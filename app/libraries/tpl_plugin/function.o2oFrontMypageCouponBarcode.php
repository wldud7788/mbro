<?
	function o2oFrontMypageCouponBarcode($data){
		$CI =& get_instance();
		
		$CI->load->library('o2o/o2oinitlibrary');
		$CI->o2oinitlibrary->init_print_front_mypage_coupon_list($data);
	}
?>