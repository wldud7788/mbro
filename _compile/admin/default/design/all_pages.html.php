<?php /* Template_ 2.2.6 2022/05/17 12:31:32 /www/music_brother_firstmall_kr/admin/skin/default/design/all_pages.html 000008284 */ 
$TPL_folders_1=empty($TPL_VAR["folders"])||!is_array($TPL_VAR["folders"])?0:count($TPL_VAR["folders"]);
$TPL_boards_1=empty($TPL_VAR["boards"])||!is_array($TPL_VAR["boards"])?0:count($TPL_VAR["boards"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<script type="text/javascript">	
	var selectUrl = '';
	$(function(){
		
		parent.DM_window_title_set("title","전체 페이지 - <?php echo htmlspecialchars($TPL_VAR["skin"])?>");
		
		$(".tpl_list li span.btn").click(function(){
			$(".tpl_list li span.btn").removeClass('selected');
			$(this).addClass('selected');

			var file_type = $(".tpl_list li span.btn.selected").attr("file_type");
			if(file_type=='layout') $(".copybtn").hide();
			else $(".copybtn").show();
			
			$(".selected_tpl_path").html(get_selected_tpl_path());			
			
			if($(this).attr('tpl_page')){
				$("#selected_url_delete").removeAttr("disabled");
				$("#selected_url_delete").parent().addClass("red");
			}else{
				$("#selected_url_delete").attr("disabled",true);
			//	$("#selected_url_delete").parent().removeClass("red");
			}

			selectUrl = $(this).attr('url');
		});

		$('#selected_url_copy').click(function(){
			if(selectUrl != ''){
				clipboard_copy(selectUrl);
				alert("주소가 복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.");
			}
		});
		
		$(".tpl_list li span.btn.selected").click();
	});

	function get_selected_tpl_path(){
		var tpl_path = $(".tpl_list li span.btn.selected").attr("tpl_path");
		if(!tpl_path){
			openDialogAlert("페이지를 선택해주세요.",400,140);
			return false;
		}
		return tpl_path;
	} 

	function del_selected_tpl_path(){
		openDialogConfirm("정말 삭제하시겠습니까?",400,140,function(){
				
			var frm = $("form[name='processForm']");
			frm.attr("action","../design_process/tpl_file_delete")
			
			$("input[name='tpl_path']",frm).val($(".tpl_list li span.btn.selected").attr("tpl_path"));
			
			frm.submit();
		});
	}

	function go_window_sourceeditor(){
		if(get_selected_tpl_path()) parent.DM_window_sourceeditor(get_selected_tpl_path());
	}

	function go_window_layout(){
		var file_type = $(".tpl_list li span.btn.selected").attr("file_type");
		var file_type_msg = $(".tpl_list li span.btn.selected").attr("file_type_msg");
		if(file_type_msg){
			openDialogAlert(file_type_msg,600,160);
		}else{
			if(get_selected_tpl_path()) parent.DM_window_layout(get_selected_tpl_path());
		}
	}
</script>
<style type="text/css">
	.all_pages_header {height:25px; padding:15px 15px 0;}
	.all_pages_header .selected_tpl_path {font-weight:bold;}
	.all_pages_body {padding:15px; /*height:536px; overflow:auto;*/}
	.all_pages_body table {border-bottom:1px solid #e0e0e0;}
	.all_pages_body .tpl_directory {border-top:1px solid #e0e0e0; text-align:left; padding:15px 0 0 20px; /*margin-bottom:5px;*/}
	.all_pages_body .tpl_list {border-top:1px solid #e0e0e0; border-left:0px solid #eee; padding:10px; /*padding-top:2px; padding-bottom:20px;*/}
	.all_pages_body .tpl_list li {display:inline-block; width:24%; line-height:20px; overflow:hidden;}
	.all_pages_body .tpl_list li span {display:block; border:1px solid #fff; background:#fff;}
	.all_pages_body .tpl_list li span.selected {border-color:#6ac9f3; background:#e4f6fe;}
	.all_pages_body .tpl_list li span button {width:100%; line-height:20px; border:none; background:transparent; text-align:left; text-indent:10px; cursor:pointer; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
</style>

<form name="processForm" target="actionFrame" method="post">
<input type="hidden" name="tpl_path" value="" />
</form>

<div class="all_pages_header">
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin:auto">
		<tr>
			<td width="180" align="left">
				<!-- <a href="#" onclick="parent.DM_window_layout_create();return false;"><img src="/admin/skin/default/images/design/btn_all_newpage.gif" /></a> -->
				<span class="btn small"><input type="button" onclick="parent.DM_window_layout_create();return false;" value="새 페이지 만들기" /></span>
			</td>
			<td align="left">
				선택파일 : <span class="selected_tpl_path"></span> 
				&nbsp;<span class="btn small copybtn"><input type="button" id="selected_url_copy" value="주소복사" /></span>
				<span class="btn small gray"><input type="button" id="selected_url_delete" value="삭제" disabled onclick="del_selected_tpl_path()" /></span> 
			</td>
			<td align="right">
				<span>선택된 페이지의&nbsp;</span>
				<!-- <a href="#" onclick="go_window_sourceeditor();return false;"><img src="/admin/skin/default/images/design/btn_all_html.gif" align="absmiddle" /></a>
				<a href="#" onclick="go_window_layout();return false;"><img src="/admin/skin/default/images/design/btn_all_design.gif" align="absmiddle" /></a> -->
				<span class="btn small cyanblue"><input type="button" onclick="go_window_sourceeditor();return false;" value="HTML소스 편집" /></span>
				<span class="btn small cyanblue"><input type="button" onclick="go_window_layout();return false;" value="레이아웃 설정" /></span>
			</td>
		</tr>
	</table>
</div>
<div class="all_pages_body">
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="margin:auto">	
<?php if($TPL_folders_1){foreach($TPL_VAR["folders"] as $TPL_V1){?>
		<tr>
			<th width="160" valign="top">
				<!-- <div class="tpl_directory"><span class="btn bluegreen"><button style="width:96px;text-align:left"><span style="display:inline-block;width:20px;text-align:center;"><img src="/admin/skin/default/images/design/icon_<?php echo $TPL_V1["icon"]?>_all.gif" align="absmiddle" onerror="this.style.display='none'" /></span> <?php echo $TPL_V1["name"]?></button></span></div> -->
				<div class="tpl_directory"><?php echo $TPL_V1["name"]?></div>
			</th>
			<td>		
				<ul class="tpl_list">
<?php if($TPL_V1["files"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["files"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<li>
							<span class="btn <?php if($TPL_V2["path"]==$TPL_VAR["tpl_path"]){?>selected<?php }?>" tpl_page="<?php echo $TPL_V2["tpl_page"]?>" tpl_path="<?php echo $TPL_V2["path"]?>" url="<?php echo $TPL_V2["url"]?>" <?php if($TPL_V2["file_type"]){?>file_type="<?php echo $TPL_V2["file_type"]?>"<?php }?> <?php if($TPL_V2["file_type_msg"]){?>file_type_msg="<?php echo $TPL_V2["file_type_msg"]?>"<?php }?>><button><?php echo $TPL_V2["desc"]?></button></span>
						</li>
<?php }}?>
<?php }else{?>
					<li>&nbsp;</li>
<?php }?>
				</ul>
			</td>
		</tr>
<?php }}?>
<?php if($TPL_boards_1){foreach($TPL_VAR["boards"] as $TPL_V1){?>
<?php if($TPL_V1["files"]){?>
		<tr>
			<th valign="top">
				<!-- <div class="tpl_directory"><span class="btn bluegreen"><button style="width:96px;text-align:left"><span style="display:inline-block;width:20px;text-align:center;"><img src="/admin/skin/default/images/design/icon_<?php echo $TPL_V1["icon"]?>_all.gif" align="absmiddle" onerror="this.style.display='none'" /></span> <?php echo $TPL_V1["name"]?></button></span></div> -->
				<div class="tpl_directory"><?php echo $TPL_V1["name"]?></div>
			</th>
			<td>		
				<ul class="tpl_list">
<?php if($TPL_V1["files"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["files"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<li>
							<span class="btn <?php if($TPL_V2["path"]==$TPL_VAR["tpl_path"]){?>selected<?php }?>" tpl_page="<?php echo $TPL_V2["tpl_page"]?>" tpl_path="<?php echo $TPL_V2["path"]?>" url="<?php echo $TPL_V2["url"]?>" <?php if($TPL_V2["file_type"]){?>file_type="<?php echo $TPL_V2["file_type"]?>"<?php }?> <?php if($TPL_V2["file_type_msg"]){?>file_type_msg="<?php echo $TPL_V2["file_type_msg"]?>"<?php }?>><button><?php echo $TPL_V2["desc"]?></button></span>
						</li>
<?php }}?>
<?php }else{?>
					<li>&nbsp;</li>
<?php }?>
				</ul>
			</td>
		</tr>
<?php }?>
<?php }}?>		
	</table>
</div>
<br /><br />

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>