<?php /* Template_ 2.2.6 2021/12/15 17:48:36 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/_modules/brand/all_navigation.html 000002009 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 전체 브랜드 @@
- 파일위치 : [스킨폴더]/_modules/brand/all_navigation.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="all_list_contents">
	<h2 class="all_list_title"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvX21vZHVsZXMvYnJhbmQvYWxsX25hdmlnYXRpb24uaHRtbA==" >ALL BRAND</span></h2>
<?php if(is_array($TPL_R1=array_chunk($TPL_VAR["categoryData"], 99,true))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	<ul class="all_list_depth1">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
		<li>
			<a href="/goods/brand?code=<?php echo $TPL_V2["category_code"]?>"><?php echo $TPL_V2["title"]?></a>
<?php if($TPL_V2["childs"]){?>
			<ul class="all_list_depth2">
<?php if(is_array($TPL_R3=$TPL_V2["childs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
				<li>
					<a href="/goods/brand?code=<?php echo $TPL_V3["category_code"]?>"><?php echo $TPL_V3["title"]?></a>
<?php if($TPL_V3["childs"]){?>
					<ul class="all_list_depth3">
<?php if(is_array($TPL_R4=$TPL_V3["childs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
						<li>
							<a href="/goods/brand?code=<?php echo $TPL_V4["category_code"]?>"><?php echo $TPL_V4["title"]?></a>
						</li>
<?php }}?>
					</ul>
<?php }?>
				</li>
<?php }}?>
			</ul>
<?php }?>
		</li>
<?php }}?>
	</ul>
<?php }}else{?>
	<div class="nodata">설정된 브랜드 메뉴가 없습니다.</div>
<?php }?>

<?php if($TPL_VAR["category_gnb_banner"]){?>
	<div class="all_list_banner">
		<?php echo $TPL_VAR["category_gnb_banner"]?>

	</div>
<?php }?>
	<a href="javascript:void(0)" class="brandAllClose all_list_close">닫기</a>
</div>
<!-- //브랜드 전체보기 -->