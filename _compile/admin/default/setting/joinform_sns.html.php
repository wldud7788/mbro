<?php /* Template_ 2.2.6 2022/05/17 12:36:57 /www/music_brother_firstmall_kr/admin/skin/default/setting/joinform_sns.html 000039365 */ ?>
<script type="text/javascript" src="/app/javascript/js/punycode.min.js"></script>
<script type="text/javascript">
$(function(){
	
	var pagemode = $("#pagemode").val();
	
	$("input[name='use_f_lay']").on("click", function(){
		
		if( $(this).val()=="0" ) {
			$("#key_f_lay").attr("disabled", true);
			$("#secret_f_lay").attr("disabled", true);
			$("#name_f_lay").attr("disabled", true);
		}else{			
			$("#key_f_lay").attr("disabled", false);
			$("#secret_f_lay").attr("disabled", false);
			$("#name_f_lay").attr("disabled", false);
		}	
	})
	
	$("input[name='use_t_lay']").on("click", function(){
		
		if( $(this).val()=="0" ) {
			$("#key_t_lay").attr("disabled", true);
			$("#secret_t_lay").attr("disabled", true);		
		}else{			
			$("#key_t_lay").attr("disabled", false);
			$("#secret_t_lay").attr("disabled", false);			
		}	
	})

	$("input[name='use_k_lay']").on("click", function(){
		
		if( $(this).val()=="0" ) {
			$("#key_k_lay").attr("disabled", true);					
		}else{			
			$("#key_k_lay").attr("disabled", false);					
		}	
	})

	$("input[name='use_i_lay']").on("click", function(){
		
		if( $(this).val()=="0" ) {
			$("#key_i_lay").attr("disabled", true);
			$("#secret_i_lay").attr("disabled", true);
		}else{			
			$("#key_i_lay").attr("disabled", false);
			$("#secret_i_lay").attr("disabled", false);
		}	
	})

	// 애플 사용여부 클릭
	$("input[name='use_a_lay']").on("click", function(){
		
		if( $(this).val()=="0" ) {
			$("#key_a_lay").attr("disabled", true);
			$("#team_a_lay").attr("disabled", true);
			$("#clientid_a_lay").attr("disabled", true);
			$("#keyfile_a_lay").attr("disabled", true);
			$("#keyfile_uploader").attr("disabled", true);
		}else{			
			$("#key_a_lay").attr("disabled", false);
			$("#team_a_lay").attr("disabled", false);
			$("#clientid_a_lay").attr("disabled", false);
			$("#keyfile_a_lay").attr("disabled", false);
			$("#keyfile_uploader").attr("disabled", false);
		}	
	})

	
	//페이스북 설정

	$("#facebookbtn").click(function(){
		if( $("#use_f_lay").is(':checked') ) {
			if( !$("#key_f_lay").val() ) {
				alert('페이스북의 [API Key] 값을 정확히 입력해 주세요.');
				return false;
			}

			if( $("#key_f_lay").val() == "455616624457601" ) {
				alert('페이스북의 [API Key] 값을 정확히 입력해 주세요.(기본앱불가)');
				return false;
			}

			if( !$("#secret_f_lay").val() ) {
				alert('페이스북의 [API Secret] 설정값을 정확히 입력해 주세요.');
				return false;
			}
			if( $("#secret_f_lay").val() == "a6c595c16e08c17802ab4e4d8ac0e70b" ) {
				alert('페이스북의 [API Secret] 설정값을 정확히 입력해 주세요.(기본앱불가)');
				return false;
			}

			if( !$("#name_f_lay").val() ) {
				alert('페이스북의 [API Name] 설정값을 정확히 입력해 주세요.');
				return false;
			}

			if( $("#name_f_lay").val() == "fammerce_plus" ) {
				alert('페이스북의 [API Name] 설정값을 정확히 입력해 주세요.(기본앱불가)');
				return false;
			}

			//$(".use_f").attr("checked",true);
			$("#use_f").val(1);
		}else{
			//$(".use_f").attr("checked",true);
			$("#use_f").val(0);
		}
	
		var submit_use='y';
<?php if($TPL_VAR["sns"]["use_f"]== 1&&$TPL_VAR["sns"]["total_f"]> 0){?>
		if( !$("#use_f_lay").is(':checked') ) {
			if(confirm("페이스북 계정으로 쇼핑몰을 이용중인 회원이 <?php echo number_format($TPL_VAR["sns"]["total_f"])?>명 있습니다.\n페이스북 SNS계정을 사용하지 않을 경우 <?php echo number_format($TPL_VAR["sns"]["total_f"])?>명의 회원이 \n페이스북 SNS계정으로 로그인을 하지 못하게 됩니다.\n위와 같은 문제가 발생하더라도 계속 진행하시겠습니까?")){
				submit_use = 'y';
				$("#use_f_lay").attr("checked",true);
			}else{
				submit_use = 'n';
			}
		}
<?php }?>

		if(submit_use == 'y'){

			$("#key_f").val($("#key_f_lay").val());
			$("#secret_f").val($("#secret_f_lay").val());
			$("#name_f").val($("#name_f_lay").val());
<?php if($TPL_VAR["sns"]["sns_req_type"]&&$TPL_VAR["sns"]["sns_req_type"]!='FREE'){?>
				$("#sns_req_type").val("<?php echo $TPL_VAR["sns"]["sns_req_type"]?>");
<?php }else{?>
				$("#sns_req_type").val("BIZPLUS");
<?php }?>
			

			if(pagemode == "joinform"){
				$("#memberForm").submit();
				$("#snsdiv_f").dialog('close').remove();
				if($("#facebookguide_cont").css("display") == "block") $("#facebookguide_cont").dialog('close').remove();
			}else{
				var data = $("#snsjoinRegist").serialize();
				data += '&snsmode=facebook';
				$.ajax({
					'url' : '../member_process/joinform_sns_update',
					'type' : 'post',
					'data': data,
					'dataType': 'json',
					'success': function(res) {
						if(res.result == true){
							snsDisplayfnc('f','facebook','up');
							$("#snsdiv_f").dialog('close');
							if($("#facebookguide_cont").css("display") == "block") $("#facebookguide_cont").dialog('close');
						}else{
							openDialogAlert(res.msg,400,140);
						}
					}
					,'error': function(e){
					}
				});
			}
		}
	});

	//트위터 설정


	$("#twitterbtn").click(function(){
		if( $("#use_t_lay").is(':checked') ) {
			if( !$("#key_t_lay").val() ){
				alert('트위터의 [Consumer Key] 값을 정확히 입력해 주세요.');
				return false;
			}

			if( $("#key_t_lay").val() == 'ifHWJYpPA2ZGYDrdc5wQ' ){
				alert('트위터의 [Consumer Key] 값을 정확히 입력해 주세요.(기본앱불가)');
				return false;
			}

			if( !$("#secret_t_lay").val() ){
				alert('트위터의 [Consumer Secret] 설정값을 정확히 입력해 주세요.');
				return false;
			}
			if( $("#secret_t_lay").val() == 'cH5gWafZTZjY553zTqZ2YEd4pRPCsKjeHkB8TLficwI' ){
				alert('트위터의 [Consumer Secret] 설정값을 정확히 입력해 주세요.(기본앱불가)');
				return false;
			}

			//$(".use_t").attr("checked",true);
			$("#use_t").val(1);
		}else{
			//$(".use_t").attr("checked",false);
			$("#use_t").val(0);
		}
	
		var submit_use='y';
<?php if($TPL_VAR["sns"]["use_t"]== 1&&$TPL_VAR["sns"]["total_t"]> 0){?>
		if( !$("#use_t_lay").is(':checked') ) {
			if(confirm("트위터 계정으로 쇼핑몰을 이용중인 회원이 <?php echo number_format($TPL_VAR["sns"]["total_t"])?>명 있습니다.\n트위터 SNS계정을 사용하지 않을 경우 <?php echo number_format($TPL_VAR["sns"]["total_t"])?>명의 회원이 \n트위터 SNS계정으로 로그인을 하지 못하게 됩니다.\n위와 같은 문제가 발생하더라도 계속 진행하시겠습니까?")){
				submit_use = 'y';
				$("#use_t_lay").attr("checked",true);
			}else{
				submit_use = 'n';
			}
		}
<?php }?>

		if(submit_use == 'y'){

			$("#key_t").val($("#key_t_lay").val());
			$("#secret_t").val($("#secret_t_lay").val());

			if(pagemode == "joinform"){
				$("#memberForm").submit();
				$("#snsdiv_t").dialog('close').remove();
				if($("#twitterguide_cont").css("display") == "block") $("#twitterguide_cont").dialog('close').remove();
			}else{
				var data = $("#snsjoinRegist").serialize();
				data += '&snsmode=twitter';
				$.ajax({
					'url' : '../member_process/joinform_sns_update',
					'type' : 'post',
					'data': data,
					'dataType': 'json',
					'success': function(res) {
						if(res.result == true){
							snsDisplayfnc('t','twitter','up');
							$("#snsdiv_t").dialog('close');
							if($("#twitterguide_cont").css("display") == "block") $("#twitterguide_cont").dialog('close');
						}else{
							openDialogAlert(res.msg,400,140);
						}
					}
					,'error': function(e){
					}
				});
			}
		}
	});	

	$("#kakaobtn").click(function(){

		if( $("#use_k_lay").is(':checked') == true) {
			if( !$("#key_k_lay").val() ){
				alert('카카오의 [Javascript Key] 값을 정확히 입력해 주세요.');
				return false;
			}
			$("#use_k").val(1);
		}else{
			$("#use_k").val(0);
		}

		var submit_use='y';
<?php if($TPL_VAR["sns"]["use_k"]== 1&&$TPL_VAR["sns"]["total_k"]> 0){?>
		if( !$("#use_k_lay").is(':checked') ) {
			if(confirm("카카오 계정으로 쇼핑몰을 이용중인 회원이 <?php echo number_format($TPL_VAR["sns"]["total_k"])?>명 있습니다.\n카카오 SNS계정을 사용하지 않을 경우 <?php echo number_format($TPL_VAR["sns"]["total_k"])?>명의 회원이 \n카카오 SNS계정으로 로그인을 하지 못하게 됩니다.\n위와 같은 문제가 발생하더라도 계속 진행하시겠습니까?")){
				submit_use = 'y';
				$("#use_k_lay").attr("checked",true);
			}else{
				submit_use = 'n';
			}
		}
<?php }?>

		if(submit_use == 'y'){

			$("#key_k").val($("#key_k_lay").val());

			if(pagemode == "joinform"){
				$("#memberForm").submit();
				$("#snsdiv_k").dialog('close').remove();
				if($("#kakaoguide_cont").css("display") == "block") $("#kakaoguide_cont").dialog('close').remove();
			}else{
				var data = $("#snsjoinRegist").serialize();
				data += '&snsmode=kakao';
				$.ajax({
					'url' : '../member_process/joinform_sns_update',
					'type' : 'post',
					'data': data,
					'dataType': 'json',
					'success': function(res) {
						if(res.result == true){
							$("#snsdiv_k").dialog('close');
							if($("#kakaoguide_cont").css("display") == "block") $("#kakaoguide_cont").dialog('close');
							snsDisplayKakao('up');
						}else{
							openDialogAlert(res.msg,400,140);
						}
					}
					,'error': function(e){
					}
				});
			}
		}
	});

	$("#instagrambtn").click(function(){
		
		
		if( $("input[name='use_i_lay'][value=1]").is(':checked') ) {
			if( !$("#key_i_lay").val() ){
				alert('인스타그램의 [CLIENT ID] 설정값을 정확히 입력해 주세요.');
				return false;
			}

			if( !$("#secret_i_lay").val() ){
				alert('인스타그램의 [CLIENT SECRET] 설정값을 정확히 입력해 주세요.');
				return false;
			}
			$("#use_i").val(1);
		}else{
			$("#use_i").val(0);
		}


		var submit_use='y';
<?php if($TPL_VAR["sns"]["use_i"]== 1&&$TPL_VAR["sns"]["total_i"]> 0){?>
		if( !$("input[name='use_i_lay'][value=1]").is(':checked') ) {
			if(confirm("인스타그램 계정으로 쇼핑몰을 이용중인 회원이 <?php echo number_format($TPL_VAR["sns"]["total_i"])?>명 있습니다.\n인스타그램 계정을 사용하지 않을 경우 <?php echo number_format($TPL_VAR["sns"]["total_i"])?>명의 회원이 \n인스타그램 계정으로 로그인을 하지 못하게 됩니다.\n위와 같은 문제가 발생하더라도 계속 진행하시겠습니까?")){
				submit_use = 'y';
				$("input[name='use_i_lay'][value=0]").attr("checked",true);
			}else{
				submit_use = 'n';
			}
		}
<?php }?>
		
			
		$("#key_i").val($("#key_i_lay").val());
		$("#secret_i").val($("#secret_i_lay").val());
		$("#redirect_i").val($("#redirect_i_lay").val());
		$("#accesstoken_i").val($("#accesstoken_i_lay").val());
			

		if(pagemode == "joinform"){				
			$("#memberForm").submit();
			$("#snsdiv_i").dialog('close').remove();
			if($("#daumguide_cont").css("display") == "block") $("#daumguide_cont").dialog('close').remove();
		}else{
			var data = $("#snsjoinRegist").serialize();				
			data += '&snsmode=instagram';		
			$.ajax({
				'url' : '../member_process/joinform_sns_update',
				'type' : 'post',
				'data': data,
				'dataType': 'json',
				'success': function(res) {
					if(res.result == true){
						snsDisplayfnc('i','instagram','up');
						$("#snsdiv_i").dialog('close');
					}else{
						openDialogAlert(res.msg,400,140);
					}
				}
				,'error': function(e){}
			});
		}
			
	});

	// 애플 설정 저장
	$("#applebtn").click(function(){
		
		
		if( $("#use_a_lay:checked").val() == '1' ) {
			
			if( $.trim($("#key_a_lay").val()) == '' ){
				alert('애플의 [Key ID] 설정값을 정확히 입력해 주세요.');
				$("#key_a_lay").focus();
				return false;
			}

			if( $.trim($("#team_a_lay").val()) == '' ){
				alert('애플의 [Team ID] 설정값을 정확히 입력해 주세요.');
				$("#team_a_lay").focus();
				return false;
			}

			if( $.trim($("#clientid_a_lay").val()) == '' ){
				alert('애플의 [Client ID] 설정값을 정확히 입력해 주세요.');
				$("#clientid_a_lay").focus();
				return false;
			}
			
			if( $.trim($("#keyfile_a_lay").val()) == '' ){
				alert('애플의 [Key 파일등록]에 키 파일을 등록해주세요.');
				$("#keyfile_a_lay").focus();
				return false;
			}		

			$("#use_a").val(1);
		}else{
			$("#use_a").val(0);
		}


		var submit_use='y';
<?php if($TPL_VAR["sns"]["use_a"]== 1&&$TPL_VAR["sns"]["total_a"]> 0){?>
		if( $("#use_a_lay:checked").val() == '0' ) {
			if(confirm("애플 계정으로 쇼핑몰을 이용중인 회원이 <?php echo number_format($TPL_VAR["sns"]["total_a"])?>명 있습니다.\n애플 계정을 사용하지 않을 경우 <?php echo number_format($TPL_VAR["sns"]["total_a"])?>명의 회원이 \n애플 계정으로 로그인을 하지 못하게 됩니다.\n위와 같은 문제가 발생하더라도 계속 진행하시겠습니까?")){
				submit_use = 'y';
			}else{
				submit_use = 'n';
			}
		}
<?php }?>

		if(submit_use == 'y'){

			$("#use_a").val($("#use_a_lay:checked").val());
			$("#key_a").val($("#key_a_lay").val());
			$("#team_a").val($("#team_a_lay").val());
			$("#clientid_a").val($("#clientid_a_lay").val());
			$("#keyfile_a").val($("#keyfile_a_lay").val());
			
			// 회원 > 로그인 및 회원가입
			if(pagemode == "joinform"){
				$("#memberForm").submit();
				$("#snsdiv_a").dialog('close').remove();
			}
			// 설정 > SNS/외부연동
			else{
				var data = $("#snsjoinRegist").serialize();
				data	+= '&snsmode=apple';
				$.ajax({
					'url' : '../member_process/joinform_sns_update',
					'type' : 'post',
					'data': data,
					'dataType': 'json',
					'success': function(res) {
						if(res.result == true){
							snsDisplayfnc('a','apple','up');
							$("#snsdiv_a").dialog('close');
						}else{
							openDialogAlert(res.msg,400,140);
						}
					}
					,'error': function(e){}
				});
			}
		}
			
	});


	$(".btn_sns_guide").click(function(){

		var gubun = $(this).attr("gubun");
		switch(gubun){
			case "facebook":
				get_sns_guide_ajax(gubun,"<?php echo $TPL_VAR["sns"]["facebook_logo"]?> 페이스북 앱키(App ID) 발급 방법 안내","facebookguide_cont",1000,550);
			break;
			case "twitter":
				openDialog("<?php echo $TPL_VAR["sns"]["twitter_logo"]?> 트위터 Consumer Key 발급 방법 안내", "twitterguide_cont", {"width":"1000","height":"550","show" : "fade","hide" : "fade","modal":false});
			break;
			case "kakao":
				openDialog("<?php echo $TPL_VAR["sns"]["kakako_logo"]?> 카카오 앱키(App Key) 발급 방법 안내", "kakaoguide_cont", {"width":"730","height":"550","show" : "fade","hide" : "fade","modal":false});
			break;
			case "instagram":
				get_sns_guide_ajax(gubun,"<?php echo $TPL_VAR["sns"]["instagram_logo"]?> 인스타그램 앱키(Client ID) 발급 방법 안내","instagramguide_cont",1000,550);
			break;
			case "apple":
				get_sns_guide_ajax(gubun,"<?php echo $TPL_VAR["sns"]["apple_logo"]?> 애플 앱키(Client ID) 발급 방법 안내","appleguide_cont",1000,550);
			break;
		}

	});

	$(".punycode_helper").click(function(){

		var gubun = $(this).attr("gubun");
		switch(gubun){
			case "facebook":
				$('.sns_name_set').html('페이스북');
			break;
			case "twitter":
				$('.sns_name_set').html('트위터');
			break;
			case "kakao":
				$('.sns_name_set').html('카카오');
			break;
			case "apple":
				$('.sns_name_set').html('애플');
			break;
		}

		openDialog("발급 시 주의사항 - 한글도메인 변환하기", "to_punycode_cont", {"width":"660","height":"310","show" : "fade","hide" : "fade","modal":false});

	});

	$("#punycode_encode").click(function(){
		var unicode_domain	= $.trim($("#unicode_domain_lay").val());
		if(unicode_domain.indexOf('http://') > -1){
			unicode_domain	= unicode_domain.replace('http://', '');
		}

		$("#unicode_domain_lay").val(unicode_domain);

		if(unicode_domain.length < 4){
			alert('한글도메인을 정확히 입력해 주세요.');
			$("#unicode_domain_lay").focus();
			return;
		}

		var punycode_domain	= punycode.toASCII(unicode_domain);
		$(".punycode_domain_lay").html(punycode_domain);
		$("#puny_domain").val(punycode_domain);
		$("#uni_domain").val(unicode_domain);
	});

});

function go_access_token(){	
	$.getJSON('/admin/setting/instargram_ajax', function(data){
		if(!data.key_i || !data.secret_i){
			alert('CLIENT ID, CLIENT SECRET를 먼저 저장해주세요.');
			return false;
		}		
		var sUri	= 'https://api.instagram.com/oauth/authorize/?response_type=code';	
		sUri		+= '&client_id=' + data.key_i;
		sUri		+= '&redirect_uri=' + data.redirect_i;
		var instargramWin = window.open(sUri, "instargramPopup", "toolbar=no,scrollbars=no,resizable=no,top=500,left=500,width=800,height=600"); 
	});	
}
</script>
<!-- Domain Info -->
<input type="hidden" name="puny_domain" id="puny_domain" value="<?php if($TPL_VAR["sns"]["puny_domain"]){?><?php echo $TPL_VAR["sns"]["puny_domain"]?><?php }else{?><?php }?>" >
<input type="hidden" name="uni_domain" id="uni_domain" value="<?php if($TPL_VAR["sns"]["uni_domain"]){?><?php echo $TPL_VAR["sns"]["uni_domain"]?><?php }else{?><?php }?>" >

<?php if($TPL_VAR["sns"]["secret_n"]&&$TPL_VAR["sns"]["key_n"]){?>
<input type="hidden" name="secret_n" id="secret_n" value="<?php if($TPL_VAR["sns"]["secret_n"]){?><?php echo $TPL_VAR["sns"]["secret_n"]?><?php }else{?><?php }?>">
<input type="hidden" name="key_n" id="key_n" value="<?php if($TPL_VAR["sns"]["key_n"]){?><?php echo $TPL_VAR["sns"]["key_n"]?><?php }else{?><?php }?>">
<?php }?>
<input type="hidden" name="use_n" id="use_n"  value="<?php echo $TPL_VAR["sns"]["use_n"]?>" />
<!-- 카카오 key -->
<input type="hidden" name="key_k" id="key_k" value="<?php if($TPL_VAR["sns"]["key_k"]){?><?php echo $TPL_VAR["sns"]["key_k"]?><?php }else{?><?php }?>">
<input type="hidden" name="use_k" id="use_k"  value="<?php echo $TPL_VAR["sns"]["use_k"]?>" />
<!-- facebook key -->
<input type="hidden" name="callbackurl_f"  id="callbackurl_f"  value="<?php if($TPL_VAR["sns"]["callbackurl_f"]){?><?php echo $TPL_VAR["sns"]["callbackurl_f"]?><?php }else{?><?php echo $TPL_VAR["config_system"]["subDomain"]?><?php }?>" />
<input type="hidden" name="key_f"  id="key_f"  value="<?php if($TPL_VAR["sns"]["key_f"]){?><?php echo $TPL_VAR["sns"]["key_f"]?><?php }else{?><?php }?>" />
<input type="hidden" name="secret_f"  id="secret_f"  value="<?php if($TPL_VAR["sns"]["secret_f"]){?><?php echo $TPL_VAR["sns"]["secret_f"]?><?php }else{?><?php }?>" />
<input type="hidden" name="name_f"  id="name_f"  value="<?php if($TPL_VAR["sns"]["name_f"]){?><?php echo $TPL_VAR["sns"]["name_f"]?><?php }else{?><?php }?>" /> 
<input type="hidden" name="sns_req_type" id="sns_req_type"  value="<?php echo $TPL_VAR["sns"]["sns_req_type"]?>" />
<input type="hidden" name="domain_f" id="domain_f"  value="<?php echo $TPL_VAR["sns"]["domain_f"]?>" /> 
<input type="hidden" name="use_f" id="use_f"  value="<?php echo $TPL_VAR["sns"]["use_f"]?>" />
<!-- twitter key -->
<input type="hidden" name="key_t" id="key_t"value="<?php if($TPL_VAR["sns"]["key_t"]){?><?php echo $TPL_VAR["sns"]["key_t"]?><?php }else{?><?php }?>" />
<input type="hidden" name="secret_t" id="secret_t" value="<?php if($TPL_VAR["sns"]["secret_t"]){?><?php echo $TPL_VAR["sns"]["secret_t"]?><?php }else{?><?php }?>" />
<input type="hidden" name="use_t" id="use_t"  value="<?php echo $TPL_VAR["sns"]["use_t"]?>" />
<!-- instagram key -->
<input type="hidden" name="key_i" id="key_i" value="<?php if($TPL_VAR["sns"]["key_i"]){?><?php echo $TPL_VAR["sns"]["key_i"]?><?php }else{?><?php }?>">
<input type="hidden" name="secret_i" id="secret_i" value="<?php if($TPL_VAR["sns"]["secret_i"]){?><?php echo $TPL_VAR["sns"]["secret_i"]?><?php }else{?><?php }?>">
<input type="hidden" name="redirect_i" id="redirect_i" value="<?php if($TPL_VAR["sns"]["redirect_i"]){?><?php echo $TPL_VAR["sns"]["redirect_i"]?><?php }else{?><?php }?>">
<input type="hidden" name="accesstoken_i" id="accesstoken_i" value="<?php if($TPL_VAR["sns"]["accesstoken_i"]){?><?php echo $TPL_VAR["sns"]["accesstoken_i"]?><?php }else{?><?php }?>">
<input type="hidden" name="use_i" id="use_i"  value="<?php echo $TPL_VAR["sns"]["use_i"]?>" />
<!-- apple key -->
<input type="hidden" name="key_a" id="key_a" value="<?php if($TPL_VAR["sns"]["key_a"]){?><?php echo $TPL_VAR["sns"]["key_a"]?><?php }else{?><?php }?>">
<input type="hidden" name="team_a" id="team_a" value="<?php if($TPL_VAR["sns"]["team_a"]){?><?php echo $TPL_VAR["sns"]["team_a"]?><?php }else{?><?php }?>">
<input type="hidden" name="clientid_a" id="clientid_a" value="<?php if($TPL_VAR["sns"]["clientid_a"]){?><?php echo $TPL_VAR["sns"]["clientid_a"]?><?php }else{?><?php }?>">
<input type="hidden" name="keyfile_a" id="keyfile_a" value="<?php if($TPL_VAR["sns"]["keyfile_a"]){?><?php echo $TPL_VAR["sns"]["keyfile_a"]?><?php }else{?><?php }?>">
<input type="hidden" name="keyfile_new_a" id="keyfile_new_a" value="n">
<input type="hidden" name="use_a" id="use_a"  value="<?php echo $TPL_VAR["sns"]["use_a"]?>" />

<!-- 페이스북 설정 레이어 -->
<div  id="snsdiv_f" class="hide" >
	<div class="header">	
		<a href="https://www.firstmall.kr/customer/faq/1093" target="_blank" class="btn_sns_guide resp_btn">발급 방법 안내 </a>
		<button type="button" mode=""  class="punycode_helper resp_btn" gubun="facebook">한글도메인 변환</button>		
	</div>	
	<table class="table_basic thl">			
		<tr>
			<th>사용 여부</th>
			<td class="resp_radio">					
				<label>
					<input type="radio" name="use_f_lay"  id="use_f_lay"  value="1"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> checked <?php }else{?><?php if($TPL_VAR["sns"]["use_f"]=="1"){?>checked<?php }?> <?php }?>   /> 사용함
				</label>
				<label>
					<input type="radio" name="use_f_lay"  id="use_f_lay"  value="0"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]==""||$TPL_VAR["isdemo"]["isdemodisabled"]=="0"?> checked <?php }else{?><?php if($TPL_VAR["sns"]["use_f"]=="0"||$TPL_VAR["sns"]["use_f"]==""){?>checked<?php }?> <?php }?>   /> 사용 안 함
				</label>					
			</td>
		</tr>
		<tr>
			<th>APP ID</th>
			<td><input type='text'  name="key_f_lay"  id="key_f_lay" value="<?php if($TPL_VAR["sns"]["key_f"]!='455616624457601'){?><?php echo $TPL_VAR["sns"]["key_f"]?><?php }else{?><?php }?>"  class="wp95" <?php if($TPL_VAR["sns"]["use_f"]=="0"||$TPL_VAR["sns"]["use_f"]==""){?>disabled<?php }?>></td>
		</tr>
		<tr>
			<th>APP Secret</th>
			<td><input type='text'  name="secret_f_lay"  id="secret_f_lay" value="<?php if($TPL_VAR["sns"]["secret_f"]!='a6c595c16e08c17802ab4e4d8ac0e70b'){?><?php echo $TPL_VAR["sns"]["secret_f"]?><?php }else{?><?php }?>" class="wp95" <?php if($TPL_VAR["sns"]["use_f"]=="0"||$TPL_VAR["sns"]["use_f"]==""){?>disabled<?php }?>></td>
		</tr>
		<tr>
			<th>APP Namespace</th>
			<td><input type='text'  name="name_f_lay"  id="name_f_lay" value="<?php if($TPL_VAR["sns"]["name_f"]!='fammerce_plus'){?><?php echo $TPL_VAR["sns"]["name_f"]?><?php }else{?><?php }?>" class="wp95" <?php if($TPL_VAR["sns"]["use_f"]=="0"||$TPL_VAR["sns"]["use_f"]==""){?>disabled<?php }?>></td>
		</tr>		
	</table>

	<div class="footer">
		<button class="resp_btn active size_XL" type="button" <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> id="facebookbtn" <?php }?> >저장</button>
		<button class="resp_btn v3 size_XL" type="button" onclick="closeDialogEvent(this);">취소</button>
	</div>
</div>
<!-- 트위터 설정 레이어 -->
<div  id="snsdiv_t" class="hide" >
	<div class="header">		
		<a href="https://www.firstmall.kr/customer/faq/1094" target="_blank" class="btn_sns_guide resp_btn">발급 방법 안내 </a>
		<button type="button" mode=""  class="punycode_helper resp_btn" gubun="twitter">한글도메인 변환</button>
	</div>
	
	<table class="joinform-user-table table_basic thl">			
		<tr>
			<th>사용 여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="use_t_lay"  id="use_t_lay"  value="1"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> checked <?php }else{?><?php if($TPL_VAR["sns"]["use_t"]=="1"){?>checked<?php }?> <?php }?>   /> 사용함</label>
					<label><input type="radio" name="use_t_lay"  id="use_t_lay"  value="0"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> {isdemo.isdemodisabled=="" || isdemo.isdemodisabled="0"} checked <?php }else{?><?php if($TPL_VAR["sns"]["use_t"]=="0"||$TPL_VAR["sns"]["use_t"]==""){?>checked<?php }?> <?php }?> /> 사용 안 함</label>
				</div>
			</td>
		</tr>
		<tr >
			<th>Consumer Key(App ID)</th>
			<td><input type='text'  name="key_t_lay"  id="key_t_lay" value="<?php if($TPL_VAR["sns"]["key_t"]!='ifHWJYpPA2ZGYDrdc5wQ'){?><?php echo $TPL_VAR["sns"]["key_t"]?><?php }else{?><?php }?>" class="wp95" <?php if($TPL_VAR["sns"]["use_t"]=="0"||$TPL_VAR["sns"]["use_t"]==""){?>disabled<?php }?>></td>
		</tr>
		<tr >
			<th>Consumer  Secret(App Secret)</th>
			<td><input type='text'  name="secret_t_lay"  id="secret_t_lay" value="<?php if($TPL_VAR["sns"]["secret_t"]!='cH5gWafZTZjY553zTqZ2YEd4pRPCsKjeHkB8TLficwI'){?><?php echo $TPL_VAR["sns"]["secret_t"]?><?php }else{?><?php }?>" class="wp95" <?php if($TPL_VAR["sns"]["use_t"]=="0"||$TPL_VAR["sns"]["use_t"]==""){?>disabled<?php }?>></td>
		</tr>	
	</table>

	<div class="footer">
		<button class="resp_btn active size_XL" type="button" <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> id="twitterbtn" <?php }?> >저장</button>
		<button class="resp_btn v3 size_XL" type="button" onclick="closeDialogEvent(this);">취소</button>
	</div>
</div>

<!-- 페이스북 설정 가이드 -->
<div id="facebookguide_cont" class="hide" style="margin-top:5px;;">
</div>

<!-- 트위터 설정 가이드 -->
<div id="twitterguide_cont" class="hide" style="margin-top:5px;;">
	<table width="100%" class="joinform-user-table info-table-style"  align="center">
		<col width="150" /><col width="" />
		<tbody>
			<tr>
				<th class="its-th">발급 방법 안내(<a href="https://apps.twitter.com/" target="_blank" ><span class="cyanblue"><u>https://apps.twitter.com/</u></span></a>)</th>
			</tr>
			<tr>
				<td class="its-td center">
				<img src="/admin/skin/default/images/sns/sns_tw_step.jpg" /> 
				</td>
			</tr>
		</tbody>
	</table>
</div>

<!-- 카카오 설정 -->
<div  id="snsdiv_k" class="snsdiv_k hide" >
	<div class="header">	
		<a href="https://www.firstmall.kr/customer/faq/1095" target="_blank" class="btn_sns_guide resp_btn">발급 방법 안내 </a>
		<button type="button" mode=""  class="punycode_helper resp_btn" gubun="kakao">한글도메인 변환</button>			
	</div>
	<table class="joinform-user-table table_basic thl">
		<tr>
			<th>사용 여부</th>
			<td class="resp_radio">
				<label>						
					<input type="radio" name="use_k_lay"  id="use_k_lay"  value="1"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> checked <?php }else{?><?php if($TPL_VAR["sns"]["use_k"]=="1"){?>checked<?php }?> <?php }?> /> 사용함
				</label>
				<label>
					<input type="radio" name="use_k_lay"  id="use_k_lay"  value="0"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]=="0"||$TPL_VAR["isdemo"]["isdemodisabled"]==""?> checked <?php }else{?><?php if($TPL_VAR["sns"]["use_k"]=="0"||$TPL_VAR["sns"]["use_k"]==""){?>checked<?php }?> <?php }?> /> 사용 안 함
				</label>
			</td>
		</tr>

		<tr>
			<th>Javascript Key</th>
			<td><input type='text'  name="key_k_lay"  id="key_k_lay" value="<?php if($TPL_VAR["sns"]["key_k"]){?><?php echo $TPL_VAR["sns"]["key_k"]?><?php }else{?><?php }?>" class="wp95" <?php if($TPL_VAR["sns"]["use_k"]=="0"||$TPL_VAR["sns"]["use_k"]==""){?>disabled<?php }?>></td>
		</tr>				
	</table>
	
	<div class="footer">
		<button class="resp_btn active size_XL" type="button" <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> id="kakaobtn" <?php }?> >저장</button>
		<button class="resp_btn v3 size_XL" type="button" onclick="closeDialogEvent(this);">취소</button>
	</div>

</div>

<!-- 카카오 설정 가이드 -->
<div id="kakaoguide_cont" style="margin-top:5px;display:none;">
	<table width="100%" align="center" class="joinform-user-table info-table-style">
	<colgroup>
		<col width="">
	</colgroup>
	<tbody>
		<tr>
			<th class="its-th" height="28">카카오 앱키 발급 안내</th>
		</tr>
		<tr>
			<td class="its-td" style="padding:20px; line-height:2.0;">
				1. 'Kakao Developers <a href="https://developers.kakao.com/apps" target="_blank">(https://developers.kakao.com/apps)</a>'로 접속하여 우측 상단의 [로그인] 을 클릭합니다.<br>

				2. 이용정책 및 개인정보 수집 동의 후 이름과 소속 입력 후 [개발자 등록]을 클릭합니다.<br>
				<img src="/admin/skin/default/images/sns/img_kakao_guide1.jpg" alt="" /><br><br>

				3. 앱 이름 입력 후 [앱 만들기] 를 클릭합니다.<br>
				<img src="/admin/skin/default/images/sns/img_kakao_guide2.jpg" alt="" /><br><br>

				4. JavaScript 키 값이 발급되었습니다.<br>
				<img src="/admin/skin/default/images/sns/img_kakao_guide3.jpg" alt="" /><br><br>

				5. 좌측 메뉴>설정>일반 메뉴를 클릭합니다. 플랫폼 우측 하단의 [플랫폼 추가] 버튼을 클릭합니다.<br>
				<img src="/admin/skin/default/images/sns/img_kakao_guide4.jpg" alt="" /><br><br>

				6. '웹' 선택 후 사용하려는 쇼핑몰 주소를 입력합니다. 입력이 완료되었다면 [추가] 버튼을 클릭합니다.<br>
				<span class="red">도메인은 http://firstmall.kr, http://www.firstmall.kr, http://m.firstmall.kr 등, 모바일 도메인과 www 포함한 것과 포함하지 않은 것 모두 입력합니다.</span><br>
				<img src="/admin/skin/default/images/sns/img_kakao_guide5.jpg" alt="" /><br><br>

				7. 좌측 메뉴>설정>사용자 관리 메뉴를 클릭합니다. 사용자 관리 설정 'OFF'를 클릭하여 'ON'으로 변경합니다.<br>
				<img src="/admin/skin/default/images/sns/img_kakao_guide6.jpg" alt="" /><br><br>

				8. 동의항목>개인정보보호항목>프로필정보 (닉네임/프로필 사진)>수집목적에 '회원가입 및 로그인'을 입력합니다.<br>
				<img src="/admin/skin/default/images/sns/img_kakao_guide7.jpg" alt="" /><br><br>

				9. 화면의 <span class="red" style="display:inline;">사이트 도메인주소</span>와 <span class="red" style="display:inline;">Javascript 키</span> 값을 확인 후  퍼스트몰 관리자 페이지에 API Javascript Key 를 설정합니다.<br>

				10. 사용하여 운영함을 체크하면 쇼핑몰 회원가입, 로그인 화면에 카카오 버튼이 노출됩니다.<br>
			</td>
		</tr>
	</tbody>
	</table>
</div>

<!-- 인스타그램 설정 가이드 -->
<div id="instagramguide_cont" class="hide" style="margin-top:5px;;">
</div>

<!-- 한글 도메인 to punycode 레이아웃 -->
<div id="to_punycode_cont" class="hide">
	<div>
		SNS에서 연동 시, 한글 도메인 사용을 원하시는 경우 반드시 퓨니코드로 변환하여 입력해주세요. 그렇지 않는 경우 SNS 연동이 정상적으로 작동되지 않을 수 있습니다.
	</div>	
	<table class=" table_basic thl mt5">
		<col width="150" /><col width="" />
		<tbody>
			<tr>
				<th>한글도메인</th>
				<td>
					<div class="desc">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;입력시 예시) 퍼스트몰.com 또는 퍼스트몰.한국</div>
					http:// <input type='text'  name="unicode_domain_lay"  id="unicode_domain_lay" value="<?php if($TPL_VAR["sns"]["uni_domain"]){?><?php echo $TPL_VAR["sns"]["uni_domain"]?><?php }else{?><?php }?>" style="width:70%">
					<button id="punycode_encode" type="button" class="resp_btn active">변 환</button>
				</td>
			</tr>
			<tr>
				<th>변환 결과</th>
				<td>http://<span class="punycode_domain_lay"><?php if($TPL_VAR["sns"]["puny_domain"]){?><?php echo $TPL_VAR["sns"]["puny_domain"]?><?php }else{?><?php }?></span></td>
			</tr>
		</tbody>
	</table>	

	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>

<!-- 인스타그램 설정 -->
<div id="snsdiv_i" class="snsdiv_i hide" >
	<div class="header">		
		<a href="https://www.firstmall.kr/customer/faq/1096" target="_blank" class="btn_sns_guide resp_btn">발급 방법 안내 </a>
		<button type="button" mode=""  class="punycode_helper resp_btn" gubun="instagram">한글도메인 변환</button>			
	</div>
	
	<table class="table_basic thl">
		<tr>
			<th>사용 여부</th>
			<td>
				<label class="mr15">
					<input type="radio" name="use_i_lay"  id="use_i_lay"  value="1"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> checked <?php }else{?><?php if($TPL_VAR["sns"]["use_i"]=="1"){?>checked<?php }?> <?php }?> /> 사용함
				</label>
				<label>
					<input type="radio" name="use_i_lay"  id="use_i_lay"  value="0"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]=="0"||$TPL_VAR["isdemo"]["isdemodisabled"]==""?> checked <?php }else{?><?php if($TPL_VAR["sns"]["use_i"]=="0"||$TPL_VAR["sns"]["use_i"]==""){?>checked<?php }?> <?php }?> /> 사용 안 함
				</label>
			</td>
		</tr>	
		<tr>
			<th>CLIENT ID</th>
			<td><input type='text' name="key_i_lay"  id="key_i_lay" value="<?php echo $TPL_VAR["sns"]["key_i"]?>" class="wp95" <?php if($TPL_VAR["sns"]["use_i"]=="0"||$TPL_VAR["sns"]["use_i"]==""){?>disabled<?php }?>></td>
		</tr>
		<tr>
			<th>CLIENT SECRET</th>
			<td><input type='text' name="secret_i_lay"  id="secret_i_lay" value="<?php echo $TPL_VAR["sns"]["secret_i"]?>"class="wp95" <?php if($TPL_VAR["sns"]["use_i"]=="0"||$TPL_VAR["sns"]["use_i"]==""){?>disabled<?php }?>></td>
		</tr>
	</table>	

	<div class="footer">
		<button class="resp_btn active size_XL" type="button" <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> id="instagrambtn" <?php }?> >저장</button>
		<button class="resp_btn v3 size_XL" type="button" onclick="closeDialogEvent(this);">취소</button>
	</div>	
</div>

<!-- 애플 설정 -->
<div  id="snsdiv_a" class="snsdiv_a hide" >

	<div class="header">		
		<a href="https://www.firstmall.kr/customer/faq/1245" target="_blank" class="btn_sns_guide resp_btn">발급 방법 안내 </a>
		<button type="button" mode=""  class="punycode_helper resp_btn" gubun="instagram">한글도메인 변환</button>			
	</div>

	<table class="table_basic thl">
		<tr>
			<th>사용 여부</th>
			<td class="resp_radio">
				<label>
					<input type="radio" name="use_a_lay"  id="use_a_lay"  value="1"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> checked <?php }else{?><?php if($TPL_VAR["sns"]["use_a"]=="1"){?>checked<?php }?> <?php }?> /> 사용함
				</label>
				<label>
					<input type="radio" name="use_a_lay"  id="use_a_lay"  value="0"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]=="0"||$TPL_VAR["isdemo"]["isdemodisabled"]==""?> checked <?php }else{?><?php if($TPL_VAR["sns"]["use_a"]=="0"||$TPL_VAR["sns"]["use_a"]==""){?>checked<?php }?> <?php }?> /> 사용 안 함
				</label>
			</td>
		</tr>	
		<tr>
			<th>Key ID</th>
			<td><input type='text'  name="key_a_lay"  id="key_a_lay" value="<?php if($TPL_VAR["sns"]["key_a"]){?><?php echo $TPL_VAR["sns"]["key_a"]?><?php }else{?><?php }?>" <?php if($TPL_VAR["sns"]["use_a"]=="0"||$TPL_VAR["sns"]["use_a"]==""){?>disabled<?php }?>  style="width:95%"></td>
		</tr>
		<tr>
			<th>Team ID</th>
			<td><input type='text'  name="team_a_lay"  id="team_a_lay" value="<?php if($TPL_VAR["sns"]["team_a"]){?><?php echo $TPL_VAR["sns"]["team_a"]?><?php }else{?><?php }?>"  <?php if($TPL_VAR["sns"]["use_a"]=="0"||$TPL_VAR["sns"]["use_a"]==""){?>disabled<?php }?>  style="width:95%"></td>
		</tr>
		<tr>
			<th>Client ID</th>
			<td><input type='text'  name="clientid_a_lay"  id="clientid_a_lay" value="<?php if($TPL_VAR["sns"]["clientid_a"]){?><?php echo $TPL_VAR["sns"]["clientid_a"]?><?php }else{?><?php }?>"  <?php if($TPL_VAR["sns"]["use_a"]=="0"||$TPL_VAR["sns"]["use_a"]==""){?>disabled<?php }?>  style="width:95%"></td>
		</tr>
		<tr>
			<th>Key 파일등록</th>
			<td>
				<div>
					<span id="keyfile_name"><?php if($TPL_VAR["sns"]["keyfile_a"]){?><?php echo $TPL_VAR["sns"]["keyfile_a"]?><?php }else{?><?php }?></span>
					<input type="hidden" name="keyfile_a_lay" id="keyfile_a_lay" value="<?php if($TPL_VAR["sns"]["keyfile_a"]){?><?php echo $TPL_VAR["sns"]["keyfile_a"]?><?php }else{?><?php }?>"/>	
				</div>				
				<label class="resp_btn v2"><input type="file" id="keyfile_uploader"  accept=".p8" <?php if($TPL_VAR["sns"]["use_a"]=="0"||$TPL_VAR["sns"]["use_a"]==""){?>disabled<?php }?>>파일선택</label>				
				<div class="resp_message v2">- 파일형식 p8</div>
			</td>
		</tr>
	</table>	

	<div class="footer">
		<button class="resp_btn active size_XL" type="button" <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> id="applebtn" <?php }?> >저장</button>
		<button class="resp_btn v3 size_XL" type="button" onclick="closeDialogEvent(this);">취소</button>
	</div>	

	<!-- ajax 파일업로드 -->
	<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
	<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		/* 파일업로드버튼 ajax upload 적용 */
		var opt			= { 'addData' : 'allow_types=p8'};
		var callback	= function(res){
			var that		= this;
			var result		= eval(res);

			if(result.status) {
				$('#keyfile_name').text(result.fileInfo.file_name);
				$('#keyfile_a_lay').val(result.fileInfo.file_name);
				$('#keyfile_new_a').val('y');
			}else{
				$('#keyfile_uploader').val('');
				$('#keyfile_new_a').val('n');
				alert(result.msg);
			}
		};

		// ajax 이미지 업로드 이벤트 바인딩
		$('#keyfile_uploader').createAjaxFileUpload(opt, callback);
	});
	</script>

</div>