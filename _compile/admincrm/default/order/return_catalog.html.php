<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admincrm/skin/default/order/return_catalog.html 000013910 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<style>
.goods_name {display:inline-block;white-space:nowrap;overflow:hidden;width:290px;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
.search_label 	{display:inline-block;width:100px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
span.step_title { font-weight:normal;padding-right:5px }
</style>
<script type="text/javascript">
$(document).ready(function() {
	$(".all-check").toggle(function(){
		$(this).parent().find('input[type=checkbox]').attr('checked',true);	
	},function(){
		$(this).parent().find('input[type=checkbox]').attr('checked',false);
	});
		
		
		$("[name='select_date']").click(function() {
			switch($(this).attr("id")) {
				case 'today' :
					$("input[name='sdate']").val(getDate(0));
					$("input[name='edate']").val(getDate(0));
					break;
				case '3day' :
					$("input[name='sdate']").val(getDate(3));
					$("input[name='edate']").val(getDate(0));
					break;
				case '1week' :
					$("input[name='sdate']").val(getDate(7));
					$("input[name='edate']").val(getDate(0));
					break;
				case '1month' :
					$("input[name='sdate']").val(getDate(30));
					$("input[name='edate']").val(getDate(0));
					break;
				case '3month' :
					$("input[name='sdate']").val(getDate(90));
					$("input[name='edate']").val(getDate(0));
					break;
				default :
					$("input[name='sdate']").val('');
					$("input[name='edate']").val('');
					break;
			}
		});

		$("#search_set").click(function(){
			openDialog("기본검색 설정", "search_detail_dialog", {"width":"800","height":"300"});
		});
		
		$("#get_default_button").click(function(){
			$.getJSON('get_search_default', function(result) {			 
				for(var i=0;i<result.length;i++){
					if(result[i][0]=='goodsStatus[0]' || result[i][0]=='goodsView[0]'){
						//alert(result[i][0]+" : "+result[i][1]); 
						if(result[i][1]=='normal') $("input[name='goodsStatus[]']").eq(0).attr("checked",true);
						else if(result[i][1]=='runout') $("input[name='goodsStatus[]']").eq(1).attr("checked",true);
						else if(result[i][1]=='unsold') $("input[name='goodsStatus[]']").eq(2).attr("checked",true);
						else if(result[i][1]=='look') $("input[name='goodsView[]']").eq(0).attr("checked",true);
						else if(result[i][1]=='notLook') $("input[name='goodsView[]']").eq(1).attr("checked",true);
					}else if(result[i][0]=='regist_date'){
						if(result[i][1] == 'today'){
							set_date('<?php echo date('Y-m-d')?>','<?php echo date('Y-m-d')?>');
						}else if(result[i][1] == '3day'){
							set_date('<?php echo date('Y-m-d',strtotime("-3 day"))?>','<?php echo date('Y-m-d')?>');
						}else if(result[i][1] == '7day'){
							set_date('<?php echo date('Y-m-d',strtotime("-7 day"))?>','<?php echo date('Y-m-d')?>');
						}else if(result[i][1] == '1mon'){
							set_date('<?php echo date('Y-m-d',strtotime("-1 month"))?>','<?php echo date('Y-m-d')?>');
						}else if(result[i][1] == '3mon'){
							set_date('<?php echo date('Y-m-d',strtotime("-3 month"))?>','<?php echo date('Y-m-d')?>');
						}	
					}
					$("*[name='"+result[i][0]+"']",document.memberForm).val(result[i][1]);
				}			
			});
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

	function set_date(start,end){	
		$("input[name='sdate']").val(start);
		$("input[name='edate']").val(end);
	}
</script>

<div class="orderTitle">반품/교환 내역</div>
<form name="orderForm" id="orderForm">
<!-- 주문리스트 검색폼 : 시작 -->
<div class="search-form-container">
	<table class="search-form-table" id="serch_tab">
	<tr id="goods_search_form" style="display:block;">
	<tr>
		<td>
			<table class="sf-option-table">
			<colgroup>
				<col width="80" />
				<col width="" />
			</colgroup>
			<tr>
				<th>
					<select name="date_field">
					<option value="ref.regist_date" <?php if($_GET["date_field"]=='ref.regist_date'||!$_GET["date_field"]){?>selected<?php }?>>반품신청일</option>
					<option value="ref.return_date" <?php if($_GET["date_field"]=='ref.return_date'){?>selected<?php }?>>반품완료일</option>
					</select>
				</th>
				<td>
					<input type="text" name="sdate" value="<?php echo $_GET["sdate"]?>" class="datepicker line"  maxlength="10" size="10" />
					&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
					<input type="text" name="edate" value="<?php echo $_GET["edate"]?>" class="datepicker line" maxlength="10" size="10" />
					&nbsp;&nbsp;
					<span class="btn small"><input type="button" value="오늘" id="today" name="select_date"/></span>
					<span class="btn small"><input type="button" value="3일간" id="3day" name="select_date"/></span>
					<span class="btn small"><input type="button" value="일주일" id="1week" name="select_date"/></span>
					<span class="btn small"><input type="button" value="1개월" id="1month" name="select_date"/></span>
					<span class="btn small"><input type="button" value="3개월" id="3month" name="select_date"/></span>
					<span class="btn small"><input type="button" value="전체" id="all" name="select_date"/></span>
				</td>
			</tr>
			<tr>
				<th>상태</th>
				<td>				
					<label class="search_label"><input type="checkbox" name="return_status[]" value="request" <?php if($_GET["return_status"]&&in_array('request',$_GET["return_status"])){?>checked<?php }?>/> 반품신청</label>
					<label class="search_label"><input type="checkbox" name="return_status[]" value="ing" <?php if($_GET["return_status"]&&in_array('ing',$_GET["return_status"])){?>checked<?php }?>/> 반품처리중</label>
					<label class="search_label"><input type="checkbox" name="return_status[]" value="complete" <?php if($_GET["return_status"]&&in_array('complete',$_GET["return_status"])){?>checked<?php }?>/> 반품완료</label>	
					
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="pdt15"><span class="btn_crm_search"><button type="submit">검색<span class="arrow"></span></button></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>
<!-- 주문리스트 검색폼 : 끝 -->
<br style="line-height:20px;">

<!-- 주문리스트 테이블 : 시작 -->
<table class="list-table-style" cellspacing="0" >
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="12%" />
		<col width="15%" />
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
		<th>반품 접수 일시</th>
		<th rowspan="2">주문번호</th>		
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
		<th>맞교환</th>
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
			<td height="20" colspan="14" align="center">검색어가 없거나 검색 결과가 없습니다.</td>
		</tr>
<?php }else{?>	
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>		
<?php if($TPL_V1["start"]){?>		
		<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
		<tr class="list-title-row">
			<td colspan="14" class="list-title-row-td">
				<div class="relative">
					<div class="ltr-title">
<?php if($TPL_V1["status"]=='request'){?>
					<span class="small_group"><?php echo $TPL_VAR["arr_return_status"][$TPL_V1["status"]]?></span>
<?php }elseif($TPL_V1["status"]=='ing'){?>
					<span class="small_group"><?php echo $TPL_VAR["arr_return_status"][$TPL_V1["status"]]?></span>
<?php }elseif($TPL_V1["status"]=='complete'){?>
					<span class="small_group"><?php echo $TPL_VAR["arr_return_status"][$TPL_V1["status"]]?></span>
<?php }?>
					</div>
				</div>
			</td>
		</tr>
		<!-- 리스트타이틀(주문상태 및 버튼) : 끝 -->
<?php }?>		
		<tr class="list-row">
			<td align="center"><a href="/admin/returns/view?no=<?php echo $TPL_V1["return_code"]?>" target="_blank"><span class="hand blue bold"><?php echo $TPL_V1["regist_date"]?></span><br /><span class="fx11"><?php echo $TPL_V1["return_code"]?></span></a></td>
			<td align="center"><a href="/admin/order/view?no=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><span class="hand blue"><?php echo $TPL_V1["order_seq"]?></span></a></td>			
			<td align="center">
<?php if($TPL_V1["pg"]=='kakaopay'){?>
				<span class="icon-pay-<?php echo $TPL_V1["pg"]?>"><span><?php echo $TPL_V1["pg"]?></span></span>
<?php }else{?>
				<span class="icon-pay-<?php echo $TPL_V1["payment"]?>"><span><?php echo $TPL_V1["mpayment"]?></span></span>
<?php }?>
			</td>
			<td align="center"><?php echo ($TPL_V1["option_ea"].$TPL_VAR["suboption_ea"])?></td>
			<td align="center"><?php if($TPL_V1["return_type"]=='return'){?><?php echo $TPL_V1["return_ea_sum"]?><?php }else{?>0<?php }?></td>
			<td align="center"><?php if($TPL_V1["return_type"]=='exchange'){?><?php echo $TPL_V1["return_ea_sum"]?><?php }else{?>0<?php }?></td>			
			<td align="center"><?php echo $TPL_V1["shop_reason_cnt"]?></td>
			<td align="center"><?php echo $TPL_V1["goods_reason_cnt"]?></td>
			<td align="center"><?php echo $TPL_V1["user_reason_cnt"]?></td>			
			<td align="center"><?php echo $TPL_V1["mname"]?></td>
			<td align="center"><?php echo $TPL_V1["return_ea"]?></td>
			<td align="center"><?php if($TPL_V1["return_date"]){?><?php echo $TPL_V1["return_date"]?><?php }else{?>&nbsp;<?php }?></td>
			<td align="center"><?php echo $TPL_V1["mrefund_status"]?></td>
			<td align="center"><?php echo $TPL_V1["mstatus"]?></td>			
		</tr>
		<tr class="list-row hide">
			<td colspan="14" class="list-end-row-td"><div class="detail"></div></td>
		</tr>
		<!-- 리스트데이터 : 끝 -->
<?php }}?>
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->
</table>
<!-- 주문리스트 테이블 : 끝 -->

</form>

<div class="hide" id="search_detail_dialog">
<form name="set_search_detail" method="post" action="set_search_default" target="actionFrame">
<div id="contents">
	<table class="search-form-table" id="serch_tab">
	<tr id="goods_search_form" style="display:block;">
	<tr>
		<td>
			<table class="sf-option-table">
			<colgroup>
				<col width="80" />
				<col width="" />
			</colgroup>
			<tr>
				<th><select name="date_gb" class="search_select">
						<option value="regist_date" <?php if($_GET["date_gb"]=='regist_date'){?>selected<?php }?>>반품신청일</option>
						<option value="return_date" <?php if($_GET["date_gb"]=='return_date'){?>selected<?php }?>>반품완료일</option>
					</select></th>
				<td>
					<input type="text" name="sdate" value="<?php echo $_GET["sdate"]?>" class="datepicker line"  maxlength="10" size="10" />
					&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
					<input type="text" name="edate" value="<?php echo $_GET["edate"]?>" class="datepicker line" maxlength="10" size="10" />
					&nbsp;&nbsp;
					<span class="btn small"><input type="button" value="오늘" id="today" name="select_date"/></span>
					<span class="btn small"><input type="button" value="3일간" id="3day" name="select_date"/></span>
					<span class="btn small"><input type="button" value="일주일" id="1week" name="select_date"/></span>
					<span class="btn small"><input type="button" value="1개월" id="1month" name="select_date"/></span>
					<span class="btn small"><input type="button" value="3개월" id="3month" name="select_date"/></span>
					<span class="btn small"><input type="button" value="전체" id="all" name="select_date"/></span>
				</td>
			</tr>
			<tr>
				<th>상태</th>
				<td>				
					<label class="search_label"><input type="checkbox" name="return_status[]" value="request" <?php if($_GET["return_status"]&&in_array('request',$_GET["return_status"])){?>checked<?php }?>/>반품신청</label>
					<label class="search_label"><input type="checkbox" name="return_status[]" value="ing" <?php if($_GET["return_status"]&&in_array('ing',$_GET["return_status"])){?>checked<?php }?>/>반품처리중</label>
					<label class="search_label"><input type="checkbox" name="return_status[]" value="complete" <?php if($_GET["return_status"]&&in_array('complete',$_GET["return_status"])){?>checked<?php }?>/>반품완료</label>	
					
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>
<div align="center" style="padding-top:10px;">
	<span class="btn large black">
		<button type="submit">저장하기<span class="arrowright"></span></button>
	</span>
</div>
</form>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>