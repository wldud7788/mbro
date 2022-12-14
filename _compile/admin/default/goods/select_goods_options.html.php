<?php /* Template_ 2.2.6 2021/08/25 16:14:45 /www/music_brother_firstmall_kr/admin/skin/default/goods/select_goods_options.html 000007998 */ ?>
<script type="text/javascript" src="/app/javascript/plugin/jquery.search.keyword.dropdown.js"></script>
<style>
	#goodsSelectorSearch {
		width:900px;
		border:0px solid red;
		text-align:center;margin:auto;
	}
	.selectedGoods{ background-color:#e7f2fc; }
	.targetGoods {padding:4px; overflow:hidden; cursor:pointer}
	.targetGoods .image {padding-right:4px;}
	.targetGoods .name {display:block; width:300px; overflow:hidden; white-space:nowrap;}
	.rborder { border-right:1px solid #ddd;}
	table#option_select_form_table {
		table-layout: fixed;
	}
	table#option_select_form_table tr th.th-option, td.td-option {
		border-left: 1px solid #dadada;
		border-bottom: 1px solid #dadada;
	}
	table#option_select_form_table tr:first-child th.th-option {
		border-top: 1px solid #dadada;
	}
	table#option_select_form_table tr th {
		background-color:#f1f1f1;font-weight:bold; height:40px;
		text-align:left;
		padding-left:5px;
	}
	table#option_select_form_table tr td {
		height:69px;
	}
	table#package_select_form_table1 {
		table-layout: fixed;
	}
	table#package_select_form_table1 tr th.th-package1 {
		border-top: 1px solid #dadada;
		border-left: 1px solid #dadada;
		background-color:#f1f1f1;
		height:40px;
		text-align:left;
		padding-left:5px;
	}
	table#package_select_form_table1 tr th.th-package1:last-child {
		border-right: 1px solid #dadada;
	}
	table#package_select_form_table1 tr td.td-package1 {
		border-top: 1px solid #dadada;
		border-left: 1px solid #dadada;
		border-bottom: 1px solid #dadada;
	}
	table#package_select_form_table1 tr td.td-package1:last-child {
		border-right: 1px solid #dadada;
	}
	table#package_select_form_table2 {
		table-layout: fixed;
	}
	table.package_select_form_table2 tr td {
		border-bottom: 1px solid #dadada;
		height:67px;
		text-align:left;
		padding-left:3px;
	}
	table.package_select_form_table2 tr:last-child td {
		border-bottom: 0px;
		height:67px;
	}
	table.package_select_form_table2 tr td:first-child {
		width :20px;
		border-right: 1px solid #dadada;
		text-align:center;
	}

	span.package_goods_name {
		width:<?php echo ( 465/count($TPL_VAR["title_loop"]))?>px;
		text-overflow: ellipsis;
		-o-text-overflow: ellipsis;
		overflow: hidden;
		white-space: nowrap;
		word-wrap: normal !important;
		display:inline-block;
		vertical-align:middle;
	}
	div.package_option_name {
		width:<?php echo ( 500/count($TPL_VAR["title_loop"]))?>px;
		text-overflow: ellipsis;
		-o-text-overflow: ellipsis;
		overflow: hidden;
		white-space: nowrap;
		word-wrap: normal !important;
		display: block;
	}
	span.option-title {
		width:130px;
		text-overflow: ellipsis;
		-o-text-overflow: ellipsis;
		overflow: hidden;
		white-space: nowrap;
		word-wrap: normal !important;
		display: block;
	}
	span.option-value {
		width:130px;
		text-overflow: ellipsis;
		-o-text-overflow: ellipsis;
		overflow: hidden;
		white-space: nowrap;
		word-wrap: normal !important;
		display: block;
	}
	div#step2-title-bar.flyingMode {
		position:fixed; z-index:1000; bottom:0px; left:0px; width:100%; height:56px; background:url('/admin/skin/default/images/common/tit_bg_rollover.png') repeat-x;
	}
</style>
<script>
$(function(){
	/* ?????? ???????????? ??????????????? */
	var packageDashObj = $("#step2-title-bar");
	if(packageDashObj[0]){
		var defaultDashBoardTop = parseInt(packageDashObj.offset().top);
		$("div#selectGoodsOptionsDialog").bind('scroll resize',function(){
			var scrollTop = parseInt($("div#selectGoodsOptionsDialog").scrollTop());
			if( scrollTop > defaultDashBoardTop )
			{
				packageDashObj.addClass('flyingMode');
			}
			else
			{
				packageDashObj.removeClass('flyingMode');
			}
		});
	}
});
</script>
<input type="hidden" name="selected_option_seq" value="" />
<input type="hidden" name="selected_goods_seq" value="" />
<input type="hidden" name="selected_goods_name" value="" />
<input type="hidden" name="selected_options" value="" />
<input type="hidden" name="selected_stock" value="" />
<input type="hidden" name="selected_rstock" value="" />
<input type="hidden" name="selected_badstock" value="" />
<input type="hidden" name="selected_safe_stock" value="" />
<input type="hidden" name="selected_optioncode" value="" />
<input type="hidden" name="selected_weight" value="" />
<input type="hidden" name="selected_tmp_seq" value="<?php echo $TPL_VAR["loop"][ 0]["tmp_no"]?>" />


<h3 class="left">STEP1. ??????????????? ?????? ?????????.</h3>
<div id="goodsSelectorSearch">
	<form name="goodsForm" action="../goods/select_goods_options_list?" method="get" target="select_<?php echo $_GET["displayId"]?>">
		<!-- ?????? ????????? : ?????? -->
<?php $this->print_("goods_search_form",$TPL_SCP,1);?>

		<!-- ?????? ????????? : ??? -->
	</form>
	<div style="height:5px;"></div>
</div>
<table class="goods-select-layout-table" cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td width="49%" valign="top" height="500">
			<iframe width="100%" height="500" frameborder="0" src="../goods/select_goods_options_list?onlyType=<?php echo $_GET["onlyType"]?>&adminshipping=<?php echo $_GET["adminshipping"]?>&adminOrder=<?php echo $_GET["adminOrder"]?>&init=Y&goods_review=<?php echo $_GET["goods_review"]?>&order_seq=<?php echo $_GET["order_seq"]?>&goods_seq=<?php echo $_GET['goods_seq']?>&selectKeyword=<?php echo urlencode($_GET["selectKeyword"])?>&member_seq=<?php echo $_GET["member_seq"]?>&cart_table=<?php echo $_GET["cart_table"]?>&provider_seq=<?php echo $_GET["provider_seq"]?>&package=<?php echo $_GET["package"]?>&<?php echo time()?>" name="select_<?php echo $_GET["displayId"]?>" scrolling="no"></iframe>
		</td>
		<td width="2%" valign="top"></td>
		<td width="49%" valign="top">
			<div id="selectGoodsOptionsView" style="overflow:auto; height:420px;">
				<table class="info-table-style" cellspacing="0">
				<colgroup>
					<col />
					<col width="90" />
				</colgroup>
				<thead class="lth">
					<tr>
						<th class="its-th-align center">??????</th>
						<th class="its-th-align center">?????? ??? ?????????</th>
					</tr>
				</thead>
				<tbody class="ltb">
					<tr class="list-row" style="height:35px;">
						<td class="its-td-align left pdl5" colspan="2">
							?????? ????????? ???????????????.
						</td>
					</tr>
				</tbody>
				</table>
			</div>
		</td>
	</tr>
</table>


<h3 class="left">STEP2. ??????????????? ??????????????? ?????? ?????????.</h3>
<div class="pdt5"></div>
<div id="step2-title-bar">
	<div class="pd10" style="background-color:#F1F1F1;width:98%;text-align:center;border:1px solid #dadada;">
		<table width="100%" border=0>
			<tr>
				<td align="left" width="50%">
<?php if($_GET["opt_type"]=='opt'){?>
					<span class="btn large red"><button type="button" name="apply_package_option" onclick="goods_package_apply();" style="width:400px;">??? ????????? ??????????????? ?????????????????? ????????????</button></span>
<?php }else{?>
					<span class="btn large red"><button name="apply_package_suboption" type="button" onclick="goods_package_suboption_apply();" style="width:400px;">??? ????????? ??????????????? ?????????????????? ????????????</button></span>
<?php }?>
				</td>
				<td align="right">
					<span class="btn large cyanblue"><button name="apply_package_option" style="width:400px;" onclick="apply_package_option();">??? ????????? ????????? ??????????????? ????????? ??????????????? ????????????</button></span>
				</td>
		</table>
	</div>
</div>

<div class="pd5"></div>
<?php if($_GET["opt_type"]=='opt'){?>
<?php $this->print_("select_option_package",$TPL_SCP,1);?>

<?php }else{?>
<?php $this->print_("select_suboption_package",$TPL_SCP,1);?>

<?php }?>

<div style="height:60px;"></div>