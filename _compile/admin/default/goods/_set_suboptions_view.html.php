<?php /* Template_ 2.2.6 2022/05/17 12:32:00 /www/music_brother_firstmall_kr/admin/skin/default/goods/_set_suboptions_view.html 000019064 */ 
$TPL_suboptions_1=empty($TPL_VAR["suboptions"])||!is_array($TPL_VAR["suboptions"])?0:count($TPL_VAR["suboptions"]);?>
<script  type="text/javascript">
	var gl_goods_seq = '<?php echo $TPL_VAR["goods_seq"]?>';
	var gl_package_yn = '<?php echo $_GET["package_yn"]?>';
	function helpicon_style(){
		/* 툴팁 */
		$(".helpicon, .help", window.parent.document).each(function(){

			var options = {
				className: 'tip-darkgray',
				bgImageFrameSize: 8,
				alignTo: 'target',
				alignX: 'right',
				alignY: 'center',
				offsetX: 10,
				allowTipHover: false,
				slide: false,
				showTimeout : 0
			}

			if($(this).attr('options')){
				var customOptions = eval('('+$(this).attr('options')+')');
				for(var i in customOptions){
					options[i] = customOptions[i];
				}
			}

			$(this).poshytip(options);
		});
	}

	//
	function socialcpinputtype() {
<?php if($_GET["socialcp_input_type"]){?>
		var socialcp_input_type = '<?php echo $_GET["socialcp_input_type"]?>';
<?php }else{?>
			var socialcp_input_type = $("input[name='socialcp_input_type']:checked", window.parent.document).val();
<?php }?>
		if(socialcp_input_type) {
			var couponinputsubtitle = '';
			$(".couponinputtitle").show();
			if( socialcp_input_type == 'price' ) {
				couponinputsubtitle = '금액';
			}else{
				couponinputsubtitle = '횟수';
			}
			$(".couponinputsubtitle").text(couponinputsubtitle);
		}
	}
</script>

<div id="suboptionLayer">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
	<input type="hidden" name="use_warehouse" value="|<?php echo implode('|',array_keys($TPL_VAR["scm_cfg"]['use_warehouse']))?>|" />
<?php }?>
	<table class="info-table-style" style="width:100%">
		<input type="hidden" name="suboptionAddPopup" value="y" />
	<thead>
	<tr>
		<th class="its-th-align center" rowspan="2">추가<br/>혜택</th>
		<th class="its-th-align center" rowspan="2">필수<br/>여부</th>
<?php if($_GET["package_yn"]!='y'){?><th class="its-th-align center" rowspan="2">상품코드</th><?php }?>
		<th class="its-th-align center" rowspan="2">옵션명</th>
		<th class="its-th-align center" rowspan="2">옵션값</th>
<?php if($_GET["package_yn"]!='y'){?><th class="its-th-align center" rowSpan="2">무게<br/>(kg)</th><?php }?>
<?php if($_GET["socialcp_input_type"]){?>
		<th class="its-th-align center couponinputtitle" rowspan="2">쿠폰1장→값어치<br/><span class="couponinputsubtitle"><?php if($_GET["socialcp_input_type"]=='price'){?>금액<?php }else{?>횟수<?php }?></span></th>
<?php }?>
<?php if($_GET["package_yn"]=='y'){?>
		<th class="its-th-align center">
			<div class="pdb5">
			실제 상품
<?php if($TPL_VAR["mode"]!='view'){?>
			<span class="btn small cyanblue"><button type="button" onclick="package_suboption_make();">검색</button></span>
<?php }?>
			<span class="btn small cyanblue"><button type="button" onclick="package_error_check('suboption');">연결 상태 확인</button></span>
			</div>
		</th>
<?php }else{?>
		<th class="its-th-align center" colspan="<?php if($TPL_VAR["provider_seq"]== 1){?>5<?php }else{?>4<?php }?>">
<?php if($TPL_VAR["provider_seq"]== 1){?>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
			<?php echo $TPL_VAR["scm_cfg"]['admin_env_name']?> = <?php echo implode(', ',$TPL_VAR["scm_cfg"]['use_warehouse'])?>

			<input type="hidden" name="use_warehouse" value="|<?php echo implode('|',array_keys($TPL_VAR["scm_cfg"]['use_warehouse']))?>|" />
<?php }else{?>
			기본매장 = 기본창고
<?php }?>
			<span class="helpicon" title="해당 상점(매장)에서 판매 재고로 사용하는 창고 기준의 재고입니다."></span>
<?php }else{?>
			<span class="storeinfo_title">재고: <?php echo $TPL_VAR["provider_info"]["provider_name"]?></span>
<?php }?>
		</th>
<?php }?>
		<th class="its-th-align center <?php if($_GET["provider_seq"]=='1'){?>hide<?php }?>" rowspan="2">정산 금액</th>
		<th class="its-th-align center <?php if($_GET["provider_seq"]=='1'){?>hide<?php }?>" rowspan="2">
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
			<span class="helpicon" title="정가는 소비자가격이며,<br/>판매가는 할인가격입니다."></span>
		</th>
		<th class="its-th-align center" rowspan="2">부가세</th>
		<th class="its-th-align center" rowspan="2">
			<div>
<?php if($TPL_VAR["goods"]["goods"]["sub_reserve_policy"]=='goods'||$TPL_VAR["sub_tmp_policy"]=='goods'){?>개별정책<?php }else{?>통합정책<?php }?>
			</div>
			지급 캐시
		</th>
		<th class="its-th-align center optionStockSetText" rowspan="2"></th>
	</tr>
	<tr>
<?php if($_GET["package_yn"]=='y'){?>
		<th class="its-th-align center">
			<table width="100%" class="package-option-titles" cellpadding="0" cellspacing="0">
			<tr>
				<td height="26" width="<?php echo  100/$TPL_VAR["suboptions"][ 0][ 0]["package_count"]?>">
					상품
				</td>
			</tr>
			</table>
		</th>
<?php }else{?>
		<th class="its-th-align center">재고 <span class="helpicon" title="재고 = 정상 재고 + 불량 재고"></span></th>
		<th class="its-th-align center">불량</th>
		<th class="its-th-align center">가용 <span class="helpicon" title="가용 = 재고 – 출고예약량 – 불량 재고"></span></th>
		<th class="its-th-align center">안전재고 <span class="helpicon" title="<?php if($TPL_VAR["provider_seq"]== 1){?><?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?><?php echo $TPL_VAR["scm_cfg"]['admin_env_name']?><?php }else{?>기본매장<?php }?><?php }else{?>입점사<?php }?>의 안전재고입니다.<br/>해당 상품의 재고수량이 안전재고 이하인 경우 자동 발주가 생성됩니다."></span></th>
<?php if($TPL_VAR["provider_seq"]== 1){?>
		<th class="its-th-align center">매입가(평균)<br />KRW, 원</th>
<?php }?>
<?php }?>
	</tr>
	</thead>
<?php if($TPL_VAR["suboptions"]){?>
	<tbody>
<?php if($TPL_suboptions_1){foreach($TPL_VAR["suboptions"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_K2=>$TPL_V2){$TPL_I2++;?>
<?php if(!$TPL_VAR["config_goods"]["suboption_view_count"]||$TPL_VAR["config_goods"]["suboption_view_count"]>$TPL_I2||$TPL_VAR["islimit"]!='limit'){?>
	<tr class="suboptionTr">
		<td class="its-td-align center">
<?php if($TPL_K2== 0){?>
<?php if($TPL_V2["sub_sale"]=='y'){?>Y<?php }else{?>N<?php }?>
<?php }?>
		</td>
		<td class="its-td-align center">
			<input type="hidden" name="suboptionSeq[]" value="<?php echo $TPL_V2["suboption_seq"]?>" />
<?php if($TPL_K2== 0){?>
<?php if($TPL_V2["sub_required"]=='y'){?>Y<?php }else{?>N<?php }?>
<?php }?>
		</td>
<?php if($_GET["package_yn"]!='y'||!$TPL_V1[ 0]["package_count"]){?><td class="its-td-align center"><span class="goodsCode"><?php echo $TPL_VAR["goods"]["goods_code"]?></span><?php echo $TPL_V2["suboption_code"]?></td><?php }?>
		<td class="its-td-align center subOptionTitle">
<?php if($TPL_K2== 0){?>
				<?php echo $TPL_V2["suboption_title"]?>

<?php }?>
		</td>
		<td class="its-td-align center"><?php echo $TPL_V2["suboption"]?>

<?php if($TPL_V2["newtype"]){?>
				<br/>
<?php if($TPL_V2["newtype"]=='color'){?>
					<div class="colorPickerBtn colorhelpicon helpicon1"  opttype="<?php echo $TPL_V2["suboption_type"]?>"  style="background-color:<?php echo $TPL_V2["color"]?>" ></div>
<?php }elseif($TPL_V2["newtype"]=='address'){?>
					<span class="addrhelpicon helpicon" opttype="<?php echo $TPL_V2["suboption_type"]?>"  title="<?php if($TPL_V2["zipcode"]){?>[<?php echo $TPL_V2["zipcode"]?>] <?php echo $TPL_V2["address"]?> <?php echo $TPL_V2["addressdetail"]?> <?php }else{?>지역 정보가 없습니다.<?php }?> <?php if($TPL_V2["biztel"]){?>업체 연락처:<?php echo $TPL_V2["biztel"]?><?php }?>">지역</span>
<?php }elseif($TPL_V2["newtype"]=='date'){?>
					<span class="codedatehelpicon helpicon" opttype="<?php echo $TPL_V2["suboption_type"]?>"  title="<?php if($TPL_V2["codedate"]&&$TPL_V2["codedate"]!='0000-00-00'){?><?php echo $TPL_V2["codedate"]?> <?php }else{?>날짜 정보가 없습니다.<?php }?>">날짜</span>
<?php }elseif($TPL_V2["newtype"]=='dayinput'){?>
					<span class="dayinputhelpicon helpicon" opttype="<?php echo $TPL_V2["suboption_type"]?>"  title="<?php if($TPL_V2["sdayinput"]&&$TPL_V2["fdayinput"]){?><?php echo $TPL_V2["sdayinput"]?> ~ <?php echo $TPL_V2["fdayinput"]?> <?php }else{?>수동기간 정보가 없습니다.<?php }?>">수동기간</span>
<?php }elseif($TPL_V2["newtype"]=='dayauto'){?>
					<span class="dayautohelpicon helpicon" opttype="<?php echo $TPL_V2["suboption_type"]?>"  title="<?php if($TPL_V2["dayauto_type"]){?>'결제확인' <?php echo $TPL_V2["dayauto_type_title"]?> <?php echo $TPL_V2["sdayauto"]?>일 <?php if($TPL_V2["dayauto_type"]=='day'){?>이후<?php }?>부터 + <?php echo $TPL_V2["fdayauto"]?>일<?php echo $TPL_V2["dayauto_day_title"]?> <?php }else{?>자동기간 정보가 없습니다.<?php }?>">자동기간</span>
<?php }?>
<?php }?>
		</td>
<?php if($_GET["package_yn"]!='y'){?><td class="its-td-align center"><?php echo $TPL_V2["weight"]?></td><?php }?>
<?php if($_GET["socialcp_input_type"]){?>
		<td class="its-td-align right pdr10 couponinputtitle">
			<input type="hidden" name="subcoupon_input[]" value="<?php echo $TPL_V2["coupon_input"]?>" />
			<?php echo get_currency_price($TPL_V2["coupon_input"])?>

		</td>
<?php }?>

<?php if($_GET["package_yn"]=='y'){?>
		<td class="its-td-align">
			<input type="hidden" name="tmp_package_count" value="<?php echo $TPL_VAR["suboption_package_count"]?>" />
			<table width="100%" class="package-suboption" cellpadding="0" cellspacing="0">
				<tr>

					<td class="pdl5">
						<div>
<?php if($TPL_V2["package_goods_seq1"]){?>
							<a href="/goods/view?no=<?php echo $TPL_V2["package_goods_seq1"]?>" target="_blank">
<?php }?>
							<span class="tmp_package_goods_seq1"><?php if($TPL_V2["package_goods_seq1"]){?>[<?php echo $TPL_V2["package_goods_seq1"]?>]<?php }?></span>
							<span class="tmp_package_goods_name1"><?php echo $TPL_V2["package_goods_name1"]?></span>
<?php if($TPL_V2["package_goods_seq1"]){?>
							</a>
<?php }?>
						</div>
						<div class="tmp_package_option_name1"><?php echo $TPL_V2["package_option1"]?></div>
						<div class="tmp_package_goodscode1"><?php echo $TPL_V2["package_option_code1"]?> | <?php echo $TPL_V2["weight1"]?>kg</div>
						<div>
							주문당
							<?php echo $TPL_V2["package_unit_ea1"]?>개 발송
							<span class="helpicon" title="해당 판매상품 주문수량 1개일때 해당 실제상품의 발송수량"></span>
						</div>
						<div>
<?php if($TPL_V2["package_stock1"]){?>
							<span>
								<?php echo number_format($TPL_V2["package_stock1"])?>

							</span>
							(<span class="tmp_package_badstock"><?php echo $TPL_V2["package_badstock1"]?></span>)
							/ <span class="tmp_package_ablestock"><?php echo $TPL_V2["package_ablestock1"]?></span>
							/ <span class="tmp_package_ablestock"><?php echo $TPL_V2["package_safe_stock1"]?></span>
							<span class="helpicon" title="현재재고 (불량재고) / 가용재고 / 안전재고"></span>
<?php }?>
						</div>

						<input type="hidden" name="tmp_package_option_seq1[]" value="<?php echo $TPL_V2["package_option_seq1"]?>" />
						<input type="hidden" name="tmp_package_option1[]" value="<?php echo $TPL_V2["package_option1"]?>" />
						<input type="hidden" name="tmp_package_goods_name1[]" value="<?php echo $TPL_V2["package_goods_name1"]?>" />
					</td>

				</tr>
			</table>
		</td>
<?php }else{?>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["provider_seq"]== 1&&$TPL_VAR["scm_use_suboption_mode"]&&$TPL_VAR["goods_seq"]> 0&&$TPL_V2["org_suboption_seq"]> 0){?>
		<td class="its-td-align right pdr10 hand" onclick="scm_warehouse_on('<?php echo $TPL_VAR["goods_seq"]?>', this);">
			<span class="option-stock" optType="suboption" optSeq="<?php echo $TPL_V2["org_suboption_seq"]?>"><?php echo number_format($TPL_V2["stock"])?></span>
			<input type="hidden" name="subStock[]" value="<?php echo $TPL_V2["stock"]?>" />
		</td>
<?php }else{?>
		<td class="its-td-align right pdr10">
			<?php echo number_format($TPL_V2["stock"])?>

			<input type="hidden" name="subStock[]" value="<?php echo $TPL_V2["stock"]?>" />
		</td>
<?php }?>
		<td class="its-td-align right pdr10">
			<?php echo number_format($TPL_V2["badstock"])?>

		</td>
		<td class="its-td-align right pdr10">
			<?php echo number_format($TPL_V2["stock"]-$TPL_V2["totunUsableStock"])?>

		</td>
		<td class="its-td-align right pdr10">
			<?php echo number_format($TPL_V2["safe_stock"])?>

		</td>
<?php if($TPL_VAR["provider_seq"]== 1){?>
		<td class="its-td-align right pdr10">
			<span title="<?php echo $TPL_V2["supply_price"]?>"><?php echo $TPL_V2["supply_price"]?></span>
			<input type="hidden" name="subSupplyPrice[]" value="<?php echo $TPL_V2["supply_price"]?>" />
		</td>
<?php }?>
<?php }?>
		<td class="its-td-align center subSettlementAmount <?php if($_GET["provider_seq"]=='1'){?>hide<?php }?>"></td>
		<td style="padding-right: 10px;" class="its-td-align right <?php if($_GET["provider_seq"]=='1'){?>hide<?php }?>">
			<input style="text-align: right;" class="line onlyfloat input-box-default-text" name="subCommissionRate[]" value="<?php if($TPL_V2["commission_rate"]){?><?php echo $TPL_V2["commission_rate"]?><?php }else{?>0<?php }?>" size="3" type="hidden">

			<input style="text-align: right;" class="line onlyfloat input-box-default-text" name="subCommissionType[]" value="<?php if($TPL_V2["commission_type"]){?><?php echo $TPL_V2["commission_type"]?><?php }else{?>0<?php }?>" size="3" type="hidden">
<?php if($TPL_V2["commission_rate"]){?><?php echo $TPL_V2["commission_rate"]?><?php }else{?>0<?php }?>
<?php if($TPL_V2["commission_type"]=='SUPR'){?><?php echo $TPL_VAR["config_system"]['basic_currency']?><?php }else{?>%<?php }?>
		</td>
		<td class="its-td-align right pdr10 pricetd">
			<?php echo get_currency_price($TPL_V2["consumer_price"])?> → <span class="priceSpan"><?php echo get_currency_price($TPL_V2["price"])?></span>
			<input type="hidden" name="subConsumerPrice[]" value="<?php echo $TPL_V2["consumer_price"]?>" />
			<input type="hidden" name="subPrice[]" value="<?php echo $TPL_V2["price"]?>" />
		</td>
		<td class="its-td-align right pdr10 suboptions_tax">
<?php if($TPL_VAR["goodsTax"]=='exempt'||$TPL_VAR["goods"]["tax"]=='exempt'){?>
			0
<?php }else{?>
			<?php echo get_currency_price($TPL_V2["tax"])?>

<?php }?>
		</td>
		<td class="its-td-align center">
<?php if($TPL_V2["reserve_unit"]=='percent'){?>
			<?php echo floatval($TPL_V2["reserve_rate"])?>% (<?php echo get_currency_price($TPL_V2["reserve"], 1,'basic')?>)
<?php }else{?>
			<?php echo get_currency_price($TPL_V2["reserve"], 1,'basic')?>

<?php }?>
		</td>
		<td class="its-td-align center"><?php if($TPL_V2["option_view"]=='N'){?>미노출<?php }else{?>노출<?php }?></td>
	</tr>
<?php }?>
<?php }}?>
<?php }}?>
	</tbody>
<?php }?>
	</table>
</div>


<div id="preview_suboption" style="display:none;">
<?php if($TPL_VAR["suboptions"]){?>
	<table class="goods_option_table" width="100%" cellpadding="0" cellspacing="5" border="0">
<?php if($TPL_suboptions_1){foreach($TPL_VAR["suboptions"] as $TPL_V1){?>
	<tr>
		<th><?php echo $TPL_V1[ 0]['suboption_title']?></th>
		<td><select style='width:200px;'><option>- 선택 -</option>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<option><?php echo $TPL_V2["suboption"]?></option>
<?php }}?>
		</select><td>
	</tr>
<?php }}?>
	</table>
<?php }?>
</div>


<script type="text/javascript">
<?php if($TPL_VAR["reload"]=='y'){?>
	location.replace('?provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&mode=view&tmp_seq=<?php echo $TPL_VAR["tmp_seq"]?>&sub_tmp_policy=<?php echo $TPL_VAR["sub_tmp_policy"]?>&goodsTax=<?php echo $TPL_VAR["goodsTax"]?>&goods_seq=<?php echo $TPL_VAR["goods_seq"]?>&socialcp_input_type=<?php echo $_GET["socialcp_input_type"]?>&islimit=<?php echo $TPL_VAR["islimit"]?>');
	socialcpinputtype();
<?php }else{?>
<?php if($TPL_VAR["suboptions"]){?>
		$("input[name='tmp_suboption_seq']", parent.document).val('<?php echo $TPL_VAR["tmp_seq"]?>');
		$("#suboptionLayer", parent.document).html($("#suboptionLayer").html());
		$("#preview_suboption", parent.document).html($("#preview_suboption").html());
<?php }else{?>
		$("input[name='tmp_suboption_seq']", parent.document).val('');
		$("#suboptionLayer", parent.document).html('');
		$("#preview_suboption", parent.document).html('');
<?php }?>
	helpicon_style();
	socialcpinputtype();
	parent.set_option_select_layout();
<?php }?>
	//parent.calulate_option_price();
	parent.calulate_subOption_price();
	$("input[name='supplyPrice[]']").bind("blur",function(){parent.calulate_option_price();});
	$("input[name='consumerPrice[]']").bind("blur",function(){parent.calulate_option_price();});
	$("input[name='price[]']").live("blur",function(){parent.calulate_option_price();});
	$("input[name='reserveRate[]']").bind("blur",function(){parent.calulate_option_price();});
	$("select[name='reserveUnit[]']").bind("change",function(){parent.calulate_option_price();});
	$("input[name='reserve[]']").bind("blur",function(){parent.calulate_option_price();});
	$("input[name='subReserveRate[]']").bind("blur",function(){parent.calulate_subOption_price();});
	$("select[name='subReserveUnit[]']").bind("change",function(){parent.calulate_subOption_price();});
	$("input[name='subReserve[]']").bind("blur",function(){parent.calulate_subOption_price();});
	$("input[name='tax']").bind("click",function(){parent.calulate_option_price();});
	$("input[name='commissionRate[]']").bind("blur",function(){parent.calulate_option_price();});

	$("input[name='subReserveRate[]']").bind("blur",function(){parent.calulate_subOption_price();});
	$("select[name='subReserveUnit[]']").bind("change",function(){parent.calulate_subOption_price();});
	$("input[name='subReserve[]']").bind("blur",function(){parent.calulate_subOption_price();});
	$("input[name='subSupplyPrice[]']").bind("blur",function(){parent.calulate_subOption_price();});
	$("input[name='subConsumerPrice[]']").bind("blur",function(){parent.calulate_subOption_price();});
	$("input[name='subPrice[]']").bind("blur",function(){parent.calulate_subOption_price();});
	$("input[name='subCommissionRate[]']").bind("blur",function(){parent.calulate_subOption_price();});
	$("select[name='subCommissionType[]']").bind("blur",function(){parent.calulate_subOption_price();});

	var optionStockSetText	= parent.setOptionStockSetText();
	$('.optionStockSetText').html(optionStockSetText);
</script>