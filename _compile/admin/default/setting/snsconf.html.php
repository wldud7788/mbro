<?php /* Template_ 2.2.6 2022/05/17 12:37:02 /www/music_brother_firstmall_kr/admin/skin/default/setting/snsconf.html 000056668 */  $this->include_("snslinkurl");
$TPL_systemfblike_1=empty($TPL_VAR["systemfblike"])||!is_array($TPL_VAR["systemfblike"])?0:count($TPL_VAR["systemfblike"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<style>
	.snsconftitle {color:#000;font-weight:bold;letter-spacing:-1px !important;font-size:14px;font-family:'돋움',Dotum,AppleGothic,sans-serif;margin-left:3px}
	.navernotice {color:#999;font-size:12px;font-family:'돋움',Dotum,AppleGothic,sans-serif;}
	.dialogDiv { font-size:12px;display:none; }
	.dialogDiv .cont1 {margin:0px auto;width:940px;text-align:center;}
	.dialogDiv .cont1 p {text-align:left; line-height:20px;}
	.dialogDiv .cont1 p.tx1 {color:#696969;margin-top:15px;}
	.dialogDiv .cont1 p.tx2 {font-size:14px;font-weight:bold;line-height:22px;}
	.dialogDiv .cont1 .popimg {margin-top:49px;}
	.dialogDiv .cont1 .psbox1 {margin-top:29px;background-color:#f4f4f4;line-height:12px;font-size:11px;width:100%;text-align:left;}
	.dialogDiv .cont1 .psbox1 ul { padding:10px;list-style-type:disc;margin-left:24px; }
	.dialogDiv .cont1 .psbox1 li {padding:3px;}
	.dialogDiv .cont1 .psbox2 {margin-top:29px;background-color:#fff;line-height:12px;font-size:11px;width:100%;text-align:left;}
	.info-table-style th{height:20px;}

	.dialogDiv .cont1 .sns_icon {margin:4px 1px 4px 1px;}
	.none { color:#a1a1a1; }
	ul.facebookdesc {list-style: disc; padding-left:20px;}
	ul.facebookdesc li {color:#747474 !important; font-size:11px; letter-spacing: -1px;}
	.red { color:#c4060b;}
	.joinform-user-table.info-table-style th.its-th {padding-left:15px;}

	div#instagramConfThum_popup input.numbering {width:40px}
	div#instagramConfThum_popup input.gab {width:60px}
	input.copyToClipboard {border:0px;width:109px;}
	.info-table-style td.its-td {padding:5px 15px 5px 15px;}
	.info-table-style td.its-td span{word-break:break-all;display:block;}
</style>
<?php if($TPL_VAR["APP_USE"]=='f'){?>
<div id="fb-root"></div>
<script type="text/javascript">
	window.fbAsyncInit = function() {
		FB.init({
			appId: '<?php echo $TPL_VAR["APP_ID"]?>', //App ID
			status: true, // check login status
			cookie:true, // enable cookies to allow the server to access the session
			xfbml: true,  // parse XFBML,
			oauth: true,
			version: 'v<?php echo $TPL_VAR["APP_VER"]?>'
		});
		// Additional initialization code here
	};
	// Load the SDK Asynchronously
	(function(d){
		var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/ko_KR/sdk.js";
		ref.parentNode.insertBefore(js, ref);
	}(document));
	$(document).ready(function() {
		$(".fb-login-button").click(function(){});
		
	});
	function pagetab(){
		FB.ui({
			method: 'pagetab',
			redirect_uri: '<?php echo $TPL_VAR["redirect_uri_new"]?>'
		}, function(response){
			if (response != null && response.tabs_added != null) {
				$.each(response.tabs_added, function(pageid) {
					if(pageid) {
						openDialogAlert("성공적으로 설정되었습니다. <br> 이제부터 쇼핑몰의 상품을 facebook에서도 판매할 수 있게 되었습니다.",'480','150');
					}else{
						openDialogAlert('설정하지 못하였습니다. <br> 다시한번 확인해 주세요.','550','140',function(){});
					}
					/**
					//사용불가 
					FB.api(pageid, function(response) {
						var pagename = response.name;
						var pageurl		= response.link;
						var pageapplink		= response.link+"/app_<?php echo $TPL_VAR["APP_ID"]?>";
						$.ajax({
							'url' : '../sns_process/config_facebook_page',
							'type' : 'post',
							'data': {"method":"connect", "pageid":pageid, "pagename":pagename, "pageurl":pageurl, "pageapplink":pageapplink},
							'dataType': 'json',
							'success': function(res) {
								if(res.result == true) {
									openDialogAlert("성공적으로 설정되었습니다. <br> 이제부터 쇼핑몰의 상품을 facebook에서도 판매할 수 있게 되었습니다.",'480','150',function(){<?php if($TPL_VAR["APP_DOMAIN"]==$_SERVER["HTTP_HOST"]){?>document.location.reload();<?php }?>});
								}else{
									openDialogAlert(res.msg,'550','140',function(){});
								}
							}
						});
					});
					**/
				});
			}
		});
	}	
</script>
<?php }?>
<script type="text/javascript">
	function fbliketdcss(disabledlay, disablednolay){
		//숨김
		$("."+disabledlay).each(function(){
			$(this).css("background-color","#eeeeee");
			$(this).attr("disabled",true);
			$(this).find("input:radio").attr("disabled",true);
			$(this).find(".desc").hide();
<?php if($TPL_VAR["sns"]["facebook_app"]=='new'&&$TPL_VAR["sns"]["facebook_ob_like"]=='Y'){?>
				$("input[name='fb_like_box_type'][value='OP']").attr("checked",true);
<?php }else{?>
				$("input[name='new_fb_like_box_type'][value='NO']").attr("checked",true);
<?php }?>
		});
		//노출
		$("."+disablednolay).each(function(){
			$(this).css("background-color","#ffffff");
			$(this).attr("disabled",false);
			$(this).find("input:radio").attr("disabled",false);
			$(this).find(".desc").show();
		});
		fblikeSalePrice();
	}

	function fblikeSalePrice(){
<?php if($TPL_VAR["sns"]["facebook_app"]=='basic'&&$TPL_VAR["sns"]["facebook_ob_like"]=='Y'){?>
		var fblikeObj = $("input[name='fb_like_box_type'][value='NO']");
<?php }else{?>
		var fblikeObj = $("input[name='new_fb_like_box_type'][value='NO']");
<?php }?>
		// 좋아요 사용안할시 혜택 부분 disable
		if(fblikeObj.is(":checked") == true){

			$("#system_fblike_tbl").addClass("desc");

			$(".fbLikeDetail").hide();
			$(".btn-plus").css("display","none");
			$(".btn-minus").css("display","none");
			
			$("input[name='fblike_ordertype']").attr("disabled",true);
			$("input[name='fblike_price1[]']").each(function(i){ $(this).attr("disabled",true); });
			$("input[name='fblike_price2[]']").each(function(i){ $(this).attr("disabled",true); });
			$("input[name='fblike_sale_price[]']").each(function(i){ $(this).attr("disabled",true); });
			$("input[name='fblike_sale_emoney[]']").each(function(i){ $(this).attr("disabled",true); });
			$("input[name='fblike_sale_point[]']").each(function(i){ $(this).attr("disabled",true); });
		}else{
			$(".fbLikeDetail").show();
			$("#system_fblike_tbl").removeClass("desc");
			$("#system_fblike_tbl span").removeClass("desc");
			$(".btn-plus").css("display","block");
			$(".btn-minus").css("display","block");
			$("input[name='fblike_ordertype']").attr("disabled",false);
			$("input[name='fblike_price1[]']").each(function(i){
				$(this).attr("disabled",false);
			});
			$("input[name='fblike_price2[]']").each(function(i){
				$(this).attr("disabled",false);
			});
			$("input[name='fblike_sale_price[]']").each(function(i){
				$(this).attr("disabled",false);
			});
			$("input[name='fblike_sale_emoney[]']").each(function(i){
				$(this).attr("disabled",false);
			});
			$("input[name='fblike_sale_point[]']").each(function(i){
				$(this).attr("disabled",false);
			});
		}
	}

	function fblikeiconFileUpload(str){
		if(str > 0) {
			alert('아이콘을 선택해 주세요.');
			return false;
		}
		var frm = $('#fblikeiconRegist');
		frm.attr("action","../setting_process/fblikeiconUpload");
		frm.submit();
	}

	function fblikeiconDisplay(filenm){
		$(".fb-og-like-imglike").attr("src",filenm);
			$('#fblikeiconRegist')[0].reset();
		$("#fblikeiconPopup").dialog("close");
	}

	function fbunlikeiconFileUpload(str){
		if(str > 0) {
			alert('아이콘을 선택해 주세요.');
			return false;
		}
		var frm = $('#fbunlikeiconRegist');
		frm.attr("action","../setting_process/fbunlikeiconUpload");
		frm.submit();
	}
	
	function snslogoFileUpload(str){
		if(str > 0) {
			alert('로고를 선택해 주세요.');
			return false;
		}
		var frm = $('#snslogoRegist');
		frm.attr("action","../setting_process/snsconf_snslogo");
		frm.submit();
	}


	function snsjoinDisplay(sns){
		$(".snslogo_img").attr("src",filenm);
		$(".snslogo_img").css("display","block");
		$(".snslogo_img").css("width","100");
		$("#snslogomsg").css("display","none");
		$("#snslogoDelete").css("display","block");
		$('#snslogoRegist')[0].reset();
		$("#snslogoUpdatePopup").dialog("close");
	}

	function instagramConfThum()
	{
		openDialog("인스타그램 섬네일 설정하기", "instagramConfThum_popup", {"width":"600","height":"300"});
	}
	
	function copyToClipboard(obj) {		
		$(obj).parent().parent().find("input.copyToClipboard").select();
		var result	= document.execCommand("Copy");		
		if( result == true ){
			alert("복사되었습니다.");
		}
	}

	function addFLikeBenefit(price1, price2, sale_price, sale_emoney, sale_point)
	{
		var tblObj		= $("#system_fblike_tbl > tbody");
		var trObj		= $("#system_fblike_tbl > tbody > tr");
		var trLen		= trObj.length;

		//좋아요 사용안할시 혜택 추가하더라도 disabled 시키기
<?php if($TPL_VAR["sns"]["facebook_app"]=='basic'&&$TPL_VAR["sns"]["facebook_ob_like"]=='Y'){?>
		var fblikeObj = $("input[name='fb_like_box_type'][value='NO']");
<?php }else{?>
		var fblikeObj = $("input[name='new_fb_like_box_type'][value='NO']");
<?php }?>
		var disabled = "";
		if(fblikeObj.is(":checked") == true){
			disabled = "disabled";
		}

		if(trLen>1)$('.add_mess').hide();
		
		var addtr = "<tr><td class='clear'><table class='table_basic thl v3'><tr><th>혜택 <span class='count'>"+(trLen-1)+"</span></th><td class='clear'><table class='table_basic thl v3'><tr><th>가격</th>";		
		addtr += "<td>‘좋아요’한 상품 구매 시 상품 실 결제금액이 <input type='text' name='fblike_price1[]' value='" + price1 + "' size='8' class='line onlyfloat input-box-default-text' "+disabled+"' /> ~ <input type='text' name='fblike_price2[]' value='" + price2 + "' size='8' class='line onlyfloat input-box-default-text' "+disabled+"' />일 때 </td></tr><tr><th>추가 할인</th><td> ";
		addtr += "상품 할인가(판매가) x 수량의 <input type='text' name='fblike_sale_price[]' value='" + sale_price + "' size='3' class='line onlynumber input-box-default-text' "+disabled+"' />% 할인, </td></tr><tr><th>캐시</th><td>";
		addtr += "실 결제금액의 <input type='text' name='fblike_sale_emoney[]' value='" + sale_emoney + "' size='3' class='line onlynumber input-box-default-text' "+disabled+"' />% 추가 지급 유효기간:<?php echo $TPL_VAR["reservetitle"]?></td></tr><tr><th>포인트</th><td>";
		
<?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> 
		addtr += "<span readonly='readonly'  class='gray readonly' >";
<?php }?>

		addtr += "실 결제금액의 <input type='text' name='fblike_sale_point[]' value='" + sale_point + "' size='3' class='line onlynumber input-box-default-text' "+disabled+" style='text-align:right;' />% 추가 지급 유효기간:<?php echo $TPL_VAR["pointtitle"]?>";
		
<?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> 
		addtr += "</span>";
<?php }?>
		addtr += "</td></tr></table></td></tr></table></td><td class='center'><button type='button' class='etcDel btn_minus'></button></td>";
		addtr += "</tr>";
		tblObj.append(addtr);
	}

	$(document).ready(function() {
<?php if($TPL_VAR["sns"]["facebook_app"]=='new'&&$TPL_VAR["sns"]["facebook_ob_like"]=='Y'){?>
			fbliketdcss('fb_like_basic','fb_like_new');
<?php }else{?>
			fbliketdcss('fb_like_new','fb_like_basic');
<?php }?>
	
		$(".btn_facebook_pagetab_guide").click(function(){
 			openDialog("안내)페이스북 페이지탭 추가 방법 안내", "facebook_pagetab_guide", {"width":"900","height":"550","show" : "fade","hide" : "fade","modal":false}); 
		});

		$("#snsfbliketypebtn").click(function(){
			openDialog("연결방식의 차이점", "snsfbliketypelay", {"width":"805","height":"260"});
		});

		$("button#fblikeiconBtn").live("click",function(){
			$('#fblikeiconRegist')[0].reset();
			openDialog("좋아요 했을때 아이콘 <span class='desc'>등록 이미지 사이즈 60X20 를 등록해 주세요.</span>", "fblikeiconPopup", {"width":"460","height":"130","show" : "fade","hide" : "fade"});
		});

		$("button#fbunlikeiconBtn").live("click",function(){
			$('#fbunlikeiconRegist')[0].reset();
			openDialog("좋아요 안했을때 아이콘 <span class='desc'>등록 이미지 사이즈 60X20를 등록해 주세요.</span>", "fbunlikeiconPopup", {"width":"480","height":"130","show" : "fade","hide" : "fade"});
		});	


		$("#snsy").click(function(){
			$("#usesnstypelay").attr("disabled",false);
		});

		$("#snsn").click(function(){
			$("#usesnstypelay").attr("disabled",false);
		});
		
		//카카오톡 관련
		$("input[name='kakaotalk_use']").click(function(){
			if( $("input[name='kakaotalk_use']:checked").val() == "Y" ) {
				$("#kakaotalk_help_lay").show();
			}else{
				$("#kakaotalk_help_lay").hide();
			}
		});

		$("button#configfacebookpagebtn").bind("click",function(){
			openDialog("보안 안내란?", "configfacebookpagepopup", {"top":"100","width":"680","height":"800"});
		});


		$("button#snsconfigshare").bind("click",function(){
			var data = $("#snsconfigfacebookurllay").html();
			$('#popup').html(data);
			openDialog("쇼핑몰 정보 푸시 활용방법", "popup", {"width":"370","height":"250"});
		});

		var tagCopyClips = [];
		$("button#snsconfigurl").bind("click",function(){
			openDialog("쇼핑몰 정보 공유 활용방법", "snsconfigsharelinklay", {"width":"1024","height":"400"});

			$(".copy_snstag_btn").each(function(i){			

				
				if($("#copy_snstag_btn_"+i).length) return;

				$(this).attr("id","copy_snstag_btn_"+i);
				$(this).click(function(){
					clipboard_copy($(this).attr('code'));
					alert("클립보드에 저장되었습니다.");
				});
				
			});
		});

		
		$(".story_ad_banner").bind("click",function(){
			var storynumber = $(this).attr("story");
			popup('https://firstmall.kr/ec_hosting/shop/story_ad_popup.php?no='+storynumber,'760','470');
		});

<?php if($TPL_VAR["sns"]["facebook_review"]=='Y'){?>
		$("input[name='facebook_review']").attr('checked',true);
<?php }?>
<?php if($TPL_VAR["sns"]["facebook_interest"]=='Y'){?>
		$("input[name='facebook_interest']").attr('checked',true);
<?php }?>
<?php if($TPL_VAR["sns"]["facebook_buy"]=='Y'){?>
		$("input[name='facebook_buy']").attr('checked',true);
<?php }?>		

		//페이스북 전용앱 사용 선택시
		$("select[name='app_gubun']").bind("change",function(){
			 var app_gubun = $(this).val();
			 if(app_gubun == "new"){
				 $("#facebook_api_v1").hide();
				 $("#facebook_api_v2").show();				 
			 }else{
				 $("#facebook_api_v1").hide();
				 $("#facebook_api_v2").show();
			 }
		 });

		//트위터 전용앱 사용 선택시
		$("select[name='app_gubun_t']").bind("change",function(){
			 var app_gubun_t = $(this).val();
			 if(app_gubun_t == "new"){
				 $("#twitter_api_v1").hide();
				 $("#twitter_api_v2").show();
			 }else{
				 $("#twitter_api_v1").show();
				 $("#twitter_api_v2").hide();
			 }
		 });

		// 트위터 기본앱 사용 불가 처리 #19795 2018-06-27 hed
		$("input[name='use_t']").bind("click",function(){			
			denyTwiiterBasicApp();
		});

		$("select[name='app_gubun_t']").bind("change",function(){
			denyTwiiterBasicApp();
		});

		function denyTwiiterBasicApp(isChk){	
			
			if(typeof $("input[name='use_t'][value=0]").is(":checked") == true && $("select[name='app_gubun_t']").val()=="basic"){
				openDialogAlert("기본 앱 서비스가 종료되었습니다.<br/>전용 앱으로 설정 후 체크하여 주세요.",400,160,'parent','');
				$("input[name='use_t'][value=0]").click();
			}
		}

		/* facebook like sale 추가 */
	

		$("#system_fblike_tbl button#etcAdd").live("click",function(){
			addFLikeBenefit(0, 0, 0, 0, 0)
		});		


		/* facebook like  sale  삭제 */
		$("#system_fblike_tbl button.etcDel").live("click",function(){
			var len = $("#system_fblike_tbl > tbody > tr").length
			if(len > 2) $(this).parent().parent().remove();		
			if(len==3)$('.add_mess').show();
			var len = $("#system_fblike_tbl > tbody > tr").length;
		
			for(var i=0; i<len; i++)
			{			
				$("#system_fblike_tbl > tbody > tr").eq(2+i).find(".count").html(i+1);
			}
		});

		$(".detailview").on("click",function(){
			var mode	= $(this).attr("gb");
			var title	= "";
			var w		= 980;
			var h		= 600;
			switch(mode){
				case "facebook":	title = "페이스북 쇼핑몰"; h = 480;break;
				case "login":		title = "가입 및 로그인"; w = 1000; break;
				case "goodpoint":	title = "좋아요"; break;
				case "share":		title = "정보 공유 (퍼가기)"; w = "1050"; break;
				case "push":		title = "상품 미리보기"; break;
				case "ntalk":		title = "실시간 채팅"; break;
			}

			var openObj = "snsconf_detail";
			if($("#snsconf_detail").attr("mode") == mode && $("#snsconf_detail").html() !=''){
				openDialog(title,openObj, {"width":w,"height":h,"show" : "fade","hide" : "fade"});
			}else{
				$.get('../setting/snsconf_detail?mode='+mode, function(data) {
					$("#snsconf_detail").html(data);
					$("#snsconf_detail").attr("mode",mode);
					openDialog(title,openObj, {"width":w,"height":h,"show" : "fade","hide" : "fade"});
				});
			}
		});

		/* 메타태그(sns 소개) 저장 */
		$("#btnmetatag").on("click",function(){
			var descript = $("#metaTagDescription").val();
			var keyword  = $("#metaTagKeyword").val();

			var data = {"metaTagDescription":descript,"metaTagKeyword":keyword}
			$.ajax({
				'url' : '../setting_process/snsconf_snsmetatag',
				'type' : 'post',
				'data': data,
				'dataType': 'json',
				'success': function(res) {
					openDialogAlert("저장 되었습니다.",400,140,'parent','');
					$("#vmetaTagDescription").val(descript);
					$("#vmetaTagKeyword").val(keyword);
					$("#snsmetaTagUpdatePopup").dialog("close");
				}
				,'error': function(e){
				}
			});
		});		

		$(".facebookconflay").live("click",function(){
			openDialog("페이스북 전용앱 설정", "snsdiv_f", {"width":"700","height":"360","show" : "fade","hide" : "fade"});
		});

		$(".twitterconflay").live("click",function(){
			openDialog("트위터 설정", "snsdiv_t", {"width":"700","height":"325","show" : "fade","hide" : "fade"});
		});

		$(".naverconflay").click(function() {
			$.get('/admin/setting/sns_nid_api', function(data) {
				$('#snsdiv_n').html(data);
			});
			openDialog("네이버 아이디로 로그인 설정", "snsdiv_n", {"width":"700","height":"690","show" : "fade","hide" : "fade"});
		});

		$(".kakaoconflay").click(function() {
			openDialog("카카오 설정", "snsdiv_k", {"width":"700","height":"280","show" : "fade","hide" : "fade"});
		});

		$(".instagramconflay").click(function() {
			openDialog("인스타그램 설정", "snsdiv_i", {"width":"700","height":"335","show" : "fade","hide" : "fade"});
		});

		// 애플 로그인 설정
		$(".appleconflay").click(function() {
			openDialog("애플 설정", "snsdiv_a", {"width":"700","height":"430","show" : "fade","hide" : "fade"});
		});

		// 네이버 톡톡 연결 하기
		$(".ntalkconflay").click(function() {
			window.open("/sns/ntalk", "_NTALK", "width=360, height=480");
		});
		
		// 네이버 톡톡 활성화
		$(".ntalkenable").click(function(){
			if(confirm('쇼핑몰의 톡톡 노출을 시작합니다.')){
				$.ajax({
					'type':"POST",
					'url': '/sns/ntalk_enable',
					'dataType': 'json',
					'data':'use_talk=Y',
					'success': function (data){
						if(data.success){
							alert('활성화 처리 되었습니다.');
						}else{
							alert(data.message);
						}
						location.reload();
					}
				});
			}
		});

		// 네이버 톡톡 비활성화
		$(".ntalkdisable").click(function(){
			if(confirm('쇼핑몰의 톡톡 노출을 중지합니다.')){
				$.ajax({
					'type':"POST",
					'url': '/sns/ntalk_disable',
					'dataType': 'json',
					'data':'use_talk=N',
					'success': function (data){
						if(data.success){
							alert('비활성화 처리 되었습니다.');
						}else{
							alert(data.message);
						}
						location.reload();
					}
				});
			}
		});
		
		// 네이버 톡톡 연결 해제
		$(".ntalkdelete").click(function(){
			if(confirm('쇼핑몰의 톡톡 연결을 삭제하시겠습니까?')){
				$.ajax({
					'type':"POST",
					'url': '/sns/ntalk_disconnect',
					'dataType': 'json',
					'success': function (data){
						if(data.success){
							alert('연결 해제 되었습니다.');
						}else{
							alert(data.message);
						}
						location.reload();
					}
				});
			}			
		});		
		
		//전용앱중에서 오픈그라피제공앱은 제외@2015-07-14
<?php if($TPL_VAR["sns"]["fb_like_box_type"]=='OP'&&(!($TPL_VAR["sns"]["key_f"]!='455616624457601'&&$TPL_VAR["sns"]["facebook_publish_actions"])||($TPL_VAR["sns"]["key_f"]=='455616624457601'))){?>
		if($("input[name='fb_like_box_type'][value='OP']").is(":checked")){
			openDialogAlert("현재 페이스북 ‘좋아요’ 설정을 페이스북 간접 연결방식으로 사용중이십니다.<br />간접 연결방식은 종료 예정으로 페이스북 ‘좋아요’ 버튼 클릭 시<br />정상적으로 동작되지 않을 수 있습니다.<br />페이스북 ‘좋아요’ 설정을 페이스북 직접 연결방식으로 변경해 주십시오.",600,190,function(){
				$("input[name='fb_like_box_type'][value='API']").focus();
			});
		}
<?php }?>

				
	});

	function getshorturl() {
		$.ajax({
		'url' : '../setting_process/shorturl',
		'type' : 'get',
		'data': { "shorturl_test":"<?php echo $TPL_VAR["shorturl_test"]?>"},
		'dataType': 'json',
		'success': function(res) {
			var  shorturllaytag = '예) <a href="'+res.resulturl+'" target="blank">'+res.resulturl+'</a>';
			$(".shorturllay").html(shorturllaytag);
		}
	   });
	}

	$(document).ready(function() {	
		$("#facebookpagepopuplay").bind("click",function(){
<?php if($TPL_VAR["sns"]["key_f"]&&$TPL_VAR["sns"]["secret_f"]&&$TPL_VAR["sns"]["name_f"]){?>
<?php if($TPL_VAR["APP_DOMAIN"]==$_SERVER["HTTP_HOST"]){?>
			pagetab();
<?php }elseif($TPL_VAR["APP_DOMAIN"]!=$TPL_VAR["config_system"]["subDomain"]){?>
			window.open(gl_protocol+'<?php echo $TPL_VAR["APP_DOMAIN"]?>/admin/sns/config_facebook?popup=1&snsreferer=<?php echo $_SERVER["HTTP_HOST"]?>&pagetab=1', 'config_facebook', 'width=850px,height=480px,toolbar=no,location=no,resizable=yes, scrollbars=no');
<?php }else{?>
			window.open('../admin/sns/config_facebook?popup=1&snsreferer=<?php echo $_SERVER["HTTP_HOST"]?>', 'config_facebook', 'width=850px,height=480px,toolbar=no,location=no,resizable=yes, scrollbars=no');
<?php }?>
<?php }else{?>
			openDialogAlert("전용앱 정보를 다시 확인해 주세요.<br/>(설정 -> SNS/외부연동)",'400','140',function(){});
<?php }?>
		});

<?php if($TPL_VAR["systemfblike"]){?>
<?php if($TPL_systemfblike_1){foreach($TPL_VAR["systemfblike"] as $TPL_V1){?>				
				addFLikeBenefit(<?php echo $TPL_V1["price1"]?>,<?php echo $TPL_V1["price2"]?>,<?php echo $TPL_V1["sale_price"]?>,<?php echo $TPL_V1["sale_emoney"]?>,<?php echo $TPL_V1["sale_point"]?>);
<?php }}?>
<?php }?>		
	});
</script>

<div id="popup" class="hide"></div>
<form name="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/snsconf" target="actionFrame">
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
			<h2>SNS 연동</h2>
		</div>
		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<button  class="resp_btn active2 size_L" type="submit">저장</button>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="contents_container">
	<!-- 서브메뉴 탭 : 시작 -->
<?php $this->print_("setting_menu",$TPL_SCP,1);?>

	<!-- 서브메뉴 탭 : 끝 -->

	<!-- 서브메뉴 바디 : 시작-->
	<div class="contents_dvs">
		<div class="item-title">
			SNS 연동
			<span class="tooltip_btn tipBtn" onClick="showTooltip(this, '../setting/snsconf_detail?mode=snscode', '', '1000')"></span>
		</div>

		<ul class="tab_01 tabEvent">
			<li><a href="javascript:void(0);" data-showcontent="tabCon4" class="current">네이버</a></li>
			<li><a href="javascript:void(0);" data-showcontent="tabCon3">카카오</a></li>
			<li><a href="javascript:void(0);" data-showcontent="tabCon1">페이스북</a></li>
			<li><a href="javascript:void(0);" data-showcontent="tabCon2">트위터</a></li>
			<li><a href="javascript:void(0);" data-showcontent="tabCon6">애플</a></li>
		</ul>

		<table class="table_basic thl hide" id="tabCon1">
			<tr id="facebook_api_v2" class="<?php if($TPL_VAR["sns"]["facebook_app"]!='new'){?>hide <?php }?>">
				<th>설정</th>
				<td>															
					<button type="button" class="resp_btn v2 facebookconflay">설정</button>
					<span class="snslogin_use facebookconfig hide">미설정</span>			
				</td>
			</tr>

			<tr>
				<th>가입 및 로그인</th>
				<td>
				<!--
					<span class="snslogin_use facebookdeafultuse">
						<label class="mr15"><input type="radio" name="use_f" value="1" <?php if($TPL_VAR["sns"]["use_f"]){?>checked='checked'<?php }?>> 사용함</label>
						<label><input type="radio" name="use_f" value="0" <?php if($TPL_VAR["sns"]["use_f"]== 0){?>checked='checked'<?php }?>> 사용 안 함</label>
					</span>	-->
					
					<span class="snslogin_use facebookuse">사용 안 함</span>	
				</td>
			</tr>
			
			<tr class="hide">
				<th>
					좋아요
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/snsconf', '#tip5')"></span>
				</th>
				<td>
<?php if($TPL_VAR["sns"]["facebook_app"]!='new'&&$TPL_VAR["sns"]["facebook_ob_like"]=='Y'){?>
						<label><input type="radio" name="fb_like_box_type" value="API" <?php if($TPL_VAR["sns"]["fb_like_box_type"]=='API'||!$TPL_VAR["sns"]["fb_like_box_type"]){?> checked="checked" <?php }?> /> 사용함 </label>
						<span class="tooltip_btn mr15" onClick="showTooltip(this, '/admin/tooltip/snsconf', '#tip3')"></span>
						<label><input type="radio" name="fb_like_box_type" value="NO" <?php if($TPL_VAR["sns"]["fb_like_box_type"]=='NO'||!$TPL_VAR["sns"]["fb_like_box_type"]){?> checked="checked" <?php }?> /> 사용 안 함</label>
<?php }else{?>
					<!-- 전용앱 -->
						<label ><input type="radio" name="new_fb_like_box_type" value="API" <?php if($TPL_VAR["sns"]["fb_like_box_type"]=='API'||!$TPL_VAR["sns"]["fb_like_box_type"]){?> checked="checked" <?php }?> /> 사용함 </label>
						<span class="tooltip_btn mr15" onClick="showTooltip(this, '/admin/tooltip/snsconf', '#tip3')"></span>
						<label ><input type="radio" name="new_fb_like_box_type" value="NO" <?php if($TPL_VAR["sns"]["fb_like_box_type"]=='NO'||!$TPL_VAR["sns"]["fb_like_box_type"]){?> checked="checked" <?php }?> /> 사용 안 함</label>
<?php }?>
					<!-- 전용앱 끝 -->					
				</td>
			</tr>

			<tr class="hide"> <!--fbLikeDetail"-->
				<th>회원 적용 범위</th>
				<td>
					<label class="mr15"><input type="radio" name="fblike_ordertype" id="fbliketype1" value="1"  <?php if($TPL_VAR["fblike_ordertype"]== 1){?> checked="checked"  <?php }?> > 회원 혜택</label>
					<label><input type="radio" name="fblike_ordertype" id="fbliketype0" value="0" <?php if($TPL_VAR["fblike_ordertype"]== 0||!$TPL_VAR["fblike_ordertype"]){?> checked="checked"  <?php }?> > 회원, 비회원 혜택</label>
				</td>
			</tr>

			<tr class="hide"> <!--fbLikeDetail"-->
				<th>좋아요 혜택</th>
				<td>					
					<table class="table_basic"  id="system_fblike_tbl" >
								
					<colgroup>
						<col width="94%" />
						<col width="6%" />									
					</colgroup>

					<tbody>
					<tr>
						<th>내용</th>
						<th class="center">
							<button type="button" class="btn_plus" id="etcAdd" ></button>
						</th>
					</tr>
					
					<tr class="add_mess">
						<td colspan="2" class="center">혜택을 추가해주세요.</td>					
					</tr>
					</tbody>
					</table>

					<ul class="bullet_hyphen gray mt10">
						<li>캐시 및 포인트 지급 시점은 관리환경 > 설정 > <a class="link_blue_01" href="/admin/setting/reserve" target="_blank">캐시/포인트/예치금</a>에 따릅니다.</li>
						<li>상품 실 결제금액 = {상품 할인가(판매가) x 수량} – 할인(쿠폰,등급,좋아요,모바일,프로모션코드)</li>
					</ul>
				
				</td>
			</tr>

			<tr>
				<th>
					페이스북 쇼핑몰
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/snsconf', '#tip6')"></span>
				</th>
				<td>
<?php if($TPL_VAR["APP_USE"]=='f'&&serviceLimit('H_NFR')){?>
					<div>
<?php if($TPL_VAR["functionLimit"]){?>
						<button class="resp_btn" type="button" onclick="servicedemoalert('use_f');">페이스북 연결</button>
<?php }else{?>							
						<button class="resp_btn" type="button" id="facebookpagepopuplay">페이스북 연결</button>
<?php }?>
																				
					</div>
<?php }else{?>					
					<div>								
<?php if($TPL_VAR["functionLimit"]){?>
						<button class="resp_btn" type="button" onclick="servicedemoalert('use_f');">페이스북 연결</button>
<?php }else{?>
						<button class="resp_btn" type="button" disabled>페이스북 연결</button>
<?php }?>							
						<!---<span class="btn small orange"><button type="button" onclick="serviceUpgrade();">업그레이드 안내</button></span>--->												
					</div>								
<?php }?>
				</td>
			</tr>

			<tr class="hide">
				<th>앱 정보</th>
				<td>
				
					<div style="line-height:25px;">
						<select name="app_gubun" <?php if($TPL_VAR["sns"]["facebook_app"]=='new'||($TPL_VAR["sns"]["facebook_app"]=='basic'&&$TPL_VAR["sns"]["total_f"]> 0)){?> disabled="disabled" <?php }?> >
						<option value="basic" <?php if($TPL_VAR["sns"]["facebook_app"]=='basic'){?>selected<?php }?> >기본앱</option>
						<option value="new" <?php if($TPL_VAR["sns"]["facebook_app"]=='new'){?>selected<?php }?>>전용앱</option>
						</select>
						을 사용						
					</div>
					<div id="facebook_api_v1" class="<?php if($TPL_VAR["sns"]["facebook_app"]=='new'){?> hide <?php }?>  fb_like_basic">
						<table class="joinform-user-table table_basic thl" >								
							<tr>
								<th>앱명칭 <span class="red">*</span></th>
								<td>
<?php if($TPL_VAR["sns"]["facebook_app"]!='new'&&$TPL_VAR["sns"]["facebook_ob_like"]=='Y'){?>
								Fammerce Plus
<?php }else{?>
								앱 명칭 변경 가능
<?php }?>
								</td>
							</tr>
							<tr>
								<th>앱이미지 <span class="red">*</span></th>
								<td>
<?php if($TPL_VAR["sns"]["facebook_app"]!='new'&&$TPL_VAR["sns"]["facebook_ob_like"]=='Y'){?>
								<img src="/admin/skin/default/images/common/icon/thumb_fb_firstmall.gif">
<?php }else{?>
								앱 이미지 변경 가능
<?php }?>
								</td>
							</tr>
							<tr>
								<th>도메인 <span class="red">*</span></th>
								<td>
									http://<select name="likeurl" >
<?php if($TPL_VAR["config_system"]["domain"]&&$TPL_VAR["config_system"]["domain"]!=$TPL_VAR["config_system"]["subDomain"]){?>
										<option value="<?php echo $TPL_VAR["config_system"]["domain"]?>"  <?php if($TPL_VAR["sns"]["likeurl"]==$TPL_VAR["config_system"]["domain"]){?>selected<?php }?>><?php echo $TPL_VAR["config_system"]["domain"]?></option>
<?php }?>
<?php if($TPL_VAR["config_system"]["subDomain"]){?>
										<option value="<?php echo $TPL_VAR["config_system"]["subDomain"]?>" <?php if(!$TPL_VAR["sns"]["likeurl"]||$TPL_VAR["sns"]["likeurl"]==$TPL_VAR["config_system"]["subDomain"]){?>selected<?php }?>><?php echo $TPL_VAR["config_system"]["subDomain"]?></option>
<?php }?>
									</select>										
							 </td>
							</tr>
						</table>
					</div>								
				</td>
			</tr>			
		</table>			
		
		<table class="table_basic thl hide" id="tabCon2">
			<tr>
				<th>설정</th>
				<td>
					<!-- sns.twitter_app 을 통해 기본앱과 전용앱을 구분하여 설정할 수 있었으나 기본앱 서비스가 종료되어 더 이상 설정할 수 없도록 변경 by hed #38785 -->
					<div id="twitter_api_v1"  class="hide">
					</div>
					<div id="twitter_api_v2" class="">							
<?php if($TPL_VAR["functionLimit"]){?>
						<button type="button" class="resp_btn v2" onclick="servicedemoalert('use_f');">설정</button>
<?php }else{?>
						<button type="button" class="resp_btn v2 twitterconflay">설정</button>
<?php }?>
						<span class="snslogin_use twitterconfig hide"> 미설정</span>
					</div>
				</td>
			</tr>

			<tr>
				<th>가입 및 로그인</th>
				<td>					
					<span class="snslogin_use twitteruse">사용 안 함</span>
				</td>
			</tr>

			<tr class="hide">
				<th>앱 정보</th>
				<td>						
					<select name="app_gubun_t"  disabled="disabled">
					<option value="basic"  >기본앱</option>
					<option value="new" selected>전용앱</option>
					</select>
					을 사용						
				</td>
			</tr>				
		</table>			

		<table class="table_basic thl hide"  id="tabCon3">	
			<tr>
				<th>
					설정
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/snsconf', '#tip7')"></span>
				</th>
				<td>						
<?php if($TPL_VAR["functionLimit"]){?>
					<button type="button" class="resp_btn v2" onclick="servicedemoalert('use_f');">설정</button>
<?php }else{?>
					<button type="button" class="kakaoconflay resp_btn v2">설정</button>
<?php }?>
					<span class="snslogin_use kakaconfig hide"> 미설정</span>						
				</td>
			</tr>

			<tr>
				<th>가입 및 로그인</th>
				<td>					
					<span class="snslogin_use kakaouse">사용 안 함</span>						
				</td>
			</tr>

			<tr>
				<th>정보 공유</th>
				<td>					
					<span class="snslogin_use kakaotalk0">사용 안 함</span>
				</td>
			</tr>

			<tr>
				<th>
					카카오맵
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/snsconf', '#tip13')"></span>
				</th>
				<td><button type="button" class="copy_snstag_btn resp_btn" onClick="clipboard_copy(this)" code="{/||/=showMapApi('가로크기', '세로크기', '주소', '위치명', '지도레벨')}" >치환코드 복사</button></td>
			</tr>

		</table>

		
		<div id="tabCon4">
			<table class="table_basic thl" >		
				<tr>
					<th>설정</th>
					<td>						
<?php if($TPL_VAR["functionLimit"]){?>
						<button type="button" class="resp_btn v2" onclick="servicedemoalert('use_f');">설정</button>
<?php }else{?>
						<button type="button" class="naverconflay resp_btn v2">설정</button>
<?php }?>
						<span class="snslogin_use naverconfig hide"> 미설정</span>
					</td>
				</tr>
				<tr>
					<th>가입 및 로그인</th>
					<td>					
						<span class="snslogin_use naveruse">사용 안 함</span>						
					</td>
				</tr>
			</table>
			<div class="navernotice resp_message" id="tabCon4"> 
				- 네이버 아이디로 로그인 관련 FAQ <a href="https://www.firstmall.kr/customer/faq/1190" style="color:#4472c4" target="_blank"> 자세히보기></a>
			</div>
		</div>

		
		<table class="table_basic thl hide"  id="tabCon6">		
			<tr>
				<th>설정</th>
				<td>						
<?php if($TPL_VAR["functionLimit"]){?>
					<button type="button" class="resp_btn v2" onclick="servicedemoalert('use_a');">설정</button>
<?php }else{?>
					<button type="button" class="appleconflay resp_btn v2">설정</button>
<?php }?>
					<span class="snslogin_use appleconfig hide"> 미설정</span>
				</td>
			</tr>

			<tr>
				<th>가입 및 로그인</th>
				<td>					
					<span class="snslogin_use appleuse">사용 안 함</span>							
				</td>
			</tr>				
		</table>
	</div>

	<div class="contents_dvs">		
		<div class="item-title">네이버 톡톡</div>				
		<table class="table_basic thl">
			<tr>
				<th>
					네이버 톡톡
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/snsconf', '#tip9', 'sizeR')"></span>
				</th>

<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'){?>
				<td class="clear">	
					<div class="pd3">
						<span class="btn large <?php if($TPL_VAR["sns"]["ntalk_use"]==''||$TPL_VAR["sns"]["ntalk_use"]=='Y'){?>green<?php }?>"><button type="button" <?php if($TPL_VAR["sns"]["ntalk_use"]=='N'){?>class="ntalkenable"<?php }?>>ON</button></span>
						<span class="btn large <?php if($TPL_VAR["sns"]["ntalk_use"]=='N'){?>green<?php }?>"><button type="button" <?php if($TPL_VAR["sns"]["ntalk_use"]=='Y'){?>class="ntalkdisable"<?php }?>>OFF</button></span>
						<button type="button" class="ntalkdelete resp_btn v3">삭제</button>							
						<!-- <?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?> -->	
					</div>
					<table class="table_basic thl v3 top_bdr">	
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
						<tr>
							<th>반응형 제공</th>						
							<td>
								<label class="mr15"><input type="checkbox" name="ntalk_use_mobile_product" value="Y" <?php if($TPL_VAR["sns"]["ntalk_use_mobile_product"]=='Y'){?>checked="checked"<?php }?>/> 상품상세</label>
								<label class="mr15"><input type="checkbox" name="ntalk_use_mobile_main" value="Y" <?php if($TPL_VAR["sns"]["ntalk_use_mobile_main"]=='Y'){?>checked="checked"<?php }?>/> 메인</label>
								<label><input type="checkbox" name="ntalk_use_mobile_customer" value="Y" <?php if($TPL_VAR["sns"]["ntalk_use_mobile_customer"]=='Y'){?>checked="checked"<?php }?>/> 고객센터</label>
							</td>
						</tr>
						
<?php }else{?>
						<tr>
							<th>PC 제공</th>						
							<td>
								<label class="mr15"><input type="checkbox" name="ntalk_use_web_product" value="Y" <?php if($TPL_VAR["sns"]["ntalk_use_web_product"]=='Y'){?>checked="checked"<?php }?>/> 상품상세</label>
								<label class="mr15"><input type="checkbox" name="ntalk_use_web_quick" value="Y" <?php if($TPL_VAR["sns"]["ntalk_use_web_quick"]=='Y'){?>checked="checked"<?php }?>/> 퀵메뉴</label>
								<label><input type="checkbox" name="ntalk_use_web_customer" value="Y" <?php if($TPL_VAR["sns"]["ntalk_use_web_customer"]=='Y'){?>checked="checked"<?php }?>/> 고객센터</label>
							</td>
						</tr>
						<tr>
							<th>Mobile 제공</th>						
							<td>
								<label class="mr15"><input type="checkbox" name="ntalk_use_mobile_product" value="Y" <?php if($TPL_VAR["sns"]["ntalk_use_mobile_product"]=='Y'){?>checked="checked"<?php }?>/> 상품상세</label>
								<label class="mr15"><input type="checkbox" name="ntalk_use_mobile_main" value="Y" <?php if($TPL_VAR["sns"]["ntalk_use_mobile_main"]=='Y'){?>checked="checked"<?php }?>/> 메인</label>
								<label><input type="checkbox" name="ntalk_use_mobile_customer" value="Y" <?php if($TPL_VAR["sns"]["ntalk_use_mobile_customer"]=='Y'){?>checked="checked"<?php }?>/> 고객센터</label>
							</td>
						</tr>
<?php }?>
						<tr>
							<th>
								스니펫
								<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/snsconf', '#tip10')"></span>
							</th>						
							<td>
								<label class="mr15"><input type="radio" name="ntalk_use_sniffet" value="Y" <?php if($TPL_VAR["sns"]["ntalk_use_sniffet"]=='Y'){?>checked="checked"<?php }?>/> 사용함</label>
								<label><input type="radio" name="ntalk_use_sniffet" value="N" <?php if(!$TPL_VAR["sns"]["ntalk_use_sniffet"]||$TPL_VAR["sns"]["ntalk_use_sniffet"]=='N'){?>checked="checked"<?php }?>/> 사용 안 함</label>
									
							</td>
						</tr>	
					</table>
				</td>				
<?php }else{?>	
				<td>							
<?php if($TPL_VAR["functionLimit"]){?>
					<button type="button" class="resp_btn" onclick="servicedemoalert('use_f');">연결하기</button>
<?php }else{?>								
					<button type="button" class="ntalkconflay resp_btn">연결하기</button>
<?php }?>							
				</td>
<?php }?>	
			</tr>	
		</table>
	</div>

	<div class="box_style_05 mt20">
		<div class="title">안내</div>
		<ul class="bullet_circle">	
			<li>
				SNS 로 회원 가입 시 사용하는 회원 정보 항목 안내
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip8', 'sizeR')"></span>
			</>
			<li>SNS 를 통한 로그인 및 회원 가입은 설정 > 회원 > <a href="/admin/setting/member" class="link_blue_01">로그인 및 회원가입</a>에서도 설정이 가능합니다.</li>			
		</ul>
	</div>			
	<!-- 서브메뉴 바디 : 끝 -->
</div>
<!-- 서브 레이아웃 영역 : 끝 -->
</form>


<div id="snsconfigkakaotalklay" class="hide">
	카카오톡 링크 API 버전 업그레이드로 인해 모바일 쇼핑몰에서 카카오톡 링크 공유를 사용하시던 고객님께서는 다음 단계를 진행하시기 바랍니다.
	<div class="desc" style="line-height:180%;margin-left:5px" >
	<ol style="padding:1px;">
		<li style="padding-bottom:3px;">1. <a href="https://developers.kakao.com/api/kakao" target="blank" >https://developers.kakao.com/api/kakao</a> 접속한 후 하단의 <span class="bold">‘앱 개발 시작하기’</span> 버튼 클릭</li>
		<li style="padding-bottom:3px;">2. 카카오계정으로 로그인</li>
		<li style="padding-bottom:3px;">3. 앱 이름을 입력 후 ‘만들기’ 버튼 클릭
		<br/>
		<img src="/admin/skin/default/images/sns/kakao_1.JPG" >
		</li>
		<li style="padding-bottom:3px;">4. 해당 앱에 대한 키값이 발급되며 3번째 항목의 <span class="red">Javascript 키</span>값을 확인합니다.</li>
		<li style="padding-bottom:3px;">5. 좌측 메뉴에서 설정 – 일반 클릭 → 페이지 중간의 <img src="/admin/skin/default/images/sns/kakao_2.JPG" > 버튼 클릭</li>
		<li style="padding-bottom:3px;">6. ‘웹’ 클릭 → 사이트 <span class="red">모바일 도메인주소</span> 입력 (<?php if($TPL_VAR["config_system"]["domain"]){?>http://m.<?php echo $TPL_VAR["config_system"]["domain"]?><?php }else{?>http://m.<?php echo $TPL_VAR["config_system"]["subDomain"]?><?php }?>) 추가 버튼 클릭
		<br/>
			※ 모바일 주소를 반드시 확인하시고 입력하시기 바랍니다.
			<br/>
			<img src="/admin/skin/default/images/sns/kakao_3.JPG" >
		</li>
		<li style="padding-bottom:3px;">7. 화면의 <span class="red">사이트 도메인주소</span>와 <span class="red">Javascript 키</span> 값을 확인 후
			<br/>
		퍼스트몰 관리자페이지에 위의 내용을 모바일 도메인주소와 API Javascript Key에 각각 입력하세요.</li>
	</ol>
	</div>
</div>

<!--보안안내-->
<div id="configfacebookpagepopup" class="hide ">
	<div  >
		<div style="padding-bottom:10px;line-height:18px;" class="red left" >
		페이스북 사용자가 보안 연결(https) 사용 상태에서<br/>
		페이스북內 쇼핑몰 페이지를 방문하면<br/>
		↓ 아래의 보안 안내가 자동으로 보여지며, 페이스북 사용자가 안내와 같이<br/>
		&nbsp;&nbsp;보안 설정을 변경 후 쇼핑몰이 보여지게 됩니다.
		</div>
		 <div class="center" style="padding-bottom:5px;">
			<span class="btn small center"><button type="button" >샘플) 페이스북 쇼핑몰에서 보안 안내</button></span>
		</div>
		 <div class="center">
			<img src="/admin/skin/default/images/design/facebookpage-ie.jpg" align="absmiddle"  style="padding:5px;"/><br/>
			<img src="/admin/skin/default/images/design/facebookpage-chrome.jpg" align="absmiddle" style="padding:5px;" />
		</div>
	</div>
</div>

<div id="snsconfigfacebookurllay" class="hide">
	홍보하고 싶은 쇼핑몰의 페이지 주소(URL)을 복사하여
	페이스북에 등록하면 자동으로 푸시정보로 변환됩니다.
	<div class="desc" style="line-height:180%;margin-left:20px" >
	<b>쇼핑몰 주요 페이지</b><br />
	- 메인페이지<br />
	- 상품상세페이지<br />
	- 카테고리페이지<br />
	- 브랜드페이지<br />
	- 이벤트페이지<br />
	- 상품후기페이지
	</div>
</div>

<div id="snsconfigsharelinklay"  class="hide">
	아래와 같이 치환코드를 사용하세요. ( 단, 카카오톡/카카오스토리/LINE은 당연히 모바일에서만 동작합니다.)
	<div class="desc" style="line-height:180%;margin-left:20px" >
		<b>- 상품정보공유하기</b> : EYE-DESIGN > 상품상세페이지(/goods/view.html)에 치환코드 삽입<br />
		<b>- 이벤트정보공유하기</b> : 관리환경 > 프로모션/쿠폰 > 이벤트 관리에서 이벤트마다 설정<br />
		<b>- 게시판정보공유하기</b> : EYE-DESIGN > 게시글상세페이지(view.html)에 치환코드 삽입<br />
	</div>

	<br class="table-gap" />
	<table width="100%"  class="info-table-style" >
		<tr>
			<th  class="its-th-align">SNS치환코드</th>
			<th  class="its-th-align center">전체</th>
			<th  class="its-th-align center">페이스북</th>
			<th  class="its-th-align center">트위터</th>
			<th  class="its-th-align center">카카오톡</th>
			<th  class="its-th-align center">카카오스토리</th>
			<th  class="its-th-align center">LINE</th>
		</tr>
		<tr>
			<th  class="its-th-align center">상품</th>
			<td  class="its-td-align center"><?php echo snslinkurl('goods',$TPL_VAR["goods"]["goods_name"])?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsgoods"]?>', goods.goods_name)//SNS전체}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('goods',$TPL_VAR["goods"]["goods_name"],'fa')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsgoods"]?>', goods.goods_name,'fa')//페이스북}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('goods',$TPL_VAR["goods"]["goods_name"],'tw')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsgoods"]?>', goods.goods_name,'tw')//트위터}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('goods',$TPL_VAR["goods"]["goods_name"],'ka')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsgoods"]?>', goods.goods_name,'ka')//카카오톡}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('goods',$TPL_VAR["goods"]["goods_name"],'kakaostory')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsgoods"]?>', goods.goods_name,'kakaostory')//카카오스토리}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('goods',$TPL_VAR["goods"]["goods_name"],'line')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsgoods"]?>', goods.goods_name,'line')//LINE}" >치환코드복사</button></span></td>
		</tr>

		<tr>
			<th  class="its-th-align center">이벤트</th>
			<td  class="its-td-align center"><?php echo snslinkurl('event','이벤트명')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsevent"]?>', '이벤트명')}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('event','이벤트명','fa')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsevent"]?>', '이벤트명','fa')//페이스북}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('event','이벤트명','tw')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsevent"]?>', '이벤트명','tw')//트위터}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('event','이벤트명','ka')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsevent"]?>', '이벤트명','ka')//카카오톡}" >치환코드복사</button></span></td>

			<td  class="its-td-align center"><?php echo snslinkurl('event','이벤트명','kakaostory')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsevent"]?>', '이벤트명','kakaostory')//카카오스토리}" >치환코드복사</button></span></td>

			<td  class="its-td-align center"><?php echo snslinkurl('event','이벤트명','line')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsevent"]?>', '이벤트명','line')//LINE}" >치환코드복사</button></span></td>
		</tr>

		<tr>
			<th  class="its-th-align center">게시글</th>
			<td  class="its-td-align center"><?php echo snslinkurl('board',$TPL_VAR["subject"])?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsboard"]?>', subject)//SNS전체}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('board',$TPL_VAR["subject"],'fa')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsboard"]?>', subject,'fa')//페이스북}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('board',$TPL_VAR["subject"],'tw')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsboard"]?>', subject,'tw')//트위터}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('board',$TPL_VAR["subject"],'ka')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsboard"]?>', subject,'ka')//카카오톡}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('board',$TPL_VAR["subject"],'kakaostory')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsboard"]?>', subject,'kakaostory')//카카오스토리}" >치환코드복사</button></span></td>
			<td  class="its-td-align center"><?php echo snslinkurl('board',$TPL_VAR["subject"],'line')?>

				<br />
				<span class="btn small"><button type="button" class="copy_snstag_btn" code="{=snslinkurl('<?php echo $TPL_VAR["snsboard"]?>', subject,'line')//LINE}" >치환코드복사</button></span></td>
		</tr>
	</table>
</div>

<div id="fblikeiconPopup" class="hide">
	<form name="fblikeiconRegist" id="fblikeiconRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">
	<ul>
		<li style="float:left;width:100px;height:30px;text-align:center" ><input type="file" name="fblikeboxpciconFile" id="fblikeboxpciconFile" onChange="fblikeiconFileUpload();" /></li>
	</ul>
	</form>
</div>

<div id="fbunlikeiconPopup" class="hide">
	<form name="fbunlikeiconRegist" id="fbunlikeiconRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">
	<ul>
		<li style="float:left;width:100px;height:30px;text-align:center" ><input type="file" name="fbunlikeboxpciconFile" id="fbunlikeboxpciconFile" onChange="fbunlikeiconFileUpload();" /> </li>
	</ul>
	</form>
</div>

<form name="snsjoinRegist" id="snsjoinRegist" method="post" action="" target="actionFrame">
<input type="hidden" name="pagemode" id="pagemode" value="snsconf">
<!--- include : joinform_sns_setting.html -->
<?php $this->print_("sns_setting",$TPL_SCP,1);?>

</form>

<div id="facebookapi_popup" class="hide"><?php echo $TPL_VAR["facebookapi_popup"]?></div>
<div id="facebook_pagetab_guide" class="hide" style="margin-top:5px;;">
	<table width="100%" class="joinform-user-table info-table-style"  align="center">
		<col width="150" /><col width="" />
		<tbody>
			<tr>
				<td class="its-td center">
				<img src="/admin/skin/default/images/sns/facebook_api_pagetab.jpg" usemap="#facebook_api_pagetab" />
				<map id="facebook_api_pagetab" name="facebook_api_pagetab">
				<area shape="rect" alt="전용앱안내" title="전용앱안내" coords="323,43,402,70" href="../setting/snsconf" target="_blank" />
				<area shape="rect" alt="페이스북 개발자페이지" title="페이스북 개발자페이지" coords="30,75,221,90" href="https://developers.facebook.com" target="_blank" />
				</map>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<!-- 네이버 아이디로 로그인 API 연동 창 -->
<div id="snsdiv_n" class="snsdiv_n hide"></div>

<div id="instagramConfThum_popup" class="hide">
	<form name="instagramConfThumForm" method="post" action="../setting_process/instagramConfThum" target="actionFrame" >
	<table width="100%"  class="info-table-style" >																																									<table width="100%"  class="info-table-style" >		
		<tr>
			<th  class="its-th-align center">섬네일 크기</th>
			<td  class="its-td left">
				<select name="thumSize">
					<option value="150">150px</option>
					<option value="320">320px</option>
					<option value="640">640px</option>
				</select>
<?php if($TPL_VAR["aInstargramThumb"]["thumSize"]){?>
				<script>$("select[name='thumSize'] option[value='<?php echo $TPL_VAR["aInstargramThumb"]["thumSize"]?>']").attr('selected',true);</script>
<?php }?>
			</td>			
		</tr>
		<tr>
			<th  class="its-th-align center">섬네일 개수</th>
			<td  class="its-td left">
				<input type="text" name="thumNumber" class="numbering" value="<?php echo $TPL_VAR["aInstargramThumb"]["thumNumber"]?>" /> 개
				<span class="desc">최대 30개의 섬네일을 가져올 수 있습니다.</span>
			</td>			
		</tr>
		<tr>
			<th  class="its-th-align center">레이아웃</th>
			<td  class="its-td left">
				<input type="text" name="thumCell" class="numbering" value="<?php echo $TPL_VAR["aInstargramThumb"]["thumCell"]?>" /> X <input type="text" name="thumRow" class="numbering" value="<?php echo $TPL_VAR["aInstargramThumb"]["thumRow"]?>" />
				<span class="desc">스킨에 노출되는 행, 열 설정</span>
			</td>			
		</tr>
		<tr>
			<th  class="its-th-align center">섬네일 간격</th>
			<td  class="its-td left">
				<input type="text" name="thumPdl" class="gab" value="<?php echo $TPL_VAR["aInstargramThumb"]["thumPdl"]?>" /> px
				<span class="desc">섬네일 간격 설정</span>
			</td>			
		</tr>
		<tr>
			<th  class="its-th-align center">섬네일 행 간격</th>
			<td  class="its-td left">
				<input type="text" name="thumPdt" class="gab" value="<?php echo $TPL_VAR["aInstargramThumb"]["thumPdt"]?>" /> px
				<span class="desc">섬네일 행 간격 설정</span>
			</td>			
		</tr>
	</table>
	<div class="pdt5 center">
		<span class="btn large"><button type="submit">적용하기</button></span>
	</div>
	</form>
</div>


<script type="text/javascript">
	function snsDisplayKakao(mode){		
		if( $("input[name='use_k_lay'][value=1]").is(':checked') ) {
			$(".kakaouse").html('사용함');
			$(".kakaotalk0").html('사용함');
			$(".kakaotalk1").show();
			$(".kakaconfig").html('설정 완료');
		}else{
			$(".kakaouse").html('사용 안 함');
			$(".kakaotalk0").html('사용 안 함');
			$(".kakaotalk1").hide();
			$(".kakaconfig").html('미설정');
		}
		if(mode == 'up') openDialogAlert("설정이 저장 되었습니다.",400,140,'parent','');
	}

	snsDisplayKakao();

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
		$(".naverconfig").html('설정 완료');
		}else{
			$(".naveruse").html('사용 안 함');
			$(".naverconfig").html('미설정');
		}
	}


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


</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>