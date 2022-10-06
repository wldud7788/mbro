<?php /* Template_ 2.2.6 2021/08/25 16:14:39 /www/music_brother_firstmall_kr/admin/skin/default/goods/_select_suboption_package.html 000004390 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_title_loop_1=empty($TPL_VAR["title_loop"])||!is_array($TPL_VAR["title_loop"])?0:count($TPL_VAR["title_loop"]);?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<input type="hidden" name="suboption_seq[]" value="<?php echo $TPL_V2["suboption_seq"]?>">
<input type="hidden" name="temp_seq[]" value="<?php echo $TPL_V2["tmp_no"]?>">
<?php }}?>
<?php }}?>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
<col width="15%"/><col width="85%"/>
<tr>
	<td valign="top">
		<table style="width:100%" id="option_select_form_table" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th class="th-option" colspan="2">추가옵션</th>
		</tr>
		<tr>
			<th class="th-option">옵션명</th>
			<th class="th-option">옵션값</th>
		</tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
		<tr>
			<td class="td-option">
<?php if($TPL_I2== 0){?>
				<span style="suboption-title hand" title="<?php echo $TPL_V2["suboption_title"]?>"><?php echo $TPL_V2["suboption_title"]?></span>
<?php }?>
			</td>
			<td class="td-option">
				<span style="suboption-value hand" title="<?php echo $TPL_V2["suboption"]?>"><?php echo $TPL_V2["suboption"]?></span>
			</td>
		</tr>
<?php }}?>
<?php }}?>
		</table>
	</td>
	<td valign="top">
		<table id="package_select_form_table1" style="width:100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th class="th-package1" colspan="<?php echo count($TPL_VAR["title_loop"])?>">실제 상품</th>
		</tr>
		<tr>
<?php if($TPL_title_loop_1){foreach($TPL_VAR["title_loop"] as $TPL_K1=>$TPL_V1){?>
			<th class="th-package1">
				<label><input type="checkbox" name="check_allpackage<?php echo $TPL_K1?>" value="<?php echo $TPL_K1?>" onclick="check_allpackage(<?php echo $TPL_K1?>,this)" /> 상품(<?php echo $TPL_K1?>)</label>
			</th>
<?php }}?>
		</tr>
		<tr>
<?php if($TPL_VAR["title_loop"][ 1]){?>
			<td class="td-package1">
				<table class="package_select_form_table2" style="width:100%">

<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<tr>
					<td>
						<div><img src="/admin/skin/default/images/common/icon_move.gif" /></div>
						<div class="pdt10">
							<span class="btn-minus">
								<button class="del_package_selected" type="button" onclick="del_package_selected(this);"></button>
							</span>
						</div>
					</td>
					<td>
						<label>
							<input type="checkbox" name="check_package_option1[]" class="check_package_option" value="1" />
						</label>
						<input type="hidden" name="package_option_seq1[]" class="package_option_seq" value="<?php echo $TPL_V2["package_option_seq1"]?>" />
<?php if($TPL_V2["error_msg1"]){?>
						<div class="package_error">
							<?php echo $TPL_V2["error_msg1"]?>

						</div>
<?php }?>
						<div class="pdt3">
							<span class="package_goods_seq1 package_goods_seq"><?php if($TPL_V2["package_goods_seq1"]){?>[<?php echo $TPL_V2["package_goods_seq1"]?>]<?php }?></span>
							<span class="package_goods_name1 package_goods_name hand" title="<?php echo $TPL_V2["package_goods_name1"]?>"><?php echo $TPL_V2["package_goods_name1"]?></span>
						</div>
						<div class="pdt3">
							<div class="package_option_name1 package_option_name hand" title="<?php echo $TPL_V2["package_option1"]?>"><?php echo $TPL_V2["package_option1"]?></div>
						</div>
						<div class="pdt3 hide">
							<div class="package_option_etc1 package_option_etc hand" title="<?php echo $TPL_V2["optioncode"]?>|<?php echo $TPL_V2["weight"]?>kg"><?php echo $TPL_V2["optioncode"]?>|<?php echo $TPL_V2["weight"]?>kg</div>
						</div>
					</td>
<?php }}?>
<?php }}?>
				</table>
			</td>
<?php }?>
		</tr>
		</table>
	</td>
</table>
<div style="height:50px;"></div>
<script>$("table.package_select_form_table2").sortable({items:'tr'});</script>