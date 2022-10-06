<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/_modules/prints/form_print_trade.html 000012871 */  $this->include_("defaultScriptFunc");
$TPL_shipping_group_items_1=empty($TPL_VAR["shipping_group_items"])||!is_array($TPL_VAR["shipping_group_items"])?0:count($TPL_VAR["shipping_group_items"]);?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<title>거래명세서</title>
<style type="text/css" media="all">
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,textarea,p,blockquote,th,td,input,select,textarea,button{margin:0;padding:0;}
body,th,td,input,select,textarea,button{ font-size:13px; line-height:1.4; font-weight:400; color:#333; font-family:'Malgun Gothic',sans-serif;}
fieldset{border:0 none;vertical-align:top;}
dl,ul,ol,menu,li{list-style:none}
img { max-width:100%; }

table{width:100%; border-collapse:collapse;border-spacing:0; border:1px #bbb solid; }
th { padding:5px; border:1px #bbb solid; text-align:left; background:#eee; font-weight:normal; }
td { padding:5px; border:1px #bbb solid; text-align:left; }

h2 { padding:10px 0; text-align:center; font-size:28px; }
h3 { padding:6px 0; font-size:15px; color:#000; }
#frint_layout { padding:10px; }
#btn_area { padding-top:10px; text-align:center; }

.estmate_top:after {content:""; display:block; clear:both;}
.estmate_top>li { float:right; width:calc(50% - 5px); }
.estmate_top>li:first-child { float:left; }

.table_1 td { text-align:right; }
.txt1 { padding:10px 0; color:#767676; }

.table_2 { width:100%; table-layout:fixed; }
.table_2 th { text-align:right; }
.table_2 td { text-align:right; }
.table_2 thead th { padding-top:10px; padding-bottom:10px; text-align:center; }
.table_2 tbody tr td:first-child { text-align:left; }
.table_2 .bg2 td { background:#f8f8f8; padding-top:10px; padding-bottom:10px; font-weight:bold; }
.table_2 .bg3 td { background:#e4e4e4; padding-top:10px; padding-bottom:10px; font-weight:bold; }

.tot_cont { margin-top:10px; border:2px #333 solid; padding:15px 0; text-align:center; font-size:17px; font-weight:bold; text-align:right; }
.tot_cont>li { padding:5px 10px; }
.tot_cont .title { font-weight:normal; }
.tot_cont .cont { display:inline-block; min-width:124px; }
.tot_cont .tot_price { font-size:21px; }

@media only screen and (max-width:767px) {
	h3 { padding-top:20px; }
	.estmate_top>li { float:none; width:auto; }
	.estmate_top>li:first-child { float:none; width:auto; }
	.table_2 td { font-size:12px; }
}

@media print {
	* { color:#000 !important; }
	#frint_layout { padding:0; }
	#btn_area { display:none; }
}
</style>
<?php echo defaultScriptFunc()?></head>
<body>

<div id="frint_layout">
	<h2>거래명세서</h2>

	<!-- -->
	<ul class="estmate_top">
		<li class="left_area">
			<h3>결제정보</h3>
			<table class="table_1" cellpadding="0" cellspacing="0">
				<colgroup><col width="90" /><col /></colgroup>
				<tbody>
					<tr>
						<th>상품 금액</th>
						<td><?php echo get_currency_price($TPL_VAR["items_tot"]["price"], 2)?></td>
					</tr>
					<tr>
						<th>배송비</th>
						<td><?php echo get_currency_price($TPL_VAR["shipping_tot"]["shipping_cost"], 2)?></td>
					</tr>
					<tr>
						<th>할인</th>
						<td>
							<?php echo get_currency_price($TPL_VAR["items_tot"]["event_sale"]+$TPL_VAR["items_tot"]["multi_sale"]+$TPL_VAR["items_tot"]["member_sale"]+$TPL_VAR["items_tot"]["mobile_sale"]+$TPL_VAR["items_tot"]["fblike_sale"]+$TPL_VAR["items_tot"]["coupon_sale"]+$TPL_VAR["items_tot"]["promotion_code_sale"]+$TPL_VAR["items_tot"]["referer_sale"]+$TPL_VAR["orders"]["coupon_sale"]+$TPL_VAR["orders"]["shipping_promotion_code_sale"]+$TPL_VAR["orders"]["enuri"]+$TPL_VAR["shipping_tot"]["coupon_sale"]+$TPL_VAR["shipping_tot"]["code_sale"], 2)?>

						</td>
					</tr>
					<tr>
						<th>사용마일리지</th>
						<td><?php echo get_currency_price($TPL_VAR["orders"]["emoney"], 2)?></td>
					</tr>
					<tr>
						<th>사용예치금</th>
						<td><?php echo get_currency_price($TPL_VAR["orders"]["cash"], 2)?></td>
					</tr>
					<tr>
						<th>결제금액</th>
						<td>
							<?php echo get_currency_price($TPL_VAR["orders"]["settleprice"], 2)?>

						</td>
					</tr>
					<tr>
						<th>결제수단</th>
						<td><?php echo $TPL_VAR["orders"]["mpayment"]?></td>
					</tr>
					<tr>
						<th>결제일</th>
						<td><?php if($TPL_VAR["orders"]["deposit_date"]){?><?php echo $TPL_VAR["orders"]["deposit_date"]?><?php }else{?>미결제<?php }?></td>
					</tr>
				</tbody>
			</table>
		</li>
		<li class="right_area">
			<h3>공급하는 자</h3>
			<table class="table_1" cellpadding="0" cellspacing="0">
				<colgroup><col width="90" /><col /><col width="60" /></colgroup>
				<tbody>
					<tr>
						<th>사업자 번호</th>
						<td colspan='2'><?php echo $TPL_VAR["businessLicense"]?></td>
					</tr>
					<tr>
						<th>상호</th>
						<td <?php if(!$TPL_VAR["signatureicon"]){?>colspan='2'<?php }?>><?php echo $TPL_VAR["companyName"]?></td>
<?php if($TPL_VAR["signatureicon"]){?>
						<td rowspan="2" style="text-align:center;"><img class="sign" src="<?php echo $TPL_VAR["signatureicon"]?>" /></td>
<?php }?>
					</tr>
					<tr>
						<th>대표자명</th>
						<td <?php if(!$TPL_VAR["signatureicon"]){?> colspan='2'<?php }?>><?php echo $TPL_VAR["ceo"]?></td>
					</tr>
					<tr>
						<th>주소</th>
						<td colspan='2'><?php echo $TPL_VAR["companyAddress"]?></td>
					</tr>
					<tr>
						<th>전화번호</th>
						<td colspan='2'><?php echo $TPL_VAR["companyPhone"]?></td>
					</tr>
					<tr>
						<th>홈페이지주소</th>
						<td colspan='2'><?php if($TPL_VAR["domain"]){?><?php echo $TPL_VAR["domain"]?><?php }else{?>-<?php }?></td>
					</tr>
				</tbody>
			</table>
		</li>
	</ul>
	<!-- // -->

	<div class="txt1">
<?php if($TPL_VAR["user_name"]){?>
			<?php echo $TPL_VAR["user_name"]?>님, 아래와 같이 계산합니다.<br/>
<?php }?>
		주문번호 : <?php echo $TPL_VAR["orders"]["order_seq"]?>

	</div>

	<table class="table_2" cellpadding="0" cellspacing="0">
		<colgroup>
			<col /><col style="width:8%;" /><col style="width:18%;" /><col style="width:14%;" /><col style="width:15%;" />
		</colgroup>
		<thead>
			<tr>
				<th>품명</th>
				<th>수량</th>
				<th>상품금액합계</th>
				<th>배송비</th>
				<th>할인</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_shipping_group_items_1){foreach($TPL_VAR["shipping_group_items"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["items"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if(is_array($TPL_R3=$TPL_V2["options"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
<?php if($TPL_V2["goods_type"]=='gift'){?>
			<tr style="background:#f6f6f6">
<?php }else{?>
			<tr>
<?php }?>
				<td>
					<?php echo $TPL_V2["goods_name"]?>

<?php if($TPL_V3["option1"]!=null){?>
					<div class="goods_option">
<?php if($TPL_V3["title1"]){?><?php echo $TPL_V3["title1"]?>:<?php }?><?php echo $TPL_V3["option1"]?>

<?php if($TPL_V3["option2"]!=null){?><?php if($TPL_V3["title2"]){?><?php echo $TPL_V3["title2"]?>:<?php }?><?php echo $TPL_V3["option2"]?><?php }?>
<?php if($TPL_V3["option3"]!=null){?><?php if($TPL_V3["title3"]){?><?php echo $TPL_V3["title3"]?>:<?php }?><?php echo $TPL_V3["option3"]?><?php }?>
<?php if($TPL_V3["option4"]!=null){?><?php if($TPL_V3["title4"]){?><?php echo $TPL_V3["title4"]?>:<?php }?><?php echo $TPL_V3["option4"]?><?php }?>
<?php if($TPL_V3["option5"]!=null){?><?php if($TPL_V3["title5"]){?><?php echo $TPL_V3["title5"]?>:<?php }?><?php echo $TPL_V3["option5"]?><?php }?>
					</div>
<?php }?>
<?php if($TPL_V3["inputs"]){?>
<?php if(is_array($TPL_R4=$TPL_V3["inputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
<?php if($TPL_V4["value"]){?>
							<div class="goods_input">
								<?php echo $TPL_V4["title"]?>:<?php echo $TPL_V4["value"]?>

							</div>
<?php }?>
<?php }}?>
<?php }?>
				</td>
				<td style="text-align:center;"><?php echo $TPL_V3["ea"]?></td>
				<td><?php echo get_currency_price(($TPL_V3["price"]*$TPL_V3["ea"]), 2)?></td>
<?php if($TPL_I2== 0&&$TPL_I3== 0){?>
				<td class="goods_delivery_info" <?php if(preg_match('/each/',$TPL_V1["shipping"]["shipping_method"])){?>style="color:#4298d3;"<?php }?> rowspan="<?php echo $TPL_V1["totalitems"]?>">
<?php if(preg_match('/gift/',$TPL_V1["shipping"]["shipping_group"])){?>
						<?php echo get_currency_price( 0, 2)?>

<?php }else{?>
						<div>
<?php if($TPL_V1["shipping"]["shipping_cost"]){?>
							<?php echo get_currency_price($TPL_V1["shipping"]["shipping_cost"]-$TPL_V1["shipping"]["atd_delivery_cost"], 2)?>

<?php }elseif($TPL_V1["shipping"]["postpaid"]){?>
							<?php echo get_currency_price($TPL_V1["shipping"]["postpaid"], 2)?>

<?php }elseif($TPL_V2["goods_shipping_cost"]){?>
							<?php echo get_currency_price($TPL_V2["goods_shipping_cost"], 2)?>

<?php }else{?>
							<?php echo get_currency_price( 0, 2)?>

<?php }?>
						</div>
<?php if(($TPL_V1["shipping"]["shipping_coupon_sale"]+$TPL_V1["shipping"]["shipping_promotion_code_sale"])> 0){?>
						<div>-<?php echo get_currency_price($TPL_V1["shipping"]["shipping_coupon_sale"]+$TPL_V1["shipping"]["shipping_promotion_code_sale"], 2)?></div>
<?php }?>
<?php }?>
				</td>
<?php }?>
				<td>
					<div><?php echo get_currency_price($TPL_V3["out_event_sale"]+$TPL_V3["out_multi_sale"]+$TPL_V3["out_coupon_sale"]+$TPL_V3["out_member_sale"]+$TPL_V3["out_fblike_sale"]+$TPL_V3["out_mobile_sale"]+$TPL_V3["out_promotion_code_sale"]+$TPL_V3["out_referer_sale"], 2)?></div>
				</td>
			</tr>
<?php if(is_array($TPL_R4=$TPL_V3["suboptions"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
			<tr class="bg1">
				<td class="suboption">
<?php if($TPL_V4["suboption"]){?>
					<div style="padding-left:4px;">
						<img src="/data/skin/responsive_diary_petit_gl/images/common/icon_sub2.png" alt="" style="vertical-align:middle; margin-top:-2px;" />
<?php if($TPL_V4["title"]){?><?php echo $TPL_V4["title"]?>:<?php }?><?php echo $TPL_V4["suboption"]?>

					</div>
<?php }?>
				</td>
				<td style="text-align:center;"><?php echo $TPL_V4["ea"]?></td>
				<td><?php echo get_currency_price(($TPL_V4["price"]*$TPL_V4["ea"]), 2)?></td>
				<td>
					<div><?php echo get_currency_price($TPL_V4["out_event_sale"]+$TPL_V4["out_multi_sale"]+$TPL_V4["out_coupon_sale"]+$TPL_V4["out_member_sale"]+$TPL_V4["out_fblike_sale"]+$TPL_V4["out_mobile_sale"]+$TPL_V4["out_promotion_code_sale"]+$TPL_V4["out_referer_sale"], 2)?></div>
				</td>
			</tr>
<?php }}?>
<?php }}?>
<?php }}?>
<?php }}?>
			<tr class="bg2">
				<td style="text-align:center;">합계</td>
				<td style="text-align:center;"><?php echo get_currency_price($TPL_VAR["orders"]["total_ea"])?></td>
				<td><?php echo get_currency_price($TPL_VAR["tot_real_price"], 2)?></td>
				<td><?php echo get_currency_price($TPL_VAR["shipping_tot"]["total_shipping_cost"], 2)?></td>
				<td><?php echo get_currency_price($TPL_VAR["tot_sales"], 2)?></td>
			</tr>
			<tr class="bg3">
				<td style="text-align:center;">결제금액</td>
				<td colspan="4"><?php echo get_currency_price($TPL_VAR["orders"]["settleprice"], 2)?></td>
			</tr>
<?php if($TPL_VAR["code"]!='cart'&&$TPL_VAR["orders"]["emoney"]> 0){?>
			<tr class="bg3">
				<td style="text-align:center;">사용 마일리지</td>
				<td colspan="4"><?php echo get_currency_price($TPL_VAR["orders"]["emoney"], 2)?></td>
			</tr>
<?php }?>
<?php if($TPL_VAR["code"]!='cart'&&$TPL_VAR["orders"]["cash"]> 0){?>
			<tr class="bg3">
				<td style="text-align:center;">사용 예치금</td>
				<td colspan="4"><?php echo get_currency_price($TPL_VAR["orders"]["cash"], 2)?></td>
			</tr>
<?php }?>
		</tbody>
	</table>

	<ul class="tot_cont">
		<li><span class="title">공급가액</span> : <span class="cont"><?php echo get_currency_price($TPL_VAR["provider_price"], 2)?></span></li>
		<li><span class="title">부가세액</span> : <span class="cont"><?php echo get_currency_price($TPL_VAR["tax_price"], 2)?></span></li>
		<li><span class="tot_price"><span class="title">합계</span> : <span class="cont"><?php echo get_currency_price($TPL_VAR["orders"]["settleprice"], 2)?></span></span></li>
	</ul>

	<!-- 하단 버튼 -->
	<div id="btn_area">
		<button type="button" onclick="window.print();" style="border:1px solid #969696; background:#aaa; padding:0 15px; line-height:30px; color:#fff; cursor:pointer;">인쇄</button>
	</div>

</div>

</body>
</html>