<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/order/_kicc_nax_iframe.html 000007553 */  $this->include_("defaultScriptFunc");
$TPL_param_1=empty($TPL_VAR["param"])||!is_array($TPL_VAR["param"])?0:count($TPL_VAR["param"]);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<title>kicc webpay 가맹점 page</title>
<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>
<?php echo defaultScriptFunc()?></head>
<body>
    <form name="frm" method="post" action="<?php echo $TPL_VAR["action_url"]?>"> <!-- 테스트 -->
        <input type="hidden" id="EP_charset"          name="EP_charset"         value="UTF-8" />
        <input type="hidden" id="sp_charset"          name="sp_charset"         value="UTF-8" />

<?php if($TPL_param_1){foreach($TPL_VAR["param"] as $TPL_K1=>$TPL_V1){?>
	<input type='hidden' name="<?php echo $TPL_K1?>" id="<?php echo $TPL_K1?>" value="<?php echo $TPL_V1?>"/>
<?php }}?>

    <!--form name="frm" method="post" action="https://pg.easypay.co.kr/webpay/MainAction.do"--> <!-- 운영 -->
	    <!--
        <input type="hidden" id="EP_mall_id"          name="EP_mall_id"         value="<?=$_POST["EP_mall_id"] ?>" />
        <input type="hidden" id="EP_pay_type"         name="EP_pay_type"        value="<?=$_POST["EP_pay_type"] ?>" /> 
        <input type="hidden" id="EP_currency"         name="EP_currency"        value="<?=$_POST["EP_currency"] ?>" />
        <input type="hidden" id="EP_order_no"         name="EP_order_no"        value="<?=$_POST["EP_order_no"] ?>" />
        <input type="hidden" id="EP_product_nm"       name="EP_product_nm"      value="<?=$_POST["EP_product_nm"] ?>" /> 
        <input type="hidden" id="EP_product_amt"      name="EP_product_amt"     value="<?=$_POST["EP_product_amt"] ?>" /> 
        <input type="hidden" id="EP_return_url"       name="EP_return_url"      value="<?=$_POST["EP_return_url"] ?>" />
        <input type="hidden" id="EP_quota"            name="EP_quota"           value="<?=$_POST["EP_quota"] ?>" />
        <input type="hidden" id="EP_mall_nm"          name="EP_mall_nm"         value="<?=$_POST["EP_mall_nm"] ?>" />
        <input type="hidden" id="EP_ci_url"           name="EP_ci_url"          value="<?=$_POST["EP_ci_url"] ?>" />
        <input type="hidden" id="EP_lang_flag"        name="EP_lang_flag"       value="<?=$_POST["EP_lang_flag"] ?>" />
        <input type="hidden" id="EP_charset"          name="EP_charset"         value="<?=$_POST["EP_charset"] ?>" />
        <input type="hidden" id="EP_user_id"          name="EP_user_id"         value="<?=$_POST["EP_user_id"] ?>" />
        <input type="hidden" id="EP_memb_user_no"     name="EP_memb_user_no"    value="<?=$_POST["EP_memb_user_no"] ?>" />
        <input type="hidden" id="EP_user_nm"          name="EP_user_nm"         value="<?=$_POST["EP_user_nm"] ?>" />
        <input type="hidden" id="EP_user_mail"        name="EP_user_mail"       value="<?=$_POST["EP_user_mail"] ?>" />
        <input type="hidden" id="EP_user_phone1"      name="EP_user_phone1"     value="<?=$_POST["EP_user_phone1"] ?>" />
        <input type="hidden" id="EP_user_phone2"      name="EP_user_phone2"     value="<?=$_POST["EP_user_phone2"] ?>" />
        <input type="hidden" id="EP_user_addr"        name="EP_user_addr"       value="<?=$_POST["EP_user_addr"] ?>" />
        <input type="hidden" id="EP_user_define1"     name="EP_user_define1"    value="<?=$_POST["EP_user_define1"] ?>" />
        <input type="hidden" id="EP_user_define2"     name="EP_user_define2"    value="<?=$_POST["EP_user_define2"] ?>" />
        <input type="hidden" id="EP_user_define3"     name="EP_user_define3"    value="<?=$_POST["EP_user_define3"] ?>" />
        <input type="hidden" id="EP_user_define4"     name="EP_user_define4"    value="<?=$_POST["EP_user_define4"] ?>" />
        <input type="hidden" id="EP_user_define5"     name="EP_user_define5"    value="<?=$_POST["EP_user_define5"] ?>" />
        <input type="hidden" id="EP_user_define6"     name="EP_user_define6"    value="<?=$_POST["EP_user_define6"] ?>" />
        <input type="hidden" id="EP_product_type"     name="EP_product_type"    value="<?=$_POST["EP_product_type"] ?>" />
        <input type="hidden" id="EP_product_expr"     name="EP_product_expr"    value="<?=$_POST["EP_product_expr"] ?>" />
        <input type="hidden" id="EP_usedcard_code"    name="EP_usedcard_code"   value="<?=$_POST["EP_usedcard_code"] ?>" />
        <input type="hidden" id="EP_os_cert_flag"     name="EP_os_cert_flag"    value="<?=$_POST["EP_os_cert_flag"] ?>" />
        <input type="hidden" id="EP_noinst_flag"      name="EP_noinst_flag"     value="<?=$_POST["EP_noinst_flag"] ?>" />
        <input type="hidden" id="EP_noinst_term"      name="EP_noinst_term"     value="<?=$_POST["EP_noinst_term"] ?>" />
        <input type="hidden" id="EP_vacct_bank"       name="EP_vacct_bank"      value="<?=$_POST["EP_vacct_bank"] ?>" />
        <input type="hidden" id="EP_vacct_end_date"   name="EP_vacct_end_date"  value="<?=$_POST["EP_vacct_end_date"] ?>" />
        <input type="hidden" id="EP_vacct_end_time"   name="EP_vacct_end_time"  value="<?=$_POST["EP_vacct_end_time"] ?>" />
        <input type="hidden" id="EP_prepaid_cp"       name="EP_prepaid_cp"      value="<?=$_POST["EP_prepaid_cp"] ?>" />
        <input type="hidden" id="EP_kmotion_useyn"    name="EP_kmotion_useyn"   value="<?=$_POST["EP_kmotion_useyn"] ?>" />
        <input type="hidden" id="EP_disp_cash_yn"     name="EP_disp_cash_yn"    value="<?=$_POST["EP_disp_cash_yn"] ?>" />
        <input type="hidden" id="EP_cert_type"        name="EP_cert_type"       value="<?=$_POST["EP_cert_type"] ?>" /> 
        -->
        <!-- 복합과세 부분 -->
		<!--
        <input type="hidden" id="EP_tax_flg"          name="EP_tax_flg"         value="<?=$_POST["EP_tax_flg"] ?>"        />
        <input type="hidden" id="EP_com_tax_amt"      name="EP_com_tax_amt"     value="<?=$_POST["EP_com_tax_amt"] ?>"    />
        <input type="hidden" id="EP_com_free_amt"     name="EP_com_free_amt"    value="<?=$_POST["EP_com_free_amt"] ?>"   />
        <input type="hidden" id="EP_com_vat_amt"      name="EP_com_vat_amt"     value="<?=$_POST["EP_com_vat_amt"] ?>"    />
		-->
    </form>
</body>

<script>
$(document).ready(function(){
		// , 'EP_return_url' 한글 URL인 경우 KICC에서 별도처리를 해야하기 때문에 현재는 인코디에서 제외
		var encode_list = [
			'EP_product_nm', 'EP_mall_nm', 'EP_user_nm', 'EP_user_addr', 'EP_recv_nm'		// PC
			, 'sp_product_nm', 'sp_mall_nm', 'sp_user_nm', 'sp_user_addr', 'sp_recv_nm'		// Mobile
		];
        var frm_pay = document.frm;
        /* UTF-8 사용가맹점의 경우 EP_charset 값 셋팅 필수 */
        if( frm_pay.EP_charset.value == "UTF-8" )
        {
			for(var i in encode_list){
				// 한글이 들어가는 값은 모두 encoding 필수.
				var $el = $("#"+encode_list[i]);
				if($el.length==1){
					var val = $el.val();
					var encodeVal = encodeURIComponent(val);
					$el.val(encodeVal);
				}
			}
        }
        frm_pay.submit();
});
</script>
</html>