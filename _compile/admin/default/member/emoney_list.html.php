<?php /* Template_ 2.2.6 2022/05/17 12:36:27 /www/music_brother_firstmall_kr/admin/skin/default/member/emoney_list.html 000005101 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<script type="text/javascript">
$(document).ready(function() {
	// IFRAME RESIZING
	parent.$("#mbcontaineremoney").css("height","0px");
	$("#mbcontaineremoney", parent.document).height($(document).height()+10);



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
	parent.pop_history(seq);
}
</script>

<div class="item-title" style="width:92%">캐시 <span class="helpicon" title="캐시 지급/차감에 관한 내역을 확인할 수 있습니다."></span></div>

<form name="emoneylist" id="emoneylist">
<input type="hidden" name="member_seq" value="<?php echo $_GET["member_seq"]?>" />
<table width="100%" class="info-table-style">
<colgroup>
<col width="120" />
<col />
</colgroup>
<tbody>
<tr>
	<th class="its-th-align">지급/차감일</th>
	<td class="its-td-align pdl10">
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
<tr>
	<th class="its-th-align">지급/차감</th>
	<td class="its-td-align">
		<label class="ml10"><input type="checkbox" name="gb[]" value="plus" <?php if($TPL_VAR["sc"]["gb"]&&in_array('plus',$TPL_VAR["sc"]["gb"])){?>checked<?php }?>/> 지급</label>
		<label class="ml10"><input type="checkbox" name="gb[]" value="minus" <?php if($TPL_VAR["sc"]["gb"]&&in_array('minus',$TPL_VAR["sc"]["gb"])){?>checked<?php }?>/> 차감</label>
	</td>
</tr>
</table>
<div class="center pd20">
	<span class="btn large cyanblue"><button type="submit" id="send_submit">검색</button></span>
</div>
</form>
<br/>

<table class="list-table-style" cellspacing="0" width="100%">
	<colgroup>
		<col width="40" />
		<col width="15%" />
		<col width="10%" />
		<col />
		<col width="15%" />
		<col width="10%" />
		<col width="10%" />
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
		<td align="center">
<?php if($TPL_V1["gb"]=='plus'){?>
			<span style="color:red;">(+)</span> <?php echo get_currency_price($TPL_V1["emoney"])?>

<?php }else{?>
			<a href="javascript:view_history('<?php echo $TPL_V1["emoney_seq"]?>');"></a><span style="color:blue;">(-)</span> <?php echo get_currency_price($TPL_V1["emoney"])?>

<?php }?>
		</td>
		<td align="center"><?php echo $TPL_V1["memo"]?></td>
		<td align="center"><?php echo $TPL_V1["contents"]?></td>
		<td align="center"><?php echo $TPL_V1["limit_date"]?></td>
		<td align="center"><?php if($TPL_V1["manager_seq"]){?>[수동] <?php echo $TPL_V1["mname"]?><?php }else{?>[자동]<?php }?></td>
	</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" colspan="7">캐시 내역이 없습니다.</td>
	</tr>
<?php }?>
	</tbody>
</table>


<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td align="center">
		<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
	</td>
</tr>
</table>