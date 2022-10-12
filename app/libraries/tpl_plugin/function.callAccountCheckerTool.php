<?
	function callAccountCheckerTool($accountData, $carryover = '', $checker_tool_view_succ=0){
		$CI =& get_instance();
		$CI->load->helper('accountall');
		
		$html = getHtmlAccountCheckerTool($accountData, $carryover, $checker_tool_view_succ);
		
		return $html;
	}
?>