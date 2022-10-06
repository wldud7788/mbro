<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_suboption_for_regist.html 000020180 */ 
$TPL_suboptions_1=empty($TPL_VAR["suboptions"])||!is_array($TPL_VAR["suboptions"])?0:count($TPL_VAR["suboptions"]);?>
<!-- 상품등록 : 추가 구성옵션 영역 -->
<script type="text/javascript">
	$(document).ready(function(){
	
		// 추가구성옵션 만들기
		$("#subOptionMake").on("click",function(){
			if	(!$(this).closest('span').hasClass('gray')){
				openSettingSubOption('');
			}
		});

		// 추가옵션 사용
		$("input[name='subOptionUse']").on("click",function(){
<?php if($TPL_VAR["sopts_loop"]){?>
			if(!$(this).is(':checked')){
				if(!confirm("추가구성옵션 사용을 해제 할 경우 기존에 작성한 내용은 사라집니다.\n다만, 추가구성옵션 만들기 클릭시 옵션명,값,가격등의 기초정보는 확인하실 수 있습니다.")){
					$(this).attr("checked",true);
					return;
				} else {
					$("input[name='frequentlysub']").val("0");
				}
			}
<?php }?>
			show_subOptionUse();
			set_option_select_layout();
		});
	
		// 추가 옵션 미리보기
		$("#subOptionPreview").click(function(){
			var optCnt = $(".subOptionTitle").length;
			if(optCnt>0){
				$("#popPreviewOpt").html($("#preview_suboption").html());
				openDialog("추가 구성옵션 미리보기", "popPreviewOpt", {"width":"400","height":"230","show" : "fade","hide" : "fade"});
			}
		});
	
	/*
		// 가져오기 선택 시
		$("input[name='frequentlytypesuboptck']").click(function(){
			if($(this).attr("checked") == "checked" ) {
				$("#frequentlytypesuboptlay").removeAttr("disabled");
				$("#frequentlytypesuboptlay").removeClass("gray");
			}else{
				$("#frequentlytypesuboptlay").attr("disabled","disabled");
				$("#frequentlytypesuboptlay").addClass("gray");
			}
		});
		*/
	
		// 추가옵션 모두열기 몇개만보기
		$(".suboption_open_all").on("click", function(){
			var openBtn = $(this);
			if	($(this).hasClass('openall')){
				viewSubOptionTmp('limit');
				openBtn.removeClass('openall');
				openBtn.text('모두열기');
			}else{
				viewSubOptionTmp('');
				openBtn.addClass('openall');
				openBtn.text('<?php echo $TPL_VAR["config_goods"]["suboption_view_count"]?>개만보기▲');
			}
		});

<?php if($TPL_VAR["goods"]["option_suboption_use"]){?>
		$("form[name='goodsRegist'] input[name='subOptionUse'][value='1']").prop("checked",true);
		show_subOptionUse();
<?php }?>
	
		$("input[name='subReserveRate[]']").on("blur",function(){calulate_subOption_price();});
		$("select[name='subReserveUnit[]']").on("change",function(){calulate_subOption_price();});
		$("input[name='subReserve[]']").on("blur",function(){calulate_subOption_price();});
		$("input[name='subSupplyPrice[]']").on("blur",function(){calulate_subOption_price();});
		$("input[name='subConsumerPrice[]']").on("blur",function(){calulate_subOption_price();});
		$("input[name='subPrice[]']").on("blur",function(){calulate_subOption_price();});
		$("input[name='subCommissionRate[]']").on("blur",function(){calulate_subOption_price();});
	
		calulate_subOption_price();
		set_option_select_layout();
	});


//새창에서 추가구성옵션 가져오기시
function openSettingSubOptionnew(add_goods_seq){
	var tmp_seq				= $("input[name='tmp_suboption_seq']").val();
	var goodsTax		= $("input[name='tax']:checked").val();
	if	(!goodsTax)	goodsTax	= 'tax';
	var policy				= $("select[name='reserve_policy'] option:selected").val();
	if	(!policy)	policy	= $("input[name='reserve_policy']").val();
	var windowOption		= 'width=1010px,height=600px,toolbar=no,titlebar=no,scrollbars=yes,resizeable';

	var socialcp_input_type = eval('$("input[name=\'socialcp_input_type\']:checked").val()');

	var url	= 'set_goods_suboptions?provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&add_goods_seq='+add_goods_seq+'&goods_seq=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type;
	window.open(url, 'SUB_OPTION_POP', windowOption);
}

function setSubOptionTmp(tmp_opno,tmp_frequently){

	var socialcp_input_type = eval('$("input[name=\'socialcp_input_type\']:checked").val()');

	var goodsTax		= $("input[name='tax']:checked").val();
	if	(!goodsTax)	goodsTax	= 'tax';
	var policy				= $("select[name='reserve_policy'] option:selected").val();
	if	(!policy)	policy	= $("input[name='reserve_policy']").val();
	$("iframe[name='actionFrame']").attr('src', 'set_goods_suboptions?provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&mode=view&tmp_seq='+tmp_opno+'&tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type);
	$("input[name='tmp_suboption_seq']").val(tmp_opno);
	$("input[name='frequentlysub']").val(tmp_frequently);

	if	(tmp_opno){
		set_option_select_layout();
	}
}

function viewSubOptionTmp(islimit){
	var tmp_seq				= $("input[name='tmp_suboption_seq']").val();
	var policy				= $("select[name='reserve_policy'] option:selected").val();
	if	(!policy)	policy	= $("input[name='reserve_policy']").val();
	var socialcp_input_type = eval('$("input[name=\'socialcp_input_type\']:checked").val()');
	var provider_seq = "<?php echo $TPL_VAR["provider_seq"]?>";
	if(!provider_seq){
		provider_seq		= $("input[name='provider_seq']").val();
	}
	var linkurl				= 'set_goods_suboptions?provider_seq='+provider_seq+'&mode=view&goods_seq=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&tmp_seq='+tmp_seq+'&goodsTax=<?php echo $TPL_VAR["goods"]["tax"]?>&socialcp_input_type='+socialcp_input_type+'&islimit='+islimit;
	actionFrame.location.replace(linkurl);
}

function chgSuboptionReservePolicy(policy){
	var goods_seq	= '<?php echo $TPL_VAR["goods"]["goods_seq"]?>';
	var goodsTax		= $("input[name='tax']:checked").val();
	if	(!goodsTax)	goodsTax	= 'tax';
	var tmp_seq		= $("input[name='tmp_suboption_seq']").val();

	var socialcp_input_type = $("input[name='socialcp_input_type']:checked").val();

	if			(tmp_seq){
		$("iframe[name='actionFrame']").attr('src', 'set_goods_suboptions?provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&mode=chgPolicy&tmp_seq='+tmp_seq+'&tmp_policy='+policy+"&goodsTax="+goodsTax+"&socialcp_input_type="+socialcp_input_type);
	}else if	(goods_seq){
		$("iframe[name='actionFrame']").attr('src', 'set_goods_suboptions?provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&mode=chgPolicy&goods_seq=<?php echo $TPL_VAR["goods"]["goods_seq"]?>&tmp_policy=<?php echo $TPL_VAR["goods"]["reserve_policy"]?>&goodsTax=<?php echo $TPL_VAR["goods"]["tax"]?>&socialcp_input_type='+socialcp_input_type);
	}
}
</script>
<input type="hidden" name="frequentlysub" value="<?php echo $TPL_VAR["goods"]["frequentlysub"]?>" />
<input type="hidden" name="package_yn_suboption" value="<?php echo $TPL_VAR["package_yn_suboption"]?>" />
<input type="hidden" name="sub_reserve_policy" value="<?php if($TPL_VAR["goods"]["sub_reserve_policy"]=='goods'){?>goods<?php }else{?>shop<?php }?>" />
<?php if(!($TPL_VAR["socialcpuse"]||$TPL_VAR["goods"]["goods_kind"]=='coupon')){?>
<input type="hidden" name="tmp_suboption_seq" value="" />
<div>
	<table class="table_basic thl mb10">
		<tr>
		<th>옵션 사용 여부</th>
		<td colspan="3">
			<div class="resp_radio">
				<label><input type="radio" name="subOptionUse" value="1" <?php if($TPL_VAR["goods"]["option_suboption_use"]){?>checked="checked"<?php }?> /> 사용</label>
				<label class="ml10"><input type="radio" name="subOptionUse" value="" <?php if($TPL_VAR["goods"]["option_suboption_use"]!='1'){?>checked="checked"<?php }?> /> 사용 안 함</label>
			</div>
		</td>
	</tr>
	<tr class="subOptionCreate <?php if(!$TPL_VAR["goods"]["option_suboption_use"]){?>hide<?php }?>">
		<th>옵션 생성</th>
		<td colspan="3">
			<button type="button" id="subOptionMake" class="resp_btn active">옵션 생성/수정</button>
		</td>
	</tr>
	<tr class="subOptionCreate <?php if(!$TPL_VAR["goods"]["option_suboption_use"]){?>hide<?php }?>">
		<th>옵션 화면</th>
		<td>
			<button type="button" class="resp_btn v2 option_layout_button" data-mode="suboption">구매 방법 설정</button>
		</td>
		<th>주문 단계별 설정</th>
		<td>
		<button type="button" id="subOptionProcessBtn" class="resp_btn v2">설정</button>
		</td>
	</tr>
	</table>
</div>

<div class="suboptionPriview right mb5 <?php if(!$TPL_VAR["goods"]["option_suboption_use"]){?>hide<?php }?>">
	<button type="button" id="subOptionPreview" class="resp_btn">미리보기</button>
<?php if($TPL_VAR["suboptions"]&&$TPL_VAR["config_goods"]["suboption_view_count"]> 0&&$TPL_VAR["config_goods"]["suboption_view_count"]<$TPL_VAR["totsuboptionrowcnt"]){?>
	<button type="button" class="resp_btn suboption_open_all">모두열기</button>
<?php }?>
</div>
<div id="suboptionLayer">
<?php if($TPL_VAR["suboptions"]){?>
	<table class="table_basic v7 pd">
	<thead>
	<tr>
		<th style='min-width:50px;'>추가혜택</th>
		<th style='min-width:50px;'>필수선택</th>
		<th style='min-width:60px;'>옵션명</th>
		<th style='min-width:80px;'>옵션값</th>
<?php if($TPL_VAR["package_yn_suboption"]!='y'&&$TPL_VAR["isplusfreenot"]&&!$TPL_VAR["package_count_suboption"]){?>
		<th style='min-width:60px;'>옵션코드</th>
<?php }?>
<?php if($TPL_VAR["package_yn_suboption"]!='y'&&!$TPL_VAR["package_count_suboption"]){?><th style='min-width:40px;'>무게(kg)</th><?php }?>
<?php if($TPL_VAR["socialcpuse"]){?>
		<th class="couponinputtitle" style='min-width:60px;'>값어치<span class="couponinputsubtitle"><?php if($TPL_VAR["goods"]["socialcp_input_type"]=='price'){?>금액<?php }else{?>횟수<?php }?></span></th>
<?php }?>
<?php if($TPL_VAR["package_yn_suboption"]=='y'){?>
		<th style='min-width:80px;'>
			<div class="pdb5">상품
				<button type="button" onclick="package_error_check('suboption');" class="resp_btn v2">연결 상태 확인</button>
			</div>
		</th>
<?php }else{?>
		<th style='min-width:50px;'>재고</th>
		<th style='min-width:50px;'>불량</th>
		<th style='min-width:50px;'>가용</th>
		<th style='min-width:60px;'>안전재고</th>
<?php }?>
		<th style='min-width:60px;'>정산 금액</th>
		<th style='min-width:60px;'>
<?php if($TPL_VAR["provider_charge"][ 0]["commission_type"]=='SACO'||$TPL_VAR["provider_charge"][ 0]["commission_type"]==''){?>
			수수료
<?php }else{?>
			<span class="SUCO_title">공급가</span>
<?php }?>
		</th>
		<th style='min-width:60px;'>정가</th>
		<th style='min-width:60px;'>판매가</th>
		<th style='min-width:60px;'>마일리지 지급</th>
		<th class="optionStockSetText" style='min-width:60px;'>옵션 노출</th>
	</tr>
	</thead>
	<tbody>
<?php if($TPL_suboptions_1){foreach($TPL_VAR["suboptions"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_K2=>$TPL_V2){$TPL_I2++;?>
<?php if(!$TPL_VAR["config_goods"]["suboption_view_count"]||$TPL_VAR["config_goods"]["suboption_view_count"]>$TPL_I2){?>
	<tr class="suboptionTr">
		<td class="center">
			<input type="hidden" name="suboptionSeq[]" value="<?php echo $TPL_V2["suboption_seq"]?>" />
<?php if($TPL_K2== 0){?>
<?php if($TPL_V2["sub_sale"]=='y'){?>Y<?php }else{?>N<?php }?>
<?php }?>
		</td>
		<td class="center">
<?php if($TPL_K2== 0){?>
<?php if($TPL_V2["sub_required"]=='y'){?>Y<?php }else{?>N<?php }?>
<?php }?>
		</td>
		<td class="center subOptionTitle">
<?php if($TPL_K2== 0){?><?php echo $TPL_V2["suboption_title"]?><?php }?>
		</td>
		<td class="center">
			<?php echo $TPL_V2["suboption"]?>

<?php if($TPL_V2["newtype"]){?>
<?php if($TPL_V2["newtype"]=='color'){?>
			<div class="colorPickerBtn " style="background-color:<?php echo $TPL_V2["color"]?>" ></div>
<?php }elseif($TPL_V2["newtype"]=='address'){?>
			<span class="addrhelpicon helpicon" title="<?php if($TPL_V2["zipcode"]){?>[<?php echo $TPL_V2["zipcode"]?>] <br> (지번) <?php echo $TPL_V2["address"]?> <?php echo $TPL_V2["addressdetail"]?><br>(도로명) <?php echo $TPL_V2["address_street"]?>  <?php echo $TPL_V2["addressdetail"]?> <?php }else{?>지역 정보가 없습니다.<?php }?> <?php if($TPL_V2["biztel"]){?>업체 연락처:<?php echo $TPL_V2["biztel"]?><?php }?>">지역</span>
<?php }elseif($TPL_V2["newtype"]=='date'){?>
			<span class="codedatehelpicon helpicon" title="<?php if($TPL_V2["codedate"]&&$TPL_V2["codedate"]!='0000-00-00'){?><?php echo $TPL_V2["codedate"]?> <?php }else{?>날짜 정보가 없습니다.<?php }?>">날짜</span>
<?php }elseif($TPL_V2["newtype"]=='dayinput'){?>
			<span class="dayinputhelpicon helpicon" title="<?php if($TPL_V2["sdayinput"]&&$TPL_V2["fdayinput"]){?><?php echo $TPL_V2["sdayinput"]?> ~ <?php echo $TPL_V2["fdayinput"]?> <?php }else{?>자동기간 정보가 없습니다.<?php }?>">수동기간</span>
<?php }elseif($TPL_V2["newtype"]=='dayauto'){?>
			<span class="dayautohelpicon helpicon" title="<?php if($TPL_V2["dayauto_type"]){?>'결제확인' <?php echo $TPL_V2["dayauto_type_title"]?> <?php echo $TPL_V2["sdayauto"]?>일 <?php if($TPL_V2["dayauto_type"]=='day'){?>이후<?php }?>부터 + <?php echo $TPL_V2["fdayauto"]?>일<?php echo $TPL_V2["dayauto_day_title"]?> <?php }else{?>자동기간 정보가 없습니다.<?php }?>">자동기간</span>
<?php }?>
<?php }?>
		</td>
<?php if($TPL_VAR["package_yn_suboption"]!='y'&&$TPL_VAR["isplusfreenot"]&&!$TPL_V1[ 0]["package_count"]){?>
			<td class="center"><span class="goodsCode"><?php echo $TPL_VAR["goods"]["goods_code"]?></span><?php echo $TPL_V2["suboption_code"]?></td>
<?php }?>
<?php if($TPL_VAR["package_yn_suboption"]!='y'){?><td class="right pdr10"><?php echo $TPL_V2["weight"]?></td><?php }?>
<?php if($TPL_VAR["socialcpuse"]){?>
		<td class="center couponinputtitle">
			<?php echo get_currency_price($TPL_V2["coupon_input"])?>

			<input type="hidden" name="subcoupon_input[]" value="<?php echo $TPL_V2["coupon_input"]?>" />
		</td>
<?php }?>
<?php if($TPL_V2["package_count"]){?>
			<td class="pdl5">
<?php if($TPL_V2["package_error_code1"]){?>
				<div class="package_error">
					<script>package_error_msg('<?php echo $TPL_V2["package_error_code1"]?>');</script>
				</div>
<?php }?>
				<div>
<?php if($TPL_V2["package_goods_seq1"]){?>
					<a href="../goods/regist?no=<?php echo $TPL_V2["package_goods_seq1"]?>" target="_blank">
					<span class="tmp_package_goods_seq1">[<?php echo $TPL_V2["package_goods_seq1"]?>]</span>
<?php }?>
					<span class="tmp_package_goods_name1"><?php echo $TPL_V2["package_goods_name1"]?></span>
<?php if($TPL_V2["package_goods_seq1"]){?>
					</a>
<?php }?>
				</div>
				<div class="tmp_package_option_name1"><?php echo $TPL_V2["package_option1"]?></div>
				<div class="tmp_package_goodscode1"><?php echo $TPL_V2["package_option_code1"]?> <?php if($TPL_V2["weight1"]){?><?php if($TPL_V2["package_option_code1"]){?>|<?php }?> <?php echo $TPL_V2["weight1"]?>kg <?php }?></div>
				<div>
					주문당 <?php echo number_format($TPL_V2["package_unit_ea1"])?>개 발송
					<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_package_ea')" ></span>
				</div>
				<div>
					<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V2["package_goods_seq1"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_VAR["goods"]["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
						<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V2["package_option_seq1"]?>">
							<?php echo number_format($TPL_V2["package_stock1"])?>

						</span>
					</span>
					(<?php echo number_format($TPL_V2["package_badstock1"])?>)
					/ <?php echo number_format($TPL_V2["package_ablestock1"])?>

					/ <?php echo number_format($TPL_V2["package_safe_stock1"])?>

					<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_package_stock')" ></span>
				</div>
			</td>
<?php }else{?>
		<td class="center">
			<?php echo number_format($TPL_V2["stock"])?>

		</td>
		<td class="center">
			<?php echo number_format($TPL_V2["badstock"])?>

		</td>
		<td class="center">
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 15){?>
			<?php echo number_format($TPL_V2["stock"]-$TPL_V2["badstock"]-$TPL_V2["reservation15"])?>

<?php }?>
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 25){?>
			<?php echo number_format($TPL_V2["stock"]-$TPL_V2["badstock"]-$TPL_V2["reservation25"])?>

<?php }?>
		</td>
		<td class="center">
			<?php echo number_format($TPL_V2["safe_stock"])?>

		</td>
<?php }?>
		<td class="right pdr10 subSettlementAmount"></td>
		<td style="padding-right: 10px;" class="its-td-align right">
			<input style="text-align: right;" class="line input-box-default-text" name="subCommissionRate[]" value="<?php if($TPL_V2["commission_rate"]){?><?php echo $TPL_V2["commission_rate"]?><?php }else{?>0<?php }?>" size="3" type="hidden">
			<input style="text-align: right;" class="line input-box-default-text" name="subCommissionType[]" value="<?php if($TPL_V2["commission_type"]){?><?php echo $TPL_V2["commission_type"]?><?php }else{?>0<?php }?>" size="3" type="hidden">
<?php if($TPL_V2["commission_rate"]){?><?php echo $TPL_V2["commission_rate"]?><?php }else{?>0<?php }?>
<?php if($TPL_V2["commission_type"]=='SUPR'){?><?php echo $TPL_VAR["basic_currency"]?><?php }else{?>%<?php }?>
		</td>
		<td class="right pdr10 pricetd">
			<?php echo get_currency_price($TPL_V2["consumer_price"])?>

			<input type="hidden" name="subConsumerPrice[]" value="<?php echo $TPL_V2["consumer_price"]?>" />
		</td>
		<td class="right pdr10 pricetd"><span class="priceSpan"><?php echo get_currency_price($TPL_V2["price"])?></span>
			<input type="hidden" name="subPrice[]" value="<?php echo $TPL_V2["price"]?>" />
		</td>
		<td class="right pdr10">
<?php if($TPL_V2["reserve_unit"]=='percent'){?>
			<?php echo floatval($TPL_V2["reserve_rate"])?>% (<?php echo get_currency_price($TPL_V2["reserve"], 2)?>)
<?php }else{?>
			<?php echo get_currency_price($TPL_V2["reserve"], 2)?>

<?php }?>
		</td>
		<td class="center"><?php if($TPL_V2["option_view"]=='N'){?>미노출<?php }else{?>노출<?php }?></td>
	</tr>
<?php }?>
<?php }}?>
<?php }}?>
	</tbody>
	</table>
<?php }?>
</div>

<input type="hidden" name="tmp_suboption_seq" value="" />
<ul class='bullet_hyphen resp_message'>
	<li>옵션 보기 <span style="margin-top:-5px;"><button type='button' name='' class='btn_goods_default_set resp_btn v2' data-type="option">기본 설정</button></span></li>
</ul>

<!-- 추가구성옵션 주문 단계별 설정 값 -->
<input type="hidden" id="individual_refund" name="individual_refund" value="<?php if($TPL_VAR["goods"]["individual_refund"]=='1'){?>1<?php }else{?>0<?php }?>" />
<input type="hidden" id="individual_refund_inherit" name="individual_refund_inherit" value="<?php echo $TPL_VAR["goods"]["individual_refund_inherit"]?>" />
<input type="hidden" id="individual_export" name="individual_export" value="<?php if($TPL_VAR["goods"]["individual_export"]=='1'){?>1<?php }else{?>0<?php }?>" />
<input type="hidden" id="individual_return" name="individual_return" value="<?php if($TPL_VAR["goods"]["individual_return"]=='1'){?>1<?php }else{?>0<?php }?>" />

<!-- 추가구성옵션 미리보기-->
<div id="preview_suboption" class="hide">
	<div class="content">
<?php if($TPL_VAR["suboptions"]){?>
		<table class="table_basic">
<?php if($TPL_suboptions_1){foreach($TPL_VAR["suboptions"] as $TPL_V1){?>
	<tr>
		<th><?php echo $TPL_V1[ 0]['suboption_title']?></th>
		<td><select style='width:200px;'><option>- 선택 -</option>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<option><?php echo $TPL_V2["suboption"]?></option>
<?php }}?>
			</select>
		</td>
	</tr>
<?php }}?>
	</table>
<?php }?>
	</div>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onClick="closeDialog('popPreviewOpt')">닫기</button>
	</div>
</div>
<?php }?>