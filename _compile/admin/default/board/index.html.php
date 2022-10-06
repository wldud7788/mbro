<?php /* Template_ 2.2.6 2022/05/17 12:30:54 /www/music_brother_firstmall_kr/admin/skin/default/board/index.html 000014842 */ 
$TPL_boardmanagerlist_1=empty($TPL_VAR["boardmanagerlist"])||!is_array($TPL_VAR["boardmanagerlist"])?0:count($TPL_VAR["boardmanagerlist"]);
$TPL_boardmainlist_1=empty($TPL_VAR["boardmainlist"])||!is_array($TPL_VAR["boardmainlist"])?0:count($TPL_VAR["boardmainlist"]);
$TPL_boardmainnosel_1=empty($TPL_VAR["boardmainnosel"])||!is_array($TPL_VAR["boardmainnosel"])?0:count($TPL_VAR["boardmainnosel"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/admin-board.js?v=20201120"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js"></script>
<script type="text/javascript">
	var board_id = '<?php echo $_GET["id"]?>';
	var boardlistsurl = '<?php echo $TPL_VAR["boardurl"]->lists?>';
	var boardwriteurl = '<?php echo $TPL_VAR["boardurl"]->write?>';
	var boardviewurl = '<?php echo $TPL_VAR["boardurl"]->view?>';
	var boardmodifyurl = '<?php echo $TPL_VAR["boardurl"]->modify?>';
	var boardreplyurl = '<?php echo $TPL_VAR["boardurl"]->reply?>';
	var file_use = '<?php echo $TPL_VAR["manager"]["file_use"]?>';

	$(document).ready(function() {

		$("#manager_main_btn").click(function() {
			openDialog("주요 게시판 보기 설정", "boardmanagermainPopup", {"width":"600","height":"610","show" : "fade","hide" : "fade"});
		});

		// 예약문의 답변하기
		$('span.store_reservation_boad_view_btn').click(function() {
			var board_seq = $(this).attr('board_seq');
			var board_id = $(this).attr('board_id');
			var boardwriteurl = './'+board_id+'_write?id='+board_id+'&reply=y&seq='+board_seq;
			boardaddFormDialog(boardwriteurl, 1200, 700, getCurrentBoardName(this) + ' 게시글 보기','false');
		});

		// 상품문의/상품후기/대량구매/faq/gs_seller 게시글 보기
		$('span.layer_boad_view_btn').click(function() {
			var board_seq = $(this).attr('board_seq');
			var board_id = $(this).attr('board_id');
			var boardviewurl = './'+board_id+'_view?id='+board_id+'&mainview=1&seq='+board_seq;
			boardaddFormDialog(boardviewurl, 1200, 700, getCurrentBoardName(this) + ' 게시글 보기','false');
		});

		//그외 추가 게시글 보기
		$('span.add_boad_view_btn').click(function() {
			var board_seq = $(this).attr('board_seq');
			var board_id = $(this).attr('board_id');
			var boardviewurl = './view?id='+board_id+'&mainview=1&seq='+board_seq;
			boardaddFormDialog(boardviewurl, 1200, 700, getCurrentBoardName(this) + ' 게시글 보기','false');
		});

	});

	$('img.small_goods_image').load(function() {
		/* 스타일적용 */
		apply_input_style();
	});

	 // 메뉴 끝으로 이동
	function fnMenuMoveEnd(oMenu) {
		var cnt = oMenu.length-1;
		var i=0;

		for (i=oMenu.length-1;i>=0;i--) {
			if (Menulist_isSelected(oMenu, i)) {
				if (i==oMenu.length-1) return;
				var idx = i;

				for (j=idx;j<cnt;j++) {
					Menulist_downMenu(oMenu, idx);
					idx = idx + 1;
				}
				cnt = cnt - 1;
			}
		}
	}

	// 메뉴 맨 위로 이동
	function fnMenuMoveStart(oMenu) {
		var i=0;
		var len = oMenu.length;
		var cnt = 0;
		for (i=0;i<oMenu.length;i++) {
		if (Menulist_isSelected(oMenu, i)) {
			if (i==0) return;
			var idx = i;

			for (j=idx;j>cnt;j--) {
				Menulist_upMenu(oMenu, idx);
				idx = idx - 1;
			}
			cnt = cnt + 1;
			}
		}
	}

	// 메뉴 위로 이동
	function fnMenuMoveUp(oMenu) {
		var i=0;
		for (i=0;i<oMenu.length;i++) {
			if (Menulist_isSelected(oMenu, i)) {
				if (i==0) return;
				Menulist_upMenu(oMenu, i);
			}
		}
	}

	// 메뉴 아래로 이동
	function fnMenuMoveDown(oMenu) {
		var i=0;
		for (i=oMenu.length-1;i>=0;i--) {
			if (Menulist_isSelected(oMenu, i)) {
				if (i==oMenu.length-1) return;
				Menulist_downMenu(oMenu, i);
			}
		}
	}

	function Menulist_downMenu(oMenu, index) {
		if (index < 0) return;
		if (index == oMenu.length-1) {
			return;// 더 이상 아래로 이동할 수 없을때
		}
		Menulist_moveMenu(oMenu, index, 1);
	}

	function Menulist_upMenu(oMenu, index) {
		if (index < 0) return;
		if (index == 0) {
			return;// 더 이상 위로 이동할 수 없을때
		}
		Menulist_downMenu(oMenu, index-1);
	}

	function Menulist_isSelected(oMenu, idx) {
		return (oMenu.options[idx].selected==true);
	}
	function Menulist_moveMenu(oMenu, index, distance) {
		var tmpOption = new Option(oMenu.options[index].text, oMenu.options[index].value, false,
		oMenu.options[index].selected);
		for (var i=index;i<index+distance;i++) {
			oMenu.options[i].text = oMenu.options[i+1].text;
			oMenu.options[i].value = oMenu.options[i+1].value;
			oMenu.options[i].selected = oMenu.options[i+1].selected;
		}
		oMenu.options[index+distance] = tmpOption;
	}

	function write_submit(){
		var option = document.getElementById("boardmain_item_use");
		if($('#boardmain_item_use').prop('options').length<1){
			alert('주요 게시판을 한 개 이상 선택해 주세요.');
			return false;
		}
		$.each($('#boardmain_item_use').prop('options'), function(_, elem) {
			elem.selected = true;
		});
		return true;
	}

	$(document).ready(function() {
			// 항목 추가
			$('#add_element').click(function() {
				$("#boardmain_item_nouse option:selected").each(function() {
					$(this).appendTo("#boardmain_item_use");
				});
			});
			$("#boardmain_item_nouse").dblclick(function(){
				$("#boardmain_item_nouse option:selected").each(function() {
					$(this).appendTo("#boardmain_item_use");
				});
			});

			// 항목 삭제
			$('#del_element').click(function() {
				var cnt = 0;
				$("#boardmain_item_use option:selected").each(function() {
					$(this).appendTo("#boardmain_item_nouse");
				});
				if(cnt>0) alert("필수 항목은 삭제하실 수 없습니다.");
			});

			$("#boardmain_item_use").dblclick(function(){
				var cnt = 0;
				$("#boardmain_item_use option:selected").each(function() {
					$(this).appendTo("#boardmain_item_nouse");
				});
				if(cnt>0) alert("필수 항목은 삭제하실 수 없습니다.");
			});

			// 항목 처음으로 이동
			$('#firstMove').click(function() {
				fnMenuMoveStart(document.BoardManagermain.boardmain_item_use);
			});

			// 항목 위로 이동
			$('#upMove').click(function() {
				fnMenuMoveUp(document.BoardManagermain.boardmain_item_use);
			});

			// 항목 아래로 이동
			$('#downMove').click(function() {
				fnMenuMoveDown(document.BoardManagermain.boardmain_item_use);
			});

			// 항목 마지막 이동
			$('#lastMove').click(function() {
				fnMenuMoveEnd(document.BoardManagermain.boardmain_item_use);
			});

	});
</script>
<style>
	.left-btns {float:left}
	.right-btns {float:right}
	td.name {line-height:1}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<div class="page-title">
			<h2>게시글 리스트</h2>
		</div>
		<ul class="page-buttons-left">
			<li>
				<select class="resp_btn size_L" id="boardgo" onchange="if(this.value){document.location.href='./board?id='+this.value;}">
					<option value>주요게시판</option>
<?php if($TPL_boardmanagerlist_1){foreach($TPL_VAR["boardmanagerlist"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["id"]?>"<?php if($_GET["id"]==$TPL_V1["id"]){?> selected<?php }?>><?php echo getstrcut($TPL_V1["name"], 10)?> (<?php echo number_format($TPL_V1["totalnum"])?>)</option>
<?php }}?>
				</select>
			</li>
		</ul>
		<ul class="page-buttons-right">
			<li>
				<select id="display_quantity" class="resp_btn size_L" onchange="if(this.value){document.location.href='./?perpage='+this.value;}">
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
			<li>
				<button class="resp_btn v2 size_L" type="button" name="manager_main" id="manager_main_btn">게시판 보기 설정</button>
			</li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<?php if($TPL_VAR["boardmainlist"]){?>
<div id="boardmain" class="contents_container">
<?php if($TPL_boardmainlist_1){$TPL_I1=-1;foreach($TPL_VAR["boardmainlist"] as $TPL_V1){$TPL_I1++;?>
	<div id="<?php if(($TPL_I1)% 2== 0){?>boardtopright<?php }else{?>boardtopleft<?php }?>" style="width:49.2%;margin:<?php if($TPL_V1["index"]< 2){?>10px<?php }else{?>30px<?php }?> 3px 0" class="<?php if(($TPL_I1+ 1)% 2== 0){?>fr<?php }else{?>fl<?php }?>">
		<ul class="clearbox">
			<li class="left-btns"><a href="./board?id=<?php echo $TPL_V1["id"]?>" style="margin-left:0"><span class="item-title"><?php echo $TPL_V1["boardname"]?> <?php echo number_format($TPL_V1["totalnum"])?>건</span></a></li>
			<li class="right-btns" style="margin-top:10px;font-size:12px;font-weight:bold;vertical-align:middle"><a href="./board?id=<?php echo $TPL_V1["id"]?>"> + 더보기</a></li>
		</ul>
		<table class="table_basic">
			<colgroup>
				<col>
<?php if($TPL_V1["id"]=='goods_qna'||$TPL_V1["id"]=='store_reservation'||$TPL_V1["id"]=='mbqna'||$TPL_V1["id"]=='bulkorder'){?><col width="90"><?php }?>
				<col width="20%">
				<col width="130">
			</colgroup>
			<thead class="lth">
				<tr>
					<th>내용</th>
<?php if($TPL_V1["id"]=='goods_qna'||$TPL_V1["id"]=='store_reservation'||$TPL_V1["id"]=='mbqna'||$TPL_V1["id"]=='bulkorder'){?><th>상태</th><?php }?>
					<th>작성자</th>
					<th><?php if($TPL_V1["id"]=='goods_qna'||$TPL_V1["id"]=='store_reservation'||$TPL_V1["id"]=='mbqna'||$TPL_V1["id"]=='bulkorder'){?>문의일<?php }else{?>등록일<?php }?></th>
				</tr>
			</thead>
			<!-- 테이블 헤더 : 끝 -->
			<!-- 리스트 : 시작 -->
			<tbody class="ltb otb" id="ajaxTable">
				<!-- 리스트데이터 : 시작 -->
<?php if($TPL_V1["widgetloop"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["widgetloop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<tr class="list-row<?php if($TPL_V2["display"]== 1){?> gray<?php }?> <?php echo $TPL_V2["tdclass"]?>">
						<td class="pdl10"><?php echo $TPL_V2["iconmobile"]?>

							<?php echo $TPL_V2["subject"]?>

							<?php echo $TPL_V2["iconimage"]?>

							<?php echo $TPL_V2["iconfile"]?>

							<?php echo $TPL_V2["iconnew"]?>

							<?php echo $TPL_V2["iconhot"]?>

							<?php echo $TPL_V2["iconhidden"]?>

						</td>
<?php if($TPL_V1["id"]=='goods_qna'||$TPL_V1["id"]=='store_reservation'||$TPL_V1["id"]=='mbqna'||$TPL_V1["id"]=='bulkorder'){?><td class="center"><?php echo $TPL_V2["reply_title"]?></td><?php }?>
						<td class="name pdl10"><?php echo $TPL_V2["name"]?></td>
						<td class="center date"><?php echo $TPL_V2["date"]?></td>
					</tr>
<?php }}?>
<?php }else{?>
				<tr class="list-row"><td colspan="<?php if($TPL_V1["id"]=='goods_qna'||$TPL_V1["id"]=='store_reservation'||$TPL_V1["id"]=='mbqna'||$TPL_V1["id"]=='bulkorder'){?>4<?php }else{?>3<?php }?>" class="center"> 등록된 게시글이 없습니다. </td></tr>
<?php }?>
			</tbody>
		</table>
	</div>
<?php if(($TPL_I1+ 1)% 2== 0){?><div class="cboth"></div><?php }?>
<?php }}?>
</div>
<?php }?>

<?php $this->print_("emoneyform",$TPL_SCP,1);?>


<div id="boardmanagermainPopup" class="hide">
	<form name="BoardManagermain" id="BoardManagermain" method="post" action="../boardmanager_process/boardmanagermain" target="actionFrame" onsubmit="return write_submit()" style="height:100%">
		<input type="hidden" name="seq" value="1">
		<input type="hidden" name="form_id" value="admin_goods_20161215144224">
		<input type="hidden" name="form_name" value="관리자 상품엑셀">
		<input type="hidden" name="form_type" value="GOODS">
		<input type="hidden" name="provider_seq" value="1">

		<div class="content">
			<table cellpadding="0" cellspacing="0" width="560">
				<tbody>
					<tr>
						<td class="center" valign="top">
							<div class="left">
								<span class="item-title">전체 게시판</span>
							</div>
							<select name="boardmain_item_nouse[]" id="boardmain_item_nouse" style="width:250px;height:380px" multiple>
<?php if($TPL_boardmainnosel_1){foreach($TPL_VAR["boardmainnosel"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["id"]?>"><?php echo $TPL_V1["boardname"]?> (<?php echo number_format($TPL_V1["totalnum"])?>)</option>
<?php }}?>
							</select>
						</td>
						<td width="60" class="center">
							<button type="button" id="add_element" style="width:35px" class="resp_btn size_S">&gt;</button>
							<div style="padding-top:6px;"></div>
							<button type="button" id="del_element" style="width:35px" class="resp_btn size_S">&lt;</button>
						</td>
						<td class="center" valign="top">
							<div class="left">
								<span class="item-title">노출 게시판</span>
								<select name="boardmain_item_use[]" id="boardmain_item_use" style="width:250px;height:380px" multiple>
<?php if($TPL_boardmainlist_1){foreach($TPL_VAR["boardmainlist"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1["id"]?>"<?php if($_GET["id"]==$TPL_V1["id"]){?> selected<?php }?>><?php echo $TPL_V1["boardname"]?> (<?php echo number_format($TPL_V1["totalnum"])?>)</option>
<?php }}?>
								</select>
							</div>
							<div class="mt5 fr">
								<button type="button" class="resp_btn size_S" id="firstMove">처음</button>
								<button type="button" class="resp_btn size_S" id="upMove">위로</button>
								<button type="button" class="resp_btn size_S" id="downMove">아래로</button>
								<button type="button" class="resp_btn size_S" id="lastMove">마지막</button>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="footer">
			<button type="submit" class="resp_btn size_XL active" id="boardmanagermainsave" name="boardmanagermainsave">저장</button>
			<button class="resp_btn v3 size_XL" type="reset" onclick="$(this).closest('.ui-dialog').find('.ui-dialog-content').dialog('close')">취소</button>
		</div>
	</form>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>