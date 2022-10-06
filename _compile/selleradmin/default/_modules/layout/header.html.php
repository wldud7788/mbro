<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/_modules/layout/header.html 000020677 */ 
$TPL_env_list_1=empty($TPL_VAR["env_list"])||!is_array($TPL_VAR["env_list"])?0:count($TPL_VAR["env_list"]);
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

	$(function(){
<?php if($TPL_VAR["providerInfo"]["provider_seq"]){?>
		setTimeout(function(){
			loadIssueCounts();
		},500);
<?php }?>
	});
</script>

<body>
<div id="dumy" style="display:none"></div>
<div id="totalMenuDialog" class="dialog" style="display:none"></div>

<!-- 매뉴얼 버튼 -->
<div class="hide">
<a href="#" target="_blank" class="page-manual-btn<?php echo $TPL_VAR["goods_quick_topmenu"]?> resp_btn active2">매뉴얼</a>
</div>

<!-- 다국어 관리환경 이동 -->
<div id="global-setting">
	<div class="global-setting-layer">
		<h1 id="global-title">쇼핑몰1의 현재 페이지에서 → 다음 쇼핑몰의 현재 페이지로 이동 가능합니다.</h1>
		<table width="650" border="0" cellpadding="0" cellspacing="0">
			<colgroup>
				<col /><col /><col width="18%" /><col width="16%" /><col width="16%" />
			</colgroup>
			<thead>
				<tr>
					<th scope="col">관리명</th>
					<th scope="col">사용자 화면</th>
					<th scope="col">안내 언어</th>
					<th scope="col">기준 통화</th>
					<th scope="col">이동</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_env_list_1){foreach($TPL_VAR["env_list"] as $TPL_V1){?>
				<tr>
					<th scope="row" class="center"><?php echo $TPL_V1["admin_env_name"]?></th>
					<td><?php echo $TPL_V1["domain"]?></td>
					<td class="lang_<?php echo $TPL_V1["language"]?>"><?php echo $TPL_V1["lang"]?></td>
					<td><?php echo $TPL_V1["currency"]?></td>
					<td class="center">
<?php if($TPL_V1["this_admin"]=='y'){?>
							<a href="#" class="btn_link">바로가기</a>
<?php }else{?>
							<a href="#" class="btn_link" onclick='env_move("<?php echo $TPL_V1["domain"]?>");'>바로가기</a>
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

		<!--[ 레이아웃 헤더 : 시작 ]-->
		<div id="layout-header">

			<!-- 헤더 상단부 -->
			<ul class="header-snb-container">

				<!-- [ 로고 : 시작 ] -->
				<li class="header_left_dvs">
					<a href="/selleradmin" class="logo">
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
						<form name="headForm" id="headForm2" action="/selleradmin/order/catalog" >
							<input type="hidden" name="searchflag" value="1">
							<div class="search_box">
								<select name="header_search_type" id="header_search_type">
									<option value="order" <?php if($_GET["header_search_type"]=="order"){?>selected<?php }?>>주문</option>
									<option value="export" <?php if($_GET["header_search_type"]=="export"){?>selected<?php }?>>출고</option>

<?php if(!serviceLimit('H_ST')){?>
									<option value="goods" <?php if($_GET["header_search_type"]=="goods"){?>selected<?php }?>>실물</option>
<?php }?>
<?php if(serviceLimit('H_EXAD')||serviceLimit('H_ST')){?>
									<option value="coupon" <?php if($_GET["header_search_type"]=="coupon"){?>selected<?php }?>>티켓</option>
<?php }?>
								</select>
								<input type="text" name="header_search_keyword" id="header_search_keyword"  value="<?php echo $_GET["header_search_keyword"]?>"/>
								<div class="i-search searchBtn"></div>
							</div>

						</form>
					</div>
					<!-- [ 검색창 : 끝 ] -->

					<!-- [ 우측 상단메뉴 : 시작 ] -->
					<ul class="header-snb">
						<li class="item">
							<ul class="top_menu">
								<li class="item hsnb-site"><a href="http://<?php echo $TPL_VAR["pcDomain"]?>/" target="_blank"  title="PC 쇼핑몰 바로가기">PC 쇼핑몰 바로가기</a></li>
								<li class="item hsnb-mini"><a href="http://<?php echo $TPL_VAR["pcDomain"]?>/mshop?m=<?php echo $TPL_VAR["providerInfo"]["provider_seq"]?>" target="_blank" title="미니샵 바로가기">미니샵 바로가기</a></li>
								<li class="item hsnb-qna"><a href="/selleradmin/board/board?id=gs_seller_qna"  title="문의하기">문의하기</a></li>
							</ul>
						</li>
<?php if($TPL_VAR["providerInfo"]["provider_seq"]){?>
						<li class="admin item hsnb-admin">
							<div class="openBtn">
<?php if($TPL_VAR["managerInfo"]["mphoto"]){?>
									<img src="/selleradmin/skin/default/images/main/sell_img.png" width="25" height="25" align="absmiddle" /><?php }else{?><div class="i-my"></div>
<?php }?>
								<span class="manager_id"><span><?php echo $TPL_VAR["providerInfo"]["provider_id"]?></span>님</span>
								<div class="i-arrow"></div>
							</div>
							<!-- 운영자 상세 정보 -->
							<div class="hsnbm-menu hsubmenu hide">
								<div>
									<img class="img_arrow" src="/admin/skin/default/images/common/helper_arrow.png">
									<ul class="info_top">
										<li><img src="/selleradmin/skin/default/images/main/sell_img.png" width="50" height="50" align="absmiddle" /></li>
										<li>
											<p class="manager_yn"><?php if($TPL_VAR["providerInfo"]["pgroup_name"]){?><?php echo $TPL_VAR["providerInfo"]["pgroup_name"]?><?php }else{?>입점사<?php }?></p>
											<p><?php echo $TPL_VAR["providerInfo"]["provider_id"]?></p>
											<p>(<?php echo $TPL_VAR["providerInfo"]["provider_name"]?>)</p>
										</li>
									</ul>
<?php if($TPL_VAR["providerInfo"]["manager_yn"]=='Y'){?>
									<a class="info_btn" href="../setting/provider_reg?no=<?php echo $TPL_VAR["providerInfo"]["provider_seq"]?>">계정 정보</a>
<?php }else{?>
									<a class="info_btn" href="../setting/manager_reg?provider_seq=<?php echo $TPL_VAR["providerInfo"]["sub_provider_seq"]?>">계정 정보</a>
<?php }?>

									<ul class="info_menu">
									<!---
										<li>
											<a href="https://www.firstmall.kr/myshop/shops/<?php echo $TPL_VAR["enc_shopsno"]?>/view" target="_blank" >MY 퍼스트몰</a>
											<a href="https://www.firstmall.kr/ec_hosting/customer/">고객센터</a>
										</li>
<?php if($TPL_VAR["config_system"]["webmail_domain"]){?>
										<li><a href="http://webmail.<?php echo $TPL_VAR["config_system"]["webmail_domain"]?>/admin/adminhome" target="_blank" title="새창열림">웹메일/세금계산서</a></li>
<?php }else{?>
											<li><a href="javascript:openDialogAlert('하이웍스를 신청하지 않으셨거나  쇼핑몰과 별도로 신청을 하셨습니다.<br/>쇼핑몰과 별도로 신청을 하셨다면 퍼스트몰 고객센터 1544-3270 으로 문의주시길 바랍니다.<br/><br/>하이웍스를 신청하려면 My퍼스트몰><a href=\'https://firstmall.kr/myshop\' target=\'_blank\'><span class=\'highlight-link\'>쇼핑몰관리</span></a> 에서 할 수 있습니다.',600,200,function(){});">웹메일/세금계산서</a></li>
<?php }?>
										<li>
											<a href="https://design.firstmall.kr/" target="_blank" >디자인샵</a>
										</li>
										--->
										<li><a href="../login_process/logout">로그아웃 <div class="i-logout"></div></a></li>
									</ul>
								</div>
							</div>
						</li>
<?php }?>
					</ul>
				</li>
				<!-- [ 우측 상단메뉴 : 끝 ] -->
			</ul>

			<!-- [ GNB : 시작 ] -->
			<ul class="header-gnb-container header-gnb">
				<li class="total_menu <?php if($TPL_VAR["adminMenuCurrent"]=='main'||$TPL_VAR["adminMenuCurrent"]=='accountall'||$TPL_VAR["adminMenuCurrent"]=='setting'||$TPL_VAR["adminMenuCurrent"]=='board'){?>close<?php }?>">
					<a href="javascript:void(0);" class="totalMenu">전체보기 <div class="i-total-menu"></div></a>
				</li>
<?php if($TPL_adminMenu_1){foreach($TPL_VAR["adminMenu"] as $TPL_K1=>$TPL_V1){?>
				<li class="<?php if(in_array($TPL_VAR["adminMenuCurrent"],$TPL_V1["folders"])){?>current <?php }?>mitem-td" code="<?php echo $TPL_K1?>">
					<a href="<?php echo $TPL_V1["url"]?>"><span><?php echo $TPL_V1["name"]?></span><div class="header-gnb-issueCount-layer hide" code="<?php echo $TPL_K1?>"></div></a>
					<div class="dropdown">
					</div>
				</li>
<?php }}?>
			</ul>
			<!-- [ GNB : 끝 ] -->
		</div>

		<div id="layout-body">
		<!--[ LNB : 시작 ]-->
<?php if($TPL_VAR["adminMenuCurrent"]!='main'&&$TPL_VAR["adminMenuCurrent"]!='accountall'&&$TPL_VAR["adminMenuCurrent"]!='setting'&&$TPL_VAR["adminMenuCurrent"]!='board'){?>
		<div class="LNB <?php if($TPL_VAR["lnb_close_yn"]=='y'){?>close<?php }?>">
			<div id="lnbCloseBtn" class="btn_lnb_close">
				<span class="i_lnb_close" <?php if($TPL_VAR["lnb_close_yn"]=='y'){?>seq="<?php echo $TPL_VAR["lnb_close_seq"]?>"<?php }?>></span>
			</div>
			<div class="logo_wrap">
				<a href="/admin">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" href="/admin" width="110px" height="21px" viewBox="0 0 113 21">
						<path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M107.915,20.577 L107.915,0.477 L112.654,0.477 L112.654,20.577 L107.915,20.577 ZM100.808,0.477 L105.546,0.477 L105.546,20.577 L100.808,20.577 L100.808,0.477 ZM94.248,18.988 C93.169,20.703 91.703,20.893 89.755,20.893 C87.044,20.893 84.622,19.548 84.622,16.566 C84.622,12.370 89.176,11.869 91.703,11.869 C92.466,11.869 93.309,11.949 93.914,12.054 C93.887,10.180 92.493,9.679 90.781,9.679 C89.255,9.679 87.634,9.969 86.317,10.708 L86.333,7.489 C88.017,6.803 89.781,6.513 91.809,6.513 C95.310,6.513 98.337,8.017 98.337,12.212 L98.337,17.331 C98.337,18.413 98.347,19.454 98.347,20.577 L94.245,20.577 L94.248,18.988 ZM91.782,14.402 C90.071,14.402 88.724,14.912 88.724,16.255 C88.724,17.222 89.622,17.786 90.800,17.786 C92.708,17.786 93.914,16.121 93.914,14.483 L91.782,14.402 ZM77.596,13.188 C77.596,11.632 77.043,10.471 75.700,10.471 C74.015,10.471 73.015,11.816 73.015,14.772 L73.015,20.577 L68.277,20.577 L68.277,13.188 C68.277,11.632 67.724,10.471 66.381,10.471 C64.696,10.471 63.696,11.816 63.696,14.772 L63.696,20.577 L58.958,20.577 L58.958,6.830 L63.275,6.830 L63.275,9.363 L63.327,9.363 C64.275,7.384 66.171,6.513 68.329,6.513 C70.277,6.513 71.883,7.357 72.620,9.151 C73.726,7.304 75.543,6.513 77.490,6.513 C81.439,6.513 82.334,8.756 82.334,12.476 L82.334,20.577 L77.596,20.577 L77.596,13.188 ZM48.402,15.748 L48.402,10.154 L45.692,10.154 L45.692,6.830 L48.482,6.830 L48.482,3.355 L53.141,3.355 L53.141,6.830 L56.458,6.830 L56.458,10.154 L53.141,10.154 L53.141,15.220 C53.141,16.883 53.536,17.727 55.037,17.727 C55.510,17.727 56.114,17.621 56.588,17.542 L56.588,20.629 C55.694,20.735 54.852,20.893 53.668,20.893 C49.430,20.893 48.402,19.020 48.402,15.748 ZM37.878,20.893 C35.746,20.893 34.193,20.682 32.798,20.234 L32.798,16.777 C33.904,17.252 35.904,17.727 37.615,17.727 C38.589,17.727 39.537,17.569 39.537,16.619 C39.537,14.297 32.798,15.933 32.798,10.972 C32.798,7.806 35.904,6.513 38.642,6.513 C40.274,6.513 41.932,6.698 43.459,7.304 L43.452,10.603 C42.452,9.996 40.590,9.679 39.406,9.679 C38.378,9.679 37.221,9.864 37.221,10.629 C37.221,12.767 44.276,11.078 44.276,16.302 C44.276,19.969 40.984,20.893 37.878,20.893 ZM29.539,10.471 C27.328,10.471 26.090,12.081 26.090,14.772 L26.090,20.577 L21.352,20.577 L21.352,6.830 L25.669,6.830 L25.669,8.963 L25.722,8.963 C26.538,7.221 27.722,6.513 29.776,6.513 C30.329,6.513 30.908,6.592 31.382,6.671 L31.382,10.629 C30.856,10.471 30.092,10.471 29.539,10.471 ZM16.427,5.602 C15.014,5.602 13.868,4.453 13.868,3.036 C13.868,1.619 15.014,0.471 16.427,0.471 C17.841,0.471 18.987,1.619 18.987,3.036 C18.987,4.453 17.841,5.602 16.427,5.602 ZM8.405,20.577 L3.667,20.577 L3.667,10.154 L0.473,10.154 L0.473,6.830 L3.746,6.830 L3.746,5.985 C3.746,1.895 5.667,0.471 9.458,0.471 C10.485,0.471 11.274,0.629 11.879,0.734 L11.879,4.137 C11.484,4.005 10.800,3.795 10.090,3.795 C8.878,3.795 8.405,4.640 8.405,5.985 L8.405,6.830 L11.879,6.830 L11.879,10.154 L8.405,10.154 L8.405,20.577 ZM18.796,20.577 L14.058,20.577 L14.058,6.830 L18.796,6.830 L18.796,20.577 Z"/>
					</svg>
					<a href="javascript:void(0);" class="totalMenu">
						<div class="i-total-menu"></div>
					</a>
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
									<div><?php echo $TPL_V2["name"]?></div>
									<ul class="sub">
<?php if(is_array($TPL_R3=$TPL_V2["childs"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
<?php if($TPL_I3> 0){?>
<?php if($TPL_VAR["adminSubMenuCurrent"]=="member"||$TPL_VAR["adminSubMenuCurrent"]=='marketplace_url'||$TPL_VAR["adminSubMenuCurrent"]=='epc_basic'){?>
										<li class="<?php if(in_array($TPL_VAR["adminSubMenuCurrent"],$TPL_V3["file"])&&($TPL_VAR["adminMenuCurrent"]==$TPL_V3["folder"])&&'../'.$TPL_VAR["adminURLCurrent"]==$TPL_V3["url"]){?>current <?php }?><?php echo $TPL_V3["class"]?>" ><?php echo $TPL_V2["limit"]?>

<?php }else{?>
										<li class="<?php if(in_array($TPL_VAR["adminSubMenuCurrent"],$TPL_V3["file"])&&($TPL_VAR["adminMenuCurrent"]==$TPL_V3["folder"])&&in_array($TPL_VAR["adminURLCurrent"],$TPL_V2["urls"])){?>current<?php }?> <?php echo $TPL_V3["class"]?>" ><?php echo $TPL_V2["limit"]?>

<?php }?>
<?php if($TPL_V3["limit"]&&serviceLimit($TPL_V3["limit"],'return')){?>
											<div class="ico-star" data-tooltip="즐겨찾기 등록 시 상단 메뉴에 노출됩니다."></div>
											<a href="#" onclick="<?php echo serviceLimit($TPL_V3["limit"])?>"><?php echo $TPL_V3["name"]?></a>
<?php }else{?>
											<div class="ico-star" data-tooltip="즐겨찾기 등록 시 상단 메뉴에 노출됩니다."></div>
											<a href="<?php echo $TPL_V3["url"]?>"><?php echo $TPL_V3["name"]?></a>
<?php }?>
										</li>
<?php }?>
<?php }}?>
									</ul>
								</li>
							</ul>
<?php }else{?>
<?php if(is_array($TPL_R3=$TPL_V2["childs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
							<div class="<?php if(in_array($TPL_VAR["adminSubMenuCurrent"],$TPL_V3["file"])){?>current<?php }?> mitem-td" code="<?php echo $TPL_K1?>" >
								<span class="sub_item <?php echo $TPL_V3["class"]?>">
<?php if($TPL_V2["limit"]&&serviceLimit($TPL_V3["limit"],'return')){?>
									<div class="ico-star" data-tooltip="즐겨찾기 등록 시 상단 메뉴에 노출됩니다."></div>
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
					<div class="submenu"><div><a href="<?php if($TPL_VAR["config_system"]["skin_type"]=='responsive'){?>../design/main?setMode=mobile<?php }else{?>../design/main?setMode=pc<?php }?>" target="_blank">디자인 편집</a></div></div>
					<div class="submenu"><div><a href="#" onclick="DM_window_eyeeditor('data/skin/<?php echo $TPL_VAR["designWorkingSkin"]?>/main/index.html')">HTML 에디터</a></div></div>
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
		<!--[ LNB : 끝 ]-->

		<div class="contentsWarp <?php if(in_array($TPL_VAR["adminMenuCurrent"],array('main','accountall','setting','board'))||$TPL_VAR["lnb_close_yn"]=='y'){?>close<?php }?>">
		<!--[ 레이아웃 바디(본문) : 시작 ]-->