<?php /* Template_ 2.2.6 2022/05/17 12:32:00 /www/music_brother_firstmall_kr/admin/skin/default/goods/_set_search_default_goods.html 000032474 */ 
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);
$TPL_shippingGroupList_1=empty($TPL_VAR["shippingGroupList"])||!is_array($TPL_VAR["shippingGroupList"])?0:count($TPL_VAR["shippingGroupList"]);
$TPL_ship_set_code_1=empty($TPL_VAR["ship_set_code"])||!is_array($TPL_VAR["ship_set_code"])?0:count($TPL_VAR["ship_set_code"]);
$TPL_sale_list_1=empty($TPL_VAR["sale_list"])||!is_array($TPL_VAR["sale_list"])?0:count($TPL_VAR["sale_list"]);
$TPL_event_list_1=empty($TPL_VAR["event_list"])||!is_array($TPL_VAR["event_list"])?0:count($TPL_VAR["event_list"]);
$TPL_gift_list_1=empty($TPL_VAR["gift_list"])||!is_array($TPL_VAR["gift_list"])?0:count($TPL_VAR["gift_list"]);
$TPL_referersale_list_1=empty($TPL_VAR["referersale_list"])||!is_array($TPL_VAR["referersale_list"])?0:count($TPL_VAR["referersale_list"]);
$TPL_marketsObj_1=empty($TPL_VAR["marketsObj"])||!is_array($TPL_VAR["marketsObj"])?0:count($TPL_VAR["marketsObj"]);?>
<script type="text/javascript">
$(document).ready(function() {
	set_search_default();
});

function colorMultiCheck() {
	if ($('.colorDefault:not(:checked)').length < 1) {
	$('.colorDefault').attr('checked', false);
		$('.colorDefault').parent().removeClass('active');
	} else {
		$('.colorDefault').attr('checked', true);
		$('.colorDefault').parent().addClass('active');
	}
}

function set_search_default() {
	$.getJSON('get_search_default?search_page=<?php echo $TPL_VAR["search_page"]?>', function(result) {
		$("#set_search_detail input[type='checkbox']").removeAttr("checked");
		$("#set_search_detail input[type='text']").val('');
		$("#set_search_detail select").val('').change();
		$("#set_search_detail input[type='hidden'][name='select_search_icon']").val('');
		$("#set_search_detail .msg_select_icon").text('');

		try {
			var marketArr = [];
			marketArr["market"] = "";
			marketArr["sellerId"] = "";
			for(var i=0;i<result.length;i++){
				//alert(result[i][0]+" : "+result[i][1]);

				if( $.inArray(result[i][0], ['provider_status_reason_type', 'goodsStatus', 'goodsView', 'taxView', 'cancel_type', 'adult_goods', 'string_price', 'favorite_chk','color_pick']) >= 0 ){
					$.each(result[i][1], function(k, v){
						$("#set_search_detail input[name^='"+result[i][0]+"'][value='"+v+"']").attr("checked",true);
					});
				}else if( strstr(result[i][0],'provider_status_reason_type') ) {
					$("#set_search_detail input[name='provider_status_reason_type[]'][value='"+result[i][1]+"']").attr("checked",true);
				}else if( strstr(result[i][0],'openmarket') ) {
					$("#set_search_detail input[name='openmarket[]'][value='"+result[i][1]+"']").attr("checked",true);
				}else if( strstr(result[i][0],'shipping_set_code') ) {
					$.each(result[i][1], function(k, v){
						$.each(v, function(kk, vv){
							$("#set_search_detail input[name='shipping_set_code["+k+"][]'][value='"+vv+"']").attr("checked",true);
						});
					});
				}else if(result[i][0]=='select_search_icon') {
					$("#set_search_detail [name='"+result[i][0]+"']").val(result[i][1]);
					var splitCode = $("#set_search_detail input[name='select_search_icon']").val().split(",");
					$("#set_search_detail .msg_select_icon").text(splitCode.length+"??? ??????");
				}else if(result[i][0]=='regist_date' || result[i][0]=='search_form_view') {
				}else if(result[i][0]=='market' || result[i][0]=='sellerId') {
					marketArr[result[i][0]] = result[i][1];
				} else {
					$("#set_search_detail select[name='"+result[i][0]+"']").val(result[i][1]);
					$("#set_search_detail input[name='"+result[i][0]+"'][value='"+result[i][1]+"']").attr("checked",true);
					$("#set_search_detail [name='"+result[i][0]+"']:not(:checkbox):not(:radio)").val(result[i][1]);
				}
				$('#set_search_detail select[name="stock_compare"]').trigger('change');
			}
			// ???????????? ?????? ??????
			initMarket("set_search_detail",marketArr["market"],marketArr["sellerId"]);
		} catch (e) {
			//console.log(e);
		}
	});
}
</script>
<style type="text/css">
table.info-table-style th.its-th { padding-left:10px; }
table.info-table-style td.its-td { padding-left:5px; }
</style>
<form name="set_search_detail" id="set_search_detail" method="post" action="set_search_default" target="actionFrame">
<input type="hidden" name="search_page" value="<?php echo $TPL_VAR["search_page"]?>">
<div id="contents">
	<table class="search-form-table" id="serch_tab">
	<tr id="goods_search_form" style="display:block;">
	<tr>
		<td class="its-td">
			<table class="info-table-style" border='0'>
			<colgroup>
				<col width="87" />
				<col width="310" />
				<col width="90" />
				<col width="150" />
				<col width="65" />
				<col width="190" />
				<col width="77" />
				<col width="203" />
			</colgroup>
			<tr>
				<th class="its-th">????????????</th>
				<td class="its-td" colspan="7">
					<label class="search_label"><input type="radio" name="search_form_view" value="open" <?php if(!$_GET["search_form_view"]||$_GET["search_form_view"]=='open'||$TPL_VAR["gdsearchdefault"]["search_form_view"]=='open'){?> checked="checked" <?php }?>/> ??????</label>
					<label class="search_label"><input type="radio" name="search_form_view" value="close" <?php if($_GET["search_form_view"]=='close'||$TPL_VAR["gdsearchdefault"]["search_form_view"]=='close'){?> checked="checked" <?php }?>/> ??????</label>
				</td>
			</tr>
<?php if(serviceLimit('H_AD')){?>
			<tr>
				<th class="its-th">?????????</th>
				<td class="its-td">
					<div class="ui-widget">
						<select name="s_provider_seq_selector" style="vertical-align:middle;width:141px;">
						<option value="0">- ????????? ?????? -</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["provider_seq"]?>"><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }}?>
						</select>
						<span style="margin-left:20px;">&nbsp;</span>
						<input type="hidden" class="s_provider_seq" name="s_provider_seq" value="<?php echo $_GET["provider_seq"]?>" />
						<input type="text" name="s_provider_name" value="<?php echo $_GET["provider_name"]?>" style="width:124px;" readonly />
					</div>
					<span class="ptc-charges hide"></span>

					<style>
					.ui-combobox {
						position: relative;
						display: inline-block;
					}
					.ui-combobox-toggle {
						position: absolute;
						top: 0;
						bottom: 0;
						margin-left: -1px;
						padding: 0;
						/* adjust styles for IE 6/7 */
						*height: 1.7em;
						*top: 0.1em;
					}
					.ui-combobox-input {
						margin: 0;
						padding: 0.3em;
					}
					.ui-autocomplete {
						max-height: 200px;
						overflow-y: auto;
						/* prevent horizontal scrollbar */
						overflow-x: hidden;
					}

					</style>

					<script>
					$(function(){
						var prv_obj = $("select[name='s_provider_seq_selector']").next(".ui-combobox").children("input");
						prv_obj.val('- ????????? ?????? -');
						$( "select[name='s_provider_seq_selector']" )
						.css({'width': 125})
						.combobox()
						.change(function(){
							if( $(this).val() > 0 ){
								$("input[name='s_provider_seq']").val($(this).val());
								$("input[name='s_provider_name']").val($("option:selected",this).text());
							}else{
								$("input[name='s_provider_seq']").val('');
								$("input[name='s_provider_name']").val('');
								//$( "select[name='provider_seq_selector']" ).val('- ????????? ?????? -');
							}
						})
						.next(".ui-combobox").children("input")
						.css({'width': 125})
						.bind('focus',function(){
							if($(this).val()==$( "select[name='s_provider_seq_selector'] option:first-child" ).text()){
								$(this).val('');
							}
						})
						.bind('mouseup',function(){
							if($(this).val()==''){
								$( "select[name='s_provider_seq_selector']").next(".ui-combobox").children("a.ui-combobox-toggle").click();
							}
						});
					});
					</script>
				</td>
				<th class="its-th">??????</th>
				<td class="its-td" colspan="3">
				<div style="padding-left:5px;">
						<label><input type="radio" name="search_provider_status" class="dig_search_provider_status" value="" <?php if($_GET["search_provider_status"]==''){?>checked<?php }?> /> ??????</label>
						<label><input type="radio" name="search_provider_status" class="dig_search_provider_status" value="2" <?php if($_GET["search_provider_status"]== 2){?>checked<?php }?> /> ??????</label>
						<label><input type="radio" name="search_provider_status" class="dig_search_provider_status" value="1" <?php if($_GET["search_provider_status"]== 1){?>checked<?php }?> /> ?????????</label>
					</div>
					<div style="padding:5px 0 0 5px;">
						(<label class="ft_11"><input type="checkbox" name="provider_status_reason_type[]" class="dig_provider_status_reason_type" value="1" <?php if(in_array('1',$_GET['provider_status_reason_type'])){?>checked<?php }?> title="[??????] ?????? ???????????? ??? ?????? ???????????? ?????? ????????? ??????"/> ????????????</label>
						<label class="ft_11"><input type="checkbox" name="provider_status_reason_type[]" class="dig_provider_status_reason_type" value="3" <?php if(in_array('3',$_GET['provider_status_reason_type'])){?>checked<?php }?> title="[??????] ????????? ????????? ????????? ???????????? ???????????? ??????"/> ????????????</label>
						<label class="ft_11"><input type="checkbox" name="provider_status_reason_type[]" class="dig_provider_status_reason_type" value="2" <?php if(in_array('2',$_GET['provider_status_reason_type'])){?>checked<?php }?>/> ?????????</label>
						<label class="ft_11"><input type="checkbox" name="provider_status_reason_type[]" class="dig_provider_status_reason_type" value="e" <?php if(in_array('e',$_GET['provider_status_reason_type'])){?>checked<?php }?> title="[??????] ????????? ????????? ?????????(?????????????????????)??? ???????????? ??????"/> ??????</label>)
					</div>
					<script type="text/javascript">
					<!--
					$(function(){
						// unbind
						$('input.dig_search_provider_status').unbind('click');
						$('input.dig_provider_status_reason_type').unbind('click');

						// bind
						$('input.dig_search_provider_status').bind('click', function(){
							var v = $(this).val();

							if(Number(v) > 0) {
								$('input.dig_provider_status_reason_type').attr('checked', false);
							}
						});

						$('input.dig_provider_status_reason_type').bind('click', function(){
							$('input.dig_search_provider_status').attr('checked', false);
							$('input.dig_search_provider_status:eq(0)').attr('checked', true);
						});
					});
					//-->
					</script>
				</td>
				<th class="its-th" class="left">??????</th>
				<td class="its-td">
					<select name="commission_type_sel" style="width:72px">
						<option value="">??????</option>
						<option value="SACO" <?php if($_GET["commission_type_sel"]=='SACO'){?>selected<?php }?>>????????????(%)</option>
						<option value="SUCO" <?php if($_GET["commission_type_sel"]=='SUCO'){?>selected<?php }?>>?????????(%)</option>
						<option value="SUPR" <?php if($_GET["commission_type_sel"]=='SUPR'){?>selected<?php }?>>?????????</option>
					</select>
					<input type="text" name="s_commission_rate" value="<?php echo $_GET["s_commission_rate"]?>" size="3" class="line" style="width:30px;" /><span class="commission_unit <?php if($_GET["commission_type_sel"]=='SUPR'){?>hide<?php }?>"></span> -
					<input type="text" name="e_commission_rate" value="<?php echo $_GET["e_commission_rate"]?>" size="3" class="line" style="width:30px;" /><span class="commission_unit <?php if($_GET["commission_type_sel"]=='SUPR'){?>hide<?php }?>"></span>
				</td>
			</tr>
<?php }?>
			<tr>
				<th class="its-th">????????????</th>
				<td class="its-td" colspan="5">
					<select class="line" name="s_category1" size="1" style="width:98px;"><option value="">1??? ??????</option></select>
					<select class="line" name="s_category2" size="1" style="width:98px;"><option value="">2??? ??????</option></select>
					<select class="line" name="s_category3" size="1" style="width:98px;"><option value="">3??? ??????</option></select>
					<select class="line" name="s_category4" size="1" style="width:98px;"><option value="">4??? ??????</option></select>

					<label><input type="checkbox" name="goods_category" value="1" <?php if($TPL_VAR["sc"]["goods_category"]){?>checked<?php }?> /> ??????</label><span class="helpicon" title="?????? ??? ?????? ??????????????? ???????????? ???????????????." options="{alignX: 'right'}"></span>
					<label><input type="checkbox" name="goods_category_no" value="1" <?php if($TPL_VAR["sc"]["goods_category_no"]){?>checked<?php }?> /> ?????????</label><span class="helpicon" title="?????? ??? ??????????????? ?????? ????????? ???????????????." options="{alignX: 'right'}"></span>
				</td>
				<th class="its-th">??????</th>
				<td class="its-td">
					<label><input type="checkbox" name="taxView[]" value="tax" <?php if($TPL_VAR["sc"]["taxView"]&&in_array('tax',$TPL_VAR["sc"]["taxView"])){?>checked<?php }?>/> ??????</label>
					<span class="pd_td_right">&nbsp;</span>
					<label><input type="checkbox" name="taxView[]" value="exempt" <?php if($TPL_VAR["sc"]["taxView"]&&in_array('exempt',$TPL_VAR["sc"]["taxView"])){?>checked<?php }?>/> ?????????</label>
				</td>
			</tr>
			<tr>
				<th class="its-th">?????????</th>
				<td class="its-td" colspan="5">
					<select class="line" name="s_brands1" size="1" style="width:98px;"><option value="">1??? ??????</option></select>
					<select class="line" name="s_brands2" size="1" style="width:98px;"><option value="">2??? ??????</option></select>
					<select class="line" name="s_brands3" size="1" style="width:98px;"><option value="">3??? ??????</option></select>
					<select class="line" name="s_brands4" size="1" style="width:98px;"><option value="">4??? ??????</option></select>

					 <label><input type="checkbox" name="goods_brand" value="1" <?php if($TPL_VAR["sc"]["goods_brand"]){?>checked<?php }?> /> ??????</label><span class="helpicon" title="?????? ??? ?????? ???????????? ???????????? ???????????????." options="{alignX: 'right'}"></span>

					 <label><input type="checkbox" name="goods_brand_no" value="1" <?php if($TPL_VAR["sc"]["goods_brand_no"]){?>checked<?php }?> /> ?????????</label><span class="helpicon" title="?????? ??? ???????????? ?????? ????????? ???????????????." options="{alignX: 'right'}"></span>
				</td>
				<th class="its-th">??????</th>
				<td class="its-td">
					<label><input type="checkbox" name="goodsStatus[]" value="normal" <?php if(($TPL_VAR["sc"]["goodsStatus"]&&in_array('normal',$TPL_VAR["sc"]["goodsStatus"]))||(in_array('normal',$TPL_VAR["gdsearchdefault"]["goodsStatus"]))){?>checked<?php }?>/> ??????</label>
					<label><input type="checkbox" name="goodsStatus[]" value="runout" <?php if(($TPL_VAR["sc"]["goodsStatus"]&&in_array('runout',$TPL_VAR["sc"]["goodsStatus"]))||(in_array('runout',$TPL_VAR["gdsearchdefault"]["goodsStatus"]))){?>checked<?php }?>/> ??????</label><br/>
					<label><input type="checkbox" name="goodsStatus[]" value="purchasing" <?php if(($TPL_VAR["sc"]["goodsStatus"]&&in_array('purchasing',$TPL_VAR["sc"]["goodsStatus"]))||(in_array('purchasing',$TPL_VAR["gdsearchdefault"]["goodsStatus"]))){?>checked<?php }?>/> ???????????????</label>
					<label><input type="checkbox" name="goodsStatus[]" value="unsold" <?php if(($TPL_VAR["sc"]["goodsStatus"]&&in_array('unsold',$TPL_VAR["sc"]["goodsStatus"]))||(in_array('unsold',$TPL_VAR["gdsearchdefault"]["goodsStatus"]))){?>checked<?php }?>/> ????????????</label>
				</td>
			</tr>
			<tr>
				<th class="its-th">??????</th>
				<td class="its-td" colspan="5">
					<select class="line" name="s_location1" size="1" style="width:98px;"><option value="">1??? ??????</option></select>
					<select class="line" name="s_location2" size="1" style="width:98px;"><option value="">2??? ??????</option></select>
					<select class="line" name="s_location3" size="1" style="width:98px;"><option value="">3??? ??????</option></select>
					<select class="line" name="s_location4" size="1" style="width:98px;"><option value="">4??? ??????</option></select>

					 <label><input type="checkbox" name="goods_location" value="1" <?php if($TPL_VAR["sc"]["goods_location"]){?>checked<?php }?> /> ??????</label><span class="helpicon" title="?????? ??? ?????? ????????? ???????????? ???????????????." options="{alignX: 'right'}"></span>

					 <label><input type="checkbox" name="goods_location_no" value="1" <?php if($TPL_VAR["sc"]["goods_location_no"]){?>checked<?php }?> /> ?????????</label><span class="helpicon" title="?????? ??? ????????? ?????? ????????? ???????????????." options="{alignX: 'right'}"></span>
				</td>
				<th class="its-th">??????</th>
				<td class="its-td">
					<label><input type="checkbox" name="goodsView[]" value="look" <?php if($TPL_VAR["sc"]["goodsView"]&&in_array('look',$TPL_VAR["sc"]["goodsView"])){?>checked<?php }?>/> ??????</label>
					<label><input type="checkbox" name="goodsView[]" value="auto" <?php if($TPL_VAR["sc"]["goodsView"]&&in_array('auto',$TPL_VAR["sc"]["goodsView"])){?>checked<?php }?>/> ????????????</label>
					<label><input type="checkbox" name="goodsView[]" value="notLook" <?php if($TPL_VAR["sc"]["goodsView"]&&in_array('notLook',$TPL_VAR["sc"]["goodsView"])){?>checked<?php }?>/> ?????????</label>
				</td>
			</tr>
			<tr>
				<th class="its-th">??????</th>
				<td class="its-td" colspan="5">
					<select class="line" name="date_gb" style="width:98px;">
						<option value="regist_date" <?php if($TPL_VAR["sc"]["date_gb"]=='regist_date'||$TPL_VAR["gdsearchdefault"]["date_gb"]=='regist_date'){?>selected<?php }?>>?????????</option>
						<option value="update_date" <?php if($TPL_VAR["sc"]["date_gb"]=='update_date'||$TPL_VAR["gdsearchdefault"]["date_gb"]=='update_date'){?>selected<?php }?>>?????????</option>
					</select>
					<label class="search_label"><input type="radio" name="regist_date" value="today" <?php if($_GET["regist_date_type"]=='today'||$TPL_VAR["gdsearchdefault"]["regist_date"]=='today'){?> checked="checked" <?php }?>/> ??????</label>
					<label class="search_label"><input type="radio" name="regist_date" value="3day" <?php if($_GET["regist_date_type"]=='3day'||$TPL_VAR["gdsearchdefault"]["regist_date"]=='3day'){?> checked="checked" <?php }?>/> 3??????</label>
					<label class="search_label"><input type="radio" name="regist_date" value="7day" <?php if($_GET["regist_date_type"]=='7day'||$TPL_VAR["gdsearchdefault"]["regist_date"]=='7day'){?> checked="checked" <?php }?>/> ?????????</label>
					<label class="search_label"><input type="radio" name="regist_date" value="1mon" <?php if($_GET["regist_date_type"]=='1mon'||$TPL_VAR["gdsearchdefault"]["regist_date"]=='1mon'){?> checked="checked" <?php }?>/> 1??????</label>
					<label class="search_label"><input type="radio" name="regist_date" value="3mon" <?php if($_GET["regist_date_type"]=='3mon'||$TPL_VAR["gdsearchdefault"]["regist_date"]=='3mon'){?> checked="checked" <?php }?>/> 3??????</label>
					<label class="search_label"><input type="radio" name="regist_date" value="all" <?php if(!$_GET["regist_date_type"]||$_GET["regist_date_type"]=='all'||$TPL_VAR["gdsearchdefault"]["regist_date"]=='all'){?> checked="checked" <?php }?>/> ??????</label>
				</td>
				<th class="its-th" class="left">????????????</th>
				<td class="its-td">
					<label><input type="checkbox" name="sale_for_stock" value="stock" <?php if($_GET["sale_for_stock"]=='stock'){?>checked<?php }?>/> ????????????</label>&nbsp;
					<label><input type="checkbox" name="sale_for_ableStock" value="ableStock" <?php if($_GET["sale_for_ableStock"]=='ableStock'){?>checked<?php }?>/> ????????????</label><br/>
					<label><input type="checkbox" name="sale_for_unlimited" value="unlimited" <?php if($_GET["sale_for_unlimited"]=='unlimited'){?>checked<?php }?>/> ????????????</label>&nbsp;
				</td>
			</tr>
			<tr>
				<th class="its-th">??????</th>
				<td class="its-td">
					<select class="line" name="price_gb" style="width:98px;">
						<option value="consumer_price" <?php if($TPL_VAR["sc"]["price_gb"]=='consumer_price'){?>selected<?php }?>>?????????</option>
						<option value="price" <?php if($TPL_VAR["sc"]["price_gb"]=='price'){?>selected<?php }?>>?????????</option>
					</select>
					<input type="text" name="sprice" value="<?php echo $_GET["sprice"]?>" size="7" class="line" style="width:75px;" />
					<span class="gray">-</span>
					<input type="text" name="eprice" value="<?php echo $_GET["eprice"]?>" size="7" class="line" style="width:75px;" />
				</td>
				<th class="its-th">????????????</th>
				<td class="its-td" colspan="3">
					<select class="line" name="shipping_group_seq" style="width:205px;">
						<option value="">???????????? ???????????? ??????</option>
<?php if($TPL_shippingGroupList_1){foreach($TPL_VAR["shippingGroupList"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["shipping_group_seq"]?>"
<?php if($_GET["shipping_group_seq"]==$TPL_V1["shipping_group_seq"]){?>selected<?php }?>
<?php if($_GET["provider_seq"]> 0&&$_GET["provider_seq"]!=$TPL_V1["shipping_provider_seq"]){?>class="hide"<?php }?>
							shipping_provider_seq = "<?php echo $TPL_V1["shipping_provider_seq"]?>"
							koreaMethodDesc="<?php echo $TPL_V1["method_korea_text"]?>" globalMethodDesc="<?php echo $TPL_V1["method_global_text"]?>"
						><?php echo $TPL_V1["provider_name"]?><?php echo $TPL_V1["shipping_group_name"]?> (<?php echo $TPL_V1["shipping_group_seq"]?>)</option>
<?php }}?>
					</select>
				</td>
				<th class="its-th">??????</th>
				<td class="its-td">
					<select name="stock_compare" id="stock_default_compare" style="width:160px;" onchange="select_stock_compare('default');">
						<option value="">???????????????</option>
						<option value="less" <?php if($_GET["stock_compare"]=='less'){?>selected<?php }?>>?????????????????? ?????? ??????</option>
						<option value="greater" <?php if($_GET["stock_compare"]=='greater'){?>selected<?php }?>>?????????????????? ??? ??? ??????</option>
						<option value="stock" <?php if($_GET["stock_compare"]=='stock'){?>selected<?php }?>>??????????????? ?????? ??????</option>
						<option value="safe" <?php if($_GET["stock_compare"]=='safe'){?>selected<?php }?>>??????????????? ???????????? ??????</option>
					</select>
					<span class="hide"><input type="text" name="sstock" value="<?php echo $_GET["sstock"]?>" class="line" style="width:25px;" /></span>
					<span class="hide">- <input type="text" name="estock" value="<?php echo $_GET["estock"]?>" class="line" style="width:25px;" /></span>
				</td>
			</tr>
			<tr>
				<th class="its-th">????????????</th>
				<td class="its-td">
					<label><input type="checkbox" class="string_price_checkbox" name="string_price[0]" value="1" <?php if($_GET["string_price"][ 0]){?>checked<?php }?> /> ?????????</label>&nbsp;
					<label><input type="checkbox" class="string_price_checkbox" name="string_price[1]" value="1" <?php if($_GET["string_price"][ 1]){?>checked<?php }?> /> ?????? + ????????????</label>
				</td>
				<th class="its-th">????????????</th>
				<td class="its-td" colspan="3">
					<div id="domesticShippingList" class="<?php if($_GET["shipping_group_seq"]){?>hide<?php }?>">
<?php if($TPL_ship_set_code_1){foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){?>
						<label><input type="checkbox" name="shipping_set_code[domestic][]" value="<?php echo $TPL_K1?>" <?php if(in_array($TPL_K1,$_GET["shipping_set_code"]["domestic"])){?>checked<?php }?> /> <?php echo $TPL_V1?></label>
<?php }}?>
					</div>
					<div id="domesticShippingInfo" class="<?php if(!$TPL_VAR["sc"]["shipping_group_seq"]){?>hide<?php }?>"></div>
				</td>
				<th class="its-th">??????(kg)</th>
				<td class="its-td">
					<input type="text" name="sweight" value="<?php echo $_GET["sweight"]?>" class="line" style="width:40px;" /> - <input type="text" name="eweight" value="<?php echo $_GET["eweight"]?>" class="line" style="width:40px;" />
				</td>
			</tr>
			<tr>
				<th class="its-th">??????</th>
				<td class="its-td">
					<select name="sale_seq" class="line" style="width:81px;">
						<option value="">??????</option>
<?php if($TPL_sale_list_1){foreach($TPL_VAR["sale_list"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["sale_seq"]?>" <?php if($_GET["sale_seq"]==$TPL_V1["sale_seq"]){?>selected<?php }?>><?php echo $TPL_V1["sale_title"]?></option>
<?php }}?>
					</select>
				</td>
				<th class="its-th">????????????</th>
				<td class="its-td" colspan="3">
					<div id="internationalShippingList" class="<?php if($_GET["shipping_group_seq"]){?>hide<?php }?>">
<?php if($TPL_ship_set_code_1){foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){?>
						<label><input type="checkbox" name="shipping_set_code[international][]" value="<?php echo $TPL_K1?>"  <?php if(in_array($TPL_K1,$_GET["shipping_set_code"]["international"])){?>checked<?php }?> /> <?php echo $TPL_V1?></label>
<?php }}?>
					</div>
					<div id="internationalShippingInfo" class="<?php if(!$TPL_VAR["sc"]["shipping_group_seq"]){?>hide<?php }?>"></div>
				</td>
				<th class="its-th">????????????</th>
				<td class="its-td">
					<input type="text" name="spage_view" value="<?php echo $_GET["spage_view"]?>" class="line" size="4" style="width:40px;" /> - <input type="text" name="epage_view" value="<?php echo $_GET["epage_view"]?>" class="line" size="4" style="width:40px;" />
				</td>
			</tr>
			<tr>
				<th class="its-th">??????</th>
				<td class="its-td">
					<select name="event_seq" class="line" style="width:280px;">
						<option value="">????????? ??????</option>
<?php if($TPL_VAR["event_list"]){?>
<?php if($TPL_event_list_1){foreach($TPL_VAR["event_list"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["event_seq"]?>" <?php if($_GET["event_seq"]==$TPL_V1["event_seq"]){?>selected<?php }?>><?php echo $TPL_V1["event_title"]?></option>
<?php }}?>
<?php }?>
					</select>
				</td>
				<th class="its-th">????????????</th>
				<td class="its-td" colspan="3">
					<label><input type="checkbox" name="feed_status" value="Y" <?php if($_GET["feed_status"]=='Y'){?>checked<?php }?> /> ??????</label>
					<label><input type="checkbox" name="feed_status" value="N" <?php if($_GET["feed_status"]=='N'){?>checked<?php }?> /> ?????????</label>
				</td>
				<th class="its-th">????????????</th>
				<td class="its-td">
					<label><input type="checkbox" name="cancel_type[0]" value="0" <?php if($_GET["cancel_type"][ 0]=='0'){?>checked<?php }?> /> ??????</label>&nbsp;
					<label><input type="checkbox" name="cancel_type[1]" value="1" <?php if($_GET["cancel_type"][ 1]){?>checked<?php }?> /> ?????????</label>
				</td>
			</tr>
			<tr>
				<th class="its-th">?????????</th>
				<td class="its-td">
					<select name="gift_seq" class="line" style="width:280px;">
						<option value="">????????? ????????? ??????</option>
<?php if($TPL_VAR["gift_list"]){?>
<?php if($TPL_gift_list_1){foreach($TPL_VAR["gift_list"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["gift_seq"]?>" <?php if($_GET["gift_seq"]==$TPL_V1["gift_seq"]){?>selected<?php }?>><?php echo $TPL_V1["gift_title"]?></option>
<?php }}?>
<?php }?>
					</select>
				</td>
				<th class="its-th">????????????</th>
				<td class="its-td" colspan="3">
					<label><input type="checkbox" name="favorite_chk[0]" value="1" <?php if($TPL_VAR["sc"]["favorite_chk"][ 0]){?>checked<?php }?>/>  <span class="icon-star-gray hand checked list-important"></span></label> &nbsp;
					<label><input type="checkbox" name="favorite_chk[1]" value="1" <?php if($TPL_VAR["sc"]["favorite_chk"][ 1]){?>checked<?php }?>/> <span class="icon-star-gray hand list-important "></span></label>
				</td>
				<th class="its-th">????????????</th>
				<td class="its-td">
					<label><input type="checkbox" name="layaway_product" value="Y" <?php if($_GET["layaway_product"]=='Y'){?>checked="checked"<?php }?> /> ?????? ?????????????????? ??????</label>
				</td>
			</tr>
			<tr>
				<th class="its-th">????????????</th>
				<td class="its-td">
					<select name="referersale_seq" class="line" style="width:280px;">
						<option value="">???????????? ????????? ??????</option>
<?php if($TPL_referersale_list_1){foreach($TPL_VAR["referersale_list"] as $TPL_V1){?><option value="<?php echo $TPL_V1["referersale_seq"]?>" <?php if($_GET["referersale_seq"]==$TPL_V1["referersale_seq"]){?>selected<?php }?>><?php echo $TPL_V1["referersale_name"]?></option><?php }}?>
					</select>
				</td>
				<th class="its-th">?????????</th>
				<td class="its-td" colspan="3">
					<button type="button" class="s_btn_search_icon"><span class='hide'>??????</span></button>
					<input type="hidden" name="select_search_icon" value="<?php echo $_GET["select_search_icon"]?>" />&nbsp;<span class="msg_select_icon"></span>
				</td>
				<th class="its-th">????????????</th>
				<td class="its-td">
					<label><input type="checkbox" name="adult_goods[1]" value="Y" <?php if($_GET["adult_goods"][ 1]=='Y'||$TPL_VAR["gdsearchdefault"]["adult_goods"][ 1]=='Y'){?>checked="checked"<?php }?> /> ??????</label>
					<span class="pd_td_right">&nbsp;</span>
					<label><input type="checkbox" name="adult_goods[0]" value="N" <?php if($_GET["adult_goods"][ 0]=='N'||$TPL_VAR["gdsearchdefault"]["adult_goods"][ 0]=='N'){?>checked="checked"<?php }?> /> ??????</label>
				</td>
			</tr>
			<tr>
				<th class="its-th">????????????</th>
				<td class="its-td">
					<label><input type="checkbox" name="multi_discount" value="Y" <?php if($TPL_VAR["sc"]["multi_discount"]=='Y'){?>checked="checked"<?php }?> /> ??????????????? ?????? ??????</label>
				</td>
				<th class="its-th">??????</th>
				<td class="its-td" colspan="3">
					<div class="color-check">
<?php if(is_array($TPL_R1=$TPL_VAR["arr_common"]['colorPickList'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
					<label style="background-color:#<?php echo $TPL_K1?>" class="<?php if($TPL_V1== 1){?>active<?php }?>"><input type="checkbox" class="colorDefault" name="color_pick[]" value="<?php echo $TPL_K1?>" <?php if($TPL_V1== 1){?>checked<?php }?> /></label>
<?php }}?>
					&nbsp;
					<span class="btn small"><button type="button" onClick="colorMultiCheck();">????????????</button></span>
					</div>
				</td>
				<th class="its-th">????????????</th>
				<td class="its-td">
					<label><input type="checkbox" name="search_option_international_shipping" value="n" <?php if($_GET["search_option_international_shipping"]=='n'){?>checked<?php }?> /> ??????</label>&nbsp;
					<label><input type="checkbox" name="search_option_international_shipping" value="y" <?php if($_GET["search_option_international_shipping"]=='y'){?>checked<?php }?> /> ??????????????????</label>
					</td>
				</td>
			</tr>
			<!-- <?php if($TPL_VAR["openMarketSeach"]!="disable"){?> -->
			<tr>
				<th class="its-th">????????????</th>
				<td class="its-td" colspan="7">
					<select name="market" id="selMarket" style="width:145px;">
						<option value="">??????</option>
<?php if($TPL_marketsObj_1){foreach($TPL_VAR["marketsObj"] as $TPL_K1=>$TPL_V1){?>
						<option value="<?php echo $TPL_K1?>"
<?php if($TPL_K1==$TPL_VAR["sc"]["market"]){?>selected<?php }?>
						data-seller-list='<?php echo $TPL_V1["sellerListJson"]?>'
						><?php echo $TPL_V1["name"]?></option>
<?php }}?>
					</select>
					<select name="sellerId" id="selMarketUserId" style="width:145px">
						<option value="">??????????????????</option>
					</select>
				</td>
			</tr>
			<!-- <?php }?> -->
			</table>
		</td>
	</tr>
	</table>
</div>
<div>
	<span class="desc pdt5">???????????? ????????? ????????? ID?????? ???????????????</span>
</div>
<div align="center" style="padding-top:10px;">
	<span class="btn large black">
		<button type="submit">????????????<span class="arrowright"></span></button>
	</span>
</div>
</form>