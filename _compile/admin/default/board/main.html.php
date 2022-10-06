<?php /* Template_ 2.2.6 2022/05/30 15:31:09 /www/music_brother_firstmall_kr/admin/skin/default/board/main.html 000022558 */ 
$TPL_boardmanagerlist_1=empty($TPL_VAR["boardmanagerlist"])||!is_array($TPL_VAR["boardmanagerlist"])?0:count($TPL_VAR["boardmanagerlist"]);
$TPL_skinlist_1=empty($TPL_VAR["skinlist"])||!is_array($TPL_VAR["skinlist"])?0:count($TPL_VAR["skinlist"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	$(function(){
		$(".btnRestriction").on("click",function(){
			$.get('../member/sms_restriction?first=1&mode=board', function(data) {
				$('#restrictionPopup').html(data);
				openDialog("발송시간 제한 설정","restrictionPopup",{"width":"700","height":"460"});
			});
		});
	});
</script>
<style>
	table.list-table-style-board {width:100%; table-layout:fixed; letter-spacing:0px;}
	table.list-table-style-board thead.lth th {height:28px; border-top:1px solid #7f8180; border-bottom:1px solid #7f8180; font-weight:normal;  border-left:1px solid #ccc;}
	table.list-table-style-board thead.lth tr.double-row th {background:#eee;}
	table.list-table-style-board thead.lth tr.double-row:nth-child(2) th {border-top:0px}
	table.list-table-style-board tbody.ltb tr.list-title-row td.list-title-row-td {border-top:1px solid #eaeaea; border-bottom:2px solid #3a4452;}
	table.list-table-style-board tbody.ltb tr.list-row {}
	table.list-table-style-board tbody.ltb tr.list-row td {height:35px; border-bottom:1px solid #e3e3e3}
	.footer.search_btn_lay{ top: auto; left: calc(50% - 50px);}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>게시판 리스트</h2>
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
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 게시판리스트검색폼 : 시작 -->
<div id="search_container" class="search_container">
	<form name="boardsearch" id="boardsearch">
		<input type="hidden" name="perpage" id="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
		<table class="table_search">
			<tr>
				<th>검색어</th>
				<td>
					<select name="search_type">
						<option value>전체</option>
						<option value="id"<?php if($_GET["search_type"]==='id'){?> selected<?php }?>>게시판 아이디</option>
						<option value="name"<?php if($_GET["search_type"]==='name'){?> selected<?php }?>>게시판명</option>
					</select>
					<input type="text" name="search_text" id="search_text" value="<?php echo $_GET["search_text"]?>" size="80">
				</td>
			</tr>
			<tr>
				<th>유형</th>
				<td>
					<span class="resp_checkbox">
						<label>
							<input type="checkbox" name="skin_all" id="typecheckedall">
							<span>전체</span>
						</label>
<?php if($TPL_skinlist_1){foreach($TPL_VAR["skinlist"] as $TPL_K1=>$TPL_V1){?>
						<label>
							<input type="checkbox" name="skin[]" id="skin<?php echo $TPL_K1?>" value="<?php echo $TPL_K1?>"<?php if(in_array($TPL_K1,$_GET["skin"])){?> checked<?php }?>>
							<span><?php echo $TPL_V1?></span>
						</label>
<?php }}?>
					</span>
				</td>
			</tr>
			<tr>
				<th>구분</th>
				<td>
					<span class="resp_radio">
						<label>
							<input type="radio" name="type" value<?php if(!$_GET["type"]){?> checked<?php }?>>
							<span>전체</span>
						</label>
						<label>
							<input type="radio" name="type" value="A"<?php if($_GET["type"]==='A'){?> checked<?php }?>>
							<span>추가</span>
						</label>
						<label>
							<input type="radio" name="type" value="NA"<?php if($_GET["type"]==='NA'){?> checked<?php }?>>
							<span>기본</span>
						</label>
					</span>
				</td>
			</tr>
		</table>
		<div class="footer search_btn_lay">
			<span class="search">
				<button type="submit" class="search_submit resp_btn active" style="background: #525f78; border: 1px solid #525f78;">검색</button>
				<button type="reset" class="search_reset resp_btn v3" style="background: white; border: 1px solid #525f78;">초기화</button>
			</span>
		</div>
	</form>
</div>
<!-- 게시판리스트검색폼 : 끝 -->

<div class="contents_container">
	<div class="list_info_container">
		<div class="dvs_left">
			검색 <b><?php echo number_format($TPL_VAR["sc"]["searchcount"])?></b>개
			(
				총 <b><?php echo number_format($TPL_VAR["sc"]["totalcount"])?></b>개
<?php if($TPL_VAR["service_limit"]&&$TPL_VAR["config_system"]["service"]["max_board_cnt"]){?> / <b><?php echo number_format($TPL_VAR["config_system"]["service"]["max_board_cnt"])?></b>개까지 가능<?php }?>
			)
		</div>
		<div class="dvs_right">
			<select name="perpage" id="display_quantity">
				<option id="dp_qty10" value="10"<?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?>>10개씩</option>
				<option id="dp_qty20" value="20"<?php if($TPL_VAR["perpage"]== 20){?> selected<?php }?>>20개씩</option>
				<option id="dp_qty30" value="30"<?php if($TPL_VAR["perpage"]== 30){?> selected<?php }?>>30개씩</option>
				<option id="dp_qty50" value="50"<?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?>>50개씩</option>
			</select>
		</div>
	</div>

	<div class="table_row_frame">
		<div class="dvs_top">
			<div class="dvs_left">
				<button class="resp_btn v3 managermulticmode" name="mode" value="boardmanager_multi_delete">선택 삭제</button>
			</div>
			<div class="dvs_right">
				<button type="button" class="resp_btn btnRestriction">SMS 발송 시간</button>
				<button type="button" name="manager_write_btn<?php echo $TPL_VAR["service_limit"]?>" id="manager_write_btn<?php echo $TPL_VAR["service_limit"]?>" class="resp_btn active">게시판 추가</button>
			</div>
		</div>
		<!-- 게시핀리스트테이블 : 시작 -->
		<table class="table_row_basic tdc">
			<!-- 테이블 헤더 : 시작 -->
			<colgroup>
				<col width="1">
				<col width="60">
				<col width="60">
				<col width="130">
				<col>
				<col width="150">
				<col width="100">
				<col width="100">
				<col width="70">
				<col width="100">
				<col width="1">
				<col width="1">
				<col width="1">
			</colgroup>
			<thead class="lth">
			<tr class="double-row">
				<th>
					<label class="resp_checkbox"><input type="checkbox" name="checkboxAll" value id="checkboxAll"></label>
				</th>
				<th nowrap>번호</th>
				<th>구분</th>
				<th>유형</th>
				<th>게시판명</th>
				<th>게시판아이디</th>
				<th colspan="2">권한 (읽기/쓰기)</th>
				<th nowrap>게시글 수</th>
				<th>게시판 스킨</th>
				<th>게시글</th>
				<th nowrap>관리</th>
				<th nowrap>삭제</th>
			</tr>
			</thead>
			<!-- 테이블 헤더 : 끝 -->

			<!-- 리스트 : 시작 -->
			<tbody class="ltb otb">
				<!-- 리스트데이터 : 시작 -->
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<?php if(!serviceLimit('H_ST')&&$TPL_V1["id"]=='store_reservation'){?>
<?php }elseif(serviceLimit('H_ST')&&$TPL_V1["id"]=='bulkorder'){?>
<?php }elseif(serviceLimit('H_ST')&&$TPL_V1["id"]=='goods_review'){?>
<?php }elseif(serviceLimit('H_ST')&&$TPL_V1["id"]=='goods_qna'){?>
<?php }else{?>
					<tr class="list-row">
						<td>
							<label class="resp_checkbox"><input type="checkbox" <?php if(!$TPL_V1["managerdeletebtn"]){?> disabled="disabled" <?php }?> name="del[]" value="<?php echo $TPL_V1["id"]?>" class="checkeds"></label>
						</td>
						<td><?php echo $TPL_V1["number"]?></td>
						<td><?php echo $TPL_V1["typetitle"]?></td>
						<td><?php echo $TPL_V1["skintitle"]?></td>
						<td class="left">
							<a href="./manager_write?id=<?php echo $TPL_V1["id"]?>">
								<span class="black underline"><?php echo $TPL_V1["name"]?></span>
							</a>
						</td>
						<td class="left"><?php echo $TPL_V1["id"]?></td>
						<td nowrap><?php echo $TPL_V1["configvalread"]?></td>
						<td nowrap><?php echo $TPL_V1["configvalwrite"]?></td>
						<td><?php echo $TPL_V1["totalnum"]?></td>
						<td>
<?php if(!($TPL_V1["id"]=='gs_seller_qna'||$TPL_V1["id"]=='gs_seller_notice'||$TPL_V1["id"]=='naverpay_qna')){?>
						<input type="button" class="resp_btn" onclick="window.open('<?php echo $TPL_V1["userurl"]?>', '', ''); return false;" value="바로 가기">
<?php }?>
						</td>
						<td><input type="button" class="resp_btn v2" onclick="document.location.href='<?php echo $TPL_V1["dataurl"]?>';" value="게시글 보기"></td>
						<td nowrap class="pdl10"><?php echo $TPL_V1["managermodifybtn"]?> <?php echo $TPL_V1["managercopybtn"]?></td>
						<td><?php echo $TPL_V1["managerdeletebtn"]?></td>
					</tr>
<?php }?>
<?php }}?>
<?php }else{?>
					<tr class="list-row">
						<td colspan="14" align="center">
<?php if($TPL_VAR["search_text"]){?>
								'<?php echo $TPL_VAR["search_text"]?>' 검색된 게시판이 없습니다.
<?php }else{?>
								등록된 게시판이 없습니다.
<?php }?>
						</td>
					<tr>
<?php }?>

			</tbody>
			<!-- 리스트 : 끝 -->
		</table>
		<!-- 게시판리스트 테이블 : 끝 -->
		<div class="dvs_bottom">
			<div class="dvs_left">
				<button class="resp_btn v3 managermulticmode" name="mode" value="boardmanager_multi_delete">선택 삭제</button>
			</div>
			<div class="dvs_right">
				<button type="button" class="resp_btn btnRestriction">SMS 발송 시간</button>
				<button type="button" name="manager_write_btn<?php echo $TPL_VAR["service_limit"]?>" id="manager_write_btn<?php echo $TPL_VAR["service_limit"]?>" class="resp_btn active">게시판 추가</button>
			</div>
		</div>
	</div>
</div>

<!-- 페이징 -->
<?php if($TPL_VAR["pagin"]){?>
<div class="paging_navigation "><?php echo $TPL_VAR["pagin"]?> </div>
<?php }else{?>
<table align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">&nbsp;</td>
	</tr>
</table>
<?php }?>

<div id="BoadService" class="hide">
	<div>
		<table width="100%">
			<tr>
				<td align="left">
					오프라인샵 / 무료몰+ : 기본 6개 (게시판 추가 시 1개당 2,200원, 최초 1회 결제로 기간 관계 없이 계속 이용)<br>
					프리미엄몰+ 또는 독립몰+로 업그레이드 하시면 게시판을 무제한 이용 가능합니다.
				</td>
			</tr>
			<tr>
				<td align="center"><br><br>
				<input type="button" class="resp_btn size_S" id="board_charge" value="추가 신청 &gt;">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand" onclick="serviceUpgrade();" align="absmiddle">
				</td>
			</tr>
		</table>
	</div>
	<br style="line-height:20px">
</div>

<div id="boardiframeuselay" class="hide">
	<div style="border:0px #dddddd solid;padding:3px;width:95%;line-height:20px">
	<table width="100%">
		<tbody >
			<tr >
				<td width="130">iframe 허용 도메인 </td>
				<td >
				<textarea rows="3" readonly style="width:100%;overflow:auto">youtube.com,naver.com,daum.net,vimeo.com,ustream.tv,smartucc.kr</textarea>
				</td>
			</tr>
			<tr >
				<td >허용 파일확장자 </td>
				<td >
				<textarea rows="4" readonly style="width:100%;overflow:auto">txt,hwp,docx,docm,doc,ppt,pptx,pptm,pps,ppsx,xls,xlsx,xlsm,xlam,xla,ai,psd,eps,pdf,ods,ogg,mp4,avi,wmv,zip,rar,tar,7z,tbz,tgz,lzh,gz,dwg</textarea>
				</td>
			</tr>
			<tr >
				<td >허용 이미지확장자 </td>
				<td >
				<textarea rows="3" readonly style="width:100%;overflow:auto">jpg,jpeg,png,gif,bmp,tif,pic,ai,psd,eps,dwg </textarea>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
</div>
<?php if($TPL_VAR["service_limit"]){?>
<div id="BoadService" class="hide">
	<div >
		<table width="100%">
			<tr>
				<td align="left">
					오프라인샵 / 무료몰+ : 기본 5개 (게시판 추가 시 1개당 2,200원, 최초 1회 결제로 기간 관계 없이 계속 이용)<br>
					프리미엄몰+ 또는 독립몰+로 업그레이드 하시면 게시판을 무제한 이용 가능합니다.
				</td>
			</tr>
			<tr>
				<td align="center"><br><br>
					<input type="button" class="resp_btn size_S" id="board_charge" value="추가 신청 &gt;">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand" onclick="serviceUpgrade();" align="absmiddle">
				</td>
			</tr>
		</table>
	</div>
	<br style="line-height:20px">
</div>
<?php }?>

<div id="boardmanagercopyPopup" class="hide">
	<form name="BoardManagerCopy" id="BoardManagerCopy" method="post" action="../boardmanager_process" target="actionFrame">
		<input type="hidden" name="mode" id="" value="boardmanager_copy">
		<input type="hidden" name="idck" id="idck" value="">
		<div class="content">
			<table class="table_basic">
				<tbody>
					<tr>
						<th>게시판 아이디</th>
						<td >
							<input type="text" name="id" id="new_id" size="40" value="<?php echo $TPL_VAR["id"]?>" title="영문, 숫자, 언더스코어(_), 하이픈(-) 가능" remote="../boardmanager_process?mode=boardmanager_idck">
						</td>
					</tr>
					<tr>
						<th>게시판명</th>
						<td >
							<input type="text" name="name" id="new_name" class="line" size="45" title="쌍따옴표(&quot;)를 제외한 모든문자 사용가능합니다." value="<?php echo $TPL_VAR["name"]?>" <?php if($TPL_VAR["id"]&&$TPL_VAR["nameread"]){?> readonly="readonly" <?php }?>>
						</td>
					</tr>
					<tr>
						<th>설정복사</th>
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
		<div class="footer">
			<input type="submit" value="복사" class="resp_btn size_XL active" id="boardmanagercopysave" name="boardmanagermainsave">
			<button class="resp_btn size_XL v3" type="reset" onclick="$(this).closest('.ui-dialog').find('.ui-dialog-content').dialog('close')">취소</button>
		</div>
	</form>
</div>

<div id="boardPaymentPopup" class="hide"></div>
<div id="restrictionPopup" class="hide"></div>

<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="euc-kr"></script>
<script type="text/javascript" src="/app/javascript/js/admin-board.js?v=20141105"></script>
<script type="text/javascript">
	$(document).ready(function() {

		$("#manager_editor_btn").click(function() {
			openDialog("안내)허용 도메인/파일", "boardiframeuselay", {"width":"570","height":"300","show" : "fade","hide" : "fade"});
		});

		$("#boardiframeusesave").click(function(){
			var editor_secu_domain = $("#editor_secu_domain").val();
			var editor_secu_file = $("#editor_secu_file").val();
			var editor_secu_image = $("#editor_secu_image").val();

			$.ajax({
					'url' : '../boardmanager_process/boardiframeusesave',
					'data' : {'editor_secu_domain':editor_secu_domain,'editor_secu_file':editor_secu_file,'editor_secu_image':editor_secu_image},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){
						if(res.result == true ){
							alert(res.msg);
							document.location.reload();
						}else{
							alert(res.msg);
						}
					}
				});
		});

		$(":input[name=boarddelete]").click(function(){
			var board_name = $(this).attr('board_name');
			if(confirm("삭제된 게시글과 댓글은 복구할 수 없습니다.\n정말로 [" + board_name +"]을(를) 삭제하시겠습니까? ")) {
				var id = $(this).attr('board_id');
				$.ajax({
					'url' : '../boardmanager_process',
					'data' : {'mode':'boardmanager_delete', 'delid':id},
					'type' : 'post',
					'dataType': 'json',
					'success': function(data) {
						if(data.result == true){
							alert(" [" + board_name +"]을(를) 삭제하였습니다!");
							document.location.reload();
						}
					}
				});
			}
		});

		$('button.managermulticmode').click(function() {
			var mode = $(this).val();
			var delidar = '';
			$('.checkeds').each(function(e, el) {
				if( $(el).attr('checked') == 'checked' ){
					delidar += $(el).val() + ",";
				}
			});
			if(!delidar){
				alert('게시판을 선택해 주세요.');
				return false;
			}
			if(mode == 'boardmanager_multi_delete' ){//다중삭제시
				if(confirm("삭제된 게시글과 댓글은 복구할 수 없습니다.\n정말로 선택된 게시판을 삭제하시겠습니까? ")) {
					var id = $(this).attr('board_id');
					$.ajax({
						'url' : '../boardmanager_process',
						'data' : {'mode':'boardmanager_multi_delete', 'delidar':delidar},
						'type' : 'post',
						'dataType': 'json',
						'success' : function(data) {
							alert("게시판 [" + data.num +"]개를 성공적으로 삭제하였습니다!");
							document.location.reload();
						}
					});
				}
			}
		});

		$("input[name=boardmanagercopysave]").click(function(){
			var boardid = $('#new_id');
			var boardname = $('#new_name');
			$('#BoardManagerCopy').validate({
				onkeyup: false,
				rules: {
					id: { required:true, remote:{type:'post',url:'../boardmanager_process?mode=boardmanager_idck'}},
					name: { required:true}
				},
				messages: {
					id: { required:'아이디를 입력해 주세요.', remote: '아이디가 중복되었습니다.'},
					name: { required:'게시판명을 입력해 주세요.'}
				},
				errorPlacement: function(error, element) {
					error.appendTo(element.parent());
				},
				submitHandler: function(f) {
					var board_id_ck = /^[a-z0-9_-]{3,20}$/; // 아이디 검사식
					if (board_id_ck.test(boardid.val()) != true) { // 아이디 검사
						alert('유효한 게시판 아이디를 입력해 주세요.');
						boardid.focus();
						return false;
					}

					if (boardname.val().length < 3) { // 게시판명 검사
						alert('3자리이상 게시판명을 입력해 주세요.');
						boardname.focus();
						return false;
					}

					if (containsChars(boardname,"\"")) {
						alert('쌍따옴표(\") 를 제거후 게시판명으로 입력해 주세요.');
						boardname.focus();
						return false;
					}
					f.submit();
				}
			});

			$('#id').after('<strong></strong>');
			// #boardid 인풋에서 onkeyup 이벤트가 발생하면
			boardid.keyup( function() {
				var s = $(this).next('strong'); // strong 요소를 변수에 할당
				if (boardid.val().length == 0) { // 입력 값이 없을 때
					s.text(''); // strong 요소에 포함된 문자 지움
				} else if (boardid.val().length < 3) { // 입력 값이 3보다 작을 때
					s.text('너무 짧아요.'); // strong 요소에 문자 출력
				} else if (boardid.val().length > 20) { // 입력 값이 16보다 클 때
					s.text('너무 길어요.'); // strong 요소에 문자 출력
				}
			});

			$('#BoardManagerCopy').submit();
		});

		$("input[name=boardmanagercopybtn]").click(function(){
			$('#BoardManagerCopy')[0].reset();//초기화
			var board_id		= $(this).attr('board_id');
			var board_name	= $(this).attr('board_name');
			$("#copyid").val(board_id);
			$("#new_id").attr('title','영문, 숫자, 언더스코어(_), 하이픈(-) 가능');
			$("#new_name").attr('title','쌍따옴표(&quot;)를 제외한 모든문자 사용가능합니다.');
			openDialog("게시판 복사 <span class='desc'>빠르게 게시판을 생성합니다.</span>", "boardmanagercopyPopup", {"width":600,"height":300});
		});

		$('#typecheckedall').on('change', function() {
			$("input[name='skin[]']").prop('checked',$(this).prop('checked'));
		});

		// 게시판 등록
		$('#manager_write_btn').live('click', function() {
			$("#search_text").focus();//검색
			var queryString = $('#boardsearch').formSerialize();
			document.location.href='./manager_write?'+queryString;
		});

		// 게시판 등록(무료몰인경우 생성불가
		$('#manager_write_btnY').live('click', function() {
<?php if($TPL_VAR["config_system"]["service"]["max_board_cnt"]&&$TPL_VAR["use_board_cnt"]>=$TPL_VAR["config_system"]["service"]["max_board_cnt"]){?>
			openDialog("게시판 이용 안내<span class='desc'></span>", "BoadService", {"width":650,"height":230});
<?php }?>
		});

		// 무료몰인경우 대량구매게시판불가
		$("input[name=bulkorder_free_btn]").live('click', function() {
<?php if(serviceLimit('H_FR')){?>
			<?php echo serviceLimit('A1')?>

<?php }?>
		});


		// 게시판 수정
		$("input[name=manager_modify_btn]").live("click", function() {
			$("#search_text").focus();//검색
			var board_id = $(this).attr("board_id");
			var board_name = $(this).attr("board_name");
			var queryString = $('#boardsearch').formSerialize();
			document.location.href='./manager_write?'+queryString+'&id='+board_id;
			//boardaddFormDialog('./manager_write?id='+board_id, '90%', '700', board_name + ' 게시판 수정');
		});

		// 체크박스 색상
		$("input[type='checkbox'][name='del[]']").live('change',function(){
			if($(this).is(':checked')){
				$(this).closest('tr').addClass('checked-tr-background');
			}else{
				$(this).closest('tr').removeClass('checked-tr-background');
			}
		}).change();

		$('#board_charge').live('click', function (){
			$.get('board_payment', function(data) {
				$('#boardPaymentPopup').html(data);
				openDialog("게시판 추가 신청", "boardPaymentPopup", {"width":"800","height":"650"});
			});
		});
	});

	/**
	 * 입력값에 특정 문자(chars)가 있는지 체크
	 * 특정 문자를 허용하지 않으려 할 때 사용
	 * ex) if (containsChars(form.name,"^%$#@~;")) {
	 *         alert("이름 필드에는 특수 문자를 사용할 수 없습니다.");
	 *     }
	 */
	 function containsChars(input,chars) {
		 for (var inx = 0; inx < input.val().length; inx++) {
			if (chars.indexOf(input.val().charAt(inx)) != -1)
				return true;
		 }
		 return false;
	 }
</script>

<?php $this->print_("emoneyform",$TPL_SCP,1);?>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>