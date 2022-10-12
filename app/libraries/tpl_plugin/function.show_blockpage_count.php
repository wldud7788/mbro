<?php
/*
 * blockpage count를 가져오기 위한 공용 함수
 * $sQuery를 컨트롤러 영역에서 목록을 가져오기 위한 전체 쿼리를 바인딩하고 해당 컨트롤러에서 $sControllerMethod 를 구현한다.
 */
function show_blockpage_count($iTotalCount = 0, $sQuery, $sControllerMethod = 'blockpage_count')
{
	$CI =& get_instance();
	
	if(empty($CI->blockpage->iBlockpageIdx)){$CI->blockpage->iBlockpageIdx = 0;}
	
	$iIdx = $CI->blockpage->iBlockpageIdx++;
	
	if(empty($iTotalCount)){
		$iTotalCount = 0;
	}
	
	$bCallAjax = false;
	// 다음 페이지가 있을 시, 다음페이지가 없다면 blackpage 에서 전체 수량이 계산되어 나옴.
	if($iTotalCount > $CI->blockpage->block_number){
		$bCallAjax = true;
	}
	
	$html = '
		<span class="left-btns-txt '.( ( $bCallAjax ) ?	' hide ' : '' ).'" id="search_blockpage_count'.$iIdx.'">
			총 <b>'.$iTotalCount.'</b> 개
		</span>
		<script type="text/javascript">
		'.(
			( $bCallAjax ) ?	
			('
				$(document).ready(function() {
					var param_blockpage_count'.$iIdx.' = "'.$sQuery.'";
					if(param_blockpage_count'.$iIdx.' && $("#search_blockpage_count'.$iIdx.'").length == 1){
						$.ajax({
							type: "get",
							url: "./'.$sControllerMethod.'",
							data: "param="+param_blockpage_count'.$iIdx.',
							dataType : "json",
							success: function(obj){
								if(obj){
									$("#search_blockpage_count'.$iIdx.'").removeClass("hide");
									$("#search_blockpage_count'.$iIdx.' b").html(comma(obj.cnt));
								}
							}
						});
					}
				});
				'
			):(		// else
				''
			)
		).'
		</script>
	';
	
	echo $html;
}
?>
