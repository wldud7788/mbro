<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 방송 편성표 관련 소스에서 사용하는 함수 모음
 */

if(function_exists('getDateFormat') === false ) {

    /**
     * 날짜 포맷으로 변환한다.
     * @param string $date : YYYY-mm-dd
     * @param string $meri : [am,pm]
     * @param unknown $hour : 0 ~11
     * @param unknown $min : 0 ~ 59
     */
    function convertDateFormat($date, $meri, $hour, $min, $format = "Y-m-d H:i:s") {
        if($meri === 'pm') {
            $hour += 12;
        }
        return date($format, strtotime($date . " " . $hour . ":".$min .":". '00'));
    }

}

if(function_exists('getGoodsParam') === false) {
    /**
     * crateBroadcast, modifyBroadcast 에서 사용하는 함수로,
     * 상품번호, 메인상품번호 값을 받아서 insert 가능한 배열로 변환한다.
     *
     * @param number $goodsSeq
     * @param number $main
     * @return array
     */
    function getGoodsParam($goodsSeq, $main) {
        $goodsParam = array();
        $goodsParam['goods_seq'] = $goodsSeq;
		$goodsParam['main'] = $main == $goodsSeq ? '1' : '0';
		$goodsParam['regist_date'] = date("Y-m-d H:i:s");

		return $goodsParam;
    }
}

if(function_exists('getMaskingText') === false) {

    /**
     * 첫째글자, 마지막글자만 남기고 나머지는 * 로 치환 처리하여 반환한다.
     * @param string $text
     * @return string
     */
    function getMaskingText($text) {
        $pattern = '/[가-힣|ㄱ-ㅎ|ㅏ-ㅣ|A-Za-z|0-9]/u';
        $result = preg_match_all($pattern, $text, $matches, PREG_PATTERN_ORDER);
        $str = '';
        for($i=0; $i<=$result-3; $i++) {
            $str .= '*';
        }
        return $matches[0][0].$str.$matches[0][$result-1];
    }
}

/*
* 추후 오픈되는 기능들을 위하여 버전 체크 필요
* @param string $version
* @return bool
*/
function isBroadcastVersion($version, $diff="is") {
	$result = false;

	$cfg_broadcast 	= config_load('broadcast');
	$cfg_version 	= $cfg_broadcast['version'];
	switch($diff) {
		case "is" :
			if($cfg_version == $version) {
				$result = true;
			}
		break;
		case "exeed" : // 초과
			if($cfg_version > $version) {
				$result = true;
			}
		break;
		case "more" : // 이상
			if($cfg_version >= $version) {
				$result = true;
			}
		break;
	}


	return $result;
}

/**
* 현재 broadcast 사용중인지 체크
*/
function isBroadcastUse() {
	$cfg_broadcast = config_load('broadcast');

	$use = false;
	if(isset($cfg_broadcast['username']) && isset($cfg_broadcast['password'])) {
		if($cfg_broadcast['status'] == '1') {
			$use = true;
		}
	}

	return $use;
}

/**
* broadcast config 리턴
*/
function getBroadcastConf() {
	$cfg_broadcast = config_load('broadcast');
	return $cfg_broadcast;
}

/**
* broadcast config 저장
*/
function setBroadcastConf($data) {
	foreach($data as $codecd=>$value){
		config_save('broadcast',array($codecd=>$value));
	}
}

/**
* broadcast 정보가 맞는지 리턴
*/
function isSecretKeyCorrect($secretKey)
{
	$cfgSecretkey = array_pop(config_load('broadcast','secret_key'));

	if(empty($secretKey) || empty($cfgSecretkey)) {
		return false;
	}
	return ($secretKey == $cfgSecretkey) ? true : false;
}

function broadcastlist(&$result, $no=null) {
	$CI =& get_instance();
	foreach($result as &$record){
		$record['rno'] = $no;
		$no--;

		// 대표 상품
		$goodsInfoMain = $CI->broadcastmodel->getBroadcastGoods($record['bs_seq'], array('main'=>'1'));
		// 연결된 상품 개수
		$goodsInfo = $CI->broadcastmodel->getBroadcastGoods($record['bs_seq'], array());

		$record['goods_name'] = $goodsInfoMain['0']['goods_name'];
		$record['goods_seq'] = $goodsInfoMain['0']['goods_seq'];
		$record['goods_img'] = viewImg($goodsInfoMain['0']['goods_seq'],'view','N');
		$record['goods_price'] = get_currency_price($goodsInfoMain['0']['default_price'], 4);

		$record['sale_rate'] = 0;
		if((int)$goodsInfoMain['0']['default_consumer_price'] > (int)$goodsInfoMain['0']['default_price']) {
			$record['sale_rate'] = 100 - floor(( $goodsInfoMain['0']['default_price'] / $goodsInfoMain['0']['default_consumer_price'] ) * 100);
		}

		if(count($goodsInfo) > 1) {
			$record['goods_name_full'] = $record['goods_name']." 외 ".(count($goodsInfo)-1)."개";
		} else if(count($goodsInfo) == 1) {
			$record['goods_name_full'] = $record['goods_name'];
		} else if(count($goodsInfo) == 0) {
			$record['goods_name_full'] = '';
		}

		$record['real_time'] = '00:00:00';
		if($record['real_start_date'] && $record['real_end_date']) {
			$real_time = date_diff(date_create($record['real_end_date']),date_create($record['real_start_date']));
			$record['real_time'] = str_pad($real_time->h,2,0,STR_PAD_LEFT).":".str_pad($real_time->i,2,0,STR_PAD_LEFT).":".str_pad($real_time->s,2,0,STR_PAD_LEFT);
		}

		// 다운로드 링크
		$record['download'] = '';
		if($record['vod_key']) {
			$record['download'] = "https://vod.firstmall.kr/download/".$record['vod_key'];
		}

		// 날짜
		$record['start_date_txt'] = date("Y년 m월 d일 H시 i분",strtotime($record['start_date']));
		//상태 값 가공
		$record['status_txt'] = $CI->broadcastmodel->cfg_status[$record['status']];
		// 이미지 수정 시 초기화 필요
		$record['image'] .= "?dummy=".time();
		// 2차 개발 시 providerInfo
		$record['provider_name'] = '본사';
		// 모바일앱인 경우 본창 그외는 새창
		$record['link_target'] = '_blank';
		if($CI->_is_mobile_app_agent) {
			$record['link_target'] = '_self';
		}

	}
}

// 만료일 체크
function isExpiredBroadcast() {
	$expire_date = array_pop(config_load('broadcast','expire_date'));

	return $expire_date < date('Y-m-d');
}