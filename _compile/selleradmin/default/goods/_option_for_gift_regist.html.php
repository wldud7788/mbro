<?php /* Template_ 2.2.6 2022/05/17 12:29:17 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_option_for_gift_regist.html 000013762 */ 
$TPL_frequentlyoptlist_1=empty($TPL_VAR["frequentlyoptlist"])||!is_array($TPL_VAR["frequentlyoptlist"])?0:count($TPL_VAR["frequentlyoptlist"]);?>
<script type="text/javascript">
$(document).ready(function(){
	var defaultOption	= $("form div#optionLayer").html();

	/* 필수옵션만들기*/
	$("#optionMake").live("click",function(){
		openSettingOption('');
	});

	/* 옵션 단일 추가*/
	$("div#optionLayer button#addOption").live("click",function(){
		$("div#optionLayer table").append( $("div#optionLayer tr.optionTr").last().clone() );
	});

	$("input[name='supplyPrice[]']").live("blur",function(){calulate_option_price();});
	$("input[name='consumerPrice[]']").live("blur",function(){calulate_option_price();});
	$("input[name='price[]']").live("blur",function(){calulate_option_price();});
	$("input[name='reserveRate[]']").live("blur",function(){calulate_option_price();});
	$("select[naame='reserveUnit[]']").live("change",function(){calulate_option_price();});
	$("input[name='reserve[]']").live("blur",function(){calulate_option_price();});
	$("input[name='tax']").live("click",function(){calulate_option_price();});

	/* 옵션 수정시 가용재고 재계산 */
	$("#optionLayer input[name='stock[]']").live('change',function(){
		var idx = $("#optionLayer input[name='stock[]']").index($(this));
		var stock = num($(this).val());
		var unUsableStock = num($("#optionLayer input[name='unUsableStock[]']").eq(idx).val());
		$("#optionLayer span.optionUsableStock").eq(idx).html(comma(stock-unUsableStock));
	});

	// 필수옵션 모두열기 몇개만보기
	$("div.option_open_all").find("span").bind("click", function(){
		if	($(this).hasClass('openall')){
			viewOptionTmp('limit');
			$(this).removeClass('openall');
			$("div.option_open_all").find("span").text('모두열기▼');
		}else{
			viewOptionTmp('');
			$(this).addClass('openall');
			$("div.option_open_all").find("span").text('<?php echo $TPL_VAR["config_goods"]["option_view_count"]?>개만보기▲');
		}
	});

	calulate_option_price();

<?php if($TPL_VAR["goods"]["goods_seq"]){?>
	set_option_select_layout();
<?php }?>

});


var optionTmpPopup	= '';


// 물류관리 사용여부 체크
function chk_scm_status(){
<?php if(($TPL_VAR["provider_seq"]=='1'||$_GET["provider"]=='base')&&$TPL_VAR["scm_cfg"]['use']=='Y'){?>
	return true;
<?php }else{?>
	return false;
<?php }?>
}
</script>

<style>
	table.reg_package_option_tbl {width:100%;}
	table.reg_package_option_title_tbl {width:100%;}
	table.reg_package_option_title_tbl tr td { text-align:center; }
	table.reg_package_option_title_tbl tr td:last-child { border-right:0px; }
	table.reg_package_option_tbl tr td { border-right:1px solid #dadada; }
	table.reg_package_option_tbl tr td:last-child { border-right:0px; }
	span.wh_option {color:#d13b00;}
</style>

<!-- 필수옵션 : 시작 -->
<input type="hidden" name="optionUse" value="" />
<input type="hidden" name="frequentlyopt" value="<?php echo $TPL_VAR["goods"]["frequentlyopt"]?>" />
<input type="hidden" name="tmp_option_seq" value="" />

<!-- 필수옵션 : 구분 선택 ( 멀티 or 단일 ) -->
<div style="padding:15px 0px 5px 10px;">
	<div>
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td class="pd0" style="width:160px">
				<span class="optionTitleText">[1] 필수옵션</span>
			</td>
			<td valign="bottom">
				<span class="optionuse-lay hide">
					<select name="optionViewType">
						<option value="divide">하고 옵션을 따로따로 보여줍니다 (옵션 분리형)</option>
						<option value="join">하고 옵션을 조합하여 보여줍니다 (옵션 합체형)</option>
					</select>
<?php if(!($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["scmTotalStock"]> 0&&($TPL_VAR["provider_seq"]=='1'||$_GET["provider"]=='base'))){?>
					→<label> <input type="checkbox" name="frequentlytypeoptck" value="1" /> </label>
					<span id="frequentlytypeoptlay" class="gray" disabled="disabled">
						<select name="frequentlytypeopt" class="frequentlytypeopt" >
							<option value="0">자주 쓰는 상품의 필수옵션 </option>
<?php if($TPL_VAR["frequentlyoptlist"]){?>
<?php if($TPL_frequentlyoptlist_1){foreach($TPL_VAR["frequentlyoptlist"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["goods_seq"]?>"><?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 20)?></option>
<?php }}?>
<?php }?>
						</select>을 가져와서
					</span>
<?php }?>
					<span class="btn small"><button type="button" id="optionMake" goods_seq="<?php echo $TPL_VAR["goods_seq"]?>">필수옵션 만들기</button></span>
					<span class="btn small gray"><button type="button" id="optionPreview">필수옵션 미리보기</button></span>
				</span>

			</td>
		</tr>
		</table>
	</div>
</div>

<div id="optionLayer">
	<table class="info-table-style" style="width:100%">
	<!-- 싱글옵션 -->
	<thead>
	<tr>

<?php if($TPL_VAR["isplusfreenot"]){?>
		<th class="its-th-align center" rowspan="2">
			상품코드
			<a href="javascript:helperMessage('goodsCode');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
			<br/><span class="btn small"><button type="button" id="goodsCodeBtn"  title="기본코드자동생성" >기본코드자동생성</button></span>
		</th>
<?php }?>

		<th class="its-th-align center" rowspan="2">무게<br/>(kg)</th>
		<th class="its-th-align center" colspan="<?php if(($TPL_VAR["provider_seq"]=='1'||$_GET["provider"]=='base')){?>5<?php }else{?>4<?php }?>">
<?php if(($TPL_VAR["provider_seq"]=='1'||$_GET["provider"]=='base')){?>
			<span class="storeinfo_title">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
				<?php echo $TPL_VAR["scm_cfg"]['store_name']?> = <?php echo implode(', ',$TPL_VAR["scm_cfg"]['use_warehouse'])?>

				<input type="hidden" name="use_warehouse" value="|<?php echo implode('|',array_keys($TPL_VAR["scm_cfg"]['use_warehouse']))?>|" />
<?php }else{?>
				재고 = 기본창고
<?php }?>
			</span>
			<span class="store_text helpicon" title="해당 상점(매장)에서 판매 재고로 사용하는 창고 기준의 재고입니다."></span>
<?php }else{?>
			<span class="storeinfo_title">재고: <?php echo $TPL_VAR["provider"]["provider_name"]?></span>
<?php }?>
		</th>
		<th class="its-th-align center" rowspan="2">정가 → 판매가 <span class="goods_required"></span> <a href="javascript:helperMessage('price');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a></th>
		<th class="its-th-align center" rowspan="2">부가세</th>
		<th class="its-th-align center optionStockSetText" rowspan="2"></th>
	</tr>
	<tr>

		<th class="its-th-align center">재고 <a href="javascript:helperMessage('stock');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a></th>
		<th class="its-th-align center">불량</th>
		<th class="its-th-align center">가용 <a href="javascript:helperMessage('solubleStock');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a></span></th>
		<th class="its-th-align center">
			안전
<?php if(($TPL_VAR["provider_seq"]=='1'||$_GET["provider"]=='base')&&$TPL_VAR["scm_cfg"]['use']){?>
				<a href="javascript:helperMessage('safeStockForScm', '<?php echo $TPL_VAR["scm_cfg"]['store_name']?>');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
				<input type="hidden" class="safestock_text" title="<?php echo $TPL_VAR["scm_cfg"]['store_name']?>"/>
<?php }else{?>
				<a href="javascript:helperMessage('safeStock', '<?php if(($TPL_VAR["provider_seq"]=='1'||$_GET["provider"]=='base')){?>기본매장<?php }else{?>입점사<?php }?>');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
				<input type="hidden" class="safestock_text" title="<?php if(($TPL_VAR["provider_seq"]=='1'||$_GET["provider"]=='base')){?>기본매장<?php }else{?>입점사<?php }?>"/>
<?php }?>

		</th>
<?php if(($TPL_VAR["provider_seq"]=='1'||$_GET["provider"]=='base')){?>
		<th class="its-th-align center">매입가(평균)</th>
<?php }?>
	</tr>
	</thead>
	<tbody>
	<tr class="optionTr">
<?php if($TPL_VAR["isplusfreenot"]){?>
		<td class="its-td-align center">
			<input type="hidden" name="optionSeq[]" value="<?php echo $TPL_VAR["options"][ 0]["option_seq"]?>" />
			<input type="text"  name="goodsCode"  id="goodsCode" value="<?php echo $TPL_VAR["goods"]["goods_code"]?>" />
			<!--select name="option_international_shipping_status_view" onchange="set_option_international_shipping_status(this);">
				<option value="n">N</option>
				<option value="y" <?php if($TPL_VAR["goods"]["option_international_shipping_status"]=='y'){?>selected<?php }?>>Y</option>
			</select-->
		</td>
<?php }?>

		<td class="its-td-align center">
			<input style="text-align: right;" class="line onlyfloat input-box-default-text" name="weight[]" value="<?php if($TPL_VAR["options"][ 0]["weight"]){?><?php echo $TPL_VAR["options"][ 0]["weight"]?><?php }else{?>0<?php }?>" size="3" type="text">
		</td>

<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&($TPL_VAR["provider_seq"]=='1'||$_GET["provider"]=='base')&&$TPL_VAR["goods"]["goods_seq"]> 0&&$TPL_VAR["options"][ 0]["option_seq"]){?>
		<td class="its-td-align right pdr10 hand" onclick="goods_option_btn('<?php echo $TPL_VAR["goods"]["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_VAR["goods"]["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
			<span class="option-stock" optType="option" optSeq="<?php echo $TPL_VAR["options"][ 0]["option_seq"]?>"><?php echo number_format($TPL_VAR["options"][ 0]["stock"])?></span>
			<input type="hidden" name="stock[]" value="<?php echo $TPL_VAR["options"][ 0]["stock"]?>" />
		</td>
<?php }elseif($TPL_VAR["scm_cfg"]['use']=='Y'&&($TPL_VAR["provider_seq"]=='1'||$_GET["provider"]=='base')){?>
		<td class="its-td-align right pdr10">
			<?php echo number_format($TPL_VAR["options"][ 0]["stock"])?>

			<input type="hidden" name="stock[]" value="<?php echo $TPL_VAR["options"][ 0]["stock"]?>" />
		</td>
<?php }else{?>
		<td class="its-td-align right pdr10">
			<input type="text" name="stock[]" value="<?php echo $TPL_VAR["options"][ 0]["stock"]?>" size="5" class="line onlynumber" style="text-align:right" />
		</td>
<?php }?>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&($TPL_VAR["provider_seq"]=='1'||$_GET["provider"]=='base')){?>
		<td class="its-td-align right pdr10">
			<?php echo number_format($TPL_VAR["options"][ 0]["badstock"])?>

			<input type="hidden" name="badstock[]" value="<?php echo $TPL_VAR["options"][ 0]["badstock"]?>"/>
		</td>
<?php }else{?>
		<td class="its-td-align right pdr10">
			<input type="text" name="badstock[]" value="<?php echo $TPL_VAR["options"][ 0]["badstock"]?>" size="5" class="line onlynumber" style="text-align:right" />
		</td>
<?php }?>
		<td class="its-td-align right pdr10">
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 15){?>
			<span class="optionUsableStock"><?php echo number_format($TPL_VAR["options"][ 0]["stock"]-$TPL_VAR["options"][ 0]["badstock"]-$TPL_VAR["options"][ 0]["reservation15"])?></span>
			<input type="hidden" name="unUsableStock[]" value="<?php echo ($TPL_VAR["options"][ 0]["badstock"]+$TPL_VAR["options"][ 0]["reservation15"])?>" />
<?php }?>
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 25){?>
			<span class="optionUsableStock"><?php echo number_format($TPL_VAR["options"][ 0]["stock"]-$TPL_VAR["options"][ 0]["badstock"]-$TPL_VAR["options"][ 0]["reservation25"])?></span>
			<input type="hidden" name="unUsableStock[]" value="<?php echo ($TPL_VAR["options"][ 0]["badstock"]+$TPL_VAR["options"][ 0]["reservation25"])?>" />
<?php }?>
			<input type="hidden" name="reservation15[]" value="" />
			<input type="hidden" name="reservation25[]" value="" />
		</td>
		<td class="its-td-align right pdr10">
			<input type="text" name="safe_stock[]" value="<?php echo $TPL_VAR["options"][ 0]["safe_stock"]?>" size="5" class="line onlynumber" style="text-align:right" />
		</td>
<?php if(($TPL_VAR["provider_seq"]=='1'||$_GET["provider"]=='base')){?>
		<td class="its-td-align right pdr10">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
			<?php echo number_format($TPL_VAR["options"][ 0]["supply_price"], 2)?>

			<input type="hidden" name="supplyPrice[]" value="<?php echo $TPL_VAR["options"][ 0]["supply_price"]?>" />
<?php }else{?>
			<input type="text" name="supplyPrice[]" value="<?php echo $TPL_VAR["options"][ 0]["supply_price"]?>" size="10" class="onlyfloat line" style="text-align:right" />
<?php }?>
		</td>
<?php }?>
		<td class="its-td-align center pdr10 pricetd">
			<input type="hidden" name="reserveRate[]" class="line onlyfloat" style="text-align:right" size="3" value="<?php echo $TPL_VAR["options"][ 0]["reserve_rate"]?>" />
			<input type="hidden" name="reserve[]" class="line onlyfloat" value="<?php echo $TPL_VAR["options"][ 0]["reserve"]?>" style="text-align:right" size="5" readonly />
			<input type="text" name="consumerPrice[]" value="<?php echo $TPL_VAR["options"][ 0]["consumer_price"]?>" size="12" class="onlyfloat line" style="text-align:right;color:#000;" />
			→
			<input type="text" name="price[]" value="<?php echo $TPL_VAR["options"][ 0]["price"]?>" size="12" class="onlyfloat line readonly-color" style="text-align:right;" readonly />
		</td>
		<td class="its-td-align right pdr10 tax" style="padding-right:10px"></td>
		<td class="its-td-align center"><input type="hidden" name="option_view[]" value="Y" />노출</td>
	</tr>
	</tbody>
	</table>
</div>