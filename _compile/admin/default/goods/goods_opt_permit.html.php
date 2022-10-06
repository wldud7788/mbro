<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/goods/goods_opt_permit.html 000005801 */ 
$TPL_otp_loop_1=empty($TPL_VAR["otp_loop"])||!is_array($TPL_VAR["otp_loop"])?0:count($TPL_VAR["otp_loop"]);
$TPL_sub_loop_1=empty($TPL_VAR["sub_loop"])||!is_array($TPL_VAR["sub_loop"])?0:count($TPL_VAR["sub_loop"]);?>
<div class="content">
	<div class="opt_area">
		<div class="item-title pdt0">필수옵션</div>
		<table class="info-table-style table_row_basic v2" style="width:99%">
		<thead>
		<tr>
<?php if(count($TPL_VAR["otp_loop"][ 0]["option_divide_title"])> 1){?>
			<th class="its-th-align center" colspan="<?php echo count($TPL_VAR["otp_loop"][ 0]["option_divide_title"])?>">옵션명</th>
<?php }else{?>
			<th class="its-th-align center" rowspan="2">옵션명</th>
<?php }?>
			<th class="its-th-align center" rowspan="2">정가</th>
			<th class="its-th-align center" rowspan="2">판매가</th>
<?php if($TPL_VAR["provider_seq"]> 1){?>
			<th class="its-th-align center" rowspan="2">정산<?php echo $TPL_VAR["commission_txt"]?></th>
			<th class="its-th-align center" rowspan="2">정산금액</th>
<?php }else{?>
			<th class="its-th-align center" rowspan="2">매입가</th>
			<th class="its-th-align center" rowspan="2">순매출</th>
<?php }?>
		</tr>
<?php if(count($TPL_VAR["otp_loop"][ 0]["option_divide_title"])> 1){?>
		<tr>
<?php if(is_array($TPL_R1=$TPL_VAR["otp_loop"][ 0]["option_divide_title"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<th class="its-th-align center"><?php echo $TPL_V1?></th>
<?php }}?>
		</tr>
<?php }?>
		</thead>
		<tbody>
<?php if($TPL_otp_loop_1){foreach($TPL_VAR["otp_loop"] as $TPL_V1){?>
		<tr>
<?php if(is_array($TPL_R2=$TPL_V1["opts"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<td class="its-td-align center"><?php echo $TPL_V2?></td>
<?php }}?>
			<td class="its-td-align center"><?php echo get_currency_price($TPL_V1["consumer_price"])?></td>
			<td class="its-td-align center"><?php echo get_currency_price($TPL_V1["price"])?></td>
<?php if($TPL_VAR["provider_seq"]> 1){?>
			<td class="its-td-align center">
<?php if($TPL_V1["commission_type"]=='SUPR'){?>
					<?php echo get_currency_price($TPL_V1["commission_rate"])?>

<?php }else{?>
					<?php echo $TPL_V1["commission_rate"]?>%
<?php }?></td>
			<td class="its-td-align center" <?php if($TPL_V1["chk_digit"]=='Y'){?>style="color:red;text-decoration:underline;"<?php }?>>
				<?php echo get_currency_price($TPL_V1["commission_price"])?>

			</td>
<?php }else{?>
			<td class="its-td-align center"><?php echo get_currency_price($TPL_V1["supply_price"])?></td>
			<td class="its-td-align center" <?php if($TPL_V1["chk_digit"]=='Y'){?>style="color:red;text-decoration:underline;"<?php }?>>
				<?php echo get_currency_price($TPL_V1["sales_rate"])?>

			</td>
<?php }?>
		</tr>
<?php }}?>
		</tbody>
		</table>

<?php if($TPL_VAR["sub_loop"]){?>
		<div class="item-title">추가옵션</div>
		<table class="info-table-style table_basic v7 v10 pd5" style="width:99%">
		<thead>
		<tr>
			<th class="its-th-align center" colspan="2">추가옵션</th>
			<th class="its-th-align center" rowspan="2">정가</th>
			<th class="its-th-align center" rowspan="2">판매가</th>
<?php if($TPL_VAR["provider_seq"]> 1){?>
			<th class="its-th-align center" rowspan="2">정산<?php echo $TPL_VAR["commission_txt"]?></th>
			<th class="its-th-align center" rowspan="2">정산금액</th>
<?php }else{?>
			<th class="its-th-align center" rowspan="2">매입가</th>
			<th class="its-th-align center" rowspan="2">순매출</th>
<?php }?>
		</tr>
		<tr>
			<th class="its-th-align center">옵션명</th>
			<th class="its-th-align center">옵션값</th>
		</tr>
		</thead>
		<tbody>
<?php if($TPL_sub_loop_1){foreach($TPL_VAR["sub_loop"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
		<tr>
			<td class="its-td-align center"><?php if($TPL_I2== 0){?><?php echo $TPL_V2["suboption_title"]?><?php }else{?>&nbsp;<?php }?></td>
			<td class="its-td-align center"><?php echo $TPL_V2["suboption"]?></td>
			<td class="its-td-align center"><?php echo get_currency_price($TPL_V2["consumer_price"])?></td>
			<td class="its-td-align center"><?php echo get_currency_price($TPL_V2["price"])?></td>
<?php if($TPL_VAR["provider_seq"]> 1){?>
			<td class="its-td-align center"><?php echo $TPL_V2["commission_rate"]?>%</td>
			<td class="its-td-align center" <?php if($TPL_V2["chk_digit"]=='Y'){?>style="color:red;text-decoration:underline;"<?php }?>>
				<?php echo get_currency_price($TPL_V2["commission_price"])?>

			</td>
<?php }else{?>
			<td class="its-td-align center"><?php echo get_currency_price($TPL_V2["supply_price"])?></td>
			<td class="its-td-align center" <?php if($TPL_V2["chk_digit"]=='Y'){?>style="color:red;text-decoration:underline;"<?php }?>>
				<?php echo get_currency_price($TPL_V2["sales_rate"])?>

			</td>
<?php }?>
		</tr>
<?php }}?>
<?php }}?>
		</tbody>
		</table>
<?php }?>
	</div>

	<div style="width:100%;text-align:center;margin-top:20px;">
		정가,판매가,정산금액을 확인해주세요.<br/>
<?php if($TPL_VAR["chk_all_digit"]){?>
		<div class="red">판매가보다 정산금액이 더 높은 역마진 상품은 빨간색 라인으로 표기되었습니다.</div>
<?php }?>
		상품을 승인으로 변경하시겠습니까?
	</div>
</div>
<div class="footer">
	<button type="button" onclick="closeDialog('goods_permit_lay');goods_save_submit();" class="resp_btn active size_XL"> 확인 </button>
	<button type="button" onclick="closeDialog('goods_permit_lay');" class="resp_btn v2 size_XL"> 취소 </button>
</div>