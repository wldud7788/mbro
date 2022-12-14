<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/setting/shipping_search_form.html 000010201 */ ?>
<style type="text/css">
/* 기본검색적용 버튼 */
button#search_set {border: none;width:84px;height:23px;background:url('/admin/skin/default/images/common/icon/admin_nbt01_2.png') no-repeat; cursor:pointer;}
button#get_default_button {border: none;width:84px;height:23px;background:url('/admin/skin/default/images/common/icon/admin_nbt01.png') no-repeat; cursor:pointer;}
button#btn_search_detail.open {border: none;width:84px;height:23px;background:url('/admin/skin/default/images/common/icon/admin_nbt03_1.png') no-repeat; cursor:pointer;}
button#btn_search_detail.close {border: none;width:84px;height:23px;background:url('/admin/skin/default/images/common/icon/admin_nbt03_2.png') no-repeat; cursor:pointer;}
button#btn-reset { width: 84px; height: 23px; background: url(/admin/skin/default/images/common/icon/admin_nbt02_1.png) no-repeat; }
div.search-form-container-new { width:calc(100% + 40px); margin: -20px -20px 0;}
</style>

<script type="text/javascript">
var keyword		= "<?php echo $_GET["keyword"]?>";
var search_type = "<?php echo $_GET["search_type"]?>";
$(document).ready(function() {
	// 무료화 활성화
	$(".calcul_type_box").unbind().bind('change', function(){
		free_chk_enr($(this));
	});

	// 기본 검색 설정
	$("#search_set").unbind().bind("click", function(){
		var title = '기본검색 설정<span class="desc"> - 아래서 원하는 검색조건을 설정하여 편하게 쇼핑몰을 운영하세요</span>';
		openDialog(title, "search_detail_dialog", {"width":"880","height":"390"});

	});

	// 기본 검색 적용
	$("#get_default_button").unbind().bind("click", function(){
		$.getJSON('get_search_default?search_page=<?php echo $TPL_VAR["search_page"]?>', function(result) {
			$("div.search-form-container-new input[type='checkbox']").removeAttr("checked");
			$("div.search-form-container-new input[type='text']").val('');
			for(var i=0;i<result.length;i++){
				if ( result[i][0] == 'shipping_calcul_type' || result[i][0] == 'shipping_calcul_free_yn' ) {
					$.each(result[i][1], function(idx, val){
						$("input[name='"+result[i][0]+"["+idx+"]'][value='"+val+"']").attr("checked",true);
					});
				} else if ( typeof(result[i][1]) == 'object' ) {
					$.each(result[i][1], function(idx, val){
						$("input[name='"+result[i][0]+"[]'][value='"+val+"']").attr("checked",true);
					});
				} else {
					$("input[name='"+result[i][0]+"'][value='"+result[i][1]+"']").attr("checked",true);
				}
			}
		});
	});

	$("#btn-reset").off().on("click", function(event){
		event.preventDefault();
		var obj = $(this).closest('form .search-form-container-new');

		obj.find('select, textarea, input[type=text]').val('');
		obj.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');

		// 아이콘 검색
		obj.find(".msg_select_icon").text('');

		var chk_except = false;
		obj.find('input:text, input:hidden').each(function() {
			chk_except = false;
			if (this.name == 'malllist[]') chk_except = true;
			if (this.name == 'show_search_form') chk_except = true;

			if (this.name != '') {
				if (!chk_except) $(this).val('');
			} else {
				// - 입점사 검색 - 셀렉트박스 제외
				$(this).val('');
				$(this).val($("select[name='provider_seq_selector'] option:first-child").text());
			}
		});
		$('.search_type_text').hide();

		$('select[name="shipping_group_seq"]').trigger('change');
		$('input[name="color_pick[]"]').attr('checked', false);
		$('#goodsForm input[name="color_pick[]"]').parent().removeClass('active');
	});

	
	$("#btn_search_detail").unbind().bind('click', function () {
		if ($(this).attr('class')=='close') {
			setSearchDetail('close');
		} else if ($(this).attr('class')=='open') {
			setSearchDetail('open');
		}
	});
<?php if($_GET["show_search_form"]){?>
		setSearchDetail('<?php echo $_GET["show_search_form"]?>');
<?php }elseif($TPL_VAR["gdsearchdefault"]["search_form_view"]){?>
		setSearchDetail('<?php echo $TPL_VAR["gdsearchdefault"]["search_form_view"]?>');
<?php }else{?>
		setSearchDetail('open');
<?php }?>
	
<?php if(is_array($TPL_R1=$TPL_VAR["sc"]["shipping_calcul_type"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
	free_chk_enr($("input[name='shipping_calcul_type[<?php echo $TPL_K1?>]']"));
<?php }}?>
});

// 무료화 활성화 함수
function free_chk_enr(obj){
	if($(obj).is(':checked')){
		$(obj).closest(".chkbox_item").find(".calcul_free").attr('disabled',false);
	}else{
		$(obj).closest(".chkbox_item").find(".calcul_free").attr('disabled',true);
	}
}

function setSearchDetail(type) {
	if (type=='close') {
		$("#show_search_form").val('close');
		$("#btn_search_detail").removeClass("close").addClass("open");
		$(".search_detail_form").hide();
	} else if (type=='open') {
		$("#show_search_form").val('open');
		$("#btn_search_detail").removeClass("open").addClass("close");
		$(".search_detail_form").show();
	}
}
</script>

<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js?dummy=<?php echo date('Ymd')?>"></script>
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/searchform.css?v=<?php echo date('Ymd')?>" />

<div class="search_container">
	<table class="table_search">
	<tr>
			<th>검색어</th>
			<td>
				<select name="searchType">
					<option value="all">배송그룹명</option>		
					<option value="id">배송그룹번호</option>			
					<option value="code">거래처 코드</option>					
				</select>
				<input type="text" name="keyword" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" title="" size="80"/>
			</td>
		</tr>
		<tr>
			<th>배송비 계산</th>
			<td>
				<div class="resp_checkbox">
					<span class="chkbox_item">
						<label><input type="checkbox" class="calcul_type_box"  name="shipping_calcul_type[1]" value="bundle" <?php if($TPL_VAR["sc"]['shipping_calcul_type'][ 1]=='bundle'){?>checked<?php }?> /> 묶음계산-묶음배송</label> (<label><input type="checkbox" class="calcul_free" name="shipping_calcul_free_yn[1]" value="Y" <?php if($TPL_VAR["sc"]['shipping_calcul_free_yn'][ 1]=='Y'){?>checked<?php }?> disabled />무료화</label>)
					</span>
					<span class="chkbox_item">
						<label><input type="checkbox" class="calcul_type_box" name="shipping_calcul_type[2]" value="each" <?php if($TPL_VAR["sc"]['shipping_calcul_type'][ 2]=='each'){?>checked<?php }?> /> 개별계산-개별배송</label> (<label><input type="checkbox" class="calcul_free" name="shipping_calcul_free_yn[2]" value="Y" <?php if($TPL_VAR["sc"]['shipping_calcul_free_yn'][ 2]=='Y'){?>checked<?php }?> disabled />무료화</label>)
					</span>
					<span class="chkbox_item">
						<label><input type="checkbox" class="calcul_type_box" name="shipping_calcul_type[3]" value="free" <?php if($TPL_VAR["sc"]['shipping_calcul_type'][ 3]=='free'){?>checked<?php }?> /> 무료계산-묶음배송</label>
					</span>
				</div>			
			</td>
		</tr>

		<tr>
			<th>대한민국 배송방법</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="kr_method" value="all" checked /> 모든 배송방법</label>				
					<label><input type="radio" name="kr_method" value="default" /> 기본 배송방법</label>
				</div>
				<br/>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="kr_set_code[]" value="delivery"/> 택배</label>
					<label><input type="checkbox" name="kr_set_code[]" value="direct_delivery"/> 직접배송</label>
					<label><input type="checkbox" name="kr_set_code[]" value="quick"/> 퀵서비스</label>
					<label><input type="checkbox" name="kr_set_code[]" value="freight"/> 화물배송</label>
					<label><input type="checkbox" name="kr_set_code[]" value="direct_store"/> 매장수령</label>
					<label><input type="checkbox" name="kr_set_code[]" value="custom"/> 직접입력</label>
				</div>
			</td>
		</tr>

		<tr>
			<th>해외국가 배송방법</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="gl_method" value="all" checked/> 모든 배송방법</label>				
					<label><input type="radio" name="gl_method" value="default"/> 기본 배송방법</label>
				</div>
				<br/>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="gl_set_code[]" value="delivery"/> 택배</label>
					<label><input type="checkbox" name="gl_set_code[]" value="direct_delivery"/> 직접배송</label>
					<label><input type="checkbox" name="gl_set_code[]" value="quick"/> 퀵서비스</label>
					<label><input type="checkbox" name="gl_set_code[]" value="freight"/> 화물배송</label>
					<label><input type="checkbox" name="gl_set_code[]" value="direct_store"/> 매장수령</label>
					<label><input type="checkbox" name="gl_set_code[]" value="custom"/> 직접입력</label>
				</div>
			</td>
		</tr>

		<tr>
			<th>기본 배송비</th>
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="default_type[]" value="free"/> 무료배송</label>
					<label><input type="checkbox" name="default_type[]" value="fixed"/> 고정 배송비</label>
					<label><input type="checkbox" name="default_type[]" value="iffree"/> 조건부  무료배송</label>
					<label><input type="checkbox" name="default_type[]" value="ifpay"/> 조건부  차등배송비</label>
				</div>
			</td>
		</tr>

		<tr>
			<th>추가 배송비</th>
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="add_opt_type[]" value="Y"/> 있음</label>
					<label><input type="checkbox" name="add_opt_type[]" value="N"/> 없음</label>
				</div>
			</td>
		</tr>

		<tr>
			<th>적용상품</th>
			<td>
				<div class="resp_checkbox">					
					<label><input type="checkbox" name="shipping_etc_search[]" value="goods"/> 연결된 상품이 없는 그룹</label>					
				</div>
			</td>
		</tr>
	</table>
	<div class="search_btn_lay"></div>
</div>