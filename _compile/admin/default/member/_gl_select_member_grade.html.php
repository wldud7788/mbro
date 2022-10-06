<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/member/_gl_select_member_grade.html 000002079 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<script type="text/javascript">
document.addEventListener('keydown', function(event) {
  if (event.keyCode === 13) {
    gMemberGradeSelect.searchMemberGrade(0);
  };
}, true);
</script>

<div class="content">
	<table class="table_basic member_grade_list">
		<colgroup>
			<col width="10%" />
			<col width="60%" />
			<col width="30%" />
		</colgroup>
		<thead>
			<tr class="nodrag nodrop">
				<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" title="전체선택"></label></th>
				<th>등급</th>
				<th>인원</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
			<tr rownum="<?php echo $TPL_V1["group_seq"]?>" <?php if(in_array($TPL_V1["group_seq"],$TPL_VAR["sc"]["select_lists"])){?>class="bg-gray"<?php }?>>
				<td class="center">
<?php if($TPL_VAR["sc"]["issued_seq"]||!in_array($TPL_V1["group_seq"],$TPL_VAR["sc"]["select_lists"])){?>
					<label class="resp_checkbox"><input type="checkbox" name="select_member_grade_seq[]" class="chk" value="<?php echo $TPL_V1["group_seq"]?>" <?php if(in_array($TPL_V1["group_seq"],$TPL_VAR["sc"]["select_lists"])){?>checked<?php }?>></label>
<?php }?>
					<input type="hidden" name="select_member_grade_title[]" grade_seq="<?php echo $TPL_V1["group_seq"]?>" value="<?php echo $TPL_V1["group_name"]?>">
				</td>
				<td class="center"><?php echo $TPL_V1["group_name"]?></td>
				<td class="center"><?php echo $TPL_V1["count"]?>명</td>
			</tr>
<?php }}?>
		</tbody>
	</table>

	<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>
</div>

<div class="footer">
	<button type="button" class="confirmSelectMemberGrade resp_btn active size_XL">선택</button>
	<button type="button" class="btnLayClose resp_btn v3 size_XL">닫기</button>
</div>