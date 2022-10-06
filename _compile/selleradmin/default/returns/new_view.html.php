<?php /* Template_ 2.2.6 2022/05/11 10:50:00 /www/music_brother_firstmall_kr/selleradmin/skin/default/returns/new_view.html 000031823 */ 
$TPL_data_return_item_1=empty($TPL_VAR["data_return_item"])||!is_array($TPL_VAR["data_return_item"])?0:count($TPL_VAR["data_return_item"]);
$TPL_process_log_1=empty($TPL_VAR["process_log"])||!is_array($TPL_VAR["process_log"])?0:count($TPL_VAR["process_log"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<style>
span.goods_name {display:inline-block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
.price {padding-right:5px;text-align:right}
div.left {float:left;padding-right:10px}
span.option {padding-right:10px;}
span.reason {display:inline-block;width:60px;}
div.status_complete_msg {padding:5px; line-height:13px;border:3px solid #333;display:none;}
select.status {border:3px solid #333; padding:5px;}
ul.addr li {float:left;}
ul.addr li input{width:93%;}
ul.return_shipping_area li {line-height:25px;}

table.goods_info tr td { border:0px !important; }
table.goods_info tr td  div{ padding-top:1px; }
.addr{line-height: 2.5;}
</style>
<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	// 별표 설정
	$("span.list-important").bind("click",function(){
		var param = "?no="+$(this).attr('id');
		if( $(this).hasClass('checked') ){
			$(this).removeClass('checked');
			param += "&val=0";
			$.get('important'+param,function(data) {});
		}else{
			$(this).addClass('checked');
			param += "&val=1";
			$.get('important'+param,function(data) {});
		}
	});

	$.get('../order/view?no=<?php echo $TPL_VAR["data_return"]["order_seq"]?>&pagemode=return_view&return_code=<?php echo $TPL_VAR["data_return"]["return_code"]?>', function(data) {
		$('#order_info').html(data);
	});

	$("input.return_adjust_input").bind('keyup change',function(){
		account_return_price();
	});

	// 우편번호 검색
    $("#senderZipcodeButton").live("click",function(){
<?php if($TPL_VAR["data_return"]["private_masking"]&&$TPL_VAR["data_return"]["status"]!='complete'){?>
        openDialogAlert("권한이 없습니다.",400,150,function(){});
<?php }else{?>
		openDialogZipcode('sender');
<?php }?>
    });

<?php if($TPL_VAR["data_return"]["status"]=='complete'||($TPL_VAR["npay_use"]&&$TPL_VAR["data_return"]["npay_order_id"])){?>
    $("input,select,textarea",$("form[name='return_form']")).each(function(){
		
    	if($(this).attr('name')!='admin_memo' && $(this).attr('name')!='return_code' && $(this).attr('type')!='submit' && $(this).attr('name')!='admin_memo' && $(this).attr('name')!='npay_use'){
<?php if($TPL_VAR["able_return_shipping_price"]){?>
				if($(this).attr('name')=='return_shipping_gubun') return;
				if($(this).attr('name')=='return_shipping_price') return;
<?php }?>
    		$(this).attr("disabled",true);
    	}
    });
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_return"]["npay_order_id"]){?> 
		$("input[name='status']").attr("disabled",false);
		$("input[name='npay_return_released']").attr("disabled",false);
		$("input[name='npay_return_hold']").attr("disabled",false);
		$(".stock_return_ea").attr("disabled",false);
		
<?php }?>
<?php }?>
	// 사은품 지급 조건 상세
	$(".gift_log").bind('click', function(){
		gift_use_log($(this).attr('order_seq'),$(this).attr('item_seq'));
	});

	// 반품배송비 책임 여부 수정 :: 2018-05-23 lwh
	$("input[name='refund_ship_duty']").on('change', function(){
		var refund_ship_duty = $("input[name='refund_ship_duty']:checked").val();
		if(refund_ship_duty == 'buyer'){
			$(".refund_ship_duty_controll_area").show();
		}else{
			$(".refund_ship_duty_controll_area").hide();
		}
		$("#refund_ship_type").change();
	});
	// 반품배송비 지불타입 수정 :: 2018-05-23 lwh
	$("#refund_ship_type").on('change', function(){
		var refund_ship_type = $(this).val();
		if(refund_ship_type == 'M'){
			$(".return_shipping_controll_area").hide();
		}else{
			$(".return_shipping_controll_area").show();
		}
	});
	$("input[name='refund_ship_duty']").change();

	// 개인정보 마스킹 처리 입력폼 비활성화
<?php if($TPL_VAR["data_return"]["private_masking"]&&$TPL_VAR["data_return"]["status"]!='complete'){?>
	$("input[name='cellphone[]']").attr("disabled",true);
	$("input[name='phone[]']").attr("disabled",true);
	$("input[name='senderZipcode[]']").attr("disabled",true);
	$("input[name='senderAddress_street']").attr("disabled",true);
	$("input[name='senderAddress']").attr("disabled",true);
	$("input[name='senderAddressDetail']").attr("disabled",true);
<?php }?>
});

// 사은품 지급 조건 상세 2015-05-14 pjm
function gift_use_log(order_seq,item_seq){
		$.ajax({
			type: "post",
			url: "../event/gift_use_log",
			data: "order_seq="+order_seq+"&item_seq="+item_seq,
			success: function(result){
				if	(result){
					$("#gift_use_lay").html(result);
					openDialog("사은품 이벤트 정보", "gift_use_lay", {"width":"450","height":"250"});
				}
			}
		});
}


</script>
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>

<?php if($TPL_VAR["data_return"]["important"]){?>
			<!--<span class="icon-star-gray hand checked list-important" id="important_<?php echo $TPL_VAR["data_return"]["return_seq"]?>"></span>&nbsp;&nbsp;-->
<?php }else{?>
			<!--<span class="icon-star-gray hand list-important" id="important_<?php echo $TPL_VAR["data_return"]["return_seq"]?>"></span>&nbsp;&nbsp;-->
<?php }?>
			<span><?php echo $TPL_VAR["data_return"]["return_code"]?></span>
			<span class="bold fx16 blue ml5" style="background-color:yellow"><?php echo $TPL_VAR["data_return"]["mstatus"]?></span>
			</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left btn_destory">
<!--  ######################## 16.12.16 gcs yjy : 검색조건 유지되도록-->
			<li><span class="btn large icon"><button type="button" onclick="location.href='catalog?<?php echo $TPL_VAR["query_string"]?>';" class="resp_btn v3 size_L"><span class="arrowleft"></span>반품리스트</button></span></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->


<!-- 주문정보 테이블 : 시작 -->
<div id="order_info"></div>


<!-- 주문 상세 내역 -->

<!--
	# $summaryModeClass
	# 주문리스트에서 보는 요약모드면 'summary-mode'
	# 주문상세화면에서 볼때에는 ''
-->
<div class="contents_dvs v2">
<div class="item-title">반품정보</div>
<form name="return_form" action="../returns_process/modify" method="post" target="actionFrame">
<input type="hidden" name="return_code" value="<?php echo $TPL_VAR["data_return"]["return_code"]?>" />
<input type="hidden" name="return_type" value="<?php echo $TPL_VAR["data_return"]["return_type"]?>" />
<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["data_return"]["order_seq"]?>" />
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_return"]["npay_order_id"]){?>
<input type="hidden" name="npay_use" value="<?php echo $TPL_VAR["npay_use"]?>" />
<?php }?>
<table class="order-view-table table_basic v10" width="100%" border=0>
	<colgroup>
		<col width="300" />
		<col />
		<col />
		<col />
		<col />
		<col />
		<col width="60" />
		<col width="60" />
	</colgroup>
	<thead class="oth">
		<tr>
			<th class="dark" rowspan="2">반품신청 상품</th>
			<th class="dark" rowspan="2">반품수량</th>
			<th class="dark" rowspan="2">'반품완료' 처리 시<br />재고 증가여부</th>
			<!-- <th class="dark" rowspan="2">반품회수</th> -->
			<th class="dark" rowspan="2">사유</th>
			<th class="dark" rowspan="2">반품접수 일시</th>
			<th class="dark" rowspan="2">반품완료 일시</th>
			<!-- <th class="dark" rowspan="2">처리자</th>	 -->
			<th class="dark" colspan="2">처리상태</th>
		</tr>
		<tr>
			<th class="dark">환불</th>
			<th class="dark">반품</th>
		</tr>
	</thead>
	<tbody class="otb">
<?php if($TPL_data_return_item_1){foreach($TPL_VAR["data_return_item"] as $TPL_V1){?>
		<tr class="order-item-row">
			<td class="info" nowrap>
				<table class="goods_info">
					<tr>
						<td>
						<a href='/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank'><span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V1["image"]?>" /></span></a>
						</td>
						<td>
<?php if($TPL_V1["npay_product_order_id"]){?><div class="ngray bold"><?php echo $TPL_V1["npay_product_order_id"]?> <span style="font-size:11px;font-weight:normal">(Npay상품주문번호)</span></div><?php }?>
<?php if($TPL_V1["goods_type"]=='gift'){?>
						<img src="/admin/skin/default/images/common/icon_gift.gif" align="absmiddle" />
<?php }?>
						<a href='../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank'><span class="goods_name" style="width:500px;"><?php echo $TPL_V1["goods_name"]?></span></a>

<?php if($TPL_V1["adult_goods"]=='Y'||$TPL_V1["option_international_shipping_status"]=='y'||$TPL_V1["cancel_type"]=='1'||$TPL_V1["tax"]=='exempt'){?>
							<div>
<?php if($TPL_V1["adult_goods"]=='Y'){?>
								<img src="/admin/skin/default/images/common/auth_img.png" alt="성인" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V1["option_international_shipping_status"]=='y'){?>
								<img src="/admin/skin/default/images/common/icon/plane_on.png" alt="해외배송상품" style="vertical-align: middle;" height="19" />
<?php }?>
<?php if($TPL_V1["cancel_type"]=='1'){?>
								<img src="/admin/skin/default/images/common/icon/nocancellation.gif" alt="청약철회" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V1["tax"]=='exempt'){?>
								<img src="/admin/skin/default/images/common/icon/taxfree.gif" alt="비과세" style="vertical-align: middle;"/>
<?php }?>
							</div>
<?php }?>

						<div class="desc">
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
						<div class="desc">
<?php if(is_array($TPL_R2=$TPL_V1["inputs"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<?php if($TPL_K2> 0){?><br /><?php }?>
							<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V2["title"]){?><?php echo $TPL_V2["title"]?>:<?php }?>
							<?php echo $TPL_V2["value"]?>

<?php }}?>
						</div>
<?php }?>
<?php if($TPL_V1["goods_kind"]=='coupon'){?>
						<div  class="desc">
<?php if($TPL_V1["coupon_serial"]){?><span class="order-item-coupon-serial" >티켓번호:<?php echo $TPL_V1["coupon_serial"]?></span><br/><?php }?>
<?php if($TPL_V1["refunditem"]["cancel_memo"]){?>
								<?php echo nl2br($TPL_V1["refunditem"]["cancel_memo"])?>

<?php }else{?>
<?php if($TPL_V1["goods_kind"]=='coupon'&&$TPL_V1["social_start_date"]&&$TPL_V1["social_end_date"]){?><span class="order-item-coupon-date" >유효기간:<?php echo $TPL_V1["social_start_date"]?>~<?php echo $TPL_V1["social_end_date"]?></span><br/><?php }?>
							<div class="goods-coupon-use-return">사용제한 : <?php echo $TPL_V1["couponinfo"]["coupon_use_return"]?></div>
							<div class="goods-coupon-cancel-day">취소 마감시간 : <?php echo $TPL_V1["couponinfo"]["socialcp_cancel_refund_day"]?></div>
<?php }?>
						</div>
<?php }?>
<?php if($TPL_V1["goods_type"]=="gift"){?>
<?php if($TPL_V1["gift_title"]){?><div><span class="fx11"><?php echo $TPL_V1["gift_title"]?></span> <span class="btn small gray"><button type="button" class="gift_log resp_btn v2" order_seq="<?php echo $TPL_VAR["data_return"]["order_seq"]?>" item_seq="<?php echo $TPL_V1["item_seq"]?>">자세히</button></span></div><?php }?>
<?php }?>

					</td>
				<tr>
				</table>
			</td>
			<td class="info center"><?php echo $TPL_V1["ea"]?></td>
			<td class="info center">
				<select name="stock_return_ea[<?php echo $TPL_V1["return_item_seq"]?>]" class="stock_return_ea" style="width:70%;">
<?php if(is_array($TPL_R2=$TPL_V1["eaLoop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<option value="<?php echo $TPL_V2?>" <?php if($TPL_V1["stock_return_ea"]==$TPL_V2){?>selected<?php }?>><?php echo $TPL_V2?></option>
<?php }}?>
				</select>
			</td>
			<!-- <td class="info center"><?php echo $TPL_V1["return_ea"]?></td> -->
			<td class="info center">
			<select name="reason[<?php echo $TPL_V1["return_item_seq"]?>]" <?php if($TPL_VAR["npay_use"]&&$TPL_V1["npay_product_order_id"]){?>disabled<?php }?>>
<?php if($TPL_VAR["npay_use"]&&$TPL_V1["npay_product_order_id"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["reasonLoop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<option value="<?php echo $TPL_V2["codecd"]?>" <?php if($TPL_V2["codecd"]==$TPL_V1["reason_code"]){?>selected<?php }?>><?php echo $TPL_V2["reason"]?></option>
<?php }}?>
<?php }else{?>
<?php if($TPL_V1["reasonLoop"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["reasonLoop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<option value="<?php echo $TPL_V2["codecd"]?>"><?php echo $TPL_V2["reason"]?></option>
<?php }}?>
<?php }else{?>
<?php if(is_array($TPL_R2=$TPL_V1["reasons"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["codecd"]!='110'){?>
				<option value="<?php echo $TPL_V2["codecd"]?>"><?php echo $TPL_V2["value"]?></option>
<?php }?>
<?php }}?>
<?php }?>
<?php }?>
			</select>
<?php if($TPL_V1["reasonLoop"]){?>
			<input type="hidden" name="reason_desc[<?php echo $TPL_V1["return_item_seq"]?>]" value="<?php echo $TPL_V1["reason_desc"]?>">
			<script>
				$.each($("select[name='reason[<?php echo $TPL_V1["return_item_seq"]?>]'] option"), function(){
					if($(this).text() == "<?php echo $TPL_V1["reason_desc"]?>"){
						$(this).attr("selected", true);
					}
				});
				$("select[name='reason[<?php echo $TPL_V1["return_item_seq"]?>]']").change(function(){
					var row = $(this).closest("tr");
					var reason_desc = row.find("select[name='reason[<?php echo $TPL_V1["return_item_seq"]?>]'] option:selected").text();
					row.find("input[name='reason_desc[<?php echo $TPL_V1["return_item_seq"]?>]']").val(reason_desc);
				});
			</script>
<?php }else{?>
			<script>$("select[name='reason[<?php echo $TPL_V1["return_item_seq"]?>]'] option[value='<?php echo $TPL_V1["reason_code"]?>']").attr('selected',true);</script>
<?php }?>
			</td>
			<td class="info center"><?php echo substr($TPL_VAR["data_return"]["regist_date"], 0, 10)?><br /><?php echo substr($TPL_VAR["data_return"]["regist_date"], 11, 8)?></td>
			<td class="info center"><?php echo substr($TPL_VAR["data_return"]["return_date"], 0, 10)?><br /><?php echo substr($TPL_VAR["data_return"]["return_date"], 11, 8)?></td>
			<!-- <td class="info center"><?php echo $TPL_VAR["data_return"]["mname"]?></td> -->
			<td class="info center"><?php echo $TPL_VAR["data_return"]["mrefund_status"]?></td>
			<td class="info center"><?php echo $TPL_VAR["data_return"]["mstatus"]?></td>
		</tr>
<?php }}?>
		<tr class="order-item-row">
			<th class="dark pd10" align="right" style="padding-right:5px;" >소계</th>
			<th class="dark" align="center"><strong><?php echo $TPL_VAR["tot"]["ea"]?> (<?php echo $TPL_VAR["tot"]["goods_cnt"]?>종)</strong></th>
			<th class="dark"></th>
			<!-- <th class="dark"><?php echo $TPL_VAR["tot"]["return_ea"]?></th> -->
			<th class="dark">
<?php if(!$TPL_VAR["data_return"]["npay_order_id"]){?>
			<span class="reason">변심:<?php echo number_format($TPL_VAR["tot"]["user_reason_cnt"])?></span>
			<span class="reason">오배송:<?php echo number_format($TPL_VAR["tot"]["shop_reason_cnt"])?></span>
			<span class="reason">하자:<?php echo number_format($TPL_VAR["tot"]["goods_reason_cnt"])?></span>
<?php }?>
			</th>
			<th class="dark" colspan="4">
<?php if($TPL_VAR["data_return"]["npay_flag_msg"]){?>
					<label><input type="checkbox" name="npay_return_released" value="y">
					<span class="red">Npay 반품 보류 해제 (사유: <?php echo $TPL_VAR["data_return"]["npay_flag_msg"]?>)</span></label>
					<input type="hidden" name="npay_return_hold" value="y">
<?php }?>
			</th>
		</tr>
	</tbody>
</table>

<div style="height:10px;"></div>

<table width="100%" class="info-table-style table_basic">
<col width="10%" /><col width="40%" /><col width="10%" /><col width="40%" />
<tr>
	<th class="its-th">휴대폰</th>
	<td class="its-td">
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_return"]["npay_order_id"]&&$TPL_VAR["data_return"]["cellphone"]){?>
		<span class="desc" style="letter-spacing:0px;"><?php echo $TPL_VAR["data_return"]["cellphone"]?></span>
<?php }else{?>
		<input type="text" name="cellphone[]" size="6" class="line" value="<?php echo $TPL_VAR["data_return"]["cellphone"][ 0]?>" />
		<input type="text" name="cellphone[]" size="6" class="line" value="<?php echo $TPL_VAR["data_return"]["cellphone"][ 1]?>" />
		<input type="text" name="cellphone[]" size="6" class="line" value="<?php echo $TPL_VAR["data_return"]["cellphone"][ 2]?>" />
<?php }?>
	</td>
	<th class="its-th">연락처</th>
	<td class="its-td">
<?php if($TPL_VAR["npay_use"]&&$TPL_VAR["data_return"]["npay_order_id"]&&$TPL_VAR["data_return"]["phone"]){?>
		<span class="desc" style="letter-spacing:0px;"><?php echo $TPL_VAR["data_return"]["phone"]?></span>
<?php }else{?>
		<input type="text" name="phone[]" size="6" class="line" value="<?php echo $TPL_VAR["data_return"]["phone"][ 0]?>" />
		<input type="text" name="phone[]" size="6" class="line" value="<?php echo $TPL_VAR["data_return"]["phone"][ 1]?>" />
		<input type="text" name="phone[]" size="6" class="line" value="<?php echo $TPL_VAR["data_return"]["phone"][ 2]?>" />
<?php }?>
	</td>
</tr>
<tr>
	<th class="its-th">회수방법</th>
	<td class="its-td">
		<label class="resp_radio"><input type="radio" name="return_method" value="user" /> 자가반품</label><br />
		<label class="resp_radio"><input type="radio" name="return_method" value="shop" /> 택배회수</label>
		<script>$("input[name='return_method'][value='<?php echo $TPL_VAR["data_return"]["return_method"]?>']").attr('checked',true);</script>
	</td>
	<th class="its-th">주소</th>
	<td class="its-td">

		<div>
		<input type="text" name="senderZipcode[]" value="<?php echo $TPL_VAR["data_return"]["sender_zipcode"][ 0]?><?php if($TPL_VAR["data_return"]["sender_zipcode"][ 1]){?>-<?php echo $TPL_VAR["data_return"]["sender_zipcode"][ 1]?><?php }?>" size="7" class="line" />
		<input type="hidden" name="senderAddress_type" value="<?php echo $TPL_VAR["data_return"]["sender_address_type"]?>">
		<span class="btn small"><input type="button" id="senderZipcodeButton" value="우편번호"  class="resp_btn v3"/></span>
		</div>

		<div>
			<ul class="addr">
			<li style="width:15%;">
			<span class="desc" <?php if($TPL_VAR["data_return"]["sender_address_type"]=="street"){?>style="font-weight:bold;"<?php }?>>(도로명)</span>
			</li>
			<li style="width:85%;">
			<input type="text" name="senderAddress_street" value="<?php echo $TPL_VAR["data_return"]["sender_address_street"]?>" class="line" /></li>
			<li style="width:15%;">
			<span class="desc" <?php if($TPL_VAR["data_return"]["sender_address_type"]!="street"){?>style="font-weight:bold;"<?php }?>>(지번)</span> </li>
			<li style="width:85%;">
			<input type="text" name="senderAddress" value="<?php echo $TPL_VAR["data_return"]["sender_address"]?>" class="line" /><br />
			<li style="width:15%;"><span class="desc">(공통상세)</span></li>
			<li style="width:85%;"><input type="text" name="senderAddressDetail" value="<?php echo $TPL_VAR["data_return"]["sender_address_detail"]?>" class="line" /></li>
			</ul>
		</div>
	</td>
</tr>
<tr>
	<th class="its-th">반품 상세 사유</th>
	<td class="its-td">
		<textarea class="wp95 line" rows="3" name="return_reason"><?php echo $TPL_VAR["data_return"]["return_reason"]?></textarea>
	</td>
	<th class="its-th">반품 관리 메모</th>
	<td class="its-td">
		<textarea class="wp95 line" rows="3" name="admin_memo"><?php echo $TPL_VAR["data_return"]["admin_memo"]?></textarea>
	</td>
</tr>
<tr>
	<th class="its-th">반품 배송비</th>
	<td class="its-td">
		<div class="left"></div>
		<div class="left">
		<span class="desc">
			<ul class="return_shipping_area">
<?php if(serviceLimit('H_AD')){?>
				<li>
					반품 상품 회수로 인하여 발생될 배송비 : 
					&nbsp;
					<label class="resp_radio"><input type="radio" name="refund_ship_duty" value="buyer" <?php if($TPL_VAR["data_return"]["refund_ship_duty"]=='buyer'){?>checked<?php }?>/> 구매자 부담</label>
					&nbsp;&nbsp;&nbsp;
					<label class="resp_radio"><input type="radio" name="refund_ship_duty" value="seller" <?php if($TPL_VAR["data_return"]["refund_ship_duty"]=='seller'){?>checked<?php }?>/> 판매자 부담</label>
				</li>
				<li class="refund_ship_duty_controll_area hide">
					<select name="refund_ship_type" id="refund_ship_type" class="line" style="height:20px;">
						<option value="M" <?php if($TPL_VAR["data_return"]["refund_ship_type"]=='M'){?>selected<?php }?>>환불금액에서 차감</option>
						<option value="A" <?php if($TPL_VAR["data_return"]["refund_ship_type"]=='A'){?>selected<?php }?>>직접 송금</option>
						<option value="D" <?php if($TPL_VAR["data_return"]["refund_ship_type"]=='D'){?>selected<?php }?>>택배상자 동봉</option>
					</select>
				</li>
				<li class="refund_ship_duty_controll_area hide">
					<span class="return_shipping_controll_area hide">
						<label class="resp_radio"><input type="radio" name="return_shipping_gubun" value="company" <?php if($TPL_VAR["data_return"]["return_shipping_gubun"]!='provider'){?> checked <?php }?>> 통신판매중계자가 반품 배송비를 받음</label>
						<br />
					</span>
					<span class="return_shipping_controll_area hide">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color:red;">반품 배송비
					<input type="text" name="return_shipping_price" value="<?php echo $TPL_VAR["data_return"]["return_shipping_price"]?>" size="10" class="line number onlyfloat" />
					<?php echo $TPL_VAR["basic_currency"]?><span class="return_shipping_controll_area hide">&nbsp;&nbsp;(수수료 제외한 금액을 배송주체에게 정산함)</span></span>
				</li>
<?php if($TPL_VAR["providerInfo"]["provider_seq"]> 1){?>
				<li class="refund_ship_duty_controll_area hide">
					<span class="return_shipping_controll_area hide">
						<label class="resp_radio"><input type="radio" name="return_shipping_gubun" value="provider" <?php if($TPL_VAR["data_return"]["return_shipping_gubun"]=='provider'){?> checked <?php }?>> <?php echo $TPL_VAR["providerInfo"]["provider_name"]?>(<?php echo $TPL_VAR["providerInfo"]["provider_id"]?>)가 반품 배송비를 받음</label><br />
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray">입점사가 반품 배송비를 받았기 때문에 당연히 정산에 반영되지 않습니다.</span>
					</span>
				</li>
<?php }?>
<?php }else{?>
				<li>
					반품 상품 회수로 인하여 발생될 배송비 : 
					&nbsp;
					<label><input type="radio" name="refund_ship_duty" value="buyer" <?php if($TPL_VAR["data_return"]["refund_ship_duty"]=='buyer'){?>checked<?php }?>/> 구매자 부담</label>
					&nbsp;&nbsp;&nbsp;
					<label><input type="radio" name="refund_ship_duty" value="seller" <?php if($TPL_VAR["data_return"]["refund_ship_duty"]=='seller'){?>checked<?php }?>/> 판매자 부담</label>
				</li>
				<li class="refund_ship_duty_controll_area hide">
					<select name="refund_ship_type" id="refund_ship_type" class="line" style="height:20px;">
						<option value="M" <?php if($TPL_VAR["data_return"]["refund_ship_type"]=='M'){?>selected<?php }?>>환불금액에서 차감</option>
						<option value="A" <?php if($TPL_VAR["data_return"]["refund_ship_type"]=='A'){?>selected<?php }?>>직접 송금</option>
						<option value="D" <?php if($TPL_VAR["data_return"]["refund_ship_type"]=='D'){?>selected<?php }?>>택배상자 동봉</option>
					</select>
				</li>
				<li class="refund_ship_duty_controll_area hide">
					<input type="radio" class="hide" name="return_shipping_gubun" value="company" checked>
					<span style="color:red;">반품 배송비
					<input type="text" name="return_shipping_price" value="<?php echo $TPL_VAR["data_return"]["return_shipping_price"]?>" size="10" class="line number onlyfloat" />
					<?php echo $TPL_VAR["basic_currency"]?>

				</li>
<?php }?>
			</ul>
		</span>
		</div>
	</td>
	<th class="its-th">반품 배송비<br />입금 계좌</th>
	<td class="its-td">
<?php if($TPL_VAR["data_return"]["shipping_price_bank_account"]){?><?php echo $TPL_VAR["data_return"]["shipping_price_bank_account"]?><?php }?><br />
<?php if($TPL_VAR["data_return"]["shipping_price_depositor"]){?>
		입금자명 : <?php echo $TPL_VAR["data_return"]["shipping_price_depositor"]?>

<?php }?>
	</td>
</tr>
<tr>
	<th class="its-th-align">처리내역로그</th>
	<td class="its-td" colspan="3">
		<textarea  class="wp95 line" rows="3" readOnly="readOnly"><?php if($TPL_process_log_1){foreach($TPL_VAR["process_log"] as $TPL_V1){?>[<?php echo $TPL_V1["regist_date"]?>] [<?php echo $TPL_V1["actor"]?>] <?php if($TPL_V1["add_info"]=="npay"){?>[네이버페이]<?php }?> <?php echo $TPL_V1["title"]?><?php echo chr( 10)?><?php }}?></textarea>
	</td>
</tr>

</table>

<div style="height:10px;"></div>


<?php if($TPL_VAR["data_order"]["pg"]=="npay"&&$TPL_VAR["npay_use"]){?>

	<div style="text-align:Center;padding:20px;">
	<input type="hidden" name="status" value="complete" />
<?php if($TPL_VAR["data_return"]["return_type"]=="return"){?>
<?php if($TPL_VAR["data_return"]["npay_flag"]=="RequestReturn"&&!$TPL_VAR["data_return"]["npay_flag_msg"]){?>
		네이버 페이 반품 처리한 주문입니다. 네이버 페이에서 반품완료시 자동 처리완료 됩니다.</div>
<?php }elseif($TPL_VAR["data_return"]["status"]=="request"&&($TPL_VAR["data_return"]["npay_flag"]=="return_request"||$TPL_VAR["data_return"]["npay_flag_msg"])){?>
		<div style="line-height:30px;">네이버 페이에서 반품요청된 건입니다. </div>
		<span class="btn large black"><input type="submit" value="반품요청승인" /></span>
<?php }else{?>
		<div style="line-height:30px;">네이버 페이 반품요청 승인 처리한 주문입니다. 네이버 페이에서 반품완료시 자동 처리완료 됩니다.</div>
<?php }?>
<?php }elseif($TPL_VAR["data_return"]["return_type"]=="exchange"){?>
<?php if($TPL_VAR["data_return"]["status"]=="request"&&($TPL_VAR["data_return"]["npay_flag"]=="exchange_request"||$TPL_VAR["data_return"]["npay_flag_msg"])){?>
		<div style="line-height:30px;">네이버 페이에서 교환요청된 건입니다. </div>
		<span class="btn large black"><input type="submit" value="교환수거완료" /></span>
<?php }elseif($TPL_VAR["data_return"]["npay_flag"]=="ApproveCollectedExchange"){?>
		<div style="line-height:30px;">네이버 페이 교환수거완료 처리한 주문입니다. 네이버 페이에서 재배송 시 처리완료 됩니다.</div>
<?php }else{?>
		<div style="line-height:30px;">네이버 페이 교환수거완료 처리한 주문입니다. 네이버 페이에서 재배송 시 처리완료 처리완료 됩니다.</div>
<?php }?>
<?php }?>
	</div>

<?php }elseif($TPL_VAR["data_order"]["pg"]=="talkbuy"){?>

<div style="text-align:Center;padding:20px;">
	<input type="hidden" name="status" value="complete" />
<?php if($TPL_VAR["data_return"]["return_type"]=="return"){?>
<?php if($TPL_VAR["data_return"]["status"]=="request"){?>
		카카오페이 구매 파트너센터에서 처리한 주문입니다. 카카오페이 구매 파트너센터에서 반품완료시 자동 처리완료 됩니다.</div>
<?php }else{?>
		<div style="line-height:30px;">카카오페이 구매 반품요청 승인 처리한 주문입니다. 카카오페이 구매 파트너센터에서 반품완료시 자동 처리완료 됩니다.</div>
<?php }?>
<?php }elseif($TPL_VAR["data_return"]["return_type"]=="exchange"){?>
<?php if($TPL_VAR["data_return"]["status"]=="request"){?>
		<div style="line-height:30px;">카카오페이 구매 파트너센터 교환요청 건입니다. </div>
<?php }else{?>
		<div style="line-height:30px;">카카오페이 구매 파트너센터에서 교환완료 처리한 주문입니다.</div>
<?php }?>
<?php }?>
</div>

<?php }else{?>

<?php if($TPL_VAR["data_return"]["status"]=='complete'){?>
		<table align="center" style="margin:auto;">
		<tr>
			<td>
				<input type="hidden" name="status" value="complete" />
				<select disabled readonly>
				<option value="complete">반품 완료</option>
				</select>
			</td>
			<td width="10"></td>
			<td>
				해당 반품건의 처리가 완료된 상태입니다.
			</td>
			<td width="10"></td>
			<td><span class="btn large black"><input type="submit" value="확인" /></span></td>
		</tr>
		</table>
<?php }else{?>
		<table align="center" style="margin:auto;">
		<tr>
			<td>
				<select name="status" class="status" onchange="if(this.value=='complete'){$('.status_complete_msg').show();}else{$('.status_complete_msg').hide();}">
					<option value="request">반품 신청</option>
					<option value="ing">반품 처리중</option>
					<option value="complete">반품 완료</option>
				</select>
				<script>$("select[name='status']").val("<?php echo $TPL_VAR["data_return"]["status"]?>").change();</script>
			</td>
			<td width="6"></td>
			<td>
				<div class="status_complete_msg hide">반품완료는 반품상품을 회수 받은 후 상품의 이상유무를 확인한 후 처리하는 것을 권장합니다.<br />반품완료 처리를 하면 해당 반품상품의 재고가 <span class="red">재고 증가여부에 따라</span> 조정됩니다.
				</div>
			</td>
			<td width="6"></td>
			<td><span class="btn large black"><input type="submit" value="확인" /></span></td>
		</tr>
		</table>
<?php }?>
<?php }?>

</form>
</div>
<div id="gift_use_lay"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>