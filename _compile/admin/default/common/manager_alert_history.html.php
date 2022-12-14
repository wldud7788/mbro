<?php /* Template_ 2.2.6 2021/12/30 15:59:46 /www/music_brother_firstmall_kr/admin/skin/default/common/manager_alert_history.html 000006650 */ ?>
<style>
.manager_alert_history_pager {margin-top:5px;}
.manager_alert_history_pager .pages {text-align:center;}
.manager_alert_history_pager .pages span {display:inline-block; padding:3px; font-size:13px; color:#666; cursor:pointer;}
.manager_alert_history_pager .pages span.first {width:10px; padding:5px 0 3px 0; background:url("/admin/skin/default/images/main/btn_memo_prev.gif") repeat-x 0px center;}
.manager_alert_history_pager .pages span.prev {padding-top:5px; padding-right:12px; background:url("/admin/skin/default/images/main/btn_memo_prev.gif") no-repeat center center;}
.manager_alert_history_pager .pages span.next {padding-top:5px; padding-left:12px; background:url("/admin/skin/default/images/main/btn_memo_next.gif") no-repeat center center;}
.manager_alert_history_pager .pages span.last {width:10px; padding:5px 0 3px 0; background:url("/admin/skin/default/images/main/btn_memo_next.gif") repeat-x 0px center;}
.manager_alert_history_pager .pages span.pgCurrent {font-weight:bold;}

/* 2021.12.30 11월 3차 패치 시작 by 김혜진 */
.content_mah .search_container {padding:0 !important;}

</style>
<script type="text/javascript" src="/app/javascript/plugin/jquery_pagination/jquery.pager.js" charset="utf8"></script>
<script type="text/javascript" src="/app/javascript/js/admin-common-ui.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('YmdHis')?>"></script>
<script>

	var search_opitons = {
		'pageid':'manager_alert_history',
		'search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>',
		'defaultPage':1,
		'divSelectLayId':'history_search_container',
		'searchFormId':'historySearch',
		'form_editor_use':false,
		'select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>',
	};

$(function(){
	gSearchForm.init(search_opitons);

	apply_input_style();

	gSearchForm.init(search_opitons);
		ajax_call_alert_history(1);
		return false;
	});
	ajax_call_alert_history(1);

	addSelectDateEvent();

	
});

function ajax_call_alert_history(page){
	var frm = $("form[name='alert_history_form']");

	if($("input[name='keyword']",frm).val() == $("input[name='keyword']",frm).attr('title')){
		$("input[name='keyword']",frm).val('');
	}

	$.ajax({
		'url' : '/admin/common/manager_alert_history_ajax_lsit',
		'type' : 'post',
		'data' : {'page':page,'keyword':$("input[name='keyword']",frm).val(),'sdate':$("input[name='sdate']",frm).val(),'edate':$("input[name='edate']",frm).val()},
		'dataType' : 'json',
		'success' : function(result){
			var html = "";

			$(".mah_search_cnt").html(comma(result.record.length));
			$(".mah_now_page").html(comma(result.page.nowpage));
			$(".mah_total_page").html(comma(result.page.totalpage));

			for(var i=0;i<result.record.length;i++){
				html += "<tr>";
				html += "<td class='its-td-align center'>"+result.record[i].regist_date+"</td>";
				html += "<td class='its-td-align center'>"+result.record[i].mname+"("+result.record[i].manager_id+")</td>";
				html += "<td class='its-td-align center'>"+result.record[i].ip+"</td>";
				html += "<td class='its-td-align left pdl5'>"+result.record[i].action_message+"</td>";
				html += "</tr>";
			}

			$(".alert_history_table tbody").empty().append(html);

			$(".manager_alert_history_pager").show().pager({pagenumber: result.page.nowpage, pagecount: result.page.totalpage, buttonClickCallback:function(clicked_page){
				ajax_call_alert_history(clicked_page);
			}});
		}
	});
	
}
</script>

<div class="content content_mah">

	<div id="history_search_container" class="search_container">
		<form id="historySearch" name="alert_history_form" class='search_form' >
			<table class="table_search">
			<tr>
				<th>검색어</th>
				<td>			
					<input type="text" name="keyword" value="<?php echo $_GET["keyword"]?>" title="관리아이디" size="80"/>
				</td>
			</tr>
			<tr>
				<th>행위일시</th>
				<td>
					<div class="date_range_form">
					<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10" style="width:80px" />
					-
					<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10" style="width:80px" />

						<span class="resp_btn_wrap">
						<input type="button" range="today" value="오늘" class="select_date resp_btn"/>
						<input type="button" range="3day" value="3일간" class="select_date resp_btn"/>
						<input type="button" range="1week" value="일주일" class="select_date resp_btn"/>
						<input type="button" range="1month" value="1개월" class="select_date resp_btn"/>
						<input type="button" range="3month" value="3개월" class="select_date resp_btn"/>
						<input type="button" range="all"  value="전체" class="select_date resp_btn"/>
						<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden">
						</span>
				</div>
				</td>
			</tr>
		</table>
			<div class="search_btn_lay"></div>
		</form>
	</div>

	<div class="list_info_container">
		<div class="dvs_left">	
			검색 <span class="mah_search_cnt bold"></span>개 (현재 <span class="mah_now_page bold"></span> 페이지)
		</div>
	</div>


	<table class="alert_history_table table_row_basic" width="100%">
		<col width="170" />
		<col width="150" />
		<col width="140" />
		<col />
		<thead>
			<tr>
				<th>행위일시</th>
				<th>행위자</th>
				<th>IP</th>
				<th>내용</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>

	<div class="manager_alert_history_pager center pdt10"></div>

	<div class="box_style_05 mt10">
		<div class="title">안내</div>
		<ul class="resp_message bullet_hyphen">
			<li>중요한 행위 발생 시 대표관리자에게 알려 드립니다.</li>
			<li>중요행위 알림창을 통해 7일동안 표시(7일 경과 시 자동 미노출)</li>
			<li>중요행위로그는 대표 관리자 계정정보에서 계속 확인 가능 <a href="../setting/manager_reg?manager_seq=<?php echo $TPL_VAR["managerInfo"]["manager_seq"]?>" class="resp_btn_txt">바로가기</a></li>
		</ul>
	</div>

</div>

<div class="footer footer_mah">
	<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
</div>
<!-- 2021.12.30 11월 3차 패치 끝 by 김혜진 -->