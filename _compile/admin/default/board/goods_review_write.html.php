<?php /* Template_ 2.2.6 2021/09/24 16:24:47 /www/music_brother_firstmall_kr/admin/skin/default/board/goods_review_write.html 000019480 */ 
$TPL_reviewcategorylist_1=empty($TPL_VAR["reviewcategorylist"])||!is_array($TPL_VAR["reviewcategorylist"])?0:count($TPL_VAR["reviewcategorylist"]);
$TPL_goodsreview_sub_1=empty($TPL_VAR["goodsreview_sub"])||!is_array($TPL_VAR["goodsreview_sub"])?0:count($TPL_VAR["goodsreview_sub"]);
$TPL_displayGoods_1=empty($TPL_VAR["displayGoods"])||!is_array($TPL_VAR["displayGoods"])?0:count($TPL_VAR["displayGoods"]);
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<?php if($_GET["mainview"]){?>
<script type="text/javascript">
var board_id = '<?php echo $_GET["id"]?>';
var boardlistsurl = '<?php echo $TPL_VAR["boardurl"]->lists?>';
var boardwriteurl = '<?php echo $TPL_VAR["boardurl"]->write?>';
var boardviewurl = '<?php echo $TPL_VAR["boardurl"]->view?>';
var boardmodifyurl = '<?php echo $TPL_VAR["boardurl"]->modify?>';
var boardreplyurl = '<?php echo $TPL_VAR["boardurl"]->reply?>';
var file_use = '<?php echo $TPL_VAR["manager"]["file_use"]?>';
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

<table class="table_basic thl">
<tbody>
<?php if($TPL_VAR["manager"]["video_use"]=='Y'){?>
		<tr>
			<th>동영상</th>
			<td >
				<table width="50%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center">
							<div id="boardVideolay">
<?php if($TPL_VAR["file_key_w"]&&uccdomain('fileswf',$TPL_VAR["file_key_w"],$TPL_VAR["manager"])){?>
								<label class="resp_checkbox"><input type="checkbox" name="video_del" value="1">삭제</label>
								<div>
									<embed src="<?php echo uccdomain('fileswf',$TPL_VAR["file_key_w"],$TPL_VAR["manager"])?>" width="200" height="200" allowfullscreen="true" wmode="transparent"></embed>
								</div>
<?php }?>
							</div>
						</td>
						<td ><button type="button" class="resp_btn batchVideoRegist" board_seq="<?php echo $_GET["seq"]?>">동영상등록</button></td>
					</tr>
				</table>
			</td>
		</tr>
<?php }elseif($TPL_VAR["file_key_w"]&&uccdomain('fileswf',$TPL_VAR["file_key_w"],$TPL_VAR["manager"])){?>
		<tr>
			<th>동영상</th>
			<td class="cell left">
				<table width="100" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center">
							<div id="boardVideolay">
								<label class="resp_checkbox"><input type="checkbox" name="video_del" value="1">삭제</label>
								<div>
									<embed src="<?php echo uccdomain('fileswf',$TPL_VAR["file_key_w"],$TPL_VAR["manager"])?>" width="200" height="200" allowfullscreen="true"></embed>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
<?php }?>

		<tr>
			<th>작성자</th>
			<td >
<?php if(!$_GET["seq"]||($_GET["seq"]&&($TPL_VAR["mseq"]=='-1'||$_GET["reply"]=='y'))){?>
					<?php echo $TPL_VAR["manager"]["writetitle"]?>

					 <input type="hidden" name="name" id="name" value="<?php echo $TPL_VAR["manager"]["write_admin"]?>" title="작성자를 입력해 주세요" class="required line">
<?php }else{?>
<?php if($TPL_VAR["mseq"]){?>
						<?php echo $TPL_VAR["name"]?>

						<input type="hidden" name="name" id="name" value="<?php echo $TPL_VAR["real_name"]?>" title="작성자를 입력해 주세요" class="required line">
<?php }else{?>
						<input type="text" name="name" id="name" value="<?php echo $TPL_VAR["real_name"]?>" title="작성자를 입력해 주세요" class="required line">
<?php }?>
<?php }?>(IP:<?php echo $TPL_VAR["ip"]?>)

			</td>
		</tr>
<?php if($TPL_VAR["order_seq"]){?>
		<tr>
			<th>주문번호</th>
			<td><b><?php echo $TPL_VAR["order_seq"]?></b>
			<!-- 해당 상품이 배송완료된 주문내역입니다.
			<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["order_seq"]?>"> -->
			</td>
		</tr>
<?php }?>

<?php if(!$TPL_VAR["isplusfreenot"]){?>
		<tr>
			<th>평점</th>
			<td><?php echo $TPL_VAR["scorelay"]?></td>
		</tr>
<?php }else{?>
<?php if($TPL_reviewcategorylist_1){$TPL_I1=-1;foreach($TPL_VAR["reviewcategorylist"] as $TPL_V1){$TPL_I1++;?>
		<tr>
			<th><?php echo $TPL_V1["title"]?></th>
			<td><?php echo getGoodsScore($TPL_V1["score"],$TPL_VAR["manager"],'write',$TPL_I1)?></td>
		</tr>
<?php }}?>
<?php }?>

<?php if($TPL_VAR["goodsreview_sub"]){?>
<?php if($TPL_goodsreview_sub_1){foreach($TPL_VAR["goodsreview_sub"] as $TPL_V1){?>
<?php if($TPL_V1["used"]=='Y'){?>
		<tr>
			<th><?php if($TPL_V1["required"]=='Y'){?><input type="hidden" name="required[]" value="<?php echo $TPL_V1["bulkorderform_seq"]?>"> <?php }?><?php echo $TPL_V1["label_title"]?></th>
			<td><?php echo $TPL_V1["label_view"]?> <?php echo $TPL_V1["label_desc"]?></td>
		</tr>
<?php }?>
<?php }}?>
<?php }?>

		<tr>
			<th>상품정보</th>
			<td>
				<button type="button" name="issueGoodsButton" id="issueGoodsButton" title="<?php echo $TPL_VAR["manager"]["name"]?>" class="resp_btn active mb10">상품 선택</button>
				<div id="displayGoods">
<?php if($TPL_displayGoods_1){foreach($TPL_VAR["displayGoods"] as $TPL_V1){?>
					<div class="goods">
						<img class="goodsThumbView" src="<?php echo $TPL_V1["image"]?>" onerror="this.src='/data/icon/error/noimage_list.gif'">
						<div class="goodsDescription">
							<a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo $TPL_V1["goods_name"]?></a>
							<p class="price"><?php echo ceil($TPL_V1["price"])?></p>
						</div>
						<input type="hidden" name="displayGoods[]" value="<?php echo $TPL_V1["goods_seq"]?>">
					</div>
<?php }}?>
				</div>
				<div id="displayGoodsSelect" class="hide"></div>
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
			<th>내용<?php echo $TPL_VAR["ismobile"]?></th>
			<td >
				<textarea name="contents" id="contents" class="daumeditor" style='width:95%; height:200px;'  class="required"><?php echo $TPL_VAR["contents"]?></textarea>
			</td>
		</tr>

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
<?php if($_GET["reply"]=='y'){?>
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

		$("button#issueGoodsButton").click(function(){
			set_goods_list("displayGoodsSelect","displayGoods");
		});

		$("button#issueGoodsButtonno").click(function(){
			openDialogAlert('구매자가 작성한 상품후기는 상품정보를 변경 할 수 없습니다.','430','140');
		});

		$("#best_select").click(function(){
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
				data: "mode=goods_review_best&board_id=<?php echo $_GET["id"]?>&best="+best+"&seq="+$(this).attr("seq"),
				success: function(result){}
			});
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
				name: { required:'<font color="red">작성자를 입력해 주세요.</font>'},
				category: { required:'<font color="red">분류를 선택해 주세요.</font>'},
				subject: { required:'문의를 입력해 주세요.'}
			},
			errorPlacement: function(error, element) {
				error.appendTo(element.parent());
			},
			submitHandler: function(f) {
				if(readyEditorForm(f)){ 
					if(!$("#subject").val() || $("#subject").val() == $("#subject").attr('title') ){
						alert('제목을 입력해 주세요.');
						return false;
					} 

					if($("#addcategory").val() == "newadd"){//신규분류
						if(!$("#newcategory").val() ) {
							alert('신규분류를 입력해 주세요.');
							$("#newcategory").focus();
							return false;
						}
					}

					if(!$("#contents").val() || $("#contents").val() == "<p>&nbsp;</p>" ){
						alert('답변을 입력해 주세요.');
						return false;
					}
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
</script>
<script src="/app/javascript/js/admin/gGoodsSelectList.js"></script>