<?php /* Template_ 2.2.6 2022/05/17 12:31:33 /www/music_brother_firstmall_kr/admin/skin/default/design/banner_insert.html 000007489 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<script type='text/javascript' src='/app/javascript/plugin/anibanner/jquery.anibanner.js'></script>
<link rel='stylesheet' type='text/css' href='/app/javascript/plugin/anibanner/anibanner.css' />
<script type="text/javascript">
	/* 태그복사버튼 객체 목록 */
	var tagCopyClips = [];

	$(function(){
<?php if($TPL_VAR["template_path"]){?>
		parent.DM_window_title_set("left","<a href=\"javascript:;\" onmousedown=\"DM_window_sourceeditor('<?php echo $TPL_VAR["template_path"]?>')\">◀ HTML소스보기</a>");
<?php }?>
		parent.DM_window_title_set("center","<?php echo $TPL_VAR["layout_config"]["tpl_desc"]?>(<?php echo $TPL_VAR["layout_config"]["tpl_path"]?>)에 선택한 ");

		load_banner_list();
	});

	/* 파일업로드버튼 ajax upload 적용 */
	function setAjaxUpload(selector){
		var opt			= {};
		var callback	= function(res){
			var that		= this;
			var result		= eval(res);

			if(result.status){
				$(that).closest('.webftpFormItem').find('.webftpFormItemPreview').attr('src', result.filePath + result.fileInfo.file_name);
				$(that).closest('.webftpFormItem').find('.webftpFormItemPreview').show();
				$(that).closest('.webftpFormItem').find('.webftpFormItemInput').val( 'data/tmp/' + result.fileInfo.file_name);
			}else{
				alert(result.msg);
			}
		};

		// ajax 이미지 업로드 이벤트 바인딩
		$(selector).createAjaxFileUpload(opt, callback);
	}

	/* 배너목록 불러오기 */
	function load_banner_list(){

		/* 리스트 호출 */
		$("#bannerListTable table.dlts-inner-table tbody").load("../design/get_banner_list_html");
	}

	/* 배너 선택 */
	function select_banner(banner_seq,platform,style_id){
		$("#bannerAdminComment").text($(".admin_comment[banner_seq='"+banner_seq+"']").text());
		$("#bannerPreview").empty();
		$.ajax({
			'url' : 'banner_html_ajax',
			'data' : {'banner_seq':banner_seq},
			'global' : false,
			'success' : function(html){
				$("#bannerPreviewContainer").attr('align','center');
				if(platform=='mobile'){
					$("#bannerPreviewContainer").css({'width':'320px','margin':'auto'});
				}
				$("#bannerPreview").html(html);
				if(platform != 'mobile'){
					$("#bannerPreviewContainer").css('height', 'auto');
				}
			}
		});

		$("#bannerPreviewContainer").show();
		$("form[name='bannerManagerForm'] input[name='banner_seq']").val(banner_seq);
		$("form[name='bannerManagerForm'] input[name='platform']").val(platform);
		$("form[name='bannerManagerForm'] input[name='style_id']").val(style_id);
	}

	/* 배너 만들기 */
	function create_banner(){
		parent.DM_window_banner_create('<?php echo $TPL_VAR["template_path"]?>');
	}

	/* 배너 수정 */
	function edit_banner(banner_seq){
		parent.DM_window_banner_edit('<?php echo $TPL_VAR["template_path"]?>',banner_seq);
	}

	/* 배너 삭제 */
	function delete_banner(){
		var banner_seqs = new Array();
		$("input[name='delete_banner_seq[]']:checked").each(function(){
			banner_seqs.push($(this).val());
		});

		if(banner_seqs.length){
			openDialogConfirm('배너를 삭제하시겠습니까?',400,140,function(){
				loadingStart();
				$("iframe[name='actionFrame']").attr('src','../design_process/delete_banner?banner_seqs=' + encodeURIComponent(banner_seqs.join(',')) + '&template_path=<?php echo $TPL_VAR["template_path"]?>');
			});
		}else{
			openDialogAlert('삭제할 배너를 선택해주세요',400,140);
		}
	}

	// 태그복사 버튼
	function tag_clipboard_copy(seq){
		var tag_display	= "{" + "=showDesignBanner(" + seq + ")" + "}";
		clipboard_copy(tag_display);
		alert('슬라이드배너 태그가 복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.');
	}
</script>
<style>
	#bannerPreviewContainer {margin:auto 15px; min-height:20px; padding:10px;  border:1px solid #ddd; text-align:center;}
</style>

<div style="height:15px"></div>
<div id="bannerPreviewContainer" class="hide">	
	<div id="bannerPreview">
	</div>
</div>

<div style="padding:15px;">
	<form name="bannerManagerForm" action="../design_process/banner_insert" method="post" target="actionFrame">
	<input type="hidden" name="template_path" value="<?php echo $TPL_VAR["template_path"]?>" />
	<input type="hidden" name="platform" value="" />
	<input type="hidden" name="banner_seq" value="" />
	<input type="hidden" name="style_id" value="" />

	<table class="design-simple-table-style" width="100%" align="center">
		<col width="140" />
		<tr>
			<th class="dsts-th">
				삽입 배너
			</th>
			<td class="dsts-td left">
				<div id="bannerAdminComment"></div>
			</td>
		</tr>
		<tr>
			<th class="dsts-th">
				삽입 위치
			</th>
			<td class="dsts-td left">
				<div class="imageCheckboxContainer">
					<div class="imageCheckboxItem"><label><input type="radio" name="location" value="top" checked="checked" /><img src="/admin/skin/default/images/design/img_layout_up.gif" /></label></div>
					<div class="imageCheckboxItem"><label><input type="radio" name="location" value="bottom" /><img src="/admin/skin/default/images/design/img_layout_down.gif" /></label></div>
				</div>
			</td>
		</tr>
	</table>
	<div style="height:15px"></div>

	<div class="center">
		<span class="btn large cyanblue"><input type="submit" value="적용" /></span>
	</div>
	</form>
	<div style="height:20px"></div>

	<table id="bannerListTable" class="design-list-table-style" width="100%">
		<colgroup>
			<col width="60" />
			<col width="" />
			<col width="80" />
			<col width="180" />
			<col width="100" />
			<col width="180" />
			<col width="100" />
		</colgroup>
		<thead>
			<tr>
				<th class="dlts-th left" colspan="5">
					<b>슬라이드 배너 리스트</b> <span class="desc" style="font-weight:normal;"> - 어느 페이지에서도 슬라이드 배너를 재활용하여 넣을 수 있습니다!</span>
				</th>
				<th class="dlts-th right" colspan="2">
					<span class="btn small black"><input type="button" value="슬라이드 배너 만들기" onclick="create_banner()" /></span>
				</th>
			</tr>
			<tr>
				<th class="dlts-th center">번호</th>
				<th class="dlts-th center">적용스킨</th>
				<th class="dlts-th center">만든 날짜</th>
				<th class="dlts-th center">배너명</th>
				<th class="dlts-th center">스타일명</th>
				<th class="dlts-th center">치환코드</th>
				<th class="dlts-th center">관리</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="7">
					<div class="dlts-body">
						<table width="100%" class="dlts-inner-table">
							<colgroup>
								<col width="60" />
								<col width="" />
								<col width="80" />
								<col width="180" />
								<col width="100" />
								<col width="180" />
								<col width="100" />
							</colgroup>
							<tbody>
							</tbody>
						</table>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<div style="height:10px"></div>

	<span class="btn small"><button onclick="delete_banner()"><input type="checkbox" checked onclick="return false;" style="width:10px ;height:10px; vertical-align:middle;"/> 삭제</button></span>
</div>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>