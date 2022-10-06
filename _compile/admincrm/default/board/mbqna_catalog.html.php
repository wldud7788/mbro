<?php /* Template_ 2.2.6 2022/05/17 12:05:20 /www/music_brother_firstmall_kr/admincrm/skin/default/board/mbqna_catalog.html 000005990 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	var board_id = 'mbqna';
	var boardlistsurl = '/admin/board/board?id=mbqna';
	var boardwriteurl = '/admin/board/mbqna_write?id=mbqna&callPage=crm';
	var boardviewurl = '/admin/board/mbqna_view?id=mbqna&&callPage=crmseq=';
	var boardmodifyurl = '/admin/board/mbqna_write?id=mbqna&callPage=crm&seq=';
	var boardreplyurl = '/admin/board/mbqna_write?id=mbqna&reply=y&callPage=crm&seq=';
	var file_use = 'Y';
</script>
<script type="text/javascript" src="/app/javascript/js/admin-board.js?v=20141105"></script>
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

		$(".orderview").click(function(){
			var order_seq = $(this).attr("order_seq");
			var href = "/admin/order/view?no="+order_seq;
			var a = window.open(href, 'orderdetail'+order_seq, '');
			if ( a ) {
				a.focus();
			}
		});
	});
</script>

<div class="orderTitle"> 1:1 문의</div>
<div class="search-form-container" align="center">
	<table class="search-form-table">
		<form name="emoneylist" id="emoneylist">
		<colgroup>
			<col width="80" /><col />
		</colgroup>
		<tbody class="ltb otb" >
			<tr class="list-row">
				<td colspan="2">
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
			<tr class="list-row">
				<th class="its-th-align left">
					문의내역
				</th>
				<td class="its-td">
					<input type="text" name="search_text" size="67" value="<?php echo $_GET["search_text"]?>" title="제목, 내용">
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
<br style="line-height:20px" />

<table class="list-table-style" cellspacing="0" width="100%">
	<colgroup>
		<col width="50" />
		<col width="60" />
		<col width="100" />
		<col />
		<col width="120" />
		<col width="40" />
		<col width="50" />
		<col width="70" />
		<col width="120" />
	</colgroup>
	<thead class="lth">
		<tr>
			<th>번호</th>
			<th>문의번호</th>
			<th>분류</th>
			<th>제목</th>
			<th>등록일</th>
			<th>조회</th>
			<th>답변</th>
			<th>수동지급</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody class="ltb otb" >
<?php if($TPL_VAR["record"]){?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
		<tr class="list-row">
			<td align="center"><?php echo $TPL_V1["_rno"]?></td>
			<td align="center"><?php echo $TPL_V1["seq"]?></td>
			<td align="center"><?php echo $TPL_V1["category"]?></td>
			<td align="left"><span class="boad_view_btn hand" board_id="mbqna" board_seq="<?php echo $TPL_V1["seq"]?>" viewlink="/admin/board/mbqna_view?id=mbqna&seq=<?php echo $TPL_V1["seq"]?>&callPage=crm"><?php echo $TPL_V1["subject"]?></span></td>
			<td align="center"><?php echo $TPL_V1["r_date"]?></td>
			<td align="center"><?php echo $TPL_V1["hit"]?></td>
			<td align="center"><?php if($TPL_V1["re_contents"]){?>완료<?php }else{?>대기<?php }?></td>
			<td align="center"><?php echo $TPL_V1["emoneylay"]?></td>
			<td align="center">
				<?php echo $TPL_V1["modifybtn"]?>

				<?php echo $TPL_V1["replaybtn"]?>

			</td>
		</tr>
<?php }}?>
<?php }else{?>
		<tr class="list-row">
			<td align="center" colspan="9">등록된 상품문의가 없습니다.</td>
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
<?php $this->print_("emoneyform",$TPL_SCP,1);?>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>