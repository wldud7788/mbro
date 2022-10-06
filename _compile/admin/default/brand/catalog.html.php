<?php /* Template_ 2.2.6 2022/05/17 12:30:57 /www/music_brother_firstmall_kr/admin/skin/default/brand/catalog.html 000024861 */ 
$TPL_chk_brand_1=empty($TPL_VAR["chk_brand"])||!is_array($TPL_VAR["chk_brand"])?0:count($TPL_VAR["chk_brand"]);
$TPL_groups_1=empty($TPL_VAR["groups"])||!is_array($TPL_VAR["groups"])?0:count($TPL_VAR["groups"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jstree/jquery.jstree.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-font-decoration.js"></script>
<script type="text/javascript" src="/app/javascript/js/base64.js"></script>
<script type="text/javascript">
	$(function () {
		
		$("#clipboard").live("click",function(){
			var categoryCode = $("input[name='categoryCode']").val();
			if(categoryCode){
				var str = categoryUrl+categoryCode;
				copyContent(str);
			}
		});
		$("#setGroup").live("click",function(){
			openDialog("접속제한 <span class='desc'>브랜드를 접속할 회원그룹을 설정합니다.</span>", "setGroupsPopup", {"width":"500","height":150});
		});
		
		$("#viewCategory").live("click",function(){
			var categoryCode = $("input[name='categoryCode']").val();
			var win = window.open( categoryUrl + categoryCode , "","" );
		});	
		
		$("input[name=memberGroup]").live("click",function(){
			groupsMsg();
		});

		$("#tree li a").live("click",function(){		
			var categoryCode = $(this).find('ins').attr('category');
			viewCategoryInfo({'mode':'info','categoryCode':categoryCode});
		});
		
		$("input[name='node_type']").live("change",function(){
			disableNodeTypeDecoration();
		});

		$("input#remove_button").bind("click",function(){

			var categoryCode = $("input[name='categoryCode']").val();
			var obj = $("#tree li ins[category='"+categoryCode+"']").parent().clone();
			obj.find("ins").remove();
			var category_name = obj.find("a").html();
			// debug($.jstree._focused());
			if (category_name) {
				if( confirm(category_name+'을 삭제하시겠습니까?') ){
					$("input#remove").click();
				}
			} else {
				alert("삭제할 브랜드를 선택해 주세요.");
				return false;
			}
		});
		
		$("#viewCategory",parent).bind("click",function(){
			var categoryCode = $("input[name='categoryCode']").val();
			var win = window.open( categoryUrl + categoryCode , "","" );
		});	
		
		// 정렬 추가
		$(".small > .sort").click(function(){
			//console.debug($("#tree").jstree("refresh"));
			if(confirm("정렬하시겠습니까?")) {
				$type = $(this).attr("data-type");
				$.get("/admin/brand_process/batch_sort/"+$type , function(response){
					if(response.result) {
						$("#tree").jstree("refresh")
					}
				}, "json");
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
				
				$("input[name='hide'][value='"+result[i].hide+"']").attr("checked",true);
				$("input[name='node_type'][value='"+result[i].node_type+"']").attr("checked",true);
				$("input[name='node_text_normal']").val(result[i].node_text_normal).change();
				$("input[name='node_text_over']").val(result[i].node_text_over).change();
				
				if(result[i].node_image_normal){
					$("#node_image_normal_preview").attr('src',result[i].node_image_normal).show();
					$("input[name='node_image_normal']").val(result[i].node_image_normal);
				}else{
					$("#node_image_normal_preview").hide();
					$("input[name='node_image_normal']").val('');
				}
				
				if(result[i].node_image_over){
					$("#node_image_over_preview").attr('src',result[i].node_image_over).show();
					$("input[name='node_image_over']").val(result[i].node_image_over);
				}else{
					$("#node_image_over_preview").hide();
					$("input[name='node_image_over']").val('');
				}
				
				$(".groupsMsg").hide();
							
				if(result[i].groups){
					for(var j=0;j<result[i].groups.length;j++){				
						$("input[type='checkbox'][name='memberGroup'][value='"+ result[i].groups[j].group_seq +"']").attr('checked',true);
					}
					isGroups = true;
				}
							
				$("#goodsCnt").html(comma(result[i].goodsCnt));			
				$("input[name='categoryCode']").val(result[i].category_code);
				var categoryCode = $("input[name='categoryCode']").val();
				$("#urlCategory").html(categoryUrl+categoryCode);	
			}
		}
		if(!isGroups)$("input[type='checkbox'][name='memberGroup']").attr("checked",false);	
		$("#categoryNavi").html(arr.join(" > "));	
		viewCategoryInfo({'mode':'info'});
		groupsMsg();

		$(".customFontDecoration").customFontDecoration();
		
		disableNodeTypeDecoration();	
	}

	function groupsMsg(){
		var str='';
		var tag='';
		$("#groupsMsg").html("이 브랜드 접속권한은 제한 없습니다.");
		$("input[type='checkbox'][name='memberGroup']:checked").each(function(){
			var clone = $(this).parent().clone();
			clone.find("input").remove();		
			str += clone.html() + ',';
			tag += "<input type='hidden' name='memberGroups[]' value='"+$(this).val()+"'>";
		});
		if(str){
			var msg = "이 브랜드 접속권한은 " + str.substr(0,str.length-1) + " 회원에게 있습니다." + tag;		
			$("#groupsMsg").html(msg);
			
		}
		
	}

	function viewCategoryInfo(opts){
		
		if(opts){
			for(var i in opts){
				$("input[name='"+i+"']").val(opts[i]);
			}
		}

		var categoryCode = $("input[name='categoryCode']").val();
		var mode = $("input[name='mode']").val();
		
		if($.jstree._focused() && categoryCode){
			$.jstree._focused().deselect_all();
			$.jstree._focused().select_node($("#tree li ins[category='"+categoryCode+"']").closest("li"));
		}
		
		$("#categorySettingContainer").empty();

		if(categoryCode){
			if(mode=='info'){
				$("#categorySettingContainer").append('<iframe id="ifrmCategorySetting" name="ifrmCategorySetting" style="width:100%; height:100px;" frameborder="0"></iframe>');
				$("#ifrmCategorySetting").attr('src','/admin/brand/ifrm_brand_info?categoryCode='+categoryCode);
			}
			if(mode=='design'){
				$("#categorySettingContainer").append('<iframe id="ifrmCategorySetting" name="ifrmCategorySetting" style="width:100%; height:100px;" frameborder="0"></iframe>');
				$("#ifrmCategorySetting").attr('src','/admin/brand/ifrm_brand_design?categoryCode='+categoryCode);
			}
			
			$('.page-buttons-right').show();
			$("#categoryInfoFirst").hide();
			
		}else{
			$('.page-buttons-right').hide();
			$("#categoryInfoFirst").show();
		}	
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

	function categorySettingFormSubmit(){
		
		if($("#ifrmCategorySetting").length){
			var frm = document.getElementById('ifrmCategorySetting').contentWindow.document.categorySettingForm;
			document.getElementById('ifrmCategorySetting').contentWindow.submitEditorForm(frm);		
		}else{
			openDialogAlert("브랜드를 선택해주세요..",400,140);
		}
		
	}
</script>
<style>
	table.help-table-style {border-collapse:collapse; border-top:1px solid #aaa; border-right:1px solid #dadada;}
	table.help-table-style .help-th {font-size:11px; font:Dotum; color:#000000; height:36px; border-left:1px solid #e6e6e6; border-bottom:1px solid #cecece; text-align:center;}
	table.help-table-style .help-td {font-size:11px; font:Dotum; color:#000000; height:36px; letter-spacing:-1px; border-left:1px solid #e6e6e6; border-bottom:1px solid #cecece; padding:0px 10px 0px 10px;}
	.point_star {color:#CC0000;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<form name="titleform" target="actionFrame">
<input type="hidden" name="categoryCode" value="" />
<input type="hidden" name="mode" value="" />
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<ul class="page-buttons-left mt5 ml5">
			<li><span class="btn large default"><a href="../page_manager/page_layout?cmd=brand" target="_blank">상품리스트 페이지 관리</a></span></li>
			<li><span class="btn small black"><a class="sort" data-type="title">↓가나다 정렬</a></span></button></span></li>
			<li><span class="btn small black"><a class="sort" data-type="title_eng">↓ABC 정렬</a></span></li>
		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>브랜드</h2>
		</div>
		<ul class="page-buttons-right hide">
			<li><span class="btn large black"><button type="button" onclick="logoInput()">대표로고 등록<span class="arrowright"></span></button></span></li>
			<li><span class="btn large gray"><input type="button" id="viewCategory" value="화면보기"/></span></li>
			<li><span class="btn large black"><button type="button" onclick="categorySettingFormSubmit()">저장하기<span class="arrowright"></span></button></span></li>
		</ul>
	</div>
</div>
	<script>
		function logoInput() {
			var page = document.getElementById("logoInput_window");

			if (page.style.display=='none') {
				page.style.display = 'block';
			} else  {
				page.style.display = 'none';
			}
		}

		function file_upload(frm) {
			var file_id = $("#logo_file")[0];

			if (file_id.files.length == 0) {
				alert('파일을 선택해주세요.');
				return;
			}

			var formData = new FormData(frm);



			$.ajax({
				url : './logo_brand',
				type : 'post',
				dataType : 'html',
				enctype : 'multipart/form-data',
				processData : false,
				contentType : false,
				data : formData,
				async : false,
				success : function (res) {
					console.log(res);
					if (res = '0') {
						alert('등록이 완료되었습니다.');
					}
				}

			});
		}
	</script>
<!-- 페이지 타이틀 바 : 끝 -->
	<div id="logoInput_window" tabindex="-1" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable" role="dialog" aria-labelledby="ui-dialog-title-couponDownloadDialog" style="display:none; top:30%; left:40%; width:500px; height:auto; z-index:10002; position:absolute;">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
			<span class="ui-dialog-title" id="ui-dialog-title-couponDownloadDialog">대표로고 등록</span>
			<a class="ui-dialog-titlebar-close ui-corner-all" role="button" href="#" onclick="logoInput()"><span class="ui-icon ui-icon-closethick">close</span></a>
		</div>
		<div class="ui-dialog-content ui-widget-content" style="width:auto; height:auto; min-height:67px;" scrolltop="0" scrollleft="0">
			<form id="file_form">
				<select id="brand" name="brand" style="width:100%;">
					<option value="" selected="selected">선택해주세요</option>
<?php if($TPL_VAR["chk_brand"]){?>
<?php if($TPL_chk_brand_1){foreach($TPL_VAR["chk_brand"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["category_code"]?>"><?php echo $TPL_V1["title"]?></option>
<?php }}?>
<?php }else{?>
<?php }?>
				</select>

				<span> 브랜드 로고 선택 : <input type="file" id="logo_file" name="logo_file"></span>
				<button onclick="file_upload(this.form)">업로드</button>
			</form>
		</div>
	</div>

<!-- 서브메뉴 바디 : 시작-->
<div class="relative" style="margin-top:-1px;">
	<div class="absolute" style="top:0px; left:0px; width:312px;">
		<table width="100%" class="info-table-style">
			<col />
			<tr>
				<th class="its-th" id="mmenu" style="padding:6px 10px;">
					브랜드
					<span class="btn small cyanblue"><input type="button" id="add_folder" value="생성" style="display:block; float:left;"/></span>
					<span class="btn small red"><input type="button" id="remove_button" value="삭제" style="display:block; float:left;"/></span>
					
					<input type="button" id="remove" value="-" style="display:none; float:left;"/>
					
					<span style="float:right; padding-top:5px;">브랜드영역 디자인  <span class="helpicon" title="<?php echo $TPL_VAR["brand_design_ex"]?>"></span></span>					
				</th>		
			</tr>	
			<tr>
				<td class="its-td" style="background:rgba(255,255,238,0.9); padding:5px 0 0 0;">	
					<div id="tree" class="tree" style="width:310px;height:500px;overflow:auto;"></div>
					<div style="height:30px; text-align:center;display:none;">
						<input type="button" style='width:170px; height:24px; margin:5px auto;' value="reconstruct" onclick="$.get('./tree?reconstruct', function () { $('#tree').jstree('refresh',-1); });" />
						<input type="button" style='width:170px; height:24px; margin:5px auto;' id="analyze" value="analyze" onclick="$('#alog').load('./tree?analyze');" />
						<input type="button" style='width:170px; height:24px; margin:5px auto;' value="refresh" onclick="$('#tree').jstree('refresh',-1);" />
					</div>
					<div id='alog' style="display:none;"></div>
				</td>
			</tr>
		</table>
			
		<table class="help-table-style" width="100%" style="margin-top:0px">
			<tr><td colspan="2" style="height:30px; background:#7498b3; color:#ffffff; padding-left:10px;"> <b>브랜드 기능 안내</b></td></tr>
			<tr>
				<td class="help-th" width="76px"><span class="btn small cyanblue"><input type="button" value="생성" style="display:block; "/></span></td>
				<td class="help-td">브랜드를 생성합니다.</td>
			</tr>
			<tr>
				<td class="help-th"><span class="btn small red"><input type="button" value="삭제" style="display:block; "/></span></td>
				<td class="help-td">브랜드를 삭제합니다.</td>
			</tr>
			<tr>
				<td class="help-th"><img src="/admin/skin/default/images/design/guide_img_folder.gif"></td>
				<td class="help-td">해당 브랜드의 정보를 확인할 수 있습니다.</td>
			</tr>
			<tr>
				<td class="help-th"><img src="/admin/skin/default/images/design/guide_img_move.gif"></td>
				<td class="help-td">선택된 브랜드에서 마우스로 드래그하여 순서를 조정할 수 있습니다.</td>
			</tr>
<!-- 			<tr> -->
<!-- 				<td class="help-th"><img src="/admin/skin/default/images/design/guide_img_mouse_r.gif"></td> -->
<!-- 				<td class="help-td"  style="height:180px;">선택 브랜드에서 오른쪽마우스를 클릭하면 아래와 같이 퀵매뉴가 나타납니다.<br/> -->
<!-- 				<img src="/admin/skin/default/images/design/guide_img_right_sample.gif"><br>&nbsp;</td> -->
<!-- 			</tr> -->
		</table>
	</div>
		
	<div style="padding-left:311px;">
		<table width="100%" class="info-table-style" id="categoryInfoFirst">
			<col />	
			<tr>
			<th class="its-th" style="height:20px; padding-left:15px;">브랜드 정보</th>
			</tr>
			<tbody>
			<tr>				
				<td class="its-td">
					<span class="btn small cyanblue"><input type="button" value="생성"/></span> 버튼을 클릭하여 브랜드를 생성할 수 있습니다.
				</td>
			</tr>			
			</tbody>
		</table>
		
		<div id="categorySettingContainer"></div>
	</div>
</div>

<?php if($TPL_VAR["groups"]){?>
<div id="setGroupsPopup" class="hide">
<?php if($TPL_groups_1){foreach($TPL_VAR["groups"] as $TPL_V1){?>
<div style="float:left;padding-right:5px;">
	<label><input type="checkbox" name="memberGroup" value="<?php echo $TPL_V1["group_seq"]?>" class="line" ><?php echo $TPL_V1["group_name"]?></label>
</div>
<?php }}?>
</div>
<?php }?>

</form>


<!-- 서브메뉴 바디 : 끝 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>


<!-- JavaScript neccessary for the tree -->
<script type="text/javascript">

var categoryUrl = gl_protocol+"<?php echo $_SERVER["HTTP_HOST"]?>/goods/brand?code=";
$(function () {

var treeLoaded = false;
var node_cnt = 0;

$("#tree")
	.bind("before.jstree", function (e, data) {
		$("#alog").append(data.func + "<br />");		
	})
	.jstree({ 
		// List of active plugins
		"plugins" : [ 
			"themes","json_data","ui","crrm","cookies","dnd","search","types","hotkeys","contextmenu" 
		],

		// I usually configure the plugin that handles the data first
		// This example uses JSON as it is most common
		"json_data" : { 
			// This tree is ajax enabled - as this is most common, and maybe a bit more complex
			// All the options are almost the same as jQuery's AJAX (read the docs)
			"ajax" : {
				// the URL to fetch the data
				"url" : "./tree",
				// the `data` function is executed in the instance's scope
				// the parameter is the node being loaded 
				// (may be -1, 0, or undefined when loading the root nodes)
				"data" : function (n) { 
					// the result is fed to the AJAX request `data` option					
					return { 
						"operation" : "get_children",
						"id" : n.attr ? n.attr("id").replace("node_","") : 1 
					}; 
					
				}
			}
		},
		
		
		// Using types - most of the time this is an overkill
		// read the docs carefully to decide whether you need types
		"types" : {
			// I set both options to -2, as I do not need depth and children count checking
			// Those two checks may slow jstree a lot, so use only when needed
			"max_depth" : -2,
			"max_children" : -2,
			// I want only `drive` nodes to be root nodes 
			// This will prevent moving or creating any other type as a root node
			"valid_children" : [ "drive" ],
			"types" : {
				// The default type
				"default" : {
					// I want this type to have no children (so only leaf nodes)
					// In my case - those are files
					"valid_children" : "none",
					// If we specify an icon for the default type it WILL OVERRIDE the theme icons
					
				},
				// The `folder` type
				"folder" : {
					// can have files and other folders inside of it, but NOT `drive` nodes
					"valid_children" : [ "default", "folder" ],
					
				},
				// The `drive` nodes 
				"drive" : {
					// can have files and folders inside, but NOT other `drive` nodes
					"valid_children" : [ "default", "folder" ],
					"icon" : {
						"image" : "/admin/skin/default/images/common/_drive.png"
					},
					// those prevent the functions with the same name to be used on `drive` nodes
					// internally the `before` event is used
					"start_drag" : false,
					"move_node" : false,
					"delete_node" : false,
					"remove" : false
				}
			}
		},
		// UI & core - the nodes to initially select and open will be overwritten by the cookie plugin

		// the UI plugin - it handles selecting/deselecting/hovering nodes
		/*"ui" : {
			// this makes the node with ID node_4 selected onload
			"initially_select" : [ "node_2" ]
		},
		*/
		// the core plugin - not many options here
		"core" : { 
			// just open those two nodes up
			// as this is an AJAX enabled tree, both will be downloaded from the server
			"initially_open" : [ "node_2" ] 
		},
		"ui" : {
			"select_limit" : 1
		}
	})
	.bind("create.jstree", function (e, data) {
		$.post(
			"./tree", 
			{ 
				"operation" : "create_node", 
				"id" : data.rslt.parent.attr("id").replace("node_",""), 
				"position" : data.rslt.position,
				"title" : data.rslt.name,
				"type" : 'folder'
			}, 
			function (r) {
				if(r == 'auth'){
					alert('권한이 없습니다.');
					location.reload();
					return;
				}else{
					if(r.status) {
						$(data.rslt.obj).attr("id", "node_" + r.id);
					}
					else {
						$.jstree.rollback(data.rlbk);
					}
					data.inst.refresh();
				}
			}
		);		
	})
	.bind("remove.jstree", function (e, data) {		
		data.rslt.obj.each(function () {
			$.ajax({
				async : false,
				type: 'POST',
				url: "./tree",
				data : { 
					"operation" : "remove_node", 
					"id" : this.id.replace("node_","")
				}, 
				success : function (r) {
					if(r == 'auth'){
						alert('권한이 없습니다.');
						location.reload();
						return;
					}else{
						if(!r.status) {
							data.inst.refresh();
						}
					}
				}
			});
		});				
	})
	.bind("rename.jstree", function (e, data) {
		$.post(
			"./tree", 
			{ 
				"operation" : "rename_node", 
				"id" : data.rslt.obj.attr("id").replace("node_",""),
				"title" : data.rslt.new_name
			}, 
			function (r) {
				if(r == 'auth'){
					alert('권한이 없습니다.');
					location.reload();
					return;
				}else{
					if(!r.status) {
						$.jstree.rollback(data.rlbk);
					}
				}
			}
		);		
	})
	.bind("before.jstree",function(e, data){
		if(data.func == "delete_node" && data.plugin == "core"){
			var category_name = '';
			category_name = data.inst.data.ui.selected[1] ? data.inst.data.ui.selected[1].innerText : data.inst.data.ui.selected[0].innerText;
			if(confirm("삭제된 브랜드는 복구할 수 없습니다.\n브랜드("+$.trim(category_name)+")를 삭제하시겠습니까?")===false){
				e.stopImmediatePropagation();
				return false;
			}
		}

		if(data.func == "move_node" && data.args[1] == false && data.plugin == "core"){
			if(confirm("처리하시겠습니까?")===false){
				e.stopImmediatePropagation();
				return false;
			}
		}
	})
	.bind("move_node.jstree", function (e, data) {
		$.ajax({
			async : false,
			type: 'POST',
			url: "./tree",
			data : { 
				"operation" : "move_node", 
				"id" : data.rslt.o.eq(0).attr("id").replace("node_",""), 
				"ref" : data.rslt.cr === -1 ? 1 : data.rslt.np.attr("id").replace("node_",""), 
				"position" : data.rslt.cp + 0,
				"title" : data.rslt.name,
				"copy" : data.rslt.cy ? 1 : 0					
			},
			success : function (r) {
				if(r == 'auth'){
					alert('관리자 권한이 없습니다.');
					location.reload();
					return;
				}else{
					if(!r.status) {
						if(r['msg']!=undefined && r['msg'].length){
							alert(r['msg']);
						}
						$.jstree.rollback(data.rlbk);
					}
					else {
						$(data.rslt.oc).attr("id", "node_" + r.id);
						$(data.rslt.oc).find("ins").attr('category',r.category_code);
						if(data.rslt.cy && $(data.rslt.oc).children("UL").length) {
							data.inst.refresh(data.inst._get_parent(data.rslt.oc));							
						}
						if(!data.rslt.cy){
							$('#tree').jstree('refresh',-1);
							viewCategoryInfo({'mode':'info','categoryCode':r.category_code});
						}
					}
				}				
			}
		});	
	})
	.bind("open_node.jstree", function (e, data) {
		
    })
	.bind("load_node.jstree", function (node) {
		
		/* 별표 색상강조 */
		$("li[rel!='drive']",node.target).each(function(){
			$(this).html($(this).html().replace(/★<\/a>/gi,"<span class=\"point_star\">★</span></a>"));
		});	
			
		if(!treeLoaded && $("#tree>ul>li:eq(0)").length){
			treeLoaded = true;
			$.jstree._focused().deselect_all();
			$.jstree._focused().select_node($("#tree>ul>li:eq(0)")[0]);
			$("#tree>ul>li:eq(0) a").click();
			
		}
	});
		
});

$(function () { 
	$("#mmenu input").click(function () {		
		switch(this.id) {
			case "add_folder":
				$("#tree").jstree("create", null, "last", { "attr" : { "rel" : this.id.toString().replace("add_", "") } });
				break;			
			default:
				$("#tree").jstree(this.id);
				break;
		}
	});
});


</script>