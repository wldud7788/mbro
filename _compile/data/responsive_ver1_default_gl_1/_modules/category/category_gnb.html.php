<?php /* Template_ 2.2.6 2022/02/04 15:51:26 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl_1/_modules/category/category_gnb.html 000001728 */ 
$TPL_category_1=empty($TPL_VAR["category"])||!is_array($TPL_VAR["category"])?0:count($TPL_VAR["category"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 카테고리 네비게이션 @@
- 파일위치 : [스킨폴더]/_modules/category/category_gnb.html
- 현재 3뎁스까지 노출 가능
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_category_1){foreach($TPL_VAR["category"] as $TPL_V1){?>
	<li class="categoryDepth1">
		<a class="categoryDepthLink designElement" designelement="category" href="/goods/catalog?code=<?php echo $TPL_V1["category_code"]?>"><em><?php echo $TPL_V1["name"]?></em></a>
<?php if($TPL_V1["childs"]){?>
		<div class="categorySub">
			<div class="categorySubWrap">
				<ul class="categoryDepth2">
<?php if(is_array($TPL_R2=$TPL_V1["childs"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<li class="categorySubDepth">
<?php if($TPL_V2["childs"]){?>
						<ul class="categoryDepth3">
<?php if(is_array($TPL_R3=$TPL_V2["childs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
							<li><a href="/goods/catalog?code=<?php echo $TPL_V3["category_code"]?>"><?php echo $TPL_V3["name"]?></a></li>
<?php }}?>
						</ul>
<?php }?>
						<a href="/goods/catalog?code=<?php echo $TPL_V2["category_code"]?>"><?php echo $TPL_V2["name"]?></a>
					</li>
<?php }}?>
				</ul>
<?php if($TPL_V1["node_banner"]){?>
				<div class="categorySubBanner">
					<?php echo $TPL_V1["node_banner"]?>

				</div>
<?php }?>
			</div>
		</div>
<?php }?>
	</li>
<?php }}?>