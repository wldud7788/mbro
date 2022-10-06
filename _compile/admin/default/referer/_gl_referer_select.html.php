<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/referer/_gl_referer_select.html 000001957 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<script type="text/javascript">
document.addEventListener('keydown', function(event) {
  if (event.keyCode === 13) {
    gMemberGradeSelect.searchMemberGrade(1);
  };
}, true);
</script>

<div class="content">
	<table class="table_basic referersale_list">
		<colgroup>
			<col width="15%" />
			<col width="85%" />
		</colgroup>
		<thead>
			<tr class="nodrag nodrop">
				<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" title="전체선택"></label></th>
				<th>유입경로명</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
			<tr rownum="<?php echo $TPL_V1["referersale_seq"]?>" <?php if(in_array($TPL_V1["referersale_seq"],$TPL_VAR["sc"]["select_lists"])){?>class="bg-gray"<?php }?>>
				<td class="center">
<?php if(!in_array($TPL_V1["referersale_seq"],$TPL_VAR["sc"]["select_lists"])){?>
					<label class="resp_checkbox"><input type="checkbox" name="select_referersale_seq[]" class="chk" value="<?php echo $TPL_V1["referersale_seq"]?>"></label>
					<input type="hidden" name="select_referersale_name[]" value="<?php echo $TPL_V1["referersale_name"]?>">
<?php }?>
				</td>
				<td><?php echo $TPL_V1["referersale_name"]?> </td>
			</tr>
<?php }}else{?>
			<tr>
				<td colspan="2" class="center">					
					유입 경로 할인이 없습니다.
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>

	<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>	
</div>

<div class="footer">
	<button type="button" class="confirmSelectReferer resp_btn active size_XL">선택</button>
	<button type="button" class="btnLayClose resp_btn v3 size_XL">닫기</button>
</div>