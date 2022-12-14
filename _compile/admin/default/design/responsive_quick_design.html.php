<?php /* Template_ 2.2.6 2021/11/16 10:51:12 /www/music_brother_firstmall_kr/admin/skin/default/design/responsive_quick_design.html 000053687 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<link href="//fonts.googleapis.com/css?family=Noto+Sans+KR:100,300,400,500,700&amp;subset=korean" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/quick_design/black-tie/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/slick/slick.css"><!-- 반응형 슬라이드 -->
<link rel="stylesheet" type="text/css" href="/data/design/goods_info_style.css"><!-- 상품디스플레이 CSS -->
<link rel="stylesheet" type="text/css" href="/data/design/goods_info_user.css"><!-- ++++++++++++ 상품디스플레이 사용자/제작자 CSS ++++++++++++ -->
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/quick_design/lib.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/quick_design/common.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/quick_design/board.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/quick_design/buttons.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/quick_design/mobile_pagination.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/quick_design/quickdesign.css" />
<style type="text/css" id="sample_css">
/* 
	[삭제금지] 선택한 테마 색상에 따라 동적으로 샘플 테마 스타일을 변경하는 영역입니다.	
*/
</style>

<form id="quickFrm" name="quickFrm" action="../design_process/responsive_quick_design" method="post" onsubmit="return quick_design_submit();">
<div id="wrap" style="padding: 10px;">

	<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ 탭 ++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
	<div id="quickDesignTab" class="tab_basic">
		<ul style="width:100%; table-layout:fixed;">
			<li class="on"><a href="#quickThemeSetting" value="theme">테마 적용</a></li>
			<li><a href="#quickDetailSetting" value="detail">상세 적용</a></li>
		</ul>
	</div>
	<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ //탭 ++++++++++++++++++++++++++++++++++++++++++++++++++++ -->


	<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ 테마 선택 ++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
	<div id="quickThemeSetting" class="quickDesignDetail quick_wrap">
		<!-- 테마 선택 -->
		<div id="quickThemeSelect" class="quick_theme_select">
			<label class="theme_color theme_basic <?php if($TPL_VAR["theme"]=='basic'){?>on<?php }?>"><input type="radio" name="quick_theme_select" value="basic" <?php if($TPL_VAR["theme"]=='basic'){?>checked<?php }?> /> <b style="background:#333;"></b>기본</label>
			<label class="theme_color theme_red <?php if($TPL_VAR["theme"]=='red'){?>on<?php }?>"><input type="radio" name="quick_theme_select" value="red" <?php if($TPL_VAR["theme"]=='red'){?>checked<?php }?> /> <b style="background:#df2929;"></b>레드</label>
			<label class="theme_color theme_pink <?php if($TPL_VAR["theme"]=='pink'){?>on<?php }?>"><input type="radio" name="quick_theme_select" value="pink" <?php if($TPL_VAR["theme"]=='pink'){?>checked<?php }?> /> <b style="background:#ff7e8f;"></b>핑크</label>
			<label class="theme_color theme_orange <?php if($TPL_VAR["theme"]=='orange'){?>on<?php }?>"><input type="radio" name="quick_theme_select" value="orange" <?php if($TPL_VAR["theme"]=='orange'){?>checked<?php }?> /> <b style="background:#f7782c;"></b>오렌지</label>
			<label class="theme_color theme_yellow <?php if($TPL_VAR["theme"]=='yellow'){?>on<?php }?>"><input type="radio" name="quick_theme_select" value="yellow" <?php if($TPL_VAR["theme"]=='yellow'){?>checked<?php }?> /> <b style="background:#;F79F1F"></b>엘로우</label>
			<label class="theme_color theme_brown <?php if($TPL_VAR["theme"]=='brown'){?>on<?php }?>"><input type="radio" name="quick_theme_select" value="brown" <?php if($TPL_VAR["theme"]=='brown'){?>checked<?php }?> /> <b style="background:#906240;"></b>브라운</label>
			<label class="theme_color theme_yellowgreen <?php if($TPL_VAR["theme"]=='yellowgreen'){?>on<?php }?>"><input type="radio" name="quick_theme_select" value="yellowgreen" <?php if($TPL_VAR["theme"]=='yellowgreen'){?>checked<?php }?> /> <b style="background:#99b242;"></b>옐로우그린</label>
			<label class="theme_color theme_green <?php if($TPL_VAR["theme"]=='green'){?>on<?php }?>"><input type="radio" name="quick_theme_select" value="green" <?php if($TPL_VAR["theme"]=='green'){?>checked<?php }?> /> <b style="background:#218c74;"></b>그린</label>
			<label class="theme_color theme_bluegrey <?php if($TPL_VAR["theme"]=='bluegrey'){?>on<?php }?>"><input type="radio" name="quick_theme_select" value="bluegrey" <?php if($TPL_VAR["theme"]=='bluegrey'){?>checked<?php }?> /> <b style="background:#778ca3;"></b>블루그레이</label>
			<label class="theme_color theme_blue <?php if($TPL_VAR["theme"]=='blue'){?>on<?php }?>"><input type="radio" name="quick_theme_select" value="blue" <?php if($TPL_VAR["theme"]=='blue'){?>checked<?php }?> /> <b style="background:#0097e6;"></b>블루</label>
			<label class="theme_color theme_navy <?php if($TPL_VAR["theme"]=='navy'){?>on<?php }?>"><input type="radio" name="quick_theme_select" value="navy" <?php if($TPL_VAR["theme"]=='navy'){?>checked<?php }?> /> <b style="background:#273c75;"></b>네이비</label>
			<label class="theme_color theme_violet <?php if($TPL_VAR["theme"]=='violet'){?>on<?php }?>"><input type="radio" name="quick_theme_select" value="violet" <?php if($TPL_VAR["theme"]=='violet'){?>checked<?php }?> /> <b style="background:#8854d0;"></b>바이올렛</label>
			<span class="custom_theme">
				<div class="theme_color theme_custom <?php if($TPL_VAR["theme"]=='custom'){?>on<?php }?>">
					<input type="radio" name="quick_theme_select" id="custom_color_radio" value="custom" <?php if($TPL_VAR["theme"]=='custom'){?>checked<?php }?>/>
					<input type="text" name="quick_theme_color" class="custom_colorpicker" <?php if($TPL_VAR["theme"]=='custom'){?>value="<?php echo $TPL_VAR["colors"]["main_color"]?>"<?php }?> readonly="readonly" style="display: none;">
				</div>
				<a href="javascript:void(0)" onclick="customColorSelect();">사용자지정</a>
			</span>
		</div>

		<p class="text_quick_sample"><b>아래는 예시 영역별 미리보기입니다.</b></p>

		<!-- 카테고리 네비게이션 -->
		<h3 class="title_quick2 Mt25"><b>카테고리 네비게이션</b></h3>
		<div id="layout_header" class="layout_header">
			<div class="nav_wrap">
				<div class="resp_wrap">
					<div class="nav_category_area">
						<div class="designCategoryNavigation">
							<ul class="respCategoryList">
								<li class="nav_category_all">
									<a class="hand categoryAllBtn" title="전체 카테고리">ALL</a>
								</li>
								<li class="categoryDepth1">
									<a class="categoryDepthLink" href="#"><em>의류</em></a>
								</li>
								<li class="categoryDepth1 on">
									<a class="categoryDepthLink" href="#"><em>유아동</em></a>
								</li>
								<li class="categoryDepth1">
									<a class="categoryDepthLink" href="#"><em>화장품</em></a>
								</li>
								<li class="custom_nav_link">
									<a class="categoryDepthLink" href="#"><em>NEW</em></a>
								</li>
								<li class="custom_nav_link">
									<a class="categoryDepthLink" href="#"><em>BEST</em></a>
								</li>
								<li class="custom_nav_link">
									<a class="categoryDepthLink" href="#"><em>BRANDS</em></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div id="layout_body" class="layout_body">

			<ul class="theme_preview_layout">
				<li class="left_aaa">
					<!-- 어사이드/마이쇼핑/고객센터 - LNB 활성화 메뉴 -->
					<h3 class="title_quick2"><b>어사이드/마이쇼핑/고객센터 - LNB</b></h3>
					<div class="subpage_lnb Clearfix">
						<div class="aside_navigation_wrap" style="float:left; width:50%; box-sizing:border-box; padding-right:10px;">
							<ul class="menu" style="display: block;">
								<li class="mitem category mitem_category mitemicon1 on mitemicon2">
									<a class="mitem_title"></a>
									<a class="mitem_goodsview" href="#">의류</a>
									<a class="mitem_favorite mitem_favorite_on"></a>
								</li>
								<li class="mitem_subcontents" style="display: list-item;">
									<ul class="submenu">
										<li class="submitem category">
											<a class="submitem_title"></a>
											<a class="mitem_goodsview" href="#">탑</a>
											<a class="mitem_favorite "></a>
										</li>
										<li class="submitem category on">
											<a class="submitem_title"></a>
											<a class="mitem_goodsview" href="#">아우터</a>
											<a class="mitem_favorite "></a>
										</li>
										<li class="submitem category">
											<a class="submitem_title"></a>
											<a class="mitem_goodsview" href="#">드레스</a>
											<a class="mitem_favorite "></a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
						<div style="float:left; width:50%; box-sizing:border-box; padding-left:10px;">
							<h3 class="title2 Mt5"><a href="#">나의 쇼핑</a></h3>
							<ul class="lnb_sub">
								<li class="on"><a href="#">주문/배송</a></li>
								<li><a href="#">반품/교환</a></li>
								<li><a href="#">취소/환불</a></li>
							</ul>
						</div>
					</div>
				</li>
				<li class="right_aaa">
					<!-- 푸시 카운트 -->
					<h3 class="title_quick2"><b>푸시 카운트</b></h3>
					<div class="Clearfix">
						<div class="asie_main_menu" style="float:left; width:280px;">
							<ul>
								<li class="am_home"><a href="#">홈</a></li>
								<li class="am_order"><a href="#"><span>주문조회</span> <span class="push_count" title="무료/취소/완료 제외한 수">14</span></a></li>
								<li class="am_my">
									<a href="#"><span>MY쇼핑</span></a>
								</li>
								<li class="am_cs"><a href="#">1:1문의</a></li>
								<li class="am_cart"><a href="#"><span>장바구니</span> <span class="push_count">4</span></a></li>
								<li class="am_wish">
									<a href="#"><span>위시리스트</span> <span class="push_count">5</span></a>
								</li>
								<li class="am_coupon"><a href="#">쿠폰</a></li>
								<li class="am_emony"><a href="#">캐시</a></li>
							</ul>
						</div>
						<ul class="my_order_step" style="float:right;">
							<li class="step1" style="width:100px;"><a href="#"><span>주문접수</span><span class="pushCount">2</span></a></li>
							<li class="step2" style="width:100px;"><a href="#"><span>결제확인</span><span class="pushCount">3</span></a></li>
						</ul>
					</div>
				</li>
			</ul>

			<ul class="theme_preview_layout">
				<li class="left_aaa">
					<!-- 상품 정보 -->
					<h3 class="title_quick2"><b>판매가/할인적용 금액/총 결제금액</b></h3>
					<div class="Clearfix">
						<div class="searched_item_display" style="float:left; width:calc( 50% - 10px )">
							<ul>
								<li style="width:100%; padding-top:0;">
									<ul class="item_info_area">
										<li class="displaY_color_option">
											<span class="areA border" style="background-color:#FFFFFF;"></span> <span class="areA" style="background-color:#6b4d32;"></span> <span class="areA" style="background-color:#b89f88;"></span> <span class="areA" style="background-color:#ebd8c1;"></span>
										</li>
										<li class="goods_name_area">
											<a href="#"><span class="name">모든 디바이스에서 최적화 UI</span></a>
										</li>
										<li class="goods_desc_area">
											퍼스트몰 반응형 스킨은 고객이...
										</li>
										<li class="goods_price_area">
											<span class="sale_price">
												<b class="num">18,000</b>원
											</span>
											<span class="consumer_price">
												<span class="num">26,000</span>원
											</span>
											<span class="discount_rate">
												<b class="num">31</b>%
											</span>
										</li>
									</ul>
								</li>
							</ul>
						</div>
						<div class="display_responsible_class" style="float:right; width:calc( 50% - 10px )">
							<ul class="goods_list goods_info_style_1">
								<li class="gl_item" style="width:100%; padding-top:0;">
								<div class="gl_inner_item_wrap">
									<div class="resp_display_goods_info infO_style_1">

										<!-- 상품명-->
										<div class="goodS_info displaY_goods_name">
											<span class="areA"><a href="#">편리한 검색 모듈 제공2</a></span>
										</div>

										<div class="infO_group">
											<!-- 비회원 대체문구 -->
											<!-- (할인혜택)판매가 -->
											<div class="goodS_info displaY_sales_price">
												<span class="areA">
													<span class="nuM">90,000</span>₩
												</span>
											</div>

											<!-- 정가 -->
											<div class="goodS_info displaY_consumer_price">
												<span class="areA">
													<span class="nuM">90,000</span>₩
												</span>
											</div>

											<!-- 할인율 -->
											<div class="goodS_info displaY_sales_percent">
												<span class="areA"><span class="nuM">27</span>%</span>
											</div>
										</div>

										<div class="infO_group">
											<!-- 무료배송 -->
											<div class="goodS_info displaY_besong typE_a">
												<span class="areA">무료배송</span>
											</div>
										</div>
									</div>
								</div>
							  </li>
							</ul>
						</div>
					</div>
				</li>
				<li class="right_aaa">
					<!-- BEST 페이지 - Rank 1위, 2위, 3위 -->
					<h3 class="title_quick2"><b>BEST 페이지 랭크</b></h3>
					<div id="searchedItemDisplay" class="searched_item_display best_page_ranking">
						<ul style="margin-left:-10px;">
							<li style="padding:10px 0 0 10px;">
								<div class="item_img_area">
									<a href="#"><img src="/admin/skin/default/images/quick_design/sample_goods01.jpg" onerror="this.src='/admin/skin/default/images/common/noimage.gif';" alt=""></a>
								<div class="item_rank"><span class="num">1</span>위</div></div>
							</li>
							<li style="padding:10px 0 0 10px;">
								<div class="item_img_area">
									<a href="#"><img src="/admin/skin/default/images/quick_design/sample_goods02.jpg" onerror="this.src='/admin/skin/default/images/common/noimage.gif';" alt=""></a>
								<div class="item_rank"><span class="num">2</span>위</div></div>
							</li>
							<li style="padding:10px 0 0 10px;">
								<div class="item_img_area">
									<a href="#"><img src="/admin/skin/default/images/quick_design/sample_goods03.jpg" onerror="this.src='/admin/skin/default/images/common/noimage.gif';" alt=""></a>
								<div class="item_rank"><span class="num">3</span>위</div></div>
							</li>
							<li style="padding:10px 0 0 10px;">
								<div class="item_img_area">
									<a href="#"><img src="/admin/skin/default/images/quick_design/sample_goods04.jpg" onerror="this.src='/admin/skin/default/images/common/noimage.gif';" alt=""></a>
								<div class="item_rank"><span class="num">4</span>위</div></div>
							</li>
						</ul>
					</div>
				</li>
			</ul>

			<ul class="theme_preview_layout">
				<li class="left_aaa">
					<!-- 상품 상세 정보 -->
					<h3 class="title_quick2"><b>상품 상세 정보</b></h3>
					<div id="goods_spec">
						<ul class="goods_spec_sections">
							<!-- ~~~~~ 단독 이벤트 ~~~~~ -->
							<li class="spec_solo_event">
								<ul class="list">
									<li class="remain_time">
										<span class="title"></span>
										<div class="event_datetime_box">
											<span class="num2" id="soloday425">6</span><span class="day">일</span>
											<span class="num2" id="solohour425">12</span> :
											<span class="num2" id="solomin425">21</span> :
											<span class="num2" id="solosecond425">32</span>
										</div>
									</li>
								</ul>
							</li>
							<!-- ~~~~~ 가격, 할인율, 할인내역 ~~~~~ -->
							<li class="deatil_price_area Mt0 Pt0">
								<div class="deatil_sale_rate">
									<p class="inner">
										<span class="num">38</span>%
									</p>
								</div>
								<p class="org_price">
									<span class="dst_th_size"><s><span class="num">26,000</span></s>원</span>
								</p>
								<p class="sale_price">
									<span class="num">16,200</span><span class="price_won">원</span>
								</p>
								<button type="button" class="btn_open_small btn_resp B"><span>혜택보기</span></button>
							</li>
							<!-- ~~~~~ //가격, 할인율, 할인내역 ~~~~~ -->

							<!-- ~~~~~ 상품후기 ~~~~~ -->
							<li class="goods_spec_customer_ev">
								<ul class="detail_spec_table">
									<li class="th"><span>상품후기</span></li>
									<li>
										1<span>명</span>&nbsp;
										<span class="ev_active2"><b style="width:70%;"></b></span>
										<span class="desc">(<span class="gray_01">3.5</span>/5)</span>
									</li>
								</ul>
							</li>
							<!-- ~~~~~ //상품후기 ~~~~~ -->
						</ul>

						<!-- ~~~~~~~~~~~ 구매하기 ~~~~~~~~~~~ -->
						<div id="goodsOptionBuySection" class="goods_buy_sections">
							<!-- 총 상품 금액 표기 시작-->
							<div class="goods_price_area">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tbody><tr>
									<!-- 단일옵션일 경우 수량 -->
									<td class="total_goods_price">
										<span class="total_goods_tit">총 상품금액</span>
										<span id="total_goods_price">16,200</span> 원
									</td>
								</tr>
								</tbody></table>
							</div>
							<!-- 총 상품 금액 표기 끝-->

							<div class="goods_buttons_area">
								<ul class="goods_buttons_section">
									<li>
										<ul class="basic_btn_area">
											<li><button type="button" name="addCart" id="addCart" class="btn_resp size_extra2 NpayNo"><span >장바구니</span></button></li>
											<li><button type="button" id="buy" class="btn_resp size_extra2 color2 NpayNo"><span>구매하기</span></button></li>
										</ul>
									</li>
								</ul>
							</div>
						</div>
						<div class="goods_bg"></div>
						<!-- ~~~~~~~~~~~ //구매하기 ~~~~~~~~~~~ -->

						<!-- 오프라인 쿠폰 -->
						<div class="coupon_area Pt20">
							<ul class="resp_coupon_list">
								<li class="couponDownload resStyle">
									<ul>
										<li class="text">
											<div class="title">할인 쿠폰 1</div>
											<div class="descr">10월 31일 까지 사용가능</div>
										</li>
										<li class="sales">
											<div class="coupon_img">
												<span class="num">20</span>%
											</div>
										</li>
										<li class="bul"></li>
									</ul>
								</li>
							</ul>
						</div>
						<!-- //오프라인 쿠폰 -->
					</div>
				</li>
				<li class="right_aaa">
					<!-- 주요 버튼 컬러 -->
					<h3 class="title_quick2"><b>주요 버튼 컬러</b></h3>
					<button type="button" class="data_save_btn btn_resp size_c color2">저장</button>
					<button type="button" class="btn_resp size_c color2">회원가입</button>
					<button type="button" class="btn_resp size_c color2">전체 주문하기</button>
					<input type="button" value="결제하기" name="button_pay" id="pay" class="btn_resp size_extra color2" />

					<!-- 게시판 상세페이지 - 현재글 -->
					<h3 class="title_quick2"><b>게시판 상세페이지 - 현재글</b></h3>
					<div class="res_table">
						<ul class="thead">
							<li style="width:48px;"><span>번호</span></li>
							<li style="width:80px;"><span>분류</span></li>
							<li><span>제목</span></li>
							<li class="Hide" style="width:100px;"><span>작성자</span></li>
							<li style="width:100px;"><span>등록일</span></li>
							<li style="width:45px;"><span>조회</span></li>
						</ul>
						<ul class="tbody">
							<li class="mo_hide"><span class="mtitle">번호:</span> 3</li>
							<li><span class="cat">[공지]</span></li>
							<li class="subject">
								<span class="hand boad_view_btn">
									 반응형 스킨 오픈이 다가오고 있습니다
								</span>
							</li>
							<li class="Hide"><img src="/admin/skin/default/images/board/icon/icon_admin.gif" id="icon_admin_img" align="absmiddle" style="vertical-align:middle;"></li>
							<li>2018.09.28</li>
							<li><span class="mtitle">조회:</span> 26</li>
						</ul>
						<ul class="tbody now_list">
							<li class="mo_hide"><span class="mtitle">번호:</span>  <span class="now">현재글</span> </li>
							<li> <span class="cat">[공지]</span></li>
							<li class="subject">
								<span class="hand boad_view_btn">
									 공지글 아닌 공지 테스트
								</span>
							</li>
							<li class="Hide"><img src="/admin/skin/default/images/board/icon/icon_admin.gif" id="icon_admin_img" align="absmiddle" style="vertical-align:middle;"></li>
							<li>2018.09.28</li>
							<li><span class="mtitle">조회:</span> 12</li>
						</ul>
						<ul class="tbody">
							<li class="mo_hide"><span class="mtitle">번호:</span> 1</li>
							<li> <span class="cat">[긴급공지]</span></li>
							<li class="subject">
								<span class="hand boad_view_btn">
									 공지글인 긴급 공지 테스트 2
								</span>
							</li>
							<li class="Hide"><img src="/admin/skin/default/images/board/icon/icon_admin.gif" id="icon_admin_img" align="absmiddle" style="vertical-align:middle;"></li>
							<li>2018.09.11</li>
							<li><span class="mtitle">조회:</span> 28</li>
						</ul>
					</div>
				</li>
			</ul>

			<!-- 페이징 -->
			<h3 class="title_quick2"><b>페이징</b></h3>
			<div class="paging_navigation_pop">
				<a href="#" class="first"></a><a href="#" class="prev"></a>
				<a href="#">6</a>
				<a href="#">7</a>
				<a href="#" class="on"><b>8</b></a>
				<a href="#">9</a>
				<a href="#">10</a>
				<a href="#" class="next"></a><a href="#" class="last"></a>
			</div>

		</div>
	</div>
	<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ //테마 선택 ++++++++++++++++++++++++++++++++++++++++++++++++++++ -->


	<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ 상세 설정 ++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
	<div id="quickDetailSetting" class="quickDesignDetail quick_wrap" style="display:none;">

		<ul class="quick_setting_container Pt10">
			<li class="Pt0 Pb0">
				<p class="text_quick_sample Mb0"><b>아래는 예시 영역별 미리보기입니다.</b></p>
			</li>
			<li class="Pt0 Pb0 Relative">
				<p class="q_color_g2">컬러를 <span class="Dib">지정하세요.</span></p>
			</li>
		</ul>
		<!-- 카테고리 네비게이션 -->
		<ul class="quick_setting_container">
			<li>
				<div id="layout_header" class="layout_header">
					<div class="nav_wrap">
						<div class="resp_wrap">
							<div class="nav_category_area">
								<div class="designCategoryNavigation">
									<ul class="respCategoryList">
										<li class="nav_category_all">
											<a class="hand categoryAllBtn" title="전체 카테고리">ALL</a>
										</li>
										<li class="categoryDepth1">
											<a class="categoryDepthLink" href="#"><em>의류</em></a>
										</li>
										<li class="categoryDepth1 on">
											<a class="categoryDepthLink" href="#"><em>유아동</em></a>
										</li>
										<li class="categoryDepth1">
											<a class="categoryDepthLink" href="#"><em>화장품</em></a>
										</li>
										<li class="custom_nav_link">
											<a class="categoryDepthLink" href="#"><em>NEW</em></a>
										</li>
										<li class="custom_nav_link">
											<a class="categoryDepthLink" href="#"><em>BEST</em></a>
										</li>
										<li class="custom_nav_link">
											<a class="categoryDepthLink" href="#"><em>BRANDS</em></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
			<li>
				<table cellpadding="0" cellspacing="0" class="quick_setting_table">
				<tbody>
					<tr>
						<th rowspan="3"><p>카테고리 네비게이션</p></th>
						<th rowspan="2"><p>활성화 메뉴</p></th>
						<th><p>라인</p></th>
						<td>
							<input type="text" name="gnb_active_line" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["gnb_active_line"]?>" readonly="readonly" style="display: none;">
						</td>
					</tr>
					<tr>
						<th><p>텍스트</p></th>
						<td>
							<input type="text" name="gnb_active_text" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["gnb_active_text"]?>" readonly="readonly" style="display: none;">
						</td>
					</tr>
					<tr>
						<th colspan="2"><p>서브 메뉴</p></th>
						<td>
							<input type="text" name="gnb_submenu" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["gnb_submenu"]?>" readonly="readonly" style="display: none;">
						</td>
					</tr>
				</tbody>
				</table>
			</li>
		</ul>


		<div id="layout_body" class="layout_body">

			<!-- 어사이드/마이쇼핑/고객센터 - LNB 활성화 메뉴 -->
			<ul class="quick_setting_container">
				<li>
					<div class="subpage_lnb Clearfix">
						<div class="aside_navigation_wrap" style="float:left; width:50%; box-sizing:border-box; padding-right:10px;">
							<ul class="menu" style="display: block;">
								<li class="mitem category mitem_category mitemicon1 on mitemicon2">
									<a class="mitem_title"></a>
									<a class="mitem_goodsview" href="#">의류</a>
									<a class="mitem_favorite mitem_favorite_on"></a>
								</li>
								<li class="mitem_subcontents" style="display: list-item;">
									<ul class="submenu">
										<li class="submitem category">
											<a class="submitem_title"></a>
											<a class="mitem_goodsview" href="#">탑</a>
											<a class="mitem_favorite "></a>
										</li>
										<li class="submitem category on">
											<a class="submitem_title"></a>
											<a class="mitem_goodsview" href="#">아우터</a>
											<a class="mitem_favorite "></a>
										</li>
										<li class="submitem category">
											<a class="submitem_title"></a>
											<a class="mitem_goodsview" href="#">드레스</a>
											<a class="mitem_favorite "></a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
						<div style="float:left; width:50%; box-sizing:border-box; padding-left:10px;">
							<h3 class="title2 Mt5"><a href="#">나의 쇼핑</a></h3>
							<ul class="lnb_sub">
								<li class="on"><a href="#">주문/배송</a></li>
								<li><a href="#">반품/교환</a></li>
								<li><a href="#">취소/환불</a></li>
							</ul>
						</div>
					</div>
				</li>
				<li>
					<table cellpadding="0" cellspacing="0" class="quick_setting_table">
					<tbody>
						<tr>
							<th><p>어사이드/마이쇼핑/고객센터 - LNB 활성화 메뉴</p></th>
							<td>
								<input type="text" name="lnb_active_text" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["lnb_active_text"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
					</tbody>
					</table>
				</li>
			</ul>

			<!-- 상품 정보 -->
			<ul class="quick_setting_container">
				<li>
					<div class="Clearfix">
						<div class="searched_item_display" style="float:left; width:calc( 50% - 10px )">
							<ul>
								<li style="width:100%; padding-top:0;">
									<ul class="item_info_area">
										<li class="displaY_color_option">
											<span class="areA border" style="background-color:#FFFFFF;"></span> <span class="areA" style="background-color:#6b4d32;"></span> <span class="areA" style="background-color:#b89f88;"></span> <span class="areA" style="background-color:#ebd8c1;"></span>
										</li>
										<li class="goods_name_area">
											<a href="#"><span class="name">모든 디바이스에서 최적화 UI</span></a>
										</li>
										<li class="goods_desc_area">
											퍼스트몰 반응형 스킨은 고객이 어떠한...
										</li>
										<li class="goods_price_area">
											<span class="sale_price">
												<b class="num">18,000</b>원
											</span>
											<span class="consumer_price">
												<span class="num">26,000</span>원
											</span>
											<span class="discount_rate">
												<b class="num">31</b>%
											</span>
										</li>
									</ul>
								</li>
							</ul>
						</div>

						<div class="display_responsible_class" style="float:right; width:calc( 50% - 10px )">
							<ul class="goods_list goods_info_style_1">
								<li class="gl_item" style="width:100%; padding-top:0;">
								<div class="gl_inner_item_wrap">
									<div class="resp_display_goods_info infO_style_1">

										<!-- 상품명-->
										<div class="goodS_info displaY_goods_name">
											<span class="areA"><a href="#">편리한 검색 모듈 제공2</a></span>
										</div>

										<div class="infO_group">
											<!-- 비회원 대체문구 -->
											<!-- (할인혜택)판매가 -->
											<div class="goodS_info displaY_sales_price">
												<span class="areA">
													<span class="nuM">90,000</span>₩
												</span>
											</div>

											<!-- 정가 -->
											<div class="goodS_info displaY_consumer_price">
												<span class="areA">
													<span class="nuM">90,000</span>₩
												</span>
											</div>

											<!-- 할인율 -->
											<div class="goodS_info displaY_sales_percent">
												<span class="areA"><span class="nuM">27</span>%</span>
											</div>
										</div>

										<div class="infO_group">
											<!-- 무료배송 -->
											<div class="goodS_info displaY_besong typE_a">
												<span class="areA">무료배송</span>
											</div>
										</div>
									</div>
								</div>
							  </li>
							</ul>
						</div>
					</div>
				</li>
				<li>
					<table cellpadding="0" cellspacing="0" class="quick_setting_table">
					<tbody>
						<tr>
							<th><p>판매가/할인적용 금액/총 결제금액</p></th>
							<td>
								<input type="text" name="sale_price" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["sale_price"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th><p>할인율</p></th>
							<td>
								<input type="text" name="basic_sale_rate" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["basic_sale_rate"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
					</tbody>
				</table>
				</li>
			</ul>

			<!-- 상품 상세 정보 -->
			<ul class="quick_setting_container">
				<li>
					<div id="goods_spec">
						<ul class="goods_spec_sections">
							<!-- ~~~~~ 단독 이벤트 ~~~~~ -->
							<li class="spec_solo_event">
								<ul class="list">
									<li class="remain_time">
										<span class="title"></span>
										<div class="event_datetime_box">
											<span class="num2" id="soloday425">6</span><span class="day">일</span>
											<span class="num2" id="solohour425">12</span> :
											<span class="num2" id="solomin425">21</span> :
											<span class="num2" id="solosecond425">32</span>
										</div>
									</li>
								</ul>
							</li>
							<!-- ~~~~~ 가격, 할인율, 할인내역 ~~~~~ -->
							<li class="deatil_price_area Mt0 Pt0">
								<div class="deatil_sale_rate">
									<p class="inner">
										<span class="num">38</span>%
									</p>
								</div>
								<p class="org_price">
									<span class="dst_th_size"><s><span class="num">26,000</span></s>원</span>
								</p>
								<p class="sale_price">
									<span class="num">16,200</span><span class="price_won">원</span>
								</p>
								<button type="button" class="btn_open_small btn_resp B"><span>혜택보기</span></button>
							</li>
							<!-- ~~~~~ //가격, 할인율, 할인내역 ~~~~~ -->

							<!-- ~~~~~ 상품후기 ~~~~~ -->
							<li class="goods_spec_customer_ev">
								<ul class="detail_spec_table">
									<li class="th"><span>상품후기</span></li>
									<li>
										1<span>명</span>&nbsp;
										<span class="ev_active2"><b style="width:70%;"></b></span>
										<span class="desc">(<span class="gray_01">3.5</span>/5)</span>
									</li>
								</ul>
							</li>
							<!-- ~~~~~ //상품후기 ~~~~~ -->
						</ul>

						<!-- ~~~~~~~~~~~ 구매하기 ~~~~~~~~~~~ -->
						<div id="goodsOptionBuySection" class="goods_buy_sections">
							<!-- 총 상품 금액 표기 시작-->
							<div class="goods_price_area">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tbody><tr>
									<!-- 단일옵션일 경우 수량 -->
									<td class="total_goods_price">
										<span class="total_goods_tit">총 상품금액</span>
										<span id="total_goods_price">16,200</span> 원
									</td>
								</tr>
								</tbody></table>
							</div>
							<!-- 총 상품 금액 표기 끝-->

							<div class="goods_buttons_area">
								<ul class="goods_buttons_section">
									<li>
										<ul class="basic_btn_area">
											<li><button type="button" name="addCart" id="addCart" class="btn_resp size_extra2 NpayNo"><span>장바구니</span></button></li>
											<li><button type="button" id="buy" class="btn_resp size_extra2 color2 NpayNo"><span>구매하기</span></button></li>
										</ul>
									</li>
								</ul>
							</div>
						</div>
						<div class="goods_bg"></div>
						<!-- ~~~~~~~~~~~ //구매하기 ~~~~~~~~~~~ -->

						<!-- 오프라인 쿠폰 -->
						<div class="coupon_area Pt20">
							<ul class="resp_coupon_list">
								<li class="couponDownload resStyle">
									<ul>
										<li class="text">
											<div class="title">할인 쿠폰 1</div>
											<div class="descr">10월 31일 까지 사용가능</div>
										</li>
										<li class="sales">
											<div class="coupon_img">
												<span class="num">20</span>%
											</div>
										</li>
										<li class="bul"></li>
									</ul>
								</li>
							</ul>
						</div>
						<!-- //오프라인 쿠폰 -->
					</div>
				</li>
				<li>
					<table cellpadding="0" cellspacing="0" class="quick_setting_table">
					<tbody>
						<tr>
							<th rowspan="3" colspan="2"><p>단독이벤트</p></th>
							<th><p>아이콘</p></th>
							<td>
								<input type="text" name="solo_event_icon" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["solo_event_icon"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th><p>배경</p></th>
							<td>
								<input type="text" name="solo_event_bg" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["solo_event_bg"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th><p>텍스트</p></th>
							<td>
								<input type="text" name="solo_event_text" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["solo_event_text"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th colspan="3"><p>평점 별 색상</p></th>
							<td>
								<input type="text" name="review_score" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["review_score"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th rowspan="2"><p>상품상세</p></th>
							<th rowspan="2"><p>할인율</p></th>
							<th><p>배경</p></th>
							<td>
								<input type="text" name="deatil_sale_rate_bg" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["deatil_sale_rate_bg"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th><p>텍스트</p></th>
							<td>
								<input type="text" name="deatil_sale_rate_text" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["deatil_sale_rate_text"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th colspan="3"><p>쿠폰 버튼 컬러</p></th>
							<td>
								<input type="text" name="coupon_btn" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["coupon_btn"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
					</tbody>
					</table>
				</li>
			</ul>

			<!-- 주요 버튼 컬러 -->
			<ul class="quick_setting_container">
				<li>
					<button type="button" class="data_save_btn btn_resp size_c color2">저장</button>
					<button type="button" class="btn_resp size_c color2">회원가입</button>
					<button type="button" class="btn_resp size_c color2">전체 주문하기</button>
					<input type="button" value="결제하기" name="button_pay" id="pay" class="btn_resp size_extra color2" />
				</li>
				<li>
					<table cellpadding="0" cellspacing="0" class="quick_setting_table">
					<tbody>
						<tr>
							<th rowspan="3"><p>주요 버튼 컬러</p></th>
							<th style="width:80px;"><p>라인</p></th>
							<td>
								<input type="text" name="major_button_line" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["major_button_line"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th style="width:80px;"><p>배경</p></th>
							<td>
								<input type="text" name="major_button_bg" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["major_button_bg"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th style="width:80px;"><p>텍스트</p></th>
							<td>
								<input type="text" name="major_button_text" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["major_button_text"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
					</tbody>
				</table>
				</li>
			</ul>



			<!-- 푸시 카운트 -->
			<ul class="quick_setting_container">
				<li>
					<div class="Clearfix">
						<div class="asie_main_menu" style="float:left; width:280px;">
							<ul>
								<li class="am_home"><a href="#">홈</a></li>
								<li class="am_order"><a href="#"><span>주문조회</span> <span class="push_count" title="무료/취소/완료 제외한 수">14</span></a></li>
								<li class="am_my">
									<a href="#"><span>MY쇼핑</span></a>
								</li>
								<li class="am_cs"><a href="#">1:1문의</a></li>
								<li class="am_cart"><a href="#"><span>장바구니</span> <span class="push_count">4</span></a></li>
								<li class="am_wish">
									<a href="#"><span>위시리스트</span> <span class="push_count">5</span></a>
								</li>
								<li class="am_coupon"><a href="#">쿠폰</a></li>
								<li class="am_emony"><a href="#">캐시</a></li>
							</ul>
						</div>
						<ul class="my_order_step" style="float:right;">
							<li class="step1" style="width:100px;"><a href="#"><span>주문접수</span><span class="pushCount">2</span></a></li>
							<li class="step2" style="width:100px;"><a href="#"><span>결제확인</span><span class="pushCount">3</span></a></li>
						</ul>
					</div>
				</li>
				<li>
					<table cellpadding="0" cellspacing="0" class="quick_setting_table">
					<tbody>
						<tr>
							<th rowspan="2"><p>푸시 카운트</p></th>
							<th style="width:80px;"><p>배경</p></th>
							<td>
								<input type="text" name="push_count_bg" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["push_count_bg"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th style="width:80px;"><p>텍스트</p></th>
							<td>
								<input type="text" name="push_count_text" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["push_count_text"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
					</tbody>
				</table>
				</li>
			</ul>


			<!-- BEST 페이지 랭크 - 1위, 2위, 3위 -->
			<ul class="quick_setting_container">
				<li>
					<div id="searchedItemDisplay" class="searched_item_display best_page_ranking">
						<ul style="margin-left:-10px;">
							<li style="padding:10px 0 0 10px;">
								<div class="item_img_area">
									<a href="#"><img src="/admin/skin/default/images/quick_design/sample_goods01.jpg" onerror="this.src='/admin/skin/default/images/common/noimage.gif';" alt=""></a>
								<div class="item_rank"><span class="num">1</span>위</div></div>
							</li>
							<li style="padding:10px 0 0 10px;">
								<div class="item_img_area">
									<a href="#"><img src="/admin/skin/default/images/quick_design/sample_goods02.jpg" onerror="this.src='/admin/skin/default/images/common/noimage.gif';" alt=""></a>
								<div class="item_rank"><span class="num">2</span>위</div></div>
							</li>
							<li style="padding:10px 0 0 10px;">
								<div class="item_img_area">
									<a href="#"><img src="/admin/skin/default/images/quick_design/sample_goods03.jpg" onerror="this.src='/admin/skin/default/images/common/noimage.gif';" alt=""></a>
								<div class="item_rank"><span class="num">3</span>위</div></div>
							</li>
							<li style="padding:10px 0 0 10px;">
								<div class="item_img_area">
									<a href="#"><img src="/admin/skin/default/images/quick_design/sample_goods04.jpg" onerror="this.src='/admin/skin/default/images/common/noimage.gif';" alt=""></a>
								<div class="item_rank"><span class="num">4</span>위</div></div>
							</li>
						</ul>
					</div>
				</li>
				<li>
					<table cellpadding="0" cellspacing="0" class="quick_setting_table">
					<tbody>
						<tr>
							<th rowspan="6"><p>BEST 페이지 랭크</p></th>
							<th rowspan="2"><p>1위</p></th>
							<th><p>배경</p></th>
							<td>
								<input type="text" name="best_rank1_bg" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["best_rank1_bg"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th><p>텍스트</p></th>
							<td>
								<input type="text" name="best_rank1_text" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["best_rank1_text"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th rowspan="2"><p>2위</p></th>
							<th><p>배경</p></th>
							<td>
								<input type="text" name="best_rank2_bg" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["best_rank2_bg"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th><p>텍스트</p></th>
							<td>
								<input type="text" name="best_rank2_text" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["best_rank2_text"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th rowspan="2"><p>3위</p></th>
							<th><p>배경</p></th>
							<td>
								<input type="text" name="best_rank3_bg" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["best_rank3_bg"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th><p>텍스트</p></th>
							<td>
								<input type="text" name="best_rank3_text" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["best_rank3_text"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
					</tbody>
				</table>
				</li>
			</ul>


			<!-- 게시판 상세페이지 - 현재글 -->
			<ul class="quick_setting_container">
				<li>
					<div class="res_table">
						<ul class="thead">
							<li style="width:48px;"><span>번호</span></li>
							<li style="width:80px;"><span>분류</span></li>
							<li><span>제목</span></li>
							<li class="Hide" style="width:100px;"><span>작성자</span></li>
							<li style="width:100px;"><span>등록일</span></li>
							<li style="width:45px;"><span>조회</span></li>
						</ul>
						<ul class="tbody">
							<li class="mo_hide"><span class="mtitle">번호:</span> 3</li>
							<li><span class="cat">[공지]</span></li>
							<li class="subject">
								<span class="hand boad_view_btn">
									 반응형 스킨 오픈이 다가오고 있습니다
								</span>
							</li>
							<li class="Hide"><img src="/admin/skin/default/images/board/icon/icon_admin.gif" id="icon_admin_img" align="absmiddle" style="vertical-align:middle;"></li>
							<li>2018.09.28</li>
							<li><span class="mtitle">조회:</span> 26</li>
						</ul>
						<ul class="tbody now_list">
							<li class="mo_hide"><span class="mtitle">번호:</span>  <span class="now">현재글</span> </li>
							<li> <span class="cat">[공지]</span></li>
							<li class="subject">
								<span class="hand boad_view_btn">
									 공지글 아닌 공지 테스트
								</span>
							</li>
							<li class="Hide"><img src="/admin/skin/default/images/board/icon/icon_admin.gif" id="icon_admin_img" align="absmiddle" style="vertical-align:middle;"></li>
							<li>2018.09.28</li>
							<li><span class="mtitle">조회:</span> 12</li>
						</ul>
						<ul class="tbody">
							<li class="mo_hide"><span class="mtitle">번호:</span> 1</li>
							<li> <span class="cat">[긴급공지]</span></li>
							<li class="subject">
								<span class="hand boad_view_btn">
									 공지글인 긴급 공지 테스트 2
								</span>
							</li>
							<li class="Hide"><img src="/admin/skin/default/images/board/icon/icon_admin.gif" id="icon_admin_img" align="absmiddle" style="vertical-align:middle;"></li>
							<li>2018.09.11</li>
							<li><span class="mtitle">조회:</span> 28</li>
						</ul>
					</div>
				</li>
				<li>
					<table cellpadding="0" cellspacing="0" class="quick_setting_table">
					<tbody>
						<tr>
							<th rowspan="2"><p>게시판 상세 - 현재글</p></th>
							<th style="width:80px;"><p>라인</p></th>
							<td>
								<input type="text" name="board_list_active_line" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["board_list_active_line"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
						<tr>
							<th><p>텍스트</p></th>
							<td>
								<input type="text" name="board_list_active_text" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["board_list_active_text"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
					</tbody>
				</table>
				</li>
			</ul>

			<!-- 페이징 -->
			<ul class="quick_setting_container">
				<li>
					<div class="paging_navigation_pop">
						<a href="#" class="first"></a><a href="#" class="prev"></a>
						<a href="#">6</a>
						<a href="#">7</a>
						<a href="#" class="on"><b>8</b></a>
						<a href="#">9</a>
						<a href="#">10</a>
						<a href="#" class="next"></a><a href="#" class="last"></a>
					</div>
				</li>
				<li>
					<table cellpadding="0" cellspacing="0" class="quick_setting_table">
					<tbody>
						<tr>
							<th rowspan="2"><p>페이징 - 현재 페이지</p></th>
							<th style="width:80px;"><p>라인</p></th>
							<td>
								<input type="text" name="paging_active_line" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["paging_active_line"]?>" readonly="readonly" style="display: none;">
								
							</td>
						</tr>
						<tr>
							<th><p>텍스트</p></th>
							<td>
								<input type="text" name="paging_active_text" class="colorpicker" value="<?php echo $TPL_VAR["colors"]["paging_active_text"]?>" readonly="readonly" style="display: none;">
							</td>
						</tr>
					</tbody>
				</table>
				</li>
			</ul>
		</div>

	</div>
	<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ //상세 설정 ++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

	<!-- 하단 버튼 -->
	<div class="quick_bottom_area">
		<span class="quickDeatilShow" style="display:none;">
			<button type="button" class="btn_resp size_c" style="width:240px;" onclick="initThemeColor(this);">선택 <b id="selectedTheme" class="theme_c"></b> 테마로 초기화</button> &nbsp;
</span>
		<button type="submit" class="btn_resp size_c color6" style="width:240px;">적용하기</button>
	</div>

</div>

</form>

<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js?v=<?php echo date('YmdHis')?>"></script>
<script>

// 컬러피커 노출여부
// true로 되어있을때 색상 설정 상관없이 무조건 컬러피커 노출
var force_colorpicker = false;

// 컬러피커위젯 객체
var detailColorPicker = null;
var customColorPicker = null;


// 적용하기 버튼
function quick_design_submit() {
    var input = confirm('현재 디자인작업용 스킨( <?php echo $TPL_VAR["config_system"]["workingMobileSkin"]?> )에 적용하시겠습니까?');
    if (input) { 
		return true;
	}else{	
		return false;
	}
}

// 선택 테마 색상 초기화
function initThemeColor(el){
	$(".colorpicker").val('');
	updateThemeColor(el);
}

// 테마 변경 갱신
function updateThemeColor(el) {
	// 넘겨줄 데이터
	// #이 포함되면 ajax로 못넘겨서 #은 생략
	var theme = $('input[name="quick_theme_select"]:checked').val();
	var color = theme == 'custom' ? $('input[name="quick_theme_color"]').val().replace('#', '') : '';

	// 커스텀 색상이 설정되어있는 경우 커스텀 색상으로 세팅
	var selectColor = $('.custom_colorpicker').val();
	if(selectColor === '' || selectColor === null || theme != 'custom'){
		$('#selectedTheme').css( 'background', $('#quickThemeSelect input[type=radio]:checked').next('b').css('background') );
	}else{
		$('#selectedTheme').css( 'background', selectColor );
	}

	// 샘플 css를 갱신
	$.ajax({
		'type': 'post',
		'url' : '../design/quick_design_css?theme=' + theme + '&color=' + color,
		'dataType' : 'text',
		'data' : $('#quickFrm').serialize(),
		'success' : function(css){
			$('#sample_css').text(css);
		}
	});
}


// 테마 색상 클릭 처리
function themeClick(obj){
	if ( $(obj).prop('checked') ) {
		$('#quickThemeSelect .theme_color').removeClass('on');
		$(obj).parent('.theme_color').addClass('on');
		$(".colorpicker").val('');
		updateThemeColor();
	}
}

// 컬러피커 바인딩
function colorPickerBind(){
	
	// 컬러 피커 모듈 호출
	detailColorPicker = $(".colorpicker").customColorPicker({
		'default_color' : '#ffffff',
		'pickerBtn' : '<div class="colorPickerBtn detail">',
		'pickerBtnBind' : function(btnObj){
			var btnKey = $(btnObj).parent().find('.colorpicker').attr('name');
			$(btnObj).css('background', null).addClass(btnKey);
		},
		'afterDone' : function(){ 
			updateThemeColor();
		}
	});
	
	// 컬러 피커 모듈 호출
	customColorPicker = $(".custom_colorpicker").customColorPicker({
		'default_color' : '#ffffff',
		'pickerBtn' : '<b id="customPickerBtn" class="colorPickerBtn" style="background:<?php echo $TPL_VAR["colors"]["custom_color"]?>;"></b>',
		'pickerBtnBind' : function(btnObj){
<?php if($TPL_VAR["theme"]=='custom'){?>
			$('#customPickerBtn').addClass('off');
<?php }?>
		},
		'afterDone' : function(){ 
			
			// 색상을 고른 뒤 체크 처리 후 테마 선택 처리
			var obj = $('#custom_color_radio');
			obj.prop('checked', true);
			themeClick(obj);
			force_colorpicker = false;

		},
		'afterClick' : function(){
			
			// 사용자지정 테마선택 버튼 클릭 후 이벤트 
			// 강제로 컬러피커를 띄우거나 색상값이 있는 경우 바로 선택처리
			if(!force_colorpicker && $('input[name="quick_theme_color"]').val() != ''){
				$('.colorPickerLayer').hide();
				var obj = $('#custom_color_radio');
				obj.prop('checked', true);
				themeClick(obj);
			}
			
			force_colorpicker = false;
		}
	});

}

// 사용자 지정 컬러 지정 시
function doneCustomColor(){
	$('#quickThemeSelect input[type="radio"][value="custom"]').prop('checked', true);
}

// 사용자 지정 텍스트 클릭 시 컬러피커 처리
// 무조건 컬러피커를 띄워야 하기때문에 force_colorpicker 를 true로 설정
function customColorSelect(){
	force_colorpicker = true;
	$('#customPickerBtn').click();
}

$(function() {

	// ajax 실행 시 로딩 이미지 제거
	$("#ajaxLoadingLayer").unbind('ajaxStart');
	$("#ajaxLoadingLayer").unbind('ajaxStop');

	// 탭 클릭
	$('#quickDesignTab a').click(function() {

		// 메인 테마 미선택시 상세 탭 이동 불가
		if($(this).attr('value') == 'detail' && $('input[name="quick_theme_select"]:checked').length == 0){
			alert('메인 테마색상 설정 후 상세설정이 가능합니다.');
			return false;
		}

		$('#quickDesignTab li').removeClass('on');
		$(this).parent('li').addClass('on');
		$('.quickDesignDetail').hide();
		$(this.hash).show();
		if ( this.hash == '#quickDetailSetting' ) {
			$('.quickDeatilShow').show();
		} else {
			$('.quickDeatilShow').hide();
		}
		return false;
	});

	// 테마 선택
	$('#quickThemeSelect input[type=radio]:checked').parent('.theme_color').addClass('on');

	// 테마 선택 버튼 클릭 시 
	$('#quickThemeSelect input[type=radio]').click(function(){
		themeClick(this);
	});

	// 사용자지정 색상 변경 시	
	$('input[name="quick_theme_color"]').change(function(){

		// 색이 지정 된 후엔 백그라운드 이미지를 없앤다
		$('#customPickerBtn').addClass('off');

		updateThemeColor();
	});

	updateThemeColor();
	colorPickerBind();
});
</script>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>