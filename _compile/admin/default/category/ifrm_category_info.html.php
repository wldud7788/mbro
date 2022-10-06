<?php /* Template_ 2.2.6 2022/05/17 12:31:01 /www/music_brother_firstmall_kr/admin/skin/default/category/ifrm_category_info.html 000017008 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-font-decoration.js"></script>
<script type="text/javascript" src="/app/javascript/js/base64.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript">
	var categoryUrl = gl_protocol+"<?php echo $_SERVER["HTTP_HOST"]?>/goods/catalog?code=";

	$(function () {

		// 주소 복사 크로스브라우징을 위해 추가 leewh 2014-10-17
		initClipBoard();

		$(document).resize(function(){
			$('#ifrmCategorySetting',parent.document).height($('form').height()+200);
		}).resize();

		Editor.onPanelLoadComplete(function(){
			$(document).resize();
		});

		/* 파일업로드버튼 ajax upload 적용 */
		var opt			= {};
		var callback	= function(res){
			var that		= this;
			var result		= eval(res);

			if(result.status){
				$(that).closest('.webftpFormItem').find('.webftpFormItemPreview').attr('src', result.filePath + result.fileInfo.file_name);
				$(that).closest('.webftpFormItem').find('.webftpFormItemPreview').css('display', 'block');
				$(that).closest('.webftpFormItem').find('.webftpFormItemInput').val( result.filePath +result.fileInfo.file_name);
			}else{
				alert(result.msg);
			}
		};

		// ajax 이미지 업로드 이벤트 바인딩
		$('#nodeImageNormalUploadButton').createAjaxFileUpload(opt, callback);
		$('#nodeImageOverUploadButton').createAjaxFileUpload(opt, callback);
		$('#nodeCatalogImageNormalUploadButton').createAjaxFileUpload(opt, callback);
		$('#nodeCatalogImageOverUploadButton').createAjaxFileUpload(opt, callback);
		$('#nodeGnbImageNormalUploadButton').createAjaxFileUpload(opt, callback);
		$('#nodeGnbImageOverUploadButton').createAjaxFileUpload(opt, callback);


		$("input[name='node_type']").live("change",function(){
			disableNodeTypeDecoration();
		});
		$("input[name='node_catalog_type']").live("change",function(){
			disableNodeCatalogTypeDecoration();
		});
		$("input[name='node_gnb_type']").live("change",function(){
			disableNodeGnbTypeDecoration();
		});

		$.ajax({
			global:false,
			type: "POST",
			url: "view",
			data: "category=<?php echo $TPL_VAR["categoryCode"]?>",
			dataType: 'json',
			success: function(result){
				$("input[name='categoryCode']").val('<?php echo $TPL_VAR["categoryCode"]?>');
				view(result);
			}
		});

	});

	function view(result){
		var len = result.length - 1;
		var arr = new Array();
		var isGroups = false;
		for(var i=0;i<=len;i++){
			arr[i] = result[i].title;
			if(i == len){

				// 페이지 접속 기간
				var allow_type = result[i].catalog_allow != null ? result[i].catalog_allow : 'show';
				if(allow_type == 'period'){
					$("#catalog_allow_sdate").text(result[i].catalog_allow_sdate=='0000-00-00'?'':result[i].catalog_allow_sdate);
					$("#catalog_allow_edate").text(result[i].catalog_allow_edate=='0000-00-00'?'':result[i].catalog_allow_edate);
				}
				$("#catalog_allow_"+allow_type).removeClass('hide');

				// 페이지 배너
				if(!result[i].top_html){
					$('.banner_wrap').text('미사용').removeClass('hide');
				}else{
					$('#layerPageBanner').html(result[i].top_html);
					$('.banner_wrap').html('<span class="hand highlight-link" onclick=\'openDialog("페이지배너", "layerPageBanner", {"width":"800","height":"500"});\'>배너</span>').removeClass('hide');
				}

				// 카테고리 네비게이션
				if(result[i].hide == '1')	$('#navHide').text('미노출');
				else						$('#navHide').text('노출');

				// 전체 카테고리 네비게이션
				if(result[i].hide_in_gnb == '1')	$('#allNavHide').text('미노출');
				else								$('#allNavHide').text('노출');

				// 추천상품
				$('#page_recommend_desc').text('미사용');
				$.ajax({
					global:false,
					type: "POST",
					url: "recommend_view",
					data: "category=<?php echo $TPL_VAR["categoryCode"]?>",
					dataType: 'html',
					success: function(display){
						$('#page_recommend_desc').html(display);
						$(document).resize();
					}
				});

				// 검색필터
				if(result[i].use_search_filter == 'Y')  $('#use_search_filter').text(result[i].set_search_filter);
				else									$('#use_search_filter').text('미사용');

				if(result[i].groups){
					for(var j=0;j<result[i].groups.length;j++){
						$("input[type='checkbox'][name='memberGroup'][value='"+ result[i].groups[j].group_seq +"']").attr('checked',true);
					}
					isGroups = true;
				}

				if(result[i].types){
					$(result[i].types).each(function(idx, data){
						$("input[type='checkbox'][name='userType'][value='"+ data.user_type +"']").attr('checked',true);
					});
				}

				$("#goodsCnt").html(comma(result[i].goodsCnt));
				$("input[name='categoryCode']").val(result[i].category_code);
				var categoryCode = $("input[name='categoryCode']").val();
				$("#urlCategory").html(categoryUrl+categoryCode);
			}
		}
		if(!isGroups)$("input[type='checkbox'][name='memberGroup']").attr("checked",false);
		$("#categoryNavi").html(arr.join(" > "));

		$(".customFontDecoration").customFontDecoration();

		disableNodeTypeDecoration();
		disableNodeCatalogTypeDecoration();
		disableNodeGnbTypeDecoration();
	}

	function disableNodeTypeDecoration(){
		switch($("input[name='node_type']:checked").val()){
			case "text":
				$(".node_type_image .font_decoration *").attr("disabled",true);
				$(".node_type_text .font_decoration *").removeAttr("disabled");
				$(".node_type_image object, .node_type_image .btn").hide();
			break;
			case "image":
				$(".node_type_text .font_decoration *").attr("disabled",true);
				$(".node_type_image .font_decoration *").removeAttr("disabled");
				$(".node_type_image object, .node_type_image .btn").show();
			break;
			default:
				$(".node_type_image .font_decoration *").attr("disabled",true);
				$(".node_type_text .font_decoration *").attr("disabled",true);
				$(".node_type_image object, .node_type_image .btn").hide();
			break;
		}
	}

	function disableNodeCatalogTypeDecoration(){
		switch($("input[name='node_catalog_type']:checked").val()){
			case "text":
				$(".node_catalog_type_image .font_decoration *").attr("disabled",true);
				$(".node_catalog_type_text .font_decoration *").removeAttr("disabled");
				$(".node_catalog_type_image object, .node_catalog_type_image .btn").hide();
			break;
			case "image":
				$(".node_catalog_type_text .font_decoration *").attr("disabled",true);
				$(".node_catalog_type_image .font_decoration *").removeAttr("disabled");
				$(".node_catalog_type_image object, .node_catalog_type_image .btn").show();
			break;
			default:
				$(".node_catalog_type_image .font_decoration *").attr("disabled",true);
				$(".node_catalog_type_text .font_decoration *").attr("disabled",true);
				$(".node_catalog_type_image object, .node_catalog_type_image .btn").hide();
			break;
		}
	}

	function disableNodeGnbTypeDecoration(){
		switch($("input[name='node_gnb_type']:checked").val()){
			case "text":
				$(".node_gnb_type_image .font_decoration *").attr("disabled",true);
				$(".node_gnb_type_text .font_decoration *").removeAttr("disabled");
				$(".node_gnb_type_image object, .node_gnb_type_image .btn").hide();
			break;
			case "image":
				$(".node_gnb_type_text .font_decoration *").attr("disabled",true);
				$(".node_gnb_type_image .font_decoration *").removeAttr("disabled");
				$(".node_gnb_type_image object, .node_gnb_type_image .btn").show();
			break;
			default:
				$(".node_gnb_type_image .font_decoration *").attr("disabled",true);
				$(".node_gnb_type_text .font_decoration *").attr("disabled",true);
				$(".node_gnb_type_image object, .node_gnb_type_image .btn").hide();
			break;
		}
	}

	function changeNodeImage(){
		var node_image_normal = $("input[name='node_image_normal']").val();
		var node_image_over = $("input[name='node_image_over']").val();

		$("input[name='node_image_normal']").val(node_image_over);
		$("input[name='node_image_over']").val(node_image_normal);

		if(node_image_normal.substring(0,1)!='/') node_image_normal = '/' + node_image_normal;
		if(node_image_over.substring(0,1)!='/') node_image_over = '/' + node_image_over;

		$("#node_image_normal_preview").show().attr('src',node_image_over);
		$("#node_image_over_preview").show().attr('src',node_image_normal);
	}

	function changeNodeCatalogImage(){
		var node_image_normal = $("input[name='node_catalog_image_normal']").val();
		var node_image_over = $("input[name='node_catalog_image_over']").val();

		$("input[name='node_catalog_image_normal']").val(node_image_over);
		$("input[name='node_catalog_image_over']").val(node_image_normal);

		if(node_image_normal.substring(0,1)!='/') node_image_normal = '/' + node_image_normal;
		if(node_image_over.substring(0,1)!='/') node_image_over = '/' + node_image_over;

		$("#node_catalog_image_normal_preview").show().attr('src',node_image_over);
		$("#node_catalog_image_over_preview").show().attr('src',node_image_normal);
	}

	function changeNodeGnbImage(){
		var node_image_normal = $("input[name='node_gnb_image_normal']").val();
		var node_image_over = $("input[name='node_gnb_image_over']").val();

		$("input[name='node_gnb_image_normal']").val(node_image_over);
		$("input[name='node_gnb_image_over']").val(node_image_normal);

		if(node_image_normal.substring(0,1)!='/') node_image_normal = '/' + node_image_normal;
		if(node_image_over.substring(0,1)!='/') node_image_over = '/' + node_image_over;

		$("#node_gnb_image_normal_preview").show().attr('src',node_image_over);
		$("#node_gnb_image_over_preview").show().attr('src',node_image_normal);
	}

	function initClipBoard() {
		$("#clipboard").live("click",function(){
			var categoryCode = $("input[name='categoryCode']").val();
			if(categoryCode){
				var str = categoryUrl+categoryCode;
				clipboard_copy(str);
				alert('클립보드에 복사되었습니다.');
			}
		});
	}

	function popupSingleNavigation(){
		openDialog('소스', 'layerSingleNavigation', {"width":"500","height":"200"});
	}

	function copy_navigation(){
		clipboard_copy('{\=showCategoryLightNavigation("category_gnb_single", "<?php echo $TPL_VAR["categoryCode"]?>")}');
		alert("클립보드에 복사되었습니다.");
	}
</script>
<style>
	.info-table-style .its-th {padding-left:10px !important;}
</style>

<!-- 서브메뉴 바디 : 시작-->
<form name="categorySettingForm" method="post" target="actionFrame" action="../category_process/category_info">
<input type="hidden" name="categoryCode" value="" />

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td valign="top">

		<table width="100%" class="info-table-style">
		<colgroup>
			<col width="18%"/>
			<col width="*"/>
			<col width="16%"/>
			<col width="*"/>
		</colgroup>
		<thead>
			<tr>
				<th class="its-th" style="height:20px" colspan="4">
					[<strong><?php echo $TPL_VAR["categoryData"]["title"]?></strong>]
<?php if($TPL_VAR["categoryData"]["level"]=='2'&&$TPL_VAR["operation_type"]=='light'){?>
					<div class="fr right cboth"><span class="btn large cyanblue"><button type="button" onclick="popupSingleNavigation();" >단독 네비게이션</button></span></div>
<?php }?>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th class="its-th">주소</th>
				<td class="its-td">
					<span id="urlCategory"></span><span class="btn small gray"><input type="button" id="clipboard" value="복사"/></span>
				</td>
				<th class="its-th">
					상품코드용 코드
					<span class="helpicon" title="설정>상품코드에서 사용되는 해당 카테고리 코드를 입력하세요."></span>
				</th>
				<td class="its-td">
<?php if(serviceLimit('H_FR')){?>
					<span class="desc">코드값 기능은 업그레이드가 필요합니다.</span> <img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand" onclick="serviceUpgrade();" align="absmiddle" />
<?php }else{?>
					<input type="text" name="category_goods_code" value="<?php echo $TPL_VAR["categoryData"]["category_goods_code"]?>" />
<?php }?>
				</td>
			</tr>
			<tr>
				<th class="its-th">상품 수</th>
				<td class="its-td">
					<span id="goodsCnt"></span>개 (하위 카테고리 포함)
				</td>
				<th class="its-th">카테고리페이지 QR 코드</th>
				<td class="its-td">
					<a href="javascript:;" class="qrcodeGuideBtn fx11 lsp-1" target="parent" key="category" value="<?php echo $TPL_VAR["categoryCode"]?>">자세히▶</a>
				</td>
			</tr>
			<tr>
				<th class="its-th">페이지 접속제한 (접속자 허용)</th>
				<td class="its-td" colspan="3"><?php echo $TPL_VAR["access_limit_txt"]?></td>
			</tr>
			<tr>
				<th class="its-th">페이지 접속제한 (접속기간 제한)</th>
				<td class="its-td" colspan="3">
					<div id="catalog_allow_show" class="mr10 hide">없음</div>
					<div id="catalog_allow_period" class="mr10 hide">
						<span id="catalog_allow_sdate"></span> ~ <span id="catalog_allow_edate"></span>
					</div>
					<div id="catalog_allow_none" class="mr10 hide">금지</div>
				</td>
			</tr>
			<tr>
				<th class="its-th">페이지 배너</th>
				<td class="its-td" colspan="3">

<?php if(serviceLimit('H_FR')){?>
						<span class="desc">배너 영역 기능은 업그레이드가 필요합니다.</span> <img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand" onclick="serviceUpgrade();" align="absmiddle" />
<?php }else{?>
						<div class="banner_wrap hide">

						</div>
<?php }?>

				</td>
			</tr>
			<tr>
				<th class="its-th">페이지 추천상품</th>
				<td class="its-td" colspan="3">
					<span id="page_recommend_desc">없음</span>
				</td>
			</tr>
			<tr>
				<th class="its-th">페이지 검색 필터</th>
				<td class="its-td" colspan="3"><span id="use_search_filter"></span></td>
			</tr>
			<tr>
				<th class="its-th">네비게이션 노출</th>
				<td class="its-td" colspan="3"><span id="navHide"></span></td>
			</tr>
			<tr>
				<th class="its-th">전체 네비게이션 노출</th>
				<td class="its-td" colspan="3"><span id="allNavHide"></span></td>
			</tr>

		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td height="20px">
	</td>
</tr>
</table>

<div style="margin:0 10px; padding:15px 20px; border:2px #767676 solid; border-radius:4px; font:14px/1.5em 'Malgun Gothic';">
	<a href="../page_manager/page_layout?cmd=category" target="_blank" title="새창" style="font-weight:bold; color:#000;">카테고리 페이지 관리</a>
	<p style="padding-top:8px; color:#767676;">
		카테고리 페이지에 관한 다양한 설정은 
		"<a href="../page_manager/page_layout?cmd=category" target="_blank" title="새창" style="display:inline-block; vertical-align:middle; border-bottom:1px #333 solid">판매상품 > 상품리스트 페이지 > 카테고리 설정</a>" 
		에서 하실 수 있습니다.<br />
		<p style="padding-top:8px; color:#999;">- 접속제한, 추천상품, 검색필터, 노출 배너, 네비게이션에 노출 여부/배너</p>
	</p>
</div>
</form>

<div id="layerPageBanner" class="hide"></div>
<div id="layerSingleNavigation" class="hide">
	<div class="wx200 fr right">
		네비게이션 안내<span class="helpicon2 detailDescriptionLayerBtn" title="네비게이션 안내"></span>
		<div class="detailDescriptionLayer hide">네비게이션(가로형/세로형) 생성</div>
	</div>
	<table class="info-table-style cboth" width="100%" cellspacing="0" cellpadding="0">
		<colgroup>
			<col width="33%"/>
			<col width="33%"/>
			<col width="*"/>
		</colgroup>
		<tbody>
			<tr>
				<th class="its-th">타입</th>
				<th class="its-th">영역</th>
				<th class="its-th">소스복사</th>
			</tr>
			<tr>
				<td class="its-td">카테고리</td>
				<td class="its-td">단독 네비게이션</td>
				<td class="its-td">
					<a href="javascript:;" onclick="copy_navigation();">소스복사</a>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<!-- 서브메뉴 바디 : 끝 -->

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>