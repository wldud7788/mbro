var alert_timer = null;
function resp_search_ui() {
	// 검색필터 항목 하나도 없을때 UI처리 추가 190121 - sjg
	var searchFilterLength = $('#searchFilter>li').length;
	if ( searchFilterLength == 0 ) {
		$('#searchFilter').addClass('no_filter');
	}

	/* PC/MOBILE 분기해서 처리해야할 스크립트 */
	if ( window.innerWidth > 1023 ) { // ++++ PC형 ++++
		// PC init
		$('#searchFilter').show();
		$('#searchFilter .menuThebogi').removeClass('xxx opend');
		$('#searchFilter .filter_detail_item').removeClass('opend');
		$('#searchFilter .filter_section_sorting').hide();
		$('#searchFilter .filter_detail_area').show();
		$('#filteredItemSorting .item_order .list').show();

		// 항목 더보기(+) 노출
		setTimeout(function(){
			$('#searchFilter .menuThebogi').each(function() {
				var filterDetailHeight = $(this).closest('.filter_section').find('.filter_detail_item').prop('scrollHeight');
				if ( filterDetailHeight < 51 ) {
					$(this).addClass('xxx');
				} else { 
                    $(this).removeClass('xxx');
                }
			});
		}, 200);
	} else { // ++++ MOBILE형 ++++
		// MOBILE init
		$('#searchFilter').hide();
		$('#searchFilter .filter_section_sorting').show();
		$('#btnFilterOpen').removeClass('opened');
		$('#searchFilter .filter_detail_area').hide();
		$('#searchFilter .filter_menu_area.on + .filter_detail_area').show();
		$('#filteredItemSorting .item_order .list').hide();

		// 메뉴가 3개인 경우( 미니샵 )
		var filterMenuNum = $('#searchFilter>li').length;
		$('#searchFilter').addClass('devide' + filterMenuNum);

		// [Mobile] 필터 선택된 영역 scroll 위치
		mobileFilterSelectedScroll();
		var mo_f_s_s_click_item = '#searchFilter .filter_detail_item a[data-searchname], #searchFilter .filter_detail_item label[data-searchname]>input, #searchFilter #reSearchApply, #searchFilter #priceApply';
		$( mo_f_s_s_click_item ).on('click', function() {
			setTimeout(function(){ mobileFilterSelectedScroll(); }, 20);
		});

		// 검색된 아이템 정렬
		$('#filteredItemSorting .now_sorting_state').on('click', function() {
			if ( $(this).hasClass('on') ) {
				$(this).removeClass('on');
				$(this).next('ul.list').hide();
			} else {
				$(this).addClass('on');
				$(this).next('ul.list').show();
			}
			return false;
		});
	}
}


$(function() {

/* +++++++++++++++++++++++ 검색 입력창 ++++++++++++++++++++++++ */
	// 검색 섹션 열기
	$('#btnSearchV2').on('click', function() {
		$('#recentArea').show();
		$('#searchVer2').addClass('on');
		$('#autoCompleteArea').hide();
	});

	// 검색 섹션 닫기
	$('.searchModuleClose').on('click', function() {
		$('#searchVer2InputBox').val('');
		$('#searchVer2').removeClass('on');
		$('#searchModule .contetns_area').hide();
		//searchAutoCompleteSlider.destroySlider(); // bx슬라이더 멈추면 좋은데 콘솔 에러뜸.
	});

	// 탭 컨텐츠( 최근 검색어, 최근본 상품 )
	$('.tab_btns>li>a').on('click', function() {
		$(this).closest('.tab_btns').children('li').removeClass('on');
		$(this).parent('li').addClass('on');
		$(this).closest('.tab_btns').parent().find('.tab_contents').hide();
		$(this.hash).show();
		return false;
	});

	// 최근 검색어, 검색어 자동완성 클릭시 -> 검색어 텍스트 입력
	$('#searchVer2 .searched_item').on('click', function() {
		$('#searchVer2InputBox').val( $(this).text() ).focus();
		$("form#topSearchForm").submit();
	});

	// 자동 저장 - 끄기/켜기 UI
	$('#searchVer2 .btnRecentAuto').on('click', function() {
		setRecentAuto('toggle');
	});

	// 자동 완성 - 끄기/켜기 UI
	$('#searchVer2 .btnAutoComplete').on('click', function() {
		$('#searchVer2 .btnAutoComplete').hide();
		if ( $(this).hasClass('off') ) {
			$('#searchVer2 .btnAutoComplete.on').show();
			$('#autoCompleteList').hide();
			$('#autoCompleteGuide').show();
		} else {
			$('#searchVer2 .btnAutoComplete.off').show();
			$('#autoCompleteList').show();
			$('#autoCompleteGuide').hide();
		}
	});

	// 검색 입력 박스 focus
	$('#searchVer2InputBox').on('focus', function() {
		if ( $('#searchModule .contetns_area').is(':hidden') ) {
			$('#searchModule .contetns_area').show();
		}
		if ( $(this).val() == '' ) {
			$('#recentArea').show();
			$('#autoCompleteArea').hide();
		}
	});

	// 검색 입력 박스 keyup -> 자동 완성 영역 노출, 추천상품 노출
	var searchAutoCompleteSlider = '';
	$('#searchVer2InputBox').on('keyup', function() {
		var _this = this;
		if ( $(_this).val() == '' ) {
			$('#recentArea').show();
			$('#autoCompleteArea').hide();
		} else {
			$('#recentArea').hide();
			$('#autoCompleteArea').show();
			clearTimeout(_this.__AutoCompleteTimer);
			_this.__AutoCompleteTimer = setTimeout(function() { showAutoComplete($(_this).val()); }, 300);
		}
	});
	$('#searchVer2InputBox').on('blur', function() {
		if ( $(this).val() == '' ) {
			$('#searchVer2, #recentArea').show();
			$('#autoCompleteArea').hide();
			//searchAutoCompleteSlider.destroySlider(); // bx슬라이더 멈추면 좋은데 콘솔 에러뜸.
		}
	});

	// 자동 저장 - 끄기/켜기 UI
	$('#autoCompleteArea .btnAutoComplete').on('click', function() {
		setUseAuto('toggle');
	});
/* +++++++++++++++++++++++ //검색 입력창 ++++++++++++++++++++++++ */



/* +++++++++++++++++++++++ 검색 결과 필터 ++++++++++++++++++++++++ */

	resp_search_ui();
	$( window ).on('resize', function() {
		if ( window.innerWidth != WINDOWWIDTH ) {
			resp_search_ui();
		}
	});
	$('#btnFilterOpen').click(function() {
		if ( $(this).hasClass('opened') ) {
			$(this).removeClass('opened');
			$('#searchFilter').hide();
		} else {
			$(this).addClass('opened');
			$('#searchFilter').show();
		}
		return false;
	});


	// 상품수/가나다 클릭 UI
	$('#searchFilter .filter_section_sorting input[type=radio]').on('click', function() {
		$(this).closest('.filter_section_sorting').find('label').removeClass('active');
		$(this).parent('label').addClass('active');
	});

	// 필터 선택 영역 - 가격
	$('#searchFilter #priceApply').on('click', function() {
		setFilterPrice($(this), false);
	});

	// 필터 선택 영역 - 재검색
	$('#searchFilter #reSearchApply').on('click', function() {
		setFilterReSearch($(this), false);
	});

	// 선택된 필터 영역
	$('#searchFilterSelected').on('click', 'a.remove', function() {
		// 페이지별 필수 항복 제어
		var bRequireErr = false;
		var sType		= $(this).closest('li').data('type');
		var filteritem		= $(this).closest('li').data('filteritem');
		var sSearchMode	= $("input[name='searchMode']").val();
		if(sSearchMode == 'catalog' && sType =='category'){
			bRequireErr = true;
		}
		if(sSearchMode == 'brand' && sType =='brand' ){
			bRequireErr = true;
		}
		if(sSearchMode == 'location' && sType =='location'){
			bRequireErr = true;
		}
		if(sSearchMode == 'mshop' && sType =='provider'){
			bRequireErr = true;
		}
		if(bRequireErr){
			return false;
		}
		// 필터 선택된 항목 제어
		$(this).closest('li').remove();
		switch ( $(this).closest('li').data('filtertype') ) {
			case 'checkbox' : // 브랜드, 배송, 컬러
				$('#searchFilter [data-searchname=' + filteritem + '] input[type=checkbox]').prop( 'checked', false );
				$('#searchFilter [data-searchname=' + filteritem + ']').removeClass('active');
				break;
			case 'price' : // 가격
				if ( filteritem == 'min_price' ) {
					$('#searchFilter [data-searchname=min_price]').val('');
				}
				if ( filteritem == 'max_price' ) {
					$('#searchFilter [data-searchname=max_price]').val('');
				}
				break;
			case 'category' : // 카테고리
				$('#searchFilter [data-searchname=' + filteritem + ']').removeClass('active');
				$(".category_all_nav a[data-searchname='all']").click();
				break;
			case 'location' : // 지역
				$('#searchFilter [data-searchname=' + filteritem + ']').removeClass('active');
				$(".location_all_nav a[data-searchname='all']").click();
				break;
			case 'provider' : // 판매자
				$('#searchFilter [data-searchname=' + filteritem + ']').removeClass('active');
				break;
			case 're_search' : // 재검색
				$('#searchFilter [data-searchname=re_search]').val('');
				break;
			default :
				alert( '아직 정의하지 않은 타입' );
				break;
		}
		goodsSearch();
		return false;
	});

	// 검색필터 입력박스 Enter Keydown
	$('#searchFilter input[type=text].input_sfilter').keydown(function(key) {
		if(key.keyCode == 13) { // Enter
			$(this).closest('li').find('button.btn_sfilter').click();
		}
	});

	// 필터내의 브랜드 정렬 변경
	$("input[name='sorting-brand']").bind("change", function(){
		filterSort($(this).val(), 'brandList');
	});

	// 필터내의 판매자 정렬 변경
	$("input[name='sorting-seller']").bind("change", function(){
		filterSort($(this).val(), 'sellerList');
	});

	// 필터내의 판매자 정렬 변경
	$("#filteredItemSorting li.item_order ul.list li label input").bind("change", function(){
		$("#filteredItemSorting li.item_order ul.list li label").removeClass("active");
		$(this).parent().addClass("active");
		goodsSearch();
	});

	// 상품 리스팅 숫자 변경
	$("form#goodsSearchForm ul li select[name='per']").bind("change",function(){
		$("form#goodsSearchForm input[name='page']").val('1');
		goodsSearch();
	});

	// 190218 모바일에서 소팅 추가
	$('#mobileSortingSelected').text( $('#mobileSortingSelected + .list label.active').text() );
	$('#mobileSortingSelected').on('click', function() {
		if ( $(this).hasClass('on') ) {
			$(this).removeClass('on');
			$(this).next('.list').hide();
		} else {
			$(this).addClass('on');
			$(this).next('.list').show();
		}
	});
	$('#mobileSortingSelected + .list label').on('click', function() {
		var selected_text = $(this).text();
		$('#mobileSortingSelected').removeClass('on').text( selected_text );
		if ( $('#mobileSortingSelected').is(':visible') ) {
			$(this).closest('.list').hide();
		}
	});

	// 항목 더보기(+) 클릭
	$('#searchFilter .menuThebogi').on('click', function() {
		var winW = $(window).width();

        if (winW > 1023){
            // PC 관련 스크립트
            if ( $(this).hasClass('xxx') === false) {
                if ( $(this).hasClass('opend') === true) {
                    $(this).removeClass('opend');
                    $(this).closest('.filter_section').find('.filter_detail_item').removeClass('opend');
                    $(this).closest('.filter_section').find('.filter_section_sorting').hide(); // 상품수/가나다
                } else {
                    $(this).addClass('opend');
                    $(this).closest('.filter_section').find('.filter_detail_item').addClass('opend');
                    $(this).closest('.filter_section').find('.filter_section_sorting').show(); // 상품수/가나다
                }
            }
        } else {
            // 모바일 관련 스크립트
            $('#searchFilter .filter_menu_area').removeClass('on');
            $('#searchFilter .filter_detail_area').hide();
            $(this).parent('.filter_menu_area').addClass('on');
            $(this).closest('.filter_section').find('.filter_detail_area').show();
        }
	});

/* +++++++++++++++++++++++ 검색 결과 필터 ++++++++++++++++++++++++ */

	// 최근 본 상품
	todayViewList();
	// 최근 검색어
	searchRecentList();
	// 최근 검색어 자동저장
	setRecentAuto('now');
	// 자동완성 사용
	setUseAuto('now');
});
