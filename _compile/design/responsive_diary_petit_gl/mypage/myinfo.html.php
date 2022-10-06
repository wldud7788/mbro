<?php /* Template_ 2.2.6 2020/12/08 11:56:43 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/myinfo.html 000020313 */  $this->include_("sslAction");
$TPL_snslist_1=empty($TPL_VAR["snslist"])||!is_array($TPL_VAR["snslist"])?0:count($TPL_VAR["snslist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 회원정보 수정 @@
- 파일위치 : [스킨폴더]/mypage/myinfo.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php echo $TPL_VAR["is_file_facebook_tag"]?>

<?php echo $TPL_VAR["is_file_kakao_tag"]?>


<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvbXlpbmZvLmh0bWw=" >회원정보 수정</span></h2>
		</div>

		<form name="registFrm" id="registFrm" target="actionFrame" method="post" action="<?php echo sslAction('../member_process/myinfo_modify')?>" novalidate>
		<input type="hidden" name="seq" value="<?php echo $TPL_VAR["member_seq"]?>"/>
		<input type="hidden" name="rute" value="<?php echo $TPL_VAR["rute"]?>"/>
<?php if($TPL_VAR["snslist"]){?>
			<h3 class="title_sub1"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvbXlpbmZvLmh0bWw=" >사용중인 SNS 계정</span></h3>
<?php if($TPL_snslist_1){foreach($TPL_VAR["snslist"] as $TPL_V1){?>
				<img src="/data/skin/responsive_diary_petit_gl/images/design/mypage_sns_<?php echo substr($TPL_V1["rute"], 0, 1)?>.png"  class="hand" snstype="<?php echo $TPL_V1["rute"]?>"  alt="<?php echo $TPL_VAR["joinform"]["use_sns"][$TPL_V1["rute"]]['nm']?>"  title="<?php echo $TPL_VAR["joinform"]["use_sns"][$TPL_V1["rute"]]['nm']?>" height="42" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9teXBhZ2Vfc25zX3s9c3Vic3RyKC5ydXRlLDAsMSl9LnBuZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvbXlpbmZvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9kZXNpZ24vbXlwYWdlX3Nuc197PXN1YnN0cigucnV0ZSwwLDEpfS5wbmc=' designElement='image' />
<?php if($TPL_V1["rute"]&&$TPL_V1["rute"]=='naver'){?>
						<?php echo $TPL_VAR["conv_sns_n"]?>

<?php }?>
<?php }}?>
<?php if(($TPL_VAR["rute"]=='none'&&$TPL_snslist_1> 0)||($TPL_VAR["rute"]!='none'&&$TPL_snslist_1> 1)||($TPL_VAR["rute"]!='none'&&$TPL_snslist_1> 0&&$TPL_VAR["sns_change"]== 1)){?>
				<button  type="button" class="snsbuttondisconnectlay btn_resp size_c Fs14">연결해제</button>
<?php }?>
<?php if($TPL_snslist_1){foreach($TPL_VAR["snslist"] as $TPL_V1){?>
<?php switch($TPL_V1["rute"]){case 'facebook':?>
					<div class="mt10">  <?php echo $TPL_V1["email"]?> ( <?php echo $TPL_V1["user_name"]?>, <?php if($TPL_V1["sex"]=='male'){?>남자<?php }elseif($TPL_V1["sex"]=='female'){?>여자<?php }?><?php if($TPL_V1["birthday"]){?>, <?php echo $TPL_V1["birthday"]?> <?php }?> )</div>
<?php }?>
<?php }}?>
<?php }?>

			<h3 class="title_sub1"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvbXlpbmZvLmh0bWw=" >SNS 계정 사용</span></h3>
			<p class="Pb8" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvbXlpbmZvLmh0bWw=" >사용하고 계신 SNS 또는 외부 계정으로 간편하게 로그인하여 쇼핑몰을 이용하실 수 있습니다. 여러 개를 함께 이용하실 수도 있습니다.</p>
<?php if(count($TPL_VAR["joinform"]["use_sns"])> 0){?>
			<ul class="member_sns_list">
<?php if(is_array($TPL_R1=$TPL_VAR["joinform"]["use_sns"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
				<li>
					<img src="/data/skin/responsive_diary_petit_gl/images/design/sns_icon_<?php echo $TPL_K1?><?php if(!in_array($TPL_K1,$TPL_VAR["sns_joined_list"])){?>_off<?php }?>.png" class="sns_icon <?php if(!in_array($TPL_K1,$TPL_VAR["sns_joined_list"])){?> <?php if($TPL_K1=='facebook'){?>fb-login-button-mbconnect-direct<?php }else{?>sns-login-button-mbconnect-direct<?php }?> hand <?php }?>" snstype="<?php echo $TPL_K1?>" alt="<?php echo $TPL_V1["nm"]?> 아이디 사용하기"  title="<?php echo $TPL_V1["nm"]?> 아이디 사용하기"  designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9zbnNfaWNvbl97PS5rZXlffXs/ICFpbl9hcnJheSgua2V5Xywgc25zX2pvaW5lZF9saXN0KX1fb2Zmey99LnBuZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvbXlpbmZvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9kZXNpZ24vc25zX2ljb25fez0ua2V5X317PyAhaW5fYXJyYXkoLmtleV8sIHNuc19qb2luZWRfbGlzdCl9X29mZnsvfS5wbmc=' designElement='image' />
<?php if($TPL_V1["key"]){?><p class="ttt1">(사용중)</p><?php }?>
				</li>
<?php }}?>
			</ul>
<?php }?>

			<h3 class="title_sub1"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvbXlpbmZvLmh0bWw=" >회원정보</span></h3>
			<!-- ------- 회원가입 입력폼. 파일위치 : [스킨폴더]/member/register_form.html ------- -->
<?php $this->print_("form_member",$TPL_SCP,1);?>

			<!-- ------- //회원가입 입력폼 ------- -->
			<div class="btn_area_c">
				<button type="submit" class="btn_resp size_c color2">확인</button>
				<button type="button" class="btn_resp size_c" onclick="document.registFrm.reset();">취소</button>
			</div>
		</form>
		<!-- //본문내용 끝 -->

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>
<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->

<!-- sns 계정 연결 해제 -->
<div id="snsdisconnectlay" class="resp_layer_pop hide">
	<h4 class="title">보유 쿠폰</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<p class="stitle v4 gray_03 C">
				SNS계정 정보를 삭제하여 연결을 해제할 수 있습니다<br />
				<span class="pointcolor">연결이 해제되면 해당 SNS계정으로 쇼핑몰을 더 이상 이용할 수 없습니다.</span><br />
			</p>
			<ul class="lis_sns_disconnect Mt20">
<?php if(is_array($TPL_R1=$TPL_VAR["joinform"]["use_sns"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_V1["key"]){?>
				<li>
					<img src="/data/skin/responsive_diary_petit_gl/images/design/mypage_sns_<?php echo substr($TPL_K1, 0, 1)?>.png" class="icon" snstype="sns_<?php echo substr($TPL_K1, 0, 1)?>"  snsrute="<?php echo $TPL_K1?>" alt="<?php echo $TPL_V1["nm"]?>"  title="<?php echo $TPL_V1["nm"]?>"  designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9teXBhZ2Vfc25zX3s9c3Vic3RyKC5rZXlfLDAsMSl9LnBuZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvbXlpbmZvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9kZXNpZ24vbXlwYWdlX3Nuc197PXN1YnN0cigua2V5XywwLDEpfS5wbmc=' designElement='image' />
					<button type="button" class="<?php if($TPL_K1=='facebook'){?>fb-login-button-disconnect<?php }else{?>sns-login-button-disconnect<?php }?> btn_resp size_c color4 pointcolor3 imp" alt="<?php echo $TPL_V1["nm"]?>"  title="<?php echo $TPL_V1["nm"]?>" <?php if($TPL_K1!='facebook'){?> snstype="sns_<?php echo substr($TPL_K1, 0, 1)?>"  snsrute="<?php echo $TPL_K1?>" <?php }?>>연결해제</button>
				</li>
<?php }?>
<?php }}?>
			</ul>
		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">닫기</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>

<!-- 휴대폰 인증 -->
<?php if($TPL_VAR["confirmPhone"]=='Y'){?>
<div id="authphone" class="resp_layer_pop hide">
	<h4 class="title">휴대폰 인증</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<input type="hidden" name="phonetype" id="phonetype" value="" />
			<div class="resp_join_table">
				<ul>
					<li class="th "><p>변경할 휴대폰 번호</p></li>
					<li class="td">
						<input type="text" name="chg_phone[]" class="chg_phone size_phone" value="" maxlength="4" /> -
						<input type="text" name="chg_phone[]" class="chg_phone size_phone" value="" maxlength="4" /> -
						<input type="text" name="chg_phone[]" class="chg_phone size_phone" value="" maxlength="4" />
						<span class="authnum_send"><button type="button" onclick="authphone_send();" class="btn_resp size_b">인증번호발송</button></span>
					</li>
				</ul>
				<ul>
					<li class="th "><p>인증번호 입력</p></li>
					<li class="td">
						<input type="text" name="authnum" id="authnum" value="" />
						<button type="button" class="btn_resp size_b color2" onclick="authphone_confirm();">인증</button>
						<p class="Pt5 hide auth_timer">(<span id="timer_min">3</span>분 <span id="timer_sec">00</span>초)</p>
					</li>
				</ul>
			</div>
			<p class="desc Mt10">※ 휴대폰번호 인증은 1일 3회로 제한됩니다.</p>
		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="$('.chg_phone').attr('disabled',false); hideCenterLayer()">닫기</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>
<?php }?>

<!-- 아이디/비밀번호 등록 -->
<?php if($TPL_VAR["sns_change"]=='0'&&$TPL_VAR["rute"]!='none'&&$TPL_VAR["rute"]){?>
<div id="sns_change_id" class="resp_layer_pop hide">
	<h4 class="title">아이디/비밀번호 등록</h4>
	<form id="sns_change_id_form">
		<div class="y_scroll_auto2">
			<div class="layer_pop_contents v5">
				<div class="resp_join_table th_size2">
					<ul>
						<li class="th "><p>아이디</p></li>
						<li class="td">
							<input type="text" name="userid" id="userid" value="" onkeypress="filterKey();" class="eng_only" style="width:200px;" placeholder="공백 없는 영문/숫자 포함 6~20자" onpaste="javascript:return false;" />
							<p id="id_info" class="guide_text"></p>
						</li>
					</ul>
					<ul>
						<li class="th "><p>비밀번호</p></li>
						<li class="td">
							<input type="password" name="password" value="" class="eng_only" style="width:200px;" placeholder="공백 없는 영문/숫자 포함 6~20자" />
						</li>
					</ul>
					<ul>
						<li class="th "><p>비밀번호 확인</p></li>
						<li class="td">
							<input type="password" name="re_password" value="" class="eng_only" style="width:200px;" />
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="layer_bottom_btn_area2 v2">
			<ul class="basic_btn_area2">
				<li><button type="button" class="btn_resp size_c color2" onclick="sns_change_id_func();">확인</button></li>
				<li><button type="button" class="btn_resp size_c color5" onclick="hideCenterLayer()">취소</button></li>
			</ul>
		</div>
	</form>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>
<?php }?>

<!-- 아이콘 등록 -->
<?php if($TPL_VAR["joinform"]["user_icon"]=='Y'){?>
<div id="membericonUpdatePopup" class="resp_layer_pop hide">
	<h4 class="title">아이콘 등록</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5 C">
			<form name="membericonRegist" id="membericonRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">
				<p class="stitle v4 gray_03 Pt30 Pb30">
					사이즈는 30 × 30 으로 등록해 주세요.
				</p>
				<input type="file" name="membericonFile" id="membericonFile" onChange="membericonFileUpload();" />
			</form>
		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">취소</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>
<?php }?>


<script src="/app/javascript/js/skin-snslogin.js"></script>
<script type="text/javascript">
var return_url	= "../main/index";
<?php if($_GET["return_url"]){?>
return_url		= "<?php echo $_GET["return_url"]?>";
<?php }elseif($TPL_VAR["return_url"]){?>
return_url		= "<?php echo $TPL_VAR["return_url"]?>";
<?php }?>
var mobileapp	= "<?php echo $TPL_VAR["mobileapp"]?>";
var m_device	= "<?php echo $TPL_VAR["m_device"]?>";
var fbuserauth	= "<?php echo $TPL_VAR["fbuserauth"]?>";
var jointype	= 'myinfo';
var apple_authurl	= '<?php echo $TPL_VAR["apple_authurl"]?>';
</script>

<script type="text/javascript">
	$(document).ready(function() {
		
		$("input[name='userid']").blur(function() {
			if($(this).val()){
				$.post("../member_process/id_chk", { userid : $(this).val() }, function(response){
					var text = response.return_result;
					var userid = response.userid;
					$("#id_info").html(text);
					$("input[name='userid']").val(userid);
				},'json');
			}
		});

		$('#find_email').change(function() {
			$("input[name='email[1]']").val(this.value);
		});

		if('<?php echo $TPL_VAR["mailing"]?>'=='y') $("input:checkbox[name='mailing']").attr('checked','checked');
		if('<?php echo $TPL_VAR["sms"]?>'=='y') $("input:checkbox[name='sms']").attr('checked','checked');		

		//기존회원 sns 계정통합 해제하기
		$(".snsbuttondisconnectlay").click(function(){
			//SNS계정 연결해제
			showCenterLayer('#snsdisconnectlay');
			//openDialog(getAlert('mb138'), "snsdisconnectlay", {"width":"500","height":"200"});
		});


		//기존회원 sns 계정통합 해제하기
		$(".sns-login-button-disconnect").click(function(){
			var snstype = $(this).attr('snstype');
			var snsrute = $(this).attr('snsrute');
			var title = $(this).attr('alt');
			//정말로 "+ title + "의 연결을 해제하시겠습니까?
			if(confirm(getAlert('mb139',title))){
				snsdisconnect(snstype, snsrute);
			}
		});

		$("#registFrm").submit(function(){
			$("input[name='bcellphone[]']").attr("disabled",false);
			$("input[name='cellphone[]']").attr("disabled",false);
			return true;
		});
	});


	function view_address(str){

		if(str == "street"){
			$("#address_view").html("(도로명) "+$("input[name='address_street']").val());
		}else{
			$("#address_view").html("(지번) "+$("input[name='address']").val());
		}
		if($("#address_view").css("display") == "none"){
			$("#address_view").show();
		}else{
			$("#address_view").hide();
		}
	}


	function filterKey() {
		var filter = "[0-9a-z]";
	   if(filter){
		  // fromCharCode : 매개 변수에서 ASCII 값이 나타내는 문자들로 구성된 문자열을 반환합니다
		  var sKey = String.fromCharCode(event.keyCode);

		  // RegExp
		  // 정규표현을 취급하는 객체로 new를 사용하지 않고 정규표현 문자열을 변수에 대입하는 것으로도 동일한 결과
		  var re = new RegExp(filter);

		  // test() : 일치하는 문자열이 있는 경우 true, 없으면 false
		  if(!re.test(sKey)) event.returnValue=false;
	   }
	}

<?php if($TPL_VAR["sns_change"]=='0'&&$TPL_VAR["rute"]!='none'&&$TPL_VAR["rute"]){?>
	function sns_change_id(){
		that = $('#sns_change_id');
		$("input[name='userid']",that).val('');
		$("input[name='password']",that).val('');
		$("input[name='re_password']",that).val('');
		$("#id_info",that).html('');
		//아이디/비밀번호 등록
		showCenterLayer('#sns_change_id');
		//openDialog(getAlert('mb143'), 'sns_change_id', {'width':580,'height':220});
	}

	function sns_change_id_func(){

		that		= $('#sns_change_id');
		userid		= $("input[name='userid']",that).val();
		password	= $("input[name='password']",that).val();
		re_password	= $("input[name='re_password']",that).val();

		if	(userid == ''){
			//아이디 항목은 필수입니다.
			openDialogAlert(getAlert('mb144'),'400','160',function(){});
			return;
		}

		if	(password == ''){
			//비밀번호 항목은 필수입니다.
			openDialogAlert(getAlert('mb145'),'400','160',function(){});
			return;
		}

		if	(re_password == ''){
			//비밀번호확인 항목은 필수입니다.
			openDialogAlert(getAlert('mb146'),'400','160',function(){});
			return;
		}

		if	(password != re_password){
			//비밀번호 확인이 일치하지 않습니다.
			openDialogAlert(getAlert('mb147'),'400','160',function(){});
			return;
		}

		$.ajax({
			url: "../member_process/sns_update_id",
			type: "post",
			data : $('#sns_change_id_form').serialize(),
			success : function(e){
				if	(e == 'succ'){
					//아이디 등록이 완료 되었습니다
					msg = getAlert('mb148');
					openDialogAlert(msg,'400','160',function(){location.reload();});
				}else{
					openDialogAlert(e,'400','160',function(){});
				}
			}
		});
	}
<?php }?>

	// 휴대폰 인증 사용시 인증팝업 :: 2016-04-19 lwh
	function authphone_popup(phoneType){
		$("#phonetype").val(phoneType);
		$.each($("input[name='"+phoneType+"[]']"),function(idx){
			$("input[name='chg_phone[]']").eq(idx).val($(this).val());
		});
		//휴대폰 인증안내
		showCenterLayer('#authphone');
		//openDialog(getAlert('mb149'), "authphone", {"width":"600","height":"250"});
	}

	// 인증번호 발신 :: 2016-04-19 lwh
	function authphone_send(){
		loadingStart();
		var new_phone = '';
		var old_phone = '';
		var ptype = $("#phonetype").val();
		$.each($("input[name='chg_phone[]']"),function(){ new_phone += $(this).val(); });
		$.each($("input[name='"+ptype+"[]']"),function(){ old_phone += $(this).val(); });
		if(!new_phone){
			//변경할 휴대폰 번호를 입력해주세요.
			openDialogAlert(getAlert('mb150'),'300','150',function(){});
			return false;
		}
		if(new_phone == old_phone){
			//기존 번호와 동일합니다.
			openDialogAlert(getAlert('mb151'),'300','150',function(){});
			return false;
		}
		
		var cellphone = $("input[name='chg_phone\\[\\]']").map(function() {
			return btoa(this.value);
		}).get();

		var min = 2;
		var sec = 59;
		$.ajax({
			'url' : '../member_process/authphone',
			'data' : {'phone':new_phone,'cellphone[]':cellphone},
			'dataType': 'json',
			'success': function(res) {
				loadingStop("body",true);
				if(res.result){
					$(".chg_phone").attr('disabled',true);
					$(".authnum_send").hide();
					$(".auth_timer").show();
					var timer = setInterval(function(){
						if(sec==0){
							sec = 59;
							if(min != 0) {
								min = min - 1;
							}
						}else{
							sec = sec - 1;
						}
						$('#timer_min').html(min);
						$('#timer_sec').html(sec);

						if(min == 0 && sec == 0){
							clearInterval(timer);
							$(".authnum_send").show();
							$(".auth_timer").hide();
							$.ajax({
								'url':'../member_process/authphone_del',
								'dataType': 'text',
								'success': function(res) {
								}
							});
						}
					}, 1000);

				}
				alert(res.msg);
			}
		});
	}

	// 인증번호 확인 :: 2016-04-19 lwh
	function authphone_confirm(){
		var authnum = $("#authnum").val();
		$("iframe[name='actionFrame']").attr('src','../member_process/authphone_confirm?authnum=' + authnum);
		//hideCenterLayer();
	}

</script>

<?php if($TPL_VAR["joinform"]["user_icon"]=='Y'){?>
<script type="text/javascript">
	$(document).ready(function() {
			$("button#membericonUpdate").live("click",function(){
				$('#membericonRegist')[0].reset();
				$("input[name=user_icon][value='99']").attr("checked",true);
				//아이콘
				showCenterLayer('#membericonUpdatePopup');
				//openDialog(getAlert('mb152'), "membericonUpdatePopup", {"width":"380","height":"150","show" : "fade","hide" : "fade"});
			});

	});
	function membericonFileUpload(str){
		if(str > 0) {
			//로고를 선택해 주세요.
			alert(getAlert('mb153'));
			return false;
		}
		var frm = $('#membericonRegist');
		frm.attr("action","../member_process/membericonsave");
		frm.submit();
	}

	function membericonDisplay(filenm){
		$("#membericon_img").attr("src",filenm);
		$("#membericon_img").css("display","block");
		$("#membericonDelete").css("display","block");
		$('#membericonRegist')[0].reset();
		hideCenterLayer();
		//$("#membericonUpdatePopup").dialog("close");
	}
</script>
<?php }?>