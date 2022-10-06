<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/refund_view.html 000013574 */ 
$TPL_refund_shipping_items_1=empty($TPL_VAR["refund_shipping_items"])||!is_array($TPL_VAR["refund_shipping_items"])?0:count($TPL_VAR["refund_shipping_items"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 취소/환불 상세 @@
- 파일위치 : [스킨폴더]/mypage/refund_view.html
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
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvcmVmdW5kX3ZpZXcuaHRtbA==" >취소/환불 상세</span></h2>
		</div>

		<ul class="myorder_sort">
			<li class="list1">
				<span class="th gray_01">상태 : </span>
				<span class="td">
					<strong class="pointcolor"><?php echo $TPL_VAR["data_refund"]["mstatus"]?> <?php if($TPL_VAR["data_refund"]["status"]=='complete'){?>(해당 환불건의 처리가 완료된 상태입니다.)<?php }?></strong>
				</span>
			</li>
		</ul>

		<div class="res_table">
			<ul class="thead">
				<li>상품</li>
				<li style="width:80px;">주문수량</li>
				<li style="width:90px;">환불신청수량</li>
				<li style="width:110px;">결제금액</li>
				<li style="width:120px;">배송비</li>
			</ul>
<?php if($TPL_refund_shipping_items_1){foreach($TPL_VAR["refund_shipping_items"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["items"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
			<ul class="tbody">
				<li class="item_info">
					<ul class="oc_item_info_detail">
						<li class="img_link">
							<a href='/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>' target='_blank' title="새창"><img src="<?php echo $TPL_V2["image"]?>" class="order_thumb" alt="<?php echo $TPL_V2["goods_name"]?>" /></a>
						</li>
						<li class="detail_spec">
<?php if($TPL_V2["goods_type"]=='gift'){?><img src="/data/skin/responsive_diary_petit_gl/images/common/icon_gift.gif" alt="사은품" vspace=3 /><?php }?>
<?php if($TPL_V2["cancel_type"]=='1'){?><span class="order-item-cancel-type">[청약철회불가]</span><?php }?>

							<div class="goods_name"><?php echo $TPL_V2["goods_name"]?></div>
							
<?php if($TPL_V2["option1"]){?>
							<div class="oc_res_block">
								<ul class="goods_options">
<?php if($TPL_V2["option1"]){?>
									<li><?php if($TPL_V2["title1"]){?><span class="xtle"><?php echo $TPL_V2["title1"]?></span><?php }?> <?php echo $TPL_V2["option1"]?></li>
<?php }?>
<?php if($TPL_V2["option2"]){?>
									<li><?php if($TPL_V2["title2"]){?><span class="xtle"><?php echo $TPL_V2["title2"]?></span><?php }?> <?php echo $TPL_V2["option2"]?></li>
<?php }?>
<?php if($TPL_V2["option3"]){?>
									<li><?php if($TPL_V2["title3"]){?><span class="xtle"><?php echo $TPL_V2["title3"]?></span><?php }?> <?php echo $TPL_V2["option3"]?></li>
<?php }?>
<?php if($TPL_V2["option4"]){?>
									<li><?php if($TPL_V2["title4"]){?><span class="xtle"><?php echo $TPL_V2["title4"]?></span><?php }?> <?php echo $TPL_V2["option4"]?></li>
<?php }?>
<?php if($TPL_V2["option5"]){?>
									<li><?php if($TPL_V2["title5"]){?><span class="xtle"><?php echo $TPL_V2["title5"]?></span><?php }?> <?php echo $TPL_V2["option5"]?></li>
<?php }?>
								</ul>
							</div>
<?php }?>

<?php if($TPL_V2["goods_type"]=="gift"){?>
<?php if($TPL_V2["gift_title"]){?>
								<div class="mt3">
									<?php echo $TPL_V2["gift_title"]?>

									<button type="button" class="gift_log btn_resp" order_seq="<?php echo $TPL_VAR["data_refund"]["order_seq"]?>" item_seq="<?php echo $TPL_V2["item_seq"]?>">자세히</button>
								</div>
<?php }?>
<?php }?>
						</li>
					</ul>
				</li>
				<li><span class="motle">주문:</span> <?php echo number_format($TPL_V2["option_ea"])?></li>
				<li>
					<span class="motle">환불신청:</span>
					<?php echo number_format($TPL_V2["ea"])?>

<?php if($TPL_VAR["data_order"]["download_seq"]){?>
<?php if($TPL_VAR["data_order"]["restore_used_coupon_refund"]){?>
						<p>상품쿠폰 <input type="button" class="btn_chg small" value="복원완료" /></p>
<?php }?>
<?php }?>
<?php if($TPL_VAR["data_order"]["shipping_promotion_code_seq"]){?>
<?php if($TPL_VAR["data_order"]["restore_used_promotioncode_refund"]){?>
						<p>프로모션쿠폰 <input type="button" class="btn_chg small" value="복원완료" /></p>
<?php }?>
<?php }?>
				</li>
				<li class="Pb10">
					<span class="motle">결제금액:</span>  
<?php if($TPL_V2["total_sale"]> 0){?>
					<?php echo number_format($TPL_V2["order_price"])?>

					할인 (-)<?php echo number_format($TPL_V2["total_sale"])?>

<?php }?>
					<strong class="pointcolor2"><?php echo number_format($TPL_V2["order_price"]-$TPL_V2["total_sale"])?></strong>
				</li>
				<li class="besong_group2 <?php if($TPL_I2== 0){?>show<?php }?>">
<?php if($TPL_I2== 0){?>
<?php if($TPL_VAR["data_order"]["payment"]!='pos_pay'){?>
<?php if($TPL_V2["goods_kind"]=='coupon'){?>
								티켓
<?php }elseif($TPL_V2["goods_kind"]=='gift'){?>
								사은품
<?php }else{?>
<?php if($TPL_V1["shipping"]['international']=='international'){?><span class="Dib style1">[해외]</span>
<?php }elseif(preg_match('/^each/',$TPL_V1["shipping"]['shipping_method'])){?><span class="Dib style1">[개별배송]</span>
<?php }else{?><span class="Dib style1">[기본배송]</span><?php }?>

<?php if($TPL_V1["shipping"]['shipping_method']=='quick'){?><span class="Dib style2">퀵서비스</span>
<?php }elseif($TPL_V1["shipping"]['shipping_method']=='direct'){?><span class="Dib style2">직접수령</span>
<?php }elseif(preg_match('/postpaid$/',$TPL_V1["shipping"]['shipping_method'])){?><span class="Dib style2">택배(착불)</span>
<?php }else{?><span class="Dib style2">택배(선불)</span><?php }?>

<?php if(preg_match('/^each/',$TPL_V1["shipping"]['shipping_method'])){?>
									<span class="Dib style3"><strong><?php echo number_format($TPL_V1["shipping"]['delivery_cost'])?></strong>원</span>
<?php if($TPL_V1["shipping"]['add_delivery_cost']> 0){?>
									<span class="Dib style3">+<?php echo number_format($TPL_V1["shipping"]['add_delivery_cost'])?></span>
<?php }?>
<?php }else{?>
									<span class="Dib style3"><strong><?php echo number_format($TPL_V1["shipping"]['shipping_cost'])?></strong>원</span>
<?php if($TPL_V1["shipping"]['add_delivery_area']> 0){?>
									<span class="Dib style3">+<?php echo number_format($TPL_V1["shipping"]['add_delivery_area'])?></span>
<?php }?>
<?php }?>
<?php }?>
<?php }else{?>
							<span class="Dib style2"><?php echo $TPL_V1["shipping"]['shipping_store_name']?></span>
<?php }?>
<?php }else{?>
					-
<?php }?>
				</li>
			</ul>
<?php }}?>
<?php }}?>
		</div>

		<ul class="order_settle">
			<li class="col1">
				<h4 class="title">
					환불처리&nbsp;
					<button type="button" onclick="document.location.href='/mypage/myqna_write?category=<?php echo urlencode('환불문의')?>'" class="btn_resp size_a color2">문의</button>
				</h4>
				<div class="resp_table_row2">
					<ul>
						<li class="th">환불상태</li>
						<li class="td">:&nbsp; <?php echo $TPL_VAR["data_refund"]["mstatus"]?></li>
					</ul>
					<ul>
						<li class="th">환불번호</li>
						<li class="td">:&nbsp; <?php echo $TPL_VAR["data_refund"]["refund_code"]?></li>
					</ul>
					<ul>
						<li class="th">환불종류</li>
						<li class="td">:&nbsp; <?php echo $TPL_VAR["data_refund"]["mrefund_type"]?> 환불</li>
					</ul>
					<ul>
						<li class="th">환불접수일</li>
						<li class="td">:&nbsp; <?php echo date('Y년 m월 d일',strtotime($TPL_VAR["data_refund"]["regist_date"]))?></li>
					</ul>
					<ul>
						<li class="th">환불완료일</li>
						<li class="td">:&nbsp; <?php if($TPL_VAR["data_refund"]["refund_date"]&&$TPL_VAR["data_refund"]["refund_date"]!='0000-00-00'){?><?php echo date('Y년 m월 d일',strtotime($TPL_VAR["data_refund"]["refund_date"]))?><?php }?></li>
					</ul>
				</div>
			</li>
			<li class="col2" <?php if($TPL_VAR["data_order"]["payment"]=='pos_pay'){?>style="display:none;"<?php }?>>
<?php if($TPL_VAR["data_refund"]["status"]=='request'){?><form action="../mypage_process/refund_modify" target="actionFrame" method="post">
				<input type="hidden" name="refund_code" value="<?php echo $TPL_VAR["data_refund"]["refund_code"]?>" />
				<h4 class="title">
					환불정보&nbsp;
					<button type="submit" class="btn_resp size_a color2">변경</button>
				</h4><?php }else{?><div>
				<h4 class="title">환불정보</h4><?php }?>
				<div class="resp_table_row2<?php if($TPL_VAR["data_refund"]["status"]=='request'){?> form_style<?php }?>">
					<ul>
						<li class="th">환불은행</li>
						<li class="td"><?php if($TPL_VAR["data_refund"]["status"]=='request'){?><input type="text" name="bank_name" value="<?php echo $TPL_VAR["data_refund"]["bank_name"]?>" maxlength="20" /><?php }else{?>:&nbsp; <?php echo $TPL_VAR["data_refund"]["bank_name"]?><?php }?></li>
					</ul>
					<ul>
						<li class="th">예금주</li>
						<li class="td"><?php if($TPL_VAR["data_refund"]["status"]=='request'){?><input type="text" name="bank_depositor" value="<?php echo $TPL_VAR["data_refund"]["bank_depositor"]?>" maxlength="20" /><?php }else{?>:&nbsp; <?php echo $TPL_VAR["data_refund"]["bank_depositor"]?><?php }?></li>
					</ul>
					<ul>
						<li class="th">계좌번호</li>
						<li class="td"><?php if($TPL_VAR["data_refund"]["status"]=='request'){?><input type="text" name="bank_account" value="<?php echo $TPL_VAR["data_refund"]["bank_account"]?>" maxlength="30" /><?php }else{?>:&nbsp; <?php echo $TPL_VAR["data_refund"]["bank_account"]?><?php }?></li>
					</ul>
					<ul>
						<li class="th">상세사유</li>
						<li class="td"><?php if($TPL_VAR["data_refund"]["status"]=='request'){?><textarea name="refund_reason"><?php echo $TPL_VAR["data_refund"]["refund_reason"]?></textarea><?php }else{?>:&nbsp; <?php echo $TPL_VAR["data_refund"]["refund_reason"]?><?php }?></li>
					</ul>
				</div>
<?php if($TPL_VAR["data_refund"]["status"]=='request'){?></form><?php }else{?></div><?php }?>
			</li>
		</ul>

<?php if($TPL_VAR["data_refund"]["status"]=='complete'){?>
		<ul class="order_settle">
			<li>
				<h4 class="title">환불금액</h4>
				[<?php echo $TPL_VAR["data_order"]["mpayment"]?><!-- <?php echo $TPL_VAR["data_refund"]["mcancel_type"]?> -->] <?php echo number_format($TPL_VAR["data_refund"]["refund_price_sum"])?>

				+ [마일리지] <?php echo number_format($TPL_VAR["data_refund"]["refund_emoney"])?>

				+ [예치금] <?php echo number_format($TPL_VAR["data_refund"]["refund_cash"])?>

<?php if($TPL_VAR["data_refund"]["return_shipping_price"]> 0){?> - [반품배송비] <?php echo get_currency_price($TPL_VAR["data_refund"]["return_shipping_price"])?> <?php }?>
				= <strong class="pointcolor"><?php echo number_format($TPL_VAR["tot"]["refund_total_price"])?></strong>
				(상품금액 : <?php echo number_format($TPL_VAR["data_refund"]["refund_price_sum"]-$TPL_VAR["data_refund"]["refund_delivery"])?>

				+ 배송비 <?php echo number_format($TPL_VAR["data_refund"]["refund_delivery"])?>)
			</li>
		</ul>
<?php }?>

		<div class="btn_area_b">
			<a href="/mypage/refund_catalog" class="btn_resp size_c">환불 목록</a>
		</div>
		
		<h3 class="title_sub1">환불 절차</h3>
		<ol class="step_type1">
			<li>
				<p class="tle"><span class="num">1</span> 환불신청</p>
				<p class="cont">고객님의 환불신청이 접수되었습니다.</p>
			</li>
			<li>
				<p class="tle"><span class="num">2</span> 환불처리중</p>
				<p class="cont">고객님의 환불건을 처리중입니다.</p>
			</li>
			<li>
				<p class="tle"><span class="num">3</span> 환불완료</p>
				<p class="cont">고객님께 환불해드렸습니다.</p>
			</li>
		</ol>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->






<div id="gift_use_lay" class="resp_layer_pop hide">
	<h4 class="title">사은품 이벤트 정보</h4>
	<div class="y_scroll_auto">
		<div class="layer_pop_contents v3">
			
		</div>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>


<script type="text/javascript">
	$(function(){
		// 사은품 지급 조건 상세
		$(".gift_log").bind('click', function(){
			$.ajax({
				type: "post",
				url: "./gift_use_log",
				data: "order_seq="+$(this).attr('order_seq')+"&item_seq="+$(this).attr('item_seq'),
				success: function(result){
					if	(result){
						$("#gift_use_lay .layer_pop_contents").html(result);
						//사은품 이벤트 정보
						showCenterLayer('#gift_use_lay');
						//openDialog(getAlert('mp122'), "gift_use_lay", {"width":"450","height":"220"});
					}
				}
			});
		});
	});
</script>