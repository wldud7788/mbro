<?php /* Template_ 2.2.6 2022/05/17 12:29:12 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/select_goods_options.html 000008243 */ ?>
<script type="text/javascript" src="/app/javascript/plugin/custom-select-box.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.search.keyword.dropdown.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-layout.js?dummy=<?php echo date('YmdHis')?>&krdomain=http://<?php echo $TPL_VAR["config_system"]["subDomain"]?>"></script>
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
		position:fixed; z-index:1000;  min-width:600px; top:632px; left:134px; width:959px; height:56px; background:url('/admin/skin/default/images/common/tit_bg_rollover.png') repeat-x;
	}
</style>
<script>
$(function(){
	/* 상단 대쉬보드 스크롤처리 */
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
<input type="hidden" name="selected_tmp_seq" value="<?php echo $TPL_VAR["loop"][ 0]["tmp_no"]?>" />
<input type="hidden" name="selected_optioncode" value="" />
<input type="hidden" name="selected_weight" value="" />


<h3 class="left">STEP1. 실제상품을 검색 하세요.</h3>
<div id="goodsSelectorSearch">
	<form name="goodsForm" action="../goods/select_goods_options_list?" method="get" target="select_<?php echo $_GET["displayId"]?>">
		<!-- 상품 검색폼 : 시작 -->
<?php $this->print_("goods_search_form",$TPL_SCP,1);?>

		<!-- 상품 검색폼 : 끝 -->
	</form>
	<div style="height:5px;"></div>
</div>
<table class="goods-select-layout-table" cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td width="49%" valign="top" height="430">
			<iframe width="100%" height="430" frameborder="0" src="../goods/select_goods_options_list?onlyType=<?php echo $_GET["onlyType"]?>&adminshipping=<?php echo $_GET["adminshipping"]?>&adminOrder=<?php echo $_GET["adminOrder"]?>&init=Y&goods_review=<?php echo $_GET["goods_review"]?>&order_seq=<?php echo $_GET["order_seq"]?>&goods_seq=<?php echo $_GET['goods_seq']?>&selectKeyword=<?php echo urlencode($_GET["selectKeyword"])?>&member_seq=<?php echo $_GET["member_seq"]?>&cart_table=<?php echo $_GET["cart_table"]?>&provider_seq=<?php echo $_GET["provider_seq"]?>" name="select_<?php echo $_GET["displayId"]?>" scrolling="no"></iframe>
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
						<th class="its-th-align center">옵션</th>
						<th class="its-th-align center">정가 → 판매가</th>
					</tr>
				</thead>
				<tbody class="ltb">
					<tr class="list-row" style="height:35px;">
						<td class="its-td-align left pdl5" colspan="2">
							왼쪽 상품을 선택하세요.
						</td>
					</tr>
				</tbody>
				</table>
			</div>
		</td>
	</tr>
</table>


<h3 class="left">STEP2. 실제상품을 판매상품에 연결 하세요.</h3>
<div class="pdt5"></div>
<div id="step2-title-bar">
	<div class="pd10" style="background-color:#F1F1F1;width:98%;text-align:center;border:1px solid #dadada;">
		<table width="100%" border=0>
			<tr>
				<td align="left" width="50%">
<?php if($_GET["opt_type"]=='opt'){?>
					<span class="btn large red"><button type="button" name="apply_package_option" onclick="goods_package_apply();" style="width:400px;">② 연결된 실제상품을 옵션등록창에 적용하기</button></span>
<?php }else{?>
					<span class="btn large red"><button name="apply_package_suboption" type="button" onclick="goods_package_suboption_apply();" style="width:400px;">② 연결된 실제상품을 옵션등록창에 적용하기</button></span>
<?php }?>
				</td>
				<td align="right">
					<span class="btn large cyanblue"><button name="apply_package_option" style="width:400px;" onclick="apply_package_option();">① 위에서 선택한 실제상품을 아래의 판매상품에 연결하기</button></span>
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