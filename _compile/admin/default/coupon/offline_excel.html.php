<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/coupon/offline_excel.html 000003392 */ ?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="utf8"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery_pagination/jquery.pager.js" charset="utf8"></script>
<script type="text/javascript">
var remainsec = parseInt("<?php echo ($TPL_VAR["saveinterval"]+ 1)?>");
$(document).ready(function() {
	getAjaxOfflineList();
	refresh();
});

function refresh()
{
	remainsec--;
	if (remainsec == 0)
	{
		var nextpage		= $('#nextpage').val();

		if(parseInt(nextpage) > 0) {
			getAjaxOfflineList(nextpage);
			remainsec= parseInt("<?php echo ($TPL_VAR["saveinterval"]+ 1)?>");
			refresh();
		}else{
			clearTimeout(timerid);
			$("#totalpagelayer").hide();
			$("#offlinelayfinish").show();
			//$("#totalcountlay").html(" 총 "+ setComma(data.totalcount) +" 건 ");
		}
		return false;
	}
	$('#sec_layer').html(remainsec);
	timerid = setTimeout("refresh()" , '<?php echo $TPL_VAR["saveinterval"]?>000');
}

/**
 * 상품을 ajax로 검색한다.
 * @param int page 페이지번호
 */
function getAjaxOfflineList(page) {
	var pageNumber = page ? page : 2;
   $("#getpage").val(pageNumber);
	var queryString = $('#offlinesearch').formSerialize();
	$.ajax({
		type: 'post',
		url: '/admin/coupon_process/offline_excel_save',
		data: queryString,
		dataType: 'json',
		success: function(data) {
			$('#ajaxTable').html(data.content);
			$('#totalcount').html(setComma(data.totalcount));
			$('#nowpage').html(setComma(data.nowpage));
			$('#nextpage').val(data.nextpage);
			$('#realtotalcount').val(data.totalcount);
			$('#total_page').html(setComma(data.total_page));
			if(data.nextpage > 0 ) {
				$("#totalpagelayer").show();
				$("#offlinelayfinish").hide();
			}else{
				clearTimeout(timerid);
				$("#totalpagelayer").hide();
				$("#offlinelayfinish").show();
				//$("#totalcountlay").html(" 총 "+ setComma(data.totalcount) +" 건 ");
			}
		}
	});
}
</script>

<form name="offlinesearch" id="offlinesearch"  method="post" >
<input type="hidden" name="no" value="<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>" >
<input type="hidden" name="file_name" id="file_name" value="<?php echo $_GET["filename"]?>" >
<input type="hidden" name="page" id="getpage" value="2" >
<input type="hidden" name="nextpage" id="nextpage" value="0" >
<input type="hidden" name="saveinterval" value="<?php echo $TPL_VAR["saveinterval"]?>">
<div id="totalpagelayer" class="hide2" >
	<div class="red bold">서버부하 방지를 위해 <span id='sec_layer'></span>초간 대기중입니다..</div>
	<div class="blue bold">창을 닫으면 일괄등록이 중단됩니다..</div>
</div>

<div id="offlinelayfinish"  class="hide" >
	<div class="red bold">오프라인쿠폰 > 수동 일괄등록이 <span id='totalcountlay'></span>완료되었습니다.</div>
</div>

<div class="list_info_container mt10">
	<div class="dvs_left">	
		총 <span id="totalcount" class="bold"><?php echo $TPL_VAR["sc"]["totalcount"]?></span>개
	</div>	
</div>

<table class="table_basic tdc">
	<thead>
	<tr>
		<th>번호</th>
		<th>인증번호</th>
		<th>등록여부</th>
	</tr>
	</thead>
	<tbody id="ajaxTable"></tbody>
</table>
</form>