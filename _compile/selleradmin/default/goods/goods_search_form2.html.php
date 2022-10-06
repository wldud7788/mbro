<?php /* Template_ 2.2.6 2022/05/17 12:29:10 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/goods_search_form2.html 000025601 */ 
$TPL_gift_list_1=empty($TPL_VAR["gift_list"])||!is_array($TPL_VAR["gift_list"])?0:count($TPL_VAR["gift_list"]);?>
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/goods_admin.css" />
<script type="text/javascript">
$(document).ready(function() {
	$("[name='select_date']").click(function() {
		switch($(this).attr("id")) {
			case 'today' :
				$("input[name='sdate']").val(getDate(0));
				$("input[name='edate']").val(getDate(0));
				break;
			case '3day' :
				$("input[name='sdate']").val(getDate(3));
				$("input[name='edate']").val(getDate(0));
				break;
			case '1week' :
				$("input[name='sdate']").val(getDate(7));
				$("input[name='edate']").val(getDate(0));
				break;
			case '1month' :
				$("input[name='sdate']").val(getDate(30));
				$("input[name='edate']").val(getDate(0));
				break;
			case '3month' :
				$("input[name='sdate']").val(getDate(90));
				$("input[name='edate']").val(getDate(0));
				break;
			default :
				$("input[name='sdate']").val('');
				$("input[name='edate']").val('');
				break;
		}
	});

	$("#get_default_button").click(function(){
		$.getJSON('get_search_default?search_page=<?php echo $TPL_VAR["search_page"]?>', function(result) {
			$("div.search-form-container input[type='checkbox']").removeAttr("checked");
			$("div.search-form-container input[type='text']").val('');
			$("div.search-form-container select").val('').change();

			for(var i=0;i<result.length;i++){
				//alert(result[i][0]+" : "+result[i][1]);
				if( strstr(result[i][0],'goodsStatus') ) {
					$("input[name='goodsStatus[]'][value='"+result[i][1]+"']").attr("checked",true);
				}else if( strstr(result[i][0],'goodsView') ) {
					$("input[name='goodsView[]'][value='"+result[i][1]+"']").attr("checked",true);
				}else if( strstr(result[i][0],'taxView') ){
					$("input[name='taxView[]'][value='"+result[i][1]+"']").attr("checked",true);
				}else if(result[i][0]=='regist_date') {
					if(result[i][1] == 'today'){
						set_date('<?php echo date('Y-m-d')?>','<?php echo date('Y-m-d')?>');
					}else if(result[i][1] == '3day'){
						set_date('<?php echo date('Y-m-d',strtotime("-3 day"))?>','<?php echo date('Y-m-d')?>');
					}else if(result[i][1] == '7day'){
						set_date('<?php echo date('Y-m-d',strtotime("-7 day"))?>','<?php echo date('Y-m-d')?>');
					}else if(result[i][1] == '1mon'){
						set_date('<?php echo date('Y-m-d',strtotime("-1 month"))?>','<?php echo date('Y-m-d')?>');
					}else if(result[i][1] == '3mon'){
						set_date('<?php echo date('Y-m-d',strtotime("-3 month"))?>','<?php echo date('Y-m-d')?>');
					}else if(result[i][1] == 'all'){
						set_date('','');
					}
				}else if( strstr(result[i][0],'openmarket') ) {
					$("input[name='openmarket[]'][value='"+result[i][1]+"']").attr("checked",true);
				} else {
					$("select[name='"+result[i][0]+"']").val(result[i][1]);
					$("input[name='"+result[i][0]+"'][value='"+result[i][1]+"']").attr("checked",true);
					$("[name='"+result[i][0]+"']").val(result[i][1]);
				}
				//$("*[name='"+result[i][0]+"']",document.goodsForm).val(result[i][1]);
			}
		});
	});

	$(".star_select").click(function(){
		var status = "";
		if($(this).hasClass("checked")){
			$(this).removeClass("checked");
			status = "none";
		}else{
			$(this).addClass("checked");
			status = "checked";
		}

		$.ajax({
			type: "get",
			url: "../goods/set_favorite",
			data: "status="+status+"&goods_seq="+$(this).attr("goods_seq"),
			success: function(result){
				//alert(result);
			}
		});
	});

	//가격대체문구 사용 체크
	$("input[name='string_price_use[1]']").click(function(){
		if($(this).is(":checked")){
			$(".string_price_checkbox").each(function(idx) {
				$(".string_price_checkbox").eq(idx).attr("disabled", false);
			});
		}else{
			$(".string_price_checkbox").each(function(idx) {
				$(".string_price_checkbox").eq(idx).attr("checked", false);
				$(".string_price_checkbox").eq(idx).attr("disabled", true);
			});
		}
	});


	// 매입처/입점사 검색선택
	$("input[name='provider_base']").bind('change',function(){
		if($(this).is(":checked")){
			$("select[name='provider_seq']").attr('disabled',true);
		}else{
			$("select[name='provider_seq']").removeAttr('disabled');
		}
	}).change();

	$("#btn-reset").on("click", function(event){
		event.preventDefault();
		var obj = $(this).closest('form .search-form-container');

		obj.find('select, textarea, input[type=text]').val('');
		obj.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');

		// 아이콘 검색
		obj.find(".msg_select_icon").text('');

		var chk_except = false;
		obj.find('input:text, input:hidden').each(function() {
			chk_except = false;
			if (this.name == 'malllist[]') chk_except = true;
			if (this.name == 'show_search_form') chk_except = true;

			if (this.name != '') {
				if (!chk_except) $(this).val('');
			} else {
				// - 입점사 검색 - 셀렉트박스 제외
				$(this).val('');
			}
		});
		$('.search_type_text').hide();

		$('select[name="shipping_group_seq"]').trigger('change');
		$('input[name="color_pick[]"]').attr('checked', false);
		$('#goodsForm input[name="color_pick[]"]').parent().removeClass('active');

	});

<?php if($TPL_VAR["sc"]["goods_addinfo"]){?>
		$("select[name='goods_addinfo']").val('<?php echo $TPL_VAR["sc"]["goods_addinfo"]?>');
<?php if($TPL_VAR["sc"]["goods_addinfo"]!='direct'){?>
			$('#<?php echo $TPL_VAR["sc"]["goods_addinfo"]?>_sel > select > option[value="<?php echo $TPL_VAR["sc"]["goods_addinfo_title"]?>"]').attr('selected', true);
<?php }?>
<?php }?>

<?php if($TPL_VAR["sc"]["goodsaddinfo"]){?>
		$('#<?php echo $TPL_VAR["sc"]["goods_addinfo"]?>_sel > select > option').attr('selected', false);
		$('#<?php echo $TPL_VAR["sc"]["goods_addinfo"]?>_sel > select > option[value="<?php echo $TPL_VAR["sc"]["goods_addinfo_title"]?>"]').attr('selected', true);
<?php }?>

	$(".msg_select_icon").text("");

	// 검색어 레이어 박스 : start
	$("#search_keyword").keyup(function () {
		if ($(this).val()) {
			$('.txt_keyword').text($(this).val());
			searchLayerOpen();
		}else{
			$('.searchLayer').hide();
		}
	});

	$("#search_keyword").focus(function () {
		if ($(this).val() && $(this).val()!=$(this).attr('title')) {
			$('.txt_keyword').text($(this).val());
			searchLayerOpen();
		}
	});

	$("a.link_keyword").click(function () {
		var sType = $(this).attr('s_type');
		$('#search_type').val(sType);
		$('.searchLayer').hide();
<?php if(preg_match('/goods\/batch_modify/',$_SERVER["REQUEST_URI"])){?>
			$("form[name='search_goods_form']").submit();
<?php }else{?>
			$("form[name='goodsForm']").submit();
<?php }?>
	});

	$("#search_keyword").blur(function(){
		if("<?php echo $_GET["keyword"]?>" == $("#search_keyword").val()){
			$(".search_type_text").show();
		}
		setTimeout(function(){
			$('.searchLayer').hide()}, 500
		);
	});

	var offset = $("#search_keyword").offset();
	$('.search_type_text').css({
		'position' : 'absolute',
		'z-index' : 1,
		'left' : 0,
		'top' : 0,
		'width':$("#search_keyword").width()-1,
		'height':$("#search_keyword").height()-5
	});

<?php if($_GET["search_type"]){?>
		$('.search_type_text').show();
<?php }?>

	$(".search_type_text").click(function () {
		$(".search_type_text").hide();
		$("#search_keyword").focus();
	});

	$(".searchLayer ul li").hover(function() {
		$(".searchLayer ul li").removeClass('hoverli');
		$(this).addClass('hoverli');
	});

	$("#search_keyword").keydown(function (e) {
		var searchbox = $(this);

		switch (e.keyCode) {
			case 40:
				if($('.searchUl').find('li.hoverli').length == 0){
					$('.searchUl').find('li:first-child').addClass('hoverli');
				}else{
					if($('.searchUl').find('li:last-child').hasClass("hoverli") ){
						$('.searchUl').find('li::last-child.hoverli').removeClass('hoverli');
						$('.searchUl').find('li:first-child').addClass('hoverli');
					}else{
						$('.searchUl').find('li:not(:last-child).hoverli').removeClass('hoverli').next().addClass('hoverli');
					}
				}
				break;
			case 38:
				if($('.searchUl').find('li.hoverli').length == 0){
					$('.searchUl').find('li:last-child').addClass('hoverli');
				}else{
					if($('.searchUl').find('li:first-child').hasClass("hoverli")){
						$('.searchUl').find('li::first-child.hoverli').removeClass('hoverli');
						$('.searchUl').find('li:last-child').addClass('hoverli');
					}else{
						 $('.searchUl').find('li:not(:first-child).hoverli').removeClass('hoverli').prev().addClass('hoverli');
					}
				}
				break;
			case 13 :
				var index=0;
				 $('.searchUl').find('li').each(function(){
					if($(this).hasClass("hoverli")){
						index=$(this).index();
					}
				});

				$('.searchUl').find('li>a').eq(index).click();
				e.keyCode = null;
				//return false;
				break;
		}
	});
	// 검색어 레이어 박스 : end

	$("#btn_search_detail").click(function () {
		if ($(this).attr('class')=='close') {
			setSearchDetail('close');
		} else if ($(this).attr('class')=='open') {
			setSearchDetail('open');
		}
	});

<?php if($_GET["show_search_form"]){?>
		setSearchDetail('<?php echo $_GET["show_search_form"]?>');
<?php }elseif($TPL_VAR["gdsearchdefault"]["search_form_view"]){?>
		setSearchDetail('<?php echo $TPL_VAR["gdsearchdefault"]["search_form_view"]?>');
<?php }else{?>
		setSearchDetail('open');
<?php }?>

	$("select[name='goods_addinfo']").change(function(){goods_addinfo_ctrl();});

	$("select[name='commission_type_sel']").change(function(){
		if(this.value == 'SUPR')	$('.commission_unit').hide();
		else						$('.commission_unit').show();
	});

	$('select[name="shipping_group_seq"]').change(function(){
		
		$('#domesticShippingList').hide();
		$('#internationalShippingList').hide();
		$('#domesticShippingInfo').hide();
		$('#internationalShippingInfo').hide();


		if (this.value == ''){
			$('#domesticShippingList').show();
			$('#internationalShippingList').show();
		} else {
			var $selectedGroupSeq	= $('select[name="shipping_group_seq"] > option:selected');
			$('#domesticShippingInfo').html($selectedGroupSeq.attr('koreaMethodDesc'));
			$('#internationalShippingInfo').html($selectedGroupSeq.attr('globalMethodDesc'));
			$('#domesticShippingInfo').show();
			$('#internationalShippingInfo').show();

		}
		

	});
	

	$('select[name="shipping_group_seq"]').trigger('change');

	
	$("#search_set").click(function(){
		category_admin_select_load('','s_category1','',function(){
<?php if($TPL_VAR["gdsearchdefault"]["category1"]){?>
			$("select[name='s_category1']").val('<?php echo $TPL_VAR["gdsearchdefault"]["category1"]?>').change();
<?php }elseif($TPL_VAR["sc"]["category1"]){?>
			$("select[name='s_category1']").val('<?php echo $_GET["category1"]?>').change();
<?php }?>
		});

		brand_admin_select_load('','s_brands1','',function(){
<?php if($TPL_VAR["gdsearchdefault"]["brands1"]){?>
			$("select[name='s_brands1']").val('<?php echo $TPL_VAR["gdsearchdefault"]["brands1"]?>').change();
<?php }elseif($TPL_VAR["sc"]["brands1"]){?>
			$("select[name='s_brands1']").val('<?php echo $_GET["brands1"]?>').change();
<?php }?>
		});

		location_admin_select_load('','s_location1','',function(){
<?php if($TPL_VAR["gdsearchdefault"]["location1"]){?>
			$("select[name='s_location1']").val('<?php echo $TPL_VAR["gdsearchdefault"]["location1"]?>').change();
<?php }elseif($TPL_VAR["sc"]["location1"]){?>
			$("select[name='s_location1']").val('<?php echo $_GET["location1"]?>').change();
<?php }?>
		});

		var title = '기본검색 설정<span class="desc"> - 아래서 원하는 검색조건을 설정하여 편하게 쇼핑몰을 운영하세요</span>';
		openDialog(title, "search_detail_dialog", {"width":"1220","height":"280"});
	});
	
});

function goods_addinfo_ctrl(){
	var nowSelected	= $("select[name='goods_addinfo'] > option:selected");
	var addtype		= $(nowSelected).attr('addtype');

	$('.goodsaddinfo_select').hide();
	$('.goodsaddinfo_direct').hide();
	$('.goodsaddinfo_select > select').attr('disabled', true);
	$('.goodsaddinfo_direct > input').attr('disabled', true);

	if(addtype == 'select'){
		$('#' + nowSelected.val() + '_sel').show();
		$('#' + nowSelected.val() + '_sel > select').attr('disabled', false);
		$('#' + nowSelected.val() + '_sel > select').width(97);
	}else if(addtype == 'direct'){
		$('.goodsaddinfo_direct > input').attr('disabled', false);
		$('.goodsaddinfo_direct').show();
	}
}

function setSearchDetail(type) {
	if (type=='close') {
		$("#show_search_form").val('close');
		$("#btn_search_detail").removeClass("close").addClass("open");
		$(".search_detail_form").hide();
	} else if (type=='open') {
		$("#show_search_form").val('open');
		$("#btn_search_detail").removeClass("open").addClass("close");
		$(".search_detail_form").show();
	}
}

function searchLayerOpen(){
	var offset = $("#search_keyword").offset();
	if( offset) {
		$('.searchLayer').css({
			'position' : 'absolute',
			'z-index' : 999,
			'left' : -1,
			'top' : '100%',
			'width':$("#search_keyword").width()
		}).show();
	}
}

function set_date(start,end){
	$("input[name='sdate']").val(start);
	$("input[name='edate']").val(end);
}
</script>

<style type="text/css">
/* 검색폼 양식 개선 */
div.search-form-container {background:#f9fbfc; padding:15px 0 10px 0;border-bottom:1px solid #d6d6d6;margin-bottom:5px;}
div.search-form-container table.search-form-table	{margin:auto;}
div.search-form-container table.sf-option-table {width:1172px;border-collapse:collapse;}
div.search-form-container table.sf-option-table th	{height:28px; text-align:left; vertical-align: middle; padding-right:0px; font-weight:bold; font-size: 12px; color:#66666a;}
div.search-form-container table.sf-keyword-table {width:100%; border:1px solid #3385d4; border-collapse:collapse; background-color:#fff; table-layout:fixed;}
div.search-form-container table.sf-keyword-table .sfk-td-txt {padding-right:0px;}
div.search-form-container table.sf-keyword-table .sfk-td-txt input {width:100%; height:30px; padding:0px; border:0px; margin:0px; background-color:#fff; line-height:30px; text-align:center; color: #797d86;}
div.search-form-container table.sf-keyword-table .sfk-td-btn {width:45px; text-align:center;}
div.search-form-container table.sf-keyword-table .sfk-td-btn button {width:45px; height:30px; border:0px; background:url('/admin/skin/default/images/common/icon/admin_search_bt.gif') no-repeat center center; cursor:pointer;}
div.search-form-container table.sf-keyword-table .sfk-td-btn button:hover {background:url('/admin/skin/default/images/common/icon/admin_search_bt2.gif');}
div.search-form-container table.sf-keyword-table .sfk-td-btn button span {display:none}

input.social_goods_group_name {width:81px;}
span.pd_td_right, span.pd_day {padding-left:5px;}

/* 티켓그룹 버튼 */
button.coupon_group_search {border: none;width:41px;height:23px;background:url('/admin/skin/default/images/common/icon/admin_sbt04.png') no-repeat; cursor:pointer;}
button.coupon_group_search_all {border: none;width:41px;height:23px;background:url('/admin/skin/default/images/common/icon/admin_allbt05.png') no-repeat; cursor:pointer;}

/* 아이콘 검색 버튼 */
button.btn_search_icon, button.s_btn_search_icon {border: none;width:33px;height:20px;background:url('/admin/skin/default/images/common/icon/admin_sbt06.png') no-repeat; cursor:pointer;}

/* 기본검색적용 버튼 */
button#search_set {border: none;width:84px;height:23px;background:url('/admin/skin/default/images/common/icon/admin_nbt01_2.png') no-repeat; cursor:pointer;}
button#get_default_button {border: none;width:84px;height:23px;background:url('/admin/skin/default/images/common/icon/admin_nbt01.png') no-repeat; cursor:pointer;}
button#btn_search_detail.open {border: none;width:84px;height:23px;background:url('/admin/skin/default/images/common/icon/admin_nbt03_1.png') no-repeat; cursor:pointer;}
button#btn_search_detail.close {border: none;width:84px;height:23px;background:url('/admin/skin/default/images/common/icon/admin_nbt03_2.png') no-repeat; cursor:pointer;}
button#btn-reset { width: 84px; height: 23px; background: url(/admin/skin/default/images/common/icon/admin_nbt02_1.png) no-repeat; }

/* 기본검색설정 글자 */
#search_set {color:#636363;font-size:12px;text-decoration: underline;}

div.ui-widget{padding-bottom:5px;}

/* 셀렉트박스 다운 아이콘 */
.search-form-container select {color:#797d86;font-size:11px;appearance:none;-webkit-appearance: none;-moz-appearance: none;height:22px !important;padding: 3px 0px 0px 3px;background: #ffffff url('/admin/skin/default/images/common/icon/admin_select_n.gif') no-repeat right 8px center;}
.search-form-container select::-ms-expand {display: none;}
.search-form-container label {color: #797d86;font-size: 12px;}
.search-form-container .ft_11 {font-size: 11px;}
.search-form-container .line {border:1px solid #a7a8aa !important; cursor:default}
.search-form-container .line:focus {margin:0px; border:2px solid #3ea4f6 !important; cursor:text}
.search-form-container input {color:#797d86;}
.search-form-table.search-form-keyword-table { padding:0; }
div.search-form-container table.search-form-table { margin-top:10px; }

.ui-combobox {position: relative; display: inline-block;}
.ui-combobox-toggle {position: absolute; top: 0; bottom: 0; margin-left: -1px; padding: 0; *height: 1.7em; *top: 0.1em;}
.ui-combobox-input {margin: 0; padding: 0.3em;}
.ui-autocomplete {max-height: 200px; overflow-y: auto; overflow-x: hidden;}
</style>
<div class="search-form-container">
	<table class="search-form-table search-form-keyword-table">
		<tr>
			<td width="415">
				<table class="sf-keyword-table">
					<tr>
						<td class="sfk-td-txt">
							<div class="relative">
								<input type="text" name="keyword" id="search_keyword" value="<?php echo $_GET["keyword"]?>" title="사은품명, 상품번호, 바코드, HSCODE" />
								<!-- 검색어 입력시 레이어 박스 : start -->
								<div class="search_type_text hide"><?php echo $_GET["search_type_text"]?></div>
								<div class="searchLayer hide">
									<input type="hidden" name="search_type" id="search_type" value="" />
									<ul class="searchUl">
										<li><a class="link_keyword" s_type="all" href="#"><span class="txt_keyword"></span> <span class="txt_title">-전체검색</span></a></li>
										<li><a class="link_keyword" s_type="goods_name" href="#">사은품명: <span class="txt_keyword"></span> <span class="txt_title">-사은품명 찾기</span></a></li>
										<li><a class="link_keyword" s_type="goods_seq" href="#">상품번호: <span class="txt_keyword"></span> <span class="txt_title">-상품번호 찾기</span></a></li>
										<li><a class="link_keyword" s_type="goods_code" href="#">바코드: <span class="txt_keyword"></span> <span class="txt_title">-바코드 찾기</span></a></li>
										<li><a class="link_keyword" s_type="hscode" href="#">HSCODE: <span class="txt_keyword"></span> <span class="txt_title">-HSCODE 찾기</span></a></li>
									</ul>
								</div>
								<!-- 검색어 입력시 레이어 박스 : end -->
							</div>
						</td>
						<td class="sfk-td-btn"><button type="submit"><span>검색</span></button></td>
					</tr>
				</table>
			</td>
			<td width="10">&nbsp;</td>
			<td>
				<button type="button" id="search_set" value="기본검색설정" name="search_set"></button>
				<button type="button" id="get_default_button" value="기본검색적용" name="get_default_button"></button>
				<button type="reset" id="btn-reset" value="초기화" name="btn_reset"></button>
				<input type="hidden" name="show_search_form" id="show_search_form" value="" />
				<button type="button" id="btn_search_detail" class="close" value="상세검색닫기" name="btn_search_detail"></button>
			</td>
		</tr>
	</table>
	<table class="search-form-table search_detail_form <?php if($_GET["show_search_form"]=='close'){?>hide<?php }elseif($TPL_VAR["gdsearchdefault"]["search_form_view"]=='close'){?>hide<?php }?>" id="serch_tab">
		<tr id="goods_search_form" style="display:none;"><td></td></tr>
		<tr>
			<td>
				<table class="sf-option-table" border='0'>
					<colgroup>
						<col width="65" />
						<col width="*" />
						<col width="65" />
						<col width="110" />
						<col width="65" />
						<col width="240" />
						<col width="65" />
						<col width="260" />
					</colgroup>
					<tr>
						<th>입점사</th>
						<td colspan="8"><?php echo $TPL_VAR["provider_name"]?></td>
					</tr>
					<tr>
						<th>날짜</th>
						<td colspan="5">
							<select class="line" name="date_gb" style="width:98px;">
								<option value="regist_date" <?php if($TPL_VAR["sc"]["date_gb"]=='regist_date'){?>selected<?php }?>>등록일</option>
								<option value="update_date" <?php if($TPL_VAR["sc"]["date_gb"]=='update_date'){?>selected<?php }?>>수정일</option>
							</select>
							<input type="text" name="sdate" value="<?php echo $_GET["sdate"]?>" class="datepicker line" maxlength="10" size="10" style="width:66px;" />
							<span class="gray">-</span>
							<input type="text" name="edate" value="<?php echo $_GET["edate"]?>" class="datepicker line" maxlength="10" size="10" style="width:65px;" />

							<span style="padding-left:7px;"></span>
							<button type="button" id="today" class="btn-today" value="오늘" name="select_date"></button><span class="pd_day"></span>
							<button type="button" id="3day" class="btn-day3" value="3일간" name="select_date"></button><span class="pd_day"></span>
							<button type="button" id="1week" class="btn-week1" value="일주일" name="select_date"></button><span class="pd_day"></span>
							<button type="button" id="1month" class="btn-month1" value="1개월" name="select_date"></button><span class="pd_day"></span>
							<button type="button" id="3month" class="btn-month3" value="3개월" name="select_date"></button><span class="pd_day"></span>
							<button type="button" id="all" class="btn-allday" value="전체" name="select_date"></button><span class="pd_day"></span>
						</td>
						<th>상태</th>
						<td>
							<label><input type="checkbox" name="goodsStatus[]" value="normal" <?php if($TPL_VAR["sc"]["goodsStatus"]&&in_array('normal',$TPL_VAR["sc"]["goodsStatus"])){?>checked<?php }?>/> 정상</label>&nbsp;
							<label><input type="checkbox" name="goodsStatus[]" value="runout" <?php if($TPL_VAR["sc"]["goodsStatus"]&&in_array('runout',$TPL_VAR["sc"]["goodsStatus"])){?>checked<?php }?>/> 품절</label>&nbsp;
							<label><input type="checkbox" name="goodsStatus[]" value="purchasing" <?php if($TPL_VAR["sc"]["goodsStatus"]&&in_array('purchasing',$TPL_VAR["sc"]["goodsStatus"])){?>checked<?php }?>/> 재고확보중</label>&nbsp;
							<label><input type="checkbox" name="goodsStatus[]" value="unsold" <?php if($TPL_VAR["sc"]["goodsStatus"]&&in_array('unsold',$TPL_VAR["sc"]["goodsStatus"])){?>checked<?php }?>/> 판매중지</label>
						</td>
					</tr>
					<tr>
						<th>사은품</th>
						<td>
							<select name="gift_seq" class="line" style="width:280px;">
								<option value="">사은품 이벤트 선택</option>
<?php if($TPL_gift_list_1){foreach($TPL_VAR["gift_list"] as $TPL_V1){?><option value="<?php echo $TPL_V1["gift_seq"]?>" <?php if($TPL_VAR["sc"]["gift_seq"]==$TPL_V1["gift_seq"]){?>selected<?php }?>><?php echo $TPL_V1["gift_title"]?></option><?php }}?>
							</select>
						</td>
						<th>중요상품</th>
						<td>
							<label><input type="checkbox" name="favorite_chk[0]" value="1" <?php if($TPL_VAR["sc"]["favorite_chk"][ 0]){?>checked<?php }?>/> <span class="icon-star-gray hand checked list-important"></span></label>
							<label class="ml10"><input type="checkbox" name="favorite_chk[1]" value="1" <?php if($TPL_VAR["sc"]["favorite_chk"][ 1]){?>checked<?php }?>/> <span class="icon-star-gray hand list-important "></span></label>
						</td>
						<th>재고판매</th>
						<td>
							<label><input type="checkbox" name="sale_for_stock" value="stock" <?php if($TPL_VAR["sc"]["sale_for_stock"]=='stock'){?>checked<?php }?>/> 재고판매</label>&nbsp;
							<label><input type="checkbox" name="sale_for_ableStock" value="ableStock" <?php if($TPL_VAR["sc"]["sale_for_ableStock"]=='ableStock'){?>checked<?php }?>/> 가용판매</label>&nbsp;
							<label><input type="checkbox" name="sale_for_unlimited" value="unlimited" <?php if($TPL_VAR["sc"]["sale_for_unlimited"]=='unlimited'){?>checked<?php }?>/> 재고무관</label>&nbsp;
						</td>
						<th>재고(개)</th>
						<td>
							<input type="text" name="sstock" value="<?php echo $_GET["sstock"]?>" class="line" style="width:40px;" /> - <input type="text" name="estock" value="<?php echo $_GET["estock"]?>" class="line" style="width:40px;" />
							<label><input type="checkbox" name="optstock" value="1" <?php if($_GET["optstock"]){?>checked="checked"<?php }?>/> 옵션기준</label>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>