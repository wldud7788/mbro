<?php /* Template_ 2.2.6 2022/05/17 12:36:57 /www/music_brother_firstmall_kr/admin/skin/default/setting/joinform.html 000045951 */ 
$TPL_user_sub_1=empty($TPL_VAR["user_sub"])||!is_array($TPL_VAR["user_sub"])?0:count($TPL_VAR["user_sub"]);
$TPL_order_sub_1=empty($TPL_VAR["order_sub"])||!is_array($TPL_VAR["order_sub"])?0:count($TPL_VAR["order_sub"]);?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.tablednd.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-addlayer.js"></script>
<!-- 회원설정 : 가입 -->
<script type="text/javascript">
	var user_arr = new Array('userid', 'password', 'user_name', 'email', 'phone', 'cellphone', 'address', 'recommend', 'birthday', 'anniversary', 'nickname', 'sex', 'o2oauthnum', 'o2ousername');
	var buss_arr = new Array('bname', 'bceo', 'bno', 'bitem', 'badress', 'bperson', 'bpart','bemail', 'bphone', 'bcellphone');

	function typeCheck(){
		/**/
		if($("input:radio[name='join_type']:checked").val()=='member_only'){
			$("table.joinform-order-table input[type='checkbox']").attr("disabled","disabled");
		}else{
			for(var i=0;i<buss_arr.length;i++){
				var tmp_nm = buss_arr[i]+"_use";
				$("input:checkbox[name='"+tmp_nm+"']").attr("disabled",false);
			}

			$(".order_chUse").attr("disabled",false);
		}

		if($("input:radio[name='join_type']:checked").val()=='member_only'){
			$(".memberDetail").show();
			$(".businessDetail").hide();
			

	
		}else if($("input:radio[name='join_type']:checked").val()=='business_only'){
			$(".disabled_userid_business").show();
			$(".text_business").hide();
			$(".businessDetail").show();
			$(".memberDetail").hide();
		}else{
			$(".disabled_userid_business").hide();
			$(".text_business").show();
			$(".memberDetail").show();
			$(".businessDetail").show();
		}

		/**/
		for(var i=0;i<user_arr.length;i++){
			var tmp_nm = user_arr[i]+"_use";
			var obj = $("input:checkbox[name='"+tmp_nm+"']");
			var tmp_nm2 = user_arr[i]+"_required";
			if(!$("input:checkbox[name='"+tmp_nm+"']").attr("checked")){
				$("input:checkbox[name='"+tmp_nm2+"']").attr("disabled","disabled");
				obj.parent().parent().css("background-color","#ffffff");
				///추천인 동시 적용
				if(tmp_nm == 'recommend_use'){$("input:checkbox[name='recommend_buse']").parent().parent().css("background-color","#ffffff");}
				
				// O2O 가입 핸드폰 인증 동시 적용
				if(tmp_nm == 'o2oauthnum_use'){
					$("input:checkbox[name='"+tmp_nm2+"']").attr("checked", false);
				}
			}else{
				obj.parent().parent().css("background-color","#fff");
				///추천인 동시적용

				if(tmp_nm == 'recommend_use'){$("input:checkbox[name='recommend_buse']").parent().parent().css("background-color","#fff");}
				
				// O2O 가입 핸드폰 인증 동시 적용
				if(tmp_nm == 'o2oauthnum_use'){
					$("input:checkbox[name='"+tmp_nm2+"']").attr("checked", true);
				}

			}
		}

		$(".user_chUse").each( function(){
			var user_ch = $(this).attr("user_ch");
			var tmps_nm = "labelItem[user]["+user_ch+"][use]";
			var obj = $("input:checkbox[name='"+tmps_nm+"']");
			if(!$("input:checkbox[name='"+tmps_nm+"']").attr("checked")){
				var tmps_nm2 = "labelItem[user]["+user_ch+"][required]";
				$("input:checkbox[name='"+tmps_nm2+"']").attr("disabled","disabled");
				obj.parent().parent().css("background-color","#ffffff");
			}else{
				obj.parent().parent().css("background-color","#fff");
			}
		});

		/**/
		for(var i=0;i<buss_arr.length;i++){
			var tmp_nm = buss_arr[i]+"_use";
			var obj = $("input:checkbox[name='"+tmp_nm+"']");
			var tmp_nm2 = buss_arr[i]+"_required";
			if(!$("input:checkbox[name='"+tmp_nm+"']").attr("checked")){
				$("input:checkbox[name='"+tmp_nm2+"']").attr("disabled","disabled");
				obj.parent().parent().css("background-color","#ffffff");
			}else{
				if($("input:radio[name='join_type']:checked").val()!='member_only') $("input:checkbox[name='"+tmp_nm2+"']").attr("disabled",false);
				obj.parent().parent().css("background-color","#fff");
			}
		}
		$(".order_chUse").each( function(){
			var order_ch = $(this).attr("order_ch");
			var tmps_nm = "labelItem[order]["+order_ch+"][use]";
			var obj = $("input:checkbox[name='"+tmps_nm+"']");
			if(!$("input:checkbox[name='"+tmps_nm+"']").attr("checked")){
				var tmps_nm2 = "labelItem[order]["+order_ch+"][required]";
				$("input:checkbox[name='"+tmps_nm2+"']").attr("disabled","disabled");
				obj.parent().parent().css("background-color","#ffffff");
			}else{
				obj.parent().parent().css("background-color","#fff");
			}
		});
	}
/*
	<label class="mr15"><input type="radio" name="join_type" value="member_only" checked /> 개인 회원</label>
			<label class="mr15"><input type="radio" name="join_type" value="business_only"/> 사업자 회원</label>
			<label ><input type="radio" name="join_type" value="member_business"/> 개인+사업자 회원</label>*/

	function check_operating(){
		var obj = $("input[name='join_type']:checked").parent();
		obj.parent().parent().parent().children().each(function(){
			$(this).css("border","1px solid #dadada");
			$(this).css("background-color","#ffffff");
		});
		obj.parent().parent().css("border","2px solid #ab0804");
		obj.parent().parent().css("background-color","#fde1e4");

		if( $("input[name='join_type']:checked").val() == 'member_only' && $("#join_sns_mbonlyf").attr("checked") != 'checked' ) {
			$(".join_type_member_only_chose").css("text-decoration","line-through");
			$("#join_sns_mbbizf").attr("checked",false);
			$("#join_sns_bizonlyf").attr("checked",false);
		}else{
			$(".join_type_member_only_chose").css("text-decoration","");
		}

		if( $("input[name='join_type']:checked").val() == 'member_business' &&  $("#join_sns_mbbizf").attr("checked") != 'checked' ) {
			$(".join_type_member_business_chose2").css("text-decoration","line-through");
			$("#join_sns_mbonlyf").attr("checked",false);
			$("#join_sns_bizonlyf").attr("checked",false);
		}else{
			$(".join_type_member_business_chose2").css("text-decoration","");
		}

		if( $("input[name='join_type']:checked").val() == 'business_only' &&  $("#join_sns_bizonlyf").attr("checked") != 'checked' ) {
			$(".join_type_business_only_chose").css("text-decoration","line-through");
			$("#join_sns_mbbizf").attr("checked",false);
			$("#join_sns_mbonlyf").attr("checked",false);
		}else{
			$(".join_type_business_only_chose").css("text-decoration","");
		}

		//obj.parent().parent().css("opacity","0.2");
	}


	function use_sns(){
		if( $("#use_f_lay").attr("checked") == 'checked' ||  $("#use_t_lay").attr("checked") == 'checked' ||  $("#use_d_lay").attr("checked") == 'checked' ||  $("#use_k_lay").attr("checked") == 'checked' || $("#nid_use").val() == 'Y' ) {
			$(".join_type_sns_chose").css("text-decoration","");
		}else{
			$(".join_type_sns_chose").css("text-decoration","line-through");
		}
	}
	$(document).ready(function() {
		/**/
		$("input[name='join_type'][value='<?php echo $TPL_VAR["join_type"]?>']").attr('checked','checked');

		/**/
		$("input[name='userid_use'][value='<?php echo $TPL_VAR["userid_use"]?>']").attr('checked','checked');
		$("input[name='userid_required'][value='<?php echo $TPL_VAR["userid_required"]?>']").attr('checked','checked');
		$("input[name='password_use'][value='<?php echo $TPL_VAR["password_use"]?>']").attr('checked','checked');
		$("input[name='password_required'][value='<?php echo $TPL_VAR["password_required"]?>']").attr('checked','checked');
		$("input[name='user_name_use'][value='<?php echo $TPL_VAR["user_name_use"]?>']").attr('checked','checked');
		$("input[name='user_name_required'][value='<?php echo $TPL_VAR["user_name_required"]?>']").attr('checked','checked');
		$("input[name='email_use'][value='<?php echo $TPL_VAR["email_use"]?>']").attr('checked','checked');
		$("input[name='email_required'][value='<?php echo $TPL_VAR["email_required"]?>']").attr('checked','checked');
		$("input[name='phone_use'][value='<?php echo $TPL_VAR["phone_use"]?>']").attr('checked','checked');
		$("input[name='phone_required'][value='<?php echo $TPL_VAR["phone_required"]?>']").attr('checked','checked');
		$("input[name='cellphone_use'][value='<?php echo $TPL_VAR["cellphone_use"]?>']").attr('checked','checked');
		$("input[name='cellphone_required'][value='<?php echo $TPL_VAR["cellphone_required"]?>']").attr('checked','checked');
		$("input[name='o2ousername_use'][value='<?php echo $TPL_VAR["o2ousername_use"]?>']").attr('checked','checked');
		$("input[name='o2ousername_required'][value='<?php echo $TPL_VAR["o2ousername_required"]?>']").attr('checked','checked');
		$("input[name='o2oauthnum_use'][value='<?php echo $TPL_VAR["o2oauthnum_use"]?>']").attr('checked','checked');
		$("input[name='o2oauthnum_required'][value='<?php echo $TPL_VAR["o2oauthnum_required"]?>']").attr('checked','checked');
		$("input[name='address_use'][value='<?php echo $TPL_VAR["address_use"]?>']").attr('checked','checked');
		$("input[name='address_required'][value='<?php echo $TPL_VAR["address_required"]?>']").attr('checked','checked');
		$("input[name='recommend_use'][value='<?php echo $TPL_VAR["recommend_use"]?>']").attr('checked','checked');
		$("input[name='recommend_required'][value='<?php echo $TPL_VAR["recommend_required"]?>']").attr('checked','checked');
		$("input[name='birthday_use'][value='<?php echo $TPL_VAR["birthday_use"]?>']").attr('checked','checked');
		$("input[name='birthday_required'][value='<?php echo $TPL_VAR["birthday_required"]?>']").attr('checked','checked');
		$("input[name='anniversary_use'][value='<?php echo $TPL_VAR["anniversary_use"]?>']").attr('checked','checked');
		$("input[name='anniversary_required'][value='<?php echo $TPL_VAR["anniversary_required"]?>']").attr('checked','checked');
		$("input[name='nickname_use'][value='<?php echo $TPL_VAR["nickname_use"]?>']").attr('checked','checked');
		$("input[name='nickname_required'][value='<?php echo $TPL_VAR["nickname_required"]?>']").attr('checked','checked');
		$("input[name='sex_use'][value='<?php echo $TPL_VAR["sex_use"]?>']").attr('checked','checked');
		$("input[name='sex_required'][value='<?php echo $TPL_VAR["sex_required"]?>']").attr('checked','checked');
		/**/
		$("input[name='bname_use'][value='<?php echo $TPL_VAR["bname_use"]?>']").attr('checked','checked');
		$("input[name='bname_required'][value='<?php echo $TPL_VAR["bname_required"]?>']").attr('checked','checked');
		$("input[name='bceo_use'][value='<?php echo $TPL_VAR["bceo_use"]?>']").attr('checked','checked');
		$("input[name='bceo_required'][value='<?php echo $TPL_VAR["bceo_required"]?>']").attr('checked','checked');
		$("input[name='bno_use'][value='<?php echo $TPL_VAR["bno_use"]?>']").attr('checked','checked');
		$("input[name='bno_required'][value='<?php echo $TPL_VAR["bno_required"]?>']").attr('checked','checked');
		$("input[name='bitem_use'][value='<?php echo $TPL_VAR["bitem_use"]?>']").attr('checked','checked');
		$("input[name='bitem_required'][value='<?php echo $TPL_VAR["bitem_required"]?>']").attr('checked','checked');
		$("input[name='badress_use'][value='<?php echo $TPL_VAR["badress_use"]?>']").attr('checked','checked');
		$("input[name='badress_required'][value='<?php echo $TPL_VAR["badress_required"]?>']").attr('checked','checked');
		$("input[name='bperson_use'][value='<?php echo $TPL_VAR["bperson_use"]?>']").attr('checked','checked');
		$("input[name='bperson_required'][value='<?php echo $TPL_VAR["bperson_required"]?>']").attr('checked','checked');
		$("input[name='bpart_use'][value='<?php echo $TPL_VAR["bpart_use"]?>']").attr('checked','checked');
		$("input[name='bpart_required'][value='<?php echo $TPL_VAR["bpart_required"]?>']").attr('checked','checked');
		$("input[name='bemail_use'][value='<?php echo $TPL_VAR["bemail_use"]?>']").attr('checked','checked');
		$("input[name='bemail_required'][value='<?php echo $TPL_VAR["bemail_required"]?>']").attr('checked','checked');
		$("input[name='bphone_use'][value='<?php echo $TPL_VAR["bphone_use"]?>']").attr('checked','checked');
		$("input[name='bphone_required'][value='<?php echo $TPL_VAR["bphone_required"]?>']").attr('checked','checked');
		$("input[name='bcellphone_use'][value='<?php echo $TPL_VAR["bcellphone_use"]?>']").attr('checked','checked');
		$("input[name='bcellphone_required'][value='<?php echo $TPL_VAR["bcellphone_required"]?>']").attr('checked','checked');
		$("input[name='recommend_buse'][value='<?php echo $TPL_VAR["recommend_use"]?>']").attr('checked','checked');
		$("input[name='recommend_brequired'][value='<?php echo $TPL_VAR["recommend_required"]?>']").attr('checked','checked');

<?php if($TPL_VAR["service_limit"]){?>
		$("input[name='join_type'][value='member_business']").attr("disabled",true);
		$("input[name='join_type'][value='business_only']").attr("disabled",true);
<?php }?>

		$("input:checkbox").live('click',function(){
			var tmp = $(this).attr('name');
			if(tmp){
				tmp = tmp.split("_");

				//추천일 체크일경우 개인/기업 둘다 적용
				if(tmp[0]=='recommend'){
					if(tmp[1] =='use'){
						if($(this).attr('checked')){$("input[name='recommend_buse']").attr('checked','checked');}
						else{$("input[name='recommend_buse']").attr('checked',false);}
					}else{
						if($(this).attr('checked')){$("input[name='recommend_brequired']").attr('checked','checked');}
						else{$("input[name='recommend_brequired']").attr('checked',false);}
					}
				}

				if(tmp[tmp.length-1]!='required'){
					if(tmp[0]=='user') tmp[0] = 'user_name';
					var tmp_nm = tmp[0]+"_required";
					if($(this).attr('checked')){
						$("input:checkbox[name='"+tmp_nm+"']").attr("disabled",false);
					}else{
						$("input:checkbox[name='"+tmp_nm+"']").attr("disabled","disabled");
					}
				}
				var tmps = $(this).attr('name').split("[");

				if(tmps[3]=='use]'){
					var tmps_nm = "labelItem["+tmps[1]+"["+tmps[2]+"[required]";
					if($(this).attr('checked')){
						$("input:checkbox[name='"+tmps_nm+"']").attr("disabled",false);
					}else{
						$("input:checkbox[name='"+tmps_nm+"']").attr("disabled","disabled");
					}
				}
				typeCheck();
			}
		});
		typeCheck();

		$("input:radio[name='join_type']").click(function(){
			typeCheck();
			//check_operating();
		});

		$(".join_sns").click(function() {
<?php if($TPL_VAR["sns"]["total_f"]> 0){?>
				if( !$("#use_f").is(':checked') && $(this).attr('name') == 'use_f' ) {
					if(!confirm("페이스북 SNS계정으로 쇼핑몰을 이용중인 회원이 <?php echo number_format($TPL_VAR["sns"]["total_f"])?>명 있습니다.\n페이스북 SNS계정을 사용하지 않을 경우 <?php echo number_format($TPL_VAR["sns"]["total_f"])?>명의 회원이 \n페이스북 SNS계정으로 로그인을 하지 못하게 됩니다.\n위와 같은 문제가 발생하더라도 계속 진행하시겠습니까?")){
						$("#use_f").attr("checked",true);
					}
				}
<?php }?>

<?php if($TPL_VAR["sns"]["total_t"]> 0){?>
				if( !$("#use_t").is(':checked')  && $(this).attr('name') == 'use_t' ) {
					if(!confirm("트위터 SNS계정으로 쇼핑몰을 이용중인 회원이 <?php echo number_format($TPL_VAR["sns"]["total_t"])?>명 있습니다.\n트위터 SNS계정을 사용하지 않을 경우 <?php echo number_format($TPL_VAR["sns"]["total_t"])?>명의 회원이 \n트위터 SNS계정으로 로그인을 하지 못하게 됩니다.\n위와 같은 문제가 발생하더라도 계속 진행하시겠습니까?")){
						$("#use_t").attr("checked",true);
					}
				}
<?php }?>

			use_sns();
		});

		$(".facebookconflay").live("click",function(){
			
			openDialog("<?php echo $TPL_VAR["sns"]["facebook_logo"]?> 페이스북 전용앱 설정하기", "snsdiv_f", {"width":"740","height":"360","show" : "fade","hide" : "fade"});
		});

		$(".twitterconflay").live("click",function(){
			openDialog("<?php echo $TPL_VAR["sns"]["twitter_logo"]?> 트위터 설정하기", "snsdiv_t", {"width":"770","height":"320","show" : "fade","hide" : "fade"});
		});

		$(".naverconflay").click(function() {
			if($('#snsdiv_n').css("display") == "none"){
				$.get('/admin/setting/sns_nid_api', function(data) {
					$('#snsdiv_n').html(data);
				});
			}
			$('#snsdiv_n').removeClass("hide");
			openDialog("<?php echo $TPL_VAR["sns"]["nid_logo"]?> 네이버 아이디로 로그인 설정하기", "snsdiv_n", {"width":"660","height":"625","show" : "fade","hide" : "fade"});
		});
		$(".kakaoconflay").click(function() {
			openDialog("<?php echo $TPL_VAR["sns"]["kakao_logo"]?> 카카오 아이디로 로그인  설정하기", "snsdiv_k", {"width":"700","height":"270","show" : "fade","hide" : "fade"});
		});


		$(".instagramconflay").click(function() {
			openDialog("<?php echo $TPL_VAR["sns"]["instagram_logo"]?> 인스타그램 아이디로 로그인  설정하기", "snsdiv_i", {"width":"700","height":"338","show" : "fade","hide" : "fade"});
		});

		// 애플 설정 열기
		$(".appleconflay").click(function() {
			openDialog("<?php echo $TPL_VAR["sns"]["apple_logo"]?> 애플 아이디로 로그인  설정하기", "snsdiv_a", {"width":"700","height":"428","show" : "fade","hide" : "fade"});
		});

		$("#use_k").click(function(){
			var key_k = $.trim($("#key_k").val());
			if(key_k == '' && $(this).attr("checked") == "checked"){
				alert("설정버튼을 눌러 'Kakao Javascript Key'를 먼저 입력해 주세요.");
				$(this).attr("checked",false);
			}
		});

		//check_operating();
		use_sns();

		//$(".labelList_user").sortable();
		$(".labelList_user").disableSelection();
		$(".tablednd").tableDnD({onDragClass: "dragRow"});
		$(".labelList_user").disableSelection();
<?php if($TPL_VAR["service_setting_date_ck"]){?>
			snsinterface();
<?php }?>

		$('.essential').click(function(){
			if(!$(this).is(':checked')){
				$('.essential_ck').removeClass('essential_ck');
				$(this).prop('checked',true).addClass('essential_ck');
				openDialog('알림', 'essential', {'width':380,'height':180});
			}
		});
		
		snsDisplayKakao();

		snsDisplayfnc('f','facebook');
		snsDisplayfnc('t','twitter');
		snsDisplayfnc('i','instagram');		
		snsDisplayfnc('a','apple');		

<?php if($TPL_VAR["sns"]["use_n"]){?>
			$(".naveruse").html('사용함');
			$(".naverconfig").html('설정 완료');
<?php }else{?>
			$(".naveruse").html('사용 안 함');
			$(".naverconfig").html('미설정');
<?php }?>
	});

	function snsinterface(){
		var pannel = $("div.snspannel");
		$.ajax({
			'url' : '/admin/common/getGabiaPannel',
			'data' : {'code':'sns_right_banner'},
			'global' : false,
			'success' : function(html){
				if(html){
					$(pannel).show().html(html);
					if(!$(this).attr("noAnimation")){
						$(pannel).activity(false);
					}
				}else{
					$(pannel).hide();
				}
			}
		});
	}

	function snsDisplayKakao(mode){		
		if( $("input[name='use_k_lay'][value=1]").is(':checked') ) {
			$(".kakaouse").html('사용함');
			$(".kakaotalk0").hide();
			$(".kakaotalk1").show();
			$(".kakaconfig").html('설정 완료');
		}else{
			$(".kakaouse").html('사용 안 함');
			$(".kakaotalk0").show();
			$(".kakaotalk1").hide();
			$(".kakaconfig").html('미설정');
		}
		if(mode == 'up') openDialogAlert("설정이 저장 되었습니다.",400,140,'parent','');
	}	

	function snsDisplayfnc(snstype,sns,mode){		
		if( $("#use_"+snstype+"_lay").is(':checked') ) {
			$("."+sns+"use").html('사용함');
			$("."+sns+"config").html('설정 완료');
		}else{
			$("."+sns+"use").html('사용 안 함');
			$("."+sns+"config").html('미설정');
		}
		if(mode == 'up') openDialogAlert("설정이 저장 되었습니다.",400,140);
	}

	function naverDisplayfnc(){			
		if($("#nid_use").val()=="Y"){
			$(".naveruse").html('사용함');
			//$(".naverconfig").html('설정 완료');
		}else{
			$(".naveruse").html('사용 안 함');
			//$(".naverconfig").html('미설정');
		}	
	}
	
</script>

<?php if($TPL_VAR["service_limit"]){?>
<div class="box_style_02" >		
	무료몰+ : 회원 종류는 ‘개인 회원’입니다.<br>
	사업자 회원의 쇼핑몰을 운영하시려면 프리미엄몰+ 또는 독립몰+로 업그레이드 하시길 바랍니다.	
	<input type="button" onclick="serviceUpgrade();" value="업그레이드 >" class="resp_btn v2">	
</div>
<?php }?>

<div class="contents_dvs">
	<div class="item-title">회원 유형</div>
	<table class="table_basic thl">
		<tr>
			<th>회원 유형 선택</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="join_type" value="member_only" checked /> 개인 회원</label>
					<label><input type="radio" name="join_type" value="business_only"/> 사업자 회원</label>
					<label ><input type="radio" name="join_type" value="member_business"/> 개인+사업자 회원</label>
				</div>
			</td>
		</tr>
	</table>
</div>

<div class="contents_dvs">
	<div class="memberDetail">
		<div class="item-title">
			개인 회원가입 시 입력 항목
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip8', 'sizeR')"></span>
		</div>

		<table class="table_basic v4 tdc joinform-user-table">	
			<col width="191" /><col width="10%" /><col width="10%" /><col /><col /><col /><col width="10%" />
			<tr>
				<th class="center">항목</th>
				<th class="center">사용</th>
				<th class="center">필수</th>
				<th colspan="3" class="center">항목 설명</th>
				<th class="center">삭제</th>
			</tr>

			<tr>
				<th>가입 불가 아이디</th>
				<td colspan="2">해당없음</td>	
				<td colspan="3" class="left"><input type="text" name="disabled_userid" value="<?php echo $TPL_VAR["disabled_userid"]?>" size="60" class="line" /></label></td>
				<td></td>
			</tr>

			<tr>
				<th>아이디</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="userid_use" value="Y" checked disabled/></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="userid_required" value="Y" checked disabled/></label></td>
				<td colspan="3" class="left">6자~20자 / 영문 및 숫자</td>
				<td></td>
			</tr>

			<tr>
				<th>비밀번호</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="password_use" value="Y" checked disabled/></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="password_required" value="Y" checked disabled/></label></td>
				<td colspan="3" class="left">
					- 영문 대문자, 영문 소문자,숫자,특수문자 중 2가지 이상을 조합한 8~20자 <br/>
					- 동일하거나 연속되는 문자,숫자 3자리 이상 사용 불가 영문 회원의 생년월일, 전화번호 사용 불가 <br/>
					- 키보드 상 나열된 문자열 3자 이상 사용 불가 <br/>
					- love, happy, password, test, admin 은 사용이 불가  <br/>
					- 사용 가능한 특수문자: !#$%&()*+-/:=>?@[＼]^_{|}~
				</td>
				<td></td>
			</tr>

			<tr>
				<th>
					이름<br/>
					<label class="resp_checkbox"><input type="checkbox" name="user_icon" value="Y" <?php if($TPL_VAR["user_icon"]){?>checked<?php }?>/> 아이콘 사용</label> 
				</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="user_name_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="user_name_required" class="essential" value="Y" /></label></td>
				<td colspan="3" class="left">아이핀/안심체크 사용 시 자동 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>닉네임</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="nickname_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="nickname_required" value="Y" /></label></td>
				<td colspan="3" class="left">10자 이내 닉네임 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>
					이메일 (수신 여부)
					<!-- <br/><label  ><input type="checkbox" name="email_userid" value="Y" <?php if($TPL_VAR["email_userid"]){?>checked<?php }?>/> 아이디로 대체</label> -->
				</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="email_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="email_required" class="essential" value="Y"/></label></td>
				<td colspan="3" class="left">이메일 입력, 수신동의 체크</td>
				<td></td>
			</tr>

			<tr>
				<th>전화번호</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="phone_use" value="Y"/></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="phone_required" value="Y" /></label></td>
				<td colspan="3" class="left">전화번호 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>핸드폰 (수신 여부)</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="cellphone_use" value="Y"/></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="cellphone_required" class="essential" value="Y" /></label></td>
				<td colspan="3" class="left">핸드폰 입력, 수신동의 체크</td>
				<td></td>
			</tr>

			<tr>
				<th>주소</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="address_use" value="Y"/></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="address_required" value="Y" /></label></td>
				<td colspan="3" class="left">우편번호, 주소 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>추천인</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="recommend_use" value="Y"/></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="recommend_required" value="Y"/></label></td>
				<td colspan="3" class="left">추천인 아이디 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>생일</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="birthday_use" value="Y"/></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="birthday_required" value="Y" /></label></td>
				<td colspan="3" class="left">생년월일 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>기념일</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="anniversary_use" value="Y"/></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="anniversary_required" value="Y" /></label></td>
				<td colspan="3" class="left">월일 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>성별</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="sex_use" value="Y"/></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="sex_required" value="Y" /></label></td>
				<td colspan="3" class="left">남/여 구분 체크</td>
				<td></td>
			</tr>

			<tbody class="labelList_user tablednd">
<?php if($TPL_VAR["user_sub"]){?>
<?php if($TPL_user_sub_1){foreach($TPL_VAR["user_sub"] as $TPL_V1){?>
				<tr class="layer<?php echo $TPL_V1["joinform_seq"]?> ">
					<th><?php echo $TPL_V1["label_title"]?></th>
					<td><label class="resp_checkbox"><input type="checkbox" name="labelItem[user][<?php echo $TPL_V1["joinform_seq"]?>][use]" class="user_chUse" user_ch="<?php echo $TPL_V1["joinform_seq"]?>" value="Y" <?php if($TPL_V1["used"]=='Y'){?> checked <?php }?>/></label></td>
					<td><label class="resp_checkbox"><input type="checkbox" name="labelItem[user][<?php echo $TPL_V1["joinform_seq"]?>][required]" class="user_chRequired" value="Y" <?php if($TPL_V1["required"]=='Y'){?> checked <?php }?> /></label></td>
					<td><img src="/admin/skin/default/images/common/icon_move.png" style="cursor:pointer"></td>
					<td class="left">[<?php echo $TPL_V1["label_ctype"]?>] <?php echo $TPL_V1["label_desc"]?></td>
					<td><button type="button" class="listJoinBtn resp_btn v2" id="listJoinBtn" value="<?php echo $TPL_V1["joinform_seq"]?>" join_type="user" >수정</button></td>			
					<td>
						<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["joinform_seq"]?>][joinform_seq]" value="<?php echo $TPL_V1["joinform_seq"]?>">
						<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["joinform_seq"]?>][name]" value="<?php echo $TPL_V1["label_title"]?>">
						<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["joinform_seq"]?>][type]" value="<?php echo $TPL_V1["label_type"]?>">
						<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["joinform_seq"]?>][exp]" value="<?php echo $TPL_V1["label_desc"]?>">
						<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["joinform_seq"]?>][value]" value="<?php echo $TPL_V1["label_value"]?>">
						<button type="button" class="btn_minus" onclick="deleteRow(this)"></button>
					</td>
				</tr>
<?php }}?>
<?php }?>
			</tbody>
		</table>
	</div>
</div>

<div class="contents_dvs">
	<div class="businessDetail">
		<div class="item-title">
			사업자 회원가입 시 입력 항목
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip8', 'sizeR')"></span>
		</div>

		<table class="table_basic v4 tdc joinform-user-table">
			<col width="191" /><col width="10%" /><col width="10%" /><col /><col /><col /><col width="10%" />
			<tr>
				<th class="center">항목</th>
				<th class="center">사용</th>
				<th class="center">필수</th>
				<th colspan="3" class="center">항목 설명</th>
				<th class="center">삭제</th>
			</tr>

			<tr>
				<th>가입 불가 아이디</th>
				<td colspan="2"  >해당없음</td>	
				<td colspan="3" class="left">
					<input class="disabled_userid_business" type="text" name="disabled_userid_business" value="<?php echo $TPL_VAR["disabled_userid"]?>" size="60" class="line" />
					<p class="text_business">[개인회원] 과 동일함</p>
				</td>
				<td></td>
			</tr>

			<tr>
				<th>아이디</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="userid_use" value="Y" checked disabled/></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="userid_required" value="Y" checked disabled/></label></td>
				<td colspan="3"  class="left">6자~20자 / 영문 및 숫자</td>
				<td></td>
			</tr>

			<tr>
				<th>비밀번호</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="password_use" value="Y" checked disabled/></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="password_required" value="Y" checked disabled/></label></td>
				<td colspan="3"  class="left">
					- 영문 대문자, 영문 소문자,숫자,특수문자 중 2가지 이상을 조합한 8~20자 <br/>
					- 동일하거나 연속되는 문자,숫자 3자리 이상 사용 불가 영문 회원의 생년월일, 전화번호 사용 불가 <br/>
					- 키보드 상 나열된 문자열 3자 이상 사용 불가 <br/>
					- love, happy, password, test, admin 은 사용이 불가  <br/>
					- 사용 가능한 특수문자: !#$%&()*+-/:=>?@[＼]^_{|}~
				</td>
				<td></td>
			</tr>

			<tr>
				<th>업체명</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="bname_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="bname_required" value="Y" /></label></td>
				<td colspan="3"  class="left">업체명 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>대표자명</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="bceo_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="bceo_required" class="essential" value="Y" /></label></td>
				<td colspan="3"  class="left">대표자명 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>사업자 등록번호</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="bno_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="bno_required" value="Y" /></label></td>
				<td colspan="3"  class="left">사업자 등록번호 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>업태/종목</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="bitem_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="bitem_required" value="Y" /></label></td>
				<td colspan="3"  class="left">업태/종목 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>사업장 주소</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="badress_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="badress_required" value="Y" /></label></td>
				<td colspan="3"  class="left">우편번호, 주소 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>담당자명</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="bperson_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="bperson_required" value="Y" /></label></td>
				<td colspan="3"  class="left">담당자명 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>담당자 부서명</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="bpart_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="bpart_required" value="Y" /></label></td>
				<td colspan="3"  class="left">부서명 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>추천인</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="recommend_buse" value="Y" disabled/></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="recommend_brequired" value="Y" disabled/></label></td>
				<td colspan="3"  class="left">추천인 아이디 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>이메일 (수신 여부)</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="bemail_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="bemail_required" class="essential" value="Y" /></label></td>
				<td colspan="3" class="left">이메일 입력, 수신동의 체크</td>
				<td></td>
			</tr>

			<tr>
				<th>담당자 전화번호</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="bphone_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="bphone_required" value="Y" /></label></td>
				<td colspan="3" class="left">전화번호 입력</td>
				<td></td>
			</tr>

			<tr>
				<th>핸드폰 (수신 여부)</th>
				<td><label class="resp_checkbox"><input type="checkbox" name="bcellphone_use" value="Y" /></label></td>
				<td><label class="resp_checkbox"><input type="checkbox" name="bcellphone_required" class="essential" value="Y" /></label></td>
				<td colspan="3" class="left">핸드폰 입력, 수신동의 체크</td>
				<td></td>
			</tr>
			
			<tbody class="labelList_order tablednd">
<?php if($TPL_VAR["order_sub"]){?>
<?php if($TPL_order_sub_1){foreach($TPL_VAR["order_sub"] as $TPL_V1){?>
				<tr class="layer<?php echo $TPL_V1["joinform_seq"]?>">
					<td style="text-align: left;padding: 5px 15px 5px 15px;border-left: 1px solid #ccc;width: 160px;font-size: 13px;background-color: #f9fafc;font-weight: normal;"><?php echo $TPL_V1["label_title"]?></td>
					<td><label class="resp_checkbox"><input type="checkbox" name="labelItem[order][<?php echo $TPL_V1["joinform_seq"]?>][use]" class="order_chUse" order_ch="<?php echo $TPL_V1["joinform_seq"]?>" value="Y" <?php if($TPL_V1["used"]=='Y'){?> checked <?php }?> /></label></td>
					<td><label class="resp_checkbox"><input type="checkbox" name="labelItem[order][<?php echo $TPL_V1["joinform_seq"]?>][required]" class="order_chRequired"  value="Y" <?php if($TPL_V1["required"]=='Y'){?> checked <?php }?> /></label></td>
					<td><img src="/admin/skin/default/images/common/icon_move.png"  style="cursor:pointer"></td>
					<td class="left">[<?php echo $TPL_V1["label_ctype"]?>] <?php echo $TPL_V1["label_desc"]?></td>
					<td><button type="button" class="listJoinBtn resp_btn v2" id="listJoinBtn" value="<?php echo $TPL_V1["joinform_seq"]?>" join_type="order" style="cursor:pointer;">수정</button></td>
					<td>
						<input type="hidden" name="labelItem[order][<?php echo $TPL_V1["joinform_seq"]?>][joinform_seq]" value="<?php echo $TPL_V1["joinform_seq"]?>">
						<input type="hidden" name="labelItem[order][<?php echo $TPL_V1["joinform_seq"]?>][name]" value="<?php echo $TPL_V1["label_title"]?>">
						<input type="hidden" name="labelItem[order][<?php echo $TPL_V1["joinform_seq"]?>][type]" value="<?php echo $TPL_V1["label_type"]?>">
						<input type="hidden" name="labelItem[order][<?php echo $TPL_V1["joinform_seq"]?>][exp]" value="<?php echo $TPL_V1["label_desc"]?>">
						<input type="hidden" name="labelItem[order][<?php echo $TPL_V1["joinform_seq"]?>][value]" value="<?php echo $TPL_V1["label_value"]?>">
						<button type="button" class="btn_minus" onclick="deleteRow(this)"></button>
					</td>
				</tr>
<?php }}?>
<?php }?>
			</tbody>
		</table>
	</div>
</div>

<div class="contents_dvs">
<!-- O2O 가입 조건 -->
<?php if($TPL_VAR["checkO2ORequired"]){?>	
<?php $this->print_("o2o_member_joinform",$TPL_SCP,1);?>

<?php }?>
</div>

<div class="contents_dvs">
	<div class="item-title">SNS 연동</div>
	<table class="table_basic thl" >
		<tr>
			<th>페이스북</th>
			<td>
				<button type="button" class="facebookconflay resp_btn v2 mr10">설정</button>
				<span class="snslogin_use facebookuse hide">사용 안 함</span>			

				<!---<?php if($TPL_VAR["sns"]["facebook_app"]=='new'){?>
					<button type="button" class="facebookconflay resp_btn v2 mr10">설정</button>
					<span class="snslogin_use facebookuse">사용 안 함</span>
<?php }else{?>
					<label><input type="checkbox" value="1"  <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?>   class="use_f join_sns"  <?php if($TPL_VAR["use_f"]){?>checked <?php }?> <?php }?> /> 사용함</label> (기본앱)
<?php }?>	--->
			
			</td>
		</tr>

		<tr>
			<th>트위터</th>
			<td>
				<button type="button" class="twitterconflay resp_btn v2 mr10">설정</button>
				<span class="snslogin_use twitteruse hide">사용 안 함</span>			
			
				<!---<?php if($TPL_VAR["sns"]["twitter_app"]=='new'){?>
					<button type="button" class="twitterconflay resp_btn v2 mr10">설정</button>
					<span class="snslogin_use twitteruse">사용 안 함</span>	
<?php }else{?>
					<label><input type="checkbox"  value="1"  <?php if($TPL_VAR["functionLimit"]){?>  onclick="servicedemoalert('use_f');"  <?php }else{?> <?php if($TPL_VAR["use_t"]){?> checked  <?php }?> class="use_t join_sns"<?php }?> /> 사용함</label> (기본앱)
<?php }?>--->	

			</td>
		</tr>

		<tr>
			<th>네이버</th>
			<td>						
<?php if($TPL_VAR["functionLimit"]){?>
				<button type="button" onclick="servicedemoalert('use_f');" class="resp_btn v2 mr10" >설정</button>
<?php }else{?>
				<button type="button" class="naverconflay resp_btn v2 mr10" >설정</button>
<?php }?>
				<span class="snslogin_use naveruse hide">사용 안 함</span>	<!---<?php if($TPL_VAR["use_n"]){?>사용함<?php }else{?>사용 안 함<?php }?>--->
				<input type="hidden" name="nid_use" id="nid_use" value="<?php if($TPL_VAR["sns"]["use_n"]){?>Y<?php }else{?>N<?php }?>">			
			</td>
		</tr>

		<tr>
			<th>카카오</th>
			<td>		
<?php if($TPL_VAR["functionLimit"]){?>
				<button type="button" onclick="servicedemoalert('use_f');" class="resp_btn v2 mr10" >설정</button>
<?php }else{?>
				<button type="button" class="kakaoconflay resp_btn v2 mr10" >설정</button>
<?php }?>
				<span class="snslogin_use kakaouse hide">사용 안 함</span>		
			</td>
		</tr>

		<tr>
			<th>애플</th>
			<td>		
<?php if($TPL_VAR["functionLimit"]){?>
				<button type="button" onclick="servicedemoalert('use_a');" class="resp_btn v2 mr10">설정</button>
<?php }else{?>
				<button type="button" class="appleconflay resp_btn v2 mr10" >설정</button>
<?php }?>
				<span class="snslogin_use appleuse hide">사용 안 함</span>			
			</td>
		</tr>
	</table>
</div>

<!--- include : joinform_sns_setting.html -->
<input type="hidden" name="pagemode" id="pagemode" value="joinform">
<?php $this->print_("sns_setting",$TPL_SCP,1);?>


<div class="contents_dvs">
	<div class="item-title">
		아이디, 비밀번호 찾기
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip10', 'sizeM')"></span>
	</div>

	<table class="table_basic thl">
		<tr>
			<th>
				보안문자 입력
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip27')"></span>
			</th>
			<td class="clear">
				<table class="table_basic v3 thl">
					<tr>
						<th>아이디</th>
						<td>
							<div class="resp_radio">
								<label><input type="radio" name="find_id_use_captcha" value="y" <?php if($TPL_VAR["find_id_use_captcha"]=='y'){?>checked<?php }?>> 사용함</label>
								<label><input type="radio" name="find_id_use_captcha" value="n" <?php if(!$TPL_VAR["find_id_use_captcha"]||$TPL_VAR["find_id_use_captcha"]=='n'){?>checked<?php }?>> 사용 안 함</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>비밀번호</th>
						<td>
							<div class="resp_radio">
								<label><input type="radio" name="find_pass_use_captcha" value="y" <?php if($TPL_VAR["find_pass_use_captcha"]=='y'){?>checked<?php }?>> 사용함</label>
								<label><input type="radio" name="find_pass_use_captcha" value="n" <?php if(!$TPL_VAR["find_pass_use_captcha"]||$TPL_VAR["find_pass_use_captcha"]=='n'){?>checked<?php }?>> 사용 안 함</label>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<input type="hidden" name="windowLabelComment" value="N">
<input type="hidden" name="windowLabelSeq" value="">
<input type="hidden" name="windowLabelType" value="">
<input type="hidden" name="Label_cnt" value="<?php echo $TPL_VAR["sub_cnt"]["cnt"]?>">
<input type="hidden" name="Label_maxid" value="<?php echo $TPL_VAR["sub_cnt"]["maxid"]?>">
<input type="hidden" name="windowJoinType" value="">
<style>
	.btn-add-plus button {display:inline-block;width:22px;height:18px;overflow:visible;position:relative;margin:0;padding:0;border:0;background:url('/admin/skin/default/images/design/icon_design_plus.gif') no-repeat; cursor:pointer;}
	.btn-add-minus button {display:inline-block;width:22px;height:18px;overflow:visible;position:relative;margin:0;padding:0;border:0;background:url('/admin/skin/default/images/design/icon_design_minus.gif') no-repeat;cursor:pointer;}
	.btn-sub-plus button {display:inline-block;width:22px;height:18px;overflow:visible;position:relative;margin:0;padding:0;border:0;background:url('/admin/skin/default/images/common/icon_plus.gif') no-repeat;cursor:pointer;}
	.btn-sub-minus button {display:inline-block;width:22px;height:18px;overflow:visible;position:relative;margin:0;padding:0;border:0;background:url('/admin/skin/default/images/common/icon_minus.gif') no-repeat;cursor:pointer;}
</style>

<div id="joinDiv" class="layer_pop hide">
	<!--팝업타이틀 -->
	<!--입력폼 -->
	<div class="content">
		<table width="100%" border="0" cellspacing="3" cellpadding="0" align="center" id="labelTable">
			<col width="25%"/><col width="75%"/>
			<tr>
				<th align="left">항목유형</th>
				<td>
					<select name="formList" id="formListSelect">
						<option value="text">텍스트박스</option>
						<option value="radio">여러개 중 택1</option>
						<option value="textarea">에디트박스</option>
						<option value="checkbox">체크박스</option>
						<option value="select">셀렉트박스</option>
					</select>

					<a href="javascript:void(0);" id="sampleViewBtn" class="resp_btn">샘플보기</a>					
				</td>
			</tr>
			<tr>
				<th align="left">항목명</th>
				<td><input type="text" name="windowLabelName" value="" size="30"></td>
			</tr>
			<tr>
				<th align="left">항목설명</th>
				<td><input type="text" name="windowLabelExp" value="" size="30"></td>
			</tr>
			<tr id="labelTr">
				<th id="labelTh" align="left">항목값</th>
				<td id="labelTd" ></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
			<tr>
				<td width="75"></td>
				<td><!-- input type="checkbox" name="windowLabelCheck" value="" size="30" class="null"> 항목값 필수--></td>
			</tr>
		</table>
	</div>

	<!--버튼 -->
	<div class="footer">
		<input type="button" value="확인" id="labelWriteBtn" class="resp_btn active size_L" />
		<button type="button" class="resp_btn v3 size_L" onclick="closeDialogEvent(this);">닫기</button>
	</div>
	<!--//버튼 -->	
	
	<!--//입력폼 -->
<?php $this->print_("surveyForm",$TPL_SCP,1);?>

</div>

<div id="essential" class="hide">
	<ul>
		<li>아이디/비밀번호 찾기의 필수요소이며, 정보 분실시 아</li>
		<li>이디/비밀번호를 찾을 수 없습니다. '해제'하시겠습니까?</li>
	</ul>
	<div class="center mt20">
		<span class="btn large cyanblue"><input type="button" onclick="$('.essential_ck').prop('checked',false);$('#essential').dialog('close')" value="해제"></span>
		<span class="btn large gray"><input type="button" onclick="$('#essential').dialog('close')" value="취소"></span>
	</div>
</div>