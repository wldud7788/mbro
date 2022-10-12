<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/api_base".EXT);
// 비디오 커머스 trait
require_once(APPPATH ."libraries/broadcast/BroadcastTrait".EXT);

/**
 * 비디오 커머스에서 사용하는 편성표 관련 API
 * @api
 * @author Sunha Ryu
 * 2019-11-22
 */
class broadcast extends api_base
{
    // Trait
	use BroadcastTrait;
	var $grant = "";

    function __construct() {
		parent::__construct();

		// 통신 서버 설정
		$this->initBroadcastServerConfig();

		// uri_string 으로 접근권한체크
		$this->authCheck();
	}

	/**
	 * vod 서버에서 리턴되는 콜백 function
	 * vod 통계 쌓기
	 */
	public function callback_post() {
		$debug['url'] = $this->uri->uri_string;
		$debug['post'] = $this->input->post();
		writeCsLog($debug, "callback" , "vod");

		$bsSeq = $this->uri->segment(4);
		$bs_seq = $this->input->post('shop_broadcast_seq');

        if(empty($bsSeq) || empty($bs_seq)) {
            $this->response404();
		}

		$bsResult = $this->statsUpdate($bsSeq);

		// 로깅
		$logParams = array(
			'provider_seq' => 0,
			'manager_seq' => 0,
			'memo' => 'VOD CALLBACK SAVE',
			'device' => 'system'
		);

		// db logging
		$this->load->library('broadcast/logs', $logParams);
		$this->logs->logging('callback', $bsSeq);


		$res = array(
            'success' => true,
            'result' => $bsResult,
        );
        return $this->response($res);
	}


	/**
	 * 권한 체크 없이 라이브 중인 방송만 체크
	 */
	public function live_get() {
		// 헤더 체크는 함
		$this->grant = $this->check(array('admin', 'app'));
		$this->load->library('broadcast/permit', $this->apiTokenInfo);

		$param['status'] = 'live';
		$param['perpage']			= 5;
		$param['page']				= 0;
		$param['searchcount']		= false;
		$data = $this->catalog($param);

        // 카멜 케이스로 변환한다.
        $data = camel_keys($data);
        $res = array(
            'success' => true,
            'data' => $data,
		);
        return $this->response($res);
	}

	/**
	 * 권한 체크 없이 현재 방송 상태 체크
	 */
	public function status_get() {
		$bsSeq = $this->uri->segment(4);
		$data = $this->view($bsSeq);

		$res = array(
            'success' => true,
            'status' => $data['status'],
        );

        return $this->response($res);
	}

	/**
	* broadcast 관련 config 리턴
	*/
	public function config_get() {
		$this->load->helper('broadcast');
		$config = getBroadcastConf();

		$res = array(
            'success' => true,
            'config' => $config,
        );
        return $this->response($res);
	}

	// 사용할지 안할지 아직 모름
	public function use_put() {
		return $this->useUpdate();
	}

    /**
     * 방송-편성표
     * 편성표 조회
     *
     */
    public function index_get()
    {
		$bsSeq = $this->uri->segment(3);

		if(!$bsSeq) {
			$data = $this->catalog();
		} else {
			$data = $this->view($bsSeq);
		}

        // 카멜 케이스로 변환한다.
        $data = camel_keys($data);
        $res = array(
            'success' => true,
            'data' => $data,
        );
        return $this->response($res);
    }

    /**
     * 방송-편성표
     * 편성표 등록
     * 접근 권한 : admin, app
     */
    public function create_post()
    {
		$grant = $this->grant;
        $this->load->helper('broadcast');
		$raw = $this->input->post();

        // 폼 검증
        $validRes = $this->registValid($raw, $grant);
        if($validRes['result']!==true) { // 검증 실패
            $this->response404(array(
                'code'=> 'param_error',
                'message' => $validRes['data'],
            ));
        }
		$params = $validRes['data'];

        $bsSeq = $this->createBroadcast($params, $grant);
        if($bsSeq === false) {
            $this->response500();
        } else {
            // 로깅
            $logParams = array(
				'provider_seq' => $this->permit->getProviderSeq(),
				'manager_seq' => $this->permit->getManagerSeq(),
				'memo' => '방송 생성',
				'device' => $grant
			);

			// db logging
            $this->load->library('broadcast/logs', $logParams);
            $this->logs->logging('create', $bsSeq);

            $res = array(
                'success' => true,
                'data' => array('bsSeq'=>$bsSeq),
            );
            $this->response($res);
        }

    }

    /**
     * 방송-편성표
     * 편성표 수정
     * 접근 권한: admin
     */
    public function modify_post()
    {
		$grant = $this->grant;
        $this->load->helper('broadcast');

        $bsSeq = $this->uri->segment(4);
        if(empty($bsSeq)) {
            $this->response404();
		}

        $raw = $this->input->post();
        // 폼 검증
        $validRes = $this->registValid($raw,$grant);
        if($validRes['result']!==true) { // 검증 실패
            $this->response404(array(
                'code'=> 'param_error',
                'message' => $validRes['data'],
            ));
            return false;
        }
        $params = $validRes['data'];

        $data = $this->modifyBroadcast($bsSeq, $params, $grant);
        if($data['result'] === true) {

            // 로깅
            $logParams = array(
				'provider_seq' => $this->permit->getProviderSeq(),
				'manager_seq' => $this->permit->getManagerSeq(),
				'memo' => '방송 수정',
				'device' => $grant
			);
            // db logging
            $this->load->library('broadcast/logs', $logParams);
            $this->logs->logging('modify', $bsSeq);
			$res = array(
                'success' => true,
                'data' => array('bsSeq'=>(int)$bsSeq),
            );
            $this->response($res, parent::HTTP_OK);
        } else {
            $this->response404($data['err'] ? $data['err'] : null);
        }
    }

    /**
     * 방송-편성표
     * 편성표 삭제 data delete
     * 접근 권한 : admin
     */
    public function index_delete()
    {
		$grant = $this->grant;
        $this->load->helper('broadcast');

        $bsSeq = $this->uri->segment(3);
        if(empty($bsSeq)) {
            $this->response404();
        }
        $data = $this->dropBroadcast($bsSeq);
        if($data['result'] === true) {

            // 로깅
            $logParams = array(
				'provider_seq' => $this->permit->getProviderSeq(),
				'manager_seq' => $this->permit->getManagerSeq(),
				'memo' => '방송 삭제-DATA REMOVE',
				'device' => $grant
			);

            // db logging
            $this->load->library('broadcast/logs', $logParams);
            $this->logs->logging('delete', $bsSeq);
            $this->response(array('result'=>true), parent::HTTP_OK);
        } else {
			if($data['err']) {
				$this->response($data, parent::HTTP_OK);
			}
            $this->response404();
        }
	}

	/**
     * 방송-편성표
     * 편성표 삭제 status='delete'
     * 접근 권한 : admin
     */
    public function delete_put()
    {
		$grant = $this->grant;
        $this->load->helper('broadcast');

        $bsSeq = $this->uri->segment(4);
        if(empty($bsSeq)) {
            $this->response404();
        }
        $data = $this->deleteBroadcast($bsSeq);
        if($data['result'] === true) {

            // 로깅
            $logParams = array(
				'provider_seq' => $this->permit->getProviderSeq(),
				'manager_seq' => $this->permit->getManagerSeq(),
				'memo' => '방송 삭제-DATA DELETE UPDATE',
				'device' => $grant
			);

            // db logging
            $this->load->library('broadcast/logs', $logParams);
            $this->logs->logging('delete', $bsSeq);
            $this->response(array('success'=>true), parent::HTTP_OK);
        } else {
            $this->response404($data['err'] ? $data['err'] : null);
        }
    }

    /**
     * 방송-방송노출
     * 방송 노출 / 미노출
     * 접근 권한 : admin
     *
     * @param bsSeq(segment) : 방송 번호 (fm_broadcast 의 PK)
     */
    public function display_put()
    {

        return $this->displayUpdate();
	}

    /**
     * 방송-방송상태
     * 방송 시작
     *
     * @param bsSeq(segment) : 방송 번호 (fm_broadcast 의 PK)
     * @param id : 사용자 ID
     */
    public function start_put()
    {
		$this->load->helper('broadcast');
		$this->load->model('broadcastmodel');

		$grant = $this->grant;
		$action = 'live';

		$bsSeq = $this->uri->segment(4);
        if(empty($bsSeq)) {
            $this->response404();
		}

		// 실제로 상태 업데이트
		$result = $this->statusUpdate($action);

        if($result['success'] === true) {
			// 로깅
			$logParams = array(
				'provider_seq' => $this->permit->getProviderSeq(),
				'manager_seq' => $this->permit->getManagerSeq(),
				'memo' => '방송 상태 변경('.$this->broadcastmodel->cfg_status[$action].')',
				'device' => $grant
			);
			// db logging
			$this->load->library('broadcast/logs', $logParams);
			$this->logs->logging($action, $bsSeq);

            $this->response($result, parent::HTTP_OK);
        } else {
            $this->response404($result['err'] ? $result['err'] : null);
		}
    }

    /**
     * 방송-방송상태
     * 방송 종료
     *
     * @param bsSeq(segment) : 방송 번호 (fm_broadcast 의 PK)
     * @param id : 사용자 ID
     */
    public function stop_put()
    {
		$this->load->helper('broadcast');
		$this->load->model('broadcastmodel');

        $grant = $this->grant;
		$action = 'end';

		$bsSeq = $this->uri->segment(4);
        if(empty($bsSeq)) {
            $this->response404();
		}

		// 실제로 상태 업데이트
		$result = $this->statusUpdate($action);

        if($result['success'] === true) {
			// 로깅
			$logParams = array(
				'provider_seq' => $this->permit->getProviderSeq(),
				'manager_seq' => $this->permit->getManagerSeq(),
				'memo' => '방송 상태 변경('.$this->broadcastmodel->cfg_status[$action].')',
				'device' => $grant
			);
			// db logging
			$this->load->library('broadcast/logs', $logParams);
			$this->logs->logging($action, $bsSeq);

            $this->response($result, parent::HTTP_OK);
        } else {
            $this->response404($result['err'] ? $result['err'] : null);
		}
	}

	/**
     * 방송-방송상태
     * 방송 종료
     *
     * @param bsSeq(segment) : 방송 번호 (fm_broadcast 의 PK)
     * @param id : 사용자 ID
	 * /api/broadcast/end/{bsseq}
     */
    public function endforce_post()
    {
		$this->load->helper('broadcast');
		$this->load->model('broadcastmodel');

        $grant = $this->grant;
		$action = 'end';

		$bsSeq = $this->uri->segment(4);
        if(empty($bsSeq)) {
            $this->response404();
		}

		// 실제로 상태 업데이트
		$result = $this->statusUpdate($action);

        if($result['success'] === true) {
			// 로깅
			$logParams = array(
				'provider_seq' => 0,
				'manager_seq' => 0,
				'memo' => '방송 상태 강제 변경('.$this->broadcastmodel->cfg_status[$action].')',
				'device' => 'system'
			);
			// db logging
			$this->load->library('broadcast/logs', $logParams);
			$this->logs->logging($action, $bsSeq);

            $this->response($result, parent::HTTP_OK);
        } else {
            $this->response404($result['err'] ? $result['err'] : null);
		}
	}

	/**
     * 방송-방송상태
     * 송출 상태 체크
     *
     * @param bsSeq(segment) : 방송 번호 (fm_broadcast 의 PK)
     * @param id : 사용자 ID
     */
    public function disconnect_put()
    {
		$this->load->helper('broadcast');
		$this->load->model('broadcastmodel');

        $grant = $this->grant;

		$bsSeq = $this->uri->segment(4);
		$disconnect = $this->uri->segment(5);

        if(empty($bsSeq)) {
            $this->response404();
		}

		// 실제로 상태 업데이트
		$result = $this->disconnectUpdate();

        if($result === true) {
			// 로깅
			$logParams = array(
				'provider_seq' => $this->permit->getProviderSeq(),
				'manager_seq' => $this->permit->getManagerSeq(),
				'memo' => '방송 연결상태 변경('.$this->broadcastmodel->cfg_disconnect[$disconnect].')',
				'device' => $grant
			);
			// db logging
			$this->load->library('broadcast/logs', $logParams);
			$this->logs->logging("disconnect", $bsSeq);

            $this->response($result, parent::HTTP_OK);
        } else {
            $this->response(array(
				'code'  =>  'not_update',
				'message'   =>  '방송 연결상태 변경 실패',
			), parent::HTTP_FORBIDDEN);
		}
	}

	/**
	 * 채팅(관리자/사용자/노티) 전송 - 소켓은 vod에서 send
	 */
	public function chat_post()
	{
		// referer 체크 필요?
		$post = $this->input->post();
		if(empty($post['bs_seq']) || empty($post['stream_key'])){
			$this->response404();
		}

		if($post['bs_seq'] && empty($post['stream_key'])){
			$data = $this->view($post['bs_seq']);
			$post['stream_key'] = $data['stream_key'];
		}

		$param = array();
		$param['type'] = $post['type'];
		$param['seq'] = $post['seq'];
		$param['name'] = $post['name'];
		$param['msg'] = $post['msg'];
		$this->sendChat($param, $post['stream_key']);
		$this->response(array('success'=>true), parent::HTTP_OK);
	}

	/**
	 * vod 시 채팅 목록 가져오기
	 */
	public function chat_get()
	{
		$bsSeq = $this->uri->segment(4);
		if(empty($bsSeq)) {
            $this->response404();
		}
		$sch = $this->view($bsSeq);

		$vodchat = $this->vodchat($sch['stream_key'],$sch['bs_seq']);

		$this->response(array('success'=>true,'data'=>$vodchat), parent::HTTP_OK);
	}

	/**
	 * vod 서버 정보 get
	 */
	public function info_get()
	{
		$bsSeq = $this->uri->segment(4);
		if(empty($bsSeq)) {
            $this->response404();
		}
		$sch = $this->view($bsSeq);
		$result = $this->info($sch['stream_key'],$sch['bs_seq']);

		$this->response(array('success'=>true,'data'=>$result), parent::HTTP_OK);
	}

    /**
     * 방송에 연결된 상품 정보를 가져온다.
     *
     * 접근 권한 : admin
     */
    public function goods_get()
    {
        $this->load->model("goodsmodel");

        $goodsData = $this->searchGoods();

		$goodsData = camel_keys($goodsData);

        $res = array(
            'success' => true,
            'data' => $goodsData,
        );
        $this->response($res);
	}

	/**
	 * 남은 방송 건수 리턴
	 */
	public function available_get()
	{
		// stream 계정 정보 리턴
		$userInfo = $this->getUserInfo();

		$res = array(
            'success' => true,
            'data' => array('availableCnt'=>$userInfo['available_cnt']),
        );

		return $this->response($res);
	}

	/**
	 * VOD 유저 정보조회
	 */
	public function user_get() {
		// 계정 정보 리턴
		$userInfo = $this->getUserInfo();

		$res = array(
			'success' => true,
			'data' => $userInfo
		);

		return $this->response($res);
	}

	/**
	 * VOD 유저 사용량 조회
	 */
	public function stat_get() {
		// stream 계정 정보 리턴
		$userInfo = $this->getUserInfo(true);

		// 각 사용량 단위 설정
		$userInfo['used_live_traffics'] = get_capacity_with_unit($userInfo['used_live_traffics']);
		$userInfo['used_vod_traffics'] = get_capacity_with_unit($userInfo['used_vod_traffics']);
		$userInfo['used_vod_quota'] = get_capacity_with_unit($userInfo['used_vod_quota']);

		$res = array(
			'success' => true,
			'data' => $userInfo
		);

		return $this->response($res);
	}

    /**
     * 방송 종료 시간 업데이트
     *
     * @param bsSeq : 방송 seq
     * @description 방송 시간 초과 시 저장 여부 팝업 노출로인해 시간만큼 방송종료시간 지연을 방지하기위한 방송종료시간만 업데이트 하는 API
     */
    public function save_end_time_put() {
        // 방송 번호 유효성 검사
        $bsSeq = $this->uri->segment(4);
        if (!$bsSeq) {
            $this->response404();
        }

        // 모델 로드
        $this->load->model('broadcastmodel');

        // 방송 데이터 조회
        $broadcastData = $this->broadcastmodel->getSch(['bs_seq' => $bsSeq]);
        $broadcastData = $broadcastData[0];

        // 방송 데이터 없는 경우 404 리턴
        if (!$broadcastData) {
            $this->response404(['code' => 'empty_data', 'message' => '방송 데이터가 없습니다.']);
        }

        // 현재 방송 중인지 여부와 종료 시간이 비어있는지 여부
        if ($broadcastData['status'] !== 'live' || $broadcastData['real_end_date']) {
            $this->response(['success' => false, 'message' => '이미 종료 된 방송입니다.']);
        }

        // 종료시간을 업데이트 처리
        $realEndDateUpdateResult = $this->broadcastmodel->setBroadcastDatetime($bsSeq, "real_end_date");
        if (!$realEndDateUpdateResult) {
            $this->response500(['code' => 'cannot_update_row', 'message' => '방송 종료시간 업데이트가 실패하였습니다.']);
        }

        $this->response(['success' => true, 'message' => '방송 종료 시간이 업데이트 되었습니다.']);
    }

	/*
	* 접근권한 체크
	*/
	public function authCheck() {
		$uri_string = implode('/', array_slice($this->uri->segments,0,3));

		switch($uri_string) {
			// VOD 서버 통신용 권한 체크
			case 'api/broadcast/callback':
			case 'api/broadcast/endforce':
				if(!in_array($_SERVER['REMOTE_ADDR'], $this->broadcast_config['allowServers'])) {
					$this->response404();
				}
				break;
			// front 용이므로 권한 체크 안함
			case 'api/broadcast/live':
			case 'api/broadcast/chat':
			case 'api/broadcast/status':
			case 'api/broadcast/info':
				break;
			// admin 용 권한 체크
			case 'api/broadcast':
			case 'api/broadcast/user/':
			case 'api/broadcast/stat/':
				$this->grant = $this->check(array('admin', 'app'));
				$this->load->library('broadcast/permit', $this->apiTokenInfo);
				// is_vod 로 권한 체크 합니다
				if($this->input->get('is_save') || $this->input->get('is_vod_key')) {
					$this->permit->type($this->grant)->check('vod_act');
				} else {
					$this->permit->type($this->grant)->check('broadcast_act');
				}
				break;
			default:
				$this->grant = $this->check(array('admin', 'app'));
				$this->load->library('broadcast/permit', $this->apiTokenInfo);
				$this->permit->type($this->grant)->check('broadcast_act');
				break;
		}
	}
}
