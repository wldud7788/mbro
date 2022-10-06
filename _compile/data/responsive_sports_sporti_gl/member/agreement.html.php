<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/member/agreement.html 000013333 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 회원가입 > 약관동의 @@
- 파일위치 : [스킨폴더]/member/agreement.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<style>
	.selection{display:inline-block;padding:10px 9px; color:#333;}
	.selection>li{margin-left: 40px;}
</style>
<?php echo $TPL_VAR["is_file_kakao_tag"]?>

<!-- 타이틀 -->
<div class="title_container">
	<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >약관 동의</span></h2>
</div>

<div class="resp_login_wrap Mt0">
	<form name="agreeFrm" id="agreeFrm" target="actionFrame" method="post" action="../member_process/register">
	<input type="hidden" name="join_type" value="<?php echo $TPL_VAR["join_type"]?>"/>
	<input type="hidden" name="kid_agree" value="">
		<div class="mem_agree_area">
			<label id="pilsuAgreeAll" class="pilsu_agree_all"><input type="checkbox"> <span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >약관 전체 동의</span></label>
			<ul id="agreeList" class="agree_list3">
				<li class="agree_section">
					<a class="agree_view" href="javascript:void(0)" onclick="showCenterLayer('#agreementDeatilLayer')"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >보기</span></a>
					<label><input type="checkbox" name="agree" value="Y" class="pilsu" > <span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >쇼핑몰 이용약관</span> <span class="desc pointcolor4 imp" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >(필수)</span></label>
				</li>
				<li class="agree_section">
					<a class="agree_view" href="javascript:void(0)" onclick="showCenterLayer('#privacyDeatilLayer')"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >보기</span></a>
					<label><input type="checkbox" name="agree2" value="Y" class="pilsu"> <span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >개인정보 수집 및 이용</span> <span class="desc pointcolor4 imp" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >(필수)</span></label>
				</li>
<?php if($TPL_VAR["joinform_optionYN"]=='Y'){?>
				<li class="agree_section">
					<a class="agree_view" href="javascript:void(0)" onclick="showCenterLayer('#joinformDeatilLayer')"><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >보기</span></a>
					<label><input type="checkbox" name="agree3" value="Y" class="pilsu"> <span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >개인정보 수집 및 이용</span> <span class="desc pointcolor4 imp" designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >(선택)</span></label>
				</li>
<?php }?>
<?php if($TPL_VAR["join_type"]=='member'&&($TPL_VAR["email_use"]=='Y'||$TPL_VAR["cellphone_use"]=='Y')){?>
				<li class="agree_section">
					<a class="agree_view" href="javascript:void(0)" onclick="showCenterLayer('#marketingDeatilLayer')"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >보기</span></a>
					<label><input type="checkbox" name="marketing" id="marketing" value="Y" class="pilsu"> <span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >마케팅 및 광고 활용 동의</span> <span class="desc pointcolor4 imp" designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >(선택)</span></label>
					<ul id="agreeList2" class="selection">
<?php if($TPL_VAR["email_use"]=='Y'){?>
						<li class="agree_section" style="float: left;margin-left: 14px;">
							<label><input type="checkbox" name="mailing" id="mailing" value="y" class="pilsu"> <span designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >이메일 수신</span></label>
						</li>
<?php }?>
<?php if($TPL_VAR["cellphone_use"]=='Y'){?>
						<li class="agree_section" style="float: left;margin-left: 14px;">
							<label><input type="checkbox" name="sms" id="sms" value="y" class="pilsu"> <span designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >SMS 수신</span></label>
						</li>
<?php }?>
					</ul>
				</li>
<?php }elseif($TPL_VAR["join_type"]=='business'&&($TPL_VAR["bemail_use"]=='Y'||$TPL_VAR["bcellphone_use"]=='Y')){?>
				<li class="agree_section">
					<a class="agree_view" href="javascript:void(0)" onclick="showCenterLayer('#marketingDeatilLayer')"><span designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >보기</span></a>
					<label><input type="checkbox" name="marketing" id="marketing" value="Y" class="pilsu"> <span designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >마케팅 및 광고 활용 동의</span> <span class="desc pointcolor4 imp" designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >(선택)</span></label>
					<ul id="agreeList2" class="selection">
<?php if($TPL_VAR["bemail_use"]=='Y'){?>
						<li class="agree_section" style="float: left;margin-left: 14px;">
							<label><input type="checkbox" name="mailing" id="mailing" value="y" class="pilsu"> <span designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >이메일 수신</span></label>
						</li>
<?php }?>
<?php if($TPL_VAR["bcellphone_use"]=='Y'){?>
						<li class="agree_section" style="float: left;margin-left: 14px;">
							<label><input type="checkbox" name="sms" id="sms" value="y" class="pilsu"> <span designElement="text" textIndex="21"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >SMS 수신</span></label>
						</li>
<?php }?>
					</ul>
				</li>
<?php }?>
			</ul>
<?php if($TPL_VAR["mtype"]=='member'&&in_array($TPL_VAR["joinform"]["kid_join_use"],array('Y','N'))){?>
				<label class="pilsu_agree_all">
					<input name="kid_agree_tmp" type="checkbox" value="Y"><span designElement="text" textIndex="22"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" ></span> 만 14세 이상입니다.
					<span class="pointcolor4" designElement="text" textIndex="23"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" ><?php if($TPL_VAR["joinform"]["kid_join_use"]=='Y'){?>(선택)<?php }elseif($TPL_VAR["joinform"]["kid_join_use"]=='N'){?>(필수)<?php }?></span>
				</label>
<?php }?>
		</div>

		<div class="btn_area_c">
			<button type="button" id="btn_submit" class="btn_resp size_c color2 Wmax"><span designElement="text" textIndex="24"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9hZ3JlZW1lbnQuaHRtbA==" >다음 단계</span></button>
		</div>
	</form>
</div>

<div id="agreementDeatilLayer" class="resp_layer_pop hide">
	<h4 class="title">쇼핑몰 이용약관</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<?php echo nl2br($TPL_VAR["policy_agreement"])?>

		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>

<div id="privacyDeatilLayer" class="resp_layer_pop hide">
	<h4 class="title">개인정보 수집 및 이용</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<?php echo nl2br($TPL_VAR["policy_joinform"])?>

		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>

<div id="joinformDeatilLayer" class="resp_layer_pop hide">
	<h4 class="title">개인정보 수집 및 이용</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<?php echo nl2br($TPL_VAR["policy_joinform_option"])?>

		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>

<div id="marketingDeatilLayer" class="resp_layer_pop hide">
	<h4 class="title">마케팅 및 광고 활용 동의</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<?php echo nl2br($TPL_VAR["policy_marketing"])?>

		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>

<script src="/app/javascript/js/skin-snslogin.js?v=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">
var return_url	= "../main/index";
<?php if($_GET["return_url"]){?>
return_url			= "<?php echo $_GET["return_url"]?>";
<?php }elseif($TPL_VAR["return_url"]){?>
return_url			= "<?php echo $TPL_VAR["return_url"]?>";
<?php }?>
var mobileapp		= "<?php echo $TPL_VAR["mobileapp"]?>";
var m_device		= "<?php echo $TPL_VAR["m_device"]?>";
var fbuserauth		= "<?php echo $TPL_VAR["fbuserauth"]?>";
var snstype			= '<?php echo substr($TPL_VAR["join_type"], 0, 2)?>';
var jointype		= '<?php echo $TPL_VAR["join_type"]?>';
var apple_authurl	= '<?php echo $TPL_VAR["apple_authurl"]?>';
</script>
<script type="text/javascript">
$(document).ready(function() {
	// 약관 전체동의
	$('#pilsuAgreeAll > input[type=checkbox]').on('change', function() {
		if ( $(this).prop('checked') ) {
			$(this).closest('.mem_agree_area').find('input[type=checkbox].pilsu').attr('checked', 'checked');
			$(this).closest('.mem_agree_area').find('input[type=checkbox].pilsu').closest('li').addClass('end');
		} else {
			$(this).closest('.mem_agree_area').find('input[type=checkbox].pilsu').removeAttr('checked');
			$(this).closest('.mem_agree_area').find('input[type=checkbox].pilsu').closest('li').removeClass('end');
		}
	});
	// 개별 약관 선택시
	$('#agreeList input[type=checkbox]').on('change', function() {
		if ( $(this).prop('checked') ) {
			$(this).closest('li').addClass('end');
		} else {
			$(this).closest('li').removeClass('end');
		}
	});

	$('#btn_submit').click(function() {
		if(jointype){
			if(!$("input[name='agree']").is(":checked")){
				//이용약관에 동의하셔야합니다.
				alert(getAlert('mb001'));
				return false;
			}
			if(!$("input[name='agree2']").is(":checked")){
				//개인정보처리방침에 동의하셔야합니다.
				alert(getAlert('mb261'));
				return false;
			}
		}

<?php if(!$TPL_VAR["join_type"]||$TPL_VAR["join_type"]=='member'||$TPL_VAR["join_type"]=='business'){?>
			$('#agreeFrm').submit();
<?php }else{?>
			var kid_agree_tmp = $('input:checkbox[name="kid_agree_tmp"]').is(":checked");
			if(typeof kid_agree_tmp == "undefined") kid_agree_tmp = '';
			if('<?php echo $TPL_VAR["mtype"]?>' == 'member' && '<?php echo $TPL_VAR["joinform"]["kid_join_use"]?>' == 'N' && !kid_agree_tmp){
				//만 14세 미만 회원으로 쇼핑몰 회원가입이 불가합니다.
				alert(getAlert('mb262'));
				return false;
			}else{
				kid_agree = kid_agree_tmp ? 'Y' : 'N';
				joinwindowopen();
			}
<?php }?>
	});

	$('input:checkbox[name="kid_agree_tmp"]').on("click", function(){
		var kid_agree = $(this).is(":checked") ? 'Y' : 'N';
		$('input[name="kid_agree"]').val(kid_agree);
	});

	$("#marketing").click(function(){
		if($("#marketing").is(":checked")){
			$("#mailing").attr("checked","checked");
			$("#sms").attr("checked","checked");
		}else{
			$("#mailing").removeAttr("checked");
			$("#sms").removeAttr("checked");
		}
	});

	$("#mailing, #sms").click(function(){
		if($("#mailing, #sms").is(":checked")){
			$("#marketing").attr("checked","checked");
		} else {
			$("#marketing").removeAttr("checked");
		}
	});

});
</script>