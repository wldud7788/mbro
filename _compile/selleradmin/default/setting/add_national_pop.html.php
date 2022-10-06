<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/setting/add_national_pop.html 000045213 */ 
$TPL_ship_set_code_1=empty($TPL_VAR["ship_set_code"])||!is_array($TPL_VAR["ship_set_code"])?0:count($TPL_VAR["ship_set_code"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<style>
html {overflow-y: hidden;}
body{background:#FFF;}
#wrap {height: 100%;}
</style>

<script type="text/javascript" src="/app/javascript/js/admin-shipping.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript">
var unit	= '<?php echo $TPL_VAR["punit"]?>'; // 기본 통화 단위
var nation	= '<?php echo $_GET["nation"]?>'; // 추가국가
var zoneTxt = '<?php if($_GET["nation"]=="korea"){?>지역<?php }else{?>국가<?php }?>'; // 국내/해외
$(document).ready(function() {
	// 배송지역 제한 타입 변경
	$("input[name='delivery_limit']").bind("change",function(){
		var delivery_limit = $(this).val();
		if(delivery_limit == 'limit'){
			var zone_html = '<span class="std_btn_area issueCount" style="left:45px;top:0px;"><input type="hidden" class="issue" name="issue[std][]" value="0" /><span class="hgi-left"><span class="hgi-right"><span class="hgi-bg">!</span></span></span></span> <span class="add_zone hand blue" onclick="add_zone_pop(this);">'+zoneTxt+'1<input type="hidden" name="shipping_area_name[std][]" value="'+zoneTxt+'1"></span><span class="zone_cnt blue">(0)</span>';
			$(this).closest("td").find(".price_set_area").find(".zone_text").html(zone_html);
			$(this).closest("td").find(".price_set_area").find(".zone_area_add_btn").show();
		}else{
			$(this).closest("td").find(".price_set_area").find(".zone_text").html('<?php if($_GET["nation"]=="korea"){?>대한민국<?php }else{?>전세계<?php }?>');
			$(this).closest("td").find(".price_set_area").find(".zone_area_add_btn").hide();
			zone_area_reset($(this).closest("td").find(".price_set_area"));
			$(this).closest("td").find(".price_set_area").find(".zone_address_area").html('');
		}
		
		del_zone_addr(this, delivery_limit);
	});

	// 배송방법 custom Name 사용여부 정의
	$("#custom_set_use").bind("change",function(){
		if($(this).is(':checked')){
			$("input[name='shipping_set_name']").attr('disabled',false);
		}else{
			$("input[name='shipping_set_name']").attr('disabled',true);
		}
	});

	// 배송안내 자동안내 설명 팝업창
	$("#btn_autoinfo_desc").bind("click",function(){
		auto_info_pop();
	});

	// 배송설정 타입별 기본 사용여부 체크
	$(".used_check").bind("change",function(){
		set_type_used($(this).attr('name').substring(0,$(this).attr('name').length - 4));
	});

	// 반품 배송비 왕복 시 요금 체크
	$("#refund_shiping_cost").on("change",function(){
		var refund_shiping_cost		= $("#refund_shiping_cost").val();
		$(".refund_shiping_double").html(get_currency_price(refund_shiping_cost * 2));
	});

	// 배송방법 정의
	shipping_set_chk();
	
	// 수정시 처리
	modify_apply();
	
	$(".shipping_opt_type").on('focus', function () {
		previous = this.value;
	}).on('change', function(e) {
		var shipping_opt_type	= $(this).val();
		var shipping_group_seq	= $("input[name='shipping_group_seq").val();
		var shipping_set_seq	= $("input[name='shipping_set_seq").val();
		var shipping_set_type	= $(this).closest("table").attr("price_type"); //std,add
		
		var section_st = new Array();
		var section_ed = new Array();

		if(shipping_opt_type == 'free'){ // 무료
			$("input[name='shipping_cost["+shipping_set_type+"][]").val('0');
		}else if(shipping_opt_type == 'fixed'){ // 고정
			$("input[name='shipping_cost["+shipping_set_type+"][]']").each(function(index, val) {
				if($(this).val() <= 0){
					$(this).attr('value', '2500');
				}
			});
		}else{ // 금액
			$("input[name='shipping_cost["+shipping_set_type+"][]']").each(function(index, val) {
				if($(this).val() <= 0){
					$(this).attr('value', '2500');
				}
			});
			$("input[name='section_st["+shipping_set_type+"][]']").each(function(index, val) {
				if(index == 0){
					$(this).val(0);
				} else {
					$(this).val(1);
				}
				section_st.push($(this).val());
			});
			
			$("input[name='section_ed["+shipping_set_type+"][]']").each(function(index, val) {
				if(index == 0){
					$(this).val(1);
				} else {
					var is_rep = shipping_opt_type.split("_");
					
					if(is_rep.length > 1){
						$(this).val(1);
					} else {
						$(this).val(0);
					}
					
				}
				section_ed.push($(this).val());
			});
		}
		
		var shipping_opt_sec_cost	= new Array();
		var areaLength				= $("input[name='shipping_cost["+shipping_set_type+"][]']").length;
		areaLength = areaLength/2;

		$("input[name='shipping_cost["+shipping_set_type+"][]']").each(function(index, val) {
			shipping_opt_sec_cost.push($(this).val());
		});
		
		var delivery_nation		= $("input[name='delivery_nation']").val();
		var delivery_limit		= $("input[name='delivery_limit']").val();
		
		$.ajax({
			type : "get",
			url : '../setting/shipping_otp_modify',
			data : {
				'shipping_opt_type'		: shipping_opt_type,
				'shipping_group_seq'	: shipping_group_seq,
				'shipping_set_seq'		: shipping_set_seq,
				'shipping_set_type'		: shipping_set_type,
				'shipping_opt_sec_cost'	: shipping_opt_sec_cost,
				'areaLength'			: areaLength,
				'section_st'			: section_st,
				'section_ed'			: section_ed,
				'shipping_calcul_type'	: '<?php echo $_GET["calcul_type"]?>',
				'delivery_nation'		: delivery_nation,
				'delivery_limit'		: delivery_limit
			},
			success : function(res) {
				var res = jQuery.parseJSON(res);
				$("input[name='shipping_opt_seq["+shipping_set_type+"][]']").each(function(index, val) {
					if(res.options[index] > 0){
						$(this).val(res['options'][index]);
						
						var areaLength = res['costs'][index].length;
						var costIdx = parseInt(index) * parseInt(areaLength);
						
						$(res['costs'][index]).each(function(cIdx, cVal){
							$("input[name='shipping_cost_seq["+shipping_set_type+"][]']").eq(costIdx).val(cVal);
							costIdx++;
						});
					}
				});
			}
		})
	});
});

// 수정시 처리내역 함수 정의
function modify_apply(){
	// 배송방법 처리
	$("select[name='shipping_set_code']").val('<?php echo $TPL_VAR["params"]["shipping_set_code"]?>').trigger('change');
	// custom name 처리
<?php if($TPL_VAR["params"]["custom_set_use"]=='Y'){?>
	$("#custom_set_use").attr('checked',true).trigger('change');
	var shipping_set_name = `<?php echo $TPL_VAR["params"]["shipping_set_name"]?>`;
	$("input[name='shipping_set_name']").val(shipping_set_name);
<?php }?>
<?php if($TPL_VAR["params"]["std_use"]=='Y'){?>
	// 기본 사용여부 처리 및 데이터 채우기
	$("input[name='std_use']").attr('checked',true).trigger('change');
	$("input[name='delivery_std_type']:radio[value=<?php echo $TPL_VAR["params"]["delivery_std_type"]?>]").attr("checked","checked");
	shipping_opt_type($("select[name='shipping_opt_type[std]']"), <?php echo json_encode($TPL_VAR["optTypeArr"]['std'])?>);
<?php }?>
<?php if($TPL_VAR["params"]["add_use"]=='Y'){?>
	// 추가 사용여부 처리 및 데이터 채우기
	$("input[name='add_use']").attr('checked',true).trigger('change');
	$("input[name='delivery_add_type']:radio[value=<?php echo $TPL_VAR["params"]["delivery_add_type"]?>]").attr("checked","checked");
	shipping_opt_type($("select[name='shipping_opt_type[add]']"), <?php echo json_encode($TPL_VAR["optTypeArr"]['add'])?>, 'add');
<?php }?>
<?php if($TPL_VAR["params"]["hop_use"]=='Y'){?>
	// 희망 사용여부 처리 및 데이터 채우기
	$("input[name='hop_use']").attr('checked',true).trigger('change');
	$("input[name='delivery_hop_type']:radio[value=<?php echo $TPL_VAR["params"]["delivery_hop_type"]?>]").attr("checked","checked");
	shipping_opt_type($("select[name='shipping_opt_type[hop]']"), <?php echo json_encode($TPL_VAR["optTypeArr"]['hop'])?>);
<?php }?>
<?php if($TPL_VAR["params"]["store_use"]=='Y'){?>
	// 매장 사용여부 처리 및 데이터 채우기
	$("input[name='store_use']").attr('checked',true).trigger('change');
	$("input[name='delivery_store_type']:radio[value=<?php echo $TPL_VAR["params"]["delivery_store_type"]?>]").attr("checked","checked");
<?php }?>
}

function use_check(obj, type){

	var shipping_group_seq	= $("input[name='shipping_group_seq").val();
	var shipping_set_seq	= $("input[name='shipping_set_seq").val();
	
	if($(obj).is(":checked") == true){
		var useVal = 'Y';
	} else {
		var useVal = 'N';
	}
	
	$.ajax({
		type : "get",
		url : '../setting/shipping_add_modify',
		data : {
			'shipping_group_seq' : shipping_group_seq,
			'shipping_set_seq' : shipping_set_seq,
			'useVal' : useVal,
			'shipping_set_type' : type
		},
		success : function(res) {
			if(useVal == 'N'){
				/*
				$("#price_"+type).find(".add_zone").removeAttr("data-seq");
				$("#price_"+type).find(".add_zone").removeAttr("data-total");
				$("#price_"+type).find(".zone_cnt").text("(0)");
				$("#price_"+type).find("input[name='shipping_cost["+type+"][]']").attr("value", 0);
				*/
			} else {
				$("#price_"+type).find(".add_zone").append('<input type="hidden" name="shipping_area_name['+type+'][]" value="지역1">');
			}
		}
	})
}

// 최종 적용
function submit_shipping_item(){
<?php if($TPL_VAR["params"]["mode"]=='modify'){?>
	// 수정일때 처리
<?php }?>
	$("form[name='shippingfrm']").submit();
}
</script>
<div class="contents_container">
<form name="shippingfrm" id="shippingfrm" method="post" action="../setting_process/add_shipping_item" target="actionFrame" class="hx100">
<?php if($TPL_VAR["params"]["mode"]=='modify'){?>
<input type="hidden" name="shipping_set_seq" value="<?php echo $TPL_VAR["params"]["shipping_set_seq"]?>" />
<input type="hidden" name="idx" value="<?php echo $TPL_VAR["params"]["idx"]?>" />
<input type="hidden" name="shipping_group_seq" value="<?php echo $TPL_VAR["params"]["shipping_group_seq"]?>" />
<input type="hidden" name="shipping_group_name" value="<?php echo $TPL_VAR["params"]["shipping_group_name"]?>" />
<?php }else{?>
<input type="hidden" name="shipping_group_seq" value="<?php echo $_GET["shipping_group_dummy_seq"]?>" />
<?php }?>
<input type="hidden" name="delivery_nation" value="<?php echo $_GET["nation"]?>" />
<?php if($_GET["shipping_group_seq"]){?>
<input type="hidden" name="shipping_group_seq" value="<?php echo $_GET["shipping_group_seq"]?>" />
<?php }else{?>
<input type="hidden" name="shipping_group_seq" value="<?php echo $TPL_VAR["params"]["shipping_group_seq"]?>" />
<?php }?>
<input type="hidden" name="shipping_set_seq" value="<?php echo $TPL_VAR["params"]["shipping_set_seq"]?>" />
<input type="hidden" name="shipping_group_real_seq" value="<?php echo $TPL_VAR["params"]["shipping_group_real_seq"]?>" />

<!-- 배송 설정 :: START -->
<div class="content">
	<div class="price_area pd10">
		<div class="pdb10">
			<select name="delivery_type">
				<option value="basic">1회구매</option>
				<!--option value="regulr">정기배송</option-->
			</select>
		</div>
		<table class="table_basic v7 v10 pd5">
		<colgroup>
			<col width="150px" />
			<col width="100px" />
			<col width="100px" />
			<col />
		</colgroup>
		<tr>
			<th>배송방법</th>
			<th colspan="3">
				<span>[<?php echo $TPL_VAR["calcul_type_tit"]?>]</span> 배송비 = 기본 + 추가 + 희망배송일
			</th>
		</tr>

		<!-- 기본배송비 :: START -->
		<tr class="std_tr">
			<td rowspan="6">
				<select name="shipping_set_code" onchange="shipping_set_chk();">
<?php if($TPL_ship_set_code_1){foreach($TPL_VAR["ship_set_code"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
				<div class="mt5">
					<label class="resp_checkbox"><input type="checkbox" name="custom_set_use" id="custom_set_use" value="Y" /></label>
					<input type="text" name="shipping_set_name" value="" style="width:100px;" disabled />
				</div>
				<div class="resp_radio col">
					<label><input type="radio" name="prepay_info" value="delivery" <?php if($TPL_VAR["params"]["prepay_info"]=='delivery'||!$TPL_VAR["params"]["prepay_info"]){?>checked<?php }?> /> 선불</label><br/>	
					<label><input type="radio" name="prepay_info" value="postpaid" <?php if($TPL_VAR["params"]["prepay_info"]=='postpaid'){?>checked<?php }?> /> 착불</label><br/>				
					<label><input type="radio" name="prepay_info" value="all" <?php if($TPL_VAR["params"]["prepay_info"]=='all'){?>checked<?php }?> /> 선불/착불</label>
				</div>
			</td>
			<td rowspan="4">
				배송비
			</td>
			<td class="center nonpd check_td">
				기본 <label class="resp_checkbox"><input type="checkbox" class="used_check std_area_check hide" name="std_use" value="Y" <?php if(!$TPL_VAR["params"]["std_use"]){?>checked<?php }?> /></label>
			</td>
			<td>
				<div class="combobox_area resp_radio">
					<label><input type="radio" class="std_area" name="delivery_limit" value="unlimit" <?php if($TPL_VAR["params"]["delivery_limit"]=='unlimit'||!$TPL_VAR["params"]["delivery_limit"]){?>checked<?php }?> /> <?php if($_GET["nation"]=='korea'){?>대한민국 전국 배송<?php }else{?>해외국가<?php }?></label>					
					<label><input type="radio" class="std_area" name="delivery_limit" value="limit" <?php if($TPL_VAR["params"]["delivery_limit"]=='limit'){?>checked<?php }?> /> <?php if($_GET["nation"]=='korea'){?>대한민국 중 지정 지역 배송<?php }else{?>해외국가 중 선택 국가 배송<?php }?></label>
				</div>
				<div class="basic_shipping_area">
					<!-- 금액 설정부 :: START -->
					<table class="table_basic wauto price_set_area" id="price_std" price_type="std">
					<thead>
					<tr>
						<th colspan="2">
							<select class="shipping_opt_type std_area" name="shipping_opt_type[std]" onchange="shipping_opt_type(this, []);" style="width:130px;">
								<option value="free" <?php if($TPL_VAR["params"]['shipping_opt_type']['std']=='free'){?>selected<?php }?>>무료</option>
<?php if($_GET["calcul_type"]!='free'){?>
								<option value="fixed" <?php if($TPL_VAR["params"]['shipping_opt_type']['std']=='fixed'){?>selected<?php }?>>고정</option>
								<option value="amount" <?php if($TPL_VAR["params"]['shipping_opt_type']['std']=='amount'){?>selected<?php }?>>금액(구간입력)</option>
								<option value="amount_rep" <?php if($TPL_VAR["params"]['shipping_opt_type']['std']=='amount_rep'){?>selected<?php }?>>금액(구간반복)</option>
								<option value="cnt" <?php if($TPL_VAR["params"]['shipping_opt_type']['std']=='cnt'){?>selected<?php }?>>수량(구간입력)</option>
								<option value="cnt_rep" <?php if($TPL_VAR["params"]['shipping_opt_type']['std']=='cnt_rep'){?>selected<?php }?>>수량(구간반복)</option>
								<option value="weight" <?php if($TPL_VAR["params"]['shipping_opt_type']['std']=='weight'){?>selected<?php }?>>무게(구간입력)</option>
								<option value="weight_rep" <?php if($TPL_VAR["params"]['shipping_opt_type']['std']=='weight_rep'){?>selected<?php }?>>무게(구간반복)</option>
<?php }?>
							</select>
							<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/shipping_group', '#tip10', 'sizeR')"></span>
						</th>
						<th>
							<span class="zone_text zone_idx_0" idx="0" >
<?php if($TPL_VAR["params"]['delivery_limit']=='unlimit'){?>
<?php if($_GET["nation"]=='korea'){?>대한민국<?php }else{?>전세계<?php }?>
<?php }elseif($TPL_VAR["params"]['delivery_limit']=='limit'){?>
<?php if($_GET["nation"]=='korea'){?>지역<?php }else{?>국가<?php }?>
<?php }else{?>
<?php if($_GET["nation"]=='korea'){?>대한민국<?php }else{?>전세계<?php }?>
<?php }?>
							</span>
							<span class="zone_area_add_btn hide">
								<span class="ctrl-add-btn add-col std_btn_area "><button class="resp_btn active size_S ctrl-btn" type="button" onclick="add_price_section(this,'zone');">추가</button></span>
							</span>
							<div class="zone_address_area"></div>
						</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<th class="its-th center" width="50px">
							<div class="section_area_add_btn hide">
								<span class="ctrl-add-btn add-row std_btn_area"><button class="resp_btn active size_S ctrl-btn" type="button" onclick="add_price_section(this,'section');">추가</button></span>
							</div>
						</th>
						<td class="its-td section_area_td">
							<div class="section_area_input hide">
								<input type="hidden" name="shipping_opt_seq[std][]" value=""> 
								<input type="text" name="section_st[std][]" value="0" class="section_st_input std_area wx90" readonly /> <span class="section_st_unit std_area"></span>
								~
								<input type="text" name="section_ed[std][]" value="0" class="section_ed_input line std_area onlyfloat wx90" onclick="if($(this).val()==0) $(this).val('');" onblur="section_auto_chk(this);" /> <span class="section_ed_unit"></span>
							</div>
						</td>
						<td class="its-td" width="105px">
							<input type="hidden" name="shipping_cost_seq[std][]" value="0" /> 
							<input type="text" name="shipping_cost[std][]" value="0" class="line right shipping-cost-input std_area onlyfloat wx50" onclick="if($(this).val()==0) $(this).val('');" disabled /> <?php echo $TPL_VAR["punit"]?>

						</td>
					</tr>
					</tbody>
					<!-- 마지막행 :: START -->
					<tfoot>
					<tr class="last-tr-base hide">
						<th class="its-th center" width="50px">
						</th>
						<td class="its-td">
							<div class="section_area_input hide">
								<input type="hidden" name="shipping_opt_seq[std][]" value=""> 
								<input type="text" name="section_st[std][]" value="0" class="section_st_input std_area wx90" readonly/> <span class="section_st_unit"></span>
								<span class="suffix hide">
									<input type="text" name="section_ed[std][]" value="0" class="section_ed_input line std_area onlyfloat wx90" onclick="if($(this).val()==0) $(this).val('');" onblur="section_auto_chk(this);" /> <span class="section_ed_unit"></span>
								</span>
							</div>
						</td>
						<td class="its-td" width="105px">
							<input type="hidden" name="shipping_cost_seq[std][]" value="0" /> 
							<input type="text" name="shipping_cost[std][]" value="0" class="line right shipping-cost-input std_area onlyfloat wx50" onclick="if($(this).val()==0) $(this).val('');" /> <?php echo $TPL_VAR["punit"]?>

						</td>
					</tr>
					</tfoot>
					<!-- 마지막행 :: END -->
					</table>
					<!-- 금액 설정부 :: END -->
				</div>
			</td>
		</tr>
		<!-- 기본배송비 :: END -->

		<!-- 추가배송비 설정부 :: START -->
		<tr class="add_tr">
			<td class="its-td nonpd center check_td">
				<label class="resp_checkbox"><input type="checkbox" class="used_check add_area_check" name="add_use" value="Y" onclick="use_check(this, 'add')"/> 추가</label>
			</td>
			<td class="its-td left">
				<!-- 금액 설정부 :: START -->
				<table class="table_basic wauto price_set_area" id="price_add" price_type="add">
				<thead>
				<tr>
					<th colspan="2">
						<select class="shipping_opt_type add_area" name="shipping_opt_type[add]" onchange="shipping_opt_type(this, []);">
							<option value="fixed" <?php if($TPL_VAR["params"]['shipping_opt_type']['add']=='fixed'){?>selected<?php }?>>고정</option>
							<option value="amount" <?php if($TPL_VAR["params"]['shipping_opt_type']['add']=='amount'){?>selected<?php }?>>금액(구간입력)</option>
							<option value="amount_rep" <?php if($TPL_VAR["params"]['shipping_opt_type']['add']=='amount_rep'){?>selected<?php }?>>금액(구간반복)</option>
							<option value="cnt" <?php if($TPL_VAR["params"]['shipping_opt_type']['add']=='cnt'){?>selected<?php }?>>수량(구간입력)</option>
							<option value="cnt_rep" <?php if($TPL_VAR["params"]['shipping_opt_type']['add']=='cnt_rep'){?>selected<?php }?>>수량(구간반복)</option>
							<option value="weight" <?php if($TPL_VAR["params"]['shipping_opt_type']['add']=='weight'){?>selected<?php }?>>무게(구간입력)</option>
							<option value="weight_rep" <?php if($TPL_VAR["params"]['shipping_opt_type']['add']=='weight_rep'){?>selected<?php }?>>무게(구간반복)</option>
						</select>
						<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/shipping_group', '#tip10', 'sizeR')"></span>
					</th>
					<th >
						<span class="zone_text zone_idx_0" idx="0" >
							<span class="add_btn_area issueCount" style="left:45px;top:0px;"><input type="hidden" class="issue" name="issue[add][]" value="0" /><span class="hgi-left"><span class="hgi-right"><span class="hgi-bg">!</span></span></span></span>
							<span class="add_zone hand blue" onclick="add_zone_pop(this);"><?php if($_GET["nation"]=='korea'){?>지역1<?php }else{?>국가1<?php }?></span><span class="zone_cnt blue">(0)</span>
						</span>
						<span class="zone_area_add_btn">
							<span class="ctrl-add-btn add-col add_btn_area"><button class="resp_btn active size_S ctrl-btn" type="button" onclick="add_price_section(this,'zone');">추가</button></span>
						</span>
						<div class="zone_address_area"></div>
					</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<th width="50px">
						<div class="section_area_add_btn hide">
							<span class="ctrl-add-btn add-row add_btn_area"><button class="resp_btn active size_S ctrl-btn" type="button" onclick="add_price_section(this,'section');">추가</button></span>
						</div>
					</th>
					<td class="section_area_td" >
						<div class="section_area_input hide">
							<input type="hidden" name="shipping_opt_seq[add][]" value=""> 
							<input type="text" name="section_st[add][]" value="0" class="section_st_input add_area wx90" readonly /> <span class="section_st_unit"></span>
							~
							<input type="text" name="section_ed[add][]" value="0" class="section_ed_input line add_area onlyfloat wx90" onclick="if($(this).val()==0) $(this).val('');" onblur="section_auto_chk(this);" /> <span class="section_ed_unit"></span>
						</div>
					</td>
					<td width="105px">
						<input type="hidden" name="shipping_cost_seq[add][]" value="0" /> 
						<input type="text" name="shipping_cost[add][]" value="0" class="line right shipping-cost-input add_area onlyfloat wx50" onclick="if($(this).val()==0) $(this).val('');" disabled /> <?php echo $TPL_VAR["punit"]?>

					</td>
				</tr>
				</tbody>
				<!-- 마지막행 :: START -->
				<tfoot>
				<tr class="last-tr-base hide">
					<th width="50px">
					</th>
					<td style="min-width:110px;">
						<div class="section_area_input hide">
							<input type="hidden" name="shipping_opt_seq[add][]" value=""> 
							<input type="text" name="section_st[add][]" value="0" class="section_st_input add_area wx90" readonly/> <span class="section_st_unit"></span>
							<span class="suffix hide">
								<input type="text" name="section_ed[add][]" value="0" class="section_ed_input line add_area onlyfloat wx90" onclick="if($(this).val()==0) $(this).val('');" onblur="section_auto_chk(this);" /> <span class="section_ed_unit"></span>
							</span>
						</div>
					</td>
					<td width="105px">
						<input type="hidden" name="shipping_cost_seq[add][]" value="0" /> 
						<input type="text" name="shipping_cost[add][]" value="0" class="line right shipping-cost-input add_area onlyfloat wx50" onclick="if($(this).val()==0) $(this).val('');" /> <?php echo $TPL_VAR["punit"]?>

					</td>
				</tr>
				</tfoot>
				<!-- 마지막행 :: END -->
				</table>
				<!-- 금액 설정부 :: END -->
			</td>
		</tr>
		<!-- 추가배송비 설정부 :: END -->

		<!-- 희망배송일 설정부 :: START -->
		<tr class="hop_tr">
			<td class="its-td nonpd center check_td">
				<label class="resp_checkbox"><input type="checkbox" class="used_check hop_area_check" name="hop_use" onclick="use_check(this, 'hop');" value="Y" />
				<div class="pdt5">희망<br/>배송일</div></label>
			</td>
			<td class="its-td left">
				<!-- 희망배송일 상세설정 :: START -->
				<div class="hopeday_setting_area">
					<table class="table_basic thl">
					<colgroup>
						<col width="18%" />
						<col width="82%" />
					</colgroup>
					<tr>
						<th class="its-th pdl10">희망배송일 선택</th>
						<td class="its-td">
							<div class="resp_radio">
								<label><input type="radio" class="hop_area" name="hopeday_required" value="N" <?php if($TPL_VAR["params"]["hopeday_required"]=='N'||!$TPL_VAR["params"]["hopeday_required"]){?>checked<?php }?> /> 선택사항</label>							
								<label><input type="radio" class="hop_area" name="hopeday_required" value="Y" <?php if($TPL_VAR["params"]["hopeday_required"]=='Y'){?>checked<?php }?>/> 필수사항</label>
							</div>
						</th>
					</tr>
					<tr>
						<th class="its-th pdl10">선택 가능 시작일</th>
						<td class="its-td">
							<div>
								<label class="resp_radio"><input type="radio" class="hop_area" name="hopeday_limit_set" value="time" <?php if($TPL_VAR["params"]["hopeday_limit_set"]=='time'||!$TPL_VAR["params"]["hopeday_limit_set"]){?>checked<?php }?> /> 주문 당일부터 선택 가능</label><br/>
								<span class="pdl20">
									단, 주문 당일은
									<select class="hop_area" name="hopeday_limit_val_time">
										<option value="1330" <?php if($TPL_VAR["params"]["hopeday_limit_set"]=='time'&&$TPL_VAR["params"]["hopeday_limit_val"]=='1330'){?>selected<?php }?>>13:30 이전</option>
										<option value="1200" <?php if($TPL_VAR["params"]["hopeday_limit_set"]=='time'&&$TPL_VAR["params"]["hopeday_limit_val"]=='1200'){?>selected<?php }?>>12:00 이전</option>
									</select>
									주문 시 당일배송 선택 가능
								</span>
							</div>
							<div class="pdt10">
								<label class="resp_radio"><input type="radio" class="hop_area" name="hopeday_limit_set" value="day" <?php if($TPL_VAR["params"]["hopeday_limit_set"]=='day'){?>checked<?php }?> /> 주문당일일</label>
								<span>
									+ <input type="text" class="hop_area" name="hopeday_limit_val_day" value="<?php if($TPL_VAR["params"]["hopeday_limit_set"]=='day'&&$TPL_VAR["params"]["hopeday_limit_val"]){?><?php echo $TPL_VAR["params"]["hopeday_limit_val"]?><?php }?>" /> 일째 되는 날 부터 선택 가능
								</span>
							</div>
						</th>
					</tr>
					<tr>
						<th class="its-th pdl10">특정요일 선택 불가</th>
						<td>
							<div class="resp_checkbox">
								<label><input type="checkbox" class="hop_area" name="hopeday_limit_week[]" value="1" <?php if($TPL_VAR["params"]['hopeday_limit_week_arr'][ 1]=='1'){?>checked<?php }?> /> Monday</label>							
								<label><input type="checkbox" class="hop_area" name="hopeday_limit_week[]" value="2" <?php if($TPL_VAR["params"]['hopeday_limit_week_arr'][ 2]=='1'){?>checked<?php }?> /> Tuesday</label>							
								<label><input type="checkbox" class="hop_area" name="hopeday_limit_week[]" value="3" <?php if($TPL_VAR["params"]['hopeday_limit_week_arr'][ 3]=='1'){?>checked<?php }?> /> Wednesday</label>							
								<label><input type="checkbox" class="hop_area" name="hopeday_limit_week[]" value="4" <?php if($TPL_VAR["params"]['hopeday_limit_week_arr'][ 4]=='1'){?>checked<?php }?> /> Thursday</label>							
								<label><input type="checkbox" class="hop_area" name="hopeday_limit_week[]" value="5" <?php if($TPL_VAR["params"]['hopeday_limit_week_arr'][ 5]=='1'){?>checked<?php }?> /> Friday</label>							
								<label><input type="checkbox" class="hop_area" name="hopeday_limit_week[]" value="6" <?php if($TPL_VAR["params"]['hopeday_limit_week_arr'][ 6]=='1'){?>checked<?php }?> /> Saturday</label>							
								<label><input type="checkbox" class="hop_area" name="hopeday_limit_week[]" value="0" <?php if($TPL_VAR["params"]['hopeday_limit_week_arr'][ 0]=='1'){?>checked<?php }?> /> Sunday</label>
							</div>							
						</th>
					</tr>
					<tr>
						<th class="its-th pdl10">선택 불가일</th>
						<td class="its-td nonpd clear">
							<table class="table_basic v3 hope_day_tb info-tb-inner" >
							<col width="18%" /><col width="82%" />
							<thead>
							<tr>
								<td >매년</td>
								<td style="border-bottom:1px solid #DADADA;">
									<input type="text" class="hop_area limit_day_input" name="hopeday_limit_repeat_day" value="<?php echo $TPL_VAR["params"]["hopeday_limit_repeat_day"]?>" style="width:90%;" />
									<input type="text" name="repeat_day_tmp" value="" onchange="set_hopeday(this);" class="datepicker hide" />
								</td>
							</tr>
							</thead>
							<tbody>
<?php if($TPL_VAR["params"]["hopeday_limit_day_arr"]){?>
<?php if(is_array($TPL_R1=$TPL_VAR["params"]["hopeday_limit_day_arr"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
							<tr>
								<td>
									<input type="text" name="hope_year[]" class="hop_area hope_year" value="<?php echo $TPL_K1?>" size="4" maxlength="4">년
<?php if($TPL_I1==(count($TPL_VAR["params"]["hopeday_limit_day_arr"])- 1)){?>
									<span class="hop_btn_area"><input type="button" onclick="hope_add(this);" class="btn_plus" /></span>
<?php }else{?>
									<span class="hop_btn_area"><input type="button" onclick="hope_del(this);" class="btn_minus"/></span>
<?php }?>
								</td>
								<td>
									<input type="text" class="hop_area limit_day_input" name="hopeday_limit_day[]" value="<?php echo $TPL_V1?>" style="width:90%;" />
									<input type="text" name="day_tmp[]" value="" onchange="set_hopeday(this);" class="datepicker hide" />
								</td>
							</tr>
<?php }}?>
<?php }else{?>
							<tr>
								<td>
									<input type="text" name="hope_year[]" class="hop_area hope_year" value="<?php echo date('Y')?>" size="4" maxlength="4">년
									<span class="hop_btn_area"><input type="button" onclick="hope_add(this);" class="btn_plus" /></span>
								</td>
								<td>
									<input type="text" class="hop_area limit_day_input" name="hopeday_limit_day[]" value="" style="width:90%;" />
									<input type="text" name="day_tmp[]" value="" onchange="set_hopeday(this);" class="datepicker hide" />
								</td>
							</tr>
<?php }?>
							</tbody>
							</table>
						</th>
					</tr>
					</table>
				</div>
				<!-- 희망배송일 상세설정 :: END -->

				<!-- 금액 설정부 :: START -->
				<div class="hop_shipping_area pdt20">
					<table class="table_basic wauto price_set_area" id="price_hop" price_type="hop">
					<thead>
					<tr>
						<th class="its-th center" colspan="2">
							<select class="shipping_opt_type hop_area" name="shipping_opt_type[hop]" onchange="shipping_opt_type(this, []);">
								<option value="free" <?php if($TPL_VAR["params"]['shipping_opt_type']['hop']=='free'){?>selected<?php }?>>무료</option>
								<option value="fixed" <?php if($TPL_VAR["params"]['shipping_opt_type']['hop']=='fixed'){?>selected<?php }?>>고정</option>
								<option value="amount" <?php if($TPL_VAR["params"]['shipping_opt_type']['hop']=='amount'){?>selected<?php }?>>금액(구간입력)</option>
								<option value="amount_rep" <?php if($TPL_VAR["params"]['shipping_opt_type']['hop']=='amount_rep'){?>selected<?php }?>>금액(구간반복)</option>
								<option value="cnt" <?php if($TPL_VAR["params"]['shipping_opt_type']['hop']=='cnt'){?>selected<?php }?>>수량(구간입력)</option>
								<option value="cnt_rep" <?php if($TPL_VAR["params"]['shipping_opt_type']['hop']=='cnt_rep'){?>selected<?php }?>>수량(구간반복)</option>
								<option value="weight" <?php if($TPL_VAR["params"]['shipping_opt_type']['hop']=='weight'){?>selected<?php }?>>무게(구간입력)</option>
								<option value="weight_rep" <?php if($TPL_VAR["params"]['shipping_opt_type']['hop']=='weight_rep'){?>selected<?php }?>>무게(구간반복)</option>
							</select>
							<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/shipping_group', '#tip10', 'sizeR')"></span>
						</th>
						<th class="its-th center">
							<span class="zone_text zone_idx_0" idx="0" >
								<span class="hop_btn_area issueCount" style="left:45px;top:0px;"><input type="hidden" class="issue" name="issue[hop][]" value="0" /><span class="hgi-left"><span class="hgi-right"><span class="hgi-bg">!</span></span></span></span>
								<span class="add_zone hand blue" onclick="add_zone_pop(this);"><?php if($_GET["nation"]=='korea'){?>지역1<?php }else{?>국가1<?php }?></span><span class="zone_cnt blue">(0)</span><span class="zone_today"> <br/>(<label class="resp_checkbox"><input type="checkbox" class="hop_area hop_today" name="shipping_today_yn[]" onclick="hop_today_use(this);" value="Y" /> 당일</label>)</span> 
								<span><input type="hidden" class="today_yn" name="today_yn[]" value="" /></span>
							</span>
							<span class="zone_area_add_btn">
								<span class="ctrl-add-btn add-col hop_btn_area"><button class="resp_btn active size_S ctrl-btn" type="button" onclick="add_price_section(this,'zone');">추가</button></span>
							</span>
							<div class="zone_address_area"></div>
						</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<th class="its-th center" width="50px">
							<div class="section_area_add_btn hide">
								<span class="ctrl-add-btn add-row hop_btn_area"><button class="resp_btn active size_S ctrl-btn" type="button" onclick="add_price_section(this,'section');">추가</button></span>
							</div>
						</th>
						<td class="its-td section_area_td" style="min-width:110px;">
							<input type="hidden" name="shipping_opt_seq[hop][]" value=""> 
							<div class="section_area_input hide">
								<input type="text" name="section_st[hop][]" value="0" class="section_st_input hop_area wx90" readonly /> <span class="section_st_unit"></span>
								~
								<input type="text" name="section_ed[hop][]" value="0" class="section_ed_input line hop_area onlyfloat wx90" onclick="if($(this).val()==0) $(this).val('');" onblur="section_auto_chk(this);" /> <span class="section_ed_unit"></span>
							</div>
						</td>
						<td class="its-td right pdr10" width="135px">
							<input type="hidden" name="shipping_cost_seq[hop][]" value="0" /> 
							<input type="text" name="shipping_cost[hop][]" value="0" class="line right shipping-cost-input hop_area onlyfloat wx50" onclick="if($(this).val()==0) $(this).val('');" disabled /> <?php echo $TPL_VAR["punit"]?>

							<br/>
							당일
							<input type="text" name="shipping_cost_today[hop][]" value="0" class="line right shipping-cost-today hop_area onlyfloat today_idx_0 wx50"  onclick="if($(this).val()==0) $(this).val('');" disabled /> <?php echo $TPL_VAR["punit"]?>

						</td>
					</tr>
					</tbody>
					<!-- 마지막행 :: START -->
					<tfoot>
					<tr class="last-tr-base hide">
						<th class="its-th center" width="50px">
						</th>
						<td class="its-td" style="min-width:110px;">
							<div class="section_area_input hide">
								<input type="hidden" name="shipping_opt_seq[hop][]" value=""> 
								<input type="text" name="section_st[hop][]" value="0" class="section_st_input hop_area wx90" readonly/> <span class="section_st_unit"></span>
								<span class="suffix hide">
									<input type="text" name="section_ed[hop][]" value="0" class="section_ed_input line hop_area onlyfloat wx90" onclick="if($(this).val()==0) $(this).val('');" onblur="section_auto_chk(this);" /> <span class="section_ed_unit"></span>
								</span>
							</div>
						</td>
						<td class="its-td right pdr10" width="135px">
							<input type="hidden" name="shipping_cost_seq[hop][]" value="0" /> 
							<input type="text" name="shipping_cost[hop][]" value="0" class="line right shipping-cost-input hop_area onlyfloat today_idx_0 wx50" onclick="if($(this).val()==0) $(this).val('');" /> <?php echo $TPL_VAR["punit"]?>

							<br/>
							당일
							<input type="text" name="shipping_cost_today[hop][]" value="0" class="line right shipping-cost-today hop_area onlyfloat today_idx_0 today_idx_0 wx50" onclick="if($(this).val()==0) $(this).val('');" disabled /> <?php echo $TPL_VAR["punit"]?>

						</td>
					</tr>
					</tfoot>
					<!-- 마지막행 :: END -->
					</table>
				</div>
				<!-- 금액 설정부 :: END -->
			</td>
		</tr>
		<!-- 희망배송일 설정부 :: END -->

		<!-- 수령매장 설정부 :: START -->
		<tr class="store_tr">
			<td class="its-td nonpd center check_td">
				<label class="resp_checkbox"><input type="checkbox" class="used_check store_area_check" name="store_use" onclick="return false;" value="Y" /><br/>
				<div class="pdt5">수령<br/>매장</div></label>
			</td>
			<td class="its-td left">
				<!-- 수령매장 :: START -->
				<div class="direct_set_area">
					<span class="btn small white store_btn_area"><button type="button" onclick="shipping_address_pop('address');">설정</button></span>
				</div>
				<div class="direct_store_area pdt5">
					<!-- 매장 설정부 :: START -->
					<table class="table_basic store_tb" >
					<colgroup>
						<col width="80px" />
						<col width="50px" />
						<col width="100px" />
						<col />
						<col width="150px" />
						<col width="170px" />
						<col width="80px" />
					</colgroup>
					<thead>
					<tr>
						<th>분류</th>
						<th>해외</th>
						<th>매장명</th>
						<th>주소</th>
						<th>전화번호</th>
						<th>재고 창고 연동</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
<?php if($TPL_VAR["params"]["store_list_arr"]){?>
<?php if(is_array($TPL_R1=$TPL_VAR["params"]["store_list_arr"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<tr>
						<td>
							<input name="shipping_address_seq[]" class="shipping_address_input" type="hidden" value="<?php echo $TPL_V1["shipping_address_seq"]?>" />
							<input name="shipping_address_category[]" type="hidden" value="<?php echo $TPL_V1["shipping_address_category"]?>" />
							<?php echo $TPL_V1["shipping_address_category"]?>

						</td>
						<td>
							<input name="shipping_address_nation[]" type="hidden" value="<?php echo $TPL_V1["shipping_address_nation"]?>" />
							<?php echo $TPL_V1["shipping_address_nation"]?>

						</td>
						<td>
							<input name="shipping_store_name[]" type="hidden" value="<?php echo $TPL_V1["shipping_store_name"]?>" />
							<?php echo $TPL_V1["shipping_store_name"]?>

						</td>
						<td>
							<input name="shipping_address_full[]" type="hidden" value="<?php echo $TPL_V1["shipping_address_full"]?>" />
							<?php echo $TPL_V1["shipping_address_full"]?>

						</td>
						<td>
							<input name="store_phone[]" type="hidden" value="<?php echo $TPL_V1["store_phone"]?>" />
							<?php echo $TPL_V1["store_phone"]?>

						</td>
						<td>
<?php if($TPL_V1["store_supply_set"]=='Y'){?>
								재고수량 :
<?php if($TPL_V1["store_supply_set_view"]=='Y'){?>
								노출
<?php }else{?>
								미노출
<?php }?>
								<br/>
								재고선택 :
<?php if($TPL_V1["store_supply_set_order"]=='Y'){?>
								재고 > 0
<?php }else{?>
								재고 = 0
<?php }?>
<?php }else{?>
							재고 창고와 미연동
<?php }?>
							<input name="store_supply_set[]" type="hidden" value="<?php echo $TPL_V1["store_supply_set"]?>" />
							<input name="store_supply_set_view[]" type="hidden" value="<?php echo $TPL_V1["store_supply_set_view"]?>" />
							<input name="store_supply_set_order[]" type="hidden" value="<?php echo $TPL_V1["store_supply_set_order"]?>" />
						</td>
						<td class="its-td">
							<input name="store_scm_type[]" type="hidden" value="<?php echo $TPL_V1["store_scm_type"]?>" />
							<span class="btn small red store_btn_area"><input onclick="del_address(this);" type="button" value="삭제"></span>
						</td>
					</tr>
<?php }}?>
<?php }else{?>
					<tr base_tr="Y">
						<td colspan="7" class="its-td center">설정된 매장이 없습니다.</td>
					</tr>
<?php }?>
					</tbody>
					</table>
					<!-- 매장 설정부 :: END -->
				</div>
				<!-- 수령매장 :: END -->
			</td>
		</tr>
		<!-- 수령매장 설정부 :: END -->

		<!-- 반품배송비 설정부 :: START -->
		<tr class="refund_tr">
			<td class="its-td" rowspan="2">반품</br/>배송비</td>
			<td class="its-td nonpd center check_td">반품</td>
			<td class="its-td left">
				편도 : <input type="text" name="refund_shiping_cost" id="refund_shiping_cost" class="line right shipping-cost-input onlyfloat wx50" value="<?php echo $TPL_VAR["params"]["refund_shiping_cost"]?>" /> <?php echo $TPL_VAR["punit"]?>

				( <label class="resp_checkbox"><input type="checkbox" name="shiping_free_yn" value="Y" <?php if($TPL_VAR["params"]["shiping_free_yn"]=='Y'){?>checked<?php }?>/> 배송비가 무료인 경우, 반품배송비 왕복 <span class="refund_shiping_double"><?php echo ($TPL_VAR["params"]["refund_shiping_cost"]* 2)?></span> <?php echo $TPL_VAR["punit"]?> 받음</label> )
			</td>
		</tr>
		<tr class="refund_tr">
			<td class="its-td nonpd center check_td">(맞)교환</td>
			<td class="its-td left">
				왕복 : <input type="text" name="swap_shiping_cost" class="line right shipping-cost-input onlyfloat wx50" value="<?php echo $TPL_VAR["params"]["swap_shiping_cost"]?>" /> <?php echo $TPL_VAR["punit"]?>

			</td>
		</tr>
		<!-- 반품배송비 설정부 :: END -->

		</table>
	</div>
	<!-- 배송 설정 :: END -->

	<!-- 배송안내 :: START -->
	<div class="ship_desc pd10">
		<div class="pdb10">
			배송안내 <input type="button" id="btn_autoinfo_desc" class="resp_btn" value="자동안내 설명" />
		</div>

		<table class="table_basic thl">		
		<tr>
			<th class="its-th pdl10">기본 배송비</th>
			<td class="its-td">
				<div class="resp_radio">
					<label><input type="radio" name="delivery_std_type" class="std_area" value="Y" checked /> 자동안내</label>				
					<label><input type="radio" name="delivery_std_type" class="std_area" value="N" /> 직접입력</label>
				</div>
				<input type="text" name="delivery_std_input" class="std_area" value="<?php echo $TPL_VAR["params"]["delivery_std_input"]?>" style="width:500px;" />				
			</td>
		</tr>
		<tr>
			<th class="its-th pdl10">추가 배송비</th>
			<td class="its-td">
				<div class="resp_radio">
					<label><input type="radio" name="delivery_add_type" class="add_area" value="Y" checked /> 자동안내</label>				
					<label><input type="radio" name="delivery_add_type" class="add_area" value="N" /> 직접입력</label>
				</div>
				<input type="text" name="delivery_add_input" class="add_area" value="<?php echo $TPL_VAR["params"]["delivery_add_input"]?>" style="width:500px;" />
			</td>
		</tr>
		<tr>
			<th class="its-th pdl10">희망배송일</th>
			<td class="its-td">
				<div class="resp_radio">
					<label><input type="radio" name="delivery_hop_type" class="hop_area" value="Y" checked /> 자동안내</label>				
					<label><input type="radio" name="delivery_hop_type" class="hop_area" value="N" /> 직접입력</label>
				</div>
				<input type="text" name="delivery_hop_input" class="hop_area" value="<?php echo $TPL_VAR["params"]["delivery_hop_input"]?>" style="width:500px;" />
			</td>
		</tr>
		<tr>
			<th class="its-th pdl10">수령매장</th>
			<td class="its-td">
				<div class="resp_radio">
					<label><input type="radio" name="delivery_store_type" class="store_area" value="Y" checked /> 자동안내</label>				
					<label><input type="radio" name="delivery_store_type" class="store_area" value="N" /> 직접입력</label>
				</div>
				<input type="text" name="delivery_store_input" class="store_area" value="<?php echo $TPL_VAR["params"]["delivery_store_input"]?>" style="width:500px;" />
			</td>
		</tr>
		</table>
	</div>
	<br/>
	<br/>
</div>
<!-- 배송안내 :: END -->

<!-- ##### 최종 적용 버튼 :: START ##### -->
<div class="footer">
	<button type="button" class="resp_btn active size_XL" onclick="submit_shipping_item();">저장</button>
	<button type="button" class="resp_btn v3 size_XL" onclick="window.close();">취소</button>
</div>
<!-- ##### 최종 적용 버튼 :: END ##### -->

</div>

<!-- 자동안내 설명 :: START -->
<div id="autoinfoPopup" class="hide">
<?php $this->print_("delivery_desc",$TPL_SCP,1);?>

</div>
<!-- 자동안내 설명 :: END -->

<!-- 장소리스트 팝업 :: START -->
<div id="shipping_address_pop_area" class="hide">
</div>
<!-- 장소리스트 팝업 :: END -->

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>