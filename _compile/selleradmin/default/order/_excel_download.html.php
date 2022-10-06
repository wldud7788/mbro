<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/order/_excel_download.html 000003605 */ 
$TPL_ship_set_code_1=empty($TPL_VAR["ship_set_code"])||!is_array($TPL_VAR["ship_set_code"])?0:count($TPL_VAR["ship_set_code"]);?>
<style>
.tip-darkgray {z-index:10000; left:0px; top:0px;}

/* 엑셀 검색 테이블 */
table.search_export_tbl {border-collapse:collapse;border:1px solid #c8c8c8;width:100%;}
table.search_export_tbl th {padding:10px; border:1px solid #c8c8c8;}
table.search_export_tbl td {padding:10px; border:1px solid #c8c8c8; height:30px;}
table.search_export_tbl th {background-color:#efefef;}

/* 배송책임 */
table.search_export_tbl tr td input.ui-state-default {width:100px;}
table.search_export_tbl tr td span.ui-combobox {width:140px;}

table.search_export_tbl tr td select.excel_ship_set_code {
	width: 130px; /* 원하는 너비설정 */
	padding: 3px 0px 3px 3px; /* 여백으로 높이 설정 */
	font-family: inherit;  /* 폰트 상속 */
	border: 1px solid #ccc;
	border-radius: 0px; /* iOS 둥근모서리 제거 */
	appearance: none;
}
table.search_export_tbl tr td span.excel_ship_set_code {
	display:inline-block;
	padding:0px 0px 0px 5px;
}
</style>
<form id="excel_down_form" name="excel_down_form" method="post" action="../order_process/excel_down" target="actionFrame">
<input type="hidden" name="order_seq" value="" />
<input type="hidden" name="seq" value="" />
<input type="hidden" name="excel_step" />
<input type="hidden" name="excel_type" />
<input type="hidden" name="params" />
<input type="hidden" name="pagemode" value="company_catalog" />

<table class="search_export_tbl" style="border-collapse:collapse" border='1'>
	<col width="120" />
	<col />
	<col width="63" />
	<tr>
		<th>배송책임</th>
		<td>
			<span class="red bold">입점사(위탁배송상품 제외)</span>
			<input type="hidden" class="shipping_provider_seq" name="excel_provider_seq" value="<?php echo $TPL_VAR["providerInfo"]["provider_seq"]?>" default_none />
			<span class="excel_ship_set_code">
				<select name="excel_ship_set_code" class="excel_ship_set_code">
					<option value=''>배송방법 전체</option>
<?php if($TPL_ship_set_code_1){foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){?>
					<option value='<?php echo $TPL_K1?>' ><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</span>
		</td>
	</tr>
</table>
<div class="center pdt10">
	<span class="btn large black"><button type="submit" style="width:100px;">다운로드</button></span>
</div>
</form>

<script>
//spout download kmj
$( "#excel_down_form" ).on('submit', function( event ) {
	event.preventDefault();
	event.stopImmediatePropagation(); //이벤트 이중 발생 방지
 
	var queryString = $('form').serializeArray();
	ajaxexceldown_spout('/cli/excel_down/create_order', queryString);
});

function ajaxexceldown_spout(url, queryString){
	var params = {};
	jQuery.each(queryString, function(i, field){
		params[field.name] = field.value;
	});

	$.ajax({      
		type: "POST",  
		url: url,      
		data: params, 
		success:function(args){ 
			closeDialog("excel_download_dialog");
			var exe = args.split('.').pop();
			if(exe == "csv" || exe == "zip" || exe == "xlsx") {
				window.location.href = '/selleradmin/excel_spout/file_download?url=' + args; 
			} else if(args.indexOf('openDialogAlert') >= 0) {
				$('body').append(args);
			} else {
				alert(args);
			}
		}, error:function(e){  
			alert(e.responseText);  
		}  
	});
}
</script>