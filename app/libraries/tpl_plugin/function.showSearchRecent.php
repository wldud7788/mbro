<?php
function showSearchRecent(){
	$CI =& get_instance();
	$CI->load->model('statsmodel');
	$sIp			= $_SERVER['REMOTE_ADDR'];
	$sMemberSeq		= $CI->userInfo['member_seq'];
	$iLimit			= 10;
	$iPoNum			= 0;
	$aKeyword		= array();
	$rQuery	= $CI->statsmodel->getSearchRecent($sIp, $sMemberSeq, $iLimit);
	foreach($rQuery->result_array() as $aData){
		$result[]	= $aData;
		$aKeyword[] = $aData['keyword'];
	}
	// 최근 검색어가 5개 미만일 경우 인기 검색어 조회
	if(count($result) < 5){
		$sTimestamp	= strtotime('-30day');
		$sEnd		= date('Y-m-d', $sTimestamp);
		$query		= $CI->statsmodel->getSearchPopular($sEnd); // 최근 30일 내의 500개의 검색어 중 검색 순위 높은 순으로 10개 조회
		foreach ($query->result_array() as $row){
			if( !in_array($row['keyword'], $aKeyword) && $iPoNum < 5 ){ // 중복 제거 후 5개 선별
				$result[] = $row;
				$iPoNum++;
			}
		}
	}
	return $result;
}
?>