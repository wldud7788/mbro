<?php
function showCategoryLight($category_code, $parents=array(), $return=false)
{
	$CI =& get_instance();
	$cache_item_id = sprintf('category_%s', $category_code);
	$categorys = cache_load($cache_item_id);
	if ($categorys === false) {
		$categorys = array();
		if ($category_code) {
			$CI->load->model('categorymodel');
			$categorys['category_code'] = $CI->categorymodel->split_category($category_code);
			if ($categorys['category_code']) {
				foreach ($categorys['category_code'] as $code) {
					$categorys['category'][] = $CI->categorymodel->one_category_name($code);
				}
			}
		}
		cache_save($cache_item_id, $categorys);
	}
	if ($return) {
		return $categorys;
	}
?>
	<div class="ajaxLineMap search_nav">
		<a class="home" href="/main">홈</a>
		<?
		if ($categorys) {
			foreach ($categorys['category'] as $k => $title) {?>
		<div class="navi_linemap2" catecode="<?=$categorys['category_code'][$k]?>" >
			<span class="selected_cate"><?=$title?></span>
			<ul class="navi_linemap_sub" style="display:none;"></ul>
		</div>
		<?
			}
		}
		?>
	</div>
	<script type="text/javascript">
	$(function() {
		$('.ajaxLineMap .navi_linemap2').on('click', function() {
			var catecode = $(this).attr('catecode');
			var that = $(this).find('.navi_linemap_sub');
			if ( $(that).is(':hidden') ) {
				if($(that).html()){
					$('.ajaxLineMap .navi_linemap_sub').hide();
					$(that).show();
				}else{
					$(that).empty();
					// 데이터 동적 호출
					$.getJSON('category_depth?code='+catecode, function(data) {
						$(data).each(function(idx, val){
							if(val.category_code == catecode){
								$(that).append('<li class="on"><a href="/goods/catalog?code=' + val.category_code + '">' + val.title + '</a></li>');
							}else{
								$(that).append('<li><a href="/goods/catalog?code=' + val.category_code + '">' + val.title + '</a></li>');
							}
						});
						$('.ajaxLineMap .navi_linemap_sub').hide();
						$(that).show();
					});
				}
			} else {
				$(that).hide();
			}
		});
	});
	</script>
<?
}
?>
