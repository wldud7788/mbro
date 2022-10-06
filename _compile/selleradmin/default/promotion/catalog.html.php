<?php /* Template_ 2.2.6 2022/05/17 12:29:26 /www/music_brother_firstmall_kr/selleradmin/skin/default/promotion/catalog.html 000007949 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="euc-kr"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".promotioncodehelperbtn").click(function() {
		openDialog("할인 코드 안내", "promotioncodehelperlay", {"width":"800","height":"480","show" : "fade","hide" : "fade"});
	});

	$(":input[name=modifypromotion_btn]").live("click", function() {
		var seq = $(this).attr("promotion_seq");
		document.location.href='../promotion/view?no='+seq;
	});
	gSearchForm.init({'pageid':'promotion_catalog','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','defaultPage':0,'select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>'});
});
</script>
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar"  >
		<!-- 타이틀 -->
		<div class="page-title">
			<h2><span class="darkgray">할인 코드</h2>
		</div>	
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->

<!-- 리스트검색폼 : 시작 -->
<div id="search_container" class="search_container">

	<form name="promotionsearch" id="promotionsearch" >
	<input type="hidden" name="id" value="<?php echo $TPL_VAR["sc"]["id"]?>" >
	<input type="hidden" name="perpage" id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" >
	<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["sc"]["page"]?>" >
	<input type="hidden" name="orderby" id="orderby" value="<?php echo $TPL_VAR["sc"]["orderby"]?>" >
	<table class="table_search">
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_keyword" class="hide"></label> 할인 코드명</th>
			<td>
				<input type="text" name="search_text" id="search_text" value="<?php echo htmlspecialchars($TPL_VAR["sc"]["search_text"])?>" size="80" />
			</td>
		</tr>
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_promotion_type" class="hide"> 혜택 구분</label></th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="promotionType"  value="all"  <?php if(!$TPL_VAR["sc"]["promotionType"]||$TPL_VAR["sc"]["promotionType"]=='all'){?> checked <?php }?> /> 전체</label>
					<label><input type="radio" name="promotionType"  value="promotion"  <?php if($TPL_VAR["sc"]["promotionType"]=='promotion'){?> checked <?php }?> /> 상품</label>
					<label><input type="radio" name="promotionType"  value="promotion_shipping"  <?php if($TPL_VAR["sc"]["promotionType"]=='promotion_shipping'){?> checked <?php }?>/> 배송비</label>
				</div>
			</td>
		</tr>
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_promotion_type2" class="hide"> 코드 유형</label></th>
			<td>								
				<div class="resp_radio">
					<label><input type="radio" name="promotionType2" value="all"  <?php if(!$TPL_VAR["sc"]["promotionType2"]||$TPL_VAR["sc"]["promotionType2"]=='all'){?> checked <?php }?>/> 전체</label>
					<label><input type="radio" name="promotionType2" value="public"  <?php if($TPL_VAR["sc"]["promotionType2"]=='public'){?> checked <?php }?>/> 공용 코드</label>
					<label><input type="radio" name="promotionType2" value="disposable" <?php if($TPL_VAR["sc"]["promotionType2"]=='disposable'){?> checked <?php }?> /> 1회용 코드</label>
				</div>
			</td>
		</tr>
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_regist_date" class="hide"> 등록일</label></th>
			<td>
				<div class="date_range_form">
					<input type="text" name="sdate" id="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10" />
					-
					<input type="text" name="edate" id="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10" />
					<div class="resp_btn_warp">
						<input type="button" range="today" value="오늘" class="select_date resp_btn" />
						<input type="button" range="3day" value="3일간" class="select_date resp_btn" />
						<input type="button" range="1week" value="일주일" class="select_date resp_btn" />
						<input type="button" range="1month" value="1개월" class="select_date resp_btn" />
						<input type="button" range="3month" value="3개월" class="select_date resp_btn" />
						<input type="button" range="select_date_all"  value="전체" class="select_date resp_btn"/>
						<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden" />
					</div>
				</div>
			</td>
		</tr>		
	</table>

	<div class="search_btn_lay center mt10 footer"></div>
	</form>
</div>
<div class="cboth"></div>
<!-- 게시물리스트검색폼 : 끝 -->

<div class="contents_container">
	<div class="list_info_container">
		<div class="dvs_left">
			<div class="left-btns-txt">검색 <b><?php echo number_format($TPL_VAR["sc"]["searchcount"])?></b> 개 (총 <b><?php echo number_format($TPL_VAR["sc"]["totalcount"])?></b> 개)</div>
		</div>
		<div class="dvs_right"><div class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></div></div>
	</div>	
	
	<table class="table_row_basic">		
		<colgroup>
			<col width="7%" />
			<col width="7%" />
			<col width="8%" />
			<col width="18%" />
			<col width="8%" />
			<col width="12%" />
			<col width="11%" />
			<col width="10%" />
			<col width="10%" />
			<col width="9%" />
		</colgroup>
		<thead>
			<tr>
				<th>번호</th>
			<th>혜택 구분</th>			
				<th>코드 유형</th>
				<th>할인 코드명</th>
				<th>코드 정보</th>
				<th>혜택</th>
				<th>유효기간</th>
				<th>내역</th>
				<th>등록일</th>
				<th>관리</th>
			</tr>
		</thead>		
		<tbody>
<?php if($TPL_VAR["record"]){?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["_no"]?></td>
				<td><?php echo $TPL_V1["issuetypetitle"]?></td>
				<td><?php echo $TPL_V1["issueimgalt"]?></td>
				<td class="left">
					<a href="../promotion/view?no=<?php echo $TPL_V1["promotion_seq"]?>" class="resp_btn_txt v2"><?php echo $TPL_V1["promotion_name"]?></a>							
				</td>
				<td><?php if(strstr($TPL_V1["type"],'promotion')){?><?php echo $TPL_V1["promotion_input_serialnumber"]?><?php }else{?>개별 코드<?php }?></td>
				<td><?php echo $TPL_V1["salepricetitle"]?></td>
				<td><?php echo $TPL_V1["issuedate"]?></td>
				<td>발급 <?php echo $TPL_V1["downloadtotal"]?>건 / 사용 <?php echo $TPL_V1["usetotal"]?>건</td>
				<td><?php echo $TPL_V1["date"]?></td>
				<td><input type="button" name="modifypromotion_btn" promotion_seq="<?php echo $TPL_V1["promotion_seq"]?>"  value="보기" class="resp_btn v2"/></td>				
			</tr>
<?php }}?>
<?php }else{?>
			<tr >
				<td colspan="10">
<?php if($TPL_VAR["search_text"]){?>
						'<?php echo $TPL_VAR["search_text"]?>' 검색된 할인이 없습니다.
<?php }else{?>
						등록된 할인이 없습니다.
<?php }?>
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>
</div>

<!-- 서브 레이아웃 영역 : 끝 -->

<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>
<!-- 페이징 : 끝 -->

<div id="lay_promotion_issued"></div><!-- Popup :: 쿠폰 발급하기 -->



<?php $this->print_("layout_footer",$TPL_SCP,1);?>