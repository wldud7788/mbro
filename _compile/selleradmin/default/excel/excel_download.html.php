<?php /* Template_ 2.2.6 2022/05/17 12:29:05 /www/music_brother_firstmall_kr/selleradmin/skin/default/excel/excel_download.html 000008577 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript">
	var gl_first_goods_date = '<?php echo $TPL_VAR["config_system"]["first_goods_date"]?>';
<?php if(is_array($TPL_R1=code_load('currency',$TPL_VAR["config_system"]["basic_currency"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	var gl_basic_currency_hangul		= '<?php echo $TPL_V1["value"]["hangul"]?>';
	var gl_basic_currency_nation		= '<?php echo $TPL_V1["value"]["nation"]?>';
<?php }}?>
	
	//jquery 스크립트 로드
	$(document).ready(function() {
		//리스트 보기 갯수 변경 시
		$("select[name='perpage']").on('change',function(){
			$("form[name='searchForm']").submit();
		});

		//다운로드 하기
		$(".excel_download").on('click',function(){
			var params = $(this).val().split("|");
			var category = params[0];
			if(!category.length) {
				alert("[Error] 카테고리를 찾을 수 없습니다.");
				return false;
			}
			var file_id = params[1];

			if( file_id > 0 ){
				$.ajax({      
					type: 'GET',  
					url: '/admin/excel_spout/file_download',
					data: {type: 'list', category: category, id: file_id}, 
					success:function(args){ 
						if(args.indexOf("[Error]") >= 0){
							alert(args);
							<!-- 2022.01.03 11월 3차 패치 by 김혜진 -->
						}  else if(args.indexOf('openDialogAlert') >= 0) {
							$('body').append(args);
						} else {
							window.location.href = '/admin/excel_spout/file_download?url=' + args; 
						}
					}, error:function(e){  
						alert(e.responseText);  
					}  
				});
			} else {
				alert("[Error] 파일이름을 찾을 수 없습니다.");
				return false;
			}
		});
	});
</script>
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/layer_stock.css" />
<style>
	.goodsOptionTable {display:none; position:absolute; border-collapse:collapse; top:-10px; left:60px; border:1px solid #f5f5f5;}
	.goodsOptionTable table {width:220px;}
	.goodsOptionTable th {padding:5px; border:1px solid #ddd; background-color:#f5f5f5}
	.goodsOptionTable td {height:25px !important; border:1px solid #ddd; background-color:#ffffff; text-align:center;}

	div.sub-choose-lay div.choose-form-lay {top:27px;right:0;width:200px;}
	div.sub-choose-lay div.choose-down-lay {top:27px;right:140px;width:150px;}
	div.list-string-price-lay {position:relative;}
	div.list-string-price-lay img {cursor:pointer;}
	div.view-string-price-lay {position:absolute;top:20px;left:41px;width:300px;z-index:100;background-color:#fff;}
	.t_tot_stock {text-align:center; border-collapse:collapse; width:570px;}
	.t_tot_stock td {border:1px solid #666; padding:5px;}
	.gr_col {color:#666;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2><!--span class="icon-goods-kind-goods"></span-->엑셀 다운로드</h2>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<form name="searchForm" id="searchForm" method="get" action="/selleradmin/excel_spout/excel_download">

<!-- 상품 검색폼 : 시작 -->
<div class="search-form-container">
	<table class="search-form-table search_detail_form" id="serch_tab">
		<tr>
			<td>
				<table class="sf-option-table">
					<colgroup>
						<col width="70" /><col width="500" />
						<col width="70" /><col width="410" />
						<col width="70" /><col />
					</colgroup>
					<tr>
						<th>구분</th>
						<td>
							<input type="radio" id="category" name="category" value="0" <?php if($TPL_VAR["category"]== 0){?> checked<?php }?> />
							<label for="category">전체</label>
							<input type="radio" id="category_goods" name="category" value="1" <?php if($TPL_VAR["category"]== 1){?> checked<?php }?> />
							<label for="category_goods">상품</label>
							<input type="radio" id="category_order" name="category" value="2" <?php if($TPL_VAR["category"]== 2){?> checked<?php }?> />
							<label for="category_order">주문</label>
							<input type="radio" id="category_export" name="category" value="4" <?php if($TPL_VAR["category"]== 4){?> checked<?php }?> />
							<label for="category_export">출고</label>
							<button type="submit"><span>검색</span></button>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
<!-- 상품 검색폼 : 끝 -->

<div class="clearbox">
	<ul class="left-btns">
		<li>
			<div class="left-btns-txt" id="search_count" class="hide">
				총 <b><?php echo $TPL_VAR["excel_total"]?></b> 개
			</div>
		</li>
	</ul>
	<ul class="right-btns">		
		<li>
			<select  class="custom-select-box-multi" name="perpage">
				<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
				<option id="dp_qty50" value="50" <?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?> >50개씩</option>
				<option id="dp_qty100" value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
				<option id="dp_qty200" value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
			</select>
		</li>
	</ul>
</div>

<!-- 주문리스트 테이블 : 시작 -->
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="80" /><!--번호-->
		<col width="100" /><!--구분-->
		<col width="150" /><!--요청일시-->
		<col width="100"/><!--요청자-->
		<col width="120" /><!--요청내용-->
		<col width="80" /><!--요청건수-->
		<col width="85" /><!--상태-->
		<col width="150" /><!--완료일시-->
		<col width="80" /><!--다운로드-->
		<col width="215" /><!--다운로드 가능 기간-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th>번호</th>
		<th>구분</th>
		<th>요청일시</th>
		<th>요청자</th>
		<th>요청내용</th>
		<th>요청건수</th>
		<th>상태</th>
		<th>완료일시</th>
		<th>다운로드</th>
		<th>다운로드 가능 기간</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
	<!-- 리스트 있으면 -->
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<!-- 리스트 시작 -->
		<tr class="list-row" style="height:70px;">
			<td align="center" class="page_no"><?php echo $TPL_V1["no"]?></td>
			<td align="center" class="category"><?php echo $TPL_V1["categoryKR"]?></td>
			<td align="center" class="request_date"><?php echo $TPL_V1["reg_date"]?></td>
			<td align="center" class="request_user"><?php echo $TPL_V1["manager_id"]?></td>
			<td align="center" class="request_type"><?php echo $TPL_V1["excel_type"]?></td>
			<td align="center" class="count"><?php echo $TPL_V1["count"]?></td>
			<td align="center" class="status"><?php echo $TPL_V1["state"]?></td>
			<td align="center" class="complete_date"><?php echo $TPL_V1["com_date"]?></td>
			<td align="center" class="download">
<?php if($TPL_V1["state"]=="완료"){?> 
					<button type="button" class="excel_download" value='<?php echo $TPL_V1["category"]?>|<?php echo $TPL_V1["id"]?>'>다운로드</button>
<?php }else{?>
					<?php echo $TPL_V1["state"]?>

<?php }?>
			</td>
			<td align="center" class="expired_date"><?php echo $TPL_V1["expired_date"]?></td>
		</tr>
<?php }}?>
		<!-- 리스트 끝 -->
<?php }else{?>
	<!-- 리스트 없으면 -->
	<tr class="list-row">
		<td align="center" colspan="10">등록된 상품이 없습니다.</td>
	</tr>
<?php }?>
	</tbody>
	<!-- 끝 -->

</table>
<!-- 주문리스트 테이블 : 끝 -->
<div class="clearbox">
	<!-- 페이징 -->
	<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
</div>
</form>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>