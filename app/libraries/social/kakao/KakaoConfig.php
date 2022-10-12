<?php
/**
 * 클라이언트에서 로직을 수행하기 위한 초기 설정값 지정 클래스
 *
 * @author pjw <pjw@gabiacns.com>
 */

namespace App\Libraries\Social\Kakao;

use App\Libraries\Social\ClientConfig;
use App\Libraries\Social\ClientRequestData;

class KakaoConfig extends ClientConfig
{
    public function __construct(ClientRequestData $clientRequestData) {
        parent::__construct($clientRequestData);
    }

    // Redirect Url 설정
    public function getRedirectUrl() {
        return get_connet_protocol().$_SERVER['HTTP_HOST'].'/sns_process/kakao_callback';
    }

    // fm_config 에서 애플 관련 정보만 저장
    public function initConfig($config, $requestParameter) {
        if($config['mode_ks'] == 'SYNC') $sync = true;

        $this->config = [
            'type' => $sync ? 'SYNC' : 'KAKAO',
            'use_k' => $config['use_k'],
            'javascript_key' => $config['key_k'],
            'rest_api_key' => $config['rest_key_k'],
            'redirect_uri' => $this->getRedirectUrl(),
            'mode' => $sync ? 'auto' : '',
            'requestParameter' => $requestParameter,
        ];
    }

    // fm_member 에서 사용 될 컬럼 목록
    public function initMemberColumnKeys() {
        $this->memberColumnKeys = [
            'rute' => 'kakao',
            'prefix' => 'kk',
            'key' => 'sns_k',
            'app_key' => 'key_k',
            'use_key' => 'use_k',
        ];
    }
}