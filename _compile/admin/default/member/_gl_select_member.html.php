<?php /* Template_ 2.2.6 2021/12/30 16:52:11 /www/music_brother_firstmall_kr/admin/skin/default/member/_gl_select_member.html 000011928 */ 
$TPL_searchfield_1=empty($TPL_VAR["searchfield"])||!is_array($TPL_VAR["searchfield"])?0:count($TPL_VAR["searchfield"]);
$TPL_group_arr_1=empty($TPL_VAR["group_arr"])||!is_array($TPL_VAR["group_arr"])?0:count($TPL_VAR["group_arr"]);?>
<!--<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="utf8"></script>-->
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery_pagination/jquery.pager.js" charset="utf8"></script>
<script type="text/javascript">

var search_opitons = {
					'pageid':'gl_select_member',
					'search_mode':'<?php echo $TPL_VAR["sc"]["searchmode"]?>',
					'defaultPage':1,
					'divSelectLayId':'member_search_container',
					'searchFormId':'downloadsearch',
					'form_editor_use':false,
					'select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>',
					};

$(function() {

	var issued_type 		= '<?php echo $TPL_VAR["sc"]["issued_type"]?>';
	var download_member_url	= '';

	switch(issued_type){
		case 'coupon':
			download_member_url = '/admin/coupon/download_member_list';
		break;
		case 'promotion':
			download_member_url = '/admin/promotion/download_member_list';
		break;
		default:
			alert('잘못된 접근입니다');
			closeDialog('<?php echo $TPL_VAR["sc"]["divSelectLay"]?>');
			return false;
		break;
	}

	/**
	 * 페이징 클릭시 페이지를 로딩한다.
	 * @param int page 페이지번호
	 */
	var pageClick = function(destPage) {
		getAjaxList(destPage);
	}
	
	/**
	 * 상품을 ajax로 검색한다.
	 * @param int page 페이지번호
	 */

	var getAjaxList = function(page) {

		var pageNumber	= page ? page : 1;

		$("#getpage").val(pageNumber);

		var queryString = $('#member_search_container #downloadsearch').formSerialize();
		var perpage		= 10;

		$.ajax({
			type	: 'post',
			url		: download_member_url,
			data	: queryString + '&perpage=' + perpage,
			dataType: 'json',
			success	: function(data) {
				$("#" + search_opitons.divSelectLayId + " #memberAjaxTable").html(data.content);
				$("#" + search_opitons.divSelectLayId + " #searchcount").html(setComma(data.searchcount));
				$("#" + search_opitons.divSelectLayId + " #totalcount").html(setComma(data.totalcount));
				$("#" + search_opitons.divSelectLayId + " #total_page").html(setComma(data.total_page));
				$("#" + search_opitons.divSelectLayId + " #pager").pager({ pagenumber: data.nowpage, pagecount: data.pagecount, buttonClickCallback: pageClick });
				$("#" + search_opitons.divSelectLayId + " #member_total_count").val(data.searchcount); //전체 검색 회원 추가 kmj 
				memberselect();
			}
		});
	}

	addSelectDateEvent();
	gSearchForm.init(search_opitons,getAjaxList);
	getAjaxList();

});

//선택된회원정보와 리스트상의 회원정보 체크하여 구분(td 색상다름)
function memberselect(){

	var target_member	= $("#target_member").val();
	var memberList		= target_member.split('|');
	var newcheckedId	= $("#" + search_opitons.divSelectLayId + " input:checkbox[name$='member_chk[]']");

	newcheckedId.each(function() {
		if($.inArray($(this).val(),memberList) >= 0){
			$(this).attr("checked","checked");
			$(this).closest('tr').addClass('bg-gray');
		}
	});
}

function chkAll(chk){
	if(chk.checked){
		$("input:checkbox[name$='member_chk[]']").attr("checked","checked");
		$("input:checkbox[name$='member_chk[]']").closest('tr').addClass('bg-gray');
	}else{
		$("input:checkbox[name$='member_chk[]']").attr("checked",false);
		$("input:checkbox[name$='member_chk[]']").closest('tr').removeClass('bg-gray');
	}
}

function chkmember(chk){

	if(chk.checked){

		$(chk).closest('tr').addClass('bg-gray');

	}else{

		var struser		= $(chk).attr("user_name")+'[' + $(chk).attr("userid") + '] , ';
		var strseq		=  '|' + $(chk).val();//
		var oldstruser	= '';
		var oldstrseq	= '';

		oldstruser	= $("#target_container").html().replace(struser,'');
		oldstrseq	= $("#target_member").val().replace(strseq,'');

		$("#target_container").html(oldstruser);
		$("#target_member").val(oldstrseq);

		var target_member	= $("#target_member").val();
		var newcheckedId	= target_member.split('|');

		var newidx = 0;
		$.each(newcheckedId,function(k,v){
			if(v != "" && v != null) newidx++;
		});
		if(newidx < 0) {
			$("#member_search_count").html(0);
		}else{
			$("#member_search_count").html(newidx);
		}
		$(chk).closest('tr').removeClass('bg-gray');
	}
}
</script>
<div id="member_search_container" class="content">
	<div class="search_container">
	<form name="downloadsearch" id="downloadsearch"  method="post" onsubmit="return false">
	<input type="hidden"	name="no" value="<?php echo $TPL_VAR["sc"]["issued_seq"]?>" cannotBeReset=1 />
	<input type="hidden"	name="page" id="getpage" value="<?php echo $TPL_VAR["sc"]["page"]?>" />
	<input type="hidden"	name="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" />
	<input type="hidden"	name="issued_type" value="<?php echo $TPL_VAR["sc"]["issued_type"]?>"  cannotBeReset=1 />
	<input type="hidden"	name="orderby" id="orderby" value="<?php echo $TPL_VAR["sc"]["orderby"]?>"  cannotBeReset=1 />
	<!-- 주문리스트 검색폼 : 시작 -->
		<table class="table_search">
		<tr>
			<th>검색어</th>
			<td colspan="3">
				<select name="search_field" class="resp_select">
<?php if($TPL_searchfield_1){foreach($TPL_VAR["searchfield"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>" <?php if($TPL_VAR["sc"]["search_field"]==$TPL_K1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
				<input type="text" name="search_text" id="download_search_text" value="<?php echo $TPL_VAR["sc"]["search_text"]?>" class="resp_text wx500" />
			</td>
		</tr>
		<tr>
			<th>날짜</th>
			<td colspan="3">
				<div class="sc_day_date date_range_form">
					<select name="date_gb" class="resp_select">
						<option value="regist_date" <?php if($TPL_VAR["sc"]["date_gb"]=="regist_date"){?>selected<?php }?> >가입일</option>
						<option value="lastlogin_date" <?php if($TPL_VAR["sc"]["date_gb"]=="lastlogin_date"){?>selected<?php }?> >최종로그인</option>
					</select>					
					<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>"  class="datepicker line sdate"  maxlength="10" size="12" default_none/>
					-
					<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>"  class="datepicker line edate" maxlength="10" size="12" default_none />
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
			<th>SMS 수신</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="sms" value=""  <?php if(!$TPL_VAR["sc"]["sms"]){?>checked<?php }?> /> 전체</label>
					<label><input type="radio" name="sms" value="y" <?php if($TPL_VAR["sc"]["sms"]=="y"){?>checked<?php }?> /> 동의</label>
					<label><input type="radio" name="sms" value="n" <?php if($TPL_VAR["sc"]["sms"]=="n"){?>checked<?php }?> /> 거부</label>
				</div>
			</td>
			<th>이메일 수신</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="mailing" value="" <?php if(!$TPL_VAR["sc"]["mailing"]){?>checked<?php }?> /> 전체</label>
					<label><input type="radio" name="mailing" value="y" <?php if($TPL_VAR["sc"]["mailing"]=="y"){?>checked<?php }?> /> 동의</label>
					<label><input type="radio" name="mailing" value="n" <?php if($TPL_VAR["sc"]["mailing"]=="n"){?>checked<?php }?> /> 거부</label>
				</div>
			</td>
		</tr>
		<tr>
			<th>등급</th>
			<td>
				<select name="grade" class="resp_select">
					<option value="">전체</option>
<?php if($TPL_group_arr_1){foreach($TPL_VAR["group_arr"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["group_seq"]?>" <?php if($TPL_VAR["sc"]["grade"]==$TPL_V1["group_seq"]){?>selected<?php }?>><?php echo $TPL_V1["group_name"]?></option>
<?php }}?>
				</select>
			</td>
			<th>구매금액</th>
			<td>
				<input type="text" name="sorder_sum" value="<?php echo $TPL_VAR["sc"]["sorder_sum"]?>" class="resp_text onlynumber" size="7"/> ~ <input type="text" name="eorder_sum" value="<?php echo $TPL_VAR["sc"]["eorder_sum"]?>" class="resp_text onlynumber" size="7"/>
			</td>
		</tr>
		<tr>
			<th>캐시액</th>
			<td>
				<input type="text" name="semoney" value="<?php echo $TPL_VAR["sc"]["semoney"]?>" class="resp_text onlynumber" size="7"/> ~ <input type="text" name="eemoney" value="<?php echo $TPL_VAR["sc"]["eemoney"]?>" class="onlu" size="7"/>
			</td>
			<th>주문횟수</th>
			<td>
				<input type="text" name="sorder_cnt" value="<?php echo $TPL_VAR["sc"]["sorder_cnt"]?>" class="resp_text onlynumber" size="5"/> ~ <input type="text" name="eorder_cnt" value="<?php echo $TPL_VAR["sc"]["eorder_cnt"]?>" class="resp_text onlynumber" size="5"/>
			</td>
		</tr>
		<tr>
			<th>리뷰횟수</th>
			<td>
				<input type="text" name="sreview_cnt" value="<?php echo $TPL_VAR["sc"]["sreview_cnt"]?>" class="resp_text onlynumber" size="5"/> ~ <input type="text" name="ereview_cnt" value="<?php echo $TPL_VAR["sc"]["ereview_cnt"]?>" class=" onlynumber" size="5"/>
			</td>
			<th>방문횟수</th>
			<td>
				<input type="text" name="slogin_cnt" value="<?php echo $TPL_VAR["sc"]["slogin_cnt"]?>" class="resp_text onlynumber" size="5"/> ~ <input type="text" name="elogin_cnt" value="<?php echo $TPL_VAR["sc"]["elogin_cnt"]?>" class="resp_text onlynumber" size="5"/>
			</td>
		</tr>
		</table>

		<div class="footer search_btn_lay"></div>
	</form>
	</div>
	<div class="cboth"></div>
	<!-- 주문리스트 검색폼 : 끝 -->

	<ul class="left-btns clearbox">
		<li class="left">
			<div style="margin-top:rpx;">
				검색 <span id="searchcount"><?php echo $TPL_VAR["sc"]["searchcount"]?></span>개 
				(총 <span id="totalcount"><?php echo $TPL_VAR["sc"]["totalcount"]?></span>개)
			</div>
		</li>
	</ul>
	<div class="clearbox"></div>


	<!-- 주문리스트 테이블 : 시작 -->
	<table class="table_basic tdc">
	<colgroup>
		<col width="5%" />
		<col width="8%" />
		<col width="10%" />
		<col width="15%" />
		<col width="10%" />
		<col width="20%" />
		<col width="20%" />
		<col width="12%" />
	</colgroup>
		<thead>
		<tr>
			<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" title="전체선택"></label></th>
			<th>번호</th>
			<th>유형</th>
			<th>아이디</th>
			<th>이름</th>
			<th>이메일 (수신)</th>
			<th>핸드폰 (수신)</th>
			<th>전화번호</th>
		</tr>
		</thead>
		<tbody id="memberAjaxTable">
		</tbody>
	</table>
	<!-- 주문리스트 테이블 : 끝 -->

	<!-- 페이징 -->
	<div id="pager" class="paging_navigation center"></div>

</div>


<div class="footer" >	
	<button type="button" class="confirmSelectMember resp_btn active size_XL">선택한 회원 적용</button>
	<button type="button" class="confirmSearchMember resp_btn active size_XL">검색한 회원 적용</button>
	<button type="button" class="btnLayClose resp_btn v3 size_XL">닫기</button>
</div>