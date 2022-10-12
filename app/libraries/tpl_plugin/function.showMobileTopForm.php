<?php
/* 모바일 상단탭바 출력*/
function showMobileTopForm($sc=array())
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

	$getargsar = array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands','infirstsearch','insecondsearch');
	$childCategoryList = array();
	$childBrandList = array();
	$childColorList = array();
	$priceList = array(
		array('title'=>'~1만원','min'=>0,'max'=>10000),
		array('title'=>'1~5만원','min'=>10000,'max'=>50000),
		array('title'=>'5~15만원','min'=>50000,'max'=>150000),
		array('title'=>'15~30만원','min'=>150000,'max'=>300000),
		array('title'=>'30만원~','min'=>300000),
	);
	switch(uri_string()){
		case "goods/search":	$kind = "search"; $kindtitle = getAlert("et395"); break;		// 카테고리
		case "mshop":	$kind = "mshop"; $kindtitle = getAlert("et395"); break;				// 카테고리
		case "goods/brand":		$kind = "brand"; $kindtitle = getAlert("et396");break;		//"브랜드";
		case "goods/location":	$kind = "location"; $kindtitle = getAlert("os058");break;		// "지역"
		case "goods/catalog":	$kind = "category"; $kindtitle = getAlert("et395");break;				// 카테고리
		default: 				$kind = "etc"; $kindtitle = getAlert("et395");break;				// 카테고리
	}

	switch($kind){
		case "mshop":
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
			$childBrandList = $CI->categorymodel->getChildBrand($sc['category_code']);

		break;
		case "brand":
			if($skin_configuration['brand_navigation_type']){
				$skin_configuration['brand_navigation_count_w'] = explode("|",$skin_configuration['brand_navigation_count_w']);
				if(strlen($sc['brand_code'])>8) $skin_configuration['brand_navigation_type'] = 'single';
				$navigation_type = $skin_configuration['brand_navigation_type'];
				$navigation_count_w = $sc['brand_code'] ? $skin_configuration['brand_navigation_count_w'][strlen($sc['brand_code'])/4-1] : $skin_configuration['brand_navigation_count_w'][0];
			}

			$CI->load->model('brandmodel');
			$childCategoryList = $CI->brandmodel->getChildCategory($sc['brand_code'],false,'searchForm');
			if($skin_configuration['category_navigation_type']=='double'){
				foreach($childCategoryList as $k=>$v){
					$childCategoryList[$k]['childs'] = $CI->brandmodel->getChildCategory($v['category_code'],true,'searchForm');
				}
			}
			$childBrandList = $CI->brandmodel->getChildBrand($sc['brand_code']);
			foreach($childBrandList as $k=>$v){
				$childBrandList[$k]['link'] = "?code={$v['category_code']}&".get_args_list($getargsar);

			}

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
			if($skin_configuration['category_navigation_type']=='double'){
				foreach($childCategoryList as $k=>$v){
					$childCategoryList[$k]['childs'] = $CI->locationmodel->getChildLocation($v['location_code'],true,'searchForm');
				}
			}
			$childBrandList = $CI->locationmodel->getChildBrand($sc['location_code']);
		break;
	}

	$navigation_count_w = $navigation_count_w ? $navigation_count_w : 4;

	foreach($childCategoryList as $k=>$v){
		switch($kind){
			case "category":
				$childCategoryList[$k]['link'] = "?code={$v['category_code']}&".get_args_list($getargsar);
				foreach($v['childs'] as $k2=>$v2){
					$childCategoryList[$k]['childs'][$k2]['link'] = "?code={$v2['category_code']}&".get_args_list($getargsar);
				}
			break;
			case "brand":
				$childCategoryList[$k]['link'] = "?code={$_GET['code']}&category_code={$v['category_code']}&".get_args_list($getargsar);
				foreach($v['childs'] as $k2=>$v2){
					$childCategoryList[$k]['childs'][$k2]['link'] = "?code={$_GET['code']}&category_code={$v2['category_code']}&".get_args_list($getargsar);
				}
			break;
			case "location":
				$childCategoryList[$k]['link'] = "?code={$v['location_code']}&".get_args_list($getargsar);
				foreach($v['childs'] as $k2=>$v2){
					$childCategoryList[$k]['childs'][$k2]['link'] = "?code={$v2['location_code']}&".get_args_list($getargsar);
				}
			break;
			case "search":
				$childCategoryList[$k]['link'] = "?category_code={$v['category_code']}&".get_args_list(array('page','code','brand_code','category_code','color','start_price','end_price','brands'));
				foreach($v['childs'] as $k2=>$v2){
					$childCategoryList[$k]['childs'][$k2]['link'] = "?category_code={$v2['category_code']}&".get_args_list($getargsar);
				}
			break;
			case "etc":
			default:
				$childCategoryList[$k]['link'] = "?category_code={$v['category_code']}&".get_args_list($getargsar);
				foreach($v['childs'] as $k2=>$v2){
					$childCategoryList[$k]['childs'][$k2]['link'] = "?category_code={$v2['category_code']}&".get_args_list($getargsar);
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
	$CI->template->assign('kindtitle',$kindtitle);
	$CI->template->assign('category_navigation_count_w',$navigation_count_w);
	$CI->template->assign('category_navigation_brand_count_w',$navigation_brand_count_w);
	$CI->template->assign('category_navigation_type',$navigation_type);
	$CI->childCategoryList =  $childCategoryList;
	$CI->template->assign('childCategoryList',$childCategoryList);

	@usort($childBrandList, 'firstmallplus_brand_asc');//오름차순
	$CI->template->assign('childBrandList',$childBrandList);
	$CI->template->assign('childColorList',$childColorList);
	$CI->template->assign('priceList',$priceList);
	$CI->template->assign('old_search_text',$_GET['old_search_text']);

	//카테고리별 추천상품 기능과 display_style 겹치는 오류로 추가
	$CI->style = ($_GET['display_style'])?$_GET['display_style']:'mobile_lattice_a';
	$CI->template->assign(array('display_style'		=>$CI->style));


	echo "<div id='goods".$kind."Form'>";
	$CI->template->define(array("mobile_top_form"=>$CI->skin."/goods/_search_form.html"));
	$CI->template->print_("mobile_top_form");
	echo "</div>";

}
?>