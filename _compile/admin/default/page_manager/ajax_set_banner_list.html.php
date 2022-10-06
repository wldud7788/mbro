<?php /* Template_ 2.2.6 2022/05/17 12:36:44 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_set_banner_list.html 000001309 */ 
$TPL_target_list_1=empty($TPL_VAR["target_list"])||!is_array($TPL_VAR["target_list"])?0:count($TPL_VAR["target_list"]);?>
<?php if($TPL_VAR["target_list"]){?>
<?php if($TPL_target_list_1){foreach($TPL_VAR["target_list"] as $TPL_K1=>$TPL_V1){?>
<tr>
	<td class="its-td-align center">
		<input type="checkbox" class="chk" name="code[]" value="<?php echo $TPL_K1?>" />
	</td>
	<td class="its-td-align center"><?php echo $TPL_V1["title"]?></td>
	<td class="its-td-align center">
<?php if($TPL_V1["top_html"]){?>
		<span class="btn medium"><button type="button" style="width:500px;" onclick="pop_target_view('<?php echo $TPL_K1?>');" >배너 보기 및 수정</button></span>
		<div class="hide" id="banner_view_<?php echo $TPL_K1?>"><?php echo $TPL_V1["top_html"]?></div>
<?php }else{?>
		<span class="desc">등록가능</span>
<?php }?>
	</td>
</tr>
<?php }}?>
<?php }else{?>
<?php if($TPL_VAR["target_code"]){?>
<tr>
	<td class="its-td-align center" colspan="3">대상이 없습니다.</td>
</tr>
<?php }else{?>
<tr>
	<td class="its-td-align center" colspan="3">대상을 먼저 선택하여 주세요.</td>
</tr>
<?php }?>
<?php }?>