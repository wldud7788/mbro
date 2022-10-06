<?php /* Template_ 2.2.6 2022/05/17 12:31:36 /www/music_brother_firstmall_kr/admin/skin/default/design/lastest_insert.html 000039756 */ 
$TPL_styles_1=empty($TPL_VAR["styles"])||!is_array($TPL_VAR["styles"])?0:count($TPL_VAR["styles"]);
$TPL_boardList_1=empty($TPL_VAR["boardList"])||!is_array($TPL_VAR["boardList"])?0:count($TPL_VAR["boardList"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<link rel="stylesheet" href="/app/javascript/plugin/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/lib/util/dialog.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/neat.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/elegant.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/night.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/monokai.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/cobalt.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/eclipse.css">
<link rel="stylesheet" href="/app/javascript/plugin/codemirror/theme/rubyblue.css">
<script src="/app/javascript/plugin/codemirror/lib/codemirror.js"></script>
<script src="/app/javascript/plugin/codemirror/mode/xml/xml.js"></script>
<script src="/app/javascript/plugin/codemirror/mode/javascript/javascript.js"></script>
<script src="/app/javascript/plugin/codemirror/lib/util/dialog.js"></script>
<script src="/app/javascript/plugin/codemirror/lib/util/search.js"></script>
<script src="/app/javascript/plugin/codemirror/lib/util/searchcursor.js"></script>
<script src="/app/javascript/plugin/codemirror/mode/css/css.js"></script>
<script src="/app/javascript/plugin/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="/app/javascript/plugin/codemirror/mode/htmlembedded/htmlembedded.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-font-decoration.js"></script>
<script type="text/javascript" src="/app/javascript/js/base64.js"></script>
<script type="text/javascript" src="/app/javascript/js/board-display.js?v=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=120824"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=120824"></script>
<script type="text/javascript">
	var info_item_config = {
		'showNumber'	: ['kind','font_decoration'],
		'showTitle'		: ['kind','font_decoration'],
		'showName'		: ['kind','font_decoration'],
		'showScore'		: ['kind','font_decoration'],
		'showContents': ['kind','font_decoration'],
		'showImg'		: ['kind','font_decoration'],
		'showView'		: ['kind','font_decoration'],
		'showRecommend'		: ['kind','font_decoration'],
		'showBuyer'		: ['kind','font_decoration']
	};//

	$(function(){

		$(".lastest_selector").change(function(){
			var boardId	 = $("select[name='boardId']").val();
			var boardurl = "/board/?id="+boardId;
			$("#boardurllay").attr('boardurl',boardurl);
			$("#displayBoardurlButton").attr('boardurl',boardurl);
			$("#boardurllay").text(boardurl);

			if($(this).attr('name') == 'showImg') {
				if($(this).attr("checked") == "checked") {//이미지
					$(".ImgDisplaylay").show();
				}else{
					$(".ImgDisplaylay").hide();
				}
			}

			if($(this).attr('name') == 'showName') {
				if( $(this).attr("checked") == "checked") {//작성자
					$(".writelay").show();
				}else{
					$(".writelay").hide();
				}
			}

			if($(this).attr('name') == 'showContents') {
				if( $(this).attr("checked") == "checked") {//내용
					$(".contentslay").show();
				}else{
					$(".contentslay").hide();
				}
			}
		});

		$("#displayBoardurlButton").live('click',function(){
			//url 복사
			clipboard_copy($(this).attr('boardurl'));
			alert("주소가 복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.");
		});

		$("select[name='boardId']").change(function(){
			//$("textarea[name='title']").val($("select[name='boardId'] option:selected").attr('title'));

			$(".option_selector").attr('disabled',true).closest('label').hide();
			$("#goodsrevieworderbylay").hide();
			$(".goods_select_container").hide();
			$("#boardorderbylay").show();

			var title = "제목";// [덧글수] [답변상태] [이미지,첨부,NEW,HOT
					$("input[name='showNumber']").removeAttr('disabled').closest('label').show();
					$("input[name='showTitle']").removeAttr('disabled').closest('label').show().children('span').text(title);
					$("input[name='showDate']").removeAttr('disabled').closest('label').show();
					$("input[name='showView']").removeAttr('disabled').closest('label').show();
			$("input[name='showRecommend']").removeAttr('disabled').closest('label').show();

			switch($(this).val()){
				case "notice":
					var imgtitle = "이미지";
					$("input[name='showImg']").removeAttr('disabled').closest('label').show().children('span').text(imgtitle);
				break;
				case "mbqna":
					var imgtitle = "이미지";
					$("input[name='showImg']").removeAttr('disabled').closest('label').show().children('span').text(imgtitle);
					$("input[name='showName']").removeAttr('disabled').closest('label').show();
				break;
				case "goods_qna":
					title = "상품명 + 제목";// [덧글수] [답변상태] [이미지,첨부,NEW,HOT]
					$("input[name='showTitle']").removeAttr('disabled').closest('label').show().children('span').text(title);
					var imgtitle = "이미지(상품)";
					$("input[name='showImg']").removeAttr('disabled').closest('label').show().children('span').text(imgtitle);
					$("input[name='showContents']").removeAttr('disabled').closest('label').show();
					$("input[name='showName']").removeAttr('disabled').closest('label').show();
				break;
				case "goods_review":
					title = "상품명 + 제목";// [덧글수] [답변상태] [이미지,첨부,NEW,HOT]
					$("input[name='showTitle']").removeAttr('disabled').closest('label').show().children('span').text(title);
					var imgtitle = "이미지(상품)";
					$("input[name='showImg']").removeAttr('disabled').closest('label').show().children('span').text(imgtitle);
					$("input[name='showContents']").removeAttr('disabled').closest('label').show();
					$("input[name='showName']").removeAttr('disabled').closest('label').show();
					$("input[name='showScore']").removeAttr('disabled').closest('label').show();
					$("input[name='showBuyer']").removeAttr('disabled').closest('label').show();

					$("#goodsrevieworderbylay").show();
					$(".goods_select_container").show();
					$("#boardorderbylay").hide();

				break;
				default:
					var imgtitle = "이미지";
					$("input[name='showImg']").removeAttr('disabled').closest('label').show().children('span').text(imgtitle);
					$("input[name='showName']").removeAttr('disabled').closest('label').show();
				break;
			}
			//option_selector
		}).change();

		$(".option_selector_list").sortable();


<?php if($TPL_VAR["template_path"]&&$TPL_VAR["display_seq"]){?>
		parent.DM_window_title_set("left","<a href=\"javascript:;\" onclick=\"DM_window_sourceeditor('<?php echo $TPL_VAR["template_path"]?>','\{=showDesignDisplay(<?php echo $TPL_VAR["display_seq"]?>)\}')\">◀ 게시판 디스플레이 영역의 HTML소스보기</a>");
		parent.DM_window_title_set("title","게시판 변경");
<?php }else{?>
		parent.DM_window_title_set("title","게시판 넣기");
<?php }?>
		parent.DM_window_title_set("center","<?php echo $TPL_VAR["layout_config"]["tpl_desc"]?>(<?php echo $TPL_VAR["layout_config"]["tpl_path"]?>)에 선택한 ");

		/* 스타일별 가로출력수 고정 설정 */
		$("input[name='style']").live('change',function(){
			$("input[name='count_w']").removeAttr('readOnly');
			if($(this).is(":checked")){
<?php if($TPL_styles_1){foreach($TPL_VAR["styles"] as $TPL_K1=>$TPL_V1){?>
					if($(this).val()=="<?php echo $TPL_K1?>"){
<?php if($TPL_V1["count_w"]){?>
							if($("input[name='count_w']").val()=='') $("input[name='count_w']").val("<?php echo $TPL_V1["count_w"]?>");
<?php }?>
<?php if($TPL_V1["count_w_fixed"]){?>
						$("input[name='count_w']").val("<?php echo $TPL_V1["count_w"]?>").attr('readOnly',true);
<?php }?>

						$("input[name='count_w']").change();
					}
<?php }}?>
			}
		}).change();

		/* 노출개수 합계 표시 */
		$("input[name='count_w'],input[name='count_h']").bind('keyup change',function(){
			var count_w = parseInt($("input[name='count_w']").val());
			var count_h = parseInt($("input[name='count_h']").val());
			if(!count_w) count_w = 0;
			if(!count_h) count_h = 0;
			$("#count_total").html(count_w*count_h);
		}).change();

		/* 게시글선택 버튼 */
		$("button#displayBoardButton").bind("click",function(){
			if($("#displayBoardSelectContainer").is(":visible")){
				$(".displayBoardSelect").empty();
				$("#displayBoardSelectContainer").hide();
			}else{
				$("#displayBoardSelectContainer").show();
				set_goods_list("displayBoardSelect","displayBoard");
			}

		});
		$("#displayBoard").sortable();
		$("#displayBoard").disableSelection();

		/* 컬러피커 */
		$(".colorpicker").customColorPicker();

		changeFileStyle();

		/* 자동노출 설정 */
		$("input[name='auto_use']").bind('change',function(){
			if($(this).is(':checked')){
				$(".goods_select_container th,.goods_select_container td").css('opacity',0.5);
				$(".auto_order_container").css('opacity',1);
				$(".auto_order_container input").removeAttr('disabled');
			}else{
				$(".goods_select_container th,.goods_select_container td").css('opacity',1);
				$(".auto_order_container").css('opacity',0.5);
				$(".auto_order_container input").attr('disabled',true);
			}
		}).change();

	});

	function showrecommendck(){
		$("input[name='showRecommend']").attr("checked",false);
	}

	function set_goods_list(displayId,inputBoard){
		$.ajax({
			type: "get",
			url: "../board/review_select",
			data: "innerMode=2&containerHeight=230&page=1&inputBoard="+inputBoard+"&displayId="+displayId,
			success: function(result){
				$("div#"+displayId).html(result);
				$("#"+displayId+"Container").show();
			}
		});
	}

	$(document).ready(function() {
		EditorJSLoader.ready(function(Editor) {
			DaumEditorLoader.init(".daumeditor");
		});
	});
	/* 저장하기 */
	function lastestinsert(){
		var infock = 0;
		$(".option_selector").each(function(){
			if($(this).attr("checked") == 'checked') {
				infock++;
			}
		});
		if(infock == 0){
			alert("출력 항목을 최소 1개 이상 선택하셔야 합니다.");
			return false;
		}

		submitEditorForm(document.displayManagerForm);
	}
</script>
<style>
	.info_item {min-height:30px;line-height:30px;padding:0 3px;border:1px solid #ddd;background-color:#fff;margin:1px;}
	.info_item_holder {min-height:30px;line-height:30px;padding:0 3px;border:1px solid #ddd;background-color:#ffeecc;margin:1px;}
	.showlistlay ul { list-style:none; padding-left:0px; padding-top:10px; }
	.showlistlay li { margin: 5px 0; padding: 0 5px; border : 0; float: left; }

	.goodsviewbox1 {float:left;width:50%;padding-bottom: 5px; padding-left: 0px; padding-right: 0px; border-top: #efefef 0px solid; padding-top: 5px;}
	.goodsviewbox1 .pic {width: 50px; float: left; vertical-align: top;}
	.goodsviewbox1 .gdinfo {width:150px;line-height: 140%; float: left; margin-left: 10px;}
	.goodsviewbox1 .gdinfo .goods_name {padding-bottom: 5px; padding-left: 0px; padding-right: 0px; padding-top: 0px;}
	.goodsviewbox1 .gdinfo .price {font-family: dotum; color: #333333;}

	.goodsviewbox2 {float:left;width:50%;padding-bottom: 5px; padding-left: 0px; padding-right: 0px; border-top: #efefef 0px solid; padding-top: 5px;}
	.goodsviewbox2 .info { line-height: 140%;margin-left: 10px;}
	.goodsviewbox2 .info .subject {width:250px;padding-bottom: 5px; padding-left: 0px; padding-right: 0px; color: #3c5899; font-weight: bold; padding-top: 0px;}
	.cboth tr{height:20px;}
</style>

<form name="displayManagerForm" action="../design_process/lastest_insert_new" method="post" target="actionFrame">
	<input type="hidden" name="template_path" value="<?php echo $TPL_VAR["template_path"]?>" />
	<div style="padding:15px;">
		<table class="design-simple-table-style" width="100%" align="center" border="0">
			<col width="120" />
			<col  />
			<col width="120" />
			<col   />
			<tr>
				<th class="dsts-th">삽입 위치</th>
				<td class="dsts-td left" nowrap>
					<div class="imageCheckboxContainer">
						<div class="imageCheckboxItem"><label><input type="radio" name="location" value="top" checked="checked"  class="lastest_selector"/><img src="/admin/skin/default/images/design/img_layout_up.gif" /></label></div>
						<div class="imageCheckboxItem"><label><input type="radio" name="location" value="bottom"  class="lastest_selector"/><img src="/admin/skin/default/images/design/img_layout_down.gif" /></label></div>
					</div>
				</td>
				<th class="dsts-th">스타일</th>
				<td class="dsts-td left" nowrap >
					<div class="imageCheckboxContainer">
<?php if($TPL_styles_1){$TPL_I1=-1;foreach($TPL_VAR["styles"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1&&$TPL_I1% 4== 0){?><br /><?php }?>
						<div class="imageCheckboxItem"><label><input type="radio" name="style" value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["data"]["style"]){?>checked="checked"<?php }?> /><img src="/admin/skin/default/images/design/img_<?php echo $TPL_K1?>.gif" title="<?php echo $TPL_V1["name"]?>" /></label></div>
<?php }}?>
					</div>
				</td>
			</tr>
			<tr>
				<th class="dsts-th">게시판</th>
				<td class="dsts-td left" colspan="3" >
					<select name="boardId" class="lastest_selector">
<?php if($TPL_boardList_1){foreach($TPL_VAR["boardList"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["id"]?>" title="<?php echo $TPL_V1["name"]?>"><?php echo $TPL_V1["name"]?> (<?php echo $TPL_V1["id"]?>)</option>
<?php }}?>
					</select>
				</td>
			</tr>

			<tr>
				<th class="dsts-th">게시판 타이틀</th>
				<td class="dsts-td left" colspan="3">
					<span class="desc" style="letter-spacing:0;">더보기 URL 안내 <span id="boardurllay" boardurl="" ></span>&nbsp;
					<span class="btn small gray mb5"><button type="button"  id="displayBoardurlButton">복사</button></span></span>
					<textarea name="title" id="title" class="daumeditor"  style='width:95%; height:50px;'  contentHeight="50px"><?php echo $TPL_VAR["data"]["title"]?></textarea>
				</td>
			</tr>
			<tr>
				<th class="dsts-th">노출 개수</th>
				<td class="dsts-td left" colspan="3">
					가로 <input type="text" name="count_w" value="<?php echo $TPL_VAR["data"]["count_w"]?>" class="lastest_selector line" size="2" maxlength="2" />개
					X 세로 <input type="text" name="count_h" value="<?php if($TPL_VAR["data"]["count_h"]){?><?php echo $TPL_VAR["data"]["count_h"]?><?php }else{?>1<?php }?>" class="lastest_selector line" size="2" maxlength="2" />개
					= 총 <b><span id="count_total"></span></b>개 게시글
				</td>
			</tr>

			<tr>
				<th class="dsts-th">출력 항목</th>
				<td class="dsts-td left" colspan="3">
					<span class="desc" style="font-weight:normal;"> 마우스로 드래그&드랍으로 노출 순서를 조정할 수 있습니다. 또한 출력 항목을 체크하면 출력 항목별 알맞은 설정화면이 나타납니다. 출력 항목을 최소 1개 이상 선택하셔야 합니다.</span><br/>
					<div style="margin:5px 0px;padding:5px 0px;">
						<ul class="option_selector_list showlistlay" >
							<li><label><input type="checkbox" name="showNumber" class="lastest_selector option_selector" /> <span  style="cursor:move">번호</span></label><input type="text" name="info_setting[]" value="showNumber" class="info_setting hide" /></li>
							<li ><label><input type="checkbox" name="showImg" class="lastest_selector option_selector boarddata" /> <span  style="cursor:move">이미지</span></label><input type="text" name="info_setting[]" value="showImg" class="info_setting hide" /></li>
							<li><label><input type="checkbox" name="showTitle" class="lastest_selector option_selector goodsdata" checked="checked"  /> <span style="cursor:move">상품명+<span color='red'>제목</span></span></label><input type="text" name="info_setting[]" value="showTitle" class="info_setting hide" checked="checked"  /></li>
							<li><label><input type="checkbox" name="showContents" class="lastest_selector option_selector" /> <span  style="cursor:move">내용</span></label><input type="text" name="info_setting[]" value="showContents" class="info_setting hide" /></li>
							<li><label><input type="checkbox" name="showDate" class="lastest_selector option_selector" /> <span  style="cursor:move">날짜</span></label><input type="text" name="info_setting[]" value="showDate" class="info_setting hide" /></li>
							<li><label><input type="checkbox" name="showView" class="lastest_selector option_selector" /> <span  style="cursor:move">조회수</span></label><input type="text" name="info_setting[]" value="showView" class="info_setting hide" /></li>
							<li><label><input type="checkbox" name="showRecommend" class="lastest_selector option_selector" /> <span  style="cursor:move">추천수</span></label><input type="text" name="info_setting[]" value="showRecommend" class="info_setting hide" /></li>
							<li><label><input type="checkbox" name="showName" class="lastest_selector option_selector" /> <span  style="cursor:move">작성자</span></label><input type="text" name="info_setting[]" value="showName" class="info_setting hide" /></li>
							<li><label><input type="checkbox" name="showScore" class="lastest_selector option_selector" /> <span  style="cursor:move">평점</span></label><input type="text" name="info_setting[]" value="showScore" class="info_setting hide" /></li>
							<li><label><input type="checkbox" name="showBuyer" class="lastest_selector option_selector" /> <span  style="cursor:move">구매여부</span></label><input type="text" name="info_setting[]" value="showBuyer" class="info_setting hide" /></li>
						</ul>
					</div>
				</td>
			</tr>
			<tr>
				<th class="dsts-th">출력항목 정렬</th>
				<td class="dsts-td left"    colspan="3">
					<div class="pdt5 pdl0">
						<label class="mr10"><input type="radio" name="text_align" class="lastest_selector text_align" value="left" title="좌측정렬" <?php if($TPL_VAR["data"]["text_align"]=='left'||!$TPL_VAR["data"]["text_align"]){?>checked="checked"<?php }?> /> 좌측정렬</label>
						<label class="mr10"><input type="radio" name="text_align" class="lastest_selector text_align" value="center" title="중앙정렬" <?php if($TPL_VAR["data"]["text_align"]=='center'){?>checked="checked"<?php }?> /> 중앙정렬</label>
						<label><input type="radio" name="text_align" class="lastest_selector text_align" value="right" title="우측정렬" <?php if($TPL_VAR["data"]["text_align"]=='right'){?>checked="checked"<?php }?> /> 우측정렬</label>
					</div>
				</td>
			</tr>
			<tr class="ImgDisplaylay hide">
				<th class="dsts-th">이미지 리사이즈</th>
				<td class="dsts-td left" colspan="3">
					<input type="text" name="image_w" value="80" size="4" class="lastest_selector" /> X <input type="text" name="image_h" value="80"  size="4" class="lastest_selector" /> ← 우측의 지정된 사이즈로 게시글 내에 있는 이미지의 사이즈를 조절(최초1회)하여 게시글을 빠르게 로딩합니다.
				</td>
			</tr>

			<!-- 게시글이미지디스플레이 꾸미기 영역 : 시작 -->
			<tbody class="ImgDisplaylay  goodsDisplayDecorationContainer  hide">
				<input type="hidden" name="info_settings" class="info_settings" value='<?php if($TPL_VAR["data"]["info_settings"]){?><?php echo $TPL_VAR["data"]["info_settings"]?><?php }else{?>{}<?php }?>' />
				<input type="hidden" name="image_decoration" class="image_decoration" value="" />
				<div class="info_item_default info_item hide" style="min-height:30px">
					<span class="info_item_cell_kind info_item_cell">
						<select class="info_item_kind info_item_selector">
							<option value="showNumber">번호</option>
							<option value="showImg">이미지(상품)</option>
							<option value="showTitle">상품명+제목</option>
							<option value="showContents">내용</option>
							<option value="showDate">날짜</option>
							<option value="showView">조회수</option>
							<option value="showRecommend">추천수</option>
							<option value="showName">작성자</option>
							<option value="showScore">평점</option>
							<option value="showBuyer">구매여부</option>
						</select>
					</span>
				</div>
				<tr>
					<th class="dsts-th">이미지 꾸미기</th>
					<td class="dsts-td left"  colspan="2">
						<div class="clearbox">
							<!-- 테두리 -->
							<table class="image_decoration_table fl" width="100%" height="120">
								<tr>
									<td height="25" valign="top">
										<label><input type="checkbox" class="use_image_border image_decorate_chk" <?php if($TPL_VAR["image_decorations"]->image_border){?>checked="checked"<?php }?> /> 테두리</label>
										<input type="text" value="<?php if($TPL_VAR["image_decorations"]->image_border){?><?php echo $TPL_VAR["image_decorations"]->image_border?><?php }else{?>#000000<?php }?>" class="lastest_selector image_border colorpicker" />
										<input type="text" value="<?php echo $TPL_VAR["image_decorations"]->image_border_width?>" size="3" maxlength="2" class="image_border_width line input-text-small" />px
									</td>
								</tr>
								<tr>
									<td valign="top"><img src="/admin/skin/default/images/design/img_effect_rollover_border.gif" /></td>
								</tr>
							</table>

							<!-- 투명도 -->
							<table class="image_decoration_table fl" width="100%" height="120">
								<tr>
									<td height="25" valign="top">
										<label><input type="checkbox" class="lastest_selector  use_image_opacity image_decorate_chk" <?php if($TPL_VAR["image_decorations"]->image_opacity){?>checked="checked"<?php }?> /> 투명도</label>
										<input type="text" value="<?php echo $TPL_VAR["image_decorations"]->image_opacity?>" size="4" maxlength="3" class="lastest_selector image_opacity line input-text-small" />% <span class="desc">(0%투명도없음)</span>
									</td>
								</tr>
								<tr>
									<td valign="top"><img src="/admin/skin/default/images/design/img_effect_rollover_opacity.gif" /></td>
								</tr>
							</table>

							<!-- 아이콘 -->
							<table class="image_decoration_table fl" width="100%" height="120">
								<tr>
									<td height="25" valign="top">
										<label><input type="checkbox" class="use_image_icon image_decorate_chk" <?php if($TPL_VAR["image_decorations"]->image_icon){?>checked="checked"<?php }?> /> 아이콘</label>

										<input type="hidden" class="image_icon" class="lastest_selector "value="<?php if($TPL_VAR["image_decorations"]->image_icon){?><?php echo $TPL_VAR["image_decorations"]->image_icon?><?php }else{?>icon_best.png<?php }?>" />
<?php if($TPL_VAR["image_decorations"]->image_icon){?>
										<img src="/data/icon/goodsdisplay/<?php echo $TPL_VAR["image_decorations"]->image_icon?>" border="0" class="image_icon_select hand" align="absmiddle">
<?php }else{?>
										<img src="/data/icon/goodsdisplay/icon_best.png" border="0" class="image_icon_select hand" align="absmiddle">
<?php }?>

										<select class="image_icon_location">
											<option value="left" <?php if($TPL_VAR["image_decorations"]->image_icon_location=='left'){?>selected="selected"<?php }?>>좌측상단</option>
											<option value="right" <?php if($TPL_VAR["image_decorations"]->image_icon_location=='right'){?>selected="selected"<?php }?>>우측상단</option>
										</select>
										<select class="image_icon_over">
											<option value="n" <?php if($TPL_VAR["image_decorations"]->image_icon_over=='n'){?>selected="selected"<?php }?>>고정</option>
											<option value="y" <?php if($TPL_VAR["image_decorations"]->image_icon_over=='y'){?>selected="selected"<?php }?>>오버 시</option>
										</select>
										<div class="relative">
											<div class="absolute desc" style="left:110px; top:-48px;">
												아이콘 변경은 아이콘을 클릭하세요!
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td valign="top"><img src="/admin/skin/default/images/design/img_effect_icon.gif" /></td>
								</tr>
							</table>
						</div>
					</td>
					<td class="dsts-td" style="padding:0px;">
						<table class="goodsDisplayImageTable" width="220" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td valign="top" class="pd10">
									<table width="100%" align="right" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td><a href="javascript:;"><span class="goodsDisplayImageWrap" goodsInfo="<?php echo base64_encode(json_encode($TPL_VAR["sampleGoodsInfo"]))?>"><img src="/admin/skin/default/images/design/img_effect_sample.gif" width="100%" designElement /></span></a></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
			<!-- 게시글 이미지디스플레이 꾸미기 영역 : 끝 -->

			<tr class="titlelay" >
				<th class="dsts-th">제목 표기</th>
				<td class="dsts-td left" colspan="3">
					<input type="text" name="strcut" value="80" size="4" class="lastest_selector" /> bytes (한글 2바이트, 영문 1바이트)
				</td>
			</tr>

			<tr class="contentslay hide" >
				<th class="dsts-th">내용 표기</th>
				<td class="dsts-td left" colspan="3">
					<input type="text" name="contentcut" value="200" size="4" class="lastest_selector" /> bytes (한글 2바이트, 영문 1바이트)
				</td>
			</tr>

			<tr class="writelay hide">
				<th class="dsts-th">작성자 표기</th>
				<td class="dsts-td left" colspan="3">
					<!--//선택박스 :: START -->
					<table class="info-table-style fl" style="width:350px; margin-right:50px;">
						<tr>
							<th class="its-th-align center">선택</th>
							<th class="its-th-align center">회원</th>
							<th class="its-th-align center">비회원</th>
						</tr>
						<tr>
							<td class="its-td">
								<input type="radio" name="write_show" id="write_showid" value="ID" <?php if($TPL_VAR["write_show"]=='ID'||!$TPL_VAR["write_show"]){?> checked="checked" <?php }?> />
							</td>
							<td class="its-td">
								<label for="write_showid">아이디 4자리 (등급)</label>
							</td>
							<td class="its-td">
								<label for="write_showid">이름 (비회원)</label>
							</td>
						</tr>
						<tr>
							<td class="its-td">
								<input type="radio" name="write_show" id="write_showidnone" value="ID-NONE" <?php if($TPL_VAR["write_show"]=='ID-NONE'){?> checked="checked" <?php }?> />
							</td>
							<td class="its-td">
								<label for="write_showidnone">아이디 4자리</label>
							</td>
							<td class="its-td">
								<label for="write_showidnone">이름</label>
							</td>
						</tr>
						<tr>
							<td class="its-td">
								<input type="radio" name="write_show" id="write_showname" value="NAME" <?php if($TPL_VAR["write_show"]=='NAME'&&$TPL_VAR["write_show"]){?> checked="checked" <?php }?> />
							</td>
							<td class="its-td">
								<label for="write_showname">이름 (등급)</label>
							</td>
							<td class="its-td">
								<label for="write_showname">이름 (비회원)</label>
							</td>
						</tr>
						<tr>
							<td class="its-td">
								<input type="radio" name="write_show" id="write_shownamenone" value="NAME-NONE" <?php if($TPL_VAR["write_show"]=='NAME-NONE'&&$TPL_VAR["write_show"]){?> checked="checked" <?php }?> />
							</td>
							<td class="its-td">
								<label for="write_shownamenone">이름</label>
							</td>
							<td class="its-td">
								<label for="write_shownamenone">이름</label>
							</td>
						</tr>
						<tr>
							<td class="its-td">
								<input type="radio" name="write_show" id="write_shownic" value="NIC" <?php if($TPL_VAR["write_show"]=='NIC'&&$TPL_VAR["write_show"]){?> checked="checked" <?php }?> />
							</td>
							<td class="its-td">
								<label for="write_shownic">닉네임 (등급)</label>
							</td>
							<td class="its-td">
								<label for="write_shownic">이름 (비회원)</label>
							</td>
						</tr>
					</table>

					<table class="info-table-style fl" style="width:350px;">
						<tr>
							<th class="its-th-align center">선택</th>
							<th class="its-th-align center">회원</th>
							<th class="its-th-align center">비회원</th>
						</tr>
						<tr>
							<td class="its-td">
								<input type="radio" name="write_show" id="write_shownicnone" value="NIC-NONE" <?php if($TPL_VAR["write_show"]=='NIC-NONE'&&$TPL_VAR["write_show"]){?> checked="checked" <?php }?> />
							</td>
							<td class="its-td">
								<label for="write_shownicnone">닉네임</label>
							</td>
							<td class="its-td">
								<label for="write_shownicnone">이름</label>
							</td>
						</tr>
						<tr>
							<td class="its-td">
								<input type="radio" name="write_show" id="write_showidname" value="ID-NAME" <?php if($TPL_VAR["write_show"]=='ID-NAME'&&$TPL_VAR["write_show"]){?> checked="checked" <?php }?> />
							</td>
							<td class="its-td">
								<label for="write_showidname">이름 (아이디 4자리, 등급)</label>
							</td>
							<td class="its-td">
								<label for="write_showidname">이름 (비회원)</label>
							</td>
						</tr>
						<tr>
							<td class="its-td">
								<input type="radio" name="write_show" id="write_showidnamenone" value="ID-NAME-NONE" <?php if($TPL_VAR["write_show"]=='ID-NAME-NONE'&&$TPL_VAR["write_show"]){?> checked="checked" <?php }?> />
							</td>
							<td class="its-td">
								<label for="write_showidnamenone">이름 (아이디 4자리)</label>
							</td>
							<td class="its-td">
								<label for="write_showidnamenone">이름</label>
							</td>
						</tr>
						<tr>
							<td class="its-td">
								<input type="radio" name="write_show" id="write_showidnic" value="ID-NIC" <?php if($TPL_VAR["write_show"]=='ID-NIC'&&$TPL_VAR["write_show"]){?> checked="checked" <?php }?> />
							</td>
							<td class="its-td">
								<label for="write_showidnic">닉네임 (아이디 4자리, 등급)</label>
							</td>
							<td class="its-td">
								<label for="write_showidnic">이름 (비회원)</label>
							</td>
						</tr>
						<tr>
							<td class="its-td">
								<input type="radio" name="write_show" id="write_showidnicnone" value="ID-NIC-NONE" <?php if($TPL_VAR["write_show"]=='ID-NIC-NONE'&&$TPL_VAR["write_show"]){?> checked="checked" <?php }?> />
							</td>
							<td class="its-td">
								<label for="write_showidnicnone">닉네임 (아이디 4자리)</label>
							</td>
							<td class="its-td">
								<label for="write_showidnicnone">이름</label>
							</td>
						</tr>
					</table>
					<!--//선택박스 :: END -->
					<!--//기타선택박스 :: START -->
					<div class="cboth">
						<table cellspacing="0" cellpadding="0" border="0">
							<colgroup>
								<col width="80px" />
								<col width="20px" />
								<col />
							</colgroup>
							<tr>
								<td>└ 이름</td>
								<td>:</td>
								<td>
									<label><input type="radio" name="show_name_type" id="show_name_hid" value="HID" <?php if($TPL_VAR["show_name_type"]=='HID'||!$TPL_VAR["show_name_type"]){?> checked="checked" <?php }?> /> 홍*동</label>
									&nbsp;
									<label><input type="radio" name="show_name_type" id="show_name_all" value="ALL" <?php if($TPL_VAR["show_name_type"]=='ALL'&&$TPL_VAR["show_name_type"]){?> checked="checked" <?php }?> /> 홍길동</label>
								</td>
							</tr>
							<tr>
								<td>└ 닉네임</td>
								<td>:</td>
								<td>상기 이름 설정과 동일. 회원의 닉네임이 없을 경우</td>
							</tr>
							<tr>
								<td>└ 등급</td>
								<td>:</td>
								<td>
									<label><input type="radio" name="show_grade_type" id="show_grade_txt" value="TXT" <?php if($TPL_VAR["show_grade_type"]=='TXT'&&$TPL_VAR["show_grade_type"]){?> checked="checked" <?php }?> /> 등급명 텍스트<label>
									&nbsp;
									<label><input type="radio" name="show_grade_type" id="show_name_img" value="IMG" <?php if($TPL_VAR["show_grade_type"]=='IMG'||!$TPL_VAR["show_grade_type"]){?> checked="checked" <?php }?> /> 등급명 이미지</label>
								</td>
							</tr>
						</table>
					</div>
					<!--//기타선택박스 :: END -->					
				</td>
			</tr>

			<tr>
				<th class="dsts-th">
					(1)<br />
					게시글노출<br />
					자동방식
				</th>
				<td class="dsts-td left" colspan="3">
					<div id="goodsrevieworderbylay" class="hide">
						<div><label><input type="checkbox" name="auto_use" value="y" <?php if($TPL_VAR["data"]["auto_use"]=='y'){?>checked="checked"<?php }?> /> 체크하면 `(2)게시글노출수동방식` 대신에 ↓아래 조건에 만족하는 게시글을 자동으로 노출합니다.</label></div>
						<div class="auto_order_container pd5">
							<table class="info-table-style" width="100%">
								<col   /><col />
								<tr>
									<td class="its-td" >
										<label class="mr10"><input type="radio" name="auto_desc" value="gid"  class="lastest_selector" checked="checked"> 최근 등록순</label>
										<label class="mr10"><input type="radio" name="auto_desc" value="hit"  class="lastest_selector"> 조회수가 높은순</label>
										<label class="mr10"><input type="checkbox" name="auto_order_seq" value="1"  class="lastest_selector"> 구매한 후기</label>
										<label class="mr10"><input type="checkbox" name="auto_upload" value="1"  class="lastest_selector"> 포토 후기</label>
										<label><input type="checkbox" name="auto_best" value="checked"  class="lastest_selector"> 베스트 후기</label>
									</td>
									<td class="its-td-align center">
										<label class="mr10"><input type="radio" name="auto_term_type" value="relative" checked="checked" /> 최근 <input type="text" name="auto_term" value="999" size="4" maxlength="4" class="lastest_selector onlynumber" />일 </label>
										<label><input type="radio" name="auto_term_type" value="absolute" <?php if($TPL_VAR["data"]["auto_term_type"]=='absolute'){?>checked="checked"<?php }?> /> 고정 </label><input type="text" name="auto_start_date" value="<?php if($TPL_VAR["data"]["auto_start_date"]!='0000-00-00'){?><?php echo $TPL_VAR["data"]["auto_start_date"]?><?php }?>" size="11" maxlength="10" class="lastest_selector datepicker" /> ~ <input type="text" name="auto_end_date" value="<?php if($TPL_VAR["data"]["auto_end_date"]!='0000-00-00'){?><?php echo $TPL_VAR["data"]["auto_end_date"]?><?php }?>" size="11" maxlength="10" class="lastest_selector datepicker" />
									</td>
								</tr>
							</table>
							<div class="desc pd5" >
								※ 단, 상품상세페이지에서 '게시판 넣기'를 적용하면 상품의 상품후기<br/>
								※ 단, 카테고리페이지에서 '게시판 넣기'를 적용하면  카테고리의 상품후기<br/>
								※ 단, 브랜드페이지에서  '게시판 넣기'를 적용하면 브랜드의 상품후기<br/>
								※  베스트 후기란 관리자가 체크한 베스트 상품후기를 말합니다.<br/>
							</div>
						</div>
					</div>
					<div id="boardorderbylay" >
						<div>↓아래 조건에 만족하는 게시글을 자동으로 노출합니다.</div>
						<div class="pd5">
							<table class="info-table-style" width="98%">
								<col width="50%" /><col width="50%" />
								<tr>
									<td class="its-td" >
										<label class="mr10"><input type="radio" name="none_auto_desc" value="gid"  class="lastest_selector" checked="checked"> 최근 등록순</label>
										<label class="mr10"><input type="radio" name="none_auto_desc" value="hit"  class="lastest_selector" > 조회수가 높은순</label>
										<label ><input type="checkbox" name="none_auto_upload" value="1" class="lastest_selector" /> 포토 게시글</label>
									</td>
									<td class="its-td-align center">
										<label class="mr10"><input type="radio" name="none_auto_term_type" value="relative" checked="checked" /> 최근 <input type="text" name="none_auto_term" value="999" size="4" maxlength="4" class="lastest_selector onlynumber" />일</label>
										<label><input type="radio" name="none_auto_term_type"  value="absolute" <?php if($TPL_VAR["data"]["auto_term_type"]=='absolute'){?>checked="checked"<?php }?> /> 고정 </label><input type="text" name="none_auto_start_date" value="<?php if($TPL_VAR["data"]["auto_start_date"]!='0000-00-00'){?><?php echo $TPL_VAR["data"]["auto_start_date"]?><?php }?>" size="11" maxlength="10" class="lastest_selector datepicker" /> ~ <input type="text" name="none_auto_end_date" value="<?php if($TPL_VAR["data"]["auto_end_date"]!='0000-00-00'){?><?php echo $TPL_VAR["data"]["auto_end_date"]?><?php }?>" size="11" maxlength="10" class="lastest_selector datepicker" />
									</td>
								</tr>
							</table>
						</div>
					</div>
				</td>
			</tr>
			<tr class="goods_select_container">
				<th class="dsts-th">
					(2)<br />
					게시글노출<br />
					수동방식<br />
					<span class="btn small gray"><button type="button" id="displayBoardButton">게시글 선택</button></span><br />
					<span class="desc" style="font-weight:normal;">노출순서변경</span> <span class="helpicon" title="게시글을 마우스로 드래그&드랍해서 조정합니다."></span>
				</th>
				<td class="dsts-td left" colspan="3">
					<div class="clearbox" style="height:5px;"></div>
					<div id="displayBoard"> </div>
				</td>
			</tr>
			<tr id="displayBoardSelectContainer" class="displayBoardContainer hide">
				<td colspan="4" class="dsts-td" style="padding:0px;">
					<div id="displayBoardSelect" class="displayBoardSelect" style="border:5px solid #Fff"></div>
				</td>
			</tr>
		</table>

		<div class="center pd20">
			<span class="btn large cyanblue"><input type="button" onclick="lastestinsert()" value="적용" /></span>
		</div>
	</div>
</form>

<!-- 아이콘 선택 -->
<div id="displayImageIconPopup" class="hide">
	<form enctype="multipart/form-data" method="post" action="../design_process/display_icon_upload" target="actionFrame">
	<input type="hidden" name="uniqueKey" value="" />
	<ul></ul>
	<div class="clearbox"></div>
	<div style="padding-top:15px;">
	<input type="file" name="displayImageIconImg" /> <span class="btn small black"><button type="submit">추가</button></span>
	</div>
	</form>
</div>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>