<?php /* Template_ 2.2.6 2022/05/17 12:36:38 /www/music_brother_firstmall_kr/admin/skin/default/order/download_member.html 000014557 */ 
$TPL_group_arr_1=empty($TPL_VAR["group_arr"])||!is_array($TPL_VAR["group_arr"])?0:count($TPL_VAR["group_arr"]);?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="utf8"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery_pagination/jquery.pager.js" charset="utf8"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#submitbtn").click(function() {
		getAjaxList();
	});


	$("[name='select_date']").click(function() {
		switch($(this).attr("id")) {
			case 'today' :
				$("input[name='sdate']").val(getDate(0));
				$("input[name='edate']").val(getDate(0));
				break;
			case '3day' :
				$("input[name='sdate']").val(getDate(3));
				$("input[name='edate']").val(getDate(0));
				break;
			case '1week' :
				$("input[name='sdate']").val(getDate(7));
				$("input[name='edate']").val(getDate(0));
				break;
			case '1month' :
				$("input[name='sdate']").val(getDate(30));
				$("input[name='edate']").val(getDate(0));
				break;
			case '3month' :
				$("input[name='sdate']").val(getDate(90));
				$("input[name='edate']").val(getDate(0));
				break;
			default :
				$("input[name='sdate']").val('');
				$("input[name='edate']").val('');
				break;
		}
	});

	$("#download_search_text").click( function(){
		if($(this).val() == "이름, 아이디, 이메일, 전화번호, 핸드폰(뒷자리4), 주소" ){
			$(this).val('');
		}
	});


	// ###
	$("input:radio[name='sms']").val(['<?php echo $TPL_VAR["sc"]["sms"]?>']);
	$("input:radio[name='mailing']").val(['<?php echo $TPL_VAR["sc"]["mailing"]?>']);
	$("input:radio[name='business_seq']").val(['<?php echo $TPL_VAR["sc"]["business_seq"]?>']);
	$("input:radio[name='status']").val(['<?php echo $TPL_VAR["sc"]["status"]?>']);
	getAjaxList();
});


//중복체크
function memberselectck(newmbseq){
	var returns = false;
	var target_member = $("#target_member").val();
	var newcheckedId = target_member.split(',');
	var idx = (newcheckedId.length-1);
	if(idx>0) {
		for(i=0;i<idx;i++) {
			if( "["+newmbseq+"]" == newcheckedId[i]){
				returns = true;
				break;
			}
		}
	}
	return returns;
}


//선택된회원정보와 리스트상의 회원정보 체크하여 구분(td 색상다름)
function memberselectchecked(newmbseq) {
	var newcheckedId = "input:checkbox[name$='member_chk[]']";
	var newidx = ($(newcheckedId).length);
	if(newidx > 0) {
		$(newcheckedId).each(function(e, newdata) {
			if( newmbseq == "["+$(newdata).val()+"]"){
				$(this).attr("checked","checked");
				$(this).parent().parent().find('td').addClass('bg-silver');
				return false;
			}
		});
	}
}

function chkmember(chk){

	$("input[name='order_user_name']").val($(chk).attr("user_name"));

	var cellphoneArr = $(chk).attr("cellphone").split('-');
	var phoneArr = $(chk).attr("phone").split('-');
	var zipcodeArr = $(chk).attr("zipcode").split('-');
	var zipcodeNew = $(chk).attr("zipcode").replace('-','');

	if(!$(chk).attr("type")){ //기업 세금계산서 값 추가 @nsg 2016-02-05
		$("input[name='order_zipcode[]']").eq(0).val(zipcodeArr[0]);
		$("input[name='order_zipcode[]']").eq(1).val(zipcodeArr[1]);

		$("input[name='order_address_type']").val($(chk).attr("address_type"));
		$("input[name='order_address']").val($(chk).attr("address"));
		$("input[name='order_address_street']").val($(chk).attr("address_street"));
		$("input[name='order_address_detail']").val($(chk).attr("address_detail"));

	}else{
		$("input[name='co_name']").val($(chk).attr("bname"));
		$("input[name='co_ceo']").val($(chk).attr("bceo"));
		// 반대로 저장되어 업태/업종 변경
		$("input[name='co_status']").val($(chk).attr("bitem"));
		$("input[name='co_type']").val($(chk).attr("bstatus"));
		$("input[name='busi_no']").val($(chk).attr("bno"));

		$("input[name='co_address_type']").val($(chk).attr("address_type"));
		$("input[name='co_address']").val($(chk).attr("address"));
		$("input[name='co_address_street']").val($(chk).attr("address_street"));
		$("input[name='co_address_detail']").val($(chk).attr("address_detail"));

		$("input[name='co_zipcode[]']").eq(0).val(zipcodeArr[0]);
		$("input[name='co_zipcode[]']").eq(1).val(zipcodeArr[1]);
		$("input[name='co_new_zipcode']").val(zipcodeNew);
	}

	$("input[name='order_phone[]']").eq(0).val(phoneArr[0]);
	$("input[name='order_phone[]']").eq(1).val(phoneArr[1]);
	$("input[name='order_phone[]']").eq(2).val(phoneArr[2]);

	$("input[name='order_cellphone[]']").eq(0).val(cellphoneArr[0]);
	$("input[name='order_cellphone[]']").eq(1).val(cellphoneArr[1]);
	$("input[name='order_cellphone[]']").eq(2).val(cellphoneArr[2]);
	
	$("input[name='member_seq']").val($(chk).attr("seq"));

	$("input[name='order_email']").val($(chk).attr("email"));
	var user_name	= $(chk).attr("user_name");
	var user_id		= $(chk).attr("userid");
	var group_name	= $(chk).attr("group_name");

	$("#userInfo").html(user_id+" / "+group_name);
	$("#userInfo2").html(user_name+" ("+group_name+" / "+user_id+")");
	$("input[name='cellphone']").val($(chk).attr("cellphone"));

<?php if($TPL_VAR["ordertype"]=='person'){?>
	cart('person');
<?php }?>

	$('#dlg').dialog('close');

	/*
	if(chk.checked){
		$(chk).parent().parent().find('td').addClass('bg-silver');
	}else{

		var struser = $(chk).attr("user_name")+'[' + $(chk).attr("userid") + '] , ';
		var strseq  =  '[' + $(chk).val() + '],';//
		var oldstruser = '';
		oldstruser = $("#target_container").html().replace(struser,'');
		var oldstrseq = '';
		oldstrseq = $("#target_member").val().replace(strseq,'');
		$("#target_container").html(oldstruser);
		$("#target_member").val(oldstrseq);

		var target_member = $("#target_member").val();
		var newcheckedId = target_member.split(',');
		var newidx = (newcheckedId.length-1);
		if(newidx < 0) {
			$("#member_search_count").html(0);
		}else{
			$("#member_search_count").html(newidx);
		}
		$(chk).parent().parent().find('td').removeClass('bg-silver');
	}
	*/
}


/**
 * 상품을 ajax로 검색한다.
 * @param int page 페이지번호
 */
function getAjaxList(page) {
	var pageNumber = page ? page : 1;
   $("#getpage").val(pageNumber);
	var queryString = $('#downloadsearch').formSerialize();
	var perpage = 10;
	$.ajax({
		type: 'post',
		url: '/admin/order/download_member_list',
		data: queryString + '&perpage=' + perpage,
		dataType: 'json',
		success: function(data) {
			$('#ajaxTable').html(data.content);
			$('#searchcount').html(setComma(data.searchcount));
			$('#totalcount').html(setComma(data.totalcount));
			$('#nowpage').html(setComma(data.nowpage));
			$('#total_page').html(setComma(data.total_page));
			$("#pager").pager({ pagenumber: data.page, pagecount: data.pagecount, buttonClickCallback: pageClick });

		},
		error:function(data){
		},
	});
}

/**
 * 페이징 클릭시 페이지를 로딩한다.
 * @param int page 페이지번호
 */
function pageClick(page) {
	$("#getpage").val(page);
	getAjaxList(page);
}

// 엔터 검색 추가
function chkEnterSubmit(evt){
	var e	= evt || window.event;
	if	(e.keyCode == 13){
		getAjaxList('1');
	}
}
</script>

<form name="downloadsearch" id="downloadsearch"  method="post" >
<input type="hidden" name="no" value="<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>" >
<input type="hidden" name="page" id="getpage" value="<?php echo $_GET["page"]?>" >
<input type="hidden" name="orderby" id="orderby" value="<?php echo $_GET["orderby"]?>" >
<input type="hidden" name="ordertype" id="ordertype" value="<?php echo $_GET["ordertype"]?>" >
<!-- 주문리스트 검색폼 : 시작 -->
<div class="search-form-container">
	<table class="search-form-table">
	<tr>
		<td width="500">
				<table class="sf-keyword-table">
				<tr>
					<td class="sfk-td-txt" ><input type="text" name="search_text" id="download_search_text" value="<?php if($_GET["search_text"]&&$_GET["search_text"]!='이름, 아이디, 이메일, 전화번호, 핸드폰(뒷자리4), 주소'){?><?php echo $_GET["search_text"]?><?php }else{?>이름, 아이디, 이메일, 전화번호, 핸드폰(뒷자리4), 주소<?php }?>" title="이름, 아이디, 이메일, 전화번호, 핸드폰(뒷자리4), 주소" onkeyup="chkEnterSubmit(event);" /></td>
					<td class="sfk-td-btn"><button type="button" id="submitbtn"><span>검색</span></button></td>
				</tr>
				</table>
		</td>
	</tr>
	</table>
	<table class="search-form-table" id="serch_tab">
	<tr id="member_search_form" style="display:block;">
		<td>
			<table class="sf-option-table">
			<colgroup>
				<col width="80" />
				<col width="170" />
				<col width="80" />
				<col width="170" />
				<col width="80" />
				<col width="170" />
			</colgroup>
			<tr>
				<th>
					<select name="date_gb">
						<option value="regist_date">가입일</option>
						<option value="lastlogin_date">최종로그인</option>
					</select>
				</th>
				<td colspan="5">
					<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker line"  maxlength="10" size="10" />
					&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
					<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker line" maxlength="10" size="10" />
					&nbsp;&nbsp;
					<span class="btn small"><input type="button" value="오늘" id="today" name="select_date"/></span>
					<span class="btn small"><input type="button" value="3일간" id="3day" name="select_date"/></span>
					<span class="btn small"><input type="button" value="일주일" id="1week" name="select_date"/></span>
					<span class="btn small"><input type="button" value="1개월" id="1month" name="select_date"/></span>
					<span class="btn small"><input type="button" value="3개월" id="3month" name="select_date"/></span>
					<span class="btn small"><input type="button" value="전체" id="all" name="select_date"/></span>
				</td>
			</tr>
			<tr>
				<th>SMS 수신</th>
				<td>
					<label><input type="radio" name="sms" value="" checked/> 전체</label>
					<label><input type="radio" name="sms" value="y"/> 동의</label>
					<label><input type="radio" name="sms" value="n"/> 거부</label>
				</td>
				<th>이메일 수신</th>
				<td>
					<label><input type="radio" name="mailing" value="" checked/> 전체</label>
					<label><input type="radio" name="mailing" value="y"/> 동의</label>
					<label><input type="radio" name="mailing" value="n"/> 거부</label>
				</td>
				<th></th>
				<td></td>
			</tr>
			<tr>
				<th>회원유형</th>
				<td>
					<label><input type="radio" name="business_seq" value="" checked/> 전체</label>
					<label><input type="radio" name="business_seq" value="n"/> 개인</label>
					<label><input type="radio" name="business_seq" value="y"/> 기업</label>
				</td>
				<th>가입승인</th>
				<td>
<?php if($_GET["ordertype"]=='person'){?>
						<label><input type="hidden" name="status" value="done"/> 승인</label>
<?php }else{?>
					<label><input type="radio" name="status" value="" checked/> 전체</label>
					<label><input type="radio" name="status" value="done"/> 승인</label>
					<label><input type="radio" name="status" value="hold"/> 미승인</label>
<?php }?>
				</td>
				<th></th>
				<td></td>
			</tr>
			<tr>
				<th>등급</th>
				<td>
					<select name="grade" style="width:100px;">
						<option value="">전체</option>
<?php if($TPL_group_arr_1){foreach($TPL_VAR["group_arr"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["group_seq"]?>" <?php if($TPL_VAR["sc"]["grade"]==$TPL_V1["group_seq"]){?>selected<?php }?>><?php echo $TPL_V1["group_name"]?></option>
<?php }}?>
					</select>
				</td>
				<th>구매금액</th>
				<td>
					<input type="text" name="sorder_sum" value="<?php echo $TPL_VAR["sc"]["sorder_sum"]?>" class="line" size="7"/> ~ <input type="text" name="eorder_sum" value="<?php echo $TPL_VAR["sc"]["eorder_sum"]?>" class="line" size="7"/>
				</td>
				<th>캐시액</th>
				<td>
					<input type="text" name="semoney" value="<?php echo $TPL_VAR["sc"]["semoney"]?>" class="line" size="7"/> ~ <input type="text" name="eemoney" value="<?php echo $TPL_VAR["sc"]["eemoney"]?>" class="line" size="7"/>
				</td>
			</tr>
			<tr>
				<th>주문횟수</th>
				<td>
					<input type="text" name="sorder_cnt" value="<?php echo $TPL_VAR["sc"]["sorder_cnt"]?>" class="line" size="5"/> ~ <input type="text" name="eorder_cnt" value="<?php echo $TPL_VAR["sc"]["eorder_cnt"]?>" class="line" size="5"/>
				</td>
				<th>리뷰횟수</th>
				<td>
					<input type="text" name="sreview_cnt" value="<?php echo $TPL_VAR["sc"]["sreview_cnt"]?>" class="line" size="5"/> ~ <input type="text" name="ereview_cnt" value="<?php echo $TPL_VAR["sc"]["ereview_cnt"]?>" class="line" size="5"/>
				</td>
				<th>방문횟수</th>
				<td>
					<input type="text" name="slogin_cnt" value="<?php echo $TPL_VAR["sc"]["slogin_cnt"]?>" class="line" size="5"/> ~ <input type="text" name="elogin_cnt" value="<?php echo $TPL_VAR["sc"]["elogin_cnt"]?>" class="line" size="5"/>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>
<!-- 주문리스트 검색폼 : 끝 -->
</form>
<ul class="left-btns clearbox">
	<li class="left"><div style="margin-top:rpx;">검색 <span id="searchcount" style="color:#000000; font-size:11px; font-weight: bold"><?php echo $TPL_VAR["sc"]["searchcount"]?></span>/총 <span id="totalcount" style="color:#000000; font-size:11px; font-weight: bold"><?php echo $TPL_VAR["sc"]["totalcount"]?></span>개(현재 <span id="nowpage" ></span>/총 <span id="total_page" ><?php echo $TPL_VAR["sc"]["total_page"]?></span>페이지)</div></li>
</ul>
<div class="clearbox"></div>

<!-- 주문리스트 테이블 : 시작 -->
<div >
	<table class="info-table-style" style="width:100%">
		<thead>
		<tr>
			<th class="its-th-align center">선택</th>
			<th class="its-th-align center">번호</th>
			<th class="its-th-align center">유형</th>
			<th class="its-th-align center">아이디</th>
			<th class="its-th-align center">이름</th>
			<th class="its-th-align center">이메일 (수신)</th>
			<th class="its-th-align center">핸드폰 (수신)</th>
			<th class="its-th-align center">전화번호</th>
		</tr>
		</thead>
		<tbody id="ajaxTable"></tbody>
	</table>
</div>
<!-- 주문리스트 테이블 : 끝 -->

<!-- 서브 레이아웃 영역 : 끝 -->

<!-- 페이징 -->
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td align="center" ><div id="pager" style='clear: both'></div></td>
</tr>
</table>