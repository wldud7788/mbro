<?php
/**
 * 퍼스트몰 "운영환경 변경"시 기존 시스템과 호환을 위해서 사용되는 파일 입니다
 *
 * 이 파일은 비정기적으로 "덮어 씌워지기 때문에", 퍼스트몰 허가없이 소스를 수정하면 안됩니다.
 */

/**
 * apache prefork + mod_php 에서 apache event + fpm 변경시 호환 되는 함수
 */
if (!function_exists('getallheaders')) {
	function getallheaders()
	{
		$arh = [];
		$rx_http = '/\AHTTP_/';
		foreach ($_SERVER as $key => $val) {
			if (preg_match($rx_http, $key)) {
				$arh_key = preg_replace($rx_http, '', $key);
				$rx_matches = [];
				// do some nasty string manipulations to restore the original letter case
				// this should work in most cases
				$rx_matches = explode('_', $arh_key);
				if (count($rx_matches) > 0 and strlen($arh_key) > 2) {
					foreach ($rx_matches as $ak_key => $ak_val) {
						$rx_matches[$ak_key] = ucfirst($ak_val);
					}
					$arh_key = implode('-', $rx_matches);
				}
				$arh[$arh_key] = $val;
			}
		}

		return($arh);
	}
}
