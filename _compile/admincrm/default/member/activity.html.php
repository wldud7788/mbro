<?php /* Template_ 2.2.6 2022/05/17 12:05:23 /www/music_brother_firstmall_kr/admincrm/skin/default/member/activity.html 000009824 */ 
$TPL_todayResult_1=empty($TPL_VAR["todayResult"])||!is_array($TPL_VAR["todayResult"])?0:count($TPL_VAR["todayResult"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<style>
	.viewGoods {background-color:#B2EBF4; font-weight:bold;}
	.goods_view_box { height: 180px; overflow-y: auto }
</style>
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="14%" />
		<col width="19%" />
		<col width="14%" />
		<col width="19%" />
		<col width="14%" />
		<col width="20%" />
	</colgroup>
	<thead>
		<tr>
			<th colspan="6">활동 정보</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th class="its-th">캐시</th>
			<td class="its-td">
				<a href="../member/emoney_list"><span class="blue"><?php echo get_currency_price($TPL_VAR["emoney"], 3)?></span></a>
			</td>
			<th class="its-th">예치금</th>
			<td class="its-td">
				<a href="../member/cash_list"><span class="blue"><?php echo get_currency_price($TPL_VAR["cash"], 3)?></span></a>
			</td>
			<th class="its-th">포인트</th>
			<td class="its-td">
				<a href="../member/point_list"><span class="blue"><?php echo get_currency_price($TPL_VAR["point"])?>P</span></a>
			</td>
		</tr>
		<tr>
			<th class="its-th">쿠폰/코드</th>
			<td class="its-td">
				<a href="../member/member_coupon_list"><span class="blue"><?php echo number_format($TPL_VAR["unusedcount"])?> / <?php echo number_format($TPL_VAR["promotionCount"])?></span></a>
			</td>
			<th class="its-th">내가 추천한 회원</th>
			<td class="its-td">
				<?php echo $TPL_VAR["recommend"]?>

			</td>
			<th class="its-th">나를 추천한 회원</th>
			<td class="its-td">
				<?php echo number_format($TPL_VAR["totalrecommend"])?>명
			</td>
		</tr>
		<tr>
			<th class="its-th">방문수</th>
			<td class="its-td">
				<?php echo $TPL_VAR["login_cnt"]?>회
			</td>
			<th class="its-th">누적 실결제금액</th>
			<td class="its-td">
				<?php echo get_currency_price($TPL_VAR["order_sum"], 3)?>

			</td>
			<th class="its-th">누적 주문수</th>
			<td class="its-td">
				<?php echo number_format($TPL_VAR["order_cnt"])?>회 (평균 : <?php echo get_currency_price(($TPL_VAR["order_sum"]/$TPL_VAR["order_cnt"]), 3)?>)
			</td>
		</tr>
		<tr>
			<th class="its-th">최근 로그인</th>
			<td class="its-td">
<?php if($TPL_VAR["lastlogin_spot_name"]){?>
					<?php echo $TPL_VAR["lastlogin_spot_name"]?><br /> 
<?php }?>
				<?php echo $TPL_VAR["lastlogin_date"]?><br />
				IP: <?php echo $TPL_VAR["login_addr"]?>

			</td>
			<th class="its-th">최근 수정일</th>
			<td class="its-td">
				<?php echo $TPL_VAR["update_date"]?>

			</td>
			<th class="its-th">최근 성인인증일</th>
			<td class="its-td">
				<?php echo $TPL_VAR["adult_info"]["lst"]?><?php if($TPL_VAR["adult_info"]["lst"]){?><br /><?php }?>
				<a href="#" id="adult_history"><span class="blue">내역 ></span></a>
			</td>
		</tr>
	</tbody>
</table>
<div style="height:20px;"></div>

<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="42%" />
		<col width="8%" />
		<col width="50%" />
	</colgroup>
	<tbody>
		<tr>
			<th class="its-th-align center" colspan="2"><strong>고객 데이터</strong></th>
			<th class="its-th-align center"><strong>상품</strong></th>
		</tr>
		<tr>
			<td class="its-td todayTr <?php if($TPL_VAR["today_cnt"]){?>viewGoods<?php }?>" <?php if($TPL_VAR["today_cnt"]){?>onclick="today_goods_view();" style="cursor:pointer;"<?php }?>>최근 본 상품</td>
			<td class="its-td todayTr right pdr15 <?php if($TPL_VAR["today_cnt"]){?>viewGoods<?php }?>"><?php echo $TPL_VAR["today_cnt"]?>건</td>
			<td class="its-td pdt15" rowspan="6" valign="top">
				<div id="goods_view" class="goods_view_box">
					<table width="100%" cellspacing="0" cellpadding="0">
<?php if($TPL_todayResult_1){foreach($TPL_VAR["todayResult"] as $TPL_V1){?>
						<tr>
							<td width="80" rowspan="2"><a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo $TPL_V1["image"]?>" width="70" height="50" onerror="/data/skin/default/images/common/noimage.gif"></a></td>
							<td align="left" style="padding-left:5px;"><a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo $TPL_V1["goods_name"]?></a></td>
						</tr>
						<tr>
							<td style="padding-left:5px;"><?php echo get_currency_price($TPL_V1["price"])?></td>
						</tr>
						<tr><td colspan="2" height="10"></td></tr>
<?php }}?>
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td class="its-td cartTr" <?php if($TPL_VAR["cartCount"]){?>onclick="cart_goods_view();" style="cursor:pointer;"<?php }?>>장바구니에 담은 상품</td>
			<td class="its-td cartTr right pdr15"><?php echo $TPL_VAR["cartCount"]?>건</td>
		</tr>
		<tr>
			<td class="its-td wishTr" <?php if($TPL_VAR["wishCount"]){?>onclick="wish_goods_view();" style="cursor:pointer;"<?php }?>>위시리스트에 담은 상품</td>
			<td class="its-td wishTr right pdr15"><?php echo $TPL_VAR["wishCount"]?>건</td>
		</tr>
		<tr>
			<td class="its-td restockTr" <?php if($TPL_VAR["restockCount"]){?>onclick="restock_goods_view();" style="cursor:pointer;"<?php }?>>재입고알림을 요청한 상품</td>
			<td class="its-td restockTr right pdr15"><?php echo $TPL_VAR["restockCount"]?>건</td>
		</tr>
		<tr>
			<td class="its-td searchTr" <?php if($TPL_VAR["searchCount"]){?>onclick="search_word_view();" style="cursor:pointer;"<?php }?>>최근 검색어</td>
			<td class="its-td searchTr right pdr15"><?php echo $TPL_VAR["searchCount"]?>건</td>
		</tr>
	</tbody>
</table>
<script>
	$(document).ready(function() {
<?php if($TPL_VAR["today_cnt"]== 0){?>
<?php if($TPL_VAR["cartCount"]){?>
				cart_goods_view()
<?php }elseif($TPL_VAR["wishCount"]){?>
				wish_goods_view();
<?php }elseif($TPL_VAR["restockCount"]){?>
				restock_goods_view();
<?php }elseif($TPL_VAR["likeCount"]){?>
				fblike_goods_view();
<?php }?>
<?php }?>

		$("#adult_history").bind("click",function(event){
			openDialog("<?php echo $TPL_VAR["user_name"]?>님의 인증내역 <span class=desc>해당 회원의 최근10건의 성인인증내역입니다.</span> ", "adultPopup", {"width":"700","height":"600"});
		});

	});

	function wish_goods_view(){
		$.ajax({
			type: "post",
			url: "../member/wish_goods_view",
			success: function(result){
				$("#goods_view").html(result);
			}
		});	
		$(".todayTr").removeClass("viewGoods");
		$(".wishTr").addClass("viewGoods");
		$(".cartTr").removeClass("viewGoods");
		$(".restockTr").removeClass("viewGoods");
		$(".fblikeTr").removeClass("viewGoods");
		$(".searchTr").removeClass("viewGoods");
	}

	function today_goods_view(){
		$.ajax({
			type: "post",
			url: "../member/today_goods_view",
			success: function(result){
				$("#goods_view").html(result);
			}
		});
		$(".todayTr").addClass("viewGoods");
		$(".wishTr").removeClass("viewGoods");
		$(".cartTr").removeClass("viewGoods");
		$(".restockTr").removeClass("viewGoods");
		$(".fblikeTr").removeClass("viewGoods");
		$(".searchTr").removeClass("viewGoods");
	}

	function cart_goods_view(){
		$.ajax({
			type: "post",
			url: "../member/cart_goods_view",
			success: function(result){
				$("#goods_view").html(result);
			}
		});
		$(".todayTr").removeClass("viewGoods");
		$(".wishTr").removeClass("viewGoods");
		$(".cartTr").addClass("viewGoods");
		$(".restockTr").removeClass("viewGoods");
		$(".fblikeTr").removeClass("viewGoods");
		$(".searchTr").removeClass("viewGoods");
	}

	function fblike_goods_view(){
		$.ajax({
			type: "post",
			url: "../member/fblike_goods_view",
			success: function(result){
				$("#goods_view").html(result);
			}
		});
		$(".todayTr").removeClass("viewGoods");
		$(".wishTr").removeClass("viewGoods");
		$(".cartTr").removeClass("viewGoods");
		$(".restockTr").removeClass("viewGoods");
		$(".fblikeTr").addClass("viewGoods");
		$(".searchTr").removeClass("viewGoods");
		
	}

	function restock_goods_view(){
		$.ajax({
			type: "post",
			url: "../member/restock_goods_view",
			success: function(result){
				$("#goods_view").html(result);
			}
		});
		$(".todayTr").removeClass("viewGoods");
		$(".wishTr").removeClass("viewGoods");
		$(".cartTr").removeClass("viewGoods");
		$(".restockTr").addClass("viewGoods");
		$(".fblikeTr").removeClass("viewGoods");
		$(".searchTr").removeClass("viewGoods");
		
	}

	function search_word_view(){
		$.ajax({
			type: "post",
			url: "../member/search_word_view",
			success: function(result){
				$("#goods_view").html(result);
			}
		});
		$(".todayTr").removeClass("viewGoods");
		$(".wishTr").removeClass("viewGoods");
		$(".cartTr").removeClass("viewGoods");
		$(".restockTr").removeClass("viewGoods");
		$(".fblikeTr").removeClass("viewGoods");
		$(".searchTr").addClass("viewGoods");
	}
</script>
<!--성인인증내역-->
<div id="adultPopup" class="hide">
<table class="info-table-style" style="width:100%">
	<tbody>
		<tr>
			<th class="its-th-align center">번호</th>
			<th class="its-th-align center">인증수단</th>
			<th class="its-th-align center">인증날짜</th>
			<th class="its-th-align center" width="420px">접속환경</th>
		</tr>
<?php if(is_array($TPL_R1=$TPL_VAR["adult_info"]["res"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
		<tr>
			<td class="its-td"><?php echo $TPL_I1+ 1?></td>
			<td class="its-td">
<?php if($TPL_V1["auth_type"]=='phone'){?>휴대폰인증<?php }elseif($TPL_V1["auth_type"]=='ipin'){?>아이핀<?php }?>
			</td>
			<td class="its-td"><?php echo $TPL_V1["regist_date"]?></td>
			<td class="its-td"><?php echo $TPL_V1["user_agent"]?></td>
		</tr>
<?php }}?>
	</tbody>
</table>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>