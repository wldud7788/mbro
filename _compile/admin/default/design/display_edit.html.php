<?php /* Template_ 2.2.6 2022/05/17 12:31:34 /www/music_brother_firstmall_kr/admin/skin/default/design/display_edit.html 000011987 */ 
$TPL_currency_symbol_list_1=empty($TPL_VAR["currency_symbol_list"])||!is_array($TPL_VAR["currency_symbol_list"])?0:count($TPL_VAR["currency_symbol_list"]);
$TPL_target_codes_1=empty($TPL_VAR["target_codes"])||!is_array($TPL_VAR["target_codes"])?0:count($TPL_VAR["target_codes"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<script type="text/javascript">
	var info_item_config = {
		'brand_title'	: ['kind','font_decoration','wrapper'],
		'goods_name'	: ['kind','font_decoration'],
		'summary'		: ['kind','font_decoration'],
		'consumer_price': ['kind','font_decoration','position','postfix','compare'/*,'zoomicon'*/],
		'price'			: ['kind','font_decoration','position','postfix','compare'/*,'zoomicon'*/],
		'sale_price'	: ['kind','font_decoration','position','postfix','compare'/*,'zoomicon'*/],
		'count'			: ['kind','buy_count','time_count'],
<?php if($TPL_VAR["eventpage"]){?>
		'event_text'	: ['kind','font_decoration'/*,'zoomicon'*/],
<?php }?>
<?php if($TPL_VAR["arrSns"]["fb_like_box_type"]!='NO'){?>
		'fblike'		: ['kind','fblike'],
<?php }?>
		'icon'			: ['kind','list_icon_desc','list_icon_cpn','list_icon_freedlv','list_icon_video'],
		'status_icon'	: ['kind','status_icon_desc','status_icon_runout','status_icon_purchasing','status_icon_unsold'],
		'score'			: ['kind','score_desc'],
		'provider_name'	: ['kind','font_decoration'],
		'color'			: ['kind','color_desc'],
		'bigdata'		: ['kind','font_decoration','bigdata'],
		'shipping'		: ['kind','shipping_desc','shipping_free','shipping_fixed','shipping_iffree','shipping_ifpay','shipping_overseas'],
		'pageview'		: ['kind','pageview_desc']
	};

	var basic_currency = "<?php echo $TPL_VAR["basic_currency"]?>";
	var currency_list = {
<?php if($TPL_currency_symbol_list_1){foreach($TPL_VAR["currency_symbol_list"] as $TPL_K1=>$TPL_V1){?>'<?php echo $TPL_K1?>' : [<?php if(is_array($TPL_R2=$TPL_V1[ 0]['value'])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>"<?php echo $TPL_V2?>",<?php }}?>],
<?php }}?>
	};

	var displayTabGoodsContainerClone;
	var m_displayTabGoodsContainerClone;
	var gl_count_w_lattice_a		= num("<?php echo $TPL_VAR["styles"]['lattice_a']['count_w']?>");
	var gl_popup					= '<?php echo $TPL_VAR["popup"]?>';
	var gl_template_path			= '<?php echo $TPL_VAR["template_path"]?>';
	var gl_tpl_desc					= '<?php echo $TPL_VAR["layout_config"]["tpl_desc"]?>';
	var gl_tpl_path					= '<?php echo $TPL_VAR["layout_config"]["tpl_path"]?>';
	var gl_recommend_flag			= '<?php echo $TPL_VAR["recommend_flag"]?>';
	var gl_display_seq				= '<?php echo $TPL_VAR["display_seq"]?>';
	var gl_m_display_seq			= '<?php echo $TPL_VAR["m_display_seq"]?>';
	var gl_platform					= '<?php echo $TPL_VAR["platform"]?>';
	var gl_kind						= '<?php if($TPL_VAR["data"]["kind"]){?><?php echo $TPL_VAR["data"]["kind"]?><?php }else{?><?php echo $TPL_VAR["displaykind"]?><?php }?>';
	var gl_sub_kind					= '<?php echo $TPL_VAR["sub_kind"]?>';
	var gl_navigation_paging_style	= '<?php echo $TPL_VAR["data"]["navigation_paging_style"]?>';
	var gl_operation_type			= '<?php echo $TPL_VAR["config_system"]["operation_type"]?>';
</script>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/mobile_pagination.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/admin_goods_display.css" />
<link rel="stylesheet" type="text/css" href="/data/design/goods_info_style.css" />
<link rel="stylesheet" type="text/css" href="/data/design/goods_info_user.css" />
<script type="text/javascript" src="/app/javascript/plugin/jquery.bxslider.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-font-decoration.js?v=<?php echo date('YmdH')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-compare-currency.js?v=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/base64.js"></script>
<script type="text/javascript" src="/app/javascript/js/goods-display.js?v=<?php echo date('YmdH')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/js/goods-display-edit.js?v=<?php echo date('YmdH')?>"></script>
<form name="displayManagerForm" action="../design_process/display_edit" method="post" target="actionFrame" enctype="multipart/form-data">
<input type="hidden" name="template_path" value="<?php echo $TPL_VAR["template_path"]?>" />
<input type="hidden" name="display_seq" value="<?php echo $TPL_VAR["display_seq"]?>" />
<input type="hidden" name="m_display_seq" value="<?php echo $TPL_VAR["m_display_seq"]?>" />
<input type="hidden" name="kind" value="<?php echo $TPL_VAR["kind"]?>" />
<input type="hidden" name="sub_kind" value="<?php echo $TPL_VAR["sub_kind"]?>" />
<input type="hidden" name="category_flag" value="<?php echo $TPL_VAR["category_flag"]?>" />  
<input type="hidden" name="recommend_flag" value="<?php echo $TPL_VAR["recommend_flag"]?>" />
<input type="hidden" name="direct" value="<?php echo $TPL_VAR["direct"]?>" />
<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>" />
<input type="hidden" name="platform" value="<?php echo $TPL_VAR["platform"]?>" />
<input type="hidden" name="displaykind" value="<?php if($TPL_VAR["data"]["kind"]=='designvideo'){?><?php echo $TPL_VAR["data"]["kind"]?><?php }else{?><?php echo $TPL_VAR["displaykind"]?><?php }?>" />
<input type="hidden" name="popup" value="<?php echo $TPL_VAR["popup"]?>" />
<input type="hidden" name="category_code" value="<?php echo $TPL_VAR["category_code"]?>" />
<?php if($TPL_VAR["target_codes"]){?>
<?php if($TPL_target_codes_1){foreach($TPL_VAR["target_codes"] as $TPL_V1){?>
<input type="hidden" name="target_codes[]" value="<?php echo $TPL_V1?>" />
<?php }}?>
<?php }?>

<div style="padding:15px;">
<?php if($TPL_VAR["mobile_skin_chk"]=='y'){?>
	<div class="mobile_skin_chk">
		모바일에선 모바일 전용 디스플레이 사용을 권장 합니다.
	</div>
<?php }?>
	<div class="pc_tab_div imageCheckboxContainer display_set_wrap">
		<input type="hidden" class="displayImageIconPopupLimit"/>
		<table class="design-simple-table-style" width="100%" align="center">
			<col width="130" />
			<tr>
				<th class="dsts-th">
					번호
				</th>
				<td class="dsts-td left" colspan="2">
<?php if($_SERVER["REMOTE_ADDR"]=="106.246.242.226"){?>
					<input type="text" name="display_seq_update" value="<?php echo $TPL_VAR["display_seq"]?>"/>
<?php }else{?>
<?php if($TPL_VAR["display_seq"]&&($TPL_VAR["data"]["kind"]=='design'||$TPL_VAR["data"]["kind"]=='designvideo')){?>
					<?php echo $TPL_VAR["display_seq"]?>

<?php }else{?>
					자동 생성
<?php }?>
<?php }?>
				</td>
			</tr>

<?php if(!$_GET["popup"]){?>
			<tr>
				<th class="dsts-th">관리용 타이틀</th>
				<td class="dsts-td left" colspan="2">
					<input type="text" name="admin_comment" value="<?php echo $TPL_VAR["data"]["admin_comment"]?>" class="line" size="100" maxlength="200" />
				</td>
			</tr>
<?php }?>

<?php if(!$_GET["kind"]||$TPL_VAR["data"]["kind"]=='design'||$TPL_VAR["data"]["kind"]=='designvideo'){?>
			<tr>
				<th class="dsts-th">타이틀</th>
				<td class="dsts-td left" colspan="2">
					<input type="text" name="title" value="<?php echo $TPL_VAR["data"]["title"]?>" title="타이틀을 입력하세요. 예) 베스트상품, 신상품, New arrival, Best Items" class="line" size="100" maxlength="200" />
					<div class="pdt5"><span class="desc">상품디스플레이의 타이틀을 텍스트가 아닌 이미지로 꾸미고 싶으시다면, EYE-DESIGN에서 [이미지넣기] 기능을 활용해 주세요.</span></div>
				</td>
			</tr>
<?php }?>

			<!--s:스타일-->
<?php $this->print_("display_edit_style",$TPL_SCP,1);?>

			<!--e:스타일-->

			<!--s:꾸미기-->
<?php $this->print_("display_edit_decoration",$TPL_SCP,1);?>

			<!--e:꾸미기-->

			<!--s:상품정보-->
<?php $this->print_("display_edit_goods_info",$TPL_SCP,1);?>

			<!--e:상품정보-->

			<!--s: 탭 추가-->
<?php if($TPL_VAR["display_tab_flag"]){?>
<?php $this->print_("display_edit_tab",$TPL_SCP,1);?>

<?php }?>
			<!--e: 탭 추가-->

			<!--s: 상품 조건지정-->
<?php if($TPL_VAR["display_condition_flag"]){?>
<?php $this->print_("display_edit_condition",$TPL_SCP,1);?>

<?php }?>
			<!--e: 상품 조건지정-->

			<!--s:상품노출, 인기순 정렬-->
<?php if($TPL_VAR["display_select_flag"]){?>
<?php $this->print_("display_edit_select",$TPL_SCP,1);?>

<?php }?>
			<!--e:상품노출, 인기순 정렬-->

<?php if($TPL_VAR["platform"]=='mobile'&&$TPL_VAR["data"]["kind"]!='relation'){?>
			<tr class="navigation_paging_area">
				<th class="dsts-th">
					네비게이션 <span class="btn small cyanblue"><button type="button" onclick="$('#navigation_paging_dialog').dialog('open')">선택</button></span>
				</th>
				<td class="dsts-td left" colspan="2">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="50%">
								<span class="navigation_paging_prn"></span>
							</td>
							<td>
								노출 상품이 <span class="count_total_swipe"></span>개를 초과하면 자동으로 네비게이션이 보여집니다.
							</td>
						</tr>
					</table>
				</td>
			</tr>
<?php }?>
		</table>
	</div>
	
	<!--s:모바일 페이지-->
<?php if($TPL_VAR["mobile_display_flag"]){?>
<?php $this->print_("display_edit_mobile",$TPL_SCP,1);?>

<?php }?>
	<!--e:모바일 페이지-->

<?php if($TPL_VAR["template_path"]&&$TPL_VAR["display_seq"]&&($TPL_VAR["data"]["kind"]=='design'||$TPL_VAR["data"]["kind"]=='designvideo')){?>
	<div class="center mt15">
		<label><input type="checkbox" name="removeDesignDisplayArea" value="Y" /> 이 페이지의 상품디스플레이 영역을 없앰 (설정 정보는 삭제되지 않음)</label>
	</div>
<?php }?>

	<div class="center pd20">
<?php if($TPL_VAR["sub_kind"]){?>
		<div class="center pdt30">
			위의 세팅값을 1차부터 4차까지 전체 <?php if($TPL_VAR["kind"]=='category'||$TPL_VAR["kind"]=='category_recommend'){?>카테고리<?php }elseif($TPL_VAR["kind"]=='brand'||$TPL_VAR["kind"]=='brand_recommend'){?>브랜드<?php }elseif($TPL_VAR["kind"]=='location'||$TPL_VAR["kind"]=='location_recommend'){?>지역<?php }?>에 적용합니다.
		</div>
		<div class="center pdt10"><span class="btn large red"><input type="submit" value="실행하기" /></span></div>
<?php }else{?>
		<span class="btn large cyanblue"><input type="submit" value="적용" /></span>
<?php if($TPL_VAR["template_path"]){?>
<?php if($TPL_VAR["data"]["kind"]){?>
			<span class="btn large"><input type="button" value="목록" onclick="parent.DM_window_display_insert('<?php echo $TPL_VAR["template_path"]?>','<?php echo $TPL_VAR["data"]["kind"]?>')"/></span>
<?php }else{?>
			<span class="btn large"><input type="button" value="목록" onclick="parent.DM_window_display_insert('<?php echo $TPL_VAR["template_path"]?>','<?php echo $_GET["displaykind"]?>')"/></span>
<?php }?>
<?php }?>
<?php }?>
	</div>
	<div style="height:30px;"></div>
</div>
</form>
<!-- 2022.02.03 라이브쇼핑 관련 1406 패치 by 김혜진 -->
<div id="condition_change_option">
</div>

<!--s:팝업 페이지-->
<?php $this->print_("display_footer_popup",$TPL_SCP,1);?>

<!--e:팝업 페이지-->

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>