<?php /* Template_ 2.2.6 2022/05/17 12:29:27 /www/music_brother_firstmall_kr/selleradmin/skin/default/referer/catalog.html 000006888 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=20200601"></script>
<script type="text/javascript">
$(function(){

	gSearchForm.init({'pageid':'referer_catalog','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>'});

	$("button#regist").live('click', function(){
		location.href	= './referersale';
	});

	$("input[name='modify_btn']").each(function(){
		$(this).click(function(){
			location.href	= './referersale?no='+$(this).attr('referersaleSeq');
		});
	});

	$('#display_quantity').bind('change', function() {
		$("#perpage").val($(this).val());
		$("#referersearch").submit();
	});
});
</script>
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar"  >

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>유입경로 할인</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<!-- 리스트검색폼 : 시작 -->

<div id="search_container" class="search_container">
	<form name="referersearch" id="referersearch" method="get">
	<input type="hidden" name="perpage" id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" >
	<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["sc"]["page"]?>" >
	<table class="table_search">
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_keyword" class="hide"></label> 검색어</th>
			<td>
				<select name="search_field" class="resp_select">
					<option value="" <?php echo $TPL_VAR["sc"]['selectbox']['search_field']['all']?>>전체</option>
					<option value="referersale_name" <?php echo $TPL_VAR["sc"]['selectbox']['search_field']['referersale_name']?>>유입경로명</option>
					<option value="referersale_url" <?php echo $TPL_VAR["sc"]['selectbox']['search_field']['referersale_url']?>>유입경로 URL</option>			
				</select>
				<input type="text" name="search_text" id="search_text" value="<?php echo $TPL_VAR["sc"]["search_text"]?>" size="80" />
			</td>
		</tr>

		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_regist_date" class="hide"></label> 등록일</th>
			<td>
				<div class="date_range_form">
					<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10" style="width:80px" />
					-
					<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10" style="width:80px" />
					
					<div class="resp_btn_warp">
						<input type="button" range="today" value="오늘" class="select_date resp_btn"/>
						<input type="button" range="3day" value="3일간" class="select_date resp_btn"/>
						<input type="button" range="1week" value="일주일" class="select_date resp_btn"/>
						<input type="button" range="1month" value="1개월" class="select_date resp_btn"/>
						<input type="button" range="3month" value="3개월" class="select_date resp_btn"/>
						<input type="button" range="select_date_all"  value="전체" class="select_date resp_btn"/>
						<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden" />
					</div>
				</div>
			</td>
		</tr>

		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_cost_type" class="hide"></label> 할인 혜택 부담</th>
			<td>
				<select name="cost_type" class="search_select">
					<option value="admin" <?php if($TPL_VAR["sc"]["cost_type"]=='admin'){?>selected<?php }?>>본사 부담율</option>
					<option value="provider" <?php if($TPL_VAR["sc"]["cost_type"]=='provider'){?>selected<?php }?>>입점사 부담율</option>
				</select>	

				<input type="text" name="search_cost_start" size="3" maxlength="3" value="<?php echo $TPL_VAR["sc"]["search_cost_start"]?>" defaultValue='0' class="onlynumber right" /> %
				~ 
				<input type="text" name="search_cost_end" size="3" maxlength="3" value="<?php echo $TPL_VAR["sc"]["search_cost_end"]?>" defaultValue='100' class="onlynumber right" /> %
				(0~100사이)	
			</td>
		</tr>
	</table>


	<div class="search_btn_lay center mt10 footer"></div>
</form>
</div>
<div class="cboth"></div>
<!-- 리스트검색폼 : 끝 -->

<div class="contents_container">
	<div class="list_info_container">
		<div class="dvs_left">
			<div class="left-btns-txt">
			검색 <b><?php echo number_format($TPL_VAR["page"]["searchcount"])?></b>개 (총 <b><?php echo number_format($TPL_VAR["page"]["totalcount"])?></b>개)
		</div>
		</div>

		<div class="dvs_right"><div class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></div></div>
	</div>
		
	<table class="table_row_basic">		
		<colgroup>
			<col width="10%" />
			<col width="15%" />
			<col width="20%" />	
			<col width="15%" />
			<col width="10%" />
			<col width="10%" />	
			<col width="10%" />
			<col width="10%" />
		</colgroup>
		
		<thead>
			<tr>
				<th>번호</th>
				<th>유입경로명</th>
				<th>유입 경로 URL</th>
				<th>혜택</th>
				<th>유효기간</th>
				<th>등록일</th>
				<th>관리</th>			
			</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["list"]){?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["_no"]?></td>
				<td class="left"><a href="../referer/referersale?no=<?php echo $TPL_V1["referersale_seq"]?>"><?php echo $TPL_V1["referersale_name"]?></a></td>
				<td class="left"><?php echo $TPL_V1["referersale_url"]?></td>
				<td><?php echo $TPL_V1["salepricetitle"]?></td>				
				<td><?php echo $TPL_V1["validdate"]?></td>
				<td><?php echo $TPL_V1["date"]?></td>
				<td><input type="button" name="modify_btn" referersaleSeq="<?php echo $TPL_V1["referersale_seq"]?>"  value="보기" class="resp_btn v2"/></td>
			</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td colspan="7">
<?php if($TPL_VAR["search_text"]){?>'<?php echo $TPL_VAR["search_text"]?>' 검색된 유입경로할인이 없습니다.
<?php }else{?>등록된 유입경로할인이 없습니다.<?php }?>
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>
</div>


<!-- 서브 레이아웃 영역 : 끝 -->


<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>