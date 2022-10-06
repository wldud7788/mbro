<?php /* Template_ 2.2.6 2022/03/23 16:45:55 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/goods/_search_form_light.html 000024510 */  $this->include_("assignBrandBestIcon","showCategoryRecommendDisplay","showBrandRecommendDisplay","showLocationRecommendDisplay");
$TPL_filterCategoryList_1=empty($TPL_VAR["filterCategoryList"])||!is_array($TPL_VAR["filterCategoryList"])?0:count($TPL_VAR["filterCategoryList"]);
$TPL_filterLocationList_1=empty($TPL_VAR["filterLocationList"])||!is_array($TPL_VAR["filterLocationList"])?0:count($TPL_VAR["filterLocationList"]);
$TPL_filterBrandList_1=empty($TPL_VAR["filterBrandList"])||!is_array($TPL_VAR["filterBrandList"])?0:count($TPL_VAR["filterBrandList"]);
$TPL_filterProviderList_1=empty($TPL_VAR["filterProviderList"])||!is_array($TPL_VAR["filterProviderList"])?0:count($TPL_VAR["filterProviderList"]);
$TPL_filterDelvieryCodes_1=empty($TPL_VAR["filterDelvieryCodes"])||!is_array($TPL_VAR["filterDelvieryCodes"])?0:count($TPL_VAR["filterDelvieryCodes"]);
$TPL_filterColors_1=empty($TPL_VAR["filterColors"])||!is_array($TPL_VAR["filterColors"])?0:count($TPL_VAR["filterColors"]);
$TPL_aBrandInfo_1=empty($TPL_VAR["aBrandInfo"])||!is_array($TPL_VAR["aBrandInfo"])?0:count($TPL_VAR["aBrandInfo"]);
$TPL_params_1=empty($TPL_VAR["params"])||!is_array($TPL_VAR["params"])?0:count($TPL_VAR["params"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 검색필터, 추천상품, 상품정렬 @@
- 파일위치 : [스킨폴더]/goods/_search_form_light.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<?php if($TPL_VAR["brand"]){?>
<?php }else{?> 
<?php }?>
<?php echo assignBrandBestIcon()?>

<?php if(uri_string()!='main/index'){?>
<form name="goodsSearchForm" id="goodsSearchForm" method="get">
<input type="hidden" name="osearchtext" value="<?php echo $TPL_VAR["goodsSearchText"]?>" />
<input type="hidden" name="ship_grp_seq" value="<?php echo $TPL_VAR["ship_grp_seq"]?>" />
<input type="hidden" name="event" value="<?php echo $TPL_VAR["event"]?>" />
<input type="hidden" name="gift" value="<?php echo $TPL_VAR["gift"]?>" />
<input type="hidden" name="page" value="<?php echo $TPL_VAR["params"]["page"]?>" />
<input type="hidden" name="searchMode" value="<?php echo end(explode('/',uri_string()))?>" />
<?php if($TPL_VAR["params"]["searchLimit"]){?>
<input type="hidden" name="searchLimit" value="<?php echo $TPL_VAR["params"]["searchLimit"]?>" />
<?php }?>
<div id="filterResultCount"><?php echo $TPL_VAR["totcount"]?></div>
<div class="search_filter_wrap" data-ezmark="undo">
	<!-- 필터 -->
	<ul id="searchFilter" class="search_filter">
<?php if($TPL_VAR["aFilterConfig"]["category"]){?>
		<li class="filter_section filter_category_section">
			<div class="filter_menu_area on">
				<a class="menuThebogi" href="#">카테고리</a>
			</div>
			<div class="filter_detail_area">
				<div class="message">
					카테고리가 없습니다.
				</div>
				<div class="category_all_nav">
<?php if(end(explode('/',uri_string()))!='catalog'){?>
					<a href="javascript:void(0)" class="mobile_pre_cate" data-searchname="pre" onclick="setFilterCategory(this, false);">상위 카테고리</a>
					<a href="javascript:void(0)" class="pc_all_cate" data-searchname="all" onclick="setFilterCategory(this, false);"><span class="name">전체</span></a>
<?php }?>
<?php if($TPL_VAR["categoryData"]["category_code"]){?>
					<a href="javascript:void(0)" class="mobile_pre_cate" data-searchname="pre" onclick="setFilterCategory(this, false);">상위 카테고리</a>
					<a href="javascript:void(0)" data-searchname="navi_category_<?php echo $TPL_VAR["categoryData"]["category_code"]?>" data-value="c<?php echo $TPL_VAR["categoryData"]["category_code"]?>" onclick="setFilterCategory(this, false);"><span class="name"><?php echo $TPL_VAR["categoryData"]["title"]?></span></a>
<?php }?>
<?php if($TPL_VAR["filterCategoryList"]){?>
					<span class="count_category">(<?php echo count($TPL_VAR["filterCategoryList"])?>개 카테고리)</span>
<?php }?>
				</div>
				<ul class="filter_detail_item li_align">
<?php if($TPL_filterCategoryList_1){foreach($TPL_VAR["filterCategoryList"] as $TPL_V1){?>
<?php if($TPL_V1["category_code"]){?>
					<li>
						<a href="javascript:void(0)" data-searchname="category_<?php echo $TPL_V1["category_code"]?>" data-value="c<?php echo $TPL_V1["category_code"]?>" onclick="setFilterCategory(this, false);">
							<span class="name"><?php echo $TPL_V1["category_name"]?></span>
							<span class="desc"><?php echo $TPL_V1["cnt"]?></span>
						</a>
					</li>
<?php }?>
<?php }}?>
				</ul>
			</div>
		</li>
<?php }?>
<?php if($TPL_VAR["aFilterConfig"]["location"]){?>
		<li class="filter_section filter_location_section">
			<div class="filter_menu_area on">
				<a class="menuThebogi" href="#">지역</a>
			</div>
			<div class="filter_detail_area">
				<div class="message">
					지역이 없습니다.
				</div>
				<div class="location_all_nav">
<?php if(end(explode('/',uri_string()))!='location'){?>
					<a href="javascript:void(0)" class="mobile_pre_location" data-searchname="pre" onclick="setFilterLocation(this, false);">상위 지역</a>
					<a href="javascript:void(0)" class="pc_all_location" data-searchname="all" onclick="setFilterLocation(this, false);"><span class="name">전체</span></a>
<?php }?>
<?php if($TPL_VAR["locationData"]["location_code"]){?>
					<a href="javascript:void(0)" class="mobile_pre_location" data-searchname="pre" onclick="setFilterLocation(this, false);">상위 지역</a>
					<a href="javascript:void(0)" data-searchname="navi_location_<?php echo $TPL_VAR["locationData"]["location_code"]?>" data-value="l<?php echo $TPL_VAR["locationData"]["location_code"]?>" onclick="setFilterLocation(this, false);"><span class="name"><?php echo $TPL_VAR["locationData"]["title"]?></span></a>
					<span class="count_location"></span>
<?php }?>
<?php if($TPL_VAR["filterLocationList"]){?>
					<span class="count_location">(<?php echo count($TPL_VAR["filterLocationList"])?>개 지역)</span>
<?php }?>
				</div>
				<ul class="filter_detail_item li_align">
<?php if($TPL_filterLocationList_1){foreach($TPL_VAR["filterLocationList"] as $TPL_V1){?>
<?php if($TPL_V1["location_code"]){?>
					<li>
						<a href="javascript:void(0)" data-searchname="location_<?php echo $TPL_V1["location_code"]?>" data-value="l<?php echo $TPL_V1["location_code"]?>" onclick="setFilterLocation(this, false);">
							<span class="name"><?php echo $TPL_V1["location_name"]?></span>
							<span class="desc"><?php echo $TPL_V1["cnt"]?></span>
						</a>
					</li>
<?php }?>
<?php }}?>
				</ul>
			</div>
		</li>
<?php }?>
<?php if($TPL_VAR["aFilterConfig"]["brand"]){?>
		<li class="filter_section filter_brand_section">
			<div class="filter_menu_area">
				<a class="menuThebogi" href="#">브랜드</a>
			</div>
			<div class="filter_detail_area">
				<div class="message">
					브랜드가 없습니다.
				</div>
				<div class="filter_section_sorting">
					<label class="active"><input type="radio" name="sorting-brand" value="cntindex" checked />상품수</label>
					<label><input type="radio" name="sorting-brand" value="nameindex" />가나다</label>
				</div>
				<ul class="filter_detail_item li_align brandList">
<?php if($TPL_filterBrandList_1){$TPL_I1=-1;foreach($TPL_VAR["filterBrandList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_V1["brand_code"]){?>
					<li>
<?php if($TPL_V1["brand_code"]&&$TPL_VAR["aBrandInfo"][$TPL_V1["brand_code"]]["category_code"]){?>
						<label data-searchname="brand_<?php echo $TPL_V1["brand_code"]?>" data-cntindex="<?php echo $TPL_I1?>" data-value="b<?php echo $TPL_V1["brand_code"]?>" class="active">
							<input type="checkbox" onclick="setFilterBrand(this, false);" checked />
<?php }else{?>
						<label data-searchname="brand_<?php echo $TPL_V1["brand_code"]?>" data-cntindex="<?php echo $TPL_I1?>" data-value="b<?php echo $TPL_V1["brand_code"]?>">
							<input type="checkbox" onclick="setFilterBrand(this, false);" />
<?php }?>							
								<?php echo $TPL_V1["brand_name"]?>

<?php if($TPL_V1["best"]=='Y'&&$TPL_VAR["brand_best_icon"]){?>
							<img class="icon" src="<?php echo $TPL_VAR["brand_best_icon"]?>" alt="best" onerror="this.src='/data/icon/goods/error/noimage_list.gif';" />
<?php }?>
						</label>
					</li>
<?php }?>
<?php }}?>
				</ul>
			</div>
		</li>
<?php }?>
<?php if($TPL_VAR["aFilterConfig"]["seller"]&&$TPL_VAR["filterProviderList"]){?>
		<li class="filter_section filter_seller_section">
			<div class="filter_menu_area">
				<a class="menuThebogi" href="#">판매자</a>
			</div>			
			<div class="filter_detail_area">
				<div class="message">
					판매자가 없습니다.
				</div>
				<div class="filter_section_sorting">
					<label class="active"><input type="radio" name="sorting-seller" value="cntindex" checked />상품수</label>
					<label><input type="radio" name="sorting-seller" value="nameindex" />가나다</label>
				</div>
				<ul class="filter_detail_item li_align sellerList">
<?php if($TPL_filterProviderList_1){$TPL_I1=-1;foreach($TPL_VAR["filterProviderList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_V1["provider_seq"]){?>
					<li>
<?php if($TPL_VAR["params"]["provider"]==$TPL_V1["provider_seq"]){?>
						<label data-searchname="seller_<?php echo $TPL_V1["provider_seq"]?>" data-cntindex="<?php echo $TPL_I1?>" data-value="<?php echo $TPL_V1["provider_seq"]?>" class="active">
							<input type="radio" onclick="setFilterProvider(this, false);" checked /><?php echo $TPL_V1["provider_name"]?>

						</label>
<?php }else{?>
						<label data-searchname="seller_<?php echo $TPL_V1["provider_seq"]?>" data-cntindex="<?php echo $TPL_I1?>" data-value="<?php echo $TPL_V1["provider_seq"]?>">
							<input type="radio" onclick="setFilterProvider(this, false);" /><?php echo $TPL_V1["provider_name"]?>

						</label>
<?php }?>
					</li>
<?php }?>
<?php }}?>
				</ul>
			</div>
		</li>
<?php }?>		
<?php if($TPL_VAR["filterDelvieryCodes"]||$TPL_VAR["aFilterConfig"]["rekeyword"]||$TPL_VAR["aFilterConfig"]["price"]||($TPL_VAR["filterColors"]&&$TPL_VAR["aFilterConfig"]["color"])){?>
		<li class="filter_section filter_detail_section">
			<div class="filter_menu_area">
				<a class="menuThebogi" href="#">상세</a>
			</div>
			<div class="filter_detail_area">
				<ul class="filter_detail_item">
<?php if($TPL_VAR["filterDelvieryCodes"]){?>
					<li class="shipping_area">
						<span class="detail_stitle mo_hide">배송</span>
<?php if($TPL_filterDelvieryCodes_1){foreach($TPL_VAR["filterDelvieryCodes"] as $TPL_V1){?>
<?php if(($TPL_VAR["aFilterConfig"]["freeship"]&&$TPL_V1["codecd"]=='free')||($TPL_VAR["aFilterConfig"]["abroadship"]&&$TPL_V1["codecd"]=='overseas')){?>
<?php if(in_array($TPL_V1["codecd"],$TPL_VAR["params"]["delivery"])){?>
						<label data-searchname="delivery_<?php echo $TPL_V1["codecd"]?>" class="btn_sfilter active" data-value="<?php echo $TPL_V1["codecd"]?>">
							<input type="checkbox" onclick="setFilterDelivery(this, false);" checked /><?php echo $TPL_V1["value"]?>

						</label>
<?php }else{?>
						<label data-searchname="delivery_<?php echo $TPL_V1["codecd"]?>" class="btn_sfilter" data-value="<?php echo $TPL_V1["codecd"]?>">
							<input type="checkbox" onclick="setFilterDelivery(this, false);" /><?php echo $TPL_V1["value"]?>

						</label>
<?php }?>
<?php }?>
<?php }}?>
					</li>
<?php }?>
<?php if($TPL_VAR["aFilterConfig"]["rekeyword"]){?>
					<li class="reresearch_area">
						<label><span class="detail_stitle">재검색</span> <input class="input_sfilter" type="text" data-searchname="re_search" value="<?php echo $TPL_VAR["params"]["re_search"]?>" /></label>
						<button type="button" class="btn_sfilter" id="reSearchApply">적용</button>
					</li>
<?php }?>
<?php if($TPL_VAR["aFilterConfig"]["price"]){?>
					<li class="price_area">
						<label><span class="detail_stitle">가격</span> <input class="input_sfilter" type="text" data-searchname="min_price" placeholder="0" value="<?php echo $TPL_VAR["params"]["min_price"]?>" /></label> ~
						<label><input class="input_sfilter" type="text"  data-searchname="max_price" placeholder="<?php echo number_format($TPL_VAR["filterMaxPrice"])?>" value="<?php echo $TPL_VAR["params"]["max_price"]?>" /></label>
						<button type="button" class="btn_sfilter" id="priceApply">적용</button>
					</li>
<?php }?>
<?php if($TPL_VAR["filterColors"]&&$TPL_VAR["aFilterConfig"]["color"]){?>
					<li class="color_area">
						<span class="detail_stitle mo_hide">색상</span>
<?php if($TPL_filterColors_1){$TPL_I1=-1;foreach($TPL_VAR["filterColors"] as $TPL_V1){$TPL_I1++;?>
<?php if(in_array($TPL_V1,$TPL_VAR["params"]["color"])){?>
						<label data-searchname="color_<?php echo $TPL_I1?>" style="background-color:#<?php echo $TPL_V1?>;" class="active" data-value="<?php echo $TPL_V1?>"><input type="checkbox"  onclick="setFilterColor(this, false);" checked /></label>
<?php }else{?>
						<label data-searchname="color_<?php echo $TPL_I1?>" style="background-color:#<?php echo $TPL_V1?>;" data-value="<?php echo $TPL_V1?>"><input type="checkbox"  onclick="setFilterColor(this, false);" /></label>
<?php }?>
<?php }}?>
					</li>
<?php }?>
				</ul>
			</div>
		</li>
<?php }?>
	</ul>

	<!-- 필터된 항목 -->
	<div id="searchFilterSelected" class="search_filter_selected">
		<ul class="selected_item_area">
		</ul>
		<div class="selected_etc_area">
			<a class="btn_all_cancel" href="#" title="전체해제" onclick="resetParams();"></a>
		</div>
	</div>

	<!--[ 추천상품 출력(추천상품 디스플레이 편집 : 관리자 > 상품리스트 페이지 > 설정 > 페이지 추천상품 ) ]-->
	<!-- 상품디스플레이 파일들 폴더 위치 : /data/design/ ( ※ /data 폴더는 /skin 폴더 상위 폴더입니다. ) -->
<?php if(end(explode('/',uri_string()))=='catalog'&&$TPL_VAR["categoryData"]["recommend_display_light_seq"]){?>
	<div id="recommendResult">		
		<?php echo showCategoryRecommendDisplay($TPL_VAR["categoryData"]["category_code"])?>

	</div>
<?php }?>
<?php if(end(explode('/',uri_string()))=='brand'&&$TPL_VAR["brandData"]["recommend_display_light_seq"]){?>
	<div id="recommendResult">
		<?php echo showBrandRecommendDisplay($TPL_VAR["brandData"]["category_code"])?>

	</div>
<?php }?>	
<?php if(end(explode('/',uri_string()))=='location'&&$TPL_VAR["locationData"]["recommend_display_light_seq"]){?>
	<div id="recommendResult">
		<?php echo showLocationRecommendDisplay($TPL_VAR["locationData"]["location_code"])?>

	</div>
<?php }?>

	<!-- 검색된 상품 정렬 -->
	<ul id="filteredItemSorting" class="filtered_item_sorting">
		<li class="item_total">
			<a href="javascript:void(0)" id="btnFilterOpen" class="total"><span class="num"><?php echo number_format($TPL_VAR["totcount"])?></span>개</a>
		</li>
		<li class="item_display">
<?php if($TPL_VAR["params"]["filter_display"]!='list'){?>
			<label class="display display_lattice active"><input type="radio" name="filter_display" value="lattice" onclick="filterDisplay()" checked />격자 반응형</label>
			<label class="display display_list"><input type="radio" name="filter_display" value="list" onclick="filterDisplay()" />리스트 반응형</label>
<?php }else{?>
			<label class="display display_lattice"><input type="radio" name="filter_display" value="lattice" onclick="filterDisplay()" />격자 반응형</label>
			<label class="display display_list active"><input type="radio" name="filter_display" value="list" onclick="filterDisplay()" checked />리스트 반응형</label>
<?php }?>
		</li>
		<li class="item_viewnum">
			<select name="per">
<?php if($TPL_VAR["params"]["per"]=='20'){?>
				<option value="20" selected>&nbsp;20개씩 보기&nbsp;</option>
<?php }else{?>
				<option value="20">&nbsp;20개씩 보기&nbsp;</option>
<?php }?>
<?php if($TPL_VAR["params"]["per"]=='40'){?>
				<option value="40" selected>&nbsp;40개씩 보기&nbsp;</option>
<?php }else{?>
				<option value="40">&nbsp;40개씩 보기&nbsp;</option>
<?php }?>
<?php if($TPL_VAR["params"]["per"]=='100'){?>
				<option value="100" selected>&nbsp;100개씩 보기&nbsp;</option>
<?php }else{?>
				<option value="100">&nbsp;100개씩 보기&nbsp;</option>
<?php }?>
<?php if($TPL_VAR["params"]["per"]=='200'){?>
				<option value="200" selected>&nbsp;200개씩 보기&nbsp;</option>
<?php }else{?>
				<option value="200">&nbsp;200개씩 보기&nbsp;</option>
<?php }?>
			</select>
		</li>
		<li class="item_order">
			<p id="mobileSortingSelected"></p>
			<ul class="list">
<?php if(end(explode('/',uri_string()))=='best'){?>
				<li>
<?php if($TPL_VAR["params"]["sorting"]=='sale'){?>
					<label class="active"><input type="radio" name="sorting" value="sale" checked />판매량순</label>
<?php }else{?>
					<label><input type="radio" name="sorting" value="sale" />판매량순</label>
<?php }?>
				</li>				
<?php }elseif(end(explode('/',uri_string()))=='new_arrivals'){?>
				<li>					
					<label class="active"><input type="radio" name="sorting" value="regist" checked />신규등록순</label>					
				</li>
<?php }else{?>
				<li>
<?php if($TPL_VAR["params"]["sorting"]=='ranking'){?>
					<label class="active"><input type="radio" name="sorting" value="ranking" checked />랭킹순</label>
<?php }else{?>
					<label><input type="radio" name="sorting" value="ranking" />랭킹순</label>
<?php }?>
				</li>
				<li>
<?php if($TPL_VAR["params"]["sorting"]=='regist'){?>
					<label class="active"><input type="radio" name="sorting" value="regist" checked />신규등록순</label>
<?php }else{?>
					<label><input type="radio" name="sorting" value="regist" />신규등록순</label>
<?php }?>
				</li>
				<li>
<?php if($TPL_VAR["params"]["sorting"]=='low_price'){?>
					<label class="active"><input type="radio" name="sorting" value="low_price" checked />낮은가격순</label>
<?php }else{?>
					<label><input type="radio" name="sorting" value="low_price" />낮은가격순</label>
<?php }?>
				</li>
				<li>
<?php if($TPL_VAR["params"]["sorting"]=='high_price'){?>
					<label class="active"><input type="radio" name="sorting" value="high_price" checked />높은가격순</label>
<?php }else{?>
					<label><input type="radio" name="sorting" value="high_price" />높은가격순</label>
<?php }?>
				</li>
				<li>
<?php if($TPL_VAR["params"]["sorting"]=='review'){?>
					<label class="active"><input type="radio" name="sorting" value="review" checked />상품평많은순</label>
<?php }else{?>
					<label><input type="radio" name="sorting" value="review" />상품평많은순</label>
<?php }?>
				</li>
				<li>
<?php if($TPL_VAR["params"]["sorting"]=='sale'){?>
					<label class="active"><input type="radio" name="sorting" value="sale" checked />판매량순</label>
<?php }else{?>
					<label><input type="radio" name="sorting" value="sale" />판매량순</label>
<?php }?>
				</li>
<?php }?>
			</ul>
		</li>
	</ul>
</div>
</form>
<script type="text/javascript">
var brand_best_icon = "<?php echo $TPL_VAR["brand_best_icon"]?>";
$(document).ready(function() {
	filterDisplay();
	
	/*<?php if($TPL_VAR["totcount"]== 0||$TPL_VAR["aFilterConfig"]["searchFilterUse"]=='0'){?>*/
	$("#searchFilterSelected").hide();
	/*<?php }?>*/
	// 상품 색상 코드값 디자인 white --> border
	if ( $('.displaY_color_option').length > 0 ) {
		$('.displaY_color_option .areA').filter(function() {
			return ( $(this).css('background-color') == 'rgb(255, 255, 255)' );
		}).addClass('border');
	}
	var aParams = {'category':'','brand':'','location':'','delivery':'','color':'','provider':'','re_search':'','min_price'	:'','max_price':''};
	/*<?php if($TPL_VAR["params"]["category"]){?>*/
	aParams['category']	= load_seleted_filter('category', 'category', 'category_<?php echo $TPL_VAR["categoryData"]["category_code"]?>', '<?php echo $TPL_VAR["params"]["category"]?>', '<?php echo $TPL_VAR["categoryData"]["title"]?>', 'category', '<?php echo $TPL_VAR["params"]["category"]?>');
	/*<?php }?>*/
	/*<?php if($TPL_VAR["params"]["brand"]){?>*/
		/*<?php if($TPL_aBrandInfo_1){foreach($TPL_VAR["aBrandInfo"] as $TPL_V1){?>*/
	aParams['brand']	+= load_seleted_filter('checkbox', 'brand', 'brand_<?php echo $TPL_V1["category_code"]?>', 'b<?php echo $TPL_V1["category_code"]?>', '<?php echo $TPL_V1["title"]?>', 'brand[]', 'b<?php echo $TPL_V1["category_code"]?>');
		/*<?php }}?>*/
	/*<?php }?>*/
	/*<?php if($TPL_VAR["params"]["location"]){?>*/
	aParams['location']	= load_seleted_filter('location', 'location', 'navi_location_<?php echo $TPL_VAR["params"]["location"]?>', '<?php echo $TPL_VAR["params"]["location"]?>', '<?php echo $TPL_VAR["locationData"]["title"]?>', 'location', '<?php echo $TPL_VAR["params"]["location"]?>');
	/*<?php }?>*/
	/*<?php if($TPL_VAR["params"]["delivery"]){?>*/
		/*<?php if($TPL_filterDelvieryCodes_1){foreach($TPL_VAR["filterDelvieryCodes"] as $TPL_V1){?>*/
			/*<?php if(in_array($TPL_V1["codecd"],$TPL_VAR["params"]["delivery"])){?>*/
	aParams['delivery']		+= load_seleted_filter('checkbox', 'delivery', 'delivery_<?php echo $TPL_V1["codecd"]?>', '<?php echo $TPL_V1["codecd"]?>', '<?php echo $TPL_V1["value"]?>', 'delivery[]', '<?php echo $TPL_V1["codecd"]?>');
			/*<?php }?>*/
		/*<?php }}?>*/
	/*<?php }?>*/
	/*<?php if($TPL_VAR["params"]["color"]){?>*/
		/*<?php if(is_array($TPL_R1=$TPL_VAR["params"]["color"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>*/
	aParams['color']		+= load_color_filter('<?php echo $TPL_I1?>','<?php echo $TPL_V1?>');
		/*<?php }}?>*/
	/*<?php }?>*/
	/*<?php if($TPL_VAR["params"]["provider"]){?>*/
	aParams['provider']		= load_seleted_filter('provider', 'provider', 'seller_<?php echo $TPL_VAR["params"]["provider"]?>', '', '<?php echo $TPL_VAR["aProvider"]["provider_name"]?>', 'provider', '<?php echo $TPL_VAR["params"]["provider"]?>');
	/*<?php }?>*/
	/*<?php if($TPL_VAR["params"]["re_search"]){?>*/
	aParams['re_search']	= load_seleted_filter('re_search', '', 're_search', '', '<?php echo $TPL_VAR["params"]["re_search"]?>', 're_search', '<?php echo $TPL_VAR["params"]["re_search"]?>');
	/*<?php }?>*/
	/*<?php if($TPL_VAR["params"]["min_price"]){?>*/
	aParams['min_price']	= load_seleted_filter('price', '', 'min_price', '', '<?php echo $TPL_VAR["params"]["min_price"]?>', 'min_price', '<?php echo $TPL_VAR["params"]["min_price"]?>');
	/*<?php }?>*/
	/*<?php if($TPL_VAR["params"]["max_price"]){?>*/
	aParams['max_price']	= load_seleted_filter('price', '', 'max_price', '', '<?php echo $TPL_VAR["params"]["max_price"]?>', 'max_price', '<?php echo $TPL_VAR["params"]["max_price"]?>');
	/*<?php }?>*/
	/*<?php if($TPL_params_1){foreach($TPL_VAR["params"] as $TPL_K1=>$TPL_V1){?>*/
		/*<?php if($TPL_K1=='category'){?>*/
	$('#searchFilterSelected .selected_item_area').append(aParams['category']);
		/*<?php }?>*/
		/*<?php if($TPL_K1=='brand'){?>*/
	$('#searchFilterSelected .selected_item_area').append(aParams['brand']);
		/*<?php }?>*/
		/*<?php if($TPL_K1=='location'){?>*/
	$('#searchFilterSelected .selected_item_area').append(aParams['location']);
		/*<?php }?>*/
		/*<?php if($TPL_K1=='delivery'){?>*/
	$('#searchFilterSelected .selected_item_area').append(aParams['delivery']);
		/*<?php }?>*/
		/*<?php if($TPL_K1=='color'){?>*/
	$('#searchFilterSelected .selected_item_area').append(aParams['color']);
		/*<?php }?>*/
		/*<?php if($TPL_K1=='provider'){?>*/
	$('#searchFilterSelected .selected_item_area').append(aParams['provider']);
		/*<?php }?>*/
		/*<?php if($TPL_K1=='re_search'){?>*/
	$('#searchFilterSelected .selected_item_area').append(aParams['re_search']);
		/*<?php }?>*/
		/*<?php if($TPL_K1=='min_price'){?>*/
	$('#searchFilterSelected .selected_item_area').append(aParams['min_price']);
		/*<?php }?>*/
		/*<?php if($TPL_K1=='max_price'){?>*/
	$('#searchFilterSelected .selected_item_area').append(aParams['max_price']);
		/*<?php }?>*/
	/*<?php }}?>*/	
	set_classification('<?php echo $TPL_VAR["categoryData"]["category_code"]?>', '<?php echo $TPL_VAR["locationData"]["location_code"]?>');	
	displaySearchFilter();
	
	goodsSearch('auto');
});
</script>
<?php }?>