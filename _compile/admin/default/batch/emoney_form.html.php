<?php /* Template_ 2.2.6 2022/05/17 12:30:49 /www/music_brother_firstmall_kr/admin/skin/default/batch/emoney_form.html 000009322 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common-ui.css?mm=<?php echo date('YmdHis')?>" />
<script type="text/javascript" src="/app/javascript/js/batch.js?v=<?php echo date('YmdHis')?>"></script>

<style>
	html{overflow-y:hidden !important;}
</style>

<script type="text/javascript">
$(document).ready(function() {

	$("#send_submit").click(function(){
		var memo = $("select[name='memo_type']").val();
		if(memo=='direct'){
			$("input[name='memo']").val($("input[name='memo_direct']").val());
		}else{
			$("input[name='memo']").val(memo);
		}

		document.emoneyForm.submit();
		loadingStart();
	});

	$("select[name='memo_type']").live('change',function(){
		if($(this).val()=='direct'){
			$("input[name='memo_direct']").show();
		}else{
			$("input[name='memo_direct']").hide();
		}
	});

	$("select[name='reserve_select']").live("change",function(){
		span_controller('reserve');
	});
	$("select[name='gb']").live('change',function(){
		if($(this).val()=='minus'){
			$(".reserve_select_lay").hide();
			$(".reserve_select_lay_minus").show();
		}else{
			$(".reserve_select_lay").show();
			$(".reserve_select_lay_minus").hide();
		}
	});

	$("#downloadMemberBtn").click(function(){
<?php if($TPL_VAR["auth_member_down"]){?>
		if($("input[name='mcount']").val() == 0){
			openDialogAlert('다운로드 파일이 없습니다.<br />먼저 회원을 검색해 주세요.', 400, 150);
			return;
		}

<?php if(preg_match("/chrome/",strtolower($_SERVER['HTTP_USER_AGENT']))||preg_match("/firefox/",strtolower($_SERVER['HTTP_USER_AGENT']))){?>
		if($("input[name='mcount']").val() > 30000){
			openDialogAlert("현재 브라우져에서는 대량 다운로드가 원할하지 않을 수 있습니다.<br />다운로드가 되지 않을 시 IE에서 다운로드 하시기 바랍니다.", 450, 160);
		}
<?php }?>

		openDialog('회원정보 다운로드','admin_member_download', {'width':550,'height':420});
<?php }else{?>
			openDialogAlert('다운로드 권한이 없습니다.<br /> <a href="../setting/manager"><span class="orange"><b>설정 > 관리자</b></span></a>에서 설정할 수 있습니다.', 400, 150);
			return;
<?php }?>
	});

	$('#reserve_year').val('<?php echo $TPL_VAR["reserve"]["reserve_year"]?>');
	setContentsSelect("gb", "plus");
	
	$("select[name='perpage']").on("change", function(){
		location.href = '?perpage='+$(this).val();
	});
});

/* 2022.01.05 12월 1차 패치 삭제 excelDownloadOk by 김혜진 */
		
function span_controller(name){
	var reserve_y = $("span[name='"+name+"_y']");
	var reserve_d = $("span[name='"+name+"_d']");
	var value = $("select[name='"+name+"_select'] option:selected").val();
	if(value==""){
		reserve_y.hide();
		reserve_d.hide();
	}else if(value=="year"){
		reserve_y.show();
		reserve_d.hide();
	}else if(value=="direct"){
		reserve_y.hide();
		reserve_d.show();
	}
}


</script>


<form name="emoneyForm" id="emoneyForm" method="post" target="actionFrame" action="../batch_process/set_emoney" class="hp100">
<input type="hidden" name="send_member" />
<input type="hidden" name="memo" />
<input type="hidden" name="mode" value="" />
<input type="hidden" name="serialize" id="serialize" value=""/>
<input type="hidden" name="mcount" value="0">
<input type="hidden" name="member" value="search">
<input type="hidden" name="searchSelect" value="search">
<input type="hidden" name="selectMember" value="">
<input type="hidden" name="callPage" value="emoney">

<div class="contents_container">
	<div class="content">		
		<div class="item-title">캐시 지급 및 차감</div>
		<table class="table_basic thl">		
			<tr>
				<th>지급자</th>
				<td><?php echo $TPL_VAR["managerInfo"]["mname"]?>(<?php echo $TPL_VAR["managerInfo"]["manager_id"]?>)</td>
			</tr>

			<tr>
				<th>대상 회원</th>
				<td>
					<span id="search_member" class="bold">0</span>명 
					<button type="button" id="searchMemberBtn" callpage="emoney" class="resp_btn v2">회원 검색</button>
					<span class="resp_btn" id="downloadMemberBtn"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /><span>다운로드</span></span>
				</td>
			</tr>

			<tr>
				<th>캐시</th>
				<td>
					<select name="gb">
						<option value="plus">지급 (+)</option>
						<option value="minus">차감 (-)</option>
					</select>
					<input type="text" name="emoney" class="line onlyfloat" size="7"> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

					
					<span class="reserve_select_lay ml20">
						유효기간 : 
						<select name="reserve_select">
							<option value="">제한하지 않음</option>
							<option value="year" <?php if($TPL_VAR["reserve"]["reserve_select"]=='year'){?>selected<?php }?>>제한 - 12월31일</option>
							<option value="direct" <?php if($TPL_VAR["reserve"]["reserve_select"]=='direct'){?>selected<?php }?>>제한 - 직접입력</option>
						</select>

						<span name="reserve_y" class="hide"> 
							<select name="reserve_year" id="reserve_year">
<?php if(is_array($TPL_R1=range( 0, 9))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
								<option value="<?php echo $TPL_K1?>"><?php echo intval(date('Y'))+intval($TPL_K1)?>년</option>
<?php }}?>
							</select>
							12월 31일</span>
							<span name="reserve_d" class="hide"><input type="text" name="reserve_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["reserve"]["reserve_direct"]?>" />개월</span>
						</span>				
					</span>
				</td>
			</tr>

			<tr>
				<th>사유</th>
				<td>
					<select name="memo_type">
						<option value="">선택</option>
						<option value="신규 회원가입 지급" class="gb_plus hide">신규 회원가입 지급</option>
						<option value="상품 구매 추가 적립" class="gb_plus hide">상품 구매 추가 적립</option>
						<option value="상품 구매 사용 차감" class="gb_minus hide">상품 구매 사용 차감</option>
						<option value="direct">직접 입력</option>
					</select>
					<input type="text" name="memo_direct" class="hide">
				</td>
			</tr>
		</table>

		<div class="footer">
			<button type="button" id="send_submit" class="resp_btn active size_XL">확인</button>
		</div>		

		<!-- 포인트 지급 내역 시작 -->
		<div class="item-title">지급 및 차감 내역</div>

		<div class="list_info_container">
			<div class="dvs_left"><div class="left-btns-txt" id="search_count" class="hide">총 <b><?php echo $TPL_VAR["data_total"]?></b> 개</div></div>
			<div class="dvs_right">
				<select name="perpage">
					<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
					<option id="dp_qty50" value="50" <?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?> >50개씩</option>
					<option id="dp_qty100" value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
					<option id="dp_qty200" value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
				</select>				
			</div>
		</div>

		<div class="table_row_frame">
			<!-- 주문리스트 테이블 : 시작 -->
			<table class="table_row_basic">
				<!-- 테이블 헤더 : 시작 -->			
				<thead>
				<tr>
					<th>번호</th>
					<th>구분</th>	
					<th>지급/차감 <?php echo $TPL_VAR["categoryKR"]?></th>					
					<th>사유</th>					
					<th>지급 회원 수</th>
					<th>지급자</th>
					<th>요청 일시</th>
					<th>완료 일시</th>
					<th>상태</th>
				</tr>
				</thead>
				<!-- 테이블 헤더 : 끝 -->

				<!-- 시작 -->
				<tbody>
<?php if($TPL_VAR["loop"]){?>
				<!-- 리스트 있으면 -->
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
					<!-- 리스트 시작 -->
					<tr>
						<td class="page_no"><?php echo $TPL_V1["no"]?></td>
						<td class="gb"><?php echo $TPL_V1["gb"]?></td>	
						<td class="amount"><?php echo $TPL_V1["amount"]?></td>						
						<td class="memo"><?php echo $TPL_V1["memo"]?></td>						
						<td class="count"><?php echo $TPL_V1["count"]?></td>	
						<td class="request_user"><?php echo $TPL_V1["manager_id"]?></td>
						<td class="request_date"><?php echo $TPL_V1["reg_date"]?></td>
						<td class="complete_date"><?php echo $TPL_V1["com_date"]?></td>
						<td class="status"><?php echo $TPL_V1["state"]?></td>
					</tr>
<?php }}?>
					<!-- 리스트 끝 -->
<?php }else{?>
				<!-- 리스트 없으면 -->
				<tr>
					<td colspan="9">등록된 내역이 없습니다.</td>
				</tr>
<?php }?>
				</tbody>
				<!-- 끝 -->
			</table>
			<!-- 주문리스트 테이블 : 끝 -->			
		</div>

		<!-- 페이징 -->
		<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
		
	</div>
	
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="window.close();">닫기</button>
	</div>
</div>
</form>
<!-- 포인트 지급 내역 종료 -->

<?php $this->print_("member_download_info",$TPL_SCP,1);?>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>