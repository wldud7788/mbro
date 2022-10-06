<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/_modules/display/right_recent_display.html 000001179 */ 
$TPL_dataRightQuicklist_1=empty($TPL_VAR["dataRightQuicklist"])||!is_array($TPL_VAR["dataRightQuicklist"])?0:count($TPL_VAR["dataRightQuicklist"]);?>
<div class="thumb">
<?php if($TPL_VAR["dataRightQuicklist"]){?><ul>
<?php if($TPL_dataRightQuicklist_1){$TPL_I1=-1;foreach($TPL_VAR["dataRightQuicklist"] as $TPL_V1){$TPL_I1++;?>
<?php if(($TPL_I1<($TPL_VAR["sc"]["limit"]* 10))){?>
<?php if(($TPL_I1&&($TPL_I1%$TPL_VAR["sc"]["limit"])== 0)){?></ul><ul><?php }?>
	<li><a href="../goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" class="right_quick_goods"><img src="<?php echo $TPL_V1["image"]?>" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage_list.gif'" alt="<?php echo $TPL_V1["goods_name"]?>"></a><a href="javascript:rightDeleteItem('<?php echo $TPL_VAR["sc"]["ftype"]?>', '<?php echo $TPL_V1["goods_seq"]?>',$(this))" class="btn_delete cover">삭제</a></li>
<?php }?>
<?php }}?>
</ul>
<?php }else{?>
<h2> 최근 본 상품이 없습니다.</h2>
<?php }?>
</div>