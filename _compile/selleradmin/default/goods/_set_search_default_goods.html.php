<?php /* Template_ 2.2.6 2022/05/17 12:29:18 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_set_search_default_goods.html 000024074 */ 
$TPL_shippingGroupList_1=empty($TPL_VAR["shippingGroupList"])||!is_array($TPL_VAR["shippingGroupList"])?0:count($TPL_VAR["shippingGroupList"]);
$TPL_ship_set_code_1=empty($TPL_VAR["ship_set_code"])||!is_array($TPL_VAR["ship_set_code"])?0:count($TPL_VAR["ship_set_code"]);
$TPL_sale_list_1=empty($TPL_VAR["sale_list"])||!is_array($TPL_VAR["sale_list"])?0:count($TPL_VAR["sale_list"]);
$TPL_event_list_1=empty($TPL_VAR["event_list"])||!is_array($TPL_VAR["event_list"])?0:count($TPL_VAR["event_list"]);
$TPL_gift_list_1=empty($TPL_VAR["gift_list"])||!is_array($TPL_VAR["gift_list"])?0:count($TPL_VAR["gift_list"]);
$TPL_referersale_list_1=empty($TPL_VAR["referersale_list"])||!is_array($TPL_VAR["referersale_list"])?0:count($TPL_VAR["referersale_list"]);?>
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
			for(var i=0;i<result.length;i++){
				//alert(result[i][0]+" : "+result[i][1]);

				if( $.inArray(result[i][0], ['goodsStatus', 'goodsView', 'taxView', 'cancel_type', 'adult_goods', 'string_price', 'favorite_chk','color_pick']) >= 0 ){
					$.each(result[i][1], function(k, v){
						$("#set_search_detail input[name^='"+result[i][0]+"'][value='"+v+"']").attr("checked",true);
					});
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
				} else {
					$("#set_search_detail select[name='"+result[i][0]+"']").val(result[i][1]);
					$("#set_search_detail input[name='"+result[i][0]+"'][value='"+result[i][1]+"']").attr("checked",true);
					$("#set_search_detail [name='"+result[i][0]+"']:not(:checkbox):not(:radio)").val(result[i][1]);
				}
				$('#set_search_detail select[name="stock_compare"]').trigger('change');
			}
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
						><?php echo $TPL_V1["shipping_group_name"]?></option>
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
				<td class="its-td" colspan="5">
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