<?php /* Template_ 2.2.6 2022/05/30 14:55:18 /www/music_brother_firstmall_kr/admin/skin/default/excel/excel_download.html 000009042 */ 
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>

<style type="text/css">
	.footer.search_btn_lay{top: auto; left: calc(50% - 50px);}
</style>

<script type="text/javascript">
	var gl_first_goods_date = '<?php echo $TPL_VAR["config_system"]["first_goods_date"]?>';
<?php if(is_array($TPL_R1=code_load('currency',$TPL_VAR["config_system"]["basic_currency"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	var gl_basic_currency_hangul		= '<?php echo $TPL_V1["value"]["hangul"]?>';
	var gl_basic_currency_nation		= '<?php echo $TPL_V1["value"]["nation"]?>';
<?php }}?>

	//jquery 스크립트 로드
	$(document).ready(function() {

		gSearchForm.init({'pageid':'excel_download','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>'});

		//입점사 선택 시(입점형 일때만)
<?php if(serviceLimit('H_AD')==true){?>
		$("select[name='provider_seq']").on('change',function(){
			var provider_seq = $(this).val();

			if(provider_seq > 0){
				$("input[name='provider_name']").css("background-color", "#EEE").attr("readonly", true).val('');
			} else {
				$("input[name='provider_name']").css("background-color", "").attr("readonly", false);
			}
		});
<?php }?>

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
						/* 2021.12.30 11월 3차 패치 by 김혜진 */
						if(args.indexOf("[Error]") >= 0) {
							alert(args);
						} else if(args.indexOf('openDialogAlert') >= 0) {
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
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layer_stock.css" />

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>엑셀 다운로드</h2>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 상품 검색폼 : 시작 -->
<div  id="search_container"  class="search_container">
	<form name="searchForm" id="searchForm" method="get" action="/admin/excel_spout/excel_download">
		<table class="table_search">
			<tr>
				<th>구분</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" id="category" name="category" value="0" <?php if($TPL_VAR["category"]== 0){?> checked<?php }?> />	전체</label>
						<label><input type="radio" id="category_goods" name="category" value="1" <?php if($TPL_VAR["category"]== 1){?> checked<?php }?> /> 상품</label>
						<label><input type="radio" id="category_order" name="category" value="2" <?php if($TPL_VAR["category"]== 2){?> checked<?php }?> /> 주문</label>
						<label><input type="radio" id="category_member" name="category" value="3" <?php if($TPL_VAR["category"]== 3){?> checked<?php }?> /> 회원</label>
						<label><input type="radio" id="category_export" name="category" value="4" <?php if($TPL_VAR["category"]== 4){?> checked<?php }?> /> 출고</label>
					</div>
				</td>
			</tr>
<?php if(serviceLimit('H_AD')==true){?>
			<tr>
				<th>입점사</th>
				<td>
					<div class="ui-widget">
						<select name="provider_seq" style="width:160px;">
							<option value="0" <?php if($TPL_VAR["provider_seq"]== 0){?> selected<?php }?>>- 입점사 검색 -</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["provider_seq"]?>" <?php if($TPL_VAR["provider_seq"]==$TPL_V1["provider_seq"]){?> selected<?php }?>><?php if($TPL_V1["provider_seq"]== 1){?>본사매입<?php }else{?><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)<?php }?></option>
<?php }}?>
						</select>
					</div>
					<span class="ptc-charges hide"></span>
				</td>
			</tr>
<?php }?>
		</table>
		<div class="footer search_btn_lay"></div>
	</form>
</div>
<!-- 상품 검색폼 : 끝 -->

<div class="contents_container">

	<div class="list_info_container">
		<div class="dvs_left">
			검색 <b>0</b>개 (총 <b><?php echo $TPL_VAR["excel_total"]?></b>개)
		</div>
		<div class="dvs_right">
			<select  name="perpage">
				<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
				<option id="dp_qty50" value="50" <?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?> >50개씩</option>
				<option id="dp_qty100" value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
				<option id="dp_qty200" value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
			</select>
		</div>
	</div>


	<!-- 주문리스트 테이블 : 시작 -->
	<table class="table_row_basic tdc">
		<!-- 테이블 헤더 : 시작 -->
		<colgroup>
			<col width="80" /><!--번호-->
			<col width="100" /><!--구분-->
			<col width="150" /><!--요청일시-->
<?php if(serviceLimit('H_AD')==true){?><col width="120" /><?php }?><!--요청사-->
			<col width="100"/><!--요청자-->
			<col width="120" /><!--요청내용-->
			<col width="90" /><!--요청건수-->
			<col width="85" /><!--상태-->
			<col width="150" /><!--완료일시-->
			<col width="90" /><!--다운로드-->
			<col width="215" /><!--다운로드 가능 기간-->
		</colgroup>
		<thead class="lth">
		<tr>
			<th>번호</th>
			<th>구분</th>
			<th>요청일시</th>
<?php if(serviceLimit('H_AD')==true){?><th>요청사</th><?php }?>
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
		<tr class="list-row">
			<td class="page_no"><?php echo $TPL_V1["no"]?></td>
			<td class="category"><?php echo $TPL_V1["categoryKR"]?></td>
			<td class="request_date"><?php echo $TPL_V1["reg_date"]?></td>
<?php if(serviceLimit('H_AD')==true){?><td class="provider_id"><?php echo $TPL_V1["provider_name"]?></td><?php }?>
			<td class="request_user"><?php echo $TPL_V1["manager_id"]?></td>
			<td class="request_type"><?php echo $TPL_V1["excel_type"]?></td>
			<td class="count"><?php echo $TPL_V1["count"]?></td>
			<td class="status"><?php echo $TPL_V1["state"]?></td>
			<td class="complete_date"><?php echo $TPL_V1["com_date"]?></td>
			<td class="download">
<?php if($TPL_V1["state"]=="완료"){?>
				<button type="button" class="excel_download resp_btn" value='<?php echo $TPL_V1["category"]?>|<?php echo $TPL_V1["id"]?>'>다운로드</button>
<?php }else{?>
				<?php echo $TPL_V1["state"]?>

<?php }?>
			</td>
			<td class="expired_date"><?php echo $TPL_V1["expired_date"]?></td>
		</tr>
<?php }}?>
		<!-- 리스트 끝 -->
<?php }else{?>
		<!-- 리스트 없으면 -->
		<tr class="list-row">
			<td class="center" height="40" colspan="<?php if(serviceLimit('H_AD')==true){?>11<?php }else{?>10<?php }?>">등록된 <?php echo $TPL_VAR["category_info_kr"][$TPL_VAR["sc"]["category"]]?> 다운로드가 없습니다.</td>
		</tr>
<?php }?>
		</tbody>
		<!-- 끝 -->

	</table>
	<!-- 주문리스트 테이블 : 끝 -->

	<!-- 페이징 -->
	<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
</div>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>