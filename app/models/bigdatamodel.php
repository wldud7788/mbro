<?php
class bigdatamodel extends CI_Model {
	public function __construct(){

		$this->load->helper('readurl');
		$this->config_system	= ($this->config_system) ? $this->config_system : config_load('system');
	}

	// 빅데이터 집합군 배열
	public function get_kind_array(){
		$kind_array	= array(	'order'		=> '구매한',
								'view'		=> '본',
								'review'	=> '리뷰를 쓴',
								'cart'		=> '장바구니에 담은',
								'wish'		=> '위시리스트에 담은',
								'like'		=> '좋아요한');
		return $kind_array;
	}

	// 빅데이터 회원 추출 ( 회원은 기준 데이터로 사용될 데이터로 limit를 주지 않는다. )
	public function get_member_seq($sc){
		$param['shopSno']		= $this->config_system['shopSno'];
		$param['month']			= $sc['src_month'];
		$param['kind']			= $sc['src_kind'];
		$param['goods_seq']		= $sc['goods_seq'];

		$url		= $this->config_system['statistics_url'];
		$url_arr	= parse_url($url);
		if	($url_arr['host']){
			$url		= 'http://' . $url_arr['host'] . '/get_members.php';
			$data		= readurl($url, $param, false, 1);
			if	(!$data)	return false;
			$result	= explode(',', $data);

			return $result;
		}else{
			return false;
		}
	}

	// 빅데이터 상품 추출
	public function get_goods_seq($sc, $limit = ''){

		$param['shopSno']		= $this->config_system['shopSno'];
		$param['limit']			= $limit;
		$param['month']			= $sc['src_month'];
		$param['kind']			= $sc['src_kind'];
		$param['members']		= $sc['members'];
		for ($i = 1; $i <= 4; $i++)
			if	($sc['category'.$i])
				$category_code	= $sc['category'.$i];
		for ($i = 1; $i <= 4; $i++)
			if	($sc['brands'.$i])
				$brand_code	= $sc['brands'.$i];
		for ($i = 1; $i <= 4; $i++)
			if	($sc['location'.$i])
				$location_code	= $sc['location'.$i];

		$param['category_code']	= $category_code;
		$param['brand_code']	= $brand_code;
		$param['location_code']	= $location_code;

		$cfg_bigdata[$param['kind']] = config_load('bigdata_'. $param['kind']);
		$param['except_goods'] = $cfg_bigdata[$param['kind']]['except_goods'];

		$url		= $this->config_system['statistics_url'];
		$url_arr	= parse_url($url);
		if	($url_arr['host']){
			$url		= 'http://' . $url_arr['host'] . '/get_goods.php';
			$data	= readurl($url, $param, false, 1);
			if	(!$data)	return false;
			$result	= explode(',', $data);

			return $result;
		}else{
			return false;
		}
	}

	public function get_bigdata_goods_display($goods_seq,$kind,$criteria = null){

		$this->load->model('goodsdisplay');
		$this->load->model('goodsmodel');
		if	($kind == 'catalog'){
			$cfg_bigdata = config_load('bigdata_criteria');
			$condition = $cfg_bigdata['condition'];
		}else{
			$condition = $criteria;
		}

		if	(!$condition) return;

		$sc['bigdata'] = 1;
		$sc['goods_seq_exclude'] = $goods_seq;
		$sc = $this->goodsdisplay->auto_select_condition($condition, $sc);
		foreach($sc as $key => $val){
			$param = array();
			$param[$key] = $val;

			$kind_str = 'bigdata';
			$platform = 'pc';
			if ($this->mobileMode && $this->realMobileSkinVersion > 2){
				$kind_str = 'bigdata_mobile';
				$platform	= 'mobile';
			}
			
			// 반응형일 경우 반응형 설정 가져옴
			if($this->operation_type == 'light'){
				$platform	= 'responsive';
			}

			$this->goodsmodel->get_goods_bigdata_display_seq();

			if	(!$this->bigdata_display)
				$this->bigdata_display	= $this->goodsdisplay->get_display_type($kind_str, $platform);

			// 모바일 환경의 디스플레이 설정이 없을 때에는 pc 버전의 디스플레이 설정을 가져옴 
			if (!$this->bigdata_display || ($kind_str == 'bigdata_mobile' && $this->mobileMode && $this->bigdata_display['m_list_use'] != 'y') )
				$this->bigdata_display	= $this->goodsdisplay->get_display_type('bigdata', 'pc');

			// 반응형스킨에서 추천상품 sizeswipe 설정하여 사용하다가 전용스킨으로 변경 시 오류발생하여 강제로 lattice_a 노출되도록 처리 2019-04-19 hyem
			if( $this->operation_type != 'light' && !($this->mobileMode) && $display['style'] == 'sizeswipe' )
				$display['style'] = "lattice_a";

			$display				= $this->bigdata_display;
			$display_key			= $this->goodsdisplay->make_display_key();
			$class					= 'designGoodsBigdataDisplay';
			$designElement			= 'goodsBigdataDisplay';
			if	($display['style'] == 'rolling_h' && $this->mobileMode){
				$class								= 'designDisplay';
				$designElement						= 'display';
				$display['platform']				= 'mobile';
				$display['style']					= 'newswipe';
				// 구버전 스킨용 예외처리
				if		(!file_exists(ROOTPATH.'data/skin/'.$this->skin.'/_modules/display/goods_display_mobile_newswipe.html'))	$display['style']	= 'lattice_a';
				if	(!$display['navigation_paging_style'])
					$display['navigation_paging_style']	= 'paging_style_1';
			}
			if($this->mobileMode && $display['platform']=='mobile' && ($display['style']=='newswipe' || $display['style']=='sizeswipe') ){
				$param[$key]['perpage']		= $display['count_max_swipe'];
				$count_w					= $display['count_w_swipe'];
				$display['count_h']			= $display['count_h_swipe'];
			}else{
				$count_w					= $display['count_w'];
				$display['count_h']			= 1;
			}
			
			// light 운영방식일 경우 perpage 값 수정 :: 2019-01-07 pjw
			if($this->operation_type == 'light'){
				$param[$key]['perpage'] = $display['count_r'] ? $display['count_r'] : 8;
			}

			//슬라이딩 스타일 기능 추가 2015-10-13 jhr
			$remain = '';
			if($display['style']=='rolling_h' && $display['h_rolling_type'] != 'moveSlides'){
				$remain_cnt = $display['count_w']-(count($list['record'])%$display['count_w']);
				if($remain_cnt <= 0 || $remain_cnt >= $display['count_w']) $remain_cnt = 0;
				for($r_i=0;$r_i<$remain_cnt;$r_i++) $remain .= '<div class="slide">&nbsp;</div>';
			}
			$list = $this->goodsmodel->auto_condition_goods_list($param);
			
			// light 일 경우 :: 2019-01-03 pjw
			if($this->operation_type == 'light'){
				
					$template_path		= $this->__tmp_template_path ? $this->__tmp_template_path : $this->template_path;
					$display_key		= $this->goodsdisplay->make_display_key();
					$tabRecords			= $this->goodsmodel->get_goodslist_display_light($list['record'], $display);
					$displayClass		= 'designGoodsBigdataDisplay display_'.$display['kind']; 
					$goods_image_size	= config_load('goodsImageSize');// 이미지 사이즈 로드
					$goodsImageSize		= $goods_image_size[$display['image_size']];
					
					$this->template->assign($display);
					$this->template->assign('displayClass', $displayClass);
					$this->template->assign('displayElement', 'goodsBigdataDisplay');
					$this->template->assign('display_key',$display_key);
					$this->template->assign('displayTabsList',array($list));
					$this->template->assign('goodsList',$tabRecords);
					$this->template->assign('template_path',$template_path);
					$this->template->assign('display_seq',$display['display_seq']);
					$this->template->assign('displayStyle',$display['style']);
					$this->template->assign('ajax_call',$ajax_call);
					$this->template->assign('skin',$this->skin);
					$this->template->assign('goodsImageSize', $goodsImageSize);
					$this->template->define('paging',		$this->skin."/_modules/display/display_paging.html");
					$this->template->define('goods_list',	"../design/{$display['goods_decoration_favorite_key']}.html");
					$this->template->define('tpl',			$this->skin."/_modules/display/goods_display_{$display['style']}.html");
					$goodsBigdataDisplayHTML = $this->template->fetch("tpl", '', true);

			}else{

				if	(count($list['record']) < $val['min_ea'] || count($list['record']) < 1)
					continue;

				$this->goodsdisplay->set('remain',$remain);
				$this->goodsdisplay->set('h_rolling_type',$display['h_rolling_type']);

				// design display
				$this->goodsdisplay->set('title',					$display['title']);
				$this->goodsdisplay->set('platform',				$display['platform']);
				$this->goodsdisplay->set('style',					$display['style']);
				$this->goodsdisplay->set('perpage',					$perpage);
				$this->goodsdisplay->set('count_w',					$count_w);
				$this->goodsdisplay->set('count_w_lattice_b',		$count_w);
				$this->goodsdisplay->set('kind',					$display['kind']);
				$this->goodsdisplay->set('navigation_paging_style',	$display['navigation_paging_style']);
				$this->goodsdisplay->set('goods_video_type',		$display['goods_video_type']);
				$this->goodsdisplay->set('videosize_w',				$display['videosize_w']);
				$this->goodsdisplay->set('videosize_h',				$display['videosize_h']);
				if($perpage){
					$this->goodsdisplay->set('count_h',				ceil($perpage/$count_w));
				}else{
					$this->goodsdisplay->set('count_h',				$display['count_h']);
				}
				$this->goodsdisplay->set('image_decorations',		$display['image_decorations']);
				$this->goodsdisplay->set('image_size',				$display['image_size']);
				$this->goodsdisplay->set('text_align',				$display['text_align']);
				$this->goodsdisplay->set('info_settings',			$display['info_settings']);
				$this->goodsdisplay->set('display_key',				$display_key);
				$this->goodsdisplay->set('displayGoodsList',		$list['record']);
				$this->goodsdisplay->set('displayTabsList',			array($list));
				$this->goodsdisplay->set('APP_USE',					$this->__APP_USE__);
				$this->goodsdisplay->set('tab_design_type',			$display['tab_design_type']);
				$this->goodsdisplay->set('is_bigdata_display',		'y');
				$this->goodsdisplay->set('m_list_use',				$display['m_list_use']);
				$this->goodsdisplay->set('mobile_h',				$display['mobile_h']);
				$this->goodsdisplay->set('img_optimize',			$display['img_opt_lattice_a']);
				$this->goodsdisplay->set('img_padding',				$display['img_padding_lattice_a']);

				$goodsBigdataDisplayHTML	= '';
				if($display['platform']=='mobile' && $display['style']=='newswipe'){
					$goodsBigdataDisplayHTML	= '<script type="text/javascript" src="/app/javascript/plugin/custom-mobile-pagination.js"></script>';
				}
				$goodsBigdataDisplayHTML		.= '<div id="'.$display_key.'" class="'.$class.'" designElement="'.$designElement.'" templatePath="'.$template_path.'" displaySeq="'.$display['display_seq'].'" perpage="'.$perpage.'" displayStyle="'.$display['style'].'">';
				$goodsBigdataDisplayHTML		.= $this->goodsdisplay->print_(true);
				$goodsBigdataDisplayHTML		.= '</div>';
			}

			$key = $key == 'fblike' ? 'like' : $key;
			$ret[$key]['textStr'] = $val['display_title'];
			$ret[$key]['display'] = $goodsBigdataDisplayHTML;
		}

		return $ret;
	}

	// 현재 상품 정보에서 체크
	public function chk_goods_seq($goods_seq, $sc){
		if	(is_array($goods_seq) && count($goods_seq) > 0){
			$sql	= "select goods_seq from fm_goods where goods_seq in ('".implode("', '", $goods_seq)."') ";

			// 상태검색
			if	(is_array($sc['goods_status']) && count($sc['goods_status']) > 0){
				$sql	.= " and goods_status in ('".implode("', '", $sc['goods_status'])."') ";
			}elseif	($sc['goods_status']){
				$sql	.= " and goods_status = '".$sc['goods_status']."' ";
			}

			// 노출여부검색
			if	(is_array($sc['goods_view']) && count($sc['goods_view']) > 0){
				$sql	.= " and goods_view in ('".implode("', '", $sc['goods_view'])."') ";
			}elseif	($sc['goods_view']){
				$sql	.= " and goods_view = '".$sc['goods_view']."' ";
			}

			$query	= $this->db->query($sql);
			$result	= $query->result_array();
			if	($result)foreach($result as $k => $goods){
				$goods_arr[]	= $goods['goods_seq'];
			}

			// 기존 배열과 비교
			foreach($goods_seq as $k => $seq){
				if	(in_array($seq, $goods_arr))	$return[]	= $seq;
			}

			return $return;
		}else{
			return array();
		}
	}

	public function get_kind_display_seq($kind = 'bigdata'){
		$query = $this->db->query("select display_seq from fm_design_display where kind = ?",$kind);
		$result = $query->row_array();
		return $result['display_seq'];
	}
}

/* End of file bigdatamodel.php */
/* Location: ./app/models/bigdatamodel.php */