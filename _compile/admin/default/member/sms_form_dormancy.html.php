<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/member/sms_form_dormancy.html 000013759 */ 
$TPL_sms_cont_1=empty($TPL_VAR["sms_cont"])||!is_array($TPL_VAR["sms_cont"])?0:count($TPL_VAR["sms_cont"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/batch.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	$("#send_submit").click(function(){
		var total_count = 0;
		var x="";
		total_count = x.length;
		if($("input[name='search_member_yn']:checked").val() == "y"){
			total_count += parseInt($("input[name='mcount']").val());
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
		loadingStart();
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

<?php if(preg_match("/chrome/",strtolower($_SERVER['HTTP_USER_AGENT']))||preg_match("/firefox/",strtolower($_SERVER['HTTP_USER_AGENT']))){?>
		if($("input[name='mcount']").val() > 30000){
			openDialogAlert("현재 브라우져에서는 대량 다운로드가 원할하지 않을 수 있습니다.<br />다운로드가 되지 않을 시 IE에서 다운로드 하시기 바랍니다.", 450, 160);
		}
<?php }?>

		openDialog('회원정보 다운로드','admin_member_download', {'width':550,'height':420});
<?php }else{?>
			openDialogAlert('다운로드 권한이 없습니다.<br /> <a href="../setting/manager"><span class="orange"><b>설정 > 관리자</b></span></a>에서 설정할 수 있습니다.', 400, 150);
			return;
<?php }?>
	});	

	var today = new Date();
	var start_date = dateDiffDay(today,0);
	var end_date = dateDiffDay(today,7);
	sDate = start_date.split('-');
	sDate_ = sDate[0]-1+"-"+sDate[1]+"-"+sDate[2];
	eDate = end_date.split('-');
	eDate_ = eDate[0]-1+"-"+eDate[1]+"-"+eDate[2];

	$('#dor_guide_sdate').html(sDate_);
	$('#dor_guide_edate').html(eDate_);
	$('#dor_ing_sdate').html(start_date);
	$('#dor_ing_edate').html(end_date);

	$("#searchDormancyBtn").click(function(){
		var callpage=$(this).attr("callpage");
		$("input[name='mode']").val("search");
		openDialog("회원 검색 <span class='desc'>&nbsp;</span>", "memberSearchDiv", {"width":"100%","height":"800"});

		if($("#memberSearchDiv").html() == "") getSearchMember('dormancy=1&search_flag=1&sc_day_type=lastlogin&lastlogin_search_type=in&regist_sdate='+sDate_+'&regist_edate='+eDate_, 'start', callpage);
	});
});

function select_sms_form(){
	$.get('sms_form_list_pop', function(data) {
		$('#smsFormListPopup').html(data);		
		openDialog("SMS 불러오기", "smsFormListPopup", {"width":"900","height":"700"});
	});
}

function dateDiffDay(date,diff){
	var today = new Date(date);
	var dateAdd = "";
	diff = parseInt(diff);
	dateAdd = new Date(today.setDate(today.getDate() + diff));
	return (dateAdd.getFullYear()) + "-" + date_zero(dateAdd.getMonth() + 1) + "-" + date_zero(dateAdd.getDate());
}

function date_zero(date){
	return parseInt(date, 10) < 10 ? "0" + date : date;
}

function excelDownloadOk(){
	closeDialog('admin_member_download');
	document.smsForm.action ="../batch_process/sms_member_download";
	document.smsForm.submit();
	document.smsForm.action ="../batch_process/send_sms";
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


function send_byte_chk(textareaObj){

	var str		= $(textareaObj).val();
	var smsarea	= $(textareaObj).closest(".sms_area");
	str = sms_replace(str);
	$("#sms_text").html(str);
	
	smsarea.find(".send_byte").html(chkByte(str));
	if(chkByte(str) > 90){
		smsarea.find(".minus_count").html("3");
	}else{
		smsarea.find(".minus_count").html("1");
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
.title_dvs > .resp_btn_dvs{right:23px;}
html{overflow-y:hidden !important;}
</style>

<!-- 페이지 타이틀 바 : 끝 -->
<form name="smsForm" id="smsForm" method="post" target="actionFrame" action="../batch_process/send_sms_dormancy" class="hp100">
<input type="hidden" name="table" value="<?php echo $TPL_VAR["table"]?>" />
<input type="hidden" name="page" value="<?php echo $_GET["page"]?>"/>
<input type="hidden" name="category"/>
<input type="hidden" name="send_num"/>
<input type="hidden" name="mode" value="">
<input type="hidden" name="serialize" id="serialize" value="">
<input type="hidden" name="mcount" value="0">
<input type="hidden" name="searchSelect" value="search">
<input type="hidden" name="selectMember" value="">
<input type="hidden" name="search_member_yn" value="y">

<div class="contents_container">
	<div class="content">
		<div class="item-title">SMS 휴면 고지 발송</div>
		<table class="table_basic thl">		
			<tr>
				<th>잔여 건수</th>
				<td>잔여 <?php echo number_format($TPL_VAR["count"])?>건</td>
			</tr>
			
			<tr>
				<th>보내는 사람</th>
				<td>
<?php if($TPL_VAR["send_phone"]){?><?php echo $TPL_VAR["send_phone"]?><?php }else{?>등록된 발신번호가 없습니다.<?php }?>
					<input type="hidden" name="send_sms" value="<?php echo $TPL_VAR["send_phone"]?>"/>
				</td>
			</tr>
			<tr>
				<th>받는 사람</th>
				<td>
					<span id="search_member" class="bold">0</span>명
					<button type="button" id="searchDormancyBtn" class="resp_btn v2">회원 검색</button>
					<span class="resp_btn" id="downloadMemberBtn"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /><span>다운로드</span></span>		
				</td>
			</tr>

			<tr>
				<th>내용<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/g_member', '#tip7')"></span></th>
				<td>
					<ul class="ul_list_01 mt20 pd0 sms_area">
						<li class="wp65">
							<div class="title_dvs mt0 wp95">
								<div class="item-title">내용 입력</div>
								<div class="resp_btn_dvs">
									<button type="button" id="special_cont" class="resp_btn v2">특수 문자</button>
									<div id="special_view" class="hide">
										<table cellpadding="5" cellspacing="1" border="0" width="100%">
										<tr>							
<?php if($TPL_sms_cont_1){$TPL_I1=-1;foreach($TPL_VAR["sms_cont"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1% 15== 0){?></tr><tr><?php }?>
											<td align="center"><span class="special_char" conts="<?php echo $TPL_V1?>" style="cursor:pointer;"><?php echo $TPL_V1?></span></td>
<?php }}?>
										</tr>
										</table>
									</div>
									<button type="button" onclick="select_sms_form();" class="resp_btn v2">SMS 불러오기</button>						
								</div>
							</div>
							<textarea name="send_message" id="send_message" class="sms_contents wp95" rows="10"></textarea>
							
							<div class="mt5">
								<b id="send_byte" class="send_byte">0</b>byte / <b id="minus_count" class="minus_count">0</b>건 차감
							</div>														
						</li>
						<li class="wp30">
							<div class="item-title">미리보기</div>
							<textarea name="sms_text" id="sms_text" class="wp95" rows="10" readonly disabled></textarea>
						</li>
					</ul>
					<div class="resp_message v2">
						- ‘정보통신망이용 촉진 및 정보보호등에 관한 법률 및 시행령’에 규정된 광고 전송 사업자의 의무사항을 준수하세요
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/g_member', '#tip2')"></span>
					</div>
				</td>
			</tr>
		</table>
		
		<ul class="bullet_hyphen resp_message">
			<li>
				휴면 회원으로 전환 1개월 이전에 고지해주세요. 
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/g_member', '#tip6', 'sizeM')"></span>
			</li>		
			<li>받는 사람이 1,000명 이상 시 받는 사람을 엑셀로 다운로드 받아 <a href="/admin/batch/sms_hp_auth" class="resp_btn_txt" target="_blank">대량 SMS 발송</a> 기능으로 SMS를 보내주세요.</li>	
		</ul>	

		<div class="item-title">발송 시간</div>
		<table class="table_basic thl">		
			<tr>
				<th>
					발송 시간 설정
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/g_member', '#tip5')"></span>
				</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="sms_reserve_yn" value="n" checked> 즉시 발송</label>						
						<label>							
							<input type="radio" name="sms_reserve_yn" value="y">
							예약 발송							
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
						</label>
					</div>
				</td>
			</tr>
		</table>
		<div class="resp_message">
			- 예약 발송 선택 시, 현재보다 이전 시간으로 설정하시는 경우 SMS가 즉시 발송 됩니다.
		</div>

		<div class="center mt20">
			<label class="resp_checkbox"><input type="checkbox" name="agree_yn" value="y" onclick="agree_yn_check();"> ‘정보통신망이용 촉진 및 정보보호등에 관한 법률 및 시행령’ 위반에 따른 책임은 당사에게 있음에 동의합니다.</label>
		</div>
		
		<div class="hx70"></div>			
	</div>

	<div class="footer">
		<button type="button" id="send_submit" <?php if($TPL_VAR["count"]< 1){?>disabled<?php }?> class="resp_btn active size_XL">발송</button>
		<button type="button" class="resp_btn v3 size_XL" onclick="window.close();">취소</button>
	</div>
</form>
<!-- 여기서 부터 기존 폼-->

<a name="sms_form"></a>

<div id="smsFormListPopup" class="hide"></div>
<div id="authPopup" class="hide"></div>
<?php $this->print_("member_download_info",$TPL_SCP,1);?>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>