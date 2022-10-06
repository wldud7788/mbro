<?php /* Template_ 2.2.6 2022/05/17 12:31:33 /www/music_brother_firstmall_kr/admin/skin/default/design/banner_list_inc.html 000001722 */ 
$TPL_banner_list_1=empty($TPL_VAR["banner_list"])||!is_array($TPL_VAR["banner_list"])?0:count($TPL_VAR["banner_list"]);?>
<?php if($TPL_banner_list_1){foreach($TPL_VAR["banner_list"] as $TPL_V1){?>
	<tr>
		<td class="dlts-td center"><input type="checkbox" name="delete_banner_seq[]" value="<?php echo $TPL_V1["banner_seq"]?>" /> <?php echo $TPL_V1["banner_seq"]?></td>
		<td class="dlts-td left"><?php echo $TPL_V1["skin"]?> 스킨</td>
		<td class="dlts-td center"><?php echo substr($TPL_V1["regdate"], 0, 10)?></td>
		<td class="dlts-td center">
			<span class="admin_comment" banner_seq="<?php echo $TPL_V1["banner_seq"]?>"><?php echo $TPL_V1["name"]?></span>
		</td>
		<td class="dlts-td center">
			<?php echo $TPL_VAR["styles"][$TPL_V1["style"]]["name"]?>

		</td>
		<td class="dlts-td center">
			&#123;=showDesignBanner(<?php echo $TPL_V1["banner_seq"]?>)&#125;
<?php if($TPL_VAR["designWorkingSkin"]==$TPL_V1["skin"]){?>
			<span class="btn small"><input type="button" value="태그복사" onclick="tag_clipboard_copy(<?php echo $TPL_V1["banner_seq"]?>);" /></span>
<?php }?>
		</td>
		<td class="dlts-td center">
<?php if($TPL_VAR["designWorkingSkin"]==$TPL_V1["skin"]){?>
			<span class="btn small red"><input type="button" value="선택" onclick="select_banner('<?php echo $TPL_V1["banner_seq"]?>','<?php echo $TPL_V1["platform"]?>','<?php echo $TPL_V1["style"]?>')" /></span>
			<span class="btn small"><input type="button" value="수정" onclick="edit_banner('<?php echo $TPL_V1["banner_seq"]?>')" /></span>
<?php }?>
		</td>
	</tr>
<?php }}?>