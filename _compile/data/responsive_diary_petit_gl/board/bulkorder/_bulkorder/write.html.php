<?php /* Template_ 2.2.6 2020/10/15 17:39:14 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/board/bulkorder/_bulkorder/write.html 000021693 */  $this->include_("sslAction");
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_bulkorder_sub_1=empty($TPL_VAR["bulkorder_sub"])||!is_array($TPL_VAR["bulkorder_sub"])?0:count($TPL_VAR["bulkorder_sub"]);
$TPL_displayGoods_1=empty($TPL_VAR["displayGoods"])||!is_array($TPL_VAR["displayGoods"])?0:count($TPL_VAR["displayGoods"]);
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 대량구매 Write @@
- 파일위치 : [스킨폴더]/board/bulkorder/_bulkorder/write.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<form name="writeform" id="writeform" method="post" action="<?php echo sslAction('../board_process')?>"  enctype="multipart/form-data" target="actionFrame">
	<input type="hidden" name="mode" id="mode" value="<?php echo $TPL_VAR["mode"]?>" />
	<input type="hidden" name="board_id" id="board_id" value="<?php echo $_GET["id"]?>" />
	<input type="hidden" name="reply" id="reply" value="<?php echo $_GET["reply"]?>" />
<?php if($TPL_VAR["seq"]){?>
		<input type="hidden" name="seq" id="seq" value="<?php echo $TPL_VAR["seq"]?>" />
<?php }?>
	<input type="hidden" name="returnurl" id="returnurl" value="<?php if($TPL_VAR["backtype"]=='view'){?><?php echo $TPL_VAR["boardurl"]->view?><?php }else{?><?php echo $TPL_VAR["boardurl"]->lists?><?php }?>" />
	<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>" >
	<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>" >
	<input type="hidden" name="goods_seq" value="<?php echo $_GET["goods_seq"]?>" >
<?php if($TPL_VAR["pw"]){?>
	<input type="hidden" name="oldpw" value="<?php echo $TPL_VAR["pw"]?>" />
<?php }?>


	<div class="resp_bulk_table">
		<ul>
			<li class="th"><p designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >문의등록자</p></li>
			<li class="td">
<?php if(defined('__ISUSER__')&&$TPL_VAR["name"]){?>
					<input type="hidden" name="name" id="name" value="<?php echo $TPL_VAR["name"]?>" >
					<input type="text" value="<?php echo $TPL_VAR["name"]?>"  readonly="readonly" />
<?php }else{?>
					<input type="text" name="name" id="name" value="<?php echo $TPL_VAR["name"]?>"  title="문의등록자를 입력해 주세요" class="required line" />
<?php }?>
				<span class="<?php echo $TPL_VAR["hiddenlay"]?>"><input type="checkbox" name="hidden" id="hidden"  value="1" <?php echo $TPL_VAR["hiddenckeck"]?> /><label for="hidden" > 비밀글</label></span>
				<?php echo $TPL_VAR["displayckeck"]?>

			</li>
		</ul>
<?php if(!$TPL_VAR["pw"]){?>
		<ul>
			<li class="th"><p designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >비밀번호</p></li>
			<li class="td">
				<input type="password" name="pw" id="pw" value=""  title="비밀번호를 입력해 주세요"  password="password" />
			</li>
		</ul>
<?php }?>
<?php if($TPL_VAR["categorylist"]){?>
		<ul class="required">
			<li class="th"><p designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >분류</p></li>
			<li class="td">
				<select  name="category" id="addcategory">
					<option value="" selected="selected" >- 분류선택 -</option>
<?php if($TPL_categorylist_1){foreach($TPL_VAR["categorylist"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["datacategory"]==$TPL_V1){?> selected="selected"  <?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</li>
		</ul>
<?php }?>

<?php if($TPL_VAR["bulkorder_sub"]){?>
<?php if($TPL_bulkorder_sub_1){foreach($TPL_VAR["bulkorder_sub"] as $TPL_V1){?>
<?php if($TPL_V1["used"]=='Y'){?>
		<ul <?php if($TPL_V1["required"]=='Y'){?>class="required"<?php }?>>
			<li class="th"><p><?php echo $TPL_V1["label_title"]?></p></li>
			<li class="td custom_form">
<?php if($TPL_V1["required"]=='Y'){?><input type="hidden" name="required[]" value="<?php echo $TPL_V1["bulkorderform_seq"]?>" /><?php }?>
<?php if($TPL_V1["label_desc"]){?><p class="desc pd_3"><?php echo $TPL_V1["label_desc"]?></p><?php }?>
				<?php echo $TPL_V1["label_view"]?>

			</li>
		</ul>
<?php }?>
<?php }}?>
<?php }?>
		
<?php if(strstr($TPL_VAR["manager"]["bulk_show"],'[goods]')){?>
		<ul>
			<li class="th"><p designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >(희망)구매요청상품</p></li>
			<li class="td">
<?php if(!$_GET["goods_seq"]){?><button type="button" id="issueGoodsButton" class="btn_resp size_b color2"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >상품 선택</span></button>&nbsp;<?php }?>
				<span class="Dib desc pd_2" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >* 상품을 선택하신 후 옵션명과 수량을 아래 입력칸에 입력하세요</span>
				<div id="displayGoods" class="board_goods_select_display v3">
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
						<textarea name='displayGoods_cont[]'  title='옵션과 수량정보를 입력해 주세요.' /><?php echo $TPL_V1["goods_cont"]?></textarea>
					</div>
<?php }}?>
				</div>
			</li>
		</ul>
<?php }?>
<?php if(strstr($TPL_VAR["manager"]["bulk_show"],'[goods]')&&$TPL_VAR["manager"]["bulk_totprice"]){?>
		<ul>
			<li class="th"><p designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >요청금액</p></li>
			<li class="td">
				<input type="text" name="total_price" id="total_price" value="<?php if($TPL_VAR["total_price"]> 0){?><?php echo $TPL_VAR["total_price"]?><?php }?>" title="희망 구매가격 입력" /> <span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >원</span>
			</li>
		</ul>
<?php }?>
<?php if(strstr($TPL_VAR["manager"]["bulk_show"],'[payment]')){?>
		<ul>
			<li class="th"><p designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >(희망)결제수단</p></li>
			<li class="td label_group2">
				<label><input type="radio" name="payment" value="bank" checked="checked" /> <span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >무통장</span></label>
<?php if($TPL_VAR["manager"]["bulk_payment_type"]=='all'){?>
<?php if($TPL_VAR["payment"]["card"]){?>
					<label><input type="radio" name="payment" value="card" <?php if($TPL_VAR["payment"]=='card'){?>checked="checked"<?php }?> /> <span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >카드결제</span></label>
<?php }?>
<?php if($TPL_VAR["payment"]["account"]){?>
					<label><input type="radio" name="payment" value="account" <?php if($TPL_VAR["payment"]=='account'){?>checked="checked"<?php }?> /> <span designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >실시간계좌이체</span></label>
<?php }?>
<?php if($TPL_VAR["payment"]["cellphone"]){?>
					<label><input type="radio" name="payment" value="cellphone" <?php if($TPL_VAR["payment"]=='cellphone'){?>checked="checked"<?php }?> /> <span designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >핸드폰결제</span></label>
<?php }?>
<?php if($TPL_VAR["payment"]["virtual"]){?>
					<label><input type="radio" name="payment" value="virtual" <?php if($TPL_VAR["payment"]=='virtual'){?>checked="checked"<?php }?> /> <span designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >가상계좌</span></label>
<?php }?>
<?php }?>
			</li>
		</ul>
<?php }?>
<?php if(strstr($TPL_VAR["manager"]["bulk_show"],'[typereceipt]')){?>
		<ul>
			<li class="th"><p designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >(희망)매출증빙자료</p></li>
			<li class="td label_group2">
				<label><input type="radio" name="typereceipt" id="typereceipt0" value="0" checked="checked"> <span designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >발급안함</span></label>
<?php if($TPL_VAR["cfg"]["order"]["cashreceiptuse"]> 0){?>
				<label><input type="radio" name="typereceipt" id="typereceipt2" value="2" <?php if($TPL_VAR["typereceipt"]== 2){?>checked="checked"<?php }?>> <span designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >현금영수증</span></label>
<?php }?>
<?php if($TPL_VAR["cfg"]["order"]["taxuse"]> 0){?>
				<label><input type="radio" name="typereceipt" id="typereceipt1" value="1" <?php if($TPL_VAR["typereceipt"]== 1){?>checked="checked"<?php }?>> <span designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >세금계산서</span></label>
<?php }?>
			</li>
		</ul>
<?php }?>
		<ul>
			<li class="th"><p designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >답변받기</p></li>
			<li class="td">
				<ul class="form_multi_row2">
<?php if($TPL_VAR["manager"]["sms_reply_user_yn"]=='Y'){?>
					<li>
						<input type="text" name="tel1" id="tel1" value="<?php if($TPL_VAR["tel2"]){?><?php echo $TPL_VAR["tel2"]?><?php }elseif($TPL_VAR["tel1"]){?><?php echo $TPL_VAR["tel1"]?><?php }?>" class="size_mail" title="휴대폰번호 입력(-포함)" />
						<label class="Dib"><input type="checkbox" name="board_sms" id="board_sms" value="1" <?php if(($TPL_VAR["seq"]&&$TPL_VAR["rsms"]=='Y')||(!$TPL_VAR["seq"]&&($TPL_VAR["tel1"]||$TPL_VAR["tel2"]))){?> checked="checked" <?php }?> /> <span designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >SMS받기</span></label>
					</li>
<?php }?>
					<li>
						<input type="text" name="email" id="email" value="<?php echo $TPL_VAR["email"]?>" class="size_mail" title="이메일주소 입력" />
						<label class="Dib"><input type="checkbox" name="board_email" id="board_email" value="1"  <?php if(($TPL_VAR["seq"]&&$TPL_VAR["remail"]=='Y')||(!$TPL_VAR["seq"]&&$TPL_VAR["email"])){?> checked="checked" <?php }?>/> <span designElement="text" textIndex="21"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >메일받기</span></label>
					</li>
				</ul>
			</li>
		</ul>
		<ul class="required">
			<li class="th"><p designElement="text" textIndex="22"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >제목</p></li>
			<li class="td">
				<input type="text" name="subject" id="subject" value="<?php echo $TPL_VAR["subject"]?>" class="size_full"  title="제목을 입력하세요"  />
				<input type="hidden" name="hidden" id="hidden"  value="1" />
				<?php echo $TPL_VAR["displayckeck"]?>

			</li>
		</ul>
	</div>
	
	<textarea name="contents" id="contents" class="size3 resm_x1" title="내용을 입력하세요" ><?php echo $TPL_VAR["contents"]?></textarea>

<?php if(($TPL_VAR["manager"]["file_use"]=='Y'||$TPL_VAR["filelist"])){?>
	<div class="bbswrite_division">
		<!-- 게시판 파일첨부. 파일위치 : [스킨폴더]/board/_mobile_file.html -->
<?php $this->print_("mobile_file",$TPL_SCP,1);?>

		<!-- //게시판 파일첨부 -->
	</div>
<?php }?>

<?php if($TPL_VAR["manager"]["autowrite_use"]=='Y'&&!defined('__ISUSER__')){?>
	<div>
<?php $this->print_("securimage",$TPL_SCP,1);?>

	</div>
<?php }?>

<?php if(!defined('__ISUSER__')){?>
	<div class="label_group Pt20">
		<label><input type="radio" name="agree" value="Y" /> <span designElement="text" textIndex="23"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >개인정보 수집ㆍ이용에 동의합니다.</span></label>&nbsp;&nbsp;&nbsp;
		<label><input type="radio" name="agree" value="N" checked /> <span designElement="text" textIndex="24"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >개인정보 수집ㆍ이용에 동의하지 않습니다.</span></label>
		<textarea class="size1 Mt5" readonly><?php echo $TPL_VAR["policy"]?></textarea>
	</div>
<?php }?>

	<div class="board_detail_btns2">
		<div class="Pb10">
			<span designElement="text" textIndex="25"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >저장후</span> &nbsp; &nbsp;
			<span class="label_group2">
				<label><input type="radio" name="backtype" id="backtype1" value="list" <?php if((!$TPL_VAR["backtype"]||$TPL_VAR["backtype"]=='list')){?> checked="checked" <?php }?> /> <span designElement="text" textIndex="26"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >목록으로 이동</span></label>
				<label><input type="radio" name="backtype" id="backtype2" value="view" <?php if($TPL_VAR["backtype"]=='view'){?> checked="checked" <?php }?> /> <span designElement="text" textIndex="27"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >본문으로 이동</span></label>
			</span>
		</div>

		<button type="button" name="data_save_btn" id="data_save_btn" class="data_save_btn btn_resp size_c color2"><span designElement="text" textIndex="28"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >확인</span></button>
		<button type="button" class="btn_resp size_c" onclick="<?php if($_GET["popup"]){?>self.close();<?php }else{?>document.location.href='<?php echo $TPL_VAR["boardurl"]->lists?>';<?php }?>"><span designElement="text" textIndex="29"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9ib2FyZC9idWxrb3JkZXIvX2J1bGtvcmRlci93cml0ZS5odG1s" >취소</span></button>
	</div>

</form>

<!-- 상품 선택/검색 레이어 -->
<div id="displayGoodsSelect" class="resp_layer_pop hide">
	<h4 class="title">상품 검색</h4>
	<div class="y_scroll_auto">
		<div class="layer_pop_contents v3">
		</div>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>

<script type="text/javascript">
//<![CDATA[

function set_goods_list(displayId,inputGoods) {
	$.ajax({
		type: "get",
		url: "/goods/user_select",
		data: "page=1&bulkorder=1&inputGoods="+inputGoods+"&displayId="+displayId,
		success: function(result){
			$("#" + displayId + " .layer_pop_contents").html(result);
			//상품 검색
			showCenterLayer('#' + displayId);
		}
	});
	/*
<?php if($_GET["popup"]){?>
	openDialog(getAlert('et320'), displayId, {"width":"700","height":"700","show" : "fade","hide" : "fade"});
<?php }else{?>
	openDialog(getAlert('et320'), displayId, {"width":"1000","height":"700","show" : "fade","hide" : "fade"});
<?php }?>
	*/
}


function shippingdate(){
	$("#txtlabel_6").addClass("datepicker");//달력추가
}
shippingdate();
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
	$('#data_save_btn').click(function() {
		$("#writeform").submit();
	});


	$('#writeform').validate({
		onkeyup: false,
		rules: {
			subject: { required:true},
<?php if($TPL_VAR["manager"]["autowrite_use"]=='Y'&&!defined('__ISUSER__')){?>
			captcha_code:{required:true},
<?php }?>
<?php if(!defined('__ISUSER__')){?>
			pw:{required:true},
<?php }?>
		},
		messages: {
			name: { required:getAlert('et122')},//<font color="red">문의등록자를 입력해 주세요.</font>
			category: { required:getAlert('et123')},//<font color="red">분류를 선택해 주세요.</font>
<?php if($TPL_VAR["manager"]["autowrite_use"]=='Y'&&!defined('__ISUSER__')){?>
			captcha_code: { required:getAlert('et124')}, //<font color="red">스팸방지 코드를 입력해 주세요.</font>
<?php }?>
<?php if(!defined('__ISUSER__')){?>
			pw: { required:getAlert('et125')}, //<font color="red">비밀번호를 입력해 주세요.</font>
<?php }?>
			subject: { required:getAlert('et126')} //<font color="red">제목을 입력해 주세요.</font>
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
			if(readyEditorForm(f)){

<?php if(!defined('__ISUSER__')){?>
					if($("input[name='agree']:checked").val()!='Y'){						
						setDefaultText();
						alert(getAlert('et127')); //개인정보 수집ㆍ이용에 동의하셔야 합니다.
						$("input[name='agree']").focus();
						return false;
					}
<?php }?>

<?php if($TPL_VAR["categorylist"]){?>
					if( !$("#addcategory").val()){ 
						setDefaultText();
						alert(getAlert('et128')); //분류를 선택해 주세요.
						$("#addcategory").focus();
						return false; 
					}
<?php }?>

				var bcontents = $("#writeform").find("#contents").val();
				if(!bcontents || bcontents.toLowerCase() == "<p>&nbsp;</p>"  || bcontents.toLowerCase() == "<p><br></p>" ){
					setDefaultText();
					alert(getAlert('et129')); //내용을 입력해 주세요.
					$("#contents").focus();
					return false;
				}

				loadingstartsubmit();
				

				if (submitFlag == true)
				{
				 alert(getAlert('et130')); //게시물을 등록하고 있습니다. 잠시만 기다려 주세요.
				 return false;
				}   
				submitFlag = true;
				f.submit();
			}
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