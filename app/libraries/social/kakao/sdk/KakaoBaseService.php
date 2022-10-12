<?php
namespace App\Libraries\Social\Kakao\Sdk;

class KakaoBaseService
{
    public $JAVASCRIPT_KEY;
    protected $REST_API_KEY;
    protected $ADMIN_KEY;
    protected $CLIENT_SECRET;
    protected $REDIRECT_URI;
    protected $LOGOUT_REDIRECT_URI;
    protected $RETURN_TYPE;

    public function __construct($config) {
        // 카카오 앱 설정 값
        $this->JAVASCRIPT_KEY = $config['javascript_key']; // https://developers.kakao.com > 내 애플리케이션 > 앱 설정 > 요약 정보
        $this->REST_API_KEY   = $config['rest_api_key']; // https://developers.kakao.com > 내 애플리케이션 > 앱 설정 > 요약 정보
        $this->ADMIN_KEY      = $config['admin_key']; // https://developers.kakao.com > 내 애플리케이션 > 앱 설정 > 요약 정보
        $this->CLIENT_SECRET  = $config['client_secret']; // https://developers.kakao.com > 내 애플리케이션 > 제품 설정 > 카카오 로그인 > 보안
        $this->RETURN_TYPE  = $config['return_type'];

        $this->REDIRECT_URI          = urlencode($config['redirect_uri']);  // 내 애플리케이션 > 제품 설정 > 카카오 로그인
        $this->LOGOUT_REDIRECT_URI   = urlencode($config['redirect_uri']); // 내 애플리케이션 > 제품 설정 > 카카오 로그인 > 고급 > Logout Redirect URI
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function rtn($response, $status_code="200")
    {
        if($this->RETURN_TYPE==""){
            return $response;
        }
        else if($this->RETURN_TYPE=="JSON"){
            header("Content-Type:application/json;charset=UTF-8");
            echo json_encode(array('result'=>$response, 'status_code'=>$status_code));
            return $response;
        }
        else if($this->RETURN_TYPE=="ECHO"){
            echo $response;
            return $response;
        }
    }

    protected function excuteCurl($callUrl, $method, $headers = array(), $data = array(), $session_type="")
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $callUrl);
        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, true);
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
            curl_setopt($ch, CURLOPT_POST, false);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $responseArr = json_decode($response, true);
        if($session_type=="accessToken"){
            //Custom Session설정 : refreshToken은 2개월 보존되며, 1개월 남았을 때 갱신 가능하므로 세션이 아닌 개별 저장소에 저장하는 것이 좋음
            if(isset($responseArr['access_token'])){
                $_SESSION["kakao_access_token"] = $responseArr['access_token'];
            }
            if(isset($responseArr['refresh_token'])){
                $_SESSION["kakao_refresh_token"] = $responseArr['refresh_token'];
            }
        }
        if($session_type=="profile"){
            //Custom Session설정
            if(isset($responseArr['id'])){
                $_SESSION["kkouser"] = $responseArr;
            }
        }

        return $this->rtn($responseArr, $status_code);
    }
}
