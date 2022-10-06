<?php /* Template_ 2.2.6 2022/05/17 12:36:44 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_set_access_limit_list.html 000001545 */ 
$TPL_target_list_1=empty($TPL_VAR["target_list"])||!is_array($TPL_VAR["target_list"])?0:count($TPL_VAR["target_list"]);?>
<?php if($TPL_VAR["target_list"]){?>
<?php if($TPL_target_list_1){foreach($TPL_VAR["target_list"] as $TPL_K1=>$TPL_V1){?>
<tr>
	<td class="its-td-align center">
		<input type="checkbox" class="chk" name="code[]" value="<?php echo $TPL_K1?>" />
	</td>
	<td class="its-td-align center"><?php echo $TPL_V1["title"]?></td>
	<td class="its-td-align center">
<?php if($TPL_V1["grp_name"]||$TPL_V1["user_type"]){?>
		<?php echo implode(',',$TPL_V1["grp_name"])?><?php if($TPL_V1["grp_name"]&&$TPL_V1["user_type"]){?> | <?php }?><?php echo implode(',',$TPL_V1["user_type"])?>

<?php }else{?>
		모든 사용자
<?php }?>
	</td>
	<td class="its-td-align center">
<?php if($TPL_V1["catalog_allow"]=='period'){?>
		<?php echo $TPL_V1["catalog_allow_sdate"]?> ~ <?php echo $TPL_V1["catalog_allow_edate"]?>

<?php }elseif($TPL_V1["catalog_allow"]=='none'){?>
		금지
<?php }elseif($TPL_V1["catalog_allow"]=='show'){?>
		없음
<?php }?>
	</td>
</tr>
<?php }}?>
<?php }else{?>
<?php if($TPL_VAR["target_code"]){?>
<tr>
	<td class="its-td-align center" colspan="4">하위 목록이 없습니다.</td>
</tr>
<?php }else{?>
<tr>
	<td class="its-td-align center" colspan="4">대상을 먼저 선택하여 주세요.</td>
</tr>
<?php }?>
<?php }?>