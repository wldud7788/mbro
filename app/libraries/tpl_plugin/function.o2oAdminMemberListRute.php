<?
	function o2oAdminMemberListRute($data){
		$CI =& get_instance();
		
		$CI->load->library('o2o/o2oinitlibrary');
		$CI->o2oinitlibrary->init_print_admin_member_list($data);
	}
?>