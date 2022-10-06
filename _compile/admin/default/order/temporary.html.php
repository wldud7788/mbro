<?php /* Template_ 2.2.6 2022/05/17 12:36:41 /www/music_brother_firstmall_kr/admin/skin/default/order/temporary.html 000029070 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<!-- 2021.12.30 11월 3차 패치 by 김혜진 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js?v=<?php echo date('Ymd')?>"></script>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/searchform.css" />
<style>
	.goods_name {display:inline-block;white-space:nowrap;overflow:hidden;width:100%;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	.search_label 	{display:inline-block;width:100px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	span.step_title { font-weight:normal;padding:0 5px 0 5px; }
	span.export-list { display:inline-block;background-url("/admin/skin/default/images/common/btn_list_release.gif");width:60px;height:15px; }
	.ltr-title {top:15px; }
</style>
<script type="text/javascript">
	var search_type				= "<?php echo $TPL_VAR["sc"]["search_type"]?>";
	//기본검색설정
	var default_search_pageid	= "temporary";
	var default_obj_width		= 750;
	var default_obj_height		= 260;

	$(document).ready(function() {
		$(".all-check").toggle(function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',true);
		},function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',false);
		});

		$("span.list-important").bind("click",function(){
			var param = "?no="+$(this).attr('id');
			if( $(this).hasClass('checked') ){
				$(this).removeClass('checked');
				param += "&val=0";
				$.get('important'+param,function(data) {});

			}else{
				$(this).addClass('checked');
				param += "&val=1";
				$.get('important'+param,function(data) {});
			}
		});

		$("select.list-select").bind("change",function(){
			var nm = $(this).attr("name");
			var value_str = $(this).val();
			var that = this;

			$("select[name='"+nm+"']").not(this).each(function(idx){
				$(this).find("option[value='"+value_str+"']").attr("selected",true);
				this.selectedIndex = that.selectedIndex;
				$(this).customSelectBox("selectIndex",that.selectedIndex);
			});

			var step = nm.replace('select_', "");
			var obj = $(".important-"+step);
			obj.each(function(){
				if( value_str ){
					$(this).parent().parent().find("td").eq(0).find("input").attr("checked",false);
					if(  value_str == 'important' && $(this).hasClass('checked') ){
						$(this).parent().parent().find("td").eq(0).find("input").attr("checked",true);
					}else if( value_str == 'not-important' && !$(this).hasClass('checked') ){
						$(this).parent().parent().find("td").eq(0).find("input").attr("checked",true);
					}else if(  value_str == 'select' ){
						$(this).parent().parent().find("td").eq(0).find("input").attr("checked",true);
					}
				}
			});
		});

		// 결제확인 시
		$("button[name='order_deposit']").bind("click",function(){
			var step = $(this).attr('id');
			var order_seq = new Array();
			$("tr.step"+step).find("input[type='checkbox'][name='order_seq[]']:checked").each(function(idx){
				order_seq[idx] = 'seq[]='+$(this).val();
			});
			if(order_seq.length > 0){
				openDialogConfirm('선택된 주문을 결제확인 하시겠습니까?',400,140,function(){
					var str = order_seq.join('&');
					$.ajax({
						type: "POST",
						url: "../order_process/batch_deposit",
						data: str,
						success: function(result){
							location.reload();
						}
					});
				},function(){
				});
			}else{
				alert("선택값이 없습니다.");
				return;
			}
		});

		// 삭제처리
		$("button[name='goods_temps']").bind("click",function(){
			var step = $(this).attr('id');
			var order_seq = new Array();
			$("tr.step"+step).find("input[type='checkbox'][name='order_seq[]']:checked").each(function(idx){
				order_seq[idx] = 'seq[]='+$(this).val();
			});
			if(order_seq.length > 0){
				openDialogConfirm('선택된 주문을 완전삭제처리 하시겠습니까?',400,140,function(){
					var str = order_seq.join('&');
					$.ajax({
						type: "POST",
						url: "../order_process/batch_temps_orders",
						data: str,
						success: function(result){
							location.reload();
						}
					});
				},function(){
				});
			}else{
				alert("선택값이 없습니다.");
				return;
			}
		});

		// 주문무효 시
		$("button[name='cancel_order']").bind("click",function(){
			var step = $(this).attr('id');
			var order_seq = new Array();
			$("tr.step"+step).find("input[type='checkbox'][name='order_seq[]']:checked").each(function(idx){
				order_seq[idx] = 'seq[]='+$(this).val();
			});
			if(order_seq.length > 0){
				openDialogConfirm('선택된 주문을 주문무효처리 하시겠습니까?',400,140,function(){
					var str = order_seq.join('&');
					$.ajax({
						type: "POST",
						url: "../order_process/batch_cancel_order",
						data: str,
						success: function(result){
							location.reload();
						}
					});
				},function(){
				});
			}else{
				alert("선택값이 없습니다.");
				return;
			}
		});

		// 일괄출고처리
		$("button[name='goods_export']").bind("click",function(){
			var step = $(this).attr('id');
			var order_seq = new Array();
			$("tr.step"+step).find("input[type='checkbox'][name='order_seq[]']:checked").each(function(idx){
				order_seq[idx] = 'seq[]='+$(this).val();
			});

			if(order_seq.length > 0){
				var str = order_seq.join('&');
				$.ajax({
					type: "POST",
					url: "../order/batch_export",
					data: str,
					success: function(result){
						$("#goods_export_dialog").html(result);
					}
				});
				openDialog("일괄 출고 처리<span class='desc'> - "+order_seq.length+"건</span>", "goods_export_dialog", {"width":"95%","height":"700"});
			}else{
				alert("선택값이 없습니다.");
				return;
			}
		});
		// 바로열기
		$(".btn-direct-open").toggle(function(){
			var pagemode = 'del_order_list';
			var shipping_provider_seq = 1;
			var nextTr = $(this).parent().parent().next();
			var order_seq = $(this).parent().parent().find("input[type='checkbox']").val();
			$.get('view?no='+order_seq+"&pagemode="+pagemode+"&shipping_provider_seq="+shipping_provider_seq, function(data) {
				nextTr.find('div.order_info').html(data);
			});
			nextTr.removeClass('hide');
			$(this).addClass("opened");

		},function(){
			var nextTr = $(this).parent().parent().next();
			nextTr.find('div.order_info').html('');
			nextTr.addClass('hide');
			$(this).removeClass("opened");
		});

		// 개별 출고처리
		$("button.goods_export").live("click",function(){
			var order_seq = $(this).attr('id').replace("goods_export_","");
			var url = "goods_export?seq="+order_seq;
			$.get(url, function(data) {
				$('#goods_export_dialog').html(data);
			});
			openDialog("출고처리<span class='desc'> - "+order_seq+"</span>", "goods_export_dialog", {"width":"95%","height":500});
		});

		// 개별 결제확인
		$("button.order_deposit").live("click",function(){
			var order_seq = $(this).attr('id').replace("order_deposit_","");
			actionFrame.location.href = '../order_process/deposit?seq='+order_seq;
		});

		// 체크박스 색상
		$("input[type='checkbox'][name='order_seq[]']").live('change',function(){
			if($(this).is(':checked')){
				$(this).closest('tr').addClass('checked-tr-background');
			}else{
				$(this).closest('tr').removeClass('checked-tr-background');
			}
		}).change();



		//
		$("button[name='goods_print']").bind("click",function(){
			var step = $(this).attr('id');
			var order_seq = new Array();
			var text = "";
			$("tr.step"+step).find("input[type='checkbox'][name='order_seq[]']:checked").each(function(idx){
				//order_seq[idx] = 'seq[]='+$(this).val();
				text += $(this).val()+"|";
			});
			if(text){
				window.open('/admin/order/order_prints?ordarr='+text, '', 'width=850px,height=800px,toolbar=no,location=no,resizable=yes, scrollbars=yes');
			}else{
				alert("선택값이 없습니다.");
				return;
			}
		});


		$("button[name='download_list']").click(function(){
			//window.open("/admin/order/download_list","","");
			location.href = "/admin/order/download_list";
		});

		/*
		$("button[name='excel_down']").click(function(){
			var step = $(this).attr("step");
			if(!$("#select_down_"+step).val()){
				alert("양식을 선택해 주세요.");
				return;
			}
			actionFrame.location.href="/admin/order_process/excel_down?step="+step+"&seq="+$("#select_down_"+step).val();
		});
		*/
		$("button[name='excel_down']").click(function(){
			var step = $(this).attr("step");
			var order_seq = "";
			$("tr.step"+step).find("input[type='checkbox'][name='order_seq[]']:checked").each(function(idx){
				order_seq += $(this).val() + "|";
			});
			if(!order_seq){
				alert("선택값이 없습니다.");
				return;
			}

			if(!$("#select_down_"+step).val()){
				alert("양식을 선택해 주세요.");
				return;
			}
			actionFrame.location.href="/admin/order_process/excel_down?order_seq="+order_seq+"&seq="+$("#select_down_"+step).val();
		});


		// export_upload
		$("button[name='excel_upload']").live("click",function(){
			openDialog("송장번호 일괄 업로드 <span class='desc'></span>", "export_upload", {"width":"600","height":"550","show" : "fade","hide" : "fade"});
		});

	});
	function set_date(start,end){
		$("input[name='regist_date[]']").eq(0).val(start);
		$("input[name='regist_date[]']").eq(1).val(end);
	}

	// sns 계정 정보 확인
	function snsdetailview(m,snscd,mem_seq,no){

		var disp = $("div#snsdetailPopup"+no).css("display");
		$(".snsdetailPopup").hide();

		var obj	= $("div#snsdetailPopup"+no);
		//$("div.snsdetailPopup").hide();
		if(obj.html() == ''){
			$.get('../member/sns_detail?snscd='+snscd+'&member_seq='+mem_seq+'&no='+no, function(data) {
				obj.html(data);
			});
		}

		if(disp == "none"){ obj.show(); }
	}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>삭제리스트</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 주문리스트 검색폼 : 시작 -->
<div class="search-form-container">
	<form name="search-form" method="get">
		<table class="table_search">
			<tr>
				<th>검색어</th>
				<td>
					<input type="text" name="keyword" value="<?php echo $_GET["keyword"]?>" size="100" title="주문자, 받는자, 입금자, 아이디, 이메일, 휴대폰, 주문번호, 상품명" />
</div>
</td>
</tr>
</table>

<div class="search-detail-lay">
	<table class="search-form-table" id="search_detail_table">
		<tr>
			<td>
				<table class="sf-option-table table_search">
					<col width="70"><col>
					<tr>
						<th>주문일</th>
						<td>
							<input type="text" name="regist_date[]" value="<?php echo $_GET["regist_date"][ 0]?>" class="datepicker"  maxlength="10" style="width:80px;" default_none />
							&nbsp;<span class="gray">-</span>&nbsp;
							<input type="text" name="regist_date[]" value="<?php echo $_GET["regist_date"][ 1]?>" class="datepicker" maxlength="10" style="width:80px;"  default_none />
							<span class="resp_btn_wrap">
									<span class="btn small"><input type="button" value="오늘" id="today" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" value="3일간" id="3day" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" value="일주일" id="1week" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" value="1개월" id="1month" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" value="3개월" id="3month" class="select_date resp_btn" /></span>
									<span class="btn small"><input type="button" value="전체" id="all" class="select_date resp_btn" /></span>
								</span>
						</td>
					</tr>
					<tr>
						<th>출고 전</th>
						<td>
								<span class="resp_checkbox">
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1=='15'||$TPL_K1=='95'||$TPL_K1=='99'){?>
<?php if($_GET["chk_step"][$TPL_K1]){?>
								<label><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" checked="checked" /> <?php echo $TPL_V1?></label>
<?php }else{?>
								<label><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" /> <?php echo $TPL_V1?></label>
<?php }?>
<?php }?>
<?php }}?>
								</span>
							<span class="icon-check hand all-check ml10"><b>전체</b></span>
						</td>
					</tr>
					<tr>
						<th>결제수단</th>
						<td>
								<span class="resp_checkbox">
<?php if(is_array($TPL_R1=config_load('payment'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if(!preg_match('/escrow/',$TPL_K1)){?>
<?php if($_GET["payment"][$TPL_K1]){?>
									<label class="resp_checkbox"><input type="checkbox" name="payment[<?php echo $TPL_K1?>]" value="1" checked="checked" />
<?php if($TPL_K1=='kakaopay'){?>
											(구)<?php echo $TPL_V1?>

<?php }else{?>
											<?php echo $TPL_V1?>

<?php }?>
									</label>
<?php }else{?>
									<label class="resp_checkbox"><input type="checkbox" name="payment[<?php echo $TPL_K1?>]" value="1" />
<?php if($TPL_K1=='kakaopay'){?>
											(구)<?php echo $TPL_V1?>

<?php }else{?>
											<?php echo $TPL_V1?>

<?php }?>
									</label>
<?php }?>
<?php }?>
<?php }}?>
								</span>
							<span class="icon-check hand all-check ml10"><b>전체</b></span>
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
				<button type="button" id="set_default_apply_button" onclick="set_search_form('temporary')" class="resp_btn v3">기본검색적용</button>
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

<!-- 주문리스트 테이블 : 시작 -->
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="40" />
		<col width="40" />
		<col width="60" />
		<col width="95" />
		<col width="275" />
		<col />
		<col width="150" />
		<col width="50" />
		<col width="70" />
		<col width="88" />
		<col width="80" />
	</colgroup>
	<thead class="lth">
	<tr>
		<th>선택</th>
		<th>중요</th>
		<th>번호</th>
		<th>주문일시</th>
		<th>주문번호</th>
		<th>주문상품</th>
		<th>주문자</th>
		<th>결제수단</th>
		<th>결제금액</th>
		<th>결제일시</th>
		<th>처리상태</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->
	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if(!$TPL_VAR["record"]){?>
	<tr class="list-row">
		<td colspan="11" align="center">검색어가 없거나 검색 결과가 없습니다.</td>
	</tr>
<?php }else{?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
<?php if($TPL_V1["start"]){?>
	<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
	<tr class="list-title-row">
		<td colspan="11" class="list-title-row-td">
			<div class="relative">
<?php if($TPL_V1["step"]== 15){?>
				<div class="ltr-title">
					<span class="step_title">(출고 전)</span>주문접수
					<span class="helpicon" title="접수된 주문의 입금을 확인하세요"></span>
				</div>
<?php }elseif($TPL_V1["step"]== 25){?>
				<div class="ltr-title">
					<span class="step_title">(출고 전)</span>결제확인
					<span class="helpicon" title="결제가 확인된 주문의 상품을 출고하세요"></span>
				</div>
<?php }elseif($TPL_V1["step"]== 35){?>
				<div class="ltr-title">
					<span class="step_title">(출고 전)</span>상품준비
					<span class="helpicon" title="보내지 못했던 상품의 재고가 확보되셨다면 상품을 출고하세요"></span>
				</div>
<?php }elseif($TPL_V1["step"]== 40){?>
				<div class="ltr-title">
					<span class="step_title">(출고 전)</span>부분 출고준비
					<span class="helpicon" title="보내지 못했던 상품의 재고가 확보되셨다면 상품을 출고하세요"></span>
					<a href='../export/catalog?export_status[45]=1'><img src="/admin/skin/default/order/btn_list_release.gif" border="0"></a>
				</div>
<?php }elseif($TPL_V1["step"]== 45){?>
				<div class="ltr-title">
					<span class="step_title">(출고 전)</span> 출고준비
					<span class="helpicon" title="출고리스트에서 출고완료를 처리하세요. 출고수량만큼 재고가 자동 차감됩니다"></span>
					<a href='../export/catalog?export_status[45]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
				</div>
<?php }elseif($TPL_V1["step"]== 50){?>
				<div class="ltr-title">
					<span class="step_title">(출고 후)</span>
					부분 출고완료 <span class="helpicon" title="보내지 못했던 상품의 재고가 확보되셨다면 상품을 출고하세요"></span>
					<a href='../export/catalog?export_status[55]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
				</div>
<?php }elseif($TPL_V1["step"]== 55){?>
				<div class="ltr-title">
					<span class="step_title">(출고 후)</span>출고완료
					<span class="helpicon" title="출고리스트에서 배송완료를 처리하세요. 배송완료 시 회원에게 마일리지가 지급됩니다"></span>
					<a href='../export/catalog?export_status[55]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
				</div>
<?php }elseif($TPL_V1["step"]== 60){?>
				<div class="ltr-title ">
					<span class="step_title">(출고 후)</span>부분 배송 중
					<span class="helpicon" title="보내지 못했던 상품의 재고가 확보되셨다면 상품을 출고하세요"></span>
					<a href='../export/catalog?export_status[65]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
				</div>
<?php }elseif($TPL_V1["step"]== 65){?>
				<div class="ltr-title">
					<span class="step_title">(출고 후)</span>배송 중
					<span class="helpicon" title="출고리스트에서 배송완료를 처리하세요. 배송완료 시 회원에게 마일리지가 지급됩니다"></span>
					<a href='../export/catalog?export_status[65]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
				</div>
<?php }elseif($TPL_V1["step"]== 70){?>
				<div class="ltr-title">
					<span class="step_title">(출고 후)</span>부분 배송완료
					<span class="helpicon" title="보내지 못했던 상품의 재고가 확보되셨다면 상품을 출고하세요"></span>
					<a href='../export/catalog?export_status[75]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
				</div>
<?php }elseif($TPL_V1["step"]== 75){?>
				<div class="ltr-title">
					<span class="step_title">(출고 후)</span>배송완료
					<span class="helpicon" title="배송완료가 처리되어 회원에게 마일리지가 지급되었습니다"></span>
					<a href='../export/catalog?export_status[75]=1'><span class="export-list"><span class="hide">출고리스트</span></span></a>
				</div>
<?php }elseif($TPL_V1["step"]== 85){?>
				<div class="ltr-title">
					<span class="step_title">(출고 전)</span>결제취소(전체)
					<span class="helpicon" title="결제를 취소한 주문입니다. 환불리스트에서 환불을 처리하세요."></span>
				</div>
<?php }elseif($TPL_V1["step"]== 95){?>
				<div class="ltr-title">
					<span class="step_title">(출고 전)</span>주문무효
					<span class="helpicon" title="입금이 안되어 무효 처리된 주문입니다"></span>
				</div>
<?php }elseif($TPL_V1["step"]== 99){?>
				<div class="ltr-title">
					<span class="step_title">(출고 전)</span>결제실패
					<span class="helpicon" title="주문할 때 오류가 발생한 주문입니다"></span>
				</div>
<?php }?>
				<ul class="left-btns clearbox">
					<li>
						<select class="list-select custom-select-box-multi" name="select_<?php echo $TPL_V1["step"]?>"  rows="4">
							<option value="select">전체선택</option>
							<option value="not-select">선택안함</option>
							<option value="important">별표선택</option>
							<option value="not-important">별표없음</option>
						</select>
					</li>
					<li>
						<span class="btn small"><button name="goods_temps"  id="<?php echo $TPL_V1["step"]?>">완전삭제</button></span>
					</li>
				</ul>

				<!-- EXCEL -->
				<ul class="right-btns clearbox">

				</ul>
			</div>
		</td>
	</tr>
	<!-- 리스트타이틀(주문상태 및 버튼) : 끝 -->
<?php }?>
	<tr class="list-row step<?php echo $TPL_V1["step"]?>">
		<td align="center"><input type="checkbox" name="order_seq[]" value="<?php echo $TPL_V1["order_seq"]?>" /></td>
		<td align="center">
<?php if($TPL_V1["important"]){?>
			<span class="icon-star-gray hand checked list-important important-<?php echo $TPL_V1["step"]?>" id="important_<?php echo $TPL_V1["order_seq"]?>"></span>
<?php }else{?>
			<span class="icon-star-gray hand list-important important-<?php echo $TPL_V1["step"]?>" id="important_<?php echo $TPL_V1["order_seq"]?>"></span>
<?php }?>
		</td>
		<td align="center"><?php echo $TPL_V1["no"]?></td>
		<td align="center"><?php echo substr($TPL_V1["regist_date"], 2, - 3)?></td>
		<td align="center">
			<span class="blue bold"><?php echo $TPL_V1["order_seq"]?></span>

			<a href="javascript:printOrderView('<?php echo $TPL_V1["order_seq"]?>', 'catalog')"><span class="icon-print-order"></a>

			<!--
			<a href="view?no=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><span class="btn-administration"><span class="hide">새창</span></span></a>
			-->
			<span class="btn-direct-open"><span class="hide">바로열기</span></span>
		</td>
		<td align="left">
<?php if($TPL_V1["item_cnt"]< 2){?>
			<div class="goods_name"><?php echo $TPL_V1["goods_name"]?></div>
<?php }else{?>
			<div class="goods_name"><?php echo $TPL_V1["goods_name"]?></div>
			<div>외 <?php echo $TPL_V1["item_cnt"]- 1?>건</div>
<?php }?>
		</td>
		<td class="hand" onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','<?php echo $TPL_V1["order_seq"]?>','right');">
<?php if($TPL_V1["member_seq"]){?>
			<div>
<?php if($TPL_V1["member_type"]=='개인'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" />
<?php }elseif($TPL_V1["member_type"]=='기업'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" /><?php }?>
				<?php echo $TPL_V1["order_user_name"]?>

<?php if($TPL_V1["sns_rute"]){?>
				<span>(<img src="/admin/skin/default/images/sns/sns_<?php echo substr($TPL_V1["sns_rute"], 0, 1)?>0.gif" align="absmiddle" class="btnsnsdetail">/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
						</span>
<?php }else{?>
<?php if($TPL_V1["mbinfo_rute"]=='facebook'){?>
				(<span style="color:#d13b00;"><img src="/admin/skin/default/images/board/icon/sns_f0.gif" align="absmiddle"><?php echo $TPL_V1["mbinfo_email"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
<?php }else{?>
				(<span style="color:#d13b00;"><?php echo $TPL_V1["userid"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
<?php }?>
<?php }?>
			</div>
<?php }else{?>
			<img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <?php echo $TPL_V1["order_user_name"]?> (<span class="desc">비회원</span>)
<?php }?>
		</td>
		<td align="center">
<?php if($TPL_V1["payment"]=='escrow_account'){?>
			<span class="icon-pay-escrow"><span>에스크로</span></span>
			<span class="icon-pay-account"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }elseif($TPL_V1["payment"]=='escrow_virtual'){?>
			<span class="icon-pay-escrow"><span>에스크로</span></span>
			<span class="icon-pay-virtual"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }else{?>
			<span class="icon-pay-<?php echo $TPL_V1["payment"]?>"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }?>
		</td>
		<td align="right"><b><?php echo get_currency_price($TPL_V1["settleprice"])?></b></td>
		<td align="center"><?php echo substr($TPL_V1["deposit_date"], 2, - 3)?></td>
		<td align="center"><?php echo $TPL_V1["mstep"]?></td>
	</tr>
	<!--<tr><td colspan="11" style="padding-top:3px;"></td></tr>-->
	<tr class="order-list-summary-row hide">
		<td colspan="11" class="order-list-summary-row-td"><div class="order_info" style="padding-top:2px;"></div></td>
	</tr>
	<!-- 리스트데이터 : 끝 -->
<?php if($TPL_V1["end"]){?>
	<!-- 합계 : 시작 -->
	<tr class="list-end-row">
		<td colspan="11" class="list-end-row-td">
			<ul class="left-btns clearbox">
				<li>
					<select class="list-select custom-select-box-multi" name="select_<?php echo $TPL_V1["step"]?>"  rows="4">
						<option value="select">전체선택</option>
						<option value="not-select">선택안함</option>
						<option value="important">별표선택</option>
						<option value="not-important">별표없음</option>
					</select>
				</li>
				<li>
					<span class="btn small"><button name="goods_temps"  id="<?php echo $TPL_V1["step"]?>">완전삭제</button></span>
				</li>
			</ul>
			<div class="list-end-total-amount">
				<?php echo $TPL_V1["mstep"]?> <span class="darkgray">합계</span> &nbsp; <?php echo number_format($TPL_V1["step_cnt"][$TPL_V1["step"]])?>건
				&nbsp;&nbsp;&nbsp;
				<?php echo $TPL_VAR["currency_symbol"]['symbol']?> <span class="fx14"><?php echo get_currency_price($TPL_V1["tot_settleprice"][$TPL_V1["step"]])?></span>
			</div>
		</td>
	</tr>
	<!-- 합계 : 끝 -->
<?php }?>
<?php }}?>
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->
</table>

<div id="goods_export_dialog"></div>

<div id="export_upload" class="hide">
	<form name="excelRegist" id="excelRegist" method="post" action="../order_process/excel_upload" enctype="multipart/form-data"  target="actionFrame">
		<table class="search-form-table" style="width:100%;">
			<tr>
				<td>주문내역을 다운로드 받으신 후 등록해 주시길 바랍니다.</td>
			</tr>
			<tr>
				<td style="height:30px;text-align:center;"><input type="file" name="excel_file" id="excel_file"/></td>
			</tr>
			<tr><td height="15"></td></tr>
			<tr>
				<td>일괄 업로드 후 주문상태를
					<select name="step">
						<option value="55">출고완료</option>
						<option value="45">출고준비</option>
					</select>
					로 변경합니다.
				</td>
			</tr>
		</table>

		<div style="width:100%;text-align:center;padding-top:10px;">
			<span class="btn large cyanblue"><button id="upload_submit">확인</button></span>
		</div>


		<div style="padding:15px;"></div>
		<table class="info-table-style" style="width:100%">
			<tr>
				<th class="its-th-align left" style="padding-left:20px;vertical-align:center;">
					<div style="height:25px;">* 출고수량, 택배사코드, 송장번호 내용만 적용됩니다.</div>
					<div style="height:25px;">* 다운로드 받으신 xls파일을 수정하여 업로드 해주세요.</div>
					<div style="height:25px;">( <span style="color:red;">필독! 엑셀파일 저장시 확장자가 XLS 인 엑셀 97~2003 양식으로 다시저장해 주세요</span> )</div>
				</th>
			</tr>
		</table>


		<div class="item-title">택배사 코드 안내</div>
		<table class="info-table-style" style="width:100%">
			<colgroup>
				<col width="17%" />
				<col width="16%" />
				<col width="17%" />
				<col width="16%" />
				<col width="17%" />
				<col width="16%" />
			</colgroup>
			<thead>
			<tr>
				<th class="its-th-align center">택배사</th>
				<th class="its-th-align center">코드</th>
				<th class="its-th-align center">택배사</th>
				<th class="its-th-align center">코드</th>
				<th class="its-th-align center">택배사</th>
				<th class="its-th-align center">코드</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<!-- <?php if(is_array($TPL_R1=config_load('delivery_url'))&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?> -->
<?php if($TPL_I1% 3== 0&&$TPL_I1!= 0){?></tr><tr><?php }?>
				<td class="its-td-align center"><?php echo $TPL_V1["company"]?></td>
				<td class="its-td-align center"><?php echo $TPL_K1?></td>
				<!-- <?php }}?> -->
			</tr>
			</tbody>
		</table>

	</form>
</div>

<!-- 기본검색설정 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchDefaultConfig.js"></script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>