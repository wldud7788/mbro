<?php /* Template_ 2.2.6 2022/05/30 15:13:56 /www/music_brother_firstmall_kr/admin/skin/default/member/withdrawal.html 000007697 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">

	$(document).ready(function() {
		gSearchForm.init({'pageid':'withdrawal'});
	});
	
</script>
<style>
	.footer.search_btn_lay button{width: auto;background-color: white; border: 1px solid gray; height: 30px;}
	.footer.search_btn_lay button span{color: #959595;}
	/*.resp_btn.active{color: #3090d6; border: 1px solid rgb(48, 144, 214) !important;}*/
	.search_btn_lay .sc_edit{position: relative;}
	.search_btn_lay .detail, .search_btn_lay .default{position: relative;}
	.resp_btn.size_XL{line-height: inherit;}
	.contents_container{width: 1400px; margin: auto;}
	.table_search{width: 1400px !important;}
	.footer.search_btn_lay{top: auto; left: calc(50% - 50px) !important}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>탈퇴 회원 리스트</h2>
		</div>		
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->



<div id="search_container"  class="search_container">
<form name="memberForm" id="memberForm" class='search_form'>
<input type="hidden" name="member_seq" />
<input type="hidden" name="orderby" value="<?php echo $TPL_VAR["sc"]["orderby"]?>"/>
<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sc"]["sort"]?>"/>
<input type="hidden" name="searchcount" value="<?php echo $TPL_VAR["sc"]["searchcount"]?>"/>
<input type="hidden" name="type" />
	<table class="table_search">
		<tr>
			<th>아이디</th>
			<td>				
				<input type="text" name="keyword" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" size="40" />
			</td>
		</tr>

		<tr>
			<th>탈퇴일</th>
			<td>
				<div class="sc_day_date date_range_form">
					<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>"  class="datepicker sdate"  maxlength="10" size="12" default_none/>
					-
					<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>"  class="datepicker edate" maxlength="10" size="12" default_none />
					<div class="resp_btn_wrap">
						<input type="button" value="오늘" range="today" class="select_date resp_btn" settarget="regist" />
						<input type="button" value="3일간" range="3day" class="select_date resp_btn" settarget="regist" />
						<input type="button" value="일주일" range="1week" class="select_date resp_btn" settarget="regist" />
						<input type="button" value="1개월" range="1month" class="select_date resp_btn" settarget="regist" />
						<input type="button" value="3개월" range="3month" class="select_date resp_btn" settarget="regist" />
						<input type="button" value="전체" range="all" class="select_date resp_btn" settarget="regist" row_bunch />
						<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden">
					</div>
				</div>
			</td>
		</tr>
	</table>	

	<div class="footer search_btn_lay"></div>
</div>

<div class="contents_container">
	<div class="list_info_container">
		<div class="dvs_left">	
			검색 <b><?php echo number_format($TPL_VAR["sc"]["searchcount"])?></b>개 (총 <b><?php echo number_format($TPL_VAR["sc"]["totalcount"])?></b>개)
		</div>
		<div class="dvs_right">	
			<select name="perpage" id="display_quantity">
				<option id="dp_qty10" value="10" <?php if($TPL_VAR["sc"]["perpage"]== 10){?> selected<?php }?> >10개씩</option>
				<option id="dp_qty50" value="50" <?php if($TPL_VAR["sc"]["perpage"]== 50){?> selected<?php }?> >50개씩</option>
				<option id="dp_qty100" value="100" <?php if($TPL_VAR["sc"]["perpage"]== 100){?> selected<?php }?> >100개씩</option>
				<option id="dp_qty200" value="200" <?php if($TPL_VAR["sc"]["perpage"]== 200){?> selected<?php }?> >200개씩</option>
			</select>
		</div>
	</div>

	<div class="table_row_frame">
	<!-- 탈퇴리스트 테이블 : 시작 -->
	<table class="table_row_basic tdc">
		<!-- 테이블 헤더 : 시작 -->
		<colgroup>
			<col width="5%" />
			<col width="10%" />
			<col />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="13%" />
			<col width="5%" />
		</colgroup>
		<thead class="lth">
		<tr>
			<th>번호</th>
			<th>아이디</th>
			<th>사유</th>
			<th>탈퇴IP</th>
			<th>탈퇴일</th>
			<th>캐시</th>
			<th>포인트</th>
			<th>예치금</th>
			<th>구매/주문/리뷰/방문</th>
			<th>관리</th>
		</tr>
		</thead>
		<!-- 테이블 헤더 : 끝 -->
		<!-- 리스트 : 시작 -->
		<tbody class="ltb otb" >
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr>
				<td><?php echo $TPL_V1["number"]?></td>
				<td onclick="window.open('/admincrm/main/user_detail?member_seq=<?php echo $TPL_V1["member_seq"]?>');"><span class="resp_btn_txt v2"><?php echo $TPL_V1["userid"]?></span></a></td>
				<td>
					<a onclick="open_reason('<?php echo $TPL_V1["member_seq"]?>')" class="resp_btn_txt v2"><?php echo $TPL_V1["reason"]?></a>
				</td>
				<td><?php echo $TPL_V1["regist_ip"]?></td>
				<td><?php echo $TPL_V1["regist_date"]?></td>
				<td><?php echo number_format($TPL_V1["emoney"])?></td>
				<td><?php echo number_format($TPL_V1["point"])?></td>
				<td><?php echo number_format($TPL_V1["cash"])?></td>
				<td><?php echo number_format($TPL_V1["order_cnt"])?>/<?php echo number_format($TPL_V1["order_sum"])?>/<?php echo number_format($TPL_V1["review_cnt"])?>/<?php echo number_format($TPL_V1["login_cnt"])?></td>
				<td><input type="button" name="manager_modify_btn" value="상세" onclick="window.open('/admincrm/main/user_detail?member_seq=<?php echo $TPL_V1["member_seq"]?>');"  member_seq="<?php echo $TPL_V1["member_seq"]?>" class="resp_btn v2"/></td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }}?>
<?php }else{?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr class="list-row">
				<td align="center" colspan="10">
<?php if($TPL_VAR["search_text"]){?>
						'<?php echo $TPL_VAR["search_text"]?>' 검색된 회원이 없습니다.
<?php }else{?>
						등록된 회원이 없습니다.
<?php }?>
				</td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }?>
		</tbody>
		<!-- 리스트 : 끝 -->
	</table>
	<!-- 탈퇴리스트 테이블 : 끝 -->
	</div>
</div>
</form>
<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>


<script>
	function joingate(){
		window.open('/member/agreement','','');
	}

	function viewDetail(obj){
		if(!$(obj).attr('member_seq')) return;
		location.href = "detail?member_seq="+$(obj).attr('member_seq');
		//$("input[name='member_seq']").val($(obj).attr('member_seq'));
		//$("form[name='memberForm']").attr('action','detail');
		//$("form[name='memberForm']").submit();
	}

	$(document).ready(function() {
		$("#display_quantity").change(function(){
			$("#memberForm").submit();
		});
	});

	function open_reason(member_seq) {
		if(member_seq == '') return;
		$.get('withdrawal_pop?member_seq='+member_seq, function(data) {
			$('#viewMemo').html(data);
			openDialog("탈퇴 회원 상세 사유", "viewMemo", {"width":"600","height":"250"});
		});
	}
</script>

<div id="viewMemo" class="hide"></div>
<!-- 기본검색설정 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>