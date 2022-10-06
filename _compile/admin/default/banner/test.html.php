<?php /* Template_ 2.2.6 2021/03/09 13:10:02 /www/music_brother_firstmall_kr/admin/skin/default/banner/test.html 000001224 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<div id="page-title-bar-area">
	<div id="page-title-bar">
		<div class="page-title">
			<h2>공지사항 배너 등록</h2>
		</div>
	</div>
</div>
<div>
	<center>
		<br>
		<form name="notice" method="post" action="../batch_process/send_email">
			<tr>
				<th>보내는 사람</th>
				<td><input type="text" name="send_email" value="musicbroooo@gmail.com" title="메일 주소 입력"></td>
			</tr>
			<br>
			<tr>
				<th>받는 사람</th>
				<td><input type="text" name="send_to" value="jinidevcom@music-brother.com" title="메일 주소 입력"></td>
			</tr>
			<br>
			<tr>
				<th>제목</th>
				<td><input type="text" name="title" title="메일 제목을 입력하세요."></td>
			</tr>
			<br>
			<tr>
				<th>내용</th>
				<td><textarea name="contents" id="contents" class="daumeditor" style="width:60%" title="내용을 입력해 주세요."></textarea></td>
			</tr>
			<br>
			<input type="submit" name="submit" value="메일 보내기"><br>
		</form>
	</center>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>