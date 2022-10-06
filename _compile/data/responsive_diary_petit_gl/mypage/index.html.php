<?php /* Template_ 2.2.6 2021/01/19 11:39:50 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/index.html 000018179 */  $this->include_("showMycartTop");
$TPL_orders_1=empty($TPL_VAR["orders"])||!is_array($TPL_VAR["orders"])?0:count($TPL_VAR["orders"]);
$TPL_coin_loop_1=empty($TPL_VAR["coin_loop"])||!is_array($TPL_VAR["coin_loop"])?0:count($TPL_VAR["coin_loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 마이페이지 index @@
- 파일위치 : [스킨폴더]/mypage/index.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)">MENU</a>
		
		<ul class="my_index_top mycs_fcont_margin">
			<li>
				<p class="my_greeting">
					<span class="name"><?php echo $TPL_VAR["user_name"]?></span><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >님</span> <span class="Dib" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >반갑습니다.</span>
				</p>
				<ul class="my_msub1">
					<li><?php echo $TPL_VAR["userInfo"]["group_name"]?><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" > 등급</span></li>
					<li><a href="/mypage/myinfo" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >회원정보 수정</a></li>
				</ul>
			</li>
			<li>
				<ul class="my_msub2">
					<li>
						<a href="/mypage/emoney">
							<span class="title" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >캐시</span>
							<span class="cont">
								<span class="num"><?php echo number_format($TPL_VAR["emoney"])?></span>
							<span>
						</a>
					</li>
					<li>
						<a href="/mypage/coupon">
							<span class="title" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >쿠폰</span>
							<span class="cont">
								<span class="num"><?php echo $TPL_VAR["summary"]["coupondownloadtotal"]?></span>장
							</span>
						</a>
					</li>
					<li>
						<a href="/mypage/wish">
							<span class="title" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >위시리스트</span>
							<span class="cont">
								<span class="num"><?php echo showMycartTop('wish')?></span>개
							</span>
						</a>
					</li>
					<li>
						<a href="/goods/recently">
							<span class="title" designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >최근 본 상품</span>
							<span class="cont">
								<span class="num"><?php echo showMycartTop('recently')?></span>개
							</span>
						</a>
					</li>
				</ul>
			</li>
		</ul>


		<!-- 최근 주문 내역 -->
		<div class="title_container2 Bbx Pb0 Mt80">
			<h3 class="title_sub6"><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >최근 주문 내역</span></h3>
			<a class="btn_thebogi" href="/mypage/order_catalog" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >전체조회</a>
		</div>
		<ul class="my_order_step">
			<li class="step1"><a href="../mypage/order_catalog?step_type=order"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >주문접수</span><?php if($TPL_VAR["counts"]['15']){?><span class="pushCount"><?php echo $TPL_VAR["counts"]['15']?></span><?php }?></a></li>
			<li class="step2"><a href="../mypage/order_catalog?step_type=deposit_only"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >결제확인</span><?php if($TPL_VAR["counts"]['25']){?><span class="pushCount"><?php echo $TPL_VAR["counts"]['25']?></span><?php }?></a></li>
			<li class="step3"><a href="../mypage/order_catalog?step_type=ready_only"><span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >상품준비중</span><?php if(($TPL_VAR["counts"]['35']+$TPL_VAR["counts"]['40']+$TPL_VAR["counts"]['45'])){?><span class="pushCount"><?php echo ($TPL_VAR["counts"]['35']+$TPL_VAR["counts"]['40']+$TPL_VAR["counts"]['45'])?></span><?php }?></a></li>
			<li class="step4"><a href="../mypage/order_catalog?step_type=delivery_ing"><span designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >배송중</span><?php if(($TPL_VAR["counts"]['50']+$TPL_VAR["counts"]['55']+$TPL_VAR["counts"]['60']+$TPL_VAR["counts"]['65']+$TPL_VAR["counts"]['70'])){?><span class="pushCount"><?php echo $TPL_VAR["counts"]['50']+$TPL_VAR["counts"]['55']+$TPL_VAR["counts"]['60']+$TPL_VAR["counts"]['65']+$TPL_VAR["counts"]['70']?></span><?php }?></a></li>
			<li class="step5"><a href="../mypage/order_catalog?step_type=delivery_complete"><span designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >배송완료</span><?php if($TPL_VAR["counts"]['75']){?><span class="pushCount"><?php echo $TPL_VAR["counts"]['75']?></span><?php }?></a></li>
		</ul>

		<!-- 최근 주문 상품 리스트 -->
<?php if($TPL_VAR["orders"]){?>
		<div id="OcList" class="res_table v2">
			<ul class="thead">
				<li class="buy_date"><span designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >날짜</span></li>
				<li class="order_seq"><span designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >주문번호</span></li>
				<li class="item_info"><span designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >상품</span></li>
				<li class="order_price"><span designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >주문금액</span></li>
				<li class="order_status"><span designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >상태</span></li>
			</ul>
<?php if($TPL_orders_1){foreach($TPL_VAR["orders"] as $TPL_V1){?>
			<ul class="tbody">
				<li class="sjb_top"><?php echo date('Y.m.d',strtotime($TPL_V1["regist_date"]))?></li>
				<li class="sjb_top order_seq"><span class="motle" designElement="text" textIndex="21"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >주문번호 : </span><a href="/mypage/order_view?no=<?php echo $TPL_V1["order_seq"]?>"><?php echo $TPL_V1["order_seq"]?></a></li>
				<li class="item_info">
<?php if(is_array($TPL_R2=$TPL_V1["items"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if(is_array($TPL_R3=$TPL_V2["options"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
					<ul class="oc_item_info_detail">
						<li class="img_link" <?php if($TPL_V2["goods_type"]!='gift'){?>style="cursor:pointer" title="상품 상세" onclick="location.href='../goods/view?no=<?php echo $TPL_V2["goods_seq"]?>';"<?php }?>>
							<img src="<?php echo viewImg($TPL_V2["goods_seq"],'thumbCart')?>" class="goods_thumb" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage_list.gif'" alt="" />
						</li>
						<li class="detail_spec">
<?php if($TPL_V2["eventEnd"]){?>
							<div class="oc_event_area">
								<span class="soloEventTd<?php echo $TPL_V3["item_option_seq"]?>">
									<img src="/data/skin/responsive_diary_petit_gl/images/common/icon_clock.gif" class="img_clock" alt=""> 남은시간
									<span class="time_area">
										<span id="soloday<?php echo $TPL_V3["item_option_seq"]?>">0</span>일
										<span id="solohour<?php echo $TPL_V3["item_option_seq"]?>">00</span>:
										<span id="solomin<?php echo $TPL_V3["item_option_seq"]?>">00</span>:
										<span id="solosecond<?php echo $TPL_V3["item_option_seq"]?>">00</span>
									</span>
								</span>
								<script>
								$(function() {
									timeInterval<?php echo $TPL_V3["item_option_seq"]?> = setInterval(function(){
										var time<?php echo $TPL_V3["item_option_seq"]?> = showClockTime('text', '<?php echo $TPL_V2["eventEnd"]["year"]?>', '<?php echo $TPL_V2["eventEnd"]["month"]?>', '<?php echo $TPL_V2["eventEnd"]["day"]?>', '<?php echo $TPL_V2["eventEnd"]["hour"]?>', '<?php echo $TPL_V2["eventEnd"]["min"]?>', '<?php echo $TPL_V2["eventEnd"]["second"]?>', 'soloday<?php echo $TPL_V3["item_option_seq"]?>', 'solohour<?php echo $TPL_V3["item_option_seq"]?>', 'solomin<?php echo $TPL_V3["item_option_seq"]?>', 'solosecond<?php echo $TPL_V3["item_option_seq"]?>', '<?php echo $TPL_V3["item_option_seq"]?>');
										if(time<?php echo $TPL_V3["item_option_seq"]?> == 0){
											clearInterval(timeInterval<?php echo $TPL_V3["item_option_seq"]?>);
											$("..soloEventTd<?php echo $TPL_V3["item_option_seq"]?>").html("단독 이벤트 종료");
										}
									},1000);
								});
								</script>
							</div>
<?php }?>

<?php if($TPL_V2["goods_type"]=='gift'){?><img src="/data/skin/responsive_diary_petit_gl/images/common/icon_gift.gif" alt="사은품" vspace=3 /><?php }?>
<?php if($TPL_V3["cancel_type"]=='1'){?><span class="order-item-cancel-type">[청약철회불가]</span><?php }?>

							<div class="goods_name"><?php echo $TPL_V2["goods_name"]?></div>

<?php if($TPL_V2["adult_goods"]=='Y'||$TPL_V2["option_international_shipping_status"]=='y'||$TPL_V2["cancel_type"]=='1'||$TPL_V2["tax"]=='exempt'){?>
							<div class="goods_type">
<?php if($TPL_V2["adult_goods"]=='Y'){?>
								<img src="/data/skin/responsive_diary_petit_gl/images/common/auth_img.png" class="icon1" alt="성인" height="17" />
<?php }?>
<?php if($TPL_V2["option_international_shipping_status"]=='y'){?>
								<img src="/data/skin/responsive_diary_petit_gl/images/common/plane.png" class="icon1" alt="해외배송상품" height="16" />
<?php }?>
<?php if($TPL_V2["cancel_type"]=='1'){?>
								<img src="/data/skin/responsive_diary_petit_gl/images/common/nocancellation.gif" class="icon1" alt="청약철회"  />
<?php }?>
<?php if($TPL_V2["tax"]=='exempt'){?>
								<img src="/data/skin/responsive_diary_petit_gl/images/common/taxfree.gif" class="icon1" alt="비과세" />
<?php }?>
							</div>
<?php }?>

							<div class="oc_res_block">
<?php if($TPL_V3["option1"]!=''){?>
								<ul class="goods_options">
<?php if($TPL_V3["option1"]){?>
									<li><?php if($TPL_V3["title1"]){?><span class="xtle"><?php echo $TPL_V3["title1"]?></span><?php }?> <?php echo $TPL_V3["option1"]?></li>
<?php }?>
<?php if($TPL_V3["option2"]){?>
									<li><?php if($TPL_V3["title2"]){?><span class="xtle"><?php echo $TPL_V3["title2"]?></span><?php }?> <?php echo $TPL_V3["option2"]?></li>
<?php }?>
<?php if($TPL_V3["option3"]){?>
									<li><?php if($TPL_V3["title3"]){?><span class="xtle"><?php echo $TPL_V3["title3"]?></span><?php }?> <?php echo $TPL_V3["option3"]?></li>
<?php }?>
<?php if($TPL_V3["option4"]){?>
									<li><?php if($TPL_V3["title4"]){?><span class="xtle"><?php echo $TPL_V3["title4"]?></span><?php }?> <?php echo $TPL_V3["option4"]?></li>
<?php }?>
<?php if($TPL_V3["option5"]){?>
									<li><?php if($TPL_V3["title5"]){?><span class="xtle"><?php echo $TPL_V3["title5"]?></span><?php }?> <?php echo $TPL_V3["option5"]?></li>
<?php }?>
								</ul>
<?php }?>

<?php if($TPL_V2["goods_type"]!='gift'){?>
								<div class="goods_quantity pointcolor">
									<span class="xtle">수량</span> <strong class="num"><?php echo number_format($TPL_V3["ea"])?></strong>개
								</div>
<?php }?>
							</div>

<?php if($TPL_V3["inputs"]){?>
							<ul class="goods_inputs">
<?php if(is_array($TPL_R4=$TPL_V3["inputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
								<li>
<?php if($TPL_V4["value"]){?>
<?php if($TPL_V4["title"]){?><span class="xtle v2"><?php echo $TPL_V4["title"]?></span><?php }?>
<?php if($TPL_V4["type"]=='file'){?>
										<a href="/mypage_process/filedown?file=<?php echo $TPL_V4["value"]?>" target="actionFrame"><img src="/mypage_process/filedown?file=<?php echo $TPL_V4["value"]?>" class="input_img" title="크게 보기" /></a>
<?php }else{?>
										<?php echo $TPL_V4["value"]?>

<?php }?>
<?php }?>
								</li>
<?php }}?>
							</ul>
<?php }?>

<?php if($TPL_I3== 0&&$TPL_V2["suboptions"]){?>
							<ul class="goods_suboptions">
<?php if(is_array($TPL_R4=($TPL_V2["suboptions"]))&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
								<li><?php if($TPL_V4["title"]){?><span class="xtle v3"><?php echo $TPL_V4["title"]?></span><?php }?> <?php echo $TPL_V4["suboption"]?> - <?php echo number_format($TPL_V4["ea"])?>개</li>
<?php }}?>
							</ul>
<?php }?>
						</li>
					</ul>
<?php }}?>
<?php }}?>
				</li>
				<li class="order_price">
					<!-- 금액 -->
<?php if($TPL_V1["gift_cnt"]==$TPL_V1["opt_cnt"]){?>
					<div>캐시 교환</div>
					<b><?php echo get_currency_price($TPL_V1["emoney"], 2)?></b>
<?php }else{?>
					<b class="pointcolor"><?php echo get_currency_price($TPL_V1["settleprice"], 2)?></b>
<?php }?>
					<!-- //금액 -->
				</li>
				<li class="order_status">
					<p class="status pointcolor">
<?php if($TPL_V1["payment"]!='pos_pay'){?>
							<?php echo $TPL_V1["mstep"]?>

<?php }else{?>
							오프라인<br/>매장 주문
<?php }?>
					</p>
				</li>
			</ul>
<?php }}?>
		</div>
<?php }else{?>
		<div class="no_data_area2">
			최근 1개월내 내역이 없습니다.
		</div>
<?php }?>

		<!-- 최근 반품 정보-->
		<div class="mypage_list_sec0 mt30">
			<ul>
				<li class="th hand" onclick="document.location.href='../mypage/return_catalog?step_type=return'"><p designElement="text" textIndex="22"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >반품/교환</p></li>
				<li class="td hand amount" onclick="document.location.href='../mypage/return_catalog?step_type=return'">
<?php if($TPL_VAR["counts"]['return']> 0){?>
					<span class="common_count"><span class="num"><?php echo number_format($TPL_VAR["counts"]['return'])?></span>건</span>
<?php }else{?>
					<span class="gray_06">최근 1개월 내역이 <span class="Dib">없습니다.</span></span>
<?php }?>
				</li>

				<li class="th hand" onclick="document.location.href='../mypage/refund_catalog?step_type=cancel'"><p designElement="text" textIndex="23"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >취소/환불</p></li>
				<li class="td hand amount" onclick="document.location.href='../mypage/refund_catalog?step_type=cancel'">
<?php if($TPL_VAR["counts"]['refund']> 0){?>
					<span class="common_count"><span class="num"><?php echo number_format($TPL_VAR["counts"]['refund'])?></span>건</span>
<?php }else{?>
					<span class="gray_06">최근 1개월 내역이 <span class="Dib">없습니다.</span></span>
<?php }?>
				</li>
			</ul>
		</div>
		<br><br>
		<!--코인 여기에 추가-->
		<? if($_SESSION[user][group_seq] == '3') { ?>
		<h3 class="title_sub6"><span designElement="text" textIndex="24"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >최근 코인 주문 내역</span></h3>
		<br>
		<div id="OcList" class="res_table v2">
			<ul class="thead">
				<li class="count"><span designElement="text" textIndex="25"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >번호</span></li>
				<li class="od_num"><span designElement="text" textIndex="26"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >지갑주소</span></li>
				<li class="start_date"><span designElement="text" textIndex="27"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >입금예정내역</span></li>
				<li class="money"><span designElement="text" textIndex="28"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >신청일자</span></li>
				<li class="status"><span designElement="text" textIndex="29"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvaW5kZXguaHRtbA==" >처리상태</span></li>
			</ul>
<?php if($TPL_coin_loop_1){foreach($TPL_VAR["coin_loop"] as $TPL_V1){?>
			<ul class="tbody">
				<li><span><?php echo $TPL_V1["status"]?></span></li> <!--주문 순서-->
				<li><span><?php echo $TPL_V1["status"]?></span></li> <!--주문 순서-->
				<li><span><?php echo $TPL_V1["updatedAt"]?></span></li> <!--코인주문날짜-->
				<li><span><?php echo $TPL_V1["updatedAt"]?></span></li> <!--주문번호-->
				<li><span><? print_r($_SERVER['SERVER_ADDR']);?></span></li> <!--클릭하면 QR코드 나오도록?-->
			</ul>
<?php }}?>
		</div>
		<? } ?>
	</div>
	<!-- +++++ //mypage contents ++++ -->
</div>
 

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->
<script type="text/javascript">
$(document).ready(function() {
	//기존멤버-통합하기
	$("#facebookmbconnectalert").click(function(){
		//facebook 친구들을 쇼핑몰에 초대하기 위해서는 facebook계정으로 쇼핑몰을 이용해 주셔야 합니다.<br>회원정보수정에서 "SNS계정사용"을 수락해 주세요. <br>친구들을 초대하시면 다양한 혜택을 받으실 수 있습니다.<br>지금 회원정보수정 화면으로 이동하시겠습니까?
		openDialogConfirm(getAlert('mp107'),'650','200',function(){document.location.href='../mypage/myinfo'},function(){});
	});
});
</script>
<?
p
?>