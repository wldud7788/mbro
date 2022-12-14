<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/main/_main_notify_popup.html 000007147 */ ?>
<style>
#notify_popup table {width:550px; margin:auto;}
#notify_popup table td {height:55px; padding: 10px 0; border-bottom:1px solid #ededed}
#notify_popup table td p{padding: 5px 0 0 15px}
#main_notify_icon_fb {margin:5px 10px 5px 3px; background:url('/admin/skin/default/images/main/facebook_icon.png') no-repeat; width:91px; height:91px; display:inline-block;}
#main_notify_icon_sms_sender {margin:5px 10px 5px 3px; background:url('/admin/skin/default/images/main/sms_sender_use_icon.png') no-repeat; width:91px; height:91px; display:inline-block;}
#main_notify_icon_sms {margin:5px 10px 5px 3px; background:url('/admin/skin/default/images/main/sms_charge_icon.png') no-repeat; width:91px; height:91px; display:inline-block;}
#main_notify_icon_ad {margin:5px 10px 5px 3px; background:url('/admin/skin/default/images/main/auto_deposit_icon.png') no-repeat; width:91px; height:91px; display:inline-block;}
#main_notify_icon_gf {margin:5px 10px 5px 3px; background:url('/admin/skin/default/images/main/goodsflow_use_icon.png') no-repeat; width:91px; height:91px; display:inline-block;}
#main_notify_icon_quarter {margin:5px 10px 5px 3px; background:url('/admin/skin/default/images/main/disk_quarter_icon.png') no-repeat; width:91px; height:91px; display:inline-block;}
</style>

<script>	
	$('#close_btn').bind('click', function()
	{
		closeDialog("notify_popup");		
		if($('#open_limit_check').is(":checked")) setCookie("isChk","Y",1);		
	});
</script>

<table border="0" cellpadding="0" cellspacing="0">
<col width="91" /><col /><col width="60" />

<?php if($TPL_VAR["return"]["space_percent"]>= 90&&$TPL_VAR["service_code"]!="F_SH_X"){?>
<tr>
<td class="left"><span id="main_notify_icon_quarter"></span></td>
<td>
	<strong>[용량]</strong><br/><br/>
	<strong><span class="red"><?php echo $TPL_VAR["return"]["space_percent"]?>%</span>의</strong> 디스크 용량을 사용중입니다.<br/>
	<strong>100% 초과 시</strong> 아래의 기능이 제한됩니다.<br/>
	<p>- <strong>상품 등록/수정 제한</strong><br/>(일괄 업데이트, 엑셀 등록/수정 포함)<br/></p>
	<p>- FTP 접속 후 <strong>파일 업로드 제한</strong></p>
</td>
<td class="center"><span class="btn medium"><a href="https://firstmall.kr/myshop" target="_blank">추가</a></span></td>
</tr>
<tr>
	<td colspan="3" style="height:0; text-align:right; padding-right:10px;">
		<input type="checkbox" id="open_limit_check" /> <label for="open_limit_check">오늘 하루 열지 않음</label> | <a href="#" id="close_btn">닫기</a> 
	</td>
</tr>
<?php }?>

<?php if($TPL_VAR["return"]["send_sms"]){?>
<tr>
<td class="left"><span id="main_notify_icon_sms"></span></td>
<td style="padding:15px 0;">
	<span class="red">발신번호가 인증되지 않았습니다.<br />
	2015년 10월 16일부터 자동발송 포함해서 모든 SMS 전송이<br /> 차단됩니다.<br /><br />
	반드시 발신번호를 인증해 주세요
	</span><br /><br />
	발신번호 인증은 가비아 로그인 후 마이퍼스트몰에서 할 수<br /> 있습니다 <span class="btn small orange"><button type="button" onclick="openDialog('발신번호 인증 안내','smsMyFirstmallInfo',{'width':850,'height':830});">안내) 발신번호 인증방법</button></span>
	<br /><br />
	※ 발신번호 인증이란?<br />
	전기통신사업법 제 84조 의해 거짓으로 표시된 전화번호로 인한 이용자들의 피해를 예방하고자 인증된 발신번호로만 SMS를<br /> 보낼 수 있으며, 사전에 인증하지 않은 번호로는 SMS를 보낼 수<br /> 없습니다.
</td>
<td class="center"><span class="btn medium"><a href="https://firstmall.kr/myshop/sms/sms_send_phone.php?num=<?php echo $TPL_VAR["config_system"]["shopSno"]?>" target="_blank">발신번호 인증</a></span></td>
</tr>
<?php }?>

<?php if($TPL_VAR["return"]["remain_sms"]){?>
<tr>
<td class="left"><span id="main_notify_icon_sms"></span></td>
<td>문자 충전을 알려 드립니다.<br />(잔여건수 : <?php echo number_format($TPL_VAR["return"]["remain_sms"])?>통)</td>
<td class="center"><span class="btn medium"><a href="/admin/member/sms_charge" target="_blank">충전</a></span></td>
</tr>
<?php }?>

<?php if($TPL_VAR["return"]["remain_autodeposit"]){?>
<tr>
<td class="left"><span id="main_notify_icon_ad"></span></td>
<td>무통장 자동입금확인서비스 연장을 알려 드립니다. <br />(만료일자 : <?php echo date('Y/m/d',strtotime($TPL_VAR["return"]["remain_autodeposit"]))?>)</td>
<td class="center"><span class="btn medium"><a href="/admin/setting/bank" target="_blank">연장</a></span></td>
</tr>
<?php }?>

<?php if($TPL_VAR["return"]["remain_goodsflow"]){?>
<tr>
<td class="left"><span id="main_notify_icon_gf"></span></td>
<td>택배자동(굿스플로) 서비스 충전을 알려 드립니다.<br />(잔여건수 : <?php echo number_format($TPL_VAR["return"]["remain_goodsflow"])?>통)</td>
<td class="center"><span class="btn medium"><a href="#">충전</a></span></td>
</tr>
<?php }?>

<?php if($TPL_VAR["return"]["epost_complete"]=='Y'){?>
<tr>
<td class="left"><span id="main_notify_icon_gf"></span></td>
<td colspan="2">
	<br/>
	축하드립니다!<br/>
	우체국택배 업무 자동화 서비스 연동이 모두 완료되었습니다.<br/><br/>
	주문상태를 ‘출고완료’로 변경하면,<br/>
	자동으로 운송장 번호가 할당되며 우체국택배 시스템으로 출고정보가 전송됩니다.<br/>
	배송상태도 자동으로 업데이트 되오니 운영에 참고하시기 바랍니다.<br/><br/>
	※ 단, 운송장출력은 우체국택배 관리자(<a href="https://biz.epost.go.kr" target="_blank">biz.epost.go.kr</a>)에서 진행하세요.

	<br/><br/><br/>
	<div style="margin-left:120px;">
	<span class="btn medium"><a href="/admin/setting/shipping">배송설정 바로가기</a></span>
	</div>
</td>
</tr>
<?php }?>

<?php if($TPL_VAR["return"]["ssl_notify"]=='Y'){?>
<tr>
<td class="left"><span id="main_notify_icon_sms"></span></td>
<td>
	<strong>[보안서버 확인요청]</strong><br/>
	<strong><span class="red"> - SSL인증서(유료/무료)가 신청 및 설치가 되지 않았습니다.</span></strong><br/>
	<strong><span class="red"> - SSL인증서(유료/무료) 미 설치 시 솔루션기능이 정상적으로 동작하지 않을 수 있으니 반드시 보안서버인증서를 신청하여 주시기 바랍니다.</span></strong><br/>
	<br/>
	<span class="btn medium"><a href="/admin/setting/protect">보안서버 인증서 확인</a></span>
	<br/>
	<br/>

	<strong>※ 보안서버 구축 의무화</strong><br/>
	<p>2012년 8월 18일 정보통신망법 개정으로 개인 정보를 취급하는 모든 웹사이트의 보안서버 구축이 의무화되었습니다. (위반 시 최대 3천만 원의 과태료가 부과되므로 반드시 인증서를 신청하시기 바랍니다.)</p>
</td>
</tr>
<?php }?>
</table>