<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 라이브커머스 모델 
 */
class broadcastmodel extends CI_Model
{ 
	public function __construct(){
		// 라이브커머스 설정
		$this->cfg_broadcast = config_load('broadcast');
		// 방송 상태 txt 변환
		$this->cfg_status = array(
			'create' => '방송 예약',
			'live' => '방송 중',
			'end' => '방송 종료',
			'cancel' => '방송 취소',
			'delete' => '방송 삭제'
		);

		// 방송 연결 txt 변환
		$this->cfg_disconnect = array(
			'0' => '연결',
			'1' => '중지'
		);
	}
    /**
     * 방송 편성 스케줄은 가져온다.
     * @param array $params
     * @return array
     */
    public function getSch($params = array())
    {
		// 검색어 관련 subquery
		if($params['search_text']) {
			if(in_array($params['search_field'], array('all','goods_name'))) {
				$searchquery = $this->db->select("bs_seq")->from("fm_goods go")
				->join("fm_broadcast_goods bsgoods", "goods_seq")
				->like("go.goods_name",$params['search_text'])
				->group_by("go.goods_seq")->get_compiled_select();
			} else if(in_array($params['search_field'], array('goods_seq'))) {
				$searchquery = $this->db->select("bs_seq")->from("fm_broadcast_goods bsgoods")
				->where("bsgoods.goods_seq",$params['search_text'])
				->get_compiled_select();
			}
		}

		// 카테고리 관련 subquery
		if($params['category1'] || $params['category2'] || $params['category3'] || $params['category4'] ) {
			if( $params['category4'] ){ 
				$sc_category = $params['category4'];
			} else if( $params['category3'] ){
				$sc_category = $params['category3'];
			} else if( $params['category2'] ){ 
				$sc_category = $params['category2'];
			} else if( $params['category1'] ){
				$sc_category = $params['category1'];
			}
						
			$categoryquery = $this->db->select("bs_seq")->from("fm_broadcast_goods bsgoods")
			->join("fm_category_link cl", "goods_seq")->where("cl.category_code", $sc_category);

			if($params['goods_category']) {
				$categoryquery->where('cl.link','1');
			}
			$categoryquery = $categoryquery->get_compiled_select();
		} else if( $params['goods_category_no'] ){
			$categoryquery = $this->db->select("bs_seq")->from("fm_broadcast_goods bsgoods")
			->join("fm_category_link cl", "goods_seq", "left")->where("cl.category_code IS NULL", NULL, FALSE)->get_compiled_select();
		}

		// 실제 본 쿼리 start
        $query = $this->db->select("SQL_CALC_FOUND_ROWS *, (visitors+vodvisitors) as sumvisitors, (views+vodviews) as sumviews", FALSE)->from("fm_broadcast b");

		$date_gb = $params['date_gb'] ? $params['date_gb'] : 'start_date';

        if( $params['sdate'] && $params['edate'] ) {
            $query->where("b.$date_gb >= '{$params['sdate']} 00:00:00'", null, false);
			$query->where("b.$date_gb <= '{$params['edate']} 23:59:59'", null, false);
		} else if( $params['sdate'] ) {
			$query->where("b.$date_gb >= '{$params['sdate']} 00:00:00'", null, false);
		} else if( $params['edate'] ) {
			$query->where("b.$date_gb <= '{$params['edate']} 23:59:59'", null, false);
		}

		// status 없으면 기본 삭제외 모든 상태 조회
		if(empty($params['status'])) {
			$params['status'] = array('create','live','end','cancel');
		}
		if(!empty($params['select_status'])) {
            if($params['select_status'] == 'vod') {
                $query->where_in('b.status', array('end'));
            } else {
                $query->where_in('b.status', array('create','live'));
            }
		} else if(!empty($params['status'])) {
            if(is_array($params['status'])) {
                $query->where_in('b.status', $params['status']);
            } else {
                $query->where('b.status', $params['status']);
            }
		}
		

        if(!empty($params['bs_seq'])) {
            if(is_array($params['bs_seq'])) {
                $query->where_in('b.bs_seq', $params['bs_seq']);
            } else {
                $query->where('b.bs_seq', $params['bs_seq']);
            }
		}

		if( $categoryquery ){
			$query->where_in('b.bs_seq', $categoryquery, false);
		}

		if($params['search_text']) {
			if($params['search_field'] == 'all') {
				$query->group_start();
				$query->where_in('b.bs_seq', $searchquery, false);
				$query->or_like("b.title",$params['search_text']);
				$query->group_end();
			} else if($params['search_field'] == 'title') {
				$query->like("b.title",$params['search_text']);
			} else if(in_array($params['search_field'], array('goods_name','goods_seq'))) {
				$query->where_in('b.bs_seq', $searchquery, false);
			}
		}

		if($params['is_vod_key']) {
			$query->where("vod_key IS NOT NULL", NULL, FALSE);
		}

		if($params['is_save']) {
			$query->where("is_save", "1");
		}

		if($params['is_live']) {
			$query->where("(status='live' or (status='create' and start_date >= '".date("Y-m-d H:i:s")."'))");
		}

		if($params['display']) {
			$query->where('b.display', $params['display']);
		}
		$sort =  (!empty($params['sort']) && $params['sort'] != 'null') ? $params['sort'] : 'desc';
		$orderby = $params['orderby'] ? $params['orderby']." ".$sort : 'b.bs_seq '.$sort;

		if($params['mode'] == 'goods_view') {
			$query->order_by("FIELD(status, 'live', 'create')");
		}

		$query->order_by($orderby);
		if($params['perpage']) {
			$query->limit($params['perpage'], $params['page']); 
		}
		$query = $query->get();
        return $query->result_array();
	}

    /**
     * 검색된 result 의 count
     * @return int
     */

	public function getSchCount() {
		$query = $this->db->select("FOUND_ROWS() as COUNT", FALSE)->get()->row_array();
		return $query['COUNT'];
	}
	
    /**
     * admin 에서 총 방송 개수 노출 시 사용
     * @return int
     */

	public function getSchTotal($is_save)
    {
		
        $query = $this->db->select("count(*) as CNT")
		->from("fm_broadcast b");

		// status 없으면 기본 삭제외 모든 상태 조회
		$params['status'] = array('create','live','end','cancel');
        if(!empty($params['status'])) {
			$query->where_in('b.status', $params['status']);
		}
		if($is_save) {
			$query->where("is_save", "1");
		}
		
		$query = $query->get();
		$query = $query->row_array();
        return $query['CNT'];
	}
	
	public function getSchEach($bs_seq) 
	{
		$query = $this->db->select("*")->from("fm_broadcast b");
		$query->where("bs_seq", $bs_seq);
		$query = $query->get();
		$query = $query->row_array();
		return $query;
	}
	
    /**
     * 방송 편성 스케쥴의 연관 상품을 가져온다.
     * @param array $bs_seqs
     * @return array
     */
    public function getBroadcastGoods($bs_seqs = array(), $where = null, $addFields = null)
    {
        if(empty($bs_seqs) || count($bs_seqs) < 1) {
            return array();
        }
        
		$fields = "bg.*, g.goods_name, g.default_price, g.default_consumer_price";
        if(!empty($addFields)) {
            $fields .= ",". $addFields;
        }
        $query = $this->db->select($fields)
        ->from('fm_broadcast_goods bg')
        ->join("fm_goods g", "goods_seq")
        ->where_in('bg.bs_seq', $bs_seqs);
        
        if(count($where)>0) {
            foreach($where as $whereField => $whereValue) {
                $query = $query->where($whereField, $whereValue);
            }
        }
        
        $query = $query->order_by('bg.bg_seq');
        $query = $query->get();
        return $query->result_array();
    }
    
    /**
     * 방송시간이 겹치는 방송 중에 상품이 겹치는 건을 반환한다. 
     * @param int $goods_seq
     * @param string $star_time
     * @param string $end_time
     * @param int $excBsSeq
     * @return array
     */
    public function getDuplGoods($goods_seq, $start_time, $end_time, $excBsSeq = null)
    {
        $query = $this->db->select("bs.bs_seq")
        ->from("fm_broadcast bs")
        ->join("fm_broadcast_goods bg", "bs_seq")
        ->where("bg.goods_seq", $goods_seq)
        ->where_in('bs.status', array('schedule', 'standby', 'onair', 'cancel'));
        
        if(!empty($excBsSeq)) {
            $query = $query->where("bs.bs_seq <> ", $excBsSeq);
        }
        
        $query = $query->where("bs.start_time <=", $end_time)
        ->where("bs.end_time >=", $start_time)
        ->get();
        
        $result = $query->result_array();
        $seqs = array();
        if(count($result)>0) {
            foreach($result as $row) {
                $seqs[] = $row['bs_seq'];
            }
        }
        return $seqs;
    }
	
	
	/**
     * 해당 방송의 연결상태를 변경한다.
     * @param int $bs_seq : 편성표 번호
     * @param string $status : ['0', '1']
     */
    public function setBroadcastDisconnect($bs_seq, $disconnected)
    {
        return $this->db->where("bs_seq", $bs_seq)->update("fm_broadcast", array('disconnected' => $disconnected));
	}


    /**
     * 해당 방송의 상태를 변경한다.
     * @param int $bs_seq : 편성표 번호
     * @param string $status : ['create', 'delete', 'live', 'end', 'cancel']
     */
    public function setBroadcastStatus($bs_seq, $status)
    {
        if(!in_array($status, array_keys($this->broadcastmodel->cfg_status))) {
            return false;
		}
		if(!is_array($bs_seq)) {
			$bs_seq = array($bs_seq);
		}
        
        return $this->db->where_in("bs_seq", $bs_seq)->update("fm_broadcast", array('status' => $status));
	}

    /**
     * 해당 방송의 시간을 변경한다.
     * @param int $bs_seq : 편성표 번호
     * @param string $timeField : ['real_start_date', 'real_end_date']
     */
    public function setBroadcastDatetime($bs_seq, $timeField)
    {
        return $this->db->where("bs_seq", $bs_seq)->where($timeField." is null")->update("fm_broadcast", array($timeField => date("Y-m-d H:i:s")));
	}

    /**
     * 해당 방송의 노출 상태를 변경한다.
     * @param int $bs_seq : 편성표 번호
     * @param string $display : ['on','off']
     */
    public function setBroadcastDisplay($bs_seq, $display)
    {
        if(!in_array($display, array('on','off'))) {
            return false;
        }
        
        return $this->db->where("bs_seq", $bs_seq)->update("fm_broadcast", array('display' => $display));
    }
    
    /**
     * 채널 URL을 변경한다.
     * @param int $bs_seq
     * @param string $liveUrl
     */
    public function setStreamKey($bs_seq, $streamKey, $streamServer)
    {
        return $this->db->where("bs_seq", $bs_seq)->update("fm_broadcast", array('stream_key' => $streamKey,'stream_server'=>$streamServer));
    }
    
    /**
     * 방송 편성표 상품을 삭제한다.
     * @param int $bsSeq
     * @return boolean
     */
    public function deleteBroadcastGoods($bsSeq)
    {
        return $this->db->delete('fm_broadcast_goods', array('bs_seq'=>$bsSeq));
    }
    
    /**
     * 방송 편성표를 삭제한다.
	 * 생성 상태에서는 바로 삭제 / 추후 생성 상태가 아닐때에는 status='delete' 로 업데이트 list 에 안보임
     * @param int $bsSeq
     * @return boolean
     */
    public function deleteBroadcast($bsSeq)
    {
        return $this->db->delete('fm_broadcast', array('bs_seq'=>$bsSeq));
    }
    
    
	/**
	 * 방송 편성표를 등록한다.
	 * @param array $params
	 * @return boolean
	 */
	 public function insertBroadcast($params = array())
	 {
		$filter_params = filter_keys($params, $this->db->list_fields('fm_broadcast'));
		$result = $this->db->insert('fm_broadcast', $filter_params);
		if($result !== true) {
		    return false;
		}
		return $this->db->insert_id();
	 }
	 
	 /**
	  * 방송 편성표 상품을 등록한다.
	  * @param array $params
	  * @param int $bsSeq
	  */
	 public function insertBroadcastGoods($params, $bsSeq) 
	 {
	     $params['bs_seq'] = $bsSeq;
	     $filter_params = filter_keys($params, $this->db->list_fields('fm_broadcast_goods'));
	     $result = $this->db->insert('fm_broadcast_goods', $filter_params);
	     if($result !== true) {
	         return false;
	     }
	     return $this->db->insert_id();
	 }
	 
	 /**
	  * 방송 편성표를 수정한다.
	  * @param array $params
	  * @param int $bsSeq
	  * @return boolean
	  */
	 public function updateBroadcast($params, $bsSeq)
	 {
		$filter_params = filter_keys($params, $this->db->list_fields('fm_broadcast'));
		$filter_params['update_date'] = date("Y-m-d H:i:s");
	    $result = $this->db->where('bs_seq', $bsSeq)->update('fm_broadcast', $filter_params);
	    return $result;
	 }

	/**
	* vod info data (likes, view, vodviews) 만 업데이트
	* @param array $params
	* @param int $bsSeq
	* @return boolean
	*/
	public function updateBroadcastInfo($params, $bsSeq) {
		$filter_params = filter_keys($params, array('views','likes','visitors','vodviews','vodvisitors','traffics'));
		$result = $this->db->where('bs_seq', $bsSeq)->update('fm_broadcast', $filter_params);
	    return $result;
	}
    
	 /**
	  * 편성표에 연동할 상품 정보를 가져온다.
	  * @param array $goods_seqs
	  */
	 public function getGoodsList($goods_seqs)
	 {
	     $this->load->model('goodsmodel');
	     $cond['abs_goods_seq'] = $goods_seqs;
	     $cond['all_rows'] = 'Y';
	     $result = $this->goodsmodel->admin_goods_list_new($cond);
	     
		if(empty($result['record'])) {
			return array();
		}
		
		return $result['record'];
	 }

	/**
	 * 방송 > 상품 유입 저장
	 * @param array $params
	 * @return boolean
	 */
	public function updateGoodsStats($params)
	{
		if(empty($params['goods_seq']) || empty($params['bs_seq'])) {
			return;
		}
		if(empty($params['stats_date'])) {
			$params['stats_date'] = date('Y-m-d');
		}
		$params['stats_year'] = date("Y", strtotime($params['stats_date']));
		$params['stats_month'] = date("m", strtotime($params['stats_date']));
		$params['stats_day'] = date("d", strtotime($params['stats_date']));
		$params['platform'] = get_sitetype();
		$params['cnt'] = 1;

		//// insert or update +1
		$filter_params = filter_keys($params, $this->db->list_fields('fm_broadcast_stats'));

		$sql = $this->db->insert_string('fm_broadcast_stats', $filter_params).' ON DUPLICATE KEY UPDATE cnt=cnt+1';
		$result = $this->db->query($sql);

		return $result;
	}
}