<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/selleradmin_base".EXT);

class event_process extends selleradmin_base {

	public function __construct() {
		parent::__construct();
		$this->load->library('validation');
		$this->load->model('designmodel');
		$this->load->model('goodssummarymodel');
	}

	public function regist(){

		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('event_act');
		if(!$auth){
			openDialogAlert($this->auth_msg,400,140,'parent','parent.location.reload();');
			exit;
		}

		$this->load->model('goodsdisplay');
		$this->load->model('eventmodel');

		$event_seq			= $_POST['event_seq'];
		$daily_event		= $_POST['daily_event'];
		$event_type			= ($_POST['event_type']) ? $_POST['event_type'] : 'multi';
		$tpl_path			= '';
		$start_time			= str_pad($_POST['start_hour'], 2, '0', STR_PAD_LEFT) . ':00:00';
		$end_time			= str_pad($_POST['end_hour'], 2, '0', STR_PAD_LEFT) . ':59:59';

		$app_start_min_time = ($event_type == 'solo') ? str_pad($_POST['app_start_minute'], 2, '0', STR_PAD_LEFT) : "00";
		$app_end_min_time	= ($event_type == 'solo') ? str_pad($_POST['app_end_minute'], 2, '0', STR_PAD_LEFT) : "59";
		$app_start_time		= str_pad($_POST['app_start_hour'], 2, '0', STR_PAD_LEFT) . $app_start_min_time;
		$app_end_time		= str_pad($_POST['app_end_hour'], 2, '0', STR_PAD_LEFT) . $app_end_min_time;

		if($_POST['week'])
			$app_week	= implode('', $_POST['week']);

		if($event_type == 'solo'){
			// 단독 이벤트 상품 체크
			if	(count($_POST['choice_goods_1']) != 1){
				openDialogAlert("단독 이벤트는 1개의 상품을 선택해야 합니다.",400,150, 'parent','');
				exit;
			}

			// 단독 이벤트 중복 체크
			$param['event_seq']		= $event_seq;
			$param['start_date']	= $_POST['start_date'] . ' ' . $start_time;
			$param['end_date']		= $_POST['end_date'] . ' ' . $end_time;
			$param['goods_seq']		= $_POST['choice_goods_1'][0];
			if ($this->eventmodel->chk_solo_event_duple($param)){
				openDialogAlert("해당 상품의 다른 단독 이벤트와 기간이 중첩됩니다.",400,150, 'parent','');
				exit;
			}
		}

		$data							= array();
		$data['title']					= $_POST['title'];
		$data['display']				= ($_POST['display'] == 'n') ? 'n' : 'y';
		$data['event_type']				= $event_type;
		$data['start_date']				= $_POST['start_date'] . ' ' . $start_time;
		$data['end_date']				= $_POST['end_date'] . ' ' . $end_time;
		$data['daily_event']			= (int)$daily_event;
		$data['app_start_time']			= '';
		$data['app_end_time']			= '';
		$data['app_week']				= '';
		if	($daily_event){
			$data['app_start_time']		= $app_start_time;
			$data['app_end_time']		= $app_end_time;
			$data['app_week']			= $app_week;
		}
		$data['update_date']			= date('Y-m-d H:i:s');
		$data['skin']					= $this->workingSkin;
		$data['goods_rule']				= $_POST['goods_rule'];
		$data['goods_seq']				= ($event_type == 'solo') ? $_POST['choice_goods_1'][0] : '0';

		$title_contents					= adjustEditorImages($_POST['title_contents'], "/data/editor/");
		$data['title_contents']			= $title_contents;
		$data['bgcolor']				= $_POST['bgcolor'];
		$data['banner_view']			= $_POST['banner_view']=='y'?'y':'n';
		$data['event_view']				= $_POST['event_view']=='n'?'n':'y';
		$data['event_introduce']		= $_POST['event_introduce'];
		$data['event_introduce_color']	= $_POST['event_introduce_color'];
		$data['m_event_introduce']		= $_POST['m_event_introduce'];
		$data['m_event_introduce_color']= $_POST['m_event_introduce_color'];
		$data['use_coupon']				= ($_POST['use_coupon'])?$_POST['use_coupon']:'y';
		$data['use_coupon_shipping']	= ($_POST['use_coupon_shipping'])?$_POST['use_coupon_shipping']:'y';
		$data['use_coupon_ordersheet']	= ($_POST['use_coupon_ordersheet'])?$_POST['use_coupon_ordersheet']:'y';
		$data['use_code']				= ($_POST['use_code'])?$_POST['use_code']:'y';
		$data['use_code_shipping']		= ($_POST['use_code_shipping'])?$_POST['use_code_shipping']:'y';

		if( $event_seq ){
			$query					= $this->db->query("select * from fm_event where event_seq=?",$event_seq);
			$eventData				= $query->row_array();
			$tpl_path				= $eventData['tpl_path']?$eventData['tpl_path']:$this->_get_event_filepath();
			$data['tpl_path']		= $tpl_path;
			$this->db->where("event_seq",$event_seq);
			unset($data['event_type']);//2014-02-12이벤트분류 수정불가
			$result = $this->db->update("fm_event",$data);
		}else{
			if	($event_type == 'solo'){
				$st_num				= $_POST['event_st_num'][0] + 1;
				$data['st_num']		= $st_num;
			}
			$tpl_path				= $this->_get_event_filepath();
			$data['tpl_path']		= $tpl_path;
			$data['regist_date']	= date('Y-m-d H:i:s');
			$result					= $this->db->insert("fm_event",$data);
			$event_seq				= $this->db->insert_id();

			// 디스플레이 생성
			$display = array();
			$display['image_size']			= 'list2';
			$display['count_w']				= '5';
			$display['count_h']				= '4';
			$display['info_settings']		= '[{"kind":"goods_name", "font_decoration":"{\"color\":\"#000000\", \"bold\":\"bold\", \"underline\":\"none\"}"},{"kind":"consumer_price", "font_decoration":"{\"color\":\"#999999\", \"bold\":\"normal\", \"underline\":\"line-through\"}", "postfix":"'.$this->config_system['basic_currency'].'"},{"kind":"price", "font_decoration":"{\"color\":\"#999999\", \"bold\":\"normal\", \"underline\":\"line-through\"}", "postfix":"'.$this->config_system['basic_currency'].'"},{"kind":"sale_price", "font_decoration":"{\"color\":\"#fb7c03\", \"bold\":\"bold\", \"underline\":\"none\"}", "postfix":"'.$this->config_system['basic_currency'].'"},{"kind":"color"}]';
			$display['admin_comment']		= $_POST['title'];
			$display['regdate']				= date('Y-m-d H:i:s');
			$display						= filter_keys($display, $this->db->list_fields('fm_design_display'));
			$this->db->insert('fm_design_display', $display);
			$display_seq = $this->db->insert_id();

			$display_tab					= array();
			$display_tab['display_seq']		= $display_seq;
			$display_tab['auto_use']		= 'y';
			$display_tab['auto_criteria']	= "selectEvent={$event_seq}";
			$display_tab = filter_keys($display_tab, $this->db->list_fields('fm_design_display_tab'));
			$this->db->insert('fm_design_display_tab ', $display_tab);

			$this->db->where("event_seq",$event_seq);
			$result = $this->db->update("fm_event",array('display_seq'=>$display_seq));
		}

		// 배경이미지 저장
		if(preg_match("/^\/?data\/tmp/i",$_POST['banner_filename'])){
			if(!is_dir(ROOTPATH.'data/event')){
				@mkdir(ROOTPATH.'data/event');
				@chmod(ROOTPATH.'data/event',0777);
			}
			$ext = explode(".",$_POST['banner_filename']);
			$ext = $ext[count($ext)-1];
			$banner_filename = "event_banner_".$event_seq.".{$ext}";
			$new_path = "data/event/{$banner_filename}";
			copy(ROOTPATH.$_POST['banner_filename'],ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
		}else{
			$banner_filename = $_POST['banner_filename'];
		}

		// PC 이벤트 베너
		if(preg_match("/^\/?data\/tmp/i",$_POST['event_banner'])){
			if(!is_dir(ROOTPATH.'data/event')){
				@mkdir(ROOTPATH.'data/event');
				@chmod(ROOTPATH.'data/event',0777);
			}
			$ext = explode(".",$_POST['event_banner']);
			$ext = $ext[count($ext)-1];
			$event_banner = "event_view_banner_".$event_seq.".{$ext}";
			$new_path = "data/event/{$event_banner}";
			copy(ROOTPATH.$_POST['event_banner'],ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
		}else{
			$event_banner = $_POST['event_banner'];
		}

		// 모바일 이벤트 베너
		if(preg_match("/^\/?data\/tmp/i",$_POST['m_event_banner'])){
			if(!is_dir(ROOTPATH.'data/event')){
				@mkdir(ROOTPATH.'data/event');
				@chmod(ROOTPATH.'data/event',0777);
			}
			$ext = explode(".",$_POST['m_event_banner']);
			$ext = $ext[count($ext)-1];
			$m_event_banner = "m_event_view_banner_".$event_seq.".{$ext}";
			$new_path = "data/event/{$m_event_banner}";
			copy(ROOTPATH.$_POST['m_event_banner'],ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
		}else{
			$m_event_banner = $_POST['m_event_banner'];
		}

		$this->db->where("event_seq",$event_seq);
		$result = $this->db->update("fm_event",array('banner_filename'=>$banner_filename, 'event_banner'=>$event_banner, 'm_event_banner'=>$m_event_banner));

		/* 이벤트 선정상품,카테고리/주문통계 저장 초기화 */
		$arr_delete = array('event_seq'=>$event_seq);
		$this->db->delete('fm_event_benefits',$arr_delete);
		$this->db->delete('fm_event_choice',$arr_delete);
		$this->db->delete('fm_event_order',$arr_delete);

		$insert_benefits['event_seq']	= $event_seq;
		$insert_benefits['regist_date'] = date('Y-m-d H:i:s');

		foreach($_POST['event_sale'] as $benefits_key => $event_sale){

			$benefits_num							= $benefits_key + 1;
			$event_benefits_seq						= $event_seq.'_'.$benefits_num;
			$insert_benefits['target_sale']			= (int) $_POST['target_sale'][$benefits_key];
			$insert_benefits['event_sale']			= get_cutting_price($event_sale);
			$insert_benefits['event_benefits_seq']	= $event_benefits_seq;
			$insert_benefits['event_reserve']		= get_cutting_price($_POST['event_reserve'][$benefits_key]);

			$reserve_limit = "";
			if($_POST['reserve_select'][$benefits_key]){
				if($_POST['reserve_select'][$benefits_key]=="year"){
					$reserve_limit = date("Y-m-d", mktime(0,0,0,12, 31, date("Y")+$_POST['reserve_year'][$benefits_key]));//$_POST['reserve_year'][$benefits_key]."-12-31";
				}else if($_POST['reserve_select'][$benefits_key]=="direct"){
					$reserve_limit = date("Y-m-d", mktime(0,0,0,date("m")+$_POST['reserve_direct'][$benefits_key], date("d"), date("Y")));
				}
			}
			$insert_benefits['reserve_limit']	= $reserve_limit;
			$insert_benefits['event_point']		= (int) $_POST['event_point'][$benefits_key];
			$point_limit = "";
			if($_POST['point_select'][$benefits_key]){
				if($_POST['point_select'][$benefits_key]=="year"){
					$point_limit = date("Y-m-d", mktime(0,0,0,12, 31, date("Y")+$_POST['point_year'][$benefits_key]));//$_POST['point_year'][$benefits_key]."-12-31";
				}else if($_POST['point_select'][$benefits_key]=="direct"){
					$point_limit = date("Y-m-d", mktime(0,0,0,date("m")+$_POST['point_direct'][$benefits_key], date("d"), date("Y")));
				}
			}

			/* 이벤트 상품의 입점사 수수료 조정 추가 leewh 2014-06-13 */
			$saller_rate_type = $_POST['saller_rate_type'];
			if ($saller_rate_type) {
				$insert_benefits['saller_rate_type']		= $saller_rate_type;
				if($saller_rate_type!=0) {
					unset($saller_rate);
					if ($saller_rate_type==1) {
						$saller_rate = $_POST['saller_rate_0'];
					}
					if ($saller_rate_type==2) {
						$saller_rate = $_POST['saller_rate_1'];
						if ($_POST['saller_rate_num']==1) {
							$saller_rate = "-".$saller_rate;
						}
					}
					$insert_benefits['saller_rate']		= $saller_rate;
				}
			}

			$insert_benefits['point_limit']			= $point_limit;
			$insert_benefits['reserve_select']		= $_POST['reserve_select'][$benefits_key];
			$insert_benefits['reserve_year']		= $_POST['reserve_year'][$benefits_key];
			$insert_benefits['reserve_direct']		= $_POST['reserve_direct'][$benefits_key];
			$insert_benefits['point_select']		= $_POST['point_select'][$benefits_key];
			$insert_benefits['point_year']			= $_POST['point_year'][$benefits_key];
			$insert_benefits['point_direct']		= $_POST['point_direct'][$benefits_key];
			$this->db->insert("fm_event_benefits",$insert_benefits);

			/* 카테고리 상품추출 오류로 추가 @nsg 2015-12-28 */
			$this->db->where("display_seq",$display_seq);
			$result = $this->db->update("fm_design_display_tab",array('auto_criteria'=>"selectEvent={$event_seq},selectEventBenefits={$event_benefits_seq}"));

			unset($insert_choice);
			$insert_choice['event_seq'] = $event_seq;
			$insert_choice['event_benefits_seq'] = $event_benefits_seq;
			if( $_POST['category_code'][$benefits_key] ) foreach($_POST['category_code'][$benefits_key] as $category_code){
				$insert_choice['choice_type'] = 'category';
				$insert_choice['category_code'] = $category_code;
				$accept['category'][]			= $category_code;
				if(in_array($data['goods_rule'],array('category'))) $this->db->insert("fm_event_choice",$insert_choice);
			}

			unset($insert_choice);
			$insert_choice['event_seq'] = $event_seq;
			$insert_choice['event_benefits_seq'] = $event_benefits_seq;
			if( $_POST['except_category_code'][$benefits_key] ) foreach($_POST['except_category_code'][$benefits_key] as $category_code){
				$insert_choice['choice_type'] = 'except_category';
				$insert_choice['category_code'] = $category_code;
				$except['category'][]			= $category_code;
				if(in_array($data['goods_rule'],array('all','category'))) $this->db->insert("fm_event_choice",$insert_choice);
			}

			unset($insert_choice);
			$insert_choice['event_seq'] = $event_seq;
			$insert_choice['event_benefits_seq'] = $event_benefits_seq;
			if( $_POST['choice_goods_'.$benefits_num] ) foreach($_POST['choice_goods_'.$benefits_num] as $goods_seq){
				$insert_choice['choice_type'] = 'goods';
				$insert_choice['goods_seq'] = $goods_seq;
				$accept['goods'][]			= $goods_seq;
				if(in_array($data['goods_rule'],array('goods_view'))) $this->db->insert("fm_event_choice",$insert_choice);
			}

			unset($insert_choice);
			$insert_choice['event_seq'] = $event_seq;
			$insert_choice['event_benefits_seq'] = $event_benefits_seq;
			if( $_POST['except_goods_'.$benefits_num] ) foreach($_POST['except_goods_'.$benefits_num] as $goods_seq){
				$insert_choice['choice_type'] = 'except_goods';
				$insert_choice['goods_seq'] = $goods_seq;
				$except['goods'][]			= $goods_seq;
				if(in_array($data['goods_rule'],array('all','category'))) $this->db->insert("fm_event_choice",$insert_choice);
			}
		}

		/* 파일생성 : PC 작업용 스킨 */
		$this->load->helper('file');
		$this->load->helper('design');
		$saveData = array(
			'tpl_desc'		=> $data['title'],
			'tpl_page'		=> 1,
			'regist_date'	=> date('Y-m-d H:i:s'),
		);

		$skin_list = $this->designmodel->get_all_skin_list();
		foreach($skin_list as $skin_info){
			$fullpath = ROOTPATH.'data/skin/'.$skin_info['skin'].'/'.$tpl_path;
			if( $skin_info['skin'] && is_dir(ROOTPATH.'data/skin/'.$skin_info['skin'].'/') ) {
				if(!$tpl_path || ($tpl_path && !file_exists($fullpath))){
					if(write_file($fullpath, '')){
						if($display_seq) file_put_contents($fullpath,"{=showDesignDisplay({$display_seq})}");
						layout_config_save($skin_info['skin'],$tpl_path,$saveData);
					}
				}
				@chmod($fullpath,0777);
			}
		}

		// 해당 상품 단독 이벤트 차수 증가
		if	($event_type == 'solo' && $goods_seq && $st_num > 0){
			$this->eventmodel->update_solo_event_stnum($goods_seq, $st_num);
			$accept	= array($goods_seq);
			$except	= array();
		}		

		//$this->goodssummarymodel->set_event_price($accept, $except);

		if($result){
			/*######################## 16.10.27 : */
			$catalogPage = "";
			if($_POST['query_string']) $catalogPage = "?".$_POST['query_string'];
			$callback = "parent.document.location = '/selleradmin/event/catalog{$catalogPage}';";
			/*######################## 16.10.27 : */
			openDialogAlert("이벤트가 저장 되었습니다.",400,140,'parent',$callback);
		}
	}

	public function gift_delete(){

		$event_seq = $_GET['event_seq'];

		$query = $this->db->query("select * from fm_gift where gift_seq=?",$event_seq);
		$data = $query->row_array();

		if($data['banner_filename']){
			$banner_filepath = "data/event/{$data['banner_filename']}";
			@unlink($banner_filepath);
		}

		if($data['event_banner']){
			$event_banner = "data/event/{$data['event_banner']}";
			@unlink($event_banner);
		}

		if($data['m_event_banner']){
			$m_event_banner = "data/event/{$data['m_event_banner']}";
			@unlink($m_event_banner);
		}

		$result = $this->db->query("delete from fm_gift where gift_seq=?",$event_seq);
		$result = $this->db->query("delete from fm_gift_choice where gift_seq=?",$event_seq);

		$skin_list = $this->designmodel->get_all_skin_list();
		foreach($skin_list as $skin_info){
			$fullpath = ROOTPATH.'data/skin/'.$skin_info['skin'].'/'.$data['tpl_path'];
			if(file_exists($fullpath)){
				@unlink($fullpath);
			}
		}

		echo $result;
	}

	public function event_copy(){
		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('event_act');
		if(!$auth){
			openDialogAlert($this->auth_msg,400,140,'parent','parent.location.reload();');
			exit;
		}

		$event_seq = $_GET['event_seq'];

		$query = $this->db->query("select * from fm_event where event_seq=?",$event_seq);
		$data = $query->row_array();

		unset($data['event_seq']);
		unset($data['pageview']);

		$tpl_path = $this->_get_event_filepath();

		if	($data['event_type'] == 'solo'){
			$soloquery	= $this->db->query("select max(st_num) as st_num from fm_event where goods_seq=?",$data['goods_seq']);
			$maxd	= $soloquery->row_array();

			$data['st_num']	= $maxd['st_num'] + 1;
			$this->db->query("update fm_goods set event_st_num = '".$data['st_num']."' where goods_seq=?",$data['goods_seq']);

			$data['start_date']	= "";
			$data['end_date']	= "";
		}

		if($tpl_path) $data['tpl_path'] = $tpl_path;
		$data['regist_date'] = date('Y-m-d H:i:s');
		$data['update_date'] = date('Y-m-d H:i:s');

		$result = $this->db->insert("fm_event",$data);
		$new_event_seq	= $this->db->insert_id();

		// 디스플레이 생성
		$query	= $this->db->query("select * from fm_design_display where display_seq=?",$data['display_seq']);
		$data	= $query->result_array();

		if	($data){
			foreach($data as $k => $row){
				unset($row['display_seq']);
				$this->db->insert("fm_design_display",$row);
			}
		}
		$display_seq = $this->db->insert_id();

		$display_tab = array();
		$display_tab['display_seq'] = $display_seq;
		$display_tab['auto_use'] = 'y';
		$display_tab['auto_criteria'] = "selectEvent={$new_event_seq}";
		$display_tab = filter_keys($display_tab, $this->db->list_fields('fm_design_display_tab'));
		$this->db->insert('fm_design_display_tab ', $display_tab);

		$this->db->where("event_seq",$new_event_seq);
		$result = $this->db->update("fm_event",array('display_seq'=>$display_seq));

		$query	= $this->db->query("select * from fm_event_benefits where event_seq=?",$event_seq);
		$data	= $query->result_array();

		if	($data){
			foreach($data as $k => $row){
				$event_benefits_seq_old = $row['event_benefits_seq'];
				$event_sale_old = $row['event_sale'];
				unset($row);
				$benefits					= explode('_', $event_benefits_seq_old);
				$row['event_benefits_seq']	= $new_event_seq . '_' . $benefits[1];
				$row['event_seq']			= $new_event_seq;
				$row['regist_date']			= date('Y-m-d H:i:s');
				$row['event_sale']			= $event_sale_old;

				$this->db->insert("fm_event_benefits",$row);
			}
		}

		$query	= $this->db->query("select * from fm_event_choice where event_seq=?",$event_seq);
		$data	= $query->result_array();
		if	($data){
			foreach($data as $k => $row){
				unset($row['event_choice_seq']);

				$benefits					= explode('_', $row['event_benefits_seq']);
				$row['event_benefits_seq']	= $new_event_seq . '_' . $benefits[1];
				$row['event_seq']			= $new_event_seq;

				$this->db->insert("fm_event_choice",$row);
			}
		}

		$skin_list = $this->designmodel->get_all_skin_list();
		foreach($skin_list as $skin_info){
			$ori_fullpath = ROOTPATH.'data/skin/'.$skin_info['skin'].'/'.$data['tpl_path'];
			if(file_exists($ori_fullpath)){
				$fullpath = ROOTPATH.'data/skin/'.$skin_info['skin'].'/'.$tpl_path;

				if(!is_dir(dirname($fullpath)))
				{
					@mkdir(dirname($fullpath));
					@chmod(dirname($fullpath),0777);
				}

				file_put_contents($fullpath,"{=showDesignDisplay({$display_seq})}");
				@chmod($fullpath,0707);
			}
		}

		$newimgquery = $this->db->query("select * from fm_event where event_seq=?",$new_event_seq);
		$newimgdata = $newimgquery->row_array();

		// 배경이미지 저장
		$ori_banner_filename = ROOTPATH."data/event/".$newimgdata['banner_filename'];
		if(is_file($ori_banner_filename)){
			$ext = explode(".",$newimgdata['banner_filename']);
			$ext = $ext[count($ext)-1];
			$banner_filename = "event_banner_".$new_event_seq.".{$ext}";
			$new_path = ROOTPATH."data/event/{$banner_filename}";
			copy($ori_banner_filename,$new_path);
			chmod($new_path,0777);
		}else{
			$banner_filename = '';//$newimgdata['banner_filename'];
		}

		// PC 이벤트 베너
		$ori_event_banner = ROOTPATH."data/event/".$newimgdata['event_banner'];
		if(is_file($ori_event_banner)){
			$ext = explode(".",$newimgdata['event_banner']);
			$ext = $ext[count($ext)-1];
			$event_banner = "event_view_banner_".$new_event_seq.".{$ext}";
			$new_path = ROOTPATH."data/event/{$event_banner}";
			copy($ori_event_banner,$new_path);
			chmod($new_path,0777);
		}else{
			$event_banner = '';//$newimgdata['event_banner'];
		}

		// 모바일 이벤트 베너
		$ori_m_event_banner = ROOTPATH."data/event/".$newimgdata['m_event_banner'];
		if(is_file($ori_m_event_banner)){
			$ext = explode(".",$newimgdata['m_event_banner']);
			$ext = $ext[count($ext)-1];
			$m_event_banner = "m_event_view_banner_".$new_event_seq.".{$ext}";
			$new_path = ROOTPATH."data/event/{$m_event_banner}";
			copy($ori_m_event_banner,$new_path);
			chmod($new_path,0777);
		}else{
			$m_event_banner = '';//$newimgdata['m_event_banner'];
		}

		$this->db->where("event_seq",$new_event_seq);
		$result = $this->db->update("fm_event",array('banner_filename'=>$banner_filename, 'event_banner'=>$event_banner, 'm_event_banner'=>$m_event_banner));

		$callback = "parent.location.reload();";
		openDialogAlert('복사되었습니다.<br/>정보를 수정해 주세요!',400,180,'parent',$callback);
	}

	/* 새 페이지명 생성 */
	public function _get_event_filepath($filename="event"){
		$this->load->model('designmodel');

		$filenamePrefix = $filename.date('ym');
		$filepath		= "";

		if(!is_dir($eventPath))
		{
			@mkdir($eventPath);
			@chmod($eventPath,0777);
		}

		$skin_list = $this->designmodel->get_all_skin_list();

		for($i=1;$i<1000;$i++){
			$num = sprintf("%03d",$i);

			$exists = false;
			foreach($skin_list as $skin_info){
				$eventPath	= ROOTPATH.'data/skin/'.$skin_info['skin'].'/etc/';
				$filepath	= $eventPath.$filenamePrefix.$num.".html";
				if(file_exists($filepath)) $exists = true;
			}

			if(!$exists) return 'etc/'.$filenamePrefix.$num.".html";
		}
	}

	public function gift_regist(){

		$aPostParams	= $this->input->post();
		$event_seq		= $aPostParams['gift_seq'];
		$tpl_path		= '';

		$provider_info['provider_seq']	= $this->providerInfo['provider_seq'];
		if($aPostParams['provider_seq'] != $provider_info['provider_seq']){
			openDialogAlert('다른 입점사의 이벤트는 수정할 수 없습니다.',400,170,'parent');
			exit;
		}

		### [반응형스킨] 운영방식 추가 :: 2018-11-01 pjw
		$operation_type = !empty($this->config_system['operation_type']) ? $this->config_system['operation_type'] : 'heavy';
		
		### Validation
		$this->validation->set_rules('title', '이벤트명','trim|required|max_length[40]|xss_clean');
		$this->validation->set_rules('start_date', '사은품 이벤트 시작 기간','trim|required|max_length[10]|xss_clean');
		$this->validation->set_rules('end_date', '사은품 이벤트 종료 기간','trim|required|max_length[10]|xss_clean');
		if($aPostParams['gift_gb'] == 'order'){
			$this->validation->set_rules('provider_seq', '사은품 제공자', 'trim|required|xss_clean');
			$this->validation->set_rules('ship_grp_seq', '사은품의 배송그룹', 'trim|required|xss_clean');
		}

		/*
		사은품 증정 기준 validation check
		*/
		$this->validation->set_rules('gift_rule','사은품 증정 기준',"trim|required|xss_clean");
		switch($aPostParams['gift_rule']){
			case "default":		// 주문 금액(1개 세트)
				$this->validation->set_rules('defaultGift[]','증정 사은품','trim|required|numeric|xss_clean');
				$this->validation->set_rules('sprice1[]', '주문 금액 기준','trim|required|numeric|xss_clean|greater_than[0]');
			break;
			case "price":		// 주문 금액별(다중세트)
				foreach($aPostParams['sprice2'] as $i => $sprice2){

					$no 		= $i+1;
					$id 		= "price".($no)."Gift";
					$eprice2 	= $aPostParams['eprice2'][$i];
					$rules 		= 'trim|required|numeric|xss_clean|greater_than[0]';
	
					if (!isset($aPostParams[$id])) {
						$this->validation->set_rules('price1Gift['.$i.']', $no.'번째 사은품','trim|required|numeric|xss_clean');
					}
				
					if($aPostParams['gift_gb'] == "order"){
						$msg 	= $no."번째 결제 금액 기준";
					}else{
						$msg 	= $no."번째 교환 마일리지(시작)";
					}
					
					$this->validation->set_rules('sprice2['.$i.']', $msg.'(시작)','trim|required|numeric|xss_clean');
	
					if($aPostParams['gift_gb'] == "order"){
							if($sprice2 > $eprice2)	$rules .= '|less_than_equal_to['.$sprice2.']';
							$this->validation->set_rules('eprice2['.$i.']', $msg.'(종료)',$rules);
					}
				}
			break;
			case "quantity":	// 주문 금액별 사은품 수량 지정

				$this->validation->set_rules('qtyGift[]','증정 사은품','trim|required|numeric|xss_clean');

				foreach($aPostParams['sprice3'] as $i => $sprice3){

					$no 		= $i+1;
					$eprice3 	= $aPostParams['eprice3'][$i];
					$rules 		= 'trim|required|numeric|xss_clean';

					$this->validation->set_rules('sprice3['.$i.']',$no.'번째 결제 금액 기준(시작)','trim|required|numeric|xss_clean');

					if($sprice3 > $eprice3){
						$_rules_ = $rules .'|greater_than['.$sprice3.']';
					}else{
						$_rules_ = $rules .'|greater_than[0]';
					}

					$this->validation->set_rules('eprice3['.$i.']', $no.'번째 결제 금액 기준(종료)',$_rules_);
					$this->validation->set_rules('ea3['.$i.']', $no.'번째 증정 사은품 수량',$rules);
				}
			break;
		}

		if($this->validation->exec()===false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.getElementsByName('{$err['key']}')[0]) parent.document.getElementsByName('{$err['key']}')[0].focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}
		
		if($event_seq){
			$mode = "mod";
		}else{
			$mode = "new";
		}

		$data = array();
		$data['title']					= $aPostParams['title'];
		$data['start_date']				= $aPostParams['start_date'];
		$data['end_date']				= $aPostParams['end_date'];
		$data['display']				= ($aPostParams['display'] == 'n') ? 'n' : 'y';
		$data['update_date']			= date('Y-m-d H:i:s');
		$data['skin']					= $this->workingSkin;
		$data['goods_rule']				= $aPostParams['goods_rule'];
		$data['gift_rule']				= $aPostParams['gift_rule'];
		$data['provider_seq']			= $aPostParams['provider_seq'];
		$data['provider_name']			= $aPostParams['provider_name'];
		$data['goods_desc_popup']		= $aPostParams['goods_desc_popup'];
		$data['shipping_group_seq']		= $aPostParams['ship_grp_seq'];
		
		// [반응형스킨] 검색필터, 노출링크 추가 :: 2018-11-01 pjw
		$data['search_filter']			= implode(',', $aPostParams['search_filter']);
		$data['search_orderby']			= $aPostParams['search_orderby'];
		$data['search_status']			= implode(',', $aPostParams['search_status']);
		$data['goods_info_image']		= ($aPostParams['goods_info_image'])?$aPostParams['goods_info_image']:'list1';
		$data['show_link']				= $aPostParams['show_link'];
		
		// [반응형스킨] 상품정보템플릿 추가 :: 2019-05-17 pjw
		$data['goods_info_style']		= $aPostParams['goods_info_style'];
		
		// daum editor 빈 값 태그 초기화 @2017-02-23
		if (strtolower($_POST['gift_contents']) == "<p>&nbsp;</p>" || strtolower($_POST['gift_contents']) == "<p><br></p>") {
			$_POST['gift_contents']='';
		}
		
		$gift_contents	= adjustEditorImages($_POST['gift_contents'], "/data/editor/");
		$data['gift_contents']			= $gift_contents;
		$data['gift_gb']				= $aPostParams['gift_gb'];
		$data['banner_view']			= $aPostParams['banner_view']=='y'?'y':'n';
		$data['event_view']				= $aPostParams['event_view']=='n'?'n':'y';
		$data['event_introduce']		= $aPostParams['event_introduce'];
		$data['event_introduce_color']	= $aPostParams['event_introduce_color'];
		$data['m_event_introduce']		= $aPostParams['m_event_introduce'];
		$data['m_event_introduce_color']= $aPostParams['m_event_introduce_color'];

		if($event_seq){
			$query = $this->db->query("select * from fm_gift where gift_seq=?",$event_seq);
			$eventData = $query->row_array();
			$tpl_path = $eventData['tpl_path']?$eventData['tpl_path']:$this->_get_event_filepath("gift");
			$data['tpl_path']	= $tpl_path;
			$this->db->where("gift_seq",$event_seq);
			$result = $this->db->update("fm_gift",$data);
			
			$display_seq = $eventData['display_seq'];
			$m_display_seq = $eventData['m_display_seq'];
			
			if ( !$m_display_seq ) {
				// 디스플레이 생성
				$display = array();
				$display['platform']	= 'mobile';
				$display['image_size']			= 'list2';
				$display['style']	= 'newswipe';
				$display['count_w_swipe']				= '4';
				$display['count_h_swipe']				= '1';
				$display['info_settings']		= '[{"kind":"goods_name", "font_decoration":"{\"color\":\"#000000\", \"bold\":\"bold\", \"underline\":\"none\"}"},{"kind":"consumer_price", "font_decoration":"{\"color\":\"#999999\", \"bold\":\"normal\", \"underline\":\"line-through\"}", "postfix":"'.$this->config_system['basic_currency'].'"},{"kind":"price", "font_decoration":"{\"color\":\"#999999\", \"bold\":\"normal\", \"underline\":\"line-through\"}", "postfix":"'.$this->config_system['basic_currency'].'"},{"kind":"sale_price", "font_decoration":"{\"color\":\"#fb7c03\", \"bold\":\"bold\", \"underline\":\"none\"}", "postfix":"'.$this->config_system['basic_currency'].'"},{"kind":"color"}]';
				$display['admin_comment']		= $aPostParams['title'];
				$display['regdate']				= date('Y-m-d H:i:s');
				$display						= filter_keys($display, $this->db->list_fields('fm_design_display'));
				$this->db->insert('fm_design_display', $display);
				$m_display_seq = $this->db->insert_id();
				
				$display_tab					= array();
				$display_tab['display_seq']		= $display_seq;
				$display_tab['auto_use']		= 'y';
				$display_tab['auto_criteria']	= "selectEvent={$event_seq}";
				$display_tab['display_seq']		= $m_display_seq;
				$mobile_display_tab = filter_keys($display_tab, $this->db->list_fields('fm_design_display_tab'));
				$this->db->insert('fm_design_display_tab ', $mobile_display_tab);
				
				$this->db->where("gift_seq",$event_seq);
				
				$result = $this->db->update("fm_gift",array('m_display_seq'=>$m_display_seq));
			}
		}else{
			$tpl_path = $this->_get_event_filepath("gift");
			$data['tpl_path']	= $tpl_path;
			$data['regist_date'] = date('Y-m-d H:i:s');
			$result = $this->db->insert("fm_gift",$data);
			$event_seq = $this->db->insert_id();

			// 디스플레이 생성
			$display = array();
			$display['image_size'] = 'list2';
			$display['count_w'] = '5';
			$display['count_h'] = '4';
			$display['info_settings'] = '[{"kind":"goods_name", "font_decoration":"{\"color\":\"#000000\", \"bold\":\"bold\", \"underline\":\"none\"}"},{"kind":"consumer_price", "font_decoration":"{\"color\":\"#999999\", \"bold\":\"normal\", \"underline\":\"line-through\"}", "postfix":"'.$this->config_system['basic_currency'].'"},{"kind":"price", "font_decoration":"{\"color\":\"#999999\", \"bold\":\"normal\", \"underline\":\"line-through\"}", "postfix":"'.$this->config_system['basic_currency'].'"},{"kind":"sale_price", "font_decoration":"{\"color\":\"#fb7c03\", \"bold\":\"bold\", \"underline\":\"none\"}", "postfix":"'.$this->config_system['basic_currency'].'"},{"kind":"color"}]';
			$display['admin_comment'] = $aPostParams['title'];
			$display['regdate'] = date('Y-m-d H:i:s');
			$display = filter_keys($display, $this->db->list_fields('fm_design_display'));
			$this->db->insert('fm_design_display', $display);
			$display_seq = $this->db->insert_id();

			//모바일 사은품 저장
			$display['platform']	= 'mobile';
			$display['style']	= 'newswipe';
			$display['count_w_swipe']				= '4';
			$display['count_h_swipe']				= '1';
			
			$this->db->insert('fm_design_display', $display);
			$m_display_seq = $this->db->insert_id();
			//모바일 사은품 저장
			
			$display_tab = array();
			$display_tab['display_seq'] = $display_seq;
			$display_tab['auto_use'] = 'y';
			$display_tab['auto_criteria'] = "selectGift={$event_seq}";
			
			$pc_display_tab = filter_keys($display_tab, $this->db->list_fields('fm_design_display_tab'));
			$this->db->insert('fm_design_display_tab ', $pc_display_tab);
			
			$display_tab['display_seq']		= $m_display_seq;
			$mobile_display_tab = filter_keys($display_tab, $this->db->list_fields('fm_design_display_tab'));
			$this->db->insert('fm_design_display_tab ', $mobile_display_tab);

			$this->db->where("gift_seq",$event_seq);
			$result = $this->db->update("fm_gift",array('display_seq'=>$display_seq, 'm_display_seq'=>$m_display_seq));
		}

		// 배경이미지 저장
		if(preg_match("/^\/?data\/tmp/i",$aPostParams['banner_filename'])){
			if(!is_dir(ROOTPATH.'data/event')){
				@mkdir(ROOTPATH.'data/event');
				@chmod(ROOTPATH.'data/event',0777);
			}
			$ext = explode(".",$aPostParams['banner_filename']);
			$ext = $ext[count($ext)-1];
			$banner_filename = "gift_banner_".$event_seq.".{$ext}";
			$new_path = "data/event/{$banner_filename}";
			copy(ROOTPATH.$aPostParams['banner_filename'],ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
		}else{
			$banner_filename = $aPostParams['banner_filename'];
		}

		// PC 이벤트 베너
		if(preg_match("/^\/?data\/tmp/i",$aPostParams['event_banner'])){
			if(!is_dir(ROOTPATH.'data/event')){
				@mkdir(ROOTPATH.'data/event');
				@chmod(ROOTPATH.'data/event',0777);
			}
			$ext = explode(".",$aPostParams['event_banner']);
			$ext = $ext[count($ext)-1];
			$event_banner = "gift_view_banner_".$event_seq.".{$ext}";
			$new_path = "data/event/{$event_banner}";
			copy(ROOTPATH.$aPostParams['event_banner'],ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
		}else{
			$event_banner = $aPostParams['event_banner'];
		}

		// 모바일 이벤트 베너
		if(preg_match("/^\/?data\/tmp/i",$aPostParams['m_event_banner'])){
			if(!is_dir(ROOTPATH.'data/event')){
				@mkdir(ROOTPATH.'data/event');
				@chmod(ROOTPATH.'data/event',0777);
			}
			$ext = explode(".",$aPostParams['m_event_banner']);
			$ext = $ext[count($ext)-1];
			$m_event_banner = "m_gift_view_banner_".$event_seq.".{$ext}";
			$new_path = "data/event/{$m_event_banner}";
			copy(ROOTPATH.$aPostParams['m_event_banner'],ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
		}else{
			$m_event_banner = $aPostParams['m_event_banner'];
		}

		// 업데이트 데이터 빠로 뺌
		$event_data = array(
			'banner_filename'=>$banner_filename,
			'event_banner'=>$event_banner,
			'm_event_banner'=>$m_event_banner,
		);

		// [반응형스킨] 운영방식이 light일 경우 이벤트 배너 통합저장 (pc = mobile) :: 2018-11-01 pjw
		if($operation_type == 'light'){
			$event_data['m_event_banner']			= $event_banner;
			$event_data['m_event_introduce']		= $aPostParams['event_introduce'];
			$event_data['m_event_introduce_color']	= $aPostParams['event_introduce_color'];
		}
		
		$this->db->where("gift_seq",$event_seq);
		$result = $this->db->update("fm_gift", $event_data);

		/* 구매 대상 상품 */
		$arr_delete = array('gift_seq'=>$event_seq);
		$this->db->delete('fm_gift_choice',$arr_delete);
		if($aPostParams['goods_rule']=='goods'){
			$issueGoods = array_unique($aPostParams['issueGoods']);
			for($i=0;$i<count($issueGoods);$i++){
				if($issueGoods[$i]){
					// 본사 또는 선택한 입점사의 상품만 저장.
					$query		= $this->db->select('provider_seq')->get_where('fm_goods',array('goods_seq'=>$issueGoods[$i]));
					$goodsData	= $query->row_array();
					if(!serviceLimit('H_AD') || $goodsData['provider_seq'] == $aPostParams['provider_seq']){
						$result = $this->db->insert('fm_gift_choice', array('gift_seq'=>$event_seq,'goods_seq'=>$issueGoods[$i],'choice_type'=>'goods'));
					}
				}
			}
		}else if($aPostParams['goods_rule']=='category'){
			for($i=0;$i<count($aPostParams['issueCategoryCode']);$i++){
				$result = $this->db->insert('fm_gift_choice', array('gift_seq'=>$event_seq,'category_code'=>$aPostParams['issueCategoryCode'][$i],'choice_type'=>'category'));
			}
		}

		### 사은품 증정 방식
		$arr_delete = array('gift_seq'=>$event_seq);
		$this->db->delete('fm_gift_benefit',$arr_delete);
		if($aPostParams['gift_rule']=='default'){
			$arr = array_unique($aPostParams['defaultGift']);
			$gift_goods_seq = implode("|",$arr);
			// 본사 또는 선택한 입점사의 사은품만 저장.
			$query		= $this->db->select('provider_seq')->get_where('fm_goods',array('goods_seq'=>$gift_goods_seq));
			$goodsData	= $query->row_array();
			if(!serviceLimit('H_AD') || $goodsData['provider_seq'] == $aPostParams['provider_seq']){
				$iparams['gift_seq']		= $event_seq;
				$iparams['benefit_rule']	= $aPostParams['gift_rule'];
				$iparams['sprice']			= get_cutting_price($aPostParams['sprice1'][0]);
				$iparams['ea']				= 1;
				$iparams['gift_goods_seq']	= $gift_goods_seq;
				$result = $this->db->insert('fm_gift_benefit', $iparams);
			}

		}else if($aPostParams['gift_rule']=='price'){
			$iparams['gift_seq']		= $event_seq;
			$iparams['benefit_rule']	= $aPostParams['gift_rule'];
			for($i=0;$i<count($aPostParams['sprice2']);$i++){
				$id = "price".($i+1)."Gift";
				$arr = array_unique($aPostParams[$id]);
				$gift_goods_seq = implode("|",$arr);

				// 본사 또는 선택한 입점사의 사은품만 저장.
				$query		= $this->db->select('provider_seq')->get_where('fm_goods',array('goods_seq'=>$gift_goods_seq));
				$goodsData	= $query->row_array();
				if($aPostParams['goods_rule'] == "reserve" ||
					($aPostParams['goods_rule'] != "reserve" && (!serviceLimit('H_AD') || $goodsData['provider_seq'] == $aPostParams['provider_seq']))){
					$iparams['sprice']			= get_cutting_price($aPostParams['sprice2'][$i]);
					$iparams['eprice']			= get_cutting_price($aPostParams['eprice2'][$i]);
					$iparams['ea']				= 1;
				$iparams['gift_goods_seq']	= $gift_goods_seq;
				$result = $this->db->insert('fm_gift_benefit', $iparams);
			}
			}
			$iparams['gift_goods_seq']	= $gift_goods_seq;
		}else if($aPostParams['gift_rule']=='quantity'){
			$arr = array_unique($aPostParams['qtyGift']);
			$gift_goods_seq = implode("|",$arr);
			// 본사 또는 선택한 입점사의 사은품만 저장.
			$query		= $this->db->select('provider_seq')->get_where('fm_goods',array('goods_seq'=>$gift_goods_seq));
			$goodsData	= $query->row_array();
			if(!serviceLimit('H_AD') || $goodsData['provider_seq'] == $aPostParams['provider_seq']){
			$iparams['gift_seq']		= $event_seq;
			$iparams['benefit_rule']	= $aPostParams['gift_rule'];
			$iparams['gift_goods_seq']	= $gift_goods_seq;
			for($i=0;$i<count($aPostParams['sprice3']);$i++){
				$iparams['sprice']			= get_cutting_price($aPostParams['sprice3'][$i]);
				$iparams['eprice']			= get_cutting_price($aPostParams['eprice3'][$i]);
				$iparams['ea']				= $aPostParams['ea3'][$i];
				$result = $this->db->insert('fm_gift_benefit', $iparams);
			}
			}
		}else if($aPostParams['gift_rule']=='lot'){
			$arr = array_unique($aPostParams['lotGift']);
			$gift_goods_seq = implode("|",$arr);
			// 본사 또는 선택한 입점사의 사은품만 저장.
			$query		= $this->db->select('provider_seq')->get_where('fm_goods',array('goods_seq'=>$gift_goods_seq));
			$goodsData	= $query->row_array();
			if(!serviceLimit('H_AD') || $goodsData['provider_seq'] == $aPostParams['provider_seq']){
			$iparams['gift_seq']		= $event_seq;
			$iparams['benefit_rule']	= $aPostParams['gift_rule'];
			$iparams['gift_goods_seq']	= $gift_goods_seq;
			$iparams['sprice']			= get_cutting_price($aPostParams['sprice4'][0]);
			$iparams['ea']				= 1;
			$result = $this->db->insert('fm_gift_benefit', $iparams);
		}
		}


		if($data['gift_gb']=="buy"){
			$today = date("Y-m-d");
			if($aPostParams['display'] == 'y' && $aPostParams['start_date'] <= $today && $aPostParams['end_date'] >= $today){
				$qry = "update fm_gift set display = 'y' where gift_seq = '{$event_seq}'";
				$this->db->query($qry);
			}
		}

		/* 파일생성 */
		$this->load->helper('file');
		$this->load->helper('design');
		$skin_list = $this->designmodel->get_all_skin_list();

		$saveData = array(
			'tpl_desc'		=> $data['title'],
			'tpl_page'		=> 1,
			'regist_date'	=> date('Y-m-d H:i:s'),
		);
		
		// 구스킨 사용 시 이벤트 페이지 생성
		if($operation_type == 'heavy'){
		foreach($skin_list as $skin_info){
			$fullpath = ROOTPATH.'data/skin/'.$skin_info['skin'].'/'.$tpl_path;
			if( $skin_info['skin'] && is_dir(ROOTPATH.'data/skin/'.$skin_info['skin'].'/') ) {
				if(!$tpl_path || ($tpl_path && !file_exists($fullpath))){
					if(write_file($fullpath, '')){
						layout_config_save($skin_info['skin'],$tpl_path,$saveData);
						$fp= fopen($fullpath,'w');
							$print = $this->gift_page($aPostParams['gift_gb']);
						foreach($print as $k){
							fwrite($fp, $k);
							fwrite($fp, "\n");
						}

							if(strpos($skin_info['skin'],'mobile') === false){
								if($display_seq) fwrite($fp,"{=showDesignDisplay({$display_seq})}");
							}else{
								if($m_display_seq) fwrite($fp,"{=showDesignDisplay({$m_display_seq})}");
							}
						fclose($fp);

						@chmod($fullpath,0707);
					}
				}
			}
		}
		}
		if($result){
			if($mode == "new"){
				$callback = "parent.document.location = './gift_regist?event_seq={$event_seq}&mode=new';";
			}else{
				$callback = "parent.document.location.reload();";
			}
			openDialogAlert("이벤트가 저장 되었습니다.",400,140,'parent',$callback);
		}
	}

	public function gift_cont(){
		$gift_seq	= $_GET['seq'];
		$query = $this->db->query("select * from fm_gift where gift_seq=?",$gift_seq);
		$data = $query->row_array();

		if($data['gift_gb'] != "order"){
		$qry = "update fm_gift set display = 'n' where gift_gb = '{$data['gift_gb']}'";
			//$this->db->query($qry);
		}

		$qry = "update fm_gift set display = 'y' where gift_seq = '{$gift_seq}'";
		$this->db->query($qry);

		$callback = "parent.document.location.reload();";
		openDialogAlert("처리 되었습니다.",400,140,'parent',$callback);
	}


	public function event_view_modify(){

		$event_view_opt['disp_target']				= ($_POST['disp_target'] == 'all') ? 'all' : 'ing';

		$event_view_opt['count_w']					= (int)$_POST['count_w'];
		$event_view_opt['count_h']					= (int)$_POST['count_h'];
		$event_view_opt['size_w']					= (int)$_POST['size_w'];
		$event_view_opt['size_h']					= (int)$_POST['size_h'];

		$event_view_opt['over_line_use']			= ($_POST['over_line_use'] == 'y') ? 'y' : 'n';
		$event_view_opt['non_line_color']			= (preg_match('/^#[0-9|a-z]{6}$/',$_POST['non_line_color'])) ? $_POST['non_line_color'] : '#FFFFFF';
		$event_view_opt['non_line_px']				= (int)$_POST['non_line_px'];
		$event_view_opt['over_line_color']			= (preg_match('/^#[0-9|a-z]{6}$/',$_POST['over_line_color'])) ? $_POST['over_line_color'] : '#FFFFFF';
		$event_view_opt['over_line_px']				= (int)$_POST['over_line_px'];
		$event_view_opt['over_opacity_use']			= ($_POST['over_opacity_use'] == 'y') ? 'y' : 'n';
		$event_view_opt['over_opacity_per']			= (int)$_POST['over_opacity_per'];
		$event_view_opt['end_lay_use']				= ($_POST['end_lay_use'] == 'y') ? 'y' : 'n';
		$event_view_opt['close_lay_use']			= ($_POST['close_lay_use'] == 'y') ? 'y' : 'n';
		$event_view_opt['close_icon_day']			= (int)$_POST['close_icon_day'];

		$event_view_opt['event_intorduce_use']		= ($_POST['event_intorduce_use'] == 'y') ? 'y' : 'n';
		$event_view_opt['event_period_use']			= ($_POST['event_period_use'] == 'y') ? 'y' : 'n';
		$event_view_opt['event_end_icon_use']		= ($_POST['event_end_icon_use'] == 'y') ? 'y' : 'n';
		$event_view_opt['event_until_use']			= ($_POST['event_until_use'] == 'y') ? 'y' : 'n';


		$event_view_opt['m_count_w']				= (int)$_POST['m_count_w'];
		$event_view_opt['m_count_h']				= (int)$_POST['m_count_h'];
		$event_view_opt['m_size_w']					= (int)$_POST['m_size_w'];
		$event_view_opt['m_size_h']					= (int)$_POST['m_size_h'];

		$event_view_opt['m_over_line_use']			= ($_POST['m_over_line_use'] == 'y') ? 'y' : 'n';
		$event_view_opt['m_non_line_color']			= (preg_match('/^#[0-9|a-z]{6}$/',$_POST['m_non_line_color'])) ? $_POST['m_non_line_color'] : '#FFFFFF';
		$event_view_opt['m_non_line_px']			= (int)$_POST['m_non_line_px'];
		$event_view_opt['m_over_line_color']		= (preg_match('/^#[0-9|a-z]{6}$/',$_POST['m_over_line_color'])) ? $_POST['m_over_line_color'] : '#FFFFFF';
		$event_view_opt['m_over_line_px']			= (int)$_POST['m_over_line_px'];
		$event_view_opt['m_over_opacity_use']		= ($_POST['m_over_opacity_use'] == 'y') ? 'y' : 'n';
		$event_view_opt['m_over_opacity_per']		= (int)$_POST['m_over_opacity_per'];
		$event_view_opt['m_end_lay_use']			= ($_POST['m_end_lay_use'] == 'y') ? 'y' : 'n';
		$event_view_opt['m_close_lay_use']			= ($_POST['m_close_lay_use'] == 'y') ? 'y' : 'n';
		$event_view_opt['m_close_icon_day']			= (int)$_POST['m_close_icon_day'];

		$event_view_opt['m_event_intorduce_use']	= ($_POST['m_event_intorduce_use'] == 'y') ? 'y' : 'n';
		$event_view_opt['m_event_period_use']		= ($_POST['m_event_period_use'] == 'y') ? 'y' : 'n';;
		$event_view_opt['m_event_end_icon_use']		= ($_POST['m_event_end_icon_use'] == 'y') ? 'y' : 'n';;
		$event_view_opt['m_event_until_use']		= ($_POST['m_event_until_use'] == 'y') ? 'y' : 'n';;


		// 종료아이콘 이미지
		if($_POST['end_icon_new'] && is_file(ROOTPATH."/data/tmp/{$_POST['end_icon_new']}") === true){
			if(!is_dir(ROOTPATH.'data/event')){
				@mkdir(ROOTPATH.'data/event');
				@chmod(ROOTPATH.'data/event',0777);
			}

			$ext				= explode(".",$_POST['end_icon_new']);
			$custom_end_icon	= "custom_end_icon.{$ext[1]}";
			$new_path			= "data/event/{$custom_end_icon}";
			copy(ROOTPATH."/data/tmp/{$_POST['end_icon_new']}", ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
			unlink(ROOTPATH."/data/tmp/{$_POST['end_icon_new']}");

			$event_view_opt['end_icon']	= "/{$new_path}";
		}else{
			$event_view_opt['end_icon']	= $_POST['end_icon_org'];
		}

		// 종료임박아이콘 이미지
		if($_POST['close_icon_new'] && is_file(ROOTPATH."/data/tmp/{$_POST['close_icon_new']}") === true){
			if(!is_dir(ROOTPATH.'data/event')){
				@mkdir(ROOTPATH.'data/event');
				@chmod(ROOTPATH.'data/event',0777);
			}

			$ext				= explode(".",$_POST['close_icon_new']);
			$custom_close_icon	= "custom_close_icon.{$ext[1]}";
			$new_path			= "data/event/{$custom_close_icon}";
			copy(ROOTPATH."/data/tmp/{$_POST['close_icon_new']}", ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
			unlink(ROOTPATH."/data/tmp/{$_POST['close_icon_new']}");

			$event_view_opt['close_icon']	= "/{$new_path}";
		}else{
			$event_view_opt['close_icon']	= $_POST['close_icon_org'];
		}


		// 모바일 종료아이콘 이미지
		if($_POST['m_end_icon_new'] && is_file(ROOTPATH."/data/tmp/{$_POST['m_end_icon_new']}") === true){
			if(!is_dir(ROOTPATH.'data/event')){
				@mkdir(ROOTPATH.'data/event');
				@chmod(ROOTPATH.'data/event',0777);
			}

			$ext				= explode(".",$_POST['m_end_icon_new']);
			$m_custom_end_icon	= "m_custom_end_icon.{$ext[1]}";
			$new_path			= "data/event/{$m_custom_end_icon}";
			copy(ROOTPATH."/data/tmp/{$_POST['m_end_icon_new']}", ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
			unlink(ROOTPATH."/data/tmp/{$_POST['m_end_icon_new']}");

			$event_view_opt['m_end_icon']	= "/{$new_path}";
		}else{
			$event_view_opt['m_end_icon']	= $_POST['m_end_icon_org'];
		}

		// 종료임박아이콘 이미지
		if($_POST['m_close_icon_new'] && is_file(ROOTPATH."/data/tmp/{$_POST['m_close_icon_new']}") === true){
			if(!is_dir(ROOTPATH.'data/event')){
				@mkdir(ROOTPATH.'data/event');
				@chmod(ROOTPATH.'data/event',0777);
			}

			$ext				= explode(".",$_POST['m_close_icon_new']);
			$m_custom_close_icon= "m_custom_close_icon.{$ext[1]}";
			$new_path			= "data/event/{$m_custom_close_icon}";
			copy(ROOTPATH."/data/tmp/{$_POST['m_close_icon_new']}", ROOTPATH.$new_path);
			chmod(ROOTPATH.$new_path,0777);
			unlink(ROOTPATH."/data/tmp/{$_POST['m_close_icon_new']}");

			$event_view_opt['m_close_icon']	= "/{$new_path}";
		}else{
			$event_view_opt['m_close_icon']	= $_POST['m_close_icon_org'];
		}

		config_save_array('event',array('display'=>$event_view_opt));

		$callback = "parent.document.location.reload();";
		openDialogAlert("처리 되었습니다.",400,140,'parent',$callback);
	}

	public function gift_page($gift_gb){
		$html[] = "";
		$html[] = "<table width='100%' border='0' cellpadding='0' cellspacing='0'>";
		$html[] = "<tr>";
		if($gift_gb != "order"){
		$html[] = "	<td align='center'><img src='../images/design/gift_top.gif'></td>";
		}else{
		$html[] = "	<td align='center'><img src='../images/design/gift_order_top.gif'></td>";
		}
		$html[] = "</tr>";
		$html[] = "</table>";
		$html[] = "<div style='padding:25px;'></div>";
		$html[] = "<table width='100%' border='0' cellpadding='0' cellspacing='0'>";
		$html[] = "<tr>";
		$html[] = "	<td width='33%' align='center'><img src='../images/design/thumb_gift.gif'></td>";
		$html[] = "	<td width='33%' align='center'><img src='../images/design/thumb_gift.gif'></td>";
		$html[] = "	<td width='33%' align='center'><img src='../images/design/thumb_gift.gif'></td>";
		$html[] = "	</tr>";
		$html[] = "	<tr><td colspan='3' height='20'></td></tr>";
		$html[] = "	<tr>";
		$html[] = "		<td width='33%' align='center'><img src='../images/design/gift_icon_a.gif'> 사은품명</td>";
		$html[] = "		<td width='33%' align='center'><img src='../images/design/gift_icon_b.gif'> 사은품명</td>";
		$html[] = "		<td width='33%' align='center'><img src='../images/design/gift_icon_c.gif'> 사은품명</td>";
		$html[] = "	</tr>";
		$html[] = "	</table>";
		$html[] = "	<div style='padding:30px;'></div>";
		$html[] = "	<div style='width:100%;text-align:center;'><div style='border:2px solid #d9d9d9;background:#f7f7f7;width:900px;'></div></div>";
		$html[] = "	<div style='padding:25px;'></div>";
		$html[] = "	<table width='100%' border='0' cellpadding='0' cellspacing='0'>";
		$html[] = "	<tr>";
		$html[] = "		<td align='center'><img src='../images/design/gift_items_tit.gif'></td>";
		$html[] = "	</tr>";
		$html[] = "	</table>";
		$html[] = "	<div style='padding:30px;'></div>	";
		return $html;
	}
}
