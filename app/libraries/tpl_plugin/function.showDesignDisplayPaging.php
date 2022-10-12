<?php

/* 상품디스플레이 페이징 출력*/
function showDesignDisplayPaging($display_seq,$perpage,$paging_style=null)
{
	$CI =& get_instance();
	$CI->template->include_('showDesignDisplay');

	if($paging_style)
		return showDesignDisplay($display_seq,$perpage,$paging_style);
	else
		return showDesignDisplay($display_seq,$perpage);
}
?>