<?php /* Template_ 2.2.6 2021/11/16 10:32:03 /www/music_brother_firstmall_kr/admin/skin/default/batch/email_form.html 000006470 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<style>
html{overflow-y:hidden !important;}

</style>

<script type="text/javascript" src="/app/javascript/js/batch.js?v=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js"></script>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common-ui.css" />

<style>
	html{ overflow-y:hidden !important; }
</style>
<script type="text/javascript">
	var dataObj = {
		'protocol' : '<?php echo $TPL_VAR["protocol"]?>',
		'agreeManager' : '<?php echo $TPL_VAR["agreeManager"]?>',
	};

	$(document).ready( function() {	
	
	Editor.onPanelLoadComplete(function(){
		$("#container", document).height($(document).height());
	});

	setContentsSelect("search_member_yn", "n");
	
	$(".emailSubmit").on('click', function() { 
		sendEmail(<?php echo $TPL_VAR["mail_count"]?>);
	});
});
</script>

<form name="emailForm" method="post" target="processFrame" action="../batch_process/send_email" style="height:100%;">
	<input type="hidden" name="callPage" id="callPage" value="email" />
	<input type="hidden" name="mcount" value="0">
	<input type="hidden" name="member" value="search"/>
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="searchSelect" value="search">
	<input type="hidden" name="selectMember" value="">
	<input type="hidden" name="serialize" id="serialize" value="">
	<input type="hidden" name="verify" id="verify" value="<?php echo $TPL_VAR["verify"]?>">

<div class="contents_container">
	<div class="content">
		<div class="item-title">이메일 발송</div>
		<table class="table_basic thl">		
			<tr>
				<th>잔여 건수</th>
				<td>잔여 <?php echo number_format($TPL_VAR["mail_count"])?>건</td>
			</tr>	
			<tr>
				<th>보내는 사람</th>
				<td>
					<input type="text" name="send_email" value="<?php echo $TPL_VAR["number"]?>" style="width:600px;" title="메일 주소 입력"/>
				</td>
			</tr>	
			<tr>
				<th>받는 사람</th>
				<td>
					<select name="search_member_yn">
						<option value="n">직접 입력</option>
						<option value="y">검색 입력</option>
					</select>
					<span class="search_member_yn_n hide"><input type="text" name="send_to" style="width:80%;" title="메일 주소는 ,(콤마)로 구분하여 입력"></span>
					<span class="search_member_yn_y hide ml10">
						<span id="search_member" class="bold">0</span>명
						<button type="button" id="searchMemberBtn" class="resp_btn v2" callpage="email">회원검색</button>
						<span class="resp_btn" id="downloadMemberBtn" mode="email"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> 다운로드</span>
					</span>
				</td>
			</tr>
			<tr>
				<th>제목</th>
				<td>
					<input type="text" id="title" name="title" style="width:80%;" title="메일 제목을 입력하세요."> 
					<button type="button" id="open_email_list" class="resp_btn v2" onclick="emailLogList()">이메일 불러오기</button>
					<div class="resp_message v2">- ‘정보통신망이용 촉진 및 정보 보호 등의 관한 법률 및 시행령’에 따라 광고 전송 시 제목에 (광고)를 표시해주세요.</div>
				</td>
			</tr>
		</table>
		<ul class="bullet_hyphen resp_message">
			<li>받는 사람이 1,000명 이상 시 받는 사람을 엑셀로 다운로드 받아 <a href="/admin/member/amail" target="_blank" class="resp_btn_txt">대량 이메일 발송</a> 기능으로 문자를 보내주세요.</li>
			<li>매월 3000건이 무료로 지급되며 남은 건수는 이월되지 않습니다.</li>
		</ul>
		
		<div class="item-title">내용</div>
		<textarea name="contents" id="contents" class="daumeditor" style="width:80%" title="내용을 입력해 주세요."></textarea>
		<div class="resp_message">
			- ‘정보통신망이용 촉진 및 정보보호등에 관한 법률 및 시행령’에 규정된 광고 전송 사업자의 의무사항을 준수하세요.
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/g_member', '#tip2')"></span>
		</div>

		<div class="item-title">수신 거부 안내</div>
		<table class="table_basic thl">		
			<tr>
				<th>
					수신 거부 링크
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/g_member', '#tip3', 'sizeM')"></span>
				</th>
				<td>
					<?php echo $TPL_VAR["protocol"]?><input type="text" name="site_url" value="<?php echo $TPL_VAR["domain"]?>" onkeyup="change_domain();">
					<button type="button" onclick="copy_unsubscribe('kor');" class="resp_btn">한글 복사</button>
					<button type="button" onclick="copy_unsubscribe('eng');" class="resp_btn">영문 복사</button>
					<button type="button" onclick="check_unsubscribe();" class="resp_btn v2">정상 여부 확인</button>
				</td>
			</tr>								
		</table>
		
		<div class="center mt20">
			<label class="resp_checkbox"><input type="checkbox" name="agree_yn" value="y" onclick="agree_yn_check();"> ‘정보통신망이용 촉진 및 정보보호등에 관한 법률 및 시행령’ 위반에 따른 책임은 당사에게 있음에 동의합니다.</label>
			<br /><span id="agree_text" class='red'></span>
		</div>
		
	</div>

	<div class="footer">		
		<button type="submit" class="emailSubmit resp_btn active size_XL">발송</button>
		<button type="button" class="resp_btn v3 size_XL" onclick="window.close();">취소</button>
	</div>
</div>
</form>

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

<div id="lay_issued_member"></div>
<div id="emailLogListPopup" class="hide"></div>

<?php $this->print_("member_download_info",$TPL_SCP,1);?>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>


<script type="text/javascript">
	var h = $( window ).height() - 830;
	$("#contents").attr("contentHeight", h+"px");
</script>