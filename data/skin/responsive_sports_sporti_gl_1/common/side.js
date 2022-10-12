$(function(){
	// 사이드 메뉴 탭 여닫기
	$("#layout_side div.aside_navigation_wrap ul.tab li").click(function(){
		var tabIdx = $("#layout_side div.aside_navigation_wrap ul.tab li").index(this);
		$("#layout_side div.aside_navigation_wrap ul.tab li").removeClass('current');
		$(this).addClass('current');
		$("#layout_side div.aside_navigation_wrap ul.menu").hide().eq(tabIdx).show();
	});

	// 사이드 메뉴 여닫기
	$("#layout_side div.aside_navigation_wrap ul.menu li.mitem a.mitem_title").click(function(){
		var mitemObj = $(this).closest("li.mitem");
		var subObj = $(this).closest("li.mitem").next(".mitem_subcontents");
		if(subObj.length){
			if($("ul.submenu",subObj).length && !$("ul.submenu>li",subObj).length){
				return true;
			}
			if(subObj.is(":visible")){
				subObj.slideUp(300);
				$(this).closest("li.mitem").removeClass("mitemicon2").addClass("mitemicon1");
			}else{
				subObj.slideDown(300);
				$(this).closest("li.mitem").removeClass("mitemicon1").addClass("mitemicon2");
			}
		}
		return false;
	});

	// 사이드 메뉴 카테고리 즐겨찾기
	var alert_timer = null;
	$("#layout_side .mitem_favorite").click(function(){
		var obj = $(this);
		var ctype = $(this).attr('ctype');
		var ccode = $(this).attr('ccode');


		switch(ctype){
			case 'category'	: var ctype_name = getAlert('et395'); break; //카테고리
			case 'brand'	: var ctype_name = getAlert('et396'); break; //브랜드
			default : var ctype_name = getAlert('et395'); break;
		}

		$.ajax({
			'url' : '/common/ajax_category_favorite',
			'type' : 'get',
			'data' : {'ctype':ctype,'ccode':ccode},
			'success' : function(res){
				if(res=='on') {
					obj.addClass('mitem_favorite_on');
					$("#category_favorite_alert .cfa_on").show();
					$("#category_favorite_alert .cfa_off").hide();
					//"즐겨찾는 "+ctype_name+"에<br />저장되었습니다."
					$("#category_favorite_alert .cfa_msg").html(getAlert('et397',ctype_name));

				}
				else if(res=='off') {
					obj.removeClass('mitem_favorite_on');
					$("#category_favorite_alert .cfa_on").hide();
					$("#category_favorite_alert .cfa_off").show();
					//"즐겨찾는 "+ctype_name+"에<br />삭제되었습니다."
					$("#category_favorite_alert .cfa_msg").html(getAlert('et398',ctype_name));
				}else{
					//회원만 사용가능합니다.\n로그인하시겠습니까?
					if(confirm(getAlert('et399'))){
						var url = "/member/login";
						top.document.location.href = url;
						return;
					}else{
						return;
					}
				}
				$("#category_favorite_alert").stop(true,true).show();

				clearInterval(alert_timer);
				alert_timer = setInterval(function(){
					clearInterval(alert_timer);
					$("#category_favorite_alert").stop(true,true).show().fadeOut('slow');
				},1000);
			}
		});
	});

	// 베스트 브랜드 페이징
	var perpage = 6;
	if($("#layout_side .bestbrands>li").length>perpage){
		var max_page = Math.ceil($("#layout_side .bestbrands>li").length/perpage);
		var now_page = 1;
		$("#layout_side .bestbrands>li").not(":lt("+perpage+")").hide();
		$("#layout_side .bestbrands_paging").customMobilePagination({
			'style':'paging_style_5',
			'max_page':max_page,
			'on_prev':function(){
				now_page = now_page == 1 ? max_page : now_page-1;
				$("#layout_side .bestbrands_paging").customMobilePagination('set_page',{'now_page':now_page});

				$("#layout_side .bestbrands>li").hide();
				$("#layout_side .bestbrands>li:lt("+(now_page*perpage)+")").show();
				$("#layout_side .bestbrands>li:lt("+((now_page-1)*perpage)+")").hide();

			},
			'on_next':function(){
				now_page = now_page == max_page ? 1 : now_page+1;
				$("#layout_side .bestbrands_paging").customMobilePagination('set_page',{'now_page':now_page});

				$("#layout_side .bestbrands>li").hide();
				$("#layout_side .bestbrands>li:lt("+(now_page*perpage)+")").show();
				$("#layout_side .bestbrands>li:lt("+((now_page-1)*perpage)+")").hide();
			}
		});
	}

	// 브랜드 소트
	var brandsort = function(kind1,word){
		$("#layout_side .mitem_brand").hide();
		$("#layout_side .mitem_brand.mitemicon2").removeClass('mitemicon2').addClass('mitemicon1');
		$("#layout_side .mitem_brand_sub").hide();

		if (kind1==0) {
			// '전체' 탭 클릭시
			$("#layout_side .mitem_brand").show();
		} else if (kind1==3 || word) {
			$("#layout_side .mitem_brand").each(function(){
				var title_org = $(this).attr('title');
				var title = $(this).attr('title').toLowerCase();

				var title_eng_org = $(this).attr('title_eng') ? $(this).attr('title_eng') : title_org;
				var title_eng = title_eng_org.toLowerCase();

				// 가나다순
				if(kind1==1){
					if(word=='ㄱ' && title.substring(0,1).search(/[가-낗]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㄴ' && title.substring(0,1).search(/[나-닣]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㄷ' && title.substring(0,1).search(/[다-띻]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㄹ' && title.substring(0,1).search(/[라-맇]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㅁ' && title.substring(0,1).search(/[마-밓]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㅂ' && title.substring(0,1).search(/[바-삫]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㅅ' && title.substring(0,1).search(/[사-앃]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㅇ' && title.substring(0,1).search(/[아-잏]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㅈ' && title.substring(0,1).search(/[자-찧]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㅊ' && title.substring(0,1).search(/[차-칳]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㅋ' && title.substring(0,1).search(/[카-킿]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㅌ' && title.substring(0,1).search(/[타-팋]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㅍ' && title.substring(0,1).search(/[파-핗]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
					if(word=='ㅎ' && title.substring(0,1).search(/[하-힣]/)!=-1) {$(this).show(); $(".mitem_goodsview",this).text(title);}
				}

				// ABC순
				if(kind1==2){
					if(title.substring(0,1)==word){
						$(this).show();
						$(".mitem_goodsview",this).text(title_org);
					}else if(title_eng.substring(0,1)==word){
						$(this).show();
						$(".mitem_goodsview",this).text(title_eng_org);
					}
				}

				// 숫자
				if(kind1==3){
					if(title.substring(0,1).search(/[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/) == -1 && title_eng.substring(0,1).search(/[ㄱ-ㅎ|ㅏ-ㅣ|가-힝]/) == -1 && title.substring(0,1).search(/[a-z]/) == -1 && title_eng.substring(0,1).search(/[a-z]/) == -1){
						$(this).show();
					}
				}
			});
		}
	};

	// 브랜드 소트 - 탭
	$("#layout_side .brandsort>li").click(function(){
		var idx = $("#layout_side .brandsort>li").index(this);
		$("#layout_side .brandsort>li.current").removeClass('current');
		$(this).addClass('current');

		$("#layout_side .brandsort_words").hide();
		$("#layout_side .brandsort_words").eq(idx).show();
		if ( idx != 0 ) {
			$('#brandSideMenu .mitem_subcontents').hide();
		}
		if(idx == 0 || idx == 3 ){
			brandsort(idx,'');
		}else{
			$("#layout_side .brandsort_words").eq(idx).children("li:first-child").trigger('click');
		}
	});

	// 브랜드 소트 - 단어
	$("#layout_side .brandsort_words>li").click(function(){
		var idx = $("#layout_side .brandsort>li").index($("#layout_side .brandsort>li.current"));
		var word = $(this).text().toLowerCase();

		$("#layout_side .brandsort_words>li.current").removeClass('current');
		$(this).addClass('current');
		brandsort(idx,word);
	});
});