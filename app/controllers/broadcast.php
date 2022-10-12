<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/front_base".EXT);
require_once(APPPATH ."libraries/broadcast/BroadcastTrait".EXT);

class broadcast extends front_base {
	
	use BroadcastTrait;

	public function __construct() {
		parent::__construct();
	}

	public function index(){
		redirect("/broadcast/schedule");
	}

	/**
	 *  방송 스케쥴
	 */
	public function schedule(){
		// 퍼스트몰 라이브
		$file_path	= $this->template_path();

		// 라이브 방송
		$live['perpage'] = 15;//최대 15개
		$live['page'] = 0;
		$live['display'] = 'on';
		$live['orderby'] = 'b.start_date';//방송일시기준
		$live['status'] = array('create','live');	//방송중,방송예정,방송종료 
		$live['is_live'] = true;
		$live['sort'] = 'asc';
		$lives = $this->catalog($live);
		foreach($lives['result'] as &$live) {
			$live['start_date_day'] = date("m월 d일",strtotime($live['start_date']));
			$live['start_date_hour'] = date("H:i",strtotime($live['start_date']));
		}
		$this->template->assign('lives',$lives['result']);

		// 지난 방송 리스트
		$vod['perpage'] = 5;//최대 15개
		$vod['page'] = 0;
		$vod['display'] = 'on';
		$vod['status'] = array('end');	//방송중,방송예정,방송종료 
		$vod['is_save'] = true;//방송일시기준
		$vod['is_vod_key'] = true;//방송일시기준
		$vod['orderby'] = 'b.start_date';//방송일시기준
		$vods = $this->catalog($vod);
		foreach($vods['result'] as &$vod) {
			$vod['start_date_day'] = date("m월 d일",strtotime($vod['start_date']));
			$vod['start_date_hour'] = date("H:i",strtotime($vod['start_date']));
		}
		$this->template->assign('vods',$vods['result']);

		//방송 스케쥴
		//7일간 날짜 추출
		//7일간 데이터 추출하여 날짜 date에 담음
		$schedule_date = array();
		$arr = array('-3','-2','-1','0','+1','+2','+3');
		foreach($arr as $row) {
			$schedule_date[] = date("Y-m-d", strtotime($row."days"));
		}
		
		$sch['perpage'] = 100;//최대 100개 (7일 이내 방송이 100개 초과 시 추가 개발 필요)
		$sch['page'] = 0;
		$sch['display'] = 'on';
		$sch['status'] = array('create','live','end');	//방송중,방송예정,방송종료 
		$sch['orderby'] = 'b.start_date';//방송일시기준
		$sch['sdate'] = $schedule_date[0];
		$sch['edate'] = end($schedule_date);
		$schs = $this->catalog($sch);

		$calendar_sch = array();
		foreach($schs['result'] as $sch) {
			$start_date = date("m.d", strtotime($sch['start_date']));
			$sch['start_date_day'] = date("m월 d일",strtotime($sch['start_date']));
			$sch['start_date_hour'] = date("H:i",strtotime($sch['start_date']));
			$calendar_sch[$start_date][] = $sch;
		}

		foreach($schedule_date as &$row) {
			$row = date("m.d", strtotime($row));
		}
		$this->template->assign('calendar_sch',$calendar_sch);
		$this->template->assign('calendar',$schedule_date);

		$this->print_layout($file_path);
	}

	/**
	 *  지난방송 리스트
	 */
	public function display() {
		// 라이브 방송
		$sc = $this->input->get();

		$sc['perpage']			= (!empty($sc['perpage'])) ? intval($sc['perpage']):10;
		$sc['page']				= (!empty($sc['page'])) ? intval($sc['page']):0;
		$sc['display'] = 'on';
		$sc['status'] = array('end');	//방송중,방송예정,방송종료 
		$sc['is_save'] = true;//방송일시기준
		$sc['is_vod_key'] = true;//방송일시기준
		$sc['orderby'] = 'b.start_date';//방송일시기준
		$vods = $this->catalog($sc);

		foreach($vods['result'] as &$vod) {
			$vod['start_date_day'] = date("m월 d일",strtotime($vod['start_date']));
			$vod['start_date_hour'] = date("H:i",strtotime($vod['start_date']));
		}
		$this->template->assign('vods',$vods['result']);
		$this->template->assign('paging',$vods['page']);

		// 지난 방송
		$file_path	= $this->template_path();
		$this->print_layout($file_path);
	}

	/**
	 *  플레이어
	 */
	public function player() {
		$bsSeq = $this->input->get('no');
		$sch = $this->view($bsSeq);
		if(!$bsSeq || !$sch['bs_seq']) {
			pageBack(getAlert('et414'));
			exit;
		}

		// 지난 방송은 vod_key 없으면 팅겨냄
		if(defined('VOD') == true && empty($sch['vod_key'])){
			pageBack(getAlert('et414'));
			exit;
		}

		// live / end  이지만 stream_key 없으면 팅겨냄
		if(in_array($sch['status'],array("live","end")) && empty($sch['stream_key'])){
			pageBack(getAlert('et414'));
			exit;
		}
		
		// stream_key 발급 되면 vod 서버 확인
		if($sch['stream_key']) {
			$result = $this->info($sch['stream_key'],$sch['bs_seq']);
			if($result['shop_broadcast_seq']) {
				// 솔루션은 종료가 안되었는데, vod 종료면 vod 종료 시킴.
				if($result['status'] == 'end' && $sch['status'] != 'end') {
					//솔루션 db update
					$param['is_save'] = $result['is_save'];
					if($result['is_save']=='1') {
						$param['vod_key'] = $result['channel'];
					}
					$param['status'] = $result['status'];
					$param['real_end_date'] = $result['completed_at'];
					$this->broadcastmodel->updateBroadcast($param,$sch['bs_seq']);
				}

				$sch['likes'] = $result['likes'];
				$sch['notice'] = $result['notice'];
				$chats = $result['chats'];
			}
		}

		$sch['start_date'] = date("m월 d일 H시 i분",strtotime($sch['start_date']));

		$this->template->assign('sch',$sch);
		$this->template->assign('schjs',json_encode($sch));

		$this->managerInfo = $this->session->userdata('manager');
		$this->template->assign(array('managerInfo' => $this->managerInfo));

		foreach($sch['goodsData'] as $goods) {
			if($goods['broadcastGoodsMain'] == 1) {
				$goodsMain = $goods;
			}
		}
		$this->template->assign('goodsMain',$goodsMain);

		// 관리자 or 사용자
		if($this->userInfo) {
			$this->template->assign('is_user',true);
		}
		if($this->managerInfo) {
			$this->template->assign('is_admin',true);
		}

		$this->template->assign('chats',json_encode(array_reverse($chats)));

		//메타테그 치환용 정보
		$add_meta_info['goods_name']		= $goodsMain['goods_name'];
		$add_meta_info['title']				= $sch['title'];
		$add_meta_info['summary']			= $sch['summary'];
		$add_meta_info['start_date']		= $sch['start_date'];
		$add_meta_info['provider_name']		= $sch['provider_name'];
		$this->template->assign(array('add_meta_info'=>$add_meta_info));

		// 라이브 플레이어 화면
		$this->template->template_dir = BASEPATH."../broadcast";
		$this->template->compile_dir	= BASEPATH."../_compile/";
		$this->template->define(array('tpl'=>'player.html'));
		$this->template->print_('tpl');
	}

	/**
	 *  vod 플레이어
	 */
	public function vod() {
		define('VOD',true);
		$this->template->assign('vod',1);
		$this->player();
	}
	
	/**
	 * 채팅 권한 획득
	 */
	public function chat_auth() {
		$result = array('auth'=>false,'type'=>'');

		if($this->userInfo) {
			$result = array('auth'=>true,'type'=>'member');
		}

		if($this->managerInfo) {
			$result = array('auth'=>true,'type'=>'admin','manager_seq'=>$this->managerInfo['manager_seq']);
		}
		echo json_encode($result);
	}

	/**
	 * 좋아요 터치
	 */
	public function touch_likes() {
		$channel = $this->input->post('channel');
		if(!$channel) {
			return;
		}
		$result = $this->likes($channel);
		//echo json_encode($result);
	}
}

/* End of file bigdata.php */
/* Location: ./app/controllers/admin/bigdata.php */