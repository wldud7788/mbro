<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/coupon/coupongoodsreviewer.html 000012489 */ 
$TPL_salestoreitemloop_1=empty($TPL_VAR["salestoreitemloop"])||!is_array($TPL_VAR["salestoreitemloop"])?0:count($TPL_VAR["salestoreitemloop"]);
$TPL_salserefereritemloop_1=empty($TPL_VAR["salserefereritemloop"])||!is_array($TPL_VAR["salserefereritemloop"])?0:count($TPL_VAR["salserefereritemloop"]);
$TPL_issuegoods_1=empty($TPL_VAR["issuegoods"])||!is_array($TPL_VAR["issuegoods"])?0:count($TPL_VAR["issuegoods"]);
$TPL_issuecategorys_1=empty($TPL_VAR["issuecategorys"])||!is_array($TPL_VAR["issuecategorys"])?0:count($TPL_VAR["issuecategorys"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 쿠폰 정보( 마이페이지 > 쿠폰내역 > [조회] 시 뜨는 레이어 ) @@
- 파일위치 : [스킨폴더]/coupon/coupongoodsreviewer.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<style>
.ui-dialog[aria-labelledby='ui-dialog-title-coupongoodsreviewerpopup'] { z-index:10100 !important; }
.coupongoodsrevieweryes img.goodsThumbView { width:76px; height:76px; margin-right:10px; }
.coupongoodsrevieweryes .issueGoods { padding:5px; border-top:1px #ddd solid; border-bottom:1px #ddd solid; }
.coupongoodsrevieweryes .issueGoods td { padding-left:0 !important; }
.coupongoodsrevieweryes .issueGoods .name { font-size:15px; }
</style>

<script type="text/javascript">
$(document).ready(function() { 
	help_tooltip();
}); 
</script>

<div >
	<table class="table_row_a">
	<colgroup>
	<col width="90" /><col  />
	</colgroup> 
	<tbody>
	<tr>
		<th><p>쿠폰명</p></th> 
		<td><?php echo $TPL_VAR["coupons"]["coupon_name"]?></td>
	</tr>
	<tr>
		<th><p>혜택</p></th>  
		<td>
			<!-- 혜택 -->
<?php if($TPL_VAR["coupons"]["use_type"]=='offline'){?>
				<?php echo $TPL_VAR["coupons"]["benefit"]?>

<?php }else{?>
<?php if($TPL_VAR["coupons"]["type"]=='offline_emoney'){?>
					마일리지 <?php echo get_currency_price($TPL_VAR["coupons"]["offline_emoney"], 2)?> 지급
				
<?php }else{?>
<?php if($TPL_VAR["coupons"]["type"]=='shipping'||strstr($TPL_VAR["coupons"]["type"],'_shipping')){?>
<?php if($TPL_VAR["coupons"]["shipping_type"]=='free'){?>
							기본 배송비 무료, (최대 <?php echo get_currency_price($TPL_VAR["coupons"]["max_percent_shipping_sale"], 2)?>)
<?php }elseif($TPL_VAR["coupons"]["shipping_type"]=='won'){?>
							기본 배송비 <?php echo get_currency_price($TPL_VAR["coupons"]["won_shipping_sale"], 2)?> 할인
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["coupons"]["sale_type"]=='percent'){?>
							<?php echo $TPL_VAR["coupons"]["percent_goods_sale"]?>% 할인  (최대할인금액 <?php echo get_currency_price($TPL_VAR["coupons"]["max_percent_goods_sale"], 2)?>)
<?php }else{?>
							<?php echo get_currency_price($TPL_VAR["coupons"]["won_goods_sale"], 2)?> 할인
<?php }?> 
<?php }?> 
<?php }?> 
<?php }?>

			<!-- 중복 -->
<?php if($TPL_VAR["coupons"]["duplication_use"]== 1){?>
<?php if($TPL_VAR["coupons"]["type"]=='shipping'||$TPL_VAR["coupons"]["type"]=='mobile'||$TPL_VAR["coupons"]["type"]=='download'){?>
					<div>중복다운로드 및 중복할인 </div>
<?php }else{?>
					<div>중복할인</div>
<?php }?>
<?php }?>
		</td>
	</tr>

<?php if(!($TPL_VAR["coupons"]["type"]=='offline_emoney'||$TPL_VAR["coupons"]["type"]=='point')){?>
	<tr>
		<th><p>유효기간</p></th>  
		<td>
<?php if($TPL_VAR["coupons"]["coupondown"]){?>
			<?php echo $TPL_VAR["coupons"]["issue_startdate"]?> ~ <?php echo $TPL_VAR["coupons"]["issue_enddate"]?> (<?php if($TPL_VAR["coupons"]["issuedaylimituse"]){?><?php echo number_format($TPL_VAR["coupons"]["issuedaylimit"])?>일 남음<?php }else{?><?php echo number_format($TPL_VAR["coupons"]["issuedaylimit"])?>일 지남<?php }?>)
<?php }else{?>
<?php if($TPL_VAR["coupons"]["issue_priod_type"]=='day'){?>
				발급일로부터 <?php echo number_format($TPL_VAR["coupons"]["after_issue_day"])?>일 동안 사용 가능
<?php }elseif($TPL_VAR["coupons"]["issue_priod_type"]=='months'){?>
				발급 당월 말일까지 
<?php }elseif($TPL_VAR["coupons"]["issue_priod_type"]=='date'){?>
				<?php echo $TPL_VAR["coupons"]["issue_startdate"]?> ~ <?php echo $TPL_VAR["coupons"]["issue_enddate"]?>

				<br/>(<?php if($TPL_VAR["coupons"]["issuedaylimituse"]){?><?php echo number_format($TPL_VAR["coupons"]["issuedaylimit"])?>일 남음<?php }else{?><?php echo number_format($TPL_VAR["coupons"]["issuedaylimit"])?>일 지남<?php }?>)
<?php }?>
<?php }?>
		</td>
	</tr>
<?php }?>

	<!-- <tr><td class="cell left"  style="background:#f5f5f5;" colspan="2" >사용제한 </td></tr> -->
	<tr>
		<td colspan="2">
			<div>
<?php if($TPL_VAR["coupons"]["use_type"]=='offline'){?>
					<ul>
<?php if($TPL_VAR["coupons"]["limit_txt"]){?><li>√ <?php echo $TPL_VAR["coupons"]["limit_txt"]?><!-- 매장 사용제한 --></li><?php }?>
						<li>√ 
<?php if($TPL_VAR["coupons"]["sale_agent"]=='m'){?> 
<?php if($TPL_VAR["coupons"]["use_type"]=='offline'){?>모바일/태블릿 환경에서만 다운로드 가능
<?php }else{?>모바일/태블릿 환경에서만 사용 가능<?php }?>
<?php }elseif($TPL_VAR["coupons"]["sale_agent"]=='app'){?> 쇼핑몰앱 환경에서만 사용 가능
<?php }else{?>모든 환경에서 사용 가능
<?php }?><!-- 결제수단 -->
						</li>
					</ul>
<?php }else{?>
					<ul>
<?php if($TPL_VAR["checkO2OService"]){?>
						<li>
							√ 
<?php if($TPL_VAR["coupons"]["sale_store"]=='all'){?>
								온/오프 둘 다 사용 가능
<?php }elseif($TPL_VAR["coupons"]["sale_store"]=='on'){?>
								온라인에서만 사용 가능
<?php }elseif($TPL_VAR["coupons"]["sale_store"]=='off'){?>
								오프라인에서만 사용 가능
<?php if($TPL_VAR["salestoreitemloop"]){?>
<?php if($TPL_salestoreitemloop_1){foreach($TPL_VAR["salestoreitemloop"] as $TPL_V1){?>
<?php if($TPL_VAR["coupons"]["sale_store"]=='off'&&in_array($TPL_V1["o2o_store_seq"],$TPL_VAR["coupons"]["sale_store_item_arr"])){?>
											<br/>&nbsp;&nbsp;&nbsp;- <span class="left"><?php echo $TPL_V1["pos_name"]?></span>
<?php }?>
<?php }}?>
<?php }?>
<?php }?>
						</li>
						<!-- 온/오프 -->
<?php }?>
						<li>√ <?php if($TPL_VAR["coupons"]["coupon_same_time"]=='Y'){?>다른 쿠폰과 동시 사용 가능<?php }else{?>다른 쿠폰과 동시 사용 불가<?php }?></li><!-- 단독 -->
						<li>√ <?php echo get_currency_price($TPL_VAR["coupons"]["limit_goods_price"], 2)?> 이상 구매 시</li><!-- 금액 -->
						<li>√ 
<?php if($TPL_VAR["coupons"]["sale_agent"]=='m'){?> 
<?php if($TPL_VAR["coupons"]["use_type"]=='offline'){?>모바일/태블릿 환경에서만 다운로드 가능
<?php }else{?>모바일/태블릿 환경에서만 사용 가능<?php }?>
<?php }elseif($TPL_VAR["coupons"]["sale_agent"]=='app'){?> 쇼핑몰앱 환경에서만 사용 가능
<?php }else{?>모든 환경에서 사용 가능
<?php }?><!-- 결제수단 -->
						</li>
						<li> √ 
<?php if($TPL_VAR["coupons"]["sale_payment"]=='b'){?>무통장 결제 시 사용 가능
<?php }else{?>모든 결제수단에 사용 가능
<?php }?><!-- 사용환경 --></li>
						<li>√ 
<?php if($TPL_VAR["coupons"]["sale_referer"]=='n'){?> 바로 접속 시 사용 가능 
<?php }elseif($TPL_VAR["coupons"]["sale_referer"]=='y'){?> 특정 유입경로로 방문 시 사용 가능 
<?php if($TPL_VAR["coupons"]["sale_referer_type"]=='s'){?> 
<?php if($TPL_VAR["salserefereritemloop"]){?> 
<?php if($TPL_salserefereritemloop_1){foreach($TPL_VAR["salserefereritemloop"] as $TPL_V1){?>
										<br/>&nbsp;&nbsp;&nbsp;- <span class="left"><?php echo $TPL_V1["referersale_name"]?></span>
<?php }}?>
<?php }?> 
<?php }else{?>모든 유입경로
<?php }?> 
<?php }else{?>유입경로와 무관하게 사용 가능
<?php }?><!-- 유입경로 -->
						</li>
						<!-- 상품 -->
<?php if($TPL_VAR["coupons"]["type"]=='shipping'||strstr($TPL_VAR["coupons"]["type"],'_shipping')){?>
							<!-- <li>√ 상품과는 무관하게 사용 가능.</li> -->
<?php }else{?>
<?php if($TPL_VAR["coupons"]["issue_type"]=='issue'){?><li>√ 특정 상품/카테고리에서 사용 가능</li>
<?php if($TPL_VAR["coupons"]["salescost_provider"]> 0&&$TPL_VAR["coupons"]["provider_list"]){?>
									<li>√ 특정 입점판매자의 상품에서 사용가능</li>
<?php }?>
<?php }elseif($TPL_VAR["coupons"]["issue_type"]=='except'){?><li>√ 특정 상품/카테고리에서는 사용 불가</li>
<?php if($TPL_VAR["coupons"]["salescost_provider"]> 0&&$TPL_VAR["coupons"]["provider_list"]){?>
									<li>√ 특정 입점판매자의 상품에서 사용가능</li>
<?php }?>
<?php }else{?> 
<?php if($TPL_VAR["coupons"]["salescost_provider"]> 0&&$TPL_VAR["coupons"]["provider_list"]){?>
									<li>√ 특정 입점판매자의 상품에서 사용가능 </li>
<?php }else{?>
									<li>√ 모든 상품에 사용 가능</li>
<?php }?>
<?php }?>
<?php }?>
					</ul>
<?php }?>
			</div>
		</td>
	</tr>
<?php if($TPL_VAR["coupons"]["issue_type"]=='issue'||$TPL_VAR["coupons"]["issue_type"]=='except'){?>
	<tr	class="<?php if(($TPL_VAR["coupons"]["type"]=='offline_emoney'||$TPL_VAR["coupons"]["type"]=='point')){?>hide<?php }?>" >
		<th><p>상품번호 <span class="Dib">입력</span></p></td>
		<td>
			<input type="text" name="goods_seq" id="coupongoods_goods_seq" size="5"> <input type="button" class="btn_resp size_b" name="goodssearchbtn" value="검색" coupon_seq="<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>" />
			 <span class="helpicon"  title="http://<?php if($TPL_VAR["config_system"]["domain"]){?><?php echo $TPL_VAR["config_system"]["domain"]?><?php }else{?><?php echo $TPL_VAR["config_system"]["subDomain"]?><?php }?>/goods/view?no=<span class='red'><?php echo $TPL_VAR["coupons"]["coupon_seq"]?></span><br/>상품번호이란 상품 URL에 있는 숫자로 상품마다 고유합니다."  options="{alignX: 'right'}"></span>
		</td>
	</tr>
	<tr>
		<td  class="cell left <?php if(($TPL_VAR["coupons"]["type"]=='offline_emoney'||$TPL_VAR["coupons"]["type"]=='point')){?>hide<?php }?>"  colspan="2" >
			<div style="border-left:1px #ececec;border-top:2px #eaeaea;padding:5px; width:98%; height:150px; border:0px;overflow:auto" class="" readonly>
<?php if($TPL_issuegoods_1){foreach($TPL_VAR["issuegoods"] as $TPL_V1){?> 
				<!-- <div class='goods fl'>
					<div align='center' class='image'>
						<img class="goodsThumbView" alt="" src="<?php echo $TPL_V1["image"]?>" width="50" height="50">
					</div>
					<div align='center' class='name' style='white-space:nowrap;'><?php echo $TPL_V1["goods_name"]?></div>
					<div align='center' class='price'><?php echo number_format($TPL_V1["price"])?></div> 
				</div> -->
<?php }}?>
			<div style="clear: both"></div>
<?php if($TPL_issuecategorys_1){foreach($TPL_VAR["issuecategorys"] as $TPL_V1){?> 
			<div ><a href="/goods/catalog?code=<?php echo $TPL_V1["category_code"]?>" target="_blank" ><span class="blue"><?php echo $TPL_V1["category"]?></span></a></div>
<?php }}?> 
			</div>
		</td>
	</tr>
<?php }?>
	</tbody>
	</table>
</div>

<div id="coupongoodsreviewerpopup" class="hide">   
	<div class="coupongoodsreviewerno"  class="center"><span class="red"  style="margin:20px 0;font-size:20px;line-height:25px;font-weight:bold;" >쿠폰사용이 안되는 상품입니다.</span></div>
	<div class="coupongoodsrevieweryes center"> 
		<p class="Pt5 Fs19 Fw500 gray_01">쿠폰사용이 가능한 상품입니다.</p>
		<p class="Pt10 gray_06">(쿠폰 사용조건에 따라 적용여부가 달라질 수 있습니다)</p>
	</div>
	<div class="coupongoodsrevieweryes coupongoodsreviewerno center Mt10"> 
		<div class="issueGoods" > 
			<table border="0" cellspacing="10" cellpadding="10" >
				<tr>
				<td rowspan="2" align='center' ><div class='image'><img class="goodsThumbView" alt="" src="" width="80" height="80"></div>
				</td> 
				<td  align='left' ><div class='name' style='white-space:nowrap;'>test</div></td>
				</tr>
				<tr>
				<td  align='left' class="Pl10"><div class='price'>10,000원</div>  </td>
				</tr>
			</table>
		</div> 
		<div class="center Pt20">
			<button type="button" name="coupongoodsdetail" class="coupongoodsdetail btn_resp size_b color2" >상품상세보기</button>
		</div>
	</div> 
</div>