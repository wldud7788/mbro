<?php /* Template_ 2.2.6 2022/05/17 12:37:25 /www/music_brother_firstmall_kr/admin/skin/default/webftp/_webftp.html 000020500 */ ?>
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqcontextmenu/jquery.contextMenu.css" />
<script type="text/javascript" src="/app/javascript/plugin/jstree/jquery.jstree.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jqcontextmenu/jquery.contextMenu.js"></script>
<script type="text/javascript">

var webftpNowPath;
var fileListOptions = {
	'keyword' : '',
	'sortBy' : 'time', // time, name
	'sortOrder' : 'desc' // desc, asc
};
var imagePreviewLayerForcedShow = false;
var lastContextMenuObj = null;
var fileContextMenuItems = {};

<?php if($TPL_VAR["EYE_EDITOR"]){?>
	var defaultPath = 'data/skin/<?php echo $TPL_VAR["designWorkingSkin"]?>';
<?php }else{?>
	var defaultPath = 'data/skin/<?php echo $TPL_VAR["designWorkingSkin"]?>/images';
<?php }?>
var webftpReady = false;

$(function () {
	/* 파일 메뉴 설정*/
	if(useWebftpFormItem) fileContextMenuItems["apply_to_form"] = {name: "선택"};
<?php if($TPL_VAR["EYE_EDITOR"]){?>
	fileContextMenuItems["source_edit"] = {name: "파일편집", icon: "edit"};
<?php }else{?>
	//fileContextMenuItems["image_edit"] = {name: "이미지편집", icon: "edit"};
<?php }?>
	fileContextMenuItems["url_copy"] = {name: "주소복사", icon: "copy"};
	fileContextMenuItems["download_file"] = {name: "PC 저장", icon: "paste"};
	fileContextMenuItems["popup"] = {name: "새창으로 보기"};
	fileContextMenuItems["sep1"] = "---------";
	fileContextMenuItems["remove_file"] = {name: "삭제", icon: "delete"};

	$("#directoryExplorer")
	.jstree({
		"plugins" : [ "themes","json_data","ui","crrm","contextmenu","types"],
		"json_data" : {
			"ajax" : {
				"url" : "/admin/webftp/process",
				"global" : false,
				"data" : function (n) {
					return {
						"operation" : "get_folder_children",
						"childPath" : n.attr ? n.attr("childPath") : ''
					};
				}
			}
		},
		"core" : {
			"strings" : {
				new_node	: "new_folder"
			}
		},
		"types" : {
			"valid_children" : [ "root" ],
			"types" : {
				"root" : {
					"icon" : {
						"image" : "/admin/skin/default/images/common/_drive.png"
					},
					"close_node" : false
				}
			}
		},
		"contextmenu" : {
			"items" : {
				"create" : {"label"				: "새 폴더", "separator_after" : false},
				"rename" : {"label"				: "폴더 이름변경"},
				"remove" : {"label"				: "폴더 삭제"},
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
		if(!webftpReady) $.jstree._focused().deselect_all();
		$.jstree._focused().select_node(data.rslt.obj);

    })
	.bind("select_node.jstree",function(e, data){

		var childPath = data.rslt.obj.attr('childPath');

		if(!webftpReady && childPath){

			var defaultPathDiv = defaultPath.split('/');
			var childPathDiv = childPath.split('/');
			for(var i=0;i<childPathDiv.length;i++){
				if(childPathDiv[i]==defaultPathDiv[0]) {
					defaultPathDiv.shift();
				}
			}

			if(defaultPathDiv.length){
				var nextChildPath = childPathDiv.join('/') + '/' + defaultPathDiv[0];

				$("#directoryExplorer").jstree('open_node',$("#directoryExplorer li[childPath='"+nextChildPath+"']"));
				return;
			}else{
				webftpReady = true;

			}
		}

		if(e && e.type){
			if(e.type=='dblclick'){
				$("#directoryExplorer").jstree('toggle_node',data.rslt.obj);
			}
		}
		else if(event && event.type){
			if(event.type=='dblclick'){
				$("#directoryExplorer").jstree('toggle_node',data.rslt.obj);
			}
		}

		getFileList(childPath);
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
		openDialogConfirm("선택한 폴더를 정말 삭제하시겠습니까?",400,140,function(){
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
								openDialogAlert("삭제에 실패했습니다.",400,140);
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
						openDialogAlert("폴더 이름 변경에 실패했습니다.",400,140);
						$.jstree._focused().select_node(data.rslt.obj);
					}

				}

			}
		);
	});

	/* 정렬버튼 클릭 이벤트 정의 */
	$(".sort-btn").live("click",function(){
		fileListOptions['sortOrder'] = fileListOptions['sortBy'] == $(this).val() ? toggleSortOrder(fileListOptions['sortOrder']) : fileListOptions['sortOrder'];
		sortFileList($(this).val(),fileListOptions['sortOrder']);
	});

	/* 확장자 선택 이벤트 정의 */
	$("select[name='fileExtension']").live("change",function(){
		getFileList(webftpNowPath, true);
	});

	/* 정렬 버튼 마크 설정 */
	setSortOrderBtn();

	/* 드래그차단 */
	$("#fileExplorer").bind("selectstart",false);

	/* 파일항목 마우스 이벤트 정의 */
	$("#fileExplorer ul li.item").live("mousedown contextmenu",function(){
		$("#fileExplorer ul li.selectedItem").removeClass("selectedItem");
		$(this).addClass("selectedItem");
	}).live("mouseenter",function(){
		showImagePreview(this);
	});
	$("#fileExplorer").live("mouseleave",function(){
		if(!imagePreviewLayerForcedShow)	hideImagePreview();
	});

	/* 우클릭메뉴 */
	$.contextMenu({
        selector: '#fileExplorer ul li.item',
        /* 실행 액션 */
        callback: function(key, options) {

        	var $item = $(this);

			switch(key){

				/* 파일 편집 */
				case "source_edit" :
					sourceFileEdit($item.attr('path'));
				break;

				/* 주소 복사 */
				case "url_copy" :
					// setUrlCopy() 함수에서 처리함
				break;

				/* 파일 삭제처리 */
				case "remove_file" :
					openDialogConfirm("\"" + $item.attr('name') + "\"<br /><br /> 파일을 삭제하시겠습니까?",400,175,function(){
						$.ajax({
							"url" : "/admin/webftp/process",
							"type" : "get",
							"data" : {"operation" : "remove_file","path" : $item.attr('path')},
							"success" : function(r){
								if(r.status) {
									/*
									openDialogAlert("삭제되었습니다.",400,140,function(){
										getFileList(webftpNowPath,true);
									});
									*/
									getFileList(webftpNowPath,true);

								}else{
									if(r.msg){
										openDialogAlert(r.msg,400,140);
									}else{
										openDialogAlert("삭제에 실패했습니다.",400,140);
									}
								}
							}
						});
					});
				break;

				/* 새창으로 보기 */
				case "popup" :
					window.open("/"+$item.attr("path"));
				break;

				/* 다운로드 */
				case "download_file" :
					$("iframe[name='actionFrame']").attr("src","/admin/webftp/download_file?path=" + encodeURI($item.attr("path")));
				break;

				/* 파일선택 */
				case "apply_to_form" :
					if(useWebftpFormItem){
						var webftpFormItemObj = $("input[type=radio][name='webftpFormItemSelector']:checked").closest(".webftpFormItem");
						webftpFormItemObj.find(".webftpFormItemInput").val($item.attr("path"));
						webftpFormItemObj.find(".webftpFormItemInputOriName").val($item.attr("name"));
						webftpFormItemObj.find(".webftpFormItemPreview").attr('src','/'+$item.attr("path"));
					}
				break;

			}
        },
        /* 메뉴 정의 */
        items: fileContextMenuItems,
        events: {
        	'show' : function(obj){
        		showImagePreview(this);
        		imagePreviewLayerForcedShow = true;
        		lastContextMenuObj = this;

//        		setTimeout("setUrlCopy('"+$(this).attr('path')+"')",100);

        	},
        	'hide' : function(){
        		imagePreviewLayerForcedShow = false;
        		hideImagePreview();

        	}
        }
    });


	/* 이미지업로드 레이어 세팅 */
	openDialog("이미지 업로드 <span class='desc'>이미지 파일을 업로드합니다.</span>", "webftpImageUploadDialog", {"width":600,"height":200,"autoOpen":false,"close":function(){
		
	}});

});

/* 파일편집 */
function sourceFileEdit(filePath){
	var filename = filePath.split('/')[filePath.split('/').length-1];
	if(filename.split('.').length>1){
		var fileext = filename.split('.')[filename.split('.').length-1];
		if(fileext=='gif' || fileext=='png' || fileext=='jpg' || fileext=='bmp' || fileext=='tif' || fileext=='pic' || fileext=='ico' || fileext=='xls'){
			openDialogAlert("확장자가 " + fileext + "인 파일은 편집할 수 없습니다.",350,140);
			return;
		}
	}
	addTabItem(filePath);
}

/* 주소복사버튼 올리기 */
function setUrlCopy(path){
	$(".icon-copy").css('position','relative').attr('id','fileUrlCopyBtn');
	$('#fileUrlCopyBtn').click(function(){
		clipboard_copy("/" + encodeURI(path));
		alert("주소가 복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.");
		$(lastContextMenuObj).contextMenu("hide");
	});	

}

/* 파일목록 가져오기 */
function getFileList(path, absolutely){

	if(webftpNowPath != path || absolutely){
		webftpNowPath = path;

		if(!absolutely) {
			fileListOptions['keyword'] = '';
			$("#searchFileKeyword").val('').focusout();
		}
		fileListOptions['fileExtension'] = document.searchFileForm.fileExtension ? document.searchFileForm.fileExtension.value : '';

		$("#fileExplorer").empty().activity({segments: 10, width: 3.5, space: 1, length: 6, color: '#999999', speed: 1.5});

		$.ajax({
			url : "/admin/webftp/process",
			global : false,
			cache: false,
			data : {
				"operation" : <?php if($TPL_VAR["EYE_EDITOR"]){?>"get_source_file_list"<?php }else{?>"get_image_file_list"<?php }?>,
				"path" : webftpNowPath,
				"options" : fileListOptions
			},
			success : function (r) {
				showFileList(r);
			},
			complete : function(){
				$("#fileExplorer").activity(false);
			}
		});
	}
}

/* 파일목록 보여주기 */
function showFileList(loop){

	$("#fileExplorer").empty().append("<ul></ul>");

	for(var i=0;i<loop.length;i++){
		var item = $("<li>");
		item.addClass("item");
		item.html(loop[i].name);
		item.attr(loop[i]);

<?php if($TPL_VAR["EYE_EDITOR"]){?>
		$(item).bind('dblclick',function(){
			sourceFileEdit($(this).attr('path'));
		});
<?php }?>

		$("#fileExplorer ul").append(item);
	}

}

/* 검색 */
function searchFileList(){
	fileListOptions['keyword'] = document.searchFileForm.keyword.value!=document.searchFileForm.keyword.getAttribute('title') ? document.searchFileForm.keyword.value : '';
	getFileList(webftpNowPath, true);
	$("#searchFileKeyword").focus();
}

/* 정렬 */
function sortFileList(sortBy, sortOrder){
	fileListOptions['sortBy'] = sortBy;
	fileListOptions['sortOrder'] = sortOrder;
	getFileList(webftpNowPath, true);
	setSortOrderBtn();
}

/* 정렬순서 토글 */
function toggleSortOrder(sortOrder){
	return sortOrder == 'desc' ? 'asc' : 'desc';
}

/* 정렬버튼 표식 세팅 */
function setSortOrderBtn(){
	$(".sort-btn .sortOrderMark").empty();
	$(".sort-btn[value='"+fileListOptions['sortBy']+"'] .sortOrderMark").html(fileListOptions['sortOrder']=='desc'?'▼':'▲');
}

/* 이미지 미리보기 */
function showImagePreview(item){

	$("#directoryExplorer").css('opacity','0.1');
	$("#imagePreviewLayer").show();

	var tmpDiv = $(item).attr('path').split('.');
	var ext = tmpDiv[tmpDiv.length-1];

	if(ext!='gif' && ext!='jpg' && ext!='jpeg' && ext!='tif' && ext!='pic' && ext!='png' && ext!='bmp'){
		return;
		//$("#imagePreviewLayer .ipl-image").hide();
	}else{
		$("#imagePreviewLayer .ipl-image").show().html("<img src='/"+$(item).attr('path')+"' />");
	}

	$("#imagePreviewLayer .ipl-name").html($(item).attr('name'));
	$("#imagePreviewLayer .ipl-scale").html($(item).attr('scale'));
	$("#imagePreviewLayer .ipl-size").html(getSizeFormat($(item).attr('size')));
}

/* 이미지 미리보기 숨기기 */
function hideImagePreview(item){
	$("#directoryExplorer").css('opacity','1');
	$("#imagePreviewLayer").hide();
}

/* 용량 포맷 */
function getSizeFormat(bytes){
	if(bytes>1024*1024) return comma(bytes/1024/1024) + "MB";
	else if(bytes>1024) return comma(bytes/1024) + "KB";
	else return comma(bytes) + "Byte";
}

/* 이미지 업로드 레이어 보기 */
function showWebftpImageUploadDialog(){

	if(webftpNowPath){
		/* Uploadify path 변경 */
		$("#webftpImageUploadDialog .uploadPath").html(webftpNowPath);
		$("#webftpImageUploadDialog").dialog("open");


		/* 파일업로드버튼 ajax upload 적용 */
		var imgopt			= {
			'eventType' : 'none',
			'file_path' : webftpNowPath,
			'btnSubmit' : $('.btnUpload')
		};
		var imgcallback	= function(res){
			var that		= this;
			var result		= eval(res);

			if(result.status){
				getFileList(webftpNowPath,true);
				$('#webftpImageUploadDialog').dialog("close");
			}else{
					openDialogAlert(result.msg,400,150);
					return false;
				}
		};

		// ajax 이미지 업로드 이벤트 바인딩
		$('#webftpImageUploadButton').createAjaxFileUpload(imgopt, imgcallback);

	}
}

</script>

<style>
table.webftp-table-style {border-collapse:collapse; border-top:1px solid #aaa; border-right:1px solid #dadada; background-color:#fff}
table.webftp-table-style .wts-th {border-left:1px solid #dadada; border-bottom:1px solid #dadada; padding:2px; text-align:left; background-color:#f1f1f1; font-weight:normal;}
table.webftp-table-style .wts-td {border-left:1px solid #dadada; border-bottom:1px solid #dadada; padding:0px;}

#searchFileKeyword {height:14px; padding:2px; font-size:11px;}

#directoryExplorer {padding:0px 5px;}
#directoryExplorer,
#fileExplorer {background-color:#fff; height:200px; overflow:auto;}
#fileExplorer ul li {cursor:pointer}
#fileExplorer ul li.item {float:left; width:150px; height:20px; line-height:20px; text-indent:4px; border:1px solid #fff; font-size:11px; color:#333; font-family:tahoma; overflow:hidden; white-space:nowrap;}
#fileExplorer ul li.item:hover {background-color:#ddeeff;}
#fileExplorer ul li.item.selectedItem,
#fileExplorer ul li.selectedItem {border:1px dotted #ddd; background-color:#0066cc; color:#fff;}

#imagePreviewLayer {display:none; position:absolute; left:0px; top:0px; height:100%; }
#imagePreviewLayer table {width:230px; height:100%; text-align:center; border-collapse:collapse;}
#imagePreviewLayer .ipl-image {display:inline-block; max-width:200px; max-height:120px; border:2px dotted #ddd; overflow:hidden; margin:auto; text-align:center;}
#imagePreviewLayer .ipl-image img {max-width:150px; max-height:120px;}
#imagePreviewLayer .ipl-name {width:230px; overflow:hidden; margin-top:5px; font-size:11px; background-color:#fff;}
#imagePreviewLayer .ipl-scalesize {margin-top:2px; font-size:11px; background-color:#fff;}

</style>

<table width="100%" class="webftp-table-style">
<col width="250" />
<tr>
	<td class="wts-th" colspan="2">
		<form name="searchFileForm" onsubmit="searchFileList();return false;">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<span class="fl hand"><img hspace="2" src="/admin/skin/default/images/design/directory_icon_folder_new.gif" title="폴더추가" onclick="$('#directoryExplorer').jstree('create',null,'last')" /></span>
				<span class="fl hand"><img hspace="2" src="/admin/skin/default/images/design/directory_icon_folder_rename.gif" title="폴더이름변경" onclick="$('#directoryExplorer').jstree('rename')" /></span>
				<span class="fl hand"><img hspace="2" src="/admin/skin/default/images/design/directory_icon_folder_del.gif" title="폴더삭제" onclick="$('#directoryExplorer').jstree('remove')" /></span>
				<!--
				<span class="fl hand"><img hspace="2" src="/admin/skin/default/images/design/directory_icon_all_extension.gif" title="모두열기" /></span>
				<span class="fl hand"><img hspace="2" src="/admin/skin/default/images/design/directory_icon_all_enfold.gif" title="모두닫기" /></span>
				-->
				<span class="fl hand"><img hspace="2" src="/admin/skin/default/images/design/directory_icon_refresh.gif" title="새로고침" onclick="$('#directoryExplorer').jstree('refresh',$('#directoryExplorer').jstree('get_selected'));" /></span>
				<span class="fl hand"><img hspace="2" src="/admin/skin/default/images/design/directory_icon_img_upload.gif" title="이미지업로드" onclick="showWebftpImageUploadDialog()" /></span>
			</td>
			<td align="left">
				<input type="text" id="searchFileKeyword" name="keyword" value="" title="<?php if(!$TPL_VAR["EYE_EDITOR"]){?>디렉토리 내 이미지 검색<?php }else{?>파일명, 확장자<?php }?>"/>
				<span class="btn small"><input type="submit" value="검색" /></span>
			</td>
			<td align="center">
				<span class="desc">파일명에 마우스 오른쪽을 클릭하세요. 퀵메뉴가 나타납니다.</span>
			</td>
			<td align="right">
<?php if($TPL_VAR["EYE_EDITOR"]){?>
				<select name="fileExtension">
					<option value="">All Files (*.*)</option>
					<option value="txt,ini,csv">Text (*.txt, *.ini, *.csv)</option>
					<option value="htm,html">Html (*.htm, *.html)</option>
					<option value="js">Javascript (*.js)</option>
					<option value="css">CSS (*.css)</option>
				</select>
<?php }?>
				<span class="btn small"><button class="sort-btn" value="time">등록순 <span class="sortOrderMark"></span></button></span>
				<span class="btn small"><button class="sort-btn" value="name">이름순 <span class="sortOrderMark"></span></button></span>
				<span class="btn small"><button class="sort-btn" value="size">용량순 <span class="sortOrderMark"></span></button></span>
			</td>
		</tr>
		</table>
		</form>
	</td>
</tr>
<tr>
	<td class="wts-td">
		<div class="relative">
			<div id="directoryExplorer"></div>
			<div id="imagePreviewLayer">
				<table>
				<tr>
					<td>
						<div class="ipl-image"></div>
						<div class="ipl-name"></div>
						<div><span class="ipl-scalesize"><span class="ipl-scale"></span> (<span class="ipl-size"></span>)</span></div>
					</td>
				</tr>
				</table>
			</div>
		</div>
	</td>
	<td class="wts-td">
		<div id="fileExplorer"></div>
	</td>
</tr>
</table>

<!-- 이미지 업로드 다이얼로그 -->
<div id="webftpImageUploadDialog" class="hide">

	<table width="100%" class="info-table-style">
	<col width="100" />
	<tr>
		<th class="its-th">업로드경로</th>
		<td class="its-td">/<span class="uploadPath"></span></td>
	</tr>
	<tr>
		<th class="its-th">파일찾기</th>
		<td class="its-td">
			<div class="pdr10">
				<img class="webftpImageUploadBtnImage hide" src="/admin/skin/default/images/common/btn_filesearch.gif">
						<input id="webftpImageUploadButton" type="file" name="file" value="" />
			</div>
		</td>
	</tr>
	</table>

			<div class="center pdt20 pdb20"><span class="btn medium"><input type="button" value="업로드" class="btnUpload" /></span></div>
</div>