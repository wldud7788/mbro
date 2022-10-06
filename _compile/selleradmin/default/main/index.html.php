<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/main/index.html 000018263 */ 
$TPL_popupsellernoticeloop_1=empty($TPL_VAR["popupsellernoticeloop"])||!is_array($TPL_VAR["popupsellernoticeloop"])?0:count($TPL_VAR["popupsellernoticeloop"]);
$TPL_goodsSummary_1=empty($TPL_VAR["goodsSummary"])||!is_array($TPL_VAR["goodsSummary"])?0:count($TPL_VAR["goodsSummary"]);
$TPL_sellernoticeloop_1=empty($TPL_VAR["sellernoticeloop"])||!is_array($TPL_VAR["sellernoticeloop"])?0:count($TPL_VAR["sellernoticeloop"]);
$TPL_goodsqnaloop_1=empty($TPL_VAR["goodsqnaloop"])||!is_array($TPL_VAR["goodsqnaloop"])?0:count($TPL_VAR["goodsqnaloop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/main.css?v=<?php echo date('Ymd')?>" />
<script type="text/javascript" src="/app/javascript/js/admin-board.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('YmdH')?>"></script>
<script type="text/javascript">
	var last_reload		= '';
	$(function(){
		/* 주요지표 */
		$(".sale_product .tab_menu li").click(function(){
			$(".sale_product .tab_menu li").removeClass("active");
			$(this).addClass("active");
			var $boxVar = $(this).index() + 1;
			$(".sale_product .tab_sub").hide();
			$(".sale_product .tab_box"+$boxVar).show();
		});

		$(".mqs-menu td").click(function(){
			$(".mqs-menu td").not(this).removeClass("selected");
			$(this).addClass("selected");

			contents_pannel_load('qna');

			var idx = $(".mqs-menu td").index(this);

			$("#main-qna-summary .link-more").hide().eq(idx).show();

			return false;
		}).eq(0).click();


		$(".mseller-menu td").click(function(){
			$(".mseller-menu td").not(this).removeClass("selected");
			$(this).addClass("selected");

			contents_pannel_load('seller');

			var idx = $(".mseller-menu td").index(this);

			$("#main-seller-summary .link-more").hide().eq(idx).show();

			return false;
		}).eq(0).click();

		print_main_order_summary();
		print_main_state();

<?php if(!$TPL_VAR["cfg_reservation"]["update_date"]){?>
		reservation_update();
<?php }?>

		// 상품문의 게시글 보기
		$('span.goods_qna_boad_view_btn').live('click', function() {
			var board_seq = $(this).attr('board_seq');
			var boardviewurl = '../board/goods_qna_view?id=goods_qna&mainview=1&seq='+board_seq;
			boardaddFormDialog(boardviewurl, 1200, 700, '상품문의 게시글 보기','false');
		});

		// 입점사공지 게시글 보기
		$('span.gs_seller_notice_boad_view_btn').live('click', function() { //
			var board_seq = $(this).attr('board_seq');
			var boardviewurl = '../board/gs_seller_notice_view?id=gs_seller_notice&mainview=1&seq='+board_seq;
			boardaddFormDialog(boardviewurl, 1200, 700, '입점사공지 게시글 보기','false');
		});

		var popupKey = '';
<?php if($TPL_VAR["popupsellernoticeloop"]){?>
<?php if($TPL_popupsellernoticeloop_1){foreach($TPL_VAR["popupsellernoticeloop"] as $TPL_V1){?>
<?php if($TPL_V1["seq"]){?>
					popupKey = "ProviderPopup<?php echo $TPL_V1["seq"]?>";
					if(!$.cookie(popupKey)){
						var boardviewurl = '../board/gs_seller_notice_view_main?id=gs_seller_notice&mainview=1&admainview=1&seq=<?php echo $TPL_V1["seq"]?>';
						boardaddFormDialog(boardviewurl, 1200, 700, '입점사공지 게시글 보기','false');
					}
<?php }?>
<?php }}?>
<?php }?>

		$('#btn-main-reload').bind('click', function(){
			var reload_status	= 'y';
			if	(last_reload){
				var now_datetime	= new Date().valueOf();
				var diff_time		= now_datetime - last_reload;
				if	(diff_time <= 60000){
					reload_status	= 'n';
				}
			}
			if	(reload_status == 'y'){
				last_reload = new Date().valueOf();
				delete_main_stat();
			}else{
				openDialogAlert("업데이트는 60초당 1회 가능합니다.<br/>운영쇼핑몰의 상세한 통계 데이터는 통계메뉴에 확인 해 주세요.",530,240,'');
			}
		});
	});

	// 출고예약량 업데이트
	function reservation_update(){
		openDialogAlert("상품의 출고예약량 업데이트중입니다.<br/>브라우저 창을 닫지 마시고<br>잠시만 기다려 주십시오.",400,150,function(){},{"hideButton":true, "noClose" : true,"modal":true});

		$.ajax({
			url : '../goods_process/all_modify_reservation',
			global : false,
			success : function(data){if(data == 'OK'){
				closeDialog('openDialogLayer');
				openDialogAlert("상품의 출고예약량이 정상적으로 업데이트 되었습니다.",400,210,function(){},{"hideButton" : false});
			}}
		});
	}
	function contents_pannel_load(area){
		var areaContentsObj = $("#main-"+area+"-summary .main-summary-contents").length ? $("#main-"+area+"-summary .main-summary-contents") : $("#main-"+area+"-summary");

		areaContentsObj.empty().activity({segments: 8, width: 3.5, space: 1, length: 7, color: '#666', speed: 1.5});
		$.ajax({
			'url' : 'get_main_contents_pannel',
			'data' : {"area":area},
			'global' : false,
			'success' : function(html){
				areaContentsObj.html(html).activity(false);
			}
		});
	}
	function boardnoticepopup(boardviewurl){
		boardaddFormDialog(boardviewurl, 1200, 700, '입점사공지 게시글 보기','false');
	}

	function refreshTable(url) {
		$.get(url, {}, function(data, textStatus) {
			$('#dlg_content').html(data);
		});
	}
	//관리자 비밀번호 변경
	function change_pass(required)
	{
		var gdata = {'required':required};
		$.ajax({
			type: "get",
			url: "popup_change_pass",
			data: gdata,
			async:false,
			success: function(result){
				$("#popup_change_pass").html(result);
			}
		});
		if(required){
			var params = {"width":700,"noClose":true};
		}else{
			var params = {"width":700};
		}
		openDialog("쇼핑몰 관리자 계정 비밀번호 변경 안내", "popup_change_pass", params);
	}

	/* 주문처리 */
	function print_main_order_summary()
	{
		$("div#order_summary").html('');
		$.ajax({
			url				: '../main/ajax_main_order_summary',
			globa			: false,
			dataType	: 'json',
			success 		: function(result){
				var data = '';
				for(var index in result)
				{
					if (result.hasOwnProperty(index))
					{
						data = result[index];
						if(index>15) $("div#order_summary").append("<dl class='hand' onclick='location.href=\""+data.link+"\"'><dt>"+data.name+"</dt><dd>"+data.count+"개</dd></dl>");
						if(index == 70) $("div#order_summary").append("<dl><dt>&nbsp;</dt><dd>&nbsp;</dd></dl>");
					}
				}
			}
		});
		
	}

	function print_main_state()
	{
		$.ajax({
			url				: 'json_main_stats',
			globa			: false,
			dataType	: 'json',
			success 		: function(result){
				var data			= [];
				var obj			= [];
				var tmp			= [];
				var num			= 0;
				var len			= 0;
				var display_id	= 'rank_order';
				var html        = "";
				if( result == null) return false;

				if(result.rank)
				{
					
					$.each(result.rank, function(mode, tmp){
						html		= "";
						display_id	= 'rank_'+mode;
						obj			= $('div#'+display_id);
						num			= 0;
						len			= 0;						
						if( tmp )
						{	
							if( tmp[0] ) obj.html('');
							$.each(tmp, function(index, data){								
								if (data.goods_name){
									num++;
									html += '<ul>';
									html += '<li class="num"><span>'+num+'</span></li>';
									if( typeof(data.tot_price) == "undefined" ){										
										html += '<li class="tit"><a href="#">'+data.goods_name+'</a></li>';
										html += '<li class="cnt">'+data.tot_ea+'회</li>';
									}else{										
										html += '<li class="tit"><a href="#">'+data.goods_name+'</a></li>';
										html += '<li class="cnt">'+data.tot_ea+'개</li>';
										html += '<li class="price">'+data.tot_price+' '+gl_basic_currency+'</li>';
									}
									html += '</ul>';									
								}
							});
							obj.append(html);
						}						
					});
				}
				$("#today_order_count").html(comma(result.today_stat_order.cnt));
				$("#today_order_price").html(comma(result.today_stat_order.price));
			}
		});
	}

	function delete_main_stat()
	{
		$.ajax({
			url				: 'main_stats_cach_delete',
			dataType	: 'json',
			success 		: function(data)
			{
				if( data.result =='OK' ) return true;
			}
		});
	}
</script>
<style>
	.ProviderPopup		{position:absolute;}
	.ProviderPopup .ProviderPopupBar	{height:25px; background-color:#fff; color:#fff;}
	.ProviderPopup .ProviderPopupBar .ProviderPopupTodaymsg	{float:left; line-height:25px; padding-left:5px; font-size:11px; color:#898989; letter-spacing:-1px; font-family:dotum;}
	.ProviderPopup .ProviderPopupBar .ProviderPopupClose		{float:right; line-height:25px; padding-right:5px; cursor:pointer; font-size:11px; color:#585858; letter-spacing:-1px; font-family:dotum;}
</style>

<ul id="main_wrap">
	<li>
		<ul class="admin_wrap">
			<li class="domain">
				<?php echo $TPL_VAR["this_admin_env"]["env_name"]?>

			</li>
			<li>			
				<dl>
					<dt>상태</dt>
					<dd><?php if($TPL_VAR["data_provider"]["provider_status"]=='Y'){?>정상<?php }else{?>미승인<?php }?></dd>
				</dl>
			</li>
			<li>			
				<dl>
					<dt>판매등급</dt>
					<dd><?php echo $TPL_VAR["data_provider"]["pgroup_name"]?></dd>
				</dl>
			</li>
			<li>			
				<dl>
					<dt>정산주기</dt>
					<dd>월 <?php echo $TPL_VAR["data_provider"]["calcu_count"]?>회</dd>
				</dl>
			</li>
			<li>			
				<dl>
					<dt>단골미니샵</dt>
					<dd>누적 <?php echo number_format($TPL_VAR["data_provider"]["minishop_count"])?>명 <a href="../../mshop?m=<?php echo $TPL_VAR["data_provider"]["provider_seq"]?>" target="_blank" title="새창열림" class="btn_minishop">미니샵 바로가기</a></dd>
				</dl>
			</li>
		</ul>
	</li>
	<li>
		<!-- //관리자 정보 -->
		<div class="summary_wrap">
			<ul>
				<li class="today_info">
					<ul class="box_wrap">
						<li>
							<ul>
								<li class="icon"><span class="i-order"/></li>
								<li>
									<dl>
										<dt>오늘 결제확인 <span class="tooltip_btn" onclick="showTooltip(this, '../tooltip/order', '#tip24', 'sizeS')"></span></dt>
										<dd><span id="today_order_count"></span> 건</dd>
									</dl>
								</li>
							</ul>
						</li>
					
						<li>
							<ul>
								<li class="icon"><span class="i-order"/></li>
								<li>
									<dl>
										<dt>오늘 상품매출</dt>
										<dd><span id="today_order_price"></span> <?php echo $TPL_VAR["config_system"]["basic_currency"]?></dd>
									</dl>
								</li>
							</ul>
						</li>
					</ul>
				</li>		
			</ul>
		</div>
	</li>

	<li>			
		<!-- //요약 정보 -->
		<div class="main_wrap">
			<ul>
				<li class="sale_product">
					<div class="box_wrap">
						<ul class="tab_menu">
							<li class="active"><h3>판매상품 TOP6<a href="../statistic_sales/sales_sales" class="more hide">더보기</a></h3></li>
							<li><h3>장바구니상품 TOP6<a href="../statistic_member/member_basic" class="more hide">더보기</a></h3></li>							
						</ul>						
						<div class="table_wrap tab_sub tab_box1" >
							<div id="rank_order" class="rank_wrap">
								<div class="nodata"><span class="icon_nodata"></span> 최근 10일동안<br /> 판매된 상품이 없습니다.</div>						
							</div>
							<!-- //판매상품 TOP6 -->
<?php if($TPL_VAR["providerInfo"]["manager_yn"]!='Y'){?>
							<div style="position:absolute; top:195px; left:2px; width:99%; height:106px; z-index:1; visibility:visible; background:#efefef">
								<div class="center" style="padding-top:45px;">
									권한이 없습니다.
								</div>							
							</div>
<?php }?>
						</div>

						<div class="table_wrap tab_sub tab_box2 hide">
							<div id="rank_cart" class="rank_wrap">
								<div class="nodata"><span class="icon_nodata"></span> 최근 10일동안<br />  장바구니에 담긴 상품이 없습니다.</div>						
							</div>
							<!-- //판매상품 TOP6 -->
<?php if($TPL_VAR["providerInfo"]["manager_yn"]!='Y'){?>
							<div style="position:absolute; top:195px; left:2px; width:99%; height:106px; z-index:1; visibility:visible; background:#efefef">
								<div class="center" style="padding-top:45px;">
									권한이 없습니다.
								</div>							
							</div>
<?php }?>
						</div>
					</div>
				</li>
				<li>
					<div class="box_wrap">
						<div class="title">주문 처리 <span class="sub_tit">(최근 100일)</span> <a id="btn-main-reload" class="reflash hand "></a></div>
						<div class="table_wrap" id="order_summary">
						</div>
					</div>
				</li>
				<li>
					<div class="box_wrap">
						<div class="title">상품 현황</div>
						<div class="table_wrap goods">
							<ul>
								<li>구분</li>
								<li>실물</li>
								<li>패키지</li>
								<li>티켓</li>
							</ul>
<?php if($TPL_goodsSummary_1){foreach($TPL_VAR["goodsSummary"] as $TPL_K1=>$TPL_V1){?>
							<dl>
								<dt>
									<a href="<?php echo $TPL_V1["goods"]["link"]?>">
<?php if($TPL_K1=='safe_stock'){?>
									안전재고 미만
<?php }elseif($TPL_K1=='normal'){?>
									판매중
<?php }elseif($TPL_K1=='runout'){?>
									품절
<?php }elseif($TPL_K1=='unsold'){?>
									판매중지
<?php }?>
									</a>
								</dt>
								<dd class="goods">
									<a href="<?php echo $TPL_V1["goods"]["link"]?>"><?php echo $TPL_V1["goods"]["count"]?></a>개
								</dd>
								<dd class="package"><a href="<?php echo $TPL_V1["package"]["link"]?>"><?php echo $TPL_V1["package"]["count"]?></a>개</dd>
								<dd><a href="<?php echo $TPL_V1["coupon"]["link"]?>"><?php echo $TPL_V1["coupon"]["count"]?></a>개</dd>
							</dl>
<?php }}?>
						</div>
					</div>
					<!-- //상품 현황 -->
				</li>
			</ul>
		</div>		
	</li>
	<li>
		<div>
			<ul>
				<li class="phone_info">
					<div class="box_wrap">							
						<div class="title">본사 대표 번호(입점사 전용)</div>	
						<div class="phoneNumber_wrap">					
<?php if($TPL_VAR["number"]["providerNumber"]){?>
							<div class="phone"><?php echo $TPL_VAR["number"]["providerNumber"]?></div>
<?php }else{?>
							<div class="phone"><?php echo $TPL_VAR["number"]["companyPhone"]?></div>
<?php }?>
						</div>							
					</div>
					<!-- //리셀러 제도 -->
				</li>
				<li class="board_wrap">
					<div class="box_wrap">
						<div class="title">입점사공지 <a href="../board/board?id=gs_seller_notice" class="more">더보기</a></div>
						<div class="tab_sub">
<?php if($TPL_VAR["sellernoticeloop"]){?>
							<ul>
<?php if($TPL_sellernoticeloop_1){foreach($TPL_VAR["sellernoticeloop"] as $TPL_V1){?>
								<li><?php echo $TPL_V1["subject"]?><span class="date"><?php echo str_replace('-','.',substr($TPL_V1["date"], 5, 5))?></span></li>
<?php }}?>
							</ul>
<?php }else{?>
							<div class="nodata">등록된 게시글이 없습니다.</div>
<?php }?>
						</div>
					</div>
				</li>
				<li class="board_wrap">
					<div class="box_wrap">
						<div class="title">상품문의 <a href="../board/board?id=goods_qna" class="more">더보기</a></div>
						<div class="tab_sub">
<?php if($TPL_VAR["goodsqnaloop"]){?>
							<ul>
<?php if($TPL_goodsqnaloop_1){foreach($TPL_VAR["goodsqnaloop"] as $TPL_V1){?>
								<li><?php echo $TPL_V1["subject"]?><span class="date"><?php echo str_replace('-','.',substr($TPL_V1["date"], 5, 5))?></span></li>
<?php }}?>
							</ul>
<?php }else{?>
							<div class="nodata">등록된 게시글이 없습니다.</div>
<?php }?>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</li>
</ul>


<?php if($TPL_VAR["notify_popup"]){?>
<div id="notify_popup" style="padding:0px;min-height:50px !important">
		<style>
			#notify_popup table {width:550px; margin:auto;}
			#notify_popup table td {height:55px; padding: 10px 0; border-bottom:1px solid #ededed}
			#notify_popup table td p{padding: 5px 0 0 15px}
			#main_notify_icon_gf {margin:5px 10px 5px 3px; background:url('/admin/skin/default/images/main/goodsflow_use_icon.png') no-repeat; width:91px; height:91px; display:inline-block;}
		</style>
	<table border="0" cellpadding="0" cellspacing="0">
		<colgroup>
			<col width="91" /><col /><col width="60" />
		</colgroup>
		<tbody>
			<tr>
				<td class="left"><span id="main_notify_icon_gf"></span></td>
				<td colspan="2">
					<br/>
					축하드립니다!<br/>
					우체국택배 업무 자동화 서비스 연동이 모두 완료되었습니다.<br/><br/>
					주문상태를 ‘출고완료’로 변경하면,<br/>
					자동으로 운송장 번호가 할당되며 우체국택배 시스템으로 출고정보가 전송됩니다.<br/>
					배송상태도 자동으로 업데이트 되오니 운영에 참고하시기 바랍니다.<br/><br/>
					※ 단, 운송장출력은 우체국택배 관리자(<a href="http://biz.epost.go.kr" target="_blank">biz.epost.go.kr</a>)에서 진행하세요.

					<br/><br/><br/>
					<div style="margin-left:120px;">
						<span class="btn medium"><a href="selleradmin/setting/provider_reg?no=<?php echo $TPL_VAR["providerInfo"]["provider_seq"]?>">배송설정 바로가기</a></span>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script>openDialog('알려드립니다!','notify_popup',{"width":570});</script>
<?php }?>

<!-- 팝업 영역 : 시작 -->
<div class="gabia-pannel" code="main_popup"></div>
<!-- 팝업 영역 : 끝 -->


<!-- 비밀번호 변경 -->
<div id="popup_change_pass"></div>
<?php if($TPL_VAR["is_change_pass_required"]){?>
<script type="text/javascript">change_pass(true);</script>
<?php }elseif($TPL_VAR["is_change_pass"]){?>
<script type="text/javascript">change_pass();</script>
<?php }?>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>