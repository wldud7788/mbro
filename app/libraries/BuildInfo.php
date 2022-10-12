<?php
/**
 * Build Info
 * 
 * Build Info는 솔루션의 빌드 정보를 제공합니다.
 * 
 * Copyright (C) Gabia C&S Inc. All Rights Reserved.
 *
 * @category   Libraries
 * @package    Firstmall
 * @author     Keunhwan Kim <kgh@gabiacns.com>
 * @copyright  2020 Gabia C&S
 */

namespace App\Libraries;

use App\Libraries\FileSystem\FileNotExistsException;

class BuildInfo {
    const default_info = [
        'build_branch' => null,
        'build_commit_id' => null,
    ];
    protected static $build_info;

    public static function get() {
        if(empty(static::$build_info)) {
            try {
                static::load();
            } catch(FileNotExistsException $ex) {
                static::$build_info = (object)static::default_info;
            }
        }

        return static::$build_info;
    }

    public static function load($path = ROOTPATH.'/build_info.json') {
        if(!is_file($path)) throw new FileNotExistsException;
        static::$build_info = (object)((array)json_decode(file_get_contents($path)) + static::default_info);
    }
}
