<?php /* Template_ 2.2.6 2022/05/17 12:29:06 /www/music_brother_firstmall_kr/selleradmin/skin/default/export/catalog.html 000032604 */ 
$TPL_arr_search_keyword_1=empty($TPL_VAR["arr_search_keyword"])||!is_array($TPL_VAR["arr_search_keyword"])?0:count($TPL_VAR["arr_search_keyword"]);
$TPL_ship_set_code_1=empty($TPL_VAR["ship_set_code"])||!is_array($TPL_VAR["ship_set_code"])?0:count($TPL_VAR["ship_set_code"]);
$TPL_delivery_company_array_1=empty($TPL_VAR["delivery_company_array"])||!is_array($TPL_VAR["delivery_company_array"])?0:count($TPL_VAR["delivery_company_array"]);
$TPL_international_company_array_1=empty($TPL_VAR["international_company_array"])||!is_array($TPL_VAR["international_company_array"])?0:count($TPL_VAR["international_company_array"]);
$TPL_referer_list_1=empty($TPL_VAR["referer_list"])||!is_array($TPL_VAR["referer_list"])?0:count($TPL_VAR["referer_list"]);
$TPL_linkage_mallnames_for_search_1=empty($TPL_VAR["linkage_mallnames_for_search"])||!is_array($TPL_VAR["linkage_mallnames_for_search"])?0:count($TPL_VAR["linkage_mallnames_for_search"]);?>
<!-- 2022.01.03 11월 3차 패치 by 김혜진 -->
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/layer_stock.css" />
<style>
	.goods_name {display:inline-block;white-space:nowrap;overflow:hidden;width:290px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	.search_label 	{display:inline-block;width:100px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	span.price {display:inline-block;width:80px;text-align:right;}
	/*span.icon-buy-confirm{display:inline-block;width:22px;height:15px;background:url('/admin/skin/default/images/common/icon/icon_buy_decide.gif')}*/
	span.icon-buy-confirm{display:inline-block;height:15px;background:url('/admin/skin/default/images/common/icon/icon_order_dcd.gif')}
	span.icon-buy-none{display:inline-block;height:15px;}

	.waybill_number {font-size:11px;width:70px;}
	.delivery_number {width:90%; padding:0px !important; text-indent:2px; line-height:20px; height:20px;}
	.ea {color:#a400ff;;}

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
</style>
<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-exportCatalog.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js?dummy={=date('Ymd')"></script>
<script type="text/javascript" src="/app/javascript/js/admin-shipping.js?dummy={=date('Ymd')"></script>
<script type="text/javascript" src="/app/javascript/js/admin-orderExportPopup.js?dummy=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">
	//기본검색설정
	var default_search_pageid	= "export";
	var default_obj_width		= 750;
	var default_obj_height		= 330;
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
				openDialog("티켓사용내역 다운로드", "coupon_use_excel_dialog", {"width":"440"});
			});
<?php }?>

			// 본사 출고 제외를 위해 재선언
			$("span.reverse_export").die("click");
			$("span.reverse_export").live("click",function(e){
				var st = '.export_code_' + $(this).attr('id');
				var export_code = new Array();
				var able_export = true;
				var str_export_code = '';
				$(st+":checked").each(function(idx){
					export_code[idx] = 'code[]='+$(this).val();
					if( ! $(this).attr('able_export') ){
						able_export = false;
						str_export_code += $(this).val()+' ';
					}
				});

				if( ! able_export ){
					alert( str_export_code +"은 본사에서 배송한 출고 입니다.");
					return;
				}

				if(export_code.length > 0){
					var str = export_code.join('&');
					$.ajax({
						type: "POST",
						url: "../export_process/batch_reverse_export",
						data: str,
						success: function(result){
							openDialogAlert(result,400,140,function(){
								document.location.reload();
							});
						}
					});

				}else{
					alert("선택값이 없습니다.");
					return;
				}
			});

			// 본사 출고 제외를 위해 재선언
			// 출고 정보수정
			$("button#waybill_number_modify").die("click");
			$("button#waybill_number_modify").live("click",function(){
				var able_export = true;
				$("[class^=export_code_]").each(function(){
					if( ! $(this).attr('able_export') ){
						able_export = false;
					}
				});
				if( ! able_export ){
					alert("본사배송 출고건이 포함되어 수정이 불가합니다.");
					return;
				}else{
					var f = $("form[name='batch_form']");
					f.html($(".waybill_number"));
					f[0].submit();
				}
			});

			$("select.waybill_number").die("change");
			$("select.waybill_number").live('change',function(){
				waybill_auto = false;
				if	($(this).attr('chkVal') != undefined && $(this).val() != null)
					if	($(this).attr('chkVal').substring(0,5)=='auto_') waybill_auto = true;
				if(waybill_auto || $(this).closest(".list-row").hasClass("step75") ){
					$("option",this).not(":selected").attr("disabled",true);
					$(this).closest('tr').find("input.delivery_number").attr("readonly",true).addClass("disabled");
				}else{
					$(this).closest('tr').find("input.delivery_number").attr("readonly",false).removeClass("disabled");
				}
			}).change();
		});
</script>

<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/searchform.css" />

<div class="hide">
	<form name="batch_form" method="post" action="../export_process/batch_waybill_number" target="actionFrame"></form>
</div>

<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>출고리스트</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<!-- <li><span class="btn large green"><button type="button" id="coupon_use_excel_btn"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> 티켓사용내역 다운로드</button></span></li> -->
			<li><span class="btn large"><button type="button" id="waybill_number_modify">출고정보수정</button></span></li>
			<li><span class="btn large"><button name="print_setting">프린트설정<span class="arrowright"></span></button></span></li>
			<li><span class="btn large red"><button type="button" onclick="batch_change_status();">출고상태변경</button></span></li>
		</ul>
	</div>
</div>

<!-- 페이지 타이틀 바 : 끝 -->

<!-- 주문리스트 검색폼 : 시작 -->
<p class="mt20"></p>
<div class="search-form-container-new">
	<form name="search-form" method="get">

		<!--######################## 16.12.15 gcs yjy : 검색조건 유지되도록  -->
		<input type="hidden" name="no" value="">
		<input type="hidden" name="query_string" value="">
		<input type="hidden" name="excel_type" value="" />
		<input type="hidden" name="status" value="" />
		<input type="hidden" name="export_code" value="" />
		<input type="hidden" name="criteria" value="" />
		<input type="hidden" name="callPage" value="" />

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
					<table class="sf-option-table w900 table_search">
						<colgroup>
							<col width="100px" />
							<col width="" />
						</colgroup>
						<tr>
							<th>날짜</th>
							<td colspan="3">
								<select class="search_select" name="date" default_none>
									<option value="order" <?php if($TPL_VAR["sc"]["date"]=='order'){?>selected<?php }?>>주문일</option>
									<option value="export"  <?php if($TPL_VAR["sc"]["date"]=='export'){?>selected<?php }?>>출고일(입력)</option>
									<option value="regist_date"  <?php if($TPL_VAR["sc"]["date"]=='regist_date'){?>selected<?php }?>>출고일</option>
									<option value="shipping"  <?php if($TPL_VAR["sc"]["date"]=='shipping'){?>selected<?php }?>>배송완료일</option>
									<option value="confirm_date"  <?php if($TPL_VAR["sc"]["date"]=='confirm_date'){?>selected<?php }?>>구매확정일</option>
								</select>

								<input type="text" name="regist_date[]" value="<?php echo $TPL_VAR["sc"]["regist_date"][ 0]?>" class="datepicker"  maxlength="10" size="10" default_none />
								&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
								<input type="text" name="regist_date[]" value="<?php echo $TPL_VAR["sc"]["regist_date"][ 1]?>" class="datepicker" maxlength="10" size="10" default_none />

								<span class="resp_btn_wrap">
							<span class="btn small"><input type="button" id="today" value="오늘" class="select_date resp_btn" /></span>
							<span class="btn small"><input type="button" id="3day" value="3일간" class="select_date resp_btn" /></span>
							<span class="btn small"><input type="button" id="1week" value="일주일" class="select_date resp_btn" /></span>
							<span class="btn small"><input type="button" id="1month" value="1개월" class="select_date resp_btn" /></span>
							<span class="btn small"><input type="button" id="3month" value="3개월" class="select_date resp_btn" /></span>
							<span class="btn small"><input type="button" id="all"  value="전체" class="select_date resp_btn"  /></span>
						</span>
							</td>
						</tr>
						<tr>
							<th>출고상태</th>
							<td colspan="3">

<?php if(is_array($TPL_R1=config_load('export_status'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
								<label style="display:inline-block;width:100px;" class="resp_checkbox"><input type="checkbox" name="export_status[<?php echo $TPL_K1?>]" value="1" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php if($TPL_VAR["sc"]["export_status"][$TPL_K1]== 1){?>
								<script type="text/javascript">$("input[name='export_status[<?php echo $TPL_K1?>]']").attr('checked',true);</script>
<?php }?>
<?php }}?>
								<span class="icon-check hand all-check"><b>전체</b></span>
								&nbsp;&nbsp;&nbsp;<span class="desc">|</span>&nbsp;&nbsp;&nbsp;
								<label class="resp_checkbox">
									<input type="checkbox" name="chk_bundle_yn" value="1" <?php if($TPL_VAR["sc"]["chk_bundle_yn"]=='1'){?>checked<?php }?>/> <span>합포장(묶음배송)</span>
								</label>
								<span class="helpicon" title="합포장(묶음배송)으로 출고된 출고건을 검색합니다."></span>
							</td>
						</tr>
						<tr>
							<th>구매 확정</th>
							<td colspan="3">
						<span class="resp_checkbox">
							<label><input type="checkbox" name="buy_confirm[user]" value="1" /> 했음(판매자)</label>
							<label><input type="checkbox" name="buy_confirm[admin]" value="1" /> 했음(구매자)</label>
							<label><input type="checkbox" name="buy_confirm[system]" value="1" /> 했음(시스템)</label>
							<label><input type="checkbox" name="buy_confirm[none]" value="1"  row_check_all /> 안했음</label>
<?php if(is_array($TPL_R1=$_GET["buy_confirm"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($_GET["buy_confirm"][$TPL_K1]== 1){?>
							<script type="text/javascript">$("input[name='buy_confirm[<?php echo $TPL_K1?>]']").attr('checked',true);</script>
<?php }?>
<?php }}?>
						</span>
								<span class="icon-check hand all-check ml10"><b>전체</b></span>
							</td>
						</tr>
						<tr>
							<th>
								출고방법
								<span class="helpicon2 detailDescriptionLayerBtn" title="출고방법"></span>
								<!-- 출고방법 설명 -->
								<div class="detailDescriptionLayer wx350 hide">선택된 배송국가의 배송방법으로 출고된 출고 조회</div>
							</th>
							<td colspan="3">
								<div class="pdb5 resp_checkbox">
									<label style="display:inline-block;"><input type="checkbox" class="shipping_nation" name="search_shipping_nation[kr]" value="kr" <?php if($TPL_VAR["sc"]["search_shipping_nation"]['kr']){?>checked<?php }?> /> 대한민국</label> (
<?php if($TPL_ship_set_code_1){$TPL_I1=-1;foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
									<label style="display:inline-block;<?php if($TPL_I1<(count($TPL_VAR["ship_set_code"])- 1)){?>width:auto;<?php }?>"><input type="checkbox" name="search_shipping_method_kr[<?php echo $TPL_K1?>]" class="set_code ship_kr" value="<?php echo $TPL_K1?>" <?php if(!$TPL_VAR["sc"]["search_shipping_nation"]['kr']){?>disabled
<?php }?> <?php if($TPL_VAR["sc"]["search_shipping_method_kr"][$TPL_K1]){?>checked<?php }?> /> <?php echo $TPL_V1?></label>
<?php }}?>
									)
									<span style="display:inline-block;width:10px"></span><span class="icon-check hand all-check"><b>전체</b></span>
								</div>
								<div class="pdb5 resp_checkbox">
									<label style="display:inline-block;"><input type="checkbox" class="shipping_nation" name="search_shipping_nation[gl]" value="gl" <?php if($TPL_VAR["sc"]["search_shipping_nation"]['gl']){?>checked<?php }?> /> 해외국가</label> (
<?php if($TPL_ship_set_code_1){$TPL_I1=-1;foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
									<label style="display:inline-block;<?php if($TPL_I1<(count($TPL_VAR["ship_set_code"])- 1)){?>width:auto;<?php }?>"><input type="checkbox" name="search_shipping_method_gl[<?php echo $TPL_K1?>]" class="set_code ship_gl" value="<?php echo $TPL_K1?>" <?php if(!$TPL_VAR["sc"]["search_shipping_nation"]['gl']){?>disabled<?php }?> <?php if($TPL_VAR["sc"]["search_shipping_method_gl"][$TPL_K1]){?>checked<?php }?> /> <?php echo $TPL_V1?></label>
<?php }}?>
									)
									<span style="display:inline-block;width:10px"></span><span class="icon-check hand all-check"><b>전체</b></span>
								</div>
								<div>
									<label style="display:inline-block;padding-right:10px;" class="resp_checkbox"><input type="checkbox" name="search_shipping_method_coupon" value="coupon" <?php if($TPL_VAR["sc"]["search_shipping_method_coupon"]){?>checked<?php }?> /> 문자/이메일(티켓발송)</label>
								</div>
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
								<select name="search_delivery_company_code" class="waybill_number">
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
								<input type="text" name="search_delivery_number" class="" value="<?php echo $TPL_VAR["sc"]["search_delivery_number"]?>" />
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
								<label class="search_label" style="height:20px;"><input type="checkbox" name="not_linkage_order" value="1" <?php if($_GET["not_linkage_order"]){?>checked="checked"<?php }?> /> 운영쇼핑몰</label>
								<select name="referer">
									<option value="">선택하세요</option>
<?php if($TPL_referer_list_1){foreach($TPL_VAR["referer_list"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1["referer_group_name"]?>" <?php if($_GET["referer"]==$TPL_V1["referer_group_name"]){?>selected<?php }?>><?php echo $TPL_V1["referer_group_name"]?></option>
<?php }}?>
									<option value="기타" <?php if($_GET["referer"]=='기타'){?>selected<?php }?>>기타</option>
								</select>
								<br />
<?php if($TPL_linkage_mallnames_for_search_1){$TPL_I1=-1;foreach($TPL_VAR["linkage_mallnames_for_search"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1&&$TPL_I1% 5== 0){?><br /><?php }?>
<?php if($_GET["linkage_mall_code"][$TPL_V1["mall_code"]]){?>
								<label class="search_label"><input type="checkbox" name="linkage_mall_code[<?php echo $TPL_V1["mall_code"]?>]" value="<?php echo $TPL_V1["mall_code"]?>" checked="checked" /> <?php echo $TPL_V1["mall_name"]?></label>
<?php }else{?>
								<label class="search_label"><input type="checkbox" name="linkage_mall_code[<?php echo $TPL_V1["mall_code"]?>]" value="<?php echo $TPL_V1["mall_code"]?>" /> <?php echo $TPL_V1["mall_name"]?></label>
<?php }?>
<?php }}?>
								<label class="search_label" style="height:20px;"><input type="checkbox" name="etc_linkage_order" value="1" <?php if($_GET["etc_linkage_order"]){?>checked="checked"<?php }?> /> 그 외 마켓</label>
								<span class="icon-check hand all-check"><b>전체</b></span>

								<span class="btn medium"><button type="button" name="openmarket_order_receive_guide">자동수집 안내<span class="arrowright"></span></button></span>
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
				<button type="button" id="search_reset_button"  onclick="reset_search_form();" class="resp_btn v3 size_XL">초기화</button>
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
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="20" /><!--선택-->
		<col width="20" /><!--중요-->
		<col width="40" /><!--번호-->
		<col width="60" /><!--원주문-->
		<col width="115" /><!--출고일-->
		<col width="208" /><!--출고번호-->
		<col /><!--출고상품-->
		<col width="60" /><!--수(종)-->
		<col width="180" /><!--받는분-->
		<col width="115" /><!--출고일-->
		<col width="220" /><!--출고정보-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" name="" value="" /></th>
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
		<table class="info-table-style" style="width:100%">
			<colgroup>
				<col width="25%" />
				<col width="25%" />
				<col width="25%" />
				<col width="25%" />
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

<div id="coupon_use_excel_dialog" class="hide">
	<div class="desc">
		구매자의 티켓상품 사용에 대한<br/>
		통신판매중계자(Admin)와 입점 판매자(Seller)간의<br/>
		정산은 정산 관리 메뉴에서 확인하십시오.<br/><br/>

		본 엑셀 다운로드는 구매자의 티켓상품 사용에 대하여<br/>
		티켓상품 사용 매장(지점)별 정산 자료를 확인할 수 있는 기능입니다.<br/> <br/>
	</div>

	티켓 사용 기간 :
	<input type="text" name="use_regist_date[]" value="<?php echo $_GET["regist_date"][ 0]?>" class="datepicker line"  maxlength="10" size="10" />
	&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
	<input type="text" name="use_regist_date[]" value="<?php echo $_GET["regist_date"][ 1]?>" class="datepicker line" maxlength="10" size="10" />
	&nbsp;&nbsp;
	<div >

		<span class="btn small"><input type="button" value="오늘" onclick="use_set_date('<?php echo date('Y-m-d')?>','<?php echo date('Y-m-d')?>')" /></span>
		<span class="btn small"><input type="button" value="3일간" onclick="use_set_date('<?php echo date('Y-m-d',strtotime("-3 day"))?>','<?php echo date('Y-m-d')?>')" /></span>
		<span class="btn small"><input type="button" value="일주일" onclick="use_set_date('<?php echo date('Y-m-d',strtotime("-7 day"))?>','<?php echo date('Y-m-d')?>')"/></span>
		<span class="btn small"><input type="button" value="1개월" onclick="use_set_date('<?php echo date('Y-m-d',strtotime("-1 month"))?>','<?php echo date('Y-m-d')?>')"/></span>
		<span class="btn small"><input type="button" value="3개월" onclick="use_set_date('<?php echo date('Y-m-d',strtotime("-3 month"))?>','<?php echo date('Y-m-d')?>')" /></span>
		<span class="btn small"><input type="button" value="6개월" onclick="use_set_date('<?php echo date('Y-m-d',strtotime("-6 month"))?>','<?php echo date('Y-m-d')?>')" /></span>
	</div>
	<br />
	<div  class="center"><span class="btn large green"><button name="coupon_use_excel">엑셀 다운로드</button></span></div>
</div>

<div id="print_setting_dialog" class="hide" style="line-height:20px;">
	<form action="../export_process/print_setting" method="post" target="actionFrame">
		<span class="fx12 black">1. 주문내역서에 출고번호를 바코드로 출력하시겠습니까?</span><br />
		<span class="fx11 gray">출고 검색창에서 바코드를 스캔하면 해당 출고건의 출고화면으로 바로 이동하여 출고처리가 편리해집니다.</span><br />
		<label><input type="radio" name="exportPrintExportcodeBarcode" value="1" <?php if($TPL_VAR["exportPrintExportcodeBarcode"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="exportPrintExportcodeBarcode" value="" <?php if(!$TPL_VAR["exportPrintExportcodeBarcode"]){?>checked<?php }?> /> 아니오</label><br />
		<br />
		<span class="fx12 black">2. 출고내역서에 출고상품의 상품코드를 출력하시겠습니까?</span><br />
		<label><input type="radio" name="exportPrintGoodsCode" value="1" <?php if($TPL_VAR["exportPrintGoodsCode"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="exportPrintGoodsCode" value="" <?php if(!$TPL_VAR["exportPrintGoodsCode"]){?>checked<?php }?> /> 아니오</label><br />
		<br />
		<span class="fx12 black">3. 출고내역서에 출고상품의 상품코드를 바코드로 출력하시겠습니까?</span><br />
		<span class="fx11 gray">해당 출고의 출고처리화면에서 실제 상품의 바코드를 스캔하면 출고상품이 맞는지 검증하여 <br />
	오배송 없이 정확하게 출고가 가능합니다. 해당 상품의 바코드를 계속 스캔하면 출고수량이 +1씩 증가합니다.</span><br />
		<label><input type="radio" name="exportPrintGoodsBarcode" value="1" <?php if($TPL_VAR["exportPrintGoodsBarcode"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="exportPrintGoodsBarcode" value="" <?php if(!$TPL_VAR["exportPrintGoodsBarcode"]){?>checked<?php }?> /> 아니오</label><br />
		<br />
		<div class="center">
			<span class="btn medium cyanblue"><input type="submit" value="저장" /></span>
		</div>
	</form>
</div>

<div id="openmarket_order_receive_guide" class="hide">
	외부 판매마켓에서 발생한 주문은<br />
	매시 20분마다 자동으로 수집합니다.<br />
	자동으로 수집되는 시간을 기다리기 힘드시면<br />
	[지금바로 주문수집] 버튼을 클릭하십시오.
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

<div id="gift_use_lay"></div>

<!-- 기본검색설정 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchDefaultConfig.js"></script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>