<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/api_base".EXT);
// 비디오 커머스 trait
require_once(APPPATH ."libraries/broadcast/BroadcastTrait".EXT);

/**
 * 비디오 커머스에서 사용하는 편성표 관련 API
 * @api
 * @author Sunha Ryu
 * 2019-11-22
 */
class Provider extends api_base
{
    // Trait
	use BroadcastTrait;
	var $grant = "";

    function __construct() {
		parent::__construct();
        $this->check('app');
	}

    /**
     * 입점사 리스트 조회
     * @api
     * @param clientId : 클라이언트 아이디
     * @param secretKey : 보안 키
     * @return providerList : 입점사 리스트
     */
    public function list_get()
    {
        $this->load->model('providermodel');
        $this->load->helper('basic');
		$this->load->helper('broadcast');

		if(isBroadcastUse() !== true) {// 서비스 신청이 안된 상태
			$this->response(array(
                'success' => false,
                'code' => "not_use",
                'message' => "라이브 서비스 신청을 하지 않은 도메인입니다.",
            ), parent::HTTP_UNAUTHORIZED);
		}

        // 입점사 조회
        $sc['orderby']	= 'provider_name';
        $sc['sort']		= 'asc';
        $sc['page']		= 0;
        $sc['perpage']	= 9999;
		$result	= $this->providermodel->provider_list($sc);

        $response = array(
            'success'   =>      true,
            'data'      =>      $result,
        );
        $this->response($response);
	}

}