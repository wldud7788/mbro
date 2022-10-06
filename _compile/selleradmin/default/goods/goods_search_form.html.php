<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/goods_search_form.html 000025336 */ 
$TPL_shippingGroupList_1=empty($TPL_VAR["shippingGroupList"])||!is_array($TPL_VAR["shippingGroupList"])?0:count($TPL_VAR["shippingGroupList"]);
$TPL_ship_set_code_1=empty($TPL_VAR["ship_set_code"])||!is_array($TPL_VAR["ship_set_code"])?0:count($TPL_VAR["ship_set_code"]);
$TPL_event_list_1=empty($TPL_VAR["event_list"])||!is_array($TPL_VAR["event_list"])?0:count($TPL_VAR["event_list"]);
$TPL_gift_list_1=empty($TPL_VAR["gift_list"])||!is_array($TPL_VAR["gift_list"])?0:count($TPL_VAR["gift_list"]);
$TPL_referersale_list_1=empty($TPL_VAR["referersale_list"])||!is_array($TPL_VAR["referersale_list"])?0:count($TPL_VAR["referersale_list"]);
$TPL_sale_list_1=empty($TPL_VAR["sale_list"])||!is_array($TPL_VAR["sale_list"])?0:count($TPL_VAR["sale_list"]);
$TPL_r_goods_icon_1=empty($TPL_VAR["r_goods_icon"])||!is_array($TPL_VAR["r_goods_icon"])?0:count($TPL_VAR["r_goods_icon"]);?>
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/goods_admin.css?v=<?php echo date('Ymd')?>" />
<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd',$TPL_VAR["mktime"])?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/goodsSearch.js?mm=<?php echo date('Ymd',$TPL_VAR["mktime"])?>"></script>
<script type="text/javascript">
var scObj = <?php echo $TPL_VAR["scObj"]?>;
<?php if($TPL_VAR["socialcpuse"]||preg_match('/goods\/batch_modify/',$_SERVER["REQUEST_URI"])){?>
var sosialcpuse = true;
<?php }else{?>
var sosialcpuse = false;
<?php }?>
</script>
<div id="search_container" class="search_container" >

	<!-- 페이지 타이틀 바 : 끝 -->
	<form name="goodsForm" id="goodsForm" class='search_form'>
	<input type="hidden" name="query_string"/>
	<input type="hidden" name="no" />
	<input type="hidden" name="sort" 			value="<?php echo $TPL_VAR["sort"]?>"/>
	<input type="hidden" name="searchcount" 	value="<?php echo $TPL_VAR["page"]["searchcount"]?>" 	cannotBeReset=1 />
	<input type="hidden" name="mode" 			value="<?php echo $TPL_VAR["mode"]?>" 			cannotBeReset=1  noSaveData=1 >
	<input type="hidden" name="provider_seq" 	value="<?php echo $TPL_VAR["provider_seq"]?>" />
	<input type="hidden" name="goodsKind" 		value="<?php echo $TPL_VAR["sc"]["goodsKind"]?>"  	cannotBeReset=1 >
	<table class="table_search">
	<tr data-fid='sc_keyword' <?php if(!in_array('sc_keyword',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>검색어</span></th>
		<td colspan="3">
			<select name="search_field">
				<option value="all">전체</option>
				<option value="goods_name">상품명</option>
				<option value="goods_seq">상품번호</option>
				<option value="goods_code">상품코드</option>
				<option value="keyword">검색어</option>
				<option value="summary">간략설명</option>
				<option value="hscode">수출입상품코드</option>
				<option value="">-------------</option>
<?php if($TPL_VAR["catalog_page_gubun"]!="coupon"){?>
				<option value="weight">무게</option>
<?php }?>
				<option value="page_view">조회수</option>
			</select>
			<span class='search_keyword keyword'><input type="text" name="keyword" id="search_keyword"  class='resp_text wx800' /></span>
			<span class='search_keyword weight hide'><input type="text" name="sweight" class="resp_text" style="width:60px;" /> kg - <input type="text" name="eweight" class="resp_text" style="width:60px;" /> kg</span>
			<span class='search_keyword page_view hide'><input type="text" name="spage_view" class="resp_text" style="width:60px;" /> 회 - <input type="text" name="epage_view" class="resp_text" style="width:60px;" /> 회</span>
		</td>
	</tr>
	<tr data-fid='sc_category' <?php if(!in_array('sc_category',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>카테고리</span></th>
		<td colspan="3">
			<select class="wx110" name="category1" size="1"><option value="">1차 분류</option></select>
			<select class="wx110" name="category2" size="1"><option value="">2차 분류</option></select>
			<select class="wx110" name="category3" size="1"><option value="">3차 분류</option></select>
			<select class="wx110" name="category4" size="1"><option value="">4차 분류</option></select>&nbsp;
			<label class='resp_checkbox'><input type="checkbox" name="goods_category" value="1" defaultValue=false  /> 대표 카테고리 기준</label>&nbsp;
			<label class='resp_checkbox'><input type="checkbox" name="goods_category_no" class="not_regist" value="1" defaultValue=false /> 카테고리 미등록</label>
		</td>
	</tr>
	<tr data-fid='sc_brand' <?php if(!in_array('sc_brand',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>브랜드</span></th>
		<td colspan="3">
			<select class="wx110" name="brands1" size="1"><option value="">1차 분류</option></select>
			<select class="wx110" name="brands2" size="1"><option value="">2차 분류</option></select>
			<select class="wx110" name="brands3" size="1"><option value="">3차 분류</option></select>
			<select class="wx110" name="brands4" size="1"><option value="">4차 분류</option></select>&nbsp;
			<label class='resp_checkbox'><input type="checkbox" name="goods_brand" value="1" <?php if($TPL_VAR["sc"]["goods_brand"]){?>checked<?php }?> /> 대표 브랜드 기준</label>&nbsp;
			<label class='resp_checkbox'><input type="checkbox" name="goods_brand_no" class="not_regist" value="1" <?php if($TPL_VAR["sc"]["goods_brand_no"]){?>checked<?php }?> /> 브랜드 미등록</label>
		</td>
	</tr>
	<tr data-fid='sc_location' <?php if(!in_array('sc_location',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>지역</span></th>
		<td colspan="3">
			<select class="wx110" name="location1" size="1"><option value="">1차 분류</option></select>
			<select class="wx110" name="location2" size="1"><option value="">2차 분류</option></select>
			<select class="wx110" name="location3" size="1"><option value="">3차 분류</option></select>
			<select class="wx110" name="location4" size="1"><option value="">4차 분류</option></select>&nbsp;
			<label class='resp_checkbox'><input type="checkbox" name="goods_location" value="1" <?php if($TPL_VAR["sc"]["goods_location"]){?>checked<?php }?> /> 대표 지역 기준</label>&nbsp;
			<label class='resp_checkbox'><input type="checkbox" name="goods_location_no" class="not_regist" value="1" <?php if($TPL_VAR["sc"]["goods_location_no"]){?>checked<?php }?> /> 지역 미등록</label>
		</td>
	</tr>
	<tr data-fid='sc_regist_date' <?php if(!in_array('sc_regist_date',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>날짜</span></th>
		<td colspan="3">
			<div class="sc_day_date date_range_form">
				<div class="fl">
					<select name="date_gb" class="resp_select wx110" default_none >
					<option value="regist_date">등록일</option>
					<option value="update_date">수정일</option>
				</select>
					<input type="text" name="sdate" class="datepicker line sdate"  maxlength="10" default_none />
				-
					<input type="text" name="edate" class="datepicker line edate" maxlength="10" default_none   />
				</div>
				<div class="fl resp_btn_wrap mt1" style="display:inline !important">
					<input type="button"  range="today" value="오늘" class="select_date resp_btn" />
					<input type="button"  range="3day" value="3일간" class="select_date resp_btn" />
					<input type="button"  range="1week" value="일주일" class="select_date resp_btn" />
					<input type="button"  range="1month" value="1개월" class="select_date resp_btn" />
					<input type="button"  range="3month" value="3개월" class="select_date resp_btn" />
					<input type="button"  range="select_date_all"  value="전체" class="select_date resp_btn"/>
					<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden" />
				</div>
			</div>
		</td>
	</tr>
<?php if(!$TPL_VAR["socialcpuse"]){?>
	<tr data-fid='sc_color' <?php if(!in_array('sc_color',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>색상</span></th>
		<td colspan='3'>
			<div class="color-check">
<?php if(is_array($TPL_R1=$TPL_VAR["arr_common"]['colorPickList'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<label style="background-color:#<?php echo $TPL_V1["code"]?>;margin-top:5px;" class="<?php if($TPL_V1["select"]){?>active<?php }?>" alt="<?php echo $TPL_V1["name"]?>" title="<?php echo $TPL_V1["name"]?>"><input type="checkbox" name="color_pick[]" value="<?php echo $TPL_V1["code"]?>" <?php if($TPL_V1["select"]){?>checked<?php }?>  defaultValue=false />	</label>
<?php }}?>
				<button type="button" class="colorMultiCheck resp_btn v3">전체선택</button>
			</div>
		</td>
	</tr>
<?php }?>
	<tr data-fid='sc_status' <?php if(!in_array('sc_status',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>판매 상태</span></th>
		<td colspan='3'>
			<label class='resp_checkbox mr20'><input type="checkbox" name="goodsStatus[]" value="all" class="chkall" /> 전체</label>
			<label class='resp_checkbox mr20'><input type="checkbox" name="goodsStatus[]" value="normal" /> 정상</label>
			<label class='resp_checkbox mr20'><input type="checkbox" name="goodsStatus[]" value="runout"/> 품절</label>
			<label class='resp_checkbox mr20'><input type="checkbox" name="goodsStatus[]" value="purchasing" /> 재고 확보 중</label>
			<label class='resp_checkbox'><input type="checkbox" name="goodsStatus[]" value="unsold"/> 판매 중지</label>
		</td>
	</tr>
	<tr data-fid='sc_view' <?php if(!in_array('sc_view',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>노출 여부</span></th>
		<td colspan='3'>
			<label class='resp_radio mr20'><input type="radio" name="goodsView" value="" checked /> 전체</label>
			<label class='resp_radio mr20'><input type="radio" name="goodsView" value="look"/> 노출</label>
			<label class='resp_radio mr20'><input type="radio" name="goodsView" value="notLook" /> 미노출</label>
			<label class='resp_radio mr20'><input type="radio" name="goodsView" value="auto"/> 노출 예약</label>
		</td>
	</tr>
	<tr data-fid='sc_tax' <?php if(!in_array('sc_tax',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>과세 여부</span></th>
		<td colspan='3'>
			<label class='resp_radio mr20'><input type="radio" name="taxView" value="" checked /> 전체</label>
			<label class='resp_radio mr20'><input type="radio" name="taxView" value="tax"/> 과세</label>
			<label class='resp_radio'><input type="radio" name="taxView" value="exempt"/> 비과세</label>
		</td>
	</tr>
	<tr data-fid='sc_canceltype' <?php if(!in_array('sc_canceltype',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>청약 철회</span></th>
		<td colspan='3'>
			<label class='resp_radio mr20'><input type="radio" name="cancel_type" value="" checked /> 전체</label>
			<label class='resp_radio mr20'><input type="radio" name="cancel_type" value="y" /> 가능</label>
			<label class='resp_radio'><input type="radio" name="cancel_type" value="n" /> 불가능</label>
		</td>
	</tr>
	<tr data-fid='sc_adult' <?php if(!in_array('sc_adult',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>성인 인증</span></th>
		<td colspan='3'>
			<label class='resp_radio mr20'><input type="radio" name="adult_goods" value="" checked /> 전체</label>
			<label class='resp_radio mr20'><input type="radio" name="adult_goods" value="Y" /> 사용</label>
			<label class='resp_radio'><input type="radio" name="adult_goods" value="N" /> 사용 안 함</label>
		</td>
	</tr>
	<tr data-fid='sc_international' <?php if(!in_array('sc_international',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>개인통관고유부호</span></th>
		<td colspan='3'>
			<label class='resp_radio mr20'><input type="radio" name="search_option_international_shipping" value="" checked /> 전체</label>
			<label class='resp_radio mr20'><input type="radio" name="search_option_international_shipping" value="y"/> 수집</label>
			<label class='resp_radio'><input type="radio" name="search_option_international_shipping" value="n" /> 수집 안 함</label>
		</td>
	</tr>
	<tr data-fid='sc_price' <?php if(!in_array('sc_price',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>가격</span></th>
		<td colspan='3'>
			<select name="price_gb" style="width:100px;">
				<option value="consumer_price" >정가</option>
				<option value="price">판매가</option>
			</select>
			<input type="text" name="sprice" style="width:90px;" class="resp_text" /> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

			-
			<input type="text" name="eprice" style="width:90px;" class="resp_text" /> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

		</td>
	</tr>
	<tr data-fid='sc_stock' <?php if(!in_array('sc_stock',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>재고</span></th>
		<td colspan='3'>
			<select name="stock_compare">
				<option value="stock">재고</option>
				<option value="safe">안전재고</option>
				<option value="less">안전재고 보다 재고 부족</option>
				<option value="greater">안전재고 보다 몇 개 많은</option>
			</select>
			<span><input type="text" name="sstock"  class="resp_text wx70 onlyNumber" /> 개</span>
			<span>- <input type="text" name="estock" class="resp_text wx70 onlyNumber"  /> 개</span>
		</td>
	</tr>
	<tr data-fid='sc_sale_for_stock' <?php if(!in_array('sc_sale_for_stock',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>재고에 따른 판매</span></th>
		<td colspan='3'>
			<label class='resp_radio mr20'><input type="radio" name="goods_runout" value="" checked /> 전체</label>
			<label class='resp_radio mr20'><input type="radio" name="goods_runout" value="stock" /> 재고가 있으면 판매</label>
			<label class='resp_radio mr20'><input type="radio" name="goods_runout" value="ableStock" /> 가용재고가 있으면 판매</label>
			<label class='resp_radio'><input type="radio" name="goods_runout" value="unlimited" /> 재고와 상관없이 판매</label>
		</td>
	</tr>
	<tr data-fid='sc_shipping' <?php if(!in_array('sc_shipping',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span><?php if($TPL_VAR["socialcpuse"]){?>티켓 그룹<?php }else{?>배송 정책<?php }?></span></th>
		<td colspan='3'>
<?php if($TPL_VAR["socialcpuse"]){?>
			<label class='resp_radio mr20'><input type="radio" name="social_goods_group_search" value=""  checked /> 전체</label>
			<label class='resp_radio mr20'><input type="radio" name="social_goods_group_search" value="search"  /> 그룹 지정</label>
			<input type="hidden" name="social_goods_group" id="social_goods_group" value="<?php echo $TPL_VAR["sc"]["social_goods_group"]?>">
			<input type="text" name="social_goods_group_name" id="social_goods_group_name" class="social_goods_group_name" value="<?php echo $TPL_VAR["sc"]["social_goods_group_name"]?>"> 
			<button type="button" onclick="coupon_grp_find();" class="resp_btn v3">찾기</button>
<?php }else{?>
			<select name="shipping_group_seq" class="wx200 mr20">
			<option value=""> 선택</option>
<?php if($TPL_shippingGroupList_1){foreach($TPL_VAR["shippingGroupList"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["shipping_group_seq"]?>"
<?php if($TPL_VAR["sc"]["shipping_group_seq"]==$TPL_V1["shipping_group_seq"]){?>selected<?php }?>
<?php if($TPL_V1["shipping_provider_seq"]> 0&&$TPL_VAR["sc"]["provider_seq"]> 0&&$TPL_VAR["sc"]["provider_seq"]!=$TPL_V1["shipping_provider_seq"]){?>class="hide"<?php }?>
					shipping_provider_seq = "<?php echo $TPL_V1["shipping_provider_seq"]?>"
					koreaMethodDesc="<?php echo $TPL_V1["method_korea_text"]?>" globalMethodDesc="<?php echo $TPL_V1["method_global_text"]?>"
				><?php echo $TPL_V1["provider_name"]?><?php echo $TPL_V1["shipping_group_name"]?> (<?php echo $TPL_V1["shipping_group_seq"]?>)</option>
<?php }}?>
				<option value="-1" <?php if($TPL_VAR["sc"]["provider_seq_selector"]<= 1){?>class="hide"<?php }?> <?php if($TPL_VAR["sc"]["shipping_group_seq"]== - 1){?>selected<?php }?>>본사 위탁배송</option>
			</select>
<?php }?>

<?php if(!$TPL_VAR["socialcpuse"]){?>
			<span class="mr20">
				국내배송 : 
				<select name="shipping_set_code[domestic]">
					<option value="">전체</option>
<?php if($TPL_ship_set_code_1){foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>" <?php if($TPL_VAR["sc"]["shipping_set_code"]["domestic"]==$TPL_K1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</span>
			<span class="mr20">
				해외배송 :
				<select name="shipping_set_code[international]">
					<option value="">전체</option>
<?php if($TPL_ship_set_code_1){foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>" <?php if($TPL_VAR["sc"]["shipping_set_code"]["international"]==$TPL_K1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</span>

				<div id="domesticShippingList" class="<?php if($TPL_VAR["sc"]["shipping_group_seq"]){?>hide<?php }?>"><?php echo $TPL_VAR["sc"]["shipping_provider_seq"]?>

				</div>
				<div id="domesticShippingInfo" class="<?php if(!$TPL_VAR["sc"]["shipping_group_seq"]){?>hide<?php }?>"></div>

				<div id="internationalShippingList" class="<?php if($TPL_VAR["sc"]["shipping_group_seq"]){?>hide<?php }?>">
				</div>
				<div id="internationalShippingInfo" class="<?php if(!$TPL_VAR["sc"]["shipping_group_seq"]){?>hide<?php }?>"></div>
<?php }?>
		</td>
	</tr>
	<tr data-fid='sc_event' <?php if(!in_array('sc_event',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>이벤트</span></th>
		<td colspan='3'>
			<select name="event_type">
				<option value="event">할인 이벤트</option>
<?php if(serviceLimit('H_NFR')){?>
				<option value="gift">사은품 이벤트</option>
<?php }?>
				<option value="referer">유입경로 이벤트</option>
			</select>
			
			<select name="event_seq" class="event wx300">
				<option value="">선택</option>
<?php if($TPL_event_list_1){foreach($TPL_VAR["event_list"] as $TPL_V1){?><option value="<?php echo $TPL_V1["event_seq"]?>"><?php echo $TPL_V1["event_title"]?></option><?php }}?>
			</select>
			
			<select name="gift_seq" class="gift wx300 hide">
				<option value="">선택</option>
<?php if($TPL_gift_list_1){foreach($TPL_VAR["gift_list"] as $TPL_V1){?><option value="<?php echo $TPL_V1["gift_seq"]?>"><?php echo $TPL_V1["gift_title"]?></option><?php }}?>
			</select>
			<select name="referersale_seq" class="referer wx300 hide">
				<option value="">선택</option>
<?php if($TPL_referersale_list_1){foreach($TPL_VAR["referersale_list"] as $TPL_V1){?><option value="<?php echo $TPL_V1["referersale_seq"]?>"><?php echo $TPL_V1["referersale_name"]?></option><?php }}?>
			</select>
		</td>
		</td>
	</tr>
	<tr data-fid='sc_multi_discount' <?php if(!in_array('sc_multi_discount',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>구매수량 할인</span></th>
		<td>
			<label class='resp_radio mr20'><input type="radio" name="multi_discount" value="" checked /> 전체</label>
			<label class='resp_radio mr20'><input type="radio" name="multi_discount" value="Y"  /> 사용</label>
			<label class='resp_radio'><input type="radio" name="multi_discount" value="N"  /> 사용 안 함</label>
		</td>
		<th>등급별 구매혜택</th>
		<td>
			<select name="sale_seq" class="wx150">
				<option value="">전체</option>
<?php if($TPL_sale_list_1){foreach($TPL_VAR["sale_list"] as $TPL_V1){?><option value="<?php echo $TPL_V1["sale_seq"]?>"><?php echo $TPL_V1["sale_title"]?></option><?php }}?>
			</select>
		</td>
	</tr>
	<tr data-fid='sc_string_price' <?php if(!in_array('sc_string_price',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>가격 대체 문구</span></th>
		<td colspan='3'>
			<label class='resp_radio mr20'><input type="radio" name="search_string_price" value="" checked /> 전체</label>
			<label class='resp_radio mr20'><input type="radio" class="string_price_radio" name="search_string_price" value="1" /> 비회원</label>
			<label class='resp_radio mr20'><input type="radio" class="string_price_radio" name="search_string_price" value="2" /> 기본등급</label>
			<label class='resp_radio'><input type="radio" class="string_price_radio" name="search_string_price" value="3" /> 추가등급</label>
		</td>
	</tr>
	<tr data-fid='sc_favorite' <?php if(!in_array('sc_favorite',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>중요상품</span></th>
		<td colspan='3'>
			<label class='resp_radio mr20'><input type="radio" name="favorite_chk" value="" checked /> 전체</label>
			<label class='resp_radio mr20'><input type="radio" name="favorite_chk" value="checked" /> 체크</label>
			<label class='resp_radio'><input type="radio" name="favorite_chk" value="none"/> 미체크</label>
		</td>
	</tr>
	<tr data-fid='sc_icon' <?php if(!in_array('sc_icon',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>아이콘</span></th>
		<td colspan='3'>
			<span class="msg_select_icon" style="line-height:240% !important;"></span>
			<input type="hidden" name="select_search_icon" value="<?php echo $TPL_VAR["sc"]["select_search_icon"]?>"/>
			<button type="button" class="btn_search_icon_new resp_btn v2">검색</button>
		</td>
	</tr>
	<tr data-fid='sc_layaway' <?php if(!in_array('sc_layaway',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>예약 발송 상품</span></th>
		<td colspan='3'>
			<label class='resp_checkbox'><input type="checkbox" name="layaway_product" value="Y" defaultValue=false /> 예약 발송 상품</label>
		</td>
	</tr>
<?php if($TPL_VAR["catalog_page_gubun"]!="coupon"&&$TPL_VAR["cfg_order"]["present_seller_use"]==='y'){?>
	<tr data-fid='sc_present' <?php if(!in_array('sc_present',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>선물하기</span></th>
		<td colspan='3'>
			<label class='resp_radio mr20'><input type="radio" name="present_chk" value="" checked /> 전체</label>
			<label class='resp_radio mr20'><input type="radio" name="present_chk" value="1" /> 사용</label>
			<label class='resp_radio'><input type="radio" name="present_chk" value="0"/> 미사용</label>
		</td>
	</tr>
<?php }?>
	</table>
	<div class="footer search_btn_lay"></div>
	
</form>
</div>

<div class="cboth"></div>

<!--
<div id="provider_status_reason_detail_lay" class="hide">
	<div class="reason-list reason-3 hide">
		<table width="100%" cellpadding="0" cellspacing="0" border="0" class="info-table-style">
		<colgroup>
			<col width="20%" />
			<col />
		</colgroup>
		<tbody>
		<tr>
			<th class="its-th-align center">1. 행위자</th>
			<td class="its-td">입점사 관리자</td>
		</tr>
		<tr>
			<th class="its-th-align center">2. 행위</th>
			<td class="its-td">
				<div>아래 항목 수정</div>
				<div>- 실물배송상품 : 상품명, 정가, 할인가, 구매자별 판매가격 디스플레이</div>
				<div>- 티켓발송상품 : 상품명, 정가, 할인가, 구매자별 판매가격 디스플레이</div>
				<div style="margin-left:10px;">유효기간 전 후 취소(환불) 또는 미사용 티켓환불 설정</div>
			</td>
		</tr>
		<tr>
			<th class="its-th-align center">3. 자동처리</th>
			<td class="its-td">미승인 + 판매중지 + 미노출</td>
		</tr>
		</tbody>
		</table>
	</div>
</div>
-->

<!-- 아이콘 검색 -->
<div id="goodsSearchIconPopup" class="hide">
	<div class="content">
		<table align="center">
		<tr>
<?php if($TPL_r_goods_icon_1){$TPL_I1=-1;foreach($TPL_VAR["r_goods_icon"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1&&$TPL_I1% 4== 0){?></tr><tr><?php }?>
	<td style="width:100px;height:30px;text-align:left;">
			<label class="resp_checkbox">
			<input type="checkbox" class="goodsIconCode" name="goodsIconCode[]" value="<?php echo $TPL_V1["codecd"]?>" />
			<img src="/data/icon/goods/<?php echo $TPL_V1["codecd"]?>.gif" class="valign_middle" border="0">
		</label>
	</td>
<?php }}?>
		</tr>
		</table>
	</div>
	<div class="footer">
		<input type="hidden" name="chk_icon" id="chk_icon" value="list" />
		<button type="button" id="btn_select_icon" class="resp_btn active size_L">선택</button>
		<button type="button" name="btn-cancel" onclick="closeDialog('goodsSearchIconPopup');" class="resp_btn v3 size_L">취소</button>
	</div>
</div>