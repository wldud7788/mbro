<?php /* Template_ 2.2.6 2022/05/17 12:30:53 /www/music_brother_firstmall_kr/admin/skin/default/board/goods_review.html 000010602 */ 
$TPL_noticeloop_1=empty($TPL_VAR["noticeloop"])||!is_array($TPL_VAR["noticeloop"])?0:count($TPL_VAR["noticeloop"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script>
//체크박스 색상
$("input[type='checkbox'][name='del[]']").live('change',function(){
	if($(this).is(':checked')){
		$(this).closest('tr').addClass('checked-tr-background');
	}else{
		$(this).closest('tr').removeClass('checked-tr-background');
	}
}).change();
</script>

<?php $this->print_("searchform",$TPL_SCP,1);?>

<div class="contents_container">
	<div class="list_info_container">
		<div class="dvs_left">
            검색 <b><?php echo number_format($TPL_VAR["sc"]["searchcount"])?></b>개
            (총 <b><?php echo number_format($TPL_VAR["sc"]["totalcount"])?></b>개)
		</div>
		<div class="dvs_right">
            <select name="perpage" id="display_quantity">
                <option id="dp_qty10" value="10"<?php if($TPL_VAR["sc"]["perpage"]=='10'){?> selected<?php }?>>10개씩</option>
                <option id="dp_qty20" value="20"<?php if($TPL_VAR["sc"]["perpage"]=='20'){?> selected<?php }?>>20개씩</option>
                <option id="dp_qty30" value="30"<?php if($TPL_VAR["sc"]["perpage"]=='30'){?> selected<?php }?>>30개씩</option>
                <option id="dp_qty50" value="50"<?php if($TPL_VAR["sc"]["perpage"]=='50'){?> selected<?php }?>>50개씩</option>
                <option id="dp_qty50" value="100"<?php if($TPL_VAR["sc"]["perpage"]=='100'){?> selected<?php }?>>100개씩</option>
                <option id="dp_qty50" value="150"<?php if($TPL_VAR["sc"]["perpage"]=='150'){?> selected<?php }?>>150개씩</option>
                <option id="dp_qty50" value="200"<?php if($TPL_VAR["sc"]["perpage"]=='200'){?> selected<?php }?>>200개씩</option>
            </select>
		</div>
	</div>

	<div class="table_row_frame">
		<div class="dvs_top">
			<div class="dvs_left">
                <button class="resp_btn v3 multicmode" name="mode" value="board_multi_delete">선택 삭제</button>
<?php if($TPL_VAR["multi_copymove"]){?>
                <button class="resp_btn v2 multicmode" name="mode" value="board_multi_copy">선택 복사</button>
                <button class="resp_btn v2 multicmode" name="mode" value="board_multi_move">선택 이동</button>
<?php }?>
			</div>
			<div class="dvs_right">
				<a href="<?php echo $TPL_VAR["boardurl"]->userurl?>" target="_blank" class="resp_btn">사용자 보기</a>
			</div>
        </div>
        <!-- 게시글리스트테이블 : 시작 -->
		<table class="table_row_basic tdc">
			<!-- 테이블 헤더 : 시작 -->
			<colgroup>
				<col width="1">
				<col width="60">
				<col width="50">
<?php if($TPL_VAR["categorylist"]){?><col width="1"><?php }?>
				<col width="150">
				<col>
				<col width="110">
				<col width="90">
				<col width="100">
				<col width="100">
				<col width="100">
				<col width="60">
				<col width="1">
				<col width="1">
				<col width="1">
			</colgroup>
			<thead class="lthgoodsrevew">
			<tr>
				<th><label class="resp_checkbox"><input type="checkbox" name="checkboxAll" value="" id="checkboxAll"></label></th>
				<th nowrap>베스트</th>
				<th nowrap>번호</th>
<?php if($TPL_VAR["categorylist"]){?><th nowrap>분류</th><?php }?>
				<th>상품명</th>
				<th>제목</th>
				<th>평점</th>
				<th>구매여부</th>
				<th nowrap>리워드 (자동)</th>
				<th nowrap>리워드 (수동)</th>
				<th>작성자</th>
				<th>등록일</th>
				<th nowrap>조회수</th>
				<th nowrap>관리</th>
				<th>삭제</th>
			</tr>
			</thead>
			<!-- 테이블 헤더 : 끝 -->

			<!-- 리스트 : 시작 -->
			<tbody class="ltb otb" id="ajaxTable">
				<!-- 공지리스트데이터 : 시작 -->
<?php if($TPL_VAR["noticeloop"]){?>
<?php if($TPL_noticeloop_1){foreach($TPL_VAR["noticeloop"] as $TPL_V1){?>
					<tr class="list-row noticetr <?php echo $TPL_V1["onlynoticeclass"]?>">
						<td></td>
						<td></td>
						<td class="number"><?php echo $TPL_V1["number"]?></td>
<?php if($TPL_VAR["categorylist"]){?><td class="category" nowrap><?php echo $TPL_V1["category"]?></td><?php }?>
						<td class="left" nowrap>
<?php if($TPL_V1["goods_seq"]){?><a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">
								<span class="underline black"><?php if($TPL_V1["goodsInfo"]["provider_seq"]&&$TPL_V1["goodsInfo"]["provider_seq"]!='1'){?>[<?php echo $TPL_V1["goodsInfo"]["provider_name"]?>] <?php }?><?php echo getstrcut($TPL_V1["goodsInfo"]["goods_name"], 8)?></span>
							</a><?php }?>
						</td>
						<td class="left" nowrap>
							<?php echo $TPL_V1["iconmobile"]?>

							<?php echo $TPL_V1["subject"]?>

							<?php echo $TPL_V1["iconimage"]?>

							<?php echo $TPL_V1["iconfile"]?>

							<?php echo $TPL_V1["iconvideo"]?>

							<?php echo $TPL_V1["iconnew"]?>

							<?php echo $TPL_V1["iconhot"]?>

							<?php echo $TPL_V1["iconhidden"]?>

						</td>
						<td><?php echo $TPL_V1["scorelay"]?><?php if($TPL_V1["score_avg_lay"]){?>/100<?php }?></td>
						<td><?php echo $TPL_V1["buyertitle"]?></td>
						<td><?php echo $TPL_V1["autoemoneylay"]?></td>
						<td><?php echo $TPL_V1["emoneylay"]?></td>
						<td><?php echo $TPL_V1["name"]?></td>
						<td nowrap><?php echo $TPL_V1["date"]?></td>
						<td><?php echo $TPL_V1["hit"]?></td>
						<td nowrap>
<?php if($TPL_V1["npay_reviewid"]){?> -
<?php }else{?>
							<?php echo $TPL_V1["modifybtn"]?>

							<?php echo $TPL_V1["replaybtn"]?>

<?php }?>
						</td>
						<td nowrap>
<?php if($TPL_V1["npay_reviewid"]){?> -
<?php }else{?>
							<?php echo $TPL_V1["deletebtn"]?>

<?php }?>
						</td>
					</tr>
<?php }}?>
<?php }?>
				<!--공지 리스트 : 끝 -->

				<!-- 리스트데이터 : 시작 -->
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
					<tr class="list-row <?php if($TPL_V1["display"]== 1){?>gray<?php }?> <?php echo $TPL_V1["tdclass"]?>">
						<td><label class="resp_checkbox"><input type="checkbox" name="del[]" value="<?php echo $TPL_V1["seq"]?>" class="checkeds"></label></td>
						<td><span class="icon-best-gray best_select <?php echo $TPL_V1["best"]?> hand" seq="<?php echo $TPL_V1["seq"]?>"></span></td>
						<td><?php echo $TPL_V1["number"]?></td>
<?php if($TPL_VAR["categorylist"]){?><td class="category" nowrap><?php echo $TPL_V1["category"]?></td><?php }?>
						<td class="left" nowrap>
<?php if($TPL_V1["goods_seq"]){?><a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">
								<span class="underline black"><?php if($TPL_V1["goodsInfo"]["provider_seq"]&&$TPL_V1["goodsInfo"]["provider_seq"]!='1'){?>[<?php echo $TPL_V1["goodsInfo"]["provider_name"]?>] <?php }?><?php echo getstrcut($TPL_V1["goodsInfo"]["goods_name"], 8)?></span>
							</a><?php }?>
						</td>
						<td class="left" nowrap>
							<?php echo $TPL_V1["iconmobile"]?>

							<?php echo $TPL_V1["subject"]?>

							<?php echo $TPL_V1["iconimage"]?>

							<?php echo $TPL_V1["iconfile"]?>

							<?php echo $TPL_V1["iconvideo"]?>

							<?php echo $TPL_V1["iconnew"]?>

							<?php echo $TPL_V1["iconhot"]?>

							<?php echo $TPL_V1["iconhidden"]?>

						</td>
						<td><?php echo $TPL_V1["scorelay"]?><?php if($TPL_V1["score_avg_lay"]){?>/100<?php }?></td>
						<td><?php echo $TPL_V1["buyertitle"]?></td>
						<td><?php echo $TPL_V1["autoemoneylay"]?></td>
						<td><?php echo $TPL_V1["emoneylay"]?></td>
						<td><?php echo $TPL_V1["name"]?></td>
						<td nowrap><?php echo $TPL_V1["date"]?></td>
						<td><?php echo $TPL_V1["hit"]?></td>
						<td nowrap>
<?php if($TPL_V1["npay_reviewid"]){?> -
<?php }else{?>
							<?php echo $TPL_V1["modifybtn"]?>

							<?php echo $TPL_V1["replaybtn"]?>

<?php }?>
						</td>
						<td nowrap>
<?php if($TPL_V1["npay_reviewid"]){?> -
<?php }else{?>
							<?php echo $TPL_V1["deletebtn"]?>

<?php }?>
						</td>
					</tr>
<?php }}?>
<?php }else{?>
					<tr class="list-row">
						<td colspan="all">
<?php if($TPL_VAR["search_text"]){?>
								'<?php echo $TPL_VAR["search_text"]?>' 검색된 게시글이 없습니다.
<?php }else{?>
								등록된 게시글이 없습니다.
<?php }?>
						</td>
					</tr>
<?php }?>

			</tbody>
			<!-- 리스트 : 끝 -->
		</table>
		<!-- 게시글리스트테이블 : 끝 -->
		<div class="dvs_bottom">
			<div class="dvs_left">
                <button class="resp_btn v3 multicmode" name="mode" value="board_multi_delete">선택 삭제</button>
<?php if($TPL_VAR["multi_copymove"]){?>
                <button class="resp_btn v2 multicmode" name="mode" value="board_multi_copy">선택 복사</button>
                <button class="resp_btn v2 multicmode" name="mode" value="board_multi_move">선택 이동</button>
<?php }?>
			</div>
			<div class="dvs_right">
				<a href="<?php echo $TPL_VAR["boardurl"]->userurl?>" target="_blank" class="resp_btn">사용자 보기</a>
			</div>
		</div>
	</div>
</div>

<br style="line-height:10px">

<!-- 페이징 -->
<div class="paging_navigation mb10" style="margin:auto"><?php echo $TPL_VAR["pagin"]?></div>

<script type="text/javascript">
$(document).ready(function() {

	$(".orderview").click(function(){
		var order_seq = $(this).attr("order_seq");
		var href = "/admin/order/view?no="+order_seq;
		var a = window.open(href, 'orderdetail'+order_seq, '');
		if ( a ) {
			a.focus();
		}
	});

	$(".best_select").click(function(){
		var best = "";
		if($(this).hasClass("checked")){
			$(this).removeClass("checked");
			best = "none";
		}else{
			$(this).addClass("checked");
			best = "checked";
		}

		$.ajax({
			type: "post",
			url: "../board_goods_process",
			data: "mode=goods_review_best&board_id="+board_id+"&best="+best+"&seq="+$(this).attr("seq"),
			success: function(result){}
		});
	});


});
</script>

<?php if(!$TPL_VAR["loop"]){?>
<script>
// colspan 계산
$("td[colspan='all']").each(function(){
	$(this).attr('colspan',$(this).closest("table").children("thead").first().children("tr").first().children("th").length);
});
</script>
<?php }?>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>