<?php /* Template_ 2.2.6 2022/05/17 12:29:24 /www/music_brother_firstmall_kr/selleradmin/skin/default/order/view.html 000115914 */ 
$TPL_able_step_action_1=empty($TPL_VAR["able_step_action"])||!is_array($TPL_VAR["able_step_action"])?0:count($TPL_VAR["able_step_action"]);
$TPL_child_order_seq_1=empty($TPL_VAR["child_order_seq"])||!is_array($TPL_VAR["child_order_seq"])?0:count($TPL_VAR["child_order_seq"]);
$TPL_data_export_1=empty($TPL_VAR["data_export"])||!is_array($TPL_VAR["data_export"])?0:count($TPL_VAR["data_export"]);
$TPL_data_refund_1=empty($TPL_VAR["data_refund"])||!is_array($TPL_VAR["data_refund"])?0:count($TPL_VAR["data_refund"]);
$TPL_data_return_1=empty($TPL_VAR["data_return"])||!is_array($TPL_VAR["data_return"])?0:count($TPL_VAR["data_return"]);
$TPL_data_exchange_1=empty($TPL_VAR["data_exchange"])||!is_array($TPL_VAR["data_exchange"])?0:count($TPL_VAR["data_exchange"]);
$TPL_shipping_group_items_1=empty($TPL_VAR["shipping_group_items"])||!is_array($TPL_VAR["shipping_group_items"])?0:count($TPL_VAR["shipping_group_items"]);
$TPL_gift_target_goods_1=empty($TPL_VAR["gift_target_goods"])||!is_array($TPL_VAR["gift_target_goods"])?0:count($TPL_VAR["gift_target_goods"]);
$TPL_process_log_1=empty($TPL_VAR["process_log"])||!is_array($TPL_VAR["process_log"])?0:count($TPL_VAR["process_log"]);
$TPL_error_export_log_1=empty($TPL_VAR["error_export_log"])||!is_array($TPL_VAR["error_export_log"])?0:count($TPL_VAR["error_export_log"]);
$TPL_order_memo_1=empty($TPL_VAR["order_memo"])||!is_array($TPL_VAR["order_memo"])?0:count($TPL_VAR["order_memo"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/layer_stock.css" />
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

</style>

<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-orderView.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-orderExportPopup.js"></script>
<script type="text/javascript">

	var order_seq				= "<?php echo $TPL_VAR["orders"]["order_seq"]?>";
	var order_hidden			= "<?php echo $TPL_VAR["orders"]["hidden"]?>";
	var order_hidden_date		= "<?php echo $TPL_VAR["orders"]["hidden_date"]?>";
	var	order_npay				= "<?php echo $TPL_VAR["npay_use"]?>";
	var	order_pg				= "<?php echo $TPL_VAR["orders"]["pg"]?>";
	var nomatch_goods_cnt		= "<?php echo $TPL_VAR["items_tot"]["nomatch_goods_cnt"]?>";
	<!-- 2022.01.03 11??? 3??? ?????? by ????????? -->
	var private_masking			= "<?php echo $TPL_VAR["orders"]["private_masking"]?>";

	var nowDate					= "<?php echo date('Ymd')?>";
	var deposit_day				= "<?php echo date('Ymd',strtotime($TPL_VAR["orders"]["deposit_date"]))?>";
	var step					= <?php echo json_encode($TPL_VAR["orders"]["opt_step"])?>;

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
	var mode		= "<?php echo $TPL_VAR["mode"]?>";
	var pagemode	= "<?php echo $TPL_VAR["pagemode"]?>";

	
	function modify_order_memo(memo_idx){
		var text = $('#admin_memo_'+memo_idx).text();
		$("input[name='memo_idx']").val(memo_idx);
		$("textarea[name='admin_memo']").empty().html(text);
	}
	
	//???????????? ??????
	function admin_memo_delete(memo_idx){
		$.ajax({
			url: '../order_process/admin_memo_delete',
			type: 'post',
			data: { memo_idx: memo_idx, order_seq: '<?php echo $TPL_VAR["orders"]["order_seq"]?>'},
			success: function(data){
				openDialogAlert("??????????????? ?????????????????????.",400,140,function(){parent.location.reload();});
			}
		});
	}
	
	$(document).ready(function() {
		$("#memo_reg").click(function(){
			var admin_memo = $("textarea[name='admin_memo']").val();
			var memo_idx = $("input[name='memo_idx']").val();
			if(admin_memo!=''){
				$.ajax({
					url:'../order_process/admin_memo',
					type: 'post',
					data: { seq : '<?php echo $TPL_VAR["orders"]["order_seq"]?>', mname : '<?php echo $TPL_VAR["managerInfo"]["mname"]?>', manager_id : '<?php echo $TPL_VAR["managerInfo"]["manager_id"]?>',admin_memo : admin_memo, memo_idx : memo_idx},
					success: function(res){
						openDialogAlert("??????????????? ?????? ???????????????.",400,140,function(){parent.location.reload();});
					}
				});
			}else{
				openDialogAlert("?????? ????????? ??????????????????.",400,140,'parent','');
			}
		});
		
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

		$(".email_pop, .send_sms").bind("click",function(event){
			alert('?????????????????? ????????? ????????????.');
	    });
	});
</script>

<!-- ????????? ????????? ??? : ?????? -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- ????????? -->
		<div class="page-title">
			<h2>
			<?php echo $TPL_VAR["orders"]["order_seq"]?>

<?php if($TPL_VAR["orders"]["able_export"]){?>
			<a href="javascript:printOrderView('<?php echo $TPL_VAR["orders"]["order_seq"]?>', 'view')"><span class="icon-print-order"></span></a>
<?php }?>
			<?php echo $TPL_VAR["orders"]["sitetypetitle"]?> <?php if($TPL_VAR["orders"]["marketplacetitle"]){?> <?php echo $TPL_VAR["orders"]["marketplacetitle"]?> <?php }?>
<?php if($TPL_VAR["orders"]["important"]){?>
				<span class="icon-star-gray hand checked list-important important-<?php echo $TPL_VAR["orders"]["step"]?>" id="important_<?php echo $TPL_VAR["orders"]["order_seq"]?>"></span>
<?php }else{?>
				<span class="icon-star-gray hand list-important important-<?php echo $TPL_VAR["orders"]["step"]?>" id="important_<?php echo $TPL_VAR["orders"]["order_seq"]?>"></span>
<?php }?>


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
				&nbsp;&nbsp;
			</h2>
		</div>

		<!-- ?????? ?????? -->
		<ul class="page-buttons-left">
<!-- ######################## 16.12.15 gcs yjy : ???????????? ??????????????? -->
			<li><span class="btn large icon"><button type="button" onclick="location.href='<?php if(!$TPL_VAR["orders"]["able_export"]){?>company_catalog<?php }else{?>catalog<?php }?>?<?php echo $TPL_VAR["query_string"]?>';"><span class="arrowleft"></span>???????????????</button></span></li>
<?php if($TPL_VAR["orders"]["able_export"]){?>
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
<?php if($TPL_VAR["orders"]["able_export"]){?>
<?php if($TPL_VAR["items_tot"]["step25"]> 0){?>
			<li><span class="btn large icon green"><button type="button" id="goods_ready">???????????? ??????</button></span></li> ??????
<?php }?>
<?php if((!$TPL_VAR["npay_use"]||$TPL_VAR["orders"]["pg"]!='npay')&&$TPL_VAR["orders"]["step"]== 15){?>
			<li><span class="btn large icon orange"><button type="button" id="order_deposit">????????????</button></span></li>
<?php }?>
<?php if($TPL_VAR["orders"]["able_export_ea"]> 0){?>
			<li><span class="btn large icon cyanblue"><button type="button" id="goods_export">????????????</button></span></li>
<?php }?>
<?php }?>
		</ul>
	</div>
</div>
<!-- ????????? ????????? ??? : ??? -->


<div class="item-title">
????????????
<?php if($TPL_VAR["orders"]["orign_order_seq"]){?>
<span class="desc" style="font-weight:normal">(??? ????????? ?????? ?????? <strong><a href="/selleradmin/order/view?no=<?php echo $TPL_VAR["orders"]["orign_order_seq"]?>" target="_blank"><?php echo $TPL_VAR["orders"]["orign_order_seq"]?></a></strong>??? ?????? ??????????????? ????????? ???????????????.)</span>
<?php }?>
<?php if($TPL_VAR["child_order_seq"]){?>
<span class="desc" style="font-weight:normal">(??? ??????????????? ???????????? ?????? ????????? ????????? ????????? <strong><?php if($TPL_child_order_seq_1){foreach($TPL_VAR["child_order_seq"] as $TPL_V1){?><a href="/selleradmin/order/view?no=<?php echo $TPL_V1?>" target="_blank"><?php echo $TPL_V1?></a><?php }}?></strong>?????????.)</span>
<?php }?>
</div>

<!-- ???????????? ????????? : ?????? -->
<table width="100%" class="simplelist-table-style">
	<tbody>
		<tr>
<?php if($TPL_VAR["linkage_mallnames"]&&$TPL_VAR["orders"]["linkage_id"]){?>
			<th>??????</th>
<?php }else{?>
			<th>??????</th>
<?php }?>
			<th>??????</th>
			<th>????????????</th>
<?php if($TPL_VAR["linkage_mallnames"]&&$TPL_VAR["orders"]["linkage_id"]){?>
			<th>????????????</th>
<?php }?>
			<th>??????</th>
			<th>????????????</th>
			<th>??????</th>
			<th>?????????</th>
			<th>?????????</th>
			<th>????????????</th>
			<th>????????????</th>
		</tr>
	</tbody>
	<tbody>
		<tr class="center">
<?php if($TPL_VAR["linkage_mallnames"]&&$TPL_VAR["orders"]["linkage_id"]){?>
			<td><?php echo $TPL_VAR["linkage"]["linkage_name"]?></td>
<?php }?>
			<td>
<?php if($TPL_VAR["orders"]["linkage_id"]){?>
<?php if($TPL_VAR["orders"]["connector_market_name"]){?><?php echo $TPL_VAR["orders"]["connector_market_name"]?><?php }else{?>
<?php if($TPL_VAR["orders"]["linkage_id"]=='pos'){?>
					????????????
<?php }else{?>
					?????????
<?php }?>
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["orders"]["referer"]){?><a href="<?php if($TPL_VAR["orders"]["referer_naver"]){?><?php echo $TPL_VAR["orders"]["referer_naver"]?><?php }else{?><?php echo $TPL_VAR["orders"]["referer"]?><?php }?>" target="_blank"><?php }?>
				<span class="help" title="<?php echo $TPL_VAR["orders"]["referer_name"]?> <?php if($TPL_VAR["orders"]["referer_naver"]){?><?php echo $TPL_VAR["orders"]["referer_naver"]?><?php }else{?><?php echo $TPL_VAR["orders"]["referer"]?><?php }?>" style="font-size:11px;font-weight:bold;color:#006666;"><?php echo getstrcut($TPL_VAR["orders"]["referer_name"], 1,'')?></span>
<?php if($TPL_VAR["orders"]["referer"]){?></a><?php }?>
<?php if($TPL_VAR["orders"]["linkage_mallname"]){?>
<?php }?>
			</td>
			<td>
<?php if($TPL_VAR["orders"]["linkage_id"]){?>
				<?php echo $TPL_VAR["linkage_mallnames"][$TPL_VAR["orders"]["linkage_mall_code"]]?>

<?php }else{?>
				<span class="help blue bold" title="<?php echo $TPL_VAR["orders"]["linkage_mallname"]?>" style="font-size:11px;"><?php echo getstrcut($TPL_VAR["orders"]["linkage_mallname"], 1,'')?></span><?php }?>
<?php }?>
			</td>
			<td><?php echo substr($TPL_VAR["orders"]["regist_date"], 2)?></td>
<?php if($TPL_VAR["linkage_mallnames"]&&$TPL_VAR["orders"]["linkage_id"]){?>
			<td><?php echo $TPL_VAR["orders"]["linkage_order_reg_date"]?></td>
<?php }?>
			<td>
<?php if($TPL_VAR["orders"]["sitetype"]=="M"||$TPL_VAR["orders"]["sitetype"]=="OFF_M"){?><span title="?????????">???</span>
<?php }elseif($TPL_VAR["orders"]["sitetype"]=="F"||$TPL_VAR["orders"]["sitetype"]=="OFF_F"){?><span title="????????????">???</span>
<?php }elseif($TPL_VAR["orders"]["sitetype"]=="APP_ANDROID"){?><span class="icon_app_android" title="???????????????">???</span>
<?php }elseif($TPL_VAR["orders"]["sitetype"]=="APP_IOS"){?><span class="icon_app_ios" title="iOS">iOS</span>
<?php }elseif($TPL_VAR["orders"]["sitetype"]=="POS"){?><span title="??????????????????">??????</span>
<?php }else{?><span title="PC">PC</span><?php }?>
			</td>
			<td>
				<?php echo $TPL_VAR["orders"]["order_seq"]?>

<?php if($TPL_VAR["orders"]["npay_order_id"]){?><div class="ngreen bold"><?php echo $TPL_VAR["orders"]["npay_order_id"]?><span style="font-size:11px;font-weight:normal;"> (Npay????????????)</span></div><?php }?>
<?php if($TPL_VAR["orders"]["linkage_mall_order_id"]){?><div class="blue bold"><?php echo $TPL_VAR["orders"]["linkage_mall_order_id"]?>(<?php echo $TPL_VAR["linkage_mallnames"][$TPL_VAR["orders"]["linkage_mall_code"]]?>)</div><?php }?>
			</td>
			<td>
<?php if($TPL_VAR["orders"]["orign_order_seq"]||$TPL_VAR["orders"]["admin_order"]||$TPL_VAR["orders"]["person_seq"]){?>
<?php if($TPL_VAR["orders"]["orign_order_seq"]){?> ??????<?php }?>
<?php if($TPL_VAR["orders"]["admin_order"]){?> ?????????<?php }?>
<?php if($TPL_VAR["orders"]["person_seq"]){?> ?????? <?php }?>
<?php }?>
			</td>
			<td>
<?php if($TPL_VAR["members"]["member_seq"]){?>
				<div>
<?php if($TPL_VAR["members"]["type"]=='??????'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" />
<?php }elseif($TPL_VAR["members"]["type"]=='??????'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" /><?php }?>
					<?php echo $TPL_VAR["orders"]["order_user_name"]?>

<?php if($TPL_VAR["orders"]["sns_rute"]){?>
						(
						<img src="/selleradmin/skin/default/images/sns/sns_<?php echo substr($TPL_VAR["orders"]["sns_rute"], 0, 1)?>0.gif" align="absmiddle">/<span class="blue"><?php echo $TPL_VAR["members"]["group_name"]?></span>)
						<div id="snsdetailPopup1" class="absolute hide"></div>
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
			<td><?php echo $TPL_VAR["orders"]["recipient_user_name"]?></td>
			<td>
<?php if($TPL_VAR["orders"]["depositor"]){?><?php echo $TPL_VAR["orders"]["depositor"]?><?php }?>
<?php if($TPL_VAR["orders"]["npay_order_id"]){?><span class="icon-pay-npay" title="naver pay"><span>npay</span></span><?php }?> 
<?php if($TPL_VAR["orders"]["pg"]=='kakaopay'){?><span class="icon-pay-kakaopay" /><span>kakaopay</span></span><?php }else{?><?php echo $TPL_VAR["orders"]["mpayment"]?><?php }?>
<?php if($TPL_VAR["orders"]["bank_name"]){?>(<?php echo $TPL_VAR["orders"]["bank_name"]?>)<?php }?>
			</td>
			<td><?php echo substr($TPL_VAR["orders"]["deposit_date"], 2)?></td>
		</tr>
	</tbody>
</table>

<br class="table-gap" />

<div class="item-title">??????<span class="title_order_number">(<?php echo $TPL_VAR["orders"]["order_seq"]?>)</span>??? ????????? ????????????
	<span class="desc" style="font-weight:normal"> - ??? ????????? ???????????????
		<a href="../export/catalog?hsb_kind=export&header_search_keyword=<?php echo $TPL_VAR["orders"]["order_seq"]?>" target="_blank"><img src="/admin/skin/default/images/common/btn_list_release.gif" align="absmiddle" alt="?????? ????????? ????????? ???????????? ?????? ?????????????????? ???????????????"></a>?????? ????????? ??????
	</span>
</div>
<table width="100%" class="simplelist-table-style">
	<tbody>
		<tr>
			<th>?????????</th>
			<th>????????????</th>
			<th>??????????????????</th>
			<th>???????????????</th>
			<th>????????????</th>
			<th>???????????????</th>
			<th>???????????????</th>
			<th>????????????</th>
			<th>???????????? ??????</th>
		</tr>
	</tbody>
	<tbody>
<?php if($TPL_VAR["data_export"]){?>
<?php if($TPL_data_export_1){foreach($TPL_VAR["data_export"] as $TPL_V1){?>
		<tr align="center">
			<td><?php echo $TPL_V1["export_date"]?></td>
			<td>
<?php if($TPL_V1["is_bundle_export"]=='Y'){?><span class="red hand bold">[?????????(????????????)]</span><br/><?php }?>
				<?php echo $TPL_V1["export_code"]?>

			</td>
			<td><?php echo get_currency_price($TPL_V1["price"])?></td>
<?php if($TPL_V1["international"]=='domestic'){?>
			<td>
<?php if($TPL_V1["goods_kind"]=='coupon'){?>
					<div>???????????? : <?php echo $TPL_V1["coupon_serial"]?> (<?php if($TPL_V1["coupon_input_type"]=='price'){?><?php echo get_currency_price($TPL_V1["coupon_input"], 3)?><?php }else{?><?php echo number_format($TPL_V1["coupon_input"])?>???<?php }?> /
					<span class="red">?????? <?php if($TPL_V1["coupon_input_type"]=='price'){?><?php echo get_currency_price($TPL_V1["coupon_remain_value"], 3)?><?php }else{?><?php echo number_format($TPL_V1["coupon_remain_value"])?>???<?php }?></span>)</div>
<?php if(is_array($TPL_R2=$TPL_V1["mail_send_log"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
						<div><?php echo date('Y-m-d H:i',strtotime($TPL_V2["regist_date"]))?>

						<?php echo $TPL_V2["send_val"]?>[<?php if($TPL_V2["status"]=='y'){?>??????<?php }else{?>??????<?php }?>] /
						<?php echo $TPL_V1["sms_send_log"][$TPL_K2]['send_val']?>[<?php if($TPL_V1["sms_send_log"][$TPL_K2]['status']=='y'){?>??????<?php }else{?>??????<?php }?>]</div>
<?php }}?>
<?php }else{?>
<?php if($TPL_V1["delivery_number"]){?>
				<a href="<?php echo $TPL_V1["tracking_url"]?>" target="_blank"><span class="blue">
				<?php echo $TPL_V1["delivery_company_array"][$TPL_V1["delivery_company_code"]]["company"]?> <?php echo $TPL_V1["delivery_number"]?> ????????????</span></a>
<?php }else{?>
				<a href="javascript:alert('?????????????????? ????????????.');"><span class="blue">????????????</span></a>
<?php }?>
<?php if($TPL_V1["invoice_send_yn"]=='y'){?>
				<a href="javascript:printInvoiceView('<?php echo $TPL_V1["order_seq"]?>','<?php echo $TPL_V1["export_code"]?>')"><span class="icon-print-invoice"></span></a>
<?php }?>
<?php }?>
			</td>
<?php }else{?>
			<td>
<?php if($TPL_V1["international_shipping_method"]!='ups'){?>
				<a href="<?php echo get_delivery_company(get_international_method_code(strtoupper($TPL_V1["international_shipping_method"])),'url')?><?php echo $TPL_V1["international_delivery_no"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["international_delivery_no"]?> ????????????</span></a>
<?php }else{?>
				<?php echo $TPL_V1["international_delivery_no"]?> ????????????
<?php }?>
			</td>
<?php }?>
			<td><?php echo $TPL_V1["ea"]?></td>
			<td><?php if(strtotime($TPL_V1["complete_date"])> 0){?><?php echo $TPL_V1["complete_date"]?><?php }?></td>
			<td  nowrap="nowrap" >
<?php if($TPL_V1["goods_kind"]=='coupon'){?>
<?php if($TPL_V1["coupon_use_log"]){?>
						<div style="width:100%;margin-top:10px;">
							<table width="100%" class="simpledata-table-style">
							<thead>
							<tr>
								<th>?????? ??????</th>
								<th>??????(?????????)</th>
								<th>?????????</th>
							</tr>
							</thead>
							<tbody>
<?php if(is_array($TPL_R2=$TPL_V1["coupon_use_log"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
							<tr>
								<td class="center">
									<?php echo date('Y-m-d H:i',strtotime($TPL_V2["regist_date"]))?>

								</td>
								<td class="center"><?php echo $TPL_V2["coupon_use_area"]?>(<?php echo number_format($TPL_V2["address_commission"])?>%)</td>
								<td class="center"><?php if($TPL_V2["confirm_user"]){?><?php echo $TPL_V2["confirm_user"]?><?php }else{?><?php echo $TPL_V2["manager_id"]?><?php }?></td>
							</tr>
<?php }}?>
							</tbody>
							</table>
						</div>
<?php }?>
<?php }else{?>
<?php if(strtotime($TPL_V1["shipping_date"])> 0){?><?php echo $TPL_V1["shipping_date"]?><?php }?>
<?php }?>
			</td>
			<td><?php echo $TPL_V1["mstatus"]?></td>
			<td>
				<table class="order-inner-table">
					<col /><col width="40" />
					<tr>
						<td><img src="/admin/skin/default/images/common/icon/icon_ord_emn.gif" title="????????????" /></td>
						<td class="right"><?php echo get_currency_price($TPL_V1["reserve"])?></td>
					</tr>
					<tr>
						<td><img src="/admin/skin/default/images/common/icon/icon_ord_point.gif" title="?????????" /></td>
						<td class="right"><?php echo get_currency_price($TPL_V1["point"])?></td>
					</tr>
				</table>
			</td>
		</tr>
<?php }}?>
<?php }else{?>
		<tr align="center">
			<td colspan="11">?????? ????????? ????????????.</td>
		</tr>
<?php }?>


	</tbody>
</table>

<div align="center"></div>
<?php if($TPL_VAR["goods_kind_arr"]['coupon']>= 50){?>
<div style="margin:20px 0;width:100%;text-align:center;">
	<span class="btn large icon red"><button type="button" class="coupon_use_btn">?????? ???????????? ??? ?????? ?????????</button></span>
</div>
<?php }?>


<div class="item-title">??????<span class="title_order_number">(<?php echo $TPL_VAR["orders"]["order_seq"]?>)</span>??? ????????? ??????/??????/?????? ??????</div>
<table width="100%" class="simplelist-table-style">
	<tbody>
		<tr>
			<th colspan="2">??????/??????/??????</th>
			<th>?????? ??????</th>
			<th>?????? ??????</th>
			<th>?????? ??????</th>
			<th>?????????</th>
			<th>?????????</th>
			<th>?????? ?????????</th>
		</tr>
	</tbody>
	<tbody>
<?php if($TPL_VAR["data_refund"]||$TPL_VAR["data_return"]||$TPL_VAR["data_exchange"]){?>
<?php if($TPL_data_refund_1){foreach($TPL_VAR["data_refund"] as $TPL_V1){?>
		<tr class="center">
			<td>
			??????
<?php if($TPL_V1["is_return"]== 1){?>
			(??????)
<?php }else{?>
			(??????)
<?php }?>
			</td>
			<td>
			<span class="blue"><?php echo $TPL_V1["refund_code"]?></span>
			</td>
			<td><?php echo get_currency_price($TPL_V1["refund_price"])?></td>
			<td><?php echo number_format($TPL_V1["ea"])?></td>
			<td><?php echo $TPL_V1["mstatus"]?><?php if($TPL_V1["npay_flag_msg"]){?><?php echo $TPL_V1["npay_flag_msg"]?><?php }?></td>
			<td><?php echo $TPL_V1["regist_date"]?></td>
			<td><?php if($TPL_V1["refund_date"]&&$TPL_V1["refund_date"]!='0000-00-00 00:00:00'){?><?php echo $TPL_V1["refund_date"]?><?php }?></td>
			<td><?php echo $TPL_V1["mname"]?></td>
		</tr>
<?php }}?>

<?php if($TPL_data_return_1){foreach($TPL_VAR["data_return"] as $TPL_V1){?>
		<tr class="center">
			<td>
			??????
			</td>
			<td>
			<a href="../returns/view?no=<?php echo $TPL_V1["return_code"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["return_code"]?></span></a>
			</td>
			<td><?php echo get_currency_price($TPL_V1["return_price"])?></td>
			<td><?php echo number_format($TPL_V1["ea"])?></td>
			<td><?php echo $TPL_V1["mstatus"]?><?php if($TPL_V1["npay_flag_msg"]){?><?php echo $TPL_V1["npay_flag_msg"]?><?php }?></td>
			<td><?php echo $TPL_V1["regist_date"]?></td>
			<td><?php if($TPL_V1["return_date"]&&$TPL_V1["return_date"]!='0000-00-00 00:00:00'){?><?php echo $TPL_V1["return_date"]?><?php }?></td>
			<td><?php echo $TPL_V1["mname"]?></td>
		</tr>
<?php }}?>

<?php if($TPL_data_exchange_1){foreach($TPL_VAR["data_exchange"] as $TPL_V1){?>
		<tr class="center">
			<td>
			??????
			(?????????)
			</td>
			<td>
			<a href="../returns/view?no=<?php echo $TPL_V1["return_code"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["return_code"]?></span></a>
			</td>
			<td><?php echo get_currency_price($TPL_V1["return_price"])?></td>
			<td><?php echo number_format($TPL_V1["ea"])?></td>
			<td><?php echo $TPL_V1["mstatus"]?><?php if($TPL_V1["npay_flag_msg"]){?><?php echo $TPL_V1["npay_flag_msg"]?><?php }?></td>
			<td><?php echo $TPL_V1["regist_date"]?></td>
			<td><?php if($TPL_V1["return_date"]&&$TPL_V1["return_date"]!='0000-00-00 00:00:00'){?><?php echo $TPL_V1["return_date"]?><?php }?></td>
			<td><?php echo $TPL_V1["mname"]?></td>
		</tr>
<?php }}?>

<?php }else{?>
		<tr align="center">
			<td colspan="11">??????/??????/?????? ????????? ????????????.</td>
		</tr>
<?php }?>
	</tbody>
</table>

<br class="table-gap" />
<!-- ???????????? ????????? : ??? -->

<!-- ?????? ?????? ?????? -->

<div class="item-title item-title-order-item">??????????????? ????????????
<?php if($TPL_VAR["linkage_mallnames"]&&$TPL_VAR["orders"]["linkage_mall_code"]&&$TPL_VAR["orders"]["step"]< 40){?>
		<span class="fx11 red">??? ????????? <?php echo $TPL_VAR["linkage_mallnames"][$TPL_VAR["orders"]["linkage_mall_code"]]?>??? ???????????????. ????????? ?????? ?????? ??? ???????????? ?????? ????????? ????????? ????????? ??? ???????????? ????????? ???????????????.</span>
<?php }?>
</div>

<table class="order-summary-table" width="100%" border=0>
	<colgroup>
		<col /><!--????????????-->
		<col width="5%" /><!--??????-->
		<col width="5%" /><!--??????-->
		<col width="5%" /><!--?????????-->
		<col width="5%" /><!--??????-->
		<col width="5%" /><!--????????????-->
		<col width="5%" /><!--??????-->
		<col width="3%" /><!--????????????-->
		<col width="3%" /><!--????????????-->
		<col width="3%" /><!--????????????-->
		<col width="3%" /><!--????????????-->
		<col width="3%" /><!--?????????-->
		<col width="3%" /><!--??????-->
		<col width="3%" /><!--????????????-->
		<col width="8%" /><!--????????????-->
		<col width="8%" /><!--??????-->
	</colgroup>
	<thead class="oth">
		<tr>
			<th class="dark">????????????</th>
			<th class="dark">??????</th>
			<th class="dark">????????????</th>
			<th class="dark">??????</th>
			<th class="dark">????????????<br /><span class="desc">(??????)</span></th>
			<th class="dark">??????????????? <span class="helpicon2 detailDescriptionLayerBtn" title="??????????????????"></span>
				<div class="detailDescriptionLayer hide">????????? ????????? ?????? ????????????????????????. ??????/??????/?????? ??? ??????????????? ?????? ??? ????????????.</div>
						<br /><span class="desc">(???????????????)</span></th>
			<th class="dark">
				??????/??????<br/>
				<span class="helpicon2 detailDescriptionLayerBtn" title="??????/??????"></span>
<?php if(is_array($TPL_R1=config_load('order','ableStockStep'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1=='25'){?>
				<div class="detailDescriptionLayer hide">?????? = ??????-???????????????-????????????<br/>??????????????? = ????????????+????????????+????????????</div>
<?php }else{?>
				<div class="detailDescriptionLayer hide">?????? = ??????-???????????????-????????????<br/>??????????????? = ????????????+????????????+????????????+????????????</div>
<?php }?>
<?php }}?></th>
			<th class="dark">??????<br />??????</th>
			<th class="dark">??????<br />??????</th>
			<th class="dark">??????<br />??????</th>
			<th class="dark">??????<br />??????</th>
			<th class="dark">??????<br/>???</th>
			<th class="dark">??????<br />??????</th>
			<th class="dark">??????<br /><span class="helpicon" title="[???????????? ?????? ??????]<br />????????????"></span></th>
			<th class="dark">????????????</th>
			<th class="dark">??????</th>
		</tr>
	</thead>

	<tbody class="otb">
<?php if($TPL_shipping_group_items_1){$TPL_I1=-1;foreach($TPL_VAR["shipping_group_items"] as $TPL_V1){$TPL_I1++;?>
<?php if(is_array($TPL_R2=$TPL_V1["items"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if(is_array($TPL_R3=$TPL_V2["options"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>

<?php if($TPL_I2== 0&&$TPL_I1){?>
<?php if($TPL_V2["goods_type"]=='gift'){?>
					<tr class="order-item-row order-item-row-topline" bgcolor="#f6f6f6">
<?php }else{?>
					<tr class="order-item-row order-item-row-topline">
<?php }?>
<?php }else{?>
<?php if($TPL_V2["goods_type"]=='gift'){?>
					<tr class="order-item-row" bgcolor="#f6f6f6">
<?php }else{?>
					<tr class="order-item-row">
<?php }?>
<?php }?>
				<td class="info" >
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="noborder-table">
				<col width="40" /><col />
					<tr>
						<td class="left" valign="top" style="border:none;"><a href='/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>' target='_blank'><span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V2["image"]?>" /></span></a></td>
						<td class="left" valign="top" style="border:none;">
<?php if($TPL_V3["npay_product_order_id"]){?><div class="ngray bold"><?php echo $TPL_V3["npay_product_order_id"]?><span style="font-size:11px;font-weight:normal"> (Npay??????????????????)</span></div><?php }?>
<?php if($TPL_V3["order_goodstype"]){?>
							<div>
<?php if(is_array($TPL_R4=$TPL_V3["order_goodstype"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?><img src="/selleradmin/skin/default/images/design/icon_order_<?php echo $TPL_K4?>.gif" align="absmiddle" title="<?php echo $TPL_V4?>" hspace=1 vspace=1/><?php }}?>
							</div>
<?php }?>
							<div class="goods_name" >
<?php if($TPL_V2["goods_kind"]=='coupon'){?>
								<a href='../goods/social_regist?no=<?php echo $TPL_V2["goods_seq"]?>' target='_blank'>
<?php }elseif($TPL_V2["goods_type"]=='gift'){?>
								<a href='../goods/gift_regist?no=<?php echo $TPL_V2["goods_seq"]?>' target='_blank'>
<?php }else{?>
								<a href='../goods/regist?no=<?php echo $TPL_V2["goods_seq"]?>' target='_blank'>
<?php }?>
									<span class="goods_name1" style="color:#000000;">


<?php if($TPL_V1["shipping"]["provider_seq"]== 1&&$TPL_V2["provider_seq"]&&$TPL_V2["provider_seq"]!= 1){?><span class="red">[???????????? : <?php echo $TPL_V2["provider_name"]?>]</span><?php }?><?php echo $TPL_V2["goods_name"]?>

									</span>
								</a>
							</div>

							<div>
<?php if($TPL_V2["tax"]=='exempt'){?>
								<img src="/admin/skin/default/images/common/icon/taxfree.gif" alt="?????????" style="vertical-align: middle;"/>
<?php }?>
							</div>

<?php if($TPL_V2["event_seq"]&&$TPL_V2["event_title"]){?>
								<div style="padding-top:3px;">
									<span class="btn small gray"><button type="button" class="goods_event hand"><?php echo $TPL_V2["event_title"]?></button></span>
								</div>
<?php }?>

<?php if($TPL_V3["option1"]!=null){?>
							<div class="goods_option" style="padding-top:3px;">
								<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php if($TPL_V3["title1"]){?><?php echo $TPL_V3["title1"]?>:<?php }?><?php echo $TPL_V3["option1"]?>

<?php if($TPL_V3["option2"]!=null){?><?php if($TPL_V3["title2"]){?><?php echo $TPL_V3["title2"]?>:<?php }?><?php echo $TPL_V3["option2"]?><?php }?>
<?php if($TPL_V3["option3"]!=null){?><?php if($TPL_V3["title3"]){?><?php echo $TPL_V3["title3"]?>:<?php }?><?php echo $TPL_V3["option3"]?><?php }?>
<?php if($TPL_V3["option4"]!=null){?><?php if($TPL_V3["title4"]){?><?php echo $TPL_V3["title4"]?>:<?php }?><?php echo $TPL_V3["option4"]?><?php }?>
<?php if($TPL_V3["option5"]!=null){?><?php if($TPL_V3["title5"]){?><?php echo $TPL_V3["title5"]?>:<?php }?><?php echo $TPL_V3["option5"]?><?php }?>
							</div>
<?php }?>

<?php if($TPL_V3["inputs"]){?>
<?php if(is_array($TPL_R4=$TPL_V3["inputs"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
<?php if($TPL_V4["value"]){?>
							<div class="goods_input" style="padding-top:3px;">
								<img src="/admin/skin/default/images/common/icon_input.gif" />
<?php if($TPL_V4["title"]){?><?php echo $TPL_V4["title"]?>:<?php }?>
<?php if($TPL_V4["type"]=='file'){?>
								<img src="/data/order/<?php echo $TPL_V4["value"]?>" style="width:25px;" align="absmiddle">
								<a href="../order_process/filedown?file=<?php echo $TPL_V4["value"]?>" target="actionFrame"><?php echo $TPL_V4["value"]?></a>
<?php }else{?><?php echo $TPL_V4["value"]?><?php }?>
							</div>
<?php }?>
<?php }}?>
<?php }?>

							<div>
								<!-- ????????? ????????? ?????? : ????????????(????????? ???)??? ?????? -->
<?php if(!$TPL_VAR["linkage_mallnames"]&&!$TPL_VAR["orders"]["linkage_mall_code"]&&$TPL_VAR["orders"]["orign_order_seq"]&&$TPL_VAR["orders"]["step"]== 25&&(!$TPL_VAR["npay_use"]||($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]['pg']!='npay'))&&$TPL_V3["package_yn"]!='y'){?>
								<span class="btn small cyanblue" onclick="set_goods_list('<?php echo $TPL_VAR["orders"]["member_seq"]?>','<?php echo $TPL_V3["item_seq"]?>','<?php echo $TPL_V3["item_option_seq"]?>','reorder')"><button type="button">??????</button></span>
<?php }?>

							<!-- ????????????????????? ????????? ????????? ??????/??????????????? ????????? ?????? ?????? -->
<?php if((!$TPL_V2["goods_seq"]||$TPL_V3["nomatch"]> 0)&&$TPL_V3["step"]< 40&&$TPL_V2["goods_type"]!='gift'){?>
									<span class="btn small cyanblue" onclick="set_goods_list('<?php echo $TPL_VAR["orders"]["member_seq"]?>','<?php echo $TPL_V3["item_seq"]?>','<?php echo $TPL_V3["item_option_seq"]?>','rematch')"><button type="button">??????</button></span>
<?php }?>

<?php if($TPL_V2["goods_type"]=="gift"){?>
<?php if($TPL_V2["gift_title"]){?><div><span class="fx11"><?php echo $TPL_V2["gift_title"]?></span> <span class="btn small gray"><button type="button" class="gift_log" order_seq="<?php echo $TPL_V2["order_seq"]?>" item_seq="<?php echo $TPL_V2["item_seq"]?>">?????????</button></span></div><?php }?>
<?php }?>
							</div>

<?php if($TPL_V3["package_yn"]!='y'){?>
							<div class="warehouse-info-lay">
							<ul>
<?php if($TPL_V3["whinfo"]["wh_name"]){?>
								<li>
								<?php echo $TPL_V3["whinfo"]["wh_name"]?> <?php if($TPL_V3["whinfo"]["location_code"]){?>(<?php echo $TPL_V3["whinfo"]["location_code"]?>)<?php }?> : <?php echo number_format($TPL_V3["whinfo"]["ea"])?>(<?php echo number_format($TPL_V3["whinfo"]["badea"])?>)
								</li>
<?php }?>
								<li>???????????? : <?php echo $TPL_V3["goods_code"]?></li>
							</ul>
							</div>
<?php }?>
						</td>
					</tr>
					</table>
				</td>
				<td class="center info ea"><?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V3["ea"]?><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?></td>
				<td class="price info"><?php echo get_currency_price($TPL_V3["out_price"])?></td>
				<td class="price info">
					<div class="hand underline under_div_view">
						<?php echo get_currency_price($TPL_V3["out_tot_sale"])?>

						<div class="absolute under_div_view_contents  hide">
							<div class="sale_price_layer" style="width:400px;">
								<div class="title_line">????????????</div>
								<br style="line-height:10px;" />
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<col width="55" />
								<col width="115" />
								<col width="70" />
								<col width="70" />
								<col />
								<tr>
									<th colspan="2">??????</th>
									<th class="bolds">??????</th>
									<th>?????? ??????</th>
									<th class="ends">????????? ??????</th>
								</tr>
								<tr>
									<td class="gr">?????????</td>
									<td class="gr"></td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V3["out_event_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_event_sale"]-$TPL_V3["event_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V3["event_provider"])?>

									</td>
								</tr>

								<tr>
									<td class="gr">????????????</td>
									<td class="gr"></td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V3["out_multi_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_multi_sale"]-$TPL_V3["multi_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V3["multi_provider"])?>

									</td>
								</tr>
								<tr>
									<td class="gr">??????</td>
									<td class="gr">
<?php if($TPL_V3["out_coupon_sale"]> 0){?>
											<div class="url-ctrl underline"><a href="javascript:open_saleinfo_layer('coupon_down','<?php echo $TPL_V3["download_seq"]?>','<?php echo $TPL_V3["item_option_seq"]?>')"><?php echo $TPL_V3["coupon_info"]["coupon_name"]?></div>
<?php }?>
<?php if($TPL_V3["unit_ordersheet"]> 0){?>
											<div class="url-ctrl underline"><a href="javascript:open_saleinfo_layer('coupon_down','<?php echo $TPL_VAR["orders"]["ordersheet_seq"]?>','')"><?php echo $TPL_VAR["orders"]["ordersheet_coupon_info"]["coupon_name"]?></div>
<?php }?>
									</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V3["out_coupon_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_coupon_sale"]-$TPL_V3["coupon_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V3["coupon_provider"])?>

									</td>
								</tr>

								<tr>
									<td class="gr">??????</td>
									<td class="gr"><?php if($TPL_V3["out_member_sale"]> 0){?><?php echo $TPL_VAR["members"]["group_name"]?><?php }?></td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V3["out_member_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_member_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
								</tr>

								<tr>
									<td class="gr">?????????</td>
									<td class="gr"></td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V3["out_mobile_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_mobile_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
								</tr>

								<tr>
									<td class="gr">??????</td>
									<td class="gr">
<?php if($TPL_V3["out_promotion_code_sale"]> 0){?>
											<div class="url-ctrl underline"><a href="javascript:open_saleinfo_layer('promotion_code','<?php echo $TPL_V3["promotion_code_seq"]?>','<?php echo $TPL_V3["item_option_seq"]?>')"><?php echo $TPL_V3["promotion_info"]["promotion_name"]?></a></div>
<?php }?>
									</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V3["out_promotion_code_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_promotion_code_sale"]-$TPL_V3["promotion_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V3["promotion_provider"])?>

									</td>
								</tr>

								<tr>
									<td class="gr">??????</td>
									<td class="gr">
<?php if($TPL_V3["out_referer_sale"]> 0){?>
											<div class="url-ctrl underline">
												<a target="_blank" href="<?php if($TPL_VAR["orders"]["referer_naver"]){?><?php echo $TPL_VAR["orders"]["referer_naver"]?><?php }else{?><?php echo $TPL_VAR["orders"]["referer"]?><?php }?>"><?php echo $TPL_VAR["orders"]["referer_domain"]?></a>
												<div class="absolute url-helper" style="padding:1px 4px;display: none;"><a target="_blank" href="<?php if($TPL_VAR["orders"]["referer_naver"]){?><?php echo $TPL_VAR["orders"]["referer_naver"]?><?php }else{?><?php echo $TPL_VAR["orders"]["referer"]?><?php }?>"><?php if($TPL_VAR["orders"]["referer_naver"]){?><?php echo $TPL_VAR["orders"]["referer_naver"]?><?php }else{?><?php echo $TPL_VAR["orders"]["referer"]?><?php }?></a></div>
											</div>
<?php }?>
									</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V3["out_referer_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_referer_sale"]-$TPL_V3["referer_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V3["referer_provider"])?>

									</td>
								</tr>
								<tr>
									<td class="gr">????????????</td>
									<td class="gr">
										
									</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V3["out_emoney_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_emoney_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
								</tr>
								<tr>
									<td class="gr">?????????</td>
									<td class="gr"></td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V3["out_enuri_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_enuri_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
								</tr>
								
								</table>
							</div>
						</div>
					</div>
					<span class="desc normal">(<?php echo get_currency_price($TPL_V3["tot_sale_provider"])?>)</span>
				</td>
				<td class="price info"><?php echo get_currency_price($TPL_V3["out_sale_price"])?><br /><span class="desc normal">(<?php echo get_currency_price($TPL_V3["sale_price"])?>)</span></td>
				<td class="price info">
<?php if($TPL_V3["reserve_log"]){?>
					<div class="under_div_view hand underline">
						<?php echo get_currency_price($TPL_V3["out_reserve"])?>

						<div class="absolute hide under_div_view_contents">
							<div class="sale_price_layer" style="width:150px;">
								<div class="title_line">??????????????????</div>
								<br style="line-height:10px;" />
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<col width="70" />
									<tr>
										<td class="ends">
<?php if(is_array($TPL_R4=$TPL_V3["reserve_log"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
										<?php echo $TPL_V4?> * <?php echo $TPL_V3["ea"]?>&nbsp;&nbsp;
<?php }}?>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
<?php }else{?>
					<div>
					<?php echo get_currency_price($TPL_V3["out_reserve"])?>

					</div>
<?php }?>

<?php if($TPL_V3["point_log"]){?>
					<div class="under_div_view hand underline">
						<span class="desc underline">(<?php echo get_currency_price($TPL_V3["out_point"])?>)</span>
						<div class="absolute hide under_div_view_contents">
							<div class="sale_price_layer" style="width:150px;">
								<div class="title_line">???????????????</div>
								<br style="line-height:10px;" />
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<col width="70" />
									<tr>
										<td class="ends">
<?php if(is_array($TPL_R4=$TPL_V3["point_log"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
										<?php echo $TPL_V4?> * <?php echo $TPL_V3["ea"]?>&nbsp;&nbsp;
<?php }}?>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
<?php }else{?>
					<div>
					<span class="desc">(<?php echo get_currency_price($TPL_V3["out_point"])?>)</span>
					</div>
<?php }?>
				</td>
				<td class="info">
<?php if($TPL_V3["package_yn"]=='y'){?>
					<div class="center"><span class="fx11 dotum blue">???????????????</span></div>
<?php }else{?>
				<div class="right">
<?php if($TPL_V3["real_stock"]!='?????????'){?>
<?php if($TPL_V3["real_stock"]> 0){?>
							<span class="blue"><?php echo number_format($TPL_V3["real_stock"])?></span>
<?php }else{?>
							<span class="red"><?php echo $TPL_V3["real_stock"]?></span>
<?php }?>
<?php }else{?>
						<span class="red"><?php echo $TPL_V3["real_stock"]?></span>
<?php }?>
				</div>
				<div class="right">
<?php if($TPL_V3["stock"]!='?????????'){?>
<?php if($TPL_V3["stock"]> 0){?>
						<span class="blue bold"><?php echo number_format($TPL_V3["stock"])?></span>
<?php }else{?>
						<span class="red bold"><?php echo number_format($TPL_V3["stock"])?></span>
<?php }?>
<?php }else{?>
						<span class="red"><?php echo $TPL_V3["stock"]?></span>
<?php }?>
				</div>
					<div class="right">
						<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V2["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_V3["provider_seq"]?>'<?php }else{?>'2'<?php }?>)" option_code1="<?php echo $TPL_V3["option1"]?>" option_code2="<?php echo $TPL_V3["option2"]?>" option_code3="<?php echo $TPL_V3["option3"]?>" option_code4="<?php echo $TPL_V3["option4"]?>" option_code5="<?php echo $TPL_V3["option5"]?>">
							<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V3["option_seq"]?>"></span>
							<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V2["goods_seq"]?>"><span class="hide">??????</span></span>
						</span>
					</div>
<?php }?>
				</td>
				<td class="info ea" align="center"><?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V3["step25"])?><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info ea" align="center"><?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V3["step35"])?><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info ea" align="center"><?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V3["step45"])?><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info ea" align="center"><?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V3["step55"])?><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info ea" align="center"><?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V3["step65"])?><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?></td>
				<td align="center" class="info ea">
<?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V3["step75"]?><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?>
<?php if($TPL_V3["cancel_list_ea"]||$TPL_V3["exchange_list_ea"]||$TPL_V3["return_list_ea"]||$TPL_V3["refund_list_ea"]){?>
					<div>
<?php if($TPL_V3["exchange_list_ea"]){?>
						<a href="/selleradmin/returns/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return_exchange.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V3["exchange_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V3["return_list_ea"]){?>
						<a href="../returns/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V3["return_list_ea"]?></span></a>
						<a href="../refund/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_refund.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V3["return_list_ea"]?></span></a>
<?php }?>
					</div>
<?php }?>
				</td>
				<td class="info ea" align="center"><?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V3["step85"]?><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info fx11" align="center">
<?php if($TPL_V3["step"]<= 45||$TPL_V3["step"]> 75){?>
						<?php echo $TPL_V3["mstep"]?>

<?php }else{?>
					<div class="under_div_view hand underline">
						<?php echo $TPL_V3["mstep"]?>

						<div class="absolute hide under_div_view_contents">

							<div class="sale_price_layer" style="width:150px;">
								<div class="title_line">????????????</div>
								<br style="line-height:10px;" />
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<col width="70" />
								<col width="70" />
								<col />
								<tr>
									<th>??????</th>
									<th class="bolds ends">??????</th>
								</tr>
								<tr>
									<td class="gr">????????????</td>
									<td class="bolds  prices ends">
										<?php echo number_format($TPL_V3["export_sum_ea"]["delivery"])?>

									</td>
								</tr>
								<tr>
									<td class="gr">????????????</td>
									<td class="bolds  prices ends">
										<?php echo number_format($TPL_V3["export_sum_ea"]["postpaid"])?>

									</td>
								</tr>
								<tr>
									<td class="gr">????????????</td>
									<td class="bolds  prices ends">
										<?php echo number_format($TPL_V3["export_sum_ea"]["quick"])?>

									</td>
								</tr>
								<tr>
									<td class="gr">????????????</td>
									<td class="bolds  prices ends">
										<?php echo number_format($TPL_V3["export_sum_ea"]["direct"])?>

									</td>
								</tr>
								</table>
							</div>

						</div>
					</div>
<?php }?>
<?php if($TPL_V2["goods_kind"]=='coupon'&&$TPL_V3["step"]>= 55){?>
					<span class="btn"><img src="/admin/skin/default/images/common/btn_ok_use.gif" class="coupon_use_btn" order_seq="<?php echo $TPL_V2["order_seq"]?>" /></span>
<?php }?>
				</td>
<?php if($TPL_V3["shipping_division"]){?>
					<td class="info" align="right" rowspan="<?php echo $TPL_V1["rowspan"]?>" class="fx11">
					<div class="blue">
<?php if($TPL_V1["shipping"]["provider_seq"]== 1){?>
						??????
<?php }else{?>
						<?php echo $TPL_V1["shipping"]["provider_name"]?>

<?php }?>
					</div>


<?php if($TPL_VAR["orders"]["sitetype"]=="POS"){?>
						<!-- ????????? ????????? ?????? POS ????????? ??????????????? ????????? ?????? ????????? ????????? -->
						<div class="lsp-1">[<?php echo $TPL_V1["shipping"]["shipping_set_name"]?>]<?php echo $TPL_V1["shipping"]["shipping_store_name"]?></div>
<?php }else{?>
<?php if(preg_match('/gift/',$TPL_V1["shipping"]["shipping_group"])){?>
								???????????????
<?php }else{?>
						<div>
							<span><?php if($TPL_V1["shipping"]["shipping_method_name"]=='??????'){?>??????<?php }else{?><?php echo $TPL_V1["shipping"]["shipping_set_name"]?><?php }?></span>
<?php if($TPL_VAR["orders"]["international_country"]){?><span class="pdl5 lsp-1"><?php echo $TPL_VAR["orders"]["international_country"]?></span><?php }?>
						</div>
	
<?php if($TPL_V1["shipping"]["shipping_set_code"]=='direct_store'){?>
						<div class="lsp-1">???????????? : <?php echo $TPL_V1["shipping"]["shipping_store_name"]?></div>
<?php }else{?>
	
	
						<div class="detailDescriptionLayerBtn hand" title="????????? ??????">
							<span class="bold">
<?php if($TPL_V1["shipping"]["shipping_cost"]> 0){?>
								<?php echo get_currency_price($TPL_V1["shipping"]["shipping_cost"], 3)?>

<?php }elseif($TPL_V1["shipping"]["postpaid"]> 0){?>
									<?php echo get_currency_price($TPL_V1["shipping"]["postpaid"], 3)?>

<?php }else{?>
								??????
<?php }?>
							</span>
<?php if($TPL_V1["shipping"]["shipping_cost"]> 0||$TPL_V1["shipping"]["postpaid"]> 0){?>
<?php if($TPL_V1["shipping"]["shipping_pay_type"]){?><span class="lsp-1">(<?php echo $TPL_V1["shipping"]["shipping_pay_type"]?>)</span><?php }?>
<?php }?> 
						</div>
						<!-- ????????? ?????? ?????? -->
						<div class="detailDescriptionLayer hide" style="width:180px;margin-left:-100px;">
<?php if($TPL_V1["shipping"]["shipping_cost"]> 0||$TPL_V1["shipping"]["postpaid"]> 0){?>
								???????????????: <?php echo get_currency_price($TPL_V1["shipping"]["delivery_cost"], 3)?><br/>
								???????????????: <?php echo get_currency_price($TPL_V1["shipping"]["add_delivery_cost"], 3)?><br/>
								???????????????: <?php echo get_currency_price($TPL_V1["shipping"]["hop_delivery_cost"], 3)?><br/>
<?php }else{?>
									????????????
<?php }?>
						</div>
<?php }?>

<?php }?>
	
<?php if($TPL_V1["shipping"]["shipping_hop_date"]){?>
					<div class="lsp-1">??????????????? : <?php echo $TPL_V1["shipping"]["shipping_hop_date"]?></div>
<?php }elseif($TPL_V1["shipping"]["reserve_sdate"]){?>
					<div class="lsp-1">??????????????? : <?php echo $TPL_V1["shipping"]["reserve_sdate"]?></div>
<?php }?>

<?php if($TPL_V1["shipping"]["shipping_coupon_sale"]> 0){?>
							<div class="desc">-<?php echo get_currency_price($TPL_V1["shipping"]["shipping_coupon_sale"], 3)?> ??????</div>
<?php }?>
<?php if($TPL_V1["shipping"]["shipping_promotion_code_sale"]> 0){?>
							<div class="desc">-<?php echo get_currency_price($TPL_V1["shipping"]["shipping_promotion_code_sale"], 3)?> ??????</div>
<?php }?>
<?php }?>
					</td>
<?php }?>
			</tr>

<?php if(is_array($TPL_R4=$TPL_V3["packages"])&&!empty($TPL_R4)){$TPL_I4=-1;foreach($TPL_R4 as $TPL_V4){$TPL_I4++;?>
			<tr class="order-item-row">
				<td class="package-option" style="padding-left:22px;">

					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<col /><col />
					<tr>
						<td valign="top" style="border:none;"><img src="/admin/skin/default/images/common/icon/ico_package.gif" border="0" /></td>
						<td class="left" valign="top" style="border:none;">
							<a href='/goods/view?no=<?php echo $TPL_V4["goods_seq"]?>' target='_blank'><span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V4["image"]?>" /></span></a>
						</td>
						<td class="left" valign="top" style="border:none;">
							<div class="goods_name">
<?php if($TPL_V4["goods_kind"]=='coupon'){?>
								<a href='../goods/social_regist?no=<?php echo $TPL_V4["goods_seq"]?>' target='_blank'>
<?php }else{?>
								<a href='../goods/regist?no=<?php echo $TPL_V4["goods_seq"]?>' target='_blank'>
<?php }?>
									<span class="title">[???????????? <?php echo $TPL_I4+ 1?>]</span>
									<span class="goods_name1 title">
									<?php echo $TPL_V4["goods_name"]?>

									</span>
								</a>
							</div>
							<div>
<?php if($TPL_V4["adult_goods"]=='Y'){?>
								<img src="/admin/skin/default/images/common/auth_img.png" alt="??????" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V4["option_international_shipping_status"]=='y'){?>
								<img src="/admin/skin/default/images/common/icon/plane_on.png" alt="??????????????????" style="vertical-align: middle;" height="19" />
<?php }?>
<?php if($TPL_V4["cancel_type"]=='1'){?>
								<img src="/admin/skin/default/images/common/icon/nocancellation.gif" alt="????????????" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V4["tax"]=='exempt'){?>
								<img src="/admin/skin/default/images/common/icon/taxfree.gif" alt="?????????" style="vertical-align: middle;"/>
<?php }?>
							</div>

<?php if($TPL_V4["event_seq"]&&$TPL_V4["event_title"]){?>
							<div style="padding-top:3px;">
								<a href="/admin/event/<?php if($TPL_V4["event_type"]=='solo'){?>solo<?php }?>regist?event_seq=<?php echo $TPL_V4["event_seq"]?>" target='_blank'><span class="btn small gray"><button type="button" class="goods_event hand"><?php echo $TPL_V4["event_title"]?></button></span></a>
							</div>
<?php }?>
<?php if($TPL_V4["option1"]!=null){?>
							<div class="goods_option" style="padding-top:3px;">
								<img src="/admin/skin/default/images/common/icon_option.gif" align="absmiddle" />
<?php if($TPL_V4["title1"]){?><?php echo $TPL_V4["title1"]?>:<?php }?><?php echo $TPL_V4["option1"]?>

<?php if($TPL_V4["option2"]!=null){?><?php if($TPL_V4["title2"]){?><?php echo $TPL_V4["title2"]?>:<?php }?><?php echo $TPL_V4["option2"]?><?php }?>
<?php if($TPL_V4["option3"]!=null){?><?php if($TPL_V4["title3"]){?><?php echo $TPL_V4["title3"]?>:<?php }?><?php echo $TPL_V4["option3"]?><?php }?>
<?php if($TPL_V4["option4"]!=null){?><?php if($TPL_V4["title4"]){?><?php echo $TPL_V4["title4"]?>:<?php }?><?php echo $TPL_V4["option4"]?><?php }?>
<?php if($TPL_V4["option5"]!=null){?><?php if($TPL_V4["title5"]){?><?php echo $TPL_V4["title5"]?>:<?php }?><?php echo $TPL_V4["option5"]?><?php }?>
							</div>
<?php }?>

<?php if($TPL_V4["inputs"]){?>
<?php if(is_array($TPL_R5=$TPL_V4["inputs"])&&!empty($TPL_R5)){foreach($TPL_R5 as $TPL_V5){?>
<?php if($TPL_V5["value"]){?>
							<div class="goods_input" style="padding-top:3px;">
								<img src="/admin/skin/default/images/common/icon_input.gif" align="absmiddle" />
<?php if($TPL_V5["title"]){?><?php echo $TPL_V5["title"]?>:<?php }?>
<?php if($TPL_V5["type"]=='file'){?>
								<a href="../order_process/filedown?file=<?php echo $TPL_V5["value"]?>" target="actionFrame"><?php echo $TPL_V5["value"]?></a>
<?php }else{?><?php echo $TPL_V5["value"]?><?php }?>
							</div>
<?php }?>
<?php }}?>
<?php }?>

							<div class="warehouse-info-lay">
							<ul>
<?php if($TPL_V4["whinfo"]["wh_name"]){?>
								<li>
								<?php echo $TPL_V4["whinfo"]["wh_name"]?> <?php if($TPL_V4["whinfo"]["location_code"]){?>(<?php echo $TPL_V4["whinfo"]["location_code"]?>)<?php }?> : <?php echo number_format($TPL_V4["whinfo"]["ea"])?>(<?php echo number_format($TPL_V4["whinfo"]["badea"])?>)
								</li>
<?php }?>
								<li>???????????? : <?php echo $TPL_V4["goods_code"]?></li>
							</ul>
							</div>
						</td>
					</tr>
					</table>
				</td>
				<td class="package-option center">
					<div>
						<span class="ea">[<?php echo number_format($TPL_V3["ea"])?>]</span>x<?php echo number_format($TPL_V4["unit_ea"])?>=<?php echo number_format($TPL_V3["ea"]*$TPL_V4["unit_ea"])?>

					</div>
					<div class="center">
						<span class="helpicon" title="?????? ???????????? ???????????? 1????????? ?????? ??????????????? ????????????"></span>
					</div>
				</td>
				<td class="package-option center">-</td>
				<td class="package-option center">-</td>
				<td class="package-option center">-</td>
				<td class="package-option center">-</td>
				<td class="package-option center">-</td>
				<td class="price package-option">
<?php if($TPL_V4["stock"]==='?????????'){?>
						<div class="red">?????????</span>
						<div class="red">?????????</span>
<?php }else{?>
					<div class="stock"><?php echo number_format($TPL_V4["stock"])?></div>
					<div class="ablestock"><?php echo number_format($TPL_V4["ablestock"])?></div>
<?php }?>
					<div class="right">
						<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V4["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_V3["provider_seq"]?>'<?php }else{?>'2'<?php }?>)" option_code1="{=.....option1}" option_code2="{=.....option2}" option_code3="{=.....option3}" option_code4="{=.....option4}" option_code5="{=.....option5}">
							<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V4["option_seq"]?>"></span>
							<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V4["goods_seq"]?>"><span class="hide">??????</span></span>
						</span>
					</div>
				</td>
				<td class="package-option center">
					<span class="ea"><?php echo number_format($TPL_V4["unit_ea"]*$TPL_V3["step25"])?></span>
				</td>
				<td class="package-option center">
					<span class="ea"><?php echo number_format($TPL_V4["unit_ea"]*$TPL_V3["step35"])?></span>
				</td>
				<td class="package-option center">
					<span class="ea"><?php echo number_format($TPL_V4["unit_ea"]*$TPL_V3["step45"])?></span>
				</td>
				<td class="package-option center">
					<span class="ea"><?php echo number_format($TPL_V4["unit_ea"]*$TPL_V3["step55"])?></span>
				</td>
				<td class="package-option center">
					<span class="ea"><?php echo number_format($TPL_V4["unit_ea"]*$TPL_V3["step65"])?></span>
				</td>
				<td class="package-option center">
					<span class="ea"><?php echo number_format($TPL_V4["unit_ea"]*$TPL_V3["step75"])?></span>
				</td>
				<td class="package-option center">
					<span class="ea"><?php echo number_format($TPL_V4["unit_ea"]*$TPL_V3["step85"])?></span>
				</td>
				<td class="package-option center">-</td>
			</tr>
<?php }}?>

<?php if(is_array($TPL_R4=$TPL_V3["suboptions"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
			<tr class="order-item-row">
				<td class="info suboption" style="padding-left:25px;">
<?php if($TPL_V4["suboption"]){?>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<col width="40" /><col />
					<tr>
						<td valign="top" align="right" style="border:none;height:10px;"><img src="/admin/skin/default/images/common/icon_add_arrow.gif" /></td>
						<td valign="top" style="border:none;height:10px;">
<?php if($TPL_V4["npay_product_order_id"]){?><div class="ngray bold"><?php echo $TPL_V4["npay_product_order_id"]?><span style="font-size:11px;font-weight:normal"> (Npay??????????????????)</span></div><?php }?>
							<img src="/admin/skin/default/images/common/icon_add.gif" align="absmiddle" />
							<span class="desc"><?php echo $TPL_V4["title"]?>:<?php echo $TPL_V4["suboption"]?></span>
<?php if($TPL_V4["package_yn"]!='y'){?>
								<div class="warehouse-info-lay">
								<ul>
<?php if($TPL_V4["whinfo"]["wh_name"]){?>
									<li>
									<?php echo $TPL_V4["whinfo"]["wh_name"]?> <?php if($TPL_V4["whinfo"]["location_code"]){?>(<?php echo $TPL_V4["whinfo"]["location_code"]?>)<?php }?> : <?php echo number_format($TPL_V4["whinfo"]["ea"])?>(<?php echo number_format($TPL_V4["whinfo"]["badea"])?>)
									</li>
<?php }?>
									<li>???????????? : <?php echo $TPL_V4["goods_code"]?></li>
								</ul>
								</div>
<?php }?>
						</td>
					</tr>
				</table>
<?php }?>

				</td>
				<td class="center info suboption ea"><?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V4["ea"])?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?></td>
				<td class="price info suboption"><?php echo get_currency_price($TPL_V4["out_price"])?></td>
				<td class="price info suboption">
					<div class="under_div_view hand underline">
						<?php echo get_currency_price($TPL_V4["out_tot_sale"])?>

						<div class="absolute under_div_view_contents  hide">
							<div class="sale_price_layer" style="width:300px;">
								<div class="title_line">????????????</div>
								<br style="line-height:10px;" />
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<col width="70" />
								<col width="70" />
								<col width="70" />
								<col />
								<tr>
									<th>??????</th>
									<th class="bolds">??????</th>
									<th>?????? ??????</th>
									<th class="ends">????????? ??????</th>
								</tr>
								<tr>
									<td class="gr">?????????</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V4["out_event_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V4["out_event_sale"]-$TPL_V4["event_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V4["event_provider"])?>

									</td>
								</tr>

								<tr>
									<td class="gr">????????????</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V4["out_multi_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V4["out_multi_sale"])?>

									</td>
									<td class="ends prices">0
									</td>
								</tr>
								<tr>
									<td class="gr">??????</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V4["out_coupon_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V4["out_coupon_sale"]-$TPL_V4["coupon_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V4["coupon_provider"])?>

									</td>
								</tr>

								<tr>
									<td class="gr">??????</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V4["out_member_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V4["out_member_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
								</tr>

								<tr>
									<td class="gr">?????????</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V4["out_mobile_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V4["out_mobile_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
								</tr>

								<tr>
									<td class="gr">??????</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V4["out_promotion_code_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V4["out_promotion_code_sale"]-$TPL_V4["promotion_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V4["promotion_provider"])?>

									</td>
								</tr>

								<tr>
									<td class="gr">??????</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V4["out_referer_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V4["out_referer_sale"]-$TPL_V4["referer_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V4["referer_provider"])?>

									</td>
								</tr>
								<tr>
									<td class="gr">????????????</td>
									<td class="gr">
										
									</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V4["out_emoney_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V4["out_emoney_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
								</tr>
								<tr>
									<td class="gr">?????????</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V4["out_enuri_sale"])?>

									</td>
									<td class="prices">
										<?php echo get_currency_price($TPL_V4["out_enuri_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
								</tr>
								
								</table>
							</div>
						</div>
					</div>
					<span class="desc normal">(<?php echo get_currency_price($TPL_V4["tot_sale_provider"])?>)</span>
				</td>
				<td class="price info suboption"><?php echo get_currency_price($TPL_V4["out_sale_price"])?><br /><span class="desc normal">(<?php echo get_currency_price($TPL_V4["sale_price"])?>)</span></td>

				<td class="price info suboption">
<?php if($TPL_V4["reserve_log"]){?>
					<div class="under_div_view hand underline">
						<?php echo get_currency_price($TPL_V4["out_reserve"])?>

						<div class="absolute hide under_div_view_contents">
							<div class="sale_price_layer" style="width:150px;">
								<div class="title_line">??????????????????</div>
								<br style="line-height:10px;" />
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<col width="70" />
									<tr>
										<td class="ends">
<?php if(is_array($TPL_R5=$TPL_V4["reserve_log"])&&!empty($TPL_R5)){foreach($TPL_R5 as $TPL_V5){?>
										<?php echo $TPL_V5?> * <?php echo $TPL_V3["ea"]?>&nbsp;&nbsp;
<?php }}?>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
<?php }else{?>
					<div><?php echo get_currency_price($TPL_V4["out_reserve"])?></div>
<?php }?>

<?php if($TPL_V4["point_log"]){?>
					<div class="under_div_view hand underline">
						<span class="desc underline">(<?php echo get_currency_price($TPL_V4["out_point"])?>)</span>
						<div class="absolute hide under_div_view_contents">
							<div class="sale_price_layer" style="width:150px;">
								<div class="title_line">???????????????</div>
								<br style="line-height:10px;" />
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<col width="70" />
									<tr>
										<td class="ends">
<?php if(is_array($TPL_R5=$TPL_V4["point_log"])&&!empty($TPL_R5)){foreach($TPL_R5 as $TPL_V5){?>
										<?php echo $TPL_V5?> * <?php echo $TPL_V3["ea"]?>&nbsp;&nbsp;
<?php }}?>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
<?php }else{?>
					<div>
					<span class="desc">(<?php echo get_currency_price($TPL_V4["out_point"])?>)</span>
					</div>
<?php }?>
				</td>
				<td class="info suboption">
<?php if($TPL_V4["package_yn"]=='y'){?>
					<div class="center"><span class="fx11 dotum blue">???????????????</span></div>
<?php }else{?>
				<div class="right">
<?php if($TPL_V4["real_stock"]!='?????????'){?>
<?php if($TPL_V4["real_stock"]> 0){?>
							<span class="blue"><?php echo number_format($TPL_V4["real_stock"])?></span>
<?php }else{?>
							<span class="red"><?php echo $TPL_V4["real_stock"]?></span>
<?php }?>
<?php }else{?>
						<span class="red"><?php echo $TPL_V4["real_stock"]?></span>
<?php }?>
				</div>
				<div class="right">
<?php if($TPL_V4["stock"]!='?????????'){?>
<?php if($TPL_V4["stock"]> 0){?>
						<span class="blue bold"><?php echo number_format($TPL_V4["stock"])?></span>
<?php }else{?>
						<span class="red bold"><?php echo number_format($TPL_V4["stock"])?></span>
<?php }?>
<?php }else{?>
						<span class="red"><?php echo $TPL_V4["stock"]?></span>
<?php }?>
				</div>
<?php }?>
				</td>

				<td class="info suboption ea" align="center"><?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V4["step25"])?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info suboption ea" align="center"><?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V4["step35"])?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info suboption ea" align="center"><?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V4["step45"])?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info suboption ea" align="center"><?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V4["step55"])?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info suboption ea" align="center"><?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V4["step65"])?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?></td>

				<td class="info suboption ea" align="center">
<?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V4["step75"]?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?>
<?php if($TPL_V4["cancel_list_ea"]||$TPL_V4["exchange_list_ea"]||$TPL_V4["return_list_ea"]||$TPL_V4["refund_list_ea"]){?>
					<div>
<?php if($TPL_V4["exchange_list_ea"]){?>
						<a href="../returns/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return_exchange.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V4["exchange_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V4["return_list_ea"]){?>
						<a href="../returns/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V4["return_list_ea"]?></span></a>
						<a href="../refund/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_refund.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V4["return_list_ea"]?></span></a>
<?php }?>
					</div>
<?php }?>
				</td>
				<td class="info suboption ea" align="center"><?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V4["step85"]?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?></td>
				<td class="info suboption" align="center">
<?php if($TPL_V4["step"]<= 45||$TPL_V4["step"]> 75){?>
					<?php echo $TPL_V4["mstep"]?>

<?php }else{?>
					<div class="under_div_view underline hand">
						<?php echo $TPL_V4["mstep"]?>

						<div class="absolute hide under_div_view_contents">
							<div class="sale_price_layer" style="width:150px;">
								<div class="title_line">????????????</div>
								<br style="line-height:10px;" />
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<col width="70" />
								<col width="70" />
								<col />
								<tr>
									<th>??????</th>
									<th class="bolds ends">??????</th>
								</tr>
								<tr>
									<td class="gr">????????????</td>
									<td class="bolds  prices ends">
										<?php echo number_format($TPL_V4["export_sum_ea"]["delivery"])?>

									</td>
								</tr>
								<tr>
									<td class="gr">????????????</td>
									<td class="bolds  prices ends">
										<?php echo number_format($TPL_V4["export_sum_ea"]["postpaid"])?>

									</td>
								</tr>
								<tr>
									<td class="gr">????????????</td>
									<td class="bolds  prices ends">
										<?php echo number_format($TPL_V4["export_sum_ea"]["quick"])?>

									</td>
								</tr>
								<tr>
									<td class="gr">????????????</td>
									<td class="bolds  prices ends">
										<?php echo number_format($TPL_V4["export_sum_ea"]["direct"])?>

									</td>
								</tr>
								</table>
							</div>
						</div>
					</div>

<?php }?>
				</td>
			</tr>

<?php if(is_array($TPL_R5=$TPL_V4["packages"])&&!empty($TPL_R5)){foreach($TPL_R5 as $TPL_V5){?>
			<tr class="order-item-row">
				<td class="package-option" style="padding-left:55px;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<col /><col />
					<tr>
						<td valign="top" style="border:none;"><img src="/admin/skin/default/images/common/icon/ico_package.gif" /></td>
						<td class="left" valign="top" style="border:none;">
							<a href='/goods/view?no=<?php echo $TPL_V5["goods_seq"]?>' target='_blank'><span class="order-item-image"><img class="small_goods_image" src="<?php echo $TPL_V5["image"]?>" /></span></a>
						</td>
						<td class="left" valign="top" style="border:none;">
							<div class="goods_name">
<?php if($TPL_V5["goods_kind"]=='coupon'){?>
								<a href='../goods/social_regist?no=<?php echo $TPL_V5["goods_seq"]?>' target='_blank'>
<?php }else{?>
								<a href='../goods/regist?no=<?php echo $TPL_V5["goods_seq"]?>' target='_blank'>
<?php }?>
									<span class="title">[????????????]</span>
									<span class="goods_name1 title">
									<?php echo $TPL_V5["goods_name"]?>

									</span>
								</a>
							</div>
							<div>
<?php if($TPL_V5["adult_goods"]=='Y'){?>
								<img src="/admin/skin/default/images/common/auth_img.png" alt="??????" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V5["option_international_shipping_status"]=='y'){?>
								<img src="/admin/skin/default/images/common/icon/plane_on.png" alt="??????????????????" style="vertical-align: middle;" height="19" />
<?php }?>
<?php if($TPL_V5["cancel_type"]=='1'){?>
								<img src="/admin/skin/default/images/common/icon/nocancellation.gif" alt="????????????" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V5["tax"]=='exempt'){?>
								<img src="/admin/skin/default/images/common/icon/taxfree.gif" alt="?????????" style="vertical-align: middle;"/>
<?php }?>
							</div>

<?php if($TPL_V5["event_seq"]&&$TPL_V5["event_title"]){?>
							<div style="padding-top:3px;">
								<a href="/admin/event/<?php if($TPL_V4["event_type"]=='solo'){?>solo<?php }?>regist?event_seq=<?php echo $TPL_V4["event_seq"]?>" target='_blank'><span class="btn small gray"><button type="button" class="goods_event hand"><?php echo $TPL_V4["event_title"]?></button></span></a>
							</div>
<?php }?>
<?php if($TPL_V5["option1"]!=null){?>
							<div class="goods_option" style="padding-top:3px;">
								<img src="/admin/skin/default/images/common/icon_option.gif" align="absmiddle" />
<?php if($TPL_V5["title1"]){?><?php echo $TPL_V5["title1"]?>:<?php }?><?php echo $TPL_V5["option1"]?>

<?php if($TPL_V5["option2"]!=null){?><?php if($TPL_V5["title2"]){?><?php echo $TPL_V5["title2"]?>:<?php }?><?php echo $TPL_V5["option2"]?><?php }?>
<?php if($TPL_V5["option3"]!=null){?><?php if($TPL_V5["title3"]){?><?php echo $TPL_V5["title3"]?>:<?php }?><?php echo $TPL_V5["option3"]?><?php }?>
<?php if($TPL_V5["option4"]!=null){?><?php if($TPL_V5["title4"]){?><?php echo $TPL_V5["title4"]?>:<?php }?><?php echo $TPL_V5["option4"]?><?php }?>
<?php if($TPL_V5["option5"]!=null){?><?php if($TPL_V5["title5"]){?><?php echo $TPL_V5["title5"]?>:<?php }?><?php echo $TPL_V5["option5"]?><?php }?>
							</div>
<?php }?>

<?php if($TPL_V5["inputs"]){?>
<?php if(is_array($TPL_R6=$TPL_V5["inputs"])&&!empty($TPL_R6)){foreach($TPL_R6 as $TPL_V6){?>
<?php if($TPL_V6["value"]){?>
							<div class="goods_input" style="padding-top:3px;">
								<img src="/admin/skin/default/images/common/icon_input.gif" align="absmiddle" />
<?php if($TPL_V6["title"]){?><?php echo $TPL_V6["title"]?>:<?php }?>
<?php if($TPL_V6["type"]=='file'){?>
								<a href="../order_process/filedown?file=<?php echo $TPL_V5["value"]?>" target="actionFrame"><?php echo $TPL_V6["value"]?></a>
<?php }else{?><?php echo $TPL_V6["value"]?><?php }?>
							</div>
<?php }?>
<?php }}?>
<?php }?>


							<div class="warehouse-info-lay">
							<ul>
<?php if($TPL_V5["whinfo"]["wh_name"]){?>
								<li>
								<?php echo $TPL_V5["whinfo"]["wh_name"]?> <?php if($TPL_V4["whinfo"]["location_code"]){?>(<?php echo $TPL_V5["whinfo"]["location_code"]?>)<?php }?> : <?php echo number_format($TPL_V5["whinfo"]["ea"])?>(<?php echo number_format($TPL_V5["whinfo"]["badea"])?>)
								</li>
<?php }?>
								<li>???????????? : <?php echo $TPL_V5["goods_code"]?></li>
							</ul>
							</div>
						</td>
					</tr>
					</table>
				</td>
				<td class="package-option center">
					<div>
						<span class="ea">[<?php echo number_format($TPL_V4["ea"])?>]</span>x<?php echo number_format($TPL_V5["unit_ea"])?>=<?php echo number_format($TPL_V5["unit_ea"]*$TPL_V4["ea"])?>

					</div>
					<span class="helpicon" title="?????? ???????????? ???????????? 1????????? ?????? ??????????????? ????????????"></span>
				</td>
				<td class="package-option center">-</td>
				<td class="package-option center">-</td>
				<td class="package-option center">-</td>
				<td class="package-option center">-</td>
				<td class="package-option center">-</td>
				<td class="price package-option">
<?php if($TPL_V5["stock"]==='?????????'){?>
						<div class="red">?????????</span>
						<div class="red">?????????</span>
<?php }else{?>
					<div class="stock"><?php echo number_format($TPL_V5["stock"])?></div>
					<div class="ablestock"><?php echo number_format($TPL_V5["ablestock"])?></div>
<?php }?>
					<div class="right">
						<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V5["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_V3["provider_seq"]?>'<?php }else{?>'2'<?php }?>)" option_code1="{=......option1}" option_code2="{=......option2}" option_code3="{=......option3}" option_code4="{=......option4}" option_code5="{=......option5}">
							<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V5["option_seq"]?>"></span>
							<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V5["goods_seq"]?>"><span class="hide">??????</span></span>
						</span>
					</div>
				</td>
				<td class="package-option center ea">
					<?php echo number_format($TPL_V5["unit_ea"]*$TPL_V4["step25"])?>

				</td>
				<td class="package-option center ea">
					<?php echo number_format($TPL_V5["unit_ea"]*$TPL_V4["step35"])?>

				</td>
				<td class="package-option center ea">
					<?php echo number_format($TPL_V5["unit_ea"]*$TPL_V4["step45"])?>

				</td>
				<td class="package-option center ea">
					<?php echo number_format($TPL_V5["unit_ea"]*$TPL_V4["step55"])?>

				</td>
				<td class="package-option center ea">
					<?php echo number_format($TPL_V5["unit_ea"]*$TPL_V4["step65"])?>

				</td>
				<td class="package-option center ea">
					<?php echo number_format($TPL_V5["unit_ea"]*$TPL_V4["step75"])?>

				</td>
				<td class="package-option center ea">
					<?php echo number_format($TPL_V5["unit_ea"]*$TPL_V4["step85"])?>

				</td>
				<td class="package-option center">-</td>
			</tr>
<?php }}?>

<?php }}?>
<?php }}?>
<?php }}?>
<?php }}?>
		<tr class="order-item-row">
			<td class="right bold">??????</td>
			<td class="info" align="right"><strong><?php echo $TPL_VAR["items_tot"]["ea"]?> (<?php echo $TPL_VAR["items_tot"]["cnt"]?>???)</strong></td>
			<td class="price info"><strong><?php echo get_currency_price($TPL_VAR["items_tot"]["price"])?></strong></td>
			<td class="price info">
				<strong><?php echo get_currency_price($TPL_VAR["items_tot"]["event_sale"]+$TPL_VAR["items_tot"]["multi_sale"]+$TPL_VAR["items_tot"]["coupon_sale"]+$TPL_VAR["items_tot"]["member_sale"]+$TPL_VAR["items_tot"]["fblike_sale"]+$TPL_VAR["items_tot"]["mobile_sale"]+$TPL_VAR["items_tot"]["promotion_code_sale"]+$TPL_VAR["items_tot"]["referer_sale"])?></strong>
				<div class="desc">(<?php echo get_currency_price($TPL_VAR["items_tot"]["coupon_provider"]+$TPL_VAR["items_tot"]["promotion_provider"]+$TPL_VAR["items_tot"]["referer_provider"]+$TPL_VAR["items_tot"]["event_provider"]+$TPL_VAR["items_tot"]["multi_provider"])?>)</div>
			</td>
			<td class="price info"><strong><?php echo get_currency_price($TPL_VAR["items_tot"]["out_sale_price"])?></strong></td>
			<td class="price info">
				<div class="bold"><?php echo get_currency_price($TPL_VAR["items_tot"]["reserve"])?></div>
				<div class="desc">(<?php echo get_currency_price($TPL_VAR["items_tot"]["point"])?>)</div>
			</td>
			<td class="info">
			<div class="right">
<?php if($TPL_VAR["items_tot"]["real_stock"]> 0){?>
				<span class="blue bold"><?php echo number_format($TPL_VAR["items_tot"]["real_stock"])?></span>
<?php }else{?>
				<span class="red bold"><?php echo number_format($TPL_VAR["items_tot"]["real_stock"])?></span>
<?php }?>
			</div>
			<div class="right">
<?php if($TPL_VAR["items_tot"]["stock"]> 0){?>
				<span class="blue bold"><?php echo number_format($TPL_VAR["items_tot"]["stock"])?></span>
<?php }else{?>
				<span class="red bold"><?php echo number_format($TPL_VAR["items_tot"]["stock"])?></span>
<?php }?>
			</div>
			</td>
			<td class="ea center bold"><?php echo number_format($TPL_VAR["items_tot"]["step25"])?></td>
			<td class="ea center bold"><?php echo number_format($TPL_VAR["items_tot"]["step35"])?></td>
			<td class="ea center bold"><?php echo number_format($TPL_VAR["items_tot"]["step45"])?></td>
			<td class="ea center bold"><?php echo number_format($TPL_VAR["items_tot"]["step55"])?></td>
			<td class="ea center bold"><?php echo number_format($TPL_VAR["items_tot"]["step65"])?></td>
			<td class="ea center bold"><?php echo number_format($TPL_VAR["items_tot"]["step75"])?></td>
			<td class="ea center bold"><?php echo number_format($TPL_VAR["items_tot"]["step85"])?></td>
			<td > &nbsp; </td>
			<td class="price info"><b><?php echo get_currency_price($TPL_VAR["shipping_tot"]["shipping_cost"]+$TPL_VAR["shipping_tot"]["goods_shipping_cost"])?></b></td>
		</tr>
	</tbody>
</table>


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

<br class="table-gap" />

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
	<col width="60%" />
	<tr>
		<th height="25" colspan="2"  colspan="2">
			<div class="left relative">
				<?php echo $TPL_VAR["orders"]["recipient_user_name"]?>??????
<?php if($TPL_VAR["orders"]["international"]=='domestic'){?>
				???????????????(??????)
<?php }else{?>
				???????????????(??????)
<?php }?>
<?php if(!$TPL_VAR["orders"]["linkage_id"]){?>
<?php if(!$TPL_VAR["orders"]["able_export"]){?>
				<div class="absolute" style="top:-4px; right:3px;"><span class="btn small cyanblue"><button type="button" id="shipping_region" onclick="alert('??? ????????? ???????????? ?????????????????? ?????????.');">??????</button></span></div>
<?php }else{?>
				<div class="absolute" style="top:-4px; right:3px;"><span class="btn small cyanblue"><button type="submit" id="shipping_region">??????</button></span></div>
<?php }?>
<?php }?>
			</div>
		</th>
	</tr>
	<tr>
		<td colspan="2">
			<input type="text" name="recipient_user_name" value="<?php echo $TPL_VAR["orders"]["recipient_user_name"]?>" class="line" /> /
			<input type="text" name="recipient_phone[]" value="<?php echo $TPL_VAR["orders"]["recipient_phone"][ 0]?>" size="5" maxlength="4" class="line" />
			- <input type="text" name="recipient_phone[]" value="<?php echo $TPL_VAR["orders"]["recipient_phone"][ 1]?>" size="5" maxlength="4" class="line" />
			- <input type="text" name="recipient_phone[]" value="<?php echo $TPL_VAR["orders"]["recipient_phone"][ 2]?>" size="5" maxlength="4" class="line" /> /
			
			
			<input type="text" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["orders"]["recipient_cellphone"][ 0]?>" size="5" class="line" />
			- <input type="text" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["orders"]["recipient_cellphone"][ 1]?>" size="5" class="line" />
			- <input type="text" name="recipient_cellphone[]" value="<?php echo $TPL_VAR["orders"]["recipient_cellphone"][ 2]?>" size="5" class="line" />
			<!--<span class="btn small cyanblue"><input type="button" value="?????????" class="send_recipient_sms" /></span>-->
<?php if($TPL_VAR["orders"]["recipient_email"]){?>
			 / <?php echo $TPL_VAR["orders"]["recipient_email"]?>

			<!--<span class="btn small cyanblue"><input type="button" class="email_pop" value="?????????" email="<?php echo $TPL_VAR["orders"]["recipient_email"]?>" /></span>-->
<?php }?>
		</td>

	</tr>
<?php if($TPL_VAR["goods_kind_arr"]['goods']){?>
	<tr>
		<td  style="padding-left:10px;">
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
			<textarea class="wp95 line" rows="3" name="memo" title="?????? ?????????"><?php if($TPL_VAR["orders"]["each_msg_yn"]=='Y'){?><?php if(is_array($TPL_R1=$TPL_VAR["orders"]["memo"]["ship_message"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?><?php echo $TPL_K1+ 1?>. <?php echo $TPL_VAR["orders"]["memo"]["goods_info"][$TPL_I1]?> : [<?php echo $TPL_V1?>]
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
			<input type="text" name="clearance_unique_personal_code" value="<?php echo $TPL_VAR["orders"]["clearance_unique_personal_code"]?>" disabled="disabled" />
			<span class="desc">????????? ????????? ?????? ????????? ??????????????? ???????????? ?????????????????????.</span>
		</td>
	</tr>
	</table>
</form>

<br class="table-gap" />
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
					<td>
<?php if($TPL_VAR["members"]["member_seq"]){?>
					<div>
<?php if($TPL_VAR["members"]["type"]=='??????'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" />
<?php }elseif($TPL_VAR["members"]["type"]=='??????'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" /><?php }?>
						<?php echo $TPL_VAR["orders"]["order_user_name"]?>

<?php if($TPL_VAR["orders"]["sns_rute"]){?>
							(<img src="/selleradmin/skin/default/images/sns/sns_<?php echo substr($TPL_VAR["orders"]["sns_rute"], 0, 1)?>0.gif" align="absmiddle">/<span class="blue"><?php echo $TPL_VAR["members"]["group_name"]?></span>)
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

<?php if($TPL_VAR["orders"]["order_cellphone"]){?><span class="btn small cyanblue"><input type="button" class="send_sms" value="?????????" cellphone="<?php echo str_replace('-','',$TPL_VAR["orders"]["order_cellphone"])?>"/></span><?php }?>
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
					<td><?php echo $TPL_VAR["orders"]["bank_account"]?></td>
				</tr>
				<tr>
					<th>????????????</th>
					<td><?php echo $TPL_VAR["orders"]["depositor"]?></td>
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
				<span class="btn medium gray"><button type="button" id="cash_receipts"  onclick="window.open('/prints/form_print_trade?no=<?php echo $TPL_VAR["orders"]["order_seq"]?>')" >???????????????<span class="arrowright"></span></button></span>
				</div>
			</td>
			<td class="odt-body-cell" valign="top">
				<div style="position:relative;width:100%">
				<div style="position:absolute;top:-40px;left:83%;">
				<!-- <span class="btn small orange"><button type="button" onclick="viewLogManual('proc');">??????) ????????????</button></span> -->
				</div>
				</div>
				<div class="pdb5">
				<label><input type="radio" name="view_log" onclick="view_log('order_log');" checked="checked" /> ????????????</label>
				<label><input type="radio" name="view_log" onclick="view_log('export_log');" /> ????????????</label>
				</div>
				<div id="order_log">
					<textarea style="background-color:#eeeeee;width:100%;" rows="15" readOnly="readOnly"><?php if($TPL_process_log_1){foreach($TPL_VAR["process_log"] as $TPL_V1){?>[<?php echo $TPL_V1["regist_date"]?>] [<?php echo $TPL_V1["actor"]?>] <?php if($TPL_V1["add_info"]=="npay"){?>[???????????????]<?php }?> <?php echo $TPL_V1["title"]?><?php echo chr( 10)?><?php }}?></textarea>
				</div>
				<div id="export_log"  class="hide">
					<textarea style="background-color:#eeeeee;width:100%;" rows="15" readOnly="readOnly">
<?php if($TPL_error_export_log_1){foreach($TPL_VAR["error_export_log"] as $TPL_V1){?>[<?php echo $TPL_V1["regist_date"]?>] <?php if($TPL_V1["manager_seq"]){?>[<?php echo $TPL_V1["manager_name"]?>]<?php }?><?php if($TPL_V1["provider_seq"]){?>[<?php echo $TPL_V1["provider_name"]?>]<?php }?> <?php if($TPL_V1["add_info"]=="npay"){?>[???????????????]<?php }?> <?php echo $TPL_V1["process_title"]?> ??????(<?php echo $TPL_V1["msg"]?>)<?php echo chr( 10)?><?php }}?>
					</textarea>
				</div>

			</td>
		</tr>

	</tbody>
	<tbody class="odt-head">
		<tr>
			<th colspan="3">
				????????????
			</th>
		</tr>
	</tbody>
	<tbody class="odt-body">
		<tr>
			<td class="odt-body-cell" valign="top" colspan="3" style="background-color:white !important";>
				<!-- <form name="frm_admin_memo" method="post" action="../order_process/admin_memo?seq=<?php echo $TPL_VAR["orders"]["order_seq"]?>" target="actionFrame"> -->
				<table class="simpledata-table-style" style="width:100%;margin-bottom:20px !important;" id="memo_list">
				<colgroup>
					<col width="55" />
					<col width="100" />
					<col width="100" />
					<col width="100" />
					<col width="*"  />
					<col width="100" />
					<col width="150" />
				</colgroup>
					<tr>
						<th>??????</th>
						<th>????????????</th>
						<th>??????</th>
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
							<td><?php echo $TPL_V1["provider_name"]?></td>
							<td><?php echo $TPL_V1["mname"]?><!-- <?php if($TPL_V1["manager_id"]){?> -->(<?php echo $TPL_V1["manager_id"]?>)<!-- <?php }?> --></td>
							<td id="admin_memo_<?php echo $TPL_V1["memo_idx"]?>" class="left" style="word-break:break-all;"><?php echo $TPL_V1["admin_memo"]?></td>
							<td><?php echo $TPL_V1["ip"]?></td>
							<td>
<?php if($TPL_V1["provider_seq"]!= 1){?>
								<div style="position:relative;width:100%">
									<span class="btn small cyanblue"><button type="button" id="admin_order_memo" onclick="modify_order_memo('<?php echo $TPL_V1["memo_idx"]?>')">??????</button></span>
									<span class="btn small red"><button type="button" onclick="admin_memo_delete(<?php echo $TPL_V1["memo_idx"]?>)">??????</button></span>
								</div>
<?php }else{?>
								-
<?php }?>
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
						<input type='hidden' name='memo_idx' value=''>
						<textarea class="odt-memo-textarea line" name="admin_memo" style="background:#f9f9f9;width:95% ;margin-left:4px;"></textarea>
						<div style="position:relative;width:100%">
							<div style="margin:5px;">
								<span class="btn small cyanblue"><button id="memo_reg">??????</button></span>
							</div>
						</div>
					</td>
				</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>
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

<div id="gift_use_lay"></div>
<div id="coupon_use_lay" class="hide"></div>
<div id="coupon_use_log_dialog" class="hide"></div>
<div id="coupon_status_dialog" class="hide"><?php $this->print_("socialcp_status_guide",$TPL_SCP,1);?></div>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>