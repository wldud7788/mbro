<?php /* Template_ 2.2.6 2022/05/17 12:29:12 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/select_goods_options_view.html 000002087 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<table class="info-table-style option-select-table" cellspacing="0">
	<colgroup>
		<col />
		<col width="130" />
	</colgroup>
	<thead class="lth">
		<tr>
			<th class="its-th-align center"><input type="checkbox" name="all_selected_option_seqs" value="1" onclick="package_toggle_option_all(this);"></th>
			<th class="its-th-align center">옵션</th>
			<th class="its-th-align center">정가 → 판매가</th>
		</tr>
	</thead>
	<tbody class="ltb">
<?php if($TPL_record_1){$TPL_I1=-1;foreach($TPL_VAR["record"] as $TPL_V1){$TPL_I1++;?>
		<tr class="list-row" style="height:35px;">
			<td class="its-td-align center">
				<input type="checkbox" name="selected_option_seqs[]" value="<?php echo $TPL_V1["option_seq"]?>" goods_name="<?php echo strip_tags($TPL_V1["goods_name"])?>" combine_option="<?php echo $TPL_V1["combine_option"]?>" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"
				stock="<?php echo $TPL_V1["stock"]?>"
				badstock="<?php echo $TPL_V1["badstock"]?>"
				safe_stock="<?php echo $TPL_V1["safe_stock"]?>"
				rstock="<?php echo $TPL_V1["rstock"]?>"
				optioncode="<?php echo $TPL_V1["option_codes"]?>"
				weight="<?php echo $TPL_V1["weight"]?>"
<?php if($TPL_I1== 0){?>checked<?php }?> onclick="package_toggle_option_color();"/>
			</td>
			<td class="its-td-align hand left pdl5" onclick="package_toggle_option(this);">
<?php if($TPL_V1["combine_option"]){?>
				<?php echo $TPL_V1["combine_option"]?>

<?php }else{?>
				기본옵션상품
<?php }?>
			</td>
			<td class="its-td-align hand right pdr5" onclick="package_toggle_option(this);">
				<?php echo number_format($TPL_V1["consumer_price"])?> → <?php echo number_format($TPL_V1["price"])?>

			</td>
		</tr>
<?php }}?>
	</tbody>
</table>
<script type="text/javascript">package_toggle_option_color();</script>