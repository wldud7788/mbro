<?php /* Template_ 2.2.6 2022/01/21 12:54:33 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/broadcast/schedule.html 000010712 */ 
$TPL_lives_1=empty($TPL_VAR["lives"])||!is_array($TPL_VAR["lives"])?0:count($TPL_VAR["lives"]);
$TPL_vods_1=empty($TPL_VAR["vods"])||!is_array($TPL_VAR["vods"])?0:count($TPL_VAR["vods"]);
$TPL_calendar_1=empty($TPL_VAR["calendar"])||!is_array($TPL_VAR["calendar"])?0:count($TPL_VAR["calendar"]);
$TPL_calendar_sch_1=empty($TPL_VAR["calendar_sch"])||!is_array($TPL_VAR["calendar_sch"])?0:count($TPL_VAR["calendar_sch"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "라이브커머스" 페이지 @@
- 파일위치 : [스킨폴더]/broadcast/schedule.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<script>
	$(function(){
		var navSwiper; 
		$(".schedule .nav > li a").on("click", function(e){
			e.preventDefault();
			var idx = $(this).closest("li").index();
			$(this).closest(".nav").find(".on").removeClass("on");
			$(this).addClass("on");
			navSwiper.slideTo( idx-1, 800, false );
			
			if($(this).hasClass('empty')) 
			{
				$(".schedule .nodata_wrap").show();
			}else{
				$(".schedule .nodata_wrap").hide();
			}
		});

		$('.display_slide_class').each(function(){
			if(!$(this).hasClass('set_slide_clear')){
				var display_swiper = new Swiper($(this).find('.goods_display_slide_wrap'), {
					slidesPerView: 'auto',
					grabCursor: true,				
				});
				
				if($(this).closest(".schedule").length) 
				{
					navSwiper = display_swiper
					navSwiper.slideTo( 2, 800, false );				
				}
				
				$(this).addClass('set_slide_clear').on('mousedown touchstart touchmove',function(){
					$('.active_swipe_slide').removeClass('active_swipe_slide');
					$(this).addClass('active_swipe_slide');
				});
			}
		});

		$(".schedule .nav > li:eq(3) a").trigger('click');
	});
</script>

<div class="broadcast">
	<!-- LIVE : 시작 -->	
	<div class="live">
		<h1>LIVE</h1>
		<div class="display_slide_class">
			<div class="goods_display_slide_wrap">
<?php if($TPL_VAR["lives"]){?>
				<ul class="cast_list swiper-wrapper">
<?php if($TPL_lives_1){foreach($TPL_VAR["lives"] as $TPL_V1){?>
					<li class="swiper-slide">
						<div class="cast">
<?php if($TPL_V1["status"]=='create'){?>
							<a href="./player?no=<?php echo $TPL_V1["bs_seq"]?>" target="<?php echo $TPL_V1["link_target"]?>" class="thumb"><img src="<?php echo $TPL_V1["image"]?>"></a>
							<div class="live_expected">
								<div>
									<p class="d_day"><?php echo $TPL_V1["start_date_day"]?></p>
									<p class="d_time"><?php echo $TPL_V1["start_date_hour"]?></p>
								</div>
							</div>
<?php }elseif($TPL_V1["status"]=='live'){?>
							<img src="/data/skin/responsive_ver1_default_gl/images/broadcast/i_live.png" class="live_mode">
							<div class="status"><?php echo $TPL_V1["sumvisitors"]?>명 시청 중</div>
							<a href="./player?no=<?php echo $TPL_V1["bs_seq"]?>" target="<?php echo $TPL_V1["link_target"]?>" class="thumb"><img src="<?php echo $TPL_V1["image"]?>"></a>
<?php }?>
							<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>">
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
							<div class="tit"><a href="./player?no=<?php echo $TPL_V1["bs_seq"]?>" target="<?php echo $TPL_V1["link_target"]?>"><?php echo $TPL_V1["title"]?></a></div>
<?php if($TPL_V1["status"]=='live'){?>
							<span class="view_count"><img src="/data/skin/responsive_ver1_default_gl/images/broadcast/i_view.png"/><?php echo $TPL_V1["sumvisitors"]?></span>
							<span class="like_count"><img src="/data/skin/responsive_ver1_default_gl/images/broadcast/i_heart.png"/><?php echo $TPL_V1["likes"]?></span>
<?php }?>
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
					<div class="mess">LIVE 방송이 없습니다.</div>	
				</div>	
<?php }?>
			</div>
		</div>
	</div>
	<!-- LIVE : 끝 -->	
	
	<!-- 지난 방송 : 시작 -->	
	<div class="prev_live"> 
		<h1>지난 방송<a href="/broadcast/display">더보기 ></a></h1>
		<div class="display_slide_class">
			<div class="goods_display_slide_wrap">
<?php if($TPL_VAR["vods"]){?>
				<ul class="cast_list swiper-wrapper">
<?php if($TPL_vods_1){foreach($TPL_VAR["vods"] as $TPL_V1){?>
					<li class="swiper-slide">
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
	</div>
	<!-- 지난 방송 : 끝 -->	

	<!-- 방송 스케줄 : 시작 -->	
	<div class="schedule">
		<h1>방송 스케줄</h1>	
		<div class="display_slide_class">
			<div class="goods_display_slide_wrap">
				<ul class="nav swiper-wrapper calendar_list">
<?php if($TPL_calendar_1){$TPL_I1=-1;foreach($TPL_VAR["calendar"] as $TPL_V1){$TPL_I1++;?>
					<li class="swiper-slide">
<?php if($TPL_I1== 3){?>
						<a class="calendar today <?php if(!array_key_exists($TPL_V1,$TPL_VAR["calendar_sch"])){?>empty<?php }?>" schdate="<?php echo str_replace('.','',$TPL_V1)?>">
							<p class="d_day"><?php echo $TPL_V1?></p>
							<p class="d_week">오늘</p>
						</a>
<?php }elseif(array_key_exists($TPL_V1,$TPL_VAR["calendar_sch"])){?>
						<a class="calendar" schdate="<?php echo str_replace('.','',$TPL_V1)?>">
							<p class="d_day"><?php echo $TPL_V1?></p>
						</a>
<?php }else{?>
						<a class="calendar empty" schdate="<?php echo str_replace('.','',$TPL_V1)?>">
							<p class="d_day"><?php echo $TPL_V1?></p>
						</a>
<?php }?>
					</li>	
<?php }}?>
				</ul>
			</div>
		</div>

<?php if($TPL_calendar_sch_1){foreach($TPL_VAR["calendar_sch"] as $TPL_K1=>$TPL_V1){?>
		<ul class="cast_list calendarsch hide" schdate="<?php echo str_replace('.','',$TPL_K1)?>">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["status"]=='create'){?>
			<li class="prev_live">
<?php }else{?>
			<li>
<?php }?>
				<ul class="item_wrap">
					<li class="cast">
<?php if($TPL_V2["status"]=='live'){?>
						<img src="/data/skin/responsive_ver1_default_gl/images/broadcast/i_live.png" class="live_mode">
						<div class="status"><?php echo $TPL_V2["sumvisitors"]?>명 시청 중</div>
<?php }elseif($TPL_V2["status"]=='end'){?>
						<div class="status"><?php echo $TPL_V2["real_time"]?></div>
<?php }?>
						<a href="./player?no=<?php echo $TPL_V2["bs_seq"]?>" target="<?php echo $TPL_V1["link_target"]?>"><img src="<?php echo $TPL_V2["image"]?>"></a>
					</li>
					<li class="info_wrap">
						<div class="time"><?php echo $TPL_V2["start_date_hour"]?></div>
						<div class="cast_info">
							<div class="tit"><a href="./player?no=<?php echo $TPL_V2["bs_seq"]?>" target="<?php echo $TPL_V1["link_target"]?>"><?php echo $TPL_V2["title"]?></a></div>
<?php if($TPL_V2["status"]=='end'){?>
							<span class="view_count"><img src="/data/skin/responsive_ver1_default_gl/images/broadcast/i_view.png"/><?php echo $TPL_V2["sumvisitors"]?></span>
							<span class="like_count"><img src="/data/skin/responsive_ver1_default_gl/images/broadcast/i_heart.png"/><?php echo $TPL_V2["likes"]?></span>
<?php }elseif($TPL_V2["status"]=='live'){?>
							<div class="like_count"><img src="/data/skin/responsive_ver1_default_gl/images/broadcast/i_heart.png"/><?php echo $TPL_V2["likes"]?></div>
<?php }?>
<?php if(serviceLimit('H_AD')){?>
							<div class="brand"><?php echo $TPL_V2["provider_name"]?></div>
<?php }?>
						</div>
						<a href="/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>">
						<ul class="product">
							<li><div><img src="<?php echo $TPL_V2["goods_img"]?>"></div></li>
							<li class="prod_info">
								<div class="tit"><?php echo $TPL_V2["goods_name"]?></div>
								<div class="price">
<?php if($TPL_V2["sale_rate"]> 0){?>
									<span class="percent"><?php echo $TPL_V2["sale_rate"]?>%</span>
<?php }?>
									<?php echo $TPL_V2["goods_price"]?>

								</div>
							</li>
						</ul>
						</a>
					</li>
				</ul>				
			</li>
<?php }}?>
		</ul>
<?php }}?>

		<div class="nodata_wrap hide">		
			<img src="/data/skin/responsive_ver1_default_gl/images/broadcast/i_nodata.png">
			<div class="mess">예약된 방송이 없습니다.</div>	
		</div>
	</div>
	<!-- 방송 스케줄 : 끝 -->	
</div>