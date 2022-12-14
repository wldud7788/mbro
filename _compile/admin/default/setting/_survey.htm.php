<?php /* Template_ 2.2.6 2022/05/17 12:37:04 /www/music_brother_firstmall_kr/admin/skin/default/setting/_survey.htm 000009090 */ ?>
<style>
.pointer {cursor:pointer;}
.sample  input[type="text"]{width:calc(100% - 20px); height:25px; padding:0;}
.sample textarea, .sample select {width:100%;}
dl > dt {padding-bottom:5px; display:block;}
dl > dd > ul > li {padding-bottom:5px;}
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="formListImgType">
<tr>
	<td colspan="2" height="10"></td>
</tr>
<tr>
	<td colspan="2" style="font:11px Dotum; letter-spacing:-1px; color:#000;">아래의 5가지의 스타일 중에서 1개를 선택하세요.</td>
</tr>
<tr>
	<td colspan="2">
		<span style="font:11px Dotum; letter-spacing:-1px;"></span>
	</td>
</tr>
<tr>
	<td colspan="2" height="20"></td>
</tr>
<tr>
	<td><img src="/admin/skin/default/images/common/btn_campaign_label_textbox.gif" value="텍스트" id="text" class="labelBtn pointer" style="border:0"> <img src="/admin/skin/default/images/common/btn_campaign_sample.gif" value="sample" style="border:0" id="textSampleBtn" class="pointer sampleBtn"></td>
	<td><img src="/admin/skin/default/images/common/btn_campaign_label_multiple.gif" value="여러개 중 택1" id="radio" class="labelBtn pointer" style="border:0"> <img src="/admin/skin/default/images/common/btn_campaign_sample.gif" value="sample" style="border:0" id="radioSampleBtn" class="pointer sampleBtn"></td>
</tr>
<tr>
	<td colspan="2" height="10"></td>
</tr>
<tr>
	<td><img src="/admin/skin/default/images/common/btn_campaign_label_text.gif" value="텍스트 박스" id="textarea" class="labelBtn pointer" style="border:0"> <img src="/admin/skin/default/images/common/btn_campaign_sample.gif" value="sample" style="border:0" id="textareaSampleBtn" class="pointer sampleBtn"></td>
	<td><img src="/admin/skin/default/images/common/btn_campaign_label_checkbox.gif" value="체크박스" id="checkbox" class="labelBtn pointer" style="border:0"> <img src="/admin/skin/default/images/common/btn_campaign_sample.gif" value="sample" style="border:0" id="checkboxSampleBtn" class="pointer sampleBtn"></td>
</tr>
<tr>
	<td colspan="2" height="10"></td>
</tr>
<tr>
	<td><img src="/admin/skin/default/images/common/btn_campaign_label_dropdown.gif" value="셀렉트박스" id="select" class="labelBtn pointer" style="border:0"> <img src="/admin/skin/default/images/common/btn_campaign_sample.gif" value="sample" style="border:0" id="selectSampleBtn" class="pointer sampleBtn"></td>
	<td></td>
</tr>
<tr>
	<td colspan="2" height="10"></td>
</tr>

</table>

<!--텍스트 샘플 -->
<div id="textSample" class="sample ">
	<!--샘플 -->
	<dl>
		<dt><b>주소</b> (수령 주소지를 정확히 입력해 주세요.)</dt>
		<dd>
			<ul>
				<li><input name="" type="text" width="80%"/></li>
				<li><input name="" type="text" width="80%"/></li>
			</ul>
		</dd>

		<dt class="mt15"><b>별명</b> (별명을 적어 주세요~)</dt>
		<dd>
			<input name="" type="text"/>
		</dd>
	</dl>
	<!--/샘플 -->
	<div class="footer">
		<button type="button" class="resp_btn v3 size_L" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>
<!--/텍스트 샘플 -->

<!--여러개 중 택일 샘플 -->
<div id="radioSample" class="sample">
	<!--샘플 -->
	<dl>
		<dt>2000CC급 자동차 선호 색상은?</dt>
		<dd>
			<div class="resp_radio">
			<ul>
				<li><label><input name="" type="radio" value="" align="absmiddle" class="null"/> 화이트</label></li>
				<li><label><input name="" type="radio" value="" align="absmiddle" class="null"/> 블랙</label></li>
				<li><label><input name="" type="radio" value="" align="absmiddle" class="null"/> 그레이</label></li>
			</ul>
			</div>
		</dd>
	</dl>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_L" onclick="closeDialogEvent(this);">닫기</button>
	</div>
<!--/여러개 중 택일 샘플 -->
</div>

<!--텍스트 박스 샘플 -->
<div id="textareaSample" class="sample">
	<!--샘플 -->
	<dl>
		<dt>올 여름  강력 추천 여행지를 소개해 주세요~!!</dt>
		<dd><textarea name="" cols="" rows="6"></textarea></dd>
	</dl>
	<!--/샘플 -->
	<div class="footer">
		<button type="button" class="resp_btn v3 size_L" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>
<!--/텍스트 박스 샘플 -->

<!--체크박스 샘플 -->
<div id="checkboxSample" class="sample">
	<!--샘플 -->
	<dl>
		<dt>꼭 가고 싶은 여행지? (여러 개 선택 가능)</dt>
		<dd>
			<ul>
				<li><label><input type="checkbox" name="checkbox" id="checkbox" class="null" align="absmiddle" /> 세부</label></li>
				<li><label><input type="checkbox" name="checkbox" id="checkbox" class="null" align="absmiddle" /> 아프리카</label></li>
				<li><label><input type="checkbox" name="checkbox" id="checkbox" class="null" align="absmiddle" /> 유럽</label></li>
				<li><label><input type="checkbox" name="checkbox" id="checkbox" class="null" align="absmiddle" /> 하와이</label></li>
			</ul>
		</dd>
	</dl>
	<!--/샘플 -->
	<div class="footer">
		<button type="button" class="resp_btn v3 size_L" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>
<!--/체크박스 샘플 -->

<!--드롭다운 샘플 -->
<div id="selectSample" class="sample">
	<!--샘플 -->
	<dl>
		<dt>휴가때 함께 보내고 싶은 연예인이 있다면?</dt>
		<dd>
			<select name="">
				<option>--------선택하세요-----------</option>
				<option>성시경</option>
				<option>니쿤</option>
				<option>박시후</option>
			</select>
		</dd>
	</dl>
	<!--/샘플 -->
	<div class="footer">
		<button type="button" class="resp_btn v3 size_L" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>
<!--/드롭다운 샘플 -->

<!--이메일 샘플 -->
<div style="width:260px; height:120px; border:1px solid #5298c6; padding:15px; position:absolute; top:298px; left:450px; background:#FFFFFF" id="emailSample" class="sample">
<!--타이틀 -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td style="font:14px Dotum; font-weight:bold; letter-spacing:-2px; color:#084b8f;">이메일 <span style="color:#1891c3;">샘플</span></td>
	<td align="right"><img src="/admin/skin/default/images/common/btn_pop_close_s.gif" class="pointer sampleCloseBtn" alt="닫기" /></td>
</tr>
<tr>
	<td colspan="2" height="10"></td>
</tr>
<tr>
	<td colspan="2" bgcolor="#d7d7d7" height="1"></td>
</tr>
<tr>
	<td colspan="2" height="16"></td>
</tr>
</table>
<!--/타이틀 -->
<!--샘플 -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td height="22" style="font:11px Dotum; letter-spacing:-1px; color:#3f3f3f;"><b>이메일</b></td>
</tr>
<tr>
	<td height="25"><input name="" type="text" style="font:11px Dotum; width:250px; height:18px; border:1px solid #dcdcdc; line-height:16px;" /></td>
</tr>
<tr>
	<td height="25"><input type="text" style="font:11px Dotum; width:250px; height:18px; border:1px solid #dcdcdc; line-height:16px;" value="이메일 확인" /></td>
</tr>
</table>
<!--/샘플 -->
</div>
<!--/이메일 샘플 -->
<!--댓글달기 샘플 -->
<div style="width:260px; height:120px; border:1px solid #5298c6; padding:15px; position:absolute; top:348px; left:368px; background:#FFFFFF" id="commentSample" class="sample">
<!--타이틀 -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td style="font:14px Dotum; font-weight:bold; letter-spacing:-2px; color:#084b8f;">댓글달기 <span style="color:#1891c3;">샘플</span></td>
	<td align="right"><img src="/admin/skin/default/images/common/btn_pop_close_s.gif" class="pointer sampleCloseBtn" alt="닫기" /></td>
</tr>
<tr>
	<td colspan="2" height="10"></td>
</tr>
<tr>
	<td colspan="2" bgcolor="#d7d7d7" height="1"></td>
</tr>
<tr>
	<td colspan="2" height="16"></td>
</tr>
</table>
<!--/타이틀 -->
<!--샘플 -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td><img src="/admin/skin/default/images/common/sample_img_comment.gif"></td>
</tr>
</table>
<!--/샘플 -->
</div>
<!--/댓글달기 샘플 -->
<!--생일 샘플 -->
<div style="width:260px; height:120px; border:1px solid #5298c6; padding:15px; position:absolute; top:348px; left:450px; background:#FFFFFF" id="birthSample" class="sample">
<!--타이틀 -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td style="font:14px Dotum; font-weight:bold; letter-spacing:-2px; color:#084b8f;">연/월/일 <span style="color:#1891c3;">샘플</span></td>
	<td align="right"><img src="/admin/skin/default/images/common/btn_pop_close_s.gif" class="pointer sampleCloseBtn" alt="닫기" /></td>
</tr>
<tr>
	<td colspan="2" height="10"></td>
</tr>
<tr>
	<td colspan="2" bgcolor="#d7d7d7" height="1"></td>
</tr>
<tr>
	<td colspan="2" height="16"></td>
</tr>
</table>
<!--/타이틀 -->

</div>
<!--/생일 샘플 -->