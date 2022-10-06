<?php /* Template_ 2.2.6 2022/05/17 12:29:12 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/select_auto_condition.html 000027456 */ 
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);?>
<style type="text/css">
.ui-combobox {position: relative;display: inline-block}
.ui-combobox-toggle {position: absolute;top: 0;bottom: 0;margin-left: -1px;padding: 0;*height: 1.7em;*top: 0.1em}
.ui-combobox-input {margin: 0;padding: 0.3em}
.ui-autocomplete {max-height: 200px;overflow-y: auto;overflow-x: hidden}
#select_auto_condition .admin_select li{margin-top:5px}
#select_auto_condition .date_month{width:60px;border:1px solid #e1e1e1;padding:3px 8px 0px 8px;cursor:pointer;display:inline-block}
#select_auto_condition .date_active{border:1px solid #ff3366 !important}
#select_auto_condition .mg-right{margin-right:20px}

/* 통계대상 행동 */
div.stat_act_div			{width:130px;line-height:80px;border:1px solid #e1e1e1;text-align:center;vertical-align:middle;padding:5px;margin-right:10px;}
div.stat_act_div > input	{display:none;}
div.stat_act_div.current	{border:1px solid #ff0000;}
div.stat_act_div.select		{border:1px solid #0000ff;}
</style>
<script type="text/javascript">
var displayKind = '<?php echo $TPL_VAR["displayKind"]?>';
$(document).ready(function(){
	DaumEditorLoader.init(".daumeditor");

	/* 카테고리 불러오기 */
	category_admin_select_load('','selectCategory1','');
	$("div#select_auto_condition select[name='selectCategory1']").bind("change",function(){
		category_admin_select_load('selectCategory1','selectCategory2',$(this).val());
		category_admin_select_load('selectCategory2','selectCategory3',"");
		category_admin_select_load('selectCategory3','selectCategory4',"");
	});
	$("div#select_auto_condition select[name='selectCategory2']").bind("change",function(){
		category_admin_select_load('selectCategory2','selectCategory3',$(this).val());
		category_admin_select_load('selectCategory3','selectCategory4',"");
	});
	$("div#select_auto_condition select[name='selectCategory3']").bind("change",function(){
		category_admin_select_load('selectCategory3','selectCategory4',$(this).val());
	});

	/* 브랜드 불러오기 */
	brand_admin_select_load('','selectBrand1','');
	$("div#select_auto_condition select[name='selectBrand1']").bind("change",function(){
		brand_admin_select_load('selectBrand1','selectBrand2',$(this).val());
		brand_admin_select_load('selectBrand2','selectBrand3',"");
		brand_admin_select_load('selectBrand3','selectBrand4',"");
	});
	$("div#select_auto_condition select[name='selectBrand2']").bind("change",function(){
		brand_admin_select_load('selectBrand2','selectBrand3',$(this).val());
		brand_admin_select_load('selectBrand3','selectBrand4',"");
	});
	$("div#select_auto_condition select[name='selectBrand3']").bind("change",function(){
		brand_admin_select_load('selectBrand3','selectBrand4',$(this).val());
	});

	/* 지역 불러오기 */
	location_admin_select_load('','selectLocation1','');
	$("div#select_auto_condition select[name='selectLocation1']").bind("change",function(){
		location_admin_select_load('selectLocation1','selectLocation2',$(this).val());
		location_admin_select_load('selectLocation2','selectLocation3',"");
		location_admin_select_load('selectLocation3','selectLocation4',"");
	});
	$("div#select_auto_condition select[name='selectLocation2']").bind("change",function(){
		location_admin_select_load('selectLocation2','selectLocation3',$(this).val());
		location_admin_select_load('selectLocation3','selectLocation4',"");
	});
	$("div#select_auto_condition select[name='selectLocation3']").bind("change",function(){
		location_admin_select_load('selectLocation3','selectLocation4',$(this).val());
	});

	$('div#select_auto_condition .date_month').click(function(){
		click_d = 1;
		click_date = $(this).index();
		if(click_date > -1) click_d += click_date;
		$("input[name='month']").val(click_d);
		$('.date_month').removeClass('date_active');
		$(this).addClass('date_active');
	}).eq(0).click();

	$('div#select_auto_condition .auto_check').click(function(){
		$(this).closest('label').parent().find('input:radio').prop('checked',true);
	});

	// 통계대상 행동 선택 :: 2018-11-26 lwh
	$("input[name='act']").bind('click',function(){
		$('.stat_act_div').removeClass('select');
		$(this).closest('.stat_act_div').addClass('select');

		if($(this).val() == 'review_sum'){
			$('.date_month').hide();
			$('.date_desc').text('누적 기간동안');
		}else{
			$('.date_month').show();
			$('.date_desc').text('동안');
		}

<?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>
			if ($(this).val() == 'recently'){
				$('.detail_act').hide();
			}else{
				$('.detail_act').show();
			}
<?php }else{?>
			$('.detail_act').hide();
<?php }?>
	}).eq(0).click();

<?php if($_GET["condition"]){?>
	var condition = "<?php echo $_GET["condition"]?>".split(",");
	if (condition=="") return;
	for(var i=0;i<condition.length;i++){
		var div = condition[i].split("=");
		var name = div[0];
		var value = decodeURIComponent(div[1]);
		//bigdata일 경우엔 최근등록순이 없다.
		if ((displayKind == 'bigdata' || displayKind == 'bigdata_catalog') && name == 'act' && value == 'recently') value = 'order_cnt';

		var obj = $("#select_auto_condition>form *[name='"+name+"']");
		if (name == 'month') $('.date_month').eq(value-1).click();
		if (obj.length){
			if(obj[0].tagName.toUpperCase()=='INPUT' && (obj.attr('type')=='checkbox' || obj.attr('type')=='radio')){
				$("#select_auto_condition>form input[name='"+name+"'][value='"+value+"']").eq(0).click();
			}else if(obj[0].tagName=='SELECT'){
				obj.val(value).attr("defaultValue",value);
			}else{
				obj.val(value);
			}
		}
	}
<?php }?>

	$('.same_admin').click(check_same).each(check_same);

	$('.close_condition').click(function(){
		$(this).closest('.ui-dialog').remove();
		closeDialog("condition_change_option");
	});

});

function check_same(){
	flag = false;
	if	($(this).is(':checked')) flag = true;
	switch($(this).attr('name')){
		case 'same_category'	: $('.select_category').prop('disabled',flag);	break;
		case 'same_brand'		: $('.select_brand').prop('disabled',flag);		break;
		case 'same_location'	: $('.select_location').prop('disabled',flag);	break;
		case 'same_seller'		: $('.select_seller').prop('disabled',flag);	break;
	}
};

var set_auto_condition = function(that){
	that = $(that).closest('#select_auto_condition');
	if	(readyEditorForm(document.select_auto_condition_form)){

<?php if($TPL_VAR["kind"]!='admin'&&$TPL_VAR["displayKind"]!='mshop'){?>
		if	($("input[name='same_category']",that).is(':checked') == false && $("input[name='same_brand']",that).is(':checked') == false && $("input[name='same_location']",that).is(':checked') == false && $("input[name='same_seller']",that).is(':checked') == false){
			openDialogAlert('고객(소비자) 기준을 선택해주세요.','400','160',function(){$("input[name='same_category']",that).focus();});
			return;
		}
<?php }?>

		if	($("input[name='age']:checked",that).val() == 'each' && $(".each_age:checkbox:checked",that).length < 1){
			openDialogAlert('나이를 선택해주세요.','400','160',function(){$("input[name='each_age_10']",that).focus();});
			return;
		}

		if	($("input[name='sex']:checked",that).val() == 'each' && $(".each_sex:checkbox:checked",that).length < 1){
			openDialogAlert('성별을 선택해주세요.','400','160',function(){$("input[name='sex_male']",that).focus();});
			return;
		}

		if	($("input[name='agent']:checked",that).val() == 'each' && $(".each_agent:checkbox:checked",that).length < 1){
			openDialogAlert('환경을 선택해주세요.','400','160',function(){$("input[name='agent_pc']",that).focus();});
			return;
		}

		if	($("input[name='act']:checked",that).val() == 'review_sum' && $("input[name='review_cnt']",that).val() < 1){
			openDialogAlert('몇 회 이상의 상품후기 횟수 입력은 필수 사항입니다.','400','160',function(){$("input[name='review_cnt']",that).focus();});
			return;
		}

		if	($("input[name='min_ea']",that).val() < 1){
			openDialogAlert('최소 노출 개수는 필수 사항입니다.','400','160',function(){$("input[name='min_ea']",that).focus();});
			return;
		}

		var formParams_arr = $('#select_auto_condition_form',that).serializeArray();
		var params = new Array();
		var arr = new Array();
		var provider_flag = false;
		for(var i in formParams_arr){
			if	(formParams_arr[i].name == 'daumedit' || formParams_arr[i].name == 'isFirst') continue;
			if	(formParams_arr[i].name == 'provider' && formParams_arr[i].value == 'seller') provider_flag = true;
			if	(!provider_flag){
				if	(formParams_arr[i].name == 'provider_seq_selector' || formParams_arr[i].name == 'provider_seq' || 	formParams_arr[i].name == 'provider_name') continue;
			}
			if	(formParams_arr[i].value!=null && formParams_arr[i].value.length>0) {
				var val = formParams_arr[i].name+"="+encodeURIComponent(formParams_arr[i].value);
				if	(formParams_arr[i].name=='selectCategory1' || formParams_arr[i].name=='selectCategory2' || formParams_arr[i].name=='selectCategory3' || formParams_arr[i].name=='selectCategory4' || formParams_arr[i].name=='selectBrand1' || formParams_arr[i].name=='selectBrand2' || formParams_arr[i].name=='selectBrand3' || formParams_arr[i].name=='selectBrand4' || formParams_arr[i].name=='selectLocation1' || formParams_arr[i].name=='selectLocation2' || formParams_arr[i].name=='selectLocation3' || formParams_arr[i].name=='selectLocation4'){
					val = val+"="+$("#select_auto_condition_form select[name='"+formParams_arr[i].name+"'] option:selected",that).text();
				}
				params.push(val);
			}
		}
		
<?php if($TPL_VAR["kind"]=='none'){?>
			$("input[name='auto_condition']").val(params.join(","));
			auto_light_condition_set();
<?php }else{?>
<?php if($TPL_VAR["bigdata_test"]== 1){?>
				$("input[name='displayCriteria']").val('<?php echo $TPL_VAR["kind"]?>'+'∀'+params.join(","));
				top.setCriteriaDescription_upgrade();
				get_test_list();
<?php }else{?>
				$("input[name='auto_condition[]']").eq('<?php echo $TPL_VAR["condition_idx"]?>').val(params.join(","));
				setAutoConditionDescription('<?php echo $TPL_VAR["displayKind"]?>');
<?php }?>
<?php }?>


		$(that).closest('.ui-dialog').remove();
		closeDialog("condition_change_option");
	}
};

<?php if($TPL_VAR["kind"]=='none'){?>
// 자동 1 전용 콜백 함수
function auto_light_condition_set(){
	var tabIdx = $("#<?php echo $_GET["inputGoods"]?>").closest('.displayTabGoodsContainer').attr('tabIdx');
	condition = new Array();
	temp = 'none∀'+$("#select_auto_condition input[name='auto_condition']").val();
	condition.push(temp);
	$("#<?php echo $_GET["inputGoods"]?>").val(condition.join('Φ'));

<?php if($_GET["displayKind"]!='relation_seller'){?>
		$("#<?php echo $_GET["auto_condition_use_id"]?>").val(1);
<?php }?>
	
<?php if($_GET["displayKind"]=='relation'){?>
		$("input[name='relation_type'][value='AUTO']").attr("checked",true).change();
<?php }else{?>
		$("select.contents_type").eq(tabIdx).val("auto").change();
<?php }?>

	setCriteriaDescription_upgrade();
}
<?php }?>
</script>
<div id="select_auto_condition">
	<input type="hidden" class="display_kind" value="<?php echo $TPL_VAR["displayKind"]?>" />
	<input type="hidden" name="select_kind" value="<?php echo $TPL_VAR["kind"]?>"/>
	<form name="select_auto_condition_form" id="select_auto_condition_form">
	<input type="hidden" name="type" value="select_auto" />
	<input type="hidden" name="isFirst" value="" />
<?php if($TPL_VAR["kind"]=='none'){?>
	<input type="hidden" name="auto_condition" value="" />
<?php }?>
	<table class="info-table-style" width="100%" border="0" cellpadding="0" cellspacing="0">
		<col width="125"/>
		<col width="170"/>
		<tr>
			<th class="its-th-align">타이틀</th>
			<td class="its-td left" colspan="2">
				<div style="width:782px">
					<textarea name="display_title" contentHeight="170px" class="daumeditor"></textarea>
				</div>
			</td>
		</tr>
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'&&($TPL_VAR["displayKind"]=='category'||$TPL_VAR["displayKind"]=='brand'||$TPL_VAR["displayKind"]=='location'||$TPL_VAR["displayKind"]=='mshop')){?>
		<tr>
			<th class="its-th-align">기준</th>
			<td class="its-td left" height="30" colspan="2">
				<input type="checkbox" name="same_<?php echo $TPL_VAR["displayKind"]?>" class="hide same_admin" value="1" checked /> 
				해당 <?php if($TPL_VAR["displayKind"]=='category'){?>카테고리<?php }elseif($TPL_VAR["displayKind"]=='location'){?>지역<?php }elseif($TPL_VAR["displayKind"]=='brand'){?>브랜드<?php }elseif($TPL_VAR["displayKind"]=='mshop'){?>판매자<?php }?> 상품 중에서
			</td>
		</tr>
<?php }elseif($TPL_VAR["kind"]=='admin'){?>
		<tr>
			<th class="its-th-align">기준</th>
			<td class="its-td left">관리자가 지정한 기준</td>
			<td class="its-td left">
				<ul class="admin_select">
					<li>
						<select name="selectCategory1" class="select_category" style="width:120px">
						<option value="">1차 카테고리</option>
						</select>
						<select name="selectCategory2" class="select_category" style="width:120px">
						<option value="">2차 카테고리</option>
						</select>
						<select name="selectCategory3" class="select_category" style="width:120px">
						<option value="">3차 카테고리</option>
						</select>
						<select name="selectCategory4" class="select_category" style="width:120px">
						<option value="">4차 카테고리</option>
						</select>
<?php if($TPL_VAR["displayKind"]=='relation_seller'||$TPL_VAR["displayKind"]=='relation'){?>
						<label>
							<input type="checkbox" name="same_category" class="same_admin" value="1" /> 동일 카테고리
						</label>
<?php }?>
					</li>
					<li>
						<select name="selectBrand1" class="select_brand" style="width:120px">
						<option value="">1차 브랜드</option>
						</select>
						<select name="selectBrand2" class="select_brand" style="width:120px">
						<option value="">2차 브랜드</option>
						</select>
						<select name="selectBrand3" class="select_brand" style="width:120px">
						<option value="">3차 브랜드</option>
						</select>
						<select name="selectBrand4" class="select_brand" style="width:120px">
						<option value="">4차 브랜드</option>
						</select>
<?php if($TPL_VAR["displayKind"]=='relation_seller'||$TPL_VAR["displayKind"]=='relation'){?>
						<label>
							<input type="checkbox" name="same_brand" class="same_admin" value="1" /> 동일 브랜드
						</label>
<?php }?>
					</li>
					<li>
						<select name="selectLocation1" class="select_location" style="width:120px">
						<option value="">1차 지역</option>
						</select>
						<select name="selectLocation2" class="select_location" style="width:120px">
						<option value="">2차 지역</option>
						</select>
						<select name="selectLocation3" class="select_location" style="width:120px">
						<option value="">3차 지역</option>
						</select>
						<select name="selectLocation4" class="select_location" style="width:120px">
						<option value="">4차 지역</option>
						</select>
<?php if($TPL_VAR["displayKind"]=='relation_seller'||$TPL_VAR["displayKind"]=='relation'){?>
						<label>
							<input type="checkbox" name="same_location" class="same_admin" value="1" /> 동일 지역
						</label>
<?php }?>
					</li>
<?php if(serviceLimit('H_AD')){?>
<?php if($_GET["provider_seq"]== 1||$_GET["provider_seq"]==''){?>
					<li>
						<label><input type="radio" name="provider" class="select_seller" value="all" checked /> 전체</label>
						<label><input type="radio" name="provider" class="select_seller" value="1"/> 본사</label>
						<label><input type="radio" name="provider" class="select_seller" value="seller"/> 판매자</label>
						<select name="provider_seq_selector" class="select_seller" style="vertical-align:middle;">
						<option value="0">- 입점사 검색 -</option>
						<option value="999999999999">입점사 전체(본사제외)</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["provider_seq"]?>"><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }}?>
						</select>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $_GET["provider_seq"]?>" />
						<input type="text" name="provider_name" class="select_seller" value="<?php echo $_GET["provider_name"]?>" readonly />
						<script>
						$(function(){
							$( "select[name='provider_seq_selector']" )
							.combobox()
							.change(function(){
								if( $(this).val() > 0 ){
									$("input[name='provider_seq']",$('#select_auto_condition')).val($(this).val());
									$("input[name='provider_name']",$('#select_auto_condition')).val($("option:selected",this).text());
								}else{
									$("input[name='provider_seq']",$('#select_auto_condition')).val('');
									$("input[name='provider_name']",$('#select_auto_condition')).val('');
								}
							})
							.next(".ui-combobox").children("input")
							.bind('focus',function(){
								if($(this).val()==$( "select[name='provider_seq_selector'] option:first-child" ).text()){
									$(this).val('');
								}
							})
							.bind('mouseup',function(){
								if($(this).val()==''){
									$( "select[name='provider_seq_selector']").next(".ui-combobox").children("a.ui-combobox-toggle").click();
								}
							});
						});
						</script>
<?php if($TPL_VAR["displayKind"]=='relation_seller'||$TPL_VAR["displayKind"]=='relation'){?>
						<label>
							<input type="checkbox" name="same_seller" class="same_admin" value="1" /> 동일 판매자
						</label>
<?php }?>
					</li>
<?php }else{?>
					<li><input type="hidden" name="same_seller" value="1"/></li>
<?php }?>
<?php }?>
				</ul>
			</td>
		</tr>
<?php }else{?>
		<tr>
			<th class="its-th-align">
				기준
			</th>
			<td class="its-td left" height="30" colspan="2">
			<span>
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'&&($TPL_VAR["displayKind"]=='relation'||$TPL_VAR["displayKind"]=='relation_seller')){?>
				해당 상품과
<?php }elseif($TPL_VAR["config_system"]["operation_type"]!='light'&&($TPL_VAR["displayKind"]=='bigdata'||$TPL_VAR["displayKind"]=='bigdata_catalog')){?>
				○○○고객이 보고 있는 이상품과
<?php }else{?>
				○○○고객이 최근
<?php if($TPL_VAR["kind"]=='view'){?>
				본
<?php }elseif($TPL_VAR["kind"]=='cart'){?>
				장바구니에 담은
<?php }elseif($TPL_VAR["kind"]=='review'){?>
				리뷰를 쓴
<?php }elseif($TPL_VAR["kind"]=='wish'){?>
				위시리스트에 찜한
<?php }elseif($TPL_VAR["kind"]=='fblike'){?>
				'좋아요'한
<?php }elseif($TPL_VAR["kind"]=='restock'){?>
				'재입고 알림요청'한
<?php }elseif($TPL_VAR["kind"]=='search'){?>
				검색한 검색결과 최상위
<?php }elseif($TPL_VAR["kind"]=='order'){?>
				구매한
<?php }?>
				상품과
<?php }?>
			</span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label>
				<input type="checkbox" name="same_category" class="same_condition" value="1"/>
				동일한 카테고리
			</label>
			&nbsp;
			<label>
				<input type="checkbox" name="same_brand" class="same_condition" value="1"/>
				동일한 브랜드
			</label>
			&nbsp;
			<label>
				<input type="checkbox" name="same_location" class="same_condition" value="1"/>
				동일한 지역
			</label>
			&nbsp;
<?php if(serviceLimit('H_AD')&&($TPL_VAR["displayKind"]=='relation_seller'||$TPL_VAR["displayKind"]=='design')){?>
			<label>
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'&&$TPL_VAR["displayKind"]=='relation_seller'){?>
				<input type="hidden" name="same_seller" value="1" />
				<input type="checkbox" class="same_condition" value="1" checked disabled />
<?php }else{?>
				<input type="checkbox" class="same_condition" name="same_seller" value="1" />
<?php }?>
				동일한 판매자의
			</label>
<?php }?>
			상품 중에서
			<br />
<?php if($TPL_VAR["displayKind"]=='bigdata'||$TPL_VAR["displayKind"]=='bigdata_catalog'){?>
				해당 상품을
				<select name="bigdata_month">
					<option value="6">최근 6개월 안에</option>
					<option value="3">최근 3개월 안에</option>
					<option value="1">최근 1개월 안에</option>
				</select>
<?php if($TPL_VAR["kind"]=='view'){?>
				본
<?php }elseif($TPL_VAR["kind"]=='cart'){?>
				장바구니에 담은
<?php }elseif($TPL_VAR["kind"]=='wish'){?>
				위시리스트에 찜한
<?php }elseif($TPL_VAR["kind"]=='fblike'){?>
				좋아요한
<?php }elseif($TPL_VAR["kind"]=='review'){?>
				상품후기 작성한
<?php }elseif($TPL_VAR["kind"]=='order'){?>
				구매한
<?php }?>
				다른 고객이
<?php }?>
			</td>
		</tr>
<?php }?>
		<tr>
			<th class="its-th-align">통계대상 기간</th>
			<td class="its-td left" height="30" colspan="2">
				<span class="date_month date_active">최근 1개월</span>
				<span class="date_month">최근 2개월</span>
				<span class="date_month">최근 3개월</span>
				<span class="date_month">최근 4개월</span>
				<span class="date_month">최근 5개월</span>
				<span class="date_month">최근 6개월</span>
				<span class="date_desc">동안</span>
				<input type="hidden" name="month" value=""/>
			</td>
		</tr>
		<tr class="detail_act">
			<th class="its-th-align">통계대상 연령</th>
			<td class="its-td left relative" colspan="2">
				<label><input type="radio" name="age" value="all" checked/> 전체</label>
				<label class="absolute" style="left:105px;">
					<input type="radio" name="age" value="each" />
					<label><input type="checkbox" name="each_age_10" class='auto_check each_age' value="10"/> 10대</label>
					<label><input type="checkbox" name="each_age_20" class='auto_check each_age' value="20"/> 20대</label>
					<label><input type="checkbox" name="each_age_30" class='auto_check each_age' value="30"/> 30대</label>
					<label><input type="checkbox" name="each_age_40" class='auto_check each_age' value="40"/> 40대</label>
					<label><input type="checkbox" name="each_age_50" class='auto_check each_age' value="50"/> 50대</label>
					<label><input type="checkbox" name="each_age_60" class='auto_check each_age' value="60"/> 60대</label>
				</label>
				<label style="position:absolute;right:30px;">
					<input type="radio" name="age" value="same"/>
					○○○고객과 같은 연령대 (고객 연령 모를 경우 전체 연령)
				</label>
			</td>
		</tr>
		<tr class="detail_act">
			<th class="its-th-align">통계대상 성별</th>
			<td class="its-td left relative" colspan="2">
				<label><input type="radio" name="sex" value="all" checked/> 전체</label>
				<label class="absolute" style="left:105px;">
					<input type="radio" name="sex" value="each" />
					<label><input type="checkbox" name="each_sex_male" class='auto_check each_sex' value="male"/> 남성</label>
					<label><input type="checkbox" name="each_sex_female" class='auto_check each_sex' value="female"/> 여성</label>
					<label><input type="checkbox" name="each_sex_none" class='auto_check each_sex' value="none"/> 모름</label>
				</label>
				<label class="absolute" style="right:42px;">
					<input type="radio" name="sex" value="same" />
					○○○고객과 같은 성별 (고객 성별 모를 경우 전체 성별)
				</label>
			</td>
		</tr>
		<tr class="detail_act">
			<th class="its-th-align">통계대상 환경</th>
			<td class="its-td left relative" colspan="2">
				<label><input type="radio" name="agent" value="all" checked/> 전체</label>
				<label class="absolute" style="left:105px;">
					<input type="radio" name="agent" value="each" />
					<label><input type="checkbox" name="each_agent_pc" class='auto_check each_agent' value="pc"/> PC환경</label>
					<label><input type="checkbox" name="each_agent_mobile" class='auto_check each_agent' value="mobile"/> Mobile환경</label>
				</label>
				<label class="absolute" style="right:220px;">
					<input type="radio" name="agent" value="same" />
					○○○고객과 같은 환경
				</label>
			</td>
		</tr>
		<tr>
			<th class="its-th-align">통계대상 행동</th>
			<td class="its-td left" colspan="2">
				<label>
				<div class="fl stat_act_div hand select">
					<input type="radio" name="act" value="order_cnt" checked />
					구매(횟수)량이 높은
				</div>
				</label>
				<label>
				<div class="fl stat_act_div hand">
					<input type="radio" name="act" value="order_ea" />
					구매(수량)량이 높은
				</div>
				</label>
				<label>
				<div class="fl stat_act_div hand">
					<input type="radio" name="act" value="cart" />
					많이 장바구니에 담은
				</div>
				</label>
				<label>
				<div class="fl stat_act_div hand">
					<input type="radio" name="act" value="wish" />
					많이 위시리스트에 찜한
				</div>
				</label>
				<label>
				<div class="fl stat_act_div hand">
					<input type="radio" name="act" value="view" />
					많이 본
				</div>
				</label>
				<div class="clearbox" style="padding-top:100px;"></div>
				<label>
				<div class="fl stat_act_div hand">
					<input type="radio" name="act" value="review" />
					<span style="line-height:40px;">상품후기가<br/>많이 작성된</span>
				</div>
				</label>
				<label>
				<div class="fl stat_act_div hand">
					<input type="radio" name="act" value="review_sum" />
					<input type="text" name="review_cnt" class="onlynumber" size="2" value="1" />
					<span style="line-height:40px;">베스트 상품 후기가<br/>많은 상품</span>
				</div>
				</label>
				<label>
				<div class="fl stat_act_div hand">
					<input type="radio" name="act" value="fblike" />
					<span style="line-height:40px;">‘좋아요’가<br/>많은 상품</span>
				</div>
				</label>
<?php if($TPL_VAR["displayKind"]!='bigdata'&&$TPL_VAR["displayKind"]!='bigdata_catalog'){?>
				<label>
				<div class="fl stat_act_div hand">
					<input type="radio" name="act" value="recently" />
					<span style="line-height:40px;">최근에 등록한<br/>상품</span>
				</div>
				</label>
<?php }?>
			</td>
		</tr>
		<tr>
			<th class="its-th-align">통계대상 노출</th>
			<td class="its-td left" colspan="2">
				승인, 노출, 정상 상태의 상품이 최소 <input type="text" name="min_ea" class="onlynumber" size="2" value="1" /> 개 이상일때 추천상품 노출
			</td>
		</tr>
	</table>
	<div class="center mt20">
		<span class="btn medium cyanblue"><button type="button" onclick="set_auto_condition(this);">사용</button></span>
		<span class="btn medium"><input type="button" value="닫기" class="close_condition" /></span>
	</div>
	</form>
</div>