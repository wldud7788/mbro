<?php
/**
 * 클라이언트에서 로직을 수행하기 위한 초기 설정값 지정 클래스
 *
 * @author pjw <pjw@gabiacns.com>
 */

namespace App\Libraries\Social\Apple;

use App\Libraries\Social\ClientConfig;
use App\Libraries\Social\ClientRequestData;

class AppleConfig extends ClientConfig
{
    // 부모 생성자에 값을 전달
    public function __construct(ClientRequestData $clientRequestData) {
        parent::__construct($clientRequestData);
    }

    // Redirect Url 설정
    public function getRedirectUrl() {
        return get_connet_protocol().$_SERVER['HTTP_HOST'].'/sns_process/applecertificate';
    }

    // fm_config 에서 애플 관련 정보만 저장
    public function initConfig($config, $requestParameter) {
        $this->config = [
            'use_a' => $config['use_a'],
            'kid' => $config['key_a'],
            'iss' => $config['team_a'],
            'sub' => $config['clientid_a'],
            'privateKey' => $config['private_key_a'],
            'redirect_uri' => $this->getRedirectUrl(),
            'code' => $requestParameter['code'],
            'state' => $requestParameter['state'],
            'id_token' => $requestParameter['id_token'],
            'user' => $requestParameter['user'],
            'error' => $requestParameter['error'],
        ];
    }

    // fm_member 에서 사용 될 컬럼 목록
    public function initMemberColumnKeys() {
        $this->memberColumnKeys = [
            'rute' => 'apple',
            'prefix' => 'ap',
            'key' => 'sns_a',
            'app_key' => 'key_a',
            'use_key' => 'use_a',
        ];
    }
}