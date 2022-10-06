<?php /* Template_ 2.2.6 2022/05/17 12:30:55 /www/music_brother_firstmall_kr/admin/skin/default/board/mbqna_write.html 000019138 */ 
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);?>
<?php if($_GET["mainview"]){?>
<script type="text/javascript">
	var board_id		= '<?php echo $_GET["id"]?>';
	var boardlistsurl	= '<?php echo $TPL_VAR["boardurl"]->lists?>';
	var boardwriteurl	= '<?php echo $TPL_VAR["boardurl"]->write?>';
	var boardviewurl	= '<?php echo $TPL_VAR["boardurl"]->view?>';
	var boardmodifyurl	= '<?php echo $TPL_VAR["boardurl"]->modify?>';
	var boardreplyurl	= '<?php echo $TPL_VAR["boardurl"]->reply?>';
	var file_use		= '<?php echo $TPL_VAR["manager"]["file_use"]?>';
</script>
<?php }?>
<form name="writeform" id="writeform" method="post" action="/admin/board_process" enctype="multipart/form-data" target="actionFrame">
<input type="hidden" name="callPage" id="callPage" value="<?php echo $_GET["callPage"]?>">
<input type="hidden" name="mode" id="mode" value="<?php echo $TPL_VAR["mode"]?>">
<input type="hidden" name="board_id" id="board_id" value="<?php echo $_GET["id"]?>">
<input type="hidden" name="reply" id="reply" value="<?php echo $_GET["reply"]?>">
<?php if($_GET["mainview"]){?>
	<input type="hidden" name="mainview" id="mainview" value="<?php echo $_GET["mainview"]?>">
<?php }?>
<?php if($TPL_VAR["seq"]){?>
	<input type="hidden" name="seq" id="seq" value="<?php echo $TPL_VAR["seq"]?>">
<?php }?>

<input type="hidden" name="returnurl" id="returnurl" value="<?php if($TPL_VAR["backtype"]=='view'){?><?php echo $TPL_VAR["boardurl"]->view?><?php }else{?><?php echo $TPL_VAR["boardurl"]->lists?><?php echo $TPL_VAR["boardurl"]->querystr?><?php }?>">

<div class="content">
	<div class="item-title">게시글</div>
<?php if($_GET["reply"]=='y'){?>
	<table class="table_basic thl">
		<tbody>
			<tr>
				<th>작성자</th>
				<td<?php if($TPL_VAR["emoneylay"]||$TPL_VAR["emoneyviewlay"]){?><?php }else{?> colspan="3"<?php }?>><?php echo $TPL_VAR["name"]?> (IP:<?php echo $TPL_VAR["ip"]?>)</td>
<?php if($TPL_VAR["emoneylay"]||$TPL_VAR["emoneyviewlay"]){?>
				<th>캐시</th>
				<td><?php if($TPL_VAR["emoneylay"]){?><?php echo $TPL_VAR["emoneylay"]?><?php }?><?php if($TPL_VAR["emoneyviewlay"]){?><?php echo $TPL_VAR["emoneyviewlay"]?><?php }?></td>
<?php }?>
			</tr>
			<tr>
				<th>날짜</th>
				<td><?php echo $TPL_VAR["m_date"]?></td>
				<th>조회</th>
				<td><?php echo number_format($TPL_VAR["hit"])?></td>
			</tr>
			<tr>
				<th>제목</th>
				<td colspan="3"><?php if($TPL_VAR["datacategory"]){?>[<?php echo $TPL_VAR["datacategory"]?>]<?php }?><?php echo $TPL_VAR["iconmobile"]?> <?php echo $TPL_VAR["subject"]?> <?php echo $TPL_VAR["iconnew"]?> <?php echo $TPL_VAR["iconhot"]?> <?php echo $TPL_VAR["iconhidden"]?></td>
			</tr>
			<tr>
				<th>내용</th>
				<td colspan="3">
					<div class="view-content"><?php echo $TPL_VAR["contents"]?></div>
<?php if($TPL_VAR["managerview"]["auth_recommend_use"]=='Y'){?>
					<div class="scorelay"><?php $this->print_("scoreskin",$TPL_SCP,1);?></div>
<?php }?>
				</td>
			</tr>
<?php if($TPL_VAR["filelist"]){?>
			<tr>
				<th>첨부 파일</th>
				<td colspan="3">
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
					<p>
						<a href="../board_process?mode=board_file_down&board_id=<?php echo $TPL_VAR["boardid"]?>&realfiledir=<?php echo $TPL_V1["realfiledir"]?>&realfilename=<?php echo $TPL_V1["orignfile"]?>" download onclick="return confirm('다운로드하시겠습니까?')"><?php echo $TPL_V1["orignfile"]?></a>
						<span>(<?php echo $TPL_V1["realsizefile"]?>)</span>
					</p>
<?php }}?>
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>

	<div class="item-title">답변</div>
	<table class="table_basic thl">
		<tbody>
			<tr>
				<th>제목</th>
				<td >
					<input type="text" name="re_subject" id="re_subject" value="<?php echo $TPL_VAR["re_subject"]?>" class="required line" title="답변제목을 입력해 주세요" style="width:95%">
				</td>
			</tr>
			<tr>
				<th>내용</th>
				<td >
					<textarea name="re_contents" id="re_contents" class="daumeditor" class="required"><?php echo $TPL_VAR["re_contents"]?></textarea>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="item-title">답변 알림</div>
	<table class="table_basic thl">
		<tbody>
			<tr>
				<th>SMS</th>
				<td>
					<label class="resp_checkbox">
						<input type="checkbox" name="board_sms" id="board_sms1" value="1"<?php if($TPL_VAR["manager"]["sms_reply_user_yn"]=="Y"&&$TPL_VAR["rsms"]=='Y'&&$TPL_VAR["tel1"]){?> checked<?php }?><?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');$('#board_sms1').prop('checked',false);"<?php }?> onchange="$('.funcSmsSend')[this.checked?'show':'hide']();">
						<span>SMS 발송</span>
					</label>
					<div class="funcSmsSend<?php if($TPL_VAR["manager"]["sms_reply_user_yn"]=="Y"&&$TPL_VAR["rsms"]=='Y'&&$TPL_VAR["tel1"]){?><?php }else{?> hide<?php }?>">
						<p>
							<input type="text" name="board_sms_hand" id="board_sms_hand" value="<?php echo $TPL_VAR["tel1"]?>" title="휴대폰 번호 입력">
							<span class="resp_message">잔여 SMS:<?php echo ($TPL_VAR["count"])?>건</span>
						</p>
<?php if($TPL_VAR["manager"]["sms_reply_user_yn"]!='Y'){?>
						<p>
							<span class="resp_message">- 게시판 설정 &gt; <a href="/admin/board/manager_write?id=<?php echo $_GET["id"]?>" target="_blank" class="blue">SMS발송</a>을 설정해주세요.</span>
						</p>
<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>이메일</th>
				<td>
					<label class="resp_checkbox">
						<input type="checkbox" name="board_email" id="board_email" value="1"<?php if($TPL_VAR["remail"]=='Y'&&$TPL_VAR["email"]&&!$TPL_VAR["isdemo"]["isdemo"]){?> checked<?php }?><?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');$('#board_email').prop('checked',false);"<?php }?> onchange="$('.funcMailSend')[this.checked?'show':'hide']();">
						<span>이메일 발송</span>
					</label>
					<div class="funcMailSend<?php if($TPL_VAR["remail"]=='Y'&&$TPL_VAR["email"]&&!$TPL_VAR["isdemo"]["isdemo"]){?><?php }else{?> hide<?php }?>">
						<p>
							<input type="text" name="board_sms_email" id="board_sms_email" value="<?php echo $TPL_VAR["email"]?>" title="이메일 입력">
						</p>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
<?php }else{?>
<table class="table_basic thl">
<tbody>
<?php if($TPL_VAR["goods_seq"]&&$TPL_VAR["goodsview"]){?>
		<tr>
			<th>상품정보</th>
			<td ><?php echo $TPL_VAR["goodsview"]?></td>
		</tr>
<?php }?>

<?php if($TPL_VAR["order_seq"]){?>
		<tr>
			<th>주문번호</th>
			<td > <span class="hand orderview blue bold" order_seq="<?php echo $TPL_VAR["order_seq"]?>"><?php echo $TPL_VAR["order_seq"]?></span></td>
		</tr>
<?php }?>
		<tr>
			<th>작성자</th>
			<td >
<?php if(!$_GET["seq"]||($_GET["seq"]&&($TPL_VAR["mseq"]=='-1'||$_GET["reply"]=='y'))){?>
					<?php echo $TPL_VAR["manager"]["writetitle"]?>

					<input type="hidden" name="name" id="name" value="<?php echo $TPL_VAR["manager"]["write_admin"]?>" title="작성자 입력" class="required line">
<?php }else{?>
<?php if($TPL_VAR["mseq"]){?>
						<?php echo $TPL_VAR["name"]?>

						<input type="hidden" name="name" id="name" value="<?php echo $TPL_VAR["real_name"]?>" title="작성자 입력" class="required line">
<?php }else{?>
						<input type="text" name="name" id="name" value="<?php echo $TPL_VAR["real_name"]?>" title="작성자 입력" class="required line">
<?php }?>
<?php }?>(IP:<?php echo $_SERVER["REMOTE_ADDR"]?>)

			</td>
		</tr>
		<tr>
			<th>제목</th>
			<td>
<?php if($TPL_VAR["categorylist"]){?>
				<select name="category" id="addcategory" class="required line">
					<option value>분류 선택</option>
<?php if($TPL_categorylist_1){foreach($TPL_VAR["categorylist"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>"<?php if(($TPL_VAR["category"])==($TPL_V1)){?> selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
					<option value="newadd">- 신규분류 -</option>
				</select>
				<input type="text" name="newcategory" id="newcategory" value title="분류 이름" class="hide line" size="30">
<?php }?>
				<input type="text" name="subject" id="subject" value="<?php echo $TPL_VAR["subject"]?>" class="required line" size="70">
				<?php echo $TPL_VAR["displayckeck"]?>

				<label class="resp_checkbox">
					<input type="checkbox" name="notice" id="boardnotice" value="1" <?php echo $TPL_VAR["noticeckeck"]?> onclick="noticecheck()">
					<span>공지글 등록</span>
				</label>
			</td>
		</tr>
<?php $this->print_("noticehidden",$TPL_SCP,1);?>

		<tr>
			<th>내용</th>
			<td >
				<textarea name="contents" id="contents" class="daumeditor" style='width:95%; height:200px;'  class="required"><?php echo $TPL_VAR["contents"]?></textarea>
			</td>
		</tr>
		<input type="hidden" name="re_contents" id="re_contents" value="<?php echo htmlspecialchars($TPL_VAR["re_contents"])?>">

<?php if($TPL_VAR["manager"]["file_use"]=='Y'||$TPL_VAR["filelist"]){?>
		<tr class="<?php if(!$TPL_VAR["ismobile"]){?>hide<?php }?>" id="filelistlay">
			<th>첨부파일</th>
			<td >
				<div>
					<table class="table_basic boardfileliststyle" id="BoardFileTable">
					<colgroup>
						<col width="10%">
						<col width="60%">
						<col width="20%">
					</colgroup>
					<thead>
					<tr>
						<th>순서</th>
						<th>파일</th>
						<th><span class="btn-plus gray"><button type="button" id="boardfileadd"></button></span></th>
					</tr>
					</thead>
					<tbody>
<?php if($TPL_VAR["filelist"]){?>
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
						<tr>
							<td align="center">↕</td>
							<td align="left"> <input type="file" name="file_info[]" value=""/>
							<input type="hidden" name="orignfile_info[]" class="orignfile_info" value="<?php echo $TPL_V1["realfilename"]?>^^<?php echo $TPL_V1["orignfile"]?>^^<?php echo $TPL_V1["sizefile"]?>^^<?php echo $TPL_V1["typefile"]?>"/>
							<span class="realfilelist hand highlight-link" realfiledir="<?php echo $TPL_V1["realfiledir"]?>" realfilename="<?php echo $TPL_V1["orignfile"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" filedown="../board_process?mode=board_file_down&board_id=<?php echo $TPL_VAR["boardid"]?>&realfiledir=<?php echo $TPL_V1["realfiledir"]?>&realfilename=<?php echo $TPL_V1["orignfile"]?>"><?php echo $TPL_V1["orignfile"]?></span> </td>
							<td align="center"><span class="btn-minus gray"><button type="button" class="etcDel"></button></span></td>
						</tr>
<?php }}?>
<?php if($TPL_VAR["manager"]["file_use"]=='Y'){?>
						<tr>
							<td align="center">↕</td>
							<td align="center"><input type="file" name="file_info[]"/></td>
							<td align="center"><span class="btn-minus gray"><button type="button" class="etcDel"></button></span></td>
						</tr>
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["manager"]["file_use"]=='Y'){?>
						<tr>
							<td align="center">↕</td>
							<td align="center"><input type="file" name="file_info[]"/></td>
							<td align="center"><span class="btn-minus gray"><button type="button" class="etcDel"></button></span></td>
						</tr>
<?php }?>
<?php }?>
					</tbody>
					</table>
				</div>
			</td>
		</tr>
<?php }?>
	</tbody>
</table>
<?php }?>

</div>
<div class="footer">
	<button type="submit" name="data_save_btn" id="data_save_btn" class="resp_btn size_XL active"><?php if($_GET["seq"]&&($_GET["reply"]!=='y'||$TPL_VAR["re_contents"])){?>수정<?php }else{?>저장<?php }?></button>
	<button class="resp_btn v3 size_XL" type="reset" onclick="$(this).closest('.ui-dialog').find('.ui-dialog-content').dialog('close')">취소</button>
</div>
</form>

<script type="text/javascript">
	$(document).ready(function() {
		//게시판글쓰기공통
		boardwrite();

		$(".orderview").click(function(){
			var order_seq = $(this).attr("order_seq");
			var href = "/admin/order/view?no="+order_seq;
			var a = window.open(href, 'orderdetail'+order_seq, '');
			if ( a ) {
				a.focus();
			}
		});

		$("#writeform button.board_emoneyt_btn").live("click",function(){
			$('#BoardEmoneytPopup')[0].reset();
			var mbname = $(this).attr('mbname');
			var mbtel = $(this).attr('mbtel');
			var board_seq = $(this).attr('board_seq');
			var mid = $(this).attr('mid');
			var mseq = $(this).attr('mseq');

			$('#emoney_board_seq').val(board_seq);
			$('#board_emoney_mid').val(mid);
			$('#board_emoney_mseq').val(mseq);
			$('#board_emoney_mbtel').val(mbtel);

			var managername = $(this).attr('managername');
			var board_id = $(this).attr('managerid');
			$('#board_board_id').val(board_id);
			$('#board_mbname').html(mbname + " (" + mbtel + ")");
			openDialog(" ["+managername+"]   <span class='desc'>캐시지급</span>", "BoardEmoneytlayList", {"width":"550","height":"380","show" : "fade","hide" : "fade"});
		});

		/* 첨부파일추가*/
		$("#boardfileadd").click(function(){
			var trObj = $("#BoardFileTable tbody tr");
			var trClone = trObj.eq(0).clone();
			trClone.find("input[type='file']").each(function(){
				$(this).val("");
			});
			trClone.find("span.realfilelist").remove();
			trClone.find("input.orignfile_info").remove();
			trObj.parent().append(trClone);
		});

		/* 첨부파일정보 삭제 */
		$("#BoardFileTable button.etcDel").click(function(){
			var deletefile = $(this).parent().parent().parent();

			if(deletefile.find("span.realfilelist").attr("realfiledir")){
				if(confirm("정말로 파일을 삭제하시겠습니까?") ) {
					var realfiledir = deletefile.find("span.realfilelist").attr("realfiledir");
					var realfilename = deletefile.find("span.realfilelist").attr("realfilename");
					var board_id =deletefile.find("span.realfilelist").attr("board_id");
					$.ajax({
						'url' : '../board_process',
						'data' : {'mode':'board_file_delete', 'realfiledir':realfiledir,  'realfilename':realfilename, 'board_id':board_id},
						'type' : 'post',
						'target' : 'actionFrame'
					});

					$(this).parent().parent().parent().remove();
				}
			}else{
				if($("#BoardFileTable tbody tr").length > 1) $(this).parent().parent().parent().remove();
			}
		});

		$("span.realfilelist").click(function(){
			var filedown = $(this).attr("filedown");
			if(confirm("다운받으시겠습니까?") ) {
				document.location.href=filedown;
			}
		});

			/* 첨부파일순서변경 */
		$("table.boardfileliststyle tbody").sortable({items:'tr'});

		//
		$(".sms_contents").live("keydown",function(){
			str = $(this).val();
			$(this).parent().parent().parent().find(".sms_byte").html(BoardchkByte(str));
		});
		$(".sms_contents").live("keyup",function(){
			str = $(this).val();
			$(this).parent().parent().parent().find(".sms_byte").html(BoardchkByte(str));
		});

		$("#backtype2").click(function() {
			$("#returnurl").val('<?php echo $TPL_VAR["boardurl"]->view?>');
		});

		$("#backtype1").click(function() {
			$("#returnurl").val('<?php echo $TPL_VAR["boardurl"]->lists?>');
		});


		// 게시글저장
		$('#data_save_btn').click(function() {
			$("#writeform").submit();
		});

		$('body,input,textarea,select').bind('keydown','Ctrl+s',function(event){
			event.preventDefault();

			$("#writeform").submit();
		});

		$('#writeform').validate({
			onkeyup: false,
			rules: {
				subject: { required:true},
				contents: { required:true}
			},
			messages: {
				name: { required:'<font color="red">작성자 입력.</font>'},
				category: { required:'질문유형을 선택해 주세요.'},
				subject: { required:'문의를 입력해 주세요.'}
			},
			errorPlacement: function(error, element) {
				error.appendTo(element.parent());
			},
			submitHandler: function(f) {
				if(readyEditorForm(f)){

<?php if($_GET["reply"]=='y'){?>
						if(!$("#re_subject").val() || $("#re_subject").val() == $("#re_subject").attr('title') ){
							alert('답변제목을 입력해 주세요.');
							return false;
						}
<?php }else{?>
						if(!$("#subject").val() || $("#subject").val() == $("#subject").attr('title') ){
							alert('제목을 입력해 주세요.');
							return false;
						}
<?php }?>

					if($("#addcategory").val() == "newadd"){//신규분류
						if(!$("#newcategory").val() ) {
							alert('질문유형을 입력해 주세요.');
							$("#newcategory").focus();
							return false;
						}
					}

<?php if($_GET["reply"]=='y'){?>
						if(!$("#re_contents").val() || $("#re_contents").val() == "<p>&nbsp;</p>" ){
							alert('답변을 입력해 주세요.');
							return false;
						}
<?php }else{?>
						if(!$("#contents").val() || $("#contents").val() == "<p>&nbsp;</p>" ){
							alert('내용을 입력해 주세요.');
							return false;
						}
<?php }?>
					f.submit();
					loadingStart();
				}
			}
		});


		$("#addcategory").bind("change",function(){
			if( $(this).val() == 'newadd') {
				$("#newcategory").removeClass("hide").addClass("show");
			}else{
				$("#newcategory").removeClass("show").addClass("hide");
			}
		});

		$("select[name='board_reserve_select']").live("change",function(){
			span_controller_view('board_reserve');
		});


	});

	function readfilelistNew(attachments){
<?php if(($TPL_VAR["manager"]["file_use"]=='Y'||$TPL_VAR["filelist"])&&!$TPL_VAR["ismobile"]){?>
<?php if($TPL_VAR["filelist"]){?>
	attachments['image'] = [];
	attachments['file'] = [];
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
		var  filePath = '<?php echo $TPL_V1["realfiledir"]?>';
		var  filePathurl = '<?php echo $TPL_V1["realfileurl"]?>';
<?php if($TPL_VAR["realthumbfile"]){?>
			var  realthumbfile = '<?php echo $TPL_V1["realthumbfiledir"]?>';
			var  thumbfilePathurl = 'http://<?php echo $_SERVER["HTTP_HOST"]?><?php echo $TPL_V1["realthumbfileurl"]?>';
<?php }?>
		var  orig_name = '<?php echo $TPL_V1["orignfile"]?>';
		var  file_size = <?php echo $TPL_V1["sizefile"]?>;
		var  typefile = '<?php echo $TPL_V1["typefile"]?>';

<?php if($TPL_V1["is_image"]||strstr($TPL_V1["typefile"],'image')||in_array($TPL_V1["typefile"],array('jpg','jpeg','png','gif','bmp','tif','pic'))){?>
			attachments['image'].push({
				'attacher': 'image',
				'data': {
					'imageurl': filePathurl,
					'filename': orig_name,
					'filesize': file_size,
					'imagealign': 'C',
					'originalurl': filePath,
					'thumburl': <?php if($TPL_VAR["realthumbfile"]){?> thumbfilePathurl <?php }else{?>filePathurl<?php }?>
				}
			});
<?php }else{?>
			attachments['file'].push({
				'attacher': 'file',
				'data': {
					'filename': orig_name,
					'filesize': file_size,
					'filemime':typefile,
					'originalurl': filePath,
					'attachurl': filePath
				}
			});
<?php }?>
<?php }}?>
	return attachments;
<?php }?>
<?php }?>
	}
	$(".content img").load(function() {
		//이미지 가로가 큰경우
		$(".content img").each(function() {
			var default_width = '600';
			if( $(this).width() > default_width || $(this).height() > default_width ) {
				imageResize(this);
			}
		});
	});
</script>