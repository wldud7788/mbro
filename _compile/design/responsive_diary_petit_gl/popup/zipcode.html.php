<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/popup/zipcode.html 000031711 */ 
$TPL__GET_1=empty($_GET)||!is_array($_GET)?0:count($_GET);
$TPL_arrSido_1=empty($TPL_VAR["arrSido"])||!is_array($TPL_VAR["arrSido"])?0:count($TPL_VAR["arrSido"]);
$TPL_arrSigungu_1=empty($TPL_VAR["arrSigungu"])||!is_array($TPL_VAR["arrSigungu"])?0:count($TPL_VAR["arrSigungu"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 주소찾기 - 콘텐츠 @@
- 파일위치 : [스킨폴더]/popup/zipcode.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript">
var params = {
	'address' : '<?php echo $_GET["address"]?>',
	'address_street' : '<?php echo $_GET["address_street"]?>',
	'address_detail' : '<?php echo $_GET["address_detail"]?>',
	'zipcode' : '<?php echo $_GET["zipcode"]?>',
	'new_zipcode' : '<?php echo $_GET["new_zipcode"]?>'
};

function getZipcodeResult(page){
	$("input[name='page']").val(page);$("#zipForm").submit();
}

function getZipcodeResultgo(zipcode_type,page){
	// $("select[name='SIDO'] option[value='']").attr("selected",true);
	// $("select[name='SIGUNGU'] option[value='']").attr("selected",true);
	$("input[name='zipcode_type']").val(zipcode_type);
	$("input[name='page']").val(page);
	$("#zipForm").submit();
}

function getZipcodeTab(zipcode_type,page){
	$("select[name='SIDO'] option[value='']").attr("selected",true);
	$("select[name='SIGUNGU'] option[value='']").attr("selected",true);
	$("input[name='zipcode_keyword']").val('');
	$("input[name='zipcode_type']").val(zipcode_type);
	$("input[name='page']").val(page);
	$("#zipForm").submit();
}

function enterchk(){
	if(event.keyCode==13){
		getZipcodeResult(1);
		event.returnValue=false;
		return;
	}
}

function choice_zipcode(obj_tr) {
	if(opener != null ) {
		var winobj = opener.document;
	}else{
		var winobj = parent.document;
	}

	obj_tr = $(obj_tr);
	var zip = obj_tr.find(".zipcode_number").html();
	var zipArr = zip.split('-');
	if(zip.length == 5){
		zipArr[0] = zip.substring(0,3);
		zipArr[1] = zip.substring(3,5);
	}
	
	zip = zip.replace("-", "");
	if(params.address){
		if('<?php echo $_GET["mtype"]?>'=='order_multi' || '<?php echo $TPL_VAR["zipcodeFlag"]?>'=='order_multi'){
			choice_order_multi(obj_tr,zipArr,zip,winobj);
		}else if('<?php echo $_GET["mtype"]?>'=='order_multi_view' || '<?php echo $TPL_VAR["zipcodeFlag"]?>'=='order_multi_view'){
			choice_order_multi_view(obj_tr,zipArr,zip,winobj);
		}else{
			choice_params_address(obj_tr,zipArr,zip,winobj);
		}
		try{parent.order_price_calculate();}catch(e){};
		try{opener.order_price_calculate();}catch(e){};
	}else{
		if('<?php echo $_GET["mtype"]?>'=='order_info' || '<?php echo $TPL_VAR["zipcodeFlag"]?>'=='order_info'){
			choice_order_info(obj_tr,zipArr,zip,winobj);
		}else if('<?php echo $_GET["mtype"]?>'=='order' || '<?php echo $TPL_VAR["zipcodeFlag"]?>'=='order'){
			choice_order(obj_tr,zipArr,zip,winobj);
		}else if('<?php echo $_GET["mtype"]?>'=='morder' || '<?php echo $TPL_VAR["zipcodeFlag"]?>'=='morder'){
			choice_morder(obj_tr,zipArr,zip,winobj);
		}else if('<?php echo $_GET["mtype"]?>'=='delivery' || '<?php echo $TPL_VAR["zipcodeFlag"]?>'=='delivery'){//3
			choice_delivery(obj_tr,zipArr,zip,winobj);
		}else if('<?php echo $_GET["mtype"]?>'=='business' || '<?php echo $TPL_VAR["zipcodeFlag"]?>'=='business'){//4
			choice_business(obj_tr,zipArr,zip,winobj);
		}else if('<?php echo $_GET["mtype"]?>'=='member' || '<?php echo $TPL_VAR["zipcodeFlag"]?>'=='member'){//5
			choice_member(obj_tr,zipArr,zip,winobj);
		}else if('<?php echo $_GET["mtype"]?>'=='sender' || '<?php echo $TPL_VAR["zipcodeFlag"]?>'=='sender'){//6
			choice_sender(obj_tr,zipArr,zip,winobj);
		}else if('<?php echo $_GET["mtype"]?>'=='co_' || '<?php echo $TPL_VAR["zipcodeFlag"]?>'=='co_'){//7
			choice_co(obj_tr,zipArr,zip,winobj);
		}else{//8
			choice_mtype(obj_tr,zipArr,zip,winobj);
		}
	}

	if(opener != null ) { // 새창으로 띄우는 경우
		//opener.$("#<?php echo $TPL_VAR["zipcodeFlag"]?>BgId").remove();
		//opener.$("#<?php echo $TPL_VAR["zipcodeFlag"]?>Id").remove();
		opener.removeCenterLayer('#<?php echo $TPL_VAR["zipcodeFlag"]?>zipId');
		self.close();
	}else{ // 레이어로 띄우는 경우
		//parent.$("#<?php echo $TPL_VAR["zipcodeFlag"]?>BgId").remove();
		//parent.$("#<?php echo $TPL_VAR["zipcodeFlag"]?>Id").remove();
		parent.removeCenterLayer('#<?php echo $TPL_VAR["zipcodeFlag"]?>zipId');
	}
	//self.close();
}

function choice_order_multi(obj_tr,zipArr,zip,winobj)
{
	$("input[name='multi_recipient_address_type[]']",$(".multiShippingItem[multiShippingItemNo='<?php echo $_GET["multiIdx"]?>']",winobj)).val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
	if( eval("$('input[name=multi_recipient_address_type[]]',winobj).val()") ) {
<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>
		$("input[name='multi_recipient_address[]']",$(".multiShippingItem[multiShippingItemNo='<?php echo $_GET["multiIdx"]?>']"),winobj).val( obj_tr.find(".address").html() ).hide();
		$("input[name='multi_recipient_address_street[]']",$(".multiShippingItem[multiShippingItemNo='<?php echo $_GET["multiIdx"]?>']"),winobj).val( obj_tr.find(".address_street").html() ).show();
<?php }else{?>
		$("input[name='multi_recipient_address[]']",$(".multiShippingItem[multiShippingItemNo='<?php echo $_GET["multiIdx"]?>']"),winobj).val( obj_tr.find(".address").html() ).show();
		$("input[name='multi_recipient_address_street[]']",$(".multiShippingItem[multiShippingItemNo='<?php echo $_GET["multiIdx"]?>']"),winobj).val( obj_tr.find(".address_street").html() ).hide();
<?php }?>
	}else{
		$("input[name='multi_recipient_address[]']",$(".multiShippingItem[multiShippingItemNo='<?php echo $_GET["multiIdx"]?>']"),winobj).val( obj_tr.find(".address").html() );
	}
	if($("input[name='multi_recipient_zipcode[0][]']").length == 2){
		$("input[name='multi_recipient_zipcode[0][]']",$(".multiShippingItem[multiShippingItemNo='<?php echo $_GET["multiIdx"]?>']"),winobj).val(zipArr[0]);
		$("input[name='multi_recipient_zipcode[1][]']",$(".multiShippingItem[multiShippingItemNo='<?php echo $_GET["multiIdx"]?>']"),winobj).val(zipArr[1]);
	}else{
		$("input[name='multi_recipient_zipcode[0][]']",$(".multiShippingItem[multiShippingItemNo='<?php echo $_GET["multiIdx"]?>']"),winobj).val(zip);
	}
	$("input[name='multi_recipient_address_detail[]']",$(".multiShippingItem[multiShippingItemNo='<?php echo $_GET["multiIdx"]?>']"),winobj).focus();
}

function choice_order_multi_view(obj_tr,zipArr,zip,winobj){
	$("input[name='recipient_address_type']",$(".multiShippingItem").eq(),winobj).val( "<?php echo $TPL_VAR["zipcode_type"]?>" )

	if( eval("$('input[name=recipient_address_type]',winobj).val()") ) {
<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>
		$("input[name='recipient_address']",$(".multiShippingItem").eq(),winobj).val( obj_tr.find(".address").html() ).hide();
		$("input[name='recipient_address_street']",$(".multiShippingItem").eq(),winobj).val( obj_tr.find(".address_street").html() ).show();
<?php }else{?>
		$("input[name='recipient_address']",$(".multiShippingItem").eq(),winobj).val( obj_tr.find(".address").html() ).show();
		$("input[name='recipient_address_street']",$(".multiShippingItem").eq(),winobj).val( obj_tr.find(".address_street").html() ).hide();
<?php }?>
	}else{
		$("input[name='recipient_address']",$(".multiShippingItem").eq(),winobj).val( $(this).find(".address").html() );
	}
	if($("input[name='recipient_zipcode[]']",$(".multiShippingItem").eq(),winobj).length == 2){
		$("input[name='recipient_zipcode[]']",$(".multiShippingItem").eq(),winobj).eq(0).val(zipArr[0]);
		$("input[name='recipient_zipcode[]']",$(".multiShippingItem").eq(),winobj).eq(1).val(zipArr[1]);
	}else{
		$("input[name='recipient_zipcode[]']",$(".multiShippingItem").eq(),winobj).eq(0).val(zip);
	}
	$("input[name='recipient_address_detail']",$(".multiShippingItem").eq(),winobj).focus();
}

function choice_params_address(obj_tr,zipArr,zip,winobj)
{
	$("input[name='"+params.address+"_type']",winobj).val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
	if( eval("$(\"input[name='"+params.address+"_type']\",winobj).val()") ) {
<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>
		$("input[name='"+params.address+"']",winobj).val( obj_tr.find(".address").html() ).hide();
		$("input[name='"+params.address_street+"']",winobj).val( obj_tr.find(".address_street").html() ).show();
<?php }else{?>
		$("input[name='"+params.address+"']",winobj).val( obj_tr.find(".address").html() ).show();
		$("input[name='"+params.address_street+"']",winobj).val( obj_tr.find(".address_street").html() ).hide();
<?php }?>
	}else{
		$("input[name='"+params.address+"']",winobj).val( obj_tr.find(".address").html() );
	}
	if($("input[name='"+params.zipcode+"']",winobj).length == 2){
		$("input[name='"+params.zipcode+"']",winobj).eq(0).val(zipArr[0]);
		$("input[name='"+params.zipcode+"']",winobj).eq(1).val(zipArr[1]);
	}else{
		$("input[name='"+params.new_zipcode+"']",winobj).eq(0).val(zip);
	}
	$("input[name='"+params.address_detail+"']",winobj).focus();
}

function choice_order_info(obj_tr,zipArr,zip,winobj)
{
	$("input[name='order_address_type']", winobj).val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
	$("input[name='order_address']", winobj).val( obj_tr.find(".address").html() );
	$("input[name='order_address_street']", winobj).val( obj_tr.find(".address_street").html() );
	if($("input[name='order_zipcode[]']", winobj).length == 2){
		$("input[name='order_zipcode[]']", winobj).eq(0).val(zipArr[0]);
		$("input[name='order_zipcode[]']", winobj).eq(1).val(zipArr[1]);
	}else{
		$("input[name='order_new_zipcode']", winobj).eq(0).val(zip);
	}
	$("input[name='order_address_detail']", winobj).focus();
}

function choice_order(obj_tr,zipArr,zip,winobj)
{
	$("input[name='recipient_address_type']", winobj).val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
	if( eval("$('input[name=recipient_address_type]', winobj).val()") ) {
<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>
		$("input[name='recipient_address']", winobj).val( obj_tr.find(".address").html() ).hide();
		$("input[name='recipient_address_street']", winobj).val( obj_tr.find(".address_street").html() ).show();
<?php }else{?>
		$("input[name='recipient_address']", winobj).val( obj_tr.find(".address").html() ).show();
		$("input[name='recipient_address_street']", winobj).val( obj_tr.find(".address_street").html() ).hide();
<?php }?>
	}else{
		$("input[name='recipient_address']", winobj).val( obj_tr.find(".address").html() );
	}
	if($("input[name='recipient_zipcode[]']", winobj).length == 2){
		$("input[name='recipient_zipcode[]']", winobj).eq(0).val(zipArr[0]);
		$("input[name='recipient_zipcode[]']", winobj).eq(1).val(zipArr[1]);
	}else{
		$("input[name='recipient_new_zipcode']", winobj).eq(0).val(zip);
	}
	$("input[name='recipient_address_detail']", winobj).focus();
	try{parent.order_price_calculate();}catch(e){};
	try{opener.order_price_calculate();}catch(e){};
}
function choice_morder(obj_tr,zipArr,zip,winobj)
{
	$("input[name='recipient_input_address_type']", winobj).val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
	if( eval("$('input[name=recipient_input_address_type]', winobj).val()") ) {
<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>
		$("input[name='recipient_input_address']", winobj).val( obj_tr.find(".address").html() ).hide();
		$("input[name='recipient_input_address_street']", winobj).val( obj_tr.find(".address_street").html() ).show();
<?php }else{?>
		$("input[name='recipient_input_address']", winobj).val( obj_tr.find(".address").html() ).show();
		$("input[name='recipient_input_address_street']", winobj).val( obj_tr.find(".address_street").html() ).hide();
<?php }?>
	}else{
		$("input[name='recipient_input_address']", winobj).val( obj_tr.find(".address").html() );
		if(typeof $("input[name='recipient_input_address_street']", winobj) != "undefind"){
			$("input[name='recipient_input_address_street']", winobj).val( obj_tr.find(".address_street").html());
		}
	}
	if($("input[name='recipient_input_zipcode[]']", winobj).length == 2){
		$("input[name='recipient_input_zipcode[]']", winobj).eq(0).val(zipArr[0]);
		$("input[name='recipient_input_zipcode[]']", winobj).eq(1).val(zipArr[1]);
	}else{
		$("input[name='recipient_input_new_zipcode']", winobj).eq(0).val(zip);
	}
	$("input[name='recipient_input_address_detail']", winobj).focus();
	try{parent.order_price_calculate();}catch(e){};
	try{opener.order_price_calculate();}catch(e){};
}
function choice_delivery(obj_tr,zipArr,zip,winobj)
{
	$("input[name='recipient_address_type']",winobj).val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
	$("input[name='recipient_address']",winobj).val( obj_tr.find(".address").html() );
	$("input[name='recipient_address_street']",winobj).val( obj_tr.find(".address_street").html() );
	if($("input[name='recipient_zipcode[]']",winobj).length == 2){
		$("input[name='recipient_zipcode[]']",winobj).eq(0).val(zipArr[0]);
		$("input[name='recipient_zipcode[]']",winobj).eq(1).val(zipArr[1]);
	}else{
		$("input[name='recipient_new_zipcode']",winobj).eq(0).val(zip);
	}
	$("input[name='recipient_address_detail']",winobj).focus();
}
function choice_business(obj_tr,zipArr,zip,winobj)
{
	$("input[name='baddress_type']",winobj).val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
	if( eval("$('input[name=baddress_type]',winobj).val()") ) {
<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>
		$("input[name='baddress']",winobj).val( obj_tr.find(".address").html() ).hide();
		$("input[name='baddress_street']",winobj).val( obj_tr.find(".address_street").html() ).show();
<?php }else{?>
		$("input[name='baddress']",winobj).val( obj_tr.find(".address").html() ).show();
		$("input[name='baddress_street']",winobj).val( obj_tr.find(".address_street").html() ).hide();
<?php }?>
	}else{
		$("input[name='baddress']",winobj).val( obj_tr.find(".address").html() );
	}
	if($("input[name='bzipcode[]']",winobj).length == 2){
		$("input[name='bzipcode[]']",winobj).eq(0).val(zipArr[0]);
		$("input[name='bzipcode[]']",winobj).eq(1).val(zipArr[1]);
	}else{
		$("input[name='new_bzipcode']",winobj).eq(0).val(zip);
	}
	$("input[name='baddress_detail']", winobj).focus();
}
function choice_member(obj_tr,zipArr,zip,winobj)
{
	$("input[name='address_type']",winobj).val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
	if( eval("$('input[name=address_type]',winobj).val()") ) {
<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>
		$("input[name='address']",winobj).val( obj_tr.find(".address").html() ).hide();
		$("input[name='address_street']",winobj).val( obj_tr.find(".address_street").html() ).show();
<?php }else{?>
		$("input[name='address']",winobj).val( obj_tr.find(".address").html() ).show();
		$("input[name='address_street']",winobj).val( obj_tr.find(".address_street").html() ).hide();
<?php }?>
	}else{
		$("input[name='address']",winobj).val( obj_tr.find(".address").html() );
	}
	if($("input[name='zipcode[]']",winobj).length == 2){
		$("input[name='zipcode[]']",winobj).eq(0).val(zipArr[0]);
		$("input[name='zipcode[]']",winobj).eq(1).val(zipArr[1]);
	}else{
		$("input[name='new_zipcode']",winobj).eq(0).val(zip);
	}

	$("input[name='address_detail']", winobj).focus();
}
function choice_sender(obj_tr,zipArr,zip,winobj)
{
	$("input[name='senderAddress_type']",winobj).val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
	if( eval("$('input[name=senderAddress_type]',winobj).val()") ) {
<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>
		$("input[name='senderAddress']",winobj).val( obj_tr.find(".address").html() ).hide();
		$("input[name='senderAddress_street']",winobj).val( obj_tr.find(".address_street").html() ).show();
<?php }else{?>
		$("input[name='senderAddress']",winobj).val( obj_tr.find(".address").html() ).show();
		$("input[name='senderAddress_street']",winobj).val( obj_tr.find(".address_street").html() ).hide();
<?php }?>
	}else{
		$("input[name='senderAddress']",winobj).val( obj_tr.find(".address").html() );
	}
	if($("input[name='senderZipcode[]']",winobj).length == 2){
		$("input[name='senderZipcode[]']",winobj).eq(0).val(zipArr[0]);
		$("input[name='senderZipcode[]']",winobj).eq(1).val(zipArr[1]);
	}else{
		$("input[name='senderZipcode[]']",winobj).eq(0).val(zip);
	}

	$("input[name='senderAddressDetail']", winobj).focus();
}
function choice_co(obj_tr,zipArr,zip,winobj)
{
	$("input[name='co_address_type']",winobj).val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
	if( eval("$('input[name=co_address_type]',winobj).val()") ) {
<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>
		$("input[name='co_address']",winobj).val( obj_tr.find(".address").html() ).hide();
		$("input[name='co_address_street']",winobj).val( obj_tr.find(".address_street").html() ).show();
<?php }else{?>
		$("input[name='co_address']",winobj).val( obj_tr.find(".address").html() ).show();
		$("input[name='co_address_street']",winobj).val( obj_tr.find(".address_street").html() ).hide();
<?php }?>
	}else{
		$("input[name='co_address']",winobj).val( obj_tr.find(".address").html() );
	}
	if($("input[name='co_zipcode[]']",winobj).length == 2){
		$("input[name='co_zipcode[]']",winobj).eq(0).val(zipArr[0]);
		$("input[name='co_zipcode[]']",winobj).eq(1).val(zipArr[1]);
	}else{
		$("input[name='co_new_zipcode']",winobj).eq(0).val(zip);
	}

	$("input[name='co_address_detail']", winobj).focus();
}
function choice_mtype(obj_tr,zipArr,zip,winobj)
{
<?php if($_GET["mtype"]){?>
	$("input[name='<?php echo $_GET["mtype"]?>address_type']",winobj).val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
	if( eval("$(\"input[name='<?php echo $_GET["mtype"]?>address_type']\",winobj).val()") ) {
<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>
		$("input[name='<?php echo $_GET["mtype"]?>address']",winobj).val( obj_tr.find(".address").html() ).hide();
		$("input[name='<?php echo $_GET["mtype"]?>address_street']",winobj).val( obj_tr.find(".address_street").html() ).show();
<?php }else{?>
		$("input[name='<?php echo $_GET["mtype"]?>address']",winobj).val( obj_tr.find(".address").html() ).show();
		$("input[name='<?php echo $_GET["mtype"]?>address_street']",winobj).val( obj_tr.find(".address_street").html() ).hide();
<?php }?>
	}else{
		$("input[name='<?php echo $_GET["mtype"]?>address']",winobj).val( obj_tr.find(".address").html() );
	}
	if($("input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>zipcode[]']",winobj).length == 2){
		$("input[name='<?php echo $_GET["mtype"]?>zipcode[]']",winobj).eq(0).val(zipArr[0]);
		$("input[name='<?php echo $_GET["mtype"]?>zipcode[]']",winobj).eq(1).val(zipArr[1]);
	}else{
		$("input[name='<?php echo $_GET["mtype"]?>new_zipcode']",winobj).eq(1).val(zip);
	}
	$("input[name='<?php echo $_GET["mtype"]?>address_detail']", winobj).focus();
<?php }else{?>
	$("input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>address_type']",winobj).val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
	if( eval("$(\"input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>address_type']\",winobj).val()") ) {
<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>
		$("input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>address']",winobj).val( obj_tr.find(".address").html() ).hide();
		$("input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>address_street']",winobj).val( obj_tr.find(".address_street").html() ).show();
<?php }else{?>
		$("input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>address']",winobj).val( obj_tr.find(".address").html() ).show();
		$("input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>address_street']",winobj).val( obj_tr.find(".address_street").html() ).hide();
<?php }?>
	}else{
		$("input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>address']",winobj).val( obj_tr.find(".address").html() );
	}
	if($("input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>zipcode[]']",winobj).length == 2){
		$("input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>zipcode[]']",winobj).eq(0).val(zipArr[0]);
		$("input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>zipcode[]']",winobj).eq(1).val(zipArr[1]);
	}else{
		$("input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>new_zipcode']",winobj).eq(0).val(zip);
	}
	$("input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>address_detail']", winobj).focus();
<?php }?>
}


$(document).ready(function() {

	$(document).resize(function(){
	$('#<?php echo $TPL_VAR["zipcodeFlag"]?>contents_frame',parent.document).height($("#wrap").height()+40); // 높이값 보정( 반응형 )
	}).resize();

	$("select[name='SIGUNGU']").children("option[value!='']").remove();
	var SIGUNGU = "<?php echo $_GET["SIGUNGU"]?>";
<?php if($TPL_VAR["keyword"]){?>
	$.ajax({
		'url' : '/popup/zipcode_street_sigungu',
		'data' : $('#zipForm').serialize(),
		'dataType' : 'json',
		'success' : function(res){
			if(res){
				var options = "";
				for(var i=0;i<res.length;i++) options += "<option value='"+res[i].SIGUNGU+"'>"+res[i].SIGUNGU+"</option>";
				$("select[name='SIGUNGU']").append(options);
			}
			if(SIGUNGU) $("select[name='SIGUNGU'] option[value='"+SIGUNGU+"']").attr("selected",true);
		}
	});
<?php }?>

<?php if($TPL_VAR["zipcode_type"]=='street'){?>
	$(".sub_page_tab td").eq(0).click();
<?php }elseif($TPL_VAR["zipcode_type"]=='zibun'){?>
	$(".sub_page_tab td").eq(1).click();
<?php }elseif($TPL_VAR["zipcode_type"]=='oldzibun'){?>
	$(".sub_page_tab td").eq(2).click();
<?php }?>
	$(".sub_page_tab td").eq(0).bind("click",function(){
		getZipcodeTab('street',1);
	});
	$(".sub_page_tab td").eq(1).bind("click",function(){
		getZipcodeTab('zibun',1);
	});
	$(".sub_page_tab td").eq(2).bind("click",function(){
		getZipcodeTab('oldzibun',1);
	});
});
</script>

<div class="sub_page_tab_wrap">
	<table width="100%" class="sub_page_tab" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td <?php if(!$TPL_VAR["cfg_zipcode"]["street_zipcode_5"]){?>class="hide"<?php }?>>도로명/지번 <span class="addtxt">(<b>5</b>자리 우편번호)</span></td>
		<td <?php if(!$TPL_VAR["cfg_zipcode"]["street_zipcode_6"]){?>class="hide"<?php }?>>도로명/지번 <span class="addtxt">(<b>6</b>자리 우편번호)</span></td>
		<!-- (구)지번주소는 신청/결제, 주문배송내역에서 에러를 일으킴( 도로명 주소에 data 없을 시 에러 ) -- 도로명/지번으로 충분함
		<td <?php if(!$TPL_VAR["cfg_zipcode"]["old_zipcode_lot_number"]){?>class="hide"<?php }?>>(구)지번 <span class="addtxt">(<b>6</b>자리 우편번호)</span></td>
		-->
	</tr>
	</table>


	<div class="zipcode_search_contents">
		<form name="zipForm" id="zipForm" method="get">
<?php if($_GET["mtype"]){?>
			<input type="hidden" name="mtype" value="<?php echo $_GET["mtype"]?>">
<?php }?>
			<input type="hidden" name="zipcodeFlag" value="<?php echo $TPL_VAR["zipcodeFlag"]?>">
			<input type="hidden" name="zipcode_type" value="<?php echo $TPL_VAR["zipcode_type"]?>">
			<input type="hidden" name="page" value="<?php echo $TPL_VAR["page"]["nowpage"]?>">
			<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>">
			<input type="hidden" name="addtext" value="" class="hide">
<?php if($TPL__GET_1){foreach($_GET as $TPL_K1=>$TPL_V1){?>
<?php if(!in_array($TPL_K1,array('page','keyword','SIDO','SIGUNGU'))){?>
			<input type="hidden" name="<?php echo $TPL_K1?>" value="<?php echo $TPL_V1?>" />
<?php }?>
<?php }}?>

			<div class="inputbox_area">
				<input type="text" name="zipcode_keyword" value="<?php echo $TPL_VAR["keyword"]?>" class="zsfText" title="<?php if($TPL_VAR["zipcode_type"]=='oldzibun'){?>읍면동<?php }else{?>도로명주소<?php }?>" onkeydown="enterchk();" />
				<button type="button" id="zipcodeSearchButton" class="btn_resp size_b color2 zsfSubmit" onclick="getZipcodeResult(1);">검색</button>
			</div>

<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>
			<div class="search_ex_area">
				<b class="title">예)</b><br />
				'○○○길'이 있는 주소: <span class="ex_point">남부순환로123가길</span> <span class="addtext">(길이름은 공백없이 입력)</span><br />
				'○○○길'이 없는 주소: <span class="ex_point">남부순환로 8</span><br />
				건물명: <span class="ex_point">전쟁기념관, 스타타워</span><br />
				동이름: <span class="ex_point">삼평동 670, 암사동 480-1</span><br />
			</div>
<?php }elseif($TPL_VAR["zipcode_type"]=="oldzibun"){?>
			<div class="search_ex_area">
				동 이름을 입력하세요.<br />
				예) <span class="ex_point">압구정동</span>
			</div>
<?php }?>

			<h5 class="title_sub2 v2 Mt15 Pb0"><b class="Pt4 Pb4">주소 검색결과</b></h5>

<?php if(($TPL_VAR["keyword"]&&$TPL_VAR["arrSido"])||$_GET["SIDO"]){?>
			<div class="cont_type1">
				<ul>
					<li class="th size1">시도</li>
					<li class="td">:
						<select name="SIDO" id="SIDO" class="select_style1" onchange="getZipcodeResult('1');">
							<option value="">전체</option>
<?php if(!$TPL_VAR["arrSido"]){?>
							<option value="<?php echo $_GET["SIDO"]?>" selected><?php echo $_GET["SIDO"]?></option>
<?php }?>
<?php if($TPL_arrSido_1){foreach($TPL_VAR["arrSido"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["SIDO"]?>" <?php if($_GET["SIDO"]==$TPL_V1["SIDO"]){?>selected<?php }?>><?php echo $TPL_V1["SIDO"]?></option>
<?php }}?>
						</select>
					</li>
				</ul>
				<ul>
					<li class="th size1">시군구</li>
					<li class="td">:
						<select name="SIGUNGU" class="select_style1" onchange="getZipcodeResult('1');">
							<option value="">전체</option>
<?php if($TPL_arrSigungu_1){foreach($TPL_VAR["arrSigungu"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["SIGUNGU"]?>" <?php if($_GET["SIGUNGU"]==$TPL_V1["SIGUNGU"]){?>selected<?php }?>><?php echo $TPL_V1["SIGUNGU"]?></option>
<?php }}?>
						</select>
					</li>
				</ul>
			</div>
<?php }?>

		</form>
	</div>

	<!-- 도로명/지번( 5자리 ) -->
	<div class="sub_page_tab_contents Mt0" style="display:none;">
<?php if($TPL_VAR["loop"]){?>
		<ul class="list_01 zipcodeResult">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<li onclick="choice_zipcode(this);">
				<div class="zipcode_number"><?php echo $TPL_V1["ZIPCODE"]?></div>
				<div class="addr"><?php echo $TPL_V1["ADDRESS_STREET"]?></div><div class="address_street hide"><?php echo $TPL_V1["ADDRESS_STREET"]?></div>
				<div class="addr"><?php echo $TPL_V1["ADDRESS"]?></div><div class="address hide"><?php echo $TPL_V1["ADDRESS"]?></div>
			</li>
<?php }}?>
		</ul>
<?php }else{?>
		<div class="zipcode_result_area">
<?php if($TPL_VAR["keyword"]){?>
			<div class="zipcode_result_nodata">
				<p class="txt1">검색 결과가 없습니다.</p>
				<p class="txt2">
					주소가 검색되지 않는 경우는 행정안전부 새주소안내시스템<br>
					<a href="http://www.juso.go.kr" target="_blank" title="새창" hrefOri='aHR0cDovL3d3dy5qdXNvLmdvLmty' >http://www.juso.go.kr</a> 에서 확인하시기 바랍니다.
				</p>
			</div>
<?php }else{?>
			<div class="zipcode_no_keyword">
				주소를 검색해 주세요.
			</div>
<?php }?>
		</div>
<?php }?>
	</div>

	<!-- 도로명/지번( 6자리 ) -->
	<div class="sub_page_tab_contents Mt0">
<?php if($TPL_VAR["loop"]){?>
		<ul class="list_01 zipcodeResult">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<li onclick="choice_zipcode(this);">
				<div class="zipcode_number"><?php echo $TPL_V1["ZIPCODE"]?></div>
				<div class="addr"><?php echo $TPL_V1["ADDRESS_STREET"]?></div><div class="address_street hide"><?php echo $TPL_V1["ADDRESS_STREET"]?></div>
				<div class="addr"><?php echo $TPL_V1["ADDRESS"]?></div><div class="address hide"><?php echo $TPL_V1["ADDRESS"]?></div>
			</li>
<?php }}?>
		</ul>
<?php }else{?>
		<div class="zipcode_result_area">
<?php if($TPL_VAR["keyword"]){?>
			<div class="zipcode_result_nodata">
				<p class="txt1">검색 결과가 없습니다.</p>
				<p class="txt2">
					주소가 검색되지 않는 경우는 행정안전부 새주소안내시스템<br>
					<a href="http://www.juso.go.kr" target="_blank" title="새창" hrefOri='aHR0cDovL3d3dy5qdXNvLmdvLmty' >http://www.juso.go.kr</a> 에서 확인하시기 바랍니다.
				</p>
			</div>
<?php }else{?>
			<div class="zipcode_no_keyword">
				주소를 검색해 주세요.
			</div>
<?php }?>
		</div>
<?php }?>
	</div>

	<!-- (구)지번주소 -->
	<div class="sub_page_tab_contents Mt0">
<?php if($TPL_VAR["loop"]){?>
		<ul class="list_01 zipcodeResult">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<li onclick="choice_zipcode(this);">
				<div class="zipcode_number"><?php echo $TPL_V1["ZIPCODE"]?></div>
				<div class="addr"><?php echo $TPL_V1["ADDRESSVIEW"]?></div><div class="address hide"><?php echo $TPL_V1["ADDRESS"]?></div>
				<div class="addr"><?php echo $TPL_V1["ADDRESS_STREET"]?></div><div class="address_street hide"><?php echo $TPL_V1["ADDRESS_STREET"]?></div>
			</li>
<?php }}?>
		</ul>
<?php }else{?>
		<div class="zipcode_result_area">
<?php if($TPL_VAR["keyword"]){?>
			<div class="zipcode_result_nodata">
				<p class="txt1">검색 결과가 없습니다.</p>
				<p class="txt2">
					주소가 검색되지 않는 경우는 행정안전부 새주소안내시스템<br>
					<a href="http://www.juso.go.kr" target="_blank" title="새창" hrefOri='aHR0cDovL3d3dy5qdXNvLmdvLmty' >http://www.juso.go.kr</a> 에서 확인하시기 바랍니다.
				</p>
			</div>
<?php }else{?>
			<div class="zipcode_no_keyword">
				주소를 검색해 주세요.
			</div>
<?php }?>
		</div>
<?php }?>
	</div>

<?php if($TPL_VAR["page"]["totalpage"]> 1){?>
	<div class="paging_navigation_pop">
<?php if($TPL_VAR["page"]["first"]){?><a href="javascript:getZipcodeResultgo('<?php echo $TPL_VAR["zipcode_type"]?>','<?php echo $TPL_VAR["page"]["first"]?>');" class="first" hrefOri='amF2YXNjcmlwdDpnZXRaaXBjb2RlUmVzdWx0Z28o' ></a><?php }?>
<?php if($TPL_VAR["page"]["prev"]){?><a href="javascript:getZipcodeResultgo('<?php echo $TPL_VAR["zipcode_type"]?>','<?php echo $TPL_VAR["page"]["prev"]?>');" class="prev" hrefOri='amF2YXNjcmlwdDpnZXRaaXBjb2RlUmVzdWx0Z28o' ></a><?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
				<a href="javascript:getZipcodeResultgo('<?php echo $TPL_VAR["zipcode_type"]?>','<?php echo $TPL_V1?>');" class="on" hrefOri='amF2YXNjcmlwdDpnZXRaaXBjb2RlUmVzdWx0Z28o' ><b><?php echo $TPL_V1?></b></a>
<?php }else{?>
				<a href="javascript:getZipcodeResultgo('<?php echo $TPL_VAR["zipcode_type"]?>','<?php echo $TPL_V1?>');" hrefOri='amF2YXNjcmlwdDpnZXRaaXBjb2RlUmVzdWx0Z28o' ><?php echo $TPL_V1?></a>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?><a href="javascript:getZipcodeResultgo('<?php echo $TPL_VAR["zipcode_type"]?>','<?php echo $TPL_VAR["page"]["next"]?>');" class="next" hrefOri='amF2YXNjcmlwdDpnZXRaaXBjb2RlUmVzdWx0Z28o' ></a><?php }?>
<?php if($TPL_VAR["page"]["last"]){?><a href="javascript:getZipcodeResultgo('<?php echo $TPL_VAR["zipcode_type"]?>','<?php echo $TPL_VAR["page"]["last"]?>');" class="last" hrefOri='amF2YXNjcmlwdDpnZXRaaXBjb2RlUmVzdWx0Z28o' ></a><?php }?>
	</div>
<?php }?>
</div>