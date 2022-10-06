<?php /* Template_ 2.2.6 2022/05/17 12:31:47 /www/music_brother_firstmall_kr/admin/skin/default/goods/batch_modify.html 000009150 */ 
$TPL__GET_1=empty($_GET)||!is_array($_GET)?0:count($_GET);
$TPL_batchmodify_selector_1=empty($TPL_VAR["batchmodify_selector"])||!is_array($TPL_VAR["batchmodify_selector"])?0:count($TPL_VAR["batchmodify_selector"]);
$TPL_info_loop_1=empty($TPL_VAR["info_loop"])||!is_array($TPL_VAR["info_loop"])?0:count($TPL_VAR["info_loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript">
	// 변경이 불가능한 Object(필요시 Property 생성)
	var freezeObj			= {};
	freezeObj.queryString	= "<?php echo str_replace('&amp;','&',$TPL_VAR["page"]["querystring"])?>";
	Object.freeze(freezeObj);

	var mode				= "<?php echo $_GET["mode"]?>";
	var get_search_field	= new Array();

	<?php  $TPL_VAR["search_field_index"] = 0; ?>
<?php if($TPL__GET_1){foreach($_GET as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_V1!=''){?>
<?php if(is_array($TPL_V1)){?>
	get_search_field[<?php echo $TPL_VAR["search_field_index"]?>] = ["<?php echo $TPL_K1?>","<?php echo implode(",",$TPL_V1)?>"];
<?php }else{?>
	get_search_field[<?php echo $TPL_VAR["search_field_index"]?>] = ["<?php echo $TPL_K1?>","<?php echo $TPL_V1?>"];
<?php }?>
		<?php  $TPL_VAR["search_field_index"]++; ?>
<?php }?>
<?php }}?>
</script>
<script type="text/javascript" src="/app/javascript/js/admin-batchModify.js?dummy=<?php echo date('YmdHis')?>"></script>
<style>
	select.line{ padding:3px; }
	table.list-table-style tr th { background-color:#e3e3e3; text-align:center; }
	.mtab-left {background:url('/admin/skin/default/images/common/tab_mem_bg_left.gif');width:4px;height:55px;}
	.mtab-right {background:url('/admin/skin/default/images/common/tab_mem_bg_right.gif');width:4px;height:55px;}
	.mtab {background:url('/admin/skin/default/images/common/tab_mem_bg_center.gif');font-size:12px;font-family:Dotum;font-weight:bold;color:#757575;padding-top:5px;}
	.mtabon-left {background:url('/admin/skin/default/images/common/tab_mem_bg_left_on.gif');width:5px;height:55px;}
	.mtabon-right {background:url('/admin/skin/default/images/common/tab_mem_bg_right_on.gif');width:5px;height:55px;}
	.mtabon {background:url('/admin/skin/default/images/common/tab_mem_bg_center_on.gif');font-size:12px;font-family:Dotum;font-weight:bold;color:#000000;padding-top:5px;}
	.pdr28 {padding-right:28px;}
	.option_info, .default_option {background-color: #f9f9f9 !important;}
	.option_info_td {background-color: #f9f9f9 !important;border-bottom:1px solid #d3d3d6 !important;border-top:none !important;}
	.border-bottom-none {border-bottom:none !important;}
	.bg-dot-line {background: url("/admin/skin/default/images/common/icon/dot_line.png") repeat-x;}
	.optionLay {background-color:#F0F0F0}
	.white {background-color:#FFFFFF}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>상품 데이터 일괄 업데이트</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<!--
                <li><span class="btn large icon"><button><span class="arrowleft"></span>상품리스트</button></span></li>
                -->
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<!--<li><span class="btn large"><button type="button" name="update_goods<?php if($_GET["mode"]=='imagehosting'){?>_imagehosting<?php }?>">업데이트하기</button></span></li>-->

<?php if($_GET["mode"]=='membersale'){?>
			<!-- goods_search_form_membersale.html 파일에 이벤트 정의됨 -->
			<li><span class="btn large"><button type="button" id="update_excel">엑셀 업로드</button></span></li>
<?php }else{?>
			<li><span class="btn large"><button type="button" <?php if($TPL_VAR["check_function"]){?>check_function="<?php echo $TPL_VAR["check_function"]?>"<?php }?> name="update_goods">업데이트하기</button></span></li>
<?php }?>
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<form name="goodsForm" id="goodsForm" enctype="multipart/form-data">
	<input type="hidden" name="query_string"/>
	<input type="hidden" name="no" />
	<input type="hidden" name="mode" value="<?php echo $_GET["mode"]?>" />
	<input type="hidden" name="perpage" value="<?php echo $_GET["perpage"]?>">
	<input type="hidden" name="goods_type" value="goods">

	<!-- 상품 검색폼 : 시작 -->
<?php $this->print_("goods_search_form",$TPL_SCP,1);?>

	<!-- 상품 검색폼 : 끝 -->
</form>

<div class="clearbox"></div>
<!-- 상단 단계 링크 : 시작 -->
<style>
	.topmenuTitleContainer {margin-top:15px; border:1px solid #000; padding-left:10px; line-height:40px;}
	.topmenuTitleContainer .ptc-title {float:left; font-size:14px; color:#fff; font-weight:bold;}
	.topmenuTitleContainer .ptc-desc {padding-left:10px; float:left;}
	.batchmodify_ui-combobox {width:650px;height:40px;margin: 0;padding: 0.3em;font-size:14px;}
	.batchmodify_ui-combobox option:nth-child(even) {color:#3366ff;}
</style>
<form name="goodsBatchUpdateForm" id="goodsBatchUpdateForm" enctype="multipart/form-data">
	<div class="center">
		<div class="topmenuTitleContainer clearbox" style="background-color:gray">
			<div class="ptc-title">상품데이터 선택 : </div>
			<div class="ptc-desc">
				<select name="batchmodify_selector" style="vertical-align:middle;" class="batchmodify_ui-combobox">
<?php if($TPL_batchmodify_selector_1){foreach($TPL_VAR["batchmodify_selector"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>" <?php if($TPL_VAR["mode"]==$TPL_K1){?> selected <?php }?> ><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
				<script>
					$( "select[name='batchmodify_selector']" )
							.change(function(){
								if($(this).val()){
									go_link_tab($(this).val());
								}
							});
				</script>
			</div>
		</div>
	</div>
	<!-- 상단 단계 링크 : 끝 -->

<?php $this->print_("list_contents",$TPL_SCP,1);?>

</form>

<?php if($_GET["mode"]!='membersale'){?>
<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

<!-- 기본검색설정 : 시작 -->
<div class="hide" id="search_detail_dialog"><?php $this->print_("set_search_default",$TPL_SCP,1);?></div>
<!-- 기본검색설정 : 끝 -->

<!--### 역마진 방지 승인팝업-->
<div id="goods_permit_lay" class="hide"></div>



<!-- 공용정보설정 팝업 -->
<?php if($TPL_VAR["mode"]=="commoninfo"){?>
<div id="view_editor_div" class="hide">
	<form name="tmpContentsFrm" id="tmpContentsFrm" method="post" enctype="multipart/form-data" action="../goods_process/goods_info_update" target="actionFrame">
		<input type="hidden" name="contents_type" value="" />
		<input type="hidden" name="mode" value="info_only_update">
		<div class="contents_view hide" id="commonContents_view"></div>
		<div>
			<div id="view_common_info">
				<input type="text" name="info_name" title="공용정보명을 입력하세요" size="20">
				<select name="info_select" class="line">
					<option value="">← 좌측에 공용정보명을 입력하여 새로운 공용정보를 만드시거나 또는 ↓아래에서 이미 만들어진 공용정보를 불러오세요</option>
<?php if($TPL_info_loop_1){foreach($TPL_VAR["info_loop"] as $TPL_V1){?>
<?php if($TPL_V1["info_name"]!='== 선택하세요 =='&&$TPL_V1["info_name"]!='== ←좌측에 공용정보명을 입력하여 새로운 공용정보를 만드시거나 또는 ↓아래에서 이미 만들어진 공용정보를 불러오세요 =='){?>
					<option value="<?php echo $TPL_V1["info_seq"]?>"><?php echo $TPL_V1["info_name"]?> &nbsp;[고유번호 : <?php echo $TPL_V1["info_seq"]?>] 고유번호는 엑셀로 상품등록/수정할 때 공용정보 셀에 입력하는 번호입니다.</option>
<?php }?>
<?php }}?>
				</select>
				<span class="btn small gray"><input type="button" onclick="goods_info_del();" value="삭제"></span>
			</div>
			<div class="view_contents_area"></div>
			<div class="contents_saveBtn center pdt10"><span class="btn large cyanblue"><button type="button" onclick="view_editor_save()" style="width:100px;">저장</button></span></div>
		</div>
	</form>
</div>
<?php }?>


<?php }else{?>
<!-- 회원등급할인세트 엑셀 업로드 팝업 -->
<div class="center hide" id="membersale_excel_uplaod_dialog">
	<form id="membersaleFrm" name="membersaleFrm" method="post" action="/cli/excel_up/create_membersale" enctype="multipart/form-data" target="actionFrame">
		<div class="pdb5 pdt10"><input type="file" id="membersale_excel_file" name="membersale_excel_file" /></div>
		<div class="pdb10 pdt10"><span class="desc red">* xlsx 파일만 업로드 가능합니다.</span></div>
		<span class="btn large"><button type="button" id="btn_excel_process">업데이트하기</button></span>
	</form>
</div>
<?php }?>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>