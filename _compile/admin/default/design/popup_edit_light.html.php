<?php /* Template_ 2.2.6 2022/05/17 12:31:37 /www/music_brother_firstmall_kr/admin/skin/default/design/popup_edit_light.html 000032956 */ 
$TPL_popup_styles_1=empty($TPL_VAR["popup_styles"])||!is_array($TPL_VAR["popup_styles"])?0:count($TPL_VAR["popup_styles"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/slick/slick.css">
<script type="text/javascript" src="/app/javascript/plugin/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-font-decoration.js"></script>
<script src="/app/javascript/plugin/slick/slick.min.js?v=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript">
	var useWebftpFormItem = true;
	var now_style = null;
	var uploadify_idx = 0;
	var design_working_skin = "<?php echo $TPL_VAR["designWorkingSkin"]?>";
	var banner_setting_load_ing = false;
	var slide_banner_opened = false;
	var contents_type_db = '<?php echo $TPL_VAR["data"]["contents_type"]?>';
	var slide_is_sample	= false;

	$(document).ready(function(){
<?php if($TPL_VAR["template_path"]&&$TPL_VAR["popup_seq"]){?>
		parent.DM_window_title_set("left","<a href=\"javascript:;\" onmouseup=\"DM_window_sourceeditor('<?php echo $TPL_VAR["template_path"]?>','\{=showDesignPopup(<?php echo $TPL_VAR["popup_seq"]?>)\}')\">◀ 팝업 영역의 HTML소스보기</a>");
<?php }?>
		parent.DM_window_title_set("center","<?php echo $TPL_VAR["layout_config"]["tpl_desc"]?>(<?php echo $TPL_VAR["layout_config"]["tpl_path"]?>)에 선택한 ");

		$("input[name='status']").change(function(){
			if($("input[name='status'][value='period']").is(":checked")){
				$("#period_span").show();
			}else{
				$("#period_span").hide();
			}
		}).change();

		$("input[name='style']").change(function(){
			if($(this).is(":checked")){
				var val = $(this).val();
				$('.style_basic').show();
				$('.contents_type_image').show();
				if(val == 'band'){
					$(".location_division, .title_division").hide();
					$(".contents_type_band_division").show();
					$(".band_location_division").show();
					$(".type_label").html("내용");

					$(".contents_type_text_division").hide();
					$(".contents_style_division").hide();

					if($("input[name='contents_type']:checked").val()=='text'){
						$("input[name='contents_type'][value='image']").attr('checked',true).change();
					}
				}else{
					$(".location_division, .title_division").show();
					$(".contents_type_band_division").hide();
					$(".band_location_division").hide();
					$(".type_label").html("이미지");

					$(".contents_type_text_division").show();
					$(".contents_style_division").show();
				}
			}
		}).change();

		setTimepicker();

		/* 컬러피커 */
		$(".colorpicker").customColorPicker({'hide':false});

		/* 슬라이드 관련 */
		// 이미지 입력폼 추가 이벤트
		$(".banner-item-plus").live('click',function(){
			banner_item_add();
			sample_view();
		});

		// 이미지 입력폼 삭제 이벤트
		$(".banner-item-minus").live('click',function(){
			if($(".banner-item-minus").length < 2){
				alert('최소 한개이상의 이미지 등록이 필요합니다.');
				return false;
			}
			var i = $(".banner-item-row").index($(this).closest(".banner-item-row"));
			$(this).closest(".banner-item-row").remove();
			$(".banner-navigation-item-row").eq(i).remove();
			$(".banner-item-row-num").each(function(i){$(this).html(i+1)});
			$(".banner-navigation-item-row-num").each(function(i){$(this).html(i+1)});
			sample_view();
		});

		// 네비게이션 선택창 세팅
		$('#navigation_btn_dialog').dialog({'title':'좌우 네비게이션 선택','width':450,'autoOpen':false});
		$('#navigation_paging_dialog').dialog({'title':'아래 네비게이션 선택','width':450,'autoOpen':false});
		$("#navigation_btn_dialog").closest(".ui-dialog").appendTo($("form[name='bannerManagerForm']"));
		$("#navigation_paging_dialog").closest(".ui-dialog").appendTo($("form[name='bannerManagerForm']"));

		// 적용
		$("form[name='bannerManagerForm']").live('change',function(){
			if(!banner_setting_load_ing){
				sample_view();
			}
		});

		$('.image_sort table tbody').sortable({stop : sample_view});
		$("select[name='contents_type']").change(content_style_chg).val('<?php echo $TPL_VAR["data"]["contents_type"]?>').change();

		// 파일 ajax 업로드 :: 2018-12-14 lwh
		var opt				= {};
		var callback_img	= function(res){
			var that	= this;
			var result	= eval(res);
			if(result.status){
				var $img_wrap = $('#image-preview-wrap').clone();
				$img_wrap.removeClass('hide');
				$img_wrap.addClass('image-preview-wrap');
				$img_wrap.find('.preview-img img').attr('src', result.filePath + result.fileInfo.file_name);
				$img_wrap.find('.preview-img a').attr('href', result.filePath + result.fileInfo.file_name);
				$img_wrap.find('.preview-path span').text(result.filePath + result.fileInfo.file_name);
				$img_wrap.find('.preview-del').click(function(){
					$(this).closest('.image-preview-wrap').remove();
					$(that).val('');
					$(that).closest('.webftpFormItem').find('.real_path').val('');
				});
				
				$(that).closest('.webftpFormItem').find('.webftpFormItemInput').attr('issample', 'n');
				$(that).closest('.webftpFormItem').find('.preview_image').html($img_wrap);
				$(that).closest('.webftpFormItem').find('.real_path').val(result.filePath + result.fileInfo.file_name);
			}else{ // 업로드 실패
				alert('[' + result.desc + '] ' + result.msg);
				return false;
			}
		};
		$('.ajaxImageFormInput').createAjaxFileUpload(opt, callback_img);
		$('.ajaxImagebackFormInput').createAjaxFileUpload(opt, callback_img);
	});

	var content_style_chg = function(){
		style = $(this).val();
		now_style = $("input[name='style']:checked").val();

		$('.contents_type_layer').hide();
		if(now_style == 'band'){
			txt = '이미지';
			$('.type_label').html('이미지');
			$('.contents_type_'+now_style+'_division').show();
		}else if(style == 'image'){
			txt = '이미지';
			$('.contents_type_'+style+'_division').show();
			$('.type_label').html('이미지');

			var that		= $('.contents_type_'+style+'_division');
			var imgFile		= '<?php echo $TPL_VAR["data"]["image"]?>';
			if(imgFile){
				// imgFile http 로 시작하지 않는 경우 /data/popup/ 붙이기
				if(imgFile.indexOf('http://') === -1 && imgFile.indexOf('https://') === -1) {
					imgFile = '/data/popup/'+ imgFile;
				}
				var $img_wrap	= $('#image-preview-wrap').clone();
				$img_wrap.removeClass('hide');
				$img_wrap.addClass('image-preview-wrap');
				$img_wrap.find('.preview-img img').attr('src', imgFile);
				$img_wrap.find('.preview-img a').attr('href', imgFile);
				$img_wrap.find('.preview-path span').text(imgFile);
				$img_wrap.find('.preview-del').click(function(){
					$(this).closest('.image-preview-wrap').remove();
					$(that).val('');
					$(that).closest('.webftpFormItem').find('.real_path').val('');
				});
				
				$(that).find('.webftpFormItemInput').attr('issample', 'n');
				$(that).find('.preview_image').html($img_wrap);
				$(that).find('.real_path').val(imgFile);
			}

		}else if(style == 'text'){
			txt = '에디터';
			$('.contents_type_'+style+'_division').show();
			$('.type_label').html('에디터');
		}else{
			// 스타일 변경
			$(".contents_type_slide_division").show();
			$('.type_label').html('슬라이드');
			txt = '슬라이드 기능으';

			reset_slick();

<?php if($TPL_VAR["data"]["popup_banner_seq"]){?>
			banner_setting_load(false,'<?php echo $TPL_VAR["data"]["popup_banner_seq"]?>');
			slide_banner_opened = true;
<?php }else{?>
			banner_setting_load(true,style);
<?php }?>
		}

		$('.style_txt').text('팝업을 '+txt+'로 만드세요');
	};

	/*슬라이드 관련*/
	// 배너 설정 로딩 ajax
	function banner_setting_load(is_sample,val){
		banner_setting_load_ing = true;
		if(is_sample){
			slide_is_sample = is_sample;
			var data = {'style':val};
		}else{
			var data = {'banner_seq':val};
		}
		that = $(".style_slide");
		$.ajax({
			'url' : 'popup_banner_setting_load',
			'data' : data,
			'dataType' : 'json',
			'success' : function(res){
				if(res){

					now_style = res.style;

					$("input[name='platform']").val(res.platform);
					if(is_sample)	$("select[name='contents_type']").val(res.style);

					$("input[name='height']",that).val(res.height);
					$("input[name='image_width']").val(res.image_width);
					$("input[name='image_height']").val(res.image_height);
					$(".banner-item-row-wrap").empty();
					$(".navigation_paging_style_custom").empty();
					if(res.images && res.images.length>0){
						for(var i=0;i<res.images.length;i++){
							banner_item_add();
							var obj = $(".banner-item-row").last();
							obj.find("input[name='s_link[]']").val(res.images[i].link);
							obj.find("select[name='s_target[]']").val(res.images[i].target);
							obj.find("input[name='s_image[]']").val(res.images[i].image);
							obj.find("input[name='tab_title[]']").val(res.images[i].tab_title);
							if(is_sample){
								obj.find("img.webftpFormItemPreview").attr("src",res.images[i].image).show();
							}else{
								obj.find('.webftpFormItemInput').attr('issample', 'n');
								obj.find("img.webftpFormItemPreview").attr("src",res.images[i].image+"?"+Math.floor(Math.random()*1000000000)).show();
							}

							if(res.images[i].image_width && res.images[i].image_height){
								obj.find(".webftpFormItemPreviewSize").html(res.images[i].image_width+" x "+res.images[i].image_height);
							}
						}
					}else{
						banner_item_add();
					}
				}
				banner_setting_load_ing = false;
				sample_view();
			}
		});
	}

	// 이미지 추가 버튼
	function banner_item_add(){
		$(".banner-item-row-wrap").append(banner_item_html());
		var new_id = 'banner_item_image_'+(uploadify_idx++);
		$(".banner-item-row").last().find("input.upload_btn").attr('id',new_id);
		
		$(".banner-item-plus:gt(0)").hide();
		$(".banner-item-minus:gt(0)").show();

		setDefaultText();
		banner_upload_event();
		$(".banner-item-row-num").each(function(i){$(this).html(i+1)});
	}

	// 슬라이드 이미지 추가 후 이벤트 설정
	function banner_upload_event(){
		var opt			= {};
		var callback	= function(res){
			var that		= this;
			var img_width	= $("#image_width").val();
			var img_height	= $("#image_height").val();
			var total_cnt	= $(".webftpFormItemPreview").length;

			var result	= eval(res);
			if(result.status){
				if((result.fileInfo.image_width == img_width && result.fileInfo.image_height == img_height) || (!img_width && !img_height) || (total_cnt == 1) || slide_is_sample){
					$(that).closest('.webftpFormItem').find('.webftpFormItemPreview').attr('src', result.filePath + result.fileInfo.file_name).show();
					$(that).closest('.webftpFormItem').find('.webftpFormItemInput').val(result.filePath + result.fileInfo.file_name);
					$(that).closest('.webftpFormItem').find('.webftpFormItemInput').attr('issample', 'n');
					$(that).closest('.webftpFormItem').find('.webftpFormItemPreviewSize').text(result.fileInfo.image_width + ' x ' + result.fileInfo.image_height);

					$("#image_width").val(result.fileInfo.image_width);
					$("#image_height").val(result.fileInfo.image_height);
					sample_view();
				}else{
					alert('동일한 사이즈의 이미지만 등록 가능합니다. (' + img_width + ' x ' + img_height + ')');
				}
			}else{ // 업로드 실패
				alert('[' + result.desc + '] ' + result.msg);
				return false;
			}
		};

		$('.ajaxSliderImage').each(function(){
			$(this).createAjaxFileUpload(opt, callback);
		});
	}

	// 이미지 등록 버튼
	function image_insert(obj, type){
		$(obj).closest('.webftpFormItem').find('.' + type).click();
	}

	// 이미지 추가 HTML
	function banner_item_html(){
		var html = '';
		html += '<tr class="banner-item-row">';
		html += '	<th class="dsts-th">';
		html += '	<img src="/admin/skin/default/images/common/icon_move.gif">';
		html += '	이미지 (<span class="banner-item-row-num"></span>)';
		html += '	</th>';
		html += '	<td class="dsts-td left webftpFormItem">';
		html += '		<input type="text" class="line" name="tab_title[]" title="탭명 입력" value="" onchange="sample_view();" />';
		html += '		<select name="s_target[]">';
		html += '			<option value="_self">현재창</option>';
		html += '			<option value="_blank">새창</option>';
		html += '		</select>';
		html += '		<input type="text" name="s_link[]" value="" size="30" maxlength="200" title="링크주소" />';

		html += '		<img src="" class="webftpFormItemPreview hide hand" style="width:20px;height:20px;" onclick="window.open(this.src)">';
		html += '		<input type="hidden" class="webftpFormItemInput" issample="y" name="s_image[]" value="" size="30" maxlength="200" />';
		html += '		<span class="btn small lightblue"><button type="button" class="btnSliderUpload" onclick="image_insert(this,\'ajaxSliderImage\');">이미지 등록</button></span>';
		html += '		<input type="file" name="tmp_image" value="" class="ajaxSliderImage hide" />';
		html += '		<span class="orange">등록 이미지 (<span class="webftpFormItemPreviewSize"></span>)</span>';

		html += '		<div class="fr">';
		html += '			<span class="banner-item-plus"><img src="/admin/skin/default/images/design/icon_design_plus.gif" /></span>';
		html += '			<span class="banner-item-minus"><img src="/admin/skin/default/images/design/icon_design_minus.gif" /></span>';
		html += '		</div>';
		html += '	</td>';
		html += '</tr>';
		return html;
	}

	// slick 초기화
	function reset_slick(){
		$('#popup_slider_1').slick('unslick');
		$('#popup_slider_1').empty();
		$('#pop_tab_1').slick('unslick');
		$('#pop_tab_1').empty();
		$('#popup_slider_1').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			fade: true,
			arrows: false,
			asNavFor: '#pop_tab_1'
		});
		$('#pop_tab_1').slick({
			slidesToShow: 3,
			responsive: [{
				breakpoint: 480,
				settings: {
					slidesToShow: 2
				}
			}],
			slidesToScroll: 1,
			asNavFor: '#popup_slider_1',
			dots: false,
			speed: 600,
			centerMode: true,
			centerPadding: '10px',
			arrows: true,
			focusOnSelect: true
		});
	}

	// 미리보기 화면 설정
	function sample_view(){
		var tmp_html_1 = tmp_html_2 = '';
		var link = img = target = tab_title = '';
		reset_slick(); // slick 초기화

		$('.webftpFormItemInput').each(function(idx){
			if($(this).val()){
				var img_path = '';
				img			= $(this).val() + "?<?php echo date('YmdHis')?>";
				target		= $("select[name='s_target[]']").eq(idx).val();
				link		= $("input[name='s_link[]']").eq(idx).val();
				tab_title	= $("input[name='tab_title[]']").eq(idx).val();

				tmp_html_1	= '<div class="sslide"><a class="slink" href="' + link + '" target="' + target + '"><img class="simg" src="' + img + '" alt="' + tab_title + '" /></a></div>';
				tmp_html_2	= '<div class="sslide"><a class="hand">' + tab_title + '</a></div>';

				$('#popup_slider_1').slick('slickAdd',tmp_html_1);
				$('#pop_tab_1').slick('slickAdd',tmp_html_2);
			}
		});
	}

	function image_popup(division,selector,e){
		idx = $(e).closest('table').index()+'_'+$(e).closest('tr').index();
		window.open('image_upload?division='+division+'&selector='+selector+'&idx='+idx,'image_popup','width=500,height=250');
	}

	function default_img(obj){
		idx = obj.idx.split('_');
		that = $('.'+obj.selector).find('table').eq(idx[0]).find('tr').eq(idx[1]);

		if(obj.division == 'slide_img'){
			that.find('.webftpFormItemPreview').prop('src','/'+obj.tmpFile).show();
			that.find('.webftpFormItemInput').val(obj.tmpFile);
			that.find('.webftpFormItemPreviewSize').text(obj.width+' x '+obj.height);
		}else{
			that.find('.webftpFormItemPreview').prop('src','/'+obj.tmpFile).show();
			that.find('.webftpFormItemInput').val(obj.tmpFile);
		}
		sample_view();
	}

	function save_popup(){
		$("input[name='removeDesignPopupArea']").val();
		if($('#removeDesignPopupArea').is(':checked')) $("input[name='removeDesignPopupArea']").val('Y');

		if($("input[name='admin_comment']").val() == ''){
			openDialogAlert('관리용 코멘트는 필수입력 사항입니다.','400','160',function(){});
		}else{
			contents_type = $("select[name='contents_type']").val();
			style = $("input[name='style']").val();

			if(contents_type == 'slider' && style == 'layer'){
				if($('.webftpFormItemInput[issample="y"]').length > 0){
					openDialogAlert('현재 등록된 이미지에 샘플이미지가 포함되어있습니다.<br/>새로운 이미지를 등록해주세요.','400','180',function(){ $(".banner-item-plus").eq(0).focus(); });
					return false;
				}
				if($(".banner-item-row-num").length<2){
					openDialogAlert("이미지를 최소 2개 이상 등록하셔야합니다.",400,140,function(){
						$(".banner-item-plus").trigger('click');
					});
					return false;
				}
			}

			submitEditorForm(document.popupManagerForm);
		}
	}
</script>
<style type="text/css">	
	.design-simple-table-style td.left.dsts-td{padding-right:10px;}
	.banner-item-row th{cursor:move}
	.contents_style_division .design-simple-table-style th,.contents_style_division .design-simple-table-style td{border-bottom:0px !important;}
	.style_basic_wrap{padding:15px;padding-bottom:0px;}
	.style_basic_wrap .item-title:first-child {margin-top:0;}
	.style_slide{margin-left:10px;margin-right:10px;padding-top:10px;border-top:1px solid #d3d3d3}
	.preview_image {/*width: 400px;*/}
	.banner-item-plus  {cursor:pointer;}
	.banner-item-minus {cursor:pointer;display:none;}	
</style>

<div class="style_basic_wrap">
	<form name="popupManagerForm" action="../design_process/popup_edit_light" method="post" target="actionFrame">
		<input type="hidden" name="template_path" value="<?php echo $TPL_VAR["template_path"]?>" />
		<input type="hidden" name="popup_seq" value="<?php echo $TPL_VAR["popup_seq"]?>" />
		<input type="hidden" name="popup_banner_seq" value="<?php echo $TPL_VAR["data"]["popup_banner_seq"]?>" />
		<input type="hidden" name="direct" value="<?php echo $_GET["direct"]?>" />
		<input type="hidden" name="view" value="<?php echo $TPL_VAR["data"]["popup_condition"]["view"]?>"/>
		<input type="hidden" name="removeDesignPopupArea" />

		<!-- 기본정보 :: START -->
		<div class="item-title" style="margin-top:0;">기본 정보</div>
		<table class="design-simple-table-style" width="100%">
			<col width="120"/>
			<col width="*"/>
			<col width="120"/>
			<col width="300"/>
			<tr>
				<th class="dsts-th">선택</th>
				<td class="dsts-td left"><?php echo $TPL_VAR["popup_styles"][$TPL_VAR["data"]["style"]]?></td>
				<th class="dsts-th">관리 타이틀</th>
				<td class="dsts-td left">
					<input type="hidden" id="title" name="title" value="<?php echo $TPL_VAR["data"]["title"]?>" class="line"/>
					<input type="text" name="admin_comment" value="<?php echo $TPL_VAR["data"]["admin_comment"]?>" class="line" size="30" onchange="$('#title').val($(this).val());" />
				</td>
			</tr>
			<tr>
				<th class="dsts-th">노출 위치</th>
				<td class="dsts-td left">
					<div class="band_location_division">최상단에 위치하는 배너</div>

					<div class="location_division">
						<span>
						화면상단으로부터 <input type="text" name="loc_top" value="<?php if($TPL_VAR["data"]["loc_top"]){?><?php echo $TPL_VAR["data"]["loc_top"]?><?php }else{?>0<?php }?>" class="line" size="4" maxlength="4" /> px
						</span>
						<span class="pdl30">
						화면좌측으로부터 <input type="text" name="loc_left" value="<?php if($TPL_VAR["data"]["loc_left"]){?><?php echo $TPL_VAR["data"]["loc_left"]?><?php }else{?>0<?php }?>" class="line" size="4" maxlength="4" /> px
						</span>
						<div class="pdt5 desc">단, 팝업 위치는 태블릿 이하의 스크린에서는 자동 설정됩니다.</div>
					</div>
				</td>
				<th class="dsts-th">상태</th>
				<td class="dsts-td left">
<?php if($TPL_popup_styles_1){foreach($TPL_VAR["popup_styles"] as $TPL_K1=>$TPL_V1){?>
					<input type="radio" class="hide" name="style" value="<?php echo $TPL_K1?>" <?php if($TPL_VAR["data"]["style"]==$TPL_K1){?>checked<?php }?> />
<?php }}?>
<?php if(!$TPL_VAR["data"]["style"]){?>
					<script>$("input[name='style']").eq(0).attr('checked',true);</script>
<?php }?>

					<label class="mr10"><input type="radio" name="status" value="show" <?php if($TPL_VAR["data"]["status"]=='show'||!$TPL_VAR["data"]["status"]=='show'){?>checked<?php }?> /> 노출</label>
					<label class="mr10"><input type="radio" name="status" value="period" <?php if($TPL_VAR["data"]["status"]=='period'){?>checked<?php }?> /> 기간 노출</label>
					<label><input type="radio" name="status" value="stop" <?php if($TPL_VAR["data"]["status"]=='stop'){?>checked<?php }?> /> 미노출</label>
					<div class="pdt5" id="period_span">
						<input type="text" name="period_s" value="<?php if($TPL_VAR["data"]["period_s"]){?><?php echo $TPL_VAR["data"]["period_s"]?><?php }else{?><?php echo date('Y-m-01 00:00:00')?><?php }?>" class="line datetimepicker" size="15" maxlength="19" /> ~
						<input type="text" name="period_e" value="<?php if($TPL_VAR["data"]["period_e"]){?><?php echo $TPL_VAR["data"]["period_e"]?><?php }else{?><?php echo date('Y-m-t 00:00:00')?><?php }?>" class="line datetimepicker" size="15" maxlength="19" />
					</div>
				</td>
			</tr>
		</table>
		<!-- 기본정보 :: END -->

		<!-- 본문 :: START -->
		<div class="item-title">본문</div>
		<div class="contents_style_division" style="margin-top:10px;">
			<table class="design-simple-table-style" width="100%">
				<col width="120"/>
				<col />
				<tr>
					<th class="dsts-th">스타일</th>
					<td class="dsts-td left">
						<select name="contents_type">
							<option value="image">Light Image Popup</option>
							<option value="text">Light Editor Popup</option>
							<option value="slider">Light Slider Popup</option>
						</select>
<?php if($TPL_VAR["data"]["contents_type"]){?>
						<script>$("select[name='contents_type']").val('<?php echo $TPL_VAR["data"]["contents_type"]?>').change();</script>
<?php }?>
						<span class="desc style_txt">팝업을 이미지로 만드세요</span>
					</td>
				</tr>
			</table>
		</div>

		<div class="style_basic">
			<table class="design-simple-table-style" width="100%">
				<col width="120"/>
				<col />
				<tr>
					<th class="dsts-th"><span class="type_label">내용</span></th>
					<td class="dsts-td left" style="padding:0 5px;">
						<!-- 이미지 부분 -->
						<div class="contents_type_layer contents_type_image_division contents_type_band_division">
							<div class="contents_type_image pd10">
								<div class="pdb5">
									<input type="text" name="link" value="<?php echo $TPL_VAR["data"]["link"]?>" class="line" size="70" maxlength="200" title="링크 주소" />
									<span><label><input type="checkbox" name="open" value="1" <?php if($TPL_VAR["data"]["open"]== 1){?>checked<?php }?>/> 새창</label></span>
								</div>
								<div class="webftpFormItem" >
									<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td>
											<input type="file" value="" class="ajaxImageFormInput hide" />
											<input type="hidden" class="real_path" name="newImgPath" value="" />
											<span class="btn small lightblue"><button class="btnSliderUpload" onclick="image_insert(this,'ajaxImageFormInput');">이미지 등록</button></span>
											<span class="contents_type_layer contents_type_band_division">권장 사이즈 : 가로 720px 이하</span>
											<div class="preview_image"></div>
										</td>
									</tr>
									</table>
								</div>
							</div>
						</div>
						<!-- 에디터 부분 -->
						<div class="contents_type_layer contents_type_text_division pdt10">
							<div class="contents_type_text pd10">
								<div class="pdb5">
									가로최대크기 <input type="text" name="width" value="<?php if($TPL_VAR["data"]["width"]){?><?php echo $TPL_VAR["data"]["width"]?><?php }else{?>0<?php }?>" class="line" size="4" maxlength="4" />px&nbsp;&nbsp;&nbsp;
									세로크기 <input type="text" name="height" value="<?php if($TPL_VAR["data"]["height"]){?><?php echo $TPL_VAR["data"]["height"]?><?php }else{?>0<?php }?>" class="line" size="4" maxlength="4" />px
								</div>
								<textarea name="contents" contentHeight="370px" class="daumeditor"><?php echo $TPL_VAR["data"]["contents"]?></textarea>
							</div>
						</div>
						<!-- 슬라이드 부분 -->
						<div class="contents_type_layer contents_type_slide_division image_sort pdt10">
							<input type="hidden" name="image_width" id="image_width" value="" size="3" maxlength="4" class="onlynumber" />
							<input type="hidden" name="image_height" id="image_height" value="" size="3" maxlength="4" class="onlynumber" />
							<table width="100%" align="center" class="design-simple-table-style">
								<col width="120" />
								<tbody class="banner-item-row-wrap">
								</tbody>
							</table>
						</div>
					</td>
				</tr>
				<tr class="contents_type_layer contents_type_band_division hide">
					<th class="dsts-th">배경</th>
					<td class="dsts-td left">
						<div>
							<label class="mr10"><input type="radio" name="band_background_type" value="color" <?php if($TPL_VAR["data"]["band_background_color"]||!$TPL_VAR["data"]["band_background_color"]){?>checked<?php }?> /> 색상</label> <input type="text" name="band_background_color" value="<?php if($TPL_VAR["data"]["band_background_color"]){?><?php echo $TPL_VAR["data"]["band_background_color"]?><?php }else{?>#ffeef7<?php }?>" size="7" maxlength="20" class="line colorpicker" />
						</div>
						<div class="mt5">
							<label>
							<input type="radio" name="band_background_type" value="image" <?php if($TPL_VAR["data"]["band_background_image"]){?>checked<?php }?> /> 이미지</label>
							<span class="band_background_imageLabel">
								<select name="band_background_image_repeat">
									<option value="repeat" <?php if($TPL_VAR["data"]["band_background_image_repeat"]=='repeat'){?>selected="selected"<?php }?>>바둑판</option>
									<option value="repeat-x" <?php if($TPL_VAR["data"]["band_background_image_repeat"]=='repeat-x'){?>selected="selected"<?php }?>>수평반복</option>
									<option value="repeat-y" <?php if($TPL_VAR["data"]["band_background_image_repeat"]=='repeat-y'){?>selected="selected"<?php }?>>수직반복</option>
									<option value="no-repeat" <?php if($TPL_VAR["data"]["band_background_image_repeat"]=='no-repeat'){?>selected="selected"<?php }?>>원본 그대로</option>
								</select>
								<select name="band_background_image_position">
									<option value="left top" <?php if($TPL_VAR["data"]["band_background_image_position"]=='left top'){?>selected="selected"<?php }?>>좌측상단</option>
									<option value="left center" <?php if($TPL_VAR["data"]["band_background_image_position"]=='left center'){?>selected="selected"<?php }?>>좌측중단</option>
									<option value="left bottom" <?php if($TPL_VAR["data"]["band_background_image_position"]=='left bottom'){?>selected="selected"<?php }?>>좌측하단</option>
									<option value="center top" <?php if($TPL_VAR["data"]["band_background_image_position"]=='center top'){?>selected="selected"<?php }?>>중앙상단</option>
									<option value="center center" <?php if($TPL_VAR["data"]["band_background_image_position"]=='center center'){?>selected="selected"<?php }?>>중앙중단</option>
									<option value="center bottom" <?php if($TPL_VAR["data"]["band_background_image_position"]=='center bottom'){?>selected="selected"<?php }?>>중앙하단</option>
									<option value="right top" <?php if($TPL_VAR["data"]["band_background_image_position"]=='right top'){?>selected="selected"<?php }?>>우측상단</option>
									<option value="right center" <?php if($TPL_VAR["data"]["band_background_image_position"]=='right center'){?>selected="selected"<?php }?>>우측중단</option>
									<option value="right bottom" <?php if($TPL_VAR["data"]["band_background_image_position"]=='right bottom'){?>selected="selected"<?php }?>>우측하단</option>
								</select>

								<span class="webftpFormItem" >
									<input type="file" value="" class="ajaxImagebackFormInput hide" />
									<input type="hidden" class="real_path" name="new_band_background_image" value="" />
									<span class="btn small lightblue"><button class="btnSliderUpload" onclick="image_insert(this,'ajaxImagebackFormInput');">이미지 등록</button></span>
									<div class="preview_image"></div>
								</span>
							</span>
						</div>
					</td>
				</tr>
				<tr class="contents_type_layer contents_type_slide_division hide">
					<th class="dsts-th">미리보기</th>
					<td class="dsts-td left">
						<div class="designPopup popup_slider sliderC" style="position:static; max-width:410px;">
							<div id="popup_slider_1" class="popup_slider_view">
							</div>
							<div class="popup_slider_tab">
								<div id="pop_tab_1" class="pop_tab_list">
								</div>
							</div>
						</div>
						<script type="text/javascript">
						$('#popup_slider_1').slick({
							slidesToShow: 1,
							slidesToScroll: 1,
							fade: true,
							arrows: false,
							asNavFor: '#pop_tab_1'
						});
						$('#pop_tab_1').slick({
							slidesToShow: 3,
							responsive: [{
								breakpoint: 480,
								settings: {
									slidesToShow: 2
								}
							}],
							slidesToScroll: 1,
							asNavFor: '#popup_slider_1',
							dots: false,
							speed: 600,
							centerMode: true,
							centerPadding: '10px',
							arrows: true,
							focusOnSelect: true
						});
						</script>
					</td>
				</tr>
			</table>
		</div>
		<!-- 본문 :: END -->

		<!-- 닫기 영역 :: START -->
		<div class="item-title">닫기 영역</div>
		<table class="design-simple-table-style" width="100%">
			<col width="120"/>
			<col>
			<tr class="footer_division">
				<th class="dsts-th">하단</th>
				<td class="dsts-td left">
					<input type="text" name="bar_msg_today_text" value="<?php if($TPL_VAR["data"]["bar_msg_today_text"]){?><?php echo $TPL_VAR["data"]["bar_msg_today_text"]?><?php }else{?>오늘 하루 이 창을 열지 않음<?php }?>" size="30" maxlength="30" />
					<input type="text" name="bar_msg_close_text" value="<?php if($TPL_VAR["data"]["bar_msg_close_text"]){?><?php echo $TPL_VAR["data"]["bar_msg_close_text"]?><?php }else{?>닫기<?php }?>" size="30" maxlength="30" />
				</td>
			</tr>
		</table>
		<!-- 닫기 영역 :: END -->
	</form>
</div>

<?php if($TPL_VAR["template_path"]&&$TPL_VAR["popup_seq"]){?>
<div style="height:15px"></div>

<div class="center">
	<label><input type="checkbox" id="removeDesignPopupArea" value="Y" /> 이 페이지의 팝업 영역을 없앰 (설정 정보는 삭제되지 않음)</label>
</div>
<?php }?>
<div style="height:15px"></div>

<div class="center">
	<span class="btn large cyanblue"><input type="button" value="적용" onclick="save_popup()" /></span>
<?php if($TPL_VAR["template_path"]){?>
		<span class="btn large"><input type="button" value="목록" onclick="parent.DM_window_popup_insert('<?php echo $TPL_VAR["template_path"]?>')"/></span>
<?php }?>
</div>
<div style="height:15px"></div>

<div id="popup_condition_div"></div>
<div id="image-preview-wrap" class="hide">
	<a href="#" class="preview-del"></a>
	<input class="preview-data" type="hidden" name="image_path" value=""/>
	<div class="preview-path"><span class="txt_line" style="width:320px;display:block;"></span></div>
	<div class="preview-img"><a href="" target="_blank"><img src=""/></a></div>
</div>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>