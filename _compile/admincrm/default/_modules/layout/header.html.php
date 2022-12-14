<?php /* Template_ 2.2.6 2022/05/17 12:05:27 /www/music_brother_firstmall_kr/admincrm/skin/default/_modules/layout/header.html 000021039 */ ?>
<?php $this->print_("common_html_header",$TPL_SCP,1);?>


<script type="text/javascript">
	//layout-table
	$(document).ready(function() {

		$("#layout-table").height($(window).height());

	// 상단 회원 검색어 레이어 박스 : start
		$("#crm_search_keyword").keyup(function (e) {
			if ($(this).val()) {
				$('.header_txt_keyword').text($(this).val());
				crmHeaderSearchLayerOpen();
			}else{
				$('.header_searchLayer').hide();
			}
		});

		$("#crm_search_keyword").focus(function () {
			if ($(this).val() && $(this).val()!=$(this).attr('title')) {
				$('.header_txt_keyword').text($(this).val());
				crmHeaderSearchLayerOpen();
			}
			$('.header_txt_order_keyword').html("");
			$('.header_order_search_type_text').hide();
			$("#crm_order_search_keyword").val("");
		});

		$("a.header_member_link_keyword").click(function () {
			var sType = $(this).attr('s_type');
			$('#header_search_type').val(sType);
			$('.header_searchLayer').hide();
			setHeaderMemberSearchTxt(sType);

		});

		var offset = $("#crm_search_keyword").offset();
		$('.header_member_search_type_text').css({
			'position' : 'absolute',
			'z-index' : 999,
			'left' : "53px",
			'line-height' : '25px;',
			'top' : "3px",
			'width':$("#crm_search_keyword").width()-1,
			'height':$("#crm_search_keyword").height()-5
		});

		$(".header_member_search_type_text").click(function () {
			$(".header_member_search_type_text").hide();
			$("#crm_search_keyword").focus();
		});

		$(".header_searchLayer ul li").hover(function() {
			$(".header_searchLayer ul li").removeClass('hoverli');
			$(this).addClass('hoverli');
		});

		$("#crm_search_keyword").keydown(function (e) {
			var searchbox = $(this);

			switch (e.keyCode) {
				case 40:
					if($('.headerMemberSearchUl').find('li.hoverli').length == 0){
						$('.headerMemberSearchUl').find('li:first-child').addClass('hoverli');
					}else{
						if($('.headerMemberSearchUl').find('li:last-child').hasClass("hoverli") ){
							$('.headerMemberSearchUl').find('li::last-child.hoverli').removeClass('hoverli');
							$('.headerMemberSearchUl').find('li:first-child').addClass('hoverli');
						}else{
							$('.headerMemberSearchUl').find('li:not(:last-child).hoverli').removeClass('hoverli').next().addClass('hoverli');
						}
					}
					break;
				case 38:
					if($('.headerMemberSearchUl').find('li.hoverli').length == 0){
						$('.headerMemberSearchUl').find('li:last-child').addClass('hoverli');
					}else{
						if($('.headerMemberSearchUl').find('li:first-child').hasClass("hoverli")){
							$('.headerMemberSearchUl').find('li::first-child.hoverli').removeClass('hoverli');
							$('.headerMemberSearchUl').find('li:last-child').addClass('hoverli');
						}else{
							 $('.headerMemberSearchUl').find('li:not(:first-child).hoverli').removeClass('hoverli').prev().addClass('hoverli');
						}
					}
					break;
				case 13 :
					var index=0;
					 $('.headerMemberSearchUl').find('li').each(function(){
						if($(this).hasClass("hoverli")){
							index=$(this).index();
						}
					});

					$('.headerMemberSearchUl').find('li>a').eq(index).click();
					//$('.header_searchLayer').hide();
					$("#crm_search_keyword").blur();
					topSearchMember();
					e.keyCode = null;
					return false;
					break;
			}
		});
		// 상단 회원 검색어 레이어 박스 : end


		// 상단 주문 검색어 레이어 박스 : start
		$("#crm_order_search_keyword").keyup(function (e) {
			if ($(this).val()) {
				$('.header_txt_order_keyword').text($(this).val());
				crmHeaderOrderSearchLayerOpen();
			}else{
				$('.header_order_searchLayer').hide();
			}
		});

		$("#crm_order_search_keyword").focus(function () {
			if ($(this).val() && $(this).val()!=$(this).attr('title')) {
				crmHeaderOrderSearchLayerOpen();
			}
			$('.header_txt_keyword').html("");
			$('.header_member_search_type_text').hide();
			$("#crm_search_keyword").val("");

		});

		$("a.header_order_link_keyword").click(function () {
			var sType = $(this).attr('s_type');
			$('#header_order_search_type').val(sType);
			$('.header_order_searchLayer').hide();
			setHeaderOrderSearchTxt(sType);
			topSearchOrder('search');

		});

		var offset = $("#crm_search_keyword").offset();
		$('.header_order_search_type_text').css({
			'position' : 'absolute',
			'z-index' : 999,
			'left' : "403px",
			'line-height' : '25px;',
			'top' : "2px",
			'width':$("#crm_search_keyword").width()-1,
			'height':$("#crm_search_keyword").height()-5
		});

		$(".header_order_search_type_text").click(function () {
			$(".header_order_search_type_text").hide();
			$("#crm_order_search_keyword").focus();
		});

		$(".header_order_searchLayer ul li").hover(function() {
			$(".header_order_searchLayer ul li").removeClass('hoverli');
			$(this).addClass('hoverli');
		});

		$("#crm_order_search_keyword").keydown(function (e) {
			var searchbox = $(this);

			switch (e.keyCode) {
				case 40:
					if($('.headerOrderSearchUl').find('li.hoverli').length == 0){
						$('.headerOrderSearchUl').find('li:first-child').addClass('hoverli');
					}else{
						if($('.headerOrderSearchUl').find('li:last-child').hasClass("hoverli") ){
							$('.headerOrderSearchUl').find('li::last-child.hoverli').removeClass('hoverli');
							$('.headerOrderSearchUl').find('li:first-child').addClass('hoverli');
						}else{
							$('.headerOrderSearchUl').find('li:not(:last-child).hoverli').removeClass('hoverli').next().addClass('hoverli');
						}
					}
					break;
				case 38:
					if($('.headerOrderSearchUl').find('li.hoverli').length == 0){
						$('.headerOrderSearchUl').find('li:last-child').addClass('hoverli');
					}else{
						if($('.headerOrderSearchUl').find('li:first-child').hasClass("hoverli")){
							$('.headerOrderSearchUl').find('li::first-child.hoverli').removeClass('hoverli');
							$('.headerOrderSearchUl').find('li:last-child').addClass('hoverli');
						}else{
							 $('.headerOrderSearchUl').find('li:not(:first-child).hoverli').removeClass('hoverli').prev().addClass('hoverli');
						}
					}
					break;
				case 13 :
					var index=0;
					 $('.headerOrderSearchUl').find('li').each(function(){
						if($(this).hasClass("hoverli")){
							index=$(this).index();
						}
					});

					$('.headerOrderSearchUl').find('li>a').eq(index).click();
					//$('.header_searchLayer').hide();
					$("#crm_order_search_keyword").blur();
					//topSearchMember();
					e.keyCode = null;
					return false;
					break;
			}
		});
		// 상단 주문 검색어 레이어 박스 : end
	});



	function setHeaderMemberSearchTxt(sType) {
		var search_type_array = new Array();
		search_type_array['all'] = "";
		search_type_array['user_name'] = "이름 찾기";
		search_type_array['userid'] = "아이디 찾기";
		search_type_array['phone'] = "전화번호 찾기";
		search_type_array['cellphone'] = "휴대폰 찾기";
		search_type_array['email'] = "이메일 찾기";
		var crm_search_keyword = $("#crm_search_keyword").val();
		crm_search_keyword = crm_search_keyword.replace(/(<([^>]+)>)/gi, "");
		$('.header_member_search_type_text').html(search_type_array[sType]+ " : " + crm_search_keyword).show();
	}

	function setHeaderOrderSearchTxt(sType) {
		var search_type_array = new Array();
		search_type_array['all'] = "";
		search_type_array['order_user_name'] = "주문자 찾기";
		search_type_array['recipient_user_name'] = "받는분 찾기";
		search_type_array['depositor'] = "입금자 찾기";
		search_type_array['userid'] = "아이디 찾기";
		search_type_array['order_cellphone'] = "휴대폰 찾기";
		search_type_array['order_email'] = "이메일 찾기";
		$('.header_order_search_type_text').html(search_type_array[sType]+ " : " + $("#crm_order_search_keyword").val()).show();
	}


	function crmHeaderSearchLayerOpen() {
		var offset = $("#crm_search_keyword_div").offset();
		if( offset) {
			$('.header_searchLayer').css({
				'position' : 'absolute',
				'z-index' : 999,
				'left' : '49px',
				'top' : '28px',
				//'width':$("#header_search_keyword").width()+32
				'width':$("#crm_search_keyword_div").width()+26
			}).show();
		}
	}

	function crmHeaderOrderSearchLayerOpen() {
		var offset = $("#crm_search_order_keyword_div").offset();
		if( offset) {
			$('.header_order_searchLayer').css({
				'position' : 'absolute',
				'z-index' : 999,
				'left' : '396px',
				'top' : '28px',
				//'width':$("#header_search_keyword").width()+32
				'width':$("#crm_search_order_keyword_div").width()+26
			}).show();
		}
	}

	function topSearchMember(type){
<?php if($TPL_VAR["memberSearchYn"]!="Y"){?>
			alert("권한이 없습니다.");
<?php }else{?>
		var header_search_keyword = $("input[name='crm_search_keyword']").val();
		var header_search_type = $("input[name='header_search_type']").val();
		$.ajax({
			type: "get",
			url: "../member/catalog",
			data: {"body_crm_search_keyword":header_search_keyword,"body_search_type":header_search_type, "ajaxCall":1, "searchType": type},
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			success: function(result){
				$("#memberSearchDiv").html(result);
				apply_input_style();
			}
		});
		openDialog("회원 검색 <span class='desc'>&nbsp;</span>", "memberSearchDiv", {"width":"98%","height":"650"});
<?php }?>
	}


	function topSearchOrder(type){
<?php if($TPL_VAR["orderSearchYn"]!="Y"){?>
			alert("권한이 없습니다.");
<?php }else{?>
		var crm_order_search_keyword = $("input[name='crm_order_search_keyword']").val();
		var header_order_search_type = $("input[name='header_order_search_type']").val();
		$.ajax({
			type: "get",
			url: "../order/catalog",
			data: {"keyword":crm_order_search_keyword,"body_order_search_type":header_order_search_type, "ajaxCall":1, "searchType":type},
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			success: function(result){
				$("#orderSearchDiv").html(result);
				apply_input_style();
			}
		});
		openDialog("주문 검색 <span class='desc'>&nbsp;</span>", "orderSearchDiv", {"width":"98%","height":"650"});
<?php }?>
	}


	function select_email(seq){
		if(!seq) return;
		/*
		$("input[name='member_chk[]'][value='"+seq+"']").attr('checked',true);
		$("input[name='type']").val('select');
		emailFormOpen();
		*/
		$.get('/admin/member/email_pop?member_seq='+seq, function(data) {
			$('#sendPopup').html(data);
			openDialog("EMAIL 발송", "sendPopup", {"width":"1000","height":"770"});
		});
	}

	function select_sms(seq){
		if(!seq) return;
		/*
		$("input[name='member_chk[]'][value='"+seq+"']").attr('checked',true);
		$("input[name='type']").val('select');
		$("#container").css("height","0px");
		$("#container").attr("src","sms_form");
		$("#container").show();
		*/
		$.get('/admin/member/sms_pop?member_seq='+seq, function(data) {
			$('#sendPopup').html(data);
			openDialog("SMS 발송", "sendPopup", {"width":"700","height":"350"});
		});
	}

</script>

<body>
<style>

</style>
<div id="member_info_layer" class="member_info_layer hide"></div>
<div id="sendPopup" class="hide"></div>
<div id="emoneyPopup" class="hide"></div>
<div id="cashPopup" class="hide"></div>
<div id="download_list_setting" class="hide"></div>
<div id="memberSearchDiv" class="hide"></div>
<div id="orderSearchDiv" class="hide"></div>
<div id="wrap">
	<div id="layout-container" class="<?php echo $TPL_VAR["service_code"]?>"><!-- free premium expantion proexpantion -->
		<!--[ 레이아웃 헤더 : 시작 ]-->
		<div id="layout-header">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<!--[ 레이아웃 헤더 검색 : 시작 ]-->
						<div class="header-snb-container clearbox">
							<a href="/admincrm/main/index"><h1 class="header-logo">고객CRM</h1></a>
							<div class="header-search">
								<table cellspacing="0" cellpadding="0">
									<tr>
										<td>
											<form name="headMemberForm" id="headMemberForm" action="/admin/order/catalog">
<?php if(!$TPL_VAR["managerInfo"]["manager_seq"]){?>
												<div class="manager_seq"></div>
<?php }?>
												<span class="fl form_tit">회원</span>
												<div class="fl form_wrap">
													<div id="crm_search_keyword_div" class="fl hs-box">
														<input type="text" name="crm_search_keyword" id="crm_search_keyword" value="" title="이름, 아이디, 전화번호, 휴대폰, 이메일" />
													</div>
													<span class="fl"><a href="javascript:topSearchMember();"><img src="/admin/skin/default/images/main/search_zoom.gif" /></a></span>
												</div>
											</form>
											<!-- 검색어 입력시 레이어 박스 : start -->
											<div class="header_member_search_type_text hide"><?php echo $_GET["header_member_search_type_text"]?></div>
											<div class="header_searchLayer hide">
												<input type="hidden" name="header_search_type" id="header_search_type" value="" />
												<ul class="headerMemberSearchUl">
													<li><a class="header_member_link_keyword" s_type="all" href="#"><span class="header_txt_keyword"></span> <span class="header_txt_title">- 회원 전체검색</span></a></li>
													<li><a class="header_member_link_keyword" s_type="user_name" href="#">이름 : <span class="header_txt_keyword"></span> <span class="header_txt_title">- 이름 찾기</span></a></li>
													<li><a class="header_member_link_keyword" s_type="userid" href="#">아이디 : <span class="header_txt_keyword"></span> <span class="header_txt_title">- 아이디 찾기</span></a></li>
													<li><a class="header_member_link_keyword" s_type="phone" href="#">전화번호 : <span class="header_txt_keyword"></span> <span class="header_txt_title">- 전화번호 찾기</span></a></li>
													<li><a class="header_member_link_keyword" s_type="cellphone" href="#">휴대폰 : <span class="header_txt_keyword"></span> <span class="header_txt_title">- 휴대폰 찾기</span></a></li>
													<li><a class="header_member_link_keyword" s_type="email" href="#">이메일 : <span class="header_txt_keyword"></span> <span class="header_txt_title">- 이메일 찾기</span></a></li>
												</ul>
											</div>
											<!-- 검색어 입력시 레이어 박스 : end -->
											<script type="text/javascript">
												$("#headMemberForm").blur(function(){
													$(".header_member_search_type_text").show();

													setTimeout(function(){
														$('.header_searchLayer').hide()}, 500
													);
												});
											</script>
										</td>
										<td class="pdl10">
											<form name="headOrderForm" id="headOrderForm" action="/admin/order/catalog">
<?php if(!$TPL_VAR["managerInfo"]["manager_seq"]){?>
												<div class="manager_seq"></div>
<?php }?>
												<span class="fl form_tit">주문</span>
												<div class="fl form_wrap">
													<div id="crm_search_order_keyword_div" class="fl hs-box">
														<input type="text" name="crm_order_search_keyword" id="crm_order_search_keyword" value="" title="주문자, 받는분, 입금자, 아이디, 휴대폰, 이메일" />
													</div>
													<span class="fl"><a href="javascript:topSearchOrder('search');"><img src="/admin/skin/default/images/main/search_zoom.gif" /></a></span>
												</div>
											</form>
											<!-- 검색어 입력시 레이어 박스 : start -->
											<div class="header_order_search_type_text hide"><?php echo $_GET["header_member_search_type_text"]?></div>
											<div class="header_order_searchLayer hide">
												<input type="hidden" name="header_order_search_type" id="header_order_search_type" value="" />
												<ul class="headerOrderSearchUl">
													<li><a class="header_order_link_keyword" s_type="all" href="#"><span class="header_txt_order_keyword"></span> <span class="header_txt_title">- 주문 전체검색</span></a></li>
													<li><a class="header_order_link_keyword" s_type="order_user_name" href="#">주문자 : <span class="header_txt_order_keyword"></span> <span class="header_txt_title">- 주문자 찾기</span></a></li>
													<li><a class="header_order_link_keyword" s_type="recipient_user_name" href="#">받는분 : <span class="header_txt_order_keyword"></span> <span class="header_txt_title">- 받는분 찾기</span></a></li>
													<li><a class="header_order_link_keyword" s_type="depositor" href="#">입금자 : <span class="header_txt_order_keyword"></span> <span class="header_txt_title">- 입금자 찾기</span></a></li>
													<li><a class="header_order_link_keyword" s_type="userid" href="#">아이디 : <span class="header_txt_order_keyword"></span> <span class="header_txt_title">- 휴대폰 찾기</span></a></li>
													<li><a class="header_order_link_keyword" s_type="order_cellphone" href="#">휴대폰 : <span class="header_txt_order_keyword"></span> <span class="header_txt_title">- 휴대폰 찾기</span></a></li>
													<li><a class="header_order_link_keyword" s_type="order_email" href="#">이메일 : <span class="header_txt_order_keyword"></span> <span class="header_txt_title">- 이메일 찾기</span></a></li>
												</ul>
											</div>
											<!-- 검색어 입력시 레이어 박스 : end -->
										</td>
									</tr>
								</table>
							</div>
							<ul class="header-snb clearbox">
<?php if($TPL_VAR["managerInfo"]["manager_seq"]){?>
								<li class="item">
									<div class="hsnb-manager">
										<span class="hsnbm-name">
											<img src=<?php if($TPL_VAR["managerInfo"]["mphoto"]){?>"../../../data/icon/manager/<?php echo $TPL_VAR["managerInfo"]["mphoto"]?>"<?php }else{?>"/admin/skin/default/images/common/myprofile_icon.png"<?php }?> width="26" height="26" align="absmiddle" />
											<?php echo $TPL_VAR["managerInfo"]["manager_id"]?>

										</span>
										<div class="hsnbm-menu">
											<img src="/admin/skin/default/images/main/point_c.png" style="position:absolute;left:190px; top:-5px;"/>
											<table class="tb_admin_info" cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td rowspan="2" style="width:65px; padding-left:5px;">
													<img src=<?php if($TPL_VAR["managerInfo"]["mphoto"]){?>"../../../data/icon/manager/<?php echo $TPL_VAR["managerInfo"]["mphoto"]?>"<?php }else{?>"/admin/skin/default/images/main/def_img.png"<?php }?> width="54" height="54" align="absmiddle" />
												</td>
												<td style="padding-left:15px;">
													<span style="font-weight:bold; font-size:14px; color:#5d5d65;font-family:tahoma;"><?php echo $TPL_VAR["managerInfo"]["manager_id"]?></span>&nbsp;<span style="font-size:12px; color:#5d5d65;">(<?php echo $TPL_VAR["managerInfo"]["mname"]?>)</span>
												</td>
											</tr>
											<tr>
												<td style="padding-left:15px;">
													<span style="font-size:12px; color:#348ddb;">
<?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'){?>대표운영자<?php }else{?>부운영자<?php }?>
													</span>
												</td>
											</tr>
											<tr>
												<td colspan="2" class="tb_bottom_line" >&nbsp;</td>
											</tr>
											<tr>
												<td colspan="2" style="padding-top:8px;">
													<a href="/admin/setting/manager_reg?manager_seq=<?php echo $TPL_VAR["managerInfo"]["manager_seq"]?>" target="_blank"><img src="/admin/skin/default/images/main/my_pbt01.gif" /></a>
													<a href="../login_process/logout"><img src="/admin/skin/default/images/main/my_pbt02.gif" /></a>
												</td>
											</tr>
											</table>
										</div>
									</div>
								</li>
<?php }?>
							</ul>
						</div>
						<!--[ 레이아웃 헤더 검색 : 끝 ]-->
					</td>
<?php if(uri_string()!="crm/main/index"){?>
					<!-- <td width="18%" bgcolor="#ffffff" class="topConselTitle">
						상담관리
					</td> -->
<?php }?>
				</tr>
			</table>
		</div>
		<!--[ 레이아웃 헤더 : 끝 ]-->

		<div id="layout-body">
			<table id="layout-table" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr valign="top">
<?php if(uri_string()!="admincrm/main/index"){?>
					<td width="200" bgcolor="696B77">
						<!--[ 우측 상담 관리 : 시작 ]-->
<?php $this->print_("layout_left",$TPL_SCP,1);?>

						<!--[ 우측 상담 관리 : 시작 ]-->
					</td>
<?php }?>
					<td class="pdl20">
						<!--[ 레이아웃 바디(본문) : 시작 ]-->