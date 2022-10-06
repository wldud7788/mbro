<?php /* Template_ 2.2.6 2021/05/21 17:54:49 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/board/freeboard/default01/write.html 000014322 */  $this->include_("sslAction");
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 사용자 생성 "리스트형" 게시판 - Write @@
- 파일위치 : [스킨폴더]/board/게시판아이디/default01/write.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if(!$_GET["iframe"]){?><?php }?>

<form name="writeform" id="writeform" method="post" action="<?php echo sslAction('../board_process')?>"   <?php if(($TPL_VAR["manager"]["file_use"]=='Y'||$TPL_VAR["filelist"])){?> enctype="multipart/form-data" <?php }?>  target="boardactionFrame">
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
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["datacategory"]==$TPL_V1){?> selected="selected"  <?php }?>><?php echo $TPL_V1?></option>
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
				<span class="<?php echo $TPL_VAR["hiddenlay"]?>" ><input type="checkbox" name="hidden" id="hidden"  value="1" <?php echo $TPL_VAR["hiddenckeck"]?> /><label for="hidden" > 비밀글</label></span>
				<?php echo $TPL_VAR["displayckeck"]?>

			</td>
		</tr>
<?php if(!$TPL_VAR["pw"]){?>
		<tr>
			<th><p>비밀번호</p></th>
			<td>
				<input type="password" name="pw" id="pw" value="" password="password"  title="비밀번호 입력" />
			</td>
		</tr>
<?php }?>
		<tr>
			<th><p>제목</p></th>
			<td>
				<input type="text" name="subject" id="subject" value="<?php echo $TPL_VAR["subject"]?>" class="Wmax" title="제목을 입력해 주세요" />
			</td>
		</tr>
	</tbody>
	</table>

	<!-- 동영상 사용인 경우( 반응형 1차에서 작업 제외 ) -->
<?php if($TPL_VAR["manager"]["video_use"]=='Y'){?>
	<div class="Mt10">
		<span style="width:100%;"><!-- 동영상<br /> -->
		<table width="50%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center">
				<div id="boardVideolay" >
<?php if($TPL_VAR["file_key_i"]&&$TPL_VAR["uccdomain_fileurl"]){?>
					<label ><input type="checkbox" name="video_del" value="1" >삭제</label>
					<div class="content" >
						<iframe   width="100" height="100" src="<?php echo $TPL_VAR["uccdomain_fileurl"]?>&g=tag&width=<?php echo $TPL_VAR["manager"]["video_size_mobile0"]?>&height=<?php echo $TPL_VAR["manager"]["video_size_mobile1"]?>" frameborder="0" allowfullscreen></iframe>
					</div>
<?php }elseif($TPL_VAR["file_key_w"]&&$TPL_VAR["uccdomain_fileurl"]){?>
					<label ><input type="checkbox" name="video_del" value="1" >삭제</label>
					<div class="content" >
						<iframe   width="100" height="100" src="<?php echo $TPL_VAR["uccdomain_fileurl"]?>&g=tag&width=<?php echo $TPL_VAR["manager"]["video_size_mobile0"]?>&height=<?php echo $TPL_VAR["manager"]["video_size_mobile1"]?>" frameborder="0" allowfullscreen></iframe>
					</div>
<?php }?>
				</div>
			</td>
			<td  ><button type="button" class="batchVideoRegist btn_style" board_seq="<?php echo $TPL_VAR["seq"]?>" >동영상등록</button></td>
		</tr>
		</table>
		</span>
		<div style="height:6px;"></div>
<?php }elseif($TPL_VAR["file_key_i"]&&$TPL_VAR["uccdomain_fileurl"]){?>
		<span style="width:100%;"><!-- 동영상<br /> -->
		<label ><input type="checkbox" name="video_del" value="1" >삭제</label>
		<div>
			<iframe   width="100" height="100" src="<?php echo $TPL_VAR["uccdomain_fileurl"]?>&g=tag&width=<?php echo $TPL_VAR["manager"]["video_size_mobile0"]?>&height=<?php echo $TPL_VAR["manager"]["video_size_mobile1"]?>" frameborder="0" allowfullscreen></iframe>
		</div>
		</span>

		<div style="height:6px;"></div>
<?php }elseif($TPL_VAR["file_key_w"]&&$TPL_VAR["uccdomain_fileurl"]){?>
		<span style="width:100%;">동영상<br />
		<label ><input type="checkbox" name="video_del" value="1" >삭제</label>
		<div>
			<iframe width="100" height="100" src="<?php echo $TPL_VAR["uccdomain_fileurl"]?>&g=tag&width=<?php echo $TPL_VAR["manager"]["video_size_mobile0"]?>&height=<?php echo $TPL_VAR["manager"]["video_size_mobile1"]?>" frameborder="0" allowfullscreen></iframe>
		</div>
		</span>

		<div style="height:6px;"></div>
	</div>
<?php }?>

	<textarea name="contents" id="contents" class="size3 Mt10" title="내용을 입력하세요" ><?php echo $TPL_VAR["contents"]?></textarea>

<?php if(($TPL_VAR["manager"]["file_use"]=='Y'||$TPL_VAR["filelist"])){?>
	 <div class="bbswrite_division"><?php $this->print_("mobile_file",$TPL_SCP,1);?></div>
<?php }?>

<?php if($TPL_VAR["manager"]["autowrite_use"]=='Y'&&!defined('__ISUSER__')){?>
	<div>
<?php $this->print_("securimage",$TPL_SCP,1);?>

	</div>
<?php }?>

	<div class="board_detail_btns2">
<?php if(!defined('__ISUSER__')){?>
		<div class="L Pb20">
			<label class="Dib Pt5 gray_01"><input type="radio" name="agree" value="Y" /> 개인정보 수집ㆍ이용에 동의합니다.</label> &nbsp; &nbsp;
			<label class="Dib Pt5 gray_05"><input type="radio" name="agree" value="N" checked /> 개인정보 수집ㆍ이용에 동의하지 않습니다.</label>
			<textarea class="cs_policy_textarea Mt10" readonly><?php echo $TPL_VAR["policy"]?></textarea>
		</div>
<?php }?>

		<button type="button" class="data_save_btn btn_resp size_c color2">저장</button>
		<button type="button" class="btn_resp size_c" onclick="<?php if($_GET["popup"]&&!$_GET["iframe"]){?>self.close();<?php }else{?>document.location.href='<?php echo $TPL_VAR["boardurl"]->lists?>';<?php }?>">취소</button>
	</div>

</form>

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
<iframe name="boardactionFrame" src="" frameborder="0" width="0" height="0" class="hide"></iframe>

<!-- 주문검색 폼 선택상품정보 -->
<div id="displayOrderlay" class="hide"></div>
<input type="hidden"  id="order_goods_list" value="<?php if($_GET["goods_seq"]){?><?php echo $_GET["goods_seq"]?><?php }else{?><?php echo $TPL_VAR["goods_seq"]?><?php }?>" >


<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
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
		// 181008 - sjg 비회원 개인정보 미동의시 submit 되는 오류
<?php if(!defined('__ISUSER__')){?>
			if ( $("input[name=agree]:checked").val() == 'Y' ) {
				$("#writeform").submit();
			} else {
				alert( '개인정보 수집ㆍ이용에 동의해야 합니다.' );
				return false;
			}
<?php }else{?>
			$("#writeform").submit();
<?php }?>
	});

	$('#writeform').validate({
		onkeyup: false,
		rules: {
			subject: {required:true},
<?php if($TPL_VAR["manager"]["autowrite_use"]=='Y'&&!defined('__ISUSER__')){?>
			captcha_code:{required:true},
<?php }?>
<?php if(!defined('__ISUSER__')){?>
			pw:{required:true},
			agree:{required:true},
<?php }?>
		},
		messages: {
			name: { required:getAlert('et369')}, //<font color="red">작성자를 입력해 주세요.</font>
			category: { required:getAlert('et370')}, //<font color="red">분류를 선택해 주세요.</font>
<?php if($TPL_VAR["manager"]["autowrite_use"]=='Y'&&!defined('__ISUSER__')){?>
			captcha_code: { required:getAlert('et371')}, //<font color="red">스팸방지 코드를 입력해 주세요.</font>
<?php }?>
<?php if(!defined('__ISUSER__')){?>
			pw: { required:getAlert('et372')}, //<font color="red">비밀번호를 입력해 주세요.</font>
			agree:{required:getAlert('et373')}, //<font color="red"><b>개인정보 수집ㆍ이용에 동의해 주세요.</b></font>
<?php }?>
			subject: { required:getAlert('et374')} //<font color="red">제목을 입력해 주세요.</font>
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
		},errorPlacement: function(error, element) {
			setDefaultText(); 
		},
		submitHandler: function(f) {
			//if(readyEditorForm(f)){

<?php if(!defined('__ISUSER__')){?>
					if($("input[name='agree']:checked").val()!='Y'){						
						setDefaultText();
						alert(getAlert('et375')); //개인정보 수집ㆍ이용에 동의하셔야 합니다.
						$("input[name='agree']").focus();
						return false;
					}
<?php }?>

<?php if($TPL_VAR["categorylist"]){?>
					if( !$("#addcategory").val()){ 
						setDefaultText();
						//신규분류를 입력해 주세요.
						alert(getAlert('et376'));
						$("#addcategory").focus();
						return false; 
					}
<?php }?>

				var bcontents = $("#writeform").find("#contents").val();
				if(!bcontents || bcontents.toLowerCase() == "<p>&nbsp;</p>"  || bcontents.toLowerCase() == "<p><br></p>" ){
					setDefaultText();
					//내용을 입력해 주세요.
					alert(getAlert('et377'));
					$("#contents").focus();
					return false;
				}
				loadingstartsubmit();
				

				if (submitFlag == true)
				{
				//게시물을 등록하고 있습니다. 잠시만 기다려 주세요.
				 alert(getAlert('et378'));
				 return false;
				}   
				submitFlag = true;
				f.submit();
			//}
		}
	});

iframeset();
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
}
<?php }?>
//]]>
</script>

<script type="text/javascript">
$(document).ready(function(){
	$(document).resize(function(){
	  $('#'+board_id+'_frame',parent.document).height($('#boardlayout').height()+200);
	 }).resize();
});
function iframeset(){
	  $('#'+board_id+'_frame',parent.document).height($('#boardlayout').height()+200);
}
</script>