<?php /* Template_ 2.2.6 2022/05/17 12:36:28 /www/music_brother_firstmall_kr/admin/skin/default/member/kakaotalk_template_modify.html 000013734 */ 
$TPL_use_replace_code_1=empty($TPL_VAR["use_replace_code"])||!is_array($TPL_VAR["use_replace_code"])?0:count($TPL_VAR["use_replace_code"]);?>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/massage.css" />
<style>
.template_frm_wrap {height:387px; vertical-align:top;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$(".templateContents").on('keyup', function(){
		template_str();
	});

	$(".kkoLinkType").on('change', function(){
		if($(this).val()=="DS")
		{
			$(".weblink").hide();
			$(".ship").show();
		}else{
			$(".weblink").show();
			$(".ship").hide();
		}
	});

	template_str();
	help_tooltip();
	btn_controll_preview();
	
	//치환코드 팝업창 닫기
	$("#infoPopupCloseBtn").on("click", function(){		
		closeDialog('infoPopup');
		$("#infoPopup").remove();		
	});
});

// 메세지 글자수 체크
function template_str(){
	var obj = $(".templateContents");
	var len	= $(obj).val().length;
	var max	= $(obj).attr('maxlength');
	if(len < max){
		msg	= len + ' / ' +  max;
	}else{
		$(obj).val( $(obj).val().substring(0,max) );
		msg	= '<b style="color:red;">'+ max + '</b> / ' + max;
		openDialogAlert('내용은 최대 1,000자까지 입력할 수 있습니다');
	}
	$(".cntStr").html(msg);

	// 미입력시 처리
	if(len == 0){
		$(".templateContents").addClass('boder_red');
	}else{
		$(".templateContents").removeClass('boder_red');
	}

	// 미리보기 동기화
	$("#preview_templateContents").val($(obj).val());

	// 스크롤 내리기
	$("#preview_templateContents").scrollTop($("#preview_templateContents").prop('scrollHeight'));
}

// 버튼 타입 컨트롤
function btn_controll(obj, mod){
	var old_btn_cnt = $(".btnTr").length;
	if(mod == 'add'){
		// 버튼 없음 검사
		var btn_flag	= true;
		var btn_cnt		= 0;
		$("select[name='kkoLinkType[]']").each(function(i, btnObj){
			btn_cnt++;
			if(!$(btnObj).val())	btn_flag = false;
		});
		// 버튼 타입 지정 체크
		if(!btn_flag){
			openDialogAlert('버튼을 추가하려면 버튼타입을 지정해주세요.');
			return false;
		}
		// 버튼 갯수 체크
		if(btn_cnt >= 5){
			openDialogAlert('버튼은 5개까지 등록가능합니다.');
			return false;
		}

		var new_tr = $(obj).closest(".btnTr").clone();
		$(new_tr).addClass('mt5');
		$(new_tr).find(".btnTd").attr('onClick','btn_controll(this);');
		$(new_tr).find(".btnTd").addClass('btn_minus');		
		$(new_tr).find(".btnTd").removeClass('btn_plus');
		$(new_tr).find(".kkoLinkType").find('option').eq(0).attr('selected', 'selected');
		$(new_tr).find(".weblink").show();
		$(new_tr).find(".ship").hide();
		$(new_tr).find("input").val('');
		$(".msg_tb").append(new_tr);
	}else{
		$(obj).closest(".btnTr").remove();
	}

	$(".preview .kakao_message").removeClass("num"+old_btn_cnt);
	btn_controll_preview();
}

// 버튼 타입 변경
function kkoLinkType_chg(obj){
	var kkoLinkType = $(obj).closest('tr.btnTr').find(".kkoLinkType").val();
	if(kkoLinkType == 'WL'){
		$(obj).closest("tr.btnTr").find(".weblink").show();
		$(obj).closest("tr.btnTr").find(".ship").hide();
	}else{
		$(obj).closest("tr.btnTr").find(".weblink").hide();
		$(obj).closest("tr.btnTr").find(".ship").show();
	}

	var btn_ds	= 0;
	$("select[name='kkoLinkType[]']").each(function(i, btnObj){
		if($(btnObj).val() == 'DS')	btn_ds++;
	});
	if(btn_ds > 1){
		openDialogAlert('배송조회 버튼은 메세지당 한개만 가능합니다.');
		$(obj).find("option").eq(0).attr('selected', 'selected');
		$(obj).closest(".btnTr").find(".weblink").show();
		$(obj).closest(".btnTr").find(".ship").hide();
		return false;
	}

	btn_controll_preview();
}

// 미리보기 버튼 컨트롤
function btn_controll_preview(){
	var btn_cnt = $(".btnTr").length;
	$(".preview").find(".clearbox").html('');
	if($("#kkoBtnYn").is(':checked')){
		$(".btnTr").each(function(i, btnObj){
			var link_type	= $(btnObj).find(".kkoLinkType").val();
			var btn_name	= '배송조회';
			if(link_type == 'WL'){
				var btn_name = $(btnObj).find(".kkoLinkName").val();
			}
			$(".preview").find(".clearbox").append('<li><a href="#">' + btn_name + '</a></li>');
		});
		$(".preview .kakao_message").removeClass("num0");
		$(".preview .kakao_message").addClass("num"+btn_cnt);
	}else{
		$(".preview .kakao_message").addClass("num0");
	}
}

// 치환코드 보기 버튼
function msg_replace_code(type){
	$(".s_info").hide();
	$("."+type).show();
	//$("#s_title").html($("#"+type).find('.msg_title').html());
	openDialog("사용 가능한 치환코드", "infoPopup", {"width":"500","height":"400"});
}

// 치환코드 삽입
function add_replace_code(code){
	// 여러가지 문제점 발견으로 인해 지원 X
	//var ori_content = $(".templateContents").html();
	//$(".templateContents").html(ori_content + code);
	//template_str();
}

// 카카오 템플릿 수정요청
function kakaotalk_modify_submit(){
	var chk_url = true;
	var pattern = new RegExp("^(\#\{).*\}$");
	if ($("#kkoBtnYn").is(':checked')){
		$.each($(".kkoLinkPc"), function (idx, obj){
			// kkoLinkType WL 때만 URL 입력 했는지 체크 2018-04-09
			if( $(".kkoLinkType").eq(idx).val() == "WL") {
				if ($(obj).val().indexOf("http://") == -1 && $(obj).val().indexOf("https://") == -1 && pattern.test($(obj).val()) === false ){
					chk_url = false;
				}
			}
		});
	}

	if(chk_url){
		openDialogConfirm('카카오에 검수(3일~5일 소요) 요청하시겠습니까?',400,150,function(){
			// loadingStart();
			$("#template_frm").submit();
		});
	}else{
		openDialogAlert('http:// 또는 https:// 를 입력해주세요.');
		return false;
	}
}
</script>
<div class="content">
	<ul class="cont clearbox">
		<!-- 카카오톡 수정영역 :: START -->
		<li class="msg_modify_area" id="<?php echo $TPL_VAR["template"]["msg_code"]?>">
		
			<table class="table_basic">
			<tbody>
			<tr>
				<th class="left"><?php echo $TPL_VAR["msg_title"]?></th>
			</tr>
			<tr>
				<td class="template_frm_wrap">
					<form name="template_frm" id="template_frm" action="../member_process/kakaotalk_template_modify" method="POST" target="actionFrame">
					<input type="hidden" name="msg_title" value="<?php echo $TPL_VAR["msg_title"]?>" />
					<input type="hidden" name="msg_type" value="<?php echo $TPL_VAR["template"]["msg_type"]?>" />
					<input type="hidden" name="msg_code" value="<?php echo $TPL_VAR["template"]["msg_code"]?>" />
					<input type="hidden" name="kkoBizCode" value="<?php echo $TPL_VAR["template"]["kkoBizCode"]?>" />
					<input type="hidden" name="base_kkoBizCode" value="<?php echo $TPL_VAR["template"]["base_kkoBizCode"]?>" />
					
					<div class="form msg_tb">			
						<div class="title_dvs">
							<div class="item-title">내용</div>						
							<button type="button" onclick="msg_replace_code('<?php echo $TPL_VAR["template"]["msg_code"]?>');" class="resp_btn">치환 코드</button>
						</div>
						
						<div class="inputbox">
							<textarea name="templateContents" class="templateContents" maxlength="1000"><?php echo $TPL_VAR["template"]["templateContents"]?></textarea>
							<div class="use">
								<span class="cntStr">0 / 1000</span>자
							</div>
						</div>

						<div class="item-title">
							<label class="resp_checkbox"><input type="checkbox" name="kkoBtnYn" id="kkoBtnYn" value="Y" onchange="btn_controll_preview();" <?php if($TPL_VAR["template"]["kkoBtnYn"]=='Y'){?>checked<?php }?> /></label>
							버튼
						</div>
<?php if($TPL_VAR["template"]["kkoLinkType_arr"]){?>
<?php if(is_array($TPL_R1=$TPL_VAR["template"]["kkoLinkType_arr"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
							<ul class="btnTr ul_list_01 pd0">	
								<li>
									<select name="kkoLinkType[]" class="kkoLinkType" onchange="kkoLinkType_chg(this);">
										<option value="WL" <?php if($TPL_V1=='WL'){?>selected<?php }?>>버튼 링크</option>
										<option value="DS" <?php if($TPL_V1=='DS'){?>selected<?php }?>>배송 조회</option>
									</select>
									<span class="weblink <?php if($TPL_V1=='DS'){?>hide<?php }?>">
										<input type="text" name="kkoLinkName[]" class="kkoLinkName" size=17 placeholder="버튼명(최대 28자)" value="<?php echo $TPL_VAR["template"]["kkoLinkName_arr"][$TPL_K1]?>" onchange="btn_controll_preview();" maxlength="28" />
										<input type="text" name="kkoLinkPc[]" class="kkoLinkPc" size=53 placeholder="링크주소 (http:// 또는 https:// 필수)" value="<?php echo $TPL_VAR["template"]["kkoLinkPc_arr"][$TPL_K1]?>" />
									</span>								
									<span class="ml5 ship <?php if($TPL_V1=='WL'){?>hide<?php }?>">배송조회는 버튼 링크를 포함하지 않습니다.</span>
								</li>

								<li class="valign-middle right">							
<?php if($TPL_K1> 0){?>
									<span class="btn_minus btnTd" idx="<?php echo $TPL_K1?>" onclick="btn_controll(this);" />
<?php }else{?>
									<span class="btn_plus btnTd" idx="<?php echo $TPL_K1?>" onclick="btn_controll(this, 'add');" />
<?php }?>
								</li>
							</ul>
							
<?php }}?>
<?php }else{?>
						<ul class="btnTr ul_list_01 pd0">	
							<li>
								<select name="kkoLinkType[]" class="kkoLinkType" onchange="kkoLinkType_chg(this);">
									<option value="WL" selected>버튼 링크</option>
									<option value="DS">배송 조회</option>
								</select>
								<span class="weblink">
									<input type="text" name="kkoLinkName[]" class="kkoLinkName" size=17 placeholder="버튼명(최대 28자)" value="" onchange="btn_controll_preview();" maxlength="28" />
									<input type="text" name="kkoLinkPc[]" class="kkoLinkPc" size=53 placeholder="링크주소" value="" />
								</span>						
								<span class="ship hide ml5">배송조회는 버튼 링크를 포함하지 않습니다.</span>
							</li>
							<li class="valign-middle right">
								<span class="btn_plus btnTd" idx="0" onclick="btn_controll(this, 'add');" />
							</li>
						</ul>
<?php }?>				
					</div>
					</form>
				</td>
			</tr>
			</tbody>
			</table>
		</li>
		<!-- 카카오톡 수정영역 :: END -->

		<!-- 카카오톡 미리보기 :: START -->
		<li class="preview">
			<img src="/admin/skin/default/images/design/k_mobile.png" alt="" />
			<div class="kakao_id"><?php echo $TPL_VAR["kakaotalk_config"]["yellowId"]?></div>
			<div class="kakao_message num5">
				<div class="stit">
					<span>아이콘</span>알림톡 도착
				</div>
				<div class="cont">
					<textarea name="preview_templateContents" id="preview_templateContents" readonly><?php echo $TPL_VAR["template"]["templateContents"]?></textarea>
				</div>
				<div class="btns">
					<div class="link">
						<ul class="clearbox">
<?php if($TPL_VAR["template"]["kkoLinkType_arr"]){?>
<?php if(is_array($TPL_R1=$TPL_VAR["template"]["kkoLinkType_arr"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
							<li><a href="#"><?php if($TPL_V1=='DS'){?>배송조회<?php }else{?><?php echo $TPL_VAR["template"]["kkoLinkName_arr"][$TPL_K1]?><?php }?></a></li>
<?php }}?>
<?php }else{?>
							<li><a href="#"></a></li>
<?php }?>
						</ul>
					</div>
				</div>
			</div>
		</li>
		<!-- 카카오톡 미리보기 :: END -->
	</ul>

	<div class="box_style_05 resp_message">
		<div class="title">안내</div>
		<ul class="bullet_hyphen ">					
			<li>알림톡 메시지 수정은 아래 3단계로 진행됩니다. [1단계] 카카오 승인 요청 → [2단계] 승인대기중 (3~5일 소요) → [3단계] 승인거절 또는 승인완료</li>	
			<li>광고성 내용이 포함되어 있는 경우 승인 거절 처리됩니다.</li>
			<li>승인 거절된 메시지는 거절 사유 확인 후 내용을 수정하여 다시 승인 요청을 하시기 바랍니다. (별도의 내용 수정이 없는 경우에도 동일)</li>
			<li>내용 입력 시 치환코드 사용하시면 알림톡 전송 시 자동으로 내용이 입력되어 전송됩니다.</li>
		</ul>
	</div>
</div>
<div class="footer">
	<button type="button" onclick="kakaotalk_modify_submit();" class="resp_btn active size_XL">승인 요청</button>
	<button type="button" onclick="closeDialog('kakaotalkPopup');" class="resp_btn v3 size_XL">취소</button>
</div>


<!-- 카카오톡 치환코드 팝업 -->
<div id="infoPopup" class="hide">	
	<div class="content">
		<table class="table_basic tdc">
			<thead>
			<tr>
				<th>치환코드</th>
				<th>설명</th>
			</tr>
			</thead>
			<tbody>
<?php if($TPL_use_replace_code_1){foreach($TPL_VAR["use_replace_code"] as $TPL_K1=>$TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
			<tr class="s_info <?php if(strpos($TPL_K1,'personal')===false){?><?php echo $TPL_K1?>_user<?php }else{?><?php echo $TPL_K1?><?php }?>">
				<td>
					<span onclick="add_replace_code('#&#123;<?php echo $TPL_K2?>&#125;');">#&#123;<?php echo $TPL_K2?>&#125;</span>
				</td>
				<td>
					<?php echo $TPL_V2["name"]?> <?php if($TPL_V2["etc"]){?><br /><span style='color:#696969;font-size:11px;line-height:15px;font-family:돋움;'><?php echo $TPL_V2["etc"]?></span><?php }?>
				</td>
			</tr>
<?php }}?>
<?php }}?>
			</tbody>
		</table>
	</div>

	<div class="footer">
		<button type="button" id="infoPopupCloseBtn" class="resp_btn v3 size_XL">닫기</button>
	</div>
</div>