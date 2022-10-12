<?php
/**
 * Asset Manager
 * 
 * 애셋 매니저는 솔루션의 프론트엔드에서 사용되는 스크립트나 스타일시트를 관리합니다.
 * 
 * Copyright (C) Gabia C&S Inc. All Rights Reserved.
 *
 * @category   Admin
 * @package    Firstmall
 * @author     Keunhwan Kim <kgh@gabiacns.com>
 * @copyright  2020 Gabia C&S
 */

namespace App\Libraries;

use App\Libraries\BuildInfo;

const CACHE_KEY_USE_COMMIT_ID = 0x1;
const CACHE_KEY_USE_RANDOM = 0x2;

class AssetManager {
    protected static $now = -1;
    protected static $files = [
        'scripts' => [],
        'styles' => [],
    ];
    protected static $handlers = [
        'scripts' => '<script src="%s"></script>',
        'styles' => '<link rel="stylesheet" type="text/css" href="%s">',
        'h2scripts' => '<%s>; as=script; rel=preload',
        'h2styles' => '<%s>; as=style; rel=preload',
    ];
    protected static $extensions = [
        '.js' => 'scripts',
        '.css' => 'styles',
    ];
    protected static $shutdown_installed = false;
    protected static $__cache_key_cache = [];

    public static function add(string $url, int $priority = PHP_INT_MAX, int $cache_key_type = CACHE_KEY_USE_COMMIT_ID) {
        if(!static::$shutdown_installed) {
            register_shutdown_function(static::class.'::shutdown');
            static::$shutdown_installed = true;
        }
        $path = parse_url($url, PHP_URL_PATH);
        $extension = substr($path, strrpos($path, '.'));
        if(!isset(static::$extensions[$extension])) throw new \UnexpectedValueException($extension);
        static::$files[static::$extensions[$extension]][$url] = [
            'url' => $url,
            'cache_key' => static::get_cache_key($cache_key_type),
            'priority' => $priority,
        ];
    }

    public static function create_html() {
        $tags = [];
        $h2links = [];
        foreach(static::$files as $type => &$files) {
            uasort($files, $cmp=function($a, $b, $field='priority')use(&$cmp) {
                if($a[$field] === $b[$field]) return $cmp($a, $b, 'url');
                return $a[$field] < $b[$field] ? -1 : 1;
            });
            foreach($files as $url => $file) {
                $tags[] = sprintf(static::$handlers[$type], $url.'?v='.$file['cache_key']);
                $h2links[] = sprintf(static::$handlers['h2'.$type], $url.'?v='.$file['cache_key']);
            }
            $files = [];
        }
        header('Link: '.implode(', ', $h2links));
        return implode('', $tags);
    }

	/**
	 * developemnt 버전도 상관없이 사용함
	 * 패치 시 반드시 js 캐시가 갱신되어야 하는 경우
	 * build_info.json 업데이트 필요
	 */
	protected static function get_cache_key(int $cache_key_type) {

		if (empty(static::$__cache_key_cache[$cache_key_type])) {
			if ($cache_key_type & CACHE_KEY_USE_COMMIT_ID) {
				static::$__cache_key_cache[$cache_key_type] = static::get_cache_key_commit_id();
			} elseif ($cache_key_type & CACHE_KEY_USE_RANDOM) {
				static::$__cache_key_cache[$cache_key_type] = static::get_cache_key_random();
			}
		}
		return static::$__cache_key_cache[$cache_key_type];
	}

    protected static function get_cache_key_commit_id() {
        return substr(BuildInfo::get()->build_commit_id, 0, 20);
    }

    protected static function get_cache_key_random() {
        return bin2hex(random_bytes(10));
    }

    public static function shutdown() {
        foreach(static::$files as $type => &$files) {
            if(count($files)>0)
                throw new \AssertionError('AssetManager: Output queue is not empty. May some required files not sent correctly.');
        }
    }
}
