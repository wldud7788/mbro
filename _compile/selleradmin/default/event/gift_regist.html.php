<?php /* Template_ 2.2.6 2022/05/17 12:29:05 /www/music_brother_firstmall_kr/selleradmin/skin/default/event/gift_regist.html 000051713 */  $this->include_("qrcode");
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);
$TPL_ship_grp_list_1=empty($TPL_VAR["ship_grp_list"])||!is_array($TPL_VAR["ship_grp_list"])?0:count($TPL_VAR["ship_grp_list"]);
$TPL_issuecategorys_1=empty($TPL_VAR["issuecategorys"])||!is_array($TPL_VAR["issuecategorys"])?0:count($TPL_VAR["issuecategorys"]);
$TPL_issuegoods_1=empty($TPL_VAR["issuegoods"])||!is_array($TPL_VAR["issuegoods"])?0:count($TPL_VAR["issuegoods"]);
$TPL_defaultGifts_1=empty($TPL_VAR["defaultGifts"])||!is_array($TPL_VAR["defaultGifts"])?0:count($TPL_VAR["defaultGifts"]);
$TPL_priceLoop_1=empty($TPL_VAR["priceLoop"])||!is_array($TPL_VAR["priceLoop"])?0:count($TPL_VAR["priceLoop"]);
$TPL_qtyGifts_1=empty($TPL_VAR["qtyGifts"])||!is_array($TPL_VAR["qtyGifts"])?0:count($TPL_VAR["qtyGifts"]);
$TPL_qtyLoop_1=empty($TPL_VAR["qtyLoop"])||!is_array($TPL_VAR["qtyLoop"])?0:count($TPL_VAR["qtyLoop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=120824"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=120824"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gCategorySelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gGoodsSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gGiftGoodsSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/giftRegist.js?mm=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">
$(function(){

	var sGlUrl		= "<?php echo get_connet_protocol()?><?php echo $_SERVER["HTTP_HOST"]?>/link/etc/"+encodeURIComponent($(".event_view_btn").data("tpl_path"));
	var sDesignUrl	= sGlUrl;
	
<?php if($_GET["mode"]=="new"){?>
	//쿠폰신규생성 후 뒤로가기 시 리스트로 이동
	history.pushState(null, null, location.href);
		window.onpopstate = function () {
			document.location.href="../event/gift_catalog";
	};
<?php }?>

	/*<?php if($TPL_VAR["operation_type"]=='light'){?> 라이트 버전일 경우 주소*/
	sGlUrl			= "<?php echo get_connet_protocol()?><?php echo $_SERVER["HTTP_HOST"]?>/promotion/gift_view?gift="+$(".event_view_btn").data("code");
	/*<?php }?>*/
	
	
	// 서브밋 발생시 딤드처리
	$(":submit").on("click",function(){
		loadingStart();
	});

	$(".colorpicker").customColorPicker();
	
	// ajax 이미지 업로드 이벤트 바인딩
	$('#bannerUploadButton').createAjaxFileUpload(uploadConfig, uploadCallback);
	$('#eventBannerUploadButton').createAjaxFileUpload(uploadConfig, uploadCallback);
	$('#m_eventBannerUploadButton').createAjaxFileUpload(uploadConfig, uploadCallback);

<?php if($TPL_VAR["event"]["banner_filename"]){?>imgUploadEvent("#bannerUploadButton", "", "/data/event/", "<?php echo $TPL_VAR["event"]["banner_filename"]?>")<?php }?>		
<?php if($TPL_VAR["event"]["event_banner"]){?>imgUploadEvent("#eventBannerUploadButton", "", "/data/event/", "<?php echo $TPL_VAR["event"]["event_banner"]?>")<?php }?>	
<?php if($TPL_VAR["event"]["m_event_banner"]){?>imgUploadEvent("#m_eventBannerUploadButton", "", "/data/event/", "<?php echo $TPL_VAR["event"]["m_event_banner"]?>")<?php }?>

	$(".select_date").click(function() {
		switch($(this).attr("id")) {
			case 'today' :
				$("input[name='start_date']").val(getDate(0));
				$("input[name='end_date']").val(getDate(0));
				break;
			case '3day' :
				$("input[name='start_date']").val(getDate(0));
				$("input[name='end_date']").val(getDate(-3));
				break;
			case '1week' :
				$("input[name='start_date']").val(getDate(0));
				$("input[name='end_date']").val(getDate(-7));
				break;
			case '1month' :
				$("input[name='start_date']").val(getDate(0));
				$("input[name='end_date']").val(getDate(-30));
				break;
			case '3month' :
				$("input[name='start_date']").val(getDate(0));
				$("input[name='end_date']").val(getDate(-90));
				break;
			default :
				$("input[name='start_date']").val('');
				$("input[name='end_date']").val('');
				break;
		}
	});
	
	/*<?php if(!$TPL_VAR["event"]["provider_seq"]){?>*/
	$(".select_date").eq(3).trigger("click");
	/*<?php }?>*/

	/*<?php if($TPL_VAR["event"]["provider_seq"]){?>*/
	$("select[name='provider_seq']").find("option[value='<?php echo $TPL_VAR["event"]["provider_seq"]?>']").attr('selected', true);
	/*<?php }?>*/

	$("input[name='goods_rule']").click(function(){
		goods_rule_type();
	});


	/*<?php if($TPL_VAR["gift_gb"]=='order'){?>*/
	$("input[name='goods_rule']").on("change", function(){
		var provider_seq	= $(".provider_seq").val();
		var ship_grp_seq	= $("#ship_grp_seq").val();
		var flag			= false;
		//if(!provider_seq)	{ alert('보내는 판매자를 먼저 지정해주세요.');	flag = true; }
		//if(!ship_grp_seq)	{ alert('배송그룹을 선택해주세요.');			flag = true; }
		if(flag) $("input[name='goods_rule']").eq(0).prop("checked",true).trigger("click");
	});
	/*<?php }?>*/

	// 보내는 판매자 선택 :: 2016-11-08 lwh
	$("select[name='provider_seq_selector']").combobox().change(function(){
		$("#ship_grp_seq").html('<option value="">배송그룹 선택</option>');
		if( $(this).val() > 0 ){
			$("input[name='provider_seq']").val($(this).val());
			$("input[name='provider_name']").val($("option:selected",this).text());
			$("input[name='goods_rule']").eq(0).prop("checked",true).trigger("click");

			// 배송그룹 검색
			$.ajax({
				'type': "get",
				'url': "../event/ship_grp_ajax",
				'data': "provider_seq="+$(this).val(),
				'dataType': 'json',
				success: function(res){
					$.each(res, function(){
						var opt = '<option value="' + this.shipping_group_seq + '">' + this.shipping_group_name + '</option>'
						$("#ship_grp_seq").append(opt);
					});
				}
			});
		}else{
			$("input[name='provider_seq']").val('');
			$("input[name='provider_name']").val('');
		}
	})	
	.bind('focus',function(){
		if($(this).val()==$("select[name='provider_seq_selector'] option:first-child" ).text()){
			$(this).val('');
		}
	});

	// 초기화
	$('#ship_grp_seq, #provider_seq_selector').on('change', function(){
		$(".gift_area").html('');

		if( $("#ship_grp_seq").val()!="")
		{
			$(".gift_info").show();
			$(".gift_info").css("border-top", "0");
			$(".gift_order_info").show();
			$(".gift_order_info").find("input, select").attr("disabled", false);
			$("input[name='goods_rule']:checked").trigger("change");			
		}else{
			$(".gift_info").hide();
			$(".gift_order_info").hide();			
			$(".gift_order_info").find("input, select").attr("disabled", true);
		}
	});

	$('input:radio[name="gift_gb"]').on('change', function ()
	{
		$(".gift_area").html('');

		$(".gift_info").show();
		$(".gift_info").css("border-top", "1px solid #0f4897");
		
		//이벤트 증정이고 배송그룹 정보가 있고 사은품제공자가 선택되어있을때
		if($(this).val()=="order"&& $("#ship_grp_seq").val()!="")
		{			
			$(".gift_order_info").show();			
			$(".gift_order_info").find("input, select, button").attr("disabled", false);
			$("input[name='goods_rule']:checked").trigger("change");
		}else{			
			$(".gift_order_info").hide();
			$(".gift_order_info").find("input, select").attr("disabled", true);
			$('input[name=gift_rule]').val("price");
		}		

		if($(this).val()=="order" && $("#ship_grp_seq").val()=="")
		{			
			$(".gift_info").hide();			
		}		

		if($(this).val()=="buy")
		{
			$("input[name='order_gift_rule'][value='price']").trigger('change');			
			
		}else{
			$("input[name='order_gift_rule'][value='default']").trigger('change');
			$(".gift_gb_order").find("input").attr("disabled", false);
		}
		
	});

	$('input[name=order_gift_rule]').on('change', function()
	{
		$('input[name=gift_rule]').val($(this).val());
	});
	
	$(".confirmPopupInfoBtn").on('click', function(){	
		var id = $(this).parent().parent().attr("id");		
		addhiddenText(id, id+"Container")
		closeDialog(id);
	});

	$(".confirmPopupBannerBtn").on('click', function(){	
		var text = Editor.getContent();	
		$("#gift_contents").html(text);
		closeDialog('giftContents');
	});

	
	$(".btnLayClose").on('click',function(){	
		var id = $(this).parent().parent().attr("id")		
		closeDialog(id);		
	});

	$(".btnLayBannerClose").on("click",function(){
		var targetLayder = $(this).attr("target");
		closeDialog(targetLayder);
	});

	$('.popupOpenBtn').on('click', function(){	
		var name = $(this).data('name');
		var title;
		var option;

		switch (name) {
			case "giftContents" :
				title = "이벤트 배너 수정";
				option = {"width":"1000","height":"430","show" : "fade","hide" : "fade"};
				view_editor('gift_contents_tmp','');
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
		}

		openDialog(title, name,  option);			
	});	
	
<?php if($TPL_VAR["event"]["gift_seq"]){?>
		setContentsRadio("gift_gb", "<?php echo $TPL_VAR["gift_gb"]?>");
		setContentsRadio("banner_view", "<?php echo $TPL_VAR["event"]["banner_view"]?>");
		setContentsRadio("event_view", "<?php echo $TPL_VAR["event"]["event_view"]?>");		
		setContentsRadio("order_gift_rule", "<?php echo $TPL_VAR["event"]["gift_rule"]?>")	
		setContentsRadio("show_link", "<?php echo $TPL_VAR["event"]["show_link"]?>")		
		$(".confirmPopupInfoBtn").trigger('click');	
<?php if($TPL_VAR["gift_gb"]=="buy"){?> $(".gift_gb_order").find("input").attr("disabled", true)<?php }?>
<?php }else{?>
		setContentsRadio("gift_gb", "order")
		setContentsRadio("event_view", "y")
		setContentsRadio("banner_view", "n")
		setContentsRadio("order_gift_rule", "default");
		setContentsRadio("show_link", "view")
<?php }?>	
	
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
		setContentsRadio("goods_rule", "<?php if($TPL_VAR["event"]["goods_rule"]){?><?php echo $TPL_VAR["event"]["goods_rule"]?><?php }else{?>category<?php }?>");		
<?php }else{?>
		setContentsRadio("goods_rule", "<?php if($TPL_VAR["event"]["goods_rule"]){?><?php echo $TPL_VAR["event"]["goods_rule"]?><?php }else{?>all<?php }?>");
<?php }?>
	
<?php if($TPL_VAR["event"]["shipping_group_seq"]&&$TPL_VAR["event"]["provider_seq"]&&$TPL_VAR["gift_gb"]=='order'){?>
		$(".gift_order_info").show();
		$(".gift_order_info").find("input, select, button").attr("disabled", false);
		$(".gift_info").css("border-top", "0");
<?php }?>

	$(".event_view_btn").click(function(){
		window.open(sGlUrl);
	});

	$(".event_design_btn").click(function(){		
		window.open(sDesignUrl);
	});

	// 주소복사 플래시 제거
	$('#url_copy').click(function(){
		clipboard_copy(sGlUrl);
		alert("주소가 복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.");
	});	
});

</script>

<style type="text/css">
.info_item {min-height:30px;line-height:30px;padding:0 3px;border:1px solid #ddd;background-color:#fff;margin:1px;}
.info_item_holder {min-height:30px;line-height:30px;padding:0 3px;border:1px solid #ddd;background-color:#ffeecc;margin:1px;}
div .connectCategory { width:97%; float:left; cursor:hand; }
span.divcostper	{ color:red; }
.selectedseller	{width:99%;height:100px;text-align:left;overflow-x:hidden;}
</style>

<form name="eventRegist" id="eventRegist" method="post" enctype="multipart/form-data" action="../event_process/gift_regist" target="actionFrame">
<input type="hidden" name="gift_gb" value="<?php echo $TPL_VAR["gift_gb"]?>" />
<?php if($TPL_VAR["event"]["gift_seq"]){?>
<input type="hidden" name="gift_seq" value="<?php echo $TPL_VAR["event"]["gift_seq"]?>" />
<?php }?>
<?php if($TPL_VAR["operation_type"]!='light'&&$TPL_VAR["event"]["goods_info_image"]){?>
<input type="hidden" name="goods_info_image" value="<?php echo $TPL_VAR["event"]["goods_info_image"]?>" />
<?php }?>
<input type="hidden" name="gift_rule" value="<?php echo $TPL_VAR["event"]["gift_rule"]?>" />

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>사은품 이벤트 <?php if($TPL_VAR["event"]["gift_seq"]){?>수정<?php }else{?>등록<?php }?></h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><button type="button" onclick="document.location.href='./gift_catalog?<?php echo $TPL_VAR["query_string"]?>';" class="resp_btn v3 size_L">리스트 바로가기</button></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right" id="page-buttons-right">			
			<li><button type="submit" onclick="submitEditorForm(document.eventRegist);"  class="resp_btn active2 size_L">저장</button></li>
		</ul>
	</div>
</div>

<!-- 페이지 타이틀 바 : 끝 -->
<div class="contents_container">

	<div class="item-title">이벤트 정보</div>

	<table class="table_basic thl">		
		<tr>
			<th>이벤트 유형</th>
			<td <?php if($TPL_VAR["event"]["gift_seq"]){?>colspan="3"<?php }?>>	
				사은품 증정	
				<input type="radio" name="gift_gb" value="order" class="hide" checked /> 
				<input type="radio" name="gift_gb" value="buy" class="hide" />				
			</td>
		</tr>

		<tr>
			<th>이벤트명</th>
			<td <?php if($TPL_VAR["event"]["gift_seq"]){?>colspan="3"<?php }?>>
				<div class="resp_limit_text limitTextEvent">
					<input type="text" name="title" id="" size="60" maxlength="30" value="<?php echo $TPL_VAR["event"]["title"]?>" class="resp_text" />	
				</div>
			</td>
		</tr>	

		<tr>
			<th>이벤트 기간 <span class="required_chk"></span></th>
			<td <?php if($TPL_VAR["event"]["gift_seq"]){?>colspan="3"<?php }?>>
				<input type="text" name="start_date"  id="start_date" value="<?php if($TPL_VAR["event"]["start_date"]){?><?php echo $TPL_VAR["event"]["start_date"]?><?php }else{?><?php echo date('Y-m-d')?><?php }?>" class="datepicker resp_text"  maxlength="10" size="10" />
				-
				<input type="text" name="end_date" id="end_date" value="<?php if($TPL_VAR["event"]["end_date"]){?><?php echo $TPL_VAR["event"]["end_date"]?><?php }else{?><?php echo date('Y-m-d',strtotime('1 month'))?><?php }?>" class="datepicker resp_text" maxlength="10" size="10" />

				<div class="resp_btn_warp">
					<input type="button"  id="today" value="오늘" class="select_date resp_btn" /></span>
					<input type="button"  id="3day" value="3일간" class="select_date resp_btn" /></span>
					<input type="button"  id="1week" value="일주일" class="select_date resp_btn" /></span>
					<input type="button"  id="1month" value="1개월" class="select_date resp_btn" /></span>
					<input type="button"  id="3month" value="3개월" class="select_date resp_btn" /></span>
				</div>
			</td>
		</tr>		

<?php if($TPL_VAR["event"]["gift_seq"]){?>
		<tr>
			<th>상태</th>
			<td colspan="3"><?php echo $TPL_VAR["event"]["status"]?></td>
		</tr>

		<tr>
			<th>
				페이지 진입 제한
				<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/promotion_coupon', '#tip10')"></span>
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
<?php if($TPL_VAR["event"]["gift_seq"]&&$TPL_VAR["operation_type"]=='heavy'){?>
				<button type="button" class="event_view_btn resp_btn" data-tpl_path="<?php echo $TPL_VAR["event"]["tpl_path"]?>" data-code="<?php echo $TPL_VAR["event"]["gift_seq"]?>">보기</button>
<?php }else{?>					
				<a href="<?php echo get_connet_protocol()?><?php echo $_SERVER["HTTP_HOST"]?>/promotion/gift_view?gift=<?php echo $TPL_VAR["event"]["gift_seq"]?>" target="_blank" title="새창" class="event_view_btn resp_btn" data-tpl_path="<?php echo $TPL_VAR["event"]["tpl_path"]?>" data-code="<?php echo $TPL_VAR["event"]["gift_seq"]?>">보기</a>				
<?php }?>
				<button type="button" id="url_copy" class="resp_btn v2">URL 복사</button>
			</td>
		</tr>

		<tr>
			<th>등록일</th>
			<td><?php echo $TPL_VAR["event"]["regist_date"]?></td>
			<th>수정일</th>
			<td><?php echo $TPL_VAR["event"]["update_date"]?></td>
		</tr>
<?php }?>
		
	</table>


	<div class="item-title">증정 사은품</div>

	<table class="table_basic thl gift_gb_order hide">		
		<tr>
			<th>사은품 제공자 <span class="required_chk"></span></th>
			<td>				
<?php if($TPL_VAR["provider"]){?>					
					<select name="provider_seq_selector" id="provider_seq_selector">					
						<option value="0">선택</option>
<?php if($TPL_VAR["event"]["provider_seq"]=='1'&&$TPL_VAR["gift_gb"]=='order'){?>
						<option value="1" selected>본사</option>
<?php }else{?>
						<option value="1">본사</option>
<?php }?>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
<?php if($TPL_VAR["event"]["provider_seq"]==$TPL_V1["provider_seq"]){?>
						<option value="<?php echo $TPL_V1["provider_seq"]?>" selected><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }else{?>
						<option value="<?php echo $TPL_V1["provider_seq"]?>"><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }?>
<?php }}?>
					</select>					
					<input type="hidden" class="provider_seq" name="provider_seq" id="provider_seq" value="<?php echo $TPL_VAR["event"]["provider_seq"]?>" />				
<?php }else{?>
					<input type="hidden" class="provider_seq" id="provider_seq" name="provider_seq" value="<?php echo $TPL_VAR["provider_info"]["provider_seq"]?>" />
					<input type="hidden" name="provider_name" value="<?php echo $TPL_VAR["provider_info"]["provider_name"]?>" />
					<?php echo $TPL_VAR["provider_info"]["provider_name"]?>

<?php }?>
			</td>
		</tr>

		<tr>
			<th>사은품의 배송비 <span class="required_chk"></span></th>
			<td>				
				<select name="ship_grp_seq" id="ship_grp_seq">
					<option value="">배송비 선택</option>
<?php if($TPL_VAR["ship_grp_list"]){?>
<?php if($TPL_ship_grp_list_1){foreach($TPL_VAR["ship_grp_list"] as $TPL_V1){?>
<?php if($TPL_VAR["event"]["shipping_group_seq"]==$TPL_V1["shipping_group_seq"]&&$TPL_VAR["gift_gb"]=='order'){?>
						<option value="<?php echo $TPL_V1["shipping_group_seq"]?>" selected><?php echo $TPL_V1["shipping_group_name"]?></option>
<?php }else{?>
						<option value="<?php echo $TPL_V1["shipping_group_seq"]?>"><?php echo $TPL_V1["shipping_group_name"]?></option>
<?php }?>
<?php }}?>
<?php }?>
				</select> 				
			</td>
		</tr>
	</table>
	<table class="table_basic thl gift_order_info hide" style="border-top:0;">
		<tr style="border-top:0;">
			<th>상품 선정 기준</th>
			<td>
				<div class="resp_radio">
<?php if($TPL_VAR["operation_type"]=='heavy'){?>
					<label><input type="radio" name="goods_rule" value="all" <?php if($TPL_VAR["event"]["goods_rule"]=="all"){?>checked<?php }?> /> 전체</label>
<?php }?>
					<label><input type="radio" name="goods_rule" value="category" <?php if($TPL_VAR["event"]["goods_rule"]=="category"){?>checked<?php }?>/> 카테고리</label>	
					<label><input type="radio" name="goods_rule" value="goods" <?php if($TPL_VAR["event"]["goods_rule"]=="goods"){?>checked<?php }?>/> 상품</label>	
				</div>
			</td>
		</tr>

		<tr class="goods_rule_category hide">
			<th>혜택 적용 카테고리</th>
			<td>
				<input type="button" value="카테고리 선택" class="resp_btn active" onClick="gCategorySelect.open(giftObj.callbackCategoryList,{})" />
				<div class="mt10 wx600 category_list">
					<table class="table_basic fix">
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
							<tr rownum=0 <?php if(count($TPL_VAR["issuecategorys"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
								<td class="center" colspan="2">카테고리를 선택하세요</td>
							</tr>
<?php if($TPL_issuecategorys_1){foreach($TPL_VAR["issuecategorys"] as $TPL_V1){?>
							<tr rownum="<?php echo $TPL_V1["category_code"]?>">
								<td class="center"><?php echo $TPL_V1["title"]?></td>
								<td class="center">
									<input type="hidden" name='issueCategoryCode[]' value='<?php echo $TPL_V1["category_code"]?>' />
									<input type="hidden" name="issueCategoryCodeSeq[<?php echo $TPL_V1["category_code"]?>]" value="<?php echo $TPL_V1["issuecategory_seq"]?>" />
									<button type="button" class="btn_minus"  selectType="category" seq="<?php echo $TPL_V1["category_code"]?>" onClick="gCategorySelect.select_delete('minus',$(this));"></button></td>
							</tr>
<?php }}?>
						</tbody>
					</table>
				</div>
			</td>
		</tr>

		<tr class="goods_rule_goods hide">
			<th>혜택 적용 상품</th>
			<td class="t_select_goods">
				<input type="button" value="상품 선택" class="resp_btn active btn_select_goods" sellerAdminMode='1' />
				<input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" selectType="goods_list" />				
				<div class="mt10 wx600">
					<div class="goods_list_header">
						<table class="table_basic tdc">
							<colgroup>
								<col width="10%" />
								<col width="65%" />
								<col width="25%" />
							</colgroup>
							<tbody>
								<tr>
									<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" value="goods"></label></th>
									<th>상품명</th>
									<th>판매가</th>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="goods_list">
						<table class="table_basic tdc fix">
							<colgroup>
								<col width="10%" />
								<col width="65%" />
								<col width="25%" />
							</colgroup>
							<tbody>
								<tr rownum=0 <?php if(count($TPL_VAR["issuegoods"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
									<td class="center" colspan="3">상품을 선택하세요</td>
								</tr>
							<!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->								
<?php if($TPL_issuegoods_1){foreach($TPL_VAR["issuegoods"] as $TPL_V1){?>
								<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
									<td>
										<label class="resp_checkbox"><input type="checkbox" name='issueGoodsTmp[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' /></label>
										<input type="hidden" name='issueGoods[]' value='<?php echo $TPL_V1["goods_seq"]?>' />
										<input type="hidden" name="issueGoodsSeq[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["issuegoods_seq"]?>" />
									</td>
									<td class='left'>
										<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></div>
										<div class="goodsname w270">
<?php if($TPL_V1["goods_code"]){?><div>[상품코드:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
											<div><?php echo $TPL_V1["goods_kind_icon"]?> <a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V1["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 30)?></a></div>
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
	</table>

	<table class="table_basic gift_info thl hide" style="border-top:0;">
		<tr>
			<th>사은품 증정 기준</th>
			<td>
				<div class="resp_radio gift_gb_order hide mb10">
					<label><input type="radio" name="order_gift_rule" value="default" checked/> 주문 금액</label>
					<label><input type="radio" name="order_gift_rule" value="price"/> 주문 금액별 사은품 지정</label>
					<label><input type="radio" name="order_gift_rule" value="quantity"/> 주문 금액별 사은품 수량 지정</label>
				</div>
				
				<div class="resp_radio gift_gb_buy hide">
					마일리지와 교환
				</div>

				<!-- 1. 주문금액 선택 시 -->
				<table class="table_basic wx600 order_gift_rule_default hide">				
					<tr>
						<th>기준 설정</th>						
					</tr>
					<tr>						
						<td class="clear">
							<table class="table_basic thl v3 th100">									
								<tbody>
									<tr>
										<th>증정 사은품 <span class="required_chk"></span></th>								
										<td>
											<button type="button" class="default_select_gift resp_btn active mb5">사은품 선택</button>	
				
											<div class="gift_list default">
												<table class="table_basic tdc">
													<colgroup>
														<col width="80%" />
														<col width="20%" />
													</colgroup>
													<thead>
														<tr>
															<th>사은품명</th>
															<th>삭제</th>
														</tr>
													</thead>
													<tbody>
														<tr rownum=0 <?php if(count($TPL_VAR["defaultGifts"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
															<td class="center" colspan="2">사은품을 선택하세요</td>
														</tr>
<?php if($TPL_defaultGifts_1){foreach($TPL_VAR["defaultGifts"] as $TPL_V1){?>
														<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
															<td class="left">
																<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" class="goodsThumbView" width="50" height="50" /></div>
																<div class="goodsname w200">
<?php if($TPL_V1["goods_code"]){?><div class="desc">[상품코드:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
																	<a href="../goods/gift_regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut($TPL_V1["goods_name"], 30)?></a>
																</div>
															</td>
															<td><input type="hidden" name='defaultGift[]' value='<?php echo $TPL_V1["goods_seq"]?>' />
																<button type="button" class="btn_minus" selectType="gift_list.default" onclick="selectItemDelete(this)" seq="<?php echo $TPL_V1["goods_seq"]?>"></button></td>
														</tr>
<?php }}?>
													</tbody>
												</table>
											</div>
										</td>
									</tr>
									<tr>
										<th>주문 금액 기준 <span class="required_chk"></span></th>								
										<td><input type="text" name="sprice1[]" value="<?php echo get_currency_price($TPL_VAR["default"]["sprice"], 1)?>" size="5" class="right <?php echo $TPL_VAR["only_numberic_type"]?>"/> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상</td>
									</tr>
								</tbody>
							</table>
						</td>					
					</tr>
				</table>

				<!-- 2. 주문 금액별 사은품 지정 선택 시 -->
				<table class="table_basic thl wx600 order_gift_rule_price hide" id="priceTable">
					<colgroup>	
						<col width="10%" />
						<col width="25%" />
						<col width="65%" />						
					</colgroup>

					<tr>
						<th class="center"><button type="button" id="priceAdd" class="btn_plus"></button></th>
						<th class="center" colspan="2">기준 설정</th>						
					</tr>
					<tbody>
<?php if($TPL_VAR["priceLoop"]){?>
<?php if($TPL_priceLoop_1){foreach($TPL_VAR["priceLoop"] as $TPL_V1){?>
					<tr class="pricetr">
						<th rowspan="2" class="center"><button type="button" onClick="trDel(this)" class="btn_minus priceDel"></button></th>
						<th>증정 사은품 <span class="required_chk"></span></th>								
						<td>
							<button type="button" class="price_select_gift resp_btn active mb5" onClick="giftGoodsSelect(this)" num=<?php echo $TPL_V1["num"]?> >사은품 선택</button>
						
							<div class="gift_list price<?php echo $TPL_V1["num"]?>">
								<table class="table_basic tdc w300">
									<colgroup>
										<col width="80%" />
										<col width="20%" />
									</colgroup>
									<thead>
										<tr>
											<th>사은품명</th>
											<th>삭제</th>	
										</tr>
									</thead>
									<tbody>
										<tr rownum=0 <?php if(count($TPL_V1["gifts"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
											<td class="center" colspan="2">사은품을 선택하세요</td>
										</tr>
<?php if(is_array($TPL_R2=$TPL_V1["gifts"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
										<tr rownum="<?php echo $TPL_V2["goods_seq"]?>">
											<td class="left">
												<div class="image"><img src="<?php echo viewImg($TPL_V2["goods_seq"],'thumbView')?>" width="50"></div>
												<div class="goodsname w190">
<?php if($TPL_V2["goods_code"]){?><div class="desc">[상품코드:<?php echo $TPL_V2["goods_code"]?>]</div><?php }?>
													<a href="../goods/gift_regist?no=<?php echo $TPL_V2["goods_seq"]?>" target="_blank"><?php echo getstrcut($TPL_V2["goods_name"], 30)?></a>
												</div>
											</td>
											<td><input type="hidden" name='price<?php echo $TPL_V1["num"]?>Gift[]' value='<?php echo $TPL_V2["goods_seq"]?>' />
												<button type="button" class="btn_minus" selectType="gift_list.price<?php echo $TPL_V1["num"]?>" onclick="selectItemDelete(this)" seq="<?php echo $TPL_V2["goods_seq"]?>"></button></td>
										</tr>
<?php }}?>
									</tbody>
								</table>
							</div>
							<div id="priceGiftSelect<?php echo $TPL_V1["num"]?>" class="hide"></div>									
						</td>						
					</tr>
					<tr class="pricetr">
						<th>
							<span class="gift_gb_order hide">주문 금액 기준</span> 
							<span class="gift_gb_buy hide">교환 마일리지</span> 
							<span class="required_chk"></span>
						</th>								
						<td>
							<div id="pTr1_<?php echo $TPL_V1["num"]?>">							
								<input type="text" name="sprice2[]" value="<?php echo get_currency_price($TPL_V1["sprice"], 1)?>" size="5" class="right <?php echo $TPL_VAR["only_numberic_type"]?>" /> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

								<span class="gift_gb_order hide">
									~ 
									<input type="text" name="eprice2[]" value="<?php echo get_currency_price($TPL_V1["eprice"], 1)?>" size="5" class="right <?php echo $TPL_VAR["only_numberic_type"]?>" /> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

									일 때 증정	
								</span>								
							</div>
						</td>
					</tr>
<?php }}?>
<?php }else{?>
					<tr class="pricetr">
						<th rowspan="2" class="center"><button type="button" onClick="trDel(this)" class="btn_minus priceDel"></button></th>
						<th>증정 사은품 <span class="required_chk"></span></th>								
						<td>
							<button type="button" class="price_select_gift resp_btn active mb5" onClick="giftGoodsSelect(this)" num=1 >사은품 선택</button>
						
							<div class="gift_list price1">
								<table class="table_basic tdc">
									<colgroup>
										<col width="80%" />
										<col width="20%" />
									</colgroup>
									<thead>
										<tr>
											<th>사은품명</th>
											<th>삭제</th>	
										</tr>
									</thead>
									<tbody>
										<tr rownum=0 class="show">
											<td class="center" colspan="2">사은품을 선택하세요</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div id="priceGiftSelect1" class="hide"></div>
						</td>						
					</tr>
					<tr class="pricetr">
						<th>
							<span class="gift_gb_order hide">주문 금액 기준</span> 
							<span class="gift_gb_buy hide">교환 마일리지</span> 
							<span class="required_chk"></span>
						</th>								
						<td>					
							<input type="text" name="sprice2[]" value="" size="5" class="right <?php echo $TPL_VAR["only_numberic_type"]?>" /> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

							<span class="gift_gb_order hide">
								~ 
								<input type="text" name="eprice2[]" value="" size="5" class="right <?php echo $TPL_VAR["only_numberic_type"]?>" /> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

								일 때 증정	
							</span>
						</td>
					</tr>									
<?php }?>
					</tbody>
				</table>

				<!-- 3. 주문 금액별 사은품 수량 지정 선택 시 -->
				<div class="order_gift_rule_quantity hide">
					<table class="table_basic thl wx600">	
						<colgroup>	
							<col width="25%" />
							<col width="75%" />
						</colgroup>
						<tbody>
							<tr>
								<th>증정 사은품 <span class="required_chk"></span></th>								
								<td>
									<button type="button" class="qty_select_gift resp_btn active mb5">사은품 선택</button>	
		
									<div class="gift_list qty">
									<table class="table_basic tdc">
										<colgroup>
											<col width="80%" />
											<col width="20%" />
										</colgroup>
										<thead>
											<tr>
												<th>사은품명</th>
												<th>삭제</th>	
											</tr>
										</thead>
										<tbody>
											<tr rownum=0 <?php if(count($TPL_VAR["qtyGifts"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
												<td class="center" colspan="2">사은품을 선택하세요</td>
											</tr>
<?php if($TPL_qtyGifts_1){foreach($TPL_VAR["qtyGifts"] as $TPL_V1){?>
											<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
												<td class="left">
												<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></div>
													<div class="goodsname w200">
<?php if($TPL_V1["goods_code"]){?><div class="desc">[상품코드:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
														<a href="../goods/gift_regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut($TPL_V1["goods_name"], 30)?></a>
													</div>
												</td>
												<td><input type='hidden' name='qtyGift[]' value='<?php echo $TPL_V1["goods_seq"]?>' />
													<button type="button" class="btn_minus" selectType="gift_list.qty" onclick="selectItemDelete(this)" seq="<?php echo $TPL_V1["goods_seq"]?>"></button></td>
											</tr>
<?php }}?>
										</tbody>
									</table>
									</div>
								</td>
							</tr>
						</tbody>
					</table>

					<table id="qtyTable" class="table_basic thl wx600 mt5">
						<colgroup>	
							<col width="10%" />
							<col width="25%" />
							<col width="65%" />							
						</colgroup>					
						<tr>
							<th class="center"><button type="button" id="qtyAdd" class="btn_plus"></button></th>
							<th colspan="2">기준 설정</th>							
						</tr>
						
<?php if($TPL_VAR["qtyLoop"]){?>
<?php if($TPL_qtyLoop_1){foreach($TPL_VAR["qtyLoop"] as $TPL_V1){?>
						<tr class="pricetr">
							<th rowspan="2" class="center"><button type="button" onClick="trDel(this)" class="btn_minus qtyDel"></th>
							<th>주문 금액 기준 <span class="required_chk"></span></th>								
							<td>
								<input type="text" name="sprice3[]" value="<?php echo get_currency_price($TPL_V1["sprice"], 1)?>" size="5" class="right <?php echo $TPL_VAR["only_numberic_type"]?>" /> <?php echo $TPL_VAR["config_system"]['basic_currency']?>

								~ 
								<input type="text" name="eprice3[]" value="<?php echo get_currency_price($TPL_V1["eprice"], 1)?>" size="5" class="right <?php echo $TPL_VAR["only_numberic_type"]?>" /> <?php echo $TPL_VAR["config_system"]['basic_currency']?>

								일 때 증정
							</td>							
						</tr>	
						
						<tr class="pricetr">
							<th>증정 사은품 수량 <span class="required_chk"></span></th>								
							<td><input type="text" name="ea3[]" value="<?php echo $TPL_V1["ea"]?>" size="3"/> 개</td>							
						</tr>							
<?php }}?>
<?php }else{?>
						<tr class="pricetr">
							<th rowspan="2" class="center"><button type="button" onClick="trDel(this)" class="btn_minus qtyDel"></th>
							<th>주문 금액 기준 <span class="required_chk"></span></th>								
							<td>
								<input type="text" name="sprice3[]" value="" size="5" class="right <?php echo $TPL_VAR["only_numberic_type"]?>" /> <?php echo $TPL_VAR["config_system"]['basic_currency']?>

								~ 
								<input type="text" name="eprice3[]" value="" size="5" class="right <?php echo $TPL_VAR["only_numberic_type"]?>" /> <?php echo $TPL_VAR["config_system"]['basic_currency']?>

								일 때 증정
							</td>							
						</tr>	
						
						<tr class="pricetr">
							<th>증정 사은품 수량 <span class="required_chk"></span></th>								
							<td><input type="text" name="ea3[]" value="" size="3"/> 개</td>
						</tr>
<?php }?>
				
					</table>
				</div>
			</td>
		</tr>
	</table>

	<div class="item-title">이벤트 상세 페이지</div>

	<table class="table_basic thl">	
<?php if($TPL_VAR["operation_type"]=='light'){?>
		<tr>
			<th>이벤트 배너</th>
			<td id="giftContentsContainer">			
				<textarea name="gift_contents" id="gift_contents" class="hide" style="width:98%;height:200px;"><?php echo $TPL_VAR["event"]["gift_contents"]?></textarea>
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

				<a href="javascript:;" class="qrcodeGuideBtn fx11 lsp-1" key="event" value="<?php echo $TPL_VAR["event"]["event_seq"]?>">자세히▶</a>
			</td>
		</tr>
<?php }?>
	</table>

	<div class="item-title">
		전체 이벤트 페이지
		<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/promotion_coupon', '#tip11')"></span>
	</div>

	<table class="table_basic thl">		
		<tr>
			<th>이벤트 노출 여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="event_view" value="n" <?php if($TPL_VAR["event"]["event_view"]=='n'){?> checked <?php }?> > 노출</label>
					<label><input type="radio" name="event_view" value="y" <?php if($TPL_VAR["event"]["event_view"]=='y'||$TPL_VAR["event"]["event_view"]==''){?> checked <?php }?> > 미노출</label>
				</div>
			</td>
		</tr>	
		
		<tr class="event_view_n hide">
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

		<tr class="event_view_n hide">
			<th>타이틀</th>
<?php if($TPL_VAR["operation_type"]=='light'){?>
			<td>
				<input type="text" name="event_introduce" class="line" size="50" value="<?php echo $TPL_VAR["event"]["event_introduce"]?>" />
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

		<tr class="event_view_n hide">
			<th>썸네일 링크 연결</th>
			<td>
				<input type="hidden" name="show_link" value="view"> 
				이벤트 페이지		
			</td>
		</tr>	
	</table>

	<div class="item-title">상품 상세 페이지</div>

	<table class="table_basic thl">		
		<tr>
			<th>이벤트 노출 여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="banner_view" value="y" <?php if($TPL_VAR["event"]["banner_view"]=='y'){?> checked <?php }?> /> 노출</label>
					<label><input type="radio" name="banner_view" value="n" <?php if($TPL_VAR["event"]["banner_view"]=='n'||$TPL_VAR["event"]["banner_view"]==''){?> checked <?php }?> /> 미노출</label>
				</div>				
			</td>
		</tr>		
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

		<tr class="banner_view_y hide">
			<th>이벤트 소개</th>
			<td><textarea class="wp95" name="goods_desc_popup"><?php echo $TPL_VAR["event"]["goods_desc_popup"]?></textarea></td>
		</tr>	
	</table>
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
	<div class="item-title">이벤트 공유</div>
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

	<div class="footer">		
		<button type="button" class="btnLayClose resp_btn v3 size_XL">닫기</button>
	</div>	
</div>

<div id="giftContents">	
	<textarea name="gift_contents_tmp" id="gift_contents_tmp" style="width:98%;height:200px;" contentHeight="200px"><?php echo $TPL_VAR["event"]["gift_contents"]?></textarea>
	<div class="center mt10">
		<button type="button" class="confirmPopupBannerBtn resp_btn active size_XL">확인</button>
		<button type="button" class="btnLayBannerClose resp_btn v3 size_XL" target="giftContents">취소</button>
	</div>
</div>


<div id="lay_goods_select"></div><!-- 상품선택 레이어 -->
<div id="lay_category_select"></div><!-- 카테고리 선택 레이어 -->
<div id="lay_gift_select"></div><!-- 선택 레이어 -->

</form>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>