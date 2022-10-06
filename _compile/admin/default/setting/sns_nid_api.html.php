<?php /* Template_ 2.2.6 2021/04/12 10:16:43 /www/music_brother_firstmall_kr/admin/skin/default/setting/sns_nid_api.html 000026405 */ ?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript">

function isKorean(objStr) {
	for (var i = 0; i < objStr.length; i++) {
		if (((objStr.charCodeAt(i) > 0x3130 && objStr.charCodeAt(i) < 0x318F) || (objStr.charCodeAt(i) >= 0xAC00 && objStr.charCodeAt(i) <= 0xD7A3))) {
			return true;		// 한글 포함이면 false 반환
		} else {
			return false;		// 한글 미포함이면 true 반환
		}
	}
}

function punycode_encode(str){

	if(str.trim() != ''){

		if(isKorean(str)){
			var unicode_domain	= $.trim($("#nid_client_url").val());
			if(unicode_domain.indexOf('http://') > -1){
				unicode_domain	= unicode_domain.replace('http://', '');
			}

			$("#nid_client_url").val(unicode_domain);

			if(unicode_domain.length < 4){
				alert('한글도메인을 정확히 입력해 주세요.');
				$("#nid_client_url").focus();
				return;
			}

			var punycode_domain	= punycode.toASCII(unicode_domain);
			$("#punycode_domain_lay").val("http://"+punycode_domain);
			$("#punycode_domain_lay").css("display","block");
			//$("#puny_domain").val(punycode_domain);
			//$("#uni_domain").val(unicode_domain);
		}else{
			$("#punycode_domain_lay").css("display","none");
			$("#punycode_domain_lay").val('');
		}
	}
}

function nidReload(){
	$.get("/admin/setting/sns_nid_api", function(data) { 
		$(".ui-dialog").animate({height:"690px"}, 300);
		$("#snsdiv_n").html(data); 
	});
}

/*사용여부 업데이트*/
function nidUseUpdate(now_use,upt_use,btn_obj){

	$.ajax({
		'url' : '../member_process/naver_login_use_change',
		'type' : 'post',
		'data': {'use_n':upt_use},
		'dataType': 'json',
		'success': function(res) {

			var span_title,btn_title;

			if(now_use == "Y"){ 
				span_title	= "사용안함";
				btn_title	= "사용함";
				usen		= "N";
				btn_obj.parent().removeClass("black");
				btn_obj.parent().addClass("cyanblue");
			}else{
				span_title	= "사용함";
				btn_title	= "사용안함";
				usen		= "Y";
				btn_obj.parent().removeClass("cyanblue");
				btn_obj.parent().addClass("black");
			}
			if(res.result == true){
				openDialogAlert("["+span_title+"]으로 저장되었습니다.",350,140);
				btn_obj.html(btn_title);
				$(".nid_use").html(span_title);
				
				$("input[name='use_n']").val(usen);
			}else{
				openDialogAlert("사용여부 변경중 오류가 발생하였습니다.",350,140);
			}

			naverDisplayfnc();
		}
		,'error': function(e){
		}
	});


}

function nid_icon_delete(){

	if(confirm("등록된 로고를 삭제하시겠습니까?")){
		$.ajax({
			'url' : '../member_process/nid_icon_delete',
			'type' : 'post',
			'data': {'nid_icon':$(".nid_icon").attr("src")},
			'dataType': 'json',
			'success': function(res) {
				if(res.result == "ok"){
					var noimg = $(".nid_icon.noimg").attr("oldsrc");
					$(".nid_icon").attr("src",noimg);
					$(".nid_icon").attr("oldsrc",noimg);
					$("#upload_nid_icon_url").val("");
					alert("삭제되었습니다.");
				}else if(res.result == "fail"){
					alert("삭제 실패!");
				}else if(res.result == "noimg"){
					alert("삭제할 이미지가 없습니다.");
				}else{
					alert("삭제 오류1!");
				}
			}
			,'error': function(e){
				alert("삭제 오류2!");
				return false;
			}
		});
	}else{
		return false;
	}
}

/* 신청/재신청 클릭시 레이어 창 변경 */
function nidApplyLayMov(mode){
	$(".update_layer").addClass("hide");
	$("input[name='nid_mode']").val(mode);
	$(".sub_title.update").removeClass("show").addClass("hide");
	$(".sub_title.apply").removeClass("hide").addClass("show");
	$(".view").removeClass("show").addClass("hide");
	$(".mod").removeClass("hide").addClass("show");
	$(".btnlay.apply").removeClass("hide").addClass("show"); 
	$(".btnlay.modify").removeClass("show").addClass("hide"); 
	$(".nid_icon_url.none").removeClass("hide").addClass("show");
	$(".nid_icon_url.use").removeClass("show").addClass("hide");
	$(".btn_img_delete").removeClass("show").addClass("hide");


}

/* 재신청 모드 */
function nidReApplyLayMov(){

	$(".nid_cancel.apply").attr("applymode","reapplication");
	$(".btnlay.apply .nid_request").html("재신청");
	$("#reapply_agree").prop("checked",false);

	openDialog("<?php echo $TPL_VAR["sns"]["nid_logo"]?> 네이버 아이디로 로그인 서비스 재신청 안내", "nid_guide_reapply", {"width":"720","height":"575","show" : "fade","hide" : "fade","modal":false});
}


$(function(){

	/* 파일업로드버튼 ajax upload 적용 */
	var opt			= { 'file_path' : '/data/icon/common' };
	var callback	= function(res){
		var that		= this;
		var result		= eval(res);
		if(result.status){
			$(".nid_icon").attr("src", result.filePath + result.fileInfo.file_name);
			$("#upload_nid_icon_url").val(result.filePath + result.fileInfo.file_name);
		}else{
			openDialogAlert("<span class='fx12'>"+result.msg+"</span>",500,150,function(){});
		}
	};

	// ajax 이미지 업로드 이벤트 바인딩
	$('#imageUploadButton').createAjaxFileUpload(opt, callback);

	/* 재신청 동의 체크 */
	$(".nid_reapplication").on("click",function(){

		if($("#reapply_agree").is(":checked") == false ){
			openDialogAlert("<span class='fx12'>네이버 아이디로 로그인 서비스 재신청 안내 동의를 하셔야 합니다.</span>",500,150,function(){
				$("#reapply_agree").prop("checked",false);
			});
		}else{
			$("div#nid_guide_reapply").dialog("close");
			nidApplyLayMov('reapply');
		}

		//return false;

	});

	$("#reapply_agree").on("click",function(){
		openDialogAlert("<span class='fx12 red'>중요! 네이버 아이디로 로그인 재신청시 발생되는 문제들에 대해 동의하셨습니다.</span>",520,150,function(){ $("input[name='reapply_agree']").prop("checked",true)});
		return false;
	});


	$(".reapply_cancel").on("click",function(){
		openDialogAlert("<span class='fx12'>취소 되었습니다.</span>",300,140,function(){ 
			$("div#nid_guide_reapply").dialog("close");
			$("#reapply_agree").prop("checked",false);
		});

	});

	/* 취소버튼 클릭시 레이어 창 변경 */
	$(".nid_cancel").on("click",function(){

		$("input[name='nid_mode']").val("");
		/* 신청 -> 취소 */
		if($(this).attr("applymode") == "apply"){

			$("div#snsdiv_n").dialog("close");

		/* 재신청 -> 취소 */
		}else{
			
			if($(this).attr("applymode") == "reapplication"){
				$(".sub_title").removeClass("show").addClass("hide");
				$(".update_layer").removeClass("hide").addClass("show");
				$(".btnlay.apply .nid_request").html("신청하기");
			}

			/* 공통 */
			$("#reapply_agree").prop("checked",false);
			$(".ui-dialog").animate({height:"555px"}, 300);
			$(".sub_title.apply").removeClass("show").addClass("hide");
			$(".sub_title.update").removeClass("show").addClass("hide");
			$(".view").removeClass("hide").addClass("show");
			$(".mod").removeClass("show").addClass("hide");
			$(".btnlay.modify").removeClass("hide").addClass("show"); 
			$(".btnlay.nid_use_change").removeClass("hide").addClass("show");
			$(".btnlay.apply").removeClass("show").addClass("hide");
<?php if($TPL_VAR["sns"]["nid_icon_url"]){?>
			$(".nid_icon_url.use").removeClass("hide").addClass("show");
			$(".nid_icon_url.none").removeClass("show").addClass("hide");
<?php }else{?>
			$(".nid_icon_url.use").removeClass("show").addClass("hide");
			$(".nid_icon_url.none").removeClass("hide").addClass("show");
<?php }?>
			
			$(".nid_icon_url.none .nid_icon").attr("src",$(".nid_icon_url.none .nid_icon").attr("oldsrc"));
			$(".nid_icon_url.use .nid_icon").attr("src",$(".nid_icon_url.use .nid_icon").attr("oldsrc"));

			$("input[name='nid_service_name']").val($("input[name='nid_service_name']").attr('stitle'));
			$("input[name='nid_client_url']").val($("input[name='nid_client_url']").attr('stitle'));
			$("input[name='nid_client_url_punycode']").val($("input[name='nid_client_url_punycode']").attr('stitle'));
			
		}
	});

	/* 로고 이미지 사용 안내 */
	$(".nid_icon_guide").on("click",function(){

		openDialog("<?php echo $TPL_VAR["sns"]["nid_logo"]?> 쇼핑몰 로고 이미지 어디에 사용되나요?", "nid_icon_guide_layer", {"width":"480","height":"540","show" : "fade","hide" : "fade","modal":false});

	});

	/* 관리자 권한 양도방법 안내 */
	$(".nid_admin_guide").on("click",function(){

		openDialog("<?php echo $TPL_VAR["sns"]["nid_logo"]?> 네이버 아이디로 로그인 관리자 권한 양도방법 안내", "nid_admin_guide_layer", {"width":"650","height":"800","show" : "fade","hide" : "fade","modal":false});

	});

	/* 사용,미사용 */
	$("#nidUseChange").on("click",function(){

		var msg		= '';
		var btn_obj = $(this);
		if($("#nid_use").val() == "Y"){
			upt_use = "N";
			msg		= "미사용 시 네이버 아이디로 회원가입 및 로그인이 되지 않습니다.<br />미사용 하시겠습니까?";
		}else{
			upt_use = "Y";
			msg		= "사용 시 네이버 아이디로 회원가입 및 로그인 서비스 이용이 가능합니다.<br />사용 하시겠습니까?";
		}

		openDialogConfirm("<span class='fx12'>"+msg+"</span>",500,170,function(){
			nidUseUpdate($("#nid_use").val(),upt_use,btn_obj);
			
		},function(){});
	});

	/* 신청, 재신청 Submit */
	$(".nid_request").on("click",function(){
		
		// 수정하기 클릭 시 프로세스 변경 :: 2019-08-29 pjw
		var updateflag	= true;
		var applymode	= $(this).attr('applymode');
		
		// 수정인 경우
		if(applymode == 'update'){
			openDialogConfirm("<span class='fx12'>지금 등록된 정보를 수정하시겠습니까?</span>",400,140,function(){
				$("input[name='nid_mode']").val("update");
				updateAPISetting();
			});			
		}else{
			updateAPISetting();
		}
	});


	// 수동입력 버튼 :: 2019-08-29 pjw
	$('.btn_manual_request').click(function(){
		$('.sub_title.apply').removeClass('show').addClass('hide');
		$('.sub_title.update').removeClass('hide').addClass('show');
		$('.btnlay.apply').removeClass('show').addClass('hide');
		$('.btnlay.modify').removeClass('hide').addClass('show');
		$('.btn_modify_area').removeClass('show').addClass('hide');
		$('.btn_remodify_area').removeClass('hide').addClass('show');
		$('.update_layer.client').removeClass('hide').addClass('show');
	});

	// 수동입력 취소 버튼 :: 2019-08-29 pjw
	$('.btn_manual_request_cancel').click(function(){
		$('.sub_title.apply').removeClass('hide').addClass('show');
		$('.sub_title.update').removeClass('show').addClass('hide');
		$('.btnlay.apply').removeClass('hide').addClass('show');
		$('.btnlay.modify').removeClass('show').addClass('hide');
		$('.btn_modify_area').removeClass('hide').addClass('show');
		$('.btn_remodify_area').removeClass('show').addClass('hide');
		$('.update_layer.client').removeClass('show').addClass('hide');
	});
	
});

// api 업데이트 함수 따로 뺌 :: 2019-08-29 pjw
function updateAPISetting(){
	$.ajax({
		'url' : '../member_process/nid_api_stats',
		'type' : 'post',
		'data': '',
		'dataType': 'html',
		'success': function(res) {

			$("#nid_stats").val(res);

			if(nidApiCheck()){
				$("#nidloginAPIform").submit();
			}
		}
		,'error': function(e){
		}
	});
}

</script>


<!-- <?php echo debug($TPL_VAR["sns"])?> -->
<!-- 네이버 설정 가이드 : API 연동 정보 입력 Layer -->

	<div class="service">
		<div>
		<form method="post" action="<?php echo $TPL_VAR["apicallurl"]?>" name="nidloginAPIform" id="nidloginAPIform" target="actionFrame"> 
		<input type="hidden" name="nid_mode" >
		<input type="hidden" name="shopcode" value="<?php echo $TPL_VAR["shopcode"]?>">
		<input type="hidden" name="shop_callbackurl" value="<?php echo $TPL_VAR["shop_callbackurl"]?>">
		<input type="hidden" name="nid_stats" id="nid_stats">
		<input type="hidden" name="shop_protocol" value="<?php echo $TPL_VAR["shop_protocol"]?>">
		<table class=" table_basic thl">
			<tr class="update_layer">
				<th>사용여부</th>
				<td colspan="2"><span class="nid_use"><?php if($TPL_VAR["sns"]["use_n"]){?>사용함<?php }else{?>사용안함<?php }?></span>
				<input type="hidden" name="use_n" id="nid_use" value="<?php if($TPL_VAR["sns"]["use_n"]){?>Y<?php }else{?>N<?php }?>">
				
				<div class="btnlay nid_use_change" style="float:right;margin-right:10px;"><button class="nid_use btn_resp b_gray3" type="button" <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> id="nidUseChange" <?php }?> ><?php if($TPL_VAR["sns"]["use_n"]){?>사용안함<?php }else{?>사용함<?php }?></button></div>
				</td>
			</tr>
			<tr class="update_layer client">
				<th class="its-th" rowspan="2" width="30%">연동정보<span class="required_chk"></th>
				<td class="its-td" width="20%">Client ID</td>
				<td class="its-td">
<!-- 					<span class="darkgray"><?php if($TPL_VAR["sns"]["nid_client_id"]){?><?php echo $TPL_VAR["sns"]["nid_client_id"]?><?php }else{?><?php }?></span> -->
					<input type='text'  name="nid_client_id"  id="key_n_lay" value="<?php if($TPL_VAR["sns"]["nid_client_id"]){?><?php echo $TPL_VAR["sns"]["nid_client_id"]?><?php }else{?><?php }?>">
				</td>
			</tr>
			<tr class="update_layer client">
				<td class="its-td">Client Secret</td>
				<td class="its-td">
<!-- 					<span class="darkgray"><?php if($TPL_VAR["sns"]["nid_client_secret"]){?><?php echo $TPL_VAR["sns"]["nid_client_secret"]?><?php }else{?><?php }?></span> -->
					<input type='text'  name="nid_secret"  id="nid_secret" value="<?php if($TPL_VAR["sns"]["nid_client_secret"]){?><?php echo $TPL_VAR["sns"]["nid_client_secret"]?><?php }else{?><?php }?>">
				</td>
			</tr>
			<!--
			<tr>
				<th class="its-th">담당자명</th>
				<td class="its-td" colspan="2"><span class="view"><?php if($TPL_VAR["sns"]["nid_client_name"]){?><?php echo $TPL_VAR["sns"]["nid_client_name"]?><?php }else{?><span class="darkgray">등록된 정보가 없습니다.</span><?php }?></span>
				<span class="mod hide"><input type='text'  name="nid_client_name" value="<?php if($TPL_VAR["sns"]["nid_client_name"]){?><?php echo $TPL_VAR["sns"]["nid_client_name"]?><?php }else{?><?php echo $TPL_VAR["ceo"]?><?php }?>"></span></td>
			</tr>
			-->
			<tr >
				<th class="its-th" width="30%">쇼핑몰 이름 <span class="required_chk"></th>
				<td class="its-td" colspan="2">
					<span class="view"><?php if($TPL_VAR["sns"]["nid_service_name"]){?><?php echo $TPL_VAR["sns"]["nid_service_name"]?><?php }else{?><span class="darkgray">등록된 정보가 없습니다.</span><?php }?></span>
					<span class="mod<?php if(!$TPL_VAR["sns"]["nid_service_name"]){?>hide<?php }?>"><input type='text' name="nid_service_name" value="<?php if($TPL_VAR["sns"]["nid_service_name"]){?><?php echo $TPL_VAR["sns"]["nid_service_name"]?><?php }else{?><?php echo $TPL_VAR["shopName"]?><?php }?>" stitle="<?php echo $TPL_VAR["shopName"]?>"></span>
				</td>
			</tr>
			<tr>
				<th>
					도메인 등록<span class="required_chk"></span>
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/snsconf', '#tip14', '500')"></span>	
				</th>
				<td colspan="2">
					<div class="view"><?php if($TPL_VAR["sns"]["nid_client_url_web"]){?>
						http://<?php echo $TPL_VAR["sns"]["nid_client_url_web"]?>

<?php if($TPL_VAR["sns"]["nid_client_url_mobile"]){?><br />http://<?php echo $TPL_VAR["sns"]["nid_client_url_mobile"]?><?php }?>
<?php }else{?><span class="darkgray">등록된 정보가 없습니다.</span><?php }?>
					</div>
					<div class="mod">
						http://<input type='text'  name="nid_client_url" id="nid_client_url" value="<?php if($TPL_VAR["sns"]["nid_client_url_web"]){?><?php echo $TPL_VAR["sns"]["nid_client_url_web"]?><?php }else{?><?php echo $TPL_VAR["config_system"]["domain"]?><?php }?>" onblur="punycode_encode(this.value)" style="width:84%;" stitle="<?php echo $TPL_VAR["config_system"]["domain"]?>">
						<input type="hidden" name="nid_client_url_punycode" value="<?php echo $TPL_VAR["punycode_encode"]?>" id="punycode_domain_lay" readonly  stitle="<?php echo $TPL_VAR["punycode_encode"]?>" style="width:80%; padding:0px;color:red; line-height:24px; font-size:11px; height:18px;border:0px;background-color:#fff;" >
						<ul class="bullet_hyphen resp_message v2">
							<li>현재 운영하고 있는 쇼핑몰의 실제 도메인(대표 도메인)을 입력해주세요.</li>
							<li>도메인 등록 시 www를 제외한 나머지 도메인을 입력해주세요.</li>							
						</ul>
					</div>
				</td>
			</tr>
			<tr >
				<th class="its-th">
					쇼핑몰 로고 이미지<span class="required_chk">
					<span class="tooltip_btn ml10" onClick="showTooltip(this, '/admin/tooltip/snsconf', '#tip11', '450')"></span>					
				<td class="its-td" colspan="2">
					<ul class="ul_list_09">
						<li>
							<div class="nid_icon_url use show"><img src="<?php echo $TPL_VAR["sns"]["nid_icon_url"]?>" width="140" height="140" class="nid_icon" oldsrc="<?php echo $TPL_VAR["sns"]["nid_icon_url"]?>"></div>
							<div class="nid_icon_url none hide"><img src="<?php echo $TPL_VAR["sns"]["nid_icon_noimg"]?>" width="140" height="140" class="nid_icon noimg" oldsrc="<?php echo $TPL_VAR["sns"]["nid_icon_noimg"]?>"></span></div>
						</li>
						
						<li class="pdl10">
							<ul class="bullet_hyphen resp_message v2">
								<li>파일형식 jpg,png,gif</li>							
								<li>이미지 사이즈 140*140</li>	
								<li>파일 크기 500KB 이하</li>	
							</ul>
							<div class="mod">
								<img src="/admin/skin/default/images/common/btn_imgdelete.gif" onclick="nid_icon_delete()" class="btn_img_delete <?php if(!$TPL_VAR["sns"]["nid_icon_url"]){?>hide<?php }?>" >							
								<span class="imageUploadBtnImage resp_btn v2"  onclick="$('#imageUploadButton').click();">파일선택</span>
								<input id="imageUploadButton" type="file" name="file" value="" class="uploadify hide" />
								<input id="imagetype" type="text" name="imagetype" class="hide" value="" />
								<input id="upload_nid_icon_url" type="hidden" name="upload_nid_icon_url" value="<?php echo $TPL_VAR["sns"]["nid_icon_url"]?>" />
							</div>
						</ul>
					</div>
				</td>
			</tr>
		
		</table>
		</div>

		<!-- 재신청 모드, 정보수정 모드 변경 -->
		<div class="btnlay modify footer" >
			<ul>
				<li class="btn_modify_area" style="float:left;">
					<button  type="button" <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> onclick="nidReApplyLayMov()" <?php }?> class="resp_btn active size_XL" >재신청</button>
				</li>

				<li class="btn_modify_area" style="float:right;">
					<button  type="button" class="<?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> nid_request <?php }?> resp_btn active size_XL" applymode='update' >수정</button>
				</li>
				<li class="btn_remodify_area hide">
					<button  type="button" class="<?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> nid_request <?php }?> resp_btn active size_XL" applymode='update' >재등록</button>
					<button  type="button" class="btn_manual_request_cancel resp_btn v3 size_XL" >취소</button>

				</li>
			</ul>
		</div>

		<!-- 신청/재신청 api submit -->
		<div class="btnlay apply center hide footer">
			<button type="button" class="<?php if($TPL_VAR["isdemo"]["isdemo"]){?>  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> nid_request <?php }?> resp_btn active size_XL"  applymode='apply'>신청</button>
			<button type="button" class="nid_cancel apply resp_btn v3 size_XL" applymode='apply' >취소</button>
			<div class="mt15 mb15">이미 발급받은 정보가 있으세요? <span class="btn_manual_request underhelpicon">수동 입력하기</span></div>
		</div>
		</form>
	</div>



<!-- 네이버 설정 가이드 : 아이콘 -->
<div id="nid_icon_guide_layer" style="margin-top:0px;display:none;">
	<div style="font-size:12px;">고객들이 네이버 아이디로 로그인 또는 회원가입 시에 고객정보 수집동의 확인 <br />
	 페이지에서 이미지가 작게 노출됩니다.</div>

	<div style="margin-top:35px;text-align:center;">
		<img src="/admin/skin/default/images/common/naver_p001.jpg">
	</div>
</div>

<!-- 네이버 설정 가이드 : 재신청안내 -->
<div id="nid_guide_reapply" style="margin-top:0px;display:none;">

	<div class="mt10" style="width:95%;margin:auto;">
	
		<div class="fx13 red bold">※ 재신청 주의 사항 </div>
		<div class="mt5 fx12 red">
		네이버 아이디로 로그인 서비스를 재신청 하실 경우 기존에 서비스를 이용하고 있던 고객들의 로그인이 불가하며, 재가입 후 로그인 가능합니다.</div>

		<div class="mt5 darkgray fx12">(현재 네이버 아이디로 회원가입 및 로그인을 이용하시는 고객이 <?php echo number_format($TPL_VAR["sns"]["total_n"])?>명 있습니다 재신청 시 네이버 아이디로 로그인을 사용하실 수 없습니다)</div>

		<div class="mt25 fx12" style="line-height:20px">
			<span class="bold blue">※ 재신청이 필요한 경우</span><br />
			<span class="darkgray">
			&nbsp;&nbsp;&nbsp;1) 현재 연동된 Client ID 값이 정확하지 않아 오류가 있을 때<br />
			&nbsp;&nbsp;&nbsp;2) 담당자 변경으로 인해 Client ID를 새로 발급 받고 싶을 때 <br />
			</span>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;⇒ 기존 Client ID에 대한 관리 권한은 타인에게 양도가능
				<span class="btn small orange"><button  type="button" class="nid_admin_guide">관리자권한 양도방법</button></span>
		</div>


		<div class="mt25 fx12">
			재신청 시 기존 회원 서비스 사용 불가 내용에 충분히 인지하셨다면 아래 [동의]에 체크하시고 재신청을 진행해 주시기 바랍니다.
		</div>

		<div class="fx12 mt20" style="border:3px solid #ddd; background-color:#F5F5F5; width:100%; ">
			<div style="width:90%;margin:auto;padding:15px;">
			<label class="resp_checkbox"><input type="checkbox" name="reapply_agree" id="reapply_agree"> <span class="red fx14">네이버 아이디로 로그인 서비스 재신청 시 발생되는 문제들에 대해 충분히 안내를 받았으며, 발생 가능한 내용에 대해 인지하였음에 동의합니다.</span></label>
			</div>
		</div>
		
		<div class="mt15" style="padding:10px;text-align:center;">
			<button type="button" class="resp_btn active size_XL <?php if($TPL_VAR["isdemo"]["isdemo"]){?> " <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> nid_reapplication " <?php }?> >재신청</button>
			<button type="button" class="resp_btn v3 size_XL reapply_cancel" >취소</button>
		</div>

	</div>

</div>


<!-- 네이버 설정 가이드 : 관리자 권한 양도 -->
<div id="nid_admin_guide_layer" style="margin-top:5px;display:none;">
	<div style="font-size:12px;">네이버 아이디로 로그인 서비스를 재신청 하지 않고 관리자 권한을 공유할 수 있습니다.</div>

	<div class="mt20 fx12">
		1. 먼저 현재 네이버 아이디로 로그인 서비스 등록시 신청한 로그인 정보로 아래 페이지에 접속합니다.<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://nid.naver.com/devcenter/main.nhn" target=_blank style="color:#06C">https://nid.naver.com/devcenter/main.nhn</a> <span class="desc">(네이버 로그인 필요)</span>
	</div>

	<div class="mt20">
		<img src="/admin/skin/default/images/common/naver_p002.jpg">
	</div>

	<div class="mt20 fx12">
		2. 등록된 애플리케이션 아래 [멤버관리] 클릭
	</div>

	<div class="mt20">
		<img src="/admin/skin/default/images/common/naver_p003.jpg">
	</div>

	<div class="mt20 fx12">
		3. 양도하려는 관리자의 "네이버 아이디" 를 등록
	</div>

	<div class="mt20">
		<img src="/admin/skin/default/images/common/naver_p004.jpg">
	</div>
	
	<div class="mt20 fx12 mb30">
		4. 관리자 권한 양도(관리자 공유) 완료
	</div>

</div>


<script type="text/javascript">
<?php if(!$TPL_VAR["sns"]["nid_client_id"]&&!$TPL_VAR["sns"]["nid_client_secret"]){?>
	nidApplyLayMov('apply');
<?php }else{?>
<?php if($TPL_VAR["sns"]["nid_icon_url"]){?>
	$(".nid_icon_url.use").removeClass("hide").addClass("show");
	$(".nid_icon_url.none").removeClass("show").addClass("hide");
<?php }else{?>
	$(".nid_icon_url.use").removeClass("show").addClass("hide");
	$(".nid_icon_url.none").removeClass("hide").addClass("show");
<?php }?>
<?php }?>


/* api 전송전 필수값 체크 */
function nidApiCheck(){

	var f = document.nidloginAPIform;

	if( !f.nid_stats.value.trim() ){
		alert('API 연동 토큰 오류! 퍼스트몰에 문의해 주세요.');
		return false;
	}
	if( !f.shopcode.value ){
		alert('Shop 연동 정보가 누락되었습니다. 퍼스트몰에 문의해 주세요.');
		return false;
	}
	if( !f.shop_callbackurl.value ){
		alert('Shop 연동 정보가 누락되었습니다. 퍼스트몰에 문의해 주세요.');
		return false;
	}

	if(f.nid_mode.value != "apply" && f.nid_mode.value != "reapply"){
		if(!f.nid_client_id.value ) {
			alert('연동정보 [Client ID] 값이 없습니다.');
			return false;
		}
		if( !f.nid_secret.value ){
			alert('연동정보 [Client Secret] 값이 없습니다.');
			return false;
		}
	}
	if( !f.nid_service_name.value.trim() ){
		alert('쇼핑몰이름 입력해 주세요.');
		f.nid_service_name.focus();
		return false;
	}
	if( !f.nid_client_url.value.trim() ){
		alert('도메인을 입력해 주세요.');
		f.nid_client_url.focus();
		return false;
	}else{
		var regExDomain=/^((?:(?:(?:\w[\.\-\+]?)*)\w)+)((?:(?:(?:\w[\.\-\+]?){0,62})\w)+)\.(\w{0,62})$/;
		if(!(regExDomain.test(f.nid_client_url.value.trim()) || f.nid_client_url.value.substring(0,4)=='xn--')) { 
			alert("도메인 형식에 맞지 않습니다.");
			f.nid_client_url.value = "";
			f.nid_client_url.focus();
			return false;
		}
		if(isKorean(f.nid_client_url.value)){
			if(!f.nid_client_url_punycode.value) punycode_encode(f.nid_client_url.value);
		}
	}

	//신규신청시 사용여부는 사용함으로 설정.
	if(f.nid_mode.value == "apply" || f.nid_mode.value == "reapply"){
		$("input[name='use_n']").val("Y");
	}

	return true;
}
</script>