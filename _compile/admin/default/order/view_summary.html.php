<?php /* Template_ 2.2.6 2022/05/24 11:04:04 /www/music_brother_firstmall_kr/admin/skin/default/order/view_summary.html 000116918 */ 
$TPL_child_order_seq_1=empty($TPL_VAR["child_order_seq"])||!is_array($TPL_VAR["child_order_seq"])?0:count($TPL_VAR["child_order_seq"]);
$TPL_data_export_1=empty($TPL_VAR["data_export"])||!is_array($TPL_VAR["data_export"])?0:count($TPL_VAR["data_export"]);
$TPL_data_refund_1=empty($TPL_VAR["data_refund"])||!is_array($TPL_VAR["data_refund"])?0:count($TPL_VAR["data_refund"]);
$TPL_data_return_1=empty($TPL_VAR["data_return"])||!is_array($TPL_VAR["data_return"])?0:count($TPL_VAR["data_return"]);
$TPL_data_exchange_1=empty($TPL_VAR["data_exchange"])||!is_array($TPL_VAR["data_exchange"])?0:count($TPL_VAR["data_exchange"]);
$TPL_shipping_group_items_1=empty($TPL_VAR["shipping_group_items"])||!is_array($TPL_VAR["shipping_group_items"])?0:count($TPL_VAR["shipping_group_items"]);
$TPL_salescost_1=empty($TPL_VAR["salescost"])||!is_array($TPL_VAR["salescost"])?0:count($TPL_VAR["salescost"]);?>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layer_stock.css" />

<style>
	.price {padding-right:5px;text-align:right}
	table.order-inner-table,
	table.order-inner-table td,table.order-inner-table th {height:9px !important; border:0 !important;}
	.ea {font-family:dotum; color:#a400ff;}
	.title_order_number {font-family:dotum;font-size:13px;}
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

	.waybill_number {font-size:11px;width:100px;}
	.delivery_number {width:90%; padding:0px !important; text-indent:2px; line-height:20px; height:20px;}
</style>

<script type="text/javascript">

	var order_seq				= "<?php echo $TPL_VAR["orders"]["order_seq"]?>";
	var orign_order_seq			= "<?php echo $TPL_VAR["orders"]["orign_order_seq"]?>";
	var order_hidden			= "<?php echo $TPL_VAR["orders"]["hidden"]?>";
	var order_hidden_date		= "<?php echo $TPL_VAR["orders"]["hidden_date"]?>";
	var	order_npay				= "<?php echo $TPL_VAR["npay_use"]?>";
	var	order_pg				= "<?php echo $TPL_VAR["orders"]["pg"]?>";
	var nomatch_goods_cnt		= "<?php echo $TPL_VAR["items_tot"]["nomatch_goods_cnt"]?>";
	var private_masking			= "<?php echo $TPL_VAR["orders"]["private_masking"]?>";

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
	var pagemode				= "<?php echo $TPL_VAR["pagemode"]?>";
</script>

<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-shipping.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-orderView.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript">
<?php if($_GET["mode"]!='order_list'){?>
	function coupon_use_btn(bobj)
	{
		var Bobj = $(bobj);
		$("#coupon_use_lay").html("");
		closeDialog("coupon_use_lay");
		$.ajax({
			type: "post",
			url: "../export/coupon_use",
			data: "order_seq="+Bobj.attr('order_seq'),
			success: function(result){
				if	(result){
					$("#coupon_use_lay").html(result);
					openDialog("???????????? ?????? / ???????????? ????????? <span class='desc'></span>", "coupon_use_lay", {"width":"1000","height":"700"});
				}
			}
		});
	}
<?php }?>

		help_tooltip();
</script>

<!-- ????????????/????????????/????????????/???????????? ????????? ?????? ?????? -->
<?php if($TPL_VAR["pagemode"]!="order_catalog"&&$TPL_VAR["pagemode"]!="company_catalog"){?>

<!-- ????????????/???????????? ????????? ?????? ??? -->
<!-- <?php if(in_array($TPL_VAR["pagemode"],array('refund_view','return_view'))){?> -->
<div class="center pdb10" style="margin-top:30px;">
	<span id="order_summary_open" class="btn medium" mode="<?php echo $_GET["mode"]?>"><button type="button">?????????(<?php echo $TPL_VAR["orders"]["order_seq"]?>) ?????? ????????????  ???</button></span>
	<span id="order_summary_close" class="btn medium" mode="<?php echo $_GET["mode"]?>" style="display:none"><button  type="button">?????????(<?php echo $TPL_VAR["orders"]["order_seq"]?>) ?????? ?????? ???</button></span>
</div>

<div class="order-summary">
	<!-- <?php }?> -->
	<!-- ????????????/???????????? ????????? ?????? ??? -->

	<div class="item-title">
		????????????
<?php if($TPL_VAR["orders"]["orign_order_seq"]){?>
		<span class="desc" style="font-weight:normal">(??? ????????? ?????? ?????? <strong><a href="/admin/order/view?no=<?php echo $TPL_VAR["orders"]["orign_order_seq"]?>" target="_blank"><?php echo $TPL_VAR["orders"]["orign_order_seq"]?></a></strong>??? ?????? ??????????????? ????????? ???????????????.)</span>
<?php }?>
<?php if($TPL_VAR["child_order_seq"]){?>
		<span class="desc" style="font-weight:normal">(??? ??????????????? ???????????? ?????? ????????? ????????? ????????? <strong><?php if($TPL_child_order_seq_1){foreach($TPL_VAR["child_order_seq"] as $TPL_V1){?><a href="/admin/order/view?no=<?php echo $TPL_V1?>" target="_blank"><?php echo $TPL_V1?></a><?php }}?></strong>?????????.)</span>
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
				<?php echo $TPL_VAR["orders"]["order_seq"]?> <a href="javascript:printOrderView('<?php echo $TPL_VAR["orders"]["order_seq"]?>', 'view')"><span class="icon-print-order"></span></a>
<?php if($TPL_VAR["orders"]["npay_order_id"]){?><div class="ngreen bold"><?php echo $TPL_VAR["orders"]["npay_order_id"]?><span style="font-size:11px;font-weight:normal;"> (Npay????????????)</span></div><?php }?>
<?php if($TPL_VAR["orders"]["talkbuy_order_id"]){?><div class="kyellow bold"><?php echo $TPL_VAR["orders"]["talkbuy_order_id"]?><span style="font-size:11px;font-weight:normal;"> (Kpay????????????)</span></div><?php }?>
<?php if($TPL_VAR["orders"]["linkage_mall_order_id"]){?><div class="blue bold"><?php echo $TPL_VAR["orders"]["linkage_mall_order_id"]?>(<?php echo $TPL_VAR["linkage_mallnames"][$TPL_VAR["orders"]["linkage_mall_code"]]?>)</div><?php }?>
			</td>
			<td>
<?php if($TPL_VAR["orders"]["orign_order_seq"]||$TPL_VAR["orders"]["admin_order"]||$TPL_VAR["orders"]["person_seq"]){?>
<?php if($TPL_VAR["orders"]["orign_order_seq"]){?> ??????<?php }?>
<?php if($TPL_VAR["orders"]["admin_order"]){?> ?????????<?php }?>
<?php if($TPL_VAR["orders"]["person_seq"]){?> ?????? <?php }?>
<?php }?>
			</td>
			<td class="hand" onclick="open_crm_summary(this,'<?php echo $TPL_VAR["members"]["member_seq"]?>','<?php echo $TPL_VAR["orders"]["order_seq"]?>','right');">
<?php if($TPL_VAR["members"]["member_seq"]){?>
				<div>
<?php if($TPL_VAR["members"]["type"]=='??????'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" />
<?php }elseif($TPL_VAR["members"]["type"]=='??????'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" /><?php }?>
					<?php echo $TPL_VAR["orders"]["order_user_name"]?>

<?php if($TPL_VAR["orders"]["sns_rute"]){?>
					(
					<img src="/admin/skin/default/images/sns/sns_<?php echo substr($TPL_VAR["orders"]["sns_rute"], 0, 1)?>0.gif" align="absmiddle" snscd="<?php echo $TPL_VAR["orders"]["sns_rute"]?>" class="btnsnsdetail hand" no=1>/<span class="blue"><?php echo $TPL_VAR["members"]["group_name"]?></span>)
					<div id="snsdetailPopup1" class="absolute hide"></div>
<?php }else{?>
<?php if($TPL_VAR["members"]["rute"]=='facebook'){?>
					(<a href="/admin/member/detail?member_seq=<?php echo $TPL_VAR["members"]["member_seq"]?>" target="_blank"><span style="color:#d13b00;"><img src="/admin/skin/default/images/board/icon/sns_f0.gif" align="absmiddle"><?php echo $TPL_VAR["members"]["email"]?></span>/<span class="blue"><?php echo $TPL_VAR["members"]["group_name"]?></span></a>)
<?php }else{?>
					(<a href="/admin/member/detail?member_seq=<?php echo $TPL_VAR["members"]["member_seq"]?>" target="_blank"><span style="color:#d13b00;"><?php echo $TPL_VAR["members"]["userid"]?></span>/<span class="blue"><?php echo $TPL_VAR["members"]["group_name"]?></span></a>)
<?php }?>
<?php }?>
				</div>
<?php }else{?>
				<img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <?php echo $TPL_VAR["orders"]["order_user_name"]?>(<span class="desc">?????????</span>)
<?php }?>
			</td>
			<td><?php echo $TPL_VAR["orders"]["recipient_user_name"]?></td>
			<td>

<?php if($TPL_VAR["orders"]["linkage_id"]=='connector'){?>
				????????????
<?php }else{?>
<?php if($TPL_VAR["orders"]["depositor"]){?><?php echo $TPL_VAR["orders"]["depositor"]?><?php }?>
<?php if($TPL_VAR["orders"]["npay_order_id"]){?><span class="icon-pay-npay" title="naver pay"><span>npay</span></span><?php }?>
<?php if($TPL_VAR["orders"]["talkbuy_order_id"]){?><span class="icon-pay-talkbuy-simple" title="talkbuy pay"><span>talkbuy</span></span><?php }?>
<?php if($TPL_VAR["orders"]["pg"]=='kakaopay'){?><span class="icon-pay-kakaopay" /><span>kakaopay</span></span><?php }else{?><?php echo $TPL_VAR["orders"]["mpayment"]?><?php }?>
<?php if($TPL_VAR["orders"]["bank_name"]){?>(<?php echo $TPL_VAR["orders"]["bank_name"]?>)<?php }?>
<?php }?>
			</td>
			<td><?php echo substr($TPL_VAR["orders"]["deposit_date"], 2)?></td>
			<td><span class="icon-order-step-<?php echo $TPL_VAR["orders"]["step"]?>"><?php echo $TPL_VAR["orders"]["mstep"]?></span></td>
		</tr>
		</tbody>
	</table>

	<div class="step-description-<?php echo $TPL_VAR["orders"]["step"]?> center pd5">
		<table width="900" style="color:#fff">
			<tr>
				<td class="left">
<?php if($TPL_VAR["orders"]["step"]=='15'){?>
					<strong><?php echo $TPL_VAR["orders"]["mstep"]?></strong> ????????? ??? ?????? <span class="yellow bold"><?php echo $TPL_VAR["items_tot"]["ea"]?></span>???(<?php echo count($TPL_VAR["items"])?>???)??? ????????? ??????????????? ?????????. <span class="btn small orange"><button type="button" class="order_deposit">????????????</button></span>
<?php }elseif($TPL_VAR["orders"]["step"]=='85'){?>
					<strong><?php echo $TPL_VAR["orders"]["mstep"]?></strong> ????????? ??? ?????? <span class="yellow bold"><?php echo $TPL_VAR["items_tot"]["ea"]?></span>???(<?php echo count($TPL_VAR["items"])?>???)??? ????????? ?????????????????????.
<?php }elseif($TPL_VAR["orders"]["step"]=='95'){?>
					<strong><?php echo $TPL_VAR["orders"]["mstep"]?></strong> ????????? ??? ?????? <span class="yellow bold"><?php echo $TPL_VAR["items_tot"]["ea"]?></span>???(<?php echo count($TPL_VAR["items"])?>???)??? ????????? ?????????????????????.
<?php }elseif($TPL_VAR["orders"]["step"]=='99'){?>
					<strong><?php echo $TPL_VAR["orders"]["mstep"]?></strong> ????????? ??? ?????? <span class="yellow bold"><?php echo $TPL_VAR["items_tot"]["ea"]?></span>???(<?php echo count($TPL_VAR["items"])?>???)??? ????????? ?????????????????????.
<?php }else{?>
					<strong><?php echo $TPL_VAR["orders"]["mstep"]?></strong> ????????? ??? ?????? <span class="yellow bold"><?php echo $TPL_VAR["items_tot"]["ea"]?></span>???(<?php echo count($TPL_VAR["items"])?>???)???
					<span class="yellow bold"><?php echo number_format($TPL_VAR["items_tot"]["ready_ea"])?></span>?????? ?????????&nbsp; <?php if($TPL_VAR["items_tot"]["ready_ea"]> 0){?><span class="btn small black"><button type="button" class="goods_export">????????????</button></span><?php }?> ??????,
					<span class="yellow bold"><?php echo number_format($TPL_VAR["orders"]["export_ready_ea"])?></span>?????? ?????? ?????? ??? ??????,
					<span class="yellow bold"><?php echo number_format($TPL_VAR["orders"]["export_complete_ea"])?></span>?????? ??????????????????.
<?php }?>
				</td>
			</tr>
<?php if($TPL_VAR["orders"]["cancel_list"]){?>
			<tr>
				<td class="left">
					????????? ???<span class="yellow bold"><?php echo count($TPL_VAR["orders"]["cancel_list"])?></span>?????????
<?php if(is_array($TPL_R1=$TPL_VAR["orders"]["cancel_list"])&&!empty($TPL_R1)){$TPL_S1=count($TPL_R1);$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
					1???(<span class="yellow bold"><?php echo $TPL_V1["ea"]?></span>???)??? <?php if($TPL_V1["status"]!='complete'){?>[?????????]<?php }else{?>[????????????]<?php }?>
<?php if($TPL_I1!=$TPL_S1- 1){?>
					,
<?php }?>
<?php }}?>
					?????????.
				</td>
			</tr>
<?php }?>
<?php if($TPL_VAR["orders"]["return_list"]){?>
			<tr>
				<td class="left">
					????????? ???<span class="yellow bold"><?php echo count($TPL_VAR["orders"]["return_list"])?></span>?????????
<?php if(is_array($TPL_R1=$TPL_VAR["orders"]["return_list"])&&!empty($TPL_R1)){$TPL_S1=count($TPL_R1);$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
					1???(<span class="yellow bold"><?php echo $TPL_V1["ea"]?></span>???)??? <?php if($TPL_V1["status"]!='complete'){?>[?????????<?php }else{?>[????????????<?php }?>???<?php if($TPL_V1["refund_status"]!='complete'){?>?????????]<?php }else{?>????????????]<?php }?>
<?php if($TPL_I1!=$TPL_S1- 1){?>
					,
<?php }else{?>
					?????????.
<?php }?>
<?php }}?>
				</td>
			</tr>
<?php }?>
<?php if($TPL_VAR["orders"]["exchange_list"]){?>
			<tr>
				<td class="left">
					????????? ???<span class="yellow bold"><?php echo count($TPL_VAR["orders"]["exchange_list"])?></span>?????????
<?php if(is_array($TPL_R1=$TPL_VAR["orders"]["exchange_list"])&&!empty($TPL_R1)){$TPL_S1=count($TPL_R1);$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
					<?php echo $TPL_V1["mstatus"]?>

					1???(<span class="yellow bold"><?php echo $TPL_V1["ea"]?></span>???)??? <?php if($TPL_V1["status"]!='complete'){?>[???????????????????????????]<?php }else{?>[???????????????????????????]<?php }?>
<?php if($TPL_I1!=$TPL_S1- 1){?>
					,
<?php }?>
<?php }}?>
					?????????.
				</td>
			</tr>
<?php }?>
		</table>
	</div>

	<div class="item-title">??????<span class="title_order_number">(<?php echo $TPL_VAR["orders"]["order_seq"]?>)</span>??? ????????????
		<span class="desc" style="font-weight:normal"> - ??? ????????? ???????????????
		<a href="../export/catalog?hsb_kind=export&header_search_keyword=<?php echo $TPL_VAR["orders"]["order_seq"]?>" target="_blank"><img src="/admin/skin/default/images/common/btn_list_release.gif" align="absmiddle" alt="?????? ????????? ????????? ???????????? ?????? ?????????????????? ???????????????"></a>?????? ????????? ??????
	</span>
	</div>
	<table width="100%" class="simplelist-table-style">
		<colgroup>
			<col width="100px" /><!--?????????-->
			<col width="150px" /><!--????????????-->
			<col width="150" /><!--??????????????????-->
			<col width="200px" /><!--????????????-->
			<col width="80px" /><!--????????????-->
			<col width="100px" /><!--??????????????????-->
			<col width="100px" /><!--??????????????????-->
			<col width="100px" /><!--????????????-->
			<col width="100px" /><!--??????????????????-->
		</colgroup>
		<tbody>
		<tr>
			<th>?????????</th>
			<th>????????????</th>
			<th>??????????????????</th>
			<th>????????????</th>
			<th>????????????</th>
			<th>??????????????????</th>
			<th>??????????????????</th>
			<th>????????????</th>
			<th>???????????? ??????</th>
		</tr>
		</tbody>
		<tbody>
<?php if($TPL_VAR["data_export"]){?>
<?php if($TPL_data_export_1){foreach($TPL_VAR["data_export"] as $TPL_V1){?>
		<tr align="center">
			<!--?????????-->
			<td><?php echo $TPL_V1["export_date"]?></td>
			<!--????????????-->
			<td>
<?php if($TPL_V1["is_bundle_export"]=='Y'){?><span class="bold red">[?????????(????????????)]</span><br/><?php }?>
				<a href='../export/view?no=<?php echo $TPL_V1["export_code"]?>'><span class="blue hand"><?php echo $TPL_V1["export_code"]?></span></a>
				<a href="javascript:printExportView('<?php echo $TPL_V1["order_seq"]?>','<?php echo $TPL_V1["export_code"]?>', 'view')"><span class="icon-print-export"></span></a>
			</td>
			<!--??????????????????-->
			<td><?php echo get_currency_price($TPL_V1["price"])?></td>
			<!--???????????????-->
<?php if($TPL_V1["goods_kind"]=='coupon'){?>
			<td>
				<div>???????????? : <?php echo $TPL_V1["coupon_serial"]?> (
<?php if($TPL_V1["coupon_input_type"]=='price'){?><?php echo get_currency_price($TPL_V1["coupon_input"], 3)?><?php }else{?><?php echo number_format($TPL_V1["coupon_input"])?>???<?php }?> /
					<span class="red">?????? <?php if($TPL_V1["coupon_input_type"]=='price'){?><?php echo get_currency_price($TPL_V1["coupon_remain_value"], 3)?><?php }else{?><?php echo number_format($TPL_V1["coupon_remain_value"])?>???<?php }?></span>)</div>
<?php if(is_array($TPL_R2=$TPL_V1["mail_send_log"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
				<div><?php echo date('Y-m-d H:i',strtotime($TPL_V2["regist_date"]))?>

					<?php echo $TPL_V2["send_val"]?>[<?php if($TPL_V2["status"]=='y'){?>??????<?php }else{?>??????<?php }?>] /
					<?php echo $TPL_V1["sms_send_log"][$TPL_K2]['send_val']?>[<?php if($TPL_V1["sms_send_log"][$TPL_K2]['status']=='y'){?>??????<?php }else{?>??????<?php }?>]</div>
<?php }}?>
			</td>
<?php }else{?>
			<td align="left" class="pdl5 shipping_info_<?php echo $TPL_V1["export_code"]?>">
				<!-- ?????? ?????? :: START -->
				<input type="hidden" name="export_shipping_group[<?php echo $TPL_V1["export_code"]?>]" class="export_shipping_group" value="<?php echo $TPL_V1["shipping_group"]?>" />
				<input type="hidden" id="export_shipping_method_<?php echo $TPL_V1["export_code"]?>" name="export_shipping_method[<?php echo $TPL_V1["export_code"]?>]" class="export_shipping_method" value="<?php echo $TPL_V1["shipping_method"]?>" />
				<input type="hidden" name="export_shipping_set_name[<?php echo $TPL_V1["export_code"]?>]" class="export_shipping_set_name" value="<?php echo $TPL_V1["shipping_set_name"]?>" />
<?php if(serviceLimit('H_AD')){?><div><?php echo $TPL_V1["provider_name"]?></div><?php }?>
				<div class="blue">
<?php if($TPL_VAR["orders"]["pg"]=='talkbuy'){?>
					<span class="hand shipping_set_name_<?php echo $TPL_V1["export_code"]?>" onclick='openDialog("??????????????? ??????", "talkbuy_delivary_dialog", {"width":"450","height":"150"});'><?php echo $TPL_V1["shipping_set_name"]?></span>
<?php }else{?>
					<span class="hand shipping_set_name_<?php echo $TPL_V1["export_code"]?>" onclick="ship_chg_popup('<?php echo $TPL_V1["export_code"]?>','export','after');"><?php echo $TPL_V1["shipping_set_name"]?></span>
<?php }?>
				</div>
				<div class="delivery_lay <?php if(!in_array($TPL_V1["shipping_method"],array('delivery','postpaid'))){?>hide<?php }?>">
<?php if($TPL_V1["international"]=='domestic'){?>
					<select name="delivery_company_code[<?php echo $TPL_V1["export_code"]?>]" class="waybill_number delivery_company_code">
<?php if(is_array($TPL_R2=$TPL_V1["delivery_company_array"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<?php if(substr($TPL_K2, 0, 5)=='auto_'&&$TPL_K2==$TPL_V1["delivery_company_code"]){?>
						<option value='<?php echo $TPL_K2?>' style='background-color:yellow' selected><?php echo $TPL_V2["company"]?></option>
<?php }elseif($TPL_K2==$TPL_V1["delivery_company_code"]){?>
						<option value='<?php echo $TPL_K2?>' selected="selected"><?php echo $TPL_V2["company"]?></option>
<?php }else{?>
						<option value='<?php echo $TPL_K2?>' <?php if(substr($TPL_K2, 0, 5)=='auto_'){?>style='background-color:yellow'<?php }?>><?php echo $TPL_V2["company"]?></option>
<?php }?>
<?php }}?>
					</select>
					<input type="text" name="delivery_number[<?php echo $TPL_V1["export_code"]?>]" class="line waybill_number delivery_number" value="<?php echo $TPL_V1["delivery_number"]?>" style="width:80px;"/>
<?php if($TPL_V1["delivery_company_code"]&&$TPL_V1["delivery_number"]){?>
					<span class="btn small cyanblue"><button type="button" class="hand" onclick="goDeliverySearch(this);">??????</button></span>
<?php }elseif($TPL_V1["delivery_company_code"]=='auto_hlc'&&$TPL_V1["delivery_number"]){?>
					<a href="<?php echo $TPL_V1["tracking_url"]?>" target="_blank"><span class="btn small cyanblue"><button type="button" class="hand">??????</button></span></a>
<?php }?>
<?php if(($TPL_V1["delivery_company_code"]=='auto_hlc'||$TPL_V1["delivery_company_code"]=='auto_epostnet')&&!$TPL_V1["delivery_number"]){?>
					<div><a href="javascript:;" onclick="invoice_export_resend(this,'<?php echo $TPL_V1["export_code"]?>')"><span class='red'>[???????????????]</span></a></div>
<?php }?>
<?php if($TPL_V1["invoice_send_yn"]=='y'){?>
					<a href="javascript:printInvoiceView('<?php echo $TPL_V1["order_seq"]?>','<?php echo $TPL_V1["export_code"]?>')"><span class="icon-print-invoice"></span></a>
<?php }?>
<?php }else{?>
					<select name="international_shipping_method[<?php echo $TPL_V1["export_code"]?>]" class="waybill_number <?php if($TPL_V1["international"]!='international'||!$TPL_V1["international_company_array"]){?>hide<?php }?>">
<?php if(is_array($TPL_R2=$TPL_V1["international_company_array"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["company"]==$TPL_V1["international_shipping_method"]){?>
						<option value='<?php echo $TPL_V2["company"]?>' style='background-color:yellow' selected><?php echo str_replace('?????? > ','',$TPL_V2["method"])?></option>
<?php }else{?>
						<option value='<?php echo $TPL_V2["company"]?>'><?php echo str_replace('?????? > ','',$TPL_V2["method"])?></option>
<?php }?>
<?php }}?>
					</select>
					<input type="text" name="international_delivery_no[<?php echo $TPL_V1["export_code"]?>]" class="line waybill_number delivery_number" value="<?php echo $TPL_V1["international_delivery_no"]?>" style="width:90%;" />
<?php }?>
				</div>

				<input type="hidden" name="shipping_provider_seq" class="shipping_provider_seq" value="<?php echo $TPL_V1["shipping_provider_seq"]?>" />

				<!-- ???????????? :: START -->
				<div class="store_lay <?php if($TPL_V1["shipping_method"]!='direct_store'){?>hide<?php }?>">
					<input type="hidden" class="store_scm_type_<?php echo $TPL_V1["export_code"]?>" name="export_store_scm_type[<?php echo $TPL_V1["export_code"]?>]" value="<?php echo $TPL_V1["store_scm_type"]?>" />
					<select name="export_address_seq[<?php echo $TPL_V1["export_code"]?>]" onchange="store_set(this, '<?php echo $TPL_V1["export_code"]?>');">
<?php if(is_array($TPL_R2=$TPL_V1["shipping_store_info"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<option value="<?php echo $TPL_V2["shipping_address_seq"]?>" scm_type="<?php echo $TPL_V2["store_scm_type"]?>" <?php if($TPL_V2["shipping_address_seq"]==$TPL_V1["shipping_address_seq"]){?>selected<?php }?>><?php echo $TPL_V2["shipping_store_name"]?></option>
<?php }}?>
					</select>
				</div>
				<!-- ???????????? :: END -->

				<!-- ????????? ?????? :: START -->
				<div class="address_lay <?php if($TPL_V1["shipping_method"]=='direct_store'){?>hide<?php }?>">
					<span class="hand" onclick="address_pop('<?php echo $TPL_V1["sending_address"]['address_category']?>','<?php echo $TPL_V1["sending_address"]['address_name']?>','<?php echo $TPL_V1["sending_address"]['view_address']?>','<?php echo $TPL_V1["sending_address"]['shipping_phone']?>');"><?php echo $TPL_V1["sending_address"]['address_name']?></span>
				</div>
				<!-- ????????? ?????? :: END -->

				<!-- ?????? ?????? :: END -->

				<div class="hide">
<?php if($TPL_V1["international"]=='domestic'){?>
<?php }else{?>
<?php if($TPL_V1["international_shipping_method"]!='ups'){?>
					<a href="<?php echo get_delivery_company(get_international_method_code(strtoupper($TPL_V1["international_shipping_method"])),'url')?><?php echo $TPL_V1["international_delivery_no"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["international_delivery_no"]?> ????????????</span></a>
<?php }else{?>
					<?php echo $TPL_V1["international_delivery_no"]?> ????????????
<?php }?>
<?php }?>

<?php if($TPL_V1["delivery_number"]){?>
					<a href="<?php echo $TPL_V1["tracking_url"]?>" target="_blank"><span class="blue">
				<?php echo $TPL_V1["delivery_company_array"][$TPL_V1["delivery_company_code"]]["company"]?> <?php echo $TPL_V1["delivery_number"]?> ????????????</span></a>
<?php }else{?>
					<a href="javascript:alert('?????????????????? ????????????.');"><span class="blue">????????????</span></a>
<?php }?>
				</div>
			</td>
<?php }?>
			<!--????????????-->
			<td><?php echo $TPL_V1["ea"]?></td>
			<!--???????????????-->
			<td><?php if(strtotime($TPL_V1["complete_date"])> 0){?><?php echo $TPL_V1["complete_date"]?><?php }?></td>
			<!--???????????????-->
			<td  nowrap="nowrap" >
<?php if($TPL_V1["goods_kind"]=='coupon'){?>
				<div class="coupon_use_log_hand hand">
<?php if($TPL_V1["coupon_use_log"]){?>
					<div style="width:100%;" class="orange">
<?php if(is_array($TPL_R2=$TPL_V1["coupon_use_log"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<div class="underline">
									<span class="left">
										<?php echo date('Y-m-d',strtotime($TPL_V2["regist_date"]))?>

									</span>
							<span class="right">
<?php if($TPL_V2["coupon_value_type"]=='price'){?><?php echo get_currency_price($TPL_V2["coupon_use_value"], 3)?><?php }else{?><?php echo number_format($TPL_V2["coupon_use_value"])?>???<?php }?>
									</span>
						</div>
<?php }}?>
					</div>
<?php }?>
					<div class="coupon_use_log_table hide" >
<?php if($TPL_V1["coupon_use_log"]){?>
						<div style="width:100%;margin-top:10px;" class="hand">
							<table width="100%" class="simpledata-table-style">
								<thead>
								<tr>
									<th>?????? ??????</th>
									<th>??????</th>
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
									<td class="center">
<?php if($TPL_V2["coupon_value_type"]=='price'){?><?php echo get_currency_price($TPL_V2["coupon_use_value"], 3)?><?php }else{?><?php echo number_format($TPL_V2["coupon_use_value"])?>???<?php }?>
									</td>
									<td class="center">
										<?php echo $TPL_V2["coupon_use_area"]?>

<?php if(serviceLimit('H_AD')){?>
										(<?php echo number_format($TPL_V2["address_commission"])?>%)
<?php }?>
									</td>
									<td class="center"><?php if($TPL_V2["confirm_user"]){?><?php echo $TPL_V2["confirm_user"]?><?php }else{?><?php echo $TPL_V2["manager_id"]?><?php }?></td>
								</tr>
<?php }}?>
								</tbody>
							</table>
						</div>
<?php }?>
					</div>
				</div>
<?php }else{?>
<?php if(strtotime($TPL_V1["shipping_date"])> 0){?><?php echo $TPL_V1["shipping_date"]?><?php }?>
<?php }?>
			</td>
			<!--????????????-->
			<td>
				<div class="<?php if($TPL_V1["goods_kind"]=='coupon'){?> coupon_status_btn hand <?php }?>" <?php if($TPL_V1["goods_kind"]=='coupon'){?> socialcp_status="<?php echo $TPL_V1["socialcp_status"]?>" <?php }?> >
<?php if($_GET["export_code"]==$TPL_V1["export_code"]){?>
				<span style="background-color:yellow"><?php echo $TPL_V1["mstatus"]?></span></div>
<?php }else{?>
<?php echo $TPL_V1["mstatus"]?>

<?php }?>
</div>
</td>
<!--???????????? ??????-->
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
	<span class="btn large icon red"><button type="button" class="coupon_use_btn" order_seq="<?php echo $TPL_VAR["orders"]["order_seq"]?>">?????? ???????????? ??? ?????? ?????????</button></span>
</div>
<?php }?>

<div class="item-title">??????<span class="title_order_number">(<?php echo $TPL_VAR["orders"]["order_seq"]?>)</span>??? ??????/??????/?????? ??????</div>
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
			<a href="../refund/view?no=<?php echo $TPL_V1["refund_code"]?>" target="_blank">
<?php if($_GET["refund_code"]==$TPL_V1["refund_code"]){?>
				<span style="background-color:yellow"><?php echo $TPL_V1["refund_code"]?></span>
<?php }else{?>
				<span class="blue"><?php echo $TPL_V1["refund_code"]?></span>
<?php }?>
			</a>
		</td>
		<td><?php echo get_currency_price($TPL_V1["refund_price"])?></td>
		<td><?php echo number_format($TPL_V1["ea"])?></td>
		<td>
<?php if($_GET["refund_code"]==$TPL_V1["refund_code"]){?>
			<span style="background-color:yellow"><?php echo $TPL_V1["mstatus"]?></span>
<?php }else{?>
			<?php echo $TPL_V1["mstatus"]?>

<?php }?>
		</td>
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
			<a href="../returns/view?no=<?php echo $TPL_V1["return_code"]?>" target="_blank">
<?php if($_GET["return_code"]==$TPL_V1["return_code"]){?>
				<span class="blue" style="background-color:yellow"><?php echo $TPL_V1["return_code"]?></span>
<?php }else{?>
				<span class="blue"><?php echo $TPL_V1["return_code"]?></span>
<?php }?>
			</a>
		</td>
		<td><?php echo get_currency_price($TPL_V1["return_price"])?></td>
		<td><?php echo number_format($TPL_V1["ea"])?></td>
		<td>
<?php if($_GET["return_code"]==$TPL_V1["return_code"]){?>
			<span style="background-color:yellow"><?php echo $TPL_V1["mstatus"]?></span>
<?php }else{?>
			<?php echo $TPL_V1["mstatus"]?>

<?php }?>
		</td>
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
		<td><?php echo $TPL_V1["mstatus"]?></td>
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
<!-- ????????????  : ??? -->
<?php }?>

<!-- ????????????/????????????/???????????? ????????? ?????? ??? -->
<!-- <?php if(in_array($TPL_VAR["pagemode"],array('export_view','refund_view','return_view'))){?> -->
<script type="text/javascript">
	$(function(){
	})
</script>
</div>
<!-- <?php if($TPL_VAR["pagemode"]=='export_view'){?> -->
<div class="center pdb10">
	<span id="order_summary_open_<?php echo $TPL_VAR["orders"]["order_seq"]?>" order_seq="<?php echo $TPL_VAR["orders"]["order_seq"]?>" class="export_order_summary_open btn medium"><button type="button">?????????(<?php echo $TPL_VAR["orders"]["order_seq"]?>) ?????? ????????????  ???</button></span>
	<span id="order_summary_close_<?php echo $TPL_VAR["orders"]["order_seq"]?>" order_seq="<?php echo $TPL_VAR["orders"]["order_seq"]?>" class="export_order_summary_close btn medium" style="display:none"><button  type="button">?????????(<?php echo $TPL_VAR["orders"]["order_seq"]?>) ?????? ?????? ???</button></span>
</div>
<?php }?>
<!-- <?php }?> -->
<!-- ????????????/????????????/???????????? ????????? ?????? ??? -->

<!-- ????????????/????????????/????????????/???????????? ????????? ?????? ?????? -->
<?php if($TPL_VAR["pagemode"]!="order_catalog"&&$TPL_VAR["pagemode"]!="company_catalog"){?>
<div id="order-summary-title<?php if($TPL_VAR["pagemode"]=='export_view'){?>_<?php echo $TPL_VAR["orders"]["order_seq"]?><?php }?>" class="item-title item-title-order-item order-summary">????????????
	<!-- #32781 ?????????????????? ????????? ?????? ?????? ?????? by hed -->
<?php if($TPL_VAR["orders"]["step"]< 75&&$TPL_VAR["orders"]["real_stock"]==='?????????'){?>
	<span class="fx11 red">???????????? ????????? ????????????. ?????? ?????? ?????? ??? ????????? ??????????????????.</span>
<?php }elseif($TPL_VAR["orders"]["step"]< 75&&$TPL_VAR["orders"]["miss_stock"]=='Y'){?>
	<span class="fx11 red">????????? ????????? ???????????????. ?????? ?????? ??? ????????? ??????????????????.</span>
<?php }?>
</div>
<?php }?>
<!-- ???????????? ?????? -->
<div id="order-summary<?php if($TPL_VAR["pagemode"]=='export_view'){?>_<?php echo $TPL_VAR["orders"]["order_seq"]?><?php }?>" class="order-summary">
	<table class="order-summary-table" width="100%" border=0>
		<colgroup>
			<col /><!--????????????-->
			<col width="5%" /><!--??????-->
			<col width="5%" /><!--????????????-->
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
			<th class="dark">
				<span class="deepGreen">??????</span>
			</th>
			<th class="dark">????????????</th>
			<th class="dark">????????????<br /><span class="desc">(????????????)</span></th>
			<th class="dark">??????????????????<br /><span class="desc">(??????)</span></th>
			<th class="dark">??????????????????
				<span class="helpicon2 detailDescriptionLayerBtn" title="??????????????????/???????????????"></span>
				<div class="detailDescriptionLayer hide">????????? ????????? ?????? ?????????????????????.<br />??????/??????/?????? ??? ??????????????? ?????? ??? ????????????.</div>
			</th>
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
			<th class="dark">??????<br />
				<span class="helpicon2 detailDescriptionLayerBtn" title="??????"></span>
				<div class="detailDescriptionLayer hide">[???????????? ?????? ??????] ????????????</div>
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
<?php if($TPL_V3["talkbuy_product_order_id"]){?><div class="kgray bold"><?php echo $TPL_V3["talkbuy_product_order_id"]?><span style="font-size:11px;font-weight:normal"> (Kpay??????????????????)</span></div><?php }?>
<?php if($TPL_V3["order_goodstype"]||$TPL_V2["bs_seq"]){?>
							<div>
<?php if(is_array($TPL_R4=$TPL_V3["order_goodstype"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?><img src="/admin/skin/default/images/design/icon_order_<?php echo $TPL_K4?>.gif" align="absmiddle" title="<?php echo $TPL_V4?>" hspace=1 vspace=1/><?php }}?>
<?php if($TPL_V2["bs_seq"]&&$TPL_V2["bs_type"]){?>
								<img src="/admin/skin/default/images/design/icon_broadcast_<?php echo $TPL_V2["bs_type"]?>.png" align="absmiddle" title="<?php echo $TPL_V2["bs_type"]?>" hspace=1 vspace=1/>
<?php }?>
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
<?php if($TPL_V2["goods_type"]!='gift'){?>
							<div style="padding-top:3px;">
								<img src="/admin/skin/default/images/design/btn_stats.gif" style="cursor:pointer;" onclick="openAdvancedStatistic('<?php echo $TPL_V2["goods_seq"]?>');" align="absmiddle"  />
							</div>
<?php }?>
<?php if($TPL_V2["tax"]=='exempt'){?>
							<div style="padding-top:3px;">
								<img src="/admin/skin/default/images/common/icon/taxfree.gif" alt="?????????" style="vertical-align: middle;"/>
							</div>
<?php }?>
<?php if($TPL_V2["event_seq"]&&$TPL_V2["event_title"]){?>
							<div style="padding-top:3px;">
								<a href="/admin/event/<?php if($TPL_V1["event_type"]=='solo'){?>solo<?php }?>regist?event_seq=<?php echo $TPL_V2["event_seq"]?>" target='_blank'><span class="btn small gray"><button type="button" class="goods_event hand"><?php echo $TPL_V2["event_title"]?></button></span></a>
							</div>
<?php }?>
<?php if($TPL_V2["bs_seq"]&&$TPL_V2["bs_title"]){?>
							<div style="padding-top:3px;">
								<a href="/broadcast/<?php if($TPL_V2["bs_type"]=='vod'){?>vod<?php }else{?>player<?php }?>?no=<?php echo $TPL_V2["bs_seq"]?>" target='_blank'><span class="btn small gray"><button type="button" class="goods_event hand"><?php echo $TPL_V2["bs_title"]?></button></span></a>
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
								<a href="/mypage_process/filedown?file=<?php echo $TPL_V4["value"]?>" target="actionFrame"><?php echo $TPL_V4["value"]?></a>
<?php }else{?><?php echo $TPL_V4["value"]?><?php }?>
							</div>
<?php }?>
<?php }}?>
<?php }?>

							<!--??????????????????????????? ??????-->
<?php if($TPL_VAR["pagemode"]==""){?>

							<div>
								<span class="btn small cyanblue" onclick="set_goods_list('<?php echo $TPL_VAR["orders"]["member_seq"]?>','<?php echo $TPL_V3["item_seq"]?>','<?php echo $TPL_V3["item_option_seq"]?>','rematch')"><button type="button">??????</button></span>
								<!-- ????????? ????????? ?????? : ????????????(????????? ???)??? ?????? -->
<?php if(!$TPL_VAR["linkage_mallnames"]&&!$TPL_VAR["orders"]["linkage_mall_code"]&&$TPL_VAR["orders"]["orign_order_seq"]&&$TPL_VAR["orders"]["step"]== 25&&(!$TPL_VAR["npay_use"]||($TPL_VAR["npay_use"]&&$TPL_VAR["orders"]['pg']!='npay'))&&$TPL_V3["package_yn"]!='y'){?>
								<span class="btn small cyanblue" onclick="set_goods_list('<?php echo $TPL_VAR["orders"]["member_seq"]?>','<?php echo $TPL_V3["item_seq"]?>','<?php echo $TPL_V3["item_option_seq"]?>','reorder')"><button type="button">??????</button></span>
<?php }?>
								<!-- ????????????????????? ????????? ????????? ??????/??????????????? ????????? ?????? ?????? -->
								<!-- 2022/05/24 ?????? ????????? ????????? ?????? ?????? ????????? ????????? ????????? ?????? ?????? ???????????? 834??? ?????? - ????????? -->
<?php if((!$TPL_V2["goods_seq"]||$TPL_V3["nomatch"]> 0)&&$TPL_V3["step"]< 40&&$TPL_V2["goods_type"]!='gift'){?>
								<span class="btn small cyanblue" onclick="set_goods_list('<?php echo $TPL_VAR["orders"]["member_seq"]?>','<?php echo $TPL_V3["item_seq"]?>','<?php echo $TPL_V3["item_option_seq"]?>','rematch')"><button type="button">??????</button></span>
<?php }?>
<?php if($TPL_V2["goods_type"]=="gift"){?>
<?php if($TPL_V2["gift_title"]){?><div><span class="fx11"><?php echo $TPL_V2["gift_title"]?></span> <span class="btn small gray"><button type="button" class="gift_log" order_seq="<?php echo $TPL_V2["order_seq"]?>" item_seq="<?php echo $TPL_V2["item_seq"]?>">?????????</button></span></div><?php }?>
<?php }?>
							</div>
<?php }?>

<?php if($TPL_V3["package_yn"]!='y'&&($TPL_V3["whinfo"]["wh_name"]||$TPL_V3["goods_code"])){?>
							<div class="warehouse-info-lay">
								<ul>
<?php if($TPL_V3["whinfo"]["wh_name"]){?>
									<li>
										<?php echo $TPL_V3["whinfo"]["wh_name"]?> <?php if($TPL_V3["whinfo"]["location_code"]){?>(<?php echo $TPL_V3["whinfo"]["location_code"]?>)<?php }?> : <?php echo number_format($TPL_V3["whinfo"]["ea"])?>(<?php echo number_format($TPL_V3["whinfo"]["badea"])?>)
									</li>
<?php }?>
<?php if($TPL_V3["goods_code"]){?><li>???????????? : <?php echo $TPL_V3["goods_code"]?></li><?php }?>
								</ul>
							</div>
<?php }?>
						</td>
					</tr>
				</table>
			</td>
			<td class="center info ea"><?php if($TPL_V3["package_yn"]=='y'){?>[<?php }?><?php echo $TPL_V3["ea"]?><?php if($TPL_V3["package_yn"]=='y'){?>]<?php }?></td>
			<td class="price info">
				<div>
					<span class="deepGreen underline"><?php echo get_currency_price($TPL_V3["out_supply_price"])?></span>
				</div>
			</td>
			<td class="price info"><?php echo get_currency_price($TPL_V3["out_price"])?></td>
			<td class="price info">
				<div class="hand underline under_div_view">
					<?php echo get_currency_price($TPL_V3["out_tot_sale"])?>

					<div class="relative under_div_view_contents  hide">
						<div class="sale_price_layer" style="<?php if(serviceLimit('H_AD')){?>width:400px;<?php }else{?>width:250px;<?php }?>">
							<div class="title_line">????????????</div>
							<br style="line-height:10px;" />
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<col width="55" />
								<col width="115" />
<?php if(serviceLimit('H_AD')){?>
								<col width="70" />
<?php }else{?>
								<col />
<?php }?>
<?php if(serviceLimit('H_AD')){?>
								<col width="70" />
								<col />
<?php }?>
								<tr>
									<th colspan="2">??????</th>
									<th class="<?php if(serviceLimit('H_NAD')){?>ends<?php }?>bolds">??????</th>
<?php if(serviceLimit('H_AD')){?>
									<th>?????? ??????</th>
									<th class="ends">????????? ??????</th>
<?php }?>
								</tr>
								<tr>
									<td class="gr">?????????</td>
									<td class="gr"><?php if($TPL_V3["out_event_sale"]> 0){?><?php }?></td>
									<td class="bolds prices <?php if(serviceLimit('H_NAD')){?>ends<?php }?>">
										<?php echo get_currency_price($TPL_V3["out_event_sale"])?>

									</td>
<?php if(serviceLimit('H_AD')){?>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_event_sale"]-$TPL_V3["event_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V3["event_provider"])?>

									</td>
<?php }?>
								</tr>
								<tr>
									<td class="gr">????????????</td>
									<td class="gr"><?php if($TPL_V3["out_multi_sale"]> 0){?><?php }?></td>
									<td class="bolds prices <?php if(serviceLimit('H_NAD')){?>ends<?php }?>">
										<?php echo get_currency_price($TPL_V3["out_multi_sale"])?>

									</td>
<?php if(serviceLimit('H_AD')){?>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_multi_sale"]-$TPL_V3["multi_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V3["multi_provider"])?>

									</td>
<?php }?>
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
									<td class="bolds prices <?php if(serviceLimit('H_NAD')){?>ends<?php }?>">
										<?php echo get_currency_price($TPL_V3["out_coupon_sale"])?>

									</td>
<?php if(serviceLimit('H_AD')){?>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_coupon_sale"]-$TPL_V3["coupon_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V3["coupon_provider"])?>

									</td>
<?php }?>
								</tr>

								<tr>
									<td class="gr">??????</td>
									<td class="gr"><?php if($TPL_V3["out_member_sale"]> 0){?><?php echo $TPL_VAR["members"]["group_name"]?><?php }?></td>
									<td class="bolds prices <?php if(serviceLimit('H_NAD')){?>ends<?php }?>">
										<?php echo get_currency_price($TPL_V3["out_member_sale"])?>

									</td>
<?php if(serviceLimit('H_AD')){?>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_member_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
<?php }?>
								</tr>

								<tr>
									<td class="gr">?????????</td>
									<td class="gr"></td>
									<td class="bolds prices <?php if(serviceLimit('H_NAD')){?>ends<?php }?>">
										<?php echo get_currency_price($TPL_V3["out_mobile_sale"])?>

									</td>
<?php if(serviceLimit('H_AD')){?>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_mobile_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
<?php }?>
								</tr>

								<tr>
									<td class="gr">??????</td>
									<td class="gr">
<?php if($TPL_V3["out_promotion_code_sale"]> 0){?>
										<div class="url-ctrl underline"><a href="javascript:open_saleinfo_layer('promotion_code','<?php echo $TPL_V3["promotion_code_seq"]?>','<?php echo $TPL_V3["item_option_seq"]?>')"><?php echo $TPL_V3["promotion_info"]["promotion_name"]?></a></div>
<?php }?>
									</td>
									<td class="bolds prices <?php if(serviceLimit('H_NAD')){?>ends<?php }?>">
										<?php echo get_currency_price($TPL_V3["out_promotion_code_sale"])?>

									</td>
<?php if(serviceLimit('H_AD')){?>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_promotion_code_sale"]-$TPL_V3["promotion_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V3["promotion_provider"])?>

									</td>
<?php }?>
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
									<td class="bolds prices <?php if(serviceLimit('H_NAD')){?>ends<?php }?>">
										<?php echo get_currency_price($TPL_V3["out_referer_sale"])?>

									</td>
<?php if(serviceLimit('H_AD')){?>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_referer_sale"]-$TPL_V3["referer_provider"])?>

									</td>
									<td class="ends prices">
										<?php echo get_currency_price($TPL_V3["referer_provider"])?>

									</td>
<?php }?>
								</tr>

								<tr>
									<td class="gr">????????????</td>
									<td class="gr"></td>
									<td class="bolds prices <?php if(serviceLimit('H_NAD')){?>ends<?php }?>">
										<?php echo get_currency_price($TPL_V3["out_emoney_sale"])?>

									</td>
<?php if(serviceLimit('H_AD')){?>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_emoney_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
<?php }?>
								</tr>

								<tr>
									<td class="gr">?????????</td>
									<td class="gr"></td>
									<td class="bolds prices <?php if(serviceLimit('H_NAD')){?>ends<?php }?>">
										<?php echo get_currency_price($TPL_V3["out_enuri_sale"])?>

									</td>
<?php if(serviceLimit('H_AD')){?>
									<td class="prices">
										<?php echo get_currency_price($TPL_V3["out_enuri_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
<?php }?>
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

					<div class="relative hide under_div_view_contents">
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
					<div class="relative hide under_div_view_contents">
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
					<a href="/admin/returns/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return_exchange.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V3["exchange_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V3["return_list_ea"]){?>
					<a href="/admin/returns/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V3["return_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V3["refund_list_ea"]){?>
					<a href="/admin/refund/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_refund.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V3["refund_list_ea"]?></span></a>
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
<?php if(serviceLimit('H_AD')){?>
				<div class="blue">
<?php if($TPL_V1["shipping"]["provider_seq"]== 1){?>
					??????
<?php }else{?>
					<?php echo $TPL_V1["shipping"]["provider_name"]?>

<?php }?>
				</div>
<?php }?>

<?php if($TPL_VAR["orders"]["sitetype"]=="POS"){?>
				<!-- ????????? ????????? ?????? POS ????????? ??????????????? ????????? ?????? ????????? ????????? -->
				<div class="lsp-1">[<?php echo $TPL_V1["shipping"]["shipping_set_name"]?>]<?php echo $TPL_V1["shipping"]["shipping_store_name"]?></div>
<?php }else{?>
<?php if(preg_match('/gift/',$TPL_V1["shipping"]["shipping_group"])){?>
				???????????????
<?php }else{?>
				<div>
							<span>
<?php if($TPL_V1["shipping"]["shipping_method_name"]=='??????'){?>
									??????
<?php }else{?>
									<?php echo $TPL_V1["shipping"]["shipping_set_name"]?>

<?php }?>
							</span>
<?php if($TPL_VAR["orders"]["international_country"]){?><span class="pdl5 lsp-1"><?php echo $TPL_VAR["orders"]["international_country"]?></span><?php }?>
				</div>
<?php if($TPL_V1["shipping"]["shipping_set_code"]=='direct_store'){?>
				<div class="lsp-1">???????????? : <?php echo $TPL_V1["shipping"]["shipping_store_name"]?></div>
<?php }else{?>
				<div class="detailDescriptionLayerBtn hand" title="????????? ??????">
							<span class="bold">
<?php if($TPL_V1["shipping"]["shipping_type"]=='postpaid'){?>
<?php if($TPL_V1["shipping"]["postpaid"]> 0){?>
									<?php echo get_currency_price($TPL_V1["shipping"]["postpaid"], 3)?>

<?php }else{?>
									??????
<?php }?>
<?php }else{?>
<?php if($TPL_V1["shipping"]["shipping_cost"]> 0){?>
									<?php echo get_currency_price($TPL_V1["shipping"]["shipping_cost"], 3)?>

<?php }else{?>
									??????
<?php }?>
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
								<a href="/mypage_process/filedown?file=<?php echo $TPL_V5["value"]?>" target="actionFrame"><?php echo $TPL_V5["value"]?></a>
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
					<span class="helpicon2 detailDescriptionLayerBtn" title="?????????/???????????? ????????????"></span>
					<div class="detailDescriptionLayer hide">?????? ???????????? ???????????? 1????????? ?????? ??????????????? ????????????</div>
				</div>
			</td>
			<td class="package-option price info"><span class="deepGreen"><?php echo get_currency_price($TPL_V4["supply_price"]*$TPL_V4["unit_ea"]*$TPL_V3["ea"])?></span></td>
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
<?php if($TPL_V4["talkbuy_product_order_id"]){?><div class="kgray bold"><?php echo $TPL_V4["talkbuy_product_order_id"]?><span style="font-size:11px;font-weight:normal"> (Kpay??????????????????)</span></div><?php }?>
							<img src="/admin/skin/default/images/common/icon_add.gif" align="absmiddle" />

							<span class="desc"><?php echo $TPL_V4["title"]?>:<?php echo $TPL_V4["suboption"]?></span>
<?php if($TPL_V4["package_yn"]!='y'&&($TPL_V4["goods_code"]||$TPL_V4["whinfo"]["wh_name"])){?>
							<div class="warehouse-info-lay">
								<ul>
<?php if($TPL_V4["whinfo"]["wh_name"]){?>
									<li>
										<?php echo $TPL_V4["whinfo"]["wh_name"]?> <?php if($TPL_V4["whinfo"]["location_code"]){?>(<?php echo $TPL_V4["whinfo"]["location_code"]?>)<?php }?> : <?php echo number_format($TPL_V4["whinfo"]["ea"])?>(<?php echo number_format($TPL_V4["whinfo"]["badea"])?>)
									</li>
<?php }?>
<?php if($TPL_V4["goods_code"]){?><li>???????????? : <?php echo $TPL_V4["goods_code"]?></li><?php }?>
								</ul>
							</div>
<?php }?>
						</td>
					</tr>
				</table>
<?php }?>
			</td>
			<td class="center info suboption ea"><?php if($TPL_V4["package_yn"]=='y'){?>[<?php }?><?php echo number_format($TPL_V4["ea"])?><?php if($TPL_V4["package_yn"]=='y'){?>]<?php }?></td>
			<td class="price info suboption">

				<div class="hand under_div_view">
					<span class="deepGreen underline"><?php echo get_currency_price($TPL_V4["out_supply_price"])?></span>
					<div class="relative under_div_view_contents  hide">
						<div class="sale_price_layer" style="width:100px;">
<?php if($TPL_V4["out_supply_price"]> 0){?><?php echo $TPL_V4["out_supply_price"]?><?php }?>
						</div>
					</div>
				</div>
			</td>
			<td class="price info suboption"><?php echo get_currency_price($TPL_V4["out_price"])?></td>
			<td class="price info suboption">
				<div class="under_div_view hand underline">
					<?php echo get_currency_price($TPL_V4["out_tot_sale"])?>

					<div class="relative under_div_view_contents  hide">
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
										<?php echo get_currency_price($TPL_V4["out_event_sale"])?>

									</td>
									<td class="ends prices">
										0
									</td>
								</tr>

								<tr>
									<td class="gr">????????????</td>
									<td class="bolds  prices">
										<?php echo get_currency_price($TPL_V4["out_multi_sale"])?>

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
									<td class="bolds prices ">
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
									<td class="bolds prices">
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

					<div class="relative hide under_div_view_contents">
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
					<div class="relative hide under_div_view_contents">
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
					<a href="/admin/returns/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return_exchange.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V4["exchange_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V4["return_list_ea"]){?>
					<a href="/admin/returns/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_return.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V4["return_list_ea"]?></span></a>
<?php }?>
<?php if($TPL_V4["refund_list_ea"]){?>
					<a href="/admin/refund/catalog?keyword=<?php echo $TPL_V2["order_seq"]?>" target="_blank"><img src='/admin/skin/default/images/common/icon/icon_list_refund.gif' align="absmiddle"><span style="font-size:11px;color:#ea3b91"><?php echo $TPL_V4["refund_list_ea"]?></span></a>
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
								<a href="/mypage_process/filedown?file=<?php echo $TPL_V5["value"]?>" target="actionFrame"><?php echo $TPL_V6["value"]?></a>
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
				<span class="helpicon2 detailDescriptionLayerBtn" title="?????????/???????????? ????????????"></span>
				<div class="detailDescriptionLayer hide">?????? ???????????? ???????????? 1????????? ?????? ??????????????? ????????????</div>
			</td>
			<td class="package-option price info">
				<span class="deepGreen"><?php echo get_currency_price($TPL_V5["supply_price"]*$TPL_V5["unit_ea"]*$TPL_V4["ea"])?></span>
			</td>
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
			<td class="price info">
				<strong>
					<span class="deepGreen"><?php echo get_currency_price($TPL_VAR["items_tot"]["supply_price"])?></span>
				</strong>
			</td>
			<td class="price info"><strong><?php echo get_currency_price($TPL_VAR["items_tot"]["price"])?></strong></td>
			<td class="price info">
				<strong><?php echo get_currency_price($TPL_VAR["items_tot"]["enuri_sale"]+$TPL_VAR["items_tot"]["event_sale"]+$TPL_VAR["items_tot"]["multi_sale"]+$TPL_VAR["items_tot"]["coupon_sale"]+$TPL_VAR["items_tot"]["member_sale"]+$TPL_VAR["items_tot"]["fblike_sale"]+$TPL_VAR["items_tot"]["mobile_sale"]+$TPL_VAR["items_tot"]["promotion_code_sale"]+$TPL_VAR["items_tot"]["referer_sale"]+$TPL_VAR["items_tot"]["emoney_sale"])?></strong>
				<div class="desc">(<?php echo get_currency_price($TPL_VAR["items_tot"]["coupon_provider"]+$TPL_VAR["items_tot"]["promotion_provider"]+$TPL_VAR["items_tot"]["referer_provider"]+$TPL_VAR["items_tot"]["multi_provider"]+$TPL_VAR["items_tot"]["event_provider"])?>)</div>
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

<?php if($TPL_VAR["pagemode"]!="company_catalog"){?>
	<div align="center">
		<table cellpadding="0" cellspacing="5" class="order-sale-summary" border="0" width="90%">
			<col width="20%" /><col width="5%" />
			<col width="20%" /><col width="5%" />
			<col width="20% "/><col width="5%" />
			<col width="25%"/>
			<tr class="total-sale-title">
				<td>
					<div class="detail-sale-box"><span class="math-price">??? ???????????? <?php echo get_currency_price($TPL_VAR["items_tot"]["price"], 3,'','<span>_str_price_</span>')?></span></div>
				</td>
				<td class="center"><span class="math-icon"><img src="/admin/skin/default/images/common/icon_plus.gif" border="0"></span></td>
				<td>
					<div class="detail-sale-box">
					<span class="math-price">
						????????? <?php echo get_currency_price($TPL_VAR["shipping_tot"]["shipping_cost"], 3,'','<span>_str_price_</span>')?>

						<img src="/admin/skin/default/images/common/btn_open.gif" border="0" class="order-sale-btn hand" onclick="open_sale_contents(this);" />
					</span>
					</div>
				</td>

				<td class="center"><span class="math-icon"><img src="/admin/skin/default/images/common/icon_minus.gif" border="0"></span></td>
				<td>
					<div class="detail-sale-box">
					<span class="math-price">???????????? <?php echo get_currency_price($TPL_VAR["total_sale_price"], 3,'','<span>_str_price_</span>')?>

						<img src="/admin/skin/default/images/common/btn_open.gif" border="0" class="order-sale-btn hand" onclick="open_sale_contents(this);" />
					</span>
					</div>
				</td>

				<td class="center"><span class="math-icon"><img src="/admin/skin/default/images/common/icon_equal.gif" border="0"></span></td>
				<td>
					<div class="detail-sale-box wx250">
					<span class="math-price">??? ???????????? <?php echo get_currency_price($TPL_VAR["orders"]["settleprice"]+$TPL_VAR["orders"]["cash"], 3,'','<span>_str_price_</span>')?>

						<img src="/admin/skin/default/images/common/btn_open.gif" border="0" class="order-sale-btn hand" onclick="open_sale_contents(this);" />
					</span>
					</div>
				</td>
			</tr>
			<tr class="detail-sale-summary">
				<td></td>
				<td></td>
				<td>
					<div class="detail-sale-box hide">
						<div>
							?????? ??? ??????  <?php echo get_currency_price($TPL_VAR["shipping_tot"]["goods_shipping_cost"]+$TPL_VAR["shipping_tot"]["shipping_cost"], 3,'','<span>_str_price_</span>')?>

						</div>

						<div>
							<ul>
								<li class="ml10 li-disc">
									?????? ????????? : <span class="price-text"><?php echo get_currency_price($TPL_VAR["shipping_tot"]["std_shipping_cost"], 3)?></span>
								</li>
								<li class="ml10 li-disc">
									?????? ????????? : <span class="price-text"><?php echo get_currency_price($TPL_VAR["shipping_tot"]["add_shipping_cost"], 3)?></span>
								</li>
								<li class="ml10 li-disc">
									?????? ????????? : <span class="price-text"><?php echo get_currency_price($TPL_VAR["shipping_tot"]["hop_shipping_cost"], 3)?></span>
								</li>
							</ul>
						</div>

						<div class="mt10 left" style="padding:0px;">
							?????? <?php echo get_currency_price($TPL_VAR["shipping_tot"]["postpaid_cost"], 3)?>

							<span class="helpicon2 detailDescriptionLayerBtn" title="??????"></span>
							<div class="detailDescriptionLayer hide" style="width:300px !important">?????? ???????????? ??????????????? ???????????? ????????????.</div>
						</div>
						<div>
							<ul>
								<li class="ml10 li-disc">
									?????? ????????? : <span class="price-text"><?php echo get_currency_price($TPL_VAR["shipping_tot"]["std_postpaid_cost"], 3)?></span>
								</li>
								<li class="ml10 li-disc">
									?????? ????????? : <span class="price-text"><?php echo get_currency_price($TPL_VAR["shipping_tot"]["add_postpaid_cost"], 3)?></span>
								</li>
								<li class="ml10 li-disc">
									?????? ????????? : <span class="price-text"><?php echo get_currency_price($TPL_VAR["shipping_tot"]["hop_postpaid_cost"], 3)?></span>
								</li>
							</ul>
						</div>
					</div>
				</td>
				<td></td>
				<td>
					<div class="detail-sale-box hide">
						<div>
							????????? :
							<?php echo get_currency_price($TPL_VAR["items_tot"]["event_sale"], 3,'','<span class="price-text">_str_price_</span>')?>

						</div>

						<div>
							???????????? :
							<?php echo get_currency_price($TPL_VAR["items_tot"]["multi_sale"], 3,'','<span class="price-text">_str_price_</span>')?>

						</div>

						<div>
<?php if($TPL_VAR["items_tot"]["coupon_sale"]> 0){?>
							<span class="underline open-link"><a href="javascript:open_saleinfo_layer('coupon_ordno_goods_ordersheet','<?php echo $TPL_VAR["orders"]["order_seq"]?>','')">?????? <?php echo get_currency_price($TPL_VAR["items_tot"]["coupon_sale"], 3,'','<span class="price-text">_str_price_</span>')?></a></span>
<?php }else{?>
							?????? : <?php echo get_currency_price($TPL_VAR["items_tot"]["coupon_sale"], 3,'','<span class="price-text">_str_price_</span>')?></a>
<?php }?>
						</div>
						<div>
<?php if($TPL_VAR["items_tot"]["promotion_code_sale"]> 0){?>
							<span class="underline open-link"><a href="javascript:open_saleinfo_layer('promotion_ordno','<?php echo $TPL_VAR["orders"]["order_seq"]?>','')">?????? : <?php echo get_currency_price($TPL_VAR["items_tot"]["promotion_code_sale"], 3,'','<span class="price-text">_str_price_</span>')?></a><span>
<?php }else{?>
							?????? : <?php echo get_currency_price($TPL_VAR["items_tot"]["promotion_code_sale"], 3,'','<span class="price-text">_str_price_</span>')?>

<?php }?>
						</div>

						<div>
							?????? :
							<?php echo get_currency_price($TPL_VAR["items_tot"]["member_sale"], 3,'','<span class="price-text">_str_price_</span>')?>

						</div>

						<div>
							????????? :
							<?php echo get_currency_price($TPL_VAR["items_tot"]["mobile_sale"], 3,'','<span class="price-text">_str_price_</span>')?>

						</div>
						<div>
<?php if($TPL_VAR["items_tot"]["referer_sale"]> 0){?>
							<span class= "url-ctrl underline">???????????? :
									<?php echo get_currency_price($TPL_VAR["items_tot"]["referer_sale"], 3,'','<span class="price-text">_str_price_</span>')?>

									<div class="absolute url-helper" style="text-align:left;padding:1px 4px;display: none;"><a target="_blank" href="<?php if($TPL_VAR["orders"]["referer_naver"]){?><?php echo $TPL_VAR["orders"]["referer_naver"]?><?php }else{?><?php echo $TPL_VAR["orders"]["referer"]?><?php }?>"><?php if($TPL_VAR["orders"]["referer_naver"]){?><?php echo $TPL_VAR["orders"]["referer_naver"]?><?php }else{?><?php echo $TPL_VAR["orders"]["referer"]?><?php }?></a></div>
								</span>
<?php }else{?>
							???????????? :
							<?php echo get_currency_price($TPL_VAR["items_tot"]["referer_sale"], 3,'','<span class="price-text">_str_price_</span>')?>

<?php }?>
						</div>
						<div>
<?php if($TPL_VAR["shipping_tot"]["shipping_coupon_sale"]> 0){?>
							<span class='underline open-link'><a href="javascript:open_saleinfo_layer('coupon_shipping','<?php echo $TPL_VAR["orders"]["order_seq"]?>','')">??????????????? :  <?php echo get_currency_price($TPL_VAR["shipping_tot"]["shipping_coupon_sale"], 3,'','<span class="price-text">_str_price_</span>')?></a></span>
<?php }else{?>
							???????????????  : <?php echo get_currency_price($TPL_VAR["shipping_tot"]["shipping_coupon_sale"], 3,'','<span class="price-text">_str_price_</span>')?>

<?php }?>
						</div>
						<div>
<?php if($TPL_VAR["shipping_tot"]["shipping_promotion_code_sale"]> 0){?>
							<span class='underline open-link'><a href="javascript:open_saleinfo_layer('promotion_ordno','<?php echo $TPL_VAR["orders"]["order_seq"]?>','')">??????????????? :  <?php echo get_currency_price($TPL_VAR["shipping_tot"]["shipping_promotion_code_sale"], 3,'','<span class="price-text">_str_price_</span>')?></a></span>
<?php }else{?>
							??????????????? :  <?php echo get_currency_price($TPL_VAR["shipping_tot"]["shipping_promotion_code_sale"], 3,'','<span class="price-text">_str_price_</span>')?>

<?php }?>
						</div>
						<div>
<?php if($TPL_VAR["orders"]["pg"]!='npay'&&$TPL_VAR["orders"]["pg"]!='talkbuy'){?>
							????????? :
<?php if($TPL_VAR["orders"]["step"]=='15'&&$TPL_VAR["items_tot"]["provider_cnt"]== 1){?>
							<form name="frm_enuri" method="post" action="../order_process/enuri?seq=<?php echo $TPL_VAR["orders"]["order_seq"]?>" target="actionFrame">
								<input type="text" name="enuri" value="<?php echo $TPL_VAR["orders"]["enuri"]?>" size="5" class="line onlynumber" /> <span class="btn small cyanblue"><button type="submit" id="enuri">??????</button></span>
							</form>
<?php }else{?>
							<?php echo get_currency_price($TPL_VAR["orders"]["enuri"], 3,'','<span>_str_price_</span>')?>

<?php }?>
<?php }?>
							<div>
<?php if($TPL_VAR["orders"]["pg"]=="npay"){?>
								<div>
									<span style="latter-spacing:-1px;">Npay ??????(???????????????) : </span> <span class="price-text"><?php echo get_currency_price($TPL_VAR["items_tot"]["npay_sale_seller"], 3,'','<span class="price-text">_str_price_</span>')?>

								</div>
								<div>
									<span style="latter-spacing:-1px;">Npay ??????(Npay??????) : </span> <span class="price-text"><?php echo get_currency_price($TPL_VAR["items_tot"]["npay_sale_npay"], 3,'','<span class="price-text">_str_price_</span>')?>

								</div>
<?php }?>
								<div class="wx250">???????????? : <?php echo get_currency_price($TPL_VAR["orders"]["emoney"], 3,'','<span>_str_price_</span>')?></div>
							</div>
				</td>
				<td></td>
				<td>
					<div class="detail-sale-box hide wx250">
						<div class="wx250">????????? : <?php echo get_currency_price($TPL_VAR["orders"]["op_sale_price"], 3,'','<span>_str_price_</span>')?></div>
						<div class="wx250">????????? : <?php echo get_currency_price($TPL_VAR["orders"]["cash"], 3,'','<span>_str_price_</span>')?></div>
<?php if($TPL_VAR["orders"]["pg"]=="npay"&&($TPL_VAR["orders"]["npay_coupon"]> 0||$TPL_VAR["orders"]["npay_point"]> 0)){?>
						<div class="wx250">Npay ??????(???????????????) : <?php echo get_currency_price($TPL_VAR["orders"]["npay_coupon"], 3,'','<span>_str_price_</span>')?></div>
						<div class="wx250">Npay ?????????(???????????????) : <?php echo get_currency_price($TPL_VAR["orders"]["npay_point"], 3,'','<span>_str_price_</span>')?></div>
<?php }?>
						<div class="wx250">?????????(????????????) : <?php echo get_currency_price($TPL_VAR["orders"]["settleprice"]-$TPL_VAR["orders"]["npay_point"], 3,'','<span>_str_price_</span>')?></div>
<?php if($TPL_VAR["orders"]["pg"]!="npay"){?>
						<div class="wx250">?????????(????????????) : <?php echo get_currency_price($TPL_VAR["orders"]["payment_price"], 3,$TPL_VAR["orders"]["pg_currency"],'<span>_str_price_</span>')?></div>
<?php }?>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div align="center" class="mt20">
<?php if($TPL_VAR["salescost"]){?>
		<table class="order-summary-table" style="width:1200px;" align="center">
			<colgroup>
				<col width="150" />
				<col width="75" /><col width="75" />
				<col width="75" /><col width="75" />
				<col width="75" /><col width="75" />
				<col width="75" /><col width="75" />
				<col width="75" /><col width="75" />
				<col width="75" /><col width="75" />
				<col width="75" /><col width="75" />
			</colgroup>
			<thead>
			<tr>
				<th class="dark" rowspan="2">??????</th>
				<th class="dark" colspan="2" style="height:25px;">??????????????? / ??????</th>
				<th class="dark" colspan="2" style="height:25px;">?????????????????? / ??????</th>
				<th class="dark" colspan="2" style="height:25px;">???????????? / ??????</th>
				<th class="dark" colspan="2" style="height:25px;">???????????? / ??????</th>
				<th class="dark" colspan="2" style="height:25px;">?????????????????? / ??????</th>
				<th class="dark" colspan="2" style="height:25px;">????????????????????? / ??????</th>
				<th class="dark" colspan="2" style="height:25px;">????????????????????? / ??????</th>
			</tr>
			<tr>
				<th class="dark" style="height:25px;">??????</th><th class="dark" style="height:25px;">?????????</th>
				<th class="dark" style="height:25px;">??????</th><th class="dark" style="height:25px;">?????????</th>
				<th class="dark" style="height:25px;">??????</th><th class="dark" style="height:25px;">?????????</th>
				<th class="dark" style="height:25px;">??????</th><th class="dark" style="height:25px;">?????????</th>
				<th class="dark" style="height:25px;">??????</th><th class="dark" style="height:25px;">?????????</th>
				<th class="dark" style="height:25px;">??????</th><th class="dark" style="height:25px;">?????????</th>
				<th class="dark" style="height:25px;">??????</th><th class="dark" style="height:25px;">?????????</th>
			</tr>
			</thead>
			<tbody>
<?php if($TPL_salescost_1){foreach($TPL_VAR["salescost"] as $TPL_V1){?>
			<tr height="25">
				<td class="pvtd"><?php echo $TPL_V1["name"]?></td>

				<td class="pvtd"><?php echo get_currency_price($TPL_V1['original']['event']-$TPL_V1['salescost']['event'])?> </td>
				<td class="pvtd"><?php echo get_currency_price($TPL_V1['salescost']['event'])?></td>

				<td class="pvtd"><?php echo get_currency_price($TPL_V1['original']['multi']-$TPL_V1['salescost']['multi'])?> </td>
				<td class="pvtd"><?php echo get_currency_price($TPL_V1['salescost']['multi'])?></td>

				<td class="pvtd"><?php echo get_currency_price($TPL_V1['original']['coupon']-$TPL_V1['salescost']['coupon'])?></td>
				<td class="pvtd"><?php echo get_currency_price($TPL_V1['salescost']['coupon'])?></td>

				<td class="pvtd"><?php echo get_currency_price($TPL_V1['original']['promotion']-$TPL_V1['salescost']['promotion'])?></td>
				<td class="pvtd"><?php echo get_currency_price($TPL_V1['salescost']['promotion'])?></td>

				<td class="pvtd"><?php echo get_currency_price($TPL_V1['original']['referer']-$TPL_V1['salescost']['referer'])?></td>
				<td class="pvtd"><?php echo get_currency_price($TPL_V1['salescost']['referer'])?></td>

				<td class="pvtd"><?php echo get_currency_price($TPL_V1['original']['shippingcoupon']-$TPL_V1['salescost']['shippingcoupon'])?></td>
				<td class="pvtd"><?php echo get_currency_price($TPL_V1['salescost']['shippingcoupon'])?></td>

				<td class="pvtd"><?php echo get_currency_price($TPL_V1['original']['shippingpromotion']-$TPL_V1['salescost']['shippingpromotion'])?></td>
				<td class="pvtd"><?php echo get_currency_price($TPL_V1['salescost']['shippingpromotion'])?></td>
			</tr>
<?php }}?>
			</tbody>
		</table>
<?php }?>
	</div>
<?php }?>
</div>

<div id="coupon_use_lay" class="hide"></div>
<div id="coupon_use_log_dialog" class="hide"></div>

<!-- ????????? ?????? ?????? :: START -->
<div id="address_dialog" class="hide">
	<table class="info-table-style" width="100%" border="0" cellspacing="0" cellpadding="0">
		<colgroup>
			<col width="75px" />
			<col width="" />
		</colgroup>
		<tr>
			<th class="its-th">??????</th>
			<td class="its-td" id="address_category"></td>
		</tr>
		<tr>
			<th class="its-th">??????</th>
			<td class="its-td" id="address_name"></td>
		</tr>
		<tr>
			<th class="its-th">??????</th>
			<td class="its-td" id="view_address"></td>
		</tr>
		<tr>
			<th class="its-th">?????????</th>
			<td class="its-td" id="shipping_phone"></td>
		</tr>
	</table>
	<div class="pd10 center">
		<span class="btn small cyanblue" ><button type="button" style="width:60px;" onclick="closeDialog('address_dialog');">??????</button></span>
	</div>
</div>
<!-- ????????? ?????? ?????? :: END -->
<!-- ????????? ?????? ????????? : ??? -->

<div id="gift_use_lay"></div>
<div id="coupon_status_dialog" class="hide"><?php $this->print_("socialcp_status_guide",$TPL_SCP,1);?></div>

<div id="talkbuy_delivary_dialog" class="hide">
	<div class="center">
		<p>??????????????? ?????? ????????? ?????? ??? ????????? ??????????????? ????????? ??? ????????????.</p>
	</div>
	<div class="pd10 center">
		<span class="btn medium" ><button type="button" onclick="closeDialog('talkbuy_delivary_dialog');">??????</button></span>
	</div>
</div>