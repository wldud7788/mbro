<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/batch/restock_notify_sms.html 000030160 */ 
$TPL_sms_cont_1=empty($TPL_VAR["sms_cont"])||!is_array($TPL_VAR["sms_cont"])?0:count($TPL_VAR["sms_cont"]);
$TPL_sms_loop_1=empty($TPL_VAR["sms_loop"])||!is_array($TPL_VAR["sms_loop"])?0:count($TPL_VAR["sms_loop"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<script type="text/javascript">
$(document).ready(function() {

	$("#searchMemberBtn").click(function(){
		$("input[name='mode']").val("search");
		openDialog("회원 검색 <span class='desc'>&nbsp;</span>", "memberSearchDiv", {"width":"100%","height":"800"});
		if($("#memberSearchDiv").html() == "") getSearchMember('', 'start', 'y');
	});

	$("body").append('<div id="memberSearchDiv" class="hide"></div>');
	//getSearchMember('', 'start');
	

	$("#send_submit").click(function(){
		var total_count = 0;
		var x="";
		var count = "<?php echo $TPL_VAR["count"]?>";
		
		total_count = parseInt($("input[name='mcount']").val());

		if(total_count == 0){
			openDialogAlert('검색된 회원이 없습니다.', 400, 140);
			return;
			
		}

		if(total_count > parseInt(count) ) {
			openDialogAlert('SMS 전송 실패 – SMS 잔여건수 부족', 400, 140);
			return;			
		}

		if(total_count > 1000){
			openDialogAlert('1,000명 이상은 받는 사람을 엑셀로 다운로드 받아<br> 대량SMS 발송 기능으로 SMS를 보내 주십시오.', 400, 150);
			return;
		}

		if($("input[name='agree_yn']").attr("checked")){

		}else{
			openDialogAlert('‘정보통신망이용 촉진 및 정보보호등에 관한 법률 및 시행령’ 위반에 따른 책임은 귀사에게 있음에 동의하셔야만 발송이 가능합니다.', 600, 150);
			return;

		}
		openDialog('처리','processDiv', {'width':550,'height':140});
		document.smsForm.submit();
	});


	$(".sms_contents").live('keyup change',function(){
		send_byte_chk(this);
	});

	// SPECIAL CHARACTER
	$("#special_cont").click(function(){
		if($("#special_view").css("display")=='none') $("#special_view").show();
		else $("#special_view").hide();
	});

	$(".special_char").click(function(){
		var str = $("#send_message").val();
		$("#send_message").val(str+$(this).attr('conts'));
		send_byte_chk($("#send_message"));
	});

	send_byte_chk($("#send_message"));

	$("#downloadMemberBtn").click(function(){
<?php if($TPL_VAR["auth_member_down"]){?>
		if($("input[name='mcount']").val() == 0){
			openDialogAlert('다운로드 파일이 없습니다.<br />먼저 회원을 검색해 주세요.', 400, 150);
			return;
		}

		openDialog('회원정보 다운로드','admin_member_download', {'width':550,'height':420});
<?php }else{?>
			openDialogAlert('다운로드 권한이 없습니다.<br /> <a href="../setting/manager"><span class="orange"><b>설정 > 관리자</b></span></a>에서 설정할 수 있습니다.', 400, 150);
			return;
<?php }?>
	});


	$("#open_save_sms").click(function(){
		loadSmsForm('');
		openDialog("저장된 SMS <span class='desc'>&nbsp;</span>", "save_sms", {"width":"800","height":"550"});
	});

	
	// ADD SMS FORM
	$("#add_sms_form").click(function(){
		openDialog("보관 메시지 추가", "add_sms_popup", {"width":"300","height":"300","show" : "fade","hide" : "fade"});
		$("#sms_form_group").val('');
		$("input[name='album_seq']").val('');
		$("#sms_form_text").val('');
	});
	//
	$(".mod_form").live("click",function(){
		openDialog("보관 메시지 수정", "add_sms_popup", {"width":"300","height":"300","show" : "fade","hide" : "fade"});
		$("#sms_form_group").val($(this).parents().find("textarea").attr("codecd"));
		$("input[name='album_seq']").val($(this).attr("seq"));
		$("#sms_form_text").val($(this).parents().find("textarea").val());
		send_byte_chk($("#sms_form_text"));

	});
	$(".del_form").live("click",function(){
		parent.actionFrame.location.href = "../member_process/delete_smsform?seq="+$(this).attr("seq");
	});

	// POPUP SMS ADD FORM
	$("#add_sms_group").click(function(){
		$("#sms_form_id").show();
		$("select[name='sms_form_group']").attr('disabled',true);
		$("input[name='sms_form_name']").attr('disabled',false);
	});
	$("#del_sms_group").click(function(){
		$("#sms_form_id").hide();
		$("select[name='sms_form_group']").attr('disabled',false);
		$("input[name='sms_form_name']").attr('disabled',true);
	});

});

function searchSubmit(){
	var serialize = $("#memberForm").serialize();
	getSearchMember(serialize, '');
}


function searchPaging(query_string){
	// keyword 검색 IE에서 한글깨짐 예외처리
	var serialize		= query_string.replace(/keyword\=[^\&]*\&/, '');
	var keyword			= $("#memberForm").find("input[name='org_keyword']").val();
	if	(keyword)	serialize	+= '&keyword=' + encodeURIComponent(keyword);
	getSearchMember(serialize, '' ,'');
}

//회원 검색 폼
function getSearchMember(query_string, callType, callPage){
	if(callType == "start" && callPage == "y"){
		query_string = "scriptPaging="+callPage;
	}
	
	$.ajax({
		type: "get",
		url: "/admin/goods/restock_notify_catalog",
		data: query_string,
		success: function(result){
			$("#memberSearchDiv").html(result);
			apply_input_style();
			searchCount = $("input[name='searchcount']").val();
		}
	});
}

function serchMemberInput(){
	if ($("input[name='keyword']").val()==$("input[name='keyword']").attr('title')) {
		$("input[name='keyword']").val('');
	}

	searchCount = $("input[name='searchcount']").val();
	serialize = decodeURIComponent($("#memberForm").serialize());

	$("#searchSelectText").html("검색된");
	$("#serialize").val(serialize);
	$("#search_member").html(comma(searchCount));
	$("input[name='mcount']").val(searchCount);
	$("input[name='selectMember']").val('');
	$("input[name='searchSelect']").val('search');

	var reciveTitle = "받는 사람";
	$('.member_chk').attr("checked", false);
	$('.all_member_chk').attr("checked", false);

	openDialogAlert('[받는사람-검색회원] 검색된 요청자 '+comma(searchCount)+'명이 '+reciveTitle+'에 들어 갔습니다.', 600, 150);
	closeDialog("memberSearchDiv");		
}

function serchMemberInputDown(){
	if ($("input[name='keyword']").val()==$("input[name='keyword']").attr('title')) {
		$("input[name='keyword']").val('');
	}
	
	searchCount = $("input[name='searchcount']").val();
	serialize = decodeURIComponent($("#memberForm").serialize());
	
	$("#serialize").val(serialize);
	$("#search_member").html(comma(searchCount));
	$("input[name='mcount']").val(searchCount);
	$("input[name='selectMember']").val('');
	$("input[name='searchSelect']").val('search');

	closeDialog("memberSearchDiv");		
	openDialog('회원정보 다운로드','admin_member_download', {'width':550,'height':420});
}

function selectMemberInput(call){
	var selectMember = $("input[name='selectMember']").val();
	var selectMemberArray = new Array();
	selectMemberArray = selectMember.split(',');
	
	if(selectMember == ""){
		alert("선택된 회원이 없습니다.");
		return;
	}

	$("#search_member").html(comma(selectMemberArray.length));
	$("#searchSelectText").html("선택된");
	
	$("input[name='mcount']").val(selectMemberArray.length);
	$("input[name='searchSelect']").val('select');

	var reciveTitle = "받는 사람";
	var params = new Array();
	params['yesMsg'] = "발송화면으로 가기";
	if(call == "emoney"){
		reciveTitle = "대상자";
		params['yesMsg'] = "지급화면으로 가기";		
	}
	
	params['noMsg'] = "계속 선택하기";


	openDialogConfirm('[받는사람-선택회원] 선택된 회원 '+comma(selectMemberArray.length)+'명이 '+reciveTitle+'에 들어 갔습니다. (중복된 회원 제외)',600, 150,function(){
		closeDialog("memberSearchDiv");
	},function(){
		
	}, params);
}


function selectMemberInputDown(){
	var selectMember = $("input[name='selectMember']").val();
	var selectMemberArray = new Array();
	selectMemberArray = selectMember.split(',');
	
	if(selectMember == ""){
		alert("선택된 회원이 없습니다.");
		return;
	}

	$("#search_member").html(comma(selectMemberArray.length));
	$("#searchSelectText").html("선택된");
	
	$("input[name='mcount']").val(selectMemberArray.length);
	$("input[name='searchSelect']").val('select');

	closeDialog("memberSearchDiv");		
	openDialog('회원정보 다운로드','admin_member_download', {'width':550,'height':420});
}


function allMemberClick(){
	$('.member_chk').each(function(){
		selectMemberClick($(this));
	});
}

function selectMemberClick(obj){
	var selectMember = $("input[name='selectMember']").val();
	var selectMemberArray = new Array();
	if(selectMember != ""){
		selectMemberArray = selectMember.split(',');
	}	

	if($(obj).is(":checked")){
		
		var inBoolen = true;
		for(i=0; i<selectMemberArray.length; i++){
			if(selectMemberArray[i] == $(obj).val()){
				inBoolen = false;
			}
		}

		if(inBoolen){
			if(selectMemberArray.length){
				selectMember += ","+$(obj).val();
			}else{
				selectMember = $(obj).val();
			}
		}
		
		
	}else{
		var newSelectMember="";
		for(i=0; i<selectMemberArray.length; i++){
			if(selectMemberArray[i] != $(obj).val()){
				if(newSelectMember == "") newSelectMember = selectMemberArray[i];
				else newSelectMember += ","+selectMemberArray[i];
			}
		}
		selectMember = newSelectMember;
		//selectMember = selectMember.replace($(obj).val()+",","");
		//selectMember = selectMember.replace($(obj).val(),"");	
	}
	$("input[name='selectMember']").val(selectMember);
}


function excelDownloadOk(){
	closeDialog('admin_member_download');
	document.smsForm.action ="../batch_process/restock_member_download";
	document.smsForm.submit();
	document.smsForm.action ="../batch_process/restock_notify_send_sms";
}
function sms_loading_stop(){
	$(".sms_form_table").css({'opacity':'1'}).activity(false);
	$("#send_submit_span").show();
}

// SEND MEMBER COUNT - IFRAME CONTROLLER
function sendMemberSum(){
	var add_cnt = $("select[name='send_to_list'] option").size();
	var chk = $("input:radio[name='member']:checked").val();
	var chk_cnt = 0;
	if(chk=='all'){
		chk_cnt = $("input:radio[name='member']:checked").attr("count");
	}else if(chk=='search'){
		chk_cnt = parent.$("input[name='searchcount']").val();
	}else if(chk=='excel'){
		chk_cnt = 0;
	}else if(chk=='select'){
<?php if($TPL_VAR["table"]=='fm_goods_restock_notify'){?>
		chk_cnt = parent.$("input:checkbox[name='restock_notify_seq[]']:checked").length;
<?php }else{?>
		chk_cnt = parent.$("input:checkbox[name='member_chk[]']:checked").length;
<?php }?>
	}

	var add_chk = $("input[name='add_num_chk']").attr('checked');
	if(add_chk=='checked'){
		chk_cnt = 0;
	}
	var total = parseInt(add_cnt) + parseInt(chk_cnt);
	$("#send_member").attr("count",total);
	$("#send_member").html(total);
}

function sms_form_container(pageNumber){

	var sms_search = $("input[name='sms_search']").val();
	var category = $("input[name='category']").val();
	
	
	$.ajax({
		type: 'post',
		url: '../member_process/getSmsForm',
		data: 'category='+category+'&sms_search='+sms_search+'&perpage=4'+pageNumber,
		dataType: 'json',
		success: function(data) {
			$('#sms_form_container').html(data);

			$('#sms_form_container .sms_contents').each(function(){
				send_byte_chk(this);
			});

		}
	});
	//sendMemberSum();
}

function get_sms_category(){

	$.ajax({
		type: 'post',
		url: '../batch/getSmsCategory',
		dataType: 'html',
		success: function(data) {
			$('#sms_category').html(data);
		}
	});


}

function get_sms_select_category(){

	$.ajax({
		type: 'post',
		url: '../batch/getSmsSelectCategory',
		dataType: 'html',
		success: function(data) {
			$('#selectCategoryList').html(data);
		}
	});


}



//
function loadSmsForm(value){
	$("input[name='category']").val(value);
	$("input[name='page']").val('');
	
	$('.tdCategoryList').each(function(){
		if($(this).attr("category_name") == value){
			$(this).css("font-weight","bold");
		}else if(value == "" && $(this).attr("category_name") == "전체보기"){
			$(this).css("font-weight","bold");
		}else{
			$(this).css("font-weight","");
		}
	});

	sms_form_container("&page=0");
}

function send_byte_chk(textareaObj){

	var str = $(textareaObj).val();
	str = sms_replace(str);
	$("#sms_text").html(str);
	$(textareaObj).parent().find(".send_byte").html(chkByte(str));
	if(chkByte(str) > 90){
		$(textareaObj).parent().find(".minus_count").html("3");
	}else{
		$(textareaObj).parent().find(".minus_count").html("1");
	}
}

function chkByte(str){
	var cnt = 0;
	for(i=0;i<str.length;i++) {
		cnt += str.charCodeAt(i) > 128 ? 2 : 1;
	}
	return cnt;
}

function agree_yn_check(){
	var agree_text = "";
	if($("input[name='agree_yn']").attr("checked")){
		agree_text= "위 내용에 대하여 <?php echo date('Y년m월d일 H시i분s초')?>에 <?php echo $TPL_VAR["managerInfo"]["mname"]?>(<?php echo $TPL_VAR["managerInfo"]["manager_id"]?>)께서 동의하셨습니다.";
		$("#agree_text").show();
	}else{
		$("#agree_text").hide();
	}
	
	$("#agree_text").html(agree_text);
}

function go_batch_sms(){

	opener.location.href = "/admin/batch/sms_hp_auth";
	self.close();

}
</script>

<style>
.scrollbox03{ font-size: 12px;  overflow:auto;  padding:0px;  border:1px;  border-style:solid;border-color:#d1d1d1;scrollbar-face-color: #ffffff; scrollbar-highlight-color: #f7f7f7; scrollbar-shadow-color: #B1B1B1; scrollbar-3dlight-color: #B1B1B1; scrollbar-arrow-color: #A1A1A1;
scrollbar-darkshadow-color: #ffffff; width:95%;}

/* 자세히 보기 링크 */
a.detail_link {
	color: #5583dd !important;
	margin-left:5px;
}
</style>
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>재입고알림 - 문자발송(수동)</h2>
		</div>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->
<form name="smsForm" id="smsForm" method="post" target="processFrame" action="../batch_process/restock_notify_send_sms">
<input type="hidden" name="table" value="<?php echo $TPL_VAR["table"]?>" />
<input type="hidden" name="page" value="<?php echo $_GET["page"]?>"/>
<input type="hidden" name="category"/>
<input type="hidden" name="send_num"/>
<input type="hidden" name="mode" value="">
<input type="hidden" name="serialize" id="serialize" value="">
<input type="hidden" name="mcount" value="0">
<input type="hidden" name="searchSelect" value="search">
<input type="hidden" name="selectMember" value="">

<table class="info-table-style" style="width:100%">
<colgroup>
	<col width="200" />
	<col width="*" />
</colgroup>
<tbody>

<tr>
	<th class="its-th-align center">잔여건수</th>
	<td class="its-td"><?php echo number_format($TPL_VAR["count"])?>건 <span class="desc">(받는 사람이 1,000명 이상 시 받는 사람을 엑셀로 다운로드 받아 <span class=" highlight-link hand" onclick="go_batch_sms();">대량SMS발송</span> 기능으로 문자를 보내 주십시오)</span></td>
</tr>
<tr>
	<th class="its-th-align center">보내는 사람</th>
	<td class="its-td">
<?php if($TPL_VAR["send_phone"]){?><?php echo $TPL_VAR["send_phone"]?><?php }else{?>등록된 발신번호가 없습니다. <span class="btn medium"><a href="https://firstmall.kr/myshop/sms/sms_send_phone.php?num=<?php echo $TPL_VAR["config_system"]["shopSno"]?>" target="_blank">발신번호 인증</a></span> <span class="btn small orange"><button type="button" onclick="openDialog('발신번호 인증 안내','smsMyFirstmallInfo',{'width':850,'height':830});">안내) 발신번호 인증방법</button></span><?php }?>
		<input type="hidden" name="send_sms" value="<?php echo $TPL_VAR["number"]?>" title="전화번호를 입력하세요"/>
	</td>
</tr>
<tr>
	<th class="its-th-align center">받는 사람(검색)</th>
	<td class="its-td">
	<label ><input type="checkbox" name="search_member_yn" value="y" checked class='hide'><span id="searchSelectText">검색된</span> 요청자</label> (<span class="hand" id="downloadMemberBtn"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /><u>엑셀다운로드</u></span> <span id="search_member">0</span>명)
	<span class="btn small"><button type="button" id="searchMemberBtn">재입고알림 요청자 검색</button></span>
	</td>
</tr>
<tr>
	<th class="its-th-align center">문자내용</th>
	<td class="its-td">
	<div style="position:relative;">
		<input type="text" name="send_message" id="send_message" class="sms_contents" style="width:700px;" value="<?php echo $TPL_VAR["send_message"]?>">
		<span class="btn small black"><button type="button" id="open_save_sms">저장한 SMS 불러오기</button></span>
		<span class="btn small black"><button type="button" id="special_cont">특수문자</button></span>
		<div id="sms_text" class="desc"></div>
		<b id="send_byte" class="send_byte">0</b>byte / <b id="minus_count" class="minus_count">0</b>건 차감
		<div id="special_view" style="position:absolute;width:340px;z-index:100;display:none; margin-left: 200px; margin-top: 0px;border:2px solid #aaaaaa;padding:3px;background-color:#eeffee;">
		<table cellpadding="5" cellspacing="1" border="0" width="100%">
		<tr>
<?php if($TPL_sms_cont_1){$TPL_I1=-1;foreach($TPL_VAR["sms_cont"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1% 15== 0){?></tr><tr><?php }?>
			<td align="center"><span class="special_char" conts="<?php echo $TPL_V1?>" style="cursor:pointer;"><?php echo $TPL_V1?></span></td>
<?php }}?>
		</tr>
		</table>
		</div>
		<br><br>
		<span class="desc">
		1) SMS(단문) 차감 : 90bytes 이하 시 SMS로 발송되며 1건이 차감 <br />
		2) LMS(장문) 차감 : 91bytes 이상 시 LMS로 발송되며 3건이 차감 <br />
		3) 특수문자 사용 : 특수문자 버튼을 클릭하여 작성하셔야 문자깨짐 및 짤림현상을 예방할 수 있습니다. <br />
		4) 치환코드
		· &#123;userName&#125; : 개인회원 - 해당 회원의 이름으로 치환됨 / 기업회원 - 해당 회원의 대표자명으로 치환됨 / 이름이 없을 경우 - '고객'으로 치환됨 <br />
		· &#123;상품고유값&#125; : 상품의 고유번호 <br />
		· &#123;상품명&#125; : 상품명의 길이가 긴 경우 <span class="goods_name_limit hide"><input type="text" name="limit_goods_name" value="" size="3" style="text-align:right;" class="onlynumber" maxlength="3"> 자로 </span><select name="limit_goods_name_yn" onchange="limit_goods_name_chg(this.value);"><option value="n">제한안함</option><option value="y">제한함</option></select><br />
		&#123;상품옵션&#125; : 상품옵션의 길이가 긴 경우 <span class="goods_option_limit hide"><input type="text" name="limit_goods_option" value="" size="3" style="text-align:right;" class="onlynumber" maxlength="3"> 자로 </span><select name="limit_goods_option_yn" onchange="limit_goods_option_chg(this.value);"><option value="n">제한안함</option><option value="y">제한함</option></select><br />
		· &#123;상품주소&#125; : <label><input type="radio" name="shorten_url_yn" value="n" checked>원래 URL 사용</label> <label><input type="radio" name="shorten_url_yn" value="y">짧은 URL 사용</label> <br />
		<script>
			function limit_goods_name_chg(str){
				if(str == "y"){
					$(".goods_name_limit").show();
				}else{
					$(".goods_name_limit").hide();
				}
			}

			function limit_goods_option_chg(str){
				if(str == "y"){
					$(".goods_option_limit").show();
				}else{
					$(".goods_option_limit").hide();
				}
			}
		</script>

		   <span style="font-size:12px;">※</span> 이름 치환코드 사용 시 개인회원 : 해당회원의 이름이로 치환됨, 기업회원 : 해당 회원의 대표자명으로 치환됨, 이름이 없을 경우 : `고객`으로 치환됨 <br />
		5) 문자내용 표기의무 <br />
		· 광고 전송 시 ‘정보통신망이용 촉진 및 정보보호등의 관한 법률 및 시행령’에 따라 광고성 정보가 시작되는 부분에 ‘(광고)’를 표시하고,  <br />
		  수신자가 어디에서 온 광고인지를 인지할 수 있도록 전송자의 명칭과 연락처를 표시 <br />
		· 수신거부 또는 수신동의의 철회용 전화번호 또는 전화에 갈음하여 쉽게 수신의 거부 또는 수신동의 철회를 할 수 있는 방식을 광고성 정보가 끝나는 부분에 명시 <br />
		· 수신의 거부 또는 수신동의의 철회를 할 수 있는 방식을 수신자가 비용을 부담하지 아니한다는 것과 함께 안내
		</span>
	</div>
	<div style="position:absolute; right:10px; top:250px;">
		<img src="/admin/skin/default/images/design/mobile_sms.png">
	</div>
	</td>
</tr>
<tr>
	<th class="its-th-align center">발송 시간</th>
	<td class="its-td">
		<label><input type="radio" name="sms_reserve_yn" value="n" checked>지금 발송합니다.</label>
		<label>
			<input type="radio" name="sms_reserve_yn" value="y">
			<select name="reserve_hour">
				<option value="08">8시</option>
				<option value="09">9시</option>
				<option value="10">10시</option>
				<option value="11">11시</option>
				<option value="12">12시</option>
				<option value="13">13시</option>
				<option value="14">14시</option>
				<option value="15">15시</option>
				<option value="16">16시</option>
				<option value="17">17시</option>
				<option value="18">18시</option>
				<option value="19">19시</option>
				<option value="20">20시</option>
			</select>

			<select name="reserve_min">
				<option value="00">00분</option>
				<option value="10">10분</option>
				<option value="20">20분</option>
				<option value="30">30분</option>
				<option value="40">40분</option>
				<option value="50">50분</option>
			</select>
			부터 순차적으로 예약 발송합니다.
		</label>
		<br />
		<span class="desc">
		정보통신망이용 촉진 및 정보보호등에 관한 법률 &nbsp;제50조 (영리목적의 광고성 정보 전송 제한)<br />
		③ 오후 9시부터 그 다음 날 오전 8시까지의 시간에 전자적 전송매체를 이용하여 영리목적의 광고성 정보를 전송하려는 자는 제1항에도 불구하고 그 수신자로부터 별도의 사전 동의를 받아야 한다.
		</span>
	</td>
</tr>
<tr>
	<td class="its-td" style="padding:0px !important;" colspan="2">
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td height="30px" colspan="2" style="color:#ff0000; text-align:center;" bgcolor="#f1f1f1"><b>‘정보통신망이용 촉진 및 정보보호등에 관한 법률 및 시행령’에 규정된 광고 전송 사업자의 의무사항을 준수하시기 바랍니다.</b></td>
			</tr>
			<tr>
				<td class="its-td" width="50%" style="border-top:1px solid #dadada; border-right:1px solid #dadada;">
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td colspan="2"><b>정보통신망 이용촉진 및 정보보호 등에 관한 법률</b></td>
					</tr>
					<tr>
						<td width="10"><span style="font-size:5px;">●</span></td>
						<td>
							제50조 (영리목적의 광고성 정보 전송 제한)
							<a class="detail_link" href="http://www.law.go.kr/법령/정보통신망이용촉진및정보보호등에관한법률/(20190625,16021,20181224)/제50조" target="_blank">
							자세히 보기>
							</a>
						</td>
					</tr>
					<tr>
						<td><span style="font-size:5px;">●</span></td>
						<td>
							제76조 (과태료)
							<a class="detail_link" href="http://www.law.go.kr/법령/정보통신망이용촉진및정보보호등에관한법률/(20190625,16021,20181224)/제76조" target="_blank">
							자세히 보기>
							</a>
						</td>
					</tr>
				</table>
				</td>
				<td class="its-td" width="50%" style="border-top:1px solid #dadada;">
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td colspan="2"><b>한국인터넷진흥원 (KISA)</b></td>
					</tr>
					<tr>
						<td width="10"><span style="font-size:5px;">●</span></td>
						<td>
							광고정보 전송 시 준수사항
							<a class="detail_link"  href="https://spam.kisa.or.kr/spam/sub62.do" target="_blank">
							자세히 보기>
							</a>
						</td>
					</tr>
					<tr>
						<td><span style="font-size:5px;">●</span></td>
						<td>
							광고전송가이드
							<a class="detail_link"  href="https://spam.kisa.or.kr/spam/sub73.do" target="_blank">
							자세히 보기>
							</a>
						</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center; border-top:1px solid #dadada; padding:10px 0px 10px 0px;">
					‘정보통신망이용 촉진 및 정보보호등에 관한 법률 및 시행령’ 위반에 따른 책임은 귀사에게 있음에 동의하시겠습니까?<br />
					<label><input type="checkbox" name="agree_yn" value="y" onclick="agree_yn_check();"> 예, 동의합니다.</label>
					<div id="agree_text" class="desc"></div>
				</td>
			</tr>
		</table>
	</td>
</tr>

</table>

<div style="text-align:center; padding-top:20px;"><span class="btn large cyanblue"><button type="button" id="send_submit" >보내기</button></span></div>

</form>
<!-- 여기서 부터 기존 폼-->

<a name="sms_form"></a>

<div id="add_sms_popup" class="hide">
<form name="popForm" method="post" action="../member_process/sms_process" target="actionFrame">
<input type="hidden" name="mode" value="sms_form"/>
<input type="hidden" name="album_seq"/>
	<table width="100%" cellspacing="0">
	<tr><td id="selectCategoryList">
			<select name="sms_form_group" id="sms_form_group">
				<option value="">= 그룹을 선택하세요 =</option>
<?php if($TPL_sms_loop_1){foreach($TPL_VAR["sms_loop"] as $TPL_V1){?>
<?php if($TPL_V1["category"]!="전체보기"){?>
				<option value="<?php echo $TPL_V1["category"]?>"><?php echo $TPL_V1["category"]?></option>
<?php }?>
<?php }}?>
			</select> <span class="btn small gray"><button type="button" id="add_sms_group">그룹추가</button></span>
			<span id="sms_form_id" class="hide"><input type="text" name="sms_form_name"> <span class="btn small gray"><button type="button" id="del_sms_group">취소</button></span></span>
	</td></tr>
	<tr><td>
		<div style="padding:2px;">
			<div class="sms-define-form">
				<div class="sdf-head clearbox">
					<div class="fl"><img src="/admin/skin/default/images/common/sms_i_antena.gif"></div>
					<div class="fr"><img src="/admin/skin/default/images/common/sms_i_battery.gif"></div>
				</div>
				<div class="sdf-body-wrap">
					<div class="sdf-body">
						<textarea name="sms_form_text" id="sms_form_text"  class="sms_contents"></textarea>
						<div class="sdf-body-foot clearbox">
							<div class="fl"><b id="send_byte" class="send_byte">0</b>byte</div>
							<div class="fr"><img src="/admin/skin/default/images/common/sms_btn_send.gif" align="absmiddle" class="del_message" /></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</td></tr>
	</table>
	<span class="btn small gray center"><button type="button" onclick="document.popForm.submit();">확인</button></span>
</form>
</div>

<div id="save_sms" class="hide">
	<!-- ### RECEIVE MESSAGE FORM -->
	<table width="100%" cellspacing="0">
	<tr>
		<td>
			<table width="100%" cellspacing="0">
			<tr>
				<td valign="top" id="sms_category">

					<table width="100%" class="info-table-style">
					<tr>
<?php if($TPL_sms_loop_1){$TPL_I1=-1;foreach($TPL_VAR["sms_loop"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1% 5== 0){?></tr><tr><?php }?>
						<td class="its-td-align tdCategoryList" style="border-top:1px solid #dddddd;border-right:1px solid #dddddd;text-align:center;width:20%;" category_name="<?php echo $TPL_V1["category"]?>"><?php if($TPL_I1== 0){?><a href="javascript:loadSmsForm('');"><?php }else{?><a href="javascript:loadSmsForm('<?php echo $TPL_V1["category"]?>');"><?php }?><?php echo $TPL_V1["category"]?></a></td>
<?php }}?>
					</tr>
					</table>

				</td>
				<td valign="top" align="right">
				<span class="btn small gray"><button type="button" id="add_sms_form">추가</button></span>				
				</td>
			</tr>
			</table>

			</div>

		</td>
	</tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td align="center">
			<input type="text" name="sms_search" class="line" style="height:12px;"/><span class="btn small gray"><button type="button" id="sms_form" onclick="sms_form_container('&page=0');">검색</button></span>
		</td>
	</tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td align="center">

		<div id="sms_form_container"></div>

		<div id="sms_form_page" style="width:100%;text-align:center;"></div>

		</td>
	</tr>
	</table>
</div>
<div id="authPopup" class="hide"></div>

<div id="processDiv" class="hide">
<div style='height:10px;'></div>
<table width="100%" cellspacing="0" cellpadding="0" style='border:1px solid #d2d2d2'>
	<tr>
		<td>
		<iframe src="" name="processFrame" frameborder="0" width="100%" height="30" scrolling="no"></iframe>
		</td>
	</tr>
</table>
</div>

<div id="smsMyFirstmallInfo" class="hide">
	<img src="//interface.firstmall.kr/firstmall_plus/images/sms/sms_aimg01.jpg" usemap="#smsFirstmallMap">
</div>
<map name="smsFirstmallMap">
	<area shape="rect" coords="0,30,172,72" href="#" onclick="window.open('https://firstmall.kr/myshop/sms/sms_send_phone.php?num=<?php echo $TPL_VAR["config_system"]["shopSno"]?>');" title="" target="_blank"/>
</map>

<?php $this->print_("member_download_info",$TPL_SCP,1);?>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>