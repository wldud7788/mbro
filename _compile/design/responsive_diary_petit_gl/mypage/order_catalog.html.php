<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/order_catalog.html 000018870 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 주문/배송 내역 @@
- 파일위치 : [스킨폴더]/mypage/order_catalog.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfY2F0YWxvZy5odG1s" >주문/배송 내역</span></h2>
		</div>
		<div class="mypage_greeting">
			전체 <span class="pointnum"><?php echo $TPL_VAR["page"]["totalcount"]?></span>건
		</div>

		<form name="orderSearchForm" id="orderSearchForm" method="get" action="order_catalog">
		<input type="hidden" name="step_type" value="<?php echo $_GET["step_type"]?>" />
		<ul class="myorder_sort">
			<li class="list3">
				<span class="td">
					<select name="sc_date">
<?php if($TPL_VAR["aParams"]["sc_date"]== 0){?>
						<option value="0" selected>전체</option>
<?php }else{?>
						<option value="0">전체</option>
<?php }?>
<?php if($TPL_VAR["aParams"]["sc_date"]== 1){?>
						<option value="1" selected>1주</option>
<?php }else{?>
						<option value="1">1주</option>
<?php }?>
<?php if($TPL_VAR["aParams"]["sc_date"]== 2){?>
						<option value="2" selected>2주</option>
<?php }else{?>
						<option value="2">2주</option>
<?php }?>
<?php if($TPL_VAR["aParams"]["sc_date"]== 3){?>
						<option value="3" selected>3주</option>
<?php }else{?>
						<option value="3">3주</option>
<?php }?>
<?php if($TPL_VAR["aParams"]["sc_date"]== 4){?>
						<option value="4" selected>1개월</option>
<?php }else{?>
						<option value="4">1개월</option>
<?php }?>
<?php if($TPL_VAR["aParams"]["sc_date"]== 8){?>
						<option value="8" selected>2개월</option>
<?php }else{?>
						<option value="8">2개월</option>
<?php }?>
<?php if($TPL_VAR["aParams"]["sc_date"]== 12){?>
						<option value="12" selected>3개월</option>
<?php }else{?>
						<option value="12">3개월</option>
<?php }?>
<?php if($TPL_VAR["aParams"]["sc_date"]=='direct'){?>
						<option value="direct" selected>직접검색</option>
<?php }else{?>
						<option value="direct">직접검색</option>
<?php }?>						
					</select>
				</span>
<?php if($TPL_VAR["aParams"]["sc_date"]!='direct'){?>
				<span id="directArea" class="direct_area Hide">
<?php }else{?>
				<span id="directArea" class="direct_area">					
<?php }?>
					<input type="text" name="sc_sdate" size="10" value="<?php echo $TPL_VAR["aParams"]["sc_sdate"]?>" class="sc-datepicker" readonly /> -
					<input type="text" name="sc_edate" size="10" value="<?php echo $TPL_VAR["aParams"]["sc_edate"]?>" class="sc-datepicker" readonly />
					<button type="submit" class="btn_resp size_b">검색</button>
				</span>
			</li>
		</ul>
		</form>

<?php if($TPL_VAR["page"]["totalcount"]== 0){?>
		<div class="no_data_area2">
			주문내역이 없습니다.
		</div>
<?php }else{?>

		<div id="OcList" class="res_table v2">
			<ul class="thead">
				<li class="buy_date">날짜</li>
				<li class="order_seq">주문번호</li>
				<li class="item_info">상품</li>
				<li class="order_price">주문금액</li>
				<li class="order_status">상태</li>
			</ul>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
			<ul class="tbody">
				<li class="sjb_top"><?php echo date('Y.m.d',strtotime($TPL_V1["regist_date"]))?></li>
				<li class="sjb_top order_seq"><span class="motle">주문번호 : </span><a href="order_view?no=<?php echo $TPL_V1["order_seq"]?>" hrefOri='b3JkZXJfdmlldz9ubz17Lm9yZGVyX3NlcX0=' ><?php echo $TPL_V1["order_seq"]?></a></li>
				<li class="item_info">
<?php if(is_array($TPL_R2=$TPL_V1["items"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if(is_array($TPL_R3=$TPL_V2["options"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
					<ul class="oc_item_info_detail">
						<li class="img_link" <?php if($TPL_V2["goods_type"]!='gift'){?>style="cursor:pointer" title="상품 상세" onclick="location.href='../goods/view?no=<?php echo $TPL_V2["goods_seq"]?>';"<?php }?>>
							<img src="<?php echo viewImg($TPL_V2["goods_seq"],'thumbCart')?>" class="goods_thumb" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage_list.gif'" alt="" designImgSrcOri='ez12aWV3SW1nKC4uZ29vZHNfc2VxLCA=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfY2F0YWxvZy5odG1s' designImgSrc='ez12aWV3SW1nKC4uZ29vZHNfc2VxLCA=' designElement='image' />
						</li>
						<li class="detail_spec">
<?php if($TPL_V2["eventEnd"]){?>
							<div class="oc_event_area">
								<span class="soloEventTd<?php echo $TPL_V3["item_option_seq"]?>">
									<img src="/data/skin/responsive_diary_petit_gl/images/common/icon_clock.gif" class="img_clock" alt="" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9pY29uX2Nsb2NrLmdpZg==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfY2F0YWxvZy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vaWNvbl9jbG9jay5naWY=' designElement='image' > 남은시간
									<span class="time_area">
										<span id="soloday<?php echo $TPL_V3["item_option_seq"]?>">0</span>일
										<span id="solohour<?php echo $TPL_V3["item_option_seq"]?>">00</span>:
										<span id="solomin<?php echo $TPL_V3["item_option_seq"]?>">00</span>:
										<span id="solosecond<?php echo $TPL_V3["item_option_seq"]?>">00</span>
									</span>
								</span>
								<script>
								$(function() {
									timeInterval<?php echo $TPL_V3["item_option_seq"]?> = setInterval(function(){
										var time<?php echo $TPL_V3["item_option_seq"]?> = showClockTime('text', '<?php echo $TPL_V2["eventEnd"]["year"]?>', '<?php echo $TPL_V2["eventEnd"]["month"]?>', '<?php echo $TPL_V2["eventEnd"]["day"]?>', '<?php echo $TPL_V2["eventEnd"]["hour"]?>', '<?php echo $TPL_V2["eventEnd"]["min"]?>', '<?php echo $TPL_V2["eventEnd"]["second"]?>', 'soloday<?php echo $TPL_V3["item_option_seq"]?>', 'solohour<?php echo $TPL_V3["item_option_seq"]?>', 'solomin<?php echo $TPL_V3["item_option_seq"]?>', 'solosecond<?php echo $TPL_V3["item_option_seq"]?>', '<?php echo $TPL_V3["item_option_seq"]?>');
										if(time<?php echo $TPL_V3["item_option_seq"]?> == 0){
											clearInterval(timeInterval<?php echo $TPL_V3["item_option_seq"]?>);
											$("..soloEventTd<?php echo $TPL_V3["item_option_seq"]?>").html("단독 이벤트 종료");
										}
									},1000);
								});
								</script>
							</div>
<?php }?>

<?php if($TPL_V2["goods_type"]=='gift'){?><img src="/data/skin/responsive_diary_petit_gl/images/common/icon_gift.gif" alt="사은품" vspace=3 designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9pY29uX2dpZnQuZ2lm' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfY2F0YWxvZy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vaWNvbl9naWZ0LmdpZg==' designElement='image' /><?php }?>
<?php if($TPL_V3["cancel_type"]=='1'){?><span class="order-item-cancel-type">[청약철회불가]</span><?php }?>

							<div class="goods_name"><?php echo $TPL_V2["goods_name"]?></div>

<?php if($TPL_V2["adult_goods"]=='Y'||$TPL_V2["option_international_shipping_status"]=='y'||$TPL_V2["cancel_type"]=='1'||$TPL_V2["tax"]=='exempt'){?>
							<div class="goods_type">
<?php if($TPL_V2["adult_goods"]=='Y'){?>
								<img src="/data/skin/responsive_diary_petit_gl/images/common/auth_img.png" class="icon1" alt="성인" height="17" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9hdXRoX2ltZy5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfY2F0YWxvZy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vYXV0aF9pbWcucG5n' designElement='image' />
<?php }?>
<?php if($TPL_V2["option_international_shipping_status"]=='y'){?>
								<img src="/data/skin/responsive_diary_petit_gl/images/common/plane.png" class="icon1" alt="해외배송상품" height="16" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9wbGFuZS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfY2F0YWxvZy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vcGxhbmUucG5n' designElement='image' />
<?php }?>
<?php if($TPL_V2["cancel_type"]=='1'){?>
								<img src="/data/skin/responsive_diary_petit_gl/images/common/nocancellation.gif" class="icon1" alt="청약철회"  designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9ub2NhbmNlbGxhdGlvbi5naWY=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfY2F0YWxvZy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vbm9jYW5jZWxsYXRpb24uZ2lm' designElement='image' />
<?php }?>
<?php if($TPL_V2["tax"]=='exempt'){?>
								<img src="/data/skin/responsive_diary_petit_gl/images/common/taxfree.gif" class="icon1" alt="비과세" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi90YXhmcmVlLmdpZg==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfY2F0YWxvZy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9jb21tb24vdGF4ZnJlZS5naWY=' designElement='image' />
<?php }?>
							</div>
<?php }?>

							<div class="oc_res_block">
<?php if($TPL_V3["option1"]!=''){?>
								<ul class="goods_options">
<?php if($TPL_V3["option1"]){?>
									<li><?php if($TPL_V3["title1"]){?><span class="xtle"><?php echo $TPL_V3["title1"]?></span><?php }?> <?php echo $TPL_V3["option1"]?></li>
<?php }?>
<?php if($TPL_V3["option2"]){?>
									<li><?php if($TPL_V3["title2"]){?><span class="xtle"><?php echo $TPL_V3["title2"]?></span><?php }?> <?php echo $TPL_V3["option2"]?></li>
<?php }?>
<?php if($TPL_V3["option3"]){?>
									<li><?php if($TPL_V3["title3"]){?><span class="xtle"><?php echo $TPL_V3["title3"]?></span><?php }?> <?php echo $TPL_V3["option3"]?></li>
<?php }?>
<?php if($TPL_V3["option4"]){?>
									<li><?php if($TPL_V3["title4"]){?><span class="xtle"><?php echo $TPL_V3["title4"]?></span><?php }?> <?php echo $TPL_V3["option4"]?></li>
<?php }?>
<?php if($TPL_V3["option5"]){?>
									<li><?php if($TPL_V3["title5"]){?><span class="xtle"><?php echo $TPL_V3["title5"]?></span><?php }?> <?php echo $TPL_V3["option5"]?></li>
<?php }?>
								</ul>
<?php }?>

<?php if($TPL_V2["goods_type"]!='gift'){?>
								<div class="goods_quantity pointcolor">
									<span class="xtle">수량</span> <strong class="num"><?php echo number_format($TPL_V3["ea"])?></strong>개
								</div>
<?php }?>
							</div>

<?php if($TPL_V3["inputs"]){?>
							<ul class="goods_inputs">
<?php if(is_array($TPL_R4=$TPL_V3["inputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
								<li>
<?php if($TPL_V4["value"]){?>
<?php if($TPL_V4["title"]){?><span class="xtle v2"><?php echo $TPL_V4["title"]?></span><?php }?>
<?php if($TPL_V4["type"]=='file'){?>
										<a href="/mypage_process/filedown?file=<?php echo $TPL_V4["value"]?>" target="actionFrame" hrefOri='L215cGFnZV9wcm9jZXNzL2ZpbGVkb3duP2ZpbGU9ey4uLi52YWx1ZX0=' ><img src="/mypage_process/filedown?file=<?php echo $TPL_V4["value"]?>" class="input_img" title="크게 보기" designImgSrcOri='L215cGFnZV9wcm9jZXNzL2ZpbGVkb3duP2ZpbGU9ey4uLi52YWx1ZX0=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2Uvb3JkZXJfY2F0YWxvZy5odG1s' designImgSrc='L215cGFnZV9wcm9jZXNzL2ZpbGVkb3duP2ZpbGU9ey4uLi52YWx1ZX0=' designElement='image' /></a>
<?php }else{?>
										<?php echo $TPL_V4["value"]?>

<?php }?>
<?php }?>
								</li>
<?php }}?>
							</ul>
<?php }?>

<?php if($TPL_I3== 0&&$TPL_V2["suboptions"]){?>
							<ul class="goods_suboptions">
<?php if(is_array($TPL_R4=($TPL_V2["suboptions"]))&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
								<li><?php if($TPL_V4["title"]){?><span class="xtle v3"><?php echo $TPL_V4["title"]?></span><?php }?> <?php echo $TPL_V4["suboption"]?> - <?php echo number_format($TPL_V4["ea"])?>개</li>
<?php }}?>
							</ul>
<?php }?>
						</li>
					</ul>
<?php }}?>
<?php }}?>
				</li>
				<li class="order_price">
					<!-- 금액 -->
<?php if($TPL_V1["gift_cnt"]==$TPL_V1["opt_cnt"]){?>
					<div>마일리지 교환</div>
					<b><?php echo get_currency_price($TPL_V1["emoney"], 2)?></b>
<?php }else{?>
					<b class="pointcolor"><?php echo get_currency_price($TPL_V1["settleprice"], 2)?></b>
<?php }?>
					<!-- //금액 -->
				</li>
				<li class="order_status">
					<p class="status pointcolor">
<?php if($TPL_V1["payment"]!='pos_pay'){?>
							<?php echo $TPL_V1["mstep"]?>

<?php }else{?>
							오프라인<br/>매장 주문
<?php }?>
					</p>
					<div class="buttons">
<?php if($TPL_V1["payment"]!='pos_pay'){?>
<?php if($TPL_V1["step"]== 15){?>
								<button type="button" class="btn_resp size_a color5" onclick="order_cancel('<?php echo $TPL_V1["order_seq"]?>');">주문무효 &gt;</button>
<?php }elseif($TPL_VAR["refund_able_ea"]&&($TPL_V1["step"]== 25||$TPL_V1["step"]== 35)){?>
								<!-- sjg : refund_able_ea 값이 넘어오지 않음 -->
								<button type="button" class="btn_resp size_a color5" onclick="order_refund('<?php echo $TPL_V1["order_seq"]?>');">결제취소 &gt;</button>
<?php }?>
<?php }?>
<?php if($TPL_V1["step"]> 45&&$TPL_V1["step"]<= 75){?>
<?php if($TPL_V1["goods_kind"]["goods"]){?>
<?php if($TPL_V1["payment"]!='pos_pay'){?>
									<button type="button" class="btn_resp size_a color5 orderexportsbtn" onclick="export_list('<?php echo $TPL_V1["order_seq"]?>', 'goods');">배송추적 &gt;</button>
<?php }?>
<?php if($TPL_V1["buy_confirm_use"]){?><button type="button" class="btn_resp size_a color5 orderexportsbtn" onclick="export_list('<?php echo $TPL_V1["order_seq"]?>', 'goods');">구매확정 &gt;</button><?php }?>
<?php }?>
<?php if($TPL_V1["goods_kind"]["coupon"]&&$TPL_V1["step"]< 75){?>
									<button type="button" class="btn_resp size_a color5" onclick="export_list('<?php echo $TPL_V1["order_seq"]?>', 'coupon');">티켓사용</button>
<?php }?>
<?php }?>
					</div>
				</li>
			</ul>
<?php }}?>
		</div>

<?php $this->print_("paging",$TPL_SCP,1);?>

<?php }?>

	</div>
	<!-- +++++ //mypage contents ++++ -->
</div>



<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->

<link href="/app/javascript/plugin/jquery_selectbox/css/jquery.selectbox.mobile.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/app/javascript/plugin/jquery_selectbox/js/jquery.selectbox-0.2.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		// 주문무효, 결제취소 UI
		$('#OcList .order_status .status').each(function() {
			if ( $(this).text() == '주문무효' || $(this).text() == '결제취소' ) {
				$(this).closest('.tbody').addClass('not_inportant');
			}
		});

		// 주문상세로 이동 이벤트
		$('.order_title').bind('click', function(){
			location.href	= 'order_view?no='+$(this).attr('seq');
		});

		// 기간 검색 selectbox plugin 적용 및 직접검색 처리
		//$("select[name='sc_date']").selectbox();

		$("select[name='sc_date']").bind('change', function(){
			if ($(this).val() == 'direct') {
				$('#directArea').removeClass('Hide');
			} else {
				$("form#orderSearchForm input[name='sc_sdate']").val("");
				$("form#orderSearchForm input[name='sc_edate']").val("");
				$('form#orderSearchForm').submit();
			}
		});

		// 기간 검색 시작일 datepicker 적용 ( 시작일 선택 시 종료일 제한을 추가한다. )
		$("input[name='sc_sdate']").datepicker({
			showAnim:'slideDown',
			dateFormat : 'yy-mm-dd',
			timeFormat: 'hh:mm:ss',
			dayNamesMin : ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort : ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
			showMonthAfterYear : true,
			changeYear : true,
			changeMonth : true,
			closeText : '닫기',
			currentText : '오늘',
			yearRange : '1900:c+10',
			onSelect:function(selectedDate){
				// 종료일 제한
				var maxMonth	= 6;
				var tmpDt		= new Date(selectedDate);
				tmpDt.setMonth(tmpDt.getMonth() + 1);
				var maxY		= tmpDt.getFullYear();
				var maxM		= ((tmpDt.getMonth() + maxMonth) > 8) ? (tmpDt.getMonth() + maxMonth) : '0' + (tmpDt.getMonth() + maxMonth);
				var maxD		= (tmpDt.getDate() > 9) ? tmpDt.getDate() : '0' + tmpDt.getDate();
				var maxDt		= maxY + '-' + maxM + '-' + maxD;
				$("input[name='sc_edate']").datepicker('option',{'minDate':selectedDate,'maxDate':maxDt});
			}
		});
		// 기간 검색 종료일 datepicker 적용 ( 종료일 선택 시 시작일 제한을 추가하고 submit )
		$("input[name='sc_edate']").datepicker({
			showAnim:'slideDown',
			dateFormat : 'yy-mm-dd',
			timeFormat: 'hh:mm:ss',
			dayNamesMin : ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort : ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
			showMonthAfterYear : true,
			changeYear : true,
			changeMonth : true,
			closeText : '닫기',
			currentText : '오늘',
			yearRange : '1900:c+10',
			onClose:function(selectedDate){
				$("input[name='sc_sdate']").datepicker('option',{'maxDate':selectedDate});
				$('form#orderSearchForm').submit();
			}
		});

		$('.new-datepicker').click(function(){
			$("input[name='sc_sdate']").datepicker();
		});

	});

	// 상품평
	function goods_review_write(goodsseq, order_seq){
		if(goodsseq){
			document.location.href	= 'mygdreview_write?goods_seq=' + goodsseq + '&order_seq=' + order_seq;
		}
	}
	// 주문 무효처리
	function order_cancel(order_seq){
		if(confirm('주문을 무효처리 합니다.')){
			actionFrame.location.href	= '../mypage_process/cancel?order_seq=' + order_seq;
		}
	}

	// 결제취소 신청
	function order_refund(order_seq){
		document.location.href	= 'order_refund?order_seq=' + order_seq + '&use_layout=1';
	}

	// 배송조회 및 쿠폰사용
	function export_list(order_seq, type){
		document.location.href	= 'export_list?seq=' + order_seq + '&type=' + type;
	}
</script>