<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/point.html 000003035 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 포인트 내역 @@
- 파일위치 : [스킨폴더]/mypage/point.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)">MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvcG9pbnQuaHRtbA==" >포인트 내역</span></h2>
		</div>

<?php if($TPL_VAR["loop"]){?>
		<div class="mypage_greeting btm_padding">
			<span class="username"><?php echo $TPL_VAR["user_name"]?>(<span class="usergroup"><?php echo $TPL_VAR["userid"]?></span>)</span>회원님이 보유한 포인트는 <span class="usergroup"><?php echo number_format($TPL_VAR["point"])?></span>P 입니다.
		</div>
		<div class="res_table">
			<ul class="thead">
				<li style="width:45px;">번호</li>
				<li style="width:85px;">날짜</li>
				<li style="width:80px;">지급/차감</li>
				<li>사유</li>
				<li style="width:180px;">내역</li>
				<li style="width:95px;">유효기간</li>
			</ul>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<ul class="tbody">
				<li class="mo_hide"><?php echo $TPL_V1["number"]?></li>
				<li class="sjb_top mo_r grow" style="order:-8;"><?php echo date('Y.m.d',strtotime($TPL_V1["regist_date"]))?></li>
				<li class="R sjb_top Bo" style="order:-10;">
<?php if($TPL_V1["gb"]=='plus'){?><span class="pointcolor2">+ <?php echo number_format($TPL_V1["point"])?></span><?php }else{?><span class="pointcolor3">- <?php echo number_format($TPL_V1["point"])?></span><?php }?> 
				</li>
				<li class="subject">
					<?php echo $TPL_V1["memo"]?>

				</li>
				<li class="L Pb10">
					<span class="motle">내역:</span> <span class="desc2"><?php echo $TPL_V1["contents"]?></span>
				</li>
				<li class="sjb_top" style="order:-9;">
					<span class="motle">유효기간:</span> 
<?php if($TPL_V1["limit_date"]){?>~ <?php echo $TPL_V1["limit_date"]?><?php }else{?>-<?php }?>
				</li>
			</ul>
<?php }}?>
		</div>
		<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
<?php }else{?>
		<div class="no_data_area2">
			포인트 내역이 없습니다.
		</div>
<?php }?>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->