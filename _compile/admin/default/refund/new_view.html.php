<?php /* Template_ 2.2.6 2022/05/17 12:36:53 /www/music_brother_firstmall_kr/admin/skin/default/refund/new_view.html 000076748 */ 
$TPL_data_refund_item_1=empty($TPL_VAR["data_refund_item"])||!is_array($TPL_VAR["data_refund_item"])?0:count($TPL_VAR["data_refund_item"]);
$TPL_process_log_1=empty($TPL_VAR["process_log"])||!is_array($TPL_VAR["process_log"])?0:count($TPL_VAR["process_log"]);
$TPL_refund_shipping_items_1=empty($TPL_VAR["refund_shipping_items"])||!is_array($TPL_VAR["refund_shipping_items"])?0:count($TPL_VAR["refund_shipping_items"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<style>
span.goods_name {display:inline-block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
.price {padding-right:5px;text-align:right}
div.left {float:left;padding-right:10px}
span.option {padding-right:10px;}

div.status_change_msg {display:none; padding:3px; line-height:20px;width:520px;text-align:center;}
select.status {border:3px solid #333;padding:5px;}
input.input_line,div.input_line,select.input_line { border:2px solid #DF171E; color:#DF171E; font-weight:bold; width:80px !important; }
input.input_line {text-align:right; }
input.input_line.disabled { border:1px solid #ddd; color:#999; }
input.input_line.w60 {width:60px !important;}
#sms_form .info-table-style, #sms_form .its-th-align {border:0px !important;}

table.goods_info tr td { border:0px !important; }
table.goods_info tr td  div{ padding-top:1px; }
</style>

<script type="text/javascript">
var pg_currency					= '<?php echo $TPL_VAR["data_order"]["pg_currency"]?>';
var pg_currency_exchange_rate	= '<?php echo $TPL_VAR["data_order"]["pg_currency_exchange_rate"]?>';
var gl_refund_status			= '<?php echo $TPL_VAR["data_refund"]["status"]?>';
var gl_order_cellphone			= '<?php echo $TPL_VAR["data_order"]["order_cellphone"]?>';
var gl_npay_use					= '<?php echo $TPL_VAR["npay_use"]?>';
var gl_refund_npay_order_id		= '<?php echo $TPL_VAR["data_refund"]["npay_order_id"]?>';
var gl_refund_userid			= '<?php echo $TPL_VAR["data_refund"]["userid"]?>';
var gl_order_pg					= '<?php echo $TPL_VAR["data_order"]["pg"]?>';
var gl_return_shipping_price	= '<?php echo $TPL_VAR["data_refund"]["return_shipping_price"]?>';
var gl_order_pg_currency		= '<?php echo $TPL_VAR["data_order"]["pg_currency"]?>';
var gl_basic_currency			= '<?php echo $TPL_VAR["basic_currency"]?>';
var gl_refund_ship_duty			= '<?php echo $TPL_VAR["data_refund"]["refund_ship_duty"]?>';
var gl_refund_ship_type			= '<?php echo $TPL_VAR["data_refund"]["refund_ship_type"]?>';
var gl_refund_order_seq 		= '<?php echo $TPL_VAR["data_refund"]["order_seq"]?>';
var gl_refund_code 				= '<?php echo $TPL_VAR["data_refund"]["refund_code"]?>';
var gl_refund_type				= '<?php echo $TPL_VAR["data_refund"]["refund_type"]?>';
var pay_emoney					= '<?php echo $TPL_VAR["data_order"]["emoney"]?>';	//결제시 사용한 마일리지
var pay_cash					= '<?php echo $TPL_VAR["data_order"]["cash"]?>';		//결제시 사용한 예치금

var gl_refund_penalty_deductible_price	= '<?php echo $TPL_VAR["tot"]["refund_penalty_deductible_price"]?>';		// 환불 위약금

</script>

<script type="text/javascript" src="/app/javascript/js/admin-refundNewView.js"></script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>
			<span class="bold fx16"  style="background-color:yellow"><?php echo $TPL_VAR["data_refund"]["refund_code"]?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span class="bold fx16 blue" style="background-color:yellow"><?php echo $TPL_VAR["data_refund"]["mstatus"]?></span>
			</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span class="btn large icon"><button type="button" onclick="location.href='catalog?<?php echo $TPL_VAR["query_string"]?>';"><span class="arrowleft"></span>환불리스트</button></span></li>
		</ul>		
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->


<!-- 주문정보 테이블 : 시작 -->
<div id="order_info"></div>

<!-- 주문 상세 내역 -->

<div class="item-title" style="margin-top:0px;">환불정보</div>
<!--
	# $summaryModeClass
	# 주문리스트에서 보는 요약모드면 'summary-mode'
	# 주문상세화면에서 볼때에는 ''
-->
<?php if($TPL_VAR["data_refund_item"]){?>
<table class="order-view-table" width="100%" border=0>
	<colgroup>
		<col width="300" />
		<col />
		<col />
		<col />
		<col />
		<col />
		<col />
		<col />
		<col />
	</colgroup>
	<thead class="oth">
		<tr>
			<th rowspan="2" class="dark" colspan="2">환불신청 상품</th>
			<th rowspan="2" class="dark">환불수량</th>
			<th rowspan="2" class="dark">결제수단</th>
			<th rowspan="2" class="dark">사유</th>
			<th rowspan="2" class="dark">환불접수 일시</th>
			<th rowspan="2" class="dark">환불완료 일시</th>
			<th rowspan="2" class="dark">처리자</th>
			<th colspan="2" class="dark">진행상태</th>
		</tr>
		<tr>
			<th class="dark">환불</th>
			<th class="dark">반품</th>
		</tr>
	</thead>

	<tbody class="otb">
<?php if($TPL_data_refund_item_1){$TPL_I1=-1;foreach($TPL_VAR["data_refund_item"] as $TPL_V1){$TPL_I1++;?>
		<tr class="order-item-row">
			<td class="info" colspan="2">
				<div class="left">
					<div style="float:left; width:40px;">
					<a href='/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank'><span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V1["image"]?>" /></span>
					</div>
					<div style="float:left;">
<?php if($TPL_V1["npay_product_order_id"]){?><div class="ngray bold"><?php echo $TPL_V1["npay_product_order_id"]?><span style="font-size:11px;font-weight:normal"> (Npay상품주문번호)</span></div><?php }?>
<?php if($TPL_V1["goods_type"]=='gift'){?>
					<img src="/admin/skin/default/images/common/icon_gift.gif" align="absmiddle" />
<?php }?>
					<span class="goods_name"><?php if($TPL_V1["cancel_type"]=='1'){?><span class="order-item-cancel-type " >[청약철회불가]</span> <?php }?><?php echo character_limiter($TPL_V1["goods_name"], 30)?></span></a>

					<div class="desc" style="padding-left:40px;">
<?php if($TPL_V1["option1"]!=null||$TPL_V1["option2"]!=null||$TPL_V1["option3"]!=null||$TPL_V1["option4"]!=null||$TPL_V1["option5"]!=null){?>
<?php if($TPL_V1["opt_type"]=='opt'){?>
						<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php }?>
<?php if($TPL_V1["opt_type"]=='sub'){?>
						<img src="/admin/skin/default/images/common/icon_add.gif" />
<?php }?>
<?php }?>
<?php if($TPL_V1["option1"]!=null){?>
							<span class="option"><?php echo $TPL_V1["title1"]?> : <?php echo $TPL_V1["option1"]?></span>
<?php }?>
<?php if($TPL_V1["option2"]!=null){?>
						<span class="option"><?php echo $TPL_V1["title2"]?> : <?php echo $TPL_V1["option2"]?></span>
<?php }?>
<?php if($TPL_V1["option3"]!=null){?>
						<span class="option"><?php echo $TPL_V1["title3"]?> : <?php echo $TPL_V1["option3"]?></span>
<?php }?>
<?php if($TPL_V1["option4"]!=null){?>
						<span class="option"><?php echo $TPL_V1["title4"]?> : <?php echo $TPL_V1["option4"]?></span>
<?php }?>
<?php if($TPL_V1["option5"]!=null){?>
						<span class="option"><?php echo $TPL_V1["title5"]?> : <?php echo $TPL_V1["option5"]?></span>
<?php }?>

<?php if($TPL_V1["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
					</div>
<?php if($TPL_V1["inputs"]){?>
					<div class="desc" style="padding-left:40px;">
<?php if(is_array($TPL_R2=$TPL_V1["inputs"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<?php if($TPL_K2> 0){?><br /><?php }?>
						<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V2["title"]){?><?php echo $TPL_V2["title"]?>:<?php }?>
						<?php echo $TPL_V2["value"]?>

<?php }}?>
					</div>
<?php }?>
<?php if($TPL_V1["goods_kind"]=='coupon'){?>
					<div class="desc" style="padding-left:40px;">
<?php if($TPL_V1["coupon_serial"]){?><span class="order-item-coupon-serial" >티켓번호:<?php echo $TPL_V1["coupon_serial"]?></span><br/><?php }?>
<?php if($TPL_V1["cancel_memo"]){?>
							<?php echo nl2br($TPL_V1["cancel_memo"])?>

<?php }else{?>
<?php if($TPL_V1["goods_kind"]=='coupon'&&$TPL_V1["social_start_date"]&&$TPL_V1["social_end_date"]){?><span class="order-item-coupon-date" >유효기간:<?php echo $TPL_V1["social_start_date"]?>~<?php echo $TPL_V1["social_end_date"]?></span><br/><?php }?>
							<div class="goods-coupon-use-return">사용제한 : <?php echo $TPL_V1["couponinfo"]["coupon_use_return"]?></div>
							<div class="goods-coupon-cancel-day">취소 마감시간 : <?php echo $TPL_V1["couponinfo"]["socialcp_cancel_refund_day"]?></div>
<?php }?>
					</div>
<?php }?>
<?php if($TPL_V1["goods_type"]=="gift"){?>
<?php if($TPL_V1["gift_title"]){?><div><span class="fx11"><?php echo $TPL_V1["gift_title"]?></span> <span class="btn small gray"><button type="button" class="gift_log" order_seq="<?php echo $TPL_VAR["data_refund"]["order_seq"]?>" item_seq="<?php echo $TPL_V1["item_seq"]?>">자세히</button></span></div><?php }?>
<?php }?>
					</div>
				</div>
			</td>
			<td class="info center"><?php echo $TPL_V1["ea"]?></td>
<?php if($TPL_I1== 0){?>
			<td class="info center" rowspan="<?php echo count($TPL_VAR["data_refund_item"])?>">
<?php if($TPL_VAR["data_order"]["npay_order_id"]){?><span class="icon-pay-npay" title="naver pay"><span>npay</span></span><?php }?>
<?php if($TPL_VAR["data_order"]["pg"]=='kakaopay'){?><span class="icon-pay-kakaopay" /><span>kakaopay</span></span><?php }else{?><?php echo $TPL_VAR["data_order"]["mpayment"]?><?php }?>
<?php if($TPL_VAR["orders"]["bank_name"]){?>(<?php echo $TPL_VAR["data_order"]["bank_name"]?>)<?php }?>
			</td>
			<td class="info center" rowspan="<?php echo count($TPL_VAR["data_refund_item"])?>"><?php echo $TPL_VAR["data_refund"]["mrefund_type"]?></td>
			<td class="info center" rowspan="<?php echo count($TPL_VAR["data_refund_item"])?>"><?php echo $TPL_VAR["data_refund"]["regist_date"]?></td>
			<td class="info center" rowspan="<?php echo count($TPL_VAR["data_refund_item"])?>">
<?php if($TPL_VAR["data_refund"]["status"]=='complete'){?>
				<?php echo $TPL_VAR["data_refund"]["refund_date"]?>

<?php }?>
			</td>
			<td class="info center" rowspan="<?php echo count($TPL_VAR["data_refund_item"])?>"><?php echo $TPL_VAR["data_refund"]["manager_name"]?></td>
			<td class="info center" rowspan="<?php echo count($TPL_VAR["data_refund_item"])?>"><?php echo $TPL_VAR["data_refund"]["mstatus"]?></td>
			<td class="info center" rowspan="<?php echo count($TPL_VAR["data_refund_item"])?>"><?php echo $TPL_VAR["data_refund"]["returns_status"]?></td>
<?php }?>
		</tr>
<?php }}?>

		<tr class="order-item-row">
			<th class="dark pd10" align="right" style="padding-right:5px;" colspan="2">소계</th>
			<th class="dark" align="center"><strong><?php echo $TPL_VAR["tot"]["ea"]?> (<?php echo $TPL_VAR["tot"]["goods_cnt"]?>종)</strong></th>
			<th class="dark" colspan="7"></th>
		</tr>
	</tbody>

</table>
<?php }else{?>
<table class="order-view-table" width="100%" border=0>
	<colgroup>
		<col width="300" />
		<col />
		<col />
		<col />
		<col />
		<col />
		<col />
		<col />
		<col />
	</colgroup>
	<thead class="oth">
		<tr>
			<th rowspan="2" class="dark" colspan="2">환불신청 상품</th>
			<th rowspan="2" class="dark">환불수량</th>
			<th rowspan="2" class="dark">사유</th>
			<th rowspan="2" class="dark">환불접수 일시</th>
			<th rowspan="2" class="dark">환불완료 일시</th>
			<th rowspan="2" class="dark">처리자</th>
			<th colspan="2" class="dark">진행상태</th>
		</tr>
		<tr>
			<th class="dark">환불</th>
			<th class="dark">반품</th>
		</tr>
	</thead>

	<tbody class="otb">

		<tr class="order-item-row">
			<td class="info" colspan="2">
			</td>
			<td class="info center"></td>

			<td class="info center">기타</td>
			<td class="info center"><?php echo $TPL_VAR["data_refund"]["regist_date"]?></td>
			<td class="info center">

				<?php echo $TPL_VAR["data_refund"]["refund_date"]?>


			</td>
			<td class="info center"><?php echo $TPL_VAR["data_refund"]["manager_name"]?></td>
			<td class="info center"><?php echo $TPL_VAR["data_refund"]["mstatus"]?></td>
			<td class="info center"><?php echo $TPL_VAR["data_refund"]["returns_status"]?></td>

		</tr>


	</tbody>

</table>
<?php }?>
<div style="height:5px;"></div>

<form name="refundForm" method="post" action="../refund_process/save" onsubmit="return refundSubmit()" target="actionFrame">
	<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["data_order"]["order_seq"]?>" />
	<input type="hidden" name="top_orign_order_seq" value="<?php echo $TPL_VAR["data_order"]["top_orign_order_seq"]?>" />
	<input type="hidden" name="refund_code" value="<?php echo $_GET["no"]?>" />
	<input type="hidden" name="tot_price" value="<?php echo $TPL_VAR["tot"]["price"]?>" />
	<input type="hidden" name="tot_refund_goods_shipping_cost" value="<?php echo $TPL_VAR["tot"]["refund_goods_shipping_cost"]?>" />
	<input type="hidden" name="tot_member_sale" value="<?php echo $TPL_VAR["tot"]["member_sale"]?>" />
	<input type="hidden" name="tot_coupon_sale" value="<?php echo $TPL_VAR["tot"]["coupon_sale"]?>" />
	<input type="hidden" name="tot_fblike_sale" value="<?php echo $TPL_VAR["tot"]["fblike_sale"]?>" />
	<input type="hidden" name="tot_mobile_sale" value="<?php echo $TPL_VAR["tot"]["mobile_sale"]?>" />
	<input type="hidden" name="tot_referer_sale" value="<?php echo $TPL_VAR["tot"]["referer_sale"]?>" />
	<input type="hidden" name="tot_promotion_code_sale" value="<?php echo $TPL_VAR["tot"]["promotion_code_sale"]?>" />
	<input type="hidden" name="order_shipping_cost" value="<?php echo $TPL_VAR["data_order"]["real_shipping_cost"]?>" />
	<input type="hidden" name="refund_shipping_cost" value="<?php echo $TPL_VAR["tot"]["refund_shipping_cost"]?>" />
	<input type="hidden" name="order_coupon_sale" value="<?php echo $TPL_VAR["data_order"]["coupon_sale"]?>" />
	<input type="hidden" name="order_emoney" value="<?php echo $TPL_VAR["data_order"]["emoney"]?>" />
	<input type="hidden" name="order_enuri" value="<?php echo $TPL_VAR["data_order"]["enuri"]?>" />
	<input type="hidden" name="cancel_type" value="<?php echo $TPL_VAR["data_refund"]["cancel_type"]?>" />
	<input type="hidden" name="refund_type" value="<?php echo $TPL_VAR["data_refund"]["refund_type"]?>" />
	<input type="hidden" name="return_reserve" value="<?php if($TPL_VAR["data_refund"]["refund_type"]=='return'){?><?php echo $TPL_VAR["tot"]["return_reserve"]?><?php }?>" />
	<input type="hidden" name="return_point" value="<?php if($TPL_VAR["data_refund"]["refund_type"]=='return'){?><?php echo $TPL_VAR["tot"]["return_point"]?><?php }?>" />
	<input type="hidden" name="refund_version" value="1" />

<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_return"]["npay_order_id"]){?>
	<input type="hidden" name="npay_use" value="<?php echo $TPL_VAR["npay_use"]?>" />
<?php }?>

<?php if($TPL_VAR["data_order"]["pg"]=='allat'){?>
	<input type='hidden' name='actionUrl'		value='/admin/refund_process/save' />
	<input type='hidden' name='allat_shop_id'	value='<?php echo $TPL_VAR["pg"]["mallCode"]?>' />
	<input type='hidden' name='allat_order_no'	value='<?php echo $TPL_VAR["data_order"]["order_seq"]?>' />
	<input type='hidden' name='allat_seq_no'	value='<?php echo $TPL_VAR["data_order"]["pg_transaction_number"]?>' />

	<input type='hidden' name='allat_amt'		value='' />
	<input type='hidden' name='allat_pay_type'	value='' />

	<input type='hidden' name='allat_enc_data'	value='' />
	<input type='hidden' name='allat_opt_pin'	value='NOVIEW' />
	<input type='hidden' name='allat_opt_mod'	value='WEB' />
	<input type='hidden' name='allat_test_yn'	value='N' />
<?php }?>

<?php if($TPL_VAR["data_order"]["pg"]=='kspay'){?>
	<input type=hidden name="storeid"		value="<?php echo $TPL_VAR["pg"]["mallId"]?>">
	<input type=hidden name="storepasswd"	value="<?php echo $TPL_VAR["pg"]["mallPass"]?>">
	<input type=hidden name="authty"		value="<?php echo $TPL_VAR["data_order"]["kspay_authty"]?>">
	<input type=hidden name="trno" size=15 maxlength=12 value="<?php echo $TPL_VAR["data_order"]["pg_transaction_number"]?>">
<?php }?>

<table class="info-table-style" width="100%" >
	<col width="25%" />
	<col width="25%" />
	<col width="25%" />
	<col width="25%" />
	<tr>
<?php if($TPL_VAR["data_refund"]["refund_method"]=='cash'){?>
		<th class="its-th-align">환불방법</th>
		<td class="its-td-align center">예치금 환불</td>
<?php }else{?>
		<th class="its-th-align">계좌정보</th>
		<td class="its-td-align center"><?php echo $TPL_VAR["data_refund"]["bank_name"]?> <?php echo $TPL_VAR["data_refund"]["bank_account"]?> <?php echo $TPL_VAR["data_refund"]["bank_depositor"]?></td>
<?php }?>
		<th class="its-th-align">상세사유</th>
		<td class="its-td-align center">
			<div class="pd5"><textarea name="refund_reason" style="width:96%;" rows="2"><?php echo htmlspecialchars($TPL_VAR["data_refund"]["refund_reason"])?></textarea></div>
		</td>
	</tr>
	<tr>
		<th class="its-th-align">처리내역로그</th>
		<td class="its-td" colspan="3">
			<textarea  class="wp95 line" rows="3" readOnly="readOnly"><?php if($TPL_process_log_1){foreach($TPL_VAR["process_log"] as $TPL_V1){?>[<?php echo $TPL_V1["regist_date"]?>] [<?php echo $TPL_V1["actor"]?>] <?php if($TPL_V1["add_info"]=="npay"){?>[네이버페이]<?php }?> <?php echo $TPL_V1["title"]?><?php echo chr( 10)?><?php }}?></textarea>
		</td>
	</tr>
</table>

<div class="item-title">환불처리</div>

	<div class="pd10">
		1. 환불금액
		<div style="float:right;">
			<span class="fx11 darkgray">재발행된 쿠폰(또는 코드)의 사용기간 = 재발행일 + 최초 쿠폰(또는 코드) 사용 시 남은 기간</span>
			<span class="btn small black"><button type="button" class="btncouponinfo">자세히</button></span>
	</div>

	<div id="couponinfo" class="hide">
		<div class="pd5 pdl20" style="padding-top:0px;"><span class="blue bold">A쿠폰</span></div>
		<div class="pd5 pdl20">
		- 유효기간 : 2015년 4월 30일<br />
		- 사용시점 : 2015년 4월 20일<br />
		- 남은기간 : 10일
		</div>
		<div class="pd5 pdl20 mt10"><span class="blue bold">A쿠폰 재발행</span></div>
		<div class="pd5 pdl20">
		- 재발행시점 : 2015년 4월 25일<br />
		- 유효기간 : 2015년 5월 5일 = 2015년 4월 25일 + 10일<br />
		- 남은기간 : 10일
		</div>
	</div>
</div>

<?php if($TPL_VAR["refund_shipping_items"]){?>

<table class="order-view-table" width="100%" border="0">
<colgroup>
	<col width="80" />	<!--// 구분 //-->
	<col />				<!--// 상품 //-->
	<col width="35" />	<!--// 수량 //-->
	<col width="100" />	<!--// 할인가격 //-->
	<col width="100" />	<!--// 기존 환불금액 //-->
	<col width="90" />	<!--// 방법 //-->
	<col width="50" />	<!--// 수량 //-->
	<col width="110" />	<!--// 금액 //-->
	<col width="110" />	<!--// 예치금 //-->
	<col width="110" />	<!--// 마일리지 //-->
	<col width="100" />	<!--// 유효기간 //-->
	<col width="80" />	<!--// 쿠폰/코드재발행 //-->
</colgroup>
<thead class="oth">
	<tr>
		<th class="dark" rowspan="2">구분</th>
		<th class="dark" colspan="3">주문</th>
		<th class="dark" rowspan="2">동일 상품의<br />기존 환불금액<br /><span class="fx11">(누적 완료기준)</span></th>
		<th class="dark" colspan="3">실 환불금액</th>
		<th class="dark" rowspan="2">예치금</th>
		<th class="dark" colspan="3">환불 복원</th>
	</tr>
	<tr>
		<!--// 주문 -->
		<th class="dark">상품</th>
		<th class="dark">수량</th>
		<th class="dark">할인가격</th>
		<!--// 실 환불금액 -->
		<th class="dark">방법</th>
		<th class="dark">수량</th>
		<th class="dark">금액</th>
		<!--// 환불 복원 -->
		<th class="dark">마일리지</th>
		<th class="dark">유효기간</th>
		<th class="dark">쿠폰/코드재발행</th>
	</tr>
</thead>

<tbody class="otb">
<?php if($TPL_refund_shipping_items_1){$TPL_I1=-1;foreach($TPL_VAR["refund_shipping_items"] as $TPL_V1){$TPL_I1++;?>
<?php if(is_array($TPL_R2=$TPL_V1["items"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>

	<!--//## 상품 영역 -->
	<tr class="order-item-row" refund_item_seq="<?php echo $TPL_V2["refund_item_seq"]?>">
		<!-- 상품구분 -->
<?php if($TPL_I2== 0&&$TPL_I2== 0){?>
		<td class="info center" rowspan="<?php echo $TPL_V1["shipping_cnt"]?>"><?php if($TPL_V2["goods_kind"]=="coupon"){?>티켓<?php }else{?><?php if($TPL_V2["goods_type"]=="gift"){?>사은품<?php }else{?>상품<?php }?><?php }?></td>
<?php }?>

		<input type="hidden" name="refund_provider_seq[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo $TPL_V2["provider_seq"]?>">
		<input type="hidden" name="refund_ea[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo $TPL_V2["ea"]?>">
		<input type="hidden" name="refund_item_for_ship[<?php echo $TPL_V1["shipping"]["shipping_seq"]?>]" value="<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>">
		<input type="hidden" name="order_shipping_cost[<?php echo $TPL_V1["shipping"]["shipping_seq"]?>]" value="<?php echo $TPL_V1["shipping"]["shipping_cost"]?>" class="order_shipping_cost">
<?php if($TPL_V2["ea"]> 0){?>
		<input type="hidden" name="refund_item_seq[]" value="<?php echo $TPL_V2["refund_item_seq"]?>">
		<input type="hidden" name="refund_npay_product_order_id[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo $TPL_V2["npay_product_order_id"]?>">
<?php }?>

<?php if($TPL_V2["first_rows"]){?>
		<!-- 상품&옵션명 -->
		<td class="info" style="min-height:56px;" <?php if($TPL_VAR["refund_rows"][$TPL_V2["option_seq"]]> 1){?>rowspan="<?php echo $TPL_VAR["refund_rows"][$TPL_V2["option_seq"]]?>"<?php }?>>
			<table border="0" cellpadding="0" cellspacing="0" class="goods_info">
			<tr>
				<td>
					<a href='/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>' target='_blank'><span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V2["image"]?>" /></span>
				</td>
				<td class="left">
<?php if($TPL_V2["npay_product_order_id"]){?><div class="ngray bold"><?php echo $TPL_V2["npay_product_order_id"]?><span style="font-size:11px;font-weight:normal"> (Npay상품주문번호)</span></div><?php }?>
<?php if($TPL_V2["goods_type"]=='gift'){?>
					<img src="/admin/skin/default/images/common/icon_gift.gif" align="absmiddle" />
<?php }?>
					<span class="goods_name"><?php echo character_limiter($TPL_V2["goods_name"], 45)?></span></a>

<?php if($TPL_V2["adult_goods"]=='Y'||$TPL_V2["option_international_shipping_status"]=='y'||$TPL_V2["cancel_type"]=='1'||$TPL_V2["tax"]=='exempt'){?>
					<div>
<?php if($TPL_V2["adult_goods"]=='Y'){?>
						<img src="/admin/skin/default/images/common/auth_img.png" alt="성인" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V2["option_international_shipping_status"]=='y'){?>
						<img src="/admin/skin/default/images/common/icon/plane_on.png" alt="해외배송상품" style="vertical-align: middle;" height="19" />
<?php }?>
<?php if($TPL_V2["cancel_type"]=='1'){?>
						<img src="/admin/skin/default/images/common/icon/nocancellation.gif" alt="청약철회" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V2["tax"]=='exempt'){?>
						<img src="/admin/skin/default/images/common/icon/taxfree.gif" alt="비과세" style="vertical-align: middle;"/>
<?php }?>
					</div>
<?php }?>

					<div class="desc">
<?php if($TPL_V2["option1"]!=null||$TPL_V2["option2"]!=null||$TPL_V2["option3"]!=null||$TPL_V2["option4"]!=null||$TPL_V2["option5"]!=null){?>
<?php if($TPL_V2["opt_type"]=='opt'){?>
						<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php }?>
<?php if($TPL_V2["opt_type"]=='sub'){?>
						<img src="/admin/skin/default/images/common/icon_add.gif" />
<?php }?>
<?php }?>
<?php if($TPL_V2["option1"]!=null){?>
							<span class="option"><?php echo $TPL_V2["title1"]?> : <?php echo $TPL_V2["option1"]?></span>
<?php }?>
<?php if($TPL_V2["option2"]!=null){?>
						<span class="option"><?php echo $TPL_V2["title2"]?> : <?php echo $TPL_V2["option2"]?></span>
<?php }?>
<?php if($TPL_V2["option3"]!=null){?>
						<span class="option"><?php echo $TPL_V2["title3"]?> : <?php echo $TPL_V2["option3"]?></span>
<?php }?>
<?php if($TPL_V2["option4"]!=null){?>
						<span class="option"><?php echo $TPL_V2["title4"]?> : <?php echo $TPL_V2["option4"]?></span>
<?php }?>
<?php if($TPL_V2["option5"]!=null){?>
						<span class="option"><?php echo $TPL_V2["title5"]?> : <?php echo $TPL_V2["option5"]?></span>
<?php }?>

<?php if($TPL_V2["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V2["goods_code"]?>]</div><?php }?>
					</div>
<?php if($TPL_V2["inputs"]){?>
					<div class="desc">
<?php if(is_array($TPL_R3=$TPL_V2["inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
<?php if($TPL_K3> 0){?><br /><?php }?>
						<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V3["title"]){?><?php echo $TPL_V3["title"]?>:<?php }?>
						<?php echo $TPL_V3["value"]?>

<?php }}?>
					</div>
<?php }?>
<?php if($TPL_V2["goods_kind"]=='coupon'){?>
					<div  class="desc">
<?php if($TPL_V2["coupon_serial"]){?><span class="order-item-coupon-serial" >티켓번호:<?php echo $TPL_V2["coupon_serial"]?></span><br/><?php }?>
<?php if($TPL_V2["cancel_memo"]){?>
							<?php echo nl2br($TPL_V2["cancel_memo"])?>

<?php }else{?>
<?php if($TPL_V2["goods_kind"]=='coupon'&&$TPL_V2["social_start_date"]&&$TPL_V2["social_end_date"]){?><span class="order-item-coupon-date" >유효기간:<?php echo $TPL_V2["social_start_date"]?>~<?php echo $TPL_V2["social_end_date"]?></span><br/><?php }?>
						<div class="goods-coupon-use-return">사용제한 : <?php echo $TPL_V2["couponinfo"]["coupon_use_return"]?></div>
						<div class="goods-coupon-cancel-day">취소 마감시간 : <?php echo $TPL_V2["couponinfo"]["socialcp_cancel_refund_day"]?></div>
<?php }?>
					</div>
<?php }?>
<?php if($TPL_V2["goods_type"]=="gift"){?>
<?php if($TPL_V2["gift_title"]){?><div><span class="fx11"><?php echo $TPL_V2["gift_title"]?></span> <span class="btn small gray"><button type="button" class="gift_log" order_seq="<?php echo $TPL_VAR["data_refund"]["order_seq"]?>" item_seq="<?php echo $TPL_V1["item_seq"]?>">자세히</button></span></div><?php }?>
<?php }?>
					</div>
				<td>
			</tr>
			</table>
		</td>

		<!-- 상품판매수량 -->
		<td class="info right" <?php if($TPL_VAR["refund_rows"][$TPL_V2["option_seq"]]> 1){?>rowspan="<?php echo $TPL_VAR["refund_rows"][$TPL_V2["option_seq"]]?>"<?php }?>><div class="pd3"><?php echo $TPL_V2["option_ea"]?></div></td>

		<!-- 상품판매가격 -->
		<td class="info right" <?php if($TPL_VAR["refund_rows"][$TPL_V2["option_seq"]]> 1){?>rowspan="<?php echo $TPL_VAR["refund_rows"][$TPL_V2["option_seq"]]?>"<?php }?>>
			<div class="pd3">
<?php if($TPL_V2["goods_type"]=="gift"){?>
				<div class="gray">0</div>
<?php }else{?>
				<div class="gray"><?php echo get_currency_price($TPL_V2["price"]*$TPL_V2["option_ea"])?></div>
				<div class="gray"><?php if($TPL_V2["total_sale"]> 0){?>-<?php }?><?php echo get_currency_price($TPL_V2["total_sale"])?></div>
				<div><span class="fx14 blue bold lsp-1"><?php echo get_currency_price(($TPL_V2["price"]*$TPL_V2["option_ea"])-$TPL_V2["total_sale"])?></span></div>
				<div class="gray" title="상품 개당 할인가격" >(<?php echo get_currency_price((($TPL_V2["price"]*$TPL_V2["option_ea"])-$TPL_V2["total_sale"])/$TPL_V2["option_ea"])?>)</div>
<?php }?>
			</div>
		</td>

		<!-- 동일 상품의 기존 환불금액 -->
		<td class="info right" <?php if($TPL_VAR["refund_rows"][$TPL_V2["option_seq"]]> 1){?>rowspan="<?php echo $TPL_VAR["refund_rows"][$TPL_V2["option_seq"]]?>"<?php }?>>
			<div class="pd3">
				<span class="red"><?php if($TPL_V2["refund_complete_ea"]){?><?php echo $TPL_V2["refund_complete_ea"]?>개 : <?php echo get_currency_price($TPL_V2["refund_price"])?><?php }else{?>0<?php }?></span><br />
				<span class="fx11 gray">잔여:<?php echo get_currency_price(($TPL_V2["price"]*$TPL_V2["option_ea"])-$TPL_V2["total_sale"]-$TPL_V2["refund_price"])?></span>
			</div>
		</td>
<?php }?>

<?php if($TPL_I1== 0&&$TPL_I2== 0){?>
		<!-- 환불방법 -->
		<td class="info center refund_line_left" rowspan="<?php echo $TPL_VAR["order_goods_cnt"]?>">
<?php if(!$TPL_V1["refund_payment"]["onlyemoney"]){?>
			<select name="refund_method" class="refund_adjust input_line" itype="method" style="text-align:left;padding:2px;" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?>>
<?php if(is_array($TPL_R3=$TPL_V1["refund_payment"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
			<option value="<?php echo $TPL_V3["paycode"]?>" <?php if($TPL_V3["paycode"]==$TPL_VAR["refund_method"]){?>selected<?php }?>><?php echo $TPL_V3["name"]?></option>
<?php }}?>
			</select>
<?php }else{?> - <?php }?>
		</td>
<?php }?>

		<!-- 환불수량 -->
		<td class="info right">
			<div class="pd3"><?php if($TPL_V2["ea"]> 0){?><strong class="fx14"><?php echo number_format($TPL_V2["ea"])?></strong><?php }else{?><span class="gray">0</span><?php }?></div>
		</td>

		<!-- 환불금액 -->
		<td class="info center">
<?php if($TPL_V2["goods_type"]!='gift'&&!$TPL_V1["refund_payment"]["onlycash"]&&!$TPL_V1["refund_payment"]["onlyemoney"]){?>
<?php if($TPL_V2["ea"]> 0){?>
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["pg"]=="npay"){?>
				<input type="hidden" name="refund_goods_price_tmp[]" value="<?php echo get_currency_price($TPL_V2["sale_price"]*$TPL_V2["ea"])?>" class="input_line" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?>>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
				<div name="refund_goods_price_txt[<?php echo $TPL_V2["refund_item_seq"]?>]" class="refund_goods_price_txt right"><?php echo get_currency_price($TPL_V2["refund_goods_price"])?></div>
				<input type="hidden" name="refund_goods_price[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo get_currency_price($TPL_V2["refund_goods_price"])?>" class="refund_adjust input_line refund_goods_price_area" itype="goods_price">
				<input type="hidden" name="origin_refund_goods_price[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo get_currency_price($TPL_V2["refund_goods_price"])?>" class="" itype="goods_price">
<?php }else{?>
				<input type="<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["pg"]=='npay'){?>hidden<?php }else{?>text<?php }?>" name="refund_goods_price[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo get_currency_price($TPL_V2["refund_goods_price"])?>" class="refund_adjust input_line refund_goods_price_area" itype="goods_price">
				<input type="hidden" name="origin_refund_goods_price[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo get_currency_price($TPL_V2["refund_goods_price"])?>" class="" itype="goods_price">
<?php }?>
<?php if($TPL_VAR["data_order"]["pg_currency"]&&$TPL_VAR["data_order"]["pg_currency"]!=$TPL_VAR["basic_currency"]){?>
				<div class="mt5 refund_pg_price desc hide">결제(<?php echo $TPL_VAR["data_order"]["pg_currency"]?>): <span></span></div>
<?php }?>
<?php }else{?>
				<!--<input type="text" name="" value="0" class="input_line disabled" size="12" disabled>-->
				<div class="right"><span class="gray">0</span></div>
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["data_refund"]["status"]=="complete"&&$TPL_V2["ea"]> 0){?>
				<div class="right"><span class="fx14"><?php echo get_currency_price(($TPL_V2["price"]*$TPL_V2["option_ea"])-$TPL_V2["total_sale"])?></span></div>
<?php }else{?>
			<div class="right">-</div>
<?php }?>
<?php }?>
		</td>

		<!-- 예치금 -->
		<td class="info center">
<?php if(!$TPL_V1["refund_payment"]["onlyemoney"]){?>
<?php if($TPL_V2["ea"]> 0){?>
<?php if($TPL_VAR["cash_use"]!='N'&&($TPL_V2["cash_sale_unit"]> 0||$TPL_V2["refund_cash_sale_unit"]> 0)){?>
<?php if(serviceLimit('H_AD')){?>
				<div name="refund_cash_txt[<?php echo $TPL_V2["refund_item_seq"]?>]" class="refund_goods_cash_txt right"><?php echo get_currency_price($TPL_V2["refund_item_cash"])?></div>
				<input type="hidden" maxlength="10" name="refund_cash_tmp[<?php echo $TPL_V2["refund_item_seq"]?>]" class="refund_goods_cash_area refund_cash_input refund_adjust input_line onlyfloat refund_adjust_input" itype="cash" value="<?php echo get_currency_price($TPL_V2["refund_item_cash"])?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?> />
				<input type="hidden" name="refund_goods_cash_area_origin[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo get_currency_price($TPL_V2["refund_item_cash"])?>"/>
<?php }else{?>
				<input type="text" maxlength="10" name="refund_cash_tmp[<?php echo $TPL_V2["refund_item_seq"]?>]" class="refund_goods_cash_area refund_cash_input refund_adjust input_line onlyfloat refund_adjust_input" itype="cash" value="<?php echo get_currency_price($TPL_V2["refund_item_cash"])?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?> />
				<input type="hidden" name="refund_goods_cash_area_origin[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo get_currency_price($TPL_V2["refund_item_cash"])?>"/>
<?php }?>
<?php }else{?>
			<div class="right">-</div>
<?php if(serviceLimit('H_AD')){?>
			<div name="refund_cash_txt[<?php echo $TPL_V2["refund_item_seq"]?>]" class="refund_goods_cash_txt right hide"><?php echo get_currency_price($TPL_V2["refund_item_cash"])?></div>
			<input type="hidden" maxlength="10" name="refund_cash_tmp[<?php echo $TPL_V2["refund_item_seq"]?>]" class="refund_goods_cash_area refund_cash_input refund_adjust input_line onlyfloat refund_adjust_input hide" itype="cash" value="<?php echo get_currency_price($TPL_V2["refund_item_cash"])?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?> />
			<input type="hidden" name="refund_goods_cash_area_origin[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo get_currency_price($TPL_V2["refund_item_cash"])?>"/>
<?php }else{?>
			<input type="text" maxlength="10" name="refund_cash_tmp[<?php echo $TPL_V2["refund_item_seq"]?>]" class="refund_goods_cash_area refund_cash_input refund_adjust input_line onlyfloat refund_adjust_input hide" itype="cash" value="<?php echo get_currency_price($TPL_V2["refund_item_cash"])?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?> />
			<input type="hidden" name="refund_goods_cash_area_origin[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo get_currency_price($TPL_V2["refund_item_cash"])?>"/>
<?php }?>
<?php }?>
<?php }else{?>
			<div class="right gray"><?php echo get_currency_price($TPL_V2["refund_item_cash"])?></div>
<?php }?>
<?php }else{?>
			<div class="right">-</div>
<?php }?>
		</td>

		<!-- 마일리지 -->
		<td class="info center">
<?php if($TPL_V2["ea"]> 0){?>
<?php if($TPL_VAR["data_order"]["pg"]!='npay'&&($TPL_V2["emoney_sale_unit"]> 0||$TPL_V2["refund_emoney_sale_unit"]> 0)){?>
<?php if(serviceLimit('H_AD')){?>
			<div name="refund_emoney_txt[<?php echo $TPL_V2["refund_item_seq"]?>]" class="refund_emoney_txt right"><?php echo get_currency_price($TPL_V2["refund_item_emoney"])?></div>
			<input type="hidden" maxlength="10" name="refund_emoney_tmp[<?php echo $TPL_V2["refund_item_seq"]?>]" class="refund_emoney_input refund_adjust input_line onlyfloat refund_adjust_input" itype="emoney" value="<?php echo get_currency_price($TPL_V2["refund_item_emoney"])?>" />
<?php }else{?>
			<input type="text" maxlength="10" name="refund_emoney_tmp[<?php echo $TPL_V2["refund_item_seq"]?>]" class="refund_emoney_input refund_adjust input_line onlyfloat refund_adjust_input" itype="emoney" value="<?php echo get_currency_price($TPL_V2["refund_item_emoney"])?>" />			<?php }?>
<?php }else{?>
			<div class="right">-</div>
<?php }?>
<?php }else{?>
			<div class="right gray"><?php echo get_currency_price($TPL_V2["refund_item_emoney"])?></div>
<?php }?>
		</td>

<?php if($TPL_I1== 0&&$TPL_I2== 0){?>
		<!-- 유효기간 -->
		<td class="info center" rowspan="<?php echo $TPL_VAR["order_goods_cnt"]?>">
<?php if($TPL_VAR["data_order"]["pg"]!='npay'&&(($TPL_V2["emoney_sale_unit"]*$TPL_V2["ea"])+($TPL_V2["emoney_sale_rest"]))> 0){?>
			<div>
				<select name="refund_emoney_limit_type" class="input_line" style="width:75px !important;padding:2px 2px 2px 0px;letter-spacing:-1px;">
					<option value="n" <?php if($TPL_VAR["data_refund"]["refund_emoney_limit_date"]==""){?>selected<?php }?>>제한없음</option>
					<option value="y" <?php if($TPL_VAR["data_refund"]["refund_emoney_limit_date"]!=""){?>selected<?php }?>>직접입력</option>
				</select>
			</div>
			<div id="refund_emoney_date_div" class="input_line" style="margin:2px auto;padding:0px;width:102px !important;text-align:center;">
				<input type="text" name="refund_emoney_limit_date" id="refund_emoney_limit_date" value="<?php echo $TPL_VAR["data_refund"]["refund_emoney_limit_date"]?>" class="datepicker" maxlength="10" size="11" style="border:0px;text-align:center;padding:3px;color:#DF171E;" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?> />
			</div>
<?php }else{?>
			<div class="right">-</div>
			<input type="hidden" name="refund_emoney_limit_date" id="refund_emoney_limit_date" value="<?php echo date('Y-m-d H:i:s')?>" />
<?php }?>
		</td>
<?php }?>

		<!-- 쿠폰/코드재발행 -->
		<td class="info center refund_line_right">
<?php if($TPL_I2== 0&&$TPL_VAR["data_order"]["ordersheet_seq"]&&$TPL_VAR["data_order"]["use_ordersheetcoupon"]){?>
			<!-- 주문서 쿠폰 재발행 -->
			<div>
<?php if($TPL_VAR["data_order"]["restore_used_ordersheetcoupon_refund"]){?>
				<span class="fx11 lsp-1" style="line-height:16px;" 
				title="[<?php echo $TPL_VAR["data_order"]["use_ordersheetcoupon"]["coupon_name"]?>] 쿠폰재발행 완료"
				>주문서쿠폰<br/>재발행</span>
<?php }else{?>
				<label class="fx11 lsp-1" style="line-height:16px;">
				<input type="checkbox" 
					name="refund_ordersheet" class="refund_ordersheet"
					value="<?php echo $TPL_VAR["data_order"]["use_ordersheetcoupon"]["download_seq"]?>" 
<?php if($TPL_VAR["data_refund"]["refund_ordersheet"]){?>checked<?php }?> 
					class="coupon_seq <?php echo $TPL_VAR["data_order"]["use_ordersheetcoupon"]["download_seq"]?>">
					<span title="<?php echo $TPL_VAR["data_order"]["use_ordersheetcoupon"]["coupon_name"]?>" 
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?>
					>주문서쿠폰<br/>재발행</span>
				</label>
<?php }?>
			</div>
			<br/>
<?php }?>

<?php if($TPL_V2["goods_type"]!='gift'){?>
<?php if(!$TPL_V2["download_seq"]&&(!$TPL_V2["promotion_code_seq"]||strstr($TPL_V2["use_promotion"]["type"],'shipping'))){?>
			<div class="right">-</div>
<?php }?>
<?php if($TPL_V2["download_seq"]&&$TPL_V2["use_coupon"]){?>
				<div>
<?php if($TPL_V2["restore_used_coupon_refund"]){?>
				<span class="fx11 lsp-1" style="line-height:16px;" title="[<?php echo $TPL_V2["use_coupon"]["coupon_name"]?>] 쿠폰재발행 완료">쿠폰 재발행</span>
<?php }else{?>
				<label class="fx11 lsp-1" style="line-height:16px;"><input type="checkbox" name="refund_goods_coupon[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo $TPL_V2["download_seq"]?>" <?php if($TPL_V2["refund_goods_coupon"]){?>checked<?php }?> class="coupon_seq <?php echo $TPL_V2["download_seq"]?>"><span title="<?php echo $TPL_V2["use_coupon"]["coupon_name"]?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?>> 쿠폰 재발행</span></label>
<?php }?>
				</div>
<?php }?>

<?php if($TPL_V2["promotion_code_seq"]&&$TPL_V2["use_promotion"]&&$TPL_V2["use_promotion"]["type"]!="promotion"&&!strstr($TPL_V2["use_promotion"]["type"],'shipping')){?>
				<div>
<?php if($TPL_V2["restore_used_promotioncode_refund"]){?>
				<span class="fx11 lsp-1" style="line-height:16px;" title="[<?php echo $TPL_V2["use_promotion"]["promotion_name"]?>] 코드재발행 완료">코드 재발행</span>
<?php }else{?>
				<label class="fx11 lsp-1" style="line-height:16px;"><input type="checkbox" name="refund_goods_promotion[<?php echo $TPL_V2["refund_item_seq"]?>]" value="<?php echo $TPL_V2["promotion_code_seq"]?>" <?php if($TPL_V2["refund_goods_promotion"]){?>checked<?php }?> class="promotion_seq <?php echo $TPL_V2["promotion_code_seq"]?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?>><span title="<?php echo $TPL_V2["use_promotion"]["promotion_name"]?>"> 코드 재발행</span></label>
<?php }?>
				</div>
<?php }?>
<?php }else{?>
			<div class="right">-</div>
<?php }?>
		</td>
	</tr>

<?php if($TPL_I2==($TPL_V1["shipping_cnt"]- 1)&&$TPL_V1["refund_flag"]=='Y'){?>
	<!--//## 배송비 영역 -->
	<tr class="order-item-row" refund_item_seq="<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>">
		<!-- 상품구분 -->
		<td class="info center">배송비</td>

		<!-- 상품&옵션명 -->
		<td class="info left">-</td>

		<!-- 상품판매수량 -->
		<td class="info right">-</td>

		<!-- 배송비 표기 -->
		<td class="info right">
<?php if(serviceLimit('H_AD')){?>
			<div class="blue">
<?php if($TPL_V1["shipping"]["provider_seq"]== 1){?>
				본사
<?php }else{?>
				<?php echo $TPL_V1["shipping"]["provider_name"]?>

<?php }?>
			</div>
<?php }?>

<?php if(preg_match('/gift/',$TPL_V1["shipping"]["shipping_group"])){?>
			사은품배송
<?php }else{?>
			<div>
				<span><?php if($TPL_V1["shipping"]["shipping_method_name"]=='쿠폰'){?>티켓<?php }else{?><?php echo $TPL_V1["shipping"]["shipping_set_name"]?><?php }?></span>
<?php if($TPL_VAR["orders"]["international_country"]){?><span class="pdl5 lsp-1"><?php echo $TPL_VAR["orders"]["international_country"]?></span><?php }?>
			</div>
<?php if($TPL_V1["shipping"]["shipping_set_code"]=='direct_store'){?>
			<div class="lsp-1">수령매장 : <?php echo $TPL_V1["shipping"]["shipping_store_name"]?></div>
<?php }else{?>
			<div class="detailDescriptionLayerBtn hand" title="배송비 상세">
				<span class="bold">
<?php if($TPL_V1["shipping"]["shipping_cost"]> 0){?>
					<?php echo get_currency_price($TPL_V1["shipping"]["shipping_cost"], 3)?>

<?php }elseif($TPL_V1["shipping"]["postpaid"]> 0){?>
					<?php echo get_currency_price($TPL_V1["shipping"]["postpaid"], 3)?>

<?php }else{?>
					무료
<?php }?>
				</span>
<?php if($TPL_V1["shipping"]["shipping_pay_type"]&&($TPL_V1["shipping"]["shipping_cost"]> 0||$TPL_V1["shipping"]["postpaid"]> 0)){?>
					<span class="lsp-1">(<?php echo $TPL_V1["shipping"]["shipping_pay_type"]?>)</span>
<?php }?>
			</div>
			<!-- 배송비 상세 설명 -->
			<div class="detailDescriptionLayer hide" style="width:180px;margin-left:-100px;">
<?php if($TPL_V1["shipping"]["shipping_cost"]> 0||$TPL_V1["shipping"]["postpaid"]> 0){?>
					기본배송비: <?php echo get_currency_price($TPL_V1["shipping"]["delivery_cost"], 3)?><br/>
					추가배송비: <?php echo get_currency_price($TPL_V1["shipping"]["add_delivery_cost"], 3)?><br/>
					희망배송비: <?php echo get_currency_price($TPL_V1["shipping"]["hop_delivery_cost"], 3)?><br/>
<?php }else{?>
					무료배송
<?php }?>
			</div>
<?php }?>

<?php if($TPL_V1["shipping"]["shipping_hop_date"]){?>
			<div class="lsp-1">희망배송일 : <?php echo $TPL_V1["shipping"]["shipping_hop_date"]?></div>
<?php }elseif($TPL_V1["shipping"]["reserve_sdate"]){?>
			<div class="lsp-1">예약배송일 : <?php echo $TPL_V1["shipping"]["reserve_sdate"]?></div>
<?php }?>

<?php if($TPL_V1["shipping"]["shipping_coupon_sale"]> 0){?>
			<div class="desc">-<?php echo get_currency_price($TPL_V1["shipping"]["shipping_coupon_sale"], 3)?> 쿠폰</div>
<?php }?>
<?php if($TPL_V1["shipping"]["shipping_promotion_code_sale"]> 0){?>
			<div class="desc">-<?php echo get_currency_price($TPL_V1["shipping"]["shipping_promotion_code_sale"], 3)?> 코드</div>
<?php }?>
<?php if(($TPL_V1["shipping"]["enuri_sale_unit"]+$TPL_V1["shipping"]["enuri_sale_rest"])> 0){?>
			<div class="desc">-<?php echo get_currency_price(($TPL_V1["shipping"]["enuri_sale_unit"]+$TPL_V1["shipping"]["enuri_sale_rest"]), 3)?> 에누리</div>
<?php }?>

<?php }?>
		</td>

		<!-- 동일 상품의 기존 환불금액 -->
		<td class="info right">
			<span class="fx11 red"><?php echo get_currency_price($TPL_V1["shipping"]["refund_complete_delivery"])?></span><br />
			<span class="fx11 gray">
				잔여:<?php if($TPL_V1["shipping"]["shipping_cost"]-$TPL_V1["shipping"]["shipping_coupon_sale"]-$TPL_V1["shipping"]["shipping_promotion_code_sale"]> 0){?>
					<?php echo get_currency_price($TPL_V1["shipping"]["shipping_cost"]-$TPL_V1["shipping"]["shipping_coupon_sale"]-$TPL_V1["shipping"]["shipping_promotion_code_sale"]-$TPL_V1["shipping"]["refund_complete_delivery"]-($TPL_V1["shipping"]["enuri_sale_unit"]+$TPL_V1["shipping"]["enuri_sale_rest"]))?>

<?php }else{?>
						0
<?php }?>
			</span>
		</td>

		<!-- 환불수량 -->
		<td class="info right">-</td>
		
		<!-- 환불배송비 -->
		<td class="info center">
<?php if($TPL_V1["return_shipping_cnt"]> 0&&!$TPL_V1["refund_payment"]["onlycash"]&&!$TPL_V1["refund_payment"]["onlyemoney"]){?>
			<div style="margin-top:2px;">
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["pg"]=="npay"){?>
				<input type="hidden" name="refund_delivery_price_npay[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" value="<?php echo get_currency_price($TPL_V1["return_shipping_cost"])?>" class="input_line" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?>>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
				<div name="refund_delivery_price_txt[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" class="refund_delivery_price_txt right"><?php echo get_currency_price($TPL_V1["return_shipping_cost"])?></div>
				<input type="hidden" name="refund_delivery_price_tmp[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" value="<?php echo get_currency_price($TPL_V1["return_shipping_cost"])?>" class="refund_adjust input_line refund_delivery_price_area" data-return_shipping_seq="<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>"  itype="delivery_price">
				<input type="hidden" name="refund_delivery_price_origin[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" value="<?php echo get_currency_price($TPL_V1["return_shipping_cost"])?>" class="input_line " itype="delivery_price">
<?php }else{?>
				<input type="<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["pg"]=="npay"){?>hidden<?php }else{?>text<?php }?>" name="refund_delivery_price_tmp[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" value="<?php echo get_currency_price($TPL_V1["return_shipping_cost"])?>" class="refund_adjust input_line refund_delivery_price_area" data-return_shipping_seq="<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>" itype="delivery_price">
				<input type="hidden" name="refund_delivery_price_origin[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" value="<?php echo get_currency_price($TPL_V1["return_shipping_cost"])?>" class="input_line " itype="delivery_price">
<?php }?>
<?php if($TPL_VAR["data_order"]["pg_currency"]&&$TPL_VAR["data_order"]["pg_currency"]!=$TPL_VAR["basic_currency"]){?>
				<div class="mt5 refund_pg_price desc hide">결제(<?php echo $TPL_VAR["data_order"]["pg_currency"]?>): <span></span></div>
<?php }?>
			</div>
<?php }else{?>
			<div class="right">-</div>
<?php }?>
		</td>

		<!-- 예치금 -->
		<td class="info center">
<?php if($TPL_VAR["cash_use"]!='N'&&$TPL_VAR["data_order"]["pg"]!='npay'&&$TPL_V1["shipping"]["refund_delivery_cash"]> 0){?>
<?php if($TPL_V2["ea"]> 0){?>
<?php if(serviceLimit('H_AD')){?>
			<div name="refund_delivery_cash_txt[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" class="refund_delivery_cash_txt right"><?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_cash"])?></div>
			<input type="hidden" maxlength="10" name="refund_delivery_cash_tmp[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" data-return_shipping_seq="<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>" class="refund_delivery_cash_area refund_cash_input refund_adjust input_line onlyfloat refund_adjust_input" itype="cash" value="<?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_cash"])?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?> />
			<input type="hidden" name="refund_delivery_cash_area_origin[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" value="<?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_cash"])?>"/>
<?php }else{?>
			<input type="text" maxlength="10" name="refund_delivery_cash_tmp[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" data-return_shipping_seq="<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>" class="refund_delivery_cash_area refund_cash_input refund_adjust input_line onlyfloat refund_adjust_input" itype="cash" value="<?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_cash"])?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?> />
			<input type="hidden" name="refund_delivery_cash_area_origin[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" value="<?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_cash"])?>"/>
<?php }?>
<?php }else{?>
			<div class="right gray"><?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_cash"])?></div>
<?php }?>
<?php }else{?>
			<div class="right">-</div>
<?php if(serviceLimit('H_AD')){?>
			<div name="refund_delivery_cash_txt[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" class="refund_delivery_cash_txt right hide"><?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_cash"])?></div>
			<input type="hidden" maxlength="10" name="refund_delivery_cash_tmp[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]"  data-return_shipping_seq="<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>"  class="refund_delivery_cash_area refund_cash_input refund_adjust input_line onlyfloat refund_adjust_input hide" itype="cash" value="<?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_cash"])?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?> />
			<input type="hidden" name="refund_delivery_cash_area_origin[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" value="<?php echo get_currency_price($TPL_V1["shipping"]["ori_refund_delivery_cash"])?>"/>
<?php }else{?>
			<input type="text" maxlength="10" name="refund_delivery_cash_tmp[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]"  data-return_shipping_seq="<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>"  class="refund_delivery_cash_area refund_cash_input refund_adjust input_line onlyfloat refund_adjust_input hide" itype="cash" value="<?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_cash"])?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?> />
			<input type="hidden" name="refund_delivery_cash_area_origin[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" value="<?php echo get_currency_price($TPL_V1["shipping"]["ori_refund_delivery_cash"])?>"/>
<?php }?>
<?php }?>
		</td>

		<!-- 마일리지 -->
		<td class="info center">
<?php if($TPL_VAR["data_order"]["pg"]!='npay'&&$TPL_V1["shipping"]["refund_delivery_emoney"]> 0){?>
<?php if($TPL_V2["ea"]> 0){?>
<?php if(serviceLimit('H_AD')){?>
			<div class="refund_delivery_emoney_txt right"><?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_emoney"])?></div>
			<input type="hidden" maxlength="10" name="refund_delivery_emoney_tmp[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" class="refund_emoney_input refund_adjust input_line onlyfloat refund_adjust_input" itype="emoney" value="<?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_emoney"])?>" />
<?php }else{?>
			<input type="text" maxlength="10" name="refund_delivery_emoney_tmp[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" class="refund_emoney_input refund_adjust input_line onlyfloat refund_adjust_input" itype="emoney" value="<?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_emoney"])?>" />
<?php }?>
<?php }else{?>
			<div class="right gray"><?php echo get_currency_price($TPL_V1["shipping"]["refund_delivery_emoney"])?></div>
<?php }?>
<?php }else{?>
			<div class="right">-</div>
<?php }?>
		</td>

		<!-- 쿠폰/코드재발행 -->
		<td class="info center">
<?php if(!($TPL_V1["shipping"]["shipping_coupon_sale"]&&$TPL_V1["shipping"]["shipping_coupon_down_seq"])&&!($TPL_V1["shipping"]["shipping_promotion_code_seq"]&&strstr($TPL_V1["shipping"]["shipping_promotion_type"],'shipping'))){?>
			<div class="right">-</div>
<?php }?>
			
			<div>
<?php if($TPL_V1["shipping"]["shipping_coupon_sale"]&&$TPL_V1["shipping"]["shipping_coupon_down_seq"]){?>
<?php if($TPL_V1["shipping"]["restore_used_coupon_refund"]||$TPL_VAR["data_refund"]["status"]=='complete'){?>
			<span class="fx11 lsp-1">쿠폰 재발행</span>
<?php }else{?>
			<div>
			<label class="fx11 lsp-1"><input type="checkbox" name="refund_delivery_coupon[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" value="<?php echo $TPL_V1["shipping"]["shipping_coupon_down_seq"]?>" <?php if($TPL_V2["refund_delivery_coupon"]){?>checked<?php }?> <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?>> 쿠폰 재발행</label>
			</div>
<?php }?>
<?php }?>
			</div>
			
			<div>
<?php if($TPL_V1["shipping"]["shipping_promotion_code_seq"]&&strstr($TPL_V1["shipping"]["shipping_promotion_type"],'shipping')){?>
<?php if($TPL_V1["shipping"]["restore_used_promotioncode_refund"]||$TPL_VAR["data_refund"]["status"]=='complete'){?>
			<span class="fx11 lsp-1">코드 재발행</span>
<?php }else{?>
			<div style="margin-top:2px;">
			<label class="fx11 lsp-1"><input type="checkbox" name="refund_delivery_promotion[<?php echo $TPL_V1["return_shipping"][$TPL_V2["shipping_seq"]]?>]" value="<?php echo $TPL_V1["shipping"]["shipping_promotion_code_seq"]?>" <?php if($TPL_V2["refund_delivery_promotion"]){?>checked<?php }?> <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?>> 코드 재발행</label>
			</div>
<?php }?>
<?php }?>
			</div>
		</td>
	</tr>
<?php }?>
<?php }}?>
<?php }}?>

	<!--//## 조정금액 상품 -->
	<tr class="order-item-row">
		<!-- 구분 -->
		<td class="info center">조정금액<br>(상품)</td>
		<!-- 상품&옵션명 -->
		<td class="info left">
<?php if($TPL_VAR["tot"]["refund_goods_sale_txt"]){?>
			위 환불신청 건 분석 결과, 상품 할인(<span style="color:red"><?php echo $TPL_VAR["tot"]["refund_goods_sale_txt"]?></span>) 내역이 있습니다. 주문내역 확인 후 환불처리하시기 바랍니다.
<?php }else{?>
			위 환불신청 건 분석 결과, 조정할 금액이 없습니다.
<?php }?>
		</td>
		<!-- 수량 -->
		<td class="info right"></td>
		<!-- 할인가격 -->
		<td class="info right"></td>
		<!-- 동일 상품의 기존 환불금액 -->
		<td class="info right"></td>
		<!-- 방법 -->
		<td class="info right"></td>
		<!-- 수량 -->
		<td class="info right"></td>
		<!-- 금액 -->
		<td class="info center">
			<div style="margin-top:2px;">
				<input type="text" name="refund_deductible_price" class="refund_deductible_price_input refund_adjust input_line onlyfloat refund_adjust_input" itype="deductible_price" value="<?php echo get_currency_price($TPL_VAR["tot"]["refund_deductible_price"])?>">
			</div>
		</td>
		<!-- 예치금 -->
		<td class="info center"></td>
		<!-- 마일리지 -->
		<td class="info center"></td>
		<!-- 유효기간 -->
		<td class="info right"></td>
		<!-- 쿠폰/코드재발행 -->
		<td class="info center"></td>
	</tr>

<?php if($TPL_VAR["tot"]["goods_kind"]=='goods'){?>
	<!--//## 조정금액 배송비 -->
	<tr class="order-item-row">
		<!-- 구분 -->
		<td class="info center">조정금액<br>(배송비)</td>
		<!-- 상품&옵션명 -->
		<td class="info left">
<?php if($TPL_VAR["tot"]["refund_shipping_sale_txt"]||$TPL_VAR["tot"]["refund_shipping_iffree_txt"]){?>
			위 환불신청 건 분석 결과, <?php if($TPL_VAR["tot"]["refund_shipping_sale_txt"]){?>배송비 할인(<span style="color:red"><?php echo $TPL_VAR["tot"]["refund_shipping_sale_txt"]?></span>)<?php }?> <?php if($TPL_VAR["tot"]["refund_shipping_sale_txt"]&&$TPL_VAR["tot"]["refund_shipping_iffree_txt"]){?>및<?php }?> <?php if($TPL_VAR["tot"]["refund_shipping_iffree_txt"]){?><span style="color:red">조건부 배송비</span><?php }?> 내역이 있습니다. 주문내역 확인 후 환불처리하시기 바랍니다.
<?php }else{?>
			위 환불신청 건 분석 결과, 조정할 금액이 없습니다.
<?php }?>
		</td>
		<!-- 수량 -->
		<td class="info right"></td>
		<!-- 할인가격 -->
		<td class="info right"></td>
		<!-- 동일 상품의 기존 환불금액 -->
		<td class="info right"></td>
		<!-- 방법 -->
		<td class="info right"></td>
		<!-- 수량 -->
		<td class="info right"></td>
		<!-- 금액 -->
		<td class="info center">
			<div style="margin-top:2px;">
				<input type="text" name="refund_delivery_deductible_price" class="refund_delivery_deductible_price_input refund_adjust input_line onlyfloat refund_adjust_input" itype="delivery_deductible_price" value="<?php echo get_currency_price($TPL_VAR["tot"]["refund_delivery_deductible_price"])?>">
			</div>
		</td>
		<!-- 예치금 -->
		<td class="info center"></td>
		<!-- 마일리지 -->
		<td class="info center"></td>
		<!-- 유효기간 -->
		<td class="info center"></td>
		<!-- 쿠폰/코드재발행 -->
		<td class="info center"></td>
	</tr>
<?php }?>

<?php if($TPL_VAR["tot"]["goods_kind"]=='coupon'&&$TPL_VAR["tot"]["refund_penalty_deductible_price"]> 0){?>
	<!--//## 조정금액 환불위약금 -->
	<tr class="order-item-row">
		<!-- 구분 -->
		<td class="info center">조정금액<br>(환불위약금)</td>
		<!-- 상품&옵션명 -->
		<td class="info left">
			환불 수수료가 발생하였습니다.<br>
			환불예정금액에서 차감 후 환불됩니다.
		</td>
		<!-- 수량 -->
		<td class="info right"></td>
		<!-- 할인가격 -->
		<td class="info right"></td>
		<!-- 동일 상품의 기존 환불금액 -->
		<td class="info right"></td>
		<!-- 방법 -->
		<td class="info right"></td>
		<!-- 수량 -->
		<td class="info right"></td>
		<!-- 금액 -->
		<td class="info right"><?php echo get_currency_price($TPL_VAR["tot"]["refund_penalty_deductible_price"])?></td>
		<!-- 예치금 -->
		<td class="info right"></td>
		<!-- 마일리지 -->
		<td class="info right"></td>
		<!-- 유효기간 -->
		<td class="info center"></td>
		<!-- 쿠폰/코드재발행 -->
		<td class="info right"></td>
	</tr>
<?php }?>
	
<?php if($TPL_VAR["data_refund"]["refund_ship_duty"]=='buyer'&&$TPL_VAR["data_refund"]["refund_ship_type"]=='M'&&$TPL_VAR["data_refund"]["return_shipping_price"]> 0){?>
	<!--//## 반품 배송비 영역 -->
	<tr class="order-item-row">
		<td class="info center">조정금액<br>(반품배송비)</td>
		<!-- 상품&옵션명 -->
		<td class="info left">
			구매자 귀책 사유로 반품배송비가 발생하였습니다.<br>
			환불예정금액에서 차감 후 환불됩니다.
		</td>
		<!-- 상품판매수량 -->
		<td class="info right">-</td>
		<!-- 상품판매가격 -->
		<td class="info right">-</td>
		<!-- 동일주문의 기존 환불금액 -->
		<td class="info right">-</td>
		<!-- 방법 -->
		<td class="info right"></td>
		<!-- 환불수량 -->
		<td class="info right">-</td>
		<!-- 반품배송비 -->
		<td class="info right"><?php echo get_currency_price($TPL_VAR["data_refund"]["return_shipping_price"])?></td>
		<!-- 예치금 -->
		<td class="info right">-</td>
		<!-- 마일리지 -->
		<td class="info right">-</td>
		<!-- 유효기간 -->
		<td class="info center"></td>
		<!-- 쿠폰/코드재발행 -->
		<td class="info right">-</td>
	</tr>
<?php }?>

	<!--//## 결제 영역 총 결산 -->
	<tr class="order-item-row">
		<td class="center bg-gray">결제내역</td>
		<td class="right bg-gray" colspan="3">&nbsp;</td>
		<td class="right bg-gray">
			<input type="hidden" name="settle_price" value="<?php echo $TPL_VAR["data_order"]["settleprice"]?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?>>
			<div class="fx14 pd3 red bold"> <?php echo get_currency_price($TPL_VAR["tot"]["refund_complete_total"])?></div>
			<input type="hidden" name="complete_price" value="<?php echo $TPL_VAR["tot"]["refund_complete_total"]?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?>>
		</td>
		<td class="right bg-gray">&nbsp;</td>
		<td class="right bg-red white refund_line_top refund_line_left refund_line_bottom refund_line_right" colspan="6" style="padding:5px 5px;">
			<input type="hidden" maxlength="10" name="refund_emoney" class="refund_adjust input_line onlyfloat refund_adjust_input" itype="emoney" value="<?php echo get_currency_price($TPL_VAR["data_refund"]["refund_emoney"])?>" />
			<input type="hidden" maxlength="10" name="refund_cash" class="refund_adjust input_line onlyfloat refund_adjust_input" itype="cash" value="<?php echo get_currency_price($TPL_VAR["data_refund"]["refund_cash"])?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?> />
			<input type="hidden" name="refund_shipping_price" class="refund_adjust input_line onlyfloat refund_adjust_input" value="<?php echo $TPL_VAR["data_refund"]["return_shipping_price"]?>" />
			<input type="hidden" name="refund_penalty_deductible_price" class="refund_adjust input_line onlyfloat refund_adjust_input" value="<?php echo $TPL_VAR["tot"]["refund_penalty_deductible_price"]?>" />

			<span id="refund_price_txt" class="fx14"><?php echo get_currency_price($TPL_VAR["data_refund"]["refund_price_sum"])?></span> <span id="refund_method_txt">(<?php echo $TPL_VAR["refund_method_name"]?>)</span>
<?php if($TPL_VAR["data_order"]["pg"]!='npay'){?>
			+ <span id="refund_cash_txt" class="fx14"><?php echo get_currency_price($TPL_VAR["data_refund"]["refund_cash_sum"])?></span> (예치금)
			+ <span id="refund_emoney_txt" class="fx14"><?php echo get_currency_price($TPL_VAR["data_refund"]["refund_emoney"])?></span> (마일리지)
<?php }?>
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_refund"]["npay_claim_price"]){?>
			- <span class="fx14"><?php echo get_currency_price($TPL_VAR["data_refund"]["npay_claim_price"])?></span>(Npay 환불 차감 금액)
<?php }?>
<?php if($TPL_VAR["data_refund"]["refund_ship_duty"]=='buyer'&&$TPL_VAR["data_refund"]["refund_ship_type"]=='M'){?>
<?php }else{?>
			<!-- 조정금액으로 반품배송비 명칭이 없어지고 조정금액 총합으로 변경된 것으로 분석됨 by hed -->
			<!-- - <?php echo get_currency_price($TPL_VAR["data_refund"]["return_shipping_price"])?> <span class="fx12 lsp-1">(반품배송비)</span>-->
<?php }?>
			- <span id="refund_all_deductible_price_txt" class="fx14"><?php echo get_currency_price($TPL_VAR["tot"]["refund_all_deductible_price"]+$TPL_VAR["data_refund"]["return_shipping_price"])?></span> (조정금액)
			= <span id="refund_price_sum" class="fx14 bold"><?php echo get_currency_price($TPL_VAR["data_refund"]["refund_total_price"])?></span>
			<input type="hidden" name="refund_price" value="<?php echo $TPL_VAR["data_refund"]["refund_total_price"]?>" <?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_order"]["npay_order_id"]){?>disabled<?php }?>>
			<div  class="mt5">
				<span class="fx13">※ 실제 결제 통화 금액 : <?php echo get_currency_price($TPL_VAR["data_order"]["payment_price"], 3,$TPL_VAR["data_order"]["pg_currency"],'','<span id=payment_price>_str_price_</span>')?></span>
			</div>
		</td>
	</tr>
</tbody>
</table>

<div id="warning_msg" class="red pd10 bold right hide"></div>

<?php if($TPL_VAR["data_order"]["orign_order_seq"]){?>
<div class="pd20 darkgray" style="line-height:18px;border-bottom:1px solid #ddd;">
	<span class="black">위 환불건은 재주문 된 상품의 환불건입니다.</span> <br />
	재주문 된 상품은 판매금액이 0원이기 때문에 재주문 된 상품의 환불금액은
	원주문의 상품 금액을 기준으로 환불을 처리를 해 주십시오.
	<a href="/admin/order/view?no=<?php echo $TPL_VAR["data_order"]["orign_order_seq"]?>" target=_blank><span class="blue">[원주문 확인하기]</span></a><br />

	<div style="margin-top:10px;">
		<span class="orange bold">※ 재주문이란?</span> 원주문이 있은 후 (맞)교환 발생으로 다시 주문된 주문건을 말합니다. <br />
	   원주문의 매출과 중복으로 매출이 잡히지 않기 위해 재주문건의 매출은 0원이 됩니다.
	  </div>
</div>
<?php }?>

<?php if($TPL_VAR["data_refund"]["member_seq"]){?>
<div class="emoney_refund_cell">

	<div class="pd10 mt25">2. 지급된 마일리지 및 포인트 회수</div>

	<table class="order-view-table" width="100%" border="0">
	<colgroup>
		<col width="80" />
		<col />
		<col />
		<col width="380" />
		<col width="90" />
	</colgroup>
	<thead class="oth">
		<tr>
			<th class="dark" style="height:45px;">구분</th>
			<th class="dark">
<?php if($TPL_VAR["data_refund"]["member_seq"]){?>
<?php if($TPL_VAR["members"]["type"]=='개인'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" />
<?php }elseif($TPL_VAR["members"]["type"]=='기업'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" /><?php }?>
						<?php echo $TPL_VAR["data_refund"]["user_name"]?>

<?php if($TPL_VAR["members"]["rute"]=='facebook'){?>
							(<a href="/admin/member/detail?member_seq=<?php echo $TPL_VAR["data_refund"]["member_seq"]?>" target="_blank"><span style="color:#d13b00;"><img src="/admin/skin/default/images/board/icon/sns_f0.gif" align="absmiddle"><?php echo $TPL_VAR["members"]["email"]?></span>/<span class="blue"><?php echo $TPL_VAR["data_refund"]["group_name"]?>}</span></a>)
<?php }else{?>
							(<a href="/admin/member/detail?member_seq=<?php echo $TPL_VAR["data_refund"]["member_seq"]?>" target="_blank"><span style="color:#d13b00;"><?php echo $TPL_VAR["data_refund"]["userid"]?></span>/<span class="blue"><?php echo $TPL_VAR["data_refund"]["group_name"]?></span></a>)
<?php }?>
<?php }else{?>
					<img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <?php echo $TPL_VAR["data_refund"]["user_name"]?>(<span class="desc">비회원</span>)
<?php }?>
					님의<br />현재 보유 마일리지 및 포인트</th>
			<th class="dark">회수(차감)해야할 마일리지 및 포인트</th>
			<th class="dark refund_line_top refund_line_left ">회수(차감) 가능한 마일리지 및 포인트</th>
			<th class="dark refund_line_top refund_line_right">비고</th>
		</tr>
	</thead>
	<tbody class="otb">
		<tr class="order-item-row">
			<td class='list center'>마일리지</td>
			<td class='list right'><?php echo get_currency_price($TPL_VAR["members"]["emoney"])?></td>
			<td class='list right'><span class="darkgray" title="회수(차감)해야할 마일리지 계산식"><?php echo $TPL_VAR["return_formula"]["reserve"]?></span> <?php echo get_currency_price($TPL_VAR["tot"]["return_reserve"])?></td>
			<td class='list bg-red right refund_line_top refund_line_left '>
				<span class="white fx14 bold">
<?php if($TPL_VAR["tot"]["return_reserve_use"]){?>
					<?php echo get_currency_price($TPL_VAR["tot"]["return_reserve"])?>

<?php }else{?>
					<?php echo get_currency_price($TPL_VAR["members"]["emoney"])?>

<?php }?>
				</span>
			</td>
			<td class='list center bg-red refund_line_top refund_line_right'>
				<span class="white fx14 bold"><?php if($TPL_VAR["tot"]["return_reserve_use"]){?>정상<?php }else{?>비정상<?php }?></span>
			</td>
		</tr>
		<tr class="order-item-row">
			<td class='list center'>포인트</td>
			<td class='list right'><?php echo get_currency_price($TPL_VAR["members"]["point"])?></td>
			<td class='list right'><span class="darkgray" title="회수(차감)해야할 포인트 계산식"><?php echo $TPL_VAR["return_formula"]["reserve"]?></span> <?php echo get_currency_price($TPL_VAR["tot"]["return_point"])?></td>
			<td class='list bg-red right white refund_line_left refund_line_bottom fx14'>
				<span class="white fx14 bold">
<?php if($TPL_VAR["tot"]["return_point_use"]){?>
					<?php echo get_currency_price($TPL_VAR["tot"]["return_point"])?>

<?php }else{?>
					<?php echo get_currency_price($TPL_VAR["members"]["point"])?>

<?php }?>
				</span>
			</td>
			<td class='list center bg-red refund_line_right refund_line_bottom'>
				<span class="white fx14 bold"><?php if($TPL_VAR["tot"]["return_point_use"]){?>정상<?php }else{?>비정상<?php }?></span>
			</td>
		</tr>
	</tbody>
	</table>
</div>
<?php }?>
<?php }?>


<div style="height:25px;"></div>

<?php if($TPL_VAR["data_order"]["pg"]=="npay"&&$TPL_VAR["npay_use"]){?>

	<div style="text-align:Center;padding:20px;">
	<input type="hidden" name="status" value="complete" />
<?php if($TPL_VAR["data_refund"]["refund_type"]=='return'&&$TPL_VAR["data_refund"]["npay_flag"]=="RequestReturn"){?>
	이 환불건은 네이버페이 반품건이므로 직접 처리 불가합니다..</div>
<?php }elseif($TPL_VAR["data_refund"]["refund_type"]=='cancel_payment'&&$TPL_VAR["data_refund"]["npay_flag"]=="refund_request"){?>
	<div style="line-height:30px;">
	네이버 페이 환불요청 승인 처리를 합니다. 실제 환불은 네이버페이에서 처리됩니다. </div>
	<span class="btn large black"><input type="submit" value="취소요청승인" /></span>
<?php }elseif($TPL_VAR["data_refund"]["npay_flag"]=="cancel_done"){?>
	<div style="line-height:30px;">네이버페이 환불완료 되었습니다.</div>
<?php }else{?>
	<div style="line-height:30px;">네이버페이에서 환불 진행중이므로, 환불상태(환불신청/환불처리중) 변경이 불가합니다.</div>
<?php }?>
	</div>

<?php }else{?>
<div style="text-align:center;">
	<table style="margin:auto;">
	<col width="100" />
	<col />
	<tr>

		<td valign="top">
<?php if($TPL_VAR["data_refund"]["status"]=='complete'){?>
			<input type="hidden" name="status" value="complete" />
			<select disabled readonly class="status">
			<option value="complete">환불 완료</option>
			</select>
<?php }else{?>
			<select name="status" class="status">
				<option value="request">환불 신청</option>
				<option value="ing">환불 처리중</option>
				<option value="complete">환불 완료</option>
			</select>
<?php }?>
		</td>

		<td valign="top">
<?php if($TPL_VAR["data_refund"]["status"]=='complete'){?>
			<div class="status_change_msg" style="border:3px solid #333;display:block;">
			해당 환불건의 처리가 완료된 상태입니다.
			</div>
<?php }else{?>
			<div class="status_change_msg request">환불 신청 상태입니다.</div>
			<div class="status_change_msg ing">환불 처리 중 상태입니다.</div>

			<div class="status_change_msg complete bank">
				환불 완료 상태입니다. 실제 환불이 진행됩니다.<br />
				환불완료 처리 후에는 환불금액과 환불방법을 수정할 수 없습니다.<br />

				<span class="gray left">
				- 마일리지(또는 예치금) 환불 : 입력된 환불금액을 자동으로 환불합니다.<br />
				- 무통장 환불 : 입력된 환불금액을 수동으로 입금해 주십시오.
				</span>
				<br />
<?php if($TPL_VAR["data_refund"]["refund_type"]=='shipping_price'&&$TPL_VAR["data_refund"]["refund_provider_seq"]> 1){?>
				<span class="red">환불완료 시 배송비 환불금액 <b>[<?php echo $TPL_VAR["data_refund"]["refund_provider_name"]?>]</b> 정산에 차감 반영됩니다.</span><br/>
<?php }?>
				최종환불금액이 <span class="status_change_msg_price"></span>원이 맞습니까?
			</div>
			<div class="status_change_msg complete card">
				환불상태를 처리완료로 업데이트하고 실제로 환불 처리가 됩니다.<br />
				최종환불금액이 <span class="status_change_msg_price"></span>원이 맞습니까?<br />
				<span class="red">
					(자동) 카드결제 환불금액만큼 카드결제를 취소합니다.<br />
					(자동) 마일리지으로 마일리지 환불금액만큼 되돌려 드립니다.<br />
				</span>
				<br />
				★ 환불완료 처리 후에는 환불금액과 환불방법을 수정할 수 없습니다.
			</div>

			<div class="status_change_msg complete manual">
				환불상태를 처리완료로 업데이트하고 실제로 환불 처리가 됩니다.<br />
				최종환불금액이 <span class="status_change_msg_price"></span>원이 맞습니까?<br />
				<span class="red">
					(자동) 마일리지으로 마일리지 환불금액만큼 되돌려 드립니다.<br />
					(수동) 전자결제(PG)사 어드민페이지에서 직접 결제 취소를 하셨습니까?<br />
				</span>
				<br />
				★ 환불완료 처리 후에는 환불금액과 환불방법을 수정할 수 없습니다.
			</div>
			<div class="status_change_msg" curStatus="request">환불 신청 상태입니다.</div>
			<div class="status_change_msg" curStatus="ing">환불 처리 중 상태입니다.</div>
			<div class="status_change_msg" curStatus="complete">해당 환불건의 처리가 완료된 상태입니다.</div>
<?php }?>
		</td>
		<td valign="top"><span class="btn large black"><input type="submit" value="확인" /></span></td>
	</tr>
	</table>
</div>
<?php }?>

</form>

<div style="height:20px;"></div>

<table class="order-view-table" width="100%" border="0">
<colgroup>
	<col width="50%" />
	<col width="50%" />
</colgroup>
	<form name="frm_admin_memo" method="post" action="../refund_process/admin_memo?seq=<?php echo $TPL_VAR["data_refund"]["refund_seq"]?>" target="actionFrame">
<thead class="oth">
	<th class="dark" style="height:45px;">
		관리자 메모
		<span class="btn small cyanblue"><button type="submit">변경</button></span>
	</th>
	<th class="dark" style="height:45px;">SMS 전송</th>
</tr>
</thead>
<tbody class="otb">
<tr>
	<td valign="top"  class='list center' style="background-color:#dfdfdf;">
		<textarea class="odt-memo-textarea line" style="margin:5px 0 5px 0;width:96%;height:140px;" name="admin_memo"><?php echo $TPL_VAR["data_refund"]["admin_memo"]?></textarea>
	</td>
	</form>

	<td valign="top" class='list center' style="background-color:#dfdfdf;border-left:1px solid #BCBFC1;">
		<div id="sms_form" style="margin:5px auto;border:0px;"></div>
	</td>
</tr>
</tbody>
</table>

<div id="gift_use_lay"></div>

<script>apply_input_style();</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>


<?php if($TPL_VAR["pgCompany"]=='allat'&&$TPL_VAR["naxCheck"]=='N'){?>
	<script language="JavaScript" charset='utf-8' src='https://tx.allatpay.com/common/AllatPayRE.js'></script>
<?php }?>