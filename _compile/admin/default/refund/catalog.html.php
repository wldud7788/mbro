<?php /* Template_ 2.2.6 2022/05/17 12:36:52 /www/music_brother_firstmall_kr/admin/skin/default/refund/catalog.html 000019016 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<!-- 2021.12.30 11월 3차 패치 by 김혜진 -->
<script type="text/javascript">
	var search_type				= "<?php echo $TPL_VAR["sc"]["search_type"]?>";
	//기본검색설정
	var default_search_pageid	= "refund";
	var default_obj_width		= 750;
	var default_obj_height		= 260;

	/* variable for ajax list */
	var npage					= 1;
	var nstep					= '';
	var nnum					= '';
	var stepArr					= new Array();
	var start_search_date		= "<?php echo date('Y-m-d',strtotime('-7 day'))?>";
	var end_search_date			= "<?php echo date('Y-m-d')?>";
	var loading_status			= 'n';
	var searchTime				= "<?php echo date('Y-m-d H:i:s')?>";

<?php if($_SERVER["QUERY_STRING"]){?>
	var queryString			= '<?php echo $_SERVER["QUERY_STRING"]?>';
<?php }else{?>
	var queryString			= 'noquery=true';
<?php }?>

		$(document).ready(function() {

			// 환불 검색 필터 전체 체크		 2019-08-07 sms
			$(".all-check").toggle(function(){
				$(this).parent().find('input[type=checkbox]').attr('checked',true);
			},function(){
				$(this).parent().find('input[type=checkbox]').attr('checked',false);
			});

			// 체크박스 색상
			$("input[type='checkbox'][name='refund_code[]']").live('change',function(){
				if($(this).is(':checked')){
					$(this).closest('tr').addClass('checked-tr-background');
				}else{
					$(this).closest('tr').removeClass('checked-tr-background');
				}
			}).change();


			$('input[name="refund_provider_seq"]').live('change',function(){
				if(this.value > 1)	$('.provider_msg').show();
				else				$('.provider_msg').hide();
			});

			$('#shipping_price_refund_btn').click(function(){
				openDialog("환불신청(배송비)", "other_refund_step", {"width":"600"});
			});

			$('#refund_info_btn').click(function(){
				openDialog("안내) 환불 종류", "refund_help", {"width":"1000"});
			});

			$(window).css('overflow', 'scroll');
			$(window).scroll(function(){
				if	((($(document).height() - $(window).height()) - $(window).scrollTop()) < 100 ){
					get_catalog_ajax();
				}
			});

			get_catalog_ajax();
		});

		// 페이징을 위한 데이터 로드
		function get_catalog_ajax(){

			if	(loading_status == 'n'){
				loading_status	= 'y';
				var stepArrCnt			= stepArr.length;
				var addParam			= '';
				for (var s = 0; s < stepArrCnt; s++ ){
					if	(stepArr[s]){
						addParam	+= '&stepBox%5B'+s+'%5D='+stepArr[s];
					}
				}

				$("#ajaxLoadingLayer").ajaxStart(function() { loadingStop(this); });
				$.ajax({
					type: 'post',
					url: 'catalog_ajax',
					data: queryString +'&page='+npage+'&bfStep='+nstep+'&nnum='+nnum+'&searchTime='+searchTime+addParam,
					dataType: 'html',
					success: function(result) {
						$(".refund-ajax-list").append(result);
						$(".custom-select-box").customSelectBox();
						$(".custom-select-box-multi").customSelectBox({'multi':true});

						nstep	= $("#"+npage+"_step").val();
						nnum	= $("#"+npage+"_no").val();
						npage++;

						$("tr.pageoverflow").hide();
						if(nnum>0) loading_status	= 'n';
						help_tooltip();
					}
				});
				if(nnum>0)$("tr.pageoverflow:last").show();
			}
		}

		var search_pop	= {};
		function order_search(){
			url			= '../order/order_search_popup?return_func=select_order&search_page=refund_shipping';
			search_pop	= window.open(url,'order_search_pop','width=1000,height=700,scrollbars=1,toolbar=0,status=0,resizable=0,menubar=0');
		}

		function delete_refund(id){
			var st = '.refund_code_' + id;
			var refund_code = new Array();
			$(st+":checked").each(function(idx){
				refund_code[idx] = 'code[]='+$(this).val();
			});

			var mstatus = (id=='request') ? '신청' : '처리중';

			if(refund_code.length > 0){
				openDialogConfirm('해당 환불 '+mstatus+' 건을 철회하겠습니까?',400,160,function(){
					var str = refund_code.join('&');
					$.ajax({
						type: "POST",
						url: "../refund_process/batch_reverse_refund",
						data: str,
						success: function(result){
							openDialogAlert(result,600,200,function(){
								document.location.reload();
							});
						}
					});
				});
			}else{
				alert("선택값이 없습니다.");
				return;
			}
		}

		function selected_order_seq(order_seq){
			var params			= {};
			params.order_seq	= order_seq;
			search_pop.close();
			$('#selected_order_seq').val(order_seq);
			$('.selected_order_seq').html(order_seq);
			$('.selected_order_seq').show();

			$.get('../order/get_order_info',params, function(response){
				set_provider_list(response.shipping_provider);
			},'json');
		}

		function set_provider_list(provider_list){
			if(provider_list.length < 1) return

			$('#order_provider_list').html('');

			for(i = 0, r_cnt = provider_list.length; i < r_cnt; i++){
				now_option		= provider_list[i];
				checked_opt		= '';
				if(i == 0){
					if(now_option.provider_seq > 1)	$('.provider_msg').show();
					else							$('.provider_msg').hide();
					checked_opt	= 'checked';
				}

				add_radio		= '<label><input type="radio" name="refund_provider_seq" value="' + now_option.provider_seq + '" ' +checked_opt+'/> ';
				add_radio		+= now_option.provider_name + ' [' + now_option.provider_seq + ']</label><br/>';
				$('#order_provider_list').append(add_radio);
			}
<?php if(serviceLimit('H_AD')){?>
			$('.has_provider').show();
<?php }?>
		}

		function check_refund(){
			var order_seq		= $('#selected_order_seq').val();

			if(order_seq.length < 15){
				alert('환불과 관계된 주문을 선택하세요.');
				return false;
			}

			var params				= {};
			params.order_seq		= order_seq;
			params.provider_seq		= $('input[name="refund_provider_seq"]:checked').val();
			params.reason_detail	= $('#refund_reason_detail').val();
			params.refund_bank_code	= $('#refund_bank').val();
			params.refund_bank_name	= $('#refund_bank > option:selected').text();
			params.refund_depositor	= $('#refund_depositor').val();
			params.refund_account	= $('#refund_account').val();

			$.post('../refund_process/shipping_price_refund', params, function(response){
				if(response.success == 'Y'){
					openDialogAlert("배송비환불 신청이 완료되었습니다.",400,140,function(){document.location.reload();});
				}else{
					openDialogAlert("배송비환불 신청 실패.",400,140);
				}

			},'json');
		}
</script>
<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js?v=<?php echo date('Ymd')?>"></script>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/searchform.css" />
<style>
	.goods_name {display:inline-block;white-space:nowrap;overflow:hidden;width:290px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	.search_label 	{display:inline-block;width:80px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	span.step_title { font-weight:normal;padding-right:5px }

	div.refund-top-step {width:100%;text-align:center;margin-top:10px;}
	span.step-title {padding:5px 10px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;}
	span.step-title.gray {background-color:#afafaf;color:#000;}
	span.step-title.black {background-color:#000000;color:#fff;}
	div.refund-top-step-title {font-size:15px;font-weight:bold;margin:20px 0 10px 0;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>환불 리스트</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span class="btn large orange"><button id="refund_info_btn">안내) 환불 종류</button></span></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large"><button id="shipping_price_refund_btn">환불신청(배송비)</button></span></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<form name="orderForm" id="orderForm">
	<!-- 주문리스트 검색폼 : 시작 -->
	<div class="search-form-container search_container">
		<table class="table_search">
			<tr>
				<th>검색어</th>
				<td>
					<select name="keyword_type" style="width:103px;">
						<option value="">통합검색</option>
						<option value="ref.refund_code">환불번호</option>
						<option value="ord.order_seq">주문번호</option>
						<option value="ord.order_user_name">주문자명</option>
						<option value="ord.depositor">입금자명</option>
						<option value="mem.userid">아이디</option>
					</select>
					<script>$("select[name='keyword_type']").val("<?php echo $_GET["keyword_type"]?>");</script>
					<input type="text" name="keyword" value="<?php echo $_GET["keyword"]?>" title="환불번호, 아이디, 회원명, 주문자명, 수령자명, 상품명(매입상품명,사은품명), 상품코드" size="82"/>
	</div>
	</td>
	</tr>
	</table>

	<div class="search-detail-lay">
		<table class="search-form-table" id="search_detail_table">
			<tr id="goods_search_form" >
				<td>
					<table class="sf-option-table table_search">
						<tr>
							<th>날짜</th>
							<td>
								<select name="date_field" class="search_select" default_none style="width:100px; border:1px solid #a7a8aa;color: #797d86;">
									<option value="ref.regist_date" <?php if($_GET["date_field"]=='ref.regist_date'||!$_GET["date_field"]){?>selected<?php }?>>환불신청일</option>
									<option value="ref.refund_date" <?php if($_GET["date_field"]=='ref.refund_date'){?>selected<?php }?>>환불완료일</option>
								</select>

								<input type="text" name="sdate" value="<?php echo $_GET["sdate"]?>" class="datepicker"  maxlength="10" style="width:80px" default_none />
								&nbsp;<span class="gray">-</span>&nbsp;
								<input type="text" name="edate" value="<?php echo $_GET["edate"]?>" class="datepicker" maxlength="10" style="width:80px" default_none />

								<span class="resp_btn_wrap">
								<span class="btn small"><input type="button" value="오늘" id="today" class="select_date resp_btn"/></span>
								<span class="btn small"><input type="button" value="3일간" id="3day" class="select_date resp_btn"/></span>
								<span class="btn small"><input type="button" value="일주일" id="1week" class="select_date resp_btn"/></span>
								<span class="btn small"><input type="button" value="1개월" id="1month" class="select_date resp_btn"/></span>
								<span class="btn small"><input type="button" value="3개월" id="3month" class="select_date resp_btn"/></span>
								<span class="btn small"><input type="button" value="전체" id="all" class="select_date resp_btn"/></span>
							</span>
							</td>
						</tr>
						<tr>
							<th>상태</th>
							<td>
								<span class="resp_checkbox">
									<label><input type="checkbox" name="refund_status[]" value="request" <?php if($_GET["refund_status"]&&in_array('request',$_GET["refund_status"])){?>checked<?php }?>/> 환불신청</label>
									<label><input type="checkbox" name="refund_status[]" value="ing" <?php if($_GET["refund_status"]&&in_array('ing',$_GET["refund_status"])){?>checked<?php }?>/> 환불처리중</label>
									<label><input type="checkbox" name="refund_status[]" value="complete" <?php if($_GET["refund_status"]&&in_array('complete',$_GET["refund_status"])){?>checked<?php }?> row_check_all /> 환불완료</label>
								</span>
								<span class="icon-check hand all-check ml10"><b>전체</b></span>
							</td>
						</tr>
<?php if($TPL_VAR["npay_use"]){?>
						<tr>
							<th>Npay 취소요청</th>
							<td no=1>
								<label><input type="checkbox" name="search_npay_order_cancel" value=1 <?php if($_GET["search_npay_order_cancel"]){?>checked<?php }?>> 조회</label>
							</td>
<?php }?>
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
				<button type="button" id="set_default_apply_button" onclick="set_search_form('refund')" class="resp_btn v3">기본검색적용</button>
			</span>
			<span class="search">
				<button type="submit" class="resp_btn active size_XL"><span>검색</span></button>
				<button type="button" id="search_reset_button" class="resp_btn v3 size_XL">초기화</button>
			</span>
			<span class="detail">
				<button type="button" id="search_detail_button" class="close resp_btn v3" value="open">상세검색닫기</button>
			</span>
		</div>
	</div>
	</div>
	<!-- 주문리스트 검색폼 : 끝 -->

	<!-- 주문리스트 테이블 : 시작 -->
	<table class="list-table-style" cellspacing="0">
		<!-- 테이블 헤더 : 시작 -->
		<colgroup>
			<col width="50" /><!--삭제-->
			<col width="50" /><!--번호-->
			<col width="150" /><!--환불 접수 일시-->
			<col width="140" /><!--주문번호-->
			<col /><!--주문자-->
			<col width="60" /><!--결제-->
			<col width="50" /><!--주문수량-->
			<col width="60" /><!--반품-->
			<col width="60" /><!--결제취소-->
			<col width="70" /><!--환불 방법-->
			<col width="70" /><!--환불 금액-->
			<col width="130" /><!--환불완료 일시-->
			<col width="70" /><!--환불-->
			<col width="70" /><!--반품-->
		</colgroup>
		<thead class="lth">
		<tr class="double-row th">
			<th rowspan="2">삭제</th>
			<th rowspan="2">번호</th>
			<th>환불 접수 일시</th>
			<th rowspan="2">주문번호</th>
			<th rowspan="2">주문자</th>
			<th rowspan="2">결제</th>
			<th rowspan="2">주문<br />수량</th>
			<th colspan="3">환불 종류</th>
			<th rowspan="2">환불 방법</th>
			<th rowspan="2">환불 금액</th>
			<th rowspan="2">환불완료 일시</th>
			<th colspan="2">처리 상태</th>
		</tr>
		<tr class="double-row th">
			<th>환불 번호</th>
			<th>반품</th>
			<th>결제취소</th>
			<th>배송비</th>
			<th>환불</th>
			<th>반품</th>
		</tr>
		</thead>
		<!-- 테이블 헤더 : 끝 -->
		<!-- 리스트 : 시작 -->
		<tbody class="ltb refund-ajax-list"></tbody>
		<!-- 리스트 : 끝 -->
	</table>
	<!-- 주문리스트 테이블 : 끝 -->
</form>

<!-- 기본검색설정 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchDefaultConfig.js"></script>
<div class="hide" id="other_refund_step">
	<div class="refund-top-step-title">1. 주문을 선택하세요.</div>
	<div>
		<table width="100%" class="info-table-style">
			<colgroup>
				<col width="25%">
				<col>
			</colgroup>
			<tbody>
			<tr>
				<th class="its-th-align left" style="padding-left:10px">주문</th>
				<td class="its-td">
					<div>
						<div class="selected_order_seq red bold" style="width:160px;float:left">&nbsp;</div>
						<span class="btn small gray has_order" style="float:left"><button type="button" onclick="order_search();">검색</button></span>
						<input type="hidden" id="selected_order_seq"/>
					</div>
				</td>
			</tr>
			<tr class="has_provider hide">
				<th class="its-th-align left" style="padding-left:10px">판매자</th>
				<td class="its-td">
					<div id="order_provider_list"></div>
					<div class="provider_msg red hide" style="clear:both; padding-top:10px;">선택된 판매자 : 환불완료 시 환불금액이 정산에 반영됩니다.</div>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<div class="refund-top-step-title">2. 환불정보를 입력하세요.</div>
	<div>
		<table width="100%" class="info-table-style">
			<colgroup>
				<col width="25%">
				<col>
			</colgroup>
			<tbody>
			<tr >
				<th class="its-th-align left" style="padding-left:10px">환불사유</th>
				<td class="its-td">배송비</td>
			</tr>
			<tr >
				<th class="its-th-align left" style="padding-left:10px">환불상세사유</th>
				<td class="its-td">
					<input id="refund_reason_detail" value="" size="50"/>
				</td>
			</tr>
			<tr >
				<th class="its-th-align left" style="padding-left:10px">환불방법(무통장)</th>
				<td class="its-td">

					<select id="refund_bank">
						<option value=''>은행선택</option>
<?php if(is_array($TPL_R1=code_load('bankCode'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><option value='<?php echo $TPL_V1["codecd"]?>'><?php echo $TPL_V1["value"]?></option><?php }}?>
					</select>
					<input type="text" id="refund_depositor" size="4" class="line" title="예금주" />
					&nbsp;
					<input type="text" id="refund_account" size="26" class="line"  title="계좌번호"/>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<div align="center" style="padding-top:10px;">
		<span class="btn large deepblue">
			<button onClick="check_refund()">환불신청<span class="arrowright"></span></button>
		</span>
	</div>
</div>

<div class="hide" id="refund_help">
	<table class="info-table-style" width="100%">
		<colgroup>
			<col width="42%" />
			<col width="14%" />
			<col width="20%" />
			<col width="24%" />
		</colgroup>
		<tr>
			<th class="its-th-align center" colspan="2">환불(고객에게 돈을 되돌려 드리는)의 경우</th>
			<th class="its-th-align center">매출 (결제확인 기준)</th>
			<th class="its-th-align center">판매자 정산 (배송완료 기준)</th>
		</tr>
		<tr>
			<td align="right" class="its-td pd10">배송(출고) 전에 취소를 한 경우</td>
			<td align="center" class="its-td bold red">결제취소</td>
			<td align="left" class="its-td pd10">환불완료 시 <span class="bold underline">취소금액</span> 반영</td>
			<td align="left" class="its-td pd10">관계 없음</td>
		</tr>
		<tr>
			<td align="right" class="its-td pd10">배송 받은 상품을 반품하고 환불 받는 경우</td>
			<td align="center" class="its-td bold red">반품→환불</td>
			<td align="left" class="its-td pd10">환불완료 시 <span class="bold underline">환불금액</span> 반영</td>
			<td align="left" class="its-td pd10">해당 판매자의 정산 시 차감 반영</td>
		</tr>
		<tr>
			<td align="right" class="its-td pd10">2개이상의 주문을 합포장(묶음배송)해서 배송비를 환불 드리는 경우</td>
			<td align="center" class="its-td bold red">배송비→환불</td>
			<td align="left" class="its-td pd10">환불완료 시 <span class="bold underline">환불금액</span> 반영</td>
			<td align="left" class="its-td pd10">해당 판매자의 정산 시 차감 반영</td>
		</tr>
	</table>
</div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>