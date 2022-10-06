<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/returns/catalog.html 000016390 */ 
$TPL_marketList_1=empty($TPL_VAR["marketList"])||!is_array($TPL_VAR["marketList"])?0:count($TPL_VAR["marketList"]);
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<style>
.goods_name {display:inline-block;}
.search_label 	{display:inline-block;}
span.step_title { font-weight:normal;padding-right:5px }
</style>
<script type="text/javascript">
var search_type				= "<?php echo $TPL_VAR["sc"]["search_type"]?>";
//기본검색설정
var default_search_pageid	= "returns";
var default_obj_width		= 750;
var default_obj_height		= 260;

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


	// 체크박스 색상
	$("input[type='checkbox'][name='return_code[]']").live('change',function(){
		if($(this).is(':checked')){
			$(this).closest('tr').addClass('checked-tr-background');
		}else{
			$(this).closest('tr').removeClass('checked-tr-background');
		}
	}).change();

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
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/searchform.css?v=<?php echo date('Ymd')?>" />

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>반품 조회</h2>
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

<div class="search-form-container-new search_container">
	<table class="table_search">
		<tr>
			<th>검색어</th>
			<td><input type="text" name="keyword" value="<?php echo $_GET["keyword"]?>" title="반품코드, 아이디, 회원명, 주문자명, 수령자명, 상품명(매입상품명), 상품코드" size="100"/></td>	
		</tr>
	</table>
	<div class="search-detail-lay">
		<table class="search-form-table" id="search_detail_table">
		<tr id="goods_search_form" >
		<tr>
			<td>
				<table class="sf-option-table table_search" style="width:630px;">
				<colgroup>
					<col width="80" />
					<col  />
<?php if($TPL_VAR["npay_use"]){?> 
					<col width="80" />
					<col width="35%"/>
<?php }?>
				</colgroup>
				<tr>
					<th>날짜</th>
					<td <?php if($TPL_VAR["npay_use"]){?>colspan="3"<?php }?>>
						<select name="date_field" class="search_select" default_none>
							<option value="ref.regist_date" <?php if($_GET["date_field"]=='ref.regist_date'||!$_GET["date_field"]){?>selected<?php }?>>반품신청일</option>
							<option value="ref.return_date" <?php if($_GET["date_field"]=='ref.return_date'){?>selected<?php }?>>반품완료일</option>
						</select>

						<input type="text" name="sdate" value="<?php echo $_GET["sdate"]?>" class="datepicker"  maxlength="10" size="10" default_none />
						&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
						<input type="text" name="edate" value="<?php echo $_GET["edate"]?>" class="datepicker" maxlength="10" size="10" default_none />
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
						<label class="search_label"><input type="checkbox" name="return_status[]" value="request" <?php if($_GET["return_status"]&&in_array('request',$_GET["return_status"])){?>checked<?php }?>/> 반품신청</label>
						<label class="search_label"><input type="checkbox" name="return_status[]" value="ing" <?php if($_GET["return_status"]&&in_array('ing',$_GET["return_status"])){?>checked<?php }?>/> 반품처리중</label>
						<label class="search_label"><input type="checkbox" name="return_status[]" value="complete" <?php if($_GET["return_status"]&&in_array('complete',$_GET["return_status"])){?>checked<?php }?> row_check_all/> 반품완료</label>					
						<span class="icon-check hand all-check"><b>전체</b></span>
					</td>
<?php if($TPL_VAR["npay_use"]){?>
					<th>Npay 반품요청건</th>
					<td no=1>
						<label style="margin-left:10px;"><input type="checkbox" name="search_npay_order_return" value=1 <?php if($_GET["search_npay_order_return"]){?>checked<?php }?>> 조회</label>
					</td>
<?php }?>
				</tr>
				<tr>
					<th>회수방법</th>
					<td <?php if($TPL_VAR["npay_use"]){?>colspan="3"<?php }?>>
						<select name="return_method">
							<option value="">선택</option>
							<option value="user" <?php if($_GET["return_method"]=='user'){?>selected<?php }?>>자가반품</option>
							<option value="shop" <?php if($_GET["return_method"]=='shop'){?>selected<?php }?>>택배회수</option>
						</select>
					</td>
				</tr>
<?php if($TPL_VAR["connectorUse"]==true){?>
				<tr>
					<th>
						오픈마켓 주문
					</th>
					<td <?php if($TPL_VAR["npay_use"]){?>colspan="3"<?php }?>>
<?php if($TPL_marketList_1){foreach($TPL_VAR["marketList"] as $TPL_K1=>$TPL_V1){?>
						<label class="search_label resp_checkbox">
							<input type="checkbox" name="selectMarkets[]" value="<?php echo $TPL_K1?>" <?php if(in_array($TPL_K1,$_GET["selectMarkets"])){?>checked<?php }?>/> <?php echo $TPL_V1["name"]?>

						</label>
<?php }}?>
					</td>
				</tr>
<?php }?>
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
				
		</div>
	</div>	
</div>
<!-- 주문리스트 검색폼 : 끝 -->

<!-- 주문리스트 테이블 : 시작 -->
<div class="contents_dvs v2">
	<table class="list-table-style table_row_basic v2" cellspacing="0">
		<!-- 테이블 헤더 : 시작 -->
		<colgroup>
			<col width="4%" />
			<col width="12%" />
			<col width="14%" />
			<col width="10%" />
			<col width="4%" />
			<col width="4%" />
			<col width="4%" />
			<col width="5%" />
			<col width="4%" />
			<col width="4%" />
			<col width="4%" />
			<col width="4%" />
			<col width="4%" />
			<col width="10%" />
			<col width="6%" />
			<col width="6%" />
		</colgroup>
		<thead class="lth">
		<tr class="double-row th">
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
				<td colspan="16" align="center">검색어가 없거나 검색 결과가 없습니다.</td>
			</tr>
<?php }else{?>	
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>		
<?php if($TPL_V1["start"]){?>		
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr class="list-title-row">
				<td colspan="16" class="list-title-row-td">
					<div class="relative">
						<div class="ltr-title">
<?php if($TPL_V1["status"]=='request'){?>
						<span class="small_group"><?php echo $TPL_VAR["arr_return_status"][$TPL_V1["status"]]?></span> <span class="helpicon" title="반품신청을 처리하세요."></span>
<?php }elseif($TPL_V1["status"]=='ing'){?>
						<span class="small_group"><?php echo $TPL_VAR["arr_return_status"][$TPL_V1["status"]]?></span> <span class="helpicon" title="반품처리를 완료하세요."></span>
<?php }elseif($TPL_V1["status"]=='complete'){?>
						<span class="small_group"><?php echo $TPL_VAR["arr_return_status"][$TPL_V1["status"]]?></span> <span class="helpicon" title="반품처리가 완료되었습니다."></span>
<?php }?>
						</div>
					</div>
				</td>
			</tr>
			<!-- 리스트타이틀(주문상태 및 버튼) : 끝 -->
<?php }?>		
			<tr class="list-row">
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
				<td align="left">
<?php if($TPL_V1["member_seq"]){?>
					<div>
<?php if($TPL_V1["member_type"]=='개인'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" />
<?php }elseif($TPL_V1["member_type"]=='기업'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" /><?php }?>
						<?php echo $TPL_V1["order_user_name"]?>

<?php if($TPL_V1["sns_rute"]){?>
							(<img src="/selleradmin/skin/default/images/sns/sns_<?php echo substr($TPL_V1["sns_rute"], 0, 1)?>0.gif" align="absmiddle"><span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
<?php }else{?>
<?php if($TPL_V1["mbinfo_rute"]=='facebook'){?>
							(<span style="color:#d13b00;"><img src="/admin/skin/default/images/board/icon/sns_f0.gif" align="absmiddle"><?php echo $TPL_V1["mbinfo_email"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
<?php }else{?>
							(<span style="color:#d13b00;"><?php echo $TPL_V1["userid"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
<?php }?>
<?php }?>
					</div>
<?php }else{?>
					<img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <?php echo $TPL_V1["order_user_name"]?>(<span class="desc">비회원</span>)
<?php }?>
				</td>
				<td align="center">
<?php if($TPL_V1["npay_order_id"]){?><span class="icon-pay-npay" title="naver pay"><span>npay</span></span><?php }?>
<?php if($TPL_V1["pg"]=='kakaopay'){?>
					<span class="icon-pay-<?php echo $TPL_V1["pg"]?>" title="kakao pay"><span><?php echo $TPL_V1["pg"]?></span></span>
<?php }else{?>
					<span class="icon-pay-<?php echo $TPL_V1["payment"]?>"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }?>
				</td>
				<td align="center"><?php echo ($TPL_V1["option_ea"].$TPL_VAR["suboption_ea"])?></td>
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
				<td colspan="16" class="list-end-row-td"><div class="detail"></div></td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php if($TPL_V1["end"]){?>	
			<!-- 합계 : 시작 -->
			<tr class="list-end-row">
				<td height="50" colspan="5" class="list-end-row-td right bold">합계</td>
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
			<!-- 합계 : 끝 -->
<?php }?>		
<?php }}?>
<?php }?>
		</tbody>
		<!-- 리스트 : 끝 -->
	</table>
</div>
<!-- 주문리스트 테이블 : 끝 -->

</form>

<!-- 기본검색설정 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchDefaultConfig.js?mm=<?php echo date('Ymd')?>"></script>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>