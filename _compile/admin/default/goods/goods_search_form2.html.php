<?php /* Template_ 2.2.6 2022/05/17 12:31:50 /www/music_brother_firstmall_kr/admin/skin/default/goods/goods_search_form2.html 000023673 */ 
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);
$TPL_gift_list_1=empty($TPL_VAR["gift_list"])||!is_array($TPL_VAR["gift_list"])?0:count($TPL_VAR["gift_list"]);?>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/goods_admin.css" />
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
				$("div.search-form-container select[name='provider_seq_selector']").next(".ui-combobox").children("input").val('');

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
					$(this).val($("select[name='provider_seq_selector'] option:first-child").text());
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


		$("select[name='provider_seq_selector']").css({'width': 125}).combobox()
				.change(function(){

					var selectedProviderSeq	= $(this).val();

					if( selectedProviderSeq > 0 ){
						$("input[name='provider_seq']").val(selectedProviderSeq);
						$("input[name='provider_name']").val($("option:selected",this).text());
					}else{
						$("input[name='provider_seq']").val('');
						$("input[name='provider_name']").val('');
					}
					
					
					$('select[name="shipping_group_seq"]').val('');
					if (selectedProviderSeq > 0) {
						$('select[name="shipping_group_seq"] > option:gt(0)').addClass('hide');
						$('select[name="shipping_group_seq"] > option[shipping_provider_seq= ' + selectedProviderSeq + ']').removeClass('hide');
					} else {
						$('select[name="shipping_group_seq"] > option').removeClass('hide');
					}


				}).next(".ui-combobox").children("input").css({'width': 125})
				.bind('focus',function(){
					if($(this).val()==$( "select[name='provider_seq_selector'] option:first-child" ).text()){
						$(this).val('');
					}
				})
				.bind('mouseup',function(){
					if($(this).val()==''){
						$( "select[name='provider_seq_selector']").next(".ui-combobox").children("a.ui-combobox-toggle").click();
					}
				})


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
			openDialog(title, "search_detail_dialog", {"width":"1220","height":"320"});
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

<div class="search-form-container">
	<table class="search-form-table search-form-keyword-table mb15">
		<tr>
			<td width="825">
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
			<td width="20">&nbsp;</td>
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
				<table class="sf-option-table">
					<colgroup>
						<col width="60" /><col width="350" />
						<col width="70" /><col width="100" />
						<col width="70" /><col width="250" />
						<col width="70" /><col />
					</colgroup>
<?php if(serviceLimit('H_AD')){?>
					<tr>
						<th>입점사</th>
						<td colspan="7">
							<div class="ui-widget">
								<select name="provider_seq_selector" style="vertical-align:middle;width:125px;">
									<option value="0">- 입점사 검색 -</option>
									<option value="1">본사매입</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?><option value="<?php echo $TPL_V1["provider_seq"]?>"><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option><?php }}?>
								</select>
								<span style="margin-left:20px;">&nbsp;</span>
								<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $_GET["provider_seq"]?>" />
								<input type="text" name="provider_name" value="<?php echo $_GET["provider_name"]?>" style="width:140px;" readonly />
							</div>
							<span class="ptc-charges hide"></span>
						</td>
					</tr>
<?php }?>
					<tr>
						<th>날짜</th>
						<td colspan="5">
							<select class="line" name="date_gb" style="width:100px;">
								<option value="regist_date" <?php if($TPL_VAR["sc"]["date_gb"]=='regist_date'){?>selected<?php }?>>등록일</option>
								<option value="update_date" <?php if($TPL_VAR["sc"]["date_gb"]=='update_date'){?>selected<?php }?>>수정일</option>
							</select>
							<input type="text" name="sdate" value="<?php echo $_GET["sdate"]?>" class="datepicker line" maxlength="10" style="width:90px;" />
							<span class="gray">-</span>
							<input type="text" name="edate" value="<?php echo $_GET["edate"]?>" class="datepicker line" maxlength="10" style="width:90px;" />
							<span style="padding-left:7px;"></span>
							<span class="btn small"><button type="button" id="today" class="" value="오늘" name="select_date">오늘</button></span>
							<span class="btn small"><button type="button" id="3day" class="" value="3일간" name="select_date">3일간</button></span>
							<span class="btn small"><button type="button" id="1week" class="" value="일주일" name="select_date">일주일</button></span>
							<span class="btn small"><button type="button" id="1month" class="" value="1개월" name="select_date">1개월</button></span>
							<span class="btn small"><button type="button" id="3month" class="" value="3개월" name="select_date">3개월</button></span>
							<span class="btn small"><button type="button" id="all" class="" value="전체" name="select_date">전체</button></span>
						</td>
						<th>상태</th>
						<td>
							<label><input type="checkbox" name="goodsStatus[]" value="normal" <?php if($TPL_VAR["sc"]["goodsStatus"]&&in_array('normal',$TPL_VAR["sc"]["goodsStatus"])){?>checked<?php }?>/> 정상</label>
							<label><input type="checkbox" name="goodsStatus[]" value="purchasing" <?php if($TPL_VAR["sc"]["goodsStatus"]&&in_array('purchasing',$TPL_VAR["sc"]["goodsStatus"])){?>checked<?php }?>/> 재고확보중</label>
							<label><input type="checkbox" name="goodsStatus[]" value="unsold" <?php if($TPL_VAR["sc"]["goodsStatus"]&&in_array('unsold',$TPL_VAR["sc"]["goodsStatus"])){?>checked<?php }?>/> 판매중지</label>
						</td>
					</tr>
					<tr>
						<th>사은품</th>
						<td>
							<select name="gift_seq" class="line" style="width:320px;">
								<option value="">사은품 이벤트 선택</option>
<?php if($TPL_gift_list_1){foreach($TPL_VAR["gift_list"] as $TPL_V1){?><option value="<?php echo $TPL_V1["gift_seq"]?>" <?php if($TPL_VAR["sc"]["gift_seq"]==$TPL_V1["gift_seq"]){?>selected<?php }?>><?php echo $TPL_V1["gift_title"]?></option><?php }}?>
							</select>
						</td>
						<th>중요상품</th>
						<td>
							<label><input type="checkbox" name="favorite_chk[0]" value="1" <?php if($TPL_VAR["sc"]["favorite_chk"][ 0]){?>checked<?php }?>/> <span class="icon-star-gray hand checked list-important"></span></label>
							<label><input type="checkbox" name="favorite_chk[1]" value="1" <?php if($TPL_VAR["sc"]["favorite_chk"][ 1]){?>checked<?php }?>/> <span class="icon-star-gray hand list-important "></span></label>
						</td>
						<th>재고판매</th>
						<td>
							<label><input type="checkbox" name="sale_for_stock" value="stock" <?php if($TPL_VAR["sc"]["sale_for_stock"]=='stock'){?>checked<?php }?>/> 재고판매</label>
							<label><input type="checkbox" name="sale_for_ableStock" value="ableStock" <?php if($TPL_VAR["sc"]["sale_for_ableStock"]=='ableStock'){?>checked<?php }?>/> 가용판매</label>
							<label><input type="checkbox" name="sale_for_unlimited" value="unlimited" <?php if($TPL_VAR["sc"]["sale_for_unlimited"]=='unlimited'){?>checked<?php }?>/> 재고무관</label>
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