<?php /* Template_ 2.2.6 2022/05/17 12:05:24 /www/music_brother_firstmall_kr/admincrm/skin/default/member/log_memo.html 000001521 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<div class="orderTitle">로그/메모</div>
<table class="info-table-style" style="width:100%; border-top:none;">
	<colgroup>
		<col width="100%" />
	</colgroup>
	<thead>
		<tr>
			<th class="its-th-align center">처리 로그</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td valign="top" style="overflow:hidden;">
				<div style="overflow:auto;width:99.4%;height:120px;padding:5px; background:#f7f7f7"><?php echo $TPL_VAR["admin_log"]?></div>
				<textarea name="admin_log" style="display:none;"><?php echo $TPL_VAR["admin_log"]?></textarea>
			</td>
		</tr>
	</tbody>
</table>
<div style="height:20px;"></div>
<form name="memoFrm" method="post" action="../member_process/save_memo" target="actionFrame">
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="100%" />
	</colgroup>
	<thead>
		<tr>
			<th class="its-th-align center">관리 메모</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td valign="top" style="overflow:hidden;">
				<textarea name="admin_memo" style="width:99.4%;height:120px;"><?php echo $TPL_VAR["admin_memo"]?></textarea>
			</td>
		</tr>
	</tbody>
</table>
<div class="pdt20 center"><span class="btn_crm_search"><button type="submit">등록<span class="arrow"></span></button></div>
</form>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>