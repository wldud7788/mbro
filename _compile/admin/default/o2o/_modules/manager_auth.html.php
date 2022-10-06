<?php /* Template_ 2.2.6 2022/05/17 12:36:34 /www/music_brother_firstmall_kr/admin/skin/default/o2o/_modules/manager_auth.html 000000545 */ ?>
<tr>
		<th class="its-th">오프라인 매장</th>
		<td class="its-td" colspan="2">
<?php if(is_array($TPL_R1=code_load('auth_o2osetting'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<label class="resp_checkbox"><input type="checkbox" name="<?php echo $TPL_V1["codecd"]?>" value="Y" class="auth"/> <?php echo $TPL_V1["value"]?></label>
			&nbsp;&nbsp;&nbsp;
<?php }}?>
		</td>
	</tr>