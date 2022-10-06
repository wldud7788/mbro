<?php /* Template_ 2.2.6 2022/05/17 12:36:46 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/page_layout.html 000025151 */ 
$TPL_page_menu_1=empty($TPL_VAR["page_menu"])||!is_array($TPL_VAR["page_menu"])?0:count($TPL_VAR["page_menu"]);
$TPL_member_group_1=empty($TPL_VAR["member_group"])||!is_array($TPL_VAR["member_group"])?0:count($TPL_VAR["member_group"]);
$TPL_member_type_1=empty($TPL_VAR["member_type"])||!is_array($TPL_VAR["member_type"])?0:count($TPL_VAR["member_type"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<style type="text/css">
	.info-table-style td { vertical-align:top; }
	.info-table-style .code_area div { display:inline-block; }
	.desc_code { font-size:8pt; color:#d7d9d7;}
	.code_area { background-color:#ebf2fa; }
</style>
<?php if($TPL_VAR["page_tab"]=='banner'||$TPL_VAR["page_tab"]=='navigation'||$TPL_VAR["page_tab"]=='all_navigation'){?>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js"></script>
<?php }?>
<script type="text/javascript">
	var width			= null;
	var height			= null;
	var cmd				= '<?php echo $_GET["cmd"]?>';
	var page_type		= '<?php echo $TPL_VAR["page_type"]?>';
	var page_tab		= '<?php echo $TPL_VAR["page_tab"]?>';

	$(document).ready(function() {
<?php if($TPL_VAR["page_tab"]=='banner'){?>
		Editor.onPanelLoadComplete(function(){
			$(document).resize();
		});
<?php }?>

		// 바로가기 selectbox
		$(".pageselect").click(function(){
			$(this).toggleClass('opened');
		});

		ajax_main_body_layer();
		help_tooltip();
	});

	// 전체 선택 값 이벤트 추가
	function bindChkAll(){
		$('.chk_all').unbind('click');
		$('.chk_all').bind('click', function(){
			if($(this).is(':checked')){
				$('input[name="code[]"]').prop('checked', true).closest('tbody').find('tr').addClass('checked-tr-background');
			}else{
				$('input[name="code[]"]').prop('checked', false).closest('tbody').find('tr').removeClass('checked-tr-background');
			}
		});
	}

	// 리스트 동적 Call
	function ajax_main_body_layer(){
		$.ajax({
			type	: 'GET',
			url		: './page_layout_list',
			data	: {'cmd':page_type, 'tab':page_tab},
			dataType: 'html',
			success	: function(res){
				$("#ajax_main_body").html(res);
			}
		});
	}

	// 차수별 설정 버튼
	function setCtrlBtn(depth){

		// 설정 팝업 사이즈
		switch (page_tab){
			case 'access_limit'	  :	width = '1000'; height = '500'; break;
			case 'banner'		  :	width = '1000'; height = '500'; break;
			case 'recommend'	  :	width = '1200'; height = '700'; break;
			case 'navigation'	  :
			case 'all_navigation' :	width = '1200'; height = '700'; break;
			default :				width = '500'; height = '188'; break;
		}
		$.ajax({
			type	: 'POST',
			url		: './ajax_set_'+page_tab,
			data	: {'cmd':cmd,'page_type':page_type, 'depth':depth},
			dataType: 'html',
			success	: function(res){
				$("#setCtrlLayer").empty();
				$("#setCtrlLayer").html(res);

				openDialog("<?php echo $TPL_VAR["grp_ctrl_txt"]?> - <span class='desc'>" + depth + "차</span>", "setCtrlLayer", {"width":width,"height":height});
			}
		});
	}

	// 예외 TOP 설정 버튼
	function extraTopCtrlBtn(){
		switch (page_tab){
			case 'page_goods'		:
				var pop_url = "/admin/design/display_edit?kind="+page_type+"&sub_kind=batch&popup=1";
				window.open(pop_url,'display_edit',"width=1200,height=700,scrollbars=1");
				break;
			case 'navigation'		:
			case 'all_navigation'	:
				// 네비게이션 소스
				openDialog('소스', 'popSource_'+page_tab, {"width":500,"height": 200});
				break;
			case 'image'			:
				openDialog('베스트 아이콘 등록/수정', 'popSource_'+page_tab, {"width":500,"height": 250});
				break;
			default :
				alert('잘못된 접근입니다.');
				break;
		}
	}

	// 예외 설정 버튼
	function extraCtrlBtn(){
		// 설정 팝업 사이즈
		var page_tab_call = page_tab;
		switch (page_tab){
			case 'page_goods'	:
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
				width = '600'; height = '350'; break;
<?php }else{?>
				width = '900'; height = '550'; break;
<?php }?>
			case 'navigation'		:	width = '800'; height = '500'; break;
			case 'all_navigation'	:	width = '800'; height = '200'; break;
			case 'image'			:
				width = '1000'; height = '800';
				page_tab_call = 'brand_' + page_tab;
				break;
			default :					width = '500'; height = '188'; break;
		}
		alert
		$.ajax({
			type	: 'POST',
			url		: './ajax_set_extra_'+page_tab_call,
			data	: {'page_type':page_type,'page_tab':page_tab},
			dataType: 'html',
			success	: function(res){
				$("#setCtrlLayer").empty();
				$("#setCtrlLayer").html(res);

				openDialog("<?php echo $TPL_VAR["grp_extra_txt"]?>", "setCtrlLayer", {"width":width,"height":height});
			}
		});
	}

	// 예외 서브 설정 버튼
	function extraSubCtrlBtn(target_code){
		// 설정 팝업 사이즈
		switch (page_tab){
			case 'navigation'		:
			case 'all_navigation'	:
				width = '800'; height = '400'; break;
			case 'image'			:	width = '800'; height = '500'; break;
			default :					width = '500'; height = '188'; break;
		}
		$.ajax({
			type	: 'POST',
			url		: './ajax_get_extra_'+page_tab,
			data	: {'page_type':page_type,'page_tab':page_tab, 'target_code' : target_code},
			dataType: 'html',
			success	: function(res){
				$("#setCtrlLayer").empty();
				$("#setCtrlLayer").html(res);

				openDialog("<?php echo $TPL_VAR["grp_extra_txt"]?>", "setCtrlLayer", {"width":width,"height":height});
			}
		});
	}

	// 노출여부 설정 버튼
	function viewCtrlBtn(target_code){
		// 설정 팝업 사이즈
		switch (page_tab){
			case 'navigation'		:
			case 'all_navigation'	:	width = '520'; height = '150'; break;
			case 'image'			:	width = '520'; height = '150'; break;
			default :					width = '500'; height = '188'; break;
		}

		if(page_tab == 'image'){ // 브랜드 메인 추가 타입 예외처리
			var best_yn = $('.codenm_'+target_code).find('.best_yn').html();
			if(best_yn != 'Y')	height = '180';
			setViewCtrlProcess(target_code, best_yn);
		}else{
			viewCtrlBtn_func(target_code, page_tab);
		}
	}

	// 노출여부 설정 실행 함수
	function viewCtrlBtn_func(target_code, page_tab){
		$.ajax({
			type	: 'POST',
			url		: './ajax_get_extra_view_'+page_tab,
			data	: {'page_type':page_type,'page_tab':page_tab, 'target_code' : target_code},
			dataType: 'json',
			success	: function(res){
				if(res.state){
					openDialogConfirmtitle('노출 정보', res.msg, width, height, function(){setViewCtrlProcess(target_code, res.next);}, null, '');
				}else{
					openDialogAlert(res.msg, width, height, null, '');
				}

			}
		});
	}

	// 업데이트 프로세스 실행 함수
	function setViewCtrlProcess(target_code, next){
		if(page_tab == 'image'){
			var msg		= '';
			var best_yn	= next;
			if(best_yn == 'Y'){
				msg = '베스트 브랜드 설정을 해제 하시겠습니까?';
			}else{
				msg = '베스트 브랜드로 설정하시겠습니까?';
				msg += '<br/><span class="desc">설정된 베스트 브랜드는 브랜드 메인페이지, 브랜드 검색필터에서 베스트 아이콘이 노출되며<br/>좌측 삼선 네비게이션 내 베스트 브랜드 영역에 노출됩니다.</span>';
			}
			openDialogConfirmtitle('베스트 브랜드', msg, width, height, function(){
				$.ajax({
					type	: 'POST',
					url		: '../page_manager_process/modify_best_brand',
					data	: {'page_type':page_type,'page_tab':page_tab, 'target_code': target_code, 'best_yn': best_yn},
					dataType: 'json',
					success	: function(res){
						if(res.state){
							alermSuccess();
							ajax_main_body_layer();
						}else{
							openDialogAlert(res.msg, '400', '150', null, '');
						}
					}
				});
			}, null);
		}else{
			$.ajax({
				type	: 'POST',
				url		: '../page_manager_process/modify_hide_'+page_tab,
				data	: {'page_type':page_type,'page_tab':page_tab, 'target_code': target_code, 'next': next},
				dataType: 'json',
				success	: function(res){
					if(res.state){
						alermSuccess();
						ajax_main_body_layer();
					}else{
						openDialogAlert(res.msg, '400', '150', null, '');
					}
				}
			});
		}
	}

	// 해당 설정 View 버튼
	function getCtrlBtn(code){

		// 설정 예외처리
		if(page_tab == 'image')		return false;

		// 선택 명 호출
		var code_name = $(".codenm_"+code).html();

		// view 팝업 사이즈
		switch (page_tab){
			case 'access_limit':
				width = '550'; height = '180'; break;
			case 'banner':
				width = $(document).width() * 0.5;
				height = $(document).height() * 0.5;
				break;
			case 'recommend':		width = '1000'; height = '600'; break;
			case 'page_goods':		width = '1000'; height = '750'; break;
			case 'navigation':
			case 'all_navigation':	width = '640'; height = '170'; break;
			default :				width = '500'; height = '188'; break;
		}

		$.ajax({
			type	: 'POST',
			url		: './ajax_get_'+page_tab,
			data	: {'page_type':page_type, 'code':code},
			dataType: 'html',
			success	: function(res){
				$("#getCtrlLayer").empty();
				$("#getCtrlLayer").html(res);

				openDialog("<?php echo $TPL_VAR["grp_ctrl_txt"]?> - <span class='desc'>" + code_name + "</span>", "getCtrlLayer", {"width":width,"height":height});
			}
		});
	}

	// 해당 설정 서브 팝업 버튼
	function setSubCtrlPop(width, height, chk_cnt, extra){
		var extraPop = extra != null ? extra+'_' : '';
		var option = {"width":width,"height":height};
		if(page_tab == 'banner'){
			option = {"width":width,"height":height,"draggable":false, position: ['center', 'top']};
		}

		if (chk_cnt > 0){
			$(".chk_layer").show();
			$(".chk_cnt").html(chk_cnt);
		}else{
			$(".chk_layer").hide();
		}
		openDialog("등록", "popModifyLayer_"+extraPop+page_tab, option);
	}

	// 이미지 보기 레이어 팝업 이벤트
	function bindImagePopup(){
		$('.imgPopup').unbind('click');
		$('.imgPopup').bind('click', function(){
			$img = $('<img/>').attr('src', $(this).val());
			$('#imgPopupWrap').html($img);
			openDialog('이미지보기', 'imgPopupWrap', {width: '800', height: '600'});
		});
	}

	// 저장 완료 팝업
	function alermSuccess(){
		$('#suckPopup').fadeIn("slow", function(){
			setTimeout(function(){
				$('#suckPopup').fadeOut("fast");
			}, 1200);
		});

	}

	// 네비게이션 소스 복사
	function copy_navigation(page_tab){
		var source_code  = '';
		var uc_page_type = '';

		switch(page_tab){
			case 'navigation':

				uc_page_type = '{\=show<?php echo ucfirst($TPL_VAR["page_type"])?>LightNavigation()}';
				break;

			case 'all_navigation':

				uc_page_type = '<a class="hand <?php echo $TPL_VAR["page_type"]?>AllBtn" title="전체 네비게이션"></a>';
				break;

			default:
				break;
		}

		clipboard_copy(uc_page_type);
		alert('클립보드에 복사되었습니다.');
	}

	// 베스트 브랜드 아이콘 저장
	function set_bestbrand_img(){
		var tmp_file = $("input[name='image_path']").val();

		$.ajax({
			type	: 'POST',
			url		: '../page_manager_process/modify_best_icon',
			data	: {'tmp_file':tmp_file},
			dataType: 'json',
			success	: function(res){
				if(res.img_path){
					$("#preview_best_img").html('<input type="image" width="30px" src="' + res.img_path + '" />');
					closeDialog('popSource_'+page_tab);
					alermSuccess();
				}else{
					alert('업로드에 실패했습니다.');
				}
			}
		});
	}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2><?php echo $TPL_VAR["page_name"]?> 페이지</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li>
				<span class="btn large icon" style="border-radius:2px;"><button type="button" onclick="location.href='/admin/page_manager';"><span class="arrowleft"></span>&lt&nbsp; 전체 리스트</button></span>
			</li>
			<li>
				<div id="pageselect-header">
					<div class="pageselect-container clearbox">
						<ul class="header-snb clearbox">
							<li class="item">
								<div class="pageselect">
									<span class="hsnbm-name">
										설정 바로가기
									</span>
									<span class="icon">&nbsp;&nbsp;</span>
									<ul class="hsnbm-menu">
<?php if($TPL_page_menu_1){foreach($TPL_VAR["page_menu"] as $TPL_V1){?>
<?php if($TPL_VAR["page_name"]==$TPL_V1["name"]){?>
										<li class="selecter"><?php echo $TPL_V1["name"]?></li>
<?php }else{?>
										<li><a href="<?php echo $TPL_V1["link"]?>" <?php if($TPL_V1["target"]){?>target="_blank"<?php }?>><?php echo $TPL_V1["name"]?></a></li>
<?php }?>
<?php }}?>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large default"><a href="../<?php echo $TPL_VAR["page_type"]?>/catalog" target="_blank"><?php echo $TPL_VAR["page_name"]?> 관리</a></span></li>
			<li>&nbsp;</li>
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 페이지 관리 검색바 : 시작 -->
<div style="margin:20px 0;">
<?php $this->print_("tab_menu",$TPL_SCP,1);?>

</div>
<!-- 페이지 관리 검색바 : 끝 -->

<!-- 안내문구 :: 시작 -->
<div class="fl pdl10 pdb10">
	<?php echo $TPL_VAR["page_desc"]?>

</div>
<!-- 안내문구 :: 끝 -->

<!-- 페이지 관리 테이블 : 시작 -->
<?php if($TPL_VAR["is_extra_top"]){?>
<div class="fr pdb5 pdr10">
	<span class="btn large cyanblue fr"><button type="button" onclick="extraTopCtrlBtn()" ><?php echo $TPL_VAR["extra_top_txt"]?></button></span>
<?php if($TPL_VAR["page_tab"]=='image'){?>
	<span class="fr pdr10" id="preview_best_img"><?php if($TPL_VAR["best_icon"]){?><img src="<?php echo $TPL_VAR["best_icon"]?>" width="30px" class="hand" onclick="window.open('<?php echo $TPL_VAR["best_icon"]?>');" /><?php }?></span>
<?php }?>
</div>
<?php }?>
<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
<?php if($TPL_VAR["is_extra_col"]){?>
		<col width="20%" /><!--1차-->
		<col width="20%" /><!--2차-->
		<col width="20%" /><!--3차-->
		<col width="20%" /><!--4차-->
		<col width="20%" /><!--추가필드-->
<?php }else{?>
		<col width="25%" /><!--1차-->
		<col width="25%" /><!--2차-->
		<col width="25%" /><!--3차-->
		<col width="25%" /><!--4차-->
<?php }?>
	</colgroup>
	<thead class="lth">
	<tr>
		<th class="its-th-align">
			<span class="pdl30">1차</span>
<?php if($TPL_VAR["grp_ctrl_yn"]){?><div class="fr pdr10"><span class="btn medium cyanblue"><button type="button" onclick="setCtrlBtn('1')" ><?php echo $TPL_VAR["grp_ctrl_txt"]?></button></span></div><?php }?>
		</th>
		<th class="its-th-align">
			<span class="pdl30">2차</span>
<?php if($TPL_VAR["grp_ctrl_yn"]){?><div class="fr pdr10"><span class="btn medium cyanblue"><button type="button" onclick="setCtrlBtn('2')" ><?php echo $TPL_VAR["grp_ctrl_txt"]?></button></span></div><?php }?>
		</th>
		<th class="its-th-align">
			<span class="pdl30">3차</span>
<?php if($TPL_VAR["grp_ctrl_yn"]){?><div class="fr pdr10"><span class="btn medium cyanblue"><button type="button" onclick="setCtrlBtn('3')" ><?php echo $TPL_VAR["grp_ctrl_txt"]?></button></span></div><?php }?>
		</th>
		<th class="its-th-align">
			<span class="pdl30">4차</span>
<?php if($TPL_VAR["grp_ctrl_yn"]){?><div class="fr pdr10"><span class="btn medium cyanblue"><button type="button" onclick="setCtrlBtn('4')" ><?php echo $TPL_VAR["grp_ctrl_txt"]?></button></span></div><?php }?>
		</th>
<?php if($TPL_VAR["is_extra_col"]){?>
		<th class="its-th-align">
			<span class="pdl30"><?php echo $TPL_VAR["grp_extra_col"]?></span>
<?php if($TPL_VAR["grp_extra_txt"]){?><div class="fr pdr10"><span class="btn medium cyanblue"><button type="button" onclick="extraCtrlBtn()" ><?php echo $TPL_VAR["grp_extra_txt"]?></button></span></div><?php }?>
		</th>
<?php }?>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb" id="ajax_main_body">
	</tbody>
	<!-- 리스트 : 끝 -->
</table>
<!-- 페이지 관리 테이블 : 끝 -->

<!-- 페이지 관리 설정 -->
<div id="setCtrlLayer" class="hide"></div>
<!-- 페이지 관리 뷰어 -->
<div id="getCtrlLayer" class="hide"></div>
<?php if($TPL_VAR["page_tab"]=='access_limit'){?>
<!-- 페이지접속제한 리스트 일괄 수정 팝업 -->
<div id="popModifyLayer_access_limit" class="hide">
	<div class="pdb5 chk_layer">선택 : <span class="chk_cnt">0</span>개</div>
	<form name="targerSettingForm" id="targerSettingForm">
		<div class="hide" id="sel_chk"></div>
		<input type="hidden" name="mode" value="" />
		<input type="hidden" name="page_type" value="<?php echo $TPL_VAR["page_type"]?>" />
		<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="18%" />
				<col width="18%" />
				<col width="" />
			</colgroup>
			<tr>
				<th class="its-th-align" rowspan="2">
					접속자 허용 <span class="helpicon" title="미체크 시 모든 접속자 허용"></span>
				</th>
				<th class="its-th-align">회원등급</th>
				<td class="its-td">
<?php if($TPL_member_group_1){foreach($TPL_VAR["member_group"] as $TPL_V1){?>
					<label><input type="checkbox" name="memberGroup[]" value="<?php echo $TPL_V1["group_seq"]?>" class="line" ><?php echo $TPL_V1["group_name"]?></label>&nbsp;&nbsp;
<?php }}?>
				</td>
			</tr>
			<tr>
				<th class="its-th-align">회원유형</th>
				<td class="its-td">
<?php if($TPL_member_type_1){foreach($TPL_VAR["member_type"] as $TPL_K1=>$TPL_V1){?>
					<label><input type="checkbox" name="userType[]" value="<?php echo $TPL_K1?>" class="line" ><?php echo $TPL_V1?></label>&nbsp;&nbsp;
<?php }}?>
				</td>
			</tr>
			<tr>
				<th class="its-th-align" colspan="2">접속기간 제한</th>
				<td class="its-td">
					<label class="mr10"><input type="radio" name="catalog_allow" value="show" checked /> 없음</label>&nbsp;&nbsp;
					<label class="mr10" for="catalog_allow_period"><input type="radio" name="catalog_allow" value="period" id="catalog_allow_period" class="hand" /> <input type="text" name="catalog_allow_sdate" class="line datepicker" size="11" maxlength="10" /> ~ <input type="text" name="catalog_allow_edate" class="line datepicker" size="11" maxlength="10" /> 기간에만 허가</label>&nbsp;&nbsp;
					<label><input type="radio" name="catalog_allow" value="none" /> 금지</label><br />
				</td>
			</tr>
		</table>
		<div style="padding:10px;" class="center">
			<span class="btn large black"><button type="button" class="saveAccessLimit" onclick="submit_target_update($(this).closest('#targerSettingForm'),'modify');">저장</button></span>
		</div>
	</form>
</div>
<?php }elseif($TPL_VAR["page_tab"]=='banner'){?>
<!-- 페이지배너 리스트 일괄 수정 팝업 -->
<div id="popModifyLayer_banner" class="hide">
	<div class="pdb5 chk_layer">선택 : <span class="chk_cnt">0</span>개</div>
	<form name="targerbannerForm" id="targerbannerForm" method="post" enctype="multipart/form-data" action="../page_manager_process/modify_banner" target="actionFrame">
		<div class="hide" id="sel_chk"></div>
		<input type="hidden" name="mode" value="" />
		<input type="hidden" name="page_type" value="<?php echo $TPL_VAR["page_type"]?>" />
		<div id="top_html_layer"></div>
		<div style="padding:10px;" class="center">
			<span class="btn large black"><button type="button" class="saveAccessLimit" onclick="submit_target_update($(this).closest('#targerbannerForm'),'modify');">저장</button></span>
		</div>
	</form>
</div>
<?php }elseif($TPL_VAR["page_tab"]=='recommend'){?>
<!-- 페이지추천상품 리스트 일괄 수정 팝업 -->
<div id="popModifyLayer_recommend" class="hide">
	<div class="pdb5 chk_layer">선택 : <span class="chk_cnt">0</span>개</div>
	<form name="targerrecommendForm" id="targerrecommendForm" method="post" enctype="multipart/form-data" action="../page_manager_process/modify_recommend" target="actionFrame">
		<div class="hide" id="sel_chk"></div>
		<input type="hidden" name="mode" value="" />
		<input type="hidden" name="page_type" value="<?php echo $TPL_VAR["page_type"]?>" />
		<div id="top_html_layer"></div>
		<div style="padding:10px;" class="center">
			<span class="btn large black"><button type="button" class="saveAccessLimit" onclick="submit_target_update($(this).closest('#targerrecommendForm'),'modify');">저장</button></span>
		</div>
	</form>
</div>
<?php }elseif($TPL_VAR["page_tab"]=='navigation'||$TPL_VAR["page_tab"]=='all_navigation'){?>
<!-- 전체 네비게이션 일괄 수정 팝업 -->
<div id="popModifyLayer_extra_<?php echo $TPL_VAR["page_tab"]?>" class="pd20 hide">
	<form name="targerExtraForm" id="targerExtraForm" method="post" action="../page_manager_process/extra_<?php echo $TPL_VAR["page_tab"]?>" target="actionFrame">
		<div id="sel_chk_extra" class="hide"></div>
		<input type="hidden" name="mode" value="" />
		<input type="hidden" name="page_type" value="<?php echo $TPL_VAR["page_type"]?>" />
		<div id="top_html_layer"></div>
		<div style="padding:10px;" class="center">
			<span class="btn large black"><button type="button" class="saveAccessLimit" onclick="submit_target_update($(this).closest('#targerExtraForm'),'modify');">저장</button></span>
		</div>
	</form>
</div>
<div id="popModifyLayer_<?php echo $TPL_VAR["page_tab"]?>" class="pd20 hide">
<?php $this->print_("_navigation_popup",$TPL_SCP,1);?>

</div>

<div id="popSource_<?php echo $TPL_VAR["page_tab"]?>" class="hide">
	<div class="wx200 fr right">
		네비게이션 안내<span class="helpicon2 detailDescriptionLayerBtn" title="네비게이션 안내"></span>
		<div class="detailDescriptionLayer hide">네비게이션(가로형/세로형) 생성</div>
	</div>
	<table class="info-table-style cboth" width="100%" cellspacing="0" cellpadding="0">
		<colgroup>
			<col width="30%"/>
			<col width="30%"/>
			<col width="*"/>
		</colgroup>
		<tbody>
		<tr>
			<th class="its-th">타입</th>
			<th class="its-th">영역</th>
			<th class="its-th">소스복사</th>
		</tr>
		<tr>
			<td class="its-td"><?php echo $TPL_VAR["page_name"]?></td>
			<td class="its-td"><?php echo $TPL_VAR["tab_name"]?></td>
			<td class="its-td">
				<a href="javascript:;" onclick="copy_navigation('<?php echo $TPL_VAR["page_tab"]?>');">소스복사</a>
			</td>
		</tr>
		</tbody>
	</table>
</div>
<?php }elseif($TPL_VAR["page_tab"]=='image'){?>
<div id="popSource_<?php echo $TPL_VAR["page_tab"]?>" class="hide">
	<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
	<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
	<script type="text/javascript">
		// 파일 ajax 업로드
		var opt			= {};
		var callback	= function(res){
			var that	= this;
			var result	= eval(res);
			if(result.status){
				var $img_wrap = $('#image-preview-wrap').clone();
				$img_wrap.removeClass('hide');
				$img_wrap.addClass('image-preview-wrap');
				$img_wrap.append('<input class="preview-data" type="hidden" name="image_path" value="' + result.filePath + result.fileInfo.file_name + '"/>');
				$img_wrap.find('.preview-img img').attr('src', result.filePath + result.fileInfo.file_name);
				$img_wrap.find('.preview-path span').text(result.filePath + result.fileInfo.file_name);
				$img_wrap.find('.preview-del').click(function(){ $(this).closest('.image-preview-wrap').remove(); $(that).val(''); });

				$('#preview_image_best').html($img_wrap);
			}else{ // 업로드 실패
				alert('[' + result.desc + '] ' + result.msg);
				return false;
			}
		};
		$('.ajaxImageFormInput_best').createAjaxFileUpload(opt, callback);
	</script>
	<div class="ajaxImageForm mt20">
		<input type="file" name="tmp_image_best" value="" class="ajaxImageFormInput_best" />
		<div id="image-preview-wrap" class="hide wx400">
			<a href="#" class="preview-del"></a>
			<div class="preview-path"><span></span></div>
			<div class="preview-img"><img src=""/></div>
		</div>
	</div>
	<div id="preview_image_best" style="min-height:60px;"></div>
	<div class="center">
		<span class="btn medium"><button type="button" onclick="set_bestbrand_img();" >저장</button></span>
	</div>
</div>
<?php }?>

<div id="suckPopup" class="successPopup hide">
	<div class="box"><i class="far fa-check-circle"></i><div style="height: 5px"></div><span>저장 완료</span></div>
</div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>