<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/partner/naverpay2.1.html 000007216 */ ?>
<?php if($TPL_VAR["ISMOBILE_AGENT"]){?>
<?php if($TPL_VAR["navercheckout"]["use"]=='test'){?>
<script type="text/javascript" src="<?php echo $TPL_VAR["http_protocol"]?>://test-pay.naver.com/customer/js/mobile/naverPayButton.js" charset="UTF-8"></script>
<?php }else{?>
<script type="text/javascript" src="<?php echo $TPL_VAR["http_protocol"]?>://pay.naver.com/customer/js/mobile/naverPayButton.js" charset="UTF-8"></script>
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["navercheckout"]["use"]=='test'){?>
<script type="text/javascript" src="<?php echo $TPL_VAR["http_protocol"]?>://test-pay.naver.com/customer/js/naverPayButton.js" charset="UTF-8"></script>
<?php }else{?>
<script type="text/javascript" src="<?php echo $TPL_VAR["http_protocol"]?>://pay.naver.com/customer/js/naverPayButton.js" charset="UTF-8"></script>
<?php }?>
<?php }?>

<script type="text/javascript" >
	function naverpay_submit(mode,shippingType){

		loadingStart("",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});

		if(mode == "direct"){
			if (typeof check_option == 'function') {
				if( !check_option() ){
					return;
				}
			}
			var f = $("form[name='goodsForm']");
		}else{
			var f = $("form[name='cart_form']");
		}
		//f.attr("target","_blank");
		var msg = getAlert('os255');
		if(typeof msg == 'string'){
			msg = msg.trim();
		} else {
			msg = "";
		}
		if(msg==""){
			if(mode == "direct"){
				f.attr("action","../order/add?mode="+mode+"&order_mode=npay&skin_version=<?php echo $TPL_VAR["skin_version"]?>&no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>");
			}else{
				f.attr("action","../naverpay/buy?mode="+mode+"&shippingType="+shippingType+"&skin_version=<?php echo $TPL_VAR["skin_version"]?>");
			}
			f[0].submit();
		}else{
			//네이버페이 주문 시 제주/도서/산간/오지/일부 지역은 배송비가 추가 과금될 수 있습니다.주문하시겠습니까?
			openDialogConfirm(msg,400,155,function(){ //yesCallback function
				if(mode == "direct"){
					f.attr("action","../order/add?mode="+mode+"&order_mode=npay&skin_version=<?php echo $TPL_VAR["skin_version"]?>&no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>");
				}else{
					f.attr("action","../naverpay/buy?mode="+mode+"&shippingType="+shippingType+"&skin_version=<?php echo $TPL_VAR["skin_version"]?>");
				}
				f[0].submit();
				},function(){ //noCallback function
					return false;
				});
			}
	}

	function buy_nc(){

<?php if(!$TPL_VAR["goods"]["goods_seq"]){?>
		if($("input[name='cart_option_seq[]']:checked").length < 1){
			//네이버페이로 구매할 상품을 선택해 주세요.
			openDialogAlert(getAlert('os223'),450,140);
			return false;
		}
<?php }?>

		var pay_position	= "<?php if($TPL_VAR["goods"]["goods_seq"]){?>direct<?php }else{?>cart<?php }?>";

<?php if($TPL_VAR["skin_version"]=="multi"){?>

		var shipping_group	= "";
<?php if($TPL_VAR["goods"]["goods_seq"]){?>
		shipping_group	= $("select[name='shipping_method'] option:selected").val();
<?php }?>
		naverpay_submit(pay_position,shipping_group);

<?php }else{?>
<?php if(count($TPL_VAR["shipping_policy"]["shipping_method"])== 1){?>
<?php if(is_array($TPL_R1=$TPL_VAR["shipping_policy"]["shipping_method"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>naverpay_submit(pay_position,'<?php echo $TPL_K1?>');<?php }}?>
<?php }else{?>
		var w				= 400;
		var h				= 210;
		w = 500;
		openDialog('naverpay','naverpay_postpaid', {"width":w,"height":h});
<?php }?>
<?php }?>
	}

	function not_buy_nc(){
<?php if(strlen($TPL_VAR["not_buy_msg"])> 160){?> var h = 220;<?php }else{?>var h = 150;<?php }?>
		openDialogAlert("<?php echo $TPL_VAR["not_buy_msg"]?>",450,h);
	}

	function wishlist_nc(){

		// 네이버 체크아웃으로 찜 정보를 등록하는 가맹점 페이지 팝업 창 생성.
<?php if($TPL_VAR["goods"]["goods_seq"]){?>
			var f = $("form[name='goodsForm']");
<?php }else{?>
			var f = $("form[name='cart_form']");
			
			var chk_cnt = 0;
			var cart = document.getElementsByName("cart_option_seq[]");
			for(var i=0; i<cart.length; i++){
				if(cart[i].checked == true){
					chk_cnt = chk_cnt + 1;
				}
			}

			if(chk_cnt == 0){
				//찜 할 상품을 1개 이상 선택해 주세요
				alert(getAlert('os224'));
				return false;
			}
<?php }?>
		f.attr("action","../naverpay/zzim");

<?php if($TPL_VAR["ISMOBILE_AGENT"]){?>
		f.attr("target","_self");
<?php }else{?>
		window.open("/data/index.php","zzim","scrollbars=yes,width=400,height=267");
		f.attr("target","zzim");
<?php }?>
		f[0].submit();
		f.attr("target","actionFrame");
		f.attr("action","../order/add");
		return false;
	}
	// 장바구니 네이버페이 버튼 노출여부 2020-06-01 hyem
	$(document).ready( 
		function() {
			var npay_display = '<?php echo $TPL_VAR["npay_init"]?>';
			if(npay_display == 'hide') $('#nhn_btn').hide();
		}
	);
</script>

<div id="nhn_btn" style="margin-top:20px;text-align:center;">
<script type="text/javascript">

	//<![CDATA[
	var enable			= 'Y';
	var buy_npay		= buy_nc;
	var goods_status	= '';
	// 품절등과 같은 이유에 따라 버튼을 비활성화할 필요가 있을 경우
<?php if($TPL_VAR["not_buy_npay"]){?>
		enable		= 'N';
		buy_npay	= not_buy_nc;
		wishlist_nc	= not_buy_nc;
<?php }?>
	try{
		naver.NaverPayButton.apply({
			BUTTON_KEY:"<?php echo $TPL_VAR["navercheckout"]["button_key"]?>", // 네이버페이에서 할당받은 버튼 KEY 를 입력하세요.
			TYPE: "<?php echo $TPL_VAR["npay_btn"][ 0]?>", // 버튼 타입
			COLOR: <?php echo $TPL_VAR["npay_btn"][ 1]?>,  // 버튼 색
			COUNT: <?php echo $TPL_VAR["npay_btn"][ 2]?>,	// 버튼 개수 설정. 구매하기 버튼만 있으면 1, 찜하기 버튼과 함께 있으면 2를 입력한다.
			ENABLE: enable,			// 품절등과 같은 이유에 따라 버튼을 비활성화할 필요가 있을 경우
			BUY_BUTTON_HANDLER: buy_npay, // 구매하기 버튼 이벤트 Handler 함수 등록, 품절인 경우 not_buy_nc 함수 사용
			WISHLIST_BUTTON_HANDLER:wishlist_nc, // 찜하기 버튼 이벤트 Handler 함수 등록
			"":""
		});
	}catch(e){
	}
	//]]>
</script>

<?php if($TPL_VAR["navercheckout"]["use"]=='test'){?>
	<div style="color:red;line-height:20px;">※ 네이버 페이 2.1 테스트모드 입니다</div>
<?php }?>
</div>

<div id="naverpay_postpaid" class="center hide" style="border:1px solid #363636;">
<?php if($TPL_VAR["ISMOBILE_AGENT"]){?><br /><?php }?>배송비 결제 방법을 선택해주세요.<br /><br />
<?php if(is_array($TPL_R1=$TPL_VAR["shipping_policy"]["shipping_method"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
	<span class="btn large black"><input type="button" onclick="naverpay_submit('direct','<?php echo $TPL_K1?>');" value="<?php echo $TPL_V1?>" /></span>
<?php }}?>
	<div style="margin:15px;">
	<span class="btn large"><input type="button" onclick="closeDialog('naverpay_postpaid');" value="취소" /></span>
	</div>
</div>