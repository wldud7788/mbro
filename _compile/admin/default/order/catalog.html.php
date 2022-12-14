<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/order/catalog.html 000017109 */ 
$TPL_linkage_mallnames_for_search_1=empty($TPL_VAR["linkage_mallnames_for_search"])||!is_array($TPL_VAR["linkage_mallnames_for_search"])?0:count($TPL_VAR["linkage_mallnames_for_search"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<div id="orderAdminSettle" class="hide"></div>
<div id="issueGoodsSelect" class="hide"></div>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layer_stock.css?v=<?php echo date('Ymd')?>"/>
<style>
	.search_label 	{display:inline-block;white-space:nowrap;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	span.step_title { font-weight:normal;padding:0 5px 0 5px; }
	span.export-list { display:inline-block;background-url("/admin/skin/default/images/common/btn_list_release.gif");width:60px;height:15px; }
	div.btn-open-all{ position:absolute;top:3px;left:-62px;}
	div.btn-open-all img { cursor:pointer; }
	.ft11	{ font-size:11px; }

	.barcode-btn {position:relative; top:-15px; left:5px; cursor:pointer}
	.barcode-btn .openImg{display:block;}
	.barcode-btn .closeImg{display:none;}
	.barcode-btn.opened .openImg{display:none;}
	.barcode-btn.opened .closeImg{display:block;}
	.barcode-description {display:none; background-color:#d2d8d8; border-top:5px solid #f9fbfc; border-bottom:10px solid #f9fbfc; text-align:center}

	.darkgreen { color:#009900; }

	table.export_table {border-collapse:collapse;border:1px solid #c8c8c8;width:100%}
	table.export_table th {padding:5px; border:1px solid #c8c8c8;}
	table.export_table td {padding:5px; border:1px solid #c8c8c8;}
	table.export_table th {background-color:#efefef;}

	.price {padding-right:5px;text-align:right}
	table.order-inner-table td,table.order-inner-table th {height:9px !important; border:0 !important;}
	.ea {font-family:dotum; color:#a400ff;}
	.title_order_number {font-family:dotum;font-size:13px;}

	table.order-summary-table tbody td.pvtd{border:1px solid #dcdde1;text-align:center;background-color:#fff;}
	.coupon_status{color:red}
	.coupon_status_all{color:red}
	.coupon_order_status{color:gray}
	.coupon_status_use{color:blue}
	.coupon_input_value{color:green}

	.url-helper{border:1px solid #424242;background-color:#fff;line-height: 14px;}
	.open-link a:link, .open-link a:active, .open-link a:visited{color: #a7a7a7;}
	.open-link a:hover {color:#f63;}
	.warehouse-info-lay { padding:5px;margin:2px 10px 5px 0;border:1px solid #c5c5c5;background-color:#fff; }

	td.package-option {background-color:#F3FCFF;}
	td.package-option span.title {color:#FF0000;}
	td.package-option div.ea {color:#A400FF;}
	td.package-option div.stock {color:#0066CC;}
	td.package-option div.ablestock {color:#0066CC;}
	#layout-container {min-width: auto;}
	html{overflow-x: hidden;}

	div.sub-choose-lay div.choose-form-lay {top:-10px;right:100px;width:200px;}
	.resp_btn > img, .resp_btn > span {vertical-align:top;}</style>
<script type="text/javascript">
	/* default search */
	var default_search_pageid	= "<?php if($TPL_VAR["sc"]["shipping_provider_seq"]== 1){?>order_company<?php }else{?>order<?php }?>";
	var default_obj_width		= 1100;
	var default_obj_height		= "<?php if($TPL_VAR["sc"]["shipping_provider_seq"]== 1){?>440<?php }else{?>600<?php }?>";

	/* variable for ajax list */
	var npage					= 1;
	var nstep					= '';
	var nnum					= '';
	var stepArr					= new Array();
	var allOpenStep				= new Array();
	var npay_use				= "<?php echo $TPL_VAR["npay_use"]?>";
	var talkbuy_use				= "<?php echo $TPL_VAR["talkbuy_use"]?>";
	var start_search_date		= "<?php echo date('Y-m-d',strtotime('-7 day'))?>";
	var end_search_date			= "<?php echo date('Y-m-d')?>";
	var loading_status			= 'n';
	var searchTime				= "<?php echo date('Y-m-d H:i:s')?>";
	var linkage_mallnames_cnt	= "<?php echo count($TPL_VAR["linkage_mallnames_for_search"])?>";
	var linkage_mallnames		= '<?php echo $TPL_VAR["linkage_mallnames_for_search"][ 0]["mall_code"]?>';

	var pagemode				= '<?php echo $TPL_VAR["pagemode"]?>';
	var detailmode				= '<?php echo $TPL_VAR["detailmode"]?>';
	var shipping_provider_seq	= '<?php echo $TPL_VAR["sc"]["shipping_provider_seq"]?>';
	var bankChk					= '<?php echo $TPL_VAR["bankChk"]?>';

<?php if($_SERVER["QUERY_STRING"]){?>
	var queryString			= '<?php echo $_SERVER["QUERY_STRING"]?>';
<?php }else{?>
	var queryString			= 'noquery=true';
<?php }?>

	/* 스타일적용 */
	apply_input_style();

	function down_list(obj)
	{
		
		location.href='../order/download_list?callPage=<?php echo $TPL_VAR["pagemode"]?>';
		
	}

	/*######################## 16.12.15 gcs yjy : 검색조건 유지되도록 s */
		function orderView(order_seq){
			$("input[name='keyword']").focus();
			$("input[name='no']").val(order_seq);
			var search = location.search;
			search = search.substring(1,search.length);
			$("input[name='query_string']").val(search);				
			$("form[name='search-form']").attr('action','view');
			$("form[name='search-form']").submit();
		}

	/*######################## 16.12.15 gcs yjy : 검색조건 유지되도록 e */

</script>
<script src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('Ymd')?>"></script>
<script src="/app/javascript/js/admin-orderCatalog.js?dummy=<?php echo date('Ymd')?>"></script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area" class="order_catalog_title_bar">
	<div id="page-title-bar">		

		<!-- 타이틀 -->
		<div class="page-title">		
			<h2><?php if($TPL_VAR["pagemode"]=="company_catalog"){?>본사 배송 주문 조회<?php }else{?>전체 주문 조회<?php }?></h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
<?php if($TPL_VAR["pagemode"]!="company_catalog"){?>
<?php if(serviceLimit('H_FR')){?>
			<li><span class="btn large <?php echo serviceLimit('C1')?>"><button type="button" onclick="<?php echo serviceLimit('A1')?>" title="현재 서비스에서는 해당기능이 지원되지 않습니다." class="resp_btn v3 size_L">개인결제 생성하기<span class="arrowright"></span></button></span></li>
			<li><span class="btn large <?php echo serviceLimit('C1')?>"><button type="button" onclick="<?php echo serviceLimit('A1')?>" title="현재 서비스에서는 해당기능이 지원되지 않습니다." class="resp_btn v3 size_L">관리자가 주문넣기<span class="arrowright"></span></button></span></li>
<?php }else{?>
			<li><span class="btn large"><button type="button" name="order_admin_person" class="resp_btn v3 size_L">개인결제 생성하기<span class="arrowright"></span></button></span></li>
			<li><span class="btn large"><button type="button" name="order_admin_settle" class="resp_btn v3 size_L" >관리자가 주문넣기<span class="arrowright"></span></button></span></li>
<?php }?>
<?php }?>
			<li>
				<span class="btn large"><button type="button" name="down_list" onclick="down_list();"  class="resp_btn v3 size_L">다운로드항목설정<span class="arrowright"></span></button></span>
			</li>
			<li><span class="btn large"><button type="button" name="print_setting"  class="resp_btn v3 size_L">프린트설정<span class="arrowright"></span></button></span></li>
			<li><span class="btn large red"><button type="button" onclick="batch_goods_export_popup('');"  class="resp_btn active size_L">출고처리<span class="arrowright"></span></button></span></li>
		</ul>

		<!-- 좌측 버튼 -->
<?php if($TPL_VAR["pagemode"]!="company_catalog"){?>
		<ul class="page-buttons-left box" style="z-index:1;">
			<li class="resp_btn v3 size_L" style="cursor:default;">
				<span>무통장자동입금</span>
				<a href="../setting/bank" target="_blank" >
<?php if($TPL_VAR["bankChk"]=='Y'&&$TPL_VAR["bankCount"]> 0){?>
				<span class="black bold">사용</span>
<?php }else{?>
				<span class="red bold">미사용</span>
<?php }?>
				</a>
			</li>
			<li class="resp_btn v3 size_L"  style="cursor:default;">
				<span>택배 업무 자동화</span>
				<a href="../setting/delivery_company" target="_blank">
<?php if($TPL_VAR["auto_parcel"]=='y'){?>
				<span class="black bold">사용</span>
<?php }else{?>
				<span class="red bold">미사용</span>
<?php }?>
				</a>
			</li>
			<li class="resp_btn v3 size_L"  style="cursor:default;">
				<span>네이버페이</span>
<?php if($TPL_VAR["npay_use"]){?>
				<span id="npay_order_receive" class="hand black bold">주문 바로수집</span네이버페이>
				<span class="helpicon2 detailDescriptionLayerBtn" title="네이버페이 주문 바로수집 안내"></span>
				<div class="detailDescriptionLayer hide" style="width:510px;margin-left:-313px;margin-top:10px;">
					네이버페이 주문은 <strong>매시 정각 마다 자동으로 수집</strong>합니다.<br />
					수동으로 수집을 원하실 경우 <strong>[지금바로 주문수집]</strong>을 이용해 주시기 바랍니다.<br />
					<span class="red">(단, [지금바로 주문수집]시에도 최대 10분 이내의 주문은 수집이 안 될 수도 있습니다.)
				</div>
<?php }else{?>
				<a href="../marketing/marketplace_url" target="_blank"><span class="red bold">미사용</span></a><?php }?>
			</li>
<?php if($TPL_VAR["talkbuy_use"]){?>
			<li style="padding-bottom:4px">
				카카오페이 구매 안내
				<span class="helpicon2 detailDescriptionLayerBtn" title="카카오페이 구매 안내"></span>
				<div class="detailDescriptionLayer hide" style="width:560px;margin-left:-313px;margin-top:10px;">
					- 카카오페이 구매 주문은 주문 발생 시 자동으로 수집합니다.<br />
					- 쇼핑몰에 수집된 카카오페이 구매 주문은 주문접수부터 배송완료까지 주문처리가 가능합니다.<br />
					- 클레임 정보는 카카오페이 구매 파트너 센터와 동기화되지 않기 때문에, <br /> 카카오페이 구매 파트너 센터에서 클레임 내역 확인 후 쇼핑몰에서 별도로 클레임에 대해 수기처리 해주셔야합니다.<br />
					<span class="red">(클레임 수집 연동은 9월 중 업데이트 예정입니다.)
				</div>
				</li>
<?php }?>
			<!--
			<li><span class="btn small orange"><button type="button" class="order_type_help hand" onclick="order_type_help();">안내) 주문유형</button></span></li>
			-->
		</ul>
<?php }?>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 주문리스트 검색폼 : 시작 -->
<div id="order_catalog_search" class="search-form-container-new search_container">
	<form name="search-form" method="get">
	<!--######################## 16.12.15 gcs yjy : 검색조건 유지되도록  -->
	<input type="hidden" name="query_string"/>
	<input type="hidden" name="no" />
	<input type="hidden" name="callPage" value="<?php echo $TPL_VAR["pagemode"]?>" />	
<?php $this->print_("search_form",$TPL_SCP,1);?>

	</form>
</div>
<!-- 주문리스트 검색폼 : 끝 -->

<!-- 주문리스트 테이블 : 시작 -->
<div class="contents_dvs v2">
	<div class="table_wrap">
		<table class="list-table-style table_row_basic pd5" cellspacing="0">
			<!-- 테이블 헤더 : 시작 -->
			<colgroup>
<?php if($TPL_VAR["pagemode"]!="company_catalog"){?>
				<col width="50" />
				<col width="50" />
				<col width="50" />
				<col width="50" />
				<col width="50" />
				<col width="90" />
				<col width="50" />
				<col width="225" />
				<col />
				<col width="70" />
				<col width="70" />
				<col width="120" />
				<col width="120" />
				<col width="80" />
				<col width="80" />
<?php }else{?>
				<col width="50" />
				<col width="50" />
				<col width="50" />
				<col width="50" />
				<col width="90" />
				<col width="50" />
				<col width="240" />
				<col />
				<col width="60" />
				<col width="60" />
				<col width="150" />
				<col width="110" />
<?php }?>
			</colgroup>
			<thead class="lth">
				<tr>
					<th>선택</th>
<?php if($TPL_VAR["pagemode"]!="company_catalog"){?>
					<th>중요</th>
<?php }?>
					<th>번호</th>
					<th>유입</th>
					<th>마켓</th>
					<th>주문일시</th>
					<th>환경</th>
					<th>주문번호</th>
					<th>주문상품</th>
					<th>수(종)</th>
					<th>출고
						<span class="helpicon2 detailDescriptionLayerBtn" title="출고"></span>
						<div class="detailDescriptionLayer hide">해당 주문의 출고리스트를 확인합니다.</div>
					</th>
					<th>받는분/주문자</th>
					<th>결제수단/일시</th>
<?php if($TPL_VAR["pagemode"]!="company_catalog"){?>
					<th>결제금액</th>
					<th>주문상태</th>
<?php }?>
				</tr>
			</thead>
			<!-- 테이블 헤더 : 끝 -->
			<!-- 리스트 : 시작 -->
			<tbody class="ltb order-ajax-list"></tbody>
			<!-- 리스트 : 끝 -->
		</table>
	</div>
</div>

<div id="goods_export_dialog"></div>

<div id="export_upload" class="hide">
<?php $this->print_("excel_export",$TPL_SCP,1);?>

</div>

<div id="excel_code_help" style="display:none;">
<?php $this->print_("excel_delivery_code",$TPL_SCP,1);?>

</div>

<div id="order_type_help" style="display:none;">
	<table width="100%" class="info-table-style">
		<colgroup>
			<col width="15%" />
			<col width="30%" />
			<col width="30%" />
			<col />
		</colgroup>
		<tr>
			<th class="its-th-align"></th>
			<th class="its-th-align">1. 관리자 행동</th>
			<th class="its-th-align">2. 구매자 행동</th>
			<th class="its-th-align">3. 관리자의 주문 처리</th>
		</tr>
		<tr>
			<th class="its-th-align">일반적인 주문</th>
			<td class="its-td-align center">-</td>
			<td class="its-td-align left red pdl5">구매자가 주문서 작성과 결제를 완료함</td>
			<td class="its-td-align left pdl5" rowspan="3">
				<span class="red">모든 주문은 주문리스트에 쌓이며<br/>
				결제완료된 주문건만 출고처리함<br/></span>
				개인결제는 <img src="/admin/skin/default/images/design/icon_order_personal.gif" /> 아이콘 표시됨<br/>
				관리자주문은 <img src="/admin/skin/default/images/design/icon_order_admin.gif" /> 아이콘 표시됨
			</td>
		</tr>
		<tr>
			<th class="its-th-align">개인 결제</th>
			<td class="its-td-align left pdl5">
				<u>관리자는 에누리 금액 적용과 결제수단을 지정하여</u><br />
				구매자 전용의 개인결제를 만들어 줌<br />
				<a href="/admin/order/personal"><span class=" highlight-link-text hand">개인결제리스트</span></a>에 쌓임
			</td>
			<td class="its-td-align left pdl5">
				구매자는 관리자가 만들어준 자신의 개인결제를<br />
				MY페이지에서 확인하고<br />
				<span class="red">구매자가 주문서 작성과 결제를 완료함</span>
			</td>
		</tr>
		<tr>
			<th class="its-th-align">관리자 주문</th>
			<td class="its-td-align left pdl5">
				<u>관리자는 에누리 금액 적용과 무통장결제로</u><br />
				<span class="red">구매자 대신 주문서 작성을 완료함</span>
			</td>
			<td class="its-td-align left red pdl5">구매자가 무통장 입금을 완료함</td>
		</tr>
	</table>
</div>

<div id="openmarket_order_receive_guide" class="hide">
	<span class="fx12">외부 판매마켓에서 발생한 주문은 <strong>매시 20분마다 자동으로 수집</strong>합니다.<br />
	자동으로 수집되는 시간을 기다리기 힘드시면 <strong>[지금바로 주문수집]</strong> 버튼을 클릭하십시오.
	</span>
</div>

<div id="invoice_manual_dialog" class="hide">
<?php $this->print_("invoice_guide",$TPL_SCP,1);?>

</div>

<div id="print_setting_dialog" class="hide" style="line-height:20px;">
<?php $this->print_("print_setting",$TPL_SCP,1);?>

</div>
<div id="openmarket_order_receive_dialog" class="hide">
	<form name="orderReceiveForm" action="../order_process/openmarket_order_receive" target="actionFrame">
	<input type="hidden" name="mall_code" value="" />
	<table class="simpleinfo-table-style" width="100%" border="0" cellpadding="0" cellspacing="0">
		<col /><col width="60" />
<?php if($TPL_linkage_mallnames_for_search_1){foreach($TPL_VAR["linkage_mallnames_for_search"] as $TPL_V1){?>
		<tr>
			<td class="pdl5"><?php echo $TPL_V1["mall_name"]?></td>
			<td align="center">
				<span class="btn small"><input type="button" value="수집" onclick="openmarket_order_receive_submit('<?php echo $TPL_V1["mall_code"]?>')" /></span>
			</td>
		</tr>
<?php }}?>
	</table>
	</form>
</div>

<div id="gift_use_lay"></div>
<div id="excel_download_dialog" style="display:none;">
<?php $this->print_("excel_dwonload",$TPL_SCP,1);?>

</div>
<div id="batch_status_popup_layer"></div>

<!-- 기본검색설정 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchDefaultConfig.js?dummy=<?php echo date('Ymd')?>"></script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>