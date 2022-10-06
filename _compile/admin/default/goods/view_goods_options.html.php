<?php /* Template_ 2.2.6 2022/05/17 12:31:55 /www/music_brother_firstmall_kr/admin/skin/default/goods/view_goods_options.html 000025127 */ 
$TPL_options_1=empty($TPL_VAR["options"])||!is_array($TPL_VAR["options"])?0:count($TPL_VAR["options"]);?>
<div id="optionLayer">

	<table class="info-table-style" style="width:100%">
		<input type="hidden" name="optionAddPopup" value="y" />
		<input type="hidden" name="reserve_policy" value="<?php echo $TPL_VAR["options"][ 0]["tmp_policy"]?>" />
		<input type="hidden" name="goodsCode" id="goodsCode" value="<?php echo $TPL_VAR["goods"]["goods_code"]?>" />
		<thead>
		<tr>
			<th class="its-th-align center" rowspan="2">기준</th>
<?php if($TPL_VAR["package_yn"]!='y'){?>
				<th class="its-th-align center" rowspan="2">상품코드</th>
<?php if(is_array($TPL_R1=$TPL_VAR["options"][ 0]["option_divide_title"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
				<th class="its-th-align center" rowspan="2">
					<?php echo $TPL_V1?>

					<input type="hidden" name="optionTitle[]" value="<?php echo $TPL_V1?>" />
					<input type="hidden" name="optionType[]" value="<?php echo $TPL_VAR["options"][ 0]["option_divide_type"][$TPL_I1]?>" />
				</th>
<?php }}?>
<?php if(!$_GET["socialcp_input_type"]){?><th class="its-th-align center" rowspan="2">무게<br/>(kg)</th><?php }?>
<?php }else{?>
				<th class="its-th-align center" <?php if(count($TPL_VAR["options"][ 0]["option_divide_title"])> 0){?>colspan="<?php echo count($TPL_VAR["options"][ 0]["option_divide_title"])?>"<?php }else{?>rowspan="2"<?php }?>>필수옵션</th>
<?php }?>
<?php if($_GET["socialcp_input_type"]){?>
			<th class="its-th-align center couponinputtitle" rowspan="2">쿠폰1장→값어치<br/><span class="couponinputsubtitle"><?php if($_GET["socialcp_input_type"]=='price'){?>금액<?php }else{?>횟수<?php }?></span></th>
<?php }?>

<?php if($TPL_VAR["package_yn"]=='y'){?>
			<th class="its-th-align center">
				실제 상품
			</th>
<?php }else{?>
			<th class="its-th-align center" colspan="<?php if($TPL_VAR["goods"]["provider_seq"]== 1){?>5<?php }else{?>4<?php }?>">
<?php if($TPL_VAR["goods"]["provider_seq"]== 1){?>
				<span class="storeinfo_title">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
					<?php echo $TPL_VAR["scm_cfg"]['admin_env_name']?> = <?php echo implode(', ',$TPL_VAR["scm_cfg"]['use_warehouse'])?>

					<input type="hidden" name="use_warehouse" value="|<?php echo implode('|',array_keys($TPL_VAR["scm_cfg"]['use_warehouse']))?>|" />
<?php }else{?>
					기본매장 = 기본창고
<?php }?>
				</span>
				<span class="helpicon" title="해당 상점(매장)에서 판매 재고로 사용하는 창고 기준의 재고입니다."></span>
<?php }else{?>
				<span class="storeinfo_title">재고: <?php echo $TPL_VAR["provider_info"]["provider_name"]?></span>
<?php }?>
			</th>
<?php }?>
			<th class="its-th-align center <?php if($_GET["provider_seq"]== 1){?>hide<?php }?>" rowspan="2">정산 금액<br />KRW, 원</th>
			<th class="its-th-align center <?php if($_GET["provider_seq"]== 1){?>hide<?php }?>" rowspan="2">
<?php if($TPL_VAR["provider_info"]["commission_type"]=='SACO'||$TPL_VAR["provider_info"]["commission_type"]==''){?>
				수수료
				<a href="javascript:helperMessage('SACO');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
<?php }else{?>
				<span class="SUCO_title">
					공급가
					<a href="javascript:helperMessage('SUPPLY');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
				</span>
<?php }?>
			</th>
			<th class="its-th-align center" rowspan="2">
				정가 → 판매가
				<span class="goods_required"></span>
				<span class="price_text helpicon" title="정가는 소비자가격이며,<br/>판매가는 할인가격입니다."></span>
			</th>
			<th class="its-th-align center" rowspan="2">부가세</th>
			<th class="its-th-align center" rowspan="2">
				<div>
<?php if($TPL_VAR["options"][ 0]["tmp_policy"]=='goods'||$TPL_VAR["tmp_policy"]=='goods'){?>
				개별정책
<?php }else{?>
				통합정책
<?php }?>
				</div>
				지급 캐시
			</th>
			<th class="its-th-align center optionStockSetText" rowspan="2"></th>
			<th class="its-th-align center" rowspan="2">설명 <span class="optionmemo_text helpicon" title="해당 옵션에 대한 안내 문구입니다.<br/>옵션설명이 있는 경우 구매자가<br/>해당 옵션을 선택하면 옵션설명이 보여지게 됩니다."></span></th>
		</tr>
		<tr>
<?php if($TPL_VAR["package_yn"]=='y'){?>
			
<?php if(is_array($TPL_R1=$TPL_VAR["options"][ 0]["option_divide_title"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><th class="its-th-align center" rowspan="2"><?php echo $TPL_V1?></th><?php }}?>

			<th class="its-th-align center package-product-width">
				<table class="reg_package_option_title_tbl">
					<tr>
<?php if(is_array($TPL_R1=range( 1,$TPL_VAR["package_count"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<td>상품<?php echo $TPL_V1?></td>
<?php }}?>
					</tr>
				</table>
			</th>
<?php }else{?>
			<th class="its-th-align center">재고 <a href="javascript:helperMessage('stock');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a></th>
			<th class="its-th-align center">불량</th>
			<th class="its-th-align center">가용 <a href="javascript:helperMessage('solubleStock');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a></th>
			<th class="its-th-align center">
				안전재고
<?php if(($TPL_VAR["goods"]["provider_seq"]=='1'||$_GET["provider"]=='base')&&$TPL_VAR["scm_cfg"]['use']){?>
					<a href="javascript:helperMessage('safeStockForScm', '<?php echo $TPL_VAR["scm_cfg"]['admin_env_name']?>');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
					<input type="hidden" class="safestock_text" title="<?php echo $TPL_VAR["scm_cfg"]['admin_env_name']?>"/>
<?php }else{?>
					<a href="javascript:helperMessage('safeStock', '<?php if(($TPL_VAR["goods"]["provider_seq"]=='1'||$_GET["provider"]=='base')){?>기본매장<?php }else{?>입점사<?php }?>');"><img src="/admin/skin/default/images/common/btn_help.gif"/></a>
					<input type="hidden" class="safestock_text" title="<?php if(($TPL_VAR["goods"]["provider_seq"]=='1'||$_GET["provider"]=='base')){?>기본매장<?php }else{?>입점사<?php }?>"/>
<?php }?>
			</th>
<?php if($TPL_VAR["goods"]["provider_seq"]== 1){?>
			<th class="its-th-align center">매입가(평균)</th>
<?php }?>
<?php }?>
		</tr>
		</thead>
<?php if($TPL_VAR["options"]){?>
		<tbody>
<?php if($TPL_options_1){$TPL_I1=-1;foreach($TPL_VAR["options"] as $TPL_V1){$TPL_I1++;?>
<?php if(!$TPL_VAR["config_goods"]["option_view_count"]||$TPL_VAR["config_goods"]["option_view_count"]>$TPL_I1||$TPL_VAR["islimit"]!='limit'){?>
		<tr class="optionTr">
			<td class="its-td-align center">
<?php if($TPL_V1["default_option"]=='y'){?>●<?php }?>
				<input type="hidden" name="optionSeq[]" value="<?php echo $TPL_V1["option_seq"]?>" />
			</td>

<?php if($TPL_VAR["package_yn"]!='y'){?><td class="its-td-align center"><span class="goodsCode"></span><?php echo $TPL_V1["optioncode"]?></td><?php }?>

<?php if(is_array($TPL_R2=$TPL_V1["opts"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_K2=>$TPL_V2){$TPL_I2++;?>
			<td class="its-td-align center optionTitle" >
				<?php echo $TPL_V2?>

<?php if($TPL_V1["optcodes"][$TPL_I2]&&$TPL_VAR["package_yn"]!='y'){?><br/><span class="desc">[<?php echo $TPL_V1["optcodes"][$TPL_I2]?>]</span><?php }?>
				<input type="hidden" name="optionNames[]" value="<?php echo $TPL_V2?>" />
<?php if($TPL_V1["divide_newtype"][$TPL_K2]){?>
				<input type="hidden"  name="optnewtype[]" value="<?php echo $TPL_V1["divide_newtype"][$TPL_K2]?>">
				<br/>
<?php if($TPL_V1["divide_newtype"][$TPL_K2]=='color'){?>
					<input type="hidden"  name="optcolor[]" value="<?php echo $TPL_V1["color"]?>">
					<div class="colorPickerBtn helpicon1" opttype="<?php echo $TPL_V1["option_divide_type"][$TPL_K2]?>" style="background-color:<?php echo $TPL_V1["color"]?>" ></div>
<?php }elseif($TPL_V1["divide_newtype"][$TPL_K2]=='address'){?>
					<span class="addrhelpicon helpicon" opttype="<?php echo $TPL_V1["option_divide_type"][$TPL_K2]?>" title="<?php if($TPL_V1["zipcode"]){?>[<?php echo $TPL_V1["zipcode"]?>]  <br> (지번) <?php echo $TPL_V1["address"]?> <?php echo $TPL_V1["addressdetail"]?><br>(도로명) <?php echo $TPL_V1["address_street"]?> <?php echo $TPL_V1["addressdetail"]?> <?php }?> <?php if($TPL_V1["biztel"]){?>업체 연락처:<?php echo $TPL_V1["biztel"]?><?php }?><br/>수수료 : <?php echo $TPL_V1["address_commission"]?> %">지역</span>
<?php }elseif($TPL_V1["divide_newtype"][$TPL_K2]=='date'){?>
					<input type="hidden"  name="codedate[]" value="<?php echo $TPL_V1["codedate"]?>">
					<span class="codedatehelpicon helpicon" opttype="<?php echo $TPL_V1["option_divide_type"][$TPL_K2]?>" title="<?php if($TPL_V1["codedate"]&&$TPL_V1["codedate"]!='0000-00-00'){?><?php echo $TPL_V1["codedate"]?><?php }?>">날짜</span>
<?php }elseif($TPL_V1["divide_newtype"][$TPL_K2]=='dayinput'){?>
					<input type="hidden"  name="sdayinput[]" value="<?php echo $TPL_V1["sdayinput"]?>">
					<input type="hidden"  name="fdayinput[]" value="<?php echo $TPL_V1["fdayinput"]?>">
					<span class="dayinputhelpicon helpicon" opttype="<?php echo $TPL_V1["option_divide_type"][$TPL_K2]?>" title="<?php if($TPL_V1["sdayinput"]&&$TPL_V1["fdayinput"]){?><?php echo $TPL_V1["sdayinput"]?> ~ <?php echo $TPL_V1["fdayinput"]?><?php }?>">수동기간</span>
<?php }elseif($TPL_V1["divide_newtype"][$TPL_K2]=='dayauto'){?>
					<span class="dayautohelpicon helpicon"  opttype="<?php echo $TPL_V1["option_divide_type"][$TPL_K2]?>" title="<?php if($TPL_V1["dayauto_type"]){?>'결제확인' <?php echo $TPL_V1["dayauto_type_title"]?> <?php echo $TPL_V1["sdayauto"]?>일 <?php if($TPL_V1["dayauto_type"]=='day'){?>이후<?php }?>부터 + <?php echo $TPL_V1["fdayauto"]?>일<?php echo $TPL_V1["dayauto_day_title"]?><?php }?>">자동기간</span>
<?php }?>
<?php }?>
			</td>
<?php }}?>
<?php if($TPL_VAR["package_yn"]!='y'&&!$_GET["socialcp_input_type"]){?><td class="its-td-align center"><?php echo $TPL_V1["weight"]?></td><?php }?>
<?php if($_GET["socialcp_input_type"]){?>
			<td class="its-td-align right pdr10 couponinputtitle"><?php echo get_currency_price($TPL_V1["coupon_input"])?></td>
<?php }?>

<?php if($TPL_VAR["package_count"]){?>
			<td class="its-td-align">
				<table class="reg_package_option_tbl">
					<tr>
<?php if(is_array($TPL_R2=range( 1,$TPL_VAR["package_count"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2== 1){?>
						<td class="pdl5">
							<input type="hidden" name="stock[]" value="<?php echo $TPL_V1["stock"]?>" />
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 15){?>
							<input type="hidden" name="unUsableStock[]" value="<?php echo ($TPL_V1["badstock"]+$TPL_V1["reservation15"])?>" />
<?php }?>
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 25){?>
							<input type="hidden" name="unUsableStock[]" value="<?php echo ($TPL_V1["badstock"]+$TPL_V1["reservation25"])?>" />
<?php }?>
							<div>
								<a href="/goods/view?no=<?php echo $TPL_V1["package_goods_seq1"]?>" target="_blank">
<?php if($TPL_V1["package_goods_seq1"]){?>[<?php echo $TPL_V1["package_goods_seq1"]?>]<?php }?>
								<span class="reg_package_goods_name1"><?php echo $TPL_V1["package_goods_name1"]?></span>
								</a>
							</div>
							<div class="reg_package_option1"><?php echo $TPL_V1["package_option1"]?></div>
							<div class="reg_package_option_code1"><?php echo $TPL_V1["package_option_code1"]?> | <?php echo $TPL_V1["weight1"]?>kg</div>
							<div class="reg_package_unit_ea1">주문당 <?php echo $TPL_V1["package_unit_ea1"]?><input type="hidden" name="package_unit_ea1[]" size="3" value="<?php echo $TPL_V1["package_unit_ea1"]?>"> 발송 <span title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량" class="helpicon"></span></div>
							<div class="reg_package_option_seq1">
<?php if($TPL_V1["package_option_seq1"]){?>
							<?php echo number_format($TPL_V1["package_stock1"])?>

							(<?php echo number_format($TPL_V1["package_badstock1"])?>)
							/
							<?php echo number_format($TPL_V1["package_ablestock1"])?>

							/
							<?php echo number_format($TPL_V1["package_safe_stock1"])?>

<?php }?>
							</div>
							<input type="hidden" name="reg_package_option_seq1[]" value="<?php echo $TPL_V1["package_option_seq1"]?>">
						</td>
<?php }?>
<?php if($TPL_V2== 2){?>
						<td class="pdl5">
							<div>
								<a href="/goods/view?no=<?php echo $TPL_V1["package_goods_seq2"]?>" target="_blank">
<?php if($TPL_V1["package_goods_seq2"]){?>[<?php echo $TPL_V1["package_goods_seq2"]?>]<?php }?>
								<span class="reg_package_goods_name1"><?php echo $TPL_V1["package_goods_name2"]?></span>
								</a>
							</div>
							<div class="reg_package_option2"><?php echo $TPL_V1["package_option2"]?></div>
							<div class="reg_package_option_code2"><?php echo $TPL_V1["package_option_code2"]?> | <?php echo $TPL_V1["weight2"]?>kg</div>
							<div class="reg_package_unit_ea2">주문당 <?php echo $TPL_V1["package_unit_ea2"]?><input type="hidden" name="package_unit_ea2[]" size="3" value="<?php echo $TPL_V1["package_unit_ea2"]?>"> 발송 <span title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량" class="helpicon"></span></div>
							<div class="reg_package_option_seq2">
<?php if($TPL_V1["package_option_seq2"]){?>
							<?php echo number_format($TPL_V1["package_stock2"])?>

							(<?php echo number_format($TPL_V1["package_badstock2"])?>)
							/
							<?php echo number_format($TPL_V1["package_ablestock2"])?>

							/
							<?php echo number_format($TPL_V1["package_safe_stock2"])?>

<?php }?>
							</div>
							<input type="hidden" name="reg_package_option_seq2[]" value="<?php echo $TPL_V1["package_option_seq2"]?>">
						</td>
<?php }?>
<?php if($TPL_V2== 3){?>
						<td class="pdl5">
							<div>
								<a href="/goods/view?no=<?php echo $TPL_V1["package_goods_seq1"]?>" target="_blank">
<?php if($TPL_V1["package_goods_seq3"]){?>[<?php echo $TPL_V1["package_goods_seq3"]?>]<?php }?>
								<span class="reg_package_goods_name1"><?php echo $TPL_V1["package_goods_name3"]?></span>
								</a>
							</div>
							<div class="reg_package_option3"><?php echo $TPL_V1["package_option3"]?></div>
							<div class="reg_package_option_code3"><?php echo $TPL_V1["package_option_code3"]?> | <?php echo $TPL_V1["weight3"]?>kg</div>
							<div class="reg_package_unit_ea3">주문당 <?php echo $TPL_V1["package_unit_ea3"]?><input type="hidden" name="package_unit_ea3[]" size="3" value="<?php echo $TPL_V1["package_unit_ea3"]?>"> 발송 <span title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량" class="helpicon"></span></div>
							<div class="reg_package_option_seq3">
<?php if($TPL_V1["package_option_seq3"]){?>
							<?php echo number_format($TPL_V1["package_stock3"])?>

							(<?php echo number_format($TPL_V1["package_badstock3"])?>)
							/
							<?php echo number_format($TPL_V1["package_ablestock3"])?>

							/
							<?php echo number_format($TPL_V1["package_safe_stock3"])?>

<?php }?>
							</div>
							<input type="hidden" name="reg_package_option_seq3[]" value="<?php echo $TPL_V1["package_option_seq3"]?>">
						</td>
<?php }?>
<?php if($TPL_V2== 4){?>
						<td class="pdl5">
							<div>
								<a href="/goods/view?no=<?php echo $TPL_V1["package_goods_seq4"]?>" target="_blank">
<?php if($TPL_V1["package_goods_seq4"]){?>[<?php echo $TPL_V1["package_goods_seq4"]?>]<?php }?>
								<span class="reg_package_goods_name1"><?php echo $TPL_V1["package_goods_name4"]?></span>
								</a>
							</div>
							<div class="package_option4"><?php echo $TPL_V1["package_option4"]?></div>
							<div class="reg_package_option_code4"><?php echo $TPL_V1["package_option_code4"]?> | <?php echo $TPL_V1["weight4"]?>kg</div>
							<div class="reg_package_unit_ea4">주문당 <?php echo $TPL_V1["package_unit_ea4"]?><input type="hidden" name="package_unit_ea4[]" size="3" value="<?php echo $TPL_V1["package_unit_ea4"]?>"> 발송 <span title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량" class="helpicon"></span></div>
							<div class="package_option_seq4">
<?php if($TPL_V1["package_option_seq4"]){?>
							<?php echo number_format($TPL_V1["package_stock4"])?>

							(<?php echo number_format($TPL_V1["package_badstock4"])?>)
							/
							<?php echo number_format($TPL_V1["package_ablestock4"])?>

							/
							<?php echo number_format($TPL_V1["package_safe_stock4"])?>

<?php }?>
							</div>
							<input type="hidden" name="reg_package_option_seq4[]" value="<?php echo $TPL_V1["package_option_seq4"]?>">
						</td>
<?php }?>
<?php if($TPL_V2== 5){?>
						<td class="pdl5">
							<div>
								<a href="/goods/view?no=<?php echo $TPL_V1["package_goods_seq5"]?>" target="_blank">
<?php if($TPL_V1["package_goods_seq5"]){?>[<?php echo $TPL_V1["package_goods_seq5"]?>]<?php }?>
								<span class="reg_package_goods_name1"><?php echo $TPL_V1["package_goods_name5"]?></span>
								</a>
							</div>
							<div class="reg_package_option5"><?php echo $TPL_V1["package_option5"]?></div>
							<div class="reg_package_option_code5"><?php echo $TPL_V1["package_option_code5"]?> | <?php echo $TPL_V1["weight5"]?>kg</div>
							<div class="reg_package_unit_ea5">주문당 <?php echo $TPL_V1["package_unit_ea5"]?><input type="hidden" name="package_unit_ea5[]" size="3" value="<?php echo $TPL_V1["package_unit_ea5"]?>"> 발송 <span title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량" class="helpicon"></span></div>
							<div class="reg_package_option_seq5">
<?php if($TPL_V1["package_option_seq5"]){?>
							<?php echo number_format($TPL_V1["package_stock5"])?>

							(<?php echo number_format($TPL_V1["package_badstock5"])?>)
							/
							<?php echo number_format($TPL_V1["package_ablestock5"])?>

							/
							<?php echo number_format($TPL_V1["package_safe_stock5"])?>

<?php }?>
							</div>
							<input type="hidden" name="reg_package_option_seq5[]" value="<?php echo $TPL_V1["package_option_seq5"]?>">
						</td>
<?php }?>
<?php }}?>
					</tr>
				</table>
			</td>
<?php }else{?>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["provider_seq"]== 1&&$TPL_VAR["goods"]["goods_seq"]> 0&&$TPL_V1["org_option_seq"]> 0){?>
			<td class="its-td-align right pdr10 hand" onmouseover="scm_warehouse_on('<?php echo $TPL_VAR["goods"]["goods_seq"]?>', this);" onmouseout="scm_warehouse_off('<?php echo $TPL_VAR["goods"]["goods_seq"]?>', this);">
				<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V1["org_option_seq"]?>"><?php echo number_format($TPL_V1["stock"])?></span>
				<input type="hidden" name="stock[]" value="<?php echo $TPL_V1["stock"]?>" />
			</td>
<?php }else{?>
			<td class="its-td-align right pdr10">
				<?php echo number_format($TPL_V1["stock"])?>

				<input type="hidden" name="stock[]" value="<?php echo $TPL_V1["stock"]?>" />
			</td>
<?php }?>
			<td class="its-td-align right pdr10">
				<?php echo number_format($TPL_V1["badstock"])?>

				<input type="hidden" name="badstock[]" value="<?php echo $TPL_V1["badstock"]?>" />
			</td>
			<td class="its-td-align right pdr10">
				<input type="hidden" name="reservation15[]" value="<?php echo $TPL_V1["reservation15"]?>" />
				<input type="hidden" name="reservation25[]" value="<?php echo $TPL_V1["reservation25"]?>" />
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 15){?>
				<input type="hidden" name="unUsableStock[]" value="<?php echo $TPL_V1["badstock"]+$TPL_V1["reservation15"]?>" />
				<span class="optionUsableStock"><?php echo number_format($TPL_V1["stock"]-$TPL_V1["badstock"]-$TPL_V1["reservation15"])?></span>
<?php }?>
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 25){?>
				<input type="hidden" name="unUsableStock[]" value="<?php echo $TPL_V1["badstock"]+$TPL_V1["reservation25"]?>" />
				<span class="optionUsableStock"><?php echo number_format($TPL_V1["stock"]-$TPL_V1["badstock"]-$TPL_V1["reservation25"])?></span>
<?php }?>
			</td>
			<td class="its-td-align right pdr10">
				<?php echo number_format($TPL_V1["safe_stock"])?>

				<input type="hidden" name="safe_stock[]" value="<?php echo $TPL_V1["safe_stock"]?>" />
			</td>
<?php if($TPL_VAR["goods"]["provider_seq"]== 1){?>
			<td class="its-td-align right pdr10"><span title="<?php echo $TPL_V1["supply_price"]?>"><?php echo $TPL_V1["supply_price"]?></span></td>
<?php }?>
<?php }?>
			<td class="its-td-align center <?php if($_GET["provider_seq"]== 1){?>hide<?php }?>"><?php echo get_currency_price($TPL_V1["commission_price"],'','KRW')?></td>
			<td style="padding-right: 10px;" class="its-td-align right <?php if($_GET["provider_seq"]== 1){?>hide<?php }?>">
<?php if($TPL_V1["commission_rate"]){?>
<?php if($TPL_V1["commission_type"]=='SUPR'){?><?php echo get_currency_price($TPL_V1["commission_rate"], 2,'basic')?><?php }else{?><?php echo $TPL_V1["commission_rate"]?>%<?php }?>
<?php }else{?>
				0
<?php }?>
			</td>
			<td class="its-td-align right pdr10 pricetd">
				<?php echo get_currency_price($TPL_V1["consumer_price"])?>

				→
				<span class="priceSpan"><?php echo get_currency_price($TPL_V1["price"])?></span>
				<input type="hidden" name="price[]" value="<?php echo $TPL_V1["price"]?>" />
			</td>
			<td style="padding-right: 10px;" class="its-td-align right">
<?php if($TPL_VAR["goodsTax"]=='exempt'){?>0<?php }else{?><?php echo get_currency_price($TPL_V1["tax"])?><?php }?>
			</td>
			<td class="its-td-align center">
<?php if($TPL_V1["reserve_unit"]=='percent'){?>
				<?php echo $TPL_V1["reserve_rate"]?>% (<?php echo get_currency_price($TPL_V1["reserve"], 2,'basic')?>)
<?php }else{?>
				<?php echo get_currency_price($TPL_V1["reserve"], 2,'basic')?>

<?php }?>
			</td>
			<td class="its-td-align center"><?php if($TPL_V1["option_view"]=='N'){?>미노출<?php }else{?>노출<?php }?></td>
			<td class="its-td-align center">
<?php if($TPL_V1["infomation"]){?>
				<span class="click-lay" onclick="viewOptionInfomation(this);">보기</span>
				<textarea class="optionInfomation" style="display:none;"><?php echo $TPL_V1["infomation"]?></textarea>
<?php }else{?>
				<span class="desc">미입력</span>
<?php }?>
			</td>
		</tr>
<?php }?>
<?php }}?>
		</tbody>
<?php }?>
	</table>
</div>


<div id="preview_option_divide">
<?php if($TPL_VAR["options"]){?>
	<table class="goods_option_table" width="100%" cellpadding="0" cellspacing="5" border="0">
<?php if(is_array($TPL_R1=$TPL_VAR["options"][ 0]["option_divide_title"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
	<tr>
		<th><?php echo $TPL_V1?></th>
		<td><select style='width:200px;'><option>- 선택 -</option>
<?php if(is_array($TPL_R2=$TPL_VAR["options"][ 0]["optionArr"][$TPL_I1])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<option><?php echo $TPL_V2?></option>
<?php }}?>
		</select><td>
	</tr>
<?php }}?>
	</table>
<?php }?>
</div>
<div id="preview_option_sum">
<?php if($TPL_VAR["options"]){?>
	<table class="goods_option_table" width="100%" cellpadding="0" cellspacing="5" border="0">
	<tr>
		<th>옵션</th>
		<td><select style='width:200px;'><option>- 선택 -</option>
<?php if($TPL_options_1){foreach($TPL_VAR["options"] as $TPL_V1){?>
			<option><?php if(is_array($TPL_R2=$TPL_V1["opts"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?><?php if($TPL_I2> 0){?> / <?php }?><?php echo $TPL_V2?><?php }}?></option>
<?php }}?>
		</select><td>
	</tr>
	</table>
<?php }?>
</div>

<script type="text/javascript">
<?php if($TPL_VAR["isAddr"]=='Y'){?>
parent.show_mapView();
<?php }else{?>
parent.hide_mapView();
<?php }?>

<?php if($TPL_VAR["reload"]=='y'){?>
location.replace('?provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&mode=view&tmp_seq=<?php echo $TPL_VAR["tmp_seq"]?>&tmp_policy=<?php echo $TPL_VAR["tmp_policy"]?>&goodsTax=<?php echo $TPL_VAR["goodsTax"]?>&goods_seq=<?php echo $TPL_VAR["goods_seq"]?>&socialcp_input_type=<?php echo $_GET["socialcp_input_type"]?>&islimit=<?php echo $TPL_VAR["islimit"]?>');
<?php }else{?>
<?php if($TPL_VAR["options"]){?>
		parent.document.goodsRegist.tmp_option_seq.value	= '<?php echo $TPL_VAR["tmp_seq"]?>';
		parent.document.getElementById("optionLayer").innerHTML	= document.getElementById("optionLayer").innerHTML;
		parent.document.getElementById("preview_option_divide").innerHTML	= document.getElementById("preview_option_divide").innerHTML;
		parent.document.getElementById("preview_option_sum").innerHTML	= document.getElementById("preview_option_sum").innerHTML;
		parent.help_tooltip();
		parent.set_option_select_layout();
		parent.openall_change('<?php echo $TPL_VAR["islimit"]?>');
<?php }?>
<?php }?>

var goodsCode	= parent.document.getElementById('goodsCode').value;

var optionList	= parent.document.getElementsByClassName("goodsCode");

for (i = 0, cnt = optionList.length; i < cnt; i++) {
	optionList[i].innerHTML	= goodsCode;
} 

parent.setOptionStockSetText();
</script>