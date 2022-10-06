<?php /* Template_ 2.2.6 2022/05/17 12:36:30 /www/music_brother_firstmall_kr/admin/skin/default/member/sms.html 000041197 */ 
$TPL_admins_arr_1=empty($TPL_VAR["admins_arr"])||!is_array($TPL_VAR["admins_arr"])?0:count($TPL_VAR["admins_arr"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_restriction_item_1=empty($TPL_VAR["restriction_item"])||!is_array($TPL_VAR["restriction_item"])?0:count($TPL_VAR["restriction_item"]);
$TPL_replace_code_loop_1=empty($TPL_VAR["replace_code_loop"])||!is_array($TPL_VAR["replace_code_loop"])?0:count($TPL_VAR["replace_code_loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<style type="text/css">
	/* sms 종류 Tab 메뉴 CSS */
	div.sms-group-tab-lay {width:100%;border-bottom:1px solid #727b99;}
	table.sms-group-tab {width:750px;}
	table.sms-group-tab td {font-size:13px;text-align:center;height:26px;font-weight:normal;}
	table.sms-group-tab td.tab-start {width:1px;background:url('/admin/skin/default/images/common/tab_bg.gif') no-repeat;background-position:0;}
	table.sms-group-tab td.tab-end {width:0px;background:url('/admin/skin/default/images/common/tab_bg.gif') no-repeat;background-position:-598px 0;}
	table.sms-group-tab td.tab-item {min-width:100px; cursor:pointer;padding:0 0 0 10px;color:#7b7b7b;background-color:#ffffff;border-top:1px solid #727b99;border-right:1px solid #727b99;}
	table.sms-group-tab td.nolinknone {cursor:pointer;padding:0 0 0 10px;color:#7b7b7b;background-color:#ffffff;border-top:1px solid #727b99;border-right:1px solid #727b99;}
	table.sms-group-tab td.tab-item span.current-arrow {padding:0 5px;margin-left:12px;}
	table.sms-group-tab td.tab-item:hover {color:#727b99;background-color:#e8e9ee;}
	table.sms-group-tab td.tab-item.current {color:#ffffff;font-weight:bold;background-color:#727b99;}
	table.sms-group-tab td.tab-item.current:hover {color:#ffffff;font-weight:bold;background-color:#727b99;}
	table.sms-group-tab td.tab-item.current span.current-arrow {padding:0 5px;margin-left:5px;background:url('/admin/skin/default/images/common/icon_arw.gif') no-repeat;background-position:0 5px;}
	/* --- sms 종류 Tab 메뉴 CSS */

	/* 알림톡 사용 상태 */
	.kakao_alrim {margin:30px 5px 0 5px; border:1px solid #e0e0e0; background:#f9e94e; line-height:50px; text-indent:20px;}
	.kakao_alrim .icon {display:inline-block; vertical-align:middle; width:17px; height:18px; margin:-4px 7px 0 0; background:url('/admin/skin/default/images/design/k_icon01.png') no-repeat; text-indent:-9999px;}
	.kakao_alrim a {font-weight:bold; color:#333;}
	.kakao_alrim a:hover {text-decoration:underline;}

	/* 아이콘 */
	.icon_wrap {padding:10px;}
	.ico_kakao_on {border:1px solid #fe9b00; background:#fff; padding:1px 3px; font-size:11px; color:#fe7800;}
	.ico_kakao_off, .ico_kakao_x, .ico_sms_off {border:1px solid #b2b3b3; background:#c1c1c2; padding:1px 3px; font-size:11px; color:#fff;}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		//
		$(".sms_contents").on("keydown",function(){
			str = $(this).val();
			$(this).closest("td").find(".sms_byte").html(chkByte(str));
		});
		$(".sms_contents").on("keyup",function(){
			str = $(this).val();	
			$(this).closest("td").find(".sms_byte").html(chkByte(str));
		}).trigger('keyup');
		/*
		$('.del_message').click(function(){
			$(this).parent().parent().parent().find('textarea').val('');
			$(this).parent().parent().parent().find(".sms_byte").html(chkByte(''));
		});*/

		//
		$("#addNum").bind("click",function(){
			var cnt		= $(".admins_num1").length + 1;
			var idx		= cnt - 1;
			var addHtml	= "<tr><td class='pdt5'>";
			addHtml += "관리자("+cnt+") <input type=\"text\" name=\"admins_num1[]\" size=\"5\" maxlength=\"4\" class='admins_num1'> - <input type=\"text\" name=\"admins_num2[]\" size=\"5\" maxlength=\"4\"> - <input type=\"text\" name=\"admins_num3[]\" size=\"5\" maxlength=\"4\">";
			addHtml += " <span class=\"btn_minus\" id=\"delNum\"  idx=\""+idx+"\"></span>";
			addHtml += "</td></tr>";
			$('#add_plus_phone').append(addHtml);

			var disabled	= '';
			var name		= '';
			var ynHtml		= '';
			$(".admin_yn_lay").each(function(){
				name		= $(this).attr('area');
				disabled	= $(this).attr('dis');
				ynHtml	= '<div id="admins_yn_label_'+idx+'"><label><input type="checkbox" name="'+name+'_admins_yn_'+idx+'" value="Y" '+disabled+' /> 관리자('+cnt+')</label></div>';
				$(this).append(ynHtml);
			});
		});
		$("#delNum").live("click",function(){
			$("div#admins_yn_label_"+$(this).attr('idx')).remove();
			$(this).parent().parent().remove();
		});


		/* ### */
		$(".info_code").click(function(){
			$("#s_title").html($(this).attr("title"));
			setSmsInfo($(this).attr("name"));
			openDialog("사용 가능한 치환코드", "infoPopup", {"width":"550","height":"400"});
		});

		$(".default_msg").click(function(){
			var type	= $(this).attr("name");
			$.getJSON('./default_sms_msg?type='+type, function(data){

				if	(data.user){
					$("textarea[name='"+type+"_user']").val(data.user);
					$("textarea[name='"+type+"_user']").closest("td").find(".sms_byte").html(chkByte(data.user));
				}
				if	(data.admin){
					$("textarea[name='"+type+"_admin']").val(data.admin);
					$("textarea[name='"+type+"_admin']").closest("td").find(".sms_byte").html(chkByte(data.admin));
				}
			});
		});

		$(".notice_criteria").click(function(){
			openDialog("안내 기준","noticeCriteriaPopup_"+$(this).attr("name"),{"width":"400"});
		});

		 $(".btnRestriction").on("click",function(){
		   $.get('./sms_restriction?first=1', function(data) {
				$('#restrictionPopup').html(data);
<?php if(serviceLimit('H_FR')&&serviceLimit('H_PR')){?>
				var h = "520";
<?php }else{?>
				var h = "590";
<?php }?>
				openDialog("발송시간 제한 설정","restrictionPopup",{"width":"700","height":h});
		   });
		});

		$(".btnSmsReceptionGuide").on("click",function(){
			openDialog("[안내] 문자수신대상","receptionGuidePopup",{"width":"400","height":"320"});
		});

		// EMAIL
		$("#email_form").click(function(){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
			var screenWidth;
			var screenHeight;

			screenWidth = screen.width;
			screenHeight = screen.height;

			if(screenWidth > 1250) screenWidth = "1250";
			if(screenHeight > 1024) screenHeight = "1024";


			window.open('../batch/email_form',"send_email","menubar=no, toolbar=no, location=yes, status=no, resizble=yes, scrollbars=yes,width=" + screenWidth + ", height=" + screenHeight);
		});

		// SMS
		$("#sms_form").click(function(){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }else{?>
			var screenWidth;
			var screenHeight;
			<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
			screenWidth = 1200;
			screenHeight = 900;


			window.open('../batch/sms_form',"sms_form","menubar=no, toolbar=no, location=yes, status=no, resizble=yes, scrollbars=yes,width=" + screenWidth + ", height=" + screenHeight);
<?php }?>
		});

		// EMONEY
		$("#emoney_form").click(function(){
<?php if(!$TPL_VAR["auth_promotion"]){?>
			alert("권한이 없습니다.");
			return;
<?php }else{?>
			var screenWidth;
			var screenHeight;

			screenWidth = 1000;
			screenHeight = 900;


			window.open('../batch/emoney_form',"emoney_form","menubar=no, toolbar=no, location=yes, status=no, resizble=yes, scrollbars=yes,width=" + screenWidth + ", height=" + screenHeight);
<?php }?>

		});

		// POINT
		$("#point_form").click(function(){
<?php if(!$TPL_VAR["auth_promotion"]){?>
			alert("권한이 없습니다.");
			return;
<?php }else{?>
			var screenWidth;
			var screenHeight;

			screenWidth = screen.width;
			screenHeight = screen.height;

			if(screenWidth > 1250) screenWidth = "1250";
			if(screenHeight > 1024) screenHeight = "1024";


			window.open('../batch/point_form',"point_form","menubar=no, toolbar=no, location=yes, status=no, resizble=yes, scrollbars=yes,width=" + screenWidth + ", height=" + screenHeight);
<?php }?>
		});


		chkSMSDialog();

		$('.essential').click(function(){
			if(!$(this).is(':checked')){
				ess_txt = '비밀번호';
				if($(this).prop('name') == 'findid_user_yn') ess_txt = '아이디';
				$('.ess_txt').text(ess_txt);
				$('.essential_ck').removeClass('essential_ck');
				$(this).prop('checked',true).addClass('essential_ck');
				openDialog('알림', 'essential', {'width':430,'height':190});
			}
		});

		$("#limitNameBtn").on("click", function(){
			openDialog('상품명 길이 제한', 'limitName', {'width':600,'height':370});
		});

		var arr = location.hash.split('#');
		var no = arr[1]?arr[1]:1;		
		tabmenu(no);	
	});

	function batchInfo(kind){

		var title, reciveName;
		
		if(kind == "released" || kind == "coupon_released2"){
			title="출고완료";
			reciveName = "주문자";
		}else if(kind == "released2" || kind == "coupon_released"){
			title="출고완료";
			reciveName = "받는분";
		}else if(kind == "delivery" || kind == "coupon_delivery2"){
			title="배송완료";
			reciveName = "주문자";
		}else if(kind == "delivery2" || kind == "coupon_delivery"){
			title="배송완료";
			reciveName = "받는분";
		}else{
			title="결제확인";
			reciveName = "주문자";
		}
		$("#batch_info_title").html(title);
		$("#batch_info_reciveName").html(reciveName);
		openDialog("수동 일괄 "+title+"시", "batch_info", {"width":"380","height":"210"});

	}

	// 상품명 길이 제한 선택
	function goodsname_limit(obj){

		if($("select[name='"+obj+"_use']").val() == 'y'){
			$("."+obj+"_limit").show();
			$("select[name='"+obj+"_use']").css("width","89");
		}else{
			$("."+obj+"_limit").hide();
			$("select[name='"+obj+"_use']").css("width","145");
		}
	}

	// 종류 tab 메뉴
	function tabmenu(no){
		var i=1;
		
		$(".messTab > li > a").each(function(){
			$(this).removeClass("current");
			if(no == i){
				var change_idx	= "<?php if($TPL_VAR["scm_use_chk"]=='Y'){?>5<?php }else{?>4<?php }?>";
				$(".sms_message_group_lay").hide();
				$(this).addClass("current");
				$("#sms_restriction").hide();
				$("#sms_message_group_lay_"+$(this).attr('value')).show();
			}
			i = i+1;		
			
		});
		
	}

	function setSmsInfo(type){
		$(".s_info").hide();
		switch (type){
			case 'deposit':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["deposit"])?>').show();
			case 'join':	//회원가입 시
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["join"])?>').show();
			break;
			case 'withdrawal':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["withdrawal"])?>').show();
			break;
			case 'order':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["order"])?>').show();
			break;
			case 'settle':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["settle"])?>').show();
			break;
			case 'sms_charge':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["sms_charge"])?>').show();
			break;
			case 'autodeposit_charge':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["autodeposit_charge"])?>').show();
			break;
			case 'goodsflow_charge':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["goodsflow_charge"])?>').show();
			break;
			case 'released':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["released"])?>').show();
			break;
			case 'released2':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["released"])?>').show();
			break;
			case 'delivery':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["delivery"])?>').show();
			break;
			case 'delivery2':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["delivery"])?>').show();
			break;
			case 'cancel':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["cancel"])?>').show();
			break;
			case 'refund':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["refund"])?>').show();
			break;
			case 'findid':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["findid"])?>').show();
			break;
			case 'findpwd':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["findpwd"])?>').show();
			break;
			case 'coupon_released':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["coupon_released"])?>').show();
			break;
			case 'coupon_released2':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["coupon_released"])?>').show();
			break;
			case 'coupon_cancel':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["coupon_cancel"])?>').show();
			break;
			case 'coupon_delivery':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["coupon_delivery"])?>').show();
			break;
			case 'coupon_delivery2':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["coupon_delivery"])?>').show();
			break;
			case 'coupon_refund':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["coupon_refund"])?>').show();
			break;
			case 'dormancy':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["dormancy"])?>').show();
			break;
			case 'sorder_draft':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["sorder_draft"])?>').show();
			break;
			case 'sorder_cancel_draft':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["sorder_cancel_draft"])?>').show();
			break;
			case 'sorder_modify_draft':
				$('#re_<?php echo implode(",#re_",$TPL_VAR["use_replace_code"]["sorder_modify_draft"])?>').show();
			break;
		}
	}

	function chkSMSDialog(){
		if ( ("<?php echo $TPL_VAR["chk"]?>" == '' || "<?php echo $TPL_VAR["sms_auth"]?>" == '') && "<?php echo $TPL_VAR["send_phone"]?>" == "" ){
			$.get('../member_process/getAuthSendPopup', function(data) {
				$('#authPopup').html(data);
				openDialog("SMS 발송 안내 <span class='desc'>&nbsp;</span>", "authPopup", {"width":"800","height":"550"});
			});
			return;
		}else if("<?php echo $TPL_VAR["chk"]?>" == '' || "<?php echo $TPL_VAR["sms_auth"]?>" == ''){
			$.get('../member_process/getAuthPopup', function(data) {
				$('#authPopup').html(data);
				openDialog("SMS 발송 보안키 및 발신 번호 등록 안내 <span class='desc'>&nbsp;</span>", "authPopup", {"width":"800","height":"300"});
			});
			return;
		}else if("<?php echo $TPL_VAR["send_phone"]?>" == ""){
			$.get('../member_process/getSendPopup', function(data) {
				$('#authPopup').html(data);
				openDialog("SMS 발송 안내2 <span class='desc'>&nbsp;</span>", "authPopup", {"width":"800","height":"300"});
			});
		}
	}

	function openSafeKeyInfo(){
		openDialog('보안키 확인 방법','safekey_input_info', {'width':772,'height':635});
	}

	function dialog_linkage_sms_mail_info(){
		openDialog('외부 판매마켓 주문 문자/이메일 발송','linkage_sms_mail_info', {'width':772,'height':185});
	}
</script>

<form name="memberForm" id="memberForm" method="post" target="actionFrame" action="../member_process/sms">

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<ul class="page-buttons-left" style="z-index:1;">			
			<li><button type="button" id="sms_form" class="resp_btn active3 size_L">SMS 수동 발송</button></li>			
		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>SMS 발송 관리</h2>
		</div>

		<!-- 좌측 버튼
		<ul class="page-buttons-left">
			<li><span class="btn large icon"><button><span class="arrowleft"></span>이동버튼</button></span></li>
			<li><span class="btn large icon"><button><span class="arrowleft"></span>이동버튼</button></span></li>
		</ul> -->

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button  <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  type="button" <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> type="submit" <?php }?>  class="resp_btn active2 size_L">저장</button></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">

<?php if($TPL_VAR["kakaouse"]=='Y'){?>
	<div class="box_style_06 mb20">
		현재 귀하의 쇼핑몰은 "카카오 알림톡" 자동 발송을 사용 중입니다. <a href="/admin/member/kakaotalk_msg" target="_blank" class="resp_btn_txt">설정 방법 </a>
	</div>
<?php }?>

<?php $this->print_("top_menu",$TPL_SCP,1);?>


<?php if($TPL_admins_arr_1){foreach($TPL_VAR["admins_arr"] as $TPL_V1){?>
	<input type="hidden" name="admins_num1[]" size="5" maxlength="4" value="<?php echo $TPL_V1["number"][ 0]?>" />
	<input type="hidden" name="admins_num2[]" size="5" maxlength="4" value="<?php echo $TPL_V1["number"][ 1]?>" /> 
	<input type="hidden" name="admins_num3[]" size="5" maxlength="4" value="<?php echo $TPL_V1["number"][ 2]?>" />
<?php }}?>
	<!-- 서브 레이아웃 영역 : 시작 -->	

	<div class="item-title">SMS 발송 메시지</div>
	<div class="title_dvs mt0">
		<!-- 종류 TAB 메뉴 -->
		<ul class="tab_01 v3 messTab">			
			<li><a href="#1" onclick="tabmenu(1)"  value="1">회원 메시지</a></li>
			<li><a href="#2" onclick="tabmenu(2)"  value="2">주문 메시지</a></li>		
			<li><a href="#3" onclick="tabmenu(3)" value="3">배송 메시지</a></li>	
			<li><a href="#4" onclick="tabmenu(4)"  value="4">부가서비스 메세지</a></li>
<?php if($TPL_VAR["scm_use_chk"]=='Y'){?>
			<li><a href="#5" onclick="tabmenu(5)"  value="5">거래처 메세지</a></li>	
<?php }?>				
		</ul>
		<!-- //종류 TAB 메뉴 -->
		
		<button type="button" class="resp_btn v2 mb3" id="limitNameBtn">상품명 길이 제한</button>
	</div>	

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_K1=>$TPL_V1){?>
	<div id="sms_message_group_lay_<?php echo $TPL_K1?>" class="mt10 sms_message_group_lay <?php if($TPL_K1> 1){?>hide<?php }?>">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_V2["name"]){?><input type="hidden" name="group_list[]" value="<?php echo $TPL_V2["name"]?>" /><?php }?>
<?php if($TPL_I2&&$TPL_I2% 3== 0){?>
			</tr><tr><td height="5" colspan="3"></td></tr><tr>
<?php }?>
			<td width="30%" align="center" valign="top" class="pdr5 pdl5 pdb10">

<?php if($TPL_V2["text"]){?>
				<div class="clearbox">
					<table class="table_basic">
					<tr>
						<th class="its-th-align">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td></td>
								<td align="left">
									<?php echo $TPL_V2["text"]?>

<?php if($TPL_V2["add_text"]){?><span class="red"> = <?php echo $TPL_V2["add_text"]?></span><?php }?>
<?php if($TPL_V2["name"]=='released2'||$TPL_V2["name"]=='delivery2'||$TPL_V2["name"]=='coupon_released'||$TPL_V2["name"]=='coupon_delivery'){?>
									<span class="helpicon" title="주문자와 받는분이 다를 경우에만 발송됩니다."></span>
<?php }?>
								</td>
								<td align="right">
									<span>
<?php if($TPL_V2["kkotalk_use"]=='Y'){?>
										<img src="/admin/skin/default/images/design/ico_kakao_on.gif" alt="알림톡 ON" />
<?php }elseif($TPL_V2["kkotalk_use"]=='N'){?>
										<img src="/admin/skin/default/images/design/ico_kakao_off.gif" alt="알림톡 OFF" />
<?php }else{?>
										<img src="/admin/skin/default/images/design/ico_kakao_x.gif" alt="알림톡  X" />
<?php }?>
									</span>
								</td>
							</tr>
							</table>
						</th>
					</tr>
					<tr>
						<td class="center">
							<table border="0" cellpadding="0" cellspacing="0" style="margin:auto;">
							<tr>
								<td align="center" valign="top">
									<!-- ### USER -->
									<div class="sms-define-form">										
										<div class="sdf-body">
<?php if($TPL_V2["user_disabled"]=='disabled'){?>
											<textarea readonly style="background-color:#bbbbbb;color:#fff;text-align:center;"><?php echo "\n\n\n"?> &nbsp;고객 수신이<?php echo "\n"?>불필요한 메세지입니다.</textarea>
<?php }else{?>
											<textarea name="<?php echo $TPL_V2["name"]?>_user" class="sms_contents"><?php echo $TPL_V2["user"]?></textarea>
											
<?php }?>
										</div>									
									</div>
									<div>
										<label class="resp_checkbox fl"><input type="checkbox" name="<?php echo $TPL_V2["name"]?>_user_yn" value="Y" <?php if($TPL_V2["user_chk"]=='Y'||$TPL_V2["user_req"]=='y'){?>checked<?php }?> <?php if($TPL_V2["user_req"]=='y'){?>onclick="this.checked=true;"<?php }?> <?php echo $TPL_V2["user_disabled"]?> <?php if($TPL_V2["name"]=='findid'||$TPL_V2["name"]=='findpwd'){?>class="essential"<?php }?>/>
<?php if(in_array($TPL_V2["name"],array('join','findid','withdrawal','findpwd','dormancy'))){?>
										고객
<?php }elseif(in_array($TPL_V2["name"],array('released2','delivery2','coupon_released','coupon_delivery'))){?>
										받는분
<?php }elseif(in_array($TPL_V2["name"],array('sorder_draft','sorder_cancel_draft','sorder_modify_draft'))){?>
										거래처
<?php }else{?>
										주문자
<?php }?>
										</label>
<?php if($TPL_V2["user_disabled"]!='disabled'){?>									
										<span class="fr"><b class="sms_byte">0</b>byte</span>									
<?php }?>
									</div>
								</td>
								<td width="4%"></td>
								<td>
									<!-- ### ADMIN -->
									<div class="sms-define-form">									
										<div class="sdf-body">
<?php if($TPL_V2["disabled"]=='disabled'){?>
											<textarea readonly style="background-color:#bbbbbb;color:#fff;text-align:center;"><?php echo "\n\n\n"?> &nbsp;관리자 수신이<?php echo "\n"?>불필요한 메세지입니다.</textarea>
<?php }else{?>
											<textarea name="<?php echo $TPL_V2["name"]?>_admin" class="sms_contents"><?php echo $TPL_V2["admin"]?></textarea>
<?php }?>											
										</div>										
									</div>
								
									<div class="admin_yn_lay" area="<?php echo $TPL_V2["name"]?>" dis="<?php echo $TPL_V2["disabled"]?>">
<?php if($TPL_V2["disabled"]!='disabled'){?>
										<span class="fr"><b class="sms_byte">0</b>byte</span>
<?php }?>
<?php if($TPL_V2["arr"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["arr"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
										<span id="admins_yn_label_<?php echo $TPL_I3?>" class="fl" >
										<label class="resp_checkbox"><input type="checkbox" name="<?php echo $TPL_V2["name"]?>_admins_yn_<?php echo $TPL_I3?>" value="Y" <?php if($TPL_V2["admins_chk"][$TPL_I3]=='Y'){?>checked<?php }?> <?php echo $TPL_V2["disabled"]?>/> 관리자(<?php echo $TPL_I3+ 1?>)</label>
										</span><br/>
<?php }}?>
<?php }else{?>
										<span id="admins_yn_label_0" class="fl">
										<label class="resp_checkbox"><input type="checkbox" name="<?php echo $TPL_V2["name"]?>_admins_yn_0" value="Y"  <?php echo $TPL_V2["disabled"]?>/> 관리자(1)</label>
										</span>										
<?php }?>										
									</div>
									<div>
<?php if(serviceLimit('H_AD')&&$TPL_V2["provider_use"]=='y'){?>										
										<label class="resp_checkbox fl"><input type="checkbox" name="<?php echo $TPL_V2["name"]?>_provider_yn" value="Y" <?php if($TPL_V2["provider_chk"]=='Y'){?>checked<?php }?>  <?php echo $TPL_V2["disabled"]?>/> 입점판매자</label>
<?php }?>
									&nbsp;</div>
<?php if(in_array($TPL_V2["name"],array('settle','released','released2','delivery','delivery2','coupon_released','coupon_released2','coupon_delivery','coupon_delivery2'))){?>
									<div><span class="btn small orange fl"><button type="button" onclick="batchInfo('<?php echo $TPL_V2["name"]?>');">안내) 수동일괄 처리시</button></span></div>
<?php }?>
									
								</td>
							</tr>
							
<?php if($TPL_V2["rest_msg"]){?>
							<tr>
							   <td colspan="3" class="center">
							   <img src='/admin/skin/default/images/design/icon_order_admin.gif' align='absmiddle' title='관리자 처리 시'>
<?php if($TPL_V2["name"]=='settle'||$TPL_V2["name"]=='delivery'||$TPL_V2["name"]=='delivery2'){?>
							   <img src='/admin/skin/default/images/design/icon_order_system.gif' align='absmiddle' title='시스템 처리 시'>
<?php }?>
							   <?php echo $TPL_V2["rest_msg"]?></td>
							</tr>
<?php }?>
							</table>
						</td>
					</tr>
<?php if($TPL_V2["name"]=='dormancy'){?>
					<tr>
					<td class="clear">
						<table class="table_basic thl v3">			
							<colgroup>
							<col width="30%" />					
							<col width="70%" />						
						</colgroup>
							<tr>
								<th>
									발송시간
									<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/g_member', '#tip10')"></span>
								</th>								
								<td class="bdrb0">
									휴면처리 1개월 전
									<select name="dormancy_send_time" id="dormancy_send_time">
										<option value="08:30">08시 30분</option>
										<option value="09:00">09시</option>
										<option value="10:00">10시</option>
										<option value="11:00">11시</option>
										<option value="12:00">12시</option>
									</select>
								</td>
							</tr>						
						
						</table>				
						<script type="text/javascript">$("#dormancy_send_time").val("<?php echo $TPL_VAR["dormancy_send_time"]?>");</script>
					</td>
<?php }?>
<?php if($TPL_V2["name"]=='deposit'){?>
					<tr>
					<td class="clear">
						<table class="table_basic thl v3">			
							<colgroup>
								<col width="25%" />					
								<col width="75%" />						
							</colgroup>
								<tr>
									<th>
										발송시간
										<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/g_member', '#tip11', '470')"></span>
									</th>								
									<td class="pdr10 bdrb0">
										주문 접수일로부터
										<select name="deposit_send_day" id="deposit_send_day">
											<option value="2">2일 후</option>
											<option value="3">3일 후</option>
											<option value="4">4일 후</option>
											<option value="5">5일 후</option>
										</select>
										<select name="deposit_send_time" id="deposit_send_time">
											<option value="08:30">08시 30분</option>
											<option value="09:00">09시</option>
											<option value="10:00">10시</option>
											<option value="11:00">11시</option>
											<option value="12:00">12시</option>
										</select>
									</td>
								</tr>						
						</table>				
				
						<script type="text/javascript">$("#deposit_send_day").val("<?php echo $TPL_VAR["deposit_send_day"]?>");</script>
						<script type="text/javascript">$("#deposit_send_time").val("<?php echo $TPL_VAR["deposit_send_time"]?>");</script>
					</td>
<?php }?>					
					</tr>
					<tr>
						<td class="right ">
<?php if(in_array($TPL_V2["name"],array('sms_charge','autodeposit_charge','goodsflow_charge'))){?>
								<input type="button" value="안내 기준" name="<?php echo $TPL_V2["name"]?>" title="<?php echo $TPL_V2["text"]?>" class="notice_criteria resp_btn"/>
<?php }?>
							<input type="button" value="치환코드" name="<?php echo $TPL_V2["name"]?>" title="<?php echo $TPL_V2["text"]?>" class="info_code resp_btn"/>
							<input type="button" value="기본 메시지" name="<?php echo $TPL_V2["name"]?>" title="<?php echo $TPL_V2["text"]?>" class="default_msg resp_btn v2"/>
									
						</td>
					</tr>
					</table>					
				</div>
<?php }?>
			</td>
<?php }}?>
		</tr>
	</table>
</div>
<?php }}?>

	<div class="item-title">SMS 발송 시간 제한</div>
	<table class="table_basic thl">		
		<tr>
			<th>시간 제한 설정</th>
			<td>
				<button type="button" class="resp_btn v2 btnRestriction" >설정</button>				
			</td>
		</tr>
	</table>

</form>
</div>

<div id="limitName" class="hide">
	<form name="memberForm" id="memberForm" method="post" target="actionFrame" action="../member_process/sms_goods_limit">
		<table class="table_basic">		
			<tr>
				<th>상품명</th>
				<th>치환코드</th>
				<th>길이 제한</th>
			</tr>
			<tr>
				<td>주문 상품</td>
				<td>&#123;ord_item&#125;</td>
				<td>
					<select name="ord_item_use" onchange="goodsname_limit('ord_item')">
						<option value="y" <?php if($TPL_VAR["ord_item_use"]=='y'){?>selected<?php }?>>제한함</option>
						<option value="n" <?php if($TPL_VAR["ord_item_use"]=='n'){?>selected<?php }?>>제한 없음</option>
					</select>
					<span class="ord_item_limit"><input type="text" name="ord_item_limit" value="<?php echo $TPL_VAR["ord_item_limit"]?>" id="" size="5" class="right ord_item_limit"> 자</span>
				</td>
			</tr>
			<tr>
				<td>취소/반품 환불 상품</td>
				<td>&#123;repay_item&#125;</td>
				<td>
					<select name="repay_item_use" onchange="goodsname_limit('repay_item')">
						<option value="y" <?php if($TPL_VAR["repay_item_use"]=='y'){?>selected<?php }?>>제한함</option>
						<option value="n" <?php if($TPL_VAR["repay_item_use"]=='n'){?>selected<?php }?>>제한 없음</option>
					</select>
					<span class="repay_item_limit"><input type="text" name="repay_item_limit" value="<?php echo $TPL_VAR["repay_item_limit"]?>" id="" size="5" class="right repay_item_limit"> 자</span>
				</td>
			</tr>
			<tr>
				<td>출고/배송완료 상품</td>
				<td>&#123;go_item&#125;</td>
				<td>
					<select name="go_item_use" onchange="goodsname_limit('go_item')">
						<option value="y" <?php if($TPL_VAR["go_item_use"]=='y'){?>selected<?php }?>>제한함</option>
						<option value="n" <?php if($TPL_VAR["go_item_use"]=='n'){?>selected<?php }?>>제한 없음</option>
					</select>
					<span class="go_item_limit"><input type="text" name="go_item_limit" value="<?php echo $TPL_VAR["go_item_limit"]?>" id="" size="5" class="right go_item_limit"> 자</span>
				</td>
			</tr>
			<tr>
				<td>티켓 상품</td>
				<td>&#123;goods_item&#125;</td>
				<td>
					<select name="goods_item_use" onchange="goodsname_limit('goods_item')">
						<option value="y" <?php if($TPL_VAR["goods_item_use"]=='y'){?>selected<?php }?>>제한함</option>
						<option value="n" <?php if($TPL_VAR["goods_item_use"]=='n'){?>selected<?php }?>>제한 없음</option>
					</select>
					<span class="goods_item_limit"><input type="text" name="goods_item_limit" value="<?php echo $TPL_VAR["goods_item_limit"]?>" id="" size="5" class="right">자</span>
				</td>
			</tr>
		</table>
		
		<div class="footer">
			<button type="submit" class="resp_btn active size_XL">저장</button>
			<button type="button" class="resp_btn v3 size_XL" onclick="closeDialog('limitName')">취쇼</button>
		</div>		
	</form>
</div>


<!-- 발송시간 제한 -->
<div id="sms_restriction" class="hide">

	<div style="padding-left:15px;line-height:27px;">아래의 <span style="padding:0px 15px 0px 15px;line-height:3px;background-color:#fff9ce;border:1px solid #edd003;"></span>에 해당되는 행위가 설정된 심야시간에 발생할 경우 해당 문자는 설정된 오전 시간에 자동으로 발송됩니다.
	<span class="btn small cyanblue"></span>
	</div>

	<table class="info-table-style" style="width:100%">
		<!-- 테이블 헤더 : 시작 -->
		<colgroup>
			<col width="6%" />
			<col width="18%" />
			<col width="12%" />
			<col width="23%" />
			<col width="23%" />
			<col width="6%" />
			<col width="6%" />
			<col width="6%" />
		</colgroup>
		<thead class="lth">
		<tr>
			<th colspan="2" rowspan="2" class="its-th-align">문자 발송 경우</th>
			<th colspan="3" class="its-th-align">행위(액션)</th>
			<th colspan="3" class="its-th-align">문자수신대상 <span class="btn small cyanblue"><button type="button" class="btnSmsReceptionGuide">안내</button></span></th>
		</tr>
		<tr>
			<th class="its-th-align">고객</th>
			<th class="its-th-align">관리자</th>
			<th class="its-th-align">시스템</th>
			<th class="its-th-align">고객</th>
			<th class="its-th-align">관리자</th>
			<th class="its-th-align">입점 판매자</th>
		</tr>
		</thead>
		<tbody class="ltb otb" >
<?php if($TPL_restriction_item_1){foreach($TPL_VAR["restriction_item"] as $TPL_K1=>$TPL_V1){?>

<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<?php if($TPL_K2!='usecnt'){?>
<?php if(!(serviceLimit('H_ST'))||(serviceLimit('H_PRST')&&$TPL_K1!='coupon')){?>
		<tr class="list-row">
<?php if($TPL_VAR["ori_key"]!=$TPL_K1){?>
			<td rowspan="<?php echo count($TPL_V1)- 1?>" class="its-td-align center"><?php echo $TPL_VAR["restriction_title"][$TPL_K1]?></td>
<?php }?>
			<td class="its-td-align"><span class="pdl10"><?php if(!$TPL_VAR["restriction_title"][$TPL_K2]){?>×<?php }else{?><?php echo $TPL_VAR["restriction_title"][$TPL_K2]?><?php }?></span></td>
			<td class="its-td-align center"><?php if(!$TPL_V2["ac_customer"]){?>×<?php }else{?><div style="padding-left:5px;text-align:left;"><?php echo $TPL_V2["ac_customer"]?></div><?php }?></td>
			<td class="its-td-align center" <?php if($TPL_V2["use"]=='y'&&$TPL_V2["ac_admin"]){?>style="background-color:#fff9ce;"<?php }?>><?php if(!$TPL_V2["ac_admin"]){?>×<?php }else{?><div style="padding-left:5px;text-align:left;"><?php echo $TPL_V2["ac_admin"]?></div><?php }?></td>
			<td class="its-td-align center" <?php if($TPL_V2["use"]=='y'&&$TPL_V2["ac_system"]){?>style="background-color:#fff9ce;"<?php }?>><?php if(!$TPL_V2["ac_system"]){?>×<?php }else{?><div style="padding-left:5px;text-align:left;"><?php echo $TPL_V2["ac_system"]?></div><?php }?></td>
			<td class="its-td-align center"><?php if(!$TPL_V2["tg_customer"]){?>×<?php }else{?><?php echo $TPL_V2["tg_customer"]?><?php }?></td>
			<td class="its-td-align center"><?php if(!$TPL_V2["tg_admin"]){?>×<?php }else{?><?php echo $TPL_V2["tg_admin"]?><?php }?></td>
			<td class="its-td-align center"><?php if(!$TPL_V2["tg_seller"]){?>×<?php }else{?><?php echo $TPL_V2["tg_seller"]?><?php }?></td>
			<?php echo $this->assign('ori_key',$TPL_K1)?>

		</tr>
<?php }?><?php }?>
<?php }}?>
<?php }}?>
		</tbody>
	</table>
</div>

<div id="infoPopup" class="hide">
	<div class="content">
		<table class="table_basic tdc">
		<colgroup>
			<col width="30%" />
			<col width="70%" />
		</colgroup>
		<thead>
		<tr>
			<th>치환코드</th>
			<th>설명</th>
		</tr>
		</thead>
		<tbody>
<?php if($TPL_replace_code_loop_1){foreach($TPL_VAR["replace_code_loop"] as $TPL_K1=>$TPL_V1){?>
		<tr class="s_info hide" oldid="s_tab<?php echo $TPL_K1+ 1?>" id="re_<?php echo $TPL_V1["cd"]?>">
			<td>&#123;<?php echo $TPL_V1["cd"]?>&#125;</td>
			<td class="left"><?php echo $TPL_V1["nm"]?> <?php if($TPL_V1["etc"]){?><br /><span style='color:#696969;font-size:11px;line-height:15px;font-family:돋움;'><?php echo $TPL_V1["etc"]?></span><?php }?></td>
		</tr>
<?php }}?>
		</tbody>
		</table>
	</div>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialog('infoPopup')">닫기</button>
	</div>
</div>

<div id="authPopup" class="hide"></div>
<div id="restrictionPopup" class="hide"></div>
<div id="receptionGuidePopup" class="hide">
	<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="20%" />
		<col width="80%" />
	</colgroup>
	<thead>
	<tr>
		<th class="its-th-align center" >기호</th>
		<th class="its-th-align center" >설명</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td class="its-td-align center">×</td>
		<td class="its-td">수신 불가</td>
	</tr>
	<tr>
		<td class="its-td-align center">○</td>
		<td class="its-td">수신 가능</td>
	</tr>
	<tr>
		<td class="its-td-align center"><span style='color:#696969'>●</span></td>
		<td class="its-td">수신 가능<br /><span style='color:#696969;font-size:11px;line-height:15px;font-family:돋움;'>(관리자 처리 또는 시스템 자동 처리 시 발송시간<br />제한을 설정하지 않음)</span></td>
	</tr>
	<tr>
		<td class="its-td-align center"><span style='color:#d90000'>●</span></td>
		<td class="its-td">수신 가능<br /><span style='color:#696969;font-size:11px;line-height:15px;font-family:돋움;'>(관리자 처리 또는 시스템 자동 처리 시 발송시간<br />제한을 설정함)</span></td>
	</tr>
	</tbody>
	</table>
</div>

<div id="noticeCriteriaPopup_sms_charge" class="hide">
	<b>아래의 ①~④ 조건을 모두 만족 시 문자<br />
	충전을 안내 드립니다.</b><br />
	① 수신여부 체크 시<br />
	② 문자 잔여건수가 있을 때<br />
	③ 충전 안내 이력 없을 경우<br />
	④ 잔여 건수가 50건 미만
</div>

<div id="noticeCriteriaPopup_autodeposit_charge" class="hide">
	<b>아래의 ①~④ 조건을 모두 만족 시 무통장자동입금서비스<br />
	연장을 안내 드립니다.</b><br />
	① 수신여부 체크 시<br />
	② 문자 잔여건수가 있을 때<br />
	③ 연장 안내 이력 없을 경우<br />
	④ 잔여 일수가 20일 미만
</div>

<div id="noticeCriteriaPopup_goodsflow_charge" class="hide">
	<b>아래의 ①~④ 조건을 모두 만족 시 굿스플로서비스<br />
	충전을 안내 드립니다.</b><br />
	① 수신여부 체크 시<br />
	② 문자 잔여건수가 있을 때<br />
	③ 충전 안내 이력 없을 경우<br />
	④ 잔여 건수가 50건 미만
</div>

<div id="safekey_input_info" class="hide" style="padding-left:30px; padding-top:30px;">
	<div style="padding-bottom:30px; font-size:13px; color:#2d2c2d;">
		가비아회원로그인 > My퍼스트몰 > `보안키 확인`에서 찾을 수 있습니다.<br />
		(쇼핑몰 소유자의 가비아 계정으로 로그인 해야 합니다.)
	</div>
	<img src="/admin/skin/default/images/design/admin_security_pop.jpg">

</div>

<div id="linkage_sms_mail_info" class="hide">
<?php $this->print_("linkage_sms_mail_info",$TPL_SCP,1);?>

</div>

<div id="smsMyFirstmallInfo" class="hide">
	<img src="/admin/skin/default/member/<?php echo get_connet_protocol()?>interface.firstmall.kr/firstmall_plus/images/sms/sms_aimg01.jpg" usemap="#smsFirstmallMap">
</div>
<map name="smsFirstmallMap">
	<area shape="rect" coords="0,30,172,72" href="#" onclick="window.open('https://firstmall.kr/myshop/sms/sms_send_phone.php?num=<?php echo $TPL_VAR["config_system"]["shopSno"]?>');" title="" target="_blank"/>
</map>

<div id="essential" class="hide">
	<ul>
		<li>해제를 하시면 회원에게 SMS로 <span class="ess_txt">아이디</span>를 전송하지 못합니다.</li>
		<li>해제하시려면 '확인'을 취소 하시려면 '취소'를 클릭해 주세요</li>
	</ul>
	<div class="center mt20">
		<span class="btn large cyanblue"><input type="button" onclick="$('.essential_ck').prop('checked',false);$('#essential').dialog('close')" value="해제"></span>
		<span class="btn large gray"><input type="button" onclick="$('#essential').dialog('close')" value="취소"></span>
	</div>
</div>
<style>
	.batchInfoLeftTd {border:1px solid #cccccc; border-top:0px; padding-left:5px;}
	.batchInfoRightTd {border:1px solid #cccccc; border-left:0px; border-top:0px; padding-left:5px;}
</style>
<div id="batch_info" class="hide">
	<div >예시) 100건의 주문을 수동으로 <span id="batch_info_title">츨고완료</span> 시</div>
	<div style="padding-top:5px;">
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td height="25" width="80" style="border:1px solid #cccccc;" align="center"><b>수신</b></td>
				<td style="border:1px solid #cccccc; border-left:0px;" align="center"><b>문자</b></td>
			</tr>
			<tr>
				<td height="25" width="80" class="batchInfoLeftTd"><span id="batch_info_reciveName">주문자</span></td>
				<td class="batchInfoRightTd">구매자별 1통씩 총 100통</td>
			</tr>

<?php if($TPL_VAR["admins_arr"]){?>
<?php if($TPL_admins_arr_1){$TPL_I1=-1;foreach($TPL_VAR["admins_arr"] as $TPL_V1){$TPL_I1++;?>
				<tr>
					<td height="25" class="batchInfoLeftTd">관리자(<?php echo $TPL_I1+ 1?>)</td>
					<td class="batchInfoRightTd">1통 : {설정된 컨텐츠} 외 99건</td>
				</tr>
<?php }}?>
<?php }else{?>
				<tr>
					<td height="25" class="batchInfoLeftTd">관리자(1)</td>
					<td class="batchInfoRightTd">1통 : {설정된 컨텐츠} 외 99건</td>
				</tr>
<?php }?>
		</table>
	</div>
</div>
<script type="text/javascript">

goodsname_limit('ord_item');
goodsname_limit('repay_item');
goodsname_limit('go_item');
goodsname_limit('goods_item');
</script>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>