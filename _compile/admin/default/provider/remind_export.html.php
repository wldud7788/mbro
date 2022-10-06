<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/provider/remind_export.html 000006549 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript">
	var scObj = <?php echo $TPL_VAR["scObj"]?>;
	$('document').ready(function () {
		remindExportList.init();
	});
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>주문 미처리 현황</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브메뉴 바디 : 시작-->
<div id="search_container" class="search_container">
	<form name="remindExportForm" id="remindExportForm" class="search_form">
		<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sc"]["sort"]?>" />
		<input type="hidden" name="searchcount" value="<?php echo $TPL_VAR["sc"]["searchcount"]?>" />
		<input type="hidden" name="perpage" id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" />
		<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["sc"]["page"]?>" data-defaultPage=0>

		<table class="table_search">
			<tr data-fid='sc_provider'>
				<th><span>입점사</span></th>
				<td>
					<select name="provider_seq_selector"></select>
					<input type="hidden" class="provider_seq" name="provider_seq" value=''>
				</td>
			</tr>

			<tr data-fid='sc_regdate'>
				<th><span>결제일</span></th>
				<td>
					<div class="date_range_form">
						<input type="text" name="regdate[]" value="<?php echo $TPL_VAR["sc"]["regdate"][ 0]?>" class="datepicker sdate"
							maxlength="10" />
						-
						<input type="text" name="regdate[]" value="<?php echo $TPL_VAR["sc"]["regdate"][ 1]?>" class="datepicker edate"
							options="fnDatepicker('max', '-3')" maxlength="10" />
						<div class="resp_btn_wrap">
							<input type="button" range="7days_untill_end_date" value="7일"
								class="select_date resp_btn" />
							<input type="button" range="15days_untill_end_date" value="15일"
								class="select_date resp_btn" />
							<input type="button" range="30days_untill_end_date" value="30일"
								class="select_date resp_btn" />
							<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input"
								type="hidden" />
						</div>
					</div>
				</td>
			</tr>

			<tr data-fid='sc_info_type'>
				<th><span>물류 담당자 정보</span></th>
				<td>
					<div class="resp_checkbox">
						<label><input type="checkbox" name="found_info_mobile[]" value="Y" <?php if(in_array('Y',$TPL_VAR["sc"]["found_info_mobile"])){?>checked<?php }?> /> 있음</label>
						<label><input type="checkbox" name="found_info_mobile[]" value="N" <?php if(in_array('N',$TPL_VAR["sc"]["found_info_mobile"])){?>checked<?php }?> /> 없음</label>
					</div>
				</td>
			</tr>

		</table>
		<div class="search_btn_lay center mt10"></div>
</div>

<div class="contents_dvs v2">
	<div class="list_info_container">
		<div class="dvs_left">
			<div class="left-btns-txt">검색 <b><?php echo number_format($TPL_VAR["page"]["searchcount"])?></b>개</div>
		</div>
		<div class="dvs_right">
			<span class="display_sort" sort="<?php echo $TPL_VAR["sc"]["display_sort"]?>"></span>
			<span class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></span>
		</div>
	</div>
	</form>
	<table class="table_row_basic">
		<colgroup>
			<col width="5%" />
			<col width="8%" />
			<col width="12%" />
			<col width="15%" />
			<col width="10%" />
			<col width="15%" />
			<col width="9%" />
			<col width="9%" />
			<col width="9%" />
			<col width="18%" />
		</colgroup>
		<thead>
			<tr>
				<th>번호</th>
				<th>상태</th>
				<th>입점사 ID</th>
				<th>입점사명 (코드)</th>
				<th>사업자</th>
				<th>물류담당자</th>
				<th>결제확인</th>
				<th>상품준비</th>
				<th>출고준비</th>
				<th>문자발송</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["_no"]?></td>
				<td><?php echo $TPL_V1["provider_status"]?></td>
				<td class="left"><a href="provider_reg?no=<?php echo $TPL_V1["provider_seq"]?>" class="resp_btn_txt v2"
						target="_blank"><?php echo $TPL_V1["provider_id"]?></a></td>
				<td class="left"><a href="provider_reg?no=<?php echo $TPL_V1["provider_seq"]?>" class="resp_btn_txt v2"
						target="_blank"><?php echo $TPL_V1["provider_name"]?></a> (<?php echo $TPL_V1["provider_seq"]?>)</td>
				<td><?php echo $TPL_V1["info_type"]?></td>
				<td><?php if($TPL_V1["person_mobile1"]!=""){?> <?php echo $TPL_V1["person_mobile1"]?> <?php }?>
<?php if($TPL_V1["person_mobile2"]!=""){?> <?php if($TPL_V1["person_mobile1"]!=""){?></br><?php }?> <?php echo $TPL_V1["person_mobile2"]?> <?php }?>
				</td>
				<td><?php echo $TPL_V1["step_25_count"]?></td>
				<td><?php echo $TPL_V1["step_35_count"]?></td>
				<td><?php echo $TPL_V1["step_45_count"]?></td>
				<td>
					<button type="button"
						onClick="remindExportList.send_sms_provider('<?php echo $TPL_V1["provider_seq"]?>', '<?php echo $TPL_V1["provider_name"]?>', '<?php echo $TPL_V1["person_mobile1"]?>', '<?php echo $TPL_V1["person_mobile2"]?>')"
						class="send_sms_provider resp_btn v2"> 문자발송</button>
				</td>
			</tr>
<?php }}?>
<?php }else{?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr>
				<td colspan="10">
					미처리 출고 건이 없습니다.
				</td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }?>
		</tbody>
	</table>
</div>

<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

<div class="box_style_05 mt20">
	<div class="title">안내</div>
	<ul class="bullet_hyphen ">
		<li>검색한 결제일 동안 입점사에서 미발송한 상품이 있는 경우 미발송 상품 수(추가구성 옵션 상품 포함)를 카운트해서 표시합니다.</li>
		<li>결제일 3일이 지난 주문부터 검색할 수 있습니다.</li>
	</ul>
</div>

<div id="sendPopup">
	<div id="sms_form"></div>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>