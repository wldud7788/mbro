<?php /* Template_ 2.2.6 2022/05/17 12:31:44 /www/music_brother_firstmall_kr/admin/skin/default/event/regist.html 000070524 */  $this->include_("qrcode");?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=120824"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=120824"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>

<script type="text/javascript" src="/app/javascript/js/admin/gProviderSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gCategorySelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gGoodsSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/eventRegist.js?mm=<?php echo date('Ymd')?>"></script>
<style>#soloProductDetailPageSetting {overflow:hidden;}</style>

<script type="text/javascript">
var applyNum	= 0;
var eventType 	= "multi";
var selectType

$(function(){
	var sGlUrl		= "<?php echo get_connet_protocol()?><?php echo $_SERVER["HTTP_HOST"]?>/link/etc/"+encodeURIComponent($(".event_view_btn").attr("tpl_path"));
	var sDesignUrl	= sGlUrl;
	/*<?php if($TPL_VAR["operation_type"]=='light'){?> 라이트 버전일 경우 주소*/
	sGlUrl			= "<?php echo get_connet_protocol()?><?php echo $_SERVER["HTTP_HOST"]?>/promotion/event_view?event="+$(".event_view_btn").data("code");
	/*<?php }?>*/

	// 단독 이벤트일 경우 주소
<?php if($TPL_VAR["event"]["event_type"]=='solo'){?>
		sGlUrl			= "<?php echo get_connet_protocol()?><?php echo $_SERVER["HTTP_HOST"]?>/promotion/event_view?event=<?php echo $TPL_VAR["event"]["event_seq"]?>";
<?php }?>

	// 서브밋 발생시 딤드처리
	$(":submit").on("click",function()
	{
		loadingStart();
	});

	$(".colorpicker").customColorPicker();

	// 배너이미지 버튼
	/* 파일업로드버튼 ajax upload 적용 */
	$('#bannerUploadButton').createAjaxFileUpload(uploadConfig, uploadCallback);
	$('#eventBannerUploadButton').createAjaxFileUpload(uploadConfig, uploadCallback);
	$('#m_eventBannerUploadButton').createAjaxFileUpload(uploadConfig, uploadCallback);

<?php if($TPL_VAR["event"]["banner_filename"]){?>imgUploadEvent("#bannerUploadButton", "", "/data/event/", "<?php echo $TPL_VAR["event"]["banner_filename"]?>")<?php }?>		
<?php if($TPL_VAR["event"]["event_banner"]){?>imgUploadEvent("#eventBannerUploadButton", "", "/data/event/", "<?php echo $TPL_VAR["event"]["event_banner"]?>")<?php }?>	
<?php if($TPL_VAR["event"]["m_event_banner"]){?>imgUploadEvent("#m_eventBannerUploadButton", "", "/data/event/", "<?php echo $TPL_VAR["event"]["m_event_banner"]?>")<?php }?>		

	$(".event_design_btn").click(function()
	{
		window.open(sDesignUrl);
	});

	$(".event_view_btn").click(function()
	{
		window.open(sGlUrl);
	});

	// 주소복사 플래시 제거
	$('#url_copy').click(function()
	{
		clipboard_copy(sGlUrl);
		alert("주소가 복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.");
	});

	// SNS 치환코드복사
	$(".copy_qrcode_btn").each(function()
	{
		$(this).click(function(){
			clipboard_copy($(this).attr("code"));
			alert("치환코드가 복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.");
		});
	});


	$(".is_hour").on("blur", function()
	{
		if	($(this).val() > 23){
			openDialogAlert("시간은 0 ~ 23까지만 입력가능합니다.", 400, 150);
			$(this).val(23);
		}
	});

	$(".is_minute").on("blur", function()
	{
		if	($(this).val() > 59){
			openDialogAlert("분은 0 ~ 59까지만 입력가능합니다.", 400, 150);
			$(this).val(59);
		}
	});

	$(".confirmPopupInfoBtn").on('click', function()
	{	
		var id = $(this).parent().parent().attr("id");			
		addhiddenText(id, id+"Container")
		closeDialog(id);
	});

	$(".soloProductDetailPageBtn").on('click', function()
	{	
		var text = Editor.getContent();		
		$("#title_contents").html(text);	
		$("input[name='bgcolor']").val($("#bgcolorDiv .on").attr("color"));
		closeDialog('soloProductDetailPageSetting');
	});

	$(".confirmPopupBannerBtn").on('click', function()
	{	
		var text = Editor.getContent();		
		$("#event_page_banner").html(text);
		closeDialog('giftContents');
	});
	
	$(".btnLayClose").on('click',function()
	{	
		var id = $(this).parent().parent().attr("id");		
		closeDialog(id);		
	});

	$(".btnLayBannerClose").on("click",function()
	{
		var targetLayder = $(this).attr("target");
		closeDialog(targetLayder);
	});
	
	// 이벤트 상세페이지 팝업
	$('.popupOpenBtn').on('click', function()
	{
		var name = $(this).data('name');
		var title;
		var option;

		switch (name) {
			case "giftContents" :
				title = "이벤트 배너 수정";
				option = {"width":"1000","height":"430","show" : "fade","hide" : "fade"};
				view_editor('event_page_banner_tmp','');
				break;

			case "detailPageSetting" :
				title = "상세 페이지 설정";
				option = {"width":"1000","height":"370","show" : "fade","hide" : "fade"};
				break;

			case "goodInfoStyle" :
				title = "상품 디스플레이";
				option = {"width":"1000","height":"700","show" : "fade","hide" : "fade"};
				break;

			case "snsShare" :
				title = "이벤트 공유";
				option =  {"width":"1000","height":"300","show" : "fade","hide" : "fade"};
				break;

			case "soloProductDetailPageSetting":
				title = "상품 상세 꾸미기";
				option =  {"width":"1100","height":"730","show" : "fade","hide" : "fade"};
				view_editor('title_contents_tmp','');
				break;
			break;
		}

		openDialog(title, name,  option);
	});		



	//이벤트 상품 삼품 선정 기준
	$(document).on("change", "input[name='goods_rule_multi'], input[name='goods_rule_solo']", function()
	{
		var val = $(this).val();		
	
		$("input[name='goods_rule_multi']").each(function() 
		{ 			 	
			$("."+$(this).val()).hide();
			$(this).attr("checked", false);					
		});

		$("."+val).show();

		$(this).attr("checked", true);
		
		if(val=="all") $(".t_select_goods").nextAll().remove();
		
		if(val=="goods_view") 
		{			
			$(".except_select_contents").hide();

			if($("input[name='event_type']:checked").val()=="solo") 
			{
				$(".solo").hide();
				$(".t_select_goods").nextAll().remove();
			}
		}else{
			if($("input[name=except_select]").is(":checked"))$(".except_select_contents").show();			
		}
		
<?php if(!$TPL_VAR["event"]["event_seq"]){?> $(".t_select_goods").nextAll().remove()<?php }?>
		
	});

	$("input[name='sales_tag']").on("click",function(){	
		setSellerCommission();
	});
	
<?php if($TPL_VAR["event"]["event_seq"]){?>
<?php if(date('Y-m-d H:59',mktime())>$TPL_VAR["event"]["end_datetime"]){?>
		openDialogAlert('이벤트가 종료되었습니다.', 300, 150);
<?php }?>
		setContentsRadio("event_type", "<?php echo $TPL_VAR["event"]["event_type"]?>");
		setContentsSelect("rate_type_saco", "<?php echo $TPL_VAR["event"]["rate_type_saco"]?>");
		setContentsSelect("rate_type_suco", "<?php echo $TPL_VAR["event"]["rate_type_suco"]?>");
		setContentsSelect("rate_type_supr", "<?php echo $TPL_VAR["event"]["rate_type_supr"]?>");
		setContentsRadio("banner_view", "<?php echo $TPL_VAR["event"]["banner_view"]?>");
		setContentsRadio("event_view", "<?php echo $TPL_VAR["event"]["event_view"]?>");
		setContentsRadio("sales_tag", '<?php if($TPL_VAR["event"]["provider_name_list"]){?>provider<?php }else{?>admin<?php }?>');
		setRangeContentsSelect("price_type", "");
		//setContentsRadio("goods_rule_multi", "<?php echo $TPL_VAR["event"]["goods_rule"]?>")
		setContentsRadio("show_link", "<?php echo $TPL_VAR["event"]["show_link"]?>")
<?php if($TPL_VAR["event"]["event_type"]=="multi"){?>setContentsRadio("goods_rule_multi", "<?php echo $TPL_VAR["event"]["goods_rule"]?>")<?php }else{?>setContentsRadio("goods_rule_solo", "goods_view")<?php }?>
		
		$(".confirmPopupInfoBtn").trigger('click');			
		
<?php }else{?>
		setContentsRadio("event_type", "multi");		
		setContentsSelect("rate_type_saco", "equal");
		setContentsSelect("rate_type_suco", "equal");
		setContentsSelect("rate_type_supr", "equal");
		setContentsRadio("event_view", "y");
		setContentsRadio("banner_view", "n");
		setContentsRadio("order_gift_rule", "default");			
		setContentsRadio("goods_rule_multi", "<?php if($TPL_VAR["operation_type"]=='light'){?>category<?php }else{?>all<?php }?>");
		setContentsRadio("goods_rule_solo", "goods_view");
		setRangeContentsSelect("price_type", "sale");
		setContentsRadio("sales_tag", 'admin');
		setContentsRadio("show_link", "view")
<?php }?>



	//이벤트 유현 선택
	$("input[name='event_type']").on("change", function()
	{
		var val = $(this).val();
		
		if(val=="multi")
		{
<?php if(!$TPL_VAR["event"]["event_seq"]){?>
<?php if($TPL_VAR["operation_type"]=='light'){?>
			$("input[name='goods_rule_multi'][value='category']").attr("checked", "true")
<?php }else{?>
			$("input[name='goods_rule_multi'][value='all']").attr("checked", "true")
<?php }?>
<?php }?>

			$(".productDetailPageItem").show()

			$("input[name='goods_rule_multi']:checked").trigger("change");			
		} else{
			$("input[name='goods_rule_solo']:checked").trigger("change");
			$("input[name='goods_rule']").val("goods_view");
<?php if($TPL_VAR["operation_type"]!='light'){?> $(".productDetailPageItem").hide()<?php }?>
		}
	})		
	
	setContentsCheckbox("week_event");
	setContentsCheckbox("time_event");	
	setRangeContentsCheckbox("except_select");
	setRangeContentsCheckbox("reserve_select");
	setRangeContentsCheckbox("point_select");
	addBenefitsItemEvent();
	selectTypeInfo();	


	//이벤트 상품 삼품 선정 기준값 goods_rule hidden text 입력
	$(".goods_rule").on("change", function()
	{	
		$("input[name='goods_rule']").val($(this).val());
	})		
	
	$("input[name='event_type']:checked").trigger("change");
	
	//요일, 시간 제한
	$(".daliyEvent").on("click", function()
	{
		var val = 0;	
		if($("input[name=week_event]").is(":checked")||$("input[name=time_event]").is(":checked")) val = 1;
		$("input[name=daily_event]").val(val);
	})	
	
	//이벤트 혜택 추가(+)
	$(".plusBtn").on("click", function()
	{		
		var id 			= $(this).closest("table").attr("id");		
		var newClone 	= $("#applyGoods .cloneTr").eq(0).clone();	
		var trObj 		= $("#applyGoods > table > tbody > tr");
		var idx 		= $("#applyGoods > table > tbody > tr").length;
		newClone.find("input, select").attr("disabled", false);	

		//상품 초기화
		newClone.find(".goods_list tr").each(function(){
			$(this).show();
			$(this).nextAll().remove();
		});

		newClone.find(".selectBtn.btn_select_goods").each(function(){
			var dataGoodstype = $(this).attr("data-goodstype").replace("_1","_"+(idx+1));
			$(this).attr("data-goodstype",dataGoodstype);
		});

		//카테고리 초기화
		newClone.find(".category_list tr").eq(1).show();
		newClone.find(".category_list tr").eq(1).nextAll().remove();		
		newClone.find(".except_category_list tr").eq(1).show();
		newClone.find(".except_category_list tr").eq(1).nextAll().remove();
		
		//혜택 금액 설정 초기화
		newClone.find("input[type='text']").val("");
		newClone.find("input[type='checkbox']").attr("checked", false);
		newClone.find(".reserve_select_contents").hide();
		newClone.find(".point_select_contents").hide();
		newClone.find(".except_select_contents").hide();
		
		//생성된 input name 변경 
		newClone.find("input").each(function(){
			var name = String($(this).attr("name")).replace("[0]","["+idx+"]")
			$(this).attr("name", name);	
		});


		trObj.parent().append(newClone);	
		newClone.find(".cloneTr").html("");		
		
		//생성된 input select 이벤트 추가
		addBenefitsItemEvent();		
		setRangeContentsSelect("price_type", "sale", newClone);			
		
		applyNum = idx;	
		selectTypeInfo();
		delectGoodsEvent();
	});
	
	$("#giftContents").hide();
	$("#soloProductDetailPageSetting").hide();
	setSellerCommission();
	
	//상세 페이지 이벤트 배경 설정
	var arr_bgcolor = ["#cc2b30", "#df6f01", "#ffd101", "#9cbb3c", "#29b672", "#76cdd4", "#7194d8", "#9464c8"];
	
	$.each(arr_bgcolor, function(index, item){
		$("#bgcolorDiv").append('<li style="background:'+item+';" color="'+item+'"><img src="/admin/skin/default/images/common/icon_check2.png"></li>');		
	})

	$("#bgcolorDiv > li").on("click", function(){		
		$("#bgcolorDiv .on").removeClass("on");
		$(this).addClass("on");
	});

	var currentGgcolorNum = 0;
<?php if($TPL_VAR["event"]["bgcolor"]){?>currentGgcolorNum = jQuery.inArray("<?php echo $TPL_VAR["event"]["bgcolor"]?>", arr_bgcolor)<?php }?>;
	$("#bgcolorDiv > li").eq(currentGgcolorNum).trigger("click");		
	
});

//정산 기준에 따른 판매 수수료
function setSellerCommission()
{
	if($("input[name='sales_tag']:checked").val() == 'admin'){
		$(".sellerCommissionSet").hide();
	}else{
		$(".sellerCommissionSet").show();
	}
}

//이벤트 혜택 삭제(-)
function trDel(tg)
{
	var len = $(tg).closest("table").find(".t_select_goods").length;
	if(len==1) return;
	$(tg).parent().parent().remove();		
}

//선택한(상품, 카테고리) 번호 및 레이어정보
function selectTypeInfo()
{
	$(".selectBtn").on("click", function()
	{		
		applyNum = $(this).closest("table").parent().closest("table").find(".t_select_goods").index($(this).closest(".t_select_goods"));
		selectType =  $(this).attr("selectType");		
		eventType = $("input[name='event_type']:checked").val();
	})
}
		
//이벤트 상품 할인혜택 이벤트 
function addBenefitsItemEvent()
{		
	$("select[name='price_type'], select[name='uint']").on("change", function()
	{
		var _val = 1;
		var _type = $(this).closest("td").find("select[name='price_type']").val();
		var _uint = $(this).closest("td").find("select[name='uint']").val();

		if(_type == "sale"&& _uint == "percent")_val = 0;
		if(_type == "sale" && _uint == "won")_val = 2;		

		$(this).closest("td").find(".target_sale").val(_val);
	})	
	
	setRangeContentsCheckbox("except_select");
	setRangeContentsCheckbox("reserve_select");
	setRangeContentsCheckbox("point_select");
}

// 이벤트 저장 전 체크
function chkEventSubmit(obj)
{
	loadingStart();
	return true;
}

</script>

<form name="eventRegist" id="eventRegist" method="post" enctype="multipart/form-data" action="../event_process/regist" target="actionFrame" onsubmit="return chkEventSubmit(this);">
<?php if($TPL_VAR["event"]["event_seq"]){?><input type="hidden" name="event_seq" value="<?php echo $TPL_VAR["event"]["event_seq"]?>" /><?php }?>
<input type="hidden" name="query_string" value="<?php echo $TPL_VAR["query_string"]?>" /> <!--######################## 16.10.27 : -->

<?php if($TPL_VAR["operation_type"]!='light'&&$TPL_VAR["event"]["goods_info_image"]){?>
<input type="hidden" name="goods_info_image" value="<?php echo $TPL_VAR["event"]["goods_info_image"]?>" />
<?php }?>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>할인 이벤트 <?php if($TPL_VAR["event"]["event_seq"]){?>수정<?php }else{?>등록<?php }?></h2>		
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><button type="button" onclick="document.location.href='/admin/event/catalog?<?php echo $TPL_VAR["query_string"]?>';" class="resp_btn v3 size_L">리스트 바로가기</button></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right" id="page-buttons-right">		
			<li><button type="submit" onclick="submitEditorForm(document.eventRegist);" class="resp_btn active2 size_L">저장</button></li>			
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">

<?php if($TPL_VAR["event"]["event_seq"]){?>	
	<div class="item-title">이벤트 현황</div>

	<table class="table_basic thl">		
		<tr>
			<th>이벤트 유형</th>
			<td colspan="3">
<?php if($TPL_VAR["event"]["event_type"]=="multi"){?>상품 이벤트<?php }else{?>단독 상품 이벤트<?php }?>
				<input type="radio" name="event_type" value="multi" class="hide" checked />
				<input type="radio" name="event_type" value="solo" class="hide" />	
			</td>
		</tr>

		<tr>
			<th>상태</th>
			<td colspan="3"><?php echo $TPL_VAR["event"]["status"]?></td>
		</tr>
		
<?php if($TPL_VAR["event"]["event_type"]=="solo"){?>
		<tr>
			<th>진행 현황</th>
			<td colspan="3">매출 <?php echo get_currency_price($TPL_VAR["event"]["event_order_price"], 2)?>/ 판매 <?php echo $TPL_VAR["event"]["event_order_cnt"]?>건 / 주문 <?php echo $TPL_VAR["event"]["event_order_ea"]?>건</td>
		</tr>
<?php }?>

		<tr>
			<th>
				페이지 진입 제한
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip10')"></span>
			</th>
			<td colspan="3">
				<div class="resp_radio">
<?php if($TPL_VAR["event"]["status"]=='진행 중'){?>
					<label><input type="radio" name="display" value="y" <?php if($TPL_VAR["event"]["display"]=='y'){?>checked<?php }?> /> 가능</label>
					<label><input type="radio" name="display" value="n" <?php if($TPL_VAR["event"]["display"]=='n'){?>checked<?php }?> /> 불가</label>
<?php }else{?>
					접속불가
<?php }?>			
				</div>
			</td>
		</tr>

		<tr>
			<th>이벤트 페이지</th>
			<td colspan="3">				
				<button type="button" class="event_view_btn resp_btn" tpl_path="<?php echo $TPL_VAR["event"]["tpl_path"]?>" data-code="<?php echo $TPL_VAR["event"]["event_seq"]?>">보기</button>
				<button type="button" class="resp_btn v2" id="url_copy">주소복사</button>				
			</td>
		</tr>

		<tr>
			<th>등록일</th>
			<td><?php echo $TPL_VAR["event"]["regist_date"]?></td>
			<th>수정일</th>
			<td><?php echo $TPL_VAR["event"]["update_date"]?></td>
		</tr>
	</table>
<?php }?>

	<div class="item-title">이벤트 정보</div>

	<table class="table_basic thl">
<?php if(!$TPL_VAR["event"]["event_seq"]){?>
		<tr>
			<th>이벤트 유형</th>
			<td>
				<div class="resp_radio">
<?php if(!serviceLimit('H_NFR')){?>	
					<input type="radio" name="event_type" value="multi" checked class="hide" />  상품 이벤트			
<?php }else{?>
					<label><input type="radio" name="event_type" value="multi" checked /> 상품 이벤트</label>
					<label><input type="radio" name="event_type" value="solo" /> 단독 상품 이벤트</label>				
<?php }?>
				</div>
			</td>
		</tr>
<?php }?>		
		<tr>
			<th>이벤트명 <span class="required_chk"></span></th>
			<td><input type="text" name="title" class="line" size="50" value="<?php echo $TPL_VAR["event"]["title"]?>" /></td>
		</tr>

		<tr>
			<th>이벤트 기간 <span class="required_chk"></span></th>
			<td>
				<input type="text" name="start_date"  id="start_date" value="<?php if($TPL_VAR["event"]["event_seq"]){?><?php echo $TPL_VAR["event"]["start_date"]?><?php }else{?><?php echo date('Y-m-d')?><?php }?>" class="datepicker"  maxlength="10" size="10" />
				<input type="text" name="start_hour" value="<?php if($TPL_VAR["event"]["event_seq"]){?><?php echo $TPL_VAR["event"]["start_time"]?><?php }else{?>00<?php }?>" size="2" maxlength="2" class="is_hour" />
				<input type="hidden" name="start_minute" value="00" />
				시 00분 - 				
				<input type="text" name="end_date" id="end_date"  value="<?php if($TPL_VAR["event"]["event_seq"]){?><?php echo $TPL_VAR["event"]["end_date"]?><?php }else{?><?php echo date('Y-m-d',strtotime('+1 month'))?><?php }?>" class="datepicker" maxlength="10" size="10" />
				<input type="text" name="end_hour" value="<?php if($TPL_VAR["event"]["event_seq"]){?><?php echo $TPL_VAR["event"]["end_time"]?><?php }else{?>23<?php }?>" size="2" maxlength="2" class="is_hour" />
				<input type="hidden" name="end_minute" value="59" />				
				시 59분
			
				<input type="hidden" name="end_minute" value="59" />				
				<br>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="week_event" <?php if($TPL_VAR["event"]["app_week"]){?>checked<?php }?> class="daliyEvent"/> 요일 제한</label>			
					<label><input type="checkbox" name="time_event" <?php if(($TPL_VAR["event"]["app_start_hour"]&&$TPL_VAR["event"]["app_end_hour"])&&!($TPL_VAR["event"]["app_start_hour"]=="00"&&$TPL_VAR["event"]["app_end_hour"]=="23")){?>checked<?php }?> class="daliyEvent"/> 시간 제한</label>
					<input type="hidden" name="daily_event" value="<?php if($TPL_VAR["event"]["daily_event"]){?><?php echo $TPL_VAR["event"]["daily_event"]?><?php }else{?>0<?php }?>"/>
				</div>
			</td>
		</tr>

		<tr class="week_event_contents <?php if($TPL_VAR["event"]["app_week"]==''){?>hide<?php }?>">
			<th>요일 제한</th>
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="week[]" value="1" <?php if(strstr($TPL_VAR["event"]["app_week"],'1')){?>checked<?php }?> <?php if(!$TPL_VAR["event"]["daily_event"]){?>disabled<?php }?> /> 월</label>
					<label><input type="checkbox" name="week[]" value="2" <?php if(strstr($TPL_VAR["event"]["app_week"],'2')){?>checked<?php }?> <?php if(!$TPL_VAR["event"]["daily_event"]){?>disabled<?php }?> /> 화</label>
					<label><input type="checkbox" name="week[]" value="3" <?php if(strstr($TPL_VAR["event"]["app_week"],'3')){?>checked<?php }?> <?php if(!$TPL_VAR["event"]["daily_event"]){?>disabled<?php }?> /> 수</label>
					<label><input type="checkbox" name="week[]" value="4" <?php if(strstr($TPL_VAR["event"]["app_week"],'4')){?>checked<?php }?> <?php if(!$TPL_VAR["event"]["daily_event"]){?>disabled<?php }?> /> 목</label>
					<label><input type="checkbox" name="week[]" value="5" <?php if(strstr($TPL_VAR["event"]["app_week"],'5')){?>checked<?php }?> <?php if(!$TPL_VAR["event"]["daily_event"]){?>disabled<?php }?> /> 금</label>
					<label><input type="checkbox" name="week[]" value="6" <?php if(strstr($TPL_VAR["event"]["app_week"],'6')){?>checked<?php }?> <?php if(!$TPL_VAR["event"]["daily_event"]){?>disabled<?php }?> /> 토</label>
					<label><input type="checkbox" name="week[]" value="7" <?php if(strstr($TPL_VAR["event"]["app_week"],'7')){?>checked<?php }?> <?php if(!$TPL_VAR["event"]["daily_event"]){?>disabled<?php }?> /> 일</label>		
				</div>
			</td>
		</tr>

		<tr class="time_event_contents <?php if(($TPL_VAR["event"]["app_start_hour"]==''&&$TPL_VAR["event"]["app_end_hour"]=='')||($TPL_VAR["event"]["app_start_hour"]== 00&&$TPL_VAR["event"]["app_end_hour"]== 23)){?>hide<?php }?>">
			<th>시간 제한</th>
			<td>
				<select name="app_start_hour">
<?php if(is_array($TPL_R1=range( 0, 23))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["event"]["app_start_hour"]==$TPL_V1){?>selected<?php }?>><?php echo str_pad($TPL_V1, 2,'0',$TPL_VAR["STR_PAD_LEFT"])?></option>
<?php }}?>
				</select>시 00분 ~
				<input type="hidden" name="app_start_minute" value="00" />
				
				<select name="app_end_hour">
<?php if(is_array($TPL_R1=range( 0, 23))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["event"]["app_end_hour"]==$TPL_V1||($TPL_VAR["event"]["app_end_hour"]==""&&$TPL_V1=="23")){?>selected<?php }?>><?php echo str_pad($TPL_V1, 2,'0',$TPL_VAR["STR_PAD_LEFT"])?></option>
<?php }}?>
				</select>시 59분
				<input type="hidden" name="app_end_minute" value="59" />

				<div class="resp_message v2 gray">- 당일 시간만 설정 가능합니다. 익일로 연장 불가</div>
			</td>
		</tr>
	</table>

<?php if(serviceLimit('H_AD')){?>

	<div class="item-title">혜택 부담 설정</div>
	<table class="table_basic thl">		
		<tr>
			<th>대상</th>
			<td>				
				<div class="resp_radio">
					<label><input type="radio" name="sales_tag" value="admin" <?php if($TPL_VAR["event"]["sales_tag"]=='admin'||!$TPL_VAR["event"]["sales_tag"]){?>checked<?php }?> /> 본사 상품</label>
					<label><input type="radio" name="sales_tag" value="provider" <?php if($TPL_VAR["event"]["sales_tag"]=='provider'){?>checked<?php }?> /> 입점사 상품</label>			
				</div>	
			</td>
		</tr>

		<tr class="sales_tag_provider hide provider">
			<th>입점사 지정 <span class="required_chk"></span></th>
			<td>
				<input type="button" value="입점사 선택" class="btn_provider_select resp_btn active" /></span>			
				
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
								<th>입점사명</th>
								<th>정산 방식</th>		
								<th>삭제</th>	
							</tr>
						</thead>
						</table>
					</div>
					<div class="provider_list">
						<table class="table_basic">
							<colgroup>
								<col width="40%" />
								<col width="40%" />
								<col width="20%" />
							</colgroup>
							<tbody>
							<tr rownum=0 <?php if(count($TPL_VAR["event"]["provider_name_list"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
									<td class="center" colspan="3">입점사를 선택하세요</td>
								</tr>
<?php if(is_array($TPL_R1=$TPL_VAR["event"]["provider_name_list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<tr rownum="<?php echo $TPL_V1["provider_seq"]?>">
								<td class="center"><?php echo $TPL_V1["provider_name"]?></td>
								<td class="center"><?php echo $TPL_V1["commission_text"]?></td>
								<td class="center">
									<input type="hidden" name="salescost_provider_list[]" value="<?php echo $TPL_V1["provider_seq"]?>">
									<button type="button" class="btn_minus" selectType="provider" seq="<?php echo $TPL_V1["provider_seq"]?>" onClick="gProviderSelect.select_delete('minus',$(this))"></button>
							</tr>
<?php }}?>
							</tbody>
						</table>
					</div>
				</div>
				<input type="hidden" name="provider_seq_list" value="<?php echo $TPL_VAR["event"]["provider_list"]?>" />
			</td>
		</tr>

		<tr class=" sales_tag_provider hide">
			<th>입점사 부담률 <span class="required_chk"></span></th>
			<td>
				<input type="text" name="salescostper" size="3" maxlength="3" value="<?php if($TPL_VAR["event"]["event_seq"]> 0&&$TPL_VAR["event"]["provider_name_list"]){?><?php echo $TPL_VAR["event"]["salescost_provider"]?><?php }else{?>0<?php }?>" class="onlynumber right" /> %

				<span class="desc red msg"></span>
				<input type="hidden" name="salescost_provider" value="<?php if($TPL_VAR["event"]["event_seq"]> 0&&$TPL_VAR["event"]["provider_name_list"]){?><?php echo $TPL_VAR["event"]["salescost_provider"]?><?php }else{?>0<?php }?>" />
			</td>
		</tr>

		<tr class="sales_admin">
			<th>본사 부담률</th>
			<td>
				<span class="percent"><?php if($TPL_VAR["event"]["event_seq"]> 0&&$TPL_VAR["event"]["provider_name_list"]){?><?php echo $TPL_VAR["event"]["salescost_admin"]?><?php }else{?>100<?php }?>%</span>
				<input type="hidden" name="salescost_admin" value="<?php if($TPL_VAR["event"]["event_seq"]> 0&&$TPL_VAR["event"]["provider_name_list"]){?><?php echo $TPL_VAR["event"]["salescost_admin"]?><?php }else{?>100<?php }?>" />	
			</td>
		</tr>
	</table>

	<div class="resp_message">- 할인 항목별 할인 금액 <a href="https://www.firstmall.kr/customer/faq/1240 " class="resp_btn_txt" target="_blank">자세히 보기</a></div>
<?php }?>

<?php if(serviceLimit('H_AD')){?>
	<div class='sellerCommissionSet mt20'>
		<div class="item-title">정산 기준에 따른 판매 수수료</div>

		<table class="table_basic thl">
			<tr>
				<th>수수료율</th>
				<td>
					<select name="rate_type_saco">
						<option value="equal" selected>현재 상품과 동일</option>	
						<option value="ignore">직접 입력</option>
						<option value="plus">추가 부과</option>
						<option value="minus">현재에서 제외</option>
					</select>
					<span class="rate_type_saco_minus rate_type_saco_plus rate_type_saco_ignore hide">
						<input type="text" class="<?php echo $TPL_VAR["only_numberic_type"]?> input_saller_rate" name="saco_value" size="5" value="<?php echo $TPL_VAR["event"]["saco_value"]?>" /> %					
					</span>
				</td>
			</tr>	
			
			<tr>
				<th>공급률</th>
				<td>
					<select name="rate_type_suco">
						<option value="equal" selected>현재 상품과 동일</option>	
						<option value="ignore">직접 입력</option>
						<option value="plus">추가 부과</option>
						<option value="minus">현재에서 제외</option>
					</select>
					<span class="rate_type_suco_minus rate_type_suco_plus rate_type_suco_ignore hide">
						<input type="text" class="<?php echo $TPL_VAR["only_numberic_type"]?> input_saller_rate" name="suco_value" size="5" value="<?php echo $TPL_VAR["event"]["suco_value"]?>" /> %
					</span>
				</td>
			</tr>

			<tr>
				<th>공급가</th>
				<td>
					<select name="rate_type_supr">
						<option value="equal" selected>현재 상품과 동일</option>	
						<option value="ignore">직접 입력</option>
						<option value="plus">추가 부과</option>
						<option value="minus">현재에서 제외</option>
					</select>
					<span class="rate_type_supr_minus rate_type_supr_plus rate_type_supr_ignore hide">
						<input type="text" class="<?php echo $TPL_VAR["only_numberic_type"]?> input_saller_rate" name="supr_value" size="5" value="<?php echo $TPL_VAR["event"]["supr_value"]?>" /> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

					</span>
				</td>
			</tr>
		</table>
	</div>
<?php }?>

	<div class="item-title">이벤트 상품</div>
	
	<table class="table_basic thl">
		<tr>
			<th>상품 선정 기준</th>
			<td>
				<div class="resp_radio event_type_multi hide">				
<?php if($TPL_VAR["operation_type"]!='light'){?><label><input type="radio" name="goods_rule_multi" value="all" <?php if($TPL_VAR["event"]["goods_rule"]=="all"){?>checked<?php }?> class="goods_rule" /> 전체</label>	<?php }?>
					<label><input type="radio" name="goods_rule_multi" value="category" <?php if($TPL_VAR["event"]["goods_rule"]=="category"){?>checked<?php }?>class="goods_rule"/> 카테고리</label>	
					<label><input type="radio" name="goods_rule_multi" value="goods_view" <?php if($TPL_VAR["event"]["goods_rule"]=="goods_view"){?>checked<?php }?>class="goods_rule"/> 상품</label>	
				</div>

				<div class="event_type_solo hide">
					<label><input type="radio" name="goods_rule_solo" value="goods_view" class="hide" class="goods_rule" checked/> 단독 상품</label>
				</div>
				
				<input type="hidden" name="goods_rule" value="<?php echo $TPL_VAR["event"]["goods_rule"]?>" />
			</td>
		</tr>

		<tr>
			<th>혜택 기준</th>
			<td>
				<table class="table_basic wx900 category goods_view solo" style="border-bottom:1px;">
					<colgroup>	
						<col width="7%"/>
						<col width="93%" />
						
					</colgroup>
					<tr>
						<th><button type="button" id="categoryItemAddBtn" class="btn_plus plusBtn"></button></th>
						<th>기준 설정</th>						
					</tr>
				</table>
				
				<div id="applyGoods">
				<table class="table_basic wx900">
					<colgroup>	
						<col width="7%" class="category goods_view solo"/>
						<col width="93%" />
					</colgroup>	
					<tbody>
<?php if($TPL_VAR["event"]["data_choice"]){?>
<?php if(is_array($TPL_R1=$TPL_VAR["event"]["data_choice"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;
$TPL_category_2=empty($TPL_V1["category"])||!is_array($TPL_V1["category"])?0:count($TPL_V1["category"]);
$TPL_goods_2=empty($TPL_V1["goods"])||!is_array($TPL_V1["goods"])?0:count($TPL_V1["goods"]);
$TPL_except_category_2=empty($TPL_V1["except_category"])||!is_array($TPL_V1["except_category"])?0:count($TPL_V1["except_category"]);
$TPL_except_goods_2=empty($TPL_V1["except_goods"])||!is_array($TPL_V1["except_goods"])?0:count($TPL_V1["except_goods"]);?>
					<tr class="cloneTr t_select_goods">
						<th class="center category goods_view solo">
							<button type="button" onClick="trDel(this)" class="btn_minus"></button>
						</th>

						<td class="clear">
						<table class="table_basic wx100 v3 thl">
						<tr>
							<th>혜택 적용 상품</th>
							<td>
								<span class="mr15 all hide">전체 상품</span>

								<div class="category hide">
									<input type="button" value="카테고리 선택" class="resp_btn active selectBtn btn_category_select" onclick="gCategorySelect.open({},eventObj.callbackCategoryList);" selectType="category"/>
									<div class="mt10 category_list">
										<table class="table_basic">
											<colgroup>
												<col width="85%" />
												<col width="15%" />
											</colgroup>
											<thead>
											<tr class="nodrag nodrop">
												<th>카테고리명</th>
												<th>삭제</th>	
											</tr>
											</thead>
											<tbody>
												<tr rownum=0 <?php if($TPL_category_2== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
													<td class="center" colspan="2">카테고리를 선택하세요</td>
												</tr>
<?php if(is_array($TPL_R2=$TPL_V1["category"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
												<tr rownum="<?php echo $TPL_V2["category_code"]?>">
													<td class="center"><?php echo $TPL_V2["category_name"]?></td>
													<td class="center">
														<input type="hidden" name='category_code[<?php echo $TPL_V1["index"]?>][]' class='category_code' value='<?php echo $TPL_V2["category_code"]?>' />
														<button type="button" class="btn_minus"  selectType="category" seq="<?php echo $TPL_V2["category_code"]?>" onClick="eventObj.select_delete('minus',$(this))"></button></td>
													</tr>
<?php }}?>
											</tbody>
										</table>
									</div>
								</div>

								<!--- 상품선택 --->
								<div class="goods_view goods_select_contents hide">
									<!--<input type="button" value="대량 업로드" class="select_goods_del resp_btn v3" onClick=""  />-->
									<input type="button" value="상품 선택" class="resp_btn active selectBtn btn_select_goods" onClick="selectGoods(this)" data-goodstype="choice_goods_<?php echo $TPL_I1+ 1?>"/>
									<input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" onClick="deleteGoods(this)"  />
									<div class="mt10">
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
												<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" value="goods" onClick="gGoodsSelect.checkAll(this)"></label></th>
<?php if(serviceLimit('H_AD')){?>
												<th>입점사명</th>
<?php }?>
												<th>상품명</th>
												<th>판매가</th>
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
													<tr rownum=0 <?php if($TPL_goods_2== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
														<td class="center" colspan="4">상품을 선택하세요</td>
													</tr>								
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
													<tr rownum="<?php echo $TPL_V2["goods_seq"]?>">
														<td><label class="resp_checkbox"><input type="checkbox" name='choice_goods_<?php echo $TPL_I1+ 1?>Tmp[]' class="chk" value='<?php echo $TPL_V2["goods_seq"]?>' /></label>
															<input type="hidden" name='choice_goods_<?php echo $TPL_I1+ 1?>[]' value='<?php echo $TPL_V2["goods_seq"]?>' />
															<input type="hidden" name="choice_goods_<?php echo $TPL_I1+ 1?>Seq[<?php echo $TPL_V2["goods_seq"]?>]" value="<?php echo $TPL_V2["issuegoods_seq"]?>" />
															</td>
<?php if(serviceLimit('H_AD')){?>
															<td><?php echo $TPL_V2["provider_name"]?></td>
<?php }?>
															<td class='left'>
																<div class="image"><img src="<?php echo viewImg($TPL_V2["goods_seq"],'thumbView')?>" width="50"></div>
																<div class="goodsname">
<?php if($TPL_V2["goods_code"]){?><div>[상품코드:<?php echo $TPL_V2["goods_code"]?>]</div><?php }?>
																	<div><?php echo $TPL_V2["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V2["goods_seq"]?>" target="_blank">[<?php echo $TPL_V2["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V2["goods_name"]), 30)?></a></div>
																</div>
															</td>
															<td class='right'><?php echo get_currency_price($TPL_V2["price"], 2)?></td>
														</tr>
<?php }}?>
														</tbody>
													</table>
												</div>
										</div>
										</div>
										
										<div class="resp_checkbox"><label class="all category hide"><input type="checkbox" name="except_select"  <?php if($TPL_V1["except_category"]||$TPL_V1["except_goods"]){?>checked<?php }?>/> 혜택 제외 카테고리/상품 선택</label></div>
									</td>
								</tr>

								<!--- 혜택 제외 카테고리/상품--->
								<tr class="except_select_contents <?php if(!$TPL_V1["except_category"]||!$TPL_V1["except_goods"]){?>hide<?php }?>">									
									<th>혜택 제외 카테고리/상품</th>										
									<td class="clear">
										<ul class="ul_list_02">
											<li>												
												<input type="button" value="카테고리 선택" class="resp_btn active selectBtn btn_category_select" onclick="gCategorySelect.open({},eventObj.callbackCategoryList);" selectType="except_category"/>
												<div class="mt10 except_category_list">
													<table class="table_basic">
													<colgroup>
														<col width="85%" />
														<col width="15%" />
													</colgroup>
													<thead>
														<tr class="nodrag nodrop">
															<th>카테고리명</th>
															<th>삭제</th>	
													</tr>
													</thead>
													<tbody>
													<tr rownum=0 <?php if($TPL_except_category_2== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
														<td class="center" colspan="2">카테고리를 선택하세요</td>
													</tr>
<?php if($TPL_except_category_2){foreach($TPL_V1["except_category"] as $TPL_V2){?>
													<tr rownum="<?php echo $TPL_V2["category_code"]?>">
														<td class="center"><?php echo $TPL_V2["category_name"]?></td>
														<td class="center">
														<input type="hidden" name='except_category_code[<?php echo $TPL_V1["index"]?>][]' class='category_code' value='<?php echo $TPL_V2["category_code"]?>' />
														<button type="button" class="btn_minus"  selectType="except_category" seq="<?php echo $TPL_V2["category_code"]?>" onClick="eventObj.select_delete('minus',$(this))"></button></td>
													</tr>
<?php }}?>
													</tbody>
												</table>	
												</div>
											</li>
											<li>
											<input type="button" value="상품 선택" class="resp_btn active selectBtn btn_select_goods" onClick="selectGoods(this)" data-goodstype="except_goods_<?php echo $TPL_I1+ 1?>"/>
											<input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" onClick="deleteGoods(this)"  />
											<div class="mt10">
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
															<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" value="except_goods" onClick="gGoodsSelect.checkAll(this)"></label></th>
<?php if(serviceLimit('H_AD')){?>
															<th>입점사명</th>
<?php }?>
															<th>상품명</th>
															<th>판매가</th>
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
															<tr rownum=0 <?php if($TPL_except_goods_2== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
																<td class="center" colspan="<?php if(serviceLimit('H_AD')){?>5<?php }else{?>4<?php }?>">상품을 선택하세요</td>
															</tr>
														<!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->								
<?php if($TPL_except_goods_2){foreach($TPL_V1["except_goods"] as $TPL_V2){?>
															<tr rownum="<?php echo $TPL_V2["goods_seq"]?>">
																<td><div class="resp_checkbox"><label><input type="checkbox" name='except_goods_<?php echo $TPL_I1+ 1?>Tmp[]' class="chk" value='<?php echo $TPL_V2["goods_seq"]?>' /></label></div>
																	<input type="hidden" name="except_goods_<?php echo $TPL_I1+ 1?>[]" value="<?php echo $TPL_V2["goods_seq"]?>" />
<?php if(serviceLimit('H_AD')){?>
																<td><?php echo $TPL_V2["provider_name"]?></td>
<?php }?>
																<td class='left'>
																	<div class="image"><img src="<?php echo viewImg($TPL_V2["goods_seq"],'thumbView')?>" width="50"></div>
																	<div class="goodsname">
<?php if($TPL_V2["goods_code"]){?><div>[상품코드:<?php echo $TPL_V2["goods_code"]?>]</div><?php }?>
																		<div><?php echo $TPL_V2["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V2["goods_seq"]?>" target="_blank">[<?php echo $TPL_V2["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V2["goods_name"]), 30)?></a></div>
																	</div>
																</td>
																<td class='right'><?php echo get_currency_price($TPL_V2["price"], 2)?></td>
															</tr>
<?php }}?>
														</tbody>
													</table>
												</div>																		
											</div>									
											</li>
										</ul>
									</td>						
								</tr>
								<tr>
									<th>
										혜택 <span class="required_chk"></span>
										<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip12')"></span>
									</th>								
									<td>										
										<select id name="price_type">
											<option value="sale" <?php if($TPL_V1["target_sale"]== 0||$TPL_V1["target_sale"]== 2){?>selected<?php }?> />판매가</option>
											<option value="price" <?php if($TPL_V1["target_sale"]== 1){?>selected<?php }?> />정가</option>
										</select>

										<input type="text" name="event_sale[<?php echo $TPL_K1?>]" class="event_sale onlynumber right" maxlength="10" size="10" value="<?php echo get_currency_price($TPL_V1["event_sale"], 1)?>" />

										<span class="price_type_sale <?php if($TPL_V1["target_sale"]== 1){?>hide<?php }?>">
											<select name="uint">
												<option value="percent" <?php if($TPL_V1["target_sale"]== 0||$TPL_V1["target_sale"]== 1){?>selected<?php }?> />%</option>
												<option value="won" <?php if($TPL_V1["target_sale"]== 2){?>selected<?php }?> /><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?></option>
										</select>										
										</span>

										<span class="price_type_price <?php if($TPL_V1["target_sale"]== 0||$TPL_V1["target_sale"]== 2){?>hide<?php }?>">%</span>				
										<input type="hidden" name="target_sale[<?php echo $TPL_K1?>]" class='target_sale' value="<?php echo $TPL_V1["target_sale"]?>" />										
									</td>
								</tr>

								<tr>
									<th>
										추가 혜택
										<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip13')"></span>
									</th>
									
									<td>
										<div class="resp_checkbox">
											<label><input type="checkbox" name="reserve_select" <?php if($TPL_V1["event_reserve"]){?>checked<?php }?>/> 캐시 지급</label>
											<label <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?>style="display:none;"<?php }?>><input type="checkbox" name="point_select"  <?php if($TPL_V1["event_point"]){?>checked<?php }?> /> 포인트 지급</label>
											 
										</div>
									</td>
								</tr>

								<tr class="reserve_select_contents <?php if($TPL_V1["event_reserve"]==''){?>hide<?php }?>">
									<th>캐시 추가 지급</th>								
									<td>
										<input type="text" name="event_reserve[<?php echo $TPL_K1?>]" class="onlynumber right" maxlength="10" size="10" value="<?php echo $TPL_V1["event_reserve"]?>" /> %
									</td>
								</tr>

								<tr class="point_select_contents <?php if($TPL_V1["event_point"]==''){?>hide<?php }?>">
									<th>포인트 추가 지급</th>								
									<td>
										<input type="text" name="event_point[<?php echo $TPL_K1?>]" class="onlynumber right" maxlength="10" size="10" value="<?php echo $TPL_V1["event_point"]?>" /> %
									</td>
								</tr>								
							</table>							
						</td>
					</tr>
<?php }}?>
<?php }else{?>
					<tr class="cloneTr t_select_goods">											
						<th class="center category goods_view solo">
							<button type="button" onClick="trDel(this)" class="btn_minus"></button>
						</th>

						<td class="clear">							
							<table class="table_basic wx100 v3 thl">								
								<tr>
									<th>혜택 적용 상품</th>								
									<td>																		
										<span class="mr15 all hide">전체 상품</span>

										<div class="category hide">
											<input type="button" value="카테고리 선택" class="resp_btn active selectBtn btn_category_select" onclick="gCategorySelect.open({},eventObj.callbackCategoryList);" selectType="category"/>
											<div class="mt10 category_list">
												<table class="table_basic">
													<colgroup>
														<col width="85%" />
														<col width="15%" />
													</colgroup>
													<thead>
														<tr class="nodrag nodrop">
															<th>카테고리명</th>
															<th>삭제</th>	
								</tr>							
													</thead>
													<tbody>
														<tr rownum=0>
															<td class="center" colspan="2">카테고리를 선택하세요</td>
					</tr>
					</tbody>
				</table>			
											</div>			
										</div>
					
										<div class="goods_view goods_select_contents hide">											
											<input type="button" value="상품 선택" class="resp_btn active selectBtn btn_select_goods" onClick="selectGoods(this)" data-goodstype="choice_goods_1" />
											<input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" onClick="deleteGoods(this)" />				
											<div class="mt10">
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
																<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" value="goods"  onClick="gGoodsSelect.checkAll(this)"></label></th>
<?php if(serviceLimit('H_AD')){?>
																<th>입점사명</th>
<?php }?>
																<th>상품명</th>
																<th>판매가</th>
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
															<tr rownum=0>
																<td class="center" colspan="4">상품을 선택하세요</td>
		</tr>

														</tbody>
													</table>
					</div>
				</div>
				</div>																	
										
										<div class="resp_checkbox"><label class="all category hide"><input type="checkbox" name="except_select"/> 혜택 제외 카테고리/상품 선택</label></div>
			</td>						
		</tr>
	
								<tr class="except_select_contents hide">									
									<th>혜택 제외 카테고리/상품</th>										
									<td class="clear">
										<ul class="ul_list_02">
											<li>										
												<input type="button" value="카테고리 선택" class="resp_btn active selectBtn" onClick="gCategorySelect.open({},eventObj.callbackCategoryList)" selectType="except_category" />
												<div class="mt10 except_category_list">
													<table class="table_basic">
														<colgroup>
															<col width="85%" />
															<col width="15%" />
														</colgroup>
														<thead>
															<tr class="nodrag nodrop">
																<th>카테고리명</th>
																<th>삭제</th>	
															</tr>
														</thead>
														<tbody>
															<tr rownum=0>
																<td class="center" colspan="2">카테고리를 선택하세요</td>
		</tr>
														</tbody>
													</table>
												</div>		
											</li>

											<li>																				
												<input type="button" value="상품 선택" class="resp_btn active selectBtn btn_select_goods" onClick="selectGoods(this)" data-goodstype="except_goods_1"/>
												<input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" onClick="deleteGoods(this)"  />				
												<div class="mt10">
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
																	<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" value="except_goods" onClick="gGoodsSelect.checkAll(this)"></label></th>
<?php if(serviceLimit('H_AD')){?>
																	<th>입점사명</th>
<?php }?>
																	<th>상품명</th>
																	<th>판매가</th>
		</tr>
															</tbody>
														</table>
													</div>
													<div class="goods_list" >
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
																<tr rownum=0>
																	<td class="center" colspan="4">상품을 선택하세요</td>
		</tr>
															</tbody>
														</table>
													</div>
												</div>										
											</li>
										</ul>
			</td>						
		</tr>
		<tr>
			<th>
				혜택 <span class="required_chk"></span>
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip12')"></span>
			</th>								
			<td>										
				<select name="price_type">
					<option value="sale">판매가</option>
					<option value="price">정가</option>
				</select>

										<input type="text" name="event_sale[0]" class="event_sale onlynumber right" maxlength="10" size="6" value="" />

										<span class="price_type_sale">
					<select name="uint">
						<option value="percent">%</option>
												<option value="won"><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?></option>
				</select>										
				</span>

				<span class="price_type_price hide">%</span>				
										<input type="hidden" name="target_sale[0]" class='target_sale' value="0" />
			</td>
		</tr>

		<tr>
			<th>
				추가 혜택
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip13')"></span>
			</th>
			
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="reserve_select" /> 캐시 지급</label>
											<label <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?>style="display:none;"<?php }?>><input type="checkbox" name="point_select" /> 포인트 지급</label>											
				</div>
			</td>
		</tr>

		<tr class="reserve_select_contents hide">
			<th>캐시 추가 지급</th>								
									<td><input type="text" name="event_reserve[0]" class="onlynumber right" maxlength="10" size="3" value="" /> %</td>
		</tr>

		<tr class="point_select_contents hide">
			<th>포인트 추가 지급</th>								
									<td><input type="text" name="event_point[0]" class="onlynumber right" maxlength="10" size="3" value="" /> %</td>
		</tr>			
							</table>							
						</td>
					</tr>				
<?php }?>
					</tbody>
				</table>
				</div>
			</td>
		</tr>
	</table>
	<div class="resp_message">- 캐시 및 포인트 설정은 설정 > <a href="/admin/setting/reserve" target="_blank" class="resp_btn_txt">캐시/포인트/예치금</a>에 따릅니다.</div>

	<div class="item-title">혜택 중복 제한</div>

	<table class="table_basic thl">		
		<tr>
			<th>쿠폰</th>
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="use_coupon" value="n" <?php if($TPL_VAR["event"]&&$TPL_VAR["event"]["use_coupon"]=='n'){?>checked<?php }?> /> 상품</label>
					<label><input type="checkbox" name="use_coupon_shipping" value="n" <?php if($TPL_VAR["event"]&&$TPL_VAR["event"]["use_coupon_shipping"]=='n'){?>checked<?php }?>/> 배송비</label>
					<label><input type="checkbox" name="use_coupon_ordersheet" value="n" <?php if($TPL_VAR["event"]&&$TPL_VAR["event"]["use_coupon_ordersheet"]=='n'){?>checked<?php }?>/> 주문서</label>
				</div>
			</td>
		</tr>
<?php if(serviceLimit('H_NFR')){?>
		<tr>
			<th>할인 코드</th>
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="use_code" value="n" <?php if($TPL_VAR["event"]&&$TPL_VAR["event"]["use_code"]=='n'){?>checked<?php }?> /> 상품코드</label>
					<label><input type="checkbox" name="use_code_shipping" value="n" <?php if($TPL_VAR["event"]&&$TPL_VAR["event"]["use_code"]=='n'){?>checked<?php }?> /> 배송비 코드</label>
				</div>
			</td>
		</tr>
<?php }?>
	</table>

	<div class="item-title">이벤트 상세페이지</div>

	<table class="table_basic thl">		
<?php if($TPL_VAR["operation_type"]=='light'){?>
		<tr>
			<th>이벤트 배너</th>
			<td id="giftContentsContainer">			
				<textarea name="event_page_banner" id="event_page_banner" class="hide" style="width:98%;height:200px;"><?php echo $TPL_VAR["event"]["event_page_banner"]?></textarea>
				<button type="button" id="popupOpenBtn" class="popupOpenBtn resp_btn v2" data-name="giftContents">수정</button>				
			</td>
		</tr>
		<tr>
			<th>상세 페이지 설정</th>
			<td id="detailPageSettingContainer" >
				<button type="button" class="popupOpenBtn resp_btn v2" data-name="detailPageSetting">설정</button>			
			</td>
		</tr>
		
		<tr>
			<th>상품 디스플레이</th>
			<td id="goodInfoStyleContainer">
				<button type="button" class="popupOpenBtn resp_btn v2" data-name="goodInfoStyle">설정</button>				
			</td>
		</tr>		
<?php }?>

		<tr>
			<th>이벤트 공유</th>
			<td id="goodInfoStyleContainer">
				<button type="button" class="popupOpenBtn resp_btn" data-name="snsShare">보기</button>				
			</td>
		</tr>	
<?php if($TPL_VAR["event"]["event_seq"]){?>
		<tr>
			<th>QR 코드</th>
			<td>
				<?php echo qrcode("event",$TPL_VAR["event"]["event_seq"], 4)?>

				<a href="javascript:;" class="qrcodeGuideBtn valign-middle resp_btn" key="event" value="<?php echo $TPL_VAR["event"]["event_seq"]?>" >자세히</a>
			</td>
		</tr>
<?php }?>
	</table>

	<div class="item-title">
		전체 이벤트 페이지
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip11')"></span>
	</div>

	<table class="table_basic thl">		
		<tr>
			<th>이벤트 노출 여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="event_view" value="y" <?php if($TPL_VAR["event"]["event_view"]=='y'){?> checked <?php }?> > 노출</label>
					<label><input type="radio" name="event_view" value="n" <?php if($TPL_VAR["event"]["event_view"]=='n'||$TPL_VAR["event"]["event_view"]==''){?> checked <?php }?> > 미노출</label>
				</div>
			</td>
		</tr>	
		
		<tr class="event_view_y hide">
			<th>이벤트 썸네일 설정</th>

<?php if($TPL_VAR["operation_type"]=='light'){?>
			<td>			
				<div class="webftpFormItem">				
					<label class="resp_btn v2"><input type="file" id="eventBannerUploadButton" class="uploadify">파일선택</label>				
					<input type="hidden" class="webftpFormItemInput" name="event_banner" value="<?php echo $TPL_VAR["event"]["event_banner"]?>" size="30" maxlength="255" />				
					<div class="preview_image"></div>
				</div>
			</td>
<?php }else{?>				
			<td class="clear">
				<table class="table_basic thl v3">									
					<tbody>
						<tr>
							<th>PC</th>								
							<td>
								<div class="webftpFormItem">									
									<label class="resp_btn v2"><input type="file" id="eventBannerUploadButton" class="uploadify">파일선택</label>
									<input type="hidden" class="webftpFormItemInput" name="event_banner" value="<?php echo $TPL_VAR["event"]["event_banner"]?>" size="30" maxlength="255" />									
									<div class="preview_image"></div>
								</div>
							</td>
						</tr>
						<tr>
							<th>모바일</th>								
							<td>
								<div class="webftpFormItem">								
									<label class="resp_btn v2"><input type="file" id="m_eventBannerUploadButton" class="uploadify">파일선택</label>
									<input type="hidden" class="webftpFormItemInput" name="m_event_banner" value="<?php echo $TPL_VAR["event"]["m_event_banner"]?>" size="30" maxlength="255" />
									<div class="preview_image"></div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
<?php }?>		
		</tr>	

		<tr class="event_view_y hide">
			<th>타이틀</th>
<?php if($TPL_VAR["operation_type"]=='light'){?>
			<td>
				<div class="resp_limit_text limitTextEvent">
					<input type="text" name="event_introduce" size="50"  maxlength="30" value="<?php echo $TPL_VAR["event"]["event_introduce"]?>" />
				</div>				
				<input type="text" name="event_introduce_color" value="<?php if($TPL_VAR["event"]["event_introduce_color"]){?><?php echo $TPL_VAR["event"]["event_introduce_color"]?><?php }else{?>#333333<?php }?>" class="colorpicker"/>
			</td>
<?php }else{?>			
			<td class="clear">
				<table class="table_basic thl v3">									
					<tbody>
						<tr>
							<th>PC</th>								
							<td>
								<div class="resp_limit_text limitTextEvent">
									<input type="text" name="event_introduce" size="50"  maxlength="30" value="<?php echo $TPL_VAR["event"]["event_introduce"]?>" />
								</div>								
								<input type="text" name="event_introduce_color" value="<?php if($TPL_VAR["event"]["event_introduce_color"]){?><?php echo $TPL_VAR["event"]["event_introduce_color"]?><?php }else{?>#333333<?php }?>" class="colorpicker"/> 
							</td>
						</tr>

						<tr>
							<th>모바일</th>								
							<td>
								<div class="resp_limit_text limitTextEvent">
									<input type="text" name="m_event_introduce" size="50"  maxlength="30" value="<?php echo $TPL_VAR["event"]["m_event_introduce"]?>" />
								</div>									
								<input type="text" name="m_event_introduce_color" value="<?php if($TPL_VAR["event"]["m_event_introduce_color"]){?><?php echo $TPL_VAR["event"]["m_event_introduce_color"]?><?php }else{?>#333333<?php }?>" class="colorpicker"/>
							</td>
						</tr>
					</tbody>
				</table>				
			</td>
<?php }?>
		</tr>	

		<tr class="event_view_y hide">
			<th>썸네일 링크 연결</th>
			<td>				
				<label class="event_type_multi hide">
					<input type="radio" name="show_link" value="view" <?php if($TPL_VAR["event"]["show_link"]=='view'||$TPL_VAR["event"]["show_link"]==""){?>checked<?php }?> class="hide"> 
					이벤트 페이지
				</label>
				<label class="event_type_solo hide">
					<input type="radio" name="show_link" value="list" <?php if($TPL_VAR["event"]["show_link"]=='list'){?>checked<?php }?> class="hide"> 
					상품 상세 페이지
				</label>
				
			</td>
		</tr>	
	</table>

	<div class="item-title">상품 상세 페이지</div>

	<table class="table_basic thl productDetailPageItem">		
		<tr>
			<th>이벤트 노출 여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="banner_view" value="y" <?php if($TPL_VAR["event"]["banner_view"]=='y'){?> checked <?php }?> /> 노출</label>
					<label><input type="radio" name="banner_view" value="n" <?php if($TPL_VAR["event"]["banner_view"]=='n'||$TPL_VAR["event"]["banner_view"]==''){?> checked <?php }?> /> 미노출</label>
				</div>				
			</td>
		</tr>		
<?php if($TPL_VAR["operation_type"]!='light'){?>
		<tr class="banner_view_y hide">
			<th>이벤트 배너</th>
			<td>
				<div class="webftpFormItem">					
					<label class="resp_btn v2"><input type="file" id="bannerUploadButton" class="uploadify">파일선택</label>					
					<input type="hidden" class="webftpFormItemInput" name="banner_filename" value="<?php echo $TPL_VAR["event"]["banner_filename"]?>" size="30" maxlength="255" />
					<div class="preview_image"></div>
				</div>
			</td>
		</tr>	
<?php }else{?>		
		<tr class="banner_view_y hide">
			<th>이벤트 소개</th>
			<td><input type="text" class="wp95" name="goods_desc_popup" value="<?php echo $TPL_VAR["event"]["goods_desc_popup"]?>"/></td>
		</tr>	
<?php }?>	
	</table>

<?php if($TPL_VAR["operation_type"]!='light'){?>
	<table class="table_basic thl event_type_solo hide">	
		<tr>
			<th>상품 상세 꾸미기</th>
			<td>
				<textarea name="title_contents" id="title_contents" class="hide" style="width:98%;height:200px;"><?php echo $TPL_VAR["event"]["title_contents"]?></textarea>
				<input type="hidden" name="bgcolor" value="<?php if($TPL_VAR["event"]["bgcolor"]){?><?php echo $TPL_VAR["event"]["bgcolor"]?><?php }else{?>#76cdd4<?php }?>">
				<button type="button" class="popupOpenBtn resp_btn v2" data-name="soloProductDetailPageSetting">설정</button>	
			</td>
		</tr>
	</table>
<?php }?>

</div>

<div id="detailPageSetting" class="hide">
	<div class="item-title">상세 페이지 설정</div>
	<table class="table_basic">						
		<tr>
			<th>검색필터</th>
			<td>	
				<div class="resp_checkbox">
<?php if(is_array($TPL_R1=$TPL_VAR["aPageManager"]["filter_col"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<?php if(in_array($TPL_K2,explode(',',$TPL_VAR["event"]["search_filter"]))){?>
					<label><input type="checkbox" name="search_filter[]" value="<?php echo $TPL_K2?>" checked /> <?php echo $TPL_V2?></label>
<?php }else{?>
					<label><input type="checkbox" name="search_filter[]" value="<?php echo $TPL_K2?>" /> <?php echo $TPL_V2?></label>
<?php }?>
<?php }}?>				
<?php }}?>
				</div>
			</td>
		</tr>
		
		<tr>
			<th>정렬</th>
			<td>
				<div class="resp_radio">
<?php if(is_array($TPL_R1=$TPL_VAR["aPageManager"]["order_col"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1==$TPL_VAR["event"]["search_orderby"]){?>
					<label><input type="radio" name="search_orderby" value="<?php echo $TPL_K1?>" checked /> <?php echo $TPL_V1?></label>
<?php }else{?>
					<label><input type="radio" name="search_orderby" value="<?php echo $TPL_K1?>" /> <?php echo $TPL_V1?></label>
<?php }?>
<?php }}?>
				</div>
			</td>
		</tr>

		<tr>
			<th>상태</th>
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="search_status[]" value="" checked disabled /> <?php echo $TPL_VAR["aPageManager"]["status"]["desc"]?></label>
<?php if(is_array($TPL_R1=$TPL_VAR["aPageManager"]["status"]["col"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if(in_array($TPL_K1,explode(',',$TPL_VAR["event"]["search_status"]))){?>
					<label><input type="checkbox" name="search_status[]" value="<?php echo $TPL_K1?>" checked /> <?php echo $TPL_V1?></label>
<?php }else{?>
					<label><input type="checkbox" name="search_status[]" value="<?php echo $TPL_K1?>" /> <?php echo $TPL_V1?></label>
<?php }?>
<?php }}?>
				</div>
			</td>
		</tr>

		<tr>
			<th>이미지 사이즈</th>
			<td>
				<select name="goods_info_image">
<?php if(is_array($TPL_R1=config_load('goodsImageSize'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_VAR["event"]["goods_info_image"]==$TPL_K1){?>
					<option value="<?php echo $TPL_K1?>" selected><?php echo $TPL_V1["name"]?></option>
<?php }else{?>
					<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["name"]?></option>
<?php }?>
<?php }}?>
				</select>
			</td>
		</tr>						
	</table>

	<div class="footer">
		<button type="button" class="resp_btn active size_XL confirmPopupInfoBtn">확인</button>
		<button type="button" class="btnLayClose resp_btn v3 size_XL">취소</button>
	</div>
</div>


<div id="goodInfoStyle" class="hide" >
	<div class="item-title">상품 디스플레이</div>	
<?php $this->print_("goods_info_style",$TPL_SCP,1);?>

	<div class="footer">
		<button type="button" class="confirmPopupInfoBtn resp_btn active size_XL">확인</button>
		<button type="button" class="btnLayClose resp_btn v3 size_XL">취소</button>
	</div>
</div>

<div id="snsShare" class="hide">
	<div class="item-title">이벤트 공유 치환코드</div>
	<table class="table_basic tdc">		
		<colgroup>
			<col width="16.6%" />
			<col width="16.6%" />
			<col width="16.6%" />	
			<col width="16.6%" />
			<col width="16.6%" />
			<col width="16.6%" />
		</colgroup>
		
		<thead>
			<tr>
				<th>전체</th>
				<th>페이스북</th>
				<th>트위터</th>	
				<th>카카오톡</th>
				<th>카카오스토리</th>
				<th>라인</th>	
			</tr>
		</thead>		
		<tbody>
			<tr>
				<td><input type="button" class="copy_qrcode_btn resp_btn" data-code="{=snslinkurl('<?php echo $TPL_VAR["snsevent"]?>', '이벤트명')}"  onclick="copyContent($(this).data('code'))" value="복사"/></td>					
				<td><input type="button" class="copy_qrcode_btn resp_btn" data-code="{=snslinkurl('<?php echo $TPL_VAR["snsevent"]?>', '이벤트명','fa')//페이스북}"  onclick="copyContent($(this).data('code'))" value="복사"/></td>
				<td><input type="button" class="copy_qrcode_btn resp_btn" data-code="{=snslinkurl('<?php echo $TPL_VAR["snsevent"]?>', '이벤트명','tw')//트위터}"  onclick="copyContent($(this).data('code'))" value="복사"/></td>
				<td><input type="button" class="copy_qrcode_btn resp_btn" data-code="{=snslinkurl('<?php echo $TPL_VAR["snsevent"]?>', '이벤트명','ka')//카카오톡}"  onclick="copyContent($(this).data('code'))" value="복사"/></td>
				<td><input type="button" class="copy_qrcode_btn resp_btn" data-code="{=snslinkurl('<?php echo $TPL_VAR["snsevent"]?>', '이벤트명','ka')//카카오톡}"  onclick="copyContent($(this).data('code'))" value="복사"/></td>
				<td><input type="button" class="copy_qrcode_btn resp_btn" data-code="{=snslinkurl('<?php echo $TPL_VAR["snsevent"]?>', '이벤트명','line')//LINE}"  onclick="copyContent($(this).data('code'))"value="복사"/></td>
			</tr>
		<tbody>
	</table>
	<div class="resp_message">- SNS 공유하기 활용 방법 <a href="https://www.firstmall.kr/customer/faq/1192" class="resp_btn_txt" target="_blank">자세히 보기</a></div>
	<div class="footer">		
		<button type="button" class="btnLayClose resp_btn v3 size_XL">닫기</button>
	</div>
</div>

<div id="giftContents">
	<textarea name="event_page_banner_tmp" id="event_page_banner_tmp" style="width:98%;height:200px;" contentHeight="200px"><?php echo $TPL_VAR["event"]["event_page_banner"]?></textarea>
	<div class="footer">
		<button type="button" class="confirmPopupBannerBtn resp_btn active size_XL">확인</button>
		<button type="button" class="btnLayClose resp_btn v3 size_XL" target="giftContents">취소</button>
	</div>
</div>

<div id="soloProductDetailPageSetting">
	<table class="table_basic thl">
		<tbody>		
		<tr>
			<th>타이틀</th>
			<td>
				<textarea name="title_contents_tmp" id="title_contents_tmp" style="width:98%; height:100px;" contentHeight="150px"><?php echo $TPL_VAR["event"]["title_contents"]?></textarea>
			</td>
		</tr>
		<tr>
			<th>배경색</th>
			<td>				
				<ul id="bgcolorDiv">								
				</ul>				
			</td>
		</tr>
		<tr>
			<th>예시</th>
			<td>
				<img src="/admin/skin/default/images/common/img_event_detail.gif" width="90%">
			</td>
		</tr>
	</table>

	<div class="footer">
		<button type="button" class="soloProductDetailPageBtn resp_btn active size_XL">확인</button>
		<button type="button" class="btnLayClose resp_btn v3 size_XL" target="soloProductDetailPageSetting">취소</button>
	</div>
</div>


<div id="lay_seller_select"></div><!-- 입점사 선택 레이어 -->
<div id="lay_goods_select"></div><!-- 상품선택 레이어 -->
<div id="lay_category_select"></div><!-- 카테고리 선택 레이어 -->
<div id="salecost_info"></div>
<div id="seller_select"></div>

</form>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>