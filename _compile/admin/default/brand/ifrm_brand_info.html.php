<?php /* Template_ 2.2.6 2022/05/17 12:30:58 /www/music_brother_firstmall_kr/admin/skin/default/brand/ifrm_brand_info.html 000031030 */ 
$TPL_groups_1=empty($TPL_VAR["groups"])||!is_array($TPL_VAR["groups"])?0:count($TPL_VAR["groups"]);?>
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
	var categoryUrl = gl_protocol+"<?php echo $_SERVER["HTTP_HOST"]?>/goods/brand?code=";
	$(function () {

		// 주소 복사 크로스브라우징을 위해 추가 leewh 2014-10-17
		initClipBoard();

		$(document).resize(function(){
			$('#ifrmCategorySetting',parent.document).height($('form').height()+200);
		}).resize();

		Editor.onPanelLoadComplete(function(){
			$(document).resize();
		});

		/* 업로드버튼 세팅 */
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
		$('#brandIconUploadButton').createAjaxFileUpload(opt, callback);
		$('#brandLeftUploadButton').createAjaxFileUpload(opt, callback);
		$('#nodeImageNormalUploadButton').createAjaxFileUpload(opt, callback);
		$('#nodeImageOverUploadButton').createAjaxFileUpload(opt, callback);
		$('#nodeCatalogImageNormalUploadButton').createAjaxFileUpload(opt, callback);
		$('#nodeCatalogImageOverUploadButton').createAjaxFileUpload(opt, callback);
		$('#nodeGnbImageNormalUploadButton').createAjaxFileUpload(opt, callback);
		$('#nodeGnbImageOverUploadButton').createAjaxFileUpload(opt, callback);

		$("#setGroup").live("click",function(){
			openDialog("접속제한 <span class='desc'>브랜드를 접속할 회원그룹을 설정합니다.</span>", "setGroupsPopup", {"width":"500","height":300,"position":[100,100]});
		});

		$("#saveGroupBtn").click(function(){
			closeDialog("setGroupsPopup");
		});

		$("input[name=memberGroup]").live("click",function(){
			groupsMsg();
		});

		$("input[name=userType]").live("click",function(){
			groupsMsg();
		});

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


		// 브랜드 그룹 관련 추가
		$("#brandClassificationPopupBtn").click(function(){
			$useSeqAry = [];
			$("input[name='classification_seq[]']").each(function(idx, data){
				$useSeqAry[idx] = $(data).val();
			});

			$.post("/admin/brand_process/classification/list", {"not_in_seq" : $useSeqAry}, function(response){
				$option = "";
				$(response).each(function(idx, data){
					$option += "<option value=\""+data.title+"\" data-seq=\""+data.seq+"\">"+data.title+"</option>";
				});

				$("#setClassificationPopup select.list").html($option);
				openDialog("브랜드 그룹 설정", "setClassificationPopup", {"width":"512","height":"400","position":[100,100]});
			}, "json");
		});

		// 브랜드 그룹 등록
		$("#ClassificationPopupFm a.regist").click(function(){
			$.post("/admin/brand_process/classification/insert", {"title" : $("#ClassificationPopupFm input[name='title']").val()}, function(response){

				$option = "<option value=\""+response.title+"\" data-seq=\""+response.seq+"\">"+response.title+"</option>";
				$("#setClassificationPopup select.list").prepend($option);
				$("#ClassificationPopupFm input[name='title']").val("");
			},"json");
		});

		// 오른쪽으로 넣기
		$("#ClassificationPopupFm .insert").click(function(){
			$("#setClassificationPopup select.list > option:selected").remove().appendTo("#setClassificationPopup select.foruse");
		});

		// 왼쪽으로 빼기
		$("#ClassificationPopupFm .delete").click(function(){
			$("#setClassificationPopup select.foruse > option:selected").remove().appendTo("#setClassificationPopup select.list");
		});
		$("#ClassificationPopupFm .up").click(function(){
			$("#setClassificationPopup select.foruse > option:selected").each(function(idx, data){
				$listItem = $(this);
				$listItemPosition = $("#setClassificationPopup select.foruse > option").index($listItem) + 1;
				if ($listItemPosition == 1) return false;
				$listItem.insertBefore($listItem.prev());
			});
		});
		$("#ClassificationPopupFm .down").click(function(){
			$itemsCount = $("#setClassificationPopup select.foruse > option").length;
			$($("#setClassificationPopup select.foruse > option:selected").get().reverse()).each(function() {
				$listItem = $(this);
				$listItemPosition = $("#setClassificationPopup select.foruse > option").index($listItem) + 1;
				if ($listItemPosition == $itemsCount) return false;
				$listItem.insertAfter($listItem.next());
			});
		});
		$("#ClassificationPopupFm .item_delete").click(function(){
			if(confirm("삭제하시겠습니까?")) {
				$("#setClassificationPopup select.list > option:selected").each(function(idx, data){
					$seq = $(this).attr("data-seq");
					$.post("/admin/brand_process/classification/delete",{ "seq" : $seq});
					$(this).remove();
				});
			}
		});

		$("#ClassificationPopupFm").submit(function(){
			$txtAry = [];
			$html = "";
			$("#setClassificationPopup select.foruse > option").each(function(idx, data){
				$seq = $(data).attr("data-seq");
				$txt = $(data).val();
				$html += "<input type=\"hidden\" name=\"classification_seq[]\" value=\""+$seq+"\" />" ;
				$html += "<input type=\"hidden\" name=\"classification_txt[]\" value=\""+$txt+"\" />" ;
				$txtAry[idx] = $txt;
			});
			$html += $txtAry.join(",");
			$("#brandClassificationCfg").html($html);
			closeDialog("setClassificationPopup");
			return false;
		});

		//브랜드 > 국가 선택시 
		$("#countrySelect").change(function(){
			$seq = $(this).val();
			if($seq === "brand_country_add") {
				$("#brandCountryCfg").html("");
				$("#brandFlagImg").html("");
				// 브랜드 국가관련 설정
				openDialog("국가 직접등록", "setCountryPopup", {"width":"482","height":"220","position":[100,100]});

			} else {
				$img = $(this).find("option:selected").attr("data-flag");

				$("#brandCountryCfg").html("");

				if($seq!=''){
					$("#brandCountryCfg").append("<span class='btn small gray'><input type='button' class='countryModifyBtn' value='수정' /></span>");
				}
				$("#brandFlagImg").html('');
				if( $img ) {
					$imgtag = "<img src=\"/data/brand_country/"+$img+"\" style=\"max-height:20px;\" />";
					$("#brandFlagImg").html($imgtag);
				}
			}

		});

		//브랜드 > 국가 수정폼
		$(".countryModifyBtn").live('click',function(){
			// 브랜드 국가관련 설정
			openDialog("국가 수정", "setCountryModifyPopup", {"width":"482","height":"220","position":[100,100]});
			$("#setCountryModifyPopup input[name='country_seq']").val($("#countrySelect").val());
			$("#setCountryModifyPopup input[name='name']").val($("#countrySelect option:selected").text());
			var flaghtml = $("#brandFlagImg").html();
			if( $("#brandFlagImg").html()) {
				flaghtml += " <span class='btn small gray'><input type='button' class='countryImgDeleteBtn' value='삭제'  country_seq=\""+$("#countrySelect").val()+"\" /></span>";
			}
			$("#setCountryModifyPopup .flagimg").html(flaghtml);
		});

		//브랜드 > 국가 > 이미지 삭제
		$(".countryImgDeleteBtn").live('click',function(){
			var country_seq = $(this).attr("country_seq");
			if(confirm("삭제하시겠습니까?")) {
				$.ajax({
					'url' : '../brand_process/country/imgdelete',
					'data' : {'country_seq':country_seq},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(response){
						if( response.result ) {
							$("#brandFlagImg").html("");
							closeDialog("setCountryModifyPopup");
						}else{
							alert(response.msg);
						}
					}
				});
			}
		});
	});

	//수정/등록후 
	function setCountryView(resultTxt){
		$data = jQuery.parseJSON(resultTxt);
		var vselected = false;

		$("select[name='country_seq']").each(function() {
			if ( $(this).find("option:selected").val() == 'brand_country_add' ) {
				vselected = true;
			}else{
				if( $data.seq ==  $(this).find("option:selected").val() ){//동일할 경우 이름 점검
					if( $data.name != $(this).find("option:selected").text() ) {//이름 변경시
						$(this).find("option:selected").text($data.name);
					}
					if( $data.flagimg != $(this).find("option:selected").attr("data-flag") ) {//이미지 변경시
						$(this).find("option:selected").attr("data-flag",$data.flagimg);
					}
				}
			}
		});

		if( vselected ) {//등록후 폼추가  brand_country_add
			$("select[name='country_seq']").append('<option value="'+$data.seq+'" data-flag="'+$data.flagimg+'"  selected="selected" >'+$data.name+'</option>');
		}
		if($data.flagimg) {
			$imgtag = "<img src=\"/data/brand_country/"+$data.flagimg+"\" style=\"max-height:20px;\" /> " ;
			$("#brandFlagImg").html($imgtag);
		}else{
			$("#brandFlagImg").html("");
		}
		$html = "";
		$html += "<span class='btn small gray'><input type='button' class='countryModifyBtn' value='수정' /></span>" ;
		$("#brandCountryCfg").html($html);
		closeDialog("setCountryPopup");
		closeDialog("setCountryModifyPopup");
	}

	function setCountry(resultTxt){
		$data = jQuery.parseJSON(resultTxt);
		//$("#countrySelect").attr("<option value=\""+$data.seq+"\" data-flag=\""+$data.flagimg+"\" selected=\"selected\">"+$data.name+"</option>");
		if($data.flagimg) {
			$imgtag = "<img src=\"/data/brand_country/"+$data.flagimg+"\" style=\"max-height:20px;\" /> " ;
			$("#brandFlagImg").html($imgtag);
		}else{
			$("#brandFlagImg").html("");
		}

		$html = "";
		$html += "<input type=\"hidden\" name=\"country_seq\" value=\""+$data.seq+"\" />" ;
		$html += $data.name ;

		$("#brandCountryCfg").html($html);
		closeDialog("setCountryPopup");
	}

	//국가 수정폼
	function setCountryModify(resultTxt){
		$("#brandFlagImg").html("");
		$data = jQuery.parseJSON(resultTxt);
		$("#countrySelect option[value='"+$data.seq+"']").text($data.name);
		if($data.flagimg) {
			$imgtag = "<img src=\"/data/brand_country/"+$data.flagimg+"\" style=\"max-height:20px;\" /> <span class='btn small gray'><input type='button' class='countryImgDeleteBtn' value='삭제' country_seq=\""+$data.seq+"\" /></span>" ;
			$("#brandFlagImg").html($imgtag);
		}
		$html = "";
		$html += "<span class='btn small gray'><input type='button' class='countryModifyBtn' value='수정' /></span>" ;

		$("#brandCountryCfg").html($html);
		closeDialog("setCountryModifyPopup");
	}

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
				if(result[i].top_html != ''){
					$('#layerPageBanner').html(result[i].top_html);
					$('.banner_wrap').html('<span class="hand highlight-link" onclick=\'openDialog("페이지배너", "layerPageBanner", {"width":"800","height":"500"});\'>배너</span>').removeClass('hide');
				}else{
					$('.banner_wrap').text('미사용').removeClass('hide');
				}

				// 카테고리 네비게이션
				if(result[i].hide == '1')	$('#navHide').text('미노출');
				else						$('#navHide').text('노출');

				// 전체 카테고리 네비게이션
				if(result[i].hide_in_gnb == '1')	$('#allNavHide').text('미노출');
				else								$('#allNavHide').text('노출');

				// 추천상품
				if(result[i].auto_criteria_desc)	$('#page_recommend_desc').html(result[i].auto_criteria_desc);
				else								$('#page_recommend_desc').text('미사용');

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
				$("#urlLocation").html(categoryUrl+categoryCode);
			}
		}
		if(!isGroups)$("input[type='checkbox'][name='memberGroup']").attr("checked",false);
		$("#categoryNavi").html(arr.join(" > "));

		$(".customFontDecoration").customFontDecoration();

		disableNodeTypeDecoration();
		disableNodeCatalogTypeDecoration();
		disableNodeGnbTypeDecoration();
		//disableNodeCategoryTypeDecoration();
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
		clipboard_copy('{\=showBrandLightNavigation("brand_gnb_single", "<?php echo $TPL_VAR["categoryCode"]?>")}');
		alert("클립보드에 복사되었습니다.");
	}
</script>
<style>
	.info-table-style .its-th {padding-left:10px !important;}
	.point_star{color:#cc0000}
</style>

<!-- 서브메뉴 바디 : 시작-->
<form name="categorySettingForm" method="post" target="actionFrame" action="../brand_process/brand_info">
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
							<label><input type="checkbox" name="best" value="Y" <?php if($TPL_VAR["categoryData"]["best"]=='Y'){?>checked<?php }?>/> <span class="point_star">★</span></label>
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
							<span id="urlLocation"></span><span class="btn small gray"><input type="button" id="clipboard" value="복사"/></span>
						</td>
						<th class="its-th">
							상품코드용 코드
							<span class="helpicon" title="설정>상품코드에서 사용되는 해당 브랜드 코드를 입력하세요."></span>
						</th>
						<td class="its-td">
<?php if(serviceLimit('H_FR')){?>
							<span class="desc">코드값 기능은 업그레이드가 필요합니다.</span> <img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand" onclick="serviceUpgrade();" align="absmiddle" />
<?php }else{?>
							<input type="text" name="brand_goods_code" value="<?php echo $TPL_VAR["categoryData"]["brand_goods_code"]?>" />
<?php }?>
						</td>
					</tr>
					<tr>
						<th class="its-th">상품 수</th>
						<td class="its-td">
							<span id="goodsCnt"></span>개 (하위 카테고리 포함)
						</td>
						<th class="its-th">브랜드페이지 QR 코드</th>
						<td class="its-td">
							<a href="javascript:;" class="qrcodeGuideBtn fx11 lsp-1" target="parent" key="brand" value="<?php echo $TPL_VAR["categoryCode"]?>">자세히▶</a>
						</td>
					</tr>
					<tr>
						<th class="its-th" >브랜드 영문명</th>
						<td class="its-td" colspan="3">
							<input type="text" name="title_eng" value="<?php echo htmlspecialchars($TPL_VAR["categoryData"]["title_eng"])?>" class="wx300" />
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
						<td class="its-td" colspan="3"><span id="page_recommend_desc"></span></td>
					</tr>
					<tr>
						<th class="its-th">페이지 검색필터</th>
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
		<a href="../page_manager/page_layout?cmd=brand" target="_blank" title="새창" style="font-weight:bold; color:#000;">브랜드 페이지 관리</a>
		<p style="padding-top:8px; color:#767676;">
			브랜드 페이지에 관한 다양한 설정은
			"<a href="../page_manager/page_layout?cmd=brand" target="_blank" title="새창" style="display:inline-block; vertical-align:middle; border-bottom:1px #333 solid">판매상품 > 상품리스트 페이지 > 브랜드 설정</a>"
			에서 하실 수 있습니다.<br />
		<p style="padding-top:8px; color:#999;">- 접속제한, 추천상품, 검색필터, 노출 배너, 네비게이션에 노출 여부/배너</p>
		</p>
	</div>

<?php if($TPL_VAR["groups"]){?>
	<div id="setGroupsPopup" class="hide">
		<p class="mt10 bold">조건1) 선택된 회원등급만 접속을 허용</p>
		<p class="mt10">
<?php if($TPL_groups_1){foreach($TPL_VAR["groups"] as $TPL_V1){?>
			<label><input type="checkbox" name="memberGroup" value="<?php echo $TPL_V1["group_seq"]?>" class="line" ><?php echo $TPL_V1["group_name"]?></label>
<?php }}?>
		</p>

		<p class="mt20 bold">조건2) 선택된 회원 유형만 접속을 허용</p>

		<p class="mt10">
			<label><input type="checkbox" name="userType" value="default" class="line" >개인</label>
			<label><input type="checkbox" name="userType" value="business" class="line" >기업</label>
		</p>

		<p class="center mt20 red"><strong>조건1</strong>과 <strong>조건2</strong>를 모두 만족해야만 접속이 가능합니다.</p>
		<p class="center mt10">
			<span class="btn large cyanblue"><a id="saveGroupBtn">저장</a></span>
		</p>
	</div>
<?php }?>
</form>

<div id="setClassificationPopup" class="hide">
	<form id="ClassificationPopupFm" method="post">
		<fieldset>
			<legend>브랜드 그룹 설정</legend>
			<div class="fl wx200">
				<p>
					<input type="text" name="title" style="width:130px;" />
					<span class="btn medium green"><a class="regist">등록</a></span>
				</p>

				<p class="mt10">
					<select multiple="multiple" class="wp95 hx200 list"></select>
				</p>
				<p class="mt5"><span class="btn small red"><a class="item_delete">선택삭제</a></span></p>

			</div>

			<div class="fl wx30 center mt30">
				<span class="btn small gray mt30"><a class="insert">▶</a></span>
				<span class="btn small gray mt5"><a class="delete">◀</a></span>
			</div>

			<div class="fr wx30 center mt30">
				<span class="btn small gray mt30"><a class="up">▲</a></span>
				<span class="btn small gray mt5"><a class="down">▼</a></span>
			</div>

			<div class="fr wx200 mt10" >
				<p>&nbsp;</p>
				<p class="mt10">
					<select multiple="multiple" class="wp95 hx200 foruse">
<?php if(is_array($TPL_R1=$TPL_VAR["categoryData"]["classification"]["txt"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
						<option value="<?php echo $TPL_V1?>" data-seq="<?php echo $TPL_VAR["categoryData"]["classification"]["seq"][$TPL_I1]?>"><?php echo $TPL_V1?></option>
<?php }}?>
					</select>
				</p>
			</div>


			<p class="cboth"></p>
			<p class="center mt10">
				<span class="btn large cyanblue"><input type="submit" value="저장" /></span>
			</p>
		</fieldset>
	</form>
</div>


<div id="setCountryPopup" class="hide">
	<form enctype="multipart/form-data" target="actionFrame" method="post" action="/admin/brand_process/country/insert">
		<fieldset>
			<legend>직접입력</legend>
			<table width="100%" class="info-table-style">
				<colgroup>
					<col width="100px">	<col >
				</colgroup>
				<tbody>
				<tr>
					<th class="its-th" colspan="2">국가이름</th>
					<td class="its-td">
						<input type="text" name="name" class="wp85" />
					</td>
				</tr>
				<tr>
					<th class="its-th" colspan="2">국기이미지</th>
					<td class="its-td">
						<input type="file" name="flagimg" />
					</td>
				</tr>
				</tbody>
			</table>
			<p class="center mt10">
				<span class="btn large cyanblue"><input type="submit" value="저장" /></span>
			</p>
		</fieldset>
	</form>
</div>

<div id="setCountryModifyPopup" class="hide">
	<form enctype="multipart/form-data" target="actionFrame" method="post" action="/admin/brand_process/country/modify">
		<input type="hidden" name="country_seq" value="" />
		<fieldset>
			<legend>직접입력</legend>
			<table width="100%" class="info-table-style">
				<colgroup>
					<col width="100px">	<col >
				</colgroup>
				<tbody>
				<tr>
					<th class="its-th" colspan="2">국가이름</th>
					<td class="its-td">
						<input type="text" name="name" class="wp85" />
					</td>
				</tr>
				<tr>
					<th class="its-th" colspan="2">국기이미지</th>
					<td class="its-td">
						<span class="flagimg"></span>
						<input type="file" name="flagimg" />
					</td>
				</tr>
				</tbody>
			</table>
			<p class="center mt10">
				<span class="btn large cyanblue"><input type="submit" value="저장" /></span>
			</p>
		</fieldset>
	</form>
</div>
<!-- 서브메뉴 바디 : 끝 -->

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
			<td class="its-td">브랜드</td>
			<td class="its-td">단독 네비게이션</td>
			<td class="its-td">
				<a href="javascript:;" onclick="copy_navigation();">소스복사</a>
			</td>
		</tr>
		</tbody>
	</table>
</div>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>