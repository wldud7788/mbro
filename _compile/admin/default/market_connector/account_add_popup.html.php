<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/market_connector/account_add_popup.html 000002281 */ 
$TPL_supportMarketList_1=empty($TPL_VAR["supportMarketList"])||!is_array($TPL_VAR["supportMarketList"])?0:count($TPL_VAR["supportMarketList"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/market_connector.css" />
<script type="text/javascript" src="/app/javascript/js/admin-connectorCommon.js?dummy=<?php echo date('YmdHis')?>"></script>
<script>
	$('document').ready(function(){
		$(".marketList").on("change", function(){
			var val = $(this).val();		
			if(val=="") return;				
			window.location.href = './account_add_popup?market=' + $(this).val();			
		})
	});
</script>
<style type="text/css">
	.market_setting {padding:2px 15px;}
	.market_setting .account li .dt, .dt-auth { width:120px !important;}
</style>

<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable" role="dialog" aria-labelledby="ui-dialog-title-couponDownloadDialog" style=" position:relative; width:99.8%; height:auto;">
	
	<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
		<span class="ui-dialog-title" id="ui-dialog-title-couponDownloadDialog">마켓 등록</span>
		<a class="ui-dialog-titlebar-close ui-corner-all" role="button" href="#" onClick="self.close()"><span class="ui-icon ui-icon-closethick">close</span></a>
	</div>

	<div class="contents_container">
		<div class="item-title">계정 설정</div>		
		<table class="table_basic thl">		
			<tr>
				<th>판매 마켓</th>
				<td>
					<select class="marketList popup">
<?php if($TPL_supportMarketList_1){foreach($TPL_VAR["supportMarketList"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_VAR["market"]==$TPL_K1){?>
						<option value="<?php echo $TPL_K1?>"  selected="selected"><?php echo $TPL_V1["name"]?></option>
<?php }else{?>
						<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["name"]?></option>
<?php }?>
<?php }}?>
					</select>
				</td>
			</tr>								
		</table>		
<?php $this->print_("ACCOUNT_FORM",$TPL_SCP,1);?>

	</div>

</div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>