<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_set_extra_navigation_list.html 000001091 */ 
$TPL_target_list_1=empty($TPL_VAR["target_list"])||!is_array($TPL_VAR["target_list"])?0:count($TPL_VAR["target_list"]);?>
<?php if($TPL_VAR["target_list"]){?>
<?php if($TPL_target_list_1){foreach($TPL_VAR["target_list"] as $TPL_K1=>$TPL_V1){?>
		<tr>
			<td class="its-td-align center"><input type="checkbox" class="chk" name="code[]" value="<?php echo $TPL_K1?>" /></td>
			<td class="its-td-align center"><?php echo $TPL_V1["title"]?></td>
			<td class="its-td-align center">
<?php if($TPL_V1["node_banner"]!=''){?>
				<span class="btn medium"><button type="button" style="width:500px;" onclick="pop_target_view('navigation', '<?php echo $TPL_K1?>');" >배너 보기 및 수정</button></span>
				<div class="hide" id="banner_view_navigation_<?php echo $TPL_K1?>"><?php echo $TPL_V1["node_banner"]?></div>
<?php }else{?>
				<span class="desc">등록가능</span>
<?php }?>
			</td>
		</tr>
<?php }}?>
<?php }?>