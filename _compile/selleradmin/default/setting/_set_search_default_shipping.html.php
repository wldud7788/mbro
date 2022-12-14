<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/setting/_set_search_default_shipping.html 000006991 */ ?>
<style type="text/css">
/* 기본검색적용 버튼 */
button#search_set {border: none;width:84px;height:24px;background:url('/admin/skin/default/images/common/icon/admin_nbt01_2.png') no-repeat; cursor:pointer;}
button#get_default_button {border: none;width:84px;height:24px;background:url('/admin/skin/default/images/common/icon/admin_nbt01.png') no-repeat; cursor:pointer;}
button#btn_search_detail.open {border: none;width:84px;height:24px;background:url('/admin/skin/default/images/common/icon/admin_nbt03_1.png') no-repeat; cursor:pointer;}
button#btn_search_detail.close {border: none;width:84px;height:24px;background:url('/admin/skin/default/images/common/icon/admin_nbt03_2.png') no-repeat; cursor:pointer;}
button#btn-reset { width: 84px; height: 24px; background: url(/admin/skin/default/images/common/icon/admin_nbt02_1.png) no-repeat; }
div.search-set-container-new { width:99%; margin-left:5px; }
</style>
<script type="text/javascript">
$(document).ready(function() {
	set_search_default();
});

// 무료화 활성화 함수
function free_chk_enr(obj){
	if($(obj).is(':checked')){
		$(obj).closest(".chkbox_item").find(".calcul_free").attr('disabled',false);
	}else{
		$(obj).closest(".chkbox_item").find(".calcul_free").attr('disabled',true);
	}
}

function set_search_default() {
	$.getJSON('get_search_default?search_page=<?php echo $TPL_VAR["search_page"]?>', function(result) {
		$("div.search-set-container-new input[type='checkbox']").removeAttr("checked");
		$("div.search-set-container-new input[type='text']").val('');
		try {
			for(var i=0;i<result.length;i++){
				if ( result[i][0] == 'shipping_calcul_type' || result[i][0] == 'shipping_calcul_free_yn' ) {
					$.each(result[i][1], function(idx, val){
						$("div.search-set-container-new input[name='"+result[i][0]+"["+idx+"]'][value='"+val+"']").attr("checked",true);
					});
				} else if ( typeof(result[i][1]) == 'object' ) {
					$.each(result[i][1], function(idx, val){
						$("div.search-set-container-new input[name='"+result[i][0]+"[]'][value='"+val+"']").attr("checked",true);
					});
				} else {
					$("div.search-set-container-new input[name='"+result[i][0]+"'][value='"+result[i][1]+"']").attr("checked",true);
				}
			}
		} catch (e) {
			//console.log(e);
		}
	});
}
</script>
<form name="set_search_detail" id="set_search_detail" method="post" action="set_search_default" target="actionFrame">
<input type="hidden" name="search_page" value="<?php echo $TPL_VAR["search_page"]?>">
<div class="search-set-container-new" id="contents">
	<table style="line-height:30px;" border="0">
	<tr>
		<th class="left" width="350">배송그룹 → 배송비계산</th>
		<td width="700">
			<span class="chkbox_item">
			<label><input type="checkbox" class="calcul_type_box"  name="shipping_calcul_type[1]" value="bundle" /> 묶음계산-묶음배송</label> (<label><input type="checkbox" class="calcul_free" name="shipping_calcul_free_yn[1]" value="Y" disabled />무료화</label>)
			</span>
			<span class="chkbox_item">
			<label><input type="checkbox" class="calcul_type_box" name="shipping_calcul_type[2]" value="each" /> 개별계산-개별배송</label> (<label><input type="checkbox" class="calcul_free" name="shipping_calcul_free_yn[2]" value="Y" disabled />무료화</label>)
			</span>
			<span class="chkbox_item">
			<label><input type="checkbox" class="calcul_type_box" name="shipping_calcul_type[3]" value="free" /> 무료계산-묶음배송</label>
			</span>
		</td>
	</tr>
	<tr>
		<th class="left" valign="top">배송그룹 → 대한민국 배송방법</th>
		<td>
			<label><input type="radio" name="kr_method" value="all" /> 모든 배송방법</label>
			&nbsp;&nbsp;&nbsp;
			<label><input type="radio" name="kr_method" value="default" /> 기본 배송방법</label>
			<br/>
			<label><input type="checkbox" name="kr_set_code[]" value="delivery" /> 택배</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="kr_set_code[]" value="direct_delivery" /> 직접배송</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="kr_set_code[]" value="quick" /> 퀵서비스</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="kr_set_code[]" value="freight" /> 화물배송</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="kr_set_code[]" value="direct_store" /> 매장수령</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="kr_set_code[]" value="custom" /> 직접입력</label>
		</td>
	</tr>
	<tr>
		<th class="left" valign="top">배송그룹 → 해외국가 배송방법</th>
		<td>
			<label><input type="radio" name="gl_method" value="all" /> 모든 배송방법</label>
			&nbsp;&nbsp;&nbsp;
			<label><input type="radio" name="gl_method" value="default" /> 기본 배송방법</label>
			<br/>
			<label><input type="checkbox" name="gl_set_code[]" value="delivery" /> 택배</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="gl_set_code[]" value="direct_delivery" /> 직접배송</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="gl_set_code[]" value="quick" /> 퀵서비스</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="gl_set_code[]" value="freight" /> 화물배송</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="gl_set_code[]" value="direct_store" /> 매장수령</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="gl_set_code[]" value="custom" /> 직접입력</label>
		</td>
	</tr>
	<tr>
		<th class="left">배송그룹 → 기본배송방법 → 기본 배송비</th>
		<td>
			<label><input type="checkbox" name="default_type[]" value="free" /> 무료배송</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="default_type[]" value="fixed" /> 고정 배송비</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="default_type[]" value="iffree" /> 조건부  무료배송</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="default_type[]" value="ifpay" /> 조건부  차등배송비</label>
		</td>
	</tr>
	<tr>
		<th class="left">배송그룹 → 기본배송방법 → 추가 배송비</th>
		<td>
			<label><input type="checkbox" name="add_opt_type[]" value="Y" /> 있음</label>&nbsp;&nbsp;&nbsp;
			<label><input type="checkbox" name="add_opt_type[]" value="N" /> 없음</label>
		</td>
	</tr>
	<tr>
		<th class="left">배송그룹 → 적용상품</th>
		<td>
			<label><input type="checkbox" name="shipping_etc_search[]" value="goods" /> 연결된 상품이 없는 그룹</label>
		</td>
	</tr>
	</table>
</div>
<div align="center" style="padding-top:10px;">
	<span class="btn large black">
		<button type="submit">저장하기<span class="arrowright"></span></button>
	</span>
</div>
</form>