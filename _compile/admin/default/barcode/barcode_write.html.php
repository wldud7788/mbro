<?php /* Template_ 2.2.6 2022/01/28 11:25:29 /www/music_brother_firstmall_kr/admin/skin/default/barcode/barcode_write.html 000004749 */ 
$TPL_listdata_1=empty($TPL_VAR["listdata"])||!is_array($TPL_VAR["listdata"])?0:count($TPL_VAR["listdata"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('YmdHis',$TPL_VAR["mktime"])?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/goodsBarcode.js?mm=<?php echo date('YmdHis',$TPL_VAR["mktime"])?>"></script>
<script type="text/javascript">
var scObj 		= <?php echo $TPL_VAR["scObj"]?>;
var pageid	 	= 'barcode_write';
</script>
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>바코드 일괄 등록</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><button type="button" class="resp_btn v3 size_L" onClick="document.location='catalog';">리스트 바로가기</button></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button type="button" name="barcode_update_btn" class="barcode_update resp_btn active2 size_L">저장</button></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->
<div id="search_container" class="search_container">
<form name="barcodeSearchForm" id="barcodeSearchForm" method="get" action="">
<input type="hidden" name="page" value="<?php echo $TPL_VAR["page"]["nowpage"]?>"/>
<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sort"]?>"/>
<input type="hidden" name="mode" value=""/>

<!-- 바코드 검색폼 : 시작 -->
<?php $this->print_("barcode_search_form",$TPL_SCP,1);?>

<!-- 바코드 검색폼 : 끝 -->
</form>
</div>
<form name="barcodeFrm" id="barcodeFrm" method="get" action="">
<div class="contents_container">
	<div class="list_info_container">
		<div class="dvs_left">	
			<div class="left-btns-txt">검색 <b><?php echo number_format($TPL_VAR["page"]["searchcount"])?></b> 개 (총 <b><?php echo number_format($TPL_VAR["page"]["totalcount"])?></b>개)</div>
		</div>
		<div class="dvs_right">	
			<span class="display_sort" sort="<?php echo $TPL_VAR["sc"]["sort"]?>"></span>
			<span class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></span>
		</div>
	</div>
	<div class="table_row_frame">
		<table class="table_row_basic">
		<!-- 테이블 헤더 : 시작 -->
		<colgroup>
			<col width="5%" />
			<col width="17%" />
			<col width="17%" />
			<col width="8%"/>
			<col width="8%" />
			<col width="*" />
			<col width="15%" />
		</colgroup>
		<thead class="lth">
			<tr>
				<th>번호</th>
				<th>기본코드</th>
				<th>옵션코드</th>
				<th>상품 번호</th>
				<th>옵션 번호</th>
				<th>상품명</th>
				<th>옵션명</th>		
			</tr>
		</thead>
		<!-- 테이블 헤더 : 끝 -->

		<!-- 리스트 : 시작 -->
		<tbody class="ltb">
<?php if($TPL_VAR["listdata"]){?>
<?php if($TPL_listdata_1){foreach($TPL_VAR["listdata"] as $TPL_V1){?>
			<tr>
				<td class="center">
					<?php echo $TPL_V1["_no"]?>

					<input type='hidden' name='goods_seq[]' value='<?php echo $TPL_V1["goods_seq"]?>'/>
					<input type='hidden' name='option_seq[]' value='<?php echo $TPL_V1["option_seq"]?>'/>
					<input type='hidden' name='is_goods_seq_duplicate[]' value='<?php echo $TPL_V1["is_goods_seq_duplicate"]?>'/>
				</td>
				<td>
<?php if($TPL_V1["is_goods_seq_duplicate"]){?>
						<input type='text' name='' value='' disabled="disabled"/>
						<input type='hidden' name='goods_code[]' value=''/>
<?php }else{?>
						<input type='text' name='goods_code[]' value='<?php echo $TPL_V1["goods_code"]?>'/>
<?php }?>
				</td>
				<td><input type='text' name='option_code[]' value='<?php echo $TPL_V1["option_code_cell"]?>'/></td>
				<td><?php echo $TPL_V1["goods_seq"]?></td>
				<td><?php echo $TPL_V1["option_seq"]?></td>
				<td class="left"><?php echo $TPL_V1["goods_name"]?></td>
				<td class="left"><?php echo $TPL_V1["option_title"]?></td>
			</tr>		
<?php }}?>
<?php }else{?>
		<tr>
			<td class="center" colspan="7">
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
	</div>
	<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>
</div>
</form>


<?php $this->print_("barcode_info_popup",$TPL_SCP,1);?>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>