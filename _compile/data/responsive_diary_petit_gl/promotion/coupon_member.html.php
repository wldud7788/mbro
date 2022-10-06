<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/promotion/coupon_member.html 000005734 */  $this->include_("getCouponCode");?>
<script type="text/javascript" src="/app/javascript/js/promotion.js" ></script>
<link type="text/css" rel="stylesheet" charset="utf-8" href="/data/skin/responsive_diary_petit_gl/css/coupon.css" />
<?php echo getCouponCode('member')?>


<div class="<?php if($_GET["popup"]){?>designPopup<?php }?>" popupStyle="layer" popupSeq="coupon_<?php echo $_GET["type"]?>"  >
	<div id="promo<?php if($_GET["popup"]){?>_popup<?php }?>"  class="designPopupBody" >
		<!-- 상단 이미지 -->
		<div style="text-align:center; margin-bottom:10px;"><img src="/data/skin/responsive_diary_petit_gl/images/promotion/main_img_newmem.jpg" alt="" /></div>

		<!-- 컴백회원 쿠폰 리스트 -->
<?php if($TPL_VAR["getCouponCodedatacnt"]){?>
<?php if(is_array($TPL_R1=($TPL_VAR["getCouponCodedata"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div style="width:90%; border-top:1px solid #e6e6e6; margin:0 auto"></div>
			<table width="254" cellpadding="0" cellspacing="0" border="0" align="center" style="padding-top:15px;" class="designCouponlist" designElement='couponlayer' templatePath="promotion/<?php echo getcouponpagepopup($_GET,'url')?>.html" >
			<tr>
				<td align="center">
					<div class="left">
<?php if($TPL_V1["type"]=='shipping'||strstr($TPL_V1["type"],'_shipping')){?>
<?php if($TPL_V1["shipping_type"]=='free'){?> <div class="online_coupon" style="<?php if($TPL_V1["coupon_img"]=='4'){?>background:url('/data/coupon/<?php echo $TPL_V1["coupon_image4"]?>')<?php }else{?>background:url('/data/coupon/coupon<?php echo $TPL_V1["sametime_shipping_img"]?>_skin_0<?php echo $TPL_V1["coupon_img"]?>.gif')<?php }?> no-repeat;" ></div>
<?php }elseif($TPL_V1["shipping_type"]=='won'){?>
								<div class="online_coupon_<?php echo $TPL_V1["shipping_type"]?>_<?php echo $TPL_V1["couponsametimeimg"]?>" style="<?php if($TPL_V1["coupon_img"]=='4'){?>background:url('/data/coupon/<?php echo $TPL_V1["coupon_image4"]?>')<?php }else{?>background:url('/data/coupon/coupon<?php echo $TPL_V1["sametime_shipping_img"]?>_skin_0<?php echo $TPL_V1["coupon_img"]?>.gif')<?php }?> no-repeat;">
									<div class="discount_price"><?php echo $TPL_V1["view_coupon_html"]?></div>
								</div> 
<?php }?>
<?php }else{?>
							<div class="online_coupon_<?php echo $TPL_V1["sale_type"]?>_<?php echo $TPL_V1["couponsametimeimg"]?>" style="<?php if($TPL_V1["coupon_img"]=='4'){?>background:url('/data/coupon/<?php echo $TPL_V1["coupon_image4"]?>')<?php }else{?>background:url('/data/coupon/coupon<?php echo $TPL_V1["sametime_shipping_img"]?>_skin_0<?php echo $TPL_V1["coupon_img"]?>.gif')<?php }?> no-repeat;">
								<div class="discount_price"><?php echo $TPL_V1["view_coupon_html"]?></div>
							</div> 
<?php }?>
					</div>
				</td>
				</tr>
			</table>
			<table width="254" cellpadding="0" cellspacing="0" border="0" class="cpn_list" align="center">
				<tr>
					<th>다운 기간</th>    
					<td>모든 신규가입 회원에게 <b>자동 제공</b></td>
				</tr>
				<tr>
					<th nowrap="nowrap">유효 기간</th>    
					<td nowrap="nowrap">
<?php if($TPL_V1["issue_priod_type"]=='day'){?>
							발급일로부터 <b><?php echo number_format($TPL_V1["after_issue_day"])?>일</b> 동안 사용 가능
<?php }elseif($TPL_V1["issue_priod_type"]=='months'){?>
						발급 당월 말일까지 (~<?php echo $TPL_V1["downloaddate_endday"]?>)
<?php }elseif($TPL_V1["issue_priod_type"]=='date'){?>
							<?php echo $TPL_V1["issue_startdate"]?> ~ <?php echo $TPL_V1["issue_enddate"]?> (<?php if($TPL_V1["issuedaylimituse"]){?><?php echo number_format($TPL_V1["issuedaylimit"])?>일 남음<?php }else{?><?php echo number_format($TPL_V1["issuedaylimit"])?>일 지남<?php }?>)
<?php }?>
					</td>
				</tr>
				<tr>
					<th>제한 금액</th>
					<td><b><?php echo ($TPL_V1["limit_goods_price"])?></b>원 이상 구매 시 사용 가능</td>
				</tr>
				<tr>    
					<td colspan="2" align="right"><span class="btn_style hand coupongoodsreviewbtn" coupon_type="<?php if($TPL_V1["type"]=='offline_coupon'){?>offline<?php }else{?>online<?php }?>" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>" download_seq="<?php echo $TPL_V1["download_seq"]?>"  use_type="<?php echo $TPL_V1["use_type"]?>"  issue_type="<?php echo $TPL_V1["issue_type"]?>"   coupon_name="<?php echo $TPL_V1["coupon_name"]?>">자세히</span></td>
				</tr>
				</table>
<?php }}?>
<?php }?>
		<!--/컴백회원 쿠폰 리스트 -->

		<!--쿠폰 사용 주의사항 -->
		<table width="90%" cellpadding="0" cellspacing="0" border="0" align="center" style="padding:10px 10px; font-size:12px; background:#eaeaea; color:#7e7e7e; line-height:1.5em; margin-bottom:30px">
		<tr>
			<td><img src="/data/skin/responsive_diary_petit_gl/images/promotion/cpn_notice.gif" width="91" height="28" alt="쿠폰 사용 주의사항!" /></td>
		</tr>
		<tr>
				<td height="5"></td>
		</tr>
		<tr>
			<td>- 주문 후 반품/환불/취소 시 쿠폰은 복원해 줍니다.<br>
				- 발급된 쿠폰은 마이페이지에서 확인하실 수 있습니다.</td>
		</tr>
		</table>	
		</table>
		<!--쿠폰 사용 주의사항 -->
	</div>

<?php if($_GET["popup"]){?> 
	<div id="promo_popup_close">
	<span class='designPopupTodaymsg'  ><label><input type='checkbox' /> 오늘 하루 이 창을 열지 않음</label></span>&nbsp;&nbsp;&nbsp; <span style="color:#c0c0c0">|</span> &nbsp;&nbsp;&nbsp;<span class='designPopupClose hand'  >닫기</span><span style="font-size:12px">×</span>
	</div> 
<?php }?> 
</div>