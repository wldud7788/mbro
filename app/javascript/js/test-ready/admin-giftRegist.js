/* 카테고리 연결 */
function add_category(cateCode,cateName){
	$("#connectCategoryInfo").hide();
	var t = $("input[name='connectCategory[]'][value='"+cateCode+"']").attr("type");
	if(t == "hidden") return false;		
	var trStr = "<tr>";
	trStr += "<td class=\"its-td-align center\"><label><input type=\"radio\" name=\"firstCategory\" value=\""+cateCode+"\" /></label>";
	trStr += "<input type=\"hidden\" name=\"connectCategory[]\" value=\""+cateCode+"\" />";
	trStr += "</td>";
	trStr += "<td class=\"its-td\"><div class=\"connectCategory\">"+cateName+"</div><div><span class=\"btn-minus\"><button type=\"button\" class=\"categoryDelete\"></button></span></div></td>";			
	trStr += "</tr>";	
	$("#connectCategoryTable").append(trStr);
	$("input:radio[name='firstCategory']").val([cateCode]);
}

/* 브랜드 연결 */
function add_brand(cateCode,cateName,charge){
	$("#connectBrandInfo").hide();
	
	charge = num(charge);
	
	var t = $("input[name='connectBrand[]'][value='"+cateCode+"']").attr("type");
	if(t == "hidden") return false;		
	var trStr = "<tr>";
	trStr += "<td class=\"its-td-align center\"><label><input type=\"radio\" name=\"firstBrand\" value=\""+cateCode+"\" /></label>";
	trStr += "<input type=\"hidden\" name=\"connectBrand[]\" value=\""+cateCode+"\" />";
	trStr += "</td>";
	trStr += "<td class=\"its-td\"><div class=\"connectBrand\">"+cateName+"</div><div><span class=\"btn-minus\"><button type=\"button\" class=\"brandDelete\"></button></span></div></td>";			
	trStr += "</tr>";	
	$("#connectBrandTable").append(trStr);
	$("input:radio[name='firstBrand']").val([cateCode]);
	
	if(charge){
		$("input[name='commissionRate[]'],input[name='subCommissionRate[]']").each(function(){
			if($(this).val()=='0'){
				$(this).val(charge);
			}		
		});
	}
}

/* 지역 연결 */
function add_location(cateCode,cateName,charge){
	$("#connectLocationInfo").hide();
	var t = $("input[name='connectLocation[]'][value='"+cateCode+"']").attr("type");
	if(t == "hidden") return false;		


	var trStr = "<tr>";
	trStr += "<td class=\"its-td-align center\"><label><input type=\"radio\" name=\"firstLocation\" value=\""+cateCode+"\" /></label>";
	trStr += "<input type=\"hidden\" name=\"connectLocation[]\" value=\""+cateCode+"\" />";
	trStr += "</td>";
	trStr += "<td class=\"its-td\"><div class=\"connectLocation\">"+cateName+"</div><div><span class=\"btn-minus\"><button type=\"button\" class=\"locationDelete\"></button></span></div></td>";			
	trStr += "</tr>";	
	$("#connectLocationTable").append(trStr);
	$("input:radio[name='firstLocation']").val([cateCode]); 
}


/* 이미지 업로드 레이어 보기 */
function showImageUploadDialog(){
	nowPath = "data/tmp";	
	$("#imageUploadDialog .uploadPath").html(nowPath);

	$("#imageUploadDialog").dialog("open");
	
	/* Uploadify path 변경 */
	$("#imageUploadButton").uploadifySettings('folder','/' + nowPath);	
}

function set_goodsImage_cut(){
	$("#goodsImageTable tbody tr").each(function(idx){
		var cutname = "<img src='/admin/skin/default/images/common/icon_move.gif'> 대표";
		if(idx > 0){
			cutname = "<img src='/admin/skin/default/images/common/icon_move.gif'>";
			cutname += idx + 1;			
			cutname += "번째 컷";
		}

		$html = $(this).find("td").eq(1).find(".fileColorTitle").html();
		$color = $(this).find("td").eq(1).find(".fileColorTitle").css("color");

		if($html) {
			cutname += " <input type=\"hidden\" name=\"goodsImageColor[]\" value=\""+rgb2hex($color)+"\" /><span class=\"fileColorTitle\" style=\"color:"+rgb2hex($color)+"\">"+$html+"</span>";
		} else {
			cutname += " <input type=\"hidden\" name=\"goodsImageColor[]\" value=\"\" /> <span class=\"fileColorTitle\"></span>";
		}

		$(this).find("td").eq(1).html(cutname);
	});	
}

//필수 옵션 조합
function merge_option(opt1,opt2){
	var result = new Array();
	var k = 0;
	for (var i=0;i<opt1.length;i++){
		for (var j=0;j<opt2.length;j++){
			result[k] = opt1[i]+","+opt2[j];
			k++;
		}		
	}	
	return result;
}

function calulate_option_price(tmpidx){
	var container = $("#optionLayer");
	var idx;

	if(typeof tmpidx == 'undefined'){
		var selector = $("input[name='price[]']",container);
		var tmpidxch = false;
	}else{
		var selector = $("input[name='price[]']",container).eq(tmpidx);
		var tmpidxch = true;
	}

	// default-price
	selector.val(0);

	selector.each(function(eachidx){
		if(tmpidxch) {
			idx = tmpidx;
		}else{
			idx = eachidx;
		}
		var rate = 0;
		var priceObj 		= $(this);
		var supplyPriceObj 	= $("input[name='supplyPrice[]']",container).eq(idx);
		var consumerPriceObj = $("input[name='consumerPrice[]']",container).eq(idx);
		var reserveRateObj 	= $("input[name='reserveRate[]']",container).eq(idx);
		var reserveUnit 	= $("select[name='reserveUnit[]']",container).eq(idx).find("option:selected").attr("value");
		var reserveObj 		= $("input[name='reserve[]']",container).eq(idx);
		var taxObj 			= $(".tax",container).eq(idx);
		var supplyRateObj 		= $(".supplyRate",container).eq(idx);
		var discountRateObj = $(".discountRate",container).eq(idx);	
		
		var settlementAmountObj	= $(".settlementAmount",container).eq(idx);
		var commissionRateObj	= $("input[name='commissionRate[]']",container).eq(idx);
		var commissionTypeObj	= $("select[name='commissionType[]']",container).eq(idx);
		var defaultCommissionType	= $("input[name='default_commission_type']").val();

		if(typeof(commissionTypeObj.val()) == 'undefined'){
			var commissionTypeObj	= $("input[name='commissionType[]']",container).eq(idx);
		}
		
		var obj = { 0:supplyPriceObj.val(), 1:consumerPriceObj.val(), 2:priceObj.val(), 3:reserveRateObj.val(), 4:reserveUnit };
		
		var result = calulate_price(obj);

		if(result[0]>0 && result[0]!='Infinity') result[0] = result[0]+"%";  
		else result[0] = "0%";
		supplyRateObj.html(result[0]);
		
		if(result[1]>0 && result[1]!='Infinity') result[1] = result[1]+"%"; 
		else result[1] = "0%";
		discountRateObj.html(result[1]);
		
		//supplyPriceObj.val(Math.floor(supplyPriceObj.val()));
		//consumerPriceObj.val(Math.floor(consumerPriceObj.val()));
		//priceObj.val(Math.floor(priceObj.val()));

		// TAX @2014-03-17
		if( (eval("$(\"input[name='tax']:checked\").val()") && $("input[name='tax']:checked").val()!='tax') || (eval("$('.goodsTax').val()") && $(".goodsTax").val()!='tax') ){
			result[2] = 0;
		}
		taxObj.html(result[2]);

		reserveObj.val(result[3]);
		
		// 마진출력
		var net_profit = priceObj.val() - supplyPriceObj.val();
		$(".net_profit",container).eq(idx).html(comma(net_profit));

		if(commissionTypeObj.val() != 'SUPR'){
			commissionRateObj.val(num_float(commissionRateObj.val()));
			if(commissionRateObj.val()>100) {
				commissionRateObj.val('100');
			}
		}

		if(defaultCommissionType=='SACO'){
			var settlementAmount	= num(priceObj.val()) / 100 * (100-num_float(commissionRateObj.val()));
		}else{
			// 정산금액 출력
			switch(commissionTypeObj.val()){
				case	'SUCO' :
					var settlementAmount	= num(consumerPriceObj.val()) / 100 * num_float(commissionRateObj.val());
					break;
				case	'SUPR' :
					var settlementAmount	= commissionRateObj.val();
					break;
				default	:
					var settlementAmount	= num(priceObj.val()) / 100 * (100-num_float(commissionRateObj.val()));
					break;
			}
		}

		// 정산가 소수점 버림 처리 - 이정록 - 2016-07-08
		settlementAmount = Math.floor(settlementAmount);
		settlementAmountObj.html(comma(settlementAmount));
				
	});
}

function calulate_subOption_price(){
	var container = $("#suboptionLayer");
	// subSupplyPrice	subConsumerPrice	subPrice
	$("input[name='subPrice[]']",container).each(function(idx){		
		var priceObj 		= $(this);
		var supplyPriceObj 	= $("input[name='subSupplyPrice[]']",container).eq(idx);
		var consumerPriceObj = $("input[name='subConsumerPrice[]']",container).eq(idx);
		var subReserveRateObj 	= $("input[name='subReserveRate[]']",container).eq(idx);
		var subReserveUnit 	= $("select[name='subReserveUnit[]']",container).eq(idx).find("option:selected").attr("value");
		var subReserveObj 		= $("input[name='subReserve[]']",container).eq(idx);
		var taxObj 			= $(".subTax",container).eq(idx);
		var supplyRateObj 		= $(".subSupplyRate",container).eq(idx);
		var discountRateObj = $(".subDiscountRate",container).eq(idx);		
		var obj = { 0:supplyPriceObj.val(), 1:consumerPriceObj.val(), 2:priceObj.val(), 3:subReserveRateObj.val(), 4:subReserveUnit };
		var result = calulate_price(obj);	
		var subSettlementAmountObj	= $(".subSettlementAmount",container).eq(idx);
		var subCommissionRateObj	= $("input[name='subCommissionRate[]']",container).eq(idx);
		var subCommissionTypeObj	= $("select[name='subCommissionType[]']",container).eq(idx);
		
		if(typeof(subCommissionTypeObj.val()) == 'undefined'){
			var subCommissionTypeObj	= $("input[name='subCommissionType[]']",container).eq(idx);
		}

		if(result[0]>0 && result[0]!='Infinity') result[0] = result[0]+"%";  
		else result[0] = "0%";
		supplyRateObj.html(result[0]);

		if(result[1]>0 && result[1]!='Infinity') result[1] = result[1]+"%"; 
		else result[1] = "0%";
		discountRateObj.html(result[1]);
		
		//supplyPriceObj.val(Math.floor(supplyPriceObj.val()));
		//consumerPriceObj.val(Math.floor(consumerPriceObj.val()));
		//priceObj.val(Math.floor(priceObj.val()));	

		// TAX @2014-03-17
		if( (eval("$(\"input[name='tax']:checked\").val()") && $("input[name='tax']:checked").val()!='tax') || (eval("$('.goodsTax').val()") && $(".goodsTax").val()!='tax') ){
			result[2] = 0;
		}
		taxObj.html(result[2]);

		subReserveObj.val(result[3]);
		
		// 마진출력
		var net_profit = priceObj.val() - supplyPriceObj.val();
		$(".sub_net_profit",container).eq(idx).html(comma(net_profit));



		if(subCommissionTypeObj.val() != 'SUPR'){
			subCommissionRateObj.val(num_float(subCommissionRateObj.val()));
			if(subCommissionRateObj.val()>100) {
				subCommissionRateObj.val('100');
			}
		}

		// 정산금액 출력
		switch(subCommissionTypeObj.val()){
			case	'SUCO' :
				var subSettlementAmount	= num(consumerPriceObj.val()) / 100 * num_float(subCommissionRateObj.val());
				break;
			case	'SUPR' :
				var subSettlementAmount	= subCommissionRateObj.val();
				break;
			default	:
				var subSettlementAmount	= num(priceObj.val()) / 100 * (100-num_float(subCommissionRateObj.val()));
				break;
		}

		// 정산가 소수점 버림 처리 - 이정록 - 2016-07-08
		subSettlementAmount = Math.floor(subSettlementAmount);
		subSettlementAmountObj.html(comma(subSettlementAmount));
	});
}

function calulate_price(obj){
	// supply,consumer,price,reserveRate,reserveUnit
	var rate;
	var result = new Array('','','');
	var supply = obj[0];
	var consumer = obj[1];
	var price = obj[2];
	if( obj[3] ) var reserveRate = obj[3];
	if( obj[4] ) var reserveUnit = obj[4];	
	
	// 매입율
	if( consumer && supply ){
		result[0] =  Math.floor( supply / consumer * 100 );		
	}
	
	// 할인율
	if( consumer && price ){
		result[1] =  100 - Math.floor( price / consumer * 100);
	}
	
	// 부가세
	if( price ){
		result[2] =  Math.floor( price - (price / 1.1) );
	}
	
	// 지급마일리지
	if( price && reserveRate && reserveUnit ){			
		if( reserveUnit == 'percent' ) {
			rate = reserveRate / 100;
			result[3] =  get_cutting_price( price * rate ,gl_basic_currency) ;
		}else{
			result[3] =  get_cutting_price( reserveRate ,gl_basic_currency);
		}			
	}	
	return result;	
}

// 옵션일괄적용 활성화
function check_button_optionBatch(){
	if($("input[name='defaultOption']")) $("#optionBatch").attr("disabled",false);
	else $("#optionBatch").attr("disabled",true);
}

function default_option_input(){
	var copyOptionTd;
	var len = $("#optionLayer table tr.optionTr").eq(0).find("td").length;	
	if(len > 11){
		for(var i=0;i<len-11;i++){
			$("#optionLayer table tr.optionTr").eq(0).find("td").eq(0).remove();
		}
	}	
	if( $("#optionLayer table tr").eq(1).children("td").html() ) copyOptionTd = $("#optionLayer table tr").eq(1).children("td");
	else copyOptionTd = $("#optionLayer table tr").eq(2).children("td");
	return copyOptionTd;
}

function get_option_title(){
	var point_text = $("#optionLayer .point_text").text();
	var tag;
	tag = '<tr>';		
	tag += '<th class="its-th-align center" rowspan="2"><span class="btn-plus"><button type="button" id="addOption"></button></span></th>';
	tag += '<th class="its-th-align center" rowspan="2">기준할인가</th>';
	tag += '<th class="its-th-align center">필수옵션</th>';
	tag += '<th class="its-th-align center" rowspan="2">정산 금액</th>';
	tag += '<th class="its-th-align center" rowspan="2">수수료율</th>';
	tag += '<th class="its-th-align center" rowspan="2">평균 매입가</th>';
	tag += '<th class="its-th-align center" rowspan="2">평균 매입율</th>';
	tag += '<th class="its-th-align center" rowspan="2">정가(소비자가/시중가)</th>';
	tag += '<th class="its-th-align center" rowspan="2">마진 / 할인가(판매가)</th>';
	tag += '<th class="its-th-align center" rowspan="2">할인율</th>';
	tag += '<th class="its-th-align center" rowspan="2">부가세</th>';
	tag += '<th class="its-th-align center" rowspan="2">재고(가용)\n';	
	tag += '</th>';
	tag += '<th class="its-th-align center" rowspan="2">지급 마일리지';
	tag += '<select name="reserve_policy">';
	tag += '<option value="shop">통합정책</option>';
	tag += '<option value="goods">개별정책</option>';
	tag += '</select>';
	tag += "<div style='color:#999999;' class='point_text'>"+point_text+"</div>";
	tag += '</th>';
	tag += '<th class="its-th-align center" rowspan="2">옵션정보</th>';	
	tag += '</tr>';
	
	tag += '<tr>';
	$("#optionMakePopup table tbody tr").each(function(idx){

		tag += '<th class="its-th-align center">';
		tag += $(this).find("input[name='optionMakeName[]']").val();
		tag += '<input type="hidden" name="optionTitle[]" value="'+$(this).find("input[name='optionMakeName[]']").val()+'" />';
		tag += '<input type="hidden" name="optionType[]" value="'+$(this).find("select[name='optionMakeId[]'] option:selected").val()+'" />';
		tag += '</th>';		
	});
	tag += '</tr>';
	
	
	return tag;
}

function make_option(){
	var key = 0;
	var cols = 0;
	var optName = new Array();
	var optionType = new Array();
	var optValue = new Array();
	var optPrice = new Array();
	var optCode = new Array();
	var result = new Array();
	var resulttype = new Array();
	var resultPrice = new Array();
	var preTag, tmp; 
	var pattern = /[\,]/;
							
	$("#optionMakePopup table tbody tr").each(function(idx){
		optionType[idx] = $(this).find("select[name='optionMakeId[]'] option:selected").val();

		tmp = $(this).find("input[name='optionMakeValue[]']").val();
		optValue[idx] = tmp.split(',');
		tmp = $(this).find("input[name='optionMakePrice[]']").val();
		optPrice[idx] = tmp.split(',');

		tmp = $(this).find("input[name='optionMakeCode[]']").val();
		optCode[idx] = tmp.split(',');

		cols = idx;
	});
	
	/* 옵션값 공백 체크 */
	for(var i=0;i<optValue.length;i++){
		for(var j=0;j<optValue[i].length;j++){
			if(optValue[i][j].length==0) {
				openDialogAlert("옵션값을 입력해주세요.",400,140,function(){
					$("#optionMakePopup input[name='optionMakeValue[]']").filter(function(){
						return $(this).val().length==0;
					}).eq(0).focus();
				});
				return false;
			}
		}
	}
	
	var clone = $("#optionLayer table").clone();		
	var copyOptionTd = default_option_input();
	var tag = get_option_title();		
	
	/* 가용재고 : 원래는 유지해야하지만, 일단 첫번 0으로 초기화시킴 */
	//copyOptionTd.find("input[name='badstock[]']").val('0');
	//copyOptionTd.find("input[name='reservation25[]']").val('0');
	//copyOptionTd.find("input[name='reservation25[]']").val('0');
	//copyOptionTd.find("input[name='unUsableStock[]']").val('0');
	//copyOptionTd.find("span.optionUsableStock").html(comma(num(copyOptionTd.find("input[name='stock[]']").val())));
	
	for ( var i=0;i<optValue.length;i++ ){	
			if(!optValue[i]) continue;
		for ( var j=0;j<optValue[i].length;j++ ){				
			if(! optPrice[i][j] ) optPrice[i][j] = 0;		
		}
	}		
	
	for (var i=0;i<optValue.length;i++){			
		if(!optValue[i]) continue; 
		if( i == 0 ){
			result = optValue[i];
			resultcode = optCode[i];
		} else {
			result = merge_option(result,optValue[i]);
			resultcode = merge_option(resultcode,optCode[i]);
		}			
	}	
	
	
	for (var i=0;i<result.length;i++){
		result[i] = result[i].split(',');
		if(resultcode[i]){
			resultcode[i] = resultcode[i].split(',');
		}else{
			resultcode[i] = '';
		}
	}		
	
	for (var i=0;i<optPrice.length;i++){
		if(i == 0 && optPrice[i] ){
			resultPrice = optPrice[i];
		}else if( optPrice[i] ){
			resultPrice = merge_option(resultPrice,optPrice[i]);
		}
	}		
	
	for (var i=0;i<resultPrice.length;i++){		
		if (pattern.test(resultPrice[i])){
			resultPrice[i] = resultPrice[i].split(',');
		}
	}
	
	for (var i=0;i<result.length;i++){
		key=0;
		tag += '<tr class="optionTr">';			
		for (var j=0;j<result[i].length;j++){
			var tmpType = $.trim(optionType[key]);
			var tmpValue = $.trim(result[i][j]);
			var tmpCode = $.trim(resultcode[i][j]);
			//tag += '<td class="its-td-align center"><input type="text" size="10" name="opt['+key+'][]" value="' + tmpValue + '" /></td>';
			if( tmpType == 'direct' || !tmpType ) {
				tag += '<td class="its-td-align center"><input type="text" size="10" name="opt['+key+'][]" value="' + tmpValue + '" class="line "/>';
			}else{
				tag += '<td class="its-td-align center"><input type="text" size="10" name="opt['+key+'][]" value="' + tmpValue + '" class="line input-box-default-text-code "/>';
			}
			tag += '<input type="hidden" size="10" name="optcode['+key+'][]" value="' + tmpCode + '" /></td>';
			key++;
		}
		tag += '</tr>';			
	}
	
	clone.empty();//clone.find("*").remove();		
	clone.html(tag);		
	clone.find("tr").eq(0).find("th").eq(2).attr('colspan',cols+1);

	key = 0;		
	clone.find("tr").each(function(idx){
		if(idx > 1) {				
			preTag = '<td class="its-td-align center">';
			preTag += '<span class="btn-minus"><button type="button" class="removeOption"></button></span>';
			preTag += '</td>';				
			if(key == 0){
				preTag += '<td class="its-td-align center"><input type="radio" name="defaultOption" value="'+result[key]+'" checked="checked" /></td>';
			}else{
				preTag += '<td class="its-td-align center"><input type="radio" name="defaultOption" value="'+result[key]+'" /></td>';
			}
			sum = 0;
			if(result[key]){
				for (var i=0;i<result[key].length;i++){
					if(result[key]==result[key][i]){
						sum += Math.floor(resultPrice[key]);	
					}else{
						sum += Math.floor(resultPrice[key][i]);	
					}
				}
			}
			
			copyOptionTd.children("input[name='price[]']").val(sum);
			$(this).prepend(preTag);				
			$(this).append(copyOptionTd.clone());
			key++;					
		}								
	});
	
	// 수수료
	var default_commission_rate = get_default_commission_rate();
	
	$("input[name='commissionRate[]']",clone).val(default_commission_rate);
	
	$("#optionLayer").html( clone );	
	calulate_option_price();

	try{ 
	if(eval("provider_seq")) 
	{ 
		var provider_seq = provider_seq;
	} 
	}catch(e){ 
		var provider_seq = '';
	}
	
	if(provider_seq != undefined && provider_seq!=''){
		$("select[name='reserve_policy'] option").each(function(){
			if($(this).parent().val()!=$(this).attr("value")){
				$(this).attr("disabled",true);
			}
		});
	}
}

function batch_option_price(){
	var defaultSupplyPrice;
	var defaultConsumerPrice;
	var reserveRate,reserveUnit,reserve,price,stock;
	var tax,supplyRate,discountRate,infomation;
	var socialcpuseopen = $("#socialcpuseopen").val();
	
	$("input[name='defaultOption']").each(function(idx){
		if( $(this).attr("checked") ){
			supplyPrice		= $("input[name='supplyPrice[]']").eq(idx).val();
			if(socialcpuseopen){
				coupon_input	= $("input[name='coupon_input[]']").eq(idx).val();
			}
			coupon_input	= $("input[name='coupon_input[]']").eq(idx).val();
			consumerPrice	= $("input[name='consumerPrice[]']").eq(idx).val();
			price			= $("input[name='price[]']").eq(idx).val();
			reserveRate 	= $("input[name='reserveRate[]']").eq(idx).val();
			reserveUnit 	= $("select[name='reserveUnit[]']").eq(idx).find("option:selected").attr("value");
			reserve			= $("input[name='reserve[]']").eq(idx).val();				
			stock			= $("input[name='stock[]']").eq(idx).val();
			infomation		= $("textarea[name='infomation[]']").eq(idx).val();
			tax 			= $(".tax").eq(idx).html();
			supplyRate 		= $(".supplyRate").eq(idx).html();
			discountRate    = $(".discountRate").eq(idx).html();
			commissionRate	= $("input[name='commissionRate[]']").eq(idx).val();
		}			
	});
	$("input[name='defaultOption']").each(function(idx){
		$("input[name='supplyPrice[]']").eq(idx).val(supplyPrice);
		if(socialcpuseopen){
			$("input[name='coupon_input[]']").eq(idx).val(coupon_input);
		}
		$("input[name='coupon_input[]']").eq(idx).val(coupon_input);
		$("input[name='consumerPrice[]']").eq(idx).val(consumerPrice);
		$("input[name='price[]']").eq(idx).val(price);
		$("input[name='reserveRate[]']").eq(idx).val(reserveRate);
		$("select[name='reserveUnit[]']").eq(idx).find("option[value='"+reserveUnit+"']").attr("selected",true);			
		$("input[name='reserve[]']").eq(idx).val(reserve);
		$("input[name='stock[]']").eq(idx).val(stock);
		$("textarea[name='infomation[]']").eq(idx).val(infomation);
		$(".tax").eq(idx).html(tax);

		$(".supplyRate").eq(idx).html(supplyRate);
		$(".discountRate").eq(idx).html(discountRate);
		$("input[name='commissionRate[]']").eq(idx).val(commissionRate);
	});	
}


function get_default_option(){
	var point_text		= $("#optionLayer .point_text").html();
	var policy			= $("select[name='reserve_policy'] option:selected").val();
	if	(!policy)	policy			= $("input[name='reserve_policy']").val();
	var policy_shop		= '';
	var policy_goods	= '';
	if	(policy == 'goods')	policy_goods	= 'selected';
	else					policy_shop		= 'selected';

	if ( socialcpuse_flag ) {
		var socialcp_input_type = $("input[name='socialcp_input_type']:checked").val();
		var couponinputsubtitle = '';
		if( socialcp_input_type == 'price' ) {
			couponinputsubtitle = '금액';
		}else{
			couponinputsubtitle = '횟수';
		}
	}
	
	// 수수료
	var default_commission_rate = get_default_commission_rate();
	var store_text		= $("#optionLayer .store_text").attr('title');
	var price_text		= $("#optionLayer .price_text").attr('title');
	var point_text		= $("#optionLayer .point_text").attr('title');
	var optionmemo_text	= $("#optionLayer .optionmemo_text").attr('title');
	var stock_text		= $("#optionLayer .stock_text").attr('title');
	var ablestock_text	= $("#optionLayer .ablestock_text").attr('title');
	var safestock_text	= $("#optionLayer .safestock_text").attr('title');
	var storeinfo_title	= $("#optionLayer .storeinfo_title").text();
	var goodsCode		= $('#goodsCode').val();
	var scmStatus		= chk_scm_status();
	var provider_seq	= $("select[name='provider_seq_selector']").val();
	if	(!provider_seq)	provider_seq = $("input[name='provider_seq']").val();
	if	(!provider_seq)	provider_seq = 999999;

	var firstTds = '<table class="info-table-style" style="width:100%;">';
	firstTds	+= '<thead>';
	firstTds	+= '<tr>';

	if (gl_package_yn != 'y') {
		firstTds	+= '<th class="its-th-align center" rowspan="2">상품코드';
		firstTds	+= '<a href="javascript:helperMessage(\'goodsCode\');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>';
		firstTds	+= '<br/><span class="btn small cyanblue"><button type="button" id="goodsCodeBtn"  title="기본코드자동생성" >기본코드자동생성</button></span>';

		if (!socialcpuse_flag)
			firstTds	+= '</th><th class="its-th-align center" rowspan="2">무게<br/>(kg)</th>';
	}
	
	if ( socialcpuse_flag ) {
		firstTds	+= '<th class="its-th-align center couponinputtitle" rowspan="2">';
		firstTds	+= '티켓1장→값어치<br/>';
		firstTds	+= ' <span class="couponinputsubtitle">' + couponinputsubtitle + '</span>';
		firstTds	+= '</th>';
	}
	
	if(gl_package_yn == 'y'){
		firstTds	+= '<th class="its-th-align center">';
		firstTds	+= '<div class="pdb5">';
		firstTds	+= '실제 상품';
		firstTds	+= ' <span class="btn small cyanblue"><button type="button" class="package_goods_make" onclick="package_goods_make();">검색</button></span>';
		firstTds	+= ' <span class="btn small cyanblue"><button type="button" onclick="package_error_check(\'option\');">연결 상태 확인</button></span>';
		firstTds	+= '</div>';
		firstTds	+= '<span class="storeinfo_title">' + storeinfo_title + '</span> ';
		firstTds	+= '</th>';
	}else{
		if	(provider_seq == 1)	firstTds	+= '<th class="its-th-align center" colspan="5">';
		else					firstTds	+= '<th class="its-th-align center" colspan="4">';
		firstTds	+= '<span class="storeinfo_title">' + storeinfo_title + '</span> ';
		firstTds	+= '<span class="store_text helpicon" title="' + store_text + '"></span>';
		firstTds	+= '</th>';
	}

	if	(provider_seq == 1){
		firstTds	+= '<th class="its-th-align center not_for_seller hide" rowspan="2">정산 금액</th>';
		firstTds	+= '<th class="its-th-align center not_for_seller hide" rowspan="2"><span class="commission_type_title">수수료</span>';
	}else{
		firstTds	+= '<th class="its-th-align center" rowspan="2">정산 금액</th>';
		firstTds	+= '<th class="its-th-align center" rowspan="2"><span class="commission_type_title">수수료</span>';
	}

	firstTds	+= ' <span class="commission_type_desc SACO_desc"><a href="javascript:helperMessage(\'SACO\');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a></span>';
	firstTds	+= ' <span class="commission_type_desc SUPPLY_desc" style="display:none;"><a href="javascript:helperMessage(\'SUPPLY\');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a></span></th>';

	firstTds	+= '<th class="its-th-align center" rowspan="2">';
	firstTds	+= '정가 → 판매가 ';
	firstTds	+= '<a href="javascript:helperMessage(\'price\');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>';
	firstTds	+= '<th class="its-th-align center" rowspan="2">부가세</th>';
	firstTds	+= '<th class="its-th-align center" rowspan="2">';
	firstTds	+= '<div style="margin-bottom:5px;">';
	firstTds	+= '<select name="reserve_policy" readonly>';
	firstTds	+= '<option value="shop" ' + policy_shop + '>통합정책</option>';
	firstTds	+= '<option value="goods" ' + policy_goods + '>개별정책</option><br/>';
	firstTds	+= '</select><br/>';
	firstTds	+= ' 지급 마일리지';
	firstTds	+= '</div>';
	firstTds	+= '</th>';
	firstTds	+= '<th class="its-th-align center optionStockSetText" rowspan="2"></th>';
	firstTds	+= '</tr>';
	firstTds	+= '<tr>';
	if(gl_package_yn == 'y'){
		var cnt = $("select[name='reg_package_count'] option:selected").val();
		firstTds += "<th class=\"its-th-align center package-product-width\">";
		firstTds += "<table class=\"reg_package_option_title_tbl\">";
		firstTds += "<tr>";
		for(var i=1;i <= cnt;i++){
			firstTds += "<td>상품"+i+"</td>";
		}
		firstTds += "</tr>";
		firstTds += "</table>";
		firstTds += "</th>";
	}else{
		firstTds	+= '<th class="its-th-align center">';
		firstTds	+= '재고 ';
		firstTds	+= '<a href="javascript:helperMessage(\'stock\');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>';
		firstTds	+= '</th>';
		firstTds	+= '<th class="its-th-align center">불량</th>';
		firstTds	+= '<th class="its-th-align center">';
		firstTds	+= '가용 ';
		firstTds	+= '<a href="javascript:helperMessage(\'solubleStock\');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a></span>';
		firstTds	+= '</th>';
		firstTds	+= '<th class="its-th-align center">';
		firstTds	+= '안전재고';
		
		if (gl_scm_use == 'Y' && provider_seq == 1)
			firstTds	+= '<a href="javascript:helperMessage(\'safeStockForScm\', \'' + safestock_text + '\');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>';
		else
			firstTds	+= '<a href="javascript:helperMessage(\'safeStock\', \'' + safestock_text + '\');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>';

		firstTds	+= '</th>';
		if	(provider_seq == 1)	firstTds	+= '<th class="its-th-align center">매입가(평균)</th>';
	}
	firstTds	+= '</tr>';
	firstTds	+= '</thead>';
	firstTds	+= '<tbody>';
	firstTds	+= '<tr class="optionTr">';
	if (gl_package_yn != 'y') {
		firstTds	+= '<td class="its-td-align center">';
		firstTds	+= '<span class="goodsCode">' + goodsCode + '</span>';
		firstTds	+= '</td>';
		if (!socialcpuse_flag) {
			firstTds	+= '<td class="its-td-align center">';
			firstTds	+= '<input style="text-align: right;" class="line onlyfloat input-box-default-text" name="weight[]" value="0" size="3" type="text">';
			firstTds	+= '</td>';
		}
	}
	


	if ( socialcpuse_flag ) {
		firstTds	+= '<td class="its-td-align right pdr10 couponinputtitle">';
		firstTds	+= '<input type="text" name="coupon_input[]" class="line onlynumber" style="text-align:right" size="10" value=""/>';
		firstTds	+= '</td>';
	}

	if(gl_package_yn == 'y'){
		
		firstTds += '<td class="its-td-align center">';
		firstTds += '<input type="hidden" name="stock[]" value="50" />';
		firstTds += '<table class="reg_package_option_tbl">';
		firstTds += '<tr>';
		for(var i=1;i <= cnt;i++){
			firstTds += '<td>';
			firstTds += '<div>';
			firstTds += '<span class="reg_package_goods_seq'+i+'"></span>';
			firstTds += '<span class="reg_package_goods_name'+i+'"></span>';
			firstTds += '</div>';
			firstTds += '<div class="reg_package_option'+i+'"></div>';
			firstTds += '<div class="reg_package_unit_ea'+i+'">주문당 <input type="text" name="package_unit_ea'+i+'[]" size="3" value="1" style="text-align:right;"> 발송 <span class="helpicon" title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량"></span></div>';
			firstTds += '<div class="reg_package_option_seq'+i+'">';
			firstTds += '</div>';
			firstTds += '<input type="hidden" name="reg_package_option_seq'+i+'[]" value="">';
			firstTds += '</td>';
		}		
		firstTds += '</tr>';
		firstTds += '</table>';
		firstTds += '</td>';
	}else{

		firstTds	+= '<td class="its-td-align right pdr10">';
		if	(scmStatus){
			firstTds	+= '0';
			firstTds	+= '<input type="hidden" name="stock[]" value="0" />';
		}else{
			firstTds	+= '<input type="text" name="stock[]" value="0" size="5" class="line onlynumber" style="text-align:right" />';
		}
		firstTds	+= '</td>';
		firstTds	+= '<td class="its-td-align right pdr10">';
		if	(scmStatus){
			firstTds	+= '0';
			firstTds	+= '<input type="hidden" name="badstock[]" value="0" />';
		}else{
			firstTds	+= '<input type="text" name="badstock[]" value="0" size="5" class="line onlynumber" style="text-align:right" />';
		}
		firstTds	+= '</td>';
	
		firstTds	+= '<td class="its-td-align right pdr10">';
		firstTds	+= '<span class="optionUsableStock">0</span>';
		firstTds	+= '<input type="hidden" name="unUsableStock[]" value="0" />';
		firstTds	+= '<input type="hidden" name="reservation15[]" value="" />';
		firstTds	+= '<input type="hidden" name="reservation25[]" value="" />';
		firstTds	+= '</td>';
		firstTds	+= '<td class="its-td-align right pdr10">';
		firstTds	+= '<input type="text" name="safe_stock[]" value="0" size="5" class="line onlynumber" style="text-align:right" />';
		firstTds	+= '</td>';
		if	(provider_seq == 1){
			firstTds	+= '<td class="its-td-align right pdr10">';
			if	(scmStatus){
				firstTds	+= '0.00';
				firstTds	+= '<input type="hidden" name="supplyPrice[]" value="0" />';
			}else{
				firstTds	+= '<input type="text" name="supplyPrice[]" value="0" size="10" class="onlyfloat line  style="text-align:right" />';
			}
			firstTds	+= '</td>';
		} 
	}

	if (provider_seq == 1) {
		firstTds	+= '<td class="its-td-align right pdr10 settlementAmount not_for_seller hide">';
		firstTds	+= '<input type="hidden" name="optionSeq[]" value="" /></td>';
		firstTds	+= '<td style="padding-right:10px;" class="its-td-align right not_for_seller hide">';
		firstTds	+= '<input style="text-align: right;" class="line onlyfloat input-box-default-text" name="commissionRate[]" value="' + default_commission_rate + '" size="3" type="text">';
		firstTds	+= '<span class="commission_type SACO_unit">%</span>';
		firstTds	+= '<span class="commission_type SUPPLY_unit" style="display:none;">';
		firstTds	+= '<select name="commissionType[]" class="commission_type_sel"><option value="SUCO">%</option><option value="SUPR">원</option></select></span>';
		firstTds	+= '</td>';
	} else {
		firstTds	+= '<td class="its-td-align right pdr10 settlementAmount">';
		firstTds	+= '<input type="hidden" name="optionSeq[]" value="" /></td>';
		firstTds	+= '<td style="padding-right:10px;" class="its-td-align right">';
		firstTds	+= '<input type="hidden" style="text-align: right;" class="line onlyfloat input-box-default-text" name="commissionRate[]" value="' + default_commission_rate + '" size="3">' + default_commission_rate;
		firstTds	+= '<span class="commission_type SACO_unit">%</span>';
		firstTds	+= '<span class="commission_type SUPPLY_unit" style="display:none;">';
		firstTds	+= '<select name="commissionType[]" class="commission_type_sel"><option value="SUCO">%</option><option value="SUPR">원</option></select></span>';
		firstTds	+= '</td>';
	}

	firstTds	+= '<td class="its-td-align right pdr10 pricetd">';
	firstTds	+= '<input type="text" name="consumerPrice[]" value="0" size="10" class="onlyfloat line" style="text-align:right;color:#000;" />';
	firstTds	+= '→';
	firstTds	+= '<input type="text" name="price[]" value="0" size="10" class="onlyfloat line" style="text-align:right" />';
	firstTds	+= '</td>';
	firstTds	+= '<td class="its-td-align right pdr10 tax" style="padding-right:10px"></td>';
	firstTds	+= '<td class="its-td-align right pdr10">';
	firstTds	+= '<input type="text" name="reserveRate[]" value="0" size="3" class="line onlyfloat" style="text-align:right;" />';
	firstTds	+= '<select name="reserveUnit[]" class="line">';
	firstTds	+= '<option value="percent">%</option>';
	firstTds	+= '<option value="'+gl_basic_currency+'" selected>'+gl_basic_currency+'</option>';
	firstTds	+= '</select>';
	firstTds	+= '<input type="text" name="reserve[]" class="line onlynumber" value="0" style="text-align:right" size="5" readonly />';
	firstTds	+= '</td>';
	firstTds	+= '<td class="its-td-align center">';
	firstTds	+= '<select name="out_of_stock_view[]">';
	firstTds	+= '<option value="Y">노출</option>';
	firstTds	+= '<option value="N">미노출</option>';
	firstTds	+= '</select>';
	firstTds	+= '</td>';
	firstTds	+= '</tr>';
	firstTds	+= '</tbody>';
	firstTds	+= '</table>';

	return firstTds;
}




function default_suboption_input(){
	
	// 수수료
	var default_commission_rate = get_default_commission_rate();
	
	var firstTds = '<td class="its-td-align center subSettlementAmount"></td>';
	firstTds += '<td style="padding-right: 10px;" class="its-td-align right"><input style="text-align: right;" class="line onlynumber input-box-default-text" name="subCommissionRate[]" value="'+default_commission_rate+'" size="3" type="text">%</td>';
	firstTds += '<td class="its-td-align center"><input type="text" name="subSupplyPrice[]" class="line onlynumber" style="text-align:right" size="10" /></td>';				
	firstTds += '<td class="its-td-align right subSupplyRate" style="padding-right:10px"></td>';
	firstTds += '<td class="its-td-align center"><input type="text" name="subConsumerPrice[]" class="line onlynumber" style="text-align:right" size="10" /></td>';
	firstTds += '<td class="its-td-align center"><input type="hidden" class="sub_net_profit" value="0" > <input type="text" name="subPrice[]" class="line onlynumber" style="text-align:right" size="10" /></td>';
	firstTds += '<td class="its-td-align right subDiscountRate" style="padding-right:10px"></td>';
	firstTds += '<td class="its-td-align right subTax" style="padding-right:10px"></td>';
	firstTds += '<td class="its-td-align center"><input type="text" name="subStock[]" class="line onlynumber" style="text-align:right" size="5" /></td>';
	firstTds += '<td class="its-td-align center"><input style="text-align: right;" class="line onlynumber input-box-default-text" name="subReserveRate[]" value="0" size="3" type="text"><select class="line" name="subReserveUnit[]"><option value="percent" selected>%</option><option value="won">원</option>	</select><input style="text-align: right;" class="line onlynumber input-box-default-text" name="subReserve[]" value="0" size="5" type="text" readonly /></td>';
	return firstTds;
}

function get_suboption_title(){
	var point_text = $("#optionLayer .point_text").text();
	tagTitle = '<thead>';
	tagTitle += '<tr>';		
	tagTitle += '<th class="its-th-align center" rowspan="2"><span class="btn-minus"><button type="button" id="addSuboptionButton"></button></span></th>';		
	tagTitle += '<th class="its-th-align center" colspan="3">추가옵션</th>';
	tagTitle += '<th class="its-th-align center" rowspan="2">정산 금액</th>';
	tagTitle += '<th class="its-th-align center" rowspan="2">수수료율</th>';
	tagTitle += '<th class="its-th-align center" rowspan="2">평균 매입가</th>';
	tagTitle += '<th class="its-th-align center" rowspan="2">평균 매입율</th>';
	tagTitle += '<th class="its-th-align center" rowspan="2">정가(소비자가/시중가)</th>';
	tagTitle += '<th class="its-th-align center" rowspan="2">마진 / 할인가(판매가)</th>';
	tagTitle += '<th class="its-th-align center" rowspan="2">할인율</th>';
	tagTitle += '<th class="its-th-align center" rowspan="2">부가세</th>';
	tagTitle += '<th class="its-th-align center" rowspan="2">재고(가용)</th>';
	tagTitle += '<th class="its-th-align center" rowspan="2">';
	tagTitle += "지급 마일리지<div style='color:#999999;' class='point_text'>"+point_text+"</div>";
	tagTitle += '</th>';
	tagTitle += '</tr>';
	tagTitle += '<tr>';
	tagTitle += '<th class="its-th-align center">필수여부</th>';
	tagTitle += '<th class="its-th-align center">옵션명</th>';
	tagTitle += '<th class="its-th-align center">옵션값</th>';
	tagTitle += '</tr>';
	tagTitle += '</thead>';
	
	return tagTitle;
}

function get_suboption_input(optName, optValue, optCode, optType){
	
	var tag = '<tbody>';	
	for (var i=0;i<optValue.length;i++){						
						
			if(!optValue[i]) continue;
		for (var j=0;j < optValue[i].length;j++){	
			var tmpName = $.trim(optName[i]);
			var tmpType = $.trim(optType[i]);
			var tmpCode = $.trim(optCode[i][j]);
			var tmpValue = $.trim(optValue[i][j]);
			if(tmpValue){
				tag += '<tr class="suboptionTr">';
				tag += '<td class="its-td-align center"><span class="btn-minus"><button type="button" class="delSuboptionButton"></button></span></td>';
				if(j == 0){
					tag += '<td class="its-td-align center"><input type="checkbox" size="10" name="subRequired[]" value="y" /></td>';
					//tag += '<td class="its-td-align center"><input type="text" size="10" name="suboptTitle[]" value="' + tmpName + '" />';
					if( tmpType == 'direct' || !tmpType ) {
						tag += '<td class="its-td-align center"><input type="text" size="10" name="suboptTitle[]" value="' + tmpName + '"  class="line " />';
					}else{
						tag += '<td class="its-td-align center"><input type="text" size="10" name="suboptTitle[]" value="' + tmpName + '"  class="line input-box-default-text-code " />';
					}
					tag += '<input type="hidden" size="10" name="suboptType[]" value="' + tmpType + '" /></td>';
				}else{
					tag += '<td class="its-td-align center"></td>';
					tag += '<td class="its-td-align center"></td>';
				}

				//tag += '<td class="its-td-align center"><input type="text" size="10" name="subopt[' + i + '][]" value="' + tmpValue + '" />';
				if( tmpType == 'direct' || !tmpType ) {
					tag += '<td class="its-td-align center"><input type="text" size="10" name="subopt[' + i + '][]" value="' + tmpValue + '"  class="line " />';
				}else{
					tag += '<td class="its-td-align center"><input type="text" size="10" name="subopt[' + i + '][]" value="' + tmpValue + '"  class="line input-box-default-text-code " />';
				}
				tag += '<input type="hidden" size="10" name="suboptCode[' + i + '][]" value="' + tmpCode + '" /></td></tr>';
			}
		}			
	}
	tag += '</tbody>';
	return tag;	
}

function get_suboption_price(optPrice){
	var k = 0;
	var subPrice = new Array();
	for (var i=0;i<optPrice.length;i++){						
		for (var j=0;j < optPrice[i].length;j++){		
			subPrice[k] = optPrice[i][j];
			k++;
		}			
	}
	return subPrice;
}

function make_suboption(){
	var optValue = new Array();
	var optPrice = new Array();
	var optName = new Array();
	var subPrice = new Array();
	
	var optCode = new Array();
	var optType = new Array();

	var copyOptionTd, tmp, tag;			
	var makeNameObj = $("input[name='suboptionMakeName[]']");
	var makeValueObj = $("input[name='suboptionMakeValue[]']");
	var makePriceObj = $("input[name='suboptionMakePrice[]']");	
	var makeCodeObj = $("input[name='suboptionMakeCode[]']");
	var makeTypeObj = $("input[name='suboptionMakeType[]']");	
	$("#suboptionLayer").html("<table class='info-table-style' width='100%'></table>");
	var clone = $("div#suboptionLayer table").clone();
	
	var tagTitle = get_suboption_title();
	var firstTdsTag = default_suboption_input();		
	
	var nameArr = new Array();
	makeNameObj.each(function(idx){
		if(!$.inArray($(this).val(),nameArr)){
			alert("옵션명이 중복되었습니다.");
			return;
		}
		nameArr[idx] = $(this).val();	 
		optName[idx] = $(this).val();	
		tmp = makeValueObj.eq(idx).val();
		optValue[idx] = tmp.split(',');
		tmp = makePriceObj.eq(idx).val();
		optPrice[idx] = tmp.split(',');			
		
		tmp = makeCodeObj.eq(idx).val();
		optCode[idx] = tmp.split(',');		
		tmp = makeTypeObj.eq(idx).val();
		optType[idx] = tmp.split(',');	

		cols = idx;
	});

	for (var i=0;i < optValue.length;i++){	
			if(!optValue[i]) continue;
		for (var j=0;j < optValue[i].length;j++){
			if( ! optPrice[i] ) optPrice[i] = new Array();
			if( ! optPrice[i][j] ){					
				optPrice[i][j] = 0;
			}
		}
	}
	
	subPrice = get_suboption_price(optPrice);
	tag = get_suboption_input(optName, optValue, optCode, optType);
	clone.children("thead").remove();
	clone.children("tbody").remove();
	
	clone.html( tagTitle );
	clone.append( tag );	
			
	clone.find("tbody tr").each(function(idx){			
		$(this).append( firstTdsTag );
	});

	clone.find("input[name='subRequired[]']").each(function(idx){
		   $(this).val(idx);     
	});

	clone.find("input[name='subPrice[]']").each(function(idx){
		$(this).val(subPrice[idx]);	
	});
	
	// 수수료
	var default_commission_rate = get_default_commission_rate();
	
	$("input[name='commissionRate[]']",clone).val(default_commission_rate);
		
	$("#suboptionLayer").html( clone );	
	calulate_subOption_price();	
}

/* 추가옵션가격 일괄 적용 */
function batch_suboption_price(){
	var n = 0;
	var supplyPrice,consumerPrice,price;
	var subReserveRate,subReserveUnit,subReserve,subStock;
	$("div#suboptionLayer input[name='suboptTitle[]']").each(function(i){		
		$("div#suboptionLayer input[name='subopt["+i+"][]']").each(function(j){
			if(j == 0){
				supplyPrice		= $("input[name='subSupplyPrice[]']").eq(n).val();
				//subcoupon_input	= $("input[name='subcoupon_input[]']").eq(n).val();
				consumerPrice	= $("input[name='subConsumerPrice[]']").eq(n).val();
				price			= $("input[name='subPrice[]']").eq(n).val();
				subStock			= $("input[name='subStock[]']").eq(n).val(); 
				subSafeStock		= $("input[name='subSafeStock[]']").eq(n).val(); 
				subReserveRate 	= $("input[name='subReserveRate[]']").eq(n).val();
				subReserveUnit 	= $("select[name='subReserveUnit[]']").eq(n).find("option:selected").attr("value");
				subReserve			= $("input[name='subReserve[]']").eq(n).val();				
			}else{
				$("input[name='subSupplyPrice[]']").eq(n).val(supplyPrice);
				$("input[name='subConsumerPrice[]']").eq(n).val(consumerPrice);
				//$("input[name='subcoupon_input[]']").eq(n).val(subcoupon_input);
				$("input[name='subPrice[]']").eq(n).val(price);

				$("input[name='subStock[]']").eq(n).val(subStock); 
				$("input[name='subSafeStock[]']").eq(n).val(subSafeStock); 
				$("input[name='subReserveRate[]']").eq(n).val(subReserveRate);
				$("select[name='subReserveUnit[]']").eq(n).find("option[value='"+subReserveUnit+"']").attr("selected",true);			
				$("input[name='subReserve[]']").eq(n).val(subReserve);
			}
			n++;
		});
	});
}

/* 추가입력 폼 입력타입 체크 */
function check_memberInputMakeForm(){
	var inputlimit;
	var text	= "";
	var img		= "<input type=\"hidden\" name=\"memberInputMakeLimit[]\" value=\"file\" /> 2M이하";
	$("select[name='memberInputMakeForm[]'] option:selected").each( function(n){
		if( $(this).val() == 'file'){
			$(this).parent().parent().next().children("div.textLimit").hide();
			$(this).parent().parent().next().children("div.uploadLimit").show();
			$(this).parent().parent().next().children("div.textLimit").html("");
			$(this).parent().parent().next().children("div.uploadLimit").html(img);
		}else{			
			inputlimit		= $("input[name='memberInputMakeLimit[]']").eq(n).val();
			if(inputlimit>0){
				text	= "<input type=\"text\" name=\"memberInputMakeLimit[]\" class=\"line\" size=\"2\" value=\""+inputlimit+"\" />자 이내";
			}else{
				text = "<input type=\"text\" name=\"memberInputMakeLimit[]\" class=\"line\" size=\"2\" value=\"0\" />자 이내";
			}
			$(this).parent().parent().next().children("div.textLimit").show();
			$(this).parent().parent().next().children("div.uploadLimit").hide();
			$(this).parent().parent().next().children("div.textLimit").html(text);
			$(this).parent().parent().next().children("div.uploadLimit").html("");
		}
	});
}

/* 추가입력 폼 생성 */
function get_memberInput_title(){
	var tag = '';	
	tag += '<table  class="simplelist-table-style" style="width:100%">';
	tag += '<thead>';
	tag += '<tr>';	
	tag += '	<th class="its-th-align center" width="100">입력필수</th>';
	tag += '	<th class="its-th-align center" width="250">옵션명</th>';
	tag += '	<th class="its-th-align center">옵션값</th>';	
	tag += '</tr>';
	tag += '</thead>';
	tag += '<tbody>';
	tag += '</tbody>';
	tag += '</table>';
	return tag;	
}


/* 추가입력 폼 내용 생성 */
function get_memberInput(){
	var tag = '';
	var iName,iForm,iRequire,iRequireView;
	
	$("div#memberInputDialog input[name='memberInputMakeName[]']").each(function(i){
		iName		= $(this).val();
		iForm		= $("select[name='memberInputMakeForm[]']").eq(i).children("option:selected").val();
		iLimit		= $("input[name='memberInputMakeLimit[]']").eq(i).val();
		iRequire	= ($("input[name='memberInputRequire[]']").eq(i).is(':checked')) ? 'require' : '';
		iRequireYN	= (iRequire == 'require') ? 'Y' : 'N';
		
		switch (iForm) {
			case 'text' :
				iFormTxt	= '텍스트박스('+iLimit+'자 이내)';
				break;

			case 'edit' :
				iFormTxt	= '에디트박스('+iLimit+'자 이내)';
				break;
			
			case 'file' :
				iFormTxt	= '이미지 업로드 (2M이하)';
				break;
		}


		tag			+= '<tr>';
		tag			+= '<td class="its-td pd10 center">'+ iRequireYN;
		tag			+= '<input type="hidden" name="memberInputRequire[]" value="' + iRequire + '" />';
		tag			+= '<input type="hidden" name="memberInputName[]" value="' + iName + '">';
		tag			+= '<input type="hidden" name="memberInputForm[]" value="' + iForm + '">';
		tag			+= '<input type="hidden" name="memberInputLimit[]" value=" '+ iLimit + '">';
		tag			+= '</td>';
		tag			+= '<td class="its-td pd10 center">' + iName + '</td>';
		tag			+= '<td class="its-td pd10">' + iFormTxt + '</td>';
		tag			+= '</tr>';
	});
	return tag;	
}

function set_goods_icon(){	
	$.getJSON('icon', function(data) {
		var tag = '';
		var width_sum = 0;
		$("div#goodsIconPopup ul li").remove();
		for(var i=0;i<data.length;i++){
			width_sum += data[i].width+60;
			if (width_sum >= 450) {
				tag += '</ul><ul>';
				width_sum = 0;
			}
			tag += '<li style="float:left;padding:5px 10px 5px 10px;'+data[i].li_css+'">';
			tag += '<input type="hidden" name="goodsIconCode[]" value="'+data[i].codecd+'">';
			tag += '<img src="/data/icon/goods/'+data[i].codecd+'.gif" border="0" class="hand icon" align="absmiddle">';
			tag += '('+data[i].codecd+')';
			tag += '</li>';
		}
		$("div#goodsIconPopup ul").html(tag);
	});
}

/* 가격 대체 문구 */
function show_stringPrice(){
	var obj = $("input[name='stringPriceUse']");
	if( obj.attr("checked") ){			
		obj.parent().parent().find("span").show();
	}else{
		obj.parent().parent().find("span").hide();
	}
}

/* 복수구매 할인 */
function show_multiDiscountUse(){
	var obj = $("input[name='multiDiscountUse']"); 
	if( obj.attr("checked") ){			
		obj.parent().parent().find("span").show();
	}else{
		obj.parent().parent().find("span").hide();
	}
}

/* 최소구매수량 */
function show_minPurchaseLimit(){
	var obj = $("input[name='minPurchaseLimit']:checked");	
	if( obj.val() == 'limit' ){			
		obj.parent().parent().find("span").show();
	}else{
		obj.parent().parent().find("span").hide();
	}
}

/* 최대 구매수량 */
function show_maxPurchaseLimit(){
	var obj = $("input[name='maxPurchaseLimit']:checked");	
	if( obj.val() == 'limit' ){			
		obj.parent().parent().find("span").show();
	}else{
		obj.parent().parent().find("span").hide();
	}
}

/* 필수옵션 사용 */
function show_optionUse(){
	var obj = $("input[name='optionUse']"); 
	if( obj.eq(1).is(':checked') ){
		obj.closest('td').find("span.optionuse-lay").show();
		$("form div#optionRegistLayer").show();
		$("form div.package_setting").hide();
	}else{
		// 필수옵션 사용에 대한 데이터일 때만 초기화
		//if	($('div#optionLayer').find("input[name='optionSeq[]']").eq(0).val() > 0){
			var default_option = get_default_option();
			$("#optionLayer").html(default_option);
			help_tooltip();
			setOptionStockSetText();
		//}
		obj.closest('td').find("span.optionuse-lay").hide();
		$("form div#optionRegistLayer").hide();
		$("form div.package_setting").show();
	}
	
	try{ 
	if(eval("provider_seq")) 
	{ 
		var provider_seq = provider_seq;
	} 
	}catch(e){ 
		var provider_seq = '';
	}
	
	if(provider_seq != undefined && provider_seq!=''){
		$("select[name='reserve_policy'] option").each(function(){
			if($(this).parent().val()!=$(this).attr("value")){
				$(this).attr("disabled",true);
			}
			$("input[name='reserveRate[]'], select[name='reserveUnit[]'], input[name='reserve[]'], input[name='subReserveRate[]'], select[name='subReserveUnit[]'], input[name='subReserve[]']").css('opacity',0.5);
			$("input[name='reserveRate[]'], select[name='reserveUnit[]'], input[name='subReserveRate[]'], select[name='subReserveUnit[]']").attr('readonly',true);
			$("select[name='reserveUnit[]'] option[value!='percent'], select[name='subReserveUnit[]'] option[value!='percent']").attr('disabled',true);
		});
	}
	calulate_option_price();
	package_unit_ea_display();
}

/* 추가옵션 사용 */
function show_subOptionUse(){
	var obj = $("input[name='subOptionUse']");
	if( obj.is(':checked') ){
		obj.parent().parent().find("span.hideSpan").show();
		$("#suboptionIndividualSettingLayer").show();
	}else{
		$("#suboptionLayer").html("");
		obj.parent().parent().find("span.hideSpan").hide();
		$("#suboptionIndividualSettingLayer").hide();
	}
	calulate_subOption_price();
}

/* 구매자 추가입력 */
function show_memberInputUse(){
	var obj = $("input[name='memberInputUse']");
	if( obj.is(':checked') ){
		obj.parent().parent().find("span.hideSpan").show();
	}else{
		$("#memberInputLayer").html("");
		obj.parent().parent().find("span.hideSpan").hide();
	}
}

/* 다량옵션오류방지를 위하여 인코딩된 옵션폼값을 인코딩 : disable 처리 */
function encodeFormValue(containerSelector){
	var container = $(containerSelector);
	var selector = "input[type='text'],input[type='hidden'],input[type='radio'],input[type='checkbox'],select,textarea";
	var data = new Array();
	$(selector,container).each(function(){
		var name = $(this).attr("name");
		var type = $(this).attr("type");
		
		if(name=='encodedFormValue') return;
		if($(this).is(":disabled")) return;
		if((type=='radio' || type=='checkbox') && !$(this).is(":checked")) return;
		
		data.push($(this).attr('name') + "=" + encodeURIComponent($(this).val()));
	});
	
	$(selector,container).each(function(){
		var name = $(this).attr("name");
		if(name=='encodedFormValue') return;
		var oriDisabled = $(this).is(":disabled")?true:false; 
		$(this).data("oriDisabled",oriDisabled).attr("disabled",true);
	});
	
	$("textarea[name='encodedFormValue']").val(data);
}

/* 다량옵션오류방지를 위하여 인코딩된 옵션폼값을 인코딩 : disable 해제 */
function encodeFormValueOff(containerSelector){
	var container = $(containerSelector);
	var selector = "input[type='text'],input[type='hidden'],input[type='radio'],input[type='checkbox'],select,textarea";
	$(selector,container).each(function(){
		var name = $(this).attr("name");
		if(name=='encodedFormValue') return;
		var oriDisabled = $(this).data("oriDisabled")?true:false; 
		$(this).attr("disabled",oriDisabled);
	});
	
	$("textarea[name='encodedFormValue']").val('');
}

/* 상품등록 에디터로딩 세팅 */
function setting_editor()
{		
	$.ajax({
		type: "get",
		url: "../setting/setting_editor_popup",
		success: function(result){
			$("div#setting_editor_popup").html(result);
		}
	});
	openDialog("상품등록/수정 페이지에서의 상품 설명 보기 설정", "setting_editor_popup", {"width":"650","height":"180","show" : "fade","hide" : "fade"});		
}

//새창 > 상품사진 멀티일괄/일괄 등록시 
function save_image_config(){
	var saveinfo = {'largeImageWidth':$('#largeImageWidth').val(), 'largeImageHeight':$('#largeImageHeight').val(),
	'viewImageWidth':$('#viewImageWidth').val(), 'viewImageHeight':$('#viewImageHeight').val(),
	'list1ImageWidth':$('#list1ImageWidth').val(), 'list1ImageHeight':$('#list1ImageHeight').val(),
	'list2ImageWidth':$('#list2ImageWidth').val(), 'list2ImageHeight':$('#list2ImageHeight').val(),
	'thumbViewWidth':$('#thumbViewWidth').val(), 'thumbViewHeight':$('#thumbViewHeight').val(),
	'thumbCartWidth':$('#thumbCartWidth').val(), 'thumbCartHeight':$('#thumbCartHeight').val(),
	'thumbScrollWidth':$('#thumbScrollWidth').val(), 'thumbScrollHeight':$('#thumbScrollHeight').val()};

	$.ajax({
		'type': "POST",
		'url': "../goods_process/save_image_config",
		'data': saveinfo,
		'dataType' : 'json',
		'success': function(result){ 
			if( result.result ) { 
				$("#largeImageWidth",window.opener.document).val(result.largeImageWidth);
				$("#largeImageHeight",window.opener.document).val(result.largeImageHeight);

				$("#viewImageWidth",window.opener.document).val(result.viewImageWidth);
				$("#viewImageHeight",window.opener.document).val(result.viewImageHeight);

				$("#list1ImageWidth",window.opener.document).val(result.list1ImageWidth);
				$("#list1ImageHeight",window.opener.document).val(result.list1ImageHeight);

				$("#list2ImageWidth",window.opener.document).val(result.list2ImageWidth);
				$("#list2ImageHeight",window.opener.document).val(result.list2ImageHeight);

				$("#thumbViewWidth",window.opener.document).val(result.thumbViewWidth);
				$("#thumbViewHeight",window.opener.document).val(result.thumbViewHeight);

				$("#thumbCartWidth",window.opener.document).val(result.thumbCartWidth);
				$("#thumbCartHeight",window.opener.document).val(result.thumbCartHeight);

				$("#thumbScrollWidth",window.opener.document).val(result.thumbScrollWidth);
				$("#thumbScrollHeight",window.opener.document).val(result.thumbScrollHeight);

				
				$(".largeImageWidth",window.opener.document).text(result.largeImageWidth);
				$(".largeImageHeight",window.opener.document).text(result.largeImageHeight);

				$(".viewImageWidth",window.opener.document).text(result.viewImageWidth);
				$(".viewImageHeight",window.opener.document).text(result.viewImageHeight);

				$(".list1ImageWidth",window.opener.document).text(result.list1ImageWidth);
				$(".list1ImageHeight",window.opener.document).text(result.list1ImageHeight);

				$(".list2ImageWidth",window.opener.document).text(result.list2ImageWidth);
				$(".list2ImageHeight",window.opener.document).text(result.list2ImageHeight);

				$(".thumbViewWidth",window.opener.document).text(result.thumbViewWidth);
				$(".thumbViewHeight",window.opener.document).text(result.thumbViewHeight);

				$(".thumbCartWidth",window.opener.document).text(result.thumbCartWidth);
				$(".thumbCartHeight",window.opener.document).text(result.thumbCartHeight);

				$(".thumbScrollWidth",window.opener.document).text(result.thumbScrollWidth);
				$(".thumbScrollHeight",window.opener.document).text(result.thumbScrollHeight);

				$(".save_image_input").attr("disabled","disabled").attr("readonly","readonly");
				$("button.save_image_config").parent().addClass("gray").removeClass("cyanblue");
				$("#save_image_config_ck").removeAttr("checked")
				openDialogAlert(result.msg,400,150);
			}else{
				openDialogAlert(result.msg,400,150);
			}
		}
	}); 
}

// 옵션 선택박스 layout 설정 사용여부 변경
var sub_require	= 'N';
function set_option_select_layout(){

	var option_layout_button_status			= false;
	var chk_option_use						= false;
	var chk_suboption_use					= false;
	var chk_suboption_require				= false;
	var chk_inputoption_use					= false;

	// 추가옵션 위치 선택 disable ( 설정 불가 )
	$("select[name='set_suboption_select_layout_position']").addClass('disable').unbind('change');
	$("select[name='set_suboption_select_layout_position']").change(function(){
		$(this).find('option').eq(0).attr('selected', true);
	});
	// 입력옵션 묶임 선택 disable ( 설정 불가 )
	$("select[name='set_inputoption_select_layout_group']").addClass('disable').unbind('change');
	$("select[name='set_inputoption_select_layout_group']").change(function(){
		$(this).find('option').eq(0).attr('selected', true);
	});

	// 기존 db의 설정값
	if	($("input[name='optionUse']").eq(1).attr('checked') && $('div#optionLayer tbody tr').length > 0 && 
		!$('div#optionLayer tbody').find("input[name='price[]'][type='text']").length){

		chk_option_use				= true;

		// 추가옵션 묶임 선택 disable
		$("select[name='set_suboption_select_layout_group']").addClass('disable').unbind('change');
		$("select[name='set_suboption_select_layout_group']").change(function(){
			$(this).find('option').eq(0).attr('selected', true);
		});

		// 추가옵션 처리
		if	($("input[name='subOptionUse']").attr('checked') && $('tr.suboptionTr').length > 0){
			chk_suboption_use	= true;
			sub_require			= 'N';
			$('tr.suboptionTr').each(function(){
				if	($(this).find('td').eq(1).text().search(/Y/) != -1){
					sub_require	= 'Y';
					return false;
				}
			});

			// 추가구성옵션 필수사용여부
			if	(sub_require == 'Y'){
				chk_suboption_require		= true;

				// 레이아웃 설정 필수 추가옵션 사용 처리
				$("#set_suboption_require").html(' : 필수포함됨');
				$("select[name='set_suboption_select_layout_group']").val('group');
				$("select[name='set_suboption_select_layout_position']").val('up');
				$("#display_suboption_select_layout_group").html('필수옵션과 쌍으로 묶임 : 해당 필수상품에 → 해당되는 추가상품 정확히 출고');
				$("#display_suboption_select_layout_position").html('옵션선택 영역에 노출되어');
			}else{
				option_layout_button_status	= true;

				// 기존 db의 설정값과 비교 후 레이아웃 설정 일반 추가옵션 사용 처리
				$("#set_suboption_require").html(' : 필수없음');
				if	(!gl_suboption_layout_group)
					gl_suboption_layout_group		= 'group';
				if	(!gl_suboption_layout_position)
					gl_suboption_layout_position	= 'up';

				$("select[name='set_suboption_select_layout_group']").val(gl_suboption_layout_group);
				$("select[name='set_suboption_select_layout_position']").val(gl_suboption_layout_position);
				if (gl_suboption_layout_group == 'first')
					$("#display_suboption_select_layout_group").html('첫번째 필수옵션에 묶임 : 첫번째 필수상품에 → 해당되는 추가상품 정확히 출고');
				else
					$("#display_suboption_select_layout_group").html('필수옵션과 쌍으로 묶임 : 해당 필수상품에 → 해당되는 추가상품 정확히 출고');

				if (gl_suboption_layout_position == 'down')
					$("#display_suboption_select_layout_position").html('선택된 옵션 영역에 노출되어');
				else
					$("#display_suboption_select_layout_position").html('옵션선택 영역에 노출되어');

				// 추가옵션 묶임 선택
				$("select[name='set_suboption_select_layout_group']").removeClass('disable').unbind('change');
				/*$("select[name='set_suboption_select_layout_group']").change(function(){
					set_option_select_display('apply');
				});*/
			}
		}else{
			// 레이아웃 설정 미사용 처리
			$("#set_suboption_require").html('');
			$("select[name='set_suboption_select_layout_group']").val('group');
			$("select[name='set_suboption_select_layout_position']").val('up');
			$("#display_suboption_select_layout_group").html('<span style="color:#9a9a9a;">미사용</span>');
			$("#display_suboption_select_layout_position").html('');
		}

		// 입력옵션 처리
		if	($("input[name='memberInputUse']").attr('checked') && $("input[name='memberInputName[]']").length > 0){

			chk_inputoption_use			= true;
			option_layout_button_status	= true;

			// 기존 db의 설정값과 비교 후 레이아웃 설정 입력옵션 사용 처리
			if	(!gl_inputoption_layout_group)
				gl_inputoption_layout_group		= 'group';
			if	(!gl_inputoption_layout_position)
				gl_inputoption_layout_position		= 'up';

			$("select[name='set_inputoption_select_layout_group']").val(gl_inputoption_layout_group);
			$("select[name='set_inputoption_select_layout_position']").val(gl_inputoption_layout_position);
			if	(gl_inputoption_layout_group == 'first')
				$("#display_inputoption_select_layout_group").html('첫번째 필수옵션에 묶임 : 해당 필수상품에 → 해당되는 입력벙보 정확히 확인');
			else
				$("#display_inputoption_select_layout_group").html('필수옵션과 쌍으로 묶임 : 해당 필수상품에 → 해당되는 입력벙보 정확히 확인');

			if	(gl_inputoption_layout_position == 'down')
				$("#display_inputoption_select_layout_position").html('선택된 옵션 영역에 노출되어');
			else
				$("#display_inputoption_select_layout_position").html('옵션선택 영역에 노출되어');

			// 추가옵션 위치 선택 disable
			$("select[name='set_inputoption_select_layout_position']").removeClass('disable').unbind('change');
			/*$("select[name='set_inputoption_select_layout_position']").change(function(){
				set_option_select_display('apply');
			});*/

		}else{
			// 레이아웃 설정 미사용 처리
			$("select[name='set_inputoption_select_layout_group']").val('group');
			$("select[name='set_inputoption_select_layout_position']").val('up');
			$("#display_inputoption_select_layout_group").html('<span style="color:#9a9a9a;">미사용</span>');
			$("#display_inputoption_select_layout_position").html('');

			// 입력옵션 위치 선택 disable
			$("select[name='set_inputoption_select_layout_position']").addClass('disable').unbind('change');
			$("select[name='set_inputoption_select_layout_position']").change(function(){
				$(this).find('option').eq(0).attr('selected', true);
			});
		}

		set_option_select_display('');

	}else{
		option_layout_button_status	= false;

		// 추가옵션 처리
		if	($("input[name='subOptionUse']").attr('checked') && $('tr.suboptionTr').length > 0){
			$("#display_suboption_select_layout_group").html('<span style="color:#9a9a9a;">필수옵션과 쌍으로 묶임</span>');
			$("#display_suboption_select_layout_position").html('<span style="color:#9a9a9a;">옵션선택 영역에 노출</span>');
		}else{
			$("#display_suboption_select_layout_group").html('<span style="color:#9a9a9a;">미사용</span>');
			$("#display_suboption_select_layout_position").html('');
		}

		// 입력옵션 처리
		if	($("input[name='memberInputUse']").attr('checked') && $("input[name='memberInputName[]']").length > 0){
			$("#display_inputoption_select_layout_group").html('<span style="color:#9a9a9a;">필수옵션과 쌍으로 묶임</span>');
			$("#display_inputoption_select_layout_position").html('<span style="color:#9a9a9a;">옵션선택 영역에 노출</span>');
		}else{
			$("#display_inputoption_select_layout_group").html('<span style="color:#9a9a9a;">미사용</span>');
			$("#display_inputoption_select_layout_position").html('');
		}

		$("select[name='set_suboption_select_layout_group']").val('group');
		$("select[name='set_suboption_select_layout_position']").val('up');
		$("select[name='set_inputoption_select_layout_group']").val('group');
		$("select[name='set_inputoption_select_layout_position']").val('up');

		// 추가옵션 위치 선택 disable ( 설정 불가 )
		$("select[name='set_suboption_select_layout_group']").addClass('disable').unbind('change');
		$("select[name='set_suboption_select_layout_group']").change(function(){
			$(this).find('option').eq(0).attr('selected', true);
		});
		// 입력옵션 묶임 선택 disable ( 설정 불가 )
		$("select[name='set_inputoption_select_layout_position']").addClass('disable').unbind('change');
		$("select[name='set_inputoption_select_layout_position']").change(function(){
			$(this).find('option').eq(0).attr('selected', true);
		});
	}

	// 옵션 레이아웃 설정 버튼 제어
	if	(option_layout_button_status){
		$("#option_layout_button").removeClass('gray').addClass('cyanblue').find('button').unbind('click');
		$("#option_layout_button").find('button').click(function(){
			openSetOptionLayout();
		});
	}else{
		var msg	= '';
		if			(!chk_option_use){
			msg	= '필수옵션이 미사용';
		}else if	(!chk_suboption_use && !chk_inputoption_use){
			msg	= '추가구성옵션 미사용<br/>추가입력옵션 미사용';
		}else if	(chk_suboption_use && chk_suboption_require && !chk_inputoption_use){
			msg	= '추가구성옵션 사용<font color="red">(필수포함됨)</font><br/>추가입력옵션 미사용';
		}
		$("#option_layout_button").removeClass('cyanblue').addClass('gray').find('button').unbind('click');
		if	(msg){
			msg		+= '<br/><br/>위 사유로 화면설정 버튼이 비활성화되었습니다.';
			$("#option_layout_button").find('button').click(function(){
				openDialogAlert(msg, 400, 200);
			});
		}
	}

	international_shipping_info();

	return false;
}

// 옵션 노출 레이아웃 설정 팝업 오픈
function openSetOptionLayout(){
	openDialog('추가(구성/입력) 옵션 구매화면 설정', 'set_option_select_layout', {'width':'1000','height':'600'});
	/*openDialog('추가(구성/입력) 옵션 구매화면 설정', 'set_option_select_layout', {'width':'1000','height':'450','close':function(){
		set_option_select_display('apply');
	}});*/
}

// 옵션 노출 설정 변경에 따른 화면 변경 처리
function set_option_select_display(type){
	var useOption		= false;
	var useSubOption	= false;
	var useInputOption	= false;
	var sub_require		= 'N';
	var sSubGroup		= $("select[name='set_suboption_select_layout_group']").val();
	var sSubPosition	= $("select[name='set_suboption_select_layout_position']").val();
	var sInputGroup		= $("select[name='set_inputoption_select_layout_group']").val();
	var sInputPosition	= $("select[name='set_inputoption_select_layout_position']").val();


	// 필수옵션 사용여부 체크
	if	($("input[name='optionUse']").eq(1).attr('checked') && $('div#optionLayer tbody tr').length > 0 && 
		!$('div#optionLayer tbody').find("input[name='price[]'][type='text']").length){
		useOption		= true;
	}
	// 추가옵션 사용여부 및 필수 존재여부 체크
	if	($("input[name='subOptionUse']").attr('checked') && $('tr.suboptionTr').length > 0){
		useSubOption	= true;
		$('tr.suboptionTr').each(function(){
			if	($(this).find('td').eq(1).text().search(/Y/) != -1){
				sub_require	= 'Y';
				return false;
			}
		});
	}
	// 입력옵션 사용여부 체크
	if	($("input[name='memberInputUse']").attr('checked') && $("input[name='memberInputName[]']").length > 0){
		useInputOption	= true;
	}

	// 추가옵션에 필수가 있는 경우 무조건 쌍으로 묶이며 위에 노출한다.
	if	(!useSubOption || sub_require == 'Y'){
		sSubGroup		= 'group';
		sSubPosition	= 'up';
		$("select[name='set_suboption_select_layout_group']").find('option').eq(0).attr('selected', true);
		$("select[name='set_suboption_select_layout_position']").find('option').eq(0).attr('selected', true);
	}

	// 입력옵션은 쌍으로 묶음만 사용가능
	if	(sInputGroup != 'group'){
		sInputGroup		= 'group';
		$("select[name='set_inputoption_select_layout_group']").find('option').eq(0).attr('selected', true);
	}

	// 입력옵션 미사용 처리
	if	(!useInputOption){
		sInputPosition	= 'up';
		$("select[name='set_inputoption_select_layout_position']").find('option').eq(0).attr('selected', true);
	}

	// type1 or type2
	if			(sSubGroup == 'group' && sSubPosition == 'up'){
		if	(type == 'apply'){
			$("#display_suboption_select_layout_group").html('필수옵션과 쌍으로 묶임');
			$("#display_suboption_select_layout_position").html('옵션선택 영역에 노출');
		}

		// type1
		if			(sInputGroup == 'group' && sInputPosition == 'up'){
			
			if( useInputOption ) {
				$('img#display_option_select_layout_image').attr('src', '/admin/skin/default/images/common/option_select_layout_1.jpg');
			}else{
				$('img#display_option_select_layout_image').attr('src', '/admin/skin/default/images/common/option_select_layout_6.jpg');
			}
			if	(type == 'apply'){
				$("#display_inputoption_select_layout_group").html('필수옵션과 쌍으로 묶임');
				$("#display_inputoption_select_layout_position").html('옵션선택 영역에 노출');
			}

		// type2
		}else if	(sInputGroup == 'group' && sInputPosition == 'down'){
			$('img#display_option_select_layout_image').attr('src', '/admin/skin/default/images/common/option_select_layout_2.jpg');
			if	(type == 'apply'){
				$("#display_inputoption_select_layout_group").html('필수옵션과 쌍으로 묶임');
				$("#display_inputoption_select_layout_position").html('선택된 옵션 영역에 노출');
			}
		}

	// type3 or type4
	}else if	(sSubGroup == 'first' && sSubPosition == 'up'){
		if	(type == 'apply'){
			$("#display_suboption_select_layout_group").html('첫번째 필수옵션에 묶임');
			$("#display_suboption_select_layout_position").html('옵션선택 영역에 노출');
		}

		// type3
		if			(sInputGroup == 'group' && sInputPosition == 'up'){
			if( useInputOption ) {
				$('img#display_option_select_layout_image').attr('src', '/admin/skin/default/images/common/option_select_layout_3.jpg');
			}else{
				$('img#display_option_select_layout_image').attr('src', '/admin/skin/default/images/common/option_select_layout_5.jpg');
			} 
			if	(type == 'apply'){
				$("#display_inputoption_select_layout_group").html('필수옵션과 쌍으로 묶임');
				$("#display_inputoption_select_layout_position").html('옵션선택 영역에 노출');
			}

		// type4
		}else if	(sInputGroup == 'group' && sInputPosition == 'down'){
			$('img#display_option_select_layout_image').attr('src', '/admin/skin/default/images/common/option_select_layout_4.jpg');
			if	(type == 'apply'){
				$("#display_inputoption_select_layout_group").html('필수옵션과 쌍으로 묶임');
				$("#display_inputoption_select_layout_position").html('선택된 옵션 영역에 노출');
			}
		}
	}

	// 추가옵션 화면 설정 미사용 처리
	if	(!useSubOption){
		$("#display_suboption_select_layout_group").html('<span style="color:#9a9a9a;">미사용</span>');
		$("#display_suboption_select_layout_position").html('');
	}
	// 입력옵션 화면 설정 미사용 처리
	if	(!useInputOption){
		$("#display_inputoption_select_layout_group").html('<span style="color:#9a9a9a;">미사용</span>');
		$("#display_inputoption_select_layout_position").html('');
	}

	if	(type == 'apply'){
		$("input[name='suboption_layout_group']").val(sSubGroup);
		$("input[name='suboption_layout_position']").val(sSubPosition);
		$("input[name='inputoption_layout_group']").val(sInputGroup);
		$("input[name='inputoption_layout_position']").val(sInputPosition);
		closeDialog('set_option_select_layout');
	}
}

// 해당 input박스의 입력된 문자 byte수를 계산
function calculate_input_byte(obj){
	$(obj).closest('byte').find('span.view-byte').html(comma(chkByte($(obj).val())));
}

// 해당 input박스의 입력된 글자수를 계산
function calculate_input_len(obj){
	var mobj	= $(obj).closest('len').find('span.view-len');
	var len	= $(obj).val().length;
	var max	= $(obj).attr('maxlength');
	mobj.removeClass('red');
	if(len < max){
		msg	= '<b>'+comma( len ) + '</b>/' + comma( max );
	}else{
		$(obj).val( $(obj).val().substring(0,max) );
		msg	= '<b>'+comma( max ) + '</b>/' + comma( max );
	}
	mobj.html( msg );
	if( len >= max ) mobj.find("b").addClass('red');
}

// 창고별 상세 재고 노출
function scm_warehouse_on(goods_seq, obj){
	var option_seq = '';
	var spanObj	= $(obj).find('span.option-stock');
	if( spanObj.attr('optType') ){
		var option_seq = spanObj.attr('optSeq');
		var optstr	= goods_seq + spanObj.attr('optType') + option_seq;
	}else{
		var optstr	= goods_seq + 'option';
	}
	
	var whLayId = 'stock-wh-info';
	var useWarehouse	= $("input[name='use_warehouse']").eq(0).val();
	
	$(obj).find('div#' + whLayId).remove();
	var whLay	= $('<div class="hide" id="' + whLayId + '"></div>').appendTo(obj);
	
	$.ajax({
		type: "post",
		url: "/scm/request_getstock_total",
		dataType : 'json', 
		data: 'goods_seq=' + goods_seq + '&option_type=option&option_seq=' + option_seq,
		success: function(result) {
			var i = 0;
			var wh_count = 0;
			var data = '';
			var data_wh = '';
			var html = '';
			var title = '';
			var option = '';
			for(var index in result) {
				if (result.hasOwnProperty(index)) {
					data = result[index];
					var wh_count_tot = 0;
					for(var index_wh in data.wh) {
						if (data.wh.hasOwnProperty(index_wh)) {
							wh_count_tot++;
						}
					}

					if( i == 0 ){
						var width = data.option_count * 100 + wh_count_tot * 80 + 180;
						html	+= '<div class="desc pdb5 bold">창고별 정보 : 첫번째줄-재고(불량재고), 두번째줄-매입가, 세번째줄-로케이션</div>';
						html	+= '<div class="desc pdb5 bold">창고별 사용/미사용 : ' + data.admin_env_name + '에서 사용하는 창고에 대하여 \'사용\'이라고 표기함</div>';
						html	+= '<table width="'+width+'" class="info-table-style store-stock" cellpadding="0" cellspacing="0" border="0">';
						html	+= '<thead>';
						html	+= '<tr>';
						if( data.option1 ){
							html	+= '<th class="its-th-align center" colspan="'+data.option_count+'">필수옵션</th>';
						}
						if( data.package_yn != 'y' ){
							for(var index_wh in data.wh) {
								if (data.wh.hasOwnProperty(index_wh)) {
									wh_count++;
									data_wh = data.wh[index_wh];
									if(data_wh.wh_name == null){
										data_wh.wh_name = ' ';
									}
									html	+= '<th class="its-th-align center" rowspan="2" width="80">';
									html	+= data_wh.wh_name;
									if(data_wh.use == 'y'){
										html	+= '<br/>[사용]';
									}else{
										html	+= '<br/>[미사용]';
									}
									html	+= '</th>';
								}
							}
						}
						html	+= '<th class="its-th-align center" rowspan="2" width="80">합계</th>';
						html	+= '<th class="its-th-align center store-box-title" rowspan="2" width="80">';
						html	+= data.admin_env_name;
						html	+= '<br/>재고</th>';
						html	+= '<th class="its-th-align center" rowspan="2" width="80">';
						html	+= data.admin_env_name;
						html	+= '<br/>가용</th>';
						html	+= '</tr>';
						html	+= '<tr>';
						if( data.option1 ){
							for(var j=1;j <= data.option_count;j++){
								eval('title = data.title'+j);
								html	+= '<th class="its-th-align center" width="100">' + title + '</th>';
							}
						}
						html	+= '</tr>';
						html	+= '</thead>';
						html	+= '<tbody>';
					}

					if(($(obj).attr('option_code1') != '') && (data.option1 == $(obj).attr('option_code1') && data.option2 == $(obj).attr('option_code2') && data.option3 == $(obj).attr('option_code3') && data.option4 == $(obj).attr('option_code4') && data.option5 == $(obj).attr('option_code5'))) {
						html	+= '<tr style="border:2px solid red;">';
					} else {
						html	+= '<tr>';
					}

					if( data.option1 ){
						for(var j=1;j <= data.option_count;j++){
							eval('option = data.option'+j);
							html	+= '<td class="its-td-align center">' + option + '</td>';
						}
					}
					if( data.package_yn != 'y' ){
						for(var index_wh in data.wh) {
							if (data.wh.hasOwnProperty(index_wh)) {
								data_wh = data.wh[index_wh];
								if(data_wh.use == 'y'){
									html	+= '<td class="its-td-align right valign-top pdr5 bgyellow">';
								}else{
									html	+= '<td class="its-td-align right valign-top pdr5">';
								}
								html	+= comma(data_wh.stock);
								html	+= '('+comma(data_wh.bad_stock)+')';
								html	+= '<br/>'+comma(data_wh.supply_price);
								html	+= '<br/>'+data_wh.location_code;
								html	+= '</td>';
							}
						}
					}

					html	+= '<td class="its-td-align right valign-top pdr5">';
					html	+= '<span>'+comma(data.total_stock)+'</span> ('+comma(data.total_badstock)+')';
					html	+= '</td>';
					html	+= '<td class="its-td-align right store-box-stock">';
					html	+= '<span>'+comma(data.stock)+'</span> ('+comma(data.badstock)+')';
					html	+= '<br/>'+comma(data.supply_price);
					html	+= '</td>';
					html	+= '<td class="its-td-align right valign-top pdr5">';
					html	+= comma(data.ablestock);
					html	+= '</td>';
					html	+= '</tr>';
				}
				i++;
			}
			width += 40; 
			var height = i*55+200;
			if(i > 10){
				height = 600;
			}

			if(width > 1300){
				width = 1300;
			}

			whLay.append(html);
			help_tooltip();
			openDialog("현재재고", whLayId, {"width":width,"height":height,"show" : "fade","hide" : "fade"});
		}
	});
}

// 패키지 연결상품 재고 노출
function package_stock_on(goods_seq, obj){
	var option_seq = '';
	var spanObj	= $(obj).find('span.option-stock');
	if( spanObj.attr('optType') ){
		var option_seq = spanObj.attr('optSeq');
		var optstr	= goods_seq + spanObj.attr('optType') + option_seq;
	}else{
		var optstr	= goods_seq + 'option';
	}
	var whLayId = 'stock-wh-info';
	var useWarehouse	= $("input[name='use_warehouse']").eq(0).val();

	$(obj).find('div#' + whLayId).remove();
	var whLay	= $('<div class="hide" id="' + whLayId + '"></div>').appendTo(obj);	
	$.ajax({
		type: "post",
		url: "/goods/request_getstock_all",
		dataType : 'json', 
		data: 'goods_seq=' + goods_seq + '&option_type=option&option_seq=' + option_seq,
		success: function(result) {
			var i = 0;
			var wh_count = 0;
			var data = '';
			var data_wh = '';
			var html = '';
			var title = '';
			var option = '';
			var packages_count = 0;
			
			for(var index in result) {
				if (result.hasOwnProperty(index)) {
					data = result[index];
					
					if( i == 0 ){
						var width = data.option_count * 100 + data.package_count * 180 + 180;
						if( data.package_count > 0 ){
							html	+= '<div class="desc pdb5 bold">첫번째줄 : 주문당 발송수량, 두번째줄 : 재고(불량재고)/가용재고/안전재고</div>';
						}else{
							html	+= '<div class="desc pdb5 bold">첫번째줄 : 재고(불량재고), 두번째줄 : 매입가</div>';
						}
						html	+= '<table width="'+width+'" class="info-table-style store-stock" cellpadding="0" cellspacing="0" border="0">';
						html	+= '<thead>';
						html	+= '<tr>';
						if( data.option1 ){
							html	+= '<th class="its-th-align center" colspan="'+data.option_count+'">필수옵션</th>';
						}
						if( data.package_count > 0 ){
							html	+= '<th class="its-th-align center" colspan="'+data.package_count+'">실제상품</th>';
						}
						if(data.package_count == 0 || !data.package_count){
							html	+= '<th class="its-th-align center" rowspan="2" width="80">';
							if(data.admin_env_name!=null) html	+= data.admin_env_name;
							else html	+= '쇼핑몰';
							html	+= '<br/>재고</th>';
							html	+= '<th class="its-th-align center" rowspan="2" width="80">';
							if(data.admin_env_name!=null) html	+= data.admin_env_name;
							else html	+= '쇼핑몰';
							html	+= '<br/>가용</th>';
						}
						html	+= '</tr>';
						html	+= '<tr>';
						if( data.option1 ){
							for(var j=1;j <= data.option_count;j++){
								eval('title = data.title'+j);
								html	+= '<th class="its-th-align center" width="100">' + title + '</th>';
							}
						}

						for(var ig=1; ig <= data.package_count;ig++ ) {
								html	+= '<th class="its-th-align center" width="100">';
								html	+= '상품 '+ ig;
								html	+= '</th>';
						}

						html	+= '</tr>';
						html	+= '</thead>';
						html	+= '<tbody>';
					}
					if(($(obj).attr('option_code1') != '') && (data.option1 == $(obj).attr('option_code1') && data.option2 == $(obj).attr('option_code2') && data.option3 == $(obj).attr('option_code3') && data.option4 == $(obj).attr('option_code4') && data.option5 == $(obj).attr('option_code5'))) {
						html	+= '<tr style="border:2px solid red;">';
					} else {
						html	+= '<tr>';
					}
					if( data.option1 ){ 
						for(var j=1;j <= data.option_count;j++){
							eval('option = data.option'+j);
							html	+= '<td class="its-td-align center" width="80">' + option + '</td>';
						}
					}

					packages_count = 0;
					for(var index_packages in data.packages) {
						if (data.packages.hasOwnProperty(index_packages)) {
							packages_count++;
							data_packages = data.packages[index_packages];
							html	+= '<td class="its-td-align center">';
							html	+= '['+data_packages.package_goods_seq+'] '+ data_packages.package_goods_name+'<br/>';
							html	+= data_packages.package_option+'<br/>';
							html	+= '주문당 '+data_packages.package_unit_ea+'개 발송<span title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량" class="helpicon"></span><br/>';
							if( data_packages.stock != null ) html	+= '<span>'+data_packages.stock+'</span>';
							if( data_packages.badstock != null ) html	+= '('+data_packages.badstock+')';
							if( data_packages.ablestock != null ) html	+= '/'+data_packages.ablestock;
							if( data_packages.safe_stock != null ) html	+= '/'+data_packages.safe_stock;
							html	+= '</td>';
						}
					}
					if(packages_count){
						for(var ig=packages_count; ig < data.package_count;ig++ ) {
								html	+= '<td class="its-td-align center">';
								html	+= '</td>';
						}
					}
					if(packages_count == 0){
						html	+= '<td class="its-td-align right valign-top pdr5 bgyellow">';
						html	+= '<span>'+comma(data.stock)+'</span> ('+comma(data.badstock)+')';
						html	+= '<br/>'+comma(data.supply_price);
						html	+= '</td>';
						html	+= '<td class="its-td-align right valign-top pdr5">';
						html	+= comma(data.ablestock);
						html	+= '</td>';
					}

					html	+= '</tr>';
				}
				i++;
			}

			html	+= '</tbody></table>';

			width += 40; 
			var height = i*70+200;
			if(i > 10){
				height = 600;
			}

			if(width > 1300){
				width = 1300;
			}

			whLay.append(html);
			help_tooltip();

			openDialog("현재재고", whLayId, {"width":width,"height":height,"show" : "fade","hide" : "fade"});
		}

	});
	
}


// 패키지 관련 함수
// 필수옵션 마켓별 금액 조정 결과 처리
function set_market_option_price(tmpseq){
	if	(tmpseq)
		$("input[name='market_tmp_seq']").val(tmpseq);

	closeDialog('market_option_price_lay');
}

// 판매마켓 전송몰 목록 데이터
function set_send_mall(data){
	var viewName	= '';
	var inputbox	= '';
	var cnt			= data.length;
	for	(var m = 0; m < cnt; m++){
		inputbox	+= '<input type="hidden" name="openmarket_send_mall_id[]" value="'+data[m].mall_code+'" />'
					+ '<input type="hidden" name="openmarket_send_mall_name[]" value="'+data[m].mall_name+'" />';

		if	(m == 0){
			viewName	+= data[m].mall_name;
		}else{
			viewName	+= ', ' + data[m].mall_name;
		}
	}
	$("div.mall-input-lay").html(inputbox);

	if	(viewName){
		$("span.mall-view-list").text(viewName);
	}else{
		$("span.mall-view-list").text('없음');
	}

	closeDialog("openmarket_lay");
}


function openGoodsRelationDisplayPopup(kind){
	window.open("../design/display_edit?kind="+kind+"&goods_seq={goods.goods_seq}&popup=1",'',"width=980,height=700,scrollbars=1");
}

//티켓값어치문구변경
function socialcpinputtype() {
		var socialcp_input_type = $("input[name='socialcp_input_type']:checked").val();
		var couponinputsubtitle = '';
		$(".couponinputtitle").show();
		if( socialcp_input_type == 'price' ) {
			couponinputsubtitle = '금액';
		}else{
			couponinputsubtitle = '횟수';
		}
		$(".couponinputsubtitle").text(couponinputsubtitle);
		//티켓값어치수정;;;
}

function goodinfochangeok() {
	$("#goodsinfochage").val("ok");
	 document.goodsRegist.submit();
}

function goodinfochangeno() {
	$("#goodsinfochage").val("");
}



/*
입력옵션 불러오기
**/
function inputoption_frequently_load(goods_seq){
	$.ajax({
		type: "get",
		'dataType' : 'json',
		url: "../goods/set_goods_inputoptions",
		data: "goods_seq="+goods_seq,
		success: function(result) {
			$("#memberInputDialog .simplelist-table-style tbody").html(result.html);
			openDialog("추가옵션 만들기", "memberInputDialog", {"width":"900","height":"350","show" : "fade","hide" : "fade"});
		}
	});
}


//추가정보 >> 추가옵션코드추가
function goodsaddinfocode_default(obj){
	obj.find(".goodsaddinfolay").hide();
	obj.find(".etcContents").show();
	var selectectid = obj.find("select[name='selectEtcTitle[]'] option:selected").val();
	var selectecttitle = obj.find("select[name='selectEtcTitle[]'] option:selected").text();
	if(  selectectid.substr(0,2) == 'goodsaddinfo'){
		 obj.find(".goodsaddinfolay").show();
		 obj.find(".goodsaddinfolay").find(".goodsaddinfosublay").hide();
		 obj.find(".etcContents").hide();
		 obj.find(".etcContents").val(obj.find("."+selectectid+" option:selected").val());
		 obj.find(".etcContents_title").val(obj.find("."+selectectid+" option:selected").text());
		 obj.find(".goodsaddinfolay").find("."+selectectid).show();
		 obj.find(".etcTitle").val(selectecttitle);
	}else{
		obj.find(".etcTitle").val('');
		obj.find(".etcContents_title").val('');
		obj.find(".etcContents").val('');
	}
}

function goodsaddinfocode(obj){
	var tageetRootSet	= obj.parent().parent();
	var targetBox		= tageetRootSet.find(".etcContents");

	tageetRootSet.find(".goodsaddinfolay").hide();
	targetBox.show();

	var selectectid = tageetRootSet.find("select[name='selectEtcTitle[]'] option:selected").val();
	var selectecttitle = tageetRootSet.find("select[name='selectEtcTitle[]'] option:selected").text();
	if( selectectid.substr(0,12) == 'goodsaddinfo'){
		tageetRootSet.find(".goodsaddinfolay").show();
		tageetRootSet.find(".goodsaddinfolay").find(".goodsaddinfosublay").hide();
		tageetRootSet.find(".etcContents_title").val(tageetRootSet.find("."+selectectid+" option:selected").text());
		tageetRootSet.find(".goodsaddinfolay").find("."+selectectid).show();
		tageetRootSet.find(".goodsaddinfolay").closest("tr").find(".byte_area").hide();
		tageetRootSet.find(".etcTitle").val(selectecttitle);

		targetBox.hide();
		targetBox.val(tageetRootSet.find("."+selectectid+" option:selected").val());
	}else{
		tageetRootSet.find(".etcTitle").val('');
		tageetRootSet.find(".etcContents_title").val('');
		tageetRootSet.find(".goodsaddinfolay").closest("tr").find(".byte_area").show();

		targetBox.val('');
		targetBox.siblings('.etcContent_size').html('0');
	}
}

function chgGoodSubInfo(str){
	var goodSubInfo = new Array();
	if(str){
		$.ajax({
			'url' : 'goods_sub_info',
			'data' : {'category':str},
			'dataType' : 'json',
			'success' : function(res){
				$("#subInfoTable").html("");
				if(res.length){
					for(var i=0;i<res.length;i++){
						$("#subInfoTable").append('<tr><td class="its-td-align center"><input type="text" name="subInfoTitle[]" class="line" value="'+res[i].title+'" style="width:90%;"/></td><td class="its-td-align center"><input type="text" name="subInfoDesc[]" class="line" value="" style="width:90%;"/></td></tr>');
					}
				}else{
					$("#subInfoTable").append('<tr><td class="its-td-align center"><input type="text" name="subInfoTitle[]" class="line" value="'+goodSubInfo[i]+'" style="width:90%;"/></td><td class="its-td-align center"><input type="text" name="subInfoDesc[]" class="line" value="" style="width:90%;"/></td></tr>');
				}
			}
		});
	}else{
		$("#subInfoTable").html("");
	}

}

function chgfeedinfo(){
	if	($("input[name='feed_status']").is(':checked')){
		$("#feed_table").addClass('desc2');
		$("select[name='feed_goods_use']").attr('disabled', 'disabled');
		$("input[name='feed_evt_sdate']").attr('disabled', 'disabled');
		$("input[name='feed_evt_edate']").attr('disabled', 'disabled');
		$("input[name='feed_evt_text']").attr('disabled', 'disabled');
		$("#feed_table").find(".datepicker").datepicker("disable");
		$(".setlink").css('color', '#a8a8a8');
	}else{
		$("#feed_table").removeClass('desc2');
		$("select[name='feed_goods_use']").removeAttr('disabled');
		$("input[name='feed_evt_sdate']").removeAttr('disabled');
		$("input[name='feed_evt_edate']").removeAttr('disabled');
		$("input[name='feed_evt_text']").removeAttr('disabled');
		$("#feed_table").find(".datepicker").datepicker("enable");
		$(".setlink").css('color', '#ff6600');
	}
}

function goSetLink(link){
	if	(!$("input[name='feed_status']").is(':checked')){
		window.open(link);
	}
}

function sale_change(str){
	$.ajax({
		'url' : 'member_sale_change',
		'data' : {'sale_seq':str},
		'dataType' : 'html',
		'success' : function(data){
			$("#sale_info_table").html(data);
		}
	});

}


function openSettingOption(){
	var tmp_seq			= $("input[name='tmp_option_seq']").val();
	var goodsTax		= $("input[name='tax']:checked").val();
	if	(!goodsTax)	goodsTax	= 'tax';
	var policy			= $("select[name='reserve_policy'] option:selected").val();
	if	(!policy)	policy			= $("input[name='reserve_policy']").val();

	var windowOption	= 'width='+$(window).width()+'px,height=700px,toolbar=no,titlebar=no,scrollbars=yes,resizeable';

	var socialcp_input_type = eval('$("input[name=\'socialcp_input_type\']:checked").val()');
	var provider_seq = gl_provider_seq;
	if(!provider_seq){
		provider_seq			= $("input[name='provider_seq']").val();
	}

	if( $("input[name='frequentlytypeoptck']:checked").val() ) {
		var add_goods_seq = $("select[name='frequentlytypeopt']").find("option:selected").val();
		var goods_name = $("select[name='frequentlytypeopt']").find("option:selected").text();
		if( add_goods_seq<=0 ){
			alert("옵션정보를 가져올 상품을 선택해 주세요!");
			return false;
		}

		openDialogConfirm('정말로 ['+goods_name+'] 상품의 <br/>필수옵션 정보를 가져오시겠습니까?',400,200,function(){
			var url	= 'set_goods_options?provider_seq='+provider_seq+'&add_goods_seq='+add_goods_seq+'&goods_seq='+gl_goods_seq+'&tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type+'&package_yn='+gl_package_yn;
			optionTmpPopup	= window.open(url, 'OPTION_POP', windowOption);
		},function(){
			if	(tmp_seq)	var url	= 'set_goods_options?provider_seq='+provider_seq+'&tmp_seq='+tmp_seq+'&tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type+'&package_yn='+gl_package_yn;
			else			var url	= 'set_goods_options?provider_seq='+provider_seq+'&goods_seq='+gl_goods_seq+'&tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type+'&package_yn='+gl_package_yn;
			optionTmpPopup	= window.open(url, 'OPTION_POP', windowOption);
		});
	}else{
		if	(tmp_seq)	var url	= 'set_goods_options?provider_seq='+provider_seq+'&tmp_seq='+tmp_seq+'&tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type+'&package_yn='+gl_package_yn;
		else			var url	= 'set_goods_options?provider_seq='+provider_seq+'&goods_seq='+gl_goods_seq+'&tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type+'&package_yn='+gl_package_yn;
		optionTmpPopup	= window.open(url, 'OPTION_POP', windowOption);
	}
}


function openSettingSubOption(){
	var tmp_seq				= $("input[name='tmp_suboption_seq']").val();
	var goodsTax			= $("input[name='tax']:checked").val();
	var policy				= $("input[name='sub_reserve_policy']").val();
	var windowOption		= 'width='+$(window).width()+'px,height=700px,toolbar=no,titlebar=no,scrollbars=yes,resizeable';
	var socialcp_input_type	= eval('$("input[name=\'socialcp_input_type\']:checked").val()');
	var provider_seq		= gl_provider_seq;

	if (!goodsTax)
		goodsTax			= 'tax';

	if(!provider_seq)
		provider_seq		= $("input[name='provider_seq']").val();

	
	var package_yn_suboption = $("input[name='package_yn_suboption']").val();

	if( $("input[name='frequentlytypesuboptck']:checked").val() ) {
		var add_goods_seq = $("select[name='frequentlytypesubopt']").find("option:selected").val();
		var goods_name = $("select[name='frequentlytypesubopt']").find("option:selected").text();
		if( add_goods_seq<=0 ){
			alert("옵션정보를 가져올 상품을 선택해 주세요!");
			return false;
		}
		openDialogConfirm('정말로  ['+goods_name+'] 상품의 <br/>추가구성옵션 정보를 가져오시겠습니까?',400,200,function() {
			var url	= 'set_goods_suboptions?provider_seq='+provider_seq+'&add_goods_seq='+add_goods_seq+'&goods_seq='+gl_goods_seq+'&sub_tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type+"&package_yn="+package_yn_suboption;
			window.open(url, 'SUB_OPTION_POP', windowOption);
		},function(){
			if	(tmp_seq)	var url	= 'set_goods_suboptions?provider_seq='+provider_seq+'&tmp_seq='+tmp_seq+'&sub_tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type+"&package_yn="+package_yn_suboption;
			else			var url	= 'set_goods_suboptions?provider_seq='+provider_seq+'&goods_seq='+gl_goods_seq+'&sub_tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type+"&package_yn="+package_yn_suboption;
			window.open(url, 'SUB_OPTION_POP', windowOption);
		});
	}else{
		if	(tmp_seq)	var url	= 'set_goods_suboptions?provider_seq='+provider_seq+'&tmp_seq='+tmp_seq+'&sub_tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type+"&package_yn="+package_yn_suboption;
		else			var url	= 'set_goods_suboptions?provider_seq='+provider_seq+'&goods_seq='+gl_goods_seq+'&sub_tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type+"&package_yn="+package_yn_suboption;

		window.open(url, 'SUB_OPTION_POP', windowOption);
	}
}


//새창에서 추가구성옵션 가져오기시
function openSettingSubOptionnew(add_goods_seq){
	var tmp_seq				= $("input[name='tmp_suboption_seq']").val();
	var goodsTax		= $("input[name='tax']:checked").val();
	if	(!goodsTax)	goodsTax	= 'tax';
	var policy				= $("select[name='reserve_policy'] option:selected").val();
	if	(!policy)	policy	= $("input[name='reserve_policy']").val();
	var windowOption		= 'width=1010px,height=700px,toolbar=no,titlebar=no,scrollbars=yes,resizeable';

	var socialcp_input_type = eval('$("input[name=\'socialcp_input_type\']:checked").val()');

	var provider_seq = gl_provider_seq;
	if(!provider_seq){
		provider_seq			= $("input[name='provider_seq']").val();
	}

	var url	= 'set_goods_suboptions?provider_seq='+provider_seq+'&add_goods_seq='+add_goods_seq+'&goods_seq='+gl_goods_seq+'&tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type;
	window.open(url, 'SUB_OPTION_POP', windowOption);
}

function setSubOptionTmp(tmp_opno, tmp_frequently, subReservePolicy){
	var socialcp_input_type = eval('$("input[name=\'socialcp_input_type\']:checked").val()');

	var goodsTax		= $("input[name='tax']:checked").val();
	if	(!goodsTax)	goodsTax	= 'tax';
	var policy				= $("select[name='reserve_policy'] option:selected").val();
	if	(!policy)	policy	= $("input[name='reserve_policy']").val();

	var provider_seq = gl_provider_seq;
	if(!provider_seq){
		provider_seq			= $("input[name='provider_seq']").val();
	}
	$("iframe[name='actionFrame']").attr('src', 'set_goods_suboptions?provider_seq='+provider_seq+'&mode=view&tmp_seq='+tmp_opno+'&sub_tmp_policy='+subReservePolicy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type);
	$("input[name='tmp_suboption_seq']").val(tmp_opno);
	$("input[name='frequentlysub']").val(tmp_frequently);

	$("input[name='sub_reserve_policy']").val(subReservePolicy);
	if	(tmp_opno){
		set_option_select_layout();
	}
}

function viewSubOptionTmp(islimit){
	var tmp_seq				= $("input[name='tmp_suboption_seq']").val();
	var socialcp_input_type = eval('$("input[name=\'socialcp_input_type\']:checked").val()');
	var provider_seq = gl_provider_seq;
	if(!provider_seq){
		provider_seq		= $("input[name='provider_seq']").val();
	}
	var linkurl				= 'set_goods_suboptions?provider_seq='+provider_seq+'&mode=view&goods_seq='+gl_goods_seq+'&tmp_seq='+tmp_seq+'&goodsTax='+gl_tax+'&socialcp_input_type='+socialcp_input_type+'&islimit='+islimit;
	actionFrame.location.replace(linkurl);
}

function chgSuboptionReservePolicy(policy){
	var goods_seq	= gl_goods_seq;
	var goodsTax		= $("input[name='tax']:checked").val();
	if	(!goodsTax)	goodsTax	= 'tax';
	var tmp_seq		= $("input[name='tmp_suboption_seq']").val();

	var socialcp_input_type = $("input[name='socialcp_input_type']:checked").val();

	var provider_seq = gl_provider_seq;
	if(!provider_seq){
		provider_seq			= $("input[name='provider_seq']").val();
	}
	if			(tmp_seq){
		$("iframe[name='actionFrame']").attr('src', 'set_goods_suboptions?provider_seq='+provider_seq+'&mode=chgPolicy&tmp_seq='+tmp_seq+'&tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type);
	}else if	(goods_seq){
		$("iframe[name='actionFrame']").attr('src', 'set_goods_suboptions?provider_seq='+provider_seq+'&mode=chgPolicy&goods_seq='+gl_goods_seq+'&tmp_policy='+gl_reserve_policy+'&goodsTax='+gl_tax+'&socialcp_input_type='+socialcp_input_type);
	}
}

//브랜드창닫기
function brand_close(){
	$("#brandPopup").hide();
}

//지역창닫기
function location_close(){
	$("#locationPopup").hide();
}

//GOODS IMG
function default_img(){
	

	$('#goodsImageTable tbody tr.no_goods_image').remove();

	var idx = 0;
	var src = ($("input[name='viewGoodsImage[]']").eq(idx).val())?$("input[name='viewGoodsImage[]']").eq(idx).val() + '?' + new Date().getTime():"";

	if	($('#goodsImageTable tbody tr').length > 0){
		$('table#watermark_tb').show();
	}else{
		var noimgtd	= '<tr class="no_goods_image"><td class="its-td-align center" colspan="10">등록된 사진이 없습니다. 멀티일괄등록 버튼을 클릭하여 사진을 편리하게 등록하세요</td></tr>';
		$('#goodsImageTable tbody').append(noimgtd);
		$('table#watermark_tb').hide();
	}
	if(!src)return;

	var cutname = "대표컷";
	if(idx > 0){
		cutname = Number(idx) + 1;
		cutname += "번째";
	}
	var clone = $("#goodsImageMake").clone();
	clone.find("th img").attr("src",src);
	clone.find("td div").eq(0).html( cutname + " - 상품상세(기본)" );
	$("#goodsImagePriview").html(clone);
	$("#fileurl").html(src);
	$("input[name='idx']").val(idx);
	$("input[name='imgKind']").val('view');
	// 레이블 표시 :: 2016-04-28 lwh
	var label_view = $("form input[name='viewGoodsLabel[]']").eq(idx).val();
	if(label_view)	label_view = label_view;
	else			label_view = '-';
	$("#goodsImgLabel_view").html(label_view);
	$("#fileOptionAble").attr("data-target", idx);

	if($('#goodsImageTable tbody').find('tr').eq(idx).find('.fileColorTitle').html()){
		$("#filecolor").html($('#goodsImageTable tbody').find('tr').eq(idx).find('.fileColorTitle').clone());
	}else{
		$("#filecolor").html('<span class="gray">본 이미지에 매칭된 색상 없음</span>');
	}

	//이미지사이즈 체크를 위해 마지막에 위치함
	$("#viewImg").load(function () { //이미지가 로딩이 완료 된 후
		var sizetxt = $("#viewImg").width() + ' X ' + $("#viewImg").height();
		$("#filesize").html(sizetxt);
	});
	//이미지사이즈 체크를 위해 마지막에 위치함
}

function fileColorOptionUse(){
	if($("input:checkbox[id='fileOptionAble']").is(":checked")) {
		$("input[name='fileColorradio']").removeAttr("disabled");
		$("#fileOptionTxt").removeClass("gray");
		$("#fileOptionValue").removeClass("gray");
	} else {
		$("input[name='fileColorradio']").attr("disabled","disabled");
		$("#fileOptionTxt").addClass("gray");
		$("#fileOptionValue").addClass("gray");

		$idx = $("#fileOptionAble").attr("data-target");
		$("#goodsImageTable tbody tr").eq($idx).find(".fileColorTitle").html("");
		$("#goodsImageTable tbody tr").eq($idx).find(".fileColorTitle").removeAttr("style");
		$("#goodsImageTable tbody tr").eq($idx).find("input[name='goodsImageColor[]']").val("");
		$("#fileOptionValue").find("input[name='fileColorradio']").removeAttr("checked");
	}
}

function addFileColorOption($idx){
	var imgKind = $("input[name='imgKind']").val();
	$isColor = false;
	$fileOptionValueHtm = "";

	var colorStr = getColor();

	if (colorStr) {
		$isColor = true;
		$fileOptionValueHtm += colorStr;
	}

	if ($isColor) {
		if (imgKind == "view") {
			$("#fileOptionTitle").hide();
		} else {
			$("#fileOptionTitle").show();
		}

		$("#fileOptionAble").show();
		$("#fileOptionTxtAdd").show();
		$("#fileOptionTxt").show();
		$("#fileOptionValue").show();
		$("#fileNoOptionTxt").hide();
		$("#fileOptionValue").html($fileOptionValueHtm);
	} else {
		$("#fileOptionAble").hide();
		$("#fileNoOptionTxt").show();
		$("#fileOptionTxt").hide();
		$("#fileOptionValue").hide();
		$("#fileOptionValue").html("");
	}

	$ccolor = $("#goodsImageTable tbody tr").eq($idx).find("input[name='goodsImageColor[]']").val();
	try {
		if($ccolor) {
			if (imgKind == "view") {
				$("#fileOptionAble").attr("disabled", false);
				$("#fileOptionAble").attr("checked", "checked");
				$("#fileOptionTxt").removeClass("gray");
				$("#fileOptionValue").removeClass("gray");
				$("input[name='fileColorradio']").removeAttr("disabled");

				// 컬러가 소문자일 경우
				if ($("input[name='fileColorradio'][value='"+$ccolor.toLowerCase()+"']").length) {
					$("input[name='fileColorradio'][value='"+$ccolor.toLowerCase()+"']").attr("checked", "checked");
				}

				// 컬러가 대문자일 경우
				if ($("input[name='fileColorradio'][value='"+$ccolor.toUpperCase()+"']").length) {
					$("input[name='fileColorradio'][value='"+$ccolor.toUpperCase()+"']").attr("checked", "checked");
				}
			} else {
				$("#fileOptionAble").removeAttr("checked");
				$("#fileOptionAble").attr("disabled", true);
			}
		} else {
			if (imgKind == "view") {
				if($("input:checkbox[id='fileOptionAble']").is(":checked")) {
					$("input[name='fileColorradio']").removeAttr("disabled");
				} else {
					$("#fileOptionAble").removeAttr("disabled");
					$("input[name='fileColorradio']").attr("disabled","disabled");
				}
			} else {
				$("#fileOptionAble").removeAttr("checked");
				$("#fileOptionAble").attr("disabled", true);
			}
		}
	} catch (e) {
		if (imgKind == "view") {
			$("#fileOptionAble").removeAttr("disabled");
			$("input[name='fileColorradio']").removeAttr("disabled");
		} else {
			$("#fileOptionAble").removeAttr("checked");
			$("#fileOptionAble").attr("disabled", true);

		}
	}
}

function chgFileColor(ccolor){
	$idx = $("#fileOptionAble").attr("data-target");
	//console.debug($("#goodsImageTable tbody tr").eq($idx).find(".fileColorTitle"));
	$("#goodsImageTable tbody tr").eq($idx).find("input[name='goodsImageColor[]']").val(ccolor);
	$("#goodsImageTable tbody tr").eq($idx).find(".fileColorTitle").html("<span style='width:30px; height:30px; margin-top:2px; margin-left:2px; border:0px solid #e8e8e8; color:"+ccolor+";size:25px;'><font style='display:inline-block;width:18px; height:18px; border:1px solid #ccc; background-color:"+ccolor+"; cursor:pointer;' >■</font></span>");
	$("#goodsImageTable tbody tr").eq($idx).find(".fileColorTitle").css("color", ccolor);
}

function index_img(idx, key, name){
	var src = ($("input[name='"+key+"GoodsImage[]']").eq(idx).val())?$("input[name='"+key+"GoodsImage[]']").eq(idx).val() + '?' + new Date().getTime():"";
	if(!src)return;
	var cutname = "대표컷";
	if(idx > 0){
		cutname = Number(idx) + 1;
		cutname += "번째";
	}
	var clone = $("#goodsImageMake").clone();
	clone.find("th img").attr("src",src);
	clone.find("td div").eq(0).html( cutname + " - " + name );
	$("#goodsImagePriview").html(clone);
	$("#fileurl").html(src);
	$("input[name='idx']").val(idx);
	$("input[name='imgKind']").val(key);
	// 레이블 표시 :: 2016-04-28 lwh
	var label_view = $("form input[name='"+key+"GoodsLabel[]']").eq(idx).val();
	if(label_view)	label_view = label_view;
	else			label_view = '-';
	$("#goodsImgLabel_view").html(label_view);
	$("#fileOptionAble").attr("data-target", idx);
	if(key == 'view'){
		if($('#goodsImageTable tbody').find('tr').eq(idx).find('.fileColorTitle').html()){
			$("#filecolor").html($('#goodsImageTable tbody').find('tr').eq(idx).find('.fileColorTitle').clone());
		}else{
			$("#filecolor").html('<span class="gray">본 이미지에 매칭된 색상 없음</span>');
		}
	}

	//이미지사이즈 체크를 위해 마지막에 위치함
	$("#viewImg").load(function () { //이미지가 로딩이 완료 된 후
		var sizetxt = $("#viewImg").width() + ' X ' + $("#viewImg").height();
		$("#filesize").html(sizetxt);
	});
	//이미지사이즈 체크를 위해 마지막에 위치함

}


function relation_count_chk(){
	var width	= $("input[name='relation_count_w']").val();
	var height  = $("input[name='relation_count_h']").val();
	var sum		= parseInt(width) * parseInt(height);
	$("#relation_count_total").html(sum);
}

function optReplace(str){
	var tmp = "";
	tmp = str.replace(/\"/gi, "");
	return tmp;
}

function reserve_policy(fset){
	var policy	= $("select[name='reserve_policy'] option:selected").val();
	if	(!policy)	policy	= $("input[name='reserve_policy']").val();

	if(policy == 'shop'){
		if(gl_default_reserve_percent){
			$("input[name='reserveRate[]']").val(gl_default_reserve_percent);
			$("select[name='reserveUnit[]'] option[value='percent']").attr('selected',true);
			calulate_option_price();

			$("input[name='subReserveRate[]']").val(gl_default_reserve_percent);
			$("select[name='subReserveUnit[]'] option[value='percent']").attr('selected',true);
			calulate_subOption_price();
		}

		$("input[name='reserveRate[]'], select[name='reserveUnit[]'], input[name='reserve[]'], input[name='subReserveRate[]'], select[name='subReserveUnit[]'], input[name='subReserve[]']").attr('readonly',true).css('opacity',0.5);
		$("select[name='reserveUnit[]'] option[value!='percent'], select[name='subReserveUnit[]'] option[value!='percent']").attr('disabled',true);
		$(".policy_str").each(function(){$(this).text("통합정책")});
	}else{
		$("input[name='reserveRate[]'], select[name='reserveUnit[]'], input[name='reserve[]'], input[name='subReserveRate[]'], select[name='subReserveUnit[]'], input[name='subReserve[]']").removeAttr('readonly').css('opacity',1);
		$("select[name='reserveUnit[]'] option[value!='percent'], select[name='subReserveUnit[]'] option[value!='percent']").removeAttr('disabled');
		$(".policy_str").each(function(){$(this).text("개별정책")});
	}

	if	(!fset)		chgSuboptionReservePolicy(policy);
}

function able_save(){
	save_flag = true;
}


function chk_stockDesc2()
{
	var totstock = 0;
	$("#optionLayer input[name='stock[]']").each(function(){
		totstock += parseInt($(this).val());
	});
	if(!totstock) totstock = 0;

	var totUnusableStock = 0;
	$("#optionLayer input[name='unUsableStock[]']").each(function(){
		totUnusableStock += parseInt($(this).val());
	});
	if(!totUnusableStock) totUnusableStock = 0;

	var runout = gl_runout;
	var ableStockLimit = 0;

	if (gl_runout == 'ableStock')
		ableStockLimit = gl_ableStockLimit;

	if( $("input[name='runout_type']:checked").val() == 'goods' ){
		runout = $("input[name='runout']:checked").val();
		ableStockLimit = parseInt($("input[name='ableStockLimit']").val())+1;
	}

	if(totstock<1 && runout=='stock' ){
		return false;
	}

	if(totstock-totUnusableStock < ableStockLimit && runout=='ableStock'){
		return false;
	}

	return true;
}

function chk_stockDesc()
{
	var totstock = 0;
	$("#optionLayer input[name='stock[]']").each(function(){
		totstock += parseInt($(this).val());
	});

	if(!totstock) totstock = 0;

	var totUnusableStock = 0;
	$("#optionLayer input[name='unUsableStock[]']").each(function(){
		totUnusableStock += parseInt($(this).val());
	});
	if(!totUnusableStock) totUnusableStock = 0;

	var runout = gl_runout;
	var ableStockLimit = 0;
	if (runout == 'ableStock')
		ableStockLimit = gl_ableStockLimit;

	if( $("input[name='runout_type']:checked").val() == 'goods' ){
		runout = $("input[name='runout']:checked").val();
		ableStockLimit = parseInt($("input[name='ableStockLimit']").val())+1;
	}

	//alert("totstock:" + totstock + "/runout : " + runout+ "/ableStockLimit : " + ableStockLimit );

	if($("input[name='goodsStatus'][value='normal']").is(":checked")){

		if(totstock<1 && runout=='stock' ){
			var msg = "";
			msg += "현재 판매방식은 재고가 '1'개 이상일 때 '정상'상태로 판매가 가능합니다.<br /><br />";
			msg += "재고 수량을 입력하시거나 또는 상품의 상태를 '정상'이 아닌 것으로 변경한 후 다시 저장해 주세요.";
			openDialogAlert(msg,400,180);
			return false;
		}

		if(totstock-totUnusableStock < ableStockLimit && runout=='ableStock'){
			var msg = "";
			msg += "현재 판매방식은 가용재고가 '"+ableStockLimit+"'개 이상일 때 '정상'상태로 판매가 가능합니다.<br /><br />";
			msg += "재고 수량을 입력하시거나 또는 상품의 상태를 '정상'이 아닌 것으로 변경한 후 다시 저장해 주세요.";
			openDialogAlerttitle('재고 변화에 따른 상품판매 여부',msg,700,180);
			return false;
		}

	}

	return true;
}



function goods_info_del(){

	var seq = $("select[name='info_select']").val();

	if(seq == ""){
		alert("삭제할 공용정보를 선택하세요");
	}else{
		if(confirm("선택한 공용정보를 삭제하시겠습니까?\n삭제후에는 복구 할 수 없습니다.")){

			$.ajax({
				type: "get",
				url: "../goods_process/goods_info_del",
				data: "seq="+seq,
				success: function(result){
					var select_index = $("select[name='info_select'] option:selected").index();
					$('select[name="info_select"] option:eq('+select_index+')').remove();
					$('input[name="info_name"]').val("");

					alert("삭제되었습니다.");
				}
			});

		}
	}
}

// 복수구매할인 체크
function chk_multisale(){
	if	(!$("input[name='multiDiscountUse']").attr('checked') || $("input[name='multiDiscountEa']").val() > 1){
		return true;
	}else{
		openDialogAlert("복수구매 할인은 최소 2개 이상부터 가능합니다.",400,140);
		return false;
	}
}

/* 저장하기 */
function goods_save(saveType){
	var goodsSeq	= gl_goods_seq;
	if($(".provider_seq").val()==''){
		openDialogAlert("입점사를 선택해주세요.",400,150,function(){
			$("select[name='provider_seq_selector']").next(".ui-combobox").children("input").eq(0).focus();
		});
		return false;
	}

	// 저장 후 동작 설정
	$("input[name='save_type']").val(saveType);

	// 초기화
	$("#goods_permit_lay").html('');

	// 상품 승인시 알림창 추가 :: 2016-03-09 lwh
	var old_status	= '{=goods.provider_status}';
	var now_status	= $("input[name='provider_status']:checked").val();
	var permit_diff = '';
	var otp_html	= '';
	if(old_status == '0' && now_status == '1'){
		/* PC, 모바일 상품 설명 대량 업로드 되는 부분 방지를 위해 disable 처리 */
		if (goodsSeq) {
			$("#goodscontents").attr('disabled',true);
			$("#mobile_contents").attr('disabled',true);
			$("#commonContents").attr('disabled',true);
		}
		$.ajax({
			type: "post",
			url: "../goods/goods_opt_permit",
			data: "goods_seq={=goods.goods_seq}&data="+$("#goodsRegist").serialize(),
			success: function(html){
				/* PC, 모바일 상품 설명 대량 업로드 되는 부분 방지를 위해 disable 해제 */
				if (goodsSeq) {
					$("#goodscontents").attr('disabled',false);
					$("#mobile_contents").attr('disabled',false);
					$("#commonContents").attr('disabled',true);
				}
				$("#goods_permit_lay").append(html);
				openDialog("상품 승인 확인", "goods_permit_lay", {"width":"900","height":"620","show" : "fade","hide" : "fade"});
			}
		});
	}else{
		confirm_first_goods(gl_first_goods_date,gl_basic_currency,gl_basic_currency_hangul,gl_basic_currency_nation,'','goods_save_submit();');
	}
}

/* 폼전송 */
function goods_save_submit(){
	var goodsSeq	= gl_goods_seq;
	if(chk_stockDesc()){
		loadingStart();
		/* 다량옵션오류방지를 위하여 인코딩된 옵션폼값을 인코딩 : disable 처리 */
		encodeFormValue("#optionLayer,#suboptionLayer");

		/* PC, 모바일 상품 설명 대량 업로드 되는 부분 방지를 위해 disable 처리 */
		if (goodsSeq) {
			$("#goodscontents").attr('disabled',true);
			$("#mobile_contents").attr('disabled',true);
			$("#commonContents").attr('disabled',true);
		}

		/* 폼 전송 */
		submitEditorForm(document.goodsRegist);

		/* 다량옵션오류방지를 위하여 인코딩된 옵션폼값을 인코딩 : disable 해제 */
		encodeFormValueOff("#optionLayer,#suboptionLayer");

		/* PC, 모바일 상품 설명 대량 업로드 되는 부분 방지를 위해 disable 해제 */
		if (goodsSeq) {
			$("#goodscontents").attr('disabled',false);
			$("#mobile_contents").attr('disabled',false);
			$("#commonContents").attr('disabled',true);
		}
	}
}


/* 워터마크 적용 */
function watermark()
{
	var target_image = new Array();
	// largeGoodsImage[] viewGoodsImage[] list1GoodsImage[] list2GoodsImage[]
	$("input[name='largeGoodsImage[]'],input[name='viewGoodsImage[]']").each(function(i){
		target_image[i] = $(this).val();
	});
	target_image = target_image.join("|");
	target_image = encodeURIComponent(target_image);

	$.ajax({
		type: "post",
		url: "../goods_process/watermark_goods",
		data: "goods_seq="+gl_goods_seq+"&target_image="+encodeURIComponent(target_image),
		success: function(result){
			if(result == 'OK'){
				openDialogAlert("워터마크가 적용되었습니다.",400,140);
				default_img();
			}
			if(result == 'ERR'){
				openDialogAlert("적용할 워터마크가 없습니다.<br/>상품리스트 > 우측 상단 [워터마크 설정]에서 설정 가능",400,140);
			}
			if(result == 'ERRGIF'){
				openDialogAlert("gif 이미지에 대한 워터마크 기능은 추후 지원 예정입니다.",400,140);
			}
		}

	});


}

function watermark_recovery()
{
	var target_image = new Array();
	// largeGoodsImage[] viewGoodsImage[] list1GoodsImage[] list2GoodsImage[]
	$("input[name='largeGoodsImage[]'],input[name='viewGoodsImage[]'],input[name='list1GoodsImage[]'],input[name='list2GoodsImage[]']").each(function(i){
		target_image[i] = $(this).val();
	});
	target_image = target_image.join("|");
	target_image = encodeURIComponent(target_image);
	$.ajax({
		type: "post",
		url: "../goods_process/watermark_recovery",
		data: "goods_seq=" + gl_goods_seq + "&target_image="+encodeURIComponent(target_image),
		success: function(result){
			if(result == 'OK'){
				openDialogAlert("워터마크가 제거되었습니다.",400,140);
				default_img();
			}
			if(result == 'ERR'){
				openDialogAlert("제거할 워터마크가 없습니다",400,140);
			}
		}
	});
	default_img();
}

function check_runout()
{

	var msg = '';
	var ableStockLimit = parseInt($("input[name='ableStockLimit'").val())+1;
	$("table.stock-qa-table tr").removeClass("red");

	if( $("input[name='runout_type']:checked").val()=='goods' ){
		$("input[name='runout']:checked").closest('tr').addClass("red");
		$("input[name='runout']:checked").closest('tr').next().addClass("red");
		$("#ableStockLimitMsg").html(ableStockLimit);

		msg = "<b style=\"vertical-align:top;\">[<span class='red'>개별</span>]</b>&nbsp;";
		if( $("input[name='runout']:checked").val()=='stock' ){
			msg += "재고 1개 이상 있을 때 판매함 → 재고가 1개 이상 있을 때 '정상'상태 선택 가능";
		}
		if( $("input[name='runout']:checked").val()=='ableStock' ){
			msg += "가용재고 "+ableStockLimit+"개 이상 있을 때 판매함 →  가용재고가 "+ableStockLimit+"개 이상 있을 때 '정상'상태 선택 가능";
		}
		if( $("input[name='runout']:checked").val()=='unlimited'){
			msg += "재고와 상관없이 판매함 → 재고수량과 상관없이 '정상'상태 선택 가능";
		}
		$("input[name='runout_policy']").val($("input[name='runout']:checked").val());
		$("input[name='able_stock_limit']").val($("input[name='ableStockLimit'").val());
	}else{
		$("table#shop_runout tr").next().addClass("red");
		msg = "<b style=\"vertical-align:top;\">[통합]</b>&nbsp;";

		switch (gl_runout) {
			case	'stock' :
				msg += "재고가 1개 이상 있을 때 판매함 → 재고가 1개 이상 있을 때 '정상'상태 선택 가능";
				break;
			
			case	'ableStock' :
				msg += "가용재고가 " + ableStockLimit + "개 이상 있을 때 판매함 → 가용재고가 " + ableStockLimit + "개 이상 있을 때 '정상'상태 선택 가능";
				break;
			
			case	'unlimited' :
				msg += "재고와 상관없이 판매함 → 재고수량과 상관없이 '정상'상태 선택 가능";
				break;
		}


		$("input[name='runout_policy']").val('');
		$("input[name='able_stock_limit']").val('');
	}
	
	if (gl_service_code == 'P_FREE')
		msg += "<br /><div class='desc' style='padding-top:10px;'>상품별 재고 변화에 따른 판매여부 세팅 기능은 업그레이드가 필요합니다. <img src='../images/common/btn_upgrade.gif' class='hand' onclick='serviceUpgrade();' align='absmiddle' /></div>";

	$("#runout_policy_msg").html(msg);

	setOptionStockSetText();

}

function check_runout_type()
{
	var runout_policy = '';
	var able_stock_limit = 0;

	$("table#goods_runout").attr('disabled',true);
	if( $("input[name='runout_type']:checked").val()=='goods' ){
		runout_policy = goodsObj.runout_policy;
		able_stock_limit = goodsObj.able_stock_limit;
		$("table#goods_runout").attr('disabled',false);
	}

	if( !runout_policy ){
		runout_policy = gl_runout;
		able_stock_limit = gl_ableStockLimit_org;
	}

	$("input[name='runout'][value='"+runout_policy+"']").attr("checked",true);
	$("input[name='ableStockLimit']").val(able_stock_limit);
}



//가격 디스플레이
function check_string_price(radioObj) {
	
	$('.string_use_radio').each(function() {

		if (!this.checked || (typeof radioObj == 'object' && radioObj.name != this.name))
			return;

		var selValue		= parseInt(this.value, 10);
		var name			= this.name;
		var target			= name.replace(/_use$/, '');

		$('input[name="' + target + '"').attr('disabled', true);
		$('input[name="' + target + '_color"').attr('disabled', true);
		$('input[name="' + target + '_link_url"').attr('disabled', true);
		$('select[name="' + target + '_link"').attr('disabled', true);
		$('select[name="' + target + '_link_target"').attr('disabled', true);

		if (this.value == 1) {
			$('input[name="' + target + '"').attr('disabled', false);
			$('input[name="' + target + '_color"').attr('disabled', false);
			$('select[name="' + target + '_link"').attr('disabled', false);
			$('select[name="' + target + '_link_target"').attr('disabled', false);

			if ($('select[name="' + target + '_link"').val() == 'direct')
				$('input[name="' + target + '_link_url"').attr('disabled', false);
		}
	})

	// 구매자별 판매가격 세팅별 문구 노출
	setting_guide_msg();
}


function apply_string_price() {
	var arr = new Array();
	arr[0] = 'string_price';
	arr[1] = 'member_string_price';
	arr[2] = 'allmember_string_price';
	arr[3] = 'string_button';
	arr[4] = 'member_string_button';
	arr[5] = 'allmember_string_button';

	for(var i=0;i<6;i++){
		var target_name = arr[i];
		var target_use = "div#frmStringPrice input[name='" + target_name+"_use']";
		var source_use = "table#tb_string_price input[name='" + target_name+"_use']:checked";
		var target = "div#frmStringPrice input[name='" + target_name+"']";
		var source = "table#tb_string_price input[name='" + target_name+"']";
		var target_color = "div#frmStringPrice input[name='" + target_name+"_color']";
		var source_color = "table#tb_string_price input[name='" + target_name+"_color']"
		var target_link = "div#frmStringPrice input[name='" + target_name+"_link']";
		var source_link = "table#tb_string_price select[name='" + target_name+"_link']";
		var target_link_url = "div#frmStringPrice input[name='" + target_name+"_link_url']";
		var source_link_url = "table#tb_string_price input[name='" + target_name+"_link_url']";
		var target_link_target = "div#frmStringPrice input[name='" + target_name+"_link_target']";
		var source_link_target = "table#tb_string_price select[name='" + target_name+"_link_target']";


		if( $(source_use).val() == '1' && !$(source).val() ){
			alert('가격대체문구를 입력해주세요!');
			$(source).focus();
			return false;
		}

		if($(source_use)) $(target_use).val($(source_use).val());
		if($(source)) $(target).val( $(source).val() );
		if($(source_color)) $(target_color).val( $(source_color).val() );
		if($(source_link)) $(target_link).val( $(source_link).val() );
		if($(source_link_url)) $(target_link_url).val( $(source_link_url).val() );
		if($(source_link_target)) $(target_link_target).val( $(source_link_target).val() );

		print_string_price();
		closeDialog('popStringPrice');
	}
}


function print_string_price() 
{
	var arr = new Array();
	arr[0] = 'string_price';
	arr[1] = 'member_string_price';
	arr[2] = 'allmember_string_price';
	arr[3] = 'string_button';
	arr[4] = 'member_string_button';
	arr[5] = 'allmember_string_button';

	for(var i=0;i<6;i++){
		var target_name		= arr[i];
		var target_use		= $("div#frmStringPrice input[name='" + target_name+"_use']").val();
		var target			= $("div#frmStringPrice input[name='" + target_name+"']").val();
		var target_color	= $("div#frmStringPrice input[name='" + target_name+"_color']").val();

		if(target_use == '0' || !target_use){

			if (i < 3) {
				$("#"+target_name+"_msg").html('판매가격 표기');
				$("#"+target_name+"_sale_msg").html('상품상태에 따라 구매 가능');
			} else {
				$("#"+target_name+"_msg").html('상품상태별 버튼');
			}

		}else{
			
			$("#"+target_name+"_msg").html('<span style="color: ' + target_color + '">' + target + '</span>');

			if (i < 3)
				$("#"+target_name+"_sale_msg").html('구매 불가');
		
		}
	}
}



// 구매자별 판매가격 세팅별 문구 노출 leewh 2015-01-29
function setting_guide_msg() {
	var obj_guide_msg = $("#setting_guide_msg");
	var string_use = $("table#tb_string_price input[name='string_price_use']:checked").val();
	var mem_use = $("table#tb_string_price input[name='member_string_price_use']:checked").val();
	var allmem_use = $("table#tb_string_price input[name='allmember_string_price_use']:checked").val();

	var msg1 = "모든 소비자(비회원,회원)가 구매 가능합니다.<br/>특이사항이 없습니다.";
	var msg2 = "비회원은 구매하지 못하며, 회원만 구매 가능합니다.";
	var msg3 = "비회원과 일반등급은 구매하지 못하며, 상위등급만 구매 가능합니다.";
	var dmsg1 = "비회원만 구매 가능하고 회원은 구매하지 못하는 비정상적인 상황입니다.<br/>다시 설정해 주세요.";
	var dmsg2 = "비회원과 일반등급만 구매 가능하고 상위등급은 구매하지 못하는 비정상적인 상황입니다.<br/>다시 설정해 주세요.";
	var dmsg3 = "비회원과 상위등급만 구매 가능하고 일반등급은 구매하지 못하는 비정상적인 상황입니다.<br/>다시 설정해주세요.";
	var dmsg4 = "일반등급만 구매 가능하고 비회원과 상위 등급은 구매하지 못하는 비정상적인 상황입니다.<br/>다시 설정해주세요.";
	var dmsg5 = "모든 소비자(비회원,회원)가 구매하지 못하는 비정상적인 상황입니다.<br/>다시 설정해 주세요.";

	if (obj_guide_msg.length) {
		obj_guide_msg.html("");
		$("#btn_apply_string").attr("disabled",false);
		obj_guide_msg.removeClass("red");

		if (string_use==0 && mem_use==0 && allmem_use==0) {
			obj_guide_msg.html(msg1);
		}

		if (string_use==1 && mem_use==0 && allmem_use==0) {
			obj_guide_msg.html(msg2);
		}

		if (string_use==1 && mem_use==1 && allmem_use==0) {
			obj_guide_msg.html(msg3);
		}

		if (string_use==0 && mem_use==1 && allmem_use==1) {
			obj_guide_msg.addClass("red");
			obj_guide_msg.html(dmsg1);
			$("#btn_apply_string").attr("disabled",true);
		}

		if (string_use==0 && mem_use==0 && allmem_use==1) {
			obj_guide_msg.addClass("red");
			obj_guide_msg.html(dmsg2);
			$("#btn_apply_string").attr("disabled",true);
		}

		if (string_use==0 && mem_use==1 && allmem_use==0) {
			obj_guide_msg.addClass("red");
			obj_guide_msg.html(dmsg3);
			$("#btn_apply_string").attr("disabled",true);
		}

		if (string_use==1 && mem_use==0 && allmem_use==1) {
			obj_guide_msg.addClass("red");
			obj_guide_msg.html(dmsg4);
			$("#btn_apply_string").attr("disabled",true);
		}

		if (string_use==1 && mem_use==1 && allmem_use==1) {
			obj_guide_msg.addClass("red");
			obj_guide_msg.html(dmsg5);
			$("#btn_apply_string").attr("disabled",true);
		}

		obj_guide_msg.show();
	}
}

function onByteCheck(obj){
	var str			= obj.value;
	var bytes		= encodeURI(str).split(/%..|./).length - 1;
	if(bytes > 255){
		obj.value	= substr_utf8_bytes(str, 0, 255);
		bytes		= encodeURI(obj.value).split(/%..|./).length - 1;
	}
	$(obj).siblings('.etcContent_size').html(bytes);
}

function substr_utf8_bytes(str, startInBytes, lengthInBytes) {
	var resultStr = '';
	var startInChars = 0;

	for (bytePos = 0; bytePos < startInBytes; startInChars++) {
		ch = str.charCodeAt(startInChars);
		bytePos += (ch < 128) ? 1 : encode_utf8(str[startInChars]).length;
	}

	end = startInChars + lengthInBytes - 1;

	for (n = startInChars; startInChars <= end; n++) {
		ch = str.charCodeAt(n);
		end -= (ch < 128) ? 1 : encode_utf8(str[n]).length;

		resultStr += str[n];
	}

    return resultStr;
}

function encode_utf8(s) {
	return unescape( encodeURIComponent( s ) );
}

function dialog_hscode()
{
	openDialog("안내) 수출입상품코드", "dialog_hscode", {"width":570,"height":200});
}

function international_shipping_info(){

	if( $("input[name='option_international_shipping_status']").val() == 'y'){
		$("div.international_shipping_info").show();
		$("td.view_option_international_shipping_status").each(function(){
			$(this).html("Y");
		});

	}else{
		$("div.international_shipping_info").hide();
		$("td.view_option_international_shipping_status").each(function(){
			$(this).html("N");
		});
	}
}

//기본옵션상품의 필수옵션 해외배송여부
function set_option_international_shipping_status(bobj){
	var select_obj = $(bobj);
	var selected_val = select_obj.find("option:selected").val();
	$("input[name='option_international_shipping_status']").val(selected_val);

	international_shipping_info();
}
// 필수옵션 변경 팝업에서 필수옵션 해외배송여부
function set_option_international_shipping_popup(selected_val){
	$("input[name='option_international_shipping_status']").val(selected_val);

	international_shipping_info();
}

function clip_copy() {
	var meintext = $("#realvideourl").val();//'{realvideourl}';

　 if (window.clipboardData) {
　 　 window.clipboardData.setData("Text", meintext);
　 } else if (window.netscape) {
　 　 netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
　 　 var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
　 　 if (!clip) return;
　 　 var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
　 　 if (!trans) return;
　 　 trans.addDataFlavor('text/unicode');
　 　 var str = new Object();
　 　 var len = new Object();
　 　 var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
　 　 var copytext=meintext;
　 　 str.data=copytext;
　 　 trans.setTransferData("text/unicode",str,copytext.length*2);
　 　 var clipid=Components.interfaces.nsIClipboard;
　 　 if (!clip) return false;
　 　 clip.setData(trans,null,clipid.kGlobalClipboard);
　 }

}

function check_goodsShippingPolicy(){
	var sel = $("select[name='shippingPolicy'] option:selected").val();
	var obj = $("input[name='goodsShippingPolicy']");
	obj.closest('td').attr('disabled',false);
	if( sel == 'shop'){
		obj.closest('td').attr('disabled',true);
	}

	$("input[name='goodsShippingPolicy']").closest("div").find("span").attr("disabled",true);
	$("input[name='goodsShippingPolicy']:checked").closest("div").find("span").attr("disabled",false);

}


function active_optionLayer(bobj,val,exist_val){
	
	$("#optionLayer").find("select[name='option_international_shipping_status_view']").attr('disabled', val);
	$("#optionLayer").find("select[name='reserve_policy']").attr('disabled', val);
	$("#optionLayer").find("select[name='reserveUnit[]']").attr('disabled', val);
	if( val ){
		$("#optionLayer").find("button.package_goods_make").closest("span").hide();
	}else{
		$("#optionLayer").find("button.package_goods_make").closest("span").show();
	}
	
	$("#optionLayer").find('tr.optionTr').find('input').each(function(){
		if($(this).attr('type') == 'text') $(this).attr('disabled', val);
	});
	if( val ){
		show_optionUse();
		bobj.closest("span").next().removeClass("hide");
		set_option_select_layout();
	}else{
		bobj.closest("span").next().addClass("hide");
		if(exist_val){
			if(confirm("필수옵션 사용을 해제 할 경우 기존에 작성한 내용은 사라집니다.\n다만, 필수옵션 만들기 클릭시 옵션명,값,가격등의 기초정보는 확인하실 수 있습니다.")){
				return;
			}
		}
	}
}

//마일리지 정책 변경
function chgReservePolicy(obj,tmp_seq){
	if	($(obj).val() == 'shop'){
		$("input[name='reserve_rate_all']").attr('disabled', true);
		setDisableSelectbox($("select[name='reserve_unit_all']"), true);
	}else{
		$("input[name='reserve_rate_all']").attr('disabled', false);
		setDisableSelectbox($("select[name='reserve_unit_all']"), false);
	}
	if(tmp_seq){
		optionFrame.location.href	= '../goods_process/save_tmpoption_cell?tmpSeq='+tmp_seq+'&target=tmp_policy_all&value='+$(obj).val();
	}
}

//selectbox disabled
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

function reg_select_package_count(){
	if( $("select[name='reg_package_count'] option:selected").val() ){
		var basic_package_count	= $("select[name='reg_package_count'] option:selected").val();
	}else{
		var basic_package_count	= $("input[name='reg_package_count']").val();
	}

	var td_len = $("table.reg_package_option_title_tbl tr td").length;
	var tr_obj = $("table.reg_package_option_title_tbl tr");
	var tr_opt_obj = $("table.reg_package_option_tbl tr");
	var num = 0;
	var package_goods_info = '';

	if(td_len <= basic_package_count){
		for(var i=td_len;i<basic_package_count;i++){
			num = i+1;
			tr_obj.append("<td>상품"+num+"</td>");
			package_goods_info = "<td class=\"pdl5\">";
			package_goods_info += "<div class=\"reg_package_goods_name"+num+"\">";
			package_goods_info += "<a href=\"/goods/view?no=\">";
			package_goods_info += "<span class=\"reg_package_goods_seq"+num+"\"></span>";
			package_goods_info += "<span class=\"reg_package_goods_name"+num+"\"></span>";
			package_goods_info += "</a>";
			package_goods_info += "</div>";
			package_goods_info += "<div class=\"reg_package_option"+num+"\"></div>";
			package_goods_info += "<div class=\"reg_package_unit_ea"+num+"\"> 주문당";
			package_goods_info += " <input type=\"text\" name=\"package_unit_ea"+num+"[]\" class=\"line onlynumber\" style=\"text-align:right\" size=\"2\" value=\"\"/>";
			package_goods_info += " 발송";
			package_goods_info += " <span class=\"helpicon\" title=\"해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량\"></span>";
			package_goods_info += "</div>";
			package_goods_info += "<div class=\"reg_package_option_seq"+num+"\"></div>";
			package_goods_info += "<input type=\"hidden\" name=\"reg_package_option_seq"+num+"[]\" value=\"\"/>";
			package_goods_info += "</td>";
			tr_opt_obj.append(package_goods_info);
		}
	}
	if(td_len > basic_package_count){
		for(var i=td_len;i>basic_package_count;i--){
			num = i-1;
			$("table.reg_package_option_title_tbl tr td").eq(num).remove();
			$("table.reg_package_option_tbl td").eq(num).remove();
		}
	}
	help_tooltip();
}

function package_goods_make()
{
	if( $("div#optionLayer table.info-table-style tr.optionTr").length == 0 ){
		alert("적용할 옵션을 먼저 생성해 주세요.");
		return false;
	}

	var goods_seq		= '';
	var tmp_seq		= '';
	var provider_seq		= '';
	tmp_seq			= $("input[name='tmp_option_seq']").val();
	provider_seq	= $("input[name='provider_seq']").val();	
	if( $("input[name='goodsSeq']").val() ) goods_seq = $("input[name='goodsSeq']").val();
	
	if( $("select[name='reg_package_count'] option:selected").val() ){
		var package_count	= $("select[name='reg_package_count'] option:selected").val();
	}else{
		var package_count	= $("input[name='reg_package_count']").val();
	}

	var data_url ="opt_type=opt&goods_seq="+goods_seq+"&tmp_seq="+tmp_seq+"&package=1";
	if(package_count){
		data_url += "&package_count="+package_count;
	}
	if(provider_seq){
		data_url += "&provider_seq="+provider_seq;
	}else{
		alert('입점사를 선택해주십시요.');
		return false;
	}
	
	// 상품등록페이지에서 직접 검색시
	if( $("input[name='goodsName']").length > 0 ){
		data_url += "&reg_type=1";
	}
	
	$.ajax({
		type: "get",
		url: "../goods/select_goods_options",
		data: data_url,
		async : false,
		success: function(result){
			$("#selectGoodsOptionsDialog").html(result);
		}
	});
	openDialog("상품 검색", "selectGoodsOptionsDialog", {"width":980,"height":800});
}

function check_allpackage(idx,obj){
	if( $(obj).attr("checked") ){
		$("input[name='check_package_option" + idx + "[]']").attr("checked",true);
	}else{
		$("input[name='check_package_option" + idx + "[]']").attr("checked",false);
	}
}

function package_select_goods(goods_seq)
{	
	$.ajax({
		type: "get",
		url: "../goods/select_goods_options_view",
		data: "goods_seq="+goods_seq,
		async : true,
		dataType : "html",
		success: function(result){
			$("#selectGoodsOptionsView").html(result);
		}
	});
}

function package_toggle_option_all(obj){
	var bObj = $(obj);
	var tblObj = $("table.option-select-table");
	tblObj.find("tr td input[type='checkbox']").each(function(){
		if( bObj.attr("checked") ){
			$(this).attr("checked",true);
		}else{
			$(this).attr("checked",false);
		}
	});
	package_toggle_option_color();
}

function package_toggle_option(bobj){
	var objtr = $(bobj).closest("tr");
	if( objtr.find("input[type='checkbox']").attr('checked') ){
		objtr.find("input[type='checkbox']").attr('checked',false);
	}else{
		// objtr.css("background-color","#EBF1DE");
		objtr.find("input[type='checkbox']").attr('checked',true);
	}

	package_toggle_option_color();
}

function package_toggle_option_color(){
	var tblObj = $("table.option-select-table");
	var option_seq		= '';
	var goods_name		= '';
	var goods_seq		= '';
	var combine_option	= '';
	var stock			= '';
	var rstock			= '';
	var badstock		= '';
	var safe_stock		= '';
	tblObj.find("tr td input[type='checkbox']").each(function(){
		if( $(this).attr("checked") ){
			$(this).closest("tr").css("background-color","#EBF1DE");
			option_seq		+= $(this).val() + '|';
			goods_name		+= $(this).attr("goods_name") + '|';
			goods_seq		+= $(this).attr("goods_seq") + '|';
			combine_option	+= $(this).attr("combine_option") + '|';
			stock			+= $(this).attr("stock") + '|';
			rstock			+= $(this).attr("rstock") + '|';
			badstock		+= $(this).attr("badstock") + '|';
			safe_stock		+= $(this).attr("safe_stock") + '|';
		}else{
			$(this).closest("tr").css("background-color","#FFFFFF");
		}
	});	
	var params = {
		'option_seq':option_seq,
		'goods_name':goods_name,
		'combine_option':combine_option,
		'goods_seq':goods_seq,
		'stock':stock,
		'rstock':rstock,
		'badstock':badstock,
		'safe_stock':safe_stock
	};
	package_select_option(params);
}

function package_select_option(obj){
	$("input[name='selected_option_seq']").val(obj.option_seq);
	$("input[name='selected_goods_name']").val(obj.goods_name);
	$("input[name='selected_options']").val(obj.combine_option);
	$("input[name='selected_goods_seq']").val(obj.goods_seq);
	$("input[name='selected_stock']").val(obj.stock);
	$("input[name='selected_rstock']").val(obj.rstock);
	$("input[name='selected_badstock']").val(obj.badstock);
	$("input[name='selected_safe_stock']").val(obj.safe_stock);
}

function del_package_selected(obj){
	var cellObj = $(obj).closest("td").next();
	cellObj.find("input.package_option_seq").val('');
	cellObj.find("span.package_goods_seq").html('');
	cellObj.find("span.package_goods_name").html('');
	cellObj.find("div.package_option_name").html('');
}

function apply_package_option(){
	var tmp_seq = $("input[name='selected_tmp_seq']").val();
	var option_seq =  $("input[name='selected_option_seq']").val().split("|");
	var goods_name = $("input[name='selected_goods_name']").val().split("|");
	var goods_seq = $("input[name='selected_goods_seq']").val().split("|");
	var option_vals = $("input[name='selected_options']").val().split("|");
	var stocks = $("input[name='selected_stock']").val().split("|");
	var badstocks = $("input[name='selected_badstock']").val().split("|");
	var safe_stocks = $("input[name='selected_safe_stock']").val().split("|");
	var rstocks = $("input[name='selected_rstock']").val().split("|");

	if(!option_seq){
		alert("검색한 상품의 옵션을 선택해주세요.");
		return false;
	}
	
	var check_var = false;
	var num = 0;
	var pos = 0;

	$("input.check_package_option").each(function(idx){
		if( $(this).attr("checked") ){
			pos = num % (option_seq.length-1);
			if(option_seq[pos]){
				$(this).closest("td").find("input[name='package_option_seq"+$(this).val()+"[]']").val(option_seq[pos]);
				$(this).closest("td").find("span.package_goods_name").html(goods_name[pos]);
				$(this).closest("td").find("span.package_goods_seq").html('['+goods_seq[pos]+']');
				$(this).closest("td").find("div.package_option_name").html(option_vals[pos]);
				var stockobj = $(this).closest("td").find("input[name='package_option_stock"+$(this).val()+"[]']");
				stockobj.val(stocks[pos]);
				stockobj.attr('rstock',rstocks[pos]);
				stockobj.attr('badstock',badstocks[pos]);
				stockobj.attr('safe_stock',safe_stocks[pos]);
			}
			$(this).attr("checked",false);
			check_var = true;
			num++;
		}
	});

	if( !check_var ){
		alert("적용 대상상품을 선택하세요.");
		return false;
	}

	$("input.check_allpackage").attr("checked",false);
}


function goods_package_suboption_apply(){
	var check_var = true;
	$("input[name='package_option_seq1[]']").each(function(idx){
		if( !$(this).val() ) check_var = false;
	});
	if(!check_var){
		alert('상품1을 연결해주세요.');
		return false;
	}

	$("input[name='package_option_seq1[]']").each(function(idx){
		var obj = $(this);
		var package_option_seq	= obj.val();
		var goods_name	= $("span.package_goods_name").eq(idx).html();
		var package_option	= $("div.package_option_name").eq(idx).html();
		var goods_seq	= $("span.package_goods_seq").eq(idx).html();
		
		$("span.tmp_package_goods_seq1").eq(idx).html(goods_seq);
		$("span.tmp_package_goods_name1").eq(idx).html(goods_name);
		$("div.tmp_package_option_name1").eq(idx).html(package_option);
		$("input[name='tmp_package_unit_ea1[]'").eq(idx).val(1);
		$("input[name='tmp_package_option_seq1[]'").eq(idx).val(package_option_seq);
		$("input[name='tmp_package_option1[]'").eq(idx).val(package_option);
		$("input[name='tmp_package_goods_name1[]'").eq(idx).val(goods_name);
	});
	package_unit_ea_display_sub();
	closeDialog('selectGoodsOptionsDialog');
}

function goods_package_apply(){
	var check_var = true;
	$("input[name='package_option_seq1[]']").each(function(idx){
		if( !$(this).val() ) check_var = false;
	});
	if(!check_var){
		alert('상품1을 연결해주세요.');
		return false;
	}
	$("input[name='package_option_seq1[]']").each(function(idx){
		apply_package_option_seq($(this),idx);
	});
	$("input[name='package_option_seq2[]']").each(function(idx){
		apply_package_option_seq($(this),idx);
	});
	$("input[name='package_option_seq3[]']").each(function(idx){
		apply_package_option_seq($(this),idx);
	});
	$("input[name='package_option_seq4[]']").each(function(idx){
		apply_package_option_seq($(this),idx);
	});
	$("input[name='package_option_seq5[]']").each(function(idx){
		apply_package_option_seq($(this),idx);
	});

	set_stock_package();
	package_unit_ea_display();

	closeDialog('selectGoodsOptionsDialog');
}

function apply_package_option_seq(obj,idx){
	var cobj = obj.closest("td");
	var num = cobj.find("input.check_package_option").val();
	var package_option_seq	= obj.val();
	var goods_name	= cobj.find("span.package_goods_name"+num).html();
	var package_option	= cobj.find("div.package_option_name"+num).html();
	var goods_seq_str	= cobj.find("span.package_goods_seq"+num).html();
	var stockobj = cobj.find("input.package_option_stock");
	var stock = parseInt(stockobj.val());
	var badstock = parseInt(stockobj.attr('badstock'));
	var rstock = parseInt(stockobj.attr('rstock'));
	var safe_stock = parseInt(stockobj.attr('safe_stock'));
	if(isNaN(stock)) stock = 0;
	if(isNaN(badstock)) badstock = 0;
	if(isNaN(rstock)) rstock = 0;
	if(isNaN(safe_stock)) safe_stock = 0;

	var goods_seq = goods_seq_str.replace("[", "");
	goods_seq = goods_seq.replace("]", "");

	$("span.reg_package_goods_seq" + num).eq(idx).html(goods_seq_str);
	$("span.reg_package_goods_name" + num).eq(idx).html(goods_name);
	$("span.reg_package_goods_name" + num).eq(idx).parent().attr('href','/goods/view?no='+goods_seq);
	$("div.reg_package_option" + num).eq(idx).html(package_option);
	$("input[name='package_unit_ea" + num + "[]']").eq(idx).val(1);
	$("input[name='reg_package_option_seq" + num+"[]']").eq(idx).val(package_option_seq);
	$("input[name='reg_package_option_stock" + num+"[]']").eq(idx).val(stock);
	$("div.reg_package_option_seq"+num).eq(idx).html(stock+' ('+badstock+')'+' / '+rstock+' / '+safe_stock);
}

function package_suboption_make()
{
	var tmp_seq = $("input[name='tmp_seq']").val();
	var provider_seq	= $("input[name='provider_seq']").val();
	
	var data_url = "tmp_seq="+tmp_seq;
	if(provider_seq){
		data_url += "&provider_seq="+provider_seq;
	}else{
		alert('입점사를 선택해주십시요.');
		return false;
	}
	$.ajax({
		type: "get",
		url: "../goods/select_goods_options",
		data: data_url,
		async : false,
		success: function(result){
			$("#selectGoodsOptionsDialog").html(result);
		}
	});
	
	openDialog("상품 검색", "selectGoodsOptionsDialog", {"width":980,"height":800});
}

function select_create_package_count(bobj){
	var obj = $('bobj');
	$("input[name='reg_package_count']").val(obj.find("option:selected").val());
}


function goods_option_btn(goods_seq,obj,mode){
	var btnObj = $(obj).find("button");
	if( mode > 1 ){
		package_stock_on(goods_seq, obj);
	}else{
		scm_warehouse_on(goods_seq, obj);
	}
}

function set_stock_package(){
	$("input[name='reg_package_option_stock1[]']").each(function(idx){
		var option_stock = $(this).val();
		var unit_ea = $("input[name='package_unit_ea1[]']").eq(idx).val();
		var cstock = option_stock / unit_ea;
		var stock = cstock;
		for(var i=2;i<6;i++){
			option_stock = $("input[name='reg_package_option_stock"+i+"[]']").eq(idx).val();
			unit_ea = $("input[name='package_unit_ea"+i+"[]']").eq(idx).val();
			cstock = option_stock / unit_ea;
			if(stock > cstock){
				stock = cstock;
			}
		}
		$("input[name='stock[]']").val(parseInt(stock));
	});
}

function package_error_msg(code){
	
	switch(code) {
		case	'10':
			msg		= '연결되었던 실제 상품이 없어짐';
			break;

		case	'20':
			msg		= '연결되었던 실제 상품의 옵션이 없어짐';
			break;
		
		case	'30':
			msg		= '연결되었던 실제 상품의 옵션명이 달라짐';
			break;
	}


	msg += ' <img src="../skin/default/images/common/btn_help.gif" style="vertical-align:top;" class="hand" onclick="package_error_alert(\''+code+'\')" />';
		
	msg += '<img src="../skin/default/images/common/btn_help.gif" style="vertical-align:top;" class="hand" onclick="package_error_alert(\''+code+'\')" />';
	document.write(msg);
}

function package_error_alert(code){
	var detail			= '';
	switch(code) {
		case	'10':
			detail		= '연결되었던 실제 상품이 없어졌습니다.<br/>실제 상품을 다시 연결해 주십시오';
			break;

		case	'20':
			detail		= '연결되었던 실제 상품의 옵션이 없어졌습니다.<br/>실제 상품을 다시 연결해 주십시오.';
			break;
		
		case	'30':
			detail		= '연결되었던 실제 상품의 옵션명이 달라졌습니다.<br/>실제 상품을 다시 연결해 주십시오.';
			break;
	}

	$('#packageErrorDialog').html(detail);

	openDialog("연결 문제 알림", "packageErrorDialog", {"width":"370","height":"150","show" : "fade","hide" : "fade"});
}

function package_error_check(mode){
	openDialog("연결 상태 확인", "packageErrorDialog", {"width":"570","height":"300","show" : "fade"});
	var htmlTag = "<table>";
	htmlTag += "<tr>";
	htmlTag += "	<td>";
	htmlTag += "	실제 상품이 삭제되어서";
	htmlTag += "	</td>";
	htmlTag += "	<td>";
	htmlTag += "	→";
	htmlTag += "	</td>";
	htmlTag += "	<td>";
	htmlTag += "	연결이 안되고 있는 실제 상품을 확인 할 수 있습니다.";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	htmlTag += "<tr>";
	htmlTag += "	<td>";
	htmlTag += "	실제 상품의 옵션이 새롭게 변경되어";
	htmlTag += "	</td>";
	htmlTag += "	<td>";
	htmlTag += "	→";
	htmlTag += "	</td>";
	htmlTag += "	<td>";
	htmlTag += "	연결이 안되고 있는 실제 상품을 확인 할 수 있습니다.";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	htmlTag += "<tr>";
	htmlTag += "	<td>";
	htmlTag += "	실제 상품의 옵션명이 변경되어";
	htmlTag += "	</td>";
	htmlTag += "	<td>";
	htmlTag += "	→";
	htmlTag += "	</td>";
	htmlTag += "	<td>";
	htmlTag += "	연결이 안되고 있는 실제 상품을 확인 할 수 있습니다.";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	htmlTag += "<tr>";
	htmlTag += "	<td colspan='3' style='height:30px;'>";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	htmlTag += "<tr>";
	htmlTag += "	<td colspan='3' class='center'>";
	htmlTag += "	연결에 문제가 있는 해당 옵션은 판매가 제한됩니다.";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	htmlTag += "<tr>";
	htmlTag += "	<td colspan='3' class='center'>";
	htmlTag += "	실제 상품을 다시 연결하여 문제를 해결해 주십시오.";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	htmlTag += "<tr>";
	htmlTag += "	<td colspan='3' style='height:30px;'>";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	htmlTag += "<tr>";
	htmlTag += "	<td colspan='3' class='center'>";
	htmlTag += "	<span class='btn large cyanblue'><button type='button' onclick=\"package_error_check_proc('"+mode+"');\">연결 상태 확인</button></span>";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	htmlTag += "</table>";
	$('#packageErrorDialog').html(htmlTag);
}

function package_error_result_option(suc){
	closeDialog("packageErrorDialog");
	openDialog("연결 상태 확인", "packageErrorDialog", {"width":"570","height":"200","show" : "fade"});
	var htmlTag = "<table width ='98%'>";
	htmlTag += "<tr>";
	htmlTag += "	<td>";
	htmlTag += "	연결 상태 확인 결과";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	if(suc){
		htmlTag += "<tr>";
		htmlTag += "	<td>";
		htmlTag += "	필수옵션에 ∞ 연결된 실제 상품 : 연결이 정상적 입니다.";
		htmlTag += "	</td>";
		htmlTag += "</tr>";
	}else{
		htmlTag += "<tr>";
		htmlTag += "	<td>";
		htmlTag += "	필수옵션에 ∞ 연결된 실제 상품 : 연결이 올바르지 않은 필수옵션이 존재합니다.";
		htmlTag += "	</td>";
		htmlTag += "</tr>";
		htmlTag += "<tr>";
		htmlTag += "	<td>";
		htmlTag += "	해당 필수옵션에 실제 상품을 다시 연결하세요.";
		htmlTag += "	</td>";
		htmlTag += "</tr>";
	}
	htmlTag += "<tr>";
	htmlTag += "	<td colspan='3' style='height:20px;'>";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	htmlTag += "<tr>";
	htmlTag += "	<td colspan='3' class='center'>";
	htmlTag += "	<span class='btn large cyanblue'><button type='button' onclick=\"closeDialog('packageErrorDialog');location.reload();\">확인</button></span>";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	htmlTag += "</table>";
	$('#packageErrorDialog').html(htmlTag);
}

function package_error_result_suboption(suc){
	closeDialog("packageErrorDialog");
	openDialog("연결 상태 확인", "packageErrorDialog", {"width":"570","height":"200","show" : "fade"});
	var htmlTag = "<table width='98%'>";
	htmlTag += "<tr>";
	htmlTag += "	<td>";
	htmlTag += "	연결 상태 확인 결과";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	if(suc){
		htmlTag += "<tr>";
		htmlTag += "	<td>";
		htmlTag += "	추가구성상품에 ∞ 연결된 실제 상품 : 연결이 정상적 입니다.";
		htmlTag += "	</td>";
		htmlTag += "</tr>";
	}else{
		htmlTag += "<tr>";
		htmlTag += "	<td>";
		htmlTag += "	추가구성상품에 ∞ 연결된 실제 상품 : 연결이 올바르지 않은 추가구성상품이 존재합니다.";
		htmlTag += "	</td>";
		htmlTag += "</tr>";
		htmlTag += "<tr>";
		htmlTag += "	<td>";
		htmlTag += "	해당 추가구성상품에 실제 상품을 다시 연결하세요.";
		htmlTag += "	</td>";
		htmlTag += "</tr>";
	}
	htmlTag += "<tr>";
	htmlTag += "	<td colspan='3' style='height:20px;'>";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	htmlTag += "<tr>";
	htmlTag += "	<td colspan='3' class='center'>";
	htmlTag += "	<span class='btn large cyanblue'><button type='button' onclick=\"closeDialog('packageErrorDialog');location.reload();\">확인</button></span>";
	htmlTag += "	</td>";
	htmlTag += "</tr>";
	htmlTag += "</table>";
	
	$('#packageErrorDialog').html(htmlTag);
}

function package_error_check_proc(mode){
	var saveinfo	= {'goods_seq':gl_goods_seq,'mode':mode};
	
	var processMsg	= '<table width="98%" height="100%"><tr><td align="center" valign="middle">';
	processMsg		+= '실행 중입니다...<br/>잠시만 기다려 주십시오.'
	processMsg		+= '</td></tr></table>';
	$('#packageErrorDialog').html(processMsg);

	$.ajax({
		'type': "GET",
		'url': "../goods/package_check",
		'data': saveinfo,
		'dataType' : 'json',
		'success': function(result){
			if( result ){
				var suc = false;
			}else{
				var suc = true;
			}
			if(mode == 'option'){
				package_error_result_option(suc);
			}else if(mode == 'suboption'){
				package_error_result_suboption(suc);
			}
		}
	});
}

function package_unit_ea_display(){
	for(var i=0;i<=5;i++){
		var goods_name_obj = $("span.reg_package_goods_name"+i);
		var unit_ea_obj = goods_name_obj.closest("td").find("div.reg_package_unit_ea"+i);
		if( ! goods_name_obj.html() ){
			unit_ea_obj.hide();
		}else{
			unit_ea_obj.show();
		}
	}
}

function package_unit_ea_display_sub(){
	var goods_name_obj = $("div.tmp_package_option_name1");
	var unit_ea_obj = goods_name_obj.next();
	if( ! goods_name_obj.html() ){
		unit_ea_obj.hide();
	}else{
		unit_ea_obj.show();
	}
}


function open_criteria_condition(displayResultId,auto_condition_use_id,criteria,kind){
	openDialog("조건 선택", "#displayGoodsSelectPopup", {"width":"99%","show" : "fade","hide" : "fade"});
	if(criteria.indexOf('∀') > -1 || criteria == '' || !criteria){
		set_goods_list_auto("displayGoodsSelect",displayResultId,criteria,auto_condition_use_id,kind);
	}else{
		set_goods_list("displayGoodsSelect",displayResultId,'criteria',criteria);
	}
};

function open_goods_search(displayResultId){
	openDialog("상품 검색", "#displayGoodsSelectPopup", {"width":"99%","show" : "fade","hide" : "fade"});
	set_goods_list("displayGoodsSelect",displayResultId,'goods','');
}


function set_goods_list(displayId,inputGoods,type,criteria){
	$.ajax({
		type: "get",
		url: "../goods/select",
		data: "innerMode=2&type="+type+"&containerHeight=230&page=1&inputGoods="+inputGoods+"&displayId="+displayId+"&displayKind=relation&criteria="+encodeURIComponent(criteria)+'&prefix=relation_&relation_goods_seq={goods.goods_seq}',
		success: function(result){
			$("div#"+displayId).html(result).show();
			$("#"+displayId+"Container").show();
		}
	});
}

function set_goods_list_auto(displayId,inputGoods,criteria,auto_condition_use_id,kind){
	$.ajax({
		type: "get",
		url: "../goods/select_auto",
		data: "inputGoods="+inputGoods+"&displayKind="+kind+"&displayId="+displayId+"&criteria="+encodeURIComponent(criteria)+"&auto_condition_use_id="+auto_condition_use_id+"&provider_seq={goods.provider_seq}",
		success: function(result){
			$("div#"+displayId).html(result);
			$("#"+displayId+"Container").show();
		}
	});
}

// 외부 티켓 등록
function setCouponSerial(tcnt, couponSerialStr){
	$("#coupon_result").show();

	if (gl_goods_seq) {
		var tcnt	= parseInt(tcnt) + parseInt($(".tcnt").text());
		$("input[name='coupon_serial_upload']").val($("input[name='coupon_serial_upload']").val()+','+couponSerialStr);
		$(".tcnt").text(comma(tcnt));
	} else {
		$("input[name='coupon_serial_upload']").val(couponSerialStr);
		$(".tcnt").text(comma(tcnt));
	}

	closeDialog("coupon_serial_upload_lay");
}


function get_default_commission_rate(){
	var default_charge = num_float($("input[name='default_charge']").val());
	if($("input[name='firstBrand']").length){
		if($("input[name='firstBrand']").attr('charge')){
			default_charge = num($("input[name='firstBrand']").attr('charge'));
		}
	}
	
	if (gl_default_charge !== false)
		default_charge	= gl_default_charge;

	return default_charge;
}

// 에디터 팝업 :: 2016-05-04 lwh
function view_editor_pop(contants,viewType){
	var goodsSeq	= gl_goods_seq;
	var descTxt		= "";
	var goods_contents_top = $("#" + contants).offset().top - 100;
	if(goodsSeq) descTxt = "<span class='desc'>- 저장을 누르면 실시간으로 저장됩니다.</span>";

	$("input[name='goodsSeq']").val(goodsSeq);
	$("input[name='contents_type']").val(contants);

	var newContant = '<textarea name="view_textarea" id="view_textarea" class="daumeditor" style="width:100%;height:500px;" contentHeight="500px">'+$("#"+contants).val()+'</textarea>';
	$(".view_contents_area").html(newContant);
	DaumEditorLoader.init("#view_textarea");

	$("#view_common_info").hide();
	var title = 'PC/태블릿용 상품 설명';
	if(contants == 'mobile_contents') title = '모바일용 상품 설명';
	else if(contants == 'commonContents') {
		title = '공용 정보';
		$("#view_common_info").show();
	}

	if(viewType == 'save')	$(".contents_saveBtn").show();
	else					$(".contents_saveBtn").hide();

	$("body").css("overflow","hidden");
	openDialog(title+" "+descTxt, "view_editor_div", {"width":"98.5%","draggable":false,position: {my:'center',at:'top',of:window},"close":function(){$("body").css("overflow",""); window.scrollTo(0,goods_contents_top); }});
}

// 에디터 내용 저장 :: 2016-05-04 lwh
function view_editor_save(){
	var goodsSeq	= gl_goods_seq;
	var editTxt		= Editor.getContent();
	var cont_type	= $("input[name='contents_type']").val();

	var info_name	= $('input[name="info_name"]').val();
	var info_select = $("form[name='tmpContentsFrm'] select[name='info_select'] option:selected").val();

	// 공용정보 검사 :: 2016-05-09 lwh
	if (editTxt=="<p><br></p>") editTxt = "";
	if (cont_type=='commonContents' && editTxt!="" && !info_name) {
		alert('공용정보명을 입력해 주세요.');
		return false;
	}else if (cont_type=='goodscontents' || cont_type=='mobile_contents'){
		$("input[name='mobile_contents_copy']").val('N');
		$("#mobile_contents_view").show();
		$("#mobile_contents_desc").hide();
	}

	// 실시간 저장
	if(goodsSeq){
		submitEditorForm(document.tmpContentsFrm);
		$("#tmpContentsFrm").submit();
	}else{
		$("input[name='info_name_view']").val(info_name);
		$("input[name='info_select_view']").val(info_select);

		// 현재 내용 COPY
		$("#"+cont_type+"_view").html(editTxt);
		$("#"+cont_type).val(editTxt);
		alert('임시 저장되었습니다.');
	}

	closeDialog('view_editor_div');
}

// 모바일 상품 설명 복사 :: 2016-05-11 lwh
function contents_copy(){
	var goodsSeq		= gl_goods_seq;
	var goodscontents	= $("#goodscontents").val();

	if(!goodscontents){
		alert('PC/테블릿용 상품 설명을 먼저 등록해주세요.');
		return;
	}

	// 실시간 저장
	if(goodsSeq){
		$.ajax({
			type: "post",
			url: "../goods_process/edit_mobile_copy",
			data: "goodsSeq="+goodsSeq,
			success: function(result){
				$("#mobile_contents_view").html(result);
				$("#mobile_contents").val(result);
				$(".mobile_view_desc").html('PC용 상품설명과 동일 <a href="javascript:view_editor_pop(\'mobile_contents\',\'view\');"><span class="highlight-link hand">미리보기></span></a>');
				alert('(현재 등록된 PC용 상품설명으로) 모바일용 설명에 저장되었습니다.');
			}
		});
	}else{
		$(".mobile_view_desc").html('상품 저장 시 PC용 상품설명과 동일하게 등록됩니다. <a href="javascript:view_editor_pop(\'mobile_contents\',\'view\');"><span class="highlight-link hand">미리보기></span></a>');
		$("#mobile_contents_view").html(goodscontents);
		$("#mobile_contents").val(goodscontents);
		alert('(현재 등록된 PC용 상품설명으로) 모바일용 설명에 임시 저장되었습니다.');
	}

	$("input[name='mobile_contents_copy']").val('Y');
	$("#mobile_contents_view").hide();
	$("#mobile_contents_desc").show();
}

// mapView 기능 추가 lwh 2014-03-31
function show_mapView(){
	if (socialcpuse_flag)
		$(".mapView").attr('disabled',false);
}

function hide_mapView(){
	if (socialcpuse_flag)
		$(".mapView").attr('disabled',true);
}


function hscodeSet() {


	var hscodeValues	= $('form[name=hscode_form]:not(.disabled)').serialize();
	$.post('../goods_process/hscode_save',hscodeValues, function() {

	});
}

function hscodeApply() {
	$('#hscode_list').html('');
	$('#hscode_info').html('');
	$('#hscode_type_name').html('');
	
	if ( $(".nations:checked").length > 0) {
		
		var nationList	= $('<ul/>');
		var hscodeType	= $.trim($('input[name="hscode_type"').val());
		var hscodeUnit	= $.trim($('input[name="hscode_unit"').val());
		

		if (hscodeType.length < 1 || hscodeUnit.length < 1) {
			alert('"류","호"값은 필수 입니다.');
			return false;
		}
		
		var hscodeTypeName	= '<a href="https://unipass.customs.go.kr/clip/index.do" target="_hscode">' + hscodeTypeList[hscodeType] + '</a>';
		$('#hscode_type_name').html(hscodeTypeName);
		
		var hscodeTypeText	= (hscodeType > 9) ? hscodeType : '0' + hscodeType;
		var hscodeUnitText	= (hscodeUnit > 9) ? hscodeUnit : '0' + hscodeUnit;
		var hscode			= hscodeTypeText.concat(hscodeUnitText);

		$(".nations:checked").each(function() {
			nationKey		= this.value;
			nationName		= $('input[name="nation_name[' + nationKey + ']"').val();
			nationFlag		= $('input[name="nation_flag[' + nationKey + ']"').val();

			hscodeNum		= $.trim($('input[name="hscode_num[' + nationKey + ']"').val());
			hscodeTax		= $.trim($('input[name="hscode_tax[' + nationKey + ']"').val()); 
			nowHsCode		= (hscodeNum.length > 1) ? hscode + '.' + hscodeNum : hscode;
			$('input[name="hscode"]').val(nowHsCode);

			appendLi		= "<li>";
			appendLi		+= '<div class="hs_nation"><img src="' + nationFlag + '" style="vertical-align:middle"/> ' + nationName + '</div>';
			appendLi		+= '<div class="hs_info">' + nowHsCode + ' (' + hscodeTax + '%)</div>';
			appendLi		+= "</li>";
			nationList.append(appendLi);

			/*
			appendForm		=  '<input type="hidden" name="nation_key[]" value="' + nationKey + '"/>';
			appendForm		+=  '<input type="hidden" name="hscode_num[' + nationKey + ']" value="' + hscodeNum + '"/>';
			appendForm		+=  '<input type="hidden" name="hscode_tax[' + nationKey + ']" value="' + hscodeTax + '"/>';
			$('#hscode_info').append(appendForm);
			*/
		});

		$('#hscode_list').append(nationList);
	} else {
		$('#hscode_list').html('설정된 HS CODE가 없습니다.');
	}
}


function payMethodChange(type) {
	
	if (type == 'goods') {
		var nowSetId	= '#pay_method_goods';
		var preSetId	= '#pay_method_basic';
		$('#pay_method_goods > span').addClass('red');
		$('input[name="possible_pay[]"].able').attr('disabled', false);
	} else {
		var nowSetId	= '#pay_method_basic';
		var preSetId	= '#pay_method_goods';
		$('#pay_method_goods > span').removeClass('red');
		$('input[name="possible_pay[]"].able').attr('disabled', true);
	}


	$(preSetId + ',' + preSetId + '_set .its-td').addClass('gray');
	$(nowSetId + ',' + nowSetId + '_set .its-td').removeClass('gray');
	
}

function displayTermsChange(mode) {
	if (mode == 'AUTO') {
		$('.display-auto').removeClass('gray');
		$('.display-form').attr('disabled', false)
	} else {
		$('.display-auto').addClass('gray');
		$('.display-form').attr('disabled', true)
	}
}

function displayTermsSet() {

	var displayTerms		= $('input[name="display_terms_set"]:checked').val();
	var displayTermsBegin	= $('#display_terms_begin').val();
	var displayTermsEnd		= $('#display_terms_end').val();
	
	var todayObj			= new Date();
	var endObj				= new Date(displayTermsEnd);
	var beginObj			= new Date(displayTermsBegin);

	$('#display_terms_auto').hide();
	$('#display_terms_menual').hide();

	if (displayTerms == 'AUTO') {
		
		if (displayTermsEnd.length < 10 || endObj.getTime() <= todayObj.getTime()) {
			alert('종료일을 정확확히 입력하세요.');
			return;
		}

		if (displayTermsBegin.length < 10 || beginObj.getTime() >= endObj.getTime()) {
			alert('시작일을 정확확히 입력하세요.');
			return;
		}

		$('#display_terms_auto').show();
	} else {
		$('#display_terms_menual').show();
	}

	var displayTermsType	= $('#display_terms_type').val();
	var displayTermsText	= $.trim($('#display_terms_text').val());
	var displayTermsColor	= $('#display_terms_color').val();
	var displayTermsBefore	= $('#display_terms_before').val();
	var displayTermsAfter	= $('#display_terms_after').val();


	
	$('input[name="display_terms"]').val(displayTerms);
	$('input[name="display_terms_begin"]').val(displayTermsBegin);
	$('input[name="display_terms_end"]').val(displayTermsEnd);
	$('input[name="display_terms_type"]').val(displayTermsType);
	$('input[name="display_terms_text"]').val(displayTermsText);
	$('input[name="display_terms_color"]').val(displayTermsColor);
	$('input[name="display_terms_before"]').val(displayTermsBefore);
	$('input[name="display_terms_after"]').val(displayTermsAfter);

	
	var beforeStatus	= (displayTermsBefore == 'DISPLAY') ? '노출' : '미노출';
	var afterStatus		= (displayTermsAfter == 'DISPLAY') ? '노출' : '미노출';
	var termsTypeText	= (displayTermsType == 'LAYAWAY') ? '예약상품' : '상품';

	$('.display_before').hide();
	$('.display_ing').hide();
	$('.display_terms_text').html('');

	if (beginObj.getTime() < todayObj.getTime())
		$('.display_ing').show();
	else
		$('.display_before').show();

	$('.display_terms_begin_before').html($('#display_terms_begin_before').html());
	$('.display_terms_end_after').html($('#display_terms_end_after').html() + '부터는');
	$('.display_terms_before').html(beforeStatus + '→');
	$('.display_terms_begin').html(displayTermsBegin + ' ~ ');
	$('.display_terms_end').html(displayTermsEnd);
	$('.display_terms_type').html(termsTypeText);
	$('.display_terms_after').html(afterStatus);

	if (displayTermsText)
		var showText	= '(<span style="color:' + displayTermsColor + '">' + displayTermsText + '</span>)으로 노출';
	else
		var showText	= '으로 노출';
	
	$('.display_terms_text').html(showText);

	closeDialog('display_terms_lay');
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

	goodscetegory			= $("input:radio[name='firstCategory']:checked").val();
	goodsbrand				= $("input:radio[name='firstBrand']:checked").val();
	goodslocation			= $("input:radio[name='firstLocation']:checked").val();

	$("select[name='selectEtcTitle[]']").each(function(){

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
			$("#goodsCode").val(result);
			$("#makeGoodsCodLay").dialog('close');
		}
	});
}

function setSubOptionProcess() {
	var individual_refund			= ($('#individual_refund_set_1').is(':checked')) ? 1 : 0;
	var individual_refund_inherit	= ($('#individual_refund_inherit_set').is(':checked')) ? 1: 0;
	var individual_export			= ($('#individual_export_set_1').is(':checked')) ? 1 : 0;
	var individual_return			= ($('#individual_return_set_1').is(':checked')) ? 1 : 0;


	$('#individual_refund_1').hide();
	$('#individual_refund_inherit_show').hide();
	$('#individual_refund_0').hide();
	$('#individual_export_1').hide();
	$('#individual_export_0').hide();
	$('#individual_return_1').hide();
	$('#individual_return_0').hide();

	$('#individual_refund_' + individual_refund).show();
	$('#individual_export_' + individual_export).show();
	$('#individual_return_' + individual_return).show();

	if (individual_refund_inherit == 1)
		$('#individual_refund_inherit_show').show();
	

	$('#individual_refund').val(individual_refund);
	$('#individual_refund_inherit').val(individual_refund_inherit);
	$('#individual_export').val(individual_export);
	$('#individual_return').val(individual_return);

	closeDialog('subOptionProcessSet');
}

function changeDiscountSet(nowIndex) {

	var totalSetCnt	= $('input[name="discount_under_qty[]"]').length;
	
	for (i = nowIndex; i < totalSetCnt; i++) {
		lastUnder	= parseInt($('input[name="discount_under_qty[]"]').eq(i - 1).val(),10);
		nowUnder	= parseInt($('input[name="discount_under_qty[]"]').eq(i).val(),10);

		$('input[name="discount_over_qty[]"]').eq(i).val(lastUnder);

		if (nowUnder <= lastUnder) {
			$('input[name="discount_under_qty[]"]').eq(i).val(lastUnder + 1);
		}
	}

	$('input[name="discount_under_qty[]"]:last').trigger('change');
}

//message
function helperMessage(mode, addText) {
	var title		= '';
	var message		= '';
	$('#helper_message').html('');

	switch (mode) {

		case	'keyword' :
			title	= '검색어 - 자동';
			message	= '상품명, 상품번호, 상품코드로 검색어를 자동 생성합니다.';
			break;

		case	'tax' :
			title	= '과세/비과세 주의사항';
			message	= '비과세 상품(도는 과세상품)을 판매하는 쇼핑몰은 <a href="../setting/sale" target ="_set"><span style="color:blue">매출증빙</span></a>';
			message	+= '설정을 해야만 매출증빙자료(세금계산서, 현금영수증, 신용카드매출전표)에 물품가격과 부가세가 정상적으로 표기됩니다.';
			break;

		case	'cancel' :
			title	= '청약철회불가';
			message	= '청약철회불가 상품은 결제를 하지 않은 주문접수 상태에서 주문 무효를 할 수 있습니다.<br/><br/>';
			message	+= '그러나 결제확인 이후로는 구매 대상자가 MY페이지에서 결제취소 또는 반품/교환 신청르 할 수 없습니다.';
			break;

		case	'adult' :
			title	= '성인상품';
			message	= '성인상품은 성인인증수단(휴대폰 또는 아이핀)으로 인증 후 상품을 보고 구매할 수 있습니다.<br/>';
			message	+= '성인인증수단은 <a href="../setting/member" target ="_set"><span style="color:blue">본인인증</span></a>에서 설정 가능힙니다.<br/><br/>'
			message	+= '관리자 로그인 상태에서 성인인증 없이 상품페이지를 볼 수 있습니다.';
			break;

		case	'oversea' :
			title	= '해외 구매 대항';
			message	= '해외에서 구매 대항한 상품을 대한민국으로 배송 시 대한민국 관세청 통관신고를 위해';
			message	+= ' 주문 시 구매 대상자(구매대행요청자)의 개인통관고유부로를 수집합니다.';
			break;

		case	'SACO' :
			title	= '수수료 정산방식';
			message	= '상품 정산금액 = 판매가격 X (100 - 수수료)%<br/><br/>';
			message	+= '※ 최종 정산금액은 할인공제, 환불공제, 배송비에 따라 결정됩니다.';
			break;
		
		case	'SUPPLY' :
			title	= '공급가 정산방식';
			message	= '- 상품 정산금액(수수료 율) = 정가 X 수수료 율<br/>';
			message	+= '- 상품 정산금액(직접입력) = 직접 등록한 금액<br/><br/>';
			message	+= '※ 최종 정산금액은 할인공제, 환불공제, 배송비에 따라 결정됩니다.';
			break;
		
		case	'goodsCode' :
			title	= '상품코드';
			message	= '등록된 상품코드는 바코드로 출력 가능합니다.<br/>';
			message	+= '출력 가능한 바코드는 Code39, Code128-A, Code128-B, Code128-C, ISBN입니다.<br/>';
			message	+= '상품코드는 기본코드 + 옵션코드를 조합하여 생성할 수 있습니다.<br/>';
			break;
		
		case	'stock' :
			title	= '재고';
			message	= '재고 = 정상 재고 + 불량 재고';
			break;

		case	'safeStock' :
			title	= '안전재고';
			message	= '재고 : ' + addText + ' → 해당 상품의 안전재고입니다.';
			break;

		case	'safeStockForScm' :
			title	= '안전재고';
			message	= '재고 : ' + addText + ' → 해당 상품의 안전재고입니다.<br/>';
			message	+= '해당 상품의 재고수량이 안전재고 이하로 떨어질 경우 자동 발주가 생성됩니다.';
			break;

		case	'price' :
			title	= '정가, 판매가';
			message	= '정가는 소비자가격이며,<br/>';
			message	+= '판매가는 할인가격입니다.';
			break;

		case	'optionInfomation' :
			title	= '설명';
			message	= '해당 필수옵션에 대한 안내 문구입니다.<br/>';
			message	+= '옵션 셜명이 있는 경우 소비자에게 해당 옵션을 선택하면, 소비자에게 옵션설명이 보여지게 됩니다.';
			break;
		
		case	'solubleStock' :
			title	= '가용재고';
			message	= '가용재고 = 재고 - 출고예약량 - 불량재고<br/>';
			message	+= '출고예약량 = 결제확인 수량 + 상품준비 수량 + 출고준비 수량<br/>';
			message	+= '※ 가용재고는 판매 가능한 수량입니다.     <a href="/admin/setting/order" target="_blank" style="color:#FF8224;">설정></a><br/>';
			message	+= '※ 출고예약량은 배송이 예정되어 있는 수량입니다.';
			break;

		case	'replaceCode' :
			title	= '치환 코드';
			message	= '<p>※ 아래 치환코드를 조합하여 입력 가능</p><br/>';
			message	+= '<p>① 상품명 : <span class="red">&#123;product_name&#125;</span></p>';
			message	+= '<p>② 대표카테고리 : <span class="red">&#123;product_category&#125;</span></p>';
			message	+= '<p>③ 대표브랜드 : <span class="red">&#123;product_brand&#125;</span></p>';
			message	+= '<p>④ 상품검색태그 : <span class="red">&#123;product_tag&#125;</span></p>';
			break;
	
		default :
			return;
	}

	$('#helperMessage').html(message);
	openDialog(title, "helperMessageShow", {"width":"450","show" : "fade","hide" : "fade"});
}


function helperMessageLayer(mode) {
	switch(mode) {
		case	'getOptions' :
			openDialog('옵션정보 가져오기', "getOptionsMessage",{"width":"400"});
			break;
		
		case	'optionPrice' :
			openDialog('옵션가격', "optionPriceMessage",{"width":"400"});
			break;

		case	'specialOption' :
			openDialog('특수옵션', "specialOptionMessage",{"width":"800"});
			break;

		case	'viewOption' :
			openDialog('옵션 설명', "viewOptInfomation", {"width":"600","show" : "fade","hide" : "fade"});
			break;
		
		default :
			return;
	}
}


function setOptionStockSetText() {
	
	if ($('input[name="runout_type"]:checked').val() == 'goods')
		var nowRunoutPolicy	= $('input[name="runout"]:checked').val();
	else
		var nowRunoutPolicy	= gl_runout;


	switch(nowRunoutPolicy) {
		case	'stock' :
			var optionStockSetText	= '재고가 있으면<br>판매';
			break;

		case	'ableStock' :
			var optionStockSetText	= '가용재고가 있으면<br>판매';
			break;

		case	'unlimited' :
			var optionStockSetText	= '재고와 상관없이<br>판매';
			break;
	}

	$('.optionStockSetText').html(optionStockSetText);
	return optionStockSetText;
}