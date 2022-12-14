<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/design/eye_editor.html 000029032 */ ?>
<!DOCTYPE HTML>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqcontextmenu/jquery.contextMenu.css" />
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
<script type="text/javascript" src="/app/javascript/plugin/jstree/jquery.jstree.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jqcontextmenu/jquery.contextMenu.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<style type="text/css">
	body {overflow:hidden}
	#wrap {min-width:700px}

	#EyeEditorTitle a {color:#fff;}
	#EyeEditorTitle {position:relative; height:40px; line-height:40px; color:#fff; background-color:#545454; border-bottom:3px solid #bbb;}
	#EyeEditorTitle .EETTextLeft {position:absolute; width:150px; left:15px; top:0px; height:40px; line-height:40px; background:url('/admin/skin/default/images/design/logo_eye_editor.gif') no-repeat left center}
	#EyeEditorTitle .EETTextRight {position:absolute; right:10px; margin-left:-5px; top:0px; height:40px; line-height:40px; text-align:right;}
	#EyeEditorTitle .EETTextCenter {text-align:center; height:40px; line-height:38px; border-bottom:1px solid #333;}
	#EyeEditorTitle .EETTextCenter .title {font-weight:bold;}
	#EyeEditorTitle .EETTextCenter .prefix {}

	#EyeEditorTabContainer {height:25px; background:url('/admin/skin/default/images/design/editor_tab_bg_bar.gif'); border-top:2px solid #ddd;}
	#EyeEditorTabContainer li.EETCItem {float:left; height:25px; cursor:pointer; position:relative;}
	#EyeEditorTabContainer li.EETCItem div {height:21px; padding:4px 30px 0 10px; background:url('/admin/skin/default/images/design/editor_tab_bg_center.gif');}
	#EyeEditorTabContainer li.EETCItemDefault {float:left; height:25px; cursor:pointer; position:relative;}
	#EyeEditorTabContainer li.EETCItemDefault div {height:21px; padding:4px 30px 0 10px; background:url('/admin/skin/default/images/design/editor_tab_bg_center.gif');}
	#EyeEditorTabContainer li.EETCItemSelected {cursor:default;}
	#EyeEditorTabContainer li.EETCItemSelected div {background:url('/admin/skin/default/images/design/editor_tab_bg_select_center.gif');}
	#EyeEditorTabContainer li.EETCItemLeft {background:url('/admin/skin/default/images/design/editor_tab_bg_left.gif') no-repeat; padding-left:5px;}
	#EyeEditorTabContainer li.EETCItemAdjoin {background:url('/admin/skin/default/images/design/editor_tab_bg_adjoin.gif') no-repeat; padding-left:9px;}
	#EyeEditorTabContainer li.EETCItemRight {background:url('/admin/skin/default/images/design/editor_tab_bg_right.gif') no-repeat; padding-left:7px;}
	#EyeEditorTabContainer li.EETCItemSelectedLeft {background:url('/admin/skin/default/images/design/editor_tab_bg_select_left.gif') no-repeat; padding-left:8px;}
	#EyeEditorTabContainer li.EETCItemSelectedRight {background:url('/admin/skin/default/images/design/editor_tab_bg_select_right.gif') no-repeat; padding-left:8px;}
	#EyeEditorTabContainer li.EETCAddBtn {cursor:pointer}
	#EyeEditorTabContainer li.EETCAddBtn div {height:18px; padding:4px 5px 0 4px;}
	#EyeEditorTabContainer li.EETCItem span.closebtn {position:absolute; display:none; width:8px; height:8px; border:1px solid transparent; left:100%; padding:1px; margin-left:-15px; top:6px; background:url('/admin/skin/default/images/design/editor_tab_close.gif') no-repeat 1px 1px;}
	#EyeEditorTabContainer li.EETCItemSelected span.closebtn {display:block; cursor:pointer;}
	#EyeEditorTabContainer li.EETCItemSelected span.closebtn:hover {border:1px solid #666;}
	#EyeEditorTabContainer li.EETCItem .EETCItemMark {color:red; font-size:15px; line-height:11px; font-weight:bold; display:none;}
	#EyeEditorTabContainer li.EETCItemModified .EETCItemName {}

	#EyeEditorContentsContainer {}
	#EyeEditorContentsContainer div.EECCItem {display:none}

	.EyeEditorSideBlank {display:none;width:200px;}

	#EyeEditorFileAddLayer {position:relative; display:none;}
	.DMWindow {z-index:1000; position:absolute; margin:auto; }
	.DMWindowTitle a {color:#fff;}
	.DMWindowTitle {position:relative; height:34px; line-height:34px; color:#fff; padding:0 3px;}
	.DMWindowTitle .DMWTTextLeft {position:absolute; width:40%; left:10px; top:0px; height:34px; line-height:34px;}
	.DMWindowTitle .DMWTTextLeft a {color:#00ccff; font-weight:bold;}
	.DMWindowTitle .DMWTTextRight {position:absolute; width:40%; left:60%; margin-left:-10px; top:0px; height:34px; line-height:34px;}
	.DMWindowTitle .DMWTTextCenter {text-align:center; background:url('/admin/skin/default/images/design/win_top_center.gif') repeat-x;}
	.DMWindowTitle .DMWTTextCenter .title {font-weight:bold;}
	.DMWindowTitle .DMWTTextCenter .prefix {}
	.DMWindowTitle .DMWTBgLeft {position:absolute; left:0px; top:0px; width:100%; height:34px; background:url('/admin/skin/default/images/design/win_top_left.gif') no-repeat left top;}
	.DMWindowTitle .DMWTBgRight {position:absolute; left:0px; top:0px; width:100%; height:34px; background:url('/admin/skin/default/images/design/win_top_right.gif') no-repeat right top;}
	.DMWindowTitle .DMWTClose {position:absolute; left:100%; top:5px; margin-left:-31px; cursor:pointer;}

	.DMWindowBody {background-color:#fff; border-left:1px solid #333; border-right:1px solid #333; border-bottom:1px solid #333; padding:0px;}
	.DMWindowBody iframe {width:100%; height:100%; border:0px; background-color:#fff;}

	#directorySelectorContainer {height:200px; overflow:auto; border-bottom:1px solid #ddd;}

	.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; cursor:text}
	.CodeMirror-gutter {cursor:default}
	.CodeMirror-scroll {height: 450px;}
	.CodeMirror-sourceEditor-fullscreen {
		display: block;
		position: fixed;
		top: 0px;
		left: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999 !important;
		border: 0px;
		background-color:#fff;
	}

	.sourceEditorActiveLine {background: #f0f0f0 !important;}
</style>
<script type="text/javascript">
	var newTabIdx = 0;
	var tabList = new Array();
	var selectedTplPath = null;
	var maxTabCnt = 5;
	var sourceEditorObjs = [];
	var searchKeyword = "<?php echo urlencode($TPL_VAR["searchKeyword"])?>";

	/* ?????????????????? ?????? ?????? */
	var tagCopyClips = [];

	$(function(){
		
		$(window).bind('beforeunload',function(){
			if($(".EETCItemModified").length){
				return "";
			}
		})
		
<?php if($_GET["template_path"]){?>
		addTabItem('<?php echo $_GET["template_path"]?>');
<?php }?>
		
		//??????????????? ??????
		$("#EyeEditorTabContainer span.closebtn").live('click',function(){
			removeTabItem($(this).closest('li.EETCItem').attr('tplPath'));	
			return false;
		});
		
		//????????? ??????
		$("#EyeEditorTabContainer li.EETCItem").live('mousedown',function(){
			selectedTplPath = $(this).attr('tplPath');
			chkFilemtime(selectedTplPath);
			resetTabItemStyle();
		});
		
		//??? ???????????? ?????? ???????????? ??????
		$(window).bind('focus',function(){
			chkFilemtime(selectedTplPath);
			resizeSelectedTabEditor();
		});
		
		//??? ??????????????? ????????? ????????????
		var doit; 
		$(window).resize(function(){ 
			clearTimeout(doit); 
			doit = setTimeout(function(){resizeSelectedTabEditor();}, 100); 
		});
		
		//????????????	
		$(document).bind('keydown', 'Ctrl+Tab', function(){
			var nextTabItemObj = selectedTabItemObj.next("li.EETCItem").length ? selectedTabItemObj.next("li.EETCItem") : $("#EyeEditorTabContainer > ul > li.EETCItem:first-child");
			selectedTplPath = nextTabItemObj.attr('tplPath');
			resetTabItemStyle();
			return false;
		});
		
		$(document).bind('keydown', 'Ctrl+Shift+Tab', function(){
			var prevTabItemObj = selectedTabItemObj.prev("li.EETCItem").length ? selectedTabItemObj.prev("li.EETCItem") : $("#EyeEditorTabContainer > ul > li.EETCItem:last");
			selectedTplPath = prevTabItemObj.attr('tplPath');
			resetTabItemStyle();
			return false;
		});
		
		$(document).bind('keydown', 'Ctrl+W', function(){
			CodeMirror.keyMap.pcDefault["Ctrl-W"]();
			return false;
		});
		CodeMirror.keyMap.pcDefault["Ctrl-W"] = function(cm) {
			removeTabItem(selectedTplPath);	
		};
		
		// ??? ?????????
		$(document).bind('keydown', 'Ctrl+S', function(){
			CodeMirror.keyMap.pcDefault["Ctrl-S"]();
			return false;
		});
		CodeMirror.keyMap.pcDefault["Ctrl-S"] = function(cm) {
			var tabIdx = getSelectedTabContentsObj().attr('tabIdx');
			eyeEditorSaveByTabIdx(tabIdx);

		};
		
		// ???????????? ??????
		$("#directorySelector")
		.jstree({ 
			"plugins" : [ "themes","json_data","ui","crrm","contextmenu","types"],
			"json_data" : {
				"ajax" : {
					"url" : "/admin/webftp/process",
					"global" : false,
					"data" : function (n) {
						return { 
							"operation" : "get_folder_children",
							"childPath" : n.attr ? n.attr("childPath") : '', 
							"rootRel"	: 'root2'
						};
					}
				}
			},
			"core" : {
				"strings" : {
					new_node	: "new_folder"
				}
			},
			"contextmenu" : {
				"items" : {
					"create" : {"label"				: "??? ??????", "separator_after" : false},
					"rename" : {"label"				: "?????? ????????????"},
					"remove" : {"label"				: "?????? ??????"},
					"ccp" : null
				}
			},
			"ui" : {
				"select_limit" : 1
			}
		})
		.bind("loaded.jstree",function(e, data){
			$.jstree._focused().select_node("li:eq(0)");
		})
		.bind("open_node.jstree", function (e, data) {
			$.jstree._focused().select_node(data.rslt.obj);
			
		})
		.bind("select_node.jstree",function(e, data){
			
			var childPath = data.rslt.obj.attr('childPath');

			if(event && event.type){
				if(event.type=='dblclick'){
					$("#directorySelector").jstree('toggle_node',data.rslt.obj);
				}
			}
			
			$("input[name='file_name_chk']").val('');
			$("input[name='newFileDirectory']").val("/"+childPath);
		
		})
		.bind("create.jstree", function (e, data) {

			if(data.rslt){
				$.get(
					"/admin/webftp/process", 
					{ 
						"operation" : "create_folder", 
						"parentPath" : data.rslt.parent.attr("childPath"), 
						"name" : data.rslt.name
					}, 
					function (r) {

						if(r.status) {
							$(data.rslt.obj).attr("childPath", r.childPath);
						}
						else{
							$.jstree.rollback(data.rlbk);							
							if(r.msg){
								openDialogAlert(r.msg,400,140);
							}
						}
					}
				);
			}else{
				$.jstree.rollback(data.rlbk);
			}
		})
		.bind("remove.jstree", function (e, data) {
			openDialogConfirm("????????? ????????? ?????? ?????????????????????????",400,140,function(){
				data.rslt.obj.each(function (i) {
					$.ajax({
						async : false,
						type: 'get',
						url: "/admin/webftp/process",
						data : { 
							"operation" : "remove_folder", 
							"childPath" : $(this).attr('childPath')
						}, 
						success : function (r) {
							if(!r.status) {
								$.jstree.rollback(data.rlbk);
								if(r.msg){
									openDialogAlert(r.msg,400,140);
								}else{
									openDialogAlert("????????? ??????????????????.",400,140);								
								}
							}
						}
					});
				});
			},function(){
				$.jstree.rollback(data.rlbk);		
			});
			
		})
		.bind("rename.jstree", function (e, data) {
			$.get(
				"/admin/webftp/process", 
				{ 
					"operation" : "rename_folder", 
					"childPath" : data.rslt.obj.attr('childPath'), 
					"name" : data.rslt.new_name
				}, 
				function (r) {
					if(r.status) {
						$(data.rslt.obj).attr("childPath", r.childPath);
					}else{
						$.jstree.rollback(data.rlbk);
						if(r.msg){
							openDialogAlert(r.msg,400,140);
						}else{
							openDialogAlert("?????? ?????? ????????? ??????????????????.",400,140);
							$.jstree._focused().select_node(data.rslt.obj);
						}
						
					}
					
				}
			);
		});
		
		/* ??? ????????? ????????? ???????????? ?????? */
		$("input[name='newFileName']").change(function(){
			$("input[name='file_name_chk']").val('');
		});
		
		$("#file_name_chk_btn").click(function(){
			
			if($("input[name='newFileName']").val()=='' || $("input[name='newFileName']").val() == $("input[name='newFileName']").attr('title')){
				openDialogAlert("???????????? ??????????????????.",400,140,function(){$("input[name='newFileName']").focus();});
				return;
			}
			
			var param = {
				'tpl_folder'	: $("input[name='newFileDirectory']").val().substring(1),
				'tpl_file_name'	: $("input[name='newFileName']").val()
			};

			$.ajax({
				'url' : '../design_process/file_name_chk',
				'data' : param,
				'success' : function(res){
					if(res=='0'){
						openDialogAlert("<font color='red'>???????????? ????????? ??? ????????????.</font>",400,140);
						$("input[name='file_name_chk']").val('');
					}else{
						openDialogAlert("<font color='blue'>???????????? ????????? ??? ????????????.</font>",400,140);
						$("input[name='file_name_chk']").val('1');
					}
				}
			});
			
		});
				
	});

	/* ????????????????????? submit */
	function newFileFormSubmit(frm){
		
		if(frm.file_name_chk.value!='1'){
			//openDialogAlert("????????? ??????????????? ????????????.",400,140);
			//return false;
		}
		
		$.ajax({
			'url' : '../design_process/eye_editor_newpage',
			'type' : 'post',
			'dataType' : 'json',
			'data' : $(frm).serialize(),
			'success' : function(result){
				if(result.code!='success'){
					openDialogAlert(result.msg,400,140,function(){
						if(result.code=='duplicate'){
							$("input[name='newFileName']").focus();
						}
					});
					return;
				}
				
				openDialogAlert(result.msg,400,140,function(){
					searchKeyword = '';
					addTabItem(result.tplPath);
					$("#EyeEditorFileAddLayer").hide();
					$("input[name='newFileName']").val('');
					$("input[name='file_name_chk']").val('');
				});
				
				
			}
		});
		
		return false;
	}

	/* ????????? */
	function addTabItem(tplPath){
		for(i in tabList){
			if(tabList[i].tplPath == tplPath){
				openDialogAlert(tplPath + ' ?????? ????????????',500,140,function(){
					chkFilemtime(tplPath);
				});
				selectedTplPath = tplPath;
				
				resetTabItemStyle();
				return;						
			}
		}
		
		if($("li.EETCItem").length>=maxTabCnt){
			openDialogAlert(maxTabCnt + '??? ????????? ??????????????????.',400,140)
			return;
		}
			
		tabList.push({'tplPath' : tplPath});
		
		selectedTplPath = tplPath;
		
		newTabIdx++;
		
		var tabName = tplPath.split('/')[tplPath.split('/').length-1];
		
		$("#EyeEditorTabContainer > ul > .EETCAddBtn").before($("<li class='EETCItem EETCItemLeft' tplPath='"+tplPath+"' tabIdx='"+newTabIdx+"'><div><span class='EETCItemMark'>* </span><span class='EETCItemName'>"+tabName+"</span><span class='closebtn'></span></div></li>"));
		
		var tabItemObj = $(".EETCItem[tabIdx='"+newTabIdx+"']");
		$("#EyeEditorContentsContainer").append("<div class='EECCItem' tabIdx='"+newTabIdx+"'></div>"); 	
		
		resetTabItemStyle();
		
		getTabContents(newTabIdx);
	}

	/* ????????? */
	function removeTabItem(tplPath){
		for(i in tabList){
			if(tabList[i].tplPath == tplPath){
				tabList.splice(i,1);
				break;
			}
		}
		
		var selectedTabItemObj = getSelectedTabItemObj();
		var deleteTabItemObj = $("#EyeEditorTabContainer > ul > li").filter("[tplPath='"+tplPath+"']");
		var deleteTabIdx = deleteTabItemObj.attr('tabIdx');
		
		if(deleteTabItemObj.is(selectedTabItemObj)){
			selectedTplPath = selectedTabItemObj.next("li.EETCItem").length ? selectedTabItemObj.next("li.EETCItem").attr('tplPath') : selectedTabItemObj.prev("li.EETCItem").attr('tplPath');
		}
		
		deleteTabItemObj.remove();

		$("#EyeEditorContentsContainer .EECCItem[tabIdx='"+deleteTabIdx+"']").remove();
		
		resetTabItemStyle();
	}

	/* ????????? ??? object ?????? */
	function getSelectedTabItemObj(){
		return selectedTabItemObj = $("#EyeEditorTabContainer > ul > li").filter("[tplPath='"+selectedTplPath+"']");	
	}

	/* ????????? ????????? object ?????? */
	function getSelectedTabContentsObj(){
		var selectedTabItemObj = getSelectedTabItemObj();
		var selectedTabIdx = selectedTabItemObj.attr('tabIdx');
		return $("#EyeEditorContentsContainer .EECCItem[tabIdx='"+selectedTabIdx+"']");
	}

	/* ??? UI ????????? */
	function resetTabItemStyle(){
		$(".EETCItem, .EETCItemDefault").removeClass("EETCItemLeft  EETCItemSelected EETCItemSelectedLeft EETCItemSelectedRight");
		
		$(".EETCItem:gt(0)").addClass("EETCItemAdjoin");
		
		var selectedTabItemObj = getSelectedTabItemObj();
		selectedTabItemObj.addClass("EETCItemSelected EETCItemSelectedLeft");
		selectedTabItemObj.next("li").addClass("EETCItemSelectedRight");
		
		$("#EyeEditorTabContainer > ul > li:first-child").addClass("EETCItemLeft");
		
		var selectedTabContentsObj = getSelectedTabContentsObj();
		$("#EyeEditorContentsContainer .EECCItem").hide();
		selectedTabContentsObj.show();
		
		var selectedTabIdx = selectedTabItemObj.attr('tabIdx');
			
		$("#EyeEditorTitle .tplPath").html("("+selectedTplPath+")");
		
		if(selectedTabContentsObj.find(".skin").length){
			var tpl_url = selectedTabContentsObj.find(".tpl_url").val();
			$("#EyeEditorTitle .EETTextCenter").show();
			$("#EyeEditorTitle .previewBtn").attr('href',tpl_url).show();
			if(~tpl_url.indexOf('/layout_header')||~tpl_url.indexOf('/layout_footer')||~tpl_url.indexOf('/layout_side')||~tpl_url.indexOf('/layout_scroll')||~tpl_url.indexOf('/layout_TopBar')){
				$("#EyeEditorTitle .previewBtn").attr('onclick',"openDialogAlert('????????? ???????????? ????????? ?????? ?????? ????????? ???????????? ???????????????.</br>??????/??????/??????/???????????? ????????? ?????? ????????? ????????? ??????????????? ?????? EYE-DESIGN?????????.',800,170); return false;");
			}
			
			if(selectedTabContentsObj.find(".tpl_name").val()){
				$("#EyeEditorTitle .prefix").html(selectedTabContentsObj.find(".tpl_name").val());
				$("#EyeEditorTitle .title").html('??????');
			}else{
				$("#EyeEditorTitle .prefix").html('');
				$("#EyeEditorTitle .title").html('??????');
			}
		}else{
			$("#EyeEditorTitle .EETTextCenter").hide();
		}
		
		$('#urlCopyBtn').click(function(){
			clipboard_copy(selectedTplPath);
			alert("????????? ?????????????????????.\nHTML????????? ???????????? ????????? Ctrl+V??? ???????????? ?????????.");
		});
		
		resizeSelectedTabEditor();

		if(tabList.length){
			//$(".EETTextCenter").show();
			$(".EETTextRight").show();
		}else{
			$(".EETTextCenter").hide();
			$(".EETTextRight").hide();
		}

	}

	/* ????????? ???????????? */
	function resizeSelectedTabEditor(){
		var selectedTabItemObj = getSelectedTabItemObj();
		var selectedTabIdx = selectedTabItemObj.attr('tabIdx');
		if(sourceEditorObjs[selectedTabIdx]){
			var scroller = sourceEditorObjs[selectedTabIdx].getScrollerElement();

			$(scroller).css({
				'height' : $(window).height() - $(scroller).offset().top		
			});
			sourceEditorObjs[selectedTabIdx].refresh();	
		}
	}

	/* ???????????? ???????????? */
	function getTabContents(tabIdx){
		var tplPath = $(".EETCItem[tabIdx='"+tabIdx+"']").attr('tplPath');	
		$("#EyeEditorContentsContainer .EECCItem[tabIdx='"+tabIdx+"']").load("../design/eye_editor_tabcontents?tabIdx="+tabIdx+"&tplPath="+encodeURIComponent(tplPath)+"&searchKeyword="+searchKeyword,function(){
			resetTabItemStyle();
		});
	}

	/* ????????? ?????? */
	function sourceeditor_edited_mark_on(tabIdx){
		$(".EETCItem[tabIdx='"+tabIdx+"'] .EETCItemMark").show();
		$(".EETCItem[tabIdx='"+tabIdx+"']").addClass("EETCItemModified");
	}

	/* ????????? ?????? ?????? */
	function sourceeditor_edited_mark_off(tabIdx){
		$(".EETCItem[tabIdx='"+tabIdx+"'] .EETCItemMark").hide();
		$(".EETCItem[tabIdx='"+tabIdx+"']").removeClass("EETCItemModified");
	}

	/* ?????????????????? */
	function source_view_popup(mode,skin,tpl_path){
		window.open("../design/source_view_popup?mode="+mode+"&skin="+skin+"&tpl_path="+encodeURIComponent(tpl_path),"source_view","width=800,height=550,scrollbars=0,resizable=1");
	}

	/* ?????????????????? */
	function file_view_popup(mode,tpl_path){
		window.open("../design/file_view_popup?mode="+mode+"&tpl_path="+encodeURIComponent(tpl_path),"source_view","width=800,height=550,scrollbars=0,resizable=1");
	}

	/* ?????? */
	function eyeEditorSaveByTabIdx(tabIdx,callback){
		var tabItemObj = $("#EyeEditorTabContainer > ul > li").filter("[tabIdx='"+tabIdx+"']");
		eyeEditorSave(tabItemObj.attr('tplPath'),callback);
	}

	function eyeEditorSave(tplPath,callback){
		var tabItemObj = $("#EyeEditorTabContainer > ul > li").filter("[tplPath='"+tplPath+"']");
		var tabIdx = tabItemObj.attr('tabIdx');
		var sourceTextareaObj = $("#sourceTextarea"+tabItemObj.attr('tabIdx'));
		
		sourceEditorObjs[tabIdx].save();
		
		$.ajax({
			'url'		: '../design_process/eye_editor_save',
			'type'		: 'post',
			'dataType'	: 'json',
			'global'	: false,
			'cache'		: false,
			'data'		: {
				'tplPath' : tplPath,
				'tplSource' : sourceTextareaObj.val()		
			},
			'success'	: function(result){
				if(result.code!='success'){
					openDialogAlert(result.msg,300,140);
					return;
				}else{
					openDialogAlert('?????????????????????.',300,140);
				}
				
				sourceeditor_edited_mark_off(tabIdx);
				
				$("#EyeEditorContentsContainer .EECCItem[tabIdx='"+tabIdx+"'] .filemtime").val(result.filemtime);

				if(typeof callback == 'function'){
					callback();
				}
			}
		});
	}

	/* ???????????? */
	function eyeEditorAllSave(){
		if(tabList.length){
			for(var i=0;i<tabList.length;i++){
				if(tabList[i].tplPath){
					eyeEditorSave(tabList[i].tplPath);
				}			
			}		
		}
	}

	/* ?????? ???????????? ?????? */
	function chkFilemtime(tplPath){
		var tabIdx = $(".EETCItem[tplPath='"+tplPath+"']").attr('tabIdx');
		
		var filemtimeObj = $("#EyeEditorContentsContainer .EECCItem[tabIdx='"+tabIdx+"'] .filemtime");
		
		if(filemtimeObj.length){
			var filemtime = eval(filemtimeObj.val());

			$.ajax({
				'url'		: '../design_process/eye_editor_filemtime',
				'type'		: 'post',
				'global'	: false,
				'cache'		: false,
				'data'		: {
					'tplPath' : tplPath		
				},
				'success'	: function(now_filemtime){
					now_filemtime = eval(now_filemtime);
					if(filemtime != now_filemtime){
						openDialogConfirm("/" + tplPath + "<br />??? ????????? Eye-Editor ??????(FTP, Eye-Design)?????? ?????????????????????.<br />HTML ????????? ?????? ?????? ???????????????????",500,170,function(){
							getTabContents(tabIdx);
							sourceeditor_edited_mark_off(tabIdx);
						},function(){
							filemtimeObj.val(now_filemtime);
						})
						return;
					}
				}
			});
		}
	}
</script>

<?php if($TPL_VAR["service_limit"]){?>
<div id="service_limit" class="center">
	<div style="border:2px #dddddd solid;padding:10px;width:95%;">
		<table width="100%">
		<tr>
		<td align="left">
			?????????+ : Eye-Editor??? ???????????? ????????????.<br>
			???????????????+ ?????? ?????????+??? ??????????????? ????????? ????????????.
		</td>
		<td align="right"><img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand" onclick="serviceUpgrade();" align="absmiddle" /></td>
		</tr>
		</table>
	</div>
	<br style="line-height:20px;" />
</div>
<script>
openDialog("Eye-Editor ??????","service_limit",{'width':550,'height':145,'noClose':true});
</script>
<?php }?>

<div id='EyeEditorTitle' class='clearbox'>
	<div class='EETTextCenter hide'>
		<span class="prefix"></span><span class="tplPath"></span> <b class="title"></b>&nbsp; 
		<span class="btn small"><input type="button" id="urlCopyBtn" value="????????????" /></span>
		<span class="btn small cyanblue"><a href="#" target="_blank" class="previewBtn">????????????</a></span>
		<!-- <a href="#" target="_blank" class="previewBtn"><img src="/admin/skin/default/images/design/btn_view_page.gif" align="absmiddle" /></a> -->		
		<!-- <span class="btn small"><a href="/admin/design/codes" target="_blank">??????CODE</a></span> -->
	</div>
	<div class='EETTextLeft'></div>
	<div class='EETTextRight hide'>
<?php if($TPL_VAR["functionLimit"]){?>
		<img src="/admin/skin/default/images/design/btn_save_all.gif" onclick="servicedemoalert('use_f');" class="hand" align="absmiddle" />
		<img src="/admin/skin/default/images/design/btn_save.gif" onclick="servicedemoalert('use_f');" class="hand" align="absmiddle" title="Ctrl+S" />
<?php }else{?>
		<img src="/admin/skin/default/images/design/btn_save_all.gif" onclick="eyeEditorAllSave()" class="hand" align="absmiddle" />
		<img src="/admin/skin/default/images/design/btn_save.gif" onclick="eyeEditorSave(selectedTplPath)" class="hand" align="absmiddle" title="Ctrl+S" />
<?php }?>
	</div>
</div>

<div id="EyeEditorTabContainer">
	<ul>
		<li class="EETCItemDefault EETCItemAdjoin EETCAddBtn" onclick="$('#EyeEditorFileAddLayer').toggle()"><div><img src="/admin/skin/default/images/design/editor_tab_new.gif" align="absmiddle" /></div></li>
		<li class="EETCItemDefault EETCItemRight"></li>
	</ul>
</div>

<div id="EyeEditorFileAddLayer">
	<div class='DMWindow'>
		<div class='DMWindowTitle' class='clearbox'>
			<div class='DMWTBgLeft'></div>
			<div class='DMWTBgRight'></div>
			<div class='DMWTTextCenter'><span class="title">??? ????????? ?????????</span></div>
			<div class='DMWTClose'><img src="/admin/skin/default/images/design/win_btn_close.gif" onclick="$('#EyeEditorFileAddLayer').hide()" /></div>
		</div>
		<div class='DMWindowBody'>
			<form name="newFileForm" target="actionFrame" method="post" onsubmit="return newFileFormSubmit(this)">
				<input type="hidden" name="file_name_chk" value="" />
				<table class="info-table-style" width="100%" align="center">
				<col width="160" />
				<col width="600" />
				<tr>
					<td class="its-th">???????????? ??????</th>
					<td class="its-td" style="padding:0px;">
						<div id="directorySelectorContainer"><div id="directorySelector"></div></div>
						<div class="pd10"><input type="text" name="newFileDirectory" readonly value="/data" style="width:220px; border:0px; width:90%;" /></div>
					</td>
				</tr>
				<tr>
					<td class="its-th">?????????</th>
					<td class="its-td pd10">
						<input type="text" name="newFileName" value="" title="?????? ?????? ???????????? ??????????????????. ???) main.html" class="line" style="width:280px;" />
						<span class="btn small"><input type="button" value="????????????" id="file_name_chk_btn" /></span>					
					</td>
				</tr>
				</table>
				
				<div style="padding:10px; text-align:center;">
					<span class="btn medium cyanblue"><input type="submit" value="?????????" ></span>
				</div>
			</form>
		</div>
	</div>
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed">
<tr>
	<td class="EyeEditorSideBlank"></td>
	<td>
		<div id="EyeEditorContentsContainer"></div>
	</td>
</tr>
</table>

<div style="position:relative;z-index:100;">
<?php $this->print_("eyeeditor_webftp",$TPL_SCP,1);?>

</div>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>