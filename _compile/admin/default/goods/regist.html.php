<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/goods/regist.html 000131448 */ 
$TPL_tabmenu_1=empty($TPL_VAR["tabmenu"])||!is_array($TPL_VAR["tabmenu"])?0:count($TPL_VAR["tabmenu"]);
$TPL_options_1=empty($TPL_VAR["options"])||!is_array($TPL_VAR["options"])?0:count($TPL_VAR["options"]);
$TPL_provider_list_1=empty($TPL_VAR["provider_list"])||!is_array($TPL_VAR["provider_list"])?0:count($TPL_VAR["provider_list"]);
$TPL_goodsColorPick_1=empty($TPL_VAR["goodsColorPick"])||!is_array($TPL_VAR["goodsColorPick"])?0:count($TPL_VAR["goodsColorPick"]);
$TPL_additions_1=empty($TPL_VAR["additions"])||!is_array($TPL_VAR["additions"])?0:count($TPL_VAR["additions"]);
$TPL_goodsaddinfoloop_1=empty($TPL_VAR["goodsaddinfoloop"])||!is_array($TPL_VAR["goodsaddinfoloop"])?0:count($TPL_VAR["goodsaddinfoloop"]);
$TPL_linkageOrigin_1=empty($TPL_VAR["linkageOrigin"])||!is_array($TPL_VAR["linkageOrigin"])?0:count($TPL_VAR["linkageOrigin"]);
$TPL_goods_subinfo_group_1=empty($TPL_VAR["goods_subinfo_group"])||!is_array($TPL_VAR["goods_subinfo_group"])?0:count($TPL_VAR["goods_subinfo_group"]);
$TPL_inputs_1=empty($TPL_VAR["inputs"])||!is_array($TPL_VAR["inputs"])?0:count($TPL_VAR["inputs"]);
$TPL_images_1=empty($TPL_VAR["images"])||!is_array($TPL_VAR["images"])?0:count($TPL_VAR["images"]);
$TPL_goodsStringPrice_1=empty($TPL_VAR["goodsStringPrice"])||!is_array($TPL_VAR["goodsStringPrice"])?0:count($TPL_VAR["goodsStringPrice"]);
$TPL_icons_1=empty($TPL_VAR["icons"])||!is_array($TPL_VAR["icons"])?0:count($TPL_VAR["icons"]);
$TPL_r_hscode_1=empty($TPL_VAR["r_hscode"])||!is_array($TPL_VAR["r_hscode"])?0:count($TPL_VAR["r_hscode"]);
$TPL_relation_1=empty($TPL_VAR["relation"])||!is_array($TPL_VAR["relation"])?0:count($TPL_VAR["relation"]);
$TPL_relation_seller_1=empty($TPL_VAR["relation_seller"])||!is_array($TPL_VAR["relation_seller"])?0:count($TPL_VAR["relation_seller"]);
$TPL_goodsvideofiles_1=empty($TPL_VAR["goodsvideofiles"])||!is_array($TPL_VAR["goodsvideofiles"])?0:count($TPL_VAR["goodsvideofiles"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<!--link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layer_stock.css" /-->
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/goods_admin.css?dummy=<?php echo date('Ymd')?>" />
<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=<?php echo date('Ym')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('YmdH')?>"></script>
<script type="text/javascript" src="/app/javascript/js/goods-display.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-shipping.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-videoDialog.js?dummy=<?php echo uniqid()?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-goodsReady.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gCategorySelectList.js?mm=<?php echo date('Ym')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gGoodsSelectList.js?mm=<?php echo date('Ym')?>"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js?mm=<?php echo date('Ym')?>"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js?mm=<?php echo date('Ym')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquploadify/swfobject.js?mm=<?php echo date('Ym')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquploadify/jquery.uploadify.v2.1.4.js?mm=<?php echo date('Ym')?>"></script>
<script type="text/javascript" src="/app/javascript/js/browsercheck.js?mm=<?php echo date('Ym')?>"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.tablednd.js"></script>
<script type="text/javascript">
	var gl_service_code					= '<?php echo $TPL_VAR["service_code"]?>';
	var gl_ableStockLimit				= <?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]+ 1?>;
	var gl_runout						= '<?php echo $TPL_VAR["cfg_order"]["runout"]?>';
	var gl_ableStockLimit_org			= <?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]?>;
	var gl_default_reserve_percent		= '<?php echo $TPL_VAR["default_reserve_percent"]?>';
	var gl_package_yn					= '<?php echo $TPL_VAR["package_yn"]?>';
	var gl_provider_seq					= '<?php echo $TPL_VAR["provider_seq"]?>';
	var gl_provider_name				= '<?php echo addcslashes($TPL_VAR["provider"]["provider_name"])?>';
	var gl_adminSessionType				= '<?php echo $TPL_VAR["adminSessionType"]?>';
	var gl_default_charge				= false;
	var gl_scm_use						= '<?php echo $TPL_VAR["scm_cfg"]["use"]?>';
	var gl_reservetitle					= '<?php echo $TPL_VAR["reservetitle"]?>';
	var gl_pointtitle					= '<?php echo $TPL_VAR["pointtitle"]?>';
	var gl_market						= '<?php echo $TPL_VAR["market"]?>';
	var goodsObj						= <?php echo $TPL_VAR["goodsObj"]?>;
	var gl_operation_type				= '<?php echo $TPL_VAR["config_system"]["operation_type"]?>';
	var bxOpenSetObj		 			= <?php echo $TPL_VAR["bxOpenSetObj"]?>;
	var gl_common_info_cfg				= '<?php echo $TPL_VAR["config_goods"]["common_info_seq"]?>';
	var gl_common_info_goods			= '<?php echo $TPL_VAR["goods"]["info_seq"]?>';

	//????????????(????????????)
	Object.freeze(goodsObj);
	Object.freeze(bxOpenSetObj);

	var  gl_goods_seq					= goodsObj.goods_seq == null ? '' : goodsObj.goods_seq;
	var  gl_tax							= goodsObj.tax;
	var  gl_reserve_policy				= goodsObj.reserve_policy;
	var  gl_runtout_policy				= goodsObj.runout_policy;
	var  gl_able_stock_limit			= goodsObj.able_stock_limit;
	var  socialcpuse_flag				= <?php if($TPL_VAR["socialcpuse"]){?>true<?php }else{?>false<?php }?>;
	var  gl_option_exist_val			= <?php if($TPL_VAR["opts_loop"]){?>true<?php }else{?>false<?php }?>;

	var  gl_image_width				=	'<?php echo $TPL_VAR["goodsImageSize"]["view"]["width"]?>';
	var  gl_image_height			=	'<?php echo $TPL_VAR["goodsImageSize"]["view"]["height"]?>';

	var  gl_first_goods_date			= '<?php echo $TPL_VAR["config_system"]["first_goods_date"]?>';
<?php if(is_array($TPL_R1=code_load('currency',$TPL_VAR["config_system"]["basic_currency"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	var  gl_basic_currency_hangul		= '<?php echo $TPL_V1["value"]["hangul"]?>';
	var  gl_basic_currency_nation		= '<?php echo $TPL_V1["value"]["nation"]?>';
<?php }}?>

	var gl_basic_currency				= "<?php echo $TPL_VAR["config_system"]["basic_currency"]?>";	//????????????
	var gl_krw_exchange_rate			= "<?php echo $TPL_VAR["krw_exchange_rate"]?>";				//??????????????? ?????? ??????(KRW)??????
	var gl_amout_list						= new Array();
<?php if(is_array($TPL_R1=$TPL_VAR["config_system"]["basic_amout"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
	gl_amout_list['<?php echo $TPL_K1?>'] = '<?php echo $TPL_V1?>';
<?php }}?>

	// ?????? ?????? ?????? DB ??? ??????
	var gl_suboption_layout_group		= goodsObj.suboption_layout_group;
	var gl_suboption_layout_position	= goodsObj.suboption_layout_position;
	var gl_inputoption_layout_group		= goodsObj.inputoption_layout_group;
	var gl_inputoption_layout_position	= goodsObj.inputoption_layout_position;

	function getNoServiceAlert(){
		<?php echo serviceLimit('A1')?>

	}
</script>


<?php if($TPL_VAR["goods"]["goods_seq"]){?>
<!-- form start -->
<form name="goodsRegist" id="goodsRegist" method="post" enctype="multipart/form-data" action="../goods_process/modify" target="actionFrame">
	<input type="hidden" name="goodsSeq" 				value="<?php echo $TPL_VAR["goods"]["goods_seq"]?>" />
	<input type="hidden" name="query_string" 			value="<?php echo $TPL_VAR["query_string"]?>"/>
	<input type="hidden" name="default_charge" 			value="<?php echo $TPL_VAR["provider"]["charge"]?>" />
	<input type="hidden" name="default_commission_type" value="<?php echo $TPL_VAR["provider"]["commission_type"]?>" />
	<input type="hidden" name="old_update_date" 		value="<?php echo $TPL_VAR["goods"]["update_date"]?>" />
	<input type="hidden" name="regist_date" 			value="<?php echo $TPL_VAR["goods"]["regist_date"]?>" />
	<input type="hidden" name="goods_modify_ok" 		value="" id="goods_modify_ok"/>
	<!-- ????????? ???????????? ????????? -->
	<div id="packageOptInput" class="hide"></div>
	<div id="packageSubInput" class="hide"></div>
<?php }else{?>
<form name="goodsRegist" id="goodsRegist" method="post" enctype="multipart/form-data" action="../goods_process/regist" target="actionFrame">
	<input type="hidden" name="default_charge" 			value="0" />
	<input type="hidden" name="default_commission_type" value="SACO" />
<?php }?>
	<input type="hidden" name="frequentlyinp" 			value="<?php echo $TPL_VAR["goods"]["frequentlyinp"]?>" />
	<input type="hidden" name="save_type" 				value="view" />
	<input type="hidden" name="goodsinfochage"  		value="" id="goodsinfochage" />
	<input type="hidden" name="runout_policy" 			value="" />
	<input type="hidden" name="able_stock_limit" 		value=""/>
	<input type="hidden" name="possible_pay_type_hidden" value="<?php echo $TPL_VAR["goods"]["possible_pay_type"]?>" />
	<input type="hidden" name="possible_pay_hidden" 	value="<?php echo $TPL_VAR["goods"]["possible_pay"]?>"/>
	<input type="hidden" name="possible_mobile_pay_hidden" value="<?php echo $TPL_VAR["goods"]["possible_mobile_pay"]?>"/>
	<input type="hidden" name="videotmpcode" 			value="<?php echo $TPL_VAR["videotmpcode"]?>" />
	<input type="hidden" name="socialcp_event"  		value="<?php echo $TPL_VAR["goods"]["socialcp_event"]?>" id="socialcp_event" />
	<input type="hidden" name="package_yn" 				value="<?php echo $TPL_VAR["package_yn"]?>" />
	<input type="hidden" name="sale_seq" 				value="<?php echo $TPL_VAR["promotion_grade"]["sale_seq"]?>"/>
<?php if(!serviceLimit('H_AD')){?>
<?php }?>
	<input type="hidden" name="provider_seq" class="provider_seq" value="<?php if($TPL_VAR["goods"]["provider_seq"]){?><?php echo $TPL_VAR["goods"]["provider_seq"]?><?php }else{?><?php echo $TPL_VAR["provider_seq"]?><?php }?>" />
	<input type="hidden" name="provider_name" class="provider_name" value="<?php if($TPL_VAR["goods"]["provider_name"]){?><?php echo $TPL_VAR["goods"]["provider_name"]?><?php }else{?><?php echo $TPL_VAR["provider_name"]?><?php }?>" />
<?php if($TPL_VAR["MarketConnectorClause"]!='NOT_YET'&&$TPL_VAR["useMarket"]==true){?>
	<input type="hidden" name="useMarket" value="1" />
<?php }?>
	<textarea name="encodedFormValue" class="hide"></textarea>

<!-- ????????? ????????? ??? : ?????? -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- ????????? -->
		<div class="page-title">
<?php if($TPL_VAR["goods"]["goods_seq"]){?>
			<h2>
				<span class="icon-star-gray pdr5 <?php echo $TPL_VAR["goods"]["favorite_chk"]?>" id="star_select" goods_seq="<?php echo $TPL_VAR["goods"]["goods_seq"]?>"></span>
				<span>		
				<?php echo getstrcut($TPL_VAR["goods"]["title"], 15)?>

				</span>
				<span class="pdl5 fx13 normal">(?????? ?????? : <?php echo $TPL_VAR["goods"]["goods_seq"]?>)</span>
			</h2>
<?php }else{?>
			<h2>
				<span class="icon-goods-kind-<?php echo $TPL_VAR["goods"]["goods_kind"]?>"></span>
<?php if($TPL_VAR["socialcpuse"]){?>??????<?php }?>
<?php if($TPL_VAR["package_yn"]=='y'){?>?????????<?php }?>
<?php if(!$TPL_VAR["socialcpuse"]&&$TPL_VAR["package_yn"]!='y'){?>??????<?php }?>				
				?????? ??????
			</h2>
<?php }?>
		</div>	

		<!-- ?????? ?????? -->
		<ul class="page-buttons-right">
<?php if($TPL_VAR["goods"]["goods_seq"]){?>
			<li class="relative">
				<button type="button" id="viewGoods" goods_seq="<?php echo $TPL_VAR["goods"]["goods_seq"]?>" class="resp_btn v2 size_L">????????????<span class="arrowright"></span></button>
				<ul class="gnb-subnb" style="z-index:1">
					<li class="gnb-subnb-item"><a href="//<?php echo $TPL_VAR["pcDomain"]?>/goods/view?no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&setMode=pc" style="width:100px" target="_blank">PC ??????</a></li>
					<li class="gnb-subnb-item"><a href="//<?php echo $TPL_VAR["mobileDomain"]?>/goods/view?no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&setMode=mobile" style="width:100px" target="_blank">Mobile/Tablet ??????</a></li>
<?php if(serviceLimit('H_NFR')&&$TPL_VAR["facebookConnected"]){?><li class="gnb-subnb-item"><a href="<?php echo $TPL_VAR["facebookapp_url"]?>" style="width:100px" target="_blank">Facebook PC ??????</a></li><?php }?>
				</ul>
			</li>
<?php }?>
			<li><button type="button" class="resp_btn active size_L" onclick="goods_save('view')">??????</button></li>
		</ul>

		<!-- ?????? ?????? -->
		<div class="page-buttons-left">
			<button type="button" class="resp_btn v3 size_L" onclick="document.location.href='../goods/<?php if($TPL_VAR["package_yn"]=='y'){?>package_<?php }?><?php if($TPL_VAR["socialcpuse"]){?>social_<?php }?>catalog?<?php echo $TPL_VAR["query_string"]?>';">????????? ????????????</button>
<?php if($TPL_VAR["goods"]["goods_seq"]){?>
			<button type="button" id="manager_copy_btn"  class="resp_btn v2 size_L" goods_seq="<?php echo $TPL_VAR["goods"]["goods_seq"]?>">??????</button>
<?php }?>
		</div>

		
		<!-- ?????? ?????? ?????? : ?????? -->
		<div class="page-goods-helper-btn">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
<?php if($TPL_tabmenu_1){$TPL_I1=-1;foreach($TPL_VAR["tabmenu"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
					<td class="ctab">
						<a data-key="<?php echo $TPL_K1?>" href="javascript:moveBookmark('<?php echo $TPL_K1?>', <?php echo $TPL_I1?>);"><?php echo $TPL_V1?> <img src="/admin/skin/default/images/common/btn_quick.gif" align="absmiddle"></a>						
					</td>
<?php }}?>
				</tr>
			</table>
		</div>
	</div>
</div>
<!-- ????????? ????????? ??? : ??? -->

<div class='clearbox'></div>

	<!-- ???????????? ?????? : ??????-->
	<div class="mt60"></div>
<?php if(serviceLimit('H_AD')&&$TPL_VAR["goods"]["provider_seq"]){?>
		<div class="box_style_06 blue bold fx14">
<?php if($TPL_VAR["provider_seq"]=='1'){?>
			<div class="ptc-title blue pdl0">?????? ?????? (<?php echo $TPL_VAR["goods"]["goods_status_text"]?>, <?php echo $TPL_VAR["goods"]["provider_status_text"]?>)</div>
<?php }else{?>
			<div class="ptc-title red">
				<?php echo $TPL_VAR["provider"]["provider_id"]?>??? ????????? ?????? (<?php echo $TPL_VAR["goods"]["goods_status_text"]?>, <?php echo $TPL_VAR["goods"]["provider_status_text"]?>)
<?php if($TPL_options_1){foreach($TPL_VAR["options"] as $TPL_V1){?>
<?php if($TPL_V1["default_option"]=='y'){?>
<?php if($TPL_VAR["provider_charge"][ 0]["commission_type"]=='SACO'||$TPL_VAR["provider_charge"][ 0]["commission_type"]==''){?>????????? ?????? ??????<?php }else{?>????????? ?????? ??????<?php }?>
<?php }?>
<?php }}?>
			</div>
<?php }?>
		</div>
<?php }?>

	<!-- ????????? ?????? ?????? -->
<?php if(serviceLimit('H_AD')){?>
	<div class="bx-lay" data-bxcode="provider">
		<div class="bx-title">
			<div class="item-title">????????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl">
			<tr>
				<th>??????</th>
				<td><?php if($TPL_VAR["goods"]["goods_seq"]){?>
<?php if($TPL_VAR["goods"]["provider_seq"]> 1){?>?????????<?php }else{?>??????<?php }?>
<?php }else{?>
					<div class='resp_radio'>
						<label class="mr20"><input type="radio" name="goods_gubun" value="admin" checked> ????????????</label>
						<label><input type="radio" name="goods_gubun" value="provider"> ????????? ??????</label>
					</div>
<?php }?>
				</td>
			</tr>
			<tr class='tr_provider hide'>
				<th>????????? <?php if(!$TPL_VAR["goods"]["goods_seq"]){?><span class="required_chk"></span><?php }?></th>
				<td>
<?php if($TPL_VAR["goods"]["provider_seq"]){?>
					<?php echo $TPL_VAR["provider"]["provider_name"]?>

<?php }else{?>
					<select name="provider_seq_selector" style="vertical-align:middle;">
						<option value="0">??????</option>
<?php if($TPL_provider_list_1){foreach($TPL_VAR["provider_list"] as $TPL_V1){?>
<?php if($TPL_V1["provider_status"]=='N'){?>
						<option value="<?php echo $TPL_V1["provider_seq"]?>" disabled><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>) [??????]</option>
<?php }else{?>
						<option value="<?php echo $TPL_V1["provider_seq"]?>"><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }?>
<?php }}?>
					</select>
<?php }?>
				</td>
			</tr>
			<tr class='tr_account hide'>
				<th>?????? ??????</th>
				<td>
					<span class="ptc-charges"><?php echo $TPL_VAR["goods"]["provider_name"]?></span>
				</td>
			</tr>
			</table>
<?php if(!$TPL_VAR["goods"]["provider_seq"]){?>
			<ul class='bullet_hyphen resp_message'>
				<li>????????? ?????? ??????, ????????? ?????? ?????? ?????? ??? ????????? ?????? ????????? ????????? ?????????.</li>
			</ul>
<?php }?>
		</div>
	</div>
	<!-- ????????? ?????? ?????? -->
<?php }?>

	<!-- 01-02. ????????????/?????????/?????? ?????? -->
<?php $this->print_("_regist_category_brands_location",$TPL_SCP,1);?> <!-- _regist_category_brands_location.html -->
	<!-- 01-02. ????????????/?????????/?????? ?????? -->

	<!-- 03. ???????????? ?????? -->
	<a name="03" alt="????????????"></a>
	<div class="bx-lay" data-bxcode="info">
		<div class="bx-title">
			<div class="item-title">?????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl">
				<tbody>
					<tr>
						<th>
							????????? <span class="required_chk"></span>
						</th>
						<td>
							<div class="resp_limit_text limitTextEvent">
								<input type="text" name="goodsName" size='100' class="resp_text" maxlength="255" value="<?php echo $TPL_VAR["goods"]["goods_name"]?>" title="HTML ????????????" />
							</div>
						</td>
					</tr>
<?php if($TPL_VAR["MarketConnectorClause"]!='NOT_YET'&&$TPL_VAR["useMarket"]==true&&!$TPL_VAR["socialcpuse"]){?>
					<tr>
						<th>
							???????????? ????????? <span class="required_chk"></span>
						</th>
						<td>
							<div class="divisionGoodsNameLinkage">
								<div class="resp_limit_text limitTextEvent">
									<input type="text" name="goodsNameLinkage" class="resp_text" maxlength="255" size='100' value="<?php echo $TPL_VAR["goods"]["goods_name_linkage"]?>" title="??????????????? ???????????? ??????????????????.">
								</div>
								<button type="button" name="goodsNameCopy" class="goods-name-copy resp_btn">????????? ??????</button>
							</div>
						</td>
					</tr>
<?php }?>
					<tr>
						<th>?????????</th>
						<td>
							<div class="resp_limit_text limitTextEvent">
								<input type="text" name="keyword" class="resp_text" size='100' maxlength="1000" value="<?php echo $TPL_VAR["goods"]["keyword"]?>" title="???????????? ,(??????)??? ???????????????">
							</div>
						</td>
					</tr>
<?php if($TPL_VAR["MarketConnectorClause"]!='NOT_YET'&&$TPL_VAR["useMarket"]==true&&!$TPL_VAR["socialcpuse"]){?>
					<tr>
						<th>
							???????????? ?????????
						</th>
						<td>
							<div class="resp_limit_text limitTextEvent">
								<input type="text" name="keywordLinkage" class="resp_text" maxlength="1000" size='100' value="<?php echo $TPL_VAR["goods"]["keyword_linkage"]?>" title="??????????????? ???????????? ??????????????????. ???????????? ,(??????)??? ???????????????."/>
							</div>
							<button type="button" name="keywordCopy" class="keyword-copy resp_btn">????????? ??????</button>
							<button type="button" class="keyword_preview resp_btn">????????????</button>
						</td>
					</tr>
<?php }?>
					<tr>
						<th>?????? ??????</th>
						<td>
							<div class="resp_limit_text limitTextEvent">
								<input type="text" name="summary" class="resp_text" maxlength="255" size='100' value="<?php echo $TPL_VAR["goods"]["summary"]?>" title="????????? ?????? ????????? ???????????????"/>
							</div>
							<ul class='bullet_hyphen resp_message'>
								<li>
								?????? ?????? ??? ???????????? ?????? ?????? ??? ?????? ?????? ???????????????.
								</li>
							</ul>

						</td>
					</tr>
<?php if(!$TPL_VAR["socialcpuse"]){?>
					<tr>
						<th>????????? ??????</th>
						<td>
							<div class="color-check">
<?php if($TPL_goodsColorPick_1){foreach($TPL_VAR["goodsColorPick"] as $TPL_V1){?>
								<label style="background-color:#<?php echo $TPL_V1["code"]?>" class="<?php if($TPL_V1["select"]){?>active<?php }?> mr5" alt="<?php echo $TPL_V1["name"]?>" title="<?php echo $TPL_V1["name"]?>"><input type="checkbox" name="color_pick[]" value="<?php echo $TPL_V1["code"]?>" <?php if($TPL_V1["select"]){?>checked<?php }?>></label>
<?php }}?>
								<button type="button" id="colorMultiCheck" class="resp_btn">????????????</button>
							</div>
						</td>
					</tr>
<?php }?>
					<tr>
						<th>?????? ??????</th>
						<td>
						<table class="table_basic wx800 v7" id="etcViewTable">
							<colgroup>
								<col width="35%" />
								<col />
								<col width="8%" />
							</colgroup>
							<thead>
								<tr>
									<th>??????</th>
									<th>??????</th>
									<th><button type="button" id="etcAdd" class="btn_plus"></button></th>
								</tr>
							</thead>
							<tbody>
								<tr class="nothing <?php if($TPL_VAR["additions"]){?>hide<?php }?>">
									<td class="center" height="30" colspan="3">????????? ??????????????????.</td>
								</tr>
<?php if($TPL_additions_1){foreach($TPL_VAR["additions"] as $TPL_V1){?>
								<tr>
									<td class="center">
										<input type="hidden" name="additionSeq[]" value="<?php echo $TPL_V1["addition_seq"]?>" />
										<select name="selectEtcTitle[]" class="<?php if($TPL_V1["type"]=='direct'){?>wp40<?php }else{?>wp85<?php }?>">
											<option value="" >-??????????????????-</option>
<?php if(is_array($TPL_R2=$TPL_V1["goodsaddinfo"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?><option value="goodsaddinfo_<?php echo $TPL_V2["codeform_seq"]?>"  style="background-color:orange;" <?php if($TPL_V1["code_seq"]==$TPL_V2["codeform_seq"]&&strstr($TPL_V1["type"],'goodsaddinfo_')){?> selected="selected" <?php }?>><?php echo $TPL_V2["label_title"]?></option><?php }}?>
											<option value="model" <?php if($TPL_V1["type"]=='model'){?>selected<?php }?>>?????????</option>
											<option value="brand" <?php if($TPL_V1["type"]=='brand'){?>selected<?php }?>>?????????</option>
											<option value="manufacture" <?php if($TPL_V1["type"]=='manufacture'){?>selected<?php }?>>?????????</option>
											<option value="orgin" <?php if($TPL_V1["type"]=='orgin'){?>selected<?php }?>>?????????</option>
											<option value="direct" <?php if($TPL_V1["type"]=='direct'){?>selected<?php }?>>????????????</option>
										</select>
										<span <?php if($TPL_V1["type"]!='direct'){?>class='hide'<?php }?>><input type="text" name="etcTitle[]" class="etcTitle resp_text" style="width:107px" value="<?php echo $TPL_V1["title"]?>"/></span>
									</td>
									<td>
										<div class="resp_limit_text limitTextEvent">
											<input type="text" name="etcContents[]" class="resp_text etcContents <?php if($TPL_V1["code_seq"]&&strstr($TPL_V1["type"],'goodsaddinfo_')){?> hide<?php }?>" maxlength="255" value="<?php echo $TPL_V1["contents"]?>" />
										</div>
										<input type="hidden" name="etcContents_title[]" class="etcContents_title " value="<?php echo $TPL_V1["contents_title"]?>"/>
										<span class='goodsaddinfolay'>
<?php if(is_array($TPL_R2=$TPL_V1["goodsaddinfo"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?><span class='goodsaddinfo_<?php echo $TPL_V2["codeform_seq"]?> goodsaddinfosublay <?php if(!($TPL_V1["code_seq"]==$TPL_V2["codeform_seq"]&&strstr($TPL_V1["type"],'goodsaddinfo_'))){?> hide<?php }?>'><?php echo $TPL_V2["label_write"]?></span><?php }}?>
										</span>
<?php if($TPL_VAR["provider_seq"]== 1&&$TPL_VAR["LINKAGE_SERVICE"]&&!$TPL_VAR["socialcpuse"]){?>
										<span class="linkage-origin <?php if($TPL_V1["type"]!='orgin'){?>hide<?php }?>">
											<select name="linkageOrigin[]">
												<option value="">???????????????</option>
<?php if(is_array($TPL_R2=$TPL_V1["linkageOrigin"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?><option value="<?php echo $TPL_V2["origin_code"]?>" <?php if($TPL_V1["linkage_val"]==$TPL_V2["origin_code"]){?>selected<?php }?>><?php echo $TPL_V2["origin_name"]?></option><?php }}?>
											</select>
										</span>
<?php }?>
									</td>
									<td class="center"><button type="button" class="etcDel btn_minus"></button></td>
								</tr>
<?php }}else{?>
								<tr>
									<td class="center">
										<input type="hidden" name="additionSeq[]" value="" />
										<select name="selectEtcTitle[]" class="wp85">
											<option value="" >-??????????????????-</option>
<?php if($TPL_goodsaddinfoloop_1){foreach($TPL_VAR["goodsaddinfoloop"] as $TPL_V1){?><option value="goodsaddinfo_<?php echo $TPL_V1["codeform_seq"]?>"  style="background-color:orange;"><?php echo $TPL_V1["label_title"]?></option><?php }}?>
											<option value="model" >?????????</option>
											<option value="brand" >?????????</option>
											<option value="manufacture" >?????????</option>
											<option value="orgin" >?????????</option>
											<option value="direct" >????????????</option>
										</select>
										<span class='hide'><input type="text" name="etcTitle[]" class="resp_text" style="width:43%"  value=""/></span>
									</td>
									<td>

										<div class="resp_limit_text limitTextEvent">
											<input type="text" name="etcContents[]" class="resp_text etcContents" maxlength="255"/>
										</div>

										<input type="hidden" name="etcContents_title[]" class="etcContents_title " value=""/>
										<span class='goodsaddinfolay hide'>
<?php if($TPL_goodsaddinfoloop_1){foreach($TPL_VAR["goodsaddinfoloop"] as $TPL_V1){?><span class='goodsaddinfo_<?php echo $TPL_V1["codeform_seq"]?> goodsaddinfosublay hide'><?php echo $TPL_V1["label_write"]?></span><?php }}?>
										</span>
<?php if($TPL_VAR["provider_seq"]== 1&&$TPL_VAR["LINKAGE_SERVICE"]&&!$TPL_VAR["socialcpuse"]){?>
										<span class="linkage-origin hide">
											<select name="linkageOrigin[]">
												<option value="">???????????????</option>
<?php if($TPL_linkageOrigin_1){foreach($TPL_VAR["linkageOrigin"] as $TPL_V1){?><option value="<?php echo $TPL_V1["origin_code"]?>"><?php echo $TPL_V1["origin_name"]?></option><?php }}?>
											</select>
										</span>
<?php }?>
									</td>
									<td class="center"><button type="button" class="etcDel btn_minus"></button></td>
								</tr>
<?php }?>
							</tbody>
						</table>
						<ul class='bullet_hyphen resp_message'>
							<li>?????? ?????? ??????????????? 
								<span class="underline blue hand" onclick="window.open('../setting/goods');">?????? ??????</span>?????? ????????? ??? ????????????.</li>
							<li>???????????? ?????? ??????(?????????, ?????????, ????????? ???)??? ????????? ??? ????????????.</li>
						</td>
					</tr>
					<tr>
						<th>????????????????????????</th>
						<td>
							<div style="max-width:1000px">
								<table class="table_basic thl v7">
									<tbody>
										<tr>
											<th>??????</th>
											<td>
												<select name="goodsSubInfo" class="resp_text" onchange="chgGoodSubInfo(this.value);" style="width:300px;"> 
													<option value="" <?php if($TPL_VAR["goods"]["goods_sub_info"]==''){?>selected<?php }?>>????????????</option>
<?php if($TPL_VAR["goods_subinfo_group"]){?>
<?php if($TPL_goods_subinfo_group_1){foreach($TPL_VAR["goods_subinfo_group"] as $TPL_V1){?>
															<option value="<?php echo $TPL_V1["category"]?>" <?php if($TPL_VAR["goods"]["goods_sub_info"]===$TPL_V1["category"]){?>selected<?php }?>>(<?php echo $TPL_V1["category"]?>)<?php echo $TPL_V1["category_desc"]?></option>
<?php }}?>
<?php }?>
												</select>
											</td>
										</tr>
										<tr class="<?php if($TPL_VAR["goods"]["goods_sub_info"]===''){?>hide<?php }?>">
											<th>?????? ??????</th>
											<td>
												<div class="right mt5">
													<button type="button" name="btnGoodsSubInfoDescrioption" id="btnGoodsSubInfoDescrioption" class="resp_btn"> ?????? ?????? '??????????????????'??? ??????</button>
												</div>
												<table class="tablednd table_basic mt5 v7" id="subInfoViewTable">
													<colgroup>
														<col width="10%" />
														<col width="40%" />
														<col width="40%" />
														<col width="10%" />
													</colgroup>
													<thead class="nodrag nodrop">
													<tr>
														<th>??????</th>
														<th>??????</th>
														<th>??????</th>
														<th><button id="goodsSubInfoAdd" type="button" onclick="add_subInfo();" class="btn_plus"></button></th>
													</tr>
													<tr class="nothing <?php if($TPL_VAR["goods"]["sub_info_desc"]["subInfo"]){?>hide<?php }?>">
														<td colspan="4" height="30" class="center">????????? ??????????????????.</td>
													</tr>
													</thead>
													<tbody id="subInfoTable">
<?php if(is_array($TPL_R1=$TPL_VAR["goods"]["sub_info_desc"]["subInfo"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
														<tr>
															<td class="center"><img src="/admin/skin/default/images/common/icon_move.png"></td>
															<td class="center"><input type="text" name="subInfoTitle[]" class="wp85" value="<?php echo $TPL_V1["title"]?>"/></td>
															<td class="center"><input type="text" name="subInfoDesc[]" class="wp85" value="<?php echo $TPL_V1["desc"]?>"/></td>
															<td class="center"><button type="button" class="btn_minus goodsSubInfoDel"  onclick="del_subInfo(this);"></button></td>
														</tr>
<?php }}?>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
								<ul class='bullet_hyphen resp_message'>
									<li>??????????????? ???????????? ?????? ?????? ?????? ????????? ?????? ?????? ?????? <span class="underline blue hand" onclick="window.open('https://www.firstmall.kr/customer/faq/1540');">????????? ?????? &gt;</span></li>
								</ul>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!-- 03. ???????????? ?????? -->

	<!-- 04. ???????????? ?????? -->
<?php if($TPL_VAR["socialcpuse"]){?>
<?php $this->print_("SOCIAL_HTML",$TPL_SCP,1);?> <!-- _social_for_regist.html -->
<?php }else{?>
	<input type="radio" checked="checked" name="socialcp_input_type" value="" class="hide">
<?php }?>
	<!-- 04. ???????????? ?????? -->

	<!-- 06. ???????????? ?????? -->
	<a name="06" alt="?????? ??????"></a>
	<div class="bx-lay" data-bxcode="sales_info">
		<div class="bx-title">
			<div class="item-title">?????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<input type="hidden" name="viewLayout" value="basic"/>
			<table class="table_basic thl">
<?php if(serviceLimit('H_AD')){?>
				<tr>
					<th>??????</th>
					<td colspan="3" >
						<div class="resp_radio">
							<label class="mr10"><input type="radio" name="provider_status" value="1"  checked="checked" > ??????</label>
							<label><input type="radio" name="provider_status" value="0" > ?????????</label>
						</div>
						<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_admin_confirm', 'sizeS')"></span>
<?php if($TPL_VAR["goods"]["provider_status"]!='1'&&$TPL_VAR["goods"]["goods_seq"]){?>
						<span class="resp_message ml10">(<?php echo $TPL_VAR["goods"]["update_date"]?> ?????????)</span>
<?php }?>
						<!--<span class="btn small orange"><button type="button" class="goods_modify_helper" >??????) ?????? ?????? ??? ?????? ????????? ?????? ??????</button></span>-->
					</td>
				</tr>
<?php }?>
				<tr>
					<th>?????? ??????
						<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_sale_status', 'sizeS')"></span></th>
					<td>
						<div class="resp_radio">
							<label class="mr10"><input type="radio" name="goodsStatus" value="normal"  <?php if(!$TPL_VAR["goods"]["goods_status"]||$TPL_VAR["goods"]["goods_status"]=="normal"){?>checked<?php }?>> ??????</label>
							<label class="mr10"><input type="radio" name="goodsStatus" value="runout" <?php if($TPL_VAR["goods"]["goods_status"]=="runout"){?>checked<?php }?>> ??????</label>
							<label class="mr10"><input type="radio" name="goodsStatus" value="purchasing" <?php if($TPL_VAR["goods"]["goods_status"]=="purchasing"){?>checked<?php }?>> ???????????????</label>
							<label><input type="radio" name="goodsStatus" value="unsold" <?php if($TPL_VAR["goods"]["goods_status"]=="unsold"){?>checked<?php }?>> ????????????</label>
						</div>
					</td>
					<th>????????? ??????</th>
					<td>
						<label class="resp_checkbox"><input type="checkbox" name="restockNotifyUse" value="1" <?php if($TPL_VAR["goods"]["restock_notify_use"]){?>checked="checked"<?php }?> />
							?????? ??? ????????? ?????? ??????</label>
					</td>
				</tr>
				<tr>
					<th>????????? ?????? ??????</th>
					<td colspan="3">
						<div class="resp_radio">
							<label><input type="radio" name="runout_type" value="shop" <?php if(!$TPL_VAR["goods"]["runout_policy"]){?>checked<?php }?> /> ?????? ??????</label>
							<label><input type="radio" name="runout_type" value="goods" <?php if($TPL_VAR["goods"]["runout_policy"]){?>checked<?php }?> /> ?????? ??????</label>
<?php if(!serviceLimit('H_FR')){?>
							<span class="<?php if(!$TPL_VAR["goods"]["runout_policy"]){?>hide<?php }?>">
								<button type="button" class="resp_btn v2 ml20 runout_setting">??????</button>
							</span>
<?php }?>

							<span class="resp_message ml10 <?php if(!$TPL_VAR["goods"]["runout_policy"]){?>hide<?php }?>" id="runout_policy_msg">
<?php if($TPL_VAR["cfg_order"]["runout"]=='stock'){?>
								(????????? ????????? ??????)
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='ableStock'){?>
								(??????????????? ????????? ??????)
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='unlimited'){?>
								(????????? ???????????? ??????)
<?php }?>
							</span>
						</div>
						<ul class='bullet_hyphen resp_message'>
							<li>?????? ????????? <span class="underline blue hand" onclick="window.open('../setting/order');">??????</span>?????? ????????? ??? ????????????.</li>
						</ul>
					</td>
				</tr>
				<tr>
					<th>
						?????? ??????
					</th>
					<td colspan="3">
						<input type="hidden" name="goodsView" value="<?php if($TPL_VAR["goods"]["goods_view"]){?><?php echo $TPL_VAR["goods"]["goods_view"]?><?php }else{?>look<?php }?>">
						<div class="resp_radio">
							<label class="mr10"><input type="radio" name="tmp_goodsView" value="look" checked="checked"> ??????</label>
							<label class="mr10"><input type="radio" name="tmp_goodsView" value="notLook"> ?????????</label>
							<label><input type="radio" name="tmp_goodsView" value="reservation" <?php if($TPL_VAR["goods"]["display_terms"]=='AUTO'&&$TPL_VAR["goods"]["display_terms_close"]=='N'){?>checked<?php }?>> ?????? ??????</label>
						</div>
					</td>
				</tr>
				<tr class="tr_goodsView_reservation <?php if(($TPL_VAR["goods"]["display_terms"]!='AUTO'||$TPL_VAR["goods"]["display_terms_close"]!='N')||$TPL_VAR["goods"]["goods_view"]!='look'){?>hide<?php }?>">
					<th>?????? ?????? ??????</th>
					<td colspan="3">
						<!-- ?????? ?????? ?????? -->
						<div class="wp70">
							<input type="hidden" name="display_terms" value="<?php if($TPL_VAR["goods"]["display_terms"]=='AUTO'){?>AUTO<?php }else{?>MENUAL<?php }?>" />
							<input type="hidden" name="display_terms_type" value="<?php if($TPL_VAR["goods"]["display_terms_type"]=='LAYAWAY'){?>LAYAWAY<?php }else{?>SELLING<?php }?>" />
							<table class="table_basic thl v7">
								<colgroup>
									<col width="20%" /><col width="30%" />
									<col width="20%" /><col width="30%" />
								</colgroup>
								<tbody>
									<tr>
										<th class="display-auto">?????? ?????? ??????</th>
										<td colspan="3">
											<input type="text" name="display_terms_begin" value="<?php if($TPL_VAR["goods"]["display_terms_begin"]){?><?php echo $TPL_VAR["goods"]["display_terms_begin"]?><?php }else{?>0000-00-00<?php }?>" class="datepicker display-form" maxlength="10"> -
											<input type="text" name="display_terms_end" value="<?php if($TPL_VAR["goods"]["display_terms_end"]){?><?php echo $TPL_VAR["goods"]["display_terms_end"]?><?php }else{?>0000-00-00<?php }?>" class="datepicker display-form" maxlength="10">
										</td>
									</tr>
									<tr>
										<th class="display-auto">?????? ?????? ??????</th>
										<td>
											<div class="resp_radio">
												<label><input type="radio" name="display_terms_before" value="DISPLAY" <?php if($TPL_VAR["goods"]["display_terms_before"]!='CONCEAL'){?>checked<?php }?> class="display-form"> ??????</label>
												<label class="ml10"><input type="radio" name="display_terms_before" value="CONCEAL" <?php if($TPL_VAR["goods"]["display_terms_before"]=='CONCEAL'){?>checked<?php }?> class="display-form"> ?????????</label>
											</div>
										</td>
										<th class="display-auto">?????? ?????? ??????</th>
										<td>
											<div class="resp_radio">
												<label><input type="radio" name="display_terms_after" value="DISPLAY" <?php if($TPL_VAR["goods"]["display_terms_after"]!='CONCEAL'){?>checked<?php }?> class="display-form"> ??????</label>
												<label class="ml10"><input type="radio" name="display_terms_after" value="CONCEAL" <?php if($TPL_VAR["goods"]["display_terms_after"]=='CONCEAL'){?>checked<?php }?> class="display-form"> ?????????</label>
											</div>
										</td>
									</tr>
									<tr>
										<th class="display-auto">????????? ??????</th>
										<td colspan="3">
											<input type="text" name="display_terms_text" value="<?php echo $TPL_VAR["goods"]["display_terms_text"]?>" maxlength="20" class="display-form" size="30">
											<input type="text" name="display_terms_color" value="<?php if($TPL_VAR["goods"]["display_terms_color"]){?><?php echo $TPL_VAR["goods"]["display_terms_color"]?><?php }else{?>#FF0000<?php }?>" class="colorpicker display-form"/>
										</td>
									</tr>
									<tr>
										<th class="display-auto">?????? ??????</th>
										<td colspan="3">
											<label class="resp_checkbox">
												<input type="checkbox" name="display_terms_type_tmp" id="display_terms_type" value="LAYAWAY" <?php if($TPL_VAR["goods"]["display_terms_type"]=='LAYAWAY'){?>checked<?php }?> class="display-form"> ?????? ?????? ??????
											</label>
										</td>
									</tr>
									<tr class="ableShippingDateLay <?php if($TPL_VAR["goods"]["display_terms_type"]!='LAYAWAY'){?>hide<?php }?>">
										<th class="display-auto">?????? ?????????</th>
										<td colspan="3">
											<input type="text" name="possible_shipping_date" value="<?php if($TPL_VAR["goods"]["possible_shipping_date"]){?><?php echo $TPL_VAR["goods"]["possible_shipping_date"]?><?php }else{?>0000-00-00<?php }?>" class="datepicker display-form" maxlength="10">
											<span class="resp_message">??? ?????? ????????? ?????? ????????? ?????? ?????? ??? ???????????? ?????? ?????? ????????????.</span>
										</td>
									</tr>
									<tr class="ableShippingDateLay <?php if($TPL_VAR["goods"]["display_terms_type"]!='LAYAWAY'){?>hide<?php }?>">
										<th class="display-auto">?????? ?????? ??????</th>
										<td colspan="3">
											????????? ?????? ?????????
											<input type="text" name="possible_shipping_text" value="<?php if($TPL_VAR["goods"]["possible_shipping_text"]){?><?php echo $TPL_VAR["goods"]["possible_shipping_text"]?><?php }else{?>?????? ??????????????? ???????????????.<?php }?>" size="30" class="display-form"/>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<th>
						?????? ?????? <span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_tax', 'sizeS')"></span>
					</th>
					<td colspan="3">
						<div class="resp_radio">
							<label class="mr10"><input type="radio" name="tax" value="tax"/> ??????</label>
							<label><input type="radio" name="tax" value="exempt" <?php if(!serviceLimit('H_NFR')){?>onclick="<?php echo serviceLimit('A1')?>;$('input[name=\'tax\']').eq(0).click();" readonly<?php }?>> ?????????</label>
						</div>
					</td>
				</tr>
				<tr>
					<th>
						????????????
						<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_cancel_type', 'sizeS')"></span>
					</th>
					<td colspan="3">
						<div class="resp_radio">
							<label class="mr10"><input type="radio" name="cancel_type" value="0"  <?php if($TPL_VAR["goods"]["cancel_type"]!='1'){?>checked<?php }?>> ??????</label>
							<label><input type="radio" name="cancel_type" value="1"  <?php if($TPL_VAR["goods"]["cancel_type"]=='1'){?>checked<?php }?>> ??????</label>
							<span class="resp_message">(??????/??????/?????? ??????)</span>
						</div>
					</td>
				</tr>
				<tr>
					<th>
						?????? ??????
						<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_adult', 'sizeS')"></span>
					</th>
					<td colspan="3">
						<div class="resp_radio">
							<label class="mr10"><input type="radio" name="adult_goods" value="Y"  <?php if($TPL_VAR["goods"]["adult_goods"]=='Y'){?>checked<?php }?>> ??????</label>
							<label><input type="radio" name="adult_goods" value="N"  <?php if($TPL_VAR["goods"]["adult_goods"]!='Y'){?>checked<?php }?>> ?????? ??? ???</label>
						</div>
					</td>
				</tr>
				<tr>
					<th>
						?????? ?????? ??????
						<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_international', 'sizeS')"></span>
					</th>
					<td colspan="3">
						<!-- ??????????????? ?????????????????? -->
						<div class="resp_radio">
							<label class="mr10"><input type="radio" name="option_international_shipping_status" value="y"  <?php if($TPL_VAR["goods"]["option_international_shipping_status"]=='y'){?>checked<?php }?>> ??????</label>
							<label><input type="radio" name="option_international_shipping_status" value="n"  <?php if($TPL_VAR["goods"]["option_international_shipping_status"]!='y'){?>checked<?php }?>> ?????? ??????</label>
						</div>
					</td>
				</tr>
<?php if(!$TPL_VAR["socialcpuse"]){?>
				<tr>
					<th>
						????????????
					</th>
					<td colspan="3">
						<div class="resp_radio">
							<label class="mr10"><input type="radio" name="present_use" value="1"  <?php if($TPL_VAR["goods"]["present_use"]==='1'){?>checked<?php }?>> ??????</label>
							<label><input type="radio" name="present_use" value="0"  <?php if($TPL_VAR["goods"]["present_use"]!='1'){?>checked<?php }?>> ?????? ??? ???</label>
						</div>
					</td>
				</tr>
<?php }?>
			</table>
		</div>
	</div>
	<!-- 06. ???????????? ?????? -->

	<!-- 07-1. ???????????? ?????? -->
	<a name="07" alt="?????? ??????"></a>
	<div class="bx-lay" data-bxcode="options">
		<div class="bx-title">
			<div class="item-title">?????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<!--
				1. ?????? ?????? ????????? open
					= ???????????? ?????? ??????
					#OPTION_HTML		: _option_for_regist.html			: (??????/??????)
					* _resgist_popup_guide.html > #optionDefaultForm 	: (????????????) ?????? ???????????? - ?????? ???????????? ????????? ????????? ?????? ?????? ?????? ??? ?????????.
					set_goods_options.html - #ONLY_VIEW(view_goods_options.html)	: (??????) - ???????????? ?????? ?????? ??? ??????(??????) ??? ??????
				2. ????????????(??????) ??????/?????? ?????? - set_goods_options.html
					- #EDIT_VIEW		: edit_goods_options.html		: ??????/?????? ??????
					- #CREATE_OPTION	: create_goods_options.html		: ???????????? ?????? ??????
				????????? ?????? ??????
					select_goods_options.html
					_select_optoin_package.html
			-->
<?php $this->print_("OPTION_HTML",$TPL_SCP,1);?>

		</div>
	</div>
	<!-- 07-1. ???????????? ?????? -->

	<!-- 07-2. ?????? ?????? ?????? ?????? -->
<?php if(!$TPL_VAR["socialcpuse"]){?>
	<div class="bx-lay" data-bxcode="suboptions">
		<div class="bx-title">
			<div class="item-title">?????? ?????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<!--
				SUBOPTION_HTML	: _suboption_for_regist.html		: ?????????????????? - ?????? ?????? ????????? Open ???
				* _resgist_popup_guide.html > #optionDefaultForm 	: ????????????(??????) ?????? ???????????? - ?????? ???????????? ????????? ????????? ???????????? ?????? ??? ?????????.
				_select_suboptoin_package.html						: ????????? ?????? ??????
			-->
<?php $this->print_("SUBOPTION_HTML",$TPL_SCP,1);?>

		</div>
	</div>
<?php }?>
	<!-- 07-2. ?????? ?????? ?????? ?????? -->

	<!-- 07-3. ?????? ?????? ?????? ?????? -->
	<div class="bx-lay" data-bxcode="inputoptions">
		<div class="bx-title">
			<div class="item-title">?????? ?????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl mb10">
			<tr>
				<th>?????? ?????? ??????</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="memberInputUse" value="1" <?php if($TPL_VAR["goods"]["member_input_use"]){?>checked="checked"<?php }?> /> ??????</label>
						<label class="ml10"><input type="radio" name="memberInputUse" value="" <?php if($TPL_VAR["goods"]["member_input_use"]!='1'){?>checked="checked"<?php }?> /> ?????? ??? ???</label>
					</div>
				</td>
			</tr>
			<tr class="subInputCreate <?php if(!$TPL_VAR["goods"]["member_input_use"]){?>hide<?php }?>">
				<th>?????? ??????</th>
				<td>
					<button type="button" id="memberInputMake" class="resp_btn active">?????? ??????/??????</button>
				</td>
			</tr>
			<tr class="subInputCreate <?php if(!$TPL_VAR["goods"]["member_input_use"]){?>hide<?php }?>">
				<th>?????? ??????</th>
				<td>
					<button type="button" class="resp_btn v2 option_layout_button" data-mode="inputoption">?????? ?????? ??????</button>
					<input type="hidden" name="suboption_layout_group" value="<?php echo $TPL_VAR["goods"]["suboption_layout_group"]?>" />
					<input type="hidden" name="suboption_layout_position" value="<?php echo $TPL_VAR["goods"]["suboption_layout_position"]?>" />
					<input type="hidden" name="inputoption_layout_group" value="<?php echo $TPL_VAR["goods"]["inputoption_layout_group"]?>" />
					<input type="hidden" name="inputoption_layout_position" value="<?php echo $TPL_VAR["goods"]["inputoption_layout_position"]?>" />
				</td>
			</tr>
			</table>

			<div id="memberInputLayer">
<?php if($TPL_VAR["inputs"]){?>
				<table class="table_basic v7 pd5">
					<thead>
						<tr>
							<th width="100">????????????</th>
							<th width="250">?????????</th>
							<th>?????????</th>
						</tr>
					</thead>
					<tbody>
<?php if($TPL_inputs_1){foreach($TPL_VAR["inputs"] as $TPL_V1){?>
						<tr>
							<td class="center">
<?php if($TPL_V1["input_require"]){?>Y<?php }else{?>N<?php }?>
								<input type="hidden" name="memberInputRequire[]" value="<?php if($TPL_V1["input_require"]){?>require<?php }?>" />
								<input type="hidden" name="inputSeq[]" value="<?php echo $TPL_V1["input_seq"]?>" />
								<input type="hidden" name="memberInputName[]" value="<?php echo $TPL_V1["input_name"]?>" />
								<input type="hidden" name="memberInputForm[]" value="<?php echo $TPL_V1["input_form"]?>" />
								<input type="hidden" name="memberInputLimit[]" value="<?php echo $TPL_V1["input_limit"]?>" />
							</td>
							<td class="center"><?php echo $TPL_V1["input_name"]?></td>
							<td>
<?php if($TPL_V1["input_form"]=='text'){?>
								??????????????? <?php if($TPL_V1["input_limit"]){?>(<?php echo $TPL_V1["input_limit"]?>??? ??????)<?php }?>
<?php }elseif($TPL_V1["input_form"]=='edit'){?>
								??????????????? <?php if($TPL_V1["input_limit"]){?>(<?php echo $TPL_V1["input_limit"]?>??? ??????)<?php }?>
<?php }elseif($TPL_V1["input_form"]=='file'){?>
								????????? ????????? (2M??????)
<?php }?>
							</td>
						</tr>
<?php }}?>
					</tbody>
				</table>
<?php }?>
			</div>

		</div>
	</div>
	<!-- 07-3. ?????? ?????? ?????? ?????? -->

	<!-- 08. ?????? ?????? ?????? -->
	<a name="08" alt="?????? ??????"></a>
	<div class="bx-lay" data-bxcode="photo">
		<div class="bx-title">
			<div class="item-title">?????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<!-- ?????? ????????? View :: START -->
			<table class="table_basic thl" id="goodsImageTable">
			<tr>
				<th class="left">?????? ??????</th>
				<td>
					<div id="multiadd">
						<button type="button" class="batchImageMultiRegist resp_btn active" data-type="multi">??????</button>
						<ul class='bullet_hyphen resp_message'>
							<li>?????? ?????? ???????????? ????????? ?????? ???????????????.</li>
						</ul>
					</div>
					<span class="btn-plus first_plus hide"><button type="button" id="goodsImageAdd"></button></span>
				</td>
			</tr>
			<tr class="goodsImageList goodsRegistView <?php if(!$TPL_VAR["images"]){?>hide<?php }?>">
				<th class="left">?????? ??????</th>
				<td>
					<div class="list_info_container">
						<div class="dvs_left">
							<span class="goodsRegistView <?php if(!$TPL_VAR["images"]){?>hide<?php }?>"><button type="button" class="ImageSort resp_btn v2">?????? ?????? ??? ??????</button></span>
						</div>
<?php if($TPL_VAR["goods"]["goods_seq"]){?><!-- ???????????? :: START -->
						<div class="dvs_right" id="watermark_tb">
<?php if(serviceLimit('H_FR')){?>
							<span class="<?php echo serviceLimit('C1')?>"><button type="button" class="resp_btn v2" onclick="<?php echo serviceLimit('A1')?>">???????????? ??????</button></span>
							<span class="<?php echo serviceLimit('C1')?>"><button type="button" class="resp_btn v2" onclick="<?php echo serviceLimit('A1')?>">???????????? ????????????</button></span>
							<span class="<?php echo serviceLimit('C1')?>"><button type="button" class="resp_btn v2" onclick="<?php echo serviceLimit('A1')?>">???????????? ????????????</button></span>
<?php }else{?>
							<button type="button" class="resp_btn v2 waterMarkImageSetting">???????????? ??????</button>
							<button type="button" class="resp_btn v2 waterMarkImageApply">???????????? ????????????</button>
							<button type="button" class="resp_btn waterMarkImageCancel">???????????? ????????????</button>
<?php }?>
						</div>
<?php }?>
						<!-- ???????????? :: END -->
					</div>
					<table class="table_basic goodsImageDetail v7 pd5">
					<colgroup>
						<col width="8%" />
						<col width="11%" />
						<col width="11%" />
						<col width="12%" />
						<col width="11%" />
						<col width="11%" />
						<col width="14%" />
						<col width="11%" />
						<col width="11%" />
					</colgroup>
					<thead>
						<tr>
							<th>??????</th>
							<th>?????? ??????</th>
							<th>?????? ??????</th>
							<th>????????????(??????)</th>
							<th>?????????(1)</th>
							<th>?????????(2)</th>
							<th>????????????(?????????)</th>
							<th>????????????/??????</th>
							<th>?????????</th>
						</tr>
					</thead>
					<tbody>
<?php if($TPL_VAR["images"]){?>
<?php if($TPL_images_1){foreach($TPL_VAR["images"] as $TPL_K1=>$TPL_V1){?>
						<tr class="cut-tr cutnum<?php echo $TPL_K1?>">
							<td class="center">
								<?php echo $TPL_K1?>

							</td>
							<td class="center">
								<button type="button" class="batchImageRegist resp_btn v2" data-divisoin="all">?????? ??????</button>
								<input type="hidden" name="all_chg[]" value="N" />
<?php if($TPL_V1["view"]["match_color"]){?>
								<input type="hidden" name="goodsImageColor[]" value="<?php echo $TPL_V1["view"]["match_color"]?>" /> <span class="fileColorTitle" style="vertical-align: middle;width:30px;height:30px;color:<?php echo $TPL_V1["view"]["match_color"]?>"><span style='display:inline-block;width:18px; height:18px; margin-top:0px; margin-left:2px; border:1px solid #e8e8e8; background-color:<?php echo $TPL_V1["view"]["match_color"]?>;size:25px;'></span></span>
<?php }else{?>
								<input type="hidden" name="goodsImageColor[]" value="" /> <span class="fileColorTitle"></span>
<?php }?>
							</td>
							<td class="center">
								<span class="<?php if(!$TPL_V1["view"]["image"]){?>v3<?php }?> hand goodsview view resp_btn" imageType="view">??????</span>
								<input type="hidden" name="viewGoodsImage[]" value="<?php echo $TPL_V1["view"]["image"]?>" />
								<input type="hidden" name="viewGoodsLabel[]" value="<?php echo $TPL_V1["view"]["label"]?>" />
								<input type="hidden" name="viewGoodsImageSeq[]" value="<?php echo $TPL_V1["view"]["image_seq"]?>" />
								<input type="hidden" name="viewGoodsImageWidth[]" value="<?php echo $TPL_V1["view"]["imageWidth"]?>" />
								<input type="hidden" name="viewGoodsImageHeight[]" value="<?php echo $TPL_V1["view"]["imageHeight"]?>" />
								<input type="hidden" name="view_chg[]" value="N" />
							</td>
							<td class="center">
								<span class="<?php if(!$TPL_V1["large"]["image"]){?>v3<?php }?> hand goodslarge view resp_btn" imageType="large">??????</span>
								<input type="hidden" name="largeGoodsImage[]" value="<?php echo $TPL_V1["large"]["image"]?>" />
								<input type="hidden" name="largeGoodsLabel[]" value="<?php echo $TPL_V1["large"]["label"]?>" />
								<input type="hidden" name="largeGoodsImageSeq[]" value="<?php echo $TPL_V1["large"]["image_seq"]?>" />
								<input type="hidden" name="largeGoodsImageWidth[]" value="<?php echo $TPL_V1["large"]["imageWidth"]?>" />
								<input type="hidden" name="largeGoodsImageHeight[]" value="<?php echo $TPL_V1["large"]["imageHeight"]?>" />
								<input type="hidden" name="large_chg[]" value="N" />
							</td>
							<td class="center">
								<span class="<?php if(!$TPL_V1["list1"]["image"]){?>v3<?php }?> hand goodslist1 view resp_btn" imageType="list1">??????</span>
								<input type="hidden" name="list1GoodsImage[]" value="<?php echo $TPL_V1["list1"]["image"]?>" />
								<input type="hidden" name="list1GoodsLabel[]" value="<?php echo $TPL_V1["list1"]["label"]?>" />
								<input type="hidden" name="list1GoodsImageSeq[]" value="<?php echo $TPL_V1["list1"]["image_seq"]?>" />
								<input type="hidden" name="list1GoodsImageWidth[]" value="<?php echo $TPL_V1["list1"]["imageWidth"]?>" />
								<input type="hidden" name="list1GoodsImageHeight[]" value="<?php echo $TPL_V1["list1"]["imageHeight"]?>" />
								<input type="hidden" name="list1_chg[]" value="N" />
							</td>
							<td class="center">
								<span class="<?php if(!$TPL_V1["list2"]["image"]){?>v3<?php }?> hand goodslist2 view resp_btn" imageType="list2">??????</span>
								<input type="hidden" name="list2GoodsImage[]" value="<?php echo $TPL_V1["list2"]["image"]?>" />
								<input type="hidden" name="list2GoodsLabel[]" value="<?php echo $TPL_V1["list2"]["label"]?>" />
								<input type="hidden" name="list2GoodsImageSeq[]" value="<?php echo $TPL_V1["list2"]["image_seq"]?>" />
								<input type="hidden" name="list2GoodsImageWidth[]" value="<?php echo $TPL_V1["list2"]["imageWidth"]?>" />
								<input type="hidden" name="list2GoodsImageHeight[]" value="<?php echo $TPL_V1["list2"]["imageHeight"]?>" />
								<input type="hidden" name="list2_chg[]" value="N" />
							</td>
							<td class="center">
								<span class="<?php if(!$TPL_V1["thumbView"]["image"]){?>v3<?php }?> hand goodsthumbView view resp_btn" imageType="thumbView">??????</span>
								<input type="hidden" name="thumbViewGoodsImage[]" value="<?php echo $TPL_V1["thumbView"]["image"]?>" />
								<input type="hidden" name="thumbViewGoodsLabel[]" value="<?php echo $TPL_V1["thumbView"]["label"]?>" />
								<input type="hidden" name="thumbViewGoodsImageSeq[]" value="<?php echo $TPL_V1["thumbView"]["image_seq"]?>" />
								<input type="hidden" name="thumbViewGoodsImageWidth[]" value="<?php echo $TPL_V1["thumbView"]["imageWidth"]?>" />
								<input type="hidden" name="thumbViewGoodsImageHeight[]" value="<?php echo $TPL_V1["thumbView"]["imageHeight"]?>" />
								<input type="hidden" name="thumbView_chg[]" value="N" />
							</td>
							<td class="center">
								<span class="<?php if(!$TPL_V1["thumbCart"]["image"]){?>v3<?php }?> hand goodsthumbCart view resp_btn" imageType="thumbCart">??????</span>
								<input type="hidden" name="thumbCartGoodsImage[]" value="<?php echo $TPL_V1["thumbCart"]["image"]?>" />
								<input type="hidden" name="thumbCartGoodsLabel[]" value="<?php echo $TPL_V1["thumbCart"]["label"]?>" />
								<input type="hidden" name="thumbCartGoodsImageSeq[]" value="<?php echo $TPL_V1["thumbCart"]["image_seq"]?>" />
								<input type="hidden" name="thumbCartGoodsImageWidth[]" value="<?php echo $TPL_V1["thumbCart"]["imageWidth"]?>" />
								<input type="hidden" name="thumbCartGoodsImageHeight[]" value="<?php echo $TPL_V1["thumbCart"]["imageHeight"]?>" />
								<input type="hidden" name="thumbCart_chg[]" value="N" />
							</td>
							<td class="center">
								<span class="<?php if(!$TPL_V1["thumbScroll"]["image"]){?>v3<?php }?> hand goodsthumbScroll view resp_btn" imageType="thumbScroll">??????</span>
								<input type="hidden" name="thumbScrollGoodsImage[]" value="<?php echo $TPL_V1["thumbScroll"]["image"]?>" />
								<input type="hidden" name="thumbScrollGoodsLabel[]" value="<?php echo $TPL_V1["thumbScroll"]["label"]?>" />
								<input type="hidden" name="thumbScrollGoodsImageSeq[]" value="<?php echo $TPL_V1["thumbScroll"]["image_seq"]?>" />
								<input type="hidden" name="thumbScrollGoodsImageWidth[]" value="<?php echo $TPL_V1["thumbScroll"]["imageWidth"]?>" />
								<input type="hidden" name="thumbScrollGoodsImageHeight[]" value="<?php echo $TPL_V1["thumbScroll"]["imageHeight"]?>" />
								<input type="hidden" name="thumbScroll_chg[]" value="N" />
							</td>
						</tr>
<?php }}?>
<?php }?>
					</tbody>
					</table>
					<!-- ?????? ????????? View :: END -->
				</td>
			</tr>
			<tr>
				<th class="left">????????????</th>
				<td>
					<div id="goodsImagePriview"></div>
					<input type="hidden" name="largeImageWidth" id="largeImageWidth" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["large"]["width"]?>">
					<input type="hidden" name="largeImageHeight"  id="largeImageHeight" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["large"]["height"]?>">
					<input type="hidden" name="viewImageWidth"  id="viewImageWidth" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["view"]["width"]?>">
					<input type="hidden" name="viewImageHeight"  id="viewImageHeight" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["view"]["height"]?>">
					<input type="hidden" name="list1ImageWidth"  id="list1ImageWidth" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["list1"]["width"]?>">
					<input type="hidden" name="list1ImageHeight"  id="list1ImageHeight" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["list1"]["height"]?>">
					<input type="hidden" name="list2ImageWidth"  id="list2ImageWidth" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["list2"]["width"]?>">
					<input type="hidden" name="list2ImageHeight"  id="list2ImageHeight" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["list2"]["height"]?>">
					<input type="hidden" name="thumbViewWidth"  id="thumbViewWidth" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbView"]["width"]?>">
					<input type="hidden" name="thumbViewHeight"  id="thumbViewHeight" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbView"]["height"]?>">
					<input type="hidden" name="thumbCartWidth"  id="thumbCartWidth" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbCart"]["width"]?>">
					<input type="hidden" name="thumbCartHeight"  id="thumbCartHeight" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbCart"]["height"]?>">
					<input type="hidden" name="thumbScrollWidth"  id="thumbScrollWidth" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbScroll"]["width"]?>">
					<input type="hidden" name="thumbScrollHeight"  id="thumbScrollHeight" size="4" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbScroll"]["height"]?>">
				</td>
			</tr>
			</table>

		</div>
	</div>
	<!-- 08. ?????? ?????? ?????? -->

	<!-- 09. ?????? ?????? ?????? -->
	<a name="09" alt="?????? ??????"></a>
	<div class="bx-lay" data-bxcode="contents">
		<div class="bx-title">
			<div class="item-title">?????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl" style="table-layout: fixed;">
<?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>
			<tr>
				<th class="left">?????? ??????</th>
				<td>
					<button type="button" class="resp_btn v2" id="goodscontentsbtn" onclick="view_editor_pop('goodscontents','save');">??????</button>

					<div class="mt5 wp95 contents_view">
						<textarea class="hide" name="contents" id="goodscontents"  style="width:100%; height:150px;" contentHeight="450px" readonly><?php echo $TPL_VAR["goods"]["contents"]?></textarea>
						<div id="goodscontents_view"><?php echo $TPL_VAR["goods"]["contents"]?></div>
					</div>

					<ul class="bullet_hyphen resp_message">
						<li>
							????????????(11??????, G??????, ?????? ???)??? ?????? ??? ????????? ????????? ????????? ????????? ?????? ????????????.
							<button type="button" class="resp_btn v2" id="openmarketimghostingftp">????????? ????????? ??????</button>
						</li>
<?php if(serviceLimit('H_FR')){?>
						<li>
							????????? ??????????????? ?????? ?????? ??????????????? ?????? ???????????????.
							<span class="<?php echo serviceLimit('C1')?>"><button type="button" class="resp_btn v2" onclick="<?php echo serviceLimit('A1')?>">???????????? ??????</button></span>
						</li>
<?php }else{?>
						<li>
							????????? ??????????????? ?????? ?????? ??????????????? ?????? ???????????????.
							<button type="button" class="resp_btn v2 waterMarkImageSetting">???????????? ??????</button>
						</li>
<?php }?>
					</ul>
				</td>
			</tr>
<?php }?>
			<tr>
				<th class="left"><?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>?????? ??????<?php }else{?>????????? ?????? ??????<?php }?></th>
				<td>
<?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>
					<div class="resp_radio">
						<label><input type="radio" name="mobile_contents_copy" value="N" <?php if($TPL_VAR["goods"]["mobile_contents_copy"]!='Y'){?>checked<?php }?>> ?????? ??????</label>
						<label><input type="radio" name="mobile_contents_copy" value="Y" <?php if($TPL_VAR["goods"]["mobile_contents_copy"]=='Y'){?>checked<?php }?>> PC??? ??????</label>
					</div>
<?php }?>

					<div class="mobileContentView mt5">
						<div id="mobilecontentsbtn">
							<button type="button" class="resp_btn v2" onclick="view_editor_pop('mobile_contents','save');">??????</button>
						</div>

						<textarea class="hide" name="mobile_contents" id="mobile_contents" class="contents_view mt5" readonly><?php echo $TPL_VAR["goods"]["mobile_contents"]?></textarea>
						<div class="contents_view mt5 <?php if($TPL_VAR["goods"]["mobile_contents_copy"]!=''&&$TPL_VAR["goods"]["mobile_contents_copy"]!='N'){?>hide<?php }?>" id="mobile_contents_view"><?php echo $TPL_VAR["goods"]["mobile_contents"]?></div>
					</div>
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
					<ul class="bullet_hyphen resp_message">
						<li>
							????????????(11??????, G??????, ?????? ???)??? ?????? ??? ????????? ????????? ????????? ????????? ?????? ????????????.
							<button type="button" class="resp_btn v2" id="openmarketimghostingftp">????????? ????????? ??????</button>
						</li>
<?php if(serviceLimit('H_FR')){?>
						<li>
							????????? ??????????????? ?????? ?????? ??????????????? ?????? ???????????????.
							<span class="<?php echo serviceLimit('C1')?>"><button type="button" class="resp_btn v2" onclick="<?php echo serviceLimit('A1')?>">???????????? ??????</button></span>
						</li>
<?php }else{?>
						<li>
							????????? ??????????????? ?????? ?????? ??????????????? ?????? ???????????????.
							<button type="button" class="resp_btn v2 waterMarkImageSetting">???????????? ??????</button>
						</li>
<?php }?>
					</ul>
<?php }?>
				</td>
			</tr>
			</table>
		</div>
	</div>
	<!-- 09. ?????? ?????? ?????? -->

	<!-- 10. ?????? ?????? ?????? ?????? -->
	<a name="10" alt="?????? ?????? ?????????"></a>
	<div class="bx-lay" data-bxcode="common_contents">
		<div class="bx-title">
			<div class="item-title">?????? ?????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl">
			<tr>
				<th class="left">?????? ?????? ?????? <span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#tip12')" ></span></th>
				<td>
					<div class="resp_radio">
						<!--label><input type="radio" name="r_info_tmp" value="default" checked="checked" /> ?????? ??????</label-->
						<label><input type="radio" name="r_info_tmp" value="loading_info" /> ?????? ?????? ????????????</label>
						<label class="ml20"><input type="radio" name="r_info_tmp" value="create_info" /> ?????? ??????</label>
					</div>
				</td>
			</tr>
			<tr class="detail s_info hide">
				<th class="left">?????? ?????? ??????</th>
				<td>
					<select name="info_select_tmp">
					<option value="" defaultOption="1">??????</option>
					</select>
					<span id="info_del"><button type="button" onclick="goods_info_del();" class="resp_btn v3">??????</button></span>
				</td>
			</tr>
			<tr class="detail left">
				<th class="left">?????? ??????</th>
				<td>
					<button type="button" class="resp_btn v2" onclick="view_editor_pop('commonContents','save');" id="commoncontentsbtn"> ?????? </button>
					<input type="hidden" name="info_name_view" value="" />
					<input type="hidden" name="info_select_view" value="" />
					<input type="hidden" name="info_select_seq" id="info_select_seq" value="<?php echo $TPL_VAR["goods"]["info_seq"]?>" />

					<textarea class="hide" name="commonContents" id="commonContents" style="width:100%;height:150px;" title="" readonly><?php if($TPL_VAR["goods"]["common_contents"]){?><?php echo $TPL_VAR["goods"]["common_contents"]?><?php }else{?><?php echo $TPL_VAR["config_goods"]["common_contents"]?><?php }?></textarea>
					<div class="contents_view mt5" id="commonContents_view"><?php if($TPL_VAR["goods"]["common_contents"]){?><?php echo $TPL_VAR["goods"]["common_contents"]?><?php }else{?><?php echo $TPL_VAR["config_goods"]["common_contents"]?><?php }?></div>
				</td>
			</tr>
			</table>
			<ul class="bullet_hyphen resp_message">
				<li>
					?????? ?????? ?????? ?????? ??????
					<button type="button" class="btn_goods_default_set resp_btn v2" data-type="commonContents">?????? ??????</button>
				</li>
			</ul>
		</div>
	</div>
	<!-- 10. ?????? ?????? ?????? -->

	<!-- 11. ????????? ?????? -->
<?php if($TPL_VAR["socialcpuse"]){?>
	<input type="hidden" name="trust_shipping" value="N" />
	<input type="hidden" name="old_group_seq" value="<?php echo $TPL_VAR["shipping_info"]["shipping_group_seq"]?>" />
	<input type="hidden" name="shipping_group_seq" value="<?php echo $TPL_VAR["shipping_info"]["shipping_group_seq"]?>" />
<?php }else{?>
	<a name="11" id="shipbookmark" alt="?????????"></a>
	<div class="bx-lay" data-bxcode="shipping">
		<div class="bx-title">
			<div class="item-title">?????????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl">
			<tr>
				<th class="left">????????? ?????? </th>
				<td>
					<div class="shipping_group_div">
						<button type="button" class="shipping_group_select resp_btn v2">??????</button>
						<span class="goods_shipping_group_name hand underline ml10"></span>
						<input type="hidden" name="trust_shipping" id="trust_shipping" value="<?php if($TPL_VAR["goods"]["trust_shipping"]){?><?php echo $TPL_VAR["goods"]["trust_shipping"]?><?php }else{?>N<?php }?>" />
						<input type="hidden" name="old_group_seq" value="<?php echo $TPL_VAR["goods"]["shipping_group_seq"]?>" />
						<input type="hidden" name="shipping_group_seq" id="shipping_group_seq" value="<?php echo $TPL_VAR["goods"]["shipping_group_seq"]?>" />
					</div>
				</td>
			</tr>
			</table>
			<ul class="bullet_hyphen resp_message">
				<li>???????????? <span class="hand blue underline" onClick="window.open('../setting/shipping_group')" target="_blank">?????????</span> ?????? ????????? ??? ????????????.</li>
			</ul>
		</div>
	</div>
<?php }?>
	<!-- 11. ????????? ?????? -->

	<!-- 12. ????????? ?????? -->
	<a name="12" alt="?????????"></a>
	<div class="bx-lay" data-bxcode="events">
		<div class="bx-title">
			<div class="item-title">?????????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl" id="promotionViewSet">
			<tr>
				<th class="left">?????????</th>
				<td>
					<button type="button" class="resp_btn btnViewEvent">?????? ??? ?????????</button>
				</td>
			</tr>
			<tr>
				<th class="left">?????? ????????? ??????</th>
				<td>
					<button type="button" class="resp_btn v2" id="gradeDiscountSet">??????</button>
					<span class="hand underline btnMemberGradeEventView ml10"><?php echo $TPL_VAR["promotion_grade"]["sale_title"]?> (<?php echo $TPL_VAR["promotion_grade"]["sale_seq"]?>)</span>
				</td>
			</tr>
			<tr>
				<th class="left">?????? ?????? ??????</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="multiDiscountSet" value="y" <?php if($TPL_VAR["goods"]["multi_discount_policy_count"]> 0){?>checked<?php }?>> ??????</label>
						<label><input type="radio" name="multiDiscountSet" class="ml20" value="n" <?php if($TPL_VAR["goods"]["multi_discount_policy_count"]== 0){?>checked<?php }?>> ?????? ??? ???</label>
					</div>
					<div class="multiDiscountLay wp50 <?php if($TPL_VAR["goods"]["multi_discount_policy_count"]== 0){?>hide<?php }?>">
						<!-- ???????????? ?????? -->
						<table class="table_basic" id="multiDiscountTable">
							<colgroup>
								<col width="50%"/>
								<col width="40%"/>
								<col width="10%" />
							</colgroup>
							<thead>
								<tr>
									<th>????????????</th>
									<th>
										??????
										<select name="discountUnit" class="resp_text">
										<option value="PER" <?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]!='PRI'){?>selected<?php }?>>%</option>
										<option value="PRI" <?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]=='PRI'){?>selected<?php }?>><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?></option>
										</select>
									</th>
									<th><button type="button" class="addDiscountSet btn_plus"></button></th>
								</tr>
							</thead>
							<tbody>
<?php if($TPL_VAR["goods"]["multi_discount_policy_count"]> 1){?>
<?php if(is_array($TPL_R1=$TPL_VAR["goods"]["multi_discount_policy"]["policyList"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
								<tr>
									<td>
										<input type="text" name="discountOverQty[]" value="<?php echo $TPL_V1["discountOverQty"]?>" class="resp_text onlynumber <?php if($TPL_I1!= 0){?>readonly-color<?php }?>" size="4" maxlength="5" <?php if($TPL_I1!= 0){?>readonly<?php }?>/> ??? ??????
										<span class="discount_under_qty <?php if($TPL_V1["discountUnderQty"]==''){?>hide<?php }?>">
											<input type="text" name="discountUnderQty[]" value="<?php if($TPL_V1["discountUnderQty"]==''){?><?php echo $TPL_V1["discountOverQty"]+ 1?><?php }else{?><?php echo $TPL_V1["discountUnderQty"]?><?php }?>" class="line onlynumber" size="4" maxlength="5"/> ??? ??????
										</span>
									</td>
									<td>
										<input type="text" name="discountAmount[]" value="<?php echo $TPL_V1["discountAmount"]?>" class="resp_text onlynumber right" size="7" maxlength="10"/>
										<span class="discount_unit"><?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]=='PRI'){?><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> / 1???<?php }else{?>%<?php }?></span>
									</td>
									<td class="center">
										<button type="button" class="delDiscountSet btn_minus <?php if($TPL_I1== 0&&count($TPL_VAR["goods"]["multi_discount_policy"]["policyList"])> 1){?>hide<?php }?>"></button>
									</td>
								</tr>
<?php }}?>
<?php }elseif($TPL_VAR["goods"]["multi_discount_policy_count"]== 1){?>
							<tr>
								<td>
									<input type="text" name="discountOverQty[]" value="<?php echo $TPL_VAR["goods"]["multi_discount_policy"]["policyList"][ 0]["discountOverQty"]?>" class="resp_text onlynumber " size="4" maxlength="5"/> ??? ??????
									<span class="discount_under_qty <?php if($TPL_VAR["goods"]["multi_discount_policy"]["policyList"][ 0]["discountUnderQty"]==''){?>hide<?php }?>">
										<input type="text" name="discountUnderQty[]" value="<?php if($TPL_VAR["goods"]["multi_discount_policy"]["policyList"][ 0]["discountUnderQty"]){?><?php echo $TPL_VAR["goods"]["multi_discount_policy"]["policyList"][ 0]["discountUnderQty"]?><?php }?>" class="line onlynumber" size="4" maxlength="5"/> ??? ??????
									</span>
								</td>
								<td>
									<input type="text" name="discountAmount[]" value="<?php echo $TPL_VAR["goods"]["multi_discount_policy"]["policyList"][ 0]["discountAmount"]?>" class="resp_text onlynumber right" size="7" maxlength="10"/>
									<span class="discount_unit"><?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]=='PRI'){?><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> / 1???<?php }else{?>%<?php }?></span>
								</td>
								<td class="center">
									<button type="button" class="delDiscountSet btn_minus "></button>
								</td>
							</tr>
<?php }else{?>
							<tr>
								<td>
									<input type="text" name="discountOverQty[]" value="2" class="resp_text onlynumber" size="4" maxlength="5" /> ??? ??????
									<span class="discount_under_qty hide">
										<input type="text" name="discountUnderQty[]" value="" class="line onlynumber" size="4" maxlength="5"/> ??? ??????
									</span>
								</td>
								<td>
									<input type="text" name="discountAmount[]" value="0" class="resp_text onlynumber right" size="7" maxlength="10"/>
									<span class="discount_unit"><?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]=='PRI'){?><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> / 1???<?php }else{?>%<?php }?></span>
								</td>
								<td class="center">
									<span class=""><button type="button" class="delDiscountSet btn_minus"></button></span></td>
							</tr>
<?php }?>
							</tbody>
							<tfoot class="center max_qty_set <?php if($TPL_VAR["goods"]["multi_discount_policy_count"]<= 0||!$TPL_VAR["goods"]["multi_discount_policy"]["discountMaxOverQty"]){?>hide<?php }?>">
								<tr>
									<td class="left">
										<input type="text" name="discountMaxOverQty" value="<?php echo $TPL_VAR["goods"]["multi_discount_policy"]["discountMaxOverQty"]?>" class="resp_text onlynumber readonly-color" size="4" maxlength="5" readonly/> ??? ??????
									</td>
									<td class="left">
										<input type="text" name="discountMaxAmount" value="<?php echo $TPL_VAR["goods"]["multi_discount_policy"]["discountMaxAmount"]?>" class="resp_text onlynumber right" size="7" maxlength="10"/>
										<span class="discount_unit"><?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]=='PRI'){?><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> / 1???<?php }else{?>%<?php }?></span>
									</td>
									<td></td>
								<tr>
							</tfoot>
						</table>
						<div class="center hide" style="padding:10px;"><span class="btn large black"><button type="button" id="applyMultiDiscountBtn">????????????</button></span></div>
					</div>
				</td>
			</tr>
			</table>
		</div>
	</div>
	<!-- 12. ????????? ?????? -->

	<!-- 13. ?????? ?????? ?????? -->
	<a name="13" alt="?????? ??????"></a>
	<div class="bx-lay" data-bxcode="etc_info">
		<div class="bx-title">
			<div class="item-title">?????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl">
			<tr>
				<th class="left">???????????? ??????</th>
				<td>
					<div class="resp_radio">
						<label class="mr20"><input type="radio" name="possible_pay_type" value="shop" <?php if($TPL_VAR["goods"]["possible_pay_type"]!='goods'){?>checked<?php }?>> ?????? ??????</label>
						<label><input type="radio" name="possible_pay_type" value="goods" <?php if($TPL_VAR["goods"]["possible_pay_type"]=='goods'){?>checked<?php }?>> ?????? ??????</label>
<?php if(serviceLimit('H_NFR')){?>
						<button type="button" class="resp_btn v2" id="possible_pay_setting">??????</button>
<?php }?>
						<span id="possible_pay_td"><?php if($TPL_VAR["goods"]["possible_pay_type"]=="goods"){?>(<?php echo $TPL_VAR["possible_pay_str"]?>)<?php }?></span>
					</div>
					<ul class="bullet_hyphen resp_message">
						<li>?????? ?????? ?????? ????????? <a href="/admin/setting/pg" target="_blank"><span class="underline blue">????????????</span></a>
							?????? <a href="/admin/setting/bank" target="_blank"><span class="underline blue">?????????</span></a>?????? ???????????????</li>
					</ul>
				</td>
			</tr>
			<tr>
				<th class="left">?????? ?????? ??????</th>
				<td>
					<div class="resp_radio">
						<label class="mr25"><input type="radio" name="minPurchaseLimit" value="unlimit" <?php if($TPL_VAR["goods"]["min_purchase_limit"]!='limit'){?>checked="checked"<?php }?> /> ?????? 1???</label>
						<label>
							<input type="radio" name="minPurchaseLimit" value="limit" <?php if($TPL_VAR["goods"]["min_purchase_limit"]=='limit'){?>checked="checked"<?php }?>/>
							?????? <input type="text" name="minPurchaseEa" size="3" class="onlynumber" value="<?php echo $TPL_VAR["goods"]["min_purchase_ea"]?>" /> ??? ?????? ????????????
						</label>
						<span class="desc">(2?????? ?????? ??????)</span>
					</div>
				</td>
			</tr>
			<tr>
				<th class="left">?????? ?????? ??????</th>
				<td>
					<div class="resp_radio">
						<label class="mr20"><input type="radio" name="maxPurchaseLimit" value="unlimit" checked="checked" <?php if($TPL_VAR["goods"]["max_purchase_limit"]!='limit'){?>checked="checked"<?php }?>/> ?????? ??????</label>
						<label>
							<input type="radio" name="maxPurchaseLimit" value="limit" <?php if($TPL_VAR["goods"]["max_purchase_limit"]=='limit'){?>checked="checked"<?php }?>/>
							?????? <input type="text" name="maxPurchaseEa" size="3" class="line onlynumber" value="<?php echo $TPL_VAR["goods"]["max_purchase_ea"]?>" /> ??? ?????? ????????????
						</label>
						<span class="desc">(?????? ???????????? ?????? ??? ???)</span>
					</div>
				</td>
			</tr>
			<tr>
				<th class="left">?????? ?????? ??????</th>
				<td>
					<div class="resp_radio">
						<label class="mr20"><input type="radio" name="stringPriceUse" value="n" checked="checked" <?php if($TPL_VAR["goods"]["stringPriceUse"]!='y'){?>checked="checked"<?php }?>/> ?????? ??????</label>
						<label>
							<input type="radio" name="stringPriceUse" value="y" <?php if($TPL_VAR["goods"]["stringPriceUse"]=='y'){?>checked="checked"<?php }?>/> ?????? ?????? ??????
						</label>

						<button type="button" id="popStringPriceBtn" class="resp_btn v2">??????</button>
						<span class="stringPriceMessage ml10 desc"></span>
					</div>
					<div>
						<!-- //?????? ????????? ?????? ?????????  -->
						<div id="frmStringPrice" class="hide">
<?php if($TPL_goodsStringPrice_1){foreach($TPL_VAR["goodsStringPrice"] as $TPL_K1=>$TPL_V1){?>
							<input type="text" name="<?php echo $TPL_K1?>" value="<?php echo $TPL_V1?>" ><br/>
<?php }}?>
						</div>
						<!-- //?????? ????????? ?????? ????????? -->
					</div>
				</td>
			</tr>
			<tr>
				<th class="left">?????????</th>
				<td>
					<div class="wp55">
						<table class="table_basic v7" id="iconViewTable">
						<colgroup>
							<col width="55%" />
							<col />
							<col width="10%" />
						</colgroup>
						<thead>
							<tr>
								<th>????????????</th>
								<th>?????????</th>
								<th><button type="button" id="iconAdd" class="btn_plus"></button></th>
							</tr>
						</thead>
						<tbody>
							<tr class="nothing <?php if(count($TPL_VAR["icons"])> 0){?>hide<?php }?>">
								<td colspan="3" class="center">???????????? ????????? ?????????.</td>
							</tr>
<?php if($TPL_VAR["icons"]){?>
<?php if($TPL_icons_1){foreach($TPL_VAR["icons"] as $TPL_V1){?>
							<tr>
								<td class="center">
									<input type="hidden" name="iconSeq[]" value="<?php echo $TPL_V1["icon_seq"]?>" />
									<span>
									<input type="text" name="iconStartDate[]" class="iconDate" value="<?php echo $TPL_V1["start_date"]?>"  maxlength="10" size="8" /> ~
									<input type="text" name="iconEndDate[]" value="<?php echo $TPL_V1["end_date"]?>" class="line iconDate"  maxlength="10" size="8" />
									</span>
								</td>
								<td class="center">
									<input type="hidden" name="goodsIcon[]" value="<?php echo $TPL_V1["codecd"]?>" />
									<img src="/data/icon/goods/<?php echo $TPL_V1["codecd"]?>.gif" border="0" class="goodsIcon hand" align="absmiddle">
									<btton type="button" class="goodsIcon resp_btn v2">??????</button>
								</td>
								<td class="center"><button type="button" class="iconDel btn_minus"></button></td>
							</tr>
<?php }}?>
<?php }?>
						</tbody>
						</table>
					</div>
				</td>
			</tr>
<?php if(!$TPL_VAR["socialcpuse"]){?>
			<tr>
				<th class="left">???????????????(HS CODE)</th>
				<td>
					<div>
						<select name="hscode_selector" class="fl mr20" style="margin-top:0px;">
							<option value="0">??????</option>
<?php if($TPL_r_hscode_1){foreach($TPL_VAR["r_hscode"] as $TPL_V1){?><option value="<?php echo $TPL_V1["hscode_common"]?>"><?php echo $TPL_V1["hscode_name"]?>(<?php echo $TPL_V1["hscode_common"]?>)</option><?php }}?>
						</select>
						<input type="hidden" class="hscode" name="hscode" value="<?php echo $TPL_VAR["goods"]["hscode"]?>"/>
						<input type="hidden" name="hscode_name" value="<?php echo $TPL_VAR["sc"]["hscode_name"]?>" style="width:150px;" readonly />

						<ul class="bullet_hyphen resp_message fl" style="margin-top:3px;">
							<li>HS CODE ?????? <a href="../goods/hscode_setting" target="_blank"><span class="underline blue">?????? ?????? &gt;</span></a></li>
						</ul>
					</div>
					<div class="cboth"></div>

					<!-- //????????????????????? ?????? (HS CODE) -->
					<div id="hscodeRegistLayer" class="mt5 <?php if(!$TPL_VAR["goods"]["hscode"]){?>hide<?php }?>">
						<table id="hscode_view" class="table_basic v7 v10">
						<colgroup>
							<col width="15%">
							<col width="10%">
							<col width="20%">
							<col width="10%">
<?php if(is_array($TPL_R1=$TPL_VAR["hscode"]["hscode_items"][ 0]["export_nation_name"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<col>
<?php }}?>
						</colgroup>
							<thead>
								<tr>
									<th class="subj" rowspan="2">??????</th>
									<th class="code" rowspan="2">????????????</th>
									<th colspan="2">??????????????????</th>
									<th class="rate" colspan="<?php echo count($TPL_VAR["hscode"]["hscode_items"][ 0]["export_nation_key"])?>">??????????????? ???????????? ??????</th>
								</tr>
								<tr>
									<th class="nation">????????????</th>
									<th class="nation_code">??????????????????</th>
<?php if($TPL_VAR["hscode"]["hscode_items"][ 0]["export_nation_name"]){?><?php if(is_array($TPL_R1=$TPL_VAR["hscode"]["hscode_items"][ 0]["export_nation_name"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
									<th class="tax"><?php echo $TPL_V1?></th>
<?php }}?><?php }else{?>
									<th class="tax"></th>
<?php }?>
								</tr>
							</thead>
							<tbody>
<?php if($TPL_VAR["goods"]["hscode"]){?>
								<tr>
									<td class="center" rowspan="<?php echo count($TPL_VAR["hscode"]["hscode_items"])?>"><?php echo $TPL_VAR["hscode"]["hscode_name"]?></td>
									<td class="center" rowspan="<?php echo count($TPL_VAR["hscode"]["hscode_items"])?>"><?php echo $TPL_VAR["hscode"]["hscode_common"]?></td>
<?php if(is_array($TPL_R1=$TPL_VAR["hscode"]["hscode_items"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1> 0){?><tr><?php }?>
									<td class="center"><?php echo $TPL_V1["nation_name"]?></td>
									<td class="center"><?php echo $TPL_V1["hscode_nation"]?></td>
<?php if(is_array($TPL_R2=$TPL_V1["customs_tax"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
									<td class="center"><?php echo $TPL_V2?>%</td>
<?php }}?>
<?php if($TPL_K1> 0){?></tr><?php }?>
<?php }}?>
								</tr>
<?php }?>
							</tbody>
						</table>
					</div>
					<!-- //????????????????????? (HS CODE) -->

				</td>
			</tr>
<?php }?>
			</table>
		</div>
	</div>
	<!-- 13. ?????? ?????? ?????? -->

	<!-- 14. ?????? ?????? ?????? -->
	<a name="14" alt="?????? ??????"></a>
	<div class="bx-lay" data-bxcode="bigdata">
		<div class="bx-title">
			<div class="item-title">?????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<div id="condition_change_option"></div><!-- ?????? ?????? ?????????(??????) -->
			<table class="table_basic thl">
<?php if(serviceLimit('H_NFR')){?>
			<tr class="bigdataGoodsContainer">
				<th class="left">?????? ?????? <span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#regist_bigdata', 'sizeS')"></span></th>
				<td>
					<span class=""><button type="button" class="resp_btn active bigdataCriteriaButton displayCriteriaType " dp_id='displayCriteriaBigdata' kind='bigdata' auto_type='bigdata'>?????? ??????</button></span>
					<!-- ## ???????????? -->
					<div class="wp70">
						<table class="table_basic thl mt5">
							<colgroup>
								<col width="10%" />
								<col width="55%" />
								<col width="15%" />
								<col width="20%" />
							</colgroup>
							<thead>
								<tr>
									<th>??????</th>
									<th>??????</th>
									<th>?????????</th>
									<th>
										?????? ?????????
										<input type='hidden' class="displayCriteriaBigdata" id="displayCriteriaBigdata" name='bigdataCriteria' value="<?php echo $TPL_VAR["goods"]["bigdata_criteria"]?>"  goods_seq="<?php echo $TPL_VAR["goods"]["goods_seq"]?>"/>
									</th>
								</tr>
							</thead>
							<tbody class="displayCriteriaBigdataDesc">
								<tr>
									<td colspan="4" class="center">
										<div class="nothing">????????? ????????? ????????????.</div>
									</td>
								</tr>
							</tbody>
						</table>
						<!-- //???????????? -->
						<ul class="bullet_hyphen resp_message">
							<li>?????? ?????? <a href="https://www.firstmall.kr/customer/faq/1333" target="_blank"><span class="underline blue">?????? ?????? &gt;</span></a></li>
						</ul>
					</div>
				</td>
			</tr>
<?php }?>
			<tr class="relationGoodsContainer">
				<th class="left">???????????? <span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#regist_relation', 'sizeS')"></span></th>
				<td>
					<div>
						<div class="resp_radio">
							<label><input type="radio" name="relation_type" class="relation_type" data-type="relation" value="AUTO" checked="checked" /> ??????</label>
							<label><input type="radio" name="relation_type" class="relation_type" data-type="relation" value="MANUAL" /> ?????? ??????</label>
						</div>
						<!-- ???????????? ?????? -->
						<div id="relationGoodsAutoContainer" class="mt5 pdt5" style="border-top:1px dashed #ddd">
							<input type="hidden" class="isBigdataTest" value="1" />
							<button type="button" class="relationCriteriaButton displayCriteriaType resp_btn active" dp_id='relationCriteria' use_id='auto_condition_use' kind='relation' auto_type="auto" goods_seq="<?php echo $TPL_VAR["goods"]["goods_seq"]?>">?????? ??????</button>

							<input type='hidden' class="auto_condition_use" id="auto_condition_use" name='auto_condition_use' value="<?php echo $TPL_VAR["goods"]["auto_condition_use"]?>" />

							<div class="wp70">
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
								<input type='hidden' class="displayCriteria relationCriteria" id="relationCriteria" name='relation_criteria_light' value="<?php echo $TPL_VAR["goods"]["relation_criteria_light"]?>" goods_seq="<?php echo $TPL_VAR["goods"]["goods_seq"]?>" />
								<table class="table_basic mt5 v7">
									<thead>
										<tr>
											<th>??????</th>
										</tr>
									</thead>
									<tbody class="displayCriteriaDesc">
										<tr>
											<td class="center">
												<div class="nothing">????????? ????????? ????????????.</div>
											</td>
										</tr>
									</tbody>
								</table>
<?php }else{?>
								<input type='hidden' class="displayCriteria relationCriteria" id="relationCriteria" name='relation_criteria' value="<?php if($TPL_VAR["goods"]["relation_criteria"]){?><?php echo $TPL_VAR["goods"]["relation_criteria"]?><?php }elseif($TPL_VAR["config_goods"]["relation_criteria"]){?><?php echo $TPL_VAR["config_goods"]["relation_criteria"]?><?php }?>" goods_seq="<?php echo $TPL_VAR["goods"]["goods_seq"]?>" />

								<table class="table_basic thl mt5 v7">
									<colgroup>
										<col width="10%" />
										<col width="90%" />
									</colgroup>
									<thead>
										<tr>
											<th>??????</th>
											<th>??????</th>
										</tr>
									</thead>
									<tbody class="displayCriteriaDesc">
										<tr>
											<td colspan="2" class="center">
												<div class="nothing">????????? ????????? ????????????.</div>
											</td>
										</tr>
									</tbody>
								</table>
<?php }?>
							</div>
						</div>
						<!-- ???????????? ???????????? -->
						<div id="relationGoodsSelectContainer" class="hide mt5 pdt5" style="border-top:1px dashed #ddd">
							<button type="button" class="btnSelectGoods resp_btn active" dp_id="relationGoods">?????? ??????</button>
							<button type="button" class="btnSelectGoodsDel resp_btn v3" selectType="goods">?????? ??????</button>
							<div class="mt5 wx600">
								<div class="goods_list_header">
								<table class="table_basic tdc">
									<colgroup>
										<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
										<col width="25%" />
										<col width="45%" />
<?php }else{?>
										<col width="70%" />
<?php }?>
										<col width="20%" />
									</colgroup>
									<tbody>
										<tr>
											<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" value="goods" title="????????????" onClick="gGoodsSelect.exceptCheckAll(this)"></label></th>
<?php if(serviceLimit('H_AD')){?>
											<th>????????????</th>
<?php }?>
											<th>?????????</th>
											<th>?????????</th>
										</tr>
									</tbody>
								</table>
								</div>
							</div>
							<div class="goods_list wx600" id="relationGoods">
								<table class="table_basic tdc fix">
									<colgroup>
										<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
										<col width="25%" />
										<col width="45%" />
<?php }else{?>
										<col width="70%" />
<?php }?>
										<col width="20%" />
									</colgroup>
									<tbody>
										<tr rownum=0 <?php if(count($TPL_VAR["relation"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
											<td colspan="4">????????? ???????????????</td>
										</tr>
<?php if($TPL_relation_1){foreach($TPL_VAR["relation"] as $TPL_V1){?>
										<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
											<td ><label class="resp_checkbox"><input type="checkbox" name='issueGoodsTmp[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' /></label>
												<input type="hidden" name='relationGoods[]' value='<?php echo $TPL_V1["goods_seq"]?>' />
												<input type="hidden" name="relationGoodsSeq[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["relationgoods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
											<td><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
											<td class='left'>
												<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></div>
												<div class="goodsname">
<?php if($TPL_V1["goods_code"]){?><div>[????????????:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
													<div><?php echo $TPL_V1["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V1["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 30)?></a></div>
												</div>
											</td>
											<td class="right"><?php echo get_currency_price($TPL_V1["price"], 2)?></td>
										</tr>
<?php }}?>
									</tbody>
								</table>
							</div>
							<div id="relationGoodsSelect"></div>
						</div>
					</div>
				</td>
			</tr>
<?php if(serviceLimit('H_AD')){?>
			<tr class="relationSellerGoodsContainer">
				<th class="left">????????? ???????????? <span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_relation_seller', 'sizeS')"></span></th>
				<td>
					<div>
						<div class="resp_radio">
							<label><input type="radio" name="relation_seller_type" class="relation_type" data-type="seller" value="AUTO" checked="checked" /> ??????</label>
							<label><input type="radio" name="relation_seller_type" class="relation_type" data-type="seller" value="MANUAL" /> ?????? ??????</label>
						</div>
						<div id="relationSellerGoodsAutoContainer" class="mt5 pdt5" style="border-top:1px dashed #ddd">
							<input type="hidden" class="isBigdataTest" value="1" />
							<button type="button" class="resp_btn active relationCriteriaButton displayCriteriaType" dp_id='relationSellerCriteria' use_id='' kind='relation_seller' auto_type="auto" goods_seq="<?php echo $TPL_VAR["goods"]["goods_seq"]?>">?????? ??????</button>

							<div class="wp70">
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
									<input type='hidden' class="displayCriteria" id="relationSellerCriteria" name='relation_seller_criteria_light' value="<?php echo $TPL_VAR["goods"]["relation_seller_criteria_light"]?>" goods_seq="<?php echo $_GET["no"]?>" />
									<table class="table_basic mt5 v7">
										<thead>
											<tr>
												<th>??????</th>
											</tr>
										</thead>
										<tbody class="displayCriteriaDesc">
											<tr>
												<td class="center">
													<div class="nothing">????????? ????????? ????????????.</div>
												</td>
											</tr>
										</tbody>
									</table>
<?php }else{?>
									<input type='hidden' class="displayCriteria" id="relationSellerCriteria" name='relation_seller_criteria' value="<?php echo $TPL_VAR["goods"]["relation_seller_criteria"]?>" goods_seq="<?php echo $_GET["no"]?>" />

									<table class="table_basic thl mt5 v7">
										<colgroup>
											<col width="10%" />
											<col width="90%" />
										</colgroup>
										<thead>
											<tr>
												<th>??????</th>
												<th>??????</th>
											</tr>
										</thead>
										<tbody class="displayCriteriaDesc">
											<tr>
												<td colspan="2" class="center">
													<div class="nothing">????????? ????????? ????????????.</div>
												</td>
											</tr>
										</tbody>
									</table>
<?php }?>
							</div>
						</div>

						<!-- ????????? ???????????? ???????????? -->
						<div id="relationSellerGoodsSelectContainer" class="hide mt5 pdt5" style="border-top:1px dashed #ddd">
							<button type="button" class="resp_btn active btnSelectGoods" dp_id="relationSellerGoods">????????????</button>
							<button type="button" class="btnSelectGoodsDel resp_btn v3" selectType="goods">?????? ??????</button>
							<div class="mt5 wx600">
								<div class="goods_list_header">
								<table class="table_basic tdc">
									<colgroup>
										<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
										<col width="25%" />
										<col width="45%" />
<?php }else{?>
										<col width="70%" />
<?php }?>
										<col width="20%" />
									</colgroup>
									<tbody>
										<tr>
											<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" value="goods" onClick="gGoodsSelect.exceptCheckAll(this)"></label></th>
<?php if(serviceLimit('H_AD')){?>
											<th>????????????</th>
<?php }?>
											<th>?????????</th>
											<th>?????????</th>
										</tr>
									</tbody>
								</table>
								</div>
							</div>
							<div class="goods_list wx600" id="relationSellerGoods">
								<table class="table_basic tdc fix">
									<colgroup>
										<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
										<col width="25%" />
										<col width="45%" />
<?php }else{?>
										<col width="70%" />
<?php }?>
										<col width="20%" />
									</colgroup>
									<tbody>
										<tr rownum=0 <?php if(count($TPL_VAR["relation_seller"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
											<td colspan="4">????????? ???????????????</td>
										</tr>
<?php if($TPL_relation_seller_1){foreach($TPL_VAR["relation_seller"] as $TPL_V1){?>
										<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
											<td ><label class="resp_checkbox"><input type="checkbox" name='issueGoodsTmp[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' /></label>
												<input type="hidden" name='relationSellerGoods[]' value='<?php echo $TPL_V1["goods_seq"]?>' />
												<input type="hidden" name="relationSellerGoodsSeq[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["relationgoods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
											<td><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
											<td class='left'>
												<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></div>
												<div class="goodsname">
<?php if($TPL_V1["goods_code"]){?><div>[????????????:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
													<div><?php echo $TPL_V1["goods_kind_icon"]?> <a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V1["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 30)?></a></div>
												</div>
											</td>
											<td><?php echo get_currency_price($TPL_V1["price"], 2)?></td>
										</tr>
<?php }}?>
									</tbody>
								</table>
							</div>
							<div id="relationSellerGoodsSelect"></div>
						</div>
					</div>
					<!-- //????????? ???????????? -->
				</td>
			</tr>
<?php }?>
			</table>
			<ul class="bullet_hyphen resp_message">
				<li>?????? ?????? ?????? ?????? <button type="button" class="resp_btn v2 btn_goods_default_set" data-type="relation">?????? ??????</button></li>
				<li>?????? ?????? ?????????????????? ?????? ??????????????? ??????????????????. <span class="underline blue hand" onClick="window.open('/admin/design/main?setMode=pc')">?????? ????????? &gt; </span></li>
			</ul>
		</div>
	</div>
	<!-- 14. ?????? ?????? ?????? -->

	<!-- 15. ?????? ?????? ?????? ?????? -->
<?php if(!$TPL_VAR["socialcpuse"]){?>
	<a name="15" alt="?????? ?????? ??????"></a>
	<div class="bx-lay" data-bxcode="openmarket">
		<div class="bx-title">
			<div class="item-title">?????? ?????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont" id="openmarketArea">
			<table class="table_basic v7">
				<colgroup>
					<col width="10%"/>
					<col width="20%" />
					<col width="15%" />
					<col width="15%" />
					<col width="10%" />
					<col width="10%" />
					<col width="20%" />
				</colgroup>
				<tbody id="openmarketLists">
					<tr class="openmarket-header">
						<th>??????</th>
						<th>?????????</th>
						<th>????????? ?????????</th>
						<th>?????? ?????? ??????</th>
						<th>?????? ??????</th>
						<th>?????? ??????</th>
						<th>????????? ?????? ??????</th>
					</tr>
					<tr class="openmarket-no-data">
						<td class="center" colspan="7">???????????? ????????? ????????????.</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
<?php }?>
	<!-- 15. ?????? ?????? ?????? ?????? -->

	<!-- 16. ?????? ????????? ?????? -->
<?php if(!$TPL_VAR["socialcpuse"]){?>
	<a name="16" alt="?????? ?????????"></a>
	<div class="bx-lay" data-bxcode="marketing">
		<div class="bx-title">
			<div class="item-title">?????? ?????????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl" id="feed_table">
				<tbody>
					<tr>
						<th class="left">?????? ?????? ??????</th>
						<td colspan="3">
							<div class="resp_radio">
								<!-- <?php if($TPL_VAR["goods"]["goods_seq"]){?> -->
								<label><input type="radio" name="feed_status" value="Y" <?php if($TPL_VAR["goods"]["feed_status"]=='Y'){?>checked="checked"<?php }?>  onclick="chgfeedinfoNew('Y');" <?php if($TPL_VAR["socialcpuse"]){?> disabled <?php }?>> ???</label>
								&nbsp;&nbsp;
								<label><input type="radio" name="feed_status" value="N" <?php if($TPL_VAR["goods"]["feed_status"]!='Y'||$TPL_VAR["socialcpuse"]){?>checked="checked"<?php }?>  onclick="chgfeedinfoNew('N');"> ?????????</label>
								<!-- <?php }else{?>  -->
								<label><input type="radio" name="feed_status" value="Y" <?php if(!$TPL_VAR["socialcpuse"]){?>checked="checked"<?php }?> onclick="chgfeedinfoNew('Y');" <?php if($TPL_VAR["socialcpuse"]){?> disabled <?php }?>> ???</label>
								&nbsp;&nbsp;
								<label><input type="radio" name="feed_status" value="N" <?php if($TPL_VAR["socialcpuse"]){?>checked="checked"<?php }?> onclick="chgfeedinfoNew('N');"> ?????????</label>
								<!-- <?php }?>  -->
							</div>
						</td>
					</tr>
					<tr>
						<th class="left">?????????</th>
						<td colspan="3">
							<div class="resp_radio">
								<label><input type="radio" name="feed_goods_use" class="feed_goods_use" value='N' <?php if($TPL_VAR["goods"]["feed_goods_use"]!='Y'){?>checked<?php }?>>?????? ??????</label>
								<label><input type="radio" name="feed_goods_use" class="feed_goods_use" value='Y' <?php if($TPL_VAR["goods"]["feed_goods_use"]=='Y'){?>checked<?php }?>>?????? ??????</option>
							</div>
							<div id="feed_goods_name_view" class="<?php if($TPL_VAR["goods"]["feed_goods_use"]!='Y'){?>hide<?php }?> mt10">
								<div class="resp_limit_text limitTextEvent">
									<input type="text" id="feed_goods_name" name="feed_goods_name" size='35' class="resp_text" maxlength="100" value="<?php echo $TPL_VAR["goods"]["feed_goods_name"]?>" title="" <?php if($TPL_VAR["goods"]["feed_goods_use"]!='Y'){?>disabled<?php }?>/>
								</div>
								<button type="button" onClick="javascript:helperMessage('replaceCode');" class="resp_btn">?????? ??????</button>
								<ul class="bullet_hyphen resp_message">
									<li>???????????? ?????? ?????? ?????? ?????? ???, ????????? ???????????? ????????? ???????????? ????????? ?????????.</li>
								</ul>
							</div>
						</td>
					</tr>
					<tr>
						<th class="left">?????????</th>
						<td colspan="3">
							<div class="resp_limit_text limitTextEvent">
								<input type="text" id="openmarket_keyword" name="openmarket_keyword" size='100' class="resp_text" maxlength="100" value="<?php echo $TPL_VAR["goods"]["openmarket_keyword"]?>" title="???????????? ,(??????)??? ???????????????" />
							</div>
							<button type="button" id="keyword_btn" class="resp_btn" onclick="openmarketKeyword()">????????????</button>
						</td>
					</tr>
					<tr>
						<th class="left">?????? ?????? <span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#regist_marketing_goods_status', 'sizeS')"></span></th>
						<td>
							<select id="feed_condition" name="feed_condition">
								<option value="">??????</option>
								<option value="?????????" <?php if($TPL_VAR["goods"]["feed_condition"]=='?????????'){?>selected<?php }?>>?????????</option>
								<option value="??????" <?php if($TPL_VAR["goods"]["feed_condition"]=='??????'){?>selected<?php }?>>??????</option>
								<option value="??????" <?php if($TPL_VAR["goods"]["feed_condition"]=='??????'){?>selected<?php }?>>??????</option>
								<option value="??????" <?php if($TPL_VAR["goods"]["feed_condition"]=='??????'){?>selected<?php }?>>??????</option>
								<option value="??????" <?php if($TPL_VAR["goods"]["feed_condition"]=='??????'){?>selected<?php }?>>??????</option>
								<option value="????????????" <?php if($TPL_VAR["goods"]["feed_condition"]=='????????????'){?>selected<?php }?>>????????????</option>
							</select>
						</td>
						<th class="left">???????????? ??????</th>
						<td>
							<select id="product_flag" name="product_flag">
								<option value="">??????</option>
								<option value="??????" <?php if($TPL_VAR["goods"]["product_flag"]=='??????'){?>selected<?php }?>>??????</option>
								<option value="??????" <?php if($TPL_VAR["goods"]["product_flag"]=='??????'){?>selected<?php }?>>??????</option>
								<option value="??????" <?php if($TPL_VAR["goods"]["product_flag"]=='??????'){?>selected<?php }?>>??????</option>
								<option value="????????????" <?php if($TPL_VAR["goods"]["product_flag"]=='????????????'){?>selected<?php }?>>????????????</option>
								<option value="????????????" <?php if($TPL_VAR["goods"]["product_flag"]=='????????????'){?>selected<?php }?>>????????????</option>
							</select>
						</td>
					</tr>
					<tr>
						<th class="left">
							?????? ????????? ??????
							<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_installation_costs', 'sizeS')"></span>
						</th>
						<td>
							<select id="installation_costs" name="installation_costs">
								<option value="">??????</option>
								<option value="Y" <?php if($TPL_VAR["goods"]["installation_costs"]=='Y'){?>selected<?php }?>>????????? ??????</option>
							</select>
						</td>
						<th class="left">
							????????????/?????? ??????
							<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_compound_state', '500')"></span>
						</th>
						<td>
							<select id="compound_state" name="compound_state">
								<option value="">??????</option>
								<option value="parallel_import" <?php if($TPL_VAR["goods"]["compound_state"]=='parallel_import'){?>selected<?php }?>>????????????</option>
								<option value="order_made" <?php if($TPL_VAR["goods"]["compound_state"]=='order_made'){?>selected<?php }?>>????????????</option>
							</select>
						</td>
					</tr>
					<tr>
						<th class="left">?????? ?????????
							<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_feed_evt_sdate', '500')"></span>
						</th>
						<td colspan="3">
							<label class="resp_checkbox"><input type="checkbox" name="marketing_event_set" value='y' <?php if($TPL_VAR["goods"]["feed_evt_sdate"]&&$TPL_VAR["goods"]["feed_evt_sdate"]!="0000-00-00"&&$TPL_VAR["goods"]["feed_evt_edate"]&&$TPL_VAR["goods"]["feed_evt_edate"]!="0000-00-00"){?>checked<?php }?>> ?????? ????????? ??????</label>
							<div class="marketing_event_set">
								<table class="table_basic thl">
								<colgroup>
									<col width="10%">
									<col width="42%">
									<col width="10%">
									<col width="38%">
								</colgroup>
								<tr>
									<th>????????????</th>
									<td>
										<div class="resp_limit_text limitTextEvent">
											<input type="text" name="feed_evt_text" size='45' class="resp_text" maxlength="100" value="<?php echo $TPL_VAR["goods"]["feed_evt_text"]?>" title="" />
										</div>
									</td>
									<th>????????? ??????</th>
									<td>
										<input type="text" name="feed_evt_sdate" value="<?php if(strtotime($TPL_VAR["goods"]["feed_evt_sdate"])> 0){?><?php echo $TPL_VAR["goods"]["feed_evt_sdate"]?><?php }?>" class="datepicker line" readonly maxlength="10" size="10" />	-
										<input type="text" name="feed_evt_edate" value="<?php if(strtotime($TPL_VAR["goods"]["feed_evt_edate"])> 0){?><?php echo $TPL_VAR["goods"]["feed_evt_edate"]?><?php }?>" class="datepicker line" readonly  maxlength="10" size="10" />
									</td>
								</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr>
						<th class="left">?????? ?????????</th>
						<td colspan="3">
							<div class="resp_radio">
								<label><input type="radio" class="feed_shipp_type" name="feed_ship_type" value="G" <?php if($TPL_VAR["goods"]["feed_ship_type"]=='G'||$TPL_VAR["goods"]["feed_ship_type"]==''){?>checked<?php }?>> ?????? ???????????? ??????</label>
								<label class="ml20"><input type="radio" class="feed_shipp_type" name="feed_ship_type" value="S" <?php if($TPL_VAR["goods"]["feed_ship_type"]=='S'){?>checked<?php }?>> ????????????</label>
								<label class="ml20"><input type="radio" class="feed_shipp_type" name="feed_ship_type" value="E" <?php if($TPL_VAR["goods"]["feed_ship_type"]=='E'){?>checked<?php }?>> ????????????</label>
							</div>
						</td>
					</tr>
					<tr class="epSel hide">
						<th class="left">????????? ?????? ??????</th>
						<td colspan="3">
							<div class="resp_radio">
								<label><input type="radio" name="feed_pay_type" value="free" <?php if(!$TPL_VAR["goods"]["feed_pay_type"]||$TPL_VAR["goods"]["feed_pay_type"]=='free'){?>checked<?php }?>> ??????</label>
								<label class="ml10"><input type="radio" name="feed_pay_type" value="fixed" <?php if($TPL_VAR["goods"]["feed_pay_type"]=='fixed'){?>checked<?php }?>> ??????</label>
								<input type="text" name="feed_std_fixed" class="onlynumber right" size="10" value="<?php echo $TPL_VAR["goods"]["feed_std_fixed"]?>" <?php if($TPL_VAR["goods"]["feed_pay_type"]!='fixed'){?>disabled<?php }?>> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

								<label class="ml10">
									<input type="radio" name="feed_pay_type" value="postpay" <?php if($TPL_VAR["goods"]["feed_pay_type"]=='postpay'){?>checked<?php }?>> ??????
								</label>
								<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_marketing_postpay', 'sizeS')"></span>
								<input type="text" name="feed_std_postpay" class="onlynumber right" size="10" value="<?php echo $TPL_VAR["goods"]["feed_std_postpay"]?>" <?php if($TPL_VAR["goods"]["feed_pay_type"]!='postpay'){?>disabled<?php }?>> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

							</div>
						</td>
					</tr>
					<tr class="epSel hide">
						<th class="left">????????? ??????</th>
						<td colspan="3">
							<div class="resp_limit_text limitTextEvent">
								<input type="text" name="feed_add_txt" id="feed_add_txt" size='40' class="resp_text" maxlength="50" value="<?php echo $TPL_VAR["goods"]["feed_add_txt"]?>" title="???) ???????????? 5?????? ??????"  <?php if($TPL_VAR["goods"]["feed_pay_type"]=='postpay'){?>disabled<?php }else{?><?php }?> />
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<ul class="bullet_hyphen resp_message">
				<li>?????? ????????? ?????? ?????? <span class="underline blue hand btn_markting_required">????????? ?????? &gt;</span></li>
				<li>?????? ????????? ?????? ????????? <span class="underline blue hand" onClick="window.open('/admin/marketing/marketplace_url')">?????? ?????????</span>?????? ???????????????.</li>
			</ul>

			<div class="option-message hide" style="margin:0 0 0 5px; border:1px solid #dadada; padding:10px 5px; background-color:#f1f1f1;">
				<ul class="desc">
					<li style="margin-bottom:5px">
						?????? ????????? ?????? ????????? ????????? > <a href="../marketing/marketplace_url" target="_blank"><span class="highlight-link hand">??????????????? ??????</span></a> ?????? ?????? ?????????.
					</li>
					<li style="margin-bottom:5px">
						???????????? ????????? ?????? ????????? ????????? ???????????? ????????? ?????? ????????? ?????? ?????? ???????????????.
					</li>
					<li style="margin-bottom:5px">
						???????????? ???????????? ?????? ??? ?????? ???????????? ???????????? ?????? ????????? ???????????? ???????????? ??????, ????????? ???????????? ????????? ???????????? ????????? ?????????. ?????? ??????????????? ?????? ??? ?????? ???????????? ???????????? ????????????.
					</li>
					<li style="margin-bottom:5px">
						???????????? ????????? '???'??? ?????? ????????? ????????? ?????? ????????? ?????? ???????????? ????????? ?????????.
					</li>
				</ul>
			</div>
		</div>
	</div>
<?php }?>
	<!-- 16. ?????? ????????? ?????? -->

	<!-- 17. ?????? ????????? ?????? -->
	<div class="bx-lay" data-bxcode="video">
		<div class="bx-title">
			<div class="item-title">?????? ?????????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl" id="videofiles_tables_images">
				<tr>
					<th class="left">?????? ?????? ??????</th>
					<td>
						<div style="max-width:1000px;">
							<span class="<?php if($TPL_VAR["cfg_goods"]["video_use"]=='Y'){?><?php }else{?>gray<?php }?> disabled">
								<button type="button" class="<?php if($TPL_VAR["cfg_goods"]["video_use"]=='Y'){?>batchVideoRegist<?php }?> resp_btn v2 " uptype="image" <?php if($TPL_VAR["cfg_goods"]["video_use"]!='Y'){?>onclick="videoSettingAlert();"<?php }?>>??????</button>
							</span>
							<table class="table_basic mt5 videofiles_tables_images v7">
								<colgroup>
									<col/>
									<col width="10%" />
									<col width="10%" />
								</colgroup>
								<thead >
									<tr>
										<th >?????????</th>
										<th >????????? ??????</th>
										<th >????????????</th>
									</tr>
								</thead>
								<tbody>
<?php if(($TPL_VAR["goods"]["file_key_w"]&&uccdomain('fileswf',$TPL_VAR["goods"]["file_key_w"]))){?>
									<tr class="goodsimagesizelay" >
										<td class="center" >
											<div class="fl">
												<img src="/admin/skin/default/images/common/img_video_position1.gif" > <br/>
												<label class="resp_checkbox mt5">
													<input type="checkbox"  class="viewer_uselay" name="viewer_use[image][<?php echo $TPL_VAR["videoimage"]["seq"]?>]" value="Y" <?php if($TPL_VAR["goods"]["video_use"]=='Y'){?>checked="checked"<?php }?>/> ??????
												</label>
													<select name="viewer_position[image][<?php echo $TPL_VAR["videoimage"]["seq"]?>]">
													<option value="first" <?php if($TPL_VAR["videoimage"]["viewer_position"]=='first'){?>selected<?php }?>>?????????</option>
													<option value="last" <?php if($TPL_VAR["videoimage"]["viewer_position"]=='last'){?>selected<?php }?>>?????????</option>
													</select><br/>
												<div style="margin-right:30px;" class="right">
												PC/????????????:<input type="text" name="pc_width[image][<?php echo $TPL_VAR["videoimage"]["seq"]?>]"   size="3" value="<?php if($TPL_VAR["videoimage"]["pc_width"]){?><?php echo $TPL_VAR["videoimage"]["pc_width"]?><?php }else{?>400<?php }?>" class="line onlynumber video_size"   />pixel X <input type="text" name="pc_height[image][<?php echo $TPL_VAR["videoimage"]["seq"]?>]"  size="3" value="<?php if($TPL_VAR["videoimage"]["pc_height"]){?><?php echo $TPL_VAR["videoimage"]["pc_height"]?><?php }else{?>300<?php }?>" class="line onlynumber video_size"   />pixel <br/>
												????????????:<input type="text" name="mobile_width[image][<?php echo $TPL_VAR["videoimage"]["seq"]?>]"   size="3" value="<?php if($TPL_VAR["videoimage"]["mobile_width"]){?><?php echo $TPL_VAR["videoimage"]["mobile_width"]?><?php }else{?>320<?php }?>" class="line onlynumber video_size_mobile"   />pixel X <input type="text" name="mobile_height[image][<?php echo $TPL_VAR["videoimage"]["seq"]?>]"  size="3" value="<?php if($TPL_VAR["videoimage"]["mobile_height"]){?><?php echo $TPL_VAR["videoimage"]["mobile_height"]?><?php }else{?>240<?php }?>" class="line onlynumber video_size_mobile"   />pixel
												<br/>
												<span class="desc" >(???: 320X240, 400X300(??????), 640X480, 720X480)</span>
												</div>
											</div>

											<div id="goodsvideolay" class="videolay" seq="<?php echo $TPL_VAR["videoimage"]["seq"]?>" tmpcode="<?php echo $TPL_VAR["videoimage"]["tmpcode"]?>" >
<?php if($TPL_VAR["goods"]["file_key_w"]&&uccdomain('fileswf',$TPL_VAR["goods"]["file_key_w"])){?>
											<div class="center">
												<table class="center">
												<tr>
													<td class="center">
													<span class="GDDisplayVideoWrap hand">
														<span class="gddisplaythumbnailvideo"  width="200" height="200" ></span>
														<iframe src="<?php echo uccdomain('fileurl',$TPL_VAR["goods"]["file_key_w"])?>" width="200" height="200" frameborder="0" class="hide"></iframe>
														<img src="<?php echo uccdomain('thumbnail',$TPL_VAR["goods"]["file_key_w"])?>" width="200" height="200" >
													</span>
													</td>
													<td class="left" >
													<div style="margin-left:10px;">
													HTML (iframe) <button type="button" class="videourlbtn resp_btn v3" htmlurl="<?php echo uccdomain('fileurl',$TPL_VAR["goods"]["file_key_w"])?>" htmlkey="<?php echo $TPL_VAR["goods"]["file_key_w"]?>"  htmltype="iframe" >URL</button><br/>
													?????????????????? &nbsp;<button type="button" class="videourlbtn resp_btn v3" htmlurl="<?php echo uccdomain('fileurl',$TPL_VAR["goods"]["file_key_w"])?>"  htmltype="page" >URL</button>
													</div>
													</td>
												</tr>
												</table>
											</div>
<?php }?>
											</div>
										</td>
										<td class="center" ><?php echo $TPL_VAR["videoimage"]["r_date"]?></td>
										<td class="center" >
											<div id="goodsvideodellay" class="videodellay" seq="<?php echo $TPL_VAR["videoimage"]["seq"]?>" tmpcode="<?php echo $TPL_VAR["videoimage"]["tmpcode"]?>"  >
<?php if($TPL_VAR["goods"]["file_key_w"]&&uccdomain('fileswf',$TPL_VAR["goods"]["file_key_w"])){?>
												<input type="hidden" name="videofiles[image][<?php echo $TPL_VAR["videoimage"]["seq"]?>]" value="<?php echo $TPL_VAR["videoimage"]["seq"]?>" >
												<input type="hidden" name="file_key_w[image][<?php echo $TPL_VAR["videoimage"]["seq"]?>]" value="<?php echo $TPL_VAR["goods"]["file_key_w"]?>" >
												<input type="hidden" name="file_key_i[image][<?php echo $TPL_VAR["videoimage"]["seq"]?>]" value="<?php echo $TPL_VAR["goods"]["file_key_i"]?>" >
												<label class="resp_checkbox"><input type="checkbox" name="video_del[image][<?php echo $TPL_VAR["videoimage"]["seq"]?>]" value="1" ></label>
<?php }?>
											</div>
										</td>
									</tr>
<?php }else{?>
									<tr id="videofiles_tables_nonetd_img" ><td colspan="3" class="center" >????????? ???????????? ????????????.</td></tr>
<?php }?>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<th class="left">?????? ?????? ??????</th>
					<td>
						<div style="max-width:1000px;">
							<span class="<?php if($TPL_VAR["cfg_goods"]["video_use"]=='Y'){?><?php }else{?>disabled<?php }?> ">
								<button id="videofiles_tables" type="button" class="resp_btn v2 <?php if($TPL_VAR["cfg_goods"]["video_use"]=='Y'){?>batchVideoRegist<?php }?>"  uptype="contents" <?php if($TPL_VAR["cfg_goods"]["video_use"]!='Y'){?>onclick="videoSettingAlert();"<?php }?>>??????</button>
							</span>
							<table class="table_basic mt5 videofiles_tables v7">
								<colgroup>
									<col width="7%" />
									<col/>
									<col width="10%" />
									<col width="10%" />
								</colgroup>
								<thead >
									<tr>
										<th >??????</th>
										<th >?????????</th>
										<th >????????? ??????</th>
										<th >????????????</th>
									</tr>
								</thead>
								<tbody>
<?php if($TPL_goodsvideofiles_1){foreach($TPL_VAR["goodsvideofiles"] as $TPL_V1){?>
									<tr>
										<td class="center videomove hand" ><img src="/admin/skin/default/images/common/icon_move.png" class="hand"></td>
										<td class="center" >
											<div class="fl">
												<img src="/admin/skin/default/images/common/img_video_position2.gif" > <br/>
												<label class="resp_checkbox mt5">
													<input type="checkbox" class="viewer_uselay" name="viewer_use[contents][<?php echo $TPL_V1["seq"]?>]" value="Y" <?php if($TPL_V1["viewer_use"]=='Y'){?> checked="checked"<?php }?>/> ??????
												</label><br/>
												<div style="margin-right:30px;" class="right">
													PC/????????????:<input type="text" name="pc_width[contents][<?php echo $TPL_V1["seq"]?>]"   size="3" value="<?php if($TPL_V1["pc_width"]){?><?php echo $TPL_V1["pc_width"]?><?php }else{?>400<?php }?>" class="line onlynumber video_size"   />pixel X <input type="text" name="pc_height[contents][<?php echo $TPL_V1["seq"]?>]"  size="3" value="<?php if($TPL_V1["pc_height"]){?><?php echo $TPL_V1["pc_height"]?><?php }else{?>300<?php }?>" class="line onlynumber video_size"/>pixel <br/>
													????????????:<input type="text" name="mobile_width[contents][<?php echo $TPL_V1["seq"]?>]"   size="3" value="<?php if($TPL_V1["mobile_width"]){?><?php echo $TPL_V1["mobile_width"]?><?php }else{?>320<?php }?>" class="line onlynumber video_size_mobile"   />pixel X <input type="text" name="mobile_height[contents][<?php echo $TPL_V1["seq"]?>]"  size="3" value="<?php if($TPL_V1["mobile_height"]){?><?php echo $TPL_V1["mobile_height"]?><?php }else{?>240<?php }?>" class="line onlynumber video_size_mobile"/>pixel
													<br/>
													<span class="desc" >(???: 320X240, 400X300(??????), 640X480, 720X480)</span>
												</div>
											</div>
											<div id="videolay<?php echo $TPL_V1["seq"]?>" class="videolay" seq="<?php echo $TPL_V1["seq"]?>" tmpcode="<?php echo $TPL_V1["tmpcode"]?>" style="margin-right:50px;">
<?php if($TPL_V1["file_key_w"]&&uccdomain('fileswf',$TPL_V1["file_key_w"])){?>
											<div class="center">
												<table class="center">
													<tr>
														<td class="center">
															<span class="GDDisplayVideoWrap  hand" >
																<span class="gddisplaythumbnailvideo"  width="200" height="200" ></span>
																<iframe src="<?php echo uccdomain('fileurl',$TPL_V1["file_key_w"])?>" width="200" height="200" frameborder="0" class="hide"></iframe>
																<img src="<?php echo uccdomain('thumbnail',$TPL_V1["file_key_w"])?>" width="200" height="200" >
															</span>
														</td>
														<td class="left" >
															<div style="margin-left:10px;">
															HTML(iframe) <button type="button" class="videourlbtn resp_btn v3" htmlurl="<?php echo uccdomain('fileurl',$TPL_V1["file_key_w"])?>" htmlkey="<?php echo $TPL_V1["file_key_w"]?>"  htmltype="iframe" >URL</button><br/>
															?????????????????? &nbsp; <button type="button" class="videourlbtn resp_btn v3" htmlurl="<?php echo uccdomain('fileurl',$TPL_V1["file_key_w"])?>"  htmltype="page" >URL</button>
															</div>
														</td>
													</tr>
												</table>
											</div>
<?php }?>
											</div>
										</td>
										<td class="center" ><?php echo $TPL_V1["r_date"]?></td>
										<td class="center" >
											<div id="videodellay<?php echo $TPL_V1["seq"]?>" class="videodellay" seq="<?php echo $TPL_V1["seq"]?>" tmpcode="<?php echo $TPL_V1["tmpcode"]?>"  >
<?php if($TPL_V1["file_key_w"]&&uccdomain('fileswf',$TPL_V1["file_key_w"])){?>
											<input type="hidden" name="videofiles[contents][]" value="<?php echo $TPL_V1["seq"]?>" >
											<input type="hidden" name="file_key_w[contents][<?php echo $TPL_V1["seq"]?>]" value="<?php echo $TPL_V1["file_key_w"]?>" >
											<input type="hidden" name="file_key_i[contents][<?php echo $TPL_V1["seq"]?>]" value="<?php echo $TPL_V1["file_key_i"]?>" >
											<label class="resp_checkbox"><input type="checkbox" name="video_del[contents][<?php echo $TPL_V1["seq"]?>]" value="1" ></label>
<?php }?>
										</div>
										</td>
									</tr>
<?php }}else{?>
									<tr id="videofiles_tables_nonetd"><td colspan="4" class="center" >????????? ???????????? ????????????.</td></tr>
<?php }?>
								</tbody>
							</table>
							<!-- //?????? ????????? -->
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<!-- 17. ?????? ????????? ?????? -->

	<!-- 18. QR ?????? ?????? -->
<?php if($TPL_VAR["goods"]["goods_seq"]){?>
	<div class="bx-lay" data-bxcode="qrcode">
		<div class="bx-title">
			<div class="item-title">QR ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl">
			<tr>
				<th class="left">??????</th>
				<td><button type="button" class="qrcodeGuideBtn resp_btn" key="goods" value="<?php echo $TPL_VAR["goods"]["goods_seq"]?>">QR ?????? ??????</button></td>
			</table>
		</div>
	</div>
<?php }?>
	<!-- 18. QR ?????? ?????? -->

	<!-- 19-1. ?????? ?????? -->
	<a name="19" alt="??????"></a>
	<div class="bx-lay" data-bxcode="memo">
		<div class="bx-title">
			<div class="item-title">??????</div>
			<div class='right'></div>
		</div>
		<div class="cont" style="background:#fff;">
			<textarea name="adminMemo" rows="5" class="resp_textarea" style="width:100% !important;padding:10px; box-sizing: border-box;"><?php echo $TPL_VAR["goods"]["admin_memo"]?></textarea>
		</div>
	</div>
	<!-- 19-1. ?????? ?????? -->

	<!-- 19-2. ?????? ?????? ?????? -->
	<div class="bx-lay" data-bxcode="history">
		<div class="bx-title">
			<div class="item-title">?????? ??????</div>
			<div class='right'></div>
		</div>
		<div class="cont" style="background:#fff;">
			 <div class="left edit_history" style="overflow:auto;height:120px;width:98%;border:1px solid #ccc; padding:10px; background-color:#f7f7f7; ">
				<?php echo $TPL_VAR["goods"]["admin_log"]?>

			</div>
		</div>
		<textarea name="admin_log" style="display:none;"><?php echo $TPL_VAR["goods"]["admin_log"]?></textarea>
	</div>
	<!-- 19-2. ?????? ?????? ?????? -->
	<div class="hx50"></div>


<div class="clearbox"></div>



<div id="goods_benefits" class=""></div>
<div id="display_button_info_dialog" class="hide">
	<table class="info-table-style">
		<colgroup>
			<col width="80" />
			<col width="520" />
			<col width="170" />
		</colgroup>
		<tr>
			<th>??????</th>
			<th>??????</th>
			<th >?????????????????????</th>
		</tr>
		<tr>
			<td class="its-th-align pdl5">??????</td>
			<td class=" pdl5">
				<ul class="goods-button-display">
					<li>????????????</li>
					<li>?????? ??????</li>
					<li>????????????</li>
					<li>???????????????</li>
					<li>???????????????</li>
				</ul>
			</td>
			<td class="pdl5 center" rowspan="4">
				??????????????? ?????????<br/>
				?????? ????????? ?????? ??????<br/>
				?????????????????? ?????? ?????? ??????
			</td>
		</tr>
		<tr>
			<td class="its-th-align  pdl5">??????</td>
			<td class=" pdl5">
				<ul class="goods-button-display">
					<li>??????</li>
					<li>???????????????</li>
<?php if(!serviceLimit('H_FR')){?>
					<li>???????????????</li>
<?php }?>
				</ul>
			</td>
		</tr>
		<tr>
			<td class="its-th-align  pdl5">???????????????</td>
			<td class=" pdl5">
				<ul class="goods-button-display">
					<li>???????????????</li>
					<li>???????????????</li>
<?php if(!serviceLimit('H_FR')){?>
					<li>???????????????</li>
<?php }?>
				</ul>
			</td>
		</tr>
		<tr>
			<td class="its-th-align  pdl5">????????????</td>
			<td class=" pdl5">
				<ul class="goods-button-display">
					<li>????????????</li>
				</ul>
			</td>
		</tr>
	</table>
	<ol id="display_button_info_contents">
		<li>??????????????? ?????? ?????? : <span class="highlight-link hand" onclick="window.open('../marketing/marketplace_url');">?????? ?????????</span> ???????????? ?????????????????? ???????????? ????????? ???????????????.</li>
		<li>
			???????????? ?????? ?????? : ?????? ????????? ????????? <span class="highlight-link hand" onclick="window.open('../setting/shipping_group');">????????????</span>??? ???????????? ????????? ????????? ???????????????.
			<div class="pdt5" style="padding-left:115px;">???????????? ?????? ?????? ??? ????????????, ????????????(??????)??? ????????? ???????????? ?????? ?????? ???????????????.</div>
		</li>
		<li>?????? ?????? : ?????????????????? ????????? ?????? ????????????.</li>
		<li>??????????????? ?????? ?????? : ?????? ??????(?????? ??????) ??? ?????? ????????? ?????? ???????????? ?????? ???????????????.</li>
	</ol>
</div>

</form>

<!----??????????????????????????? ??? ?????? ???????????????????????? ????????? ?????? ?????? ---->
<?php $this->print_("_regist_popup_guide",$TPL_SCP,1);?>



<?php $this->print_("barcodeInfo",$TPL_SCP,1);?>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>