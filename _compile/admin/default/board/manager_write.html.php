<?php /* Template_ 2.2.6 2022/05/17 12:30:54 /www/music_brother_firstmall_kr/admin/skin/default/board/manager_write.html 000119469 */ $TPL_smartucc_OBJ=$this->new_("smartucc");
$TPL_boardmanagerlist_1=empty($TPL_VAR["boardmanagerlist"])||!is_array($TPL_VAR["boardmanagerlist"])?0:count($TPL_VAR["boardmanagerlist"]);
$TPL_skinlist_1=empty($TPL_VAR["skinlist"])||!is_array($TPL_VAR["skinlist"])?0:count($TPL_VAR["skinlist"]);
$TPL_categorylist_1=empty($TPL_VAR["categorylist"])||!is_array($TPL_VAR["categorylist"])?0:count($TPL_VAR["categorylist"]);
$TPL_bulkorder_sub_1=empty($TPL_VAR["bulkorder_sub"])||!is_array($TPL_VAR["bulkorder_sub"])?0:count($TPL_VAR["bulkorder_sub"]);
$TPL_reviewcategorylist_1=empty($TPL_VAR["reviewcategorylist"])||!is_array($TPL_VAR["reviewcategorylist"])?0:count($TPL_VAR["reviewcategorylist"]);
$TPL_goodsreview_sub_1=empty($TPL_VAR["goodsreview_sub"])||!is_array($TPL_VAR["goodsreview_sub"])?0:count($TPL_VAR["goodsreview_sub"]);
$TPL_managerlist_1=empty($TPL_VAR["managerlist"])||!is_array($TPL_VAR["managerlist"])?0:count($TPL_VAR["managerlist"]);
$TPL_sms_loop_1=empty($TPL_VAR["sms_loop"])||!is_array($TPL_VAR["sms_loop"])?0:count($TPL_VAR["sms_loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script>
	var file_use = 'N';
	var board_id = 'boardmanager';
	var operation_type = '<?php echo $TPL_VAR["operation_type"]?>';
</script>
<?php if(!$TPL_VAR["id"]){?>
<script src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script src="/app/javascript/plugin/editor/js/daum_editor_loader.js"></script>
<?php }?>
<?php if($TPL_VAR["id"]=='bulkorder'){?>
<script src="/app/javascript/js/admin-bulkorderaddlayer.js"></script>
<?php }elseif($TPL_VAR["id"]=='goods_review'){?>
<script>
	function set_goods_icon(){
		$.getJSON('display_image_icon', function(data) {
			if(data == '') return false;
			var tag = '';
			$("div#goodsReviewIconPopup ul li").remove();
			for(var i=0;i<data.length;i++){
				tag += '<li style="float:left;padding:5px 10px 5px 10px">';
				tag += '<input type="hidden" name="goodsReviewIconCode[]" value="'+data[i].codecd+'">';
				tag += '<img src="<?php echo $TPL_VAR["goodsreviewicon"]?>'+data[i].codecd+'" title="'+data[i].value+'" border="0" class="hand icon" filename="'+data[i].codecd+'">';
				tag += '</li>';
			}
			$("div#goodsReviewIconPopup ul").html(tag);
		});
	}
</script>
<script src="/app/javascript/js/admin-goodsreviewaddlayer.js"></script>
<?php }?>
<!-- ???????????? : ?????? -->
<style>
	/*????????????*/
	.boardtap button {width:96px;height:30px;display:inline-block;overflow:visible;position:relative;margin:0;padding:0;border:0;background:url('/admin/skin/default/images/common/tab_bg.gif') no-repeat;text-decoration:none !important;vertical-align:middle;white-space:nowrap;}
	.boardlarge {width:96px;height:30px;padding-right:26px; background-position:right -200px;}
	.boardlarge button {font-family:'dotum';color:#fff !important;font-size:14px;line-height:20px;font-weight:bold;letter-spacing:-1px;padding:0 13px;}

	/*???????????????*/
	.layer_pop {border:3px solid #618298; background:#fff;}
	.layer_pop .tit {height:45px; font:14px Dotum; letter-spacing:-1px; font-weight:bold; color:#003775; background:#ebf4f2; border-bottom:1px solid #d8dee3; padding:0 10px; border-right:0;}
	.layer_pop .search_input {border:1px solid #cecece; height:17px;}
	.layer_pop .left {text-align:left;}

	.layer_pop_input th {font:11px Dotum; font-weight:bold; letter-spacing:-1px; border:0; background:#fff;}
	.layer_pop_input td {font:11px Dotum; border:0;}
	.layer_pop_input input {height:18px; line-height:15px; padding:0 3px;}

	/* ????????? */
	.icon_wrap {padding:10px;}
	.ico_kakao_on {border:1px solid #fe9b00; background:#fff; padding:1px 3px; font-size:11px; color:#fe7800;}
	.ico_kakao_off, .ico_kakao_x, .ico_sms_off {border:1px solid #b2b3b3; background:#c1c1c2; padding:1px 3px; font-size:11px; color:#fff;}
	.ico_sms_on {border:1px solid #91b8e8; background:#fff; padding:1px 3px; font-size:11px; color:#598ed2;}

	div.icon_layer {width: 50px;height: 50px;margin: 5px auto 10px;border: 1px solid #ccc;position: relative}
	div.icon_layer.left {margin:5px .5em 10px}
	div.icon_layer img {position:absolute;margin:auto;top:0;right:0;bottom:0;left:0;max-width:100%;max-height:100%}

	input[name="category[]"] {width:100%;box-sizing:border-box}
	tbody:empty + tfoot.on-empty-tbody {display:table-footer-group}
</style>

<form name="form_manager_write" id="form_manager_write" method="post" action="../boardmanager_process" target="actionFrame">
<input type="hidden" name="mode" id="" value="<?php echo $TPL_VAR["mode"]?>">
<?php if($TPL_VAR["seq"]){?>
	<input type="hidden" name="seq" id="seq" value="<?php echo $TPL_VAR["seq"]?>">
	<input type="hidden" name="idck" id="idck" value="true">
<?php }else{?>
	<input type="hidden" name="idck" id="idck" value="">
<?php }?>

<!-- ????????? ????????? ??? : ?????? -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- ????????? -->
		<div class="page-title">
			<h2><?php if($TPL_VAR["name"]){?><?php echo $TPL_VAR["name"]?> ??????<?php }else{?>????????? ??????<?php }?></h2>
		</div>

		<!-- ?????? ?????? -->
		<ul class="page-buttons-left">
			<li>
				<a href="/admin/board/main" class="resp_btn v3 size_L">????????? ????????????</a>
			</li>
			<li>
				<select class="resp_btn size_L" id="boardgo" onchange="if(this.value){document.location.href='?id='+this.value;}">
					<option value>???????????????</option>
<?php if($TPL_boardmanagerlist_1){foreach($TPL_VAR["boardmanagerlist"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["id"]?>"<?php if($TPL_VAR["id"]==$TPL_V1["id"]){?> selected<?php }?>><?php echo getstrcut($TPL_V1["name"], 10)?> (<?php echo number_format($TPL_V1["totalnum"])?>)</option>
<?php }}?>
				</select>
			</li>
		</ul>

		<!-- ?????? ?????? -->
		<ul class="page-buttons-right">
<?php if($TPL_VAR["id"]){?>
<?php if(serviceLimit('H_FR')&&$TPL_VAR["id"]=='bulkorder'){?>
				<li>
					<input type="button" class="resp_btn size_L" name="bulkorder_free_btn" value="???????????????">
				</li>
				<li>
					<input type="button" class="resp_btn size_L" name="bulkorder_free_btn" value="???????????????">
				</li>
<?php }else{?>
<?php if(!($TPL_VAR["id"]=='gs_seller_notice'||$TPL_VAR["id"]=='gs_seller_qna')){?>
				<li>
					<a class="resp_btn size_L" href="<?php echo $TPL_VAR["userurl"]?>" target="_blank">???????????????</a>
				</li>
<?php }?>
				<li>
					<a class="resp_btn size_L" href="<?php echo $TPL_VAR["dataurl"]?>" target="_blank">???????????????</a>
				</li>
<?php }?>
<?php }?>
			<li><button type="submit" name="manager_write_btn" id="manager_write_btn" class="resp_btn active2 size_L">??????<span class="arrowright"></span></button></li>
		</ul>
	</div>
</div>
<!-- ????????? ????????? ??? : ??? -->
<!-- ???????????? ?????? : ??????-->
<div >

<div class="contents_container">
	<div class="item-title">?????? ?????? <span class="tooltip_btn" onclick="showTooltip(this, '/admin/tooltip/board', '#tip_information', 'sizeS')"></span></div>
	<table class="table_basic thl">
		<tbody>
			<tr>
				<th>????????????<span class="required_chk"></span></th>
				<td >
					<div class="resp_limit_text limitTextEvent">
						<input type="text" class="resp_text" size="80" maxlength="30" name="board_name" value="<?php echo htmlspecialchars($TPL_VAR["name"])?>" title="????????????(&quot;)??? ????????? ???????????? ?????????????????????."<?php if($TPL_VAR["id"]&&$TPL_VAR["nameread"]){?> readonly<?php }?>>
					</div>
				</td>
			</tr>
			<tr>
				<th>????????? ?????????<span class="required_chk"></span></th>
				<td >
<?php if($TPL_VAR["id"]){?>
						<input type="hidden" name="board_id" id="board_id" size="40" value="<?php echo $TPL_VAR["id"]?>">
						<?php echo $TPL_VAR["id"]?>

<?php }else{?>
						<div class="resp_limit_text limitTextEvent">
							<input type="text" class="resp_text" size="80" maxlength="15" name="board_id" value="<?php echo htmlspecialchars($TPL_VAR["id"])?>" title="??????, ??????, ???????????????(_), ?????????(-) ??????">
						</div>
<?php }?>
				</td>
			</tr>
<?php if($TPL_VAR["useform"]["display"]["skin"]["use"]){?>
			<tr>
				<th>??????</th>
				<td>
					<span class="resp_radio">
<?php if($TPL_skinlist_1){foreach($TPL_VAR["skinlist"] as $TPL_K1=>$TPL_V1){?>
						<label>
							<input type="radio" name="skin[]" id="skin_type<?php echo $TPL_K1?>" value="<?php echo $TPL_K1?>" <?php if(((strstr($TPL_K1,'gallery01')&&!$TPL_VAR["id"])||($TPL_VAR["id"]&&$TPL_K1==$TPL_VAR["skin"]))){?> checked<?php }?> class="skinlay"> <?php echo $TPL_V1?>

						</label>
						<span class="tooltip_btn" onclick="showTooltip(this, '/admin/tooltip/board', '#tip_skin_<?php echo $TPL_K1?>', 'sizeS')"></span>
<?php }}?>
					</span>
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>
<?php if($TPL_VAR["useform"]["auth_reply"]||$TPL_VAR["useform"]["auth_cmt"]||$TPL_VAR["useform"]["auth_cmt_recommend"]||$TPL_VAR["useform"]["auth_recommend"]){?>
	<div class="item-title">????????? ??????</div>
<?php if($TPL_VAR["useform"]["auth_read"]){?><input type="hidden" name="auth_read_use" id="auth_read_use" value="y">
<?php }else{?><?php if($TPL_VAR["useform"]["display"]["auth_read"]["input"]){?><input type="hidden" name="auth_read_use" id="auth_read_use" value="y">
<?php }else{?><input type="hidden" name="auth_read_use" id="auth_read_use" value="<?php echo $TPL_VAR["auth_write_usey"]?>">
<?php }?>
<?php }?>
<?php if($TPL_VAR["useform"]["auth_write"]){?><input type="hidden" name="auth_write_use" id="auth_write_use" value="Y">
<?php }else{?><?php if($TPL_VAR["useform"]["display"]["auth_write"]["title"]){?><input type="hidden" name="auth_write_use" id="auth_write_use" value="Y">
<?php }else{?><input type="hidden" name="auth_write_use" id="auth_write_use" value="<?php echo $TPL_VAR["auth_write_usey"]?>">
<?php }?>
<?php }?>
	<table class="table_basic thl">
		<tbody>
<?php if($TPL_VAR["useform"]["auth_reply"]){?>
			<tr>
				<th>??????</th>
				<td colspan="3">
					<span class="resp_radio">
						<label><input type="radio" name="auth_reply_use" id="auth_reply_usey" value="Y" <?php if($TPL_VAR["auth_reply_use"]=='Y'&&$TPL_VAR["auth_reply_use"]){?> checked="checked" <?php }?>> ??????</label>
						<label><input type="radio" name="auth_reply_use" id="auth_reply_usen" value="N" <?php if($TPL_VAR["auth_reply_use"]=='N'||!$TPL_VAR["auth_reply_use"]){?> checked="checked" <?php }?>> ?????? ??? ???</label>
					</span>
				</td>
			</tr>
<?php }?>
<?php if($TPL_VAR["useform"]["auth_cmt"]){?>
			<tr>
				<th <?php if($TPL_VAR["auth_cmt_use"]=='Y'&&$TPL_VAR["auth_cmt_use"]){?>rowspan="3"<?php }?>>??????</th>
				<td colspan="3">
					<span class="resp_radio">
						<label><input type="radio" name="auth_cmt_use" id="auth_cmt_usey" value="Y" <?php if($TPL_VAR["auth_cmt_use"]=='Y'&&$TPL_VAR["auth_cmt_use"]){?> checked="checked" <?php }?>> ??????</label>
						<label><input type="radio" name="auth_cmt_use" id="auth_cmt_usen" value="N" <?php if($TPL_VAR["auth_cmt_use"]=='N'||!$TPL_VAR["auth_cmt_use"]){?> checked="checked" <?php }?>> ?????? ??? ???</label>
					</span>
				</td>
			</tr>
<?php }?>
<?php if($TPL_VAR["useform"]["auth_cmt_recommend"]){?>
			<tr>
				<th>?????? ??????</th>
				<td colspan="2">
					<span class="resp_radio">
						<label><input type="radio" name="auth_cmt_recommend_use" class="auth_cmt_recommend_use" id="auth_cmt_recommend_usey" value="Y" <?php if($TPL_VAR["auth_cmt_recommend_use"]=='Y'&&$TPL_VAR["auth_cmt_recommend_use"]){?> checked="checked" <?php }?>> ??????</label>
						<label><input type="radio" name="auth_cmt_recommend_use" class="auth_cmt_recommend_use" id="auth_cmt_recommend_usen" value="N" <?php if($TPL_VAR["auth_cmt_recommend_use"]=='N'||!$TPL_VAR["auth_cmt_recommend_use"]){?> checked="checked" <?php }?>> ?????? ??? ???</label>
					</span>
				</td>
			</tr>
			<tr>
				<th>?????? ?????? ??????</th>
				<td colspan="2">
					<span class="resp_radio">
						<label>
							<input type="radio" name="cmt_recommend_type" class="cmt_recommend_type" value="2"<?php if($TPL_VAR["cmt_recommend_type"]=='2'){?> checked<?php }?>> ??????/?????????
						</label>
						<label>
							<input type="radio" name="cmt_recommend_type" class="cmt_recommend_type" value="1"<?php if($TPL_VAR["cmt_recommend_type"]=='1'){?> checked<?php }?>> ??????
						</label>
						<table class="table_basic tdc" style="width:auto">
							<colgroup>
								<col width="200">
								<col width="200">
							</colgroup>
							<thead>
								<tr>
									<th class="cmt_recommend_type1 cmt_recommend_type2">?????? ?????????</th>
									<th class="cmt_recommend_type2">????????? ?????????</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="cmt_recommend_type1 cmt_recommend_type2">
										<div class="icon_layer" id="icon_cmt_recommend_lay"><img src="<?php echo $TPL_VAR["icon_cmt_recommend_img"]?>" id="icon_cmt_recommend_img"></div>
										<button type="button" class="resp_btn v2 iconcmtrecommendBtn" icontype="cmt_recommend">?????? ??????</button>
									</td>
									<td class="cmt_recommend_type2">
										<div class="icon_layer" id="icon_cmt_none_rec_lay"><img src="<?php echo $TPL_VAR["icon_cmt_none_rec_img"]?>" id="icon_cmt_none_rec_img"></div>
										<button type="button" class="resp_btn v2 iconcmtrecommendBtn" icontype="cmt_none_rec">?????? ??????</button>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="resp_message">- ?????? ??????: gif, jpg, jpeg, png</div>
					</span>
				</td>
			</tr>
<?php }?>
<?php if($TPL_VAR["useform"]["auth_recommend"]){?>
			<tr>
				<th rowspan="2">?????????</th>
				<th>????????? ??????</th>
				<td colspan="2">
					<span class="resp_radio">
						<label><input type="radio" name="auth_recommend_use" class="auth_recommend_use" id="auth_recommend_usey" value="Y" <?php if($TPL_VAR["auth_recommend_use"]=='Y'&&$TPL_VAR["auth_recommend_use"]){?> checked="checked" <?php }?>> ??????</label>
						<label><input type="radio" name="auth_recommend_use" class="auth_recommend_use" id="auth_recommend_usen" value="N" <?php if($TPL_VAR["auth_recommend_use"]=='N'||!$TPL_VAR["auth_recommend_use"]){?> checked="checked" <?php }?>> ?????? ??? ???</label>
					</span>
				</td>
			</tr>
			<tr>
				<th>????????? ?????? ??????</th>
				<td colspan="2">
					<span class="resp_radio">
						<label>
							<input type="radio" name="recommend_type" class="recommend_type" value="2"<?php if($TPL_VAR["recommend_type"]=='2'){?> checked<?php }?>> ??????/?????????
						</label>
						<label>
							<input type="radio" name="recommend_type" class="recommend_type" value="1"<?php if($TPL_VAR["recommend_type"]=='1'){?> checked<?php }?>> ??????
						</label>
						<label>
							<input type="radio" name="recommend_type" class="recommend_type" value="3"<?php if($TPL_VAR["recommend_type"]=='3'){?> checked<?php }?>> 5????????????
						</label>
						<table class="table_basic tdc" style="width:auto">
							<colgroup>
								<col width="200">
								<col width="200">
								<col width="200">
								<col width="200">
								<col width="200">
								<col width="200">
								<col width="200">
							</colgroup>
							<thead>
								<tr>
									<th class="recommend_type1 recommend_type2">?????? ?????????</th>
									<th class="recommend_type2">????????? ?????????</th>
									<th class="recommend_type3">?????? ??????</th>
									<th class="recommend_type3">??????</th>
									<th class="recommend_type3">??????</th>
									<th class="recommend_type3">??????</th>
									<th class="recommend_type3">?????? ??????</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="recommend_type1 recommend_type2">
										<div class="icon_layer" id="icon_recommend_lay"><img src="<?php echo $TPL_VAR["icon_recommend_img"]?>" id="icon_recommend_img"></div>
										<button type="button" class="resp_btn v2 iconrecommendBtn" icontype="recommend">?????? ??????</button>
									</td>
									<td class="recommend_type2">
										<div class="icon_layer" id="icon_none_rec_lay"><img src="<?php echo $TPL_VAR["icon_none_rec_img"]?>" id="icon_none_rec_img"></div>
										<button type="button" class="resp_btn v2 iconrecommendBtn" icontype="none_rec">?????? ??????</button>
									</td>
									<td class="recommend_type3">
										<div class="icon_layer" id="icon_recommend1_lay"><img src="<?php echo $TPL_VAR["icon_recommend1_img"]?>" id="icon_recommend1_img"></div>
										<button type="button" class="resp_btn v2 iconrecommendBtn" icontype="recommend1">?????? ??????</button>
									</td>
									<td class="recommend_type3">
										<div class="icon_layer" id="icon_recommend2_lay"><img src="<?php echo $TPL_VAR["icon_recommend2_img"]?>" id="icon_recommend2_img"></div>
										<button type="button" class="resp_btn v2 iconrecommendBtn" icontype="recommend2">?????? ??????</button>
									</td>
									<td class="recommend_type3">
										<div class="icon_layer" id="icon_recommend3_lay"><img src="<?php echo $TPL_VAR["icon_recommend3_img"]?>" id="icon_recommend3_img"></div>
										<button type="button" class="resp_btn v2 iconrecommendBtn" icontype="recommend3">?????? ??????</button>
									</td>
									<td class="recommend_type3">
										<div class="icon_layer" id="icon_recommend4_lay"><img src="<?php echo $TPL_VAR["icon_recommend4_img"]?>" id="icon_recommend4_img"></div>
										<button type="button" class="resp_btn v2 iconrecommendBtn" icontype="recommend4">?????? ??????</button>
									</td>
									<td class="recommend_type3">
										<div class="icon_layer" id="icon_recommend5_lay"><img src="<?php echo $TPL_VAR["icon_recommend5_img"]?>" id="icon_recommend5_img"></div>
										<button type="button" class="resp_btn v2 iconrecommendBtn" icontype="recommend5">?????? ??????</button>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="resp_message">- ?????? ??????: gif, jpg, jpeg, png</div>
					</span>
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>
<?php }?>

<?php if($TPL_VAR["id"]!='store_review'){?>
	<div class="item-title">????????? ?????? ??????</div>
	<table class="table_basic thl">
		<tbody>
			<tr>
				<th>?????? ??????</th>
				<td colspan="2">
					<div>
						<table class="table_basic thc" id="BoardCategoryTable" style="width:400px">
							<colgroup>
								<col width="1">
								<col>
								<col width="1">
							</colgroup>
							<thead>
								<tr>
									<th nowrap>??????</th>
									<th>?????????</th>
									<th>
										<button type="button" class="btn_plus" id="boardcategoryadd"></button>
									</th>
								</tr>
							</thead>
							<tbody>
<?php if($TPL_categorylist_1){foreach($TPL_VAR["categorylist"] as $TPL_V1){?>
								<tr>
									<td>
										<img src="/admin/skin/default/images/common/icon_move.png">
									</td>
									<td class="left">
										<input type="text" name="category[]" value="<?php echo $TPL_V1?>">
									</td>
									<td>
										<button type="button" class="btn_minus etcDel"></button>
									</td>
								</tr>
<?php }}?>
							</tbody>
							<tfoot<?php if($TPL_VAR["categorylist"]){?> class="hide"<?php }?>>
								<tr>
									<td colspan="3" class="center">????????? ????????????.</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</td>
			</tr>
<?php if($TPL_VAR["id"]=='bulkorder'){?>
			<tr>
				<th>????????????</th>
				<td colspan="2">
					<button type="button" id="joinBtn" value="????????????" class="resp_btn active" style="margin-bottom: .4em">?????? ?????? ??????</button>
					<table class="joinform-user-table table_basic tdc" style="max-width:800px">
						<colgroup>
							<col width="1">
							<col>
							<col>
							<col width="1">
							<col width="1">
							<col width="1">
							<col width="1">
						</colgroup>
						<thead>
							<tr>
								<th nowrap>??????</th>
								<th>?????????</th>
								<th>?????? ??????</th>
								<th nowrap>??????</th>
								<th nowrap>??????</th>
								<th nowrap>??????</th>
								<th nowrap>??????</th>
							</tr>
						</thead>
						<tbody class="labelList_bulkorder">
							<tr>
								<td></td>
								<td class="left">??????</td>
								<td class="left">
									<label class="resp_checkbox">
										<input type="checkbox" name="bulk_totprice" id="bulk_totprice" value="1"<?php if($TPL_VAR["bulk_totprice"]){?> checked<?php }?>>
										<span>?????? ???????????? ??????</span>
									</label>
								</td>
								<td>
									<label class="resp_checkbox">
										<input type="checkbox" name="bulk_show[]" id="bulk_show_goods" value="[goods]"<?php if(strstr($TPL_VAR["bulk_show"],'[goods]')){?> checked<?php }?>>
									</label>
								</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td class="left">????????????</td>
								<td class="left">
									<span class="resp_radio bulk_payment_type_alllay <?php if(!strstr($TPL_VAR["bulk_show"],'[payment]')){?>gray<?php }?>">
										<label>
											<input type="radio" name="bulk_payment_type" id="bulk_payment_type_all" value="all" checked="checked">
											<span>?????? ??????</span>
										</label>
										<label>
											<input type="radio" name="bulk_payment_type" id="bulk_payment_type_bank" value="bank">
											<span>?????????</span>
										</label>
									</span>
								</td>
								<td>
									<label class="resp_checkbox">
										<input type="checkbox" name="bulk_show[]" id="bulk_show_payment" value="[payment]"<?php if(strstr($TPL_VAR["bulk_show"],'[payment]')){?> checked<?php }?>>
									</label>
								</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td class="left">?????? ??????</td>
								<td class="left">???????????? ?????? (??????&gt;<a href="/admin/setting/sale" target="_blank">????????????</a>)</td>
								<td>
									<label class="resp_checkbox">
										<input type="checkbox" name="bulk_show[]" id="bulk_show_typereceipt" value="[typereceipt]"<?php if(strstr($TPL_VAR["bulk_show"],'[typereceipt]')){?> checked<?php }?>>
									</label>
								</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
<?php if($TPL_bulkorder_sub_1){foreach($TPL_VAR["bulkorder_sub"] as $TPL_V1){?>
							<tr class="layer<?php echo $TPL_V1["bulkorderform_seq"]?>">
								<td>
									<img src="/admin/skin/default/images/common/icon_move.png">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][bulkorderform_seq]" value="<?php echo $TPL_V1["bulkorderform_seq"]?>">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][id]" value="<?php echo $TPL_V1["label_id"]?>">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][name]" value="<?php echo $TPL_V1["label_title"]?>">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][type]" value="<?php echo $TPL_V1["label_type"]?>">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][exp]" value="<?php echo $TPL_V1["label_desc"]?>">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][value]" value="<?php echo $TPL_V1["label_value"]?>">
								</td>
								<td class="left"><?php echo $TPL_V1["label_title"]?></td>
								<td class="left">[<?php echo $TPL_V1["label_ctype"]?>] <?php echo $TPL_V1["label_desc"]?></td>
								<td>
									<label class="resp_checkbox">
										<input type="checkbox" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][use]" class="bulkorder_chUse" bulkorder_ch="<?php echo $TPL_V1["bulkorderform_seq"]?>" value="Y"<?php if($TPL_V1["used"]=='Y'){?> checked<?php }?>/>
									</label>
								</td>
								<td>
									<label class="resp_checkbox">
										<input type="checkbox" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][required]" class="bulkorder_chRequired" value="Y"<?php if($TPL_V1["required"]=='Y'){?> checked<?php }?>>
									</label>
								</td>
								<td nowrap>
									<button type="button" class="resp_btn v2 listJoinBtn" id="listJoinBtn" value="<?php echo $TPL_V1["bulkorderform_seq"]?>">??????</button>
								</td>
								<td nowrap><?php if($TPL_V1["bulkorderform_seq"]> 6){?>
									<button type="button" class="btn_minus" onclick="deleteRow(this);"></button>
<?php }?></td>
							</tr>
<?php }}?>
						</tbody>
					</table>
				</td>
			</tr>
<?php }?>
<?php if(!($TPL_VAR["id"]=='notice'||$TPL_VAR["id"]=='faq'||$TPL_VAR["id"]=='store_gallery')){?>
			<tr>
				<th>????????? ?????? ??????</th>
				<td colspan="2">
					<span class="resp_radio">
						<label>
							<input type="radio" name="content_default_use" value="1" <?php if($TPL_VAR["content_default"]||$TPL_VAR["content_default_mobile"]){?> checked<?php }?>>
							<span>??????</span>
						</label>
						<label>
							<input type="radio" name="content_default_use" value="0" <?php if(!($TPL_VAR["content_default"]||$TPL_VAR["content_default_mobile"])){?> checked<?php }?>>
							<span>?????? ??? ???</span>
						</label>
					</span>
				</td>
			</tr>
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'&&$TPL_VAR["config_system"]["skin_type"]=='responsive'){?>
			<tr>
				<th>?????? ?????? ??????</th>
				<td colspan="2">
					<textarea rows="10" name="content_default" id="content_default" class="daumeditor" contentHeight="100px"><?php echo htmlspecialchars($TPL_VAR["content_default"])?></textarea>
					<input type="hidden" name="content_default_mobile_use" value="0">
				</td>
			</tr>
<?php }else{?>
			<tr>
				<th>PC ?????? ?????? ??????</th>
				<td colspan="2">
					<textarea rows="10" name="content_default" id="content_default" class="daumeditor" contentHeight="100px"><?php echo htmlspecialchars($TPL_VAR["content_default"])?></textarea>
				</td>
			</tr>
			<tr>
				<th>????????? ?????? ?????? ??????</th>
				<td colspan="2">
					<div class="resp_radio">
						<label>
							<input type="radio" name="content_default_mobile_use" value="1"<?php if(!($TPL_VAR["content_default"]==$TPL_VAR["content_default_mobile"])){?> checked<?php }?>>
							<span>?????? ??????</span>
						</label>
						<label>
							<input type="radio" name="content_default_mobile_use" value="0"<?php if($TPL_VAR["content_default"]==$TPL_VAR["content_default_mobile"]){?> checked<?php }?>>
							<span>PC??? ??????</span>
						</label>
					</div>
					<textarea rows="5" name="content_default_mobile" id="content_default_mobile" style="width:100%;box-sizing:border-box"><?php echo htmlspecialchars($TPL_VAR["content_default_mobile"])?></textarea>
				</td>
			</tr>
<?php }?>
<?php }?>
<?php if($TPL_VAR["useform"]["display"]["autowrite_use"]&&!($TPL_VAR["id"]=='notice'||$TPL_VAR["id"]=='faq'||$TPL_VAR["id"]=='mbqna'||$TPL_VAR["id"]=='gs_seller_qna'||$TPL_VAR["id"]=='gs_seller_notice'||$TPL_VAR["id"]=='store_reservation')){?>
			<tr>
<?php if($TPL_VAR["useform"]["display"]["autowrite_use"]){?>
				<th>???????????? ?????? ??????</th>
				<td colspan="2">
					<span class="resp_radio">
						<label><input type="radio" name="autowrite_use" id="autowrite_usey" value="Y" <?php if($TPL_VAR["autowrite_use"]=='Y'||!$TPL_VAR["autowrite_use"]){?> checked="checked" <?php }?>> ??????</label>&nbsp;
						<label><input type="radio" name="autowrite_use" id="autowrite_usen" value="N" <?php if($TPL_VAR["autowrite_use"]=='N'&&$TPL_VAR["autowrite_use"]){?> checked="checked" <?php }?>> ?????? ??? ???</label>
					</span>
				</td>
<?php }?>
			</tr>
			<tr>
<?php if(($TPL_VAR["id"]=='notice'||$TPL_VAR["id"]=='faq'||$TPL_VAR["id"]=='mbqna'||$TPL_VAR["id"]=='gs_seller_qna'||$TPL_VAR["id"]=='gs_seller_notice')){?>
<?php if($TPL_VAR["id"]=='faq'){?>
					<input type="hidden" name="secret_use" id="secret_usen" value="Y">
<?php }else{?>
					<input type="hidden" name="secret_use" id="secret_usen" value="N">
<?php }?>
<?php }else{?>
				<th>?????????</th>
				<td colspan="2">
					<span class="resp_radio">
						<label><input type="radio" name="secret_use" id="secret_usey" value="Y" <?php if($TPL_VAR["secret_use"]=='Y'||!$TPL_VAR["secret_use"]){?> checked="checked" <?php }?>> ??????(????????? ??????)</label>&nbsp;
						<label><input type="radio" name="secret_use" id="secret_usea" value="A" <?php if($TPL_VAR["secret_use"]=='A'&&$TPL_VAR["secret_use"]){?> checked="checked" <?php }?>> ??????(????????? ??????)</label>&nbsp;
						<label><input type="radio" name="secret_use" id="secret_usen" value="N" <?php if($TPL_VAR["secret_use"]=='N'&&$TPL_VAR["secret_use"]){?> checked="checked" <?php }?>> ?????? ??? ???</label>
					</span>
				</td>
<?php }?>
			</tr>
<?php }?>
			<tr>
				<th>????????????</th>
				<td colspan="2">
<?php if($TPL_VAR["useform"]["display"]["file_use"]){?>
					<span class="resp_radio">
						<label><input type="radio" name="file_use" id="file_usey" value="Y" <?php if($TPL_VAR["file_use"]=='Y'){?> checked="checked" <?php }?>> ?????? </label>(<label class="resp_checkbox"><input type="checkbox" name="onlyimage_use" id="onlyimage_use" value="Y" <?php if($TPL_VAR["onlyimage_use"]=='Y'){?> checked="checked" <?php }?> > ????????? ??????</label>)&nbsp;
						<label><input type="radio" name="file_use" id="file_usen" value="N" <?php if($TPL_VAR["file_use"]=='N'||!$TPL_VAR["file_use"]){?> checked="checked" <?php }?>> ?????? ??? ??? <span class="red">(?????? ??? ?????? ?????? ??????)</span></label>
					</span>
<?php }else{?>
<?php if($TPL_VAR["id"]=='store_reservation'){?>
						?????? ??? ???<input type="hidden" name="file_use" id="file_usey" value="N">
<?php }else{?>
						??????<input type="hidden" name="file_use" id="file_usey" value="Y">
<?php }?>
<?php }?>
				</td>
			</tr>

<?php if($TPL_VAR["skin_type"]=='goods'&&$TPL_VAR["id"]=='goods_review'){?>
			<tr>
				<th>?????????</th>
				<td colspan="2">
					<span class="resp_radio">
						<label><input type="radio" name="video_use" id="video_usey" value="Y" <?php if($TPL_VAR["video_use"]=='Y'){?> checked="checked" <?php }?> <?php if(!($TPL_VAR["ucc_domain"]&&$TPL_VAR["ucc_key"])){?> onclick="alert('????????? ??????????????? ????????? ?????????!');$('#video_usen').attr('checked',true);return false;" <?php }?>/> ??????</label>&nbsp;
						<label><input type="radio" name="video_use" id="video_usen" value="N" <?php if($TPL_VAR["video_use"]=='N'||!$TPL_VAR["video_use"]){?> checked="checked" <?php }?>> ?????? ??? ???</label>
					</span>
				</td>
			</tr>
			<tr>
				<th rowspan="2">????????? ?????????</th>
				<th>??????</th>
				<td>
					<?php echo $TPL_smartucc_OBJ->form_encoding_speed('video_type',$TPL_VAR["video_type"],'class="line"')?> Kbps
				</td>
			</tr>
			<tr>
				<th>??????</th>
				<td>
					<?php echo $TPL_smartucc_OBJ->form_encoding_screen('video_screen',$TPL_VAR["video_screen"],'class="line"')?> Pixel
				</td>
			</tr>
			<tr>
				<th rowspan="2">?????? ?????? ??????</th>
				<th>PC</th>
				<td>
					<input type="text" name="video_size[]" id="video_size0" size="3" value="<?php if($TPL_VAR["video_size0"]){?><?php echo $TPL_VAR["video_size0"]?><?php }else{?>400<?php }?>" class="line onlynumber video_size"> X <input type="text" name="video_size[]" id="video_size1" size="3" value="<?php if($TPL_VAR["video_size1"]){?><?php echo $TPL_VAR["video_size1"]?><?php }else{?>300<?php }?>" class="line onlynumber video_size"> Pixel
				</td>
			</tr>
			<tr>
				<th>?????????</th>
				<td>
					<input type="text" name="video_size_mobile[]" id="video_size_mobile0" size="3" value="<?php if($TPL_VAR["video_size_mobile0"]){?><?php echo $TPL_VAR["video_size_mobile0"]?><?php }else{?>200<?php }?>" class="line onlynumber video_size_mobile"> X <input type="text" name="video_size_mobile[]" id="video_size1" size="3" value="<?php if($TPL_VAR["video_size_mobile1"]){?><?php echo $TPL_VAR["video_size_mobile1"]?><?php }else{?>150<?php }?>" class="line onlynumber video_size_mobile"> Pixel
				</td>
			</tr>
<?php }elseif($TPL_VAR["type"]=='A'){?>
			<tr>
				<th>?????????</th>
				<td>
					<span class="resp_radio">
						<label><input type="radio" name="video_use" id="addvideo_usey" value="Y" <?php if($TPL_VAR["video_use"]=="Y"){?> checked="checked" <?php }?> <?php if(!($TPL_VAR["ucc_domain"]&&$TPL_VAR["ucc_key"])){?> onclick="alert('????????? ??????????????? ????????? ?????????!');$('#video_usen').attr('checked',true);return false;" <?php }?>> ??????</label>&nbsp;
						<label><input type="radio" name="video_use" id="addvideo_usen" value="N" <?php if($TPL_VAR["video_use"]=='N'||!($TPL_VAR["video_use"])){?> checked="checked" <?php }?>> ?????? ??? ???</label>
					</span>
				</td>
			</tr>
			<tr>
				<th rowspan="2">????????? ?????????</th>
				<th>??????</th>
				<td>
					<?php echo $TPL_smartucc_OBJ->form_encoding_speed('video_type',$TPL_VAR["video_type"],'class="line"')?> Kbps
				</td>
			</tr>
			<tr>
				<th>??????</th>
				<td>
					<?php echo $TPL_smartucc_OBJ->form_encoding_screen('video_screen',$TPL_VAR["video_screen"],'class="line"')?>  Pixel
				</td>
			</tr>
			<tr>
				<th rowspan="2">?????? ?????? ??????</th>
				<th>PC</th>
				<td>
					<input type="text" name="video_size[]" id="video_size0" size="3" value="<?php if($TPL_VAR["video_size0"]){?><?php echo $TPL_VAR["video_size0"]?><?php }else{?>400<?php }?>" class="line onlynumber video_size"> X <input type="text" name="video_size[]" id="video_size1" size="3" value="<?php if($TPL_VAR["video_size1"]){?><?php echo $TPL_VAR["video_size1"]?><?php }else{?>300<?php }?>" class="line onlynumber video_size"> Pixel
				</td>
			</tr>
			<tr>
				<th>?????????</th>
				<td>
					<input type="text" name="video_size_mobile[]" id="video_size_mobile0" size="3" value="<?php if($TPL_VAR["video_size_mobile0"]){?><?php echo $TPL_VAR["video_size_mobile0"]?><?php }else{?>200<?php }?>" class="line onlynumber video_size_mobile"> X <input type="text" name="video_size_mobile[]" id="video_size1" size="3" value="<?php if($TPL_VAR["video_size_mobile1"]){?><?php echo $TPL_VAR["video_size_mobile1"]?><?php }else{?>150<?php }?>" class="line onlynumber video_size_mobile"> Pixel
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>
<?php }?>

<?php if($TPL_VAR["skin_type"]=='goods'&&$TPL_VAR["id"]=='goods_review'){?>
	<div class="item-title">?????? ?????? ??????</div>
	<table class="table_basic thl">
		<tbody>
			<tr>
				<th>???????????? ????????? ???
					?????? ?????? ??????
<?php if(serviceLimit('H_FR')){?>
						<br><br><span class="desc" style="font-weight:normal">?????? ?????? ????????? ?????????????????? ???????????????.</span> <img src='/admin/skin/default/images/common/btn_upgrade.gif' class='hand' onclick='serviceUpgrade();' align='absmiddle'>
<?php }?>
				</th>
				<td>
					<table class="table_basic tdc" id="BoardReviewCategoryTable" style="width:400px">
						<colgroup>
							<col width="1">
							<col>
							<col width="1">
						</colgroup>
						<thead>
							<tr>
								<th nowrap>??????</th>
								<th>???????????? ??????</th>
								<th>
									<button type="button" id="boardreviewcategoryadd" class="btn_plus"></button>
								</th>
							</tr>
						</thead>
						<tbody>
<?php if($TPL_VAR["reviewcategorylist"]){?>
<?php if($TPL_reviewcategorylist_1){foreach($TPL_VAR["reviewcategorylist"] as $TPL_V1){?>
							<tr>
								<td>
									<img src="/admin/skin/default/images/common/icon_move.png">
								</td>
								<td class="left">
									<input type="text" name="reviewcategory[]" class="line" value="<?php echo $TPL_V1?>">
								</td>
								<td>
									<button type="button" class="btn_minus etcDel"></button>
								</td>
							</tr>
<?php }}?>
<?php }else{?>
							<tr>
								<td>
									<img src="/admin/skin/default/images/common/icon_move.png">
								</td>
								<td class="left">
									<input type="text" name="reviewcategory[]" class="line" value="??????">
								</td>
								<td>
									<button type="button" class="btn_minus etcDel"></button>
								</td>
							</tr>
<?php }?>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<th>?????? ??????</th>
				<td>
					<span class="resp_radio">
						<label>
							<input type="radio" name="goods_review_type" id="goods_review_typeimg" value="IMAGE"<?php if($TPL_VAR["goods_review_type"]=='IMAGE'||!$TPL_VAR["goods_review_type"]){?> checked<?php }?>>
							<span>?????????</span>
						</label>
						<label>
							<input type="radio" name="goods_review_type" id="goods_review_typeint" value="INT"<?php if($TPL_VAR["goods_review_type"]=='INT'&&$TPL_VAR["goods_review_type"]){?> checked<?php }?>>
							<span>??????</span>
						</label>
					</span>
				</td>
			</tr>
			<tr>
				<th>?????? ????????? ??????</th>
				<td>
					<div class="icon_layer left" id="icon_review_lay">
						<img src="<?php echo $TPL_VAR["icon_review_img"]?>" id="icon_review_img">
					</div>
					<button type="button" id="iconReviewBtn" class="resp_btn v2">?????? ??????</button>
				</td>
			</tr>
			<tr>
				<th>?????? ??????
<?php if(serviceLimit('H_FR')){?>
					<br><br><span class="desc" style="font-weight:normal">???????????? ????????? ?????????????????? ???????????????.</span> <img src='/admin/skin/default/images/common/btn_upgrade.gif' class='hand' onclick='serviceUpgrade();' align='absmiddle'><br><br>
<?php }?>
				</th>
				<td>
					<button type="button" <?php if($TPL_VAR["isplusfreenot"]){?> id="joinBtn" <?php }?> value="????????????" class="resp_btn active" style="margin-bottom:.4em">?????? ?????? ??????</button>
					<table class="joinform-user-table table_basic tdc" style="max-width:800px">
						<colgroup>
							<col width="1">
							<col>
							<col>
							<col width="1">
							<col width="1">
							<col width="1">
							<col width="1">
						</colgroup>
						<thead>
						<tr>
							<th nowrap>??????</th>
							<th>?????????</th>
							<th>?????? ??????</th>
							<th nowrap>??????</th>
							<th nowrap>??????</th>
							<th nowrap>??????</th>
							<th nowrap>??????</th>
						</tr>
						</thead>
						<tbody class="labelList_goodsreview"><?php if($TPL_VAR["goodsreview_sub"]&&$TPL_VAR["isplusfreenot"]){?>
<?php if($TPL_goodsreview_sub_1){foreach($TPL_VAR["goodsreview_sub"] as $TPL_V1){?>
							<tr class="layer<?php echo $TPL_V1["bulkorderform_seq"]?>">
								<td>
									<img src="/admin/skin/default/images/common/icon_move.png">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][bulkorderform_seq]" value="<?php echo $TPL_V1["bulkorderform_seq"]?>">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][id]" value="<?php echo $TPL_V1["label_id"]?>">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][name]" value="<?php echo $TPL_V1["label_title"]?>">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][type]" value="<?php echo $TPL_V1["label_type"]?>">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][exp]" value="<?php echo $TPL_V1["label_desc"]?>">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][value]" value="<?php echo $TPL_V1["label_value"]?>">
									<input type="hidden" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][icon]" value="<?php echo $TPL_V1["label_icon"]?>">
								</td>
								<td class="left"><?php echo $TPL_V1["label_title"]?></td>
								<td class="left">[<?php echo $TPL_V1["label_ctype"]?>] <?php echo $TPL_V1["label_desc"]?></td>
								<td>
									<label class="resp_checkbox">
										<input type="checkbox" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][use]" class="bulkorder_chUse" bulkorder_ch="<?php echo $TPL_V1["bulkorderform_seq"]?>" value="Y" <?php if($TPL_V1["used"]=='Y'){?> checked <?php }?>/>
									</label>
								</td>
								<td>
									<label class="resp_checkbox">
										<input type="checkbox" name="labelItem[user][<?php echo $TPL_V1["bulkorderform_seq"]?>][required]" class="bulkorder_chRequired" value="Y" <?php if($TPL_V1["required"]=='Y'){?> checked <?php }?>>
									</label>
								</td>
								<td nowrap>
									<button type="button" <?php if($TPL_VAR["isplusfreenot"]){?>  class="resp_btn v2 listJoinBtn" id="listJoinBtn" <?php }?> value="<?php echo $TPL_V1["bulkorderform_seq"]?>">??????</button>
								</td>
								<td>
									<button type="button" class="btn_minus" onclick="deleteRow(this)"></button>
								</td>
							</tr>
<?php }}?>
<?php }?></tbody>
						<tfoot class="on-empty-tbody hide">
							<tr>
								<td colspan="7" class="center">?????? ????????? ????????????.</td>
							</tr>
						</tfoot>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
<?php }?>

<?php if(!($TPL_VAR["id"]=='notice'||$TPL_VAR["id"]=='faq'||$TPL_VAR["id"]=='store_review'||$TPL_VAR["id"]=='store_gallery')||($TPL_VAR["skin_type"]=='goods'&&$TPL_VAR["id"]=='goods_review')){?>
<?php if($TPL_VAR["skin_type"]=='goods'&&$TPL_VAR["id"]=='goods_review'){?>
		<div class="item-title">?????? ?????? ?????????</div>
		<table class="table_basic thl">
			<tr>
				<th>???????????? ?????? ??????</th>
				<td>
<?php if(serviceLimit('H_NFR')){?>
					<span class="resp_radio">
						<label>
							<input type="radio" name="autoemoney" id="autoemoney1" value="1"<?php if($TPL_VAR["autoemoney"]== 1){?> checked<?php }?>>
							<span>??????</span>
						</label>
						<label>
							<input type="radio" name="autoemoney" value="0"<?php if($TPL_VAR["autoemoney"]!= 1){?> checked<?php }?>>
							<span>?????? ??? ???</span>
						</label>
					</span>
<?php }?>
				</td>
			</tr>
			<tr class="autoemoney">
				<th>?????? ??????</th>
				<td>
<?php if(serviceLimit('H_FR')){?>
					?????????Plus+????????? ???????????? ?????? ???????????????. <span class="btn large cyanblue"><input type="button" onclick="serviceUpgrade();" value="??????????????? >"></span>
<?php }?>
<?php if(serviceLimit('H_NFR')){?>
					<span class="resp_radio">
						<label>
							<input type="radio" name="autoemoneytype" id="autoemoneytype1" value="1"<?php if($TPL_VAR["autoemoney"]!= 1){?> disabled<?php }?><?php if($TPL_VAR["autoemoneytype"]== 1){?> checked<?php }?>>
							<span>????????? ?????? ?????? ??????</span>
						</label>
						<label>
							<input type="radio" name="autoemoneytype" id="autoemoneytype2" value="2"<?php if($TPL_VAR["autoemoney"]!= 1){?> disabled<?php }?><?php if($TPL_VAR["autoemoneytype"]== 2){?> checked<?php }?>>
							<span>????????? ?????? ??????</span>
							<input type="text" name="autoemoneystrcut1" id="autoemoneystrcut1" value="<?php echo $TPL_VAR["autoemoneystrcut1"]?>" size="2"<?php if($TPL_VAR["autoemoney"]!= 1){?> disabled<?php }?>>
							<span>??? ?????? ??????</span>
						</label>
						<label>
							<input type="radio" name="autoemoneytype" id="autoemoneytype3" value="3"<?php if($TPL_VAR["autoemoney"]!= 1){?> disabled<?php }?><?php if($TPL_VAR["autoemoneytype"]== 3){?> checked<?php }?>>
							<span>??????</span>
							<input type="text" name="autoemoneystrcut2" id="autoemoneystrcut2" value="<?php echo $TPL_VAR["autoemoneystrcut2"]?>" size="2"<?php if($TPL_VAR["autoemoney"]!= 1){?> disabled<?php }?>>
							<span>??? ?????? ??????</span>
						</label>
					</span>
<?php }?>
				</td>
			</tr>
			<tr class="autoemoney">
				<th>?????? ???????????? ??????</th>
				<td>
<?php if(serviceLimit('H_NFR')){?>
					<table class="table_basic thl" style="width:700px">
						<thead>
							<tr>
								<th>??????</th>
								<th>????????????</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>?????????</th>
								<td>
									<label>
										<input type="text" name="autoemoney_video" id="autoemoney_video" value="<?php echo $TPL_VAR["autoemoney_video"]?>" size="5"<?php if($TPL_VAR["autoemoney"]!= 1){?> disabled<?php }?>>
										<span>???</span>
									</label>
									<label>
										<span>????????????:</span>
										<select name="video_reserve_select">
											<option value>???????????? ??????</option>
											<option value="year"<?php if($TPL_VAR["video_reserve_select"]=='year'){?> selected<?php }?>>?????? - 12???31???</option>
											<option value="direct"<?php if($TPL_VAR["video_reserve_select"]=='direct'){?> selected<?php }?>>?????? - ????????????</option>
										</select>
									</label>
									<span name="video_reserve_y" class="hide">
										<label>
											<span>????????????</span>
											<select name="video_reserve_year" id="video_reserve_year">
												<option value="0">0???</option>
												<option value="1">1???</option>
												<option value="2">2???</option>
												<option value="3">3???</option>
												<option value="4">4???</option>
												<option value="5">5???</option>
												<option value="6">6???</option>
												<option value="7">7???</option>
												<option value="8">8???</option>
												<option value="9">9???</option>
												<option value="10">10???</option>
											</select>
											<span>??? ????????????</span>
										</label>
									</span>
									<span name="video_reserve_d" class="hide">
										<label>
											<input type="text" name="video_reserve_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["video_reserve_direct"]?>">
											<span>??????</span>
										</label>
									</span>
								</td>
							</tr>
							<tr>
								<th>??????</th>
								<td>
									<label>
										<input type="text" name="autoemoney_photo" id="autoemoney_photo" value="<?php echo $TPL_VAR["autoemoney_photo"]?>" size="5"<?php if($TPL_VAR["autoemoney"]!= 1){?> disabled<?php }?>>
										<span>???</span>
									</label>
									<label>
										<span>????????????:</span>
										<select name="photo_reserve_select">
											<option value>???????????? ??????</option>
											<option value="year"<?php if($TPL_VAR["photo_reserve_select"]=='year'){?> selected<?php }?>>?????? - 12???31???</option>
											<option value="direct"<?php if($TPL_VAR["photo_reserve_select"]=='direct'){?> selected<?php }?>>?????? - ????????????</option>
										</select>
									</label>
									<span name="photo_reserve_y" class="hide">
										<label>
											<span>????????????</span>
											<select name="photo_reserve_year" id="photo_reserve_year">
												<option value="0">0???</option>
												<option value="1">1???</option>
												<option value="2">2???</option>
												<option value="3">3???</option>
												<option value="4">4???</option>
												<option value="5">5???</option>
												<option value="6">6???</option>
												<option value="7">7???</option>
												<option value="8">8???</option>
												<option value="9">9???</option>
												<option value="10">10???</option>
											</select>
											<span>??? ????????????</span>
										</label>
									</span>
									<span name="photo_reserve_d" class="hide">
										<label>
											<input type="text" name="photo_reserve_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["photo_reserve_direct"]?>">
											<span>??????</span>
										</label>
									</span>
								</td>
							</tr>
							<tr>
								<th>??????</th>
								<td>
									<label>
										<input type="text" name="autoemoney_review" id="autoemoney_review" value="<?php echo $TPL_VAR["autoemoney_review"]?>" size="5"<?php if($TPL_VAR["autoemoney"]!= 1){?> disabled<?php }?>>
										<span>???</span>
									</label>
									<label>
										<span>????????????:</span>
										<select name="default_reserve_select">
											<option value>???????????? ??????</option>
											<option value="year"<?php if($TPL_VAR["default_reserve_select"]=='year'){?> selected<?php }?>>?????? - 12???31???</option>
											<option value="direct"<?php if($TPL_VAR["default_reserve_select"]=='direct'){?> selected<?php }?>>?????? - ????????????</option>
										</select>
									</label>
									<span name="default_reserve_y" class="hide">
										<label>
											<span>????????????</span>
											<select name="default_reserve_year" id="default_reserve_year">
												<option value="0">0???</option>
												<option value="1">1???</option>
												<option value="2">2???</option>
												<option value="3">3???</option>
												<option value="4">4???</option>
												<option value="5">5???</option>
												<option value="6">6???</option>
												<option value="7">7???</option>
												<option value="8">8???</option>
												<option value="9">9???</option>
												<option value="10">10???</option>
											</select>
											<span>??? ????????????</span>
										</label>
									</span>
									<span name="default_reserve_d" class="hide">
										<label>
											<input type="text" name="default_reserve_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["default_reserve_direct"]?>">
											<span>??????</span>
										</label>
									</span>
								</td>
							</tr>
						</tbody>
					</table>
					<div>
						<label class="resp_checkbox">
							<input type="checkbox" name="autopoint" value="1"<?php if($TPL_VAR["autopoint_video"]||$TPL_VAR["autopoint_photo"]||$TPL_VAR["autopoint_review"]){?> checked<?php }?>>
							<span>????????? ?????? ??????</span>
						</label>
					</div>
					<table class="table_basic thl autopoint" style="width:700px">
						<thead>
							<tr>
								<th>??????</th>
								<th>?????????</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>?????????</th>
								<td>
									<label>
										<input type="text" name="autopoint_video" id="autopoint_video" value="<?php echo $TPL_VAR["autopoint_video"]?>" size="5"<?php if($TPL_VAR["autoemoney"]!= 1){?> disabled<?php }?>>
										<span>P</span>
									</label>
									<label>
										<span>????????????:</span>
										<select name="video_point_select">
											<option value="">???????????? ??????</option>
											<option value="year" <?php if($TPL_VAR["video_point_select"]=='year'){?>selected<?php }?>>?????? - 12???31???</option>
											<option value="direct" <?php if($TPL_VAR["video_point_select"]=='direct'){?>selected<?php }?>>?????? - ????????????</option>
										</select>
									</label>
									<span name="video_point_y" class="hide">
										<label>
											<span>????????????</span>
											<select name="video_point_year" id="video_point_year">
												<option value="0">0???</option>
												<option value="1">1???</option>
												<option value="2">2???</option>
												<option value="3">3???</option>
												<option value="4">4???</option>
												<option value="5">5???</option>
												<option value="6">6???</option>
												<option value="7">7???</option>
												<option value="8">8???</option>
												<option value="9">9???</option>
												<option value="10">10???</option>
											</select>
											<span>??? ????????????</span>
										</label>
									</span>
									<span name="video_point_d" class="hide">
										<label>
											<input type="text" name="video_point_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["video_point_direct"]?>">
											<span>??????</span>
										</label>
									</span>
								</td>
							</tr>
							<tr>
								<th>??????</th>
								<td>
									<label>
										<input type="text" name="autopoint_photo" id="autopoint_photo" value="<?php echo $TPL_VAR["autopoint_photo"]?>" size="5"<?php if($TPL_VAR["autoemoney"]!= 1){?> disabled<?php }?>>
										<span>P</span>
									</label>
									<label>
										<span>????????????:</span>
										<select name="photo_point_select">
											<option value="">???????????? ??????</option>
											<option value="year" <?php if($TPL_VAR["photo_point_select"]=='year'){?>selected<?php }?>>?????? - 12???31???</option>
											<option value="direct" <?php if($TPL_VAR["photo_point_select"]=='direct'){?>selected<?php }?>>?????? - ????????????</option>
										</select>
									</label>
									<span name="photo_point_y" class="hide">
										<label>
											<span>????????????</span>
											<select name="photo_point_year" id="photo_point_year">
												<option value="0">0???</option>
												<option value="1">1???</option>
												<option value="2">2???</option>
												<option value="3">3???</option>
												<option value="4">4???</option>
												<option value="5">5???</option>
												<option value="6">6???</option>
												<option value="7">7???</option>
												<option value="8">8???</option>
												<option value="9">9???</option>
												<option value="10">10???</option>
											</select>
											<span>??? ????????????</span>
										</label>
									</span>
									<span name="photo_point_d" class="hide">
										<label>
											<input type="text" name="photo_point_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["photo_point_direct"]?>">
											<span>??????</span>
										</label>
									</span>
								</td>
							</tr>
							<tr>
								<th>??????</th>
								<td>
									<label>
										<input type="text" name="autopoint_review" id="autopoint_review" value="<?php echo $TPL_VAR["autopoint_review"]?>" size="5"<?php if($TPL_VAR["autoemoney"]!= 1){?> disabled<?php }?>>
										<span>P</span>
									</label>
									<label>
										<span>????????????:</span>
										<select name="default_point_select">
											<option value="">???????????? ??????</option>
											<option value="year" <?php if($TPL_VAR["default_point_select"]=='year'){?>selected<?php }?>>?????? - 12???31???</option>
											<option value="direct" <?php if($TPL_VAR["default_point_select"]=='direct'){?>selected<?php }?>>?????? - ????????????</option>
										</select>
									</label>
									<span name="default_point_y" class="hide">
										<label>
											<span>????????????</span>
											<select name="default_point_year" id="default_point_year">
												<option value="0">0???</option>
												<option value="1">1???</option>
												<option value="2">2???</option>
												<option value="3">3???</option>
												<option value="4">4???</option>
												<option value="5">5???</option>
												<option value="6">6???</option>
												<option value="7">7???</option>
												<option value="8">8???</option>
												<option value="9">9???</option>
												<option value="10">10???</option>
											</select>
											<span>??? ????????????</span>
										</label>
									</span>
									<span name="default_point_d" class="hide">
										<label>
											<input type="text" name="default_point_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["default_point_direct"]?>">
											<span>??????</span>
										</label>
									</span>
								</td>
							</tr>
						</tbody>
					</table>
					<div>
						<label class="resp_checkbox">
							<input type="checkbox" name="bbslimit" value="1"<?php if($TPL_VAR["bbs_start_date"]||$TPL_VAR["bbs_end_date"]||$TPL_VAR["emoneyBbs_limit"]||$TPL_VAR["pointBbs_limit"]){?> checked<?php }?>>
							<span>?????? ?????? ?????? ??????</span>
						</label>
					</div>
					<table class="table_basic thl bbslimit" style="width:700px">
						<thead>
							<tr>
								<th></th>
								<th>?????? ??????</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>?????? ??????</th>
								<td>
									<input type="text" name="bbs_start_date" value="<?php echo $TPL_VAR["bbs_start_date"]?>" class="datepicker line" maxlength="10" size="10">
									<span>~</span>
									<input type="text" name="bbs_end_date" value="<?php echo $TPL_VAR["bbs_end_date"]?>" class="datepicker line" maxlength="10" size="10">
									<span>?????????</span>
								</td>
							</tr>
							<tr>
								<th>????????????</th>
								<td>
									<label>
										<input type="text" name="emoneyBbs_limit" value="<?php echo $TPL_VAR["emoneyBbs_limit"]?>" size="6" class="line onlynumber right">
										<span>???</span>
									</label>
									<label>
										????????????: 
										<select name="date_reserve_select">
											<option value="">???????????? ??????</option>
											<option value="year" <?php if($TPL_VAR["date_reserve_select"]=='year'){?>selected<?php }?>>?????? - 12???31???</option>
											<option value="direct" <?php if($TPL_VAR["date_reserve_select"]=='direct'){?>selected<?php }?>>?????? - ????????????</option>
										</select>
									</label>
									<span name="date_reserve_y" class="hide">
										????????????
										<select name="date_reserve_year" id="date_reserve_year">
											<option value="0">0???</option>
											<option value="1">1???</option>
											<option value="2">2???</option>
											<option value="3">3???</option>
											<option value="4">4???</option>
											<option value="5">5???</option>
											<option value="6">6???</option>
											<option value="7">7???</option>
											<option value="8">8???</option>
											<option value="9">9???</option>
											<option value="10">10???</option>
										</select>
										<span>??? ????????????</span>
									</span>
									<span name="date_reserve_d" class="hide">
										<input type="text" name="date_reserve_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["date_reserve_direct"]?>">
										<span>??????</span>
									</span>
								</td>
							</tr>
							<tr>
								<th>?????????</th>
								<td>
									<label>
										<input type="text" name="pointBbs_limit" value="<?php echo $TPL_VAR["pointBbs_limit"]?>" size="6" class="line onlynumber right">
										<span>P</span>
									</label>
									<label>
										<span>????????????: </span>
										<select name="date_point_select">
											<option value="">???????????? ??????</option>
											<option value="year" <?php if($TPL_VAR["date_point_select"]=='year'){?>selected<?php }?>>?????? - 12???31???</option>
											<option value="direct" <?php if($TPL_VAR["date_point_select"]=='direct'){?>selected<?php }?>>?????? - ????????????</option>
										</select>
									</label>
									<span name="date_point_y" class="hide">
										<span>????????????</span>
										<select name="date_point_year" id="date_point_year">
											<option value="0">0???</option>
											<option value="1">1???</option>
											<option value="2">2???</option>
											<option value="3">3???</option>
											<option value="4">4???</option>
											<option value="5">5???</option>
											<option value="6">6???</option>
											<option value="7">7???</option>
											<option value="8">8???</option>
											<option value="9">9???</option>
											<option value="10">10???</option>
										</select>
										<span>??? ????????????</span>
									</span>
									<span name="date_point_d" class="hide">
										<input type="text" name="date_point_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["date_point_direct"]?>">
										<span>??????</span>
									</span>
								</td>
							</tr>
						</tbody>
					</table>
<?php }?>
				</td>
			</tr>
			<tr>
				<th>???????????? ?????? ?????? <span class="tooltip_btn" onclick="showTooltip(this, '/admin/tooltip/board', '#tip_manual_mileage', 'sizeS')"></span></th>
				<td>
					<label>
						<span>?????? ????????????</span>
						<input type="text" name="reserve_goods_review" size="5" class="line onlynumber right" value="<?php echo $TPL_VAR["reserve_goods_review"]?>">
						<span>???</span>
					</label>
				</td>
			</tr>
		</table>
		<div class="resp_message">- ????????? ?????????(????????????,?????????)??? ????????? ?????? ?????? ?????? ??? ?????? ???????????????. ???, ????????? ???????????? ????????? ?????? ???????????? ?????? ?????? ????????? ???????????????(???????????? ??????).</div>
<?php }?>
<?php }?>

<?php if($TPL_VAR["id"]!='faq'&&$TPL_VAR["id"]!='store_gallery'&&$TPL_VAR["id"]!='gallery_bbs'){?>
	<div class="item-title">????????? ??????</div>
	<table class="table_basic thl">
		<tbody>
<?php if($TPL_VAR["id"]!='gs_seller_notice'&&$TPL_VAR["id"]!='gs_seller_qna'){?>
			<tr>
				<th rowspan="<?php if($TPL_VAR["id"]!='notice'){?>4<?php }else{?>3<?php }?>">?????????</th>
				<th>?????? ??????</th>
				<td>
					<select name="write_show">
						<option value="ID" <?php if($TPL_VAR["write_show"]=='ID'||!$TPL_VAR["write_show"]){?> selected<?php }?>>????????? (??????)</option>
						<option value="ID-NONE" <?php if($TPL_VAR["write_show"]=='ID-NONE'){?> selected<?php }?>>?????????</option>
						<option value="NAME" <?php if($TPL_VAR["write_show"]=='NAME'&&$TPL_VAR["write_show"]){?> selected<?php }?>>?????? (??????)</option>
						<option value="NAME-NONE" <?php if($TPL_VAR["write_show"]=='NAME-NONE'&&$TPL_VAR["write_show"]){?> selected<?php }?>>??????</option>
						<option value="NIC" <?php if($TPL_VAR["write_show"]=='NIC'&&$TPL_VAR["write_show"]){?> selected<?php }?>>????????? (??????)</option>
						<option value="NIC-NONE" <?php if($TPL_VAR["write_show"]=='NIC-NONE'&&$TPL_VAR["write_show"]){?> selected<?php }?>>?????????</option>
						<option value="ID-NAME" <?php if($TPL_VAR["write_show"]=='ID-NAME'&&$TPL_VAR["write_show"]){?> selected<?php }?>>?????? (?????????, ??????)</option>
						<option value="ID-NAME-NONE" <?php if($TPL_VAR["write_show"]=='ID-NAME-NONE'&&$TPL_VAR["write_show"]){?> selected<?php }?>>?????? (?????????)</option>
						<option value="ID-NIC" <?php if($TPL_VAR["write_show"]=='ID-NIC'&&$TPL_VAR["write_show"]){?> selected<?php }?>>????????? (?????????, ??????)</option>
						<option value="ID-NIC-NONE" <?php if($TPL_VAR["write_show"]=='ID-NIC-NONE'&&$TPL_VAR["write_show"]){?> selected<?php }?>>?????????(?????????)</option>
					</select>
					<div class="resp_message">- ???????????? ?????? ???????????? ???????????? '??????'??????, ????????? '?????????'?????? ???????????????.</div>
				</td>
			</tr>
			<tr>
				<th>?????? ?????? ??????</th>
				<td>
					<span class="resp_radio">
						<label><input type="radio" name="show_name_type" id="show_name_hid" value="HID" <?php if($TPL_VAR["show_name_type"]=='HID'||!$TPL_VAR["show_name_type"]){?> checked="checked" <?php }?>> ???*???</label>
						<label><input type="radio" name="show_name_type" id="show_name_all" value="ALL" <?php if($TPL_VAR["show_name_type"]=='ALL'&&$TPL_VAR["show_name_type"]){?> checked="checked" <?php }?>> ?????????</label>
					</span>
				</td>
			</tr>
			<tr>
				<th>?????? ??????</th>
				<td>
					<span class="resp_radio">
						<label><input type="radio" name="show_grade_type" id="show_grade_txt" value="TXT" <?php if($TPL_VAR["show_grade_type"]=='TXT'&&$TPL_VAR["show_grade_type"]){?> checked="checked" <?php }?>> ????????? ?????????</label>
						<label><input type="radio" name="show_grade_type" id="show_name_img" value="IMG" <?php if($TPL_VAR["show_grade_type"]=='IMG'||!$TPL_VAR["show_grade_type"]){?> checked="checked" <?php }?>> ????????? ?????????</label>
					</span>
				</td>
			</tr>
<?php if($TPL_VAR["id"]!='notice'){?>
			<tr>
				<th>?????????/?????????</th>
				<td>
					<span class="resp_checkbox">
						<label>
							<input type="checkbox" name="writer_date_regit" value="regit"<?php if($TPL_VAR["writer_date"]=='all'||$TPL_VAR["writer_date"]=='regit'){?> checked<?php }?>>
							<span>??????????????? ??????</span>
						</label>
						<label>
							<input type="checkbox" name="writer_date_login" value="login"<?php if($TPL_VAR["writer_date"]=='all'||$TPL_VAR["writer_date"]=='login'){?> checked<?php }?>>
							<span>??????????????? ??????</span>
						</label>
					</span>
				</td>
			</tr>
<?php }?>
<?php }?>
			<tr>
				<th rowspan="<?php if($TPL_VAR["id"]!='bulkorder'&&$TPL_VAR["id"]!='gs_seller_notice'&&$TPL_VAR["id"]!='gs_seller_qna'&&$TPL_VAR["id"]!='store_review'&&$TPL_VAR["id"]!='gallery_bbs'&&$TPL_VAR["id"]!='product_bbs'){?>3<?php }else{?>2<?php }?>">?????????</th>
				<th>?????? ??????</th>
				<td>
					<span class="resp_radio">
						<label>
							<input type="radio" name="write_admin_type" id="write_admintxt" value="TXT" <?php if($TPL_VAR["write_admin_type"]=='TXT'||!$TPL_VAR["write_admin_type"]){?> checked="checked" <?php }?>>
							<span>?????????</span>
						</label>
						<label>
							<input type="radio" name="write_admin_type" id="write_adminimg" value="IMG" <?php if($TPL_VAR["write_admin_type"]=='IMG'&&$TPL_VAR["write_admin_type"]){?> checked="checked" <?php }?>>
							<span>?????????</span>
						</label>
					</span>
				</td>
			</tr>
			<tr>
				<th>?????? ??????</th>
				<td>
					<div class="resp_limit_text limitTextEvent" id="write_admin">
						<input type="text" name="write_admin" size="20" maxlength="15" value="<?php echo $TPL_VAR["write_admin"]?>">
					</div>
					<div id="image_admin">
						<button type="button" id="iconAdminBtn" class="resp_btn v2">?????? ??????</button>
						<img src="<?php echo $TPL_VAR["icon_admin_img"]?>" id="icon_admin_img" style="vertical-align:middle;">
						<div class="resp_message">- ?????? ??????: gif, jpg, jpeg, png</div>
					</div>
				</td>
			</tr>
<?php if($TPL_VAR["id"]!='bulkorder'&&$TPL_VAR["id"]!='gs_seller_notice'&&$TPL_VAR["id"]!='gs_seller_qna'&&$TPL_VAR["id"]!='store_review'&&$TPL_VAR["id"]!='gallery_bbs'&&$TPL_VAR["id"]!='product_bbs'){?>
			<tr>
				<th>?????????</th>
				<td>
					<label class="resp_checkbox">
						<input type="checkbox" name="admin_regist_view" value="Y"<?php if($TPL_VAR["admin_regist_view"]=='Y'){?> checked<?php }?>>
						<span>????????? ??????</span>
					</label> 
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>
<?php }?>

	<div class="item-title">?????? <span class="tooltip_btn" onclick="showTooltip(this, '/admin/tooltip/board', '#tip_auth', 'sizeS')"></span></div>
	<table class="table_basic thl">
		<tbody>
			<tr>
				<th>????????? ??????</th>
				<td>
<?php if($TPL_VAR["useform"]["display"]["auth_read"]["title"]&&$TPL_VAR["useform"]["display"]["auth_read"]["input"]){?>
						 <?php echo $TPL_VAR["useform"]["display"]["auth_read"]["title"]?>

						 <?php echo $TPL_VAR["useform"]["display"]["auth_read"]["input"]?>

<?php }else{?>
						<?php echo $TPL_VAR["auth_read_form"]?>

<?php }?>
				</td>
			</tr>
			<tr>
				<th>????????? ??????</th>
				<td >
<?php if($TPL_VAR["useform"]["display"]["auth_write"]["title"]&&$TPL_VAR["useform"]["display"]["auth_write"]){?>
						<?php echo $TPL_VAR["useform"]["display"]["auth_write"]["title"]?>

						<?php echo $TPL_VAR["useform"]["display"]["auth_write"]["input"]?>

<?php }else{?>
						<?php echo $TPL_VAR["auth_write_form"]?>

<?php }?>
				</td>
			</tr>
<?php if(($TPL_VAR["skin_type"]=='goods'&&$TPL_VAR["id"]=='goods_review')||$TPL_VAR["id"]=='notice'||$TPL_VAR["id"]=='store_reservation'||$TPL_VAR["id"]=='store_gallery'||$TPL_VAR["id"]=='faq'){?>
<?php }elseif($TPL_VAR["id"]=='store_review'||$TPL_VAR["type"]=='A'){?>
			<tr>
				<th>?????? ??????</th>
<?php if($TPL_VAR["type"]=='A'){?>
				<td >
					<?php echo $TPL_VAR["auth_reply_form"]?>

				</td>
<?php }else{?>
				<td >
					<?php echo $TPL_VAR["auth_write_reply_form"]?>

				</td>
<?php }?>
			</tr>
<?php }?>
<?php if($TPL_VAR["id"]=='faq'||$TPL_VAR["id"]=='store_review'||$TPL_VAR["id"]=='store_reservation'||$TPL_VAR["id"]=='store_gallery'){?>
<?php }elseif(!(($TPL_VAR["skin_type"]=='goods'&&$TPL_VAR["id"]=='goods_review')||$TPL_VAR["id"]=='notice'||$TPL_VAR["type"]=='A')){?>
<?php }else{?>
			<tr>
				<th>?????? ??????</th>
<?php if($TPL_VAR["type"]=='A'){?>
				<td >
					<?php echo $TPL_VAR["auth_cmt_form"]?>

				</td>
<?php }else{?>
				<td >
					<?php echo $TPL_VAR["auth_write_cmt_form"]?>

				</td>
<?php }?>
			</tr>
<?php }?>
		</tbody>
	</table>

<?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'){?>
	<div class="item-title">
		????????? ??????
		<div class="fr">
			<button type="button" id="allClick" gb="none" class="resp_btn size_S v2">?????? ??????</button>
		</div>
	</div>
	<table class="table_basic thl tdc">
		<colgroup>
			<col>
			<col>
			<col>
			<col width="10%">
<?php if($TPL_VAR["id"]!=='notice'&&$TPL_VAR["id"]!=='faq'&&$TPL_VAR["id"]!=='mbqna'&&$TPL_VAR["id"]!=='store_review'&&$TPL_VAR["id"]!=='gs_seller_notice'&&$TPL_VAR["id"]!=='gs_seller_qna'){?><col width="10%"><?php }?>
			<col width="10%">
		</colgroup>
		<thead>
			<tr>
				<th></th>
				<th>????????????</th>
				<th>????????? ID</th>
				<th>??????</th>
<?php if($TPL_VAR["id"]!=='notice'&&$TPL_VAR["id"]!=='faq'&&$TPL_VAR["id"]!=='mbqna'&&$TPL_VAR["id"]!=='store_review'&&$TPL_VAR["id"]!=='gs_seller_notice'&&$TPL_VAR["id"]!=='gs_seller_qna'){?><th>?????????</th><?php }?>
				<th>????????? ??????</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_managerlist_1){foreach($TPL_VAR["managerlist"] as $TPL_V1){?>
			<tr>
				<th nowrap><?php if($TPL_V1["manager_yn"]=='Y'){?>?????? ?????????<?php }else{?>????????????<?php }?></th> 
				<td class="left"><?php echo $TPL_V1["mname"]?></td>
				<td class="left">
					<a href="../setting/manager_reg?manager_seq=<?php echo $TPL_V1["manager_seq"]?>" target="_blank"><span class="black underline hand managerinfo"><?php echo $TPL_V1["manager_id"]?></span></a>
					<input type="hidden" name="managerauth[<?php echo $TPL_V1["manager_seq"]?>]" value="<?php echo $TPL_V1["manager_seq"]?>">
				</td>
				<td>
					<label class="resp_checkbox"><input type="checkbox" name="board_view[<?php echo $TPL_V1["manager_seq"]?>]" value="1" <?php if($TPL_V1["board_view"]){?> checked="checked" <?php }?> class="authboard board_view"></label>
				</td><?php if($TPL_VAR["id"]!=='notice'&&$TPL_VAR["id"]!=='faq'&&$TPL_VAR["id"]!=='mbqna'&&$TPL_VAR["id"]!=='store_review'&&$TPL_VAR["id"]!=='gs_seller_notice'&&$TPL_VAR["id"]!=='gs_seller_qna'){?>
				<td>
					<label class="resp_checkbox"><input type="checkbox" name="board_view_pw[<?php echo $TPL_V1["manager_seq"]?>]" value="2" <?php if($TPL_V1["board_view_pw"]){?> checked="checked" <?php }elseif(!$TPL_V1["board_view"]){?> disabled="disabled" <?php }?> class="authboard board_view_pw"></label>
				</td><?php }?>
				<td>
					<label class="resp_checkbox"><input type="checkbox" name="board_act[<?php echo $TPL_V1["manager_seq"]?>]" value="1" <?php if($TPL_V1["board_act"]){?> checked="checked" <?php }elseif(!$TPL_V1["board_view"]){?> disabled="disabled" <?php }?> class="authboard board_act"></label>
				</td>
			</tr>
<?php }}?>
		</tbody>
	</table>
<?php }?>

<?php if($TPL_VAR["id"]!=='gs_seller_qna'&&$TPL_VAR["id"]!=='gs_seller_notice'){?>
	<div class="item-title">????????? ????????? ??????</div>
	<table class="table_basic thl">
		<tbody>
			<tr>
				<th>???????????? ????????? ???</th>
				<td> 
					<div class="defaultlay <?php if(!$TPL_VAR["id"]||!strstr($TPL_VAR["skin"],'gallery')){?>show<?php }else{?> hide <?php }?>"><input type="text" name="pagenum" id="pagenum" size="3" value="<?php echo $TPL_VAR["pagenum"]?>" class="line onlynumber"> ???</div>
					<div class="gallerylay <?php if($TPL_VAR["id"]&&strstr($TPL_VAR["skin"],'gallery')){?>show<?php }else{?> hide <?php }?>">
<?php if($TPL_VAR["operation_type"]=='light'){?>
						<input type="text" name="gallerycell[]" size="3" value="<?php if(!$TPL_VAR["id"]){?>20<?php }else{?><?php echo $TPL_VAR["gallerycell0"]?><?php }?>" class="line onlynumber gallerycell"> ???
<?php }else{?>
						<input type="text" name="gallerycell[]" id="gallerycell0" size="3" value="<?php echo $TPL_VAR["gallerycell0"]?>" class="line onlynumber gallerycell"> X <input type="text" name="gallerycell[]" id="gallerycell1" size="3" value="<?php echo $TPL_VAR["gallerycell1"]?>" class="line onlynumber gallerycell"> = <span id="gallerytotalnum"><?php echo number_format($TPL_VAR["gallerycell0"]*$TPL_VAR["gallerycell1"])?></span> ???
<?php }?>
					</div>
				</td>
			</tr>
			<tr>
				<th>????????? ?????????</th>
				<td>
					<input type="text" name="gallery_list_w" id="gallery_list_w" size="3" value="<?php if($TPL_VAR["gallery_list_w"]){?><?php echo $TPL_VAR["gallery_list_w"]?><?php }else{?>399<?php }?>" class="line onlynumber gallery_list_w"> X <input type="text" name="gallery_list_h" id="gallery_list_h" size="3" value="<?php if($TPL_VAR["gallery_list_h"]){?><?php echo $TPL_VAR["gallery_list_h"]?><?php }else{?>266<?php }?>" class="line onlynumber gallerycell"> Pixel
				</td>
			</tr>
<?php if($TPL_VAR["useform"]["display"]["list_show"]){?>
			<tr>
				<th>????????????</th>
				<td>
					<span class="resp_checkbox">
						<?php echo $TPL_VAR["listshowform"]?>

					</span>
				</td>
			</tr>
<?php }?>
<?php if($TPL_VAR["useform"]["display"]["newhot"]){?>
			<tr>
				<th>?????????</th>
				<td>
					<table class="table_basic tdc" style="width:400px">
						<thead>
							<tr>
								<th>??????</th>
								<th>NEW ?????????</th>
								<th>HOT ?????????</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>?????? ??????</th>
								<td>
									<label>
										<span>??? ?????? ???</span>
										<input type="text" name="icon_new_day" id="icon_new_day" size="3" value="<?php echo $TPL_VAR["icon_new_day"]?>">
										<span>??? ???</span>
									</label>
								</td>
								<td>
									<label>
										<span>?????? ???</span>
										<input type="text" name="icon_hot_visit" id="icon_hot_visit" size="3" value="<?php echo $TPL_VAR["icon_hot_visit"]?>">
										<span>??? ??????</span>
									</label>
								</td>
							</tr>
							<tr>
								<th>?????????</th>
								<td>
									<div class="icon_layer" id="icon_new_img">
										<img src="<?php echo $TPL_VAR["icon_new_img"]?>" id="icon_new_img">
									</div>
									<button type="button" id="iconNewBtn" class="resp_btn v2">?????? ??????</button>
								</td>
								<td>
									<div class="icon_layer" id="icon_hot_img">
										<img src="<?php echo $TPL_VAR["icon_hot_img"]?>" id="icon_hot_img">
									</div>
									<button type="button" id="iconHotBtn" class="resp_btn v2">?????? ??????</button>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="resp_message">- ?????? ??????: gif, jpg, jpeg, png</div>
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>
<?php }?>

<?php if($TPL_VAR["skin_type"]=='goods'){?>
	<div class="item-title">?????? ????????? ????????? ?????? <span class="tooltip_btn" onclick="showTooltip(this, '/admin/tooltip/board', '#tip_goods_list', 'sizeS')"></span></div>
	<table class="table_basic thl">
		<tbody>
			<tr>
				<th>???????????? ?????? ???</th>
				<td >
					<input type="text" name="goods_num" id="goods_num" size="3" value="<?php echo $TPL_VAR["goods_num"]?>" class="line onlynumber">???
				</td>
			</tr>
<?php if($TPL_VAR["id"]=='goods_review'||$TPL_VAR["id"]=='goods_qna'){?>
			<tr>
				<th>????????????</th>
				<td >
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
					<input type="hidden" name="viewtype" value="<?php echo $TPL_VAR["viewtype"]?>">
					<span class="resp_radio">
						<label>
							<input type="radio"<?php if($TPL_VAR["viewtype"]==''||$TPL_VAR["viewtype"]=='page'){?> checked<?php }?> disabled>
							<span>????????? ??????</span>
						</label>
						<label>
							<input type="radio"<?php if($TPL_VAR["viewtype"]=='layer'){?> checked<?php }?> disabled>
							<span>????????? ?????????</span>
						</label>
					</span>
<?php }else{?>
					<span class="resp_radio">
						<label>
							<input type="radio" name="viewtype" value="page" checked>
							<span>????????? ??????</span>
						</label>
						<label>
							<input type="radio" name="viewtype" value="layer"<?php if($TPL_VAR["viewtype"]=='layer'){?> checked<?php }?>>
							<span>????????? ?????????</span>
						</label>
					</span>
<?php }?>
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>
<?php }?>

<?php if($TPL_VAR["sms_rest_use"]||$TPL_VAR["id"]=='bulkorder'){?>
		<div class="item-title">SMS ??????</div>
		<table class="table_basic thl">
			<tbody>
				<tr>
					<th>SMS ?????? ??????</th>
					<td>
						<table class="table_basic" style="width:auto">
							<thead>
								<tr>
<?php if($TPL_sms_loop_1){foreach($TPL_VAR["sms_loop"] as $TPL_V1){?><?php if($TPL_V1["text"]){?>
									<th class="left">
										<span><?php echo $TPL_V1["text"]?></span>
										<span class="fr">
<?php if($TPL_V1["kkotalk_use"]=='Y'){?><img src="/admin/skin/default/images/design/ico_kakao_on.gif" alt="????????? ON">
<?php }elseif($TPL_V1["kkotalk_use"]=='N'){?><img src="/admin/skin/default/images/design/ico_kakao_off.gif" alt="????????? OFF">
<?php }else{?><img src="/admin/skin/default/images/design/ico_kakao_x.gif" alt="????????? X">
<?php }?>
										</span>
									</th>
<?php }?><?php }}?>
								</tr>
							</thead>
							<tbody>
								<tr>
<?php if($TPL_sms_loop_1){foreach($TPL_VAR["sms_loop"] as $TPL_V1){?><?php if($TPL_V1["text"]){?>
									<td valign="top">
<?php if($TPL_V1["user_disabled"]!='disabled'){?>
										<div class="sms-define-form">
											<div class="sdf-body-wrap">
												<div class="sdf-body">
													<textarea name="<?php echo $TPL_V1["name"]?>_user" class="sms_contents"><?php echo $TPL_V1["user"]?></textarea>
													<div class="sdf-body-foot clearbox">
														<div class="fr"><b class="sms_byte">0</b>byte</div>
													</div>
												</div>
											</div>
										</div>
<?php }?>
				
<?php if($TPL_V1["disabled"]!='disabled'){?>
										<div class="sms-define-form">
											<div class="sdf-body-wrap">
												<div class="sdf-body">
													<textarea name="<?php echo $TPL_V1["name"]?>_admin" class="sms_contents"><?php echo $TPL_V1["admin"]?></textarea>
													<div class="sdf-body-foot clearbox">
														<div class="fr"><b class="sms_byte">0</b>byte</div>
													</div>
												</div>
											</div>
										</div>
<?php }?>
				
<?php if($TPL_V1["user_disabled"]!='disabled'){?>
										<div>
											<label class="resp_checkbox">
												<input type="checkbox" name="<?php echo $TPL_V1["name"]?>_user_yn" value="Y"<?php if($TPL_V1["user_chk"]=='Y'){?> checked<?php }?> <?php echo $TPL_V1["user_disabled"]?>>
												<span>??????</span>
											</label>
										</div>
<?php }?>
<?php if($TPL_V1["disabled"]!='disabled'){?>
<?php if(is_array($TPL_R2=$TPL_V1["arr"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
										<div>
											<label class="resp_checkbox">
												<input type="checkbox" name="<?php echo $TPL_V1["name"]?>_admins_yn_<?php echo $TPL_I2?>" value="Y"<?php if($TPL_V1["admins_chk"][$TPL_I2]=='Y'){?> checked<?php }?> <?php echo $TPL_V1["disabled"]?>>
												<span>?????????(<?php echo $TPL_I2+ 1?>)</span>
											</label>
										</div>
<?php }}?>
<?php if($TPL_V1["to_provider_sms"]=='Y'){?>
										<div>
											<label class="resp_checkbox">
												<input type="checkbox" name="<?php echo $TPL_V1["name"]?>_provider_yn" value="Y"<?php if($TPL_V1["sms_provider_chk"]=='Y'){?> checked<?php }?> <?php echo $TPL_V1["disabled"]?>>
												<span>???????????????</span>
											</label>
										</div>
<?php }?>
<?php }?>
									</td>
<?php }?><?php }}?>
								</tr>
				
								<tr>
<?php if($TPL_sms_loop_1){foreach($TPL_VAR["sms_loop"] as $TPL_V1){?><?php if($TPL_V1["text"]){?>
									<td class="right">
										<input type="button" value="?????? ??????" name="<?php echo $TPL_V1["text"]?>" title="<?php echo $TPL_V1["text"]?>" class="resp_btn info_code">
									</td>
<?php }?><?php }}?>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
<?php }?>
</div>
<!-- ???????????? ?????? : ???-->

</form>

<?php if($TPL_VAR["id"]=='bulkorder'||$TPL_VAR["id"]=='goods_review'){?>
<form id="joinDiv" class="layer_pop hide">
	<div class="content">
		<table width="100%" id="labelTable">
			<tr>
				<th class="left">????????????</th>
				<td>
					<select name="windowLabelType" id="formListSelect">
						<option value="text">???????????????</option>
						<option value="radio">????????? ??? ???1</option>
						<option value="textarea">???????????????</option>
						<option value="checkbox">????????????</option>
						<option value="select">???????????????</option>
					</select>

					<a id="sampleViewBtn" class="ml5 link_blue_01">????????????</a>					
				</td>
			</tr>
			<tr>
				<th class="left">?????????</th>
				<td><input type="text" name="windowLabelName" size="30"></td>
			</tr>
			<tr>
				<th class="left">????????????</th>
				<td><input type="text" name="windowLabelExp" size="30"></td>
			</tr>
			<tr id="labelTr">
				<th id="labelTh" class="left">?????????</th>
				<td id="labelTd"></td>
			</tr>
		</table>
	</div>
	<div class="footer">
		<input type="button" class="resp_btn active size_XL" value="??????" id="labelWriteBtn">
		<input type="reset" class="resp_btn v3 size_XL" value="??????" onclick="$(this).closest('.ui-dialog').find('.ui-dialog-content').dialog('close')">
	</div>
	<!--//????????? -->
	<input type="hidden" name="windowLabelComment" value="N">
	<input type="hidden" name="windowLabelSeq" value="">
	<!-- <input type="hidden" name="windowLabelType" value="<?php if($TPL_VAR["operation_type"]=='light'&&$TPL_VAR["id"]=='goods_review'){?>radio<?php }?>"> -->
	<input type="hidden" name="Label_cnt" value="<?php echo $TPL_VAR["sub_cnt"]["cnt"]?>">
	<input type="hidden" name="Label_maxid" value="<?php echo $TPL_VAR["sub_cnt"]["maxid"]?>">
	<input type="hidden" name="windowLabelId" value="">
	<input type="hidden" name="windowLabelvalue" value="">
	<input type="hidden" name="windowLabelIcon" value="">
	<input type="hidden" name="windowLabelUseCheck" value="" size="30" class="null">
	<input type="hidden" name="windowLabelRequireCheck" value="" size="30" class="null">
</form>
<?php $this->print_("surveyForm",$TPL_SCP,1);?>

<script>$('#legacySurveyForm').hide()</script>
<?php }?>

<div id="BoardIconPopup" class="hide">
	<form name="Iconregist" id="Iconregist" method="post" action="" enctype="multipart/form-data" target="actionFrame">
	<input type="hidden" name="mode" id="" value="boardmanager_icon">
	<input type="hidden" name="icontype" id="icontype" value="">
	<input type="hidden" name="seq" value="<?php echo $TPL_VAR["seq"]?>">
	<input type="hidden" name="boardid" value="<?php echo $TPL_VAR["id"]?>">
	<ul>
		<li style="float:left;width:250px;height:30px;text-align:center"><input type="file" name="board_icon" id="board_icon" onChange="iconFileUpload();"></li>
	</ul>
	</form>
</div>

<?php if($TPL_VAR["id"]=='goods_review'){?>
<!-- ????????? ?????? -->
<div id="goodsReviewIconPopup" class="hide">
	<form enctype="multipart/form-data" method="post" action="../board_goods_process/icon" target="actionFrame">
	<input type="hidden" name="iconReviewIndex" value="0">
	<ul>
<?php if(is_array($TPL_R1=code_load('goodsReviewIcon'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<li style="float:left;width:50px;height:30px;text-align:center">
			<input type="hidden" name="goodsReviewIconCode[]" value="<?php echo $TPL_V1["codecd"]?>">
			<img src="<?php echo $TPL_VAR["goodsreviewicon"]?><?php echo $TPL_V1["codecd"]?>" filename="<?php echo $TPL_V1["codecd"]?>" border="0" title="<?php echo $TPL_V1["value"]?>" class="hand hover-select icon">
		</li>
<?php }}?>
	</ul>
	<div class="clearbox"></div>
	 <div>
		<input type="file" name="goodsReviewIconImg"> <button type="submit" class="resp_btn">??????</button>
	</div>
	</form>
</div>
<?php }?>

<?php if($TPL_VAR["service_limit"]&&!$TPL_VAR["id"]){?>
<div id="BoadService" class="hide">
<div>
		<table width="100%">
			<tr>
				<td class="left">
					????????? Plus+ : ?????? 5??? (????????? ?????? ??? 1?????? 2,200???, ?????? 1??? ????????? ?????? ?????? ?????? ?????? ??????)<br>
					???????????????+ ?????? ?????????+??? ??????????????? ????????? ???????????? ????????? ?????? ???????????????.
				</td>
			</tr>
			<tr>
				<td class="center">
					<br><br>
					<span class="btn large gray"><input type="button" onclick="serviceBoardAdd();" value="?????? ?????? >"></span>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="btn large gray"><input type="button" onclick="serviceUpgrade();" value="??????????????? >"></span>
				</td>
			</tr>
		</table>
	</div>
	<br style="line-height:20px">
</div>
<?php }?>

<div id="infoPopup" class="hide">
	<div class="content">
		<div><b id="s_title"></b> ?????? ????????? ?????????????????????.</div>
		<table class="table_basic thl">
			<thead>
				<tr>
					<th>????????????</th>
					<th>??????</th>
				</tr>
			</thead>
			<tbody>
				<tr class="s_info">
					<td class="center">&#123;shopName&#125;</td>
					<td >????????????(?????? > ????????????)</td>
				</tr>
				<tr class="s_info">
					<td class="center">&#123;boardName&#125;</td>
					<td >????????????</td>
				</tr>
				<tr class="s_info">
					<td class="center">&#123;userid&#125;</td>
					<td >???????????????</td>
				</tr>
				<tr class="s_info">
					<td class="center">&#123;userName&#125;</td>
					<td >????????????</td>
				</tr>
				<tr class="s_info" >
					<td class="its-td-align center">&#123;shopDomain&#125;</td>
					<td class="its-td">????????? ?????????(?????? > ????????????)</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="footer">
		<button class="resp_btn v3 size_XL" type="reset" onclick="$(this).closest('.ui-dialog').find('.ui-dialog-content').dialog('close')">??????</button>
	</div>
</div>
<script src="/app/javascript/plugin/validate/jquery.validate.js"></script>
<script>
	(function(){
		var form = document.forms['form_manager_write'];
		if(!form)console.error('no form provided');

		var content_default_use = '1';
		var autoemoney_use		= true;
<?php if(!($TPL_VAR["content_default"]||$TPL_VAR["content_default_mobile"])){?>content_default_use = '0';<?php }?>
<?php if(!$TPL_VAR["autoemoney"]){?>autoemoney_use = false;<?php }?>

		$(form.elements.content_default_use).on('change', function(e,selectVal) {
			var use = $(this).val() === '1';
			if(typeof selectVal != 'undefined') {
				use = selectVal;
			}
			$('#content_default, #content_default_mobile').closest('tr')[use == '1'?'show':'hide']();
			if(use != '1') {
				$('#content_default, #content_default_mobile').val('');
			}
		}).trigger('change',content_default_use);
		$(form.elements.content_default_mobile_use).on('change', function() {
			var use = form.elements.content_default_mobile_use.value === '1';
			$('#content_default_mobile')[use?'show':'hide']();
			if(!use) {
				$('#content_default_mobile').val('');
			}
		}).trigger('change');
		$(form.elements.video_use).on('change', function() {
			var use = form.elements.video_use.value === 'Y';
			$(form).find('[name="video_type"],[name="video_screen"],[name="video_size[]"],[name="video_size_mobile[]"]').closest('tr')[use?'show':'hide']();
		}).trigger('change');
		$(form.elements.goods_review_type).on('change', function() {
			var use = form.elements.goods_review_type.value === 'IMAGE';
			$(form).find('#icon_review_img').closest('tr')[use?'show':'hide']();
		}).trigger('change');
		$(form.elements.autoemoney).on('change', function(e,selectVal) {
			var use = $(this).val() === '1';
			if(typeof selectVal != 'undefined') {
				use = selectVal;
			}
			$(form).find('[name="autoemoneytype"],[name="autopoint"],[name="reserve_goods_review"]').closest('tr')[use?'show':'hide']();
			if(use) {
				$(form).find('[name="autoemoneytype"][value="1"]').prop('checked', true);
			}
			else {
				$(form).find('[name="autoemoneytype"],[name="autopoint"],[name="reserve_goods_review"]').prop('checked', false);
			}
			if(!Firstmall.Config.Environment.serviceLimit.H_FR && use) {
				$(".autoemoney").find("input,select").removeAttr('disabled');
			}
			else {
				$(".autoemoney").find("input,select").attr('disabled',true);
			}
		}).trigger('change',autoemoney_use);

		$(Array.prototype.concat.apply([],[
			Array.prototype.slice.call(form.elements.auth_cmt_use||[]),
			Array.prototype.slice.call(form.elements.auth_cmt_recommend_use||[]),
			Array.prototype.slice.call(form.elements.cmt_recommend_type||[]),
			Array.prototype.slice.call(form.elements.auth_recommend_use||[]),
			Array.prototype.slice.call(form.elements.recommend_type||[]),
		])).on('change', function() {
			var commentUse 				= $(form.elements.auth_cmt_use||{}).eq(0).attr("checked") === 'checked',
				commentRecommendUse 	= $(form.elements.auth_cmt_recommend_use||{}).eq(0).attr("checked") === 'checked',
				commentRecommendType	= (form.elements.cmt_recommend_type||{}).value,
				articleUse 				= true,
				articleRecommendUse 	= $(form.elements.auth_recommend_use||{}).eq(0).attr("checked")  === 'checked',
				articleRecommendType 	= (form.elements.recommend_type||{}).value
			;
			var commentRowspan 			= 1,
				articleRowspan 			= 0
			;

			$(form.elements.auth_cmt_use).closest('tr').find('th[rowspan]').attr('rowspan', commentUse?commentRecommendUse?3:2:1);
			$(form.elements.auth_cmt_recommend_use).closest('tr')[['hide','show'][~~commentUse]]();
			$(form.elements.cmt_recommend_type).closest('tr')[['hide','show'][~~(commentUse&&commentRecommendUse)]]();

			$(form.elements.auth_recommend_use).closest('tr').find('th[rowspan]').attr('rowspan', articleUse?articleRecommendUse?2:1:1);
			$(form.elements.auth_recommend_use).closest('tr')[['hide','show'][~~articleUse]]();
			$(form.elements.recommend_type).closest('tr')[['hide','show'][~~(articleUse&&articleRecommendUse)]]();
		}).trigger('change');
	})();
	$(document).ready(function() {
<?php if($TPL_VAR["service_limit"]&&!$TPL_VAR["id"]){?>
			openDialog("????????? ?????? ?????? ??????<span class='desc'></span>", "BoadService", {"width":600,"height":200});
<?php }?>

<?php if(!$TPL_VAR["goodsreview_sub"]){?>
			$("input[name='list_show[]'][value='[reviewinfo]']").attr("checked",false);
			$("input[name='list_show[]'][value='[reviewinfo]']").attr("disabled",true);
<?php }?>


		var boardid = $('#board_id');
		var boardname = $('#board_name');
<?php if($TPL_VAR["seq"]){?>
			
			//?????? ??????????????? ?????? ???????????? ??????
			
			auth_cmt_use_ck('<?php echo $TPL_VAR["cmt_recommend_type"]?>');

			//????????? ????????????
			
			auth_recommend_use_ck('<?php echo $TPL_VAR["recommend_type"]?>');

			//???????????? ????????????
			//auth_cmt_recommend_use_ck();

			$('#form_manager_write').validate({
				ignore : ':not([name]),:hidden',
				onkeyup: false,
				rules: {
					board_name: { required:true}
				},
				messages: {
					board_name: { required:'??????????????? ????????? ?????????.'}
				},
				showErrors: function(_, eL) {
					if(window.submitted) {
						alert(eL[0].message);
						window.submitted = false;
					}
				},
				invalidHandler: function(form, validator) {
					window.submitted = true;
				},
				submitHandler: function(f) {
					if(readyEditorForm(f)){
						if ($(f).find('[name="board_name"]').val().length < 3) { // ???????????? ??????
							alert('3???????????? ??????????????? ????????? ?????????.');
							$(f).find('[name="board_name"]').focus();
							return false;
						}

						if (containsChars($(f).find('[name="board_name"]'),"\"")) {
							alert('?????????????????? ????????????(" ")??? ????????? ??? ????????????.\n????????????(\") ??? ????????? ?????????????????? ????????? ?????????.');
							$(f).find('[name="board_name"]').focus();
							return false;
						}

<?php if(serviceLimit('H_FR')&&$TPL_VAR["id"]=='bulkorder'){?>
						<?php echo serviceLimit('A1')?>

<?php }else{?>
						f.submit();
<?php }?>
					}
				}
			});
<?php }else{?>
			//????????? ???????????? 
			auth_recommend_use_ck(); 

			//?????? ??????????????? ?????? ???????????? ?????? 
			auth_cmt_use_ck(); 


			//???????????? ???????????? 
			//auth_cmt_recommend_use_ck(); 

			$('#form_manager_write').validate({
				ignore : ':not([name]),:hidden',
				onkeyup: false,
				rules: {
					board_id: { required:true, remote:{type:'post',url:'../boardmanager_process?mode=boardmanager_idck'}},
					board_name: { required:true }
				},
				messages: {
					board_id: { required:'????????? ???????????? ??????????????????.', remote: '???????????? ?????????????????????.'},
					board_name: { required:'??????????????? ??????????????????.'}
				},
				showErrors: function(_, eL) {
					if(window.submitted) {
						alert(eL[0].message);
						window.submitted = false;
					}
				},
				invalidHandler: function(form, validator) {
					window.submitted = true;
				},
				submitHandler: function(f) {
					if(readyEditorForm(f)){
						var boardname = $(f).find('[name="board_name"]');
						var boardid = $(f).find('[name="board_id"]');

						var board_id_ck = /^[a-zA-Z0-9_-]{3,20}$/; // ????????? ?????????
						if (board_id_ck.test(boardid.val()) != true) { // ????????? ??????
							alert('???????????? ????????? ???????????????.\n???????????? ??????,??????,???????????????,???????????? ?????????????????????.');
							boardid.focus();
							return false;
						}
						if (boardname.val().length < 3) { // ???????????? ??????
							alert('3???????????? ?????????????????? ????????? ?????????.');
							boardname.focus();
							return false;
						}

						if (containsChars(boardname,"\"")) {
							alert('????????? ????????? ????????????(" ")??? ????????? ??? ????????????.\n????????????(\") ??? ????????? ?????????????????? ????????? ?????????.');
							boardname.focus();
							return false;
						}

<?php if($TPL_VAR["service_limit"]&&!$TPL_VAR["id"]){?>
						openDialog("????????? ?????? ??????<span class='desc'></span>", "BoadService", {"width":600,"height":200});
<?php }else{?>
						f.submit();
<?php }?>
					}
				}
			});
<?php }?>

		$('#board_id').after('<strong></strong>');
		// #boardid ???????????? onkeyup ???????????? ????????????
		boardid.keyup( function() {
			var s = $(this).next('strong'); // strong ????????? ????????? ??????
			if (boardid.val().length == 0) { // ?????? ?????? ?????? ???
				s.text(''); // strong ????????? ????????? ?????? ??????
			} else if (boardid.val().length < 3) { // ?????? ?????? 3?????? ?????? ???
				s.text('?????? ?????????.'); // strong ????????? ?????? ??????
			} else if (boardid.val().length > 20) { // ?????? ?????? 16?????? ??? ???
				s.text('?????? ?????????.'); // strong ????????? ?????? ??????
			}else{
				s.text(''); // strong ????????? ?????? ??????
			}
		});

		//???????????? all
		$(".auth_read").click(function(){
			if($(this).val() == 'member' ){
				$(".auth_read_group").attr("disabled",false);
				$(".auth_read_group").attr("checked",true);
			}else{
				$(".auth_read_group").attr("disabled",true);
				$(".auth_read_group").removeAttr("checked");
			}
		});

<?php if($TPL_VAR["type"]=='A'){?>
			//?????? ???????????? all
			$(".auth_write").click(function(){
				if($(this).val() == 'member' ){
					$(".auth_write_group").attr("disabled",false);
					$(".auth_write_group").attr("checked",true);
				}else{
					$(".auth_write_group").attr("disabled",true);
					$(".auth_write_group").removeAttr("checked");
				}
			});

			//?????? ???????????? all
			$(".auth_reply").click(function(){
				if($(this).val() == 'member' ){
					$(".auth_reply_group").attr("disabled",false);
					$(".auth_reply_group").attr("checked",true);
				}else{
					$(".auth_reply_group").attr("disabled",true);
					$(".auth_reply_group").removeAttr("checked");
				}
			});

			//?????? ???????????? all
			$(".auth_cmt").click(function(){
				if($(this).val() == 'member' ){
					$(".auth_cmt_group").attr("disabled",false);
					$(".auth_cmt_group").attr("checked",true);
				}else{
					$(".auth_cmt_group").attr("disabled",true);
					$(".auth_cmt_group").removeAttr("checked");
				}
			});

<?php }else{?>
			//??????/??????/?????? ???????????? all
			$(".auth_write").click(function(){
				if($(this).val() == 'member' ){
					$(".auth_write_group").attr("disabled",false);
					$(".auth_write_group").attr("checked",true);
				}else{
					$(".auth_write_group").attr("disabled",true);
					$(".auth_write_group").removeAttr("checked");
				}
			});

			//?????? ???????????? all
			$(".auth_reply").click(function(){
				if($(this).val() == 'member' ){
					$(".auth_reply_group").attr("disabled",false);
					$(".auth_reply_group").attr("checked",true);
				}else{
					$(".auth_reply_group").attr("disabled",true);
					$(".auth_reply_group").removeAttr("checked");
				}
			});

			//???????????? > ?????? ???????????? all
			$(".auth_write_cmt").click(function(){
				if($(this).val() == 'member' ){
					$(".auth_write_cmt_group").attr("disabled",false);
					$(".auth_write_cmt_group").attr("checked",true);
				}else{
					$(".auth_write_cmt_group").attr("disabled",true);
					$(".auth_write_cmt_group").removeAttr("checked");
				}
			});


<?php }?>

		/* ????????????*/
		$("button#boardcategoryadd").click(function(){
			var trObj = $("#BoardCategoryTable tbody");
			var trClone = '<tr><td><img src="/admin/skin/default/images/common/icon_move.png"></td><td class="left"><input type="text" name="category[]"></td><td><button type="button" class="btn_minus"></button></td></tr>';
			trObj.append(trClone);
			$(this).closest('table').find('tfoot').hide();
		});

		/* ?????????????????? ?????? */
		$("#BoardCategoryTable").on('click', 'button.btn_minus', function(){
			if($(this).closest('tbody').find('tr').length === 1) {
				$(this).closest('table').find('tfoot').show();
			}
			$(this).closest('tr').remove();
		});

			/* ?????????????????? */
		$("table#BoardCategoryTable tbody").sortable({items:'tr'});


		/* ??????????????????*/
		$("button#boardreviewcategoryadd").click(function(){
<?php if(!$TPL_VAR["isplusfreenot"]){?>
				//serviceUpgrade();
<?php }else{?>
				var trObj = $("#BoardReviewCategoryTable tbody");
				var trClone = '<tr><td><img src="/admin/skin/default/images/common/icon_move.png"></td><td class="left"><input type="text" name="reviewcategory[]" class="line"></td><td><button type="button" class="btn_minus etcDel"></button></td></tr>';
				trObj.append(trClone);
<?php }?>
		});

		/* ???????????????????????? ?????? */
		$("#BoardReviewCategoryTable button.etcDel").live("click",function(){
			if($("#BoardReviewCategoryTable tbody tr").length > 0) $(this).parent().parent().parent().remove();
		});

		/* ???????????????????????? */
		$("table#BoardReviewCategoryTable tbody").sortable({items:'tr'});

		$('input[name="write_admin_type"]').on('change', function() {
			if($(this).closest('form').prop('elements').write_admin_type.value==='TXT') {
				$('#write_admin').show();
				$('#image_admin').hide();
			}
			else {
				$('#write_admin').hide();
				$('#image_admin').show();
			}
		}).trigger('change');

		/*  New icon > ????????? ????????? ?????? */
		$("button#iconNewBtn").click(function(){
			$("#icontype").val('new');
			openDialog("????????? ??????  <span class='desc'>??????????????? ????????? ???????????? ????????? ?????????.</span>", "BoardIconPopup", {"width":"380","height":"150","show" : "fade","hide" : "fade"});
		});

		/* Hot icon >  ????????? ????????? ?????? */
		$("button#iconHotBtn").click(function(){
			$("#icontype").val('hot');
			openDialog("????????? ??????  <span class='desc'>??????????????? ????????? ???????????? ????????? ?????????.</span>", "BoardIconPopup", {"width":"380","height":"150","show" : "fade","hide" : "fade"});
		});

		/* ???????????? > ????????? ????????? ?????? */
		$("button#iconReviewBtn").click(function(){
			$("#icontype").val('review');
			openDialog("????????? ??????  <span class='desc'>??????????????? ????????? ???????????? ????????? ?????????.</span>", "BoardIconPopup", {"width":"380","height":"150","show" : "fade","hide" : "fade"});
		});


		/* ????????? ?????? > ????????? ????????? ?????? */
		$("button#iconAdminBtn").click(function(){
			$("#icontype").val('admin');
			openDialog("????????? ????????? ??????  <span class='desc'>??????????????? ????????? ???????????? ????????? ?????????.</span>", "BoardIconPopup", {"width":"450","height":"150","show" : "fade","hide" : "fade"});
		});
		 
		
		/* ??????????????? > ????????? ????????? ?????? */
		$("button.iconrecommendBtn").click(function(){
			var icontype = $(this).attr("icontype");
			$("#icontype").val(icontype);
			openDialog("??????????????? ????????? ??????  <span class='desc'>??????????????? ????????? ???????????? ????????? ?????????.</span>", "BoardIconPopup", {"width":"450","height":"130","show" : "fade","hide" : "fade"});
		}); 

		$("input:[name='recommend_type']").click(function(){  
			if( $(this).val() == '3' ) {
				$("span#scoreid").html('5????????????');
			}else if( $(this).val() == '2' ) {
				$("span#scoreid").html('??????/?????????');
			}else{
				$("span#scoreid").html('??????');
			} 
			auth_recommned_icon_lay();
		}); 

		$("input:[name='cmt_recommend_type']").click(function(){   
			auth_cmt_recommned_icon_lay();
		}); 


		/* ???????????? > ????????? ????????? ?????? */
		$("button.iconcmtrecommendBtn").click(function(){
			var icontype = $(this).attr("icontype");
			$("#icontype").val(icontype);
			openDialog("???????????? ????????? ??????  <span class='desc'>??????????????? ????????? ???????????? ????????? ?????????.</span>", "BoardIconPopup", {"width":"450","height":"130","show" : "fade","hide" : "fade"});
		});



		$("input:[name='skin[]']").live('click', function() {
			var skinname = $(".skinlay:checked").val();
			$(".gallerylay02hide").show();
			$(".gallerylay02show").hide();
			if( skinname.substring(0,7) == 'gallery' ) {
				$(".gallerylay").show();
				$(".defaultlay").hide();
				// ??????????????? ?????? ????????? ?????? ??????
				if( skinname == 'gallery02' ) {
					$(".gallerylay02hide").hide();
					$(".gallerylay02show").show();
				}
			}else{
				$(".defaultlay").show();
				$(".gallerylay").hide();
			}
		});
		$("input:[name='skin[]']:checked").trigger('click');

		// ?????? ?????? ????????? ??????
		$("input.gallerycell").blur(function() {
			var gallerytotalnum = parseInt($("input#gallerycell0").val())*parseInt($("input#gallerycell1").val());
			$("#gallerytotalnum").html(setComma(gallerytotalnum));
		});
<?php if($TPL_VAR["useform"]["display"]["skin"]["use"]){?>
<?php if($TPL_skinlist_1){foreach($TPL_VAR["skinlist"] as $TPL_K1=>$TPL_V1){?>
				skintypelay('<?php echo $TPL_K1?>');
<?php }}?>
<?php }else{?>
			skintypelay('<?php echo $TPL_VAR["skin"]?>');
<?php }?>

		$("#autoemoneystrcut1").click(function(){
			$("#autoemoneytype2").attr('checked',true);
		});

		$("#autoemoneystrcut2").click(function(){//, #autoemoney_photo, #autoemoney_review
			$("#autoemoneytype3").attr('checked',true);
		});

		$("input[name=autopoint]").change(function(){
			if(!Firstmall.Config.Environment.serviceLimit.H_FR && $(this).attr('checked')) {
				$(".autopoint").show();
			}
			else {
				$(".autopoint").hide();
				$(".autopoint").find('input,select').val('').change();
			}
		}).change();

		$("input[name=bbslimit]").change(function(){
			if(!Firstmall.Config.Environment.serviceLimit.H_FR && $(this).attr('checked')) {
				$(".bbslimit").show();
			}
			else {
				$(".bbslimit").hide();
				$(".bbslimit").find('input,select').val('').change();
			}
		}).change();

		$(".sms_contents").live("keydown",function(){
			str = $(this).val();
			$(this).parent().parent().parent().find(".sms_byte").html(chkByte(str));
		});
		$(".sms_contents").live("keyup",function(){
			str = $(this).val();
			$(this).parent().parent().parent().find(".sms_byte").html(chkByte(str));
		}).trigger('keyup');
		$('.del_message').click(function(){
			$(this).parent().parent().parent().find('textarea').val('').trigger('keyup');
		});

<?php if($TPL_VAR["id"]=='bulkorder'){?>
			$("#bulk_show_goods").click(function(){//bulk_totprice
				if( $(this).attr("checked") ){
					$(".bulk_totpricelay").removeClass("gray");
					$(".bulk_totpricelay").removeAttr("disabled");
					$("#bulk_totprice").removeAttr("disabled");
					//$("#bulk_totprice").attr("checked",false);
				}else{
					$(".bulk_totpricelay").addClass("gray");
					$(".bulk_totpricelay").attr("disabled","disabled");
					$("#bulk_totprice").attr("disabled","disabled");
					$("#bulk_totprice").attr("checked",false);
				}
			});

			$("#bulk_show_payment").click(function(){
				if( $(this).attr("checked") ){
					$(".bulk_payment_type_alllay").removeClass("gray");
					$(".bulk_payment_type_alllay").removeAttr("disabled");
					$("input:radio[name='bulk_payment_type']").removeAttr("disabled");
				}else{
					$(".bulk_payment_type_alllay").addClass("gray");
					$(".bulk_payment_type_alllay").attr("disabled","disabled");
					$("input:radio[name='bulk_payment_type']").attr("disabled","disabled");
				}
			});

			$(".labelList_bulkorder").sortable({
				'items': 'tr[class^="layer"]',
			});
			$(".labelList_bulkorder").disableSelection();
			typeCheck();
			$(".bulkorder_chUse").live("click",function(){
				typeCheck();
			});

<?php }?>


			/* ### */
			$(".info_code").click(function(){
				$("#s_title").html($(this).attr("title"));
				openDialog("?????? ????????? ????????????", "infoPopup", {"width":"500","height":"420"});
			});



		// ?????????????????? ???????????????????????????
		$("input[name=bulkorder_free_btn]").click(function(){
<?php if(serviceLimit('H_FR')){?>
			<?php echo serviceLimit('A1')?>

<?php }?>
		});

		$("select[name='video_reserve_select']").change(function(){
			span_controller('reserve','video');
		}).change();
		$("select[name='video_point_select']").change(function(){
			span_controller('point','video');
		}).change();
		$("select[name='photo_reserve_select']").change(function(){
			span_controller('reserve','photo');
		}).change();
		$("select[name='photo_point_select']").change(function(){
			span_controller('point','photo');
		}).change();
		$("select[name='default_reserve_select']").change(function(){
			span_controller('reserve','default');
		}).change();
		$("select[name='default_point_select']").change(function(){
			span_controller('point','default');
		}).change();

		$("select[name='date_reserve_select']").change(function(){
			span_controller('reserve','date');
		}).change();
		$("select[name='date_point_select']").change(function(){
			span_controller('point','date');
		}).change();

<?php if($TPL_VAR["id"]=='goods_review'){?>
			$(".labelList_goodsreview").sortable();
			/* ????????? ????????? ?????? .labelList_goodsreview */
			$("#labelTable .goodsReviewIcon").live("click",function(){
				//var trObj = $("#labelTable tbody").find("input[name='labelIcon[]']");
				var idx = $(this).attr('iconindex');
				$("input[name='iconReviewIndex']").val(idx);
				set_goods_icon();
				closeDialog("goodsReviewIconPopup");
				openDialog("????????? ??????  <span class='desc'>??????????????? ????????? ???????????? ???????????? ?????????.</span>", "goodsReviewIconPopup", {"width":"550","height":"200","show" : "fade","hide" : "fade"});
			});
			changeFileStyle();

			/* ????????? ?????? */
			$("#goodsReviewIconPopup img.icon").live("click",function(){
				var idx = $("input[name='iconReviewIndex']").val();
				$("#labelTable tbody tr").find("img.goodsReviewIcon").eq(idx).attr("src",$(this).attr("src")+'?time'+<?php echo time()?>);
				var filename = $(this).attr("filename");
				$("input[name='labelIcon[]']").eq(idx).val(filename);
				closeDialog("goodsReviewIconPopup");
			});
			typeCheck();

			$(".bulkorder_chUse").live("click",function(){
				typeCheck();
			});
<?php }?>


		$("#auth_writeonlybuyer").click(function(){
			Editor.switchEditor($("#content_default").data("initializedId"));
			var content = Editor.getContent();
			var cont_default = "";
			var content_default_mobile = "";
			if( !content || content == "<p>&nbsp;</p>" || content == "<p><br></p>" || !$("#content_default_mobile").val()) {
				if( confirm("?????? ??? ????????? ??????????????? ?????????????????????????") ) {
					var msghtml = "??????????????? ???????????? ????????? ???????????????.<br>????????? ????????? ????????? ??? ??????????????? ????????? ?????????.";
					var msgtext = "??????????????? ???????????? ????????? ???????????????.\r\n????????? ????????? ????????? ??? ??????????????? ????????? ?????????.";
					if(!content || content == "<p>&nbsp;</p>" || content == "<p><br></p>") {
						Editor.modify({"content" : msghtml});
					}
					if(!$("#content_default_mobile").val()) $("#content_default_mobile").val(msgtext);
				}
			}
		});
		
		//??????????????????
		$(".board_view").click(function() {
			if($(this).attr("checked")){ 
				$(this).parent().parent().find(".board_view_pw").attr("checked",true);
				$(this).parent().parent().find(".board_act").attr("checked",true);
				$(this).parent().parent().find(".board_view_pw").attr("disabled",false);
				$(this).parent().parent().find(".board_act").attr("disabled",false);
			}else{
				$(this).parent().parent().find(".board_view_pw").attr("checked",false);
				$(this).parent().parent().find(".board_act").attr("checked",false);
				$(this).parent().parent().find(".board_view_pw").attr("disabled",true);
				$(this).parent().parent().find(".board_act").attr("disabled",true);
			}
		});
		
		//?????? ??????????????? ?????? ???????????? ??????
		$("input[name='auth_cmt_use']").on("click",function(){
			auth_cmt_use_ck();
		});

		//????????? ????????????
		$("input[name='auth_recommend_use']").click(function(){
			auth_recommend_use_ck();
		});

		//???????????? ????????????
		$("input[name='auth_cmt_recommend_use']").click(function(){
			auth_cmt_recommend_use_ck();
		});
		
		//??????????????? ????????????
		$("#allClick").click(function(){
			if($(this).attr("gb")=="none"){
				$("input.authboard").attr("checked",true);
				$("#click_text").html("????????????");
				$(this).attr("gb","click");
				$("input.board_view_pw").attr("disabled",false);
				$("input.board_act").attr("disabled",false);
			}else{
				$("input.authboard").attr("checked",false);
				$("#click_text").html("????????????");
				$(this).attr("gb","none");
				$("input.board_view_pw").attr("disabled",true);
				$("input.board_act").attr("disabled",true);
			} 
		});

		$('#video_reserve_year').val('<?php echo $TPL_VAR["video_reserve_year"]?>');
		$('#video_point_year').val('<?php echo $TPL_VAR["video_point_year"]?>');
		$('#photo_reserve_year').val('<?php echo $TPL_VAR["photo_reserve_year"]?>');
		$('#photo_point_year').val('<?php echo $TPL_VAR["photo_point_year"]?>');
		$('#default_reserve_year').val('<?php echo $TPL_VAR["default_reserve_year"]?>');
		$('#default_point_year').val('<?php echo $TPL_VAR["default_point_year"]?>');
		$('#date_reserve_year').val('<?php echo $TPL_VAR["date_reserve_year"]?>');
		$('#date_point_year').val('<?php echo $TPL_VAR["date_point_year"]?>');
	});

	//????????? ????????????
	function auth_recommend_use_ck(recommend_type){ 
		var auth_recommend_use = $("input[name='auth_recommend_use']:checked").val();  
		if( auth_recommend_use == 'Y' ){
			$(".recommend_type").attr("disabled",false);
			if(typeof recommend_type != 'undefined' && recommend_type){
				$("input[name='recommend_type'][value='"+recommend_type+"']").attr("checked",true);
			}else{
				$("input[name='recommend_type'][value='2']").attr("checked",true);
			}
			
			$("input[name='list_show[]'][value='[score]']").attr("checked",true);
			$("input[name='list_show[]'][value='[score]']").attr("disabled",false);
			$(".recommend_type").closest('tr').show();
		}else{ 
			$(".recommend_type").attr("disabled",true);
			$("input[name='recommend_type']").attr("checked",false);
			
			$("input[name='list_show[]'][value='[score]']").attr("checked",false);
			$("input[name='list_show[]'][value='[score]']").attr("disabled",true);
			$(".recommend_type").closest('tr').hide();
		}
<?php if($TPL_VAR["seq"]){?>
<?php if((isset($TPL_VAR["list_show"])&&strstr($TPL_VAR["list_show"],'[score]'))){?>
				$("input[name='list_show[]'][value='[score]']").attr("checked",true);
<?php }else{?>
				$("input[name='list_show[]'][value='[score]']").attr("checked",false);
<?php }?>
<?php }?>

		auth_recommned_icon_lay();

	}

	//?????? ???????????? ????????????
	function auth_cmt_use_ck(cmt_recommend_type){ 
		var auth_recommend_use 	= $("input[name='auth_recommend_use']:checked").val();  
		var auth_cmt_use 		= $("input[name='auth_cmt_use']:checked").val(); 
		if(  auth_cmt_use == 'Y') {// && auth_recommend_use == 'Y' 
			$(".auth_cmt_recommend_use").attr("disabled",false);
			$(".cmt_recommend_type").attr("disabled",false);   
			if(cmt_recommend_type){
				$("input[name='cmt_recommend_type'][value='"+cmt_recommend_type+"']").attr("checked",true);
			}else{ 
				$("input[name='cmt_recommend_type'][value='2']").attr("checked",true); 
			}
			$(".auth_cmt_recommend_use").closest('tr').show();
		}else{
			$(".auth_cmt_recommend_use").attr("disabled",true);
			//$(".cmt_recommend_type").attr("disabled",true);
			//$("input[name='cmt_recommend_type']").attr("checked",false); 
			$("#auth_cmt_recommend_usey").attr("checked",false);
			$("#auth_cmt_recommend_usen").attr("checked",true);

			$(".auth_cmt_recommend_use").closest('tr').hide();
		}
		auth_cmt_recommend_use_ck(cmt_recommend_type);
		auth_cmt_recommned_icon_lay();
	}

	//???????????? ????????????
	function auth_cmt_recommend_use_ck(cmt_recommend_type){ 
		var auth_cmt_recommend_use = $("input[name='auth_cmt_recommend_use']:checked").val();
		if( auth_cmt_recommend_use == 'Y' ){
			$(".cmt_recommend_type").attr("disabled",false);
			if(cmt_recommend_type){
				$("input[name='cmt_recommend_type'][value='"+cmt_recommend_type+"']").attr("checked",true);
			}else{ 
				$("input[name='cmt_recommend_type'][value='2']").attr("checked",true); 
			}
			$(".cmt_recommend_type").closest('tr').show();
		}else{ 
			$(".cmt_recommend_type").attr("disabled",true);
			$("input[name='cmt_recommend_type']").attr("checked",false); 
			$(".cmt_recommend_type").closest('tr').hide();
		}
		
		auth_cmt_recommned_icon_lay();
	}

	//????????? ???????????????
	function auth_recommned_icon_lay(){ 
		var auth_recommend_use = $("input[name='auth_recommend_use']:checked").val();  
		var recommend_type = $("input[name='recommend_type']:checked").val();   
		if( auth_recommend_use == 'Y' && recommend_type ) {
			$(".recommend_type3").hide();
			$(".recommend_type2").hide();
			$(".recommend_type1").hide(); 
			$(".recommend_type"+recommend_type).show(); 
		}else{
			$(".recommend_type1").show(); 
			$(".recommend_type2").hide();
			$(".recommend_type3").hide(); 
		}
	}

	//?????? ???????????????
	function auth_cmt_recommned_icon_lay(){
		var auth_cmt_recommend_use = $("input[name='auth_cmt_recommend_use']:checked").val();
		var cmt_recommend_type = $("input[name='cmt_recommend_type']:checked").val();  
		if( cmt_recommend_type  && auth_cmt_recommend_use == 'Y' ) {
			$(".cmt_recommend_type2").hide();
			$(".cmt_recommend_type1").hide();
			$(".cmt_recommend_type"+cmt_recommend_type).show(); 
		}else{
			$(".cmt_recommend_type1").hide();
			$(".cmt_recommend_type2").hide();
		}
	}


	function span_controller(nm, type){
		var name = type ? type+"_"+nm : nm;
		var reserve_y = $("span[name='"+name+"_y']");
		var reserve_d = $("span[name='"+name+"_d']");
		var value = $("select[name='"+name+"_select'] option:selected").val();
		if(value==""){
			reserve_y.hide();
			reserve_d.hide();
		}else if(value=="year"){
			reserve_y.show();
			reserve_d.hide();
		}else if(value=="direct"){
			reserve_y.hide();
			reserve_d.show();
		}

		reserve_y.addClass("black");
		reserve_d.addClass("black");
	}

	function typeCheck(){

		$(".bulkorder_chUse").each( function(){
			var bulkorder_ch = $(this).attr("bulkorder_ch");
			var tmps_nm = "labelItem[user]["+bulkorder_ch+"][use]";
			var obj = $("input:checkbox[name='"+tmps_nm+"']");
			var tmps_nm2 = "labelItem[user]["+bulkorder_ch+"][required]";
			if(!$("input:checkbox[name='"+tmps_nm+"']").attr("checked")){
				$("input:checkbox[name='"+tmps_nm2+"']").attr("disabled","disabled");
				obj.parent().parent().css("background-color","#ffffff");
			}else{
				$("input:checkbox[name='"+tmps_nm2+"']").attr("disabled",false);
				obj.parent().parent().css("background-color","#e7f2fc");
			}
		});

		if( $(".bulkorder_chUse").size() ) {
			$("input[name='list_show[]'][value='[reviewinfo]']").attr("disabled",false);
		}

	}

	function chkByte(str){
		var cnt = 0;
		for(i=0;i<str.length;i++) {
			cnt += str.charCodeAt(i) > 128 ? 2 : 1;
			if(str.charCodeAt(i)==10) cnt++;
		}
		return cnt;
	}

		function skintypelay(skinname){
			skinname = (skinname) ? skinname:$(".skinlay:checked").val();
			$.ajax({
					'url' : "../boardmanager_process",
					'data' : {'mode':'boardmanager_skin_help', 'boardid':'<?php echo $TPL_VAR["id"]?>', 'skinname':skinname},
					'type' : 'post',
					'dataType': 'json',
					'success': function(data) {
					$("#skin_type_lay"+skinname).html(data.skin_type_img);
					$("#skin_help_lay"+skinname).html(data.skin_help);
					}
			});
		}

		// ??????????????? ?????????
		function iconFileUpload(str){
			if(str > 0) {
				alert('???????????? ????????? ?????????.');
				return false;
			}
			//????????????
			var frm = $('#Iconregist');
			frm.attr("action","../boardmanager_process");
			frm.submit();
		}

		// ????????????????????????
		function iconFileUploadComplete(result, icontype,filename, filedir, file_ext){
			$("#BoardIconPopup").html('<form name="Iconregist" id="Iconregist" method="post" action="" enctype="multipart/form-data" target="actionFrame"><input type="hidden" name="mode" id="" value="boardmanager_icon"><input type="hidden" name="seq" value="<?php echo $TPL_VAR["seq"]?>"><input type="hidden" name="boardid" value="<?php echo $TPL_VAR["id"]?>"><input type="hidden" name="icontype" id="icontype" value="' + icontype + '"><ul><li style="float:left;width:100px;height:30px;text-align:center"><input type="file" name="board_icon" id="board_icon" onChange="iconFileUpload();"></li></ul></form>');

			if(result ==  "true"){//file_ext
				// $("#icon_" + icontype + "_lay").html("<input type='hidden' name='real_icon_name_" + icontype + "' value='" + filename + "'><input type='hidden' name='real_icon_ext_" + icontype + "' value='" + file_ext + "'><img src='" + filedir + filename +"?"+$.now()+"' id='icon_" + icontype + "_img'>");
				$('#icon_' + icontype + '_img').attr('src', filedir + filename + '?' + $.now());
				closeDialog("BoardIconPopup");
			}
		}

		/**
		 * ???????????? ?????? ??????(chars)??? ????????? ??????
		 * ?????? ????????? ???????????? ????????? ??? ??? ??????
		 * ex) if (containsChars(form.name,"^%$#@~;")) {
		 *         alert("?????? ???????????? ?????? ????????? ????????? ??? ????????????.");
		 *     }
		 */
		 function containsChars(input,chars) {
			 for (var inx = 0; inx < input.val().length; inx++) {
				if (chars.indexOf(input.val().charAt(inx)) != -1)
					return true;
			 }
			 return false;
		 }
</script>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>