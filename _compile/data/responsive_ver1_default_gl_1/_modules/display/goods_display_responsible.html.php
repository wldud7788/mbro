<?php /* Template_ 2.2.6 2022/02/04 15:51:26 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl_1/_modules/display/goods_display_responsible.html 000002701 */ 
$TPL_displayTabsList_1=empty($TPL_VAR["displayTabsList"])||!is_array($TPL_VAR["displayTabsList"])?0:count($TPL_VAR["displayTabsList"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ [반응형] 디스플레이 템플릿 - 격자 반응형 @@
- 파일위치 : [스킨폴더]/_modules/display/goods_display_responsible.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<style>
	.<?php echo $TPL_VAR["display_key"]?> .goods_list li.gl_item{ width:<?php echo $TPL_VAR["goodsImageSize"]["width"]?>px; }
</style>

<?php if(!$TPL_VAR["ajax_call"]){?>
<?php if($TPL_VAR["isRecommend"]){?><h3 class="title_sub1">추천상품</h3><?php }?>
<div id='<?php echo $TPL_VAR["display_key"]?>' class='<?php echo $TPL_VAR["displayClass"]?>' designElement='<?php echo $TPL_VAR["displayElement"]?>' templatePath='<?php echo $TPL_VAR["template_path"]?>' displaySeq='<?php echo $TPL_VAR["display_seq"]?>' page='<?php echo $TPL_VAR["page"]["nowpage"]?>' perpage='<?php echo $TPL_VAR["perpage"]?>' category='<?php echo $TPL_VAR["category_code"]?>' displayStyle='<?php echo $TPL_VAR["style"]?>'>
<?php if($TPL_VAR["title"]){?><div class="res_db_title1"><?php echo $TPL_VAR["title"]?></div><?php }?>
<?php if($TPL_VAR["displayTitle"]){?><div class="res_db_title2"><?php echo $TPL_VAR["displayTitle"]?></div><?php }?>
<?php if(count($TPL_VAR["displayTabsList"])> 1){?>
	<ul class="displayTabContainer displayTabType1">
<?php if($TPL_displayTabsList_1){$TPL_I1=-1;foreach($TPL_VAR["displayTabsList"] as $TPL_V1){$TPL_I1++;?>
			<li <?php if($TPL_I1== 0){?>class="current"<?php }?> style="width:<?php echo  100/count($TPL_VAR["displayTabsList"])?>%"><?php echo $TPL_V1["tab_title"]?></li>
<?php }}?>
	</ul>
<?php }?>
<?php }?>

<?php if($TPL_displayTabsList_1){foreach($TPL_VAR["displayTabsList"] as $TPL_V1){?>
	<div class="<?php echo $TPL_VAR["display_key"]?> display_responsible_class <?php if(count($TPL_VAR["displayTabsList"])> 1||$TPL_VAR["ajax_call"]){?>displayTabContentsContainer displayTabContentsContainerBox<?php }?>">
<?php if($TPL_V1["contents_type"]=='text'){?>
		  <div><?php echo $TPL_V1["tab_contents"]?></div>
<?php }else{?>
		<!-- ------- 상품정보. 파일위치 : /data/design/ ------- -->
<?php $this->print_("goods_list",$TPL_SCP,1);?>

		<!-- ------- //상품정보. ------- -->
<?php }?>
	</div>
<?php }}?>


<?php if(!$TPL_VAR["ajax_call"]){?>
<?php if($TPL_VAR["perpage"]){?>
<?php $this->print_("paging",$TPL_SCP,1);?>

<?php }?>
</div>
<?php }?>