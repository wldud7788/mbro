<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_set_extra_all_navigation_list.html 000000668 */ ?>
<tr>
	<td class="its-td-align center">전체 카테고리 네비게이션</td>
	<td class="its-td-align center">
<?php if($TPL_VAR["node_gnb_banner"]!=''){?>
		<span class="btn medium"><button type="button" style="width:500px;" onclick="pop_target_view('all_navigation');" >배너 보기 및 수정</button></span>
		<div class="hide" id="banner_view_all_navigation"><?php echo $TPL_VAR["node_gnb_banner"]?></div>
<?php }else{?>
		<span class="desc">등록가능</span>
<?php }?>
	</td>
</tr>