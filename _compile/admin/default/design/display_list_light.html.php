<?php /* Template_ 2.2.6 2022/05/17 12:31:34 /www/music_brother_firstmall_kr/admin/skin/default/design/display_list_light.html 000003340 */ ?>
<div style="border:1px solid #333;">
	<table width="100%" class="info-table-style">
		<colgroup>
			<col width="80" />
			<col width="150" />
			<col width="" />
			<col width="150" />
			<col width="250" />
			<col width="130" />
		</colgroup>
		<thead>
			<tr>
				<th class="its-th-align center">
					<label><input type="checkbox" name="chkall" value="" onclick="list_all_chk(this);" /> 번호</label>
				</th>
				<th class="its-th-align center">생성 일시</th>
				<th class="its-th-align center">관리용 타이틀</th>
				<th class="its-th-align center">스타일</th>
				<th class="its-th-align center">치환코드</th>
				<th class="its-th-align center">관리</th>
			</tr>
		</thead>
		<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["display_list"]["record"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<tr>
				<td class="its-td-align center"><?php if($TPL_V1["display_seq"]> 10){?><input type="checkbox" class="chk_display" name="delete_display_seq[]" value="<?php echo $TPL_V1["display_seq"]?>" /><?php }?> <?php echo $TPL_V1["display_seq"]?></td>
				<td class="its-td-align center"><?php echo $TPL_V1["regdate"]?></td>
				<td class="its-td-align left">
					<div class="admin_comment" display_seq="<?php echo $TPL_V1["display_seq"]?>"><?php echo htmlspecialchars($TPL_V1["admin_comment"])?></div>
					<span><?php echo $TPL_V1["title"]?></span>
				</td>
				<td class="its-td-align center select_style" display_seq="<?php echo $TPL_V1["display_seq"]?>">
<?php if($TPL_VAR["styles"][$TPL_V1["style"]]["custom"]){?>
						<div class="desc">[추가 스타일]</div>
						<?php echo $TPL_V1["style"]?>

<?php }else{?>
						<?php echo $TPL_VAR["styles"][$TPL_V1["style"]]["name"]?>

<?php }?>
				</td>
				<td class="its-td-align center">
					&#123;=showDesignDisplay(<?php echo $TPL_V1["display_seq"]?>)&#125;
					<span class="btn small"><input type="button" value="태그복사" onclick="tag_clipboard_copy(<?php echo $TPL_V1["display_seq"]?>);" /></span>
				</td>
				<td class="its-td-align center">
					<span class="btn small"><input type="button" value="복사" onclick="copy_display('<?php echo $TPL_V1["display_seq"]?>')" /></span>
					<span class="btn small"><input type="button" value="수정" onclick="edit_display('<?php echo $TPL_V1["display_seq"]?>', '<?php echo $TPL_V1["kind"]?>')" /></span>
					<span class="btn small red">
<?php if($TPL_V1["platform"]!='mobile'){?>
						<input type="button" value="삽입" onclick="select_display('<?php echo $TPL_V1["display_seq"]?>','<?php echo $TPL_V1["image"]?>','<?php echo $TPL_V1["style"]?>','pc')" />
<?php }else{?>
						<input type="button" value="삽입" onclick="select_display('<?php echo $TPL_V1["display_seq"]?>','<?php echo $TPL_V1["image"]?>','<?php echo $TPL_V1["style"]?>','mobile')" />
<?php }?>
					</span>
				</td>
			</tr>
<?php }}else{?>
			<tr>
				<td class="its-td-align center" colspan="6">검색된 결과가 없습니다.</td>
			</tr>
<?php }?>
		</tbody>
	</table>
</div>
<?php if($TPL_VAR["pagin"]){?>
<div class="paging_navigation" style="margin-bottom:0;"><?php echo $TPL_VAR["pagin"]?></div>
<?php }?>