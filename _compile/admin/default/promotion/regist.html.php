<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/promotion/regist.html 000054349 */ 
$TPL_issuegoods_1=empty($TPL_VAR["issuegoods"])||!is_array($TPL_VAR["issuegoods"])?0:count($TPL_VAR["issuegoods"]);
$TPL_issuecategorys_1=empty($TPL_VAR["issuecategorys"])||!is_array($TPL_VAR["issuecategorys"])?0:count($TPL_VAR["issuecategorys"]);
$TPL_issuebrands_1=empty($TPL_VAR["issuebrands"])||!is_array($TPL_VAR["issuebrands"])?0:count($TPL_VAR["issuebrands"]);
$TPL_groups_1=empty($TPL_VAR["groups"])||!is_array($TPL_VAR["groups"])?0:count($TPL_VAR["groups"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<style>
	div .connectCategory { width:97%; float:left; cursor:hand; }
<?php if($TPL_VAR["promotion"]["promotion_img"]== 4&&$TPL_VAR["promotion"]["promotion_image4"]){?>
	.promotioncodeshow {position:relative; height:40px; width:600px; background:url('/data/promotion/<?php echo $TPL_VAR["promotion"]["promotion_image4"]?>');width:870px; height:40px; line-height:40px; text-align:center; font-size:16px; font-family:dotum; font-weight:bold; color:#fff; letter-spacing:-1px;}
<?php }else{?>
	.promotioncodeshow {position:relative; height:40px; width:600px; background:url('/data/promotion/promotion_skin_01.gif');width:870px; height:40px; line-height:40px; text-align:center; font-size:16px; font-family:dotum; font-weight:bold; color:#fff; letter-spacing:-1px;}
<?php }?>
	span.divcostper	{ color:red; }
	.selectedseller	{width:100%;text-align:left;overflow-x:hidden;}	
</style>
<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-font-decoration.js"></script>
<script type="text/javascript" src="/app/javascript/js/base64.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gCouponIssued.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gProviderSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gGoodsSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gCategorySelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/promotionRegist.js?mm=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">

var promotionData = $.parseJSON('<?php echo json_encode($TPL_VAR["promotionsJson"])?>');

	$(document).ready(function() {


		if(promotionData.promotion_seq && (promotionData.promotion_type == 'one' || promotionData.promotion_type == 'input')){

			$('#promotion_code_copy').click(function(){
				var promotion_input_serialnumber =  $(this).attr('promotion_input_serialnumber');
				clipboard_copy(promotion_input_serialnumber);
				alert("?????? ????????? ?????????????????????.\nCtrl+V??? ???????????? ?????????.");	
			});
					
		}

		$("input[name='maxPercentShippingSale']").focus(function(){
			chk_delivery_choice_box(1);
			$("#duplicationUse").attr("disabled","disabled");
			$(".duplicationUsetitle").addClass('gray');
			$(".duplicationuselay").addClass('gray');
			$("#saleType_shipping_free").attr('checked',true);
			$("#issueexceptlay").hide();
			//openSelectProvider('1');
		});

		$("input[name='wonShippingSale']").focus(function(){
			chk_delivery_choice_box(2);
			$("#duplicationUse").attr("disabled","disabled");
			$(".duplicationUsetitle").addClass('gray');
			$(".duplicationuselay").addClass('gray');
			$("#saleType_shipping_won").attr('checked',true);
			$("#issueexceptlay").hide();
			//openSelectProvider('1');
		});	
		
		
		$("input[name='form_type']").change(function()
		{			
			setDuplicationUse();
		
		});	
		
<?php if($TPL_VAR["promotion"]["promotion_seq"]){?>			
			setContentsRadio('form_type', "<?php if($TPL_VAR["promotion"]["type"]=='promotion'||$TPL_VAR["promotion"]["type"]=='admin'||$TPL_VAR["promotion"]["type"]=='point'){?>product<?php }else{?>shipping<?php }?>");
			setContentsRadio('code_type', "<?php if($TPL_VAR["promotion"]["type"]=='promotion'||$TPL_VAR["promotion"]["type"]=='promotion_shipping'){?>promotion<?php }else{?>disposable<?php }?>");			
			
<?php if($TPL_VAR["promotion"]["type"]=='point'||$TPL_VAR["promotion"]["type"]=='point_shipping'){?>
			setContentsRadio('promt_type', "point")
<?php }else{?> 
			setContentsRadio('promt_type', "admin")			
<?php }?>	
			
			console.log("<?php echo $TPL_VAR["promotion"]["issue_priod_type"]?>");
						
			setContentsRadio("promotion_type", "<?php echo $TPL_VAR["promotion"]["promotion_type"]?>");
			setContentsSelect("saleType", "<?php echo $TPL_VAR["promotion"]["sale_type"]?>");	
			setRadio("issuePriodType", "<?php if($TPL_VAR["promotion"]["issue_priod_type"]=='day'){?>day<?php }else{?>date<?php }?>")	
			
<?php if($TPL_VAR["promotion"]["type"]=='promotion'){?>
				$("input[name='issuePriodType'][value='date']").hide();				
<?php }?>			
			
			setRadio("downloadLimit_promotion", "<?php if($TPL_VAR["promotion"]["download_limit"]=='limit'){?>limit<?php }else{?><?php }?>")
			setContentsRadio('promotionImg', "<?php echo $TPL_VAR["promotion"]["promotion_img"]?>");
			setContentsRadio("issue_type", "<?php echo $TPL_VAR["promotion"]["issue_type"]?>");
			setContentsRadio("sales_tag", '<?php if($TPL_VAR["promotion"]["provider_name_list"]){?>provider<?php }else{?>admin<?php }?>');

			setContentsRadio("mainshow", "<?php echo $TPL_VAR["promotion"]["mainshow"]?>")
<?php }else{?>			
			setContentsRadio('form_type', "product");
			setContentsRadio('code_type', "promotion");
			setContentsRadio('promotionType', "admin");
			setContentsRadio('promt_type', "admin");
			
			setContentsRadio("promotion_type", "one");
			setRadio("issuePriodType", "date")
			$("input[name='issuePriodType'][value='date']").hide();		
			setRadio("downloadLimit_promotion", "")
			$("input[name='downloadLimitEa_promotion']").val("0");
			setContentsRadio('promotionImg', "1");
			setContentsSelect("saleType", "percent");	
			setContentsRadio("issue_type", "all");
			setContentsRadio("sales_tag", 'admin');
			setContentsRadio("mainshow", "0")
<?php }?>				

		$("input[name='promt_type']").change(function()
		{			
			if($(this).val()=="point")			
			{
				$(".member_limit").hide();
				$("input[name='promotionType']").val('point');
			}else{
				$(".member_limit").show();
				$("input[name='promotionType']").val('admin');
			}			
		});		

		$("input[name='code_type']").change(function()
		{				
			if($(this).val()=="promotion")
			{
				$("input[name='issuePriodType'][value='date']").hide();
				$("input[name='issuePriodType'][value='day']").parent().hide();
				$("#promotion_type1").val('one');
				$("#promotion_type2").val('input');	
				$("input[name='promotionType']").val('promotion');
				$("input[name='promotion_type'][value='one']").trigger('change');			
			}else{
				$("input[name='issuePriodType'][value='date']").show();
				$("input[name='issuePriodType'][value='day']").parent().show();
				$("#promotion_type1").val('random');
				$("#promotion_type2").val('file');
				$("input[name='promotionType']").val('admin');
				$("input[name='promotion_type'][value='random']").trigger('change');
			}

			$("input[name='issuePriodType'][value='date']").trigger('change');
			$("input[name='promt_type'][value='admin']").trigger('change');
			
			setDuplicationUse();				
		});			

		$(".promocodeallhtmlView").click(function()
		{
			var mode = $(this).attr("mode");
			var winHeight = 300;
			if(mode=="all") winHeight = 550;
			window.open('/admin/promotion/promotionpage_codeview?mode='+mode+'&no=<?php echo $TPL_VAR["promotion"]["promotion_seq"]?>', 'totalpromotioncodepopup', 'width=900px,height='+winHeight+'px,top=50,toolbar=no,location=no,resizable=yes,scrollbars=yes');			
		});	
		
		$("#setGroupsBtn").click(function()
		{
			groupsMsg()
		})

		setDuplicationUse();
	});
	
	//?????? ?????? ??????(??????&??????????????? ???????????? ??????)
	function setDuplicationUse(){		
		if($("input[name='form_type']:checked").val()=="product" && $("input[name='code_type']:checked").val()=="promotion" ){
			$(".duplicationUse_con").show();
		}else{
			$(".duplicationUse_con").hide();
		}		
	}

	function set_promotion_form(){
		$("form#promotionRegist input[name='promotionType']:checked").each(function(){
			$(".promotion, .point, .admin").hide();
			$("."+$(this).val()).show();

			if($(this).attr('checked') == 'checked' && $(this).val() == 'promotion') {
				$("#promotion_type1").val('one');
				$("#promotion_type2").val('input');
			}else{
				$("#promotion_type1").val('random');
				$("#promotion_type2").val('file');
			}
<?php if(!$TPL_VAR["promotion"]["promotion_seq"]){?>
				$("input:radio[name='issuePriodType']").eq(0).attr("checked","checked");
<?php }?>
		});
	}
	function set_goods_list(displayId,inputGoods){
		$.ajax({
			type: "get",
			url: "../goods/select_for_provider",
			url: "../goods/select",
			data: "page=1&goods_type=all&inputGoods="+inputGoods+"&displayId="+displayId+"&provider_list="+$("input[name='provider_seq_list']").val()+"&salescost="+$("input[name='salescost_provider']").val(),
			data: "page=1&inputGoods="+inputGoods+"&displayId="+displayId,
			success: function(result){
				$("div#"+displayId).html(result);
			}
		});
		openDialog("?????? ??????", displayId, {"width":"1000","height":"700","show" : "fade","hide" : "fade"});
	}
	function regist_category(targetCategory){
		$("div#categoryDialog input[name='targetCategory']").val(targetCategory);
		openDialog("???????????? ??????", "categoryDialog", {"width":900,"height":300});
	}


	function promotion_member_search(promotion_name){
		var no  = $("#write_no").val();
		addFormDialogSel('./download_member?no='+no, '1200px', '750', '?????? ?????? ');
	}

	function addFormDialogSel(url, width, height, title, btn_yn) {
		newcreateElementContainer(title);
		newrefreshTable(url);
		$('#dlg').dialog({
			bgiframe: true,
			autoOpen: false,
			width: width,
			height: height,
			resizable: false,
			draggable: false,
			modal: true,			
			buttons: [
				{
					text:"????????? ????????????",
					class : 'resp_btn active size_XL',
					click : function() {
						var str = "";
						var tag = "";
						var oldstr = $("#target_container").html();
						var target_member = $("#target_member").val();
						var checkedId = "input:checkbox[name$='member_chk[]']:checked";
						var idx = ($(checkedId).length);//???????????????
						var addnum = 0;
						if(idx > 0) {

							var downloadtotal = $("#downloadtotal").val();////?????? ????????????
							var download_limit_ea = $("#download_limit_ea").val();//????????????
							var member_search_count = parseInt($("#member_search_count").html());//??????????????????
							var download_limit = $("#download_limit").val();//??????????????????
							if(download_limit == 'limit'){
									var downloadtotal1 = parseInt(parseInt(downloadtotal)+parseInt(idx));
									var downloadtotal2 = parseInt(parseInt(downloadtotal1)+parseInt(member_search_count));
								if(idx > download_limit_ea ){
									alert("??? ?????? ????????? ?????????????????? ????????????("+download_limit_ea+")?????? ?????? ????????????("+idx+")??? ????????????!");
									return false;
								}else if(downloadtotal1 > download_limit_ea ){
									alert("??? ?????? ????????? ?????????????????? ????????????("+download_limit_ea+")?????? ??? ??????????????? ?????? ??????????????? ??????("+downloadtotal1+")??? ????????????!");
									return false;
								}else if(downloadtotal2 > download_limit_ea ){
									alert("??? ?????? ????????? ?????????????????? ????????????("+download_limit_ea+")?????? ??? ??????????????? ??? ??????????????? ??????("+downloadtotal2+")??? ????????????!");

									return false;
								}
							}

							$(checkedId).each(function(e, data) {
								if( memberselectck($(this).val()) == false ) {addnum++;
									str += $(this).attr("user_name")+'[' + $(this).attr("userid") + '] , ';
									tag += '['+$(this).val()+'],';
								}
							});
						}

						if(str){
							var msg = oldstr + " " + str;
							$("#target_container").html(msg);
							$("#target_member").val(target_member + tag)
							var newcheckedId = $("#target_member").val().split(',');
							$("#member_search_count").html((newcheckedId.length-1));
						}
						$(this).dialog('close');
					}
				},
				{
					text:"????????? ????????????",
					class : 'resp_btn active size_XL',
					click : function() {
						var queryString = $('#downloadsearch').formSerialize();
						$.ajax({
							type: 'post',
							url: '/admin/promotion_process/download_member_search_all',
							data: queryString,
							dataType: 'json',
							success: function(data) {
								var checkedId = "input:checkbox[name$='member_chk[]']:checked";
								var oldstr = $("#target_container").html();
								var target_member = $("#target_member").val();
								var addnum = 0;
								var str = "";
								var tag = "";

								var downloadtotal = $("#downloadtotal").val();////?????? ????????????
								var download_limit_ea = $("#download_limit_ea").val();//????????????
								var member_search_count = ($("#member_search_count").html());//??????????????????
								var download_limit = $("#download_limit").val();//??????????????????

								if(data.totalcnt>0) {
									for(i=0;i<data.totalcnt;i++) {
										var member_seq = data.searchallmember[i]['member_seq'];
										var userid = data.searchallmember[i]['userid'];
										var user_name = data.searchallmember[i]['user_name'];
										if( memberselectck(member_seq) == false ) {
											addnum++;
											str += user_name+'[' + userid + '] , ';
											tag += '['+member_seq+'],';
										}
									}
								}
								if(str){
									var msg = oldstr + " " + str;
									$("#target_container").html(msg);
									$("#target_member").val(target_member + tag)
									var newcheckedId = $("#target_member").val().split(',');
									$("#member_search_count").html((newcheckedId.length-1));
								}
							}
						});
						$(this).dialog('close');
					}
				},
				{
					text:"??????",
					class : 'resp_btn v3 size_XL',
					click: function() {
						$(this).dialog('close');
					}
				}
			]
		}).dialog('open');
		return false;
	}

	function groupsMsg(){
		var str = "";
		var tag = "";
		$("#groupsMsg").html("");
		
		$("input[type='checkbox'][name='memberGroup']:checked").each(function(){
			var clone = $(this).parent().clone();
			clone.find("input").remove();
			str += $(this).attr("groupName") + ' , ';
			tag += "<input type='hidden' name='memberGroups[]' value='"+$(this).val()+"'>";
			
		});

		if(str){
			var msg = str.substr(0,str.length-3) + tag;
			$("#groupsMsg").html(msg);
		}
	}


	//?????? ????????? ???????????? ??????????????? ??????
	function downloadmembergroup(newgroup) {
		var returns = false;
		var newcheckedId = "input[name$='download_memberGroups[]']";
		var newidx = ($(newcheckedId).length);
		if(newidx > 0) {
			$(newcheckedId).each(function(e, newdata) {
				if( parseInt(newgroup) == parseInt($(newdata).val()) ) {
					returns = true;
					return false;
				}
			});
		}else{
			returns = true;
		}
		return returns;
	}

	//?????? ?????? ????????????
	function offlineexcelsave(promotion_seq)
	{
		var promotion_name = $("#promotion_name").val();
		var filename = $("#promotion_file").val();
		addExcelFormDialog('./promotion_excel?filename='+ filename +'&no='+promotion_seq, '45%', '800', '['+promotion_name+'] ?????? ?????? ???????????? ','false',promotion_seq);
	}


	/**
	 * ???????????? ??????????????? ?????? ?????????.
	 * <pre>
	 * 1. createElementContainer ????????? ???????????? ?????? div ????????? ???????????? ?????? ??????????????? ????????? ???????????? ????????????.
	 * 2. refreshTable ????????? ???????????? ??????????????? ?????? ????????? ????????????.
	 * </pre>
	 * @param string url ????????? ??????
	 * @param int width ?????? ?????????
	 * @param int height ?????? ?????????
	 * @param string title ??????
	 * @param string btn_yn 'false'?????? ??????????????? ????????????.
	 */
	function addExcelFormDialog(url, width, height, title, btn_yn, promotion_seq) {
		newcreateElementContainer(title);
		newrefreshTable(url);

		if (btn_yn != 'false') {
			var buttons = {
				'??????': function() {
					$(this).dialog('close');
				},
				'????????????': function() {
					$('#form1').submit();
				}
			}
		}
		else if (btn_yn == 'close') {
			var buttons =  {
				'??????': function() {
					document.location.href='./regist?no='+promotion_seq;
				}
			}
		}

		$('#dlg').dialog({
			bgiframe: true,
			autoOpen: false,
			width: width,
			height: height,
			resizable: false,
			draggable: false,
			modal: true,
			overlay: {
				backgroundColor: '#000000',
				opacity: 0.8
			},
			buttons: buttons,
			open: function() {
					$("#ui-datepicker-div").css("z-index",
					$(this).parents(".ui-dialog").css("z-index")+1);
			},
			close: function() {
				document.location.href='./regist?no='+promotion_seq;
			}
		}).dialog('open');
		return false;
	}

	function chk_delivery_choice_box(type) {
		if (type==1) {
			$(".box_choice1").show();
			$(".box_choice2").hide();
		} else {
			$(".box_choice1").hide();
			$(".box_choice2").show();
		}
	}
</script>

<?php if($TPL_VAR["promotion"]["promotion_seq"]){?>
<form name="promotionRegist" id="promotionRegist" method="post" enctype="multipart/form-data" action="../promotion_process/promotion_modify" target="actionFrame">
<input type="hidden" name="promotionSeq" value="<?php echo $TPL_VAR["promotion"]["promotion_seq"]?>" />
<?php }else{?>
<form name="promotionRegist" id="promotionRegist" method="post" enctype="multipart/form-data" action="../promotion_process/promotion" target="actionFrame">
<?php }?>

<!-- ????????? ????????? ??? : ?????? -->
<div id="page-title-bar-area"  class="gray-bar">
	<div id="page-title-bar">
		<!-- ?????? ?????? -->
		<ul class="page-buttons-left">
			<li><button type="button" onclick="document.location.href='../promotion/catalog';" class="resp_btn v3 size_L">????????? ????????????</button></li>
		</ul>

		<!-- ????????? -->
		<div class="page-title">
			<h2>?????? ?????? <?php if($TPL_VAR["promotion"]["promotion_seq"]){?>??????<?php }else{?>??????<?php }?> </h2>
		</div>
		
		<!-- ?????? ?????? -->
<?php if($TPL_VAR["promotion"]["downloadtotal"]< 1){?>
		<ul class="page-buttons-right">			
<?php if(serviceLimit('H_FR')){?>
			<li><input type="button" onclick="serviceUpgrade();" class="resp_btn v8" value="???????????????"></li>
			<li><button type="button" class="resp_btn active2 size_L">??????</button></li>
<?php }else{?>				
			<li><button type="submit" class="resp_btn active2 size_L">??????</button></li>
<?php }?>
		</ul>
<?php }?>
	</div>
</div>

<div class="contents_container">	
<?php if($TPL_VAR["promotion"]["promotion_seq"]){?>
	<div class="item-title">?????? ?????? ??????</div>	
	<table class="table_basic thl">	
<?php if($TPL_VAR["promotion"]["downloadtotal"]< 1&&$TPL_VAR["adminissuebtn"]){?>		
		<tr>
			<th>?????? ?????? ??????</th>
			<td>			
				<button type="button" class="resp_btn active" onClick="gCouponIssued.open({'issued_type':'promotion','issued_seq':'<?php echo $TPL_VAR["promotion"]["promotion_seq"]?>','download_limit':'<?php echo $TPL_VAR["promotion"]["download_limit"]?>','divSelectLay':'lay_promotion_issued'})">??????</button>				
			</td>
		</tr>	
<?php }?>
<?php if($TPL_VAR["promotionNo"]){?>
		<tr>
			<th>????????????</th>
			<td>
				?????? <?php echo $TPL_VAR["promotion"]["downloadtotalbtn"]?> ??? / ?????? <?php echo $TPL_VAR["promotion"]["usetotalbtn"]?> ???
				<input type="button" class="downloadlist_btn resp_btn v2" promotion_seq="<?php echo $TPL_VAR["promotion"]["promotion_seq"]?>" promotion_name="<?php echo $TPL_VAR["promotion"]["promotion_name"]?>" value="??????" />			
			</td>
		</tr>
<?php }?>
	</table>	
<?php }?>

	<div class="item-title">?????? ??????</div>
	
	<table class="table_basic thl">		
		<tr>
			<th>?????? ??????</th>
			<td>
<?php if($TPL_VAR["promotion"]["promotion_seq"]){?>
<?php if($TPL_VAR["promotion"]["type"]=='promotion'||$TPL_VAR["promotion"]["type"]=='admin'||$TPL_VAR["promotion"]["type"]=='point'){?>
						??????					
<?php }else{?>
						?????????						
<?php }?>

					<input type="radio" name="form_type" value="product" class="hide" /> 
					<input type="radio" name="form_type" value="shipping" class="hide" />
<?php }else{?>
					<div class="resp_radio">					
						<label><input type="radio" name="form_type" value="product" checked /> ??????</label>
						<label><input type="radio" name="form_type" value="shipping" /> ?????????</label>				
					</div>
<?php }?>				
			</td>
		</tr>

		<tr>
			<th>?????? ?????? ??????</th>
			<td>
<?php if($TPL_VAR["promotion"]["promotion_seq"]){?>
<?php if($TPL_VAR["promotion"]["type"]=='promotion'||$TPL_VAR["promotion"]["type"]=='promotion_shipping'){?>
						?????? ??????						
<?php }elseif($TPL_VAR["promotion"]["type"]=='admin'||$TPL_VAR["promotion"]["type"]=='point'||$TPL_VAR["promotion"]["type"]=='admin_shipping'||$TPL_VAR["promotion"]["type"]=='point_shipping'){?>
						1?????? ??????						
<?php }?>

					<input type="radio" name="code_type" value="promotion" class="hide"/>
					<input type="radio" name="code_type" value="disposable" class="hide"/>
<?php }else{?>
					<div class="resp_radio">
						<label><input type="radio" name="code_type" value="promotion" checked/> ?????? ??????</label>
						<label><input type="radio" name="code_type" value="disposable"/> 1?????? ??????</label>						
					</div>
<?php }?>

				<input type="hidden" name="promotionType" value="<?php if($TPL_VAR["promotion"]["type"]=='point_shipping'||$TPL_VAR["promotion"]["type"]=='point'){?>point<?php }elseif($TPL_VAR["promotion"]["type"]=='admin_shipping'||$TPL_VAR["promotion"]["type"]=='admin'){?>admin<?php }else{?>promotion<?php }?>" />				
			</td>
		</tr>

		<tr class="code_type_disposable hide">
			<th>?????? ??????</th>
			<td>
<?php if($TPL_VAR["promotion"]["promotion_seq"]){?>
<?php if($TPL_VAR["promotion"]["type"]=='admin'||$TPL_VAR["promotion"]["type"]=='admin_shipping'){?>
						?????? ?????? ??????						
<?php }elseif($TPL_VAR["promotion"]["type"]=='point'||$TPL_VAR["promotion"]["type"]=='point_shipping'){?>
						????????? ??????						
<?php }?>

					<input type="radio" name="promt_type" value="admin" class="hide"/>
					<input type="radio" name="promt_type" value="point" class="hide"/> 
<?php }else{?>
					<div class="resp_radio">					
						<label><input type="radio" name="promt_type" value="admin" checked/> ?????? ?????? ??????</label>
						<label><input type="radio" name="promt_type" value="point" /> ????????? ??????</label>				
					</div>
<?php }?>
				
			</td>
		</tr>		

		<tr>
			<th>?????? ????????? <span class="required_chk"></span></th>
			<td>				
<?php if($TPL_VAR["promotion"]["downloadtotal"]> 0){?>
				<?php echo $TPL_VAR["promotion"]["promotion_name"]?>

<?php }else{?>
				<div class="resp_limit_text limitTextEvent">
					<input type="text" class="resp_text" size="70"  maxlength="30" name="promotionName" id="promotion_name" value="<?php echo $TPL_VAR["promotion"]["promotion_name"]?>" />
				</div>
<?php }?>			
			</td>
		</tr>

		<tr>
			<th>?????? ?????? ??????</th>
			<td>				
<?php if($TPL_VAR["promotion"]["downloadtotal"]> 0){?>
				<?php echo $TPL_VAR["promotion"]["promotion_desc"]?>

<?php }else{?>
				<div class="resp_limit_text limitTextEvent">
					<input type="text" class="resp_text" size="70" maxlength="50" name="promotionDesc" value="<?php echo $TPL_VAR["promotion"]["promotion_desc"]?>" />
				</div>
<?php }?>
			</td>
		</tr>
	</table>

	<div class="item-title promt_type_point hide">?????? ?????????</div>
	
	<table class="table_basic thl promt_type_point hide">		
		<tr>
			<th>?????? ????????? <span class="required_chk"></span></th>
			<td>				
				<input type="text" name="promotion_point" size="8" class="resp_text <?php echo $TPL_VAR["only_numberic_type"]?>" value="<?php echo get_currency_price($TPL_VAR["promotion"]["promotion_point"], 1)?>" /> P??? ?????? ????????? ??????
			</td>
		</tr>
	</table>

<?php if(serviceLimit('H_AD')){?>

	<div class="item-title">?????? ?????? ??????</div>

	<table class="table_basic thl t_discount_seller_type">		
		<tr>
			<th>??????</th>
			<td>				
				<div class="resp_radio">
					<label><input type="radio" name="sales_tag" id="" value="admin" <?php if($TPL_VAR["referer"]["provider_name_list"]==""){?>checked<?php }?>/> ?????? ??????</label>
					<label><input type="radio" name="sales_tag" id="" value="provider" <?php if($TPL_VAR["referer"]["provider_name_list"]){?>checked<?php }?>  /> ????????? ??????</label>			
				</div>	
			</td>
		</tr>

		<tr class="sales_tag_provider hide provider">
			<th>????????? ?????? <span class="required_chk"></span></th>
			<td>
				<input type="button" value="????????? ??????" class="btn_provider_select resp_btn active" /></span>			
				
				<div class="mt10 wx500">
					<div class="provider_list_header">
						<table class="table_basic tdc">
						<colgroup>
							<col width="40%" />
							<col width="40%" />
							<col width="20%" />
						</colgroup>
						<thead>
							<tr class="nodrag nodrop">
								<th>????????????</th>
								<th>?????? ??????</th>		
								<th>??????</th>	
							</tr>
						</thead>
						</table>
					</div>
					<div class="provider_list">
						<table class="table_basic fix">
							<colgroup>
								<col width="40%" />
								<col width="40%" />
								<col width="20%" />
							</colgroup>
							<tbody>
								<tr rownum=0 <?php if(count($TPL_VAR["promotion"]["provider_name_list"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
									<td class="center" colspan="3">???????????? ???????????????</td>
								</tr>
<?php if(is_array($TPL_R1=$TPL_VAR["promotion"]["provider_name_list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<tr rownum="<?php echo $TPL_V1["provider_seq"]?>">
								<td class="center"><?php echo $TPL_V1["provider_name"]?></td>
								<td class="center"><?php echo $TPL_V1["commission_text"]?></td>
								<td class="center">
									<input type="hidden" name="salescost_provider_list[]" value="<?php echo $TPL_V1["provider_seq"]?>">
									<button type="button" class="btn_minus" selectType="provider" seq="<?php echo $TPL_V1["provider_seq"]?>" onClick="gGoodsSelect.select_delete('minus',$(this))"></button>
								</td>
							</tr>
<?php }}?>
							</tbody>
						</table>
					</div>
				</div>
				<input type="hidden" name="provider_seq_list" value="<?php echo $TPL_VAR["promotion"]["provider_list"]?>" />
			</td>
		</tr>

		<tr class=" sales_tag_provider hide">
			<th>????????? ????????? <span class="required_chk"></span></th>
			<td>
				<input type="text" name="salescostper" size="3" maxlength="3" value="<?php if($TPL_VAR["promotion"]["promotion_seq"]> 0&&$TPL_VAR["promotion"]["provider_name_list"]){?><?php echo $TPL_VAR["promotion"]["salescost_provider"]?><?php }else{?>0<?php }?>" class="line onlynumber right" /> %
				<span class="desc red msg"></span>
				<input type="hidden" name="salescost_provider" value="<?php if($TPL_VAR["promotion"]["promotion_seq"]> 0&&$TPL_VAR["promotion"]["provider_name_list"]){?><?php echo $TPL_VAR["promotion"]["salescost_provider"]?><?php }else{?>0<?php }?>" />
			</td>
		</tr>

		<tr class="sales_admin">
			<th>?????? ?????????</th>
			<td>
				<span class="percent"><?php if($TPL_VAR["promotion"]["promotion_seq"]> 0&&$TPL_VAR["promotion"]["provider_name_list"]){?><?php echo $TPL_VAR["promotion"]["salescost_admin"]?><?php }else{?>100<?php }?>%</span>
				<input type="hidden" name="salescost_admin" value="<?php if($TPL_VAR["promotion"]["promotion_seq"]> 0&&$TPL_VAR["promotion"]["provider_name_list"]){?><?php echo $TPL_VAR["promotion"]["salescost_admin"]?><?php }else{?>100<?php }?>" />		
			</td>
		</tr>
	</table>
	<div class="resp_message">- ?????? ????????? ?????? ?????? <a href="https://www.firstmall.kr/customer/faq/1240 " class="resp_btn_txt" target="_blank">????????? ??????</a>
<?php }?>
	
	
	<div class="item-title">?????? ?????? <span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip6')"></span></div>
	
	<table class="table_basic thl">		
		<tr>
			<th>?????? <span class="required_chk"></span></th>
			<td>			
				<div class="form_type_product hide">							
					<input type="text" name="percentGoodsSale" size="8" maxlength="2" class="resp_text onlynumber right saleType_percent hide" value="<?php if($TPL_VAR["promotion"]["percent_goods_sale"]){?><?php echo $TPL_VAR["promotion"]["percent_goods_sale"]?><?php }else{?>0<?php }?>" />

					<input type="text" name="wonGoodsSale" size="8" class="resp_text <?php echo $TPL_VAR["only_numberic_type"]?> right saleType_won" value="<?php if($TPL_VAR["promotion"]["won_goods_sale"]){?><?php echo $TPL_VAR["promotion"]["won_goods_sale"]?><?php }else{?>0<?php }?>" />

					<select name="saleType" class="resp_select">
						<option value="percent">%</option>
						<option value="won"><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?></option>
					</select>							
				
					<span class="ml20 saleType_percent hide">
						?????? <input type="text" name="maxPercentGoodsSale" size="8" value="<?php if($TPL_VAR["promotion"]["max_percent_goods_sale"]){?><?php echo get_currency_price($TPL_VAR["promotion"]["max_percent_goods_sale"], 1)?><?php }else{?>0<?php }?>" class="<?php echo $TPL_VAR["only_numberic_type"]?> right"/> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

					</span>
					??????
					<div class="resp_message v2">- ????????? ?????? ?????? ?????? 1?????? ??????</div>							
				</div>

				<div class="form_type_shipping hide">					
					<select name="saleType" class="resp_select">
						<option value="shipping_free">?????? ????????? ??????</option>
						<option value="shipping_won">?????? ????????? ??????</option>
					</select>

					<span class="saleType_shipping_free hide ml20">
						??????
						<input type="text" name="maxPercentShippingSale" size="8"   value="<?php echo get_currency_price($TPL_VAR["promotion"]["max_percent_shipping_sale"], 1)?>" class="<?php echo $TPL_VAR["only_numberic_type"]?> right" />
						<?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

					</span>

					<span class="saleType_shipping_won hide">
						<input type="text" name="wonShippingSale" size="8" class="resp_text  <?php echo $TPL_VAR["only_numberic_type"]?> right" value="<?php echo $TPL_VAR["promotion"]["won_shipping_sale"]?>" />
						<?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> ??????						
					</span>	
				</div>		
			</td>
		</tr>

		<tr>
			<th>
				?????? ?????? ?????? 
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip7')"></span>
			</th>
			<td>	
				<input type="text" name="limitGoodsPrice" size="6" value="<?php echo get_currency_price($TPL_VAR["promotion"]["limit_goods_price"], 1)?>" class="<?php echo $TPL_VAR["only_numberic_type"]?> right"/> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> ?????? ?????? ??? ?????? ??????
			</td>
		</tr>

		<tr>
			<th>???????????? <span class="required_chk"></span></th>
			<td>			
				<div>
					<div class="resp_radio">
						<label>				
							<input type="radio" name="issuePriodType" id="issuePriodType0" value="date" <?php if(!$TPL_VAR["promotion"]["promotion_seq"]){?> checked="checked" <?php }?> />
							<input type="text" name="issueDate[]" value="<?php echo $TPL_VAR["promotion"]["issue_startdate"]?>" class="datepicker resp_text"  maxlength="10" size="10" /> ~ <input type="text" name="issueDate[]" value="<?php echo $TPL_VAR["promotion"]["issue_enddate"]?>" class="datepicker resp_text"  maxlength="10" size="10" />
						</label>				
				
						<label class="code_type_disposable hide">
							<input type="radio" name="issuePriodType"  id="issuePriodType1"  value="day" />
							?????????????????? <input type="text" name="afterIssueDay" size="2" value="<?php echo $TPL_VAR["promotion"]["after_issue_day"]?>" class="onlynumber" /> ???
						</label>						
					</div>				
				</div>
			</td>
		</tr>
		
		<tr class="duplicationUse_con hide">
			<th>?????? ?????? <span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip8')"></span></th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="duplicationUse" value="0" checked/> ??????</label>
					<label><input type="radio" name="duplicationUse" value="1"/> ??????</label>				
				</div>				
			</td>
		</tr>		
	</table>

	<div class="item-title">?????? ?????? ??????</div>
	
	<table class="table_basic thl">	
		<tr>
			<th>?????? ?????? ??????</th>
			<td>	
				
<?php if($TPL_VAR["promotion"]["promotion_seq"]){?>
<?php if($TPL_VAR["promotion"]["promotion_type"]=='random'||$TPL_VAR["promotion"]["promotion_type"]=='one'){?>					
						?????? ??????
<?php if($TPL_VAR["promotion"]["promotion_type"]=='random'){?>
						<input type="radio" id ="promotion_type1" name="promotion_type" value="random" checked class="hide"/>
<?php }else{?>
						<input type="radio" id ="promotion_type1" name="promotion_type" value="one" checked class="hide"/>
<?php }?>
<?php }elseif($TPL_VAR["promotion"]["promotion_type"]=='file'||$TPL_VAR["promotion"]["promotion_type"]=='input'){?>					
						?????? ??????
<?php if($TPL_VAR["promotion"]["promotion_type"]=='file'){?>
						<input type="radio" id ="promotion_type2" name="promotion_type" value="file" checked class="hide"/>
<?php }else{?>
						<input type="radio" id ="promotion_type2" name="promotion_type" value="input" checked class="hide"/>
<?php }?>
<?php }?>
<?php }else{?>
					<div class="resp_radio code_type_promotion hide">
						<label><input type="radio" id ="promotion_type1" name="promotion_type" value="one" checked/> ?????? ??????</label>
						<label><input type="radio" id ="promotion_type2" name="promotion_type" value="input"/> ?????? ??????</label>
					</div>

					<div class="resp_radio code_type_disposable hide">
						<label><input type="radio" id ="promotion_type1" name="promotion_type" value="random" checked/> ?????? ??????</label>
						<label><input type="radio" id ="promotion_type2" name="promotion_type" value="file"/> ?????? ??????</label>
					</div>
<?php }?>
			</td>
		</tr>

		<tr>
			<th>?????? ??????</th>
			<td>				
				<div class="code_type_promotion hide">
					<div class="promotion_type_one hide">
<?php if($TPL_VAR["promotion"]["promotion_seq"]){?>	
<?php if($TPL_VAR["promotion"]["promotion_type"]=='one'){?>															
								<strong><?php echo $TPL_VAR["promotion"]["promotion_input_serialnumber"]?></strong>
								<input type="button" id="promotion_code_copy" promotion_input_serialnumber="<?php echo $TPL_VAR["promotion"]["promotion_input_serialnumber"]?>" value="??????" class="resp_btn v2" />
<?php }?>								
<?php }else{?>
							<select name="promotionLimit_size1" id="promotionLimit_size1">
							<option value="5" selected="selected" >5</option>
							<option value="6">6</option>
							</select> ????????? ?????? ?????? 1??? ??????
<?php }?>
					</div>

					<div class="promotion_type_input hide">
<?php if($TPL_VAR["promotion"]["promotion_seq"]){?>												
<?php if($TPL_VAR["promotion"]["promotion_type"]=='input'){?>								
								<input type="hidden" name="promotion_input_num" value="<?php echo $TPL_VAR["promotion"]["promotion_input_serialnumber"]?>" >								
								<strong><?php echo $TPL_VAR["promotion"]["promotion_input_serialnumber"]?></strong>
								<input type="button" id="promotion_code_copy" promotion_input_serialnumber="<?php echo $TPL_VAR["promotion"]["promotion_input_serialnumber"]?>" value="??????" class="resp_btn v2" />							
<?php }?>								
<?php }else{?>
							<select name="promotionLimit_size2" id="promotionLimit_size2">
							<option value="5" selected="selected" >5</option>
							<option value="6">6</option>
							</select> ?????? <label for="promotion_type2"> <input type="text" name="promotion_input_num" id="promotion_input_num" value="" title="?????? ?????? ?????? ??????" size="25" class="resp_text"></label>
<?php }?>
					</div>
				</div>

				<div class="code_type_disposable hide">					
					<div class="promotion_type_random hide">						
<?php if($TPL_VAR["promotion"]["promotion_seq"]){?>												
<?php if($TPL_VAR["promotion"]["promotion_type"]=='random'){?>														
								<strong>??? <?php echo number_format($TPL_VAR["promotion"]["filepromotiontotal"])?>???</strong>
								<input type="button" id="promotion_code_view" value="?????? ??????" class="resp_btn v2"/>
								<input type="button" id="promotion_code_excel_down" value="?????? ????????????" class="resp_btn"/>
<?php }?>	
<?php }else{?>
							?????? ??????
							<input type="hidden" name="promotionLimit_size1" value="5">
							<input type="hidden" name="promotionLimit_size2" value="5">
<?php }?>
					</div>

					<div class="promotion_type_file hide">
<?php if($TPL_VAR["promotion"]["promotion_seq"]){?>						
<?php if($TPL_VAR["promotion"]["promotion_type"]=='file'){?>
								<input type="hidden" name="promotion_type" value="file" >
								<strong>??? <?php echo number_format($TPL_VAR["promotion"]["filepromotiontotal"])?>???</strong>
								<input type="button" id="promotion_code_view"  value="?????? ??????" class="resp_btn v2"/>
								<input type="button" id="promotion_code_excel_down" value="?????? ????????????" class="resp_btn"/>	
<?php }?>	
<?php }else{?>
							<input type="hidden" name="promotion_file" id="promotion_file" >
							<button type="button" class="batchExcelRegist resp_btn v2">?????? ??????</button>
							<span class='promotion_file'></span>
<?php }?>	
					</div>	
				</div>							
			</td>
		</tr>

		<tr>
			<th>????????? ?????? <span class="required_chk"></span></th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="downloadLimit_promotion" value="unlimit" checked /> ?????? ??????</label>
					<label>
						<input type="radio" name="downloadLimit_promotion" value="limit" /> 
						<input type="text" name="downloadLimitEa_promotion" id="downloadLimitEa_promotion" value="" size="5"  class="resp_text onlynumber"/>????????? ?????? ??????	
					</label>				
				</div>						
			</td>
		</tr>

		<tr class="member_limit">
			<th>?????? ??????</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="downloadLimit_member" value="" checked /> ?????? ??????</label>
					<label><input type="radio" name="downloadLimit_member" value="1" /> ?????? ??????</label>	
				</div>
			</td>
		</tr>
	</table>

	<div class="item-title form_type_product hide">?????? ?????? ?????? ??????</div>
	
	<table class="table_basic thl form_type_product hide">		
		<tr>
			<th>??????/???????????? ??????</th>
			<td class="clear">
				<ul class="ul_list_02">
					<li>
						<div class="resp_radio">
							<label><input type="radio" name="issue_type" id="issue_type0" value="all" checked="checked" > ?????? ??????</label>
							<label><input type="radio" name="issue_type" id="issue_type1" value="issue" > ????????? ??????/???????????????</label>
							<label><input type="radio" name="issue_type" id="issue_type2" value="except" > ????????? ??????/??????????????? ??????</label>
						</div>
					</li>
					<li class="clear issue_type_issue issue_type_except hide">
						<table class="table_basic thl v3 t_select_goods">
							<tbody>
								<tr class="t_goods">
									<th>??????</th>
									<td>
										<input type="button" value="?????? ??????" class="btn_select_goods resp_btn active"  />
										<input type="button" value="?????? ??????" class="select_goods_del resp_btn v3" selectType="goods" />
										<div class="mt10 wx600">
											<div class="goods_list_header">
												<table class="table_basic tdc">
													<colgroup>
														<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
														<col width="25%" />
														<col width="45%" />
<?php }else{?>
														<col width="70%" />
<?php }?>
														<col width="20%" />
													</colgroup>
													<tbody>
														<tr>
														<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" value="goods"></label></th>
<?php if(serviceLimit('H_AD')){?>
															<th>????????????</th>
<?php }?>
															<th>?????????</th>
															<th>?????????</th>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="goods_list">
												<table class="table_basic tdc">
													<colgroup>
														<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
														<col width="25%" />
														<col width="45%" />
<?php }else{?>
														<col width="70%" />
<?php }?>
														<col width="20%" />
													</colgroup>
													<tbody>
														<tr rownum=0 <?php if(count($TPL_VAR["issuegoods"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
															<td class="center" colspan="4">????????? ???????????????</td>
														</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->
<?php if($TPL_issuegoods_1){foreach($TPL_VAR["issuegoods"] as $TPL_V1){?>
														<tr rownum="<?php echo $TPL_V1["goods_seq"]?>" goods_provider_seq="<?php echo $TPL_V1["provider_seq"]?>">
															<td><label class="resp_checkbox"><input type="checkbox" name='issueGoodsTmp[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' /></label>
																<input type="hidden" name='issueGoods[]' value='<?php echo $TPL_V1["goods_seq"]?>' />
																<input type="hidden" name="issueGoodsSeq[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["issuegoods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
																<td><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
															<td class='left'>
																<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></div>
																<div class="goodsname">
<?php if($TPL_V1["goods_code"]){?><div>[????????????:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
																	<div><?php echo $TPL_V1["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V1["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 30)?></a></div>
																</div>
															</td>
															<td class='right'><?php echo get_currency_price($TPL_V1["price"], 2)?></td>
														</tr>
<?php }}?>
													</tbody>
												</table>
											</div>
										</div>
									</td>
								</tr>
								<tr class="t_category">
									<th>????????????</th>
									<td>
										<input type="button" value="???????????? ??????" class="btn_category_select resp_btn active" />
										<div class="mt10 wx600 category_list">
											<table class="table_basic">
												<colgroup>
													<col width="85%" />
													<col width="15%" />
												</colgroup>
												<thead>
													<tr class="nodrag nodrop">
														<th>???????????????</th>
														<th>??????</th>	
													</tr>
												</thead>
												<tbody>
													<tr rownum=0 <?php if(count($TPL_VAR["issuecategorys"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
														<td class="center" colspan="2">??????????????? ???????????????</td>
													</tr>
<?php if($TPL_issuecategorys_1){foreach($TPL_VAR["issuecategorys"] as $TPL_V1){?>
													<tr rownum="<?php echo $TPL_V1["category_code"]?>">
														<td class="center"><?php echo $TPL_V1["category"]?></td>
														<td class="center">
															<input type="hidden" name='issueCategoryCode[]' value='<?php echo $TPL_V1["category_code"]?>' />
															<input type="hidden" name="issueCategoryCodeSeq[<?php echo $TPL_V1["category_code"]?>]" value="<?php echo $TPL_V1["issuecategory_seq"]?>" />
															<button type="button" class="btn_minus"  selectType="category" seq="<?php echo $TPL_V1["category_code"]?>" onClick="promotionObj.select_delete('minus',$(this))"></button></td>
													</tr>
<?php }}?>
												</tbody>
											</table>
										</div>
									</td>
								</tr>
<?php if($TPL_VAR["issuebrands"]){?>
								<tr>
									<th>?????????</th>
									<td>	
										<div class="mt10 wx600 category_list">
											<table class="table_basic">												
												<thead>
													<tr class="nodrag nodrop">
														<th>????????????</th>														
													</tr>
												</thead>
												<tbody>
											
<?php if($TPL_issuebrands_1){foreach($TPL_VAR["issuebrands"] as $TPL_V1){?>
													
													<tr>
														<td class="center">
															<?php echo $TPL_V1["brand"]?>

															<input type="hidden" name='issueBrandCode[]' value='<?php echo $TPL_V1["brand_code"]?>' />
															<input type="hidden" name="issueBrandCodeSeq[<?php echo $TPL_V1["brand_code"]?>]" value="<?php echo $TPL_V1["issuebrand_seq"]?>" />
														</td>														
													</tr>
													
<?php }}?>
												</tbody>
											</table>
										</div>														
									</td>
								</tr>
<?php }?>
							</tbody>
						</table>
					</li>
				</ul>
			</td>
		</tr>
	</table>

	<div class="code_type_disposable hide">	
		<input type="hidden" name="promotionImg" value="1" />
	</div>
	
	<div class="table_group code_type_promotion hide">
		<div class="item-title">?????? ?????? ?????????</div>
		
		<table class="table_basic thl">
			<tr>
				<th>?????? ??????</th>
				<td>
					<div class="resp_radio">
						<label ><input type="radio" name="mainshow" value="1" /> ??????</label>
						<label ><input type="radio" name="mainshow" value="0" /> ?????????</label>							
					</div>
				</td>
			</tr>
		</table>
		<table class="table_basic thl mainshow_1 hide">
			<tr>
				<th>?????? ??????</th>
				<td>				
					<div class="promotioncodeshow" <?php echo $TPL_VAR["promotion"]["node_text_normal_style"]?>>
<?php if($TPL_VAR["promotion"]["node_text_title"]){?><?php echo $TPL_VAR["promotion"]["node_text_title"]?><?php }else{?><?php if(!$TPL_VAR["promotion"]){?>[??????????????????] Promotion Code : [????????????]<?php }?><?php }?>
					</div>							
				</td>
			</tr>

			<tr>

				<th>?????? ??????</th>
				<td>				
					<input type="text" name="node_text"  id="node_text" size="85" value="<?php if($TPL_VAR["promotion"]["node_text"]){?><?php echo $TPL_VAR["promotion"]["node_text"]?><?php }else{?><?php if(!$TPL_VAR["promotion"]){?>[??????????????????] Promotion Code : [????????????]<?php }?><?php }?>" class="center"  title="" />
				</td>
			</tr>

			<tr>
				<th>?????? ??????</th>
				<td>				
					<input type="text" name="node_text_normal"  id="node_text_normal" value='<?php echo $TPL_VAR["promotion"]["node_text_normal"]?>'  class="customFontDecoration" />
					<textarea class="hide" name="node_text_normal_orign" ><?php echo $TPL_VAR["promotion"]["node_text_normal"]?></textarea>
				</td>
			</tr>

			<tr>
				<th>?????? ?????? URL</th>
				<td>				
					<input type="text" name="node_text_normal_url" value="<?php echo $TPL_VAR["promotion"]["node_text_normal_url"]?>" title="??????URL" class="resp_text" size="85" />
					<select name="node_text_normal_url_target">
						<option value="_self" <?php if($TPL_VAR["promotion"]["node_text_normal_url_target"]=="_self"){?> selected="selected" <?php }?>>?????? ???</option>
						<option value="_blank"  <?php if(!$TPL_VAR["promotion"]["node_text_normal_url_target"]||$TPL_VAR["promotion"]["node_text_normal_url_target"]=='_blank'){?> selected="selected" <?php }?>>??? ???</option>
					</select>
				</td>
			</tr>

			<tr>
				<th>?????? ?????????</th>
				<td>				
					<div class="resp_radio">
						<label><input type="radio" name="promotionImg" value="1" <?php if(!$TPL_VAR["promotion"]["promotion_seq"]){?> checked="checked" <?php }?>/> ?????? ?????????</label>
						<label><input type="radio" name="promotionImg" value="4"/> ????????? ?????????</label>
					</div>							
				</td>
			</tr>

			<tr class="promotionImg_4 hide">
				<th>????????? ??????</th>
				<td>				
					<input type="hidden" name="promotionimage4" id="promotionimage4" value="" >			 
					<button type="button" class="batchImageRegist resp_btn v2">????????? ??????</button>
					<div class="promotionimage4lay mt5">
						<div id="promotionimage4lay" class="promotionimage"> <?php if($TPL_VAR["promotion"]["promotion_image4"]){?><img src="/data/promotion/<?php echo $TPL_VAR["promotion"]["promotion_image4"]?>"/><?php }?></div>
						<span class="guide_mess gray">(?????? ????????? ?????? 40)</span>
					</div>
				</td>
			</tr>
		</table>
	</div>
	
	<div class="item-title">?????? ?????? ??????</div>
	
	<table class="table_basic thl">		
		<tr>
			<th>?????? ?????? ??????</th>
			<td>
				<input type="button" class="resp_btn promocodeallhtmlView" value="??????" mode='all' /></span>				
			</td>
		</tr>

		<tr>
			<th>?????? ?????? ??????</th>
			<td>	
				<input type="button" class="promocodeallhtmlView resp_btn" value="??????"  mode='' /></span>				
			</td>
		</tr>
	</table>
</div>
</form>

<!-- ????????? ????????? ??????????????? -->
<div id="imageUploadDialog" class="hide">
	<div class="item-title">????????? ?????????</div>
	
	<table class="table_basic thl">		
		<tr>
			<th>????????????, ?????????</th>
			<td>jpg,gif,png 350*150</td>
		</tr>

		<tr>
			<th>???????????????</th>
			<td>/<span class="uploadPath"></span></td>		
		</tr>

		<tr>
			<th>????????????</th>
			<td>
				<span class="resp_btn v3">
					<label><input type="file" name="file" id="imageUploadButton"  class="uploadify"/>????????????</label>
				</span>					
			</td>		
		</tr>
	</table>

	<div class="footer">
		<input type="submit" class="resp_btn active size_XL" onclick="$('#imageUploadDialog').dialog('close');" value="??????" />	
		<input type="button" class="resp_btn v3 size_XL" onclick="$('#imageUploadDialog').dialog('close');" value="??????" />
	</div>	

</div>

<?php if($TPL_VAR["groups"]){?>
<div id="setGroupsPopup" class="hide">

	<div class="item-title">?????? ??????</div>

	<table class="table_row_basic">
		<colgroup>
			<col width="20%" />
			<col width="80%" />
		</colgroup>
		<thead>
			<tr>
				<th><input type="checkbox" class="allChkEvent" name="all_chk"></th>
				<th>??????</th>							
			</tr>
		</thead>		
		<tbody>
<?php if($TPL_groups_1){foreach($TPL_VAR["groups"] as $TPL_V1){?>
			<tr>
				<td><input type="checkbox" name="memberGroup" id="memberGroup_<?php echo $TPL_V1["group_seq"]?>" groupName="<?php echo $TPL_V1["group_name"]?>" value="<?php echo $TPL_V1["group_seq"]?>" class="resp_checkbox" /></td>
				<td><?php echo $TPL_V1["group_name"]?></td>					
			</tr>
<?php }}?>
		<tbody>
	</table>

	<div class="footer">
		<input type="button" id="setGroupsBtn" class="resp_btn active size_XL" onclick="$('#setGroupsPopup').dialog('close');" value="??????" />		
		<input type="button" class="resp_btn v3 size_XL" onclick="$('#setGroupsPopup').dialog('close');" value="??????" />
	</div>

</div>
<?php }?>

<!-- ???????????? ????????? ??????????????? -->
<div id="ExcelUploadDialog" class="hide">

	<div class="item-title">?????? ??????</div>
	
	<table class="table_basic thl">		
		<tr>
			<th>?????? ????????????</th>
			<td><input type="button" class="promotion_code_form resp_btn" promotion_code_form='<?php echo $TPL_VAR["promotion_code_form"]?>' value="?????? ????????????" /></td>
		</tr>

		<tr>
			<th>?????? ?????????</th>
			<td>				
				<label class="resp_btn v2"><input type="file" name="file" id="ExcelUploadButton" class="uploadify"/>????????????</label>				
			</td>
		</tr>
	</table>

	<div class="resp_message">
		- ?????? ?????? ?????? ?????? ?????? ?????? <a href="https://www.firstmall.kr/customer/faq/1252" class="resp_btn_txt" target="_blank">????????? ??????</a>
	</div>
	
	<div class="footer">
		<input type="submit" class="resp_btn active size_XL" onclick="closeDialog('ExcelUploadDialog')" value="??????" />	
		<input type="button" class="resp_btn v3 size_XL" onclick="closeDialog('ExcelUploadDialog')" value="??????" />
	</div>	

</div>

<div id="lay_seller_select"></div><!-- ????????? ?????? ????????? -->
<div id="lay_goods_select"></div><!-- ???????????? ????????? -->
<div id="lay_category_select"></div><!-- ???????????? ?????? ????????? -->
<div id="lay_promotion_issued"></div><!-- Popup :: ?????? ???????????? -->


<?php $this->print_("layout_footer",$TPL_SCP,1);?>