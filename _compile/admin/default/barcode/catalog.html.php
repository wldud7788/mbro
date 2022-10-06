<?php /* Template_ 2.2.6 2022/05/25 16:35:33 /www/music_brother_firstmall_kr/admin/skin/default/barcode/catalog.html 000015809 */ 
$TPL_listdata_1=empty($TPL_VAR["listdata"])||!is_array($TPL_VAR["listdata"])?0:count($TPL_VAR["listdata"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/scm.common.js"></script>
<script>
	$(document).ready(function(){

		//바코드 일괄 등록
		$("#barcode_write").click(function(){
			var originAction = $("#barcodeFrm").attr('action');
			$("#barcodeFrm").attr('action', 'barcode_write');
			$("#barcodeFrm").attr('method', 'post');
			$("#barcodeFrm").attr('target', 'barcode_write');
			$("#barcodeFrm").submit();

			$("#barcodeFrm").attr('action', originAction);
		});

		//전체 체크 버튼
		$('#chkAll').click(function(){
			if($('#chkAll:checked').length == 0){
				$('.chk').attr('checked', false);
			}else{
				$('.chk').attr('checked', true);
			}
		});

		//재고 수량 셀렉트 박스 변경
		$('.sel-stock').change(function(){
			$('#target_stock').val('');
			if($(this).val() == 0){
				$('#target_stock').attr('disabled', true);
				$('.tmp_stock').each(function(){
					$(this).next('.chk_stock').val($(this).val());
				});
			}else{
				$('#target_stock').attr('disabled', false);
			}
		});

		//재고 수량 숫자만 입력 받기
		$('.chk_stock, #target_stock').keydown(function(event){
			if(!( (event.keyCode >= 48 && event.keyCode<=57) || (event.keyCode >= 96 && event.keyCode<= 105) || event.keyCode == 8) ){
				alert('숫자만 입력해 주세요.');
				if(event.returnValue) event.returnValue = false;
				else $(this).val(this.value.replace(/[^0-9]+/g, ''));
				return false;
			}
		});

		//재고 수량 일괄 적용
		$('#btn_all_stock').click(function(){
			if($('.sel-stock').val() != 0 ){
				var tar_val = $('#target_stock').val() != '' ? $('#target_stock').val() : 0;
				$('.chk_stock').val(tar_val);
			}
		});

		//정렬 버튼 클릭
		$('.btnSort').click(function(){
			var sort = $("input[name='sort']").val();
			if($(this).attr("orderby") != "<?php echo $TPL_VAR["orderby"]?>") sort = "";

			if(sort == "asc"){
				sort = "desc";
			}else if(sort == "desc" || sort == ""){
				sort = "asc";
			}
			var orderby = sort+"_"+$(this).attr("orderby");

			$("input[name='sort']").val(sort);
			$("select[name='orderby'] option[value='"+orderby+"']").attr("selected",true);
			$("input[name='keyword']").focus();
			$(".chk").attr('checked', false);
			$("#barcodeFrm").attr('method', 'get');
			$("#barcodeFrm").submit();
		});

		//엑셀 다운로드 버튼 클릭
		$('button[name="excel_down"]').click(function(){
			var mode = $(this).attr('value');

			if(mode == 'select' && $('.chk:checked').length == 0){
				openDialogAlert('다운로드 할 바코드정보를 선택해 주세요.');
				return false;
			}

			$("#barcodeFrm input[name='mode']").val(mode);
			var queryString = $("#barcodeFrm").serializeArray();
			ajaxexceldown('/admin/barcode_process/exceldownload', queryString);
			$("#barcodeFrm input[name='mode']").val('');
		});

		//엑셀 다운로드 액션폼 생성 함수
		function ajaxexceldown(url, queryString){
			var inputs = "";
			 jQuery.each(queryString, function(i, field){
				 inputs +='<input type="hidden" name="'+field.name+'" value="'+ field.value +'" />';
			 });
			jQuery('<form action="'+ url +'" method="post" target="actionFrame" >'+inputs+'</form>')
			.appendTo('body').submit().remove();
		}

		//바코드 타입 변경 팝업
		$('button[name="codetype_btn"]').click(function(){
			openDialog("바코드 형식 변경", "barcode_type_popup", {"width":"790","height":"350","show" : "fade","hide" : "fade"});
		});

		//바코드 타입 변경 저장 버튼
		$('button[name="barcode_btn"]').click(function(){

		});

		//바코드 출력 팝업
		$('button[name="excel_upload"]').click(function(){
			var mode = $(this).attr('mode');

			if(mode == 'select' && $('.chk:checked').length == 0){
				openDialogAlert('출력할 상품을 선택하세요.');
				return false;
			}

			window.open("", "barcode", "width=960, height=640");
			var tempFrm = $('#barcodeFrm').clone();

			$(tempFrm).attr('target', 'barcode');
			$(tempFrm).attr('method', 'post');
			$(tempFrm).attr('action', 'barcode_print');
			$(tempFrm).find('input[name="mode"]').val(mode);
			$(tempFrm).find('input[name="total_ea"]').remove();
			$(tempFrm).find('input[name="orderby"]').remove();
			$(tempFrm).find('input[name="stock"]').remove();
			$(tempFrm).find('input[name="sort"]').remove();
			$('body').append(tempFrm);
			$(tempFrm).submit();
			$(tempFrm).remove();
		});
	});

	function searchformchange(){
		$(".chk").attr('checked', false);
		$("#barcodeFrm").attr('method', 'get');
		$('#barcodeFrm').submit();
	}
</script>
<style>
	div.sub-choose-lay div.choose-form-lay {top:27px;right:0;width:200px;}
	div.sub-choose-lay div.choose-down-lay {top:27px;right:20px;width:150px;}
	table.list-table-style tbody.ltb td {border: 1px solid #eaeaea; padding: 3px; }
	table.list-table-style tbody.ltb td input { width: 90% }
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>바코드 출력</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span id="barcode_info" class="btn large orange"><button type="button">바코드 정보 입력방법</button></span></li>
			<li><span id="barcode_write" class="btn large orange"><button type="button">일괄 등록</button></span></li>
			<li><a href="barcode_write_excel"><span class="btn large orange"><button type="button"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> 일괄등록</button></span></a></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large"><button name="codetype_btn"><?php echo $TPL_VAR["use_code_order"]["code_name"]?>/<?php echo $TPL_VAR["use_code"]["code_name"]?></button></span></li>
			<li><span class="btn large"><button name="excel_upload" mode="all">바코드 전체 출력</button></span></li>
			<li><span class="btn large"><button name="excel_upload" mode="select">바코드 선택 출력</button></span></li>
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!--검색 폼-->
<form name="barcodeFrm" id="barcodeFrm" method="get" action="">
<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sort"]?>"/>
<input type="hidden" name="mode" value=""/>

<!-- 바코드 검색폼 : 시작 -->
<?php $this->print_("barcode_search_form",$TPL_SCP,1);?>

<!-- 바코드 검색폼 : 끝 -->

<div class="clearbox">
	<ul class="left-btns clearbox">
		<li><div class="left-btns-txt">
<?php if($TPL_VAR["search_yn"]=='y'){?>
		검색 <b><?php echo number_format($TPL_VAR["page"]["totalcount"])?></b> 개
<?php }else{?>
		총 <b><?php echo number_format($TPL_VAR["page"]["totalcount"])?></b> 개</div>
<?php }?>
		</li>
	</ul>
	<ul class="right-btns clearbox">
		<li>
			<!-- <select class="custom-select-box-multi" name="excel_type" id="excel_type"> -->
				<!-- <option value="">상품바코드</option> -->
				<!-- <option value="select">선택 다운로드</option> -->
				<!-- <option value="search">검색 다운로드</option> -->
			<!-- </select> -->
			<span class="btn small"><button type="button" name="excel_down" value="select"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> 선택 다운로드</button></span>
			<span class="btn small"><button type="button" name="excel_down" value="search"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> 검색 다운로드</button></span>
		</li>
		<li>
			<select class="custom-select-box-multi" name="orderby" onchange="searchformchange();">
				<option value="">정렬선택</option>
				<option value="asc_goods_seq"	<?php if($TPL_VAR["sorderby"]=='asc_goods_seq'){?>selected<?php }?>     >상품번호↑</option>
				<option value="desc_goods_seq"	<?php if($TPL_VAR["sorderby"]=='desc_goods_seq'){?>selected<?php }?>    >상품번호↓</option>
				<option value="asc_goods_name"	<?php if($TPL_VAR["sorderby"]=='asc_goods_name'){?>selected<?php }?> >상품명↑</option>
				<option value="desc_goods_name"	<?php if($TPL_VAR["sorderby"]=='desc_goods_name'){?>selected<?php }?>>상품명↓</option>
				<option value="asc_barcode"		<?php if($TPL_VAR["sorderby"]=='asc_barcode'){?>selected<?php }?>    >바코드↑</option>
				<option value="desc_barcode"	<?php if($TPL_VAR["sorderby"]=='desc_barcode'){?>selected<?php }?>   >바코드↓</option>
			</select>
		</li>
		<li>
			<select  class="custom-select-box-multi" name="perpage" onchange="searchformchange();">
				<option value="10"  <?php if($TPL_VAR["perpage"]== 10){?>  selected<?php }?> >10개씩</option>
				<option value="50"  <?php if($TPL_VAR["perpage"]== 50){?>  selected<?php }?> >50개씩</option>
				<option value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
				<option value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
			</select>
		</li>
	</ul>
</div>

<!-- 주문리스트 테이블 : 시작 -->
<table class="list-table-style" cellspacing="0" style="border-collapse: collapse;">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="3%" />
		<col width="3%" />
		<col width="7%" />
		<col width="7%" />
		<col width="7%" />
		<col width="4%"/>
		<col width="4%" />
		<col width="*" />
		<col width="15%" />
		<col width="10%" />
		<col width="10%" />
	</colgroup>
	<thead class="lth">
		<tr class="double-row th" >
			<th rowspan="2"><input type="checkbox" id="chkAll" /></th>
			<th rowspan="2">번호</th>
			<th style="padding: 5px 0px;">
				출력수<br/>
				<select class="sel-stock" name="stock">
					<option value="0">현재재고</option>
					<option value="1">직접입력</option>
				</select>
			</th>
			<th colspan="2"><span class="btnSort hand" orderby="barcode" title="[바코드]로 정렬">바코드(상품코드)<?php if($TPL_VAR["sorderby"]=='asc_barcode'){?>▲<?php }elseif($TPL_VAR["sorderby"]=='desc_barcode'){?>▼<?php }?></span></th>
			<th rowspan="2"><span class="btnSort hand" orderby="goods_seq" title="[상품번호]로 정렬">상품번호<?php if($TPL_VAR["sorderby"]=='asc_goods_seq'){?>▲<?php }elseif($TPL_VAR["sorderby"]=='desc_goods_seq'){?>▼<?php }?></span></th>
			<th rowspan="2">옵션번호</th>
			<th rowspan="2"><span class="btnSort hand" orderby="goods_name" title="[상품명]으로 정렬">상품명<?php if($TPL_VAR["sorderby"]=='asc_goods_name'){?>▲<?php }elseif($TPL_VAR["sorderby"]=='desc_goods_name'){?>▼<?php }?></span></th>
			<th rowspan="2">옵션명</th>
			<th colspan="2"><?php echo $TPL_VAR["store_col"]?></th>
		</tr>
		<tr class="double-row th">
			<th>
				<input style="width: 50%" type="text" id="target_stock" disabled="disabled" />
				<span class="btn small gray">&nbsp;<button type="button" id="btn_all_stock">▼</button></span>
			</th>
			<th>기본코드</th>
			<th>옵션코드</th>
			<th>재고</th>
			<th>불량재고</th>
		</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["listdata"]){?>
<?php if($TPL_listdata_1){foreach($TPL_VAR["listdata"] as $TPL_V1){?>
		<tr class="list-row">
			<td align="center">
				<input type="hidden" class="total_ea" value="<?php echo $TPL_V1["total_ea"]?>"/>
				<input type="checkbox" class="chk" name="goods_seq[<?php echo $TPL_V1["_rno"]?>]" value="<?php echo $TPL_V1["goods_seq"]?>|<?php echo $TPL_V1["option_seq"]?>" />
			</td>
			<td align="center"><?php echo $TPL_V1["_rno"]?></td>
			<td>
				<input type="hidden" class="tmp_stock" value="<?php echo $TPL_V1["total_ea"]?>"/>
				<input type="text" class="chk_stock" name="goods_stock[<?php echo $TPL_V1["_rno"]?>]" value="<?php echo $TPL_V1["total_ea"]?>"/>
			</td>
			<td><?php echo $TPL_V1["goods_code"]?></td>
			<td><?php echo $TPL_V1["option_code"]?></td>
			<td><?php echo $TPL_V1["goods_seq"]?></td>
			<td><?php echo $TPL_V1["option_seq"]?></td>
			<td><a href="/admin/goods/regist?query_string=&no=<?php echo $TPL_V1["goods_seq"]?>"><?php echo $TPL_V1["goods_name"]?></a></td>
			<td><?php echo $TPL_V1["option_title"]?></td>
			<td align="right"><?php echo $TPL_V1["prefix"]?><?php echo $TPL_V1["total_ea"]?><?php echo $TPL_V1["suffix"]?></td>
			<td align="right">(<?php echo $TPL_V1["total_bad_ea"]?>)</td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" colspan="11">
<?php if($TPL_VAR["keyword"]){?>
				'<?php echo $TPL_VAR["keyword"]?>' 검색된 바코드가 없습니다.
<?php }else{?>
				등록된 바코드가 없습니다.
<?php }?>
		</td>
	</tr>
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->

</table>
<!-- 주문리스트 테이블 : 끝 -->
</form>

<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

<?php $this->print_("barcode_info_popup",$TPL_SCP,1);?>

<style type="text/css">
	#barcode_type_popup .cont { margin: 20px 0px; }
	#barcode_type_popup .cont p { padding: 20px; }
	#barcode_type_popup .cont p label { margin-right: 10px; }
</style>
<div id="barcode_type_popup" class="hide">
	<form id="bartypeFrm" name="bartypeFrm" method="post" action="../barcode_process/set_barcodeid" target="actionFrame">
		<h3>바코드 형식 변경</h3>
		<div class="cont">
			<h4>1. 주문, 출고번호 바코드 형식</h4>
			<p>
				<label><input type="radio" name="use_code_order" value="code39" <?php if($TPL_VAR["use_code_order"]["id"]=='code39'){?>checked="checked"<?php }?>/> Code 39</label>
				<label><input type="radio" name="use_code_order" value="code128_a" <?php if($TPL_VAR["use_code_order"]["id"]=='code128_a'){?>checked="checked"<?php }?>/> Code 128-A</label>
				<label><input type="radio" name="use_code_order" value="code128_b" <?php if($TPL_VAR["use_code_order"]["id"]=='code128_b'){?>checked="checked"<?php }?>/> Code 128-B</label>
			</p>
		</div>
		<div class="cont">
			<h4>2. 상품 바코드 형식</h4>
			<span style="color: #777; font-size: 9pt">※ ISBN 바코드 체계로 입력된 상품은 ISBN으로 자동 출력됩니다.</span>
			<p>
				<label><input type="radio" name="use_code" value="code39" <?php if($TPL_VAR["use_code"]["id"]=='code39'){?>checked="checked"<?php }?>/> Code 39 + ISBN</label>
				<label><input type="radio" name="use_code" value="code128_a" <?php if($TPL_VAR["use_code"]["id"]=='code128_a'){?>checked="checked"<?php }?>/> Code 128-A + ISBN</label>
				<label style="width: 250px"><input type="radio" name="use_code" value="code128_b" <?php if($TPL_VAR["use_code"]["id"]=='code128_b'){?>checked="checked"<?php }?>/> Code 128-B + ISBN</label>
				<label><input type="radio" name="use_code" value="code128_c" <?php if($TPL_VAR["use_code"]["id"]=='code128_c'){?>checked="checked"<?php }?>/> Code 128-C + ISBN</label>
				<!-- <label><input type="radio" name="use_code" value="isbn" <?php if($TPL_VAR["use_code"]["id"]=='isbn'){?>checked="checked"<?php }?>/> ISBN</label> -->
			</p>
		</div>
		<div class="center">
			<span class="btn small cyanblue"><button type="submit" name="barcode_btn">저장</button></span>
		</div>
	</form>
</div>
<div id="goods_scm_warehouse_info" class="hide"></div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>