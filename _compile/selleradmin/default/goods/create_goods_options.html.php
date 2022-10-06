<?php /* Template_ 2.2.6 2022/05/17 12:29:08 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/create_goods_options.html 000059924 */ 
$TPL_opts_loop_1=empty($TPL_VAR["opts_loop"])||!is_array($TPL_VAR["opts_loop"])?0:count($TPL_VAR["opts_loop"]);
$TPL_goodsoptionloop_1=empty($TPL_VAR["goodsoptionloop"])||!is_array($TPL_VAR["goodsoptionloop"])?0:count($TPL_VAR["goodsoptionloop"]);?>
<script type="text/javascript">
$(document).ready(function(){
	$("#btn_goods_special_list").bind("click",function(){
		openDialog("특수 정보 활용 안내", "special_newlist", {"width":"760","height":"816","show" : "fade","hide" : "fade"});
	});

	$("#btn_goods_option_list").bind("click",function(){
		openDialog("옵션정보 가져오기", "option_newlist", {"width":"800","height":"880","show" : "fade","hide" : "fade"});
	});

	/* 필수옵션 만들기 폼 */
	$("#addOptionMake").bind("click",function(){
		var objTr = $(this).parents("tr");
		var objTb = $(this).parents("tbody");
		$( objTr.find("input[name='optionMakesdayinput[]']") ).datepicker( "destroy" );
		$( objTr.find("input[name='optionMakefdayinput[]']") ).datepicker( "destroy" );

		var clone = objTr.clone();
		clone.find("span.btnplusminus").removeClass("btn-plus");
		clone.find("span.btnplusminus").addClass("btn-minus");
		clone.find("span.btnplusminus").click(function(){$(this).parents('tr').remove();});
		clone.find("input[name='optionMakesdayinput[]']").attr("id","addoptionMakesdayinput"+(objTb.find("tr").index()+1));
		clone.find("input[name='optionMakefdayinput[]']").attr("id","addoptionMakefdayinput"+(objTb.find("tr").index()+1));
		clone.find(".goodsOptionBtn").click(function(){goodsOptionBtn(this);});
		setDatepicker(clone.find("input[name='optionMakesdayinput[]']"));
		setDatepicker(clone.find("input[name='optionMakefdayinput[]']"));


		//폼초기화(직접입력)형식
		clone.find("select[name='optionMakeId[]'] option[value='direct']").attr("selected",true);
		clone.find(".goodsoptionlay").hide();
		clone.find(".etcContents").show();
		goodsoptiondirectdefault(clone);
		if( objTb.find("tr").index() < 4) objTb.append(clone);
		setDefaultText();
	});

	//옵션 생성하기 버튼
	$("#gdoptioncodemakebtn").bind("click", function() {
		var optName = new Array();
		var optionType = new Array();
		var optValue = new Array();
		var tmp;

		$("#optionMakePopup table tbody tr").each(function(idx){
			optionType[idx] = $(this).find("select[name='optionMakeId[]'] option:selected").val();

			tmp = $(this).find("input[name='optionMakeName[]']").val();
			if( tmp == $(this).find("input[name='optionMakeName[]']").attr("title") ){
				optName = new Array();
				return false;
			}else{
				optName[idx] = tmp.split(',');
			}

			tmp = $(this).find("input[name='optionMakeValue[]']").val();
			if( tmp == $(this).find("input[name='optionMakeValue[]']").attr("title") ){
				optValue = new Array();
				return false;
			}else{
				optValue[idx] = tmp.split(',');
			}

		});

		if(optName.length<1){
			openDialogAlert("옵션명을 정확히 입력해주세요.",400,140,function(){
				$("#optionMakePopup input[name='optionMakeName[]']").filter(function(){
					return $(this).val().length==0;
				}).eq(0).focus();
			});
			return false;
		}

		if(optValue.length<1){
			openDialogAlert("옵션명을 정확히 입력해주세요.",400,140,function(){
				$("#optionMakePopup input[name='optionMakeName[]']").filter(function(){
					return $(this).val().length==0;
				}).eq(0).focus();
			});
			return false;
		}

		// 옵션명 공백 체크
		for(var i=0;i<optName.length;i++){
			for(var j=0;j<optName[i].length;j++){
				if(optName[i][j].length==0) {
					openDialogAlert("옵션명을 입력해주세요.",400,140,function(){
						$("#optionMakePopup input[name='optionMakeName[]']").filter(function(){
							return $(this).val().length==0;
						}).eq(0).focus();
					});
					return false;
				}
			}
		}

		// 옵션값 공백 체크
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

		$("#optionMakeForm").submit();
	});

	//필수옵션 > 직접입력 >> 특수정보 선택시
	$("select[name='optionMakespecial[]']").live("change",function() {
		goodsoptionspecialform($(this), $(this).parents("tr"));
	});

	//자동기간 예시 미리보기
	$("div#optionMakePopup span.optionMakenewdayautolayrealdateBtn").live("click",function() {
		socialcpdayautoreview( $(this).parents("div.optionMakenewdayauto") );
	});

});


// 더블쿼터 제거
function optReplace(str){
	var tmp = "";
	tmp = str.replace(/\"/gi, "");
	return tmp;
}

// 기본 가격 정보 추가
function setDefaultPrice(tobj){
	var tmp = optReplace($(tobj).val());
	if	(tmp){
		$(tobj).val(tmp);

		var obj = $(tobj).parents("tr").find("input[name='optionMakePrice[]']");
		var sArr = $(tobj).val().split(',');
		var tArr = obj.val().split(',');
		var tArrNew = new Array();
		for(var i = 0;i<sArr.length;i++){
			if(tArr[i]){
				tArrNew[i] = tArr[i];
			}else{
				tArrNew[i] = 0;
			}
		}
		obj.val(tArrNew.join(','));
	}
}

// 옵션정보 적용하기
function setGoodsOption(obj){
	var codeform_seq = $(obj).attr("codeform_seq");
	var label_type = $(obj).attr("label_type");
	var label_newtype = $(obj).attr("label_newtype");
	var label_id = $(obj).attr("label_id");
	var layer_id = $(obj).attr("layer_id");

	var goodsoptioncodeval = new Array();
	var goodsoptioncodetitle = new Array();

	var goodsoptioncodecolor = new Array();
	var goodsoptioncodezipcode = new Array();
	var goodsoptioncodeaddress_type = new Array();
	var goodsoptioncodeaddress = new Array();
	var goodsoptioncodeaddress_street = new Array();
	var goodsoptioncodeaddressdetail = new Array();
	var goodsoptioncodeaddress_commission = new Array();

	var biztel = new Array();
	var codedate = new Array();
	var sdayinput = new Array();
	var fdayinput = new Array();
	var dayautotype = new Array();
	var sdayauto = new Array();
	var fdayauto = new Array();
	var dayautoday = new Array();

	$(obj).parents("tr").parent().find("input[name='goodsoption[]']").each(function(){
		if ( $(this).is(':checked') == true  ) {
			goodsoptioncodeval.push($(this).val());//code
			goodsoptioncodetitle.push($(this).attr("label_value"));//label_value title

			goodsoptioncodecolor.push($(this).attr("label_color"));
			goodsoptioncodezipcode.push($(this).attr("label_zipcode"));
			goodsoptioncodeaddress_type.push($(this).attr("label_address_type"));
			goodsoptioncodeaddress.push($(this).attr("label_address"));
			goodsoptioncodeaddress_street.push($(this).attr("label_address_street"));
			goodsoptioncodeaddressdetail.push($(this).attr("label_addressdetail"));
			goodsoptioncodeaddress_commission.push($(this).attr("label_address_commission"));

			biztel.push($(this).attr("label_biztel"));
			codedate.push($(this).attr("label_codedate"));
			sdayinput.push($(this).attr("label_sdayinput"));
			fdayinput.push($(this).attr("label_fdayinput"));
			dayautotype.push($(this).attr("label_dayauto_type"));
			sdayauto.push($(this).attr("label_sdayauto"));
			fdayauto.push($(this).attr("label_fdayauto"));
			dayautoday.push($(this).attr("label_dayauto_day"));
		}
	});

	var goodsoptioncodevaljoin = goodsoptioncodeval.join(',');
	var goodsoptioncodetitlejoin = goodsoptioncodetitle.join(',');

	var goodsoptioncodecolorjoin = goodsoptioncodecolor;
	var goodsoptioncodezipcodejoin = goodsoptioncodezipcode;
	var goodsoptioncodeaddress_typejoin = goodsoptioncodeaddress_type;
	var goodsoptioncodeaddressjoin = goodsoptioncodeaddress;
	var goodsoptioncodeaddress_streetjoin = goodsoptioncodeaddress_street;
	var goodsoptioncodeaddressdetailjoin = goodsoptioncodeaddressdetail;
	var goodsoptioncodeaddress_commission_join = goodsoptioncodeaddress_commission;

	var bizteljoin = biztel;
	var codedatejoin = codedate;
	var sdayinputjoin = sdayinput;
	var fdayinputjoin = fdayinput;
	var dayautotypejoin = dayautotype;
	var sdayautojoin = sdayauto;
	var fdayautojoin = fdayauto;
	var dayautodayjoin = dayautoday;
	var gdoptidx = $(obj).parents("table").find(".gdoptidx").val();

	$("div#optionMakePopup input[name='optionMakeType[]']").eq(gdoptidx).val(label_type);
	$("div#optionMakePopup input[name='optionMakeCode[]']").eq(gdoptidx).val(goodsoptioncodevaljoin);
	$("div#optionMakePopup input[name='optionMakenewtype[]']").eq(gdoptidx).val(label_newtype);
	$("div#optionMakePopup input[name='optionMakecolor[]']").eq(gdoptidx).val(goodsoptioncodecolorjoin);
	$("div#optionMakePopup input[name='optionMakezipcode[]']").eq(gdoptidx).val(goodsoptioncodezipcodejoin);
	$("div#optionMakePopup input[name='optionMakeaddress_type[]']").eq(gdoptidx).val(goodsoptioncodeaddress_typejoin);
	$("div#optionMakePopup input[name='optionMakeaddress[]']").eq(gdoptidx).val(goodsoptioncodeaddressjoin);
	$("div#optionMakePopup input[name='optionMakeaddress_street[]']").eq(gdoptidx).val(goodsoptioncodeaddress_streetjoin);
	$("div#optionMakePopup input[name='optionMakeaddressdetail[]']").eq(gdoptidx).val(goodsoptioncodeaddressdetailjoin);
	$("div#optionMakePopup input[name='optionMakebiztel[]']").eq(gdoptidx).val(bizteljoin);
	$("div#optionMakePopup input[name='optionMakeaddress_commission[]']").eq(gdoptidx).val(goodsoptioncodeaddress_commission_join);

	$("div#optionMakePopup input[name='optionMakecodedate[]']").eq(gdoptidx).val(codedatejoin);
	$("div#optionMakePopup input[name='optionMakesdayinput[]']").eq(gdoptidx).val(sdayinputjoin);
	$("div#optionMakePopup input[name='optionMakefdayinput[]']").eq(gdoptidx).val(fdayinputjoin);
	$("div#optionMakePopup select[name='optionMakedayauto_type[]'] option[value='"+dayautotypejoin+"']").eq(gdoptidx).attr("selected",true);
	$("div#optionMakePopup input[name='optionMakesdayauto[]']").eq(gdoptidx).val(sdayautojoin);
	$("div#optionMakePopup input[name='optionMakefdayauto[]']").eq(gdoptidx).val(fdayautojoin);
	$("div#optionMakePopup select[name='optionMakedayauto_day[]'] option[value='"+dayautodayjoin+"']").eq(gdoptidx).attr("selected",true);

	$("div#optionMakePopup input[name='optionMakeValue[]']").eq(gdoptidx).val(goodsoptioncodetitlejoin);
	//$("div#optionMakePopup input[name='optionMakeValue[]']").eq(gdoptidx).attr("readonly",true);
	$("div#optionMakePopup input[name='optionMakeValue[]']").eq(gdoptidx).show();

	var obj = $("div#optionMakePopup input[name='optionMakePrice[]']").eq(gdoptidx);
	var sArr = goodsoptioncodetitlejoin.split(',');
	var tArr = new Array();
	for(var i = 0;i<sArr.length;i++){
		tArr.push(0);
	}
	obj.val(tArr.join(','));
	if( label_newtype == 'dayauto' ){
		socialcpdayautoreview( $("div#optionMakePopup div.optionMakenewdayauto").eq(gdoptidx) );
	}
	closeDialog(layer_id);
}


// 옵션정보 가져오기
function goodsOptionBtn(obj){
	var layerid = $(obj).attr("layerid");
	var label_type = $(obj).attr("label_type");
	var label_newtype = $(obj).attr("label_newtype");
	var codeform_seq = $(obj).attr("codeform_seq");
	var label_title = $(obj).attr("label_title");
	var idx = $(obj).parents("tr").index();
	$("#"+layerid).find(".gdoptidx").val(idx);

	//설정 변경시 및 최초값설정
	var goodsoptioncodetitlejoin = $("div#optionMakePopup input[name='optionMakeCode[]']").eq(idx).val();
	if( goodsoptioncodetitlejoin ) {//수정시 설정값셋팅
		var goodsoptioncodetitlear = goodsoptioncodetitlejoin.split(',');
	}

	$("#"+layerid).find("input[name='goodsoption[]']").each(function(){
		if( goodsoptioncodetitlejoin ) {
			$(obj).attr("checked",false);
			for (var i=0;i<goodsoptioncodetitlear.length;i++){
				if(!goodsoptioncodetitlear[i]) continue;
				if( goodsoptioncodetitlear[i] == $(obj).val() ) {
					$(obj).attr("checked",true);
					break;
				}
			}
		}else if( !goodsoptioncodetitlejoin && $(obj).attr("default") == 'checked' ) {
			$(obj).attr("checked",true);
		}else{
			$(obj).attr("checked",false);
		}
	});
	if(label_newtype == 'address'){
		openDialog(label_title, layerid, {"width":"800","height":"490","show" : "fade","hide" : "fade"});
	}else if(label_newtype == 'dayinput' || label_newtype == 'dayauto' ){
		openDialog(label_title, layerid, {"width":"550","height":"400","show" : "fade","hide" : "fade"});
	}else if(label_newtype == 'color'){
		openDialog(label_title, layerid, {"width":"300","height":"400","show" : "fade","hide" : "fade"});
	}else{
		openDialog(label_title, layerid, {"width":"800","height":"400","show" : "fade","hide" : "fade"});
	}
}

// 옵션정보 가져오기 선택 시
function chgOptionMakeId(obj){
	$(obj).parent().find("span").addClass("hide");
	if( $(obj).val() == 'direct'){//직접입력
		goodsoptiondirectdefault($(obj).parents("tr"));
	}else{//상품코드 옵션선택시
		goodsoptionspecialselect($(obj), $(obj).parents("tr"));
	}
	goodsoptioncode($(obj));//필수옵션 >> 필수옵션코드추가
}

//옵션 >> 옵션코드추가
function goodsoptioncode(obj) {
	obj.parent().parent().find(".goodsoptionlay").hide();
	obj.parent().parent().find(".etcContents").show();
	obj.parent().parent().find(".optionMakeType").val('');
	var selectecttitle = obj.find("option:selected").val();
	if(  selectecttitle.substr(0,11) == 'goodsoption'){
		obj.parent().parent().find(".optionMakeType").val(selectecttitle);
		obj.parent().parent().find(".goodsoptionlay").show();
		obj.parent().parent().find(".goodsoptionsublay").hide();
		obj.parent().parent().find(".etcContents").hide();
		obj.parent().parent().find("."+selectecttitle).show();
	}
}

//옵션정보 가져오기시 중복체크
function goodsoptionspecialselect(obj, objparent) {
	var parentidx = objparent.index();//현재위치
	var goodsoptionspecialdate = 0;
	var goodsoptionspecial = 0;
	var label_newtype = obj.find("option:selected").attr("label_newtype");
	var optionMakeIdval = obj.find("option:selected").val();
	var label_newtype_length = objparent.parent().find("select[name='optionMakespecial[]']").length;

	if( label_newtype_length > 1 ) {
		objparent.parent().find("select[name='optionMakespecial[]']").each( function() {
			var selidx = $(this).parents("tr").index();//alert(parentidx + "-->" + selidx);//
			if(parentidx != selidx && $(this).val()){
				if( $(this).find("option:selected"))  {
					if( label_newtype == $(this).val() )  goodsoptionspecial++;//중복불가

					if( $(this).val() == 'date' ||  $(this).val() == 'dayauto'  ||  $(this).val() == 'dayinput' )goodsoptionspecialdate++;
				}
			}
		});
	}
	if( goodsoptionspecialdate > 0 && ( label_newtype == 'date' ||  label_newtype == 'dayauto'  ||  label_newtype == 'dayinput' ) ){
		alert("[수동기간, 자동기간, 날짜]를 동시에 선택할 수 없습니다.");
		objparent.find("select[name='optionMakeId[]'] option[value='direct']").attr("selected",true);
		goodsoptiondirectdefault(objparent);//초기화
		return;
	}

	objparent.find("input[name='optionMakeValue[]']").val('').attr("title","");
	objparent.find("input[name='optionMakePrice[]']").val('').attr("title","");

	if( goodsoptionspecial < 1 ) {
		objparent.find(".optionMakeSpecial").hide();
		objparent.find(".optionMakeSpecialsub").hide();
		//objparent.find(".optionMakelayout").show();

		var label_newtype = obj.find("option:selected").attr("label_newtype");
		//objparent.find("input[name='optionMakeName[]']").addClass("input-box-default-text-code");
		//objparent.find("input[name='optionMakeValue[]']").addClass("input-box-default-text-code");
		objparent.find("input[name='optionMakeName[]']").val(obj.children("option:selected").attr("label_title"));
		//objparent.find("input[name='optionMakeName[]']").attr("readonly",true);
		objparent.find("select[name='optionMakespecial[]']").attr("disabled",true);
		objparent.find("select[name='optionMakespecial[]']").attr("readonly",true);
		objparent.find("input[name='optionMakeValue[]']").hide();

		if( label_newtype != 'none') {
			objparent.find("select[name='optionMakespecial[]'] option[value='"+label_newtype+"']").attr("selected",true);
		}else{
			objparent.find("select[name='optionMakespecial[]'] option[value='']").attr("selected",true);
		}
		if(label_newtype) {
			objparent.find(".optionMakeSpecial").show();
			objparent.find(".optionMakeSpecialsub").hide();
			switch(label_newtype){
				case 'color':			objparent.find(".optionMakeColor").show();break;
				case 'address':		objparent.find(".optionMakeaddress").show();break;
				case 'date':			objparent.find(".optionMakedate").show();break;
				case 'dayinput':	objparent.find(".optionMakedayinput").show();break;
				case 'dayauto':	objparent.find(".optionMakenewdayauto").show();break;
			}
		}else{
			objparent.find(".optionMakeSpecial").hide();
			objparent.find(".optionMakeSpecialsub").hide();
		}
		setDefaultText();
		setDatepicker();


		return true;
	}else{

		alert("서로 다른 특수정보는 사용가능하나\n동일한 특수정보는 중복사용할 수 없습니다.");
		objparent.find("select[name='optionMakeId[]'] option[value='direct']").attr("selected",true);
		goodsoptiondirectdefault(objparent);//초기화
		return;
	}
}

//옵션 >> 직접입력시 초기화
function goodsoptiondirectdefault(objparent){
	objparent.find("input[name='optionMakeName[]']").removeClass("input-box-default-text-code");
	objparent.find("input[name='optionMakeValue[]']").removeClass("input-box-default-text-code");
	//objparent.find("input[name='optionMakeName[]']").val('');
	//objparent.find("input[name='optionMakeValue[]']").val('');
	//objparent.find("input[name='optionMakePrice[]']").val('').attr("title","");
	objparent.find("input[name='optionMakeName[]']").val('').attr("title","예) 사이즈");
	objparent.find("input[name='optionMakeValue[]']").val('').attr("title","예) 90, 95, 100");
	objparent.find("input[name='optionMakeCode[]']").val('');
	objparent.find("input[name='optionMakePrice[]']").val('').attr("title","예) 0,0,0");

	objparent.find("input[name='optionMakenewtype[]']").val('');
	objparent.find("input[name='optionMakecolor[]']").val('');
	objparent.find("input[name='optionMakezipcode[]']").val('');
	objparent.find("input[name='optionMakeaddress_type[]']").val('');
	objparent.find("input[name='optionMakeaddress[]']").val('');
	objparent.find("input[name='optionMakeaddress_street[]']").val('');
	objparent.find("input[name='optionMakeaddressdetail[]']").val('');
	objparent.find("input[name='optionMakebiztel[]']").val('');
	objparent.find("input[name='optionMakeaddress_commission[]']").val('');

	objparent.find("input[name='optionMakesdayinput[]']").val('');
	objparent.find("input[name='optionMakefdayinput[]']").val('');
	objparent.find("input[name='optionMakedayauto_type[]'] option[value='']").attr("selected",true);
	objparent.find("input[name='optionMakesdayauto[]']").val('');
	objparent.find("input[name='optionMakefdayauto[]']").val('');
	objparent.find("input[name='optionMakedayauto_day[]'] option[value='']").attr("selected",true);

	objparent.find("input[name='optionMakeValue[]']").removeAttr("readonly");
	objparent.find("input[name='optionMakeName[]']").removeAttr("readonly");
	objparent.find("select[name='optionMakespecial[]']").removeAttr("readonly");
	objparent.find("select[name='optionMakespecial[]']").removeAttr("disabled");
	objparent.find("select[name='optionMakespecial[]'] option[value='']").attr("selected",true);
	objparent.find("input[name='optionMakeName[]']").show();
	objparent.find("input[name='optionMakeValue[]']").show();

	objparent.find(".optionMakeSpecial").hide();
	objparent.find(".optionMakeSpecialsub").hide();
	//objparent.find(".optionMakelayout").show();
}

//옵션 > 직접입력 >> 특수정보 선택시
function goodsoptionspecialform(obj, objparent) {
	var parentidx = objparent.index();//현재위치
	var specialform = obj.val();
	var goodsoptionspecial = 0;
	var goodsoptionspecialdate = 0;
	var label_newtype = specialform;
	var label_newtype_length = objparent.parent().find("select[name='optionMakespecial[]']").length;
	if( label_newtype_length > 1 ) {
		objparent.parent().find("select[name='optionMakespecial[]']").each( function() {
			var selidx = $(this).parents("tr").index();//alert(parentidx + "-->" + selidx);//

			if(parentidx == selidx && label_newtype == $(this).val()) {//본인추가
				goodsoptionspecial++;//중복불가
				return true;
			}

			if( parentidx != selidx && $(this).val()){
				if( $(this).find("option:selected"))  {
					if( label_newtype == $(this).val() )  goodsoptionspecial++;//중복불가
					if( $(this).val() == 'date' ||  $(this).val() == 'dayauto'  ||  $(this).val() == 'dayinput' ) goodsoptionspecialdate++;
				}
			}
		});
	}
	var valuetitle = "예) 90, 95, 100";
	objparent.find("input[name='optionMakeValue[]']").val("").attr("title","");
	objparent.find("input[name='optionMakeCode[]']").val('');
	if( specialform == 'date' ) {
		valuetitle = "예) 12월 31일 20시 공연";
		objparent.find("input[name='optionMakeName[]']").val('예) 공연일시').attr("title","예) 공연일시");
		objparent.find("input[name='optionMakePrice[]']").val('예) 0').attr("title","예) 0");
	}
	else if( specialform == 'dayauto' ){
		valuetitle = "사용 기간을 안내 하세요.";
		objparent.find("input[name='optionMakeName[]']").val('예) 사용기간').attr("title","예) 사용기간");
		objparent.find("input[name='optionMakePrice[]']").val('예) 0').attr("title","예) 0");
	}
	else if( specialform == 'dayinput' ){
		valuetitle = "사용 기간을 안내 하세요.";
		objparent.find("input[name='optionMakeName[]']").val('예) 사용기간').attr("title","예) 사용기간");
		objparent.find("input[name='optionMakePrice[]']").val('예) 0').attr("title","예) 0");
	}
	else if( specialform == 'color' ){
		valuetitle = "예) 블랙, 화이트, 그레이";
		objparent.find("input[name='optionMakeName[]']").val('예) 색상').attr("title","예) 색상");
		objparent.find("input[name='optionMakePrice[]']").val('예) 0,0,0').attr("title","예) 0,0,0");
	}
	else if( specialform == 'address' ){
		valuetitle = "예) 분당점, 삼평점, 판교점";
		objparent.find("input[name='optionMakeName[]']").val('예) 사용지점').attr("title","예) 사용지점");
		objparent.find("input[name='optionMakePrice[]']").val('예) 0,0,0').attr("title","예) 0,0,0");
	}else{
		objparent.find("input[name='optionMakeName[]']").val('예) 사이즈').attr("title","예) 사이즈");
		objparent.find("input[name='optionMakePrice[]']").val('예) 0,0,0').attr("title","예) 0,0,0");
	}
	objparent.find("input[name='optionMakeValue[]']").val(valuetitle);
	objparent.find("input[name='optionMakeValue[]']").attr("title",valuetitle);

	//alert(goodsoptionspecialdate + " --> " + label_newtype);
	if( goodsoptionspecialdate > 0  && ( label_newtype == 'date' ||  label_newtype == 'dayauto'  ||  label_newtype == 'dayinput' ) ){
		alert("[수동기간, 자동기간, 날짜]를 동시에 선택할 수 없습니다.");
		objparent.find("input[name='optionMakenewtype[]']").val('');
		objparent.find("select[name='optionMakeId[]'] option[value='direct']").attr("selected",true);
		goodsoptiondirectdefault(objparent);//초기화
		return;
	}

	if( goodsoptionspecial < 2 ) {
		if(specialform) {
			objparent.find(".optionMakeSpecial").show();
			objparent.find(".optionMakeSpecialsub").hide();
			//objparent.find(".optionMakelayout").hide();
			switch(specialform){
				case 'color':			objparent.find(".optionMakeColor").show();break;
				case 'address':		objparent.find(".optionMakeaddress").show();break;
				case 'date':			objparent.find(".optionMakedate").show();break;
				case 'dayinput':	objparent.find(".optionMakedayinput").show();break;
				case 'dayauto':	objparent.find(".optionMakenewdayauto").show();break;
			}
			objparent.find("input[name='optionMakenewtype[]']").val(specialform);
			setDefaultText();
			setDatepicker();
		}else{
			objparent.find("input[name='optionMakenewtype[]']").val('');
			objparent.find(".optionMakeSpecial").hide();
			objparent.find(".optionMakeSpecialsub").hide();
			objparent.find("select[name='optionMakeId[]'] option[value='direct']").attr("selected",true);
			//objparent.find(".optionMakelayout").show();
			return;
		}
	}else{
		objparent.find("input[name='optionMakenewtype[]']").val('');
		alert("서로 다른 특수정보는 사용가능하나\n동일한 특수정보는 중복사용할 수 없습니다.");
		objparent.find("select[name='optionMakeId[]'] option[value='direct']").attr("selected",true);
		goodsoptiondirectdefault(objparent);//초기화
		return;
	}
}

//특수옵션 > 자동기간 미리보기
function socialcpdayautoreview(opttblobj) {
	opttblobj.find(".optionMakenewdayautolayrealdate").html('');
	var dayauto_type = 'month';
	dayauto_type = opttblobj.find(".optionMakedayauto_type option:selected").val();

	var sdayauto = '0';
	sdayauto = opttblobj.find(".optionMakesdayauto").val();

	var fdayauto = '0';
	fdayauto = opttblobj.find(".optionMakefdayauto").val();

	var dayauto_day = 'day';
	dayauto_day = opttblobj.find(".optionMakedayauto_day option:selected").val();

	if( !sdayauto || !sdayauto ){
		alert("기간 자동일자를 정확히 입력해 주세요.");
		return false;
	}

	$.ajax({
		'url' : '../setting_process/goods_dayauto_setting',
		'data' : {'dayauto_type':dayauto_type,'dayauto_day':dayauto_day,'sdayauto':sdayauto,'fdayauto':fdayauto},
		'dataType' : 'json',
		'success' : function(res){
			opttblobj.find(".optionMakenewdayautolayrealdate").html(res.social_start_date+"~"+res.social_end_date);
		}
	});

}

</script>
<!-- 옵션만들기 다이얼로그 -->
<div id="optionMakePopup" class="hide">
	<form name="optionMakeForm" id="optionMakeForm" method="post" action="../goods_process/make_tmp_option" target="optionFrame">
	<input type="hidden" name="goods_seq" value="<?php echo $TPL_VAR["goods_seq"]?>" />
	<input type="hidden" name="tmp_seq" value="<?php echo $TPL_VAR["tmp_seq"]?>" />
	<input type="hidden" name="optionMakeDepth" value="1" />
	<input type="hidden" name="optionCode" class="line" size="55" value="" />
	<input type="hidden" name="socialcpuseopen" class="socialcpuseopen" value="" />
	<input type="hidden" name="goodsTax" class="goodsTax" value="" />
	<input type="hidden" name="default_commission_rate" class="default_commission_rate" value="<?php echo $TPL_VAR["default_charge"]["charge"]?>" />
	<input type="hidden" name="default_commission_type" class="default_commission_type" value="<?php echo $TPL_VAR["default_charge"]["commission_type"]?>" />
	<table  class="simplelist-table-style" style="width:100%">
	<colgroup>
		<col width="1%" />
		<col/>
		<col  width="200"/>
		<col />
		<col width="200" />
	</colgroup>
	<thead>
	<tr>
		<th class="its-th-align center" ></th>
		<th class="its-th-align center">
			옵션정보 가져오기
			<a href="javascript:helperMessageLayer('getOptions');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
		</th>
		<th class="its-th-align center" >
			옵션명
			[특수정보선택] <a href="javascript:helperMessageLayer('specialOption');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
		</th>
		<th class="its-th-align center" >옵션값 → ','(콤마)로 구분</th>
		<th class="its-th-align center" >
			옵션가격 → ','(콤마)로 구분 <a href="javascript:helperMessageLayer('optionPrice');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
		</th>
	</tr>
	</thead>
	<tbody>

<?php if($TPL_VAR["opts_loop"]){?>
<?php if($TPL_opts_loop_1){$TPL_I1=-1;foreach($TPL_VAR["opts_loop"] as $TPL_V1){$TPL_I1++;?>
		<tr>
			<td class="its-td-align center">
<?php if($TPL_I1== 0){?>
				<span class="btn-plus btnplusminus"><button type="button" id="addOptionMake"></button></span>
<?php }else{?>
				<span class="btn-minus btnplusminus"><button type="button" onclick="$(this).parents('tr').remove();"></button></span>
<?php }?>
			</td>
			<td class="its-td-align center">
				<input type="hidden" name="optionMakeType[]" value="<?php echo $TPL_V1["type"]?>" />
				<input type="hidden" name="optionMakeCode[]" value="<?php echo $TPL_V1["optcodes"]?>" />
				<input type="hidden" name="optionMakenewtype[]" value="<?php echo $TPL_V1["newtype"][$TPL_I1]?>" />
				<input type="hidden" name="optionMakecolor[]" value="<?php echo $TPL_V1["colors"]?>" />
				<input type="hidden" name="optionMakezipcode[]" value="<?php echo $TPL_V1["zipcodes"]?>" />
				<input type="hidden" name="optionMakeaddress_type[]" value="<?php echo $TPL_V1["addresss_type"]?>" />
				<input type="hidden" name="optionMakeaddress[]" value="<?php echo $TPL_V1["addresss"]?>" />
				<input type="hidden" name="optionMakeaddress_street[]" value="<?php echo $TPL_V1["addresss_street"]?>" />
				<input type="hidden" name="optionMakeaddressdetail[]" value="<?php echo $TPL_V1["addressdetails"]?>" />
				<input type="hidden" name="optionMakebiztel[]" value="<?php echo $TPL_V1["biztels"]?>" />
				<input type="hidden" name="optionMakeaddress_commission[]" value="<?php echo $TPL_V1["address_commissions"]?>" />
				<input type="hidden"  name="optionMakecodedate[]" class="optionMakecodedate" value="<?php echo $TPL_V1["codedates"]?>">

				<select name="optionMakeId[]" class="line" onclick="chgOptionMakeId(this);">
<?php if(is_array($TPL_R2=$TPL_V1["goodsoptionloop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($_GET["socialcp_input_type"]){?>
<?php if($TPL_V2["label_newtype"]!='color'){?>
					<option value="goodsoption_<?php echo $TPL_V2["codeform_seq"]?>" label_type="<?php echo $TPL_V2["label_type"]?>"  codeform_seq="<?php echo $TPL_V2["codeform_seq"]?>" label_title="<?php echo $TPL_V2["label_title"]?>"  label_newtype="<?php echo $TPL_V2["label_newtype"]?>"  label_color="<?php echo $TPL_V2["label_color"]?>" newtypeid="goodsoption_<?php echo $TPL_I1?>_<?php echo $TPL_V1["newtype"][$TPL_I1]?>" label_zipcode="<?php echo $TPL_V2["label_zipcode"]?>" label_address_type="<?php echo $TPL_V2["label_address_type"]?>"  label_address="<?php echo $TPL_V2["label_address"]?>" label_address_street="<?php echo str_replace(',','＆',$TPL_V2["address_street"])?>"  label_addressdetail="<?php echo $TPL_V2["label_addressdetail"]?>" label_biztel="<?php echo $TPL_V2["label_biztel"]?>"  label_address_commission="<?php echo $TPL_V2["label_address_commission"]?>"  label_codedate="<?php echo $TPL_V2["label_codedate"]?>"  label_sdayinput="<?php echo $TPL_V2["label_sdayinput"]?>" label_fdayinput="<?php echo $TPL_V2["label_fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V2["label_dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V2["label_sdayauto"]?>" label_fdayauto="<?php echo $TPL_V2["label_fdayauto"]?>" label_dayauto_day="<?php echo $TPL_V2["label_dayauto_day"]?>" <?php if(str_replace('goodsoption_','',$TPL_V1["type"])==$TPL_V2["codeform_seq"]){?> selected="selected" <?php }?> ><?php if($TPL_V2["label_newtype"]&&$TPL_V2["label_newtype"]!='none'){?>[특수]<?php }?> <?php echo $TPL_V2["label_title"]?></option>
<?php }?>
<?php }else{?>
<?php if($TPL_V2["label_newtype"]=='color'||!$TPL_V2["label_newtype"]||$TPL_V2["label_newtype"]=='none'){?>
					<option value="goodsoption_<?php echo $TPL_V2["codeform_seq"]?>" label_type="<?php echo $TPL_V2["label_type"]?>"  codeform_seq="<?php echo $TPL_V2["codeform_seq"]?>" label_title="<?php echo $TPL_V2["label_title"]?>"  label_newtype="<?php echo $TPL_V2["label_newtype"]?>"  label_color="<?php echo $TPL_V2["label_color"]?>" newtypeid="goodsoption_<?php echo $TPL_I1?>_<?php echo $TPL_V1["newtype"][$TPL_I1]?>" label_zipcode="<?php echo $TPL_V2["label_zipcode"]?>"  label_address_type="<?php echo $TPL_V2["label_address_type"]?>"  label_address="<?php echo $TPL_V2["label_address"]?>" label_address_street="<?php echo $TPL_V2["label_address_street"]?>"  label_addressdetail="<?php echo $TPL_V2["label_addressdetail"]?>" label_biztel="<?php echo $TPL_V2["label_biztel"]?>"  label_address_commission="<?php echo $TPL_V2["label_address_commission"]?>"   label_codedate="<?php echo $TPL_V2["label_codedate"]?>"  label_sdayinput="<?php echo $TPL_V2["label_sdayinput"]?>" label_fdayinput="<?php echo $TPL_V2["label_fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V2["label_dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V2["label_sdayauto"]?>" label_fdayauto="<?php echo $TPL_V2["label_fdayauto"]?>" label_dayauto_day="<?php echo $TPL_V2["label_dayauto_day"]?>" <?php if(str_replace('goodsoption_','',$TPL_V1["type"])==$TPL_V2["codeform_seq"]){?> selected="selected" <?php }?> ><?php if($TPL_V2["label_newtype"]&&$TPL_V2["label_newtype"]!='none'){?>[특수]<?php }?> <?php echo $TPL_V2["label_title"]?></option>
<?php }?>
<?php }?>
<?php }}?>
					<option value="direct"  <?php if(!strstr($TPL_V1["type"],'goodsoption_')){?> selected="selected" <?php }?>>직접입력</option>
				</select>
			</td>
			<td class="its-td-align center">
				<input type="text" name="optionMakeName[]" class="line " size="10" value="<?php echo $TPL_V1["title"]?>" />
<?php if($TPL_V1["newtype"][$TPL_I1]&&$TPL_V1["newtype"][$TPL_I1]!='none'&&strstr($TPL_V1["type"],'goodsoption_')){?>
				<select  name="optionMakespecial[]"  readonly="readonly" disabled="disabled" id="goodsoption_<?php echo $TPL_I1?>_<?php echo $TPL_V1["newtype"][$TPL_I1]?>" class="<?php echo $TPL_V1["newtype"][$TPL_I1]?>select"  onchange="goodsoptionspecialform($(this), $(this).parents('tr'));">
					<option value="" >특수정보선택</option>
<?php if($_GET["socialcp_input_type"]){?>
					<option value="address"  <?php if($TPL_V1["newtype"][$TPL_I1]=='address'){?> selected="selected" <?php }?>>지역</option>
					<option value="date"  <?php if($TPL_V1["newtype"][$TPL_I1]=='date'){?> selected="selected" <?php }?>>날짜</option>
					<option value="dayauto"  <?php if($TPL_V1["newtype"][$TPL_I1]=='dayauto'){?> selected="selected" <?php }?>>자동기간</option>
					<option value="dayinput"  <?php if($TPL_V1["newtype"][$TPL_I1]=='dayinput'){?> selected="selected" <?php }?>>수동기간</option>
<?php }else{?>
					<option value="color" <?php if($TPL_V1["newtype"][$TPL_I1]=='color'){?> selected="selected" <?php }?>>색상</option>
<?php }?>
				</select>
<?php }else{?>
				<select name="optionMakespecial[]"  id="goodsoption_<?php echo $TPL_I1?>_<?php echo $TPL_V1["newtype"][$TPL_I1]?>" class="<?php echo $TPL_V1["newtype"][$TPL_I1]?>select" onchange="goodsoptionspecialform($(this), $(this).parents('tr'));">
					<option value="" >특수정보선택</option>
<?php if($_GET["socialcp_input_type"]){?>
					<option value="address"  <?php if($TPL_V1["newtype"][$TPL_I1]=='address'){?> selected="selected" <?php }?>>지역</option>
					<option value="date"  <?php if($TPL_V1["newtype"][$TPL_I1]=='date'){?> selected="selected" <?php }?>>날짜</option>
					<option value="dayauto"  <?php if($TPL_V1["newtype"][$TPL_I1]=='dayauto'){?> selected="selected" <?php }?>>자동기간</option>
					<option value="dayinput"  <?php if($TPL_V1["newtype"][$TPL_I1]=='dayinput'){?> selected="selected" <?php }?>>수동기간</option>
<?php }else{?>
					<option value="color" <?php if($TPL_V1["newtype"][$TPL_I1]=='color'){?> selected="selected" <?php }?>>색상</option>
<?php }?>
				</select>
<?php }?>
			</td>
			<td class="its-td-align left">
				<span class='goodsoptionlay'>
<?php if(is_array($TPL_R2=$TPL_V1["goodsoptionloop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<span class="goodsoption_<?php echo $TPL_V2["codeform_seq"]?> goodsoptionsublay <?php if((($TPL_V1["code_seq"]!=$TPL_V2["codeform_seq"]&&strstr($TPL_V1["type"],'goodsoption_'))||(!strstr($TPL_V1["type"],'goodsoption_')))){?>hide<?php }?> "><span class="btn small "><button type="button" class="<?php echo $TPL_V2["label_type"]?>btn" onclick="goodsOptionBtn(this);" layerid="<?php echo $TPL_V2["label_type"]?><?php echo $TPL_V2["codeform_seq"]?>_lay" label_type="<?php echo $TPL_V2["label_type"]?>"  codeform_seq="<?php echo $TPL_V2["codeform_seq"]?>" label_title="<?php echo $TPL_V2["label_title"]?>"  label_newtype="<?php echo $TPL_V2["label_newtype"]?>"  label_color="<?php echo $TPL_V2["label_color"]?>" label_zipcode="<?php echo $TPL_V2["label_zipcode"]?>"  label_address_type="<?php echo $TPL_V2["label_address_type"]?>"  label_address="<?php echo $TPL_V2["label_address"]?>"  label_address_street="<?php echo $TPL_V2["label_address_street"]?>"  label_addressdetail="<?php echo $TPL_V2["label_addressdetail"]?>" label_biztel="<?php echo $TPL_V2["label_biztel"]?>" label_address_commission="<?php echo $TPL_V2["label_address_commission"]?>"  label_codedate="<?php echo $TPL_V2["label_codedate"]?>"  label_sdayinput="<?php echo $TPL_V2["label_sdayinput"]?>" label_fdayinput="<?php echo $TPL_V2["label_fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V2["label_dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V2["label_sdayauto"]?>" label_fdayauto="<?php echo $TPL_V2["label_fdayauto"]?>" label_dayauto_day="<?php echo $TPL_V2["label_dayauto_day"]?>" >선택</button></span></span>
<?php }}?>
				</span>
				<input type="text" name="optionMakeValue[]" class="line " size="45" value="<?php echo $TPL_V1["opt"]?>" onblur="setDefaultPrice(this);" />

				<div class="optionMakeSpecial ">
					<div class="optionMakeSpecialsub optionMakeColor  <?php if($TPL_V1["newtype"][$TPL_I1]!='color'){?> hide <?php }?>">
						<span class="desc">※ 색상표 정보는 옵션 생성 후 입력 가능합니다.</span>
					</div>
					<div class="optionMakeSpecialsub optionMakeaddress   <?php if($TPL_V1["newtype"][$TPL_I1]!='address'){?> hide <?php }?>">
						<span class="desc">※ 지역의 위치정보는 옵션 생성 후 입력 가능합니다.</span>
					</div>
					<div class="optionMakeSpecialsub optionMakedate  <?php if($TPL_V1["newtype"][$TPL_I1]!='date'){?> hide <?php }?>">
						<span class="desc">※ 날짜 지정은 옵션 생성 후 입력 가능합니다.</span>
					</div>
					<div class="optionMakeSpecialsub optionMakedayinput  <?php if($TPL_V1["newtype"][$TPL_I1]!='dayinput'){?> hide <?php }?>">
						<input type="text" name="optionMakesdayinput[]" id="addoptionMakesdayinput<?php echo $TPL_I1?>"  value="<?php echo $TPL_V1["sdayinput"]?>" class="line optionMakesdayinput datepicker"  maxlength="10" size="10" />
						~
						<input type="text" name="optionMakefdayinput[]" id="addoptionMakefdayinput<?php echo $TPL_I1?>" value="<?php echo $TPL_V1["fdayinput"]?>" class="line optionMakefdayinput datepicker" maxlength="10" size="10" />
					</div>
					<div class="optionMakeSpecialsub optionMakenewdayauto  <?php if($TPL_V1["newtype"][$TPL_I1]!='dayauto'){?> hide <?php }?>">
						<span> '결제확인' 후
							<select name="optionMakedayauto_type[]" class="optionMakedayauto_type" >
								<option value="month" <?php if($TPL_V1["dayauto_type"]=='month'){?> selected="selected" <?php }?>>해당 월▼</option>
								<option value="day" <?php if($TPL_V1["dayauto_type"]=='day'){?> selected="selected" <?php }?>>해당 일▼</option>
								<option value="next" <?php if($TPL_V1["dayauto_type"]=='next'){?> selected="selected" <?php }?>>익월▼</option>
							</select>
							<input type="text" name="optionMakesdayauto[]"  value="<?php echo $TPL_V1["sdayauto"]?>" class="line optionMakesdayauto"  maxlength="10" size="2" />일 <span class="optionMakenewdayautolaytitle"><?php if($TPL_V1["dayauto_type"]=='day'){?>이후<?php }?></span>부터 +
							<input type="text" name="optionMakefdayauto[]"  value="<?php echo $TPL_V1["fdayauto"]?>" class="line optionMakefdayauto"  maxlength="10" size="2" />일
							<select name="optionMakedayauto_day[]" class="optionMakedayauto_day" onchange="socialcpdayautoreview($(this).parents('div.optionMakenewdayauto'));">
								<option value="day"  <?php if($TPL_V1["dayauto_day"]=='day'){?> selected="selected" <?php }?>>동안</option>
								<option value="end"  <?php if($TPL_V1["dayauto_day"]=='end'){?> selected="selected" <?php }?>>이 되는 월의 말일</option>
							</select>
						</span>
						<br/>
						<span  class="hand optionMakenewdayautolayrealdateBtn"  >미리보기▶ </span>
						<span class="optionMakenewdayautolayrealdate"><?php echo $TPL_V1["social_start_date_end"]?></span>
					</div>
				</div>
			</td>
			<td class="its-td-align center">
				<input type="text" name="optionMakePrice[]" class="line" size="25" value="<?php echo $TPL_V1["price"]?>" />
			</td>
		</tr>
<?php }}?>
<?php }else{?>
		<tr>
			<td class="its-td-align center">
				<span class="btn-plus  btnplusminus"><button type="button" id="addOptionMake"></button></span>
			</td>
			<td class="its-td-align center">
				<input type="hidden" name="optionMakeType[]" value="" />
				<input type="hidden" name="optionMakeCode[]" value="" />
				<input type="hidden" name="optionMakenewtype[]" value="" />
				<input type="hidden" name="optionMakecolor[]" value="" />
				<input type="hidden" name="optionMakezipcode[]" value="" />
				<input type="hidden" name="optionMakeaddress_type[]" value="" />
				<input type="hidden" name="optionMakeaddress[]" value="" />
				<input type="hidden" name="optionMakeaddress_street[]" value="" />
				<input type="hidden" name="optionMakeaddressdetail[]" value="" />
				<input type="hidden" name="optionMakebiztel[]" value="" />
				<input type="hidden" name="optionMakeaddress_commission[]" value="" />
				<input type="hidden" name="optionMakecodedate[]" value="" />
				<select name="optionMakeId[]" class="line" onclick="chgOptionMakeId(this);">
<?php if($TPL_goodsoptionloop_1){foreach($TPL_VAR["goodsoptionloop"] as $TPL_V1){?>
<?php if($_GET["socialcp_input_type"]){?>
<?php if($TPL_V1["label_newtype"]!='color'){?>
					<option value="goodsoption_<?php echo $TPL_V1["codeform_seq"]?>" label_type="<?php echo $TPL_V1["label_type"]?>"  codeform_seq="<?php echo $TPL_V1["codeform_seq"]?>" label_title="<?php echo $TPL_V1["label_title"]?>"  label_newtype="<?php echo $TPL_V1["label_newtype"]?>"  label_color="<?php echo $TPL_V1["label_color"]?>" label_zipcode="<?php echo $TPL_V1["label_zipcode"]?>" label_address_type="<?php echo $TPL_V1["label_address_type"]?>"  label_address="<?php echo $TPL_V1["label_address"]?>"  label_address_street="<?php echo $TPL_V1["label_address_street"]?>" label_addressdetail="<?php echo $TPL_V1["label_addressdetail"]?>" label_biztel="<?php echo $TPL_V1["label_biztel"]?>"  label_address_commission="<?php echo $TPL_V1["label_address_commission"]?>"  label_codedate="<?php echo $TPL_V1["label_codedate"]?>"  label_sdayinput="<?php echo $TPL_V1["label_sdayinput"]?>" label_fdayinput="<?php echo $TPL_V1["label_fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V1["label_dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V1["label_sdayauto"]?>" label_fdayauto="<?php echo $TPL_V1["label_fdayauto"]?>" label_dayauto_day="<?php echo $TPL_V1["label_dayauto_day"]?>" ><?php if($TPL_V1["label_newtype"]&&$TPL_V1["label_newtype"]!='none'){?>[특수]<?php }?><?php echo $TPL_V1["label_title"]?></option>
<?php }?>
<?php }else{?>
<?php if($TPL_V1["label_newtype"]=='color'||!$TPL_V1["label_newtype"]||$TPL_V1["label_newtype"]=='none'){?>
					<option value="goodsoption_<?php echo $TPL_V1["codeform_seq"]?>" label_type="<?php echo $TPL_V1["label_type"]?>"  codeform_seq="<?php echo $TPL_V1["codeform_seq"]?>" label_title="<?php echo $TPL_V1["label_title"]?>"  label_newtype="<?php echo $TPL_V1["label_newtype"]?>"  label_color="<?php echo $TPL_V1["label_color"]?>" label_zipcode="<?php echo $TPL_V1["label_zipcode"]?>"  label_address_type="<?php echo $TPL_V1["label_address_type"]?>"  label_address="<?php echo $TPL_V1["label_address"]?>"  label_address_street="<?php echo $TPL_V1["label_address_street"]?>"  label_addressdetail="<?php echo $TPL_V1["label_addressdetail"]?>" label_biztel="<?php echo $TPL_V1["label_biztel"]?>"  label_address_commission="<?php echo $TPL_V1["label_address_commission"]?>"  label_codedate="<?php echo $TPL_V1["label_codedate"]?>"  label_sdayinput="<?php echo $TPL_V1["label_sdayinput"]?>" label_fdayinput="<?php echo $TPL_V1["label_fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V1["label_dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V1["label_sdayauto"]?>" label_fdayauto="<?php echo $TPL_V1["label_fdayauto"]?>" label_dayauto_day="<?php echo $TPL_V1["label_dayauto_day"]?>" ><?php if($TPL_V1["label_newtype"]&&$TPL_V1["label_newtype"]!='none'){?>[특수]<?php }?><?php echo $TPL_V1["label_title"]?></option>
<?php }?>
<?php }?>
<?php }}?>
					<option value="direct"  selected>직접입력</option>
				</select>
			</td>
			<td class="its-td-align center">
				<input type="text" name="optionMakeName[]" class="line" size="10" value="" title="예) 사이즈" />
				<select name="optionMakespecial[]" onchange="goodsoptionspecialform($(this), $(this).parents('tr'));">
					<option value="" >특수 정보</option>
<?php if($_GET["socialcp_input_type"]){?>
					<option value="address" >지역</option>
					<option value="date" >날짜</option>
					<option value="dayauto" >자동기간</option>
					<option value="dayinput" >수동기간</option>
<?php }else{?>
					<option value="color" >색상</option>
<?php }?>
				</select>
			</td>
			<td class="its-td-align left">
				<span class='goodsoptionlay hide'>
<?php if($TPL_goodsoptionloop_1){foreach($TPL_VAR["goodsoptionloop"] as $TPL_V1){?>
					<span class="goodsoption_<?php echo $TPL_V1["codeform_seq"]?> goodsoptionsublay hide"><span class="btn small "><button type="button" class="<?php echo $TPL_V1["label_type"]?>btn" onclick="goodsOptionBtn(this);" layerid="<?php echo $TPL_V1["label_type"]?><?php echo $TPL_V1["codeform_seq"]?>_lay" label_type="<?php echo $TPL_V1["label_type"]?>"  codeform_seq="<?php echo $TPL_V1["codeform_seq"]?>" label_title="<?php echo $TPL_V1["label_title"]?>"   label_newtype="<?php echo $TPL_V1["label_newtype"]?>"  label_color="<?php echo $TPL_V1["label_color"]?>" label_zipcode="<?php echo $TPL_V1["label_zipcode"]?>" label_address_type="<?php echo $TPL_V1["label_address_type"]?>"  label_address="<?php echo $TPL_V1["label_address"]?>"  label_address_street="<?php echo $TPL_V1["label_address_street"]?>" label_addressdetail="<?php echo $TPL_V1["label_addressdetail"]?>" label_biztel="<?php echo $TPL_V1["label_biztel"]?>"  label_address_commission="<?php echo $TPL_V1["label_address_commission"]?>"  label_codedate="<?php echo $TPL_V1["label_codedate"]?>"  label_sdayinput="<?php echo $TPL_V1["label_sdayinput"]?>" label_fdayinput="<?php echo $TPL_V1["label_fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V1["label_dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V1["label_sdayauto"]?>" label_fdayauto="<?php echo $TPL_V1["label_fdayauto"]?>" label_dayauto_day="<?php echo $TPL_V1["label_dayauto_day"]?>">선택</button></span></span>
<?php }}?>
				</span>
				<input type="text" name="optionMakeValue[]" class="line" size="45" value="" title="예) 90, 95, 100" onblur="setDefaultPrice(this);" />

				<div class="optionMakeSpecial hide">
					<div class="optionMakeSpecialsub optionMakeColor hide">
						<span class="desc">※ 색상표 정보는 옵션 생성 후 입력 가능합니다.</span>
					</div>

					<div class="optionMakeSpecialsub optionMakeaddress  hide">
						<span class="desc">※ 지역의 위치정보는 옵션 생성 후 입력 가능합니다.</span>
					</div>

					<div class="optionMakeSpecialsub optionMakedate hide">
						<span class="desc">※ 날짜 지정은 옵션 생성 후 입력 가능합니다.</span>
					</div>

					<div class="optionMakeSpecialsub optionMakedayinput hide">
						<input type="text" name="optionMakesdayinput[]"  id="addoptionMakesdayinput0" value="" class="line optionMakesdayinput datepicker"  maxlength="10" size="10" />
						~
						<input type="text" name="optionMakefdayinput[]"  id="addoptionMakefdayinput0" value="" class="line optionMakefdayinput datepicker"  maxlength="10" size="10" />
					</div>
					<div class="optionMakeSpecialsub optionMakenewdayauto hide">
						<span> '결제확인' 후
							<select name="optionMakedayauto_type[]" class="optionMakedayauto_type" >
								<option value="month">해당 월▼</option>
								<option value="day">해당 일▼</option>
								<option value="next">익월▼</option>
							</select>
							<input type="text" name="optionMakesdayauto[]"  value="" class="line optionMakesdayauto"  maxlength="10" size="2" />일 <span class="optionMakenewdayautolaytitle"></span>부터
							+
							<input type="text" name="optionMakefdayauto[]"  value="" class="line optionMakefdayauto"  maxlength="10" size="2" />일
							<select name="optionMakedayauto_day[]" class="optionMakedayauto_day" onchange="socialcpdayautoreview($(this).parents('div.optionMakenewdayauto'));">
							<option value="day">동안</option>
							<option value="end">이 되는 월의 말일</option>
							</select>
						</span>
						<br/><span  class="hand optionMakenewdayautolayrealdateBtn"  >미리보기▶ </span><span class="optionMakenewdayautolayrealdate"></span>
					</div>
				</div>
			</td>
			<td class="its-td-align center">
				<input type="text" name="optionMakePrice[]" class="line" size="25" value="" />
			</td>
		</tr>
<?php }?>
	</tbody>
	</table>
<?php if($_GET["package_yn"]=='y'){?>
	<div class="center" style="padding:10px;">
		위 옵션정보를 기준으로 <span class="blue">패키지/복합 상품</span>은
		<select name="create_package_count">
<?php if(is_array($TPL_R1=range( 1, 5))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["package_count"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?>개</option>
<?php }}?>
		</select>
		로 구성하며 출고처리 시 패키지/복합 상품에 연결된 실제 상품의 재고가 차감됩니다.
	</div>
<?php }?>
	<div class="center" style="padding:10px;"><span class="btn large"><button type="button" id="gdoptioncodemakebtn">옵션 생성하기</button></span></div>
	</form>
</div>

<!-- <?php if($TPL_goodsoptionloop_1){foreach($TPL_VAR["goodsoptionloop"] as $TPL_V1){?> -->
<div id="<?php echo $TPL_V1["label_type"]?><?php echo $TPL_V1["codeform_seq"]?>_lay" class="hide">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
	<tr>
		<td  valign="top" class="center">
			<div class="center" style="padding:10px;">
				<span class="btn large black"><button type="button" id="<?php echo $TPL_V1["label_type"]?><?php echo $TPL_V1["codeform_seq"]?>CodeApply" class="GoodsOptionCodeApply" onclick="setGoodsOption(this);" codeform_seq="<?php echo $TPL_V1["codeform_seq"]?>"  label_type="<?php echo $TPL_V1["label_type"]?>" label_newtype="<?php echo $TPL_V1["label_newtype"]?>"   label_id="<?php echo $TPL_V1["label_id"]?>" layer_id="<?php echo $TPL_V1["label_type"]?><?php echo $TPL_V1["codeform_seq"]?>_lay">적용하기</button></span>
			</div>
		</td>
	</tr>
	<tr>
		<td  valign="top">
			<table  width="100%" class="joinform-user-table info-table-style" border="1" cellspacing="3" cellpadding="0" align="center" border="0"  id=" labelTable">
			<col  /><col   width="30%" />
			<thead>
			<tr>
				<th  class="its-th center" id=" labelTh" align="center"><?php echo $TPL_V1["label_title"]?></th>
				<th  class="its-th center" id=" labelTh" align="center">코드값</th>
			</tr>
			</thead>
			<tbody>
<?php if(is_array($TPL_R2=$TPL_V1["code_arr"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<tr id=" labelTr"  class=" layer ">
				<td id=" labelTd1"  class="its-td left"  nowrap="nowrap" >
				<label><input type="checkbox" name="<?php echo $TPL_V1["label_type"]?>[]" class="null labelCheckbox_<?php echo $TPL_V1["codeform_seq"]?>"  codeform_seq="<?php echo $TPL_V1["codeform_seq"]?>"  label_type="<?php echo $TPL_V1["label_type"]?>"  label_id="<?php echo $TPL_V1["label_id"]?>" value="<?php echo $TPL_V2["code"]?>" label_value="<?php echo $TPL_V2["value"]?>"   label_newtype="<?php echo $TPL_V1["label_newtype"]?>"  label_color="<?php echo $TPL_V2["colors"]?>" label_zipcode="<?php echo $TPL_V2["zipcode"]?>" label_address_type="<?php echo $TPL_V2["address_type"]?>" label_address="<?php echo $TPL_V2["address"]?>" label_address_street="<?php echo str_replace(',','＆',$TPL_V2["address_street"])?>" label_addressdetail="<?php echo $TPL_V2["addressdetail"]?>" label_biztel="<?php echo $TPL_V2["biztel"]?>"  label_address_commission="<?php echo $TPL_V2["address_commission"]?>"  label_codedate="<?php echo $TPL_V2["codedate"]?>"  label_sdayinput="<?php echo $TPL_V2["sdayinput"]?>" label_fdayinput="<?php echo $TPL_V2["fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V2["dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V2["sdayauto"]?>" label_fdayauto="<?php echo $TPL_V2["fdayauto"]?>"  label_dayauto_day="<?php echo $TPL_V2["dayauto_day"]?>"  <?php if($TPL_V2["default"]=="Y"){?> default="checked" <?php }?>>
				<?php echo $TPL_V2["value"]?></label>
				<!-- <?php if($TPL_V1["label_newtype"]){?> -->
					<!-- <?php if($TPL_V1["label_newtype"]=='color'){?> -->
						→<div class="colorPickerBtn colorhelpicon" style="background-color:<?php echo $TPL_V2["colors"]?>" ></div>
					<!-- <?php }elseif($TPL_V1["label_newtype"]=='address'){?> -->
						→<span class="addrhelpicon1  " alt="<?php if($TPL_V2["zipcode"]){?>[<?php echo $TPL_V2["zipcode"]?>] <br> (지번) <?php echo $TPL_V2["address"]?> <?php echo $TPL_V2["addressdetail"]?><br>(도로명) <?php echo $TPL_V2["address_street"]?> <?php echo $TPL_V2["addressdetail"]?> <?php }?> <?php if($TPL_V2["biztel"]){?>업체 연락처:<?php echo $TPL_V2["biztel"]?><?php }?>"  title="<?php if($TPL_V2["zipcode"]){?>[<?php echo $TPL_V2["zipcode"]?>] <br> (지번) <?php echo $TPL_V2["address"]?> <?php echo $TPL_V2["addressdetail"]?><br>(도로명) <?php echo $TPL_V2["address_street"]?> <?php echo $TPL_V2["addressdetail"]?> <?php }?> <?php if($TPL_V2["biztel"]){?>업체 연락처:<?php echo $TPL_V2["biztel"]?><?php }?><br/>수수료:<?php echo $TPL_V2["address_commission"]?>%" ><?php if($TPL_V2["zipcode"]){?>[<?php echo $TPL_V2["zipcode"]?>] <br> (지번) <?php echo $TPL_V2["address"]?> <?php echo $TPL_V2["addressdetail"]?><br>(도로명) <?php echo $TPL_V2["address_street"]?> <?php echo $TPL_V2["addressdetail"]?> <?php }?> <?php if($TPL_V2["biztel"]){?><br/>업체 연락처:<?php echo $TPL_V2["biztel"]?><?php }?><br/>수수료:<?php echo $TPL_V2["address_commission"]?>%</span>
					<!-- <?php }elseif($TPL_V1["label_newtype"]=='date'){?> -->
						→<span class="codedatehelpicon1  " title="<?php echo $TPL_V2["codedate"]?>" ><?php echo $TPL_V2["codedate"]?></span>
					<!-- <?php }elseif($TPL_V1["label_newtype"]=='dayinput'){?> -->
						→<span class="dayinputhelpicon1   " title="<?php echo $TPL_V2["sdayinput"]?> ~ <?php echo $TPL_V2["fdayinput"]?>" ><?php echo $TPL_V2["sdayinput"]?> ~ <?php echo $TPL_V2["fdayinput"]?></span>
					<!-- <?php }elseif($TPL_V1["label_newtype"]=='dayauto'){?> -->
						→<span class="dayautohelpicon1   "  title="'결제확인' <?php echo $TPL_V2["dayauto_type_title"]?> <?php echo $TPL_V2["sdayauto"]?>일 <?php if($TPL_V2["dayauto_type"]=='day'){?>이후<?php }?>부터 + <?php echo $TPL_V2["fdayauto"]?>일  <?php echo $TPL_V2["dayauto_day_title"]?>">'결제확인' <?php echo $TPL_V2["dayauto_type_title"]?> <?php echo $TPL_V2["sdayauto"]?>일 <?php if($TPL_V2["dayauto_type"]=='day'){?>이후<?php }?>부터 + <?php echo $TPL_V2["fdayauto"]?>일  <?php echo $TPL_V2["dayauto_day_title"]?></span>
					<!-- <?php }?> -->
				<!-- <?php }?> -->
				</td>
				<td id=" labelTd2"  class="its-td center"><?php echo $TPL_V2["code"]?></td>
			</tr>
<?php }}?>
			</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td  valign="top" class="center">
			<input type="hidden" name="gdoptidx" class="gdoptidx" value="">
			<div class="center" style="padding:10px;">
				<span class="btn large black"><button type="button" id="<?php echo $TPL_V1["label_type"]?><?php echo $TPL_V1["codeform_seq"]?>CodeApply" class="GoodsOptionCodeApply" onclick="setGoodsOption(this);" codeform_seq="<?php echo $TPL_V1["codeform_seq"]?>"  label_type="<?php echo $TPL_V1["label_type"]?>" label_newtype="<?php echo $TPL_V1["label_newtype"]?>"   label_id="<?php echo $TPL_V1["label_id"]?>" layer_id="<?php echo $TPL_V1["label_type"]?><?php echo $TPL_V1["codeform_seq"]?>_lay">적용하기</button></span>
			</div>
		</td>
	</tr>
	</table>
	<!--//입력폼 -->
</div>
<!-- <?php }}?> -->

<div id="special_newlist" class="hide">
	<img src="/admin/skin/default/images/design/img_speinfo.jpg" />
</div>
<div id="option_newlist" class="hide">
	<img src="/admin/skin/default/images/design/img_optinfo.jpg" />
</div>

<!-- 메세지 리스트 -->
<div id="getOptionsMessage"  class="option-message hide">
	<ul>
		<li>
			<span style="color:blue">상품코드관리</span>에서 미리 등로개 놓은 옵션정보를 가져와서 옵션을 등록하게 됩니다. 옵션 정보의 일관성을 유지할 수 있게 됩니다.
			<br/><br/>
			<span class="btn small orange"><button type="button"  id="btn_goods_option_list"> 안내) 옵션정보 가져오기</button></span>
		</li>
	</ul>
</div>

<div id="optionPriceMessage"  class="option-message hide">
	<ul>
		<li>옵션가격의 합이 판매가격이 됩니다.<br/>판매가격은 부모창에서 직접입력 할 수도 있습니다.</li>
	</ul>
</div>

<div id="specialOptionMessage"  class="option-message hide">
	<ul>
		<li>
			<span style="font-weight:bold">실물배송상품의 특수옵션 [색상]:</span>
			특수옵션 색상을 사용하면 상품의 색상을 색상표로 설정할 수 있으며 상품의 색상을 소비자에게 노출할 수 있습니다.
		</li>
		<li>
			<span style="font-weight:bold">티켓발송상품의 특수옵션 [수동기간]:</span>
			특수옵션 수동기간을 사용하면 티켓의 유효기간을 수동으로 설정할 수 있으며 설정된 유효기간으로 티켓 사용/취소/환불이 자동 제어됩니다.
		</li>
		<li>
			<span style="font-weight:bold">티켓발송상품의 특수옵션 [자동기간]:</span>
			특수옵션 자동기간을 사용하면 티켓의 유효기간을 자동으로 설정할 수 있으며 설정된 유효기간으로 티켓 사용/취소/환불이 자동 제어됩니다.
		</li>
		<li>
			<span style="font-weight:bold">티켓발송상품의 특수옵션 [날짜]:</span>
			특수옵션 날짜를 사용하면 티켓의 유효일(ex.공연일)을 설정할 수 있으며 설정된 유효일로 티켓 사용/취소/환불이 자동 제어됩니다.
		</li>
		<li>
			<span style="font-weight:bold">티켓발송상품의 특수옵션 [지역]:</span>
			특수옵션 지역을 사용하면 티켓의 사용장소(ex.사용가능매장,공연장)를 설정할 수 있으며 설정된 사용장소로 티켓 사용이 제어됩니다.
			<br/><br/>
			<span class="btn small orange"><button type="button"  id="btn_goods_special_list"> 안내) 특수 정보 활용</button></span>
		</li>
	</ul>
</div>