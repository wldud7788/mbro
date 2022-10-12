<?php
/* 상품검색폼 출력*/
function showGoodsSearchForm($sc=array())
{
	$CI =& get_instance();
	$CI->load->model('goodsmodel');

	$skin_configuration = skin_configuration($CI->skin);
	$skin_configuration['category_navigation_count_w'] = explode("|",$skin_configuration['category_navigation_count_w']);

	if(strlen($sc['category_code'])>8){
		$skin_configuration['category_navigation_type'] = 'single';
	}

	$navigation_type = $skin_configuration['category_navigation_type'];
	$navigation_count_w = $sc['category_code'] ? $skin_configuration['category_navigation_count_w'][strlen($sc['category_code'])/4-1] : $skin_configuration['category_navigation_count_w'][0];
	$navigation_brand_count_w = $skin_configuration['category_navigation_brand_count_w'];

	$childCategoryList = array();
	$childBrandList = array();
	$childColorList = array();
	$price_arr	= getAlert('gv095');
	$price_arr	= explode('|',$price_arr);
	$priceList = array(
		array('title'=>$price_arr[0],'min'=>0,'max'=>10000), //~1만원
		array('title'=>$price_arr[1],'min'=>10000,'max'=>50000), //1~5만원
		array('title'=>$price_arr[2],'min'=>50000,'max'=>150000), //5~15만원
		array('title'=>$price_arr[3],'min'=>150000,'max'=>300000), //15~30만원
		array('title'=>$price_arr[4],'min'=>300000), //30만원~
	);

	switch(uri_string()){
		case "goods/search":	$kind = "search"; break;
		case "goods/brand":		$kind = "brand"; break;
		case "goods/location":	$kind = "location"; break;
		case "goods/catalog":	$kind = "category"; break;
		case "mshop":	$kind = "mshop"; break;
		default: 				$kind = "etc"; break;
	}

	switch($kind){
		case "etc":
		case "search":
		case "category":
			$CI->load->model('categorymodel');
			$childCategoryList = $CI->categorymodel->getChildCategory($sc['category_code'],false,'searchForm');
			if($skin_configuration['category_navigation_type']=='double'){
				foreach($childCategoryList as $k=>$v){
					$childCategoryList[$k]['childs'] = $CI->categorymodel->getChildCategory($v['category_code'],true,'searchForm');
				}
			}
			$childBrandList = $CI->categorymodel->getChildBrand($sc['category_code'],'searchForm');
		break;
		case "brand":
			if($skin_configuration['brand_navigation_type']){
				$skin_configuration['brand_navigation_count_w'] = explode("|",$skin_configuration['brand_navigation_count_w']);
				if(strlen($sc['brand_code'])>8) $skin_configuration['brand_navigation_type'] = 'single';
				$navigation_type = $skin_configuration['brand_navigation_type'];
				$navigation_count_w = $sc['brand_code'] ? $skin_configuration['brand_navigation_count_w'][strlen($sc['brand_code'])/4-1] : $skin_configuration['brand_navigation_count_w'][0];
			}

			$CI->load->model('brandmodel');
			$childCategoryList = $CI->brandmodel->getChildBrand($sc['brand_code'],false,'searchForm');
			if($skin_configuration['brand_navigation_type']=='double'){
				foreach($childCategoryList as $k=>$v){
					$childCategoryList[$k]['childs'] = $CI->brandmodel->getChildBrand($v['category_code'],true,'searchForm');
				}
			}
			$childCategoryListP = $CI->brandmodel->getChildCategory($sc['brand_code']);
		break;
		case "location":
			if($skin_configuration['location_navigation_type']){
				$skin_configuration['location_navigation_count_w'] = explode("|",$skin_configuration['location_navigation_count_w']);
				if(strlen($sc['location_code'])>8) $skin_configuration['location_navigation_type'] = 'single';
				$navigation_type = $skin_configuration['location_navigation_type'];
				$navigation_count_w = $sc['location_code'] ? $skin_configuration['location_navigation_count_w'][strlen($sc['location_code'])/4-1] : $skin_configuration['location_navigation_count_w'][0];
			}

			$CI->load->model('locationmodel');
			$childCategoryList = $CI->locationmodel->getChildLocation($sc['location_code']);
			if($skin_configuration['location_navigation_type']=='double'){
				foreach($childCategoryList as $k=>$v){
					$childCategoryList[$k]['childs'] = $CI->locationmodel->getChildLocation($v['location_code'],true,'searchForm');
				}
			}
			$childBrandList = $CI->locationmodel->getChildBrand($sc['location_code']);
		break;
		case "mshop":
			$CI->load->model('categorymodel');
			$childCategoryList = $CI->categorymodel->getChildCategory($sc['category_code'],false,'searchForm');
			if($skin_configuration['category_navigation_type']=='double'){
				foreach($childCategoryList as $k=>$v){
					$childCategoryList[$k]['childs'] = $CI->categorymodel->getChildCategory($v['category_code'],true,'searchForm');
				}
			}

			if ($sc['category_code']) {
				$childBrandList = $CI->categorymodel->getChildBrand($sc['category_code'],'searchForm');
			} else {
				$arr_code_chk = array();
				foreach ($childCategoryList as $key => $val) {
					$temp_brand = $CI->categorymodel->getChildBrand($childCategoryList[$key]['category_code'],'searchForm');
					for ($i=0;$i<count($temp_brand);$i++) {
						// 중복 제거
						if (!in_array($temp_brand[$i]['category_code'],$arr_code_chk)) {
							array_push($childBrandList,$temp_brand[$i]);
							$arr_code_chk[] = $temp_brand[$i]['category_code'];
						}
					}
				}
			}
		break;
	}

	$navigation_count_w = $navigation_count_w ? $navigation_count_w : 4;

	foreach($childCategoryList as $k=>$v){
		switch($kind){
			case "category":
				$childCategoryList[$k]['link'] = "?code={$v['category_code']}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands'));
				foreach($v['childs'] as $k2=>$v2){
					$childCategoryList[$k]['childs'][$k2]['link'] = "?code={$v2['category_code']}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands'));
				}
			break;
			case "brand":
				$childCategoryList[$k]['link'] = "?code={$v['category_code']}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands'));
				foreach($v['childs'] as $k2=>$v2){
					$childCategoryList[$k]['childs'][$k2]['link'] = "?code={$v2['category_code']}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands'));
				}
			break;
			case "location":
				$childCategoryList[$k]['link'] = "?code={$v['location_code']}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands'));
				foreach($v['childs'] as $k2=>$v2){
					$childCategoryList[$k]['childs'][$k2]['link'] = "?code={$v2['location_code']}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands'));
				}
			break;
			case "search":
				$childCategoryList[$k]['link'] = "?category_code={$v['category_code']}&".get_args_list(array('page','code','brand_code','category_code','color','start_price','end_price','brands'));
				foreach($v['childs'] as $k2=>$v2){
					$childCategoryList[$k]['childs'][$k2]['link'] = "?category_code={$v2['category_code']}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands'));
				}
			break;
			case "mshop":
			case "etc":
			default:
				$childCategoryList[$k]['link'] = "?category_code={$v['category_code']}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands'));
				foreach($v['childs'] as $k2=>$v2){
					$childCategoryList[$k]['childs'][$k2]['link'] = "?category_code={$v2['category_code']}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands'));
				}
			break;
		}
	}

	if($sc['search_text']) {
		if($_GET['insearch']){
			$arr_search_text = explode("\n",$_GET['old_search_text']);

			if(!in_array($sc['search_text'],$arr_search_text)) $arr_search_text[] = $sc['search_text'];

			$sc['search_text'] = array();
			foreach($arr_search_text as $search_text){
				if(trim($search_text)){
					$sc['search_text'][] = trim($search_text);
				}
			}

			$_GET['old_search_text'] = implode("\n",$sc['search_text']);
		}else{
			$_GET['old_search_text'] = $sc['search_text'];
		}
	}

	$childColorList = $CI->goodsmodel->getCategoryGoodsColors($sc);

	$CI->template->assign('kind',$kind);
	$CI->template->assign('category_navigation_count_w',$navigation_count_w);
	$CI->template->assign('category_navigation_brand_count_w',$navigation_brand_count_w);
	$CI->template->assign('category_navigation_type',$navigation_type);
	$CI->template->assign('childCategoryList',$childCategoryList);

	@usort($childBrandList, 'firstmallplus_brand_asc');//오름차순
	$CI->template->assign('childBrandList',$childBrandList);
	@usort($childCategoryListP, 'firstmallplus_brand_asc');//오름차순
	$CI->template->assign('childCategoryListP',$childCategoryListP);
	$CI->template->assign('childColorList',$childColorList);
	$CI->template->assign('priceList',$priceList);
	$CI->template->assign('old_search_text',$_GET['old_search_text']);

	echo "<div id='goodsSearchForm'>";
	$CI->template->define(array("goods_search_form"=>$CI->skin."/goods/_search_form.html"));
	$CI->template->print_("goods_search_form");
	echo "</div>";
}
?>