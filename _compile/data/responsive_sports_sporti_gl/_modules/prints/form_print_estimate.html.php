<?php /* Template_ 2.2.6 2021/12/15 16:50:22 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/_modules/prints/form_print_estimate.html 000014160 */  $this->include_("defaultScriptFunc","snsLikeButton");
$TPL_shipping_group_list_1=empty($TPL_VAR["shipping_group_list"])||!is_array($TPL_VAR["shipping_group_list"])?0:count($TPL_VAR["shipping_group_list"]);?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<title>견적서</title>
<style type="text/css" media="all">
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,textarea,p,blockquote,th,td,input,select,textarea,button{margin:0;padding:0;}
body,th,td,input,select,textarea,button{ font-size:13px; line-height:1.4; font-weight:400; color:#333; font-family:'Malgun Gothic',sans-serif;}
fieldset{border:0 none;vertical-align:top;}
dl,ul,ol,menu,li{list-style:none}
img { max-width:100%; }

table{width:100%; border-collapse:collapse;border-spacing:0; border:1px #bbb solid; }
th { padding:5px; border:1px #bbb solid; text-align:left; background:#eee; font-weight:normal; }
td { padding:5px; border:1px #bbb solid; text-align:left; }

body { overflow:hidden; }

#controll_frame { width:100%; }
#controll_frame td { text-align:center; height:110px; padding:0 5px; border-bottom:1px #333 solid; font-size:15px; }
#controll_frame .desc { padding-top:10px; font-size:13px; line-height:1.4; color:#999; }

#print_frame { position:fixed; left:0; top:112px; right:0; bottom:0; padding:10px; overflow-y:auto; }

h2 { padding:10px 0; text-align:center; font-size:28px; }
h3 { padding:6px 0; font-size:15px; color:#000; }
.estmate_top:after {content:""; display:block; clear:both;}
.estmate_top>li { float:right; width:calc(50% - 5px); }
.estmate_top>li:first-child { float:left; }
.estmate_top .left_area { text-align:center; }
.estmate_top .customer { padding:42px 0 32px; }
.estmate_top #apply_name { display:inline-block; line-height:30px; min-width:140px; border-bottom:1px #333 solid; margin-right:10px; font-size:15px; color:#000; }
.estmate_top .earlow { display:inline-block; line-height:30px; }
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
	.estmate_top .customer { padding:10px 0; }
	.table_2 td { font-size:12px; }
}

@media print {
	* { color:#000 !important; }
	#controll_frame { display:none; }
	#print_frame {position:relative; top:0; padding:0; }
}
</style>
<?php echo defaultScriptFunc()?></head>
<body>

	<!-- ++++++++++++++ 상단 ++++++++++++++ -->
	<table id="controll_frame" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td>
					<span style="color:#555;">받는분</span>&nbsp;
					<input type="text" class="inp" id="estimate_name" name="estimate_name" style="width:140px; border:none; border-bottom:1px solid #aaa; line-height:30px; font-size:15px; color:#000;" />
					<button class="apply-name" type="button" onclick="applyName();" style="border:1px solid #888; background:#fff; padding:0 15px; line-height:30px; font-weight:bold; color:#666; cursor:pointer;">적용</button>
					<button type="button" onclick="estimatePrint();" style="border:1px solid #969696; background:#aaa; padding:0 15px; line-height:30px; color:#fff; cursor:pointer;">인쇄</button>
					<p class="desc">받는분을 입력 후 적용을 클릭하면 아래의 입력란에 적용됩니다.</p>
				</td>
			</tr>
		</tbody>
	</table>
	<!-- ++++++++++++++ //상단 ++++++++++++++ -->

	<!-- ++++++++++++++ 본문 ++++++++++++++ -->
	<div id="print_frame">
		<h2>견 적 서</h2>

		<!-- -->
		<ul class="estmate_top">
			<li class="left_area">
				<div class="area">
					<p class="customer"><span id="apply_name"><?php if($TPL_VAR["user_name"]){?><?php echo $TPL_VAR["user_name"]?><?php }else{?>&nbsp;<?php }?></span><span class="earlow">귀하</span></p>
					<table class="table_1" cellpadding="0" cellspacing="0">
						<colgroup><col width="80" /><col /></colgroup>
						<tbody>
							<tr><th>견적번호</th><td><?php echo $TPL_VAR["estimate_num"]?></td></tr>
							<tr><th>견적일자</th><td><?php echo $TPL_VAR["estimate_date"]?></td></tr>
						</tbody>
					</table>
				</div>
			</li>
			<li class="right_area">
				<h3>사업자 정보</h3>
				<div class="area">
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
								<td rowspan="2" style="text-align:center;"><img src="<?php echo $TPL_VAR["signatureicon"]?>" /></td>
<?php }?>
							</tr>
							<tr><th>대표자명</th><td <?php if(!$TPL_VAR["signatureicon"]){?> colspan='2'<?php }?>><?php echo $TPL_VAR["ceo"]?></td></tr>
							<tr><th>주소</th><td colspan='2'><?php echo $TPL_VAR["companyAddress"]?></td></tr>
							<tr><th>전화번호</th><td colspan='2'><?php echo $TPL_VAR["companyPhone"]?></td></tr>
							<tr><th>홈페이지주소</th><td colspan='2'><?php if($TPL_VAR["domain"]){?><?php echo $TPL_VAR["domain"]?><?php }else{?>-<?php }?></td></tr>
						</tbody>
					</table>
				</div>
			</li>
		</ul>

		<p class="txt1">아래와 같이 견적합니다.</p>

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
<?php if($TPL_VAR["shipping_group_list"]){?>
<?php if($TPL_shipping_group_list_1){foreach($TPL_VAR["shipping_group_list"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<tr>
					<td>
<?php if($TPL_V2["tax"]=="exempt"){?>[비과세]<?php }?>
						<?php echo $TPL_V2["goods_name"]?>

<?php if($TPL_V2["option1"]!=null){?>
						<div class="goods_option">
<?php if($TPL_V2["title1"]){?><?php echo $TPL_V2["title1"]?>:<?php }?><?php echo $TPL_V2["option1"]?>

<?php if($TPL_V2["option2"]){?><?php if($TPL_V2["title2"]){?><?php echo $TPL_V2["title2"]?>:<?php }?><?php echo $TPL_V2["option2"]?> <?php }?>
<?php if($TPL_V2["option3"]){?><?php if($TPL_V2["title3"]){?><?php echo $TPL_V2["title3"]?>:<?php }?><?php echo $TPL_V2["option3"]?> <?php }?>
<?php if($TPL_V2["option4"]){?><?php if($TPL_V2["title4"]){?><?php echo $TPL_V2["title4"]?>:<?php }?><?php echo $TPL_V2["option4"]?> <?php }?>
<?php if($TPL_V2["option5"]){?><?php if($TPL_V2["title5"]){?><?php echo $TPL_V2["title5"]?>:<?php }?><?php echo $TPL_V2["option5"]?> <?php }?>
						</div>
<?php }?>
<?php if($TPL_V2["cart_inputs"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["cart_inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["input_value"]){?>
								<div class="goods_input">
<?php if($TPL_V3["type"]=='file'){?>
<?php if($TPL_V3["input_title"]){?><?php echo $TPL_V3["input_title"]?>:<?php }?>
<?php }else{?>
<?php if($TPL_V3["input_title"]){?><?php echo $TPL_V3["input_title"]?>:<?php }?><?php echo $TPL_V3["input_value"]?>

<?php }?>
								</div>
<?php }?>
<?php }}?>
<?php }?>
<?php if($TPL_VAR["cfg"]["order"]["fblike_ordertype"]&&$TPL_VAR["fblikesale"]){?>
						<div class="fblikelay" style="padding-top:10px">
							<?php echo snsLikeButton($TPL_V2["goods_seq"],'button_count')?>

						</div>
<?php }?>
					</td>
					<td style="text-align:center;">
						<div id="cart_option_ea_<?php echo $TPL_V2["cart_option_seq"]?>"><?php echo number_format($TPL_V2["ea"])?></div>
					</td>
					<td>
						<?php echo get_currency_price($TPL_V2["price"]*$TPL_V2["ea"], 2,'','<span class="cart_option_orgprice_'.$TPL_V2["cart_option_seq"].'">_str_price_</span>')?>

					</td>
<?php if($TPL_V2["shipping_provider_division"]){?>
					<td class="goods_delivery_info" rowspan="<?php echo $TPL_VAR["shipping_company_cnt"][$TPL_V2["shipping_group"]]?>">
<?php if(preg_match('/coupon/',$TPL_V2["shipping_group"])){?>
							<?php echo get_currency_price( 0, 2)?>

<?php }elseif(preg_match('/coupon/',$TPL_V2["shipping_group"])){?>
							<?php echo get_currency_price( 0, 2)?>

<?php }else{?>
<?php if($TPL_V1["grp_shipping_price"]> 0){?>
								<?php echo get_currency_price($TPL_V1["grp_shipping_price"], 2)?>

<?php }else{?>
								<?php echo get_currency_price( 0, 2)?>

<?php }?>
<?php }?>
					</td>
<?php }?>
					<td>
						<span class="cart_option_price_<?php echo $TPL_V2["cart_option_seq"]?>">
<?php if($TPL_VAR["code"]!='cart'){?>
						<?php echo get_currency_price($TPL_V2["tot_sale_price"], 2)?>

<?php }else{?>
						<?php echo get_currency_price($TPL_V2["sales"]["total_sale_price"], 2)?>

<?php }?>
						</span>
					</td>
				</tr>
<?php if(is_array($TPL_R3=$TPL_V2["cart_suboptions"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
				<tr class="bg1">
					<td>
<?php if($TPL_V3["suboption"]){?>
						<div style="padding-left:4px;">
							<img src="/data/skin/responsive_sports_sporti_gl/images/common/icon_sub2.png" alt="" style="vertical-align:middle; margin-top:-2px;" /> <?php if($TPL_V3["suboption_title"]){?><?php echo $TPL_V3["suboption_title"]?>:<?php }?><?php echo $TPL_V3["suboption"]?><br />
						</div>
<?php }?>
					</td>
					<td style="text-align:center;"><div><?php echo number_format($TPL_V3["ea"])?></div></td>
					<td><?php echo get_currency_price($TPL_V3["price"]*$TPL_V3["ea"], 2)?></td>
					<td>
						<?php echo get_currency_price($TPL_V3["sales"]["total_sale_price"], 2,'','<span id="cart_suboption_price_'.$TPL_V3["cart_suboption_seq"].'">_str_price_</span>')?>

					</td>
				</tr>
<?php }}?>
<?php }}?>
<?php }}?>
<?php }else{?>
				<tr>
					<td colspan="5" height="100">
<?php if($TPL_VAR["code"]=='cart'){?>
						장바구니에 담긴 상품이 없습니다.
<?php }elseif($TPL_VAR["code"]=='order'){?>
						주문 결제 할 상품이 없습니다.
<?php }?>
					</td>
				</tr>
<?php }?>
				<tr class="bg2">
					<td style="text-align:center;">합계</td>
					<td style="text-align:center;"><?php echo number_format($TPL_VAR["total_ea"])?></td>
					<td><?php echo get_currency_price($TPL_VAR["total"], 2)?></td>
					<td><?php echo get_currency_price($TPL_VAR["shipping_price"], 2)?></td>
					<td><?php echo get_currency_price($TPL_VAR["total_sale"], 2)?></td>
				</tr>
				<tr class="bg3">
					<td style="text-align:center;">결제금액</td>
					<td colspan="4"><?php echo get_currency_price($TPL_VAR["total_price"], 2)?></td>
				</tr>
<?php if($TPL_VAR["code"]!='cart'){?>
				<tr>
					<td colspan="4">사용마일리지/예치금</td>
					<td><?php echo get_currency_price($TPL_VAR["cash"]+$TPL_VAR["emoney"], 2)?></td>
				</tr>
<?php }?>
			</tbody>
		</table>
		
		<ul class="tot_cont">
			<li><span class="title">공급가액</span> : <span class="cont"><?php echo get_currency_price($TPL_VAR["provider_price"], 2)?></span></li>
			<li><span class="title">부가세액</span> : <span class="cont"><?php echo get_currency_price($TPL_VAR["tax_price"], 2)?></span></li>
			<li><span class="tot_price"><span class="title">합계</span> : <span class="cont"><?php echo get_currency_price($TPL_VAR["total_price"], 2)?></span></span></li>
		</ul>
	</div>


</body>
</html>


<script type="text/javascript">
/*
	var beforePrint = function() {
		document.getElementById('controll_frame').style.display = 'none';
		document.getElementById('print_frame').removeAttribute('class');
		document.getElementById('print_frame').setAttribute('class', 'ly-estimate');
		document.getElementById('print_frame').style.height = document.getElementById('print_frame').scrollHeight+'px';
	};
	var afterPrint = function() {
		document.getElementById('controll_frame').style.display = '';
		document.getElementById('print_frame').removeAttribute('class');
		document.getElementById('print_frame').style.height = '510px';
		document.getElementById('print_frame').setAttribute('class', 'ly-estimate print');
	};

	if (window.matchMedia) {
		var mediaQueryList = window.matchMedia('print');
		mediaQueryList.addListener(function(mql) {
			if (mql.matches) {
				beforePrint();
			} else {
				afterPrint();
			}
		});
	}
*/

	function applyName(){
		var apply_name = document.getElementById('estimate_name').value;

		if(apply_name == ''){
			alert("이름을 입력해 주세요.");
			return false;
		}

		document.getElementById('apply_name').innerHTML = apply_name;
	}

	function estimatePrint(){
		//window.onbeforeprint = beforePrint;
		//window.onafterprint = afterPrint;
		window.print();
	}
</script>