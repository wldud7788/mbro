<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/export/catalog.html 000031674 */ 
$TPL_arr_search_keyword_1=empty($TPL_VAR["arr_search_keyword"])||!is_array($TPL_VAR["arr_search_keyword"])?0:count($TPL_VAR["arr_search_keyword"]);
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);
$TPL_ship_set_code_1=empty($TPL_VAR["ship_set_code"])||!is_array($TPL_VAR["ship_set_code"])?0:count($TPL_VAR["ship_set_code"]);
$TPL_delivery_company_array_1=empty($TPL_VAR["delivery_company_array"])||!is_array($TPL_VAR["delivery_company_array"])?0:count($TPL_VAR["delivery_company_array"]);
$TPL_international_company_array_1=empty($TPL_VAR["international_company_array"])||!is_array($TPL_VAR["international_company_array"])?0:count($TPL_VAR["international_company_array"]);
$TPL_referer_list_1=empty($TPL_VAR["referer_list"])||!is_array($TPL_VAR["referer_list"])?0:count($TPL_VAR["referer_list"]);
$TPL_linkage_mallnames_for_search_1=empty($TPL_VAR["linkage_mallnames_for_search"])||!is_array($TPL_VAR["linkage_mallnames_for_search"])?0:count($TPL_VAR["linkage_mallnames_for_search"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-exportCatalog.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-shipping.js?v=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-orderExportPopup.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js?v=<?php echo date('Ymd')?>"></script>
<script type="text/javascript">
	//기본검색설정
	var default_search_pageid	= "export";
	var default_obj_width		= 1100;
	var default_obj_height		= 430;
	var keyword					= "<?php echo $TPL_VAR["sc"]["keyword"]?>";
	var search_type				= "<?php echo $TPL_VAR["sc"]["search_type"]?>";

	var chk_export_msg			= '상태변경할 출고를 선택하세요.';
	var chk_save_msg			= '저장할 출고를 선택하세요.';

	/* variable for ajax list */
	var npage					= 1;
	var nstep					= '';
	var nnum					= '';
	var stepArr					= new Array();
	var npay_use				= "<?php echo $TPL_VAR["npay_use"]?>";
	var start_search_date		= "<?php echo date('Y-m-d',strtotime('-7 day'))?>";
	var end_search_date			= "<?php echo date('Y-m-d')?>";
	var loading_status			= 'n';
	var searchTime				= "<?php echo date('Y-m-d H:i:s')?>";
	var linkage_mallnames_cnt	= "<?php echo count($TPL_VAR["linkage_mallnames_for_search"])?>";
	var linkage_mallnames		= '<?php echo $TPL_VAR["linkage_mallnames_for_search"][ 0]["mall_code"]?>';

	var shipping_provider_seq	= '<?php echo $TPL_VAR["sc"]["shipping_provider_seq"]?>';

<?php if($_SERVER["QUERY_STRING"]){?>
	var queryString			= '<?php echo $_SERVER["QUERY_STRING"]?>';
<?php }else{?>
	var queryString			= 'noquery=true';
<?php }?>

	var search_default_date_today	= "<?php echo date('Y-m-d')?>";
	var search_default_date_3day	= "<?php echo date('Y-m-d',strtotime("-3 day"))?>";
	var search_default_date_7day	= "<?php echo date('Y-m-d',strtotime("-7 day"))?>";
	var search_default_date_1month	= "<?php echo date('Y-m-d',strtotime("-1 month"))?>";
	var search_default_date_3month	= "<?php echo date('Y-m-d',strtotime("-3 month"))?>";

	$(document).ready(function() {

<?php if(serviceLimit('H_NFR')){?>
		$("#coupon_use_excel_btn").live("click",function(){
			openDialog("티켓사용내역 다운로드", "coupon_use_excel_dialog", {"width":"500"});
		});
<?php }?>

	});
</script>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/searchform.css?v=<?php echo date('Ymd')?>" />
<style>
	.goods_name {display:inline-block;white-space:nowrap;overflow:hidden;width:290px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	.search_label 	{display:inline-block;width:100px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	span.price {display:inline-block;width:80px;text-align:right;}
	/*span.icon-buy-confirm{display:inline-block;width:22px;height:15px;background:url('/admin/skin/default/images/common/icon/icon_buy_decide.gif')}*/
	span.icon-buy-confirm{display:inline-block;height:15px;background:url('/admin/skin/default/images/common/icon/icon_order_dcd.gif')}
	span.icon-buy-none{display:inline-block;height:15px;}
	.list-table-style .delivery_lay .resp_btn {margin-top:0 !important;}

	.waybill_number {font-size:11px;width:80px;}
	.delivery_number {width:90%; }
	.ea {color:#a400ff;;}

	table.export_table {border-collapse:collapse;border:1px solid #c8c8c8;width:100%}
	table.export_table th {padding:5px; border:1px solid #c8c8c8;}
	table.export_table td {padding:5px; border:1px solid #c8c8c8;}
	table.export_table th {background-color:#efefef;}

	table.store-stock tr:first-child th.redbox:nth-last-child(1) {
		border-top:2px solid red !important ;
		border-right:2px solid red !important ;
	}
	table.store-stock tr:first-child th {
		border-top:2px solid black !important ;
	}
	table.store-stock tr:nth-last-child(1) td {
		border-bottom:2px solid black !important ;
	}
	table.store-stock tr td:first-child {
		border-left:2px solid black !important ;
	}
	table.store-stock tr th:first-child {
		border-left:2px solid black !important ;
	}
	table.store-stock tr td.redbox:nth-last-child(2) {
		border-left:2px solid red !important ;
	}
	table.store-stock tr td.redbox:nth-last-child(1) {
		border-right:2px solid red !important ;
	}
	table.store-stock tr:last-child td.redbox:nth-last-child(2) {
		border-bottom:2px solid red !important ;
	}
	table.store-stock tr:last-child td.redbox:nth-last-child(1) {
		border-bottom:2px solid red !important ;
	}
	table.store-stock tr:first-child th.redbox:nth-last-child(2) {
		border-top:2px solid red !important ;
		border-left:2px solid red !important ;
	}
	table.store-stock tr th,td {
		line-height:120% !important;
	}
	
</style>

<div class="hide">
<form name="batch_form" method="post" action="../export_process/batch_waybill_number" target="actionFrame"></form>
</div>
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">	
			<h2>출고 조회</h2>			
		</div>		

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li>
<?php if(serviceLimit('H_FR')){?>
				<span class="btn large <?php echo serviceLimit('C1')?>"><button type="button" onclick="<?php echo serviceLimit('A1')?>" class="resp_btn v3 size_L"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> 티켓사용내역 다운로드</button></span>
<?php }else{?>
				<span class="btn large green"><button type="button" id="coupon_use_excel_btn" class="resp_btn v3 size_L"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> 티켓사용내역 다운로드</button></span>
<?php }?>
			</li>
			<li><span class="btn large"><button type="button" id="waybill_number_modify" class="resp_btn v3 size_L">출고정보수정</button></span></li>
			<li><span class="btn large"><button name="print_setting" class="resp_btn v3 size_L">프린트설정<span class="arrowright"></span></button></span></li>
			<li><span class="btn large red"><button name="complete_export"  id="45" onclick="batch_change_status();" class="resp_btn active size_L">출고상태변경</button></span></li>
		</ul>

		<ul class="page-buttons-left">
			<li><span class="btn large orange"><button type="button" onclick="window.open('../realpacking/main','_REALPACKING');" class="resp_btn v2 size_L">리얼패킹-포장촬영</button></span></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 주문리스트 검색폼 : 시작 -->
<div class="search-form-container-new search_container w1280">
	<form name="search-form" method="get">
	<!--######################## 16.12.15 gcs yjy : 검색조건 유지되도록  -->
	<input type="hidden" name="no" value="">
	<input type="hidden" name="query_string" value="">	
	<input type="hidden" name="excel_type" value="" />
	<input type="hidden" name="status" value="" />
	<input type="hidden" name="export_code" value="" />
	<input type="hidden" name="criteria" value="" />
	<table class="table_search">
		<tr>
			<th>검색어</th>
			<td>						
				<div class="relative">
					<input type="text" name="keyword" id="search_keyword" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" title="<?php echo implode(',',$TPL_VAR["arr_search_keyword"])?>" size="100" autocomplete='off'/>
					<!-- 검색어 입력시 레이어 박스 : start -->
					<div class="search_type_text hide"><?php echo $TPL_VAR["sc"]["keyword"]?></div>
					<div class="searchLayer hide">
						<input type="hidden" name="search_type" id="search_type" value="" />
						<ul class="searchUl">
							<li><a class="link_keyword" s_type="all" href="#"><span class="txt_keyword"></span> <span class="txt_title">-전체검색</span></a></li>
<?php if($TPL_arr_search_keyword_1){$TPL_I1=-1;foreach($TPL_VAR["arr_search_keyword"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
							<li <?php if($TPL_I1== 0||$TPL_K1=='ord.recipient_cellphone'||$TPL_K1=='oitem.goods_name'){?>style="margin-top:10px;"<?php }?>><a class="link_keyword" s_type="<?php echo $TPL_K1?>" href="#"><?php echo $TPL_V1?>: <span class="txt_keyword"></span> <span class="txt_title">-<?php echo $TPL_V1?>로 찾기</span></a></li>
<?php }}?>
						</ul>
					</div>
					<!-- 검색어 입력시 레이어 박스 : end -->
				</div>
			</td>
		</tr>
	</table>

	<table class="search-form-table search-detail-lay" id="search_detail_table">
		<tr>
			<td>
				<table class="sf-option-table table_search">
							
<?php if(serviceLimit('H_AD')){?>
					<tr>
						<th>배송책임</th>
						<td colspan="3">
							<div class="ui-widget" >
								<select name="provider_seq_selector" default_none>
									<option value="0">=배송책임검색=</option>
									<option value="1">본사(admin)</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1["provider_seq"]?>" <?php if($TPL_VAR["sc"]["provider_seq"]==$TPL_V1["provider_seq"]){?>selected<?php }?>><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }}?>
								</select>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $TPL_VAR["sc"]["provider_seq"]?>" />
								<input type="text" name="provider_name" value="<?php echo $TPL_VAR["sc"]["provider_name"]?>" style="width:158px;" readonly default_none />
							</div>
							<script>
								$(function(){
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
									.next(".ui-combobox").children("input")
									.bind('focus',function(){
										if($(this).val()==$( "select[name='provider_seq_selector'] option:first-child" ).text()){
											$(this).val('');
										}
									})
									.bind('mouseup',function(){
										if($(this).val()==''){
											$( "select[name='provider_seq_selector']").next(".ui-combobox").children("a.ui-combobox-toggle").click();
										}
									});
								});
							</script>
						</td>
					</tr>
<?php }?>
					<tr>
						<th>날짜</th>
						<td colspan="3">
							<select class="search_select line" style="width:110px;" name="date">
								<option value="order" <?php if($TPL_VAR["sc"]["date"]=='order'){?>selected<?php }?>>주문일</option>
								<option value="export"  <?php if($TPL_VAR["sc"]["date"]=='export'){?>selected<?php }?>>출고일(입력)</option>
								<option value="regist_date"  <?php if($TPL_VAR["sc"]["date"]=='regist_date'){?>selected<?php }?>>출고일</option>
								<option value="shipping"  <?php if($TPL_VAR["sc"]["date"]=='shipping'){?>selected<?php }?>>배송완료일</option>
								<option value="confirm_date"  <?php if($TPL_VAR["sc"]["date"]=='confirm_date'){?>selected<?php }?>>구매확정일</option>
							</select>
							<input type="text" name="regist_date[]" value="<?php echo $TPL_VAR["sc"]["regist_date"][ 0]?>" class="datepicker"  maxlength="10" default_none />
							&nbsp;<span class="gray">-</span>&nbsp;
							<input type="text" name="regist_date[]" value="<?php echo $TPL_VAR["sc"]["regist_date"][ 1]?>" class="datepicker" maxlength="10" default_none />
							&nbsp;&nbsp;
							<span class="resp_btn_wrap">
								<span class="btn small"><input type="button" id="today" value="오늘" class="select_date resp_btn" /></span>
								<span class="btn small"><input type="button" id="3day" value="3일간" class="select_date resp_btn" /></span>
								<span class="btn small"><input type="button" id="1week" value="일주일" class="select_date resp_btn" /></span>
								<span class="btn small"><input type="button" id="1month" value="1개월" class="select_date resp_btn" /></span>
								<span class="btn small"><input type="button" id="3month" value="3개월" class="select_date resp_btn" /></span>
								<span class="btn small"><input type="button" id="1year" value="1년" class="select_date resp_btn"/></span>
							</span>
						</td>
					</tr>
					<tr>
						<th>출고상태</th>
						<td colspan="3">							
<?php if(is_array($TPL_R1=config_load('export_status'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
							<label class="resp_checkbox"><input type="checkbox" name="export_status[<?php echo $TPL_K1?>]" value="1" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php if($TPL_VAR["sc"]["export_status"][$TPL_K1]== 1){?>
							<script type="text/javascript">$("input[name='export_status[<?php echo $TPL_K1?>]']").attr('checked',true);</script>
<?php }?>
<?php }}?>
							<span class="icon-check hand all-check ml5"><b>전체</b></span>
							&nbsp;&nbsp;&nbsp;<span class="desc">|</span>&nbsp;&nbsp;&nbsp;
							<label class="resp_checkbox"><input type="checkbox" name="chk_bundle_yn" value="1" <?php if($TPL_VAR["sc"]["chk_bundle_yn"]=='1'){?>checked<?php }?>/> <span>합포장(묶음배송)</span>
							<span class="helpicon" title="합포장(묶음배송)으로 출고된 출고건을 검색합니다."></span></label>							
						</td>
					</tr>
					<tr>
						<th>
							구매확정
							<span class="helpicon2 detailDescriptionLayerBtn" title="구매확정"></span>
							<!-- 구매확정 설명 -->
							<div class="detailDescriptionLayer wx300 hide">구매확정 기능 사용 시 구매확정 여부를 검색</div>
						</th>
						<td colspan="3">							
							<div class="resp_checkbox">
							<label><input type="checkbox" name="buy_confirm[ok]" value="1" <?php if($TPL_VAR["sc"]["buy_confirm"]['ok']=='1'){?>checked<?php }?> /> 구매확정 완료 (출고상태 : 배송완료)</label>
							<label><input type="checkbox" name="buy_confirm[standby]" value="1" <?php if($TPL_VAR["sc"]["buy_confirm"]['standby']=='1'){?>checked<?php }?> row_check_all /> 구매확정 대기 (출고상태 : 출고완료, 배송중, 배송완료)</label>
							<span class="icon-check hand all-check hide"><b>전체</b></span>
							</div>
						</td>
					</tr>
					<tr>
						<th>
							출고방법
							<span class="helpicon2 detailDescriptionLayerBtn" title="출고방법"></span>
							<!-- 출고방법 설명 -->
							<div class="detailDescriptionLayer wx350 hide">선택된 배송국가의 배송방법으로 출고된 출고 조회</div>
						</th>
						<td>							
							<label style="display:inline-block;;" class="resp_checkbox"><input type="checkbox" class="shipping_nation" name="search_shipping_nation[kr]" value="kr" <?php if($TPL_VAR["sc"]["search_shipping_nation"]['kr']){?>checked<?php }?> /> 대한민국</label>
							(<?php if($TPL_ship_set_code_1){$TPL_I1=-1;foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
							<label style="display:inline-block;<?php if($TPL_I1<(count($TPL_VAR["ship_set_code"])- 1)){?>;<?php }?>" class="resp_checkbox"><input type="checkbox" name="search_shipping_method_kr[<?php echo $TPL_K1?>]" class="set_code ship_kr" value="<?php echo $TPL_K1?>" <?php if(!$TPL_VAR["sc"]["search_shipping_nation"]['kr']){?>disabled
<?php }?> <?php if($TPL_VAR["sc"]["search_shipping_method_kr"][$TPL_K1]){?>checked<?php }?> /> <span class="fx11"><?php echo $TPL_V1?></span></label>
<?php }}?>)
							<span class="icon-check hand all-check ml5"><b>전체</b></span>
						</td>
						<td>
							<label style="display:inline-block;" class="resp_checkbox"><input type="checkbox" class="shipping_nation" name="search_shipping_nation[gl]" value="gl" <?php if($TPL_VAR["sc"]["search_shipping_nation"]['gl']){?>checked<?php }?> /> 해외국가</label> 
							(<?php if($TPL_ship_set_code_1){$TPL_I1=-1;foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
							<label class="resp_checkbox" style="display:inline-block;<?php if($TPL_I1<(count($TPL_VAR["ship_set_code"])- 1)){?>;<?php }?>"><input type="checkbox" name="search_shipping_method_gl[<?php echo $TPL_K1?>]" class="set_code ship_gl" value="<?php echo $TPL_K1?>" <?php if(!$TPL_VAR["sc"]["search_shipping_nation"]['gl']){?>disabled<?php }?> <?php if($TPL_VAR["sc"]["search_shipping_method_gl"][$TPL_K1]){?>checked<?php }?> /> <span class="fx11"><?php echo $TPL_V1?></span></label>
<?php }}?>)
							<span class="icon-check hand all-check ml5"><b>전체</b></span>
						</td>
						<td >
							<label style="display:inline-block;padding-right:10px;" class="resp_checkbox"><input type="checkbox" name="search_shipping_method_coupon" value="coupon" <?php if($TPL_VAR["sc"]["search_shipping_method_coupon"]){?>checked<?php }?> /> 문자/이메일 <span class="fx11">(티켓발송)</span></label> 
						</td>											
					</tr>
					<tr>
						<th>
							택배정보
							<span class="helpicon2 detailDescriptionLayerBtn" title="택배정보"></span>
							<!-- 택배정보 설명 -->
							<div class="detailDescriptionLayer wx350 hide">출고방법이 택배일 때 운송장번호로 해당 출고건 검색</div>
						</th>
						<td colspan="3">
<?php if($TPL_VAR["delivery_company_array"]||$TPL_VAR["international_company_array"]){?>
							<select name="search_delivery_company_code" class="waybill_number line" style="width:120px;">
								<option value=''>전체</option>
<?php if($TPL_delivery_company_array_1){foreach($TPL_VAR["delivery_company_array"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1==$TPL_VAR["sc"]["search_delivery_company_code"]){?>
								<option value='<?php echo $TPL_K1?>' selected><?php echo $TPL_V1["company"]?></option>
<?php }else{?>
								<option value='<?php echo $TPL_K1?>'><?php echo $TPL_V1["company"]?></option>
<?php }?>
<?php }}?>
<?php if($TPL_international_company_array_1){foreach($TPL_VAR["international_company_array"] as $TPL_V1){?>
<?php if($TPL_V1["company"]==$TPL_VAR["sc"]["search_delivery_company_code"]){?>
								<option value='<?php echo $TPL_V1["company"]?>' selected><?php echo str_replace('선불 > ','',$TPL_V1["method"])?></option>
<?php }else{?>
								<option value='<?php echo $TPL_V1["company"]?>'><?php echo str_replace('선불 > ','',$TPL_V1["method"])?></option>
<?php }?>
<?php }}?>
							</select>
<?php }?>
							<input type="text" name="search_delivery_number" class="line" value="<?php echo $TPL_VAR["sc"]["search_delivery_number"]?>" />&nbsp;
							<label class="resp_checkbox"><input type="checkbox" name="null_delivery_number" value= "1" /> 운송장번호 없음</label>
<?php if($TPL_VAR["sc"]["null_delivery_number"]){?>
							<script type="text/javascript">
							$("input[name='null_delivery_number']").attr('checked',true);
							</script>
<?php }?>
						</td>
					</tr>
<?php if($TPL_VAR["linkage_mallnames_for_search"]){?>
					<tr>
						<th>판매마켓</th>
						<td colspan="3">
							<label class="mr5 resp_checkbox"><input type="checkbox" name="not_linkage_order" value="1" <?php if($TPL_VAR["sc"]["not_linkage_order"]){?>checked="checked"<?php }?> /> 운영쇼핑몰</label>
							<select name="referer" class="line mr10" style="min-width:100px">
								<option value="">선택하세요</option>
<?php if($TPL_referer_list_1){foreach($TPL_VAR["referer_list"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["referer_group_name"]?>" <?php if($TPL_VAR["sc"]["referer"]==$TPL_V1["referer_group_name"]){?>selected<?php }?>><?php echo $TPL_V1["referer_group_name"]?></option>
<?php }}?>
								<option value="기타" <?php if($TPL_VAR["sc"]["referer"]=='기타'){?>selected<?php }?>>기타</option>
							</select>
<?php if($TPL_linkage_mallnames_for_search_1){$TPL_I1=-1;foreach($TPL_VAR["linkage_mallnames_for_search"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1&&$TPL_I1% 5== 0){?><br /><?php }?>
<?php if($TPL_VAR["sc"]["linkage_mall_code"][$TPL_V1["mall_code"]]){?>
								<label><input type="checkbox" name="linkage_mall_code[<?php echo $TPL_V1["mall_code"]?>]" value="<?php echo $TPL_V1["mall_code"]?>" checked="checked" /> <?php echo $TPL_V1["mall_name"]?></label>
<?php }else{?>
								<label><input type="checkbox" name="linkage_mall_code[<?php echo $TPL_V1["mall_code"]?>]" value="<?php echo $TPL_V1["mall_code"]?>" /> <?php echo $TPL_V1["mall_name"]?></label>
<?php }?>
<?php }}?>
							<label class="mr10 resp_checkbox"><input type="checkbox" name="etc_linkage_order" value="1" <?php if($TPL_VAR["sc"]["etc_linkage_order"]){?>checked="checked"<?php }?> /> 그 외 마켓</label>
							<span class="icon-check hand all-check"><b>전체</b></span>&nbsp; 
							<span class="btn medium"><button type="button" name="openmarket_order_receive_guide" class="resp_btn v3">자동수집 안내<span class="arrowright"></span></button></span>
						</td>
					</tr>
<?php }?>
				</table>
			</td>
		</tr>
	</table>	

	<div class="footer search_btn_lay">
		<div>	
			<span class="sc_edit">
				<button type="button" id="set_default_setting_button" class="resp_btn v3">기본검색설정</button>
				<button type="button" id="set_default_apply_button" onclick="set_search_form('export')" class="resp_btn v3">기본검색적용</button>		
			</span>	
			<span class="search">	
				<button type="submit" class="resp_btn active size_XL"><span>검색</span></button>	
				<button type="button" id="btn-reset"  onclick="reset_search_form();" class="resp_btn v3 size_XL">초기화</button>		
			</span>				
			<span class="detail">	
				<button type="button" id="search_detail_button" class="close resp_btn v3" value="open">상세검색닫기</button>	
			</span>			
		</div>
	</div>
	</form>
</div>
<!-- 주문리스트 검색폼 : 끝 -->

<!-- 주문리스트 테이블 : 시작 -->
<div class="contents_dvs v2">
<table class="list-table-style table_row_basic pd5" cellspacing="0" border="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="40" /><!--선택-->
		<col width="40" /><!--중요-->
		<col width="40" /><!--번호-->
		<col width="80" /><!--원주문-->
		<col width="135" /><!--출고일-->
		<col width="178" /><!--출고번호-->
		<col /><!--출고상품-->
		<col width="60" /><!--수(종)-->
		<col width="210" /><!--받는분-->
		<col width="155" /><!--출고일-->
		<col width="260" /><!--출고정보-->
	</colgroup>
	<thead class="lth">
		<tr>
			<th><input type="checkbox" name="" value="" class="resp_checkbox"/></th>
			<th><span class="icon-star-gray"></span></th>
			<th>번호</th>
			<th>
				원주문
				<span class="helpicon" title="해당 출고의 원래 주문내역과 해당 주문의 모든 출고건을 확인 할 수 있습니다."></span>
			</th>
			<th>상태변경일시</th>
			<th>출고번호</th>
			<th>출고상품</th>
			<th>수(종)</th>
			<th>받는분/주문자</th>
			<th>출고일</th>
			<th>출고정보</th>
		</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->
	<!-- 리스트 : 시작 -->
	<tbody class="ltb export-ajax-list"></tbody>
	<!-- 리스트 : 끝 -->
</table>
</div>

<div id="goods_export_dialog"></div>

<div id="export_upload" class="hide">
<form name="excelRegist" id="excelRegist" method="post" action="../export_process/excel_upload" enctype="multipart/form-data"  target="actionFrame" onsubmit="loadingStart();">
<table class="search-form-table" style="width:100%;">
<tr>
	<td height="20">① <b class="red">출고내역</b>을 파일 다운로드(.xls) 하십시오.</td>
</tr>
<tr>
	<td height="20">② 파일을 수정(출고완료일, 택배사코드, 송장번호) 하십시오.</td>
</tr>
<?php if($TPL_VAR["config_system"]["invoice_use"]){?>
<tr>
	<td height="20" class="bold red">　 단, 택배업무자동화 서비스가 되는 택배사코드는 송장번호를 입력하지 마십시오.</td>
</tr>
<tr>
	<td height="20" class="bold red">　 택배업무 자동화 서비스 : <?php if(is_array($TPL_R1=get_invoice_company())&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?><?php echo $TPL_V1["company"]?> / <?php echo $TPL_K1?><?php }}?></td>
</tr>
<?php }?>
<tr>
	<td height="20">③ 수정된 파일을 'EXCEL 97~2003 통합문서(*.xls)'로 저장하십시오.</td>
</tr>
<tr>
	<td height="20">④ 아래에서 수정된 파일을 업로드 하십시오.</td>
</tr>
<tr>
	<td style="height:30px; line-height:30px; text-align:center;"><input type="file" name="excel_file" id="excel_file"/></td>
</tr>
<tr><td height="15"></td></tr>
</table>

<table class="info-table-style" style="width:100%">
<tr>
	<th class="its-th-align left" style="padding-left:20px;">
		<div style="height:25px;line-height:25px;">* 업로드 후 처리완료 메시지를 확인하십시오.</div>
		<div style="height:25px;line-height:25px;">* 메시지 확인 후 바로 처리 결과내역을 엑셀로 다운로드 받을 수 있습니다.</div>
		<div style="height:25px;line-height:25px;">* 반드시 처리 결과내역을 확인하십시오.</div>
	</th>
</tr>
</table>

<div style="width:100%;text-align:center;padding-top:10px;">
<span class="btn large cyanblue"><button id="upload_submit">확인</button></span>
</div>

<div class="item-title">택배사 코드 안내</div>
<table class="info-table-style table_row_basic v2 v4" style="width:100%">
<colgroup>
	<col width="26%" />
	<col width="24%" />
	<col width="26%" />
	<col width="24%" />
</colgroup>
<thead>
<tr>
	<th class="its-th-align center">택배사</th>
	<th class="its-th-align center">코드</th>
	<th class="its-th-align center">택배사</th>
	<th class="its-th-align center">코드</th>
</tr>
</thead>
<tbody>
<tr>
<?php if(is_array($TPL_R1=array_merge(get_invoice_company(),config_load('delivery_url')))&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1% 2== 0&&$TPL_I1!= 0){?></tr><tr><?php }?>
<td class="its-td-align center"><?php echo $TPL_V1["company"]?></td>
<td class="its-td-align center"><?php echo $TPL_K1?></td>
<?php }}?>
</tr>
</tbody>
</table>
<br /><br />
</form>
</div>

<div id="coupon_use_lay" class="hide"></div>
<div id="gift_use_lay" class="hide"></div>

<div id="coupon_use_excel_dialog" class="hide">
	<div class="desc">
	구매자의 티켓상품 사용에 대한<br/>
	통신판매중계자(Admin)와 입점 판매자(Seller)간의<br/>
	정산은 정산 관리 메뉴에서 확인하십시오.<br/><br/>

	본 엑셀 다운로드는 구매자의 티켓상품 사용에 대하여<br/>
	티켓상품 사용 매장(지점)별 정산 자료를 확인할 수 있는 기능입니다.<br/> <br/>
	</div>
	<ul class="flex_wrap v2">
		<li class="wx110 mt5">티켓 사용 기간 :</li>	
		<li>
			<input type="text" name="use_regist_date[]" value="<?php echo $TPL_VAR["sc"]["regist_date"][ 0]?>" class="datepicker"  maxlength="10" size="10" />
			-
			<input type="text" name="use_regist_date[]" value="<?php echo $TPL_VAR["sc"]["regist_date"][ 1]?>" class="datepicker" maxlength="10" size="10" />	
			
			<div class="mt5">
				<span class="btn small"><input type="button" value="오늘" onclick="use_set_date('<?php echo date('Y-m-d')?>','<?php echo date('Y-m-d')?>')" /></span>
				<span class="btn small"><input type="button" value="3일간" onclick="use_set_date('<?php echo date('Y-m-d',strtotime("-3 day"))?>','<?php echo date('Y-m-d')?>')" /></span>
				<span class="btn small"><input type="button" value="일주일" onclick="use_set_date('<?php echo date('Y-m-d',strtotime("-7 day"))?>','<?php echo date('Y-m-d')?>')"/></span>
				<span class="btn small"><input type="button" value="1개월" onclick="use_set_date('<?php echo date('Y-m-d',strtotime("-1 month"))?>','<?php echo date('Y-m-d')?>')"/></span>
				<span class="btn small"><input type="button" value="3개월" onclick="use_set_date('<?php echo date('Y-m-d',strtotime("-3 month"))?>','<?php echo date('Y-m-d')?>')" /></span>
				<span class="btn small"><input type="button" value="6개월" onclick="use_set_date('<?php echo date('Y-m-d',strtotime("-6 month"))?>','<?php echo date('Y-m-d')?>')" /></span>
			</div>	
		</li>
	</ul>
	<br/>
	<div  class="center"><span class="btn large green"><button name="coupon_use_excel">엑셀 다운로드</button></span></div>
</div>

<div id="print_setting_dialog" class="hide" style="line-height:20px;">
<?php $this->print_("print_setting",$TPL_SCP,1);?>

</div>

<div id="openmarket_order_receive_guide" class="hide">
	외부 판매마켓에서 발생한 주문은<br />
	매시 20분마다 자동으로 수집합니다.<br />
	자동으로 수집되는 시간을 기다리기 힘드시면<br />
	[지금바로 주문수집] 버튼을 클릭하십시오.
</div>

<!-- 출고지 정보 팝업 :: START -->
<div id="address_dialog" class="hide">
	<table class="info-table-style table_basic v7" width="100%" border="0" cellspacing="0" cellpadding="0">
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

<!-- 기본검색설정 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchDefaultConfig.js?mm=<?php echo date('Ymd')?>"></script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>