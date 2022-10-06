<?php /* Template_ 2.2.6 2021/12/15 17:48:38 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/promotion/event_list.html 000008244 */  $this->include_("showDesignBanner");
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "이벤트 메인" 페이지 @@
- 파일위치 : [스킨폴더]/promotion/event_list.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="search_nav">
	<a class="home" href="../main/index">홈</a>
	<span class="navi_linemap on" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvcHJvbW90aW9uL2V2ZW50X2xpc3QuaHRtbA==" >EVENT</span>
</div>

<!-- "이벤트 메인" 상단 배너 -->
<?php if($TPL_VAR["page_config"]["banner"]["banner_seq"]){?>
<div id="slideBanner_EventMain" class="page_banner_area1 slider_before_loading">
<?php echo showDesignBanner($TPL_VAR["page_config"]["banner"]["banner_seq"],true)?>

</div>
<?php }?>

<!-- 검색필터 영역 -->
<form name="searchForm" id="searchForm" method="get" action="./event">
	<!-- 탭 -->
	<div class="tab_basic size1 Mt30 Mb0">
		<ul>
			<li <?php if($TPL_VAR["sc"]["sc_status"]=='ing'){?>class="on"<?php }?>>
				<label><input type="radio" name="sc_status" value="ing" <?php if($TPL_VAR["sc"]["sc_status"]=='ing'){?>checked<?php }?> /><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvcHJvbW90aW9uL2V2ZW50X2xpc3QuaHRtbA==" >진행중인 이벤트</span></label>
			</li>
<?php if(is_array($TPL_R1=$TPL_VAR["page_config"]["status"]["chk"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<li <?php if($TPL_VAR["sc"]["sc_status"]==$TPL_V1){?>class="on"<?php }?>>
				<label><input type="radio" name="sc_status" value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["sc"]["sc_status"]==$TPL_V1){?>checked<?php }?> /><?php echo $TPL_VAR["page_config"]["status"]["col"][$TPL_V1]?></label>
			</li>
<?php }}?>
		</ul>
	</div>

	<!-- 소팅/검색 -->
	<div class="bbs_top_wrap2">
		<ul>
			<li class="resp_sorting_list">
<?php if(is_array($TPL_R1=$TPL_VAR["page_config"]["search_filter"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1!='event'){?>
					<label <?php if($TPL_VAR["sc"]["sc_filter"]==$TPL_V1){?>class="active"<?php }?>><input type="radio" name="sc_filter" value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["sc"]["sc_filter"]==$TPL_V1){?>checked<?php }?> /><?php echo $TPL_VAR["page_config"]["filter_col"][ 0][$TPL_V1]?></label>
<?php }?>
<?php }}?>
			</li>
<?php if(array_search('event',$TPL_VAR["page_config"]["search_filter"])){?>
			<li class="area_search">
				<input type="text" name="event_name" id="event_name" title="이벤트명" value="<?php echo $TPL_VAR["sc"]["event_name"]?>"/>
				<button type="submit" class="btn_resp size_b"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvcHJvbW90aW9uL2V2ZW50X2xpc3QuaHRtbA==" >검색</span></button>
			</li>
<?php }?>
		</ul>
	</div>
</form>

<!-- 이벤트 목록 -->
<div class="event-list2">
<?php if($TPL_VAR["record"]){?>
	<ul class="event_bnr1">
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
		<li>
<?php if($TPL_V1["gift_seq"]){?>
			<a href="../promotion/gift_view?gift=<?php echo $TPL_V1["gift_seq"]?>">
<?php }elseif($TPL_V1["event_seq"]){?>
			<a href="../promotion/event_view?event=<?php echo $TPL_V1["event_seq"]?>">
<?php }elseif($TPL_V1["joincheck_seq"]){?>
			<a href="../joincheck/joincheck_view?seq=<?php echo $TPL_V1["joincheck_seq"]?>">
<?php }?>
				<div class="event-image-box">
<?php if($TPL_V1["event_banner"]){?>
						<p class="image_event "><img class="event_list_banner" src="/data/event/<?php echo $TPL_V1["event_banner"]?>" alt="" /></p>
<?php }elseif($TPL_V1["joincheck_banner"]){?>
						<p class="image_event "><img class="event_list_banner" src="/data/joincheck/<?php echo $TPL_V1["joincheck_banner"]?>" alt="" /></p>
<?php }else{?>
<?php if($TPL_V1["joincheck_seq"]){?>
						<p class="no_image_event"><img src="/data/skin/responsive_ver1_default_gl/images/design/no_images_stamp.png" alt="출석체크 이벤트" /></p>
<?php }elseif($TPL_V1["gift_seq"]){?>
						<p class="no_image_event"><img src="/data/skin/responsive_ver1_default_gl/images/design/no_images_gift.png" alt="사은품 이벤트" /></p>
<?php }elseif($TPL_V1["event_seq"]){?>
						<p class="no_image_event"><img src="/data/skin/responsive_ver1_default_gl/images/design/no_images_promotion.png" alt="할인/기획전 이벤트" /></p>
<?php }else{?>
						<img class="none" src="/data/skin/responsive_ver1_default_gl/images/design/noimg_thumb.gif" alt="이미지 준비중입니다" />
<?php }?>
<?php }?>
<?php if($TPL_V1["status"]=='close'){?><img class="close-icon" src="/data/icon/event/event_icon01.png" alt="마감임박" /><?php }?>
<?php if($TPL_V1["status"]=='end'){?><img class="end-icon" src="/data/icon/event/event_icon02.png" alt="종료" /><?php }?>
				</div>
				<div class="infobox">
<?php if($TPL_V1["event_introduce_color"]){?>
					<div class="intorduce" style="color:<?php echo $TPL_V1["event_introduce_color"]?>">
<?php }elseif($TPL_V1["joincheck_introduce_color"]){?>
					<div class="intorduce" style="color:<?php echo $TPL_V1["joincheck_introduce_color"]?>">
<?php }else{?>
					<div class="intorduce">
<?php }?>
<?php if($TPL_V1["event_introduce"]){?><?php echo $TPL_V1["event_introduce"]?><?php }elseif($TPL_V1["joincheck_introduce"]){?><?php echo $TPL_V1["joincheck_introduce"]?><?php }else{?><?php echo $TPL_V1["title"]?><?php }?>
					</div>
					<div class="period"><?php echo $TPL_V1["period"]?></div>
<?php if($TPL_V1["event_type"]=='solo'){?>
						<div class="until">남은시간 : <input type="hidden" name="timestamp[]" value="<?php echo $TPL_V1["timestamp"]?>"><span class="until-day countdown"><?php echo $TPL_V1["d_day"]?></span></div>
<?php }?>
<?php if($TPL_V1["status"]=='end'){?>
						<div class="until"><img src="/data/icon/event/event_end.gif"/></div>
<?php }?>
				</div>
			</a>
		</li>
<?php }}?>
	</ul>
<?php }else{?>
	<div class="no_data_area2">이벤트가 없습니다.</div>
<?php }?>
</div>

<!-- 페이징 -->
<div class="paging_navigation">
	<?php echo $TPL_VAR["pagin"]?>

</div>






<script type="text/javascript">
$(document).ready(function(){
	$("input[name='sc_filter'], input[name='sc_status']").on('change',function(){
		$("#event_name").val('');
		$("#searchForm").submit();
	});

	$('.countdown').each(function(key){
		var setTime	= $(this).prev().val();
		count_down(this, setTime);
	});

	// "이벤트 메인" 상단 슬라이드배너 옵션 설정
	$('#slideBanner_EventMain .custom_slider>div').slick('unslick');
	$('#slideBanner_EventMain .custom_slider>div').slick({
		dots: true, // 도트 페이징 사용( true 혹은 false )
		autoplay: true, // 슬라이드 자동( true 혹은 false )
		speed: 1000, // 슬라이딩 모션 속도 ms( 밀리세컨드, ex. 600 == 0.6초 )
		fade: true, // 페이드 모션 사용( 이 부분은 수정하지 마세요 )
		autoplaySpeed: 5000 // autoplay 사용시 슬라이드간 시간 ms( 밀리세컨드, ex. 5000 == 5초 )
	});
});

function count_down(target, setTime){
	var pad	= "00";

	var key = setInterval(function(){
		setTime--;
		if(setTime <= 0){
			$(target).text("00일 00:00:00");
			clearInterval(key);
		}else{
			day		= Math.floor(setTime / 86400);
			day_c	= (setTime - day * 86400) % 86400;
			day_t	= pad.substring(0, pad.length - day.toString().length) + day.toString();

			hour	= Math.floor(day_c / 3600);
			hour_c	= (day_c - hour * 3600) % 3600;
			hour_t	= pad.substring(0, pad.length - hour.toString().length) + hour.toString();

			minit	= Math.floor(hour_c / 60);
			minit_t	= pad.substring(0, pad.length - minit.toString().length) + minit.toString();

			sec		= hour_c % 60;
			sec_t	= pad.substring(0, pad.length - sec.toString().length) + sec.toString();

			$(target).text(day_t + "일 " + hour_t + ":"+ minit_t + ":" + sec_t);
		}

	}, 1000);
}
</script>