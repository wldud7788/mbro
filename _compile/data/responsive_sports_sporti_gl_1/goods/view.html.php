<?php /* Template_ 2.2.6 2022/04/08 17:57:00 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/goods/view.html 000110669 */  $this->include_("showCategoryLight","snslinkurl","snsLikeButton","showNaverMileageButton","showCoupons","showNaverMapApi");
$TPL_icons_1=empty($TPL_VAR["icons"])||!is_array($TPL_VAR["icons"])?0:count($TPL_VAR["icons"]);
$TPL_images_1=empty($TPL_VAR["images"])||!is_array($TPL_VAR["images"])?0:count($TPL_VAR["images"]);
$TPL_shipping_set_1=empty($TPL_VAR["shipping_set"])||!is_array($TPL_VAR["shipping_set"])?0:count($TPL_VAR["shipping_set"]);
$TPL_ship_gl_list_1=empty($TPL_VAR["ship_gl_list"])||!is_array($TPL_VAR["ship_gl_list"])?0:count($TPL_VAR["ship_gl_list"]);
$TPL_additions_1=empty($TPL_VAR["additions"])||!is_array($TPL_VAR["additions"])?0:count($TPL_VAR["additions"]);
$TPL_mapArr_1=empty($TPL_VAR["mapArr"])||!is_array($TPL_VAR["mapArr"])?0:count($TPL_VAR["mapArr"]);
$TPL_bigdata_1=empty($TPL_VAR["bigdata"])||!is_array($TPL_VAR["bigdata"])?0:count($TPL_VAR["bigdata"]);
$TPL_event_banner_1=empty($TPL_VAR["event_banner"])||!is_array($TPL_VAR["event_banner"])?0:count($TPL_VAR["event_banner"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 상품 상세 @@
- 파일위치 : [스킨폴더]/goods/view.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<?php echo $TPL_VAR["is_file_facebook_tag"]?>


<script type="text/javascript">
	var gl_goods_price = 0;
	var gl_event_sale_unit = 0;
	var gl_cutting_sale_price = 0;
	var gl_cutting_sale_action = "<?php echo $TPL_VAR["config_system"]["cutting_sale_action"]?>";
	var gl_multi_discount_use 	= "<?php echo $TPL_VAR["goods"]["multi_discount_use"]?>";
	var gl_multi_discount_unit = "<?php echo $TPL_VAR["goods"]["multi_discount_unit"]?>";
	var gl_multi_discount 		= 0;
	var gl_multi_discount_ea 	= 0;
	var gl_option_view_type = "<?php echo $TPL_VAR["goods"]["option_view_type"]?>";
	var gl_options_count = <?php echo count($TPL_VAR["options"])?>;
	var gl_opttag = '<tr class="quanity_row">';
	var gl_min_purchase_limit = '<?php echo $TPL_VAR["goods"]["min_purchase_limit"]?>';
	var gl_min_purchase_ea = 0;
	var gl_max_purchase_limit = '<?php echo $TPL_VAR["goods"]["max_purchase_limit"]?>';
	var gl_max_purchase_ea = 0;
	var gl_member_seq = "<?php echo $TPL_VAR["sessionMember"]["member_seq"]?>";
	var gl_request_uri = "<?php echo urlencode($_SERVER["REQUEST_URI"])?>";
	var gl_goods_seq = 0;
	var gl_option_divide_title_count = <?php echo count($TPL_VAR["goods"]["option_divide_title"])?>;
	var gl_skin = "<?php echo $TPL_VAR["skin"]?>";
	var gl_string_price_use = "";
	var gl_string_button_use = "";

<?php if(is_array($TPL_VAR["options_n0"])){?>
	var gl_option_n0 = <?php echo json_encode($TPL_VAR["options_n0"])?>;
<?php }?>

<?php if(is_array($TPL_VAR["gl_options_join"])){?>
	var gl_options_join = <?php echo json_encode($TPL_VAR["options_join"])?>;
<?php }?>

<?php if($TPL_VAR["goods"]["price"]){?>
	gl_goods_price = <?php echo $TPL_VAR["goods"]["sale_price"]?>;
<?php }?>
<?php if($TPL_VAR["goods"]["event"]["event_sale_unit"]){?>
	gl_event_sale_unit = <?php echo $TPL_VAR["goods"]["event"]["event_sale_unit"]?>;
<?php }?>
<?php if(is_numeric($TPL_VAR["config_system"]["cutting_sale_price"])&&$TPL_VAR["config_system"]["cutting_sale_use"]!='none'){?>
	gl_cutting_sale_price = <?php echo $TPL_VAR["config_system"]["cutting_sale_price"]?>;
<?php }?>
<?php if($TPL_VAR["goods"]["multi_discount"]){?>
	gl_multi_discount 		= <?php echo $TPL_VAR["goods"]["multi_discount"]?>;
<?php }?>
<?php if($TPL_VAR["goods"]["multi_discount_ea"]){?>
	gl_multi_discount_ea 	= <?php echo $TPL_VAR["goods"]["multi_discount_ea"]?>;
<?php }?>
<?php if($TPL_VAR["goods"]["min_purchase_ea"]){?>
	gl_min_purchase_ea = <?php echo $TPL_VAR["goods"]["min_purchase_ea"]?>;
<?php }?>
<?php if($TPL_VAR["goods"]["max_purchase_ea"]){?>
	gl_max_purchase_ea = <?php echo $TPL_VAR["goods"]["max_purchase_ea"]?>;
<?php }?>
<?php if($TPL_VAR["goods"]["goods_seq"]){?>
	gl_goods_seq = <?php echo $TPL_VAR["goods"]["goods_seq"]?>;
<?php }?>
<?php if($TPL_VAR["goods"]["string_price_use"]){?>
	gl_string_price_use = <?php echo $TPL_VAR["goods"]["string_price_use"]?>;
<?php }?>
<?php if($TPL_VAR["goods"]["string_button_use"]){?>
	gl_string_button_use = <?php echo $TPL_VAR["goods"]["string_button_use"]?>;
<?php }?>


	/*
	var PlusMobileTaps = {};
	PlusMobileTaps.hiddenTab = $('<div>').appendTo(document.body).css({position:'fixed',top:0,left:0,width:'100%',height:0,zIndex:999});

	PlusMobileTaps.tabFlyingmode = function(type) {
		if( type && !$('#goods_contents_quick').hasClass('flyingMode') ){
			$('#goods_contents_quick').css('padding-top',$('#goods_title_bar').height()).addClass('flyingMode');
			$('#goods_tabs').css('top',$('#goods_title_bar').height()).appendTo(PlusMobileTaps.hiddenTab);
		}else if( !type && $('#goods_contents_quick').hasClass('flyingMode') ){
			$('#goods_contents_quick').removeClass('flyingMode').css('padding-top',0);
			$('#goods_contents_quick').prepend( $('#goods_tabs').css('top',$('#goods_title_bar').height()) );
		}
	}

	PlusMobileTaps.scrollTabsFunc = function() {
		var sc = $(window).scrollTop(),
			headerH = $('#goods_title_bar').height(),
			detailtabH = $('#goods_tabs').height(),
			contH = parseInt($('.event_datetime').height()+$('#goods_view_quick').height());
		if(sc == 0 && contH == 0)	$('#goods_tabs').hide();
		else						$('#goods_tabs').show();
		if( sc > headerH ){
			$('#goods_title_bar').addClass('flyingMode');
		}else{
			$('#goods_title_bar').removeClass('flyingMode');
		}

		if( sc < contH ){
			PlusMobileTaps.tabFlyingmode(false);//해더타이틀 숨김
		}else{
			PlusMobileTaps.tabFlyingmode(true);
		}
	}
	*/

	var get_preload_func = function(){
		$.ajax({
			url: "/goods/view_contents?no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&zoom=1&view_preload=1",
			type: "get",
			success : function(e){
				$('.goods_view_contents').html(e);
			}
		});
	};

	var get_commonpreload_func = function(){
		$.ajax({
			url: "/goods/view_common_contents?no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&zoom=1&view_preload=1",
			type: "get",
			success : function(e){
				$('.goods_common_contents').html(e);
			}
		});
	};

	$(document).ready(function(){
		/*
		if	(window.location.hash == '#goods_review') {
			$('#goods_review_frame,#goods_qna_frame').load(function(){
				$('.goods_information_tabs li:eq(1)').click();
				$('html,body').animate({scrollTop:$('html,body').height()+500},'fast');
			});
		}
		*/

		setSlideSwipe('.slides_wrap', '.main_tabs_contents', 'resimg_num');

<?php if($TPL_VAR["eventEnd"]){?>
		timeInterval<?php echo $TPL_VAR["goods"]["goods_seq"]?> = setInterval(function(){
			var time<?php echo $TPL_VAR["goods"]["goods_seq"]?> = showClockTime('text', '<?php echo $TPL_VAR["eventEnd"]["year"]?>', '<?php echo $TPL_VAR["eventEnd"]["month"]?>', '<?php echo $TPL_VAR["eventEnd"]["day"]?>', '<?php echo $TPL_VAR["eventEnd"]["hour"]?>', '<?php echo $TPL_VAR["eventEnd"]["min"]?>', '<?php echo $TPL_VAR["eventEnd"]["second"]?>', 'soloday', 'solohour', 'solomin', 'solosecond', '<?php echo $TPL_VAR["goods"]["goods_seq"]?>');
			var time_tmp = showClockTime('text', '<?php echo $TPL_VAR["eventEnd"]["year"]?>', '<?php echo $TPL_VAR["eventEnd"]["month"]?>', '<?php echo $TPL_VAR["eventEnd"]["day"]?>', '<?php echo $TPL_VAR["eventEnd"]["hour"]?>', '<?php echo $TPL_VAR["eventEnd"]["min"]?>', '<?php echo $TPL_VAR["eventEnd"]["second"]?>', 'soloday<?php echo $TPL_VAR["goods"]["goods_seq"]?>', 'solohour<?php echo $TPL_VAR["goods"]["goods_seq"]?>', 'solomin<?php echo $TPL_VAR["goods"]["goods_seq"]?>', 'solosecond<?php echo $TPL_VAR["goods"]["goods_seq"]?>', '<?php echo $TPL_VAR["goods"]["goods_seq"]?>');
			if(time<?php echo $TPL_VAR["goods"]["goods_seq"]?> == 0){
				clearInterval(timeInterval<?php echo $TPL_VAR["goods"]["goods_seq"]?>);
				//단독이벤트가 종료되었습니다.
				alert(getAlert('gv002'));
				document.location.reload();
			}
		},1000);
<?php }?>

		$("select[name='viewOptions[]']").last().bind("change",function(){
			gl_opttag = '<td class="quantity_cell option_text">';
<?php if(is_array($TPL_R1=$TPL_VAR["options"][ 0]["option_divide_title"])&&!empty($TPL_R1)){$TPL_S1=count($TPL_R1);foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
			var opt = $(this).find('option:selected').attr('opt<?php echo $TPL_K1+ 1?>');
			if(!opt) return false;
			gl_opttag += '	<?php echo $TPL_V1?> : '+opt+'<input type="hidden" name="option[<?php echo $TPL_K1?>][]" value="'+opt+'" />';
			gl_opttag += '<input type="hidden" name="optionTitle[<?php echo $TPL_K1?>][]" value="<?php echo $TPL_V1?>" />';
<?php if($TPL_S1!=$TPL_K1+ 1){?>
			gl_opttag += '<br />';
<?php }?>
<?php }}?>
		});

		// 관련상품 옵션/수량변경 클릭시
		$("button.btn_option_modify").bind("click",function() {
			var id	= $(this).attr("id");
			option_open(id);
		});

		// 관련상품 장바구니 클릭시
		$("button.goodscart").bind("click",function() {
			var id	= $(this).attr("id");
			id = id.replace("goodscart_","");

			if($("div#optional_changes_area_"+id).html() == ""){
				option_open(id);
			}else{
				if(check_option(this)){
					$("#optional_changes_form_"+id).submit();
				}
			}
		});

<?php if($TPL_VAR["wish_seq"]){?>
			$('#wishimg').css('background-image','url(/data/skin/responsive_sports_sporti_gl_1/images/design/ico_wish_on.png)');
			$('#wishimg').attr('usewish','y');
<?php }?>

		// 상품이미지 페이징
		if($("#goods_thumbs_paging").length){
			var thumbs_max_page = parseInt('<?php echo count($TPL_VAR["images"])?>');
			$("#goods_thumbs_paging").customMobilePagination({
				'style' : 'paging_style_5',
				'now_page' : 1,
				'max_page' : thumbs_max_page,
				'btn_auto_hide' : false,
				'on_prev' : function(){
					var idx = parseInt($("#goods_thumbs_paging").attr('idx'));
					var newidx = idx==0?thumbs_max_page-1:idx-1;
					resimg_num(newidx);
				},
				'on_next' : function(){
					var idx = parseInt($("#goods_thumbs_paging").attr('idx'));
					var newidx = idx==thumbs_max_page-1?0:idx+1;
					resimg_num(newidx);
				},
			});
		}


		$("img[data-original]").lazyload();

		/* 상품상세 - 상품설명 탭(대쉬보드) */
		/*
		  $(document).on('on',PlusMobileTaps.scrollTabsFunc);
		  $(document).on('scroll',PlusMobileTaps.scrollTabsFunc);
		  $(document).on('touchmove',PlusMobileTaps.scrollTabsFunc);
		*/

<?php if($TPL_VAR["preload"]){?>
			$(".set_preload").one('inview',get_preload_func);
<?php }?>

<?php if($TPL_VAR["commonpreload"]){?>
			$(".set_preload").one('inview',get_commonpreload_func);
<?php }?>

		/* 스킨 변경 하게 되면 해당 부분 붙여넣기 필요 by 김혜진 */
			//var shipping_set_seq = $("select[name='shipping_method'] option:selected").val();
			//getShippingInfo(shipping_set_seq);

			/* #20936 2018-09-27 ycg 네이버페이 배송옵션 변경 이벤트 수정 - 시작 */
<?php if($TPL_VAR["navercheckout_tpl"]){?>
			/*var npay =  $("select[name='shipping_method'] option:selected").attr('npay');
			if(npay=='Y'){
				$(".npay_area").show();
				$(".goods_npay").show();
			}else{
				$(".npay_area").hide();
				$(".goods_npay").hide();
			}*/
<?php }?>
			/* #20936 2018-09-27 ycg 네이버페이 배송옵션 변경 이벤트 수정 - 종료 */
		});

	// 티켓상품 지도변경 버튼 :: 2014-04-02 lwh
	function setMapajax(){
		var option_seq	= $("#option_location option:selected").val();
		var goods_seq	= $("#option_location option:selected").attr('goods_seq');

		$.ajax({
				type: "post",
				url: "../goods/coupon_location_ajax",
				data: {'option_seq':option_seq, 'goods_seq':goods_seq, 'width':'300'},
				success: function(result){
					$("#NaverMap").html('');
					$("#map_area").html(result);
				}
			});
	}

	function detail_contents_toggle(btn,contents){
		if($("#"+contents).is(":hidden")){
			$("#"+contents).show();
			if($(btn).is('.btn_open_small')) $(btn).addClass('btn_close_small');
		}else{
			$("#"+contents).hide();
			if($(btn).is('.btn_close_small')) $(btn).removeClass('btn_close_small');
		}
	}

	// 배송정보 변경 :: 2016-07-15 lwh
	function view_delivery_cost(){
		// 희망배송일 레이어 닫기 및 초기화
		$(".hopCalendarLayer").hide();
		$("#hop_select_date").val('');

		var set_seq = $("select[name='shipping_method']").val();
		var prepay_info = $("select[name='shipping_method'] option:selected").attr('prepay_info');
		var hop_date = $("select[name='shipping_method'] option:selected").attr('hop_date');

		// 배송비 결제 정보
		if(prepay_info == 'delivery' || prepay_info == 'all'){
			$("#shipping_prepay_info").val('delivery');
		}else{
			$("#shipping_prepay_info").val('postpaid');
		}
		if	(prepay_info)	chg_prepayinfo(prepay_info);			// 선착불 변경
		if	(hop_date)		$("#hop_select_date").val(hop_date);	// 희망배송일 자동지정

		$(".set_lay").hide();
		$(".shipping_set_area").find(".set_"+set_seq).show();

		//getShippingInfo(set_seq);
	}

	// 자세히보기 배송비 안내에서 배송정보 변경 :: 2016-08-10 lwh
	function chg_delivery_info(ship_set_seq,store_seq,prepay_info){
		$("select[name='shipping_method']").val(ship_set_seq).trigger('change');
		if (prepay_info){
			$("#shipping_prepay_info").val(prepay_info);
			chg_prepayinfo(prepay_info);
		}
		if(store_seq)		$("#shipping_store_seq").val(store_seq);
		closeDialog('shipping_detail_lay');
	}

	// 선착불 여부 변경
	function chg_prepayinfo(prepay_info){
		// 배송비 결제 정보
		var res_msg	= '';
		var msg		= getAlert('sy004') == undefined ? '선불' : getAlert('sy004');
		var msg2	= getAlert('sy003') == undefined ? '착불' : getAlert('sy003');

		if			(prepay_info == 'all'){
			$("#shipping_prepay_info").val('delivery'); // 선불
			res_msg = msg;
		}else if	(prepay_info == 'delivery'){
			$("#shipping_prepay_info").val('delivery'); // 선불
			res_msg = msg;
		}else if	(prepay_info == 'postpaid'){
			$("#shipping_prepay_info").val('postpaid'); // 착불
			res_msg = msg2;
		}

		var selected_method = $("select[name='shipping_method'] option:selected").attr('prepay_info');
		if(selected_method == 'all'){
			// 선택 배송 결제 방법 색상 처리 :: 2019-01-30 lwh
			var sel_prepay_info = $("#shipping_prepay_info").val();
			$('.prepay_info_area').removeClass('on');
			$('.prepay_info_'+sel_prepay_info).addClass('on');
			$("#shipping_prepay_txt").html('('+res_msg+')');
		}else{
			$("#shipping_prepay_txt").html('');
		}

		var shipping_set_code = $("select[name='shipping_method'] option:selected").attr('shipping_set_code');
		if(shipping_set_code == 'direct_store'){
			$("#shipping_prepay_txt").html('');
		}
	}

	// 컬러 옵션 클릭시 상품상세컷 연결 leewh
	function clickSelectColor(color) {
		$("img[id^=dot_]").each(function(){
			if ($(this).attr('color')==color) {
					$(this).trigger("click");
					return false;
			}
		});
	}

	function resimg_num(i){
		var slide_current = $(".slides_wrap").data('slide_current');
		$('.main_tabs_contents').eq(slide_current).removeClass('active');
		$('.main_tabs_contents').eq(i).addClass('active').show();
		var k=0;
		$('.main_tabs_contents').each(function(){
			if(i == k) $(this).show();
			else $(this).hide();
			k = k + 1;
		});
		$(".slides_wrap").data('slide_current',i);

		$("#goods_thumbs_paging").attr('idx',i);
		$("#goods_thumbs_paging .paging_btn_num_now").html(parseInt(i)+1);
	}

	var old_id = "";
	function option_open(id){
		var url = "recently_option?no="+id;
		var area_obj = $("div#optional_changes_area_"+id);

		// 닫기 옵션
		if(old_id == id){ $(".optional_area").slideUp(500); old_id = ""; $(".optional_area").html(""); return; }
		else			{ $(".optional_area").slideUp(500); $(".optional_area").html(""); }

		$.get(url, function(data) {
			area_obj.html(data);
			area_obj.slideDown(500);
			old_id = id;
		});
	}

	var alert_timer = null;
	function wish_chg(){
		if(!gl_member_seq){
			//회원만 사용가능합니다.\n로그인하시겠습니까?
			if(confirm(getAlert('gv009'))){
				var url = "/member/login?return_url=<?php echo $_SERVER['REQUEST_URI']?>";
				top.document.location.href = url;
				return;
			}else{
				return;
			}
		}
		$.ajax({
			'url' : $('#wishimg').attr('usewish') == 'n' ? '/mypage/wish_add?seqs[]=<?php echo $TPL_VAR["goods"]["goods_seq"]?>' : '/mypage/wish_del?seqs=<?php echo $TPL_VAR["goods"]["goods_seq"]?>',
			'type' : 'get',
			'success' : function(res){
				if($('#wishimg').attr('usewish') == 'n'){
					//$('#wishimg').attr('src','/data/skin/responsive_sports_sporti_gl_1/images/design/ico_wish_on.png');
					$('#wishimg').css('background-image','url(/data/skin/responsive_sports_sporti_gl_1/images/design/ico_wish_on.png)');
					$('#wishimg').attr('usewish','y');
					$("#wish_alert .wa_on").show();
					$("#wish_alert .wa_off").hide();
					//위시리스트에<br />저장되었습니다.
					$("#wish_alert .wa_msg").html(getAlert('gv056'));

				}else{
					//$('#wishimg').attr('src','/data/skin/responsive_sports_sporti_gl_1/images/design/ico_wish_off.png');
					$('#wishimg').css('background-image','url(/data/skin/responsive_sports_sporti_gl_1/images/design/ico_wish_off.png)');
					$('#wishimg').attr('usewish','n');
					$("#wish_alert .wa_on").hide();
					$("#wish_alert .wa_off").show();
					//위시리스트에서<br />삭제되었습니다.
					$("#wish_alert .wa_msg").html(getAlert('gv057'));
				}
				$("#wish_alert").stop(true,true).show();

				clearInterval(alert_timer);
				alert_timer = setInterval(function(){
					clearInterval(alert_timer);
					$("#wish_alert").stop(true,true).show().fadeOut('slow');
				},1000);
			}
		});
	}

	function share_chg() {
		var originStyle = document.getElementById("btnSnsShare");
		var subStyle = document.getElementById("snsListDetail");

		if (subStyle.style.display = 'none') {
			subStyle.style.display = 'block';
		} else {
			subStyle.style.display = 'none';
		}

		$('#btnSnsShare').click(function() {
			if ( $('#snsListDetail').is(':hidden') ) {
				$('#snsListDetail').show();
			} else {
				$('#snsListDetail').hide();
			}
		});

	}
</script>
<script type="text/javascript" src='/data/skin/responsive_sports_sporti_gl_1/common/minishop.js'></script>
<script type="text/javascript" src="/app/javascript/js/goods-view.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/lazy/jquery.lazyload.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.inview.js"></script>

<style type="text/css">
@media only screen and (max-width:767px) {
	/* 플로팅 - BACK/TOP(대쉬보드) */
	#floating_over .ico_floating_back {bottom:73px !important;}
	#floating_over .ico_floating_top {bottom:73px !important;}
	#floating_over .ico_floating_foward {bottom:73px !important;}
	#floating_over .ico_floating_zoom {bottom:115px !important;}
}
</style>


<?php if(!$_GET["quickview"]){?>
<!-- 현재 상품의 카테고리 라인맵( 스킨단에서 html 수정 불가. CSS로만 수정하세요. ) -->
<?php echo showCategoryLight($TPL_VAR["goods"]["category_code"][count($TPL_VAR["goods"]["category_code"])- 1])?>

<?php }?>

<!-- 타이틀 -->
<div class="detail_title_area">
	<h3 class="name"><?php echo $TPL_VAR["goods"]["goods_name"]?></h3>
	<p class="summary">
		<?php echo $TPL_VAR["goods"]["summary"]?>

		<span class="detail_icons">
<?php if($TPL_icons_1){foreach($TPL_VAR["icons"] as $TPL_V1){?>
			<img src="/data/icon/goods/<?php echo $TPL_V1["codecd"]?>.gif" alt="">
<?php }}?>
		</span>
	</p>
	<p class="seq_num Hide">상품번호 : <?php echo $TPL_VAR["goods"]["goods_seq"]?></p>
</div>

<div id="goods_view">
	<div class="goods_thumbs_spec">
		<!-- ++++++++++++++++++++++++ 상품 이미지 ++++++++++++++++++++++++ -->
		<style>

			#goods_thumbs { width:<?php echo $TPL_VAR["goodsImageSize"]["view"]["width"]?>px; }
<?php if($TPL_VAR["goodsImageSize"]["view"]["width"]< 500){?>
			#goods_thumbs { width:40%; }
<?php }?>
<?php if($TPL_VAR["goodsImageSize"]["view"]["width"]> 800){?>
			#goods_thumbs { width:800px; }
<?php }?>
<?php if($TPL_VAR["goodsImageSize"]["view"]["width"]> 600){?>
			@media only screen and (max-width:1279px) {
				#goods_thumbs { width:60%; }
			}
<?php }?>

			/* 감싸는 div */

			.wrap {
				position: relative;
				width: 500px;
				margin: 0 auto;
			}
			/* 확대될 타겟이미지*/
			.target {
				display: block;
				width: 100%;
			}
			/* 돋보기 */
			/*
			.magnifier {
				width: 150px;
				height: 150px;
				position: absolute;
				border-radius: 100%;
				box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.85), 0 0 3px 3px rgba(0, 0, 0, 0.25);
				display: none;
				z-index: 999;
			}*/
		</style>
		<script>
			window.onload = function(){
				var target = $('.target');
				var zoom = target.data('zoom');

				$(".wrap")
						.on('mousemove', magnify)
						.prepend("<div class='magnifier'></div>")
						.children('.magnifier').css({
					"background": "url('" + target.attr("src") + "') no-repeat",
					"background-size": target.width() * zoom + "px " + target.height() * zoom+ "px"
				});

				var magnifier = $('.magnifier');

				function magnify(e) {

					// 마우스 위치에서 .magnify의 위치를 차감해 컨테이너에 대한 마우스 좌표를 얻는다.
					var mouseX = e.pageX - $(this).offset().left;
					var mouseY = e.pageY - $(this).offset().top;

					// 컨테이너 밖으로 마우스가 벗어나면 돋보기를 없앤다.
					if (mouseX < $(this).width() && mouseY < $(this).height() && mouseX > 0 && mouseY > 0) {
						magnifier.fadeIn(100);
					} else {
						magnifier.fadeOut(100);
					}

					//돋보기가 존재할 때
					if (magnifier.is(":visible")) {

						// 마우스 좌표 확대될 이미지 좌표를 일치시킨다.
						var rx = -(mouseX * zoom - magnifier.width() /2 );
						var ry = -(mouseY * zoom - magnifier.height() /2 );

						//돋보기를 마우스 위치에 따라 움직인다.
						//돋보기의 width, height 절반을 마우스 좌표에서 차감해 마우스와 돋보기 위치를 일치시킨다.
						var px = mouseX - magnifier.width() / 2;
						var py = mouseY - magnifier.height() / 2;

						//적용
						magnifier.css({
							left: px,
							top: py,
							backgroundPosition: rx + "px " + ry + "px"
						});
					}
				}
			};
		</script>
		<!-- 상품 대표 이미지 나오는 부분 by 김혜진 -->
		<div id="goods_thumbs" class="wrap">
			<div class="slides_container hide" style="position:relative;">
<?php if($TPL_images_1){foreach($TPL_VAR["images"] as $TPL_V1){?>
<?php if($TPL_V1["view"]["image"]){?>
					<div class="viewImgWrap">
<?php if($TPL_V1["view"]["image_type"]=='video'){?>
<?php if($TPL_VAR["is_mobile_agent"]){?>
							<iframe src="<?php echo $TPL_V1["view"]["image"]?>" width="<?php if($TPL_VAR["goods"]["video_size_mobile0"]){?><?php echo $TPL_VAR["goods"]["video_size_mobile0"]?><?php }else{?>100%<?php }?>" height="<?php if($TPL_VAR["goods"]["video_size_mobile1"]){?><?php echo $TPL_VAR["goods"]["video_size_mobile1"]?><?php }else{?>250<?php }?>" frameborder="0"></iframe>
<?php }else{?>
							<iframe src="<?php echo $TPL_V1["view"]["image"]?>" width="<?php if($TPL_VAR["goods"]["video_size0"]){?><?php echo $TPL_VAR["goods"]["video_size0"]?><?php }else{?>100%<?php }?>" height="<?php if($TPL_VAR["goods"]["video_size1"]){?><?php echo $TPL_VAR["goods"]["video_size1"]?><?php }else{?>300<?php }?>" frameborder="0"></iframe>
<?php }?>
<?php }else{?>
							<img class="target" data-zoom="3" src="<?php echo $TPL_V1["view"]["image"]?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl_1/images/common/noimage_wide.gif'" title="<?php echo $TPL_V1["large"]["label"]?>" <?php if($TPL_VAR["goods_view_image_alt"]){?>alt="<?php echo $TPL_VAR["goods_view_image_alt"]?>"<?php }?>/>
<?php }?>
					</div>
<?php }?>
<?php }}?>
				<a id="btn_zoom_view" href="javascript:popup('zoom?no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&popup=1',<?php echo ($TPL_VAR["goodsImageSize"]["large"]["width"]+ 17)?>, document.body.clientHeight,'yes')">확대 보기</a>
			</div>

<?php if(count($TPL_VAR["images"])> 1){?>
			<div class="pagination_wrap">
				<div class="count">
					<a href="javascript:void(0)" class="prev" title="이전"></a>
					<div class="pagination_area">
						<ul class="pagination">
<?php if($TPL_images_1){foreach($TPL_VAR["images"] as $TPL_V1){?>
<?php if($TPL_V1["thumbView"]["image"]){?>
							<li><a href="javascript:void(0)"><img src="<?php echo $TPL_V1["thumbView"]["image"]?>" width="<?php echo $TPL_VAR["goodsImageSize"]["thumbView"]["width"]?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl_1/images/common/noimage_list.gif'" <?php if($TPL_V1["thumbView"]["match_color"]){?> color="<?php echo $TPL_V1["thumbView"]["match_color"]?>"<?php }?> /></a></li>
<?php }?>
<?php }}?>
						</ul>
					</div>
					<a href="javascript:void(0)" class="next" title="다음"></a>
				</div>
			</div>
<?php }?>
			<script type="text/javascript">
				//$("#goods_thumbs .pagination").hide().width('<?php echo $TPL_VAR["goodsImageSize"]["view"]["width"]- 60?>').show();
				var setGoodsThumbsPaginationScroll = function(){
					var paginationWidth = $("#goods_thumbs .pagination").width();
					var currentWidth = $("#goods_thumbs .pagination>li.current").outerWidth();
					var currentLeft = $("#goods_thumbs .pagination>li.current").position().left;

					var gap = ($("#goods_thumbs .pagination").scrollLeft()+currentLeft+(currentWidth/2))-(paginationWidth/2);

					$("#goods_thumbs .pagination").stop(true,true).animate({'scrollLeft':gap});
				};
				$("#goods_thumbs .slides_container>.viewImgWrap:gt(0)").hide();
				$("#goods_thumbs .pagination>li:eq(0)").addClass('current');
				$("#goods_thumbs .slides_container").show();
				$("#goods_thumbs .pagination>li").bind('click',function(){
					var i = $("#goods_thumbs .pagination>li").index(this);
					$("#goods_thumbs .slides_container>.viewImgWrap").hide().eq(i).show();
					$("#goods_thumbs .pagination>li").removeClass('current').eq(i).addClass('current');
					setGoodsThumbsPaginationScroll();
					return false;
				});
				$("#goods_thumbs .prev").bind('click',function(){
					var i = $("#goods_thumbs .slides_container>.viewImgWrap").index($("#goods_thumbs .slides_container>.viewImgWrap:visible"));
					if(i<=0) i = $("#goods_thumbs .slides_container>.viewImgWrap").length-1;
					else i--;
					$("#goods_thumbs .slides_container>.viewImgWrap").hide().eq(i).show();
					$("#goods_thumbs .pagination>li").removeClass('current').eq(i).addClass('current');
					setGoodsThumbsPaginationScroll();
					return false;
				});
				$("#goods_thumbs .next").bind('click',function(){
					var i = $("#goods_thumbs .slides_container>.viewImgWrap").index($("#goods_thumbs .slides_container>.viewImgWrap:visible"));
					if(i>=$("#goods_thumbs .slides_container>.viewImgWrap").length-1) i = 0;
					else i++;
					$("#goods_thumbs .slides_container>.viewImgWrap").hide().eq(i).show();
					$("#goods_thumbs .pagination>li").removeClass('current').eq(i).addClass('current');
					setGoodsThumbsPaginationScroll();
					return false;
				});
			</script>
		</div>
		<!-- ++++++++++++++++++++++++ //상품 이미지 ++++++++++++++++++++++++ -->


		<!-- ++++++++++++++++++++++++ 상품 스펙 ++++++++++++++++++++++++ -->
		<div id="goods_spec">
		<form name="goodsForm" method="post" enctype="multipart/form-data" action="../order/add" target="actionFrame">
		<input type="hidden" name="goodsSeq" value="<?php echo $TPL_VAR["goods"]["goods_seq"]?>" />
		<input type="hidden" name="goodsViewVersion" value="2" />

			<div class="sns_wish">
				<!-- SNS 공유 -->
				<a href="javascript:void(0)" id="btnSnsShare" class="btn_sns_share" title="SNS 공유" onclick="share_chg()" ><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >공유</span></a>
				<div id="snsListDetail" class="snsbox_area" style="display:none;">
					<?php echo snslinkurl('goods',$TPL_VAR["goods"]["goods_name"])?>

				</div>
				<!-- 찜 -->
				<a href="javascript:void(0)" id="wishimg" class="ico_wish" usewish="n" onclick="wish_chg();" title="찜하기(위시리스트에 추가)"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >찜</span></a>
			</div>

			<ul class="goods_spec_sections">
				<!-- ~~~~~ 단독 이벤트 ~~~~~ -->
<?php if($TPL_VAR["eventEnd"]){?>
				<li class="spec_solo_event">
					<ul class="list">
						<li class="buy_num"><strong class="num"><?php echo number_format($TPL_VAR["goods"]["event"]["event_order_ea"])?></strong><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >개 구매중</span></li>
						<li class="remain_time">
							<span class="title"></span>
							<div class="event_datetime_box">
								<span class="num2" id="soloday<?php echo $TPL_VAR["goods"]["goods_seq"]?>">00</span><span class="day" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >일</span>
								<span class="num2" id="solohour<?php echo $TPL_VAR["goods"]["goods_seq"]?>">00</span> :
								<span class="num2" id="solomin<?php echo $TPL_VAR["goods"]["goods_seq"]?>">00</span> :
								<span class="num2" id="solosecond<?php echo $TPL_VAR["goods"]["goods_seq"]?>">00</span>
							</div>
						</li>
					</ul>
				</li>
<?php }?>
				<!-- ~~~~~ //단독 이벤트 ~~~~~ -->

				<!-- ~~~~~ 퍼스트몰 라이브 알림 ~~~~~ -->
<?php if($TPL_VAR["braodcastData"]){?>
				<li>
					<div class="cast_notice">
<?php if($TPL_VAR["braodcastData"]["status"]=='live'){?>
						<img class="status" src="/data/skin/responsive_sports_sporti_gl_1/images/broadcast/i_live.png" alt="방송 중">
						<p class="notice_text"><?php echo $TPL_VAR["braodcastData"]["start_date"]?> 현재 방송 중</p>
						<a class="btn_resp no_border" href="/broadcast/player?no=<?php echo $TPL_VAR["braodcastData"]["bs_seq"]?>" target="_blank"><img src="/data/skin/responsive_sports_sporti_gl_1/images/broadcast/btn_live_go.png" alt="시청하기"></a>
<?php }else{?>
						<img class="status" src="/data/skin/responsive_sports_sporti_gl_1/images/broadcast/reserve_live.png" alt="방송 예정 LIVE">
						<a href="/broadcast/player?no=<?php echo $TPL_VAR["braodcastData"]["bs_seq"]?>" class="notice_text" target="_blank"><?php echo $TPL_VAR["braodcastData"]["start_date"]?> 라이브 쇼핑으로 만나보세요.</a>
<?php }?>
					</div>
				</li>
<?php }?>
				<!-- ~~~~~ 퍼스트몰 라이브 알림 ~~~~~ -->

				<!-- ~~~~~ 가격, 할인율, 할인내역 ~~~~~ -->
				<li class="deatil_price_area">
<?php if($TPL_VAR["goods"]["sale_rate"]){?>
<?php if($TPL_VAR["goods"]["org_price"]!= 0&&$TPL_VAR["goods"]["sale_price"]!= 0){?>
						<div class="deatil_sale_rate">
							<p class="inner">
								<span class="num"><?php echo number_format($TPL_VAR["goods"]["sale_rate"])?></span>%
							</p>
						</div>
<?php }?>
<?php }?>
<?php if($TPL_VAR["goods"]["string_price_use"]){?>
						<p class="sale_price"><?php echo $TPL_VAR["goods"]["string_price"]?></p>
<?php }else{?>
<?php if($TPL_VAR["goods"]["org_price"]>$TPL_VAR["goods"]["sale_price"]){?>
						<p class="org_price">
							<span class="dst_th_size"><?php echo get_currency_price($TPL_VAR["goods"]["org_price"], 2,'','<s><span class="num">_str_price_</span></s>')?></span>
						</p>
<?php }?>
						<p class="sale_price">
<?php if($TPL_VAR["goods"]["sale_price"]> 0){?>
								<?php echo get_currency_price($TPL_VAR["goods"]["sale_price"], 2,'','<span class="num">_str_price_</span>','price_won')?>

<?php }else{?>
								<?php echo get_currency_price( 0, 2,'','<span class="num">_str_price_</span>','price_won')?>

<?php }?>
						</p>
<?php }?>
<?php if($TPL_VAR["goods"]["sale_price_compare"]&&$TPL_VAR["goods"]["sale_price"]> 0&&!$TPL_VAR["goods"]["string_price_use"]){?>
						<?php echo $TPL_VAR["goods"]["sale_price_compare"]?>

<?php }?>

<?php if((array_sum($TPL_VAR["sales"]["sale_list"])-$TPL_VAR["sales"]["sale_list"]["basic"])> 0){?>
					<button type="button" class="btn_open_small btn_resp B" onclick="detail_contents_toggle(this,'priceDetail')"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >혜택보기</span></button>
					<div id="priceDetail" class="detail_option_list hide">
						<ul>
<?php if(is_array($TPL_R1=$TPL_VAR["sales"]["sale_list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_V1> 0){?>
							<li>
								<span class="title"><?php echo $TPL_VAR["sales"]["title_list"][$TPL_K1]?></span>
								<span class="detail"><?php echo get_currency_price($TPL_V1, 2)?></span>
							</li>
<?php }?>
<?php }}?>
						</ul>
					</div>
<?php }?>
				</li>
				<!-- ~~~~~ //가격, 할인율, 할인내역 ~~~~~ -->

				<!-- ~~~~~ 상품번호 ~~~~~ -->
				<li class="goods_spec_number hide">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >상품번호</span></li>
						<li class="td"><?php echo $TPL_VAR["goods"]["goods_seq"]?></li>
					</ul>
				</li>
				<!-- ~~~~~ //상품번호 ~~~~~ -->

				<!-- ~~~~~ 판매중지 ~~~~~ -->
<?php if($TPL_VAR["goods"]["goods_status"]=='unsold'){?>
				<li class="goods_spec_unsold">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >상태</span></li>
						<li class="td sell_stop"><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >판매중지</span></li>
					</ul>
				</li>
<?php }?>
				<!-- ~~~~~ //판매중지 ~~~~~ -->

				<!-- ~~~~~ 대량구매 ~~~~~ -->
<?php if($TPL_VAR["sales"]["mtext_list"]['multi']){?>
				<li class="goods_spec_large_purchase">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >대량구매</span></li>
						<li>
							<?php echo $TPL_VAR["sales"]["mtext_list"]['multi']?>

						</li>
						<li class="btn_area1">
							<button type="button" class="btn_open_small btn_resp no_border" onclick="detail_contents_toggle(this,'multi')"><span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >자세히</span></button>
						</li>
					</ul>
					<div id="multi" class="detail_option_list hide">
						<ul>
							<!-- <?php if(is_array($TPL_R1=$TPL_VAR["goods"]["multi_discount_policy"]["policyList"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?> -->
<?php if($TPL_V1["discountAmount"]> 0){?>
							<li><?php echo $TPL_V1["discountOverQty"]?>개 이상<?php if($TPL_V1["discountUnderQty"]){?> ~ <?php echo $TPL_V1["discountUnderQty"]?>개 미만 <?php }?>: 1개당 <?php echo $TPL_V1["discountAmount"]?><?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]=='PER'){?>%<?php }else{?>원<?php }?> 할인</li>
<?php }?>
							<!-- <?php }}?> -->
							<!-- <?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountMaxAmount"]){?> -->
							<li><?php echo $TPL_VAR["goods"]["multi_discount_policy"]["discountMaxOverQty"]?>개 이상 : 1개당 <?php echo $TPL_VAR["goods"]["multi_discount_policy"]["discountMaxAmount"]?><?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]=='PER'){?>%<?php }else{?>원<?php }?> 할인</li>
							<!-- <?php }?> -->
						</ul>
					</div>
				</li>
<?php }?>
				<!-- ~~~~~ //대량구매 ~~~~~ -->

				<!-- ~~~~~ 회원등급 ~~~~~ -->
<?php if($TPL_VAR["sales"]["mtext_list"]['member']){?>
				<li class="goods_spec_member_grade">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >회원등급</span></li>
						<li><?php echo $TPL_VAR["sales"]["mtext_list"]['member']?></li>
<?php if($TPL_VAR["goods"]["group_benifits"]){?>
						<li class="btn_area1">
							<button type="button" class="btn_open_small btn_resp no_border" onclick="detail_contents_toggle(this,'memberBenefitDetail')"><span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >자세히</span></button>
						</li>
<?php }?>
					</ul>
					<div id="memberBenefitDetail" class="detail_option_list hide">
						<ul>
<?php if(is_array($TPL_R1=$TPL_VAR["goods"]["group_benifits"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["group_seq"]&&($TPL_V1["sale_price"]> 0||$TPL_V1["reserve_price"]> 0||$TPL_V1["point_price"]> 0)){?>
							<li>
								<p class="e_title"><?php echo $TPL_V1["group_name"]?></p>
<?php if($TPL_V1["sale_price"]> 0){?>
								<div class="e_content">
<?php if($TPL_V1["sale_price_type"]=='PER'){?>
									<?php echo floor($TPL_V1["sale_price"])?>% 추가할인<br />
<?php }else{?>
									<?php echo get_currency_price($TPL_V1["sale_price"], 2)?> 추가할인<br />
<?php }?>
<?php if($TPL_V1["sale_use"]=='Y'&&$TPL_V1["sale_limit_price"]> 0){?>
									(<?php echo get_currency_price($TPL_V1["sale_limit_price"], 2)?> 이상 구매 시)<br />
<?php }?>
								</div>
<?php }?>

<?php if($TPL_V1["sale_price"]> 0&&($TPL_V1["reserve_price"]> 0||$TPL_V1["point_price"]> 0)){?>
<?php }?>

<?php if($TPL_V1["reserve_price"]> 0){?>
								<div class="e_content">
<?php if($TPL_V1["reserve_price_type"]=='PER'){?>
									마일리지 <?php echo floor($TPL_V1["reserve_price"])?>% 추가적립<br />
<?php }else{?>
									마일리지 <?php echo get_currency_price($TPL_V1["reserve_price"], 2)?> 추가적립<br />
<?php }?>
<?php if($TPL_V1["reserve_price"]> 0||$TPL_V1["point_price"]> 0){?>
<?php if($TPL_V1["point_use"]=='Y'&&$TPL_V1["point_limit_price"]> 0){?>
										(<?php echo get_currency_price($TPL_V1["point_limit_price"], 2)?> 이상 구매 시)<br />
<?php }?>
<?php }?>
								</div>
<?php }?>

<?php if($TPL_V1["point_price"]> 0){?>
								<div class="e_content">
<?php if($TPL_V1["point_price_type"]=='PER'){?>
									포인트 <?php echo floor($TPL_V1["point_price"])?>% 추가적립<br />
<?php }else{?>
									포인트 <?php echo $TPL_V1["point_price"]?>P 추가적립<br />
<?php }?>
<?php if($TPL_V1["reserve_price"]> 0||$TPL_V1["point_price"]> 0){?>
<?php if($TPL_V1["point_use"]=='Y'&&$TPL_V1["point_limit_price"]> 0){?>
										(<?php echo get_currency_price($TPL_V1["point_limit_price"],'')?> 이상 구매 시)<br />
<?php }?>
<?php }?>
								</div>
<?php }?>
							</li>
<?php }?>
<?php }}?>
						</ul>
					</div>
				</li>
<?php }?>
				<!-- ~~~~~ //회원등급 ~~~~~ -->

				<!-- ~~~~~ 쿠폰 ~~~~~ -->
<?php if($TPL_VAR["sales"]["mtext_list"]['coupon']){?>
				<li class="goods_spec_coupon">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >쿠폰</span></li>
						<li>
							<?php echo $TPL_VAR["sales"]["mtext_list"]['coupon']?>

						</li>
						<li class="btn_area1">
							<button type="button" id="couponDownload" class="btn_resp ico_down resStyle">쿠폰받기</button>
						</li>
					</ul>
				</li>
<?php }?>
				<!-- ~~~~~ //쿠폰 ~~~~~ -->

				<!-- ~~~~~ 할인코드 ~~~~~ -->
<?php if($TPL_VAR["sales"]["mtext_list"]['code']){?>
				<li class="goods_spec_sales_code">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >할인코드</span></li>
						<li>
							<?php echo $TPL_VAR["sales"]["mtext_list"]['code']?>

						</li>
						<li class="btn_area1">
							<button type="button" id="codeSaleView" class="btn_resp no_border resStyle"><span designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >자세히</span></button>
						</li>
					</ul>
				</li>
<?php }?>
				<!-- ~~~~~ //할인코드 ~~~~~ -->

				<!-- ~~~~~ 좋아요 ~~~~~ -->
<?php if($TPL_VAR["sales"]["mtext_list"]['like']&&$TPL_VAR["APP_USE"]=='f'&&$TPL_VAR["APP_LIKE_TYPE"]!='NO'){?>
				<li class="goods_spec_like">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >좋아요</span></li>
						<li>
							<div><?php echo $TPL_VAR["sales"]["mtext_list"]['like']?></div>
<?php if($TPL_VAR["APP_USE"]=='f'&&$TPL_VAR["APP_LIKE_TYPE"]!='NO'){?>
							<div><?php echo snsLikeButton($TPL_VAR["goods"]["goods_seq"],'button_count')?></div>
<?php }?>
						</li>
						<li class="btn_area1">
							<button type="button" class="btn_open_small btn_resp no_border" onclick="detail_contents_toggle(this,'fblikeDetail')"><span designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >자세히</span></button>
						</li>
					</ul>
					<div id="fblikeDetail" class="detail_option_list hide">
						<ul>
<?php if(is_array($TPL_R1=$TPL_VAR["fblikesale"]["result"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<li>
								<p class="e_title" ><span designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >좋아요 + </span><?php echo get_currency_price($TPL_V1["price1"], 2)?><span designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" > 이상 구매시</span></p>
								<div class="e_content">
<?php if(count($TPL_V1["result"])> 1){?>
										<ul class="basic_lr_style">
											<li>최대</li>
											<li>
<?php if($TPL_V1["sale_price_max"]){?><p class="style"><span class="pointcolor"><?php echo number_format($TPL_V1["sale_price_max"])?>%</span> 추가할인</p><?php }?>
<?php if($TPL_V1["sale_emoney_max"]){?><p class="style"><?php if($TPL_V1["sale_price_max"]){?><?php }?> 마일리지 <span class="pointcolor"><?php echo number_format($TPL_V1["sale_emoney_max"])?>%</span> 추가적립</p><?php }?>
<?php if($TPL_V1["sale_point_max"]){?><p class="style"><?php if($TPL_V1["sale_price_max"]||$TPL_V1["sale_emoney_max"]){?><?php }?> 포인트 <span class="pointcolor"><?php echo number_format($TPL_V1["sale_point_max"])?>%</span> 추가적립</p><?php }?>
											</li>
										</ul>
<?php }else{?>
<?php if($TPL_V1["sale_price"]){?><p class="style"><span class="pointcolor"><?php echo number_format($TPL_V1["sale_price"])?>%</span> 추가할인</p><?php }?>
<?php if($TPL_V1["sale_emoney"]){?><p class="style"><?php if($TPL_V1["sale_price"]){?><?php }?> 마일리지 <span class="pointcolor"><?php echo number_format($TPL_V1["sale_emoney"])?>%</span> 추가적립</p><?php }?>
<?php if($TPL_V1["sale_point"]){?><p class="style"><?php if($TPL_V1["sale_price"]||$TPL_V1["sale_emoney"]){?><?php }?> 포인트 <span class="pointcolor"><?php echo number_format($TPL_V1["sale_point"])?>%</span> 추가적립</p><?php }?>
<?php }?>
								</div>
							</li>
<?php }}?>
						</ul>
					</div>
				</li>
<?php }?>
				<!-- ~~~~~ //좋아요 ~~~~~ -->

				<!-- ~~~~~ 모바일 ~~~~~ -->
<?php if($TPL_VAR["sales"]["mtext_list"]['mobile']){?>
				<li class="goods_spec_mobile">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >모바일</span></li>
						<li>
							<?php echo $TPL_VAR["sales"]["mtext_list"]['mobile']?>

						</li>
						<li class="btn_area1">
							<button type="button" class="btn_open_small btn_resp no_border" onclick="detail_contents_toggle(this,'mobileDetail')"><span designElement="text" textIndex="21"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >자세히</span></button>
						</li>
					</ul>
					<div id="mobileDetail" class="detail_option_list hide">
						<ul>
<?php if(is_array($TPL_R1=$TPL_VAR["mobilesale"]["result"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<li>
								<p class="e_title"><span designElement="text" textIndex="22"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >모바일 + </span><?php echo get_currency_price($TPL_V1["price1"], 2)?><span designElement="text" textIndex="23"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" > 이상 구매시</span></p>
								<div class="e_content">
<?php if(count($TPL_V1["result"])> 1){?>
										<ul class="basic_lr_style">
											<li>최대</li>
											<li>
												<p class="style"><span class="pointcolor"><?php echo number_format($TPL_V1["sale_price_max"])?>%</span> 추가할인</p>
<?php if($TPL_V1["sale_emoney_max"]){?><p class="style">마일리지 <span class="pointcolor"><?php echo number_format($TPL_V1["sale_emoney_max"])?>%</span> 추가적립</p><?php }?>
<?php if($TPL_V1["sale_point_max"]){?><p class="style">포인트 <span class="pointcolor"><?php echo number_format($TPL_V1["sale_point_max"])?>%</span> 추가적립</p><?php }?>
											</li>
										</ul>
<?php }else{?>
										<p class="style"><span class="pointcolor"><?php echo number_format($TPL_V1["sale_price"])?>%</span> 추가할인</p>
<?php if($TPL_V1["sale_emoney"]){?><p class="style">마일리지 <span class="pointcolor"><?php echo number_format($TPL_V1["sale_emoney"])?>%</span> 추가적립</p><?php }?>
<?php if($TPL_V1["sale_point"]){?><p class="style">포인트 <span class="pointcolor"><?php echo number_format($TPL_V1["sale_point"])?>%</span> 추가적립</p><?php }?>
<?php }?>
								</div>
							</li>
<?php }}?>
						</ul>
					</div>
				</li>
<?php }?>
				<!-- ~~~~~ //모바일 ~~~~~ -->

				<!-- ~~~~~ 무이자할부( common.css에서 display:none 처리 - 190320 sjg ) ~~~~~ -->
				<li class="goods_spec_halbu">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="24"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >무이자할부</span></li>
						<li><span class="gray_06" designElement="text" textIndex="25"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >우측 '자세히' 참조</span></li>
						<li class="btn_area1">
							<button type="button" class="btn_resp no_border" onclick="detail_contents_toggle(this,'goodsInterest')"><span designElement="text" textIndex="26"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >자세히</span></button>
						</li>
					</ul>
					<div id="goodsInterest" class="Relative hide">
						<div class="layer_simple_basic px p_right">
							<table class="detail_option_table card" cellpadding="0" cellspacing="0">
								<tbody>
								<tr>
									<th><img src="/data/skin/responsive_sports_sporti_gl_1/images/common/interest/Interest_img_bc.gif"></th>
									<td><span designElement="text" textIndex="27"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >3~12개월</span></td>
									<td><span designElement="text" textIndex="28"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >5만원이상</span></td>
								</tr>
								<tr>
									<th><img src="/data/skin/responsive_sports_sporti_gl_1/images/common/interest/Interest_img_ct.gif"></th>
									<td><span designElement="text" textIndex="29"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >3~12개월</span></td>
									<td><span designElement="text" textIndex="30"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >5만원이상</span></td>
								</tr>
								<tr>
									<th><img src="/data/skin/responsive_sports_sporti_gl_1/images/common/interest/Interest_img_hd.gif"></th>
									<td><span designElement="text" textIndex="31"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >3~12개월</span></td>
									<td><span designElement="text" textIndex="32"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >5만원이상</span></td>
								</tr>
								<tr>
									<th><img src="/data/skin/responsive_sports_sporti_gl_1/images/common/interest/Interest_img_hn.gif"></th>
									<td><span designElement="text" textIndex="33"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >3~12개월</span></td>
									<td><span designElement="text" textIndex="34"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >5만원이상</span></td>
								</tr>
								<tr>
									<th><img src="/data/skin/responsive_sports_sporti_gl_1/images/common/interest/Interest_img_kb.gif"></th>
									<td><span designElement="text" textIndex="35"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >3~12개월</span></td>
									<td><span designElement="text" textIndex="36"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >5만원이상</span></td>
								</tr>
								<tr>
									<th><img src="/data/skin/responsive_sports_sporti_gl_1/images/common/interest/Interest_img_lt.gif"></th>
									<td><span designElement="text" textIndex="37"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >3~12개월</span></td>
									<td><span designElement="text" textIndex="38"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >5만원이상</span></td>
								</tr>
								<tr>
									<th><img src="/data/skin/responsive_sports_sporti_gl_1/images/common/interest/Interest_img_sh.gif"></th>
									<td><span designElement="text" textIndex="39"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >3~12개월</span></td>
									<td><span designElement="text" textIndex="40"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >5만원이상</span></td>
								</tr>
								<tr>
									<th><img src="/data/skin/responsive_sports_sporti_gl_1/images/common/interest/Interest_img_ss.gif"></th>
									<td><span designElement="text" textIndex="41"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >3~12개월</span></td>
									<td><span designElement="text" textIndex="42"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >5만원이상</span></td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</li>
				<!-- ~~~~~ //무이자할부 ~~~~~ -->

				<!-- ~~~~~ 유입경로 ~~~~~ -->
<?php if($TPL_VAR["goods"]["referer_sale"]["referersale_seq"]){?>
				<li class="goods_spec_referersale_seq">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="43"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >유입경로</span></li>
						<li>
							<?php echo $TPL_VAR["sales"]["text_list"]['referer']?>

						</li>
					</ul>
				</li>
<?php }?>
				<!-- ~~~~~ //유입경로 ~~~~~ -->

				<!-- ~~~~~ 적립혜택 ~~~~~ -->
				<li class="goods_spec_saving_benefit">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="44"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >적립혜택</span></li>
						<li>
							<span designElement="text" textIndex="45"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >구매</span>
<?php if($TPL_VAR["goods"]["string_price_use"]){?>
							<?php echo $TPL_VAR["goods"]["string_price"]?>

<?php }else{?>
							<?php echo get_currency_price($TPL_VAR["goods"]["reserve"], 2)?>

<?php if($TPL_VAR["goods"]["point"]> 0){?>
								(<?php echo number_format($TPL_VAR["goods"]["point"])?>P)
<?php }?>
<?php }?>

<?php if(($TPL_VAR["cfg_reserve"]["autoemoney_video"]> 0||$TPL_VAR["cfg_reserve"]["autopoint_video"]> 0||$TPL_VAR["cfg_reserve"]["autoemoney_photo"]> 0||$TPL_VAR["cfg_reserve"]["autopoint_photo"]> 0||$TPL_VAR["cfg_reserve"]["autoemoney_review"]> 0||$TPL_VAR["cfg_reserve"]["autopoint_review"]> 0||($TPL_VAR["cfg_reserve"]["bbs_start_date"]&&$TPL_VAR["cfg_reserve"]["bbs_end_date"]))&&$TPL_VAR["isplusfreenot"]){?>
							&nbsp;<span class="gray_07">|</span>&nbsp; <span designElement="text" textIndex="46"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >후기</span> <span class="Dib gray_06" designElement="text" textIndex="47"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >우측 '자세히' 참조</span>
<?php }?>
						</li>
<?php if(($TPL_VAR["cfg_reserve"]["autoemoney_video"]> 0||$TPL_VAR["cfg_reserve"]["autopoint_video"]> 0||$TPL_VAR["cfg_reserve"]["autoemoney_photo"]> 0||$TPL_VAR["cfg_reserve"]["autopoint_photo"]> 0||$TPL_VAR["cfg_reserve"]["autoemoney_review"]> 0||$TPL_VAR["cfg_reserve"]["autopoint_review"]> 0||($TPL_VAR["cfg_reserve"]["bbs_start_date"]&&$TPL_VAR["cfg_reserve"]["bbs_end_date"]))&&$TPL_VAR["isplusfreenot"]){?>
						<li class="btn_area1">
							<button type="button" class="btn_resp no_border" onclick="detail_contents_toggle(this,'reviewDetail')"><span designElement="text" textIndex="48"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >자세히</span></button>
						</li>
<?php }?>
					</ul>
					<div id="reviewDetail" class="detail_option_list hide">
						<ul>
<?php if($TPL_VAR["cfg_reserve"]["autoemoney_review"]> 0||$TPL_VAR["cfg_reserve"]["autopoint_review"]> 0){?>
							<li>
								<p class="e_title" designElement="text" textIndex="49"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >일반 상품후기</p>
								<div class="e_content">
<?php if($TPL_VAR["cfg_reserve"]["autoemoney_review"]> 0){?>마일리지 <?php echo get_currency_price($TPL_VAR["cfg_reserve"]["autoemoney_review"], 2)?> 적립<?php }?>
<?php if($TPL_VAR["cfg_reserve"]["autopoint_review"]> 0){?>, 포인트 <?php echo number_format($TPL_VAR["cfg_reserve"]["autopoint_review"])?>P 적립<?php }?>
								</div>
							</li>
<?php }?>
<?php if($TPL_VAR["cfg_reserve"]["autoemoney_photo"]> 0||$TPL_VAR["cfg_reserve"]["autopoint_photo"]> 0){?>
							<li>
								<p class="e_title" designElement="text" textIndex="50"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >포토 상품후기</p>
								<div class="e_content">
<?php if($TPL_VAR["cfg_reserve"]["autoemoney_photo"]> 0){?>마일리지 <?php echo get_currency_price($TPL_VAR["cfg_reserve"]["autoemoney_photo"], 2)?> 적립<?php }?>
<?php if($TPL_VAR["cfg_reserve"]["autopoint_photo"]> 0){?>, 포인트 <?php echo number_format($TPL_VAR["cfg_reserve"]["autopoint_photo"])?>P 적립<?php }?>
								</div>
							</li>
<?php }?>
<?php if($TPL_VAR["cfg_reserve"]["autoemoney_video"]> 0||$TPL_VAR["cfg_reserve"]["autopoint_video"]> 0){?>
							<li>
								<p class="e_title" designElement="text" textIndex="51"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >동영상 상품후기</p>
								<div class="e_content">
<?php if($TPL_VAR["cfg_reserve"]["autoemoney_video"]> 0){?>마일리지 <?php echo get_currency_price($TPL_VAR["cfg_reserve"]["autoemoney_video"], 2)?> 적립<?php }?>
<?php if($TPL_VAR["cfg_reserve"]["autopoint_video"]> 0){?>, 포인트 <?php echo number_format($TPL_VAR["cfg_reserve"]["autopoint_video"])?>P 적립<?php }?>
								</div>
							</li>
<?php }?>
<?php if($TPL_VAR["cfg_reserve"]["bbs_start_date"]&&$TPL_VAR["cfg_reserve"]["bbs_end_date"]){?>
							<li>
								<p class="e_title" designElement="text" textIndex="52"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >기타 상품후기</p>
								<div class="e_content">
<?php if($TPL_VAR["cfg_reserve"]["emoneyBbs_limit"]> 0){?>마일리지 <?php echo get_currency_price($TPL_VAR["cfg_reserve"]["emoneyBbs_limit"], 2)?> 적립<?php }?>
<?php if($TPL_VAR["cfg_reserve"]["pointBbs_limit"]> 0){?>, 포인트 <?php echo number_format($TPL_VAR["cfg_reserve"]["pointBbs_limit"])?>P 적립<?php }?>
								</div>
							</li>
<?php }?>
						</ul>
					</div>
				</li>
				<!-- ~~~~~ //적립혜택 ~~~~~ -->

				<!-- ~~~~~ 네이버 마일리지 ~~~~~ -->
<?php if(in_array($TPL_VAR["naver_mileage_yn"],array('y','t'))){?>
				<li class="goods_spec_naver_mileage">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="53"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >네이버 마일리지</span></li>
						<li>
							<?php echo showNaverMileageButton('view')?>

						</li>
					</ul>
				</li>
<?php }?>
				<!-- ~~~~~ //네이버 마일리지 ~~~~~ -->

				<!-- ~~~~~ 배송 ~~~~~ -->
<?php if($TPL_VAR["goods"]["goods_kind"]=='coupon'){?>
				<li class="goods_spec_coupon2" style="display:none;">
					<select name="shipping_method">
<?php if($TPL_shipping_set_1){foreach($TPL_VAR["shipping_set"] as $TPL_V1){?>
						<option value='<?php echo $TPL_V1["shipping_set_seq"]?>' selected grp_seq="<?php echo $TPL_V1["shipping_group_seq"]?>" nation="<?php echo $TPL_V1["delivery_nation"]?>" prepay_info="<?php echo $TPL_V1["prepay_info"]?>" ><?php echo $TPL_V1["shipping_set_name"]?>(<?php echo $TPL_V1["prepay_txt"]?>)</option>
<?php }}?>
					</select>
					<input type="hidden" name="shipping_prepay_info" value="delivery" />
				</li>
<?php }else{?>
				<li class="goods_spec_shipping">
					<ul class="detail_spec_table">
						<li class="th">
							<span designElement="text" textIndex="54"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >배송</span>
<?php if($TPL_VAR["goods"]["option_international_shipping_status"]=='y'){?>
							<img src="/data/skin/responsive_sports_sporti_gl_1/images/common/icon_inter_ship.png" class="icon_global" alt="" />
<?php }?>
						</li>
						<li>
<?php if($TPL_VAR["goods"]["option_international_shipping_status"]=='y'){?>
							<ul class="detail_spec_table sub">
								<li><span designElement="text" textIndex="55"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >해외구매대행 상품, 개인통관고유부호</span></li>
								<li class="btn_area1"><button type="button" class="btn_resp no_border" onclick="detail_contents_toggle(this,'customsDetail')"><span designElement="text" textIndex="56"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >자세히</span></button></li>
							</ul>
<?php }?>

<?php if($TPL_VAR["shipping_set"]){?>
							<ul class="detail_spec_table sub">
								<li>
									<select class="M" name="shipping_method" onchange="view_delivery_cost();" <?php if(count($TPL_VAR["shipping_set"])== 1){?>style="display:none"<?php }?>>
<?php if($TPL_shipping_set_1){foreach($TPL_VAR["shipping_set"] as $TPL_V1){?>
										<option value='<?php echo $TPL_V1["shipping_set_seq"]?>' <?php if($TPL_V1["default_yn"]=='Y'){?>selected<?php }?> grp_seq="<?php echo $TPL_V1["shipping_group_seq"]?>" nation="<?php echo $TPL_V1["delivery_nation"]?>" prepay_info="<?php echo $TPL_V1["prepay_info"]?>" shipping_set_code="<?php echo $TPL_V1["shipping_set_code"]?>" <?php if($TPL_V1["hopeday_required"]=='Y'){?>hop_date="<?php echo $TPL_V1["hop_date"]?>"<?php }?>><?php echo $TPL_V1["shipping_set_name"]?><?php if($TPL_V1["shipping_set_code"]!='direct_store'){?>(<?php echo $TPL_V1["prepay_txt"]?>)<?php }?></option>
<?php }}?>
									</select>
									<script>$(function(){view_delivery_cost()});</script>
<?php if(count($TPL_VAR["shipping_set"])== 1){?>
<?php if($TPL_shipping_set_1){foreach($TPL_VAR["shipping_set"] as $TPL_V1){?>
									<span><?php echo $TPL_V1["shipping_set_name"]?><?php if($TPL_V1["shipping_set_code"]!='direct_store'){?>(<span class="gray_06"><?php echo $TPL_V1["prepay_txt"]?></span>)<?php }?></span>
<?php }}?>
<?php }else{?>
									<span id="shipping_prepay_txt" class="gray_01"></span>
<?php }?>
									<input type="hidden" name="shipping_prepay_info" id="shipping_prepay_info" value="" alt="선/착불정보" />
									<input type="hidden" name="shipping_store_seq" id="shipping_store_seq" value="" alt="수령매장정보" />
									<!--div id="shipping_detail_lay" class="resp_layer_pop hide"></div-->
									<div id="shipping_detail_lay" class="resp_layer_pop hide">
										<h4 class="title"><span designElement="text" textIndex="57"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >배송비 안내</span></h4>
										<div class="y_scroll_auto2">
											<div class="layer_pop_contents v5"></div>
										</div>
										<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
									</div>
								</li>
								<li class="btn_area1">
									<button type="button" class="btn_resp no_border" id="shipping_detail_info_resp"><span designElement="text" textIndex="58"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >자세히</span></button>
								</li>
							</ul>
<?php }?>

<?php if($TPL_VAR["goods"]["goods_kind"]!='coupon'){?>
							<ul class="detail_spec_table sub shipping_set_area">
								<li>
<?php if($TPL_shipping_set_1){foreach($TPL_VAR["shipping_set"] as $TPL_V1){?>
									<div class="set_lay set_<?php echo $TPL_V1["shipping_set_seq"]?> hide">
<?php if($TPL_V1["delivery_std_input"]){?>
										<div class="std">
											<?php echo $TPL_V1["delivery_std_input"]?>

										</div>
<?php }?>
<?php if($TPL_V1["delivery_add_input"]){?>
										<div class="add">
											<span designElement="text" textIndex="59"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >추가배송비</span> <?php echo $TPL_V1["delivery_add_input"]?>

										</div>
<?php }?>
<?php if($TPL_V1["delivery_hop_input"]&&!$TPL_VAR["goods"]["reserve_ship_flag"]){?>
										<div class="hop">
											<span designElement="text" textIndex="60"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >희망배송일</span> <?php echo $TPL_V1["delivery_hop_input"]?>

											<button type="button" value="" class="btn_resp calendarBtn" grp_seq="<?php echo $TPL_V1["shipping_group_seq"]?>" set_seq="<?php echo $TPL_V1["shipping_set_seq"]?>" onclick="detail_contents_toggle(this,'deliverydateDetail');"><span designElement="text" textIndex="61"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >희망배송일</span></button>
											<span class="hop_view_date">(미선택)</span>
										</div>
<?php }?>
									</div>
<?php }}?>
									<input type="hidden" name="hop_select_date" id="hop_select_date" value="" />
									<script>view_delivery_cost();</script>
								</li>
							</ul>
<?php }?>

<?php if($TPL_VAR["goods"]["reserve_ship_flag"]){?>
							<ul class="detail_spec_table sub">
								<li><span designElement="text" textIndex="62"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >예약판매 :</span> <?php echo $TPL_VAR["goods"]["reserve_ship_txt"]?></li>
							</ul>
<?php }?>
						</li>
					</ul>

					<div id="deliverydateDetail" class="Relative hide">
						<div class="hopCalendarLayer layer_simple_basic"><span designElement="text" textIndex="63"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >달력</span></div>
					</div>

					<div id="customsDetail" class="detail_option_list hide">
						<ul>
							<li>
								<p class="e_title" designElement="text" textIndex="64"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >해외구매대행 상품이란?</p>
								<p class="e_content" designElement="text" textIndex="65"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >
									해외에서 수입하여 판매하는 상품으로 배송, 반품, 교환이 일반상품과 다를 수 있습니다. 또한 관세청 수입통관 신고 시 구매자의 개인통관고유부호가 필요하기 때문에 주문 시 구매자로부터 개인통관고유부호를 수집하게 됩니다.
								</p>
							</li>
							<li>
								<p class="e_title" designElement="text" textIndex="66"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >개인통관고유부호란?</p>
								<p class="e_content" designElement="text" textIndex="67"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >
									관세청에서는 개인정보 유출을 방지하기 위하여 개인물품 수입신고 시 주민등록번호를 대신 활용할 수 있는 개인통관고유부호 제도를 운영합니다. 개인통관고유부호는 <a href="https://p.customs.go.kr" class="Und" target="_blank" title="새창" designElement="text" textIndex="68"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >관세청 사이트</a>에서 신청 즉시 부여되며, 계속 같은 번호로 사용이 가능합니다. 분실하면 관세청 사이트에서 조회 가능합니다. 부호 체계는 P로 시작하고 13자리입니다.
								</p>
							</li>
						</ul>
					</div>

					<div id="eachDeliveryDetail" class="detail_option_list hide">
						<ul>
							<li>
								<p class="e_title" designElement="text" textIndex="69"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >포장최대단위</p>
								<div class="e_content">
									상품 <?php echo number_format($TPL_VAR["goods"]["limit_shipping_ea"])?>개
								</div>
							</li>
							<li>
								<p class="e_title" designElement="text" textIndex="70"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >포장단위별 배송비</p>
								<div class="e_content">
									<?php echo get_currency_price($TPL_VAR["goods"]["limit_shipping_price"], 2)?>

								</div>
							</li>
							<li>
								<p class="e_title" designElement="text" textIndex="71"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >포장단위별 추가배송비</p>
								<div class="e_content">
									<?php echo get_currency_price($TPL_VAR["goods"]["limit_shipping_subprice"], 2)?>

								</div>
							</li>
						</ul>
					</div>
				</li>
<?php }?>
				<!-- ~~~~~ //배송 ~~~~~ -->

				<!-- ~~~~~ 해외배송 ~~~~~ -->
<?php if($TPL_VAR["ship_summary"]["gl_shipping_yn"]=='Y'){?>
				<li class="goods_spec_international_shipping">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="72"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >해외배송</span> <img src="/data/skin/responsive_sports_sporti_gl_1/images/common/plane.png" height="15" alt="해외배송" /></li>
						<li>
							<span class="gray_06" designElement="text" textIndex="73"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >우측 '자세히' 참조</span>
							<div class="hide">
								이 상품은 해외에서 국내로 배송되는 상품이므로 배송,반품,교환이 일반 상품과 다를 수 있습니다.
							</div>
						</li>
						<li class="btn_area1">
							<button type="button" class="btn_resp no_border" onclick="detail_contents_toggle(this,'countryDetail')"><span designElement="text" textIndex="74"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >자세히</span></button>
						</li>
					</ul>
					<div id="countryDetail" class="Relative hide">
						<div class="layer_simple_basic px country_list">
							<table class="detail_option_table" cellpadding="0" cellspacing="0">
								<tbody>
<?php if($TPL_ship_gl_list_1){foreach($TPL_VAR["ship_gl_list"] as $TPL_V1){?>
									<tr>
										<th scope="row" class="L">
											<img src="/admin/skin/default/images/common/icon/nation/<?php echo $TPL_V1["gl_nation"]?>.png" height="20" alt="">
											<?php echo $TPL_V1["gl_nation"]?>

										</th>
										<td class="L"><?php echo $TPL_V1["kr_nation"]?></td>
									</tr>
<?php }}?>
								</tbody>
							</table>
						</div>
					</div>
				</li>
<?php }?>
				<!-- ~~~~~ //해외배송 ~~~~~ -->

				<!-- ~~~~~ 상품정보 ~~~~~ -->
<?php if($TPL_VAR["goods"]["sub_info_desc"]["subInfo"]){?>
				<li class="goods_spec_sub_info">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="75"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >상품정보</span></li>
						<li><span class="gray_06" designElement="text" textIndex="76"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >우측 '자세히' 참조</span></li>
						<li class="btn_area1">
							<button type="button" class="btn_resp no_border" onclick="showCenterLayer('#infoDetail')"><span designElement="text" textIndex="77"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >자세히</span></button>
						</li>
					</ul>
					<div id="infoDetail" class="resp_layer_pop hide">
						<h4 class="title"><span designElement="text" textIndex="78"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >상품 정보 제공 고시</span></h4>
						<div class="y_scroll_auto2">
							<div class="layer_pop_contents v5">
								<div class="resp_1line_table">
									<!-- <?php if(is_array($TPL_R1=$TPL_VAR["goods"]["sub_info_desc"]["subInfo"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?> -->
									<ul>
										<li class="th size1"><p><?php echo $TPL_V1["title"]?></p></li>
										<li class="td"><?php echo $TPL_V1["desc"]?></li>
									</ul>
									<!-- <?php }}?> -->
								</div>
							</div>
						</div>
						<div class="layer_bottom_btn_area2">
							<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
						</div>
						<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
					</div>
				</li>
<?php }?>
				<!-- ~~~~~ //상품정보 ~~~~~ -->

				<!-- ~~~~~ 상품후기 ~~~~~ -->
<?php if($TPL_VAR["goods"]["review_count"]){?>
				<li class="goods_spec_customer_ev">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="79"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >상품후기</span></li>
						<li>
							<?php echo number_format($TPL_VAR["goods"]["review_count"])?><span designElement="text" textIndex="80"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >명</span>&nbsp;
							<span class="ev_active2"><b style="width:<?php echo round($TPL_VAR["goods"]["review_divide"]/ 5* 100, 1)?>%;"></b></span>
							<span class="desc">(<span class="gray_01"><?php echo round($TPL_VAR["goods"]["review_divide"], 1)?></span>/5)</span>
						</li>
					</ul>
				</li>
<?php }?>
				<!-- ~~~~~ //상품후기 ~~~~~ -->

				<!-- ~~~~~ 브랜드 ~~~~~ -->
<?php if($TPL_VAR["goods"]["brand"]){?>
				<li class="goods_spec_brand">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="81"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >브랜드</span></li>
						<li>
							<?php echo $TPL_VAR["view_brand"]?>

						</li>
					</ul>
				</li>
<?php }?>
				<!-- ~~~~~ //브랜드 ~~~~~ -->

				<!-- ~~~~~ 추가정보 ~~~~~ -->
<?php if($TPL_additions_1){foreach($TPL_VAR["additions"] as $TPL_V1){?>
				<li class="goods_spec_brand">
					<ul class="detail_spec_table">
						<li class="th"><?php echo $TPL_V1["name"]?></li>
						<li>
							<?php echo $TPL_V1["contents"]?>

						</li>
					</ul>
				</li>
<?php }}?>
				<!-- ~~~~~ //추가정보 ~~~~~ -->

				<!-- ~~~~~ 청약철회 ~~~~~ -->
<?php if($TPL_VAR["goods"]["cancel_type"]=='1'){?>
				<li class="goods_spec_cancel">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="82"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >청약철회</span></li>
						<li>
							<span designElement="text" textIndex="83"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >불가</span>
						</li>
					</ul>
				</li>
<?php }?>
				<!-- ~~~~~ //청약철회 ~~~~~ -->

				<!-- ~~~~~ 판매자 ~~~~~ -->
<?php if($TPL_VAR["provider"]["provider_seq"]){?>
				<li class="goods_spec_provider">
					<ul class="detail_spec_table">
						<li class="th"><span designElement="text" textIndex="84"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >판매자</span></li>
						<li>
							<a href="/mshop?m=<?php echo $TPL_VAR["provider"]["provider_seq"]?>" target="_blank" title="새창"><?php echo $TPL_VAR["provider"]["provider_name"]?></a>
							<a href="javascript:void(0)" class="reg_minishop v2 <?php if($TPL_VAR["provider"]["thisshop"]=='y'){?>on<?php }?>" title="<?php if($TPL_VAR["provider"]["thisshop"]=='n'){?>단골 등록<?php }?>" data-shop='<?php echo $TPL_VAR["provider"]["provider_seq"]?>' onclick="mshopadd(this, '<?php echo $TPL_VAR["sessionMember"]["member_seq"]?>');"></a>
						</li>
						<li class="btn_area1">
							<button type="button" class="btn_resp no_border" onclick="showCenterLayer('#sellerInfo')"><span designElement="text" textIndex="85"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >자세히</span></button>
						</li>
					</ul>
					<div id="sellerInfo" class="resp_layer_pop hide">
						<h4 class="title"><span designElement="text" textIndex="86"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >판매자 정보</span></h4>
						<div class="y_scroll_auto">
							<div class="layer_pop_contents">
								<div class="resp_1line_table">
<?php if($TPL_VAR["provider"]["provider_seq"]=='1'){?>
<?php if($TPL_VAR["config_basic"]["companyName"]){?>
										<ul>
											<li class="th size2"><p designElement="text" textIndex="87"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >상호명</p></li>
											<li class="td"><?php echo $TPL_VAR["config_basic"]["companyName"]?></li>
										</ul>
<?php }?>
<?php if($TPL_VAR["config_basic"]["ceo"]){?>
										<ul>
											<li class="th size2"><p designElement="text" textIndex="88"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >대표자</p></li>
											<li class="td"><?php echo $TPL_VAR["config_basic"]["ceo"]?></li>
										</ul>
<?php }?>
<?php if($TPL_VAR["config_basic"]["businessLicense"]){?>
										<ul>
											<li class="th size2"><p designElement="text" textIndex="89"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >사업자등록번호</p></li>
											<li class="td"><?php echo $TPL_VAR["config_basic"]["businessLicense"]?></li>
										</ul>
<?php }?>
<?php if($TPL_VAR["config_basic"]["mailsellingLicense"]){?>
										<ul>
											<li class="th size2"><p designElement="text" textIndex="90"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >통신판매신고번호</p></li>
											<li class="td"><?php echo $TPL_VAR["config_basic"]["mailsellingLicense"]?></li>
										</ul>
<?php }?>
<?php if($TPL_VAR["config_basic"]["companyPhone"]){?>
										<ul>
											<li class="th size2"><p designElement="text" textIndex="91"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >연락처</p></li>
											<li class="td"><?php echo $TPL_VAR["config_basic"]["companyPhone"]?></li>
										</ul>
<?php }?>
<?php if($TPL_VAR["config_basic"]["companyAddress"]){?>
										<ul>
											<li class="th size2"><p designElement="text" textIndex="92"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >사업장 소재지</p></li>
											<li class="td"><?php echo $TPL_VAR["config_basic"]["companyAddress"]?> <?php echo $TPL_VAR["config_basic"]["companyAddressDetail"]?></li>
										</ul>
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["provider"]["info_name"]){?>
										<ul>
											<li class="th size2"><p designElement="text" textIndex="93"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >상호명</p></li>
											<li class="td"><?php echo $TPL_VAR["provider"]["info_name"]?></li>
										</ul>
<?php }?>
<?php if($TPL_VAR["provider"]["info_ceo"]){?>
										<ul>
											<li class="th size2"><p designElement="text" textIndex="94"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >대표자</p></li>
											<li class="td"><?php echo $TPL_VAR["provider"]["info_ceo"]?></li>
										</ul>
<?php }?>
<?php if($TPL_VAR["provider"]["info_num"]){?>
										<ul>
											<li class="th size2"><p designElement="text" textIndex="95"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >사업자등록번호</p></li>
											<li class="td"><?php echo $TPL_VAR["provider"]["info_num"]?></li>
										</ul>
<?php }?>
<?php if($TPL_VAR["provider"]["info_selling_license"]){?>
										<ul>
											<li class="th size2"><p designElement="text" textIndex="96"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >통신판매신고번호</p></li>
											<li class="td"><?php echo $TPL_VAR["provider"]["info_selling_license"]?></li>
										</ul>
<?php }?>
<?php if($TPL_VAR["provider"]["info_phone"]){?>
										<ul>
											<li class="th size2"><p designElement="text" textIndex="97"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >연락처</p></li>
											<li class="td"><?php echo $TPL_VAR["provider"]["info_phone"]?><?php if($TPL_VAR["provider"]["info_email"]){?> / <?php echo $TPL_VAR["provider"]["info_email"]?><?php }?></li>
										</ul>
<?php }?>
<?php if($TPL_VAR["provider"]["info_address2"]){?>
										<ul>
											<li class="th size2"><p designElement="text" textIndex="98"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >사업장 소재지</p></li>
											<li class="td">
<?php if($TPL_VAR["provider"]["info_address1_street"]){?>
													<?php echo $TPL_VAR["provider"]["info_address1_street"]?>

<?php }else{?>
													<?php echo $TPL_VAR["provider"]["info_address1"]?>

<?php }?>
												<?php echo $TPL_VAR["provider"]["info_address2"]?>

											</li>
										</ul>
<?php }?>
<?php }?>
								</div>
								<div class="layer_bottom_btn_area">
									<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
								</div>
							</div>
						</div>
						<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
					</div>
				</li>
<?php }?>
				<!-- ~~~~~ //판매자 ~~~~~ -->
			</ul>

			<!-- ~~~~~~~~~~~ 구매하기 열기 섹션( 모바일 전용 ) ~~~~~~~~~~~ -->
			<div id="goodsBuyOpenSection" class="goods_buy_open_sections">
				<a href="javascript:void(0);" id="btnSectionOpen" class="btn_section_open off">열기</a>
				<ul class="goods_buttons_section">
<?php if($TPL_VAR["goods"]["goods_status"]=='normal'&&!$TPL_VAR["goods"]["string_price_use"]&&!$TPL_VAR["goods"]["string_button_use"]){?>
					<li>
						<ul class="basic_btn_area">
<?php if($TPL_VAR["talkbuyorder_tpl"]){?>
							<li class="talkbuy_area" style="display:none;"><button type="button" id="kpay_btn" class="btn_resp size_c"></button></li>
<?php }?>
<?php if($TPL_VAR["navercheckout_tpl"]){?>
							<li class="npay_area" style="display:none;"><button type="button" id="npay_btn" class="btn_resp size_c"></button></li>
<?php }?>
							<li><button type="button" id="buy_btn" class="btn_resp size_c color2"><span designElement="text" textIndex="99"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >구매하기</span></button></li>
						</ul>
					</li>
<?php }elseif($TPL_VAR["goods"]["string_button_use"]){?>
					<li><?php echo $TPL_VAR["goods"]["string_button"]?></li>
<?php }else{?>
<?php if($TPL_VAR["goods"]["goods_status"]=='runout'){?>
						<li>
<?php if($TPL_VAR["goods"]["restock_notify_use"]){?>
<?php }else{?>
<?php }?>
							<p class="text_soldout NpayNo" designElement="text" textIndex="100"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >품절</p>
						</li>
<?php }?>
<?php if($TPL_VAR["goods"]["goods_status"]=='purchasing'){?>
						<li><button type="button" style="width:100%;" class="btn_resp size_c NpayNo"><span designElement="text" textIndex="101"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >재고확보 중</span></button></li>
<?php }?>
<?php if(($TPL_VAR["goods"]["goods_status"]=='purchasing'&&serviceLimit('H_NFR'))||($TPL_VAR["goods"]["goods_status"]=='runout'&&$TPL_VAR["goods"]["restock_notify_use"])){?>
						<li><button type="button" style="width:100%;" class="restockOpenBtn btn_resp size_c color4 NpayNo"><span designElement="text" textIndex="102"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >재입고알림 신청</span></button></li>
<?php }?>
<?php if($TPL_VAR["goods"]["goods_status"]=='unsold'){?>
						<li><button type="button" style="width:100%;" class="btn_resp size_c color3 NpayNo"><span designElement="text" textIndex="103"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >판매중지</span></button></li>
<?php }?>
<?php }?>

<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'&&$TPL_VAR["sns"]["ntalk_use"]=='Y'&&$TPL_VAR["sns"]["ntalk_use_mobile_product"]=='Y'){?>
					<li>
						<button type="button" class="btn_naver_talk" onclick="window.open('https://talk.naver.com/<?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?><?php if($TPL_VAR["sns"]["ntalk_use_sniffet"]=='Y'){?>?ref='+encodeURIComponent(location.href)+'#nafullscreen'<?php }else{?>#nafullscreen'<?php }?>, 'talktalk', 'width=471, height=640'); return false;"><span designElement="text" textIndex="104"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >쇼핑할땐</span> &nbsp;<img src="/data/skin/responsive_sports_sporti_gl_1/images/icon/icon_talk.png" align="absmiddle" alt="네이버톡톡" />&nbsp; <span designElement="text" textIndex="105"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >톡톡하세요</span></button>
					</li>
<?php }?>
				</ul>
			</div>
			<!-- ~~~~~~~~~~~ 구매하기 열기 섹션( 모바일 전용 ) ~~~~~~~~~~~ -->

			<!-- ~~~~~~~~~~~ 구매하기 ~~~~~~~~~~~ -->
			<div id="goodsOptionBuySection" class="goods_buy_sections">
				<a href="javascript:void(0);" id="btnSectionClose" class="btn_section_close">닫기</a>

<?php if(!$TPL_VAR["goods"]["string_price_use"]){?>
				<div class="goods_option_select_area">
				<!-- 상품 옵션 인클루드. 파일위치 : [스킨폴더]/goods/_select_options.html -->
<?php $this->print_("OPTION_SELECT",$TPL_SCP,1);?>

				<!-- //상품 옵션 인클루드 -->
				</div>
<?php }?>

				<!-- 총 상품 금액 표기 시작-->
<?php if(!$TPL_VAR["goods"]["string_price_use"]&&$TPL_VAR["select_option_mode"]!='optional_change'){?>
				<div class="goods_price_area">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<!-- 단일옵션일 경우 수량 -->
<?php if(!(count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"])&&!$TPL_VAR["goods"]["string_price_use"]){?>
						<td class="num_single_area">
							<input type="hidden" name="option[0][0]" class="selected_options" type="hidden" value="" opt_seq="0" opt_group="0" />
							<input type="hidden" name="optionTitle[0][0]" class="selected_options_title" type="hidden" value="" opt_seq="0" opt_group="0" />
<?php if($TPL_VAR["cart_options"][ 0]['cart_option_seq']> 0){?>
							<input type="hidden" name="exist_option_seq[]" class="cart_option_seq" value="<?php echo $TPL_VAR["cart_options"][ 0]['cart_option_seq']?>" />
<?php }?>
							<button type="button" class="btn_graybox eaMinus">-</button><input type="number" name="optionEa[0]" value="<?php if($TPL_VAR["cart_options"][ 0]['ea']> 0){?><?php echo $TPL_VAR["cart_options"][ 0]['ea']?><?php }else{?>1<?php }?>" class="onlynumber ea_change" /><button type="button" class="btn_graybox eaPlus">+</button>
								<div style="display:none" class="optionPrice"><?php echo $TPL_VAR["goods"]["org_basic_price"]?></div>
						</td>
<?php }else{?>
<?php }?>
						<td class="total_goods_price">
							<span class="total_goods_tit" designElement="text" textIndex="106"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >총 상품금액</span>
<?php if(($TPL_VAR["goods"]["price"]>$TPL_VAR["goods"]["sale_price"])||($TPL_VAR["goods"]["consumer_price"]>$TPL_VAR["goods"]["sale_price"]&&$TPL_VAR["goods"]["event"]["target_sale"]== 1)){?>
<?php if($TPL_VAR["goods"]["sale_price"]> 0){?>
								<?php echo get_currency_price($TPL_VAR["goods"]["sale_price"], 2,'','<span id="total_goods_price">_str_price_</span> ')?>

<?php }else{?>
								<?php echo get_currency_price( 0, 2,'','<span id="total_goods_price">_str_price_</span> ')?>

<?php }?>
<?php }else{?>
							<?php echo get_currency_price($TPL_VAR["goods"]["price"], 2,'','<span id="total_goods_price">_str_price_</span> ')?>

<?php }?>
						</td>
					</tr>
					</table>
				</div>
<?php }?>
				<!-- 총 상품 금액 표기 끝-->

				<div class="goods_buttons_area">
<?php if($TPL_VAR["goods"]["string_button_use"]){?>
					<?php echo $TPL_VAR["goods"]["string_button"]?>

<?php }else{?>
					<ul class="goods_buttons_section">
<?php if($TPL_VAR["goods"]["goods_status"]=='normal'&&!$TPL_VAR["goods"]["string_price_use"]&&!$TPL_VAR["goods"]["string_button_use"]){?>
						<li>
							<ul class="basic_btn_area">
								<li><button type="button" name="addCart" id="addCart" class="btn_resp size_extra2 NpayNo"><span designElement="text" textIndex="107"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >장바구니</span></button></li>
<?php if($TPL_VAR["ship_summary"]["kr_direct_store_yn"]=='Y'||$TPL_VAR["ship_summary"]["gl_direct_store_yn"]=='Y'){?>
								<li>
									<button type="button" id="direct_store" class="btn_resp size_extra2 NpayNo"><span designElement="text" textIndex="108"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >매장픽업</span></button>
								</li>
<?php }?>
								<li><button type="button" id="buy" class="btn_resp size_extra2 color2 NpayNo"><span designElement="text" textIndex="109"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >구매하기</span></button></li>
							</ul>
						</li>
<?php }?>
<?php if($TPL_VAR["goods"]["goods_status"]=='runout'){?>
						<li>
<?php if($TPL_VAR["goods"]["restock_notify_use"]){?>
<?php }else{?>
<?php }?>
							<p class="text_soldout NpayNo" designElement="text" textIndex="110"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >품절</p>
						</li>
<?php }?>
<?php if($TPL_VAR["goods"]["goods_status"]=='purchasing'){?>
						<li>
							<button type="button" class="btn_resp size_c color3 Cd NpayNo"><span designElement="text" textIndex="111"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >재고확보 중</span></button>
						</li>
<?php }?>
<?php if(($TPL_VAR["goods"]["goods_status"]=='purchasing'&&serviceLimit('H_NFR'))||($TPL_VAR["goods"]["goods_status"]=='runout'&&$TPL_VAR["goods"]["restock_notify_use"])){?>
						<li>
							<button type="button" class="restockOpenBtn btn_resp size_c color4 NpayNo"><span designElement="text" textIndex="112"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >재입고알림 신청</span></button>
						</li>
<?php }?>
<?php if($TPL_VAR["goods"]["goods_status"]=='unsold'){?>
						<li>
							<button type="button" class="btn_resp size_c color3 NpayNo"><span designElement="text" textIndex="113"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >판매중지</span></button>
						</li>
<?php }?>
					</ul>
<?php }?>

<?php if($TPL_VAR["navercheckout_tpl"]){?>
						<div class="goods_npay">
							<div class="goods_npay_inner"><?php echo $TPL_VAR["navercheckout_tpl"]?></div>
						</div>
<?php }?>

<?php if($TPL_VAR["talkbuyorder_tpl"]){?>
						<div class="goods_talkbuy" style="display:none;">
							<div class="goods_talkbuy_inner"><?php echo $TPL_VAR["talkbuyorder_tpl"]?></div>
						</div>
<?php }?>

<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'&&$TPL_VAR["sns"]["ntalk_use"]=='Y'&&$TPL_VAR["sns"]["ntalk_use_mobile_product"]=='Y'){?>
					<div class="goods_naver_talk_pc">
						<button type="button" class="btn_naver_talk" onclick="window.open('https://talk.naver.com/<?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?><?php if($TPL_VAR["sns"]["ntalk_use_sniffet"]=='Y'){?>?ref='+encodeURIComponent(location.href)+'#nafullscreen'<?php }else{?>#nafullscreen'<?php }?>, 'talktalk', 'width=471, height=640'); return false;"><span designElement="text" textIndex="114"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >쇼핑할땐</span> &nbsp;<img src="/data/skin/responsive_sports_sporti_gl_1/images/icon/icon_talk.png" align="absmiddle" alt="네이버톡톡" />&nbsp; <span designElement="text" textIndex="115"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >톡톡하세요</span></button>
					</div>
<?php }?>
				</div>
			</div>
			<div class="goods_bg"></div>
			<!-- ~~~~~~~~~~~ //구매하기 ~~~~~~~~~~~ -->

			<ul class="goods_event_gift_area">
				<!-- ~~~~~ 이벤트 ~~~~~ -->
<?php if($TPL_VAR["sales"]["mtext_list"]['event']){?>
				<li class="goods_spec_event" style="display:none"><!-- 하단 관련 이벤트와 중복이라 hide 처리함( sjg ) -->
					<ul class="detail_event_area" onclick="detail_contents_toggle(this,'eventDetail'); if( $('#eventDetail').is(':hidden') ) $(this).removeClass('up'); else $(this).addClass('up');">
						<li class="th"><span designElement="text" textIndex="116"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >이벤트</span></li>
						<li>
							<?php echo $TPL_VAR["sales"]["subject_list"]['event']?>

						</li>
					</ul>
					<div id="eventDetail" class="detail_option_list x1 hide">
						<ul>
							<li>
								<p class="e_title"><?php echo $TPL_VAR["sales"]["subject_list"]['event']?></p>
								<div class="e_period">
									<?php echo $TPL_VAR["sales"]["evtPeriod"]['event']?>

<?php if($TPL_VAR["sales"]["alertEnd"]['event']){?>
									<span class="pointcolor">(<?php echo $TPL_VAR["sales"]["alertEnd"]['event']?>)</span>
<?php }?>
								</div>
								<div class="e_content">
<?php if($TPL_VAR["sales"]["descPopup"]['event']){?>
									<?php echo $TPL_VAR["sales"]["descPopup"]['event']?>

<?php }else{?>
									<?php echo $TPL_VAR["sales"]["text_list"]['event']?>

<?php }?>
								</div>
							</li>
						</ul>
					</div>
				</li>
<?php }?>
				<!-- ~~~~~ //이벤트 ~~~~~ -->

				<!-- ~~~~~ 사은품 ~~~~~ -->
<?php if($TPL_VAR["goods"]["gift"]&&$TPL_VAR["goods"]["gift"]["benifits"]){?>
				<li class="goods_spec_gift">
					<ul class="detail_event_area" onclick="detail_contents_toggle(this,'giftInterest'); if( $('#giftInterest').is(':hidden') ) $(this).removeClass('up'); else $(this).addClass('up');">
						<li class="th"><span designElement="text" textIndex="117"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >사은품</span></li>
						<li>
							<?php echo $TPL_VAR["goods"]["gift"]["title"]?> (<?php echo $TPL_VAR["goods"]["gift"]["start_date"]?> ~ <?php echo $TPL_VAR["goods"]["gift"]["end_date"]?><?php if($TPL_VAR["goods"]["gift"]["alertEnd"]){?> <span class="pointcolor"><?php echo $TPL_VAR["goods"]["gift"]["alertEnd"]?></span><?php }?>)
						</li>
					</ul>
					<div id="giftInterest" class="detail_option_list x1 hide">
						<ul>
<?php if(is_array($TPL_R1=$TPL_VAR["goods"]["gift"]["benifits"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<li>
								<p class="e_title"><?php echo $TPL_VAR["goods"]["gift"]["title"]?></p>
								<div class="e_period">
									<?php echo $TPL_VAR["goods"]["gift"]["start_date"]?> ~ <?php echo $TPL_VAR["goods"]["gift"]["end_date"]?>

<?php if($TPL_VAR["goods"]["gift"]["alertEnd"]){?> <span class="pointcolor"><?php echo $TPL_VAR["goods"]["gift"]["alertEnd"]?></span><?php }?>
								</div>
								<div class="e_content">
<?php if($TPL_VAR["goods"]["gift"]["goods_desc_popup"]){?>
									<?php echo $TPL_VAR["goods"]["gift"]["goods_desc_popup"]?>

<?php }else{?>
<?php if($TPL_VAR["goods"]["gift"]["gift_rule"]=='default'){?>
									<?php echo get_currency_price($TPL_V1["sprice"], 2)?> 이상 구매 시 사은품 증정
<?php }elseif($TPL_VAR["goods"]["gift"]["gift_rule"]=='price'){?>
									<?php echo get_currency_price($TPL_V1["sprice"], 2)?><?php if($TPL_V1["eprice"]> 0){?> ~ <?php echo get_currency_price($TPL_V1["eprice"], 2)?><?php }?> 구매 시 사은품 증정
<?php }elseif($TPL_VAR["goods"]["gift"]["gift_rule"]=='quantity'){?>
									<?php echo get_currency_price($TPL_V1["sprice"], 2)?><?php if($TPL_V1["eprice"]> 0){?> ~ <?php echo get_currency_price($TPL_V1["eprice"], 2)?><?php }?> 구매 시 사은품 <?php echo $TPL_V1["ea"]?>개 증정
<?php }?>
<?php }?>
								</div>
							</li>
<?php }}?>
						</ul>
					</div>
				</li>
<?php }?>
				<!-- ~~~~~ //사은품 ~~~~~ -->
			</ul>

			<!-- 오프라인 쿠폰 -->
			<div class="coupon_area">
				<!-- 쿠폰 템플릿. 파일위치 : _modules/display/coupon_display_detail_light.html -->
				<?php echo showCoupons('all','detail')?>

				<!-- //쿠폰 템플릿 -->
			</div>
			<!-- //오프라인 쿠폰 -->

		</form>
		</div>
		<!-- ++++++++++++++++++++++++ //상품 스펙 ++++++++++++++++++++++++ -->
	</div>

	<div id="goods_contents_quick" class="set_preload">

		<div id="goods_tabs" class="goods_tabs">
			<div class="resp_area">
				<div class="goods_information_tabs">
					<a href="#goods_contents_quick" class="current" onclick="open_information_tab(this,'goods_description');"><span designElement="text" textIndex="118"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >상세설명</span></a>
					<a href="#goods_contents_quick" id="goodsReviewLoad" onclick="open_information_tab(this,'goods_review');"><span><span designElement="text" textIndex="119"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >상품후기</span> <?php if($TPL_VAR["goods"]["review_count"]){?><span class="num"><?php echo number_format($TPL_VAR["goods"]["review_count"])?></span><?php }?></span></a>
					<a href="#goods_contents_quick" id="goodsQnaLoad" onclick="open_information_tab(this,'goods_qna');"><span><span designElement="text" textIndex="120"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >상품문의</span> <?php if($TPL_VAR["goods"]["qna_count"]){?><span class="num"><?php echo number_format($TPL_VAR["goods"]["qna_count"])?></span><?php }?></span></a>
					<a href="#goods_contents_quick" onclick="open_information_tab(this,'exchange_guide');"><span designElement="text" textIndex="121"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >교환/반품/<span class="Dib">배송</span></span></a>
				</div>
			</div>
		</div>
		<script>
		var goodsTabsTop = $('#goods_tabs').offset().top;
		//var goodsTabsMargin = 180;
		function open_information_tab(thisTab,type){
			$(".goods_information_tabs>a.current").removeClass('current');
			$(thisTab).addClass('current');

			$(".goods_information_contents").hide();
			$('.info_goods_add').hide();
			$('.info_goods_add_map').hide();
			$('.info_goods_add_bigdata').hide();
			$('.info_goods_add_relation').hide();
			$('.'+type).show();
			if( type == 'goods_description' || type == 'exchange_guide' ) {
				$('.info_goods_add').show();
				if( type == 'goods_description' ) {
					$('.info_goods_add_map').show();
					$('.info_goods_add_bigdata').show();
					$('.info_goods_add_relation').show();
				}
			}
			/*
			if ( $('#goods_tabs').hasClass('flyingMode') ) {
				if ( window.innerWidth > 1024 ) { // PC인 경우 모션 실행
					$('html, body').animate({ scrollTop : (goodsTabsTop - goodsTabsMargin) }, 300);
					return false;
				}
			}
			*/
		}
		$(function() {
			var scrollPosition, tabHeight, goodsTabsTop2;
			tabHeight = $('#goods_tabs').outerHeight();
			goodsTabsTop2 = $('#goods_tabs').offset().top;
			$(window).scroll(function() {
				scrollPosition = $(window).scrollTop();
				if ( scrollPosition > goodsTabsTop2 ) {
					$('#goods_tabs').addClass('flyingMode');
					if ( $('#gon').length < 1 ) {
						$('#goods_tabs').after('<div id="gon" style="height:' + tabHeight + 'px"></div>');
					}
				} else {
					if ( $('#goods_tabs').hasClass('flyingMode') ) {
						$('#goods_tabs').removeClass('flyingMode');
					}
					$('#gon').remove();
				}
			});
			$( window ).resize(function() {
				if ( window.innerWidth != WINDOWWIDTH ) {
					tabHeight = $('#goods_tabs').outerHeight();
					goodsTabsTop2 = $('#goods_tabs').offset().top;
				}
			});
		});
		</script>

		<!-- 상품상세설명 -->
		<div class="goods_information_contents goods_description">
<?php if($TPL_VAR["goods"]["mobile_contents_images_true"]){?>
			<ul class="guide_origin_image">
				<li><p designElement="text" textIndex="122"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >상세설명 이미지를 자유롭게 확대/축소하시려면 <a href="/goods/view_contents?no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&zoom=1">원본 보기</a>에서 가능합니다.</p></li>
				<li class="btn_area">
					<button type="button" class="btn_resp size_b" onclick="document.location.href='/goods/view_contents?no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&zoom=1';"><span designElement="text" textIndex="123"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >원본 보기</span></button>
				</li>
			</ul>
<?php }?>

			<div class="goods_description_images goods_view_contents">
<?php if(!$TPL_VAR["preload"]){?>
				<?php echo $TPL_VAR["goods"]["mobile_contents"]?>

<?php }?>
			</div>
		</div>

		<!-- 상품후기 -->
		<div class="goods_information_contents goods_review hide" id="goods_review_frame_div"><!-- 상품후기 게시판 가져옴 --></div>

		<!-- 상품문의 -->
		<div class="goods_information_contents goods_qna hide" id="goods_qna_frame_div"><!-- 상품문의 게시판 가져옴 --></div>

		<!-- 교환/반품/배송 -->
		<div class="goods_information_contents exchange_guide hide">

<?php if($TPL_VAR["goods"]["common_contents_images_true"]){?>
			<ul class="guide_origin_image">
				<li><p designElement="text" textIndex="124"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >상세설명 이미지를 자유롭게 확대/축소하시려면 <a href="/goods/view_common_contents?no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&zoom=1">원본 보기</a>에서 가능합니다.</p></li>
				<li class="btn_area">
					<button type="button" class="btn_resp size_b" onclick="document.location.href='/goods/view_common_contents?no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&zoom=1';"><span designElement="text" textIndex="125"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >원본 보기</span></button>
				</li>
			</ul>
<?php }?>

			<div class="goods_description_images goods_common_contents">
<?php if(!$TPL_VAR["commonpreload"]){?>
				<?php echo $TPL_VAR["goods"]["common_contents"]?>

<?php }?>
			</div>

		</div>


<?php if($TPL_VAR["goods"]["m_mapview"]=='Y'){?>
		<div class="info_goods_add_map">
			<table class="info_goods_spec_table" width="100%" cellpadding="0" cellspacing="0" border="0">
			<col width="110" /><col />
			<tr>
				<th class="gst_th">위치안내</th>
				<td class="gst_td">
				</td>
			</tr>
			<tr>
				<td class="gst_sub" colspan="2">
					<!-- 티켓상품 위치 안내 : 시작 -->
					<div class="goods_mapview" style="padding:10px;align-text:center;">
						<div style="margin:-20px;padding-bottom:10px;">
							<?php echo showNaverMapApi('300','300',$TPL_VAR["mapArr"][ 0]['address'],$TPL_VAR["mapArr"][ 0]['option'])?>

						</div>
						<div id="map_area"></div>
						<table cellpadding="0" cellspacing="0" border="0" width="100%" style="line-height:17px;">
						<tr>
							<td width="50px">업체명</td><td width="5px"> : </td>
							<td>
								<select name="option_location" id="option_location" >
<?php if($TPL_mapArr_1){foreach($TPL_VAR["mapArr"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1["o_seq"]?>" goods_seq="<?php echo $_GET["no"]?>" ><?php echo $TPL_V1["option"]?></option>
<?php }}?>
								</select>
								<button type="button" onclick="setMapajax();">보기</button>
							</td>
						</tr>
						<tr>
							<td>주소</td><td> : </td>
							<td id="address"><?php echo $TPL_VAR["mapArr"][ 0]['address']?></td>
						</tr>
						<tr>
							<td></td><td></td>
							<td id="street"><?php echo $TPL_VAR["mapArr"][ 0]['address_street']?></td>
						</tr>
						<tr>
							<td>전화번호</td><td> : </td>
							<td id="biztel"><?php echo $TPL_VAR["mapArr"][ 0]['biztel']?></td>
						</tr>
						</table>
					</div>
					<!-- 티켓상품 위치 안내 : 끝 -->
				</td>
			</tr>
			</table>
		</div>
		<!-- //위치안내 -->
<?php }?>

<?php if($TPL_VAR["bigdata"]){?>
		<div class="sbt_relation_contents_new info_goods_add_bigdata">
<?php if($TPL_bigdata_1){foreach($TPL_VAR["bigdata"] as $TPL_V1){?>
			<h3 class="title_sub1 bigdata"><?php echo $TPL_V1["textStr"]?></h3>
			<div class="bigdata-goods-list">
				<?php echo $TPL_V1["display"]?>

			</div>
<?php }}?>
		</div>
		<!-- //빅데이터 -->
<?php }?>

<?php if($TPL_VAR["event_banner"]){?>
		<h3 class="title_sub1"><span designElement="text" textIndex="126"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >관련 이벤트</span></h3>
		<ul class="detail_relation_event">
<?php if($TPL_event_banner_1){foreach($TPL_VAR["event_banner"] as $TPL_V1){?>
			<li><a href="/promotion/<?php echo $TPL_V1["type"]?>_view?<?php echo $TPL_V1["type"]?>=<?php echo $TPL_V1["seq"]?>" target="_blank" title="새창"><span class="title"><?php echo $TPL_V1["title"]?></span><span class="date">(<?php echo $TPL_V1["start_date"]?> ~ <?php echo $TPL_V1["end_date"]?>)</span><span class="e_desc"><?php echo $TPL_V1["goods_desc_popup"]?></span></a></li>
<?php }}?>
		</ul>
<?php }?>

<?php if($TPL_VAR["goodsRelationDisplayHTML"]){?>
		<h3 class="title_sub1"><span designElement="text" textIndex="127"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >관련상품</span></h3>
		<!-- EYE-Design 켜고 클릭해서 관련상품 디스플레이 수정 가능. ( 노출할 상품 설정은, 관리자 > 판매상품 > 상품상세 > 관련상품 ) -->
		<?php echo $TPL_VAR["goodsRelationDisplayHTML"]?>

<?php }?>

<?php if($TPL_VAR["goodsRelationSellerDisplayHTML"]){?>
		<h3 class="title_sub1"><span designElement="text" textIndex="128"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >판매자 인기상품</span></h3>
		<!-- EYE-Design 켜고 클릭해서 판매자 인기상품 디스플레이 수정 가능. ( 노출할 상품 설정은, 관리자 > 판매상품 > 상품상세 > 판매자 인기상품 ) -->
		<?php echo $TPL_VAR["goodsRelationSellerDisplayHTML"]?>

<?php }?>

	</div>
</div>

<div id="couponDownloadDialog" class="hide"></div>

<!-- 재입고 알림 레이어 -->
<div id="restockNotifyApply" class="resp_layer_pop hide">
	<h4 class="title"><span designElement="text" textIndex="129"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzEvZ29vZHMvdmlldy5odG1s" >재입고 알림</span></h4>
	<div class="y_scroll_auto">
		<div class="layer_pop_contents v3">
		</div>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>
<!--<div id="restock_notify_apply" class="hide"></div>-->

<!-- 회원등급별 혜택 안내 -->
<div id="memberBenefitDetailDialog" class="hide">
	<table class="ddlTable" width="100%">
	<col width="100" />
<?php if(is_array($TPL_R1=$TPL_VAR["goods"]["group_benifits"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["group_seq"]&&($TPL_V1["sale_price"]> 0||$TPL_V1["reserve_price"]> 0||$TPL_V1["point_price"]> 0)){?>
	<tr>
		<th><?php echo $TPL_V1["group_name"]?></th>
		<td>
<?php if($TPL_V1["sale_price"]> 0){?>
<?php if($TPL_V1["sale_price_type"]=='PER'){?>
			<?php echo floor($TPL_V1["sale_price"])?>% 추가할인
<?php }else{?>
			<?php echo get_currency_price($TPL_V1["sale_price"], 2)?> 추가할인
<?php }?>
<?php if($TPL_V1["sale_use"]=='Y'&&$TPL_V1["sale_limit_price"]> 0){?>
			(<?php echo get_currency_price($TPL_V1["sale_limit_price"], 2)?> 이상 구매 시)
<?php }?>
<?php }?>
<?php if($TPL_V1["sale_price"]> 0&&($TPL_V1["reserve_price"]> 0||$TPL_V1["point_price"]> 0)){?>
			<br />
<?php }?>
<?php if($TPL_V1["reserve_price"]> 0){?>
<?php if($TPL_V1["reserve_price_type"]=='PER'){?>
			{floor(.reserve_price)}%추가적립
<?php }else{?>
			<?php echo get_currency_price($TPL_V1["reserve_price"], 2)?> 추가적립
<?php }?>
<?php }?>

<?php if($TPL_V1["point_price"]> 0){?>
<?php if($TPL_V1["point_price_type"]=='PER'){?>
			{floor(.point_price)}%추가포인트
<?php }else{?>
			<?php echo get_currency_price($TPL_V1["point_price"])?>P 추가포인트
<?php }?>
<?php }?>

<?php if($TPL_V1["reserve_price"]> 0||$TPL_V1["point_price"]> 0){?>
<?php if($TPL_V1["point_use"]=='Y'&&$TPL_V1["point_limit_price"]> 0){?>
			(<?php echo get_currency_price($TPL_V1["point_limit_price"], 2)?> 이상 구매 시)
<?php }?>
<?php }?>
		</td>
	</tr>
<?php }?>
<?php }}?>
	</table>
</div>

<!-- 위시 클릭시 레이어창 -->
<div id="wish_alert">
	<div class="wa_on"></div>
	<div class="wa_off"></div>
	<div class="wa_msg"></div>
</div>

<!-- 즐겨찾기 레이어 -->
<div id="myshop_favorite_alert" class="myshop_favorite_alert">
	<div class="cfa_on"></div>
	<div class="cfa_off"></div>
	<div class="cfa_msg"></div>
</div>

<!-- 해외배송 안내 콘텐츠. 파일위치 : [스킨폴더]/goods/_international_shipping_info.html -->
<?php $this->print_("INTERNATIONAL_SHIPPING_INFO",$TPL_SCP,1);?>

<!-- //해외배송 안내 콘텐츠 -->

<script type="text/javascript">
$(function() {

	// 재입고 알림
	$('.restockOpenBtn').on('click', function() {
		$.get('restock_notify_apply?goods_seq=<?php echo $TPL_VAR["goods"]["goods_seq"]?>', function(data) {
			$('#restockNotifyApply .layer_pop_contents').html(data);
			showCenterLayer('#restockNotifyApply');
		});
	});

	$('#btnSnsShare').click(function() {
		if ( $('#snsListDetail').is(':hidden') ) {
			$('#snsListDetail').show();
		} else {
			$('#snsListDetail').hide();
		}
	});

	$('#goodsReviewLoad').one('click', function() {
		$("div#goods_review_frame_div").html('<iframe name="goods_review_frame" id="goods_review_frame" src="/board/?id=goods_review&goods_seq=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&iframe=1&gdviewer=1" width="100%" height="500" frameborder="0" scrolling="no" allowTransparency="true"></iframe>');
	});
	$('#goodsQnaLoad').one('click', function() {
		$("div#goods_qna_frame_div").html('<iframe name="goods_qna_frame" id="goods_qna_frame" src="/board/?id=goods_qna&goods_seq=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&iframe=1&gdviewer=1" width="100%" height="500" frameborder="0" scrolling="no" allowTransparency="true"></iframe>');
	});
});

</script>