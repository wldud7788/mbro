<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admincrm/skin/default/board/counsel_catalog.html 000014807 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	$(document).ready(function() {
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

<?php if($_GET["counsel_seq"]){?>
			counselView('<?php echo $_GET["counsel_seq"]?>');
<?php }?>

	});

	function counselView(seq){
<?php if($TPL_VAR["counsel_act_auth"]){?>
		$.ajax({
			'url' : '../counsel_process/counsel_view',
			'data' : {'seq':seq},
			'type' : 'post',
			'dataType': 'json',
			'success' : function(res){
				$("form#counselModifyForm input[name='counsel_seq']").val(seq);
				$("#counselSeq").html(res.counsel_seq);
				if(res.order_seq != 0){
					$("form#counselModifyForm input[name='order_seq']").val(res.order_seq);
				}else{
					$("form#counselModifyForm input[name='order_seq']").val("");
				}
<?php if($_GET["order_seq"]&&!$_GET["member_seq"]){?>
					$("form#counselModifyForm input[name='order_seq']").attr("readOnly",true);
<?php }?>
				$("form#counselModifyForm input[name='export_code']").val(res.export_code);
				$("form#counselModifyForm input[name='return_code']").val(res.return_code);
				$("form#counselModifyForm input[name='refund_code']").val(res.refund_code);
				if(res.goods_qna_seq != 0){
					$("form#counselModifyForm input[name='goods_qna_seq']").val(res.goods_qna_seq);
				}else{
					$("form#counselModifyForm input[name='goods_qna_seq']").val("");
				}
				if(res.goods_review_seq != 0){
					$("form#counselModifyForm input[name='goods_review_seq']").val(res.goods_review_seq);
				}else{
					$("form#counselModifyForm input[name='goods_review_seq']").val("");
				}
				if(res.parent_counsel_seq != 0){
					$("form#counselModifyForm input[name='parent_counsel_seq']").val(res.parent_counsel_seq);
				}else{
					$("form#counselModifyForm input[name='parent_counsel_seq']").val("");
				}
				
				if(res.counsel_status) $("form#counselModifyForm input[name='counsel_status']").val(res.counsel_status);
				if(res.counsel_contents) $("form#counselModifyForm #counsel_contents").val(res.counsel_contents);
				if(res.counsel_status == "request"){
					$("form#counselModifyForm select[name='counsel_status']").css("background-color", "#ff0000");
					$("form#counselModifyForm select[name='counsel_status']").css("color", "#ffffff");
				}else{
					$("form#counselModifyForm select[name='counsel_status']").css("background-color", "#ffffff");
					$("form#counselModifyForm select[name='counsel_status']").css("color", "#000000");
				}

				$("form#counselModifyForm select[name='counsel_status'] option[value='"+res.counsel_status+"']").attr('selected', true);

			}
		});
		openDialog("상담 내역 수정", "counselView", {"width":"450","height":"615","show" : "fade","hide" : "fade"});
<?php }else{?>
			alert("권한이 없습니다.");
<?php }?>
	}

	function modifyStatusBg(str){
		if(str == "request"){
			$("form#counselModifyForm select[name='counsel_status']").css("background-color", "#ff0000");
			$("form#counselModifyForm select[name='counsel_status']").css("color", "#ffffff");
		}else{
			$("form#counselModifyForm select[name='counsel_status']").css("background-color", "#ffffff");
			$("form#counselModifyForm select[name='counsel_status']").css("color", "#000000");
		}
	}
</script>

<div class="orderTitle">상담</div>
<div class="search-form-container" align="center">
	<table class="search-form-table">
		<form name="emoneylist" id="emoneylist">
		<colgroup>
			<col width="80" />
			<col />
			<col width="90" />
			<col />
		</colgroup>
		<tbody class="ltb otb" >
			<tr class="list-row">
				<td colspan="4">
					<select name="dateType">
						<option value="counsel_regdate">상담일</option>
						<option value="counsel_complete_date">처리일</option>
					</select>
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
					상담자
				</th>
				<td class="its-td">
					<select name="managerType">
						<option value="">직접입력</option>
					</select>
					<input type="text" name="manager_name" size="35" value="<?php echo $_GET["manager_name"]?>">
				</td>
				<th class="its-th-align left pdl10">
					처리여부
				</th>
				<td class="its-td">
					<label class="pdr20"><input type="checkbox" name="counsel_status[]" value="request" <?php if(in_array("request",$_GET["counsel_status"])){?>checked<?php }?>> 미처리</label>
					<label class="pdr20"><input type="checkbox" name="counsel_status[]" value="ing" <?php if(in_array("ing",$_GET["counsel_status"])){?>checked<?php }?>> 처리중</label>
					<label><input type="checkbox" name="counsel_status[]" value="complete" <?php if(in_array("complete",$_GET["counsel_status"])){?>checked<?php }?>> 처리</label>
				</td>
			</tr>
			<tr class="list-row">
				<th class="its-th-align left">
					관련번호
				</th>
				<td class="its-td">
					<select name="relationType">
						<option value="order_seq" <?php if($_GET["relationType"]=="order_seq"){?>selected<?php }?>>주문번호</option>
						<option value="export_code" <?php if($_GET["relationType"]=="export_code"){?>selected<?php }?>>출고번호</option>
						<option value="return_code" <?php if($_GET["relationType"]=="return_code"){?>selected<?php }?>>반품번호</option>
						<option value="refund_code">환불번호</option>
						<option value="goods_qna_seq" <?php if($_GET["relationType"]=="goods_qna_seq"){?>selected<?php }?>>상품품의</option>
						<option value="goods_review_seq" <?php if($_GET["relationType"]=="goods_review_seq"){?>selected<?php }?>>상품후기</option>
						<option value="parent_counsel_seq" <?php if($_GET["relationType"]=="parent_counsel_seq"){?>selected<?php }?>>상담번호</option>
					</select>
					<input type="text" name="relationCode" size="35" value="<?php echo $_GET["relationCode"]?>">
				</td>
				<th class="its-th-align left pdl10">
					상담내용
				</th>
				<td class="its-td">
					<input type="text" name="search_text" size="35" value="<?php echo $_GET["search_text"]?>">
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center" class="pdt15">
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
		<col />
		<col width="200" />
		<col width="100" />
		<col width="100" />
		<col width="70" />
	</colgroup>
	<thead class="lth">
		<tr>
			<th>번호</th>
			<th>상담번호</th>
			<th>상담내용</th>
			<th>관련번호</th>
			<th>상담일시</th>
			<th>처리여부</th>
			<th>상담자</th>
		</tr>
	</thead>
	<tbody class="ltb otb" >
<?php if($TPL_VAR["record"]){?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
		<tr class="list-row">
			<td align="center"><?php echo $TPL_V1["_rno"]?></td>
			<td align="center"><?php echo $TPL_V1["seq"]?></td>
			<td align="left" class="pdl5"><a href="javascript:counselView('<?php echo $TPL_V1["counsel_seq"]?>');"><?php echo str_replace(array("\r\n","\n"),array("<br>","<br>"),$TPL_V1["counsel_contents"])?></a></td>
			<td align="left" class="pdl5">
<?php if($TPL_V1["order_seq"]){?><div>주문번호 : <a href="/admin/order/view?no=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["order_seq"]?></span></a></div><?php }?>
<?php if($TPL_V1["export_code"]){?><div>출고번호 : <a href="/admin/returns/view?no=<?php echo $TPL_V1["export_code"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["export_code"]?></span></a></div><?php }?>
<?php if($TPL_V1["return_code"]){?><div>반품번호 : <a href="/admin/returns/view?no=<?php echo $TPL_V1["export_code"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["return_code"]?></span></a></div><?php }?>
<?php if($TPL_V1["refund_code"]){?><div>환불번호 : <a href="/admin/refund/view?no=<?php echo $TPL_V1["export_code"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["refund_code"]?></span></a></div><?php }?>
<?php if($TPL_V1["goods_qna_seq"]){?><div>상품문의 : <a href="/board/view?id=goods_qna&seq=<?php echo $TPL_V1["goods_qna_seq"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["goods_qna_seq"]?></span></a></div><?php }?>
<?php if($TPL_V1["goods_review_seq"]){?><div>상품후기 : <a href="/board/view?id=goods_review&seq=<?php echo $TPL_V1["goods_review_seq"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["goods_review_seq"]?></span></a></div><?php }?>
<?php if($TPL_V1["parent_counsel_seq"]){?><div>상담번호 : <a href="javascript:counselView('<?php echo $TPL_V1["parent_counsel_seq"]?>');"><span class="blue"><?php echo $TPL_V1["parent_counsel_seq"]?></span></a></div><?php }?>
			</td>
			<td align="center"><?php echo str_replace(" ","<br />",$TPL_V1["counsel_regdate"])?></td>
			<td align="center"><?php if($TPL_V1["counsel_status"]=='complete'){?>완료<br /> <?php echo $TPL_V1["counsel_complete_date"]?><?php }elseif($TPL_V1["counsel_status"]=='ing'){?>처리중<?php }else{?>미처리<?php }?></td>
			<td align="center"><?php echo $TPL_V1["manager_name"]?></td>
		</tr>
<?php }}?>
<?php }else{?>
		<tr class="list-row">
			<td align="center" colspan="7">등록된 상담 내역이 없습니다.</td>
		</tr>
<?php }?>
	</tbody>
</table>

<table align="center" border="0" cellpadding="0" cellspacing="0"  width="100%">
	<tr>
		<td align="center" style="padding-bottom:20px;">
			<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>
		</td>
	</tr>
</table>

<div id="counselView" class="hide">
	<form name="counselModifyForm" id="counselModifyForm" method="post" target="actionFrame" action="../counsel_process/counsel_modify">
	<input type="hidden" name="counsel_seq" value="">
	<table class="info-table-style" style="width:100%">
		<colgroup>
			<col width="80" />
			<col />
		</colgroup>
		<tbody>
			<tr>
				<th class="its-th-align center">상담번호</th>
				<td class="its-td" id="counselSeq"></td>
			</tr>
			<tr>
				<th class="its-th-align center">상 담 자&nbsp;</th>
				<td class="its-td"><?php echo $TPL_VAR["managerInfo"]["mname"]?></td>
			</tr>
			<tr>
				<th class="its-th-align center">주문번호</th>
				<td class="its-td">
					<input type="text" name="order_seq" value="">
				</td>
			</tr>
			<tr>
				<th class="its-th-align center">출고번호</th>
				<td class="its-td">
					<input type="text" name="export_code" value="">
				</td>
			</tr>
			<tr>
				<th class="its-th-align center">반품번호</th>
				<td class="its-td">
					<input type="text" name="return_code" value="">
				</td>
			</tr>
			<tr>
				<th class="its-th-align center">환불번호</th>
				<td class="its-td">
					<input type="text" name="refund_code" value="">
				</td>
			</tr>
			<tr>
				<th class="its-th-align center">상품문의</th>
				<td class="its-td">
					<input type="text" name="goods_qna_seq" value="">
				</td>
			</tr>
			<tr>
				<th class="its-th-align center">상품후기</th>
				<td class="its-td">
					<input type="text" name="goods_review_seq" value="">
				</td>
			</tr>
			<tr>
				<th class="its-th-align center">상담번호</th>
				<td class="its-td">
					<input type="text" name="parent_counsel_seq" value="">
				</td>
			</tr>
			<tr>
				<th class="its-th-align center">처리여부</th>
				<td class="its-td">
					<select name="counsel_status" style="background-color:#ff0000; color:#ffffff;" onChange="modifyStatusBg(this.value)">
						<option value="request">미처리</option>
						<option value="ing">처리중</option>
						<option value="complete">처리완료</option>
					</select>								
				</td>
			</tr>
			<tr>
				<th colspan="2" class="its-th-align center">상담내용</th>
			</tr>
			<tr>
				<td colspan="2" class="its-td center" style="padding:0px !important;"><textarea name="counsel_contents" id="counsel_contents" style="width:97%; border:0px;" rows="7"></textarea></td>
			</tr>
		</tbody>		
	</table>
	<div class="center pdt15 pdb20">
		<span class="btn_crm_search"><button type="submit" style="width:100%">수정<span class="arrow"></span></button></span>
	</div>
	</form>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>