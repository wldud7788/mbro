<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/order/_search_form.html 000018317 */ 
$TPL_arr_search_keyword_1=empty($TPL_VAR["arr_search_keyword"])||!is_array($TPL_VAR["arr_search_keyword"])?0:count($TPL_VAR["arr_search_keyword"]);
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);
$TPL_ship_set_code_1=empty($TPL_VAR["ship_set_code"])||!is_array($TPL_VAR["ship_set_code"])?0:count($TPL_VAR["ship_set_code"]);
$TPL_arr_order_goods_type_1=empty($TPL_VAR["arr_order_goods_type"])||!is_array($TPL_VAR["arr_order_goods_type"])?0:count($TPL_VAR["arr_order_goods_type"]);
$TPL_marketList_1=empty($TPL_VAR["marketList"])||!is_array($TPL_VAR["marketList"])?0:count($TPL_VAR["marketList"]);?>
<script type="text/javascript">

	var search_type				= "<?php echo $TPL_VAR["sc"]["search_type"]?>";
	var keyword					= "<?php echo $TPL_VAR["sc"]["keyword"]?>";
	var search_type				= "<?php echo $TPL_VAR["sc"]["search_type"]?>";
	</script>
	<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js?dummy=<?php echo date('Ymd')?>"></script>
	<style>
		table.helpicon_table{padding:0px;margin:0px;border-top:1px solid #ddd !important;}
		table.helpicon_table th,table.helpicon_table td {font-weight:normal;padding:3px;margin:0px;border-right:1px solid #ddd !important;border-bottom:1px solid #ddd !important;text-align:center;}
		table.helpicon_table th:first-child,table.helpicon_table td:first-child {border-left:1px solid #ddd !important;}
	</style>
	
	<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/searchform.css?v=<?php echo date('Ymd')?>" />
	
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
<?php if($TPL_arr_search_keyword_1){foreach($TPL_VAR["arr_search_keyword"] as $TPL_K1=>$TPL_V1){?>
							<li><a class="link_keyword" s_type="<?php echo $TPL_K1?>" href="#"><?php echo $TPL_V1?>: <span class="txt_keyword"></span> <span class="txt_title">-<?php echo $TPL_V1?>로 찾기</span></a></li>
<?php }}?>
						</ul>
					</div>
					<!-- 검색어 입력시 레이어 박스 : end -->
				</div>																			
			</div>
			</td>
		</tr>
	</table>

<!-- 상세검색 시작 -->
<div class="search-detail-lay">
	<table class="search-form-table" id="search_detail_table" >
	<tr>
		<td>
			<table class="sf-option-table table_search" width="100%" border=0>
			<!-- 배송책임 -->
			<tr>
				<th>배송책임</th>
				<td colspan="5">
<?php if($TPL_VAR["pagemode"]=="company_catalog"){?>
					<span class="red bold">
<?php if($TPL_VAR["sc"]["shipping_provider_seq"]== 1){?>본사 (입점사 위탁배송 포함)
<?php }else{?>
						<?php echo $TPL_VAR["providerInfo"]["provider_name"]?> (입점사 위탁배송상품 제외)
<?php }?>
					</span>
					<input type="hidden" class="shipping_provider_seq" name="shipping_provider_seq" value="<?php echo $TPL_VAR["sc"]["shipping_provider_seq"]?>" default_none />
<?php }else{?>
					<div class="ui-widget">
						<select name="shipping_provider_seq_selector" default_none>
						<option value="0">- 검색 -</option>
						<option value="1" provider_id="본사" <?php if($TPL_VAR["sc"]["provider_seq"]== 1){?>selected<?php }?>>본사</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
<?php if($TPL_VAR["providerInfo"]["provider_name"]==$TPL_V1["provider_name"]){?>
						<option value="<?php echo $TPL_V1["provider_seq"]?>" provider_id="<?php echo $TPL_V1["provider_id"]?>" <?php if($TPL_VAR["sc"]["shipping_provider_seq"]==$TPL_V1["provider_seq"]){?>selected<?php }?>><?php echo $TPL_V1["provider_name"]?></option>
<?php }?>
<?php }}?>
						</select>						
						<input type="hidden" class="shipping_provider_seq" name="shipping_provider_seq" value="<?php echo $TPL_VAR["sc"]["shipping_provider_seq"]?>" default_none />
						<input type="text" name="shipping_provider_name" value="<?php echo $TPL_VAR["sc"]["shipping_provider_name"]?>" readonly class="disabled"  default_none />
					</div>

					<!--<div style="float:left;padding:7px 0px 0px 5px;;"><label><input type="checkbox" name="base_inclusion" value="1" <?php if($_GET["base_inclusion"]){?>checked<?php }?>  default_none /> 본사상품 주문</label></div>-->
					<span class="ptc-charges hide"></span>
<?php }?>
				</td>
			</tr>
			<!-- 날짜 -->
			<tr>
				<th>날짜</th>
				<td colspan="5">
					<input type="hidden" name="regist_date_type" value="<?php echo $TPL_VAR["sc"]["regist_date_type"]?>" default_none />
					<select name="date_field">
						<option value="regist_date" <?php if($_GET["date_field"]=='regist_date'||!$_GET["date_field"]){?>selected<?php }?>>주문일</option>
						<option value="deposit_date" <?php if($_GET["date_field"]=='deposit_date'){?>selected<?php }?>>입금일</option>
					</select>
					<input type="text" name="regist_date[]" value="<?php echo $TPL_VAR["sc"]["regist_date"][ 0]?>" class="datepicker"  maxlength="10" size="10" default_none />
					&nbsp;<span class="gray">-</span>&nbsp;
					<input type="text" name="regist_date[]" value="<?php echo $TPL_VAR["sc"]["regist_date"][ 1]?>" class="datepicker" maxlength="10" size="10" default_none />
				
					<span class="resp_btn_wrap">
						<span class="btn small"><input type="button" value="오늘" id="today" class="select_date resp_btn" settarget="regist_date"/></span>
						<span class="btn small"><input type="button" value="3일간" id="3day" class="select_date resp_btn" settarget="regist_date"/></span>
						<span class="btn small"><input type="button" value="일주일" id="1week" class="select_date resp_btn" settarget="regist_date"/></span>
						<span class="btn small"><input type="button" value="1개월" id="1month" class="select_date resp_btn" settarget="regist_date"/></span>
						<span class="btn small"><input type="button" value="3개월" id="3month" class="select_date resp_btn" settarget="regist_date"/></span>
						<span class="btn small"><input type="button" value="6개월" id="6month" class="select_date resp_btn" settarget="regist_date" /></span>
						<span class="btn small"><input type="button" value="1년" id="1year" class="select_date resp_btn" settarget="regist_date" /></span>
					</span>
				</td>
			</tr>
			<!-- 주문상태 출고 전 -->
			<tr>
				<th><span class='red'>상품상태</span> 출고 전</th>
				<td colspan="5">
					
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1!= 15&&($TPL_K1< 50||$TPL_K1> 80)){?>
					<label class="search_label resp_checkbox"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" <?php if($TPL_VAR["sc"]["chk_step"][$TPL_K1]){?>checked<?php }?> /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }?>
<?php }}?>
					
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			<!-- 주문상태 출고 후 -->
			<tr>
				<th><span class='red'>상품상태</span> 출고 후</th>
				<td colspan="5" style="position:relative;">
					
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1!= 15&&($TPL_K1>= 50&&$TPL_K1< 80)){?>
					<label class="search_label resp_checkbox"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" <?php if($TPL_VAR["sc"]["chk_step"][$TPL_K1]){?>checked<?php }?>/> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }?>
<?php }}?>
				
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
<?php if($TPL_VAR["detailmode"]!="trust"){?>
			<!-- 배송방법 -->
			<tr>
				<th>배송방법
					<span class="helpicon2 detailDescriptionLayerBtn" title="배송방법"></span>
					<!-- 배송방법 설명 -->
					<div class="detailDescriptionLayer hide">선택된 배송국가의 배송방법으로 주문된 주문 조회</div>
				</th>
				<td colspan="5">
					<div class="">
						<label class="search_label resp_checkbox" style="width:75px;"><input type="checkbox" name="nation[]" value="domestic" <?php if(in_array('domestic',$TPL_VAR["sc"]["nation"])){?>checked<?php }?>/> 대한민국</label>
						(
<?php if($TPL_ship_set_code_1){$TPL_I1=-1;foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
						<label class="resp_checkbox"><input type="checkbox" name="shipping_set_code[domestic][]" value="<?php echo $TPL_K1?>" groupset='domestic' grouplast="<?php if(count($TPL_VAR["ship_set_code"])- 1==$TPL_I1){?>y<?php }else{?>n<?php }?>" <?php if(in_array($TPL_K1,$TPL_VAR["sc"]["shipping_set_code"]["domestic"])){?>checked<?php }?> /><span  class="fx11"><?php echo $TPL_V1?></span></label>
<?php }}?>
						)

						<label class="search_label ml10 resp_checkbox" style="width:75px;"><input type="checkbox" name="nation[]" value="international" br='y'
<?php if(in_array('international',$TPL_VAR["sc"]["nation"])){?>checked<?php }?>/> 해외국가</label>
						(
<?php if($TPL_ship_set_code_1){$TPL_I1=-1;foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
						<label class="resp_checkbox"><input type="checkbox" name="shipping_set_code[international][]" value="<?php echo $TPL_K1?>"  groupset='international' grouplast="<?php if(count($TPL_VAR["ship_set_code"])- 1==$TPL_I1){?>y<?php }else{?>n<?php }?>" <?php if(in_array($TPL_K1,$TPL_VAR["sc"]["shipping_set_code"]["international"])){?>checked<?php }?> /><span  class="fx11"><?php echo $TPL_V1?></span></label>
<?php }}?>
						)

						&nbsp;|&nbsp;
						<label class="search_label resp_checkbox" style="width:auto;letter-spacing:-1px;"><input type="checkbox" name="shipping_set_code[ticket]" value="ticket" br='y' <?php if($TPL_VAR["sc"]["shipping_set_code"]["ticket"]=='ticket'){?>checked<?php }?> /> 문자/이메일(티켓발송)</label>
					</div>
				</td>
			</tr>
			<!-- 배송예정 -->
			<tr>
				<th>배송예정
					<span class="helpicon2 detailDescriptionLayerBtn" title="배송예정"></span>
					<!-- 배송방법 설명 -->
					<div class="detailDescriptionLayer wx300 hide">희망배송일이 입력기간인 주문조회<br />예약상품발송일이 입력기간인 주문조회</div>
				</th>
				<td colspan="5">

					<label class="search_label resp_checkbox" ><input type="checkbox" name="shipping_hop_use" value="y" <?php if($TPL_VAR["sc"]["shipping_hop_use"]=='y'){?>checked<?php }?>/> 희망배송일</label>

					<input type="text" name="shipping_hope_sdate" value="<?php echo $TPL_VAR["sc"]["shipping_hope_sdate"]?>" class="datepicker"  maxlength="10" size="10" default_none />
					<span class="gray">-</span>
					<input type="text" name="shipping_hope_edate" value="<?php echo $TPL_VAR["sc"]["shipping_hope_edate"]?>" class="datepicker" maxlength="10" size="10" default_none />
					&nbsp;<span class="btn small"><input type="button" value="오늘" id="today" class="select_date resp_btn v3 size_S" settarget="shipping_hope" /></span>

					<label class="search_label resp_checkbox ml20" style="width:110px;"><input type="checkbox" name="shipping_reserve_use" value="y" <?php if($TPL_VAR["sc"]["shipping_reserve_use"]=='y'){?>checked<?php }?>/> 예약상품발송일</label>

					<input type="text" name="shipping_reserve_sdate" value="<?php echo $TPL_VAR["sc"]["shipping_reserve_sdate"]?>" class="datepicker"  maxlength="10" size="10" default_none />
					<span class="gray">-</span>
					<input type="text" name="shipping_reserve_edate" value="<?php echo $TPL_VAR["sc"]["shipping_reserve_edate"]?>" class="datepicker" maxlength="10" size="10" default_none />
					&nbsp;<span class="btn small"><input type="button" value="오늘" id="today" class="select_date resp_btn size_S v3" settarget="shipping_reserve"/></span>

				</td>
			</tr>
			<!-- 주문상품 -->
			<tr>
				<th>주문상품
					<span class="helpicon2 detailDescriptionLayerBtn" title="주문상품"></span>
					<!-- 배송방법 설명 -->
					<div class="detailDescriptionLayer hide">
						<table class='helpicon_table' cellpadding=0 cellspacing=0>
						<tr><th>구분</th><th>주문상품</th><th>주문 조회 결과</th></tr>
						<tr><td>일반/티켓</td><td>성인상품</td><td class='red left'>성인상품이 있는 주문 조회</td></tr>
						<tr><td>일반/티켓</td><td>청약철회불가</td><td class='red left'>청약철회불가상품이 있는 주문 조회</td></tr>
						<tr><td>일반/티켓</td><td>구매대행</td><td class='red left'>구매대행상품이 있는 주문 조회</td></tr>
						<tr><td>일반</td><td>예약상품</td><td class='red left'>예약상품이 있는 주문 조회</td></tr>
						<tr><td>일반</td><td>패키지/복합상품</td><td class='red left'>패키지/복합상품이 있는 주문 조회</td></tr>
						<tr><td>일반</td><td>사은품</td><td class='red left'>사은품이 있는 주문 조회</td></tr>
						<tr><td>티켓</td><td>티켓</td><td class='red left'>티켓이 있는 주문 조회</td></tr>
						<tr><td>일반</td><td>위탁배송상품</td><td class='red left'>위탁배송이 있는 주문 조회</td></tr>
						</table>
					</div>
				</th>
				<td colspan="5">
					
<?php if($TPL_arr_order_goods_type_1){foreach($TPL_VAR["arr_order_goods_type"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1=="package"){?> |&nbsp;&nbsp;&nbsp;<?php }?>
					<label class="search_label resp_checkbox" no="1" <?php if($TPL_K1=="withdraw"||$TPL_K1=="package"){?>style="width:130px;"<?php }?>>
						<input type="checkbox" name="goodstype[]" value="<?php echo $TPL_K1?>" row_group="주문상품" <?php if(in_array($TPL_K1,$TPL_VAR["sc"]["goodstype"])){?>checked<?php }?>  /> <img src="/selleradmin/skin/default/images/design/icon_order_<?php echo $TPL_K1?>.gif" align="absmiddle" />
						<?php echo $TPL_V1?>

					</label>
<?php }}?>
					</div>
				</td>
			</tr>
			<!-- 마켓 연동 주문 -->
<?php if($TPL_VAR["connectorUse"]==true){?>
			<tr>
				<th>
					오픈마켓 주문
					<span class="helpicon2 detailDescriptionLayerBtn" title="오픈마켓 주문서 검색"></span>
				</th>
				<td colspan="5">
					<div class="resp_checkbox">
<?php if($TPL_marketList_1){foreach($TPL_VAR["marketList"] as $TPL_K1=>$TPL_V1){?>
					<label class="search_label">
						<input type="checkbox" name="selectMarkets[]" value="<?php echo $TPL_K1?>" <?php if(in_array($TPL_K1,$TPL_VAR["sc"]["selectMarkets"])){?>checked<?php }?>/> <span><?php echo $TPL_V1["name"]?></span>
					</label>
<?php }}?>
					</div>
				</td>
			</tr>
<?php }?>
			<tr>
				<th>
					주문유형
					<span class="helpicon2 detailDescriptionLayerBtn" title="주문유형 검색"></span>
					<!-- 주문유형 검색 -->
					<div class="detailDescriptionLayer hide">
						<table class='helpicon_table' cellpadding=0 cellspacing=0>
						<tr><th>주문유형</th><th>주문 조회 결과</th></tr>
						<tr><td>교환 주문</td><td class='red left'>교환 상품이 있는 주문</td></tr>
						<tr><td>관리자 주문</td><td class='red left'>관리자가 직접 주문을 생성한 주문</td></tr>
						<tr><td>개인결제</td><td class='red left'>관리자가 생성한 개인결제건에 대하여 구매자가 결제를 완료한 주문</td></tr>
						<tr><td>선물하기</td><td class='red left'>선물하기 상품 주문</td></tr>
						</table>
					</div>
				</th>
				<td>
					<label class="search_label resp_checkbox" ><input type="checkbox" name="ordertype[]" value="change" <?php if(in_array('change',$TPL_VAR["sc"]["ordertype"])){?>checked<?php }?> /> <img src="/admin/skin/default/images/design/icon_order_exchange.gif" align="absmiddle" /> 교환주문</label>
					<label class="resp_checkbox"><input type="checkbox" name="ordertype[]" value="admin"  <?php if(in_array('admin',$TPL_VAR["sc"]["ordertype"])){?>checked<?php }?> /> <img src="/admin/skin/default/images/design/icon_order_admin.gif" align="absmiddle" /> 관리자주문</label>
					<label class="resp_checkbox"><input type="checkbox" name="ordertype[]" value="personal" <?php if(in_array('personal',$TPL_VAR["sc"]["ordertype"])){?>checked<?php }?>  /> <img src="/admin/skin/default/images/design/icon_order_personal.gif" align="absmiddle" /> 개인결제</label>
					<label class="resp_checkbox"><input type="checkbox" name="ordertype[]" value="present" <?php if(in_array('present',$TPL_VAR["sc"]["ordertype"])){?>checked<?php }?>  /> <img src="/admin/skin/default/images/design/icon_order_present.gif" align="absmiddle" width="14" /> 선물하기</label>
				</td>

			</td>
<?php }?>
			</table>
		</td>
	</tr>
	</table>
</div>
<!-- 상세검색 끝 -->

<div class="footer search_btn_lay">
	<div>	
		<span class="sc_edit">
			<button type="button" id="set_default_setting_button" class="resp_btn v3">기본검색설정</button>
			<button type="button" id="set_default_apply_button" onclick="set_search_form('order')" class="resp_btn v3">기본검색적용</button>		
		</span>	
		<span class="search">	
			<button type="submit" class="resp_btn active size_XL"><span>검색</span></button>	
			<button type="button" id="search_reset_button" class="resp_btn v3 size_XL">초기화</button>		
		</span>				
		<span class="detail">	
			<button type="button" id="search_detail_button" class="close resp_btn v3" value="open">상세검색닫기</button>	
		</span>			
	</div>
</div>