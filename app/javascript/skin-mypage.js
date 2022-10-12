/**
 * mypage 에서 사용되는 스크립트
 * 스킨 상관없이 호출하여 사용함
 * 스킨 분기는 gl_operation_type , gl_mobile_mode 로 체킹함
 * added by hyem 2021-06-11
 */
$(document).ready(function(){
	$(".taxBtn").on('click',function(){
		var tax_seq = $(this).attr("tax_seq");
		var order_seq = $(this).attr("order_seq");
		$.ajax({
			url: '../mypage/taxwrite',
			type : 'post',
			dataType: 'json',
			data : {'order_seq':order_seq, 'tax_seq':tax_seq, 'request_mode':'js'},
			success: function(data) {
				if(data.result == false) {
					openDialogAlert(data.msg,'400','140',function(){});
				} else {
					if(gl_operation_type == 'light') {
						$('#tax_bill .layer_pop_contents').html(data.taxwrite);
						showCenterLayer('#tax_bill');
					} else {
						$('#taxlay').html(data.taxwrite);
						//세금계산서 <span class='desc'>세금계산서를 신청합니다.</span>
						openDialog(getAlert('mo122'), "taxlay", {"width":"700","height":"600"});
					}
				}
				
			}
		});
	});

	$(".taxDellBtn").on('click',function(){
		var tax_seq = $(this).attr("tax_seq");
		var order_seq = $(this).attr("order_seq");
		//정말로 삭제하시겠습니까?
		if(confirm(getAlert('mo138'))) {
			$.ajax({
				url: '../sales_process/taxdelete',
				type : 'post',
				dataType: 'json',
				data : {'order_seq':order_seq, 'tax_seq':tax_seq},
				success: function(data) {
					if(data) {
						if(data.result == true){
							openDialogAlert(data.msg,'400','140',function(){document.location.reload();});
						}else{
							openDialogAlert(data.msg,'400','140',function(){});
						}
					}else{
						//잘못된 접근입니다.
						openDialogAlert(getAlert('mo139'),'400','140',function(){});
					}
				}
			});
		}
	});

	$("#shipMessage .ship_message_txt").on('focus', function(){
		if($(this).closest(".ship_message").find(".add_message").css("display")=='none'){
			$(".add_message").hide();
			$(this).closest(".ship_message").find(".add_message").show();
		}else{
			$(".add_message").hide();
			$(this).closest(".ship_message").find(".add_message").hide();
		}
	});
	$("#shipMessage .ship_message_txt").on('blur', function(){
		$(".add_message").hide();
	});
	$(".add_message>li").on("mousedown", function(){
		var sel_message = $(this).html();
		$(this).closest(".ship_message").find(".ship_message_txt").val(sel_message).trigger('change');
		$(".add_message").hide();
	});

	// 배송메세지 카운터
	$(".ship_message_txt").on("keyup change", function(){
		var obj = $(this).closest(".ship-lay");
		check_ship_message_length(obj);
	}).trigger("keyup");

	const dropdowns = document.querySelectorAll(".dropdown h3");
	dropdowns.forEach(dropdown => {
		dropdown.closest(".dropdown").classList.add("active")
  
		if (!dropdown.closest(".section_header")) {
  
			dropdown.addEventListener("click", (event) => {
				event.target.closest(".dropdown").classList.toggle("active");
			})
		}
	});	
});

/**
 * 세금계산서 신청 후 종료
 */
function taxlayerclose(){
	$('#taxlay').dialog('close');
}

var certify_cellphone = (function () {
	var _options = {};
	var defaultOptions = {
		timeMinutes : 3,
		timeSeconds : 0,
	};
	var _init = function (options) {
		_options = $.extend(defaultOptions, options);
		_options.contents = $("form[name='" + _options.form + "']");
		_options.cellphone_element = _options.contents.find("input[name='" + _options.cellphone + "']");
	}
	var send_message = function () {
		var cellphone = '';
		_options.cellphone_element.each(function () {
			cellphone += $(this).val();
		});
		var min = _options.timeMinutes;
		var sec = _options.timeSeconds;
		$.ajax({
			'url': '/member_process/certify_cellphone',
			'data': { 'cellphone': cellphone },
			'dataType': 'json',
			'success': function (res) {
				if (res.result) {
					_options.contents.find("[name='certify_confirm']").val('done');
					_options.cellphone_element.attr('disabled', true);
					_options.contents.find('.certify_btn').hide();
					_options.contents.find(".certify_timer").show();
					var timer = setInterval(function () {
						if (sec == 0) {
							sec = 59;
							if (min != 0) {
								min = min - 1;
							}
						} else {
							sec = sec - 1;
						}
						_options.contents.find('.timer_min').html(min);
						_options.contents.find('.timer_sec').html(sec);

						if (min == 0 && sec == 0) {
							clearInterval(timer);
							_options.contents.find('.certify_btn').show();
							_options.contents.find(".certify_timer").hide();
							$.ajax({
								'url': '../member_process/certify_del',
							});
						}
					}, 1000);
					alert(res.msg);
				} else {
					alert(res.msg);
				}
				
			}
		});
	};
	var validation = function () {
		if ($("[name='certify_confirm']").val() != 'done') {
			alert(getAlert('mo162'));
			return false;
		}
		return true;
	};
	var complete = function () {
		_options.contents.find('.certify_timer').hide();
		_options.contents.find('button[type="submit"]').hide();
	};

	return {
		init: _init,

		send_message: send_message, // 실제 sms 발송
		validation: validation, // 인증전송 전 validation
		complete: complete, // 인증성공 후 
	}
})();



// 배송메세지 길이 체크
function check_ship_message_length(obj){
	var message		= obj.find(".ship_message_txt").val();
	var message_cnt	= message.length;
	if(message_cnt <= 300){
		obj.find(".cnt_txt").html(message_cnt);
	}else{
		//배송메세지는 300자 이하까지만 가능합니다.
		alert(getAlert('os151'));
		obj.find(".cnt_txt").html(300);
		obj.find(".ship_message_txt").val(message.substr(0,300));
	}
}

// 추가 연락처 
function add_phone(obj, type){
	if			(type == 'open'){
		$(obj).closest('li').next('.add_phone').show();
		$(obj).attr('onclick',"add_phone(this,'close')");
		$(obj).html('추가연락처 ▲');
	}else if	(type == 'close'){
		$(obj).closest('li').next('.add_phone').hide();
		$(obj).attr('onclick',"add_phone(this,'open')");
		$(obj).html('추가연락처 ▼');
	}else{ // 체크하여 값이 있으면 열기
		var add_phone_flag = true;
		$(obj).closest('li').next('.add_phone').find('input.add_phone_input').each(function(){
			if (!$(this).val())	add_phone_flag = false;
		});

		if(add_phone_flag){
			$(obj).closest('li').next('.add_phone').show();
			$(obj).attr('onclick',"add_phone(this,'close')");
			$(obj).html('추가연락처 ▲');
		}
	}
}

/**
 * 선물하기 배송지 등록에서 사용함
 */
var present = (function () {
	var change_delivery_content = function () {
		$(".order_contents").hide();
		$(".receipt_contents").show();

		$(".section_header > h3").eq(0).hide();
		$(".section_header > h3").eq(1).show();
	};

	return {
		change_delivery_content: change_delivery_content,
	}
})();
