<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Composer load
require_once(ROOTPATH.'vendor/autoload.php');

// JWT
use \Firebase\JWT\JWT;
use \InvalidArgumentException;
use \UnexpectedValueException;
use \Firebase\JWT\SignatureInvalidException;
use \Firebase\JWT\BeforeValidException;

class jwtmodel extends CI_Model
{
    /**
     * 쇼핑몰 고유 번호
     * @var int
     */
    private $shopSno = null;
    
    public function __construct()
    {
        parent::__construct();
        
        // config_system이 없으면 정보를 다시 불러온다.
        if(empty($this->config_system['shopSno'])) {
            $this->load->helper("basic");
            $this->load->helper("common");
            get_base_config_system();
        }
        $this->shopSno = $this->config_system['shopSno'];
    }
    
    /**
     * client_id, secret_key 를 생성한다.
     * @param string $id
     * @return []
     */
    public function credential($id)
    {
        $auth = array();
        $auth['client_id'] = $id;
        $auth['secret_key'] = bin2hex(openssl_random_pseudo_bytes(32));
        return $auth;
    }
    
    /**
     * payload 데이터를 대입하여 accessToken을 생성한다.
     * @param array $payload
     * @return string
     */
    public function createToken($payload)
    {
        $now = time();
        if(!isset($payload) || !is_array($payload)) {
            $payload = array();
        }
        $payload['iat'] = $now;
        $payload['exp'] = $now + (60*60*1);
        $payload['iss'] = $this->input->server("HTTP_HOST");
        $payload['jti'] = bin2hex(openssl_random_pseudo_bytes(6));
        $token = $this->createAccessToken($payload);
        return $token;
    }
    
    /**
     * Access Token을 변환하여 반환한다.
     * @param unknown $token
     * @throws Exception
     */
    public function decodeToken($token)
    {
        if(empty($token)) {
            throw new Exception("token_not_provided|인증이 필요합니다.", 401);
        }
        $key = get_jwt_key();
        try {
            $payload = JWT::decode($token, $key, array('HS256'));
        } catch(InvalidArgumentException $e) {
            if(ENVIRONMENT === 'development') {
                throw new Exception("internal_server_error|" .  $e->getMessage(), 500);
            }
            throw new Exception(null, 500);
        } catch(UnexpectedValueException $e) {
            throw new Exception("token_unexpected|".(ENVIRONMENT==='development'?$e->getMessage():"인증에 실패하였습니다."),401);
        } catch(SignatureInvalidException $e) {
            throw new Exception("token_unexpected|".(ENVIRONMENT==='development'?$e->getMessage():"인증에 실패하였습니다."),401);
        } catch(BeforeValidException $e) {
            throw new Exception("token_not_before|".(ENVIRONMENT==='development'?$e->getMessage():"사용할 수 없는 토큰입니다."),401);
        } catch(ExpiredException $e) {
            throw new Exception("token_expired|".(ENVIRONMENT==='development'?$e->getMessage():"토큰의 유효 기간이 만료되었습니다."),401);
        } catch(Exception $e) {
            if(ENVIRONMENT === 'development') {
                throw new Exception("internal_server_error|" .  $e->getMessage(), 500);
            }
            throw new Exception(null, 500);
        }
        return $payload;
    }
    
    /**
     * Access Token을 생성한다.
     * @param array $payload
     * @return string
     */
    private function createAccessToken($payload)
    {
        $key = get_jwt_key();
        return JWT::encode($payload, $key);
    }
    
}