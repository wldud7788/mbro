<?php /* Template_ 2.2.6 2022/05/11 10:48:19 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/social_catalog.html 000013599 */  $this->include_("showBatchGoodsData");
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js?mm=<?php echo date('Ymd')?>"></script>
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/layer_stock.css?mm=<?php echo date('Ymd')?>">
<link rel="stylesheet" type="text/css" href="../skin/default/css/admin_catalog.css?mm=<?php echo date('Ymd')?>">
<script type="text/javascript">
	var gl_goods_config = <?php echo $TPL_VAR["arr_gl_gooda_config"]?>;
</script>
<script type="text/javascript" src="/app/javascript/js/admin/goodsCatalog.js?mm=<?php echo date('Ymd')?>"></script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>티켓 상품 조회</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button name="excel_upload" class="resp_btn v3 size_L" data-kind="coupon"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> 상품 등록</button></li>
			<li>
				<button onclick="location.href='social_regist';" class="resp_btn active size_L">상품 등록<span class="arrowright"></span></button>
			</li>
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 티켓상품 검색폼 : 시작 -->
<?php $this->print_("goods_search_form",$TPL_SCP,1);?>

<!-- 티켓상품 검색폼 : 끝 -->

<div class="contents_dvs v2" style="min-width:1200px;">
	<div class="list_info_container">
		<div class="dvs_left">	
			<div class="left-btns-txt">검색 <b><?php echo number_format($TPL_VAR["page"]["searchcount"])?></b> 개 (총 <b><?php echo number_format($TPL_VAR["page"]["totalcount"])?></b>개)</div>
		</div>
		<div class="dvs_right">	
			<span class="display_sort" sort="<?php echo $TPL_VAR["sc"]["sort"]?>"></span>
			<span class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></span>
		</div>
	</div>

	<div class="table_row_frame">
		<div class="dvs_top">	
			<div class="dvs_left">	
				<button type="button" class="goods_delete_btn resp_btn v3">선택 삭제</button>
			</div>
			<div class="dvs_right">	
				<button type='button' name='' class='btn_goods_default_set resp_btn v2' data-kind="coupon">리스트 항목</button>
				<button type='button' name='excel_down_btn' class='btn_excel_down resp_btn v3' data-kind="coupon"><img src="/admin/skin/default/images/common/btn_img_ex.gif" /> 다운로드</button></button>
			</div>
		</div>

		<!-- 엑셀다운로드/다운로드항목설정 -->
<?php $this->print_("excel_download_form",$TPL_SCP,1);?>


		<form name="goodsList" id="goodsList">
		<!-- 주문리스트 테이블 : 시작 -->
		<table class="table_row_basic list">
		<!-- 테이블 헤더 : 시작 -->
		<thead class="lth">
		<tr>
			<th style="min-width:35px"><label class='resp_checkbox'><input type="checkbox" id="chkAll" /></label></th>
			<th style="min-width:35px">중요<!--span class="icon-star-gray hand <?php if($TPL_VAR["sc"]["orderby"]=='favorite_chk'&&$TPL_VAR["sc"]["sort"]=='desc'){?>checked<?php }?>" id="order_star"></span--></th>
			<th style="min-width:40px">번호</th>
			<th colspan="2">티켓명</th>
			<th style="min-width:70px">정가</th>
			<th style="min-width:70px">판매가</th>
			<th style="min-width:80px;width:100px">재고/가용
				<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/goods', '#catalog_stock', 'sizeS')"></span>
			</th>
			<th style="min-width:65px">재고판매
				<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#catalog_stock2', 'sizeS')"></span>
			</th>
			<th style="min-width:45px">조회</th>
			<th style="min-width:110px">등록일/수정일</th>
			<th style="min-width:60px">상태</th>
			<th style="min-width:40px">노출</th>
			<th style="min-width:45px">관리</th>
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
				<td class="center" style="width:60px"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a></td>
				<td class="left" style="min-width:100px;max-width:350px;">
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
							<table class="table_basic mt5" style="width:100%;border-top:1px solid #ccc !important;border-right:1px solid #ccc !important;">
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
							</td>
						</tr>
					</table>
<?php if($TPL_V1["options"][ 0]["option_title"]){?>
					<br/>
<?php if($TPL_VAR["cfg_goods_default"]["list_condition_stock"]=='y'){?>
<?php if($TPL_V1["runout_policy"]=='stock'){?>
					<!-- img src="/admin/skin/default/images/common/icon/ico_goods_stock.png" class="help" title="[개별설정] 재고" align="absmiddle" / -->
					재고
<?php }elseif($TPL_V1["runout_policy"]=='ableStock'){?>
					<!--img src="/admin/skin/default/images/common/icon/ico_goods_ablestock.png" class="help" title="[개별설정] 가용재고" align="absmiddle" / -->
					가용재고
<?php }elseif($TPL_V1["runout_policy"]=='unlimited'){?>
					<!--img src="/admin/skin/default/images/common/icon/ico_goods_nolimit.png" class="help" title="[개별설정] 무제한" align="absmiddle" / -->
					무제한
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='stock'){?>
					<!-- img src="/admin/skin/default/images/common/icon/ico_config_stock.png" class="help" title="[통합설정] 재고" align="absmiddle" / -->
					재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='ableStock'){?>
					<!-- img src="/admin/skin/default/images/common/icon/ico_config_ablestock.png" class="help" title="[통합설정] 가용재고" align="absmiddle" / -->
					가용재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='unlimited'){?>
					<!-- img src="/admin/skin/default/images/common/icon/ico_config_nolimit.png" class="help" title="[통합설정] 무제한" align="absmiddle" / -->
					무제한
<?php }?>
<?php }?>
<?php }?>
				</td>
				<td class='center'>
<?php if($TPL_V1["runout_policy"]){?>
<?php if($TPL_V1["runout_policy"]=='stock'){?>
					재고
<?php }elseif($TPL_V1["runout_policy"]=='ableStock'){?>
					가용재고
<?php }elseif($TPL_V1["runout_policy"]=='unlimited'){?>
					무제한
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["cfg_order"]["runout"]=='stock'){?>
					재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='ableStock'){?>
					가용재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='unlimited'){?>
					무제한
<?php }?>
<?php }?>
				</td>
				<td class="center"><?php echo number_format($TPL_V1["page_view"])?></td>
				<td class="center"><?php echo substr($TPL_V1["regist_date"], 0, 16)?><br/><?php echo substr($TPL_V1["update_date"], 0, 16)?></td>
				<td class="center">
<?php if($TPL_V1["provider_status_reason"]){?><?php echo $TPL_V1["provider_status_reason"]?><br/><?php }?>
<?php if(serviceLimit('H_AD')){?><?php echo $TPL_V1["provider_status_text"]?><br/><?php }?><?php echo $TPL_V1["goods_status_text"]?>

				</td>
				<td class="center">
<?php if($TPL_V1["display_terms"]=='AUTO'){?>
					<span class="click-lay display-terms-<?php echo $TPL_V1["goods_seq"]?>" style="color:#ff9900 !important;" onclick="openGoodsDisplayTerms('<?php echo $TPL_V1["goods_seq"]?>');">자동<br/>노출</span>
<?php }?>
					<span class="display-goods-view-<?php echo $TPL_V1["goods_seq"]?> <?php if($TPL_V1["display_terms"]=='AUTO'){?>hide<?php }?>"><?php echo $TPL_V1["goods_view_text"]?></span>
				</td>
				<td class="center">
					<div><button type="button" name="manager_modify_btn" class="resp_btn v2" goods_seq="<?php echo $TPL_V1["goods_seq"]?>" onclick="goodsView('<?php echo $TPL_V1["goods_seq"]?>');">상세</button></div>
					<div><button type="button" class="manager_copy_btn resp_btn v2 mt2" goods_seq="<?php echo $TPL_V1["goods_seq"]?>">복사</button></div>
				</td>
			</tr>
<?php }}?>
<?php }else{?>
		<tr class="list-row">
			<td class="center" height="40" colspan="15">
<?php if($TPL_VAR["search_text"]){?>
					'<?php echo $TPL_VAR["search_text"]?>' 검색된 티켓상품이 없습니다.
<?php }else{?>
					등록된 티켓상품이 없습니다.
<?php }?>
			</td>
		</tr>
<?php }?>
		</tbody>
		<!-- 리스트 : 끝 -->
		</table>
		</form>

		<div class="dvs_bottom">	
			<div class="dvs_left">	
				<button type="button" class="goods_delete_btn resp_btn v3">선택 삭제</button>
			</div>
			<div class="dvs_right">	
				<button type='button' name='' class='btn_goods_default_set resp_btn v2' data-kind="coupon">리스트 항목</button>
				<button type='button' name='excel_down_btn' class='btn_excel_down resp_btn v3' data-kind="coupon"><img src="/admin/skin/default/images/common/btn_img_ex.gif" /> 다운로드</button></button>
			</div>
		</div>

	</div>

<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>
</div>

<!--### 옵션보기 설정 -->
<div id="set_option_view_lay" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>