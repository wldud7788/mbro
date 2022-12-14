<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/popup/shipping_address_pop.html 000015757 */ ?>
<style type="text/css">
/* 장소리스트 CSS */
.ctab {border-top:1px solid #d6d6d6;border-right:1px solid #d6d6d6;border-bottom:1px solid #d6d6d6;width:100px;line-height:30px;text-align:center;background-color:#eeeeee;float:left;font-size:12px;font-family:Dotum;font-weight:bold;color:#757575;}
.ctab-on {border-top:1px solid #d6d6d6;border-bottom:1px solid #ffffff;border-right:1px solid #d6d6d6;width:100px;line-height:30px;text-align:center;background-color:#ffffff;float:left;font-size:12px;font-family:Dotum;font-weight:bold;color:#000000;}
</style>

<script type="text/javascript">
var present_gb = '';
// 장소리스트 탭이동
function formMoveSub(gb, no){
	//$(".ctab-on").addClass("current");
	$(".tab_01 li a").removeClass("current");
	$(".tab_01 li").eq(no-1).find("a").addClass("current");

	$("#tab_type").val(gb);
	present_gb = gb;

	if(gb == 'input'){
		$(".insertAdress").show();
		$(".warehouseAdress").hide();
	}else if(gb == 'scm'){
		$(".insertAdress").hide();
		$(".warehouseAdress").show();
	}
	/* O2O 매장 추가 */
<?php if($TPL_VAR["checkO2OService"]){?>
		else if(gb == 'o2o'){
		$(".insertAdress").hide();
		$(".warehouseAdress").hide();
	}
<?php }?>

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
	var url = "/admin/popup/shipping_address_list";
	var params = {'tabType':tabType};
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
	openDialog("장소 등록/수정", "shipping_address_insert", {"width":600,"height":380});
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
function apply_address(){
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
		var suc_msg		= <?php if($TPL_VAR["use_type"]=='sendding'){?>'출고지'<?php }else{?>'반송지'<?php }?>;
		var shipping_address_seq = chkObj.val();
		var add_type	= chkObj.closest(".address_tr_" + shipping_address_seq).attr('add_type');
		var address		= chkObj.closest(".address_tr_" + shipping_address_seq).find("td.address").html();
		var category	= chkObj.closest(".address_tr_" + shipping_address_seq).find("td.category").html();
		var address_name= chkObj.closest(".address_tr_" + shipping_address_seq).find("div.address_name").html();

		if($.trim(address).length > 0){
			var scm_type = (add_type == 'input') ? 'N' : 'Y';
			$("input[name='<?php echo $TPL_VAR["use_type"]?>_scm_type']").val(scm_type);
			$("input[name='<?php echo $TPL_VAR["use_type"]?>_address_seq']").val(shipping_address_seq);
			$(".<?php echo $TPL_VAR["use_type"]?>_txt").text('[' + category + ' > ' + address_name + ']' + address);

			// alert(suc_msg + '가 설정되었습니다.');
			closeDialog('shipping_address_pop_area');
		}else{
			chkObj.attr('checked',false);
			alert(suc_msg + ' 에는 반드시 주소가 필요합니다.\n주소를 기재한 다른 장소를 선택해주세요.');
		}
	}
<?php }elseif($TPL_VAR["use_type"]=='address'){?>
	chkObj.each(function(){
		var shipping_address_seq = $(this).val();
		var tr_obj = $(this).closest(".address_tr_" + shipping_address_seq);
		var scm_type	= '';
		var scm_set		= '';
		var add_use		= '';

		var address_html = '<tr>';
		address_html += '	<td class="its-td"><input type="hidden" class="shipping_address_input" name="shipping_address_seq[]" value="'+shipping_address_seq+'" /><input type="hidden" name="shipping_address_category[]" value="'+tr_obj.find("td.category").html()+'" />'+tr_obj.find("td.category").html()+'</td>'; // 분류
		if(tr_obj.find("div.address_use").html() != null){ // 창고 검색
			add_use = '<div class="blue">'+tr_obj.find("div.address_use").html()+'</div>';
		}
		address_html += '	<td class="its-td"><input type="hidden" name="shipping_store_name[]" value="'+tr_obj.find("div.address_name").html()+'" />'+tr_obj.find("div.address_name").html() + add_use + '</td>'; // 명칭
		address_html += '	<td class="its-td-align center"><input type="hidden" name="shipping_address_nation[]" value="'+tr_obj.find("td.nation").html()+'" />'+tr_obj.find("td.nation").html()+'</td>'; // 해외
		address_html += '	<td class="its-td"><input type="hidden" name="shipping_address_full[]" value="'+tr_obj.find("td.address").html()+'" />'+tr_obj.find("td.address").html()+'</td>'; // 주소
		address_html += '	<td class="its-td"><input type="hidden" name="store_phone[]" value="'+tr_obj.find("td.shipping_phone").html()+'" />'+tr_obj.find("td.shipping_phone").html()+'</td>'; // 연락처
		var tmp_wh_use = tr_obj.attr('wh_use');
		if(tmp_wh_use == 'N'){
			scm_type = '<input type="hidden" name="store_scm_type[]" value="N" />';
			scm_set = '<input type="hidden" name="store_supply_set[]" value="N" />';
			scm_set += '<input type="hidden" name="store_supply_set_view[]" value="N" />';
			scm_set += '<input type="hidden" name="store_supply_set_order[]" value="N" />';
			address_html += '	<td class="its-td">해당 상품의 재고수량'+scm_set+'</td>'; // 입력된 장소
		}else if(tmp_wh_use == 'Y'){
			scm_type = '<input type="hidden" name="store_scm_type[]" value="Y" />';
			scm_set = '<input type="hidden" name="store_supply_set[]" value="Y" />';
			scm_set += '<input type="hidden" name="store_supply_set_view[]" value="Y" />';
			scm_set += '<input type="hidden" name="store_supply_set_order[]" value="Y" />';
			address_html += '	<td class="its-td-align pdl5">해당 상품의 해당 창고의 재고수량<br/>※ 매장 재고수량 노출<br/>※ 매장 재고수량 있을때 선택가능'+scm_set+'</td>'; // 재고창고
		}
		address_html += '	<td class="its-td-align center"><div class="blue">노출</div></td>'; // 상태
		address_html += '	<td class="its-td-align center">'+scm_type+'<span class="btn small red store_btn_area"><input type="button" onclick="del_address(this);" value="삭제" /></span></td>'; // 관리
		address_html += '	<input type="hidden" name="store_type[]" value="'+tr_obj.attr('add_type')+'" />';	// 장소 타입
		address_html += '	<input type="hidden" name="store_scm_seq[]" value="'+tr_obj.attr('store_scm_seq')+'" />';	// 창고 고유키
		address_html += '</tr>';


		if($(".store_tb").find("tbody > tr").attr('base_tr') == 'Y'){
			$(".store_tb").find("tbody > tr").remove();
		}
		$(".store_tb").find("tbody").append(address_html);
	});
	alert('적용되었습니다.');
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
	<input type="hidden" name="tab_type" id="tab_type" value="input" />
	<div class="center">		
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
		<div class="l_dvs">
			<ul class="tab_01">
				<li><a href="javascript:void(0);" onclick="formMoveSub('input',1);" class="current">오프라인 매장</a></li>
				<li><a href="javascript:void(0);" onclick="formMoveSub('scm',2);">재고 창고</a></li>
			</ul>
		</div>
	<!-- control button -->
		<div class="control-btn r_dvs">		
			<span class="warehouseAdress hide gray">※미사용 창고는 수령매장으로 선택할 수 없습니다.</span>
			<span class="insertAdress gray">※신규등록 및 수정은 <a class="link_blue_01" href="../o2o/o2osetting" target="_blank">오프라인 매장>매장 리스트</a>에서 설정 가능합니다.	</span>		
		</div>
	</div>

	<!-- Contants custom -->
	<div id="shipping_address_contants_list">
	</div>		
</div>

<div class="footer">
	<button type="button" onclick="apply_address();" class="resp_btn active size_XL">선택 적용</button>
	<button type="button" onclick="closeDialogEvent(this);" class="resp_btn v3 size_XL">취소</button>
</div>
<!-- 리스트 부분 :: END -->

<!-- 장소 등록/수정 :: START -->
<div id="shipping_address_insert" class="hide shipping_address_insert_lay">
	<form name="insFrm" id="insFrm" class="insFrmLay" method="post" action="/admin/setting_process/set_shipping_address" target="actionFrame">
	<input type="hidden" name="shipping_address_seq" value="" />
	<input type="hidden" name="address_provider_seq" value="1" />
	<table class="table_basic thl" cellspacing="0" cellpadding="0" width="100%">
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
		<td>
			<input type="text" name="zoneZipcode[]" value="" size="7" title="우편번호" class="line" readonly='true' />
			<select name="address_nation" onchange="international_chg();">
				<option value="korea">대한민국</option>
				<option value="global">해외국가</option>
			</select>
			<span class="btn small inter_area international_korea"><input type="button" value="검색" onclick="openDialogZipcode('zone');"/></span>

			<div class="inter_area international_korea">
				<input type="hidden" name="zoneAddress_type" value="zibun" />
				<input type="text" name="zoneAddress" value="" size="65" title="주소" class="line" readonly="true"/>
				<input type="text" name="zoneAddress_street" value="" size="65" title="주소" class="line hide" readonly="true" /><br />
				<input type="text" name="zoneAddressDetail" value="" size="65" title="상세주소" class="line" />
			</div>
			<div class="inter_area international_global hide">
				<input type="text" name="international_country" value="" size="25" title="국가" class="line" />
				<input type="text" name="international_town_city" value="" size="25" title="도시" class="line" />
				<input type="text" name="international_county" value="" size="60" title="주/도" class="line" />
				<input type="text" name="international_address" value="" size="60" title="주소" class="line" />
			</div>
		</td>
	</tr>
	<tr>
		<th>매장 전화번호</th>
		<td >
			<input type="text" name="shipping_phone" value="" title="매장 전화번호" class="line" />
		</td>
	</tr>
	</table>
	</form>

	<div class="center pdt10">
		<button type="button" onclick="insert_address();" class="btn_resp b_gray size_a">확인</button>
	</div>
</div>
<!-- 장소 등록/수정 :: END -->