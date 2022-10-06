<?php /* Template_ 2.2.6 2022/05/17 12:29:17 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_quick_regist_rowskin.html 000015883 */ 
$TPL_removeGoods_1=empty($TPL_VAR["removeGoods"])||!is_array($TPL_VAR["removeGoods"])?0:count($TPL_VAR["removeGoods"]);?>
<table id="tmp_row_html">
<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["tmpData"]["goods"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["options"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<tr class="option-row-<?php echo $TPL_V1["goods_seq"]?> option-rows" goodsSeq="<?php echo $TPL_V1["goods_seq"]?>">
<?php if($TPL_I2== 0){?>
	<td class="its-td-align center goods-seq-td" rowspan="<?php echo count($TPL_V1["options"])?>">
		<input type="checkbox" name="goods_seq[]" class="chk" value="<?php echo $TPL_V1["goods_seq"]?>" />
	</td>
	<td class="its-td-align left pdl5 goods-name-td" style="vertical-align:top;" rowspan="<?php echo count($TPL_V1["options"])?>">
		<div class="right" style="width:98%;">
			<input type="text" name="goods_name[<?php echo $TPL_V1["goods_seq"]?>]" class="goods_name" style="width:50%;" value="<?php echo $TPL_V1["goods_name"]?>" title="상품명" onblur="domSaverSendData(this);" />
			<input type="text" name="goods_code[<?php echo $TPL_V1["goods_seq"]?>]" class="goods_code" style="width:30%;" value="<?php echo $TPL_V1["goods_code"]?>" title="기본코드" onblur="domSaverSendData(this);" />
			<div style="margin-top:5px;">
				<input type="hidden" name="option_use[<?php echo $TPL_V1["goods_seq"]?>]" class="option_use" value="<?php echo $TPL_V1["option_use"]?>" />
<?php if($TPL_V1["option_use"]=='Y'){?>
				<span class="btn small whiteblue"><button type="button" onclick="open_options_create_popup('create_option_popup', '<?php echo $TPL_V1["goods_seq"]?>', 'create_option_batch_regist', '<?php echo $TPL_VAR["tmpData"]["tmp_seq"]?>');">옵션 : 있음</button></span>
<?php }else{?>
				<span class="btn small whiteblue"><button type="button" onclick="open_options_create_popup('create_option_popup', '<?php echo $TPL_V1["goods_seq"]?>', 'create_option_batch_regist', '<?php echo $TPL_VAR["tmpData"]["tmp_seq"]?>');">옵션 : 없음</button></span>
<?php }?>
			</div>
		</div>
	</td>
<?php }?>
	<td class="its-td-align center">
		<table width="90%" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
<?php if(is_array($TPL_R3=$TPL_V2["opt_values"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
		<tr>
			<td width="55" height="20"><?php echo $TPL_V3?></td>
			<td width="12" style="text-align:center;">
<?php if($TPL_V2["newtype"][$TPL_K3]=='color'){?>
				<div style="background-color:<?php echo $TPL_V2["color"]?>;border:1px solid #c5c5c5;width:10px;height:10px;"></div>
<?php }?>
			</td>
			<td class="left pdl5" height="20"><?php echo $TPL_V2["opt_codes"][$TPL_K3]?></td>
		</tr>
<?php }}?>
		</table>
		<input type="hidden" name="option_seq[<?php echo $TPL_V1["goods_seq"]?>][]" class="option_seq" value="<?php echo $TPL_V2["option_seq"]?>" />
	</td>
	<td class="its-td-align left pdl5" style="vertical-align:top;">
		<input type="text" name="weight[<?php echo $TPL_V2["option_seq"]?>]" class="weight" style="width:40%;" value="<?php echo $TPL_V2["weight"]?>" onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
	</td>
<?php if($TPL_VAR["scm_cfg"]["use"]=='Y'&&$TPL_VAR["scm_cfg"]["set_default_date"]&&!$TPL_VAR["sellermode"]){?>
	<td class="its-td-align left pdl5 bg-pastelred scm-box <?php if($TPL_VAR["tmpData"]["provider_seq"]> 1){?>hide<?php }?>" style="vertical-align:top;">
<?php if(is_array($TPL_R3=$TPL_V2["revision"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
		<div class="warehouse-lay-<?php echo $TPL_V2["option_seq"]?> revision-row-<?php echo $TPL_V3["revision_seq"]?>" rseq="<?php echo $TPL_V3["revision_seq"]?>" style="height:25px;">
			<input type="hidden" name="revision_seq[<?php echo $TPL_V2["option_seq"]?>][]" class="revision_seq" value="<?php echo $TPL_V3["revision_seq"]?>" />
			<select name="warehouse[<?php echo $TPL_V2["option_seq"]?>][]" class="simple warehouse" onchange="select_warehouse(this, '');" whSeq="<?php echo $TPL_V3["wh_seq"]?>">
				<option value="">창고 선택</option>
<?php if(is_array($TPL_R4=$TPL_VAR["whData"]['warehouse'])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
				<option value="<?php echo $TPL_V4["wh_seq"]?>" <?php if($TPL_V4["wh_seq"]==$TPL_V3["wh_seq"]){?>selected<?php }?>><?php echo $TPL_V4["wh_name"]?></option>
<?php }}?>
			</select>
			<select name="location_w[<?php echo $TPL_V2["option_seq"]?>][]" class="simple location_w" onchange="scmLocationSendData(this);" <?php if(!$TPL_V3["wh_seq"]){?>disabled style="background-color:#efefef;"<?php }?>>
<?php if(is_array($TPL_R4=$TPL_V3["location"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?>
				<option value="<?php echo $TPL_K4?>" <?php if($TPL_V3["position_arr"][ 0]==$TPL_K4){?>selected<?php }?>><?php echo $TPL_K4?></option>
<?php }}?>
			</select>
			<select name="location_l[<?php echo $TPL_V2["option_seq"]?>][]" class="simple location_l" onchange="scmLocationSendData(this);" <?php if(!$TPL_V3["wh_seq"]){?>disabled style="background-color:#efefef;"<?php }?>>
<?php if(is_array($TPL_R4=$TPL_V3["location"][$TPL_V3["position_arr"][ 0]])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?>
				<option value="<?php echo $TPL_K4?>" <?php if($TPL_V3["position_arr"][ 1]==$TPL_K4){?>selected<?php }?>><?php echo $TPL_K4?></option>
<?php }}?>
			</select>
			<select name="location_h[<?php echo $TPL_V2["option_seq"]?>][]" class="simple location_h" onchange="scmLocationSendData(this);" <?php if(!$TPL_V3["wh_seq"]){?>disabled style="background-color:#efefef;"<?php }?>>
<?php if(is_array($TPL_R4=$TPL_V3["location"][$TPL_V3["position_arr"][ 0]][$TPL_V3["position_arr"][ 1]])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?>
				<option value="<?php echo $TPL_K4?>" <?php if($TPL_V3["position_arr"][ 2]==$TPL_K4){?>selected<?php }?>><?php echo $TPL_K4?></option>
<?php }}?>
			</select>
<?php if($TPL_I3== 0){?>
			<span class="btn small"><button type="button" onclick="add_tmp_revision_data(this);">┿</button></span>
<?php }else{?>
			<span class="btn small"><button type="button" onclick="remove_tmp_revision_data(this);">━</button></span>
<?php }?>
		</div>
<?php }}?>
	</td>
<?php }?>
	<td class="its-td-align left pdl5 bg-pastelred" style="vertical-align:top;">
<?php if($TPL_VAR["tmpData"]["provider_seq"]== 1&&$TPL_VAR["scm_cfg"]["use"]=='Y'&&!$TPL_VAR["sellermode"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["revision"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
		<div class="stock-lay-<?php echo $TPL_V2["option_seq"]?> revision-row-<?php echo $TPL_V3["revision_seq"]?>" rseq="<?php echo $TPL_V3["revision_seq"]?>" style="height:25px;">
			<input type="text" size="3" name="stock[<?php echo $TPL_V2["option_seq"]?>][]" class="stock" style="width:40%;" value="<?php echo $TPL_V3["stock"]?>" <?php if(!$TPL_V3["wh_seq"]||!$TPL_VAR["scm_cfg"]["set_default_date"]){?>disabled<?php }?> onblur="domSaverSendData(this);"/>
<?php if($TPL_I2== 0&&$TPL_I3== 0&&$TPL_V1["option_use"]=='Y'){?>
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
		</div>
<?php }}?>
<?php }else{?>
		<input type="text" size="3" name="stock[<?php echo $TPL_V2["option_seq"]?>][]" class="stock" style="width:40%;" value="<?php echo $TPL_V2["stock"]?>" onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
<?php }?>
	</td>
	<td class="its-td-align left pdl5 bg-pastelred" style="vertical-align:top;">
<?php if($TPL_VAR["tmpData"]["provider_seq"]== 1&&$TPL_VAR["scm_cfg"]["use"]=='Y'&&!$TPL_VAR["sellermode"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["revision"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
		<div class="badstock-lay-<?php echo $TPL_V2["option_seq"]?> revision-row-<?php echo $TPL_V3["revision_seq"]?>" rseq="<?php echo $TPL_V3["revision_seq"]?>" style="height:25px;">
			<input type="text" size="3" name="badstock[<?php echo $TPL_V2["option_seq"]?>][]" class="badstock" style="width:40%;" value="<?php echo $TPL_V3["badstock"]?>" <?php if(!$TPL_V3["wh_seq"]||!$TPL_VAR["scm_cfg"]["set_default_date"]){?>disabled<?php }?> onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_I3== 0&&$TPL_V1["option_use"]=='Y'){?>
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
		</div>
<?php }}?>
<?php }else{?>
		<input type="text" size="3" name="badstock[<?php echo $TPL_V2["option_seq"]?>][]" class="badstock" style="width:40%;" value="<?php echo $TPL_V2["badstock"]?>" onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
<?php }?>
	</td>
	<td class="its-td-align left pdl5 bg-pastelred admin-box  <?php if($TPL_VAR["tmpData"]["provider_seq"]> 1){?>hide<?php }?>" style="vertical-align:top;">
<?php if($TPL_VAR["scm_cfg"]["use"]=='Y'&&!$TPL_VAR["sellermode"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["revision"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
		<div class="supplyprice-lay-<?php echo $TPL_V2["option_seq"]?> revision-row-<?php echo $TPL_V3["revision_seq"]?>" rseq="<?php echo $TPL_V3["revision_seq"]?>" style="height:25px;">
			<input type="text" size="3" name="supply_price[<?php echo $TPL_V2["option_seq"]?>][]" class="supply_price" style="width:40%;" value="<?php echo $TPL_V3["supply_price"]?>" <?php if(!$TPL_V3["wh_seq"]||!$TPL_VAR["scm_cfg"]["set_default_date"]){?>disabled<?php }?> onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_I3== 0&&$TPL_V1["option_use"]=='Y'){?>
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
		</div>
<?php }}?>
<?php }else{?>
		<input type="text" size="3" name="supply_price[<?php echo $TPL_V2["option_seq"]?>][]" class="supply_price" style="width:40%;" value="<?php echo $TPL_V2["supply_price"]?>" onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
<?php }?>
	</td>
	<td class="its-td-align left pdl5" style="vertical-align:top;">
		<input type="text" size="3" name="safe_stock[<?php echo $TPL_V2["option_seq"]?>]" class="safe_stock" style="width:40%;" value="<?php echo $TPL_V2["safe_stock"]?>" onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
	</td>
<?php if(serviceLimit('H_AD')){?>
	<td class="its-td-align right pdr5 seller-box <?php if($TPL_VAR["tmpData"]["provider_seq"]== 1){?>hide<?php }?>" style="vertical-align:top;">
		<span class="commission_price_lay"><?php echo number_format($TPL_V2["commission_price"], 2)?></span>
	</td>
	<td class="its-td-align left pdl5 seller-box <?php if($TPL_VAR["tmpData"]["provider_seq"]== 1){?>hide<?php }?>" style="vertical-align:top;">
<?php if($TPL_VAR["sellermode"]){?>
			<?php echo $TPL_V2["commission_rate"]?>

<?php if($TPL_V2["commission_type"]=='SUPR'){?>원<?php }else{?>%<?php }?>
<?php }else{?>
		<input type="text" size="3" name="commission_rate[<?php echo $TPL_V2["option_seq"]?>]" class="commission_rate" style="width:40%;" value="<?php echo $TPL_V2["commission_rate"]?>" onblur="calculate_commission(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
<?php }?>
	</td>
<?php }?>
	<td class="its-td-align left pdl5 bg-lightyellow" style="vertical-align:top;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td>
				<input type="text" size="10" name="consumer_price[<?php echo $TPL_V2["option_seq"]?>]" class="consumer_price" style="width:50%;" value="<?php echo $TPL_V2["consumer_price"]?>" onblur="calculate_commission(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
				<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
			</td>
			<td>
				<input type="text" size="10" name="price[<?php echo $TPL_V2["option_seq"]?>]" class="price" style="width:50%;"  value="<?php echo $TPL_V2["price"]?>" onblur="calculate_commission(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
				<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
			</td>
		</tr>
		</table>
	</td>
	<td class="its-td-align left pdl5" style="vertical-align:top;">
		<select name="option_view[<?php echo $TPL_V2["option_seq"]?>]" class="simple option_view"  onchange="domSaverSendData(this);">
			<option value="N" <?php if($TPL_V2["option_view"]=='N'){?>selected<?php }?>>N</option>
			<option value="Y" <?php if($TPL_V2["option_view"]=='Y'){?>selected<?php }?>>Y</option>
		</select>
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
	</td>
</tr>
<?php }}?>
<?php }}?>
</tbody>
</table>

<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>
<script type="text/javascript">
// 현재 옵션의 목록 HTML을 변경
function replace_option_list_row(){
	$('tr.option-row-<?php echo $TPL_VAR["goods_seq"]?>', parent.document).addClass('option-row-remove');
	$('tr.option-row-<?php echo $TPL_VAR["goods_seq"]?>', parent.document).last().after($('table#tmp_row_html tbody').html());
	$('tr.option-row-remove', parent.document).remove();

	parent.areaSetDefaultText($('tr.option-row-<?php echo $TPL_VAR["goods_seq"]?>', parent.document));
	process_result_msg();
}

// 상품 입력 폼 추가/삭제
function add_option_list_row(){
	$('tbody.quick-goods-regist-tbody', parent.document).append($('table#tmp_row_html tbody').html());
	parent.areaSetDefaultText($('tbody.quick-goods-regist-tbody', parent.document).find('tr.option-rows').last());
	process_result_msg();
}

// 상품 삭제
function remove_option_list_row(){
<?php if($TPL_removeGoods_1){foreach($TPL_VAR["removeGoods"] as $TPL_V1){?>
<?php if($TPL_V1> 0){?>
	$('tr.option-row-<?php echo $TPL_V1?>', parent.document).remove();
<?php }?>
<?php }}?>
	process_result_msg();
}

// 초기화 후 한줄 추가
function reset_option_list_row(){
	$('tbody.quick-goods-regist-tbody tr', parent.document).remove();
	add_option_list_row();
	process_result_msg();
}

// 처리 결과 메시지가 필요한 경우
function process_result_msg(){
<?php if($TPL_VAR["addResultMsg"]){?>
	parent.openDialogAlert('<?php echo $TPL_VAR["addResultMsg"]["msg"]?>', <?php echo $TPL_VAR["addResultMsg"]["width"]?>, <?php echo $TPL_VAR["addResultMsg"]["height"]?>, function(){});
<?php }?>
}

<?php echo $TPL_VAR["procJS"]?>

<?php if($TPL_VAR["popup_id"]){?>
parent.closeDialog('<?php echo $TPL_VAR["popup_id"]?>');
<?php }?>
parent.loadingStop();
</script>