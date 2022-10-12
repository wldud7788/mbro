$(function(){

	// 사이드 여닫기
	$("#layout_header a[href='#category'], #layout_side_background, #side_close").click(function(){side_menu_onoff();});

	// 하단퀵메뉴
	$(document)
	.bind('scroll',function(){
		if($(window).height()<$("#quick_layer").height()*3 || ($(document).height()-10 > $(window).height() && $(document).scrollTop()+$(window).height() >= $(document).height()-10)){
			$("#quick_layer").hide();
		}else{
			if(!layout_side_opened) $("#quick_layer").show();
		}
	}).trigger('scroll');
	$(window).resize(function(){$(document).scroll();});

	// 탭버튼스타일의 radio,checkbox
	$(".radio_tab_wrapper input[type='radio'], .radio_tab_wrapper input[type='checkbox']").change(function(){
		$("input[type='radio'], .radio_tab_wrapper input[type='checkbox']",$(this).closest('.radio_tab_wrapper')).each(function(){
			if($(this).is(":checked")){
				$(this).closest('td').addClass('checked');
			}else{
				$(this).closest('td').removeClass('checked');
			}
		});
	});

	$("button.btn_cancel_tab1").click(function(){
		$("input[type='checkbox'], .ctg_list_sub input[type='checkbox']",$(this).parents().find(".ctg_list_sub")).each(function(){
			if($(this).is(":checked")){
				$(this).attr("checked",false).trigger('change');
			}
		});
	});

	$("button.btn_cancel_tab2").click(function(){
		$("input[type='text']",$(this).parents().find(".ctg_result_sub")).each(function(){
			$(this).val('');
			$(this).attr('placeholder','');
		});
	});

	$(".goodsSearchKeybtn").click(function(){
		$("#goodsTopSearchForm input[name='insearch']").val('1');
	});

	/* 탭형식 공통사용 */
	$(".sub_page_tab_wrap").each(function(){
		var wrapObj = this;
		$(".sub_page_tab td",wrapObj).each(function(i){
			$(this).click(function(){
				$(".sub_page_tab td",wrapObj).removeClass("current");
				$(this).addClass("current");
				$(".sub_page_tab_contents",wrapObj).hide().eq(i).show();
			});
		}).eq(0).click();
	});

	// 서브 영역 열기/닫기
	$(".sub_division_title").live('click',function(){
		var contentsObj = $(this).closest('.sub_division_title').next('.sub_division_contents'),
			 summaryObj = $(this).parent().find('.sub_division_title_summary');
		if(!contentsObj.is(":hidden")){
			$(this).children(".sub_division_arw").addClass('closed');
			contentsObj.hide();
			summaryObj.show();
		}else{
			$(this).children(".sub_division_arw").removeClass('closed');
			contentsObj.show();
			summaryObj.hide();
		}
		typeof area_close_chk == 'function' && area_close_chk(); // 각 레이어별 닫힘 체크 :: 2017-05-29 lwh
	});

	//결제페이지의 사은품영역 서브 영역 열기/닫기
	$(".sub_division_title_gift").live('click',function(){
		var contentsObj = $(this).parent().closest('.sub_division_title').next('.sub_division_contents');
		if(!contentsObj.is(":hidden")){
			$(this).children("sub_division_arw_gift").addClass('closed');
			contentsObj.hide();
		}else{
			$(this).children("sub_division_arw_gift").removeClass('closed');
			contentsObj.show();
		}
	});

	/* 상품디스플레이 탭 스크립트 */
	$('.displayTabContainer>li').on('click', function() {
		$(this).closest('.displayTabContainer').find('li').removeClass('current');
		$(this).addClass('current');
	});
	$('[designelement=display]').each(function() {
		$(this).find('.displayTabContentsContainer:first').show();
	});
	// 카테고리 추천상품에 탭인 경우
	$('[designelement=categoryRecommendDisplay]').each(function() {
		$(this).find('.displayTabContentsContainer:first').show();
	});

	/* 상품리스트 - 카테고리(슬라이딩 메뉴) */
	$(".ctg_category").click(function(){
		$(this).parent().parent().parent().nextAll().slideToggle().siblings("#ctg_category");
		$("#ctg_category").css("max-height","70%");
		$("#ctg_brand").hide();
		$("#ctg_search").hide();
		$("#ctg_sort").hide();
		$(".ctg_bg").fadeIn();
		$("html").attr("class","overflow");
	});
	$("#ctg_category .ctg_close").click(function(){
		$(this).parent().parent().slideToggle().siblings("#ctg_category");
		$(".ctg_bg").fadeOut();
		$("html").attr("class","auto");
	});

	/* 상품리스트 - 브랜드(슬라이딩 메뉴) */
	$(".ctg_brand").click(function(){
		$(this).parent().parent().parent().nextAll().slideToggle().siblings("#ctg_brand");
		$("#ctg_category").hide();
		$("#ctg_brand").css("max-height","70%");
		$("#ctg_search").hide();
		$("#ctg_sort").hide();
		$(".ctg_bg").fadeIn();
		$("html").attr("class","overflow");
	});

	$("#ctg_brand .ctg_close").click(function(){
		$(this).parent().parent().slideToggle().siblings("#ctg_brand");
		$(".ctg_bg").fadeOut();
		$("html").attr("class","auto");
	});

	/* 상품리스트 - 상세검색(슬라이딩 메뉴) */
	$(".ctg_search").click(function(){
		$(this).parent().parent().parent().nextAll().slideToggle().siblings("#ctg_search");
		$("#ctg_category").hide();
		$("#ctg_search").css("max-height","70%");
		$("#ctg_brand").hide();
		$("#ctg_sort").hide();
		$(".ctg_bg").fadeIn();
		$("html").attr("class","overflow");
	});
	$("#ctg_search .ctg_close").click(function(){
		$(this).parent().parent().slideToggle().siblings("#ctg_search");
		$(".ctg_bg").fadeOut();
		$("html").attr("class","auto");
	});

	/* 상품리스트 - 정렬(슬라이딩 메뉴) */
	$(".ctg_sort").click(function(){
		$(this).parent().parent().parent().nextAll().slideToggle().siblings("#ctg_sort");
		$("#ctg_category").hide();
		$("#ctg_brand").hide();
		$("#ctg_search").hide();
		$("#ctg_sort").css("max-height","70%");
		$(".ctg_bg").fadeIn();
		$("html").attr("class","overflow");
	});
	$("#ctg_sort .ctg_close").click(function(){
		$(this).parent().parent().slideToggle().siblings("#ctg_sort");
		$(".ctg_bg").fadeOut();
		$("html").attr("class","auto");
	});

	/* 상품리스트 - 백그라운드 */
	$(".ctg_bg").click(function(){
		$(".ctg_wrap").fadeOut();
		$(".ctg_bg").fadeOut();
		$("html").attr("class","auto");
	});

	/* 상품리스트 - 스와이프 안내 */
	$(".swipe_close, .swipe_bg").click(function(){
		$(".swipe_guide").hide();
	});

	/* 상품댓글 - SNS 공유(레이어) */
	$("#cmt_sns_btn").live('click',function(){
		$(".cmt_sns_pop").fadeIn();
		$(".sns_bg").fadeIn();
		$("html").attr("class","overflow").bind('touchmove', function(e){e.preventDefault()});
	});
	/* 상품상세 - SNS 공유(레이어) */
	$("#sns_btn").click(function(){
		$(".sns_pop").fadeIn();
		$(".sns_bg").fadeIn();
		$("html").attr("class","overflow").bind('touchmove', function(e){e.preventDefault()});
	});
	$(".sns_close, .sns_bg").live('click', function(){
		$(".sns_pop").fadeOut();
		$(".cmt_sns_pop").fadeOut();
		$(".sns_bg").fadeOut();
		$("html").attr("class","auto").unbind('touchmove');
	});


	/* 플로팅 - BACK/TOP(대쉬보드) */
	$(document).bind("scroll resize", function(){
		var scrollTop = parseInt($(document).scrollTop());
		if(scrollTop > 0){
			$("#floating_over").fadeIn();
		}else{
			$("#floating_over").fadeOut();
		}
	});
	$("#floating_over .ico_floating_recently").click(function(){
		$("#recently_popup").fadeIn();
		$(".recently_bg").fadeIn();
		$("html").attr("class","overflow").bind('touchmove', function(e){e.preventDefault()});
	});
	$("#floating_over .recently_popup .btn_close").click(function(){
		$("#recently_popup").fadeOut();
		$(".recently_bg").fadeOut();
		$("html").attr("class","auto").unbind('touchmove');
	});

});

//최근본상품 삭제시 새로적용
function getfloatingrecentlydata(ftype, floatingid, act, totalcnt){
	var limit = ( floatingid == "recently_slide_bottom" )?4:3;
	if( act == "del" ) $("#"+floatingid).parents().find(".recently_page").html('<a href="javascript:;" class="btn_page cover">선택</a>');
	$.ajax({
		'async' : false,
		'url' : '/common/get_right_display',
		'type' : 'GET',
		'data' : "type=right_item_recent&limit="+limit+"&ftype="+ftype,
		'success' : function(html){
			$("#"+floatingid).html(html);
			if( limit < totalcnt ) {
				$("#"+floatingid).touchSlider({
					flexible:true, roll:true, paging:$("#"+floatingid).next().find(".btn_page"),
					initComplete:function(e){$("#"+floatingid).next().find(".btn_page").each(function(i, el){$(this).text("page " + (i+1));});},
					counter:function(e){$("#"+floatingid).next().find(".btn_page").removeClass("on").eq(e.current-1).addClass("on");}
				});
			}
		}
	});
}

var layout_side_opened = false;
function side_menu_onoff(){
	//$("#layout_side").css('min-height', $(window).height());
	var tHeight		= $("#layout_wrap").height();
	var sHeight		= $("#layout_side").height();
	//if	(tHeight > sHeight) $("#layout_side").css('height', tHeight+'px');
	if(tHeight > sHeight) $("#layout_wrap").css('height', sHeight+'px');

	// 열기
	if	(!layout_side_opened){
		layout_side_opened = true;
		var orgWidth	= $("#layout_side").width();
		var headerWidth	= $("#layout_header").width() - orgWidth;
		$("#layout_side").css("left", orgWidth*-1 + 'px');
		$('a[href=#category]').addClass('on');
		if($("#layout_side").html()==''){
			$.ajax({
				'url' : '/common/ajax_mobile_layout_side',
				'async':true,
				'cache':false,
				'success' : function(res){
					$("#layout_side").html(res);
					$('#side_close').addClass('on');
				}
			});
		}
		$("#quick_layer").hide();
		$("#layout_side").show().animate({left:0}, 600, function(){
			//$("#layout_header").css('left', orgWidth+'px');
			$("#layout_wrap").css({'position' : 'absolute', 'width':'100%'});
			if($("body").find(".designPopupBandMobile").css("display") == 'block')
					$("#side_close").css("top","-60px");
			else	$("#side_close").css("top","0");
			$('html, body').css({'overflow' : 'hidden'});
		});
		$('#side_close').addClass('on');
		$("#layout_side_background").fadeIn();
		//$(".designPopupBandMobile").hide();

	// 닫기
	}else{
		layout_side_opened = false;
		$("#layout_wrap").css({'position' : 'relative', 'width':'auto'});
		var orgWidth	= $("#layout_side").width();
		var headerWidth	= $("#layout_header").width() + orgWidth;
		//$("#layout_header").css('left', '0px');
		$("#layout_side").animate({left:orgWidth*-1}, 300, function(){
			$("#layout_side").hide();
			$("#layout_side_background").fadeOut();
			$("#quick_layer").show();
			$('html, body').css({'overflow' : 'visible'});
		});
		$('#side_close').removeClass('on');
		setTimeout(function(){ $('a[href=#category]').removeClass('on'); }, 800);
		//$(".designPopupBandMobile").show();
	}
}
