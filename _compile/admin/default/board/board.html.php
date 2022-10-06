<?php /* Template_ 2.2.6 2022/05/30 15:22:13 /www/music_brother_firstmall_kr/admin/skin/default/board/board.html 000009787 */ 
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
<style type="text/css">
	.footer.search_btn_lay{ top: auto;  left: calc(50% - 50px);}
</style>
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
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><col width="50"><?php }?>
<?php if($TPL_VAR["categorylist"]){?><col width="100"><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?><col><?php }?>
<?php if(!($TPL_VAR["manager"]["id"]=='notice'||$TPL_VAR["manager"]["id"]=='faq'||$TPL_VAR["manager"]["id"]=='gallery_bbs'||$TPL_VAR["manager"]["id"]=='product_bbs')){?><col width="100"><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><col width="200"><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><col width="130"><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><col width="90"><?php }?>
			<col width="1">
			<col width="1">
			</colgroup>
			<thead class="lth">
			<tr>
				<th><label class="resp_checkbox"><input type="checkbox" name="checkboxAll" value="" id="checkboxAll"></label></th>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><th nowrap>번호</th><?php }?>
<?php if($TPL_VAR["categorylist"]){?><th>분류</th><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?><th>제목</th><?php }?>
<?php if(!($TPL_VAR["manager"]["id"]=='notice'||$TPL_VAR["manager"]["id"]=='faq'||$TPL_VAR["manager"]["id"]=='gallery_bbs'||$TPL_VAR["manager"]["id"]=='product_bbs')){?><th>캐시</th><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><th>작성자</th><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><th>등록일</th><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><th>조회수</th><?php }?>
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
					<tr class="list-row noticetr">
						<td> </td>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><td class="number"><?php echo $TPL_V1["number"]?></td><?php }?>
<?php if($TPL_VAR["categorylist"]){?><td class="category"><?php echo $TPL_V1["category"]?></td><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?>
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
<?php }?>
<?php if(!($TPL_VAR["manager"]["id"]=='notice'||$TPL_VAR["manager"]["id"]=='faq'||$TPL_VAR["manager"]["id"]=='gallery_bbs'||$TPL_VAR["manager"]["id"]=='product_bbs')){?><td> </td><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><td class="name"><?php echo $TPL_V1["name"]?></td><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><td class="date"><?php echo $TPL_V1["date"]?></td><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><td class="hit"><?php echo $TPL_V1["hit"]?></td><?php }?>
						<td nowrap>
							<?php echo $TPL_V1["modifybtn"]?>

							<?php echo $TPL_V1["replaybtn"]?>

						</td>
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
					<tr class="list-row <?php if($TPL_V1["display"]== 1){?>gray<?php }?>">
						<td><label class="resp_checkbox"><input type="checkbox" name="del[]" value="<?php echo $TPL_V1["seq"]?>" class="checkeds" <?php if(!$TPL_V1["deletebtn"]){?> disabled="disabled" <?php }?>></label></td>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[num]')){?><td class="number"><?php echo $TPL_V1["number"]?></td><?php }?>
<?php if($TPL_VAR["categorylist"]){?><td class="category"><?php echo $TPL_V1["category"]?></td><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[subject]')){?>
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
<?php }?>
<?php if(!($TPL_VAR["manager"]["id"]=='notice'||$TPL_VAR["manager"]["id"]=='faq'||$TPL_VAR["manager"]["id"]=='gallery_bbs'||$TPL_VAR["manager"]["id"]=='product_bbs')){?><td><?php echo $TPL_V1["emoneylay"]?></td><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?><td class="name"><?php echo $TPL_V1["name"]?></td><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?><td class="date"><?php echo $TPL_V1["date"]?></td><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?><td class="hit"><?php echo $TPL_V1["hit"]?></td><?php }?>
						<td nowrap>
							<?php echo $TPL_V1["modifybtn"]?>

							<?php echo $TPL_V1["replaybtn"]?>

						</td>
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