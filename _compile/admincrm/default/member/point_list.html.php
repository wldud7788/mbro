<?php /* Template_ 2.2.6 2022/05/17 12:05:25 /www/music_brother_firstmall_kr/admincrm/skin/default/member/point_list.html 000006626 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	$(document).ready(function() {
		// IFRAME RESIZING
		parent.$("#mbcontainerpont").css("height","0px");
		$("#mbcontainerpont", parent.document).height($(document).height()+10);

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
	});

	function view_history(seq){
		$.get('/admin/member/used_history?type=point&seq='+seq, function(data) {
			$('#usedPopup').html(data);
			openDialog("차감 내역", "usedPopup", {"width":"850","height":"700"});
		});
	}

	function point_pop(seq){
		if(!seq) return;
		$.get('/admin/member/point_detail?member_seq='+seq, function(data) {
			$('#emoneyPopup').html(data);
			openDialog("포인트 내역/지급 <span class='desc'>해당 회원의 포인트 내역 및 수동 지급/차감을 하실 수 있습니다.</span>", "emoneyPopup", {"width":"900","height":"700"});
		});
	}

	function point_not_use(){
	alert("현재 포인트 \'사용안함\' 상태입니다. \n \'사용함\'으로 상태 변경 후 다시 시도하시기 바랍니다.");
	}
</script>

<div id="usedPopup" class="hide"></div>
<div class="orderTitle">포인트 내역</div>
<div class="search-form-container" align="center">
	<table class="search-form-table">
		<form name="emoneylist" id="emoneylist">
		<colgroup>
			<col width="80" /><col />
		</colgroup>
		<tbody class="ltb otb">
			<tr class="list-row">
				<td colspan="2">
					<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker line"  maxlength="10" size="10" />
					&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
					<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker line" maxlength="10" size="10" />
					&nbsp;&nbsp;
					<span class="btn small"><input type="button" value="오늘" id="today" name="select_date"/></span>
					<span class="btn small"><input type="button" value="3일간" id="3day" name="select_date"/></span>
					<span class="btn small"><input type="button" value="일주일" id="1week" name="select_date"/></span>
					<span class="btn small"><input type="button" value="1개월" id="1month" name="select_date"/></span>
					<span class="btn small"><input type="button" value="3개월" id="3month" name="select_date"/></span>
					<span class="btn small"><input type="button" value="전체" id="all" name="select_date"/></span>
				</td>
			</tr>
			<tr class="list-row">
				<th class="its-th-align left">포인트</th>
				<td class="its-td">
					<label class="pdr20"><input type="checkbox" name="gb[]" value="plus" <?php if($TPL_VAR["sc"]["gb"]&&in_array('plus',$TPL_VAR["sc"]["gb"])){?>checked<?php }?>/> 지급</label>
					<label class="pdr20"><input type="checkbox" name="gb[]" value="minus" <?php if($TPL_VAR["sc"]["gb"]&&in_array('minus',$TPL_VAR["sc"]["gb"])){?>checked<?php }?>/> 차감</label>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="pdt15">
					<span class="btn_crm_search"><button type="submit" id="send_submit">검색<span class="arrow"></span></button></span>
				</td>
			</tr>
		</tbody>
		</form>
	</table>
</div>
<br style="line-height:20px;">

<div style="padding-bottom:5px;"><?php echo $TPL_VAR["leftUserName"]?>님의 보유 포인트 <b style="color:#078fec;"><?php echo get_currency_price($TPL_VAR["userPoint"])?></b>P &nbsp;<span class="btn small "><?php if($TPL_VAR["reserveinfo"]["point_use"]=='Y'){?><button type="button" onclick="point_pop('<?php echo $_SESSION["member_seq"]?>')">지급/차감</button><?php }else{?><button type="button" onclick="point_not_use()">지급/차감</button><?php }?></span></div>
<table class="list-table-style" cellspacing="0" width="100%">
	<colgroup>
		<col width="50" />
		<col width="15%" />
		<col width="13%" />
		<col />
		<col width="15%" />
		<col width="10%" />
		<col width="15%" />
	</colgroup>
	<thead class="lth">
		<tr>
			<th>번호</th>
			<th>날짜</th>
			<th>지급/차감 금액</th>
			<th>사유</th>
			<th>내역</th>
			<th>유효기간</th>
			<th>자동/수동</th>
		</tr>
	</thead>
	<tbody class="ltb otb" >
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row">
			<td align="center"><?php echo $TPL_V1["number"]?></td>
			<td align="center"><?php echo $TPL_V1["regist_date"]?></td>
			<td align="left" class="pdl10">
<?php if($TPL_V1["gb"]=='plus'){?>
				<span style="color:red;">(+)</span> <?php echo get_currency_price($TPL_V1["point"])?>

<?php }else{?>
				<a href="javascript:view_history('<?php echo $TPL_V1["point_seq"]?>');"></a><span style="color:blue;">(-)</span> <?php echo get_currency_price($TPL_V1["point"])?>

<?php }?>
			</td>
			<td align="left" class="pdl10"><?php echo $TPL_V1["memo"]?></td>
			<td align="left" class="pdl10"><?php echo $TPL_V1["contents"]?></td>
			<td align="center"><?php echo $TPL_V1["limit_date"]?></td>
			<td align="center"><?php if($TPL_V1["manager_seq"]){?>[수동] <?php echo $TPL_V1["mname"]?><?php }else{?>[자동]<?php }?></td>
		</tr>
<?php }}?>
<?php }else{?>
		<tr class="list-row">
			<td align="center" colspan="7">포인트 내역이 없습니다.</td>
		</tr>
<?php }?>
	</tbody>
</table>

<table align="center" border="0" cellpadding="0" cellspacing="0"  width="100%">
	<tr>
		<td align="center">
			<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
		</td>
	</tr>
</table>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>