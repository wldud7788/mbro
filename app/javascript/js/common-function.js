
var gl_basic_currency					= 'KRW';
var gl_skin_currency					= 'KRW';
var gl_basic_currency_symbol			= '원';
var gl_basic_currency_symbol_position	= 'after';

function strip_tags(html){

	//PROCESS STRING
	if(arguments.length < 3) {
		html=html.replace(/<\/?(?!\!)[^>]*>/gi, '');
	} else {
		var allowed = arguments[1];
		var specified = eval("["+arguments[2]+"]");
		if(allowed){
			var regex='</?(?!(' + specified.join('|') + '))\b[^>]*>';
			html=html.replace(new RegExp(regex, 'gi'), '');
		} else{
			var regex='</?(' + specified.join('|') + ')\b[^>]*>';
			html=html.replace(new RegExp(regex, 'gi'), '');
		}
	}

	//CHANGE NAME TO CLEAN JUST BECAUSE
	var clean_string = html;

	//RETURN THE CLEAN STRING
	return clean_string;
}

/* input form style 적용*/
function apply_input_style(){

	setDefaultText();
	setDatepicker();

	$(".onlynumber, .onlynumber_signed").live("keydown",function(e){
		if($(this).hasClass('onlynumber')) return onlynumber(e);
		if($(this).hasClass('onlynumber_signed')) return onlynumber_signed(e);
	}).live('focusin',function(){
		if($(this).val()=='0') $(this).val('');
	}).live('focusout',function(){
		if($(this).val()=='') $(this).val('0');
	}).live('change',function(){
		if($(this).attr('max')){
			var max = num($(this).attr('max'));
			if(num($(this).val()) > max){
				$(this).val(max).change();
			}
		}

		if($(this).attr('min')){
			var min = num($(this).attr('min'));
			if(num($(this).val()) < min){
				$(this).val(min).change();
			}
		}

		$(this).val( $(this).val().replace(/[^0-9\-]*/gi, ''));

	});

	$(".onlyfloat").live("keydown",function(e){
		if (e.keyCode!=190 && e.keyCode!=110) return onlynumber(e);
	}).live('focusin',function(){
		if($(this).val()=='0') $(this).val('');
	}).live('focusout',function(){
		if($(this).val()=='') $(this).val('0');
	});

	$(".percent").bind("keyup",function(){
		if( $(this).val() > 100 ){
			$(this).val(100);
		}
	});

	help_tooltip();
}

function help_tooltip(){
/* 툴팁 */
	$(".helpicon, .mainhelpicon, .help, .colorhelpicon, .underhelpicon").each(function(){

		var options = {
			className: 'tip-darkgray',
			bgImageFrameSize: 8,
			alignTo: 'target',
			alignX: 'right',
			alignY: 'center',
			offsetX: 10,
			allowTipHover: false,
			slide: false,
			showTimeout : 0
		}

		if($(this).attr('options')){
			var customOptions = eval('('+$(this).attr('options')+')');
			for(var i in customOptions){
				options[i] = customOptions[i];
			}
		}

		$(this).poshytip(options);
	});

	// 상세 레이어창 열기 :: 2016-08-17 lwh
	$(".detailDescriptionLayerBtn").unbind("click").bind("click",function(){
		currencyCompareList($(this));
	});

	//상세 레이어창 열기 :: 마우스 오버용 @2016-11-08
	$(".detailDescriptionLayerBtn.over").unbind("mouseover").bind("mouseover",function(){
		currencyCompareList($(this));
	});
	$(".detailDescriptionLayerBtn.over").unbind("mouseout").bind("mouseout",function(){
		$('div.detailDescriptionLayer').hide();
	});

	$(".currency_compare_lay .detailDescriptionLayerCloseBtn").bind("click",function(){
		$('div.detailDescriptionLayer').hide();
	});
}

// 비교통화 노출
function currencyCompareList(obj){

	var layer	= $(obj).parent().find('div.detailDescriptionLayer');
	var title	= $(obj).attr("title");
	var idx		= parseInt(Math.random()*10000000);

	if(title){
		var message	= "";
		if($(obj).parent().find('div.detailDescriptionLayer .layer_wrap .layer_inner').html() != null){
			message	= $(obj).parent().find('div.detailDescriptionLayer .layer_wrap .layer_inner').html();
		}else{
			message	= layer.html();
		}
		var cont	= "";
		cont_new	= '<div class="layer_wrap">';
		cont_new	= cont_new + '<h1>' + title + '</h1>';
		cont_new	= cont_new + '<div class="layer_inner">' + message + '</div>';
		cont_new	= cont_new + '<a href="javascript:;" class="detailDescriptionLayerCloseBtn '+idx+'" onclick="detailDescriptionLayerClose('+idx+')"></a>';
		cont_new	= cont_new + '</div>';
		layer.html(cont_new);
		$(".helpicon_noimg").each(function(){ //상품정보 재고/가용 팁툴 마우스오버용

			var options = {
				className: 'tip-darkgray',
				bgImageFrameSize: 8,
				alignTo: 'target',
				alignX: 'left',
				alignY: 'center',
				offsetX: 10,
				allowTipHover: false,
				slide: false,
				showTimeout : 0
			}

			if($(this).attr('options')){
				var customOptions = eval('('+$(this).attr('options')+')');
				for(var i in customOptions){
					options[i] = customOptions[i];
				}
			}

			$(this).poshytip(options);
		});
	}

	$('div.detailDescriptionLayer').not($(obj).next('div.detailDescriptionLayer')).hide();$(obj).next('div.detailDescriptionLayer').toggle()
}

// 특정 영역 하위만 활성화
function area_help_tooltip(obj){
	$(obj).find(".helpicon, .mainhelpicon, .help, .colorhelpicon, .underhelpicon").each(function(){

		var options = {
			className: 'tip-darkgray',
			bgImageFrameSize: 8,
			alignTo: 'target',
			alignX: 'right',
			alignY: 'center',
			offsetX: 10,
			allowTipHover: false,
			slide: false,
			showTimeout : 0
		}

		if($(this).attr('options')){
			var customOptions = eval('('+$(this).attr('options')+')');
			for(var i in customOptions){
				options[i] = customOptions[i];
			}
		}

		$(this).poshytip(options);
	});
}

/* input form style 적용*/
function chk_small_goods_image(){
	$('img.small_goods_image').error(function(){
		var noImageSrc = '/data/icon/goods/error/noimage_list.gif';
		if (this.src != noImageSrc) {// image was broken, replace with your new image
			this.src = noImageSrc;
		}
	}).each(function(){
		this.setAttribute('src',this.getAttribute('src'));
	});
}

function reMakeHelpIcon(){
	/* 툴팁 */
	$(".addHelpIcon").each(function(){

		var options = {
			className: 'tip-darkgray',
			bgImageFrameSize: 8,
			alignTo: 'target',
			alignX: 'right',
			alignY: 'center',
			offsetX: 10,
			allowTipHover: false,
			slide: false,
			showTimeout : 0
		}

		if($(this).attr('options')){
			var customOptions = eval('('+$(this).attr('options')+')');
			for(var i in customOptions){
				options[i] = customOptions[i];
			}
		}

		$(this).poshytip(options);
	});
}

function setDatepicker(selector){

	if(!selector) selector = ".datepicker";
	var randKey = Math.floor(Math.random() * 0x75bcd15);

	/* 달력 */
	$(selector).each(function(i){

		if(!$(this).is(".datepicker")){
			return;
		}
		if($(this).data('datepickerSettingDone')){
			return;
		}

		var randId = randKey.toString() + '_' + i.toString();

		var options = {
			dateFormat : 'yy-mm-dd',
			timeFormat: 'hh:mm:ss',
			showOn: "button",
			dayNamesMin : ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort : ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
			showButtonPanel : true,
			showMonthAfterYear : true,
			changeYear : true,
			changeMonth : true,
			closeText : '닫기',
			currentText : '오늘',
			yearRange : '1900:c+10',
			buttonImage: "/app/javascript/jquery/icon_calendar.gif",
			buttonImageOnly: true
		}

		if($(this).attr('gettype')){
			options.dateFormat	= $(this).attr('gettype');
		}

		if(!$(this).attr('id') || $(this).attr('id').substring(0,11)=='datepicker_'){
			$(this).attr('id','datepicker_'+randId);
		}

		if($(this).attr('options')){
			var customOptions = eval('('+$(this).attr('options')+')');
			for(var i in customOptions){
				options[i] = customOptions[i];
			}
		}

		if($(this).is(".datepicker"))		{
			$(this).datepicker(options);
			$(this).data('datepickerSettingDone',true);
		}

	});
}

/*
* datepicker 날짜 선택 제한
*/
function fnDatepicker(mode,day=0) {
	var options = new Array();
	
	if(mode == 'min'){
		options['minDate'] = day;
	}else if (mode == 'max'){
		options['maxDate'] = day;
	}

	return options;
}

function setTimepicker(selector){

	if(!selector) selector = ".datetimepicker";

	/* 달력 */
	$(selector).each(function(i){

		var options = {
			dateFormat : 'yy-mm-dd',
			timeFormat: 'hh:mm:ss',
			showOn: "button",
			dayNamesMin : ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort : ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
			showButtonPanel : true,
			showMonthAfterYear : true,
			changeYear : true,
			changeMonth : true,
			closeText : '닫기',
			currentText : '오늘',
			buttonImage: "/app/javascript/jquery/icon_calendar.gif",
			buttonImageOnly: true
		}

		if(!$(this).attr('id') || $(this).attr('id').substring(0,11)=='datepicker_'){
			$(this).attr('id','datepicker_'+i);
		}

		if($(this).attr('options')){
			var customOptions = eval('('+$(this).attr('options')+')');
			for(var i in customOptions){
				options[i] = customOptions[i];
			}
		}

		if($(this).is(".datetimepicker"))	$(this).datetimepicker(options);

	});
}



function onlynumber(event){
	var e = event.keyCode;

	if (e>=48 && e<=57) return;
	if (e>=96 && e<=105) return;
	if (e>=37 && e<=40) return;
	if (e==8 || e==9 || e==13 || e==46 || (e==229 && gl_set_mode == 'mobile')) return;
	event.returnValue = false;
	return false;
}
function onlynumber_signed(event){
	var e = event.keyCode;

	if (e>=48 && e<=57) return;
	if (e>=96 && e<=105) return;
	if (e>=37 && e<=40) return;
	if (e==8 || e==9 || e==13 || e==46 || e==109 || e==189) return;
	event.returnValue = false;
	return false;
}

//password -> type change , title add 2012-10-19
function setDefaultText(){
	try{
		$('input, textarea')
		.each(function(){
			var thisInputObj = $(this);
			if(thisInputObj.attr('title') != thisInputObj.attr('placeholder') || !thisInputObj.attr('placeholder')) thisInputObj.attr('placeholder',thisInputObj.attr('title'));
		})
		// $('input, textarea').placeholder();
	} catch (e) {
		setTimeout(function(){
			$("input[type='text'][title!=''], textarea[title!=''], input[type='password'][title!=''][password='password']")
			.each(function(){
				var thisInputObj = $(this);
				$(this.form).submit(function(){
					if(thisInputObj.val() == thisInputObj.attr('title')) thisInputObj.val('');
				})
			})
			.bind('focusin focusout keydown',function(event){
				if(event.type=='focusout')
				{
					if($(this).val() == '')
					{
						if ( $(this).attr('password') == 'password' && $(this).attr('title')) {
							if(($.browser.version >= 9.0 && $.browser.msie) || !$.browser.msie ) {
								if( $(this).attr("id")){
									document.getElementById($(this).attr("id")).type = "text";
								}else{
									document.getElementsByName($(this).attr("name")).type = "text";
								}
								$(this).val($(this).attr('title')).addClass('input-box-default-text');
							}
						}else{
							$(this).val($(this).attr('title')).addClass('input-box-default-text');
						}
					}
				}
				if(event.type=='focusin' || event.type=='keydown')
				{
					if($(this).val() == $(this).attr('title') ){
						if ( $(this).attr('password') == 'password' && $(this).attr('title')) {
							if(($.browser.version >= 9.0 && $.browser.msie) || !$.browser.msie ) {
								if( $(this).attr("id")){
									document.getElementById($(this).attr("id")).type = "password";
								}else{
									document.getElementsByName($(this).attr("name")).type = "password";
								}
								$(this).val('');
							}
						}else{
							$(this).val('');
						}
					}
					$(this).removeClass('input-box-default-text');
				}
			}).focusout();
		},300);

		setTimeout(function(){
			$("input[type='password'][title][password!='password']")
			.each(function(){
				var thisInputObj = $(this);
				if(!thisInputObj.attr('uniqCloneId')){
					var uniqCloneId = uniqid();
					var thisCloneObj = $("<input type='text' />");
					thisCloneObj
					.attr('style',$(this).attr('style'))
					.attr('size',$(this).attr('size'))
					.attr('class',$(this).attr('class'))
					.addClass('input-box-default-text');
					//var thisCloneObj = $(this).clone().attr({'type':'text','name':'','id':uniqCloneId});
					if($(this).attr('tabIndex')) thisCloneObj.attr('tabIndex',$(this).attr('tabIndex'));
					$(this).attr('uniqCloneId',uniqCloneId);
					$(thisCloneObj).attr({'value':$(this).attr('title'),'title':''});

					thisCloneObj.bind('focus',function(){
						thisInputObj.show().focus();
						$(this).hide();
					});
					$(this).hide().after(thisCloneObj);

					$(this).bind('focusout',function(event){
						if($(this).val() == '')
						{
							$(this).hide();
							thisCloneObj.show();
						}else{
							$(this).show();
							thisCloneObj.hide();
						}
					}).focusout();
				}
			})

		},300);
	}
}


//password -> type change , title add 2012-10-19
function areaSetDefaultText(obj){
	try{
		$(obj).find('input, textarea')
		.each(function(){
			var thisInputObj = $(this);
			if(thisInputObj.attr('title') != thisInputObj.attr('placeholder') || !thisInputObj.attr('placeholder')) thisInputObj.attr('placeholder',thisInputObj.attr('title'));
		})
		// $('input, textarea').placeholder();
	} catch (e) {
		setTimeout(function(){
			$(obj).find("input[type='text'][title!=''], textarea[title!=''], input[type='password'][title!=''][password='password']")
			.each(function(){
				var thisInputObj = $(this);
				$(this.form).submit(function(){
					if(thisInputObj.val() == thisInputObj.attr('title')) thisInputObj.val('');
				})
			})
			.bind('focusin focusout keydown',function(event){
				if(event.type=='focusout')
				{
					if($(this).val() == '')
					{
						if ( $(this).attr('password') == 'password' && $(this).attr('title')) {
							if(($.browser.version >= 9.0 && $.browser.msie) || !$.browser.msie ) {
								if( $(this).attr("id")){
									document.getElementById($(this).attr("id")).type = "text";
								}else{
									document.getElementsByName($(this).attr("name")).type = "text";
								}
								$(this).val($(this).attr('title')).addClass('input-box-default-text');
							}
						}else{
							$(this).val($(this).attr('title')).addClass('input-box-default-text');
						}
					}
				}
				if(event.type=='focusin' || event.type=='keydown')
				{
					if($(this).val() == $(this).attr('title') ){
						if ( $(this).attr('password') == 'password' && $(this).attr('title')) {
							if(($.browser.version >= 9.0 && $.browser.msie) || !$.browser.msie ) {
								if( $(this).attr("id")){
									document.getElementById($(this).attr("id")).type = "password";
								}else{
									document.getElementsByName($(this).attr("name")).type = "password";
								}
								$(this).val('');
							}
						}else{
							$(this).val('');
						}
					}
					$(this).removeClass('input-box-default-text');
				}
			}).focusout();
		},300);

		setTimeout(function(){
			$(obj).find("input[type='password'][title][password!='password']")
			.each(function(){
				var thisInputObj = $(this);
				if(!thisInputObj.attr('uniqCloneId')){
					var uniqCloneId = uniqid();
					var thisCloneObj = $("<input type='text' />");
					thisCloneObj
					.attr('style',$(this).attr('style'))
					.attr('size',$(this).attr('size'))
					.attr('class',$(this).attr('class'))
					.addClass('input-box-default-text');
					//var thisCloneObj = $(this).clone().attr({'type':'text','name':'','id':uniqCloneId});
					if($(this).attr('tabIndex')) thisCloneObj.attr('tabIndex',$(this).attr('tabIndex'));
					$(this).attr('uniqCloneId',uniqCloneId);
					$(thisCloneObj).attr({'value':$(this).attr('title'),'title':''});

					thisCloneObj.bind('focus',function(){
						thisInputObj.show().focus();
						$(this).hide();
					});
					$(this).hide().after(thisCloneObj);

					$(this).bind('focusout',function(event){
						if($(this).val() == '')
						{
							$(this).hide();
							thisCloneObj.show();
						}else{
							$(this).show();
							thisCloneObj.hide();
						}
					}).focusout();
				}
			})

		},300);
	}
}
/*
function comma(x)
{
	var temp = "";
	var x = String(uncomma(x));

	num_len = x.length;
	co = 3;
	while (num_len>0){
		num_len = num_len - co;
		if (num_len<0){
			co = num_len + co;
			num_len = 0;
		}
		temp = ","+x.substr(num_len,co)+temp;
	}
	var result = temp.substr(1);
	result = result.replace('-,', '-');
	result = result.replace('-0', '0');

	return result;
}
*/

function comma(data_value) {
	var data_value = String(uncomma(data_value));
    var txtNumber = '' + data_value;    // 입력된 값을 문자열 변수에 저장합니다.
    if (isNaN(txtNumber) || txtNumber == "") {    // 숫자 형태의 값이 정상적으로 입력되었는지 확인합니다.
        alert("숫자만 입력 하세요");
        return;
    }
    else {
        var rxSplit = new RegExp('([0-9])([0-9][0-9][0-9][,.])');    // 정규식 형태 생성
        var arrNumber = txtNumber.split('.');    // 입력받은 숫자를 . 기준으로 나눔. (정수부와 소수부분으로 분리)
        arrNumber[0] += '.'; // 정수부 끝에 소수점 추가
        do {
            arrNumber[0] = arrNumber[0].replace(rxSplit, '$1,$2'); // 정수부에서 rxSplit 패턴과 일치하는 부분을 찾아 replace 처리
        } while (rxSplit.test(arrNumber[0])); // 정규식 패턴 rxSplit 가 정수부 내에 있는지 확인하고 있다면 true 반환. 루프 반복.
        if (arrNumber.length > 1) { // txtNumber를 마침표(.)로 분리한 부분이 2개 이상이라면 (즉 소수점 부분도 있다면)
            return arrNumber.join(''); // 배열을 그대로 합칩. (join 함수에 인자가 있으면 인자를 구분값으로 두고 합침)
        }
        else { // txtNumber 길이가 1이라면 정수부만 있다는 의미.
            return arrNumber[0].split('.')[0]; // 위에서 정수부 끝에 붙여준 마침표(.)를 그대로 제거함.
        }
    }
}

function uncomma(x){
	var result		= '';
	var reg			= /(,)*/g;
	var txtNumber	= '' + String(x);
	var arrNumber	= txtNumber.split('.');
	arrNumber[0]	= parseInt(String(arrNumber[0]).replace(reg,""));

	if	(arrNumber.length > 1){
		result		= arrNumber.join('.');
	}else{
		result		= arrNumber[0];
	}

	return (isNaN(result)) ? 0 : result;
}

function uncomma_float(x)
{
	var reg = /(,)*/g;
	x = parseFloat(String(x).replace(reg,""));
	return (isNaN(x)) ? 0 : x;
}

function num(val){
	if(!val || val=='' || isNaN(val)){
		return 0;
	}else{
		return parseInt(val);
	}
}

function num_float(val){
	if(!val || val=='' || isNaN(val)){
		return 0;
	}else{
		return parseFloat(val);
	}
}

// 소숫점을 포함한 comma함수
function float_comma(price){
	var result	= price + '';
	if	(result.search(/\./) != -1){
		var tmp	= result.split('.');
		result	= comma(tmp[0]) + '.' + tmp[1];
	}else{
		result	= comma(price);
	}

	result	= result.replace('-,', '-');
	result	= result.replace('-0', '0');

	return result;
}

/* 카테고리 가져오기*/
function category_select_load(preSelectName,selectName,code,callbackFunction){
	$("select[name='" + selectName + "'] option").each(function(){ if( $(this).val() ) $(this).remove(); });
	if(preSelectName && !code) return;
	$.ajax({
		type: "GET",
		url: "/common/category2json",
		data: "categoryCode=" + code,
		dataType: 'json',
		success: function(result){
			var options = "";
			for(var i=0;i<result.length;i++) options += "<option value='"+result[i].category_code+"'>"+result[i].title+"</option>";
			$("select[name='" + selectName + "']").append(options);
			if(options){
				$("select[name='" + selectName + "']").show();
			}
			if(preSelectName){
				$("select[name='" + preSelectName + "'] option[value='"+code+"']").attr("selected",true);
			}

			if(callbackFunction){
				callbackFunction(result);
			}
		}
	});
}


function loadingStart(target,customOptions){
	var options = {segments: 12, width: 5.5, space: 15, length: 13, color: '#ffffff', speed: 1.5};

	if(customOptions != undefined){
		for(var i in customOptions){
			options[i] = customOptions[i];
		}
	}

	if(!target) var target = "#ajaxLoadingLayer";

	$(target).css({'opacity':'0.5'}).activity(options).show();
	$(target).find("div").eq(0).css({'z-index':'1000'});//mobile loadingimg
}

function loadingStop(target,noHidden){
	if(!target) var target = "#ajaxLoadingLayer";
	if(noHidden){
		$(target).css({'opacity':'1'}).activity(false);
	}else{
		$(target).hide().activity(false);
	}
}

//모바일submit 체크
function loadingstartsubmit(){
	loadingStart("body",{segments: 12, width: 25.5, space: 6, length: 23, color: '#000000', speed: 1.5, valign: 'bottom',padding: '1'});
}


/* 다이얼로그 띄우기 (타이틀, 레이어아이디, 옵션) */
function openDialog(title, layerId, customOptions, callback){

	if((typeof layerId) != 'string') var layerSelector = layerId;
	else if(layerId.substring(0,1)=='#' || layerId.substring(0,1)=='.' || (typeof layerId) != 'string') var layerSelector = layerId;
	else var layerSelector = "#"+layerId;

	var options = {
		"zIndex" : 10000,
//		"show" : "fade",
//		"hide" : "fade",
		"modal" : true,
		"resizable" : false,
		"draggable" : true,
		"noClose" : false
	};

	if(customOptions != undefined){
		for(var i in customOptions){
			options[i] = customOptions[i];
		}
	}

	options['title'] = title;

	if(callback){
		$(layerSelector).dialog({
			"modal" : options['modal'],
			"close" : function(){
				callback();
			}
		});
	}

	$(function(){
		if(customOptions['autoOpen']==false){

			$(layerSelector)
			.dialog({"autoOpen" : false})
			.dialog("option", options);

		}else{
			$(layerSelector)
			.dialog({"autoOpen" : false})
			.dialog("option", options)
			.dialog("open")
			.focus();
		}

		// 스크롤시 레이어 위치 조정
		var top_pos = parseInt($(layerSelector).closest('.ui-dialog').css('top'));
		setTimeout(function(){
			if( top_pos < $(document).scrollTop()){
				top_pos = $(document).scrollTop();
				if( top_pos < 0 ) top_pos = 0;
				$(layerSelector).closest('.ui-dialog').css('top',top_pos+'px');
			}
		},200);



		if(options['noClose']==false){

			$(".ui-dialog-titlebar-close",$(layerSelector).closest(".ui-dialog")).show();
			$(".ui-dialog-titlebar-close").bind("click",function(){

				//lek 오늘하루그만보기 추가
				if($('#open_limit_check').is(":checked")) setCookie("isChk","Y",1);

				if(layerId=='recommendDisplayGoodsSelect'){
					parent.$(window).css("overflow-y","auto");
					$(this).dialog("close");
				}else{
					$(window).css("overflow-y","auto");
					$(this).dialog("close");
				}
			});
		}else{

			$(".ui-dialog-titlebar-close",$(layerSelector).closest(".ui-dialog")).hide();
			$(layerSelector).dialog("option","close",function(){
				if(options['noClose'])	$(layerSelector).dialog("open").focus();
			});
		}

		/* 해당창을 최상위로 보내기 */
		var maxZindex	= 0;

		$(".ui-widget-overlay").each(function(k){
			if(maxZindex < $(this).css("z-index")) maxZindex = $(this).css("z-index");
		});

		maxZindex++;
		$(layerSelector).css("z-index",eval(maxZindex)+" !important");
	});

}

//lek 오늘하루그만보기 추가
function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+d.toUTCString();
	document.cookie = cname + "=" + cvalue + "; " + expires;
}

/* 18.03.05 kmj callback 문제로 수정 */
function openDialogNew(title, layerId, customOptions, callback){

	if((typeof layerId) != 'string') var layerSelector = layerId;
	else if(layerId.substring(0,1)=='#' || layerId.substring(0,1)=='.' || (typeof layerId) != 'string') var layerSelector = layerId;
	else var layerSelector = "#"+layerId;

	var options = {
		"zIndex" : 10000,
//		"show" : "fade",
//		"hide" : "fade",
		"modal" : true,
		"resizable" : false,
		"draggable" : true,
		"noClose" : false
	};

	if(customOptions != undefined){
		for(var i in customOptions){
			options[i] = customOptions[i];
		}
	}

	options['title'] = title;

	$(function(){
		if(customOptions['autoOpen']==false){

			$(layerSelector)
			.dialog({"autoOpen" : false})
			.dialog("option", options);

		}else{
			$(layerSelector)
			.dialog({"autoOpen" : false})
			.dialog("option", options)
			.dialog("open")
			.focus();
		}

		// 스크롤시 레이어 위치 조정
		var top_pos = parseInt($(layerSelector).closest('.ui-dialog').css('top'));
		setTimeout(function(){
			if( top_pos < $(document).scrollTop()){
				top_pos = $(document).scrollTop();
				if( top_pos < 0 ) top_pos = 0;
				$(layerSelector).closest('.ui-dialog').css('top',top_pos+'px');
			}
		},200);

		if(options['noClose']==false){
			$(".ui-dialog-titlebar-close",$(layerSelector).closest(".ui-dialog")).show();
			$(".ui-dialog-titlebar-close").bind("click",function(){
				if(layerId=='recommendDisplayGoodsSelect'){
					parent.$(window).css("overflow-y","auto");
					$(this).dialog("close");
				}else{
					$(window).css("overflow-y","auto");
					$(this).dialog("close");
				}
			});
		}else{
			$(".ui-dialog-titlebar-close",$(layerSelector).closest(".ui-dialog")).hide();
			$(layerSelector).dialog("option","close",function(){
				if(options['noClose'])	$(layerSelector).dialog("open").focus();
			});
		}

		/* 해당창을 최상위로 보내기 */
		var maxZindex	= 0;

		$(".ui-widget-overlay").each(function(k){
			if(maxZindex < eval($(this).css("z-index"))) maxZindex = eval($(this).css("z-index"));
		});

		maxZindex++;
		$(layerSelector).css("z-index",eval(maxZindex)+" !important");

		if(callback){
			$(layerSelector).dialog({
				"modal" : options['modal'],
				"close" : function(){
					callback();
				}
			});
		}
	});
}

/* 다이얼로그 닫기 */
function closeDialog(layerId){
	if((typeof layerId) != 'string') var layerSelector = layerId;
	else if(layerId.substring(0,1)=='#' || layerId.substring(0,1)=='.' || (typeof layerId) != 'string') var layerSelector = layerId;
	else var layerSelector = "#"+layerId;
	$(layerSelector).dialog("close");    
}

/* 다이얼로그 팝업창띄우기(미리 div영역을 만들어놓을필요가 없음) */
function openDialogPopup(title, layerId, customOptions, onloadCallback){
	closeDialog(layerId);

	var layerSelector = "#"+layerId;

	if($(layerSelector).length==0){
		layerSelector = $("<div id='"+layerId+"'></div>").appendTo('body');
	}

	if(customOptions['url']){
		$.ajax({
			'cache' : false,
			'url' : customOptions['url'],
			'type' : customOptions['type']?customOptions['type']:'get',
			'data' : customOptions['data']?customOptions['data']:{},
			'success' : function(result){
				$(layerSelector).html(result);
				openDialog(title, layerId, customOptions);
				if(onloadCallback){
					onloadCallback();
				}
			}
		});
	}

}

/* Alert 다이얼로그 */
/* 사용예
	openDialogAlert("저장했습니다.",400,140,function(){
		alert("확인을 눌렀습니다.");
	});
*/
function openDialogAlert(msg,width,height,callback,customOptions){
	if(gl_mobile_mode && gl_set_mode == 'mobile'){
		openDialogAlertmobile(msg,width,height,callback,customOptions);
		return;
	}
	var options = {
		"z-index"		: 999999,
		"hideButton"	: false,
		"modal" 		: true
	};

	if(customOptions != undefined){
		for(var i in customOptions){
			options[i] = customOptions[i];
		}
	}

	if(width) options['width'] = width;
	if(height) options['height'] = height;

	document.getElementById('openDialogLayerMsg').innerHTML = msg;

	admin_flag = check_is_admin();

	//알림 <span class='desc'>알림 정보를 표시합니다.</span>
	title = getAlert('et352');
	if	(admin_flag)
		title = "알림 <span class='desc'>알림 정보를 표시합니다.</span>";
	openDialog(title, "openDialogLayer", options);

	if(callback){
		$("#openDialogLayer").dialog({
			"modal" : options['modal'],
			"close" : function(){
				callback();
			}
		});
	}
	//확인
	btn_y = getAlert('et353')
	if	(admin_flag)
		btn_y = '확인';

	options.btn_title	= (options.btn_title) ? options.btn_title : btn_y;
	options.btn_class	= (options.btn_class) ? options.btn_class : 'btn medium';
	options.btn_action	= (options.btn_action) ? options.btn_action : function(){ $('#openDialogLayer').dialog('close'); };

	$("#openDialogLayerBtns").remove();
	if(!options.hideButton){
		var button = $('<input>').attr('type', 'button');
		if(options.btn_title) button.attr('value', options.btn_title);
		if(options.btn_action) {
			if(typeof options.btn_action === 'string'){
				button.attr('onclick', options.btn_action);
			} else if(typeof options.btn_action === 'function'){
				if($().jquery == '1.6.4'){
					button.bind('click', options.btn_action);
				}else{
					button.on('click', options.btn_action);
				}
			}
		}
		$("#openDialogLayer").append(
			$('<div>').attr('id', 'openDialogLayerBtns').css({'text-align': 'center', 'padding-top': '15px'}).append(
				$('<span>').addClass(options.btn_class).append(
					button
				)
			)
		);
	}
	$("#openDialogLayerBtns input:eq(0)").focus();
}

function openDialogAlerttitle(title, msg,width,height,callback,customOptions){

	var options = {
		"hideButton"	: false,
		"modal" 		: true
	};

	if(customOptions != undefined){
		for(var i in customOptions){
			options[i] = customOptions[i];
		}
	}

	if(width) options['width'] = width;
	if(height) options['height'] = height;

	document.getElementById('openDialogLayerMsg').innerHTML = msg;
	openDialog(title, "openDialogLayer", options);

	if(callback){
		$("#openDialogLayer").dialog({
			"modal" : options['modal'],
			"close" : function(){
				callback();
			}
		});
	}

	$("#openDialogLayerBtns").remove();
	if(!options.hideButton){
		$("#openDialogLayer").append("<div id='openDialogLayerBtns' align='center' style='padding-top:15px'><button class='resp_btn v3 size_XL' onclick=\"$('#openDialogLayer').dialog('close');\" >닫기</button></div>");
	}
	$("#openDialogLayerBtns input:eq(0)").focus();

}

/* Confirm 다이얼로그 */
/* 사용예
	openDialogConfirm('저장하시겠습니까?',400,140,function(){
		alert('예를 눌렀습니다.');
	},function(){
		alert('아니오를 눌렀습니다.');
	});

*/
function openDialogConfirm(msg,width,height,yesCallback,noCallback,params){
	if(gl_mobile_mode && gl_set_mode == 'mobile'){
		openDialogConfirmmobile(msg,width,height,yesCallback,noCallback,params);
		return;
	}

	var choicedYes = false;
	admin_flag = check_is_admin();

	document.getElementById('openDialogLayerMsg').innerHTML = msg;
	//알림 <span class='desc'>알림 정보를 표시합니다.</span>
	title = getAlert('et352');
	if	(admin_flag)
		title = "알림 <span class='desc'>알림 정보를 표시합니다.</span>";
	openDialog(title, "openDialogLayer", {"width":width,"height":height});

	$("#openDialogLayer").dialog({
			close : function(){
				if(noCallback && !choicedYes){
					noCallback();
				}
			}
	});
	var params = typeof params!='undefined' ? params : {};
	//예
	btn_y = getAlert('et354');
	if	(admin_flag)
		btn_y = '예';
	if(!params['yesMsg']){params['yesMsg'] = btn_y;}
	//아니오
	btn_n = getAlert('et355');
	if	(admin_flag)
		btn_n = '아니오';
	if(!params['noMsg']){params['noMsg'] = btn_n;}

	$("#openDialogLayerBtns").remove();
	$("#openDialogLayer").append("<div id='openDialogLayerBtns' align='center' style='padding-top:15px'><span class='btn medium'><button type='button' id='openDialogLayerConfirmYesBtn'>"+params['yesMsg']+"</button></span> <span class='btn medium'><button type='button' id='openDialogLayerConfirmNoBtn'>"+params['noMsg']+"</button></span></div>");
	$("#openDialogLayerBtns input:eq(0)").focus();

	document.getElementById('openDialogLayerConfirmYesBtn').onclick = function(){
		choicedYes = true;
		$("#openDialogLayer").dialog("close");
		if(yesCallback) yesCallback();
	};
	document.getElementById('openDialogLayerConfirmNoBtn').onclick = function(){
		choicedYes = false;
		$("#openDialogLayer").dialog("close");
	};
}

function openDialogConfirmtitle(title,msg,width,height,yesCallback,noCallback){
	var choicedYes = false;

	document.getElementById('openDialogLayerMsg').innerHTML = msg;
	openDialog(title, "openDialogLayer", {"width":width,"height":height});

	$("#openDialogLayer").dialog({
			close : function(){
				if(noCallback && !choicedYes){
					noCallback();
				}
			}
	});

	$("#openDialogLayerBtns").remove();
	$("#openDialogLayer").append("<div id='openDialogLayerBtns' align='center' style='padding-top:15px'><span class='btn medium'><input type='button' value='예' id='openDialogLayerConfirmYesBtn' class='btn_resp size_b'/></span> <span class='btn medium'><input type='button' value='아니오' id='openDialogLayerConfirmNoBtn' class='btn_resp size_b color2'/></span></div>");
	$("#openDialogLayerBtns input:eq(0)").focus();

	document.getElementById('openDialogLayerConfirmYesBtn').onclick = function(){
		choicedYes = true;
		$("#openDialogLayer").dialog("close");
		if(yesCallback) yesCallback();
	};
	document.getElementById('openDialogLayerConfirmNoBtn').onclick = function(){
		choicedYes = false;
		$("#openDialogLayer").dialog("close");
	};
}

/**
 * 다양한 사용자 정의 대화상자를 띄웁니다.
 * @param {Object} options
 * @param {Element} options.text
 * @param {string} [options.title]
 * @param {Array.<{text: string, attributes?: Object, action?: Function, default?: boolean}|Element|string>} [options.buttons=[]]
 * @param {number} [options.width=400]
 * @param {number} [options.height]
 * @param {Function} [options.close]
 * @param {Function} [options.beforeclose]
 */
function openCustomDialog(options){
	if(!options || typeof options !== 'object') throw TypeError('"options" is required and must supplied as object');
	var _this = this;

	/* default values */
	options.title = options.title || getAlert('et352');
	options.buttons = options.buttons || [];
	options.width = +options.width || 400;

	/* check type of arguments */
	if(typeof options.text !== 'string') throw TypeError('"text" is required and must supplied as string');
	if(!isNumber(options.width)) throw TypeError('"width" must supplied as number');
	if(options.height && !isNumber(options.height)) throw TypeError('"height" must supplied as number');
	if(!Array.isArray(options.buttons)) throw TypeError('"buttons" must supplied as Array');

	/* create new dialog layer */
	var dialogLayer = $(document.createElement('div')).hide();
	var buttonLayer = null;
	var defaultButton = null;
	var dialogOptions = {'width':options.width, 'height': options.height || 'auto','beforeClose':options.beforeclose || null,'close':function(e) {
		if(options.close && typeof options.close === 'function') options.close(e);
		_this.dispose();
	}};
	dialogLayer.append($('<div>').append(options.text));

	/* check if buttons required? */
	if(options.buttons.length > 0) {
		buttonLayer = $(document.createElement('div'));
		buttonLayer.css('text-align', 'center');
		options.buttons.forEach(function(button_options) {
			if(typeof button_options === 'string') button_options = {'text': button_options};
			if(typeof button_options !== 'object') { _this.dispose(); throw TypeError('"buttons" must supplied as Array of Object or string') };
			var buttonWrapper = $(document.createElement('span')).addClass('btn').addClass('medium');
			var button = (((button_options instanceof Element || button_options instanceof $) && $(button_options)) || $(document.createElement('button')).append(button_options.text)).attr('type', 'button');
			button.on('click', function(e) {
				if(button_options.action && typeof button_options.action === 'function') button_options.action(e);
				if(!e.isDefaultPrevented()) dialogLayer.dialog('close');
			});
			buttonLayer.append(buttonWrapper.append(button)).append(' ');
			if(button_options.default) defaultButton = button;
		});
		dialogLayer.append(buttonLayer);
		defaultButton = defaultButton || dialogLayer.find('button:first-of-type');
	}

	openDialog(options.title, dialogLayer, dialogOptions);
	if(defaultButton) defaultButton.focus();

	_this.dispose = function() {
		dialogLayer.remove();
	}
}

function openSearchSet(id, title){
	var html = "<div class=\"search-form-container\" style='padding:10px;'>";
	html += "<form id='setForm'>";
	html += $("#"+id).html();
	html += "</form>";
	html += "</div>";
	html += "<div style=\"padding-top:10px;\" class=\"center\">";
	html += "<span class=\"btn large black\">";
	html += "<button type=\"submit\" class=\"setBtn\" onclick='settingForm();'>저장하기</button>";
	html += "</span>";
	html += "</div>";
	$('#'+id).html(html);
	openDialog(title+" <span class='desc'>"+title+"을 합니다.</span>", id, {"width":"900","height":"300"});
}

function JSONtoString(object,quote) {
    var results = [];

    if(!quote) quote = '"';

    for (var property in object) {
    	var value = object[property];
    	if (value){
    		if(typeof value == "string") value = quote+value+quote;
    		results.push(quote+property.toString()+quote + ':' + value);
    	}
    }

    return '{' + results.join(', ') + '}';
}

/**
 * 새창으로 팝업을 띄웁니다
 * popup('zoom.php?seq=7',750,550)
 */
function popup(src,width,height,popupId) {
	var scrollbars = "1";
	var resizable = "no";
	if (typeof(arguments[3])!="undefined") scrollbars = arguments[3];
	if (arguments[4]) resizable = "yes";
	if (typeof popupId == 'undefinedd') popupId = '';
	window.open(src,popupId,'width='+width+',height='+height+',scrollbars='+scrollbars+',toolbar=no,status=no,resizable='+resizable+',menubar=no');
}


function sprintf () {
	// Return a formatted string
	//
	// version: 1103.1210
	// discuss at: http://phpjs.org/functions/sprintf    // +   original by: Ash Searle (http://hexmen.com/blog/)
	// + namespaced by: Michael White (http://getsprink.com)
	// +    tweaked by: Jack
	// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// +      input by: Paulo Freitas    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// +      input by: Brett Zamir (http://brett-zamir.me)
	// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// *     example 1: sprintf("%01.2f", 123.1);
	// *     returns 1: 123.10    // *     example 2: sprintf("[%10s]", 'monkey');
	// *     returns 2: '[    monkey]'
	// *     example 3: sprintf("[%'#10s]", 'monkey');
	// *     returns 3: '[####monkey]'
	var regex = /%%|%(\d+\$)?([-+\'#0 ]*)(\*\d+\$|\*|\d+)?(\.(\*\d+\$|\*|\d+))?([scboxXuidfegEG])/g;
	var a = arguments,
		i = 0,
		format = a[i++];

	// pad()
	var pad = function (str, len, chr, leftJustify) {
		if (!chr) {
			chr = ' ';
		}
		var padding = (str.length >= len) ? '' : Array(1 + len - str.length >>> 0).join(chr);
		return leftJustify ? str + padding : padding + str;
	};

	// justify()
	var justify = function (value, prefix, leftJustify, minWidth, zeroPad, customPadChar) {
		var diff = minWidth - value.length;
		if (diff > 0) {
			if (leftJustify || !zeroPad) {
				value = pad(value, minWidth, customPadChar, leftJustify);
			} else {
				value = value.slice(0, prefix.length) + pad('', diff, '0', true) + value.slice(prefix.length);
			}
		}
		return value;
	};
	// formatBaseX()
	var formatBaseX = function (value, base, prefix, leftJustify, minWidth, precision, zeroPad) {
		// Note: casts negative numbers to positive ones
		var number = value >>> 0;        prefix = prefix && number && {
			'2': '0b',
			'8': '0',
			'16': '0x'
		}[base] || '';        value = prefix + pad(number.toString(base), precision || 0, '0', false);
		return justify(value, prefix, leftJustify, minWidth, zeroPad);
	};

	// formatString()
	var formatString = function (value, leftJustify, minWidth, precision, zeroPad, customPadChar) {
		if (precision != null) {
			value = value.slice(0, precision);
		}
		return justify(value, '', leftJustify, minWidth, zeroPad, customPadChar);
	};

	// doFormat()
	var doFormat = function (substring, valueIndex, flags, minWidth, _, precision, type) {
		var number;
		var prefix;
		var method;
		var textTransform;
		var value;
		 if (substring == '%%') { return '%'; }

		// parse flags
		var leftJustify = false,
			positivePrefix = '',
			zeroPad = false,
			prefixBaseX = false,
			customPadChar = ' ';
		var flagsl = flags.length;
		for (var j = 0; flags && j < flagsl; j++) {
			switch (flags.charAt(j)) {
				case ' ':
					positivePrefix = ' ';
					break;
				case '+':
					positivePrefix = '+';
					break;
				case '-':
					leftJustify = true;
					break;
				case "'":
					customPadChar = flags.charAt(j + 1);
					break;
				case '0':
					zeroPad = true;
					break;
				case '#':
					prefixBaseX = true;
					break;
			}
		}

		// parameters may be null, undefined, empty-string or real valued
		// we want to ignore null, undefined and empty-string values
		if (!minWidth) {
			minWidth = 0;
		} else if (minWidth == '*') {
			minWidth = +a[i++];
		} else if (minWidth.charAt(0) == '*') {
			minWidth = +a[minWidth.slice(1, -1)];
		} else {
			minWidth = +minWidth;
		}
		// Note: undocumented perl feature:
		if (minWidth < 0) {
			minWidth = -minWidth;
			leftJustify = true;
		}

		if (!isFinite(minWidth)) {
			throw new Error('sprintf: (minimum-)width must be finite');
		}
		if (!precision) {
			precision = 'fFeE'.indexOf(type) > -1 ? 6 : (type == 'd') ? 0 : undefined;
		} else if (precision == '*') {
			precision = +a[i++];
		} else if (precision.charAt(0) == '*') {
			precision = +a[precision.slice(1, -1)];
		} else {
			precision = +precision;
		}
		// grab value using valueIndex if required?
		value = valueIndex ? a[valueIndex.slice(0, -1)] : a[i++];

		switch (type) {
			case 's':
				return formatString(String(value), leftJustify, minWidth, precision, zeroPad, customPadChar);
			case 'c':
				return formatString(String.fromCharCode(+value), leftJustify, minWidth, precision, zeroPad);
			case 'b':
				return formatBaseX(value, 2, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'o':
				return formatBaseX(value, 8, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'x':
				return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'X':
				return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad).toUpperCase();
			case 'u':
				return formatBaseX(value, 10, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'i':
			case 'd':
				number = (+value) | 0;
				prefix = number < 0 ? '-' : positivePrefix;
				value = prefix + pad(String(Math.abs(number)), precision, '0', false);
				return justify(value, prefix, leftJustify, minWidth, zeroPad);
			case 'e':
			case 'E':
			case 'f':
			case 'F':
			case 'g':
			case 'G':
				number = +value;
				prefix = number < 0 ? '-' : positivePrefix;
				method = ['toExponential', 'toFixed', 'toPrecision']['efg'.indexOf(type.toLowerCase())];
				textTransform = ['toString', 'toUpperCase']['eEfFgG'.indexOf(type) % 2];
				value = prefix + Math.abs(number)[method](precision);
				return justify(value, prefix, leftJustify, minWidth, zeroPad)[textTransform]();
			default:
				return substring;
		}
	};

    return format.replace(regex, doFormat);
}




/**
 * 현재 시각을 Time 형식으로 리턴
 */
function getCurrentTime(date) {
	return toTimeString(new Date(date));
}

/**
 * 자바스크립트 Date 객체를 Time 스트링으로 변환
 * parameter date: JavaScript Date Object
 */
function toTimeString(date) {
	var year  = date.getFullYear();
	var month = date.getMonth() + 1; // 1월=0,12월=11이므로 1 더함
	var day   = date.getDate();

	if (("" + month).length == 1) {month = "0" + month;}
	if (("" + day).length   == 1) {day   = "0" + day;}

	return ("" + year + month + day)
}
/**
 * 현재 年을 YYYY형식으로 리턴
 */
function getYear(date) {
	return getCurrentTime(date).substr(0,4);
}

/**
 * 현재 月을 MM형식으로 리턴
 */
function getMonth(date) {
	return getCurrentTime(date).substr(4,2);
}

/**
 * 현재 日을 DD형식으로 리턴
 */
function getDay(date) {
	return getCurrentTime(date).substr(6,2);
}
//
function getDate(day) {
	var d = new Date();
	var dt = d - day*24*60*60*1000;
	return getYear(dt) + '-' + getMonth(dt) + '-' + getDay(dt);
}
/**
 * 특정일 기준 0day 이전 날짜 계산
*/
function getTheDate(default_date, day) {
	if(default_date == 'today'){
		var d = new Date();
	}else{
		var d = new Date(default_date);
	}
	var dt = d - day*24*60*60*1000;
	return getYear(dt) + '-' + getMonth(dt) + '-' + getDay(dt);
}

/**
 * 콤마 붙이기 함수
 * @param value int
 */
function setComma(nStr) {
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}


/**
 * 신규생성 다이얼로그 창을 띄운다.
 * <pre>
 * 1. createElementContainer 함수를 이용하여 매번 div 태그를 입력하지 않고 다이얼로그 생성시 자동으로 생성한다.
 * 2. refreshTable 함수를 이용하여 다이얼로그 내용 부분을 불러온다.
 * </pre>
 * @param string url 폼화면 주소
 * @param int width 가로 사이즈
 * @param int height 세로 사이즈
 * @param string title 제목
 * @param string btn_yn 'false'이면 닫기버튼만 나타낸다.
 */
function addFormDialog(url, width, height, title, btn_yn, class_name) {
	newcreateElementContainer(title);
	newrefreshTable(url);

	if (btn_yn != 'false') {
		var buttons = {
			'닫기': function() {
				$(this).dialog('close');
			},
			'저장하기': function() {
				$('#form1').submit();
			}
		}
	}
	else if (btn_yn == 'false') {
		var buttons =  [{
			text:"닫기",
			class : class_name,
			click: function() {
				$(this).dialog('close');
			}
		}]
	}
	else if (btn_yn == 'close') {
		var buttons =  {
			'닫기': function() {
				$(this).dialog('close');
			}
		}
	}
	
	if (btn_yn == 'select') {
		var buttons =  [{
			text:"저장",
			class :'resp_btn active size_XL',
			click: function() {
				$('#npayFrm').submit();
				$(this).dialog('close');
			}},
			{
			text:"닫기",
			class : 'resp_btn v3 size_XL',
			click: function() {
				$(this).dialog('close');
			}
		}]		
	}

	// background layer의 z-index는 9999인데 본창의 z-index가 9999보다 낮은 경우가 발생해서 추가함.
	var dialog_zIndex	= $('.ui-dialog').last().css('z-index');
	if	(dialog_zIndex < 9999)	dialog_zIndex	= 10001;
	if( height>0 ) {
		$('#dlg').dialog({
			bgiframe: true,
			autoOpen: false,
			width: width,
			height: height,
			resizable: false,
			draggable: false,
			zIndex: dialog_zIndex,
			modal: true,
			overlay: {
				backgroundColor: '#000000',
				opacity: 0.8
			},
			buttons: buttons,
			open: function() {
					$("#ui-datepicker-div").css("z-index",
					$(this).parents(".ui-dialog").css("z-index")+1);
			}
		}).dialog('open');
	}else{
		$('#dlg').dialog({
			bgiframe: true,
			autoOpen: false,
			width: width,
			resizable: false,
			draggable: false,
			zIndex: dialog_zIndex,
			modal: true,
			overlay: {
				backgroundColor: '#000000',
				opacity: 0.8
			},
			buttons: buttons,
			open: function() {
					$("#ui-datepicker-div").css("z-index",
					$(this).parents(".ui-dialog").css("z-index")+1);
			}
		}).dialog('open');
	}
	return false;
}

function newcreateElementContainer(title) {
	var dlg_title = title ? title : '등록 폼';
	var el = '<div id="dlg" title="' + dlg_title + '"   ><div id="dlg_content" ></div></div>';
	$('#dlg').remove();
	$(el).appendTo('body');
}

function newrefreshTable(url) {
	$.get(url, {}, function(data, textStatus) {
		$('#dlg_content').html(data);
	});
}



function goTwitter(msg,url) {
	var href = "http://twitter.com/intent/tweet?text=" + encodeURIComponent(msg) + " " + encodeURIComponent(url);
	var a = window.open(href, 'twitter', '');
	if ( a ) {
		a.focus();
	}
}
function goMe2Day(msg,url,tag) {
	var href = "http://me2day.net/posts/new?new_post[body]=" + encodeURIComponent(msg) + " " + encodeURIComponent(url) + "&new_post[tags]=" + encodeURIComponent(tag);
	var a = window.open(href, 'me2Day', '');
	if ( a ) {
		a.focus();
	}
}
function goFaceBook(msg,url) {
	var href = "https://www.facebook.com/sharer/sharer.php?u=" + url + "&t=" + encodeURIComponent(msg);
	var a = window.open(href, 'facebook', '');
	if ( a ) {
		a.focus();
	}
}
function goCyWorld(no) {
	var href = "http://api.cyworld.com/openscrap/post/v1/?xu=http://ticketmonster.co.kr/html/cyworldConnectToXml.php?no=" + no +"&sid=suGPZc14uNs4a4oaJbVPWkDSZCwgY8Xe";
	var a = window.open(href, 'cyworldpost', 'width=450,height=410');
	if ( a ) {
		a.focus();
	}
}
function goYozmDaum(link,prefix,parameter) {
	var href = "http://yozm.daum.net/api/popup/post?sourceid=&link=" + encodeURIComponent(link) + "&prefix=" + encodeURIComponent(prefix) + "&parameter=" + encodeURIComponent(parameter);
	var a = window.open(href, 'yozmSend', 'width=466, height=356');
	if ( a ) {
		a.focus();
	}
}

function snsWin(sns, enc_tit, enc_sbj, enc_tag, enc_url, isMobile,imgurl,imgwidth,imgheight)
{
	//짧은주소체크
	var sourturl = enc_url;
	$.ajax({url: '/common/get_shortURL?url='+enc_url,global:false,async: false,dataType: 'json',success: function(data) {if(data) sourturl = data;}});

	var snsset = new Array();
	if(isMobile){
		snsset['tw'] = 'http://twitter.com/intent/tweet?text=' + enc_sbj + '+++' + sourturl;
		snsset['me'] = 'http://me2day.net/plugins/mobile_post/new?new_post[body]=' + enc_sbj + '+++["'+enc_tit+'":' + sourturl + '+]&new_post[tags]='+enc_tag;
		snsset['my']		= 'https://m.mypeople.daum.net/mypeople/mweb/share.do?source_id=' + enc_tit + '&link=' + sourturl + '&prefix=' + enc_sbj;
	}else{
		snsset['tw'] = 'http://twitter.com/intent/tweet?text=' + enc_sbj + '+++' + sourturl;
		snsset['me'] = 'http://me2day.net/posts/new?new_post[body]=' + enc_sbj + '+++["'+enc_tit+'":' + sourturl + '+]&new_post[tags]='+enc_tag+'&redirect_url='+sourturl;
		snsset['my']		= 'https://mypeople.daum.net/mypeople/web/share.do?source_id=' + enc_tit + '&link=' + sourturl + '&prefix=' + enc_sbj;
	}

	snsset['ka'] = 'kakaolink://sendurl?msg=' + enc_sbj + '&url=' + sourturl + '&appid=' + document.domain + '&appver=4.0&type=link&appname=' + enc_tit + '&apiver=2.0';
	snsset['kaapi']		= "api";
	snsset['kakaostory']	= 'storylink://posting?post=' + enc_sbj + '&appid=' + document.domain + '&appver=4.0&apiver=1.0&appname=' + enc_tit + '&urlinfo=' + sourturl + '';
	snsset['go']		= 'https://plus.google.com/share?url=' + sourturl;
	snsset['fa'] = 'https://www.facebook.com/sharer/sharer.php?u=' + sourturl + '&t=' + enc_sbj;
	snsset['yo'] = "http://yozm.daum.net/api/popup/prePost?link=" + sourturl + "&prefix=" + enc_sbj + "&parameter=" + sourturl;

	snsset['pi'] = '';//이미지전용
	snsset['na'] = 'http://api.nateon.nate.com/web/note/SendNote.do?msg='+enc_sbj+ '&lurl='+sourturl;
	snsset['cy'] = 'http://csp.cyworld.com/bi/bi_recommend_pop.php?title='+enc_tit+ '&url='+sourturl+ '&thumbnail='+imgurl+ '&summary='+enc_sbj;
	snsset['line']		= 'http://line.me/R/msg/text/?' + enc_sbj + '%0D%0A' + sourturl;

	if( snsset[sns] ) {
		if(sns == 'ka'){//app link copy
			executeURLLink(enc_sbj, enc_tit, sourturl,isMobile);
		}else if(sns == 'kaapi'){
			sendKakaotalk(enc_sbj, enc_tit, enc_url,imgurl,imgwidth,imgheight);
		}else if(sns == 'kakaostory'){
			sendKakaostorynew(enc_sbj, enc_tit, sourturl,isMobile,imgurl);
		}else{
			var a = window.open(snsset[sns], "SnsWinUp"+sns);
			if ( a ) {
				a.focus();
			}
		}
	}
}

//카카오스토리연동
function sendKakaostorynew(enc_sbj, enc_tit, enc_url,isMobile,imgurl)
{
	var appid = 'http://' + document.domain;
	kakaostorynew.link("story").send({
        post : enc_url,
        appid : appid,
        appver : "1.0",
        appname : enc_tit,
        urlinfo : JSON.stringify({title:enc_sbj, imageurl:[imgurl], type:"article"})
    });
}



//카카오톡 연결
function sendKakaotalk(enc_sbj, enc_tit, enc_url,imgurl,imgwidth,imgheight)
{
	if(imgurl && imgwidth >= 81 && imgheight >= 81) {
	Kakao.Link.createTalkLinkButton({
	container: '.kakao-link-btn',
	label: enc_tit,
	image: {
	src: imgurl,
	width: imgwidth,
	height: imgheight
	},
	webButton: {
	text: enc_sbj,
	url: enc_url
	}
		});
	}else{
		Kakao.Link.createTalkLinkButton({
		container: '.kakao-link-btn',
		label: enc_tit,
		webButton: {
		text: enc_sbj,
		url: enc_url
		}
		});
	}
	// 앱 설정의 웹 플랫폼에 등록한 도메인의 URL이어야 합니다. 개발자 사이트에 등록한 웹사이트 중 첫번째 URL
}

function executeURLLink(enc_sbj, enc_tit, enc_url,isMobile,imgurl)
{
	if ( !isMobile ) {
		//PC에서 접속한 경우에는 작동하지 않습니다.\n\n카카오톡이 설치된 아이폰/안드로이드폰등으로 접속하는 경우에만 사용 가능합니다.
		alert( getAlert('et070') );
		return;
	}
    /*
    msg, url, appid, appname은 실제 서비스에서 사용하는 정보로 업데이트되어야 합니다.
    */
	var appid = location.protocol+'://' + document.domain;
    kakao.link("talk").send({
        msg : enc_sbj,
        url : enc_url,
        appid : appid,
        appver : "2.0",
        appname : enc_tit,
        type : "link"
    });

}

//데모경고창
function servicedemoalert(e) {
	if( e.name == "use_f"  ||e.name == "use_t" ) {
		$("input[name="+e.name+"]").attr("checked",'checked');
	}else if( e.type == "checkbox" ) {
		$("input[name="+e.name+"]").attr("checked",'');
		$("input[name="+e.name+"]").removeAttr("checked");
	}else if( e.type == "file" ) {
		$("input[name="+e.name+"]").attr("disabled","disabled");
	}

	$.ajax({
		type: "get",
		url: "/admin/main/main_demo",
		success: function(result){
			$("#main_demo").html(result);
			openDialog("제한 기능 안내", "main_demo", {"width":"700","height":"700","show" : "fade","hide" : "fade"});
		}
	});

	//alert( "type:" + e.type + "/name:" + e.name );
	//alert( '체험 사이트에서는 해당 기능을 제공하지 않습니다.' );
	return;
}


//무료몰업그레이드
function serviceUpgrade(){
	window.open('https://firstmall.kr/ec_hosting/addservice/upgrade.php','','');
}
//무료몰 > 게시판추가
function serviceBoardAdd(){
	$.get('board_payment', function(data) {
		var target = $(document.createElement('div')).html(data);
		openDialog("게시판 추가 신청", target, {
			width: 800,
			height: 650,
		}, function() {
			$(target).dialog('destroy').remove();
		});
		$(document.forms['gabiaFrm']).submit();
	});
}

function htmlspecialchars(str) {
	if (typeof(str) == "string") {
		str = str.replace(/&/g, "&amp;"); /* must do &amp; first */
		str = str.replace(/"/g, "&quot;");
		str = str.replace(/'/g, "&#039;");
		str = str.replace(/</g, "&lt;");
		str = str.replace(/>/g, "&gt;");
	}
	return str;
}

//flash(파일주소, 가로, 세로, 배경색, 윈도우모드, 변수, 경로)
function flash(url,w,h,bg,win,vars,base,target){
	var s=
	"<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='"+w+"' height='"+h+"' align='middle'>"+
	"<param name='allowScriptAccess' value='always' />"+
	"<param name='movie' value='"+url+"' />"+
	"<param name='wmode' value='transparent' />"+
	"<param name='menu' value='false' />"+
	"<param name='quality' value='high' />"+
	"<param name='FlashVars' value='"+vars+"' />"+
	"<param name='bgcolor' value='"+bg+"' />"+
	"<param name='base' value='"+base+"' />"+
	"<embed src='"+url+"' base='"+base+"' wmode='transparent' menu='false' quality='high' bgcolor='"+bg+"' width='"+w+"' height='"+h+"' align='middle' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />"+
	"</object>";

	$('.'+target).html(s);
}

function isNumber(s) {
	s += ''; // 문자열로 변환
	s = s.replace(/^\s*|\s*$/g, ''); // 좌우 공백 제거
	if (s == '' || isNaN(s)) return false;
	return true;
}

function uniqid (prefix, more_entropy) {
	  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	  // +    revised by: Kankrelune (http://www.webfaktory.info/)
	  // %        note 1: Uses an internal counter (in php_js global) to avoid collision
	  // *     example 1: uniqid();
	  // *     returns 1: 'a30285b160c14'
	  // *     example 2: uniqid('foo');
	  // *     returns 2: 'fooa30285b1cd361'
	  // *     example 3: uniqid('bar', true);
	  // *     returns 3: 'bara20285b23dfd1.31879087'
	  if (typeof prefix == 'undefined') {
	    prefix = "";
	  }

	  var retId;
	  var formatSeed = function (seed, reqWidth) {
	    seed = parseInt(seed, 10).toString(16); // to hex str
	    if (reqWidth < seed.length) { // so long we split
	      return seed.slice(seed.length - reqWidth);
	    }
	    if (reqWidth > seed.length) { // so short we pad
	      return Array(1 + (reqWidth - seed.length)).join('0') + seed;
	    }
	    return seed;
	  };

	  // BEGIN REDUNDANT
	  if (!this.php_js) {
	    this.php_js = {};
	  }
	  // END REDUNDANT
	  if (!this.php_js.uniqidSeed) { // init seed with big random int
	    this.php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
	  }
	  this.php_js.uniqidSeed++;

	  retId = prefix; // start with prefix, add current milliseconds hex string
	  retId += formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);
	  retId += formatSeed(this.php_js.uniqidSeed, 5); // add seed hex string
	  if (more_entropy) {
	    // for more entropy we add a float lower to 10
	    retId += (Math.random() * 10).toFixed(8).toString();
	  }

	  return retId;
}


//정식 오픈그라피>바로구매시 적용
function getfbopengraph(gdseq, type, urldomain, id)
{

	 if (document.location.protocol == "https:") {
		var url = 'https://'+urldomain+'/sns_process/fbopengraph';
	 }else{
	var url = 'http://'+urldomain+'/sns_process/fbopengraph';
	 }
	$.getJSON(url + "?no="+gdseq+"&id="+id+"&type="+type+"&jsoncallback=?");
}

//페이스북>me/feed 글남기기
function getfbmefeed(boardseq, type, urldomain, boardid)
{
	 if (document.location.protocol == "https:") {
		var url = 'https://'+urldomain+'/sns_process/fbmefeed';
	 }else{
		var url = 'http://'+urldomain+'/sns_process/fbmefeed';
	 }
	$.getJSON(url + "?no="+boardseq+"&id="+boardid+"&type="+type+"&jsoncallback=?");
}


function chkByte(str){
	var cnt = 0;
	for(i=0;i<str.length;i++) {
		cnt += str.charCodeAt(i) > 128 ? 2 : 1;
		if(str.charCodeAt(i)==10) cnt++;
	}
	return cnt;
}

//단독이벤트 남은 시간
function showClockTime(numberType, year, month, day, hour, min, second, dayDiv, hourDiv, minDiv, secondDiv, goods_seq, classType){
	var close_date = new Date(year, month-1, day, hour, min, second);
	var close_timestamp = Math.floor(close_date.getTime()/1000);
	var now_timestamp = Math.floor((new Date()).getTime()/1000);
	var remind_timestamp = close_timestamp - now_timestamp;

	if(remind_timestamp<0) {
		return;
	}

	var remind_days = Math.floor(remind_timestamp/86400);
	var remind_hours = Math.floor((remind_timestamp - (86400 * remind_days))/3600);
	var remind_minutes = Math.floor((remind_timestamp - ((86400 * remind_days) + (3600 * remind_hours))) / 60);
	var remind_seconds = remind_timestamp%60;
	var day="";
	var hour="", min="", second="";

	if(numberType == "img"){
		if (remind_days > 0){
			day = "";
			for(var i=0;i<remind_days.toString().length;i++){
				day += "<img src='/data/icon/goods/social_no"+remind_days.toString().substring(i,i+1)+".png'>";
			}
			$('.'+dayDiv).html(day);
		}else{
			day = "<img src='/data/icon/goods/social_no0.png'>";
			$('.'+dayDiv).html(day);
		}

		// 시간처리
		if (remind_hours > -1){
			if (remind_hours < 10){
				hour = "<img src='/data/icon/goods/social_no0.png'><img src='/data/icon/goods/social_no"+Math.floor(remind_hours % 10)+".png'>";
			} else {
				hour = "<img src='/data/icon/goods/social_no"+Math.floor(remind_hours / 10)+".png'>";
				hour += "<img src='/data/icon/goods/social_no"+Math.floor(remind_hours % 10) +".png'>";
			}
			$('.'+hourDiv).html(hour);
		}

		// 분처리
		if (remind_minutes > -1){
			if (remind_minutes < 10){
				min = "<img src='/data/icon/goods/social_no0.png'><img src='/data/icon/goods/social_no"+Math.floor(remind_minutes % 10)+".png'>";
			} else {
				min = "<img src='/data/icon/goods/social_no"+Math.floor(remind_minutes / 10)+".png'>";
				min += "<img src='/data/icon/goods/social_no"+Math.floor(remind_minutes % 10)+".png'>";
			}
			$('.'+minDiv).html(min);
		}

		// 초처리
		if (remind_seconds > -1){
			if (remind_seconds < 10){
				second = "<img src='/data/icon/goods/social_no0.png'><img src='/data/icon/goods/social_no"+Math.floor(remind_seconds % 10)+".png'>";
			} else {
				second = "<img src='/data/icon/goods/social_no"+Math.floor(remind_seconds / 10)+".png'>";
				second += "<img src='/data/icon/goods/social_no"+Math.floor(remind_seconds % 10)+".png'>";
			}
			$('.'+secondDiv).html(second);
		}
	}else{
		remind_hours = strRight("0"+remind_hours, 2);
		remind_minutes = strRight("0"+remind_minutes, 2);
		remind_seconds = strRight("0"+remind_seconds, 2);
		if(classType == 'class'){
			$('.'+dayDiv).html(remind_days);
			$('.'+hourDiv).html(remind_hours);
			$('.'+minDiv).html(remind_minutes);
			$('.'+secondDiv).html(remind_seconds);
		}else{
			$('#'+dayDiv).html(remind_days);
			$('#'+hourDiv).html(remind_hours);
			$('#'+minDiv).html(remind_minutes);
			$('#'+secondDiv).html(remind_seconds);
		}
	}

	return remind_timestamp;

}


function strRight(Str, Num){
	if(Num <= 0){
		return "";
	}else if(Num > String(Str).length){
		return Str;
	}else{
		var iLen = String(Str).length;
		return String(Str).substring(iLen, iLen-Num);
	}
}

function strstr (haystack, needle, bool) {
  // From: http://phpjs.org/functions
  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Onno Marsman
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // *     example 1: strstr('Kevin van Zonneveld', 'van');
  // *     returns 1: 'van Zonneveld'
  // *     example 2: strstr('Kevin van Zonneveld', 'van', true);
  // *     returns 2: 'Kevin '
  // *     example 3: strstr('name@example.com', '@');
  // *     returns 3: '@example.com'
  // *     example 4: strstr('name@example.com', '@', true);
  // *     returns 4: 'name'
  var pos = 0;

  haystack += '';
  pos = haystack.indexOf(needle);
  if (pos == -1) {
    return false;
  } else {
    if (bool) {
      return haystack.substr(0, pos);
    } else {
      return haystack.slice(pos);
    }
  }
}

function rgb2hex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

// 배송사 배송조회 링크 추출
var delivery_url_list	= '';
function get_delivery_url_list(codecd, delivery_code, target, provider_seq){
	if	(typeof(provider_seq) == 'undefined') provider_seq = 1;
	$.getJSON("/common/get_delivery_url", {'provider_seq':provider_seq}, function(result){
		delivery_url_list	= result;
		open_search_delivery(codecd, delivery_code, target, provider_seq);
	});
}

// 배송사 배송조회 링크 전송
var chk_search	= '';
function open_search_delivery(codecd, delivery_code, target, provider_seq){
	if	(typeof(provider_seq) == 'undefined') provider_seq = 1;

	if	(!delivery_url_list){
		get_delivery_url_list(codecd, delivery_code, target, provider_seq);
	}else{
		var url	= delivery_url_list[codecd];
		if	(!url) {
			if(chk_search == 'Y'){
				//조회할수 없습니다.
				alert(getAlert('et071'));
				return;
			}
			chk_search = 'Y';
			get_delivery_url_list(codecd, delivery_code, target, provider_seq);
			url	= delivery_url_list[codecd];
		}else{
			if	(url && delivery_code){
				url	= url + delivery_code.replace(/[^0-9a-zA-Z]/g, '');
				if	(target){
					eval(target+'.location.href="'+url+'";');
				}else{
					window.open(url);
				}
			}else{
				alert(getAlert('et071'));
			}
		}
	}
}

// 동적 폼 생성 및 Submit
var DomSaver	= function(fDivId, fMethod, fAction, fTarget){
	this.fDivId		= fDivId;
	this.fMethod	= fMethod;
	this.fAction	= fAction;
	this.fTarget	= fTarget;
	this.sTarget	= '';
	this.saveStatus	= 'null';
};
DomSaver.prototype.setTarget	= function(obj){
	this.sTarget	= obj;
	this.saveStatus	= 'ready';
};
DomSaver.prototype.sendValue	= function(val){
	if	(this.saveStatus == 'ready'){

		// 해당 ID의 Div 객체 생성 및 초기화
		var oDiv		= document.getElementById(this.fDivId);
		oDiv.innerHTML	= '';

		// form 생성
		var oForm		= document.createElement('form');
		oForm.method	= this.fMethod;
		oForm.action	= this.fAction;
		if	(this.fTarget)	oForm.target	= this.fTarget;

		// input 생성
		var oInput		= '';
		for (var k in val){
			oInput			= '';
			oInput			= document.createElement('input');
			oInput.setAttribute('type', 'hidden');
			oInput.setAttribute('name', k);
			oInput.setAttribute('value', val[k]);
			oForm.appendChild(oInput);
		}

		// form 추가 및 submit
		oDiv.appendChild(oForm);
		oForm.submit();

		// this.saveStatus를 초기화
		this.saveStatus	= '';
	}
};



//쿠폰받기
//반응형 분리되어있는 function 하나로 합침 2020-06-09
function coupondownlist(gl_goods_seq,gl_request_uri,gl_coupon_seq)
{
	title = getAlert('gv015');
	if( gl_operation_type == "light" || gl_mobile_mode == true) {
		$('div#couponDownloadDialogId').dialog('close');
		$('div#couponDownloadDialogBgId').dialog('close');
		$.ajax({
			'global' : false,
			'url':'../coupon/goods_coupon_list?no='+gl_goods_seq+'&return_url='+gl_request_uri+'&coupon='+gl_coupon_seq,
			'type' : 'get',
			'cache' : false,
			'success' : function(couponDownload){
				try{
					coupondownlist_view(couponDownload);					
				}catch(ex){}
				echo.init({
					offset: 100,
					throttle: 250,
					unload: false
				});
			}
		});
	}else{
		$('div#couponDownloadDialog').dialog('close');
		$.get('../coupon/goods_coupon_list?no='+gl_goods_seq+'&return_url='+gl_request_uri+'&coupon='+gl_coupon_seq, function(data) {
			$("div#couponDownloadDialog").html(data);
		});
		openDialog(title, "couponDownloadDialog", {"width":700});
	}
}
function coupondownlist_view(couponDownload) {
	
	if(gl_operation_type == "light" ) {
		$("body").append("<div id='couponDownloadDialogId' class='resp_layer_pop'></div>");
		var iframe = '<h4 class="title">'+title+'</h4>';
		iframe += '<div id="couponDownloadMobile" class="y_scroll_auto2">';
		iframe += '<div class="layer_pop_contents v5">';
		iframe += couponDownload;
		iframe += '</div>';
		iframe += '</div>';
		iframe += '<div class="layer_bottom_btn_area2"><button type="button" class="btn_resp size_c color5 Wmax" onclick="closeDialogCoupon()">닫기</button></div>';
		iframe += '<a href="javascript:void(0)" class="btn_pop_close" onclick="closeDialogCoupon()"></a>';
		$("#couponDownloadDialogId").html(iframe);
		showCenterLayer( '#couponDownloadDialogId' );
	} else {// 모바일모드
		var sheight = $('body').prop("scrollHeight");
		$("body").append("<div id='couponDownloadDialogBgId' style='position:absolute;top:0px;background:#000;width:100%;height:"+sheight+"px;z-index:10005;visibility:visible;filter:alpha(opacity=30); opacity:0.3; -moz-opacity:0.3;'></div>");
		$("body").append("<div id='couponDownloadDialogId' style='position:absolute;top:0px;background:#fff;width:100%;height:auto;z-index:10006'></div>");
		var iframe = '<div class="sub_division_title">'+title+'<div class="sub_division_arw sub_division_arw_x" onclick="javascript:closeDialogCoupon()"></div></div>';
		iframe += '<div style="height:auto:" id="couponDownloadMobile" >';
		iframe += couponDownload;
		iframe += '</div>';
		$("#couponDownloadDialogId").html(iframe);
		$(window).scrollTop(0);
	}
}
//쿠폰받기 - 반응형
// skin 에서 호출하기 때문에 coupondownlist_res 삭제는 하지 못함 .... 2020-06-09
function coupondownlist_res(gl_goods_seq,gl_request_uri)
{
	coupondownlist(gl_goods_seq,gl_request_uri);
}

//코드보기
function codesalelist(gl_goods_seq,gl_request_uri)
{
	title = getAlert('gv061');
	if(typeof gl_mobile_mode!="undefined" && gl_mobile_mode){//모바일모드

		$('div#couponDownloadDialogId').dialog('close');
		$('div#couponDownloadDialogBgId').dialog('close');
		var sheight = $('body').prop("scrollHeight");
		$.ajax({
			'global' : false,
			'url':'../promotion/goods_code_list?no='+gl_goods_seq+'&return_url='+gl_request_uri,
			'type' : 'get',
			'cache' : false,
			'success' : function(couponDownload){
				try{
					$("body").append("<div id='couponDownloadDialogBgId' style='position:absolute;top:0px;background:#000;width:100%;height:"+sheight+"px;z-index:10005;visibility:visible;filter:alpha(opacity=30); opacity:0.3; -moz-opacity:0.3;'></div>");
					$("body").append("<div id='couponDownloadDialogId' style='position:absolute;top:0px;background:#fff;width:100%;height:auto;z-index:10006'></div>");
					var iframe = '<div class="sub_division_title">'+title+'<div class="sub_division_arw sub_division_arw_x" onclick="javascript:closeDialogCoupon()"></div></div>';
					iframe += '<div style="height:auto:" id="couponDownloadMobile" >';
					iframe += couponDownload;
					iframe += '</div>';
					$("#couponDownloadDialogId").html(iframe);
					$(window).scrollTop(0);
				}catch(ex){}
				echo.init({
					offset: 100,
					throttle: 250,
					unload: false
				});
			}
		});
	}else{
		$('div#codeSaleDialog').dialog('close');
		$.get('../promotion/goods_code_list?no='+gl_goods_seq+'&return_url='+gl_request_uri, function(data) {
			$("div#couponDownloadDialog").html(data);
		});
		openDialog(title, "couponDownloadDialog", {"width":700});
	}
}
//코드보기 - 반응형
function codesalelist_res(gl_goods_seq,gl_request_uri)
{
	title = getAlert('gv061');
	$('div#couponDownloadDialogId').dialog('close');
	$('div#couponDownloadDialogBgId').dialog('close');
	var sheight = $('body').prop("scrollHeight");
	$.ajax({
		'global' : false,
		'url':'../promotion/goods_code_list?no='+gl_goods_seq+'&return_url='+gl_request_uri,
		'type' : 'get',
		'cache' : false,
		'success' : function(couponDownload){
			try{
				$("body").append("<div id='couponDownloadDialogId' class='resp_layer_pop'></div>");
				var iframe = '<h4 class="title">'+title+'</h4>';
				iframe += '<div id="couponDownloadMobile" class="y_scroll_auto2">';
				iframe += '<div class="layer_pop_contents v5">';
				iframe += couponDownload;
				iframe += '</div>';
				iframe += '</div>';
				iframe += '<div class="layer_bottom_btn_area2"><button type="button" class="btn_resp size_c color5 Wmax" onclick="closeDialogCoupon()">닫기</button></div>';
				iframe += '<a href="javascript:void(0)" class="btn_pop_close" onclick="closeDialogCoupon()"></a>';
				$("#couponDownloadDialogId").html(iframe);
				showCenterLayer( '#couponDownloadDialogId' );
			}catch(ex){}
			echo.init({
				offset: 100,
				throttle: 250,
				unload: false
			});
		}
	});
}

function closeDialogCoupon()
{
	$("div#couponDownloadDialogId, .resp_layer_bg").remove();
	$("div#couponDownloadDialogBgId").remove();
	$('body').css( 'overflow', 'auto' );
}

//비밀번호 변경
function popup_change_pass(){
	if (typeof gl_operation_type != 'undefined' && gl_operation_type == 'light') {
		showCenterLayer('#popupChangePassword');
	} else {
		openDialog(getAlert('mb188'), "popupChangePassword", {"width":500,"height":250, "noClose":true});
	}
}

function close_popup_change(){
	if (typeof gl_operation_type != 'undefined' && gl_operation_type == 'light') {
		hideCenterLayer();
	} else {
		closeDialog('popupChangePassword');
	}
}

function update_rate_checked(){
	//나중에 하기 클릭 시....비활성화
	if($("input[name='update_rate']").attr("checked")){
		$("input[name='old_password']").val('');
		$("input[name='new_password']").val('');
		$("input[name='re_new_password']").val('');
		$(".passwordField").attr("disabled",true);
	}else{
		$(".passwordField").attr("disabled",false);
	}

}


function passwordAfterUpdate(){
	$("input[name='password_mode']").val('after');
	$('#passUpdateForm').submit();
}

function sms_replace(str){
	str = str.replace("{userName}","홍길동");
	return str
}

// 현재 페이지 인쇄
function thisPagePrint(){
	if	(window.matchMedia) {
		var mediaQueryList = window.matchMedia('print');
		mediaQueryList.addListener(function(mql) {
			if (mql.matches) {	$('.unprints').hide();	} else {	$('.unprints').show();	}
		});
	}

	window.onbeforeprint	= function(){	$('.unprints').hide();	}
	window.onafterprint		= function(){	$('.unprints').show();	}
	window.print();
}

function viewCrm(mseq){
	window.open("/admincrm/main/index?member_seq="+mseq);
}

function changeCrm(mseq){
	top.location.href="/admincrm/main/user_detail?member_seq="+mseq;

}

// 파일찾기 메시지 박스처리
function chagne_file_msg(obj){
	var bobj = $(obj);
	var mobj = bobj.closest("span.filebox").parent().find(".filebox_msg");
	if( bobj.val() ){
		mobj.html('선택됨');
	}
}

/* 멀티/글로벌 통화기준 관련 처리 */
function get_currency_price(price,mode,currency,currency_symbol,currency_symbol_position,pmode,replace_str){

	if(typeof(pmode) == "undefined"){ pmode = ""; }

	if(!currency) currency = "basic";
	if(currency == "basic"){
		currency					= gl_basic_currency;
		currency_symbol				= gl_basic_currency_symbol;
		currency_symbol_position	= gl_basic_currency_symbol_position;
	}else if(currency == "skin"){
		currency					= gl_skin_currency;
		currency_symbol				= gl_basic_currency_symbol;
		currency_symbol_position	= gl_basic_currency_symbol_position;
	}

	price = get_cutting_price(price,currency,pmode);

	if(currency == "KRW" || currency == "JPY"){
		if(mode != 1){
			price = comma(price);
		}else{
			price = price;
		}
	}else{
		if(price){
			price = ""+price+"";
			var tmp = price.split(".");
			if(tmp[1]){
				price = tmp[0] + rpad("."+tmp[1],3,"0");
			}else{
				price = price + ".00";
			}
			//price = eval(price);
		}else{
			price = 0;
		}
	}
	
	// 치환처리
	if(replace_str){
		price = replace_str.replace("_str_price_",price);
	}

	if(mode == 2){
		if(currency_symbol_position == "before"){
			price = currency_symbol + "" + price;
		}else if(currency_symbol_position == "after"){
			price =  price + "" + currency_symbol;
		}
	}else if(mode == 3){
		if(currency_symbol_position == "before"){
			price = currency_symbol + price;
		}else if(currency_symbol_position == "after"){
			price =  price + currency_symbol;
		}
	}

	return price;
}

// currency			: 통화
// exchange_rate	: currency 기준 환율
// 비교통화 환율 적용 금액
function get_currency_exchange(price,currency,exchange_rate){

	if(!currency){
		currency		= gl_basic_currency;
	}
	if(!exchange_rate){
		exchange_rate	= gl_currency_exchange;
	}

	var basic_amout		= gl_amout_list[currency];	//기본통화의 환율 기준액
	var return_price	= 0;
	return_price		= price / basic_amout * exchange_rate;
	//return_price		= get_currency_price(return_price,'',gl_basic_currency);

	return return_price;
}


// 멀티/글로벌 환율
function get_compare_currency(price){

	var compare_price = {'KRW':1000,'CNY':500,'JPY':1200};
	var compare_data = {};

	for(var key in compare_price){
		price				= price * compare_price[key];
		compare_data[key]	= get_currency_price(price,1,key);
	}

	return compare_data;
}


// 기본 절사처리(기본통화 기준) @2016-05-25 pjm
function get_cutting_price(price,currency,mode){

	if(!mode) mode = "backoffice";

	if(!currency) currency = 'basic';
	if(currency == "basic"){
		currency = gl_basic_currency;
	}else if(currency == "skin"){
		currency = gl_skin_currency;
	}

	var reg = /,/;
	if(price != "" && reg.test(price)){
		price = price.replaceAll(",","");
	}

	//backoffice용 : 원화,엔화 소수점 버림/ 그외 소수점 3째자리 버림.
	if(mode == "backoffice"){
		if(currency == "KRW" || currency == "JPY"){
			price = Math.floor(price);
		}else{
			price = Math.floor(price * 100) / 100;
		}
	//front용 : 설정 > 상점관리 설정 기준.
	}else{

		$.ajax({
			url		: '/common/get_front_cutting_price',
			async	: false,
			data	: {'price':price,'currency':currency},
			success	: function(res){
				price = res;
			}
		});
	}

	return price;
}

function get_front_cutting_price(price,currency){

	return $.ajax({
		'url' : '/common/get_front_cutting_price',
		'data' : {'price':price,'currency':currency}
	});

}

// 희망 배송일 달력 팝업 :: 2016-07-22 lwh
function hop_calendar_pop(grp_seq, set_seq){
	var cal_lay	= $(".hopCalendarLayer");
	var hop_select_date = $("#hop_select_date").val();
	if(cal_lay.css('display') == 'block'){ cal_lay.hide(); return false; }
	$.ajax({
		'url' : '/goods/hop_calendar_pop',
		'data' : {'grp_seq':grp_seq,'set_seq':set_seq,'hop_select_date':hop_select_date},
		'success' : function(html){
			if(html){
				cal_lay.html(html);
				cal_lay.show();
			}else{
				alert('달력생성에 실패하였습니다.');
			}
		}
	});
}

// 희망배송일 변경
function chg_hopdate(hop_date){
	$("#hop_select_date").val(hop_date);
	var myDate = new Date(hop_date);
	$(".hop_view_date").html('(' + (myDate.getMonth()+1) + '/' + myDate.getDate() + ')');
}

// javascript 용 STR_PAD :: 2016-07-29 lwh
function pad_zero(str,max,type){
	str = str + "";
	if(str.length < max){
		if(type == 'right'){
			str = str+"0";
		}else{
			str = "0" + str;
		}
		pad_zero(str, max);
	}else{
		return str;
	}

	return str.length < max ? pad_zero("0" + str, max) : str;
}


function rpad(originalstr, length, strToPad) {

	while (originalstr.length < length) originalstr = originalstr + strToPad;

	return originalstr;
}

/*
	app/javascript/js/L10n_KOR.js
	arg1 = code
	arg2 = string, array
*/
if(!$.isFunction("getAlert")){
function getAlert(code,args){
	if	(!code) return;
	var ret = L10n[code];
	if	(!ret || ret == undefined) return '';
	ret = ret.replace(/%n/g, '\n');
	ret = ret.replace(/%b/g, '<br />');

	if	(ret.indexOf('%s') >  -1) {
		str_len				= ret.match(/%s/g).length;
		arr_len				= $.isArray(args) ? args.length : 1;

		if	(str_len > arr_len) {
			if	(!$.isArray(args)) {
				args_temp	= args;
				args		= new Array();
				args.push(args_temp);
				arr_len		= 1;
			}
			for	( i=0; i<str_len-arr_len; i++ ) args.push('');
		}

		if	(args == undefined) args = '';

		ret = $.isArray(args) ? $.vsprintf(ret, args) : sprintf(ret, args);
	}

	if	(ret == undefined) ret = '';

	return ret;
}
}

function detailDescriptionLayerClose(idx){
	$('.detailDescriptionLayerCloseBtn.'+idx).parent().parent().parent().find('div.detailDescriptionLayer').toggle();
}

/*
	언어별 validation 간단 입력 체크
*/
function validationCheck(area){

	var required_full_text	= new Array();
	var result				= true;
	var exception			= ['order_cellphone[]','international_recipient_cellphone[]','recipient_cellphone[]','recipient_input_cellphone[]'];
	var selector			= $("input, select, textarea");

	if	(area != 'all')
		selector			= $("input, select, textarea",$('.'+area));

	required_full_text['KR'] = "%s 항목은 필수입니다.";
	required_full_text['US'] = "The %s field is required.";
	required_full_text['CN'] = "The %s field is required.";
	required_full_text['JP'] = "The %s field is required.";

	selector.each(function(){

		var required = $(this).attr("required");

		if(typeof required != 'undefined'){

			var title = $(this).attr("title");
			var value = $(this).val().trim();

			if( $.inArray($(this).attr("name"), exception) > -1 )
				title = $(this).attr("valid");

			if(typeof title == 'undefined'){ title = $(this).attr("name"); }

			if	(required_full_text[gl_language])
				title = required_full_text[gl_language].replace("%s",title);

			if(value == ''){
				var that = $(this);
				$(this).addClass("bg_yellow");
				openDialogAlert(title,400,150,function(){
					var obj_y = $(that).offset().top - $(window).scrollTop();
					var scroll_pos = 150 - obj_y;
					if(scroll_pos > 0){
						$('html, body').animate({scrollTop : scroll_pos});
					}
					$(that).focus();
					//address_modify('delivery');
					//address_modify('order');
				});
				result = false;
				return false;
			}else{
				$(this).removeClass("bg_yellow");
			}
		}

	});

	return result;

}

function check_is_admin(){
	url			= location.href;
	url_arr		= url.split('/');
	ret			= false;
	if	($.inArray('admin',url_arr) > -1)
		ret		= true;
	return ret;
}

function open_bigdata_quide(){
	html ='<div id="lay_bigdata_quide">';
	html +='<ul class="bullet_hyphen resp_message left mt0">';
	html +='<li>페이지별 해당 고객이 보고있는 상품의 기준은 아래와 같습니다.</li>';
	html +='<li>페이지별 기준 상품이 없을 경우 추천상품 영역을 보이지 않습니다</li>';
	html +='</ul>';
	html +='<table class="table_basic mt10">';
	html +='<colgroup><col width="30%"><col width="70%"></colgroup>';
	html +='<tr><th>페이지</th><th>해당 고객이 보고있는 상품</th></tr>';
	html +='<tr><th>검색 페이지</th><td class="center">검색결과 최상위 상품</td></tr>';
	html +='<tr><th>카테고리 페이지</th><td class="center">카테고리 페이지 최상위 상품</td></tr>';
	html +='<tr><th>브랜드 페이지</th><td class="center">브랜드 페이지 최상위 상품</td></tr>';
	html +='<tr><th>지역 페이지</th><td class="center">지역 페이지 최상위 상품</td></tr>';
	html +='<tr><th>상품상세 페이지</th><td class="center">상품상세 페이지 상품</td></tr>';
	html +='<tr><th>장바구니</th><td class="center">장바구니에 담긴 최상위 상품</td></tr>';
	html +='<tr><th>위시리스트</th><td class="center">위시리스트에 담긴 최상위 상품</td></tr>';
	html +='<tr><th>주문완료 페이지</th><td class="center">주문 완료된 최상위 상품</td></tr>';
	html +='</table>';
	html +='</div>';
	openDialogAlerttitle('<span class="fm_default_font">추천상품 노출 페이지별 해당 고객이 보고 있는 상품 기준</span>',html,'800','560',function(){});
}

//장바구니 개선 스크립트
//가격정보 설정
function setPriceInfo(){
	var checkGoods = '';
			var checkCartSeqs = '';

	$('input[name*="cart_option_seq"]').each(function(){
		if($(this).attr('checked') == 'checked'){
			var goodsSeq = $(this).attr('rel');
			checkGoods += goodsSeq + '||';
			checkCartSeqs += $(this).val() + '||';
		}
	});

	var nation = $('input[name=nation]').val();

	//장바구니 데이터 json 호출
	$.ajax({
		url : '/order/cart_price',
		dataType : 'json',
		data : {'goodsSeq' : checkGoods, 'nation' : nation, 'checkCartSeqs' : checkCartSeqs},
		type : 'post' ,
		async : false,
		success : function (data){
			setCartPriceInfo(data);
		},
		error : function (e){
			alert('error : ' + e);
		}
	});
}

//전체 체크시 금액 계산 스크립트
function setPriceInfoCheck(){
	var trueChk = 0;
	$('input[name*="cart_option_seq"]').each(function(){
		if($(this).attr('checked') == 'checked'){
			trueChk++;
		}
	});

	if(trueChk == 0){
		/**
		 * 20210408 : kjw
		 * 기존, gl_set_mode 만 mobile 검사를 진행하여 반응형 모바일 웹에서도 테두리의 색상을 변경하고 디자인이 깨지는 문제가 발생
		 * 따라서, gl_operation_type 을 같이 검사함에 따라, 전용스킨-모바일 버전에서만 아래 로직이 타도록 수정
		 */
		if(gl_set_mode == 'mobile' && gl_operation_type != 'light') { // 전용스킨-모바일
			$("form#cart_form input[name='cart_option_seq[]']").eq(0).attr('checked',true).closest("div").addClass("ez-checkbox-on");
			var cartOptionSeq = $("form#cart_form input[name='cart_option_seq[]']").eq(0).val();

			/**
			 * 20210408 : kjw
			 * 배송 가능 상품 여부에 따른 테두리 색상 변경로직 추가
			 */
			var ship_possible_flag = $("input[name='ship_possible["+cartOptionSeq+"]']").val();
			if(ship_possible_flag == "N") {
				$("#cart_goods_"+cartOptionSeq).css('outline','2px solid #F15F5F');
			} else {
				$("#cart_goods_"+cartOptionSeq).css('outline','2px solid #769dff');
			}
		} else {
			$('input[name*="cart_option_seq"]').eq(0).attr('checked',true);
		}
		setPriceInfo();
		alert('주문이나 상품 삭제는 하나이상의 상품을 선택 하셔야 합니다.');	
	}else{
		setPriceInfo();
	}
}

//가격 설정
function setCartPriceInfo(data){

	// 체크 여부에 따라 네이버페이 버튼 노출 toggle
	if(data.npay_display == 'hide') {
		$('#nhn_btn').hide();
	} else {
		$('#nhn_btn').show();
	}
	
	//전체 상품금액 html create
	var goodsTotalViewPrice = get_currency_price(data.cart.total,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'');
	$('#totalGoodsPrice').html(goodsTotalViewPrice);

	//전체 배송금액 html create
	var shippingTotalViewPrice = get_currency_price(data.shippingGroupList.total_shipping_price,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span id="total_sale">_str_price_</span>');
	if(data.shippingGroupList.total_shipping_price > 0){
		shippingTotalViewPrice = '(+) ' + shippingTotalViewPrice
	}
	$('#shippingTotalPrice').html(shippingTotalViewPrice);

	//전체 결제금액 html create
	var totalViewPrice = get_currency_price(data.cart.total_price,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span class="tahoma">_str_price_</span>');
	$('#totalPrice').html(totalViewPrice);
	
	//전체 할인금액 html create
	var saleTotalViewPrice = get_currency_price(data.cart.total_sale,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span id="total_sale">_str_price_</span>');
	if(data.cart.total_sale > 0){
		saleTotalViewPrice = '(-) ' + saleTotalViewPrice
	}
	$('#saleTotalPrice').html(saleTotalViewPrice);

	//전체 결제금액 비교통화
	var totalPriceCompare = data.cart.total_price_compare;
	$('#totalPriceCompare').html(totalPriceCompare);	

	//배송비 html 바인딩
	if(typeof gl_operation_type != 'undefined' && gl_operation_type == 'light') {
		shippingInfoHtmlCreateResp(data);
	}else if(gl_set_mode == 'mobile'){
		shippingInfoHtmlCreateMobile(data);
	}else{
		shippingInfoHtmlCreate(data);
		//배송비 상세정보 바인딩
		if(data.shippingCostDetail != null){
			shippingInfoDetailHtmlCreate(data);
		}
		//할인금액 상세정보 바인딩
		if(data.totalSaleList != null){
			saleCostInfoHtmlCreate(data);
		}	
	}
}

//할인금액 상세 내역 html create
function saleCostInfoHtmlCreate(data){
	var saleDetailHtml = '<h1>할인내역</h1><div class="layer_inner"><p class="center">총 <span class="red">' + get_currency_price(data.cart.total_sale,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span class="total_sales_price totalprice">_str_price_</span>') + '</span> 할인</p><table class="tbl_col" width="100%" border="0" cellpadding="0" cellspacing="0"><caption>할인내역</caption><colgroup><col style="width:50%" /><col style="width:50%" /></colgroup><thead class="hide"><tr><th scope="col">항목</th><th scope="col">할인금액</th></tr></thead><tbody>';
	var enuri = 0;
	var ehideClass = '';
	var target = $('#saleDetailInfo');

	$.each(data.totalSaleList,function(_key, _value){
		var hideClass = '';
		var price = 0;

		if(_value['price'] == 0){
			hideClass = 'class="hide"';
		}else{
			price = get_currency_price(_value['price'],3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span cclass="total_' + _key + '_sale">_str_price_</span>')
		}

		saleDetailHtml += '<tr id="total_' + _key + '_sale_tr" ' + hideClass + '><th scope="row">' + _value['title'] + '</th><td class="bolds ends prices">' + price + '';
	});


	if(data.cart.enuri > 0){
		enuri = get_currency_price(data.cart.enuri,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span cclass="enuri">_str_price_</span>')
		saleDetailHtml += '<tr><th scope="row">에누리</th><td>' + enuri + '</td></tr>';
	}

	saleDetailHtml += '</tbody></table></div><a href="javascript:;" class="detailDescriptionLayerCloseBtn">닫기</a>';

	target.html(saleDetailHtml);
}

//배송비 상세 내역 html create
function shippingInfoDetailHtmlCreate(data){

	var shippingDetailHtml = '';
	var target = $('#shippingDetailInfo');
	var totalShippingCost = 0;
	var totalPostpaidCost = 0;
	var dsCost = 0;
	var daCost = 0;
	var dhCost = 0;
	var psCost = 0;
	var paCost = 0;
	var phCost = 0;

	if(data.shippingCostDetail.hasOwnProperty('delivery')){
		$.each(data.shippingCostDetail.delivery,function(_key, _value){
			totalShippingCost += _value;
		});

		dsCost = data.shippingCostDetail.delivery.std;
		daCost = data.shippingCostDetail.delivery.add;
		dhCost = data.shippingCostDetail.delivery.hop;
	}

	if(data.shippingCostDetail.hasOwnProperty('postpaid')){
		$.each(data.shippingCostDetail.postpaid,function(_key, _value){
			totalPostpaidCost += _value;
		});

		psCost = data.shippingCostDetail.postpaid.std;
		paCost = data.shippingCostDetail.postpaid.add;
		phCost = data.shippingCostDetail.postpaid.hop;
	}

	shippingDetailHtml = '<h1>배송비내역</h1><div class="layer_inner"><!-- 선불 배송비 상세 :: START --><p class="center">주문 시 결제 배송비 : 총<span class="red">' + get_currency_price(totalShippingCost,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span class="total_org_shipping_price totalprice">_str_price_</span>') + '</span></p><table class="tbl_col" width="100%" border="0" cellpadding="0" cellspacing="0"><caption>주문 시 결제 배송비</caption><colgroup><col style="width:50%" /><col style="width:50%" /></colgroup><thead class="hide"><tr><th scope="col">항목</th><th scope="col">배송비</th></tr></thead><tbody><tr><th scope="row">기본배송비</th><td>' + get_currency_price(dsCost,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span class="basic_delivery">_str_price_</span>') + '</td></tr><tr class="total_add_delivery_lay"><th scope="row">추가배송비</th><td>' + get_currency_price(daCost,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span class="add_delivery">_str_price_</span>') + '</td></tr><tr><th scope="row">희망일 배송비</th><td>' + get_currency_price(dhCost,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span class="hop_delivery">_str_price_</span>') + '</td></tr></tbody></table><!-- 선불 배송비 상세 :: END --><!-- 착불 배송비 상세 :: START --><p class="mt10 center">착불 결제 배송비 : 총 <span class="red">' + get_currency_price(totalPostpaidCost,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span class="totalprice">_str_price_</span>') + '</span></p><table class="tbl_col" width="100%" border="0" cellpadding="0" cellspacing="0"><caption>착불 결제 배송비</caption><colgroup><col style="width:50%" /><col style="width:50%" /></colgroup><thead class="hide"><tr><th scope="col">항목</th><th scope="col">배송비</th></tr></thead><tbody><tr><th scope="row">기본배송비</th><td>' + get_currency_price(psCost,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span class="basic_delivery">_str_price_</span>') + '</td></tr><tr class="total_add_delivery_lay"><th scope="row">추가배송비</th><td>' + get_currency_price(paCost,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span class="add_delivery">_str_price_</span>') + '</td></tr><tr><th scope="row">희망일 배송비</th><td>' + get_currency_price(phCost,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span class="hop_delivery">_str_price_</span>') + '</td></tr></tbody></table><!-- 착불 배송비 상세 :: END --></div><a href="javascript:;" class="detailDescriptionLayerCloseBtn">닫기</a>';

	target.html(shippingDetailHtml);
}

//배송 방법 변경 이벤트
function bind_shipping_modify_btn(){
	$(".btn_shipping_modify").off('click').on("click",function() {
		var cart_seq	= $(this).attr('cart_seq');
		var prepay_info = $(this).attr('prepay_info');
		var nation		= $(this).attr('nation');
		var hop_date	= $(this).attr('hop_date');
		var goods_seq	= $(this).attr('goods_seq');
		var reserve_txt	= $(this).attr('reserve_txt');

		$.ajax({
			'url': '/goods/shipping_detail_info',
			'data': {'mode':'cart','cart_seq':cart_seq,'prepay_info':prepay_info,'nation':nation,'hop_date':hop_date,'goods_seq':goods_seq,'reserve_txt':reserve_txt},
			'type': 'get',
			'dataType': 'text',
			'success': function(html){
				if(html){
					// 반응형스킨
					if (typeof gl_operation_type != 'undefined' && gl_operation_type == 'light') {
						$("#shipping_detail_lay .layer_pop_contents").html(html);
						showCenterLayer('#shipping_detail_lay');
					}else{
						// 전용 스킨
						$("div#shipping_detail_lay").html(html);
						//배송방법 안내 및 변경
						openDialog(getAlert('oc040'), "shipping_detail_lay", {"width":500,"height":650});
					}
				}else{
					//오류가 발생했습니다. 새로고침 후 다시시도해주세요.
					alert(getAlert('oc041'));
					document.location.reload();
				}
			}
		});
	});
}

/**
 * 배송비 html 동적 생성(Mobile 전용 스킨)
 * @param object data 상품 가격이 재계산된 후 넘어온 데이터(장바구니 데이터, 배송그룹 데이터, 총 결제 금액)
 */
function shippingInfoHtmlCreateMobile(data){
	//배송 그룹별 배송비 html create
	$.each(data.shippingGroupList,function(_key, _value){
		var shippingInfoHthml = '';

		if(_key != 'shipping_cost_detail' && _key != 'total_shipping_price'){
			if(data.shippingGroupList[_key].hasOwnProperty('shipping_std_cfg')){

				var target = $('#sippingInfo' + data.shippingGroupList[_key].shipping_std_cfg.shipping_group_seq);

				//티켓 상품일 경우
				if(data.shippingGroupList[_key].cfg.baserule.shipping_set_code == 'coupon'){
					if(data.shippingGroupList[_key].shipper_name){
						shippingInfoHthml += '<span>' + data.shippingGroupList[_key].shipper_name + '  -  티켓배송</span>';
					}else{
						shippingInfoHthml += '<span>티켓배송</span>';
					}

				//티켓 상품이 아닐 경우
				}else{
					shippingInfoHthml = '<div class="fleft">';
					if(data.shippingGroupList[_key].shipper_name){
						shippingInfoHthml += '<span class="blue">[' + data.shippingGroupList[_key].shipper_name + ']</span> ';
					}

					shippingInfoHthml += '<span>' + data.shippingGroupList[_key].cfg.baserule.shipping_set_name + '</span> ';

					if(data.shippingGroupList[_key].cfg.baserule.shipping_set_code == 'direct_store'){
						shippingInfoHthml += '<span class="ship_info">수령매장 ' + data.shippingGroupList[_key].store_info.shipping_store_name + '</span>';
					}

					if(data.shippingGroupList[_key].shipping_hop_date){
						shippingInfoHthml += '<span class="ship_info">희망배송일 : ' + data.shippingGroupList[_key].shipping_hop_date + '</span>';
					}else if (data.shippingGroupList[_key].reserve_sdate){
						shippingInfoHthml += '<span class="ship_info">예약배송일 : ' + data.shippingGroupList[_key].reserve_sdate + '</span>';
					}

					shippingInfoHthml += '<input type="button" class="btn_style small btn_shipping_modify" cart_seq="' + data.shippingGroupList[_key].goods[0].cart_seq + '" prepay_info="' + data.shippingGroupList[_key].shipping_prepay_info + '" nation="' + data.shippingGroupList[_key].cfg.baserule.delivery_nation + '" goods_seq="' + data.shippingGroupList[_key].goods[0].goods_seq + '" hop_date="' + data.shippingGroupList[_key].shipping_hop_date + '" reserve_txt="' + data.shippingGroupList[_key].reserve_sdate + data.shippingGroupList[_key].reserve_txt + '" value="변경" /></div><div class="fright pdt5">';

					if(data.shippingGroupList[_key].cfg.baserule.shipping_set_code != 'direct_store'){
						if(data.shippingGroupList[_key].grp_shipping_price > 0){
							if(data.shippingGroupList[_key].shipping_prepay_info == 'delivery'){
								shippingInfoHthml += '<span class="ship_info">(' + getAlert('sy004') + ')</span>';
							}else{
								shippingInfoHthml += '<span class="ship_info">(' + getAlert('sy003') + ')</span>';
							}
						}
					}

					if(data.shippingGroupList[_key].grp_shipping_price > 0){
						shippingInfoHthml += '<span id="price_' + data.shippingGroupList[_key].shipping_group + '"> ' + get_currency_price(data.shippingGroupList[_key].grp_shipping_price,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span class="add_delivery">_str_price_</span>') + '</span>';
					}else{
						if(data.shippingGroupList[_key].ship_possible == 'Y'){
							shippingInfoHthml += '<span id="price_' + data.shippingGroupList[_key].shipping_group + '">무료</span>';
						}else{
							shippingInfoHthml += '<span class="red" id="price_' + data.shippingGroupList[_key].shipping_group + '">배송불가</span>';
						}
					}
				}

				shippingInfoHthml += '</div>';


				target.html(shippingInfoHthml);
				bind_shipping_modify_btn();
			}
		}
	});
}

/**
 * 배송비 html 동적 생성(PC전용 스킨)
 * @param object data 상품 가격이 재계산된 후 넘어온 데이터(장바구니 데이터, 배송그룹 데이터, 총 결제 금액)
 */
function shippingInfoHtmlCreate(data){

	$.each(data.shippingGroupList,function(_key, _value){

		if(_key != 'shipping_cost_detail' && _key != 'total_shipping_price'){
			if(data.shippingGroupList[_key].hasOwnProperty('shipping_std_cfg')){
				var shipperName = '';
				if(data.shippingGroupList[_key].shipper_name){
					shipperName = data.shippingGroupList[_key].shipper_name;
				}
				var shippingInfoHthml = '<table width="100%" cellpadding="0" cellspacing="0"><tr><td><div class="blue">' + shipperName + '</div>';

				var target = $('#sippingInfo' + data.shippingGroupList[_key].shipping_std_cfg.shipping_group_seq);

				//티켓 상품일 경우
				if(data.shippingGroupList[_key].cfg.baserule.shipping_set_code == 'coupon'){
					shippingInfoHthml += '티켓발송';
				//티켓 상품이 아닐 경우
				}else{
					shippingInfoHthml += '<div>' + data.shippingGroupList[_key].cfg.baserule.shipping_set_name + '</div>';

					if(data.shippingGroupList[_key].grp_shipping_price > 0){
						shippingInfoHthml += '<span>' + get_currency_price(data.shippingGroupList[_key].grp_shipping_price,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,''); + '</span>';

						if(data.shippingGroupList[_key].cfg.baserule.shipping_set_code != 'direct_store'){
							if(data.shippingGroupList[_key].shipping_prepay_info == 'delivery'){
								shippingInfoHthml += '<span class="ship_info">(' + getAlert('sy004') + ')</span>';
							}else{
								shippingInfoHthml += '<span class="ship_info">(' + getAlert('sy003') + ')</span>';
							}
						}
					}else{
						if(data.shippingGroupList[_key].ship_possible == 'Y'){
							shippingInfoHthml += '<div>무료</div>';
						}else{
							shippingInfoHthml += '<div class="red">배송불가</div>';
						}
					}
				}
				shippingInfoHthml += '</td>';
				shippingInfoHthml += '<td><!-- 배송방법 변경 :: START --><div class="order_change"><button type="button" class="btn_shipping_modify btn_chg small" cart_seq="' + data.shippingGroupList[_key].goods[0].cart_seq + '" prepay_info="' + data.shippingGroupList[_key].shipping_prepay_info + '" nation="' + data.shippingGroupList[_key].cfg.baserule.delivery_nation + '" goods_seq="' + data.shippingGroupList[_key].goods[0].goods_seq + '" hop_date="' + data.shippingGroupList[_key].shipping_hop_date + '" reserve_txt="' + data.shippingGroupList[_key].reserve_sdate + data.shippingGroupList[_key].reserve_txt + '">변경</button></div><!-- 배송방법 변경 :: END --></td>';
				shippingInfoHthml += '</tr></table>';

				if(data.shippingGroupList[_key].cfg.baserule.shipping_set_code == 'direct_store'){
					shippingInfoHthml += '<div class="ship_info">수령매장 : ' + data.shippingGroupList[_key].store_info.shipping_store_name + '</div>';
				}

				if(data.shippingGroupList[_key].shipping_hop_date){
					shippingInfoHthml += '<div class="ship_info">희망배송일 : ' + data.shippingGroupList[_key].shipping_hop_date + '</div>';
				}else if (data.shippingGroupList[_key].reserve_sdate){
					shippingInfoHthml += '<div class="ship_info">예약배송일 : ' + data.shippingGroupList[_key].reserve_sdate + '</div>';
				}

				target.html(shippingInfoHthml);
				bind_shipping_modify_btn();
			}
		}
	});
}

/**
 * 배송비 html 동적 생성(반응형 스킨)
 * @param object data 상품 가격이 재계산된 후 넘어온 데이터(장바구니 데이터, 배송그룹 데이터, 총 결제 금액)
 */
function shippingInfoHtmlCreateResp(data){
	
	//배송 그룹별 배송비 html create
	$.each(data.shippingGroupList,function(_key, _value){
		
		if(_key != 'shipping_cost_detail' && _key != 'total_shipping_price'){
			if(data.shippingGroupList[_key].hasOwnProperty('shipping_std_cfg')){
				var html = '';
				html += '<ul class="detail">';
				var target = $('#sippingInfo' + data.shippingGroupList[_key].shipping_std_cfg.shipping_group_seq);
				html += '<li class="th">배송 :</li>';
				//티켓 상품일 경우
				if(data.shippingGroupList[_key].cfg.baserule.shipping_set_code == 'coupon'){
					if(data.shippingGroupList[_key].shipper_name){
						html += '<li class="ticket">' + data.shippingGroupList[_key].shipper_name + '  -  티켓배송</li>';
					}else{
						html += '<li class="ticket">티켓배송</li>';
					}

				//티켓 상품이 아닐 경우
				}else{
					html += '<li class="silmul">';
					if(data.shippingGroupList[_key].shipper_name){
						html += '<span class="gray_01">[' + data.shippingGroupList[_key].shipper_name + ']</span> ';
					}

					html += '<span>' + data.shippingGroupList[_key].cfg.baserule.shipping_set_name + '</span> ';

					if(data.shippingGroupList[_key].cfg.baserule.shipping_set_code != 'direct_store'){
						if(data.shippingGroupList[_key].grp_shipping_price > 0){
							if(data.shippingGroupList[_key].shipping_prepay_info == 'delivery'){
								html += '<span class="ship_info">(' + getAlert('sy004') + ')</span>';
							}else{
								html += '<span class="ship_info">(' + getAlert('sy003') + ')</span>';
							}
						}
					}

					if(data.shippingGroupList[_key].grp_shipping_price > 0){
						html += '<span id="price_' + data.shippingGroupList[_key].shipping_group + '"> ' + get_currency_price(data.shippingGroupList[_key].grp_shipping_price,3,gl_skin_currency,gl_basic_currency_symbol,gl_basic_currency_symbol_position,'','<span class="add_delivery">_str_price_</span>') + '</span>';
					}else{
						if(data.shippingGroupList[_key].ship_possible == 'Y'){
							html += '<span id="price_' + data.shippingGroupList[_key].shipping_group + '">무료</span>';
						}else{
							html += '<span class="red" id="price_' + data.shippingGroupList[_key].shipping_group + '">배송불가</span>';
						}
					}
					
					html += '<div class="hope">';
					if(data.shippingGroupList[_key].cfg.baserule.shipping_set_code == 'direct_store'){
						html += '<span class="ship_info">수령매장 ' + data.shippingGroupList[_key].store_info.shipping_store_name + '</span>';
					}

					if(data.shippingGroupList[_key].shipping_hop_date){
						html += '<span class="ship_info">희망배송일 : ' + data.shippingGroupList[_key].shipping_hop_date + '</span>';
					}else if (data.shippingGroupList[_key].reserve_sdate){
						html += '<span class="ship_info">예약배송일 : ' + data.shippingGroupList[_key].reserve_sdate + '</span>';
					}
					
					html += '</div>';
					
					html += '</li>';
				}
				
				html += '<li class="btn_area">';
				html += '<button type="button" class="btn_resp" onclick="bundle_goods_search(\'' + data.shippingGroupList[_key].cfg.baserule.shipping_group_seq +'\');" title="새창">묶음배송 상품보기</button> ';
				
				var reserve_txt = "";
				if(typeof data.shippingGroupList[_key].reserve_sdate !== 'undefined') {
					reserve_txt += data.shippingGroupList[_key].reserve_sdate;
				}
				if(typeof data.shippingGroupList[_key].reserve_txt !== 'undefined') {
					reserve_txt += data.shippingGroupList[_key].reserve_txt;
				}
				html += '<input type="button" class="btn_resp btn_shipping_modify" cart_seq="' + data.shippingGroupList[_key].goods[0].cart_seq +'" prepay_info="'+ data.shippingGroupList[_key].shipping_prepay_info +	'" nation="' + data.shippingGroupList[_key].cfg.baserule.delivery_nation + '" goods_seq="' + data.shippingGroupList[_key].goods[0].goods_seq + '" hop_date="' + data.shippingGroupList[_key].shipping_hop_date + '" reserve_txt="' + reserve_txt + '" value="배송 변경" />';
				html += '</li>';
				html += '</ul>';
				target.html(html);
				bind_shipping_modify_btn();
			}
		}
		
	});
	
}

//전체 체크 해제
function checkBoxCheck(){
	var falseChk = 0;
	$('input[name*="cart_option_seq"]').each(function(){
		if($(this).attr('checked') != 'checked'){
			falseChk++;
		}
	});

	if (typeof gl_operation_type != 'undefined' && gl_operation_type == 'light') { // 반응형스킨
		if(falseChk == 0){
			$("form#cart_form .btn_select_all").attr("checked",true);
		}else{
			$("form#cart_form .btn_select_all").attr("checked",false);
		}		
	} else if(gl_set_mode === 'mobile'){ // 전용스킨-모바일
		if(falseChk == 0){
			$("form#cart_form .btn_select_all").attr("checked",true).closest("div").addClass("ez-checkbox-on");
		}else{
			$("form#cart_form .btn_select_all").attr("checked",false).closest("div").removeClass("ez-checkbox-on");
		}
	} else { // 전용스킨-pc
		if(falseChk == 0){
			$('.chk_select_all').attr('checked',true);
		}else{
			$('.chk_select_all').attr('checked',false);
		}
	}
}
//장바구니 개선 스크립트


// 모바일 에이전트 구분
var isMobile = {
	Android: function () {
			 return navigator.userAgent.match(/Android/i) == null ? false : true;
	},
	BlackBerry: function () {
			 return navigator.userAgent.match(/BlackBerry/i) == null ? false : true;
	},
	IOS: function () {
			 return navigator.userAgent.match(/iPhone|iPad|iPod/i) == null ? false : true;
	},
	Opera: function () {
			 return navigator.userAgent.match(/Opera Mini/i) == null ? false : true;
	},
	Windows: function () {
			 return navigator.userAgent.match(/IEMobile/i) == null ? false : true;
	},
	any: function () {
			 return (isMobile.Android() || isMobile.BlackBerry() || isMobile.IOS() || isMobile.Opera() || isMobile.Windows());
	}
};

//카카오톡 링크
function kakaotalk_link(type, url, subject, title, img, price, price_discount, price_rate){
	var kakao_obj = {
		objectType: type,
		content: {
			title: subject,
			imageUrl: img,
			link: {
				mobileWebUrl: url,
				webUrl: url
			}
		},
		buttons: [
		  {
			title: '피드',
			link: {
				mobileWebUrl: url,
				webUrl: url
			}
		  }
		]
	};
	if	( type == 'commerce' ) {
		if(price_rate == "0") {
			kakao_obj.commerce = {
				regularPrice:	price_discount,
			}
		} else {
			kakao_obj.commerce = {
				regularPrice:	price,
				discountPrice:	price_discount,
				discountRate:	price_rate
			}
		}
		kakao_obj.buttons[0].title = '구매하기';
		kakao_obj.content.title = title;
	}

	Kakao.Link.sendDefault(kakao_obj);
}

// 클립보드 복사 함수 :: 2018-11-22 lwh
function clipboard_copy(str){

	if(typeof(str) === "undefined") retrun;	
	
	if(typeof(str) === "object")
	{
		var code =  $(str).attr('code');
		if(typeof(code) === "undefined") retrun;
		var arr = code.split("/||/");	
		str = arr.join("");
		alert("클립보드에 저장되었습니다.");
	}	

	var $temp = $("<input>");		// $temp 에 인풋 변수저장
    $("body").append($temp);		// body안 끝에 $temp인풋 생성
    $temp.val(str).select();		// $temp value는 param str 로하고 셀렉트한다.
    document.execCommand("copy");	// 현재의 선택한 내용을 클립보드로 복사한다.
    $temp.remove();					// $temp 지우기
}

function callbackIdChk(json){
	var response = $.parseJSON(json);
	var text = response.return_result;
	var userid = response.userid;
	$("#id_info").html(text);
	$("input[name='userid']").val(userid);
}

// 객체 -> 숫자로 타입체크 변환시 사용 (채널톡)
function check_obj(data) {
	var ret;
	var sum = 0;

	if (Object.keys(data).length > 0) {
		ret = {};
		for (var key in data){ 
			sum = 0;
			if (Array.isArray(data[key])){
				data[key].forEach(function(val,idx,arr){
					sum += check_number(val);
				});
			} else {
				sum += check_number(data[key]);
			}
			ret[key] = sum;				
		};
	};
	return ret;
}

// 숫자로 타입변환시 사용 (채널톡)
function check_number(x) {

	var pattern = /[^0-9.]/gi; // 이외에는 제외
	var pattern2 = /./; // 포함 

	// 숫자를 제외하고는 제거
	if (pattern.test(x)) {  
		x = x.replace(pattern,''); 
	}

	// 변환
	if (pattern2.test(x)) { 
		x = uncomma_float(x); 
	} else { 
		x = uncomma(x); 
	}
	return x;

}

// 채널톡 위시리스트 이벤트
function AddToWish(id,name,amount) {
    if (id == null || typeof id == 'undefined') {
        id = '';
    } 

    if (name == null || typeof name == 'undefined'){
        name = '';
    }

    if (amount == null || typeof amount == 'undefined'){
        amount = 0;
    }
	if (typeof ChannelIO != 'undefined') {
		ChannelIO('track', 'AddToWish', {
			'id': id,
			'name': name,
			'amount': amount
		});
	}
}

// 리스트에서 위시리스트 사용시 or 장바구니에서 위시리스트 사용시 호출
function channeltalk_wish_in(seq,type,obj){

	// 초기값
	var name = '';
	var amount = '';
	var ret;
	
	// 가공할 데이터가 있을 경우
	if (typeof obj != 'undefined' && typeof type != 'undefined') { 
		switch (type) {
            case 'setWish': // (반응형스킨) 리스트에서 찜버튼 클릭시
                var goods = $(obj).parents('.item_img_area').siblings('.item_info_area'); // 상품정보
                name = goods.children('.goods_name_area').find('.name').text(); // 상품명
                amount = goods.children('.goods_price_area').find('.sale_price > .num').text();
                break;
            case 'display_goods_zzim_heavy': // (전용스킨) 메인페이지 or 리스트에서 찜버튼 클릭시
                name = $(obj).find('.goods_name').text(); // 상품명
				var classObj = $(obj).find('.sale_price');
				amount = 0;
				if ( $(obj).find('.sale_price').length > 0) {
					if ($(obj).find('.sale_price').length === 1 ){
						amount = $(obj).find('.sale_price').text(); // 상품 가격
						amount = check_number(amount);
					} else {
						classObj.each(function(){
							var tmp_amount = check_number($(this).text());
							if (amount === 0){
								amount = tmp_amount;
							} else if (amount > tmp_amount) {
								amount = tmp_amount;
							}
						});
					}
				}
                break;
            case 'display_goods_zzim': // (반응형스킨) 메인페이지에서 찜버튼 클릭시
                name = $(obj).find('.displaY_goods_name > .areA > a').text(); // 상품명
                amount = $(obj).find('.displaY_sales_price > .areA > .nuM').text(); // 상품 가격
                break;
			// case 'cart_wish': // (공통) 장바구니에서 찜버튼 클릭시
			// 	name = $(obj).siblings('.relative').find('.order_name').text();
			// 	amount = $(obj).siblings('.right').find('[class^="cart_option_price"]').text();
			// 	console.log(name,amount);
			// 	break;
			default:
				name = '';
				amount = '';
				break;
        }
	}
	if (typeof seq != 'undefined') {
		// 옵션값이 존재할때 사용
		if (name != '' && name != null && amount !='' && amount != null && amount != 0 ) {

			// 금액외에 특수문자 포함여부 확인 
			if (type == 'display_goods_zzim_heavy') {
				 AddToWish(seq,name,amount);
			} else {
				ret = check_number(amount);
				if (typeof ret != 'undefined'){
					amount = ret;
					AddToWish(seq,name,amount);
				}
			}
			
		} else {
			var url = "/goods/now_wish?seqs="+ seq;

			$.getJSON(url,function(res){
				if (res != null) {
					name = res.goods_name;
					amount = res.price;
					ret = check_number(amount);
					if (typeof ret != 'undefined'){
						amount = ret;
						AddToWish(seq,name,amount);
					}
				}
			});
		}
	} else {
		return false;
	}
}

// 자주 묻는 질문 조회
function call_faq_view(faqviewBtn) {
	var boardId = faqviewBtn.attr('board_id');
	var boardSeq = faqviewBtn.attr('board_seq');
	var viewLink = faqviewBtn.attr('href');
	var elementType = faqviewBtn.prop('nodeName');

	$.ajax({
		'url' : '../board/view',
		'data' : {'id': boardId, 'seq': boardSeq},
		'type' : 'get',
		'dataType': 'html',
		'success' : function(res){
			// PC 스킨 고객센터 자주 묻는 질문 글 클릭한 경우
			if (elementType == "A") {
				document.location.href= viewLink;
			}
			// 그 외 글 클릭한 경우
			else {
				$("#faqcontent_"+boardSeq).toggle();
			}
		}
	});
}
