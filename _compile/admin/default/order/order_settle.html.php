<?php /* Template_ 2.2.6 2022/05/17 12:36:40 /www/music_brother_firstmall_kr/admin/skin/default/order/order_settle.html 000047657 */ 
$TPL_bank_1=empty($TPL_VAR["bank"])||!is_array($TPL_VAR["bank"])?0:count($TPL_VAR["bank"]);?>
<style type="text/css">
#person_step1,#person_step2,#person_step3 {font-size:12px;color:#666;}

div.person-top-step {width:100%;text-align:center;margin-top:10px;}
span.step-title {padding:8px 13px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;}
span.step-title.gray {background-color:#dddddd;color:#000;}
span.step-title.black {background-color:#333;color:#fff;}
div.person-step-title {font-size:15px;font-weight:bold;margin:20px 0 10px 0;color:#000;}
div.btn-bottom {margin:10px 0;width:100%;text-align:center;}
div.cart-list {margin-top:5px;}
div.settle_title { margin:20px 0 5px 0; }
div.translucent_disable_lay	{position:absolute;top:0;left:0;width:100%;z-index:1;}
div.translucent_disable_back {position:absolute;top:0;left:0;width:100%;background-color:#000000;filter:alpha(opacity=75);-ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=75)';opacity:0.75;background:rgba(0,0,0,0.75);z-index:2;}
div.translucent_disable_title {position:absolute;top:45px;left:10%;color:#fff;font-size:20px;font-weight:bold;font-family:Verdana, Arial, sans-serif;z-index:3;}
.couponbtn {border:0px; background-color:#000; color:#fff; font-family:dotum; font-size:11px; height:20px; letter-spacing:-1px; padding:0 7px; cursor:pointer}
.international , .onlymembers { display:none; }
.eaMinus, .eaPlus, .removeOption{vertical-align:middle}
.ea_change{padding:0 !important;}

div.translucent_disable_title_personal_code {position:absolute;top:50px;left:10%;color:#fff;font-size:20px;font-weight:bold;font-family:돋움,Verdana, Arial, sans-serif;z-index:3;}

.enuri_div_none {font-family:돋움;}
</style>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/admin_cart.css" />
<script type="text/javascript">
	var gl_mode					= 'direct';
	var gl_region				= new Array();
	var gl_mobile				= '<?php echo $TPL_VAR["members"]["mobile"]?>';
</script>
<script type="text/javascript" src="/app/javascript/js/order-settle.js?dummy=<?php echo date('YmdHis')?>" charset="utf8"></script>
<script type="text/javascript">

	$(document).ready(function(){
<?php if($TPL_VAR["ordertype"]=='person'){?>
			$("div.translucent_disable_lay").show();
<?php }?>

		// 해외/국내 배송 선택
		/*$("select[name='international']").bind("change",function(){
			check_shipping_method();
		});
		*/

		// 구스킨 우편번호 처리를 위해 추가
		$('input[name="recipient_address_detail"]').focus(function(){
			var old_form_zipcode	= '';
			var new_form_zipcode	= $('input[name="recipient_new_zipcode"]').val();
			$('input[name="recipient_zipcode[]"]').each(function(){
				old_form_zipcode	+= this.value;
			});
			
			if(new_form_zipcode != old_form_zipcode && old_form_zipcode){
				$('input[name="recipient_new_zipcode"]').val(old_form_zipcode);
			}
		});

	});

	function translucent_disable(){

		var trans_height = $(".tb_translucent_disable").height();

		if(trans_height > 260){ trans_height = 254; }
		$(".translucent_disable_back").eq(0).height(trans_height);
		$(".translucent_disable_title").eq(0).attr("style","top:"+eval((trans_height/2)-10)+"px");

		$(".translucent_disable_back").eq(1).height(160);
		$(".translucent_disable_title").eq(1).attr("style","top:80px");
		
<?php if($TPL_VAR["ordertype"]=='person'){?>
			$("div.translucent_disable_lay").show();
<?php }?>

	}

	function check_shipping_method(){

		var idx = $("select[name='international'] option:selected").val();
		$("div.shipping_method_radio").each(function(){
			$(this).hide();
		});
		if(!idx)idx = 0;

		$("div.shipping_method_radio").eq(idx).show();

		if(idx == 0){
			$(".domestic").show();
			$(".international").hide();
		}else{
			$(".international").show();
			$(".domestic").hide();
		}

	}

	// 다음 단계로 이동
	function moveNextStep(step){

		if	(step == 1){
			if	($("input[name='member_group']").eq(1).attr('checked') || $("input[name='member_seq']").val() > 0){
				$("div#person_step1").hide();
				$(".ui-dialog").animate({top: "50px", left: "100px", width: "1000px", height:"800px"}, 500);
				$(".ui-dialog-content").css('height', '90%');
				$("span.step-title").removeClass("black").removeClass("gray").addClass("gray");
				$("span.step-title").eq(1).removeClass("gray").addClass("black");
				$("div#person_step2").show();
				$("#individual_noti").css('display','block');
				cart();
			}else{
				openDialogAlert('회원을 선택해 주세요', 400, 150);
				return;
			}

			// 회원이 선택된 경우 회원용으로 폼 변경
			$(".onlymembers").hide();
			$("div.personalinfomation-lay").show();
			if	($("input[name='member_group']").eq(0).attr('checked') && $("input[name='member_seq']").val() > 0){
				$("div.personalinfomation-lay").hide();
				$(".onlymembers").show();
				$(".onlymembers").attr("style","display:block;");
				$(".onlymembers").attr("style","display:table-row;");
				getLastlyShippingAddress();
			}

		}else if	(step == 2){

			if	($("input[name='cartOptionSeq[]']").length > 0){
				$("div#person_step2").hide();
				$(".ui-dialog").animate({top: "50px", left: "80px", width: "1100px", height:"800px"}, 500);
				$(".ui-dialog-content").css('height', '90%');
				$("span.step-title").removeClass("black").removeClass("gray").addClass("gray");
				$("span.step-title").eq(2).removeClass("gray").addClass("black");
				$("div#person_step3").show();
				$("div#individual_noti").css('display','block');
				settle_cart();
			}else{
				openDialogAlert('상품을 선택해 주세요', 400, 150);
				return;
			}
		}
	}

	// 이전 단계로 이동
	function movePrevStep(step){
		if	(step == 2){
			$(".ui-dialog").animate({top: "300px", left: "350px", width: "600px", height:"300px"}, 500);
			$(".ui-dialog-content").css('height', '90%');
			$("span.step-title").removeClass("black").removeClass("gray").addClass("gray");
			$("span.step-title").eq(0).removeClass("gray").addClass("black");
			$("div#person_step1").show();
			$("div#person_step2").hide();
			$("#individual_noti").css('display','grid');
		}else if	(step == 3){
			$("div#person_step3").hide();
			$(".ui-dialog").animate({top: "50px", left: "100px", width: "1000px", height:"800px"}, 500);
			$(".ui-dialog-content").css('height', '90%');
			$("span.step-title").removeClass("black").removeClass("gray").addClass("gray");
			$("span.step-title").eq(1).removeClass("gray").addClass("black");
			$("div#person_step2").show();
		}
	}

	// 장바구니 추출
	function cart(){
		var member_seq = $("input[name='member_seq']").val();
		$.ajax({
			type: "get",
			url: "../order/cart",
			data: "cart_table=<?php echo $TPL_VAR["ordertype"]?>&member_seq="+member_seq,
			success: function(result){
				loadingStop("#ajaxLoadingLayer");
				$(".cart_list").html(result);
			}
		});

		order_price_calculate();
	}

	// 주문 페이지용 장바구니 추출
	function settle_cart(){

		var member_seq = $("input[name='member_seq']").val();
		$.ajax({
			type: "get",
			url: "../order/cart",
			data: "issettle=y&cart_table=<?php echo $TPL_VAR["ordertype"]?>&member_seq="+member_seq,
			success: function(result){
				loadingStop("#ajaxLoadingLayer");
				$(".settle_cart_list").html(result);
				$("#individual_noti").css('display','block');
			}
		});

		//check_shipping_method();
	}

	// 배송비 안내에서 배송정보 변경시 처리
	function chg_delivery_info(mode){
		if(mode == "cart"){
			closeDialog('shipping_detail_lay');
			$('#shipping_detail_lay').remove();	// dialog clone버그로 인해 dummy 제거 추가
			moveNextStep(1);
		}else if(mode == "settle"){
			closeDialog('shipping_detail_lay');
			$('#shipping_detail_lay').remove();// dialog clone버그로 인해 dummy 제거 추가
			cart();
			settle_cart();
		}
	}

	// 할인 및 주문금액 계산
	/*
	function order_price_calculate(){
		var f		= $("form#orderFrm");
		var action	= '/order/calculate?mode=<?php echo $TPL_VAR["mode"]?>&adminOrder=admin';
<?php if($TPL_VAR["ordertype"]=='person'){?>
		action		= action + '&adminOrderType=person';
<?php }?>
		f.attr("action", action);
		f.attr("target","actionFrame");
		f[0].submit();

		translucent_disable();
	}
	*/

	// 장바구니 상품 선택
	function set_goods_list(displayId,inputGoods,ordertype){

		var mem_seq = $("input[name='member_seq']").val();

		if(ordertype == "person"){
			if(mem_seq == ""){
				alert("회원을 선택하세요.");
				return;
			}
		}

		//url: "../order/goods_select",
		$("div#"+displayId).html('');
		$.ajax({
			type: "get",
			url: "../goods/select_new",
			data: "page=1&inputGoods="+inputGoods+"&displayId="+displayId+"&ordertype="+ordertype+"&member_seq="+mem_seq+"&cart_table="+ordertype,
			success: function(result){
				$("div#"+displayId).html(result);
			}
		});
		openDialog("상품 검색", displayId, {"width":"1000","height":"700","show" : "fade","hide" : "fade"});
	}

	// 비회원으로 전환 시 회원정보 초기화
	function reset_member_select(){
		if	(!$("input[name='member_group']").eq(1).attr('disabled')){
			$("#userInfo2").html('');
			$("input[name='member_seq']").val('');

			//프로모션 코드 미적용 19.01.23 kmj
			$.ajax({
				'url' : '/promotion/getPromotionCartDel',
				'cache': false,
				'success' : function(){
					$(".cartPromotionTh").hide();
					$(".cartPromotionTd").hide();
					$("#pricePromotionTd").hide();
					$(".cartpromotioncodedellay").hide();
					$(".cartpromotioncodeinputlay").show();
				}
			});
		}
	}

	// 회원선택
	function coupon_member_search(ordertype){
		if	($("input[name='member_group']").eq(0).attr('checked')){
			addFormDialogSel('./download_member?ordertype='+ordertype, '85%', '750', '회원검색');
		}
	}
	function addFormDialogSel(url, width, height, title, btn_yn) {
		newcreateElementContainer(title);
		newrefreshTable(url);

		$('#dlg').dialog({
			bgiframe: true,
			autoOpen: false,
			width: width,
			height: height,
			resizable: false,
			draggable: false,
			modal: true,
			overlay: {
				backgroundColor: '#000000',
				opacity: 0.8
			},
			buttons: {
				'닫기': function() {
					$(this).dialog('close');
				}
			}
		}).dialog('open');
		return false;
	}

	// 회원의 최근 배송지 5건 추출
	function getLastlyShippingAddress(){
		$(".chk_last_address_lay").hide();
		$("select[name='chkQuickAddressLately']").find('option').remove();

		var member_seq	= $("input[name='member_seq']").val();
		if	(member_seq > 0){
			data			= 'return_type=json&member_seq='+member_seq;
			$.ajax({
				'url'		: '../member/get_lastly_shipping_address',
				'data'		: data,
				'dataType'	: 'json',
				'success'	: function(res){
					if	(res.length > 0){
						$(".chk_last_address_lay").show();
						var loop	= res.length;
						var opt		= '';
						for (var i = 0; i < loop; i++){
							opt		= '';
							if	(res[i].recipient_address_type == 'street'){
								opt		= '<option value="'+i+'">'+res[i].recipient_address_street+' '+res[i].recipient_address_detail+'</option>';
							}else{
								opt		= '<option value="'+i+'">'+res[i].recipient_address+' '+res[i].recipient_address_detail+'</option>';
							}
							$("select[name='chkQuickAddressLately']").append(opt);
						}
					}
				}
			});
		}
	}

	// 배송지 선택에 따른 변경
	/*
	function get_recipient_address(obj){
		if	($(obj).attr('type') == 'radio' && !$(obj).is(":checked"))	return;

		var val = $(obj).val();
		if	($(obj).attr('type') == 'checkbox' && val == 'copy' && !$(obj).is(":checked"))	val = 'new';

		switch(val){
			case "often":
			case "lately":
			case "member":
				var data = {'member_seq':$("input[name='member_seq']").val(),'type':$(obj).val()};
				if	(val == 'lately'){
					data['idx'] = $("select[name='chkQuickAddressLately']").val();
				}

				$.ajax({
					'url'		: '/order/ajax_get_delivery_address',
					'data'		: data,
					'dataType'	: 'json',
					'success'	: function(res){
						if	(res){
							$('input[name="recipient_new_zipcode"]').val(res.recipient_new_zipcode);
							$("input[name='recipient_zipcode[]']").each(function(idx){
								if(typeof res.recipient_zipcode == 'string' && res.recipient_zipcode.length > 6){
									$(this).val( res.recipient_zipcode.split('-')[idx] );
								}
							});

							if	(res.recipient_address_type == "street"){
								$("input[name='recipient_address']").hide();
								$("input[name='recipient_address_street']").show();
							}else{
								$("input[name='recipient_address']").show();
								$("input[name='recipient_address_street']").hide();
							}

							$("input[name='recipient_address_type']").val( res.recipient_address_type );
							$("input[name='recipient_address']").val( res.recipient_address );
							$("input[name='recipient_address_street']").val( res.recipient_address_street );
							$("input[name='recipient_address_detail']").val( res.recipient_address_detail );
							if	( res.recipient_address_street && res.recipient_address_street.length ) {
								$("input[name='recipient_address']").hide();
								$("input[name='recipient_address_street']").show();
							}

							$("input[name='recipient_user_name']").val( res.recipient_user_name );
							$("input[name='recipient_email']").val( res.recipient_email );

							if	(res.recipient_phone != null) {
								$("input[name='recipient_phone[]']").each(function(idx){
									$(this).val( res.recipient_phone.split('-')[idx] );
								});
							}

							if	(res.recipient_cellphone != null) {
								$("input[name='recipient_cellphone[]']").each(function(idx){
									$(this).val( res.recipient_cellphone.split('-')[idx] );
								});
							}

							$("input[name='recipient_zipcode[]']").first().blur();
						}

						order_price_calculate();
					}
				});
			break;
			case "new":
				$('input[name="recipient_new_zipcode"]').val("");
				$("input[name='order_zipcode[]']").each(function(idx){
					$("input[name='recipient_zipcode[]']").eq(idx).val("");
				});

				$("input[name='recipient_address_type']").val("");
				$("input[name='recipient_address']").val("");
				$("input[name='recipient_address_street']").val("");
				$("input[name='recipient_address_detail']").val("");
				$("input[name='recipient_user_name']").val("");

				$("input[name='international_address']").val("");
				$("input[name='international_town_city']").val("");
				$("input[name='international_county']").val("");
				$("input[name='international_postcode']").val("");
				$("input[name='international_country']").val("");

				$("input[name='order_phone[]']").each(function(idx){
					$("input[name='recipient_phone[]']").eq(idx).val("");
				});

				$("input[name='order_cellphone[]']").each(function(idx){
					$("input[name='recipient_cellphone[]']").eq(idx).val("");
				});

				$("input[name='recipient_email']").val("");

				order_price_calculate();
			break;
		}
	}
	*/

	// 배송정보 채우기
	/*
	function set_recipient_info(obj){
		if( $(obj).attr("checked") ){
			$("input[name='recipient_user_name']").val( $("input[name='order_user_name']").val() );
			$("input[name='order_phone[]']").each(function(idx){
				$("input[name='recipient_phone[]']").eq(idx).val( $("input[name='order_phone[]']").eq(idx).val() );
				$("input[name='international_recipient_phone[]']").eq(idx).val( $("input[name='order_phone[]']").eq(idx).val() );
			});
			$("input[name='order_cellphone[]']").each(function(idx){
				$("input[name='recipient_cellphone[]']").eq(idx).val( $("input[name='order_cellphone[]']").eq(idx).val() );
				$("input[name='international_recipient_cellphone[]']").eq(idx).val( $("input[name='order_cellphone[]']").eq(idx).val() );
			});
			$("input[name='recipient_email']").val( $("input[name='order_email']").val() );
		}else{
			$("input[name='recipient_user_name']").val("");
			$("input[name='order_phone[]']").each(function(idx){
				$("input[name='recipient_phone[]']").eq(idx).val("");
			});
			$("input[name='order_cellphone[]']").each(function(idx){
				$("input[name='recipient_cellphone[]']").eq(idx).val("");
			});
			$("input[name='recipient_email']").val("");
		}
		order_price_calculate();
	}
	*/

	// 영수증 발급을 클릭했을경우
	function taxBill(str){
		// 발급안함
		if(str == 0) {
			$('#cash_container').hide();
			$('#tax_container').hide();
			taxRemoveClass();
			cashRemoveClass();
		}
		// 세금계산서 신청일 경우
		else if(str == 1) {
			$('#tax_container').show();
			$('#cash_container').hide();

			$('#co_name').attr('title', ' ').addClass('required');
			$('#co_ceo').attr('title', ' ').addClass('required');
			$('#busi_no').attr('title', ' ').addClass('required').addClass('busiNo');
			$('#co_zipcode').attr('title', ' ').addClass('required');
			$('#co_address').attr('title', ' ').addClass('required');
			$('#co_status').attr('title', ' ').addClass('required');
			$('#co_type').attr('title', ' ').addClass('required');

			cashRemoveClass();
		}
		// 현금영수증 신청일 경우
		else if(str == 2) {
			$('#cash_container').show();
			$('#tax_container').hide();
			$('#creceipt_number').attr('title', ' ').addClass('required').addClass('numberHyphen');
			taxRemoveClass();
		}
	}

	// 소득공제 타입 결정
	function cashBilltype(str){
		// 개인일 경우
		if(str == 0) {
			$('#personallay').show();
			$('#businesslay').hide();
		}
		// 사업자일경우
		else if(str == 1) {
			$('#personallay').hide();
			$('#businesslay').show();
		}
	}

	// 세금계산서 폼체크를 삭제한다.
		<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
		function taxRemoveClass() {
			$('#co_name').removeClass('required');
			$('#co_ceo').removeClass('required');
			$('#busi_no').removeClass('required');
			$('#co_zipcode').removeClass('required');
			$('#co_address').removeClass('required');
			$('#co_status').removeClass('required');
			$('#co_type').removeClass('required');
		}

	// 현금영수증 폼체크를 삭제한다.
		<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
	function cashRemoveClass() {
		$('#creceipt_number').removeClass('required');
	}

	// 주문하기
	function adminPay(){

		var frm = document.orderFrm;
		var action = "";
<?php if($TPL_VAR["ordertype"]=='person'){?>
		action = "/admin/order/pay";
<?php }else{?>

		if	($("div.personalinfomation-lay").css('display') && $("div.personalinfomation-lay").css('display') != 'none'){
			if($("input[name='agree']:checked").val()!='Y'){
				alert('개인정보 수집ㆍ이용에 동의하셔야 합니다.');
				$("input[name='agree']").focus();
				return false;
			}
		}

		if	($("div.cancellation-lay").css('display') && $("div.cancellation-lay").css('display') != 'none'){
			if	($("input[name='cancellation']:checked").val() != 'Y'){
				alert('청약철회 관련방침에 동의하셔야 합니다.');
				$("input[name='cancellation']").focus();
				return false;
			}
		}
		action = "/order/pay";
<?php }?>
			
		// ssl 적용
		$.ajax({
			async: false,
			'url'		: '/common/ssl_action',
			'data'		: {'action':action},
			'type'		: 'get',
			'dataType'	: 'html',
			'success'	: function(res) {
				action = res;
			}
		});
			
		frm.action = action;
		frm.target = "actionFrame";
		frm.submit();
	}

	// 캐시 사용여부 변경
	function chgUseReserve(obj){
		var idx	= $("input[name='use_reserve']").index(obj);
		$("div.use-reserve-lay").hide();
		$("div.use-reserve-lay").eq(idx).show();

		if	(!$(obj).val()){
			$("input[name='reserve_limit']").attr('disabled', true);
		}else{
			$("input[name='reserve_limit']").attr('disabled', false);
		}
	}

	function international_method(val){
		if(val == "1"){
			document.getElementById("international_foreign").style.display = "block";
			document.getElementById("international_country").style.display = "none";
		}else{
			document.getElementById("international_foreign").style.display = "none";
			document.getElementById("international_country").style.display = "block";
		}
	}

	
</script>
<?php if($TPL_VAR["ordertype"]!='admin'){?>
<div id="individual_noti" class="desc enuri_div_none orange" style="display:grid;">
	<span>※ 개인 결제 유효기간은 7일입니다.</span>
	<span>(유효기간 내 고객이 미 주문 시 '마이페이지 > 나의쇼핑 > 개인결제'에서 자동으로 삭제됩니다.)</span>
</div>
<?php }?>
<div class="person-top-step">
	<span class="step-title black"><b>STEP 1 구매자 선택</b></span>
	<img src="/admin/skin/default/images/design/coupon_code_depth.jpg" height="20" align="absmiddle" />
	<span class="step-title gray"><b>STEP 2 상품 선택</b></span>
	<img src="/admin/skin/default/images/design/coupon_code_depth.jpg" height="20" align="absmiddle" />
	<span class="step-title gray"><b>STEP 3 에누리 할인</b></span>
</div>

<br style="line-height:20px;" />

<form name="orderFrm" id="orderFrm" method="post" action="/order/pay" target="actionFrame">
<input type="hidden" name="member_seq"/>
<input type="hidden" name="mode" value="<?php echo $TPL_VAR["mode"]?>"/>
<input type="hidden" name="order_version" value="1.1" />
<input type="hidden" name="delivery_coupon" value="" />
<input type="hidden" name="download_seq" id="download_seq" value="" />
<input type="hidden" name="coupon_sale" id="shipping_coupon_sale" value="" />
<input type="hidden" name="adminOrder" id="adminOrder" value="admin" />
<input type="hidden" name="adminOrderType" id="adminOrderType" value="<?php if($TPL_VAR["ordertype"]=='person'){?>person<?php }else{?><?php }?>" />
<input type="hidden" name="shipping_promotion_code_seq" id="shipping_promotion_code_seq" value="" />
<input type="hidden" name="shipping_promotion_code_sale" id="shipping_promotion_code_sale" value="" />

<input type="hidden" name="ordersheet_coupon_download_seq" id="ordersheet_coupon_download_seq" value="" />

<!-- Step1. 구매자 선택 -->
<div id="person_step1">
	<div class="person-step-title">STEP1. 구매자를 선택하세요.</div>
	<div class="select-member">
		<div>
			<label><input type="radio" name="member_group" value="1" checked /> 회원</label>
			<span class="btn small"><button type="button" onclick="coupon_member_search('<?php echo $TPL_VAR["ordertype"]?>');">선택</button></span>
		</div>
		<div id="userInfo2" style="margin-left:20px;"></div>
		<div style="margin-top:20px;">
			<label onclick="reset_member_select();"><input type="radio" name="member_group" value="0" <?php if($TPL_VAR["ordertype"]=='person'){?>disabled<?php }?> /> 비회원 - STEP 3에서 주문자 정보를 입력하세요.</label>
		</div>
	</div>
	<div class="btn-bottom">
		<span class="btn large black"><button type="button" onclick="moveNextStep('1');">다음 단계 &gt;</button></span>
	</div>
</div>

<!-- Step2. 상품 선택 -->
<div id="person_step2" class="hide">
	<div class="person-step-title">
		STEP2. 상품을 선택하세요.
		<span class="btn small gray"><button type="button" onclick="set_goods_list('issueGoodsSelect','issueGoods', '<?php echo $TPL_VAR["ordertype"]?>');">선택</button></span>
<?php if(serviceLimit('H_AD')){?>
		<span class="desc enuri_div_none">※ 에누리를 적용하려면 동일 입점사의 상품만을 선택하거나 본사 상품만 선택하셔야 합니다.</span>
<?php }?>
	</div>

	<div class="cart_list"></div>

	<div class="btn-bottom">
		<span class="btn large black"><button type="button" onclick="movePrevStep('2');">&lt; 이전 단계 </button></span>
		<span class="btn large black"><button type="button" onclick="moveNextStep('2');">다음 단계 &gt;</button></span>
	</div>
</div>

<!-- Step3. 에누리 할인 -->
<div id="person_step3" class="hide">
	<div class="person-step-title">
<?php if($TPL_VAR["ordertype"]=='person'){?>
		STEP3. 에누리 할인 여부를 결정하시고 개인 결제 생성을 완료하세요.
<?php }else{?>
		STEP3. 에누리 할인 여부를 결정하시고 관리자 주문 생성을 완료하세요.
<?php }?>
	</div>

	<!-- 에누리/관리자주문알림/관리자메모 등-->
	<div>
		<table width="100%" class="info-table-style">
		<colgroup>
			<col width="15%" />
			<col width="15%" />
			<col />
		</colgroup>
		<tbody>
<?php if($TPL_VAR["ordertype"]=='person'){?>
		<tr>
			<th class="its-th-align center" colspan="2">개인결제타이틀 <span class="required"></span></th>
			<td class="its-td">
				<input type="text" name="title" size="50" value="" />
				<span class="desc">MY페이지 > ‘개인결제’ 메뉴에서 보여지는 문구입니다.</span>
			</td>
		</tr>
<?php }?>
		<tr>
			<th class="its-th-align center" colspan="2">에누리</th>
			<td class="its-td">
				<div class="hide" id="enuri_div">
					<input type="text" name="enuri" value="" class="onlyfloat" />
					<span class="btn small black"><button type="button" onclick="order_price_calculate();">적용</button></span>
				</div>
				<div class="hide enuri_div_none">
					에누리 적용 불가 (본상 상품만 선택하거나 단일 입점사 상품 선택시 에누리 가능)
				</div>
			</td>
		</tr>
<?php if($TPL_VAR["ordertype"]=='person'){?>
		<tr>
			<th class="its-th-align center" rowspan="5">개인결제 조건</th>
			<th class="its-th-align center">결제수단</th>
			<td class="its-td"><span class="desc">개인결제 시 구매자의 결제수단을 페이지 하단에서 체크 하세요.</span></td>
		</tr>
		<tr>
			<th class="its-th-align center">쿠폰사용</th>
			<td class="its-td"><span class="desc">개인결제 시 구매자가 보유한 쿠폰을 사용 하지 못함.</span></td>
		</tr>
		<tr>
			<th class="its-th-align center">코드사용</th>
			<td class="its-td"><span class="desc">개인결제 시 구매자가 보유한 코드를 사용 하지 못함.</span></td>
		</tr>
		<tr>
			<th class="its-th-align center">캐시 사용</th>
			<td class="its-td">
				<label><input type="radio" name="use_reserve" value="1" onclick="chgUseReserve(this);" /> 개인결제 시 구매자가 보유한 캐시를 사용 할 수 있음</label>
				<label><input type="radio" name="use_reserve" value="0" onclick="chgUseReserve(this);" checked /> 개인결제 시 구매자가 보유한 캐시를 사용 하지 못함</label>
			</td>
		</tr>
		<tr>
			<th class="its-th-align center">캐시 지급</th>
			<td class="its-td">
				<div class="use-reserve-lay hide">
				<ul>
					<li>개인결제 시</li>
					<li><label><input type="radio" name="reserve_limit" value="0" <?php if(!$TPL_VAR["cfg_reserve"]["default_reserve_limit"]){?>checked<?php }?> /> 캐시를 사용해도 실 결제금액 기준으로 조건 없이 지급 (권장)</label></li>
					<li><label><input type="radio" name="reserve_limit" value="3" <?php if($TPL_VAR["cfg_reserve"]["default_reserve_limit"]=='3'){?>checked<?php }?> /> 캐시를 사용하면 사용한 캐시를 제외한 결제금액을 기준으로  캐시 지급 (권장하지 않음)</label></li>
					<li><label><input type="radio" name="reserve_limit" value="2" <?php if($TPL_VAR["cfg_reserve"]["default_reserve_limit"]=='2'){?>checked<?php }?> /> 캐시를 사용하면 기대 캐시에서 사용한 캐시를 뺀 만큼만 적립 (권장하지 않음)</label></li>
					<li><label><input type="radio" name="reserve_limit" value="1" <?php if($TPL_VAR["cfg_reserve"]["default_reserve_limit"]=='1'){?>checked<?php }?> /> 캐시를 사용하면 캐시 지급하지 않음 (권장하지 않음)</label></li>
				</ul>
				</div>
				<div class="use-reserve-lay">
					<span class="desc">개인결제 시 실 결제금액 기준으로 지급</span>
				</div>
			</td>
		</tr>
<?php }?>
		<tr>
			<th class="its-th-align center" colspan="2">
<?php if($TPL_VAR["ordertype"]=='person'){?>
				개인결제 알림
<?php }else{?>
				관리자 주문 알림
<?php }?>
			</th>
			<td class="its-td">
<?php if($TPL_VAR["ordertype"]=='person'){?>
				<div><label><input type="checkbox" name="send_sms" value="Y" /> 개인결제 등록을 구매 요청자에게 알리겠습니다.</label></div>
				<input type="text" name="cellphone" value="휴대전화번호" class="line sms"  size="14" onclick="if(this.value == '휴대전화번호'){this.value='';}" />
				<input type="text" name="msg" class="line sms" value="개인결제가 등록되었습니다. 주문 요청 드립니다."  size="80" />
<?php }else{?>
				구매요청자 휴대전화번호 : <input type="text" name="cellphone" value="휴대전화번호" class="line sms"  size="14" onclick="if(this.value == '휴대전화번호'){this.value='';}" /> <label><input type="checkbox" name="send_sms" value="Y" /> 관리자 주문 등록을 구매 요청자에게 알리겠습니다.</label>
				<input type="text" name="msg" class="line sms" value="요청하신 주문서가 등록되었습니다. 결제 요청 드립니다."  size="80" />
<?php }?>
			</td>
		</tr>
		<tr>
			<th class="its-th-align center" style="border-bottom:0px;" colspan="2">관리자 메모</th>
			<td class="its-td" style="border-bottom:0px;" ><textarea name="admin_memo" style="width:98%;" rows="4"></textarea></td>
		</tr>
		</tbody>
		</table>
	</div>

	<!-- 주문상품 리스트-->
	<div class="settle_cart_list"></div>


	<!-- 최종결제금액/주문자정보-->
	<input type="hidden" name="order_post_number[]" value="" />
	<input type="hidden" name="order_zipcode[]" value="" />
	<input type="hidden" name="order_zipcode[]" value="" />
	<input type="hidden" name="order_address_type" value="" />
	<input type="hidden" name="order_address" value="" />
	<input type="hidden" name="order_address_street" value="" />
	<input type="hidden" name="order_address_detail" value="" />

	<!-- 최종결제금액 -->
	<input type="hidden" name="total_price" value="">
	<input type="hidden" name="total_price_temp" class="total_price_temp"  value="" />
	<span style="font-size:24px; font-family:tahoma;" class="settle_price hide" id="total_settle_price">0</span>

	<!-- 결제정보 / 개인정보 수집 동의 -->
	<div class="order_settle clearbox">
		<div class="benefit">
			<h4>결제정보</h4>
			<div class="list_inner">
				<!-- 결제정보입력 -->
<?php if($TPL_VAR["ordertype"]=='person'){?>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<col width="90" />
				<tr>
					<td>결제수단</td>
					<td class="fx12" style="letter-spacing:-1px">
<?php if($TPL_VAR["payment"]["bank"]){?>
						<label style="display:inline-block;width:70px"><input type="checkbox" name="payment[]" value="bank" /> 무통장</label>&nbsp;&nbsp;
<?php }?>
<?php if($TPL_VAR["payment"]["card"]){?>
						<label style="display:inline-block;width:80px"><input type="checkbox" name="payment[]" value="card" /> 카드결제</label>&nbsp;&nbsp;
<?php }?>
<?php if($TPL_VAR["payment"]["account"]){?>
						<label style="display:inline-block;width:100px"><input type="checkbox" name="payment[]" value="account" /> 실시간계좌이체</label>&nbsp;&nbsp;
<?php }?>
<?php if($TPL_VAR["payment"]["cellphone"]){?>
						<label style="display:inline-block;width:80px"><input type="checkbox" name="payment[]" value="cellphone" /> 핸드폰결제</label>&nbsp;&nbsp;
<?php }?>
<?php if($TPL_VAR["payment"]["virtual"]){?>
						<label style="display:inline-block;width:80px"><input type="checkbox" name="payment[]" value="virtual" /> 가상계좌</label>&nbsp;&nbsp;
<?php }?>
<?php if($TPL_VAR["payment"]["kakaopay"]){?>
						<label style="display:inline-block;width:80px"><input type="checkbox" name="payment[]" value="kakaopay" /> 카카오페이</label>&nbsp;&nbsp;
<?php }?>
<?php if($TPL_VAR["payment"]["paypal"]){?>
						<label style="display:inline-block;width:80px"><input type="checkbox" name="payment[]" value="paypal" /> 페이팔</label>&nbsp;&nbsp;
<?php }?>
<?php if($TPL_VAR["payment"]["eximbay"]){?>
						<label style="display:inline-block;width:80px"><input type="checkbox" name="payment[]" value="eximbay" /> 엑심페이</label>&nbsp;&nbsp;
<?php }?>
					</td>
				</tr>
				</table>
<?php }else{?>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<col width="90" />
				<tr>
					<td>일반 결제</td>
					<td class="fx12" style="letter-spacing:-1px">
						<label style="display:inline-block;width:70px"><input type="radio" name="payment" value="bank" checked/> 무통장</label>
					</td>
				</tr>
				<!-- 무통장 정보 입력줄 시작 -->
				<tr class="bank">
					<td></td>
					<td style="padding-top:15px;">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<col width="60" />
						<tr>
							<td>
								<span style="font-family:'arial black'; line-height:10px; ">·</span> 입금자명
							</td>
							<td><input type="text" name="depositor" value="" /></td>
						</tr>
						<tr><td height="4"></td></tr>
						<tr>
							<td>
								<span style="font-family:'arial black'; line-height:10px;">·</span> 입금은행
							</td>
							<td>
								<select name="bank">
									<option value="">은행선택</option>
<?php if($TPL_bank_1){foreach($TPL_VAR["bank"] as $TPL_V1){?>
<?php if($TPL_V1["accountUse"]=='y'){?>
									<option value="<?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["account"]?> 예금주:<?php echo $TPL_V1["bankUser"]?>"><?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["account"]?> 예금주:<?php echo $TPL_V1["bankUser"]?></option>
<?php }?>
<?php }}?>
								</select>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr ><td height="15"></td></tr>
				<tr id="typereceiptlay" class="">
					<td>매출증빙</td>
					<td class="fx12">
						<label for="typereceipt0"><input type="radio" name="typereceipt" id="typereceipt0" value="0" checked="checked" onclick="taxBill(0)"> 발급안함 </label>
						<label for="typereceipt2">	<input type="radio" name="typereceipt" id="typereceipt2" value="2" onclick="taxBill(2)"> 현금영수증 </label>
						<label for="typereceipt1">	<input type="radio" name="typereceipt" id="typereceipt1" value="1" onclick="taxBill(1)"> 세금계산서 </label>
					</td>
				</tr>
				</table>

				<!-- ~~~~~~~ 현금영수증 신청 부분 ~~~~~~~~~~~~~~~ -->
				<div id="cash_container" class="hide typereceiptlay" style="margin-top:15px;">
					<table width="100%" border="0">
						<tr>
							<td align="center">발행용도</td>
							<td>
								<label for="cuse0"><input type="radio" name="cuse"  id="cuse0"  value="0" checked="checked" onclick="cashBilltype(0)" />개인 소득공제용</label>
								<label for="cuse1"><input type="radio" name="cuse"  id="cuse1"  value="1" onclick="cashBilltype(1)"/>사업자지출 증빙용</label>
							</td>
						</tr>
						<tr>
							<td align="center">인증번호</td>
							<td>
								<div id="personallay"  >
								  휴대폰번호 <input type="text" name="creceipt_number[0]" class="line number" maxlength="13"/>(<span class="comment">"-" 없이 입력.</span>)
								</div>
								<div id="businesslay" class="hide" >
								 사업자번호 <input type="text" name="creceipt_number[1]" class="line number" maxlength="10"/>(<span class="comment">"-" 없이 입력</span>)
								</div>
							</td>
						</tr>
					</table>
				</div>
				<!-- ~~~~~~~ 세금계산서 신청 부분 ~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
				<div id="tax_container" class="hide typereceiptlay" style="padding-top:15px;">
					<table width="100%" border="0"  class="list_table_style">
						<tr>
							<td align="center">상호명</td>
							<td  class="fx12">
								<input type="text" name="co_name" id="co_name" value="" />
							</td>
						</tr>
						<tr>
							<td align="center">대표자</td>
							<td  class="fx12">
								<input type="text" name="co_ceo" id="co_ceo" value=""/>
							</td>
						</tr>
						<tr>
							<td align="center">업태/업종</td>
							<td  class="fx12">
								<input type="text" name="co_status" id="co_status" value=""/> -
								<input type="text" name="co_type" id="co_type" value=""/>
							</td>
						</tr>
						<tr>
							<td align="center">사업자번호</td>
							<td  class="fx12">
								<input type="text" name="busi_no" id="busi_no" value=""/> ex)123-12-12345
							</td>
						</tr>
						<tr>
							<td align="center">주소</td>
							<td class="fx12">
								<input type="text" name="co_new_zipcode" value="" size="10" />
								<span class="btn small"><button type="button" onclick="window.open('/popup/zipcode?mtype=co_&admin=y&adminzipcode=y','popup_zipcode','width=600,height=350')" >주소찾기</button></span> <br />
								<input type="hidden" name="co_address_type" id="co_address_type" size="40"  value=""/>
								(지번) <input type="text" name="co_address" id="co_address" size="40"  value=""/><br>
								(도로명) <input type="text" name="co_address_street" id="co_address_street" size="38" value=""/><br>
								(공통상세) <input type="text" name="co_address_detail" id="co_address" size="36"  value=""/>
							</td>
						</tr>
					</table>
				</div>
<?php }?>

			</div>
		</div>
		<div class="settle bgcolor">
			<ul class="agreement">
<?php if($TPL_VAR["policy"]&&$TPL_VAR["ordertype"]=='admin'){?>
				<li>
					<input type="checkbox" name="agree" id="agree" value="Y" />
					<label for="agree">(<span class="red">필수</span>) 개인정보 수집 및 이용 동의</label>
					<textarea class="textarea_disabled" style="width:95%; height:100px;" readonly><?php echo $TPL_VAR["policy"]?></textarea>
				</li>
				<!-- //개인정보 수집 및 이용 동의 -->
<?php }?>
<?php if(serviceLimit('H_AD')){?>
				<li>
					<input type="checkbox" name="agree2" id="agree2" value="Y" />
					<label for="agree2">(<span class="red">필수</span>) 개인정보 제3자 제공 동의</label>
					<textarea class="textarea_disabled" style="width:95%; height:100px;" readonly><?php echo $TPL_VAR["policy"]?></textarea>
				</li>
<?php }?>
				<!-- //개인정보 제3자 제공 동의 -->
<?php if($TPL_VAR["cancellation"]&&$TPL_VAR["ordertype"]=='admin'){?>
				<li>
					<input type="checkbox" name="cancellation" id="cancellation" value="Y" />
					<label for="cancellation">청약철회 관련방침에 동의합니다.</label>
					<textarea class="textarea_disabled" style="width:95%; height:100px;" readonly><?php echo $TPL_VAR["cancellation"]?></textarea>
				</li>
				<!-- //청약철회 관련방침 -->
<?php }?>
			</ul>
		</div>
		<!-- //약관동의 -->
	</div>

	<!--해외배송상품 개인통관 고유부호-->
	<div class="order_settle clearbox clearance_unique_personal_code" <?php if($TPL_VAR["ordertype"]=='admin'){?>hide<?php }?>">
		<div class="benefit">
			<h4>해외배송상품 개인통관 고유부호</h4>
			<div class="list_inner">
<?php if($TPL_VAR["ordertype"]=='person'){?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td style="position:relative;">
					<div class="translucent_disable_lay hide">
						<div class="translucent_disable_back" style="height:175px;"></div>
						<div class="translucent_disable_title_personal_code" style="top:75px;">개인통관 고유부호는 개인 결제 시 구매자께서 직접 입력하시게 됩니다.</div>
					</div>
				</td>
			</tr>
			</table>
<?php }?>
			<div style="padding:10px">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<col width="10" /><col width="40%" /><col width="50%" />
			<tr>
				<td>개인통관고유부호</td>
				<td class="fx12">
					<input type="text" name="clearance_unique_personal_code" value="" size="15" maxlength="13" />
				</td>
				<td>
					<table width="100%" border="0" cellpadding="0" cellspacing="3">
					<col width="10" />
					<tr>
						<td valign="top"><span style="font-family:'arial black'; line-height:10px; ">·</span></td>
						<td class="desc" style="color:#333;">
							P로 시작하는 개인통관고유부호를 입력하세요.
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr><td height="15" colspan="3"></td></tr>
			<tr>
				<td class="fx12" colspan="3">
					해외배송상품은 관세청 통관 신고를 위해 구매고객의 고유식별정보인 개인통관고유부호를 수집합니다.
				</td>
			</tr>
			<tr><td height="5" colspan="3"></td></tr>
			<tr>
				<td class="fx12" colspan="3">
					<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							개인통관고유부호는 통관 시 주문등록번호 대신 사용 가능한 번호로, 관세청 사이트에서 발급 받으실 수 있습니다.
						</td>
						<td style="padding-left:10px;">
							<img src="/admin/skin/default/images/common/btn_detail.gif" class="detailDescriptionLayerBtn hand" />
							<div class="detailDescriptionLayer hide">
								<div class="absolute">
									<table width="350px;" border="0" cellpadding="0" cellspacing="0" bgcolor="000000" >
									<tr>
										<td class="left pdl5" style="font-weight:bold; color:#fff; font-size:12px;" height="25">개인통관고유부호 발급안내</td>
										<td class="right pdr5 fx15"><span class='hand detailDescriptionLayerCloseBtn'>X</span></td>
									</tr>
									</table>
									<div style="padding:10px;line-height:18px;">
										<div>
											개인통관 고유부호는 해외배송 상품 통관 시 주민등록번호 대신<br/>
											사용 가능한 번호로, 관세청 사이트에서 발급 받으실 수 있습니다.
										</div>
										<div style="padding-top:10px;">
											<strong>개인통관고유부호 발급방법</strong><br/>
											1. 관세청 전자통관 사이트(https://p.customs.go.kr) 방문<br/>
											2. 사이트 상단에서 업무처리 메뉴 선택<br/>
											3. 좌측 메뉴에서 수입통관 메뉴 선택<br/>
											4. 좌측 메뉴에서 개인통관고유부호 항목 선택<br/>
											5. 본인 이름과 주민등록번호 입력 후 ‘확인’ 클릭<br/>
											6. 공인인증서 인증<br/>
											7. 주소, 전화번호, 휴대폰번호, 이메일 입력 후 최종 ‘등록’<br/>
											8. 개인통관고유부호 확인
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr><td height="15" colspan="3"></td></tr>
			<tr>
				<td class="fx12" colspan="3">
					<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							<label><input type="checkbox" name="agree_international_shipping1" value="y"> 해외배송상품의 수입신고를 위한 개인통관고유부호 수집에 동의합니다.</label>
						</td>
						<td style="padding-left:10px;">
							<img src="/admin/skin/default/images/common/btn_detail.gif" class="detailDescriptionLayerBtn hand" />
							<div class="detailDescriptionLayer hide">
								<div class="absolute">
									<table width="500px;" border="0" cellpadding="0" cellspacing="0" bgcolor="000000" >
									<tr>
										<td class="left pdl5" style="font-weight:bold; color:#fff; font-size:12px;" height="25">개인통관고유부호 수집</td>
										<td class="right pdr5 fx15"><span class='hand detailDescriptionLayerCloseBtn'>X</span></td>
									</tr>
									</table>
									<div style="padding:10px;line-height:18px;">
										<div>
											개인통관고유번호는 수입통관 업무처리를 위해 수집하며, 서비스 이용기간 동안 보관합니다.
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
					</table>
				</td>
			</tr>

			<tr><td height="5" colspan="3"></td></tr>
			<tr>
				<td class="fx12" colspan="3">
					<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							<label><input type="checkbox" name="agree_international_shipping2" value="y"> 해외배송상품의 수입신고를 위한 개인통관고유부호의 판매자 제공에 동의합니다.</label>
						</td>
						<td style="padding-left:10px;">
							<img src="/admin/skin/default/images/common/btn_detail.gif" class="detailDescriptionLayerBtn hand" />
							<div class="detailDescriptionLayer hide">
								<div class="absolute">
									<table width="500px;" border="0" cellpadding="0" cellspacing="0" bgcolor="000000" >
									<tr>
										<td class="left pdl5" style="font-weight:bold; color:#fff; font-size:12px;" height="25">개인통관고유부호 수집</td>
										<td class="right pdr5 fx15"><span class='hand detailDescriptionLayerCloseBtn'>X</span></td>
									</tr>
									</table>
									<div style="padding:10px;line-height:18px;">
										<div>
											개인통관고유번호는 수입통관 업무처리를 위해 수집하며, 서비스 이용기간 동안 보관합니다.
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
					</table>
				</td>
			</tr>

			<tr><td height="5" colspan="3"></td></tr>
			<tr>
				<td class="fx12" colspan="3">
					<span class="red">! 기재하신 개인통관 고유부호는 수입신고 목적 이외 사용되지 않습니다.</span><br/>
				</td>
			</tr>
			</table>
			</div>
			</div>
			
		</div>

	</div>

	<!-- 해외배송상품 관부가세 안내 --> 
	<div class="order_settle clearbox clearance_unique_personal_code" <?php if($TPL_VAR["ordertype"]=='admin'){?>hide<?php }?>">
		<div class="benefit">
			<h4>해외배송상품 관부가세 안내</h4>
			<div class="list_inner">
<?php if($TPL_VAR["ordertype"]=='person'){?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td style="position:relative;">
					<div class="translucent_disable_lay hide">
						<div class="translucent_disable_back" style="height:88px;;"></div>
						<div class="translucent_disable_title_personal_code" style="top:35px;">관부가세 발생 공지는 개인 결제 시 구매자께서 직접 확인하시게 됩니다.</div>
					</div>
				</td>
			</tr>
			</table>
<?php }?>
			<table width="100%" cellpadding="0" cellspacing="3">
			<tr>
				<td colspan="2">
				* 해외에서 제품을 구매하여 배송하는 상품의 경우 배송비는 상품 무게에 따라 결제 시 합산이 됩니다.
				</td>
			</tr>
			<tr>
				<td  colspan="2">
				* 배송비를 포함한 세관신고금액이 150,000원 이상일 경우 20~80%의 관부가세가 결제시 추가로 부과됩니다.
				</td>
			</tr>
			<tr>
				<td  colspan="2">
				* 타 구매대행 사이트에서 동일한 수취인 이름으로 주문했을 경우 통관일 기준7일까지 합산되어 통관시 관/부가세가 추가 부과 될 수 있으니 이점 주의해주십시오.
				</td>
			</tr>
			<tr>
				<td class="pdt5">
					<label>
						<input type="checkbox" name="agree_international_shipping3" value="y" /> 관부가세 발생 관련 공지를 확인하였습니다.
					</label>
				</td>
				<td class="pdt5" align="right">
				<a href="javascript:openDialog('해외구매대행 관련 안내', 'international_shipping_info', {'width':'500'}, '');">해외구매대행관련안내 자세히 보기 &gt;</a>
				</td>
			</tr>
			</table>
			</div>
		</div>
	</div>

	<!-- ### GIFT -->
	<div id="gift_list_lay"></div>
	<div id="optional_changes_dialog"></div>

	<div class="btn-bottom">
		<span class="btn large black"><button type="button" onclick="movePrevStep('3');">&lt; 이전 단계 </button></span>
		<span class="btn large cyanblue"><button type="button" onclick="adminPay();">주문하기</button></span>
		<span class="btn large cyanblue"><button type="button" onclick="$('#orderAdminSettle').dialog('close');">취소하기</button></span>
	</div>

	<br style="line-height:20px;" />
</div>
</form>


<script type="text/javascript">

</script>