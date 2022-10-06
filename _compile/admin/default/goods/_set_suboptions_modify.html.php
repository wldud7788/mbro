<?php /* Template_ 2.2.6 2022/05/17 12:32:00 /www/music_brother_firstmall_kr/admin/skin/default/goods/_set_suboptions_modify.html 000104692 */ 
$TPL_frequentlysublistAll_1=empty($TPL_VAR["frequentlysublistAll"])||!is_array($TPL_VAR["frequentlysublistAll"])?0:count($TPL_VAR["frequentlysublistAll"]);
$TPL_suboptions_1=empty($TPL_VAR["suboptions"])||!is_array($TPL_VAR["suboptions"])?0:count($TPL_VAR["suboptions"]);
$TPL_sopts_loop_1=empty($TPL_VAR["sopts_loop"])||!is_array($TPL_VAR["sopts_loop"])?0:count($TPL_VAR["sopts_loop"]);
$TPL_goodssuboptionloop_1=empty($TPL_VAR["goodssuboptionloop"])||!is_array($TPL_VAR["goodssuboptionloop"])?0:count($TPL_VAR["goodssuboptionloop"]);
$TPL_frequentlysublist_1=empty($TPL_VAR["frequentlysublist"])||!is_array($TPL_VAR["frequentlysublist"])?0:count($TPL_VAR["frequentlysublist"]);?>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/goods_admin.css" />
<script  type="text/javascript">
	var gl_goods_seq = '<?php echo $TPL_VAR["goods_seq"]?>';
	var gl_package_yn = '<?php echo $_GET["package_yn"]?>';
	$(document).ready(function(){

		chgSubReservePolicy();
		calulate_subOption_price();
		socialcpinputtype();
		$("input[name='subReserveRate[]']").bind("blur",function(){calulate_subOption_price();});
		$("select[name='subReserveUnit[]']").bind("change",function(){calulate_subOption_price();});
		$("input[name='subReserve[]']").bind("blur",function(){calulate_subOption_price();});
		$("input[name='subSupplyPrice[]']").bind("blur",function(){calulate_subOption_price();});
		$("input[name='subConsumerPrice[]']").bind("blur",function(){calulate_subOption_price();});
		$("input[name='subPrice[]']").bind("blur",function(){calulate_subOption_price();});
		$("input[name='subCommissionRate[]']").bind("blur",function(){calulate_subOption_price();});
		$("select[name='subCommissionType[]']").bind("blur",function(){calulate_subOption_price();});

		// 옵션 세로로 삭제
		$(".removeOptionCell").live("click", function(){
			suboptionFrame.location.href='../goods_process/remove_option_tmp_column?tmp_seq='+$(this).attr('tmpSeq')+'&depth='+$(this).attr('oDepth');
		});

		$(".colorpicker").customColorPicker();


		// 캐시
		$("input[name='subReserveRate[]']").each(function(){
			$(this).live("blur", function(){
				calculrate_reserve($("input[name='subReserveRate[]']").index(this));
			});
		});

		// 캐시 단위
		$("select[name='subReserveUnit[]']").each(function(){
			$(this).live("change", function(){
				calculrate_reserve($("select[name='subReserveUnit[]']").index(this));
			});
		});

		// 판매가
		$("input[name='subPrice[]']").each(function(){
			$(this).live("blur", function(){
				calculrate_reserve($("input[name='subPrice[]").index(this));
			});
		});

		// 옵션 추가 ---------------------------->
		$("#addCellOption").live("click",function(){
			openDialog("추가구성옵션", "subOptDialog", {"width":"1150","height":"500","show" : "fade","hide" : "fade"});
			$("input[name='optionMakeDepth']").val('<?php echo count($TPL_VAR["options"][ 0]["option_divide_title"])+ 1?>');
			$("input[name='optionName']").val('');
			$("input[name='optionPrice']").val('');
		});

		// 옵션 관리
		$("#optionSetting").bind("click",function(){
			openDialog("자주쓰는 상품의 옵션 관리", "optionSettingPopup", {"width":"500","height":"500","show" : "fade","hide" : "fade"});
		});

		// 서브옵션 만들기폼 추가
		$("#addSuboptionMake").bind("click",function(){
			var objTr = $(this).parents("tr");//$(this).parent().parent().parent();
			var objTb = $(this).parents("tbody");//$(this).parent().parent().parent().parent();

			$( objTr.find("input[name='suboptionMakesdayinput[]']") ).datepicker( "destroy" );
			$( objTr.find("input[name='suboptionMakefdayinput[]']") ).datepicker( "destroy" );

			var clone = objTr.clone();
			clone.find("#addSuboptionMake").attr("id","").addClass("delSuboptionMake");
			clone.find("span.btnplusminus").removeClass("btn-plus");
			clone.find("span.btnplusminus").addClass("btn-minus");
			clone.find("input[name='suboptionMakesdayinput[]']").attr("id","addoptionMakesdayinput"+(objTb.find("tr").index()+1));
			clone.find("input[name='suboptionMakefdayinput[]']").attr("id","addoptionMakefdayinput"+(objTb.find("tr").index()+1));
			setDatepicker(clone.find("input[name='suboptionMakesdayinput[]']"));
			setDatepicker(clone.find("input[name='suboptionMakefdayinput[]']"));
			objTb.append(clone);

			//폼초기화(직접입력)형식
			clone.find("select[name='suboptionMakeId[]'] option[value='direct']").attr("selected",true);
			goodssuboptiondirectdefault(clone);
			clone.find(".goodssuboptionlay").hide();
			clone.find(".etcContents").show();
			setDefaultText();
		});

		/* 옵션삭제하기  */
		$(".delSuboptionButton").live("click",function(){
			if( $(this).closest("tr.suboptionTr").parent().children("tr.suboptionTr").length > 0 ){
				$idx	= $(".delSuboptionButton").index(this);
				$nidx	= parseInt($idx) + 1;
				if	($(this).attr('ltype') == 'm' && $(".delSuboptionButton").eq($nidx).attr('ltype') == 's'){
					$(".subSale_td").eq($nidx).html($(".subSale_td").eq($idx).html());
					$(".subRequired_td").eq($nidx).html($(".subRequired_td").eq($idx).html());
					$(".suboptTitle_td").eq($nidx).html($(".suboptTitle_td").eq($idx).html());
					$(".delSuboptionButton").eq($nidx).attr('ltype', 'm');
				}
				$(this).closest("tr.suboptionTr").remove();
			}
		});

		/* 옵션만들기 폼 삭제하기 */
		$(".delSuboptionMake").live("click",function(){
			$(this).parents("tr").remove();//$(this).parent().parent().parent().remove();
		});

		/* 옵션직접입력 선택시 */
		$("select[name='suboptionMakeId[]']").live("change",function(){
			if( $(this).val() == 'direct'){//직접입력
				goodssuboptiondirectdefault($(this).parents("tr"));
			}else{//상품코드 옵션선택시
				goodssuboptionspecialselect($(this), $(this).parents("tr"));
			}
			goodssuboptioncode($(this));//추가정보 >> 추가구성옵션코드추가
		});

		//추가구성옵션 > 직접입력 >> 특수정보 선택시
		$("select[name='suboptionMakespecial[]']").live("change",function() {
			goodssuboptionspecialform($(this), $(this).parents("tr"));
		});

		/* 옵션 >> 추가된 코드 선택시 레이어띄우기 */
		$(".goodssuboptionbtn").live("click",function(){
			var layerid = $(this).attr("layerid");
			var label_type = $(this).attr("label_type");
			var label_newtype = $(this).attr("label_newtype");
			var codeform_seq = $(this).attr("codeform_seq");
			var label_title = $(this).attr("label_title");
			var idx = $(this).parents("tr").index();
			$("#"+layerid).find(".gdsuboptidx").val(idx);

			//설정 변경시 및 최초값설정
			var goodssuboptioncodetitlejoin = $("div#subOptDialog input[name='suboptionMakeCode[]']").eq(idx).val();
			if( goodssuboptioncodetitlejoin ) {//수정시 설정값셋팅
				var goodssuboptioncodetitlear = goodssuboptioncodetitlejoin.split(',');
			}
			$("#"+layerid).find("input[name='goodssuboption[]']").each(function(){
				if( goodssuboptioncodetitlejoin ) {
					$(this).attr("checked",false);
					for (var i=0;i<goodssuboptioncodetitlear.length;i++){
						if(!goodssuboptioncodetitlear[i]) continue;
						if( goodssuboptioncodetitlear[i] == $(this).val() ) {
							$(this).attr("checked",true);
							break;
						}
					}
				}else if( !goodssuboptioncodetitlejoin && $(this).attr("default") == 'checked' ) {
					$(this).attr("checked",true);
				}else{
					$(this).attr("checked",false);
				}
			});

			if(label_newtype == 'address'){
				openDialog(label_title, layerid, {"width":"800","height":"400","show" : "fade","hide" : "fade"});
			}else if(label_newtype == 'dayinput'  || label_newtype == 'dayauto' ){
				openDialog(label_title, layerid, {"width":"550","height":"400","show" : "fade","hide" : "fade"});
			}else{
				openDialog(label_title, layerid, {"width":"300","height":"400","show" : "fade","hide" : "fade"});
			}
		});

		/* 옵션 >> 추가코드선택 후 적용하기 */
		$(".GoodsSubOptionCodeApply").live("click",function(){
			var codeform_seq = $(this).attr("codeform_seq");
			var label_type = $(this).attr("label_type");
			var label_newtype = $(this).attr("label_newtype");
			var label_id = $(this).attr("label_id");
			var layer_id = $(this).attr("layer_id");

			var gdsuboptcodeval = new Array();
			var gdsuboptcodetitle = new Array();

			var gdsuboptcolor = new Array();
			var gdsuboptzipcode = new Array();
			var gdsuboptaddress = new Array();
			var gdsuboptaddressdetail = new Array();

			var biztel = new Array();
			var codedate = new Array();
			var sdayinput = new Array();
			var fdayinput = new Array();
			var dayautotype = new Array();
			var sdayauto = new Array();
			var fdayauto = new Array();
			var dayautoday = new Array();

			$(this).parents("tr").parent().find("input[name='goodssuboption[]']").each(function(i){
				if ( $(this).is(':checked') == true  ) {
					gdsuboptcodeval.push($(this).val());//code
					gdsuboptcodetitle.push($(this).attr("label_value"));

					gdsuboptcolor.push($(this).attr("label_color"));
					gdsuboptzipcode.push($(this).attr("label_zipcode"));
					gdsuboptaddress.push($(this).attr("label_address"));
					gdsuboptaddressdetail.push($(this).attr("label_addressdetail"));

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

			var gdsuboptcodevaljoin = gdsuboptcodeval.join(',');
			var gdsuboptcodetitlejoin = gdsuboptcodetitle.join(',');

			var gdsuboptcolorjoin = gdsuboptcolor.join(',');
			var gdsuboptzipcodejoin = gdsuboptzipcode.join(',');
			var gdsuboptaddressjoin = gdsuboptaddress.join(',');
			var gdsuboptaddressdetailjoin = gdsuboptaddressdetail.join(',');

			var bizteljoin = biztel.join(',');
			var codedatejoin = codedate.join(',');
			var sdayinputjoin = sdayinput.join(',');
			var fdayinputjoin = fdayinput.join(',');
			var dayautotypejoin = dayautotype.join(',');
			var sdayautojoin = sdayauto.join(',');
			var fdayautojoin = fdayauto.join(',');
			var dayautodayjoin = dayautoday.join(',');

			var gdsuboptidx = $(this).parents("table").find(".gdsuboptidx").val();

			$("div#subOptDialog input[name='suboptionMakeType[]']").eq(gdsuboptidx).val(label_type);
			$("div#subOptDialog input[name='suboptionMakeCode[]']").eq(gdsuboptidx).val(gdsuboptcodevaljoin);

			$("div#subOptDialog input[name='suboptionMakenewtype[]']").eq(gdsuboptidx).val(label_newtype);
			$("div#subOptDialog input[name='suboptionMakecolor[]']").eq(gdsuboptidx).val(gdsuboptcolorjoin);
			$("div#subOptDialog input[name='suboptionMakezipcode[]']").eq(gdsuboptidx).val(gdsuboptzipcodejoin);
			$("div#subOptDialog input[name='suboptionMakeaddress[]']").eq(gdsuboptidx).val(gdsuboptaddressjoin);
			$("div#subOptDialog input[name='suboptionMakeaddressdetail[]']").eq(gdsuboptidx).val(gdsuboptaddressdetailjoin);

			$("div#subOptDialog input[name='suboptionMakebiztel[]']").eq(gdsuboptidx).val(bizteljoin);
			$("div#subOptDialog input[name='suboptionMakecodedate[]']").eq(gdsuboptidx).val(codedatejoin);
			$("div#subOptDialog input[name='suboptionMakesdayinput[]']").eq(gdsuboptidx).val(sdayinputjoin);
			$("div#subOptDialog input[name='suboptionMakefdayinput[]']").eq(gdsuboptidx).val(fdayinputjoin);
			$("div#subOptDialog select[name='suboptionMakedayauto_type[]'] option[value='"+dayautotypejoin+"']").eq(gdsuboptidx).attr("selected",true);
			$("div#subOptDialog input[name='suboptionMakesdayauto[]']").eq(gdsuboptidx).val(sdayautojoin);
			$("div#subOptDialog input[name='suboptionMakefdayauto[]']").eq(gdsuboptidx).val(fdayautojoin);
			$("div#subOptDialog select[name='suboptionMakedayauto_day[]'] option[value='"+dayautodayjoin+"']").eq(gdsuboptidx).attr("selected",true);

			$("div#subOptDialog input[name='suboptionMakeValue[]']").eq(gdsuboptidx).val(gdsuboptcodetitlejoin);
			//$("div#subOptDialog input[name='suboptionMakeValue[]']").eq(gdsuboptidx).attr("readonly",true);
			$("div#subOptDialog input[name='suboptionMakeValue[]']").eq(gdsuboptidx).show();

			var obj = $("div#subOptDialog input[name='suboptionMakePrice[]']").eq(gdsuboptidx);
			var sArr = gdsuboptcodetitlejoin.split(',');
			var tArr = new Array();
			for(var i = 0;i<sArr.length;i++){
				tArr.push(0);
			}
			obj.val(tArr.join(','));

			if( label_newtype == 'dayauto' ) {
				socialcpdayautoreview( $("div#subOptDialog div.suboptionMakenewdayauto").eq(gdsuboptidx) );
			}


			closeDialog(layer_id);
		});

		/* 옵션만들기 초기가격 넣기*/
		$("div#subOptDialog input[name='suboptionMakeValue[]']").live("blur",function(){
			var tmp = optReplace($(this).val());
			if	(tmp){
				$(this).val(tmp);

				var obj = $(this).parents("tr").find("input[name='suboptionMakePrice[]']");
				var sArr = $(this).val().split(',');
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
		});

		/* 옵션가격 일괄 적용 */
		$("button#suboptionBatch").bind("click",function(){
			batch_suboption_price();
			calulate_subOption_price();
		});


		$("#btn_goods_option_list").live("click",function(){
			openDialog("옵션정보 가져오기", "option_newlist", {"width":"800","height":"880","show" : "fade","hide" : "fade"});
		});

		$("#btn_goods_special_list").live("click",function(){
			openDialog("특수 정보 활용 안내", "special_newlist", {"width":"760","height":"816","show" : "fade","hide" : "fade"});
		});

		// 자주사용하는 옵션 가져오기
		$("#frequentlytypesuboptbtn").live("click",function(){
			var add_goods_seq = $("select[name='frequentlytypesubopt']").find("option:selected").val();
			if( add_goods_seq<=0 ){
				alert("옵션정보를 가져올 상품을 선택해 주세요!");
				return false;
			}

			var goods_name = $("select[name='frequentlytypesubopt']").find("option:selected").text();
			openDialogConfirm('정말로  ['+goods_name+'] 상품의 <br/>추가구성옵션 정보를 가져오시겠습니까?',400,200,function() {
				opener.openSettingSubOptionnew(add_goods_seq);
			});
		});

		$("input[name='optionValue']").live("blur", function(){
			var valStr		= $(this).val();
			if	(valStr){
				var priceStr	= valStr.replace(/[^,]*/ig, '0');
				priceStr		= priceStr.replace(/[0]{2,}/g, '0');
				$("input[name='optionPrice']").val(priceStr);
			}
		});
		//<----------------- 옵션 세로로 추가

<?php if($TPL_VAR["reload"]=='y'){?>
		location.replace('?provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&tmp_seq=<?php echo $TPL_VAR["tmp_seq"]?>&sub_tmp_policy=<?php echo $TPL_VAR["sub_tmp_policy"]?>&goodsTax=<?php echo $TPL_VAR["goodsTax"]?>&goods_seq=<?php echo $TPL_VAR["goods_seq"]?>&socialcp_input_type=<?php echo $_GET["socialcp_input_type"]?>&package_yn=<?php echo $_GET["package_yn"]?>');
<?php }?>


		//수정불가
		$(".input-box-default-text-code").live('keydown change focusin selectstart',function(){
			$(this).blur();
			return false;
		});

		//옵션 생성하기 버튼
		$("#gdsuboptioncodemakebtn").live("click", function() {
			var optName = new Array();
			var optionType = new Array();
			var optValue = new Array();
			var tmp;

			$("#subOptDialog table tbody tr").each(function(idx){
				optionType[idx] = $(this).find("select[name='suboptionMakeId[]'] option:selected").val();

				tmp = $(this).find("input[name='suboptionMakeName[]']").val();
				if( tmp == $(this).find("input[name='suboptionMakeName[]']").attr("title") ){
					optName = new Array();
					return false;
				}else{
					optName[idx] = tmp.split(',');
				}

				tmp = $(this).find("input[name='suboptionMakeValue[]']").val();
				if( tmp == $(this).find("input[name='suboptionMakeValue[]']").attr("title") ){
					optValue = new Array();
					return false;
				}else{
					optValue[idx] = tmp.split(',');
				}

			});

			if(optName.length<1){
				openDialogAlert("추가 옵션명을 정확히 입력해주세요.",400,140,function(){
					$("#subOptDialog input[name='suboptionMakeName[]']").filter(function(){
						return $(this).val().length==0;
					}).eq(0).focus();
				});
				return false;
			}

			if(optValue.length<1){
				openDialogAlert("추가 옵션명을 정확히 입력해주세요.",400,140,function(){
					$("#subOptDialog input[name='suboptionMakeValue[]']").filter(function(){
						return $(this).val().length==0;
					}).eq(0).focus();
				});
						return false;
			}

			/* 옵션명 공백 체크 */
			for(var i=0;i<optName.length;i++){
				for(var j=0;j<optName[i].length;j++){
					if(optName[i][j].length==0) {
						openDialogAlert("추가 옵션명을 입력해주세요.",400,140,function(){
							$("#subOptDialog input[name='suboptionMakeName[]']").filter(function(){
								return $(this).val().length==0;
							}).eq(0).focus();
						});
						return false;
					}
				}
			}

			/* 옵션값 공백 체크 */
			for(var i=0;i<optValue.length;i++){
				for(var j=0;j<optValue[i].length;j++){
					if(optValue[i][j].length==0) {
						openDialogAlert("추가 옵션값을 입력해주세요.",400,140,function(){
							$("#subOptDialog input[name='suboptionMakeValue[]']").filter(function(){
								return $(this).val().length==0;
							}).eq(0).focus();
						});
						return false;
					}
				}
			}

			$("#suboptionMakeForm").submit();
		});

		//직접입력 > 색상
		$(".colorhelpicon").live("click",function(){
			if($(this).attr("opttype") ){
				$("#gdoptdirectmodifylay input").val();
				var opttblobj = $(this).parents("tr");
				var opttblidx = opttblobj.index();
				$("#goodsoptiondirectmodifybtn").attr("opttblidx",opttblidx);
				$("#goodsoptiondirectmodifybtn").attr("newtype","color");
				$("#gdoptdirectmodifylay div.goodsoptiondirectlay").hide();
				$("#gdoptdirectmodifylay div.colordateaddresslay").show();
				$("#gdoptdirectmodifylay div.colorlay").show();
				$("#gdoptdirectmodifylay div.datelay").hide();
				$("#gdoptdirectmodifylay div.addresslay").hide();
				$($("#gdoptdirectmodifylay input[name='direct_color']")).customColorPicker("destroy");
				$("#gdoptdirectmodifylay input[name='direct_color']").val(opttblobj.find("input[name='suboptcolor[]']").val());
				$($("#gdoptdirectmodifylay input[name='direct_color']")).customColorPicker();
				//helpicon_style();
				openDialog("색상 변경", "gdoptdirectmodifylay", {"width":"450","height":"300","show" : "fade","hide" : "fade"});
			}
		});

		//직접입력 > 지역
		$(".addrhelpicon").live("click",function(){
			if($(this).attr("opttype")){
				$("#gdoptdirectmodifylay input").val();
				var opttblobj = $(this).parents("tr");
				var opttblidx = opttblobj.index();
				$("#goodsoptiondirectmodifybtn").attr("opttblidx",opttblidx);
				$("#goodsoptiondirectmodifybtn").attr("newtype","address");
				$("#gdoptdirectmodifylay div.goodsoptiondirectlay").hide();
				$("#gdoptdirectmodifylay div.colordateaddresslay").show();
				$("#gdoptdirectmodifylay div.addresslay").show();
				$("#gdoptdirectmodifylay div.colorlay").hide();
				$("#gdoptdirectmodifylay div.datelay").hide();
				var zipcode = new Array()
				zipcode = opttblobj.find("input[name='suboptzipcode[]']").val().split("-");
				$("#gdoptdirectmodifylay input.direct_zipcode1").val(zipcode[0]);
				$("#gdoptdirectmodifylay input.direct_zipcode2").val(zipcode[1]);
				$("#gdoptdirectmodifylay input[name='direct_address']").val(opttblobj.find("input[name='suboptaddress[]']").val());
				$("#gdoptdirectmodifylay input[name='direct_addressdetail']").val(opttblobj.find("input[name='suboptaddressdetail[]']").val());
				$("#gdoptdirectmodifylay input[name='direct_biztel']").val(opttblobj.find("input[name='suboptbiztel[]']").val());
				//helpicon_style();
				openDialog("지역 변경", "gdoptdirectmodifylay", {"width":"450","height":"300","show" : "fade","hide" : "fade"});
			}
		});
		//직접입력 > 날짜
		$(".codedatehelpicon").live("click",function(){
			if($(this).attr("opttype")){
				$("#gdoptdirectmodifylay input").val();
				var opttblobj = $(this).parents("tr");
				var opttblidx = opttblobj.index();
				$("#goodsoptiondirectmodifybtn").attr("opttblidx",opttblidx);
				$("#goodsoptiondirectmodifybtn").attr("newtype","date");
				$("#gdoptdirectmodifylay div.goodsoptiondirectlay").hide();
				$("#gdoptdirectmodifylay div.colordateaddresslay").show();
				$("#gdoptdirectmodifylay div.datelay").show();
				$("#gdoptdirectmodifylay div.colorlay").hide();
				$("#gdoptdirectmodifylay div.addresslay").hide();
				$("#gdoptdirectmodifylay input[name='direct_codedate']").val(opttblobj.find("input[name='codedate[]']").val());
				//helpicon_style();
				openDialog("날짜 변경", "gdoptdirectmodifylay", {"width":"450","height":"300","show" : "fade","hide" : "fade"});
			}
		});
		//직접입력 > 수동기간
		$(".dayinputhelpicon").live("click",function(){
			if($(this).attr("opttype")){
				var opttblobj = $(this).parents("tr");
				var opttblidx = opttblobj.index();
				$("#goodsoptiondirectmodifybtn").attr("opttblidx",opttblidx);
				$("#goodsoptiondirectmodifybtn").attr("newtype","dayinput");
				$("#gdoptdirectmodifylay div.goodsoptiondirectlay").hide();
				$("#gdoptdirectmodifylay div.colordateaddresslay").hide();
				$("#gdoptdirectmodifylay div.dayinputlay").show();
				openDialog("수동기간 변경", "gdoptdirectmodifylay", {"width":"350","height":"150","show" : "fade","hide" : "fade"});
			}
		});
		//직접입력 > 자동기간
		$(".dayautohelpicon").live("click",function(){
			if($(this).attr("opttype") ){
				var opttblobj = $(this).parents("tr");
				var opttblidx = opttblobj.index();
				$("#goodsoptiondirectmodifybtn").attr("opttblidx",opttblidx);
				$("#goodsoptiondirectmodifybtn").attr("newtype","dayauto");
				$("#gdoptdirectmodifylay div.goodsoptiondirectlay").hide();
				$("#gdoptdirectmodifylay div.colordateaddresslay").hide();
				$("#gdoptdirectmodifylay div.dayautolay").show();
				openDialog("자동기간 변경", "gdoptdirectmodifylay", {"width":"350","height":"150","show" : "fade","hide" : "fade"});
			}
		});

		//직접입력 개별수정버튼클릭시
		$("#goodsoptiondirectmodifybtn").live("click",function(){
			var newtype = $(this).attr("newtype");
			var opttblidx = $(this).attr("opttblidx");
			goodsoptiondirectmodify(opttblidx, newtype);
		});


		// 우편번호 검색
		$(".direct_zipcode_btn").live("click",function(){
			openDialogZipcode('direct_');
		});

		$("div#subOptDialog select.suboptionMakedayauto_type").live("change",function(){
			if( $(this).find("option:selected").val() == 'day' ) {
				var suboptionMakenewdayautolaytitle = "이후";
			}else{
				var suboptionMakenewdayautolaytitle = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			$(this).parent().find(".suboptionMakenewdayautolaytitle").html(suboptionMakenewdayautolaytitle);
			socialcpdayautoreview($(this).parents("div.suboptionMakenewdayauto"));
		});

		$("div#subOptDialog select.suboptionMakedayauto_day").live("change",function(){
			socialcpdayautoreview($(this).parents("div.suboptionMakenewdayauto"));
		});

		//자동기간 예시 미리보기
		$("div#subOptDialog span.optionMakenewdayautolayrealdateBtn").live("click",function() {
			socialcpdayautoreview( $(this).parents("div.suboptionMakenewdayauto") );
		});

<?php if(!$TPL_VAR["suboptions"]){?>
			$("#frequentlay").hide();
<?php }?>

		/* 재고조정 기능 사용시 매입가, 재고수량 수정 차단*/
<?php if($TPL_VAR["provider_seq"]=='1'&&$TPL_VAR["cfg_goods"]["stock_history_use"]){?>
			/**
			$("input[name='supplyPrice[]'], input[name='stock[]']").live('keydown change focusin selectstart',function(){
				alert('[재고조정하기] 기능을 이용해 주세요!');
				$(this).blur();
				return false;
			});
			$("input[name='subSupplyPrice[]'], input[name='subStock[]']").live('keydown change focusin selectstart',function(){
				alert('[재고조정하기] 기능을 이용해 주세요!');
				$(this).blur();
				return false;
			});
			**/
<?php }?>

		$('.save_all').click(function(){
			var baseId	= $(this).attr('id');
			var target	= $(this).attr('target');
			$('.' + target).val($('.' + baseId).val()).trigger('blur');
		});

		$('.applyAllCommission').click(function(){
			$('.subCommissionType').val($('.subCommissionType_all').val());
			$('.subCommissionRate').val($('.subCommissionRate_all').val()).trigger('blur');
		});

		$('.applyAllReserve').click(function() {
			$('.subReserveUnit').val($('.subReserveUnit_all').val());
			$('.subReserveRate').val($('.subReserveRate_all').val()).trigger('blur');
		});

		$("input[name='subCommissionRate[]']").live("change",function(){
			var float_cnt	= this.value.match(/\.[0-9]+/g);
			if(float_cnt > 0 && float_cnt.toString().length > 3){
				alert('소숫점 2자리까지 가능합니다.(2자리 초과 절삭)');
			}
			var charge		= Math.floor(this.value * 100) / 100;
			this.value		= charge;
		});

		$('select[name="subReservePolicy"]').change(function(){chgSubReservePolicy()});
		
		var optionStockSetText	= opener.setOptionStockSetText();
		$('.optionStockSetText').html(optionStockSetText);
		
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


	//특수옵션 > 자동기간 미리보기
	function socialcpdayautoreview(opttblobj) {
		opttblobj.find(".optionMakenewdayautolayrealdate").html('');
		var dayauto_type = 'month';
		dayauto_type = opttblobj.find(".suboptionMakedayauto_type option:selected").val();

		var sdayauto = '0';
		sdayauto = opttblobj.find(".optionMakesdayauto").val();

		var fdayauto = '0';
		fdayauto = opttblobj.find(".optionMakefdayauto").val();

		var dayauto_day = 'day';
		dayauto_day = opttblobj.find(".suboptionMakedayauto_day option:selected").val();

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

	//
	function socialcpinputtype() {
<?php if($_GET["socialcp_input_type"]){?>
		var socialcp_input_type = '<?php echo $_GET["socialcp_input_type"]?>';
<?php }else{?>
			var socialcp_input_type = $("input[name='socialcp_input_type']:checked", window.opener.document).val();
<?php }?>

		if(socialcp_input_type) {
			var couponinputsubtitle = '';
			$(".couponinputtitle").show();
			if( socialcp_input_type == 'price' ) {
				couponinputsubtitle = '금액';
			}else{
				couponinputsubtitle = '횟수';
			}
			$("#socialcpuseopen").val(socialcp_input_type);
			$(".couponinputsubtitle").text(couponinputsubtitle);
		}

		//과세/부가세 체크
<?php if($_GET["goodsTax"]){?>
		var goodsTax = '<?php echo $_GET["goodsTax"]?>';
<?php }else{?>
			var goodsTax = $("input[name='tax']:checked", window.opener.document).val();
<?php }?>
		$(".goodsTax").val(goodsTax);

	}

	function helpicon_style(){
		/* 툴팁 */
		$(".helpicon, .help").each(function(){

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

	//직접입력 > 개별수정레이어창에서 수정하기
	function goodsoptiondirectmodify(opttblidx, newtype) {
		var opttblobj = $("div#suboptionLayer tr.suboptionTr").eq(opttblidx);
		switch(newtype){
			case "color":
				var optcolor = $("#gdoptdirectmodifylay input[name='direct_color']").val();
				opttblobj.find("input[name='suboptcolor[]']").val(optcolor);
				opttblobj.find("div.colorhelpicon").css("background-color",optcolor);
				opttblobj.find("div.colorhelpicon").attr("title", "[색상]을 클릭하여 변경할 수 있습니다.");
				$(opttblobj.find("div.colorhelpicon")).customColorPicker(optcolor);
			break;
			case "address":
				var direct_zipcode1 = $("#gdoptdirectmodifylay input.direct_zipcode1").val();
				var direct_zipcode2 = $("#gdoptdirectmodifylay input.direct_zipcode2").val();
				var optaddress = $("#gdoptdirectmodifylay input[name='direct_address']").val();
				var optaddressdetail = $("#gdoptdirectmodifylay input[name='direct_addressdetail']").val();
				var optbiztel = $("#gdoptdirectmodifylay input[name='direct_biztel']").val();
				opttblobj.find("input[name='suboptaddressdetail[]']").val(optaddressdetail);
				opttblobj.find("input[name='suboptbiztel[]']").val(optbiztel);
				opttblobj.find("input[name='suboptaddress[]']").val(optaddress);
				opttblobj.find("input[name='suboptzipcode[]']").val(direct_zipcode1+"-"+direct_zipcode2);
				opttblobj.find("span.addrhelpicon").attr("title","["+direct_zipcode1+"-"+direct_zipcode2+"] "+optaddress +" "+ optaddressdetail + " 업체 연락처:"+ optbiztel +"<br/>[지역]을 클릭하여 변경할 수 있습니다.");
			break;
			case "date":
				var codedate = $("#gdoptdirectmodifylay input[name='direct_codedate']").val();
				opttblobj.find("input[name='codedate[]']").val(codedate);
				opttblobj.find("span.codedatehelpicon").attr("title",codedate + "<br/>[날짜]를 클릭하여 변경할 수 있습니다.");
			break;
		}
		helpicon_style();
		closeDialog("gdoptdirectmodifylay");
	}

	//옵션 >> 직접입력시 초기화
	function goodssuboptiondirectdefault(objparent) {
		objparent.find("input[name='suboptionMakeName[]']").removeClass("input-box-default-text-code");
		objparent.find("input[name='suboptionMakeValue[]']").removeClass("input-box-default-text-code");
		//objparent.find("input[name='suboptionMakeName[]']").val('');
		//objparent.find("input[name='suboptionMakeCode[]']").val('');
		//objparent.find("input[name='suboptionMakeValue[]']").val('');
		//objparent.find("input[name='suboptionMakePrice[]']").val('');

		objparent.find("input[name='suboptionMakeName[]']").val('예) 사이즈').attr("title","예) 사이즈");
		objparent.find("input[name='suboptionMakeValue[]']").val('예) 90, 95, 100').attr("title","예) 90, 95, 100");
		objparent.find("input[name='suboptionMakeCode[]']").val('');
		objparent.find("input[name='suboptionMakePrice[]']").val('0,0,0').attr("title","0,0,0");

		objparent.find("input[name='suboptionMakenewtype[]']").val('');
		objparent.find("input[name='suboptionMakecolor[]']").val('');
		objparent.find("input[name='suboptionMakezipcode[]']").val('');
		objparent.find("input[name='suboptionMakeaddress[]']").val('');
		objparent.find("input[name='suboptionMakeaddressdetail[]']").val('');

		objparent.find("input[name='suboptionMakebiztel[]']").val('');
		objparent.find("input[name='suboptionMakesdayinput[]']").val('');
		objparent.find("input[name='suboptionMakefdayinput[]']").val('');
		objparent.find("input[name='suboptionMakedayauto_type[]'] option[value='']").attr("selected",true);
		objparent.find("input[name='suboptionMakesdayauto[]']").val('');
		objparent.find("input[name='suboptionMakefdayauto[]']").val('');
		objparent.find("input[name='suboptionMakedayauto_day[]'] option[value='']").attr("selected",true);

		objparent.find("input[name='suboptionMakeValue[]']").removeAttr("readonly");
		objparent.find("input[name='suboptionMakeName[]']").removeAttr("readonly");
		objparent.find("select[name='suboptionMakespecial[]']").removeAttr("disabled");
		objparent.find("select[name='suboptionMakespecial[]']").removeAttr("readonly");
		objparent.find("select[name='suboptionMakespecial[]'] option[value='']").attr("selected",true);
		objparent.find("input[name='suboptionMakeName[]']").show();
		objparent.find("input[name='suboptionMakeValue[]']").show();

		objparent.find(".suboptionMakeSpecial").hide();
		objparent.find(".suboptionMakeSpecialsub").hide();
		//objparent.find(".suboptionMakelayout").show();
	}

	//옵션정보 가져오기시 중복체크
	function goodssuboptionspecialselect(obj, objparent) {
		var parentidx = objparent.index();//현재위치
		var goodsoptionspecialdate = 0;
		var goodsoptionspecial = 0;
		var label_newtype = obj.find("option:selected").attr("label_newtype");
		var optionMakeIdval = obj.find("option:selected").val();
		var label_newtype_length = objparent.parent().find("select[name='suboptionMakespecial[]']").length;

		if( label_newtype_length > 1 ) {
			objparent.parent().find("select[name='suboptionMakespecial[]']").each( function() {
				var selidx = $(this).parents("tr").index();//alert(parentidx + "-->" + selidx);//
				if( parentidx != selidx && $(this).val() ) {
					if( $(this).find("option:selected") ) {
						if( label_newtype == $(this).val() )  goodsoptionspecial++;//중복불가

						if( $(this).val() == 'date' ||  $(this).val() == 'dayauto'  ||  $(this).val() == 'dayinput' )goodsoptionspecialdate++;
					}
				}
			});
		}

		objparent.find("input[name='suboptionMakeValue[]']").val('').attr("title","");
		objparent.find("input[name='suboptionMakePrice[]']").val('').attr("title","");

		objparent.find(".suboptionMakeSpecial").hide();
		objparent.find(".suboptionMakeSpecialsub").hide();
		//objparent.find(".suboptionMakelayout").show();

		var label_newtype = obj.find("option:selected").attr("label_newtype");
		//objparent.find("input[name='suboptionMakeName[]']").addClass("input-box-default-text-code");
		//objparent.find("input[name='suboptionMakeValue[]']").addClass("input-box-default-text-code");
		objparent.find("input[name='suboptionMakeName[]']").val(obj.children("option:selected").attr("label_title"));
		//objparent.find("input[name='suboptionMakeName[]']").attr("readonly",true);
		objparent.find("select[name='suboptionMakespecial[]']").attr("disabled",true);
		objparent.find("input[name='suboptionMakeValue[]']").hide();

		if( label_newtype != 'none') {
			objparent.find("select[name='suboptionMakespecial[]'] option[value='"+label_newtype+"']").attr("selected",true);
		}else{
			objparent.find("select[name='suboptionMakespecial[]'] option[value='']").attr("selected",true);
		}

		if(label_newtype) {
			objparent.find(".suboptionMakeSpecial").show();
			objparent.find(".suboptionMakeSpecialsub").hide();
			switch(label_newtype){
				case 'color':			objparent.find(".suboptionMakeColor").show();break;
				case 'address':		objparent.find(".suboptionMakeaddress").show();break;
				case 'date':			objparent.find(".suboptionMakedate").show();break;
				case 'dayinput':	objparent.find(".suboptionMakedayinput").show();break;
				case 'dayauto':	objparent.find(".suboptionMakenewdayauto").show();break;
			}
		}else{
			objparent.find(".suboptionMakeSpecial").hide();
			objparent.find(".suboptionMakeSpecialsub").hide();
		}
		setDefaultText();
		setDatepicker();


		return true;
	}
	//옵션 > 직접입력 >> 특수정보 선택시
	function goodssuboptionspecialform(obj, objparent) {
		var parentidx = objparent.index();//현재위치
		var specialform = obj.val();
		var goodsoptionspecial = 0;
		var goodsoptionspecialdate = 0;
		var label_newtype = specialform;
		var label_newtype_length = objparent.parent().find("select[name='suboptionMakespecial[]']").length;
		if( label_newtype_length > 1 ) {
			objparent.parent().find("select[name='suboptionMakespecial[]']").each( function() {
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
		objparent.find("input[name='suboptionMakeValue[]']").val("").attr("title","");
		objparent.find("input[name='suboptionMakeCode[]']").val('');
		if( specialform == 'date' ) {
			valuetitle = "예) 12월 31일 20시 공연";
			objparent.find("input[name='suboptionMakeName[]']").val('예) 공연일시').attr("title","예) 공연일시");
			objparent.find("input[name='suboptionMakePrice[]']").val('0').attr("title","0");
		}
		else if( specialform == 'dayauto' ){
			valuetitle = "사용 기간을 안내 하세요.";
			objparent.find("input[name='suboptionMakeName[]']").val('예) 사용기간').attr("title","예) 사용기간");
			objparent.find("input[name='suboptionMakePrice[]']").val('0').attr("title","0");
		}
		else if( specialform == 'dayinput' ){
			valuetitle = "사용 기간을 안내 하세요.";
			objparent.find("input[name='suboptionMakeName[]']").val('예) 사용기간').attr("title","예) 사용기간");
			objparent.find("input[name='suboptionMakePrice[]']").val('0').attr("title","0");
		}
		else if( specialform == 'color' ){
			valuetitle = "예) 블랙, 화이트, 그레이";
			objparent.find("input[name='suboptionMakeName[]']").val('예) 색상').attr("title","예) 색상");
			objparent.find("input[name='suboptionMakePrice[]']").val('0,0,0').attr("title","0,0,0");
		}
		else if( specialform == 'address' ){
			valuetitle = "예) 분당점, 삼평점, 판교점";
			objparent.find("input[name='suboptionMakeName[]']").val('예) 사용지점').attr("title","예) 사용지점");
			objparent.find("input[name='suboptionMakePrice[]']").val('0,0,0').attr("title","0,0,0");
		}else{
			objparent.find("input[name='suboptionMakeName[]']").val('예) 사이즈').attr("title","예) 사이즈");
			objparent.find("input[name='suboptionMakePrice[]']").val('0,0,0').attr("title","0,0,0");
		}

		objparent.find("input[name='suboptionMakeValue[]']").val(valuetitle);
		objparent.find("input[name='suboptionMakeValue[]']").attr("title",valuetitle);

		if(specialform){
			objparent.find(".suboptionMakeSpecial").show();
			objparent.find(".suboptionMakeSpecialsub").hide();
			//objparent.find(".suboptionMakelayout").hide();
			switch(specialform){
				case 'color':			objparent.find(".suboptionMakeColor").show();break;
				case 'address':		objparent.find(".suboptionMakeaddress").show();break;
				case 'date':			objparent.find(".suboptionMakedate").show();break;
				case 'dayinput':	objparent.find(".suboptionMakedayinput").show();break;
				case 'dayauto':	objparent.find(".suboptionMakenewdayauto").show();break;
			}
			objparent.find("input[name='suboptionMakenewtype[]']").val(specialform);
			setDefaultText();
			setDatepicker();
		}else{
			objparent.find("input[name='suboptionMakenewtype[]']").val('');
			objparent.find(".suboptionMakeSpecial").hide();
			objparent.find(".suboptionMakeSpecialsub").hide();
			objparent.find("select[name='suboptionMakeId[]'] option[value='direct']").attr("selected",true);
			//objparent.find(".suboptionMakelayout").show();
			return;
		}
	}

	//옵션 >> 옵션코드추가
	function goodssuboptioncode(obj){
		obj.parent().parent().find(".goodssuboptionlay").hide();
		obj.parent().parent().find(".etcContents").show();
		obj.parent().parent().find(".suboptionMakeType").val('');
		var selectecttitle = obj.find("option:selected").val();
		if(  selectecttitle.substr(0,14) == 'goodssuboption'){
			obj.parent().parent().find(".suboptionMakeType").val(selectecttitle);
			obj.parent().parent().find(".goodssuboptionlay").show();
			obj.parent().parent().find(".goodssuboptionsublay").hide();
			obj.parent().parent().find(".etcContents").hide();
			obj.parent().parent().find("."+selectecttitle).show();
		}
	}

	/* 컬러피커 */
	function colorpickerlay(){
		$(".colorpicker").customColorPicker();
	}

	function optReplace(str){
		var tmp = "";
		tmp = str.replace(/\"/gi, "");
		return tmp;
	}



	function calculrate_reserve(idx){
		var price			= $("input[name='subPrice[]']").eq(idx).val();
		var reserve_rate	= $("input[name='subReserveRate[]']").eq(idx).val();
		var reserve_unit	= $("select[name='subReserveUnit[]'] option:selected").eq(idx).val();
		var reserve			= reserve_rate;
		if	(reserve_unit == 'percent')
			reserve			= Math.floor(price * (reserve_rate * 0.01));


		$('.subReserve').eq(idx).html(reserve);
		$('.reserve-shop').eq(idx).html(reserve);

	}

	function setTmpSeq(){
		var tmp_frequently		= ($("input[name='frequently']:checked")) ? $("input[name='frequently']:checked").val() : 0;
		var subReservePolicy	= ($('select[name="subReservePolicy"]').val() == 'goods') ? 'goods' : 'shop';
		opener.setSubOptionTmp('<?php echo $TPL_VAR["tmp_seq"]?>', tmp_frequently, subReservePolicy);
		self.close();
	}

	function apply_suboption(){
		var suboptionTitle = $.trim($("input[name='suboptTitle[]']'").val());
		if(!suboptionTitle){
			alert('옵션명을 입력 해 주세요.');
			return false;
		}
		
		$("form[name='listFrm']").submit();
	}


	function chgSubReservePolicy() {
		if ($('select[name="subReservePolicy"]').val() == 'goods') {
			var disabledType	= false;
			$('.subReserve_all').show();
			$('.reserve-shop-lay').hide();
			$('.reserve-goods-lay').show();
		} else {
			var disabledType	= true;
			$('.subReserve_all').hide();
			$('.reserve-shop-lay').show();
			$('.reserve-goods-lay').hide();
		}
		
		$('.subReserveRate, .subReserveUnit, .subReserve').attr('disabled', disabledType)
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
<style type="text/css">
	body {overflow-x:hidden;}
	.input-box-default-text-code {border:1px solid #ccc; background-color:#f6f6f6; color:#999 !important;}
	.input-box-default-text-code option {background-color:#f6f6f6; color:#999; }
	.top_title	{width:100%;background:url('/admin/skin/default/images/design/win_tbl_thbg.gif') repeat-x;font-weight:bold;font-size:15px;padding:6px 0;padding-left:20px;color:#747474;}
	.top_title_memo {line-height:25px;border-bottom:1px solid #000;margin-bottom:10px;}
	.top_btn_area	{margin:5px 0;}
	.pricetd		{background-color:#ffffcc;}
	.pricetd input	{color:red;}
	div.package_error {
		color:#f00f00;
		letter-spacing : -1px;
		font-size : 11px;
	}
</style>

<?php if($TPL_VAR["provider_seq"]=='1'&&$TPL_VAR["cfg_goods"]["stock_history_use"]){?>
<!--
<style>
	input[name='commissionRate[]'], input[name='supplyPrice[]'], input[name='stock[]'],
	input[name='subCommissionRate[]'], input[name='subSupplyPrice[]'], input[name='subStock[]'] {border:1px solid #ccc; background-color:#f6f6f6; color:#999 !important;}
</style>
-->
<?php }?>

<div class="top_title">추가구성옵션</div>
<div style="width:99%;padding:10px;">
	<div id="suboptionLayer">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
			<input type="hidden" name="use_warehouse" value="|<?php echo implode('|',array_keys($TPL_VAR["scm_cfg"]['use_warehouse']))?>|" />
<?php }?>
		<div class="top_title_memo">
			<span class="bold">가져오기</span> :
			다른 상품의 필수옵션 정보를 가져와서 해당 상품의 추가구성옵션을 등록 할 수 있습니다.
			<br/>
			<span class="btn small cyanblue"><button type="button">생성 및 변경</button></span> :
			해당 상품의 추가구성옵션을 등록 할 수 있습니다. 또한 미리 등록된 옵션정보로 모든 상품의 옵션정보를 통일성 있게 등록 할 수도 있습니다.
			<br/>
			<span class="btn-plus"><button type="button"></button></span> <span class="btn-minus"><button type="button"></button></span> &nbsp; : &nbsp;
			해당 상품의 추가구성옵션을 1줄씩 추가 또는 삭제 할 수 있습니다.
<?php if(serviceLimit('H_AD')&&$_GET["provider_seq"]> 1){?>
			<br/>
			<span class="red">이벤트 상품의 수수료율 </span> :
			프로모션/쿠폰 > <span class="bold orange">할인 이벤트</span>에 등록된 해당 이벤트의 수수료 설정에 따릅니다. 이벤트기간의 수수료는 본사와 입점사간 협의를 통하여 결정하십시오.
<?php }?>
		</div>
		<div class="top_btn_area">
			<div class="left" >
				<span id="frequentlytypesuboptlay" ><select name="frequentlytypesubopt" class="frequentlytypesubopt" >
					<option value="0">자주 쓰는 상품의 추가구성옵션 </option>
<?php if($TPL_VAR["frequentlysublistAll"]){?>
<?php if($TPL_frequentlysublistAll_1){foreach($TPL_VAR["frequentlysublistAll"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["goods_seq"]?>"><?php echo strip_tags($TPL_V1["goods_name"])?></option>
<?php }}?>
<?php }?>
				</select>을  <span class="btn small cyanblue"><button type="button" id="frequentlytypesuboptbtn" goods_seq="<?php echo $TPL_VAR["goods_seq"]?>">가져오기</button></span></span>
				또는
				<span class="btn small cyanblue"><button type="button" id="addCellOption" goods_seq="<?php echo $TPL_VAR["goods_seq"]?>">생성 및 변경</button></span>
				<span class="btn small"><button type="button" id="optionSetting">추가구성옵션관리</button></span>
			</div>
			<div class="cboth"></div>
			<div class="right" style="margin-right:0px;margin-top:-20px;">
				<span class="btn small gray"><button type="button" id="suboptionBatch">기준할인가 일괄적용</button></span>
			</div>
		</div>

		<form name="listFrm" method="post" action="../goods_process/save_suboption_tmp" target="suboptionFrame">
		<input type="hidden" name="goods_seq" value="<?php echo $TPL_VAR["goods_seq"]?>" />
		<input type="hidden" name="tmp_seq" value="<?php echo $TPL_VAR["tmp_seq"]?>" />
		<input type="hidden" name="provider_seq" value="<?php echo $_GET["provider_seq"]?>" />
		<input type="hidden" name="goodsTax" class="goodsTax" value="" />
			<table class="info-table-style" style="width:100%;">
			<thead>
			<tr>
				<th class="its-th-align center" colSpan="5"><b>일괄적용 →</b></th>
<?php if($_GET["package_yn"]!='y'){?>
				<th class="its-th-align center">
					<input type="text" size="2" class="weightVal_all" class="onlynumber" value="" />
					<span class="btn small black"><button type="button" class="save_all" id="weightVal_all" target="weightVal">▼</button></span>
				</th>
<?php }?>

<?php if($_GET["package_yn"]=='y'){?>
				<th class="its-th-align center">
					<input type="text" size="5" class="tmp_package_unit_ea1_all" class="onlynumber" value="" />
					<span class="btn small black"><button type="button" class="save_all" id="tmp_package_unit_ea1_all" target="tmp_package_unit_ea1">▼</button></span>
				</th>
<?php }else{?>				
				<th class="its-th-align center">
					<input type="text" size="5" class="subStock_all" class="onlynumber" value="" />
					<span class="btn small black"><button type="button" class="save_all" id="subStock_all" target="subStock">▼</button></span>
				</th>
				<th class="its-th-align center">
					<input type="text" size="5" class="subBadStock_all" class="onlynumber" value="" />
					<span class="btn small black"><button type="button" class="save_all" id="subBadStock_all" target="subBadStock">▼</button></span>
				</th>
				<th class="its-th-align center">
					<input type="text" size="5" class="subSafeStock_all" class="onlynumber" value="" />
					<span class="btn small black"><button type="button" class="save_all" id="subSafeStock_all" target="subSafeStock">▼</button></span>
				</th>
<?php if($TPL_VAR["provider_seq"]== 1){?>
				<th class="its-th-align center">
					<input type="text" size="5" class="subSupplyPrice_all" class="onlynumber" value="" />
					<span class="btn small black"><button type="button" class="save_all" id="subSupplyPrice_all" target="subSupplyPrice">▼</button></span>
				</th>
<?php }?>
<?php }?>
				
<?php if($TPL_VAR["provider_seq"]> 1){?>
				<th class="its-th-align center">
					<input type="text" style="text-align: right;" class="subCommissionRate_all" value="" size="3">

<?php if($TPL_VAR["provider_info"]["commission_type"]=='SACO'||$TPL_VAR["provider_info"]["commission_type"]==''){?>
					<input type="hidden" class="subCommissionType_all" value="SACO" />
<?php }else{?>
					<select class="subCommissionType_all">
						<option value="SUCO" selected>%</option>
						<option value="SUPR" selected><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
					</select>
<?php }?>
					<span class="btn small black"><button type="button" class="applyAllCommission">▼</button></span>
				</th>
<?php }?>

				<th class="its-th-align center">
					<input type="text" class="subConsumerPrice_all" style="color:#000;" class="right line onlyfloat"  size="10" value="" idx="{..index_}" />
					<span class="btn small black"><button type="button" class="save_all" id="subConsumerPrice_all" target="subConsumerPrice">▼</button></span>
					→
					<input type="text" class="subPrice_all" class="right line onlyfloat" size="10" value=""/>
					<span class="btn small black"><button type="button" class="save_all" id="subPrice_all" target="subPrice">▼</button></span>
				</th>
				<th class="its-th-align center">
					<input class="subReserveRate_all subReserve_all <?php if($TPL_VAR["goods"]["sub_reserve_policy"]!='goods'){?>hide<?php }?>" value="" size="3" type="text"/>
					<select class="subReserveUnit_all subReserve_all <?php if($TPL_VAR["goods"]["sub_reserve_policy"]!='goods'){?>hide<?php }?>">
						<option value="percent">%</option>
						<option value="<?php echo $TPL_VAR["config_system"]['basic_currency']?>"><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
					</select>
					<span class="subReserve_all btn small black <?php if($TPL_VAR["goods"]["sub_reserve_policy"]!='goods'){?>hide<?php }?>"><button type="button" class="applyAllReserve">▼</button></span>
				</th>
				<th class="its-th-align center">
					<select class="optionView_all">
						<option value="Y" selected>노출</option>
						<option value="N">미노출</option>
					</select>
					<span class="btn small black"><button type="button" class="save_all" id="optionView_all" target="optionView">▼</button></span>
				</th>
			</tr>
			<tr>
				<th class="its-th-align center" rowSpan="2"></th>
				<th class="its-th-align center" rowSpan="2">추가<br/>혜택</th>
				<th class="its-th-align center" rowSpan="2">선택<br/>필수</th>
				<th class="its-th-align center" rowSpan="2">옵션명</th>
				<th class="its-th-align center" rowSpan="2">옵션값</th>
<?php if($_GET["package_yn"]!='y'){?><th class="its-th-align center" rowSpan="2">무게<br/>(kg)</th><?php }?>
<?php if($_GET["socialcp_input_type"]){?>
				<th class="its-th-align center couponinputtitle" rowspan="2">티켓1장→값어치<br/><span class="couponinputsubtitle"><?php if($_GET["socialcp_input_type"]=='price'){?>금액<?php }else{?>횟수<?php }?></span></th>
<?php }?>
<?php if($_GET["package_yn"]=='y'){?>
			<th class="its-th-align center">
				<div class="pdb5">
				실제 상품
<?php if($TPL_VAR["suboptions"]){?>
				<span class="btn small cyanblue"><button type="button" onclick="package_suboption_make();">검색</button></span>
<?php }?>
				</div>
			</th>
<?php }else{?>
				<th class="its-th-align center" colspan="<?php if($TPL_VAR["provider_seq"]== 1){?>4<?php }else{?>3<?php }?>">
<?php if($TPL_VAR["provider_seq"]== 1){?>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
					<?php echo $TPL_VAR["scm_cfg"]['admin_env_name']?> = <?php echo implode(', ',$TPL_VAR["scm_cfg"]['use_warehouse'])?>

					<input type="hidden" name="use_warehouse" value="|<?php echo implode('|',array_keys($TPL_VAR["scm_cfg"]['use_warehouse']))?>|" />
<?php }else{?>
					기본매장 = 기본창고
<?php }?>
					<span class="helpicon" title="해당 상점(매장)에서 판매 재고로 사용하는 창고 기준의 재고입니다."></span>
<?php }else{?>
					재고: <?php echo $TPL_VAR["provider_info"]["provider_name"]?>

<?php }?>
				</th>
<?php }?>
				<th class="its-th-align center <?php if($_GET["provider_seq"]=='1'){?>hide<?php }?>" rowspan="2">
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
				<th class="its-th-align center" rowspan="2">
					정가 → 판매가
					<span class="goods_required"></span>
					<span class="helpicon" title="정가는 소비자가격이며,<br/>판매가는 할인가격입니다."></span>
				</th>
				<th class="its-th-align center" rowspan="2">
					<select name="subReservePolicy">
						<option value="shop">통합정책</option>
						<option value="goods" <?php if($TPL_VAR["goods"]["sub_reserve_policy"]=='goods'||$TPL_VAR["sub_tmp_policy"]=='goods'){?>selected<?php }?>>개별정책 </option>
					</select><br/>
					지급 캐시
				</th>
				<th class="its-th-align center optionStockSetText" rowspan="2"></th>
			</tr>
			<tr>
<?php if($_GET["package_yn"]=='y'){?>
			<th class="its-th-align center">
				<table width="100%" class="package-suboption-titles" id="package-suboption-title" cellpadding="0" cellspacing="0">
					<tr>
<?php if(is_array($TPL_R1=range( 1,$TPL_VAR["suboption_package_count"]))&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
						<td height="26" width="<?php echo  100/$TPL_VAR["suboption_package_count"]?>%">
						상품<?php if($TPL_VAR["suboption_package_count"]> 1){?><?php echo $TPL_I1+ 1?><?php }?>
						</td>
<?php }}?>
					</tr>
				</table>
			</th>
<?php }else{?>
				<th class="its-th-align center">재고 <span class="helpicon" title="재고 = 정상 재고 + 불량 재고"></span></th>
				<th class="its-th-align center">불량</th>
				<th class="its-th-align center">안전재고 <span class="helpicon" title="<?php if($TPL_VAR["provider_seq"]== 1){?><?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?><?php echo $TPL_VAR["scm_cfg"]['admin_env_name']?><?php }else{?>기본매장<?php }?><?php }else{?>입점사<?php }?>의 안전재고입니다.<br/>해당 상품의 재고수량이 안전재고 이하인 경우 자동 발주가 생성됩니다."></span></th>
<?php if($TPL_VAR["provider_seq"]== 1){?>
				<th class="its-th-align center">매입가(평균)<br />KRW, 원</th>
<?php }?>
<?php }?>
			</tr>
			</thead>
			<tbody>
<?php if($TPL_suboptions_1){foreach($TPL_VAR["suboptions"] as $TPL_K1=>$TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_K2=>$TPL_V2){$TPL_I2++;?>
			<tr class="suboptionTr">
				<td class="its-td-align center">
					<input type="hidden" name="suboptionSeq[]" value="<?php echo $TPL_V2["suboption_seq"]?>" />
					<span class="btn-minus"><button class="delSuboptionButton" type="button" <?php if($TPL_K2== 0){?>ltype="m"<?php }else{?>ltype="s"<?php }?>></button></span>
				</td>
				<td class="its-td-align center subSale_td">
<?php if($TPL_K2== 0){?>
					<input type="checkbox" name="subSale[]" size="10" value="<?php echo $TPL_K1?>" <?php if($TPL_V2["sub_sale"]=='y'){?>checked="checked"<?php }?> />
<?php }?>
				</td>
				<td class="its-td-align center subRequired_td">
<?php if($TPL_K2== 0){?>
					<input type="checkbox" name="subRequired[]" size="10" value="<?php echo $TPL_K1?>" <?php if($TPL_V2["sub_required"]=='y'){?>checked="checked"<?php }?> />
<?php }?>
				</td>
				<td class="its-td-align center suboptTitle_td">
<?php if($TPL_K2== 0){?>
					<input type="text" name="suboptTitle[]" size="10" value="<?php echo $TPL_V2["suboption_title"]?>"  class="line" />
					<input type="hidden" name="suboptType[]" value="<?php echo $TPL_V2["suboption_type"]?>">
<?php }?>
				</td>
				<td class="its-td-align center" >
					<input type="hidden" name="orgSuboptionSeq[<?php echo $TPL_K1?>][]" value="<?php echo $TPL_V2["org_suboption_seq"]?>" />
					<input type="text" name="subopt[<?php echo $TPL_K1?>][]" value="<?php echo $TPL_V2["suboption"]?>" class="line"  style="width:70%;"  />
					<br/>
<?php if($TPL_V1[ 0]["package_count"]){?>
					<input type="hidden" name="suboptCode[<?php echo $TPL_K1?>][]" value="<?php echo $TPL_V2["suboption_code"]?>" />
<?php }else{?>
					<input type="text" name="suboptCode[<?php echo $TPL_K1?>][]" value="<?php echo $TPL_V2["suboption_code"]?>" class="line" style="width:70%;"   title="옵션코드" />
<?php }?>
<?php if($TPL_V2["newtype"]){?>
						<br/>
<?php if($TPL_V2["newtype"]=='color'){?>
					<div class="colorPickerBtn colorhelpicon helpicon1" opttype="<?php echo $TPL_V2["suboption_type"]?>"  style="background-color:<?php echo $TPL_V2["color"]?>" title="[색상]을 클릭하여 변경할 수 있습니다."></div>
<?php }elseif($TPL_V2["newtype"]=='address'){?>
					<span class="addrhelpicon helpicon" opttype="<?php echo $TPL_V2["suboption_type"]?>"  title="<?php if($TPL_V2["zipcode"]){?>[<?php echo $TPL_V2["zipcode"]?>] <?php echo $TPL_V2["address"]?> <?php echo $TPL_V2["addressdetail"]?> <?php }else{?>지역 정보가 없습니다.<?php }?> <?php if($TPL_V2["biztel"]){?>업체 연락처:<?php echo $TPL_V2["biztel"]?><?php }?><br/>[지역]을 클릭하여 변경할 수 있습니다.">지역</span>
<?php }elseif($TPL_V2["newtype"]=='date'){?>
					<span class="codedatehelpicon helpicon" opttype="<?php echo $TPL_V2["suboption_type"]?>"  title="<?php if($TPL_V2["codedate"]&&$TPL_V2["codedate"]!='0000-00-00'){?><?php echo $TPL_V2["codedate"]?><?php }else{?>날짜 정보가 없습니다.<?php }?> <br/>[날짜]를 클릭하여 변경할 수 있습니다.">날짜</span>
<?php }elseif($TPL_V2["newtype"]=='dayinput'){?>
					<span class="dayinputhelpicon helpicon" opttype="<?php echo $TPL_V2["suboption_type"]?>"  title="<?php if($TPL_V2["sdayinput"]&&$TPL_V2["fdayinput"]){?><?php echo $TPL_V2["sdayinput"]?> ~ <?php echo $TPL_V2["fdayinput"]?><?php }else{?>수동기간 정보가 없습니다.<?php }?> <br/> [생성 및 변경]에서 변경할 수 있습니다.">수동기간</span>
<?php }elseif($TPL_V2["newtype"]=='dayauto'){?>
					<span class="dayautohelpicon helpicon"  opttype="<?php echo $TPL_V2["suboption_type"]?>" title="<?php if($TPL_V2["dayauto_type"]){?>'결제확인' <?php echo $TPL_V2["dayauto_type_title"]?> <?php echo $TPL_V2["sdayauto"]?>일 <?php if($TPL_V2["dayauto_type"]=='day'){?>이후<?php }?>부터 + <?php echo $TPL_V2["fdayauto"]?>일<?php echo $TPL_V2["dayauto_day_title"]?><?php }else{?>자동기간 정보가 없습니다.<?php }?> <br/>[생성 및 변경]에서 변경할 수 있습니다.">자동기간</span>
<?php }?>
<?php }?>

					<input type="hidden" name="suboptcolor[]" value="<?php echo $TPL_V2["color"]?>" />
					<input type="hidden" name="suboptzipcode[]" value="<?php echo $TPL_V2["zipcode"]?>" />
					<input type="hidden" name="suboptaddress[]" value="<?php echo $TPL_V2["address"]?>" />
					<input type="hidden" name="suboptaddressdetail[]" value="<?php echo $TPL_V2["addressdetail"]?>" />
					<input type="hidden" name="suboptbiztel[]" value="<?php echo $TPL_V2["biztel"]?>">
					<input type="hidden"  name="codedate[]" value="<?php echo $TPL_V2["codedate"]?>">
					<input type="hidden"  name="sdayinput[]" value="<?php echo $TPL_V2["sdayinput"]?>">
					<input type="hidden"  name="fdayinput[]" value="<?php echo $TPL_V2["fdayinput"]?>">
					<input type="hidden"  name="dayauto_type[]" value="<?php echo $TPL_V2["dayauto_type"]?>">
					<input type="hidden"  name="sdayauto[]" value="<?php echo $TPL_V2["sdayauto"]?>">
					<input type="hidden"  name="fdayauto[]" value="<?php echo $TPL_V2["fdayauto"]?>">
					<input type="hidden"  name="dayauto_day[]" value="<?php echo $TPL_V2["dayauto_day"]?>">
					<input type="hidden" name="suboptionnewtype[]" value="<?php echo $TPL_V2["newtype"]?>" />
				</td>

<?php if($_GET["package_yn"]!='y'){?>
				<td class="its-td-align center">
					<input type="text" name="weightVal[]" size="3" value="<?php echo $TPL_V2["weight"]?>"  class="weightVal line" />
				</td>
<?php }?>

<?php if($_GET["socialcp_input_type"]){?>
				<td class="its-td-align right pdr10 couponinputtitle">
					<input type="text" name="subcoupon_input[]" class="right line onlyfloat"  size="10" value="<?php echo $TPL_V2["coupon_input"]?>" idx="<?php echo $TPL_I2?>" />
				</td>
<?php }?>

<?php if($_GET["package_yn"]=='y'){?>
				<td class="its-td-align">
					<input type="hidden" name="tmp_package_count" value="<?php echo $TPL_V2["package_count"]?>" />
					<table width="100%" class="package-suboption" cellpadding="0" cellspacing="0">
						<tr>
							<td class="pdl5">
<?php if($TPL_V2["package_error_code1"]){?>
								<div class="package_error">
									<script>package_error_msg('<?php echo $TPL_V2["package_error_code1"]?>');</script>
								</div>
<?php }?>
								<div>
<?php if($TPL_V2["package_goods_seq1"]){?>
									<a href="/goods/view?no=<?php echo $TPL_V2["package_goods_seq1"]?>" target="_blank">
<?php }?>
									<span class="tmp_package_goods_seq1"><?php if($TPL_V2["package_goods_seq1"]){?>[<?php echo $TPL_V2["package_goods_seq1"]?>]<?php }?></span>
									<span class="tmp_package_goods_name1"><?php echo $TPL_V2["package_goods_name1"]?></span>
<?php if($TPL_V2["package_goods_seq1"]){?>
									</a>
<?php }?>
								</div>
								<div class="tmp_package_option_name1"><?php echo $TPL_V2["package_option1"]?></div>
								<div class="tmp_package_goodscode1"><?php echo $TPL_V2["package_option_code1"]?> | <?php echo $TPL_V2["weight1"]?>kg</div>
								<div>
									주문당
									<input type="text" name="tmp_package_unit_ea1[]" class = "tmp_package_unit_ea1" size="3" style="text-align:right;" value="<?php echo $TPL_V2["package_unit_ea1"]?>">
									발송
									<span class="helpicon" title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량"></span>
								</div>
								<div>
<?php if($TPL_V2["package_stock1"]){?>
										<span class="option-stock tmp_package_stock" optType="option" optSeq="<?php echo $TPL_V2["package_option_seq1"]?>">
											<?php echo number_format($TPL_V2["package_stock1"])?>

										</span>
									(<span class="tmp_package_badstock"><?php echo $TPL_V2["package_badstock1"]?></span>)
									/ <span class="tmp_package_ablestock"><?php echo $TPL_V2["package_ablestock1"]?></span>
									/ <span class="tmp_package_ablestock"><?php echo $TPL_V2["package_safe_stock1"]?></span>
									<span class="helpicon" title="현재재고 (불량재고) / 가용재고 / 안전재고"></span>
<?php }?>
								</div>
								<input type="hidden" name="tmp_package_option_seq1[]" value="<?php echo $TPL_V2["package_option_seq1"]?>" />
								<input type="hidden" name="tmp_package_option1[]" value="<?php echo $TPL_V2["package_option1"]?>" />
								<input type="hidden" name="tmp_package_goods_name1[]" value="<?php echo $TPL_V2["package_goods_name1"]?>" />
							</td>
						</tr>
					</table>
				</td>
<?php }else{?>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["provider_seq"]== 1&&$TPL_VAR["scm_use_suboption_mode"]&&$TPL_VAR["goods_seq"]> 0&&$TPL_V2["org_suboption_seq"]> 0){?>
				<td class="its-td-align right pdr10 hand" onclick="scm_warehouse_on('<?php echo $TPL_VAR["goods_seq"]?>', this);">
					<span class="option-stock" optType="suboption" optSeq="<?php echo $TPL_V2["org_suboption_seq"]?>"><?php echo number_format($TPL_V2["stock"])?></span>
					<input type="hidden" name="subStock[]" value="<?php echo $TPL_V2["stock"]?>" />
					<input type="hidden" name="subTotalStock[]" value="<?php echo $TPL_V2["total_stock"]?>" />
				</td>
<?php }elseif($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["provider_seq"]== 1&&$TPL_VAR["scm_use_suboption_mode"]){?>
				<td class="its-td-align right pdr10">
					<?php echo number_format($TPL_V2["stock"])?>

					<input type="hidden" name="subStock[]" value="<?php echo $TPL_V2["stock"]?>" />
					<input type="hidden" name="subTotalStock[]" value="<?php echo $TPL_V2["total_stock"]?>" />
				</td>
<?php }else{?>
				<td class="its-td-align right pdr10">
					<input type="text" name="subStock[]" class="subStock right line onlynumber" size="5" value="<?php echo $TPL_V2["stock"]?>" />
					<input type="hidden" name="subTotalStock[]" value="<?php echo $TPL_V2["total_stock"]?>" />
				</td>
<?php }?>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["provider_seq"]== 1&&$TPL_VAR["scm_use_suboption_mode"]){?>
				<td class="its-td-align right pdr10">
					<?php echo number_format($TPL_V2["badstock"])?>

					<input type="hidden" name="subBadStock[]" value="<?php echo $TPL_V2["badstock"]?>" />
					<input type="hidden" name="subTotalBadStock[]" value="<?php echo $TPL_V2["total_badstock"]?>" />
				</td>
<?php }else{?>
				<td class="its-td-align right pdr10">
					<input type="text" name="subBadStock[]" class="subBadStock right line onlynumber" size="5" value="<?php echo $TPL_V2["badstock"]?>" />
					<input type="hidden" name="subTotalBadStock[]" value="<?php echo $TPL_V2["total_badstock"]?>" />
				</td>
<?php }?>
				<td class="its-td-align right pdr10">
					<input type="text" name="subSafeStock[]" class="subSafeStock right line onlynumber" size="5" value="<?php echo $TPL_V2["safe_stock"]?>" />
				</td>
<?php if($TPL_VAR["provider_seq"]== 1){?>
				<td class="its-td-align right pdr10">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["scm_use_suboption_mode"]){?>
					<span title="<?php echo $TPL_V2["supply_price"]?>"><?php echo $TPL_V2["supply_price"]?></span>
					<input type="hidden" name="subSupplyPrice[]" value="<?php echo $TPL_V2["supply_price"]?>" />
					<input type="hidden" name="subTotalSupplyPrice[]" value="<?php echo $TPL_V2["total_supply_price"]?>" />
<?php }else{?>
					<input type="text" name="subSupplyPrice[]" class="subSupplyPrice right line onlyfloat" size="10" value="<?php echo $TPL_V2["supply_price"]?>" idx="<?php echo $TPL_I2?>" />
					<input type="hidden" name="subTotalSupplyPrice[]" value="<?php echo $TPL_V2["total_supply_price"]?>" />
<?php }?>
				</td>
<?php }?>
<?php }?>
				
				<td style="padding-right: 10px;" class="its-td-align right <?php if($_GET["provider_seq"]=='1'){?>hide<?php }?>">
					<input style="text-align: right;" class="subCommissionRate line onlyfloat input-box-default-text" name="subCommissionRate[]" value="<?php if($_GET["provider_seq"]=='1'){?>100<?php }else{?><?php if($TPL_V2["commission_rate"]){?><?php echo $TPL_V2["commission_rate"]?><?php }else{?>0<?php }?><?php }?>" size="3" type="text">

<?php if($TPL_VAR["provider_info"]["commission_type"]=='SACO'||$TPL_VAR["provider_info"]["commission_type"]==''){?>
					<input type="hidden" name="subCommissionType[]" class="subCommissionType" value="SACO" />
					%
<?php }else{?>
					<select name="subCommissionType[]" class="subCommissionType">
						<option value="SUCO" <?php if($TPL_V2["commission_type"]!='SUPR'){?>selected<?php }?>>%</option>
						<option value="SUPR" <?php if($TPL_V2["commission_type"]=='SUPR'){?>selected<?php }?>><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
					</select>
<?php }?>
				</td>

				<td class="its-td-align right pdr10 pricetd">
					<input type="text" name="subConsumerPrice[]" style="color:#000;" class="subConsumerPrice right line onlyfloat"  size="10" value="<?php echo $TPL_V2["consumer_price"]?>" idx="<?php echo $TPL_I2?>" />
					→
					<input type="text" name="subPrice[]" class="subPrice right line onlyfloat" size="10" value="<?php echo $TPL_V2["price"]?>" idx="<?php echo $TPL_I2?>" />
				</td>
				<td class="its-td-align center ">
					<div class="reserve-shop-lay <?php if($TPL_VAR["goods"]["sub_reserve_policy"]=='goods'){?>hide<?php }?>">
						<?php echo $TPL_VAR["reserves"]["default_reserve_percent"]?>%
						(<span class="reserve-shop"><?php echo get_currency_price($TPL_V2["reserve"])?></span>)
					</div>
					<div class="reserve-goods-lay <?php if($TPL_VAR["goods"]["sub_reserve_policy"]=='shop'){?>hide<?php }?>">
						<input type="text" size="5" name="subReserveRate[]" value="<?php echo $TPL_V2["reserve_rate"]?>"  class="subReserveRate" />
						<select name="subReserveUnit[]" class="subReserveUnit">
							<option value="percent">%</option>
							<option value="<?php echo $TPL_VAR["config_system"]['basic_currency']?>" <?php if($TPL_V2["reserve_unit"]==$TPL_VAR["config_system"]['basic_currency']){?>selected<?php }?>><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
						</select>
						(<span class="subReserve"><?php echo get_currency_price($TPL_V2["reserve"])?></span>)
					</div>
				</td>
				<td class="its-td-align center ">
					<select name="optionView[]" class="optionView">
						<option value="Y" <?php if($TPL_V2["option_view"]!='N'){?>selected<?php }?>>노출</option>
						<option value="N" <?php if($TPL_V2["option_view"]=='N'){?>selected<?php }?>>미노출</option>
					</select>
				</td>
			</tr>
<?php }}?>
<?php }}?>
			</tbody>
			</table>
		<div class="center" style="padding:10px;"  id="frequentlay">
			이 상품의 옵션 정보를 자주 쓰는 상품의 추가구성옵션으로 사용하시겠습니까? <label><input type="checkbox" name="frequently" value="1"  <?php if($TPL_VAR["goods"]["frequentlysub"]== 1){?> checked="checked" <?php }?> >예, 사용하겠습니다.</label>
		</div>

		<div class="center" style="padding:10px;">
			<span class="btn large black"><button type="button" onclick="apply_suboption();">적용하기</button></span>
		</div>
		</form>
	</div>

	<!-- 추가옵션만들기 다이얼로그 -->
	<div id="subOptDialog" class="hide">
		<form name="suboptionMakeForm" id="suboptionMakeForm" method="post" action="../goods_process/make_suboption_tmp" target="suboptionFrame">
		<input type="hidden" name="goods_seq" value="<?php echo $TPL_VAR["goods_seq"]?>" />
		<input type="hidden" name="tmp_seq" value="<?php echo $TPL_VAR["tmp_seq"]?>" />
		<input type="hidden" name="optionCode" class="line" size="55" value="" />
		<input type="hidden" name="socialcpuseopen" id="socialcpuseopen" value="" />
		<input type="hidden" name="goodsTax" id="goodsTax" value="" />
		<input type="hidden" name="default_commission_rate" class="default_commission_rate" value="<?php echo $TPL_VAR["default_charge"]["charge"]?>" />
		<input type="hidden" name="default_commission_type" class="default_commission_type" value="<?php echo $TPL_VAR["provider_info"]["commission_type"]?>" />
		<table  class="simplelist-table-style" style="width:100%" border="0">
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
						추가 옵션명
						[특수정보선택] <a href="javascript:helperMessageLayer('specialOption');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
					</th>
					<th class="its-th-align center" >추가 옵션값은 :','(콤마)로 구분</th>
					<th class="its-th-align center" >
						추가 가격은 : ','(콤마)로 구분
						<a href="javascript:helperMessageLayer('optionPrice');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
					</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_VAR["sopts_loop"]){?>
<?php if($TPL_sopts_loop_1){$TPL_I1=-1;foreach($TPL_VAR["sopts_loop"] as $TPL_V1){$TPL_I1++;?>
				<tr>
					<td class="its-td-align center">
<?php if($TPL_I1== 0){?>
						<span class="btn-plus btnplusminus"><button type="button" id="addSuboptionMake"></button></span>
<?php }else{?>
						<span class="btn-minus btnplusminus"><button type="button" class="delSuboptionMake"></button></span>
<?php }?>
					</td>
					<td class="its-td-align center">
						<input type="hidden" name="suboptionMakeType[]" class="suboptionMakeType line" size="25" value="<?php echo $TPL_V1["type"]?>" />
						<input type="hidden" name="suboptionMakeCode[]" class="suboptionMakeCode line" size="25" value="<?php echo $TPL_V1["optcodes"]?>" />

						<input type="hidden" name="suboptionMakenewtype[]" value="<?php echo $TPL_V1["newtype"]?>" />

						<input type="hidden" name="suboptionMakecolor[]" value="<?php echo $TPL_V1["colors"]?>" />
						<input type="hidden" name="suboptionMakezipcode[]" value="<?php echo $TPL_V1["zipcodes"]?>" />
						<input type="hidden" name="suboptionMakeaddress[]" value="<?php echo $TPL_V1["addresss"]?>" />
						<input type="hidden" name="suboptionMakeaddressdetail[]" value="<?php echo $TPL_V1["addressdetails"]?>" />
						<input type="hidden" name="suboptionMakebiztel[]" value="<?php echo $TPL_V1["biztels"]?>" />
						<input type="hidden" name="suboptionMakecodedate[]" value="<?php echo $TPL_V1["codedates"]?>">

							<select name="suboptionMakeId[]" class="line">
<?php if(is_array($TPL_R2=$TPL_V1["goodssuboptionloop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($_GET["socialcp_input_type"]){?>
<?php if($TPL_V2["label_newtype"]!='color'){?>
									<option value="goodssuboption_<?php echo $TPL_V2["codeform_seq"]?>" label_type="<?php echo $TPL_V2["label_type"]?>"  codeform_seq="<?php echo $TPL_V2["codeform_seq"]?>" label_title="<?php echo $TPL_V2["label_title"]?>"   <?php if($TPL_V1["code_seq"]==$TPL_V2["codeform_seq"]&&strstr($TPL_V1["type"],'goodssuboption_')){?> selected="selected" <?php }?>   newtypeid="goodssuboption_<?php echo $TPL_I1?>_<?php echo $TPL_V1["newtype"]?>" label_newtype="<?php echo $TPL_V2["label_newtype"]?>"  label_color="<?php echo $TPL_V2["label_color"]?>" label_zipcode="<?php echo $TPL_V2["label_zipcode"]?>" label_address="<?php echo $TPL_V2["label_address"]?>" label_addressdetail="<?php echo $TPL_V2["label_addressdetail"]?>"  label_biztel="<?php echo $TPL_V2["label_biztel"]?>"  label_codedate="<?php echo $TPL_V2["label_codedate"]?>"  label_sdayinput="<?php echo $TPL_V2["label_sdayinput"]?>" label_fdayinput="<?php echo $TPL_V2["label_fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V2["label_dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V2["label_sdayauto"]?>" label_fdayauto="<?php echo $TPL_V2["label_fdayauto"]?>" label_dayauto_day="<?php echo $TPL_V2["label_dayauto_day"]?>"><?php if($TPL_V2["label_newtype"]&&$TPL_V2["label_newtype"]!='none'){?>[특수]<?php }?> <?php echo $TPL_V2["label_title"]?></option>
<?php }?>
<?php }else{?>
<?php if($TPL_V2["label_newtype"]=='color'||!$TPL_V2["label_newtype"]||$TPL_V2["label_newtype"]=='none'){?>
								<option value="goodssuboption_<?php echo $TPL_V2["codeform_seq"]?>" label_type="<?php echo $TPL_V2["label_type"]?>"  codeform_seq="<?php echo $TPL_V2["codeform_seq"]?>" label_title="<?php echo $TPL_V2["label_title"]?>"   <?php if($TPL_V1["code_seq"]==$TPL_V2["codeform_seq"]&&strstr($TPL_V1["type"],'goodssuboption_')){?> selected="selected" <?php }?>   newtypeid="goodssuboption_<?php echo $TPL_I1?>_<?php echo $TPL_V1["newtype"]?>" label_newtype="<?php echo $TPL_V2["label_newtype"]?>"  label_color="<?php echo $TPL_V2["label_color"]?>" label_zipcode="<?php echo $TPL_V2["label_zipcode"]?>" label_address="<?php echo $TPL_V2["label_address"]?>" label_addressdetail="<?php echo $TPL_V2["label_addressdetail"]?>"  label_biztel="<?php echo $TPL_V2["label_biztel"]?>"  label_codedate="<?php echo $TPL_V2["label_codedate"]?>"  label_sdayinput="<?php echo $TPL_V2["label_sdayinput"]?>" label_fdayinput="<?php echo $TPL_V2["label_fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V2["label_dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V2["label_sdayauto"]?>" label_fdayauto="<?php echo $TPL_V2["label_fdayauto"]?>" label_dayauto_day="<?php echo $TPL_V2["label_dayauto_day"]?>"><?php if($TPL_V2["label_newtype"]&&$TPL_V2["label_newtype"]!='none'){?>[특수]<?php }?> <?php echo $TPL_V2["label_title"]?></option>
<?php }?>
<?php }?>
<?php }}?>
							<option value="direct" <?php if(!strstr($TPL_V1["type"],'goodssuboption_')){?> selected="selected" <?php }?>>직접입력</option>
						</select>
					</td>
					<td class="its-td-align center">
						<input type="text" name="suboptionMakeName[]" size="10" class="line " value="<?php echo $TPL_V1["title"]?>" />
<?php if($TPL_V1["newtype"]&&$TPL_V1["newtype"]!='none'&&strstr($TPL_V1["type"],'goodssuboption_')){?>
						<select name="suboptionMakespecial[]" readonly="readonly"  disabled="disabled" id="goodssuboption_<?php echo $TPL_I1?>_<?php echo $TPL_V1["newtype"]?>" class="<?php echo $TPL_V1["newtype"]?>select">
							<option value="" >특수정보선택</option>
<?php if($_GET["socialcp_input_type"]){?>
							<option value="address"  <?php if($TPL_V1["newtype"]=='address'){?> selected="selected" <?php }?>>지역</option>
							<option value="date"  <?php if($TPL_V1["newtype"]=='date'){?> selected="selected" <?php }?>>날짜</option>
							<option value="dayauto"  <?php if($TPL_V1["newtype"]=='dayauto'){?> selected="selected" <?php }?>>자동기간</option>
							<option value="dayinput"  <?php if($TPL_V1["newtype"]=='dayinput'){?> selected="selected" <?php }?>>수동기간</option>
<?php }else{?>
								<option value="color" <?php if($TPL_V1["newtype"]=='color'){?> selected="selected" <?php }?>>색상</option>
<?php }?>
						</select>
<?php }else{?>
						<select name="suboptionMakespecial[]" id="goodssuboption_<?php echo $TPL_I1?>_<?php echo $TPL_V1["newtype"]?>" class="<?php echo $TPL_V1["newtype"]?>select">
							<option value="" >특수정보선택</option>
<?php if($_GET["socialcp_input_type"]){?>
							<option value="address"  <?php if($TPL_V1["newtype"]=='address'){?> selected="selected" <?php }?>>지역</option>
							<option value="date"  <?php if($TPL_V1["newtype"]=='date'){?> selected="selected" <?php }?>>날짜</option>
							<option value="dayauto"  <?php if($TPL_V1["newtype"]=='dayauto'){?> selected="selected" <?php }?>>자동기간</option>
							<option value="dayinput"  <?php if($TPL_V1["newtype"]=='dayinput'){?> selected="selected" <?php }?>>수동기간</option>
<?php }else{?>
								<option value="color" <?php if($TPL_V1["newtype"]=='color'){?> selected="selected" <?php }?>>색상</option>
<?php }?>
						</select>
<?php }?>
					</td>
					<td class="its-td-align left">
							<span class='goodssuboptionlay '>
<?php if(is_array($TPL_R2=$TPL_V1["goodssuboptionloop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<span class="goodssuboption_<?php echo $TPL_V2["codeform_seq"]?> goodssuboptionsublay  <?php if((($TPL_V1["code_seq"]!=$TPL_V2["codeform_seq"]&&strstr($TPL_V1["type"],'goodssuboption_'))||(!strstr($TPL_V1["type"],'goodssuboption_')))){?>hide<?php }?> "><span class="btn small black"><button type="button" class="<?php echo $TPL_V2["label_type"]?>btn" layerid="<?php echo $TPL_V2["label_type"]?><?php echo $TPL_V2["codeform_seq"]?>_lay" label_type="<?php echo $TPL_V2["label_type"]?>"  codeform_seq="<?php echo $TPL_V2["codeform_seq"]?>" label_title="<?php echo $TPL_V2["label_title"]?>"  label_newtype="<?php echo $TPL_V2["label_newtype"]?>"  label_color="<?php echo $TPL_V2["label_color"]?>" label_zipcode="<?php echo $TPL_V2["label_zipcode"]?>" label_address="<?php echo $TPL_V2["label_address"]?>" label_addressdetail="<?php echo $TPL_V2["label_addressdetail"]?>"  label_biztel="<?php echo $TPL_V2["label_biztel"]?>"  label_codedate="<?php echo $TPL_V2["label_codedate"]?>"  label_sdayinput="<?php echo $TPL_V2["label_sdayinput"]?>" label_fdayinput="<?php echo $TPL_V2["label_fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V2["label_dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V2["label_sdayauto"]?>" label_fdayauto="<?php echo $TPL_V2["label_fdayauto"]?>" label_dayauto_day="<?php echo $TPL_V2["label_dayauto_day"]?>" >선택</button></span></span>
<?php }}?>
							</span>
							<input type="text" name="suboptionMakeValue[]" class="line " size="45" value="<?php echo $TPL_V1["opt"]?>" />
						<div class="suboptionMakeSpecial">
							<div class="suboptionMakeSpecialsub suboptionMakeColor <?php if($TPL_V1["newtype"]!='color'){?> hide <?php }?>">
								<span class="desc">※ 색상표 정보는 옵션 생성 후 입력 가능합니다.</span>
							</div>

							<div class="suboptionMakeSpecialsub suboptionMakeaddress   <?php if($TPL_V1["newtype"]!='address'){?> hide <?php }?>">
							<span class="desc">※ 지역의 위치정보는 옵션 생성 후 입력 가능합니다.</span>
							</div>

							<div class="suboptionMakeSpecialsub suboptionMakedate  <?php if($TPL_V1["newtype"]!='date'){?> hide <?php }?>">
								<span class="desc">※ 날짜 지정은 옵션 생성 후 입력 가능합니다.</span>
							</div>

							<div class="suboptionMakeSpecialsub suboptionMakedayinput  <?php if($TPL_V1["newtype"]!='dayinput'){?> hide <?php }?>">
								<input type="text" name="suboptionMakesdayinput[]" id="addoptionMakesdayinput<?php echo $TPL_I1?>" value="<?php echo $TPL_V1["sdayinput"]?>" class="line suboptionMakesdayinput datepicker"  maxlength="10" size="10" />
								~
								<input type="text" name="suboptionMakefdayinput[]"  id="addoptionMakefdayinput<?php echo $TPL_I1?>"  value="<?php echo $TPL_V1["fdayinput"]?>" class="line suboptionMakefdayinput datepicker"  maxlength="10" size="10" />
							</div>

							<div class="suboptionMakeSpecialsub suboptionMakenewdayauto  <?php if($TPL_V1["newtype"]!='dayauto'){?> hide <?php }?>">
								<span> '결제확인' 후
									<select name="suboptionMakedayauto_type[]" class="suboptionMakedayauto_type" >
									<option value="month" <?php if($TPL_V1["dayauto_type"]=='month'){?> selected="selected" <?php }?>>해당 월▼</option>
									<option value="day" <?php if($TPL_V1["dayauto_type"]=='day'){?> selected="selected" <?php }?>>해당 일▼</option>
									<option value="next" <?php if($TPL_V1["dayauto_type"]=='next'){?> selected="selected" <?php }?>>익월▼</option>
									</select>
									<input type="text" name="suboptionMakesdayauto[]"   value="<?php echo $TPL_V1["sdayauto"]?>" class="line optionMakesdayauto"  maxlength="10" size="2" />일 <span class="suboptionMakenewdayautolaytitle"><?php if($TPL_V1["dayauto_type"]=='day'){?>이후<?php }?></span>부터
									+
									<input type="text" name="suboptionMakefdayauto[]"  value="<?php echo $TPL_V1["fdayauto"]?>" class="line optionMakefdayauto"  maxlength="10" size="2" />일
									<select name="suboptionMakedayauto_day[]" class="suboptionMakedayauto_day" >
								<option value="day"  <?php if($TPL_V1["dayauto_day"]=='day'){?> selected="selected" <?php }?>>동안</option>
								<option value="end"  <?php if($TPL_V1["dayauto_day"]=='end'){?> selected="selected" <?php }?>>이 되는 월의 말일</option>
									</select>
								</span>
								<br/><span  class="hand optionMakenewdayautolayrealdateBtn"  >미리보기▶ </span><span class="optionMakenewdayautolayrealdate"><?php echo $TPL_V1["social_start_date_end"]?></span>
							</div>
						</div>
					</td>
					<td class="its-td-align center">
						<input type="text" name="suboptionMakePrice[]" class="line" size="25" value="<?php echo $TPL_V1["price"]?>" />
					</td>
				</tr>
<?php }}?>
<?php }else{?>
				<tr>
					<td class="its-td-align center">
						<span class="btn-plus btnplusminus"><button type="button" id="addSuboptionMake"></button></span>
					</td>
					<td class="its-td-align center">
						<input type="hidden" name="suboptionMakeType[]" class="suboptionMakeType" value="" />
						<input type="hidden" name="suboptionMakeCode[]" class="suboptionMakeCode" value="" />

						<input type="hidden" name="suboptionMakenewtype[]" value="" />
						<input type="hidden" name="suboptionMakecolor[]" value="" />
						<input type="hidden" name="suboptionMakezipcode[]" value="" />
						<input type="hidden" name="suboptionMakeaddress[]" value="" />
						<input type="hidden" name="suboptionMakeaddressdetail[]" value="" />
						<input type="hidden" name="suboptionMakebiztel[]" value="" />

						<input type="hidden" name="suboptionMakecodedate[]" value="" />

						<select name="suboptionMakeId[]" class="line">
<?php if($TPL_goodssuboptionloop_1){foreach($TPL_VAR["goodssuboptionloop"] as $TPL_V1){?>
<?php if($_GET["socialcp_input_type"]){?>
<?php if($TPL_V1["label_newtype"]!='color'){?>
								<option value="goodssuboption_<?php echo $TPL_V1["codeform_seq"]?>" label_type="<?php echo $TPL_V1["label_type"]?>"  codeform_seq="<?php echo $TPL_V1["codeform_seq"]?>" label_title="<?php echo $TPL_V1["label_title"]?>"   label_newtype="<?php echo $TPL_V1["label_newtype"]?>"  label_color="<?php echo $TPL_V1["label_color"]?>" label_zipcode="<?php echo $TPL_V1["label_zipcode"]?>" label_address="<?php echo $TPL_V1["label_address"]?>" label_addressdetail="<?php echo $TPL_V1["label_addressdetail"]?>"  label_biztel="<?php echo $TPL_V1["label_biztel"]?>"  label_codedate="<?php echo $TPL_V1["label_codedate"]?>"  label_sdayinput="<?php echo $TPL_V1["label_sdayinput"]?>" label_fdayinput="<?php echo $TPL_V1["label_fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V1["label_dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V1["label_sdayauto"]?>" label_fdayauto="<?php echo $TPL_V1["label_fdayauto"]?>" label_dayauto_day="<?php echo $TPL_V1["label_dayauto_day"]?>"><?php if($TPL_V1["label_newtype"]&&$TPL_V1["label_newtype"]!='none'){?>[특수]<?php }?> <?php echo $TPL_V1["label_title"]?></option>
<?php }?>
<?php }else{?>
<?php if($TPL_V1["label_newtype"]=='color'||!$TPL_V1["label_newtype"]||$TPL_V1["label_newtype"]=='none'){?>
										<option value="goodssuboption_<?php echo $TPL_V1["codeform_seq"]?>" label_type="<?php echo $TPL_V1["label_type"]?>"  codeform_seq="<?php echo $TPL_V1["codeform_seq"]?>" label_title="<?php echo $TPL_V1["label_title"]?>"   label_newtype="<?php echo $TPL_V1["label_newtype"]?>"  label_color="<?php echo $TPL_V1["label_color"]?>" label_zipcode="<?php echo $TPL_V1["label_zipcode"]?>" label_address="<?php echo $TPL_V1["label_address"]?>" label_addressdetail="<?php echo $TPL_V1["label_addressdetail"]?>"  label_biztel="<?php echo $TPL_V1["label_biztel"]?>"  label_codedate="<?php echo $TPL_V1["label_codedate"]?>"  label_sdayinput="<?php echo $TPL_V1["label_sdayinput"]?>" label_fdayinput="<?php echo $TPL_V1["label_fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V1["label_dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V1["label_sdayauto"]?>" label_fdayauto="<?php echo $TPL_V1["label_fdayauto"]?>" label_dayauto_day="<?php echo $TPL_V1["label_dayauto_day"]?>"><?php if($TPL_V1["label_newtype"]&&$TPL_V1["label_newtype"]!='none'){?>[특수]<?php }?> <?php echo $TPL_V1["label_title"]?></option>
<?php }?>
<?php }?>
<?php }}?>
							<option value="direct" selected>직접입력</option>
						</select>
					</td>
					<td class="its-td-align center">
						<input type="text" name="suboptionMakeName[]" size="10" class="line" value="" title="예) 사이즈" />
						<select name="suboptionMakespecial[]" >
							<option value="" >특수정보선택</option>
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
							<span class='goodssuboptionlay hide'>
<?php if($TPL_goodssuboptionloop_1){foreach($TPL_VAR["goodssuboptionloop"] as $TPL_V1){?>
								<span class="goodssuboption_<?php echo $TPL_V1["codeform_seq"]?> goodssuboptionsublay hide "><span class=" btn small black"><button type="button" class="<?php echo $TPL_V1["label_type"]?>btn" layerid="<?php echo $TPL_V1["label_type"]?><?php echo $TPL_V1["codeform_seq"]?>_lay" label_type="<?php echo $TPL_V1["label_type"]?>"  label_id="<?php echo $TPL_V1["label_id"]?>"  codeform_seq="<?php echo $TPL_V1["codeform_seq"]?>" label_title="<?php echo $TPL_V1["label_title"]?>"  label_newtype="<?php echo $TPL_V1["label_newtype"]?>"  label_color="<?php echo $TPL_V1["label_color"]?>" label_zipcode="<?php echo $TPL_V1["label_zipcode"]?>" label_address="<?php echo $TPL_V1["label_address"]?>" label_addressdetail="<?php echo $TPL_V1["label_addressdetail"]?>"  label_biztel="<?php echo $TPL_V1["label_biztel"]?>"   label_codedate="<?php echo $TPL_V1["label_codedate"]?>"  label_sdayinput="<?php echo $TPL_V1["label_sdayinput"]?>" label_fdayinput="<?php echo $TPL_V1["label_fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V1["label_dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V1["label_sdayauto"]?>" label_fdayauto="<?php echo $TPL_V1["label_fdayauto"]?>" label_dayauto_day="<?php echo $TPL_V1["label_dayauto_day"]?>">선택</button></span></span>
<?php }}?>
							</span>
							<input type="text" name="suboptionMakeValue[]" class="line" size="45" value="" title="예) 90, 95, 100" />
						<div class="suboptionMakeSpecial hide">
							<div class="suboptionMakeSpecialsub suboptionMakeColor hide">
								<span class="desc">※ 색상표 정보는 옵션 생성 후 입력 가능합니다.</span>
							</div>

							<div class="suboptionMakeSpecialsub suboptionMakeaddress  hide">
							<span class="desc">※ 지역의 위치정보는 옵션 생성 후 입력 가능합니다.</span>
							</div>

							<div class="suboptionMakeSpecialsub suboptionMakedate hide">
								<span class="desc">※ 날짜 지정은 옵션 생성 후 입력 가능합니다.</span>
							</div>

							<div class="suboptionMakeSpecialsub suboptionMakedayinput hide">
								<input type="text" name="suboptionMakesdayinput[]"  id="addoptionMakesdayinput0"  value="" class="line suboptionMakesdayinput datepicker"  maxlength="10" size="10" />
								~
								<input type="text" name="suboptionMakefdayinput[]"  id="addoptionMakefdayinput0"  value="" class="line suboptionMakefdayinput datepicker"  maxlength="10" size="10" />
							</div>
							<div class="suboptionMakeSpecialsub suboptionMakenewdayauto hide">
								<span> '결제확인' 후
									<select name="suboptionMakedayauto_type[]" class="suboptionMakedayauto_type" >
										<option value="month">해당 월▼</option>
										<option value="day">해당 일▼</option>
										<option value="next">익월▼</option>
									</select>
									<input type="text" name="suboptionMakesdayauto[]"  value="" class="line optionMakesdayauto"  maxlength="10" size="2" />일 <span class="suboptionMakenewdayautolaytitle"></span>부터
									+
									<input type="text" name="suboptionMakefdayauto[]"  value="" class="line optionMakefdayauto"  maxlength="10" size="2" />일
									<select name="suboptionMakedayauto_day[]" class="voptionMakedayauto_day" >
									<option value="day">동안</option>
									<option value="end">이 되는 월의 말일</option>
									</select>
								</span>
								<br/><span  class="hand optionMakenewdayautolayrealdateBtn"  >미리보기▶ </span><span class="optionMakenewdayautolayrealdate"></span>
							</div>
						</div>
					</td>
					<td class="its-td-align center">
						<input type="text" name="suboptionMakePrice[]" class="line" size="25" value="" />
					</td>
				</tr>
<?php }?>
			</tbody>
		</table>
		<div class="center" style="padding:10px;">
			위 옵션정보를 기준으로 <span class="blue">추가구성옵션 상품</span>을
			<select name="suboption_package_count">
<?php if(!($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["provider_seq"]== 1)){?>
				<option value="0">실제 상품으로 연결하지 않습니다.</option>
<?php }?>
				<option value="1" <?php if($TPL_VAR["suboption_package_count"]== 1){?>selected<?php }?>>실제 상품으로 연결하며, 출고처리 시 연결된 실제 상품의 재고를 차감합니다.</option>
			</select>
		</div>
		<div class="center" style="padding:10px;"><span class="btn large black"><button  type="button" id="gdsuboptioncodemakebtn">옵션 생성하기</button></span></div>
		</form>
	</div>

<?php if($TPL_goodssuboptionloop_1){foreach($TPL_VAR["goodssuboptionloop"] as $TPL_V1){?>
	<div id="<?php echo $TPL_V1["label_type"]?><?php echo $TPL_V1["codeform_seq"]?>_lay" class="hide">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >

		<tr>
			<td  valign="top" class="center">
				<div class="center" style="padding:10px;">
					<span class="btn large black"><button type="button" id="<?php echo $TPL_V1["label_type"]?><?php echo $TPL_V1["codeform_seq"]?>CodeApply" class="GoodsSubOptionCodeApply" codeform_seq="<?php echo $TPL_V1["codeform_seq"]?>"  label_type="<?php echo $TPL_V1["label_type"]?>"  label_id="<?php echo $TPL_V1["label_id"]?>" layer_id="<?php echo $TPL_V1["label_type"]?><?php echo $TPL_V1["codeform_seq"]?>_lay">적용하기</button></span>
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
					<td id=" labelTd1"  class="its-td left" nowrap="nowrap" >
						<label><input type="checkbox" name="<?php echo $TPL_V1["label_type"]?>[]" class="null labelCheckbox_<?php echo $TPL_V1["codeform_seq"]?>"  codeform_seq="<?php echo $TPL_V1["codeform_seq"]?>"  label_type="<?php echo $TPL_V1["label_type"]?>"  label_id="<?php echo $TPL_V1["label_id"]?>" value="<?php echo $TPL_V2["code"]?>" label_value="<?php echo $TPL_V2["value"]?>"   label_newtype="<?php echo $TPL_V1["label_newtype"]?>"  label_color="<?php echo $TPL_V2["colors"]?>" label_zipcode="<?php echo $TPL_V2["zipcode"]?>" label_address="<?php echo $TPL_V2["address"]?>" label_addressdetail="<?php echo $TPL_V2["addressdetail"]?>"  label_biztel="<?php echo $TPL_V2["biztel"]?>"  label_codedate="<?php echo $TPL_V2["codedate"]?>"  label_sdayinput="<?php echo $TPL_V2["sdayinput"]?>" label_fdayinput="<?php echo $TPL_V2["fdayinput"]?>" label_dayauto_type="<?php echo $TPL_V2["dayauto_type"]?>" label_sdayauto="<?php echo $TPL_V2["sdayauto"]?>" label_fdayauto="<?php echo $TPL_V2["fdayauto"]?>"  label_dayauto_day="<?php echo $TPL_V2["dayauto_day"]?>"  <?php if($TPL_V2["default"]=="Y"){?> default="checked" <?php }?>>
						<?php echo $TPL_V2["value"]?></label>
<?php if($TPL_V1["label_newtype"]){?>
<?php if($TPL_V1["label_newtype"]=='color'){?>
							→<div class="colorPickerBtn " style="background-color:<?php echo $TPL_V2["colors"]?>"  ></div>
<?php }elseif($TPL_V1["label_newtype"]=='address'){?>
							→<span class="addrhelpicon1  " alt="<?php if($TPL_V2["zipcode"]){?>[<?php echo $TPL_V2["zipcode"]?>] <?php echo $TPL_V2["address"]?> <?php echo $TPL_V2["addressdetail"]?><?php }?> <?php if($TPL_V2["biztel"]){?>업체 연락처:<?php echo $TPL_V2["biztel"]?><?php }?>"  title="<?php if($TPL_V2["zipcode"]){?>[<?php echo $TPL_V2["zipcode"]?>] <?php echo $TPL_V2["address"]?> <?php echo $TPL_V2["addressdetail"]?><?php }?> <?php if($TPL_V2["biztel"]){?>업체 연락처:<?php echo $TPL_V2["biztel"]?><?php }?>" ><?php if($TPL_V2["zipcode"]){?>[<?php echo $TPL_V2["zipcode"]?>] <?php echo $TPL_V2["address"]?> <?php echo $TPL_V2["addressdetail"]?><?php }?> <?php if($TPL_V2["biztel"]){?>업체 연락처:<?php echo $TPL_V2["biztel"]?><?php }?></span>
<?php }elseif($TPL_V1["label_newtype"]=='date'){?>
							→<span class="codedatehelpicon1  " alt="<?php echo $TPL_V2["codedate"]?>" title="<?php echo $TPL_V2["codedate"]?>"><?php echo $TPL_V2["codedate"]?></span>
<?php }elseif($TPL_V1["label_newtype"]=='dayinput'){?>
							→<span class="dayinputhelpicon1  " alt="<?php echo $TPL_V2["sdayinput"]?> ~ <?php echo $TPL_V2["fdayinput"]?>" title="<?php echo $TPL_V2["sdayinput"]?> ~ <?php echo $TPL_V2["fdayinput"]?>"><?php echo $TPL_V2["sdayinput"]?> ~ <?php echo $TPL_V2["fdayinput"]?></span>
<?php }elseif($TPL_V1["label_newtype"]=='dayauto'){?>
							→<span class="dayautohelpicon1  " alt="'결제확인' <?php echo $TPL_V2["dayauto_type_title"]?> <?php echo $TPL_V2["sdayauto"]?>일 <?php if($TPL_V2["dayauto_type"]=='day'){?>이후<?php }?>부터 + <?php echo $TPL_V2["fdayauto"]?>일  <?php echo $TPL_V2["dayauto_day_title"]?>" title="'결제확인' <?php echo $TPL_V2["dayauto_type_title"]?> <?php echo $TPL_V2["sdayauto"]?>일 <?php if($TPL_V2["dayauto_type"]=='day'){?>이후<?php }?>부터 + <?php echo $TPL_V2["fdayauto"]?>일  <?php echo $TPL_V2["dayauto_day_title"]?>">결제확인' <?php echo $TPL_V2["dayauto_type_title"]?> <?php echo $TPL_V2["sdayauto"]?>일 이후부터 ~ <?php echo $TPL_V2["fdayauto"]?>일  <?php echo $TPL_V2["dayauto_day_title"]?></span>
<?php }?>
<?php }?>
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
				<input type="hidden" name="gdsuboptidx" class="gdsuboptidx" value="">
				<div class="center" style="padding:10px;">
					<span class="btn large black"><button type="button" id="<?php echo $TPL_V1["label_type"]?><?php echo $TPL_V1["codeform_seq"]?>CodeApply" class="GoodsSubOptionCodeApply" codeform_seq="<?php echo $TPL_V1["codeform_seq"]?>"  label_type="<?php echo $TPL_V1["label_type"]?>" label_newtype="<?php echo $TPL_V1["label_newtype"]?>"  label_id="<?php echo $TPL_V1["label_id"]?>" layer_id="<?php echo $TPL_V1["label_type"]?><?php echo $TPL_V1["codeform_seq"]?>_lay">적용하기</button></span>
				</div>
			</td>
		</tr>
		</table>
		<!--//입력폼 -->
	</div>
<?php }}?>
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


<!-- 추가구성옵션관리 다이얼로그 -->
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
<?php if($TPL_VAR["frequentlysublist"]){?>
<?php if($TPL_frequentlysublist_1){foreach($TPL_VAR["frequentlysublist"] as $TPL_V1){?>
			<tr>
				<td><span class="delFreqOptionName_<?php echo $TPL_V1["goods_seq"]?>"><?php echo $TPL_V1["goods_name"]?></span></td>
				<td class="its-th-align center">
					<span class="btn small"><button type="button" class="delFreqOption" value="<?php echo $TPL_V1["goods_seq"]?>" data-type="sub" data-packageyn="<?php echo $TPL_V1["package_yn"]?>">삭제</button></span>
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
	
	<div class="paging_navigation"><?php echo $TPL_VAR["frequentlysubpaginlay"]?></div>
</div>