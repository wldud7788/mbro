<?php /* Template_ 2.2.6 2022/05/30 15:17:55 /www/music_brother_firstmall_kr/admin/skin/default/member/curation_history_sms.html 000005056 */ 
$TPL_curationmn_1=empty($TPL_VAR["curationmn"])||!is_array($TPL_VAR["curationmn"])?0:count($TPL_VAR["curationmn"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		gSearchForm.init({'pageid':'curation_history_sms','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>'});

		$("#btn_submit").click(function(){
			$("#gabiaFrm").submit();
		});
	});
</script>
<style type="text/css">
	.footer.search_btn_lay{top: auto; left: calc(50% - 50px);}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title"><h2>고객 리마인드</h2></div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">
	<!-- 상단 단계 링크 : 시작 -->
<?php $this->print_("top_menu",$TPL_SCP,1);?>

	<!-- 상단 단계 링크 : 끝 -->

	<!-- 서브 레이아웃 영역 : 시작 -->
	<div id="search_container"  class="search_container">
		<form name="gabiaFrm" id="gabiaFrm"  class='search_form'>
		<input type="hidden" name="sc_gb" value="<?php echo $TPL_VAR["sc_gb"]?>">
			<table class="table_search">		
				<tr>
					<th>제목</th>
					<td>
						<input type="text" name="sc_subject" size="80" value="<?php echo $TPL_VAR["sc"]["sc_subject"]?>" />
					</td>
				</tr>
				<tr>
					<th>리마인드 종류</th>
					<td>
						<select name="sc_kind">
							<option value="">전체</option>
<?php if($TPL_curationmn_1){foreach($TPL_VAR["curationmn"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_V1["name"]==$TPL_VAR["sc"]["sc_kind"]){?> selected<?php }?>><?php echo $TPL_V1["title"]?></option>
<?php }}?>
						</select>
					</td>
				</tr>
				<tr>
					<th>발송일</th>
					<td>
						<div class="date_range_form">
							<input type="text" name="start_date" value="<?php echo $TPL_VAR["sc"]["start_date"]?>" class="datepicker sdate"  maxlength="10" size="10" />
							-
							<input type="text" name="end_date" value="<?php echo $TPL_VAR["sc"]["end_date"]?>" class="datepicker edate" maxlength="10" size="10" />
								
							<div class="resp_btn_wrap">
								<input type="button" range="today" value="오늘" class="select_date resp_btn" />
								<input type="button" range="3day" value="3일간" class="select_date resp_btn" />
								<input type="button" range="1week" value="일주일" class="select_date resp_btn" />
								<input type="button" range="1month" value="1개월" class="select_date resp_btn" />
								<input type="button" range="3month" value="3개월" class="select_date resp_btn" />
								<input type="button" range="all"  value="전체" class="select_date resp_btn"/>
								<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden" />
							</div>
						</div>
					</td>
				</tr>			
			</table>

			<div class="footer search_btn_lay"></div>
		</form>
	</div>

	<div class="list_info_container">
		<div class="dvs_left">	
			검색 <b><?php echo number_format($TPL_VAR["sc"]["searchcount"])?></b>개 (총 <b><?php echo number_format($TPL_VAR["sc"]["totalcount"])?></b>개)
		</div>		
	</div>

	<!-- 주문리스트 테이블 : 시작 -->
	<table class="table_row_basic tdc">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="8%" />
		<col width="20%" />
		<col />
		<col width="12%" />
		<col width="12%" />
	</colgroup>
	<thead class="lth">
	<tr>
		<th>번호</th>
		<th>리마인드 종류</th>
		<th>SMS 제목</th>
		<th>발송 요청일</th>
		<th>발송 완료일</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->
		<tbody class="ltb otb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr class="list-row email_select">
				<td><?php echo $TPL_V1["number"]?></td>
				<td><?php echo $TPL_V1["kind_name"]?></td>
				<td class="left"><?php echo $TPL_V1["sms_msg"]?></td>
				<td><?php echo $TPL_V1["regist_date"]?></td>
				<td><?php echo $TPL_V1["reserve_date"]?></td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }}?>
<?php }else{?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr class="list-row">
				<td align="center" colspan="5">SMS 발송 내역이 없습니다.</td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }?>
		</tbody>
		<!-- 리스트 : 끝 -->

	</table>
	<!-- 주문리스트 테이블 : 끝 -->

	<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?> </div>
</div>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>