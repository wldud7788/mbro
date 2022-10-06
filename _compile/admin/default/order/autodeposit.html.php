<?php /* Template_ 2.2.6 2022/05/17 12:36:37 /www/music_brother_firstmall_kr/admin/skin/default/order/autodeposit.html 000036529 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<!-- 2021.12.30 11월 3차 패치 by 김혜진 */ -->
<script type="text/javascript">
	var search_type				= "<?php echo $TPL_VAR["sc"]["search_type"]?>";
	//기본검색설정
	var default_search_pageid	= "autodeposit";
	var default_obj_width		= 780;
	var default_obj_height		= 220;

	$(document).ready(function() {
		$("#autorun_once").click(function(){
			auto_run_plus('SET');
		});

		$(".order_search").click(function(){
			var sprice = $(this).attr("sprice");
			var eprice = $(this).attr("eprice");
			//alert(sprice+" "+eprice);
			window.open("catalog?mode=bank&sprice="+sprice+"&eprice="+eprice);
		});

		$("button#get_default_button").bind("click",function(){
			$.getJSON('get_search_autodeposit', function(result) {
				var patt;
				for(var i=0;i<result.length;i++){
					patt=/date/g;
					if( patt.test(result[i][0]) ){
						if(result[i][1] == 'today'){
							set_date('<?php echo date('Ymd')?>','<?php echo date('Ymd')?>');
						}else if(result[i][1] == '3day'){
							set_date('<?php echo date('Ymd',strtotime("-3 day"))?>','<?php echo date('Ymd')?>');
						}else if(result[i][1] == '7day'){
							set_date('<?php echo date('Ymd',strtotime("-7 day"))?>','<?php echo date('Ymd')?>');
						}else if(result[i][1] == '1mon'){
							set_date('<?php echo date('Ymd',strtotime("-1 month"))?>','<?php echo date('Ymd')?>');
						}
					}
					patt=/ad_/;
					if( patt.test(result[i][0]) ){
						$("form[name='search-form'] input[name='"+result[i][0]+"']").attr("checked",true);
					}
				}
			});
		});

		$(".info").click(function(){
			document.location.href = "../setting/bank";
		});


		$("#auto_deposit_set").bind("click",function(){
			var title = '자동실행확인 및 수동실행하기';
			openDialog(title, "auto_deposit_dialog", {"width":"880","height":"270"});
		});

		if("<?php echo $TPL_VAR["bankChk"]?>" == 'N'){
			openDialog("자동 입금 확인", "pop_info", {"width":"450","height":"180","noClose":"true"});
		}else if("<?php echo $TPL_VAR["bankChk"]?>" == 'END'){
			openDialog("자동 입금 확인", "pop_info2", {"width":"450","height":"180","noClose":"true"});
		}

		$('.view_account_memo').click(function(){
			var memo_num	= $(this).attr('memo_num');
			var memo_yn		= $(this).attr('memo_yn');
			$('.message_update').attr('memo_num',memo_num);
			$('#memo_view').val('')
			if(memo_yn == 'Y'){
				loadingStart();
				$.get('autodeposit_memo_get', {'memo_num' : memo_num}, function(response){
					$('#memo_view').val(response[0].memo);
					$('.message_update').text(' 수정 ')
					openDialog("관리자 메모", "autodeposit_memo_lay", {"width":"450","height":"250"});
					loadingStop();
				},'json');
			}else{
				$('.message_update').text(' 등록 ')
				openDialog("관리자 메모", "autodeposit_memo_lay", {"width":"450","height":"250"});
			}
		});

		$('.message_update').click(function(){
			var memo_num	= $(this).attr('memo_num');
			if(memo_num == ''){
				return;
			}

			var mode_txt	= $('.message_update').text();
			var params		= {};
			params.memo_num	= memo_num;
			params.memo		= $.trim($('#memo_view').val());

			loadingStart();
			$.post('autodeposit_memo_set', params, function(response){
				if(response == true){
					openDialogAlert("메모가 " + mode_txt + " 되었습니다.",400,140,function(){
						loadingStop();
						closeDialog("autodeposit_memo_lay");
						location.reload();
					});
				}else{
					openDialogAlert("메모저장 실패");
					loadingStop();
				}
			},'json');

		});

		$('.message_close').click(function(){closeDialog('autodeposit_memo_lay');});
	});


	var timeout_obj	= '';
	function auto_runs(){
		$.ajax({
			type: "get",
			url: "../order_process/auto_deposit_update",
			data: "",
			success: function(result){
				alert('입금내역이 갱신되었습니다.');
			}
		});
	}

	function auto_run_plus(setType){
		$.ajax({
			type: "get",
			url: "../order_process/auto_deposit_update_plus",
			data: "setType="+setType,
			success: function(result){
				if	(result > 0){
					auto_run_plus('');
				}else{
					auto_runs();
				}
			}
		});
	}

	function set_date(start,end){
		$("input[name='sdate']").eq(0).val(start);
		$("input[name='edate']").eq(1).val(end);
	}

	// 입금확인 안내 팝업 오픈
	function openInfoCheckKind(obj){
		openDialog('입금확인 안내', 'infoChkKind', {'width':950,'height':200});
	}

	// 주문 목록 조회
	function searchOrderList(page, param){
		if	(!page)	page	= 1;
		var params			= 'page=' + page;
		params				+= '&srcSdate=' + $('div#searchOrderForMatching').find('input.srcSdate').val();
		params				+= '&srcEdate=' + $('div#searchOrderForMatching').find('input.srcEdate').val();
		if	($('div#searchOrderForMatching').find('input.srcChkBkname').attr('checked')){
			params			+= '&srcBkname=' + $('div#searchOrderForMatching').find('input.srcBkname').val();
		}
		if	($('div#searchOrderForMatching').find('input.srcChkBknum').attr('checked')){
			params			+= '&srcBknum=' + $('div#searchOrderForMatching').find('input.srcBknum').val();
		}
		params				+= '&srcBkjukyo=' + $('div#searchOrderForMatching').find('input.srcBkjukyo').val();
		params				+= '&srcSprice=' + $('div#searchOrderForMatching').find('input.srcSprice').val();
		params				+= '&srcEprice=' + $('div#searchOrderForMatching').find('input.srcEprice').val();
		if	(param !== 'total' && $('div#searchOrderForMatching').find('input.total-row-count').val() > 0){
			params			+= '&totalCnt=' + $('div#searchOrderForMatching').find('input.total-row-count').val();
		}

		$('div#searchOrderForMatching').find('input.srcChkStatus').each(function(){
			if	($(this).attr('checked')){
				params		+= '&srcStatus[]=' + $(this).val();
			}
		});

		$.ajax({
			type		: 'post',
			url			: '../order/search_order',
			data		: params,
			dataType	: 'json',
			success		: function(result){
				$('div#searchOrderForMatching').find('tbody.order-list tr').remove();
				var html	= '';
				var data	= '';
				var rno		= 0;
				if	(result.pagination.totalCount > 0 && result.record.length > 0){
					$('div#searchOrderForMatching').find('span.total-row-count').html(comma(result.pagination.totalCount));
					$('div#searchOrderForMatching').find('input.total-row-count').val(result.pagination.totalCount);
					rno		= result.pagination.pagerno;
					for	(var i in result.record){
						data	= result.record[i];
						html	= '<tr>';
						html	+= '<td class="its-td-align center">' + rno + '</td>';
						html	+= '<td class="its-td-align left pdl5">';
						html	+= data.order_seq + '<br/>(' + data.regist_date + ')';
						html	+= '<input type="hidden" class="order-seq" value="' + data.order_seq + '" />';
						html	+= '<input type="hidden" class="regist-date" value="' + data.regist_date + '" />';
						html	+= '<input type="hidden" class="bank-account" value="' + data.bank_account + '" />';
						html	+= '<input type="hidden" class="depositor" value="' + data.depositor + '" />';
						html	+= '<input type="hidden" class="settleprice" value="' + data.settleprice + '" />';
						html	+= '<input type="hidden" class="deposit-date" value="' + data.deposit_date + '" />';
						html	+= '<input type="hidden" class="step" value="' + data.step + '" />';
						html	+= '<input type="hidden" class="step-msg" value="' + data.stepMsg + '" />';
						html	+= '</td>';
						html	+= '<td class="its-td-align left pdl5">' + data.bank_account + '</td>';
						html	+= '<td class="its-td-align center">' + data.depositor + '</td>';
						if	(data.depositor == data.order_user_name){
							html	+= '<td class="its-td-align center">좌동</td>';
						}else{
							html	+= '<td class="its-td-align center">' + data.order_user_name + '</td>';
						}
						html	+= '<td class="its-td-align right pdr5">' + get_currency_price(data.settleprice, 2) + '</td>';
						if	(data.step == 15 || data.step == 95){
							html	+= '<td class="its-td-align center">입금미확인</td>';
						}else{
							html	+= '<td class="its-td-align center">' + data.deposit_date + '</td>';
						}
						html	+= '<td class="its-td-align center">' + data.stepMsg + '</td>';
						if	(data.ismatch == 'Y'){
							html	+= '<td class="its-td-align center">다른 입금내역과 이미 매칭됨</td>';
						}else{
							if			(data.step == 95 || data.step == 15){
								html	+= '<td class="its-td-align center">';
								html	+= '<span class="btn small"><button type="button" style="color:orange;width:80px;" onclick="openMatchPopup(this);">입금확인+매칭</button></span>';
								html	+= '</td>';
							}else{
								html	+= '<td class="its-td-align center">';
								html	+= '<span class="btn small"><button type="button" style="color:orange;width:80px;" onclick="openMatchPopup(this);">매칭</button></span>';
								html	+= '</td>';
							}
						}
						$('div#searchOrderForMatching').find('tbody.order-list').append(html);
						rno--;
					}
					$('div#searchOrderForMatching').find('div.paging_navigation').html(result.pagination.html);
				}else{
					$('div#searchOrderForMatching').find('span.total-row-count').html('0');
					$('div#searchOrderForMatching').find('input.total-row-count').val(0);
					html	= '<tr><td class="its-td-align center" colspan="9">검색결과가 없습니다</td></tr>';
					$('div#searchOrderForMatching').find('tbody.order-list').append(html);
					$('div#searchOrderForMatching').find('div.paging_navigation').html('');
				}
			}
		});
	}

	// 주문 조회 팝업
	function openSearchOrder(obj){
<?php if($TPL_VAR["private_masking"]){?>
		openDialogAlert("권한이 없습니다.",400,150,function(){});
<?php }else{?>
		var bkcode		= $(obj).closest('tr').find('input.bkcode').val();
		var bk_date		= $(obj).closest('tr').find('input.bk_date').val();
		var bkname		= $(obj).closest('tr').find('input.bkname').val();
		var bkacctno	= $(obj).closest('tr').find('input.bkacctno').val();
		var bkjukyo		= $(obj).closest('tr').find('input.bkjukyo').val();
		var bkinput		= $(obj).closest('tr').find('input.bkinput').val();
		var bkjukyo2	= bkjukyo.substring(0, 3);
		var tmp1		= new Date(bk_date);
		tmp1.setDate(tmp1.getDate() - 7);
		var tmp_m		= parseInt(tmp1.getMonth()) + 1;
		var tmp_d		= tmp1.getDate();
		if	(tmp_m < 10)	tmp_m	= '0' + tmp_m;
		if	(tmp_d < 10)	tmp_d	= '0' + tmp_d;
		var tmpSdate	= tmp1.getFullYear() + '-' + tmp_m + '-' + tmp_d;
		var tmp2		= new Date(bk_date);
		tmp_m		= parseInt(tmp2.getMonth()) + 1;
		tmp_d		= tmp2.getDate();
		if	(tmp_m < 10)	tmp_m	= '0' + tmp_m;
		if	(tmp_d < 10)	tmp_d	= '0' + tmp_d;
		var tmpEdate	= tmp2.getFullYear() + '-' + tmp_m + '-' + tmp_d;

		$('div#searchOrderForMatching').find('input.srcSdate').val(tmpSdate);
		$('div#searchOrderForMatching').find('input.srcEdate').val(tmpEdate);
		$('div#searchOrderForMatching').find('input.srcBkname').val(bkname);
		$('div#searchOrderForMatching').find('input.srcBknum').val(bkacctno);
		$('div#searchOrderForMatching').find('input.srcBkjukyo').val(bkjukyo2);
		$('div#searchOrderForMatching').find('input.srcSprice').val(bkinput);
		$('div#searchOrderForMatching').find('input.srcEprice').val(bkinput);
		$('div#searchOrderForMatching').find('input.bkcode').val(bkcode);
		$('div#searchOrderForMatching').find('input.bk_date').val(bk_date);
		$('div#searchOrderForMatching').find('input.bkname').val(bkname);
		$('div#searchOrderForMatching').find('input.bkacctno').val(bkacctno);
		$('div#searchOrderForMatching').find('input.bkjukyo').val(bkjukyo);
		$('div#searchOrderForMatching').find('input.bkinput').val(bkinput);
		$('div#searchOrderForMatching').find('td.bkDate').html(bk_date);
		$('div#searchOrderForMatching').find('td.bkBank').html(bkname);
		$('div#searchOrderForMatching').find('td.bkBanknum').html(bkacctno);
		$('div#searchOrderForMatching').find('td.bkJukyo').html(bkjukyo);
		$('div#searchOrderForMatching').find('td.bkprice').html(comma(bkinput) + '원');

		searchOrderList('1', 'total');
		openDialog('주문조회', 'searchOrderForMatching', {'width':1200,'height':800});
<?php }?>
		}

		function openMatchPopup(obj){
<?php if($TPL_VAR["private_masking"]){?>
			openDialogAlert("권한이 없습니다.",400,150,function(){});
<?php }else{?>
			var bkcode			= $('div#searchOrderForMatching').find('input.bkcode').val();
			var bk_date			= $('div#searchOrderForMatching').find('input.bk_date').val();
			var bkname			= $('div#searchOrderForMatching').find('input.bkname').val();
			var bkacctno		= $('div#searchOrderForMatching').find('input.bkacctno').val();
			var bkjukyo			= $('div#searchOrderForMatching').find('input.bkjukyo').val();
			var bkinput			= $('div#searchOrderForMatching').find('input.bkinput').val();
			var order_seq		= $(obj).closest('tr').find('input.order-seq').val();
			var regist_date		= $(obj).closest('tr').find('input.regist-date').val();
			var bank_account	= $(obj).closest('tr').find('input.bank-account').val();
			var depositor		= $(obj).closest('tr').find('input.depositor').val();
			var settleprice		= $(obj).closest('tr').find('input.settleprice').val();
			var deposit_date	= $(obj).closest('tr').find('input.deposit-date').val();
			var step			= $(obj).closest('tr').find('input.step').val();
			var stepMsg			= $(obj).closest('tr').find('input.step-msg').val();

			if	(bank_account.search(bkname) == -1 || bank_account.search(bkacctno) == -1){
				bank_account	= '<span style="color:red;">' + bank_account + '</span>';
			}
			if	(depositor != bkjukyo){
				depositor		= '<span style="color:red;">' + depositor + '</span>';
			}
			if	(settleprice != bkinput){
				settleprice		= '<span style="color:red;">' + get_currency_price(settleprice, 2) + '</span>';
			}else{
				settleprice		= get_currency_price(settleprice, 2);
			}

			$('div#autodepositMatchingPopup').find("input[name='bkcode']").val(bkcode);
			$('div#autodepositMatchingPopup').find('td.bkDate').html(bk_date);
			$('div#autodepositMatchingPopup').find('td.bkBank').html(bkname);
			$('div#autodepositMatchingPopup').find('td.bkBanknum').html(bkacctno);
			$('div#autodepositMatchingPopup').find('td.bkJukyo').html(bkjukyo);
			$('div#autodepositMatchingPopup').find('td.bkprice').html(comma(bkinput));

			$('div#autodepositMatchingPopup').find("input[name='order_seq']").val(order_seq);
			$('div#autodepositMatchingPopup').find('td.order-seq').html(order_seq + ' (' + regist_date + ')');
			$('div#autodepositMatchingPopup').find('td.order-bkinfo').html(bank_account);
			$('div#autodepositMatchingPopup').find('td.order-depositor').html(depositor);
			$('div#autodepositMatchingPopup').find('td.order-settleprice').html(settleprice);
			if	(step == '15' || step == '95'){
				$('div#autodepositMatchingPopup').find('td.order-step').html('입금미확인 (' + stepMsg + ')');
				$('div#autodepositMatchingPopup').find('div.description-lay').html('위 \‘주문 내역\’을 입금확인합니다. 위 \‘주문 내역\’과 \‘입금 내역\’을 매칭합니다.<br/>(입금내역과의 매칭 후 해당 주문건이 특이한 사유로 인하여 주문접수로 되돌려질 경우 입금 내역과의 매칭 또한 해제됩니다)');
			}else{
				$('div#autodepositMatchingPopup').find('td.order-step').html(deposit_date + ' (' + stepMsg + ')');
				$('div#autodepositMatchingPopup').find('div.description-lay').html('위 \‘주문 내역\’과 \‘입금 내역\’을 매칭합니다.<br/>(입금내역과의 매칭 후 해당 주문건이 특이한 사유로 인하여 주문접수로 되돌려질 경우 입금 내역과의 매칭 또한 해제됩니다)');
			}

			openDialog('입금내역과 주문내역 확인 처리', 'autodepositMatchingPopup', {'width':1200,'height':320});
<?php }?>
			}

// 수동입금확인 처리
			function autodepositMatchSubmit(){
				if	(!$("form[name='bkMatchOrderFrm']").find("input[name='bkcode']").val()){
					openDialogAlert('매치할 입금내역이 없습니다.', 400, 170, function(){});
					return false;
				}
				if	(!$("form[name='bkMatchOrderFrm']").find("input[name='order_seq']").val()){
					openDialogAlert('매치할 입금내역이 없습니다.', 400, 170, function(){});
					return false;
				}

				$("form[name='bkMatchOrderFrm']").submit();
			}
</script>
<style type="text/css">
	.autorun_top_manual	{ margin:10px 0;text-align:center;line-height:27px; }
	.storage{background-image: url("/admin/skin/default/images/design/deposit_storage.png");}
	.title{padding-bottom:10px;font-size:17px;font-weight:bold;color:#464646;text-align:center;}
	.red-bold{color:#ff5353;font-weight:bold;padding-bottom:8px;font-size:14px;}
	.content{padding-left:5px;color:#4b4b4b;}
</style>
<!-- 2022.01.04 11월 4차 패치 by 김혜진 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js?v=<?php echo date('Ymd')?>"></script>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/searchform.css" />


<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>은행입금내역 자동입금확인</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 주문리스트 검색폼 : 시작 -->

<div id="autodeposit_search" class="search-form-container-new search_container">
	<div class="autorun_top_manual" style="float:left;width:83%;color:red;line-height:18px;">
		자동입금확인은 약 1시간마다 수집한 은행의 입금내역을 매시 20분마다 주문내역과 매칭함으로써 자동으로 입금확인이 이뤄집니다.<br/>
		매시 20분마다 실행되는 입금내역과 주문내역의 매칭 작업은 우측의 버튼을 클릭하여 수동으로 실행하실 수도 있습니다.
	</div>
	<div class="autorun_top_manual" style="float:right;padding-right:20px;">
		<span class="btn large cyanblue"><button type="button" id="auto_deposit_set">자동실행확인 및 수동실행하기</button></span>
	</div>
	<form name="search-form" method="get">
		<table class="table_search">
			<tr>
				<th>검색어</th>
				<td>
					<input type="text" name="keyword" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" title="입금자명,입금은행,금액,주문번호" size="100"/>
				<!-- 2021.12.30 위 태그 미 매칭으로 예상 by 김혜진 </div> -->
				</td>
			</tr>
		</table>

		<div class="search-detail-lay">
			<table class="search-form-table" id="search_detail_table">
				<tr>
					<td>
						<table class="sf-option-table  table_search">
							<tr>
								<th>입금일</th>
								<td>
									<input type="text" name="sdate" value="<?php echo $_GET["sdate"]?>" class="datepicker line"  maxlength="10" size="10" default_none />
									&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
									<input type="text" name="edate" value="<?php echo $_GET["edate"]?>" class="datepicker line" maxlength="10" size="10" default_none />
									<span class="resp_btn_wrap">
									<span class="btn small"><input type="button" id="today" value="오늘" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" id="3day" value="3일간" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" id="1week" value="일주일" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" id="1month" value="1개월" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" id="3month" value="3개월" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" id="select_date_all"  value="전체" class="select_date resp_btn"  /></span>
								</span>
								</td>
							</tr>
							<tr>
								<th>
									입금확인
									<span class="helpicon" title="입금확인 안내" onclick="openInfoCheckKind(this);"></span>
								</th>
								<td>
									<label class="search_label resp_checkbox"><input type="checkbox" name="ad_chk[0]" value="1" <?php echo $TPL_VAR["checked"]["ad_chk"][ 0]?>/> 자동입금확인</label>
									&nbsp;&nbsp;
									<label class="search_label resp_checkbox"><input type="checkbox" name="ad_chk[1]" value="2" <?php echo $TPL_VAR["checked"]["ad_chk"][ 1]?>/> 수동입금확인</label>
									&nbsp;&nbsp;
									<label class="search_label resp_checkbox"><input type="checkbox" name="ad_chk[2]" value="3" <?php echo $TPL_VAR["checked"]["ad_chk"][ 2]?>/> 미매칭</label>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>

		<div class="footer search_btn_lay">
			<div>
					<span class="sc_edit">
						<button type="button" id="set_default_setting_button" class="resp_btn v3">기본검색설정</button>
						<button type="button" id="set_default_apply_button" onclick="set_search_form('autodeposit')" class="resp_btn v3">기본검색적용</button>
					</span>
				<span class="search">
						<button type="submit" class="resp_btn active size_XL"><span>검색</span></button>
						<button type="button" id="search_reset_button" class="resp_btn v3 size_XL">초기화</button>
					</span>
			</div>
		</div>
	</form>
</div>
<!-- 주문리스트 검색폼 : 끝 -->

<div style="margin:15px 0;"></div>

<!-- 주문리스트 테이블 -->
<table class="info-table-style" cellspacing="0" width="100%">
	<colgroup>
		<col width="80" />
		<col width="120" />
		<col width="120" />
		<col width="120" />
		<col width="120" />
		<col width="90" />
		<col width="120" />
		<col width="250" />
		<col />
	</colgroup>
	<thead>
	<tr>
		<th class="its-th-align center" colspan="5">은행 입금내역</th>
		<th class="its-th-align center" colspan="3">좌측 입금내역에 대한 주문</th>
		<th class="its-th-align center" rowspan="2">관리 메모</th>
	</tr>
	<tr>
		<th class="its-th-align center">입금일</th>
		<th class="its-th-align center">입금은행</th>
		<th class="its-th-align center">계좌번호</th>
		<th class="its-th-align center">입금자명</th>
		<th class="its-th-align center">입금금액</th>
		<th class="its-th-align center">처리상태</th>
		<th class="its-th-align center">입금확인 일시</th>
		<th class="its-th-align center">입금확인 주문</th>
	</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
	<tr class="list-row" <?php if($TPL_V1["status"]!='N'){?>bgcolor="#eaf1ff"<?php }?>>
	<td class="its-td-align center">
		<?php echo $TPL_V1["bk_date"]?>

		<input type="hidden" class="bkcode" value="<?php echo $TPL_V1["bkcode"]?>" />
		<input type="hidden" class="bk_date" value="<?php echo $TPL_V1["bk_date"]?>" />
		<input type="hidden" class="bkname" value="<?php echo $TPL_V1["bkname"]?>" />
		<input type="hidden" class="bkacctno" value="<?php echo $TPL_V1["bkacctno"]?>" />
		<input type="hidden" class="bkjukyo" value="<?php echo $TPL_V1["bkjukyo"]?>" />
		<input type="hidden" class="bkinput" value="<?php echo $TPL_V1["bkinput"]?>" />
	</td>
	<td class="its-td-align left pdl5"><?php echo $TPL_V1["bkname"]?></td>
	<td class="its-td-align left pdl5"><?php echo $TPL_V1["bkacctno"]?></td>
	<td class="its-td-align left pdl5"><?php echo $TPL_V1["bkjukyo"]?></td>
	<td class="its-td-align right pdr5"><?php echo get_currency_price($TPL_V1["bkinput"], 3)?></td>
	<td class="its-td-align left pdl5"><?php echo $TPL_V1["statusStr"]?></td>
	<td class="its-td-align center">
<?php if($TPL_V1["status"]!='N'){?>
		<?php echo $TPL_V1["deposit_date"]?>

<?php if($TPL_V1["status"]=='M'){?><?php echo $TPL_V1["manager_id"]?><?php }?>
<?php }?>
	</td>
	<td class="its-td-align left pdl5">
<?php if($TPL_V1["status"]=='N'){?>
		<center><span class="btn small"><button type="button" onclick="openSearchOrder(this);" style="color:orange;">&nbsp;&nbsp;주문조회&nbsp;&nbsp;</button></center>
<?php }else{?>
<?php if($TPL_V1["order_seq"]){?>
		<div class="click-lay" onclick="window.open('../order/view?no=<?php echo $TPL_V1["order_seq"]?>');"><?php echo $TPL_V1["order_seq"]?></div>
		<div><?php echo $TPL_V1["bank_account"]?></div>
		<div><?php echo $TPL_V1["depositor"]?> <?php echo get_currency_price($TPL_V1["settleprice"], 3)?></div>
<?php }?>
<?php }?>
	</td>
	<td class="its-td-align left pdl5">
<?php if($TPL_V1["memo"]){?>
		<span class="click-lay view_account_memo" memo_num="<?php echo $TPL_V1["bkcode"]?>" memo_yn="Y"><?php echo $TPL_V1["memo"]?></span>
<?php }else{?>
		<center><span class="btn small"><button class="view_account_memo" type="button" memo_num="<?php echo $TPL_V1["bkcode"]?>" memo_yn="N" style="color:orange;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;메 모&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></span></center>
<?php }?>
	</td>
	</tr>
<?php }}?>
	</tbody>
</table>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td align="center">
			<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
		</td>
	</tr>
</table>

<div id="autodeposit_memo_lay" class="hide">
	<table style="width:100%">
		<tbody>
		<tr>
			<td>
				<textarea id="memo_view" style="width:395px;height:110px"></textarea>
			</td>
		</tr>
		</tbody>
	</table>
	<div style="width:100%;text-align:center;padding-top:10px;">
		<span class="btn large cyanblue"><button class="message_update" memo_num=""> 등록 </button></span>
		<span class="btn large gray"><button class="message_close"> 취소 </button></span>
	</div>
</div>

<div id="pop_info" class="hide">
	<table style="width:100%">
		<tbody>
		<tr><td>무통장 자동입금확인을 이용하기 위해 먼저 서비스를 신청해 주십시오.</td></tr>
		<tr><td height="30">설정 > 무통장에서 신청을 하실 수 있으며 계좌도 설정할 수 있습니다.</td></tr>
	</table>
	<div style="width:100%;text-align:center;padding-top:10px;">
		<span class="btn large cyanblue"><button class="info">바로가기</button></span>
	</div>
</div>

<div id="pop_info2" class="hide">
	<table style="width:100%">
		<tbody>
		<tr><td>서비스 기한이 만료되었습니다. </td></tr>
		<tr><td height="30">다시 신청해 주시기 바랍니다.</td></tr>
	</table>
	<div style="width:100%;text-align:center;padding-top:10px;">
		<span class="btn large cyanblue"><button class="info">바로가기</button></span>
	</div>
</div>

<!-- 주문리스트 테이블 : 끝 -->
<div class="hide" id="auto_deposit_dialog">
	<div id="contents">
		<table>
			<tr>
				<td class="title" width="102">금융권</td>
				<td width="200" ></td>
				<td class="title"  width="102">입금정보</td>
				<td width="320" ></td>
				<td class="title" width="102">주문정보</td>
			</tr>
			<tr>
				<td class="storage" height="112"></td>
				<td style="vertical-align:top;">
					<div style="height:50px;padding-left:15px;">
						<p class="red-bold">[자동실행]</p>
						<p class="content">1시간 간격으로 입금정보 수집</p>
					</div>
					<div>
						<div style="background-color:#d3e5fb;width:183px;height:6px;float:left;margin-top:9px;"></div>
						<div style="float:left"><img src="/admin/skin/default/images/design/arrow_right.png"></div>
					</div>
				</td>
				<td class="storage"></td>
				<td style="vertical-align:top;">
					<div style="height:50px;padding-left:20px;">
						<p class="red-bold">[자동실행 中]</p>
						<p class="content">
							최근 7일 동안의 주문(주문접수+무통장)건에 대하여<br/>
							20분 간격으로 입금여부 자동 매칭
						</p>
					</div>
					<div>
						<div style="float:left"><img src="/admin/skin/default/images/design/arrow_left.png"></div>
						<div style="background-color:#d3e5fb;width:288px;height:6px;float:left;margin-top:9px;"></div>
						<div style="float:left"><img src="/admin/skin/default/images/design/arrow_right.png"></div>
					</div>
					<div style="height:50px;padding-left:20px;">
						<p class="red-bold">[수동실행]</p>
						<p class="content">
							주문(주문접수+무통장)건에 대하여<br/>
							지금 바로 입금여부 자동 매칭
							<span class="btn small cyanblue"><button type="button" id="autorun_once">수동실행</button></span><br/>
						</p>
					</div>
				</td>
				<td class="storage"></td>
			</tr>
		</table>
	</div>
</div>

<div id="infoChkKind" class="hide">
	<table class="info-table-style" width="100%" cellspacing="0">
		<tbody>
		<tr>
			<th width="120" class="its-th-align left pdl5">자동입금확인</th>
			<td class="its-td-align left pdl5">실제 입금된 은행 계좌의 입금자명, 입금금액이 = 주문된 은행 계좌의 입금자명, 입금금액과 서로 일치하여 자동으로 입금 확인한 주문입니다.</td>
		</tr>
		<tr>
			<th class="its-th-align left pdl5">수동입금확인</th>
			<td class="its-td-align left pdl5">실제 입금된 은행 계좌의 입금자명, 입금금액이 = 주문된 은행 계좌의 입금자명, 입금금액을 관리자가 수동으로 입금 확인한 주문입니다.</td>
		</tr>
		<tr>
			<th class="its-th-align left pdl5">미매칭</th>
			<td class="its-td-align left pdl5">실제 입금 내역과 주문이 매칭되지 않았습니다.</td>
		</tr>
		</tbody>
	</table>
</div>

<div id="searchOrderForMatching" class="hide">
	<table width="100%" class="info-table-style">
		<colgroup>
			<col width="8%" />
			<col />
			<col width="12%" />
			<col width="12%" />
			<col width="10%" />
			<col width="18%" />
			<col width="20%" />
		</colgroup>
		<thead>
		<tr>
			<th class="its-th-align center">구분</th>
			<th class="its-th-align center">입금일 / 주문일</th>
			<th class="its-th-align center">입금은행</th>
			<th class="its-th-align center">계좌번호</th>
			<th class="its-th-align center">입금자명</th>
			<th class="its-th-align center">입금금액</th>
			<th class="its-th-align center">입금여부</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td class="its-td-align center">
				입금 내역
				<input type="hidden" class="bkcode" value="" />
				<input type="hidden" class="bk_date" value="" />
				<input type="hidden" class="bkname" value="" />
				<input type="hidden" class="bkacctno" value="" />
				<input type="hidden" class="bkjukyo" value="" />
				<input type="hidden" class="bkinput" value="" />
			</td>
			<td class="its-td pdl5 bkDate"></td>
			<td class="its-td pdl5 bkBank"></td>
			<td class="its-td pdl5 bkBanknum"></td>
			<td class="its-td pdl5 bkJukyo"></td>
			<td class="its-td-align right pdr5 bkprice"></td>
			<td class="its-td-align center">-</td>
		</tr>
		<tr>
			<td class="its-td-align center bgyellow">주문 내역</td>
			<td class="its-td-align center bgyellow">
				<input type="text" size="10" class="line datepicker srcSdate" value="" readonly />
				-
				<input type="text" size="10" class="line datepicker srcEdate" value="" readonly />
			</td>
			<td class="its-td-align center bgyellow">
				<label><input type="checkbox" class="line srcChkBkname" value="Y" checked /></label>
				<input type="text" class="line srcBkname" size="15" value="" />
			</td>
			<td class="its-td-align center bgyellow">
				<label><input type="checkbox" class="line srcChkBknum" value="Y" checked /></label>
				<input type="text" class="line srcBknum" size="15" value="" />
			</td>
			<td class="its-td-align center bgyellow">
				<input type="text" class="line srcBkjukyo" size="15" value="" />
			</td>
			<td class="its-td-align center bgyellow">
				<input type="text" size="10" class="line srcSprice" value="" />
				-
				<input type="text" size="10" class="line srcEprice" value="" />
			</td>
			<td class="its-td-align center bgyellow">
				<label><input type="checkbox" class="line srcChkStatus" value="N" checked /> 입금미확인</label>
				<label><input type="checkbox" class="line srcChkStatus" value="Y" checked /> 입금확인</label>
				<label><input type="checkbox" class="line srcChkStatus" value="R" /> 주문무효</label>
			</td>
		</tr>
		</tbody>
	</table>

	<div style="margin:10px 0 20px 0;text-align:center;">
		<span class="btn large"><button type="button" style="color:orange;" onclick="searchOrderList('1', 'total');">주문조회</button></span>
	</div>

	<div style="margin:0 0 5px 0;">상기 주문 내역 기준의 검색결과 : <span class="total-row-count">0</span>건<input type="hidden" class="total-row-count" value="0" /></div>
	<table width="100%" class="info-table-style">
		<colgroup>
			<col width="8%" />
			<col width="12%" />
			<col width="20%" />
			<col width="8%" />
			<col width="8%" />
			<col width="10%" />
			<col width="12%" />
			<col width="8%" />
			<col />
		</colgroup>
		<thead>
		<tr>
			<th class="its-th-align center">번호</th>
			<th class="its-th-align center">주문번호 (주문일시)</th>
			<th class="its-th-align center">입금은행</th>
			<th class="its-th-align center">입금자명</th>
			<th class="its-th-align center">주문자</th>
			<th class="its-th-align center">입금금액</th>
			<th class="its-th-align center">입금확인 일시</th>
			<th class="its-th-align center">주문상태</th>
			<th class="its-th-align center">처리</th>
		</tr>
		</thead>
		<tbody class="order-list"></tbody>
	</table>

	<div style="margin:15px 0;text-align:center;" class="paging_navigation"></div>
</div>

<div id="autodepositMatchingPopup" class="hide">
	<form name="bkMatchOrderFrm" method="post" action="../order_process/autodeposit_manual_match" target="actionFrame">
		<input type="hidden" name="bkcode" value="" />
		<input type="hidden" name="order_seq" value="" />
	</form>
	<table width="100%" class="info-table-style">
		<colgroup>
			<col width="8%" />
			<col />
			<col width="12%" />
			<col width="12%" />
			<col width="10%" />
			<col width="10%" />
			<col width="18%" />
		</colgroup>
		<thead>
		<tr>
			<th class="its-th-align center">구분</th>
			<th class="its-th-align center">입금일 / 주문일</th>
			<th class="its-th-align center">입금은행</th>
			<th class="its-th-align center">계좌번호</th>
			<th class="its-th-align center">입금자명</th>
			<th class="its-th-align center">입금금액</th>
			<th class="its-th-align center">입금여부</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td class="its-td-align center">입금 내역</td>
			<td class="its-td pdl5 bkDate"></td>
			<td class="its-td pdl5 bkBank"></td>
			<td class="its-td pdl5 bkBanknum"></td>
			<td class="its-td pdl5 bkJukyo"></td>
			<td class="its-td-align right pdr5 bkprice"></td>
			<td class="its-td-align center">-</td>
		</tr>
		<tr>
			<td class="its-td-align center bgyellow">주문 내역</td>
			<td class="its-td-align left pdl5 bgyellow order-seq"></td>
			<td class="its-td-align left pdl5 bgyellow order-bkinfo" colspan="2"></td>
			<td class="its-td-align left pdl5 bgyellow order-depositor"></td>
			<td class="its-td-align right pdr5 bgyellow order-settleprice"></td>
			<td class="its-td-align center bgyellow order-step"></td>
		</tr>
		</tbody>
	</table>

	<div class="description-lay" style="margin:15px 0;text-align:center;line-height:25px;"></div>

	<div style="margin:15px 0;text-align:center;">
		<span class="btn large"><button type="button" style="color:orange;padding-left:50px;padding-right:50px;" onclick="autodepositMatchSubmit();">실행</button></span>
	</div>
</div>



<!-- 기본검색설정 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchDefaultConfig.js"></script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>