<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_set_extra_page_goods_light.html 000002135 */ ?>
<form name="navigationSettingForm" id="navigationSettingForm" method="post" target="actionFrame" action="../page_manager_process/save_subpage">
<input type="hidden" name="page_type" value="<?php echo $TPL_VAR["page_type"]?>"/>
<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
<?php if(is_array($TPL_R1=$TPL_VAR["data"]["filter_col"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	<tr class="list-row">
		<td class="its-td">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
			<label><input type="checkbox" name="search_filter[]" value="<?php echo $TPL_K2?>" <?php if(in_array($TPL_K2,$TPL_VAR["data"]["search_filter"])){?>checked<?php }?>/> <?php echo $TPL_V2?></label>
<?php }}?>
		</td>
	</tr>
<?php }}?>
<?php if(in_array('orderby',$TPL_VAR["data"]["allow"])){?>
	<tr class="list-row">
		<td class="its-td">
<?php if(is_array($TPL_VAR["data"]["order_col"])){?>
<?php if(is_array($TPL_R1=$TPL_VAR["data"]["order_col"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
				<label><input type="radio" name="orderby" value="<?php echo $TPL_K1?>" <?php if(in_array($TPL_K1,$TPL_VAR["data"]["orderby"])){?>checked<?php }?>/> <?php echo $TPL_V1?></label>
<?php }}?>
<?php }?>
		</td>
	</tr>
<?php }?>
<?php if(in_array('status',$TPL_VAR["data"]["allow"])){?>
	<tr class="list-row">
		<td class="its-td">
			<span class="pdr10"><?php echo $TPL_VAR["data"]["status"]["desc"]?></span>
<?php if(is_array($TPL_R1=$TPL_VAR["data"]["status"]["col"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
				<label><input type="checkbox" name="status[]" value="<?php echo $TPL_K1?>" <?php if(in_array($TPL_K1,$TPL_VAR["data"]["status"]["chk"])){?>checked<?php }?>/> <?php echo $TPL_V1?></label>
<?php }}?>
		</td>
	</tr>
<?php }?>
</table>

<div class="center pdt10"><span class="btn large black"><button type="submit">저장</button></span></div>

</form>