<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/goods/catalog.html 000015898 */  $this->include_("showBatchGoodsData");
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js?mm=<?php echo date('Ymd')?>"></script>
<!--<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?mm=<?php echo date('Ymd')?>"></script>
-->
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layer_stock.css?mm=<?php echo date('Ymd')?>">
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/admin_catalog.css?mm=<?php echo date('Ymd')?>">
<script type="text/javascript">
	var gl_goods_config 	= <?php echo $TPL_VAR["arr_gl_gooda_config"]?>;
</script>
<script type="text/javascript" src="/app/javascript/js/admin/goodsCatalog.js?mm=<?php echo date('Ymd')?>"></script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2><!--span class="icon-goods-kind-goods"></span-->일반 상품 조회</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button name="excel_upload" class="resp_btn v3 size_L"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> 상품 등록</button></li>
			<li><span class="icon-goods-kind-<?php echo $TPL_VAR["goods"]["goods_kind"]?>"></span><button class="resp_btn active size_L" onclick="location.href='regist';">상품 등록<span class="arrowright"></button></span></li>
		</ul>
	</div>
</div>

<!-- 상품 검색폼 : 시작 -->
<?php $this->print_("goods_search_form",$TPL_SCP,1);?>

<!-- 상품 검색폼 : 끝 -->

<div class="contents_dvs v2">
	<div class="list_info_container">
		<div class="dvs_left">	
			<div class="left-btns-txt">검색 <b><?php echo number_format($TPL_VAR["page"]["searchcount"])?></b> 개 (총 <b><?php echo number_format($TPL_VAR["page"]["totalcount"])?></b>개)</div>
		</div>
		<div class="dvs_right">	
			<span class="display_sort" sort="<?php echo $TPL_VAR["sc"]["orderby"]?>"></span>
			<span class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></span>
		</div>
	</div>

	<div class="table_row_frame">
		<div class="dvs_top">	
			<div class="dvs_left">	
				<button type="button" class="goods_delete_btn resp_btn v3">선택 삭제</button>
			</div>
			<div class="dvs_right">	
				<button type='button' name='' class='btn_goods_default_set resp_btn v2' data-kind="goods">리스트 항목</button>
				<button type='button' name='excel_down_btn' class='btn_excel_down v3 resp_btn' data-kind="goods"><img src="/admin/skin/default/images/common/btn_img_ex.gif" /><span>다운로드</span></button></button>
			</div>
		</div>

		<div class="sub-choose-lay">
			<div class="choose-down-lay">
				<ul>
					<li class="choose-title">다운로드</li>
					<li onclick="excel_down('new');" class="choose-item">실물 다운로드</li>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
<?php }else{?>
					<li onclick="excel_down('old');" class="choose-item">(구) 실물 다운로드</li>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
<?php $this->print_("o2o_barcode_download",$TPL_SCP,1);?>

<?php }?>
				</ul>
			</div>
			<div class="choose-form-lay">
				<ul>
					<li class="choose-title">다운로드항목설정</li>
					<li onclick="excel_form('new');" class="choose-item">실물 다운로드항목설정</li>
					<li onclick="excel_form('old');" class="choose-item">(구) 실물 다운로드항목설정</li>
				</ul>
			</div>
		</div>

		<!-- 엑셀다운로드/다운로드항목설정 -->
<?php $this->print_("excel_download_form",$TPL_SCP,1);?>


		<form name="goodsList" id="goodsList">
		<!-- 주문리스트 테이블 : 시작 -->
		<table class="table_row_basic list">
			<!-- 테이블 헤더 : 시작 -->
			<thead>
			<tr>
				<th style="min-width:35px"><label class='resp_checkbox'><input type="checkbox" id="chkAll" /></label></th>
				<th style="min-width:35px">중요<!--span class="icon-star-gray hand <?php if($TPL_VAR["sc"]["orderby"]=='favorite_chk'&&$TPL_VAR["sc"]["sort"]=='desc'){?>checked<?php }?>" id="order_star"></span--></th>
				<th style="min-width:40px">번호</th>
<?php if(serviceLimit('H_AD')){?>
				<th style="min-width:70px">입점사</th>
<?php }?>
				<th colspan="2">상품명</th>
				<th style="min-width:70px">정가</th>
				<th style="min-width:70px">판매가</th>
				<th style="min-width:90px;width:120px">재고/가용
					<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#catalog_stock', 'sizeS')"></span>
				</th>
				<th style="min-width:65px">재고판매
					<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#catalog_stock2', 'sizeS')"></span>
				</th>
				<th style="min-width:80px;max-width:120px">배송비</th>
				<th style="min-width:45px">조회</th>
				<th style="min-width:100px;max-width:120px;">등록일/수정일</th>
				<th style="min-width:60px">상태</th>
				<th style="min-width:50px">노출</th>
				<th style="min-width:50px">통계</th>
				<th style="min-width:50px">관리</th>
			</tr>
			</thead>
			<!-- 테이블 헤더 : 끝 -->

			<!-- 리스트 : 시작 -->
			<tbody>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
				<tr  style="height:70px;">
					<td class="center">
						<label class='resp_checkbox'><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" <?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?> scm_rtotal_stock=<?php echo $TPL_V1["rtotal_stock"]?> <?php }?> data-provider_seq="<?php echo $TPL_V1["provider_seq"]?>"/></label>
					</td>
					<td class="center"><span class="icon-star-gray star_select <?php echo $TPL_V1["favorite_chk"]?>" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"></span></td>
					<td class="center page_no"><?php echo $TPL_V1["_no"]?></td>
<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_V1["provider_seq"]=='1'){?>
					<td class="center blue">
<?php if($TPL_V1["lastest_supplier_name"]){?>
						본사 - <?php echo getstrcut($TPL_V1["lastest_supplier_name"], 5)?>

<?php }else{?>
						본사
<?php }?>
					</td>
<?php }else{?>
					<td class="center"><div class="overflow-breakall center" style="width:75px;margin:auto;"><a href="../provider/provider_reg?no=<?php echo $TPL_V1["provider_seq"]?>" target="_blank" class="red"><?php echo $TPL_V1["provider_name"]?></a></div></td>
<?php }?>
<?php }?>
					<td class="center" style="width:60px"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a></td>
					<td class="left" style="min-width:100px;max-width:400px;">
						<div class="overflow-breakall minw120">
							<div class="fx11">
<?php if($TPL_VAR["cfg_goods_default"]["list_condition_brand"]=='y'&&$TPL_V1["brand_default"]){?>
							[<?php echo $TPL_V1["brand_default"]?>]
<?php }?>
<?php if($TPL_VAR["cfg_goods_default"]["list_condition_category"]=='y'&&$TPL_V1["category_default"]){?>
							<?php echo $TPL_V1["category_default"]?>

<?php }?>
							</div>
							<?php echo showBatchGoodsData($TPL_V1)?>

						</div>
					</td>
					<td class="right">
						<div class="pdr5"><?php echo get_currency_price($TPL_V1["consumer_price"], 2)?></div>
					</td>
					<td class="right">
						<div class="pdr5"><?php echo get_currency_price($TPL_V1["price"], 2)?></div>
<?php if($TPL_VAR["cfg_goods_default"]["list_condition_stringprice"]=='y'&&($TPL_V1["string_price_use"]||$TPL_V1["member_string_price_use"]||$TPL_V1["allmember_string_price_use"])){?>
						<div class="list-string-price-lay">
							<button type="button" onmouseover="viewStringPrice('open', this);" onmouseout="viewStringPrice('close', this);" class="resp_btn size_S v3" >가격 노출 제한</button>
							<div class="view-string-price-lay hide">
								<table class="table_basic mt5" style="width:100%;border:1px solid #ccc !important; background: #FFF;">
<?php if($TPL_V1["string_price_use"]){?>
								<tr>
									<th width="140px" class="center">비회원</th>
									<td><?php echo $TPL_V1["string_price"]?></td>
								</tr>
<?php }?>
<?php if($TPL_V1["member_string_price_use"]){?>
								<tr>
									<th class="center">기본 등급</th>
									<td><?php echo $TPL_V1["member_string_price"]?></td>
								</tr>
<?php }?>
<?php if($TPL_V1["allmember_string_price_use"]){?>
								<tr>
									<th class="center">추가 등급</th>
									<td><?php echo $TPL_V1["allmember_string_price"]?></td>
								</tr>
<?php }?>
								</table>
							</div>
						</div>
<?php }?>
					</td>
					<td class="right">
						<table width="100%" style="padding-left:1px;padding-right:1px;">
							<tr>
								<td colspan=2 style="border:0px;height:15px;width:*;text-align:left;">
									[<?php echo number_format($TPL_V1["a_stock_cnt"])?>]
<?php if($TPL_V1["a_stock_cnt"]== 0){?>
									<?php echo $TPL_V1["a_stock"]?> / <?php echo $TPL_V1["a_rstock"]?>

<?php }else{?>
									<?php echo number_format($TPL_V1["a_stock"])?> / <?php echo number_format($TPL_V1["a_rstock"])?>

<?php }?>
								</td>
							</tr>
							<tr>
								<td style="border:0px;height:15px;text-align:left;">
									[<?php echo number_format($TPL_V1["b_stock_cnt"])?>]
<?php if($TPL_V1["b_stock_cnt"]== 0){?>
									<?php echo $TPL_V1["b_stock"]?> / <?php echo $TPL_V1["b_rstock"]?>

<?php }else{?>
									<?php echo number_format($TPL_V1["b_stock"])?> / <?php echo number_format($TPL_V1["b_rstock"])?>

<?php }?>
								</td>
								<td style="width:40px;border:0px;height:15px;text-align:right;padding-right:2px;">
									<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V1["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_V1["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
										<span class="option-stock" optType="option" optSeq=""></span>
										<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"><span class="hide">옵션</span></span>
									</span>
								</td>
							</tr>
						</table>
					</td>
					<td class="center">
<?php if($TPL_V1["runout_policy"]){?>
<?php if($TPL_V1["runout_policy"]=='stock'){?>
					<!--img src="/admin/skin/default/images/common/icon/ico_goods_stock.png" class="help" title="[개별설정] 주문수량 ≤ 재고" align="absmiddle" /-->
						재고
<?php }elseif($TPL_V1["runout_policy"]=='ableStock'){?>
					<!--img src="/admin/skin/default/images/common/icon/ico_goods_ablestock.png" class="help" title="[개별설정] 주문수량 ≤ 가용재고" align="absmiddle" /-->
						가용재고
<?php }elseif($TPL_V1["runout_policy"]=='unlimited'){?>
						<!--img src="/admin/skin/default/images/common/icon/ico_goods_nolimit.png" class="help" title="[개별설정] 무제한" align="absmiddle" /-->
						무제한
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["cfg_order"]["runout"]=='stock'){?>
					<!--img src="/admin/skin/default/images/common/icon/ico_config_stock.png" class="help" title="[통합설정] 주문수량 ≤ 재고" align="absmiddle" /-->
						재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='ableStock'){?>
					<!--img src="/admin/skin/default/images/common/icon/ico_config_ablestock.png" class="help" title="[통합설정] 주문수량 ≤ 가용재고" align="absmiddle" /-->
						가용재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='unlimited'){?>
						<!--img src="/admin/skin/default/images/common/icon/ico_config_nolimit.png" class="help" title="[통합설정] 무제한" align="absmiddle" /-->
						무제한
<?php }?>
<?php }?>
					</td>
				<td class="center overflow-breakall">
					<a href="../setting/shipping_group_regist?shipping_group_seq=<?php echo $TPL_V1["shipping_group_seq"]?><?php if($TPL_V1["provider_seq"]> 1&&$TPL_V1["trust_shipping"]=='N'){?>&provider_seq=<?php echo $TPL_V1["provider_seq"]?><?php }?>" target="_blank"><span class="underline black"><?php echo $TPL_V1["shipping_group_name"]?>(<?php echo $TPL_V1["shipping_group_seq"]?>)</span></a>
<?php if($TPL_V1["provider_seq"]> 1&&$TPL_V1["trust_shipping"]=='Y'){?>
						위탁배송
<?php }?>
					</td>
					<td class="center">
					<?php echo number_format($TPL_V1["page_view"])?>

					</td>
					<td class="center"><?php echo substr($TPL_V1["regist_date"], 0, 16)?><br/><?php echo substr($TPL_V1["update_date"], 0, 16)?></td>
					<td class="center">
<?php if($TPL_V1["provider_status_reason"]){?><div><?php echo $TPL_V1["provider_status_reason"]?></div><?php }?>
<?php if(serviceLimit('H_AD')){?><div><?php echo $TPL_V1["provider_status_text"]?></div><?php }?><div><?php echo $TPL_V1["goods_status_text"]?><div/>
					</td>
					<td class="center">
<?php if($TPL_V1["display_terms"]=='AUTO'){?>
					<span class="display-terms-<?php echo $TPL_V1["goods_seq"]?> underline black hand" onclick="openGoodsDisplayTerms('<?php echo $TPL_V1["goods_seq"]?>');">노출 예약</span><br/>
<?php }?>
						<span class="display-goods-view-<?php echo $TPL_V1["goods_seq"]?> <?php if($TPL_V1["display_terms"]=='AUTO'){?>hide<?php }?>"><?php echo $TPL_V1["goods_view_text"]?></span>
					</td>
					<td class="center">
						<div><button type="button" onclick="openAdvancedStatistic('<?php echo $TPL_V1["goods_seq"]?>');" class="resp_btn v3" >통계</button></div>
					</td>
					<td class="center">
						<div><button type="button" name="manager_modify_btn" goods_seq="<?php echo $TPL_V1["goods_seq"]?>" onclick="goodsView('<?php echo $TPL_V1["goods_seq"]?>');"class="resp_btn v2">수정</button></div>
						<div class="mt2"><button type="button" goods_seq="<?php echo $TPL_V1["goods_seq"]?>" class="manager_copy_btn resp_btn v2">복사</button></div>
					</td>
				</tr>
<?php }}?>
<?php }else{?>
			<tr class="list-row">
				<td class="center" height="40" <?php if(serviceLimit('H_AD')){?>colspan="18"<?php }else{?>colspan="17"<?php }?>>
<?php if($TPL_VAR["search_text"]){?>
						'<?php echo $TPL_VAR["search_text"]?>' 검색된 상품이 없습니다.
<?php }else{?>
						등록된 상품이 없습니다.
<?php }?>
				</td>
			</tr>
<?php }?>
			</tbody>
			<!-- 리스트 : 끝 -->

		</table>
		<!-- 주문리스트 테이블 : 끝 -->
		</form>
		
		<div class="dvs_bottom">	
			<div class="dvs_left">	
				<button type="button" class="goods_delete_btn resp_btn v3">선택 삭제</button>
			</div>
			<div class="dvs_right">	
				<button type='button' name='' class='btn_goods_default_set resp_btn v2' data-kind="goods">리스트 항목</button>
				<button type='button' name='excel_down_btn' class='btn_excel_down v3 resp_btn' data-kind="goods"><img src="/admin/skin/default/images/common/btn_img_ex.gif" /><span>다운로드</span></button></button>
			</div>
		</div>
	</div>
</div>

<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

<!--### 옵션보기 설정 -->
<div id="set_option_view_lay" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>