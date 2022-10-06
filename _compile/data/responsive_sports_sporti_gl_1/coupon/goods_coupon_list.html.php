<?php /* Template_ 2.2.6 2022/03/18 15:13:30 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/coupon/goods_coupon_list.html 000003468 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 쿠폰받기( 상품상세 > 쿠폰받기 시 뜨는 레이어 ) @@
- 파일위치 : [스킨폴더]/coupon/goods_coupon_list.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_VAR["list"]){?>
<div class="res_table bd1">
	<ul class="thead">
		<li style="width:25%;">쿠폰명</li>
		<li>혜택</li>
		<li style="width:110px;">유효기간</li>
		<li style="width:64px;">남은 기간</li>
		<li style="width:72px;">발급</li>
	</ul>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
	<ul class="tbody <?php if($TPL_V1["unused_cnt"]){?>disabled<?php }?>">
		<li style="order:-6">
			<strong class="gray_01"><?php echo $TPL_V1["coupon_name"]?></strong>
<?php if($TPL_V1["sale_agent"]=='m'||$TPL_V1["type"]=='mobile'){?> <img src="/data/skin/responsive_sports_sporti_gl_1/images/board/icon/icon_mobile.gif" alt="사용제한 모바일" title="사용제한 모바일" /><?php }?>
		</li>
		<li class="subject pointcolor2 imp">
<?php if($TPL_V1["use_type"]=='offline'){?>
				<?php echo $TPL_V1["benefit"]?>

<?php }else{?>
<?php if($TPL_V1["type"]=='offline_emoney'){?>
					마일리지 <?php echo number_format($TPL_V1["offline_emoney"])?>원 지급
<?php }else{?>
<?php if($TPL_V1["type"]=='shipping'||strstr($TPL_V1["type"],'_shipping')){?>
<?php if($TPL_V1["shipping_type"]=='free'){?>
							기본 배송비 무료 (최대 <?php echo number_format($TPL_V1["max_percent_shipping_sale"])?>원)
<?php }elseif($TPL_V1["shipping_type"]=='won'){?>
							기본 배송비 <?php echo number_format($TPL_V1["won_shipping_sale"])?>원 할인
<?php }?>
<?php }else{?>
<?php if($TPL_V1["sale_type"]=='won'){?>
							<?php echo number_format($TPL_V1["won_goods_sale"])?>원 할인
<?php }elseif($TPL_V1["sale_type"]=='percent'){?>
							<?php echo $TPL_V1["percent_goods_sale"]?>% 할인 (최대할인금액 <?php echo number_format($TPL_V1["max_percent_goods_sale"])?>원)
<?php }?> 
<?php }?> 
<?php }?> 
<?php }?>
		</li>
		<li>
<?php if($TPL_V1["issue_priod_type"]=='day'){?>
				발급일 후 <?php echo number_format($TPL_V1["after_issue_day"])?>일
<?php }elseif($TPL_V1["issue_priod_type"]=='months'){?>
				발급 당월 말일까지
<?php }elseif($TPL_V1["issue_priod_type"]=='date'){?>
				~ <?php echo $TPL_V1["issue_enddate"]?>

<?php }?>
		</li>
		<li>
<?php if($TPL_V1["issue_priod_type"]=='day'){?>
				
<?php }elseif($TPL_V1["issue_priod_type"]=='date'){?>
<?php if($TPL_V1["issuedaylimituse"]){?><?php echo number_format($TPL_V1["issuedaylimit"])?>일<?php }else{?><?php echo number_format($TPL_V1["issuedaylimit"])?>일 지남<?php }?>
<?php }?>
		</li>
		<li>
<?php if($TPL_V1["unused_cnt"]){?>
			발급완료<span class="Dib">(<?php echo $TPL_V1["download_regist_date"]?>)</span>
<?php }else{?>
			<button type="button" name="couponDownloadButton" goods="<?php echo $_GET["no"]?>" coupon="<?php echo $TPL_V1["coupon_seq"]?>" class="btn_resp color2 size_a">받기</button>
<?php }?>
		</li>
	</ul>
<?php }}?>
</div>
<?php }else{?>
<div class="no_data_area2">
	다운로드 가능한 쿠폰이 없습니다.
</div>
<?php }?>