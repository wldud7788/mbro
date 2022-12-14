<?php /* Template_ 2.2.6 2022/05/17 12:31:34 /www/music_brother_firstmall_kr/admin/skin/default/design/display_insert_light.html 000007526 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<script type="text/javascript">
	$(function(){
<?php if($TPL_VAR["template_path"]){?>
		parent.DM_window_title_set("left","<a href=\"javascript:;\" onmousedown=\"DM_window_sourceeditor('<?php echo $TPL_VAR["template_path"]?>')\">◀ HTML소스보기</a>");
<?php }?>
		parent.DM_window_title_set("center","<?php echo $TPL_VAR["layout_config"]["tpl_desc"]?>(<?php echo $TPL_VAR["layout_config"]["tpl_path"]?>)에 선택한 ");
		parent.DM_window_title_set("title","상품디스플레이 넣기");

		load_display_list(1);
	});

	// 태그복사 버튼
	function tag_clipboard_copy(seq){
		var tag_display	= "{" + "=showDesignDisplay(" + seq + ")" + "}";
		clipboard_copy(tag_display);
		alert('상품디스플레이 태그가 복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.');
	}

	function list_all_chk(obj){
		if($(obj).attr("checked")){
			$(".chk_display").attr("checked",true).change();
		}else{
			$(".chk_display").attr("checked",false).change();
		}
	}

	/* 상품디스플레이목록 불러오기 */
	function load_display_list(page){
		page = page ? page : 1;

		$(".designDisplayInsertEdit div.dlts-body").load("../design/get_display_list_light?platform=<?php echo $_GET["platform"]?>&displaykind=<?php echo $_GET["displaykind"]?>&page="+page);
	}

	function select_display(display_seq,image,style,platform){
		// 디스플레이 정보 호출
		$('input[name="paging"]').prop('disabled',false);
		$.ajax({
			type: "GET",
			url: "/admin/design/display_info",
			data: "display_seq="+display_seq,
			dataType: "json",
			success: function(result){
				if	(result.cnt > 1 && platform != 'mobile') {
	//				openDialogAlert('페이징이 되는 상품디스플레이는 탭 기능을 사용할 수 없습니다.',450,140);
					$('input[name="paging"]').prop('disabled',true);
	//				return;
				}
				if	(result.limit_func) {
					$.each(result.limit_func,function(k, v){
						$.each(v,function(){
							$('.'+this).prop('disabled',true);
						});
					});
				}

				$("#displayAdminComment").text($(".admin_comment[display_seq='"+display_seq+"']").text()+' ('+$(".select_style[display_seq='"+display_seq+"']").text()+')');
				$("form[name='displayManagerForm'] input[name='display_seq']").val(display_seq);

				openDialog("상품디스플레이 삽입하기", "#set_display_wrap", {"width":"530","height":"460","show" : "fade","hide" : "fade"});
			}
		});
	}

	function edit_display(display_seq, displaykind, platform){
		parent.DM_window_display_edit('<?php echo $TPL_VAR["template_path"]?>',display_seq,'','', displaykind, platform);
	}

	function copy_display(display_seq){
		openDialogConfirm('상품디스플레이를 복사하시겠습니까?',400,140,function(){
			loadingStart();
			$("iframe[name='actionFrame']").attr('src','../design_process/copy_display?display_seq=' + display_seq);
		});
	}

	function delete_display(){
		var display_seqs = new Array();
		$("input[name='delete_display_seq[]']:checked").each(function(){
			display_seqs.push($(this).val());
		});

		if(display_seqs.length){
			openDialogConfirm('상품디스플레이를 삭제하시겠습니까?',400,140,function(){
				loadingStart();
				$("iframe[name='actionFrame']").attr('src','../design_process/delete_display?display_seqs=' + encodeURIComponent(display_seqs.join(',')));
			});
		}else{
			openDialogAlert('삭제할 상품디스플레이를 선택해주세요',400,140);
		}
	}
</script>
<style type="text/css">
	.designDisplayInsertEdit{padding:35px 15px 0 15px}
	.designDisplayInsertEdit .displayDesignTop{clear:left;height:25px}
	.designDisplayInsertEdit .displayDesignTop .left-tit-light{position:absolute;left:15px;top:25px}
	.designDisplayInsertEdit .displayDesignTop .right-tit-light{position:absolute;right:15px;top:25px}
	#set_display_wrap .paging_list span{display:inline-block; width:150px}
	##set_display_wrap .paging_list span:first-child{width:80px;}
</style>

<div class="designDisplayInsertEdit">
	<div class="displayDesignTop">
		<span class="left-tit-light">
			<span class="btn small"><button onclick="delete_display();">선택 삭제</button></span>
		</span>
		<span class="right-tit-light btn small black">
			<input type="button" value="상품디스플레이 만들기" onclick="edit_display('','<?php echo $_GET["displaykind"]?>','<?php echo $_GET["platform"]?>')" />
		</span>
	</div>

	<div class="dlts-body" style="max-height:450px;"></div>
	<div style="height:3px;"></div>
</div>

<div id="set_display_wrap" class="hide pd15">
	<form name="displayManagerForm" action="../design_process/display_insert" method="post" target="actionFrame">
	<input type="hidden" name="template_path" value="<?php echo $TPL_VAR["template_path"]?>" />
	<input type="hidden" name="display_seq" value="" />
	<input type="hidden" name="tab_type" value="N" />

	<table class="info-table-style" width="100%" align="center">
		<col width="140" />
		<tr>
			<th class="its-th-align">
				삽입 상품디스플레이
			</th>
			<td class="its-td-align left">
				<div id="displayAdminComment"></div>
			</td>
		</tr>
		<tr>
			<th class="its-th-align">삽입 페이지</th>
			<td class="its-td-align left"><?php echo $TPL_VAR["layout_config"]["tpl_desc"]?> (<?php echo $TPL_VAR["layout_config"]["tpl_path"]?>)</td>
		</tr>
		<tr>
			<th class="its-th-align">
				삽입 위치
			</th>
			<td class="its-td-align left">
				<div class="imageCheckboxContainer">
					<div class="imageCheckboxItem"><label><input type="radio" name="location" value="top" checked="checked" /><img src="/admin/skin/default/images/design/img_layout_up.gif" /></label></div>
					<div class="imageCheckboxItem"><label><input type="radio" name="location" value="bottom" /><img src="/admin/skin/default/images/design/img_layout_down.gif" /></label></div>
				</div>
			</td>
		</tr>
		<tr>
			<th class="its-th-align">
				페이징
			</th>
			<td class="its-td-align left">
				<ul class="paging_list">
					<li>
						<label><input type="radio" name="paging" value="0" checked="checked" /> 페이징 없음</label>
					</li>
					<li>
						<span><label><input type="radio" name="paging" class="insert_paging_1" value="1" /> < 1 2 3 4 ></label></span>
						<span>페이징 : <input type="text" name="perpage1" maxlength="3" size="3" value="20" class="line number"/> 개/페이지</span>
					</li>
					<li>
						<span><label><input type="radio" name="paging" class="insert_paging_2" value="2" /> 더보기</label></span>
						<span>페이징 : <input type="text" name="perpage2" maxlength="3" size="3" value="20" class="line number"/> 개/페이지</span>
					</li>
					<li>
						<span><label><input type="radio" name="paging" class="insert_paging_3" value="3" /> 스크롤</label></span>
						<span>페이징 : <input type="text" name="perpage3" maxlength="3" size="3" value="20" class="line number"/> 개/페이지</span>
					</li>
				</ul>
			</td>
		</tr>
	</table>
	<div style="height:15px"></div>

	<div class="center">
		<span class="btn medium cyanblue"><input type="submit" value="삽입" /></span>
	</div>

	</form>
</div>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>