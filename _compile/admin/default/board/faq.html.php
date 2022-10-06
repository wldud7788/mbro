<?php /* Template_ 2.2.6 2021/09/24 16:24:46 /www/music_brother_firstmall_kr/admin/skin/default/board/faq.html 000007286 */ 
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
				<col width="20">
				<col width="50">
<?php if($TPL_VAR["categorylist"]){?><col width="150"><?php }?>
				<col width="1">
				<col>
				<col width="200">
				<col width="130">
				<col width="90">
				<col width="1">
				<col width="1">
			</colgroup>
			<thead class="lth">
			<tr>
				<th><label class="resp_checkbox"><input type="checkbox" name="checkboxAll" value="" id="checkboxAll"></label></th>
				<th nowrap>번호</th>
<?php if($TPL_VAR["categorylist"]){?><th>분류</th><?php }?>
				<th><nobr>노출</nobr></th>
				<th>제목</th>
				<th>작성자</th>
				<th>등록일</th>
				<th>조회수</th>
				<th><nobr>관리</nobr></th>
				<th><nobr>삭제</nobr></th>
			</tr>
			</thead>
			<!-- 테이블 헤더 : 끝 -->

			<!-- 리스트 : 시작 -->
			<tbody class="ltb otb" id="ajaxTable">
				<!-- 리스트데이터 : 시작 -->
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
					<tr class="list-row <?php if($TPL_V1["display"]== 1){?>gray<?php }?> <?php echo $TPL_V1["tdclass"]?>">
						<td><label class="resp_checkbox"><input type="checkbox" name="del[]" value="<?php echo $TPL_V1["seq"]?>" class="checkeds"></label></td>
						<td class="number"><?php echo $TPL_V1["number"]?></td>
<?php if($TPL_VAR["categorylist"]){?><td class="category"><?php echo $TPL_V1["category"]?></td><?php }?>
						<td><?php echo $TPL_V1["hiddenbtn"]?></td>
						<td class="left">
							<div style="padding:10px 0 10px 0;line-height:160%"><?php echo $TPL_V1["subject"]?></div>
							<div id="faqcontent_<?php echo $TPL_V1["seq"]?>" class="<?php if($_GET["seq"]!=$TPL_V1["seq"]){?>hide<?php }?>" style="padding:20px 0 20px 0;line-height:160%">
								<!-- 업로드 파일 리스트 : 시작 -->
<?php if($TPL_V1["filelist"]){?>
									<div class="attach">
										<ul>
<?php if(is_array($TPL_R2=$TPL_V1["filelist"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
												<li><span class="realfilelist hand highlight-link" realfiledir="<?php echo $TPL_V2["realfiledir"]?>" realfilename="<?php echo $TPL_V2["orignfile"]?>" board_id="<?php echo $TPL_V1["boardid"]?>" filedown="../board_process?mode=board_file_down&board_id=<?php echo $TPL_V1["boardid"]?>&realfiledir=<?php echo $TPL_V2["realfiledir"]?>&realfilename=<?php echo $TPL_V2["orignfile"]?>"><?php echo $TPL_V2["orignfile"]?> (<span class="size"><?php echo $TPL_V2["realsizefile"]?></span>)<button type="button" class="bbs_btn">down</button></span></li>
<?php }}?>
										</ul>
									</div>
<?php }?>
								<!-- 업로드 파일 리스트 : 끝 -->
								<?php echo $TPL_V1["contents"]?>

							</div>
						</td>
						<td class="number"><?php echo $TPL_V1["name"]?></td>
						<td class="date"><?php echo $TPL_V1["date"]?></td>
						<td class="hit"><?php echo $TPL_V1["hit"]?></td>
						<td><?php echo $TPL_V1["modifybtn"]?></td>
						<td><?php echo $TPL_V1["deletebtn"]?></td>
					</tr>
<?php }}?>
<?php }else{?>
					<tr class="list-row">
						<td colspan="all" align="center">
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

<?php if(!$TPL_VAR["loop"]){?>
<script>
// colspan 계산
$("td[colspan='all']").each(function(){
	$(this).attr('colspan',$(this).closest("table").children("thead").first().children("tr").first().children("th").length);
});
</script>
<?php }?>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>