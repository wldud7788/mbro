window.onload=function(){
    // 가로/세로 비율이 다른 썸네일 --> 정사각형으로 커팅
	$('.board_gallery[data-type=type3] .board_thumb').each(function() {
		var img_garo = $(this).width();
		var img_sero = $(this).height();
		if ( img_garo > img_sero ) {
			$(this).closest('.item_img_area').addClass('garo');
		} else if ( img_garo < img_sero ) {
			$(this).closest('.item_img_area').addClass('sero');
		} else {
			$(this).closest('.item_img_area').removeClass('garo sero');
		}
	});

	// 게시판 항목이 하나도 없을 경우 처리
	$('.board_gallery').each(function() {
		var gonx = $(this).find('.board_gallery_li').length;
		if ( gonx < 1 ) {
			$(this).closest('.board_gallery').addClass('board_no_data').text('등록된 게시글이 없습니다.');
		}
	});	
}

$(function(){

	$('#layerPopup').on('scroll touchmove mousewheel', function(event) {
		// 터치무브와 마우스휠 스크롤 방지
		event.preventDefault();
		event.stopPropagation();
		return false;
	})
})

function openPopupSize( selector, size ) {
	if ( window.innerWidth < size ) {
		$(selector).addClass('small_screen');
		$('#view_iframe').height( document.body.clientHeight - 80 );
	} else {
		$('#view_iframe').height( document.body.clientHeight - 126 );
	}
}

function openPopup(path){
	$('body').append('<div id="layerPopup" class="resp_layer_pop gallery_type maxHeight hide"><h4 class="title"></h4><div class="y_scroll_auto"><iframe id="view_iframe" src="'+path+'" scrolling="yes"></iframe></div><a href="javascript:void(0)" class="btn_pop_close" onclick="removeCenterLayer()"></a></div>');

	openPopupSize( '#layerPopup', 1279 );
	$( window ).on('resize', function() {
		openPopupSize( '#layerPopup', 1279 );
	});

	showCenterLayer('#layerPopup');
}


/* responsive table */
function respTable( table_id_class, modify_screen_width ) {
	var orizinTableSource = $( table_id_class ).html();
    if ( $(window).width() < modify_screen_width ) {
        respTableExe( table_id_class );
    }
    $( window ).on('resize', function() {
        if ( $(window).width() < modify_screen_width ) {
            respTableExe( table_id_class );
        } else {
            $( table_id_class ).html( orizinTableSource );
        }
    });
}
function respTableExe( gon ) {
    var newTr = '<tr></tr>';
    $(gon + ' th').each(function() {
        $(gon).prepend(newTr);
    });
    $(gon + ' th').each(function(i) {
        $(gon + '>tbody>tr').eq(i).append( $(gon + ' th').eq(i).removeAttr('colspan') ).append( $(gon + ' td').eq(i).removeAttr('colspan') );
    });
    $(gon +' tr').filter(':not(:has(th))').remove();
    $(gon + ' colgroup>col').filter(':not(:eq(0), :eq(1))').remove();
}
/* //responsive table */

/* responsive layer popup - center align */
function showCenterLayer( selector, option1 ) {
	if ( option1 == 'brother' ) {
		var gon = $(selector).parent().find('.resp_layer_pop');
	} else {
		var gon = $(selector);
	}

	if ( gon.length < 1 )  return false;
	/*
	var popContentScrollHeight = document.body.clientHeight - 60;
	var gon_bg = $('<div class="resp_layer_bg"></div>');

	gon.find('.y_scroll_auto').css( 'max-height', popContentScrollHeight + 'px' );
	gon.find('.y_scroll_auto2').css( 'max-height', (popContentScrollHeight - 63) + 'px' );

	if ( gon.hasClass('maxHeight') && window.innerWidth > 767 ) {
		gon.find('.y_scroll_auto').css( 'max-height', (popContentScrollHeight - 40) + 'px' );
		gon.find('.y_scroll_auto').css( 'min-height', (popContentScrollHeight - 40) + 'px' );
	} else if ( window.innerWidth > 767 ) {
		gon.find('.y_scroll_auto2').css( 'max-height', (popContentScrollHeight - 83) + 'px' );
	}
	*/
	var popContentScrollHeight = document.body.clientHeight - 80;
	var gon_bg = $('<div class="resp_layer_bg"></div>');

	gon.find('.y_scroll_auto').css( 'max-height', popContentScrollHeight + 'px' );
	gon.find('.y_scroll_auto2').css( 'max-height', (popContentScrollHeight - 63) + 'px' );

	if ( gon.hasClass('maxHeight') && window.innerWidth > 767 ) {
		gon.find('.y_scroll_auto').css( 'max-height', (popContentScrollHeight - 40) + 'px' );
		gon.find('.y_scroll_auto').css( 'min-height', (popContentScrollHeight - 40) + 'px' );
	} else if ( window.innerWidth > 767 ) {
		gon.find('.y_scroll_auto2').css( 'max-height', (popContentScrollHeight - 83) + 'px' );
	}

	if ( window.innerWidth > 767 ) {
		gon.css({
			'top': '50%',
			'left': '50%',
			'marginLeft': (gon.outerWidth() / 2) * -1,
			'marginTop': (gon.outerHeight() / 2) * -1
		});
	} else {
		gon.addClass('small_screen');
	}
	$( window ).on('resize', function() {
		if ( window.innerWidth > 767 ) {
			gon.removeClass('small_screen');
			gon.css({
				'top': '50%',
				'left': '50%',
				'marginLeft': (gon.outerWidth() / 2) * -1,
				'marginTop': (gon.outerHeight() / 2) * -1
			});
		} else {
			gon.addClass('small_screen');
		}
	});
	if ( $('.resp_layer_bg').length < 1 ) {
		$('body').append( gon_bg );
	} else if ( option1 != 'inner_layer' ) {
		$('.resp_layer_pop:not(' + selector + ')').addClass('wait_hide');
	}
	
	// Hide 클래스 대소문자 미구분으로 인한 display:none !important 속성 제거
	if(gon.hasClass('hide')) { gon.removeClass('hide'); }
	gon.show();
	$('body').css('overflow', 'hidden');
	return false;
}

function hideCenterLayer( selector, option1 ) {
	if ( selector ) {
		var gon = $(selector);
		gon.hide();
	} else {
		$('.resp_layer_pop').hide();
	}
	if ( option1 != 'inner_layer' ) {
		$('.resp_layer_bg').remove();
		$('body').css('overflow', 'auto');
	}
}

function removeCenterLayer( selector ) {
	var res_layer_num = $('.resp_layer_pop:visible').length;
	if ( res_layer_num > 1 ) {
		$('.resp_layer_pop').removeClass('wait_hide');
	} else {
		$('.resp_layer_bg').remove();
		$('body').css('overflow', 'auto');
	}
	if ( selector ) {
		$(selector).remove();
	} else {
		$('.resp_layer_pop').remove();
	}
}


function showModal( id ) {
	var gon_bg = $('<div class="resp_layer_bg"></div>');
	if ( id ) gon_bg.attr( 'id', id );
	if ( $('.resp_layer_bg').length < 1 ) {
		$('body').append( gon_bg );
	}
	$('body').css('overflow', 'hidden');
	return false;
}
function hideModal() {
	$('.resp_layer_bg').remove();
	$('body').css('overflow', 'auto');
}
/* //responsive layer popup - center align */

/* checkbox, radiobox UI */
function radioCheckUI() {
	$('input[type=radio]:checked').parent('label').addClass('on');
	$('input[type=radio]').on('change', function() {
		if ( $(this).prop('checked') ) {
			$(this).parent('label').siblings('label').removeClass('on');
			$(this).parent('label').addClass('on');
		}
	});
}
/* //checkbox, radiobox UI */

/* 상품이미지 썸네일 변경 */
function goodsThumbModify( selector, before, after ) {
	$( selector + ' img').each(function() {
		var gon = $(this).attr('src');
		$(this).attr( 'src', gon.replace( before, after) );
	});
}
/* //상품이미지 썸네일 변경 */