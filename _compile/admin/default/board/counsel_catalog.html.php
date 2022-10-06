<?php /* Template_ 2.2.6 2022/05/30 15:31:46 /www/music_brother_firstmall_kr/admin/skin/default/board/counsel_catalog.html 000015366 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script>
	$(document).ready(function() {
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

	function counselNoView(elem) {
		var related_no = JSON.parse(elem.getAttribute('data-related-no'));
		var form = document.getElementById('counselNoView');
		$.each(related_no, function(key, value) {
			if(!value || value==='0') value='';
			var $elem = $('#counselNoView [name="' + key + '"]');
			$elem.text(value);
			if($elem.attr('data-href')) {
				$elem.closest('a').attr('href', $elem.attr('data-href').replace('%s', value));
			}
		});
		openDialog("관련 번호 조회", "counselNoView", {"width":"550","show" : "fade","hide" : "fade"});
	}

	function counselView(seq){
<?php if($TPL_VAR["counsel_act_auth"]){?>
		$.ajax({
			'url' : '/admincrm/counsel_process/counsel_view',
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

			}
		});
		openDialog("상담 내역 수정", "counselView", {"width":"550","show" : "fade","hide" : "fade"});
<?php }else{?>
			alert("권한이 없습니다.");
<?php }?>
	}
</script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('YmdHis')?>"></script>

<style>
	.footer.search_btn_lay{ top: auto; left: calc(50% - 50px);}
</style>

<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>고객상담 통합게시판</h2>
		</div>		
	</div>
</div>
<div id="search_container" class="search_container">
    <form name="emoneylist" id="emoneylist">
		<table class="table_search">
			<tr>
				<th>검색어</th>
				<td>
					<select name="search_type">
						<option value>전체</option>
						<option value="name">이름</option>
						<option value="id">아이디</option>
						<option value="tel">전화번호</option>
						<option value="cell">휴대폰</option>
						<option value="email">이메일</option>
					</select>
                    <input type="text" name="search_member" value="<?php echo $_GET["search_member"]?>" size="80">
				</td>
			</tr>
			<tr>
				<th>날짜</th>
				<td>
                    <select name="dateType">
                        <option value="counsel_regdate">상담일</option>
                        <option value="counsel_complete_date">처리일</option>
					</select>

					<div class="date_range_form">
						<input type="text" name="sdate" class="datepicker sdate" maxlength="10">
						-
						<input type="text" name="edate" class="datepicker edate" maxlength="10">

						<div class="resp_btn_warp">
							<input type="button" range="today" value="오늘" class="select_date resp_btn">
							<input type="button" range="3day" value="3일간" class="select_date resp_btn">
							<input type="button" range="1week" value="일주일" class="select_date resp_btn">
							<input type="button" range="1month" value="1개월" class="select_date resp_btn">
							<input type="button" range="3month" value="3개월" class="select_date resp_btn">
							<input type="button" range="select_date_all"  value="전체" class="select_date resp_btn">
							<input name="select_date_regist" class="select_date_input" type="hidden">
						</div>
					</div>
				</td>
			</tr>
            <tr>
                <th>상담자</th>
                <td>
                    <input type="text" name="manager_name" size="20" value="<?php echo $_GET["manager_name"]?>">
                </td>
            </tr>
            <tr>
                <th>처리여부</th>
                <td>
                    <span class="resp_radio">
						<label>
							<input type="radio" name="counsel_status" value<?php if(!$_GET["counsel_status"]){?> checked<?php }?>>
							<span>전체</span>
						</label>
                    	<label>
							<input type="radio" name="counsel_status" value="complete"<?php if("complete"==$_GET["counsel_status"]){?> checked<?php }?>>
							<span>처리</span>
						</label>
                    	<label>
							<input type="radio" name="counsel_status" value="ing"<?php if("ing"==$_GET["counsel_status"]){?> checked<?php }?>>
							<span>처리중</span>
						</label>
						<label>
							<input type="radio" name="counsel_status" value="request"<?php if("request"==$_GET["counsel_status"]){?> checked<?php }?>>
							<span>미처리</span>
						</label>
					</span>
                </td>
            </tr>
            <tr>
                <th>관련번호</th>
                <td>
                    <select name="relationType">
                        <option value="order_seq"<?php if($_GET["relationType"]=="order_seq"){?> selected<?php }?>>주문번호</option>
                        <option value="export_code"<?php if($_GET["relationType"]=="export_code"){?> selected<?php }?>>출고번호</option>
                        <option value="return_code"<?php if($_GET["relationType"]=="return_code"){?> selected<?php }?>>반품번호</option>
                        <option value="refund_code">환불번호</option>
                        <option value="goods_qna_seq"<?php if($_GET["relationType"]=="goods_qna_seq"){?> selected<?php }?>>상품품의</option>
                        <option value="goods_review_seq"<?php if($_GET["relationType"]=="goods_review_seq"){?> selected<?php }?>>상품후기</option>
                        <option value="parent_counsel_seq"<?php if($_GET["relationType"]=="parent_counsel_seq"){?> selected<?php }?>>상담번호</option>
                    </select>
                    <input type="text" name="relationCode" size="20" value="<?php echo $_GET["relationCode"]?>">
                </td>
            </tr>
            <tr>
                <th>상담내용</th>
                <td >
                    <input type="text" name="search_text" size="35" value="<?php echo $_GET["search_text"]?>">
                </td>
            </tr>
        </table>
		<div class="footer search_btn_lay">
			<span class="search">
				<button type="button" class="search_submit resp_btn active size_XL">검색</button>
				<button type="button" class="search_reset resp_btn v3 size_XL">초기화</button>
			</span>
		</div>
    </form>
</div>
<script>
	gSearchForm.init({'pageid':'counsel_catalog','search_mode':'search','sc':<?php echo json_encode($_GET)?>});
</script>
<div class="contents_container">
	<table class="table_basic">
		<colgroup>
			<col width="1">
			<col width="100">
			<col width="100">
			<col width="100">
			<col>
			<col width="100">
			<col width="100">
			<col width="100">
			<col width="100">
		</colgroup>
		<thead class="lth">
			<tr>
				<th nowrap>번호</th>
				<th nowrap>아이디</th>
				<th nowrap>이름(닉네임)</th>
				<th nowrap>등급</th>
				<th nowrap>상담 내용</th>
				<th nowrap>관련 번호</th>
				<th nowrap>상담일</th>
				<th nowrap>처리 여부</th>
				<th nowrap>상담자</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["record"]){?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
			<tr>
				<td class="center"><?php echo $TPL_V1["_rno"]?></td>
				<td><?php if($TPL_V1["userid"]){?><span onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','<?php echo $TPL_V1["order_seq"]?>','right');" class="black underline"><?php echo $TPL_V1["userid"]?></span><?php }else{?>비회원<?php }?></td>
				<td><?php if($TPL_V1["userid"]){?><?php echo $TPL_V1["user_name"]?><?php }else{?><?php echo $TPL_V1["order_user_name"]?><?php }?></td>
				<td><?php echo $TPL_V1["group_name"]?></td>
				<td>
					<a href="javascript:counselView('<?php echo $TPL_V1["counsel_seq"]?>')">
						<span class="black underline" style="white-space:pre-line"><?php echo $TPL_V1["counsel_contents"]?></span>
					</a>
				</td>
				<td class="center">
					<a class="resp_btn" onclick="counselNoView(this)" data-related-no="{&quot;order_seq&quot;:&quot;<?php echo $TPL_V1["order_seq"]?>&quot;,&quot;export_code&quot;:&quot;<?php echo $TPL_V1["export_code"]?>&quot;,&quot;return_code&quot;:&quot;<?php echo $TPL_V1["return_code"]?>&quot;,&quot;refund_code&quot;:&quot;<?php echo $TPL_V1["refund_code"]?>&quot;,&quot;goods_qna_seq&quot;:&quot;<?php echo $TPL_V1["goods_qna_seq"]?>&quot;,&quot;goods_review_seq&quot;:&quot;<?php echo $TPL_V1["goods_review_seq"]?>&quot;,&quot;parent_counsel_seq&quot;:&quot;<?php echo $TPL_V1["parent_counsel_seq"]?>&quot;}">보기</a>
				</td>
				<td class="center">
					<nobr><?php echo str_replace(" ","</nobr> <nobr>",$TPL_V1["counsel_regdate"])?></nobr>
				</td>
				<td class="center"><?php if($TPL_V1["counsel_status"]=='complete'){?>처리<br><?php echo $TPL_V1["counsel_complete_date"]?><?php }elseif($TPL_V1["counsel_status"]=='ing'){?>처리 중<?php }else{?>미처리<?php }?></td>
				<td class="center"><?php echo $TPL_V1["manager_name"]?></td>
			</tr>
<?php }}?>
<?php }else{?>
			<tr class="list-row">
				<td class="center" colspan="9">등록된 상담 내역이 없습니다.</td>
			</tr>
<?php }?>
		</tbody>
	</table>
</div>
<div class="paging_navigation mb10"><?php echo $TPL_VAR["page"]["html"]?></div>

<div id="counselView" class="hide">
	<form name="counselModifyForm" id="counselModifyForm" method="post" target="actionFrame" action="/admincrm/counsel_process/counsel_modify">
		<input type="hidden" name="counsel_seq" value>
		<div class="content" style="margin-bottom: 70px;">
			<div class="item-title">상담 정보</div>
			<table class="table_basic thl">
				<thead>
					<tr>
						<th>항목</th>
						<th>내용</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>상담번호</th>
						<td id="counselSeq"></td>
					</tr>
					<tr>
						<th>상담자</th>
						<td><?php echo $TPL_VAR["managerInfo"]["mname"]?></td>
					</tr>
					<tr>
						<th>처리여부</th>
						<td>
							<select name="counsel_status">
								<option value="request">미처리</option>
								<option value="ing">처리중</option>
								<option value="complete">처리완료</option>
							</select>								
						</td>
					</tr>
				</tbody>
			</table>
			<div class="item-title">관련 번호</div>
			<table class="table_basic thl">
				<tbody>
					<tr>
						<th>주문번호</th>
						<td>
							<input type="text" name="order_seq">
						</td>
						<th>출고번호</th>
						<td>
							<input type="text" name="export_code">
						</td>
					</tr>
					<tr>
						<th>반품번호</th>
						<td>
							<input type="text" name="return_code">
						</td>
						<th>환불번호</th>
						<td>
							<input type="text" name="refund_code">
						</td>
					</tr>
					<tr>
						<th>상품문의</th>
						<td>
							<input type="text" name="goods_qna_seq">
						</td>
						<th>상담번호</th>
						<td>
							<input type="text" name="parent_counsel_seq">
						</td>
					</tr>
					<tr>
						<th>상품후기</th>
						<td colspan="3">
							<input type="text" name="goods_review_seq">
						</td>
					</tr>
				</tbody>
			</table>
			<div class="item-title">상담 내용</div>
			<textarea name="counsel_contents" id="counsel_contents" style="width:100%;box-sizing:border-box;resize:none" rows="5"></textarea>
		</div>
		<div class="footer">
			<button class="resp_btn size_XL active" type="submit">수정</button>
			<button class="resp_btn v3 size_XL" type="reset" onclick="$(this).closest('.ui-dialog').find('.ui-dialog-content').dialog('close')">취소</button>
		</div>
	</form>
</div>

<form id="counselNoView" class="hide">
	<div class="content" style="margin-bottom: 70px;">
		<table class="table_basic thl">
			<colgroup>
				<col width="20%">
				<col width="30%">
				<col width="20%">
				<col width="30%">
			</colgroup>
			<tr>
				<th>주문번호</th>
				<td>
					<a target="_blank">
						<span name="order_seq" data-href="/admin/order/view?no=%s" class="black underline"></span>
					</a>
				</td>
				<th>출고번호</th>
				<td>
					<a target="_blank">
						<span name="export_code" data-href="/admin/export/view?no=%s" class="black underline"></span>
					</a>
				</td>
			</tr>
			<tr>
				<th>반품번호</th>
				<td>
					<a target="_blank">
						<span name="return_code" data-href="/admin/returns/view?no=%s" class="black underline"></span>
					</a>
				</td>
				<th>환불번호</th>
				<td>
					<a target="_blank">
						<span name="refund_code" data-href="/admin/refund/view?no=%s" class="black underline"></span>
					</a>
				</td>
			</tr>
			<tr>
				<th>상품문의</th>
				<td>
					<a target="_blank">
						<span name="goods_qna_seq" data-href="/board/view?id=goods_qna&amp;seq=%s" class="black underline"></span>
					</a>
				</td>
				<th>상담번호</th>
				<td>
					<a target="_blank">
						<span name="parent_counsel_seq" data-href="javascript:counselView('%s')" class="black underline"></span>
					</a>
				</td>
			</tr>
			<tr>
				<th>상품후기</th>
				<td colspan="3">
					<a target="_blank">
						<span name="goods_review_seq" data-href="/board/view?id=goods_review&amp;seq=%s" class="black underline"></span>
					</a>
				</td>
			</tr>
		</table>
	</div>
	<div class="footer">
		<button class="resp_btn v3 size_XL" type="reset" onclick="$(this).closest('.ui-dialog').find('.ui-dialog-content').dialog('close')">닫기</button>
	</div>
</form>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>