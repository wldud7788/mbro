<?php /* Template_ 2.2.6 2022/01/21 12:32:44 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/broadcast/display.html 000002545 */ 
$TPL_vods_1=empty($TPL_VAR["vods"])||!is_array($TPL_VAR["vods"])?0:count($TPL_VAR["vods"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "라이브커머스-지난방송" 페이지 @@
- 파일위치 : [스킨폴더]/broadcast/display.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div class="broadcast broadcast_list">
	<div class="prev_live">
		<h1>지난방송</h1>
<?php if($TPL_VAR["vods"]){?>
		<ul class="cast_list">	
<?php if($TPL_vods_1){foreach($TPL_VAR["vods"] as $TPL_V1){?>
			<li>
				<div class="cast">
					<div class="status"><?php echo $TPL_V1["real_time"]?></div>
					<a href="./vod?no=<?php echo $TPL_V1["bs_seq"]?>" target="<?php echo $TPL_V1["link_target"]?>" class="thumb"><img src="<?php echo $TPL_V1["image"]?>"></a>
					<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="<?php echo $TPL_V1["link_target"]?>">
						<ul class="product">
							<li><div><img src="<?php echo $TPL_V1["goods_img"]?>"></div></li>
							<li class="prod_info">
								<div class="tit"><?php echo $TPL_V1["goods_name"]?></div>
								<div class="price">
<?php if($TPL_V1["sale_rate"]> 0){?>
									<span class="percent"><?php echo $TPL_V1["sale_rate"]?>%</span>
<?php }?>
									<?php echo $TPL_V1["goods_price"]?>

								</div>
							</li>
						</ul>
					</a>
				</div>
				<div class="cast_info">
					<div class="tit"><a href="./vod?no=<?php echo $TPL_V1["bs_seq"]?>" target="<?php echo $TPL_V1["link_target"]?>"><?php echo $TPL_V1["title"]?></a></div>
					<span class="view_count"><img src="/data/skin/responsive_ver1_default_gl/images/broadcast/i_view.png"/><?php echo $TPL_V1["sumvisitors"]?></span>
					<span class="like_count"><img src="/data/skin/responsive_ver1_default_gl/images/broadcast/i_heart.png"/><?php echo $TPL_V1["likes"]?></span>
<?php if(serviceLimit('H_AD')){?>
					<div class="brand"><?php echo $TPL_V1["provider_name"]?></div>
<?php }?>
				</div>
			</li>
<?php }}?>	
		</ul>
<?php }else{?>	
		<div class="nodata_wrap">		
			<img src="/data/skin/responsive_ver1_default_gl/images/broadcast/i_nodata.png">
			<div class="mess">지난 방송이 없습니다.</div>	
		</div>	
<?php }?>	
	</div>
		
</div>
<?php if($TPL_VAR["vods"]){?>
<div id="pagingDisplay" class="paging_navigation">
	<?php echo $TPL_VAR["paging"]["html"]?>

</div>
<?php }?>