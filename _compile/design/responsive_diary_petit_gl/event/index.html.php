<?php /* Template_ 2.2.6 2021/03/29 16:34:13 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/event/index.html 000002415 */ ?>
<style type="text/css">
	.month_free_wrap{padding-top: 100px;}
	.month_free_wrap>h2{text-align: center; font-size: 2.5em;}

	.user_info_wrap{margin-top: 50px;}
	.user_info_wrap>table{margin: 0 auto; width: 50%;}
	.user_info_wrap>table tr>td{padding: 10px 10px;}
	.user_info_wrap>table tr>td>input{width: 100%;}
	.user_info_wrap>table tr>td:nth-of-type(1){font-size: 1.6em;  width: 30%; text-align: center;}

	.submit_btn_wrap{text-align: right; margin: 0 auto; width: 50%;}
	.submit_btn{padding: 10px; cursor: pointer;}
	.month_free_text_box{width: 70%; margin: 50px auto 0;}
	.month_free_text_box>p{font-size: 16px; margin-top: 10px;}

	 @media (max-width:968px) {
	 	.user_info_wrap>table{width: 100%;}
	 	.submit_btn_wrap{width: 100%;}
	 	.submit_btn{width: 100%;}

	 	.month_free_text_box{width: 100%;}
	 }

</style>

<div class="month_free_wrap">
	<h2>한달 무료 이용권 이벤트 페이지</h2>
	
	<form name="event" method="post" action="/event/process">
		<div class="user_info_wrap">
			<table>
				<tbody>
					<tr>
						<td>이메일</td>
						<td><input type="text" name="email" placeholder="ex) mubro@mubro.com" autocomplete="off"></td>
					</tr>
					<tr>
						<td>비밀번호</td>
						<td><input type="password" name="password" placeholder="password"></td>
					</tr>
					<tr>
						<td>쿠폰번호</td>
						<td><input type="text" name="coupon" placeholder="10자리" autocomplete="off" ></td>
					</tr>
				</tbody>
			</table>
			<div class="submit_btn_wrap">
				<input type="submit" name="submit" value="입력완료" class="submit_btn">
				<!-- https://musicbroshop.com/page/index?tpl=etc%2Fmonth_free_ok_page.html -->
			</div>	
		</div>
	</form>

	<div class="month_free_text_box">
		<p>ㆍ 이메일, 비밀번호는 '뮤직브로 앱'에서 사용하고 계시는 이메일, 비밀번호로 입력해주시기 바랍니다.</p>
		<p>ㆍ 본 이벤트는 신규 회원을 대상으로 하는 이벤트로, 이용권 사용 내역이 있는 고객님은 쿠폰사용이 불가합니다. (지인에게 전달 가능)</p>
		<p>ㆍ 쿠폰은 중복사용 되지 않습니다.</p>
		<p>ㆍ 한달 무료 사용 이벤트이므로, 기간만료 후에는 이용권 결제를 해야 계속 사용이 가능합니다.</p>
	</div>
</div>