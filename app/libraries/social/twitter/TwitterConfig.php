<?php
/**
 * 클라이언트에서 로직을 수행하기 위한 초기 설정값 지정 클래스
 *
 * @author pjw <pjw@gabiacns.com>
 */

namespace App\Libraries\Social\Twitter;

use App\Libraries\Social\ClientConfig;
use App\Libraries\Social\ClientRequestData;

class TwitterConfig extends ClientConfig
{
    public function __construct(ClientRequestData $clientRequestData) {
        parent::__construct($clientRequestData);
    }

    // Redirect Url 설정
    // 현재 레거시로 되어있음 추후 변경 해야함
    public function getRedirectUrl() {
        return get_connet_protocol().($_SERVER['HTTP_HOST'])."/sns_process/twitterjoin";
    }

    // fm_config 에서 트위터 관련 정보만 저장
    public function initConfig($config, $requestParameter) {
        $this->config = [
            'use_t' => $config['use_t'],
            'consumer_key' => $config['key_t'],
            'consumer_secret' => $config['secret_t'],
            'oauth_token' => $_SESSION['oauth_token'],
            'oauth_token_secret' => $_SESSION['oauth_token_secret'],
            'redirect_uri' => $this->getRedirectUrl(),
            'oauth_verifier' => $requestParameter['oauth_verifier'],
            'denied' => $requestParameter['denied'],
        ];
    }

    // fm_member 에서 사용 될 컬럼 목록
    public function initMemberColumnKeys() {
        $this->memberColumnKeys = [
            'rute' => 'twitter',
            'prefix' => 'tw',
            'key' => 'sns_t',
            'app_key' => 'key_t',
            'use_key' => 'use_t',
        ];
    }
}