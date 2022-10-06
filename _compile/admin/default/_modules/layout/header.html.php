<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/_modules/layout/header.html 000040909 */ 
$TPL_env_list_1=empty($TPL_VAR["env_list"])||!is_array($TPL_VAR["env_list"])?0:count($TPL_VAR["env_list"]);
$TPL_action_history_data_1=empty($TPL_VAR["action_history_data"])||!is_array($TPL_VAR["action_history_data"])?0:count($TPL_VAR["action_history_data"]);
$TPL_adminMenu_1=empty($TPL_VAR["adminMenu"])||!is_array($TPL_VAR["adminMenu"])?0:count($TPL_VAR["adminMenu"]);?>
<?php $this->print_("common_html_header",$TPL_SCP,1);?>

<style>
	.header-snb-container {display:table; width:100%;}
	.header-snb-container > li {display:table-cell; vertical-align:middle;}
	.header_search select, .header_search input {border: 0 !important;}
</style>

<script type="text/javascript">
	var gl_manager_id = '<?php echo $TPL_VAR["managerInfo"]["manager_id"]?>';
	var gl_operation_type = '<?php echo $TPL_VAR["config_system"]["operation_type"]?>';
	var gl_admin_menual_hidden = '<?php echo $TPL_VAR["admin_menual_hidden"]?>';
	var gl_goods_quick_topmenu = '<?php echo $TPL_VAR["goods_quick_topmenu"]?>';
	var gl_admin_menual_url = '<?php echo $TPL_VAR["admin_menual_url"]?>';
	var gl_lnb_close_yn = '<?php echo $TPL_VAR["lnb_close_yn"]?>';
	var design_working_skin = '<?php echo $TPL_VAR["designWorkingSkin"]?>'
	var folder;
	var category_use = '<?php echo $TPL_VAR["category_use"]?>';
	var cate_code = '<?php echo $TPL_VAR["cate_code"]?>';

	$.fn.hasScrollBar = function() {
		return (this.prop("scrollHeight") == 0 && this.prop("clientHeight") == 0) || (this.prop("scrollHeight") > this.prop("clientHeight"));
	};

<?php if($TPL_VAR["is_change_pass_required"]&&uri_string()!='admin/main/index'&&uri_string()!='admin/login/index'){?>
	top.document.location.replace('/admin/main/index');
<?php }?>

<?php if($TPL_VAR["managerInfo"]["manager_seq"]){?>
	setTimeout(function(){
		loadIssueCounts();
	},500);
<?php }?>

	$(function(){
		$(".platformhelp").poshytip({
			className: 'tip-darkgray',
			bgImageFrameSize: 8,
			alignTo: 'target',
			alignX: 'up',
			alignY: 'bottom',
			offsetX: -55,
			offsetY: 6,
			allowTipHover: false,
			slide: false,
			showTimeout : 0
		});
	});
</script>
<body>
<div id="dumy" style="display:none"></div>
<div id="totalMenuDialog" class="dialog" style="display:none"></div>
<div id="env_move" style="display:none">
	<table class="info-table-style" cellspacing="0">
		<colgroup>
			<col width="100px"/>
			<col width="400px"/>
			<col width="200px"/>
			<col width="200px"/>
			<col width="100px"/>
		</colgroup>
		<thead>
			<tr>
				<th class="its-th-align">관리명</th>
				<th class="its-th-align">사용자 화면</th>
				<th class="its-th-align">안내 언어</th>
				<th class="its-th-align">기본통화</th>
				<th class="its-th-align">관리환경</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div id="member_info_layer" class="member_info_layer hide"></div>
<!-- 다국어 통합설정 -->
<div id="page-global-btn" class="page-global-btn<?php echo $TPL_VAR["goods_quick_topmenu"]?> hide" env="<?php if($TPL_VAR["env_all"]){?>all<?php }else{?><?php echo $TPL_VAR["this_admin_env"]["env_name"]?><?php }?>">
<?php if($TPL_VAR["env_all"]){?>
	<a href="javascript:;" title="관리환경 이동" style="display:none;"><img src="/data/brand_country/<?php echo strtolower($TPL_VAR["this_admin_env"]["language"])?>.png" alt="<?php echo $TPL_VAR["this_admin_env"]["language"]?>"> <strong>다국어 통합설정</strong></a>
<?php }else{?>
	<a href="javascript:;" title="관리환경 이동" style="display:none;"><img src="/data/brand_country/<?php echo strtolower($TPL_VAR["this_admin_env"]["language"])?>.png" alt="<?php echo $TPL_VAR["this_admin_env"]["language"]?>"> <strong><?php echo $TPL_VAR["this_admin_env"]["env_name"]?></strong> <?php echo $TPL_VAR["this_admin_env"]["currency"]?></a>
<?php }?>
</div>

<!-- 매뉴얼 버튼 -->
<div class="hide">
	<div class="page-manual-btn<?php echo $TPL_VAR["goods_quick_topmenu"]?> resp_btn hide">
		<a href="#" target="_blank" >매뉴얼</a>
	</div>
</div>

<!-- 다국어 관리환경 이동 -->
<div id="global-setting">
	<div class="global-setting-layer">
		<h1 id="global-title">관리환경 이동</h1>
		<table width="650" border="0" cellpadding="0" cellspacing="0">
			<colgroup>
				<col /><col /><col width="18%" /><col width="16%" /><col width="16%" />
			</colgroup>
			<thead>
				<tr>
					<th scope="col">관리명</th>
					<th scope="col">사용자 화면</th>
					<th scope="col">안내 언어</th>
					<th scope="col">기본 통화</th>
					<th scope="col">관리환경</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_env_list_1){foreach($TPL_VAR["env_list"] as $TPL_V1){?>
				<tr>
					<th scope="row"><?php echo $TPL_V1["admin_env_name"]?></th>
					<td><?php echo $TPL_V1["domain"]?></td>
					<td class="lang_<?php echo $TPL_V1["language"]?>"><?php echo $TPL_V1["lang"]?></td>
					<td class="center"><?php echo $TPL_V1["currency"]?></td>
					<td class="center">
<?php if($TPL_V1["this_admin"]=='y'){?>
						<a class="btn_link" style="border:1px solid #b9b9b9;color:#b9b9b9;">바로가기</a>
<?php }else{?>
						<a href="javascript:env_move('<?php echo $TPL_V1["domain"]?>');" class="btn_link">바로가기</a>
<?php }?>
					</td>
				</tr>
<?php }}?>
			</tbody>
		</table>
		<a href="javascript:;" class="close">닫기</a>
	</div>
	<div class="global-setting-bg"></div>
</div>

<div id="wrap">
	<div id="layout-container" class="<?php echo $TPL_VAR["service_code"]?>"><!-- free premium expantion proexpantion -->
<?php if($TPL_VAR["main"]){?><div id="layout-body-background"></div><?php }?>
		<div id="layout-background"  <?php if($TPL_VAR["main"]){?>class="main-background-width"<?php }?>><div class="img_bg <?php echo $TPL_VAR["service_code"]?>"></div></div>
		<!-- //헤더 : 백그라운드 -->

		<!--[ 레이아웃 헤더 : 시작 ]-->
		<div id="layout-header" <?php if($TPL_VAR["managerInfo"]["gnb_icon_view"]!='n'){?>class="icon-view"<?php }?>>

			<!-- 헤더 상단부 -->
			<ul class="header-snb-container">

				<!-- [ 로고 : 시작 ] -->
				<li class="header_left_dvs">
					<a href="/admin" class="logo">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" href="/admin" class="logo" width="113px" height="21px" viewBox="0 0 113 21">
							<path fill-rule="evenodd"  fill="rgb(51, 51, 51)" d="M107.915,20.577 L107.915,0.477 L112.654,0.477 L112.654,20.577 L107.915,20.577 ZM100.808,0.477 L105.546,0.477 L105.546,20.577 L100.808,20.577 L100.808,0.477 ZM94.248,18.988 C93.169,20.703 91.703,20.893 89.755,20.893 C87.044,20.893 84.622,19.548 84.622,16.566 C84.622,12.370 89.176,11.869 91.703,11.869 C92.466,11.869 93.309,11.949 93.914,12.054 C93.887,10.180 92.493,9.679 90.781,9.679 C89.255,9.679 87.634,9.969 86.317,10.708 L86.333,7.489 C88.017,6.803 89.781,6.513 91.809,6.513 C95.310,6.513 98.337,8.017 98.337,12.212 L98.337,17.331 C98.337,18.413 98.347,19.454 98.347,20.577 L94.245,20.577 L94.248,18.988 ZM91.782,14.402 C90.071,14.402 88.724,14.912 88.724,16.255 C88.724,17.222 89.622,17.786 90.800,17.786 C92.708,17.786 93.914,16.121 93.914,14.483 L91.782,14.402 ZM77.596,13.188 C77.596,11.632 77.043,10.471 75.700,10.471 C74.015,10.471 73.015,11.816 73.015,14.772 L73.015,20.577 L68.277,20.577 L68.277,13.188 C68.277,11.632 67.724,10.471 66.381,10.471 C64.696,10.471 63.696,11.816 63.696,14.772 L63.696,20.577 L58.958,20.577 L58.958,6.830 L63.275,6.830 L63.275,9.363 L63.327,9.363 C64.275,7.384 66.171,6.513 68.329,6.513 C70.277,6.513 71.883,7.357 72.620,9.151 C73.726,7.304 75.543,6.513 77.490,6.513 C81.439,6.513 82.334,8.756 82.334,12.476 L82.334,20.577 L77.596,20.577 L77.596,13.188 ZM48.402,15.748 L48.402,10.154 L45.692,10.154 L45.692,6.830 L48.482,6.830 L48.482,3.355 L53.141,3.355 L53.141,6.830 L56.458,6.830 L56.458,10.154 L53.141,10.154 L53.141,15.220 C53.141,16.883 53.536,17.727 55.037,17.727 C55.510,17.727 56.114,17.621 56.588,17.542 L56.588,20.629 C55.694,20.735 54.852,20.893 53.668,20.893 C49.430,20.893 48.402,19.020 48.402,15.748 ZM37.878,20.893 C35.746,20.893 34.193,20.682 32.798,20.234 L32.798,16.777 C33.904,17.252 35.904,17.727 37.615,17.727 C38.589,17.727 39.537,17.569 39.537,16.619 C39.537,14.297 32.798,15.933 32.798,10.972 C32.798,7.806 35.904,6.513 38.642,6.513 C40.274,6.513 41.932,6.698 43.459,7.304 L43.452,10.603 C42.452,9.996 40.590,9.679 39.406,9.679 C38.378,9.679 37.221,9.864 37.221,10.629 C37.221,12.767 44.276,11.078 44.276,16.302 C44.276,19.969 40.984,20.893 37.878,20.893 ZM29.539,10.471 C27.328,10.471 26.090,12.081 26.090,14.772 L26.090,20.577 L21.352,20.577 L21.352,6.830 L25.669,6.830 L25.669,8.963 L25.722,8.963 C26.538,7.221 27.722,6.513 29.776,6.513 C30.329,6.513 30.908,6.592 31.382,6.671 L31.382,10.629 C30.856,10.471 30.092,10.471 29.539,10.471 ZM16.427,5.602 C15.014,5.602 13.868,4.453 13.868,3.036 C13.868,1.619 15.014,0.471 16.427,0.471 C17.841,0.471 18.987,1.619 18.987,3.036 C18.987,4.453 17.841,5.602 16.427,5.602 ZM8.405,20.577 L3.667,20.577 L3.667,10.154 L0.473,10.154 L0.473,6.830 L3.746,6.830 L3.746,5.985 C3.746,1.895 5.667,0.471 9.458,0.471 C10.485,0.471 11.274,0.629 11.879,0.734 L11.879,4.137 C11.484,4.005 10.800,3.795 10.090,3.795 C8.878,3.795 8.405,4.640 8.405,5.985 L8.405,6.830 L11.879,6.830 L11.879,10.154 L8.405,10.154 L8.405,20.577 ZM18.796,20.577 L14.058,20.577 L14.058,6.830 L18.796,6.830 L18.796,20.577 Z"/>
						</svg>
					</a>
				</li>
				<!-- [ 로고 : 끝 ] -->
				<!-- [ 우측 상단메뉴 : 시작 ] -->
				<li class="header_right_dvs">

					<!-- [ 검색창 : 시작 ] -->
					<div class="header_search">
						<form name="headForm" id="headForm" action="/admin/order/catalog" style="overflow: visible;">
							<input type="hidden" name="searchflag" value="1">
							<span class="search_box">
								<select name="header_search_type" id="header_search_type">
									<option value="order" <?php if($_GET["header_search_type"]=="order"){?>selected<?php }?>>주문</option>
									<option value="export" <?php if($_GET["header_search_type"]=="export"){?>selected<?php }?>>출고</option>
<?php if(serviceLimit('SN4')){?><option value="goods" <?php if($_GET["header_search_type"]=="goods"){?>selected<?php }?>>실물</option><?php }?>
<?php if(serviceLimit('S28')){?><option value="coupon" <?php if($_GET["header_search_type"]=="coupon"){?>selected<?php }?>>티켓</option><?php }?>
									<option value="member" <?php if($_GET["header_search_type"]=="member"){?>selected<?php }?>>회원</option>
								</select>
								<input type="text" name="header_search_keyword" id="header_search_keyword" value="<?php echo $_GET["header_search_keyword"]?>" />
								<div class="searchBtn"></div>
							</span>
							<img src="/admin/skin/default/images/main/q_icon.png" align="absmiddle" id="search_help" class="hand" />
							<div class="relative">
								<div class="absolute hide" id="search_information" style="z-index:1000">
									<div class="center pdb10 fn12 bold">아래의 정의된 검색어로 빠르게 검색하세요</div>
									<table class="simplelist-table-style" style="width:100%; table-layout:fixed">
										<tr>
											<th class="bold">주문 → 주문리스트</th>
											<th class="bold">출고 → 출고리스트</th>
											<th class="bold">상품 → 실물 배송 상품</th>
											<th class="bold">티켓 → 티켓 발송 상품</th>
											<th class="bold">회원  → 회원리스트</th>
										</tr>
										<tr>
											<td style="border:1px solid #c8c8c8;" valign="top">
												<div class="pdl5">· 주문자</div>
												<div class="pdl5 pdt5">· 수령자</div>
												<div class="pdl5 pdt5">· 입금자</div>
												<div class="pdl5 pdt5">· 아이디</div>
												<div class="pdl5 pdt5">· 이메일</div>
												<div class="pdl5 pdt5">· 휴대폰</div>
												<div class="pdl5 pdt5">· 상품명</div>
												<div class="pdl5 pdt5">· 상품 고유값</div>
												<div class="pdl5 pdt5">· 상품코드</div>
												<div class="pdl5 pdt5">· 사은품</div>
												<div class="pdl5 pdt5">· 운송장번호</div>
												<div class="pdl5 pdt5">· 주문번호</div>
												<div class="pdl5 pdt5">· 출고번호</div>
												<div class="pdl5 pdt5">· 반품번호</div>
												<div class="pdl5 pdt5">· 환불번호</div>
											</td>
											<td style="border:1px solid #c8c8c8;" valign="top">
												<div class="pdl5">· 주문자</div>
												<div class="pdl5 pdt5">· 수령자</div>
												<div class="pdl5 pdt5">· 입금자</div>
												<div class="pdl5 pdt5">· 아이디</div>
												<div class="pdl5 pdt5">· 이메일</div>
												<div class="pdl5 pdt5">· 휴대폰</div>
												<div class="pdl5 pdt5">· 상품명</div>
												<div class="pdl5 pdt5">· 상품 고유값</div>
												<div class="pdl5 pdt5">· 상품코드</div>
												<div class="pdl5 pdt5">· 사은품</div>
												<div class="pdl5 pdt5">· 운송장번호</div>
												<div class="pdl5 pdt5">· 주문번호</div>
												<div class="pdl5 pdt5">· 출고번호</div>
												<div class="pdl5 pdt5">· 반품번호</div>
												<div class="pdl5 pdt5">· 환불번호</div>
											</td>
											<td style="border:1px solid #c8c8c8;" valign="top">
												<div class="pdl5">· 상품명</div>
												<div class="pdl5 pdt5">· 상품 고유값</div>
												<div class="pdl5 pdt5">· 상품코드</div>
												<div class="pdl5 pdt5">· 태그</div>
												<div class="pdl5 pdt5">· 간략설명</div>
											</td>
											<td style="border:1px solid #c8c8c8;" valign="top">
												<div class="pdl5">· 상품명</div>
												<div class="pdl5 pdt5">· 상품 고유값</div>
												<div class="pdl5 pdt5">· 상품코드</div>
												<div class="pdl5 pdt5">· 태그</div>
												<div class="pdl5 pdt5">· 간략설명</div>
											</td>
											<td style="border:1px solid #c8c8c8;" valign="top">
												<div class="pdl5">· 아이디</div>
												<div class="pdl5 pdt5">· 회원명</div>
												<div class="pdl5 pdt5">· 닉네임</div>
												<div class="pdl5 pdt5">· 이메일</div>
												<div class="pdl5 pdt5">· 주소</div>
												<div class="pdl5 pdt5">· 전화번호</div>
												<div class="pdl5 pdt5">· 핸드폰</div>
											</td>
										</tr>
									</table>
								</div>
							</div>
							<script type="text/javascript">
								$("#search_help").bind("click",function(){
									openDialog("빠른 검색", "search_information", {"width":800});
								});
								$("#header_search_keyword").blur(function(){
									if("<?php echo $_GET["header_search_keyword"]?>" == $("#header_search_keyword").val()){
										$(".header_search_type_text").show();
									}
									setTimeout(function(){
										$('.header_searchLayer').hide()}, 500
									);
								});
<?php if($_GET["header_search_type"]){?>
									setHeaderSearchTxt('<?php echo $_GET["header_search_type"]?>');
									$('.header_search_type_text').show();
<?php }?>
							</script>
						</form>
					</div>
					<!-- [ 검색창 : 끝 ] -->

					<ul class="header-snb clearbox">
						<!-- [ 바로가기 : 시작 ] -->
						<li class="item">
							<ul class="top_menu">
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'&&$TPL_VAR["config_system"]["skin_type"]=='responsive'){?>
								<li class="item hsnb-pc shortcutBtn">
									<a href="//<?php echo $TPL_VAR["pcDomain"]?>/?setDesignMode=off&setMode=pc" target="_blank" title="쇼핑몰 바로가기">쇼핑몰 바로가기</a>
								</li>
<?php }else{?>
								<li class="item hsnb-pc shortcutBtn">
									<a href="javascript:void(0);" title="쇼핑몰 바로가기">쇼핑몰 바로가기</a>
									<div class="shortcut_wrap hsubmenu hide" >
										<div>
											<img class="img_arrow" src="/admin/skin/default/images/common/helper_arrow.png">
											<ul>
												<li><a href="//<?php echo $TPL_VAR["pcDomain"]?>/?setDesignMode=off&setMode=pc" target="_blank"  title="PC 쇼핑몰">PC 쇼핑몰</a></li>
												<li><a href="//<?php echo $TPL_VAR["mobileDomain"]?>/?setDesignMode=off&setMode=mobile" target="_blank" title="모바일 쇼핑몰">모바일 쇼핑몰</a></li>
											</ul>
										</div>
									</div>
								</li>
<?php }?>

								<li class="item shortcutBtn">
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
									<a href="<?php if($TPL_VAR["config_system"]["skin_type"]=='responsive'){?>../design/main?setMode=mobile<?php }else{?>../design/main?setMode=pc<?php }?>" target="_blank">디자인 편집</a>
<?php }else{?>
									<a href="javascript:void(0);">디자인 편집</a>
									<div class="shortcut_wrap hsubmenu hide" >
										<div>
											<img class="img_arrow" src="/admin/skin/default/images/common/helper_arrow.png">
											<ul>
												<li><a href="../design/main?setMode=pc" target="_blank"  title="PC 쇼핑몰">PC 편집</a></li>
												<li><a href="../design/main?setMode=mobile" target="_blank" title="모바일 쇼핑몰">모바일 편집</a></li>
											</ul>
										</div>
									</div>
<?php }?>
								</li>
							</ul>
						</li>
						<!-- [ 바로가기 : 끝 ] -->


						<!-- [ 메모 : 시작 ] -->
						<li class="item hsnb-memo memo">
							<a href="javascript:;" title="메모" class="i-memo openBtn">메모</a>
							<div class="hsnbm-menu hsubmenu">
								<div>
									<span class="point_b img_arrow"></span>
									<script type="text/javascript" src="/app/javascript/plugin/jquery_pagination/jquery.pager.js" charset="utf8"></script>

									<div id="admin-memo">
										<div id="admin-memo-container">
											<div class="memo-input-container clearbox">
												<form name="newMemoForm" action="../adminmemo_process/save" method="post" target="actionFrame">
													<textarea class="memo-input" name="contents" title="메모를 남기세요." rows="5"></textarea>
													<button type="submint" class="resp_btn v2 size_S btn_save"/>저장</button>
												</form>
											</div>
											<div class="memo-search">
												<form name="searchMemoForm" method="post" onsubmit="get_memo_list('',this.search_keyword.value);return false;">
													<input type="text" class="memo-search-input" name="search_keyword" value="" class="line" title="메모 검색" />
													<button onsubmit="get_memo_list('',this.search_keyword.value);return false;" class="btn_search"/><div class="i-search-3" ></div></button>
												</form>
											</div>
											<div class="memo-list"></div>
											<div id="admin-memo-page" class="pager"></div>
										</div>
									</div>
								</div>
							</div>
							<script>
									var memo_page = 1;
									var memo_animation = false;
									var addHeight = 0;
									var memo_opened	= false;

									$(function(){
										var memoWidth;
										//$("#admin-memo-container").height($("#layout-body").outerHeight());
										$("#admin-memo-openbtn").toggle(function(){
											memoWidth = 216;
											$("#admin-memo-container").outerWidth(memoWidth).height($("#layout-body").outerHeight());
											if(memo_animation)	$("#admin-memo").animate({'width':memoWidth,'margin-left':-memoWidth});
											else				$("#admin-memo").css({'width':memoWidth,'margin-left':-memoWidth});
											$(".memo-closebtn").show();
											$(".memo-openbtn").hide();
										},function(){
											$("#admin-memo").animate({'width':0,'margin-left':0});
											$(".memo-openbtn").show();
											$(".memo-closebtn").hide();
										});

										$("#admin-memo-openbtn").click();
										memo_animation = true;

										$(".memo-item-openbtn").live('click',function(){
											$(".memo-item").not($(this).closest('.memo-item')).removeClass('memo-item-opened');
											$(this).closest('.memo-item').toggleClass('memo-item-opened');
											memo_opened ? memo_opened = false : memo_opened = true;
										});

										$(".memo-item-contents").live('click',function(){
											if(!$(this).closest('.memo-item').is(".memo-item-opened")){
												$(this).closest('.memo-item').find(".memo-item-openbtn").click();
											}
										});

										$(".memo-item-contents textarea").live('keydown','Ctrl+S',function(event){
											event.preventDefault();
											$(this.form).submit();
											return false;
										});

										$("#admin-memo-container .memo-input").focus(function(){
											$(".memo-input-container").addClass('memo-input-container-focused');
										});
										get_memo_list();
									});

									function get_memo_list(page,search_keyword){

										memo_page = page ? page : memo_page;

										if(search_keyword && document.searchMemoForm.search_keyword.value==document.searchMemoForm.search_keyword.title){
											document.searchMemoForm.search_keyword.value='';
											search_keyword='';
										}

										$.ajax({
											'url' : '../adminmemo_process/get_list',
											'data' : {'page':page,'search_keyword':search_keyword},
											'type' : 'post',
											'dataType' : 'json',
											'global' : false,
											'success' : function(result){

												$("#admin-memo-page").show().pager({pagenumber: result.page.nowpage, pagecount: result.page.totalpage, buttonClickCallback:function(clicked_page){
													get_memo_list(clicked_page,search_keyword);
												}});

												var html = '';
												if( result.record ) {
													for(var i=0;i<result.record.length;i++){
														html += '<div class="memo-item '+(result.record[i].check=='1'?'checked':'')+'" memo_seq="'+result.record[i].memo_seq+'">';
														html += '	<form action="../adminmemo_process/edit" method="post" target="actionFrame">';
														html += '	<input type="hidden" name="memo_seq" value="'+result.record[i].memo_seq+'" />';
														html += '	<div class="memo-item-important"><span class="icon-star-gray '+(result.record[i].important=='1'?'checked':'')+'" onclick="important_memo('+result.record[i].memo_seq+')"></span></div>';
														html += '	<div class="memo-item-writer"><span>'+result.record[i].manager_id+'</span></div>';
														html += '	<div class="memo-item-contents">';
														html += '		<div class="memo-item-contents-summary">'+result.record[i].contents_htmlspecialchars+'</div>';
														html += '		<textarea name="contents">'+result.record[i].contents_htmlspecialchars+'</textarea>';
														html += '	</div>';
														html += '	<div class="memo-item-openbtn"></div>';
														html += '	<div class="memo-item-footer clearbox">';
														html += '		<div class="fl">';
														html += '			<span class="memo-item-check" onclick="check_memo('+result.record[i].memo_seq+')"></span>';
														html += '			<input type="image" src="/admin/skin/default/images/main/btn_memo_edit.gif" onmouseover="this.src=\'/admin/skin/default/images/main/btn_memo_edit_on.gif\'" onmouseout="this.src=\'/admin/skin/default/images/main/btn_memo_edit.gif\'" align="absmiddle" title="저장하기" />';
														html += '			<img src="/admin/skin/default/images/main/btn_memo_del.gif" onmouseover="this.src=\'/admin/skin/default/images/main/btn_memo_del_on.gif\'" onmouseout="this.src=\'/admin/skin/default/images/main/btn_memo_del.gif\'" align="absmiddle" hspace="5" title="삭제하기" class="hand" onclick="delete_memo('+result.record[i].memo_seq+')" />';
														html += '		</div>';
														html += '		<div class="fr fx11 gray">'+result.record[i].date+'</div>';
														html += '	</div>';
														html += '	</form>';
														html += '</div>';
													}
												}else{
													html = '<div class="pd5 desc center">검색된 메모가 없습니다.</div>';
													$("#admin-memo-page").hide();
												}

												$("#admin-memo .memo-list").html(html);
											}
										});
									}

									function delete_memo(memo_seq){
										openDialogConfirm('메모를 삭제하시겠습니까?',400,200,function(){
											$.ajax({
												'url'	: '../adminmemo_process/delete',
												'type'	: 'post',
												'data'	: {'memo_seq':memo_seq},
												'success' : function(){
													$(".memo-item[memo_seq='"+memo_seq+"']").slideUp();
													openDialogAlert("메모가 삭제 되었습니다.",400,240,function(){
														get_memo_list(memo_page);
													});
												}
											});
										});
									}

									function important_memo(memo_seq){
										$.ajax({
											'url'	: '../adminmemo_process/important',
											'type'	: 'post',
											'data'	: {'memo_seq':memo_seq},
											'global' : false,
											'success' : function(important){
												if(important=='1') $(".memo-item[memo_seq='"+memo_seq+"'] .memo-item-important .icon-star-gray").addClass('checked');
												else $(".memo-item[memo_seq='"+memo_seq+"'] .memo-item-important .icon-star-gray").removeClass('checked');
											}
										});
									}

									function check_memo(memo_seq){
										$.ajax({
											'url'	: '../adminmemo_process/check',
											'type'	: 'post',
											'data'	: {'memo_seq':memo_seq},
											'global' : false,
											'success' : function(check){
												if(check=='1'){
													$(".memo-item[memo_seq='"+memo_seq+"']").addClass('checked');
												}
												else{
													$(".memo-item[memo_seq='"+memo_seq+"']").removeClass('checked');
												}
											}
										});
									}
								</script>
						</li>
						<!-- [ 메모 : 끝 ] -->

						<!-- [ 알림 : 시작 ] -->
						<li class="item hsnb-notice notice">
<?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'){?>
							<span class="icon_new"><?php echo count($TPL_VAR["action_history_data"])?></span>
<?php }?>
							<a href="javascript:void(0);" title="알림" class="i-notice openBtn"></a>

							<div class="hsnbm-menu hsubmenu hide">
								<div>
									<span class="point_c img_arrow"></span>
									<div class="title">
										<strong>알림</strong>
<?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'){?>
										<a href="javascript:;" class="tb_search manager_alert_view_btn"><div class="i-search-2"></div></a>
<?php }?>
									</div>
									<ul class="tb_link">
<?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'){?>
<?php if($TPL_action_history_data_1){foreach($TPL_VAR["action_history_data"] as $TPL_V1){?>
										<li class="manager_alert_view_btn"><a href="#"><?php echo date('Y.m.d',strtotime($TPL_V1["regist_date"]))?><br /><?php echo $TPL_V1["action_message"]?></a></li>
<?php }}?>
<?php }else{?>
										<li><a href="#">부관리자는 볼수 없습니다.</a></li>
<?php }?>
									</ul>
								</div>
							</div>

							<div id="manager_alert_dialog" class="hide"></div>
						</li>
						<!-- [ 알림 : 끝 ] -->

						<li class="item admin hsnb-admin">
							<div class="openBtn">
<?php if($TPL_VAR["managerInfo"]["mphoto"]){?>
									<img src="../../../data/icon/manager/<?php echo $TPL_VAR["managerInfo"]["mphoto"]?>" width="25" height="25" align="absmiddle" /><?php }else{?><div class="i-my"></div>
<?php }?>
								<span class="manager_id"><span><?php echo $TPL_VAR["managerInfo"]["manager_id"]?></span>님</span>
								<div class="i-arrow"></div>
							</div>

							<!-- 운영자 상세 정보 -->
							<div class="hsubmenu hsnbm-menu hide">
								<div>
									<img class="img_arrow" src="/admin/skin/default/images/common/helper_arrow.png">
									<ul class="info_top">
										<li><img src=<?php if($TPL_VAR["managerInfo"]["mphoto"]){?>"../../../data/icon/manager/<?php echo $TPL_VAR["managerInfo"]["mphoto"]?>"<?php }else{?>"/admin/skin/default/images/main/def_img.png"<?php }?> width="50" height="50" align="absmiddle" /></li>
										<li>
											<p class="manager_yn"><?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'){?>대표운영자<?php }else{?>부운영자<?php }?></p>
											<p><?php echo $TPL_VAR["managerInfo"]["manager_id"]?> (<?php echo $TPL_VAR["managerInfo"]["mname"]?>)</p>
										</li>
									</ul>
									<a class="info_btn" href="../setting/manager_reg?manager_seq=<?php echo $TPL_VAR["managerInfo"]["manager_seq"]?>">계정 정보</a>
									<ul class="info_menu">
										<li>
											<a href="https://www.firstmall.kr/myshop/shops/<?php echo $TPL_VAR["enc_shopsno"]?>/view" target="_blank" >MY 퍼스트몰</a>
											<a href="https://www.firstmall.kr/ec_hosting/customer/" target="_blank">고객센터</a>
										</li>
<?php if($TPL_VAR["config_system"]["webmail_domain"]){?>
										<li><a href="http://webmail.<?php echo $TPL_VAR["config_system"]["webmail_domain"]?>/admin/adminhome" target="_blank" title="새창열림">웹메일/세금계산서</a></li>
<?php }else{?>
											<li><a href="javascript:openDialogAlert('하이웍스를 신청하지 않으셨거나  쇼핑몰과 별도로 신청을 하셨습니다.<br/>쇼핑몰과 별도로 신청을 하셨다면 퍼스트몰 고객센터 1544-3270 으로 문의주시길 바랍니다.<br/><br/>하이웍스를 신청하려면 My퍼스트몰><a href=\'https://firstmall.kr/myshop\' target=\'_blank\'><span class=\'highlight-link\'>쇼핑몰관리</span></a> 에서 할 수 있습니다.',600,200,function(){});">웹메일/세금계산서</a>
											</li>
<?php }?>
										<li>
											<a href="https://design.firstmall.kr/" target="_blank" >디자인샵</a>
										</li>
										<li><a href="../login_process/logout">로그아웃 <div class="i-logout"></div></a></li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
				</li>
				<!-- [ 우측 상단메뉴 : 끝 ] -->
			</ul>

			<!--[ ***** HEADER : 시작 ***** ]-->
			<div class="header-gnb-container">
				<!--[ (신) 헤더  : 시작 ]-->
				<ul class="header-gnb">
					<li class="total_menu <?php if($TPL_VAR["adminMenuCurrent"]=='main'||$TPL_VAR["adminMenuCurrent"]=='realpacking'){?>close<?php }?>">
						<a href="javascript:void(0);" class="totalMenu" >
							<span class="txt">전체보기</span>
							<div class="i-total-menu"></div>
						</a>
					</li>
<?php if($TPL_adminMenu_1){foreach($TPL_VAR["adminMenu"] as $TPL_K1=>$TPL_V1){?>
					<li class="<?php if(in_array($TPL_VAR["adminMenuCurrent"],$TPL_V1["folders"])){?>current<?php }?> mitem-td <?php if($TPL_K1=='setting'){?>qnb-config<?php }?>" code="<?php echo $TPL_K1?>">
						<a href="<?php echo $TPL_V1["url"]?>">
							<span><?php echo $TPL_V1["name"]?></span>
<?php if($TPL_K1!='setting'){?><div class="header-gnb-issueCount-layer" code="<?php echo $TPL_K1?>"></div><?php }?>
						</a>
						<div class="dropdown">
						</div>
					</li>
<?php }}?>
				</ul>
				<!--[ (신) 헤더  : 끝 ]-->
			</div>
			<!--[ ***** HEADER : 시작 ***** ]-->

			<!--[ 혜택설정바로가기 : 시작 ]-->
			<div class="relative">
				<div class="benifit-popup hide"></div>
			</div>
			<!--[ 혜택설정바로가기 : 끝 ]-->
		</div>
		<!--[ 레이아웃 헤더 : 끝 ]-->

		<div id="layout-body">
			<!--[ 레프트 메뉴(LNB) : 시작 ]-->
<?php if($TPL_VAR["adminMenuCurrent"]!='main'&&$TPL_VAR["adminMenuCurrent"]!='realpacking'&&$TPL_VAR["adminMenuCurrent"]!='export_download'&&$TPL_VAR["adminMenuCurrent"]!='total_download'){?>
			<div class="LNB <?php if($TPL_VAR["lnb_close_yn"]=='y'){?>close<?php }?>">
				<div id="lnbCloseBtn" class="btn_lnb_close">
					<span class="i_lnb_close" <?php if($TPL_VAR["lnb_close_yn"]=='y'){?>seq="<?php echo $TPL_VAR["lnb_close_seq"]?>"<?php }?>></span>
				</div>
				<div class="logo_wrap">
					<a href="/admin">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" href="/admin" width="110px" height="21px" viewBox="0 0 113 21">
							<path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M107.915,20.577 L107.915,0.477 L112.654,0.477 L112.654,20.577 L107.915,20.577 ZM100.808,0.477 L105.546,0.477 L105.546,20.577 L100.808,20.577 L100.808,0.477 ZM94.248,18.988 C93.169,20.703 91.703,20.893 89.755,20.893 C87.044,20.893 84.622,19.548 84.622,16.566 C84.622,12.370 89.176,11.869 91.703,11.869 C92.466,11.869 93.309,11.949 93.914,12.054 C93.887,10.180 92.493,9.679 90.781,9.679 C89.255,9.679 87.634,9.969 86.317,10.708 L86.333,7.489 C88.017,6.803 89.781,6.513 91.809,6.513 C95.310,6.513 98.337,8.017 98.337,12.212 L98.337,17.331 C98.337,18.413 98.347,19.454 98.347,20.577 L94.245,20.577 L94.248,18.988 ZM91.782,14.402 C90.071,14.402 88.724,14.912 88.724,16.255 C88.724,17.222 89.622,17.786 90.800,17.786 C92.708,17.786 93.914,16.121 93.914,14.483 L91.782,14.402 ZM77.596,13.188 C77.596,11.632 77.043,10.471 75.700,10.471 C74.015,10.471 73.015,11.816 73.015,14.772 L73.015,20.577 L68.277,20.577 L68.277,13.188 C68.277,11.632 67.724,10.471 66.381,10.471 C64.696,10.471 63.696,11.816 63.696,14.772 L63.696,20.577 L58.958,20.577 L58.958,6.830 L63.275,6.830 L63.275,9.363 L63.327,9.363 C64.275,7.384 66.171,6.513 68.329,6.513 C70.277,6.513 71.883,7.357 72.620,9.151 C73.726,7.304 75.543,6.513 77.490,6.513 C81.439,6.513 82.334,8.756 82.334,12.476 L82.334,20.577 L77.596,20.577 L77.596,13.188 ZM48.402,15.748 L48.402,10.154 L45.692,10.154 L45.692,6.830 L48.482,6.830 L48.482,3.355 L53.141,3.355 L53.141,6.830 L56.458,6.830 L56.458,10.154 L53.141,10.154 L53.141,15.220 C53.141,16.883 53.536,17.727 55.037,17.727 C55.510,17.727 56.114,17.621 56.588,17.542 L56.588,20.629 C55.694,20.735 54.852,20.893 53.668,20.893 C49.430,20.893 48.402,19.020 48.402,15.748 ZM37.878,20.893 C35.746,20.893 34.193,20.682 32.798,20.234 L32.798,16.777 C33.904,17.252 35.904,17.727 37.615,17.727 C38.589,17.727 39.537,17.569 39.537,16.619 C39.537,14.297 32.798,15.933 32.798,10.972 C32.798,7.806 35.904,6.513 38.642,6.513 C40.274,6.513 41.932,6.698 43.459,7.304 L43.452,10.603 C42.452,9.996 40.590,9.679 39.406,9.679 C38.378,9.679 37.221,9.864 37.221,10.629 C37.221,12.767 44.276,11.078 44.276,16.302 C44.276,19.969 40.984,20.893 37.878,20.893 ZM29.539,10.471 C27.328,10.471 26.090,12.081 26.090,14.772 L26.090,20.577 L21.352,20.577 L21.352,6.830 L25.669,6.830 L25.669,8.963 L25.722,8.963 C26.538,7.221 27.722,6.513 29.776,6.513 C30.329,6.513 30.908,6.592 31.382,6.671 L31.382,10.629 C30.856,10.471 30.092,10.471 29.539,10.471 ZM16.427,5.602 C15.014,5.602 13.868,4.453 13.868,3.036 C13.868,1.619 15.014,0.471 16.427,0.471 C17.841,0.471 18.987,1.619 18.987,3.036 C18.987,4.453 17.841,5.602 16.427,5.602 ZM8.405,20.577 L3.667,20.577 L3.667,10.154 L0.473,10.154 L0.473,6.830 L3.746,6.830 L3.746,5.985 C3.746,1.895 5.667,0.471 9.458,0.471 C10.485,0.471 11.274,0.629 11.879,0.734 L11.879,4.137 C11.484,4.005 10.800,3.795 10.090,3.795 C8.878,3.795 8.405,4.640 8.405,5.985 L8.405,6.830 L11.879,6.830 L11.879,10.154 L8.405,10.154 L8.405,20.577 ZM18.796,20.577 L14.058,20.577 L14.058,6.830 L18.796,6.830 L18.796,20.577 Z"/>
						</svg>
					</a>
					<a href="javascript:void(0);" class="totalMenu">
						<div class="i-total-menu"></div>
					</a>
				</div>

				<div class="submenu-wrapper header-gnb">
<?php if($TPL_adminMenu_1){foreach($TPL_VAR["adminMenu"] as $TPL_K1=>$TPL_V1){?>
<?php if(in_array($TPL_VAR["adminMenuCurrent"],$TPL_V1["folders"])){?>
<?php if(is_array($TPL_R2=$TPL_V1["submenu"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<div class="submenu">
<?php if($TPL_V2["childs"][ 1]){?>
								<ul>
									<li class="<?php if(in_array($TPL_VAR["adminURLCurrent"],$TPL_V2["urls"])){?>current<?php }?> mitem-td" code="<?php echo $TPL_K1?>">
										<div class="name"><?php echo $TPL_V2["name"]?></div>
										<ul class="sub">
<?php if(is_array($TPL_R3=$TPL_V2["childs"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
<?php if($TPL_I3> 0){?>
<?php if($TPL_V3["name"]=='입점사별'){?>
<?php if(serviceLimit('H_AD')){?>
											<li class="<?php if(in_array($TPL_VAR["adminSubMenuCurrent"],$TPL_V3["file"])&&($TPL_VAR["adminMenuCurrent"]==$TPL_V3["folder"])){?>current <?php }?><?php echo $TPL_V3["class"]?>">
												<div class="ico-star" data-tooltip="즐겨찾기 등록 시 상단 메뉴에 노출됩니다."></div>
												<a href="<?php echo $TPL_V3["url"]?>"><?php echo $TPL_V3["name"]?></a>
											</li>
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["adminSubMenuCurrent"]=="member"||$TPL_VAR["adminSubMenuCurrent"]=='marketplace_url'||$TPL_VAR["adminSubMenuCurrent"]=='epc_basic'){?>
											<li class="<?php if(in_array($TPL_VAR["adminSubMenuCurrent"],$TPL_V3["file"])&&($TPL_VAR["adminMenuCurrent"]==$TPL_V3["folder"])&&'../'.$TPL_VAR["adminURLCurrent"]==$TPL_V3["url"]){?>current <?php }?><?php echo $TPL_V3["class"]?>">
<?php }else{?>
											<li class="<?php if(in_array($TPL_VAR["adminSubMenuCurrent"],$TPL_V3["file"])&&($TPL_VAR["adminMenuCurrent"]==$TPL_V3["folder"])&&in_array($TPL_VAR["adminURLCurrent"],$TPL_V2["urls"])){?>current <?php }?><?php echo $TPL_V3["class"]?>">
<?php }?>
<?php if($TPL_V3["limit"]&&serviceLimit($TPL_V3["limit"],'return')){?>
												<a href="#" onclick="<?php echo serviceLimit($TPL_V3["limit"])?>"><?php echo $TPL_V3["name"]?></a>
<?php }else{?>
												<div class="ico-star" data-tooltip="즐겨찾기 등록 시 상단 메뉴에 노출됩니다."></div>
												<a href="<?php echo $TPL_V3["url"]?>">
													<?php echo $TPL_V3["name"]?>

												</a>
<?php }?>
											</li>
<?php }?>
<?php }?>
<?php }}?>
										</ul>
									</li>
								</ul>
<?php }else{?>
<?php if(is_array($TPL_R3=$TPL_V2["childs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
								<div class="<?php if(in_array($TPL_VAR["adminSubMenuCurrent"],$TPL_V3["file"])&&($TPL_VAR["adminMenuCurrent"]==$TPL_V3["folder"])&&in_array($TPL_VAR["adminURLCurrent"],$TPL_V2["urls"])){?>current<?php }?> mitem-td" code="<?php echo $TPL_K1?>" >
									<span class="sub_item <?php echo $TPL_V3["class"]?>">
<?php if($TPL_V3["limit"]&&serviceLimit($TPL_V3["limit"],'return')){?>
									<a href="#" onclick="<?php echo serviceLimit($TPL_V3["limit"])?>" ><?php echo $TPL_V3["name"]?></a>
<?php }else{?>
									<div class="ico-star" data-tooltip="즐겨찾기 등록 시 상단 메뉴에 노출됩니다."></div>
									<a href="<?php echo $TPL_V3["url"]?>"><?php echo $TPL_V3["name"]?></a>
<?php }?>
									</span>
								</div>
<?php }}?>
<?php }?>
						</div>
<?php }}?>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["adminMenuCurrent"]=="design"){?>
						<div class="submenu mitem-td" code="designEdit">
							<div class="sub_item">
								<div class="ico-star" data-tooltip="즐겨찾기 등록 시 상단 메뉴에 노출됩니다."></div>
								<a href="<?php if($TPL_VAR["config_system"]["skin_type"]=='responsive'){?>../design/main?setMode=mobile<?php }else{?>../design/main?setMode=pc<?php }?>" target="_blank">디자인 편집</a>
							</div>
						</div>
						<div class="submenu mitem-td" code="designEditor">
							<div class="sub_item">
								<div class="ico-star" data-tooltip="즐겨찾기 등록 시 상단 메뉴에 노출됩니다."></div>
								<a href="#" onclick="DM_window_eyeeditor('data/skin/<?php echo $TPL_VAR["designWorkingSkin"]?>/main/index.html')">HTML 에디터</a>
							</div>
						</div>
<?php }?>
					<!--
					<ul class="short_cut_wrap">
						<li><a href="" target="_blank">MY 퍼스트몰 <img src="/admin/skin/default/images/common/blue_arrow.png"></a></li>
						<li><a href="" target="_blank">고객센터 <img src="/admin/skin/default/images/common/blue_arrow.png"></a></a></li>
					</ul>
					-->
				</div>
			</div>
<?php }?>
			<!--[ 레프트 메뉴(LNB) : 끝 ]-->
			<?php echo $TPL_VAR["adminMenuSubCurrent"]?>


			<div class="contentsWarp <?php if(in_array($TPL_VAR["adminMenuCurrent"],array('main','realpacking','export_download','total_download'))||$TPL_VAR["lnb_close_yn"]=='y'){?>close<?php }?>">
			<!--[ 레이아웃 바디(본문) : 시작 ]-->