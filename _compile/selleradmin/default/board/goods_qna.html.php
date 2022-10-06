<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/board/goods_qna.html 000008932 */ 
$TPL_noticeloop_1=empty($TPL_VAR["noticeloop"])||!is_array($TPL_VAR["noticeloop"])?0:count($TPL_VAR["noticeloop"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_boardmanagerlist_1=empty($TPL_VAR["boardmanagerlist"])||!is_array($TPL_VAR["boardmanagerlist"])?0:count($TPL_VAR["boardmanagerlist"]);?>
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

<div class="contents_dvs v2">
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
			<div class="dvs_right">
				<a href="<?php echo $TPL_VAR["boardurl"]->userurl?>" target="_blank" class="resp_btn v3">사용자 보기</a>
			</div>
        </div>
        <!-- 게시글리스트테이블 : 시작 -->
		<table class="table_row_basic tdc">
			<!-- 테이블 헤더 : 시작 -->
			<colgroup>
				<col width="50">
				<col width="50">
<?php if($TPL_VAR["categorylist"]){?><col width="100"><?php }?>
				<col width="150">
				<col>
				<col width="100">
				<col width="50">
				<col width="150">
				<col width="100">
				<col width="70">
				<col width="50">
				<col width="50">
			</colgroup>
			<thead class="lth">
			<tr>
				<th><label class="resp_checkbox"><input type="checkbox" name="checkboxAll" value="" id="checkboxAll"></label></th>
				<th nowrap>번호</th>
<?php if($TPL_VAR["categorylist"]){?><th>분류</th><?php }?>
				<th>상품명</th>
				<th>제목</th>
				<th nowrap>답변 상태</th>
				<th>답변</th>
				<th>작성자</th>
				<th>등록일</th>
				<th nowrap>조회수</th>
				<th nowrap>관리</th>
				<th nowrap>삭제</th>
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
						<td class="number" nowrap><?php echo $TPL_V1["number"]?></td>
<?php if($TPL_VAR["categorylist"]){?><td class="category" nowrap><?php echo $TPL_V1["category"]?></td><?php }?>
						<td nowrap>
<?php if($TPL_V1["goods_seq"]){?><a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php if($TPL_V1["goodsInfo"]["provider_seq"]&&$TPL_V1["goodsInfo"]["provider_seq"]!='1'){?>[<?php echo $TPL_V1["goodsInfo"]["provider_name"]?>] <?php }?><?php echo getstrcut($TPL_V1["goodsInfo"]["goods_name"], 8)?></a><?php }?>
						</td>
						<td class="left">
							<?php echo $TPL_V1["iconmobile"]?>

							<?php echo $TPL_V1["subject"]?>

							<?php echo $TPL_V1["iconimage"]?>

							<?php echo $TPL_V1["iconfile"]?>

							<?php echo $TPL_V1["iconvideo"]?>

							<?php echo $TPL_V1["iconnew"]?>

							<?php echo $TPL_V1["iconhot"]?>

							<?php echo $TPL_V1["iconhidden"]?>

						</td>
						<td></td>
						<td><?php echo $TPL_V1["replaybtn"]?></td>
						<td class="name"><?php echo $TPL_V1["name"]?></td>
						<td class="date"><?php echo $TPL_V1["date"]?></td>
						<td class="hit"><?php echo $TPL_V1["hit"]?></td>
						<td nowrap><?php echo $TPL_V1["modifybtn"]?></td>
						<td nowrap>
							<?php echo $TPL_V1["deletebtn"]?>

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
						<td class="number" nowrap><?php echo $TPL_V1["number"]?></td>
<?php if($TPL_VAR["categorylist"]){?><td class="category" nowrap><?php echo $TPL_V1["category"]?></td><?php }?>
						<td nowrap>
<?php if($TPL_V1["goods_seq"]){?><a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php if($TPL_V1["goodsInfo"]["provider_seq"]&&$TPL_V1["goodsInfo"]["provider_seq"]!='1'){?>[<?php echo $TPL_V1["goodsInfo"]["provider_name"]?>] <?php }?><?php echo getstrcut($TPL_V1["goodsInfo"]["goods_name"], 8)?></a><?php }?>
						</td>
						<td class="left">
							<?php echo $TPL_V1["iconmobile"]?>

							<?php echo $TPL_V1["subject"]?>

							<?php echo $TPL_V1["iconimage"]?>

							<?php echo $TPL_V1["iconfile"]?>

							<?php echo $TPL_V1["iconvideo"]?>

							<?php echo $TPL_V1["iconnew"]?>

							<?php echo $TPL_V1["iconhot"]?>

							<?php echo $TPL_V1["iconhidden"]?>

						</td>
						<td nowrap><?php echo $TPL_V1["reply_title"]?></td>
						<td><?php echo $TPL_V1["replaybtn"]?></td>
						<td class="name"><?php echo $TPL_V1["name"]?></td>
						<td class="date"><?php echo $TPL_V1["date"]?></td>
						<td class="hit"><?php echo $TPL_V1["hit"]?></td>
						<td nowrap><?php echo $TPL_V1["modifybtn"]?></td>
						<td nowrap>
							<?php echo $TPL_V1["deletebtn"]?>

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
			<div class="dvs_right">
				<a href="<?php echo $TPL_VAR["boardurl"]->userurl?>" target="_blank" class="resp_btn v3">사용자 보기</a>
			</div>
		</div>
	</div>
</div>

<br style="line-height:10px">

<!-- 페이징 -->
<div class="paging_navigation" style="margin:auto"><?php echo $TPL_VAR["pagin"]?></div>

<div id="boardmovecopyPopup" style="display:none">
	<form name="BoardCopy" id="BoardCopy" method="post" action="../board_process" target="actionFrame">
	<input type="hidden" name="mode" id="board_mode" value="">
	<input type="hidden" name="idck" id="idck" value="">
	<div align="center">
		<table class="table_basic">
		<tbody>
		<tr>
			<th>게시판</th>
			<td >
				<select name="copyid" id="copyid">
<?php if($TPL_boardmanagerlist_1){foreach($TPL_VAR["boardmanagerlist"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["id"]?>"><?php echo getstrcut($TPL_V1["name"], 20)?> (<?php echo number_format($TPL_V1["totalnum"])?>) </option>
<?php }}?>
				</select>
			</td>
		</tr>
		</tbody>
		</table>
	</div>
	<div style="padding:10px 0 0 0" align="center"><span class="btn medium"><input type="button" value="게시판복사" id="boardcopybtn" name="boardcopybtn"></span></div>
	</form>
</div>

<?php if(!$TPL_VAR["loop"]){?>
<script>
// colspan 계산
$("td[colspan='all']").each(function(){
	$(this).attr('colspan',$(this).closest("table").children("thead").first().children("tr").first().children("th").length);
});
</script>
<?php }?>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>