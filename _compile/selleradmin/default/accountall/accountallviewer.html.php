<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/accountall/accountallviewer.html 000034993 */ 
$TPL_year_1=empty($TPL_VAR["year"])||!is_array($TPL_VAR["year"])?0:count($TPL_VAR["year"]);
$TPL_month_1=empty($TPL_VAR["month"])||!is_array($TPL_VAR["month"])?0:count($TPL_VAR["month"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>

<script type="text/javascript" >
	// 정산 데이터 ajax 호출
	var loading_status					= new Array();
	loading_status['sale']				= new Array();
	loading_status['sale']['carry']		= 'n';
	loading_status['sale']['current']	= 'n';
	loading_status['acc']				= new Array();
	loading_status['acc']				= new Array();
	loading_status['acc']['carry']		= 'n';
	loading_status['acc']['current']	= 'n';

	// 페이지당 노출 수 전역변수
	var gl_perpage	= "<?php echo $TPL_VAR["perpage"]?>";
	
	$(document).ready(function() {
		gSearchForm.init({'pageid':'accountallviewerall','sc':<?php echo $TPL_VAR["scObj"]?>});

		//해더타이틀과 body 따라다니기 checked-tr-background
		$(".account-table-grid-body").on("scroll", $.proxy(function(e) {
			$(".account-table-grid-header").scrollLeft(e.target.scrollLeft);
		}, this));

		$("button[name='order_referer_btn']").click(function(){
			var order_referer = $(this).attr("order_referer");
			$("#order_referer").val(order_referer);
			$("#accountsearch").submit();
		});

		$("select[name='s_year'] option[value='<?php echo $_GET["s_year"]?>']").attr('selected',true);
		$("select[name='s_month'] option[value='<?php echo $_GET["s_month"]?>']").attr('selected',true);

		$(".result_false_file").click(function(){
			var result_excel_url = $(this).attr("result_excel_url");
			$("iframe[name=actionFrame]").attr("src", result_excel_url);
			//document.location.href=result_excel_url;
		});

		$("input[name='order_referer[]'][value='all']").on("click",function(){
			if($(this).is(":checked") == true){
				$("input[name='order_referer[]']").prop("checked",true);
			}else{
				$("input[name='order_referer[]']").prop("checked",false);
			}
		});
		// 정산데이터 조회
		get_acc_all_list();
	});


	// 정산데이터 전체 조회
	function get_acc_all_list(){
		get_acc_carry_list();
		get_acc_current_list();
	}
	// 정산데이터 이월 조회
	function get_acc_carry_list(){
		get_data_list_ajax('sale', 'carry');
		get_data_list_ajax('acc', 'carry');
	}
	// 정산데이터 당월 조회
	function get_acc_current_list(){
		get_data_list_ajax('sale', 'current');
		get_data_list_ajax('acc', 'current');
	}
	// 정산데이터 ajax
	function get_data_list_ajax(pagemode, targetmode){
		var params = $("#accountsearch").serialize();
		var page =  $("#"+targetmode+"_page").val();
		var last_num =  $("#"+targetmode+"_last_num").val();
		var add_params = 
			"&pagemode=" + pagemode + 
			"&targetmode=" + targetmode + 
			"&"+targetmode+"_page=" + page +
			"&"+targetmode+"_last_num="+last_num
		;
		
		params = params + add_params;
		
		if(loading_status[pagemode][targetmode] == 'n' 
			&& $("#"+targetmode+"_total_count").val() != '0'
			&& (parseInt($("#"+targetmode+"_total_count").val()) > parseInt($("#"+targetmode+"_last_num").val()))
		){
			loading_status[pagemode][targetmode] = 'y';
			
			$("#ajaxLoadingLayer").ajaxStart(function() { loadingStop(this); });
			$(".more_btn_" + pagemode + "_" + targetmode).remove();

			$.ajax({
				type: 'get',
				url: 'accountallviewerall',
				data: params,
				dataType: 'html',
				success: function(result) {
					$("#list_" + pagemode + "_" + targetmode).append(result);
					// 데이터 존재 여부 확인
					if(
						$("#"+targetmode+"_total_count").val() != '0'
						&& parseInt($("#"+targetmode+"_total_count").val()) > parseInt($("#"+targetmode+"_last_num").val()
						&& parseInt($("#"+targetmode+"_total_count").val()) > parseInt(gl_perpage) // 100개 이상일때만 더보기 출력
					)){
						var more_btn = $("<div class='more_btn_" + pagemode + "_" + targetmode + "'><button type='button'>더보기</button></div>");
						$("#list_" + pagemode + "_" + targetmode).append(more_btn);
					}

					$(".more_btn_" + pagemode + "_" + targetmode + "").off("click");
					$(".more_btn_" + pagemode + "_" + targetmode + "").on("click", function(){
						if(targetmode=='carry'){
							get_acc_carry_list();
						}else if(targetmode=='current'){
							get_acc_current_list();
						}
					});
					
					loading_status[pagemode][targetmode] = 'n';
				}
			});
		}
	}
	
	function accountlallExcel(){
		var formData		= $('[name="accountsearch"]').serialize();
		actionFrame.location.href		= '../accountall/accountallviewerall?accountall_excel=1&'+formData;
	}

// 스크롤 컨트롤
$(function() {
	var xxx = 0;
	
	$(".listCarryScroll").mouseenter(function() {
		$(".listCarryScroll").not($(this)).off('scroll');
		$(this).on('scroll', function() {
			var scroll_value = $(this).scrollTop();
			$(".listCarryScroll").not($(this)).scrollTop( scroll_value );
			
			var tableLayer = $(this).height();
			var listLayer = $(this).find(".calc-table-style").height();
			
			if(((listLayer - tableLayer) - scroll_value) < 200 ){
				get_acc_carry_list();
			}
		});
	});
	$(".listCurrentScroll").mouseenter(function() {
		$(".listCurrentScroll").not($(this)).off('scroll');
		$(this).on('scroll', function() {
			var scroll_value = $(this).scrollTop();
			$(".listCurrentScroll").not($(this)).scrollTop( scroll_value );
			
			var tableLayer = $(this).height();
			var listLayer = $(this).find(".calc-table-style").height();
			
			if(((listLayer - tableLayer) - scroll_value) < 200 ){
				get_acc_current_list();
			}
		});
	});
	$(".colgroupAcc").mouseenter(function() {
		$(".colgroupAcc").not($(this)).off('scroll');
		$(this).on('scroll', function() {
			var scroll_value = $(this).scrollLeft();
			$(".colgroupAcc").not($(this)).scrollLeft( scroll_value );
		});
	});
	

	$('#topScroll .calc-table-style colgroup col').each(function() {
		xxx = xxx + parseInt( $(this).attr('width') );
	});
	$('#topScroll .calc-table-style').css( 'width', xxx + 'px' );
	$('.colgroupAcc .calc-table-style').css( 'width', xxx + 'px' );

});
</script>

<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/accountall.css?v=<?php echo date('Ymd')?>" />


<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>주문별 정산</h2>
		</div>	
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<!-- 리스트검색폼 : 시작 -->
<div id="search_container" class="search_container">
	<input type="hidden" name="carry_total_count" id="carry_total_count" value="<?php echo $TPL_VAR["carryoverloopcnt"]?>"/>
	<input type="hidden" name="carry_page" id="carry_page" value="<?php echo $TPL_VAR["carry_page"]?>"/>
	<input type="hidden" name="carry_last_num" id="carry_last_num" value="0"/>
	<input type="hidden" name="current_total_count" id="current_total_count" value="<?php echo $TPL_VAR["loopcnt"]?>"/>
	<input type="hidden" name="current_page" id="current_page" value="<?php echo $TPL_VAR["current_page"]?>"/>
	<input type="hidden" name="current_last_num" id="current_last_num" value="0"/>
	<form name="accountsearch" id="accountsearch" class="search_form">
	<input type="hidden" name="perpage" id="perpage" value="<?php echo $TPL_VAR["perpage"]?>"/>
	<table class="table_search">		
		<tr>
			<th>
				기간
			</th>
			<td>				
				<select name="s_year" class="wx80">
<?php if($TPL_year_1){foreach($TPL_VAR["year"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($_GET["s_year"]==$TPL_V1){?> selected="selected" <?php }?> ><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
				<select name="s_month" class="wx80">
<?php if($TPL_month_1){foreach($TPL_VAR["month"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($_GET["s_month"]==$TPL_V1){?> selected="selected" <?php }?> ><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				주문/환불 번호
			</th>
			<td>
				<input type="hidden" name="order_referer" id="order_referer" value="<?php echo $_GET["order_referer"]?>" size="20">
				<input type="text" name="search_seq" value="<?php echo $_GET["search_seq"]?>" size="30" >
				<!--label > <input type="checkbox" name="account_hidden_name" value="hidden" <?php if($_GET["account_hidden_name"]){?> checked="checked" <?php }?>>기본숨김</label>
				<label > <input type="checkbox" name="account_hidden_cal" value="hidden" <?php if($_GET["account_hidden_cal"]){?> checked="checked" <?php }?>>정산숨김</label>
				<label > <input type="checkbox" name="account_hidden_sales" value="hidden" <?php if($_GET["account_hidden_sales"]){?> checked="checked" <?php }?>>매출숨김</label-->
			</td>
		</tr>
		<tr>
			<th>
				결제 및 주문경로
			</th>
			<td>
				<div class="resp_checkbox">
					<div class="resp_radio">
						<label><input type="checkbox" name="order_referer[]" value="all" class="chkall" /> 전체 </label>
						<label><input type="checkbox" name="order_referer[]" value="shop" /> 무통장 </label>
						<label><input type="checkbox" name="order_referer[]" value="pg" /> PG </label>
						<label><input type="checkbox" name="order_referer[]" value="kakaopay" /> 카카오페이 </label>
						<label><input type="checkbox" name="order_referer[]" value="npay" /> 네이버페이 </label>
						<label><input type="checkbox" name="order_referer[]" value="storefarm"  /> 스마트스토어 </label>
						<label><input type="checkbox" name="order_referer[]" value="open11st" /> 11번가 </label>
						<label><input type="checkbox" name="order_referer[]" value="coupang"  /> 쿠팡 </label>
						<label><input type="checkbox" name="order_referer[]" value="shoplinker" /> 샵링커 </label>
					</div>	
				</div>
			</td>
		</tr>		
	</table>

	<div class="search_btn_lay footer"></div>
	</form>
</div>

<div class="contents_dvs v2">	
<?php if($TPL_VAR["sc"]["provider_seq"]&&$TPL_VAR["sc"]["provider_seq"]!="all"&&$TPL_VAR["sc"]["provider_seq"]!="1"){?>
<div class="seller_account_dvs">
	<ul class="ul_list_04">
		<li>
			<dl class="dl_list_01 v3">
				<dt>입점사명</dt>
				<dd class="fx14"><?php echo $TPL_VAR["provider_viewer"]["provider_name"]?></dd>
			</dl>
		</li>

		<li>
			<dl class="dl_list_01 v3">
				<dt>정산 주기</dt>
				<dd class="fx14">월 <?php echo $TPL_VAR["provider"]["calcu_count"]?>회 정산</dd>
			</dl>
		</li>
		
		<li>
			<dl class="dl_list_01 v3">
				<dt>정산 금액</dt>
				<dd>
<?php if($TPL_VAR["accountAllCount"][$TPL_VAR["provider_viewer"]["provider_id"]]["calcu_count"]=='2'){?>
						01일 ~ 15일 (<span class="blue"><?php echo number_format($TPL_VAR["accountAllCount"]["account2"][ 0])?></span>원) <br />
						16일 ~ 말일 (<span class="blue"><?php echo number_format($TPL_VAR["accountAllCount"]["account2"][ 1])?></span>원)
<?php }elseif($TPL_VAR["accountAllCount"][$TPL_VAR["provider_viewer"]["provider_id"]]["calcu_count"]=='4'){?>
						01일 ~ 07일 (<span class="blue"><?php echo number_format($TPL_VAR["accountAllCount"]["account4"][ 0])?></span>원) <br />
						08일 ~ 14일 (<span class="blue"><?php echo number_format($TPL_VAR["accountAllCount"]["account4"][ 1])?></span>원) <br />
						15일 ~ 21일 (<span class="blue"><?php echo number_format($TPL_VAR["accountAllCount"]["account4"][ 2])?></span>원) <br />
						22일 ~ 말일 (<span class="blue"><?php echo number_format($TPL_VAR["accountAllCount"]["account4"][ 3])?></span>원)
<?php }else{?>
						01일 ~ 말일 (<span class="blue"><?php echo number_format($TPL_VAR["accountAllCount"]["account1"][ 0])?></span>원)
<?php }?>
				</dd>
			</dl>
		</li>
	</ul>
</div>
<?php }?>	
<div class="table_row_frame mt20">
	<div class="dvs_top">			
			<div class="dvs_left">	
				<div class="confirm_setting_date">
<?php if($TPL_VAR["accountConfirm"]){?>
					<?php echo $_GET["s_year"]?>년 <?php echo $_GET["s_month"]?>월 정산마감일 : <?php echo $TPL_VAR["accountConfirm"]["confirm_name"]?>(<?php echo $TPL_VAR["accountConfirm"]["confirm_end_date"]?> 마감실행)
<?php }else{?>
					<?php echo $_GET["s_year"]?>년 <?php echo $_GET["s_month"]?>월 정산마감일 : <?php echo $TPL_VAR["accountallConfirmSetting"]["confirm_name"]?>(<?php echo $TPL_VAR["accountallConfirmSetting"]["confirm_date"]?> <font color="red">마감실행예정</font>)
<?php }?>	
				</div>
			</div>

			<div class="dvs_right">	
				<span class="mr5">* 부가세(VAT) 포함</span>
<?php if($TPL_VAR["loopcnt"]> 0||$TPL_VAR["carryoverloopcnt"]> 0||$TPL_VAR["overdrawloopcnt"]> 0){?>
				<button type="button" onclick="accountlallExcel()" class="resp_btn v3"><span class="icon_excel"></span> 다운로드</button>
<?php }else{?>
				<button type="button" onclick="openDialogAlert('조회내역이 없습니다',300,180);"  class="resp_btn v3"><span class="icon_excel"></span> 다운로드</button>
<?php }?>
			</div>
		</div>

		<ul class="scroll_container" style="height:30px;">	
			<?php 
			// 페이징 기능이 추가됨에 따라 동일한 소스가 여러번 반복 되어 통일함 by hed
			 $TPL_VAR["sale_table_colgroup"] = '
				<!-- 테이블 헤더 : 시작 -->
				<colgroup>
					<!--col width="50" /--><!--발생월-->
					<col width="80" /><!--순번-->
					<col width="100" /><!--발 생 일<br />(결제/취소/환불)-->
					<col width="130" /><!--완 료 일<br />(구매확정/취소/환불일)-->
					<col width="150" /><!--주문/취소/환불 번호-->
				'.((!_GET.account_hidden_name)?'
					<col width="80" /><!--구매자-->
					<col width="130" /><!--입점사-->
					<col width="150" /><!--상품/배송비/반품배송비-->
				':'').'
				</colgroup>
			';
			?>
			
			<li id="account_table" class="account_left account_table" style="opacity:1; position:relative; height:<?php echo $TPL_VAR["tableheight"]?>px;">
			  <div class="account-table-grid-left-header account-table-header-scrollbar">
				<table width="100%" class="calc-left-table-style" cellpadding="0" cellspacing="0">
					<!-- 테이블 헤더 : 시작 -->
					<?php echo $TPL_VAR["sale_table_colgroup"]?>

					<thead>
						<tr>
							<!--th scope="col" rowspan="2">발생월</th-->
							<th scope="col" rowspan="2">순번</th>
							<th scope="col" rowspan="2">발 생 일<br />(결제/취소/환불)</th>
							<th scope="col" rowspan="2">완 료 일<br />(구매확정/취소/환불)</th>
							<th scope="col" rowspan="2">주문/환불 번호</th>
<?php if(!$_GET["account_hidden_name"]){?>
							<th scope="col" rowspan="2">구매자</th>
							<th scope="col" rowspan="2">입점사</th>
							<th scope="col" rowspan="2">상품명/배송비/반품배송비</th>
<?php }?>
						</tr>

						<tr>
						</tr>
					</thead>
				</table>
			  </div>
			  <div class="left_scroll_wrap"><!-- 180702 추가 -->
				  <div class="account-table-grid-left-body listCarryScroll" style="height:<?php echo $TPL_VAR["tableheight_carry"]?>px;">
					<table width="100%" class="calc-table-style" cellpadding="0" cellspacing="0">
						<!-- 테이블 헤더 : 시작 -->
						<?php echo $TPL_VAR["sale_table_colgroup"]?>

						<tbody id="list_sale_carry">
<?php if($TPL_VAR["carryoverloopcnt"]){?>
<?php }else{?>
								<tr>
									<td colspan="<?php if($_GET["account_hidden_name"]){?>4<?php }else{?>7<?php }?>" class="right pdr20 nodata bd_bt_4">이월 조회 내역이 없습니다.</td>
								</tr>
<?php }?>
						</tbody>
					</table>
				  </div>
				  <div class="account-table-grid-left-body summryScroll">
					<table width="100%" class="calc-table-style" cellpadding="0" cellspacing="0">
						<!-- 테이블 헤더 : 시작 -->
						<?php echo $TPL_VAR["sale_table_colgroup"]?>

						<tbody>
<?php if($TPL_VAR["carryoverloopcnt"]){?>
								<tr class="its_tr_looptotal">
									<td colspan="<?php if($_GET["account_hidden_name"]){?>4<?php }else{?>7<?php }?>" class="right pdr20 bd_bt_4">합계</td>
								</tr>
<?php }?>
						</tbody>
					</table>
				  </div>
				  <div class="account-table-grid-left-body listCurrentScroll" style="height:<?php echo $TPL_VAR["tableheight_current"]?>px;">
					<table width="100%" class="calc-table-style" cellpadding="0" cellspacing="0">
						<!-- 테이블 헤더 : 시작 -->
						<?php echo $TPL_VAR["sale_table_colgroup"]?>

						<tbody id="list_sale_current">
<?php if($TPL_VAR["loopcnt"]){?>
<?php }else{?>
								<tr>
									<td colspan="<?php if($_GET["account_hidden_name"]){?>4<?php }else{?>7<?php }?>" class="right pdr20 nodata">당월 조회 내역이 없습니다.</td>
								</tr>
<?php }?>
						</tbody>
					</table>
				  </div>
				  <div class="account-table-grid-left-body summryScroll">
					<table width="100%" class="calc-table-style" cellpadding="0" cellspacing="0">
						<!-- 테이블 헤더 : 시작 -->
						<?php echo $TPL_VAR["sale_table_colgroup"]?>

						<tbody>
<?php if($TPL_VAR["loopcnt"]){?>
								<tr  class="its_tr_looptotal">
									<td colspan="<?php if($_GET["account_hidden_name"]){?>4<?php }else{?>7<?php }?>" class="right pdr20">합계</td>
								</tr>
<?php }?>
							<tr class="its_tr_loopname">
								<td colspan="<?php if($_GET["account_hidden_name"]){?>4<?php }else{?>7<?php }?>"></td>
							</tr>
						</tbody>
					</table>
				  </div>
				</div>
			</li>

			<?php 
			// 페이징 기능이 추가됨에 따라 동일한 소스가 여러번 반복 되어 통일함 by hed
			 $TPL_VAR["acc_table_colgroup"] = '
				<!-- 테이블 헤더 : 시작 -->
				<colgroup>
				'.((!_GET.account_hidden_sales)?'
					<col width="50" /><!--판매수량-->
					<col width="80" /><!--판매금액-->
					<col width="80" /><!--할인-본사-->
					<col width="80" /><!--할인-제휴사-->
					<col width="80" /><!--할인-입점사-->
					<col width="80" /><!--결제금액(A)-->
					<col width="80" /><!--실결제액-->
					<col width="80" /><!--예치금-->
				':'').'
				'.((!_GET.account_hidden_cal)?'
					<col width="50" /><!--정산수량-->
					<col width="80" /><!--정산대상(수수료방식)-->
					<col width="80" /><!--정산대상(수수료방식)-결제금액-->
					<col width="80" /><!--정산대상(수수료방식)-본사-->
					<col width="80" /><!--정산대상(수수료방식)-제휴사-->
					<col width="80" /><!--정산대상(공급가방식)-->
					<col width="80" /><!--수수료율(%)-->
					<col width="80" /><!--수수료-->
					<col width="80" /><!--정산금액(B)-->
				':'').'
					<col width="180" /><!--제휴사(PG)<br/>주문번호-->
					<col width="100" /><!--주문경로-->
					<col width="100" /><!--결제수단-->
				</colgroup>
			';
			?>
			<li id="account_table" class="account_right account_table" style="opacity:1; position:relative; height:<?php echo $TPL_VAR["tableheight"]?>px;">
			  <div class="account-table-grid-right-header account-table-header-scrollbar colgroupAcc" id="topScroll">
				<table width="100%" class="calc-table-style" cellpadding="0" cellspacing="0">
					<!-- 테이블 헤더 : 시작 -->
					<?php echo $TPL_VAR["acc_table_colgroup"]?>

					<thead>
						<tr>
<?php if(!$_GET["account_hidden_sales"]){?>
							<th scope="col" rowspan="2">판매<br/>수량</th>
							<th scope="col" rowspan="2" style="font-weight:bold;">판매금액</th>
							<th scope="col" colspan="3">할인</th>
							<th scope="col" colspan="3" class="nobottom" style="font-weight:bold;">결제금액(매출액)(A)</th>
<?php }?>
<?php if(!$_GET["account_hidden_cal"]){?>
							<th scope="col" rowspan="2">정산<br/>수량</th>
							<th scope="col" colspan="4" class="nobottom" style="font-weight:bold;">
								정산대상(수수료방식)
								<span class="helpicon2"
									onclick="openDialog('정산대상(수수료방식)', 'SACO_info_dialog', {'width':400});"
								></span>
								<div id="SACO_info_dialog" class="hide">
									주문된 금액에서 입점사와 무관하게 본사 정책에 따라 할인된<br/>
									금액을 합산한 정산을 위한 기준 금액
								</div>
							</th>
							<th scope="col" rowspan="2" style="font-weight:bold;">
								정산대상<br/>
								(<span style="color:blue;">공급가 방식</span>)
								<span class="helpicon2"
									onclick="openDialog('정산대상(공급가 방식)', 'SUPPLY_info_dialog', {'width':400});"
								></span>
								<div id="SUPPLY_info_dialog" class="hide">
									정산대상 (공급가 방식) : 입점사에 지급하는 금액을 정가에 대한 비율(%) 또는 지급하는 금액을 직접 등록한 정산을 위한 기준금액
								</div>
							</th>
							<th scope="col" rowspan="2" style="font-weight:bold;">
								수수료율(%)<br/>
								(<span style="color:blue;">공급률(%)</span>)
							</th>
							<th scope="col" rowspan="2">수수료</th>
							<th scope="col" rowspan="2" style="font-weight:bold;">정산금액(B)</th>
<?php }?>
							<th scope="col" rowspan="2">제휴사(PG)<br/>주문번호</th>
							<th scope="col" rowspan="2">주문경로</th>
							<th scope="col" rowspan="2">결제수단</th>
						</tr>

						<tr>
<?php if(!$_GET["account_hidden_sales"]){?>
							<th scope="col">본사</th>
							<th scope="col">제휴사</th>
							<th scope="col">입점사</th>
							<th scope="col"></th>
							<th scope="col" class="bordertop">실결제액</th>
							<th scope="col" class="bordertop">예치금</th>
<?php }?>
<?php if(!$_GET["account_hidden_cal"]){?>
							<th scope="col"></th>
							<th scope="col" class="bordertop">결제금액</th>
							<th scope="col" class="bordertop">본사할인</th>
							<th scope="col" class="bordertop">제휴사할인</th>
<?php }?>
						</tr>
					</thead>
				</table>
			  </div>
			  <div class="account-table-grid-right-body listCarryScroll colgroupAcc" style="height:<?php echo $TPL_VAR["tableheight_carry"]?>px;">
				<table width="100%" class="calc-table-style" cellpadding="0" cellspacing="0">
					<!-- 테이블 헤더 : 시작 -->
					<?php echo $TPL_VAR["acc_table_colgroup"]?>

					<tbody id="list_acc_carry">
<?php if($TPL_VAR["carryoverloopcnt"]){?>
<?php }else{?>
							<tr>
								<td colspan="<?php echo ($TPL_VAR["totalcolspan"]- 8)?>" class="nodata bd_bt_4"><!-- 조회 내역이 없습니다. --></td>
							</tr>
<?php }?>
					</tbody>
				</table>
			  </div>
			  <div class="account-table-grid-right-body summryScroll colgroupAcc">
				<table width="100%" class="calc-table-style" cellpadding="0" cellspacing="0">
					<!-- 테이블 헤더 : 시작 -->
					<?php echo $TPL_VAR["acc_table_colgroup"]?>

					<tbody>
<?php if($TPL_VAR["carryoverloopcnt"]){?>
							<tr class="its_tr_looptotal">
<?php if(!$_GET["account_hidden_sales"]){?>
								<td  class="bd_bt_4"><?php echo number_format($TPL_VAR["carryovertot"]["out_ea"]-$TPL_VAR["carryovertot"]["refund_out_ea"])?><!-- 수량 --></td>
								<td class="right bd_bt_4" style="font-size:13px;font-weight:bold;"><?php echo number_format($TPL_VAR["carryovertot"]["out_price"]-$TPL_VAR["carryovertot"]["refund_out_price"])?><!-- =<?php echo number_format($TPL_VAR["carryovertot"]["out_price"])?>-<?php echo $TPL_VAR["carryovertot"]["refund_out_price"]?> --><!-- 판매금액 --></td>
								<td class="right bd_bt_4"><?php echo number_format($TPL_VAR["carryovertot"]["out_salescost_admin"]-$TPL_VAR["carryovertot"]["refund_salescost_admin"])?><!-- 할인>본사 --></td>
								<td class="right bd_bt_4"><?php echo number_format($TPL_VAR["carryovertot"]["out_pg_sale_price"]-$TPL_VAR["carryovertot"]["refund_pg_sale_price"])?><!-- 할인>제휴사 --></td>
								<td class="right bd_bt_4"><?php echo number_format($TPL_VAR["carryovertot"]["out_salescost_provider"]-$TPL_VAR["carryovertot"]["refund_salescost_provider"])?><!-- 할인>입점사 --></td>
								<td class="right bd_bt_4" style="font-size:13px;font-weight:bold;"><?php echo number_format(($TPL_VAR["carryovertot"]["out_sale_price"]+$TPL_VAR["carryovertot"]["out_cash_use"])-($TPL_VAR["carryovertot"]["refund_out_sale_price"]+$TPL_VAR["carryovertot"]["refund_out_cash_use"]))?><!-- 결제금액(A) --></td>
								<td class="right bd_bt_4"><?php echo number_format($TPL_VAR["carryovertot"]["out_sale_price"]-$TPL_VAR["carryovertot"]["refund_out_sale_price"])?><!-- 실결제액 --></td>
								<td class="right bd_bt_4"><?php echo number_format($TPL_VAR["carryovertot"]["out_cash_use"]-$TPL_VAR["carryovertot"]["refund_out_cash_use"])?><!-- 이머니 --></td>
<?php }?>
<?php if(!$_GET["account_hidden_cal"]){?>
								<td class="pdr20 <?php if(!$TPL_VAR["loopcnt"]){?>cal_bottom<?php }?> cal_bg cal_left bd_bt_4"><?php echo number_format($TPL_VAR["carryovertot"]["out_exp_ea"]-$TPL_VAR["carryovertot"]["refund_out_exp_ea"])?>

								<!-- 정산수량 --></td>
								<td class="right <?php if(!$TPL_VAR["loopcnt"]){?>cal_bottom<?php }?> cal_bg bd_bt_4" style="font-size:13px;font-weight:bold;"><?php echo number_format($TPL_VAR["carryovertot"]["out_total_ac_price"]-$TPL_VAR["carryovertot"]["refund_out_total_ac_price"])?>

								<!-- 정산대상(수수료방식) --></td>
								<td class="right <?php if(!$TPL_VAR["loopcnt"]){?>cal_bottom<?php }?> cal_bg bd_bt_4"><?php echo number_format($TPL_VAR["carryovertot"]["out_pg_default_price"]-$TPL_VAR["carryovertot"]["refund_out_pg_default_price"])?>

								<!-- 정산대상(수수료방식)-결제금액 --></td>
								<td class="right <?php if(!$TPL_VAR["loopcnt"]){?>cal_bottom<?php }?> cal_bg bd_bt_4">
									<!-- <?php echo number_format($TPL_VAR["carryovertot"]["out_ac_salescost_admin"]-$TPL_VAR["carryovertot"]["refund_out_ac_salescost_admin"])?> -->
									-
									<!-- 정산대상(수수료방식)-본사할인 -->
								</td>
								<td class="right <?php if(!$TPL_VAR["loopcnt"]){?>cal_bottom<?php }?> cal_bg bd_bt_4">
									<!-- <?php echo number_format($TPL_VAR["carryovertot"]["out_ac_pg_price"]-$TPL_VAR["carryovertot"]["refund_out_out_ac_pg_price"])?> -->
									-
									<!-- 정산대상(수수료방식)-제휴사할인 -->
								</td>
								<td class="right <?php if(!$TPL_VAR["loopcnt"]){?>cal_bottom<?php }?> cal_bg bd_bt_4"><?php echo number_format($TPL_VAR["carryovertot"]["out_ac_consumer_real_price"]-$TPL_VAR["carryovertot"]["refund_out_ac_consumer_real_price"])?>

								<!-- 정산대상(공급가방식) --></td>
								<td class="right <?php if(!$TPL_VAR["loopcnt"]){?>cal_bottom<?php }?> cal_bg bd_bt_4">
									<!-- <?php if($TPL_VAR["carryovertot"]["out_ac_fee_rate"]!= 0){?><?php echo $TPL_VAR["carryovertot"]["out_ac_fee_rate"]?>%<?php }else{?>0<?php }?> -->
									-
									<!-- 수수료율(%) -->
								</td>
								<td class="right <?php if(!$TPL_VAR["loopcnt"]){?>cal_bottom<?php }?> cal_bg bd_bt_4"><?php echo number_format($TPL_VAR["carryovertot"]["out_sales_unit_feeprice"]-$TPL_VAR["carryovertot"]["refund_sales_unit_feeprice"])?>

								<!-- 수수료 -->
								</td>
								<td class="right <?php if(!$TPL_VAR["loopcnt"]){?>cal_bottom<?php }?> cal_bg cal_right bd_bt_4" style="font-size:13px;font-weight:bold;"><?php echo number_format($TPL_VAR["carryovertot"]["out_commission_price"]-$TPL_VAR["carryovertot"]["refund_out_commission_price"])?>

									<!-- =<?php echo number_format($TPL_VAR["carryovertot"]["out_commission_price"])?>-<?php echo $TPL_VAR["carryovertot"]["refund_out_commission_price"]?> -->
									<!-- p><?php echo number_format(($TPL_VAR["carryovertot"]["out_sales_unit_feeprice"]-$TPL_VAR["carryovertot"]["refund_sales_unit_feeprice"])+$TPL_VAR["carryovertot"]["out_commission_price"]-$TPL_VAR["carryovertot"]["refund_out_commission_price"])?>

									</p -->
									<!--  -->
								<!-- 정산금액(B) --></td>
<?php }?>
								<td class="bd_bt_4"></td>
								<td class="bd_bt_4"></td>
								<td class="bd_bt_4"></td>
							</tr>
<?php }?>
					</tbody>
				</table>
			  </div>
			  <div class="account-table-grid-right-body listCurrentScroll colgroupAcc" style="height:<?php echo $TPL_VAR["tableheight_current"]?>px;">
				<table width="100%" class="calc-table-style" cellpadding="0" cellspacing="0">
					<!-- 테이블 헤더 : 시작 -->
					<?php echo $TPL_VAR["acc_table_colgroup"]?>

					<tbody id="list_acc_current">
<?php if($TPL_VAR["loopcnt"]){?>
<?php }else{?>
							<tr>
								<td colspan="<?php echo ($TPL_VAR["totalcolspan"]- 8)?>" class="nodata"><!-- 조회 내역이 없습니다. --></td>
							</tr>
<?php }?>
					</tbody>
				</table>
			  </div>
			  <div class="account-table-grid-right-body summryScroll colgroupAcc">
				<table width="100%" class="calc-table-style" cellpadding="0" cellspacing="0">
					<!-- 테이블 헤더 : 시작 -->
					<?php echo $TPL_VAR["acc_table_colgroup"]?>

					<tbody>
<?php if($TPL_VAR["loopcnt"]){?>
							<tr  class="its_tr_looptotal">
<?php if(!$_GET["account_hidden_sales"]){?>
								<td  class="<?php if(!$TPL_VAR["overdrawloopcnt"]){?>acc_bottom<?php }?> acc_left acc_bg"><?php echo number_format($TPL_VAR["tot"]["out_ea"]-$TPL_VAR["tot"]["refund_out_ea"])?><!-- 수량 --></td>
								<td class="right <?php if(!$TPL_VAR["overdrawloopcnt"]){?>acc_bottom<?php }?> acc_bg" style="font-size:13px; font-weight:bolder;"><?php echo number_format($TPL_VAR["tot"]["out_price"]-$TPL_VAR["tot"]["refund_out_price"])?>

								<!--=<?php echo number_format($TPL_VAR["tot"]["out_price"])?>-<?php echo $TPL_VAR["tot"]["refund_out_price"]?>  --><!-- 판매금액 --></td>
								<td class="right <?php if(!$TPL_VAR["overdrawloopcnt"]){?>acc_bottom<?php }?> acc_bg"><?php echo number_format($TPL_VAR["tot"]["out_salescost_admin"]-$TPL_VAR["tot"]["refund_salescost_admin"])?><!-- 할인>본사 --></td>
								<td class="right <?php if(!$TPL_VAR["overdrawloopcnt"]){?>acc_bottom<?php }?> acc_bg"><?php echo number_format($TPL_VAR["tot"]["out_pg_sale_price"]-$TPL_VAR["tot"]["refund_pg_sale_price"])?><!-- 할인>제휴사 --></td>
								<td class="right <?php if(!$TPL_VAR["overdrawloopcnt"]){?>acc_bottom<?php }?> acc_bg"><?php echo number_format($TPL_VAR["tot"]["out_salescost_provider"]-$TPL_VAR["tot"]["refund_salescost_provider"])?><!-- 할인>입점사 --></td>
								<td class="right <?php if(!$TPL_VAR["overdrawloopcnt"]){?>acc_bottom<?php }?> acc_bg" style="font-size:13px; font-weight:bolder;"><?php echo number_format(($TPL_VAR["tot"]["out_sale_price"]+$TPL_VAR["tot"]["out_cash_use"])-($TPL_VAR["tot"]["refund_out_sale_price"]+$TPL_VAR["tot"]["refund_out_cash_use"]))?><!-- 결제금액(A) --></td>
								<td class="right <?php if(!$TPL_VAR["overdrawloopcnt"]){?>acc_bottom<?php }?> acc_bg"><?php echo number_format($TPL_VAR["tot"]["out_sale_price"]-$TPL_VAR["tot"]["refund_out_sale_price"])?><!-- 실결제액 --></td>
								<td class="right <?php if(!$TPL_VAR["overdrawloopcnt"]){?>acc_bottom<?php }?> acc_bg acc_right"><?php echo number_format($TPL_VAR["tot"]["out_cash_use"]-$TPL_VAR["tot"]["refund_out_cash_use"])?><!-- 이머니 --></td>
<?php }?>
<?php if(!$_GET["account_hidden_cal"]){?>
								<td class="cal_bottom cal_bg cal_left"><?php echo number_format($TPL_VAR["alltot"]["ac_out_exp_ea"])?>

								<!-- 정산수량 --></td>
								<td class="right cal_bottom cal_bg" style="font-size:13px; font-weight:bolder;"><?php echo number_format($TPL_VAR["alltot"]["ac_out_total_ac_price"])?>

								<!-- 정산대상(수수료방식) --></td>
								<td class="right cal_bottom cal_bg"><?php echo number_format($TPL_VAR["alltot"]["ac_out_pg_default_price"])?>

								<!-- 정산대상(수수료방식)-결제금액 --></td>
								<td class="right cal_bottom cal_bg">
									<!-- <?php echo number_format($TPL_VAR["alltot"]["ac_out_salescost_admin"])?> -->
									-
									<!-- 정산대상(수수료방식)-본사할인 -->
								</td>
								<td class="right cal_bottom cal_bg">
									<!-- <?php echo number_format($TPL_VAR["alltot"]["ac_out_ac_pg_price"])?> -->
									-
									<!-- 정산대상(수수료방식)-제휴사할인 -->
								</td>
								<td class="right cal_bottom cal_bg"><?php echo number_format($TPL_VAR["alltot"]["ac_out_consumer_real_price"])?>

								<!-- 정산대상(공급가방식) --></td>
								<td class="right cal_bottom cal_bg">
									<!-- <?php if($TPL_VAR["alltot"]["ac_out_fee_rate"]!= 0){?><?php echo $TPL_VAR["alltot"]["ac_out_fee_rate"]?>%<?php }?> -->
									-
									<!-- 수수료율(%) -->
								</td>
								<td class="right cal_bottom cal_bg"><?php echo number_format($TPL_VAR["alltot"]["ac_out_sales_unit_feeprice"])?>

								<!-- 수수료 --></td>
								<td class="right cal_bottom cal_bg cal_right" style="font-size:13px; font-weight:bolder;"><?php echo number_format($TPL_VAR["alltot"]["ac_out_commission_price"])?><!-- =<?php echo number_format($TPL_VAR["tot"]["out_commission_price"])?>-<?php echo $TPL_VAR["tot"]["refund_out_commission_price"]?> -->
								<!-- p><?php echo number_format(($TPL_VAR["tot"]["out_sales_unit_feeprice"]-$TPL_VAR["tot"]["refund_sales_unit_feeprice"])+$TPL_VAR["tot"]["out_commission_price"]-$TPL_VAR["tot"]["refund_out_commission_price"])?></p -->
								<!-- 정산금액(B) --></td>
<?php }?>
								<td></td>
								<td></td>
								<td></td>
							</tr>
<?php }?>
					</tbody>
				</table>
			  </div>
			  <div class="account-table-grid-right-body summryScroll colgroupAcc">
				<table width="100%" class="calc-table-style" cellpadding="0" cellspacing="0">
					<!-- 테이블 헤더 : 시작 -->
					<?php echo $TPL_VAR["acc_table_colgroup"]?>

					<tbody>
						<tr class="its_tr_loopname">
<?php if(!$_GET["account_hidden_sales"]){?>
							<td colspan="8" class="acc_name acc_bottom acc_left acc_right">당월 판매 합계</td>
<?php }?>
<?php if(!$_GET["account_hidden_cal"]){?>
							<td colspan="9" class="cal_name cal_bottom cal_left cal_right">당월 정산 합계</td>
							<td style="display:none;"></td>
<?php }?>
							<td colspan="3"></td>
						</tr>
					</tbody>
				</table>
			  </div>
			</li>
		</ul>
	</div>
</div>

<!-- 서브 레이아웃 영역 : 끝 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>