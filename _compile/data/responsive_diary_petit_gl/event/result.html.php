<?php /* Template_ 2.2.6 2021/03/29 16:42:08 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/event/result.html 000001946 */ 
$TPL_pass_1=empty($TPL_VAR["pass"])||!is_array($TPL_VAR["pass"])?0:count($TPL_VAR["pass"]);?>
<style type="text/css">
	.month_free_wrap{padding-top: 100px;}
	.month_free_wrap>h2{text-align: center; font-size: 2.5em;}

	.user_info_wrap{margin-top: 50px; text-align: center;}
	.user_info_wrap>p{font-size: 1.5em;}

	/*.free_no_user{display: none;}*/
	.free_ok_user{display: none;}

	.free_ok_btn{padding: 15px; cursor: pointer; border:1px solid #333333; display: inline-block; margin-top: 50px;}
	.free_ok_btn:hover{opacity: 0.8;}
	.mypage_link_btn{  display: inline-block; margin-top: 50px;}
	.mypage_link_btn>a{display: block;width: 100%; height: 100%; padding: 15px; border:1px solid #333333;}
	
</style>
<?php if($TPL_VAR["pass"]){?>
<div class="month_free_wrap">
	<h2>한달 무료 이용권 이벤트 페이지</h2>
<?php if($TPL_pass_1){foreach($TPL_VAR["pass"] as $TPL_V1){?>
<?php if($TPL_V1["sign"]=='Y'){?>
	<div class="user_info_wrap free_no_user">
		<p>고객님은 사용중인 이용권이 없습니다.</p>
		<p>한달 무료 이용권 이벤트는 이용권 사용중이 아닌 신규 회원 대상 이벤트 입니다.</p>
		<h1 style="font-weight: bold; margin-top: 10px;">" 사용 가능 "</h1>
		<div class="free_ok_btn">
			<a href="/event/movepage">한달 이용권 사용하기</a>
		</div>
	</div>
<?php }?>
<?php if($TPL_V1["sign"]=='N'){?>
	<div class="user_info_wrap free_no_user">
		<p>고객님께서는 정기결제 이용권 사용 중이십니다.</p>
		<p>한달 무료 이용권 이벤트는 이용권 사용중이 아닌 신규 회원 대상 이벤트 입니다.</p>
		<h1 style="font-weight: bold; margin-top: 10px;">" 사용 불가능 "</h1>
		<div class="free_ok_btn">
			<a href="/mypage">마이페이지</a>
		</div>
	</div>
<?php }?>
<?php }}?>
</div>
<?php }?>