<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 라이브커머스 모델 
 */
class broadcastdisplay extends CI_Model
{ 
	var $styles = array();

	public function __construct(){
		$this->styles['pc'] = array(
			'full'		=>	array('name'=>'단일형','count_f'=>3),
			'rolling'		=>	array('name'=>'수평롤링형','count_s'=>5),
			'lattice_a'			=>	array('name'=>'격자형','count_w'=>2, 'count_h'=>3),
		);
		$this->styles['mobile'] = array(
			'full'		=>	array('name'=>'단일형','count_f'=>3),
			'slide'		=>	array('name'=>'슬라이드형(크기고정)','count_s'=>5),
			'lattice_r'		=>	array('name'=>'격자형(반응형)','count_r'=>5)
		);
	}

	/**
	 * 디스플레이를 검색
	 * @param array $params
	 * @return array
	 */
	public function getDisplay($params = array()) {
		$query = $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE)->from("fm_design_broadcast d");

		if(!empty($params['display_seq'])) {
            if(is_array($params['display_seq'])) {
                $query->where_in('d.display_seq', $params['display_seq']);
            } else {
                $query->where('d.display_seq', $params['display_seq']);
            }
		}

		if($params['platform']) {
			$query->where("platform", $params['platform']);
		}
		$query->order_by("display_seq desc");
		$query = $query->get();
        return $query->result_array();
	}

	/**
	 * 디스플레이 데이터 1개 추출
	 */
	public function getDisplayData($display_seq) {
		$query = $this->db->from("fm_design_broadcast d");
		$query->where('display_seq', $display_seq);
		$query = $query->get();
		return $query->row_array();
	}

	function get_styles($platform = 'pc'){
		if($platform == 'pc') {
			$styles = $this->styles['pc'];
		} else {
			$styles = $this->styles['mobile'];
		}

		return $styles;
	}

	function makeDisplayKey(){
		$this->display_key = "designBroadcast_".uniqid();
		return $this->display_key;
	}

    /**
     * 검색된 result 의 count
     * @return int
     */

	public function getDisplayCount() {
		$query = $this->db->select("FOUND_ROWS() as COUNT", FALSE)->get()->row_array();
		return $query['COUNT'];
	}

	/**
	 * 디스플레이를 등록
	 * @param array $params
	 * @return boolean
	 */
	public function insertBroadcast($params = array())
	{
	   $filter_params = filter_keys($params, $this->db->list_fields('fm_design_broadcast'));
	   $filter_params['regist_date'] = date("Y-m-d H:i:s");
	   $result = $this->db->insert('fm_design_broadcast', $filter_params);
	   if($result !== true) {
		   return false;
	   }
	   return $this->db->insert_id();
	}

	 /**
	  * 디스플레이를 수정.
	  * @param array $params
	  * @param int $displaySeq
	  * @return boolean
	  */
	public function updateBroadcast($params, $displaySeq)
	{
		if($displaySeq < 1) return false;
		$filter_params = filter_keys($params, $this->db->list_fields('fm_design_broadcast'));
		$filter_params['update_date'] = date("Y-m-d H:i:s");
		$result = $this->db->where('display_seq', $displaySeq)->update('fm_design_broadcast', $filter_params);
		return $result;
	}

	 /**
	* 디스플레이를 삭제.
	*/
	public function deleteBroadcast($displaySeqs)
	{
		if(!is_array($displaySeqs)) {
			$displaySeqs = array($displaySeqs);
		}

		return $this->db->where_in('display_seq', $displaySeqs)->delete('fm_design_broadcast');
	}

	/**
	 * 직접 선정인 경우 아이템 삭제
	 */
	public function deleteBroadcastItem($displaySeqs) {
		return $this->db->where_in('display_seq', $displaySeqs)->delete('fm_design_broadcast_item');
	}

	/**
	 * 직접 선정인 경우 아이템 등록
	 */
	public function insertBroadcastItem($bsSeq, $displaySeq) {
		$params['bs_seq'] = $bsSeq;
		$params['display_seq'] = $displaySeq;
		$result = $this->db->insert('fm_design_broadcast_item', $params);
		if($result !== true) {
			return false;
		}
		return $this->db->insert_id();
	}

	/**
	 * 직접 선정인 경우 아이템 로드
	 */
	public function getBroadcastItem($displaySeq) {
		$query = $this->db->select("SQL_CALC_FOUND_ROWS *", FALSE)->from("fm_design_broadcast_item");

		$query->where("display_seq", $displaySeq);
		$query->order_by("bc_item_seq desc");
		$query = $query->get();
		return $query->result_array();
	}

}