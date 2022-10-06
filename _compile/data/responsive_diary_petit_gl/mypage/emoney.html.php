<?php /* Template_ 2.2.6 2021/05/31 13:33:43 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/emoney.html 000004982 */ 
$TPL_coin_loop_1=empty($TPL_VAR["coin_loop"])||!is_array($TPL_VAR["coin_loop"])?0:count($TPL_VAR["coin_loop"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 캐시 내역 @@
- 파일위치 : [스킨폴더]/mypage/emoney.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

		<!-- +++++ mypage contents ++++ -->
		<div class="subpage_container">
			<!-- 전체 메뉴 -->
			<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)">MENU</a>
			<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvZW1vbmV5Lmh0bWw=" >캐시전환내역</span></h2>
			</div>
			<div class="mypage_greeting btm_padding">
				<span class="username">입금 신청 후 7일 이내에 입금을 하지 않으시면 취소처리 됩니다. </span>
			</div>
<?php if($TPL_VAR["coin_loop"]){?>
			<div class="res_table bmp_check">
				<ul class="thead">
					<li style="width:85px;">번호</li>
					<li style="width:180px;">지갑주소</li>
					<li style="width:80px;">입금예정내역</li>
					<li style="width:95px;">신청일자</li>
					<li style="width:95px;">처리상태</li>
				</ul>
<?php if($TPL_coin_loop_1){foreach($TPL_VAR["coin_loop"] as $TPL_V1){?>
				<ul class="tbody">
					<li><?php echo $TPL_V1["number"]?></li>
					<li><?php echo $TPL_V1["walletId"]?></li>
					<li><?php echo $TPL_V1["price"]?></li>
					<li><?php echo $TPL_V1["createdAt"]?></li>
					<li><?php echo $TPL_V1["status"]?></li>
				</ul>
<?php }}?>
			</div>
<?php }else{?>
			<div class="no_data_area2">
				캐시전환신청을 한 내역이 없습니다.
			</div>
<?php }?>
				<!-- <script type="text/javascript">
					$(function(){
						for (i = 0; i < 10; i++) { 			
							$(".bmp_check").append('<ul class="tbody"><li>0</li><li><?php echo $TPL_VAR["coin_list"]['+']["walletId"]?></li><li><?php echo $TPL_VAR["coin_list"][ 1]["price"]?></li><li><?php echo $TPL_VAR["coin_list"][ 1]["createdAt"]?></li><li><?php echo $TPL_VAR["coin_list"][ 1]["status"]?></li>');   
						}
					});
				</script> -->

			<!-- 타이틀 -->
			<div class="title_container">
				<h2><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvZW1vbmV5Lmh0bWw=" >캐시내역</span></h2>
			</div>
			
			<div class="mypage_greeting btm_padding">
				<span class="username"><?php echo $TPL_VAR["user_name"]?>(<span class="usergroup"><?php echo $TPL_VAR["userid"]?></span>)</span>님이 보유한 캐시는 <span class="pointnum"><?php echo number_format($TPL_VAR["emoney"])?></span>C 입니다.
			</div>
<?php if($TPL_VAR["loop"]){?>
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
<?php if($TPL_V1["gb"]=='plus'){?><span class="pointcolor2">+ <?php echo number_format($TPL_V1["emoney"])?></span><?php }else{?><span class="pointcolor3">- <?php echo number_format($TPL_V1["emoney"])?></span><?php }?> 
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
				캐시 내역이 없습니다.
			</div>
<?php }?>
			
		<!-- <a href="/coin/coin_notice?" style=" background-color: gray; color: white; padding: 15px 30px; border-radius: 15px; border: 1px solid gray; display: block; text-align: center; margin-top: 50px;" >코인 환전하러 가기</a> -->
		</div>

	<!-- +++++ //mypage contents ++++ -->

	</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->