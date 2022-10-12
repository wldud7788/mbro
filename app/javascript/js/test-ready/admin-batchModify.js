$(document).ready(function() {

	$("#chkAll").click(function(){
		if($(this).attr("checked")){
			$(".chk").attr("checked",true).change();
		}else{
			$(".chk").attr("checked",false).change();
		}
	});

	// 체크박스 색상
	$("input[type='checkbox'][name='goods_seq[]']").on('change',function(){
		var goods_seq	= this.value;
		var rowspan		= $(this).closest('td').attr('rowspan');
		var trIdx		= $(this).closest('tbody').find('tr').index($(this).closest('tr'));

		if(this.checked){
			$(this).closest('tr').addClass('checked-tr-background');
			if	(rowspan > 1){
				for (var i = 1; i < rowspan; i++){
					trIdx++;
					$(this).closest('tbody').find('tr').eq(trIdx).addClass('checked-tr-background');
				}
			}
			$('#option_' + goods_seq + ' tr').addClass('checked-tr-background');
		}else{
			$(this).closest('tr').removeClass('checked-tr-background');
			if	(rowspan > 1){
				for (var i = 1; i < rowspan; i++){
					trIdx++;
					$(this).closest('tbody').find('tr').eq(trIdx).removeClass('checked-tr-background');
				}
			}
			$('#option_' + goods_seq + ' tr').removeClass('checked-tr-background');
		}
	}).change();
	
	// 회원등급혜택 엑셀 일괄업데이트 추가 :: 2019-09-25 pjw
	$("#update_excel").bind("click",function(){
		openDialog("엑셀업로드", "membersale_excel_uplaod_dialog", {"width":420,"height":230});
	});

	$('#btn_excel_process').bind("click",function(){
		if($('#membersale_excel_file').val() == ''){
			openDialogAlert('업데이트할 엑셀파일을 선택하여 주시기 바랍니다.',400,150,function(){},'');
			return false;
		}

		$('#membersaleFrm').submit();
	});

	$("button[name='update_goods']").bind("click",function(){

		var $applyObj		= $(this);
		var checkFunction	= $applyObj.attr('check_function');
		var chk_val			= false;

		$(".chk").each(function(){
			if( $(this).attr("checked") == "checked" ){
				chk_val = true;
			}
		});

		if($('.batch_update_item').length > 0 && $('.batch_update_item:checked').length == 0){
			openDialogAlert('업데이트할 항목을 선택하여 주시기 바랍니다.',400,150,function(){},'');
			return false;
		}

		if($('.batch_icon').length > 0 && $('.batch_icon:checked').length == 0){
			openDialogAlert('업데이트할 아이콘을 선택하여 주시기 바랍니다.',400,150,function(){},'');
			return false;
		}

		if ( typeof $('select[name="target_modify"]').val() != 'undefined'   ) {
			if ($('select[name="modify_list_'+$('select[name="target_modify"]').val()+'"]').val() != 'all' && !chk_val) {
				openDialogAlert('일괄적용할 상품을 선택해 주세요.',400,150,function(){},'');
				return false;
			}
		} else {
			if ($('select[name="modify_list"]').val() != 'all' && !chk_val) {
				openDialogAlert('일괄적용할 상품을 선택해 주세요.',400,150,function(){},'');
				return false;
			}
		}

		if (typeof checkFunction == 'string') {
			var callCheck	= new Function('$applyObj', 'return ' + checkFunction + '($applyObj);');
			var checkMsg	= callCheck($applyObj);

			if (checkMsg !== true) { return false; }
		}

		// 역마진 확인 Ajax :: 2016-03-24 lwh
		$("#goods_permit_lay").html('');
		$.ajax({
			type: "post",
			url: "../goods/goods_batch_permit",
			data: "data="+$("form#goodsForm").serialize(),
			success: function(html){
				$("#goods_permit_lay").append(html);
				openDialog("일괄업데이트 확인", "goods_permit_lay", {"width":"500","show" : "fade","hide" : "fade"});
			}
		});

	});
	
	//원본이미지 삭제여부
	$("#imagedelete").bind("click",function(){ 
		if( $("#imagedelete").is(':checked') ) {
			openDialogConfirm('원본이미지를 삭제하겠습니까?<br/>삭제된 이미지는 복구 되지 않습니다!',500,160,function(){
				$("#imagedelete").attr("checked",true);
			},function(){
				$("#imagedelete").removeAttr("checked");
			});
		}
	}); 

	/* 이미지 호스팅 일괄업데이트 >개별 이미지호스팅 FTP 일괄업데이트 */
	$("#imagehostinggoodssave").bind("click",function(){
		var hostname	= $("#imghostinghostname").val();
		var username	= $("#imghostingusername").val();
		var password	= $("#imghostingpassword").val();
		var imagehostingDomainType	= $("input[name='imagehostingDomainType']:checked").val();
		
		if( !hostname || !username || !password ){
			alert("이미지 호스팅 FTP 정보를 정확히 입력해 주세요!");
			return;
		}
		
		var chk_val = false;
		$(".chk").each(function(){
			if( $(this).attr("checked") == "checked" ){
				chk_val = true;
			}
		});
		if(!chk_val && $("select.modify_list:visible").val()=='choice' ){
			openDialogAlert('변경할 상품을 선택해 주세요!',400,150,function(){closeDialog('openmarketimghostinglay');},'');
			return false;
		} 

		openDialogConfirm('PC/테블릿용 상품설명정보를를 변경하겠습니까?<br/>변경된 데이터는 복구 되지 않습니다!',500,160,function(){
				closeDialog('openmarketimghostinglay');
				loadingStart("body",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});
				
				var search_val = "";
				search_val += "<input type='hidden' name='hostname' value='"+hostname+"'>";
				search_val += "<input type='hidden' name='username' value='"+username+"'>";
				search_val += "<input type='hidden' name='password' value='"+password+"'>";
				search_val += "<input type='hidden' name='imagehostingDomainType' value='"+imagehostingDomainType+"'>";
				$("form#goodsBatchUpdateForm").append(search_val);

				batch_goods_save_submit();

			},function(){
		});
	});

	$("select[name='orderby']").bind("click change",function(){
		var url = "?page=1&"+freezeObj.queryString+"&orderby="+$(this).find("option:selected").val();
		location.href = url;
	});
	$("select[name='perpage']").bind("click change",function(){
		var url = "?page=1&"+freezeObj.queryString+"&perpage="+$(this).find("option:selected").val();
		location.href = url;
	});

	$("select[name^='modify_list']").bind("change",function(){
		if( $(this).find("option:selected").val() != "all"){
			$("input.chk").attr('disabled',false);
			$("#chkAll").attr('disabled',false);
		}else{
			$("input.chk").attr('disabled',true);
			$("#chkAll").attr('disabled',true);
		}
	});

	// 바로열기
	$(".btn-direct-open").on("click", function(){optionViewOnOff(this);});

	// 모두 열기/닫기
	$(".btn_open_all").on("click", function(){optionViewAllOnOff(this);});

	// 일괄적용
	$(".applyAllBtn").on("click", function(){applyAll(this)});

	// 옵션일괄적용
	$(".applyOptionsBtn").on("click", function(){applyOptions(this)});
});

// SEARCH FOLDER
function showSearch(){
	if($("#goods_search_form").css('display')=='none'){
		$("#goods_search_form").show();
		$.cookie("goods_list_folder", "folded");
	}else{
		$("#goods_search_form").hide();
		$.cookie("goods_list_folder", "unfolded");
	}
}

// 일괄업데이트 실행
function batch_goods_save_submit(){

	var f				= $("form#goodsBatchUpdateForm")[0];
	var actionMode		= $('[name="batchmodify_selector"]', f).val();
	var actionUrl		= "../goods_process/batch_goods_modify";
	var search_val		= "";

	for(var i=0; i < get_search_field.length; i++){
		if(get_search_field[i][0] != 'cancel_type'){
			search_val += "<input type='hidden' name='"+get_search_field[i][0]+"' value='"+get_search_field[i][1]+"'>";
		}
	}

	$("form#goodsBatchUpdateForm").append(search_val);

	switch (actionMode) {
		case	'' :
			actionUrl	= "../goods_process/batch_modify";
			break;
		case	'imagehosting' :
			actionUrl	= "../goods_process/batch_modify";
			break;
	}
	f.method	= "post";
	f.target	= "actionFrame";
	f.action	= actionUrl;
	f.submit();
}


function goodsView(seq){
	$("input[name='no']").val(seq);
	var search = location.search;
	search = search.substring(1,search.length);
	$("input[name='query_string']").val(search);
	$("form[name='goodsForm']").attr('action','regist');
	$("form[name='goodsForm']").submit();
}

function go_link_tab(mode)
{
	var url = "?page=1&" + freezeObj.queryString + "&mode="+mode;//amp;
	url = url.replace("&mode={_GET.mode}","");
	if(mode == 'price' || mode == 'goods' ){
		openDialogConfirm('현재 화면에서 나가시겠습니까?<br/>우측 상단의 ‘업데이트’ 버튼으로 저장하지 않은 데이터는 저장되지 않습니다!',500,180,function(){
			document.location.href = url;
		},function(){});
	}else{
		document.location.href = url;
	}
}


function change_all_input(input_name,update_class,msg_yn)
{
	var cnt = $("input:checkbox[name='goods_seq[]']:checked").length;
	if(cnt<1){
		if( msg_yn ) alert("일괄적용할 상품을 선택해 주세요.");
		return;
	}else{

		var tagname				= $("."+input_name)[0].tagName;
		var obj_val				= "";
		var input_type			= "";
		var obj_val_checked		= new Array();
		var old_update_obj_name = "";

		if(tagname == "INPUT"){
			input_type	= $("."+input_name).attr("type").toLowerCase();
			if(input_type == "text"){
				obj_val		= $("input[name='"+input_name+"']").val();
			}else if(input_type == "checkbox"){
				obj_val_tmp	= $("input[name='"+input_name+"[]']");
				var k = 0;
				obj_val_tmp.each(function(){
					if($(this).is(":checked")){
						obj_val_checked[k] = $(this).val();
						k++;
					}
				});
			}
		}else{
			obj_val		= $("select[name='"+input_name+"'] option:selected").val();
		}

		// LIST 일괄 적용
		$("."+update_class).each(function(e){

			var update_obj = $(this);
			if( update_obj.closest("tr").find("input[name='goods_seq[]']").attr("checked") == 'checked' ){
				if(tagname == "INPUT"){
					//TEXT INPUT 처리
					if(input_type == "text"){
						update_obj.val(obj_val);
					//CHECKBOX INPUT 처리
					}else if(input_type == "checkbox"){
						
						var update_obj_name = update_obj.attr("name");
						if(update_obj_name != old_update_obj_name){
							$("input[name='"+update_obj_name+"']").prop("checked",false);
							if(update_class == "input_color_pick"){
								$("input[name='"+update_obj_name+"']").parent().attr("class","");
							}
						}

						old_update_obj_name = update_obj_name;

						for(var i=0; i < obj_val_checked.length; i++){

							if(obj_val_checked[i] == update_obj.val()){
								update_obj.prop("checked",true);
								if(update_class == "input_color_pick"){
									update_obj.parent().attr("class","active");
								}
							}
						}
					}
				}else{
					//SELECT 처리
					update_obj.find("option[value='"+obj_val+"']").attr('selected',true);
					
					if(input_name == "batch_runout_type"){

						change_all_input_in_span('batch_able_stock_limit','input_able_stock_limit');
						change_all_select_in_span('batch_runout_policy','input_runout_policy');

						chk_runout_type();
						chk_runout_policy();
					}
				}
			}
		});
	}
}

// -------------------------------------------------------------
// _batch_modify_status 사용 시작
//재고 정책 체크
function chk_runout_type()
{
	$("select.runout_type").each(function(e){
		if( $(this).find("option:selected").val() == 'goods' ){
			$(this).parent().find(".runout_span").removeClass("hide");
			$(this).parent().find(".runout_span2").addClass("hide");
		}else{
			$(this).parent().find(".runout_span").addClass("hide");
			$(this).parent().find(".runout_span2").removeClass("hide");
		}
	});
}

//재고연동판매 체크
function chk_runout_policy()
{
	$("select.runout_policy").each(function(){
		$(this).next().removeClass("hide");
		$(this).next().prop("disabled", false);
		if( $(this).find("option:selected").val() == 'unlimited' ){
			$(this).next().addClass("hide");
		}

		if ($(this).find("option:selected").val() == 'stock') {
			$(this).next().val(0);
			$(this).next().prop("disabled", true);
		}
	});
}

function change_all_input_in_span(input_name,class_name)
{
	var obj_val = $("input[name='"+input_name+"']").val();
	$("."+class_name).each(function(){
		if( $(this).parent().parent().parent().find("input[name='goods_seq[]']").attr("checked") == 'checked' ){
			$(this).val(obj_val);
		}
		var str_name = $(this).attr('name');
		if( str_name.match(/detail/) ){
			var obj_chk = $(this).parent().parent().parent().parent().parent().parent().parent().parent().prev();
			if( obj_chk.find("input[name='goods_seq[]']").attr("checked") == 'checked' ){
				$(this).val(obj_val);
			}
		}
	});
}
function change_all_select_in_span(input_name,class_name)
{
	var obj_val = $("select[name='"+input_name+"'] option:selected").val();
	$("."+class_name).each(function(){
		if( $(this).parent().parent().parent().find("input[name='goods_seq[]']").attr("checked") == 'checked' ){
			$(this).find("option[value='"+obj_val+"']").attr('selected',true);
		}
		var str_name = $(this).attr('name');
		if( str_name.match(/detail/) ){
			var obj_chk = $(this).parent().parent().parent().parent().parent().parent().parent().parent().prev();
			if( obj_chk.find("input[name='goods_seq[]']").attr("checked") == 'checked' ){
				$(this).find("option[value='"+obj_val+"']").attr('selected',true);
			}
		}
	});
}

function set_table_dialog(id, content) {
	$("#"+id).append(content);
}

//이미지 호스팅 일괄 업데이트 :: 호스팅정보 세팅 레이어
function chk_hosting_info(obj){
	openDialog("이미지 호스팅 일괄 업데이트", "openmarketimghostinglay", {"width":650,"height":455});
	return false;
}
function chk_multidiscount(){

	var setting_chk			= false;
	var ck_multidiscount	= $("input[name='batch_multidiscount']").is(":checked");
	var ck_min_limit		= $("input[name='batch_min_limit']").is(":checked");
	var ck_max_limit		= $("input[name='batch_max_limit']").is(":checked");

	console.log("ck_multidiscount : "+ ck_multidiscount);
	console.log("ck_min_limit : "+ ck_min_limit);
	console.log("ck_max_limit : "+ ck_max_limit);
	if(ck_multidiscount != true && ck_min_limit != true && ck_max_limit != true){
		openDialogAlert('업데이트 하실 내용을 먼저 선택하세요..',350,150,function(){},'');
		return false;
	}

	var discountMaxOverQty		= $("input[name='discountMaxOverQty'").length;
	var discountMaxAmount		= $("input[name='discountMaxAmount'").length;
	if(discountMaxOverQty > 0 && discountMaxAmount > 0){
		setting_chk = true;
	}

	var discountOverQty		= $("input[name='discountOverQty[]'").length;
	var discountUnderQty	= $("input[name='discountUnderQty[]'").length;
	var discountAmount		= $("input[name='discountAmount[]'").length;

	if((discountOverQty == 1 || (discountOverQty > 1 && discountUnderQty > 0)) && discountAmount > 0){
		setting_chk = true;
	}
	console.log("setting_chk : "+ setting_chk);
	if(ck_multidiscount == true && setting_chk != true){
		openDialogAlert('대량구매 혜택을 먼저 설정하세요.',350,150,function(){},'');
		return false;
	}
	
	if(ck_min_limit == true && $("input[name='minPurchaseLimit']").val() == ""){
		openDialogAlert('최소구매수량을 먼저 설정하세요.',350,150,function(){},'');
		return false;
	}
	
	if(ck_max_limit == true && $("input[name='maxPurchaseLimit']").val() == ""){
		openDialogAlert('최대구매수량을 먼저 설정하세요.',350,150,function(){},'');
		return false;
	}


	return true;
}
function chk_commoninfo(){
	if($("select[name='batch_info_select'] option:selected").val() == ""){
		openDialogAlert('업데이트할 공용정보를 먼저 선택해 주세요.',400,150,function(){},'');
		return false;
	}
	return true;
}
function chk_hscode(){
	if($("input[name='hscode_name']").val() == '' || $("input[name='batch_hscode_yn']").is(":checked") == false){
		openDialogAlert('업데이트할 HSCODE를 먼저 선택 해주세요.',400,150,function(){},'');
		return false;
	}
	return true;
}
function chk_epdata(){
	if($("#feed_ship_type").val() == 'E' && $("input[name='feed_pay_type']:checked").val() == 'fixed' && $("input[name='feed_std_fixed']").val() == ''){
		openDialogAlert('유료 타입은 배송비금액이 필수입니다.',400,150,function(){$("input[name='feed_std_fixed']").focus();},'');
		return false;
	}

	if($("#feed_ship_type").val() == 'E' && $("input[name='feed_pay_type']:checked").val() == 'postpay' && $("input[name='feed_std_postpay']").val() == ''){
		openDialogAlert('유료 타입은 배송비금액이 필수입니다.',400,150,function(){$("input[name='feed_std_postpay']").focus();},'');
		return false;
	}

	return true;
}

// 재고정책에 따라 상품상태가 변경된 경우 MSG 띄우기.
function popup_stock_modify_msg(data) {

	var rtn_json = $.parseJSON(data); // 데이터를 JSON으로 파싱
	//console.log(rtn_json);
	if(rtn_json['msg_show']) {
		var msg_show		= rtn_json['msg_show'].replace(/\\n/g, '\n');
		var gname			= rtn_json['gname'];
		var out_gname		= rtn_json['out_gname'];
		var normal_cnt		= rtn_json['normal_cnt'];
		var runout_cnt		= rtn_json['runout_cnt'];
		$("#dialog_confirm_msg").html(msg_show);
		openDialog("알림 <span class='desc'>알림 정보를 표시합니다.</span>", "dialog_confirm", {"width":480,"height":250});
	}

	if(!normal_cnt)	normal_cnt = "0";
	if(!runout_cnt) runout_cnt = "0";
	$("#btn_normal_gname span").html("품절⇒정상<br/>변경 상품<br/>("+ normal_cnt+"건)");
	$("#btn_runout_gname span").html("정상⇒품절<br/>변경 상품<br/>("+ runout_cnt+"건)");

	$("#btn_normal_gname").bind("click",function(){
		if($(this).attr("mode") != "ifstatus" && $(this).attr("mode") != "ifgoodsetc"){
			if (gname) {
				openDialog("알림 <span class='desc'>알림 정보를 표시합니다.</span>", "dialog_confirm_normal", {"width":480,"height":"auto"});
			} else { 
				openDialogAlert('해당 건이 없습니다.',400,180,'','');
			}
		}
		return;
	});

	$("#btn_runout_gname").bind("click",function(){
		if($(this).attr("mode") != "ifstatus" && $(this).attr("mode") != "ifgoodsetc"){
			if (out_gname) {
				openDialog("알림 <span class='desc'>알림 정보를 표시합니다.</span>", "dialog_confirm_runout", {"width":480,"height":"auto"});
			} else { 
				openDialogAlert('해당 건이 없습니다.',400,180,'','');
			}
		}
		return;
	});

	var mode = $("#btn_normal_gname").attr('mode');
	if( mode == "ifstatus" || mode == "ifgoodsetc" ) {
		$("#btn_normal_gname").css("cursor","default");
		$("#btn_runout_gname").css("cursor","default");
	}

	$("#btn_pop_close").bind("click",function(){
		$("#dialog_confirm").dialog( "close" );
		parent.location.reload();
	});

	$("#btn_pop_normal_close").bind("click",function(){
		$("#dialog_confirm_normal").dialog( "close" );
	});

	$("#btn_pop_runout_close").bind("click",function(){
		$("#dialog_confirm_runout").dialog( "close" );
	});
}
// _batch_modify_status 사용 종료
// -------------------------------------------------------------


function optionViewOnOff(thisObj) {
	
	var $btnObj		= $(thisObj);
	var ctrlType	= ($btnObj.hasClass('opened') === false) ? 'open' : 'close';
	var nowGoodsSeq	= $btnObj.attr('goods_seq');

	var $optionLay	= $('#option_' + nowGoodsSeq);

	if (ctrlType == 'open') {
		$optionLay.find('input,select').attr('disabled', false);
		$optionLay.show();
		$btnObj.addClass('opened');
		$('.default_option[goods_seq="' + nowGoodsSeq + '"]').attr('disabled', true);
		$('.applyOptionsBtn[goods_seq="' + nowGoodsSeq + '"]').parent().show();
		$('.openAddOptionSet[goods_seq="' + nowGoodsSeq + '"]').show();
		$('.closeAddOptionSet[goods_seq="' + nowGoodsSeq + '"]').hide();
	} else {
		$optionLay.find('input,select').attr('disabled', true);
		$optionLay.hide();
		$btnObj.removeClass('opened');
		$('.default_option[goods_seq="' + nowGoodsSeq + '"]').attr('disabled', false);
		$('.applyOptionsBtn[goods_seq="' + nowGoodsSeq + '"]').parent().hide();
		$('.openAddOptionSet[goods_seq="' + nowGoodsSeq + '"]').hide();
		$('.closeAddOptionSet[goods_seq="' + nowGoodsSeq + '"]').show();
	}

	$('.btn-direct-open[goods_seq="' + nowGoodsSeq + '"]').trigger('changeOptionLay');
}


function optionViewAllOnOff(thisObj) {
	var $btnObj		= $(thisObj);
	var ctrlType	= ($btnObj.hasClass('opened') === false) ? 'open' : 'close';
	var $optionLay	= $('.optionLay');
	
	if (ctrlType == 'open') {
		$btnObj.attr('src', '/admin/skin/default/images/common/icon/btn_close_all.gif');
		$optionLay.find('input,select').attr('disabled', false);
		$optionLay.show();
		$(".btn-direct-open").addClass('opened');
		$btnObj.addClass('opened');
		$('.default_option.option_use').attr('disabled', true);
		$('.applyOptionsBtn').parent().show();
		$('.openAddOptionSet').show();
		$('.closeAddOptionSet').hide();
	} else {
		$btnObj.attr('src', '/admin/skin/default/images/common/icon/btn_open_all.gif');
		$optionLay.find('input,select').attr('disabled', true);
		$optionLay.hide();
		$btnObj.removeClass('opened');
		$('.default_option.option_use').attr('disabled', false);
		$('.btn-direct-open').removeClass('opened');
		$('.applyOptionsBtn').parent().hide();
		$('.openAddOptionSet').hide();
		$('.closeAddOptionSet').show();
	}

	$('.btn-direct-open').trigger('changeOptionLay');

}


//전체상품적용
function applyAll(thisObj) {

	var $applyObj		= $(thisObj);
	var applyType		= $applyObj.attr('apply_type');
	var checkFunction	= $applyObj.attr('check_function');

	if ($("input:checkbox[name='goods_seq[]']:checked").length < 1) {
		alert("일괄적용할 상품을 선택해 주세요.");
		return false;
	}
	
	if (typeof checkFunction == 'string') {
		var callCheck	= new Function('$applyObj', 'return ' + checkFunction + '($applyObj);');
		var checkMsg	= callCheck($applyObj);

		if (checkMsg !== true) {
			alert(checkMsg);
			return false;
		}
	}

	$('.' + applyType + '_value:not(:disabled)').each(function() {
		target		= $(this).attr('apply_target');
		newValue	= this.value;

		$("input:checkbox[name='goods_seq[]']:checked").each (function() {
			$applyTbodyObj	= $('tr[goods_seq="' + this.value + '"]')
			applyAction($applyTbodyObj, target, newValue);
		});
	});

	var doneFunction	= $applyObj.attr('done_function');

	if (typeof doneFunction == 'string') {
		var callDone	= new Function('$applyObj', 'return ' + doneFunction + '($applyObj);');
		var checkMsg	= callDone($applyObj);
	}

}

//전체옵션적용
function applyOptions(thisObj) {
	var $applyObj		= $(thisObj);
	var goodsSeq		= $applyObj.attr('goods_seq');
	var applyType		= $applyObj.attr('apply_type');
	var checkFunction	= $applyObj.attr('check_function');
	
	if (typeof checkFunction == 'string') {
		var callCheck	= new Function('$applyObj', 'return ' + checkFunction + '($applyObj);');
		var checkMsg	= callCheck($applyObj);

		if (checkMsg !== true) {
			alert(checkMsg);
			return false;
		}
	}
	
	$('.' + applyType + '_value:not(:disabled)').each(function() {
		target			= $(this).attr('apply_target');
		newValue		= this.value;
		$applyTbodyObj	= $('#option_' + goodsSeq);
		applyAction($applyTbodyObj, target, newValue);
	});

	var doneFunction	= $applyObj.attr('done_function');
	
	if (typeof doneFunction == 'string') {
		var callDone	= new Function('$applyObj', 'return ' + doneFunction + '($applyObj);');
		var checkMsg	= callDone($applyObj);
	}
}

function applyAction ($applyTbodyObj, target, newValue) {
	$applyTbodyObj.find('.org_' + target + ':not(:disabled)').each(function(){
		this.value	= $(this).siblings('.' + target).val();
	});

	if($applyTbodyObj.find('.' + target + ':not(:disabled)').attr("type") != "checkbox"){
		$applyTbodyObj.find('.' + target + ':not(:disabled)').val(newValue);
	}
}

