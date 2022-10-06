<?php /* Template_ 2.2.6 2022/05/17 12:36:53 /www/music_brother_firstmall_kr/admin/skin/default/returns/catalog.html 000022645 */ 
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);
$TPL_marketList_1=empty($TPL_VAR["marketList"])||!is_array($TPL_VAR["marketList"])?0:count($TPL_VAR["marketList"]);
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<!-- 2021.12.30 11월 3차 패치 by 김혜진 -->
<script type="text/javascript">
	var search_type				= "<?php echo $TPL_VAR["sc"]["search_type"]?>";
	//기본검색설정
	var default_search_pageid	= "returns";
	var default_obj_width		= 750;
	var default_obj_height		= 300;

	$(document).ready(function() {

		$(".all-check").toggle(function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',true);
		},function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',false);
		});

		$("#order_star").click(function(){
			var status = "";
			if($(this).hasClass("checked")){
				$(this).removeClass("checked");
				status = "asc";
			}else{
				$(this).addClass("checked");
				status = "desc";
			}
			location.href = "../goods/catalog?orderby=favorite_chk&sort="+status;
		});

		// 선택한 환불건 삭제
		$(".reverse_return").bind("click",function(){
			var st = '.return_code_' + $(this).attr('id');
			var return_code = new Array();
			$(st+":checked").each(function(idx){
				return_code[idx] = 'code[]='+$(this).val();
			});

			var mstatus = $(this).attr('id')=='request' ? '신청' : '처리중';

			if(return_code.length > 0){
				openDialogConfirm('해당 반품 '+mstatus+' 건을 철회하겠습니까?',400,160,function(){
					var str = return_code.join('&');
					$.ajax({
						type: "POST",
						url: "../returns_process/batch_reverse_return",
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
		});

		// 체크박스 색상
		$("input[type='checkbox'][name='return_code[]']").live('change',function(){
			if($(this).is(':checked')){
				$(this).closest('tr').addClass('checked-tr-background');
			}else{
				$(this).closest('tr').removeClass('checked-tr-background');
			}
		}).change();

		// 모든 마켓
		$(".allSelectDrop").click(function(){
			var name	= $(this).attr("name").replace("all","");
			$("input[name='"+name+"[]']").prop("checked",$(this).is(":checked"));
		});

		$('.allCheckMark').click(function(){
			var chkName			= $(this).attr('name');
			var allCheckerName	= 'all' + chkName.replace(/\[\]/, '');

			if ($('input[name="' + chkName + '"]').length == $('input[name="' + chkName + '"]:checked').length)
				$('input[name="' + allCheckerName + '"]').attr('checked', true);
			else
				$('input[name="' + allCheckerName + '"]').attr('checked', false);
		});

	});


	/*######################## 16.12.15 gcs yjy : 검색조건 유지되도록 s */
	function returnView(seq){
		$("input[name='no']").val(seq);
		var search = location.search;
		search = search.substring(1,search.length);

		$("input[name='query_string']").val(search);
		$("form[name='orderForm']").attr('action','view');
		$("form[name='orderForm']").submit();
	}
	/*######################## 16.12.15 gcs yjy : 검색조건 유지되도록 e */
</script>
<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js?v=<?php echo date('Ymd')?>"></script>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/searchform.css" />
<style>
	/*	.goods_name {display:inline-block;white-space:nowrap;overflow:hidden;width:290px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	.search_label 	{display:inline-block;width:80px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	span.step_title { font-weight:normal;padding-right:5px }

	.ui-combobox {
		position: relative;
		display: inline-block;
	}
	.ui-combobox-toggle {
		position: absolute;
		top: 0;
		bottom: 0;
		margin-left: -1px;
		padding: 0;
		*height: 1.7em;
		*top: 0.1em;
	}
	.ui-combobox-input {
		margin: 0;
		padding: 0.3em;
	}
	.ui-autocomplete {
		max-height: 200px;
		overflow-y: auto;
		overflow-x: hidden;
	}*/
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>반품 리스트</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<form name="orderForm" id="orderForm">
	<!--######################## 16.12.16 gcs yjy : 검색조건 유지되도록  -->
	<input type="hidden" name="no">
	<input type="hidden" name="query_string">

	<!-- 주문리스트 검색폼 : 시작 -->
	<div class="search-form-container search_container">
		<table class="table_search">
			<tr>
				<th>검색어</th>
				<td>
					<input type="hidden" name="regist_date_type" value="<?php echo $_GET["regist_date_type"]?>"/>
					<select name="keyword_type" style="width:103px;">
						<option value="">통합검색</option>
						<option value="ref.return_code">반품번호</option>
						<option value="ord.order_seq">주문번호</option>
						<option value="ord.order_user_name">주문자명</option>
						<option value="ord.depositor">입금자명</option>
						<option value="mem.userid">아이디</option>
					</select>
					<input type="text" name="keyword" value="<?php echo $_GET["keyword"]?>" size="82" title="반품번호, 아이디, 회원명, 주문자명, 수령자명, 상품명(매입상품명), 상품코드" />
				</td>
			</tr>
		</table>

		<div class="search-detail-lay">
			<table class="search-form-table" >
				<tr id="goods_search_form" >
					<td>
						<table class="sf-option-table table_search" id="search_detail_table">
<?php if(serviceLimit('H_AD')){?>
							<tr>
								<th>배송책임</th>
								<td <?php if($TPL_VAR["npay_use"]){?>colspan="4"<?php }else{?>colspan="2"<?php }?>>
								<div class="ui-widget"  style="float:left;">
									<select name="provider_seq_selector" style="vertical-align:middle;" >
										<option value="0">- 입점사 검색 -</option>
										<option value="999999999999">입점사 전체(본사제외)</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
										<option value="<?php echo $TPL_V1["provider_seq"]?>"><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }}?>
									</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="text" name="provider_name" value="<?php echo $_GET["provider_name"]?>" readonly />
									<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $_GET["provider_seq"]?>" default_none/>
								</div>
								<div style="float:left;padding:5px 0px 0px 10px;;">
									<label class="resp_checkbox"><input type="checkbox" name="base_inclusion" value="1" <?php if($_GET["base_inclusion"]){?>checked<?php }?> /> 본사배송</label>
								</div>
								<span class="ptc-charges hide"></span>
								</td>
							</tr>
<?php }?>
							<tr>
								<th>날짜</th>
								<td>
									<select name="date_field" class="search_select" default_none style="width:100px;">
										<option value="ref.regist_date" <?php if($_GET["date_field"]=='ref.regist_date'||!$_GET["date_field"]){?>selected<?php }?>>반품신청일</option>
										<option value="ref.return_date" <?php if($_GET["date_field"]=='ref.return_date'){?>selected<?php }?>>반품완료일</option>
									</select>

									<input type="text" name="sdate" value="<?php echo $_GET["sdate"]?>" class="datepicker"  maxlength="10" style="width:80px" default_none />
									&nbsp;<span class="gray">-</span>&nbsp;
									<input type="text" name="edate" value="<?php echo $_GET["edate"]?>" class="datepicker" maxlength="10" style="width:80px" default_none />
									&nbsp;&nbsp;
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
<?php if($TPL_VAR["npay_use"]){?>
							<tr>
								<th>Npay 반품요청건</th>
								<td no=1>
									<label><input type="checkbox" name="search_npay_order_return" value=1 <?php if($_GET["search_npay_order_return"]){?>checked<?php }?>> 조회</label>
								</td>
							</tr>
<?php }?>
							<tr>
								<th>상태</th>
								<td>
									<div class="resp_checkbox">
										<label><input type="checkbox" name="return_status[]" value="request" <?php if($_GET["return_status"]&&in_array('request',$_GET["return_status"])){?>checked<?php }?>/> 반품신청</label>
										<label><input type="checkbox" name="return_status[]" value="ing" <?php if($_GET["return_status"]&&in_array('ing',$_GET["return_status"])){?>checked<?php }?>/> 반품처리중</label>
										<label><input type="checkbox" name="return_status[]" value="complete" <?php if($_GET["return_status"]&&in_array('complete',$_GET["return_status"])){?>checked<?php }?> row_check_all /> 반품완료</label>
										<span class="icon-check hand all-check ml10"><b>전체</b></span>
									</div>
								</td>
							</tr>
							<tr>
								<th>오픈마켓</th>
								<td no=1>
<?php if($TPL_VAR["connectorUse"]==true){?>
									<div class="resp_checkbox">
										<label><input type="checkbox" name="allselectMarkets" class="allSelectDrop" default_none value='y' <?php if($_GET["allselectMarkets"]=='y'){?>checked<?php }?>> <span class="allselectMarkets">모든 마켓</span></label>
										<label><input type="checkbox" class="allCheckMark" name="selectMarkets[]" value="NOT" <?php if(in_array('NOT',$_GET["selectMarkets"])){?>checked<?php }?>/> 내쇼핑몰</label>
<?php if($TPL_marketList_1){foreach($TPL_VAR["marketList"] as $TPL_K1=>$TPL_V1){?>
										<label><input type="checkbox"  class="allCheckMark" name="selectMarkets[]" value="<?php echo $TPL_K1?>" <?php if(in_array($TPL_K1,$_GET["selectMarkets"])){?>checked<?php }?>/> <?php echo $TPL_V1["name"]?></label>
<?php }}?>
									</div>
<?php }?>
								</td>
							</tr>
							<tr>
								<th>회수방법</th>
								<td>
									<select name="return_method" style="width:100px;">
										<option value="">선택</option>
										<option value="user" <?php if($_GET["return_method"]=='user'){?>selected<?php }?>>자가반품</option>
										<option value="shop" <?php if($_GET["return_method"]=='shop'){?>selected<?php }?>>택배회수</option>
									</select>
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
				<button type="button" id="set_default_apply_button" onclick="set_search_form('returns')" class="resp_btn v3">기본검색적용</button>
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
			<col width="3%" />
			<col width="3%" />
			<col width="12%" />
			<col width="12%" />
			<col width="14%" />
			<col width="4%" />
			<col width="4%" />
			<col width="4%" />
			<col width="4%" />
			<col width="4%" />
			<col width="4%" />
			<col width="4%" />
			<col width="4%" />
			<col width="3%" />
			<col width="10%" />
			<col width="6%" />
			<col width="6%" />
		</colgroup>
		<thead class="lth">
		<tr class="double-row th">
			<th rowspan="2">삭제</th>
			<th rowspan="2">번호</th>
			<th>반품 접수 일시</th>
			<th rowspan="2">주문번호</th>
			<th rowspan="2">주문자</th>
			<th rowspan="2">결제</th>
			<th rowspan="2">주문<br />수량</th>
			<th colspan="2">반품 종류</th>
			<th colspan="3">반품 사유</th>
			<th rowspan="2">처리자</th>
			<th rowspan="2">회수</th>
			<th rowspan="2">처리완료 일시</th>
			<th colspan="2">처리 상태</th>
		</tr>
		<tr class="double-row th">
			<th>반품 번호</th>
			<th>반품</th>
			<th>(맞)교환</th>
			<th>오배송</th>
			<th>하자</th>
			<th>변심</th>
			<th>환불</th>
			<th>반품</th>
		</tr>
		</thead>
		<!-- 테이블 헤더 : 끝 -->
		<!-- 리스트 : 시작 -->
		<tbody class="ltb">
<?php if(!$TPL_VAR["record"]){?>
		<tr class="list-row">
			<td colspan="17" align="center">검색어가 없거나 검색 결과가 없습니다.</td>
		</tr>
<?php }else{?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
<?php if($TPL_V1["start"]){?>
		<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
		<tr class="list-title-row">
			<td colspan="17" class="list-title-row-td" style="border-top:none;">
				<div class="relative clearbox">
					<div class="ltr-title">
<?php if($TPL_V1["status"]=='request'){?>
						<span class="small_group"><?php echo $TPL_VAR["arr_return_status"][$TPL_V1["status"]]?></span> <span class="helpicon" title="반품신청을 처리하세요."></span>
<?php }elseif($TPL_V1["status"]=='ing'){?>
						<span class="small_group"><?php echo $TPL_VAR["arr_return_status"][$TPL_V1["status"]]?></span> <span class="helpicon" title="반품처리를 완료하세요."></span>
<?php }elseif($TPL_V1["status"]=='complete'){?>
						<span class="small_group"><?php echo $TPL_VAR["arr_return_status"][$TPL_V1["status"]]?></span> <span class="helpicon" title="반품처리가 완료되었습니다."></span>
<?php }?>
					</div>
					<ul class="left-btns">
<?php if($TPL_V1["status"]!='complete'){?>
						<li><span class="btn small"><input type="button" value="반품철회" class="reverse_return" id="<?php echo $TPL_V1["status"]?>" /></span></li>
<?php }?>
					</ul>
				</div>
			</td>
		</tr>
		<!-- 리스트타이틀(주문상태 및 버튼) : 끝 -->
<?php }?>
		<tr class="list-row">
			<td align="center">
<?php if($TPL_V1["status"]!='complete'){?>
				<input type="checkbox" name="return_code[]" class="return_code_<?php echo $TPL_V1["status"]?>" value="<?php echo $TPL_V1["return_code"]?>" order_seq="<?php echo $TPL_V1["order_seq"]?>" />
<?php }?>
			</td>
			<td align="center"><?php echo $TPL_V1["no"]?></td>
			<!-- ######################## 16.12.16 gcs yjy : 검색조건 유지되도록 -->
			<td align="center"><a href="javascript:returnView('<?php echo $TPL_V1["return_code"]?>')"><span class="hand blue bold"><?php echo $TPL_V1["regist_date"]?></span><br /><span class="fx11"><?php echo $TPL_V1["return_code"]?></span></a></td>
			<td align="center">
				<a href="../order/view?no=<?php echo $TPL_V1["order_seq"]?>"><span class="hand blue"><?php echo $TPL_V1["order_seq"]?></span></a>

<?php if($TPL_V1["linkage_mall_order_id"]){?>
				<div class="blue bold"><?php echo $TPL_V1["linkage_mall_order_id"]?><br/>(<?php echo $TPL_V1["linkage_mallname_text"]?>)</div>
<?php }else{?>
<?php if($TPL_VAR["npay_use"]&&$TPL_V1["npay_order_id"]){?><div class="ngreen"><?php echo $TPL_V1["npay_order_id"]?><span style="font-size:11px;"> (Npay주문번호)</span></div><?php }?>
<?php }?>

			</td>
			<td align="left" class="hand" onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','<?php echo $TPL_V1["order_seq"]?>','right');">
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
					(<span style="color:#d13b00;" <img src="/admin/skin/default/images/board/icon/sns_f0.gif" align="absmiddle"><?php echo $TPL_V1["mbinfo_email"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
<?php }else{?>
					(<span style="color:#d13b00;"><?php echo $TPL_V1["userid"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
<?php }?>
<?php }?>
				</div>
<?php }else{?>
				<img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <?php echo $TPL_V1["order_user_name"]?> (<span class="desc" order_seq="<?php echo $TPL_V1["order_seq"]?>">비회원</span>)
<?php }?>
			</td>
			<td align="center">
<?php if($TPL_V1["npay_order_id"]){?><span class="icon-pay-npay" title="naver pay"><span>npay</span></span><?php }?>
<?php if($TPL_V1["pg"]=='kakaopay'){?>
				<span class="icon-pay-kakaopay-simple" title="kakao pay"><span>kakaopay</span></span>
<?php }else{?>
				<span class="icon-pay-<?php echo $TPL_V1["payment"]?>"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }?>
			</td>
			<td align="center"><?php echo ($TPL_V1["option_ea"]+$TPL_V1["suboption_ea"])?></td>
			<td align="center"><?php if($TPL_V1["return_type"]=='return'){?><?php echo $TPL_V1["return_ea_sum"]?><?php }else{?>0<?php }?></td>
			<td align="center"><?php if($TPL_V1["return_type"]=='exchange'){?><?php echo $TPL_V1["return_ea_sum"]?><?php }else{?>0<?php }?></td>
			<td align="center"><?php if($TPL_V1["shop_reason_cnt"]){?><?php echo $TPL_V1["shop_reason_cnt"]?><?php }else{?>0<?php }?></td>
			<td align="center"><?php if($TPL_V1["goods_reason_cnt"]){?><?php echo $TPL_V1["goods_reason_cnt"]?><?php }else{?>0<?php }?></td>
			<td align="center"><?php if($TPL_V1["user_reason_cnt"]){?><?php echo $TPL_V1["user_reason_cnt"]?><?php }else{?>0<?php }?></td>
			<td align="center"><?php echo $TPL_V1["mname"]?></td>
			<td align="center"><?php echo $TPL_V1["return_ea"]?></td>
			<td align="center"><?php if($TPL_V1["return_date"]){?><?php echo $TPL_V1["return_date"]?><?php }else{?>&nbsp;<?php }?></td>
			<td align="center"><?php echo $TPL_V1["mrefund_status"]?></td>
			<td align="center"><?php echo $TPL_V1["mstatus"]?></td>
		</tr>
		<tr class="list-row hide">
			<td colspan="17" class="list-end-row-td">
				<div class="detail"></div>
			</td>
		</tr>
		<!-- 리스트데이터 : 끝 -->
<?php if($TPL_V1["end"]){?>
		<!-- 합계 : 시작 -->
		<tr class="list-end-row">
			<td height="38" colspan="6" class="list-end-row-td right bold">합계</td>
			<td class="list-end-row-td" align="center"><?php echo number_format($TPL_VAR["tot"][$TPL_V1["status"]]['order_ea'])?></td>
			<td class="list-end-row-td" align="center"><?php echo number_format($TPL_VAR["tot"][$TPL_V1["status"]]['return'])?></td>
			<td class="list-end-row-td" align="center"><?php echo number_format($TPL_VAR["tot"][$TPL_V1["status"]]['exchange'])?></td>
			<td class="list-end-row-td" align="center"><?php echo number_format($TPL_VAR["tot"][$TPL_V1["status"]]['shop_reason_cnt'])?></td>
			<td class="list-end-row-td" align="center"><?php echo number_format($TPL_VAR["tot"][$TPL_V1["status"]]['goods_reason_cnt'])?></td>
			<td class="list-end-row-td" align="center"><?php echo number_format($TPL_VAR["tot"][$TPL_V1["status"]]['user_reason_cnt'])?></td>
			<td class="list-end-row-td">&nbsp;</td>
			<td class="list-end-row-td" align="center"><?php echo $TPL_VAR["tot"][$TPL_V1["status"]]['return_ea']?></td>
			<td colspan="3" class="list-end-row-td">&nbsp;</td>
		</tr>
		<tr class="list-row">
			<td colspan="17" style="border:none; height:30px;"></td>
		</tr>
		<!-- 합계 : 끝 -->
<?php }?>
<?php }}?>
<?php }?>
		</tbody>
		<!-- 리스트 : 끝 -->
	</table>
	<!-- 주문리스트 테이블 : 끝 -->
</form>

<!-- 기본검색설정 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchDefaultConfig.js?ymd=<?php echo date('YmdHis')?>"></script>
<script>$("select[name='keyword_type']").val("<?php echo $_GET["keyword_type"]?>");</script>
<script>
	$(function(){
		$( "select[name='provider_seq_selector']" )
				.combobox()
				.change(function(){
					if( $(this).val() > 0 ){
						$("input[name='provider_seq']").val($(this).val());
						$("input[name='provider_name']").val($("option:selected",this).text());
					}else{
						$("input[name='provider_seq']").val('');
						$("input[name='provider_name']").val('');
					}
				})
				.next(".ui-combobox").children("input").attr('default_none', 'default_none')
				.bind('focus',function(){
					if($(this).val()==$( "select[name='provider_seq_selector'] option:first-child" ).text()){
						$(this).val('');
					}
				})
				.bind('mouseup',function(){
					if($(this).val()==''){
						$( "select[name='provider_seq_selector']").next(".ui-combobox").children("a.ui-combobox-toggle").click();
					}
				});
	});
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>