<?php
/**
 * Internal API for Admin Board
 *
 * 게시판 설정에서 내부적으로 사용되는 API를 정의합니다.
 * 
 * Copyright (C) Gabia C&S Inc. All Rights Reserved.
 *
 * @category   Admin
 * @package    Firstmall
 * @author     Keunhwan Kim <kgh@gabiacns.com>
 * @copyright  2020 Gabia C&S
 */

namespace App\Libraries\Http;

use \InvalidArgumentException;
use \UnexpectedValueException;

class Request {
    protected static $method = null;
    public static function initialize() {}

    public static function get(string $name) {
        if(!isset($_GET[$name])) throw new InvalidArgumentException;
        return $_GET[$name];
    }

    public static function post(string $name) {
        if(!isset($_POST[$name])) throw new InvalidArgumentException;
        return $_POST[$name];
    }

    public static function json() {
        $body = file_get_contents('php://input');
        if(empty($body)) throw new UnexpectedValueException;
        $parsed_body = json_decode($body);
        if($parsed_body === null) throw new UnexpectedValueException;
        return $parsed_body;
    }

    public static function method(string $test = null) {
        if(is_null(static::$method)) {
            static::$method = strtolower($_SERVER['REQUEST_METHOD']);
        }

        if(is_string($test))
            return static::$method === strtolower($test);

        return static::$method;
    }
}

Request::initialize();
