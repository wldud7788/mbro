<?php

namespace App\Libraries\Http;

use ReflectionClass, Exception;

class JsonResponse {
    public static $content_type = 'text/json';
    public static $charset = 'utf-8';

    /**
     * 오류 응답을 반환하고 스크립트를 종료합니다.
     * 
     * @param Exception $ex 
     * @return string
     */
    public static function error(Exception $ex, int $status = 400) {
        $error = [
            'error' => (new ReflectionClass($ex))->getShortName(),
            'message' => $ex->getMessage(),
        ];
        static::response($status, $error);
        exit;
    }

    /**
     * 정상적으로 처리되었다는 응답을 반환합니다.
     * 
     * @param array|object $object 
     * @return string
     */
    public static function ok($object = null) {
        static::response(200, $object);
    }

    /**
     * 응답을 반환합니다.
     * 
     * @param array|object $object 
     * @return string
     */
    public static function response(int $status, $object = null) {
        $sent = headers_sent();

        if($status===200 && is_null($object)) {
            if(!$sent) http_response_code(204);
            return;
        }

        if(!$sent) http_response_code($status);

        if(!is_null($object)) {
            if(!$sent) static::set_content_type();
            echo static::toJsonString($object);
        }
    }

    /**
     * 배열이나 객체를 JSON 문자열로 변환합니다.
     * 
     * @param array|object $object 
     * @return string
     */
    protected static function toJsonString($object): string {
        $options = JSON_UNESCAPED_UNICODE;
        if(ENVIRONMENT === 'development') $options |= JSON_PRETTY_PRINT;
        return json_encode($object, $options);
    }

    /**
     * Content-Type Http 헤더를 설정합니다.
     */
    protected static function set_content_type() {
        @header('Content-Type: '.static::$content_type.'; charset='.static::$charset);
    }
}
