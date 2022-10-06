<?php /* Template_ 2.2.6 2022/05/17 12:31:36 /www/music_brother_firstmall_kr/admin/skin/default/design/layout.html 000044681 */ 
$TPL_folders_1=empty($TPL_VAR["folders"])||!is_array($TPL_VAR["folders"])?0:count($TPL_VAR["folders"]);
$TPL_loop_font_1=empty($TPL_VAR["loop_font"])||!is_array($TPL_VAR["loop_font"])?0:count($TPL_VAR["loop_font"]);
$TPL_layout_header_config_1=empty($TPL_VAR["layout_header_config"])||!is_array($TPL_VAR["layout_header_config"])?0:count($TPL_VAR["layout_header_config"]);
$TPL_layout_TopBar_config_1=empty($TPL_VAR["layout_TopBar_config"])||!is_array($TPL_VAR["layout_TopBar_config"])?0:count($TPL_VAR["layout_TopBar_config"]);
$TPL_layout_side_config_1=empty($TPL_VAR["layout_side_config"])||!is_array($TPL_VAR["layout_side_config"])?0:count($TPL_VAR["layout_side_config"]);
$TPL_layout_footer_config_1=empty($TPL_VAR["layout_footer_config"])||!is_array($TPL_VAR["layout_footer_config"])?0:count($TPL_VAR["layout_footer_config"]);
$TPL_layout_scroll_config_1=empty($TPL_VAR["layout_scroll_config"])||!is_array($TPL_VAR["layout_scroll_config"])?0:count($TPL_VAR["layout_scroll_config"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript">
	$(function(){		
<?php if($TPL_VAR["mode"]!='create'){?>
<?php if($TPL_VAR["tpl_path"]=='basic'){?>
				parent.DM_window_title_set("center","<?php echo $TPL_VAR["skin"]?> 스킨의 ");
				parent.DM_window_title_set("title","전체 레이아웃 설정");
<?php }else{?>
				parent.DM_window_title_set("center","<?php echo $TPL_VAR["tpl_desc"]?>(<?php echo $TPL_VAR["tpl_path"]?>)");
<?php }?>
<?php }?>
			
		/* 폰트 셀렉트박스 변경시 예시 스타일 변경 */
		$("select[name='font']").change(function(){
			$(".font-view").css({
				'font-family'	: $(this).val(),
				'font-size'		: '12px',
				'color'			: '#0000ff'
			});
		}).change();
		
		/* 레이아웃 미리보기 이벤트 */
		$("input[name='width'],input[name='body_width']").bind('change',function(){
			var width = $("input[name='width']").val();
			var body_width = $("input[name='body_width']").val();
			
			$("#layout-preview-body").animate({'width':body_width/width*100 + '%'});
		}).change();
		
		$("input[name='layoutHeaderChk']").bind('change click',function(){
			if($(this).val()=='hidden') $("#layout-preview-header").hide();
			else{
				$("#layout-preview-header").show();
			}
		});

		$("input[name='layoutTopBarChk']").bind('change click',function(){
			if($(this).val()=='hidden') $("#layout-preview-topbar").hide();
			else{
				$("#layout-preview-topbar").show();
			}
		});

		$("input[name='layoutFooterChk']").bind('change click',function(){
			if($(this).val()=='hidden') $("#layout-preview-footer").hide();
			else{
				$("#layout-preview-footer").show();
			}
		});
		
		$("input[name='layoutSideChk']").bind('change click',function(){
			if($(this).val()=='hidden') {
				$("#layout-preview-side-left").hide();
				$("#layout-preview-side-right").hide();
			}
			else{
				if($("select[name='layoutSideLocation']").val() == 'left'){
					$("#layout-preview-side-left").show();
					$("#layout-preview-side-right").hide();
				}
				if($("select[name='layoutSideLocation']").val() == 'right'){
					$("#layout-preview-side-right").show();
					$("#layout-preview-side-left").hide();				
				}
			}
		});
		$("select[name='layoutSideLocation']").change(function(){
			$("input[name='layoutSideChk']:checked").change();	
		});
		
		$("input[name='layoutScrollLeftChk']").bind('change click',function(){
			if($(this).val()=='hidden') $("#layout-preview-scroll-left").hide();
			else{
				$("#layout-preview-scroll-left").show();
			}
		});
		
		$("input[name='layoutScrollRightChk']").bind('change click',function(){
			if($(this).val()=='hidden') $("#layout-preview-scroll-right").hide();
			else{
				$("#layout-preview-scroll-right").show();
			}
		});
		
		/* 라디오,체크박스 변경시 텍스트항목에 disabled 효과 */
		$("input[type='radio'],input[type='checkbox']")
		.each(function(){
			
			$("input[name='"+$(this).attr('name')+"'][disableSelector]").each(function(){
				$($(this).attr('disableSelector')).attr('disabled',true);
			});
			
			$(this).bind('change',function(){
				$("input[name='"+$(this).attr('name')+"'][disableSelector]").each(function(){
					$($(this).attr('disableSelector')).attr('disabled',true);
				});
				if($(this).is(":checked") && $(this).attr('disableSelector')){
					$($(this).attr('disableSelector')).removeAttr('disabled');
				}
			});
		});
		$("input[type='radio']:checked,input[type='checkbox']:checked").change();
		
		/* 수정여부 체크버튼 */
		$(".edit-panel-chk").change(function(){
			if($(this).is(':checked')){
				$(this).parent().parent().children(".edit-panel").show();
				$(this).parent().parent().children(".edit-panel").find("input,select option,textarea").each(function(){
					$(this).data('original-value',$(this).val());		
					$(this).data('original-checked',$(this).attr('checked')?true:false);
					$(this).data('original-selected',$(this).attr('selected')?true:false);
					$(this).data('original-disabled',$(this).attr('disabled')?true:false);
					if($(this).is(':checked') || $(this).is(':selected')) $(this).change();
				});
			}
			else{
				$(this).parent().parent().children(".edit-panel").hide();
				$(this).parent().parent().children(".edit-panel").find("input,select option,textarea").each(function(){
					$(this).val($(this).data('original-value'));
					$(this).attr('checked',$(this).data('original-checked')==undefined?false:$(this).data('original-checked'));
					$(this).attr('selected',$(this).data('original-selected')==undefined?false:$(this).data('original-selected'));
					$(this).attr('disabled',$(this).data('original-disabled')==undefined?false:$(this).data('original-disabled'));
					if($(this).is(':checked') || $(this).is(':selected')) $(this).change();
				});
			}
		});
		
		/* 새페이지 만들기 모드 */
<?php if($TPL_VAR["mode"]=='create'){?>
			$("select[name='tpl_folder']").change(function(){
				if($(this).val().substring(0,7)=='layout_'){
					$("#layout-preview, .layout-configuration-table, .layout-configuration-table *:not(select,option), .apply_type_select").attr("disabled",true);
					$("#layout-preview, .apply_type_select").hide();
				}else{
					$("#layout-preview, .layout-configuration-table, .layout-configuration-table *, .apply_type_select").removeAttr("disabled");
					$("#layout-preview, .apply_type_select").show();
				}
			}).change();
			
			
			/* 새 페이지 파일명 중복확인 관련 */
			$("select[name='tpl_folder'], input[name='tpl_file_name'], select[name='tpl_file_ext']").change(function(){
				$("input[name='tpl_file_name_chk']").val('');
			});
			
			$("#tpl_file_name_chk_btn").click(function(){
				
				if($("input[name='tpl_file_name']").val()==''){
					openDialogAlert("파일명을 입력해주세요.",400,140,function(){$("input[name='tpl_file_name']").focus();});
					return;
				}
				
				var param = {
					'tpl_folder'	: $("select[name='tpl_folder']") .val(),
					'tpl_file_name'	: $("input[name='tpl_file_name']") .val(),
					'tpl_file_ext'	: $("select[name='tpl_file_ext']") .val()
				};

				$.ajax({
					'url' : '../design_process/tpl_file_name_chk',
					'data' : param,
					'success' : function(res){
						if(res=='0'){
							openDialogAlert("파일명을 사용할 수 없습니다.",400,140);
							$("input[name='tpl_file_name_chk']").val('');
						}else if(res=='1'){
							openDialogAlert("같은 이름의 파일이 존재합니다.",400,140);
							$("input[name='tpl_file_name_chk']").val('');
						}else{
							openDialogAlert("파일명을 사용할 수 있습니다.",400,140);
							$("input[name='tpl_file_name_chk']").val('1');
						}
					}
				});
				
			});
			
			
<?php }?>
		
		/* 컬러피커 */
		$(".colorpicker").customColorPicker({'hide':false});
	});

	/*사이즈 관련 script start*/
	function chk_size_p() {
		var w = Number($(".width").val());
		var b = Number($(".body_width").val());
		var _value = Number(event.srcElement.value);
		if($("select[name='"+event.srcElement.className+"_sign']").val() == '%') {
			if(_value > 100) { // 퍼센트일때 100까지 입력가능
				alert("최대 100%까지 가능합니다.");
				$("."+event.srcElement.className).val("");
			}
		} else if($("select[name='width_sign']").val() == 'pixel' && $("select[name='body_width_sign']").val() == 'pixel') {
			if(w < b) {
				alert("전체 크기 이하로 가능합니다.");
				$(".body_width").val("");
			}
		} 
		if((event.keyCode>57&&event.keyCode<96)||event.keyCode>105){	//event.keyCode<48
			alert("숫자만 입력하실 수 있습니다.");
			return false;
		}
	}

	function per_change() {
		if($("select[name='width_sign']").val() == "%") {
			alert("전체가 %일 경우 본문도 %로만 입력이 가능합니다.");
			$("select[name='body_width_sign']").val("%");
			$(".width").val("100");
			$(".body_width").val("");
			$(".body_width_sign option:eq(0)").hide();
		} else {
			$(".width").val();
			$(".body_width").val();
		}
	}


	function all_chk_save() {
		var w = Number($(".width").val());
		var b = Number($(".body_width").val());
		
		if($("select[name='width_sign']").val() == 'pixel') {
			if($("select[name='body_width_sign']").val() == 'pixel') {
				if(w < b) {
					alert("전체 크기 이하로 가능합니다.");
					$(".body_width").val("");
					return false;
				} 
			} else {
				if(b > 100) {
					alert("최대 100%까지 가능합니다.");
					$(".body_width").val("");
					return false;
				}
			}
		} else if($("select[name='width_sign']").val() == '%') {
			if((w > 100) || (b > 100)) {
				alert("최대 100%까지 가능합니다");
				if(w > 100) {
					$(".width").val("");
					return false;
				} else {
					$(".body_width").val("");
					return false;
				}
			}
		}
		else {

		}
		$("#layout_setting_form").submit();
	}
	/*end*/
</script>
<style type="text/css">
	.edit-panel {display:none;}
	.edit-panel-chk-label {padding-right:15px;}

	#layout-preview {width:780px; margin:auto; padding-bottom:10px; position:relative;}
	#layout-preview .layout-preview-border {border:1px solid #4bc0e6;}
	#layout-preview-header			{}
	#layout-preview-footer			{}
	#layout-preview-side-left		{}
	#layout-preview-side-right		{}
	#layout-preview-body	.layout-preview-border {border:1px solid #0077c0; background-color:#dceaea}
	#layout-preview-scroll-left		{position:absolute; margin-top:5px; margin-left:-95px; width:90px;}
	#layout-preview-scroll-right	{position:absolute; margin-top:5px; margin-left:5px; left:100%; width:90px;}

	table.layout-configuration-table {margin:auto; border:1px solid #2b2b2b;}
	table.layout-configuration-table th,
	table.layout-configuration-table td {height:30px; line-height:30px; border-top:1px solid #d3d3d3; border-left:1px solid #d3d3d3; text-indent:10px;}
	table.layout-configuration-table th {background-color:#ededed}
	table.layout-configuration-table tr td:first-child {border-left:0px;}
	table.layout-configuration-table tr:first-child td {border-top:0px;}

	.apply_type_select {margin:5px 0 30px 0; text-align:center; font-size:11px;}
	.apply_type_select b {color:#c52a00; font-weight:normal;}
	.apply_type_select input {margin:0 10px;}

	.topbar{color:#ff0000;font-size:11px;line-height:15px;margin:0;padding-left:10px;text-indent:0}
</style>

<div style="padding:15px;">	
	<form name="layout_setting_form" id="layout_setting_form" action="../design_process/layout" method="post" enctype="multipart/form-data" target="actionFrame" onsubmit="loadingStart()">
	<input type="hidden" name="mode" value="<?php echo $TPL_VAR["mode"]?>" />
<?php if($TPL_VAR["mode"]=='edit'){?><input type="hidden" name="tpl_path" value="<?php echo $TPL_VAR["tpl_path"]?>" /><?php }?>

<?php if($TPL_VAR["mode"]=='create'){?>
	<input type="hidden" name="tpl_file_name_chk" value="" />
	<table class="layout-configuration-table" cellpadding="0" cellspacing="0">
		<col width="220" /><col width="760" />
		<tr>
			<th>스킨 &gt; 디렉토리 &gt; 파일명</th>
			<td>
				<?php echo $TPL_VAR["designWorkingSkin"]?> &gt;
				<select name="tpl_folder">
<?php if($TPL_folders_1){foreach($TPL_VAR["folders"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>" <?php if($TPL_K1=='etc'){?>selected<?php }?>><?php echo $TPL_K1?>(<?php echo $TPL_V1?>)</option>
<?php }}?>
				</select> &gt;
				<input type="text" name="tpl_file_name" value="newfile" class="line" />
				<select name="tpl_file_ext">
				<option value="html">.html</option>
				</select>
				<span class="btn small"><input type="button" value="중복확인" id="tpl_file_name_chk_btn" /></span>
			</td>
		</tr>
		<tr>
			<th>페이지 설명</th>
			<td>
				<input type="text" name="tpl_desc" value="" style="width:96%" class="line" />
			</td>
		</tr>
	</table>
	<br />
<?php }?>

	<div id="layout-configuration-tab-source" style="display:none">
		소스편집기
	</div>
	
	<div id="layout-configuration-tab-config">	
		<!-- 레이아웃 미리보기 : 시작 -->
		<div id="layout-preview">
			<table id="layout-preview-header" class="layout-preview-border" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td height="60">
						<table style="margin:auto;" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100"><b>상단 (Header)</b></td>
							<td>
								<input type="text" name="layout_header_tpl_text" class="line" size="60" value="<?php echo $TPL_VAR["layoutHeader"]?>" readonly/>
								<span class="btn small"><input type="button" value="소스편집" onclick="parent.DM_window_sourceeditor('<?php echo $TPL_VAR["layoutHeader"]?>')" /></span>
							</td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
<?php if(!$TPL_VAR["mobileMode"]&&$TPL_VAR["config_system"]["operation_type"]!='light'){?>
			<table id="layout-preview-topbar" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td height="5"></td></tr>
				<tr>
					<td>
						<table class="layout-preview-border" width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td height="60">
								<table style="margin:auto;" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="100"><b>상단바 (TopBar)</b></td>
									<td>
										<input type="text" name="layout_topbar_tpl_text" class="line" size="60" value="<?php echo $TPL_VAR["layoutTopBar"]?>" readonly/>
										<span class="btn small"><input type="button" value="소스편집" onclick="parent.DM_window_sourceeditor('<?php echo $TPL_VAR["layoutTopBar"]?>')" /></span>
									</td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
<?php }?>
<?php if($TPL_VAR["mobileMode"]&&($TPL_VAR["tpl_path"]=="main/index.html")&&$TPL_VAR["config_system"]["operation_type"]!='light'){?>
			<table id="layout-preview-topbar" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td height="5"></td></tr>
				<tr>
					<td>
						<table class="layout-preview-border" width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td height="100">
								<table style="margin:auto;" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="100"><b>메인 상단바 (MainTopBar)</b></td>
									<td>
										<input type="text" name="layout_mainTopbar_tpl_text" class="line" size="60" value="<?php echo $TPL_VAR["layoutMainTopBar"]?>" readonly/>
										<span class="btn small"><input type="button" value="소스편집" onclick="parent.DM_window_sourceeditor('<?php echo $TPL_VAR["layoutMainTopBar"]?>')" /></span>
									</td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
<?php }?>
<?php if(!$TPL_VAR["mobileMode"]&&$TPL_VAR["config_system"]["operation_type"]!='light'){?>
			<table id="layout-preview-scroll-left" class="layout-preview-border" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td height="80">
						<table width="90%" style="margin:auto;" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td align="center"><b>좌측스크롤<br />(Scroll)</b></td>
						</tr>
						<tr>
							<td align="center" class="pdt5"><span class="btn small"><input type="button" value="소스편집" onclick="parent.DM_window_sourceeditor('<?php echo $TPL_VAR["layoutScrollLeft"]?>')" /></span></td>
						</tr>
						</table>
					</td>
				</tr>
			</table>	
			<table id="layout-preview-scroll-right" class="layout-preview-border" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td height="80">
						<table width="90%" style="margin:auto;" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td align="center"><b>우측스크롤<br />(Scroll)</b></td>
						</tr>
						<tr>
							<td align="center" class="pdt5"><span class="btn small"><input type="button" value="소스편집" onclick="parent.DM_window_sourceeditor('<?php echo $TPL_VAR["layoutScrollRight"]?>')" /></span></td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
<?php }?>			
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td height="5"></td></tr>
				<tr>
<?php if(!$TPL_VAR["mobileMode"]&&$TPL_VAR["config_system"]["operation_type"]!='light'){?>
					<td id="layout-preview-side-left" style="padding-right:5px;">
						<table height="140" class="layout-preview-border" width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td align="center"><b>측면 (Side)</b></td>
								</tr>
								<tr>
									<td align="center"><span class="btn small"><input type="button" value="소스편집"  onclick="parent.DM_window_sourceeditor('<?php echo $TPL_VAR["layoutSide"]?>')"/></span></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
					</td>
<?php }?>
					<td id="layout-preview-body">
						<table height="140" class="layout-preview-border" width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>
<?php if($TPL_VAR["mode"]=='create'){?>
								<table style="margin:auto;" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="100"><b>본문 (Body)</b></td>
									<td width="440">
										<input type="text" name="layout_body_tpl_text" class="line" size="60" value="새 페이지" readonly/>
									</td>
								</tr>
								</table>
<?php }else{?>
								<table style="margin:auto;" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="100"><b>본문 (Body)</b></td>
									<td width="440">
										<input type="text" name="layout_body_tpl_text" class="line" size="60" value="<?php echo $TPL_VAR["tpl_path"]?>" readonly/>
<?php if($TPL_VAR["tpl_path"]!='basic'){?>
										<span class="btn small"><input type="button" value="소스편집" onclick="parent.DM_window_sourceeditor('<?php echo $TPL_VAR["tpl_path"]?>')" /></span>
<?php }?>
									</td>
								</tr>
								</table>
<?php }?>
							</td>
						</tr>
						</table>
					</td>
<?php if(!$TPL_VAR["mobileMode"]&&$TPL_VAR["config_system"]["operation_type"]!='light'){?>
					<td id="layout-preview-side-right" style="padding-left:5px;">
						<table height="140" class="layout-preview-border" width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<table width="90%" style="margin:auto;" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td align="center"><b>측면 (Side)</b></td>
								</tr>
								<tr>
									<td align="center"><span class="btn small"><input type="button" value="소스편집" onclick="parent.DM_window_sourceeditor('<?php echo $TPL_VAR["layoutSide"]?>')" /></span></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
					</td>
<?php }?>
				</tr>
				<tr><td height="5"></td></tr>
			</table>			
			<table id="layout-preview-footer" class="layout-preview-border" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td height="60">
						<table style="margin:auto;" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100"><b>하단 (Footer)</b></td>
							<td>
								<input type="text" name="layout_footer_tpl_text" class="line" size="60" value="<?php echo $TPL_VAR["layoutFooter"]?>" readonly/>
								<span class="btn small"><input type="button" value="소스편집" onclick="parent.DM_window_sourceeditor('<?php echo $TPL_VAR["layoutFooter"]?>')" /></span>
							</td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<!-- 레이아웃 미리보기 : 시작 -->
	
		<table class="layout-configuration-table" cellpadding="0" cellspacing="0">
			<col width="180" /><col width="240" /><col width="550" />
			<tr>
				<th>항목</th>
				<th>현재 설정</th>
				<th>설정 변경</th>
			</tr>
<?php if($TPL_VAR["mode"]=='edit'){?>
			<tr>
				<td>설명</td>
				<td>
					<?php echo $TPL_VAR["tpl_desc"]?>

				</td>
				<td>
					<input type="text" name="tpl_desc" value="<?php echo $TPL_VAR["tpl_desc"]?>" class="line" style="width:94%" />
				</td>
			</tr>
<?php }?>
<?php if(!$TPL_VAR["mobileMode"]&&$TPL_VAR["config_system"]["operation_type"]!='light'){?>
<?php if($TPL_VAR["mode"]=='edit'&&$TPL_VAR["tpl_path"]!='basic'){?>
				<tr>
					<td>사이즈</td>
					<td>
						전체 <?php echo number_format($TPL_VAR["width"])?> <?php if($TPL_VAR["width_sign"]=='%'){?>%<?php }else{?>pixel<?php }?> / 본문 <?php echo number_format($TPL_VAR["body_width"])?>  <?php if($TPL_VAR["body_width_sign"]=='%'){?>%<?php }else{?>pixel<?php }?>
					</td>
					<td>
						<label class="edit-panel-chk-label"><input type="checkbox" class="edit-panel-chk" /> 수정</label>
						<span class="edit-panel">
							전체 <input type="text" name="width" class="width" onkeyup="chk_size_p()" value="<?php echo $TPL_VAR["width"]?>" class="line" size="5" maxlength="4" /> <select name="width_sign" class="width_sign"><option value="px" <?php if($TPL_VAR["width_sign"]!='%'){?>selected<?php }?>>pixel</option><option value="%" onclick="per_change()" <?php if($TPL_VAR["width_sign"]=='%'){?>selected<?php }?>>%</option></select> / 본문 <input type="text" name="body_width" class="body_width" onkeyup="chk_size_p()" value="<?php echo $TPL_VAR["body_width"]?>" class="line" size="5" maxlength="4" /> <select name="body_width_sign" class="body_width_sign"><option value="px" onclick="per_change()" <?php if($TPL_VAR["body_width_sign"]!='%'){?>selected<?php }?>>pixel</option><option value="%" <?php if($TPL_VAR["body_width_sign"]=='%'){?>selected<?php }?>>%</option></select>
						</span>
					</td>
				</tr>
<?php }else{?>
				<tr>
					<td>사이즈</td>
					<td>
						전체 <?php echo number_format($TPL_VAR["width"])?> <?php if($TPL_VAR["width_sign"]=='%'){?>%<?php }else{?>pixel<?php }?> / 본문 <?php echo number_format($TPL_VAR["body_width"])?>  <?php if($TPL_VAR["body_width_sign"]=='%'){?>%<?php }else{?>pixel<?php }?>
					</td>
					<td>
						전체 <input type="text" name="width" class="width" onkeyup="chk_size_p()" value="<?php echo $TPL_VAR["width"]?>" class="line" size="5" maxlength="4" /> <select name="width_sign" class="width_sign"><option value="px" <?php if($TPL_VAR["width_sign"]!='%'){?>selected<?php }?>>pixel</option><option value="%" onclick="per_change()" <?php if($TPL_VAR["width_sign"]=='%'){?>selected<?php }?>>%</option></select> / 본문 <input type="text" name="body_width" class="body_width" onkeyup="chk_size_p()" value="<?php echo $TPL_VAR["body_width"]?>" class="line" size="5" maxlength="4" /> <select name="body_width_sign" class="body_width_sign"><option value="px" onclick="per_change()" <?php if($TPL_VAR["body_width_sign"]!='%'){?>selected<?php }?>>pixel</option><option value="%" <?php if($TPL_VAR["body_width_sign"]=='%'){?>selected<?php }?>>%</option></select>
					</td>
				</tr>
<?php }?>
<?php }?>

<?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>
			<tr>
				<td>정렬</td>
				<td>
<?php if($TPL_VAR["align"]=='center'){?>
					가운데
<?php }elseif($TPL_VAR["align"]=='left'){?>
					좌측
<?php }?>
				</td>
				<td>
<?php if($TPL_VAR["tpl_path"]=='basic'&&$TPL_VAR["mode"]!='create'){?>
					<label><input type="radio" name="align" value="center" <?php if($TPL_VAR["align"]=='center'){?>checked<?php }?> /> 가운데(권장)</label>&nbsp;&nbsp;&nbsp;
					<label><input type="radio" name="align" value="left" <?php if($TPL_VAR["align"]=='left'){?>checked<?php }?> /> 좌측</label>
<?php }else{?>-<?php }?>
				</td>
			</tr>
			<tr>
				<td>폰트</td>
				<td>
<?php if($TPL_VAR["font"]){?><?php echo $TPL_VAR["font"]?><?php }else{?>기본(CSS)<?php }?>
				</td>
				<td>			
<?php if($TPL_VAR["tpl_path"]=='basic'&&$TPL_VAR["mode"]!='create'){?>
					<select name="font">
						<option value="" font_service_seq="" <?php if(!$TPL_VAR["font"]){?>selected<?php }?>>기본</option>
<?php if($TPL_loop_font_1){foreach($TPL_VAR["loop_font"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["font_face"]?>" font_service_seq="<?php echo $TPL_V1["service_seq"]?>" <?php if($TPL_VAR["font"]==$TPL_V1["font_face"]){?>selected<?php }?>><?php echo $TPL_V1["font_name"]?></option>
<?php }}?>
						<option value="dotum" font_service_seq="" <?php if($TPL_VAR["font"]=='dotum'){?>selected<?php }?>>돋움</option>
						<option value="gulim" font_service_seq="" <?php if($TPL_VAR["font"]=='gulim'){?>selected<?php }?>>굴림</option>
						<option value="batang" font_service_seq="" <?php if($TPL_VAR["font"]=='batang'){?>selected<?php }?>>바탕</option>
						<option value="맑은 고딕" font_service_seq="" <?php if($TPL_VAR["font"]=='맑은 고딕'){?>selected<?php }?>>맑은 고딕</option>					
					</select>
					<input type="hidden" name="font_service_seq" value="" />
					<script>
					function check_font_service(){
						var font_service_seq = $("select[name='font'] option:selected").attr('font_service_seq');
						if( font_service_seq ){
							$("input[name='font_service_seq']").val(font_service_seq);
						}
					}
					$("select[name='font']").change(function(){
						check_font_service();
					});
					check_font_service();
					</script>
					<span class="desc font-view">예) 가나다라1234</span>
<?php }else{?>-<?php }?>
				</td>			
			</tr>
			<tr>
				<td>스크롤색상</td>
				<td>
<?php if($TPL_VAR["scrollbarColor"]){?><?php echo $TPL_VAR["scrollbarColor"]?><?php }else{?>기본(브라우저)<?php }?>
				</td>
				<td>
<?php if($TPL_VAR["tpl_path"]=='basic'&&$TPL_VAR["mode"]!='create'){?>
					<label style="padding-right:14px;"><input type="radio" name="scrollbarChk" <?php if(!$TPL_VAR["scrollbarColor"]){?>checked<?php }?> /> 기본</label>
					<label><input type="radio" name="scrollbarChk" disableSelector=".scrollbarColorLabel" <?php if($TPL_VAR["scrollbarColor"]){?>checked<?php }?> /></label> <input type="text" name="scrollbarColor" value="<?php echo $TPL_VAR["scrollbarColor"]?>" size="7" maxlength="20" class="line scrollbarColorLabel colorpicker" />
<?php }else{?>-<?php }?>
				</td>
			</tr>
			<tr>
				<td>배경색</td>
				<td>
<?php if($TPL_VAR["backgroundColor"]){?><?php echo $TPL_VAR["backgroundColor"]?><?php }elseif($TPL_VAR["backgroundImage"]){?><img src="<?php echo $TPL_VAR["backgroundImage"]?>" width="20" height="20" align="absmiddle"/><?php }else{?>-<?php }?>
				</td>
				<td>
					<label class="edit-panel-chk-label" style="padding-right:14px;"><input type="checkbox" name="backgroundSetChk" class="edit-panel-chk" /> 수정</label>
					<span class="edit-panel">
						<label><input type="radio" name="backgroundChk" value="color" disableSelector=".backgroundColorLabel" <?php if($TPL_VAR["backgroundColor"]){?>checked<?php }?> /></label> <input type="text" name="backgroundColor" value="<?php if($TPL_VAR["backgroundColor"]){?><?php echo $TPL_VAR["backgroundColor"]?><?php }else{?>#ffffff<?php }?>" size="7" maxlength="20" class="line backgroundColorLabel colorpicker" />
						<div style="padding-left:60px;">
							<label><input type="radio" name="backgroundChk" value="image" disableSelector=".backgroundImageLabel" <?php if($TPL_VAR["backgroundImage"]){?>checked<?php }?> /></label>					
							<span class="backgroundImageLabel">
								<select name="backgroundRepeat">
									<option value="repeat" <?php if($TPL_VAR["backgroundRepeat"]=='repeat'){?>selected="selected"<?php }?>>바둑판</option>
									<option value="repeat-x" <?php if($TPL_VAR["backgroundRepeat"]=='repeat-x'){?>selected="selected"<?php }?>>수평반복</option>
									<option value="repeat-y" <?php if($TPL_VAR["backgroundRepeat"]=='repeat-y'){?>selected="selected"<?php }?>>수직반복</option>
									<option value="no-repeat" <?php if($TPL_VAR["backgroundRepeat"]=='no-repeat'){?>selected="selected"<?php }?>>원본 그대로</option>
								</select>
								<select name="backgroundPosition">
									<option value="left top" <?php if($TPL_VAR["backgroundPosition"]=='left top'){?>selected="selected"<?php }?>>좌측상단</option>
									<option value="left center" <?php if($TPL_VAR["backgroundPosition"]=='left center'){?>selected="selected"<?php }?>>좌측중단</option>
									<option value="left bottom" <?php if($TPL_VAR["backgroundPosition"]=='left bottom'){?>selected="selected"<?php }?>>좌측하단</option>
									<option value="center top" <?php if($TPL_VAR["backgroundPosition"]=='center top'){?>selected="selected"<?php }?>>중앙상단</option>
									<option value="center center" <?php if($TPL_VAR["backgroundPosition"]=='center center'){?>selected="selected"<?php }?>>중앙중단</option>
									<option value="center bottom" <?php if($TPL_VAR["backgroundPosition"]=='center bottom'){?>selected="selected"<?php }?>>중앙하단</option>
									<option value="right top" <?php if($TPL_VAR["backgroundPosition"]=='right top'){?>selected="selected"<?php }?>>우측상단</option>
									<option value="right center" <?php if($TPL_VAR["backgroundPosition"]=='right center'){?>selected="selected"<?php }?>>우측중단</option>
									<option value="right bottom" <?php if($TPL_VAR["backgroundPosition"]=='right bottom'){?>selected="selected"<?php }?>>우측하단</option>
								</select>
								<input type="file" name="backgroundImage" size="7" maxlength="50" />
								<input type="hidden" name="oBackgroundImage" value="<?php echo $TPL_VAR["backgroundImage"]?>" />
							</span>
<?php if($TPL_VAR["backgroundImage"]){?><img src="<?php echo $TPL_VAR["backgroundImage"]?>" width="20" height="20" align="absmiddle"/><?php }?>
						</div>
					</span>			
				</td>
			</tr>
<?php }?>

			<tr>
				<td>상단 (Header)</td>
				<td><?php echo $TPL_VAR["layoutHeader"]?></td>
				<td>
					<label class="edit-panel-chk-label"><input type="checkbox" name="layoutHeaderSetChk" class="edit-panel-chk" /> 수정</label>
					<span class="edit-panel">	
						<label><input type="radio" name="layoutHeaderChk" disableSelector=".layoutHeaderLabel" <?php if($TPL_VAR["layoutHeader"]!='hidden'){?>checked<?php }?> /> 선택</label>
						<select name="layoutHeader" class="line layoutHeaderLabel">
<?php if($TPL_layout_header_config_1){foreach($TPL_VAR["layout_header_config"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["tpl_path"]?>" <?php if($TPL_V1["tpl_path"]==$TPL_VAR["layoutHeader"]){?>selected<?php }?>><?php if($TPL_V1["tpl_desc"]){?>[<?php echo $TPL_V1["tpl_desc"]?>] <?php }?><?php echo $TPL_V1["tpl_path"]?></option>
<?php }}?>
						</select>
						<label class="fr mr10"><input type="radio" name="layoutHeaderChk" value="hidden" <?php if($TPL_VAR["layoutHeader"]=='hidden'){?>checked<?php }?> /> 숨기기</label>
					</span>
				</td>
			</tr>
<?php if(!$TPL_VAR["mobileMode"]&&!$TPL_VAR["fammerceMode"]&&$TPL_VAR["config_system"]["operation_type"]!='light'){?>
			<tr>
				<td>상단바 (TopBar)</td>
				<td><?php echo $TPL_VAR["layoutTopBar"]?></td>
				<td>
					<label class="edit-panel-chk-label"><input type="checkbox" name="layoutTopBarSetChk" class="edit-panel-chk" /> 수정</label>
					<span class="edit-panel">	
						<label><input type="radio" name="layoutTopBarChk" disableSelector=".layoutTopBarLabel" <?php if($TPL_VAR["layoutTopbar"]!='hidden'){?>checked<?php }?> /> 선택</label>
						<select name="layoutTopBar" class="line layoutTopBarLabel">
<?php if($TPL_layout_TopBar_config_1){foreach($TPL_VAR["layout_TopBar_config"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["tpl_path"]?>" <?php if($TPL_V1["tpl_path"]==$TPL_VAR["layoutHeader"]){?>selected<?php }?>><?php if($TPL_V1["tpl_desc"]){?>[<?php echo $TPL_V1["tpl_desc"]?>] <?php }?><?php echo $TPL_V1["tpl_path"]?></option>
<?php }}?>
						</select>
						<label class="fr mr10"><input type="radio" name="layoutTopBarChk" value="hidden" <?php if($TPL_VAR["layoutTopBar"]=='hidden'||!$TPL_VAR["layoutTopBar"]){?>checked<?php }?> /> 숨기기</label>
						<p class="topbar">상단바 영역을 선택하셨는데도 보이지 않으세요? 스킨 패치가 되셨는지 확인해 주십시오. <a href="https://firstmall.kr/ec_hosting/customer/patch.php?page=1&patchSeq=608&intRowCount=10&searchTargetShopCode=&searchKeyword=#p608" target="_blank">패치안내></a></p>
					</span>
				</td>
			</tr>
<?php }?>
<?php if($TPL_VAR["mobileMode"]&&($TPL_VAR["tpl_path"]=="main/index.html")&&$TPL_VAR["config_system"]["operation_type"]!='light'){?>
			<tr>
				<td>메인 상단바 (MainTopBar)</td>
				<td><?php echo $TPL_VAR["layoutMainTopBar"]?></td>
				<td>
					<label class="edit-panel-chk-label"><input type="checkbox" name="layoutMainTopBarSetChk" class="edit-panel-chk" /> 수정</label>
					<span class="edit-panel">	
						<label><input type="radio" name="layoutMainTopBarChk" disableSelector=".layoutMainTopBarLabel" <?php if($TPL_VAR["layoutMainTopbar"]!='hidden'){?>checked<?php }?> /> 선택</label>
						<select name="layoutMainTopBar" class="line layoutMainTopBarLabel">
							<option value="layout_MainTopBar/standard.html">layout_MainTopBar/standard.html</option>
						</select>
						<label class="fr mr10"><input type="radio" name="layoutMainTopBarChk" value="hidden" <?php if($TPL_VAR["layoutMainTopBar"]=='hidden'){?>checked<?php }?> /> 숨기기</label>
						<p class="topbar">상단바 영역을 선택하셨는데도 보이지 않으세요?<br />
						스킨 패치가 되셨는지 확인해 주십시오. <a href="https://firstmall.kr/ec_hosting/customer/patch.php?page=1&patchSeq=608&intRowCount=10&searchTargetShopCode=&searchKeyword=#p608" target="_blank">패치안내></a></p>
					</span>
				</td>
			</tr>
<?php }?>
<?php if(!$TPL_VAR["mobileMode"]&&$TPL_VAR["config_system"]["operation_type"]!='light'){?>
<?php if($TPL_VAR["is_fullsize_absolutly"]){?>
				<tr>
					<td>측면 (Side)</td>
					<td>-</td>
					<td>
						이 페이지에서는 측면디자인을 설정 할 수 없습니다.
						<input type="radio" name="layoutSideChk" value="hidden" checked class="hide" />
					</td>
				</tr>
<?php }else{?>
				<tr>
					<td>측면 (Side)</td>
					<td><?php echo $TPL_VAR["layoutSide"]?></td>
					<td>
						<label class="edit-panel-chk-label"><input type="checkbox" name="layoutSideSetChk" class="edit-panel-chk" /> 수정</label>
						<span class="edit-panel">	
							<label><input type="radio" name="layoutSideChk" disableSelector=".layoutSideLabel" <?php if($TPL_VAR["layoutSide"]!='hidden'){?>checked<?php }?> /> 선택</label>
							<select name="layoutSideLocation" class="line layoutSideLabel">
								<option value="left" <?php if($TPL_VAR["layoutSideLocation"]=='left'){?>selected<?php }?>>좌측</option>
								<option value="right" <?php if($TPL_VAR["layoutSideLocation"]=='right'){?>selected<?php }?>>우측</option>
							</select>
							<select name="layoutSide" class="line layoutSideLabel">
<?php if($TPL_layout_side_config_1){foreach($TPL_VAR["layout_side_config"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["tpl_path"]?>" <?php if($TPL_V1["tpl_path"]==$TPL_VAR["layoutSide"]){?>selected<?php }?>><?php if($TPL_V1["tpl_desc"]){?>[<?php echo $TPL_V1["tpl_desc"]?>] <?php }?><?php echo $TPL_V1["tpl_path"]?></option>
<?php }}?>
							</select>
							<label class="fr mr10"><input type="radio" name="layoutSideChk" value="hidden" <?php if($TPL_VAR["layoutSide"]=='hidden'){?>checked<?php }?> /> 숨기기</label>
						</span>
					</td>
				</tr>
<?php }?>
<?php }?>

<?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>
			<tr>
				<td>본문 (Body)</td>
				<td>
<?php if($TPL_VAR["bodyBackgroundColor"]){?><?php echo $TPL_VAR["bodyBackgroundColor"]?><?php }elseif($TPL_VAR["bodyBackgroundImage"]){?><img src="<?php echo $TPL_VAR["bodyBackgroundImage"]?>" width="20" height="20" align="absmiddle"/><?php }else{?>-<?php }?>
				</td>
				<td>
					<label class="edit-panel-chk-label"><input type="checkbox" name="bodyBackgroundSetChk" class="edit-panel-chk" /> 수정</label>
					<span class="edit-panel">
						<label><input type="radio" name="bodyBackgroundChk" value="color" disableSelector=".bodyBackgroundColorLabel" <?php if($TPL_VAR["bodyBackgroundColor"]){?>checked<?php }?> /></label><input type="text" name="bodyBackgroundColor" value="<?php echo $TPL_VAR["bodyBackgroundColor"]?>" size="7" maxlength="20" class="line bodyBackgroundColorLabel colorpicker" />&nbsp;&nbsp;&nbsp;
						<label><input type="radio" name="bodyBackgroundChk" value="image" disableSelector=".bodyBackgroundImageLabel" <?php if($TPL_VAR["bodyBackgroundImage"]){?>checked<?php }?> /></label><span class="bodyBackgroundImageLabel"><input type="file" name="bodyBackgroundImage" size="7" maxlength="50" /></span>
						<input type="hidden" name="oBodyBackgroundImage" value="<?php echo $TPL_VAR["bodyBackgroundImage"]?>" />
<?php if($TPL_VAR["bodyBackgroundImage"]){?><img src="<?php echo $TPL_VAR["bodyBackgroundImage"]?>" width="20" height="20" align="absmiddle"/><?php }?>
					</span>
				</td>
			</tr>
<?php }?>
			<tr>
				<td>하단 (Footer)</td>
				<td><?php echo $TPL_VAR["layoutFooter"]?></td>
				<td>
					<label class="edit-panel-chk-label"><input type="checkbox" name="layoutFooterSetChk" class="edit-panel-chk" /> 수정</label>
					<span class="edit-panel">
						<label><input type="radio" name="layoutFooterChk" disableSelector=".layoutFooterLabel" <?php if($TPL_VAR["layoutFooter"]!='hidden'){?>checked<?php }?> /> 선택</label>
						<select name="layoutFooter" class="line layoutFooterLabel">
<?php if($TPL_layout_footer_config_1){foreach($TPL_VAR["layout_footer_config"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["tpl_path"]?>" <?php if($TPL_V1["tpl_path"]==$TPL_VAR["layoutFooter"]){?>selected<?php }?>><?php if($TPL_V1["tpl_desc"]){?>[<?php echo $TPL_V1["tpl_desc"]?>] <?php }?><?php echo $TPL_V1["tpl_path"]?></option>
<?php }}?>
						</select>
						<label class="fr mr10"><input type="radio" name="layoutFooterChk" value="hidden" <?php if($TPL_VAR["layoutFooter"]=='hidden'){?>checked<?php }?> /> 숨기기</label>
					</span>
				</td>
			</tr>
<?php if(!$TPL_VAR["mobileMode"]&&$TPL_VAR["config_system"]["operation_type"]!='light'){?>
			<tr>
				<td>좌측스크롤 (Scroll)</td>
				<td><?php echo $TPL_VAR["layoutScrollLeft"]?></td>
				<td>
					<label class="edit-panel-chk-label"><input type="checkbox" name="layoutScrollLeftSetChk" class="edit-panel-chk" /> 수정</label>
					<span class="edit-panel">
						<label><input type="radio" name="layoutScrollLeftChk" disableSelector=".layoutScrollLeftLabel" <?php if($TPL_VAR["layoutScrollLeft"]!='hidden'){?>checked<?php }?> /> 선택</label>
						<select name="layoutScrollLeft" class="line layoutScrollLeftLabel">
<?php if($TPL_layout_scroll_config_1){foreach($TPL_VAR["layout_scroll_config"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["tpl_path"]?>" <?php if($TPL_V1["tpl_path"]==$TPL_VAR["layoutScrollLeft"]){?>selected<?php }?>><?php if($TPL_V1["tpl_desc"]){?>[<?php echo $TPL_V1["tpl_desc"]?>] <?php }?><?php echo $TPL_V1["tpl_path"]?></option>
<?php }}?>
						</select>
						<label class="fr mr10"><input type="radio" name="layoutScrollLeftChk" value="hidden" <?php if($TPL_VAR["layoutScrollLeft"]=='hidden'){?>checked<?php }?> /> 숨기기</label>
					</span>
				</td>
			</tr>
			<tr>
				<td>우측스크롤 (Scroll)</td>
				<td><?php echo $TPL_VAR["layoutScrollRight"]?></td>
				<td>
					<label class="edit-panel-chk-label"><input type="checkbox" name="layoutScrollRightSetChk" class="edit-panel-chk" /> 수정</label>
					<span class="edit-panel">
						<label><input type="radio" name="layoutScrollRightChk" disableSelector=".layoutScrollRightLabel" <?php if($TPL_VAR["layoutScrollRight"]!='hidden'){?>checked<?php }?> /> 선택</label>
						<select name="layoutScrollRight" class="line layoutScrollRightLabel">
<?php if($TPL_layout_scroll_config_1){foreach($TPL_VAR["layout_scroll_config"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["tpl_path"]?>" <?php if($TPL_V1["tpl_path"]==$TPL_VAR["layoutScrollRight"]){?>selected<?php }?>><?php if($TPL_V1["tpl_desc"]){?>[<?php echo $TPL_V1["tpl_desc"]?>] <?php }?><?php echo $TPL_V1["tpl_path"]?></option>
<?php }}?>
						</select>
						<label class="fr mr10"><input type="radio" name="layoutScrollRightChk" value="hidden" <?php if($TPL_VAR["layoutScrollRight"]=='hidden'){?>checked<?php }?> /> 숨기기</label>
					</span>
				</td>
			</tr>
<?php }?>
		</table>
	</div><br />
	<div class="apply_type_select" style="margin-bottom:10px">
<?php if($TPL_VAR["tpl_path"]=='basic'&&$TPL_VAR["mode"]=='edit'){?>
		<table style="margin:auto;">
			<tr>
				<td align="left">
					<input type="radio" name="apply_type" value="this" id="apply_type_this" checked /><label for="apply_type_this">위 설정값을 <b>모든 페이지에 일괄</b> 적용합니다.</label>
					<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="desc"><span class="fx12">※</span> 단, 페이지별 항목 설정값이 위의 변경 설정값과 다를 경우 일괄적용에서 제외</span>
				</td>
				<td width="10"></td>
				<td align="left">
					<input type="radio" name="apply_type" value="all" id="apply_type_all" /><label for="apply_type_all">위 설정값을 <b>모든 페이지에 일괄</b> 적용합니다.   </label>
					<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="desc"><span class="fx12">※</span> 단, 마이페이지에 적용된 측면만은 일괄 적용에서 제외</span>
				</td>
			</tr>
		</table>
<?php }else{?>
		<input type="hidden" name="apply_type" value="this" />
		<div class="pdb10">위 설정값을 <b>현재 페이지에</b> 적용합니다.</div>
<?php }?>
	</div>

	<div align="center"><span class="btn large cyanblue"><input type="button" onclick="all_chk_save()" value="적용" /></span></div>	
	</form>	
	<div style="height:20px"></div>
</div>

<!-- 스킨업로드 레이어 -->
<div id="skinUploadDialogLayer" class="hide">
	<form action="../design_process/upload_skin" target="actionFrame" enctype="multipart/form-data" method="post" onsubmit="return upload_skin_submit(this)">
		<table width="100%" class="info-table-style">
		<tr>	
			<td class="its-th">파일첨부</td>
			<td><input type="file" name="skin_zipfile" /></td>
		</tr>
		</table>
		<br />
		
		<div align="center"><span class="btn large"><input type="submit" value="업로드" /></span></div>
	</form>
</div>
 
<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>