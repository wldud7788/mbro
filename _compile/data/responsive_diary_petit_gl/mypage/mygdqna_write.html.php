<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/mygdqna_write.html 000020250 */  $this->include_("sslAction");
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_displayGoods_1=empty($TPL_VAR["displayGoods"])||!is_array($TPL_VAR["displayGoods"])?0:count($TPL_VAR["displayGoods"]);
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 나의 상품 문의 Write @@
- 파일위치 : [스킨폴더]/mypage/mygdqna_write.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)">MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvbXlnZHFuYV93cml0ZS5odG1s" >나의 상품 문의</span></h2>
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
								<input type="text" name="tel1" id="tel1" value="<?php if($TPL_VAR["tel2"]){?><?php echo $TPL_VAR["tel2"]?><?php }elseif($TPL_VAR["tel1"]){?><?php echo $TPL_VAR["tel1"]?><?php }?>" class="size_mail" title="휴대폰번호 입력(-포함)" />
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
					<th><p>문의상품</p></th>
					<td>
						<!-- 상품선택 & 선택된 상품 -->
						<div class="board_goods_select">
<?php if(!$TPL_VAR["seq"]){?>
							<div class="btn_area">
								<button type="button" id="issueGoodsButton" class="btn_resp size_b color2">상품 선택 </button>
							</div>
<?php }?>
							<div id="displayGoods" class="board_goods_select_display">
<?php if($TPL_displayGoods_1){foreach($TPL_VAR["displayGoods"] as $TPL_V1){?>
								<div class="goods_loop_area">
									<ul class="goods_area">
										<li class="img_area"><img src="<?php echo $TPL_V1["image"]?>" class="goodsThumbView goods_img" alt=""></li>
										<li class="info_area">
											<div class="name"><?php echo $TPL_V1["goods_name"]?></div>
											<div class="price"><?php echo number_format($TPL_V1["price"])?></div>
										</li>
									</ul>
									<input type='hidden' name='displayGoods[]' value='<?php echo $TPL_V1["goods_seq"]?>' />
								</div>
<?php }}?>
							</div>
						</div>

						<!-- 동영상 사용인 경우( 반응형 1차에서 작업 제외 ) -->
<?php if($TPL_VAR["manager"]["video_use"]=='Y'){?>
						<div class="bbswrite_division">
							<div class="bbswrite_division" style="margin-top:6px; margin-bottom:6px; border-top:1px dashed #ddd; border-bottom:1px dashed #ddd;">
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
							</div>
							<div style="height:6px;"></div>
<?php }elseif($TPL_VAR["file_key_i"]&&$TPL_VAR["uccdomain_fileurl"]){?>
							<div class="bbswrite_division" style="margin-top:6px; margin-bottom:6px; border-top:1px dashed #ddd; border-bottom:1px dashed #ddd;">
							<label ><input type="checkbox" name="video_del" value="1" >삭제</label>
							<div>
								<iframe   width="100" height="100" src="<?php echo $TPL_VAR["uccdomain_fileurl"]?>&g=tag&width=<?php echo $TPL_VAR["manager"]["video_size_mobile0"]?>&height=<?php echo $TPL_VAR["manager"]["video_size_mobile1"]?>" frameborder="0" allowfullscreen></iframe>
							</div>

							<div style="height:6px;"></div>
<?php }elseif($TPL_VAR["file_key_w"]&&$TPL_VAR["uccdomain_fileurl"]){?>
								<div class="bbswrite_division" style="margin-top:6px; margin-bottom:6px; border-top:1px dashed #ddd; border-bottom:1px dashed #ddd;">
								<label ><input type="checkbox" name="video_del" value="1" >삭제</label>
								<div>
									<iframe width="100" height="100" src="<?php echo $TPL_VAR["uccdomain_fileurl"]?>&g=tag&width=<?php echo $TPL_VAR["manager"]["video_size_mobile0"]?>&height=<?php echo $TPL_VAR["manager"]["video_size_mobile1"]?>" frameborder="0" allowfullscreen></iframe>
								</div>
							</div>
							<div style="height:6px;"></div>
						</div>
<?php }?>
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

<?php if(!$TPL_VAR["seq"]&&$TPL_VAR["manager"]["content_default"]){?>
<?php if($TPL_VAR["contents"]){?>
				<div class="Pt10">
					<?php echo nl2br($TPL_VAR["contents"])?>

				</div>
<?php }?>
				<textarea name="contents" id="contents" class="size3 Mt10" <?php if(!$TPL_VAR["contents"]){?>title="내용을 입력하세요"<?php }?>></textarea>
<?php }else{?>
				<textarea name="contents" id="contents" class="size3 Mt10"><?php echo $TPL_VAR["contents"]?></textarea>
<?php }?>

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

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->

<!-- 상품 선택/검색 레이어 -->
<div id="displayGoodsSelect" class="resp_layer_pop hide">
	<h4 class="title">상품 검색</h4>
	<div class="y_scroll_auto">
		<div class="layer_pop_contents v3">
		</div>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>


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

<iframe name="boardactionFrame" src="" frameborder="0" width="0" height="0" class="hide"></iframe>




<!-- 주문검색 폼 선택상품정보 -->
<div id="displayOrderlay" class="hide"></div>
<input type="hidden"  id="order_goods_list" value="<?php if($_GET["goods_seq"]){?><?php echo $_GET["goods_seq"]?><?php }else{?><?php echo $TPL_VAR["goods_seq"]?><?php }?>" >

<script type="text/javascript">
//<![CDATA[

function set_goods_list(displayId,inputGoods) {
<?php if(!defined('__ISUSER__')){?>
		$("#orderbtnlay").show();
		$("#nonemblay").hide();
<?php }?>

	var sheight = $('body').prop("scrollHeight");

	$.ajax({
		type: "get",
		url: "/goods/user_select",
		data: "page=1&goods_review=1&order_seq=<?php echo $_GET["order_seq"]?>&inputGoods="+inputGoods+"&displayId="+displayId,
		success: function(result){
			$("#" + displayId + " .layer_pop_contents").html(result);
			//상품 검색
			showCenterLayer('#' + displayId);
			//openDialogModal(displayId+'Dialog',getAlert('et045'),'',displayId);
		}
	});

/*
<?php if($_GET["popup"]){?>
	openDialog("상품 검색", displayId, {"width":"400","height":"700","show" : "fade","hide" : "fade"});
<?php }else{?>
	openDialog("상품 검색", displayId, {"width":"500","height":"700","show" : "fade","hide" : "fade"});
<?php }?>
*/
}

//비회원 상품조회 새창 >> 검색완료후 처리함부
function goodslistclose(displayId, goods_seq) {
	closeDialogAll(displayId+'Dialog');
	//$("div#"+displayId).dialog('close');
	$("#ordergoodslist").empty();//초기화
	$("#order_goods_list").val(goods_seq);
<?php if(defined('__ISUSER__')){?>
		goods_review_order_load(goods_seq, '', '');
<?php }?>
}

//주문조회 새창 >> 검색완료후 처리함수
function gdordersearch() {
	var goods_seq = $("#order_goods_list").val();
	if(!goods_seq){
		//상품을 먼저 선택해 주세요.
		alert(getAlert('et046'));
		return false;
	}
	$("#orderbtnlay").hide();
	$("#nonemblay").show();
	goods_review_order_load(goods_seq, '', '');
}

$(document).ready(function() {
	$("#OrderauthButton").live("click", function(){
		var goodsseq = $("#order_goods_list").val();
		if(!goodsseq){
			//상품을 먼저 선택해 주세요.
			alert(getAlert('et046'));
			return false;
		}
<?php if($_SERVER["HTTPS"]=='on'){?>
			var openurl = 'https://<?php echo $_SERVER["HTTP_HOST"]?>'
<?php }else{?>
			var openurl = 'http://<?php echo $_SERVER["HTTP_HOST"]?>'
<?php }?>
		window.open(openurl + '/member/login?order_auth=1&goodsseq='+goodsseq+'&popup=1&return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?><?php echo urlencode('&goodsseq=')?>'+goodsseq,'goodrevieworder','width=700px,height=900px,statusbar=no,scrollbars=auto,toolbar=no');
	});


	$("#issueGoodsButton").live("click",function(){
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
		$("#writeform").submit();
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
			//<font color="red">작성자를 입력해 주세요.</font>
			name: { required:getAlert('et039')},
			//<font color="red">분류를 선택해 주세요.</font>
			category: { required:getAlert('et040')},
<?php if($TPL_VAR["manager"]["autowrite_use"]=='Y'&&!defined('__ISUSER__')){?>
			//<font color="red">스팸방지 코드를 입력해 주세요.</font>
			captcha_code: { required:getAlert('et047')},
<?php }?>
<?php if(!defined('__ISUSER__')){?>
			//<font color="red">비밀번호를 입력해 주세요.</font>
			pw: { required:getAlert('et048')},
			//<font color="red"><b>개인정보 수집ㆍ이용에 동의해 주세요.</b></font>
			agree:{required:getAlert('et049')},
<?php }?>
			//'<font color="red">제목을 입력해 주세요.</font>'
			subject: { required:getAlert('et041')}
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

<?php if($TPL_VAR["categorylist"]){?>
					if( !$("#addcategory").val()){ 
						setDefaultText();
						//분류를 선택해 주세요.
						alert(getAlert('et042'));
						$("#addcategory").focus();
						return false; 
					}
<?php }?>


				var bcontents = $("#writeform").find("#contents").val();
				if(!bcontents || bcontents.toLowerCase() == "<p>&nbsp;</p>"  || bcontents.toLowerCase() == "<p><br></p>" ){
					setDefaultText();
					//내용을 입력해 주세요.
					alert(getAlert('et043'));
					$("#contents").focus();
					return false;
				}

				loadingstartsubmit();
				

				if (submitFlag == true)
				{
					//게시물을 등록하고 있습니다. 잠시만 기다려 주세요.
					alert(getAlert('et044'));
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