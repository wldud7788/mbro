<?php /* Template_ 2.2.6 2022/05/17 12:29:10 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/gift_regist.html 000094506 */ 
$TPL_options_1=empty($TPL_VAR["options"])||!is_array($TPL_VAR["options"])?0:count($TPL_VAR["options"]);
$TPL_r_hscode_1=empty($TPL_VAR["r_hscode"])||!is_array($TPL_VAR["r_hscode"])?0:count($TPL_VAR["r_hscode"]);
$TPL_images_1=empty($TPL_VAR["images"])||!is_array($TPL_VAR["images"])?0:count($TPL_VAR["images"]);
$TPL_opts_loop_1=empty($TPL_VAR["opts_loop"])||!is_array($TPL_VAR["opts_loop"])?0:count($TPL_VAR["opts_loop"]);
$TPL_sopts_loop_1=empty($TPL_VAR["sopts_loop"])||!is_array($TPL_VAR["sopts_loop"])?0:count($TPL_VAR["sopts_loop"]);
$TPL_inputs_1=empty($TPL_VAR["inputs"])||!is_array($TPL_VAR["inputs"])?0:count($TPL_VAR["inputs"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/layer_stock.css" />
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/goods_admin.css" />
<style>
.providerTitleContainer {margin-top:25px; border:1px solid #000; padding-left:10px; line-height:40px;}
.providerTitleContainer .ptc-title {float:left; font-size:20px; color:#fff; font-weight:bold;}
.providerTitleContainer .ptc-title b { color:#ffffff; }
.providerTitleContainer .ptc-desc {padding-left:10px; float:left;}
.providerTitleContainer .ptc-charges {color:#eee;}
</style>
<script type="text/javascript" src="/app/javascript/plugin/custom-select-box-basic.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-giftRegist.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-giftReady.js"></script>

<script type="text/javascript">
var gl_service_code				= '<?php echo $TPL_VAR["service_code"]?>';
var gl_ableStockLimit				= <?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]+ 1?>;
var gl_runout						= '<?php echo $TPL_VAR["cfg_order"]["runout"]?>';
var gl_ableStockLimit_org			= <?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]?>;
var gl_default_reserve_percent	= '<?php echo $TPL_VAR["default_reserve_percent"]?>';
var gl_package_yn					= '<?php echo $TPL_VAR["package_yn"]?>';
var gl_provider_seq				= '<?php echo $TPL_VAR["provider_seq"]?>';
var gl_provider_name				= '<?php echo $TPL_VAR["provider"]["provider_name"]?>';
var gl_adminSessionType			= '<?php echo $TPL_VAR["adminSessionType"]?>';
var gl_default_charge				= false;
var gl_scm_use					= '<?php echo $TPL_VAR["scm_cfg"]["use"]?>';

var goodsObj						= <?php echo $TPL_VAR["goodsObj"]?>;

//객체동결(변경금지)
Object.freeze(goodsObj);

var gl_goods_seq					= goodsObj.goods_seq;
var gl_runtout_policy				= goodsObj.runout_policy;
var socialcpuse_flag				= <?php if($TPL_VAR["socialcpuse"]){?>true<?php }else{?>false<?php }?>;
</script>

<script type="text/javascript">
var save_flag = true;

function get_default_commission_rate(){
	var default_charge = num($("input[name='default_charge']").val());
	if($("input[name='firstBrand']").length){
		default_charge = num($("input[name='firstBrand']").attr('charge'));
	}

<?php if($TPL_VAR["provider_seq"]=='1'){?>
		default_charge = 100;
<?php }?>

	return default_charge;
}

// RELATION GOODS
function set_goods_list(displayId,inputGoods){
	$.ajax({
		type: "get",
		url: "../goods/select",
		data: "page=1&inputGoods="+inputGoods+"&displayId="+displayId,
		success: function(result){
			$("div#"+displayId).html(result);
		}
	});
	openDialog("상품 검색", displayId, {"width":"1000","height":"700","show" : "fade","hide" : "fade"});
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

function reserve_policy(){
	if($("select[name='reserve_policy'] option:selected").val() == 'shop'){
<?php if($TPL_VAR["default_reserve_percent"]){?>
		$("input[name='reserveRate[]']").val(<?php echo $TPL_VAR["default_reserve_percent"]?>);
		$("select[name='reserveUnit[]'] option[value='percent']").attr('selected',true);
		calulate_option_price();

		$("input[name='subReserveRate[]']").val(<?php echo $TPL_VAR["default_reserve_percent"]?>);
		$("select[name='subReserveUnit[]'] option[value='percent']").attr('selected',true);
		calulate_subOption_price();
<?php }?>

		$("input[name='reserveRate[]'], select[name='reserveUnit[]'], input[name='reserve[]'], input[name='subReserveRate[]'], select[name='subReserveUnit[]'], input[name='subReserve[]']").css('opacity',0.5);
		$("input[name='reserveRate[]'], select[name='reserveUnit[]'], input[name='subReserveRate[]'], select[name='subReserveUnit[]']").attr('readonly',true);
		$("select[name='reserveUnit[]'] option[value!='percent'], select[name='subReserveUnit[]'] option[value!='percent']").attr('disabled',true);
	}else{
		$("input[name='reserveRate[]'], select[name='reserveUnit[]'], input[name='reserve[]'], input[name='subReserveRate[]'], select[name='subReserveUnit[]'], input[name='subReserve[]']").css('opacity',1);
		$("input[name='reserveRate[]'], select[name='reserveUnit[]'], input[name='subReserveRate[]'], select[name='subReserveUnit[]']").removeAttr('readonly');
		$("select[name='reserveUnit[]'] option[value!='percent'], select[name='subReserveUnit[]'] option[value!='percent']").removeAttr('disabled');
	}
}

function able_save(){
	save_flag = true;
}

/* 저장하기 */
function goods_save(saveType){
	// 저장 후 동작 설정
	$("input[name='save_type']").val(saveType);

	if($(".provider_seq").val()==''){
		openDialogAlert("입점사를 선택해주세요.",400,150,function(){
			$("select[name='provider_seq_selector']").next(".ui-combobox").children("input").eq(0).focus();
		});
		return false;
	}

	if(chk_stockDesc()){
		loadingStart();
		$("#goodsRegist").submit();
	}
}

var nowPath;


$(document).ready(function() {
	$("button.runout_setting").bind("click",function(){
<?php if(serviceLimit('H_FR')){?>
		<?php echo serviceLimit('A1')?>

<?php }else{?>
		openDialog("재고 변화에 따른 상품판매 여부 설정", "popup_runout_setting", {"width":"98%","height":"510","show" : "fade","hide" : "fade"});
<?php }?>
	});

	$( "select[name='provider_seq_selector']" ).combobox().on("change", function(){
		$("input[name='provider_seq']").val($(this).val());
		$("input[name='provider_name']").val($("option:selected",this).text());
	});

<?php if($TPL_VAR["goods"]["tax"]){?>
	$("input[name='tax'][value='<?php echo $TPL_VAR["goods"]["tax"]?>']").attr("checked",true);
<?php }else{?>
	$("input[name='tax'][value='tax']").attr("checked",true);
<?php }?>

	var defaultOption = $("form div#optionLayer").html();

	$("#subOptionMake").live("click",function(){
		openDialog("추가선택옵션", "subOptionMakeDialog", {"width":800,"height":400});
	});

	$("#goodsRegist div.connectCategory").live("click",function(){
		$(this).parent().parent().find("input[type='radio']").attr("checked",true);
	});

	/* 카테고리 불러오기 */
	category_admin_select_load('','category1','');
	$("select[name='category1']").bind("change",function(){
		category_admin_select_load('category1','category2',$(this).val());
		category_admin_select_load('category2','category3',"");
		category_admin_select_load('category3','category4',"");
	});
	$("select[name='category2']").bind("change",function(){
		category_admin_select_load('category2','category3',$(this).val());
		category_admin_select_load('category3','category4',"");
	});
	$("select[name='category3']").bind("change",function(){
		category_admin_select_load('category3','category4',$(this).val());
	});

	/* 브랜드 불러오기 */
	brand_admin_select_load('','brands1','');
	$("select[name='brands1']").bind("change",function(){
		brand_admin_select_load('brands1','brands2',$(this).val());
		brand_admin_select_load('brands2','brands3',"");
		brand_admin_select_load('brands3','brands4',"");
	});
	$("select[name='brands2']").bind("change",function(){
		brand_admin_select_load('brands2','brands3',$(this).val());
		brand_admin_select_load('brands3','brands4',"");
	});
	$("select[name='brands3']").bind("change",function(){
		brand_admin_select_load('brands3','brands4',$(this).val());
	});

	/* 카테고리 연결 팝업*/
	$("#categoryConnectPopup").bind("click",function(){
		openDialog("카테고리 연결", "categoryPopup", {"width":800,"height":500});
	});

	/* 브랜드 연결 팝업*/
	$("#brandConnectPopup").bind("click",function(){
		if($(".provider_seq").val()=='1'){
			$("#base_brand_container").show();
			$("#provider_brand_container").hide();
			$("form[name='brandConnectFrm'] input[name='provider_seq']").val('');
			$("input[type='radio'][name='brandInputMethod'][value='select']").attr('checked',true);
		}else{
			$("#base_brand_container").hide();
			$("#provider_brand_container").show();
			$("form[name='brandConnectFrm'] input[name='provider_seq']").val($(".provider_seq").val());
			$("input[type='radio'][name='brandInputMethod'][value='providerBrand']").attr('checked',true);

			$.ajax({
				'url' : 'provider_brand_list',
				'data' : {'provider_seq':$(".provider_seq").val()},
				'dataType' : 'json',
				'success' : function(res){
					var html = "";
					$("#provider_brand_list").empty();
					if(res.length){
						for(var i=0;i<res.length;i++){
							if(res[i].category_code!=''){
								html += "<div><label><input type='radio' name='providerBrandCode' value='"+res[i].category_code+"' /> "+res[i].brand_name+" ("+res[i].charge+"%)</label></div>";
							}
						}
					}else{
						html = "입점사 "+$(".provider_seq").val()+" 에 설정된 브랜드가 없습니다.";
					}
					$("#provider_brand_list").html(html);

				}
			});
		}
		openDialog("브랜드 연결", "brandPopup", {"width":800,"height":500});
	});

	/* 연결카테고리 삭제 */
	$(".categoryDelete").live("click",function(){
		var cnt = $("input:[name='connectCategory[]']").length;
		if(cnt>1){
			if($(this).parent().parent().parent().parent().find("input[type='radio']").is(":checked")){
				alert("대표 카테고리 변경 후 삭제해 주세요.");
				return;
			}
		}
		var ret = true;
		var present = $(this).parent().parent().parent().parent().find("input[name='connectCategory[]']");
		var flag = present.val();

		$("input:[name='connectCategory[]']").each(function(idx){
			if( $(this).val().substring(0,flag.length) == flag ){
				if( present.val().length < $(this).val().length) ret = false;
			}
		});
		if(!ret){
			alert("하위 카테고리를 먼저 삭제하셔야 합니다.");
			return;
		}

		$(this).parent().parent().parent().parent().remove();

	});

	/* 연결카테고리 삭제 */
	$(".brandDelete").live("click",function(){
		var cnt = $("input:[name='connectBrand[]']").length;
		if(cnt>1){
			if($(this).parent().parent().parent().parent().find("input[type='radio']").is(":checked")){
				alert("대표 브랜드 변경 후 삭제해 주세요.");
				return;
			}
		}
		var ret = true;
		var present = $(this).parent().parent().parent().parent().find("input[name='connectBrand[]']");
		var flag = present.val();

		$("input:[name='connectBrand[]']").each(function(idx){
			if( $(this).val().substring(0,flag.length) == flag ){
				if( present.val().length < $(this).val().length) ret = false;
			}
		});
		if(!ret){
			alert("하위 브랜드를 먼저 삭제하셔야 합니다.");
			return;
		}

		$(this).parent().parent().parent().parent().remove();

	});


	//$("#iconViewTable").find(".datepicker").datepicker("destroy");
	var iconClone = $("#iconViewTable tbody tr").eq(1).clone();
	iconClone.find("input[type='text']").each(function(){
		$(this).val("");
	});


	$("#iconViewTable").find("input[name='iconDate[]']").addClass('datepicker');
	setDatepicker($("#iconViewTable").find("input[name='iconDate[]']"));


	iconClone.find("select").each(function(){
		$(this).find("option").eq(0).attr("selected",true);
	});
	<!-- <?php if(!$TPL_VAR["icons"]){?> -->
	$("#iconViewTable tbody tr").eq(1).remove();
	<!-- <?php }?> -->
	/* 아이콘 추가 */
	$("#iconViewTable button#iconAdd").live("click",function(){
		var newClone = iconClone.clone();
		var trObj = $("#iconViewTable tbody tr");

		newClone.find("input[type='text']").addClass('datepicker');

		trObj.parent().append(newClone);

		apply_input_style(newClone.find("input[type='text']"));
	});

	/* 아이콘 삭제 */
	$("#iconViewTable button.iconDel").live("click",function(){
		if($("#iconViewTable tbody tr").length > 1) $(this).parent().parent().parent().remove();
	});

	/* 선택된 아이콘 출력 */
	$("#iconViewTable .goodsIcon").live("click",function(){
		var trObj = $("#iconViewTable tbody").children("tr");
		var idx = trObj.index(trObj.has(this));
		$("input[name='iconIndex']").val(idx);
		set_goods_icon();
		closeDialog("goodsIconPopup");
		openDialog("아이콘 선택  <span class='desc'>아이콘으로 사용할 이미지를 클릭하여 주세요.</span>", "goodsIconPopup", {"width":"570","height":"200","show" : "fade","hide" : "fade"});
		//changeFileStyle();
	});
	changeFileStyle();

	/* 아이콘 선택 */
	$("#goodsIconPopup img.icon").live("click",function(){
		var idx = $("input[name='iconIndex']").val();
		$("#iconViewTable tbody tr").eq(idx).children("td").eq(1).find("img").attr("src",$(this).attr("src"));
		var arr = $(this).attr("src").split(".");
		var selectedIndex = arr[0].replace("/data/icon/goods/","");
		$("input[name='goodsIcon[]']").eq(idx-1).val(selectedIndex);
		closeDialog("goodsIconPopup");
	});

	/* 추가정보 추가*/
	var etcClone = $("#etcViewTable tbody tr").eq(1).clone();
	etcClone.find("input[type='text']").each(function(){
		$(this).val("");
	});
	etcClone.find("input[type='hidden']").each(function(){
		$(this).val("model");
	});
	etcClone.find("select").each(function(){
		$(this).find("option").eq(0).attr("selected",true);
	});
	<!-- <?php if(!$TPL_VAR["additions"]){?> -->
	$("#etcViewTable tbody tr").eq(1).remove();
	<!-- <?php }?> -->
	$("#etcViewTable button#etcAdd").live("click",function(){
		var trObj = $("#etcViewTable tbody tr");
		trObj.parent().append(etcClone.clone());
	});


	$("#viewGoods").click(function(){
		window.open("/goods/view?no="+$(this).attr("goods_seq"),'','');
	});


	/* 추가정보 삭제 */
	$("#etcViewTable button.etcDel").live("click",function(){
		if($("#etcViewTable tbody tr").length > 1) $(this).parent().parent().parent().remove();
	});

	/* 직업입력 선택시 */
	$("select[name='selectEtcTitle[]']").live("click",function(){
		if( $(this).find("option[value='direct']").attr('selected') == 'selected'){
			$(this).parent().find("span").removeClass("hide");
		}else{
			$(this).parent().find("span").addClass("hide");
		}
	});

	/* 필수옵션만들기*/
	$("#optionMake").live("click",function(){
		openDialog("필수옵션 만들기", "optionMakePopup", {"width":"700","height":"350","show" : "fade","hide" : "fade"});
	});


	$("#star_select").click(function(){
		var status = "";
		if($(this).hasClass("checked")){
			$(this).removeClass("checked");
			status = "none";
		}else{
			$(this).addClass("checked");
			status = "checked";
		}

		$.ajax({
			type: "get",
			url: "../goods/set_favorite",
			data: "status="+status+"&goods_seq="+$(this).attr("goods_seq"),
			success: function(result){
				//alert(result);
			}
		});
	});


	/* 필수옵션 만들기 폼 */
	$("#addOptionMake").live("click",function(){
		/* 원더플레이스 */
		if($("#optionMakePopup table tbody tr").length>=2){
			openDialogAlert("옵션은 2차까지만 등록 가능합니다.",400,140,'');
			return false;
		}
		var clone = $(this).parent().parent().parent().clone();
		clone.find("#addOptionMake").attr("id","").addClass("delOptionMake");
		clone.find("span").removeClass("btn-plus");
		clone.find("span").addClass("btn-minus");

		/* 원더플레이스 */
		clone.find("input[name='optionMakeName[]']").val("SIZE").removeAttr("readonly");

		if($("#optionMakePopup table tbody tr").index() < 4) $("#optionMakePopup table tbody").append(clone);
	});
	/* 옵션만들기 폼 삭제하기 */
	$(".delOptionMake").live("click",function(){
		$(this).parent().parent().parent().remove();
	});
	/* 옵션만들기  */
	$("#OptionMakeApply").live("click",function(){
		//make_option();
		//check_button_optionBatch();
	});

	/* 옵션가격 일괄 적용 */
	$("button#optionBatch").bind("click",function(){
		batch_option_price();
		calulate_option_price();
	});
	$("input[name='defaultOption']").click(function(){
		var index = $(this).attr("index");
		$("input[name='defaultOption']").each(function(idx){
			if(index!=idx){
				$("input[name='defaultOption']").eq(idx).attr("checked",false);
			}
		});
		$("input[name='defaultOption']").eq(index).attr("checked",true);
	});

	/* 옵션삭제하기  */
	$(".removeOption").live("click",function(){
		if( $(this).parent().parent().parent().parent().find("tr").length > 1 ) $(this).parent().parent().parent().remove();
	});
	$("input[name='supplyPrice[]']").live("blur",function(){calulate_option_price();});
	$("input[name='consumerPrice[]']").live("blur",function(){calulate_option_price();});
	$("input[name='price[]']").live("blur",function(){calulate_option_price();});
	$("input[name='reserveRate[]']").live("blur",function(){calulate_option_price();});
	$("select[name='reserveUnit[]']").live("change",function(){calulate_option_price();});
	$("input[name='reserve[]']").live("blur",function(){calulate_option_price();});
	$("input[name='subReserveRate[]']").live("blur",function(){calulate_subOption_price();});
	$("select[name='subReserveUnit[]']").live("change",function(){calulate_subOption_price();});
	$("input[name='subReserve[]']").live("blur",function(){calulate_subOption_price();});
	$("input[name='tax']").live("click",function(){calulate_option_price();});

	/* 옵션만들기 초기가격 넣기*/
	$("div#optionMakePopup input[name='optionMakeValue[]']").live("blur",function(){
		var tmp = optReplace($(this).val());
		$(this).val(tmp);

		var obj = $(this).parent().next().find("input[name='optionMakePrice[]']");
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
	});

	/* 옵션 단일 추가*/
	$("div#optionLayer button#addOption").live("click",function(){
		$("div#optionLayer table").append( $("div#optionLayer tr.optionTr").last().clone() );
	});


	// 서브옵션 만들기
	$("#suboptionMakeApply").live("click",function(){
		make_suboption();
	});

	// 서브옵션 만들기폼 추가
	$("#addSuboptionMake").bind("click",function(){
		var objTr = $(this).parent().parent().parent();
		var objTb = $(this).parent().parent().parent().parent();
		var clone = objTr.clone();
		clone.find("#addSuboptionMake").attr("id","").addClass("delSuboptionMake");
		clone.find("span").removeClass("btn-plus");
		clone.find("span").addClass("btn-minus");
		objTb.append(clone);
		calulate_subOption_price();
	});
	/* 옵션만들기 폼 삭제하기 */
	$(".delSuboptionMake").live("click",function(){
		$(this).parent().parent().parent().remove();
	});

	$("input[name='subSupplyPrice[]']").live("blur",function(){calulate_subOption_price();});
	$("input[name='subConsumerPrice[]']").live("blur",function(){calulate_subOption_price();});
	$("input[name='subPrice[]']").live("blur",function(){calulate_subOption_price();});

	$("form .delSuboptionButton").live("click",function(){
		var removeVar = false;
		var clickTitleInput = $(this).parent().parent().next().find("input").val();
		if ( clickTitleInput ){
			$("form .delSuboptionButton").each(function(){
				var titleInput = $(this).parent().parent().next().find("input").val();
				if( titleInput && titleInput == clickTitleInput ) removeVar = true;
				if( titleInput && titleInput != clickTitleInput ) removeVar = false;
				if( removeVar ) $(this).parent().parent().parent().remove();
			});
		}else{
			$(this).parent().parent().parent().remove();
		}

		var objTr = $("div#suboptionLayer table").find("tr");
		if( objTr.length <= 2 ) objTr.parent().parent().remove();
	});

	/* 서브 옵션만들기 초기가격 넣기*/
	$("div#subOptionMakeDialog input[name='suboptionMakeValue[]']").live("blur",function(){
		var tmp = optReplace($(this).val());
		$(this).val(tmp);

		var obj = $(this).parent().next().find("input[name='suboptionMakePrice[]']");
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
	});

	/* 추가옵션가격 일괄 적용 */
	$("form button#subOptionBatch").live("click",function(){
		batch_suboption_price();
		calulate_subOption_price();
	});

	/* 구매자 추가입력 사용 만들기 다이얼로그박스 */
	$("form button#memberInputMake").bind("click",function(){
		openDialog("추가옵션 만들기", "memberInputDialog", {"width":"600","height":"350","show" : "fade","hide" : "fade"});
	});

	/* 구매자 추가입력 사용 만들기 */
	$("button#addMemberInputMake").bind("click",function(){
		var objTr = $(this).parent().parent().parent();
		//var clone = $("div#memberInputDialog table tbody tr#firstMemberInput").clone();
		var clone = objTr.clone();
		clone.attr("id","");
		clone.attr("class","memberInput");
		clone.find("button").attr("id","");
		clone.find("button").attr("class","delMemberInputMake");
		clone.find("span").removeClass("btn-plus");
		clone.find("span").addClass("btn-minus");
		$("div#memberInputDialog table tbody").append(clone);
	});

	$("select[name='memberInputMakeForm[]']").live("change",function(){
		check_memberInputMakeForm();
	});

	/* 구매자 추가입력  만들기삭제 */
	$("div#memberInputDialog button.delMemberInputMake").live("click",function(){
		$(this).parent().parent().parent().remove();
	});

	/* 구매자 추가입력 만들기 적용 */
	$("div#memberInputDialog button#memberInputMakeApply").live("click",function(){
		var tag = get_memberInput_title();
		var target = $("form div#memberInputLayer");
		target.html(tag);
		tag = get_memberInput();
		target.find("table").append(tag);
		changeFileStyle();
	});

	/* 구매자 추가입력 삭제 */
	$("form button.delMemberInput").live("click",function(){
		if( $(this).parent().parent().parent().parent().children().length == 1 ) $("form div#memberInputLayer").html("");
		else $(this).parent().parent().parent().remove();
	});

	check_memberInputMakeForm();

	/* 가격 대체 문구 */
	$("input[name='stringPriceUse']").bind("click",function(){
		show_stringPrice();
	});

	/* 복수구매 할인 */
	$("input[name='multiDiscountUse']").bind("click",function(){
		show_multiDiscountUse();
	});

	$("input[name='minPurchaseLimit']").bind("click",function(){
		show_minPurchaseLimit();
	});

	/* 최대 구매수량 */
	$("input[name='maxPurchaseLimit']").bind("click",function(){
		show_maxPurchaseLimit();
	});

	/* 필수옵션 사용 */
	$("input[name='optionUse']").bind("click",function(){
<?php if($TPL_VAR["opts_loop"]){?>
		if(!$(this).is(':checked')){
			if(!confirm("필수옵션 사용을 해제 할 경우 기존에 작성한 내용은 사라집니다.\n다만, 필수옵션 만들기 클릭시 옵션명,값,가격등의 기초정보는 확인하실 수 있습니다.")){
				$(this).attr("checked",true);
				return;
			}
		}
<?php }?>
		show_optionUse();
	});

	/* 추가옵션 사용 */
	$("input[name='subOptionUse']").bind("click",function(){
<?php if($TPL_VAR["sopts_loop"]){?>
		if(!$(this).is(':checked')){
			if(!confirm("추가구성옵션 사용을 해제 할 경우 기존에 작성한 내용은 사라집니다.\n다만, 추가구성옵션 만들기 클릭시 옵션명,값,가격등의 기초정보는 확인하실 수 있습니다.")){
				$(this).attr("checked",true);
				return;
			}
		}
<?php }?>
		show_subOptionUse();
	});

	/* 구매자 추가입력 */
	$("input[name='memberInputUse']").bind("click",function(){
<?php if($TPL_VAR["inputs"]){?>
		if(!$(this).is(':checked')){
			if(!confirm("추가입력옵션 사용을 해제 할 경우 기존에 작성한 내용은 사라집니다.\n다만, 추가입력옵션 만들기 클릭시 확인하실 수 있습니다.")){
				$(this).attr("checked",true);
				return;
			}
		}
<?php }?>
		show_memberInputUse();
	});

	<!-- <?php if($TPL_VAR["goods"]["view_layout"]){?> -->
	$("form[name='goodsRegist'] input[name='viewLayout'][value='<?php echo $TPL_VAR["goods"]["view_layout"]?>']").attr("checked",true);
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["goods_status"]){?> -->
	$("form[name='goodsRegist'] input[name='goodsStatus'][value='<?php echo $TPL_VAR["goods"]["goods_status"]?>']").attr("checked",true);
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["goods_view"]){?> -->
	$("form[name='goodsRegist'] input[name='goodsView'][value='<?php echo $TPL_VAR["goods"]["goods_view"]?>']").attr("checked",true);
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["string_price_use"]){?> -->
	$("form[name='goodsRegist'] input[name='stringPriceUse']").attr("checked",true);
	show_stringPrice();
	<!-- <?php }?> -->

	<!-- <?php if($TPL_VAR["goods"]["multi_discount_use"]){?> -->
	$("form[name='goodsRegist'] input[name='multiDiscountUse']").attr("checked",true);
	show_multiDiscountUse();
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["multi_discount_unit"]){?> -->
	$("form[name='goodsRegist'] select[name='multiDiscountUnit'] option[value='<?php echo $TPL_VAR["goods"]["multi_discount_unit"]?>']").attr("selected",true);
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["goods_view"]){?> -->
	$("form[name='goodsRegist'] input[name='minPurchaseLimit'][value='<?php echo $TPL_VAR["goods"]["min_purchase_limit"]?>']").attr("checked",true);
	show_minPurchaseLimit();
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["max_purchase_limit"]){?> -->
	$("form[name='goodsRegist'] input[name='maxPurchaseLimit'][value='<?php echo $TPL_VAR["goods"]["max_purchase_limit"]?>']").attr("checked",true);
	show_maxPurchaseLimit();
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["max_purchase_order_limit"]){?> -->
	$("form[name='goodsRegist'] select[name='maxPurchaseOrderLimit'] option[value='<?php echo $TPL_VAR["goods"]["max_purchase_order_limit"]?>']").attr("selected",true);
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["option_use"]){?> -->
	$("form[name='goodsRegist'] input[name='optionUse']").attr("checked",true);
	show_optionUse();
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["option_view_type"]){?> -->
	$("form[name='goodsRegist'] select[name='optionViewType'] option[value='<?php echo $TPL_VAR["goods"]["option_view_type"]?>']").attr("selected",true);
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["option_suboption_use"]){?> -->
	$("form[name='goodsRegist'] input[name='subOptionUse']").attr("checked",true);
	show_subOptionUse();
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["member_input_use"]){?> -->
	$("form[name='goodsRegist'] input[name='memberInputUse']").attr("checked",true);
	show_memberInputUse();
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["shipping_policy"]){?> -->
	$("input[name='shippingPolicy'][value='<?php echo $TPL_VAR["goods"]["shipping_policy"]?>']").attr("checked",true);
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["goods_shipping_policy"]){?> -->
	$("input[name='goodsShippingPolicy'][value='<?php echo $TPL_VAR["goods"]["goods_shipping_policy"]?>']").attr("checked",true);
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["shipping_weight_policy"]){?> -->
	$("input[name='shippingWeightPolicy'][value='<?php echo $TPL_VAR["goods"]["shipping_weight_policy"]?>']").attr("checked",true);
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["option_view_type"]){?> -->
	$("form[name='goodsRegist'] select[name='reserve_policy'] option[value='<?php echo $TPL_VAR["goods"]["reserve_policy"]?>']").attr("selected",true);
	<!-- <?php }?> -->

	<!-- <?php if($TPL_VAR["goods"]["info_seq"]){?> -->
	$("form[name='goodsRegist'] select[name='info_select'] option[value='<?php echo $TPL_VAR["goods"]["info_seq"]?>']").attr("selected",true);
	if($("form[name='goodsRegist'] select[name='info_select'] option:selected").val()){
		$("input[name='info_name']").val($("form[name='goodsRegist'] select[name='info_select'] option:selected").text());
	}
	<!-- <?php }?> -->
	<!-- <?php if($TPL_VAR["goods"]["relation_type"]){?> -->
	$("input[name='relation_type'][value='<?php echo $TPL_VAR["goods"]["relation_type"]?>']").attr("checked",true);
	if('<?php echo $TPL_VAR["goods"]["relation_type"]?>'=='MANUAL') $("#relation_btn").show();
	<!-- <?php }?> -->

<?php if($TPL_VAR["goods"]["goods_seq"]){?>
	default_img();
<?php }?>

	// COMMON INFO
	$("select[name='info_select']").live("change", function(){
		var text = $("select[name='info_select'] option:selected").text();
		if(!$(this).val()){
			$("input[name='info_name']").val('');
			return;
		}
		$("input[name='info_name']").val(text);
		$.get('../goods_process/get_info?seq='+$(this).val(), function(response) {
			var data = eval(response)[0];
			Editor.switchEditor($("#commonContents").data("initializedId"));
			Editor.modify({"content" : data.contents});
		});
	});

	// RELATION GOODS
	$("form#goodsRegist button#relationGoodsButton").bind("click",function(){
		set_goods_list("relationGoodsSelect","relationGoods");
		$(window).css("overflow-y","hidden");
	});
	$("#relationGoods").sortable();
	$("#relationGoods").disableSelection();

	// RELATION RADIO
	$("input[name='relation_type']").click(function(){
		if($(this).val()=='AUTO'){
			$("#relation_btn").hide();
			$("#relationGoods").hide();
		}else{
			$("#relation_btn").show();
			$("#relationGoods").show();
		}
	});

	/*필수 옵션 미리보기*/
	$("#optionPreview").click(function(){
		var optCnt = $("input:[name='optionTitle[]']").length;
		var html = "<div style='border:1px #aaaaaa solid;background-color:#eeeeee;'><table class=\"goods_option_table\" width=\"100%\" cellpadding=\"0\" cellspacing=\"5\" border=\"0\">";
		if(optCnt>0){
			var gb = $("select[name='optionViewType']").val();
			var tmp = "";
			if(gb=='divide'){
				for(var i=0;i<optCnt;i++){
					html += "<tr>";
					html += "<th>"+$("input:[name='optionTitle[]']").eq(i).val()+"</th>";
					html += "<td><select style='width:200px;'><option>- 선택 -</option>";
					var opt = document.getElementsByName("opt["+i+"][]");
					if(i==0){
						for(var j=0;j<opt.length;j++){
							if(tmp!=opt[j].value) html += "<option>"+opt[j].value+"</option>";
							tmp = opt[j].value;
						}
					}else{
						var opts = document.getElementsByName("optionMakeValue[]");
						var tmp_arr = opts[i].value.split(",");
						for(var j=0;j<tmp_arr.length;j++){
							html += "<option>"+tmp_arr[j]+"</option>";
						}
					}
					html += "</select><td>";
					html += "</tr>";
				}
			}else{
				html += "<tr>";
				html += "<th>옵션</th>";
				html += "<td><select style='width:200px;'><option>- 선택 -</option>";
				var opt = document.getElementsByName("opt[0][]");
				for(var i=0;i<opt.length;i++){
					var opt_name = "";
					for(var j=0;j<optCnt;j++){
						var tmp_opt = document.getElementsByName("opt["+j+"][]");
						opt_name += tmp_opt[i].value;
						if(j!=optCnt-1) opt_name += " / ";
					}
					html += "<option>"+opt_name+"</option>";
				}
				html += "</select><td>";
				html += "</tr>";
			}
			html += "</table></div>";


			$("#popPreviewOpt").html(html);
			openDialog("필수옵션 미리보기", "popPreviewOpt", {"width":"370","height":"180","show" : "fade","hide" : "fade"});

		}
	});


	$("#subOptionPreview").click(function(){
		var optCnt = $("input:[name='suboptTitle[]']").length;
		if(optCnt>0){
			var tmp_cnt = 0;
			var html = "<div style='border:1px #aaaaaa solid;background-color:#eeeeee;'><table class=\"goods_option_table\" width=\"100%\" cellpadding=\"0\" cellspacing=\"5\" border=\"0\">";
			for(var i=0;i<optCnt;i++){
				html += "<tr>";
				html += "<th>"+$("input:[name='suboptTitle[]']").eq(i).val()+"</th>";
				html += "<td><select style='width:200px;'><option>선택안함</option>";

				var opt	= document.getElementsByName("subopt["+i+"][]");
				for(var j=0;j<opt.length;j++){
					var price = $("input:[name='subPrice[]']").eq(tmp_cnt).val();
					html += "<option>"+opt[j].value+" (추가 "+price+"원)</option>";
				}
				html += "</select><td>";
				html += "</tr>";
			}
			html += "</table></div>";

			$("#popPreviewOpt").html(html);
			openDialog("추가구성옵션 미리보기", "popPreviewOpt", {"width":"370","height":"180","show" : "fade","hide" : "fade"});
		}
	});


	$("#memberInputPreview").click(function(){
		var optCnt = $("input:[name='memberInputForm[]']").length;
		var height = 100;
		if(optCnt){
			var html = "<div style='border:1px #aaaaaa solid;background-color:#eeeeee;'><table class=\"goods_option_table\" width=\"100%\" cellpadding=\"0\" cellspacing=\"5\" border=\"0\">";

			for(var i=0;i<optCnt;i++){
				html += "<tr><th style='text-align:left;'>"+$("input:[name='memberInputName[]']").eq(i).val()+"</th></tr>";
				html += "<tr><td>";
				var value = $("input:[name='memberInputForm[]']").eq(i).val();
				if(value=='edit'){
					html += "<textarea style='width:300px;' rows='3'></textarea>";
					height += 80;
				}else if(value=='file'){
					html += "<input type='file' class='line' style='width:300px;'>";
					height += 50;
				}else{
					html += "<input type='text' class='line' style='width:300px;'			 style='width:300px;'>";
					height += 50;
				}
				html += "</td></tr>";
			}

			html += "<tr>";
			html += "</tr>";

			html += "</table></div>";

			$("#popPreviewOpt").html(html);
			openDialog("추가입력 미리보기", "popPreviewOpt", {"width":"370","height":height,"show" : "fade","hide" : "fade"});
		}
	});


	$("input[name='relation_count_w']").live("keyup",function(){
		relation_count_chk();
	});
	$("input[name='relation_count_h']").live("keyup",function(){
		relation_count_chk();
	});


	$("#manager_copy_btn").click(function(){
		if(!confirm("이 상품을 복사해서 상품을 등록하시겠습니까?")) return;

		$.ajax({
			type: "get",
			url: "../goods_process/goods_copy",
			data: "goods_seq="+$(this).attr("goods_seq"),
			success: function(result){
				//alert(result);
				alert("등록 되었습니다.");
				location.href = "../goods/gift_catalog";
			}
		});
	});


	// GOODS
	$(document).bind('keydown', 'Ctrl+s', function(){
		if(save_flag){
			save_flag = false;
			//submitEditorForm(document.goodsRegist);
			$("#goodsRegist").submit();
		}
		return false;
	});

	$("input:text").bind('keydown', 'Ctrl+s', function(){
		if(save_flag){
			save_flag = false;
			//submitEditorForm(document.goodsRegist);
			$("#goodsRegist").submit();
		}
		return false;
	});

	$("select[name='reserve_policy']").bind("change",function(){
		reserve_policy();
	});

	calulate_option_price();

		// 추가혜택 통합설정
	$("#goods_benefits_btn").live("click",function(){
		$.ajax({
			type: "get",
			url: "../goods/benefits_info",
			data: "goods_seq=<?php echo $TPL_VAR["goods"]["goods_seq"]?>",
			success: function(result){
				$("#popup_benefits").html(result);
			}
		});
		openDialog("추가 혜택  통합 설정", "popup_benefits", {"width":"1000","height":"340","show" : "fade","hide" : "fade"});
		event.preventDefault();
		return false;
	});

	// 추가혜택 보기
	$.ajax({
		type: "get",
		url: "../goods/benefits",
		data: "goods_seq=<?php echo $TPL_VAR["goods"]["goods_seq"]?>",
		success: function(result){
			$("#goods_benefits").html(result);
		}
	});

	calulate_option_price();
	calulate_subOption_price();

	reserve_policy();

	/* 화면보기 버튼 */
	$("#viewGoods").closest("li")
	.bind('mouseenter',function(){
		$("ul.gnb-subnb",this).stop(true,true).slideDown('fast');
	})
	.bind('mouseleave',function(){
		$("ul.gnb-subnb",this).stop(true,true).slideUp('fast');
	});

<?php if($TPL_VAR["goods"]["goods_seq"]){?>
	chk_stockDesc();
<?php }?>

	/* 옵션 재고조정하기 버튼 */
	$("button#optionStockEdit").click(function(){
		var optionTitleData = [];
		var optionData = [];
		var optCnt = $("input:[name='optionTitle[]']").length;

		var optTitle = document.getElementsByName("optionTitle[]");
		var opt = document.getElementsByName("opt[0][]");
		var supplyPrice = document.getElementsByName("supplyPrice[]");

		for(var j=0;j<optTitle.length;j++){
			optionTitleData[j] = optTitle[j].value;
		}

		for(var i=0;i<opt.length;i++){
			var opt_names = [];
			for(var j=0;j<optCnt;j++){
				var tmp_opt = document.getElementsByName("opt["+j+"][]");
				opt_names[j] = tmp_opt[i].value;
			}
			optionData[i] = {
				'opt_names' : opt_names,
				'supply_price' : supplyPrice[i].value
			};
		}

		openDialogPopup("재고 조정","stockModifyPopup",{
			'width':'700',
			'height':'600',
			'url':'stock_modify',
			'data':{
				'mode'			: 'optionStockEdit',
				'goods_seq'		: '<?php echo $TPL_VAR["goods"]["goods_seq"]?>',
				'optionTitle'	: optionTitleData,
				'optionData'	: optionData
			}
		});
	});

	/* 추가옵션 재고조정하기 버튼 */
	$("button#subOptionStockEdit").click(function(){
		var subOptionTitleData = [];
		var subOptionData = [];
		var subOptCnt = $("input:[name='suboptTitle[]']").length;

		var subOptTitle = document.getElementsByName("suboptTitle[]");
		var subOpt = document.getElementsByName("subopt[0][]");
		var subSupplyPrice = document.getElementsByName("subSupplyPrice[]");

		for(var j=0;j<subOptTitle.length;j++){
			subOptionTitleData[j] = subOptTitle[j].value;
		}

		for(var i=0;i<subOpt.length;i++){
			var subOpt_names = [];
			for(var j=0;j<subOptCnt;j++){
				var tmp_opt = document.getElementsByName("subopt["+j+"][]");
				subOpt_names[j] = tmp_opt[i].value;
			}
			subOptionData[i] = {
				'opt_names' : subOpt_names,
				'supply_price' : subSupplyPrice[i].value
			};
		}

		openDialogPopup("재고 조정","stockModifyPopup",{
			'width':'700',
			'height':'600',
			'url':'stock_modify',
			'data':{
				'mode'			: 'subOptionStockEdit',
				'goods_seq'		: '<?php echo $TPL_VAR["goods"]["goods_seq"]?>',
				'optionTitle'	: subOptionTitleData,
				'optionData'	: subOptionData
			}
		});
	});


	/* 옵션 재고조정 히스토리 */
	$("button#optionStockEditHistory, button#subOptionStockEditHistory").click(function(){
		window.open("../stock/history_catalog?goods_seq=<?php echo $TPL_VAR["goods"]["goods_seq"]?>");
	});

	/* 본사에서 입점사 상품등록시 입점사 수수료율 출력 */
	$("select[name='provider_seq']").change(function(){
		var provider_seq = $(this).val();
		$.ajax({
			'url' : 'provider_charge_list',
			'data' : {'provider_seq':$(".provider_seq").val()},
			'dataType' : 'json',
			'global' : false,
			'success' : function(res){
				var html = "";
				$(".ptc-charges").empty();
				if(res.length){
					for(var i=0;i<res.length;i++){
						if(i) html += ' / ';
						html += res[i].link=='1' ? '기본' : res[i].brand_name;
						html += '(' + comma(num(res[i].charge)) + '%)';

						if(res[i].link=='1'){
							$("input[name='default_charge']").val(res[i].charge);
						}
					}
				}else{
					html = "입점사 "+$(".provider_seq").val()+" 에 설정된 브랜드가 없습니다.";
				}
				$(".ptc-charges").html(html);
			}
		});
	}).change();

	//입점사 버전일경우
<?php if($TPL_VAR["config_system"]["solution_division"]){?>

	var previous_provider_seq	= '';

	/* 본사에서 입점사 상품등록시 입점사 수수료율 출력 */
	$("select[name='provider_seq_selector']").change(function(event){
		var tmp_option_seq		= $("input[name='tmp_option_seq']").val();
		var tmp_suboption_seq	= $("input[name='tmp_suboption_seq']").val();

		var selected_val		= this;

		if(	(tmp_option_seq != '' && $('input[name="optionUse"]').is(':checked')) ||
			(tmp_suboption_seq != '' && $('input[name="subOptionUse"]').is(':checked'))
		){
			openDialogConfirm('입점사를 변경하면 입력하신 옵션의 수수료는 리셋 됩니다.<br/>계속 하시겠습니까?',400,200,do_provider_change,do_rollback);
		}else{
			do_provider_change();
		}


		function do_provider_change(){
			var provider_seq		= $(selected_val).val();
			previous_provider_seq	= provider_seq;

			if(provider_seq == '1' || provider_seq == ''){
				$('.not_for_provider').show();
				$('.not_for_seller').hide();
			}else{
				$('.not_for_provider').hide();
				$('.not_for_seller').show();
			}
		}


		function do_rollback(){
			$("select[name='provider_seq_selector']").val(previous_provider_seq);
			$("input[name='provider_seq']").val(previous_provider_seq);

			var text	= $("select[name='provider_seq_selector']>option[value='" + previous_provider_seq +"']").text();
			$('.ui-combobox-input').val(text);
			$("input[name='provider_name']").val(text);
		}


	}).change();

<?php }?>
});
</script>

<!-- <?php if($TPL_VAR["goods"]["goods_seq"]){?> -->
<form name="goodsRegist" id="goodsRegist" method="post" enctype="multipart/form-data" action="../goods_process/modify" target="actionFrame">
<input type="hidden" name="goodsSeq" value="<?php echo $TPL_VAR["goods"]["goods_seq"]?>" />
<input type="hidden" name="query_string" value="<?php echo $TPL_VAR["query_string"]?>"/>
<input type="hidden" name="default_charge" value="<?php echo $TPL_VAR["provider"]["charge"]?>" />
<input type="hidden" name="old_update_date" value="<?php echo $TPL_VAR["goods"]["update_date"]?>" />
<input type="hidden" name="provider_seq" value="<?php echo $TPL_VAR["goods"]["provider_seq"]?>" />
<input type="hidden" name="goodsView" value="<?php echo $TPL_VAR["goods"]["goods_view"]?>" />
<input type="hidden" name="tax" value="<?php echo $TPL_VAR["goods"]["tax"]?>" />
<input type="hidden" name="minPurchaseLimit" value="<?php echo $TPL_VAR["goods"]["min_purchase_limit"]?>" />
<input type="hidden" name="maxPurchaseLimit" value="<?php echo $TPL_VAR["goods"]["max_purchase_limit"]?>" />
<input type="hidden" name="possible_pay_type_hidden" value="<?php echo $TPL_VAR["goods"]["possible_pay_type_hidden"]?>" />
<input type="hidden" name="goods_modify_ok" id="goods_modify_ok" value=""/>
<!-- <?php }else{?> -->
<form name="goodsRegist" id="goodsRegist" method="post" enctype="multipart/form-data" action="../goods_process/regist" target="actionFrame">
<input type="hidden" name="default_charge" value="0" />
<input type="hidden" name="goodsView" value="look" />
<input type="hidden" name="tax" value="tax" />
<input type="hidden" name="minPurchaseLimit" value="unlimit" />
<input type="hidden" name="maxPurchaseLimit" value="unlimit" />
<input type="hidden" name="possible_pay_type_hidden" value="shop" />
<!-- <?php }?> -->

<input type="hidden" name="provider_status" value="1" />
<input type="hidden" name="runout_policy" value="" />
<input type="hidden" name="able_stock_limit" value=""/>
<input type="hidden" name="goods_type" value="gift" />
<input type="hidden" name="save_type" value="view" />

<input type="hidden" name="string_price_use" value="">
<input type="hidden" name="string_price" value="">
<input type="hidden" name="string_price_color" value="">
<input type="hidden" name="string_price_link" value="">
<input type="hidden" name="string_price_link_url" value="">
<input type="hidden" name="string_price_link_target" value="">

<input type="hidden" name="member_string_price_use" value="">
<input type="hidden" name="member_string_price" value="">
<input type="hidden" name="member_string_price_color" value="">
<input type="hidden" name="member_string_price_link" value="">
<input type="hidden" name="member_string_price_link_url" value="">
<input type="hidden" name="member_string_price_link_target" value="">

<input type="hidden" name="allmember_string_price_use" value="">
<input type="hidden" name="allmember_string_price" value="">
<input type="hidden" name="allmember_string_price_color" value="">
<input type="hidden" name="allmember_string_price_link" value="">
<input type="hidden" name="allmember_string_price_link_url" value="">
<input type="hidden" name="allmember_string_price_link_target" value="">

<input type="hidden" name="string_button_use" value="">
<input type="hidden" name="string_button" value="">
<input type="hidden" name="string_button_color" value="">
<input type="hidden" name="string_button_link" value="">
<input type="hidden" name="string_button_link_url" value="">
<input type="hidden" name="string_button_link_target" value="">

<input type="hidden" name="member_string_button_use" value="">
<input type="hidden" name="member_string_button" value="">
<input type="hidden" name="member_string_button_color" value="">
<input type="hidden" name="member_string_button_link" value="">
<input type="hidden" name="member_string_button_link_url" value="">
<input type="hidden" name="member_string_button_link_target" value="">

<input type="hidden" name="allmember_string_button_use" value="">
<input type="hidden" name="allmember_string_button" value="">
<input type="hidden" name="allmember_string_button_color" value="">
<input type="hidden" name="allmember_string_button_link" value="">
<input type="hidden" name="allmember_string_button_link_url" value="">
<input type="hidden" name="allmember_string_button_link_target" value="">

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<!-- <?php if($TPL_VAR["goods"]["goods_seq"]){?> -->
			<h2>
				<span class="icon-star-gray <?php echo $TPL_VAR["goods"]["favorite_chk"]?>" id="star_select" goods_seq="<?php echo $TPL_VAR["goods"]["goods_seq"]?>"></span>
				[<?php echo $TPL_VAR["goods"]["goods_seq"]?>]
				<?php echo getstrcut($TPL_VAR["goods"]["title"], 20)?>

				<span class="pdl20 fx11 normal">
					<span class="goods_status_color_<?php echo $TPL_VAR["goods"]["goods_status"]?>"><?php echo $TPL_VAR["goods"]["goods_status_text"]?></span>,
					<span class="goods_view_color_<?php echo $TPL_VAR["goods"]["goods_view"]?>"><?php echo $TPL_VAR["goods"]["goods_view_text"]?></span>
				</span>
			</h2>
			<!-- <?php }else{?> -->
			<h2>사은품등록</h2>
			<!-- <?php }?> -->
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span class="btn large white"><button type="button" onclick="document.location.href='/selleradmin/goods/gift_catalog?<?php echo $TPL_VAR["query_string"]?>';">사은품리스트<span class="arrowright"></span></button></span></li>
			<!-- <?php if($TPL_VAR["goods"]["goods_seq"]){?> -->
			<li><span class="btn large black"><button type="button" id="manager_copy_btn"  goods_seq="<?php echo $TPL_VAR["goods"]["goods_seq"]?>">상품복사 등록<span class="arrowright"></span></button></span></li>
			<!-- <?php }?> -->
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large black"><button type="button" onclick="goods_save('list')">저장 후 리스트<span class="arrowright"></span></button></span></li>
			<li><span class="btn large black"><button type="button" onclick="goods_save('view')">저장 후 화면유지<span class="arrowright"></span></button></span></li>
		</ul>

		<!-- 상단 단계 링크 : 시작 -->
		<div class="page-goods-helper-btn" >
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td class="ctab"><a href="#01">상품명/검색어</a> &nbsp; <img src="/admin/skin/default/images/common/btn_quick.gif" align="absmiddle" style="padding-right:6px;"><span class="ctabvbar" style="float:right;">&nbsp;</span></td>
					<td class="ctab"><a href="#02">판매정보</a> &nbsp; <img src="/admin/skin/default/images/common/btn_quick.gif" align="absmiddle" style="padding-right:6px;"><span class="ctabvbar" style="float:right;">&nbsp;</span></td>
					<td class="ctab"><a href="#03">배송정책</a> &nbsp; <img src="/admin/skin/default/images/common/btn_quick.gif" align="absmiddle" style="padding-right:6px;"><span class="ctabvbar" style="float:right;">&nbsp;</span></td>
					<td class="ctab"><a href="#04">사진</a> &nbsp; <img src="/admin/skin/default/images/common/btn_quick.gif" align="absmiddle" style="padding-right:6px;"><span class="ctabvbar" style="float:right;">&nbsp;</span></td>
					<td class="ctab"><a href="#05">관리메모</a> &nbsp; <img src="/admin/skin/default/images/common/btn_quick.gif" align="absmiddle"></td>
				</tr>
			</table>
		</div>
		<!-- 상단 단계 링크 : 끝 -->

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->
<!-- 서브메뉴 바디 : 시작-->

<!-- 본사매입 상품 -->
<br style="line-height:18px;"/>

<?php if(serviceLimit('H_AD')){?>

<?php if($TPL_VAR["goods"]["goods_seq"]){?>
	<!-- 입점사 상품 수정 -->
	<div class="providerTitleContainer clearbox" style="text-align:center; background-color:red">
		<div class="ptc-title" style="float:inherit;">
<?php if($TPL_VAR["provider"]["provider_status"]=='Y'){?>[정상 : 판매활동가능]<?php }else{?>[종료 : 판매활동불가]<?php }?>
		<?php echo $TPL_VAR["provider"]["provider_name"]?> 입점사 상품
<?php if($TPL_options_1){foreach($TPL_VAR["options"] as $TPL_V1){?>
<?php if($TPL_V1["default_option"]=='y'){?>
			(<?php if($TPL_VAR["provider_charge"][ 0]["commission_type"]=='SACO'||$TPL_VAR["provider_charge"][ 0]["commission_type"]==''){?>수수료<?php }else{?>공급가<?php }?> 방식 정산)
<?php }?>
<?php }}?>
<?php if($TPL_VAR["goods"]["provider_status_text"]){?>→ <?php echo $TPL_VAR["goods"]["provider_status_text"]?><?php }?></div>
		<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $TPL_VAR["provider_seq"]?>" />
	</div>
<?php }else{?>
	<!-- 입점사 상품 등록 -->
	<div class="providerTitleContainer clearbox" style="text-align:center; background-color:red">
		<div class="ptc-title" style="float:inherit;"><?php if($TPL_VAR["provider"]["provider_status"]=='Y'){?>[정상 : 판매활동가능]<?php }else{?>[종료 : 판매활동불가]<?php }?> <?php echo $TPL_VAR["provider"]["provider_name"]?> 입점사 상품</div>
	</div>
	<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $TPL_VAR["provider"]["provider_seq"]?>" />
<?php }?>

<?php }?>

<a name="01" alt="상품명/검색어"></a>
<div class="clearbox"></div>
<div class="item-title">기본 정보 (상품번호 : <?php if($TPL_VAR["goods"]["goods_seq"]){?><?php echo $TPL_VAR["goods"]["goods_seq"]?><?php }else{?><span style="vertical-align:top;color:#787878">자동생성</span><?php }?>)</div>
<input type="hidden" name="viewLayout" value="basic"/>
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="200" />
		<col width="*" />
	</colgroup>
	<tbody>
		<tr>
			<th class="its-th-align center">상품명 <span class="goods_required"></span></th>
			<td class="its-td">
				<len><input type="text" name="goodsName" class="cal-len line" maxlength="255" size="50" value="<?php echo $TPL_VAR["goods"]["goods_name"]?>" title="HTML 사용가능" onkeyup="calculate_input_len(this);" onblur="calculate_input_len(this);" /> <span class="view-len">0</span></len>
			</td>
		</tr>
	</tbody>
</table>

<a name="02" alt="판매 정보"></a>
<div id="02" class="item-title">판매 정보</div>
<input type="hidden" name="viewLayout" value="basic"/>
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="200" />
		<col width="*" />
		<col />
	</colgroup>

	<tbody>
		<tr>
			<th class="its-th-align center">승인</th>
			<td class="its-td"><?php if($TPL_VAR["goods"]["provider_status"]=='1'){?>승인<?php }else{?>미승인<?php }?></td>
		</tr>
		<tr>
			<th class="its-th-align center">상태</th>
			<td class="its-td">
				<label><input type="radio" name="goodsStatus" value="normal" /> 정상</label>&nbsp;
				<label><input type="radio" name="goodsStatus" value="runout" /> 품절</label>&nbsp;
				<label><input type="radio" name="goodsStatus" value="purchasing" /> 재고확보중</label>&nbsp;
				<label><input type="radio" name="goodsStatus" value="unsold" /> 판매중지</label>
			</td>
		</tr>
		<tr>
			<th class="its-th-align center">
				재고에 따른 판매&nbsp;
<?php if(serviceLimit('H_FR')){?>
				<span class="btn small gray"><button type="button">설정</button></span>
<?php }else{?>
				<span class="btn small cyanblue"><button type="button" class="runout_setting">설정</button></span>
<?php }?>
			</th>
			<td class="its-td" id="runout_policy_msg"></td>
		</tr>
	</tbody>
</table>

<!-- 수출입상품코드 (HS CODE) 시작 -->
<div class="item-title">
	수출입상품코드 (HS CODE)
</div>
<table class="info-table-style" style="width:100%">
<tr>
	<th class="its-th-align left">
		<div class="pdl10">
		<select name="hscode_selector" style="vertical-align:middle;width:141px;" title="선택하세요">
			<option value="0">선택하세요</option>
<?php if($TPL_r_hscode_1){foreach($TPL_VAR["r_hscode"] as $TPL_V1){?><option value="<?php echo $TPL_V1["hscode_common"]?>"><?php echo $TPL_V1["hscode_name"]?>(<?php echo $TPL_V1["hscode_common"]?>)</option><?php }}?>
		</select>
		<span style="margin-left:20px;">&nbsp;</span>
		<input type="hidden" class="hscode" name="hscode"/>
		<input type="text" name="hscode_name" value="<?php echo $_GET["hscode_name"]?>" style="width:150px;" readonly />
		</div>
	</th>
</tr>
</table>
<style>
	#hscodeRegistLayer table.info-table-style {table-layout:fixed;margin:auto;position:relative;width:auto;}
	#hscodeRegistLayer table tr .subj {width:15%;}
	#hscodeRegistLayer table tr .code {width:10%;min-width:100px;}
	#hscodeRegistLayer table tr .nation {min-width:100px;}
	#hscodeRegistLayer table tr .nation_code {min-width:100px;}
	#hscodeRegistLayer table tr .tax {min-width:140px;}
	#hscodeRegistLayer table tr td.subj,#hscodeRegistLayer table tr td.code {vertical-align:top;}
</style>

<div id="hscodeRegistLayer" style="width:100%;">
<table id="hscode_view" class="info-table-style" <?php if(!$TPL_VAR["goods"]["hscode"]){?>class="hide"<?php }?> style="border-top:0px;width:100%">
	<thead>
		<tr>
			<th class="its-th-align center subj" rowspan="2">품명</th>
			<th class="its-th-align center code" rowspan="2">공통코드</th>
			<th class="its-th-align center" colspan="2">수입국가코드</th>
			<th class="its-th-align center rate" colspan="<?php echo count($TPL_VAR["hscode"]["hscode_items"][ 0]["export_nation_key"])?>">수출국가별 수입국가 세율</th>
		</tr>
		<tr>
			<th class="its-th-align center nation">수입국가</th>
			<th class="its-th-align center nation_code">수입국가코드</th>
<?php if($TPL_VAR["hscode"]["hscode_items"][ 0]["export_nation_name"]){?><?php if(is_array($TPL_R1=$TPL_VAR["hscode"]["hscode_items"][ 0]["export_nation_name"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<th class="its-th-align center tax"><?php echo $TPL_V1?></th>
<?php }}?><?php }else{?>
			<th class="its-th-align center tax"></th>
<?php }?>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_VAR["goods"]["hscode"]){?>
		<tr>
			<td class="its-td pd10 center" rowspan="<?php echo count($TPL_VAR["hscode"]["hscode_items"])?>"><?php echo $TPL_VAR["hscode"]["hscode_name"]?></td>
			<td class="its-td pd10 center" rowspan="<?php echo count($TPL_VAR["hscode"]["hscode_items"])?>"><?php echo $TPL_VAR["hscode"]["hscode_common"]?></td>
<?php if(is_array($TPL_R1=$TPL_VAR["hscode"]["hscode_items"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1> 0){?><tr><?php }?>
			<td class="its-td pd10 center"><?php echo $TPL_V1["nation_name"]?></td>
			<td class="its-td pd10 center"><?php echo $TPL_V1["hscode_nation"]?></td>
<?php if(is_array($TPL_R2=$TPL_V1["customs_tax"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<td class="its-td pd10 center"><?php echo $TPL_V2?>%</td>
<?php }}?>
<?php if($TPL_K1> 0){?></tr><?php }?>
<?php }}?>
		</tr>
<?php }?>
	</tbody>
</table>
</div>
<!-- 수출입상품코드 (HS CODE) 끝 -->
<br/>

<!-- 필수옵션 -->
<?php $this->print_("OPTION_HTML",$TPL_SCP,1);?>


<a name="03" alt="배송 정책"></a>
<div class="item-title">배송 정책</div>
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="50%" />
		<col width="50%"/>
	</colgroup>
	<thead>
		<tr>
			<th class="its-th-align center">주문을 하면 → 사은품 지급(배송)</th>
			<th class="its-th-align center">마일리지/포인트를 교환하면 → 사은품 지급(배송)</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="its-td">
				1. <span style="color:#0000ff;">구매조건 사은품 이벤트</span> 진행 시 본 사은품을 지급 사은품으로 설정<br/>
				2. 구매조건을 만족하는 주문은 주문서에 지급해야 하는 정확한 사은품 정보가 보임
			</td>
			<td class="its-td">
				1. <span style="color:#0000ff;">교환조건 사은품 이벤트</span> 진행 시 본 사은품을 지급 사은품으로 설정<br/>
				2. 교환조건을 만족하는 주문은 주문서에 지급해야 하는 정확한 사은품 정보가 보임<br/>
				<span style="color:#676767;">※ 마일리지/포인트 교환 신청은 MY페이지에서 가능합니다.</span>
			</td>
		</tr>
	</tbody>
</table>


<a name="04" alt="사진"></a>
<div class="item-title">상품 사진 <!--span class="btn small orange"><button type="button" id="btnVideoGuide">노출안내</button></span--></div>

<div id="goodsImagePriview"></div>

<input type="hidden" name="largeImageWidth" id="largeImageWidth" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["large"]["width"]?>">
<input type="hidden" name="largeImageHeight"  id="largeImageHeight" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["large"]["height"]?>">
<input type="hidden" name="viewImageWidth"  id="viewImageWidth" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["view"]["width"]?>">
<input type="hidden" name="viewImageHeight"  id="viewImageHeight" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["view"]["height"]?>">
<input type="hidden" name="list1ImageWidth"  id="list1ImageWidth" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["list1"]["width"]?>">
<input type="hidden" name="list1ImageHeight"  id="list1ImageHeight" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["list1"]["height"]?>">
<input type="hidden" name="list2ImageWidth"  id="list2ImageWidth" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["list2"]["width"]?>">
<input type="hidden" name="list2ImageHeight"  id="list2ImageHeight" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["list2"]["height"]?>">
<input type="hidden" name="thumbViewWidth"  id="thumbViewWidth" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbView"]["width"]?>">
<input type="hidden" name="thumbViewHeight"  id="thumbViewHeight" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbView"]["height"]?>">
<input type="hidden" name="thumbCartWidth"  id="thumbCartWidth" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbCart"]["width"]?>">
<input type="hidden" name="thumbCartHeight"  id="thumbCartHeight" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbCart"]["height"]?>">
<input type="hidden" name="thumbScrollWidth"  id="thumbScrollWidth" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbScroll"]["width"]?>">
<input type="hidden" name="thumbScrollHeight"  id="thumbScrollHeight" size="4" class="line" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbScroll"]["height"]?>">

<!-- 상품 이미지 View :: START -->
<table class="info-table-style" style="width:100%" id="goodsImageTable">
	<colgroup>
		<col width="14%" />
		<col width="10%" />
		<col width="11%" />
		<col width="11%" />
		<col width="11%" />
		<col width="11%" />
		<col width="11%" />
		<col width="11%" />
		<col width="11%" />
	</colgroup>
	<thead>
		<tr>
			<th class="its-th-align center" >
<?php if(!$TPL_VAR["images"]){?>
				<div id="multiadd" class="hide">
					<span class="btn large cyanblue"><button type="button" class="batchImageMultiRegist" style="width:120px;">여러 컷 일괄등록</button></span>
					<span class="helpicon" title="<b>여러 컷 일괄등록이란?</b><br>쇼핑몰에서 상품 사진은 여러 페이지에서 보여지게 되며,<br>각각의 페이지에 알맞은 사이즈로 나타나야 합니다.<br>여러 컷 일괄등록이란 입력된 일괄등록 사이즈 설정값을 기준으로 <br>필요한 사이즈의 상품 여러개의 사진을 한꺼번에 등록합니다.<br><br><b>일괄등록이란?</b><br>일괄등록이란 입력된 일괄등록 사이즈 설정값을 기준으로 <br>필요한 사이즈의 상품 사진을 한 번에 등록합니다.<br><br><b>개별등록이란?</b><br>일괄등록으로 등록된 상품사진을 개별적으로 변경하여 등록합니다."></span>
				</div>
				<span class="btn-plus first_plus hide"><button type="button" id="goodsImageAdd"></button></span>
<?php }?>
				<div id="multitxt">멀티등록<br/>순서변경</div>
			</th>
			<th class="its-th-align center">상품사진<br/>일괄등록</th>
			<th class="its-th-align center">상품상세(확대)</th>
			<th class="its-th-align center">상품상세(기본)</th>
			<th class="its-th-align center">리스트(1)</th>
			<th class="its-th-align center">리스트(2)</th>
			<th class="its-th-align center">썸네일(상품상세)</th>
			<th class="its-th-align center">썸네일(장바구니/주문)</th>
			<th class="its-th-align center">썸네일(스크롤)</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_VAR["images"]){?>
<?php if($TPL_images_1){$TPL_I1=-1;foreach($TPL_VAR["images"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
		<tr class="cut-tr cutnum<?php echo $TPL_K1?>">
<?php if($TPL_I1== 0){?>
			<td class="its-td-align left firstCol pdl30" rowspan="<?php echo count($TPL_VAR["images"])?>">
				<span class="btn large cyanblue"><button type="button" class="batchImageMultiRegist" style="width:120px;">여러 컷 일괄등록</button></span>
				<span class="helpicon" title="<b>여러 컷 일괄등록이란?</b><br>쇼핑몰에서 상품 사진은 여러 페이지에서 보여지게 되며,<br>각각의 페이지에 알맞은 사이즈로 나타나야 합니다.<br>여러 컷 일괄등록이란 입력된 일괄등록 사이즈 설정값을 기준으로 <br>필요한 사이즈의 상품 여러개의 사진을 한꺼번에 등록합니다.<br><br><b>일괄등록이란?</b><br>일괄등록이란 입력된 일괄등록 사이즈 설정값을 기준으로 <br>필요한 사이즈의 상품 사진을 한 번에 등록합니다.<br><br><b>개별등록이란?</b><br>일괄등록으로 등록된 상품사진을 개별적으로 변경하여 등록합니다."></span>
				<span class="btn-plus hide"><button type="button" id="goodsImageAdd"></button></span>
				<div class="pdt10"><span class="btn large cyanblue"><button type="button" class="ImageSort" style="width:120px;">순서변경 및 삭제</button></span></div>
			</td>
<?php }?>
			<td class="its-td-align pdl30 left">
				<span class="btn small lightblue"><button type="button" class="batchImageRegist">일괄등록</button></span>
				<input type="hidden" name="all_chg[]" value="N" />
<?php if($TPL_V1["view"]["match_color"]){?>
				<input type="hidden" name="goodsImageColor[]" value="<?php echo $TPL_V1["view"]["match_color"]?>" /> <span class="fileColorTitle" style="color:<?php echo $TPL_V1["view"]["match_color"]?>"><span style='width:30px; height:30px; margin-top:2px; margin-left:2px; border:0px solid #e8e8e8; color:<?php echo $TPL_V1["view"]["match_color"]?>;size:25px;'><font  style='display:inline-block;width:18px; height:18px; border:1px solid #ccc; background-color:<?php echo $TPL_V1["view"]["match_color"]?>; cursor:pointer;' >■</font></span></span>
<?php }else{?>
				<input type="hidden" name="goodsImageColor[]" value="" /> <span class="fileColorTitle"></span>
<?php }?>
			</td>

			<td class="its-td-align center">
				<span class="<?php if($TPL_V1["large"]["image"]){?>blue<?php }else{?>desc<?php }?> hand goodslarge view" imageType="large">보기</span>
				<input type="hidden" name="largeGoodsImage[]" value="<?php echo $TPL_V1["large"]["image"]?>" />
				<input type="hidden" name="largeGoodsLabel[]" value="<?php echo $TPL_V1["large"]["label"]?>" />
				<input type="hidden" name="largeGoodsImageSeq[]" value="<?php echo $TPL_V1["large"]["image_seq"]?>" />
				<input type="hidden" name="large_chg[]" value="N" />
			</td>
			<td class="its-td-align center">
				<span class="<?php if($TPL_V1["view"]["image"]){?>blue hand goodsview view<?php }else{?>desc<?php }?>" imageType="view">보기</span>
				<input type="hidden" name="viewGoodsImage[]" value="<?php echo $TPL_V1["view"]["image"]?>" />
				<input type="hidden" name="viewGoodsLabel[]" value="<?php echo $TPL_V1["view"]["label"]?>" />
				<input type="hidden" name="viewGoodsImageSeq[]" value="<?php echo $TPL_V1["view"]["image_seq"]?>" />
				<input type="hidden" name="view_chg[]" value="N" />
			</td>
			<td class="its-td-align center">
				<span class="<?php if($TPL_V1["list1"]["image"]){?>blue hand goodslist1 view<?php }else{?>desc<?php }?>" imageType="list1">보기</span>
				<input type="hidden" name="list1GoodsImage[]" value="<?php echo $TPL_V1["list1"]["image"]?>" />
				<input type="hidden" name="list1GoodsLabel[]" value="<?php echo $TPL_V1["list1"]["label"]?>" />
				<input type="hidden" name="list1GoodsImageSeq[]" value="<?php echo $TPL_V1["list1"]["image_seq"]?>" />
				<input type="hidden" name="list1_chg[]" value="N" />
			</td>
			<td class="its-td-align center">
				<span class="<?php if($TPL_V1["list2"]["image"]){?>blue hand goodslist2 view<?php }else{?>desc<?php }?>" imageType="list2">보기</span>
				<input type="hidden" name="list2GoodsImage[]" value="<?php echo $TPL_V1["list2"]["image"]?>" />
				<input type="hidden" name="list2GoodsLabel[]" value="<?php echo $TPL_V1["list2"]["label"]?>" />
				<input type="hidden" name="list2GoodsImageSeq[]" value="<?php echo $TPL_V1["list2"]["image_seq"]?>" />
				<input type="hidden" name="list2_chg[]" value="N" />
			</td>
			<td class="its-td-align center">
				<span class="<?php if($TPL_V1["thumbView"]["image"]){?>blue hand goodsthumbView view<?php }else{?>desc<?php }?>" imageType="thumbView">보기</span>
				<input type="hidden" name="thumbViewGoodsImage[]" value="<?php echo $TPL_V1["thumbView"]["image"]?>" />
				<input type="hidden" name="thumbViewGoodsLabel[]" value="<?php echo $TPL_V1["thumbView"]["label"]?>" />
				<input type="hidden" name="thumbViewGoodsImageSeq[]" value="<?php echo $TPL_V1["thumbView"]["image_seq"]?>" />
				<input type="hidden" name="thumbView_chg[]" value="N" />
			</td>
			<td class="its-td-align center">
				<span class="<?php if($TPL_V1["thumbCart"]["image"]){?>blue hand goodsthumbCart view<?php }else{?>desc<?php }?>" imageType="thumbCart">보기</span>
				<input type="hidden" name="thumbCartGoodsImage[]" value="<?php echo $TPL_V1["thumbCart"]["image"]?>" />
				<input type="hidden" name="thumbCartGoodsLabel[]" value="<?php echo $TPL_V1["thumbCart"]["label"]?>" />
				<input type="hidden" name="thumbCartGoodsImageSeq[]" value="<?php echo $TPL_V1["thumbCart"]["image_seq"]?>" />
				<input type="hidden" name="thumbCart_chg[]" value="N" />
			</td>
			<td class="its-td-align center">
				<span class="<?php if($TPL_V1["thumbScroll"]["image"]){?>blue hand goodsthumbScroll view<?php }else{?>desc<?php }?>" imageType="thumbScroll">보기</span>
				<input type="hidden" name="thumbScrollGoodsImage[]" value="<?php echo $TPL_V1["thumbScroll"]["image"]?>" />
				<input type="hidden" name="thumbScrollGoodsLabel[]" value="<?php echo $TPL_V1["thumbScroll"]["label"]?>" />
				<input type="hidden" name="thumbScrollGoodsImageSeq[]" value="<?php echo $TPL_V1["thumbScroll"]["image_seq"]?>" />
				<input type="hidden" name="thumbScroll_chg[]" value="N" />
			</td>
		</tr>
<?php }}?>
<?php }?>
	</tbody>
</table>

<?php if(!$TPL_VAR["images"]){?><script>$("#multiadd").show();$("#multitxt").hide();</script><?php }?>
<!-- 상품 이미지 View :: END -->


<?php if($TPL_VAR["goods"]["goods_seq"]){?>
<!-- 워터마크 :: START -->
<table class="info-table-style" id="watermark_tb" style="width:100%;">
	<colgroup>
		<col width="14%" />
		<col width="25%" />
		<col width="" />
	</colgroup>
	<tr>
		<td class="its-td-align center">
			<div>워터마크 <span class="helpicon" title="워터마크란? 사용자가 이미지를 보는데 지장을 주지 않으면서 로고와 같은 마크가 이미지 원본에 삽입되는 기능으로<br/>이미지 도용을 방지할 수 있게 됩니다.<br/><br/>워터마크를 적용할 원본이미지 크기는 680*3000 이하로 등록해 주세요.<br/>워터마크는 상품정보 수정 시 등록된 상품 사진에 적용이 가능합니다."></span></div>
		</td>
		<td class="its-td-align center">
			<span class="btn large cyanblue"><button type="button" class="waterMarkImageApply">워터마크 적용하기</button></span>
			<span class="btn large gray"><button type="button" class="waterMarkImageCancel">워터마크 제거하기</button></span>
		</td>
		<td class="its-td-align center"></td>
	</tr>
</table>
<!-- 워터마크 :: END -->
<?php }?>


<br class="table-gap" />


<a name="05" alt="관리 메모"></a>
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="50%" />
		<col width="50%" />
	</colgroup>
	<thead>
		<tr>
			<th class="its-th-align center"><a name="tb_goods_log">상품 관리 메모</a></th>
			<th class="its-th-align center">처리 내역</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="its-td-align center">
				<textarea name="adminMemo"  style="width:98%" rows="5"><?php echo $TPL_VAR["goods"]["admin_memo"]?></textarea>
			</td>
			<td class="its-td-align center">
				<div style="overflow:auto;height:60px;width:98%;border:1px solid #cccccc;padding: 10px 5px;background:#f7f7f7;text-align:left;"><?php echo $TPL_VAR["goods"]["admin_log"]?></div>
				<textarea name="admin_log" style="display:none;"><?php echo $TPL_VAR["goods"]["admin_log"]?></textarea>
			</td>
		</tr>
	</tbody>
</table>
</form>

<!-- 이미지 업로드 다이얼로그 -->
<div id="imageUploadDialog" class="hide">
	<table width="100%" class="info-table-style">
	<col width="100" />
	<tr>
		<th class="its-th">업로드경로</th>
		<td class="its-td">/<span class="uploadPath"></span></td>
	</tr>
	<tr>
		<th class="its-th">파일찾기</th>
		<td class="its-td">
			<div class="pdr10">
				<img class="imageUploadBtnImage hide" src="/admin/skin/default/images/common/btn_filesearch.gif">
				<input id="imageUploadButton" type="file" name="file" value="" class="uploadify" />
			</div>
		</td>
	</tr>
	</table>
	<div class="center pdt20 pdb20"><span class="btn medium"><input type="button" value="업로드" onclick="$('#imageUploadButton').uploadifyUpload();" /></span></div>
</div>
<!-- 이미지 수정 상세보기 -->
<div class="hide">
	<input type="hidden" name="idx" id="idx" value="" />
	<input type="hidden" name="imgKind" id="imgKind" value="" />
	<table width="100%" class="info-table-style" id="goodsImageMake">
	<tr>
		<th class="its-th-align center" width="<?php echo $TPL_VAR["goodsImageSize"]["large"]["width"]?>" style="padding:10px; max-width:700px;"><img id="viewImg" style="max-width:700px;"></th>
		<td class="its-td" style="min-width: 470px;">
			<div style="font-weight:bold;float:left;padding-right:5px">대표컷 - 상품상세(기본)</div>
			<div>
				<span class="btn small gray"><button type="button" id="eachImageRegist">개별등록</button></span>
				<span class="btn small gray"><button type="button" id="imgDownload">PC저장</button></span>
			</div>
			<table class="img-info-tb" border="0">
			<tr>
				<td width="60px">&bull; 레이블</td>
				<td width="10px"> : </td>
				<td>
					<span id="goodsImgLabel_view"></span>
				</td>
			</tr>
			<tr>
				<td>&bull; 주소</td>
				<td> : </td>
				<td>
					<span id="fileurl"></span>
				</td>
			</tr>
			<tr>
				<td>&bull; 사이즈</td>
				<td> : </td>
				<td>
					<span id="filesize"></span>
				</td>
			</tr>
			<tr id="FileColorView">
				<td>&bull; 색상</td>
				<td> : </td>
				<td>
					<span id="filecolor"></span>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>
<!-- 옵션만들기 다이얼로그 -->
<div id="optionMakePopup" class="hide">
	<table  class="simplelist-table-style" style="width:100%">
		<colgroup>
			<col />
			<col />
			<col />
			<col width="5%" />
		</colgroup>
		<thead>
			<tr>
				<th class="its-th-align center">필수 옵션명</th>
				<th class="its-th-align center">필수 옵션값 : ','(콤마)로 구분</th>
				<th class="its-th-align center">필수 가격 : ','(콤마)로 구분</th>
				<th class="its-th-align center"></th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["opts_loop"]){?>
<?php if($TPL_opts_loop_1){$TPL_I1=-1;foreach($TPL_VAR["opts_loop"] as $TPL_V1){$TPL_I1++;?>
			<tr>
				<td class="its-td-align center">
<?php if($TPL_I1== 0&&$TPL_V1["title"]=='컬러'){?>
					<!-- /* 원더플레이스 */ -->
					<input type="text" name="optionMakeName[]" class="line" size="10" value="<?php echo $TPL_V1["title"]?>" readonly />
<?php }else{?>
					<input type="text" name="optionMakeName[]" class="line" size="10" value="<?php echo $TPL_V1["title"]?>" />
<?php }?>
				</td>
				<td class="its-td-align center">
					<input type="text" name="optionMakeValue[]" class="line" size="45" value="<?php echo $TPL_V1["opt"]?>" />
				</td>
				<td class="its-td-align center">
					<input type="text" name="optionMakePrice[]" class="line" size="25" value="<?php echo $TPL_V1["price"]?>" />
				</td>
				<td class="its-td-align center">
<?php if($TPL_I1== 0){?>
					<span class="btn-plus"><button type="button" id="addOptionMake"></button></span>
<?php }else{?>
					<span class="btn-minus"><button type="button" class="delOptionMake"></button></span>
<?php }?>
				</td>
			</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td class="its-td-align center">
					<!--<input type="text" name="optionMakeName[]" class="line" size="10" value="" />-->
					<!-- /* 원더플레이스 */ -->
					<input type="text" name="optionMakeName[]" class="line" size="10" value="컬러" readonly />
				</td>
				<td class="its-td-align center">
					<input type="text" name="optionMakeValue[]" class="line" size="45" value="" />
				</td>
				<td class="its-td-align center">
					<input type="text" name="optionMakePrice[]" class="line" size="25" value="" />
				</td>
				<td class="its-td-align center">
					<!--<span class="btn-plus"><button type="button" id="addOptionMake"></button></span>-->
				</td>
			</tr>
			<tr>
				<td class="its-td-align center">
					<input type="text" name="optionMakeName[]" class="line" size="10" value="SIZE" readonly />
				</td>
				<td class="its-td-align center">
					<input type="text" name="optionMakeValue[]" class="line" size="45" value="" />
				</td>
				<td class="its-td-align center">
					<input type="text" name="optionMakePrice[]" class="line" size="25" value="" />
				</td>
				<td class="its-td-align center">

				</td>
			</tr>
<?php }?>
		</tbody>
	</table>
	<div class="center" style="padding:10px;"><span class="btn large black"><button type="button" id="OptionMakeApply">적용하기</button></span>	</div>
</div>

<div id="makeGoodsCodLay" class="hide">
	<div class="center" style="padding-top:10px;color:blue">현재 상품 기본코드 자동생성규칙</div>
	<div class="center" style="padding-top:10px;">
<?php if($TPL_VAR["goodscodesettingview"]){?><?php echo substr($TPL_VAR["goodscodesettingview"], 0,strlen($TPL_VAR["goodscodesettingview"])- 3)?><?php }else{?>규칙없음<?php }?>
	</div>
	<div class="center" style="padding:20px;">
<?php if($TPL_VAR["goodscodesettingview"]&&$_GET["no"]){?>
		<span class="btn large gray"><button type="button" onClick="makeGoodsCode();">자동생성</button></span>
<?php }else{?>
		<span class="btn large gray"><button type="button" disabled>자동생성</button></span>
<?php }?>
	</div>

</div>

<!-- 추가옵션만들기 다이얼로그 -->
<div id="subOptionMakeDialog" class="hide">
	<table  class="simplelist-table-style" style="width:100%">
		<colgroup>
			<col width="25%" />
			<col />
			<col />
			<col width="5%" />
		</colgroup>
		<thead>
			<tr>
				<th class="its-th-align center">추가 옵션명</th>
				<th class="its-th-align center">추가 옵션값은 ','(콤마)로 구분</th>
				<th class="its-th-align center">추가 옵션가격은  ','(콤마)로 구분</th>
				<th class="its-th-align center"></th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["sopts_loop"]){?>
<?php if($TPL_sopts_loop_1){$TPL_I1=-1;foreach($TPL_VAR["sopts_loop"] as $TPL_V1){$TPL_I1++;?>
			<tr>
				<td class="its-td-align center">
					<input type="text" name="suboptionMakeName[]" size="10" class="line" value="<?php echo $TPL_V1["title"]?>" />
				</td>
				<td class="its-td-align center">
					<input type="text" name="suboptionMakeValue[]" class="line" size="55" value="<?php echo $TPL_V1["opt"]?>" />
				</td>
				<td class="its-td-align center">
					<input type="text" name="suboptionMakePrice[]" class="line" size="25" value="<?php echo $TPL_V1["price"]?>" />
				</td>
				<td class="its-td-align center">
<?php if($TPL_I1== 0){?>
					<span class="btn-plus"><button type="button" id="addSuboptionMake"></button></span>
<?php }else{?>
					<span class="btn-minus"><button type="button" class="delSuboptionMake"></button></span>
<?php }?>
				</td>
			</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td class="its-td-align center">
					<input type="text" name="suboptionMakeName[]" size="10" class="line" value="" />
				</td>
				<td class="its-td-align center">
					<input type="text" name="suboptionMakeValue[]" class="line" size="55" value="" />
				</td>
				<td class="its-td-align center">
					<input type="text" name="suboptionMakePrice[]" class="line" size="25" value="" />
				</td>
				<td class="its-td-align center">
					<span class="btn-plus"><button type="button" id="addSuboptionMake"></button></span>
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>
	<div class="center" style="padding:10px;"><span class="btn large black"><button type="button" id="suboptionMakeApply">적용하기</button></span></div>
</div>

<!-- 구매자 추가입력만들기 다이얼로그 -->
<div id="memberInputDialog" class="hide">
	<table  class="simplelist-table-style" style="width:100%">
		<colgroup>
			<col />
			<col />
			<col />
			<col />
			<col width="5%" />
		</colgroup>
		<thead>
			<tr>
				<th class="its-th-align center">추가 입력명</th>
				<th class="its-th-align center">추가입력 형식</th>
				<th class="its-th-align center">추가입력 제한</th>
				<th class="its-th-align center"></th>
			</tr>
		</thead>
		<tbody>
		<!-- <?php if($TPL_VAR["inputs"]){?> -->
			<!-- <?php if($TPL_inputs_1){$TPL_I1=-1;foreach($TPL_VAR["inputs"] as $TPL_V1){$TPL_I1++;?> -->
			<tr>
				<td class="its-td-align center">
					<input type="text" name="memberInputMakeName[]" class="line" size="10" value="<?php echo $TPL_V1["input_name"]?>" />
				</td>
				<td class="its-td-align center">
					<select name="memberInputMakeForm[]">
						<option value="text" <?php if($TPL_V1["input_form"]=='text'){?>selected<?php }?>>텍스트박스</option>
						<option value="edit" <?php if($TPL_V1["input_form"]=='edit'){?>selected<?php }?>>에디트박스</option>
						<option value="file" <?php if($TPL_V1["input_form"]=='file'){?>selected<?php }?>>이미지 업로드</option>
					</select>
				</td>
				<td class="its-td">
					<!-- <?php if($TPL_V1["input_form"]=='text'||$TPL_V1["input_form"]=='edit'){?> -->
						<div class="textLimit">
						<input type="text" name="memberInputMakeLimit[]" class="line" size="2" value="<?php echo $TPL_V1["input_limit"]?>" />자 이내
						</div>
						<div class="uploadLimit"></div>
					<!-- <?php }else{?> -->
						<div class="uploadLimit"><input type="hidden" name="memberInputMakeLimit[]" value="imageUpload" />2M이하</div>
						<div class="textLimit" class="hide">
						<input type="text" name="memberInputMakeLimit[]" class="line" size="2" value="<?php echo $TPL_V1["input_limit"]?>" />자 이내
						</div>
					<!-- <?php }?> -->
				</td>
				<td class="its-td-align center">
<?php if($TPL_I1== 0){?>
					<span class="btn-plus"><button type="button" id="addMemberInputMake"></button></span>
<?php }else{?>
					<span class="btn-minus"><button type="button" class="delMemberInputMake"></button></span>
<?php }?>
				</td>
			</tr>
			<!-- <?php }}?> -->
		<!-- <?php }else{?> -->
			<tr>
				<td class="its-td-align center">
					<input type="text" name="memberInputMakeName[]" class="line" size="10" value="" />
				</td>
				<td class="its-td-align center">
					<select name="memberInputMakeForm[]">
						<option value="text">텍스트박스</option>
						<option value="edit">에디트박스</option>
						<option value="file">이미지 업로드</option>
					</select>
				</td>
				<td class="its-td">
					<div class="textLimit">
					<input type="text" name="memberInputMakeLimit[]" class="line" size="2" value="" />자 이내
					</div>
					<div class="uploadLimit"></div>
				</td>
				<td class="its-td-align center">
					<span class="btn-plus"><button type="button" id="addMemberInputMake"></button></span>
				</td>
			</tr>
		<!-- <?php }?> -->
		</tbody>
	</table>
	<div class="center" style="padding:10px;"><span class="btn large black"><button type="button" id="memberInputMakeApply">적용하기</button></span></div>
</div>


<!-- 아이콘 선택 -->
<div id="goodsIconPopup" class="hide">
	<form enctype="multipart/form-data" method="post" action="../goods_process/icon" target="actionFrame">
	<input type="hidden" name="iconIndex" value="0" />
	<ul>
<?php if(is_array($TPL_R1=code_load('goodsIcon'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	<li style="float:left;width:100px;height:30px;text-align:center">
		<input type="hidden" name="goodsIconCode[]" value="<?php echo $TPL_V1["codecd"]?>">
		<img src="/data/icon/goods/<?php echo $TPL_V1["codecd"]?>.gif" border="0" class="hand hover-select">
	</li>
<?php }}?>
	</ul>
	<div class="clearbox"></div>
	<div>
	<input type="file" name="goodsIconImg" /> <span class="btn small black"><button type="submit">추가</button></span>
	</div>
	</form>
</div>

<!-- 상품상태별 이미지 선택 -->
<div id="popGoodsStatusImageChoice" class="hide">
	<form enctype="multipart/form-data" method="post" action="../goods_process/goods_status_image_upload" target="actionFrame">
	<input type="hidden" name="goodsStatusImageCode" value="" />
	<table align="center" height="160">
	<tr>
		<td><div class="nowGoodsStatusImage pd10"></div></td>
		<td><input type="file" name="goodsStatusImage" /> <span class="btn small black"><button type="submit">확인</button></span></td>
	</tr>
	</table>
	</form>
</div>


<!--### 필수옵션 미리보기 -->
<div id="popPreviewOpt" class="hide"></div>
<!--### 추가혜택 -->
<div id="popup_benefits" class="hide"></div>
<!--### 상품상태별 이미지세팅 -->
<div id="popGoodsStatusImage" class="hide"></div>

<div id="popup_runout_setting" class="hide">
	<div style="padding-bottom:5px;">
	<label style="width:80px;display:inline-block;"><input type="radio" name="runout_type" value="shop" <?php if(!$TPL_VAR["goods"]["runout_policy"]){?>checked<?php }?> /> 통합세팅</label>
	(설정><a href="../setting/order" target="_blank"><span class=" highlight-link hand">주문</span></a>)
	</div>
	<table width="100%" class="info-table-style stock-qa-table" id="shop_runout">
	<col width="180" /><col width="300" /><col width="230" /><col width="280" /><col />
	<tr>
		<td class="its-td center">판매 방식</td>
		<td class="its-td center">상황의 발생</td>
		<td class="its-td center">재고(가용재고)의 변화</td>
		<td class="its-td center">상품의 상태 처리	</td>
		<td class="its-td center">결과</td>
	</tr>
<?php if($TPL_VAR["cfg_order"]["runout"]=='stock'){?>
	<tr>
		<td class="its-td" rowspan="2">재고가 있으면 판매</td>
		<td class="its-td">[좋은일] 상품을 발송(출고완료)하여</td>
		<td class="its-td">재고가 0 이 될 때</td>
		<td class="its-td">품절(또는 재고확보중)로 자동 업데이트되어</td>
		<td class="its-td">판매 중지</td>
	</tr>
	<tr>
		<td class="its-td">[나쁜일] 결제취소/반품/주문처리되돌리기로</td>
		<td class="its-td">재고가 1 이상이 될 때</td>
		<td class="its-td">정상으로 자동 업데이트되어</td>
		<td class="its-td">판매 가능</td>
	</tr>
<?php }?>
<?php if($TPL_VAR["cfg_order"]["runout"]=='ableStock'){?>
	<tr>
		<td class="its-td" rowspan="2">가용재고가 있으면 판매</td>
		<td class="its-td">[좋은일] 상품의 주문으로</td>
		<td class="its-td">가용재고가 <?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]?> 이하로 될 때</td>
		<td class="its-td">품절(또는 재고확보중)로 자동 업데이트되어</td>
		<td class="its-td">판매 중지</td>
	</tr>
	<tr>
		<td class="its-td">[나쁜일] 결제취소/반품/주문처리되돌리기로</td>
		<td class="its-td">가용재고가 <?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]+ 1?> 이상이 될 </td>
		<td class="its-td">정상으로 자동 업데이트되어</td>
		<td class="its-td">판매 가능</td>
	</tr>
<?php }?>
<?php if($TPL_VAR["cfg_order"]["runout"]=='unlimited'){?>
	<tr>
		<td class="its-td" rowspan="2">재고와 상관없이 판매</td>
		<td class="its-td">[좋은일] 상품을 발송(출고완료)하여</td>
		<td class="its-td">재고가 차감되어도</td>
		<td class="its-td">정상으로 유지되어</td>
		<td class="its-td">판매 중지되지 않고 판매 가능</td>
	</tr>
	<tr>
		<td class="its-td">[나쁜일] 결제취소/반품/주문처리되돌리기로</td>
		<td class="its-td">재고와 가용재고가 증가되면 </td>
		<td class="its-td">당연히 정상으로 유지되어</td>
		<td class="its-td">판매 가능</td>
	</tr>
<?php }?>
	</table>
	<br/><br/>
	<div style="padding-bottom:5px;">
		<label><input type="radio" name="runout_type" value="goods" <?php if($TPL_VAR["goods"]["runout_policy"]){?>checked<?php }?> /> 개별세팅</label>
	</div>
	<table width="100%" class="info-table-style stock-qa-table" id="goods_runout">
	<col width="180" /><col width="300" /><col width="230" /><col width="280" /><col />
	<tr>
		<td class="its-td center">판매 방식</td>
		<td class="its-td center">상황의 발생</td>
		<td class="its-td center">재고(가용재고)의 변화</td>
		<td class="its-td center">상품의 상태 처리	</td>
		<td class="its-td center">결과</td>
	</tr>
	<tr>
		<td class="its-td" rowspan="2"><label><input type="radio" name="runout" value="stock" /> 재고가 있으면 판매</label></td>
		<td class="its-td">[좋은일] 상품을 발송(출고완료)하여</td>
		<td class="its-td">재고가  <strong>0</strong> 이 될 때</td>
		<td class="its-td">품절(또는 재고확보중)로 자동 업데이트되어</td>
		<td class="its-td">판매 중지</td>
	</tr>
	<tr>
		<td class="its-td">[나쁜일] 결제취소/반품/주문처리되돌리기로</td>
		<td class="its-td">재고가 <strong>1</strong> 이상이 될 때</td>
		<td class="its-td">정상으로 자동 업데이트되어</td>
		<td class="its-td">판매 가능</td>
	</tr>
	<tr>
		<td class="its-td" rowspan="2"><label><input type="radio" name="runout" value="ableStock" checked /> 가용재고가 있으면 판매</label></td>
		<td class="its-td">[좋은일] 상품의 주문으로</td>
		<td class="its-td">가용재고가  <input type="text" name="ableStockLimit" size="5" value="<?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]?>" class="right line onlynumber_signed"> 이하로 될 때</td>
		<td class="its-td">품절(또는 재고확보중)로 자동 업데이트되어</td>
		<td class="its-td">판매 중지</td>
	</tr>
	<tr>
		<td class="its-td">[나쁜일] 결제취소/반품/주문처리되돌리기로</td>
		<td class="its-td">가용재고가     <span id="ableStockLimitMsg" style="font-weight:bold"><?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]+ 1?></span> 이상이 될 때</td>
		<td class="its-td">정상으로 자동 업데이트되어</td>
		<td class="its-td">판매 가능</td>
	</tr>
	<tr>
		<td class="its-td" rowspan="2"><label><input type="radio" name="runout" value="unlimited" /> 재고와 상관없이 판매</label></td>
		<td class="its-td">[좋은일] 상품을 발송(출고완료)하여</td>
		<td class="its-td">재고가 차감되어도</td>
		<td class="its-td">정상으로 유지되어</td>
		<td class="its-td">판매 중지되지 않고 판매 가능</td>
	</tr>
	<tr>
		<td class="its-td">[나쁜일] 결제취소/반품/주문처리되돌리기로</td>
		<td class="its-td">재고와 가용재고가 증가되면</td>
		<td class="its-td">당연히 정상으로 유지되어</td>
		<td class="its-td">판매 가능</td>
	</tr>
	</table>
</div>

<!-- 이미지 업로드 다이얼로그 -->
<div id="imageUploadDialog" class="hide">
	<table width="100%" class="info-table-style">
	<col width="100" />
	<tr>
		<th class="its-th">업로드경로</th>
		<td class="its-td">/<span class="uploadPath"></span></td>
	</tr>
	<tr>
		<th class="its-th">파일찾기</th>
		<td class="its-td">
			<div class="pdr10">
				<img class="imageUploadBtnImage hide" src="/admin/skin/default/images/common/btn_filesearch.gif">
				<input id="imageUploadButton" type="file" name="file" value="" class="uploadify" />
			</div>
		</td>
	</tr>
	</table>
	<div class="center pdt20 pdb20"><span class="btn medium"><input type="button" value="업로드" onclick="$('#imageUploadButton').uploadifyUpload();" /></span></div>
</div>


<!-- 이미지 수정 상세보기 -->
<div class="hide">
	<input type="hidden" name="idx" id="idx" value="" />
	<input type="hidden" name="imgKind" id="imgKind" value="" />
	<table width="100%" class="info-table-style" id="goodsImageMake">
	<tr>
		<th class="its-th-align center" width="<?php echo $TPL_VAR["goodsImageSize"]["large"]["width"]?>" style="padding:10px; max-width:700px;"><img id="viewImg" style="max-width:700px;"></th>
		<td class="its-td" style="min-width: 470px;">
			<div style="font-weight:bold;float:left;padding-right:5px">대표컷 - 상품상세(기본)</div>
			<div>
				<span class="btn small gray"><button type="button" id="eachImageRegist">개별등록</button></span>
				<span class="btn small gray"><button type="button" id="imgDownload">PC저장</button></span>
			</div>
			<table class="img-info-tb" border="0">
			<tr>
				<td width="60px">&bull; 레이블</td>
				<td width="10px"> : </td>
				<td>
					<span id="goodsImgLabel_view"></span>
				</td>
			</tr>
			<tr>
				<td>&bull; 주소</td>
				<td> : </td>
				<td>
					<span id="fileurl"></span>
				</td>
			</tr>
			<tr>
				<td>&bull; 사이즈</td>
				<td> : </td>
				<td>
					<span id="filesize"></span>
				</td>
			</tr>
			<tr id="FileColorView">
				<td>&bull; 색상</td>
				<td> : </td>
				<td>
					<span id="filecolor"></span>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>

<!-- 상품상태별 이미지 선택 -->
<div id="popGoodsStatusImageChoice" class="hide">
	<form enctype="multipart/form-data" method="post" action="../goods_process/goods_status_image_upload" target="actionFrame">
		<input type="hidden" name="goodsStatusImageCode" value="" />
		<table align="center" height="160">
		<tr>
			<td><div class="nowGoodsStatusImage pd10"></div></td>
			<td><input type="file" name="goodsStatusImage" /> <span class="btn small black"><button type="submit">확인</button></span></td>
		</tr>
		</table>
	</form>
</div>


<!--### 상품상태별 이미지세팅 -->
<div id="popGoodsStatusImage" class="hide"></div>

<!-- 메시지 출력용 -->
<div id="helperMessageShow" class="hide"><span id="helperMessage"></div></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>