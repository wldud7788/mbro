<?php /* Template_ 2.2.6 2022/05/17 12:31:38 /www/music_brother_firstmall_kr/admin/skin/default/design/popup_insert_light.html 000003488 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<script type="text/javascript">
	/* 태그복사버튼 객체 목록 */
	var tagCopyClips = [];

	$(function(){
<?php if($TPL_VAR["template_path"]){?>
		parent.DM_window_title_set("left","<a href=\"javascript:;\" onmousedown=\"DM_window_sourceeditor('<?php echo $TPL_VAR["template_path"]?>')\">◀ HTML소스보기</a>");
<?php }?>
		parent.DM_window_title_set("center","<?php echo $TPL_VAR["layout_config"]["tpl_desc"]?>(<?php echo $TPL_VAR["layout_config"]["tpl_path"]?>)에 선택한 ");
		load_popup_list();
	});

	/* 팝업목록 불러오기 */
	function load_popup_list(){
		$(".dlts-body").load("../design/get_popup_list_light_html");
	}

	// 태그복사 버튼
	function tag_clipboard_copy(seq){
		var tag_display	= "{" + "=showDesignLightPopup(" + seq + ")" + "}";
		clipboard_copy(tag_display);
		alert('팝업 태그가 복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.');
	}

	// 전체 체크
	function list_all_chk(obj){
		if($(obj).attr("checked")){
			$(".chk_display").attr("checked",true).change();
		}else{
			$(".chk_display").attr("checked",false).change();
		}
	}

	// 팝업 삽입 :: 2018-12-14 lwh
	function insert_popup(popup_seq){

		$("form[name='popupManagerForm'] input[name='popup_seq']").val(popup_seq);
		$("form[name='popupManagerForm']").submit();
	}

	function edit_popup(popup_seq,banner_type){
		parent.DM_window_popup_edit('<?php echo $TPL_VAR["template_path"]?>',popup_seq,null,banner_type);
	}

	function copy_popup(popup_seq){
		openDialogConfirm('팝업을 복사하시겠습니까?',400,140,function(){
			loadingStart();
			$("iframe[name='actionFrame']").attr('src','../design_process/copy_popup?popup_seq=' + popup_seq);
		});
	}

	function delete_popup(){
		var popup_seqs = new Array();
		$("input[name='delete_popup_seq[]']:checked").each(function(){
			popup_seqs.push($(this).val());
		});

		if(popup_seqs.length){
			openDialogConfirm('팝업을 삭제하시겠습니까?',400,140,function(){
				loadingStart();
				$("iframe[name='actionFrame']").attr('src','../design_process/delete_popup?popup_seqs=' + encodeURIComponent(popup_seqs.join(',')));
			});
		}else{
			openDialogAlert('삭제할 팝업을 선택해주세요',400,140);
		}
	}
</script>

<div style="height:15px"></div>
<div class="pd15">
	<div class="pdb10 fl">
		<span class="btn small"><button onclick="delete_popup()"><input type="checkbox" checked onclick="return false;" style="width:10px ;height:10px;vertical-align:middle"/> 삭제</button></span>
	</div>
	<div class="bdb10 fr">
		<span class="btn small black"><input type="button" value="띠배너 만들기" onclick="edit_popup(null,'band');" /></span>
		<span class="btn small black"><input type="button" value="팝업 만들기" onclick="edit_popup(null,'layer');" /></span>
	</div>

	<form name="popupManagerForm" action="../design_process/popup_insert" method="post" target="actionFrame">
	<input type="hidden" name="template_path" value="<?php echo $TPL_VAR["template_path"]?>" />
	<input type="hidden" name="popup_seq" value="" />
	</form>

	<div class="dlts-body" style="max-height:450px;"></div>
</div>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>