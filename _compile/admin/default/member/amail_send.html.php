<?php /* Template_ 2.2.6 2022/05/30 15:17:24 /www/music_brother_firstmall_kr/admin/skin/default/member/amail_send.html 000007360 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/memberList.js?mm=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/batch.js?mm=<?php echo date('YmdHis')?>"></script>

<script type="text/javascript">
$(document).ready(function() {
	gSearchForm.init({'pageid':'member_catalog','formEditorUse':true,'searchFormEditView':true, 'fix_field':'sc_mailing','sc':<?php echo $TPL_VAR["scObj"]?>});
	memberList.init({'auth_arr':'<?php echo $TPL_VAR["auth_arr"]?>'});

	var scMailing = "<?php echo $TPL_VAR["sc"]["mailing"]?>";
	if( scMailing ) {
		$("#memberForm input[name='mailing']:[value='"+scMailing+"']").prop('checked',true);
	}
	// CHECKBOX COUNT
	parent.chkMemberCount();

	//개별 이메일 추가		
	setContentsCheckbox("add_email");

	sendMemberSum();
	searchMemberCount();
});

function amail_send_submit() {
	addNum_init();
	sendMemberSum();
	
	var no				= $("input[name='send_to']").val();
	var serialize		= $('#memberForm').serialize();
	
	// 이메일 발송 세팅을 팝업으로 띄우면서 추가 변수를 직접 넘겨줘야함
	var member			= $("input[name='member']:checked").val();
	var add_email		= $("input[name='add_email']").val();
	var send_to_list	= '';
	var add_num_chk		= $("input[name='add_num_chk']:checked").val();
	$("#sendToList .mailItem").each(function(e, data) {
		send_to_list += ","+String($(this).attr("value"));
	});
	var send_count		= $("input[name='member']:checked").attr('count');
	
	var addserialize	= 'member=' + member + '&add_email=' + add_email + '&send_to_list=' + send_to_list + '&add_num_chk=' + add_num_chk+'&send_count='+send_count;

	

	$.get('../member_process/amail_send_set?no='+no+"&"+serialize+'&'+addserialize, function(response) {
		var data = eval(response)[0];
		//debug(response);
		if(data.result == true) {
			alert(data.msg);
			var email_url = "https://partners.postman.co.kr/home/login_partner.jsp?user_id=<?php echo $TPL_VAR["mass"]["cid"]?>&user_no=*************&user_nm=<?php echo $TPL_VAR["mass"]["name"]?>&user_email=<?php echo $TPL_VAR["mass"]["email"]?>&user_tel=<?php echo $TPL_VAR["mass"]["phone"]?>&user_cell=<?php echo $TPL_VAR["mass"]["cellphone"]?>&user_domain=<?php echo $TPL_VAR["mass"]["server_name"]?>&cooperation_id=GA&target_cd=G002&target_nm=001&vertify_cd=<?php echo $TPL_VAR["mass"]["vertify_cd"]?>";
			window.open(email_url, '_blank');
		} else {
			alert(data.msg);
		}
	});
}
</script>

<style>
	#sendToList {height:100px; overflow-y:auto; overflow-x:hidden;}
	.footer.search_btn_lay button{width: auto;background-color: white; border: 1px solid gray; height: 30px;}
	.footer.search_btn_lay button span{color: #959595;}
	/*.resp_btn.active{color: #3090d6; border: 1px solid rgb(48, 144, 214) !important;}*/
	.search_btn_lay .sc_edit{position: relative;}
	.search_btn_lay .detail, .search_btn_lay .default{position: relative;}
	.resp_btn.size_XL{line-height: inherit;}
	.contents_container{width: 1400px; margin: auto;}
	.table_search{width: 1400px !important;}
	.footer.search_btn_lay{top: auto; left: calc(50% - 50px) !important;}
</style>




<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>이메일 대량 발송</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button type="button" class="btnSendEmail resp_btn active2 size_L">이메일 대량 발송</button></li>
		</ul>
	</div>
</div>
<div id="search_container">
<form name="memberForm" id="memberForm"  action="../member/amail_send">
<input type="hidden" name="search" id="hidden_search" />
<input type="hidden" name="send_to"/>
<input type="hidden" name="send_num"/>
<input type="hidden" name="member_seq" />
<input type="hidden" name="orderby" value="<?php echo $TPL_VAR["sc"]["orderby"]?>"/>
<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sc"]["sort"]?>"/>
<input type="hidden" name="selectMember" value="">
<input type="hidden" name="searchcount" value="<?php echo $TPL_VAR["sc"]["searchcount"]?>"/>
<input type="hidden" name="type" />
<input type="hidden" name="perpage"  id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" />

<div class="contents_container">	
	<ul class="tab_01 v2 tabEvent">
		<li><a href='amail'>대량 발송 설정</a></li>
		<li><a href='amail_send' class="current">이메일 대량 발송</a></li>
	</ul>	
</div>

<div class="search_container">
<?php $this->print_("member_search",$TPL_SCP,1);?>

</div>

<div class="contents_container">	
<?php $this->print_("member_list",$TPL_SCP,1);?>

	<!-- 페이징 -->
	<div class="paging_navigation center"><?php echo $TPL_VAR["pagin"]?></div>
</div>

<div id="email_popup" class="hide">
	<div class="item-title">수신 대상 회원</div>
	<!-- ### RECEIVE USER FORM -->
	<table class="table_basic thl">		
		<tr>
			<th>회원 선택</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="member" value="all" count="<?php echo $TPL_VAR["mInfo"]["total"]?>" checked/>전체 (<sapn id="all_member"><?php echo $TPL_VAR["mInfo"]["total"]?></sapn>명)</label>
					<label><input type="radio" name="member" value="select" count="0"/>선택 회원 (<span id="selected_member">0</span>명)</label>
					<label><input type="radio" name="member" value="search" count="0"/>검색 회원 (<span id="search_member">0</span>명)</label>					
				</div>
			</td>
		</tr>
		<tr>
			<th>개별 이메일 추가</th>
			<td>			
				<label class="resp_checkbox"><input type="checkbox" name="add_email" value="1" class=""/> 개별 이메일 추가</label>					
			</td>
		</tr>
		<tr class="add_email_contents hide">
			<th>이메일 추가</th>
			<td>
				<div>
					<input type="text" name="send_to_add" size="50">
					<button type="button" id="send_to_add_btn" class="btn_plus"></button>
				</div>				
				<div id="sendToList" class="wx300 box_style_02 mt5 hide"></div>				
				<label class="resp_checkbox"><input type="checkbox" name="add_num_chk" value="Y"> 추가 이메일만 보냄</label>				
			</td>
		</tr>		
	</table>

	<div class="resp_message">
		- 이메일 정보가 없는 회원 또는 이메일 수신 동의를 하지 않은 회원에게는 이메일이 발송되지 않습니다. 
	</div>
	
	<div class="footer">
		<button type="button" id="amail_send_submit" class="resp_btn active size_XL">발송</button>
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialog('email_popup')">취소</button>
	</div>
</div>

</form>
</div>
<iframe id="emailForm" frameborder="0" style="display:none;" ></iframe>

<div id="excel_popup" class="hide"></div>

<div id="amail_chk" class="hide" style="text-align:center;">
	<table width="100%" cellspacing="0">
	<tr><td>
		이메일 대량발송 설정을 등록해 주세요.
	</td></tr>
	</table>
	<span class="btn small gray center"><button type="button" onclick="location.href='amail';">확인</button></span>
</div>



<?php $this->print_("member_download_info",$TPL_SCP,1);?>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>