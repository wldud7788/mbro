<?php /* Template_ 2.2.6 2022/05/17 12:36:41 /www/music_brother_firstmall_kr/admin/skin/default/order/view.html 000046103 */ 
$TPL_able_step_action_1=empty($TPL_VAR["able_step_action"])||!is_array($TPL_VAR["able_step_action"])?0:count($TPL_VAR["able_step_action"]);
$TPL_gift_target_goods_1=empty($TPL_VAR["gift_target_goods"])||!is_array($TPL_VAR["gift_target_goods"])?0:count($TPL_VAR["gift_target_goods"]);
$TPL_bank_1=empty($TPL_VAR["bank"])||!is_array($TPL_VAR["bank"])?0:count($TPL_VAR["bank"]);
$TPL_process_log_1=empty($TPL_VAR["process_log"])||!is_array($TPL_VAR["process_log"])?0:count($TPL_VAR["process_log"]);
$TPL_error_export_log_1=empty($TPL_VAR["error_export_log"])||!is_array($TPL_VAR["error_export_log"])?0:count($TPL_VAR["error_export_log"]);
$TPL_npay_log_1=empty($TPL_VAR["npay_log"])||!is_array($TPL_VAR["npay_log"])?0:count($TPL_VAR["npay_log"]);
$TPL_order_memo_1=empty($TPL_VAR["order_memo"])||!is_array($TPL_VAR["order_memo"])?0:count($TPL_VAR["order_memo"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<!-- <link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layer_stock.css" />
<style>
	.price {padding-right:5px;text-align:right}
	table.order-inner-table,
	table.order-inner-table td,table.order-inner-table th {border:0 !important;height:9px !important;}
	.ea {font-family:dotum; color:#a400ff;}
	.title_order_number {font-family:dotum;font-size:13px;}
	.provider_name {font-weight:bold;}

	table.detail_price { background-color:#ffffff !important; border-collapse:collapse !important; border:2px solid #bcbfc1 !important; }
	table.detail_price th { background-color:#efefef; height:20px !important; border:1px solid #bcbfc1 !important; }
	table.detail_price td { height:20px !important; border:1px solid #bcbfc1 !important; }

	table.order-summary-table tbody td.pvtd{border:1px solid #dcdde1;text-align:center;background-color:#fff;}
	.coupon_status{color:red}
	.coupon_status_all{color:red}
	.coupon_order_status{color:gray}
	.coupon_status_use{color:blue}
	.coupon_input_value{color:green}

	.url-helper{border:1px solid #424242;background-color:#fff;line-height: 14px;}
	.open-link a:link, a:active, a:visited{color: #a7a7a7;}
	.open-link a:hover {color:#f63;}
	.warehouse-info-lay { padding:5px;margin:2px 10px 5px 0;border:1px solid #c5c5c5;background-color:#fff; }
</style> -->
<script type="text/javascript">
	/*
	var order_seq				= "<?php echo $TPL_VAR["orders"]["order_seq"]?>";
	var orign_order_seq			= "<?php echo $TPL_VAR["orders"]["orign_order_seq"]?>";
	var order_hidden			= "<?php echo $TPL_VAR["orders"]["hidden"]?>";
	var order_hidden_date		= "<?php echo $TPL_VAR["orders"]["hidden_date"]?>";
	var	order_npay				= "<?php echo $TPL_VAR["npay_use"]?>";
	var	order_pg				= "<?php echo $TPL_VAR["orders"]["pg"]?>";
	var nomatch_goods_cnt		= "<?php echo $TPL_VAR["items_tot"]["nomatch_goods_cnt"]?>";

	var nowDate					= "<?php echo date('Ymd')?>";
	var deposit_day				= "<?php echo date('Ymd',strtotime($TPL_VAR["orders"]["deposit_date"]))?>";
	var step					= "<?php echo $TPL_VAR["orders"]["step"]?>";

	var able_return_ea			= parseInt("<?php echo $TPL_VAR["orders"]["able_return_ea"]?>");
	var able_refund_ea			= parseInt("<?php echo $TPL_VAR["orders"]["able_refund_ea"]?>");
	var able_export_ea			= parseInt("<?php echo $TPL_VAR["orders"]["able_export_ea"]?>");

	var linkage_mallnames		= "<?php echo $TPL_VAR["linkage_mallnames"]?>";
	var order_linkage_id		= "<?php echo $TPL_VAR["orders"]["linkage_id"]?>";

	var referer_name			= encodeURIComponent('<?php echo $TPL_VAR["orders"]["referer_name"]?>');
	var referer_domain			= encodeURIComponent('<?php echo $TPL_VAR["orders"]["referer_domain"]?>');
	var referer					= encodeURIComponent('<?php if($TPL_VAR["orders"]["referer_naver"]){?><?php echo $TPL_VAR["orders"]["referer_naver"]?><?php }else{?><?php echo $TPL_VAR["orders"]["referer"]?><?php }?>');

	var directExport			= "<?php echo $_GET["directExport"]?>";
	var	member_seq				= "<?php echo $TPL_VAR["members"]["member_seq"]?>";
	*/
</script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-orderExportPopup.js"></script>
<!--<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-orderView.js?dummy=<?php echo date('YmdHis')?>"></script>
-->
<script type="text/javascript">
	/* #16651 2018-07-10 ycg ????????? ?????? ?????? ?????? */
	//???????????? ??????
	function modify_order_memo(idx){
		var memo_idx = idx;
		$.ajax({
			url: '../order_process/admin_memo_modify',
			type: 'get',
			data: { memo_idx:memo_idx },
			success: function(data){
				$("textarea[name='admin_memo']").val(data);
				$("textarea[name='admin_memo']").after("<input type='hidden' name='memo_idx' value='"+memo_idx+"'>");
			}
		});
	}

	//???????????? ??????
	function delete_order_memo(idx){
		var memo_idx = idx;
		openDialogConfirm("????????? ????????? ????????? ??? ????????????. ????????? ?????????????????????????",400,150,function(){
			$.ajax({
				url: '../order_process/admin_memo_del',
				type: 'post',
				data: { memo_idx:memo_idx },
				success: function(){
					openDialogAlert("??????????????? ?????????????????????.",400,140,function(){parent.location.reload();});
				}
			});
		});
	}
	/* #16651 2018-07-10 ycg ????????? ?????? ?????? ?????? */

	$(document).ready(function(){
		/* #16651 2018-07-10 ycg ????????? ?????? ?????? ?????? */
		//???????????? ??????
		$("#memo_reg").click(function(){
			var admin_memo = $("textarea[name='admin_memo']").val();
			var memo_idx = $("input[name='memo_idx']").val();
			if(admin_memo!=''){
				$.ajax({
					url:'../order_process/admin_memo',
					type: 'post',
					data: { seq : '<?php echo $TPL_VAR["orders"]["order_seq"]?>', mname : '<?php echo $TPL_VAR["managerInfo"]["mname"]?>', manager_id : '<?php echo $TPL_VAR["managerInfo"]["manager_id"]?>',admin_memo : admin_memo, memo_idx : memo_idx},
					success:function(){
						openDialogAlert("??????????????? ?????? ???????????????.",400,140,function(){parent.location.reload();});
					}
				});
			}else{
				openDialogAlert("?????? ????????? ??????????????????.",400,140,'parent','');
			}
		});
		/* #16651 2018-07-10 ycg ????????? ?????? ?????? ?????? */

		// ?????? ??????
<?php if($TPL_able_step_action_1){foreach($TPL_VAR["able_step_action"] as $TPL_K1=>$TPL_V1){?>
		$("#<?php echo $TPL_K1?>").parent().hide();
		$("form[name=frm_<?php echo $TPL_K1?>]").attr('disabled',true);
		$("input,select,textarea",$("form[name=frm_<?php echo $TPL_K1?>]")).each(function(){$(this).attr('readonly',true);});

<?php if(($TPL_K1=='change_bank')&&$TPL_VAR["orders"]["payment"]=='bank'){?>
<?php if(!in_array($TPL_VAR["orders"]["step"],array('15'))){?>
		// ???????????? ???????????? ????????? ????????? ???????????? ???????????? ????????? ?????? leewh 2014-09-01
		if (!$.browser.msie) $("input,select,textarea",$("form[name=frm_<?php echo $TPL_K1?>]")).each(function(){$(this).attr('disabled',true);});
<?php }?>
<?php }?>

<?php if($TPL_VAR["items_tot"]["coupontotal"]> 0){?>
<?php if(($TPL_K1=='return_coupon_list')){?>
<?php if(in_array($TPL_VAR["orders"]["step"],$TPL_V1)||in_array($TPL_VAR["orders"]["step"],array('50'))||in_array($TPL_VAR["orders"]["step"],array('55'))||in_array($TPL_VAR["orders"]["step"],array('75'))){?>
		$("#<?php echo $TPL_K1?>").parent().show();
		$("form[name=frm_<?php echo $TPL_K1?>]").attr('disabled',false);
		$("input,select,textarea",$("form[name=frm_<?php echo $TPL_K1?>]")).each(function(){$(this).attr('readonly',false);});
<?php }?>
<?php }elseif(($TPL_K1=='order_deposit')||($TPL_K1=='goods_export')){?>
<?php if(in_array($TPL_VAR["orders"]["step"],$TPL_V1)){?>
		$("#<?php echo $TPL_K1?>").parent().show();
		$("form[name=frm_<?php echo $TPL_K1?>]").attr('disabled',false);
		$("input,select,textarea",$("form[name=frm_<?php echo $TPL_K1?>]")).each(function(){$(this).attr('readonly',false);});
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["items_tot"]["goodstotal"]> 0){?>
<?php if(in_array($TPL_VAR["orders"]["step"],$TPL_V1)){?>
<?php if($TPL_K1=='enuri'){?>
<?php if($TPL_VAR["orders"]["payment"]=='bank'){?>
		$("#<?php echo $TPL_K1?>").parent().show();
		$("form[name=frm_<?php echo $TPL_K1?>]").attr('disabled',false);
		$("input,select,textarea",$("form[name=frm_<?php echo $TPL_K1?>]")).each(function(){$(this).attr('readonly',false);});
<?php }?>
<?php }else{?>
		$("#<?php echo $TPL_K1?>").parent().show();
		$("form[name=frm_<?php echo $TPL_K1?>]").attr('disabled',false);
		$("input,select,textarea",$("form[name=frm_<?php echo $TPL_K1?>]")).each(function(){$(this).attr('readonly',false);});
<?php }?>
<?php }?>
<?php }else{?>
<?php if(in_array($TPL_VAR["orders"]["step"],$TPL_V1)){?>
<?php if(($TPL_K1=='enuri'&&$TPL_VAR["orders"]["payment"]=='bank')||$TPL_K1=='cash_receipts'||$TPL_K1=='tax_bill'||$TPL_K1=='card_slips'){?>
		// ??????????????? ??????????????? ???????????????, ???????????????, ???????????? ?????? ??????????????? ??????
		$("#<?php echo $TPL_K1?>").parent().show();
		$("form[name=frm_<?php echo $TPL_K1?>]").attr('disabled',false);
		$("input,select,textarea",$("form[name=frm_<?php echo $TPL_K1?>]")).each(function(){$(this).attr('readonly',false);});
<?php }?>
<?php }?>
<?php }?>
<?php }?>
<?php }else{?>
<?php if(in_array($TPL_VAR["orders"]["step"],$TPL_V1)||($TPL_VAR["orders"]["step"]=='85'&&(($TPL_K1=='goods_ready'&&$TPL_VAR["items_tot"]["step25"]> 0)||($TPL_K1=='goods_export'&&$TPL_VAR["orders"]["able_export_ea"]> 0)||($TPL_K1=='cancel_payment'&&$TPL_VAR["orders"]["able_refund_ea"]> 0)))){?>
<?php if($TPL_K1=='enuri'){?>
<?php if($TPL_VAR["orders"]["payment"]=='bank'){?>
		$("#<?php echo $TPL_K1?>").parent().show();
		$("form[name=frm_<?php echo $TPL_K1?>]").attr('disabled',false);
		$("input,select,textarea",$("form[name=frm_<?php echo $TPL_K1?>]")).each(function(){$(this).attr('readonly',false);});
<?php }?>
<?php }else{?>
		$("#<?php echo $TPL_K1?>").parent().show();
		$("form[name=frm_<?php echo $TPL_K1?>]").attr('disabled',false);
		$("input,select,textarea",$("form[name=frm_<?php echo $TPL_K1?>]")).each(function(){$(this).attr('readonly',false);});
<?php }?>
<?php }?>
<?php }?>
<?php }}?>
	});
</script>

<!-- ????????? ????????? ??? : ?????? -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- ????????? -->
		<div class="page-title">
			<h2>
				<?php echo $TPL_VAR["orders"]["sitetypetitle"]?> <?php if($TPL_VAR["orders"]["marketplacetitle"]){?> <?php echo $TPL_VAR["orders"]["marketplacetitle"]?> <?php }?>
<?php if($TPL_VAR["orders"]["important"]){?>
				<span class="icon-star-gray hand checked list-important important-<?php echo $TPL_VAR["orders"]["step"]?>" id="important_<?php echo $TPL_VAR["orders"]["order_seq"]?>"></span>&nbsp;&nbsp;
<?php }else{?>
				<span class="icon-star-gray hand list-important important-<?php echo $TPL_VAR["orders"]["step"]?>" id="important_<?php echo $TPL_VAR["orders"]["order_seq"]?>"></span>&nbsp;&nbsp;
<?php }?>

<?php if($TPL_VAR["orders"]["step"]< 75&&$TPL_VAR["orders"]["real_stock"]==='?????????'){?>
				<span class='gray'>(?????????)</span>
<?php }elseif($TPL_VAR["orders"]["step"]< 75&&$TPL_VAR["orders"]["miss_stock"]=='Y'){?>
				<span class='gray'>(?????? ??????)</span>
<?php }?>

				<span class="bold fx16"><?php echo $TPL_VAR["orders"]["order_seq"]?></span>
				<a href="javascript:printOrderView('<?php echo $TPL_VAR["orders"]["order_seq"]?>')"><span class="icon-print-order"></span></a>
				&nbsp;&nbsp;&nbsp;

				<span class="icon-order-step-<?php echo $TPL_VAR["orders"]["step"]?>"><?php echo $TPL_VAR["orders"]["mstep"]?></span>
<?php if($TPL_VAR["orders"]["orign_order_seq"]){?>
				(????????? ??????)
<?php }?>

<?php if($TPL_VAR["orders"]["admin_order"]){?>
				(<?php echo $TPL_VAR["orders"]["admin_order"]?> ????????? ??????)
<?php }?>
				<span style="font-size:9pt">???????????? <?php echo $TPL_VAR["orders"]["cancel_list_ea"]?></span>
				<span style="font-size:9pt">?????? <?php echo $TPL_VAR["orders"]["return_list_ea"]?></span>
				<span style="font-size:9pt">?????? <?php echo $TPL_VAR["orders"]["exchange_list_ea"]?></span>
				<span style="font-size:9pt">?????? <?php echo $TPL_VAR["orders"]["refund_list_ea"]?></span>
			</h2>
		</div>
		<!-- ?????? ?????? -->
		<ul class="page-buttons-left">
			<!-- ######################## 16.12.15 gcs yjy : ???????????? ??????????????? -->
			<li><span class="btn large icon"><button type="button" onclick="location.href='catalog?<?php echo $TPL_VAR["query_string"]?>';"><span class="arrowleft"></span>???????????????</button></span></li>
<?php if(!$TPL_VAR["orders"]["disable_order_back_action"]=='POS'){?>
<?php if(in_array($TPL_VAR["orders"]["step"],$TPL_VAR["able_step_action"]['cancel_order'])){?>
			<li><span class="btn large icon"><button type="button" id="cancel_order"><span class="arrowleft"></span>????????????</button></span></li>
<?php }?>
<?php if($TPL_VAR["orders"]["able_refund_ea"]> 0){?>
			<li><span class="btn large icon"><button type="button" id="cancel_payment" onclick="order_refund('<?php echo $TPL_VAR["orders"]["order_seq"]?>');"><span class="arrowleft"></span>????????????</button></span></li>
<?php }?>
<?php if($TPL_VAR["items_tot"]["coupontotal"]> 0){?>
			<li><span class="btn large icon"><button type="button" id="return_coupon_list" onclick="order_return_coupon('<?php echo $TPL_VAR["orders"]["order_seq"]?>');"><span class="arrowleft"></span>???????????? ??????</button></span></li>
<?php }?>
<?php if($TPL_VAR["orders"]["able_return_ea"]> 0||$TPL_VAR["orders"]["able_after_return_ea"]> 0){?>
			<li><span class="btn large icon"><button type="button" id="return_list" onclick="order_return('<?php echo $TPL_VAR["orders"]["order_seq"]?>');"><span class="arrowleft"></span>??????</button></span></li>
<?php }?>
<?php if($TPL_VAR["orders"]["able_return_ea"]> 0&&(!$TPL_VAR["npay_use"]||$TPL_VAR["orders"]["pg"]!='npay')){?>
			<li><span class="btn large icon"><button type="button" id="exchange_list" onclick="order_exchange('<?php echo $TPL_VAR["orders"]["order_seq"]?>');"><span class="arrowleft"></span>?????????</button></span></li>
<?php }?>
<?php }?>
		</ul>
		<!-- ?????? ?????? -->
		<ul class="page-buttons-right">
<?php if(!$TPL_VAR["orders"]["disable_order_back_action"]=='POS'){?>
<?php if($TPL_VAR["items_tot"]["step25"]> 0){?>
			<li><span class="btn large icon green"><button type="button" id="goods_ready">???????????? ??????</button></span></li> ??????
<?php }?>
<?php if((!$TPL_VAR["npay_use"]||$TPL_VAR["orders"]["pg"]!='npay')&&$TPL_VAR["orders"]["step"]== 15){?>
			<li><span class="btn large icon orange"><button type="button" id="order_deposit">????????????</button></span></li>
<?php }?>
<?php }?>
<?php if($TPL_VAR["orders"]["able_export_ea"]> 0){?>
			<li><span class="btn large icon cyanblue"><button type="button" id="goods_export">????????????</button></span></li>
<?php }?>
		</ul>
	</div>
</div>
<!-- ????????? ????????? ??? : ??? -->
<br style="line-height:20px;" />

<?php if($TPL_VAR["orders"]["order_seq"]){?>
<!-- Order_Statistics -->
<div id="Order_Statistics"></div>
<?php }?>
<br style="line-height:10px;" />

<div style="padding-left:5px;">
	<span class="order_reverse hand" autodepositKey="<?php if($TPL_VAR["bankChk"]=='Y'){?><?php echo $TPL_VAR["orders"]["autodeposit_key"]?><?php }?>">
<?php if($TPL_VAR["orders"]["step"]== 25&&$TPL_VAR["orders"]["payment"]=='bank'&&!$TPL_VAR["orders"]["linkage_id"]){?>
		<span class="helpicon" title="??????, ??????, ????????? ?????? ????????? ???????????? ????????????(?????????)??? ????????? ??? ????????????."></span> '????????????' ????????? ???????????? <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_VAR["orders"]["step"]=='35'){?>
		<span class="helpicon" title="??????????????? ????????? ?????????????????? ????????? ??? ????????????."></span> '????????????' ????????? ???????????? <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }elseif($TPL_VAR["orders"]["step"]=='95'&&!$TPL_VAR["orders"]["linkage_id"]){?>
		<span class="helpicon" title="????????? ????????? ????????? ?????? ??????????????? ????????? ??? ????????????."></span> '????????????' ????????? ???????????? <img src="/admin/skin/default/images/common/icon_arrow_back.gif" align="absmiddle" />
<?php }?>
	</span>
</div>

<!----- [???????????? ??????] ??????????????? view_summery.html ??? ?????? ?????? >>>>>  --->
<?php $this->print_("ORDER_INFO",$TPL_SCP,1);?>

<!----- [???????????? ??????]??????????????? view_summery.html ??? ?????? ?????? >>>>>  --->

<?php if($TPL_VAR["gift_target_goods"]){?>
<br class="table-gap" />
<div class="item-title">????????? ?????? ??????</div>
<div align="center">
	<table class="simplelist-table-style" width="100%" border=0>
		<colgroup>
			<col width="30%" />
			<col width="40%" />
			<col width="40%" />
		</colgroup>
		<thead class="oth">
		<tr>
			<th>??? ????????? ????????? ?????? ?????? ??????</th>
			<th>????????? ?????? ?????? ??????</th>
			<th>?????? ????????? ?????? ????????? ????????? ??????</th>
		</tr>
		</thead>
		<tbody class="otb">
<?php if($TPL_gift_target_goods_1){foreach($TPL_VAR["gift_target_goods"] as $TPL_V1){?>
		<tr>
			<td>
				<div style="float:left;margin-left:10px;">
					<a href='/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>' target='_blank'><span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V1["image"]?>" width="40" /></span></a></div>
				<div style="float:left;margin:5px 0 0 8px;">
					<?php echo $TPL_V1["goods_name"]?>

<?php if($TPL_V1["option1"]){?>
					<div class="goods_option">
						<img src="/admin/skin/default/images/common/icon_option.gif" align="absmiddle" />
<?php if($TPL_V1["title1"]){?><?php echo $TPL_V1["title1"]?>:<?php }?><?php echo $TPL_V1["option1"]?>

<?php if($TPL_V1["option2"]){?><?php if($TPL_V1["title2"]){?><?php echo $TPL_V1["title2"]?>:<?php }?><?php echo $TPL_V1["option2"]?><?php }?>
<?php if($TPL_V1["ption3"]){?><?php if($TPL_V1["title3"]){?><?php echo $TPL_V1["title3"]?>:<?php }?><?php echo $TPL_V1["option3"]?><?php }?>
<?php if($TPL_V1["option4"]){?><?php if($TPL_V1["title4"]){?><?php echo $TPL_V1["title4"]?>:<?php }?><?php echo $TPL_V1["option4"]?><?php }?>
<?php if($TPL_V1["option5"]){?><?php if($TPL_V1["title5"]){?><?php echo $TPL_V1["title5"]?>:<?php }?><?php echo $TPL_V1["option5"]?><?php }?>
					</div>
<?php }?>
				</div>
			</td>
<?php if($TPL_V1["gift_seq"]!=$TPL_V1["after_gift_seq"]){?>
			<td <?php if($TPL_V1["row_cnt"]> 1){?>rowspan="<?php echo $TPL_V1["row_cnt"]?>"<?php }?> style="border-left:1px solid #ddd;">
				<div style="margin:5px 10px;line-height:16px;" >
					<div class="bold" style="line-height:20px;">[<?php echo $TPL_V1["gift_title"]?>]</div>
					<?php echo $TPL_V1["gift_rule_text2"]?>

<?php if($TPL_V1["gift_goods"]){?><div>-> <?php echo implode("<br />-> ",$TPL_V1["gift_goods"])?></div> <?php }?>
				</div>
			</td>
			<td <?php if($TPL_V1["row_cnt"]> 1){?>rowspan="<?php echo $TPL_V1["row_cnt"]?>"<?php }?> style="border-left:1px solid #ddd;">
				<div style="padding:5px;">
<?php if($TPL_V1["gift_rule"]=='lot'){?>????????????
<?php }else{?>
					?????? ????????? ???????????? ?????? ????????? ?????? ????????? ???????????? ?????? ?????? ?????? ????????? ????????? ????????? ??????????????? ????????? <span class='red'>??????????????? ???????????? ?????? ??????????????? ??????</span>????????????.
<?php }?>
				</div></td>
<?php }?>
		</tr>
<?php }}?>
		</tbody>
	</table>
</div>
<?php }?>

<div class="item-title">????????? ??????</div>
<style>
	.order_shipping_box {border:2px solid #547bb7;}
	table.order_shipping_table {border-collapse:collapse;border:1px solid #a0def3;}
	table.order_shipping_table th,
	table.order_shipping_table td {padding:2px;}
	table.order_shipping_table th {background-color:#f3fcff;  border:1px solid #a0def3;}
	table.order_shipping_table td {}

	table.order_shipping_item_table  {}
	table.order_shipping_item_table  tr.ositHeader		th {height:28px; border-top:1px solid #a0def3; border-bottom:1px solid #a0def3; background-color:#f3fcff; font-weight:normal;}
	table.order_shipping_item_table  tr.ositRecord		td {height:26px; padding:5px 0; border-top:1px dashed #ddd;}
	table.order_shipping_item_table  tr.ositRecordFirst td {border-top:0px;}
	table.order_shipping_item_table  tr.ositRecord		td.delivery {border-left:1px dashed #ddd}
</style>
<div class="order_shipping_box">
	<form name="frm_shipping_region" method="post" action="../order_process/shipping?seq=<?php echo $TPL_VAR["orders"]["order_seq"]?>&international=<?php echo $TPL_VAR["orders"]["international"]?>" target="actionFrame">
		<table width="100%" class="order_shipping_table">
			<col width="48%" />
			<tr>
				<th height="25" colspan="2"  colspan="2">
					<div class="left relative ml10">
						<?php echo $TPL_VAR["orders"]["recipient_user_name"]?>??????
<?php if($TPL_VAR["orders"]["international"]=='domestic'){?>
						???????????????(??????)
<?php }else{?>
						???????????????(??????)
<?php }?>
<?php if(!$TPL_VAR["orders"]["linkage_id"]){?>
						<div class="absolute" style="top:-4px; right:3px;"><span class="btn small cyanblue"><button type="submit" id="shipping_region">??????</button></span></div>
<?php }?>
					</div>
				</th>
			</tr>
			<tr>
				<td colspan="2" class="pdt10 pdl10">
					<input type="text" name="recipient_user_name" value="<?php echo $TPL_VAR["orders"]["recipient_user_name"]?>" class="line" /> /
					<input type="text" name="recipient_phone[]" value="<?php echo $TPL_VAR["orders"]["recipient_phone"][ 0]?>" size="5" maxlength="4" class="line" />
					- <input type="text" name="recipient_phone[]" value="<?php echo $TPL_VAR["orders"]["recipient_phone"][ 1]?>" size="5" maxlength="4" class="line" />
					- <input type="text" name="recipient_phone[]" value="<?php echo $TPL_VAR["orders"]["recipient_phone"][ 2]?>" size="5" maxlength="4" class="line" /> /


					<input type="text" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["orders"]["recipient_cellphone"][ 0]?>" size="5" class="line" />
					- <input type="text" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["orders"]["recipient_cellphone"][ 1]?>" size="5" class="line" />
					- <input type="text" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["orders"]["recipient_cellphone"][ 2]?>" size="5" class="line" />
					<span class="btn small cyanblue"><input type="button" value="?????????" class="send_recipient_sms" /></span>
<?php if($TPL_VAR["orders"]["recipient_email"]){?>
					/ <?php echo $TPL_VAR["orders"]["recipient_email"]?>

					<span class="btn small cyanblue"><input type="button" class="email_pop" value="?????????" email="<?php echo $TPL_VAR["orders"]["recipient_email"]?>" /></span>
<?php }?>
				</td>
			</tr>
<?php if($TPL_VAR["goods_kind_arr"]['goods']){?>
			<tr>
				<td  class="pdl10">
<?php if($TPL_VAR["orders"]["international"]=='international'){?>
					<span style="display:inline-block; width:60px">??????</span>
					<select name="region">
<?php if(is_array($TPL_R1=$TPL_VAR["shipping_policy"]["policy"][ 1][ 0]["region"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1==$TPL_VAR["orders"]["region"]){?>
						<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }?>
<?php }}?>
					</select><br />
					<span style="display:inline-block; width:60px">??????</span> <input type="text" name="international_address"  value="<?php echo $TPL_VAR["orders"]["international_address"]?>" size="30" class="line" /><br />
					<span style="display:inline-block; width:60px">??????</span> <input type="text" name="international_town_city"  value="<?php echo $TPL_VAR["orders"]["international_town_city"]?>" size="30" class="line" /><br />
					<span style="display:inline-block; width:60px">???</span> <input type="text" name="international_county"  value="<?php echo $TPL_VAR["orders"]["international_county"]?>" size="30" class="line" /><br />
					<span style="display:inline-block; width:60px">????????????</span> <input type="text" name="international_postcode"  value="<?php echo $TPL_VAR["orders"]["international_postcode"]?>" size="30" class="line" /><br />
					<span style="display:inline-block; width:60px">??????</span> <input type="text" name="international_country"  value="<?php echo $TPL_VAR["orders"]["international_country"]?>" size="30" class="line" /><br />
<?php }else{?>
					<table class="delivery_address">
						<tr>
							<td>
								<input type="text" style="text-align:center;" name="recipient_zipcode" value="<?php echo $TPL_VAR["orders"]["recipient_zipcode"]?>" size="7" maxlength="7" class="line" />
								<span class="btn small"><button type="button" id="recipient_zipcode_button">????????????</button></span>
							</td>
							<td>
								<input type="hidden" name="recipient_address_type" value="<?php echo $TPL_VAR["orders"]["recipient_address_street_type"]?>">
								<table cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td><span <?php if($TPL_VAR["orders"]["recipient_address_type"]=="street"){?>style="font-weight:bold;"<?php }?>>(?????????)</span></td>
										<td><input type="text" name="recipient_address_street" value="<?php echo $TPL_VAR["orders"]["recipient_address_street"]?>" style="width:366px;" class="line" /></td>
									</tr>
									<tr>
										<td><span <?php if($TPL_VAR["orders"]["recipient_address_type"]!="street"){?>style="font-weight:bold;"<?php }?>>(??????)</span></td>
										<td><input type="text" name="recipient_address"  value="<?php echo $TPL_VAR["orders"]["recipient_address"]?>" style="width:366px;" class="line" /></td>
									</tr>
									<tr>
										<td>(????????????)</td>
										<td><input type="text" name="recipient_address_detail" value="<?php echo $TPL_VAR["orders"]["recipient_address_detail"]?>" style="width:366px;" class="line" /></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
<?php }?>
				</td>
				<td valign="top">
				<textarea class="line" style="width:98%; height:100px" name="memo" title="?????? ?????????"><?php if($TPL_VAR["orders"]["each_msg_yn"]=='Y'){?><?php if(is_array($TPL_R1=$TPL_VAR["orders"]["memo"]["ship_message"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?><?php echo $TPL_K1+ 1?>. <?php echo $TPL_VAR["orders"]["memo"]["goods_info"][$TPL_I1]?> : [<?php echo $TPL_V1?>]
<?php }}?><?php }else{?><?php echo $TPL_VAR["orders"]["memo"]?><?php }?>
				</textarea>
				</td>
			</tr>
<?php }?>
		</table>
	</form>
</div>

<div class="item-title">?????????????????? ????????? ?????? ????????????????????????</div>
<form name="frm_change_unique_personal_code" method="post" action="../order_process/unique_personal_code?seq=<?php echo $TPL_VAR["orders"]["order_seq"]?>" target="actionFrame" >
	<table class="info-table-style" style="width: 100%;">
		<colgroup>
			<col width="150" />
			<col />
		</colgroup>
		<tr>
			<th class="its-th-align center">???????????? ????????????</th>
			<td class="its-td">
				<table cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td>
							<input type="text" name="clearance_unique_personal_code" value="<?php echo $TPL_VAR["orders"]["clearance_unique_personal_code"]?>" <?php if(!$TPL_VAR["orders"]["is_option_international_shipping"]){?>disabled="disabled"<?php }?> />
						</td>
						<td class="pdl5">
							<span class="btn small <?php if(!$TPL_VAR["orders"]["is_option_international_shipping"]){?>gray<?php }else{?>cyanblue<?php }?>"><button type="submit" <?php if(!$TPL_VAR["orders"]["is_option_international_shipping"]){?>disabled="disabled"<?php }?>>??????</button></span>
						</td>
						<td class="pdl5">
					<span class="desc">
						????????? ????????? ?????? ????????? ??????????????? ???????????? ?????????????????????.<br/>
						??? ???????????? ????????????????????? ???????????? ?????? ??????????????? ??????????????????????????? ???????????????.<br/>
						??????????????? ???????????? ?????? ???????????? ??????????????????. (??? : ???????????? ?????? ????????? ??????)
					</span>
						</td>

					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
<br class="table-gap" />

<!-- ????????? ?????? ????????? : ?????? -->
<table class="order-detail-table">
	<colgroup>
		<col width="33%" />
		<col width="33%" />
		<col width="33%" />
	</colgroup>
	<tbody class="odt-head">
	<tr>
		<th>???????????????</th>
		<th>????????????</th>
		<th>?????? ?????? (????????????/?????????/????????????)</th>
	</tr>
	</tbody>
	<tbody class="odt-body">
	<tr>
		<td class="odt-body-cell" valign="top">


			<table class="odt-info-table">
				<col width="80" />
				<tr>
					<th>?????????</th>
					<td class="hand" onclick="open_crm_summary(this,'<?php echo $TPL_VAR["members"]["member_seq"]?>','<?php echo $TPL_VAR["orders"]["order_seq"]?>','right');">
<?php if($TPL_VAR["members"]["member_seq"]){?>
						<div>
<?php if($TPL_VAR["members"]["type"]=='??????'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" />
<?php }elseif($TPL_VAR["members"]["type"]=='??????'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" /><?php }?>
							<?php echo $TPL_VAR["orders"]["order_user_name"]?>

<?php if($TPL_VAR["orders"]["sns_rute"]){?>
							(<img src="/admin/skin/default/images/sns/sns_<?php echo substr($TPL_VAR["orders"]["sns_rute"], 0, 1)?>0.gif" align="absmiddle" snscd="<?php echo $TPL_VAR["orders"]["sns_rute"]?>" class="btnsnsdetail hand" no=2>/<span class="blue"><?php echo $TPL_VAR["members"]["group_name"]?></span>)
							<div id="snsdetailPopup2" class="absolute hide"></div>
<?php }else{?>
<?php if($TPL_VAR["members"]["rute"]=='facebook'){?>
							(<span style="color:#d13b00;"><img src="/admin/skin/default/images/board/icon/sns_f0.gif" align="absmiddle"><?php echo $TPL_VAR["members"]["email"]?></span>/<span class="blue"><?php echo $TPL_VAR["members"]["group_name"]?></span>)
<?php }else{?>
							(<span style="color:#d13b00;"><?php echo $TPL_VAR["members"]["userid"]?></span>/<span class="blue"><?php echo $TPL_VAR["members"]["group_name"]?></span>)
<?php }?>
<?php }?>
						</div>
<?php }else{?>
						<img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <?php echo $TPL_VAR["orders"]["order_user_name"]?>(<span class="desc">?????????</span>)
<?php }?>
					</td>
				</tr>
<?php if($TPL_VAR["members"]["type"]=='??????'){?>
				<tr>
					<th>???????????????</th>
					<td><?php echo $TPL_VAR["members"]["bno"]?></td>
				</tr>
				<tr>
					<th>?????????</th>
					<td><?php echo $TPL_VAR["members"]["bname"]?></td>
				</tr>
				<tr>
					<th>?????????</th>
					<td><?php echo $TPL_VAR["members"]["bceo"]?></td>
				</tr>
<?php }?>
				<tr>
					<th>??????</th>
					<td><?php echo $TPL_VAR["orders"]["order_phone"]?></td>
				</tr>
				<tr>
					<th>?????????</th>
					<td>
						<?php echo $TPL_VAR["orders"]["order_cellphone"]?>

<?php if($TPL_VAR["orders"]["order_cellphone"]){?><span class="btn small cyanblue"><input type="button" value="?????????" id="send_sms" cellphone="<?php echo str_replace('-','',$TPL_VAR["orders"]["order_cellphone"])?>" /></span><?php }?>
					</td>
				</tr>
				<tr>
					<th>?????????</th>
					<td>
						<?php echo $TPL_VAR["orders"]["order_email"]?>

<?php if($TPL_VAR["orders"]["order_email"]){?><span class="btn small cyanblue"><input type="button" class="email_pop" value="?????????" email="<?php echo $TPL_VAR["orders"]["order_email"]?>" /></span><?php }?>
					</td>
				</tr>
			</table>


			<div class="pdt20 center">
				<span class="btn medium gray"><a href='../member/email_history?order_seq=<?php echo $TPL_VAR["orders"]["order_seq"]?>' target='_blank'>??????????????????</a></span>
				<span class="btn medium gray"><a href='../member/sms_history?tran_phone=<?php echo str_replace('-','',$TPL_VAR["orders"]["order_cellphone"])?>' target='_blank'>SMS????????????</a></span>
<?php if($TPL_VAR["members"]["userid"]){?>
				<span class="btn medium gray"><a href='../board/board?id=mbqna&search_text=<?php echo $TPL_VAR["members"]["userid"]?>' target='_blank'>1:1??????</a></span>
<?php }?>
			</div>

		</td>
		<td class="odt-body-cell" valign="top" style="padding-bottom:35px;">
<?php if($TPL_VAR["orders"]["payment"]=='bank'||($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=='npay')){?>
			<form name="frm_change_bank" method="post" action="../order_process/bank?seq=<?php echo $TPL_VAR["orders"]["order_seq"]?>" target="actionFrame">
				<div style="position:relative;">
					<div style="position:absolute;top:-40px; right:0px;">
						<span class="btn small cyanblue"><button type="submit" id="change_bank">??????</button></span>
					</div>
<?php }?>
				</div>


				<table class="odt-info-table">
					<col width="80" />
					<tr>
						<th>????????????</th>
						<td>
<?php if($TPL_VAR["orders"]["npay_order_id"]){?>
							<span class="icon-pay-npay"></span>
<?php }?>
<?php if($TPL_VAR["orders"]["pg"]=='kakaopay'){?>
							<span class="icon-pay-<?php echo $TPL_VAR["orders"]["pg"]?>"></span>
<?php }else{?>
							<?php echo $TPL_VAR["orders"]["mpayment"]?>

<?php if($TPL_VAR["orders"]["payment"]=='escrow_account'){?>
							<span class="icon-pay-escrow"></span>
							<span class="icon-pay-account"></span>
<?php }elseif($TPL_VAR["orders"]["payment"]=='escrow_virtual'){?>
							<span class="icon-pay-escrow"></span>
							<span class="icon-pay-virtual"></span>
<?php }else{?>
							<span class="icon-pay-<?php echo $TPL_VAR["orders"]["payment"]?>"></span>
<?php }?>
<?php }?>
						</td>
					</tr>
<?php if($TPL_VAR["orders"]["payment"]=='bank'){?>
					<tr>
						<th>????????????</th>
						<td><?php echo $TPL_VAR["orders"]["bank_account"]?>

							<select name="bank_account" class="line" style="width:150px;">
<?php if($TPL_bank_1){foreach($TPL_VAR["bank"] as $TPL_V1){?>
<?php if($TPL_V1["accountUse"]=='y'){?>
								<option value="<?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["account"]?> ?????????:<?php echo $TPL_V1["bankUser"]?>"><?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["account"]?> ?????????:<?php echo $TPL_V1["bankUser"]?></option>
<?php }?>
<?php }}?>
							</select>
							<script type="text/javascript">
								$("select[name='bank_account']").val('<?php echo $TPL_VAR["orders"]["bank_account"]?>');
							</script>
						</td>
					</tr>
					<tr>
						<th>????????????</th>
<?php if($TPL_VAR["orders"]["step"]== 15){?>
						<td><input type="text" name="depositor" value="<?php echo $TPL_VAR["orders"]["depositor"]?>" size="40" class="line" /></td>
<?php }else{?>
						<td><?php echo $TPL_VAR["orders"]["depositor"]?></td>
<?php }?>
					</tr>
<?php }?>

<?php if(is_array($TPL_R1=$TPL_VAR["orders"]["pg_log"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["pg"]){?>
					<tr>
						<th>pg???</th>
						<td><?php echo $TPL_V1["pg"]?> (<?php echo $TPL_V1["regist_date"]?>)</td>
					</tr>
<?php }?>
<?php if($TPL_V1["tno"]){?>
					<tr>
						<th>????????????</th>
						<td><?php echo $TPL_V1["tno"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["amount"]){?>
					<tr>
						<th>????????????</th>
						<td><?php echo get_currency_price($TPL_V1["amount"], 3,$TPL_VAR["orders"]["pg_currency"])?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["app_time"]){?>
					<tr>
						<th>????????????</th>
						<td><?php echo $TPL_V1["app_time"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["app_no"]){?>
					<tr>
						<th>????????????</th>
						<td><?php echo $TPL_V1["app_no"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["card_name"]){?>
					<tr>
						<th>?????????</th>
						<td><?php echo $TPL_V1["card_name"]?> <?php echo $TPL_V1["card_cd"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["noinf"]){?>
					<tr>
						<th>?????????</th>
						<td><?php echo $TPL_V1["noinf"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["quota"]){?>
					<tr>
						<th>??????</th>
						<td><?php echo $TPL_V1["quota"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["bank_name"]){?>
					<tr>
						<th>??????</th>
						<td><?php echo $TPL_V1["bank_name"]?> <?php echo $TPL_V1["bank_code"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["depositor"]){?>
					<tr>
						<th>?????????</th>
						<td><?php echo $TPL_V1["depositor"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["account"]){?>
					<tr>
						<th>??????</th>
						<td><?php echo $TPL_V1["account"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["va_date"]){?>
					<tr>
						<th>?????????</th>
						<td><?php echo $TPL_V1["va_date"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["commid"]){?>
					<tr>
						<th>???????????????</th>
						<td><?php echo $TPL_V1["commid"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["mobile_no"]){?>
					<tr>
						<th>???????????????</th>
						<td><?php echo $TPL_V1["mobile_no"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["escw_yn"]){?>
					<tr>
						<th>????????????</th>
						<td><?php echo $TPL_V1["escw_yn"]?></td>
					</tr>
<?php }?>
<?php if($TPL_V1["res_msg"]){?>
					<tr>
						<th>???????????????</th>
						<td>[<?php echo $TPL_V1["res_cd"]?>] <?php echo $TPL_V1["res_msg"]?></td>
					</tr>
<?php }?>
<?php }}?>

<?php if($TPL_VAR["orders"]["typereceipt"]== 1){?>
					<tr>
						<th>???????????????</th>
						<td><?php echo $TPL_VAR["sales_cash_msg"]?></td>
					</tr>
<?php }?>

<?php if($TPL_VAR["orders"]["typereceipt"]== 2){?>
					<tr>
						<th>???????????????</th>
						<td><?php echo $TPL_VAR["sales_cash_msg"]?></td>
					</tr>
<?php }?>
				</table>

			</form>

			<div align="center" class="pdt10 <?php if($TPL_VAR["orders"]["pg"]=='paypal'||($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]["pg"]=='npay')||($TPL_VAR["orders"]["linkage_id"]=='pos')){?>hide<?php }?>">
				<span class="btn medium gray"><button type="button" id="card_slips" onclick="location.href='./sales?keyword=<?php echo $TPL_VAR["orders"]["order_seq"]?>'" ><?php if($TPL_VAR["orders"]["payment"]=='card'){?>???????????? ??????<?php }else{?>????????????<?php }?><span class="arrowright"></span></button></span>
<?php if($TPL_VAR["orders"]["typereceipt"]== 1){?>
				<span class="btn medium gray "><button type="button" id="tax_bill"  onclick="location.href='./sales?keyword=<?php echo $TPL_VAR["orders"]["order_seq"]?>'" >???????????????<span class="arrowright"></span></button></span><?php }?>
<?php if($TPL_VAR["orders"]["typereceipt"]== 2){?>
				<span class="btn medium gray"><button type="button" id="cash_receipts"  onclick="location.href='./sales?keyword=<?php echo $TPL_VAR["orders"]["order_seq"]?>'" >???????????????<span class="arrowright"></span></button></span><?php }?>
				<span class="btn medium gray"><button type="button" id="cash_receipts"  onclick="window.open('/prints/form_print_trade?no=<?php echo $TPL_VAR["orders"]["order_seq"]?>')" >???????????????<span class="arrowright"></span></button></span>
			</div>
		</td>
		<td class="odt-body-cell" valign="top">
			<div style="position:relative;width:100%">
				<div style="position:absolute;top:-40px;left:83%;">
					<span class="btn small orange"><button type="button" onclick="viewLogManual('proc');">??????) ????????????</button></span>
				</div>
			</div>
			<div class="pdb5">
				<label class="mr10"><input type="radio" name="view_log" onclick="view_log('order_log');" checked="checked" /> ????????????</label>
				<label class="mr10"><input type="radio" name="view_log" onclick="view_log('export_log');" /> ????????????</label>
<?php if($TPL_VAR["npay_use"]){?>
				<label><input type="radio" name="view_log" onclick="view_log('npay_log');" /> Npay API ????????????</label>
<?php }?>
			</div>
			<div id="order_log">
				<textarea style="background-color:#f9f9f9;width:100%;" rows="10" readOnly="readOnly"><?php if($TPL_process_log_1){foreach($TPL_VAR["process_log"] as $TPL_V1){?>[<?php echo $TPL_V1["regist_date"]?>] [<?php echo $TPL_V1["actor"]?>] <?php if($TPL_V1["add_info"]=="npay"){?>[???????????????]<?php }?> <?php echo $TPL_V1["title"]?><?php echo chr( 10)?><?php }}?></textarea>
			</div>
			<div id="export_log"  class="hide">
					<textarea style="background-color:#f9f9f9;width:100%;"  rows="10" readOnly="readOnly">
<?php if($TPL_error_export_log_1){foreach($TPL_VAR["error_export_log"] as $TPL_V1){?>[<?php echo $TPL_V1["regist_date"]?>]<?php if($TPL_V1["manager_seq"]){?>[<?php echo $TPL_V1["manager_id"]?>(<?php echo $TPL_V1["manager_name"]?>)]<?php }elseif($TPL_V1["provider_seq"]){?>[<?php echo $TPL_V1["provider_id"]?>(<?php echo $TPL_V1["provider_name"]?>)]<?php }else{?>?????????<?php }?><?php if($TPL_V1["add_info"]=="npay"){?>[???????????????]<?php }?><?php echo $TPL_V1["process_title"]?>(<?php echo $TPL_V1["export_type_title"]?>)<?php echo chr( 10)?>?????? : <?php echo $TPL_V1["msg"]?><?php echo chr( 10)?><?php }}?>
					</textarea>
			</div>
			<div id="npay_log" class="hide">
				<textarea style="background-color:#f9f9f9;width:100%;" rows="10" readOnly="readOnly"><?php if($TPL_npay_log_1){foreach($TPL_VAR["npay_log"] as $TPL_V1){?>[<?php echo $TPL_V1["regist_date"]?>][<?php echo $TPL_V1["actor"]?>]<?php if($TPL_V1["add_info"]=="npay"){?>[???????????????]<?php }?> <?php echo $TPL_V1["title"]?><?php echo chr( 10)?><?php if($TPL_V1["detail"]){?>??? <?php echo $TPL_V1["detail"]?><?php }?><?php }}?></textarea>
			</div>

		</td>
	</tr>
	</tbody>
	<tbody class="odt-head">
	<tr>
		<th colspan="3">????????????</th>
	</tr>
	</tbody>
	<!-- #16651 2018-07-10 ycg ????????? ?????? ?????? ?????? -->
	<tbody class="odt-body">
	<tr>
		<td class="odt-body-cell" valign="top" colspan="3">
			<!-- <form name="frm_admin_memo" method="post" action="../order_process/admin_memo?seq=<?php echo $TPL_VAR["orders"]["order_seq"]?>" target="actionFrame">-->
			<table class="simpledata-table-style" style="width:100%;margin-bottom:20px !important;" id="memo_list">
				<colgroup>
					<col width="55" />
					<col width="100" />
<?php if(serviceLimit('H_AD')){?>
					<col width="100" />
<?php }?>
					<col width="100" />
					<col width="*"  />
					<col width="100" />
					<col width="150" />
				</colgroup>
				<tr>
					<th>??????</th>
					<th>????????????</th>
<?php if(serviceLimit('H_AD')){?>
					<th>??????</th>
<?php }?>
					<th>?????????</th>
					<th>??????</th>
					<th>IP</th>
					<th>??????</th>
				</tr>
				<!-- <?php if($TPL_VAR["order_memo"]!=false){?> -->
				<!-- <?php if($TPL_order_memo_1){$TPL_I1=-1;foreach($TPL_VAR["order_memo"] as $TPL_V1){$TPL_I1++;?> -->
				<tr class="center">
					<td><?php echo $TPL_order_memo_1-$TPL_I1?> <input type="hidden" value="<?php echo $TPL_V1["memo_idx"]?>" name="order_memo"></td>
					<td><?php echo substr($TPL_V1["regist_date"], 0, 16)?></td>
<?php if(serviceLimit('H_AD')){?>
					<td><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
					<td><?php echo $TPL_V1["mname"]?><!-- <?php if($TPL_V1["manager_id"]){?> -->(<?php echo $TPL_V1["manager_id"]?>)<!-- <?php }?> --></td>
					<td class="left" style="word-break:break-all;"><?php echo $TPL_V1["admin_memo"]?></td>
					<td><?php echo $TPL_V1["ip"]?></td>
					<td>
						<div style="position:relative;width:100%">
							<span class="btn small cyanblue"><button type="button" id="admin_order_memo" onclick="modify_order_memo(<?php echo $TPL_V1["memo_idx"]?>)">??????</button></span>
							<span class="btn small red"><button type="button" onclick="delete_order_memo(<?php echo $TPL_V1["memo_idx"]?>)">??????</button></span>
						</div>
					</td>
				</tr>
				<!-- <?php }}?> -->
				<!-- <?php }else{?> -->
				<tr>
					<td colspan="7" class="center"> ????????? ????????? ????????????. </td>
				</tr>
				<!-- <?php }?> -->
			</table>

			<table class="info-table-style" style="width: 100%;">
				<colgroup>
					<col width="150" />
					<col />
				</colgroup>
				<tr>
					<th class="its-th-align center">??????</th>
					<td class="its-td">
						<textarea class="odt-memo-textarea line" name="admin_memo" style="background:#f9f9f9;width:95% ;margin-left:4px;"></textarea>
						<div style="position:relative;width:100%">
							<div style="margin:5px;">
								<span class="btn small cyanblue"><button id="memo_reg">??????</button></span>
							</div>
						</div>
					</td>
				</tr>
			</table>
			<!-- </form> -->
		</td>
	</tr>
	</tbody>
</table>
<!-- #16651 2018-07-10 ycg ????????? ?????? ?????? ?????? -->
<!-- ????????? ?????? ????????? : ??? -->

<div id="goods_ready_dialog"></div>
<div id="goods_export_dialog"></div>

<!-- ????????? ??? ??????-->
<div class="hide">
	<form name="goods_export_frm" id="goods_export_frm" method="get" action="../order/order_export_popup" target="export_popup">
	</form>
</div>
<!-- ????????? ??? ???-->
<div id="goods_matching_dialog"></div>
<div id="sendPopup"><div id="sms_form"></div></div>
<div id="choice_goods_selected_"></div>
<!-- ???????????? ????????? -->
<div id="order_refund_layer" class="hide"></div>
<div id="sendPopup2" class="hide"></div>
<div id="logManual" class="hide"></div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>