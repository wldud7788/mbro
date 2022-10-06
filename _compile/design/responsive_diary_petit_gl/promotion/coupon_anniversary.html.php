<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/promotion/coupon_anniversary.html 000008161 */  $this->include_("getCouponCode");?>
<script type="text/javascript" src="/app/javascript/js/promotion.js" ></script>
<link type="text/css" rel="stylesheet" charset="utf-8" href="/data/skin/responsive_diary_petit_gl/css/coupon.css" />
<?php echo getCouponCode('anniversary')?>


<div class="<?php if($_GET["popup"]){?>designPopup<?php }?>" popupStyle="layer" popupSeq="coupon_<?php echo $_GET["type"]?>" >
	<div id="promo<?php if($_GET["popup"]){?>_popup<?php }?>"  class="designPopupBody" >
		<!--상단 이미지 --> 
		<div style="text-align:center; margin-bottom:10px;"><img src="/data/skin/responsive_diary_petit_gl/images/promotion/main_img_anniversary.jpg" alt=="" designImgSrcOri='Li4vaW1hZ2VzL3Byb21vdGlvbi9tYWluX2ltZ19hbm5pdmVyc2FyeS5qcGc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9wcm9tb3Rpb24vY291cG9uX2Fubml2ZXJzYXJ5Lmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9wcm9tb3Rpb24vbWFpbl9pbWdfYW5uaXZlcnNhcnkuanBn' designElement='image' /></div> 

		<!--회원 정보 -->
<?php if(defined('__ISUSER__')||defined('__ISADMIN__')){?>
			<div style="width:90%; border-top:1px solid #e6e6e6; margin:0 auto; text-align:center; font-size:15px; color:#000; letter-spacing:-1px; padding:10px 0">
			<b><?php echo $TPL_VAR["user_name"]?></b>님의 <?php if($TPL_VAR["anniversary"]){?><b><?php echo date("m월 d일",strtotime($TPL_VAR["thisyear_anniversary"]))?> <?php }?> 기념일</b>을 진심으로 축하하며,<br>
			<?php echo $TPL_VAR["config_basic"]["shopName"]?>에서 감사의 축하 쿠폰을 드립니다. 
			</div>
<?php }?>

		<!--기념일 쿠폰 리스트 -->
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
				<tr>
					<td height="3"></td>
				</tr>
				<tr>
					<td>
						<a href="/coupon?no=<?php echo $TPL_V1["coupon_seq"]?>&return_url=<?php echo $_SERVER["REQUEST_URI"]?>" target="actionFrame" hrefOri='L2NvdXBvbj9ubz17LmNvdXBvbl9zZXF9JnJldHVybl91cmw9e19TRVJWRVIuUkVRVUVTVF9VUkl9' ><img src="/data/skin/responsive_diary_petit_gl/images/promotion/btn_cpn_dn<?php if($TPL_V1["coupondownfinish"]){?>_finish<?php }elseif($TPL_V1["coupondownno"]){?>_no<?php }?>.gif" alt="쿠폰 다운받기" style="margin-top:5px" class="newcoupondownbtn<?php if($TPL_V1["coupondownfinish"]){?>_finish<?php }elseif($TPL_V1["coupondownno"]){?>_no<?php }?>" designImgSrcOri='Li4vaW1hZ2VzL3Byb21vdGlvbi9idG5fY3BuX2Ruez8gLmNvdXBvbmRvd25maW5pc2h9X2ZpbmlzaHs6IC5jb3Vwb25kb3dubm8gfV9ub3svfS5naWY=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9wcm9tb3Rpb24vY291cG9uX2Fubml2ZXJzYXJ5Lmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9wcm9tb3Rpb24vYnRuX2Nwbl9kbns/IC5jb3Vwb25kb3duZmluaXNofV9maW5pc2h7OiAuY291cG9uZG93bm5vIH1fbm97L30uZ2lm' designElement='image' /></a>
						</td>
				</tr>
			</table>
			<table width="254" cellpadding="0" cellspacing="0" border="0" class="cpn_list" align="center">
				<tr>
					<th>다운 기간</th>    
					<td>기념일 <b><?php echo $TPL_V1["before_anniversary"]?>일 전 ~ <?php echo $TPL_V1["after_anniversary"]?>일 이후</b>까지</td>
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
		<!--/기념일 쿠폰 리스트 -->

		<!--쿠폰 사용 주의사항 -->
		<table width="90%" cellpadding="0" cellspacing="0" border="0" align="center" style="padding:10px 10px; font-size:12px; background:#eaeaea; color:#7e7e7e; line-height:1.5em; margin-bottom:30px" designImgSrcOri='' >
			<tr>
				<td><img src="/data/skin/responsive_diary_petit_gl/images/promotion/cpn_notice.gif" width="91" height="28" alt="쿠폰 사용 주의사항!" designImgSrcOri='Li4vaW1hZ2VzL3Byb21vdGlvbi9jcG5fbm90aWNlLmdpZg==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9wcm9tb3Rpb24vY291cG9uX2Fubml2ZXJzYXJ5Lmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9wcm9tb3Rpb24vY3BuX25vdGljZS5naWY=' designElement='image' /></td>
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