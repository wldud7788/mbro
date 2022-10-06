<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/member/withdrawal_pop.html 000000536 */ ?>
<table class="table_basic thl">		
	<colgroup>
		<col width="23%" />					
		<col />	
	</colgroup>

	<tr>
		<th>탈퇴 사유</th>
		<td><?php echo $TPL_VAR["reason"]?></div>
		</td>
	</tr>
	
	<tr>
		<th>내용</th>
		<td><?php echo $TPL_VAR["memo"]?></td>
	</tr>
</table>

<div class="footer">
	<a onclick="closeDialog('viewMemo')" class="resp_btn v3 size_XL">닫기</a>
</div>