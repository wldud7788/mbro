<?php
/**
 * 클라이언트에서 로직을 수행하기 위한 초기 설정값 지정 클래스
 *
 * @author pjw <pjw@gabiacns.com>
 */

namespace App\Libraries\Social\Facebook;

use App\Libraries\Social\ClientConfig;
use App\Libraries\Social\ClientRequestData;

class FacebookConfig extends ClientConfig
{
    public function __construct(ClientRequestData $clientRequestData) {
        parent::__construct($clientRequestData);
    }

    // Redirect Url 설정
    public function getRedirectUrl() {
        return get_connet_protocol().$_SERVER['HTTP_HOST'].'/sns_process/facebook_callback';
    }

    // fm_config 에서 애플 관련 정보만 저장
    public function initConfig($config, $requestParameter) {
        $this->config = [
            'use_f' => $config['use_f'],
            'appId' => $config['key_f'],
            'secret' => $config['secret_f'],
            'redirect_uri' => $this->getRedirectUrl(),
            'code' => $requestParameter['code'],
            'state' => $requestParameter['state'],
            'error' => $requestParameter['error'],
            'version' => '11.0',
            'cookie' => true,
        ];
    }

    // fm_member 에서 사용 될 컬럼 목록
    public function initMemberColumnKeys() {
        $this->memberColumnKeys = [
            'rute' => 'facebook',
            'prefix' => 'fb',
            'key' => 'sns_f',
            'app_key' => 'key_f',
            'use_key' => 'use_f',
        ];
    }
}