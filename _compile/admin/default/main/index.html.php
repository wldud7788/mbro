<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/main/index.html 000020650 */  $this->include_("getGabiaMainBannerPannel");
$TPL_serviceHtml_1=empty($TPL_VAR["serviceHtml"])||!is_array($TPL_VAR["serviceHtml"])?0:count($TPL_VAR["serviceHtml"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/admin-board.js?v=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('YmdH')?>"></script>
<!--[if IE]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/js/admin-main.js?v=<?php echo date('Ymd')?>"></script>
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" class="include" />
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/main.css?v=<?php echo date('Ymd')?>" media="screen" />
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script type="text/javascript">
	var last_reload	= '';
	var gl_H_AD		= "<?php echo serviceLimit('H_AD')?>";
	var gl_H_SC		= "<?php echo serviceLimit('H_SC')?>";
	var gl_9ago		= "<?php echo date('Y-m-d',strtotime('-9 days'))?>";
	var gl_today	= "<?php echo date('Y-m-d')?>";
	var gl_shopSno	= "<?php echo $TPL_VAR["config_system"]["shopSno"]?>";


	$(function(){
		/* 주요지표 */
		$(".board_wap .tab_menu li").click(function(){
			$(".board_wap .tab_menu li").removeClass("active");
			$(this).addClass("active");
			var $boxVar = $(this).index() + 1;
			$(".board_wap .tab_sub").hide();
			$(".board_wap .tab_box"+$boxVar).show();
		});


		/* 매출 */
		$(".stats_wrap .tab_menu li").click(function(){
			$(".stats_wrap .tab_menu li").removeClass("active");
			$(this).addClass("active");
			var $boxVar = $(this).index() + 1;
			$(".stats_wrap .tab_sub").hide();
			$(".stats_wrap .tab_box"+$boxVar).show();
		});

		/* firstmall.kr 게시판 rss */
		print_main_news_area('notice');
		print_main_news_area('upgrade');
		//print_main_news_area('upgrade_news');
		print_main_news_area('education');
		print_main_stat();

		/* sms ajax 호출 leewh 2014-07-31 */
		get_sms_info();
		/* kakaotalk ajax 호출 :: 2018-03-02 lwh */
		get_kakao_info();
		/* 주요 이슈사항 공지 호출 */
		get_notify_info();
		/* traffic ajax 호출 :: 2015-01-09 lwh */
		reload_data('main','<?php echo $TPL_VAR["this_admin_env"]["temp_domain"]?>');
		/* 요약통계 업데이트 */

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
				//delete_main_stat(); 작동안함 18.09.07 kmj
				$.ajax({
					url			: 'main_stats_cach_delete',
					dataType	: 'json',
					success 	: function(data)
					{
						if( data.result =='OK' ) location.reload();
					}
				});
			}else{
				openDialogAlert("업데이트는 60초당 1회 가능합니다.<br/>운영쇼핑몰의 상세한 통계 데이터는 통계메뉴에 확인 해 주세요.",530,240,'');
			}
		});
<?php if(!$TPL_VAR["cfg_reservation"]["update_date"]){?>
			reservation_update();
<?php }?>

<?php if($TPL_VAR["facebook_notice"]){?>
			/*페이스북 관련 공지 18.02.28 kmj*/
			var viewCheckYN = $.cookie('fb_notice_view_check');
			if(viewCheckYN != "Y"){
				openDialogNew(
					'<?php echo $TPL_VAR["facebook_notice"]["title"]?>',
					'facebookNotice',
					{
						'width' :'<?php echo $TPL_VAR["facebook_notice"]["width"]?>',
						'height':'<?php echo $TPL_VAR["facebook_notice"]["height"]?>'
					},
					function fb_close(){
						var viewCheck = $('#fb_notice_view_check').is(':checked');
						var date = new Date();
						date.setTime(date.getTime() + ((3600 * 1000) * 24 * 7)); //1 week
						if(viewCheck){
							$.cookie('fb_notice_view_check', 'Y', { path: '/', expires: date });
						}
					}
				);
			}
<?php }?>

<?php if($TPL_VAR["config_basic"]["manual_view"]=='N'){?>
			openDialog("알림", "firstmallGlManualPopup", {"width":"850","height":"820","close":function(){manualEndClose();}});
<?php }?>
	});
function manualEndClose(){
	var manual_check = $("#manual_view_check").is(":checked");
	if(manual_check){
		$.ajax({
			type: "post",
			url: "../setting_process/manualViewClose",
			data: "manual_check=Y",
			dataType: 'json',
			success: function(result){
				if(result == "ok"){
				}else if(result == "err"){
				}
			}
		});
	}
}
</script>

<ul id="main_wrap">
	<li class="center">
		<ul class="admin_wrap">
			<li class="domain">
<?php if($TPL_VAR["this_admin_env"]["domain"]){?>
				<?php echo $TPL_VAR["this_admin_env"]["domain"]?>

<?php }else{?>
				http://<?php echo $TPL_VAR["this_admin_env"]["temp_domain"]?> (기본)
<?php }?>

			</li>
			<li>
				<dl>
					<dt>타입</dt>
					<dd><?php echo $TPL_VAR["service_name"]?></dd>
				</dl>
			</li>
			<li>
				<dl>
					<dt>기간</dt>
					<dd>
<?php if(solutionServiceCheck( 1)){?>
							<span>평생</span>
							<span style="color:#a3a3a3; font-size:11px;">(단, 관리자 미접속 30일 차단, 60일 삭제)</span>
<?php }elseif($TPL_VAR["expireDay"]&&(solutionServiceCheck( 6790)||solutionServiceCheck( 32)||(solutionServiceCheck( 1304)&&$TPL_VAR["config_system"]["service"]["hosting_code"]!='F_SH_X'))){?>
							<span><?php echo $TPL_VAR["expireDay"]?> <span class="red">(<?php echo number_format($TPL_VAR["remainExpireDay"])?>일 남음)</span></span>

							<div id="hostingExpire" class="hide <?php echo $TPL_VAR["service_code"]?>">
								<ul>
									<li>
										<span class="icon_extend"></span>
										<strong>[기간 연장]</strong><br />
										호스팅 만료일이 <span class="red"><?php echo number_format($TPL_VAR["remainExpireDay"])?>일</span> 남았습니다.
									</li>
<?php if($TPL_VAR["hosting_service"]!='CLOUD'){?>
									<li><a href="https://www.firstmall.kr/myshop" target="_blank" class="resp_btn v4 size_SS">연장</a></li>
<?php }?>
								</ul>
							</div>
<?php if($TPL_VAR["hosting_service"]!='CLOUD'){?>
<?php if($TPL_VAR["functionLimit"]){?>
								<a href="javascript: servicedemoalert('use_f');" class="resp_btn v4 size_SS">
<?php }else{?>
<?php if($TPL_VAR["remainExpireDay"]< 8){?>
									<a href="javascript: openDialog('알려드립니다!','hostingExpire',{'width':530, 'height':200});" target="_blank" title="새창열림"  class="resp_btn v4 size_SS expire">
<?php }else{?>
									<a href="https://www.firstmall.kr/myshop "  target="_blank" title="새창열림"  class="resp_btn v4 size_SS">
<?php }?>
<?php }?>
								연장
								</a>
<?php }?>
<?php }else{?>
							없음
<?php }?>
					</dd>
				</dl>
			</li>
			<li>
				<dl>
					<dt>용량</dt>
					<dd>
<?php if($TPL_VAR["functionLimit"]){?>
							<?php echo $TPL_VAR["usedDiskSpace"]?> / <?php echo $TPL_VAR["maxDiskSpace"]?> (<?php echo $TPL_VAR["usedSpacePercent"]?>%) <a href="javascript: servicedemoalert('use_f');" class="resp_btn v4 size_SS <?php if($TPL_VAR["usedSpacePercent"]> 89){?>}expire<?php }?>">추가</a>
<?php }else{?>
<?php if($TPL_VAR["hosting_service"]=='CLOUD'){?>
							무제한
<?php }elseif(solutionServiceCheck( 1)||solutionServiceCheck( 6790)||solutionServiceCheck( 32)||(solutionServiceCheck( 1304)&&!preg_match("/^F_SH_/",$TPL_VAR["hosting_code"]))){?>
							<?php echo $TPL_VAR["usedDiskSpace"]?> / <?php echo $TPL_VAR["maxDiskSpace"]?> (<?php echo $TPL_VAR["usedSpacePercent"]?>%) <a href="https://www.firstmall.kr/myshop" target="_blank" title="새창열림" class="resp_btn v4 size_SS <?php if($TPL_VAR["usedSpacePercent"]> 89){?>}expire<?php }?>">추가</a>
<?php }else{?>
							없음
<?php }?>
<?php }?>						
					</dd>
				</dl>
			</li>
			<li class="traffic_area">
				<dl>
					<dt>트래픽</dt>
					<dd>
						<span id="traffic_area" >
<?php if(!serviceLimit('H_EXAD')||$TPL_VAR["hosting_service"]=='CLOUD'){?>
							무제한
<?php }elseif($TPL_VAR["hosting_code"]!='F_SH_X'&&$TPL_VAR["config_system"]["service"]["traffic"]> 0){?>
								<b><?php echo $TPL_VAR["traffic"]["usages"]?></b> / <?php echo $TPL_VAR["traffic"]["limits"]?>(<b><?php echo $TPL_VAR["traffic"]["state"]?>% 사용중</b>)
<?php }else{?>
							없음
<?php }?>
						</span>
<?php if($TPL_VAR["hosting_service"]!='CLOUD'&&$TPL_VAR["hosting_code"]!='F_SH_X'){?>
<?php if($TPL_VAR["functionLimit"]){?>
							<a href="javascript:servicedemoalert('use_f');" class="resp_btn v4 size_SS <?php if($TPL_VAR["traffic"]["state"]> 89){?>}expire<?php }?>">리셋</a>
<?php }else{?>
							<a href="https://www.firstmall.kr/myshop/index_service.php?domain=<?php echo $TPL_VAR["this_admin_env"]["temp_domain"]?> " target="_blank" title="새창열림" class="resp_btn v4 size_SS <?php if($TPL_VAR["traffic"]["state"]> 89){?>}expire<?php }?>">리셋</a>
<?php }?>
<?php }?>						
					</dd>
				</dl>
			</li>
			<li class="auth_yn">
				<dl>
					<dt>대표자</dt>
					<dd>
<?php if($TPL_VAR["hosting_code"]!='F_SH_X'){?>
<?php if($TPL_VAR["config_system"]["mall_auth_yn"]!='y'){?>
						실명인증 필요
<?php }else{?>
						실명인증 완료
<?php }?>
						 <a href="https://www.firstmall.kr/customer/faq/1512" target="_blank" class="resp_btn v4 size_SS">안내</a>
<?php }else{?>
						없음
<?php }?>						
					</dd>
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
										<dt>오늘 주문접수</dt>
										<dd><span id="today_order_count"></span> 건</dd>
									</dl>
								</li>
							</ul>
						</li>
						<li>
							<ul>
								<li class="icon"><span class="i-payment"/></li>
								<li>
									<dl>
										<dt>오늘 결제확인 <span class="tooltip_btn" onclick="showTooltip(this, '../tooltip/order', '#tip24', 'sizeS')"></span></dt>
										<dd><span id="today_deposit_count"></span> 건</dd>
									</dl>
								</li>
							</ul>
						</li>
						<li>
							<ul>
								<li class="icon"><span class="i-sales"/></li>
								<li>
									<dl>
										<dt>오늘 매출</dt>
										<dd><span id="today_deposit_price"></span> <?php echo $TPL_VAR["config_system"]["basic_currency"]?></dd>
									</dl>
								</li>
							</ul>
						</li>
						<li class="today_status">
							<dl>
								<dt>총 회원</dt>
								<dd><span id="total_member_count"></span> 명</dd>
							</dl>
						</li>
						<li class="today_status">
							<dl>
								<dt>누적 마일리지</dt>
								<dd><span id="total_emoney"></span> <?php echo $TPL_VAR["config_system"]["basic_currency"]?></dd>
							</dl>
						</li>
					</ul>
				</li>
				<li class="extra_service">
					<div class="box_wrap">
						<div class="title">부가서비스</div>
						
<?php if($TPL_serviceHtml_1){foreach($TPL_VAR["serviceHtml"] as $TPL_V1){?>
						<dl>
							<dt><span><?php echo $TPL_V1["name"]?></span><a href="<?php echo $TPL_V1["link"]?>" class="link"></a></dt>
<?php if($TPL_V1["name"]=="이프두"){?>
							<dd><span class="txt"><?php echo $TPL_V1["servicetxt"]?></span></dd>
<?php }else{?>
							<dd><span class="num"><?php echo $TPL_V1["servicetxt"]?></span>통</dd>
<?php }?>
						</dl>
<?php }}?>
					</div>
				</li>
			</ul>
		</div>
	</li>

	<li>
		<!-- //요약 정보 -->
		<div class="main_wrap <?php if(serviceLimit('H_SC')){?>H_SC<?php }?>">
			<ul>
				<li class="sale_product">
					<div class="box_wrap">
						<div class="title">판매상품</div>
						<div class="table_wrap rank_order" id="rank_order">
							<div class="nodata"><span class="icon_nodata"></span> 최근 10일동안<br/>판매된 상품이 없습니다.</div>
<?php if(serviceLimit('H_FR')){?>
							<div class="free_upgrade">
								<div class="nodata">
									죄송합니다.<br/>
									본 기능은 상위버전으로
									업그레이드 후<br/>
									이용 가능합니다.
								</div>
								<div class="pdt5 center">
									<div class="resp_btn v3"  onclick="serviceUpgrade();">업그레이드 하기 <img src="/admin/skin/default/images/main/i_arrow2.png" class="ml5"></div>
								</div>
							</div>
<?php }?>			
						</div>
					</div>
				</li>
				<li class="order_status">
					<div class="box_wrap">
						<div class="title">주문처리 <span class="sub_tit">(최근 100일)</span> <a id="btn-main-reload" class="reflash hand"></a></div>
						<div class="table_wrap" id="order_summary">	</div>
					</div>
				</li>
				<li class="board_status">
					<div class="box_wrap">
						<div class="title">게시글 현황</div>
						<div class="table_wrap board" id="board_summary">
							<ul>
								<li>구분</li>
								<li>미처리</li>
							</ul>
						</div>
					</div>
				</li>
				<li class="product_status">
					<div class="box_wrap">
						<div class="title">상품 현황</div>
						<div class="table_wrap goods" id="goods_summary">
							<ul>
								<li>구분</li>
								<li>실물</li>
								<li>패키지</li>
								<li>티켓</li>
							</ul>
						</div>
					</div>
				</li>
<?php if(serviceLimit('H_SC')){?>
				<li class="stock_status">
					<div class="box_wrap">
						<div class="title">재고관리</div>
						<div class="table_wrap board" id="scm_summary">
							<ul>
								<li>구분</li>
								<li>항목</li>
							</ul>
						</div>
					</div>
				</li>
<?php }?>
			</ul>
		</div>
	</li>
	<li>
		<!-- //좌메뉴 -->
		<div class="sub_cont">
		<ul>
			<li class="stats_wrap">
				<div class="box_wrap">
					<ul class="tab_menu">
						<li class="active"><h3>판매금액<a href="../statistic_sales/sales_sales" class="more">더보기</a></h3></li>
						<li><h3>회원<a href="../statistic_member/member_basic" class="more">더보기</a></h3></li>
						<li><h3>방문<a href="../statistic_visitor/visitor_basic" class="more">더보기</a></h3></li>
						<li><h3>유입경로</h3></li>
					</ul>
					<div class="tab_sub_wrap">
					<div class="data rank_priod">(2016.10.11~2016.10.20)</div>
					<div class="tab_sub tab_box1">
						<div id="chart1">
							<div class="nodata2">
								<span class="icon_nodata"></span> 최근 10일동안<br/>판매된 상품이 없습니다.
							</div>
						</div>
					</div>
					<div class="tab_sub tab_box2 ">
						<div id="chart2">
							<div class="nodata2">
								<span class="icon_nodata"></span>  최근 10일동안<br/>가입된 회원이 없습니다.
							</div>
						</div>
					</div>
					<div class="tab_sub tab_box3 ">
						<div id="chart3">
							<div class="nodata2">
								<span class="icon_nodata"></span> 최근 10일동안<br/>쇼핑몰로 방문한 데이터가 없습니다.
							</div>
						</div>
					</div>
					<div class="tab_sub tab_box4 ">
						<div class="inflow">
							<div id="chart4">
								<div class="nodata2">
									<span class="icon_nodata"></span> 최근 10일동안<br/>쇼핑몰로 유입된 데이터가 없습니다.
								</div>
							</div>
						</div>
<?php if(serviceLimit('H_FR')){?>
						<div class="free_upgrade2">
							<div class="nodata2">
								죄송합니다.<br/>
								본 기능은 상위버전으로<br/>
								업그레이드 후<br/>
								이용 가능합니다.
							</div>
							<div class="pdt5 center">
								<div class="resp_btn v3"  onclick="serviceUpgrade();">업그레이드 하기 <img src="/admin/skin/default/images/main/i_arrow2.png" class="ml5"></div>
							</div>
						</div>
<?php }?>
					</div>
				</div>
				</div>
			</li>

			<li class="board_wap">
				<div class="box_wrap">

						<ul class="tab_menu">
							<li class="active"><h3>공지사항<a href="https://www.firstmall.kr/ec_hosting/customer/notice.php" target="_blank" title="새창열림" class="more">더보기</a></h3></li>
							<li><h3>패치리스트<a href="https://www.firstmall.kr/ec_hosting/customer/patch.php" target="_blank" title="새창열림" class="more">더보기</a></h3></li>
							<li><h3>창업교육<a href="https://www.firstmall.kr/ec_hosting/education/index.php" target="_blank" title="새창열림" class="more">더보기</a></h3></li>
						</ul>

						<div class="tab_sub_wrap">
							<div class="tab_sub tab_box1">
								<ul id="print_main_news_notice_area"></ul>
							</div>

							<div class="tab_sub tab_box2">
								<ul id="print_main_news_upgrade_area"></ul>
							</div>

							<div class="tab_sub tab_box3">
								<ul class="edu" id="print_main_news_education_area"></ul>
							</div>
						</div>

				<!-- //게시판 -->
				</div>
			</li>
		</ul>
		</div>
	</li>
	<li>
		<?php echo getGabiaMainBannerPannel()?>

	</li>
</ul>
<!-- //메인 정보 -->

<!-- 비밀번호 변경 -->
<div id="popup_change_pass"></div>
<?php if($TPL_VAR["is_change_pass_required"]){?>
<script type="text/javascript">change_pass(true);</script>
<?php }elseif($TPL_VAR["is_change_pass"]){?>
<script type="text/javascript">change_pass();</script>
<?php }?>
<!-- 주요 이슈사항 공지 -->
<div id="notify_popup" style="padding:0px;"></div>

<div id="smsMyFirstmallInfo" class="hide">
	<img src="https://interface.firstmall.kr/firstmall_plus/images/sms/sms_aimg01.jpg" usemap="#smsFirstmallMap">
</div>

<div class="hide" id="facebookNotice">
<!-- //페이스북 관련 공지 18.02.28 kmj -->
<?php echo $TPL_VAR["facebook_notice"]["content"]?>

<div style="position:absolute; right:10px;">
	<input type="checkbox" id="fb_notice_view_check" /> <label for="fb_notice_view_check">일주일 동안 이 창을 열지 않음</label>
</div>
</div>

<?php if($TPL_VAR["config_basic"]["manual_view"]=='N'){?>
<div class="hide" id="firstmallGlManualPopup">
	<div style="width:800px; height:700px;">
		<iframe name="firstmall_manual" id="firstmall_manual" src="//interface.firstmall.kr/firstmall_manual/firstmall_gl_manual.php?service_code=<?php echo $TPL_VAR["service_code"]?>" width="800px" height="700px" frameborder="0" allowTransparency="true"></iframe>
	</div>
	<div style="bottom:0px; width:800px; background:#666; text-indent:20px; color:#fff; line-height:30px;">
		<input type="checkbox" id="manual_view_check" /> <label for="manual_view_check">다시 보지 않기</label>
	</div>
</div>
<?php }?>

<map name="smsFirstmallMap">
	<area shape="rect" coords="0,30,172,72" href="#" onclick="window.open('https://firstmall.kr/myshop/sms/sms_send_phone.php?num=<?php echo $TPL_VAR["config_system"]["shopSno"]?>');" title="" target="_blank"/>
</map>

<!-- 메인 팝업 : START -->
<?php echo $TPL_VAR["main_popup"]?>

<!-- 메인 팝업 : END -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>