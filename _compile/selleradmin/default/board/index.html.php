<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/board/index.html 000013419 */ 
$TPL_goodsqnaloop_1=empty($TPL_VAR["goodsqnaloop"])||!is_array($TPL_VAR["goodsqnaloop"])?0:count($TPL_VAR["goodsqnaloop"]);
$TPL_mbqnaloop_1=empty($TPL_VAR["mbqnaloop"])||!is_array($TPL_VAR["mbqnaloop"])?0:count($TPL_VAR["mbqnaloop"]);
$TPL_goodsreviewloop_1=empty($TPL_VAR["goodsreviewloop"])||!is_array($TPL_VAR["goodsreviewloop"])?0:count($TPL_VAR["goodsreviewloop"]);
$TPL_noticeloop_1=empty($TPL_VAR["noticeloop"])||!is_array($TPL_VAR["noticeloop"])?0:count($TPL_VAR["noticeloop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin-board.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('YmdH')?>"></script>
<script type="text/javascript">
	var board_id = '<?php echo $_GET["id"]?>';
	var boardlistsurl = '<?php echo $TPL_VAR["boardurl"]->lists?>';
	var boardwriteurl = '<?php echo $TPL_VAR["boardurl"]->write?>';
	var boardviewurl = '<?php echo $TPL_VAR["boardurl"]->view?>';
	var boardmodifyurl = '<?php echo $TPL_VAR["boardurl"]->modify?>';
	var boardreplyurl = '<?php echo $TPL_VAR["boardurl"]->reply?>';
	var file_use = '<?php echo $TPL_VAR["manager"]["file_use"]?>';

	$(document).ready(function() {	
		// 상품문의 게시글 보기
		$('span.goods_qna_boad_view_btn').live('click', function() {
			var board_seq = $(this).attr('board_seq');
			var board_id = $(this).attr('board_id');
			var boardviewurl = './goods_qna_view?id='+board_id+'&mainview=1&seq='+board_seq;
			boardaddFormDialog(boardviewurl, 1200, 700, getCurrentBoardName(this) + ' 게시글 보기','false');
		});
		
		// 상품후기 게시글 보기
		$('span.goods_review_boad_view_btn').live('click', function() {
			var board_seq = $(this).attr('board_seq');
			var board_id = $(this).attr('board_id');
			var boardviewurl = './goods_review_view?id='+board_id+'&mainview=1&seq='+board_seq;
			boardaddFormDialog(boardviewurl, 1200, 700, getCurrentBoardName(this) + ' 게시글 보기','false');
		});
		
		// 입점사문의 게시글 보기
		$('span.gs_seller_qna_boad_view_btn').live('click', function() { //
			var board_seq = $(this).attr('board_seq');
			var board_id = $(this).attr('board_id');
			var boardviewurl = './gs_seller_qna_view?id='+board_id+'&mainview=1&seq='+board_seq;
			boardaddFormDialog(boardviewurl, 1200, 700, getCurrentBoardName(this) + ' 게시글 보기','false');
		});
		
		//입점사공지 게시글 보기
		$('span.gs_seller_notice_boad_view_btn').live('click', function() { //
			var board_seq = $(this).attr('board_seq');
			var board_id = $(this).attr('board_id');
			var boardviewurl = './gs_seller_notice_view?id='+board_id+'&mainview=1&seq='+board_seq;
			boardaddFormDialog(boardviewurl, 1200, 700, getCurrentBoardName(this) + ' 게시글 보기','false');
		});		
		
		$('img.small_goods_image').load(function() {
			/* 스타일적용 */
			apply_input_style();
		});
	});
</script>
<style>
	.flex_wrap > li {width: calc(50% - 50px); flex-grow: initial;}
	.contents_dvs{margin:10px !important;}
	.boardleft{margin-left:0 !important;}
	.boardright {margin-right:0 !important;}
	.table_row_basic td {height: 35px !important;padding: 5px 10px !important;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<div class="page-title">
			<h2>최근 게시글 리스트</h2>
		</div>
		<ul class="page-buttons-right">
			<li>
				<select id="display_quantity" onchange="if(this.value){document.location.href='./?perpage='+this.value;}">
					<option id="dp_qty5" value="5"<?php if($_GET["perpage"]=='5'){?> selected<?php }?>>5개씩</option>
					<option id="dp_qty10" value="10"<?php if($_GET["perpage"]=='10'){?> selected<?php }?>>10개씩</option>
					<option id="dp_qty20" value="20"<?php if($_GET["perpage"]=='20'){?> selected<?php }?>>20개씩</option>
					<option id="dp_qty30" value="30"<?php if($_GET["perpage"]=='30'){?> selected<?php }?>>30개씩</option>
					<option id="dp_qty50" value="50"<?php if($_GET["perpage"]=='50'){?> selected<?php }?>>50개씩</option>
					<option id="dp_qty50" value="100"<?php if($_GET["perpage"]=='100'){?> selected<?php }?>>100개씩</option>
					<option id="dp_qty50" value="150"<?php if($_GET["perpage"]=='150'){?> selected<?php }?>>150개씩</option>
					<option id="dp_qty50" value="200"<?php if($_GET["perpage"]=='200'){?> selected<?php }?>>200개씩</option>
				</select>
			</li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->
<div id="boardmain" >
	<ul class="flex_wrap">
		<li id="boardtopleft" class="contents_dvs v2 boardleft">
			<!-- 상품문의  게시글리스트테이블 : 시작 -->		
			<div class="title_dvs">
				<div class="item-title"><a href="./board?id=goods_qna" style="margin-left:0"><?php echo $TPL_VAR["goodsqnaname"]?> <?php echo number_format($TPL_VAR["goodsqnatotalcount"])?>건</a></div>
				<div class="resp_btn_dvs"><a href="./board?id=goods_qna" style="display:inline-block; height: 30px; line-height: 30px;"> + 더보기</a></div>
			</div>
			<table class="table_row_basic">
				<!-- 상품문의 테이블 헤더 : 시작 -->
				<colgroup>
					<col>
					<col width="90">
					<col width="20%">
					<col width="150">
				</colgroup>
				<thead class="lth">
				<tr>
					<th>제목</th>
					<th>상태</th>
					<th>작성자</th>
					<th>문의일</th>
				</tr>
				</thead>
				<!-- 테이블 헤더 : 끝 -->

				<!-- 리스트 : 시작 -->
				<tbody class="ltb otb" id="ajaxTable">
					<!-- 리스트데이터 : 시작 -->
<?php if($TPL_VAR["goodsqnaloop"]){?>
<?php if($TPL_goodsqnaloop_1){foreach($TPL_VAR["goodsqnaloop"] as $TPL_V1){?>
						<tr class="list-row <?php if($TPL_V1["display"]== 1){?>gray<?php }?> <?php echo $TPL_V1["tdclass"]?>">
							<td class="left"> 
								<?php echo $TPL_V1["iconmobile"]?>

								<?php echo $TPL_V1["subject"]?>

								<?php echo $TPL_V1["iconimage"]?>

								<?php echo $TPL_V1["iconfile"]?>

								<?php echo $TPL_V1["iconnew"]?>

								<?php echo $TPL_V1["iconhot"]?>

								<?php echo $TPL_V1["iconhidden"]?>

							</td>
							<td class="center"><?php echo $TPL_V1["reply_title"]?></td>
							<td class="center name"><?php echo $TPL_V1["name"]?></td>
							<td class="center date"><?php echo $TPL_V1["date"]?></td>
						</tr>
<?php }}?>
<?php }else{?>
						<tr class="list-row"><td colspan="4" class="center" style="border-bottom:1px solid #ccc;"> 등록된 게시글이 없습니다. </td><tr>
<?php }?>
				</tbody>
				<!-- 리스트 : 끝 -->
			</table>			
			<!-- 상품문의 게시글리스트테이블 : 끝 -->		
		</li>
		<li id="boardtopright"  class="contents_dvs v2 boardright">
			<!-- 1:1문의 게시글리스트테이블 : 시작 -->		
			<div class="title_dvs">
				<div class="item-title"><a href="./board?id=gs_seller_qna" style="margin-left:0"><?php echo $TPL_VAR["mbqnaname"]?> <?php echo number_format($TPL_VAR["mbqnatotalcount"])?>건</a></div>
				<div class="resp_btn_dvs" style="margin-top:10px;font-size:12px;font-weight:bold;vertical-align:middle"><a href="./board?id=gs_seller_qna"> + 더보기</a></div>
			</div>
			<table class="table_row_basic">
				<!-- 테이블 헤더 : 시작 -->
				<colgroup>
					<col>
					<col width="90">
					<col width="20%">
					<col width="150">
				</colgroup>
				<thead class="lth">
				<tr>
					<th>제목</th>
					<th>상태</th>
					<th>작성자</th>
					<th>문의일</th>
				</tr>
				</thead>
				<!-- 테이블 헤더 : 끝 -->

				<!-- 리스트 : 시작 -->
				<tbody class="ltb otb" id="ajaxTable">
					<!-- 리스트데이터 : 시작 -->
<?php if($TPL_VAR["mbqnaloop"]){?>
<?php if($TPL_mbqnaloop_1){foreach($TPL_VAR["mbqnaloop"] as $TPL_V1){?>
						<tr class="list-row <?php if($TPL_V1["display"]== 1){?>gray<?php }?> <?php echo $TPL_V1["tdclass"]?>">
							<td class="left">
								<?php echo $TPL_V1["iconmobile"]?>

								<?php echo $TPL_V1["subject"]?>

								<?php echo $TPL_V1["iconimage"]?>

								<?php echo $TPL_V1["iconfile"]?>

								<?php echo $TPL_V1["iconnew"]?>

								<?php echo $TPL_V1["iconhot"]?>

								<?php echo $TPL_V1["iconhidden"]?>

							</td>
							<td class="center"><?php echo $TPL_V1["reply_title"]?></td>
							<td class="center name"><?php echo $TPL_V1["name"]?></td>
							<td class="center date"><?php echo $TPL_V1["date"]?></td>
						</tr>
<?php }}?>
<?php }else{?>
						<tr class="list-row"><td colspan="4" class="center" style="border-bottom:1px solid #ccc;"> 등록된 게시글이 없습니다. </td><tr>
<?php }?>
				</tbody>
				<!-- 리스트 : 끝 -->
			</table>			
			<!-- 1:1문의 게시글리스트테이블 : 끝 -->
		</li>
	</ul>
	<ul class="flex_wrap">
		<li id="boardbottomleft" class="contents_dvs v2 boardleft">
			<!-- 상품후기 게시글리스트테이블 : 시작 -->			
			<div class="title_dvs">
				<div class="item-title"><a href="./board?id=goods_review" style="margin-left:0"><?php echo $TPL_VAR["goodsreviewname"]?> <?php echo number_format($TPL_VAR["goodsreviewtotalcount"])?>건</a></div>
				<div class="resp_btn_dvs" style="margin-top:10px;font-size:12px;font-weight:bold;vertical-align:middle"><a href="./board?id=goods_review"> + 더보기</a></div>
			</div>
			<table class="table_row_basic">
				<!-- 테이블 헤더 : 시작 -->
				<colgroup>
					<col>
					<col width="20%">
					<col width="150">
				</colgroup>
				<thead class="lth">
				<tr>
					<th>제목</th>
					<th>작성자</th>
					<th>등록일</th>
				</tr>
				</thead>
				<!-- 테이블 헤더 : 끝 -->

				<!-- 리스트 : 시작 -->
				<tbody class="ltb otb" id="ajaxTable">
					<!-- 리스트데이터 : 시작 -->
<?php if($TPL_VAR["goodsreviewloop"]){?>
<?php if($TPL_goodsreviewloop_1){foreach($TPL_VAR["goodsreviewloop"] as $TPL_V1){?>
						<tr class="list-row <?php if($TPL_V1["display"]== 1){?>gray<?php }?> <?php echo $TPL_V1["tdclass"]?>">
							<td class="left">
								<?php echo $TPL_V1["iconmobile"]?>

								<?php echo $TPL_V1["subject"]?>

								<?php echo $TPL_V1["iconimage"]?>

								<?php echo $TPL_V1["iconfile"]?>

								<?php echo $TPL_V1["iconnew"]?>

								<?php echo $TPL_V1["iconhot"]?>

								<?php echo $TPL_V1["iconhidden"]?>


							</td>
							<td class="center name"><?php echo $TPL_V1["name"]?></td>
							<td class="center date"><?php echo $TPL_V1["date"]?></td>
						</tr>
<?php }}?>
<?php }else{?>
						<tr class="list-row"><td colspan="3" class="center" style="border-bottom:1px solid #ccc;"> 등록된 게시글이 없습니다. </td><tr>
<?php }?>
				</tbody>
				<!-- 리스트 : 끝 -->
			</table>
			
			<!-- 상품후기게시글리스트테이블 : 끝 -->
		</li>
		<li id="boardbottomright" class="contents_dvs v2 boardright">
			<!--  공지사항 게시글리스트테이블 : 시작 -->			
			<ul class="title_dvs">
				<li class="item-title"><a href="./board?id=gs_seller_notice" style="margin-left:0"><?php echo $TPL_VAR["noticename"]?> <?php echo number_format($TPL_VAR["noticetotalcount"])?>건</a></li>
				<li class="resp_btn_dvs" style="margin-top:10px;font-size:12px;font-weight:bold;vertical-align:middle"><a href="./board?id=gs_seller_notice"> + 더보기</a></li>
			</ul>
			<table class="table_row_basic">
				<!-- 테이블 헤더 : 시작 -->
				<colgroup>
					<col>
					<col width="20%">
					<col width="150">
				</colgroup>
				<thead class="lth">
				<tr>
					<th>제목</th>
					<th>작성자</th>
					<th>등록일</th>
				</tr>
				</thead>
				<!-- 테이블 헤더 : 끝 -->

				<!-- 리스트 : 시작 -->
				<tbody class="ltb otb" id="ajaxTable">
					<!-- 리스트데이터 : 시작 -->
<?php if($TPL_VAR["noticeloop"]){?>
<?php if($TPL_noticeloop_1){foreach($TPL_VAR["noticeloop"] as $TPL_V1){?>
						<tr class="list-row <?php if($TPL_V1["display"]== 1){?>gray<?php }?> <?php echo $TPL_V1["tdclass"]?>">
							<td class="left">
								<?php echo $TPL_V1["iconmobile"]?>

								<?php echo $TPL_V1["subject"]?>

								<?php echo $TPL_V1["iconimage"]?>

								<?php echo $TPL_V1["iconfile"]?>

								<?php echo $TPL_V1["iconnew"]?>

								<?php echo $TPL_V1["iconhot"]?>

								<?php echo $TPL_V1["iconhidden"]?>

							</td>
							<td class="center name"><?php echo $TPL_V1["name"]?></td>
							<td class="center date"><?php echo $TPL_V1["date"]?></td>
						</tr>
<?php }}?>
<?php }else{?>
						<tr class="list-row"><td colspan="3" class="center" style="border-bottom:1px solid #ccc;"> 등록된 게시글이 없습니다. </td><tr>
<?php }?>
				</tbody>
				<!-- 리스트 : 끝 -->
			</table>			
			<!-- 공지사항 게시글리스트테이블 : 끝 -->
		</li>
	</ul>
</div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>