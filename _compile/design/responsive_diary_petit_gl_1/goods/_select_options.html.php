<?php /* Template_ 2.2.6 2021/01/08 12:01:42 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/goods/_select_options.html 000037702 */ 
$TPL_option_data_1=empty($TPL_VAR["option_data"])||!is_array($TPL_VAR["option_data"])?0:count($TPL_VAR["option_data"]);
$TPL_inputs_1=empty($TPL_VAR["inputs"])||!is_array($TPL_VAR["inputs"])?0:count($TPL_VAR["inputs"]);
$TPL_suboptions_1=empty($TPL_VAR["suboptions"])||!is_array($TPL_VAR["suboptions"])?0:count($TPL_VAR["suboptions"]);
$TPL_cart_options_1=empty($TPL_VAR["cart_options"])||!is_array($TPL_VAR["cart_options"])?0:count($TPL_VAR["cart_options"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 상품 옵션 @@
- 파일위치 : [스킨폴더]/goods/_select_options.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript" src="/app/javascript/plugin/jquery_selectbox/js/jquery.selectbox-0.2.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.fmupload.js"></script>
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/jquery_selectbox/css/jquery.selectbox.mobile.css" />
<link rel="stylesheet" type="text/css" href="/data/skin/<?php echo $TPL_VAR["skin"]?>/css/buttons.css" />
<script type="text/javascript" src="/app/javascript/js/goods.option.0.2.js"></script>
<script type="text/javascript">
// 기존 option size 저장
var old_height = $('.goods_option_select_area').height();
$(document).ready(function(){
	gl_option_select_ver	= $("input[name='gl_option_select_ver']").val();

	var optObj			= new jscls_option_select();
	optObj.set_init('<?php echo count($TPL_VAR["goods"]["option_divide_title"])?>',
					'<?php echo $TPL_VAR["goods"]["goods_seq"]?>',
					'<?php if($TPL_VAR["goods"]["price"]>$TPL_VAR["goods"]["sale_price"]){?><?php echo $TPL_VAR["goods"]["sale_price"]?><?php }elseif($TPL_VAR["goods"]["price"]){?><?php echo $TPL_VAR["goods"]["price"]?><?php }else{?>0<?php }?>',
					'<?php if($TPL_VAR["goods"]["string_price_use"]){?><?php echo $TPL_VAR["goods"]["string_price_use"]?><?php }?>',
					'<?php echo $TPL_VAR["skin"]?>',
					true,
					'<?php echo $TPL_VAR["goods"]["min_purchase_ea"]?>',
					'<?php echo $TPL_VAR["goods"]["max_purchase_ea"]?>',
					'<?php echo $TPL_VAR["sessionMember"]["member_seq"]?>',
					'<?php echo $TPL_VAR["sessionMember"]["group_seq"]?>',
					'<?php echo $TPL_VAR["goods"]["option_view_type"]?>',
					'<?php echo $TPL_VAR["goods"]["suboption_layout_group"]?>',
					'<?php echo $TPL_VAR["goods"]["suboption_layout_position"]?>',
					'<?php echo $TPL_VAR["goods"]["inputoption_layout_group"]?>',
					'<?php echo $TPL_VAR["goods"]["inputoption_layout_position"]?>',
					'<?php echo $TPL_VAR["basic_currency"]?>', 
					'<?php echo $TPL_VAR["basic_currency_info"]["currency_symbol"]?>', 
					'<?php echo $TPL_VAR["basic_currency_info"]["currency_symbol_position"]?>',
					'<?php if($TPL_VAR["goods"]["string_button_use"]){?><?php echo $TPL_VAR["goods"]["string_button_use"]?><?php }?>');

<?php if($TPL_VAR["goods"]["event_sale_unit"]){?>
	optObj.set_event_sale('<?php echo $TPL_VAR["goods"]["sales"]["event_event_sale"]?>','<?php echo $TPL_VAR["goods"]["sales"]["event_target_sale"]?>');
<?php }?>

<?php if($TPL_VAR["goods"]["member_sale_unit"]){?>
	optObj.set_member_sale('<?php echo $TPL_VAR["goods"]["sales"]["member_sale_price"]?>','<?php echo $TPL_VAR["goods"]["sales"]["member_sale_type"]?>');
<?php }?>

	policyList = new Array();
<?php if(is_array($TPL_R1=$TPL_VAR["goods"]["multi_discount_policy"]["policyList"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		policyList.push('<?php echo $TPL_V1["discountOverQty"]?>/<?php echo $TPL_V1["discountUnderQty"]?>/<?php echo $TPL_V1["discountAmount"]?>');
<?php }}?>

<?php if($TPL_VAR["goods"]["multi_discount_policy"]){?>
	optObj.set_multi_sale(policyList, '<?php echo $TPL_VAR["goods"]["multi_discount_policy"]["discountMaxOverQty"]?>', '<?php echo $TPL_VAR["goods"]["multi_discount_policy"]["discountMaxAmount"]?>', '<?php echo $TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]?>');
<?php }?>

<?php if(is_numeric($TPL_VAR["config_system"]["cutting_sale_price"])&&$TPL_VAR["config_system"]["cutting_sale_use"]!='none'){?>
	optObj.set_cutting_sale_price('<?php echo $TPL_VAR["config_system"]["cutting_sale_price"]?>', '<?php echo $TPL_VAR["config_system"]["cutting_sale_action"]?>');
<?php }?>

<?php if($TPL_VAR["cart_options"]){?>
	optObj.set_option_change_type(true);
<?php if(count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"]){?>
	optObj.set_apply_option_seq('<?php echo count($TPL_VAR["cart_options"])?>');
<?php }?>
<?php }?>

<?php if($TPL_VAR["goods"]["inputoption_layout_position"]=='down'){?>
	var inputoptionData	= <?php echo json_encode($TPL_VAR["inputs"])?>;
	optObj.set_inputoption_data(inputoptionData);
<?php }?>

	// callback 함수 셋팅 :: 2016-02-04 lwh
	optObj.set_selectbox_option('sbHolderOpen', 'sbHolderClose');

	optObj.set_bind_option();
	apply_input_style();
});

// 옵션 선택시 슬라이드 옵션창 재조정 :: 2019-02-07 lwh
function sbHolderOpen(inst){
	if ( window.innerWidth < 768 ) {
		if ( old_height == 0 ) {
			old_height = $('#select_option_lay .goods_option_area').height();
		}
		var opScrollHeight = $('#select_option_lay .goods_option_area').height();
		var selectOptionHeight = $('#select_option_lay').find('.sbOptions:visible').height();
		if ( selectOptionHeight > opScrollHeight - 77 ) {
			$('#select_option_lay .goods_option_area').css( 'min-height', opScrollHeight + selectOptionHeight + 22 + 'px' );
			$('#select_option_lay').find('.sbOptions').css( 'max-height', 'none' );
		}
	}
}
function sbHolderClose(inst){
	// 선택된 옵션이 있는지 체크
	if ( window.innerWidth < 768 ) {
		if($(".goods_quantity_table_container").css('display') != 'block'){
			$('#select_option_lay .goods_option_area').css( 'min-height', '0' );
		}
	}
}
</script>

<div id="select_option_lay">
	<input type="hidden" name="option_select_goods_seq" value="<?php echo $TPL_VAR["goods"]["goods_seq"]?>" />
	<input type="hidden" name="option_select_provider_seq" value="<?php echo $TPL_VAR["goods"]["provider_seq"]?>" />
	<input type="hidden" name="gl_option_select_ver" value="0.1" />
<?php if((count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"])&&($TPL_VAR["suboptions"]||$TPL_VAR["inputs"])){?>
	<input type="hidden" name="use_add_action_button" value="y" />
<?php }else{?>
	<input type="hidden" name="use_add_action_button" value="n" />
<?php }?>

	<div class="goods_option_area">
<?php if(!(count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"])&&!$TPL_VAR["goods"]["string_price_use"]&&!$TPL_VAR["goods"]["string_button_use"]){?>
		<input type="hidden" name="option[0][0]" class="selected_options" type="hidden" value="" opt_seq="0" opt_group="0" />
		<input type="hidden" name="optionTitle[0][0]" class="selected_options_title" type="hidden" value="" opt_seq="0" opt_group="0" />
<?php if($TPL_VAR["cart_options"][ 0]['cart_option_seq']> 0){?>
		<input type="hidden" name="exist_option_seq[]" class="cart_option_seq" value="<?php echo $TPL_VAR["cart_options"][ 0]['cart_option_seq']?>" />
<?php }?>
<?php if($TPL_VAR["select_option_mode"]=='optional_change'){?>
		<table align="left" border="0" cellpadding="1" cellspacing="0">
		<tr>
			<td class="single_num_change">
				<span class="tle">수량 :</span>
				<button type="button" class="btn_graybox eaMinus">-</button><input type="text" name="optionEa[0]" value="<?php if($TPL_VAR["cart_options"][ 0]['ea']> 0){?><?php echo $TPL_VAR["cart_options"][ 0]['ea']?><?php }else{?>1<?php }?>" class="onlynumber ea_change" style="text-align:center; width:31px; height:31px; border:1px solid #d0d0d0;" /><button type="button" class="btn_graybox eaPlus">+</button>
				<div style="display:none" class="optionPrice"><?php echo $TPL_VAR["goods"]["sale_price"]?></div>
				<div style="display:none" class="consumer_price"><?php echo $TPL_VAR["goods"]["consumer_price"]?></div>
			</td>
		</tr>
		</table>
<?php }?>
<?php }?>
<?php if((count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"])||$TPL_VAR["suboptions"]||$TPL_VAR["inputs"]){?>
		<table class="goods_option_table" width="100%" cellpadding="0" cellspacing="0" border="0">
		<colgroup>
			<col />
			<col width="15" />
		</colgroup>

			<!-- 필수옵션 시작 -->
<?php if(count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"]){?>
<?php if(!$TPL_VAR["minimize"]){?>
		<tr>
			<th colspan="2"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL19zZWxlY3Rfb3B0aW9ucy5odG1s" >상품옵션</span></th>
		</tr>
<?php }?>
<?php }?>
<?php if($TPL_option_data_1){$TPL_I1=-1;foreach($TPL_VAR["option_data"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
		<tr class="optionTr">
			<td colspan="2">
				<span class="optionTitle hide"><?php echo $TPL_V1["title"]?></span>
				<select name="viewOptions[]" id="<?php echo $TPL_K1?>" opttype="<?php echo $TPL_V1["newtype"]?>">
					<option value="">- <?php echo $TPL_V1["title"]?> 선택 -</option>
<?php if($TPL_V1["options"]&&$TPL_I1== 0){?>
<?php if(is_array($TPL_R2=$TPL_V1["options"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
					<option value="<?php echo $TPL_V2["opt"]?>" price="<?php echo $TPL_V2["org_basic_price"]?>" consumer_price="<?php echo $TPL_V2["consumer_price"]?>" opt1="<?php echo $TPL_V2["option1"]?>" opt2="<?php echo $TPL_V2["option2"]?>" opt3="<?php echo $TPL_V2["option3"]?>" opt4="<?php echo $TPL_V2["option4"]?>" opt5="<?php echo $TPL_V2["option5"]?>" infomation="<?php echo $TPL_V2["infomation"]?>" class="<?php echo $TPL_V2["chk_stock_class"]?>" seq="<?php echo $TPL_I2?>"><?php echo $TPL_V2["opt_string"]?></option>
<?php }}?>
<?php }?>
				</select>
<?php if($TPL_V1["newtype"]&&$TPL_V1["newtype"]=='color'&&$TPL_VAR["goods"]["option_view_type"]=='divide'){?>
				<div class="viewOptionsspecialays <?php echo $TPL_V1["newtype"]?>">
<?php if(is_array($TPL_R2=$TPL_V1["options"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["chk_stock"]){?>
					<span class="<?php echo $TPL_V2["color"]?>"><span name="viewOptionsspecialbtn" class="viewOptionsspecialbtn hand bbs_btn <?php echo $TPL_V2["color"]?>"  style="color:<?php echo $TPL_V2["color"]?>;"  value="<?php echo $TPL_V2["opt"]?>"  optvalue="<?php echo $TPL_V2["opt"]?>" price="<?php echo $TPL_V2["org_price"]?>" opt1="<?php echo $TPL_V2["option1"]?>" opt2="<?php echo $TPL_V2["option2"]?>" opt3="<?php echo $TPL_V2["option3"]?>" opt4="<?php echo $TPL_V2["option4"]?>" opt5="<?php echo $TPL_V2["option5"]?>" infomation="<?php echo $TPL_V2["infomation"]?>"  eqindex='0'><font style="background-color:<?php echo $TPL_V2["color"]?>;">■</font></span></span>
<?php }else{?>
					<span class="<?php echo $TPL_V2["color"]?>"><span name="" class="viewOptionsspecialbtnDisable hand bbs_btn <?php echo $TPL_V2["color"]?>"  style="color:<?php echo $TPL_V2["color"]?>;"  value="<?php echo $TPL_V2["opt"]?>"  optvalue="<?php echo $TPL_V2["opt"]?>" price="<?php echo $TPL_V2["org_basic_price"]?>" consumer_price="<?php echo $TPL_V2["consumer_price"]?>" opt1="<?php echo $TPL_V2["option1"]?>" opt2="<?php echo $TPL_V2["option2"]?>" opt3="<?php echo $TPL_V2["option3"]?>" opt4="<?php echo $TPL_V2["option4"]?>" opt5="<?php echo $TPL_V2["option5"]?>" infomation="<?php echo $TPL_V2["infomation"]?>"  eqindex='0'><font style="background-color:<?php echo $TPL_V2["color"]?>;">■</font><b class="out">품절</b></span></span>
<?php }?>
<?php }}?>
				</div>
<?php }?>
			</td>
		</tr>
<?php }}?>
		<tr id="viewoptionsInfoTr" class="hide">
			<td id="viewOptionsInfo" class="center" colspan="2"></td>
		</tr>
			<!-- 필수옵션 끝 -->

			<!-- 입력옵션 시작 -->
<?php if($TPL_VAR["inputs"]&&$TPL_VAR["goods"]["inputoption_layout_position"]!='down'){?>
<?php if(!$TPL_VAR["minimize"]){?>
		<tr>
			<th colspan="2"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL19zZWxlY3Rfb3B0aW9ucy5odG1s" >입력옵션</span></th>
		</tr>
<?php }?>
<?php if(!(count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"])&&$TPL_VAR["cart_options"]){?>
<?php if(is_array($TPL_R1=$TPL_VAR["cart_options"][ 0]["cart_inputs"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
		<tr class="inputoptionTr">
			<td colspan="2">
				<span class="inputsTitle hide"><?php echo $TPL_V1["title"]?></span>
				<input type="hidden" name="viewInputsTitle[]" value="<?php echo $TPL_V1["input_title"]?>" />
<?php if($TPL_V1["type"]=='edit'){?>
				<div class="viewInputTextareaLay"><textarea name="viewInputs[]" rows="4" class="inputlimit"  inputlimit="<?php echo $TPL_V1["input_limit"]?>" limit="<?php echo $TPL_V1["input_limit"]?>" <?php if($TPL_V1["input_require"]){?>isrequired="y"<?php }?> title="<?php echo $TPL_V1["title"]?>을 입력하세요 <?php if($TPL_V1["input_require"]&&$TPL_V1["input_limit"]> 0){?> (필수, <?php echo $TPL_V1["input_limit"]?>자 이내)<?php }elseif($TPL_V1["input_require"]){?>(필수) <?php }?>"><?php echo $TPL_V1["input_value"]?></textarea></div>
<?php }elseif($TPL_V1["type"]=='text'){?>
				<div class="viewInputLay"><input type="text" name="viewInputs[]" class="inputlimit"  inputlimit="<?php echo $TPL_V1["input_limit"]?>" limit="<?php echo $TPL_V1["input_limit"]?>" <?php if($TPL_V1["input_require"]){?>isrequired="y"<?php }?> title="<?php echo $TPL_V1["title"]?>을 입력하세요<?php if($TPL_V1["input_require"]&&$TPL_V1["input_limit"]> 0){?> (필수, <?php echo $TPL_V1["input_limit"]?>자 이내)<?php }elseif($TPL_V1["input_require"]){?>(필수) <?php }?>" value="<?php echo $TPL_V1["input_value"]?>" /></div>
<?php }elseif($TPL_V1["type"]=='file'){?>
				<table class="upload-tb" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="title_dd"><?php echo $TPL_V1["title"]?></td>
					<td><div class="inputsUploadButton" id="fmupload_<?php echo $TPL_I1?>" uploadType="fmupload"></div></td>
<?php if($TPL_V1["input_value"]){?>
					<td><img src="/data/order/<?php echo $TPL_V1["input_value"]?>" id="prevImg" style="height:20px;" designImgSrcOri='L2RhdGEvb3JkZXIvey5pbnB1dF92YWx1ZX0=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL19zZWxlY3Rfb3B0aW9ucy5odG1s' designImgSrc='L2RhdGEvb3JkZXIvey5pbnB1dF92YWx1ZX0=' designElement='image' /></td>
<?php }else{?>
					<td><img src="about:blank;" class="prevImg" style="display:none;height:20px;" designImgSrcOri='YWJvdXQ6Ymxhbms7' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL19zZWxlY3Rfb3B0aW9ucy5odG1s' designImgSrc='YWJvdXQ6Ymxhbms7' designElement='image' /></td>
<?php }?>
					<td><span class="prevTxt"></span></td>
				</tr>
				<input type="hidden" name="viewInputs[]" class="fmuploadInputs" <?php if($TPL_V1["input_require"]){?>isrequired="y"<?php }?> value="<?php echo $TPL_V1["input_value"]?>" />
				</table>
<?php }?>
			</td>
		</tr>
<?php }}?>
<?php }else{?>
<?php if($TPL_inputs_1){$TPL_I1=-1;foreach($TPL_VAR["inputs"] as $TPL_V1){$TPL_I1++;?>
		<tr class="inputoptionTr">
			<td colspan="2">
				<span class="inputsTitle hide"><?php echo $TPL_V1["input_name"]?></span>
				<input type="hidden" name="viewInputsTitle[]" value="<?php echo $TPL_V1["input_name"]?>" />
<?php if($TPL_V1["input_form"]=='edit'){?>
				<div class="viewInputTextareaLay"><textarea name="viewInputs[]" rows="4" class="inputlimit"  inputlimit="<?php echo $TPL_V1["input_limit"]?>"  limit="<?php echo $TPL_V1["input_limit"]?>" <?php if($TPL_V1["input_require"]){?>isrequired="y"<?php }?> title="<?php echo $TPL_V1["input_name"]?>을 입력하세요<?php if($TPL_V1["input_require"]&&$TPL_V1["input_limit"]> 0){?> (필수, <?php echo $TPL_V1["input_limit"]?>자 이내)<?php }elseif($TPL_V1["input_require"]){?>(필수) <?php }?>"></textarea></div>
<?php }elseif($TPL_V1["input_form"]=='text'){?>
				<div class="viewInputLay"><input type="text" name="viewInputs[]" class="inputlimit"  inputlimit="<?php echo $TPL_V1["input_limit"]?>"  limit="<?php echo $TPL_V1["input_limit"]?>" <?php if($TPL_V1["input_require"]){?>isrequired="y"<?php }?> title="<?php echo $TPL_V1["input_name"]?>을 입력하세요<?php if($TPL_V1["input_require"]&&$TPL_V1["input_limit"]> 0){?> (필수, <?php echo $TPL_V1["input_limit"]?>자 이내)<?php }elseif($TPL_V1["input_require"]){?>(필수) <?php }?>" /></div>
<?php }elseif($TPL_V1["input_form"]=='file'){?>
				<table class="upload-tb" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="title_dd"><?php echo $TPL_V1["input_name"]?></td>
					<td><div class="inputsUploadButton" id="fmupload_<?php echo $TPL_I1?>" uploadType="fmupload"></div></td>
					<td><img src="about:blank;" class="prevImg" style="display:none;height:20px;" designImgSrcOri='YWJvdXQ6Ymxhbms7' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL19zZWxlY3Rfb3B0aW9ucy5odG1s' designImgSrc='YWJvdXQ6Ymxhbms7' designElement='image' /></td>
					<td><span class="prevTxt"></span></td>
				</tr>
				<input type="hidden" name="viewInputs[]" class="fmuploadInputs" <?php if($TPL_V1["input_require"]){?>isrequired="y"<?php }?>  />
				</table>
<?php }?>
			</td>
		</tr>
<?php }}?>
<?php }?>
<?php }?>
			<!-- 입력옵션 끝 -->


			<!-- 추가옵션 시작 -->
<?php if($TPL_VAR["suboptions"]&&$TPL_VAR["goods"]["suboption_layout_group"]!='first'){?>
<?php if(!$TPL_VAR["minimize"]){?>
		<tr>
			<th colspan="3"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL19zZWxlY3Rfb3B0aW9ucy5odG1s" >추가구성</span></th>
		</tr>
<?php }?>
<?php if($TPL_suboptions_1){$TPL_I1=-1;foreach($TPL_VAR["suboptions"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_V1[ 0]["sub_required"]=='y'){?>
		<input type="hidden" name="suboption_title_required[]" value="<?php echo $TPL_V1[ 0]["suboption_title"]?>" />
<?php }?>
		<tr class="suboptionTr" subGroupIdx="<?php echo $TPL_I1?>">
			<td <?php if(count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"]){?><?php }else{?>colspan="2"<?php }?>>
				<span class="suboptionTitle hide"><?php echo $TPL_V1[ 0]["suboption_title"]?></span>
				<select name="viewSuboption[]" requiredgroup="<?php echo $TPL_I1?>" <?php if($TPL_V1[ 0]["sub_required"]=='y'){?>isrequired="y"<?php }?>>
					<option value="">- <?php echo $TPL_V1[ 0]["suboption_title"]?> 선택<?php if($TPL_V1[ 0]["sub_required"]=='y'){?> (필수)<?php }?> -</option>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_V2["chk_stock"]){?>
<?php if($TPL_V2["price"]> 0){?>
						<option value="<?php echo $TPL_V2["suboption"]?>" price="<?php echo $TPL_V2["price"]?>" seq="<?php echo $TPL_I2?>"><?php echo $TPL_V2["suboption"]?> (추가 <?php echo get_currency_price($TPL_V2["price"], 2)?>)</option>
<?php }else{?>
						<option value="<?php echo $TPL_V2["suboption"]?>" price="0" seq="<?php echo $TPL_I2?>"><?php echo $TPL_V2["suboption"]?></option>
<?php }?>
<?php }else{?>
						<option value="<?php echo $TPL_V2["suboption"]?>" price="0" disabled><?php echo $TPL_V2["suboption"]?> (품절)</option>
<?php }?>
<?php }}?>
				</select>
<?php if($TPL_V1[ 0]["newtype"]=='color'){?>
				<div class="viewSubOptionsspecialays">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["newtype"]=='color'){?>
<?php if($TPL_V2["chk_stock"]){?>
					<span  class="<?php echo $TPL_V2["color"]?>"><span name="viewSubOptionsspecialbtn" opspecialtype="color" class="viewSubOptionsspecialbtn hand bbs_btn <?php echo $TPL_V2["color"]?>" style="color:<?php echo $TPL_V2["color"]?>;"  value="<?php echo $TPL_V2["suboption"]?>"  suboptvalue="<?php echo $TPL_V2["suboption"]?>" price="<?php echo $TPL_V2["price"]?>" eqindex="<?php echo $TPL_I1?>" opspecial_location="1"><font style="background-color:<?php echo $TPL_V2["color"]?>;">■</font></span></span>
<?php }else{?>
					<span  class="<?php echo $TPL_V2["color"]?>"><span name="" opspecialtype="color" class="viewSubOptionsspecialbtnDisable hand bbs_btn <?php echo $TPL_V2["color"]?>" style="color:<?php echo $TPL_V2["color"]?>;" value="<?php echo $TPL_V2["suboption"]?>" suboptvalue="<?php echo $TPL_V2["suboption"]?>" price="<?php echo $TPL_V2["price"]?>" eqindex="<?php echo $TPL_I1?>" opspecial_location="1"><font style="background-color:<?php echo $TPL_V2["color"]?>;">■</font><b class="out">품절</b></span></span>
<?php }?>
<?php }?>
<?php }}?>
				</div>
<?php }?>
			</td>
<?php if(count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"]){?>
			<td class="btn_pm_td">
				<button class="btn_add_suboption btn_graybox" type="button">+</button>
			</td>
<?php }?>
		</tr>
<?php }}?>
<?php }?>
			<!-- 추가옵션 끝 -->

<?php if((count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"])&&(($TPL_VAR["suboptions"]&&$TPL_VAR["goods"]["suboption_layout_group"]!='first')||($TPL_VAR["inputs"]&&$TPL_VAR["goods"]["inputoption_layout_position"]!='down'))){?>
		<!-- <tr><td colspan="3" style="min-height:0;height:0;line-height:0;border-top:1px solid #ccc;"></td></tr>
		<tr><td colspan="3" style="min-height:0;height:10px;line-height:5px;"></td></tr> -->
		<tr>
			<td colspan="3" align="center" style="padding-top:10px; padding-bottom:10px;">
				<button type="button" class="viewOptionsApply btn_resp size_c color6" style="width:100%"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL19zZWxlY3Rfb3B0aW9ucy5odG1s" >위의 정보로 선택</span></button>
			</td>
		</tr>
<?php }?>

		</table>
<?php }?>
		<!-- 옵션 선택 영역 끝 -->

		<!-- 추가옵션 시작 -->
<?php if($TPL_VAR["goods"]["suboption_layout_group"]=='first'){?>
		<table class="goods_option_table" width="100%" cellpadding="0" cellspacing="5" border="0">
		<colgroup>
			<col />
			<col width="15" />
		</colgroup>
<?php if(!$TPL_VAR["minimize"]){?>
		<tr>
			<th colspan="3"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL19zZWxlY3Rfb3B0aW9ucy5odG1s" >추가구성</span></th>
		</tr>
<?php }?>
<?php if($TPL_suboptions_1){$TPL_I1=-1;foreach($TPL_VAR["suboptions"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_V1[ 0]["sub_required"]=='y'){?>
		<input type="hidden" name="suboption_title_required[]" value="<?php echo $TPL_V1[ 0]["suboption_title"]?>" />
<?php }?>
		<tr class="suboptionTr" subGroupIdx="<?php echo $TPL_I1?>">
			<td <?php if(count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"]){?><?php }else{?>colspan="2"<?php }?>>
				<span class="suboptionTitle hide"><?php echo $TPL_V1[ 0]["suboption_title"]?></span>
				<select name="viewSuboption[]" requiredgroup="<?php echo $TPL_I1?>" <?php if($TPL_V1[ 0]["sub_required"]=='y'){?>isrequired="y"<?php }?>>
					<option value="">- <?php echo $TPL_V1[ 0]["suboption_title"]?> 선택<?php if($TPL_V1[ 0]["sub_required"]=='y'){?> (필수)<?php }?> -</option>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["chk_stock"]){?>
<?php if($TPL_V2["price"]> 0){?>
						<option value="<?php echo $TPL_V2["suboption"]?>" price="<?php echo $TPL_V2["price"]?>"><?php echo $TPL_V2["suboption"]?> (추가 <?php echo get_currency_price($TPL_V2["price"], 2)?>)</option>
<?php }else{?>
						<option value="<?php echo $TPL_V2["suboption"]?>" price="0"><?php echo $TPL_V2["suboption"]?></option>
<?php }?>
<?php }else{?>
						<option value="<?php echo $TPL_V2["suboption"]?>" price="0" disabled><?php echo $TPL_V2["suboption"]?> (품절)</option>
<?php }?>
<?php }}?>
				</select>
<?php if($TPL_V1[ 0]["newtype"]=='color'){?>
				<div class="viewSubOptionsspecialays">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["newtype"]=='color'){?>
<?php if($TPL_V2["chk_stock"]){?>
					<span  class="<?php echo $TPL_V2["color"]?>"><span name="viewSubOptionsspecialbtn" opspecialtype="color" class="viewSubOptionsspecialbtn hand bbs_btn <?php echo $TPL_V2["color"]?>" style="color:<?php echo $TPL_V2["color"]?>;"  value="<?php echo $TPL_V2["suboption"]?>"  suboptvalue="<?php echo $TPL_V2["suboption"]?>" price="<?php echo $TPL_V2["price"]?>" eqindex="<?php echo $TPL_I1?>" opspecial_location="1"><font style="background-color:<?php echo $TPL_V2["color"]?>;">■</font></span></span>
<?php }else{?>
					<span  class="<?php echo $TPL_V2["color"]?>"><span name="" opspecialtype="color" class="viewSubOptionsspecialbtnDisable hand bbs_btn <?php echo $TPL_V2["color"]?>" style="color:<?php echo $TPL_V2["color"]?>;" value="<?php echo $TPL_V2["suboption"]?>" suboptvalue="<?php echo $TPL_V2["suboption"]?>" price="<?php echo $TPL_V2["price"]?>" eqindex="<?php echo $TPL_I1?>" opspecial_location="1"><font style="background-color:<?php echo $TPL_V2["color"]?>;">■</font><b class="out">품절</b></span></span>
<?php }?>
<?php }?>
<?php }}?>
				</div>
<?php }?>
			</td>
		</tr>
<?php }}?>
		</table>
<?php }?>
		<!-- 추가옵션 끝 -->




		<!-- 선택된 옵션 노출 영역 시작( 장바구니에 해당 ) -->
<?php if(!$TPL_VAR["goods"]["string_price_use"]&&!$TPL_VAR["goods"]["string_button_use"]){?>
		<div class="goods_quantity_table_container" <?php if(!$TPL_VAR["cart_options"]){?> style="display:none"<?php }?>>
			<table class="goods_quantity_table" cellpadding="0" cellspacing="0">
<?php if($TPL_VAR["cart_options"]){?>
<?php if($TPL_cart_options_1){$TPL_I1=-1;foreach($TPL_VAR["cart_options"] as $TPL_V1){$TPL_I1++;?>
				<input type="hidden" name="exist_option_seq[<?php echo $TPL_I1?>]" class="cart_option_seq" value="<?php echo $TPL_V1["cart_option_seq"]?>" />
<?php if(count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"]){?>
				<tr class="quanity_row option_tr" opt_group="<?php echo $TPL_I1?>">
					<td class="quantity_cell option_col_text">
<?php if($TPL_V1["option1"]){?>
							<div class="option_text"><?php echo $TPL_V1["title1"]?> : <?php echo $TPL_V1["option1"]?></div>
							<input name="option[<?php echo $TPL_I1?>][0]" class="selected_options" type="hidden" value="<?php echo $TPL_V1["option1"]?>" opt_seq="0" opt_group="<?php echo $TPL_I1?>" />
							<input name="optionTitle[<?php echo $TPL_I1?>][0]" class="selected_options_title" type="hidden" value="<?php echo $TPL_V1["title1"]?>" opt_seq="0" opt_group="<?php echo $TPL_I1?>" />
<?php }?>
<?php if($TPL_V1["option2"]){?>
							<div class="option_text"><?php echo $TPL_V1["title2"]?> : <?php echo $TPL_V1["option2"]?></div>
							<input name="option[<?php echo $TPL_I1?>][1]" class="selected_options" type="hidden" value="<?php echo $TPL_V1["option2"]?>" opt_seq="1" opt_group="<?php echo $TPL_I1?>" />
							<input name="optionTitle[<?php echo $TPL_I1?>][1]" class="selected_options_title" type="hidden" value="<?php echo $TPL_V1["title2"]?>" opt_seq="1" opt_group="<?php echo $TPL_I1?>" />
<?php }?>
<?php if($TPL_V1["option3"]){?>
							<div class="option_text"><?php echo $TPL_V1["title3"]?> : <?php echo $TPL_V1["option3"]?></div>
							<input name="option[<?php echo $TPL_I1?>][2]" class="selected_options" type="hidden" value="<?php echo $TPL_V1["option3"]?>" opt_seq="2" opt_group="<?php echo $TPL_I1?>" />
							<input name="optionTitle[<?php echo $TPL_I1?>][2]" class="selected_options_title" type="hidden" value="<?php echo $TPL_V1["title3"]?>" opt_seq="2" opt_group="<?php echo $TPL_I1?>" />
<?php }?>
<?php if($TPL_V1["option4"]){?>
							<div class="option_text"><?php echo $TPL_V1["title4"]?> : <?php echo $TPL_V1["option4"]?></div>
							<input name="option[<?php echo $TPL_I1?>][3]" class="selected_options" type="hidden" value="<?php echo $TPL_V1["option4"]?>" opt_seq="3" opt_group="<?php echo $TPL_I1?>" />
							<input name="optionTitle[<?php echo $TPL_I1?>][3]" class="selected_options_title" type="hidden" value="<?php echo $TPL_V1["title4"]?>" opt_seq="3" opt_group="<?php echo $TPL_I1?>" />
<?php }?>
<?php if($TPL_V1["option5"]){?>
							<div class="option_text"><?php echo $TPL_V1["title5"]?> : <?php echo $TPL_V1["option5"]?></div>
							<input name="option[<?php echo $TPL_I1?>][4]" class="selected_options" type="hidden" value="<?php echo $TPL_V1["option5"]?>" opt_seq="4" opt_group="<?php echo $TPL_I1?>" />
							<input name="optionTitle[<?php echo $TPL_I1?>][4]" class="selected_options_title" type="hidden" value="<?php echo $TPL_V1["title5"]?>" opt_seq="4" opt_group="<?php echo $TPL_I1?>" />
<?php }?>
						
						<ul class="num_price">
							<li><button type="button" class="btn_graybox eaMinus">-</button><input type="text" name="optionEa[<?php echo $TPL_I1?>]" class="onlynumber ea_change" value="<?php echo $TPL_V1["ea"]?>" /><button type="button" class="btn_graybox eaPlus">+</button></li>
							<li class="option_col_price">
								<span class="optionPrice hide"><?php echo get_currency_price($TPL_V1["price"],'')?></span>
								<?php echo get_currency_price($TPL_V1["price"]*$TPL_V1["ea"],null,'','<strong class="out_option_price">_str_price_</strong>')?>

								<img src="/data/skin/responsive_diary_petit_gl_1/images/common/icon_close_gray.png" class="removeOption" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9pY29uX2Nsb3NlX2dyYXkucG5n' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL19zZWxlY3Rfb3B0aW9ucy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2NvbW1vbi9pY29uX2Nsb3NlX2dyYXkucG5n' designElement='image' />
							</li>
						</ul>
					</td>
				</tr>

<?php if(is_array($TPL_R2=$TPL_V1["cart_inputs"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_VAR["goods"]["inputoption_layout_position"]=='down'){?>
<?php if($TPL_V2["type"]=='file'){?>
				<tr class="quanity_row inputoption_tr" opt_group="<?php echo $TPL_I1?>">
					<td class="quantity_cell option_text" style="border-top:none;">
						<input name="inputsTitle[<?php echo $TPL_I1?>][<?php echo $TPL_I2?>]" class="selected_inputs_title" type="hidden" value="<?php echo $TPL_V2["input_title"]?>" opt_seq="<?php echo $TPL_I2?>" opt_group="<?php echo $TPL_I1?>" />
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td style="width:{=(strlen(..input_title * 10 + 20)}px;max-width:200px;">
								<?php echo $TPL_V2["input_title"]?>

							</td>
							<td>
								<table class="upload-tb" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td><div class="inputsUploadButton" id="fmupload_<?php echo $TPL_I1?>_<?php echo $TPL_I2?>" uploadType="fmupload"></div></td>
<?php if($TPL_V2["input_value"]){?>
									<td><img src="/data/order/<?php echo $TPL_V2["input_value"]?>" class="prevImg" style="height:20px;" designImgSrcOri='L2RhdGEvb3JkZXIvey4uaW5wdXRfdmFsdWV9' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL19zZWxlY3Rfb3B0aW9ucy5odG1s' designImgSrc='L2RhdGEvb3JkZXIvey4uaW5wdXRfdmFsdWV9' designElement='image' /></td>
<?php }else{?>
									<td><img src="about:blank;" class="prevImg" style="display:none;height:20px;" designImgSrcOri='YWJvdXQ6Ymxhbms7' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL19zZWxlY3Rfb3B0aW9ucy5odG1s' designImgSrc='YWJvdXQ6Ymxhbms7' designElement='image' /></td>
<?php }?>
									<td><span class="prevTxt"><?php echo $TPL_V2["input_value"]?></span><input type="hidden" name="inputsValue[<?php echo $TPL_I1?>][<?php echo $TPL_I2?>]" class="selected_inputs fmuploadInputs" type="hidden" value="<?php echo $TPL_V2["input_value"]?>" opt_seq="<?php echo $TPL_I2?>" opt_group="<?php echo $TPL_I1?>" /></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
					</td>
				</tr>
<?php }else{?>
				<tr class="quanity_row inputoption_tr" opt_group="<?php echo $TPL_I1?>">
					<td class="quantity_cell option_text" style="border-top:none;">
						<input name="inputsTitle[<?php echo $TPL_I1?>][<?php echo $TPL_I2?>]" class="selected_inputs_title" type="hidden" value="<?php echo $TPL_V2["input_title"]?>" opt_seq="<?php echo $TPL_I2?>" opt_group="<?php echo $TPL_I1?>" />
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><?php echo $TPL_V2["input_title"]?></td>
							<td style="text-align:right;color:#6c6c6c;<?php if($TPL_V2["input_limit"]> 0){?><?php }else{?>display:none;<?php }?>"><span class="inputByte_<?php echo $TPL_I1?>_<?php echo $TPL_I2?>">0</span>/<?php echo $TPL_V2["input_limit"]?></td>
						</tr>
						</table>
					</td>
				</tr>

				<tr class="quanity_row inputoption_tr" opt_group="<?php echo $TPL_I1?>">
					<td class="quantity_cell option_text" style="border-top:none;">
<?php if($TPL_V2["type"]=='edit'){?>
						<div class="viewInputTextareaLay"><textarea rows="4" name="inputsValue[<?php echo $TPL_I1?>][<?php echo $TPL_I2?>]" class="selected_inputs inputlimit" inputlimit="<?php echo $TPL_V2["input_limit"]?>"  <?php if($TPL_V2["input_require"]){?>isrequired="y" title="(필수)"<?php }?>><?php echo $TPL_V2["input_value"]?></textarea></div>
<?php }else{?>
						<div class="viewInputLay" style="width:100%;"><input type="text" name="inputsValue[<?php echo $TPL_I1?>][<?php echo $TPL_I2?>]" class="selected_inputs inputlimit" inputlimit="<?php echo $TPL_V2["input_limit"]?>" <?php if($TPL_V2["input_require"]){?>isrequired="y" title="(필수)"<?php }?>  opt_seq="<?php echo $TPL_I2?>" opt_group="<?php echo $TPL_I1?>" value="<?php echo $TPL_V2["input_value"]?>"  style="width:100%;"/></div>
<?php }?>
					</td>
				</tr>
<?php }?>
<?php }else{?>
				<tr class="quanity_row inputoption_tr" opt_group="<?php echo $TPL_I1?>">
					<td class="quantity_cell option_text" style="border-top:none;">
						<?php echo $TPL_V2["input_title"]?> : <?php echo $TPL_V2["input_value"]?>

						<input name="inputsTitle[<?php echo $TPL_I1?>][<?php echo $TPL_I2?>]" class="selected_inputs_title" type="hidden" value="<?php echo $TPL_V2["input_title"]?>" opt_seq="<?php echo $TPL_I2?>" opt_group="<?php echo $TPL_I1?>" />
						<input name="inputsValue[<?php echo $TPL_I1?>][<?php echo $TPL_I2?>]" class="selected_inputs" type="hidden" value="<?php echo $TPL_V2["input_value"]?>" opt_seq="<?php echo $TPL_I2?>" opt_group="<?php echo $TPL_I1?>" />
					</td>
				</tr>
				<!--tr class="quanity_row inputoption_tr" opt_group="<?php echo $TPL_I1?>">
					<td class="quantity_cell option_text" style="border-top:none;">
						<?php echo $TPL_V2["input_title"]?>

						<input name="inputsTitle[<?php echo $TPL_I1?>][<?php echo $TPL_I2?>]" class="selected_inputs_title" type="hidden" value="<?php echo $TPL_V2["input_title"]?>" opt_seq="<?php echo $TPL_I2?>" opt_group="<?php echo $TPL_I1?>" />
					</td>
				</tr>
				<tr class="quanity_row inputoption_tr" opt_group="<?php echo $TPL_I1?>">
					<td class="quantity_cell option_text" style="border-top:none;">
						<div style="width:100%;"><?php echo $TPL_V2["input_value"]?></div>
						<input name="inputsValue[<?php echo $TPL_I1?>][<?php echo $TPL_I2?>]" class="selected_inputs" type="hidden" value="<?php echo $TPL_V2["input_value"]?>" opt_seq="<?php echo $TPL_I2?>" opt_group="<?php echo $TPL_I1?>" />
					</td>
				</tr-->

<?php }?>
<?php }}?>
<?php }?>

<?php if(is_array($TPL_R2=$TPL_V1["cart_suboptions"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
				<tr class="quanity_row suboption_tr" opt_group="<?php echo $TPL_I1?>">
					<td class="quantity_cell_sub">
						<div class="option_text">
							- <?php echo $TPL_V2["suboption_title"]?> : <?php echo $TPL_V2["suboption"]?>

							<input name="suboption[<?php echo $TPL_I1?>][<?php echo $TPL_I2?>]" class="suboption selected_suboptions" type="hidden" value="<?php echo $TPL_V2["suboption"]?>" opt_seq="<?php echo $TPL_I2?>" opt_group="<?php echo $TPL_I1?>" />
							<input name="suboptionTitle[<?php echo $TPL_I1?>][<?php echo $TPL_I2?>]" class="selected_suboptions_title" type="hidden" value="<?php echo $TPL_V2["suboption_title"]?>" opt_seq="<?php echo $TPL_I2?>" opt_group="<?php echo $TPL_I1?>" />
						</div>
						<ul class="num_price">
							<li>
								<button type="button" class="btn_graybox eaMinus">-</button><input type="text" name="suboptionEa[<?php echo $TPL_I1?>][<?php echo $TPL_I2?>]" class="onlynumber ea_change" value="<?php echo $TPL_V2["ea"]?>" /><button type="button" class="btn_graybox eaPlus">+</button>
							</li>
							<li class="option_col_price">
								<span class="suboptionPrice hide"><?php echo get_currency_price($TPL_V2["price"],'')?></span>
								<?php echo get_currency_price($TPL_V2["price"]*$TPL_V2["ea"],null,'','<strong class="out_suboption_price">_str_price_</strong>')?>

								<img src="/data/skin/responsive_diary_petit_gl_1/images/common/icon_close_gray.png" class="removeOption" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9pY29uX2Nsb3NlX2dyYXkucG5n' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL2dvb2RzL19zZWxlY3Rfb3B0aW9ucy5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2NvbW1vbi9pY29uX2Nsb3NlX2dyYXkucG5n' designElement='image' />
							</li>
						</ul>
					</td>
				</tr>
<?php }}?>
<?php }}?>
<?php }?>
			</table>
		</div>
<?php }?>
		<!-- 선택된 옵션 노출 영역 끝 -->
	</div>
</div>