<?php /* Template_ 2.2.6 2022/05/17 12:36:46 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/page_layout_list.html 000011194 */ 
$TPL_all_target_1=empty($TPL_VAR["all_target"])||!is_array($TPL_VAR["all_target"])?0:count($TPL_VAR["all_target"]);?>
<?php if($TPL_VAR["all_target"]){?>
<?php if($TPL_all_target_1){$TPL_I1=-1;foreach($TPL_VAR["all_target"] as $TPL_V1){$TPL_I1++;?>
<tr class="list-row" style="height:50px;">
<?php if($TPL_VAR["all_target_cnt"][$TPL_V1["category_code"]]> 0){?>
	<td class="its-td code_area" rowspan="<?php echo $TPL_VAR["all_target_cnt"][$TPL_V1["category_code"]]?>">
		<div class="wp49 codenm_<?php echo $TPL_V1["category_code"]?>"><?php if(!empty($TPL_VAR["name_arr"])){?><a href="javascript:viewCtrlBtn('<?php echo $TPL_V1["category_code"]?>');"><?php echo $TPL_VAR["name_arr"][$TPL_V1["category_code"]]?></a><?php }else{?><?php echo $TPL_V1["name"]?><?php }?> <span class="desc_code"><?php echo $TPL_V1["category_code"]?></span></div>

<?php if($TPL_VAR["grp_ctrl_arr"][$TPL_V1["category_code"]]){?>
		<div class="right wp49">
<?php if($TPL_VAR["grp_ctrl_use"]){?>
			<div class="pdr10 highlight-link hand" onclick="getCtrlBtn('<?php echo $TPL_V1["category_code"]?>')">
<?php }else{?>
				<div class="pdr10 highlight-link">
<?php }?>
<?php if(is_array($TPL_VAR["grp_ctrl_txt"])){?>
					<?php echo $TPL_VAR["grp_ctrl_txt"][$TPL_VAR["grp_ctrl_arr"][$TPL_V1["category_code"]]["grp_ctrl_type"]]?>

<?php }else{?>
					<?php echo $TPL_VAR["grp_ctrl_txt"]?>

<?php }?>
				</div>
			</div>
<?php }?>

	</td>
<?php if(is_array($TPL_R2=$TPL_V1["childs"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_VAR["all_target_cnt"][$TPL_V2["category_code"]]> 0){?>
	<td class="its-td code_area" rowspan="<?php echo $TPL_VAR["all_target_cnt"][$TPL_V2["category_code"]]?>">
		<div class="wp49 codenm_<?php echo $TPL_V2["category_code"]?>"><?php if(!empty($TPL_VAR["name_arr"])){?><a href="javascript:viewCtrlBtn('<?php echo $TPL_V2["category_code"]?>');"><?php echo $TPL_VAR["name_arr"][$TPL_V2["category_code"]]?></a><?php }else{?><?php echo $TPL_V2["name"]?><?php }?> <span class="desc_code"><?php echo $TPL_V2["category_code"]?></span></div>
<?php if($TPL_VAR["grp_ctrl_arr"][$TPL_V2["category_code"]]){?>
		<div class="right wp49">
<?php if($TPL_VAR["grp_ctrl_use"]){?>
			<div class="pdr10 highlight-link hand" onclick="getCtrlBtn('<?php echo $TPL_V2["category_code"]?>')">
<?php }else{?>
				<div class="pdr10 highlight-link">
<?php }?>
<?php if(is_array($TPL_VAR["grp_ctrl_txt"])){?>
					<?php echo $TPL_VAR["grp_ctrl_txt"][$TPL_VAR["grp_ctrl_arr"][$TPL_V2["category_code"]]["grp_ctrl_type"]]?>

<?php }else{?>
					<?php echo $TPL_VAR["grp_ctrl_txt"]?>

<?php }?>
				</div>
			</div>
<?php }?>
	</td>
<?php if(is_array($TPL_R3=$TPL_V2["childs"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
<?php if($TPL_VAR["all_target_cnt"][$TPL_V3["category_code"]]> 0){?>
	<td class="its-td code_area" rowspan="<?php echo $TPL_VAR["all_target_cnt"][$TPL_V3["category_code"]]?>">
		<div class="wp49 codenm_<?php echo $TPL_V3["category_code"]?>"><?php if(!empty($TPL_VAR["name_arr"])){?><a href="javascript:viewCtrlBtn('<?php echo $TPL_V3["category_code"]?>');"><?php echo $TPL_VAR["name_arr"][$TPL_V3["category_code"]]?></a><?php }else{?><?php echo $TPL_V3["name"]?><?php }?> <span class="desc_code"><?php echo $TPL_V3["category_code"]?></span></div>
<?php if($TPL_VAR["grp_ctrl_arr"][$TPL_V3["category_code"]]){?>
		<div class="right wp49">
<?php if($TPL_VAR["grp_ctrl_use"]){?>
			<div class="pdr10 highlight-link hand" onclick="getCtrlBtn('<?php echo $TPL_V3["category_code"]?>')">
<?php }else{?>
				<div class="pdr10 highlight-link">
<?php }?>
<?php if(is_array($TPL_VAR["grp_ctrl_txt"])){?>
					<?php echo $TPL_VAR["grp_ctrl_txt"][$TPL_VAR["grp_ctrl_arr"][$TPL_V3["category_code"]]["grp_ctrl_type"]]?>

<?php }else{?>
					<?php echo $TPL_VAR["grp_ctrl_txt"]?>

<?php }?>
				</div>
			</div>
<?php }?>
	</td>
<?php if(is_array($TPL_R4=$TPL_V3["childs"])&&!empty($TPL_R4)){$TPL_I4=-1;foreach($TPL_R4 as $TPL_V4){$TPL_I4++;?>
	<td class="its-td code_area">
		<div class="wp49 codenm_<?php echo $TPL_V4["category_code"]?>"><?php if(!empty($TPL_VAR["name_arr"])){?><a href="javascript:viewCtrlBtn('<?php echo $TPL_V4["category_code"]?>');"><?php echo $TPL_VAR["name_arr"][$TPL_V4["category_code"]]?></a><?php }else{?><?php echo $TPL_V4["name"]?><?php }?> <span class="desc_code"><?php echo $TPL_V4["category_code"]?></span></div>
<?php if($TPL_VAR["grp_ctrl_arr"][$TPL_V4["category_code"]]){?>
		<div class="right wp49">
<?php if($TPL_VAR["grp_ctrl_use"]){?>
			<div class="pdr10 highlight-link hand" onclick="getCtrlBtn('<?php echo $TPL_V4["category_code"]?>')">
<?php }else{?>
				<div class="pdr10 highlight-link">
<?php }?>
<?php if(is_array($TPL_VAR["grp_ctrl_txt"])){?>
					<?php echo $TPL_VAR["grp_ctrl_txt"][$TPL_VAR["grp_ctrl_arr"][$TPL_V4["category_code"]]["grp_ctrl_type"]]?>

<?php }else{?>
					<?php echo $TPL_VAR["grp_ctrl_txt"]?>

<?php }?>
				</div>
			</div>
<?php }?>
	</td>
<?php if($TPL_VAR["is_extra_col"]){?>
<?php if(is_array($TPL_VAR["extra_col_txt"])&&($TPL_I2+$TPL_I3+$TPL_I4)== 0){?>
	<td class="its-td center" <?php if($TPL_VAR["all_target_cnt"][$TPL_V1["category_code"]]> 0){?>rowspan="<?php echo $TPL_VAR["all_target_cnt"][$TPL_V1["category_code"]]?>"<?php }?> style="vertical-align:middle;"><?php echo $TPL_VAR["extra_col_txt"][$TPL_V1["category_code"]]?></td>
<?php }elseif(!is_array($TPL_VAR["extra_col_txt"])&&($TPL_I1+$TPL_I2+$TPL_I3+$TPL_I4)== 0){?>
	<td class="its-td center" rowspan="<?php echo $TPL_VAR["all_rowspan"]?>" style="vertical-align:middle;"><?php echo $TPL_VAR["extra_col_txt"]?></td>
<?php }?>
<?php }?>
</tr>
<?php }}?>
<?php }else{?>
<td class="its-td code_area">
	<div class="wp49 codenm_<?php echo $TPL_V3["category_code"]?>"><?php if(!empty($TPL_VAR["name_arr"])){?><a href="javascript:viewCtrlBtn('<?php echo $TPL_V3["category_code"]?>');"><?php echo $TPL_VAR["name_arr"][$TPL_V3["category_code"]]?></a><?php }else{?><?php echo $TPL_V3["name"]?><?php }?> <span class="desc_code"><?php echo $TPL_V3["category_code"]?></span></div>
<?php if($TPL_VAR["grp_ctrl_arr"][$TPL_V3["category_code"]]){?>
	<div class="right wp49">
<?php if($TPL_VAR["grp_ctrl_use"]){?>
		<div class="pdr10 highlight-link hand" onclick="getCtrlBtn('<?php echo $TPL_V3["category_code"]?>')">
<?php }else{?>
			<div class="pdr10 highlight-link">
<?php }?>
<?php if(is_array($TPL_VAR["grp_ctrl_txt"])){?>
				<?php echo $TPL_VAR["grp_ctrl_txt"][$TPL_VAR["grp_ctrl_arr"][$TPL_V3["category_code"]]["grp_ctrl_type"]]?>

<?php }else{?>
				<?php echo $TPL_VAR["grp_ctrl_txt"]?>

<?php }?>
			</div>
		</div>
<?php }?>
</td>
<td class="its-td">&nbsp;</td>
<?php if($TPL_VAR["is_extra_col"]){?>
<?php if(is_array($TPL_VAR["extra_col_txt"])&&($TPL_I2+$TPL_I3)== 0){?>
<td class="its-td center" <?php if($TPL_VAR["all_target_cnt"][$TPL_V1["category_code"]]> 0){?>rowspan="<?php echo $TPL_VAR["all_target_cnt"][$TPL_V1["category_code"]]?>"<?php }?> style="vertical-align:middle;"><?php echo $TPL_VAR["extra_col_txt"][$TPL_V1["category_code"]]?></td>
<?php }elseif(!is_array($TPL_VAR["extra_col_txt"])&&($TPL_I1+$TPL_I2+$TPL_I3)== 0){?>
<td class="its-td center" rowspan="<?php echo $TPL_VAR["all_rowspan"]?>" style="vertical-align:middle;"><?php echo $TPL_VAR["extra_col_txt"]?></td>
<?php }?>
<?php }?>
</tr>
<?php }?>
<?php }}?>
<?php }else{?>
<td class="its-td code_area">
	<div class="wp49 codenm_<?php echo $TPL_V2["category_code"]?>"><?php if(!empty($TPL_VAR["name_arr"])){?><a href="javascript:viewCtrlBtn('<?php echo $TPL_V2["category_code"]?>');"><?php echo $TPL_VAR["name_arr"][$TPL_V2["category_code"]]?></a><?php }else{?><?php echo $TPL_V2["name"]?><?php }?> <span class="desc_code"><?php echo $TPL_V2["category_code"]?></span></div>
<?php if($TPL_VAR["grp_ctrl_arr"][$TPL_V2["category_code"]]){?>
	<div class="right wp49">
<?php if($TPL_VAR["grp_ctrl_use"]){?>
		<div class="pdr10 highlight-link hand" onclick="getCtrlBtn('<?php echo $TPL_V2["category_code"]?>')">
<?php }else{?>
			<div class="pdr10 highlight-link">
<?php }?>
<?php if(is_array($TPL_VAR["grp_ctrl_txt"])){?>
				<?php echo $TPL_VAR["grp_ctrl_txt"][$TPL_VAR["grp_ctrl_arr"][$TPL_V2["category_code"]]["grp_ctrl_type"]]?>

<?php }else{?>
				<?php echo $TPL_VAR["grp_ctrl_txt"]?>

<?php }?>
			</div>
		</div>
<?php }?>
</td>
<td class="its-td">&nbsp;</td>
<td class="its-td">&nbsp;</td>
<?php if($TPL_VAR["is_extra_col"]){?>
<?php if(is_array($TPL_VAR["extra_col_txt"])&&($TPL_I2)== 0){?>
<td class="its-td center" <?php if($TPL_VAR["all_target_cnt"][$TPL_V1["category_code"]]> 0){?>rowspan="<?php echo $TPL_VAR["all_target_cnt"][$TPL_V1["category_code"]]?>"<?php }?> style="vertical-align:middle;"><?php echo $TPL_VAR["extra_col_txt"][$TPL_V1["category_code"]]?></td>
<?php }elseif(!is_array($TPL_VAR["extra_col_txt"])&&($TPL_I1+$TPL_I2)== 0){?>
<td class="its-td center" rowspan="<?php echo $TPL_VAR["all_rowspan"]?>" style="vertical-align:middle;"><?php echo $TPL_VAR["extra_col_txt"]?></td>
<?php }?>
<?php }?>
</tr>
<?php }?>
<?php }}?>
<?php }else{?>
<td class="its-td code_area">
	<div class="wp49 codenm_<?php echo $TPL_V1["category_code"]?>"><?php if(!empty($TPL_VAR["name_arr"])){?><a href="javascript:viewCtrlBtn('<?php echo $TPL_V1["category_code"]?>');"><?php echo $TPL_VAR["name_arr"][$TPL_V1["category_code"]]?></a><?php }else{?><?php echo $TPL_V1["name"]?><?php }?> <span class="desc_code"><?php echo $TPL_V1["category_code"]?></span></div>
<?php if($TPL_VAR["grp_ctrl_arr"][$TPL_V1["category_code"]]){?>
	<div class="right wp49">
<?php if($TPL_VAR["grp_ctrl_use"]){?>
		<div class="pdr10 highlight-link hand" onclick="getCtrlBtn('<?php echo $TPL_V1["category_code"]?>')">
<?php }else{?>
			<div class="pdr10 highlight-link">
<?php }?>
<?php if(is_array($TPL_VAR["grp_ctrl_txt"])){?>
				<?php echo $TPL_VAR["grp_ctrl_txt"][$TPL_VAR["grp_ctrl_arr"][$TPL_V1["category_code"]]["grp_ctrl_type"]]?>

<?php }else{?>
				<?php echo $TPL_VAR["grp_ctrl_txt"]?>

<?php }?>
			</div>
		</div>
<?php }?>
</td>
<td class="its-td">&nbsp;</td>
<td class="its-td">&nbsp;</td>
<td class="its-td">&nbsp;</td>
<?php if($TPL_VAR["is_extra_col"]){?>
<?php if(is_array($TPL_VAR["extra_col_txt"])){?>
<td class="its-td center" <?php if($TPL_VAR["all_target_cnt"][$TPL_V1["category_code"]]> 0){?>rowspan="<?php echo $TPL_VAR["all_target_cnt"][$TPL_V1["category_code"]]?>"<?php }?> style="vertical-align:middle;"><?php echo $TPL_VAR["extra_col_txt"][$TPL_V1["category_code"]]?></td>
<?php }elseif(!is_array($TPL_VAR["extra_col_txt"])&&$TPL_I1== 0){?>
<td class="its-td center" rowspan="<?php echo $TPL_VAR["all_rowspan"]?>" style="vertical-align:middle;"><?php echo $TPL_VAR["extra_col_txt"]?></td>
<?php }?>
<?php }?>
</tr>
<?php }?>
<?php }}?>
<?php }else{?>
<tr class="list-row">
	<td class="its-td center" colspan="5">등록된 <?php echo $TPL_VAR["page_name"]?>가 없습니다.</td>
</tr>
<?php }?>