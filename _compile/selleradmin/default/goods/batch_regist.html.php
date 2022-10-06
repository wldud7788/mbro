<?php /* Template_ 2.2.6 2022/05/17 12:29:08 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/batch_regist.html 000039595 */ 
$TPL_provider_list_1=empty($TPL_VAR["provider_list"])||!is_array($TPL_VAR["provider_list"])?0:count($TPL_VAR["provider_list"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<style style="text/css">
.ui-combobox {position: relative;display: inline-block;}
.ui-combobox-toggle {position: absolute;top: 0;bottom: 0;margin-left: -1px;padding: 0;*height: 1.7em;*top: 0.1em;}
.ui-combobox-input {margin: 0;padding: 0.3em;}
.ui-autocomplete {max-height: 200px;overflow-y: auto;overflow-x: hidden;}
.btnhelp {display:inline-block; width:14px; height:14px; cursor:pointer; background:url('/admin/skin/default/images/common/bg_icon.png'); vertical-align:middle;margin-bottom:2px}
</style>
<script type="text/javascript" src="/app/javascript/plugin/jquery.fmdomsaver.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/js/scm.common.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-goodsQuickRegist.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	quick_regist_js_init(
		'<?php echo $TPL_VAR["loadStatus"]?>', 
		'<?php echo $TPL_VAR["cfg_order"]["runout"]?>', 
		'<?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]?>', 
		'<?php echo $TPL_VAR["scm_cfg"]["use"]?>', 
		'<?php echo $TPL_VAR["scm_cfg"]["set_default_date"]?>', 
		<?php echo json_encode($TPL_VAR["whData"]['warehouse'])?>, 
		<?php echo json_encode($TPL_VAR["whData"]['location'])?>

	);
});
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>[실물] 일반상품 빠른등록</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left"></ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large"><button type="button" onclick="saveGoodsData();">빠른 등록</button></span></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<br style="line-height:30px;" />

<form name="batchRegistFrm" method="post" action="../goods_process/save_tmp_goods_row" target="actionFrame">
<input type="hidden" name="tmp_seq" value="<?php echo $TPL_VAR["tmpData"]["tmp_seq"]?>" />
<input type="hidden" name="act_type" value="add" />
<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $TPL_VAR["tmpData"]["provider_seq"]?>" />
<input type="hidden" class="commission_type" name="commission_type" value="<?php echo $TPL_VAR["current_provider"]['commission_type']?>" />
<?php if($TPL_VAR["tmpData"]["provider_seq"]> 1||$TPL_VAR["scm_cfg"]["use"]!='Y'||!$TPL_VAR["scm_cfg"]["set_default_date"]&&!$TPL_VAR["sellermode"]){?>
<input type="hidden" name="stock_type" value="" />
<?php }else{?>
<input type="hidden" name="stock_type" value="scm" />
<?php }?>
<table class="info-table-style" width="100%">
<colgroup>
	<col width="10%" />
	<col width="19%" />
	<col width="12%" />
	<col width="30%" />
	<col width="10%" />
	<col />
</colgroup>
<tbody>
<?php if(serviceLimit('H_AD')&&!$TPL_VAR["sellermode"]){?>
<tr>
	<th class="its-th-align center">승인 여부</th>
	<td class="its-td-align left pdl5">
		<label><input type="radio" name="provider_status" value="1" <?php if($TPL_VAR["tmpData"]["provider_status"]){?>checked<?php }?> onclick="domSaverSendData(this);" /> 승인</label>
		<label><input type="radio" name="provider_status" value="0" <?php if(!$TPL_VAR["tmpData"]["provider_status"]){?>checked<?php }?> onclick="domSaverSendData(this);" /> 미승인</label>
	</td>
	<th class="its-th-align center">판매자</th>
	<td class="its-td-align left pdl5">
		<div class="ui-widget">
			<select name="provider_seq_selector" style="vertical-align:middle;">
			<option value="1" <?php if($TPL_VAR["tmpData"]["provider_seq"]== 1){?>selected<?php }?>>본사</option>
<?php if($TPL_provider_list_1){foreach($TPL_VAR["provider_list"] as $TPL_V1){?>
			<option value="<?php echo $TPL_V1["provider_seq"]?>" commissionType="<?php echo $TPL_V1["commission_type"]?>" providerStatus="<?php echo $TPL_V1["provider_status"]?>" <?php if($TPL_VAR["tmpData"]["provider_seq"]==$TPL_V1["provider_seq"]){?>selected<?php }?>><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }}?>
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" name="provider_name" value="<?php echo $TPL_VAR["current_provider"]['provider_name']?>" readonly />
		</div>
	</td>
	<th class="its-th-align center"></th>
	<td class="its-td-align left pdl5"></td>
</tr>
<?php }?>
<tr>
	<th class="its-th-align center">과세 여부</th>
	<td class="its-td-align left pdl5">
		<label><input type="radio" name="tax" value="tax" <?php if($TPL_VAR["tmpData"]["tax"]!='exempt'){?>checked<?php }?> onclick="domSaverSendData(this);" /> 과세</label>
		<label><input type="radio" name="tax" value="exempt" <?php if($TPL_VAR["tmpData"]["tax"]=='exempt'){?>checked<?php }?> onclick="domSaverSendData(this);" /> 비과세</label>
	</td>
	<th class="its-th-align center">
		재고에 따른 판매
		<span class="btn small whiteblue"><button type="button" <?php if(serviceLimit('H_FR')){?>class="nofreelinknone"<?php }else{?>onclick="open_runout_setting_popup();"<?php }?>>설정</button></span>
	</th>
	<td class="its-td-align left pdl5">
		<span class="runout-msg-lay"></span>
		<input type="hidden" name="runout_policy" value="<?php echo $TPL_VAR["tmpData"]["runout_policy"]?>" />
		<input type="hidden" name="able_stock_limit" value="<?php echo $TPL_VAR["tmpData"]["able_stock_limit"]?>" />
	</td>
	<th class="its-th-align center">
		배송정책
		<span class="btn small whiteblue"><button type="button" onclick="open_shipping_setting_popup('set_provider_shipping_setting', 'selected_provider_shipping_group');">선택</button></span>
	</th>
	<td class="its-td-align left pdl5">
		<font class="shipping-group-name"><?php echo $TPL_VAR["shippingData"]["shipping_group_name"]?></font>
		(<span class="shipping-group-seq"><?php echo $TPL_VAR["shippingData"]["shipping_group_seq"]?></span>)
		<span class="shipping-default-yn <?php if($TPL_VAR["shippingData"]["default_yn"]!='Y'){?>hide<?php }?> basic_black_box">기본</span>
		<input type="hidden" name="shipping_group_seq" value="<?php echo $TPL_VAR["shippingData"]["shipping_group_seq"]?>" />
	</td>
</tr>
<tr>
	<th class="its-th-align center">노출 여부</th>
	<td class="its-td-align left pdl5">
		<label><input type="radio" name="goods_view" value="look" <?php if($TPL_VAR["tmpData"]["goods_view"]=='look'){?>checked<?php }?> onclick="domSaverSendData(this);" /> 노출</label>
		<label><input type="radio" name="goods_view" value="notLook" <?php if($TPL_VAR["tmpData"]["goods_view"]!='look'){?>checked<?php }?> onclick="domSaverSendData(this);" /> 미노출</label>
	</td>
	<th class="its-th-align center">
		상태
		<span class="btnhelp" onclick="helpOpenDialog('goods_satatus');"></span>
	</th>
	<td class="its-td-align left pdl5">
		↑상기 ‘재고에 따른 판매’에 따라 자동 등록
	</td>
	<th class="its-th-align center"></th>
	<td class="its-td-align left pdl5"></td>
</tr>
<?php if($TPL_VAR["scm_cfg"]["use"]=='Y'&&!$TPL_VAR["sellermode"]){?>
<tr class="scm-box <?php if($TPL_VAR["tmpData"]["provider_seq"]> 1){?>hide<?php }?>">
	<th class="its-th-align center">
		기초재고 기초일자
		<span class="btnhelp"onclick="helpOpenDialog('default_revision_date');"></span>
	</th>
	<td class="its-td-align left pdl5">
<?php if($TPL_VAR["scm_cfg"]["set_default_date"]){?>
		<?php echo $TPL_VAR["scm_cfg"]["set_default_date"]?>

<?php }else{?>
		재고기초 > <span class="click-lay" onclick="window.open('../scm_basic/config');">절사/환율, 기초일자</span>에서 설정
<?php }?>
	</td>
	<th class="its-th-align center">재고관리 분류</th>
	<td class="its-td-align left pdl5">
<?php if(is_array($TPL_R1=range( 1, 4))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<select name="scm_catagory[]" class="simple scm-category" depth="<?php echo $TPL_V1?>" onchange="getChildScmCategory(this, 'scm-category');scmCategorySendData(this);">
			<option value=""><?php echo $TPL_V1?>차 분류</option>
<?php if(is_array($TPL_R2=$TPL_VAR["categoryinfo"][$TPL_V1])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<option value="<?php echo $TPL_V2["category_code"]?>" <?php if($TPL_VAR["scmCategory"][$TPL_V1]==$TPL_V2["category_code"]){?>selected<?php }?>><?php echo $TPL_V2["title"]?></option>
<?php }}?>
		</select>
<?php }}?>
	</td>
	<th class="its-th-align center"></th>
	<td class="its-td-align left pdl5"></td>
</tr>
<?php }?>
</tbody>
</table>

<br style="line-height:20px;" />

<div class="clearbox">
	<ul class="left-btns clearbox">
		<li>
			<span class="btn small black"><button type="button" onclick="save_tmp_goods_row('remove');">삭제</button></span>
			<span class="btn small black"><button type="button" onclick="save_tmp_goods_row('copy');">복사</button></span>
			<span class="btn small black"><button type="button" onclick="save_tmp_goods_row('add');">추가</button></span>
		</li>
	</ul>
</div>
<table class="info-table-style quick-goods-regist-table" width="100%">
<thead>
<tr>
	<th class="its-th-align center" rowspan="2" width="30"><input type="checkbox" class="allChk" /></th>
	<th class="its-th-align center" rowspan="2" width="170">상품명</th>
	<th class="its-th-align center" rowspan="2">옵션</th>
	<th class="its-th-align center" rowspan="2" width="80">
		무게(kg)<br/>
		<div class="all-batch-lay">
			<input type="text" size="2" class="all-batch-weight" />
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'all');">▼</button></span>
		</div>
	</th>
<?php if($TPL_VAR["tmpData"]["provider_seq"]== 1&&$TPL_VAR["scm_cfg"]["use"]=='Y'&&$TPL_VAR["scm_cfg"]["set_default_date"]){?>
	<th class="its-th-align center option-box-title-lay" colspan="4">기초재고 <span class="btnhelp"onclick="helpOpenDialog('default_revision');"></span></th>
<?php }elseif($TPL_VAR["tmpData"]["provider_seq"]== 1){?>
	<th class="its-th-align center option-box-title-lay" colspan="3">기초재고 <span class="btnhelp"onclick="helpOpenDialog('default_revision');"></span></th>
<?php }else{?>
	<th class="its-th-align center option-box-title-lay" colspan="2">기초재고 <span class="btnhelp"onclick="helpOpenDialog('default_revision');"></span></th>
<?php }?>
	<th class="its-th-align center" width="70" rowspan="2">
		안전<br/>
		<div class="all-batch-lay" style="display:inline-block;">
			<input type="text" size="2" class="all-batch-safe_stock" />
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'all');">▼</button></span>
		</div>
	</th>
<?php if(serviceLimit('H_AD')){?>
	<th class="its-th-align center seller-box <?php if($TPL_VAR["tmpData"]["provider_seq"]== 1){?>hide<?php }?>" width="60" rowspan="2">정산금액</th>
	<th class="its-th-align center seller-box <?php if($TPL_VAR["tmpData"]["provider_seq"]== 1){?>hide<?php }?>" width="80" rowspan="2">
		수수료
<?php if(!$TPL_VAR["sellermode"]){?>
		<br/>
		<div class="all-batch-lay" style="display:inline-block;">
			<input type="text" size="2" class="all-batch-commission_rate" />
			<span class="commission-type-unit">
<?php if($TPL_VAR["current_provider"]['commission_type']=='SUPR'){?>원<?php }else{?>%<?php }?>
			</span>
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'all');">▼</button></span>
		</div>
<?php }?>
	</th>
<?php }?>
	<th class="its-th-align center" rowspan="2" width="170">
		정가→판매가(KRW)<br/>
		<div class="all-batch-lay" style="display:inline-block;">
			<input type="text" size="5" class="all-batch-consumer_price" />
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'all');">▼</button></span>
		</div>
		<div class="all-batch-lay" style="display:inline-block;">
			<input type="text" size="5" class="all-batch-price" />
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'all');">▼</button></span>
		</div>
	</th>
	<th class="its-th-align center" rowspan="2" width="80">
		옵션노출<br/>
		<div class="all-batch-lay" style="display:inline-block;">
			<select class="simple all-batch-option_view">
				<option value="N">N</option>
				<option value="Y">Y</option>
			</select>
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'all');">▼</button></span>
		</div>
	</th>
</tr>
<tr>
<?php if($TPL_VAR["scm_cfg"]["use"]=='Y'&&$TPL_VAR["scm_cfg"]["set_default_date"]&&!$TPL_VAR["sellermode"]){?>
	<th class="its-th-align left pdl5 option-box-subtitle-lay scm-box <?php if($TPL_VAR["tmpData"]["provider_seq"]> 1){?>hide<?php }?>" width="300">
		<center>창고 및 로케이션</center>
		<div class="all-batch-lay" style="display:inline-block;">
			<select class="simple all-batch-warehouse warehouse" onchange="select_warehouse(this, 'nosave');">
<?php if(is_array($TPL_R1=$TPL_VAR["whData"]['warehouse'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["wh_seq"]?>"><?php echo $TPL_V1["wh_name"]?></option>
<?php }}?>
			</select>
			<select class="simple all-batch-location_w location_w">
<?php if(is_array($TPL_R1=$TPL_VAR["whData"]['location'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
				<option value="<?php echo $TPL_K1?>"><?php echo $TPL_K1?></option>
<?php }}?>
			</select>
			<select class="simple all-batch-location_l location_l">
<?php if(is_array($TPL_R1=$TPL_VAR["whData"]['location'][ 1])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
				<option value="<?php echo $TPL_K1?>"><?php echo $TPL_K1?></option>
<?php }}?>
			</select>
			<select class="simple all-batch-location_h location_h">
<?php if(is_array($TPL_R1=$TPL_VAR["whData"]['location'][ 1][ 1])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
				<option value="<?php echo $TPL_K1?>"><?php echo $TPL_K1?></option>
<?php }}?>
			</select>
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'all');">▼</button></span>
		</div>
	</th>
<?php }?>
	<th class="its-th-align center option-box-subtitle-lay" width="70">
		재고<br/>
		<div class="all-batch-lay" style="display:inline-block;">
			<input type="text" size="2" class="all-batch-stock" <?php if(!$TPL_VAR["scm_cfg"]["set_default_date"]){?>disabled<?php }?> />
<?php if($TPL_VAR["scm_cfg"]["set_default_date"]){?>
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'all');">▼</button></span>
<?php }?>
		</div>
	</th>
	<th class="its-th-align center option-box-subtitle-lay" width="70">
		불량<br/>
		<div class="all-batch-lay" style="display:inline-block;">
			<input type="text" size="2" class="all-batch-badstock" <?php if(!$TPL_VAR["scm_cfg"]["set_default_date"]){?>disabled<?php }?> />
<?php if($TPL_VAR["scm_cfg"]["set_default_date"]){?>
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'all');">▼</button></span>
<?php }?>
		</div>
	</th>
	<th class="its-th-align center option-box-subtitle-lay admin-box <?php if($TPL_VAR["tmpData"]["provider_seq"]> 1){?>hide<?php }?>" width="80">
		매입가(KRW)<br/>
		<div class="all-batch-lay" style="display:inline-block;">
			<input type="text" size="2" class="all-batch-supply_price" <?php if(!$TPL_VAR["scm_cfg"]["set_default_date"]){?>disabled<?php }?> />
<?php if($TPL_VAR["scm_cfg"]["set_default_date"]){?>
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'all');">▼</button></span>
<?php }?>
		</div>
	</th>
</tr>
</thead>
<tbody class="quick-goods-regist-tbody">
<?php if(is_array($TPL_R1=$TPL_VAR["tmpData"]["goods"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["options"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<tr class="option-row-<?php echo $TPL_V1["goods_seq"]?> option-rows" goodsSeq="<?php echo $TPL_V1["goods_seq"]?>">
<?php if($TPL_I2== 0){?>
	<td class="its-td-align center goods-seq-td" rowspan="<?php echo count($TPL_V1["options"])?>">
		<input type="checkbox" name="goods_seq[]" class="chk" value="<?php echo $TPL_V1["goods_seq"]?>" />
	</td>
	<td class="its-td-align left pdl5 goods-name-td" style="vertical-align:top;" rowspan="<?php echo count($TPL_V1["options"])?>">
		<div class="right" style="width:98%;">
			<input type="text" name="goods_name[<?php echo $TPL_V1["goods_seq"]?>]" class="goods_name" style="width:50%;" value="<?php echo $TPL_V1["goods_name"]?>" title="상품명" onblur="domSaverSendData(this);" />
			<input type="text" name="goods_code[<?php echo $TPL_V1["goods_seq"]?>]" class="goods_code" style="width:30%;" value="<?php echo $TPL_V1["goods_code"]?>" title="기본코드" onblur="domSaverSendData(this);" />
			<div style="margin-top:5px;">
				<input type="hidden" name="option_use[<?php echo $TPL_V1["goods_seq"]?>]" class="option_use" value="<?php echo $TPL_V1["option_use"]?>" />
<?php if($TPL_V1["option_use"]=='Y'){?>
				<span class="btn small whiteblue"><button type="button" onclick="open_options_create_popup('create_option_popup', '<?php echo $TPL_V1["goods_seq"]?>', 'create_option_batch_regist', '<?php echo $TPL_VAR["tmpData"]["tmp_seq"]?>');">옵션 : 있음</button></span>
<?php }else{?>
				<span class="btn small whiteblue"><button type="button" onclick="open_options_create_popup('create_option_popup', '<?php echo $TPL_V1["goods_seq"]?>', 'create_option_batch_regist', '<?php echo $TPL_VAR["tmpData"]["tmp_seq"]?>');">옵션 : 없음</button></span>
<?php }?>
			</div>
		</div>
	</td>
<?php }?>
	<td class="its-td-align center">
		<table width="90%" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
<?php if(is_array($TPL_R3=$TPL_V2["opt_values"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
		<tr>
			<td width="55" height="20"><?php echo $TPL_V3?></td>
			<td width="12" style="text-align:center;">
<?php if($TPL_V2["newtype"][$TPL_K3]=='color'){?>
				<div style="background-color:<?php echo $TPL_V2["color"]?>;border:1px solid #c5c5c5;width:10px;height:10px;"></div>
<?php }?>
			</td>
			<td class="left pdl5" height="20"><?php echo $TPL_V2["opt_codes"][$TPL_K3]?></td>
		</tr>
<?php }}?>
		</table>
		<input type="hidden" name="option_seq[<?php echo $TPL_V1["goods_seq"]?>][]" class="option_seq" value="<?php echo $TPL_V2["option_seq"]?>" />
	</td>
	<td class="its-td-align left pdl5" style="vertical-align:top;">
		<input type="text" name="weight[<?php echo $TPL_V2["option_seq"]?>]" class="weight" style="width:40%;" value="<?php echo $TPL_V2["weight"]?>" onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
	</td>
<?php if($TPL_VAR["scm_cfg"]["use"]=='Y'&&$TPL_VAR["scm_cfg"]["set_default_date"]&&!$TPL_VAR["sellermode"]){?>
	<td class="its-td-align left pdl5 bg-pastelred scm-box <?php if($TPL_VAR["tmpData"]["provider_seq"]> 1){?>hide<?php }?>" style="vertical-align:top;">
<?php if(is_array($TPL_R3=$TPL_V2["revision"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
		<div class="warehouse-lay-<?php echo $TPL_V2["option_seq"]?> revision-row-<?php echo $TPL_V3["revision_seq"]?>" rseq="<?php echo $TPL_V3["revision_seq"]?>" style="height:25px;">
			<input type="hidden" name="revision_seq[<?php echo $TPL_V2["option_seq"]?>][]" class="revision_seq" value="<?php echo $TPL_V3["revision_seq"]?>" />
			<select name="warehouse[<?php echo $TPL_V2["option_seq"]?>][]" class="simple warehouse" onchange="select_warehouse(this, '');" whSeq="<?php echo $TPL_V3["wh_seq"]?>">
				<option value="">창고 선택</option>
<?php if(is_array($TPL_R4=$TPL_VAR["whData"]['warehouse'])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
				<option value="<?php echo $TPL_V4["wh_seq"]?>" <?php if($TPL_V4["wh_seq"]==$TPL_V3["wh_seq"]){?>selected<?php }?>><?php echo $TPL_V4["wh_name"]?></option>
<?php }}?>
			</select>
			<select name="location_w[<?php echo $TPL_V2["option_seq"]?>][]" class="simple location_w" onchange="scmLocationSendData(this);" <?php if(!$TPL_V3["wh_seq"]){?>disabled style="background-color:#efefef;"<?php }?>>
<?php if(is_array($TPL_R4=$TPL_V3["location"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?>
				<option value="<?php echo $TPL_K4?>" <?php if($TPL_V3["position_arr"][ 0]==$TPL_K4){?>selected<?php }?>><?php echo $TPL_K4?></option>
<?php }}?>
			</select>
			<select name="location_l[<?php echo $TPL_V2["option_seq"]?>][]" class="simple location_l" onchange="scmLocationSendData(this);" <?php if(!$TPL_V3["wh_seq"]){?>disabled style="background-color:#efefef;"<?php }?>>
<?php if(is_array($TPL_R4=$TPL_V3["location"][$TPL_V3["position_arr"][ 0]])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?>
				<option value="<?php echo $TPL_K4?>" <?php if($TPL_V3["position_arr"][ 1]==$TPL_K4){?>selected<?php }?>><?php echo $TPL_K4?></option>
<?php }}?>
			</select>
			<select name="location_h[<?php echo $TPL_V2["option_seq"]?>][]" class="simple location_h" onchange="scmLocationSendData(this);" <?php if(!$TPL_V3["wh_seq"]){?>disabled style="background-color:#efefef;"<?php }?>>
<?php if(is_array($TPL_R4=$TPL_V3["location"][$TPL_V3["position_arr"][ 0]][$TPL_V3["position_arr"][ 1]])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?>
				<option value="<?php echo $TPL_K4?>" <?php if($TPL_V3["position_arr"][ 2]==$TPL_K4){?>selected<?php }?>><?php echo $TPL_K4?></option>
<?php }}?>
			</select>
<?php if($TPL_I3== 0){?>
			<span class="btn small"><button type="button" onclick="add_tmp_revision_data(this);">┿</button></span>
<?php }else{?>
			<span class="btn small"><button type="button" onclick="remove_tmp_revision_data(this);">━</button></span>
<?php }?>
		</div>
<?php }}?>
	</td>
<?php }?>
	<td class="its-td-align left pdl5 bg-pastelred" style="vertical-align:top;">
<?php if($TPL_VAR["tmpData"]["provider_seq"]== 1&&$TPL_VAR["scm_cfg"]["use"]=='Y'&&!$TPL_VAR["sellermode"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["revision"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
		<div class="stock-lay-<?php echo $TPL_V2["option_seq"]?> revision-row-<?php echo $TPL_V3["revision_seq"]?>" rseq="<?php echo $TPL_V3["revision_seq"]?>" style="height:25px;">
			<input type="text" size="3" name="stock[<?php echo $TPL_V2["option_seq"]?>][]" class="stock" style="width:40%;" value="<?php echo $TPL_V3["stock"]?>" <?php if(!$TPL_V3["wh_seq"]||!$TPL_VAR["scm_cfg"]["set_default_date"]){?>disabled<?php }?> onblur="domSaverSendData(this);"/>
<?php if($TPL_I2== 0&&$TPL_I3== 0&&$TPL_V1["option_use"]=='Y'){?>
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
		</div>
<?php }}?>
<?php }else{?>
		<input type="text" size="3" name="stock[<?php echo $TPL_V2["option_seq"]?>][]" class="stock" style="width:40%;" value="<?php echo $TPL_V2["stock"]?>" onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
<?php }?>
	</td>
	<td class="its-td-align left pdl5 bg-pastelred" style="vertical-align:top;">
<?php if($TPL_VAR["tmpData"]["provider_seq"]== 1&&$TPL_VAR["scm_cfg"]["use"]=='Y'&&!$TPL_VAR["sellermode"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["revision"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
		<div class="badstock-lay-<?php echo $TPL_V2["option_seq"]?> revision-row-<?php echo $TPL_V3["revision_seq"]?>" rseq="<?php echo $TPL_V3["revision_seq"]?>" style="height:25px;">
			<input type="text" size="3" name="badstock[<?php echo $TPL_V2["option_seq"]?>][]" class="badstock" style="width:40%;" value="<?php echo $TPL_V3["badstock"]?>" <?php if(!$TPL_V3["wh_seq"]||!$TPL_VAR["scm_cfg"]["set_default_date"]){?>disabled<?php }?> onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_I3== 0&&$TPL_V1["option_use"]=='Y'){?>
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
		</div>
<?php }}?>
<?php }else{?>
		<input type="text" size="3" name="badstock[<?php echo $TPL_V2["option_seq"]?>][]" class="badstock" style="width:40%;" value="<?php echo $TPL_V2["badstock"]?>" onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
<?php }?>
	</td>
	<td class="its-td-align left pdl5 bg-pastelred admin-box <?php if($TPL_VAR["tmpData"]["provider_seq"]> 1){?>hide<?php }?>" style="vertical-align:top;">
<?php if($TPL_VAR["tmpData"]["provider_seq"]== 1&&$TPL_VAR["scm_cfg"]["use"]=='Y'&&!$TPL_VAR["sellermode"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["revision"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
		<div class="supplyprice-lay-<?php echo $TPL_V2["option_seq"]?> revision-row-<?php echo $TPL_V3["revision_seq"]?>" rseq="<?php echo $TPL_V3["revision_seq"]?>" style="height:25px;">
			<input type="text" size="3" name="supply_price[<?php echo $TPL_V2["option_seq"]?>][]" class="supply_price" style="width:40%;" value="<?php echo $TPL_V3["supply_price"]?>" <?php if(!$TPL_V3["wh_seq"]||!$TPL_VAR["scm_cfg"]["set_default_date"]){?>disabled<?php }?> onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_I3== 0&&$TPL_V1["option_use"]=='Y'){?>
			<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
		</div>
<?php }}?>
<?php }else{?>
		<input type="text" size="3" name="supply_price[<?php echo $TPL_V2["option_seq"]?>][]" class="supply_price" style="width:40%;" value="<?php echo $TPL_V2["supply_price"]?>" onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
<?php }?>
	</td>
	<td class="its-td-align left pdl5" style="vertical-align:top;">
		<input type="text" size="3" name="safe_stock[<?php echo $TPL_V2["option_seq"]?>]" class="safe_stock" style="width:40%;" value="<?php echo $TPL_V2["safe_stock"]?>" onblur="domSaverSendData(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
	</td>
<?php if(serviceLimit('H_AD')){?>
	<td class="its-td-align right pdr5 seller-box <?php if($TPL_VAR["tmpData"]["provider_seq"]== 1){?>hide<?php }?>" style="vertical-align:top;">
		<span class="commission_price_lay"><?php echo number_format($TPL_V2["commission_price"], 2)?></span>
	</td>
	<td class="its-td-align left pdl5 seller-box <?php if($TPL_VAR["tmpData"]["provider_seq"]== 1){?>hide<?php }?>" style="vertical-align:top;">
<?php if($TPL_VAR["sellermode"]){?>
			<?php echo $TPL_V2["commission_rate"]?>

<?php if($TPL_VAR["current_provider"]['commission_type']=='SUPR'){?>원<?php }else{?>%<?php }?>
<?php }else{?>
		<input type="text" size="3" name="commission_rate[<?php echo $TPL_V2["option_seq"]?>]" class="commission_rate" style="width:40%;" value="<?php echo $TPL_V2["commission_rate"]?>" onblur="calculate_commission(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
<?php }?>
	</td>
<?php }?>
	<td class="its-td-align left pdl5 bg-lightyellow" style="vertical-align:top;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td>
				<input type="text" size="10" name="consumer_price[<?php echo $TPL_V2["option_seq"]?>]" class="consumer_price" style="width:50%;" value="<?php echo $TPL_V2["consumer_price"]?>" onblur="calculate_commission(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
				<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
			</td>
			<td>
				<input type="text" size="10" name="price[<?php echo $TPL_V2["option_seq"]?>]" class="price" style="width:50%;"  value="<?php echo $TPL_V2["price"]?>" onblur="calculate_commission(this);" />
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
				<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
			</td>
		</tr>
		</table>
	</td>
	<td class="its-td-align left pdl5" style="vertical-align:top;">
		<select name="option_view[<?php echo $TPL_V2["option_seq"]?>]" class="simple option_view"  onchange="domSaverSendData(this);">
			<option value="N" <?php if($TPL_V2["option_view"]=='N'){?>selected<?php }?>>N</option>
			<option value="Y" <?php if($TPL_V2["option_view"]=='Y'){?>selected<?php }?>>Y</option>
		</select>
<?php if($TPL_I2== 0&&$TPL_V1["option_use"]=='Y'){?>
		<span class="btn small gray"><button type="button" onclick="allBatchSave(this, 'goods');">▼</button></span>
<?php }?>
	</td>
</tr>
<?php }}?>
<?php }}?>
</tbody>
</table>
</form>












<div id="popup_shipping_setting" class="hide">
	<table class="info-table-style" width="100%">
	<thead>
	<tr>
		<th class="its-th-align center">배송그룹명 (배송그룹번호)</th>
		<th class="its-th-align center">배송비계산기준</th>
	</tr>
	</thead>
	<tbody>
	<tr class="default-row hide">
		<td class="its-td-align left pdl5">
			<label><input type="radio" name="sel_shipping_group" value="[:SHIPPING_GROUP_SEQ:]" />
			<span class="sel_shipping_group_name">[:SHIPPING_GROUP_NAME:]</span>
			([:SHIPPING_GROUP_SEQ:])
			<span class="sel_shipping_default_yn basic_black_box [:SHIPPING_DEFAULT_CLASS:]">[:SHIPPING_DEFAULT_YN:]</span>
			</label>
		</td>
		<td class="its-td-align left pdl5">[:SHIPPING_CALCULATE_TYPE:]</td>
	</tr>
	</tbody>
	</table>
	<div style="width:100%;text-align:center;margin-top:20px;">
		<span class="btn large cyanblue"><button type="button" class="shipping-apply-button">적용</button></span>
	</div>
</div>
<div id="popup_runout_setting" class="hide">
	<div style="padding-bottom:5px;">
		<label style="width:80px;display:inline-block;"><input type="radio" name="runout_type" value="shop" <?php if(!$TPL_VAR["tmpData"]["runout_policy"]){?>checked<?php }?> onclick="chk_runout_policy('<?php echo $TPL_VAR["cfg_order"]["runout"]?>', '<?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]?>');" /> 통합세팅</label>
		(설정><a href="../setting/order" target="_blank"><span class=" highlight-link hand">주문</span></a>)
	</div>
	<table width="100%" class="info-table-style stock-qa-table" id="shop_runout">
	<col width="180" /><col width="300" /><col width="230" /><col width="280" /><col />
	<tr>
		<td class="its-td center">판매 방식</td>
		<td class="its-td center">상황의 발생</td>
		<td class="its-td center">재고(가용재고)의 변화</td>
		<td class="its-td center">상품의 상태 처리	</td>
		<td class="its-td center">결과</td>
	</tr>
<?php if($TPL_VAR["cfg_order"]["runout"]=='stock'){?>
	<tr>
		<td class="its-td" rowspan="2">재고가 있으면 판매</td>
		<td class="its-td">[좋은일] 상품을 발송(출고완료)하여</td>
		<td class="its-td">재고가 0 이 될 때</td>
		<td class="its-td">품절(또는 재고확보중)로 자동 업데이트되어</td>
		<td class="its-td">판매 중지</td>
	</tr>
	<tr>
		<td class="its-td">[나쁜일] 결제취소/반품/주문처리되돌리기로</td>
		<td class="its-td">재고가 1 이상이 될 때</td>
		<td class="its-td">정상으로 자동 업데이트되어</td>
		<td class="its-td">판매 가능</td>
	</tr>
<?php }?>
<?php if($TPL_VAR["cfg_order"]["runout"]=='ableStock'){?>
	<tr>
		<td class="its-td" rowspan="2">가용재고가 있으면 판매</td>
		<td class="its-td">[좋은일] 상품의 주문으로</td>
		<td class="its-td">가용재고가 <?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]?> 이하로 될 때</td>
		<td class="its-td">품절(또는 재고확보중)로 자동 업데이트되어</td>
		<td class="its-td">판매 중지</td>
	</tr>
	<tr>
		<td class="its-td">[나쁜일] 결제취소/반품/주문처리되돌리기로</td>
		<td class="its-td">가용재고가 <?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]+ 1?> 이상이 될 </td>
		<td class="its-td">정상으로 자동 업데이트되어</td>
		<td class="its-td">판매 가능</td>
	</tr>
<?php }?>
<?php if($TPL_VAR["cfg_order"]["runout"]=='unlimited'){?>
	<tr>
		<td class="its-td" rowspan="2">재고와 상관없이 판매</td>
		<td class="its-td">[좋은일] 상품을 발송(출고완료)하여</td>
		<td class="its-td">재고가 차감되어도</td>
		<td class="its-td">정상으로 유지되어</td>
		<td class="its-td">판매 중지되지 않고 판매 가능</td>
	</tr>
	<tr>
		<td class="its-td">[나쁜일] 결제취소/반품/주문처리되돌리기로</td>
		<td class="its-td">재고와 가용재고가 증가되면 </td>
		<td class="its-td">당연히 정상으로 유지되어</td>
		<td class="its-td">판매 가능</td>
	</tr>
<?php }?>
	</table>
	<br/><br/>
	<div style="padding-bottom:5px;">
		<label><input type="radio" name="runout_type" value="goods" <?php if($TPL_VAR["tmpData"]["runout_policy"]){?>checked<?php }?>  onclick="chk_runout_policy('<?php echo $TPL_VAR["cfg_order"]["runout"]?>', '<?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]?>');" /> 개별세팅</label>
	</div>
	<table width="100%" class="info-table-style stock-qa-table" id="goods_runout">
	<col width="180" /><col width="300" /><col width="230" /><col width="280" /><col />
	<tr>
		<td class="its-td center">판매 방식</td>
		<td class="its-td center">상황의 발생</td>
		<td class="its-td center">재고(가용재고)의 변화</td>
		<td class="its-td center">상품의 상태 처리	</td>
		<td class="its-td center">결과</td>
	</tr>
	<tr>
		<td class="its-td" rowspan="2"><label><input type="radio" name="runout" value="stock" <?php if($TPL_VAR["tmpData"]["runout_policy"]=='stock'){?>checked<?php }?> onclick="chk_runout_policy('<?php echo $TPL_VAR["cfg_order"]["runout"]?>', '<?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]?>');" /> 재고가 있으면 판매</label></td>
		<td class="its-td">[좋은일] 상품을 발송(출고완료)하여</td>
		<td class="its-td">재고가  <strong>0</strong> 이 될 때</td>
		<td class="its-td">품절(또는 재고확보중)로 자동 업데이트되어</td>
		<td class="its-td">판매 중지</td>
	</tr>
	<tr>
		<td class="its-td">[나쁜일] 결제취소/반품/주문처리되돌리기로</td>
		<td class="its-td">재고가 <strong>1</strong> 이상이 될 때</td>
		<td class="its-td">정상으로 자동 업데이트되어</td>
		<td class="its-td">판매 가능</td>
	</tr>
	<tr>
		<td class="its-td" rowspan="2"><label><input type="radio" name="runout" value="ableStock" <?php if($TPL_VAR["tmpData"]["runout_policy"]=='ableStock'){?>checked<?php }?> onclick="chk_runout_policy('<?php echo $TPL_VAR["cfg_order"]["runout"]?>', '<?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]?>');" /> 가용재고가 있으면 판매</label></td>
		<td class="its-td">[좋은일] 상품의 주문으로</td>
		<td class="its-td">가용재고가  <input type="text" name="ableStockLimit" size="5" value="<?php echo $TPL_VAR["tmpData"]["able_stock_limit"]?>" class="right line onlynumber_signed"  onblur="chk_runout_policy('<?php echo $TPL_VAR["cfg_order"]["runout"]?>', '<?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]?>');"/> 이하로 될 때</td>
		<td class="its-td">품절(또는 재고확보중)로 자동 업데이트되어</td>
		<td class="its-td">판매 중지</td>
	</tr>
	<tr>
		<td class="its-td">[나쁜일] 결제취소/반품/주문처리되돌리기로</td>
		<td class="its-td">가용재고가     <span id="ableStockLimitMsg" style="font-weight:bold"></span> 이상이 될 때</td>
		<td class="its-td">정상으로 자동 업데이트되어</td>
		<td class="its-td">판매 가능</td>
	</tr>
	<tr>
		<td class="its-td" rowspan="2"><label><input type="radio" name="runout" value="unlimited" <?php if($TPL_VAR["tmpData"]["runout_policy"]=='unlimited'||!$TPL_VAR["tmpData"]["runout_policy"]){?>checked<?php }?> onclick="chk_runout_policy('<?php echo $TPL_VAR["cfg_order"]["runout"]?>', '<?php echo $TPL_VAR["cfg_order"]["ableStockLimit"]?>');" /> 재고와 상관없이 판매</label></td>
		<td class="its-td">[좋은일] 상품을 발송(출고완료)하여</td>
		<td class="its-td">재고가 차감되어도</td>
		<td class="its-td">정상으로 유지되어</td>
		<td class="its-td">판매 중지되지 않고 판매 가능</td>
	</tr>
	<tr>
		<td class="its-td">[나쁜일] 결제취소/반품/주문처리되돌리기로</td>
		<td class="its-td">재고와 가용재고가 증가되면</td>
		<td class="its-td">당연히 정상으로 유지되어</td>
		<td class="its-td">판매 가능</td>
	</tr>
	</table>
</div>
<div id="help_goods_satatus" class="hide">
	<table class="info-table-style" width="100%">
	<colgroup>
		<col width="40%" />
		<col />
		<col />
	</colgroup>
	<thead>
	<tr>
		<th class="its-th-align left pdl5"></th>
		<th class="its-th-align left pdl5">재고 있음</th>
		<th class="its-th-align left pdl5">재고 없음</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<th class="its-th-align left pdl5">재고 상관없이 판매함</th>
		<td class="its-td-align left pdl5">정상</td>
		<td class="its-td-align left pdl5">정상</td>
	</tr>
	<tr>
		<th class="its-th-align left pdl5">재고 1개 이상 있을때 판매함</th>
		<td class="its-td-align left pdl5">정상</td>
		<td class="its-td-align left pdl5">판매중지</td>
	</tr>
	<tr>
		<th class="its-th-align left pdl5">가용재고 ○○개 이상 있을때 판매함</th>
		<td class="its-td-align left pdl5">정상(재고 >= 가용재고)</td>
		<td class="its-td-align left pdl5">판매중지(재고 < 가용재고)</td>
	</tr>
	</tbody>
	</table>
</div>
<div id="help_default_revision_date" class="hide">
	기초재고가 있을 경우 입력된 기초재고 기초일자의 기말재고로 등록됩니다.
</div>
<div id="help_default_revision" class="hide">
	기초재고는 시스템 도입 전 보유하고 있는 재고가 있을 경우에만 등록하십시오. <br/>
	기초재고를 등록함으로써 보유하고 있는 실제 재고와 전산상의 재고가 동일하게 됩니다.
</div>
<div id="create_option_popup" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>