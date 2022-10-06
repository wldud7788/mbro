<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/board/searchform.html 000012516 */ 
$TPL_boardmanagerlist_1=empty($TPL_VAR["boardmanagerlist"])||!is_array($TPL_VAR["boardmanagerlist"])?0:count($TPL_VAR["boardmanagerlist"]);
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_boardmanagercopylist_1=empty($TPL_VAR["boardmanagercopylist"])||!is_array($TPL_VAR["boardmanagercopylist"])?0:count($TPL_VAR["boardmanagercopylist"]);?>
<script type="text/javascript">
	var board_id = '<?php echo $_GET["id"]?>';
	var boardlistsurl = '<?php echo $TPL_VAR["boardurl"]->lists?>';
	var boardwriteurl = '<?php echo $TPL_VAR["boardurl"]->write?>';
	var boardviewurl = '<?php echo $TPL_VAR["boardurl"]->view?>';
	var boardmodifyurl = '<?php echo $TPL_VAR["boardurl"]->modify?>';
	var boardreplyurl = '<?php echo $TPL_VAR["boardurl"]->reply?>';
	var file_use = '<?php echo $TPL_VAR["manager"]["file_use"]?>';
</script>
<script type="text/javascript" src="/app/javascript/js/admin-board.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>


<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2><?php echo $TPL_VAR["manager"]["name"]?></h2>
		</div>	

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
<?php if($_GET["id"]!='gs_seller_notice'){?>
			<li>
<?php if($_GET["id"]!='gs_seller_qna'){?>
				<a href="<?php echo $TPL_VAR["boardurl"]->userurl?>" target="_blank" class="resp_btn active size_L" style="color:#fff">사용자 보기</a>
<?php }else{?>
				<button type="button" class="resp_btn active size_L" name="boardwrite" id="boad_write_btn" title="<?php echo $TPL_VAR["manager"]["name"]?>">게시글 등록</button>
<?php }?>
			</li>
<?php }?>
		</ul>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li>
				<select id="boardgo" onchange="if(this.value){document.location.href='./board?id='+this.value;}">
					<option value>주요게시판</option>
<?php if($TPL_boardmanagerlist_1){foreach($TPL_VAR["boardmanagerlist"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["id"]?>"<?php if($_GET["id"]==$TPL_V1["id"]){?> selected<?php }?>><?php echo getstrcut($TPL_V1["name"], 10)?> (<?php echo number_format($TPL_V1["totalnum"])?>)</option>
<?php }}?>
				</select>
			</li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 게시글리스트검색폼 : 시작 -->
<div id="search_container" class="search_container">
	<form name="boardsearch" id="boardsearch">
		<input type="hidden" name="id" value="<?php echo $_GET["id"]?>" cannotBeReset=1>
		<input type="hidden" name="perpage" id="perpage" value="<?php echo $_GET["perpage"]?>">
		<input type="hidden" name="page" id="page" value="<?php echo $_GET["page"]?>">
		<input type="hidden" name="category" id="category" value="<?php echo $_GET["category"]?>">
		<input type="hidden" name="searchreply" id="searchreply" value="<?php echo $_GET["searchreply"]?>">
		<input type="hidden" name="score" id="score" value="<?php echo $_GET["score"]?>">
		<input type="hidden" name="member_seq" id="member_seq" value="<?php echo $_GET["member_seq"]?>">
		<input type="hidden" name="mseq" id="mseq" value="<?php echo $_GET["mseq"]?>">

		<table class="table_search">
			<tr>
				<th>검색어</th>
				<td>
					<select name="search_type">
						<option value>전체</option>
						<option value="name">작성자</option>
						<option value="user_id">아이디</option>
						<option value="subject">제목</option>
						<option value="content">내용</option>
					</select>
					<input type="text" name="search_text" id="search_text" value="<?php echo $_GET["search_text"]?>" size="80">
				</td>
			</tr>
			<tr>
				<th>등록일</th>
				<td>
					<div class="date_range_form">
						<input type="text" name="rdate_s" class="datepicker sdate" maxlength="10">
						-
						<input type="text" name="rdate_f" class="datepicker edate" maxlength="10">
						<div class="resp_btn_wrap">
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
<?php if($TPL_VAR["categorylist"]){?>
			<tr>
				<th>분류</th>
				<td>
					<select name="category">
						<option value>전체</option>
<?php if($TPL_categorylist_1){foreach($TPL_VAR["categorylist"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>"<?php if($_GET["category"]==$TPL_V1){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
					</select>
				</td>
			</tr>
<?php }?>
<?php if($_GET["id"]=='mbqna'||$_GET["id"]=='bulkorder'||$_GET["id"]=='gs_seller_qna'||$_GET["id"]=='naverpay_qna'){?>
			<tr>
				<th>답변 상태</th>
				<td>
					<span class="resp_radio">
						<label>
							<input type="radio" name="reply" value<?php if(!$_GET["searchreply"]){?> checked<?php }?>>
							<span>전체</span>
						</label>
						<label>
							<input type="radio" name="reply" value="y"<?php if($_GET["searchreply"]=='y'){?> checked<?php }?>>
							<span>답변 대기</span>
						</label>
						<label>
							<input type="radio" name="reply" value="n"<?php if($_GET["searchreply"]=='n'){?> checked<?php }?>>
							<span>답변 완료</span>
						</label>
					</span>
				</td>
			</tr>
<?php }?>
<?php if($_GET["id"]=='store_review'){?>
			<tr>
				<th>평점</th>
				<td>
					<select name="score_avg">
						<option value>평점 전체</option>			
						<option value="1"<?php if($_GET["score_avg"]== 1){?> selected<?php }?>>1점</option>
						<option value="2"<?php if($_GET["score_avg"]== 2){?> selected<?php }?>>2점</option>
						<option value="3"<?php if($_GET["score_avg"]== 3){?> selected<?php }?>>3점</option>
						<option value="4"<?php if($_GET["score_avg"]== 4){?> selected<?php }?>>4점</option>
						<option value="5"<?php if($_GET["score_avg"]== 5){?> selected<?php }?>>5점</option>
						<option value="6"<?php if($_GET["score_avg"]== 6){?> selected<?php }?>>6점</option>
						<option value="7"<?php if($_GET["score_avg"]== 7){?> selected<?php }?>>7점</option>
						<option value="8"<?php if($_GET["score_avg"]== 8){?> selected<?php }?>>8점</option>
						<option value="9"<?php if($_GET["score_avg"]== 9){?> selected<?php }?>>9점</option>
						<option value="10"<?php if($_GET["score_avg"]== 10){?> selected<?php }?>>10점</option>
					</select>
				</td>
			</tr>
<?php }?>
<?php if($_GET["id"]=='goods_review'){?>
			<tr>
				<th>주문번호</th>
				<td>
					<input type="text" name="order_seq" id="order_seq" value="<?php echo $_GET["order_seq"]?>" size="33">
				</td>
			</tr>
			<tr>
				<th>평점</th>
				<td>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["manager"]["goods_review_type"]!='IMAGE'){?>
					<select name="score" class="line">
						<option value selected>평점 전체</option>
						<option value="1"<?php if($_GET["score"]== 1){?> selected<?php }?>>0~20</option>
						<option value="2"<?php if($_GET["score"]== 2){?> selected<?php }?>>21~40</option>
						<option value="3"<?php if($_GET["score"]== 3){?> selected<?php }?>>41~60</option>
						<option value="4"<?php if($_GET["score"]== 4){?> selected<?php }?>>61~80</option>
						<option value="5"<?php if($_GET["score"]== 5){?> selected<?php }?>>81~100</option>
					</select>
<?php }else{?>
					<select name="score" class="line">
						<option value selected>평점 전체</option>
						<option value="1"<?php if($_GET["score"]== 1){?> selected<?php }?>>★</option>
						<option value="2"<?php if($_GET["score"]== 2){?> selected<?php }?>>★★</option>
						<option value="3"<?php if($_GET["score"]== 3){?> selected<?php }?>>★★★</option>
						<option value="4"<?php if($_GET["score"]== 4){?> selected<?php }?>>★★★★</option>
						<option value="5"<?php if($_GET["score"]== 5){?> selected<?php }?>>★★★★★</option>
					</select>
<?php }?>
				</td>
			</tr>
			<tr>
				<th>구매 여부</th>
				<td>
					<div class="resp_radio">
						<label>
							<input type="radio" name="ordered_review" checked>
							전체
						</label>
						<label>
							<input type="radio" name="ordered_review" value="y">
							구매 상품
						</label>
						<label>
							<input type="radio" name="ordered_review" value="n">
							미구매 상품
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>회원 여부</th>
				<td>
					<div class="resp_radio">
						<label>
							<input type="radio" name="member_review" checked>
							전체
						</label>
						<label>
							<input type="radio" name="member_review" value="y">
							회원
						</label>
						<label>
							<input type="radio" name="member_review" value="n">
							비회원
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>기타 후기</th>
				<td>
					<div class="resp_radio">
						<label>
							<input type="radio" name="review_type" checked>
							전체
						</label>
						<label>
							<input type="radio" name="review_type" value="best">
							베스트 후기
						</label>
						<label>
							<input type="radio" name="review_type" value="npay">
							네이버페이 후기
						</label>
					</div>
				</td>
			</tr>
<?php }?>
<?php if($_GET["id"]=='faq'){?>
			<tr>
				<th>노출/미노출</th>
				<td>
					<div class="resp_radio">
						<label>
							<input type="radio" name="hidden" checked>
							전체
						</label>
						<label>
							<input type="radio" name="hidden" value="2">
							노출
						</label>
						<label>
							<input type="radio" name="hidden" value="1">
							미노출
						</label>
					</div>
				</td>
			</tr>
<?php }?>
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
	// gSearchForm.init(<?php echo json_encode($TPL_VAR["sc"])?>);
	gSearchForm.init({'pageid':'board_list','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','sc':<?php echo json_encode($TPL_VAR["sc"])?>});
</script>
<!-- 게시글리스트검색폼 : 끝 -->

<div id="boardmovecopyPopup" class="hide">
	<form name="BoardCopy" id="BoardCopy" method="post" action="../board_process" target="actionFrame">
		<input type="hidden" name="mode" id="board_mode" value>
		<input type="hidden" name="board_id" id="orignalboardid" value="<?php echo $_GET["id"]?>">
		<input type="hidden" name="delseq" id="delseq" value>
		<input type="hidden" name="queryString" id="queryString" value>
		<div class="content">
			<table class="table_basic">
				<tbody>
					<tr>
						<th>게시판</th>
						<td >
							<select name="copyid" id="copyid" required>
								<option value>선택</option>
<?php if($TPL_boardmanagercopylist_1){foreach($TPL_VAR["boardmanagercopylist"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["id"]?>"><?php echo $TPL_V1["name"]?> (<?php echo number_format($TPL_V1["totalnum"])?>)</option>
<?php }}?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="footer">
			<button class="resp_btn active" type="submit" id="boardcopybtn" name="boardcopybtn">제출</button>
			<button class="resp_btn v3" type="reset" onclick="$(this).closest('.ui-dialog').find('.ui-dialog-content').dialog('close')">취소</button>
		</div>
	</form>
</div>