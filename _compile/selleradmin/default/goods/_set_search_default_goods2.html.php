<?php /* Template_ 2.2.6 2022/05/17 12:29:18 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_set_search_default_goods2.html 000009696 */ 
$TPL_gift_list_1=empty($TPL_VAR["gift_list"])||!is_array($TPL_VAR["gift_list"])?0:count($TPL_VAR["gift_list"]);?>
<script type="text/javascript">
$(document).ready(function() {
	set_search_default();
});

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
				} else {
					$("#set_search_detail select[name='"+result[i][0]+"']").val(result[i][1]);
					$("#set_search_detail input[name='"+result[i][0]+"'][value='"+result[i][1]+"']").attr("checked",true);
					$("#set_search_detail [name='"+result[i][0]+"']:not(:checkbox):not(:radio)").val(result[i][1]);
				}
				//$("#set_search_detail *[name='"+result[i][0]+"']",document.goodsForm).val(result[i][1]);
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
				<col width="65" />
				<col width="*" />
				<col width="65" />
				<col width="110" />
				<col width="65" />
				<col width="240" />
				<col width="65" />
				<col width="260" />
			</colgroup>
			<tr>
				<th class="its-th">????????????</th>
				<td class="its-td" colspan="7">
					<label class="search_label"><input type="radio" name="search_form_view" value="open" <?php if(!$_GET["search_form_view"]||$_GET["search_form_view"]=='open'||$TPL_VAR["gdsearchdefault"]["search_form_view"]=='open'){?> checked="checked" <?php }?>/> ??????</label>
					<label class="search_label"><input type="radio" name="search_form_view" value="close" <?php if($_GET["search_form_view"]=='close'||$TPL_VAR["gdsearchdefault"]["search_form_view"]=='close'){?> checked="checked" <?php }?>/> ??????</label>
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
				<th class="its-th">??????</th>
				<td class="its-td">
					<label><input type="checkbox" name="goodsStatus[]" value="normal" <?php if(($TPL_VAR["sc"]["goodsStatus"]&&in_array('normal',$TPL_VAR["sc"]["goodsStatus"]))||(in_array('normal',$TPL_VAR["gdsearchdefault"]["goodsStatus"]))){?>checked<?php }?>/> ??????</label>
					<label><input type="checkbox" name="goodsStatus[]" value="runout" <?php if(($TPL_VAR["sc"]["goodsStatus"]&&in_array('runout',$TPL_VAR["sc"]["goodsStatus"]))||(in_array('runout',$TPL_VAR["gdsearchdefault"]["goodsStatus"]))){?>checked<?php }?>/> ??????</label><br/>
					<label><input type="checkbox" name="goodsStatus[]" value="purchasing" <?php if(($TPL_VAR["sc"]["goodsStatus"]&&in_array('purchasing',$TPL_VAR["sc"]["goodsStatus"]))||(in_array('purchasing',$TPL_VAR["gdsearchdefault"]["goodsStatus"]))){?>checked<?php }?>/> ???????????????</label>
					<label><input type="checkbox" name="goodsStatus[]" value="unsold" <?php if(($TPL_VAR["sc"]["goodsStatus"]&&in_array('unsold',$TPL_VAR["sc"]["goodsStatus"]))||(in_array('unsold',$TPL_VAR["gdsearchdefault"]["goodsStatus"]))){?>checked<?php }?>/> ????????????</label>
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
				<td class="its-td">
					<label><input type="checkbox" name="favorite_chk[0]" value="1" <?php if($TPL_VAR["sc"]["favorite_chk"][ 0]){?>checked<?php }?>/> <span class="icon-star-gray hand checked list-important"></span></label>&nbsp;
					<label><input type="checkbox" name="favorite_chk[1]" value="1" <?php if($TPL_VAR["sc"]["favorite_chk"][ 1]){?>checked<?php }?>/> <span class="icon-star-gray hand list-important "></span></label>
				</td>


				<th class="its-th">????????????</th>
				<td class="its-td">
					<label><input type="checkbox" name="sale_for_stock" value="stock" <?php if($_GET["sale_for_stock"]=='stock'){?>checked<?php }?>/> ????????????</label>&nbsp;
					<label><input type="checkbox" name="sale_for_ableStock" value="ableStock" <?php if($_GET["sale_for_ableStock"]=='ableStock'){?>checked<?php }?>/> ????????????</label><br/>
					<label><input type="checkbox" name="sale_for_unlimited" value="unlimited" <?php if($_GET["sale_for_unlimited"]=='unlimited'){?>checked<?php }?>/> ????????????</label>&nbsp;
				</td>

				<th class="its-th">??????(???)</th>
				<td class="its-td">
					<input type="text" name="sstock" value="<?php echo $_GET["sstock"]?>" size="3" class="line" style="width:40px;" /> - <input type="text" name="estock" value="<?php echo $_GET["estock"]?>" size="3" class="line" style="width:40px;" />
					<label><input type="checkbox" name="optstock" value="1" <?php if($_GET["optstock"]){?>checked="checked"<?php }?>/> ?????????</label>
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