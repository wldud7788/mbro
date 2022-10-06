<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/order/_excel_download.html 000004306 */ 
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);
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

<table class="search_export_tbl" style="border-collapse:collapse" border='1'>
	<col width="120" />
	<col />
	<col width="63" />
	<tr>
		<th>배송책임</th>
		<td>
<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_VAR["pagemode"]=="company_catalog"){?>
			<span class="red bold">본사 (입점사 위탁배송 포함)</span>
<?php }else{?>
			<div class="ui-widget"  style="float:left;">
				<select name="excel_provider_seq_selector" style="vertical-align:middle;" default_none>
				<option value="0">검색</option>
				<option value="1" provider_id="본사">본사</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["provider_seq"]?>" provider_id="<?php echo $TPL_V1["provider_id"]?>"><?php echo $TPL_V1["provider_name"]?></option>
<?php }}?>
				</select>
				<input type="hidden" class="shipping_provider_seq" name="excel_provider_seq" value="" default_none />
				<input type="text" name="excel_provider_name" value="" readonly class="disabled"  default_none />
			</div>
			<span class="ptc-charges hide"></span>

			<script type="text/javascript">
			$(function(){
				$( "select[name='excel_provider_seq_selector']" )
				.combobox()
				.change(function(){
					if( $(this).val() > 0 ){
						$("input[name='excel_provider_seq']").val($(this).val());
						$("input[name='excel_provider_name']").val($("option:selected",this).attr("provider_id"));
					}else{
						$("input[name='excel_provider_seq']").val('1');
						$("input[name='excel_provider_name']").val('본사');
					}
				})
				.next(".ui-combobox").children("input")
				.bind('focus',function(){
					if($(this).val()==$( "select[name='excel_provider_seq_selector'] option:first-child" ).text()){
						$(this).val('');
					}
				})
				.bind('mouseup',function(){
					if($(this).val()==''){
						$( "select[name='excel_provider_seq_selector']").next(".ui-combobox").children("a.ui-combobox-toggle").click();
					}
				});
			});
			</script>
<?php }?>
<?php }?>
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