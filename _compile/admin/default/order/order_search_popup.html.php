<?php /* Template_ 2.2.6 2021/11/16 14:29:28 /www/music_brother_firstmall_kr/admin/skin/default/order/order_search_popup.html 000035220 */ 
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);
$TPL_sitetypeloop_1=empty($TPL_VAR["sitetypeloop"])||!is_array($TPL_VAR["sitetypeloop"])?0:count($TPL_VAR["sitetypeloop"]);
$TPL_referer_list_1=empty($TPL_VAR["referer_list"])||!is_array($TPL_VAR["referer_list"])?0:count($TPL_VAR["referer_list"]);
$TPL_linkage_mallnames_for_search_1=empty($TPL_VAR["linkage_mallnames_for_search"])||!is_array($TPL_VAR["linkage_mallnames_for_search"])?0:count($TPL_VAR["linkage_mallnames_for_search"]);
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<style>
.search_label 	{display:inline-block;width:90px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
span.step_title { font-weight:normal;padding:0 5px 0 5px; }
span.export-list { display:inline-block;background-url("/admin/skin/default/images/common/btn_list_release.gif");width:60px;height:15px; }
div.btn-open-all{ position:absolute;top:3px;left:-62px;}
div.btn-open-all img { cursor:pointer; }
.ft11	{ font-size:11px; }

.barcode-btn {position:absolute; top:-34px; left:10px; cursor:pointer}
.barcode-btn .openImg{display:block;}
.barcode-btn .closeImg{display:none;}
.barcode-btn.opened .openImg{display:none;}
.barcode-btn.opened .closeImg{display:block;}
.barcode-description {display:none; background-color:#d2d8d8; border-top:1px solid #c4cccc; border-bottom:1px solid #c4cccc; text-align:center}

.darkgreen { color:#009900; }

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

table.export_table {border-collapse:collapse;border:1px solid #c8c8c8;width:100%}
table.export_table th {padding:5px; border:1px solid #c8c8c8;}
table.export_table td {padding:5px; border:1px solid #c8c8c8;}
table.export_table th {background-color:#efefef;}
</style>


<script type="text/javascript">

/* variable for ajax list */
var npage		= 1;
var nstep		= '';
var nnum		= '';
var stepArr		= new Array();
var allOpenStep	= new Array();

$(document).ready(function() {
	
	$(".all-check").toggle(function(){
		$(this).parent().find('input[type=checkbox]').not('[name="chk_bundle_yn"]').attr('checked',true);
	},function(){
		$(this).parent().find('input[type=checkbox]').not('[name="chk_bundle_yn"]').attr('checked',false);
	});

	// 기본검색 조건 불러오기
	$("button#get_default_button").bind("click",function(){
		$.getJSON('get_search_default', function(result) {
			$("form[name='search-form'] input[type='checkbox']").removeAttr("checked");
			$("form[name='search-form'] input[type='text']").val('');
			$("form[name='search-form'] select").val('').change();
			$("select[name='provider_seq_selector']" ).next(".ui-combobox").children("input").val('');

			var patt;
			for(var i=0;i<result.length;i++){
				patt=/_date/g;
				if( patt.test(result[i][0]) ){
					if(result[i][1] == 'today'){
						set_date('<?php echo date('Y-m-d')?>','<?php echo date('Y-m-d')?>');
					}else if(result[i][1] == '3day'){
						set_date('<?php echo date('Y-m-d',strtotime("-3 day"))?>','<?php echo date('Y-m-d')?>');
					}else if(result[i][1] == '7day'){
						set_date('<?php echo date('Y-m-d',strtotime("-7 day"))?>','<?php echo date('Y-m-d')?>');
					}else if(result[i][1] == '1mon'){
						set_date('<?php echo date('Y-m-d',strtotime("-1 month"))?>','<?php echo date('Y-m-d')?>');
					}else if(result[i][1] == '3mon'){
						set_date('<?php echo date('Y-m-d',strtotime("-3 month"))?>','<?php echo date('Y-m-d')?>');
					}else if(result[i][1] == 'all'){
						set_date('','');
					}
				}
				patt=/chk_/;
				if( patt.test(result[i][0]) ){
					$("form[name='search-form'] input[name='"+result[i][0]+"']").attr("checked",true);
				}
			}
		});
	});


	

	// 기본검색 조건 저장하기
	$("span#set_default_button").bind("click",function(){
		var title = '기본검색 설정<span style="font-size:11px; margin-left:26px;"> - 아래서 원하는 검색조건을 설정하여 편하게 쇼핑몰을 운영하세요</span>';
		openDialog(title, "search_detail_dialog", {"width":"85%","height":"240"});
	});
	

	$("form[name='search-form']").submit(function(){
		var submit = true;

		// 바코드 검색 체크
		var keyword = $("input[name='keyword']",this).val();
		if(keyword.length==21 && keyword.substring(0,1)=='A' && keyword.substring(keyword.length-1,keyword.length)=='A'){
			var order_seq = keyword.substring(1,20);
			$.ajax({
				'url' : 'order_seq_chk',
				'data' : {'order_seq':keyword},
				'async' : false,
				'success' : function(res){
					if(res=='1'){
						window.open('/admin/order/view?no='+order_seq+'&directExport=1');
						$("form[name='search-form'] input[name='keyword']").val('');
						submit = false;
					}
				}
			});
		}

		return submit;
	});
});


function set_date(start,end){
	$("input[name='regist_date[]']").eq(0).val(start);
	$("input[name='regist_date[]']").eq(1).val(end);
}



</script>
<!--link rel="stylesheet" type="text/css" href="/admin/skin/default/css/searchform.css" /-->
<!-- 주문리스트 검색폼 : 시작 -->
<div class="search-form-container" style="padding-bottom:20px;">
	<form name="search-form" method="get">
	<input type="hidden" name="search_page" value="<?php echo $_GET["search_page"]?>">
	<table class="search-form-table">
		<tr>
			<td>
				<table>
					<tr>
						<td width="600">
							<table class="sf-keyword-table">
								<tr>
									<td width="100" align="center">
										<select name="keyword_type" style="width:94px;">
											<option value="">통합검색</option>
											<option value="order_seq">주문번호</option>
											<option value="order_user_name">주문자명</option>
											<option value="depositor">입금자명</option>
											<option value="userid">아이디</option>
										</select>
										<script>$("select[name='keyword_type']").val("<?php echo $_GET["keyword_type"]?>");</script>
									</td>
									<td class="sfk-td-txt">
										<input type="text" name="keyword" value="<?php echo $_GET["keyword"]?>" title="주문자, 수령자, 입금자, 아이디, 이메일, 휴대폰, 상품명, 상품번호, 상품코드, 사은품, 운송장번호, 주문번호, 출고번호, 반품번호, 환불번호" />
										</td>
									<td class="sfk-td-btn"><button type="submit"><span>검색</span></button></td>
								</tr>
							</table>
						</td>
						<td>&nbsp;&nbsp;&nbsp;</td>
						<!--
						<td>
							<span id="set_default_button" class="icon-arrow-down" style="cursor:pointer;">기본검색설정</span>
							<span class="btn small gray"><button type="button" id="get_default_button">적용 ▶</button></span>
						</td>
						<td>&nbsp;&nbsp;&nbsp;</td>
						-->
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table class="search-form-table" id="search_detail_table" >
		<tr>
			<td>
				<table class="sf-option-table" width="100%">
					<col width="80"/>
					<col width="200"/>
					<col width="110"/>
					<col />
<?php if(solutionServiceCheck( 16)||solutionServiceCheck( 1024)||solutionServiceCheck( 2048)||solutionServiceCheck( 4096)){?>
					<tr>
						<th>입점사</th>
						<td colspan="3">
							<div class="ui-widget"  style="float:left;">
								<select name="provider_seq_selector" style="vertical-align:middle;">
								<option value="0">- 입점사 검색 -</option>
								<option value="999999999999">입점사 전체(본사제외)</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["provider_seq"]?>"><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }}?>
								</select>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $_GET["provider_seq"]?>" />
								<input type="text" name="provider_name" value="<?php echo $_GET["provider_name"]?>" readonly />
							</div>
							<div style="float:left;padding:7px 0px 0px 5px;;"><label><input type="checkbox" name="base_inclusion" value="1" <?php if($_GET["base_inclusion"]){?>checked<?php }?> /> 본사상품 주문</label></div>
							<span class="ptc-charges hide"></span>
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
						<th>
							<select name="date_field" style="width:60px;">
								<option value="regist_date" <?php if($_GET["date_field"]=='regist_date'||!$_GET["date_field"]){?>selected<?php }?>>주문일</option>
								<option value="deposit_date" <?php if($_GET["date_field"]=='deposit_date'){?>selected<?php }?>>입금일</option>
							</select>
						</th>
						<td colspan="3">
							<input type="text" name="regist_date[]" value="<?php echo $_GET["regist_date"][ 0]?>" class="datepicker line"  maxlength="10" size="10" />
							&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
							<input type="text" name="regist_date[]" value="<?php echo $_GET["regist_date"][ 1]?>" class="datepicker line" maxlength="10" size="10" />
							&nbsp;&nbsp;
							<span class="btn small"><input type="button" value="오늘" onclick="set_date('<?php echo date('Y-m-d')?>','<?php echo date('Y-m-d')?>')" /></span>
							<span class="btn small"><input type="button" value="3일간" onclick="set_date('<?php echo date('Y-m-d',strtotime("-3 day"))?>','<?php echo date('Y-m-d')?>')" /></span>
							<span class="btn small"><input type="button" value="일주일" onclick="set_date('<?php echo date('Y-m-d',strtotime("-7 day"))?>','<?php echo date('Y-m-d')?>')"/></span>
							<span class="btn small"><input type="button" value="1개월" onclick="set_date('<?php echo date('Y-m-d',strtotime("-1 month"))?>','<?php echo date('Y-m-d')?>')"/></span>
							<span class="btn small"><input type="button" value="3개월" onclick="set_date('<?php echo date('Y-m-d',strtotime("-3 month"))?>','<?php echo date('Y-m-d')?>')" /></span>
							<span class="btn small"><input type="button" value="전체" onclick="set_date('','')" /></span>
						</td>
					</tr>
					<tr>
						<th>출고 전</th>
						<td colspan="3">
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if(($_GET["search_page"]=='refund_shipping'&&$TPL_K1> 15&&$TPL_K1< 50)||($_GET["search_page"]!='refund_shipping'&&$TPL_K1< 50)){?>
<?php if($_GET["chk_step"][$TPL_K1]){?>
							<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" checked="checked" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }else{?>
							<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }?>
<?php }?>
<?php }}?>
							<span class="icon-check hand all-check"><b>전체</b></span>
						</td>
					</tr>
					<tr>
						<th>출고 후</th>
						<td colspan="3">
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1>= 50&&$TPL_K1< 80){?>
<?php if($_GET["chk_step"][$TPL_K1]){?>
							<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" checked="checked" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }else{?>
							<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }?>
<?php }?>
<?php }}?>
							<span class="icon-check hand all-check"><b>전체</b></span>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label>
								<input type="checkbox" name="chk_bundle_yn" value="1" <?php if($_GET["chk_bundle_yn"]=='1'){?>checked<?php }?>/> 합포장(묶음배송)
								<span class="helpicon" title="합포장(묶음배송)으로 출고된 출고건을 검색합니다."></span>
							</label>
						</td>
					</tr>
					<tr>
						<th>결제수단</th>
						<td colspan="3">
<?php if(is_array($TPL_R1=config_load('payment'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if(!preg_match('/escrow/',$TPL_K1)){?>
<?php if($_GET["payment"][$TPL_K1]){?>
							<label class="search_label"><input type="checkbox" name="payment[<?php echo $TPL_K1?>]" value="1" checked="checked" /> <?php echo $TPL_V1?></label>
<?php }else{?>
							<label class="search_label"><input type="checkbox" name="payment[<?php echo $TPL_K1?>]" value="1" /> <?php echo $TPL_V1?></label>
<?php }?>
<?php }?>
<?php }}?>
							<span class="icon-check hand all-check"><b>전체</b></span>
						</td>
					</tr>
					<tr>
						<th>판매환경</th>
						<td colspan="3">
<?php if($TPL_sitetypeloop_1){foreach($TPL_VAR["sitetypeloop"] as $TPL_K1=>$TPL_V1){?>
<?php if($_GET["sitetype"][$TPL_K1]){?>
								<label class="search_label" <?php if($TPL_K1=='MF'){?>style="width:150px"<?php }?> ><input type="checkbox" name="sitetype[<?php echo $TPL_K1?>]" value="<?php echo $TPL_K1?>" checked="checked" /> <?php echo $TPL_V1["name"]?></label>
<?php }else{?>
								<label class="search_label"  <?php if($TPL_K1=='MF'){?>style="width:150px"<?php }?> ><input type="checkbox" name="sitetype[<?php echo $TPL_K1?>]" value="<?php echo $TPL_K1?>" /> <?php echo $TPL_V1["name"]?></label>
<?php }?>
<?php }}?>
							<span class="icon-check hand all-check"><b>전체</b></span>
						</td>
					</tr>
					<tr>
						<th>주문유형</th>
						<td colspan="3">
							<label class="search_label" ><input type="checkbox" name="ordertype[personal]" value="personal" <?php if($_GET["ordertype"]['personal']){?>checked<?php }?>/> <img src="/admin/skin/default/images/design/icon_order_personal.gif" align="absmiddle" /> 개인결제</label>
							<label class="search_label" ><input type="checkbox" name="ordertype[admin]" value="admin" <?php if($_GET["ordertype"]['admin']){?>checked<?php }?>/> <img src="/admin/skin/default/images/design/icon_order_admin.gif" align="absmiddle" /> 관리자</label>
							<label class="search_label" ><input type="checkbox" name="ordertype[change]" value="change" <?php if($_GET["ordertype"]['change']){?>checked<?php }?>/> <img src="/admin/skin/default/images/design/icon_order_exchange.gif" align="absmiddle" /> 맞교환</label>
							<label class="search_label" ><input type="checkbox" name="ordertype[gift]" value="gift" <?php if($_GET["ordertype"]['gift']){?>checked<?php }?>/> <img src="/admin/skin/default/images/design/icon_order_gift.gif" align="absmiddle" /> 사은품</label>
							<span class="icon-check hand all-check"><b>전체</b></span>
						</td>
					</tr>
					<tr>
						<th>배송방법</th>
						<td colspan="3">
							<label class="search_label" ><input type="checkbox" name="search_shipping_method[delivery]" value="delivery" <?php if($_GET["search_shipping_method"]['delivery']){?>checked<?php }?>/> 택배선불</label>
							<label class="search_label" ><input type="checkbox" name="search_shipping_method[postpaid]" value="postpaid" <?php if($_GET["search_shipping_method"]['postpaid']){?>checked<?php }?>/> 택배착불</label>
							<label class="search_label" ><input type="checkbox" name="search_shipping_method[quick]" value="quick" <?php if($_GET["search_shipping_method"]['quick']){?>checked<?php }?>/> 퀵서비스</label>
							<label class="search_label" ><input type="checkbox" name="search_shipping_method[direct]" value="direct" <?php if($_GET["search_shipping_method"]['direct']){?>checked<?php }?>/> 직접수령</label>
							<span class="icon-check hand all-check"><b>전체</b></span>
						</td>
					</tr>
					<tr>
						<th>주문경로<span class="helpicon" title="어디서 유입되어 주문 되었는지 알 수 있습니다."></span></th>
						<td>
							<select name="referer">
								<option value="">선택하세요</option>
<?php if($TPL_referer_list_1){foreach($TPL_VAR["referer_list"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["referer_group_name"]?>" <?php if($_GET["referer"]==$TPL_V1["referer_group_name"]){?>selected<?php }?>><?php echo $TPL_V1["referer_group_name"]?></option>
<?php }}?>
								<option value="기타" <?php if($_GET["referer"]=='기타'){?>selected<?php }?>>기타</option>
							</select>
						</td>
						<th>해외배송상품<span class="helpicon" title="필수 상품 기준으로 검색됩니다."></span></th>
						<td>
							<label>
								<input type="checkbox" name="search_option_international_shipping" value="y" <?php if($_GET["search_option_international_shipping"]=='y'){?>checked<?php }?> /> 사용
							</label>
						</td>
					</tr>
<?php if($TPL_VAR["linkage_mallnames_for_search"]){?>
					<tr>
						<th>판매마켓</th>
						<td colspan="3">
							<label class="search_label" style="height:20px;padding-top:10px;"><input type="checkbox" name="not_linkage_order" value="1" <?php if($_GET["not_linkage_order"]){?>checked="checked"<?php }?> /> 운영쇼핑몰</label>
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

							<span class="btn medium"><button type="button" name="openmarket_order_receive">지금바로 주문수집<span class="arrowright"></span></button></span>
							<span class="btn medium"><button type="button" name="openmarket_order_receive_guide">자동수집 안내<span class="arrowright"></span></button></span>
						</td>
					</tr>
<?php }?>
				</table>
			</td>
		</tr>
	</table>
	</form>
</div>
<!-- 주문리스트 검색폼 : 끝 -->

<div style="background:#FFF;padding-bottom:20px;">
	<!-- 주문리스트 테이블 : 시작 -->
	<table class="list-table-style" cellspacing="0">
		<!-- 테이블 헤더 : 시작 -->
		<colgroup>
			<col width="50" />
			<col width="28" />
			<col width="80" />
			<col width="150" />
			<col />
			<col width="45" />
			<col width="45" />
			<col width="110" />
			<col width="110" />
			<col width="60" />
			<col width="60" />
		</colgroup>
		<thead class="lth">
		<tr>
			<th>선택</th>
			<th>번호</th>
			<th>주문일시</th>
			<th>주문번호</th>
			<th>주문상품</th>
			<th>수(종)</th>
			<th>출고</th>
			<th>받는분/주문자</th>
			<th>결제수단/일시</th>
			<th>결제금액</th>
			<th>처리상태</th>
		</tr>
		</thead>
		<!-- 테이블 헤더 : 끝 -->
		<!-- 리스트 : 시작 -->
		<tbody class="ltb order-ajax-list">

<?php if(!$TPL_VAR["record"]&&$TPL_VAR["page"]== 1){?>
			<tr class="list-row">
				<td colspan="10" align="center">검색어가 없거나 검색 결과가 없습니다.</td>
			</tr>
		
<?php }else{?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_K1=>$TPL_V1){?>
			<tr class="list-row step<?php echo $TPL_V1["step"]?> important_<?php echo $TPL_V1["order_seq"]?> <?php if($TPL_V1["thischeck"]){?>checked-tr-background<?php }?>">
				<td align="center" class="ft11">
<?php if((($TPL_VAR["voucher_type"]=='chkvoucher_cash'&&number_format($TPL_V1["settleprice"])<= 0)||(($TPL_VAR["sale_reserve_yn"]!='Y'&&$TPL_V1["emoney_use"]=='use')&&number_format($TPL_V1["settleprice"])<= 0)||(($TPL_VAR["sale_emoney_yn"]!='Y'&&$TPL_V1["cash_use"]=='use')&&number_format($TPL_V1["settleprice"])<= 0)||($TPL_VAR["voucher_type"]=='chkvoucher_cash'&&$TPL_V1["pg"]=='payco'))||$TPL_V1["linkage_mall_order_id"]||$TPL_V1["linkage_id"]=='pos'){?>
<?php }else{?>
					<span class="btn small gray"><button type="button" onClick="opener.selected_order_seq('<?php echo $TPL_V1["order_seq"]?>');">선택</button></span>
<?php }?>
				</td>
				<td align="center" class="ft11"><?php echo $TPL_V1["no"]?></td>
				<td align="center" class="ft11"><?php echo substr($TPL_V1["regist_date"], 2, - 3)?></td>
				<td class="ft11" style="padding-left:10px">
					<a href="view?no=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><span class="order-step-color-<?php echo $TPL_V1["step"]?> bold"><?php echo $TPL_V1["order_seq"]?></span></a>
					<!--a href="javascript:printOrderView('<?php echo $TPL_V1["order_seq"]?>')"><span class="icon-print-order"></span></a>
					<a href="view?no=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><span class="btn-administration"><span class="hide">새창</span></span></a>
					<!--span class="btn-direct-open" onclick="btn_direct_open(this);"><span class="hide">바로열기</span></span-->
<?php if($TPL_V1["linkage_mall_order_id"]){?>
					<div class="blue bold"><?php echo $TPL_V1["linkage_mall_order_id"]?> (<?php echo $TPL_V1["linkage_mallname_text"]?>)</div>
<?php }?>
				</td>
				<td align="left" style="padding-left:10px">
					<div class="goods_name"><?php if($TPL_V1["gift_cnt"]> 0){?><span title="사은품 주문"><img src="/admin/skin/default/images/design/icon_order_gift.gif" align="absmiddle"/></span><?php }?> <?php echo $TPL_V1["goods_name"]?> <?php if($TPL_V1["item_cnt"]> 1){?>외 <?php echo $TPL_V1["item_cnt"]- 1?>종<?php }?></div>
				</td>
				<td class="right">
					<?php echo $TPL_V1["tot_ea"]?>(<?php echo $TPL_V1["item_cnt"]?>종)
				</td>
				<td class="right">
<?php if($TPL_V1["step"]>= 45&&$TPL_V1["step"]< 85){?>
<?php if($TPL_V1["bundle_yn"]=='y'){?>[합]<br/><?php }?>
						출고
<?php }?>
				</td>
				<td class="ft11" style="padding-left:10px">
<?php if($TPL_V1["recipient_user_name"]!=$TPL_V1["order_user_name"]){?>
						<div style="margin-top:5px;"><?php echo $TPL_V1["recipient_user_name"]?></div>
<?php }?>

					<div style="margin-bottom:3px;">
<?php if($TPL_V1["member_seq"]){?>
<?php if($TPL_V1["member_type"]=='개인'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" vspace="0" align="absmiddle" />
<?php }elseif($TPL_V1["member_type"]=='기업'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" vspace="0" align="absmiddle" /><?php }?>
						<span><?php echo $TPL_V1["order_user_name"]?></span>
<?php if($TPL_V1["sns_rute"]){?>
							<span>(<img src="/admin/skin/default/images/sns/sns_<?php echo substr($TPL_V1["sns_rute"], 0, 1)?>0.gif" align="absmiddle" snscd="<?php echo $TPL_V1["sns_rute"]?>" mem_seq="<?php echo $TPL_V1["member_seq"]?>" no="<?php echo $TPL_V1["step"]?><?php echo $TPL_K1?>" onclick="snsdetailview('open','<?php echo $TPL_V1["sns_rute"]?>','<?php echo $TPL_V1["member_seq"]?>','<?php echo $TPL_V1["step"]?><?php echo $TPL_K1?>')" class="btnsnsdetail hand">/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
							<div id="snsdetailPopup<?php echo $TPL_V1["step"]?><?php echo $TPL_K1?>" class="snsdetailPopup absolute hide" style="margin-left:73px;margin-top:-16px;"></div>
							</span>
<?php }else{?>
							(<a href="/admin/member/detail?member_seq=<?php echo $TPL_V1["member_seq"]?>" target="_blank"><span style="color:#d13b00;"><?php echo $TPL_V1["userid"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span></a>)
<?php }?>
<?php }else{?>
						<img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <?php echo $TPL_V1["order_user_name"]?> (<span class="desc">비회원</span>)
<?php }?>
					</div>
				</td>
				<!--// 결제 수단 //-->
				<td align="right" class="ft11">
<?php if($TPL_V1["payment"]=='bank'){?>
<?php if($TPL_V1["order_user_name"]==$TPL_V1["depositor"]){?>
					<span class="darkgray"><span title="입금자명"><?php echo $TPL_V1["depositor"]?></span></span>
<?php }else{?>
					<span class="blue"><span title="입금자명"><?php echo $TPL_V1["depositor"]?></span></span>
<?php }?>
<?php }?>
<?php if($TPL_V1["payment"]=='escrow_account'){?>
					<span class="icon-pay-escrow"><span>에스크로</span></span>
					<span class="icon-pay-account"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }elseif($TPL_V1["payment"]=='escrow_virtual'){?>
					<span class="icon-pay-escrow"><span>에스크로</span></span>
					<span class="icon-pay-virtual"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }elseif($TPL_V1["pg"]=='kakaopay'){?>
					<span class="icon-pay-<?php echo $TPL_V1["pg"]?>-simple"><span><?php echo $TPL_V1["pg"]?></span></span>
<?php }else{?>
					<span class="icon-pay-<?php echo $TPL_V1["payment"]?>"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }?>
<?php if($TPL_V1["payment"]=='bank'&&$TPL_V1["bank_name"]){?>
					<span class="darkgray"><span title="은행명"><?php echo $TPL_V1["bank_name"]?></span></span>
<?php }?>
<?php if($TPL_V1["deposit_date"]){?>
					 <div class="pdt5"><?php echo substr($TPL_V1["deposit_date"], 2, - 3)?></div>
<?php }?>
			</td>
			<td align="right" style="padding-right:5px;"><b><?php echo number_format($TPL_V1["settleprice"])?></b></td>
			<td align="center" class="ft11">
				<div><?php echo $TPL_V1["mstep"]?></div>
<?php if($TPL_V1["cancel_list_ea"]||$TPL_V1["exchange_list_ea"]||$TPL_V1["return_list_ea"]||$TPL_V1["refund_list_ea"]){?>
				<div>
<?php if($TPL_V1["cancel_list_ea"]){?>
					<a href="/admin/refund/catalog?keyword=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_cancel.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V1["cancel_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V1["exchange_list_ea"]){?>
					<a href="/admin/returns/catalog?keyword=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return_exchange.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V1["exchange_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V1["return_list_ea"]){?>
					<a href="/admin/returns/catalog?keyword=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V1["return_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V1["refund_list_ea"]){?>
					<a href="/admin/refund/catalog?keyword=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_refund.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V1["refund_list_ea"]?></span></a>
<?php }?>
				</div>
<?php }?>
			</td>
		</tr>
<?php }}?>
<?php }?>
		</tbody>
		<!-- 리스트 : 끝 -->
	</table>
</div>
<!-- 페이징 -->
<div class="paging_navigation" style="margin:auto;padding-bottom:30px;"><?php echo $TPL_VAR["pagin"]?></div>

<div class="hide" id="search_detail_dialog">
<form name="set_search_detail" method="post" action="set_search_default" target="actionFrame">
<div id="contents">
	<table class="search-form-table">
	<tr>
		<td>
			<table class="sf-option-table">
			<tr>
				<th width="100">주문일</th>
				<td class="date" height="30">
					<label class="search_label"><input type="radio" name="regist_date" value="today" <?php if(!$_GET["regist_date_type"]||$_GET["regist_date_type"]=='today'){?> checked="checked" <?php }?>/> 오늘</label>
					<label class="search_label"><input type="radio" name="regist_date" value="3day" <?php if($_GET["regist_date_type"]=='3day'){?> checked="checked" <?php }?>/> 3일간</label>
					<label class="search_label"><input type="radio" name="regist_date" value="7day" <?php if($_GET["regist_date_type"]=='7day'){?> checked="checked" <?php }?>/> 일주일</label>
					<label class="search_label"><input type="radio" name="regist_date" value="1mon" <?php if($_GET["regist_date_type"]=='1mon'){?> checked="checked" <?php }?>/> 1개월</label>
					<label class="search_label"><input type="radio" name="regist_date" value="3mon" <?php if($_GET["regist_date_type"]=='3mon'){?> checked="checked" <?php }?>/> 3개월</label>
					<label class="search_label"><input type="radio" name="regist_date" value="all" <?php if($_GET["regist_date_type"]=='all'){?> checked="checked" <?php }?>/> 전체</label>
				</td>
			</tr>

			<tr>
				<th>출고 전</th>
				<td>
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1< 50||$TPL_K1> 80){?>
<?php if($_GET["chk_step"][$TPL_K1]){?>
					<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" checked="checked" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }else{?>
					<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }?>
<?php }?>
<?php }}?>
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			<tr>
				<th>출고 후</th>
				<td>
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1>= 50&&$TPL_K1< 80){?>
<?php if($_GET["chk_step"][$TPL_K1]){?>
					<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" checked="checked" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }else{?>
					<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }?>
<?php }?>
<?php }}?>
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			<tr>
				<th>결제수단</th>
				<td>
<?php if(is_array($TPL_R1=config_load('payment'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if(!preg_match('/escrow/',$TPL_K1)){?>
<?php if($_GET["payment"][$TPL_K1]){?>
					<label class="search_label"><input type="checkbox" name="payment[<?php echo $TPL_K1?>]" value="1" checked="checked" /> <?php echo $TPL_V1?></label>
<?php }else{?>
					<label class="search_label"><input type="checkbox" name="payment[<?php echo $TPL_K1?>]" value="1" /> <?php echo $TPL_V1?></label>
<?php }?>
<?php }?>
<?php }}?>
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			<tr>
				<th>판매환경</th>
				<td>
<?php if($TPL_sitetypeloop_1){foreach($TPL_VAR["sitetypeloop"] as $TPL_K1=>$TPL_V1){?>
<?php if($_GET["sitetype"][$TPL_K1]){?>
						<label class="search_label" <?php if($TPL_K1=='MF'){?>style="width:150px"<?php }?> ><input type="checkbox" name="sitetype[<?php echo $TPL_K1?>]" value="<?php echo $TPL_K1?>" checked="checked" /> <?php echo $TPL_V1["name"]?></label>
<?php }else{?>
						<label class="search_label"  <?php if($TPL_K1=='MF'){?>style="width:150px"<?php }?> ><input type="checkbox" name="sitetype[<?php echo $TPL_K1?>]" value="<?php echo $TPL_K1?>" /> <?php echo $TPL_V1["name"]?></label>
<?php }?>
<?php }}?>
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			<tr>
				<th>주문유형</th>
				<td colspan="3">
					<label class="search_label" ><input type="checkbox" name="ordertype[personal]" value="personal" <?php if($_GET["ordertype"]['personal']){?>checked<?php }?>/> <img src="/admin/skin/default/images/design/icon_order_personal.gif" align="absmiddle" /> 개인결제</label>
					<label class="search_label" ><input type="checkbox" name="ordertype[admin]" value="admin" <?php if($_GET["ordertype"]['admin']){?>checked<?php }?>/> <img src="/admin/skin/default/images/design/icon_order_admin.gif" align="absmiddle" /> 관리자</label>
					<label class="search_label" ><input type="checkbox" name="ordertype[change]" value="change" <?php if($_GET["ordertype"]['change']){?>checked<?php }?>/> <img src="/admin/skin/default/images/design/icon_order_exchange.gif" align="absmiddle" /> 맞교환</label>
					<label class="search_label" ><input type="checkbox" name="ordertype[gift]" value="gift" <?php if($_GET["ordertype"]['gift']){?>checked<?php }?>/> <img src="/admin/skin/default/images/design/icon_order_gift.gif" align="absmiddle" /> 사은품</label>
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>
<div align="center" style="padding-top:10px;">
	<span class="btn large black">
		<button type="submit">저장하기<span class="arrowright"></span></button>
	</span>
</div>
</form>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>