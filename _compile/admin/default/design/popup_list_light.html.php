<?php /* Template_ 2.2.6 2022/05/17 12:31:38 /www/music_brother_firstmall_kr/admin/skin/default/design/popup_list_light.html 000003058 */ 
$TPL_popup_list_1=empty($TPL_VAR["popup_list"])||!is_array($TPL_VAR["popup_list"])?0:count($TPL_VAR["popup_list"]);?>
<div style="border:1px solid #000;">
	<table width="100%" class="info-table-style">
		<colgroup>
			<col width="55" />
			<col width="150" />
			<col width="" />
			<col width="" />
			<col width="240" />
			<col width="130" />
		</colgroup>
		<thead>
			<tr>
				<th class="its-th-align center">
					<label><input type="checkbox" name="chkall" value="" onclick="list_all_chk(this);" /> 번호</label>
				</th>
				<th class="its-th-align center">생성 일시</th>
				<th class="its-th-align center">관리용 타이틀 (노출여부)</th>
				<th class="its-th-align center">스타일</th>
				<th class="its-th-align center">치환코드</th>
				<th class="its-th-align center">관리</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["popup_list"]){?>
<?php if($TPL_popup_list_1){foreach($TPL_VAR["popup_list"] as $TPL_V1){?>
			<tr>
				<td class="its-td-align center"><input type="checkbox" class="chk_display" name="delete_popup_seq[]" value="<?php echo $TPL_V1["popup_seq"]?>" /> <?php echo $TPL_V1["popup_seq"]?></td>
				<td class="its-td-align center"><?php echo $TPL_V1["regdate"]?></td>
				<td class="its-td-align left">
					<span class="admin_comment" popup_seq="<?php echo $TPL_V1["popup_seq"]?>"><?php echo htmlspecialchars($TPL_V1["admin_comment"])?></span> <?php echo $TPL_V1["status_msg"]?>

				</td>
				<td class="its-td-align left">
<?php if($TPL_V1["style"]=='layer'){?>
					[팝업]
<?php if($TPL_V1["contents_type"]=='image'){?>
					Light Image Popup
<?php }elseif($TPL_V1["contents_type"]=='text'){?>
					Light Editor Popup
<?php }elseif($TPL_V1["contents_type"]=='slider'){?>
					Light Slider Popup
<?php }?>
<?php }else{?>
					[띠배너] Light Image LineBanner
<?php }?>
				</td>
				<td class="its-td-align center">
					&#123;=showDesignLightPopup(<?php echo $TPL_V1["popup_seq"]?>)&#125;
					<span class="btn small"><input type="button" value="태그복사" onclick="tag_clipboard_copy(<?php echo $TPL_V1["popup_seq"]?>);" /></span>
				</td>
				<td class="its-td-align center">
					<span class="btn small"><input type="button" value="복사" onclick="copy_popup('<?php echo $TPL_V1["popup_seq"]?>')" /></span>
					<span class="btn small"><input type="button" value="수정" onclick="edit_popup('<?php echo $TPL_V1["popup_seq"]?>','<?php echo $TPL_V1["style"]?>')" /></span>
					<span class="btn small red"><input type="button" value="삽입" onclick="insert_popup('<?php echo $TPL_V1["popup_seq"]?>','<?php echo $TPL_V1["image"]?>','<?php echo $TPL_V1["contents_type"]?>')" /></span>
				</td>
			</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td class="its-td-align center" colspan="6">등록된 띠배너/팝업 이 없습니다.</td>
			</tr>
<?php }?>
		</tbody>
	</table>
</div>