<?php /* Template_ 2.2.6 2022/05/17 12:29:06 /www/music_brother_firstmall_kr/selleradmin/skin/default/export/batch_status.html 000082610 */ 
$TPL_all_delivery_1=empty($TPL_VAR["all_delivery"])||!is_array($TPL_VAR["all_delivery"])?0:count($TPL_VAR["all_delivery"]);
$TPL_ship_set_code_1=empty($TPL_VAR["ship_set_code"])||!is_array($TPL_VAR["ship_set_code"])?0:count($TPL_VAR["ship_set_code"]);
$TPL_marketList_1=empty($TPL_VAR["marketList"])||!is_array($TPL_VAR["marketList"])?0:count($TPL_VAR["marketList"]);
$TPL_data_export_1=empty($TPL_VAR["data_export"])||!is_array($TPL_VAR["data_export"])?0:count($TPL_VAR["data_export"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<!-- 2022.01.06 12월 1차 패치 by 김혜진 -->
<script type="text/javascript">
	var today			= "<?php echo date('Y-m-d')?>";
	var week			= "<?php echo date('Y-m-d',strtotime('-1 week'))?>";
	var mon				= "<?php echo date('Y-m-d',strtotime('-1 month'))?>";
	var mon3			= "<?php echo date('Y-m-d',strtotime('-3 month'))?>";
	var gf_deliveryCode = '<?php echo $TPL_VAR["gf_config"]["gf_deliveryCode"]?>';
	var keyword			= "<?php echo $TPL_VAR["sc"]["keyword"]?>";
	var search_type		= "<?php echo $TPL_VAR["sc"]["search_type"]?>";

<?php if($TPL_VAR["exist_goods"]){?>
	var chk_export_msg = '상태변경할 출고를 선택하세요.';
	var chk_save_msg = '저장할 출고를 선택하세요.';
<?php }else{?>
	var chk_export_msg = '상태변경할 출고가 없습니다. 출고를 검색하세요.';
	var chk_save_msg = '저장할 출고정보가 없습니다. 출고를 검색하세요.';
<?php }?>

</script>
<script type="text/javascript" src="/app/javascript/js/admin-batchStatus.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-shipping.js"></script>
<script type="text/javascript">
	$( document ).ready(function() {
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
			'left' : "1px",
			'top' : "1px",
			'width':$("#search_keyword").width()-1,
			'height':$("#search_keyword").height()+3
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

			$("#set_default_setting_button").click(function(){
				var title = '기본검색 설정<span style="font-size:11px; margin-left:26px;"> - 아래서 원하는 검색조건을 설정하여 편하게 쇼핑몰을 운영하세요</span>';
				openDialog(title, "search_detail_dialog", {"width":"1220","height":"300"});
			});

			var exportBarPositionTop = $("#export-bar").offset().top;
			$(document).scroll(function(){
				if($(document).scrollTop()>exportBarPositionTop){
					$("#export-bar-area").height($("#export-bar").outerHeight());
					$("#export-bar").addClass('flying');
				}else{
					$("#export-bar").removeClass('flying');
				}
			});

			apply_input_style();

			$("button.batch_status_btn").live("click",function(){
				var f = document.batch_status;
				$("input[name='mode']").val($(this).attr('id'));
				loadingStart();
				f.submit();
			});

			$(".shipping_user_name")
					.bind("mouseenter",function(){
						$(this).parent().children(".relative").children().show();
					})
					.bind("mouseleave",function(){
						$(this).parent().children(".relative").children().hide();
					});

			$("select.delivery_company").bind("change",function(){
				var thisValue = $(this).val() ? $(this).val() : '';
				if(thisValue.substring(0,5)=='auto_'){
					$("option",this).not(":selected").attr("disabled",true);
					$(this).parent().find("input.delivery_number").attr("readonly",true).addClass("disabled");
				}else{
					$(this).parent().find("input.delivery_number").attr("readonly",false).removeClass("disabled");
				}
			}).change();

			$("span#invoice_manual_button").bind("click",function(){
				var title = '택배 업무 자동화 서비스 사용방법';
				openDialog(title, "invoice_manual_dialog", {"width":"700"});
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
			});
</script>
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/searchform.css" />
<style>
	.tip-darkgray {z-index:10000; left:0px; top:0px;}

	/* 출고내역 테이블 */
	table td.info {border:1px solid #ddd;  padding:0px;}
	table td.null,table th.null { border:0px; background:#fff }
	span.goods_name1 {display:inline-block;height:white-space:nowrap;overflow:hidden;width:450px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	span.goods_name2 {display:inline-block;height:white-space:nowrap;overflow:hidden;width:300px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
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
	#export-bar.flying {position:fixed;	width:100%;left:0px;top:0px;z-index:100;background:url('/admin/skin/default/images/common/tit_bg_rollover.png') repeat-x; }
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
	table.rec-info tr td span.store {color:#999999;}

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
	table.table-export-info th.null {background-color:#fff;height:25px;border-top:0px;border-bottom:0px;}
	table.table-export-info td.null {background-color:#fff;height:25px;border-top:0px;border-bottom:0px;}
	div.search-form-container {margin-bottom: 0 !important;}


<?php if($TPL_VAR["data_search_default"]["export_detail_view"]!='close'){?>
	tr.close-tr {display:none;}
<?php }else{?>
	tr.open-tr {display:none;}
<?php }?>
</style>

<form name="order_export" id="goods_export" method="post" action="../export_process/batch_status" target="export_frame" onsubmit="loadingStart();">
	<input type="hidden" name="gf_mode" value="" />
	<input type="hidden" name="gf_export_code" value="" />
	<input type="hidden" name="each_export_code" value="">

	<div style="padding:5px 0px 0;" align="center">
		<table class="export-tab-tbl" style="border-collapse:collapse" border='1'>
			<tr>
				<td>
					<a href="../order/order_export_popup">주문  → 출고처리</a>
				</td>
				<td class="on">
					출고 → 출고상태변경 <img src="/admin/skin/default/images/common/icon/check_icon.png" />
				</td>
			</tr>
		</table>
	</div>

	<div class="search-form-container">
		<table class="table_search">
			<tr>
				<th>검색어</th>
				<td>
					<div class="relative">
						<input type="text" name="keyword" id="search_keyword" value="<?php echo $_GET["keyword"]?>" title="출고번호,주문번호,아이디,주문자,수령자,입금자,이메일,연락처,휴대폰,상품명,상품번호,상품코드" size="100" autocomplete='off'/>
						<!-- 검색어 입력시 레이어 박스 : start -->
						<div class="search_type_text hide"><?php echo $_GET["search_type_text"]?></div>
						<div class="searchLayer hide">
							<input type="hidden" name="search_type" id="search_type" value="<?php echo $_GET["search_type"]?>" />
							<ul class="searchUl">
								<li><a class="link_keyword" s_type="export_code" href="#">출고번호: <span class="txt_keyword"></span> <span class="txt_title">-출고번호 찾기</span></a></li>
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
								<li><a class="link_keyword" s_type="npay_order_id" href="#">Npay주문번호: <span class="txt_keyword"></span> <span class="txt_title">-Npay주문번호 찾기</span></a></li>
								<li><a class="link_keyword" s_type="npay_product_order_id" href="#">Npay상품주문번호: <span class="txt_keyword"></span> <span class="txt_title">-Npay상품주문번호 찾기</span></a></li>
							</ul>
						</div>
						<!-- 검색어 입력시 레이어 박스 : end -->
					</div>
				</td>
			</tr>
		</table>
		<table class="search-form-table search-detail-lay search_detail_form" id="serch_tab" border="0">
			<tr id="goods_search_form" >
			<tr>
				<td>
					<table class="sf-option-table table_search" border="0" style="table-layout:fixed;">
						<tr>
							<th>날짜</th>
							<td>
								<select name="date_field" style="width:110px;">
									<option value="order" <?php if($_GET["date_field"]=='order'){?>selected<?php }?>>주문일</option>
									<option value="export" <?php if($_GET["date_field"]=='export'||!$_GET["date_field"]){?>selected<?php }?>>출고일(입력)</option>
									<option value="regist_date" <?php if($_GET["date_field"]=='regist_date'){?>selected<?php }?>>출고일</option>
									<option value="shipping" <?php if($_GET["date_field"]=='shipping'){?>selected<?php }?>>배송완료일</option>
									<option value="confirm_date" <?php if($_GET["date_field"]=='confirm_date'){?>selected<?php }?>>구매확정일</option>
								</select>
								<input type="text" name="regist_date[]" value="<?php echo $_GET["start_search_date"]?>" class="datepicker"  maxlength="10" size="10" />
								&nbsp;<span class="gray">-</span>&nbsp;
								<input type="text" name="regist_date[]" value="<?php echo $_GET["end_search_date"]?>" class="datepicker" maxlength="10" size="10" />

								<span class="resp_btn_wrap">
						<span class="btn small"><input type="button" value="오늘" onclick="set_date_export('<?php echo date('Y-m-d')?>','<?php echo date('Y-m-d')?>');" class="select_date resp_btn" /></span>
						<span class="btn small"><input type="button" value="3일간" onclick="set_date_export('<?php echo date('Y-m-d',strtotime('-3 day'))?>','<?php echo date('Y-m-d')?>');" class="select_date resp_btn" /></span>
						<span class="btn small"><input type="button" value="일주일" onclick="set_date_export('<?php echo date('Y-m-d',strtotime('-7 day'))?>','<?php echo date('Y-m-d')?>');" class="select_date resp_btn" /></span>
						<span class="btn small"><input type="button" value="1개월" onclick="set_date_export('<?php echo date('Y-m-d',strtotime('-1 month'))?>','<?php echo date('Y-m-d')?>');" class="select_date resp_btn" /></span>
						<span class="btn small"><input type="button" value="3개월" onclick="set_date_export('<?php echo date('Y-m-d',strtotime('-3 month'))?>','<?php echo date('Y-m-d')?>');" class="select_date resp_btn"/></span>
						<span class="btn small"><input type="button" value="전체" onclick="set_date_export('','');" class="select_date resp_btn"/></span>
					</span>
							</td>
						</tr>
						<tr>
							<th>출고상태</th>
							<td >
<?php if(is_array($TPL_R1=config_load('export_status'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
								<label class="search_label resp_radio" >
									<input type="radio" name="status" value="<?php echo $TPL_K1?>" <?php if($_GET["status"]==$TPL_K1){?>checked<?php }?> />
									<span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span>
								</label>
<?php }}?>

<?php if($TPL_VAR["npay_use"]&&false){?>
								<label style="margin-left:20px;display:inline-block;height:26px;vertical-align:middle;line-height:26px;">
									<input type="checkbox" name="search_npay_order" value='y' <?php if($_GET["search_npay_order"]=='y'){?>checked<?php }?> align="middle"> Npay 주문건
								</label>
<?php }?>
							</td>
						</tr>
						<tr>
							<th>택배사</th>
							<td>
								<div class="src_shipping_delivery_area">
									<select name="src_shipping_delivery" style="vertical-align:middle;width:100px;height:25px;">
										<option value="">택배사 전체</option>
<?php if($TPL_all_delivery_1){foreach($TPL_VAR["all_delivery"] as $TPL_K1=>$TPL_V1){?>
										<option value="<?php echo $TPL_K1?>" <?php if($_GET["src_shipping_delivery"]==$TPL_K1){?>selected<?php }?>><?php echo $TPL_V1["company"]?></option>
<?php }}?>
									</select>
									<input type="text" name="search_delivery_number" size="15" title="운송장번호" class="search_delivery" value="<?php echo $_GET["search_delivery_number"]?>"  />
									<label class="resp_checkbox"><input type="checkbox" name="none_search_delivery_number"  value="1" class="search_delivery" <?php if($_GET["none_search_delivery_number"]){?>checked<?php }?> /> 없음</label>
								</div>
							</td>
						</tr>
						<tr>
							<th>배송방법</th>
							<td>
								<div class="resp_checkbox">
									<label><input type="checkbox" class="allSelectDrop" name="allsearch_shipping_method" <?php if(count($_GET['shipping_method'])== 7){?>checked<?php }?> default_none> <span class="allshipmethod fx12">배송방법 전체</span></label>
<?php if($TPL_ship_set_code_1){foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){?>
									<label><input type="checkbox" name="search_shipping_method[]" value="<?php echo $TPL_K1?>" title="<?php echo $TPL_V1?>" <?php if($_GET['shipping_method'][$TPL_K1]==$TPL_K1){?>checked<?php }?> default_none> <?php echo $TPL_V1?></label>
<?php }}?>
									<label><input type="checkbox" name="search_shipping_method[]" value="coupon" title="문자/이메일" <?php if($_GET['shipping_method']['coupon']=='coupon'){?>checked<?php }?> default_none> 문자/이메일</label>
<?php if($TPL_VAR["npay_use"]){?>
									<label><input type="checkbox" name="search_npay_order" value='y' <?php if($_GET["search_npay_order"]=='y'){?>checked<?php }?>> 네이버페이 주문</label>
<?php }?>
								</div>
							</td>
						</tr>
<?php if($TPL_VAR["connectorUse"]==true&&$TPL_VAR["isExportedList"]==true){?>
						<tr>
							<th>오픈마켓</th>
							<td>
								<div class="resp_checkbox">
									<label><input type="checkbox" name="allselectMarkets" class="allSelectDrop" default_none value='y' <?php if(count($TPL_VAR["marketList"])==count($_GET["selectMarkets"])){?>checked<?php }?>> <span class="allselectMarkets fx12">오픈 마켓 전체</span></label>
<?php if($TPL_marketList_1){foreach($TPL_VAR["marketList"] as $TPL_K1=>$TPL_V1){?>
									<label><input type="checkbox" class="allCheckMark" name="selectMarkets[]" value="<?php echo $TPL_K1?>" <?php if(in_array($TPL_K1,$_GET["selectMarkets"])){?>checked<?php }?>/> <?php echo $TPL_V1["name"]?></label>
<?php }}?>
									<label><input type="checkbox" name="search_market_fail" value='y' <?php if($_GET["search_market_fail"]=='y'){?>checked<?php }?>> 송장전송실패 조회</label>
								</div>
							</td>
						</tr>
<?php }?>
					</table>
				</td>
			<tr>
		</table>
		<div class="footer search_btn_lay">
			<div>
			<span class="sc_edit">
				<button type="button" id="set_default_setting_button" class="resp_btn v3">기본검색설정</button>
				<button type="button" id="get_default_button" onclick="set_default_search_form();" class="resp_btn v3">기본검색적용</button>
			</span>
				<span class="search">
				<button type="button" onclick="go_search_export();" class="resp_btn active"><span>검색</span></button>
				<button type="button" id="search_reset_button" onclick="reset_search_form();" class="resp_btn v3">초기화</button>
			</span>
				<span class="detail">
				<button type="button" id="search_detail_button" class="close resp_btn v3" class="close" value="open">상세검색닫기</button>
			</span>
			</div>
		</div>
	</div>

	<div align="center">
		<div style="position: relative;width:100px;height:8px;">
			<div style="position: absolute;z-index:2;top:0px;" id="btn-close-search"><a href="javascript:close_search_form();"><img src="/admin/skin/default/images/common/search_close.gif" /></a></div>
			<div style="position: absolute;z-index:2;top:0px;" id="btn-open-search"><a href="javascript:open_search_form();"><img src="/admin/skin/default/images/common/search_open.gif" /></a></div>
		</div>
	</div>

	<div id="export-bar-area">
		<div id="export-bar">
			<div class="export-bar-inner pdl10 pdr10">
				<div  class="pdt5"></div>
				<table width="100%">
					<tr>
						<td width="42%">
							<div class="desc">
								<a href="#" onclick="set_default_stock_check();">
									<span style="font-weight:normal;color:#0082ec;">재고에 따른 '출고완료'처리 설정 ></span>
								</a>
								&nbsp;
								<span class="desc">
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
								<label><input type="checkbox" name="allcheck" value="1" onclick="check_all(this);check_bg();" <?php if($_GET["seq"][ 0]){?>checked="checked"<?php }?> /> 전체</label>
								&nbsp;<img src="/admin/skin/default/images/common/btn_print_m_odr.gif"  onclick="order_print();" class="hand" align="absmiddle" />
								&nbsp;<img src="/admin/skin/default/images/common/btn_print_m_rls.gif"  onclick="export_print();" class="hand" align="absmiddle" />
							</div>
						</td>
						<td align="center" width="16%">

<?php if($_GET["status"]=='45'){?>
							<div align="center">
								<div><span class="btn large cyanblue" ><button type="button" id="goods_export" style="width:150px;" onclick="export_popup();">
						일괄 출고완료 처리>
						</button></span></div>
							</div>
<?php }elseif($_GET["status"]=='55'){?>
<?php if($TPL_VAR["hasMarketOrders"]==true){?>
							<span class="btn large cyanblue" >
							<button type="button" id="goods_export" onclick="export_sumit_for_status55('55');">일괄 마켓 송장 전송</button>
						</span>
<?php }else{?>
							<div onmouseover="on_delivery_layer(this)" onmouseout="out_delivery_layer(this)" style="width:100px;">
								<span class="btn large cyanblue"><button type="button">일괄 출고상태 변경▼</button></span>
								<div class="relative hide">
									<div class="absolute" style="background-color:#fff;text-align:left;">
										<div class="pdt5"></div>
										<span class="btn large cyanblue" >
															<button type="button" id="goods_export" onclick="export_sumit_for_status55('55');">일괄 배송중 처리></button>
													</span>
										<div class="pdt5"></div>
										<span class="btn large cyanblue" >
															<button type="button" id="goods_export" onclick="export_sumit_for_status55('65');">일괄 배송완료 처리></button>
													</span>
									</div>
								</div>
							</div>
<?php }?>
<?php }elseif($_GET["status"]=='65'){?>
							<div align="center">
								<div>
						<span class="btn large cyanblue" ><button type="button" id="goods_export" style="width:150px;" onclick="export_sumit();">
						일괄 배송완료 처리>
						</button></span>
								</div>
							</div>
<?php }?>
						</td>
						<td width="42%" class="right">
						<span class="btn large cyanblue" ><button type="button" id="goods_export" style="width:150px;" onclick="export_sumit_for_status55('75');">
						↓아래 출고정보저장
						</button></span>
						</td>
					</tr>
				</table>
				<div style="height:1px;border-top:1px solid #e1e1e1; margin-top:10px;"></div>
			</div>
		</div>
	</div>

	<div tabindex="-1" id="export_layer" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable" style="outline: 0px; left: 13%; top: 30%; width: 930px; height: auto; display: block; position: absolute; z-index: 10002;">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
			<span class="ui-dialog-title" id="ui-dialog-title-export_layer">일괄출고처리</span>
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
						실물 :
						<input type="hidden" name="stockable" id="export_stockable" value="<?php echo $TPL_VAR["data_present_provider"]["default_export_stock_check"]?>">
<?php if($TPL_VAR["data_present_provider"]["default_export_stock_check"]=='limit'){?>
						출고되는 모든 실물의 재고가 있으면
<?php }elseif($TPL_VAR["data_present_provider"]["default_export_stock_check"]=='unlimit'){?>
						출고되는 모든 실물의 재고가 부족해도
<?php }?>
						→ 재고 차감 → (설정 시) SMS/EMAIL 발송 → 	출고완료로 상태 처리
					</td>
				</tr>
			</table>
			<div class="center pdt10">
				<span class="btn large cyanblue" ><button type="button" id="goods_export" style="width:70px;" onclick="export_sumit();">처 리</button></span>
			</div>
		</div>
	</div>
	<script>
		$("#export_layer").hide();
	</script>

<?php if($TPL_VAR["data_page"]["totalpage"]> 1){?>
	<div class="paging_navigation" style="margin:auto;">
		<?php echo $TPL_VAR["data_page"]["html"]?>

	</div>
<?php }?>
	<div class="pdl10 pdr10">
<?php if($TPL_VAR["gf_config"]["goodsflow_step"]=='1'&&$TPL_VAR["batch_goodsflow"]){?>
		<div class="right pdt5">
			<span class="btn small cyanblue" ><button type="button" onclick="gf_invoice_call('all');">(굿)일괄운송장받기/출력</button></span>
		</div>
<?php }?>

<?php if($TPL_data_export_1){$TPL_I1=-1;foreach($TPL_VAR["data_export"] as $TPL_V1){$TPL_I1++;?>
		<div class="pd5"></div>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_I2== 0){?>
		<!--// top_orderinfo_barcode START -->
		<div class="top_orderinfo_barcode">
			<!-- 주문정보 및 바코드 -->
			<table width="100%" border="0" style="table-layout: fixed">
				<tr>
					<td width="20%">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td rowspan="2" width="35">
<?php if($TPL_V2["goods_kind"]=='goods'){?>
<?php if($TPL_VAR["hasMarketOrders"]==false&&$TPL_V2["export_status"]!='y'){?>
									<input type="checkbox" name="export_code[]" disabled="disabled" />
<?php }else{?>
									<input type="checkbox" name="export_code[]" class="check_export_code" value="<?php echo $TPL_V2["export_code"]?>" order_seq="<?php echo $TPL_V2["order_seq"]?>" <?php if($_GET["seq"]){?>checked="checked"<?php }?> onclick="check_bg();"/>
									<input type="hidden" name="shipping_provider_seq[<?php echo $TPL_V2["export_code"]?>]" value="<?php echo $TPL_V2["shipping_provider_seq"]?>" />
<?php }?>
<?php }else{?>
									<input type="checkbox" name="export_code[]" disabled="disabled" />
<?php }?>
									<?php echo $TPL_V2["num"]?>.
								</td>
								<td >
									<table cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td>
<?php if($TPL_V2["is_bundle_export"]=='Y'){?>
<?php if(is_array($TPL_R3=$TPL_V2["bundle_order_list"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
												<a href="../order/view?no=<?php echo $TPL_V3?>" target="_blank"><span class="blue"><?php echo $TPL_V3?></span></a>
												<a href="javascript:printOrderView('<?php echo $TPL_V3?>', 'batch_status')"><span class="icon-print-order"></span></a>
<?php }}?>
<?php }else{?>
												<a href="../order/view?no=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><span class="blue"><?php echo $TPL_V2["order_seq"]?></span></a>
												<a href="javascript:printOrderView('<?php echo $TPL_V2["order_seq"]?>', 'batch_status')"><span class="icon-print-order"></span></a>
<?php }?>
											</td>
										</tr>
<?php if(($TPL_VAR["npay_use"]&&$TPL_V2["npay_order_id"])||$TPL_V2["linkage_id"]=='connector'){?>
										<tr>
<?php if($TPL_V2["linkage_id"]=='connector'){?>
											<td><div class="ngreen"><span class="bold"><?php echo $TPL_V2["linkage_mall_order_id"]?></span> (<?php echo $TPL_V2["linkage_mallname_text"]?>)</div></td>
<?php }else{?>
											<td><div class="ngreen"><span class="bold"><?php echo $TPL_V2["npay_order_id"]?></span> (Npay주문번호)</div></td>
<?php }?>
										</tr>
<?php }?>
										<tr>
											<td>
												<a href="../export/view?no=<?php echo $TPL_V2["export_code"]?>" target="_blank"><span class="blue"><?php echo $TPL_V2["export_code"]?></span></a>
												<a href="javascript:printExportView('<?php echo $TPL_V2["order_seq"]?>','<?php echo $TPL_V2["export_code"]?>', 'batch_status')"><span class="icon-print-export"></span></a>
												<div class="bold">
<?php if($TPL_V2["mall_name"]){?><?php echo $TPL_V2["mall_name"]?> →<?php }?>
<?php if($TPL_V2["provider_seq"]==$TPL_V2["shipping_provider_seq"]){?>
													<?php echo $TPL_V2["provider_name"]?>

<?php }else{?>
													본사
<?php }?>
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>

						</table>
					</td>
					<td align="left">
						<div class="desc" style="color:#000;">
							<table class="rec-info">
								<tr>
									<td rowspan="2" align="right">
<?php if($TPL_V2["member_seq"]){?>
										<a href="../member/detail?member_seq=<?php echo $TPL_V2["member_seq"]?>" target="_blank"><span class="member"><?php echo $TPL_V2["order_user_name"]?></span></a>
<?php }else{?>
										<span class="nomember"><?php echo $TPL_V2["order_user_name"]?></span>
<?php }?>
<?php if($TPL_V2["order_user_name"]!=$TPL_V2["recipient_user_name"]){?>
										<img src="/admin/skin/default/images/common/order_arrow.png" / >
										<span class="nomember"><?php echo $TPL_V2["recipient_user_name"]?></span>
<?php }?>
									</td>
									<td width="25"></td>
									<td>
<?php if($TPL_V2["domestic_shipping_method"]&&$TPL_V2["domestic_shipping_method"]!='coupon'){?>
										<span class="addr">
									<?php echo $TPL_V2["recipient_zipcode"]?>)
<?php if($TPL_V2["recipient_address_type"]=="street"){?>
									<?php echo $TPL_V2["recipient_address_street"]?>

<?php }else{?>
									<?php echo $TPL_V2["recipient_address"]?>

<?php }?>
									<?php echo $TPL_V2["recipient_address_detail"]?>

								</span>
<?php }else{?>
										<span class="tel"><?php echo $TPL_V2["recipient_email"]?>&nbsp;|&nbsp;</span>
										<span class="tel"><?php echo $TPL_V2["recipient_cellphone"]?></span>
										<span class="memo"><?php echo $TPL_V2["memo"]?></span>
<?php }?>
									</td>
								</tr>
<?php if($TPL_V2["domestic_shipping_method"]&&$TPL_V2["domestic_shipping_method"]!='coupon'){?>
								<tr>
									<td></td>
									<td>
										<span class="tel" style="font-size:11px;"><?php echo $TPL_V2["recipient_phone"]?></span>
<?php if($TPL_V2["recipient_phone"]&&$TPL_V2["recipient_cellphone"]){?>
										<span class="separator">|</span>
<?php }?>
										<span class="tel"><?php echo $TPL_V2["recipient_cellphone"]?></span>
<?php if($TPL_V2["recipient_cellphone"]&&$TPL_V2["memo"]){?>
										<span class="separator">|</span>
<?php }?>
										<span class="memo"><?php echo $TPL_V2["memo"]?></span>
									</td>
								</tr>
<?php }?>
							</table>
						</div>
					</td>
					<td width="30">
						<span class="btn-direct-open <?php if($TPL_VAR["data_search_default"]["export_detail_view"]!='close'){?>opened<?php }?>" onclick="btn_export_toggle(this);"><span class="hide">열기</span></span>
					</td>
					<td width="25%" class="left">
<?php if($TPL_V2["goods_kind"]=='goods'&&$TPL_V2["status"]<'55'){?>
						<input type="text" name="barcode[<?php echo $TPL_V2["export_code"]?>]" class="barcode" style="width:100%;" value="" title="피킹(picking)한 상품의 바코드(상품코드)를 스캔→검수" onkeydown="check_barcode(this)" tabindex="<?php echo $TPL_V2["num"]?>" <?php if($TPL_VAR["data_search_default"]["export_detail_view"]=='close'){?>disabled="disabled"<?php }?> />
<?php }?>
					</td>
					<td width="8%" align="right">
<?php if($_GET["status"]<'75'&&$TPL_V2["goods_kind"]=='goods'){?>
<?php if($_GET["status"]=='45'){?>
						<span class="btn small cyanblue" >
							<button type="button" id="goods_export" onclick="export_each_popup('<?php echo $TPL_V2["export_code"]?>');">출고 처리></button>
						</span>
<?php }elseif($_GET["status"]=='55'){?>
<?php if($TPL_VAR["hasMarketOrders"]==true){?>
						<span class="btn small cyanblue" >
                                                            <button type="button" id="goods_export" onclick="export_each_submit_for_status55('<?php echo $TPL_V2["export_code"]?>','55');">마켓 송장 전송</button>
                                                    </span>
<?php }else{?>
<?php if($TPL_VAR["hasMarketOrders"]==false){?>
<?php }else{?>
						<div onmouseover="on_delivery_layer(this)" onmouseout="out_delivery_layer(this)">
							<span class="btn small cyanblue"><button type="button">출고상태 변경▼</button></span>
							<div class="relative hide">
								<div class="absolute left pdl10" style="background-color:#fff;">
									<div class="pdt5"></div>
									<span class="btn small cyanblue" >
                                                                                        <button type="button" id="goods_export" onclick="export_each_submit_for_status55('<?php echo $TPL_V2["export_code"]?>','55');">배송중 처리></button>
                                                                                </span>
									<div class="pdt5"></div>
									<span class="btn small cyanblue" >
                                                                                        <button type="button" id="goods_export" onclick="export_each_submit_for_status55('<?php echo $TPL_V2["export_code"]?>','65');">배송완료 처리></button>
                                                                                </span>
								</div>
							</div>
						</div>
<?php }?>
<?php }?>
<?php }elseif($_GET["status"]=='65'){?>
						<span class="btn small cyanblue" >
							<button type="button" id="goods_export" onclick="export_each_submit('<?php echo $TPL_V2["export_code"]?>');">배송완료 처리></button>
						</span>
<?php }?>
<?php }?>
					</td>
			</table>
		</div>
		<!--// top_orderinfo_barcode END -->

		<!--// TITLE START -->
		<table class="simplelist-table-style table-export-info" width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout: fixed">
			<colgroup>
				<col /><!-- 주문상품 -->
				<col width="10%"/><!-- 재고/가용 -->
				<col width="5%"/><!-- 주문 -->
				<col width="5%"/><!-- 취소 -->
				<col width="5%"/><!-- 보낸수량 -->
				<col width="5%"/><!-- 남은수량 -->
				<col width="5%"/><!-- 공백 -->
				<col width="5%"/><!-- 출고수량 -->
				<col width="5%"/><!-- 검수 -->
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
				<th>출고수량</th>
				<th>검수</th>
				<th>받는방법</th>
			</tr>
			</thead>
			<tbody>
<?php }?>

			<!-- 닫힘상태의 정보 시작 -->
			<tr class="close-tr">
				<td class="info option">
					<table class="list-goods-info">
						<tr>
							<td width="50"><span class="order-item-image"><img src="<?php echo $TPL_V2["image"]?>" class="small_goods_image" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif';" /></span></td>
							<td>
								<div class="goods_name">
<?php if($TPL_VAR["npay_use"]&&$TPL_V2["npay_product_order_id"]){?><div class="ngray"><span class="bold"><?php echo $TPL_V2["npay_product_order_id"]?></span> (Npay상품주문번호)</div><?php }?>
									<span class="goods_name1" style="width:100%;color:#000000;">
<?php if($TPL_V2["goods_type"]=='gift'){?>
								<img src="/admin/skin/default/images/common/icon_gift.gif" />
<?php }?>
<?php if($TPL_V2["cancel_type"]=='1'){?>
								<span class="order-item-cancel-type " >[청약철회불가]</span><br/>
<?php }?>
<?php if($TPL_V2["provider_seq"]!=$TPL_V2["shipping_provider_seq"]&&$TPL_V2["shipping_provider_seq"]){?>
								<span style="color:#ff0000;font-size:11px;">위탁배송:본사</span>
<?php }?>
								<?php echo $TPL_V2["goods_name"]?>

<?php if($TPL_V2["rowspan"]> 1){?>
									<cite class="red">외 <?php echo ($TPL_V2["rowspan"]- 1)?>건<cite>
<?php }?>
							</span>
								</div>
<?php if($TPL_V2["option1"]!=null){?>
								<div class="goods_option">
									<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php if($TPL_V2["option1"]!=null){?><?php if($TPL_V2["title1"]){?><?php echo $TPL_V2["title1"]?>:<?php }?><?php echo $TPL_V2["option1"]?><?php }?>
<?php if($TPL_V2["option2"]!=null){?><?php if($TPL_V2["title2"]){?><?php echo $TPL_V2["title2"]?>:<?php }?><?php echo $TPL_V2["option2"]?><?php }?>
<?php if($TPL_V2["option3"]!=null){?><?php if($TPL_V2["title3"]){?><?php echo $TPL_V2["title3"]?>:<?php }?><?php echo $TPL_V2["option3"]?><?php }?>
<?php if($TPL_V2["option4"]!=null){?><?php if($TPL_V2["title4"]){?><?php echo $TPL_V2["title4"]?>:<?php }?><?php echo $TPL_V2["option4"]?><?php }?>
<?php if($TPL_V2["option5"]!=null){?><?php if($TPL_V2["title5"]){?><?php echo $TPL_V2["title5"]?>:<?php }?><?php echo $TPL_V2["option5"]?><?php }?>
								</div>
<?php }?>
<?php if($TPL_V2["opt_goods_code"]){?>
								<div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V2["opt_goods_code"]?>]</div>
<?php }?>
<?php if(is_array($TPL_R3=$TPL_V2["subinputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V3["title"]){?><?php echo $TPL_V3["title"]?>:<?php }?>
<?php if($TPL_V3["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V3["value"]?>" target="actionFrame"><?php echo $TPL_V3["value"]?></a>
<?php }else{?><?php echo $TPL_V3["value"]?><?php }?>
								</div>
<?php }}?>
							</td>
						</tr>
					</table>
				</td>
				<td class="info option" align="center"><?php echo number_format($TPL_V2["tot_stock"])?></td>
				<td class="info option" align="center"><?php echo number_format($TPL_V2["tot_ea"])?></td>
				<td class="info option" align="center"><?php echo number_format($TPL_V2["tot_step85"])?></td>
				<td class="info option" align="center"><?php echo number_format($TPL_V2["tot_sended_ea"])?></td>
				<td class="info option" align="center"><?php echo number_format($TPL_V2["tot_request_ea"])?></td>
				<td class="null" align="center">→</td>
				<td class="info option" align="center"><?php echo number_format($TPL_V2["tot_export_ea"])?></td>
				<td class="info option" align="center">-</td>

				<td class="info option delivery-info" align="center"><!-- // 배송방법 정보 -->
<?php if($TPL_VAR["data_search_default"]["export_detail_view"]=='close'){?>
					<table border="0" cellpadding="0" cellspacing="0" class="inner-table shipping_info_<?php echo $TPL_V2["export_code"]?>" width="100%">
						<tr>
							<td class="info pdl5" valign="top" width="100%">
<?php if(preg_match('/coupon/',$TPL_V2["shipping_method"])){?>
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<col width="40%" />
									<col width="40%" />
									<col width="20%" />
									<tr>
										<td><?php if($TPL_V2["mail_send_log"][ 0]["status"]!='y'){?><s><?php echo $TPL_V2["recipient_email"]?></s><?php }else{?><?php echo $TPL_V2["recipient_email"]?><?php }?></td><td><span class="desc"><?php echo $TPL_V2["couponinfo"]["coupon_serial"]?> (<?php echo $TPL_V2["couponinfo"]["couponNum"]?>)</span></td>
										<td rowspan="2" align="center">
											<span class="coupon_remain_value red"><?php echo str_replace('잔여:','잔여<br/>',$TPL_V2["couponinfo"]["coupon_remain"])?></span>
											<br/><span class="btn"><img src="/admin/skin/default/images/common/btn_ok_use.gif" class="excoupon_use_btn" order_seq="<?php echo $TPL_V2["order_seq"]?>" onclick="excoupon_use_btn(this)" /></span>
										</td>
									</tr>
									<tr>
										<td><?php if($TPL_V2["sms_send_log"][ 0]["status"]!='y'){?><s><?php echo $TPL_V2["recipient_cellphone"]?></s><?php }else{?><?php echo $TPL_V2["recipient_cellphone"]?><?php }?></td><td><?php echo $TPL_V2["mstatus_arr"][ 1]?></td>
									</tr>
								</table>
<?php }else{?>
								<!-- 배송 정보 :: START -->
								<input type="hidden" name="export_shipping_group[<?php echo $TPL_V2["export_code"]?>]" class="export_shipping_group" value="<?php echo $TPL_V2["shipping_group"]?>" />
								<input type="hidden" id="export_shipping_method_<?php echo $TPL_V2["export_code"]?>" name="export_shipping_method[<?php echo $TPL_V2["export_code"]?>]" class="export_shipping_method" value="<?php echo $TPL_V2["shipping_method"]?>" />
								<input type="hidden" name="export_shipping_set_name[<?php echo $TPL_V2["export_code"]?>]" class="export_shipping_set_name" value="<?php echo $TPL_V2["shipping_set_name"]?>" />
								<div><?php echo $TPL_V2["provider_name"]?></div>
								<div class="blue">
<?php if($TPL_V2["pg"]=='talkbuy'){?>
									<span class="hand shipping_set_name_<?php echo $TPL_V2["export_code"]?>" onclick='openDialog("카카오페이 구매", "talkbuy_delivary_dialog", {"width":"450","height":"150"});'><?php echo $TPL_V2["shipping_set_name"]?></span>
<?php }else{?>
									<span class="hand shipping_set_name_<?php echo $TPL_V2["export_code"]?>" onclick="ship_chg_popup('<?php echo $TPL_V2["export_code"]?>','export','after');"><?php echo $TPL_V2["shipping_set_name"]?></span>
<?php }?>

									<!-- 택배사선택 :: START -->
									<div class="delivery_lay <?php if(!preg_match('/delivery|postpaid/',$TPL_V2["shipping_method"])){?>hide<?php }?>">
<?php if($TPL_V2["delivery_company_array"]){?>
										<select name="delivery_company[<?php echo $TPL_V2["export_code"]?>]" class="deliveryCompany" onchange="check_deliveryCompany('<?php echo $TPL_V2["export_code"]?>');" style="width:85px;">
<?php if(is_array($TPL_R3=$TPL_V2["delivery_company_array"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
<?php if(preg_match('/auto/',$TPL_K3)){?>
											<!--{ * ? ..linkage_id == 'connector' && hasMarketOrders == false //#23611 ycg 2019-02-07 shoplinker n goodsflow linkage * }-->
											<option value="<?php echo $TPL_K3?>" url="<?php echo $TPL_V3["url"]?>" style="background-color:yellow" <?php if($TPL_V2["delivery_company_code"]==$TPL_K3){?>selected<?php }?>><?php echo $TPL_V3["company"]?></option>
											<!--{ * / //#23611 ycg 2019-02-07 shoplinker n goodsflow linkage * }-->
<?php }else{?>
											<option value="<?php echo $TPL_K3?>" url="<?php echo $TPL_V3["url"]?>" style="background-color:#ffffff" <?php if($TPL_V2["delivery_company_code"]==$TPL_K3){?>selected<?php }?>><?php echo $TPL_V3["company"]?></option>
<?php }?>
<?php }}?>
										</select>
<?php }?>
										<input type="text" size="10" name="delivery_number[<?php echo $TPL_V2["export_code"]?>]" class="line delivery_number" value="<?php echo $TPL_V2["delivery_number"]?>" />
<?php if($_GET["status"]>='55'){?>
										<span class="btn small cyanblue" >
								<button type="button" onclick="invoice_link('<?php echo $TPL_V2["export_code"]?>');">조회</button>
							</span>
<?php }?>
<?php if($TPL_V2["delivery_number"]&&($TPL_V2["shipping_provider_seq"]==$TPL_VAR["gf_config"]["provider_seq"])){?>
										<span class="btn small red gf_btn_area"><button type="button" onclick="reset_delnumber('<?php echo $TPL_V2["export_code"]?>');">초기화</button></span></span>
<?php }?>
									</div>
									<!-- 택배사선택 :: END -->
									<!-- 매장선택 :: START -->
									<div class="store_lay <?php if($TPL_V2["shipping_method"]!='direct_store'){?>hide<?php }?>">
										<input type="hidden" class="store_scm_type_<?php echo $TPL_V2["export_code"]?>" name="export_store_scm_type[<?php echo $TPL_V2["export_code"]?>]" value="<?php echo $TPL_V2["store_scm_type"]?>" />
										<select name="export_address_seq[<?php echo $TPL_V2["export_code"]?>]" onchange="store_set(this, '<?php echo $TPL_V2["export_code"]?>');">
<?php if(is_array($TPL_R3=$TPL_V2["shipping_store_info"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
											<option value="<?php echo $TPL_V3["shipping_address_seq"]?>" scm_type="<?php echo $TPL_V3["store_scm_type"]?>" <?php if($TPL_V3["shipping_address_seq"]==$TPL_V2["shipping_address_seq"]){?>selected<?php }?>><?php echo $TPL_V3["shipping_store_name"]?></option>
<?php }}?>
										</select>
									</div>
									<!-- 매장선택 :: END -->
									<!-- 출고지 정보 :: START -->
									<div class="address_lay <?php if($TPL_V2["shipping_method"]=='direct_store'){?>hide<?php }?>">
										<span class="hand" onclick="address_pop('<?php echo $TPL_V2["sending_address"]['address_category']?>','<?php echo $TPL_V2["sending_address"]['address_name']?>','<?php echo $TPL_V2["sending_address"]['view_address']?>','<?php echo $TPL_V2["sending_address"]['shipping_phone']?>');"><?php echo $TPL_V2["sending_address"]['address_name']?></span>
									</div>
									<!-- 출고지 정보 :: END -->
									<script>check_deliveryCompany('<?php echo $TPL_V2["export_code"]?>');</script>
<?php }?>
							</td>
						</tr>
<?php if($TPL_VAR["gf_config"]["goodsflow_step"]=='1'&&$TPL_VAR["gf_config"]["gf_use"]=='Y'){?>
						<tr class="gf_btn_area <?php if($TPL_V2["shipping_provider_seq"]!=$TPL_VAR["gf_config"]["provider_seq"]||$TPL_VAR["gf_config"]["gf_deliveryCode"]!=$TPL_V2["delivery_company_code"]||!preg_match('/delivery|postpaid/',$TPL_V2["shipping_method"])){?>hide<?php }?>">
							<td class="info pdl5">
								<!-- <span class="btn small gray" >
                                    <button type="button" onclick="alert('오픈마켓 주문건은 굿스플로 서비스를 이용할 수 없습니다.');">(굿)운송장받기/출력</button>
                                </span> -->
								<span class="btn small cyanblue" >
							<button type="button" onclick="gf_invoice_call('<?php echo $TPL_V2["export_code"]?>');">(굿)운송장받기/출력</button>
						</span>
							</td>
						</tr>
<?php }?>
					</table>
<?php }?>

				</td>
			</tr>
			<!-- 닫힘상태의 정보 끝 -->

<?php }?>

<?php if($TPL_V2["option_seq"]||($TPL_V2["suboption_seq"]&&$TPL_I2== 0)){?>
			<tr class="open-tr">
				<td class="info option">
					<table class="list-goods-info">
						<tr>
							<td width="50"><span class="order-item-image"><img src="<?php echo $TPL_V2["image"]?>" class="small_goods_image" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif';" /></span></td>
							<td>
								<div class="goods_name">
<?php if($TPL_VAR["npay_use"]&&$TPL_V2["npay_product_order_id"]){?><?php echo $TPL_V2["npay_product_order_id"]?><div class="ngray"> (Npay상품주문번호)<span class="bold"></span></div><?php }?>
									<span class="goods_name1" style="width:100%;color:#000000;">
<?php if($TPL_V2["goods_type"]=='gift'){?>
								<img src="/admin/skin/default/images/common/icon_gift.gif" />
<?php }?>
<?php if($TPL_V2["cancel_type"]=='1'){?>
								<span class="order-item-cancel-type " >[청약철회불가]</span><br/>
<?php }?>
<?php if($TPL_V2["provider_seq"]!=$TPL_V2["shipping_provider_seq"]&&$TPL_V2["shipping_provider_seq"]){?>
								<span style="color:#ff0000;font-size:11px;">위탁배송:본사</span>
<?php }?>
								<?php echo $TPL_V2["goods_name"]?>

							</span>
								</div>
<?php if($TPL_V2["option1"]!=null){?>
								<div class="goods_option">
									<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php if($TPL_V2["option1"]!=null){?><?php if($TPL_V2["title1"]){?><?php echo $TPL_V2["title1"]?>:<?php }?><?php echo $TPL_V2["option1"]?><?php }?>
<?php if($TPL_V2["option2"]!=null){?><?php if($TPL_V2["title2"]){?><?php echo $TPL_V2["title2"]?>:<?php }?><?php echo $TPL_V2["option2"]?><?php }?>
<?php if($TPL_V2["option3"]!=null){?><?php if($TPL_V2["title3"]){?><?php echo $TPL_V2["title3"]?>:<?php }?><?php echo $TPL_V2["option3"]?><?php }?>
<?php if($TPL_V2["option4"]!=null){?><?php if($TPL_V2["title4"]){?><?php echo $TPL_V2["title4"]?>:<?php }?><?php echo $TPL_V2["option4"]?><?php }?>
<?php if($TPL_V2["option5"]!=null){?><?php if($TPL_V2["title5"]){?><?php echo $TPL_V2["title5"]?>:<?php }?><?php echo $TPL_V2["option5"]?><?php }?>
								</div>
<?php }?>
<?php if(is_array($TPL_R3=$TPL_V2["subinputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V3["title"]){?><?php echo $TPL_V3["title"]?>:<?php }?>
<?php if($TPL_V3["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V3["value"]?>" target="actionFrame"><?php echo $TPL_V3["value"]?></a>
<?php }else{?><?php echo $TPL_V3["value"]?><?php }?>
								</div>
<?php }}?>

								<div class="warehouse-info-lay">
									<ul>
										<li class="wh_info"></li>
										<li>상품코드 : <?php echo $TPL_V2["opt_goods_code"]?></li>
									</ul>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<td class="info option" align="center">
<?php if($TPL_V2["option_seq"]){?>
<?php if($TPL_V2["package_yn"]=='y'){?>
					실제상품▼
<?php }else{?>
					<?php echo number_format($TPL_V2["stock"])?>

<?php }?>
<?php }else{?>
					-
<?php }?>
				</td>
				<td class="info option" align="center">
<?php if($TPL_V2["option_seq"]){?>
<?php if($TPL_V2["package_yn"]=='y'){?>[<?php }?><span class="ea"><?php echo $TPL_V2["opt_ea"]?></span><?php if($TPL_V2["package_yn"]=='y'){?>]<?php }?>
<?php }else{?>
					-
<?php }?>
				</td>
				<td class="info option" align="center">
<?php if($TPL_V2["option_seq"]){?>
<?php if($TPL_V2["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V2["opt_step85"]?><?php if($TPL_V2["package_yn"]=='y'){?>]<?php }?>
<?php }else{?>
					-
<?php }?>
				</td>
				<td class="info option" align="center">
<?php if($TPL_V2["option_seq"]){?>
<?php if($TPL_V2["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V2["opt_step45"]+$TPL_V2["opt_step55"]+$TPL_V2["opt_step65"]+$TPL_V2["opt_step75"]?><?php if($TPL_V2["package_yn"]=='y'){?>]<?php }?>
<?php }else{?>
					-
<?php }?>
				</td>
				<td class="info option" align="center">
<?php if($TPL_V2["option_seq"]){?>
<?php if($TPL_V2["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V2["opt_ea"]-$TPL_V2["opt_step45"]-$TPL_V2["opt_step55"]-$TPL_V2["opt_step65"]-$TPL_V2["opt_step75"]-$TPL_V2["opt_step85"]?><?php if($TPL_V2["package_yn"]=='y'){?>]<?php }?>
<?php }else{?>
					-
<?php }?></td>
				<td class="null" align="center">→</td>
				<td class="info option" align="center" >
					<?php echo $TPL_V2["ea"]?>

					<input type="hidden" name="request_ea[<?php echo $TPL_V2["export_code"]?>][<?php echo $TPL_V2["bar_goods_code"]?>]" class="line export_ea"  style="text-align:right" size="2" value="<?php echo $TPL_V2["ea"]?>" onkeydown="reset_barcode_ea(this);">
				</td>
<?php if($TPL_V2["goods_kind"]=='goods'){?>
				<td class="info option" align="center">
<?php if($TPL_V2["option_seq"]&&$TPL_V2["status"]< 55){?>
					<span>대기</span>
					<input type="text" name="barcode_ea[<?php echo $TPL_V2["export_code"]?>][<?php echo $TPL_V2["bar_goods_code"]?>]" class="barcode_ea_<?php echo $TPL_V2["export_code"]?> barcode_ready" value="0" size="2" onblur="check_barcode_ea(this);" />
<?php }else{?>
					-
<?php }?>
				</td>
<?php }?>
<?php if($TPL_I2== 0){?>
				<td class="info option delivery-info" align="left" rowspan="<?php echo $TPL_V2["rowspan"]?>" <?php if($TPL_V2["goods_kind"]!='goods'){?>colspan="2"<?php }?>><!-- // 배송방법 정보 -->
<?php if($TPL_VAR["data_search_default"]["export_detail_view"]!='close'){?>
				<table border="0" cellpadding="0" cellspacing="0" class="inner-table shipping_info_<?php echo $TPL_V2["export_code"]?>" width="100%">
					<tr>
						<td class="info pdl5" valign="top" width="100%">

<?php if(preg_match('/coupon/',$TPL_V2["shipping_method"])){?>
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<col width="40%" />
								<col width="40%" />
								<col width="20%" />
								<tr>
									<td><?php if($TPL_V2["mail_send_log"][ 0]["status"]!='y'){?><s><?php echo $TPL_V2["recipient_email"]?></s><?php }else{?><?php echo $TPL_V2["recipient_email"]?><?php }?></td><td><span class="desc"><?php echo $TPL_V2["couponinfo"]["coupon_serial"]?> (<?php echo $TPL_V2["couponinfo"]["couponNum"]?>)</span></td>
									<td rowspan="2" align="center">
										<span class="coupon_remain_value red"><?php echo str_replace('잔여:','잔여<br/>',$TPL_V2["couponinfo"]["coupon_remain"])?></span>
										<br/><span class="btn"><img src="/admin/skin/default/images/common/btn_ok_use.gif" class="excoupon_use_btn" order_seq="<?php echo $TPL_V2["order_seq"]?>" onclick="excoupon_use_btn(this)" /></span>
									</td>
								</tr>
								<tr>
									<td><?php if($TPL_V2["sms_send_log"][ 0]["status"]!='y'){?><s><?php echo $TPL_V2["recipient_cellphone"]?></s><?php }else{?><?php echo $TPL_V2["recipient_cellphone"]?><?php }?></td><td><?php echo $TPL_V2["mstatus_arr"][ 1]?></td>
								</tr>
							</table>
<?php }else{?>
							<!-- 배송 정보 :: START -->
							<input type="hidden" name="export_shipping_group[<?php echo $TPL_V2["export_code"]?>]" class="export_shipping_group" value="<?php echo $TPL_V2["shipping_group"]?>" />
							<input type="hidden" id="export_shipping_method_<?php echo $TPL_V2["export_code"]?>" name="export_shipping_method[<?php echo $TPL_V2["export_code"]?>]" class="export_shipping_method" value="<?php echo $TPL_V2["shipping_method"]?>" />
							<input type="hidden" name="export_shipping_set_name[<?php echo $TPL_V2["export_code"]?>]" class="export_shipping_set_name" value="<?php echo $TPL_V2["shipping_set_name"]?>" />
							<div><?php echo $TPL_V2["provider_name"]?></div>
							<div class="blue">
								<span class="hand shipping_set_name_<?php echo $TPL_V2["export_code"]?>" onclick="ship_chg_popup('<?php echo $TPL_V2["export_code"]?>','export','after');"><?php echo $TPL_V2["shipping_set_name"]?></span>
							</div>

							<!-- 택배사선택 :: START -->
							<div class="delivery_lay <?php if(!preg_match('/delivery|postpaid/',$TPL_V2["shipping_method"])){?>hide<?php }?>">
<?php if($TPL_V2["delivery_company_array"]){?>
								<select name="delivery_company[<?php echo $TPL_V2["export_code"]?>]" class="deliveryCompany" onchange="check_deliveryCompany('<?php echo $TPL_V2["export_code"]?>');" style="width:85px;">
<?php if(is_array($TPL_R3=$TPL_V2["delivery_company_array"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
<?php if(preg_match('/auto/',$TPL_K3)){?>
									<option value="<?php echo $TPL_K3?>" url="<?php echo $TPL_V3["url"]?>" style="background-color:yellow" <?php if($TPL_V2["delivery_company_code"]==$TPL_K3){?>selected<?php }?>><?php echo $TPL_V3["company"]?></option>
<?php }else{?>
									<option value="<?php echo $TPL_K3?>" url="<?php echo $TPL_V3["url"]?>" style="background-color:#ffffff" <?php if($TPL_V2["delivery_company_code"]==$TPL_K3){?>selected<?php }?>><?php echo $TPL_V3["company"]?></option>
<?php }?>
<?php }}?>
								</select>
<?php }?>
								<input type="text" size="10" name="delivery_number[<?php echo $TPL_V2["export_code"]?>]" class="line delivery_number" value="<?php echo $TPL_V2["delivery_number"]?>" />
<?php if($_GET["status"]>='55'){?>
								<span class="btn small cyanblue" >
								<button type="button" onclick="invoice_link('<?php echo $TPL_V2["export_code"]?>');">조회</button>
							</span>
<?php }?>
<?php if($TPL_V2["delivery_number"]&&($TPL_V2["shipping_provider_seq"]==$TPL_VAR["gf_config"]["provider_seq"])){?>
								<span class="btn small red gf_btn_area"><button type="button" onclick="reset_delnumber('<?php echo $TPL_V2["export_code"]?>');">초기화</button></span></span>
<?php }?>
							</div>
							<!-- 택배사선택 :: END -->
							<!-- 매장선택 :: START -->
							<div class="store_lay <?php if($TPL_V2["shipping_method"]!='direct_store'){?>hide<?php }?>">
								<input type="hidden" class="store_scm_type_<?php echo $TPL_V2["export_code"]?>" name="export_store_scm_type[<?php echo $TPL_V2["export_code"]?>]" value="<?php echo $TPL_V2["store_scm_type"]?>" />
								<select name="export_address_seq[<?php echo $TPL_V2["export_code"]?>]" onchange="store_set(this, '<?php echo $TPL_V2["export_code"]?>');">
<?php if(is_array($TPL_R3=$TPL_V2["shipping_store_info"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
									<option value="<?php echo $TPL_V3["shipping_address_seq"]?>" scm_type="<?php echo $TPL_V3["store_scm_type"]?>" <?php if($TPL_V3["shipping_address_seq"]==$TPL_V2["shipping_address_seq"]){?>selected<?php }?>><?php echo $TPL_V3["shipping_store_name"]?></option>
<?php }}?>
								</select>
							</div>
							<!-- 매장선택 :: END -->
							<!-- 출고지 정보 :: START -->
							<div class="address_lay <?php if($TPL_V2["shipping_method"]=='direct_store'){?>hide<?php }?>">
								<span class="hand" onclick="address_pop('<?php echo $TPL_V2["sending_address"]['address_category']?>','<?php echo $TPL_V2["sending_address"]['address_name']?>','<?php echo $TPL_V2["sending_address"]['view_address']?>','<?php echo $TPL_V2["sending_address"]['shipping_phone']?>');"><?php echo $TPL_V2["sending_address"]['address_name']?></span>
							</div>
							<!-- 출고지 정보 :: END -->
							<script>check_deliveryCompany('<?php echo $TPL_V2["export_code"]?>');</script>
<?php }?>
						</td>
					</tr>
<?php if($TPL_VAR["gf_config"]["goodsflow_step"]=='1'&&$TPL_VAR["gf_config"]["gf_use"]=='Y'){?>
					<tr class="gf_btn_area <?php if($TPL_V2["shipping_provider_seq"]!=$TPL_VAR["gf_config"]["provider_seq"]||$TPL_VAR["gf_config"]["gf_deliveryCode"]!=$TPL_V2["delivery_company_code"]||!preg_match('/delivery|postpaid/',$TPL_V2["shipping_method"])){?>hide<?php }?>">
						<td class="info pdl5">
							<!-- <span class="btn small gray" >
                                <button type="button" onclick="alert('오픈마켓 주문건은 굿스플로 서비스를 이용할 수 없습니다.');">(굿)운송장받기/출력</button>
                            </span> -->
							<span class="btn small cyanblue" >
							<button type="button" onclick="gf_invoice_call('<?php echo $TPL_V2["export_code"]?>');">(굿)운송장받기/출력</button>
						</span>
						</td>
					</tr>
<?php }?>
				</table>
<?php }?>
				</td>
<?php }?>
			</tr>
			<!-- 필수옵션 패키지 -->
<?php if(is_array($TPL_R3=$TPL_V2["packages"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
			<tr class="open-tr">
				<td class="info option">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_V2["shipping_provider_seq"]== 1){?>
					<input type="hidden" name="optioninfo[<?php echo $TPL_V2["export_code"]?>][option][<?php echo $TPL_V3["option_seq"]?>]" class="optioninfo" value="<?php echo $TPL_V3["goods_seq"]?>option<?php echo $TPL_V2["option_seq"]?>" />
					<input type="hidden" name="whSupplyPrice[<?php echo $TPL_V2["export_code"]?>][option][<?php echo $TPL_V3["option_seq"]?>]" class="wh_supply_price" value="<?php echo $TPL_V3["supply_price"]?>" />
					<input type="hidden" name="goodscode[<?php echo $TPL_V2["export_code"]?>][option][<?php echo $TPL_V3["option_seq"]?>]" value="<?php echo $TPL_V3["goods_code"]?>" />
<?php }?>
					<table class="list-goods-info" width="100%" border="0">
						<tr>
							<td valign="top" style="border:none;padding-left:60px;" width="15"><img src="/admin/skin/default/images/common/icon/ico_package.gif" border="0" /></td>
							<td width="50" style="padding-left:5px;">
						<span class="order-item-image">
							<img src="<?php echo $TPL_V3["image"]?>" class="small_goods_image" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif';" />
						</span>
							</td>
							<td>
								<div>
							<span class="red">
								[실제상품]
								<?php echo $TPL_V3["goods_name"]?>

							</span>
								</div>
<?php if($TPL_V3["option1"]){?>
								<div class="goods_option">
									<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php if($TPL_V3["option1"]){?><?php if($TPL_V3["title1"]){?><?php echo $TPL_V3["title1"]?>:<?php }?><?php echo $TPL_V3["option1"]?><?php }?>
<?php if($TPL_V3["option2"]){?><?php if($TPL_V3["title2"]){?><?php echo $TPL_V3["title2"]?>:<?php }?><?php echo $TPL_V3["option2"]?><?php }?>
<?php if($TPL_V3["option3"]){?><?php if($TPL_V3["title3"]){?><?php echo $TPL_V3["title3"]?>:<?php }?><?php echo $TPL_V3["option3"]?><?php }?>
<?php if($TPL_V3["option4"]){?><?php if($TPL_V3["title4"]){?><?php echo $TPL_V3["title4"]?>:<?php }?><?php echo $TPL_V3["option4"]?><?php }?>
<?php if($TPL_V3["option5"]){?><?php if($TPL_V3["title5"]){?><?php echo $TPL_V3["title5"]?>:<?php }?><?php echo $TPL_V3["option5"]?><?php }?>
								</div>
<?php }?>
<?php if(is_array($TPL_R4=$TPL_V3["subinputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V4["title"]){?><?php echo $TPL_V4["title"]?>:<?php }?>
<?php if($TPL_V4["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V4["value"]?>" target="actionFrame"><?php echo $TPL_V4["value"]?></a>
<?php }else{?><?php echo $TPL_V4["value"]?><?php }?>
								</div>
<?php }}?>
								<div class="warehouse-info-lay">
									<ul>
										<li class="wh_info"></li>
										<li>상품코드 : <?php echo $TPL_V3["goods_code"]?></li>
									</ul>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<td class="info option" align="center">
					<?php echo number_format($TPL_V3["stock"])?>

				</td>
				<td class="info option" align="center">
<?php if($TPL_V2["opt_ea"]){?>
					[<?php echo $TPL_V2["opt_ea"]?>]x<?php echo $TPL_V3["unit_ea"]?>=<span class="ea"><?php echo number_format($TPL_V2["opt_ea"]*$TPL_V3["unit_ea"])?></span>
<?php }else{?>
					0
<?php }?>
				</td>
				<td class="info option" align="center">
<?php if($TPL_V2["opt_step85"]){?>
					[<?php echo $TPL_V2["opt_step85"]?>]x<?php echo $TPL_V3["unit_ea"]?>=<span class="ea"><?php echo number_format($TPL_V2["opt_step85"]*$TPL_V3["unit_ea"])?></span>
<?php }else{?>
					0
<?php }?>
				</td>
				<td class="info option" align="center">
<?php if(($TPL_V2["opt_step45"]+$TPL_V2["opt_step55"]+$TPL_V2["opt_step65"]+$TPL_V2["opt_step75"])){?>
					[<?php echo ($TPL_V2["opt_step45"]+$TPL_V2["opt_step55"]+$TPL_V2["opt_step65"]+$TPL_V2["opt_step75"])?>]x<?php echo $TPL_V3["unit_ea"]?>=<span class="ea"><?php echo number_format(($TPL_V2["opt_step45"]+$TPL_V2["opt_step55"]+$TPL_V2["opt_step65"]+$TPL_V2["opt_step75"])*$TPL_V3["unit_ea"])?></span>
<?php }else{?>
					0
<?php }?>
				</td>
				<td class="info option" align="center">
<?php if(($TPL_V2["opt_ea"]-$TPL_V2["opt_step45"]-$TPL_V2["opt_step55"]-$TPL_V2["opt_step65"]-$TPL_V2["opt_step75"]-$TPL_V2["opt_step85"])){?>
					[<?php echo ($TPL_V2["opt_ea"]-$TPL_V2["opt_step45"]-$TPL_V2["opt_step55"]-$TPL_V2["opt_step65"]-$TPL_V2["opt_step75"]-$TPL_V2["opt_step85"])?>]x<?php echo $TPL_V3["unit_ea"]?>=<span class="ea"><?php echo number_format(($TPL_V2["opt_ea"]-$TPL_V2["opt_step45"]-$TPL_V2["opt_step55"]-$TPL_V2["opt_step65"]-$TPL_V2["opt_step75"]-$TPL_V2["opt_step85"])*$TPL_V3["unit_ea"])?></span>
<?php }else{?>
					0
<?php }?>
				</td>
				<td class="null" align="center">→</td>
				<td class="info option" align="center" >
					<?php echo number_format($TPL_V2["ea"]*$TPL_V3["unit_ea"])?>

					<span title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량" class="helpicon"></span>
				</td>
<?php if($TPL_V2["goods_kind"]=='goods'){?>
				<td class="info option" align="center">
<?php if($TPL_V2["option_seq"]&&$TPL_V2["status"]< 55){?>
					<span>대기</span>
<?php }else{?>
					-
<?php }?>
				</td>
<?php }?>
			</tr>
<?php }}?>
<?php }?>
<?php if($TPL_V2["suboption_seq"]){?>
			<tr class="open-tr">
				<td class="info suboption" style="padding-left:30px;">
<?php if($TPL_VAR["npay_use"]&&$TPL_V2["npay_product_order_id"]){?><div class="ngray"><?php echo $TPL_V2["npay_product_order_id"]?> (Npay상품주문번호)<span class="bold"></span></div><?php }?>
					<img src="/admin/skin/default/images/common/icon_add_arrow.gif" /><img src="/admin/skin/default/images/common/icon_add.gif" />
<?php if($TPL_V2["suboption"]){?><?php if($TPL_V2["subtitle"]){?><?php echo $TPL_V2["subtitle"]?>:<?php }?><?php echo $TPL_V2["suboption"]?><?php }?>
<?php if($TPL_V2["subopt_package_yn"]!='y'){?>
					<div class="warehouse-info-lay">
						<ul>
							<li class="wh_info"></li>
							<li>상품코드 : <?php echo $TPL_V2["subopt_goods_code"]?></li>
						</ul>
					</div>
<?php }?>
				</td>
				<td class="info suboption" align="center">
					<?php echo number_format($TPL_V2["stock"])?>

				</td>
				<td class="info suboption" align="center">
<?php if($TPL_V2["subopt_package_yn"]=='y'){?>[<?php }?><span class="ea"><?php echo $TPL_V2["subopt_ea"]?></span><?php if($TPL_V2["subopt_package_yn"]=='y'){?>]<?php }?>
				</td>
				<td class="info suboption" align="center">
<?php if($TPL_V2["subopt_package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V2["subopt_step85"]?><?php if($TPL_V2["subopt_package_yn"]=='y'){?>]<?php }?>
				</td>
				<td class="info suboption" align="center">
<?php if($TPL_V2["subopt_package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V2["subopt_step45"]+$TPL_V2["subopt_step55"]+$TPL_V2["subopt_step65"]+$TPL_V2["subopt_step75"]?><?php if($TPL_V2["subopt_package_yn"]=='y'){?>]<?php }?>
				</td>
				<td class="info suboption" align="center">
<?php if($TPL_V2["subopt_package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V2["subopt_ea"]-$TPL_V2["subopt_step45"]-$TPL_V2["subopt_step55"]-$TPL_V2["subopt_step65"]-$TPL_V2["subopt_step75"]-$TPL_V2["subopt_step85"]?><?php if($TPL_V2["subopt_package_yn"]=='y'){?>]<?php }?>
				</td>
				<td class="null" align="center">→</td>
				<td class="info suboption" align="center">
					<?php echo $TPL_V2["ea"]?>

					<input type="hidden" name="request_ea[<?php echo $TPL_V2["export_code"]?>][<?php echo $TPL_V2["bar_goods_code"]?>]" class="line export_ea"  style="text-align:right" size="2" value="<?php echo $TPL_V2["ea"]?>" onkeydown="reset_barcode_ea(this);">
				</td>
<?php if($TPL_V2["goods_kind"]=='goods'){?>
				<td class="info suboption" align="center">
<?php if($TPL_V2["status"]< 55){?>
					<span>대기</span>
					<input type="text" name="barcode_ea[<?php echo $TPL_V2["export_code"]?>][<?php echo $TPL_V2["bar_goods_code"]?>]" class="barcode_ea_<?php echo $TPL_V2["export_code"]?> barcode_ready" value="0" size="2" onblur="check_barcode_ea(this);" />
<?php }else{?>
					-
<?php }?>
				</td>
<?php }?>
			</tr>

			<!-- 추가옵션 패키지 -->
<?php if(is_array($TPL_R3=$TPL_V2["packages"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
			<tr class="open-tr">
				<td class="info option" style="padding-left:70px">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_V2["shipping_provider_seq"]== 1){?>
					<input type="hidden" name="optioninfo[<?php echo $TPL_V2["export_code"]?>][option][<?php echo $TPL_V3["option_seq"]?>]" class="optioninfo" value="<?php echo $TPL_V3["goods_seq"]?>option<?php echo $TPL_V3["option_seq"]?>" />
					<input type="hidden" name="whSupplyPrice[<?php echo $TPL_V2["export_code"]?>][option][<?php echo $TPL_V3["option_seq"]?>]" class="wh_supply_price" value="<?php echo $TPL_V3["supply_price"]?>" />
					<input type="hidden" name="goodscode[<?php echo $TPL_V2["export_code"]?>][option][<?php echo $TPL_V3["option_seq"]?>]" value="<?php echo $TPL_V3["goods_code"]?>" />
<?php }?>
					<table class="list-goods-info" width="100%">
						<tr>
							<td valign="top" style="border:none;" width="15"><img src="/admin/skin/default/images/common/icon/ico_package.gif" border="0" /></td>
							<td width="50" style="padding-left:5px;">
						<span class="order-item-image">
							<img src="<?php echo $TPL_V3["image"]?>" class="small_goods_image" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif';" />
						</span>
							</td>
							<td>
								<div>
							<span class="red">
								[실제상품]
								<?php echo $TPL_V3["goods_name"]?>

							</span>
								</div>
<?php if($TPL_V3["option1"]){?>
								<div class="goods_option">
									<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php if($TPL_V3["option1"]){?><?php if($TPL_V3["title1"]){?><?php echo $TPL_V3["title1"]?>:<?php }?><?php echo $TPL_V3["option1"]?><?php }?>
<?php if($TPL_V3["option2"]){?><?php if($TPL_V3["title2"]){?><?php echo $TPL_V3["title2"]?>:<?php }?><?php echo $TPL_V3["option2"]?><?php }?>
<?php if($TPL_V3["option3"]){?><?php if($TPL_V3["title3"]){?><?php echo $TPL_V3["title3"]?>:<?php }?><?php echo $TPL_V3["option3"]?><?php }?>
<?php if($TPL_V3["option4"]){?><?php if($TPL_V3["title4"]){?><?php echo $TPL_V3["title4"]?>:<?php }?><?php echo $TPL_V3["option4"]?><?php }?>
<?php if($TPL_V3["option5"]){?><?php if($TPL_V3["title5"]){?><?php echo $TPL_V3["title5"]?>:<?php }?><?php echo $TPL_V3["option5"]?><?php }?>
								</div>
<?php }?>
<?php if(is_array($TPL_R4=$TPL_V3["subinputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
								<div class="goods_input">
									<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V4["title"]){?><?php echo $TPL_V4["title"]?>:<?php }?>
<?php if($TPL_V4["type"]=='file'){?>
									<a href="../order_process/filedown?file=<?php echo $TPL_V4["value"]?>" target="actionFrame"><?php echo $TPL_V4["value"]?></a>
<?php }else{?><?php echo $TPL_V4["value"]?><?php }?>
								</div>
<?php }}?>
								<div class="warehouse-info-lay">
									<ul>
										<li class="wh_info"></li>
										<li>상품코드 : <?php echo $TPL_V3["goods_code"]?></li>
									</ul>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<td class="info option" align="center">
					<?php echo number_format($TPL_V3["stock"])?>

				</td>
				<td class="info option" align="center">
<?php if($TPL_V2["subopt_ea"]){?>
					[<?php echo $TPL_V2["subopt_ea"]?>]x<?php echo $TPL_V3["unit_ea"]?>=<span class="ea"><?php echo number_format($TPL_V2["subopt_ea"]*$TPL_V3["unit_ea"])?></span>
<?php }else{?>
					0
<?php }?>
				</td>
				<td class="info option" align="center">
<?php if($TPL_V2["opt_step85"]){?>
					[<?php echo $TPL_V2["opt_step85"]?>]x<?php echo $TPL_V3["unit_ea"]?>=<span class="ea"><?php echo number_format($TPL_V2["subopt_step85"]*$TPL_V3["unit_ea"])?></span>
<?php }else{?>
					0
<?php }?>
				</td>
				<td class="info option" align="center">
<?php if(($TPL_V2["subopt_step45"]+$TPL_V2["subopt_step55"]+$TPL_V2["subopt_step65"]+$TPL_V2["subopt_step75"])){?>
					[<?php echo ($TPL_V2["subopt_step45"]+$TPL_V2["subopt_step55"]+$TPL_V2["subopt_step65"]+$TPL_V2["subopt_step75"])?>]x<?php echo $TPL_V3["unit_ea"]?>=<span class="ea"><?php echo number_format(($TPL_V2["subopt_step45"]+$TPL_V2["subopt_step55"]+$TPL_V2["subopt_step65"]+$TPL_V2["subopt_step75"])*$TPL_V3["unit_ea"])?></span>
<?php }else{?>
					0
<?php }?>
				</td>
				<td class="info option" align="center">
<?php if(($TPL_V2["subopt_ea"]-$TPL_V2["subopt_step45"]-$TPL_V2["subopt_step55"]-$TPL_V2["subopt_step65"]-$TPL_V2["subopt_step75"]-$TPL_V2["subopt_step85"])){?>
					[<?php echo ($TPL_V2["subopt_ea"]-$TPL_V2["subopt_step45"]-$TPL_V2["subopt_step55"]-$TPL_V2["subopt_step65"]-$TPL_V2["subopt_step75"]-$TPL_V2["subopt_step85"])?>]x<?php echo $TPL_V3["unit_ea"]?>=<span class="ea"><?php echo number_format(($TPL_V2["subopt_ea"]-$TPL_V2["subopt_step45"]-$TPL_V2["subopt_step55"]-$TPL_V2["subopt_step65"]-$TPL_V2["subopt_step75"]-$TPL_V2["subopt_step85"])*$TPL_V3["unit_ea"])?></span>
<?php }else{?>
					0
<?php }?>
				</td>
				<td class="null" align="center">→</td>
				<td class="info option" align="center" >
					<?php echo number_format($TPL_V2["ea"]*$TPL_V3["unit_ea"])?>

					<span title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량" class="helpicon"></span>
				</td>
<?php if($TPL_V2["goods_kind"]=='goods'){?>
				<td class="info option" align="center">
<?php if($TPL_V2["option_seq"]&&$TPL_V2["status"]< 55){?>
					<span>대기</span>
<?php }else{?>
					-
<?php }?>
				</td>
<?php }?>
			</tr>
<?php }}?>

<?php }?>
<?php }}?>

			</tbody>
		</table>
<?php }}?>
</form>

<?php if($TPL_VAR["data_page"]["totalpage"]> 1){?>
<div class="paging_navigation" style="margin:auto;">
	<?php echo $TPL_VAR["data_page"]["html"]?>

</div>
<?php }?>

<div id="invoice_manual_dialog" class="hide">
<?php $this->print_("invoice_guide",$TPL_SCP,1);?>

</div>
<div id="default_stock_check_dialog" class="hide">
<?php $this->print_("default_stock_check",$TPL_SCP,1);?>

</div>
<div id="batch_status_popup_layer"></div>
<div id="goodsflow_popup_layer" class="hide">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td height="50px"><B>아래의 STEP1와 STEP2를 순서대로 진행해 주세요.</B></td>
		</tr>
		<tr>
			<td>
				<B>STEP1</B>.
				<span class="blue">굿스플로 화면에서 운송장을 프린트 하세요.</span>
			</td>
		</tr>
		<tr>
			<td>
				----------------------------------------------------------------------
				<br/>프린트를 하시면<br/>
				① 배송정보 : 자동으로 해당 택배사에 전달됩니다.<br/>
				② 운송장번호 : 자동으로 해당 택배사의 운송장번호가 출고건에 할당됩니다.<br/>
				※ ①,② 실행조건 : 굿스플로 택배사 + 운송장번호가 없는 출고<br/>
				<div id="gf_chk_reset" class="pdt10 red fx11 hide">※ 아래의 [운송장 프린트] 를 클릭하면 굿스플로로부터 받은 현재 운송장번호는 없어지고, <br/>굿스플로로부터 새로운 운송장번호를 받을 수 있습니다.</div>
				----------------------------------------------------------------------
			</td>
		</tr>
		<tr>
			<td align="center" style="padding-bottom:20px;">
				<span class="btn large cyanblue" ><button type="button" style="width:150px;" onclick="gf_call();">운송장 프린트</button></span>
			</td>
		</tr>
		<tr>
			<td height="50px">
				<B>STEP2</B>.
				<span class="blue">출고화면을 새로고침하여 할당된 운송장번호를 확인하세요.</span>
			</td>
		</tr>
		<tr>
			<td align="center">
				<span class="btn large cyanblue" ><button type="button" style="width:150px;" onclick="window.location.reload();">새로고침</button></span>
			</td>
		</tr>
	</table>
</div>
<div id="coupon_use_lay"></div>
<div id="search_detail_dialog" class="hide">
<?php $this->print_("export_default_search_path",$TPL_SCP,1);?>

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

<div id="talkbuy_delivary_dialog" class="hide">
	<div class="center">
		<p>카카오페이 구매 주문은 주문 시 선택된 배송방법을 변경할 수 없습니다.</p>
	</div>
	<div class="pd10 center">
		<span class="btn medium" ><button type="button" onclick="closeDialog('talkbuy_delivary_dialog');">확인</button></span>
	</div>
</div>

<br/>

<iframe name="export_frame" width="100%" height="1000" class="hide"></iframe>
<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>