<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);
// 비디오 커머스 trait
require_once(APPPATH ."libraries/broadcast/BroadcastTrait".EXT);

/**
 * 라이브 방송 페이지
 */
class broadcast_process extends admin_base {
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
     * 방송-편성표
     * 편성표 조회
     *
     */
    public function index_get()
    {
        $bsSeq = $this->uri->segment(3);

        var_dump($bsSeq);

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
        //return $this->response($res);


    }
}

?>