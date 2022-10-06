<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/goods/_select_option_package.html 000015152 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php if($TPL_loop_1){$TPL_I1=-1;foreach($TPL_VAR["loop"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
<input type="hidden" name="group_seq" value="<?php echo $TPL_V1["group_seq"]?>">
<input type="hidden" name="goods_seq" value="<?php echo $TPL_V1["goods_seq"]?>">
<?php }?>
<input type="hidden" name="option_seq[]" value="<?php echo $TPL_V1["option_seq"]?>">
<input type="hidden" name="temp_seq[]" value="<?php echo $TPL_V1["temp_seq"]?>">
<?php }}?>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
<col width="15%"/><col width="85%"/>
<tr>
	<td valign="top">
		<table style="width:100%" id="option_select_form_table" cellpadding="0" cellspacing="0" border="0">
		<col width="100" />
<?php if(!$TPL_VAR["option_title_loop"]){?>
		<tr>
			<th class="th-option">필수옵션</th>
		</tr>
		<tr>
			<th class="th-option">기본</td>
		</tr>
		<tr>
			<td class="th-option">기본</td>
		</tr>
<?php }else{?>
		<tr>
			<th class="th-option">필수옵션</th>
		</tr>
<?php if($TPL_loop_1){$TPL_I1=-1;foreach($TPL_VAR["loop"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
		<tr>
			<th class="th-option">
				<span class="option-title hand" title="<?php if(is_array($TPL_R2=range( 0, 4))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?><?php if($TPL_V2== 0&&$TPL_VAR["option_title_loop"][$TPL_V2]){?><?php echo $TPL_V1["title1"]?><?php }elseif($TPL_VAR["option_title_loop"][$TPL_V2]){?> / <?php echo $TPL_V1["option_divide_title"][$TPL_V2]?><?php }?><?php }}?> ">
<?php if(is_array($TPL_R2=range( 0, 4))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2== 0&&$TPL_VAR["option_title_loop"][$TPL_V2]){?>
				<?php echo $TPL_V1["title1"]?>

<?php }elseif($TPL_VAR["option_title_loop"][$TPL_V2]){?>
				/ <?php echo $TPL_V1["option_divide_title"][$TPL_V2]?>

<?php }?>
<?php }}?>
				</span>
			</th>
		</tr>
<?php }?>
		<tr>
			<td class="td-option">
				<span class="option-value hand" title="<?php if(is_array($TPL_R2=range( 0, 4))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?><?php if($TPL_V2== 0&&$TPL_V1["opts"][$TPL_V2]){?><?php echo $TPL_V1["opts"][$TPL_V2]?><?php }elseif($TPL_V1["opts"][$TPL_V2]){?> / <?php echo $TPL_V1["opts"][$TPL_V2]?><?php }?><?php }}?>">
<?php if(is_array($TPL_R2=range( 0, 4))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2== 0&&$TPL_V1["opts"][$TPL_V2]){?>
				<?php echo $TPL_V1["opts"][$TPL_V2]?>

<?php }elseif($TPL_V1["opts"][$TPL_V2]){?>
				/ <?php echo $TPL_V1["opts"][$TPL_V2]?>

<?php }?>
<?php }}?>
				</span>
			</td>
		</tr>
<?php }}?>
<?php }?>
		</table>
	</td>
	<td valign="top">
		<table id="package_select_form_table1" style="width:100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th class="th-package1" colspan="<?php echo count($TPL_VAR["title_loop"])?>">실제 상품 : ‘상품(1)’열만은 필수적으로 연결하세요!</th>
		</tr>
		<tr>
<?php if(is_array($TPL_R1=range( 1, 5))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["title_loop"][$TPL_V1]){?>
			<th class="th-package1"  width="<?php echo ( 100/count($TPL_VAR["title_loop"]))?>%">
				<label><input type="checkbox" name="check_allpackage<?php echo $TPL_V1?>" value="<?php echo $TPL_V1?>" onclick="check_allpackage(<?php echo $TPL_V1?>,this)" class="check_allpackage" /> 상품(<?php echo $TPL_V1?>)</label>
			</th>
<?php }?>
<?php }}?>
		</tr>
		<tr>
<?php if($TPL_VAR["title_loop"][ 1]){?>
			<td class="td-package1">
				<table class="package_select_form_table2" style="width:100%">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
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
						<input type="hidden" name="package_option_seq1[]" class="package_option_seq" value="<?php echo $TPL_V1["package_option_seq1"]?>" />
						<input type="hidden" name="package_option_stock1[]" class="package_option_stock" value="<?php echo $TPL_V1["package_stock1"]?>" rstock="<?php echo $TPL_V1["package_ablestock1"]?>" badstock="<?php echo $TPL_V1["package_badstock1"]?>" safe_stock="<?php echo $TPL_V1["package_safe_stock1"]?>" />
						<div class="package_error">
<?php if($TPL_V1["error_msg1"]){?>
							<?php echo $TPL_V1["error_msg1"]?>

<?php }?>
						</div>
						<div class="pdt3">
							<span class="package_goods_seq1 package_goods_seq"><?php if($TPL_V1["package_goods_seq1"]){?>[<?php echo $TPL_V1["package_goods_seq1"]?>]<?php }?></span>
							<span class="package_goods_name1 package_goods_name hand" title="<?php echo $TPL_V1["package_goods_name1"]?>"><?php echo $TPL_V1["package_goods_name1"]?></span>
						</div>
						<div class="pdt3">
							<div class="package_option_name1 package_option_name hand" title="<?php echo $TPL_V1["package_option1"]?>"><?php echo $TPL_V1["package_option1"]?></div>
						</div>
					</td>
				</tr>
<?php }}?>
				</table>
			</td>
<?php }?>
<?php if($TPL_VAR["title_loop"][ 2]){?>
			<td class="td-package1">
				<table class="package_select_form_table2" style="width:100%">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
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
							<input type="checkbox" name="check_package_option2[]" class="check_package_option" value="2" />
						</label>
						<input type="hidden" name="package_option_seq2[]" class="package_option_seq" value="<?php echo $TPL_V1["package_option_seq2"]?>" />
						<input type="hidden" name="package_option_stock2[]" class="package_option_stock" value="<?php echo $TPL_V1["package_stock2"]?>" rstock="<?php echo $TPL_V1["package_ablestock2"]?>" badstock="<?php echo $TPL_V1["package_badstock2"]?>" safe_stock="<?php echo $TPL_V1["package_safe_stock2"]?>" />
						<div class="package_error">
<?php if($TPL_V1["error_msg2"]){?>
							<?php echo $TPL_V1["error_msg2"]?>

<?php }?>
						</div>
						<div class="pdt3">
							<span class="package_goods_seq2 package_goods_seq"><?php if($TPL_V1["package_goods_seq2"]){?>[<?php echo $TPL_V1["package_goods_seq2"]?>]<?php }?></span>
							<span class="package_goods_name2 package_goods_name hand" title="<?php echo $TPL_V1["package_goods_name2"]?>"><?php echo $TPL_V1["package_goods_name2"]?></span>
						</div>
						<div class="pdt3">
							<div class="package_option_name2 package_option_name hand" title="<?php echo $TPL_V1["package_option2"]?>"><?php echo $TPL_V1["package_option2"]?></div>
						</div>
					</td>
				</tr>
<?php }}?>
				</table>
			</td>
<?php }?>
<?php if($TPL_VAR["title_loop"][ 3]){?>
			<td class="td-package1">
				<table class="package_select_form_table2" style="width:100%">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
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
							<input type="checkbox" name="check_package_option3[]" class="check_package_option" value="3" />
						</label>
						<input type="hidden" name="package_option_seq3[]" class="package_option_seq" value="<?php echo $TPL_V1["package_option_seq3"]?>" />
						<input type="hidden" name="package_option_stock3[]" class="package_option_stock" value="<?php echo $TPL_V1["package_stock3"]?>" rstock="<?php echo $TPL_V1["package_ablestock3"]?>" badstock="<?php echo $TPL_V1["package_badstock3"]?>" safe_stock="<?php echo $TPL_V1["package_safe_stock3"]?>" />
						<div class="package_error">
<?php if($TPL_V1["error_msg3"]){?>
							<?php echo $TPL_V1["error_msg3"]?>

<?php }?>
						</div>
						<div class="pdt3">
							<span class="package_goods_seq3 package_goods_seq"><?php if($TPL_V1["package_goods_seq3"]){?>[<?php echo $TPL_V1["package_goods_seq3"]?>]<?php }?></span>
							<span class="package_goods_name3 package_goods_name hand" title="<?php echo $TPL_V1["package_goods_name3"]?>"><?php echo $TPL_V1["package_goods_name3"]?></span>
						</div>
						<div class="pdt3">
							<div class="package_option_name3 package_option_name hand" title="<?php echo $TPL_V1["package_option3"]?>"><?php echo $TPL_V1["package_option3"]?></div>
						</div>
					</td>
				</tr>
<?php }}?>
				</table>
			</td>
<?php }?>
<?php if($TPL_VAR["title_loop"][ 4]){?>
			<td class="td-package1">
				<table class="package_select_form_table2" style="width:100%">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
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
							<input type="checkbox" name="check_package_option4[]" class="check_package_option" value="4" />
						</label>
						<input type="hidden" name="package_option_seq4[]" class="package_option_seq" value="<?php echo $TPL_V1["package_option_seq4"]?>" />
						<input type="hidden" name="package_option_stock4[]" class="package_option_stock" value="<?php echo $TPL_V1["package_stock4"]?>" rstock="<?php echo $TPL_V1["package_ablestock4"]?>" badstock="<?php echo $TPL_V1["package_badstock4"]?>" safe_stock="<?php echo $TPL_V1["package_safe_stock4"]?>" />
						<div class="package_error">
<?php if($TPL_V1["error_msg4"]){?>
							<?php echo $TPL_V1["error_msg4"]?>

<?php }?>
						</div>
						<div class="pdt3">
							<span class="package_goods_seq4 package_goods_seq"><?php if($TPL_V1["package_goods_seq4"]){?>[<?php echo $TPL_V1["package_goods_seq4"]?>]<?php }?></span>
							<span class="package_goods_name4 package_goods_name hand" title="<?php echo $TPL_V1["package_goods_name4"]?>"><?php echo $TPL_V1["package_goods_name4"]?></span>
						</div>
						<div class="pdt3">
							<div class="package_option_name4 package_option_name hand" title="<?php echo $TPL_V1["package_option4"]?>"><?php echo $TPL_V1["package_option4"]?></div>
						</div>
					</td>
				</tr>
<?php }}?>
				</table>
			</td>
<?php }?>
<?php if($TPL_VAR["title_loop"][ 5]){?>
			<td class="td-package1">
				<table class="package_select_form_table2" style="width:100%">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
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
							<input type="checkbox" name="check_package_option5[]" class="check_package_option" value="5" />
						</label>
						<input type="hidden" name="package_option_seq5[]" class="package_option_seq" value="<?php echo $TPL_V1["package_option_seq5"]?>" />
						<input type="hidden" name="package_option_stock5[]" class="package_option_stock" value="<?php echo $TPL_V1["package_stock5"]?>" rstock="<?php echo $TPL_V1["package_ablestock5"]?>" badstock="<?php echo $TPL_V1["package_badstock5"]?>" safe_stock="<?php echo $TPL_V1["package_safe_stock5"]?>" />
						<div class="package_error">
<?php if($TPL_V1["error_msg5"]){?>
							<?php echo $TPL_V1["error_msg5"]?>

<?php }?>
						</div>
						<div class="pdt3">
							<span class="package_goods_seq5 package_goods_seq"><?php if($TPL_V1["package_goods_seq5"]){?>[<?php echo $TPL_V1["package_goods_seq5"]?>]<?php }?></span>
							<span class="package_goods_name5 package_goods_name hand" title="<?php echo $TPL_V1["package_goods_name5"]?>"><?php echo $TPL_V1["package_goods_name5"]?></span>
						</div>
						<div class="pdt3">
							<div class="package_option_name5 package_option_name hand" title="<?php echo $TPL_V1["package_option5"]?>"><?php echo $TPL_V1["package_option5"]?></div>
						</div>
					</td>
				</tr>
<?php }}?>
				</table>
			</td>
<?php }?>
		</tr>
		</table>
	</td>
</tr>
</table>
<script>
$("table.package_select_form_table2").sortable({items:'tr'});
// 필수옵션 미사용일 때
if( $("input[name='optionUse']").eq(0).is(":checked") ){
	var cellobj = $("table.reg_package_option_tbl tr td");
	var tobj = $("table#package_select_form_table1");
	var tmp_error = '';
	cellobj.each(function(idx){
		var tmp_error = '';
		var num = idx+1;
		var package_goods_name = $(this).find("span.reg_package_goods_name"+num).html();
		var package_goods_seq = $(this).find("span.reg_package_goods_seq"+num).html();
		var package_option = $(this).find("div.reg_package_option"+num).html();
		var package_unit_ea = $(this).find("input[name='package_unit_ea"+num+"[]']").val();
		var package_option_seq = $(this).find("input[name='reg_package_option_seq"+num+"[]']").val();
		var optseqObj = $(this).find(".reg_package_option_seq"+num);
		var stock = optseqObj.attr('stock');
		var rstock = optseqObj.attr('rstock');
		var badstock = optseqObj.attr('badstock');
		var safe_stock = optseqObj.attr('safe_stock');
		var targetObj = tobj.find("tr td.td-package1 table.package_select_form_table2").eq(idx);
		var tcellobj = targetObj.find("tr td").eq(1);
		var error = $(this).find("div.package_error").html();
		if(error) tmp_error = error.split('<\/script>');
		if(package_goods_name){
			tcellobj.find("input.package_option_seq").val(package_option_seq);
			tcellobj.find("input.package_option_stock").val(stock);
			tcellobj.find("input.package_option_stock").attr('stock',stock);
			tcellobj.find("input.package_option_stock").attr('rstock',rstock);
			tcellobj.find("input.package_option_stock").attr('badstock',badstock);
			tcellobj.find("input.package_option_stock").attr('safe_stock',safe_stock);
			tcellobj.find("span.package_goods_name").html(package_goods_name);
			tcellobj.find("div.package_option_name").html(package_option);
			tcellobj.find("span.package_goods_seq").html(package_goods_seq);
			tcellobj.find("div.package_error").html(tmp_error[1]);
		}
	});
}
</script>