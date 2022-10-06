<?php /* Template_ 2.2.6 2022/05/17 12:29:13 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/shipping_group_view.html 000003827 */ 
$TPL_shipping_info_1=empty($TPL_VAR["shipping_info"])||!is_array($TPL_VAR["shipping_info"])?0:count($TPL_VAR["shipping_info"]);?>
<?php if($TPL_VAR["shipping_info"]){?>
<?php if($TPL_shipping_info_1){foreach($TPL_VAR["shipping_info"] as $TPL_V1){?>
<?php if($TPL_V1["shipping_provider_seq"]=='1'){?>
<tr>
	<td class="its-td-align center" style="height:30px;">위탁</td>
	<td class="its-td-align center" colspan="10">본사가 배송합니다.</td>
<?php }else{?>
<tr>
	<td class="its-td-align center" <?php if($TPL_V1["setting_cnt"]){?>rowspan="<?php echo $TPL_V1["setting_cnt"]?>"<?php }?>>
		<?php echo $TPL_V1["shipping_group_name"]?> (<?php echo $TPL_V1["shipping_group_seq"]?>)
<?php if($TPL_V1["default_yn"]=='Y'){?>
		<span class="basic_black_box">기본</span>
<?php }?>
	</td>
	<td class="its-td-align center" <?php if($TPL_V1["setting_cnt"]){?>rowspan="<?php echo $TPL_V1["setting_cnt"]?>"<?php }?>>
		<?php echo $TPL_V1["calcul_type_txt"]?>계산
<?php if($TPL_V1["shipping_calcul_free_yn"]=='Y'){?>
		<br/>(무료화)
<?php }?>
	</td>
<?php if(is_array($TPL_R2=$TPL_V1["setting"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_K2=>$TPL_V2){$TPL_I2++;?>
	<td class="its-td-align center"  rowspan="<?php echo count($TPL_V2)?>">
<?php if($TPL_K2=='korea'){?>대한민국<?php }else{?>해외국가<?php }?>
	</td>
<?php if(is_array($TPL_R3=$TPL_V2)&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
<?php if($TPL_I3> 0){?>
<tr>
<?php }?>
	<td class="its-td ship-bg" height="45px">
<?php if($TPL_V3["shipping_set_code"]=='direct_store'){?>
		<input type="hidden" class="direct_store_use" value="1" />
<?php }?>
		<?php echo $TPL_V3["shipping_set_name"]?>

<?php if($TPL_V3["set_code_txt"]){?>
		(<?php echo $TPL_V3["set_code_txt"]?>)
<?php }?>
<?php if($TPL_V3["default_yn"]=='Y'){?>
		<span class="basic_black_box">기본</span>
<?php }?>
	</td>
	<td class="its-td-align center ship-bg">
<?php if($TPL_V3["shipping_set_code"]!='direct_store'){?>
		<span class="highlight-link hand" onclick="ship_desc_pop('<?php echo $TPL_V3["shipping_set_seq"]?>');">배송안내</span>
<?php }else{?>
		<span class="gray">배송안내</span>
<?php }?>
	</td>
	<td class="its-td ship-bg"><?php echo $TPL_V3["stdtxt"]?></td>
	<td class="its-td ship-bg"><?php echo $TPL_V3["addtxt"]?></td>
	<td class="its-td ship-bg"><?php echo $TPL_V3["hoptxt"]?></td>
	<td class="its-td ship-bg"><?php echo $TPL_V3["storetxt"]?></td>
	<td class="its-td ship-bg"><?php echo $TPL_V3["prepay_info_txt"]?></td>
<?php if($TPL_I2== 0&&$TPL_I3== 0){?>
	<td class="its-td-align center" rowspan="<?php echo (count($TPL_V1["setting"]['korea'])+count($TPL_V1["setting"]['global']))?>">
		<span class="btn small valign-middle"><input name="modify_btn" onclick="window.open('../goods/package_catalog?ship_grp_seq=<?php echo $TPL_V1["shipping_group_seq"]?>');" type="button" value="패키지 : <?php echo $TPL_V1["package_cnt"]?>개" style="width:85px;"></span>
		<div style="height:5px;"></div>
		<span class="btn small valign-middle"><input name="modify_btn" onclick="window.open('../goods/catalog?ship_grp_seq=<?php echo $TPL_V1["shipping_group_seq"]?>');" type="button" value="실물상품 : <?php echo $TPL_V1["goods_cnt"]?>개" style="width:85px;"></span>
		<div style="height:5px;"></div>
		<span class="btn small valign-middle"><input name="modify_btn" onclick="window.open('../setting/shipping_group_regist?shipping_group_seq=<?php echo $TPL_V1["shipping_group_seq"]?>');" type="button" value="상세" style="width:85px;"></span>
	</td>
<?php }?>
</tr>
<?php }}?>
<?php }}?>
<?php }?>
</tr>
<?php }}?>
<?php }?>