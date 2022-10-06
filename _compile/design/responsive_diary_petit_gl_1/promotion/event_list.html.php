<?php /* Template_ 2.2.6 2021/01/08 12:02:11 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/promotion/event_list.html 000010887 */  $this->include_("setTemplatePath","showDesignBanner");
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "이벤트 메인" 페이지 @@
- 파일위치 : [스킨폴더]/promotion/event_list.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="search_nav">
	<a class="home" href="../main/index" hrefOri='Li4vbWFpbi9pbmRleA==' >홈</a>
	<span class="navi_linemap on" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3Byb21vdGlvbi9ldmVudF9saXN0Lmh0bWw=" >EVENT</span>
</div>

<!-- "이벤트 메인" 상단 배너 -->
<?php if($TPL_VAR["page_config"]["banner"]["banner_seq"]){?>
<div id="slideBanner_EventMain" class="page_banner_area1 slider_before_loading">
<?php echo setTemplatePath('promotion/event_list.html')?><?php echo showDesignBanner($TPL_VAR["page_config"]["banner"]["banner_seq"],true)?>

</div>
<?php }?>

<!-- 검색필터 영역 -->
<form name="searchForm" id="searchForm" method="get" action="./event">
	<!-- 탭 -->
	<div class="tab_basic size1 Mt30 Mb0">
		<ul>
			<li <?php if($TPL_VAR["sc"]["sc_status"]=='ing'){?>class="on"<?php }?>>
				<label><input type="radio" name="sc_status" value="ing" <?php if($TPL_VAR["sc"]["sc_status"]=='ing'){?>checked<?php }?> /><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3Byb21vdGlvbi9ldmVudF9saXN0Lmh0bWw=" >진행중인 이벤트</span></label>
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
				<button type="submit" class="btn_resp size_b"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3Byb21vdGlvbi9ldmVudF9saXN0Lmh0bWw=" >검색</span></button>
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
			<a href="../promotion/gift_view?gift=<?php echo $TPL_V1["gift_seq"]?>" hrefOri='Li4vcHJvbW90aW9uL2dpZnRfdmlldz9naWZ0PXsuZ2lmdF9zZXF9' >
<?php }elseif($TPL_V1["event_seq"]){?>
			<a href="../promotion/event_view?event=<?php echo $TPL_V1["event_seq"]?>" hrefOri='Li4vcHJvbW90aW9uL2V2ZW50X3ZpZXc/ZXZlbnQ9ey5ldmVudF9zZXF9' >
<?php }elseif($TPL_V1["joincheck_seq"]){?>
			<a href="../joincheck/joincheck_view?seq=<?php echo $TPL_V1["joincheck_seq"]?>" hrefOri='Li4vam9pbmNoZWNrL2pvaW5jaGVja192aWV3P3NlcT17LmpvaW5jaGVja19zZXF9' >
<?php }?>
				<div class="event-image-box">
<?php if($TPL_V1["event_banner"]){?>
						<p class="image_event "><img class="event_list_banner" src="/data/event/<?php echo $TPL_V1["event_banner"]?>" alt="" designImgSrcOri='L2RhdGEvZXZlbnQvey5ldmVudF9iYW5uZXJ9' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3Byb21vdGlvbi9ldmVudF9saXN0Lmh0bWw=' designImgSrc='L2RhdGEvZXZlbnQvey5ldmVudF9iYW5uZXJ9' designElement='image' /></p>
<?php }elseif($TPL_V1["joincheck_banner"]){?>
						<p class="image_event "><img class="event_list_banner" src="/data/joincheck/<?php echo $TPL_V1["joincheck_banner"]?>" alt="" designImgSrcOri='L2RhdGEvam9pbmNoZWNrL3suam9pbmNoZWNrX2Jhbm5lcn0=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3Byb21vdGlvbi9ldmVudF9saXN0Lmh0bWw=' designImgSrc='L2RhdGEvam9pbmNoZWNrL3suam9pbmNoZWNrX2Jhbm5lcn0=' designElement='image' /></p>
<?php }else{?>
<?php if($TPL_V1["joincheck_seq"]){?>
						<p class="no_image_event"><img src="/data/skin/responsive_diary_petit_gl_1/images/design/no_images_stamp.png" alt="출석체크 이벤트" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9ub19pbWFnZXNfc3RhbXAucG5n' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3Byb21vdGlvbi9ldmVudF9saXN0Lmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2Rlc2lnbi9ub19pbWFnZXNfc3RhbXAucG5n' designElement='image' /></p>
<?php }elseif($TPL_V1["gift_seq"]){?>
						<p class="no_image_event"><img src="/data/skin/responsive_diary_petit_gl_1/images/design/no_images_gift.png" alt="사은품 이벤트" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9ub19pbWFnZXNfZ2lmdC5wbmc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3Byb21vdGlvbi9ldmVudF9saXN0Lmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2Rlc2lnbi9ub19pbWFnZXNfZ2lmdC5wbmc=' designElement='image' /></p>
<?php }elseif($TPL_V1["event_seq"]){?>
						<p class="no_image_event"><img src="/data/skin/responsive_diary_petit_gl_1/images/design/no_images_promotion.png" alt="할인/기획전 이벤트" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9ub19pbWFnZXNfcHJvbW90aW9uLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3Byb21vdGlvbi9ldmVudF9saXN0Lmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2Rlc2lnbi9ub19pbWFnZXNfcHJvbW90aW9uLnBuZw==' designElement='image' /></p>
<?php }else{?>
						<img class="none" src="/data/skin/responsive_diary_petit_gl_1/images/design/noimg_thumb.gif" alt="이미지 준비중입니다" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9ub2ltZ190aHVtYi5naWY=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3Byb21vdGlvbi9ldmVudF9saXN0Lmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2Rlc2lnbi9ub2ltZ190aHVtYi5naWY=' designElement='image' />
<?php }?>
<?php }?>
<?php if($TPL_V1["status"]=='close'){?><img class="close-icon" src="/data/icon/event/event_icon01.png" alt="마감임박" designImgSrcOri='L2RhdGEvaWNvbi9ldmVudC9ldmVudF9pY29uMDEucG5n' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3Byb21vdGlvbi9ldmVudF9saXN0Lmh0bWw=' designImgSrc='L2RhdGEvaWNvbi9ldmVudC9ldmVudF9pY29uMDEucG5n' designElement='image' /><?php }?>
<?php if($TPL_V1["status"]=='end'){?><img class="end-icon" src="/data/icon/event/event_icon02.png" alt="종료" designImgSrcOri='L2RhdGEvaWNvbi9ldmVudC9ldmVudF9pY29uMDIucG5n' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3Byb21vdGlvbi9ldmVudF9saXN0Lmh0bWw=' designImgSrc='L2RhdGEvaWNvbi9ldmVudC9ldmVudF9pY29uMDIucG5n' designElement='image' /><?php }?>
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
						<div class="until"><img src="/data/icon/event/event_end.gif" designImgSrcOri='L2RhdGEvaWNvbi9ldmVudC9ldmVudF9lbmQuZ2lm' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3Byb21vdGlvbi9ldmVudF9saXN0Lmh0bWw=' designImgSrc='L2RhdGEvaWNvbi9ldmVudC9ldmVudF9lbmQuZ2lm' designElement='image' /></div>
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