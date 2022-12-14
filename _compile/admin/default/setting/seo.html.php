<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/setting/seo.html 000044701 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>

<script type="text/javascript">
	$(document).ready(function() {	

		$('#snslogoUpdateBtn').createAjaxFileUpload(uploadConfig, uploadCallback);
<?php if($TPL_VAR["config_system"]["snslogo"]){?>imgUploadEvent("#snslogoUpdateBtn", "", "", "<?php echo $TPL_VAR["config_system"]["snslogo"]?>")<?php }?>;	

		
		$(".meta_set_btn").click(function(){
			var mode	= $(this).attr('meta_type');
			set_meta_info(mode);
		});
		
		$("#alt_set_btn").click(function(){
			$('.code_page_name').text('상품');
			$('.image_alt_value').val($('input[name="image_alt"]').val());
			openDialog("검색엔진 수집정보 - 상품 이미지", "image_alt_set_pop", {"width":"800","height":"270","show" : "fade","hide" : "fade"});
		});

		$(".check_allow").on("change", function(){		
			contentsSetting($(this).closest("table"), $(this).val())			
		})

		
		
		$('#subTab > li > a').on("click", function(){
			var type = $(this).attr("meta_type")
			var data_selector = $("#"+$(this).data('showcontent'));
			contentsSetting(data_selector, $("input[name='"+type+"_allow']:checked").val())		
		});

		//짧은주소 관련
		$("input[name='shorturl_use']").click(function(){
			showShorturl();
		});

		showShorturl();		

		$("button#snslogoUpdate").live("click",function(){
			//$('#fbunlikeiconRegist')[0].reset();
			openDialog("쇼핑몰 로고", "snslogoUpdatePopup", {"width":"380","height":"150","show" : "fade","hide" : "fade"});
		});

		$("button#snsmetaTagUpdate").live("click",function(){
			//$('#fbunlikeiconRegist')[0].reset();
			openDialog("쇼핑몰 소개", "snsmetaTagUpdatePopup", {"width":"600","show" : "fade","hide" : "fade"});
		});

		$("#replaceCodeBtn").live("click", function(){
			var mode = $("#subTab").find(".current").attr("meta_type")
			var id = "replace_code_"+mode;			

			openDialog("치환코드", id, {"width":"750","show" : "fade","hide" : "fade"});			
		});

		$("#prodAltreplaceCodeBtn").live("click", function(){
			openDialog("치환코드", "replace_code_prod_alt", {"width":"750","show" : "fade","hide" : "fade"});			
		});

		// shorturl url 설정
		$(".shorturlConfig").click(function() {
			var winH = "235";			
<?php if($TPL_VAR["sns"]["shorturl_app_key"]&&$TPL_VAR["sns"]["shorturl_app_id"]){?>	winH = 390;<?php }?>			
			openDialog("짧은 URL 설정", "shorturl_help_lay", {"width":"600","height":winH,"show" : "fade","hide" : "fade"});
		});

		$("#meta_save_btn").click(function(){save_meta_info()});
		$("#image_alt_save_btn").click(function(){save_image_alt_info()});

		/* 메타태그(sns 소개) 저장 */
		$("#btnmetatag").on("click",function(){
			var descript = $("#metaTagDescription").val();
			var keyword  = $("#metaTagKeyword").val();

			var data = {"metaTagDescription":descript,"metaTagKeyword":keyword}
			$.ajax({
				'url' : '../setting_process/snsconf_snsmetatag',
				'type' : 'post',
				'data': data,
				'dataType': 'json',
				'success': function(res) {
					openDialogAlert("저장 되었습니다.",400,140,'parent','');
					$("#vmetaTagDescription").val(descript);
					$("#vmetaTagKeyword").val(keyword);
					$("#snsmetaTagUpdatePopup").dialog("close");
				}
				,'error': function(e){
				}
			});
		});	

		$("#snslogoDelete").live("click",function(){
			var url = '../setting_process/snslogo_delete';//favicon_delete
			var obj = $(this);
			$.getJSON(url, function(data) {
				if(data['result'] == 'ok'){			
					$("#snslogo_div").css("display","none");					
				}
			});
		});		
		
		// 레이어팝업 수정 기능 제거 by hed #37117
		$(".meta_set_btn").hide();
		for(var i=1;i<9;i++){
			$("#tabCon"+i+" .table_basic span").hide();
			$("#tabCon"+i+" .table_basic input[type='hidden']").each(function(){
				var inputName = $(this).attr("name");
				var textObj = $("<input type=\"text\" name=\"" + inputName + "\" value=\"" + $(this).val() + "\">");
				textObj.addClass("inputW")
				var td = $(this).parent();
				$(this).remove();
				td.append(textObj);
				
				// tooltip 생성
				var inputNameValue = inputName.replace(/([a-z_])+\[/, "");
				var inputNameValue = inputNameValue.replace(/\]/, "");
				var th = td.prev();
				var tooltip = $("<span class=\"tooltip_btn\" onClick=\"showTooltip(this, '/admin/tooltip/seo', '#tip_seo_" + inputNameValue + "')\"></span>");
				th.append(tooltip);				
			});
		}

		$("#alt_set_btn").hide();
		$("#alt_set_btn").next().find("span").hide();
		$("#alt_set_btn").next().find("input[type='hidden']").each(function(){
			var textObj = $("<input type=\"text\" name=\"" + $(this).attr("name") + "\" value=\"" + $(this).val() + "\">");
			textObj.addClass("inputW")
			var td = $(this).parent();
			$(this).remove();
			td.append(textObj);
		});

		// 치환코드 컨트롤
		$("#subTab a").click(function(){
			$(".replace_code_tabCon").hide();
			$(".replace_code_"+$(this).data("showcontent")).show();
		});
		$("#subTab a").first().trigger("click");		
	
	});

	function contentsSetting(obj, val)
	{
		if(val=="allow")
		{
			obj.find(".detaile_setting").show();
		}else{
			obj.find(".detaile_setting").hide();				
		}
	}		

	function showShorturl()
	{
		if( $("input[name='shorturl_use']:checked").val() == "Y" ) {
			$(".btnshorturl").show();
		}else{
			$(".btnshorturl").hide();
		}
	}

	function snslogoDisplay(filenm){
		$(".snslogo_img").attr("src",filenm);
		$(".snslogo_img").css("display","block");
		$(".snslogo_img").css("width","100");
		$("#snslogomsg").css("display","none");
		$("#snslogoDelete").css("display","block");
		$("#snslogo_div").show();
		$("#snslogo_msg").hide();
		$('#snslogoRegist')[0].reset();
		$("#snslogoUpdatePopup").dialog("close");
	}	

	function snslogoFileUpload(str){
		if(str > 0) {
			alert('로고를 선택해 주세요.');
			return false;
		}

		var frm = $('#snslogoRegist');
		frm.attr("action","../setting_process/snsconf_snslogo");
		frm.submit();
	}

	function view_search_engine_content(mode){
		var params	= {};
		params.mode	= mode;
		$.get('/admin/setting_process/get_search_engine_content', params, function(response){
			$('#' + mode + '_content_view').html("<xmp>" + response.content + "</xmp>");
		},'json');

		//robots_txt_view
		openDialog("검색엔진 정보수집", mode + "_view_pop", {"width":"800","height":"420","show" : "fade","hide" : "fade"});
	}

	function set_meta_info(mode){
		
		var replace_code	= 'show';
		var height			= 380;

		switch(mode){
			case	'others' :
				var title		= '메인페이지 및 기타 페이지';				
			break;
			
			case	'goods_view' :
				var title		= '상품상세 페이지';
				var type_txt	= '상품';	
				height			= 400;
			break;
			
			case	'category' :
				var title		= '카테고리 페이지';
				var type_txt	= '카테고리';		
				break;

			case	'brand' :
				var title		= '브랜드 페이지';
				var type_txt	= '브랜드';			
			break;
			
			case	'location' :
				var title		= '지역 페이지';
				var type_txt	= '지역';		
			break;

			case	'board' :
				var title		= '게시판 페이지';
				var type_txt	= '게시판';
			break;
			
			case	'event' :
				var title		= '이벤트 페이지';
				var type_txt	= '이벤트';
			break;
		}
		
		$('.meta_title_pop').html(title);
		
		if(replace_code == 'hide')	$('.replace_code_ctl').hide();
		else						$('.replace_code_ctl').show();		
		
		$('.replace_code').hide();
		$('.' + mode + '_code').show();
		$('.code_page_name').text(type_txt);
		$('#meta_mode_code').val(mode);
		
		$('.meta_info_value').each(function(){
			this.value	= $('input[name="' + mode + '[' + this.name + ']"]').val();
		});

		openDialog(title, "meta_set_pop", {"width":"800","height":height,"show" : "fade","hide" : "fade"});		
	}

	function save_meta_info(){
		var mode	= $('#meta_mode_code').val();
		
		switch(mode){
			case	'others' :	
			case	'goods_view' :
			case	'category' :
			case	'brand' :
			case	'location' :
			case	'board' :
			case	'event' :
			break;
			default :
				closeDialog('meta_set_pop');
				return false;
				break;
		}

		var target	= '';
		var _inpit	= '';


		if($.trim($('.meta_info_value[name="title"]').val()) == ''){
			openDialogAlert("타이틀을 입력하세요",300,155,'parent');
			return false;
		}

		if($.trim($('.meta_info_value[name="description"]').val()) == ''){
			openDialogAlert("설명을 입력하세요",300,155,'parent');
			return false;
		}

		if($.trim($('.meta_info_value[name="keywords"]').val()) == ''){
			openDialogAlert("키워드를 입력하세요",300,155,'parent');
			return false;
		}

		$('.meta_info_value').each(function(){
			target		= this.name;
			_input_dom	= $('input[name="' + mode + '[' + target + ']"]');
			_input_dom.val(this.value);
			_input_dom.next('span').html(this.value);
		});

		$('#meta_mode_code').val('');
		$('.code_page_name').text('');
		$('.meta_info_value').val('');
		closeDialog('meta_set_pop');
	}

	function save_image_alt_info(){
		var value	= $('.image_alt_value').val();
		_input_dom	= $('input[name="image_alt"]');
		_input_dom.val(value);
		_input_dom.next('span').html(value);
		closeDialog('image_alt_set_pop');
	}	
</script>

<style>
	.file-info li{float:left; text-align:center;}
	.file-info li:after {content: "|";}
	.file-info li.none:after {content: ''}
	.inputW {width:555px;}	
</style>

<form name="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/seo" target="actionFrame">

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
			<h2>검색엔진최적화(SEO)</h2>
		</div>

		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<button class="resp_btn active size_L" type="submit">저장</button>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
	<!-- 서브메뉴 바디 : 시작-->
	<ul class="tab_02 tabEvent">
		<li><a href="#basic" data-showcontent="basic">검색엔진 최적화 설정</a></li>
		<li><a href="#advance" data-showcontent="advance" >고급 설정</a></li>						
	</ul>	
	
	<div id="basic" class="hide">
		<div class="contents_dvs">
			<div class="item-title">
				검색엔진 수집 정보	
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/seo', '#tip3', 'sizeM')"></span>
			</div>	
			<div class="dvs_box">
				<ul id="subTab" class="tab_01 tabEvent">
					<li><a href="javascript:void(0);" data-showcontent="tabCon1" meta_type="others"  class="current">메인 및 기타</a></li>
					<li><a href="javascript:void(0);" data-showcontent="tabCon2" meta_type="goods_view">상품 상세</a></li>
					<li><a href="javascript:void(0);" data-showcontent="tabCon3" meta_type="category">카테고리</a></li>
					<li><a href="javascript:void(0);" data-showcontent="tabCon4" meta_type="brand">브랜드</a></li>
					<li><a href="javascript:void(0);" data-showcontent="tabCon5" meta_type="location">지역</a></li>
					<li><a href="javascript:void(0);" data-showcontent="tabCon6" meta_type="board">게시판</a></li>
					<li><a href="javascript:void(0);" data-showcontent="tabCon7" meta_type="event">이벤트</a></li>
					<li><a href="javascript:void(0);" data-showcontent="tabCon8" meta_type="broadcast">라이브 쇼핑</a></li>
				</ul>
				
				<!----------메인 및 기타----------------------------------------->

				<div id="tabCon1">
					<table class="table_basic thl">
						<tr>
							<th>타이틀: Title</th>
							<td>
								<input type="hidden" name="others[title]" value="<?php echo $TPL_VAR["others"]["title"]?>"/>
								<span><?php echo $TPL_VAR["others"]["title"]?></span>
							</td>
						</tr>
						<tr>
							<th>제작자: Author</th>
							<td>
								<input type="hidden" name="others[author]" value="<?php echo $TPL_VAR["others"]["author"]?>"/>
								<span><?php echo $TPL_VAR["others"]["author"]?></span>
							</td>
						</tr>
						<tr>
							<th>설명: Description</th>
							<td>
								<input type="hidden" name="others[description]" value="<?php echo $TPL_VAR["others"]["description"]?>"/>
								<span><?php echo $TPL_VAR["others"]["description"]?></span>
							</td>
						</tr>
						<tr>
							<th>키워드: Keyword</th>
							<td>
								<input type="hidden" name="others[keywords]" value="<?php echo $TPL_VAR["others"]["keywords"]?>"/>
								<span><?php echo $TPL_VAR["others"]["keywords"]?></span>
							</td>
						</tr>							
					</table>	
				</div>			

				<!----------상품상세----------------------------------------->
				
				<div id="tabCon2" class="hide">
					<table class="table_basic thl">
						<tr>
							<th>사용 여부</th>
							<td>
								<div class="resp_radio">
									<label><input class="check_allow" type="radio" name="goods_view_allow" value="allow" <?php if($TPL_VAR["goods_view_allow"]=="allow"){?>checked="checked"<?php }?>> 사용함</label>
									<label><input class="check_allow" type="radio"  name="goods_view_allow" value="disallow" <?php if($TPL_VAR["goods_view_allow"]=="disallow"||$TPL_VAR["goods_view_allow"]==""){?>checked="checked"<?php }?>> 사용 안 함</label>
								</div>
							</td>
						</tr>
						
						<tr class="detaile_setting">
							<th>타이틀: Title</th>
							<td>
								<input type="hidden" name="goods_view[title]" value="<?php echo $TPL_VAR["goods_view"]["title"]?>"/>
								<span><?php echo $TPL_VAR["goods_view"]["title"]?></span>
							</td>
						</tr>
						
						<tr class="detaile_setting">
							<th>제작자: Author</th>
							<td>
								<input type="hidden" name="goods_view[author]" value="<?php echo $TPL_VAR["goods_view"]["author"]?>"/>
								<span><?php echo $TPL_VAR["goods_view"]["author"]?></span>
							</td>
						</tr>
						
						<tr class="detaile_setting">
							<th>설명: Description</th>
							<td>
								<input type="hidden" name="goods_view[description]" value="<?php echo $TPL_VAR["goods_view"]["description"]?>"/>
								<span><?php echo $TPL_VAR["goods_view"]["description"]?></span>
							</td>
						</tr>
						
						<tr class="detaile_setting">
							<th>키워드: Keyword</th>
							<td>
								<input type="hidden" name="goods_view[keywords]" value="<?php echo $TPL_VAR["goods_view"]["keywords"]?>"/>
								<span><?php echo $TPL_VAR["goods_view"]["keywords"]?></span>
							</td>
						</tr>			
					</table>
				</div>
				
				<!----------카테고리----------------------------------------->

				<div id="tabCon3" class="hide">
					<table class="table_basic thl">
						<tr>
							<th>사용 여부</th>
							<td>
								<div class="resp_radio">
									<label><input class="check_allow" type="radio" name="category_allow" value="allow" <?php if($TPL_VAR["category_allow"]=="allow"){?>checked="checked"<?php }?>> 사용함</label>
									<label><input class="check_allow" type="radio"  name="category_allow" value="disallow" <?php if($TPL_VAR["category_allow"]=="disallow"||$TPL_VAR["category_allow"]==""){?>checked="checked"<?php }?>> 사용 안 함</label>
								</div>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>타이틀: Title</th>
							<td>
								<input type="hidden" name="category[title]" value="<?php echo $TPL_VAR["category"]["title"]?>"/>
								<span><?php echo $TPL_VAR["category"]["title"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>제작자: Author</th>
							<td>
								<input type="hidden" name="category[author]" value="<?php echo $TPL_VAR["category"]["author"]?>"/>
								<span><?php echo $TPL_VAR["category"]["author"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>설명: Description</th>
							<td>
								<input type="hidden" name="category[description]" value="<?php echo $TPL_VAR["category"]["description"]?>"/>
								<span><?php echo $TPL_VAR["category"]["description"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>키워드: Keyword</th>
							<td>
								<input type="hidden" name="category[keywords]" value="<?php echo $TPL_VAR["category"]["keywords"]?>"/>
								<span><?php echo $TPL_VAR["category"]["keywords"]?></span>
							</td>
						</tr>	
					</table>
				</div>

				<!----------브랜드----------------------------------------->
				
				<div id="tabCon4" class="hide">
					<table class="table_basic thl">
						<tr>
							<th>사용 여부</th>
							<td>
								<div class="resp_radio">
									<label><input class="check_allow" type="radio" name="brand_allow" value="allow" <?php if($TPL_VAR["brand_allow"]=="allow"){?>checked="checked"<?php }?>> 사용함</label>
									<label><input class="check_allow" type="radio"  name="brand_allow" value="disallow" <?php if($TPL_VAR["brand_allow"]=="disallow"||$TPL_VAR["brand_allow"]==""){?>checked="checked"<?php }?>> 사용 안 함</label>
								</div>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>타이틀: Title</th>
							<td>
								<input type="hidden" name="brand[title]" value="<?php echo $TPL_VAR["brand"]["title"]?>"/>
								<span><?php echo $TPL_VAR["brand"]["title"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>제작자: Author</th>
							<td>
								<input type="hidden" name="brand[author]" value="<?php echo $TPL_VAR["brand"]["author"]?>"/>
								<span><?php echo $TPL_VAR["brand"]["author"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>설명: Description</th>
							<td>
								<input type="hidden" name="brand[description]" value="<?php echo $TPL_VAR["brand"]["description"]?>"/>
								<span><?php echo $TPL_VAR["brand"]["description"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>키워드: Keyword</th>
							<td>
								<input type="hidden" name="brand[keywords]" value="<?php echo $TPL_VAR["brand"]["keywords"]?>"/>
								<span><?php echo $TPL_VAR["brand"]["keywords"]?></span>
							</td>
						</tr>	
					</table>
				</div>

				<!----------지역----------------------------------------->
				
				<div id="tabCon5" class="hide">
					<table class="table_basic thl">
						<tr>
							<th>사용 여부</th>
							<td>
								<div class="resp_radio">
									<label><input class="check_allow" type="radio" name="location_allow" value="allow" <?php if($TPL_VAR["location_allow"]=="allow"){?>checked="checked"<?php }?>> 사용함</label>
									<label><input class="check_allow" type="radio"  name="location_allow" value="disallow" <?php if($TPL_VAR["location_allow"]=="disallow"||$TPL_VAR["location_allow"]==""){?>checked="checked"<?php }?>> 사용 안 함</label>
								</div>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>타이틀: Title</th>
							<td>
								<input type="hidden" name="location[title]" value="<?php echo $TPL_VAR["location"]["title"]?>"/>
								<span><?php echo $TPL_VAR["location"]["title"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>제작자: Author</th>
							<td>
								<input type="hidden" name="location[author]" value="<?php echo $TPL_VAR["location"]["author"]?>"/>
								<span><?php echo $TPL_VAR["location"]["author"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>설명: Description</th>
							<td>
								<input type="hidden" name="location[description]" value="<?php echo $TPL_VAR["location"]["description"]?>"/>
								<span><?php echo $TPL_VAR["location"]["description"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>키워드: Keyword</th>
							<td>
								<input type="hidden" name="location[keywords]" value="<?php echo $TPL_VAR["location"]["keywords"]?>"/>
								<span><?php echo $TPL_VAR["location"]["keywords"]?></span>
							</td>
						</tr>						
					</table>
				</div>

				<!----------게시판----------------------------------------->
				
				<div id="tabCon6" class="hide">
					<table class="table_basic thl">
						<tr>
							<th>사용 여부</th>
							<td>
								<div class="resp_radio">
									<label><input class="check_allow" type="radio" name="board_allow" value="allow" <?php if($TPL_VAR["board_allow"]=="allow"){?>checked="checked"<?php }?>> 사용함</label>
									<label><input class="check_allow" type="radio"  name="board_allow" value="disallow" <?php if($TPL_VAR["board_allow"]=="disallow"||$TPL_VAR["board_allow"]==""){?>checked="checked"<?php }?>> 사용 안 함</label>
								</div>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>타이틀: Title</th>
							<td>
								<input type="hidden" name="board[title]" value="<?php echo $TPL_VAR["board"]["title"]?>"/>
								<span><?php echo $TPL_VAR["board"]["title"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>제작자: Author</th>
							<td>
								<input type="hidden" name="board[author]" value="<?php echo $TPL_VAR["board"]["author"]?>"/>
								<span><?php echo $TPL_VAR["board"]["author"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>설명: Description</th>
							<td>
								<input type="hidden" name="board[description]" value="<?php echo $TPL_VAR["board"]["description"]?>"/>
								<span><?php echo $TPL_VAR["board"]["description"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>키워드: Keyword</th>
							<td>
								<input type="hidden" name="board[keywords]" value="<?php echo $TPL_VAR["board"]["keywords"]?>"/>
								<span><?php echo $TPL_VAR["board"]["keywords"]?></span>
							</td>
						</tr>		
					</table>
				</div>

				<!----------이벤트----------------------------------------->
				
				<div id="tabCon7" class="hide">
					<table class="table_basic thl">
						<tr>
							<th>사용 여부</th>
							<td>
								<div class="resp_radio">
									<label><input class="check_allow" type="radio" name="event_allow" value="allow" <?php if($TPL_VAR["event_allow"]=="allow"){?>checked="checked"<?php }?>> 사용함</label>
									<label><input class="check_allow" type="radio"  name="event_allow" value="disallow" <?php if($TPL_VAR["event_allow"]=="disallow"||$TPL_VAR["event_allow"]==""){?>checked="checked"<?php }?>> 사용 안 함</label>
								</div>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>타이틀: Title</th>
							<td>
								<input type="hidden" name="event[title]" value="<?php echo $TPL_VAR["event"]["title"]?>"/>
								<span><?php echo $TPL_VAR["event"]["title"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>제작자: Author</th>
							<td>
								<input type="hidden" name="event[author]" value="<?php echo $TPL_VAR["event"]["author"]?>"/>
								<span><?php echo $TPL_VAR["event"]["author"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>설명: Description</th>
							<td>
								<input type="hidden" name="event[description]" value="<?php echo $TPL_VAR["event"]["description"]?>"/>
								<span><?php echo $TPL_VAR["event"]["description"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>키워드: Keyword</th>
							<td>
								<input type="hidden" name="event[keywords]" value="<?php echo $TPL_VAR["event"]["keywords"]?>"/>
								<span><?php echo $TPL_VAR["event"]["keywords"]?></span>
							</td>
						</tr>		
					</table>
				</div>

				<!----------라이브 쇼핑----------------------------------------->
				<div id="tabCon8" class="hide">
					<table class="table_basic thl">
						<tr>
							<th>사용 여부</th>
							<td>
								<div class="resp_radio">
								<label><input class="check_allow" type="radio" name="broadcast_allow" value="allow" <?php if($TPL_VAR["broadcast_allow"]=="allow"){?>checked="checked"<?php }?>> 사용함</label>
								<label><input class="check_allow" type="radio"  name="broadcast_allow" value="disallow" <?php if($TPL_VAR["broadcast_allow"]=="disallow"||$TPL_VAR["broadcast_allow"]==""){?>checked="checked"<?php }?>> 사용 안 함</label>
								</div>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>타이틀: Title</th>
							<td>
								<input type="hidden" name="broadcast[title]" value="<?php echo $TPL_VAR["broadcast"]["title"]?>"/>
								<span><?php echo $TPL_VAR["broadcast"]["title"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>제작자: Author</th>
							<td>
								<input type="hidden" name="broadcast[author]" value="<?php echo $TPL_VAR["broadcast"]["author"]?>"/>
								<span><?php echo $TPL_VAR["broadcast"]["author"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>설명: Description</th>
							<td>
								<input type="hidden" name="broadcast[description]" value="<?php echo $TPL_VAR["broadcast"]["description"]?>"/>
								<span><?php echo $TPL_VAR["broadcast"]["description"]?></span>
							</td>
						</tr>
						<tr class="detaile_setting">
							<th>키워드: Keyword</th>
							<td>
								<input type="hidden" name="broadcast[keywords]" value="<?php echo $TPL_VAR["broadcast"]["keywords"]?>"/>
								<span><?php echo $TPL_VAR["broadcast"]["keywords"]?></span>
							</td>
						</tr>		
					</table>
				</div>
				
				<div class="resp_message">
					<span class="gray">- 검색엔진 수집 정보를 위한 치환 코드 안내</span>
					<span id="replaceCodeBtn" class="resp_btn size_S">치환코드</span>
				</div>
			</div>			
		</div>
		
		<div class="contents_dvs">
			<div class="item-title">
				상품 이미지 Alt
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/seo', '#tip9')"></span>
			</div>			
			
			<table class="table_basic thl">
				<tr>
					<th>이미지 설정: Alt태그</th>
					<td>						
						<input type="text" name="image_alt" value="<?php echo $TPL_VAR["image_alt"]?>" class="inputW"/>							
					</td>
				</tr>
			</table>

			<div class="resp_message">
				<span class="gray">- 검색엔진 수집 정보를 위한 치환 코드 안내</span>
				<span id="prodAltreplaceCodeBtn" class="resp_btn size_S">치환코드</span>
			</div>
		</div>

		<div class="box_style_05 mt20">
			<div class="title">안내</div>
			<ul class="bullet_circle">					
				<li>검색엔진최적화(Search Engine Optimization, SEO)란 쇼핑몰을 포털 사이트 검색 결과 상위에 노출 시키기 위한 설정입니다. </li>	
				<li>검색엔진에 최적화된 쇼핑몰 정보를 제공함으로써 쇼핑몰을 효과적으로 홍보할 수 있습니다.</li>
				<li>검색엔진최적화 내 사이트 등록하기 FAQ<br />
				-&nbsp&nbsp네이버 <a href="https://www.firstmall.kr/customer/faq/96" class="link_blue_01" target="_blank">자세히 보기></a><br />
				-&nbsp&nbsp다음 <a href="https://www.firstmall.kr/customer/faq/1202" class="link_blue_01" target="_blank">자세히 보기></a><br />
				-&nbsp&nbsp구글 <a href="https://www.firstmall.kr/customer/faq/1146" class="link_blue_01" target="_blank">자세히 보기></a></li>
			</ul>
		</div>
	</div>

	<div id="advance" class="hide">
		<div class="contents_dvs">
			<div class="item-title">
				오픈 그래프 태그
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/seo', '#tip10')"></span>
			</div>

			<table class="table_basic thl">
				<tr>
					<th>로고</th>
					<td>
						<div class="webftpFormItem">									
							<label class="resp_btn v2"><input type="file" id="snslogoUpdateBtn" accept="image/*">파일선택</label>
							<input type="hidden" class="webftpFormItemInput" name="snslogo" value="<?php echo $TPL_VAR["config_system"]["snslogo"]?>" size="30" maxlength="255" />									
							<div class="preview_image"></div>
						</div>
						<div class="resp_message v2">- 이미지 가로 사이즈 400px이상</div>
					</td>
				</tr>				
				
				<tr>
					<th>
						메타태그<br>
						<button class="resp_btn v2" type="button" id="snsmetaTagUpdate">등록</button>			
					</th>
					<td class="clear">
						<table class="table_basic thl v3">
							<col width="170" /><col />
							<tr>
								<th>설명</th>
								<td>						
									<input disabled type="text" name="metaTagDescription" id="vmetaTagDescription" class="line inputW" title="검색엔진에서 수집할 사이트의 설명을 입력하세요" <?php if($TPL_VAR["metaTagDescription"]){?>value="<?php echo $TPL_VAR["metaTagDescription"]?>"<?php }?> />		
								</td>
							</tr>

							<tr>
								<th>키워드</th>
								<td>						
									<input disabled type="text" name="metaTagKeyword" id="vmetaTagKeyword" class="line inputW" <?php if($TPL_VAR["metaTagKeyword"]){?>value="<?php echo $TPL_VAR["metaTagKeyword"]?>"<?php }?> title="검색엔진에서 수집할 사이트의 키워드(콤마구분)을 입력하세요.<?php echo chr( 10)?>예) 여성의류, 캐주얼 패션, 청소년 의류" />			
								</td>
							</tr>
						</table>
					</td>
				</tr>				
			
				<tr>
					<th>
						URL 정보 제공 방식
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/seo', '#tip8')"></span>
					</th>
					<td>	
						<div class="resp_radio">
							<label><input type="radio" name="shorturl_use" value="N" <?php if($TPL_VAR["sns"]["shorturl_use"]=='N'||!$TPL_VAR["sns"]["shorturl_use"]){?> checked="checked" <?php }?> /> URL 주소 정보 제공</label>	
							<label><input type="radio" name="shorturl_use" id="shorturl_use" value="Y" <?php if($TPL_VAR["sns"]["shorturl_use"]=='Y'){?> checked="checked" <?php }?> > URL 주소 정보를 짧게 변환</label>
						</div>
					</td>
				</tr>
				
				<tr class="btnshorturl hide">
					<th>짧은 URL 변환</th>
					<td>
						<span >
							<button type="button" class="shorturlConfig resp_btn v2">설정</button> <?php if($TPL_VAR["set_string"]){?><?php if($TPL_VAR["set_url"]){?><br/><span class="red"><?php }else{?><span class="red"><?php }?>(<?php echo $TPL_VAR["set_string"]?>)</span><?php }?>
						</span>
					</td>
				</tr>
				
			</table>	
		</div>

		<div class="contents_dvs">
			<div class="item-title">
				검색로봇 접근 권한 설정
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/seo', '#tip1', 'sizeM')"></span>
			</div>	
		
			<table class="table_basic thl">
				<tr>
					<th>robots.txt 등록</th>
					<td>					
						<span class="filebox resp_btn v2">
							<label for="rebots_file">파일선택</label>
							<input type="file" name="rebots_file" id="rebots_file" accept=".txt">
						</span>			
					
<?php if($TPL_VAR["robots"]["size"]> 0){?>
						<ul class="ul_list_03">
							<li><a href="javascript:view_search_engine_content('robots');" />robots.txt</a></li>
							<li><?php echo $TPL_VAR["robots"]["size"]?> bytes</li>
							<li><?php echo $TPL_VAR["robots"]["time"]?></li>
						</ul>	
<?php }?>
						
					</td>
				</tr>
			</table>		
		</div>

		<div class="contents_dvs">
			<div class="item-title">
				사이트 맵 설정
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/seo', '#tip2', 'sizeM')"></span>
			</div>
			<table class="table_basic thl">			
				<tr>
					<th>sitemap.xml 등록</th>
					<td>
						<span class="filebox resp_btn v2">
							<label for="sitemap_file">파일선택</label>
							<input type="file" name="sitemap_file" id="sitemap_file" accept=".xml">
						</span>		

<?php if($TPL_VAR["sitemap"]["size"]> 0){?>
						<ul class="ul_list_03">
							<li><a href="javascript:view_search_engine_content('sitemap');" />sitemap.xml</a></li>
							<li><?php echo $TPL_VAR["sitemap"]["size"]?> bytes</li>
							<li><?php echo $TPL_VAR["sitemap"]["time"]?></li>											
						</ul>
<?php }?>		
					</td>
				</tr>
			</table>
		</div>
	</div>

</form>

<!--- include : snsconf_shorturl_setting.html -->
<?php $this->print_("shorturl_setting",$TPL_SCP,1);?>


<div id="snslogoUpdatePopup" class="hide">
	<form name="snslogoRegist" id="snslogoRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">
	<div style="height:20px;padding-left:30px;"><span class='desc'>로고 사이즈는 400px 이상으로 등록해 주세요.</span></div>
	<div style="height:30px;padding-left:30px;"><input type="file" name="snslogoFile" class="line"  id="snslogoFile" onChange="snslogoFileUpload();" /></div>
	</form>
</div>

<div id="snsmetaTagUpdatePopup" class="hide">
	<form name="snsmetatagRegist" id="snsmetatagRegist" method="post" action="" target="actionFrame">
	<div class="item-title">쇼핑몰 설명</div>
	<textarea name="metaTagDescription" id="metaTagDescription"  rows="4" class="line pd_wx100" title="검색엔진에서 수집할 사이트의 설명을 입력하세요" ><?php echo $TPL_VAR["metaTagDescription"]?></textarea>

	<div class="item-title">쇼핑몰 키워드</div>	
	<textarea name="metaTagKeyword" id="metaTagKeyword" rows="4" class="line pd_wx100" title="검색엔진에서 수집할 사이트의 키워드(콤마구분)을 입력하세요.<?php echo chr( 10)?>예) 여성의류, 캐주얼 패션, 청소년 의류"><?php echo $TPL_VAR["metaTagKeyword"]?></textarea>
	
	<div class="footer">
		<button type="button" id="btnmetatag" class="resp_btn active size_XL">등록</button>
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">취소</button>
	</div>

	</form>
</div>

<div id="replace_code_others" class="replace_code hide">
	<table class="table_basic v7">
		<col width="30%" /><col width="70%" />
		<tr>
			<th>치환코드</th>
			<th>설명</th>
		</tr>
		<tr>
			<td>{<?php echo "쇼핑몰명"?>}</td>
			<td>상점 정보 : 쇼핑몰명을 표기 <a href="/admin/setting/multi_basic?no=1" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>		
	</table>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>

<div id="replace_code_goods_view" class="replace_code hide">
	<table class="table_basic v7" >
		<col width="20%" /><col />
		<tr>
			<th>치환코드</th>
			<th>설명</th>
		</tr>
		<tr>
			<td>{<?php echo "쇼핑몰명"?>}</td>
			<td>상점 정보 : 쇼핑몰명을 표기 <a href="/admin/setting/multi_basic?no=1" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "상품명"?>}</td>
			<td>일반/패키지/티켓 상품 조회 > 상세 : 상품명을 표기 <a href="/admin/goods/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "간략설명"?>}</td>
			<td>일반/패키지/티켓 상품 조회 > 상세 : 간략 설명을 표기 <a href="/admin/goods/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "브랜드명"?>}</td>
			<td>일반/패키지/티켓 상품 조회 > 상세 : 브랜드를 표기 <a href="/admin/goods/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "카테고리명"?>}</td>
			<td>일반/패키지/티켓 상품 조회 > 상세 : 카테고리를 표기 <a href="/admin/goods/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "검색어"?>}</td>
			<td>일반/패키지/티켓 상품 조회 > 상세 : 검색어를 표기 <a href="/admin/goods/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>
	</table>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>

<div id="replace_code_category" class="replace_code hide">
	<table class="table_basic">
		<col width="30%" /><col width="70%" />
		<tr>
			<th>치환코드</th>
			<th>설명</th>
		</tr>
		<tr>
			<td>{<?php echo "쇼핑몰명"?>}</td>
			<td>상점 정보 : 쇼핑몰명을 표기 <a href="/admin/setting/multi_basic?no=1" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "카테고리명"?>}</td>
			<td>카테고리 : 카테고리명 표기 <a href="/admin/category/catalog" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>	
	</table>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>

<div id="replace_code_brand"  class="replace_code hide">
	<table class="table_basic">
		<col width="30%" /><col width="70%" />
		<tr>
			<th>치환코드</th>
			<th>설명</th>
		</tr>
		<tr>
			<td>{<?php echo "쇼핑몰명"?>}</td>
			<td>상점 정보 : 쇼핑몰명을 표기 <a href="/admin/setting/multi_basic?no=1" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>
		
		<tr>
			<td>{<?php echo "브랜드명"?>}</td>
			<td>브랜드 : 브랜드명 표기 <a href="/admin/brand/catalog" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>

		<tr>
			<td>{<?php echo "브랜드영문명"?>}</td>
			<td>브랜드 : 브랜드 영문명 표기 <a href="/admin/brand/catalog" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>	
	</table>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>

<div id="replace_code_location" class="replace_code hide">
	<table class="table_basic">
		<col width="30%" /><col width="70%" />
		<tr>
			<th>치환코드</th>
			<th>설명</th>
		</tr>
		<tr>
			<td>{<?php echo "쇼핑몰명"?>}</td>
			<td>상점 정보 : 쇼핑몰명을 표기 <a href="/admin/setting/multi_basic?no=1" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>	
		<tr>
			<td>{<?php echo "지역"?>}</td>
			<td>지역 : 지역명을 표기 <a href="/admin/location/catalog" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>	
	</table>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>

<div id="replace_code_board" class="replace_code hide">
	<table class="table_basic">
		<col width="30%" /><col width="70%" />
		<tr>
			<th>치환코드</th>
			<th>설명</th>
		</tr>
		<tr>
			<td>{<?php echo "쇼핑몰명"?>}</td>
			<td>상점 정보 : 쇼핑몰명을 표기 <a href="/admin/setting/multi_basic?no=1" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>	
		<tr>
			<td>{<?php echo "게시판"?>}</td>
			<td>게시판 리스트 > 수정: 게시판명을 표기 <a href="/admin/board/main" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>	
		<tr>
			<td>{<?php echo "게시글제목"?>}</td>
			<td>게시물의 제목이 표기</td>
		</tr>	
	</table>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>

<div id="replace_code_event" class="replace_code hide">
	<table class="table_basic">
		<col width="30%" /><col width="70%" />
		<tr>
			<th>치환코드</th>
			<th>설명</th>
		</tr>
		<tr>
			<td>{<?php echo "쇼핑몰명"?>}</td>
			<td>상점 정보 : 쇼핑몰명을 표기 <a href="/admin/setting/multi_basic?no=1" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "이벤트"?>}</td>
			<td>할인, 사은품 이벤트> 상세: 이벤트명을 표기 <a href="/admin/event/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>
	</table>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>

<div id="replace_code_prod_alt" class="hide">
	<table class="table_basic">
		<col width="30%" /><col width="70%" />
		<tr>
			<th>치환코드</th>
			<th>설명</th>
		</tr>
		<tr>
			<td>{<?php echo "쇼핑몰명"?>}</td>
			<td>상점 정보 : 쇼핑몰명을 표기 <a href="/admin/setting/multi_basic?no=1" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "상품명"?>}</td>
			<td>일반/패키지/티켓 상품 조회 > 상세 : 상품명을 표기 <a href="/admin/goods/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "간략설명"?>}</td>
			<td>일반/패키지/티켓 상품 조회 > 상세: 간략 설명을 표기 <a href="/admin/goods/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>		
	</table>

	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>

<div id="replace_code_broadcast" class="replace_code hide">
	<table class="table_basic" >
		<col width="30%" /><col width="70%" />
		<tr>
			<th>치환코드</th>
			<th>설명</th>
		</tr>
		<tr>
			<td>{<?php echo "쇼핑몰명"?>}</td>
			<td>상점 정보 : 쇼핑몰명을 표기 <a href="/admin/setting/multi_basic?no=1" class="link_blue_01 ml20" target="_blank">설정 보기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "방송제목"?>}</td>
			<td>라이브 예약 관리 > 상세 : 방송 제목 <a href="/admin/broadcast/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>		
		<tr>
			<td>{<?php echo "상품명"?>}</td>
			<td>라이브 예약 관리 > 상세 : 상품 정보 중 대표 상품명 <a href="/admin/broadcast/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "방송설명"?>}</td>
			<td>라이브 예약 관리 > 상세 : 방송 설명 <a href="/admin/broadcast/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "방송일"?>}</td>
			<td>라이브 예약 관리 > 상세 : 방송일 <a href="/admin/broadcast/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>
		<tr>
			<td>{<?php echo "방송입점사"?>}</td>
			<td>라이브 예약 관리 > 상세 : 신청 입점사 명 <a href="/admin/broadcast/catalog" class="link_blue_01 ml20" target="_blank">리스트 바로가기></a></td>
		</tr>
	</table>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>

<div id="robots_view_pop" class="hide">
	<div style="font-weight: bold;padding-bottom:20px;">현재 설정된 검색엔진의 정보수집을 제어하는 <b>robots.txt</b>파일 내용입니다.</div>
	<div style="background:#efefef;padding:10px;min-height:260px;" id="robots_content_view"></div>
</div>

<div id="sitemap_view_pop" class="hide">
	<div style="font-weight: bold;padding-bottom:20px;">현재 설정된 검색엔진의 사이트맵 정보수집 파일 <b>sitemap.xml</b>파일 내용입니다.</div>
	<div style="background:#efefef;padding:10px;min-height:260px;" id="sitemap_content_view"></div>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>