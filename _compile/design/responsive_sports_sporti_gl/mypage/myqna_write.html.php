<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/mypage/myqna_write.html 000012945 */  $this->include_("sslAction");
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 나의 1:1 문의 Write @@
- 파일위치 : [스킨폴더]/mypage/myqna_write.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL215cGFnZS9teXFuYV93cml0ZS5odG1s" >나의 1:1 문의</span></h2>
		</div>

		<form name="writeform" id="writeform" method="post" action="<?php echo sslAction('../board_process')?>"  enctype="multipart/form-data" target="boardactionFrame">
			<input type="hidden" name="mode" id="mode" value="<?php echo $TPL_VAR["mode"]?>" />
			<input type="hidden" name="board_id" id="board_id" value="<?php echo $TPL_VAR["manager"]["id"]?>" />
			<input type="hidden" name="reply" id="reply" value="<?php echo $_GET["reply"]?>" />
<?php if($TPL_VAR["seq"]){?>
			<input type="hidden" name="seq" id="seq" value="<?php echo $TPL_VAR["seq"]?>" />
<?php }?>
			<input type="hidden" name="returnurl" id="returnurl" value="<?php if($TPL_VAR["backtype"]=='view'){?><?php echo $TPL_VAR["boardurl"]->view?><?php }else{?><?php echo $TPL_VAR["boardurl"]->lists?><?php }?>" />
			<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>" >
			<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>" >
			<input type="hidden" name="goods_seq" value="<?php echo $_GET["goods_seq"]?>" >
			<input type="hidden" name="backtype" value="list" >
<?php if($TPL_VAR["pw"]){?>
			<input type="hidden" name="oldpw" value="<?php echo $TPL_VAR["pw"]?>" >
<?php }?>

			<div class="table_top_line1"></div>
			<table id="boardDetailTable" class="table_row_a v2 Thc" width="100%" cellpadding="0" cellspacing="0">
			<colgroup><col class="size_b"><col></colgroup>
			<tbody>
<?php if($TPL_VAR["categorylist"]){?>
				<tr>
					<th><p>분류</p></th>
					<td>
						<select  name="category" id="addcategory">
							<option value="" selected="selected" >- 분류선택 -</option>
<?php if($TPL_categorylist_1){foreach($TPL_VAR["categorylist"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["datacategory"]==$TPL_V1||$TPL_VAR["datacategory"].' '==$TPL_V1){?> selected="selected"  <?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
						</select>
					</td>
				</tr>
<?php }?>
				<tr>
					<th><p>작성자</p></th>
					<td>
<?php if(defined('__ISUSER__')&&$TPL_VAR["name"]){?>
							<input type="hidden" name="name" id="name" value="<?php echo $TPL_VAR["name"]?>" >
							<input type="text" value="<?php echo $TPL_VAR["name"]?>" readonly="readonly" />
<?php }else{?>
							<input type="text" name="name" id="name" value="<?php echo $TPL_VAR["name"]?>"  title="작성자를 입력해 주세요" />
<?php }?>
						<span class="<?php echo $TPL_VAR["hiddenlay"]?>"><input type="checkbox" name="hidden" id="hidden"  value="1" <?php echo $TPL_VAR["hiddenckeck"]?> /><label for="hidden" > 비밀글</label></span>
						<?php echo $TPL_VAR["displayckeck"]?>

					</td>
				</tr>
<?php if(!$TPL_VAR["pw"]){?>
				<tr>
					<th><p>비밀번호</p></th>
					<td>
						<input type="password" name="pw" id="pw" value=""  password="password"  title="비밀번호 입력" />
					</td>
				</tr>
<?php }?>
				<tr>
					<th><p>답변받기</p></th>
					<td>
						<ul class="form_multi_row2">
<?php if($TPL_VAR["manager"]["sms_reply_user_yn"]=='Y'){?>
							<li>
								<input type="text" name="tel1" id="tel1" value="<?php if($TPL_VAR["tel2"]){?><?php echo $TPL_VAR["tel2"]?><?php }elseif($TPL_VAR["tel1"]){?><?php echo $TPL_VAR["tel1"]?><?php }?>" class="size_mail" readonly="readonly" title="휴대폰번호 입력(-포함)" />
								<label class="Dib"><input type="checkbox" name="board_sms" id="board_sms" value="1" <?php if(($TPL_VAR["seq"]&&$TPL_VAR["rsms"]=='Y')||(!$TPL_VAR["seq"]&&($TPL_VAR["tel1"]||$TPL_VAR["tel2"]))){?> checked="checked" <?php }?> /> SMS받기</label>
							</li>
<?php }?>
							<li>
								<input type="text" name="email" id="email" value="<?php echo $TPL_VAR["email"]?>" class="size_mail" title="이메일주소를 입력" />
								<label class="Dib"><input type="checkbox" name="board_email" id="board_email" value="1"  <?php if(($TPL_VAR["seq"]&&$TPL_VAR["remail"]=='Y')||(!$TPL_VAR["seq"]&&$TPL_VAR["email"])){?> checked="checked" <?php }?>/> 메일받기</label>
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th><p>제목</p></th>
					<td>
						<input type="text" name="subject" id="subject" value="<?php echo $TPL_VAR["subject"]?>" class="Wmax"  title="제목을 입력해 주세요" />
					</td>
				</tr>
			</tbody>
			</table>

			<textarea name="contents" id="contents" class="size3 Mt10" title="내용을 입력하세요" ><?php echo $TPL_VAR["contents"]?></textarea>

<?php if(($TPL_VAR["manager"]["file_use"]=='Y'||$TPL_VAR["filelist"])){?>
			 <div class="bbswrite_division">
				<!-- 게시판 파일첨부. 파일위치 : [스킨폴더]/board/_mobile_file.html -->
<?php $this->print_("mobile_file",$TPL_SCP,1);?>

				<!-- //게시판 파일첨부 -->
			</div>
<?php }?>

			<div class="board_detail_btns2">
				<button type="button" class="data_save_btn btn_resp size_c color2">저장</button>
				<button type="button" class="btn_resp size_c" onclick="<?php if($_GET["popup"]&&!$_GET["iframe"]){?>self.close();<?php }else{?>document.location.href='<?php echo $TPL_VAR["boardurl"]->lists?>';<?php }?>">취소</button>
			</div>
		</form>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_sports_sporti_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->


<div id="openDialogLayer" style="display: none">
	<div align="center" id="openDialogLayerMsg"></div>
</div>

<script type="text/javascript">
//<![CDATA[
var board_id = '<?php echo $TPL_VAR["manager"]["id"]?>';
var board_seq = '<?php echo $_GET["seq"]?>';
var boardlistsurl = '<?php echo $TPL_VAR["boardurl"]->lists?>';
var boardwriteurl = '<?php echo $TPL_VAR["boardurl"]->write?>';
var boardviewurl = '<?php echo $TPL_VAR["boardurl"]->view?>';
var boardmodifyurl = '<?php echo $TPL_VAR["boardurl"]->modify?>';
var file_use = '<?php echo $TPL_VAR["manager"]["file_use"]?>';
//]]>
</script>
<script type="text/javascript" src="/app/javascript/js/board.js?v=20200513"  charset="utf-8"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="utf-8"></script>
<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"  charset="utf-8"></script>

<iframe name="boardactionFrame" src="" frameborder="0" width="0" height="0"></iframe>

<script type="text/javascript">
//<![CDATA[

function set_goods_list(displayId,inputGoods) {
	$.ajax({
		type: "get",
		url: "/goods/user_select",
		data: "page=1&goods_review=1&inputGoods="+inputGoods+"&displayId="+displayId,
		success: function(result){
			$("div#"+displayId).html(result);
		}
	});

<?php if($_GET["popup"]){?>
	//상품 검색
	openDialog(getAlert('mp168'), displayId, {"width":"300","height":"300","show" : "fade","hide" : "fade"});
<?php }else{?>
	openDialog(getAlert('mp168'), displayId, {"width":"300","height":"300","show" : "fade","hide" : "fade"});
<?php }?>
}
//
function goodslistclose(displayId, goods_seq) {
	$("div#"+displayId).dialog('close');
}

$(document).ready(function() {

	$("button#issueGoodsButton").live("click",function(){
		set_goods_list("displayGoodsSelect","displayGoods");
	});

	EditorJSLoader.ready(function(Editor) {
		DaumEditorLoader.init(".daumeditor");
	});

	$("#backtype2").click(function() {
		$("#returnurl").val('<?php echo $TPL_VAR["boardurl"]->view?>');
	});

	$("#backtype1").click(function() {
		$("#returnurl").val('<?php echo $TPL_VAR["boardurl"]->lists?>');
	});

	// 게시글저장
	$('.data_save_btn').click(function() {
		// 2018-06-07 byuncs 수정시 파일이 포함 되어 있는 경우 체크..
		checkAttachImage();

		// 180912 - sjg 폼 수정에서 "분류선택" 미선택시 submit 되는 오류 개선
		if ( $("#addcategory").val() ) {
			$("#writeform").submit();
		} else {
			alert('분류를 선택하시기 바랍니다.');
			$("#addcategory").focus();
		}
	});

	$('#writeform').validate({
		onkeyup: false,
		rules: {
			subject: {required:true},
<?php if(!defined('__ISUSER__')){?>
			agree:{required:true},
<?php }?>
		},
		messages: {
			name: { required:getAlert('mp113')}, //<font color="red">작성자를 입력해 주세요.</font>
			category: { required:getAlert('mp114')}, //<font color="red">분류를 선택해 주세요.</font>
<?php if(!defined('__ISUSER__')){?>
			agree:{required:getAlert('mp169')}, //<font color="red"><b>개인정보 수집ㆍ이용에 동의해 주세요.</b></font>
<?php }?>
			subject: { required:getAlert('mp115')} //<font color="red">제목을 입력해 주세요.</font>
		},
		errorClass: "input_round_style_rounded",
		validClass: "input_round_style", 
		highlight: function(element, errorClass, validClass) {
			$(element).parent().addClass(errorClass);
			$(element).parent().removeClass(validClass);
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parent().removeClass(errorClass);
			$(element).parent().addClass(validClass);
		},
		errorPlacement: function(error, element) {
			setDefaultText(); 
		},
		submitHandler: function(f) {
			//if(readyEditorForm(f)){
<?php if($TPL_VAR["categorylist"]){?>
					if( !$("#addcategory").val()){ 
						setDefaultText();
						alert(getAlert('mp116')); //분류를 선택해 주세요.
						$("#addcategory").focus();
						submitFlag = false;
						return false; 
					}
<?php }?>

				var bcontents = $("#writeform").find("#contents").val();
				if(!bcontents || bcontents.toLowerCase() == "<p>&nbsp;</p>"  || bcontents.toLowerCase() == "<p><br></p>" ){
					setDefaultText();
					alert(getAlert('mp117')); //내용을 입력해 주세요.
					$("#contents").focus();
					return false;
				}

				loadingstartsubmit();

				if (submitFlag == true)
				{
				//게시물을 등록하고 있습니다. 잠시만 기다려 주세요.
				 alert(getAlert('mp118'));
				 return false;
				}   
				submitFlag = true;
				f.submit();
			//}
		}
	});

});

<?php if(($TPL_VAR["manager"]["file_use"]=='Y'||$TPL_VAR["filelist"])&&!$TPL_VAR["ismobile"]){?>
function readfilelistNew(attachments){
<?php if($TPL_VAR["filelist"]){?>
attachments['image'] = [];
attachments['file'] = [];
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
	var  filePath = '<?php echo $TPL_V1["realfiledir"]?>';
	var  filePathurl = '<?php echo $TPL_V1["realfileurl"]?>';
<?php if($TPL_VAR["realthumbfile"]){?>
		var  realthumbfile = '<?php echo $TPL_V1["realthumbfiledir"]?>';
		var  thumbfilePathurl = '//<?php echo $_SERVER["HTTP_HOST"]?><?php echo $TPL_V1["realthumbfileurl"]?>';
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
}
<?php }?>
//]]>
</script>