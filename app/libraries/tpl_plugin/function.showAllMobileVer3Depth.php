<?php

function showAllMobileVer3Depth( $ftype='category', $return=false)
{
	$CI =& get_instance(); 
	if( $ftype == 'mshop' ) {
		$allcode = $_GET['category_code'];
	}else{
		$allcode = ($_GET['code'])?$_GET['code']:$_GET['category_code'];
	}

	if( $ftype == 'brand' ) {
		$brand['showall_code'] = $CI->brandmodel->split_brand($allcode);
		$i=0;
		if($brand['showall_code'])foreach($brand['showall_code'] as $code){
			$i++;
			$brands[$code]['showall'] = $CI->brandmodel->one_brand_name($code);
			$brands[$code]['link'] = "?code={$code}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands'));

			if( count($brand['showall_code']) == $i ) {
				$getchildbrand = $CI->brandmodel->getChildBrand($code,true,'searchForm');
				$brands[$code]['showall_count'] = count($getchildbrand);
			}
		}
		$AllMobileVer3Depth = $brands;

	}elseif( $ftype == 'location'  ) {

		$location['showall_code'] = $CI->locationmodel->split_location($allcode);

		$i=0;
		if($location['showall_code'])foreach($location['showall_code'] as $code){
			$i++;
			$locations[$code]['showall'] = $CI->locationmodel->one_location_name($code);
			$locations[$code]['link'] = "?code={$code}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands'));

			if( count($location['showall_code']) == $i ) {
				$getchildlocation = $CI->locationmodel->getChildLocation($code,true,'searchForm');
				$locations[$code]['showall_count'] = count($getchildlocation);
			}
		}
	
		$AllMobileVer3Depth = $locations; 

	}else{
		$CI->load->model('categorymodel');
		
		$category['showall_code'] = $CI->categorymodel->split_category($allcode);
		$i=0;
		if($category['showall_code'])foreach($category['showall_code'] as $code){
			$i++;
			$categorys[$code]['showall'] = $CI->categorymodel->one_category_name($code);
			$categorys[$code]['link'] = "?code={$code}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands')); 
			$categorys[$code]['link2'] = "?category_code={$code}&".get_args_list(array('page','code','brand_code','category_code','search_text','old_search_text','color','start_price','end_price','brands')); 

			if( count($category['showall_code']) == $i ) {
				$getchildcategory = $CI->categorymodel->getChildCategory($code,true,'searchForm');
				$categorys[$code]['showall_count'] = count($getchildcategory);
			}
		}

		$AllMobileVer3Depth = $categorys;

	}

	if( $return === true  ) {//if조건체크용
		if( $AllMobileVer3Depth ) {
			return true;
		}else{
			return false;
		}
	} 

	return $AllMobileVer3Depth;
}
?>