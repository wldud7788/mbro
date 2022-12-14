<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/popup/shipping_address_pop.html 000014395 */ ?>
<style type="text/css">
/* 장소리스트 CSS */
.ctab {border-top:1px solid #d6d6d6;border-right:1px solid #d6d6d6;border-bottom:1px solid #d6d6d6;width:100px;line-height:30px;text-align:center;background-color:#eeeeee;float:left;font-size:12px;font-family:Dotum;font-weight:bold;color:#757575;}
.ctab-on {border-top:1px solid #d6d6d6;border-bottom:1px solid #ffffff;border-right:1px solid #d6d6d6;width:100px;line-height:30px;text-align:center;background-color:#ffffff;float:left;font-size:12px;font-family:Dotum;font-weight:bold;color:#000000;}
</style>

<script type="text/javascript">
var present_gb = '';
var _shipping_address_seqs = '<?php echo $TPL_VAR["shipping_address_seqs"]?>';
// 장소리스트 탭이동
function formMoveSub(gb, no){

	$(".tab_01 li a").removeClass("current");
	$(".tab_01 li").eq(no-1).find("a").addClass("current");

	$("#tab_type").val(gb);
	present_gb = gb;

	if(gb == 'input')	$(".insertAdress").show();
	else				$(".insertAdress").hide();
	// 리스트 호출
	list_table_create();
}

// 페이징 스크립트
function searchPaging(param){
	list_table_create(param);
}

// 검색
function src_list(){
	var category = $("#src_address_category").val();
	var address_nation = $("#src_address_nation").val();
	var address_name = $("#src_address_name").val();

	var param = "address_category="+category+"&address_nation="+address_nation+"&address_name="+address_name;
	list_table_create(param);
}

// 장소리스트 테이블
function list_table_create(param){
	var tabType = $("#tab_type").val();
	var url = "/selleradmin/popup/shipping_address_list";
	var params = {'tabType':tabType, 'shipping_address_seqs': _shipping_address_seqs};
	if(param)	params.src = param;

	$.get(url, params, function(data) {
		$('#shipping_address_contants_list').html(data);
	});
}

// 장소 입력 등록
function insert_address_pop(type){
	if	(type != 'add'){
		$.ajax({
			'url'		: '../setting_process/get_shipping_address_ajax',
			'type'		: 'POST',
			'dataType'	: 'json',
			'data'		: { 'seq' : type },
			'success'	: function(res){
				if(res.shipping_address_seq)
					$("input[name='shipping_address_seq']").val(res.shipping_address_seq);
				if(res.address_provider_seq)
					$("input[name='address_provider_seq']").val(res.address_provider_seq);
				if(res.address_category){
					$("#address_category").val(res.address_category).trigger('change');
					$("#address_category_direct").attr('disabled',true);
				}
				if(res.address_name)
					$("input[name='address_name']").val(res.address_name);
				if(res.address_zipcode)
					$("input[name='zoneZipcode[]']").val(res.address_zipcode);
				if(res.address_nation)
					$("select[name='address_nation']").val(res.address_nation).trigger('change');
				if(res.address_type)
					$("input[name='zoneAddress_type']").val(res.address_type);
				if(res.address)
					$("input[name='zoneAddress']").val(res.address);
				if(res.address_street)
					$("input[name='zoneAddress_street']").val(res.address_street);
				if(res.address_detail)
					$("input[name='zoneAddressDetail']").val(res.address_detail);

				if(res.address_type == 'street'){
					$("input[name='zoneAddress']").hide();
					$("input[name='zoneAddress_street']").show();
				}else{
					$("input[name='zoneAddress']").show();
					$("input[name='zoneAddress_street']").hide();
				}

				// 해외국가
				if(res.international_postcode)
					$("input[name='zoneZipcode[]']").val(res.international_postcode);
				if(res.international_country)
					$("input[name='international_country']").val(res.international_country);
				if(res.international_town_city)
					$("input[name='international_town_city']").val(res.international_town_city);
				if(res.international_county)
					$("input[name='international_county']").val(res.international_county);
				if(res.international_address)
					$("input[name='international_address']").val(res.international_address);
				if(res.international_address)
					$("input[name='international_address']").val(res.international_address);

				if(res.shipping_phone)
					$("input[name='shipping_phone']").val(res.shipping_phone);

			}
		});
	}else{
		if($("input[name='shipping_address_seq']").val()){
			document.insFrm.reset();
			$("input[name='shipping_address_seq']").val('');
		}
		setDefaultText();
	}

	if	($('.shipping_address_insert_lay').length > 1){
		$('.shipping_address_insert_lay').eq(1).remove();
	}
	openDialog("장소 등록/수정", "shipping_address_insert", {"width":700,"height":480});
}

// 국내 / 해외 주소 변경
function international_chg(){
	var nation = $("select[name='address_nation'] option:selected").val();
	$(".inter_area").hide();
	$(".international_"+nation).show();
	if (nation == 'korea') {
		$("input[name='zoneZipcode[]']").attr('readonly',true);
	} else {
		$("input[name='zoneZipcode[]']").attr('readonly',false);
	}
}

// 분류 변경시
function category_chg(){
	var category = $("#address_category option:selected").val();
	if(category == 'direct_input'){
		$("input[name='address_category_direct']").attr('disabled',false);
	}else{
		$("input[name='address_category_direct']").attr('disabled',true);
	}
}

// 장소 등록 및 수정
function insert_address(){
	$("#insFrm").submit();

	list_table_create(); // 리스트 재 호출
}

// ### 선택 장소 적용 ### //
function apply_address(e){
	var chkObj	= $("input[name='add_chk[]']:checked");
	var chk_cnt = chkObj.length;
	if(chk_cnt == 0){
		alert('선택된 장소가 없습니다.');
		return false;
	}
<?php if($TPL_VAR["use_type"]=='sendding'||$TPL_VAR["use_type"]=='refund'){?>
	if(chk_cnt > 1){
		alert('1개만 선택해 주십시오.');
		return false;
	}else{
		var suc_msg = <?php if($TPL_VAR["use_type"]=='sendding'){?>'출고지'<?php }else{?>'반송지'<?php }?>;

		var shipping_address_seq = $("input[name='add_chk[]']:checked").val();
		var address = $("input[name='add_chk[]']:checked").closest(".address_tr_" + shipping_address_seq).find("td.address").html();
		var category	= chkObj.closest(".address_tr_" + shipping_address_seq).find("td.category").html();
		var address_name= chkObj.closest(".address_tr_" + shipping_address_seq).find("td.address_name").html();

		if($.trim(address).length > 0){
			$("input[name='<?php echo $TPL_VAR["use_type"]?>_address_seq']").val(shipping_address_seq);
			$(".<?php echo $TPL_VAR["use_type"]?>_txt").text('[' + category + ' > ' + address_name + ']' + address);

			// alert(suc_msg + '가 설정되었습니다.');
			closeDialog('shipping_address_pop_area');
		}else{
			$("input[name='add_chk[]']:checked").attr('checked',false);
			alert(suc_msg + ' 에는 반드시 주소가 필요합니다.\n주소를 기재한 다른 장소를 선택해주세요.');
		}
	}
<?php }elseif($TPL_VAR["use_type"]=='address'){?>
	$("input[name='add_chk[]']:checked").each(function(){
		var shipping_address_seq = $(this).val();
		var tr_obj = $(this).closest(".address_tr_" + shipping_address_seq);
		var scm_type = '';
		var scm_set = '';

		var address_html = '<tr>';
		address_html += '	<td class="its-td"><input type="hidden" class="shipping_address_input" name="shipping_address_seq[]" value="'+shipping_address_seq+'" /><input type="hidden" name="shipping_address_category[]" value="'+tr_obj.find("td.category").html()+'" />'+tr_obj.find("td.category").html()+'</td>'; // 분류
		address_html += '	<td class="its-td"><input type="hidden" name="shipping_address_nation[]" value="'+tr_obj.find("td.nation").html()+'" />'+tr_obj.find("td.nation").html()+'</td>'; // 해외
		address_html += '	<td class="its-td"><input type="hidden" name="shipping_store_name[]" value="'+tr_obj.find("td.address_name").html()+'" />'+tr_obj.find("td.address_name").html()+'</td>'; // 명칭
		address_html += '	<td class="its-td"><input type="hidden" name="shipping_address_full[]" value="'+tr_obj.find("td.address").html()+'" />'+tr_obj.find("td.address").html()+'</td>'; // 주소
		address_html += '	<td class="its-td"><input type="hidden" name="store_phone[]" value="'+tr_obj.find("td.shipping_phone").html()+'" />'+tr_obj.find("td.shipping_phone").html()+'</td>'; // 연락처
		if(tr_obj.attr('add_type') == 'input'){
			scm_type = '<input type="hidden" name="store_scm_type[]" value="N" />';
			scm_set = '<input type="hidden" name="store_supply_set[]" value="N" />';
			scm_set += '<input type="hidden" name="store_supply_set_view[]" value="N" />';
			scm_set += '<input type="hidden" name="store_supply_set_order[]" value="N" />';
			address_html += '	<td class="its-td">재고창고 미연동'+scm_set+'</td>'; // 입력된 장소
		}else{
			scm_type = '<input type="hidden" name="store_scm_type[]" value="Y" />';
			scm_set = '<input type="hidden" name="store_supply_set[]" value="Y" />';
			scm_set += '<input type="hidden" name="store_supply_set_view[]" value="Y" />';
			scm_set += '<input type="hidden" name="store_supply_set_order[]" value="Y" />';
			address_html += '	<td class="its-td">재고수량 : 노출<br/>매장선택 : 재고>0'+scm_set+'</td>'; // 재고창고
		}
		address_html += '	<td class="its-td">'+scm_type+'<span class="btn small red store_btn_area"><input type="button" onclick="del_address(this);" value="삭제" /></span></td>'; // 관리
		address_html += '</tr>';


		if($(".store_tb").find("tbody > tr").attr('base_tr') == 'Y'){
			$(".store_tb").find("tbody > tr").remove();
		}
		$(".store_tb").find("tbody").append(address_html);
	});
	alert('적용되었습니다.');
	closeDialogEvent(e);
<?php }?>
}

// 저장 후 반영 함수
function applyAddress(){
	formMoveSub('input', 1);
}

$(document).ready(function() {
	list_table_create(); // 기본 리스트 호출
	setDefaultText(); // title 기본 셋

	$("input[name='src_address_name']").keydown(function(e){
		if(e.keyCode == 13) {
			src_list();
		}
	});
});
</script>

<div class="content">
	<!-- 주소 검색 부분 :: START -->
	<div class="center">
		<input type="hidden" name="tab_type" id="tab_type" value="input" />	
		<select name="src_address_category" id="src_address_category">
			<option value="">전체분류</option>
		</select>
		<select name="src_address_nation" id="src_address_nation">
			<option value="">국내/해외</option>
			<option value="korea">국내</option>
			<option value="global">해외</option>
		</select>
		<input type="text" name="src_address_name" id="src_address_name" title="매장명" value="" />
		<button type="button" onclick="src_list();" class="resp_btn active">검색</button>	
	</div>
	<!-- 주소 검색 부분 :: END -->

	<!-- 리스트 부분 :: START -->
	<div class="title_dvs">
		<!-- Tab -->	
		<ul class="tab_01">
			<li><a href="javascript:void(0);" onclick="formMoveSub('input',1);" class="current">오프라인 매장</a></li>
		</ul>
		<button onclick="insert_address_pop('add');" class="resp_btn active" type="button">등록</button>
	</div>

	<!-- Contants custom -->
	<div id="shipping_address_contants_list">
	</div>
</div>
<!-- 리스트 부분 :: END -->
<div class="footer">
	<button type="button" onclick="apply_address(this);" class="resp_btn active size_XL">선택 적용</button>
	<button type="button" onclick="closeDialogEvent(this);" class="resp_btn v3 size_XL">취소</button>
</div>

<!-- 장소 등록/수정 :: START -->
<div id="shipping_address_insert" class="hide shipping_address_insert_lay">
	<form name="insFrm" id="insFrm" class="insFrmLay" method="post" action="../setting_process/set_shipping_address" target="actionFrame">
	<input type="hidden" name="shipping_address_seq" value="" />
	
	<table class="table_basic thl">
	<tr>
		<th>분류</th>
		<td>
			<select name="address_category" id="address_category" onchange="category_chg();">
				<option value="">직접입력</option>
			</select>
			<input type="text" name="address_category_direct" id="address_category_direct" class="line" title="분류명" value="" />
		</td>
	</tr>
	<tr>
		<th>매장명</th>
		<td>
			<input type="text" name="address_name" value="" title="매장명" class="line" />
		</td>
	</tr>
	<tr>
		<th>주소</th>
		<td class="lh_normal">
			<input type="text" name="zoneZipcode[]" value="" size="7" title="우편번호" class="line" readonly='true' />
			<select name="address_nation" onchange="international_chg();">
				<option value="korea">대한민국</option>
				<option value="global">해외국가</option>
			</select>
			<span class="inter_area international_korea"><input type="button" value="검색" onclick="openDialogZipcode('zone');" class="resp_btn active"/></span>

			<div class="inter_area international_korea ">
				<input type="hidden" name="zoneAddress_type" value="zibun" />
				<input type="text" name="zoneAddress" value="" size="65" title="주소" class="line mt3" readonly="true" />
				<input type="text" name="zoneAddress_street" value="" size="65" title="주소" class="line hide mt3" readonly="true" /><br />
				<input type="text" name="zoneAddressDetail" value="" size="65" title="상세주소" class="line mt3" />
			</div>
			<div class="inter_area international_global hide ">
				<input type="text" name="international_country" value="" size="25" title="국가" class="line" />
				<input type="text" name="international_town_city" value="" size="25" title="도시" class="line mt3" />
				<input type="text" name="international_county" value="" size="60" title="주/도" class="line mt3" />
				<input type="text" name="international_address" value="" size="60" title="주소" class="line mt3" />
			</div>
		</td>
	</tr>
	<tr>
		<th>매장 전화번호</th>
		<td>
			<input type="text" name="shipping_phone" value="" title="매장 전화번호" class="line" />
		</td>
	</tr>
	</table>
	</form>

	<div class="footer">
		<button type="button" class="resp_btn active size_XL" onclick="insert_address();">확인</button>
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">취소</button>
	</div>
</div>
<!-- 장소 등록/수정 :: END -->