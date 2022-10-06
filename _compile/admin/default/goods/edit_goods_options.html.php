<?php /* Template_ 2.2.6 2022/05/17 12:31:49 /www/music_brother_firstmall_kr/admin/skin/default/goods/edit_goods_options.html 000086434 */ 
$TPL_frequentlyoptlistAll_1=empty($TPL_VAR["frequentlyoptlistAll"])||!is_array($TPL_VAR["frequentlyoptlistAll"])?0:count($TPL_VAR["frequentlyoptlistAll"]);
$TPL_options_1=empty($TPL_VAR["options"])||!is_array($TPL_VAR["options"])?0:count($TPL_VAR["options"]);
$TPL_frequentlyoptlist_1=empty($TPL_VAR["frequentlyoptlist"])||!is_array($TPL_VAR["frequentlyoptlist"])?0:count($TPL_VAR["frequentlyoptlist"]);?>
<script type="text/javascript">

var gl_basic_currency					= "<?php echo $TPL_VAR["config_system"]["basic_currency"]?>";	//기본통화
//var gl_skin_currency					= "<?php echo $TPL_VAR["config_system"]["compare_currency"]?>";		//비교통화
var gl_basic_currency_symbol			= "<?php echo $TPL_VAR["config_currency"][$TPL_VAR["basic_currency"]]['currency_symbol']?>";
var gl_basic_currency_symbol_position	= "<?php echo $TPL_VAR["config_currency"][$TPL_VAR["basic_currency"]]['currency_symbol_position']?>";
var gl_amout_list						= new Array();
<?php if(is_array($TPL_R1=$TPL_VAR["config_system"]["basic_amout"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
gl_amout_list['<?php echo $TPL_K1?>'] = '<?php echo $TPL_V1?>';
<?php }}?>
var gl_currency_exchange = "<?php echo $TPL_VAR["config_currency"][$TPL_VAR["basic_currency"]]['currency_exchange']?>";


$(document).ready(function(){
// 목록형태로 노출되지 않는 object만 여기서 event를 일괄로 잡는다.
// 목록형태로 n개 노출되는 object는 해당 object에 각각 event를 잡아야 함.

	// 옵션 생성
	$("#optionMake").bind("click",function(){
		openDialog("필수옵션", "optionMakePopup", {"width":"1150","height":"500","show" : "fade","hide" : "fade"});
		$("input[name='optionMakeDepth']").val('<?php echo count($TPL_VAR["options"][ 0]["option_divide_title"])+ 1?>');
		$("input[name='optionName']").val('');
		$("input[name='optionPrice']").val('');
	});
	
	// 옵션 관리
	$("#optionSetting").bind("click",function(){
		openDialog("자주쓰는 상품의 옵션 관리", "optionSettingPopup", {"width":"500","height":"500","show" : "fade","hide" : "fade"});
	});

	// 특수옵션 개별 수정 시 저장
	$("#goodsoptiondirectmodifybtn").bind("click",function(){
		var newtype		= $(this).attr("newtype");
		var opttblidx	= $(this).attr("opttblidx");
		goodsoptiondirectmodify(opttblidx, newtype);

		if	(newtype == 'color' || newtype == 'address' || newtype == 'date'){
			$("#gdoptdirectmodifylay input[name='newType']").val(newtype);
			$("#gdoptdirectmodifylay input[name='tmpSeq']").val('<?php echo $TPL_VAR["tmp_seq"]?>');
			loadingStart();
			$("#specialOption").submit();
		}else{
			closeDialog("gdoptdirectmodifylay");
		}
	});

	// 자주사용하는 옵션 가져오기
	$("#frequentlytypeoptbtn").bind("click",function(){
		var add_goods_seq = $("select[name='frequentlytypeopt']").find("option:selected").val();
		if( add_goods_seq<=0 ){
			alert("옵션정보를 가져올 상품을 선택해 주세요!");
			return false;
		}
		var goods_name = $("select[name='frequentlytypeopt']").find("option:selected").text();
		openDialogConfirm('정말로 ['+goods_name+'] 상품의 <br/>필수옵션 정보를 가져오시겠습니까?',400,200,function(){
			opener.openSettingOptionnew(add_goods_seq);
		});
	});

    // 우편번호 검색
    $(".direct_zipcode_btn").bind("click",function(){
		openDialogZipcode('direct_');
    });

	// 일괄저장 버튼
	$(".save_all").bind("click", function(){
		
		var targetId		= $(this).attr('id');

		if	(targetId == 'reserve_rate_all' && $("select[name='reserve_policy']").val() == 'shop'){
			openDialogAlert("캐시 일괄적용은 캐시 지급정책이 개별정책 입력일 경우에만 가능합니다.", 550, 150 );
			return;
		}else{
			if($('select[name="commission_type_all"]').val() != 'SUPR' && targetId == 'commission_rate_all'){
				if($("input[name='"+targetId+"']").val() > 100){
					$("input[name='"+targetId+"']").val('');
					openDialogAlert("수수료율은 100%를 넘을 수 없습니다.", 400, 160 );
					return false;
				}
			}
			
			var href	= '../goods_process/save_tmpoption_cell?tmpSeq=<?php echo $TPL_VAR["tmp_seq"]?>&target='+targetId;

			if (targetId == 'option_view_all' ) {
				href	+= '&value='+$("select[name='"+targetId+"']").val();
			} else if (targetId != 'infomation_all') {
				href	+= '&value='+$("input[name='"+targetId+"']").val();
			} else {
				href	+= '&value='+$("textarea[name='"+targetId+"']").val();
				$("#applyAllOptInfomation").dialog("close");
			}

			if(targetId == 'commission_rate_all' && $(this).attr('commission_type') != 'SACO')
				href	+= "&commission_type="+$('select[name="commission_type_all"]').val();
			else if(targetId == 'commission_rate_all' && $(this).attr('commission_type') == 'SACO')
				href	+= "&commission_type=SACO"

			// 캐시는 단위까지 넘어가야 한다.
			if	(targetId == 'reserve_rate_all'){
				href	+= '&reserve_unit='+$("select[name='reserve_unit_all']").val();
			}

			// 할인가(판매가) 일괄변경시 캐시 설정 상태 전달
			if	( targetId == 'price_all' ){
				href	+= '&reserve_policy='+$("select[name='reserve_policy']").val();
			}

			if(targetId == 'infomation_all') {
				var infoText	= $.trim($("textarea[name='"+targetId+"']").val());
				if (!infoText)
					$('.viewInfomationTextAll').html('미입력');
				else
					$('.viewInfomationTextAll').html('보기');
			}

			optionFrame.location.href	= href;
		}
	});

	// 상품 상세 페이지에 적용
	$("#setTmpSeq").bind("click", function(){
		$("form[name='tmp_option_form']").attr('action', '../goods_process/chk_tmpoption_require');
		$("form[name='tmp_option_form']").submit();
	});

	setDatepicker($(".datepicker"));

	// 옵션 한줄 추가
	$("#addOption").click(function(){
		var trobj	= $("input[name='default_option']:checked").closest('tr');
		var seq		= trobj.find("input[name='option_seq[]']").val();
		optionFrame.location.replace('../goods_process/save_option_one_row?saveType=add&tmpSeq=<?php echo $_GET["tmp_seq"]?>&optionSeq='+seq);
	});

	$(".onlyfloat").live("keydown",function(e){
		if (e.keyCode!=190 && e.keyCode!=110) return onlynumber(e);
	}).live('focusin',function(){
		if($(this).val()=='0') $(this).val('');
	}).live('focusout',function(){
		if($(this).val()=='') $(this).val('0');
	});

	$("input[name='commission_rate_all'], input[name='commission_rate']").live("change",function(){
		var float_cnt	= this.value.match(/\.[0-9]+/g);
		if(float_cnt > 0 && float_cnt.toString().length > 3){
			alert('소숫점 2자리까지 가능합니다.(2자리 초과 절삭)');
		}
		var charge		= Math.floor((this.value * 100).toFixed(2)) / 100;
		this.value		= charge;
	});

	check_option_international_shipping(); // 해외 배송여부에 따른 레이어 폰트색상

	//정산방식이 수수료 기준이 아닌경우 단위 전체 리셋필요
<?php if($TPL_VAR["provider_info"]["commission_type"]!='SACO'||$TPL_VAR["provider_info"]["commission_type"]!=''){?>
	//$('select[name="commission_type"]').each(function(){this.focus();$(this).trigger('change');});
<?php }?>
	

	/* 상품코드 코드생성넣기*/
	$("#goodsCodeBtn").on("click", function(){openDialog("기본코드 자동생성", "makeGoodsCodLay", {"width":"400"});});
	$('#goodsCodeOpt').val($('#goodsCode', opener.document).val());

	var optionStockSetText	= opener.setOptionStockSetText();
	$('.optionStockSetText').html(optionStockSetText);
	
	$('input[name="default_option"]').on('change', function(){
		$('select[name="option_view"]').show();
		$('.option_view_only').hide();

		if (this.value == 'y') {
			var $option_view	= $(this).parent().parent().find('select[name="option_view"]');
			$option_view.val('Y').hide();
			$(this).parent().parent().find('.option_view_only').show();
			ready_input_save($option_view);
		}
		
	});

	$(document).on("click", '.delFreqOption', function(){
		var goods_seq = $(this).val();
		var type = $(this).data('type');
		if(!goods_seq){
			alert("상품 번호를 찾을 수 없습니다.");
			return false;
		}
		
		if(!type){
			alert("타입을 찾을 수 없습니다.");
			return false;
		}
		
		var popupID		= $(this).parents('div').attr('id');
		var page		= $(this).closest('div').find('.paging_navigation .on').text();
		var packageyn	= $(this).data('packageyn');
		
		var name = $('.delFreqOptionName_'+goods_seq).text();
		
		if(confirm(name + '를 삭제 하시겠습니까?')){
			delFreqOption(goods_seq, type, page, packageyn, popupID);
		}
	});
});

function set_option_to_opener(){
	set_option_internation_shipping();
	var tmp_frequently = ($("input[name='frequently']:checked"))?$("input[name='frequently']:checked").val():0;
<?php if($_GET["package_yn"]=='y'){?>
	save_package_tmp(tmp_frequently);
<?php }else{?>
	goodsCode	= $('#goodsCodeOpt').val();
	opener.setOptionTmp('<?php echo $TPL_VAR["tmp_seq"]?>',tmp_frequently, goodsCode);
	self.close();
<?php }?>
}

/****************** 리스트 수정 및 변경 처리 ******************************/

var saverObj	= new DomSaver('hideFormLay', 'post', '../goods_process/save_tmpoption_piece', 'optionFrame');
// 각 input을 클릭 시 저장 대기로 돌린다.
function ready_input_save(obj){
	//공급가 방식의 경우 단위까지 함께 적용
	saverObj.setTarget(obj);
	if	($(obj).val() == $(obj).attr('title') || $(obj).val() == 0){
		$(obj).val('');
	}
}

// 키 이벤트 처리
function key_input_value(evt, obj){
	var e			= evt || window.event;

	if	(e.keyCode == 13){
		var name	= $(obj).attr('name');
		var idx		= $("input[name='"+name+"']").index(obj) + 1;
		if	($("input[name='"+name+"']").eq(idx).attr('name')){
			$("input[name='"+name+"']").eq(idx).focus();
			ready_input_save(obj);
		}
	}
}


// 각 input의 폼값 저장
function save_input_value(obj){

	if	($(obj).attr('name') == 'default_option')	saverObj.setTarget(obj);

	var optionSeq				= $(obj).closest('tr').find("input[name='option_seq[]']").val();
	var param					= new Array();
	param['tmpSeq']				= '<?php echo $TPL_VAR["tmp_seq"]?>';
	param['optionSeq']			= optionSeq;
	param[$(obj).attr('name')]	= $(obj).val();

	if	($(obj).attr('name') == 'default_option' && $(obj).val() == 'y') {
		param['option_view'] = $(obj).parents('tr').find('[name="option_view"]');
	}

	// 입력 제한 체크
	if	($(obj).attr('name') == 'coupon_input' && (!$(obj).val() || $(obj).val() < 1 || $(obj).val().search(/[^0-9]/) != -1)){
		openDialogAlert('쿠폰 1장의 값어치는 반드시 숫자 1이상이어야 합니다.', 400, 150, function(){
			$(obj).val('').css('border', '2px solid red').focus();
		});
		return false;
	}else{
		$(obj).css('border', '1px solid #cccccc');
	}

	// 변경 시 계산이 필요한 컬럼들 계산처리
	if	($(obj).attr('name') == 'price' || $(obj).attr('name') == 'commission_rate' || $(obj).attr('name') == 'commission_type' || $(obj).attr('name') == 'consumer_price'|| $(obj).attr('name') == 'reserve_rate' || $(obj).attr('name') == 'reserve_unit'){
		var reserve = tmpOptCalculate(obj);

		if(reserve === false)	return;
		param['reserve']	= reserve;
	}

	saverObj.sendValue(param);

	if	(!$(obj).val())	$(obj).val($(obj).attr('title'));
	if	(!$(obj).val())	$(obj).val('0');
}

// 정산율 및 할인금액 변경 시 계산 처리
function tmpOptCalculate(obj){

	var calulateReserve	= false;
	var commission_cal	= 'NONE';
	var commission_type	= $(obj).closest("tr").find("select[name='commission_type']").val();
	var commission_type	= (commission_type) ? commission_type : 'SACO';
	var provider_seq	= '<?php echo $_GET["provider_seq"]?>';


	switch($(obj).attr('name')){
		case	'commission_type':	//수수료 변경시
		case	'commission_rate':	//수수료 변경시
			commission_cal	= commission_type;
			break;
		case	'consumer_price':	//정가 변경시
			commission_cal	= (commission_type != 'SACO') ? commission_type : 'NONE';
			break;
		case	'price' :			//판매가 변경시
			commission_cal	= (commission_type == 'SACO') ? commission_type : 'NONE';
		case	'reserve_rate' :	//적립율 변경시
		case	'reserve_unit' :	//적립율 단위 변경시
			calulateReserve	= true;
			break

	}

	if(commission_cal != 'NONE'){
		var sale_price			= $(obj).closest("tr").find("input[name='price']").val();
		var consumer_price		= $(obj).closest("tr").find("input[name='consumer_price']").val();
		var commission_rate		= $(obj).closest("tr").find("input[name='commission_rate']").val();

		switch(commission_type){
			case	'SACO' :
				var commission_price	= sale_price - get_currency_price(sale_price * (commission_rate / 100));
				break;
			case	'SUCO' :
				var commission_price	= consumer_price - get_currency_price(consumer_price * ((100-commission_rate) / 100));
				break;
			case	'SUPR' :
				var commission_price	= commission_rate;
				break;

		}

		if(commission_type != 'SUPR' && commission_rate > 100){
			var org_commission_rate		= $(obj).closest("tr").find("input[name='org_commission_rate']").val();
			$(obj).closest("tr").find("input[name='commission_rate']").val(org_commission_rate);

			if(commission_type == 'SUCO'){
				var org_commission_type		= $(obj).closest("tr").find("input[name='org_commission_type']").val();
				$(obj).closest("tr").find("select[name='commission_type']").val(org_commission_type);
			}

			openDialogAlert("수수료율은 100%를 넘을 수 없습니다.", 400, 160 );
			return false;
		}

		$(obj).closest("tr").find("input[name='org_commission_rate']").val(commission_rate);
		$(obj).closest("tr").find("input[name='org_commission_type']").val(commission_type);

		commission_price	= (provider_seq > 1) ? commission_price : 0;

		$(obj).closest("tr").find('.oCommissionPrice').html(commission_price);
	}


	// 정산율 변경 시 ==> 정산금액 계산
	if			($(obj).attr('name') == 'commission_rate'){
		// 정산금액 계산
		var price				= $(obj).closest("tr").find("input[name='price']").val();
		var commission_price	= num(price) - Math.floor( num(price) * (num_float($(obj).val()) / 100));

		//$(obj).closest("tr").find('.oCommissionPrice').html(comma(commission_price));

	// 할인금액 변경 시 ==> 정산금액 및 캐시 계산
	}else if	($(obj).attr('name') == 'price'){
		// 정산금액 계산
		var commission_rate		= $(obj).closest("tr").find("input[name='commission_rate']").val();
		var commission_price	= $(obj).val() - Math.floor($(obj).val() * (commission_rate / 100));
		//$(obj).closest("tr").find('.oCommissionPrice').html(comma(commission_price));

		calulateReserve	= true;

	// 적립율 또는 적립율 단위 변경 시 ==> 캐시 계산
	}else if	($(obj).attr('name') == 'reserve_rate' || $(obj).attr('name') == 'reserve_unit'){
		calulateReserve	= true;
	}

	// 캐시 계산
	if	(calulateReserve){
		var reserve				= '';
		var price				= $(obj).closest("tr").find("input[name='price']").val();
		// 통합정책
		if	($("select[name='reserve_policy']").val() == 'shop'){
			var reserve_rate	= '<?php echo $TPL_VAR["reserves"]["default_reserve_percent"]?>';
			var reserve_unit	= 'percent';

		// 개별정책
		}else{
			var reserve_rate	= $(obj).closest("tr").find("input[name='reserve_rate']").val();
			var reserve_unit	= $(obj).closest("tr").find("select[name='reserve_unit']").val();
		}

		if	(reserve_unit == 'percent')	reserve		= get_currency_price(price * (reserve_rate / 100),'basic',1);
		else reserve		= reserve_rate;

		$(obj).closest("tr").find(".reserve-shop").html(reserve);
		$(obj).closest("tr").find(".reserve").html(reserve);

		return reserve;
	}
}

// 전체 캐시 일괄 계산
function tmpReserveCalculate(){
	var reserve				= '';
	var reserve_rate		= '';
	var reserve_unit		= '';
	// 통합정책
	if	($("select[name='reserve_policy']").val() == 'shop'){
		reserve_rate		= '<?php echo $TPL_VAR["reserves"]["default_reserve_percent"]?>';
		reserve_unit		= 'percent';
	}

	$("input[name='price']").each(function(){
		// 통합정책
		if	($("select[name='reserve_policy']").val() == 'goods'){
			reserve_rate	= $(this).closest("tr").find("input[name='reserve_rate']").val();
			reserve_unit	= $(this).closest("tr").find("select[name='reserve_unit']").val();
		}

		if	(reserve_unit == 'percent')	reserve		= get_currency_price($(this).val() * (reserve_rate / 100),1);
		else reserve		= reserve_rate;

		$(this).closest("tr").find(".reserve-shop").html(reserve);
		$(this).closest("tr").find(".reserve").html(reserve);
	});
}

// selectbox disabled
function setDisableSelectbox(obj, disable){
	if	(disable){
		var orgVal	= $(obj).val();
		$(obj).css('background-color', '#f0f0f0');
		$(obj).find('option').css('background-color', '#f0f0f0');
		$(obj).bind("change", function(){
			$(obj).find("option[value='"+orgVal+"']").attr('selected', true);
		});
	}else{
		$(obj).css('background-color', '#fff');
		$(obj).find('option').css('background-color', '#fff');
		$(obj).unbind("change");
	}
}

// 캐시 정책 변경
function chgReservePolicy(obj){
	if	($(obj).val() == 'shop'){
		$("input[name='reserve_rate_all']").attr('disabled', true);
		setDisableSelectbox($("select[name='reserve_unit_all']"), true);
	}else{
		$("input[name='reserve_rate_all']").attr('disabled', false);
		setDisableSelectbox($("select[name='reserve_unit_all']"), false);
	}
	optionFrame.location.href	= '../goods_process/save_tmpoption_cell?tmpSeq=<?php echo $TPL_VAR["tmp_seq"]?>&target=tmp_policy_all&value='+$(obj).val();
}

// 일괄 변경 시 계산 처리
function tmpSaveAll(target, value, commission_type){
	if	(target == 'tmp_policy'){
		if	(value == 'goods'){
			$(".reserve-shop-lay").hide();
			$(".reserve-goods-lay").show();
		}else{
			$(".reserve-goods-lay").hide();
			$(".reserve-shop-lay").show();
		}

		tmpReserveCalculate();
	}else{

		if(target == 'commission_rate' && commission_type != 'SACO'){
			$("select[name='commission_type']").val(commission_type);
		}

		$("input[name='"+target+"'],select[name='"+target+"']").each(function(){
			
			if	(target == 'reserve_rate' || target == 'option_view'){
				
				if (target == 'reserve_rate') {
					$(this).val(value);
					$("select[name='reserve_unit']").val($("select[name='reserve_unit_all']").val());
				} else {
					$("select[name='" + target + "']:visible").val($("select[name='" + target + "_all']").val());
				}
				
			} else {

				$(this).val(value);

			}
			tmpOptCalculate($(this));
		});
	}
}

// 옵션 한줄 추가 ( script )
function add_option_row(optionSeq){
	var trobj	= $("input[name='default_option']:checked").closest('tr');
	var clone	= trobj.clone();
	clone.find("input[name='option_seq[]']").val(optionSeq);
	clone.find("input[name='default_option']").attr('checked', false);
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
	clone.find("td.scm-td-stock").html("");
	clone.find("td.scm-td-stock").html("0<input type='hidden' name='stock' value='0' />");
	clone.find("td.scm-td-badstock").html("");
	clone.find("td.scm-td-badstock").html("0<input type='hidden' name='badstock' value='0' />");
	clone.find("td.scm-td-supplyprice").html("");
	clone.find("td.scm-td-supplyprice").html("0<input type='hidden' name='supply_price' value='0' />");
	clone.find("input[name='safe_stock']").val(0);
<?php }?>
	clone.find("div.package_error script").remove();
	trobj.closest('tbody').append(clone);
}

// 옵션 한줄 제거
function removeOption(obj){
	var seq		= $(obj).closest('td').find("input[name='option_seq[]']").val();
	var isChecked = false;
	var tr = $(obj).closest('tr.optionTr');
	var defaultObj = tr.find("input[name='default_option']");
	if( defaultObj.length === 1 ) {
		isChecked = defaultObj.is(':checked');
	}
	if(isChecked === true) {
		alert("필수 옵션은 삭제할 수 없습니다.");
		defaultObj.focus();
		return false;
	}
	
	optionFrame.location.replace('../goods_process/save_option_one_row?saveType=del&tmpSeq=<?php echo $_GET["tmp_seq"]?>&optionSeq='+seq);
}

// 옵션 한줄 제거 ( script )
function del_option_row(optionSeq){
	if	($("input[name='option_seq[]'][value='"+optionSeq+"']").closest('tr').find("input[name='default_option']").is(':checked')){
		$("input[name='default_option']").eq(0).attr('checked', true);
	}
	$("input[name='option_seq[]'][value='"+optionSeq+"']").closest('tr').remove();
}
/****************** 리스트 수정 및 변경 처리 ******************************/



/****************** 특수옵션 개별 수정 팝업 ******************************/


//직접입력 > 색상
function chgColorOption(obj){
	var optSeq	= $(obj).closest('tr').find("input[name='option_seq[]']").val();
	if( $(obj).attr("opttype") && optSeq){
		$("#gdoptdirectmodifylay input[name='same_spc_save_type'][value='y']").attr('checked', true);
		$("#gdoptdirectmodifylay input[type='text']").val('');
		var opttblobj = $(obj).parents("tr");
		var opttblidx = opttblobj.index();
		$("#gdoptdirectmodifylay input[name='optionSeq']").val(optSeq);
		$("#gdoptdirectmodifylay input[name='optionNo']").val($(obj).attr('optno'));
		$("#goodsoptiondirectmodifybtn").attr("opttblidx",opttblidx);
		$("#goodsoptiondirectmodifybtn").attr("newtype","color");
		$("#gdoptdirectmodifylay div.goodsoptiondirectlay").hide();
		$("#gdoptdirectmodifylay div.colordateaddresslay").show();
		$("#gdoptdirectmodifylay div.colorlay").show();
		$("#gdoptdirectmodifylay div.datelay").hide();
		$("#gdoptdirectmodifylay div.addresslay").hide();
		$($("#gdoptdirectmodifylay input[name='direct_color']")).customColorPicker("destroy");
		$("#gdoptdirectmodifylay input[name='direct_color']").val(opttblobj.find("input[name='optcolor[]']").val());
		$($("#gdoptdirectmodifylay input[name='direct_color']")).customColorPicker();
		openDialog("색상 변경", "gdoptdirectmodifylay", {"width":"450","height":"300","show" : "fade","hide" : "fade"});
	}
}

//직접입력 > 지역
function chgAddressOption(obj){
	var optSeq	= $(obj).closest('tr').find("input[name='option_seq[]']").val();
	if( $(obj).attr("opttype") && optSeq){
		$("#gdoptdirectmodifylay input[name='same_spc_save_type'][value='y']").attr('checked', true);
		$("#gdoptdirectmodifylay input[type='text']").val('');
		var opttblobj = $(obj).parents("tr");
		var opttblidx = opttblobj.index();
		$("#gdoptdirectmodifylay input[name='optionSeq']").val(optSeq);
		$("#gdoptdirectmodifylay input[name='optionNo']").val($(obj).attr('optno'));
		$("#goodsoptiondirectmodifybtn").attr("opttblidx",opttblidx);
		$("#goodsoptiondirectmodifybtn").attr("newtype","address");
		$("#gdoptdirectmodifylay div.goodsoptiondirectlay").hide();
		$("#gdoptdirectmodifylay div.colordateaddresslay").show();
		$("#gdoptdirectmodifylay div.addresslay").show();
		$("#gdoptdirectmodifylay div.colorlay").hide();
		$("#gdoptdirectmodifylay div.datelay").hide();
		var zipcode = new Array();
		zipcode = opttblobj.find("input[name='optzipcode[]']").val();
		$("#gdoptdirectmodifylay input.direct_zipcode1").val(zipcode);
		$("#gdoptdirectmodifylay input[name='direct_address_type']").val(opttblobj.find("input[name='optaddress_type[]']").val());
		$("#gdoptdirectmodifylay input[name='direct_address']").val(opttblobj.find("input[name='optaddress[]']").val());
		$("#gdoptdirectmodifylay input[name='direct_address_street']").val(opttblobj.find("input[name='optaddress_street[]']").val());
		$("#gdoptdirectmodifylay input[name='direct_addressdetail']").val(opttblobj.find("input[name='optaddressdetail[]']").val());
		$("#gdoptdirectmodifylay input[name='direct_biztel']").val(opttblobj.find("input[name='optbiztel[]']").val());
		$("#gdoptdirectmodifylay input[name='direct_address_commission']").val(opttblobj.find("input[name='optaddress_commission[]']").val());
		openDialog("지역 변경", "gdoptdirectmodifylay", {"width":"450","height":"400","show" : "fade","hide" : "fade"});
		setDefaultText();
	}
}

//직접입력 > 날짜
function chgDateOption(obj){
	var optSeq	= $(obj).closest('tr').find("input[name='option_seq[]']").val();
	if( $(obj).attr("opttype") && optSeq){
		$("#gdoptdirectmodifylay input[name='same_spc_save_type'][value='y']").attr('checked', true);
		$("#gdoptdirectmodifylay input[type='text']").val('');
		var opttblobj = $(obj).parents("tr");
		var opttblidx = opttblobj.index();
		$("#gdoptdirectmodifylay input[name='optionSeq']").val(optSeq);
		$("#gdoptdirectmodifylay input[name='optionNo']").val($(obj).attr('optno'));
		$("#goodsoptiondirectmodifybtn").attr("opttblidx",opttblidx);
		$("#goodsoptiondirectmodifybtn").attr("newtype","date");
		$("#gdoptdirectmodifylay div.goodsoptiondirectlay").hide();
		$("#gdoptdirectmodifylay div.colordateaddresslay").show();
		$("#gdoptdirectmodifylay div.datelay").show();
		$("#gdoptdirectmodifylay div.colorlay").hide();
		$("#gdoptdirectmodifylay div.addresslay").hide();
		$("#gdoptdirectmodifylay input[name='direct_codedate']").val(opttblobj.find("input[name='codedate[]']").val());
		openDialog("날짜 변경", "gdoptdirectmodifylay", {"width":"450","height":"300","show" : "fade","hide" : "fade"});
	}
}

//직접입력 > 수동기간
function chgInputDateOption(obj){
	var optSeq	= $(obj).closest('tr').find("input[name='option_seq[]']").val();
	if( $(obj).attr("opttype") && optSeq){
		var opttblobj = $(obj).parents("tr");
		var opttblidx = opttblobj.index();
		$("#gdoptdirectmodifylay input[name='optionSeq']").val(optSeq);
		$("#gdoptdirectmodifylay input[name='optionNo']").val($(obj).attr('optno'));
		$("#goodsoptiondirectmodifybtn").attr("opttblidx",opttblidx);
		$("#goodsoptiondirectmodifybtn").attr("newtype","dayinput");
		$("#gdoptdirectmodifylay div.goodsoptiondirectlay").hide();
		$("#gdoptdirectmodifylay div.colordateaddresslay").hide();
		$("#gdoptdirectmodifylay div.dayinputlay").show();
		openDialog("수동기간 변경", "gdoptdirectmodifylay", {"width":"350","height":"150","show" : "fade","hide" : "fade"});
	}
}

//직접입력 > 자동기간
function chgAutoDateOption(obj){
	var optSeq	= $(obj).closest('tr').find("input[name='option_seq[]']").val();
	if( $(obj).attr("opttype") && optSeq){
		var opttblobj = $(obj).parents("tr");
		var opttblidx = opttblobj.index();
		$("#gdoptdirectmodifylay input[name='optionSeq']").val(optSeq);
		$("#gdoptdirectmodifylay input[name='optionNo']").val($(obj).attr('optno'));
		$("#goodsoptiondirectmodifybtn").attr("opttblidx",opttblidx);
		$("#goodsoptiondirectmodifybtn").attr("newtype","dayauto");
		$("#gdoptdirectmodifylay div.goodsoptiondirectlay").hide();
		$("#gdoptdirectmodifylay div.colordateaddresslay").hide();
		$("#gdoptdirectmodifylay div.dayautolay").show();
		openDialog("자동기간 변경", "gdoptdirectmodifylay", {"width":"350","height":"150","show" : "fade","hide" : "fade"});
	}
}

//직접입력 > 개별수정레이어창에서 수정하기
function goodsoptiondirectmodify(opttblidx, newtype) {
	var opttblobj = $("div#optionLayer tr.optionTr").eq(opttblidx);
	switch(newtype){
		case "color":
			var optcolor = $("#gdoptdirectmodifylay input[name='direct_color']").val();
			if	($("#gdoptdirectmodifylay input[name='same_spc_save_type']:checked").val() == 'y'){
				var optName = $(opttblobj.find("div.colorhelpicon")).closest("td").find("input.optionval").attr("name");
				var optValue = $(opttblobj.find("div.colorhelpicon")).closest("td").find("input.optionval").val();
				$("div#optionLayer tr.optionTr").find("input[name='"+optName+"'][value='"+optValue+"']").each(function(i){
					var otherOpttblobj	= $(this).closest("tr.optionTr");
					otherOpttblobj.find("input[name='optcolor[]']").val(optcolor);
					otherOpttblobj.find("div.colorhelpicon").css("background-color",optcolor);
					otherOpttblobj.find("div.colorhelpicon").attr("title", "[색상]을 클릭하여 변경할 수 있습니다.");
					$(otherOpttblobj.find("div.colorhelpicon")).customColorPicker(optcolor);//colorpickerlay();
				});
			}else{
				opttblobj.find("input[name='optcolor[]']").val(optcolor);
				opttblobj.find("div.colorhelpicon").css("background-color",optcolor);
				opttblobj.find("div.colorhelpicon").attr("title", "[색상]을 클릭하여 변경할 수 있습니다.");
				$(opttblobj.find("div.colorhelpicon")).customColorPicker(optcolor);//colorpickerlay();
			}
		break;
		case "address":
			var direct_zipcode1 = $("#gdoptdirectmodifylay input.direct_zipcode1").val();
			var direct_zipcode2 = $("#gdoptdirectmodifylay input.direct_zipcode2").val();
			var optaddress_type = $("#gdoptdirectmodifylay input[name='direct_address_type']").val();
			var optaddress = $("#gdoptdirectmodifylay input[name='direct_address']").val();
			var optaddress_street = $("#gdoptdirectmodifylay input[name='direct_address_street']").val();
			optaddress_street = optaddress_street.replace(",","&");
			var optaddressdetail = $("#gdoptdirectmodifylay input[name='direct_addressdetail']").val();
			var optbiztel = $("#gdoptdirectmodifylay input[name='direct_biztel']").val();
			var optaddress_commission = $("#gdoptdirectmodifylay input[name='direct_address_commission']").val();
			var addresstitle = "["+direct_zipcode1+"] <br> (지번) "+optaddress + optaddressdetail + " <br>(도로명) "+optaddress_street + optaddressdetail + " <br>  연락처:" + optbiztel + "<br/>[지역]을 클릭하여 변경할 수 있습니다.";
			addresstitle += "<br/>수수료 : "+optaddress_commission+"%";
			if	($("#gdoptdirectmodifylay input[name='same_spc_save_type']:checked").val() == 'y'){
				var optName = $(opttblobj.find("span.addrhelpicon")).closest("td").find("input.optionval").attr("name");
				var optValue = $(opttblobj.find("span.addrhelpicon")).closest("td").find("input.optionval").val();
				$("div#optionLayer tr.optionTr").find("input[name='"+optName+"'][value='"+optValue+"']").each(function(i){
					var otherOpttblobj	= $(this).closest("tr.optionTr");
					otherOpttblobj.find("input[name='optbiztel[]']").val(optbiztel);
					otherOpttblobj.find("input[name='optaddressdetail[]']").val(optaddressdetail);
					otherOpttblobj.find("input[name='optaddress_type[]']").val(optaddress_type);
					otherOpttblobj.find("input[name='optaddress[]']").val(optaddress);
					otherOpttblobj.find("input[name='optaddress_street[]']").val(optaddress_street);
					otherOpttblobj.find("input[name='optzipcode[]']").val(direct_zipcode1+"-"+direct_zipcode2);
					otherOpttblobj.find("input[name='optaddress_commission[]']").val(optaddress_commission);
					otherOpttblobj.find("span.addrhelpicon").attr("title",addresstitle);
				});
			}else{
				opttblobj.find("input[name='optbiztel[]']").val(optbiztel);
				opttblobj.find("input[name='optaddressdetail[]']").val(optaddressdetail);
				opttblobj.find("input[name='optaddress_type[]']").val(optaddress_type);
				opttblobj.find("input[name='optaddress[]']").val(optaddress);
				opttblobj.find("input[name='optaddress_street[]']").val(optaddress_street);
				opttblobj.find("input[name='optzipcode[]']").val(direct_zipcode1+"-"+direct_zipcode2);
				opttblobj.find("input[name='optaddress_commission[]']").val(optaddress_commission);
				opttblobj.find("span.addrhelpicon").attr("title",addresstitle);
			}
		break;
		case "date":
			var codedate = $("#gdoptdirectmodifylay input[name='direct_codedate']").val();
			if	($("#gdoptdirectmodifylay input[name='same_spc_save_type']:checked").val() == 'y'){
				var optName = $(opttblobj.find("span.codedatehelpicon")).closest("td").find("input.optionval").attr("name");
				var optValue = $(opttblobj.find("span.codedatehelpicon")).closest("td").find("input.optionval").val();
				$("div#optionLayer tr.optionTr").find("input[name='"+optName+"'][value='"+optValue+"']").each(function(i){
					var otherOpttblobj	= $(this).closest("tr.optionTr");
					otherOpttblobj.find("input[name='codedate[]']").val(codedate);
					otherOpttblobj.find("span.codedatehelpicon").attr("title",codedate + "<br/>[날짜]를 클릭하여 변경할 수 있습니다.");
				});
			}else{
				opttblobj.find("input[name='codedate[]']").val(codedate);
				opttblobj.find("span.codedatehelpicon").attr("title",codedate + "<br/>[날짜]를 클릭하여 변경할 수 있습니다.");
			}
		break;
	}
	help_tooltip();
	closeDialog("gdoptdirectmodifylay");
}

function check_able_option(iobj){
	var obj = $(iobj);
	if( $("div#optionLayer table.info-table-style tr.optionTr").length == 0 ){
		obj.attr("checked",false);
		alert("적용할 옵션을 생성해 주세요.");
		return false;
	}

	return true;
}

/****************** 특수옵션 개별 수정 팝업 ******************************/

/* 해외 배송여부에 따른 레이어 폰트색상*/
function check_option_international_shipping()
{
	var input_checked = $("input[name='option_international_shipping_status_view']").attr("checked");

	if ( input_checked ){
		$("div#option_international_shipping_layer").css("color","#000000");
	}else{
		$("div#option_international_shipping_layer").css("color","#6d6d6d");
	}
}

function dialog_international_shipping()
{
	openDialog("안내) 해외배송", "dialog_international_shipping", {"width":570,"height":200});
}

function set_option_internation_shipping(){
	var chk = $("input[name='option_international_shipping_status_view']").attr("checked");
	if(chk){
		opener.set_option_international_shipping_popup('y');
	}else{
		opener.set_option_international_shipping_popup('n');
	}
}

function save_package_tmp(tmp_frequently){
	var fobj = $("form#save_package_tmp");
	fobj.html("<input type='hidden' name='save_tmp_package_count[]' value='"+$("input[name='reg_package_count']").val()+"'>");
	fobj.append("<input type='hidden' name='tmp_no' value='<?php echo $TPL_VAR["tmp_seq"]?>'>");
	fobj.append("<input type='hidden' name='tmp_frequently' value='"+tmp_frequently+"'>");
	$("input[name='reg_package_option_seq1[]'").each(function(){

		fobj.append("<input type='hidden' name='save_tmp_package_option_seq[]' value='"+$(this).closest('table').closest('tr').find("input[name='option_seq[]']").val()+"'>");

		fobj.append("<input type='hidden' name='save_tmp_package_option_seq1[]' value='"+$(this).val()+"'>");
	});
	$("input[name='reg_package_option_seq2[]'").each(function(){
		fobj.append("<input type='hidden' name='save_tmp_package_option_seq2[]' value='"+$(this).val()+"'>");
	});
	$("input[name='reg_package_option_seq3[]'").each(function(){
		fobj.append("<input type='hidden' name='save_tmp_package_option_seq3[]' value='"+$(this).val()+"'>");
	});
	$("input[name='reg_package_option_seq4[]'").each(function(){
		fobj.append("<input type='hidden' name='save_tmp_package_option_seq4[]' value='"+$(this).val()+"'>");
	});
	$("input[name='reg_package_option_seq5[]'").each(function(){
		fobj.append("<input type='hidden' name='save_tmp_package_option_seq5[]' value='"+$(this).val()+"'>");
	});

	$("input[name='package_unit_ea1[]'").each(function(){
		fobj.append("<input type='hidden' name='save_tmp_package_unit_ea1[]' value='"+$(this).val()+"'>");
	});
	$("input[name='package_unit_ea2[]'").each(function(){
		fobj.append("<input type='hidden' name='save_tmp_package_unit_ea2[]' value='"+$(this).val()+"'>");
	});
	$("input[name='package_unit_ea3[]'").each(function(){
		fobj.append("<input type='hidden' name='save_tmp_package_unit_ea3[]' value='"+$(this).val()+"'>");
	});
	$("input[name='package_unit_ea4[]'").each(function(){
		fobj.append("<input type='hidden' name='save_tmp_package_unit_ea4[]' value='"+$(this).val()+"'>");
	});
	$("input[name='package_unit_ea5[]'").each(function(){
		fobj.append("<input type='hidden' name='save_tmp_package_unit_ea5[]' value='"+$(this).val()+"'>");
	});
	fobj[0].submit();
}

function applyAllOptInfomation() {openDialog('옵션 설명', "applyAllOptInfomation", {"width":"450","show" : "fade","hide" : "fade"});}

function applyOptInfomation(infomationIdx) {
	var orgValue	= $('#infomation_' + infomationIdx).val();
	$('#tmpInfomation').val(orgValue);
	$('#tmpInfomationIdx').val(infomationIdx);
	openDialog('옵션 설명', "applyOptInfomation", {"width":"450","show" : "fade","hide" : "fade"});
}

function doApplyOptInfomation() {
	$('#applyOptInfomation').dialog('close');
	var infomationIdx	= $('#tmpInfomationIdx').val();
	var newValue		= $.trim($('#tmpInfomation').val());
	$('#infomation_' + infomationIdx).val(newValue);
	ready_input_save($('#infomation_' + infomationIdx))
	save_input_value($('#infomation_' + infomationIdx));
	
	if (!newValue)
		$('#viewInfomationText_' + infomationIdx).html('미입력');
	else
		$('#viewInfomationText_' + infomationIdx).html('보기');

}


function makeGoodsCode() {
	var goodscetegory		= '';//대표카테고리
	var goodsbrand			= '';//대표브랜드
	var goodslocation		= '';//대표지역

	var selectectid			= '';
	var selectectseq		= '';
	var selectectcode		= '';
	var goodsaddinfoseqar	= new Array();//추가정보처리
	var goodsaddinfocodear	= new Array();//추가정보처리

	goodscetegory			= $("input:radio[name='firstCategory']:checked", opener.document).val();
	goodsbrand				= $("input:radio[name='firstBrand']:checked", opener.document).val();
	goodslocation			= $("input:radio[name='firstLocation']:checked", opener.document).val();

	$("select[name='selectEtcTitle[]']",opener.document).each(function(){


		selectectid			= $(this).find("option:selected").val();

		if (selectectid) {

			var idx			= $(this).index($(this));

			if (selectectid.substr(0,12) == 'goodsaddinfo') {
				selectectcode	= $(this).parent().parent().find("."+selectectid+" option:selected").val();
				selectectseq	= $(this).parent().parent().find("."+selectectid).attr("label_codeform_seq");
				goodsaddinfoseqar.push(selectectid.replace("goodsaddinfo_",""));
				goodsaddinfocodear.push(selectectcode);
			}

		}

	});

	var goodsaddinfoseq		= goodsaddinfoseqar.join(',');
	var goodsaddinfocode	= goodsaddinfocodear.join(',');

	$.ajax({
		type: "post",
		url: "../goods_process/tmpgoodscode",
		data: "no=" + gl_goods_seq + "&category_goods_code="+goodscetegory+"&brand_goods_code="+goodsbrand+"&location_goods_code="+goodslocation+"&addtion_goods_seq="+goodsaddinfoseq+"&addtion_goods_code="+goodsaddinfocode,
		success: function(result){
			$("#goodsCode", opener.document).val(result);
			$(".goodsCode", opener.document).html(result);
			$("#goodsCodeOpt").val(result);
			$("#makeGoodsCodLay").dialog('close');
		}
	});
}

//옵션관리
function delFreqOption(goods_seq, type, page, packageyn, popupID){
	if( !goods_seq || goods_seq <= 0 ){
		alert("상품 번호를 찾을 수 없습니다.");
		return false;
	}
	
	if( !type ){
		alert("타입을 찾을 수 없습니다.");
		return false;
	}

	$.ajax({
		'url' : '../goods_process/del_freq_option',
		'data' : {'goods_seq': goods_seq, 'type': type},
		'type' : 'post',
		'success' : function(res){
			if(res === false){
				alert("삭제 실패");
			} else {
				$(".delFreqOptionName_"+goods_seq).parent().parent().remove();
				if (type == "opt") {
					$('select[name="frequentlytypeopt"] option[value="'+goods_seq+'"]').remove();
				} else if (type == "sub") {
					$('select[name="frequentlytypesubopt"] option[value="'+goods_seq+'"]').remove();
				} else if (type == "inp") {
					$('select[name="frequentlytypeinputopt"] option[value="'+goods_seq+'"]').remove();
				}
				
				frequentlypaging(page, type, packageyn, popupID);
				alert("삭제 성공");
			}
		}
	});
}

function frequentlypaging(page, type, packageyn, popupID){
	$.ajax({
		'url' : '../goods_process/get_freq_paging',
		'data' : {'page': page, 'type': type, 'packageyn': packageyn, 'popupID': popupID},
		'type' : 'post',
		'success' : function(res){
			var data = jQuery.parseJSON(res);
			var result = data.result;
			
			if(result.length > 0){
				$("#"+popupID+" table tbody").html('');
				
				$.each(result, function(key, item) {
					var contents = '<tr>';
					contents += '<td><span class="delFreqOptionName_'+item.goods_seq+'">'+item.goods_name+'</span></td>';
					contents += '<td class="its-th-align center">';
					contents += '<span class="btn small"><button type="button" class="delFreqOption" value="'+item.goods_seq+'" data-type="opt">삭제</button></span>';
					contents += '</td>';
					contents += '</tr>';
					
					$("#"+popupID+" table tbody").append(contents);
				});
			} else {
				$("#"+popupID+" table tbody").html('');
				$("#"+popupID+" table tbody").html('<tr> <td colspan="2" class="its-th-align center">데이터 없음</td></tr>');
			}
			
			$("#"+popupID+" .paging_navigation").html(data.paging);
		}
	});
}


</script>

<form name="tmp_option_form" method="post" target="optionFrame" action="about:blank;">
<input type="hidden" name="goods_seq" value="<?php echo $TPL_VAR["goods_seq"]?>" />
<input type="hidden" name="socialcp_input_type" value="<?php echo $_GET["socialcp_input_type"]?>" />

<?php if($_GET["package_yn"]=='y'){?>
<input type="hidden" name="reg_package_count" value="<?php echo $TPL_VAR["package_count"]?>">
<input type="hidden" name="tmp_option_seq" value="<?php echo $_GET["tmp_seq"]?>">
<input type="hidden" name="use_warehouse" value="|<?php echo implode('|',array_keys($TPL_VAR["scm_cfg"]['use_warehouse']))?>|" />
<?php }?>
<div class="top_title">필수옵션</div>
<div style="width:99%;padding:10px;">
	<div id="optionLayer">
		<div class="top_btn_area">
			<div class="left">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["scmTotalStock"]> 0){?>
				<select class="gray">
					<option value="0">자주 쓰는 상품의 필수옵션 </option>
				</select>을
				<span class="btn small cyanblue"><button type="button">가져오기</button></span>
				또는
				<span class="btn small cyanblue"><button type="button" >생성 및 변경</button></span>
<?php }else{?>
				<span id="frequentlytypeoptlay">
					<select name="frequentlytypeopt" class="frequentlytypeopt" style="width:300px">
						<option value="0">자주 쓰는 상품의 필수옵션 </option>
<?php if($TPL_VAR["frequentlyoptlistAll"]){?>
<?php if($TPL_frequentlyoptlistAll_1){foreach($TPL_VAR["frequentlyoptlistAll"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["goods_seq"]?>"  ><?php echo strip_tags($TPL_V1["goods_name"])?></option>
<?php }}?>
<?php }?>
					</select>을
					<span class="btn small cyanblue"><button type="button" id="frequentlytypeoptbtn" goods_seq="<?php echo $TPL_VAR["goods_seq"]?>">가져오기</button></span>
				</span>
				또는
				<span class="btn small cyanblue"><button type="button" id="optionMake" goods_seq="<?php echo $TPL_VAR["goods_seq"]?>">생성 및 변경</button></span>
				<span class="btn small"><button type="button" id="optionSetting">옵션관리</button></span>
<?php }?>
			</div>
			<div class="cboth"></div>
		</div>

		<table class="info-table-style" style="width:100%;">
		<thead>
<?php if(count($TPL_VAR["options"][ 0]["option_divide_title"])> 0){?>
		<tr>
			<th class="its-th-align" colspan="<?php echo (count($TPL_VAR["options"][ 0]["option_divide_title"]))+ 2?>" >
				<b>일괄적용 →</b>
			</th>
<?php if($TPL_VAR["package_yn"]!='y'&&!$_GET["socialcp_input_type"]){?>
			<th class="its-th-align center" width="80">
				<input type="text" size="5" name="weight_all" class="onlynumber" value="" />
				<span class="btn small black"><button type="button" class="save_all" id="weight_all">▼</button></span>
			</th>
<?php }?>
<?php if($_GET["socialcp_input_type"]){?>
			<th class="its-th-align center">
				<input type="text" size="5" name="coupon_input_all" value="" />
				<span class="btn small black"><button type="button" class="save_all" id="coupon_input_all">▼</button></span>
			</th>
<?php }?>
<?php if($_GET["package_yn"]!='y'){?>
			<th class="its-th-align center">
<?php if($TPL_VAR["goods"]["provider_seq"]!= 1||$TPL_VAR["scm_cfg"]['use']!='Y'){?>
				<input type="text" size="5" name="stock_all" value="" />
				<span class="btn small black"><button type="button" class="save_all" id="stock_all">▼</button></span>
<?php }?>
			</th>
			<th class="its-th-align center">
<?php if($TPL_VAR["goods"]["provider_seq"]!= 1||$TPL_VAR["scm_cfg"]['use']!='Y'){?>
				<input type="text" size="5" name="badstock_all" value="" />
				<span class="btn small black"><button type="button" class="save_all" id="badstock_all">▼</button></span>
<?php }?>
			</th>
			<th class="its-th-align center">
				<input type="text" size="5" name="safe_stock_all" value="" />
				<span class="btn small black"><button type="button" class="save_all" id="safe_stock_all">▼</button></span>
			</th>
<?php }else{?>
			<th class="its-th-align center">
			</th>
<?php }?>
<?php if($TPL_VAR["goods"]["provider_seq"]== 1&&$_GET["package_yn"]!='y'){?>
			<th class="its-th-align center">
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'){?>
				<input type="text" size="5" name="supply_price_all" value="" />
				<span class="btn small black"><button type="button" class="save_all" id="supply_price_all">▼</button></span>
<?php }?>
			</th>
<?php }?>
			<th class="its-th-align center <?php if($_GET["provider_seq"]== 1){?>hide<?php }?>">
				<input type="text" size="5" class="onlyfloat" name="commission_rate_all" value="<?php echo $TPL_VAR["provider_info"]["charge"]?>"/>
<?php if($TPL_VAR["provider_info"]["commission_type"]=='SACO'||$TPL_VAR["provider_info"]["commission_type"]==''){?>
				%
				<input type="hidden" name="commission_type_all" class="commission_type">
<?php }else{?>
				<select name="commission_type_all" class="commission_type_sel">
					<option value="SUCO" <?php if($TPL_VAR["provider_info"]["commission_type"]!='SUPR'){?>selected<?php }?>>%</option>
					<option value="SUPR" <?php if($TPL_VAR["provider_info"]["commission_type"]=='SUPR'){?>selected<?php }?>>원</option>
				</select>
<?php }?>
				<span class="btn small black"><button type="button" class="save_all" id="commission_rate_all" commission_type = "<?php if($TPL_VAR["provider_info"]["commission_type"]=='SACO'||$TPL_VAR["provider_info"]["commission_type"]==''){?>SACO<?php }else{?><?php echo $TPL_VAR["provider_info"]["commission_type"]?><?php }?>">▼</button></span>
			</th>
			<th class="its-th-align center">
				<input type="text" size="5" name="consumer_price_all" value="" class="onlyfloat" />
				<span class="btn small black"><button type="button" class="save_all" id="consumer_price_all">▼</button></span>
				→
				<input type="text" size="5" name="price_all" value="" class="onlyfloat" />
				<span class="btn small black"><button type="button" class="save_all" id="price_all">▼</button></span>
			</th>
			<th class="its-th-align center">
				<input type="text" size="5" name="reserve_rate_all" value="" <?php if($TPL_VAR["goods"]["reserve_policy"]=='shop'){?>disabled<?php }?> />
				<select name="reserve_unit_all">
					<option value="percent">%</option>
					<option value="<?php echo $TPL_VAR["config_system"]['basic_currency']?>"><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
				</select>
				<span class="btn small black"><button type="button" class="save_all" id="reserve_rate_all">▼</button></span>
			</th>
			<th class="its-th-align">
				<select name="option_view_all">
					<option value="Y">노출</option>
					<option value="N">미노출</option>
				</select>
				<span class="btn small black"><button type="button" class="save_all" id="option_view_all">▼</button></span>
			</th>
			<th class="its-th-align">
				<span class="btn small"><button type="button" onclick="applyAllOptInfomation();">입력</button></span>
			</th>
		</tr>
<?php }?>
		<tr>
			<th class="its-th-align center" rowspan="2" width="25"><span class="btn-plus"><button type="button" id="addOption"></button></span></th>
			<th class="its-th-align center" rowspan="2"  width="38">기준</th>
			
<?php if($_GET["package_yn"]!='y'){?>
<?php if(is_array($TPL_R1=$TPL_VAR["options"][ 0]["option_divide_title"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><th class="its-th-align center" rowspan="2"><?php echo $TPL_V1?></th><?php }}?>
<?php if(!$_GET["socialcp_input_type"]){?><th class="its-th-align center" rowspan="2"  width="50">무게(Kg)</th><?php }?>
<?php }else{?>
			<th class="its-th-align center" <?php if(count($TPL_VAR["options"][ 0]["option_divide_title"])> 0){?>colspan="<?php echo count($TPL_VAR["options"][ 0]["option_divide_title"])?>"<?php }else{?>rowspan="2"<?php }?>>필수옵션</th>
<?php }?>

<?php if($_GET["socialcp_input_type"]){?>
			<th class="its-th-align center couponinputtitle" rowspan="2" width="100">쿠폰1장→값어치<br/><span class="couponinputsubtitle"><?php if($_GET["socialcp_input_type"]=='price'){?>금액<?php }else{?>횟수<?php }?></span></th>
<?php }?>
<?php if($_GET["package_yn"]=='y'){?>
			<th class="its-th-align center">
				<div class="pdb5">
					실제상품
					<span class="btn small"><button type="button" class="package_goods_make" onclick="package_goods_make();">검색</button></span>
				</div>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
				<?php echo $TPL_VAR["scm_cfg"]['admin_env_name']?> = <?php echo implode(', ',$TPL_VAR["scm_cfg"]['use_warehouse'])?>

				<input type="hidden" name="use_warehouse" value="|<?php echo implode('|',array_keys($TPL_VAR["scm_cfg"]['use_warehouse']))?>|" />
<?php }else{?>
				기본매장 = 기본창고
<?php }?>
				<span class="helpicon" title="해당 상점(매장)에서 판매 재고로 사용하는 창고 기준의 재고commission_type입니다."></span>
			</th>
<?php }else{?>
			<th class="its-th-align center" colspan="<?php if($TPL_VAR["goods"]["provider_seq"]== 1){?>4<?php }else{?>3<?php }?>">
<?php if($TPL_VAR["goods"]["provider_seq"]== 1){?>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
				<?php echo $TPL_VAR["scm_cfg"]['admin_env_name']?> = <?php echo implode(', ',$TPL_VAR["scm_cfg"]['use_warehouse'])?>

				<input type="hidden" name="use_warehouse" value="|<?php echo implode('|',array_keys($TPL_VAR["scm_cfg"]['use_warehouse']))?>|" />
<?php }else{?>
				기본매장 = 기본창고
<?php }?>
				<span class="helpicon" title="해당 상점(매장)에서 판매 재고로 사용하는 창고 기준의 재고입니다."></span>
<?php }else{?>
				<span class="storeinfo_title">재고: <?php echo $TPL_VAR["provider_info"]["provider_name"]?></span>
<?php }?>
			</th>
<?php }?>
			<!--th class="its-th-align center <?php if($_GET["provider_seq"]== 1){?>hide<?php }?>" rowspan="2" width="120">정산 금액</th-->
			<th class="its-th-align center <?php if($_GET["provider_seq"]== 1){?>hide<?php }?>" rowspan="2" width="130">
<?php if($TPL_VAR["provider_info"]["commission_type"]=='SACO'||$TPL_VAR["provider_info"]["commission_type"]==''){?>
				수수료
				<a href="javascript:helperMessage('SACO');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
<?php }else{?>
				<span class="SUCO_title">
					공급가
					<a href="javascript:helperMessage('SUPPLY');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
				</span>
<?php }?>
			</th>
			<th class="its-th-align center" rowspan="2" width="178">
				정가 → 판매가
				<span class="goods_required"></span>
				<a href="javascript:helperMessage('price');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
			</th>
			<th class="its-th-align center" rowspan="2" width="150">
				<div style="margin-bottom:5px;" >
<?php if(count($TPL_VAR["options"][ 0]["option_divide_title"])> 0){?>
					<select name="reserve_policy" onchange="chgReservePolicy(this);">
					<option value="shop">통합정책</option>
					<option value="goods" <?php if($TPL_VAR["goods"]["reserve_policy"]=='goods'){?>selected<?php }?>>개별정책 </option>
					</select>
<?php }?>
				</div>
				지급 캐시
			</th>
			<th class="its-th-align center optionStockSetText" rowspan="2" width="100"></th>
			<th class="its-th-align center" rowspan="2" width="60">
				<a href="javascript:helperMessageLayer('viewOption');">설명</a>
				<a href="javascript:helperMessage('optionInfomation');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
			</th>
		</tr>
		<tr>
<?php if($_GET["package_yn"]!='y'){?>
			<th class="its-th-align center">재고 <a href="javascript:helperMessage('stock');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a></th>
			<th class="its-th-align center">불량</th>
			<th class="its-th-align center">
				안전재고
<?php if($TPL_VAR["goods"]["provider_seq"]== 1&&$TPL_VAR["scm_cfg"]['use']){?>
					<a href="javascript:helperMessage('safeStockForScm', '<?php echo $TPL_VAR["scm_cfg"]['admin_env_name']?>');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
<?php }else{?>
					<a href="javascript:helperMessage('safeStock', '<?php if($TPL_VAR["goods"]["provider_seq"]== 1){?>기본매장<?php }else{?>입점사<?php }?>');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
<?php }?>
				

			</th>
<?php if($TPL_VAR["goods"]["provider_seq"]== 1){?>
			<th class="its-th-align center">매입가(평균)</th>
<?php }?>
<?php }else{?>
<?php if(is_array($TPL_R1=$TPL_VAR["options"][ 0]["option_divide_title"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><th class="its-th-align center"><?php echo $TPL_V1?></th><?php }}?>
			<th class="its-th-align center">
				<table class="reg_package_option_title_tbl">
					<tr>
					</tr>
				</table>
			</th>
			<script>reg_select_package_count();</script>
<?php }?>
		</tr>
		</thead>
<?php if(count($TPL_VAR["options"][ 0]["option_divide_title"])){?>
		<tbody>
<?php if($TPL_options_1){foreach($TPL_VAR["options"] as $TPL_K1=>$TPL_V1){?>
		<tr class="optionTr">
			<td class="its-td-align center">
				<input type="hidden" name="option_seq[]" value="<?php echo $TPL_V1["option_seq"]?>" />
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'||!$TPL_V1["total_stock"]){?>
				<span class="btn-minus"><button type="button" class="removeOption" onclick="removeOption(this);"></button></span>
<?php }?>
			</td>
			<td class="its-td-align center">
				<input type="radio" name="default_option" value="y" onclick="save_input_value(this);" <?php if($TPL_V1["default_option"]=='y'){?>checked<?php }?> />
			</td>
<?php if(is_array($TPL_R2=$TPL_V1["opts"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_K2=>$TPL_V2){$TPL_I2++;?>
			<td class="its-td-align left pdl5" width="<?php if($TPL_V1["divide_newtype"][$TPL_K2]){?>135<?php }else{?>80<?php }?>" valign="top">
				<input type="text" size="10" name="option<?php echo $TPL_I2+ 1?>" class="optionval" value="<?php echo $TPL_V2?>" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);" />
				<input type="hidden" name="newtype[<?php echo $TPL_I2?>]" value="<?php echo $TPL_V1["divide_newtype"][$TPL_K2]?>" />

<?php if($TPL_V1["divide_newtype"][$TPL_K2]){?>
<?php if($TPL_V1["divide_newtype"][$TPL_K2]=='color'){?>
						<input type="hidden"  name="optcolor[]" value="<?php echo $TPL_V1["color"]?>">
						<div class="colorPickerBtn colorhelpicon helpicon1" opttype="<?php echo $TPL_V1["option_divide_type"][$TPL_K2]?>" optno="<?php echo $TPL_K2+ 1?>" style="background-color:<?php echo $TPL_V1["color"]?>" title="[색상]을 클릭하여 변경할 수 있습니다." onclick="chgColorOption(this);"></div>
<?php }elseif($TPL_V1["divide_newtype"][$TPL_K2]=='address'){?>
						<input type="hidden"  name="optzipcode[]" value="<?php echo $TPL_V1["zipcode"]?>">
						<input type="hidden"  name="optaddress_type[]" value="<?php echo $TPL_V1["address_type"]?>">
						<input type="hidden"  name="optaddress[]" value="<?php echo $TPL_V1["address"]?>">
						<input type="hidden"  name="optaddress_street[]" value="<?php echo $TPL_V1["address_street"]?>">
						<input type="hidden"  name="optaddressdetail[]" value="<?php echo $TPL_V1["addressdetail"]?>">
						<input type="hidden"  name="optbiztel[]" value="<?php echo $TPL_V1["biztel"]?>">
						<input type="hidden"  name="optaddress_commission[]" value="<?php echo $TPL_V1["address_commission"]?>">
						<span class="addrhelpicon helpicon" opttype="<?php echo $TPL_V1["option_divide_type"][$TPL_K2]?>" title="<?php if($TPL_V1["zipcode"]){?>[<?php echo $TPL_V1["zipcode"]?>]  <br> (지번) <?php echo $TPL_V1["address"]?> <?php echo $TPL_V1["addressdetail"]?><br>(도로명) <?php echo $TPL_V1["address_street"]?> <?php echo $TPL_V1["addressdetail"]?>  <?php }else{?>지역 정보가 없습니다. <?php }?> <br/> <?php if($TPL_V1["biztel"]){?>업체 연락처:<?php echo $TPL_V1["biztel"]?><?php }?><br/>수수료: <?php echo $TPL_V1["address_commission"]?>%<br/>[지역]을 클릭하여 변경할 수 있습니다." optno="<?php echo $TPL_K2+ 1?>" onclick="chgAddressOption(this);">지역</span>
<?php }elseif($TPL_V1["divide_newtype"][$TPL_K2]=='date'){?>
						<input type="hidden"  name="codedate[]" value="<?php echo $TPL_V1["codedate"]?>">
						<span class="codedatehelpicon helpicon" opttype="<?php echo $TPL_V1["option_divide_type"][$TPL_K2]?>" title="<?php if($TPL_V1["codedate"]&&$TPL_V1["codedate"]!='0000-00-00'){?><?php echo $TPL_V1["codedate"]?> <?php }else{?>날짜 정보가 없습니다.<?php }?><br/>[날짜]를 클릭하여 변경할 수 있습니다." optno="<?php echo $TPL_K2+ 1?>" onclick="chgDateOption(this);">날짜</span>
<?php }elseif($TPL_V1["divide_newtype"][$TPL_K2]=='dayinput'){?>
						<input type="hidden"  name="sdayinput[]" value="<?php echo $TPL_V1["sdayinput"]?>">
						<input type="hidden"  name="fdayinput[]" value="<?php echo $TPL_V1["fdayinput"]?>">
						<span class="dayinputhelpicon helpicon" opttype="<?php echo $TPL_V1["option_divide_type"][$TPL_K2]?>" title="<?php if($TPL_V1["sdayinput"]&&$TPL_V1["fdayinput"]){?><?php echo $TPL_V1["sdayinput"]?> ~ <?php echo $TPL_V1["fdayinput"]?> <?php }else{?>수동기간 정보가 없습니다.<?php }?> <br/> [생성 및 변경]에서 변경할 수 있습니다." optno="<?php echo $TPL_K2+ 1?>" onclick="chgInputDateOption(this);">수동기간</span>
<?php }elseif($TPL_V1["divide_newtype"][$TPL_K2]=='dayauto'){?>
						<input type="hidden"  name="sdayauto[]" value="<?php echo $TPL_V1["sdayauto"]?>">
						<input type="hidden"  name="fdayauto[]" value="<?php echo $TPL_V1["fdayauto"]?>">
						<input type="hidden"  name="dayauto_type[]" value="<?php echo $TPL_V1["dayauto_type"]?>">
						<input type="hidden"  name="dayauto_day[]" value="<?php echo $TPL_V1["dayauto_day"]?>">
						<span class="dayautohelpicon helpicon" opttype="<?php echo $TPL_V1["option_divide_type"][$TPL_K2]?>" title="<?php if($TPL_V1["dayauto_type"]){?>'결제확인' <?php echo $TPL_V1["dayauto_type_title"]?> <?php echo $TPL_V1["sdayauto"]?>일 <?php if($TPL_V1["dayauto_type"]=='day'){?>이후<?php }elseif($TPL_V1["dayauto_type"]=='month'){?>부터<?php }?> + <?php echo $TPL_V1["fdayauto"]?>일<?php echo $TPL_V1["dayauto_day_title"]?> <?php }else{?>자동기간 정보가 없습니다.<?php }?> <br/>[생성 및 변경]에서 변경할 수 있습니다." optno="<?php echo $TPL_K2+ 1?>" onclick="chgAutoDateOption(this);">자동기간</span>
<?php }?>
<?php }?>

<?php if($_GET["package_yn"]!='y'){?>
				<br/>
				<input type="text" size="10" name="optioncode<?php echo $TPL_I2+ 1?>" value="<?php if($TPL_V1["optcodes"][$TPL_I2]!=''){?><?php echo $TPL_V1["optcodes"][$TPL_I2]?><?php }else{?>옵션코드<?php }?>" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);" title="옵션코드" />
<?php }else{?>
				<input type="hidden" name="optioncode<?php echo $TPL_I2+ 1?>" value="<?php echo $TPL_V1["optcodes"][$TPL_I2]?>" />
<?php }?>
			</td>
<?php }}?>
<?php if($_GET["package_yn"]!='y'&&!$_GET["socialcp_input_type"]){?>
			<td class="its-td-align center ">
				<input type="text" size="5" name="weight" value="<?php echo $TPL_V1["weight"]?>" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);">
			</td>
<?php }?>
<?php if($_GET["socialcp_input_type"]){?>
			<td class="its-td-align right pdr10">
				<input type="text" size="5" name="coupon_input" value="<?php echo $TPL_V1["coupon_input"]?>" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);" />
			</td>
<?php }?>

<?php if($_GET["package_yn"]=='y'){?>
			<td class="its-td-align">
				<table class="reg_package_option_tbl">
					<tr>
<?php if(is_array($TPL_R2=range( 1,$TPL_VAR["package_count"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2== 1){?>
						<td class="pdl5">
<?php if($TPL_V1["package_error_code1"]){?>
							<div class="package_error">
								<script>package_error_msg('<?php echo $TPL_V1["package_error_code1"]?>');</script>
							</div>
<?php }?>
							<div>
<?php if($TPL_V1["package_goods_seq1"]){?>
								<a href="/goods/view?no=<?php echo $TPL_V1["package_goods_seq1"]?>" target="_blank">
								<span class="reg_package_goods_seq1">[<?php echo $TPL_V1["package_goods_seq1"]?>]</span>
<?php }?>
								<span class="reg_package_goods_name1"><?php echo $TPL_V1["package_goods_name1"]?></span>
<?php if($TPL_V1["package_goods_seq1"]){?>
								</a>
<?php }?>
							</div>
							<div class="reg_package_option1"><?php echo $TPL_V1["package_option1"]?></div>
							<div class="reg_package_option_code1"><?php echo $TPL_V1["package_option_code1"]?> | <?php echo $TPL_V1["weight1"]?>kg</div>
							<div class="reg_package_unit_ea1">
								주문당
								<input type="text" name="package_unit_ea1[]" size="3" value="<?php echo $TPL_V1["package_unit_ea1"]?>" style="text-align:right;">
								발송 <span title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량" class="helpicon"></span>
							</div>
							<div class="reg_package_option_seq1">
<?php if($TPL_V1["package_option_seq1"]){?>
							<?php echo number_format($TPL_V1["package_stock1"])?>

							(<?php echo number_format($TPL_V1["package_badstock1"])?>)
							/
							<?php echo number_format($TPL_V1["package_ablestock1"])?>

							/
							<?php echo number_format($TPL_V1["package_safe_stock1"])?>

<?php }?>
							</div>
							<input type="hidden" name="reg_package_option_seq1[]" value="<?php echo $TPL_V1["package_option_seq1"]?>">
						</td>
<?php }?>
<?php if($TPL_V2== 2){?>
						<td class="pdl5">
<?php if($TPL_V1["package_error_code2"]){?>
							<div class="package_error">
								<script>package_error_msg('<?php echo $TPL_V1["package_error_code2"]?>');</script>
							</div>
<?php }?>
							<div>
<?php if($TPL_V1["package_goods_seq2"]){?>
								<a href="/goods/view?no=<?php echo $TPL_V1["package_goods_seq2"]?>" target="_blank">
								<span class="reg_package_goods_seq2">[<?php echo $TPL_V1["package_goods_seq2"]?>]</span>
<?php }?>
								<span class="reg_package_goods_name2"><?php echo $TPL_V1["package_goods_name2"]?></span>
<?php if($TPL_V1["package_goods_seq2"]){?>
								</a>
<?php }?>
							</div>
							<div class="reg_package_option2"><?php echo $TPL_V1["package_option2"]?></div>
							<div class="reg_package_option_code2"><?php echo $TPL_V1["package_option_code2"]?> | <?php echo $TPL_V1["weight2"]?>kg</div>
							<div class="reg_package_unit_ea2">
								주문당
								<input type="text" name="package_unit_ea2[]" size="3" value="<?php echo $TPL_V1["package_unit_ea2"]?>" style="text-align:right;">
								발송
								<span class="helpicon" title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량"></span>
							</div>
							<div class="reg_package_option_seq2">
<?php if($TPL_V1["package_option_seq2"]){?>
							<?php echo number_format($TPL_V1["package_stock2"])?>

							(<?php echo number_format($TPL_V1["package_badstock2"])?>)
							/
							<?php echo number_format($TPL_V1["package_ablestock2"])?>

							/
							<?php echo number_format($TPL_V1["package_safe_stock2"])?>

<?php }?>
							</div>
							<input type="hidden" name="reg_package_option_seq2[]" value="<?php echo $TPL_V1["package_option_seq2"]?>">
						</td>
<?php }?>
<?php if($TPL_V2== 3){?>
						<td class="pdl5">
<?php if($TPL_V1["package_error_code3"]){?>
							<div class="package_error">
								<script>package_error_msg('<?php echo $TPL_V1["package_error_code3"]?>');</script>
							</div>
<?php }?>
							<div>
<?php if($TPL_V1["package_goods_seq3"]){?>
								<a href="/goods/view?no=<?php echo $TPL_V1["package_goods_seq3"]?>" target="_blank">
								<span class="reg_package_goods_seq3">[<?php echo $TPL_V1["package_goods_seq3"]?>]</span>
<?php }?>
								<span class="reg_package_goods_name3"><?php echo $TPL_V1["package_goods_name3"]?></span>
<?php if($TPL_V1["package_goods_seq3"]){?>
								</a>
<?php }?>
							</div>
							<div class="reg_package_option3"><?php echo $TPL_V1["package_option3"]?></div>
							<div class="reg_package_option_code3"><?php echo $TPL_V1["package_option_code3"]?> | <?php echo $TPL_V1["weight3"]?>kg</div>
							<div class="reg_package_unit_ea3">
								주문당
								<input type="text" name="package_unit_ea3[]" size="3" value="<?php echo $TPL_V1["package_unit_ea3"]?>" style="text-align:right;">
								발송
								<span class="helpicon" title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량"></span>
							</div>
							<div class="reg_package_option_seq3">
<?php if($TPL_V1["package_option_seq3"]){?>
							<?php echo number_format($TPL_V1["package_stock3"])?>

							(<?php echo number_format($TPL_V1["package_badstock3"])?>)
							/
							<?php echo number_format($TPL_V1["package_ablestock3"])?>

							/
							<?php echo number_format($TPL_V1["package_safe_stock3"])?>

<?php }?>
							</div>
							<input type="hidden" name="reg_package_option_seq3[]" value="<?php echo $TPL_V1["package_option_seq3"]?>">
						</td>
<?php }?>
<?php if($TPL_V2== 4){?>
						<td class="pdl5">
<?php if($TPL_V1["package_error_code4"]){?>
							<div class="package_error">
								<script>package_error_msg('<?php echo $TPL_V1["package_error_code4"]?>');</script>
							</div>
<?php }?>
							<div>
<?php if($TPL_V1["package_goods_seq4"]){?>
								<a href="/goods/view?no=<?php echo $TPL_V1["package_goods_seq4"]?>" target="_blank">
								<span class="reg_package_goods_seq4">[<?php echo $TPL_V1["package_goods_seq4"]?>]</span>
<?php }?>
								<span class="reg_package_goods_name4"><?php echo $TPL_V1["package_goods_name4"]?></span>
<?php if($TPL_V1["package_goods_seq4"]){?>
								</a>
<?php }?>
							</div>
							<div class="package_option4"><?php echo $TPL_V1["package_option4"]?></div>
							<div class="reg_package_option_code4"><?php echo $TPL_V1["package_option_code4"]?> | <?php echo $TPL_V1["weight4"]?>kg</div>
							<div class="reg_package_unit_ea4">
								주문당
								<input type="text" name="package_unit_ea4[]" size="3" value="<?php echo $TPL_V1["package_unit_ea4"]?>" style="text-align:right;">
								발송
								<span class="helpicon" title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량"></span>
							</div>
							<div class="package_option_seq4">
<?php if($TPL_V1["package_option_seq4"]){?>
							<?php echo number_format($TPL_V1["package_stock4"])?>

							(<?php echo number_format($TPL_V1["package_badstock4"])?>)
							/
							<?php echo number_format($TPL_V1["package_ablestock4"])?>

							/
							<?php echo number_format($TPL_V1["package_safe_stock4"])?>

<?php }?>
							</div>
							<input type="hidden" name="reg_package_option_seq4[]" value="<?php echo $TPL_V1["package_option_seq4"]?>">
						</td>
<?php }?>
<?php if($TPL_V2== 5){?>
						<td class="pdl5">
<?php if($TPL_V1["package_error_code5"]){?>
							<div class="package_error">
								<script>package_error_msg('<?php echo $TPL_V1["package_error_code5"]?>');</script>
							</div>
<?php }?>
							<div>
<?php if($TPL_V1["package_goods_seq5"]){?>
								<a href="/goods/view?no=<?php echo $TPL_V1["package_goods_seq5"]?>" target="_blank">
								<span class="reg_package_goods_seq5">[<?php echo $TPL_V1["package_goods_seq5"]?>]</span>
<?php }?>
								<span class="reg_package_goods_name5"><?php echo $TPL_V1["package_goods_name5"]?></span>
<?php if($TPL_V1["package_goods_seq5"]){?>
								</a>
<?php }?>
							</div>
							<div class="reg_package_option5"><?php echo $TPL_V1["package_option5"]?></div>
							<div class="reg_package_option_code5"><?php echo $TPL_V1["package_option_code5"]?> | <?php echo $TPL_V1["weight5"]?>kg</div>
							<div class="reg_package_unit_ea5">
								주문당
								<input type="text" name="package_unit_ea5[]" size="3" value="<?php echo $TPL_V1["package_unit_ea5"]?>" style="text-align:right;">
								발송
								<span class="helpicon" title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량"></span>
							</div>
							<div class="reg_package_option_seq5">
<?php if($TPL_V1["package_option_seq5"]){?>
							<?php echo number_format($TPL_V1["package_stock5"])?>

							(<?php echo number_format($TPL_V1["package_badstock5"])?>)
							/
							<?php echo number_format($TPL_V1["package_ablestock5"])?>

							/
							<?php echo number_format($TPL_V1["package_safe_stock5"])?>

<?php }?>
							</div>
							<input type="hidden" name="reg_package_option_seq5[]" value="<?php echo $TPL_V1["package_option_seq5"]?>">
						</td>
<?php }?>
<?php }}?>
					</tr>
				</table>
			</td>
<?php }else{?>
<?php if($TPL_VAR["goods"]["provider_seq"]== 1&&$TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["goods"]["goods_seq"]> 0&&$TPL_V1["org_option_seq"]> 0){?>
			<td class="its-td-align right pdr10 scm-td-stock hand" onclick="scm_warehouse_on('<?php echo $TPL_VAR["goods"]["goods_seq"]?>', this);">
				<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V1["org_option_seq"]?>"><?php echo number_format($TPL_V1["stock"])?></span>
				<input type="hidden" name="stock" value="<?php echo $TPL_V1["stock"]?>" />
			</td>
<?php }elseif($TPL_VAR["goods"]["provider_seq"]== 1&&$TPL_VAR["scm_cfg"]['use']=='Y'){?>
			<td class="its-td-align right pdr10 scm-td-stock">
				<?php echo number_format($TPL_V1["stock"])?>

				<input type="hidden" name="stock" value="<?php echo $TPL_V1["stock"]?>" />
			</td>
<?php }else{?>
			<td class="its-td-align right pdr10">
				<input type="text" size="5" name="stock" value="<?php echo $TPL_V1["stock"]?>" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);" />
			</td>
<?php }?>
<?php if($TPL_VAR["goods"]["provider_seq"]== 1&&$TPL_VAR["scm_cfg"]['use']=='Y'){?>
			<td class="its-td-align right pdr10 scm-td-badstock">
				<?php echo number_format($TPL_V1["badstock"])?>

				<input type="hidden" name="badstock" value="<?php echo $TPL_V1["badstock"]?>" />
			</td>
<?php }else{?>
			<td class="its-td-align right pdr10">
				<input type="text" size="5" name="badstock" value="<?php echo $TPL_V1["badstock"]?>" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);" />
			</td>
<?php }?>
			<td class="its-td-align right pdr10">
				<input type="text" size="5" name="safe_stock" value="<?php echo $TPL_V1["safe_stock"]?>" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);" />
			</td>
<?php if($TPL_VAR["goods"]["provider_seq"]== 1){?>
			<td class="its-td-align right pdr10 scm-td-supplyprice">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
				<?php echo $TPL_V1["supply_price"]?>

				<input type="hidden" name="supply_price" value="<?php echo $TPL_V1["supply_price"]?>" />
<?php }else{?>
				<input type="text" size="5" name="supply_price" value="<?php echo $TPL_V1["supply_price"]?>" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);" />
<?php }?>
			</td>
<?php }?>
<?php }?>
			<td style="padding-right: 10px;" class="its-td-align right <?php if($_GET["provider_seq"]== 1){?>hide<?php }?>">
				<input type="text" size="5" class="onlyfloat" name="commission_rate" value="<?php echo $TPL_V1["commission_rate"]?>" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);" />
				<input type="hidden" class="onlyfloat" name="org_commission_rate" value="<?php echo $TPL_V1["commission_rate"]?>"/>
				<input type="hidden" class="onlyfloat" name="org_commission_type" value="<?php echo $TPL_V1["commission_type"]?>"/>

<?php if($TPL_VAR["provider_info"]["commission_type"]=='SACO'||$TPL_VAR["provider_info"]["commission_type"]==''){?>
				<input type="hidden" name="commission_type" class="commission_type" value="SACO" />
				%
<?php }else{?>
				<select name="commission_type" onfocus="ready_input_save(this);" onchange="save_input_value(this);">
					<option value="SUCO" <?php if($TPL_V1["commission_type"]!='SUPR'){?>selected<?php }?>>%</option>
					<option value="SUPR" <?php if($TPL_V1["commission_type"]=='SUPR'){?>selected<?php }?>><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
				</select>
<?php }?>

			</td>
			<td class="its-td-align right pdr10 pricetd">
				<input type="text" name="consumer_price" value="<?php echo $TPL_V1["consumer_price"]?>" size="5" style="color:#000;" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);" />
				→
				<input type="text" size="5" name="price" value="<?php echo $TPL_V1["price"]?>" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);" />
			</td>
			<td class="its-td-align right pdr10">
				<div class="reserve-shop-lay <?php if($TPL_VAR["goods"]["reserve_policy"]=='goods'){?>hide<?php }?>">
					<?php echo $TPL_VAR["reserves"]["default_reserve_percent"]?>%
					(<span class="reserve-shop"><?php echo get_currency_price($TPL_V1["shop_reserve"])?></span>)
				</div>
				<div class="reserve-goods-lay <?php if($TPL_VAR["goods"]["reserve_policy"]=='shop'){?>hide<?php }?>">
					<input type="text" size="5" name="reserve_rate" value="<?php echo $TPL_V1["reserve_rate"]?>" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);" />
					<select name="reserve_unit" onfocus="ready_input_save(this);" onchange="save_input_value(this);">
						<option value="percent">%</option>
						<option value="<?php echo $TPL_VAR["config_system"]['basic_currency']?>" <?php if($TPL_V1["reserve_unit"]==$TPL_VAR["config_system"]['basic_currency']){?>selected<?php }?>><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
					</select>
					(<span class="reserve"><?php echo get_currency_price($TPL_V1["reserve"])?></span>)
				</div>
			</td>
			<td class="its-td-align center">
				<span class="option_view_only <?php if($TPL_V1["default_option"]!='y'){?>hide<?php }?>">노출</span>
				<select name="option_view" class="option_view <?php if($TPL_V1["default_option"]=='y'){?>hide<?php }?>" onfocus="ready_input_save(this);" onchange="save_input_value(this);">
					<option value="Y" <?php if($TPL_V1["option_view"]!='N'||$TPL_V1["default_option"]=='y'){?>selected<?php }?>>노출</option>
					<option value="N" <?php if($TPL_V1["option_view"]=='N'){?>selected<?php }?>>미노출</option>
				</select>
			</td>
			<td class="its-td-align center">
				<input type="hidden" name="infomation" value="<?php echo $TPL_V1["infomation"]?>" id="infomation_<?php echo $TPL_K1?>">
				<a href="javascript:applyOptInfomation('<?php echo $TPL_K1?>')" id="viewInfomation_<?php echo $TPL_V1["key"]?>" idx="<?php echo $TPL_K1?>"><span class="viewInfomationTextAll" id="viewInfomationText_<?php echo $TPL_K1?>"><?php if($TPL_V1["infomation"]){?>보기<?php }else{?>미입력<?php }?></span></a>
				<!--textarea name="infomation" rows="3" width="width:90%;" onkeyup="key_input_value(event, this);" onfocus="ready_input_save(this);" onblur="save_input_value(this);"><?php echo $TPL_V1["infomation"]?></textarea-->
			</td>
		</tr>
<?php }}?>
		</tbody>
<?php }?>
		</table>

		<div class="hide" style="padding:5px; width:100%;" align="center">
			<div style="width:850px;text-align:left;" id="option_international_shipping_layer">
			 	<label><input type="checkbox" name="option_international_shipping_status_view" onchange="if(check_able_option(this))check_option_international_shipping();" value="y" <?php if($TPL_VAR["goods"]["option_international_shipping_status"]=='y'){?> checked="checked" <?php }?> > 이 상품은 해외에서 수입되는 해외 배송 상품입니다. → 주문 시 구매자로부터 관세청 통관 신고를 위한 개인통관고유부호를 수집합니다.</label>
			 	<span class="btn small orange"><button type="button"  onclick="dialog_international_shipping();">안내) 해외배송</button></span>
			 	<br/>※ 해외배송상품은 배송,반품,교환이 일반상품과 다르므로 배송비는 개별배송비 정책 사용을 권장 드립니다.
			 </div>
		</div>
		
<?php if($_GET["package_yn"]!='y'){?>
		<div class="center" style="padding:2px; padding-top:10px;"  id="frequentlay">
			<input type="text" id="goodsCodeOpt" value="">
<?php if($TPL_VAR["goodscodesettingview"]&&($_GET["no"]||$TPL_VAR["goods_seq"])){?>
			<span class="btn small"><button type="button" id="goodsCodeBtn" title="자동생성" >기본코드자동생성</button></span>
<?php }?>
			<a href="javascript:helperMessage('goodsCode');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
		</div>
<?php }?>
		<div class="center" style="padding:2px;"  id="frequentlay">
			이 상품의 옵션 정보를 자주 쓰는 상품의 필수옵션으로 사용하시겠습니까? <label><input type="checkbox" name="frequently" value="1" <?php if($TPL_VAR["goods"]["frequentlyopt"]== 1){?> checked="checked" <?php }?> onchange="check_able_option(this)">예, 사용하겠습니다.</label>
		</div>

		<div class="center" style="padding:10px;">
			<span class="btn large black"><button type="button" id="setTmpSeq">적용하기</button></span>
		</div>

	</div>
</div>

</form>

<!-- 직접입력 > 색상, 지역, 날짜  -->
<div id="gdoptdirectmodifylay" class="hide">
	<!-- 직접입력 > 날짜 -->
	<div class="dayinputlay goodsoptiondirectlay hide">
		<span class="help">수동기간은 [생성 및 변경]에서 변경할 수 있습니다.</span>
	</div>

	<!-- 직접입력 > 날짜 -->
	<div class="dayautolay goodsoptiondirectlay hide">
	<span class="help">자동기간은 [생성 및 변경]에서 변경할 수 있습니다.</span>
	</div>

	<div class="goodsoptiondirectlay colordateaddresslay">
		<form name="specialOption" id="specialOption" method="post" action="../goods_process/save_special_option" target="optionFrame">
		<input type="hidden" name="tmpSeq" value="<?php echo $_GET["tmp_seq"]?>" />
		<input type="hidden" name="optionSeq" value="" />
		<input type="hidden" name="optionNo" value="" />
		<input type="hidden" name="newType" value="" />
		<table width="100%" border="0" cellspacing="5" cellpadding="5" >
		<tr>
			<td  valign="top" class="center">
				<div style="margin-bottom:10px;">
					<label><input type="radio" name="same_spc_save_type" value="y" checked /> 동일옵션 모두 적용</label>
					<label><input type="radio" name="same_spc_save_type" value="n" /> 현재 선택한 옵션만 적용</label>
				</div>
				<div class="datelay">
					<input type="text" name="direct_codedate" value="" class="line datepicker"  maxlength="10" size="10" />
				</div>
				<div class="colorlay">
					<input type="text" name="direct_color" value="" class="line colorpickerreview colorpicker"  maxlength="10" size="10" />
				</div>
				<div class="addresslay">
					<input type="text" name="direct_zipcode[]" value="" size="5" class="line direct_zipcode1" /> <span class="btn small"><button type="button" class="direct_zipcode_btn">우편번호</button></span><br/>
					<input type="text" name="direct_address_type" value="" size="40" class="line direct_address_type hide" />
					<table width="100%" border="0" cellspacing="5" cellpadding="5" >
					<tr>
						<td  valign="top" class="center">(지번) </td>
						<td><input type="text" name="direct_address" value="" size="40" class="line direct_address" /></td>
					</tr>
					<tr>
						<td  valign="top" class="center">(도로명) </td>
						<td><input type="text" name="direct_address_street" value="" size="40" class="line direct_address_street" /></td>
					</tr>
					<tr>
						<td  valign="top" class="center">(공통상세) </td>
						<td><input type="text" name="direct_addressdetail"  value="" size="40" class="line direct_addressdetail" /></td>
					</tr>
					<tr>
						<td  valign="top" class="center">(업체연락처) </td>
						<td><input type="text" name="direct_biztel" value="" title="업체 연락처" size="40" class="line direct_biztel" />
						</td>
					</tr>
					</table>
					<!-- <div >map</div> -->
				</div>
			</td>
		</tr>
		<tr>
			<td  valign="top" class="left">
				<div class="addresslay"style="padding-top:10px;">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" >
					<tr>
						<td valign="top" class="center" width="105">수수료</td>
						<td valign="top" class="left"> <input style="text-align: right;" class="input-box-default-text direct_address_commission" name="direct_address_commission" value="0" size="3" type="text">%</div></td>
					</tr>
					<tr>
						<td valign="top" colspan="2">
							<div class="desc" style="padding-top:10px;">
								※ 해당 상품을 해당 매장(지역,장소)에서 사용했을 경우의 수수료입니다.  </br>
								※ 해당 수수료는 판매자(본사 또는 입점사)와 매장간 정산 내역에 자동 반영됩니다.							</div>
						</td>
					</tr>
					</table><br/>
				</div>
			</td>
		</tr>
		</table>
	</div>

	<div class="center" style="padding:5px;">
		<span class="btn large black"><button type="button" id="goodsoptiondirectmodifybtn">확인</button></span>
	</div>
	</form>
</div>

<div id="hideFormLay"></div>

<div id="dialog_international_shipping" class="hide">
	<div class="fx12 pdb10">
		<div>
			● 수출입상품코드(HSCODE)란?<br />
			&nbsp;&nbsp;&nbsp;<span class="darkgray">전 세계에서 거래되는 각종 물품을 세계관세기구(WCO)가 정한 국제통일상품분류체계(HS)에 <br/>
			&nbsp;&nbsp;&nbsp;의거 하나의 품목번호(Heading)로 분류한 국제적 상품 코드입니다.</span>
		</div>
		<div style="margin-top:8px;">
	 		● 수출입상품코드 (HSCODE) 이용<br />
			&nbsp;&nbsp;&nbsp;<span class="darkgray">HSCODE는 통관 시 세관신고서에 기입하시게 됩니다.<br/>
			&nbsp;&nbsp;&nbsp;본 시스템에서는 물품의 HSCODE를 저장하여 관리할 수 있습니다.</span>
		</div>
	</div>
</div>

<?php $this->print_("CREATE_OPTION",$TPL_SCP,1);?>


<div id="selectGoodsOptionsDialog" style="display:none;"></div>
<iframe name="optionFrame" id="optionFrame" src="" width="100%" height="0" frameborder="0" class="hide"></iframe>
<form name="save_package_tmp" id="save_package_tmp" method="post" action="../goods_process/save_tmp_option_package" target="optionFrame">
</form>
<script>package_unit_ea_display();</script>

<!-- 옵션설명 레이어 -->
<div id="applyAllOptInfomation" class="hide">
	<table class="info-table-style" style="width:410px;">
		<tbody>
			<tr>
				<th class="its-th-align">설명</th>
			</tr>
			<tr>
				<td class="its-td center pd5">
					<textarea name="infomation_all" rows="3" style="width:400px;"></textarea>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="contents_saveBtn center pdt10">
		<span class="btn large"><button type="button" class="save_all" id="infomation_all" style="width:100px;">적 용</button></span>
	</div>
</div>

<div id="applyOptInfomation" class="hide">
	<table class="info-table-style" style="width:410px;">
		<tbody>
			<tr>
				<th class="its-th-align">설명</th>
			</tr>
			<tr>
				<td class="its-td center pd5">
					<input type="hidden" id="tmpInfomationIdx" value=""/>
					<textarea id="tmpInfomation" rows="3" style="width:400px;"></textarea>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="contents_saveBtn center pdt10">
		<span class="btn large"><button type="button" onClick="doApplyOptInfomation();" style="width:100px;">적 용</button></span>
	</div>
</div>

<div id="viewOptInfomation" class="hide">
	<table class="info-table-style" style="width:560px;">
		<tbody>
			<tr>
<?php if(is_array($TPL_R1=$TPL_VAR["options"][ 0]["option_divide_title"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><th class="its-th-align center" width="80"><?php echo $TPL_V1?></th><?php }}?>
				<th class="its-th-align center">설명</th>
			</tr>
<?php if($TPL_options_1){foreach($TPL_VAR["options"] as $TPL_V1){?>
			<tr>
<?php if(is_array($TPL_R2=$TPL_V1["opts"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<td class="its-td center pd5"><?php echo $TPL_V2?>

				</td>
<?php }}?>
				<td class="its-td left pd5"><?php echo $TPL_V1["infomation"]?></td>
			</tr>
<?php }}?>
		</tbody>
	</table>
</div>

<div id="makeGoodsCodLay" class="hide">
	<div class="center" style="padding-top:10px;color:blue">현재 상품 기본코드 자동생성규칙</div>
	<div class="center" style="padding-top:10px;">
<?php if($TPL_VAR["goodscodesettingview"]){?><?php echo substr($TPL_VAR["goodscodesettingview"], 0,strlen($TPL_VAR["goodscodesettingview"])- 3)?><?php }else{?>규칙없음<?php }?>
	</div>
	<div class="center" style="padding:20px;">
<?php if($TPL_VAR["goodscodesettingview"]&&($_GET["no"]||$TPL_VAR["goods_seq"])){?>
		<span class="btn large gray"><button type="button" onClick="makeGoodsCode();">자동생성</button></span>
<?php }?>
	</div>
</div>

<!-- 옵션관리 다이얼로그 -->
<div id="optionSettingPopup" class="hide">
	<table  class="simplelist-table-style" style="width:100%">
		<colgroup>
			<col width="80%" /><col/>
			<col width="20%" /><col/>
		</colgroup>
		<thead>
			<tr>
				<th class="its-th-align center">상품명</th>
				<th class="its-th-align center">삭제</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["frequentlyoptlist"]){?>
<?php if($TPL_frequentlyoptlist_1){foreach($TPL_VAR["frequentlyoptlist"] as $TPL_V1){?>
			<tr>
				<td><span class="delFreqOptionName_<?php echo $TPL_V1["goods_seq"]?>"><?php echo $TPL_V1["goods_name"]?></span></td>
				<td class="its-th-align center">
					<span class="btn small"><button type="button" class="delFreqOption" value="<?php echo $TPL_V1["goods_seq"]?>" data-type="opt">삭제</button></span>
				</td>
			</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td colspan="2" class="its-th-align center">데이터 없음</td>
			</tr>
<?php }?>
		</tbody>
	</table>
	<div class="paging_navigation"><?php echo $TPL_VAR["frequentlyoptpaginlay"]?></div>
</div>