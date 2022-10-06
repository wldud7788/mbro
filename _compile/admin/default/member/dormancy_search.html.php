<?php /* Template_ 2.2.6 2022/05/17 12:36:26 /www/music_brother_firstmall_kr/admin/skin/default/member/dormancy_search.html 000007992 */ ?>
<script src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js"></script>
<script type="text/javascript">
	$(function(){
		gSearchForm.init({'pageid':'dormancy_catalog','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>'});
	})
	//기본검색설정
	var default_search_pageid	= "dormancy_catalog";
	var default_obj_width		= 750;
	var default_obj_height		= 230;

	// SEARCH FOLDER
	function showSearch(){
		if($("#member_search_form").css('display')=='none'){
			$("#member_search_form").show();
			$.cookie("member_list_folder", "folded");
		}else{
			$("#member_search_form").hide();
			$.cookie("member_list_folder", "unfolded");
		}
	}

	// POP SETTING FORM
	function settingForm(){
		var set_value = $('#setForm').serialize();
		if(set_value) $.cookie("member_list_search", set_value);
		closeDialog("setPopup");
		location.reload();
	}

	function set_date(target, start,end){
		var starget	= target + '_sdate';
		var etarget	= target + '_edate';
		if	(target == 'anniversary'){
			$("select[name='" + starget + "[]']").eq(0).val(start.substr(5,2));
			$("select[name='" + starget + "[]']").eq(1).val(start.substr(8,2));
			$("select[name='" + etarget + "[]']").eq(0).val(end.substr(5,2));
			$("select[name='" + etarget + "[]']").eq(1).val(end.substr(8,2));
		}else{
			$("input[name='" + starget + "']").val(start);
			$("input[name='" + etarget + "']").val(end);
		}
	}

	// MEMBER DETAIL
	function viewDetail(seq){
		//if(!$(obj).attr('member_seq')) return;
		//location.href = "detail?member_seq="+$(obj).attr('member_seq');

		$("input[name='member_seq']").val(seq);
		$("form[name='memberForm']").attr('action','detail');
		$("form[name='memberForm']").submit();
	}

	// CHECKBOX COUNT - IFRAME CONTROLLER
	function chkMemberCount(){
		var cnt = $("input:checkbox[name='member_chk[]']:checked").length;
		$("#container").contents().find("#selected_member").html(cnt);
<?php if($TPL_VAR["amail"]!='Y'){?>
			$("#container")[0].contentWindow.sendMemberSum();
<?php }else{?>
			$("#selected_member").html(cnt);
			sendMemberSum();
<?php }?>
	}

	function searchMemberCount(){
		var cnt = $("input[name='searchcount']").val();
		$("#container").contents().find("#search_member").html(cnt);
<?php if($TPL_VAR["amail"]!='Y'){?>
			$("#container")[0].contentWindow.sendMemberSum();
<?php }else{?>
			$("#search_member").html(cnt);
			sendMemberSum();
<?php }?>
	}

	function chkAll(chk, name){
		if(chk.checked){
			$("."+name).attr("checked",true).change();
		}else{
			$("."+name).attr("checked",false).change();
		}
<?php if(preg_match('/member\/amail_send/',$_SERVER["REQUEST_URI"])){?>
		// CHECKBOX COUNT
		parent.chkMemberCount();
<?php }?>

	}

	function select_email(seq){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
		if(!seq) return;
		/*
		$("input[name='member_chk[]'][value='"+seq+"']").attr('checked',true);
		$("input[name='type']").val('select');
		emailFormOpen();
		*/
		$.get('email_pop?member_seq='+seq, function(data) {
			$('#sendPopup').html(data);
			openDialog("EMAIL 발송", "sendPopup", {"width":"600","height":"700"});
		});
	}

	function select_sms(seq){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
		if(!seq) return;
		/*
		$("input[name='member_chk[]'][value='"+seq+"']").attr('checked',true);
		$("input[name='type']").val('select');
		$("#container").css("height","0px");
		$("#container").attr("src","sms_form");
		$("#container").show();
		*/
		$.get('sms_pop?member_seq='+seq, function(data) {
			$('#sendPopup').html(data);
			openDialog("SMS 발송", "sendPopup", {"width":"600","height":"200"});
		});
	}

	function emoney_pop(seq){
		if(!seq) return;
		$.get('emoney_detail?member_seq='+seq, function(data) {
			$('#emoneyPopup').html(data);
			openDialog("캐시 내역/지급 <span class='desc'>해당 회원의 캐시 내역 및 수동 지급/차감을 하실 수 있습니다.</span>", "emoneyPopup", {"width":"800","height":"700"});
		});
	}

	function point_pop(seq){
		if(!seq) return;
		$.get('point_detail?member_seq='+seq, function(data) {
			$('#emoneyPopup').html(data);
			openDialog("포인트 내역/지급 <span class='desc'>해당 회원의 포인트 내역 및 수동 지급/차감을 하실 수 있습니다.</span>", "emoneyPopup", {"width":"800","height":"700"});
		});
	}
	function cash_pop(seq){
		if(!seq) return;
		$.get('cash_detail?member_seq='+seq, function(data) {
			$('#emoneyPopup').html(data);
			openDialog("예치금 내역/지급 <span class='desc'>해당 회원의 예치금 내역.</span>", "emoneyPopup", {"width":"800","height":"700"});
		});
	}

	function chgAnniversaryOption(type, standard, target){
		if	(type == 's'){
			if	($("select[name='anniversary_sdate[]']").eq(standard).val()){
				if	(!$("select[name='anniversary_sdate[]']").eq(target).val())
					$("select[name='anniversary_sdate[]']").eq(target).val('01');
			}else{
				if	($("select[name='anniversary_sdate[]']").eq(target).val())
					$("select[name='anniversary_sdate[]']").eq(target).val('');
			}
		}else{
			if	($("select[name='anniversary_edate[]']").eq(standard).val()){
				if	(!$("select[name='anniversary_edate[]']").eq(target).val())
					$("select[name='anniversary_edate[]']").eq(target).val('01');
			}else{
				if	($("select[name='anniversary_edate[]']").eq(target).val())
					$("select[name='anniversary_edate[]']").eq(target).val('');
			}
		}
	}
</script>

<div id="search_container"  class="search_container">
	<table class="table_search">
		<tr>
			<th>아이디</th>
			<td>				
				<input type="text" name="keyword" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" size="80"/>
			</td>
		</tr>

		<tr>
			<th>휴면일</th>
			<td>
				<div class="sc_day_date date_range_form">
					<input type="text" name="regist_sdate" value="<?php echo $TPL_VAR["sc"]["regist_sdate"]?>"  class="datepicker line sdate"  maxlength="10" size="12" default_none/>
					-
					<input type="text" name="regist_edate" value="<?php echo $TPL_VAR["sc"]["regist_edate"]?>"  class="datepicker line edate" maxlength="10" size="12" default_none />
					<div class="resp_btn_wrap">
						<input type="button" value="오늘" range="today" class="select_date resp_btn" settarget="regist" />
						<input type="button" value="3일간" range="3day" class="select_date resp_btn" settarget="regist" />
						<input type="button" value="일주일" range="1week" class="select_date resp_btn" settarget="regist" />
						<input type="button" value="1개월" range="1month" class="select_date resp_btn" settarget="regist" />
						<input type="button" value="3개월" range="3month" class="select_date resp_btn" settarget="regist" />
						<input type="button" value="전체" range="all" class="select_date resp_btn" settarget="regist" row_bunch />
						<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden">
					</div>
				</div>
			</td>
		</tr>

		<tr>
			<th>구분</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="status" value="all" <?php if($_GET["status"]=='all'||$_GET["status"]==''){?>checked<?php }?> /> 전체</label>
					<label><input type="radio" name="status" value="on" <?php if($_GET["status"]=='on'){?>checked<?php }?> /> 휴면</label>
					<label><input type="radio" name="status" value="off" <?php if($_GET["status"]=='off'){?>checked<?php }?> /> 휴면 해제</label>
				</div>
			</td>
		</tr>
	</table>	

	<div class="footer search_btn_lay"></div>
</div>
<div id="setPopup" class="hide"></div>