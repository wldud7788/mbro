<?php /* Template_ 2.2.6 2022/05/17 12:29:08 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/benefits.html 000015445 */  $this->include_("snsLikeButton","qrcode","showGoodsCoupons");
$TPL_nointerest_1=empty($TPL_VAR["nointerest"])||!is_array($TPL_VAR["nointerest"])?0:count($TPL_VAR["nointerest"]);
$TPL_popularity_1=empty($TPL_VAR["popularity"])||!is_array($TPL_VAR["popularity"])?0:count($TPL_VAR["popularity"]);
$TPL_gifloop_1=empty($TPL_VAR["gifloop"])||!is_array($TPL_VAR["gifloop"])?0:count($TPL_VAR["gifloop"]);?>
<style>
table.benefits-table {width:100%; border-collapse:collapse;}
table.benefits-table th {font-weight:bold;text-align:center;padding:8px 5px 8px 5px;}
table.benefits-table td {padding:8px 5px 8px 5px;}
</style>
<?php if($TPL_VAR["APP_USE"]=='f'){?>
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
FB.init({
appId : '<?php echo $TPL_VAR["APP_ID"]?>', //App ID
status : true, // check login status
cookie : true, // enable cookies to allow the server to access the session
xfbml : true, // parse XFBML,
oauth      : true,
version    : 'v<?php echo $TPL_VAR["APP_VER"]?>'
});
// Additional initialization code here
};
// Load the SDK Asynchronously
(function(d){
var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
if (d.getElementById(id)) {return;}
js = d.createElement('script'); js.id = id; js.async = true;
js.src = "//connect.facebook.net/ko_KR/sdk.js";
ref.parentNode.insertBefore(js, ref);
}(document));
$(document).ready(function() {

	/* 툴팁 */
	$(".helpicon, .help").each(function(){

		var options = {
			className: 'tip-darkgray',
			bgImageFrameSize: 8,
			alignTo: 'target',
			alignX: 'right',
			alignY: 'center',
			offsetX: 10,
			allowTipHover: false,
			slide: false,
			showTimeout : 0
		}

		if($(this).attr('options')){
			var customOptions = eval('('+$(this).attr('options')+')');
			for(var i in customOptions){
				options[i] = customOptions[i];
			}
		}

		$(this).poshytip(options);
	});

$(".fb-login-button").click(function(){
});


$("#socialcp_event_tmp").click(function(){
	if($(this).is(":checked")){
		var socialcpevent = 1;
	}else{
		var socialcpevent = 0;
	}
	$("input[name='socialcp_event']",window.parent.document).val(socialcpevent);
});


});
</script>
<?php }?>



<table style="width:100%;">
<col width="40%" /><col width="30%" />
<tr>
	<td>
		<div class="item-title">
		이 상품의 현재 혜택 현황 <span class="btn small cyanblue"><button type="button" id="goods_benefits_btn">추가혜택 통합설정<span class="arrowright"></span></button></span>
		</div>
	</td>
	<td>
		<div class="item-title">
		이 상품의 인기지수
		</div>
	</td>
	<td>
		<div class="item-title">
		이 상품의 QR코드
		</div>
	</td>
</tr>
</table>

<table style="width:100%; border-bottom:1px solid #dadada;; border-top:1px solid #aaa;" cellspacing="0">
<col width="40%" /><col width="30%" />
<tr>
	<td>
<?php if($TPL_VAR["goods_seq"]){?>
		<table class="benefits-table" style="width:100%">
		<colgroup>
			<col width="18%" />
			<col />
		</colgroup>
		<tbody>
		<tr>
			<th>판매가</th>
			<td><?php echo number_format($TPL_VAR["consumer_price"])?> → <strong><?php echo number_format($TPL_VAR["price"])?></strong>원(<?php echo $TPL_VAR["price_rate"]?>%↓)</td>
		</tr>
<?php if($TPL_VAR["event"]["event_sale"]||$TPL_VAR["event"]["event_reserve"]){?>
		<tr>
			<th><strong>이벤트</strong></th>
			<td>

				<div>
				<?php echo $TPL_VAR["event"]["title"]?>

				(
				<?php echo substr($TPL_VAR["event"]["start_date"], 5)?>~<?php echo substr($TPL_VAR["event"]["end_date"], 5)?>

<?php if($TPL_VAR["event"]["event_sale"]){?>
				<?php echo $TPL_VAR["event"]["event_sale"]?>%추가할인
<?php }?>
<?php if($TPL_VAR["event"]["event_reserve"]){?>
				<?php echo $TPL_VAR["event"]["event_reserve"]?>%추가적립
<?php }?>
				)
				<a href="../event/regist?event_seq=<?php echo $TPL_VAR["event"]["event_seq"]?>" target="_blank"><span class="desc">자세히▶</span></a>
				</div>
<?php if($TPL_VAR["event"]["event_sale_unit"]> 0){?>
				<div style="padding-top:5px;"><?php echo number_format($TPL_VAR["price"])?>원  → <strong><?php echo number_format($TPL_VAR["price"]-$TPL_VAR["event"]["event_sale_unit"])?></strong>원</div>
<?php }?>
			</td>
		</tr>
<?php }?>
<?php if($TPL_VAR["reserve"]){?>
		<tr class='hide'>
			<th>마일리지</th>
<?php if($TPL_VAR["reserve_unit"]=='percent'){?>
			<td><?php echo $TPL_VAR["reserve_rate"]?>% 적립</td>
<?php }else{?>
			<td><?php echo number_format($TPL_VAR["reserve"])?>원 적립</td>
<?php }?>
		</tr>
<?php }?>
		<tr>
			<th>회원등급</th>
			<td>
			<?php echo $TPL_VAR["member_group"]["group_name"]?>

<?php if($TPL_VAR["member_group"]["sale_rate"]){?>
			<?php echo $TPL_VAR["member_group"]["sale_rate"]?>% 추가할인
<?php }elseif($TPL_VAR["member_group"]["sale"]){?>
			<?php echo number_format($TPL_VAR["member_group"]["sale"])?>원 추가할인
<?php }?>
<?php if($TPL_VAR["member_group"]["reserve_rate"]){?>
			<?php echo $TPL_VAR["member_group"]["reserve_rate"]?>% 추가적립
<?php }elseif($TPL_VAR["member_group"]["reserve"]){?>
			<?php echo number_format($TPL_VAR["member_group"]["reserve"])?>원 추가적립
<?php }?>
			</td>
		</tr>
<?php if($TPL_VAR["systemmobiles"]&&($TPL_VAR["systemmobiles"]["sale_price"]||$TPL_VAR["systemmobiles"]["sale_emoney"])){?>
		<tr>
			<th>모바일</th>
			<td>
			모바일에서 구매시
<?php if($TPL_VAR["systemmobiles"]["sale_price"]){?>
			<?php echo $TPL_VAR["systemmobiles"]["sale_price"]?>% 추가할인
<?php }?>
<?php if($TPL_VAR["systemmobiles"]["sale_emoney"]){?>
			<?php echo $TPL_VAR["systemmobiles"]["sale_emoney"]?>%추가적립
<?php }?>
			</td>
		</tr>
<?php }?>
<?php if($TPL_VAR["max_coupon"]){?>
		<tr>
			<th>할인쿠폰</th>
			<td>
			바로 할인받는 쿠폰
<?php if($TPL_VAR["max_coupon"]["sale_type"]=='percent'){?>
			<?php echo $TPL_VAR["max_coupon"]["percent_goods_sale"]?>%
<?php }else{?>
			<?php echo number_format($TPL_VAR["max_coupon"]["won_goods_sale"])?>원
<?php }?>
			</td>
		</tr>
<?php }?>
		<!--
		<tr>
			<th>구매후기</th>
			<td>구매후기 작성시 250원 추가적립</td>
		</tr>
		-->
<?php if($TPL_VAR["nointerest"]){?>
		<tr>
			<th>무이자할부</th>
			<td>
<?php if($TPL_nointerest_1){foreach($TPL_VAR["nointerest"] as $TPL_V1){?>
			<?php echo $TPL_V1?>개월
<?php }}?>
			<a href="../setting/pg" target="_blank"><span class="desc">자세히▶</span></a></td>
		</tr>
<?php }?>
		<tr>
			<th>배송</th>
			<td>
<?php if($TPL_VAR["delivery"]["type"]=='delivery'){?>택배<?php }?>
<?php if($TPL_VAR["delivery"]["type"]=='quick'){?>퀵서비스<?php }?>
<?php if($TPL_VAR["delivery"]["type"]=='direct'){?>직접배송<?php }?>
<?php if($TPL_VAR["delivery"]["type"]=='delivery'){?>
<?php if($TPL_VAR["delivery"]["free"]> 0){?><?php echo number_format($TPL_VAR["delivery"]["free"])?>원 이상 구매 시 무료<?php }?>
<?php if($TPL_VAR["delivery"]["price"]> 0&&!$TPL_VAR["delivery"]["free"]){?><?php echo number_format($TPL_VAR["delivery"]["price"])?>원<?php }?>
<?php if($TPL_VAR["delivery"]["price"]== 0){?>무료<?php }?>
<?php }else{?>
<?php if($TPL_VAR["delivery"]["summary"]){?>(<?php echo $TPL_VAR["delivery"]["summary"]?>)<?php }?>
<?php }?>
			</td>
		</tr>
<?php if($TPL_VAR["systemfblikes"]&&($TPL_VAR["systemfblikes"]["sale_price"]||$TPL_VAR["systemfblikes"]["sale_emoney"])){?>
		<tr>
			<th><?php echo snsLikeButton($TPL_VAR["goods_seq"], 0)?></th>
			<td>
<?php if($TPL_VAR["systemfblikes"]["sale_price"]){?>
			<?php echo $TPL_VAR["systemfblikes"]["sale_price"]?>% 추가할인
<?php }?>
<?php if($TPL_VAR["systemfblikes"]["sale_emoney"]){?>
			<?php echo $TPL_VAR["systemfblikes"]["sale_emoney"]?>%추가적립
<?php }?>
			</td>
		</tr>
<?php }?>
		</tbody>
		</table>
<?php }else{?>
		<div class="pdl10"><div class="pd10 desc">상품 등록 후 자동으로 '혜택'을 분석합니다.</div></div>
<?php }?>
	</td>
	<td class="pdl10" valign="top"style="border-left:1px solid #dadada">
<?php if($TPL_VAR["goods_seq"]){?>
		<table class="benefits-table" style="width:100%">
<?php if($TPL_popularity_1){foreach($TPL_VAR["popularity"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["desc"]?></td>
			<td><a href="<?php echo $TPL_V1["link"]?>" target="_blank"><span class="blue bold">총 <?php echo number_format($TPL_V1["value"])?><?php echo $TPL_V1["postfix"]?></span></a></td>
		</tr>
<?php }}?>
		</table>
<?php }else{?>
		<div class="pd10 desc">상품 등록 후 자동으로 '인기지수'를 분석합니다.</div>
<?php }?>
	</td>
	<td class="pdl10" style="border-left:1px solid #dadada">
<?php if($TPL_VAR["goods_seq"]){?>
		<div class="pdl20">
			<?php echo qrcode("goods",$TPL_VAR["goods_seq"], 4)?>

			<a href="javascript:;" class="qrcodeGuideBtn fx11 lsp-1" key="goods" value="<?php echo $TPL_VAR["goods_seq"]?>">자세히▶</a>
		</div>
<?php }else{?>
		<div class="pd10 desc">상품 등록 후 자동으로 'QR코드'를 생성합니다.</div>
<?php }?>
	</td>
</tr>
</table>

<!-- <div>
	<div style="float:left;width:50%">
		<div class="item-title">
			진행 중인 이 상품의 단독 이벤트
			<span class="helpicon" title="이벤트 차(횟)수 관리가 가능한 이벤트로 특정 기간에 할인/적립 혜택을 진행할 수 있습니다."></span>
			<span class="btn small cyanblue"><button type="button" id="">등록</button></span>
		</div>
		<div class="fl pdl10" style="margin-left:5px;">
			<span class="desc"><label><input type="checkbox" id="socialcp_event_tmp" value="1"  <?php if($TPL_VAR["goodsbenefits"]["socialcp_event"]== 1){?> checked="checked" <?php }?> > 본 상품은 아래 단독이벤트 기간에만 판매합니다.</label></span>
		</div>
		<table class="info-table-style" style="width:100%" >
		<colgroup>
			<col width="50px" />
			<col width="50px" />
			<col />
			<col />
			<col width="80px" />
			<col width="80px" />
		</colgroup>
		<thead>
		<tr>
			<th class="its-th-align center" rowspan="2" >차(횟)수</th>
			<th class="its-th-align center" rowspan="2" >할인</th>
			<th class="its-th-align center" rowspan="2" >이벤트명</th>
			<th class="its-th-align center" rowspan="2" >이벤트 기간</th>
			<th class="its-th-align center" colspan="2" >달성 성과</th>
		</tr>
		<tr>
			<th class="its-th-align center" rowspan="2" >갯수/주문</th>
			<th class="its-th-align center" rowspan="2" >매출</th>
		</tr>
		</thead>
		<tbody class="ltb otb" >
<?php if($TPL_VAR["gifloop"]){?>
<?php if($TPL_gifloop_1){foreach($TPL_VAR["gifloop"] as $TPL_V1){?>
<?php }}?>
<?php }else{?>
		<tr>
			<td class="its-td-align center" colspan="6">
<?php if($TPL_VAR["goods_seq"]){?>
			<div class="pd10 desc">진행중인 단독 이벤트가 없습니다. .</div>
<?php }else{?>
			<div class="pd10 desc">상품 등록 후 단독 이벤트를 등록해 주세요.</div>
<?php }?>
			</td>
		</tr>
<?php }?>
		</tbody>
		</table>
	</div>

	<div style="float:left;width:50%">
		<div class="item-title" >
			진행 중인 이 상품의 사은품 이벤트
			<a href="/sellaradmin/event/gift_catalog" target="_blank"><span class="fr desc"> 리스트 바로가기 ></span></a>
		</div>
		<br/>
		<table class="info-table-style" style="width:100%" >
		<colgroup>
			<col width="20%" />
			<col />
		</colgroup>
		<thead>
		<tr>
			<th class="its-th-align center" >종료</th>
			<th class="its-th-align center" >사은품 이벤트명</th>
			<th class="its-th-align center" >사은품 이벤트기간</th>
		</tr>
		</thead>
		<tbody class="ltb otb" >
<?php if($TPL_VAR["gifloop"]){?>
<?php if($TPL_gifloop_1){foreach($TPL_VAR["gifloop"] as $TPL_V1){?>
			<tr>
				<td class="its-td-align center" ><?php if($TPL_V1["gift_gb"]=='order'){?>구매조건 사은품<?php }else{?>교환조건 사은품<?php }?></td>
				<td class="its-td-align center" ><?php echo $TPL_V1["title"]?></td>
				<td class="its-td-align center" ><?php echo $TPL_V1["start_date"]?>~<?php echo $TPL_V1["end_date"]?></td>
			</tr>
<?php }}?>
<?php }else{?>
		<tr>
			<td class="its-td-align center" colspan="3" height="50px">
<?php if($TPL_VAR["goods_seq"]){?>
			<div class="pd10 desc">진행중인 사은품 이벤트가 없습니다.</div>
<?php }else{?>
			<div class="pd10 desc">상품 등록 후 사은품을 등록해 주세요.</div>
<?php }?>
			</td>
		</tr>
<?php }?>
		</tbody>
		</table>
	</div>

	<div class="clearbox"></div>

	<div style="float:left;width:50%">
		<div class="item-title">다운로드 가능한 이 상품의 상품쿠폰</div>
		<table class="info-table-style" style="width:100%" >
		<colgroup>
			<col />
			<col width="20%" />
			<col width="20%" />
			<col width="20%" />
		</colgroup>
		<thead>
		<tr>
			<th class="its-th-align center" >쿠폰명 / 할인액(율) / 종류</th>
			<th class="its-th-align center" >사용 제한금액</th>
			<th class="its-th-align center" >다운로드 기간</th>
			<th class="its-th-align center" >유효기간</th>
		</tr>
		</thead>
		<tbody class="ltb otb" >
<?php if(is_array($TPL_R1=showGoodsCoupons($TPL_VAR["goods_seq"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<tr>
				<td class="its-td-align left" >
				<div class="bold"><?php echo $TPL_V1["coupon_name"]?></div>
				<div ><?php echo $TPL_V1["salepricetitle"]?></div>
				<div ><?php echo $TPL_V1["issuebtn"]?></div></td>
				<td class="its-td-align right" ><?php echo $TPL_V1["limit_goods_price"]?>원 이상 구매 시</td>
				<td class="its-td-align center" ><?php echo $TPL_V1["downloaddate"]?></td>
				<td class="its-td-align center" ><?php echo $TPL_V1["issuedate"]?></td>
			</tr>
<?php }}else{?>
		<tr>
			<td class="its-td-align center" colspan="4">
<?php if($TPL_VAR["goods_seq"]){?>
			<div class="pd10 desc">다운가능한 쿠폰이 없습니다.</div>
<?php }else{?>
			<div class="pd10 desc">상품 등록 후 쿠폰을 등록해 주세요.</div>
<?php }?>
			</td>
		</tr>
<?php }?>
		</tbody>
		</table>
	</div>

	<div style="float:left;width:50%">
		<div class="item-title">이 상품을 구매하면 배송비가 무료인가?</div>

	<table style="width:100%; border-bottom:1px solid #dadada;; border-top:1px solid #aaa;" cellspacing="0">
	<col width="40%" /><col width="30%" />
	<tr>
		<td><div class="pd10 desc">
<?php if($TPL_VAR["socialcpuse"]){?>
					아닙니다. 이 상품은 배송이 필요 없는 쿠폰 발송 상품입니다.
<?php }else{?>
<?php if($TPL_VAR["goodsbenefits"]["goods_shipping_policy"]){?>
						아닙니다. 이 상품은 개별 배송비 정책 상품입니다.
<?php }else{?>
<?php if($TPL_VAR["deliveryCostPolicy"]=='ifpay'){?>
							아닙니다. 이 상품은 구매금액 조건의 기본 배송비 정책 상품입니다.
<?php }elseif($TPL_VAR["deliveryCostPolicy"]=='free'){?>
							맞습니다. 이 상품을 구매하면 배송비가 무료입니다.<br/>
							단, 개별 배송비 상품 또는 지역별 추가 배송비는 부과됩니다.
<?php }?>
<?php }?>
<?php }?>
				</div>
			</td>
		</tr>
		</table>
	</div>

</div> -->