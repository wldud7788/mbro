<?php /* Template_ 2.2.6 2022/05/17 12:29:22 /www/music_brother_firstmall_kr/selleradmin/skin/default/order/order_export_popup.html 000090366 */ 
$TPL_ship_set_code_1=empty($TPL_VAR["ship_set_code"])||!is_array($TPL_VAR["ship_set_code"])?0:count($TPL_VAR["ship_set_code"]);
$TPL_ordershipping_1=empty($TPL_VAR["ordershipping"])||!is_array($TPL_VAR["ordershipping"])?0:count($TPL_VAR["ordershipping"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<script type="text/javascript">
	var today = "<?php echo date('Y-m-d')?>";
	var week = "<?php echo date('Y-m-d',strtotime('-1 week'))?>";
	var mon = "<?php echo date('Y-m-d',strtotime('-1 month'))?>";
	var mon3 = "<?php echo date('Y-m-d',strtotime('-3 month'))?>";
	var gf_deliveryCode = "<?php echo $TPL_VAR["gf_config"]["gf_deliveryCode"]?>";
<?php if($TPL_VAR["ordershipping"]){?>
	var chk_export_msg = '출고처리할 주문을 선택하세요.';
<?php }else{?>
	var chk_export_msg = '출고처리할 주문이 없습니다. 주문을 검색하세요.';
<?php }?>
</script>
<script type="text/javascript" src="/app/javascript/js/admin-orderExportPopup.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-shipping.js"></script>
<script type="text/javascript">
	var keyword			= "<?php echo $TPL_VAR["sc"]["keyword"]?>";
	var search_type		= "<?php echo $TPL_VAR["sc"]["search_type"]?>";

	var now_get_step			= {};
<?php if(is_array($TPL_R1=$_GET["step"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>now_get_step[<?php echo $TPL_K1?>]	= '<?php echo $TPL_V1?>';<?php }}?>

	function set_goods_list(member_seq,order_seq,item_seq,option_seq,cart_table){

		var param		= "";
		var displayId	= "export_goods_selected_";

		param			= "&order_seq="+order_seq+"&member_seq="+member_seq+"&displayId="+displayId+"&cart_table="+cart_table;
		param			= param +"&item_seq="+item_seq+"&option_seq="+option_seq;

		$.ajax({
			type: "get",
			url: "/selleradmin/goods/select_new",
			data: "page=1"+param,
			success: function(result){
				$("div#"+displayId).html(result);
			}
		});
		openDialog("상품 검색", displayId, {"width":"1000","height":"700","show" : "fade","hide" : "fade"});
	}

	$( document ).ready(function() {
		$(".all-check").toggle(function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',true);
		},function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',false);
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

		// 검색어 레이어 박스 : start
		$("#search_keyword").keyup(function () {
			if ($(this).val()) {
				$('.txt_keyword').text($(this).val());
				searchLayerOpen();
			}else{
				$('.searchLayer').hide();
			}
		});

		$("#search_keyword").focus(function () {
			if ($(this).val() && $(this).val()!=$(this).attr('title')) {
				$('.txt_keyword').text($(this).val());
				searchLayerOpen();
			}
		});

		$("a.link_keyword").click(function () {
			var sType = $(this).attr('s_type');
			$('#search_type').val(sType);
			$('.searchLayer').hide();
			go_search_export();
		});

		$("#search_keyword").blur(function(){
			if("<?php echo $_GET["keyword"]?>" == $("#search_keyword").val()){
				$(".search_type_text").show();
			}
			setTimeout(function(){
				$('.searchLayer').hide()}, 500
			);
		});

		var offset = $("#search_keyword").offset();
		$('.search_type_text').css({
			'position' : 'absolute',
			'z-index' : 999,
			'left' : 0,
			'top' : 0,
			'width':$("#search_keyword").width()-1,
			'height':$("#search_keyword").height()-5
		});

<?php if($_GET["search_type"]){?>
		$('.search_type_text').show();
<?php }?>

			$(".search_type_text").click(function () {
				$(".search_type_text").hide();
				$("#search_keyword").focus();
			});

			$(".searchLayer ul li").hover(function() {
				$(".searchLayer ul li").removeClass('hoverli');
				$(this).addClass('hoverli');
			});

			$("#search_keyword").keydown(function (e) {
				var searchbox = $(this);

				switch (e.keyCode) {
					case 40:
						if($('.searchUl').find('li.hoverli').length == 0){
							$('.searchUl').find('li:first-child').addClass('hoverli');
						}else{
							if($('.searchUl').find('li:last-child').hasClass("hoverli") ){
								$('.searchUl').find('li::last-child.hoverli').removeClass('hoverli');
								$('.searchUl').find('li:first-child').addClass('hoverli');
							}else{
								$('.searchUl').find('li:not(:last-child).hoverli').removeClass('hoverli').next().addClass('hoverli');
							}
						}
						break;
					case 38:
						if($('.searchUl').find('li.hoverli').length == 0){
							$('.searchUl').find('li:last-child').addClass('hoverli');
						}else{
							if($('.searchUl').find('li:first-child').hasClass("hoverli")){
								$('.searchUl').find('li::first-child.hoverli').removeClass('hoverli');
								$('.searchUl').find('li:last-child').addClass('hoverli');
							}else{
								$('.searchUl').find('li:not(:first-child).hoverli').removeClass('hoverli').prev().addClass('hoverli');
							}
						}
						break;
					case 13 :
						var index=0;
						$('.searchUl').find('li').each(function(){
							if($(this).hasClass("hoverli")){
								index=$(this).index();
							}
						});

						$('.searchUl').find('li>a').eq(index).click();
						e.keyCode = null;
						//return false;
						break;
				}
			});
			// 검색어 레이어 박스 : end

			var exportBarPositionTop = $("#export-bar").offset().top;
			$(document).scroll(function(){
				if($(document).scrollTop()>exportBarPositionTop){
					$("#export-bar-area").height($("#export-bar").outerHeight());
					$("#export-bar").addClass('flying');
				}else{
					$("#export-bar").removeClass('flying');
				}
			});

			$("#btn_no_matching_info").click(function(){
				var title = '주의) 미매칭 상품의 출고';
				openDialog(title, "no_matching_dialog", {"width":"600","height":"470"});
			});

			$("#btn_bundle_info").click(function(){
				var title = '안내) 합포장(묶음배송)';
				openDialog(title, "bundle_dialog", {"width":"680","height":"200"});
			});

			$("#set_default_setting_button").click(function(){
				var title = '기본검색 설정<span style="font-size:11px; margin-left:26px;"> - 아래서 원하는 검색조건을 설정하여 편하게 쇼핑몰을 운영하세요</span>';
				openDialog(title, "search_detail_dialog", {"width":"1220","height":"300"});
			});



			$( "select[name='provider_seq_selector']" )
					.combobox()
					.change(function(){
						if( $(this).val() > 0 ){
							$("input[name='provider_seq']").val($(this).val());
							$("input[name='provider_name']").val($("option:selected",this).text());
						}else{
							$("input[name='provider_seq']").val('');
							$("input[name='provider_name']").val('');
						}
					})
					.next(".ui-combobox").children("input").bind('focus click',function(){
				if($(this).val()==$( "select[name='provider_seq_selector'] option:first-child" ).text()){
					$(this).val('');
					$( "select[name='provider_seq_selector']").next(".ui-combobox").children("a.ui-combobox-toggle").click();

				}
			});

<?php if($_GET["provider_seq"]){?>
			$("input[name='provider_name']").val($("select[name='provider_seq_selector'] option:selected",this).text());
<?php }?>

<?php if($TPL_VAR["system"]["goodsflow_use"]=='1'){?>
				goodsflow_set(true);
<?php }?>

<?php if(!$_GET["keyword"]){?>
					setTimeout(function(){
						$("#search_keyword").focus();
					},400);
<?php }else{?>
					setTimeout(function(){
						$(".barcode").eq(0).focus();
					},400);
<?php }?>
						check_bg();
<?php if($_GET["seq"][ 0]){?>
						close_search_form();
<?php }else{?>
						open_search_form();
<?php }?>

						//개별출고 제한 @2016-03-31
						$("input.export_ea_opt").bind("change",function(){
							var row = $(this).closest("tbody");
							var item_seq = $(this).attr("item_seq")
							var chk_individual_export = row.find("tr.open-tr input[name='chk_individual_export["+item_seq+"]']").val();
							//개별출고가 불가한 필수옵션 상품일때 추가옵션 제한
							if(chk_individual_export!='1') {
								if(parseInt($(this).val())==parseInt($(this).attr("org")) ) {//주문수량만큼 모두 출고시 추가옵션 제한
									row.find("input.export_ea[opt_type='sub']").each(function(){
										if( item_seq == $(this).attr("item_seq") ) {
											$(this).val($(this).attr("org")).attr("readonly",true).addClass("disabled");
											reset_barcode_ea(this);check_request_ea(this,$(this).attr("org"));
										}
									});
								}else if(parseInt($(this).val())==0){//출고수량이 0 이면 추가옵션 제한
									row.find("input.export_ea[opt_type='sub']").each(function(){
										if( item_seq == $(this).attr("item_seq") ) {
											$(this).val(0).attr("readonly",true).addClass("disabled");
											reset_barcode_ea(this);check_request_ea(this,$(this).attr("org"));
										}
									});
								}else{
									row.find("input.export_ea[opt_type='sub']").removeAttr("readonly").removeClass("disabled");
								}
							}
						}).change();


					});
</script>
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/searchform.css" />
<style type="text/css">
	.tip-darkgray {z-index:10000; left:0px; top:0px;}

	/* 출고내역 테이블 */
	table td.info {border:1px solid #ddd;  padding:0px 0px 0px 0px;}
	span.goods_name1 {display:inline-block;height:white-space:nowrap;overflow:hidden;width:450px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	span.remind_ea { display:inline-block;text-align:right;width:20px; }
	span.order-item-image {display:inline-block;}
	span.order-item-image img {border:1px solid #ccc; width:30px; height:30px; vertical-align:middle;}

	table.export_table {border-collapse:collapse;border:1px solid #c8c8c8;width:100%}
	table.export_table th {padding:5px; border:1px solid #c8c8c8;}
	table.export_table td {padding:5px; border:1px solid #c8c8c8;}
	table.export_table th {background-color:#efefef;}

	table.search_export_tbl {border-collapse:collapse;border:1px solid #c8c8c8;width:100%;}
	table.search_export_tbl th {padding:5px; border:1px solid #c8c8c8;}
	table.search_export_tbl td {padding:5px; border:1px solid #c8c8c8;}
	table.search_export_tbl th {background-color:#efefef;}

	#export-bar {position:relative;border-bottom:0px}
	#export-bar.flying {position:fixed;width:100%;left:0px;top:0px; z-index:100; background:url('/admin/skin/default/images/common/tit_bg_rollover.png') repeat-x;}
	#export-bar.flying .export-bar-inner {padding:0 10px;}

	.ui-combobox {
		position: relative;
		display: inline-block;
	}
	.ui-combobox-toggle {
		position: absolute;
		top: 0;
		bottom: 0;
		margin-left: -1px;
		padding: 0;
		/* adjust styles for IE 6/7 */
		*height: 1.7em;
		*top: 0.1em;
	}
	.ui-combobox-input {
		margin: 0;
		padding: 0.3em;
	}
	.ui-autocomplete {
		max-height: 200px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
	}
	div.search-form-container {border-top:1px solid #d6d6d6;color:#797d86;}
	div.search-form-container select {border:1px solid #d6d6d6;color:#797d86;}
	div.search-form-container input {border:1px solid #d6d6d6;color:#797d86;}

	span.cyanblue-info {color:#0082ec;font-weight:bold;font-family:tahoma;letter-spacing:-1px;}
	.barcode_ready { border:1px solid #ff3232 !important; background:#ea95bd; }
	.barcode_complete { border:1px solid #0033ff !important; background:#95afff; }

	/* 배송주소 */
	table.rec-info tr td span {font-size:11px;}
	table.rec-info tr td span.separator {display:inline-block; color:#999999; padding:0px 5px 0px 5px;}
	table.rec-info tr td span.member {color:#0066cc;}
	table.rec-info tr td span.nomember {color:#444445;}
	table.rec-info tr td span.tel {color:#999999;}
	table.rec-info tr td span.addr {color:#444445;}
	table.rec-info tr td span.memo {color:#fb8200;}

	div#export-bar-area {padding-top:5px;}
<?php if($TPL_VAR["data_search_default"]["order_detail_view"]!='close'){?>
	tr.close-tr {display:none;}
<?php }else{?>
	tr.open-tr {display:none;}
<?php }?>

	.warehouse-info-lay { padding:5px;margin:2px 10px 5px 0px;border:1px solid #c5c5c5;background-color:#fff; }

	table.table-export-info {border-collapse:collapse;}
	table.table-export-info th {background-color:#EDEDED; height:24px; line-height:24px; border:1px solid #c8c8c8; color:#666; font-weight:normal;}
	table.table-export-info td {padding:5px 0; border-bottom:1px solid #d7d7d7; color:#666}

	table.table-export-info th.remain-ea {height:100%; background:url('/selleradmin/skin/default/images/design/th_bg_orange.gif') repeat-x left top;}
	table.table-export-info td.remain-ea {background-color:#fefbf1 !important;}

	table.table-export-info th.export-ea {height:100%; background:url('/selleradmin/skin/default/images/design/th_bg_blue.gif') repeat-x left top;}
	table.table-export-info th.export-ea {border-top:2px solid #8fbcec;}
	table.table-export-info th.export-ea-left {border-left:2px solid #8fbcec;}
	table.table-export-info th.export-ea:last-child {border-right:2px solid #8fbcec;}

	table.table-export-info td.export-ea-left {border-left:2px solid #8fbcec;}
	table.table-export-info td.export-ea:last-child {border-right:2px solid #8fbcec;}

	table.table-export-info tr:last-child td.export-ea {border-bottom:2px solid #8fbcec;}
	table.table-export-info td.suboption {background-color:#f6f6f6;height:25px;}

	table td.null,table th.null { border:0px; background:#fff }

	#not_to_be_bundle table.info-table-style .its-th{text-align:center; padding-left:0; font-weight: bold;};
	#not_to_be_bundle table.info-table-style .its-td{text-align:left; padding-top:15px; background-color:#f90 };
	#not_to_be_bundle table.info-table-style .its-td .info{background-color:#f90};
</style>

<form name="order_export" id="goods_export" method="post" action="../order_process/order_export_popup" target="export_frame" onsubmit="loadingStart();" autocomplete="off">

	<input type="hidden" name="check_mode" value="check" />
	<input type="hidden" name="export_mode" value="<?php echo $_GET["mode"]?>" />
	<input type="hidden" name="mode" value="goods" />
	<input type="hidden" name="status" value="<?php echo $_GET["status"]?>" />
	<input type="hidden" name="each_shipping_seq" value="" />
	<input type="hidden" name="each_item_option_seq" value="" />
	<input type="hidden" name="each_shipping_method" value="" />


	<div style="padding:5px 0px 5px;" align="center">
		<table class="export-tab-tbl" style="border-collapse:collapse" border='1'>
			<tr>
				<td class="center on">주문 → 출고처리 <img src="/admin/skin/default/images/common/icon/check_icon.png" /></td>
				<td class="center">
					<a href="../export/batch_status">출고 → 출고상태변경</a>
				</td>
			</tr>
		</table>
	</div>
	<div class="search-form-container">
		<table class="search-form-table">
			<tr>
				<td>
					<table width="800" border="0">
						<tr>
							<td width="415">
								<table class="sf-keyword-table">
									<tr>
										<td class="sfk-td-txt">
											<div class="relative">
												<input type="text" name="keyword" id="search_keyword" value="<?php echo $_GET["keyword"]?>" title="주문번호,아이디,주문자,수령자,입금자,이메일,연락처,휴대폰,상품명,상품번호,상품코드" />
												<!-- 검색어 입력시 레이어 박스 : start -->
												<div class="search_type_text hide"><?php echo $_GET["search_type_text"]?></div>
												<div class="searchLayer hide">
													<input type="hidden" name="search_type" id="search_type" value="" />
													<ul class="searchUl">
														<li><a class="link_keyword" s_type="order_seq" href="#">주문번호: <span class="txt_keyword"></span> <span class="txt_title">-주문번호 찾기</span></a></li>
														<li><a class="link_keyword" s_type="userid" href="#">아이디: <span class="txt_keyword"></span> <span class="txt_title">-아이디 찾기</span></a></li>
														<li><a class="link_keyword" s_type="order_user_name" href="#">주문자: <span class="txt_keyword"></span> <span class="txt_title">-주문자 찾기</span></a></li>
														<li><a class="link_keyword" s_type="recipient_user_name" href="#">수령자: <span class="txt_keyword"></span> <span class="txt_title">-수령자 찾기</span></a></li>
														<li><a class="link_keyword" s_type="depositor" href="#">입금자: <span class="txt_keyword"></span> <span class="txt_title">-입금자 찾기</span></a></li>
														<li><a class="link_keyword" s_type="order_email" href="#">이메일: <span class="txt_keyword"></span> <span class="txt_title">-이메일 찾기</span></a></li>
														<li><a class="link_keyword" s_type="order_phone" href="#">연락처: <span class="txt_keyword"></span> <span class="txt_title">-연락처 찾기</span></a></li>
														<li><a class="link_keyword" s_type="order_cellphone" href="#">휴대폰: <span class="txt_keyword"></span> <span class="txt_title">-휴대폰 찾기</span></a></li>
														<li><a class="link_keyword" s_type="goods_name" href="#">상품명: <span class="txt_keyword"></span> <span class="txt_title">-상품명 찾기</span></a></li>
														<li><a class="link_keyword" s_type="goods_seq" href="#">상품번호: <span class="txt_keyword"></span> <span class="txt_title">-상품번호: 찾기</span></a></li>
														<li><a class="link_keyword" s_type="goods_code" href="#">상품코드: <span class="txt_keyword"></span> <span class="txt_title">-상품코드 찾기</span></a></li>
														<li><a class="link_keyword" s_type="npay_order_id" href="#">N페이주문번호: <span class="txt_keyword"></span> <span class="txt_title">-N페이주문번호 찾기</span></a></li>
														<li><a class="link_keyword" s_type="npay_product_order_id" href="#">N페이상품주문번호: <span class="txt_keyword"></span> <span class="txt_title">-N페이상품주문번호 찾기</span></a></li>
													</ul>
												</div>
												<!-- 검색어 입력시 레이어 박스 : end -->
											</div>
										</td>
										<td class="sfk-td-btn"><button type="button" onclick="go_search_export();"><span>검색</span></button></td>
									</tr>
								</table>
							</td>
							<td align="right">
								<button type="button" id="set_default_setting_button" title="기본검색설정" class="ml10" onclick=""></button>
								<button type="button" id="set_default_apply_button" onclick="set_default_search_form();" title="기본검색적용"></button>
								<button type="button" id="search_reset_button" title="검색초기화" onclick="reset_search_form();"></button>
								<button type="button" id="search_detail_button" class="close" value="open" title="상세검색닫기▲"></button>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table class="search-form-table search-detail-lay search_detail_form" id="serch_tab">
			<tr id="goods_search_form" style="display:block;">
			<tr>
				<td align="center">
					<table class="sf-option-table" border="0">
						<col width="70" /><col width="630" /><col width="60" /><col width="415" /><col width="105" />
						<tr>
							<th>
								<select name="date_field">
									<option value="regist_date" <?php if($_GET["date_field"]=='regist_date'||!$_GET["date_field"]){?>selected<?php }?>>주문일</option>
									<option value="deposit_date" <?php if($_GET["date_field"]=='deposit_date'){?>selected<?php }?>>입금일</option>
								</select>
							</th>
							<td>
								<input type="text" name="regist_date[]" value="<?php echo $_GET["start_search_date"]?>" class="datepicker line"  maxlength="10" size="9" />
								&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
								<input type="text" name="regist_date[]" value="<?php echo $_GET["end_search_date"]?>" class="datepicker line" maxlength="10" size="9" />
								<span class="btn small"><input type="button" value="오늘" onclick="set_date('<?php echo date('Y-m-d')?>','<?php echo date('Y-m-d')?>')" style="border:0;" /></span>
								<span class="btn small"><input type="button" value="3일간" onclick="set_date('<?php echo date('Y-m-d',strtotime('-3 day'))?>','<?php echo date('Y-m-d')?>')" style="border:0;" /></span>
								<span class="btn small"><input type="button" value="일주일" onclick="set_date('<?php echo date('Y-m-d',strtotime('-7 day'))?>','<?php echo date('Y-m-d')?>')" style="border:0;" /></span>
								<span class="btn small"><input type="button" value="1개월" onclick="set_date('<?php echo date('Y-m-d',strtotime('-1 month'))?>','<?php echo date('Y-m-d')?>')" style="border:0;" /></span>
								<span class="btn small"><input type="button" value="3개월" onclick="set_date('<?php echo date('Y-m-d',strtotime('-3 month'))?>','<?php echo date('Y-m-d')?>')" style="border:0;" /></span>
								<span class="btn small"><input type="button" value="전체" onclick="set_date('','')" style="border:0;"/></span>
							</td>
							<td rowspan="2">
								<div class="selectbox_multi">
									<div class="cont">
										<h2>
											<label><input type="checkbox" class="allSelectDrop" name="allshipmethod" <?php if(count($_GET['shipping_method'])== 6){?>checked<?php }?> default_none> <span class="allshipmethod fx12">배송방법 전체</span></label>
										</h2>
										<div class="list" style="height:46px;">
											<ul>
<?php if($TPL_ship_set_code_1){foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){?>
												<li><label><input type="checkbox" name="shipmethod[]" value="<?php echo $TPL_K1?>" title="<?php echo $TPL_V1?>" <?php if($_GET['shipping_method'][$TPL_K1]==$TPL_K1){?>checked<?php }?> default_none> <?php echo $TPL_V1?></label></li>
<?php }}?>
											</ul>
										</div>
									</div>
<?php if($TPL_VAR["npay_use"]){?>
									<div class="cont" style="vertical-align:middle;">
										<div style="margin-top:3px">
											<label><input type="checkbox" name="search_npay_order" value='y' <?php if($_GET["search_npay_order"]=='y'){?>checked<?php }?>> 네이버페이 주문</label>
										</div>
									</div>
<?php }?>
								</div>
							</td>
						</tr>
						<tr>
							<th>주문상태</th>
							<td>
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if(($TPL_K1>= 40&&$TPL_K1<= 75&&substr($TPL_K1, 1, 1)== 0)||($TPL_K1>= 25&&$TPL_K1<= 35)){?>
								<label class="search_label" style="display:inline-block;padding:3px 3px 3px 0px;width:90px;"><input class="step" type="checkbox" name="step[<?php echo $TPL_K1?>]" value="<?php echo $TPL_K1?>" <?php if($_GET['step'][$TPL_K1]==$TPL_K1){?>checked<?php }?> /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }?>
<?php }}?>
								<span class="icon-check hand all-check"><b>전체</b></span>
								<input type="hidden" name="seq" value="<?php echo $_GET['seq']?>" />
							</td>
						</tr>
					</table>
				</td>
			<tr>
		</table>
	</div>
	<div align="center">
		<div style="position: relative;width:100px;height:5px;">
			<div style="position: absolute;z-index:2;top:-5px;" id="btn-close-search"><a href="javascript:close_search_form();"><img src="/admin/skin/default/images/common/search_close.gif" /></a></div>
			<div style="position: absolute;z-index:2;top:-5px;" id="btn-open-search"><a href="javascript:open_search_form();"><img src="/admin/skin/default/images/common/search_open.gif" /></a></div>
		</div>
	</div>
	<div id="export-bar-area">
		<div id="export-bar">
			<div class="export-bar-inner pdl10 pdr10">
				<table width="100%" border='0'>
					<tr>
						<td width="34%">
							<div class="desc">
								<a href="#" onclick="set_default_stock_check();">
									<span style="font-weight:normal;color:#0082ec;">재고에 따른 '출고완료'처리 설정 ></span>
								</a>
								&nbsp;
								<span>
								[현재설정]
<?php if($TPL_VAR["data_present_provider"]["default_export_stock_check"]=='limit'){?>
								실물: 재고있을때 가능,
<?php }elseif($TPL_VAR["data_present_provider"]["default_export_stock_check"]=='unlimit'){?>
								실물: 재고없어도 가능,
<?php }?>
								&nbsp;
<?php if($TPL_VAR["data_present_provider"]["default_export_ticket_stock_check"]=='limit'){?>
								티켓: 재고와 티켓번호있으면 가능
<?php }elseif($TPL_VAR["data_present_provider"]["default_export_ticket_stock_check"]=='limit_ticket'){?>
								티켓: 재고없어도 티켓번호있으면 가능
<?php }?>
							</span>
							</div>
							<div class="pdt5 desc">
								<label><input type="checkbox" name="allcheck" value="1" onclick="check_all(this);check_bg();" checked="checked" /> 전체</label>
								&nbsp;<img src="/admin/skin/default/images/common/btn_print_m_odr.gif"  onclick="order_print();" class="hand" align="absmiddle" />
								&nbsp;<img src="/admin/skin/default/images/common/btn_print_m_rls.gif"  onclick="export_print();" class="hand" align="absmiddle" />
								<span class="btn small orange valign-middle"><input type="button" id="btn_no_matching_info" value="주의) 미매칭 상품의 출고" /></span>
								<span class="btn small orange valign-middle"><input type="button" id="btn_bundle_info" value="안내) 합포장(묶음배송)" /></span>
							</div>
						</td>
						<td align="center" width="32%">
							<span class="btn large cyanblue" ><button type="button" id="goods_export" style="width:150px;" onclick="export_popup();">출고처리></button></span>
							<span class="btn large cyanblue" ><button type="button" id="goods_export" style="width:160px;" onclick="export_bundle_delivery();">합포장 출고처리></button></span>
						</td>
						<td width="34%">
						</td>
					</tr>
				</table>

				<div class="pd5"></div>
				<div style="height:1px;border-top:1px solid #e1e1e1;"></div>
			</div>
		</div>
	</div>

	<div tabindex="-1" id="export_layer" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable" style="outline: 0px; left: 13%;width: 930px; height: auto; display: block; position: absolute; z-index: 10002;">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
			<span class="ui-dialog-title" id="ui-dialog-title-export_layer">출고처리</span>
			<a class="ui-dialog-titlebar-close ui-corner-all" href="#" onclick="close_export_popup();"><span class="ui-icon ui-icon-closethick">close</span></a>
		</div>
		<div class="hide absolute ui-dialog-content ui-widget-content" style="width: auto; height: 157px; display: block; min-height: 0px;" scrolltop="0" scrollleft="0">
			<table class="export_table" style="border-collapse:collapse" border='1'>
				<col width="120" />
				<col  />
				<tr>
					<th>출고일자</th>
					<td>
						<input type="text" name="export_date" class="datepicker line"  maxlength="10" size="10" readonly value="<?php echo date('Y-m-d')?>">
					</td>
				</tr>
				<tr>
					<th>출고처리</th>
					<td>
						<div class="pdb5<?php if(!$TPL_VAR["exist_goods"]){?> hide<?php }?>">
							실물 :
							<input type="hidden" name="stockable" id="export_stockable" value="<?php echo $TPL_VAR["data_present_provider"]["default_export_stock_check"]?>">
							<span class="hide">
<?php if($TPL_VAR["data_present_provider"]["default_export_stock_check"]=='limit'){?>
					출고되는 모든 실물의 재고가 있으면
<?php }elseif($TPL_VAR["data_present_provider"]["default_export_stock_check"]=='unlimit'){?>
					출고되는 모든 실물의 재고가 부족해도
<?php }?>
					→ 재고 차감 → (설정 시) SMS/EMAIL 발송 →
					</span>
							<select name="export_step" id="export_step" onchange="check_stock_policy_step()">
								<option value="55" <?php if($TPL_VAR["data_present_provider"]["default_export_stock_step"]=='55'){?>selected<?php }?>>출고완료</option>
								<option value="45" <?php if($TPL_VAR["data_present_provider"]["default_export_stock_step"]=='45'){?>selected<?php }?>>출고준비</option>
							</select>로 상태 처리
						</div>
						<div class="pdb5<?php if(!$TPL_VAR["exist_ticket"]){?> hide<?php }?>">
							티켓 :
							<input type="hidden" name="ticket_stockable" value="<?php echo $TPL_VAR["data_present_provider"]["default_export_ticket_stock_check"]?>">
							<span>
<?php if($TPL_VAR["data_present_provider"]["default_export_ticket_stock_check"]=='limit'){?>
					출고되는 모든 티켓의 재고가 있고 티켓번호가 있으면
<?php }elseif($TPL_VAR["data_present_provider"]["default_export_ticket_stock_check"]=='limit_ticket'){?>
					출고되는 모든 티켓의 재고가 부족해도 티켓번호가 있으면
<?php }?>
					→ 재고 차감 → (설정 시) SMS/EMAIL 발송 →
					</span>
							<select name="ticket_step" style="background-color:#efefef;">
								<option value="55" <?php if($TPL_VAR["data_present_provider"]["default_export_ticket_stock_step"]=='55'){?>selected<?php }?>>출고완료</option>
							</select>로 상태 처리
						</div>
					</td>
				</tr>
			</table>
<?php if($TPL_VAR["exist_provider"]){?>
			<div class="center red pdb5 fx11">
				통신판매중계자가 입점사 판매상품을 출고처리 시 그에 따른 책임을 통신판매중계자에게 있습니다.
			</div>
<?php }?>
<?php if($TPL_VAR["gf_config"]["goodsflow_step"]=='1'){?>
			<div id="goodsflow_desc" class="center pdb5 fx11">
				* <span class="blue">굿스플로</span> 서비스를 이용하여 출고처리 시 <span class="blue">출고준비</span> 상태로 먼저 변경하고,
				송장 자동발급 서비스를 사용하셔야 구매자에게 <span class="blue">운송장번호가 발송</span>됩니다.
			</div>
<?php }?>
			<table  width="100%">
				<tr>
					<td>
						<span class="btn large gray" ><button type="button" id="goods_export" style="width:100px;" onclick="export_check();">예상결과 보기</button></span>
					</td>
					<td>
						<span class="btn large cyanblue" ><button type="button" id="goods_export" style="width:100px;" onclick="export_submit();">처 리</button></span>
					</td>
				</tr>
			</table>

		</div>
	</div>
	<script>
		$("#export_layer").hide();
	</script>

<?php if($TPL_VAR["data_page"]["totalpage"]>= 1){?>
	<div class="paging_navigation" style="margin:auto;">
		<?php echo $TPL_VAR["data_page"]["html"]?>

	</div>
<?php }?>

	<!-- 출고 리스트 :: START -->
	<div class="pdl10 pdr10">
		<div class="pd5"></div>
<?php if($TPL_ordershipping_1){$TPL_I1=-1;foreach($TPL_VAR["ordershipping"] as $TPL_V1){$TPL_I1++;?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
		<input type="hidden" name="order_seq[<?php echo $TPL_V2["shipping_seq"]?>]" value="<?php echo $TPL_V2["order_seq"]?>" />
		<div>
			<table width="100%" border="0" style="table-layout: fixed">
				<tr>
					<td width="20%">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td rowspan="2" width="35">
<?php if($TPL_V2["request_exist"]){?>
									<input type="checkbox" name="check_shipping_seq[<?php echo $TPL_V2["shipping_seq"]?>]" class="check_shipping_group_seq" order_seq="<?php echo $TPL_V2["order_seq"]?>" value="<?php echo $TPL_V2["shipping_seq"]?>"  linkage_id="<?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["linkage_id"]?>" checked="checked" onclick="check_bg();" />
<?php }else{?>
									<input type="checkbox" name="disable_check" class="check_shipping_group_seq" value="<?php echo $TPL_V2["shipping_seq"]?>" disabled="disabled" />
<?php }?>
									<?php echo $TPL_V2["num"]?>.
								</td>
								<td>
									<a href="../order/view?no=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><span class="blue"><?php echo $TPL_V2["order_seq"]?></span></a>
									<a href="javascript:printOrderView('<?php echo $TPL_V2["order_seq"]?>')"><span class="icon-print-order"></span></a>
<?php if($TPL_V2["export_exist"]){?>
									<a href="javascript:printExportView('<?php echo $TPL_V2["order_seq"]?>')"><span class="icon-print-export"></span></a>
<?php }?>
<?php if($TPL_V2["npay_order_id"]){?><div class="ngreen bold"><?php echo $TPL_V2["npay_order_id"]?><span style="font-size:11px;font-weight:normal"> (Npay주문번호)</span></div><?php }?>
<?php if($TPL_VAR["order"][$TPL_V2["order_seq"]]["linkage_id"]=='connector'){?><div class="ngreen bold"><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["linkage_mall_order_id"]?> <span style="font-size:11px;font-weight:normal">(<?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["linkage_mallname_text"]?>)</span></div><?php }?>
								</td>
							</tr>
							<tr>
								<td>
						<span class="bold">
<?php if($TPL_V2["mall_name"]){?>
							<?php echo $TPL_V2["mall_name"]?>

							→
<?php }?>
							<?php echo $TPL_V2["provider_name"]?>

						</span>
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">

						<table class="rec-info">
							<tr>
								<td rowspan="2" align="right">
<?php if($TPL_VAR["order"][$TPL_V2["order_seq"]]["member_seq"]){?>
									<a href="../member/detail?member_seq=<?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["member_seq"]?>" target="_blank"><span class="member"><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["order_user_name"]?></span></a>
<?php }else{?>
									<span class="nomember"><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["order_user_name"]?></span>
<?php }?>
<?php if($TPL_VAR["order"][$TPL_V2["order_seq"]]["order_user_name"]!=$TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_user_name"]){?>
									<img src="/admin/skin/default/images/common/order_arrow.png" / >
									<span class="nomember"><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_user_name"]?></span>
<?php }?>
								</td>
								<td width="25"></td>
								<td>
<?php if(!preg_match('/coupon/',$TPL_V2["shipping_method"])){?>
									<span class="addr">
								(<?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_zipcode"]?>)
<?php if($TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_address_type"]=="street"){?>
								<?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_address_street"]?>

<?php }else{?>
								<?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_address"]?>

<?php }?>
								<?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_address_detail"]?>

							</span>
<?php }else{?>
									<span class="tel"><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_email"]?>&nbsp;|&nbsp;</span>
									<span class="tel"><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_cellphone"]?></span>
									<span class="memo"><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["memo"]?></span>
<?php }?>
								</td>
							</tr>

<?php if(!preg_match('/coupon/',$TPL_V2["shipping_method"])){?>
							<tr>
								<td></td>
								<td>
									<span class="tel" style="font-size:11px;"><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_phone"]?></span>
<?php if($TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_phone"]&&$TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_cellphone"]){?>
									<span class="separator">|</span>
<?php }?>
									<span class="tel"><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_cellphone"]?></span>
<?php if($TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_cellphone"]&&$TPL_VAR["order"][$TPL_V2["order_seq"]]["memo"]){?>
									<span class="separator">|</span>
<?php }?>
									<span class="memo"><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["memo"]?></span>
								</td>
							</tr>
<?php }?>
						</table>


					</td>
					<td width="30">
						<span class="btn-direct-open <?php if($TPL_VAR["data_search_default"]["order_detail_view"]!='close'){?>opened<?php }?>" onclick="btn_export_toggle(this);"><span class="hide">열기</span></span>
					</td>
					<td width="26%" class="left">
<?php if($TPL_V2["shipping_method"]!='coupon'&&$TPL_V2["request_exist"]){?>
						<input type="text" name="barcode[<?php echo $TPL_V2["shipping_seq"]?>]" style="width:100%;" value="" title="피킹(picking)한 상품의 바코드(상품코드)를 스캔→검수" onkeydown="check_barcode(this)" class="barcode" tabindex="<?php echo $TPL_V2["num"]?>" <?php if($TPL_VAR["data_search_default"]["order_detail_view"]=='close'){?>disabled="disabled"<?php }?> />
<?php }?>
					</td>
					<td width="7%" align="right">
<?php if($TPL_V2["request_exist"]){?>
						<span class="btn small cyanblue" ><button type="button" id="goods_export" onclick="export_each_popup('<?php echo $TPL_V2["shipping_seq"]?>','<?php echo current(array_keys($TPL_V2["options"]))?>','<?php echo $TPL_V2["shipping_method"]?>');">출고처리></button></span>
<?php }else{?>
						<span class="btn small gray" disabled="disabled"><button type="button">출고처리></button></span>
<?php }?>
					</td>
				</tr>
			</table>
		</div>

		<table class="simplelist-table-style table-export-info shipping_group_<?php echo $TPL_V2["shipping_seq"]?>" width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout: fixed">
			<colgroup>
				<col /><!-- 주문상품 -->
				<col width="5%"/><!-- 재고/가용 -->
				<col width="5%"/><!-- 주문 -->
				<col width="5%"/><!-- 취소 -->
				<col width="5%"/><!-- 보낸수량 -->
				<col width="5%"/><!-- 남은수량 -->
				<col width="5%"/><!-- 공백 -->
				<col width="5%"/><!-- 보낼수량 -->
				<col width="5%"/><!-- 보낼수량 -->
				<col width="23%"/><!-- 받는방법 -->
			</colgroup>
			<thead>
<?php if($TPL_I1== 0&&$TPL_I2== 0){?>
			<tr>
				<th>주문상품</th>
				<th>재고</th>
				<th>주문</th>
				<th>취소</th>
				<th>보낸수량</th>
				<th>남은수량 </th>
				<th class="null"></th>
				<th>보낼수량</th>
				<th>검수</th>
				<th>받는방법</th>
			</tr>
<?php }?>
			</thead>
			<tbody>
<?php if(is_array($TPL_R3=$TPL_V2["options"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
<?php if($TPL_I2== 0&&$TPL_I3== 0){?>
			<!--닫힘상태의 상품정보 시작-->
			<tr class="close-tr">
				<td class="info option">
					<table class="list-goods-info">
						<tr>
							<td width="50" style="border:0px;">
								<span class="order-item-image"><img src="<?php echo viewImg($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_seq"],'thumbCart')?>" width="30"></span>
							</td>
							<td style="border:0px;">
								<div class="goods_name">
<?php if($TPL_V3["npay_product_order_id"]){?><div class="ngray bold"><?php echo $TPL_V3["npay_product_order_id"]?><span style="font-size:11px;font-weight:normal"> (Npay상품주문번호)</span></div><?php }?>
									<span class="goods_name1" style="width:100%;color:#000000;">
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_type"]=='gift'){?>
								<img src="/admin/skin/default/images/common/icon_gift.gif" />
<?php }?>
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_data"]["cancel_type"]=='1'){?>
								<span class="order-item-cancel-type " >[청약철회불가]</span><br/>
<?php }?>
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["provider_seq"]!=$TPL_V2["provider_seq"]){?>
								<span style="color:#ff0000;font-size:11px;">위탁배송:<?php echo $TPL_V2["items"][$TPL_V3["item_seq"]]["provider_name"]?></span>
<?php }?>
								<?php echo $TPL_V2["items"][$TPL_V3["item_seq"]]["goods_data"]["goods_name"]?>

<?php if($TPL_V2["rowspan"]> 1){?>
									<cite class="red">외 <?php echo ($TPL_V2["rowspan"]- 1)?>건<cite>
<?php }?>
							</span>
								</div>
<?php if($TPL_V3["option1"]!=null){?>
								<div class="goods_option">
									<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php if($TPL_V3["title1"]){?><?php echo $TPL_V3["title1"]?>:<?php }?><?php echo $TPL_V3["option1"]?>

<?php if($TPL_V3["option2"]!=null){?><?php if($TPL_V3["title2"]){?><?php echo $TPL_V3["title2"]?>:<?php }?><?php echo $TPL_V3["option2"]?><?php }?>
<?php if($TPL_V3["option3"]!=null){?><?php if($TPL_V3["title3"]){?><?php echo $TPL_V3["title3"]?>:<?php }?><?php echo $TPL_V3["option3"]?><?php }?>
<?php if($TPL_V3["option4"]!=null){?><?php if($TPL_V3["title4"]){?><?php echo $TPL_V3["title4"]?>:<?php }?><?php echo $TPL_V3["option4"]?><?php }?>
<?php if($TPL_V3["option5"]!=null){?><?php if($TPL_V3["title5"]){?><?php echo $TPL_V3["title5"]?>:<?php }?><?php echo $TPL_V3["option5"]?><?php }?>

								</div>
<?php }?>
<?php if(is_array($TPL_R4=$TPL_V3["subinputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V4["title"]){?>
									<?php echo $TPL_V4["title"]?> :
<?php }?>
<?php if($TPL_V4["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V4["value"]?>" target="actionFrame"><?php echo $TPL_V4["value"]?></a>
<?php }else{?>
									<?php echo $TPL_V4["value"]?>

<?php }?>
								</div>
<?php }}?>
							</td>
						</tr>
					</table>
				</td>
				<td class="info option" align="center"><?php echo number_format($TPL_V2["tot_stock"])?></td>
				<td class="info option" align="center"><?php echo number_format($TPL_V2["tot_ea"])?></td>
				<td class="info option" align="center"><?php echo number_format($TPL_V2["tot_step85"])?></td>
				<td class="info option" align="center"><?php echo number_format($TPL_V2["tot_export_ea"])?></td>
				<td class="info option" align="center"><?php echo number_format($TPL_V2["tot_request_ea"])?></td>
				<td class="null" align="center">→</td>
				<td class="info option" align="center"><?php echo number_format($TPL_V2["tot_request_ea"])?></td>
				<td class="info option" align="center">-</td>

				<td class="info option delivery-info" align="center">
<?php if($TPL_VAR["data_search_default"]["order_detail_view"]=='close'){?>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="inner-table shipping_info_<?php echo $TPL_V2["shipping_seq"]?>">
						<tr>
<?php if(preg_match('/coupon/',$TPL_V2["shipping_method"])){?>
							<td class="info pdl5" valign="top">
								<div><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_email"]?></div>
								<div><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_cellphone"]?></div>
							</td>
<?php }else{?>
							<td class="info pdl5 left" valign="top">
								<!-- 배송 정보 :: START -->
								<input type="hidden" name="export_shipping_group[<?php echo $TPL_V2["shipping_seq"]?>]" class="export_shipping_group" value="<?php echo $TPL_V2["shipping_group"]?>" />
								<input type="hidden" id="export_shipping_method_<?php echo $TPL_V2["shipping_seq"]?>" name="export_shipping_method[<?php echo $TPL_V2["shipping_seq"]?>]" class="export_shipping_method" value="<?php echo $TPL_V2["shipping_method"]?>" />
								<input type="hidden" name="export_shipping_set_name[<?php echo $TPL_V2["shipping_seq"]?>]" class="export_shipping_set_name" value="<?php echo $TPL_V2["shipping_set_name"]?>" />
								<div><?php echo $TPL_V2["provider_name"]?></div>
								<div class="blue">
									<span class="hand shipping_set_name_<?php echo $TPL_V2["shipping_seq"]?>" onclick="ship_chg_popup('<?php echo $TPL_V2["shipping_seq"]?>','order','after');"><?php echo $TPL_V2["shipping_set_name"]?></span>
								</div>

<?php if($TPL_VAR["npay_use"]&&$TPL_V3["npay_product_order_id"]&&$TPL_V3["top_item_option_seq"]&&$TPL_V2["npay_flag_msg"]){?>
								<label>
									<input type="checkbox" name="npay_flag_release[<?php echo $TPL_V2["shipping_seq"]?>]" value='<?php echo $TPL_V3["exchange_return_code"]?>'>
									<span class='desc'><span class="red">보류해제(사유:<?php echo $TPL_V3["npay_flag_msg"]?>)</span></span>
								</label>
<?php }?>

								<!-- 택배사선택 :: START -->
								<div class="delivery_lay <?php if($TPL_V2["shipping_method"]!='delivery'){?>hide<?php }?>">
									<select name="delivery_company[<?php echo $TPL_V2["shipping_seq"]?>]" id="delivery_company_<?php echo $TPL_V2["shipping_seq"]?>" class="deliveryCompany" onchange="check_deliveryCompany(<?php echo $TPL_V2["shipping_seq"]?>)" style="width:85px;">
<?php if(is_array($TPL_R4=$TPL_V2["couriers"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?>
<?php if(substr($TPL_K4, 0, 5)=='auto_'){?>
										<option value="<?php echo $TPL_K4?>" style="background:yellow"><?php echo $TPL_V4["company"]?></option>
<?php }else{?>
										<option value="<?php echo $TPL_K4?>" style="background:#ffffff"><?php echo $TPL_V4["company"]?></option>
<?php }?>
<?php }}?>
									</select>
									<input type="text" size="25" name="delivery_number[<?php echo $TPL_V2["shipping_seq"]?>]" class="line delivery_number" />
								</div>
								<!-- 택배사선택 :: END -->
								<!-- 매장선택 :: START -->
								<div class="store_lay <?php if($TPL_V2["shipping_method"]!='direct_store'){?>hide<?php }?>">
									<input type="hidden" class="store_scm_type_<?php echo $TPL_V2["shipping_seq"]?>" name="export_store_scm_type[<?php echo $TPL_V2["shipping_seq"]?>]" value="<?php echo $TPL_V2["store_scm_type"]?>" />
									<select name="export_address_seq[<?php echo $TPL_V2["shipping_seq"]?>]" onchange="store_set(this, '<?php echo $TPL_V2["shipping_seq"]?>');">
<?php if(is_array($TPL_R4=$TPL_V2["shipping_store_info"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
										<option value="<?php echo $TPL_V4["shipping_address_seq"]?>" scm_type="<?php echo $TPL_V4["store_scm_type"]?>" <?php if($TPL_V4["shipping_address_seq"]==$TPL_V2["shipping_address_seq"]){?>selected<?php }?>><?php echo $TPL_V4["shipping_store_name"]?></option>
<?php }}?>
									</select>
								</div>
								<!-- 매장선택 :: END -->
								<!-- 출고지 정보 :: START -->
								<div class="address_lay <?php if($TPL_V2["shipping_method"]=='direct_store'){?>hide<?php }?>">
									<span class="hand" onclick="address_pop('<?php echo $TPL_V2["sending_address"]['address_category']?>','<?php echo $TPL_V2["sending_address"]['address_name']?>','<?php echo $TPL_V2["sending_address"]['view_address']?>','<?php echo $TPL_V2["sending_address"]['shipping_phone']?>');"><?php echo $TPL_V2["sending_address"]['address_name']?></span>
								</div>
								<!-- 출고지 정보 :: END -->
								<script>check_deliveryCompany(<?php echo $TPL_V2["shipping_seq"]?>);</script>
								<!-- 배송 정보 :: END -->
							</td>
<?php }?>
						</tr>
					</table>
<?php }?>
				</td>
			</tr>
			<!--닫힘상태의 상품정보 끝-->
<?php }?>
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_type"]=='gift'){?>
			<tr bgcolor="#f6f6f6" class="opttr-<?php echo $TPL_V3["item_option_seq"]?> open-tr">
<?php }else{?>
			<tr class="opttr-<?php echo $TPL_V2["item_option_seq"]?> open-tr">
<?php }?>
				<td class="info option">
					<input type="hidden" name="chk_individual_export[<?php echo $TPL_V3["item_seq"]?>]" value="<?php echo $TPL_V2["items"][$TPL_V3["item_seq"]]["individual_export"]?>" />
					<table class="list-goods-info" width="100%">
						<tr>
							<td width="50">
								<span class="order-item-image"><img src="<?php echo viewImg($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_seq"],'thumbCart')?>" width="30"></span>
							</td>
							<td>
								<div class="goods_name">
<?php if($TPL_V3["npay_product_order_id"]){?><div class="ngray bold"><?php echo $TPL_V3["npay_product_order_id"]?><span style="font-size:11px;font-weight:normal"> (Npay상품주문번호)</span></div><?php }?>
									<span class="goods_name1" style="width:100%;color:#000000;">
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_type"]=='gift'){?>
								<img src="/admin/skin/default/images/common/icon_gift.gif" />
<?php }?>
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_data"]["cancel_type"]=='1'){?>
								<span class="order-item-cancel-type " >[청약철회불가]</span><br/>
<?php }?>
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["provider_seq"]!=$TPL_V2["provider_seq"]){?>
								<span style="color:#ff0000;font-size:11px;">위탁배송:<?php echo $TPL_V2["items"][$TPL_V3["item_seq"]]["provider_name"]?></span>
<?php }?>
								<?php echo $TPL_V2["items"][$TPL_V3["item_seq"]]["goods_data"]["goods_name"]?>

							</span>
								</div>
<?php if($TPL_V3["option1"]!=null){?>
								<div class="goods_option">
									<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php if($TPL_V3["title1"]){?><?php echo $TPL_V3["title1"]?>:<?php }?><?php echo $TPL_V3["option1"]?>

<?php if($TPL_V3["option2"]!=null){?><?php if($TPL_V3["title2"]){?><?php echo $TPL_V3["title2"]?>:<?php }?><?php echo $TPL_V3["option2"]?><?php }?>
<?php if($TPL_V3["option3"]!=null){?><?php if($TPL_V3["title3"]){?><?php echo $TPL_V3["title3"]?>:<?php }?><?php echo $TPL_V3["option3"]?><?php }?>
<?php if($TPL_V3["option4"]!=null){?><?php if($TPL_V3["title4"]){?><?php echo $TPL_V3["title4"]?>:<?php }?><?php echo $TPL_V3["option4"]?><?php }?>
<?php if($TPL_V3["option5"]!=null){?><?php if($TPL_V3["title5"]){?><?php echo $TPL_V3["title5"]?>:<?php }?><?php echo $TPL_V3["option5"]?><?php }?>
								</div>
<?php }?>
<?php if(is_array($TPL_R4=$TPL_V3["subinputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V4["title"]){?>
									<?php echo $TPL_V4["title"]?> :
<?php }?>
<?php if($TPL_V4["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V4["value"]?>" target="actionFrame"><?php echo $TPL_V4["value"]?></a>
<?php }else{?>
									<?php echo $TPL_V4["value"]?>

<?php }?>
								</div>
<?php }}?>

<?php if((!$TPL_V2["items"][$TPL_V3["item_seq"]]["goods_seq"]||$TPL_V3["nomatch"]> 0)&&$TPL_V3["step"]< 40&&$TPL_V2["items"][$TPL_V3["item_seq"]]["goods_type"]!='gift'){?>
								<div>
									<span class="btn small cyanblue" onclick="set_goods_list('<?php echo $TPL_VAR["orders"]["member_seq"]?>','<?php echo $TPL_V2["order_seq"]?>','<?php echo $TPL_V3["item_seq"]?>','<?php echo $TPL_V3["item_option_seq"]?>','rematch')"><button type="button">매칭</button></span>
								</div>
<?php }?>

<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]['goods_type']=="gift"){?>
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]['gift_title']){?>
								<div>
									<span class="fx11"><?php echo $TPL_V2["items"][$TPL_V3["item_seq"]]['gift_title']?></span>
									<span class="btn small gray">
							<button type="button" class="gift_log" order_seq="<?php echo $TPL_V2["order_seq"]?>" item_seq="<?php echo $TPL_V3["item_seq"]?>">자세히</button>
						</span>
								</div>
<?php }?>
<?php }?>

<?php if($TPL_V3["package_yn"]!='y'){?>
								<div class="warehouse-info-lay">
									<ul>
										<li class="wh_info"></li>
										<li>상품코드 : <?php echo $TPL_V3["goods_code"]?></li>
									</ul>
								</div>
<?php }?>

<?php if($TPL_V3["npay_pay_delivery"]=='y'){?>
								<div class='red'>! 네이버 페이 판매자센터에서 출고진행중인 주문입니다.</div>
<?php }?>

							</td>
						</tr>
					</table>
				</td>
				<td class="info option" align="center">
<?php if($TPL_V3["package_yn"]!='y'){?>
<?php if($TPL_V3["stock"]==='미매칭'){?>
					미매칭
<?php }else{?>
					<span class="stock"><?php echo number_format($TPL_V3["stock"])?></span>
<?php }?>
					<input type="hidden" name="stock[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]" class="whstock" value="<?php echo $TPL_V3["stock"]?>" />
<?php }else{?>
					<span class="fx11 dotum">실제상품▼</span>
<?php }?>
				</td>
				<td class="info option" align="center">
<?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><span class="ea"><?php echo number_format($TPL_V3["ea"])?></span><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?>
				</td>
				<td class="info option" align="center"><?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V3["step85"])?><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info option" align="center"><?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V3["export_ea"])?><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info option" align="center">
<?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V3["request_ea"])?><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?>
					<input type="hidden" class="orderEA" value="<?php echo $TPL_V3["request_ea"]?>" />
				</td>

				<td class="null" align="center">→</td>

<?php if($_GET["mode"]=='order'){?>

				<td class="info option" align="center">
<?php if($TPL_V3["request_ea"]== 0){?>
					0
<?php }else{?>
					<?php echo number_format($TPL_V3["request_ea"])?>

<?php }?>

<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_data"]["goods_kind"]=='coupon'){?>
					<input type="hidden" name="request_ea[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]" class="line export_ea"  style="text-align:right;background-color:#efefef;" size="2" value="<?php echo $TPL_V3["request_ea"]?>" readonly>
					<input type="hidden" name="shipping_goods_kind[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]"  value="COU" />
<?php }else{?>
					<input type="hidden" name="request_ea[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]" class="line export_ea"  style="text-align:right" size="2" value="<?php echo $TPL_V3["request_ea"]?>">
					<input type="hidden" name="shipping_goods_kind[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]"  value="OPT" />
<?php }?>
				</td>

<?php }else{?>
				<td class="info option" align="center">
<?php if($TPL_V3["request_ea"]== 0){?>
					0
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_data"]["goods_kind"]=='coupon'){?>
					<input type="hidden" name="request_ea[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]" class="line export_ea"  style="text-align:right;background-color:#efefef;" size="2" value="<?php echo $TPL_V3["request_ea"]?>" org="<?php echo $TPL_V3["request_ea"]?>" opt_type="opt" item_seq="<?php echo $TPL_V3["item_seq"]?>" readonly>
					<input type="hidden" name="shipping_goods_kind[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]"  value="COU" />
<?php }else{?>
					<input type="hidden" name="request_ea[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]" class="line export_ea"  style="text-align:right" size="2" value="<?php echo $TPL_V3["request_ea"]?>" onkeydown="reset_barcode_ea(this);" org="<?php echo $TPL_V3["request_ea"]?>" opt_type="opt" item_seq="<?php echo $TPL_V3["item_seq"]?>" >
					<input type="hidden" name="shipping_goods_kind[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]"  value="OPT" />
<?php }?>
<?php }else{?>
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_data"]["goods_kind"]=='coupon'){?>
					<input type="text" name="request_ea[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]" class="line export_ea export_ea_opt"  style="text-align:right;background-color:#efefef;" size="2" value="<?php echo $TPL_V3["request_ea"]?>" onblur="check_request_ea(this,<?php echo $TPL_V3["request_ea"]?>)" org="<?php echo $TPL_V3["request_ea"]?>" opt_type="opt" item_seq="<?php echo $TPL_V3["item_seq"]?>" readonly>
					<input type="hidden" name="shipping_goods_kind[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]"  value="COU" />
<?php }else{?>
<?php if(($TPL_VAR["npay_use"]&&$TPL_V3["npay_product_order_id"])||$TPL_VAR["order"][$TPL_V2["order_seq"]]["linkage_id"]=='connector'){?>
					<input type="hidden" name="request_ea[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]" value="<?php echo $TPL_V3["request_ea"]?>"  org="<?php echo $TPL_V3["request_ea"]?>" opt_type="opt" item_seq="<?php echo $TPL_V3["item_seq"]?>">
					<input type="text" name="request_ea_tmp[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]" class="line export_ea"  style="text-align:right" size="2" value="<?php echo $TPL_V3["request_ea"]?>" disabled style="background-color:#eee;">
<?php }else{?>
					<input type="text" name="request_ea[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]" class="line export_ea"  style="text-align:right" size="2" value="<?php echo $TPL_V3["request_ea"]?>" org="<?php echo $TPL_V3["request_ea"]?>" onkeyup="reset_barcode_ea(this);check_request_ea(this,<?php echo $TPL_V3["request_ea"]?>);">
<?php }?>
					<input type="hidden" name="shipping_goods_kind[<?php echo $TPL_V2["shipping_seq"]?>][option][<?php echo $TPL_V3["item_option_seq"]?>]"  value="OPT" />
<?php }?>
<?php }?>
				</td>
<?php }?>
				<td class="info option" align="center">
					<span><?php if($TPL_V3["request_ea"]== 0){?>-<?php }else{?>대기<?php }?></span>
<?php if($TPL_V3["request_ea"]> 0){?>
					<input type="text" name="barcode_ea[<?php echo $TPL_V2["shipping_seq"]?>][<?php echo strtoupper($TPL_V3["bar_goods_code"])?>]" class="barcode_ea_<?php echo $TPL_V2["shipping_seq"]?> barcode_ready" value="0" size="2" onblur="check_barcode_ea(this);" />
<?php }?>
				</td>
<?php if($TPL_I3== 0){?>
				<td class="info option delivery-info" align="center" rowspan="<?php echo $TPL_V2["rowspan"]?>">
<?php if($TPL_VAR["data_search_default"]["order_detail_view"]!='close'){?>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="inner-table shipping_info_<?php echo $TPL_V2["shipping_seq"]?>">
						<tr>
<?php if(preg_match('/coupon/',$TPL_V2["shipping_method"])){?>
							<td class="info pdl5" valign="top">
								<div><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_email"]?></div>
								<div><?php echo $TPL_VAR["order"][$TPL_V2["order_seq"]]["recipient_cellphone"]?></div>
							</td>
<?php }else{?>
							<td class="info pdl5 left" valign="top">
								<!-- 배송 정보 :: START -->
								<input type="hidden" name="export_shipping_group[<?php echo $TPL_V2["shipping_seq"]?>]" class="export_shipping_group" value="<?php echo $TPL_V2["shipping_group"]?>" />
								<input type="hidden" id="export_shipping_method_<?php echo $TPL_V2["shipping_seq"]?>" name="export_shipping_method[<?php echo $TPL_V2["shipping_seq"]?>]" class="export_shipping_method" value="<?php echo $TPL_V2["shipping_method"]?>" />
								<input type="hidden" name="export_shipping_set_name[<?php echo $TPL_V2["shipping_seq"]?>]" class="export_shipping_set_name" value="<?php echo $TPL_V2["shipping_set_name"]?>" />
								<div><?php echo $TPL_V2["provider_name"]?></div>
								<div class="blue">
									<span class="hand shipping_set_name_<?php echo $TPL_V2["shipping_seq"]?>" onclick="ship_chg_popup('<?php echo $TPL_V2["shipping_seq"]?>','order','after');"><?php echo $TPL_V2["shipping_set_name"]?></span>
								</div>

<?php if($TPL_VAR["npay_use"]&&$TPL_V3["npay_product_order_id"]&&$TPL_V3["top_item_option_seq"]&&$TPL_V2["npay_flag_msg"]){?>
								<label>
									<input type="checkbox" name="npay_flag_release[<?php echo $TPL_V2["shipping_seq"]?>]" value='<?php echo $TPL_V3["exchange_return_code"]?>'>
									<span class='desc'><span class="red">보류해제(사유:<?php echo $TPL_V3["npay_flag_msg"]?>)</span></span>
								</label>
<?php }?>

								<!-- 택배사선택 :: START -->
								<div class="delivery_lay <?php if($TPL_V2["shipping_method"]!='delivery'){?>hide<?php }?>">
									<select name="delivery_company[<?php echo $TPL_V2["shipping_seq"]?>]" id="delivery_company_<?php echo $TPL_V2["shipping_seq"]?>" class="deliveryCompany" onchange="check_deliveryCompany(<?php echo $TPL_V2["shipping_seq"]?>)" style="width:85px;">
<?php if(is_array($TPL_R4=$TPL_V2["couriers"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?>
<?php if(substr($TPL_K4, 0, 5)=='auto_'){?>
										<option value="<?php echo $TPL_K4?>" style="background:yellow"><?php echo $TPL_V4["company"]?></option>
<?php }else{?>
										<option value="<?php echo $TPL_K4?>" style="background:#ffffff"><?php echo $TPL_V4["company"]?></option>
<?php }?>
<?php }}?>
									</select>
									<input type="text" size="25" name="delivery_number[<?php echo $TPL_V2["shipping_seq"]?>]" class="line delivery_number" />
								</div>
								<!-- 택배사선택 :: END -->
								<!-- 매장선택 :: START -->
								<div class="store_lay <?php if($TPL_V2["shipping_method"]!='direct_store'){?>hide<?php }?>">
									<input type="hidden" class="store_scm_type_<?php echo $TPL_V2["shipping_seq"]?>" name="export_store_scm_type[<?php echo $TPL_V2["shipping_seq"]?>]" value="<?php echo $TPL_V2["store_scm_type"]?>" />
									<select name="export_address_seq[<?php echo $TPL_V2["shipping_seq"]?>]" onchange="store_set(this, '<?php echo $TPL_V2["shipping_seq"]?>');">
<?php if(is_array($TPL_R4=$TPL_V2["shipping_store_info"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
										<option value="<?php echo $TPL_V4["shipping_address_seq"]?>" scm_type="<?php echo $TPL_V4["store_scm_type"]?>" <?php if($TPL_V4["shipping_address_seq"]==$TPL_V2["shipping_address_seq"]){?>selected<?php }?>><?php echo $TPL_V4["shipping_store_name"]?></option>
<?php }}?>
									</select>
								</div>
								<!-- 매장선택 :: END -->
								<!-- 출고지 정보 :: START -->
								<div class="address_lay <?php if($TPL_V2["shipping_method"]=='direct_store'){?>hide<?php }?>">
									<span class="hand" onclick="address_pop('<?php echo $TPL_V2["sending_address"]['address_category']?>','<?php echo $TPL_V2["sending_address"]['address_name']?>','<?php echo $TPL_V2["sending_address"]['view_address']?>','<?php echo $TPL_V2["sending_address"]['shipping_phone']?>');"><?php echo $TPL_V2["sending_address"]['address_name']?></span>
								</div>
								<!-- 출고지 정보 :: END -->
								<script>check_deliveryCompany(<?php echo $TPL_V2["shipping_seq"]?>);</script>
								<!-- 배송 정보 :: END -->
							</td>
<?php }?>
						</tr>
					</table>
<?php }?>
				</td>
<?php }?>
			</tr>

<?php if($TPL_V3["package_yn"]=='y'){?>
<?php if(is_array($TPL_R4=$TPL_V3["packages"])&&!empty($TPL_R4)){$TPL_I4=-1;foreach($TPL_R4 as $TPL_V4){$TPL_I4++;?>
			<tr class="open-tr">
				<td class="info option" style="padding-left:20px;">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_V2["items"][$TPL_V3["item_seq"]]["goods_data"]["provider_seq"]== 1){?>
					<input type="hidden" name="whcode" class="optioninfo" value="<?php echo $TPL_V4["goods_seq"]?>option<?php echo $TPL_V4["option_seq"]?>" />
					<input type="hidden" name="package_wh_info[option][<?php echo $TPL_V4["item_option_seq"]?>][<?php echo $TPL_V4["package_option_seq"]?>]" value="<?php echo $TPL_V4["goods_seq"]?>|<?php echo $TPL_V4["option_seq"]?>|<?php echo $TPL_V4["goods_code"]?>|<?php echo $TPL_V4["supply_price"]?>" />
<?php }?>
					<table class="list-goods-info" width="100%">
						<tr>
							<td valign="top" style="border:none;"><img src="/admin/skin/default/images/common/icon/ico_package.gif" border="0" /></td>
							<td width="50" style="border:0px" class="center">
								<span class="order-item-image"><img src="<?php echo $TPL_V4["image"]?>" class="small_goods_image" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif';" /></span>
							</td>
							<td style="border:0px;">
								<div class="goods_name">
									<span class="red">[실제상품<?php echo $TPL_I4+ 1?>] <?php echo $TPL_V4["goods_name"]?></span>
								</div>
								<div class="goods_option">
									<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php if($TPL_V4["title1"]){?>
									<?php echo $TPL_V4["title1"]?>:
<?php }?>
									<?php echo $TPL_V4["option1"]?>

<?php if($TPL_V4["title2"]){?>
									&nbsp;<?php echo $TPL_V4["title2"]?>:
<?php }?>
									<?php echo $TPL_V4["option2"]?>

<?php if($TPL_V4["title3"]){?>
									&nbsp;<?php echo $TPL_V4["title3"]?>:
<?php }?>
									<?php echo $TPL_V4["option3"]?>

<?php if($TPL_V4["title4"]){?>
									&nbsp;<?php echo $TPL_V4["title4"]?>:
<?php }?>
									<?php echo $TPL_V4["option4"]?>

<?php if($TPL_V4["title5"]){?>
									&nbsp;<?php echo $TPL_V4["title5"]?>:
<?php }?>
									<?php echo $TPL_V4["option5"]?>

								</div>
								<div class="goods_option fx11 goods_code_icon">
								</div>

								<div class="warehouse-info-lay">
									<ul>
										<li class="wh_info">창고를 선택해 주세요.</li>
<?php if($TPL_V4["goods_code"]){?>
										<li><?php echo $TPL_V4["goods_code"]?></li>
<?php }?>
									</ul>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<td class="info option center">
<?php if($TPL_V4["stock"]==='미매칭'){?>
					<div class="red">미매칭</span>
<?php }else{?>
						<span class="red"><?php echo number_format($TPL_V4["stock"])?></span>
<?php }?> </td>

				<td class="info option center">
				<span class="red fx11">
<?php if($TPL_V3["ea"]){?>
				[<?php echo number_format($TPL_V3["ea"])?>]x<?php echo number_format($TPL_V4["unit_ea"])?>=<?php echo number_format($TPL_V3["ea"]*$TPL_V4["unit_ea"])?>

<?php }else{?>
				0
<?php }?>
				</span>
				</td>
				<td class="info option center">
				<span class="red fx11">
<?php if($TPL_V3["step85"]){?>
				[<?php echo number_format($TPL_V3["step85"])?>]x<?php echo number_format($TPL_V4["unit_ea"])?>=<?php echo number_format($TPL_V3["step85"]*$TPL_V4["unit_ea"])?>

<?php }else{?>
				0
<?php }?>
				</span>
				</td>
				<td class="info option center">
				<span class="red fx11">
<?php if($TPL_V3["export_ea"]){?>
				[<?php echo number_format($TPL_V3["export_ea"])?>]x<?php echo number_format($TPL_V4["unit_ea"])?>=<?php echo number_format($TPL_V3["export_ea"]*$TPL_V4["unit_ea"])?>

<?php }else{?>
				0
<?php }?>
				</span>
				</td>
				<td class="info option center">
				<span class="red fx11">
<?php if($TPL_V3["request_ea"]){?>
				[<?php echo number_format($TPL_V3["request_ea"])?>]x<?php echo number_format($TPL_V4["unit_ea"])?>=<?php echo number_format($TPL_V3["request_ea"]*$TPL_V4["unit_ea"])?>

<?php }else{?>
				0
<?php }?>
				</span>
				</td>

				<td class="null center">→</td>
				<td class="info option center">
					<input type="hidden" class="unit_ea" name="unit_ea[option][<?php echo $TPL_V3["item_option_seq"]?>][<?php echo $TPL_V4["package_option_seq"]?>]" value="<?php echo $TPL_V4["unit_ea"]?>" />
					<span class="package_ea" style="display:inline-block;width:38px;text-align:right;"><?php echo number_format($TPL_V3["request_ea"]*$TPL_V4["unit_ea"])?></span>
					<span class="helpicon" title="<?php echo $TPL_V4["unit_ea"]?>개 / 주문수량당"></span>
				</td>
				<td class="info option center">
				<span class="fx11 dotum">
<?php if($TPL_V3["request_ea"]== 0){?>
				-
<?php }else{?>
				대기
<?php }?>
				</span>
<?php if($TPL_V3["request_ea"]> 0){?>
					<input type="text" name="package_barcode_ea[<?php echo $TPL_V2["shipping_group_seq"]?>][<?php echo strtoupper($TPL_V4["bar_goods_code"])?>]" class="barcode_ea_<?php echo $TPL_V2["shipping_group_seq"]?> barcode_ready package" style="text-align:right;" value="0" size="2" onblur="package_check_barcode_ea(this);" />
<?php }?>
				</td>
			</tr>
<?php }}?>
<?php }?>

<?php if(is_array($TPL_R4=$TPL_V3["suboptions"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
			<tr class="open-tr">
				<td class="info suboption" style="padding:3px 0px 0px 45px;">
<?php if($TPL_V4["suboption"]){?>
					<img src="/admin/skin/default/images/common/icon_add_arrow.gif" /><img src="/admin/skin/default/images/common/icon_add.gif" /> <?php echo $TPL_V4["title"]?>:<?php echo $TPL_V4["suboption"]?>


<?php }?>

					<div class="warehouse-info-lay">
						<ul>
							<li class="wh_info"></li>
							<li>상품코드 : <?php echo $TPL_V4["goods_code"]?></li>
						</ul>
					</div>

<?php if($TPL_V4["npay_pay_delivery"]=='y'){?>
					<div class='red'>! 네이버 페이 판매자센터에서 출고진행중인 주문입니다.</div>
<?php }?>
				</td>
				<td class="info suboption" align="center">
<?php if($TPL_V4["package_yn"]!='y'){?>
<?php if($TPL_V4["stock"]==='미매칭'){?>
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_data"]["goods_seq"]){?>
					미매칭
<?php }?>
<?php }else{?>
					<span class="stock"><?php echo number_format($TPL_V4["stock"])?></span>
<?php }?>
					<input type="hidden" name="stock[<?php echo $TPL_V2["shipping_seq"]?>][suboption][<?php echo $TPL_V4["item_suboption_seq"]?>]" class="whstock" value="<?php echo $TPL_V4["stock"]?>" />
<?php }else{?>
					<span class="fx11 dotum">실제상품▼</span>
<?php }?>
				</td>
				<td class="info suboption" align="center"><?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><span class="ea"><?php echo number_format($TPL_V4["ea"])?></span><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info suboption" align="center"><?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V4["step85"])?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info suboption" align="center"><?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V4["export_ea"])?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info suboption" align="center">
<?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V4["request_ea"])?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?>
					<input type="hidden" class="orderEA" value="<?php echo $TPL_V4["request_ea"]?>" />
				</td>
				<td class="null" align="center">→</td>

<?php if($_GET["mode"]=='order'){?>
				<td class="info suboption" align="center">
<?php if($TPL_V4["request_ea"]== 0){?>
					모두 출고됨
<?php }else{?>
					<?php echo $TPL_V4["request_ea"]?>

<?php }?>
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_data"]["goods_kind"]!='coupon'){?>
					<input type="hidden" name="request_ea[<?php echo $TPL_V2["shipping_seq"]?>][suboption][<?php echo $TPL_V4["item_suboption_seq"]?>]" class="line export_ea"  style="text-align:right" size="3" value="<?php echo $TPL_V4["request_ea"]?>" org="<?php echo $TPL_V4["request_ea"]?>" opt_type="sub" item_seq="<?php echo $TPL_V3["item_seq"]?>" >
					<input type="hidden" name="shipping_goods_kind[<?php echo $TPL_V2["shipping_seq"]?>][suboption][<?php echo $TPL_V4["item_suboption_seq"]?>]"  value="SUB" />
<?php }?>
				</td>
<?php }else{?>
				<td class="info suboption" align="center">
<?php if($TPL_V4["request_ea"]== 0){?>
					0
<?php }else{?>
<?php if($TPL_V2["items"][$TPL_V3["item_seq"]]["goods_data"]["goods_kind"]!='coupon'){?>
<?php if($TPL_VAR["npay_use"]&&$TPL_V3["npay_product_order_id"]){?>
					<input type="hidden" name="request_ea[<?php echo $TPL_V2["shipping_seq"]?>][suboption][<?php echo $TPL_V4["item_suboption_seq"]?>]" value="<?php echo $TPL_V4["request_ea"]?>" org="<?php echo $TPL_V4["request_ea"]?>">
					<input type="text" name="request_ea_tmp[<?php echo $TPL_V2["shipping_seq"]?>][suboption][<?php echo $TPL_V4["item_suboption_seq"]?>]" class="line export_ea"  style="text-align:right" size="2" value="<?php echo $TPL_V4["request_ea"]?>" org="<?php echo $TPL_V4["request_ea"]?>" opt_type="sub" item_seq="<?php echo $TPL_V3["item_seq"]?>"   disabled>
<?php }else{?>
					<input type="text" name="request_ea[<?php echo $TPL_V2["shipping_seq"]?>][suboption][<?php echo $TPL_V4["item_suboption_seq"]?>]" class="line export_ea" style="text-align:right" size="2" value="<?php echo $TPL_V4["request_ea"]?>" org="<?php echo $TPL_V4["request_ea"]?>" opt_type="sub" item_seq="<?php echo $TPL_V3["item_seq"]?>"  onkeyup="reset_barcode_ea(this);check_request_ea(this,<?php echo $TPL_V4["request_ea"]?>);">
<?php }?>
					<input type="hidden" name="shipping_goods_kind[<?php echo $TPL_V2["shipping_seq"]?>][suboption][<?php echo $TPL_V4["item_suboption_seq"]?>]"  value="SUB" />
<?php }?>
<?php }?>
				</td>
<?php }?>
				<td class="info suboption" align="center">
					<span><?php if($TPL_V4["request_ea"]== 0){?>-<?php }else{?>대기<?php }?></span>
<?php if($TPL_V4["request_ea"]> 0){?>
					<input type="text" name="barcode_ea[<?php echo $TPL_V2["shipping_seq"]?>][<?php echo strtoupper($TPL_V4["bar_goods_code"])?>]" class="barcode_ea_<?php echo $TPL_V2["shipping_seq"]?> barcode_ready" value="0" size="2" onblur="check_barcode_ea(this);" />
<?php }?>
				</td>
			</tr>
<?php if($TPL_V4["package_yn"]=='y'){?>
<?php if(is_array($TPL_R5=$TPL_V4["packages"])&&!empty($TPL_R5)){foreach($TPL_R5 as $TPL_V5){?>
			<tr class="open-tr">
				<td class="info suboption" style="padding-left:68px;">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_V2["items"][$TPL_V3["item_seq"]]["goods_data"]["provider_seq"]== 1){?>
					<input type="hidden" name="whcode" class="optioninfo" value="<?php echo $TPL_V5["goods_seq"]?>option<?php echo $TPL_V5["option_seq"]?>" />
					<input type="hidden" name="str_wh_info[suboption][<?php echo $TPL_V4["item_suboption_seq"]?>][<?php echo $TPL_V5["package_suboption_seq"]?>]" value="<?php echo $TPL_V5["goods_seq"]?>|<?php echo $TPL_V5["option_seq"]?>|<?php echo $TPL_V5["goods_code"]?>|<?php echo $TPL_V5["supply_price"]?>" />
<?php }?>
					<table class="list-goods-info" width="100%">
						<tr>
							<td valign="top" style="border:none;"><img src="/admin/skin/default/images/common/icon/ico_package.gif" border="0" /></td>
							<td width="50" style="border:0px" class="center">
								<span class="order-item-image"><img src="<?php echo $TPL_V5["image"]?>" class="small_goods_image" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif';" /></span>
							</td>
							<td style="border:0px;">
								<div class="goods_name">
									<span class="red">[실제상품] <?php echo $TPL_V5["goods_name"]?></span>
								</div>
								<div class="goods_option">
<?php if($TPL_V5["option1"]){?>
									<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php if($TPL_V5["title1"]){?>
									<?php echo $TPL_V5["title1"]?>:
<?php }?>
									<?php echo $TPL_V5["option1"]?>

<?php if($TPL_V5["title2"]){?>
									&nbsp;<?php echo $TPL_V5["title2"]?>:
<?php }?>
									<?php echo $TPL_V5["option2"]?>

<?php if($TPL_V5["title3"]){?>
									&nbsp;<?php echo $TPL_V5["title3"]?>:
<?php }?>
									<?php echo $TPL_V5["option3"]?>

<?php if($TPL_V5["title4"]){?>
									&nbsp;<?php echo $TPL_V5["title4"]?>:
<?php }?>
									<?php echo $TPL_V5["option4"]?>

<?php if($TPL_V5["title5"]){?>
									&nbsp;<?php echo $TPL_V5["title5"]?>:
<?php }?>
									<?php echo $TPL_V5["option5"]?>

<?php }?>
								</div>
								<div class="goods_option fx11 goods_code_icon">
								</div>

								<div class="warehouse-info-lay">
									<ul>
										<li class="wh_info"></li>
<?php if($TPL_V5["goods_code"]){?>
										<li><?php echo $TPL_V5["goods_code"]?></li>
<?php }?>
									</ul>
								</div>

							</td>
						</tr>
					</table>
				</td>
				<td class="info suboption center"><span class="red"><?php echo number_format($TPL_V5["stock"])?></span></td>

				<td class="info suboption center">
				<span class="red fx11">
<?php if($TPL_V4["ea"]){?>
				[<?php echo number_format($TPL_V4["ea"])?>]x<?php echo number_format($TPL_V5["unit_ea"])?>=<?php echo number_format($TPL_V4["ea"]*$TPL_V5["unit_ea"])?>

<?php }else{?>
				0
<?php }?>
				</span>
				</td>
				<td class="info suboption center">
				<span class="red fx11">
<?php if($TPL_V4["step85"]){?>
				[<?php echo number_format($TPL_V4["step85"])?>]x<?php echo number_format($TPL_V5["unit_ea"])?>=<?php echo number_format($TPL_V4["step85"]*$TPL_V5["unit_ea"])?>

<?php }else{?>
				0
<?php }?>
				</span>
				</td>
				<td class="info suboption center">
				<span class="red fx11">
<?php if($TPL_V4["export_ea"]){?>
				[<?php echo number_format($TPL_V4["export_ea"])?>]x<?php echo number_format($TPL_V5["unit_ea"])?>=<?php echo number_format($TPL_V4["export_ea"]*$TPL_V5["unit_ea"])?>

<?php }else{?>
				0
<?php }?>
				</span>
				</td>
				<td class="info suboption center">
				<span class="red fx11">
<?php if($TPL_V4["request_ea"]){?>
				[<?php echo number_format($TPL_V4["request_ea"])?>]x<?php echo number_format($TPL_V5["unit_ea"])?>=<?php echo number_format($TPL_V4["request_ea"]*$TPL_V5["unit_ea"])?>

<?php }else{?>
				0
<?php }?>
				</span>
				</td>

				<td class="null" align="center">→</td>
				<td class="info suboption center">
					<input type="hidden" class="unit_ea" name="unit_ea[suboption][<?php echo $TPL_V4["item_suboption_seq"]?>][<?php echo $TPL_V5["package_suboption_seq"]?>]" value="<?php echo $TPL_V5["unit_ea"]?>" />
					<span class="package_ea" style="display:inline-block;width:38px;text-align:right;"><?php echo $TPL_V5["unit_ea"]*$TPL_V4["request_ea"]?></span>
					<span class="helpicon" title="<?php echo $TPL_V5["unit_ea"]?>개 / 주문수량당"></span>
				</td>
				<td class="info suboption center">
				<span class="fx11 dotum">
<?php if($TPL_V4["request_ea"]== 0){?>
				-
<?php }else{?>
				대기
<?php }?>
				</span>
<?php if($TPL_V4["request_ea"]> 0){?>
					<input type="text" name="package_barcode_ea[<?php echo $TPL_V2["shipping_seq"]?>][<?php echo strtoupper($TPL_V5["bar_goods_code"])?>]" class="barcode_ea_<?php echo $TPL_V2["shipping_seq"]?> barcode_ready package" style="text-align:right;" value="0" size="2" onblur="package_check_barcode_ea(this);" />
<?php }?>
				</td>
			</tr>
<?php }}?>
<?php }?>
<?php }}?>
<?php }}?>
			</tbody>
		</table>
		<div class="pdb10"></div>
<?php }}?>
<?php }}?>
	</div>
	<!-- 출고 리스트 :: END -->

</form>


<?php if($TPL_VAR["data_page"]["totalpage"]>= 1){?>
<div class="paging_navigation" style="margin:auto;">
	<?php echo $TPL_VAR["data_page"]["html"]?>

</div>
<?php }?>


<div id="export_goods_selected_"></div>

<iframe name="export_frame" width="100%" height="1000" class="hide"></iframe>

<script type="text/javascript">check_stock_policy_step();</script>
<div id="goods_matching_dialog"></div>
<div id="invoice_manual_dialog" class="hide">
	<div id="gift_use_lay"></div>
<?php $this->print_("invoice_guide",$TPL_SCP,1);?>

</div>
<div id="default_stock_check_dialog" class="hide">
<?php $this->print_("default_stock_check",$TPL_SCP,1);?>

</div>
<div id="batch_status_popup_layer"></div>
<div id="gift_use_lay"></div>
<div id="search_detail_dialog" class="hide">
<?php $this->print_("export_default_search_path",$TPL_SCP,1);?>

</div>
<div id="no_matching_dialog" class="hide">
	<div class="fx12 pdb10">
		<div>
			● 미매칭 상품이란?<br />
			&nbsp;&nbsp;&nbsp;<span class="darkgray">주문된 상품이 등록된 상품과 정확하게 매칭되지 않는 상품을 말합니다.</span>
		</div>
		<div style="margin-top:8px;">
			● 미매칭 상품은 왜 생기나요?<br />
			&nbsp;&nbsp;&nbsp;<span class="darkgray">상품 삭제, 옵션명 변경, 등록되지 않은 상품을 판매할 경우 주문서에 미매칭 상품이 발생하게 됩니다.</span>
		</div>
		<div style="margin-top:8px;">
			● 미매칭 상품에 대하여 매칭하지 않고 출고 처리할 경우 아래와 같은 문제가 발생됩니다.
		</div>
	</div>
	<table width="100%" class="info-table-style">
		<tr>
			<th class="its-th" rowspan="2">구분</th>
			<th class="its-th" style="padding-left:15px;">자체 쇼핑몰의 주문</th>
			<th class="its-th" style="padding-left:15px;">외부마켓으로부터 수집된 주문</th>
		</tr>
		<tr>
			<th class="its-th" style="padding-left:15px;">매칭하지 않고 출고</th>
			<th class="its-th" style="padding-left:15px;">매칭하지 않고 출고</th>
		</tr>
		<tr>
			<th class="its-th" rowspan="3">출고 시</th>
			<td class="its-td">재고 처리 불가능 (skip)</td>
			<td class="its-td">재고 처리 불가능 (skip)</td>
		</tr>
		<tr>
			<td class="its-td">매입원가 반영</td>
			<td class="its-td">매입원가 반영 불가능</td>
		</tr>
		<tr>
			<td class="its-td">지급 마일리지액 반영</td>
			<td class="its-td">지급 마일리지액 반영 불가능</td>
		</tr>
		<tr>
			<th class="its-th">반품 시</th>
			<td class="its-td">재고 처리 불가능 (skip)</td>
			<td class="its-td">재고 처리 불가능 (skip)</td>
		</tr>
	</table>
	<div class="red fx12 pdt10" style="line-height:20px;letter-spacing:-1px;">
		※ 주의<br />
		&nbsp;&nbsp;&nbsp;- 미매칭 상품(알 수 없는 상품)을 출고할 경우 상기 문제 외 예상치 못한 다른 문제가 발생할 수도 있습니다.<br/>
		&nbsp;&nbsp;&nbsp;- 미매칭 상품(알 수 없는 상품)을 매칭 후 출고를 처리 하시길 적극 권장 드립니다.
	</div>
</div>

<!-- 출고지 정보 팝업 :: START -->
<div id="address_dialog" class="hide">
	<table class="info-table-style" width="100%" border="0" cellspacing="0" cellpadding="0">
		<colgroup>
			<col width="75px" />
			<col width="" />
		</colgroup>
		<tr>
			<th class="its-th">분류</th>
			<td class="its-td" id="address_category"></td>
		</tr>
		<tr>
			<th class="its-th">명칭</th>
			<td class="its-td" id="address_name"></td>
		</tr>
		<tr>
			<th class="its-th">주소</th>
			<td class="its-td" id="view_address"></td>
		</tr>
		<tr>
			<th class="its-th">연락처</th>
			<td class="its-td" id="shipping_phone"></td>
		</tr>
	</table>
	<div class="pd10 center">
		<span class="btn small cyanblue" ><button type="button" style="width:60px;" onclick="closeDialog('address_dialog');">닫기</button></span>
	</div>
</div>
<!-- 출고지 정보 팝업 :: END -->

<div id="bundle_dialog" class="hide">
	<div class="fx12 pdb10">
		<div>
			아래의 조건을 모두 만족 시 합포장(묶음배송)이 가능합니다.
		</div>
	</div>
	<div>
		<p>첫번째) 출고할 주문을 2개 이상 선택해야 합니다. (단, 동일한 주문은 선택 불가)</p>
		<p>두번째) 선택한 주문의 주문자, 받는곳, 받는분, 받는분 연락처(휴대폰)의 정보가 동일해야 합니다.</p>
		<p>세번째) 선택한 주문의 동일 판매자의 실물 배송상품을 합포장 할 수 있습니다.</p>
		<p>네번째) 출고수량이 있는 합포장 대상 주문이 2개 이상이어야 합니다.</p>
		<p>다섯번째) 외부주문은 합포장이 불가능합니다.</p>
	</div>
</div>


<div id="not_to_be_bundle" class="hide">
	<div class="fx14 pdb10">
		● 합포장 조건 결과 : 선택하신 주문간에 상이한 정보가 있어 합포장을 할 수 없습니다.
	</div>
	<table width="100%" id="bundle_list" class="info-table-style">
		<thead>
		<tr>
			<th class="its-th" width="150">주문번호</th>
			<th class="its-th" width="100">주문자</th>
			<th class="its-th">받는곳</th>
			<th class="its-th" width="80">받는분</th>
			<th class="its-th" width="100">받는분 휴대폰</th>
		</tr>
		</thead>
		<tbody></tbody>
	</table>
	<br/>
	<div class="fx14 pdb10 center bold">
		합포장 주문건을 다시 선택해 주십시오.
	</div>
</div>

<div id="to_be_bundle" class="hide">
	<form name="bundle_order_export" id="bundle_goods_export" method="post" action="../order_process/bundle_order_export_popup" target="export_frame" onsubmit="loadingStart();" autocomplete="off">
		<input type="hidden" name="bundle_check_mode" value=""/>
		<div id="bundle_export_form"></div>
		<div>
			<table width="100%" border="0" style="table-layout: fixed">
				<tr>
					<td width="15%"><span id="bundle_provider_list" class="bold"></span></td>
					<td align="left" valign="top">

						<table class="rec-info">
							<tr>
								<td rowspan="2" align="right"><span class="bundle_member_info"></span></td>
								<td width="25"></td>
								<td><br><span class="bundle_addr"></span></td>
							</tr>
							<tr>
								<td></td>
								<td><span class="bundle_phone"></span></td>
							</tr>
						</table>

					</td>
					<td width="29%" class="left">
						<input type="text" name="bundle_barcode" style="width:100%;" value="" title="피킹(picking)한 상품의 바코드(상품코드)를 스캔→검수" onkeydown="check_bundle_barcode(this)" class="barcode"/>
					</td>
					<td width="1%" align="right"></td>
				</tr>
			</table>
		</div>

		<table class="simplelist-table-style table-export-info bundle_shipping_group" width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout: fixed">
			<colgroup>
				<col width="13%"/>
				<col />
				<col width="5%"/>
				<col width="5%"/>
				<col width="5%"/>
				<col width="5%"/>
				<col width="5%"/>
				<col width="5%"/>
				<col width="5%"/>
				<col width="8%"/>
				<col width="17%"/>
			</colgroup>
			<thead>
			<tr>
				<th>주문번호</th>
				<th>주문상품</th>
				<th>재고</th>
				<th>주문</th>
				<th>취소</th>
				<th>보낸수량</th>
				<th>남은수량 </th>
				<th class="null"></th>
				<th>보낼수량</th>
				<th>검수</th>
				<th>받는방법</th>
			</tr>
			</thead>
			<tbody></tbody>
		</table>

		<br/><br/>

		<table class="export_table" style="border-collapse:collapse" border='1'>
			<thead><col width="13%" /><col  /></thead>
			<tbody>
			<tr>
				<th>출고일자</th>
				<td>
					<input type="text" name="bundle_export_date" class="datepicker line"  maxlength="10" size="10" readonly value="<?php echo date('Y-m-d')?>">
				</td>
			</tr>
			<tr>
				<th>출고처리</th>
				<td>
					<div class="pdb5">
						실물 :	<input type="hidden" name="bundle_stockable" id="bundle_export_stockable" value="<?php echo $TPL_VAR["data_present_provider"]["default_export_stock_check"]?>">
						<span class="hide">
<?php if($TPL_VAR["data_present_provider"]["default_export_stock_check"]=='limit'){?>
							출고되는 모든 실물의 재고가 있으면
<?php }elseif($TPL_VAR["data_present_provider"]["default_export_stock_check"]=='unlimit'){?>
							출고되는 모든 실물의 재고가 부족해도
<?php }?>
							→ 재고 차감 → (설정 시) SMS/EMAIL 발송 →
						</span>
						<select name="bundle_export_step" id="bundle_export_step" onchange="check_stock_policy_step('bundle')">
							<option value="55" <?php if($TPL_VAR["data_present_provider"]["default_export_stock_step"]=='55'){?>selected<?php }?>>출고완료</option>
							<option value="45" <?php if($TPL_VAR["data_present_provider"]["default_export_stock_step"]=='45'){?>selected<?php }?>>출고준비</option>
						</select>로 상태 처리
					</div>
				</td>
			</tr>
			</tbody>
		</table>

		<div class="center red pdb5 fx11">
			통신판매중계자가 입점사 판매상품을 출고처리 시 그에 따른 책임을 통신판매중계자에게 있습니다.
		</div>

		<div class="center blue pdb5 fx11">
			합포장(묶음배송)으로 인해 배송비를 고객님게 되돌려 드려야 할 경우 판매자께서 직접 구매자에게 환불해 주십시오.<br/>
			또는 통신판매중계자에게 환불을 요청해 주십시오. <br/>
			통신판매중계자가 환불을 처리할 경우 정산 시 환불금액이 차감됩니다.
		</div>

<?php if($TPL_VAR["gf_config"]["goodsflow_step"]=='1'){?>
		<div id="goodsflow_desc" class="center pdb5 fx11">
			* <span class="blue">굿스플로</span> 서비스를 이용하여 출고처리 시 <span class="blue">출고준비</span> 상태로 먼저 변경하고,
			송장 자동발급 서비스를 사용하셔야 구매자에게 <span class="blue">운송장번호가 발송</span>됩니다.
		</div>
<?php }?>
	</form>

	<table  width="100%">
		<tr>
			<td>
				<span class="btn large gray" ><button type="button" id="bundle_goods_export" style="width:100px;" onclick="export_check('bundle');">예상결과 보기</button></span>
			</td>
			<td>
				<span class="btn large cyanblue" ><button type="button" id="bundle_goods_export" style="width:100px;" onclick="export_submit('bundle');">합포장 출고처리</button></span>
			</td>
		</tr>
	</table>
</div>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>