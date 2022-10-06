<?php /* Template_ 2.2.6 2022/05/17 12:31:47 /www/music_brother_firstmall_kr/admin/skin/default/export/view.html 000042614 */ 
$TPL_data_export_item_1=empty($TPL_VAR["data_export_item"])||!is_array($TPL_VAR["data_export_item"])?0:count($TPL_VAR["data_export_item"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layer_stock.css" />
<style>
	span.goods_name1 {display:inline-block;white-space:nowrap;overflow:hidden;width:250px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	span.goods_name2 {display:inline-block;white-space:nowrap;overflow:hidden;width:500px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	div.left {float:left;padding-right:10px}
	span.option {padding-right:10px;color:#666;}
	.price {padding-right:5px;text-align:right}
	.ea {font-family:dotum; color:#a400ff;}
	.coupon_status{color:red}
	.coupon_status_all{color:red}
	.coupon_order_status{color:gray}
	.coupon_status_use{color:blue}
	.coupon_input_value{color:green}
	.warehouse-info-lay { padding:5px;margin:2px 10px 5px 0;border:1px solid #c5c5c5;background-color:#fff; }
</style>
<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-orderExportPopup.js?dummy=<?php echo date('YmdHis')?>"></script>
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

		get_order_list();

		// 출고완료
		$("#complete_export").bind("click",function(){
			batch_change_status('45');
		});

		// 배송중
		$("#going_delivery").bind("click",function(){
			batch_change_status('55');
		});

		// 배송완료
		$("#complete_delivery").bind("click",function(){
			batch_change_status('65');
		});

		// 정보수정
		$("#export_modify").bind("click",function(){
			var f = $("form#exportForm");
			f.attr('action','../export_process/export_modify');
			f[0].submit();
			if(f[0].export_code.value.match(/^B/) == 'B') {
				$('.delivery_number').val($('.delivery_number').eq(0).val());
				$('.delivery_company').val($('.delivery_company').eq(0).val());
			}
		});

		// 출고상태 되돌리기
		$("li.reverse_export").bind("click",function(){
<?php if($TPL_VAR["data_export"]["status"]=='45'){?>
			var msg = '출고 준비된 상품을 정말 \'상품준비\'로 되돌리시겠습니까?';
<?php }elseif($TPL_VAR["data_export"]["status"]=='55'){?>
			var msg = '출고 완료된 상품을 정말 \'출고준비\'로 되돌리시겠습니까?<br/>출고완료 시 차감된 재고 수량은 환원됩니다.';
<?php }elseif($TPL_VAR["data_export"]["status"]=='65'){?>
			var msg = '배송 중인  상품을 정말 \'출고완료\'로 되돌리시겠습니까?';
<?php }elseif($TPL_VAR["data_export"]["status"]=='75'){?>
			var msg = '배송 완료된  상품을 정말 \'배송중\'으로 되돌리시겠습니까?<br/>지급된 캐시는 다시 회수 됩니다.';
<?php }?>
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'||$TPL_VAR["data_export"]["status"]!='55'){?>
			openDialogConfirm(msg,400,150,function(){
				var f = document.exportForm;
				f.action = "../export_process/reverse_export";
				f.submit();
			},function(){});
<?php }?>
		});

		// 이미지로 알려드립니다!
		$("#export_guide").bind("click",function(){
			openDialog("이미지로 알려드립니다!", "export_guide_dialog", {width:1000,height:750});
		});


		// 구매확정
		$("button.buy_confirm").bind("click",function(){
			openDialogConfirm('구매확정을 하시겠습니까?',400,150,function(){
				var f = document.exportForm;
				f.action = "../export_process/buy_confirm";
				f.submit();
			},function(){});
		});

		// 구매확정로그 2015-04-06 pjm
		$("button.buy_confirm_log").bind("click",function(){

			var export_seq		= $(this).attr("export_seq");
			$.get('../export_process/buy_confirm_log?export_seq='+export_seq, function(data) {
				$("div#export_buyconfirm_log").html(data);
				openDialog("구매확정 처리로그", "export_buyconfirm_log", {width:550,height:300});
			});

		});

		// 사은품 지급 조건 상세
		$(".gift_log").bind('click', function(){
			$.ajax({
				type: "post",
				url: "../event/gift_use_log",
				data: "order_seq="+$(this).attr('order_seq')+"&item_seq="+$(this).attr('item_seq'),
				success: function(result){
					if	(result){
						$("#gift_use_lay").html(result);
						openDialog("사은품 이벤트 정보", "gift_use_lay", {"width":"450","height":"250"});
					}
				}
			});
		});

	});

	function excoupon_use_btn(obj){
		var btnobj = $(obj);
		$.ajax({
			type: "post",
			url: "../export/coupon_use",
			data: "order_seq="+btnobj.attr('order_seq'),
			success: function(result){
				if	(result){
					$("#coupon_use_lay").html(result);
					openDialog("티켓사용 확인 / 티켓번호 재발송 <span class='desc'></span>", "coupon_use_lay", {"width":"1000","height":"700"});
				}
			}
		});
	}

	//할인내역 열기 닫기
	function open_sale_contents(obj)
	{
		var btnobj = $(obj);
		var trobj = $(obj).closest('tr').next();
		var tdobj = $(obj).closest('td');
		var divobj = trobj.find("td").eq(tdobj.index()).find("div");
		if(divobj.hasClass('hide')){
			divobj.removeClass('hide');
			btnobj.attr('src','/admin/skin/default/images/common/btn_close.gif');
		}else{
			divobj.addClass('hide');
			btnobj.attr('src','/admin/skin/default/images/common/btn_open.gif');
		}
	}

	function batch_change_status(mode_status){
		var status = mode_status;
		var url = '../export/batch_status?mode=goods&step=25&search_type=export_code&keyword=<?php echo $TPL_VAR["data_export"]["export_code"]?>&start_search_date=<?php echo date('Y-m-d',strtotime("-7 day"))?>&end_search_date=<?php echo date('Y-m-d')?>&status='+status;
		var win = window.open(url,'export_popup','toolbar=no, scrollbars=yes, resizable=yes, width=1265, height=954');
	}


	var order_list	= <?php echo $TPL_VAR["order_list"]?>;
	function get_order_list(){
		var order_seq	= order_list.shift();
		var bundle_export = "<?php echo $TPL_VAR["data_export"]["is_bundle_export"]?>";
		if(typeof order_seq == 'undefined'){
			if ( bundle_export == "Y") {
				$('.delivery_number').not(':eq(0)').attr('disabled',true);
				$('.delivery_company').not(':eq(0)').attr('disabled',true);
			}
			return true;
		}

		$.get('../order/view?no=' + order_seq + '&pagemode=export_view&export_code=<?php echo $TPL_VAR["data_export"]["export_code"]?>', function(data) {
			$('#order_info').append(data);
			$('#order_info').append('<br/><hr/><br/><br/>');
			get_order_list()
		});
	}

</script>


<form name="exportForm" id="exportForm" method="post" target="actionFrame">
	<input type="hidden" name="export_code" value="<?php echo $TPL_VAR["data_export"]["export_code"]?>">
	<!-- 페이지 타이틀 바 : 시작 -->
	<div id="page-title-bar-area">
		<div id="page-title-bar">

			<!-- 타이틀 -->
			<div class="page-title">
				<h2>
<?php if($TPL_VAR["data_export"]["important"]){?>
					<span class="icon-star-gray hand checked list-important" id="important_<?php echo $TPL_VAR["data_export"]["export_seq"]?>"></span>&nbsp;&nbsp;
<?php }else{?>
					<span class="icon-star-gray hand list-important" id="important_<?php echo $TPL_VAR["data_export"]["export_seq"]?>"></span>&nbsp;&nbsp;
<?php }?>
<?php if($TPL_VAR["data_export"]["is_bundle_export"]=='Y'){?>
					<span class="bold red"/>[합포장(묶음배송)]</span>
<?php }?>
					<span class="bold fx16" style='background-color:yellow'><?php echo $TPL_VAR["data_export"]["export_code"]?></span>

<?php if($TPL_VAR["data_export"]["invoice_send_yn"]=='y'){?>
					<a href="javascript:printInvoiceView('<?php echo $TPL_VAR["data_export"]["order_seq"]?>','<?php echo $TPL_VAR["data_export"]["export_code"]?>')"><span class="icon-print-invoice"></span></a>
<?php }?>

					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="bold fx16 blue" style='background-color:yellow'><?php echo $TPL_VAR["data_export"]["mstatus"]?></span>

<?php if($TPL_VAR["cfg_order"]["buy_confirm_use"]){?>
<?php if($TPL_VAR["data_export"]["buy_confirm"]!='none'){?>
					<span class="desc" style="font-weight:normal;">
				<?php echo $TPL_VAR["tot"]["buyconfirm_ea"]?>개 구매확정
				( 최신:<?php echo substr($TPL_VAR["data_buy_confirm"]["regdate"], 0, 16)?>

<?php if($TPL_VAR["data_export"]["buy_confirm"]=='admin'){?>
				판매자
<?php }elseif($TPL_VAR["data_export"]["buy_confirm"]=='user'){?>
				구매자
<?php }elseif($TPL_VAR["data_export"]["buy_confirm"]=='system'){?>
				자동
<?php }?>
				/ 잔여구매확정수량 : <?php echo $TPL_VAR["tot"]["buyconfirm_remain"]?>개
				)
			</span>
<?php }?>
<?php if(!$TPL_VAR["orders"]["npay_order_id"]){?>
<?php if($TPL_VAR["data_export"]["buyconfirmInfo"]['btn_buyconfirm']){?>
					<span class="btn small red"><button  type="button" name="buy_confirm" class="buy_confirm">구매확정</button></span>
<?php }?>
<?php }?>
<?php if(!$TPL_VAR["coupon_cnt"]){?>
					<span class="btn small cyanblue"><button  type="button" class="buy_confirm_log" export_seq="<?php echo $TPL_VAR["data_export"]["export_seq"]?>">로그</button></span>
<?php }?>
<?php }?>

				</h2>
			</div>

			<!-- 좌측 버튼 -->
			<ul class="page-buttons-left">
				<!-- ######################## 16.12.16 gcs yjy : 검색조건 유지되도록 -->
				<li><span class="btn large icon"><button type="button" onclick="location.href='catalog?<?php echo $TPL_VAR["query_string"]?>';"><span class="arrowleft"></span>출고리스트</button></span></li>
				<li class="hand reverse_export">
					&nbsp;
<?php if($TPL_VAR["data_export"]["status"]=='45'&&!$TPL_VAR["coupon_cnt"]&&(!$TPL_VAR["npay_use"]||!$TPL_VAR["data_export"]["npay_order_id"])){?>
					<span class="helpicon" title="출고 준비된 상품을 상품준비로 되돌릴 수 있습니다."></span> '상품준비'로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_VAR["scm_cfg"]['use']!='Y'&&$TPL_VAR["data_export"]["status"]=='55'&&!$TPL_VAR["coupon_cnt"]&&(!$TPL_VAR["npay_use"]||!$TPL_VAR["data_export"]["npay_order_id"])){?>
					<span class="helpicon" title="출고 완료된 상품을 출고준비로 되돌릴 수 있습니다.<br/>이 때 출고완료 시 차감된 재고 수량이 환원됩니다."></span> '출고준비'로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_VAR["data_export"]["status"]=='65'&&!$TPL_VAR["coupon_cnt"]&&(!$TPL_VAR["npay_use"]||!$TPL_VAR["data_export"]["npay_order_id"])){?>
					<span class="helpicon" title="배송 중인 상품을 출고완료로 되돌릴 수 있습니다."></span> '출고완료'로 되돌리기 <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }?>
				</li>
			</ul>

			<!-- 우측 버튼 -->
			<ul class="page-buttons-right">
<?php if($TPL_VAR["data_export"]["tracking_url"]&&$TPL_VAR["data_export"]["shipping_method"]=='delivery'&&!$TPL_VAR["coupon_cnt"]){?>
				<li><span class="btn large cyanblue"><a href="<?php echo $TPL_VAR["data_export"]["tracking_url"]?>" target="_blank">배송추적</a></span></li>
<?php }?>
<?php if($TPL_VAR["data_export"]["status"]< 75&&$TPL_VAR["data_export"]["status"]>= 45){?>
<?php if(!$TPL_VAR["npay_use"]||!$TPL_VAR["data_export"]["npay_order_id"]||($TPL_VAR["npay_use"]&&$TPL_VAR["data_export"]["npay_order_id"]&&$TPL_VAR["data_export"]["status"]== 45)){?>
				<li><span class="btn large black"><button type='button' name="export_modify" id="export_modify">출고정보저장</button></span></li>
<?php }?>
<?php }?>
<?php if($TPL_VAR["data_export"]["status"]>= 45&&$TPL_VAR["data_export"]["status"]< 75){?>
<?php if(!$TPL_VAR["npay_use"]||!$TPL_VAR["data_export"]["npay_order_id"]||($TPL_VAR["npay_use"]&&$TPL_VAR["data_export"]["npay_order_id"]&&$TPL_VAR["data_export"]["status"]== 45)){?>
				<li><span class="btn large red"><button type='button' onclick="batch_change_status('<?php echo $TPL_VAR["data_export"]["status"]?>')">출고상태변경</button></span></li>
<?php }?>
<?php }?>
			</ul>
		</div>
	</div>
	<!-- 페이지 타이틀 바 : 끝 -->

	<!-- 주문정보 : 시작 -->
	<div id="order_info"></div>
</form>
<!-- 주문정보 : 끝 -->


<table width="100%">
	<tr>
		<td valign="bottom">
			<div class="item-title">출고<span style="background-color:yellow" class="title_order_number">
			(<?php echo $TPL_VAR["data_export"]["export_code"]?>)
		</span>의 출고상품
<?php if($TPL_VAR["cfg_order"]["buy_confirm_use"]){?>
<?php if($TPL_VAR["data_export"]["buy_confirm"]!='none'){?>
				<span class="desc" style="font-weight:normal;">
				<?php echo $TPL_VAR["tot"]["buyconfirm_ea"]?>개 구매확정
				( 최신:<?php echo substr($TPL_VAR["data_buy_confirm"]["regdate"], 0, 16)?>

<?php if($TPL_VAR["data_export"]["buy_confirm"]=='admin'){?>
				판매자
<?php }elseif($TPL_VAR["data_export"]["buy_confirm"]=='user'){?>
				구매자
<?php }elseif($TPL_VAR["data_export"]["buy_confirm"]=='system'){?>
				자동
<?php }?>
				/ 잔여구매확정수량 : <?php echo $TPL_VAR["tot"]["buyconfirm_remain"]?>개
				)
			</span>
<?php }?>
<?php if(!$TPL_VAR["orders"]["npay_order_id"]){?>
<?php if($TPL_VAR["data_export"]["buyconfirmInfo"]['btn_buyconfirm']){?>
				<span class="btn small red"><button  type="button" name="buy_confirm" class="buy_confirm">구매확정</button></span>
<?php }?><?php }?>
<?php if(!$TPL_VAR["coupon_cnt"]){?>
				<span class="btn small cyanblue"><button  type="button" class="buy_confirm_log" export_seq="<?php echo $TPL_VAR["data_export"]["export_seq"]?>">로그</button></span>
<?php }?>
<?php }?>
			</div>
		</td>
		<td valign="bottom" align="right" class="pdb3 pdr3">
			<span class="btn small orange"><input type="button" value="안내) 출고처리" class="promotioncodehelperbtn" id="export_guide" /></span>
		</td>
	</tr>
</table>
<table class="order-view-table" width="100%" border=0>
	<colgroup>
		<col />
		<col width="4%" />
		<col width="8%" />
		<col width="6%" />
		<col width="6%" />
		<col width="6%" />
		<col width="5%" />
		<col width="5%" />
		<col width="5%" />
		<col width="5%" />
		<col width="5%" />
		<col width="5%" />
	</colgroup>
	<thead class="oth">
	<tr>
		<th class="dark" rowspan="2">출고상품</th>
		<th class="dark" rowspan="2">주문<br />수량</th>
		<th class="dark" rowspan="2">재고/가용
<?php if(is_array($TPL_R1=config_load('order','ableStockStep'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1=='25'){?>
			<span class="helpicon" title="가용 = 재고-출고예약량<br/>출고예약량 = 결제확인+상품준비+출고준비"></span>
<?php }else{?>
			<span class="helpicon" title="가용 = 재고-출고예약량<br/>출고예약량 = 주문접수+결제확인+상품준비+출고준비"></span>
<?php }?>
<?php }}?></th>
		<th class="dark" rowspan="2">
<?php if($TPL_VAR["data_export"]["wh_name"]){?>
			<div style="color:red;"><?php echo $TPL_VAR["data_export"]["wh_name"]?></div>
<?php }?>
			출고수량
		</th>
		<th class="dark" rowspan="2">예상 캐시<span class="helpicon" title="해당 출고건의 캐시/포인트가 지급(배송완료 시 또는 구매확정 시)될 때<br />지급되어야 하는 잔여 캐시/포인트입니다."></span><br/><span class="desc">(예상포인트)</span></th>
		<th class="dark" rowspan="2">지급 캐시<br/><span class="desc">(지급포인트)</span></th>
		<th class="dark" colspan="6">
			현재 출고 외 상태

		<th>

	</tr>
	<tr>
		<th class="dark">준비</th>
		<th class="dark">출고<br/>준비</th>
		<th class="dark">출고<br/>완료</th>
		<th class="dark">배송<br/>중</th>
		<th class="dark">배송<br/>완료</th>
		<th class="dark">취소</th>
	</tr>
	</thead>

	<tbody class="otb">
<?php if($TPL_data_export_item_1){foreach($TPL_VAR["data_export_item"] as $TPL_V1){?>
<?php if($TPL_V1["opt_type"]=='sub'||$TPL_V1["goods_type"]=='gift'){?>
	<tr class="order-item-row" bgcolor="#f6f6f6">
<?php }else{?>
	<tr class="order-item-row">
<?php }?>
		<td class="info">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<col width="40" /><col />
				<tr>
					<td align="center" style="border:none;">
<?php if($TPL_V1["opt_type"]=="sub"){?>
						<img src="/admin/skin/default/images/common/icon_add_arrow.gif" /></td>
<?php }else{?>
					<a href='/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank'><span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V1["image"]?>" /></span></a>
<?php }?>
					</td>
					<td style="border:none;"><?php echo $TPL_V1["npay_product_order_id"]?>

<?php if($TPL_V1["npay_product_order_id"]){?><div class="ngray bold"><?php echo $TPL_V1["npay_product_order_id"]?><span style="font-size:11px;font-weight:normal"> (Npay상품주문번호)</span></div><?php }?>

<?php if($TPL_V1["opt_type"]!="sub"){?>
						<div>
<?php if($TPL_V1["goods_type"]=="gift"){?>
							<img src="/admin/skin/default/images/common/icon_gift.gif" />
<?php }?>
<?php if($TPL_V1["goods_kind"]=='coupon'){?>
							<a href='../goods/social_regist?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank'>
<?php }elseif($TPL_V1["goods_type"]=='gift'){?>
								<a href='../goods/gift_regist?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank'>
<?php }else{?>
<?php if($TPL_V1["is_bundle_export"]=='Y'){?><span class="bold red">[<?php echo $TPL_V1["order_seq"]?>]</span><br/><?php }?>
									<a href='../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank'>
<?php }?>
										<?php echo $TPL_V1["goods_name"]?></a>
						</div>
<?php }?>

<?php if($TPL_V1["adult_goods"]=='Y'||$TPL_V1["option_international_shipping_status"]=='y'||$TPL_V1["cancel_type"]=='1'||$TPL_V1["tax"]=='exempt'){?>
						<div style="padding-top:3px">
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

						<!-- <?php if($TPL_V1["goods_kind"]=='coupon'){?> -->
						<div style="padding-top:3px">
							<span class="coupon_serial"><?php echo $TPL_V1["coupon_serial"]?></span> /
							<span class="coupon_input"><?php if($TPL_V1["socialcp_input_type"]=='price'){?><?php echo get_currency_price($TPL_V1["coupon_input"], 3)?><?php }else{?><?php echo number_format($TPL_V1["coupon_input"])?>회<?php }?></span> /
							<span class="coupon_remain_value red">잔여<?php if($TPL_V1["socialcp_input_type"]=='price'){?><?php echo get_currency_price($TPL_V1["coupon_remain_value"], 3)?><?php }else{?><?php echo number_format($TPL_V1["coupon_remain_value"])?>회<?php }?></span>
							<span class="btn"><img src="/admin/skin/default/images/common/btn_ok_use.gif" class="excoupon_use_btn" order_seq="<?php echo $TPL_VAR["data_export"]["order_seq"]?>" onclick="excoupon_use_btn(this)" /></span>
						</div>
						<!-- <?php }?> -->

<?php if($TPL_V1["option1"]!=null||$TPL_V1["option2"]!=null||$TPL_V1["option3"]!=null||$TPL_V1["option4"]!=null||$TPL_V1["option5"]!=null){?>
						<div style="padding-top:3px">
<?php if($TPL_V1["opt_type"]=='sub'){?>
							<img src="/admin/skin/default/images/common/icon_add.gif" />
<?php }else{?>
							<img src="/admin/skin/default/images/common/icon_option.gif" />
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
						</div>
<?php }?>
<?php if($TPL_V1["inputs"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["inputs"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["value"]){?>
						<div class="goods_input">
							<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V2["title"]){?><?php echo $TPL_V2["title"]?>:<?php }?>
<?php if($TPL_V2["type"]=='file'){?>
							<a href="../order_process/filedown?file=<?php echo $TPL_V2["value"]?>" target="actionFrame"><?php echo $TPL_V2["value"]?></a>
<?php }else{?><?php echo $TPL_V2["value"]?><?php }?>
						</div>
<?php }?>
<?php }}?>
<?php }?>

<?php if($TPL_V1["goods_type"]=="gift"){?>
<?php if($TPL_V1["gift_title"]){?><div><span class="fx11"><?php echo $TPL_V1["gift_title"]?></span> <span class="btn small gray"><button type="button" class="gift_log" order_seq="<?php echo $TPL_VAR["data_export"]["order_seq"]?>" item_seq="<?php echo $TPL_V1["item_seq"]?>">자세히</button></span></div><?php }?>
<?php }?>
<?php if($TPL_V1["package_yn"]!='y'&&($TPL_V1["goods_code"]||$TPL_V1["whinfo"]["wh_name"])){?>
						<div class="warehouse-info-lay">
							<ul>
<?php if($TPL_V1["whinfo"]["wh_name"]){?>
								<li>
									<?php echo $TPL_V1["whinfo"]["wh_name"]?> <?php if($TPL_V1["whinfo"]["location_code"]){?>(<?php echo $TPL_V1["whinfo"]["location_code"]?>)<?php }?> : <?php echo number_format($TPL_V1["whinfo"]["ea"])?>(<?php echo number_format($TPL_V1["whinfo"]["badea"])?>)
								</li>
<?php }?>
<?php if($TPL_V1["goods_code"]){?><li>상품코드 : <?php echo $TPL_V1["goods_code"]?></li><?php }?>
							</ul>
						</div>
<?php }?>
					</td>
				</tr>
			</table>
		</td>
		<td class="info center ea"><?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["opt_ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?></td>

		<td class="info center">
<?php if($TPL_V1["package_yn"]=='y'){?>
			<span class="blue">실제상품▼</span>
<?php }else{?>
<?php if($TPL_V1["real_stock"]> 0){?>
			<span class="blue"><?php echo number_format($TPL_V1["real_stock"])?></span>
<?php }else{?>
			<span class="red"><?php echo number_format($TPL_V1["real_stock"])?></span>
<?php }?>
			<br/>
<?php if($TPL_V1["stock"]> 0){?>
			<span class="blue"><?php echo number_format($TPL_V1["stock"])?></span>
<?php }else{?>
			<span class="red"><?php echo number_format($TPL_V1["stock"])?></span>
<?php }?>

			<div class="center">
				<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V1["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_V1["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
					<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V1["whinfo"]["option_seq"]?>"></span>
					<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"><span class="hide">옵션</span>
				</span>
			</div>
<?php }?>
		</td>

		<td class="info center">
<?php if($TPL_VAR["data_export"]["status"]== 45){?>
			<form method="post" action="../export_process/ea_modify?export_code=<?php echo $TPL_VAR["data_export"]["export_code"]?>" target="actionFrame">
				<input type="text" name="ea[<?php echo $TPL_V1["export_item_seq"]?>]" size="3" class="onlynumber line" value="<?php echo $TPL_V1["ea"]?>" <?php if(($TPL_VAR["npay_use"]&&$TPL_V1["npay_order_id"])||$TPL_VAR["orders"]["linkage_id"]=='connector'){?>disabled<?php }?> />
<?php if(!$TPL_VAR["npay_use"]||!$TPL_V1["npay_order_id"]){?>
<?php if($TPL_VAR["orders"]["linkage_id"]!='connector'){?><span class="btn small cyanblue"><button type="submit" class="ea_modify">변경</button></span><?php }?>
<?php }?>
			</form>
<?php }else{?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
<?php }?>
		</td>

		<td class="price info">
			<?php echo get_currency_price($TPL_V1["out_reserve"])?><br/>
			<span class="desc">(<?php echo get_currency_price($TPL_V1["out_point"])?>)</span>
		</td>
		<td class="price info">
			<?php echo get_currency_price($TPL_V1["in_reserve"])?><br/>
			<span class="desc">(<?php echo get_currency_price($TPL_V1["in_point"])?>)</span>
		</td>

		<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["ready_ea"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step45"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step55"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step65"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step75"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step85"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>
		</td>


	</tr>
<?php if($TPL_V1["package_yn"]=='y'&&$TPL_V1["opt_type"]=='opt'){?>
<?php if(is_array($TPL_R2=$TPL_V1["packages"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
	<tr class="order-item-row">
		<td style="padding-left:45px;">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:0px">
				<tr>
					<td valign="top" style="border:none;" width="14"><img src="/admin/skin/default/images/common/icon/ico_package.gif" border="0" /></td>
					<td style="border:0px;width:50px;text-align:center">
						<span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V2["image"]?>" /></span>
					</td>
					<td style="font-size:11px;border:0px;">
							<span class="red">
							[실제상품 <?php echo $TPL_I2+ 1?>]
							<?php echo $TPL_V2["goods_name"]?>

							</span>
<?php if($TPL_V2["option1"]!=null){?>
						<div style="padding:5px 0px 0px 10px;">
							<?php echo $TPL_V2["title1"]?>:<?php echo $TPL_V2["option1"]?>

<?php if($TPL_V2["option2"]!=null){?> <?php echo $TPL_V2["title2"]?>:<?php echo $TPL_V2["option2"]?><?php }?>
<?php if($TPL_V2["option3"]!=null){?> <?php echo $TPL_V2["title3"]?>:<?php echo $TPL_V2["option3"]?><?php }?>
<?php if($TPL_V2["option4"]!=null){?> <?php echo $TPL_V2["title4"]?>:<?php echo $TPL_V2["option4"]?><?php }?>
<?php if($TPL_V2["option5"]!=null){?> <?php echo $TPL_V2["title5"]?>:<?php echo $TPL_V2["option5"]?><?php }?>
						</div>
<?php }?>

<?php if($TPL_V2["inputs"]){?>
						<div style="padding:0px 0px 0px 10px;">
<?php if(is_array($TPL_R3=$TPL_V2["inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["value"]){?>
							<div class="goods_input">
								<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V3["title"]){?><?php echo $TPL_V3["title"]?>:<?php }?>
<?php if($TPL_V3["type"]=='file'){?>
								<a href="../order_process/filedown?file=<?php echo $TPL_V3["value"]?>" target="actionFrame"><?php echo $TPL_V3["value"]?></a>
<?php }else{?><?php echo $TPL_V3["value"]?><?php }?>
							</div>
<?php }?>
<?php }}?>
						</div>
<?php }?>
						<div class="warehouse-info-lay">
							<ul>
<?php if($TPL_V2["whinfo"]["wh_name"]){?>
								<li>
									<?php echo $TPL_V2["whinfo"]["wh_name"]?> <?php if($TPL_V2["whinfo"]["location_code"]){?>(<?php echo $TPL_V2["whinfo"]["location_code"]?>)<?php }?> : <?php echo number_format($TPL_V2["whinfo"]["ea"])?>(<?php echo number_format($TPL_V2["whinfo"]["badea"])?>)
								</li>
<?php }?>
								<li>상품코드 : <?php echo $TPL_V2["goods_code"]?></li>
							</ul>
						</div>
					</td>
				</tr>
			</table>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["opt_ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["opt_ea"]?>

			<div class="center">
				<span class="helpicon" title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량"></span>
			</div>
		</td>
		<td class="info center">
<?php if($TPL_V2["real_stock"]> 0){?>
			<span class="blue"><?php echo number_format($TPL_V2["real_stock"])?></span>
<?php }else{?>
			<span class="red"><?php echo number_format($TPL_V2["real_stock"])?></span>
<?php }?>
			<br/>
<?php if($TPL_V2["stock"]> 0){?>
			<span class="blue"><?php echo number_format($TPL_V2["stock"])?></span>
<?php }else{?>
			<span class="red"><?php echo number_format($TPL_V2["stock"])?></span>
<?php }?>
			<div class="center">
					<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V2["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_V1["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
						<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V2["whinfo"]["option_seq"]?>"></span>
						<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V2["goods_seq"]?>"><span class="hide">옵션</span>
					</span>
			</div>
		</td>
		<td class="info center">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["ea"]?>

		</td>
		<td class="info center">-</td>
		<td class="info center">-</td>
		<td class="info center ea">
<?php if($TPL_V1["ready_ea"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["ready_ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["ready_ea"]?>

<?php }else{?>
			0
<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["exp_step45"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step45"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step45"]?>

<?php }else{?>
			0
<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["exp_step55"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step55"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step55"]?>

<?php }else{?>
			0
<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["exp_step65"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step65"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step65"]?>

<?php }else{?>
			0
<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["exp_step75"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step75"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step75"]?>

<?php }else{?>
			0
<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["exp_step85"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step85"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step85"]?>

<?php }else{?>
			0
<?php }?>
		</td>
	</tr>
<?php }}?>
<?php }?>
<?php if($TPL_V1["package_yn"]=='y'&&$TPL_V1["opt_type"]=='sub'){?>
<?php if(is_array($TPL_R2=$TPL_V1["packages"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<tr class="order-item-row" bgcolor="#f6f6f6">
		<td style="padding-left:45px;">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:0px">
				<tr>
					<td valign="top" style="border:none;" width="14"><img src="/admin/skin/default/images/common/icon/ico_package.gif" border="0" /></td>
					<td style="border:0px;width:50px;text-align:center">
						<span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V2["image"]?>" /></span>
					</td>

					<td style="font-size:11px;border:0px;">
							<span class="red">
							[실제상품]
							<?php echo $TPL_V2["goods_name"]?>

							</span>
<?php if($TPL_V2["option1"]!=null){?>
						<div style="padding:5px 0px 0px 10px;">
							<?php echo $TPL_V2["title1"]?>:<?php echo $TPL_V2["option1"]?>

<?php if($TPL_V2["option2"]!=null){?> <?php echo $TPL_V2["title2"]?>:<?php echo $TPL_V2["option2"]?><?php }?>
<?php if($TPL_V2["option3"]!=null){?> <?php echo $TPL_V2["title3"]?>:<?php echo $TPL_V2["option3"]?><?php }?>
<?php if($TPL_V2["option4"]!=null){?> <?php echo $TPL_V2["title4"]?>:<?php echo $TPL_V2["option4"]?><?php }?>
<?php if($TPL_V2["option5"]!=null){?> <?php echo $TPL_V2["title5"]?>:<?php echo $TPL_V2["option5"]?><?php }?>
						</div>
<?php }?>

<?php if($TPL_VAR["exportPrintGoodsBarcode"]){?>
						<div style="padding:2px 0px 0px 10px;">
							<img src="../order/order_barcode_image?order_seq=<?php echo $TPL_V2["goods_code"]?>" />
						</div>
<?php }?>
<?php if($TPL_V2["inputs"]){?>
						<div style="padding:0px 0px 0px 10px;">
<?php if(is_array($TPL_R3=$TPL_V2["inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["value"]){?>
							<div class="goods_input">
								<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V3["title"]){?><?php echo $TPL_V3["title"]?>:<?php }?>
<?php if($TPL_V3["type"]=='file'){?>
								<a href="../order_process/filedown?file=<?php echo $TPL_V3["value"]?>" target="actionFrame"><?php echo $TPL_V3["value"]?></a>
<?php }else{?><?php echo $TPL_V3["value"]?><?php }?>
							</div>
<?php }?>
<?php }}?>
						</div>
<?php }?>

						<div class="warehouse-info-lay">
							<ul>
<?php if($TPL_V2["whinfo"]["wh_name"]){?>
								<li>
									<?php echo $TPL_V2["whinfo"]["wh_name"]?> <?php if($TPL_V2["whinfo"]["location_code"]){?>(<?php echo $TPL_V2["whinfo"]["location_code"]?>)<?php }?> : <?php echo number_format($TPL_V2["whinfo"]["ea"])?>(<?php echo number_format($TPL_V2["whinfo"]["badea"])?>)
								</li>
<?php }?>
								<li>상품코드 : <?php echo $TPL_V2["goods_code"]?></li>
							</ul>
						</div>
					</td>
				</tr>
			</table>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["opt_ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["opt_ea"]?>

			<div class="center">
				<span class="helpicon" title="<?php echo $TPL_V2["unit_ea"]?>개 / 주문수량당"></span>
			</div>
		</td>
		<td class="info center">
<?php if($TPL_V2["real_stock"]> 0){?>
			<span class="blue"><?php echo number_format($TPL_V2["real_stock"])?></span>
<?php }else{?>
			<span class="red"><?php echo number_format($TPL_V2["real_stock"])?></span>
<?php }?>
			<br/>
<?php if($TPL_V2["stock"]> 0){?>
			<span class="blue"><?php echo number_format($TPL_V2["stock"])?></span>
<?php }else{?>
			<span class="red"><?php echo number_format($TPL_V2["stock"])?></span>
<?php }?>

			<div class="center">
					<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V2["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_V1["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
						<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V2["option_seq"]?>"></span>
						<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V2["goods_seq"]?>"><span class="hide">옵션</span>
					</span>
			</div>
		</td>
		<td class="info center">
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["ea"]?>

		</td>
		<td class="info center">-</td>
		<td class="info center">-</td>
		<td class="info center ea">
<?php if($TPL_V1["ready_ea"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["ready_ea"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["ready_ea"]?>

<?php }else{?>
			0
<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["exp_step45"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step45"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step45"]?>

<?php }else{?>
			0
<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["exp_step55"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step55"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step55"]?>

<?php }else{?>
			0
<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["exp_step65"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step65"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step65"]?>

<?php }else{?>
			0
<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["exp_step75"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V1["exp_step75"]?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step75"]?>

<?php }else{?>
			0
<?php }?>
		</td>
		<td class="info center ea">
<?php if($TPL_V1["exp_step85"]){?>
<?php if($TPL_V1["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V1["exp_step85"])?><?php if($TPL_V1["package_yn"]=='y'){?>]<?php }?>x<?php echo $TPL_V2["unit_ea"]?>=<?php echo $TPL_V2["unit_ea"]*$TPL_V1["exp_step85"]?>

<?php }else{?>
			0
<?php }?>
		</td>
	</tr>
<?php }}?>
<?php }?>
<?php }}?>

	<tr class="order-item-row">
		<td style="padding-left:10px; border-right:0px;">
			<?php echo $TPL_VAR["orders"]["recipient_user_name"]?>

<?php if($TPL_VAR["data_export_item"][ 0]["goods_kind"]=='coupon'){?>
<?php if($TPL_VAR["orders"]["recipient_cellphone"]){?> / <?php echo ($TPL_VAR["orders"]["recipient_cellphone"])?><?php }?>
<?php if($TPL_VAR["orders"]["recipient_email"]){?> / <?php echo ($TPL_VAR["orders"]["recipient_email"])?><?php }?>
<?php }else{?>
<?php if($TPL_VAR["orders"]["recipient_zipcode"]){?>(<?php echo $TPL_VAR["orders"]["recipient_zipcode"]?>)<?php }?>
<?php if($TPL_VAR["orders"]["recipient_address_type"]!="street"){?>
			<?php echo $TPL_VAR["orders"]["recipient_address"]?> <?php echo $TPL_VAR["orders"]["recipient_address_detail"]?><br/>
<?php }else{?>
			<?php echo $TPL_VAR["orders"]["recipient_address_street"]?> <?php echo $TPL_VAR["orders"]["recipient_address_detail"]?><br/>
<?php }?>
<?php if($TPL_VAR["orders"]["recipient_phone"]){?><?php echo ($TPL_VAR["orders"]["recipient_phone"])?><?php }?>
<?php if($TPL_VAR["orders"]["recipient_cellphone"]){?> / <?php echo ($TPL_VAR["orders"]["recipient_cellphone"])?><?php }?>
<?php if($TPL_VAR["orders"]["hope_date"]){?> / <?php echo $TPL_VAR["orders"]["hope_date"]?><?php }?>
<?php }?>
		</td>
		<td class="info ea center"><strong><?php echo $TPL_VAR["tot"]["opt_ea"]?></strong></td>
		<td  class="info center">
<?php if($TPL_VAR["tot"]["real_stock"]> 0){?>
			<span class="blue bold"><?php echo number_format($TPL_VAR["tot"]["real_stock"])?></span>
<?php }else{?>
			<span class="red bold"><?php echo number_format($TPL_VAR["tot"]["real_stock"])?></span>
<?php }?>
			<br/>
<?php if($TPL_VAR["tot"]["stock"]> 0){?>
			<span class="blue bold"><?php echo number_format($TPL_VAR["tot"]["stock"])?></span>
<?php }else{?>
			<span class="red bold"><?php echo number_format($TPL_VAR["tot"]["stock"])?></span>
<?php }?>
		</td>
		<td class="info center"><strong><?php echo $TPL_VAR["tot"]["ea"]?> (<?php echo $TPL_VAR["tot"]["goods_cnt"]?>종)</strong></td>
		<td class="price info bold">
			<?php echo get_currency_price($TPL_VAR["tot"]["reserve"])?><br/>
			<span class="desc">(<?php echo get_currency_price($TPL_VAR["tot"]["point"])?>)</span>
		</td>
		<td class="price info bold">
			<?php echo get_currency_price($TPL_VAR["tot"]["in_reserve"])?><br/>
			<span class="desc">(<?php echo get_currency_price($TPL_VAR["tot"]["in_point"])?>)</span>
		</td>
		<td class="info ea bold center"><?php echo number_format($TPL_VAR["tot"]["ready_ea"])?></td>
		<td class="info ea bold center"><?php echo number_format($TPL_VAR["tot"]["exp_step45"])?></td>
		<td class="info ea bold center"><?php echo number_format($TPL_VAR["tot"]["exp_step55"])?></td>
		<td class="info ea bold center"><?php echo number_format($TPL_VAR["tot"]["exp_step65"])?></td>
		<td class="info ea bold center"><?php echo number_format($TPL_VAR["tot"]["exp_step75"])?></td>
		<td class="info ea bold center"><?php echo number_format($TPL_VAR["tot"]["step85"])?></td>
	</tr>
	</tbody>
</table>

<div id="goods_export_dialog"></div>
<div id="gift_use_lay"></div>

<div id="export_guide_dialog" class="hide">
	<div class="center">
		<img src="/admin/skin/default/images/common/img_release_guide.gif" />
		<div class="pdt10"><img src="/admin/skin/default/images/common/btn_popup_close.gif" class="hand" onclick="closeDialog('export_guide_dialog')" /></div>
	</div>
</div>

<div id="export_buyconfirm_log" class="hide">

</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>