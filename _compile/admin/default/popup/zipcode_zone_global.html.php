<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/popup/zipcode_zone_global.html 000018556 */ ?>
<script type="text/javascript">
var old_idx		= '<?php echo $_GET["idx"]?>';		// 클릭지역
var get_idx		= '<?php echo $_GET["idx"]?>';		// 선택지역
var get_p_type	= '<?php echo $_GET["p_type"]?>';	// 배송설정타입
var get_nation	= '<?php echo $_GET["nation"]?>';	// 배송국가타입
var limitType	= 'all';

// 하위 주소 검색
function getchildAddress(address_type){

	var url = '../popup/zipcode_zone_ajax';
	var params = {'address_type':address_type,'nation':'<?php echo $_GET["nation"]?>','limitType':limitType};

	// 국가명 기준
	if(address_type == 'nation_name'){
		$.getJSON(url, params, function(data){
			for(var i=0;i<data.length;i++){
				var disable_status	= false;
				var disable_tag		= 'on';
				var diff_str = data[i].nation_name;
				disable_status	= chk_disable_address_option(diff_str, 'all');
				if	(disable_status){
					disable_tag	= 'off';
				}

				var otpHtml = '<tr class="'+disable_tag+' hand" onclick="sel_country(this);">';
				otpHtml += '	<td class="its-td wid1" value="'+data[i].nation_name+'">'+data[i].nation_name+'</td>';
				otpHtml += '	<td class="its-td wid2 center">'+data[i].nation_ems+'</td>';
				otpHtml += '	<td class="its-td wid3 center">'+data[i].nation_ems_premium+'</td>';
				otpHtml += '</tr>';
				$("."+address_type).append(otpHtml);
			}
		});
	// EMS 기준
	}else{
		$("select[name='EMS_COUNTRY']").empty().data('options');

		var EMS_TYPE	= $("select[name='EMS_TYPE'] option:selected").val();
		var EMS_AREA	= $("select[name='EMS_AREA'] option:selected").val();
		if(EMS_TYPE)	params.EMS_TYPE = EMS_TYPE;
		if(EMS_AREA)	params.EMS_AREA = EMS_AREA;

		$("select[name='"+address_type+"']").empty();

		$.getJSON(url, params, function(data){
			for(var i=0;i<data.length;i++){
				disable_status	= '';

				if(address_type == 'EMS_AREA'){
					var result_val = eval("data[i]."+EMS_TYPE);
				}else if(address_type == 'EMS_COUNTRY'){
					var result_val = data[i].nation_name;

					if(chk_disable_address_option(result_val, 'match')){
						disable_status = 'disabled="disabled"';
					}
				}

				var resultHtml = '<option value="'+result_val+'" '+disable_status+' >' + result_val + '</option>';
				$("select[name='"+address_type+"']").append(resultHtml);
			}
		});
	}
}

//국가명 선택
function sel_country(obj){
	if($(obj).hasClass('on')){
		if($(obj).hasClass('selectCountry')){
			$(obj).removeClass('selectCountry');
		}else{
			$(obj).addClass('selectCountry');
		}
	}
}

// 이미 선택된 값 체크
function chk_disable_address_option(srcAddress, type){
	var returnVal	= false;
	$('.sel_address_txt_<?php echo $_GET["p_type"]?>').each(function(){
		if	(type == 'all'){
			if	($(this).val() == srcAddress){
				returnVal	= true;
				return true;
			}
		}else{
			var target_cnt = srcAddress.length;
			if	($(this).val().substring(0,target_cnt) == srcAddress){
				returnVal	= true;
				return true;
			}
		}
	});

	return returnVal;
}

// 선택 버튼 - 선택된 내용 조합
function select_address(){
	var area_select = $("input[name='area_select']:checked").val();
	// 추가할 국가명이 있을 경우 기본값 삭제
	if($("#select_address_tb").find("tbody > tr").attr('base_tr') == 'Y'){
		$("#select_address_tb").find("tbody > tr").remove();
	}

	// 국가명 기준 선택 상태
	if(area_select == 'name'){
		if($('.selectCountry').length > 0){
			// 선택 된 국가명을 차례로 추가
			$('.selectCountry').each(function(){
				var selectNation = [$(this).find('.wid1').text()];
				add_address(selectNation, area_select);
				$(this).addClass('off').removeClass('on').removeClass('selectCountry').unbind('click');
			});
		}else{
			alert('먼저 지역을 선택해주세요.');
			return false;
		}
	}
	// EMS 기준 선택 상태
	else if(area_select == 'ems'){
		var EMS_COUNTRY		= $('select[name="EMS_COUNTRY"]').val();
		if(EMS_COUNTRY != undefined && EMS_COUNTRY != 'undefined'){
			$(EMS_COUNTRY).each(function(idx, item){
				var selectNation = [item];
				add_address(selectNation, 'add');
			});
		}else{
			alert('먼저 지역을 선택해주세요.');
			return false;
		}

	}
}

// 비활성화 처리 (나라명으로 비교)
function setDisableList(val){
	$('.info-table-style2 .wid1[value="'+val+'"]').parent().addClass('off').removeClass('on').removeClass('selectCountry').unbind('click');
	$("select[name='EMS_COUNTRY']").children("[value='"+val+"']").attr('disabled', true);
}

// 선택된 지역 테이블 추가
function add_address(sel_address, add_type){
	var sel_idx				= sel_address.length - 1;
	var sel_address_txt		= sel_address[sel_idx];
	var sel_address_zibun	= sel_address[sel_idx];
	var sel_address_street	= sel_address[sel_idx];
	var sel_address_join	= sel_address.join('||');

	if(add_type == 'all' || add_type == 'add'){
		if(chk_disable_address_option(sel_address_txt, 'match')){
			default_tr();
			alert('이미 선택 된 국가입니다.');
			return false;
		}else{
			setDisableList(sel_address_txt);
		}
	}else if(add_type == 'set'){
		var area_select = $("input[name='area_select']:checked").val();
		setDisableList(sel_address_txt);
	}

	var input_hide1	= '<input type="hidden" class="sel_address_street_<?php echo $_GET["p_type"]?>" name="sel_address_street[<?php echo $_GET["p_type"]?>]['+get_idx+'][]" value="'+sel_address_street+'" />';
	var input_hide2	= '<input type="hidden" class="sel_address_zibun_<?php echo $_GET["p_type"]?>" name="sel_address_zibun[<?php echo $_GET["p_type"]?>]['+get_idx+'][]" value="'+sel_address_zibun+'" />';
	var input_hide3	= '<input type="hidden" class="sel_address_join_<?php echo $_GET["p_type"]?>" name="sel_address_join[<?php echo $_GET["p_type"]?>]['+get_idx+'][]" value="'+sel_address_join+'" />';
	var input_hide4	= '<input type="hidden" class="sel_address_txt_<?php echo $_GET["p_type"]?>" name="sel_address_txt[<?php echo $_GET["p_type"]?>]['+get_idx+'][]" value="'+sel_address_txt+'" />';
	var td_html		= '<tr><td class="its-td"><span class="btn-minus"><button class="etcDel" onclick="del_address(this);" type="button"></button></span>&nbsp;&nbsp;&nbsp;' + sel_address_txt + '<span class="hide_input">' + input_hide1 + input_hide2 + input_hide3 + input_hide4 + '</span></td></tr>';
	$("#select_address_tb").append(td_html);
}

// 선택된 지역 삭제
function del_address(obj){
	default_tr();
	if($("#select_address_tb").find("tbody > tr").index() == 0){
		$("#select_address_tb").append('<tr base_tr="Y" ><td class="its-td center">선택하세요</td></tr>');
	}

	var delVal = $(obj).closest('td.its-td').find('.sel_address_txt_std').val();

	$('input[type="hidden"][value="'+delVal+'"]').remove();
	$(obj).closest('tr').remove();
}

// 기본TR 설정
function default_tr(){
	if(!$("#select_address_tb").find("tbody > tr").html()){
		$("#select_address_tb").append('<tr base_tr="Y" ><td class="its-td center">선택하세요</td></tr>');
	}
}

// 부모창의 지역 설정 가져오기
function get_parent_zone(p_idx){
	if(p_idx) get_idx = p_idx;

	$("select[name='zone_select_box']").empty().data('options'); // 지역선택박스 초기화
	$("#select_address_tb").find("tbody").html(''); // 지역선택박스 초기화

	$("#price_"+get_p_type).find(".add_zone",parent.document).each(function(obj){
		var idx = $(this).closest(".zone_text").attr('idx');
		var txt = $(this).text();
		var chk = '';

		// 설정된 상세 지역 가져오기
		if(get_idx == idx){
			chk = 'selected';
			$("input[name='zone_select_box_name']").val(txt);

			if($("#select_address_tb").find("tbody > tr").attr('base_tr') == 'Y'){
				$("#select_address_tb").find("tbody > tr").remove();
			}

			var old_address = '';
			var sel_address = '';

			$("#price_"+get_p_type, parent.document).find("thead > tr").find(".zone_idx_"+get_idx).closest("th").find(".zone_address_area input.sel_address_join_"+get_p_type).each(function(num){
				old_address = $(this).val();
				sel_address = old_address.split("||");
				add_address(sel_address,'set');
			});

			default_tr();
		}

		// 설정된 지역 가져오기
		var otpHtml = "<option value=\""+idx+"\" "+chk+">"+txt+"</option>";
		$("select[name='zone_select_box']").append(otpHtml);
	});
}

// ### 최종 적용 ### //
/*
	1. 기본, 추가, 희망배송 구분값 필요.
	2. 부모창 1번 구분값 하단 해당 지역 하단에 넣는다.
	3. 지역명변경 필요.
*/
function submit_zone(){

	var set_z_name	= $("input[name='zone_select_box_name']").val().trim();
	var set_add_cnt = $("#select_address_tb").find(".sel_address_txt_<?php echo $_GET["p_type"]?>").length;

	if(set_z_name == ''){
		openDialogAlert('선택한 국가의 타이틀을 입력해 주세요.',350,150,function(){});
		return false;
	}

	// 기본 tr 지우기
	if($("#select_address_tb").find("tbody > tr").attr('base_tr') == 'Y'){
		$("#select_address_tb").find("tbody > tr").remove();
	}

	// 선택된정보 리스트 조합
	var inputList	= '';
	$("#select_address_tb").find("tbody > tr").each(function(){
		inputList += $(this).find('span.hide_input').html();
	});

	// ## 부모창 정보 컨트롤 ## //

	// 부모창 지역 정보 지우기
	$("#price_"+get_p_type, parent.document).find("thead > tr").find(".zone_idx_"+get_idx).closest("th").find(".zone_address_area").html('');

	// 지역명 변경
	var zone_html = set_z_name + '<input type="hidden" name="shipping_area_name[<?php echo $_GET["p_type"]?>]['+get_idx+']" value="'+set_z_name+'" />';
	$("#price_"+get_p_type, parent.document).find("thead > tr").find(".zone_idx_"+get_idx).closest("th").find(".add_zone").html(zone_html);

	// 카운트 추가
	$("#price_"+get_p_type, parent.document).find("thead > tr").find(".zone_idx_"+get_idx).closest("th").find(".zone_cnt").html('('+set_add_cnt+')');

	// 카운트에 따른 경고창 컨트롤
	if(set_add_cnt > 0){
		$("#price_"+get_p_type, parent.document).find("thead > tr").find(".zone_idx_"+get_idx).closest("th").find(".issueCount").hide();
		$("#price_"+get_p_type, parent.document).find("thead > tr").find(".zone_idx_"+get_idx).closest("th").find(".issue").val('1');
	}else{
		$("#price_"+get_p_type, parent.document).find("thead > tr").find(".zone_idx_"+get_idx).closest("th").find(".issueCount").show();
		$("#price_"+get_p_type, parent.document).find("thead > tr").find(".zone_idx_"+get_idx).closest("th").find(".issue").val('0');
	}

	// 지역 추가
	if(inputList){
		$("#price_"+get_p_type, parent.document).find("thead > tr").find(".zone_idx_"+get_idx).closest("th").find(".zone_address_area").html(inputList);
	}
	
	insert_address();
	
	// 창 닫기
	closeDialog(get_nation+'_'+old_idx);
}

function insert_address() {
	var shipping_cost_seq	= $("input[name='shipping_cost_seq']").val();
	var shipping_group_seq	= $("input[name='shipping_group_seq").val();
	var shipping_set_seq	= $("input[name='shipping_set_seq").val();
	var nation				= get_nation;
	var zone_name			= $("input[name='zone_select_box_name").val();
	var shipping_opt_type	= $("select[name='shipping_opt_type["+get_p_type+"]']").val();
	
	var shipping_opt_sec_cost	= new Array();
	var costIdx					= parseInt(get_idx);
	var areaLength				= $("input[name='shipping_cost["+get_p_type+"][]']").length;
	var secLength				= $("input[name='section_st["+get_p_type+"][]']").length;
	var areaTerm				= parseInt(areaLength)/parseInt(secLength);
	
	var costTotal = 0;
	$("input[name='shipping_cost["+get_p_type+"][]']").each(function(index, val) {
		if(index == costIdx){
			shipping_opt_sec_cost.push($(this).val());
			costIdx = costIdx + areaTerm; 
			
			costTotal += parseInt($(this).val());
		}
	});
	
	if(costTotal <= 0 && shipping_opt_type != 'free'){
		alert("지역 배송비가 모두 0 입니다. 배송비를 입력 해 주세요.");
		return false;
	}
	
	var shipping_opt_sec_st = new Array();
	$("input[name='section_st["+get_p_type+"][]']").each(function(index, val) {
		shipping_opt_sec_st.push($(this).val());
	});
	var shipping_opt_sec_ed = new Array();
	$("input[name='section_ed["+get_p_type+"][]']").each(function(index, val) {
		shipping_opt_sec_ed.push($(this).val());
	});
	
	$.ajax({
		'url' : '../setting/shipping_zone_insert',
		'data' : { 'shipping_cost_seq': shipping_cost_seq, 'shipping_group_seq': shipping_group_seq, 'nation': nation, 'idx': get_idx, 'p_type': get_p_type, 'shipping_set_seq': shipping_set_seq, 'zone_name': zone_name, 'shipping_opt_type': shipping_opt_type, 'shipping_opt_sec_cost': shipping_opt_sec_cost, 'shipping_opt_sec_st': shipping_opt_sec_st, 'shipping_opt_sec_ed': shipping_opt_sec_ed },
		'dataType' : 'json', //'json'
		'success' : function(res) {
			if (res == 'ERROR') {
				alert('등록 에러. 재시도 해보세요.');
				return false;
			} else if (res == 'duplicate') {
				alert('이미 등록된 지역입니다.');
				return false;
			} else {
				var costIdx = parseInt(get_idx);
				var i = 0;
				$("input[name='shipping_cost_seq["+get_p_type+"][]']'").each(function(index) {
					if(index == costIdx){
						$(this).val(res.shipping_costs_seqs[i]);
						costIdx = costIdx + areaTerm; 
						i++;
					}
				});
			}
		}
	});
}

$(document).ready(function() {

	// 기본 국가명 기준 불러오기
	getchildAddress('nation_name');

	// 부모창 설정 지역 및 설정된 상세지역 가져오기
	get_parent_zone();

	// EMS 타입 선택시
	$(".address_select").bind("change",function(){
		var address_type = $(this).attr('address_type');
		getchildAddress(address_type);
	});

	// 지역 변경시 선택정보 초기화 및 행위
	$(".zone_select_box").bind("change", function(){
		if(confirm('변경 시 적용되지 않은 데이터가 초기화 됩니다.\n변경하시겠습니까?') == true){
			// 해당지역의 설정 지역 가져오기
			get_parent_zone($(this).val());
		}else{
			$(this).val(get_idx);
		}
	});

	// 기준 선택 변경 시 (국가명, EMS)
	$("input[name='area_select']").bind("change", function(){
		var tabId = $(this).val();

		// 각 탭 별 데이터 새로 가져오기
		if(tabId == 'name'){			// 국가명 기준
			$('.info-table-style2 tr').removeClass('selectCountry');
		}else if(tabId == 'ems'){	// EMS 기준
			$("select[name='EMS_TYPE'] option").attr('selected', false);
			$("select[name='EMS_AREA'] option").remove();
			$("select[name='EMS_COUNTRY'] option").remove();

		}

		// 해당 탭 노출
		limitType = tabId;
		$('.tabBody').addClass('hide');
		$('.tabBody[tabid="'+tabId+'"]').removeClass('hide');
	});
});

</script>
<style type="text/css">
.info-table-style2 { border:1px solid #dadada; }
.info-table-style2 .its-td { line-height:180%;letter-spacing:0px; }
.info-table-style2 tr.off { color: #dadada; }
.info-table-style2 tr.on:hover { background: #dadada; }
.info-table-style2 tr.selectCountry { background: #82D0FB; }
.wid1 { width:518px; padding-left: 5px; }
.wid2 { width:170px; border-left:1px solid #dadada; }
.wid3 { width:155px; border-left:1px solid #dadada; }
.sel-contry {}
</style>
<table id="wrap" width="100%" height="500px" cellspacing="0" cellpadding="20">
<tr>
	<td valign="top" style="height:350px;">
		<ul class="tabs">
			<label><input type="radio" name="area_select" value="name" checked /> 국가명 기준</label>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><input type="radio" name="area_select" value="ems" /> EMS 기준</label>
		</ul>
		<!-- 국가명 기준용 -->
		<div class="tabBody pdt10" tabid="name">
			<table class="info-table-style" cellspacing="0" cellpadding="0" width="856px">
			<tr>
				<th class="its-th center" style="width:516px;">국가명</th>
				<th class="its-th center" style="width:170px;">EMS</th>
				<th class="its-th center" style="width:170px;">EMS프리미엄</th>
			</tr>
			</table>
			<table class="info-table-style2 nation_name" cellspacing="0" cellpadding="0" style="overflow-y:scroll;height:300px;display:block;width:856px;">
			</table>
		</div>


		<!-- EMS 기준용 -->
		<div class="tabBody pdt10 hide" tabid="ems">
			<!-- EMS TYPE 선택 :: START -->
			<div style="padding-right:15px;float:left;">
				<select name="EMS_TYPE" class="address_select" address_type="EMS_AREA" style="border: 1px solid #cccccc; width:150px;" size="22">
					<option value="nation_ems">EMS</option>
					<option value="nation_ems_premium">프리미엄 EMS</option>
				</select>
			</div>
			<!-- EMS TYPE 선택 :: END -->

			<!-- EMS 지역 선택 :: START -->
			<div style="padding-right:15px;float:left;">
				<select name="EMS_AREA" class="address_select" address_type="EMS_COUNTRY" style="border: 1px solid #cccccc; width:180px;" size="22">
				</select>
			</div>
			<!-- EMS 지역 선택 :: END -->

			<!-- 국가 선택 :: START -->
			<div style="padding-right:15px;float:left;">
				<select name="EMS_COUNTRY" style="border: 1px solid #cccccc; width: 460px;" size="22" multiple>
				</select>
			</div>
			<!-- 국가 선택 :: END -->
		</div>
	</td>
</tr>
<tr>
	<td class="center" style="height:50px;">
		<span class="btn large white"><button type="button" onclick="select_address();" >선택</button></span>
	</td>
</tr>

<!-- 선택목록 :: START -->
<tr>
	<td>
		<div class="pdb10">
			<select name="zone_select_box" class="zone_select_box">
			</select>
			<input type="text" name="zone_select_box_name" title="지역명" value="" />
		</div>
		<div>
			<table id="select_address_tb" class="info-table-style" cellspacing="0" cellpadding="0" width="100%">
			<thead>
			<tr>
				<th class="its-th center">
<?php if($_GET["nation"]=='korea'){?>
					대한민국
<?php }else{?>
					해외국가
<?php }?>
				</th>
			</tr>
			</thead>
			<tbody>
			<tr base_tr="Y" >
				<td class="its-td center">선택하세요</td>
			</tr>
			</tbody>
			</table>
		</div>
	</td>
</tr>
<!-- 선택목록 :: END -->

<!-- 최종적용 :: START -->
<tr>
	<td class="center pd20">
		<span class="btn large cyanblue"><button type="button" onclick="submit_zone();">&nbsp;&nbsp;&nbsp;적용&nbsp;&nbsp;&nbsp;</button></span>
	</td>
</tr>
<!-- 최종적용 :: END -->
</table>