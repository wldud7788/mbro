<?php
function showCategoryDepth($category_code, $parents=array(), $return=false)
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
				foreach ($categorys['category_code'] as $code){
					$categorys['category'][] = $CI->categorymodel->one_category_name($code);
				}
			}
		}
		cache_save($cache_item_id, $categorys);
	}
	if ($return) {
		return $categorys;
	}
	echo '<div class="category_depth clearbox">';
	echo '	<ul class="list">';
	echo '		<li class="item"><a href="/main">&nbsp;&nbsp;&nbsp;&nbsp;</a></li>';
	foreach ($parents as $v) {
		echo "		<li class='item'>&gt; {$v}";
		echo "		</li>";
	}
	if ($categorys) {
		foreach ($categorys['category'] as $k => $v) {
			echo "		<li class='item' id='{$categorys['category_code'][$k]}'>&gt; <a href='catalog?code={$categorys['category_code'][$k]}'>{$v}</a>";
			echo "			<div class='sub_menu'></div>";
			echo "		</li>";
		}
	}
	echo '	</ul>';
	echo '</div>';
	if ($categorys) {
		echo "
			<script>
			$('div.category_depth ul li').mouseenter(function(){
				var tag = '';
				var obj = $(this);
				$.getJSON('category?code='+$(this).attr('id'), function(data) {
					if(data && data.length){
						tag += \"<ul class='sub_menu_list'>\";
						for(var i=0;i<data.length;i++){
							tag += \"<li class='sub_item'><a href='catalog?code=\"+data[i].category_code+\"'>\"+data[i].title+\"</a></li>\";
						}
						tag += \"</ul>\";
						obj.find('div.sub_menu').html(tag);

						if($('div.category_depth ul li').is('.selected'))
						{
							$('div.category_depth ul li').removeClass('selected');
						}else{
							obj.addClass('selected')
						}
					}
				});

			}).mouseleave(function(){
				$(this).removeClass('selected');
			});
			</script>
		";
	}
}
?>
