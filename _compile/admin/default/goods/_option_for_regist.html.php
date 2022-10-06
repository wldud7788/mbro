<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/goods/_option_for_regist.html 000050044 */ 
$TPL_options_1=empty($TPL_VAR["options"])||!is_array($TPL_VAR["options"])?0:count($TPL_VAR["options"]);?>
<!-- 상품 상세 필수 옵션    -->
<script type="text/javascript">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["scmTotalStock"]> 0){?>
	var scmUse = true;
<?php }else{?>
	var scmUse = false;
<?php }?>

	$(document).ready(function(){

		//var defaultOption	= $("form div#optionLayer").html();

		/* 필수옵션만들기*/
		$("#optionMake").on("click",function(){
			if	(!$(this).closest('span').hasClass('gray')){
				if(providerChk()){
					openSettingOption('');
				}
			}
		});

		/* 옵션 단일 추가*/
		$("div#optionLayer button#addOption").on("click",function(){
			$("div#optionLayer table").append( $("div#optionLayer tr.optionTr").last().clone() );
		});

		/* 필수옵션 사용/사용안함 */
		$("input[name='optionUse']").on("click",function(e,optionUse){

			if(!providerChk()){ return false;}

			var obj = $("input[name='optionUse']");

			if(typeof optionUse == 'undefined') optionUse = obj.eq(0).is(':checked');

			if(scmUse == true){
					if(goodsObj.option_use > 0){
					if($(this).is(':checked') && $(this).val() == ''){
						openDialogAlert('재고가 있어 변경할 수 없습니다.', 400, 150, function(){
							obj.eq(0).attr('checked', true);
						});
					}
				}else{
					if($(this).is(':checked') && $(this).val() == '1'){
						openDialogAlert('재고가 있어 변경할 수 없습니다.', 400, 150, function(){
							obj.eq(1).attr('checked', true);
						});
					}
				}
			}else{
				if(goodsObj.optsCnt > 0){
					if($(this).is(':checked') && $(this).val() == ''){
						if(!confirm("필수옵션 사용을 해제 할 경우 기존에 작성한 내용은 사라집니다.\n다만, 필수옵션 만들기 클릭시 옵션명,값,가격등의 기초정보는 확인하실 수 있습니다.")){
							obj.eq(0).attr('checked', true);
							return;
						}
					}
				}

				show_optionUse();
				// 사용함 체크 시
				if(optionUse){
					$("#optionLayer").find("select[name='option_international_shipping_status_view']").attr('disabled', true);
					$("#optionLayer").find("select[name='reserve_policy']").attr('disabled', true);
					$("#optionLayer").find("select[name='reserveUnit[]']").attr('disabled', true);
					$("#optionLayer").find("select[name='commissionType[]']").attr('disabled', true);
					$("#optionLayer").find('tr.optionTr').find('input').each(function(){
						if	($(this).attr('type') == 'text')	$(this).attr('disabled', true);
					});
					$("button.package_goods_make").closest("span").hide();
					$(".tr_package").hide();
				}else{
					$("#optionLayer").find("select[name='option_international_shipping_status_view']").attr('disabled', false);
					$("#optionLayer").find("select[name='reserve_policy']").attr('disabled', false);
					$("#optionLayer").find("select[name='reserveUnit[]']").attr('disabled', false);
					$("#optionLayer").find("select[name='commissionType[]']").attr('disabled', false);
					$("#optionLayer").find('tr.optionTr').find('input').each(function(){
						if	($(this).attr('type') == 'text')	$(this).attr('disabled', false);
					});
					$("button.package_goods_make").closest("span").show();

					// 필수옵션 미사용으로 변경 시 구매화면 설정 초기값으로 수정
					gl_suboption_layout_group 		= 'group';
					gl_suboption_layout_position 	= 'up';
					gl_inputoption_layout_group 	= 'group';
					gl_inputoption_layout_position 	= 'up';

					$("input[name='suboption_layout_group']").val('group');
					$("input[name='suboption_layout_position']").val('up');
					$("input[name='inputoption_layout_group']").val('group');
					$("input[name='inputoption_layout_position']").val('up');
					$(".tr_package").show();
				}

				set_option_select_layout();
			}

			//필수옵션 사용안함 시
			if(!optionUse){
				if(goodsObj.goods_seq){
					//신규
					if(typeof($("select[name='provider_seq_selector']").attr('name')) == 'undefined'){
						$('.not_for_provider').show();
						$('.not_for_seller').hide();
					}else{
						$("select[name='provider_seq_selector']").trigger('change');
					}

				}else{
					//수정
					var commission_type	= '<?php echo $TPL_VAR["provider_charge"][ 0]["commission_type"]?>';
					var commission_rate	= '<?php echo $TPL_VAR["provider_charge"][ 0]["charge"]?>';

					$('.commission_type_desc').hide();
					$('.commission_type').hide();

					if(commission_type == 'SACO' || commission_type == ''){
						//수수료 방식
						$('.commission_type_title').text('수수료');
						$('.SACO_desc').show();
						$('.SACO_unit').show();
					}else{
						$('.commission_type_title').text('공급가');
						$('.SUPPLY_desc').show();
						$('.SUPPLY_unit').show();
					}

					$("input[name='default_charge']").val(commission_rate);
					$("input[name='default_commission_type']").val(commission_type);
					$("input[name='commissionRate[]']").val(commission_rate);

					if(commission_type == 'SUPR'){
						$('select[name="commissionType[]"]>option[value="SUPR"]').attr('selected',true)
					}else{
						$('select[name="commissionType[]"]>option[value="SUCO"]').attr('selected',true)
					}

					$('select[name="commissionType[]"]').trigger('change');
				}

			}

			// 입점사 버전 and (본사 or 입점사 상품 여부) :: 재고/안전재고 입력 창 노출
			if(typeof gift == "undefined" && window.Firstmall.Config.Environment.serviceLimit.H_AD == true){
				var goods_gubun = 'provider';
				if($("input[name='provider_seq']").val() == '1'){
					goods_gubun = 'admin';
				}
				resetStockInput(goods_gubun);		// 재고관리 input 창 입력가능 여부 재세팅
			}
		});

		/*필수 옵션 미리보기*/
		$("#optionPreview").on("click",function(){
			var optCnt = $(".optionTitle").length;
			if(optCnt>0){
				var gb = $("input[name='optionViewType']").val();
				var tmp = "";
				if(gb=='divide'){
					$("#popPreviewOpt").html($("#preview_option_divide").html());
				}else{
					$("#popPreviewOpt").html($("#preview_option_sum").html());
				}
				openDialog("필수 옵션 미리 보기", "popPreviewOpt", {"width":"400","height":"300","show" : "fade","hide" : "fade"});
			}
		});

		// 옵션 관리
		/*
		$("#optionSetting").bind("click",function(){
			openDialog("자주쓰는 상품의 필수옵션 관리", "optionSettingPopup", {"width":"500","height":"500","show" : "fade","hide" : "fade"});
		});
		*/

		$("#optionLayer").on("change", "select[name='reserve_policy']", function(){
			reserve_policy();
		});

		if(goodsObj.provider_seq  == 1){
			$("input[name='commissionRate[]'], input[name='subCommissionRate[]']").val('100');
			$("input[name='commissionRate[]']").eq(0).change();
			$("input[name='subCommissionRate[]']").eq(0).change();
		}


		$("input[name='supplyPrice[]']").on("blur",function(){calulate_option_price();});
		$("input[name='consumerPrice[]']").on("blur",function(){calulate_option_price();});
		$("input[name='price[]']").on("blur",function(){calulate_option_price();});
		$("input[name='reserveRate[]']").on("blur",function(){calulate_option_price();});
		$("select[name='reserveUnit[]']").on("change",function(){calulate_option_price();});
		$("input[name='reserve[]']").on("blur",function(){calulate_option_price();});
		$("input[name='tax']").on("click",function(){calulate_option_price();});
		$("select[name='commissionType[]']").on("change",function(){ calulate_option_price();});
		$("input[name='commissionRate[]']").on("blur",function(){calulate_option_price();});
		$("input[name='commissionRate[]']").on("change",function(e){
			var float_cnt	= this.value.match(/\.[0-9]+/g);
			if(float_cnt > 0 && float_cnt.toString().length > 3){
				alert('소숫점 2자리까지 가능합니다.(2자리 초과 절삭)');
			}
			var charge		= Math.floor((this.value * 100).toFixed(0)) / 100;
			this.value		= charge;
		});

		/* 옵션 수정시 가용재고 재계산 */
		$("#optionLayer input[name='stock[]']").on('change',function(){
			var idx 			= $("#optionLayer input[name='stock[]']").index($(this));
			var stock 			= num($(this).val());
			var unUsableStock 	= num($("#optionLayer input[name='unUsableStock[]']").eq(idx).val());
			$("#optionLayer span.optionUsableStock").eq(idx).html(comma(stock-unUsableStock));
		});

		/**
		* 자주사용옵션 사용시 선택가능처리
		**/
		/*
		$("input[name='frequentlytypeoptck']").click(function(){
			if($(this).attr("checked") == "checked" ) {
				$("#frequentlytypeoptlay").removeAttr("disabled");
				$("#frequentlytypeoptlay").removeClass("gray");
			}else{
				$("#frequentlytypeoptlay").attr("disabled","disabled");
				$("#frequentlytypeoptlay").addClass("gray");
			}
		});
		*/

		// 필수옵션 모두열기 몇개만보기
		$("button.option_open_all").on("click", function(){
			openall_status_toggle(this);
		});

		// 판매마켓별 금액 설정
		$(".option-market-price").click(function(){
<?php if($TPL_VAR["LINKAGE_SERVICE"]&&$TPL_VAR["linkage"]["linkage_id"]&&$TPL_VAR["mall"]){?>
			var param	= "openType=div&resfunc=set_market_option_price&goods_seq=<?php echo $TPL_VAR["goods"]["goods_seq"]?>";
			if	($("input[name='market_tmp_seq']").val())
				param	+= "&tmpseq="+$("input[name='market_tmp_seq']").val();
			if	($("input[name='optionUse']").eq(1).is(':checked')){
				param	+= "&optuse=y&opttmpseq="+$("input[name='tmp_option_seq']").val();
			}else{
				param	+= "&optuse=n&optprice="+$("input[name='price[]']").val();
			}

			$.ajax({
				type: "get",
				url: "../openmarket/set_option_price",
				data: param,
				success: function(result) {
					$("#market_option_price_lay").html(result);
					if	(result.search(/^error/) != -1){
						result	= result.replace('error:', '');
						openDialogAlert(result, 400, 170);
					}else{
						openDialog("판매마켓별 할인가", "market_option_price_lay", {"width":"1000","height":"600"});
					}
				}
			});
	//		var popupOption	= 'width=1200px,height=700px,toolbar=no,titlebar=no,scrollbars=yes,resizeable';
	//		window.open('../openmarket/set_option_price'+param, 'OPEN_MARKET_OPTION_PRICE', popupOption);
<?php }else{?>
			openDialogAlert("현재 판매마켓 설정이 되어있지 않습니다.<br/>판매마켓을 먼저 설정해 주세요.", 400, 170);
<?php }?>
		});

		if(goodsObj.goods_seq == ''){
			calulate_option_price();
		}
		reserve_policy();

		var option_use = goodsObj.option_use;
		// 티켓 상품 등록 일 때 옵션은 무조건 사용함으로
		if(batchModify === false && socialcpuse_flag){
			option_use = 1;
		}

		if(option_use == "" || option_use == null) option_use = 0;
		$("form[name='goodsRegist'] input[name='optionUse'][value='"+option_use+"']").prop("checked",true).trigger("click",true);

		if(goodsObj.reserve_policy){
			$("form[name='goodsRegist'] select[name='reserve_policy'] option[value='"+goodsObj.reserve_policy+"']").attr("selected",true);
		}
		if(goodsObj.goods_seq){
			set_option_select_layout();
		}


	});


	var optionTmpPopup	= '';

	// openall 버튼 변경 함수
	function openall_change(isLimit){

		// 현재 리스트가 전체인지, 1개노출인지 여부에 따라 openall 버튼 상태값 변경
		var openBtn = $("button.option_open_all");
		if(isLimit == 'limit'){
			openBtn.removeClass('openall');
			openBtn.text('모두열기');
		}else{
			openBtn.addClass('openall');
			openBtn.text('<?php echo $TPL_VAR["config_goods"]["option_view_count"]?>개만보기▲');
		}
	}

	// openall 버튼 동작 함수
	function openall_status_toggle(obj){
		if	($(obj).hasClass('openall')){
			openall_change('limit');
			viewOptionTmp('limit');
		}else{
			openall_change('');
			viewOptionTmp('');
		}
	}


	// 물류관리 사용여부 체크
	function chk_scm_status(){
<?php if(($TPL_VAR["provider_seq"]=='1')&&$TPL_VAR["scm_cfg"]['use']=='Y'){?>
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
	.tr_package{padding:20px;}
</style>

	<!-- 필수옵션 : 시작 -->
	<input type="hidden" name="frequentlyopt" value="<?php echo $TPL_VAR["goods"]["frequentlyopt"]?>" />
	<input type="hidden" name="tmp_option_seq" value="" />
	<input type="hidden" name="optionViewType" value="<?php echo $TPL_VAR["goods"]["option_view_type"]?>" />
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
	<input type="hidden" name="use_warehouse" value="|<?php echo implode('|',array_keys($TPL_VAR["scm_cfg"]['use_warehouse']))?>|" />
<?php }?>
	<input type="hidden" name="optionTmpSeq" id="optionTmpSeq">

	<table class="table_basic thl mb10">
	<tr <?php if($TPL_VAR["socialcpuse"]){?>class="hide"<?php }?>>
		<th>옵션 사용 여부</th>
		<td>
			<div class="resp_radio">
				<label><input type="radio" name="optionUse" value="1" <?php if($TPL_VAR["goods"]["option_use"]=='1'||$TPL_VAR["socialcpuse"]){?>checked="checked"<?php }?> /> 사용</label>
				<label class="ml10"><input type="radio" name="optionUse" value="" <?php if($TPL_VAR["goods"]["option_use"]!='1'&&!$TPL_VAR["socialcpuse"]){?>checked="checked"<?php }?> /> 사용 안 함</label>
			</div>
		</td>
	</tr>
	<tr class="optionCreate <?php if(!$TPL_VAR["goods"]["option_use"]&&!$TPL_VAR["socialcpuse"]){?>hide<?php }?>">
		<th>옵션 생성</th>
		<td>
			<button type="button" id="optionMake" goods_seq="<?php echo $TPL_VAR["goods_seq"]?>" class="resp_btn active">옵션 생성/수정</button>
		</td>
	</tr>
<?php if($TPL_VAR["package_yn"]=='y'){?>
	<tr class="tr_package <?php if(count($TPL_VAR["options"])> 1){?>hide<?php }?>">
		<th>패키지 상품 수</th>
		<td>
			<div class="package_setting">
				<span class="<?php if($TPL_VAR["package_yn"]=='n'){?>hide<?php }?>">
					<select name="reg_package_count" onchange="reg_select_package_count($('#optionLayer'));">
						<option value="1" <?php if($TPL_VAR["package_count"]== 1){?>selected<?php }?>>1개</option>
						<option value="2" <?php if($TPL_VAR["package_count"]== 2){?>selected<?php }?>>2개</option>
						<option value="3" <?php if($TPL_VAR["package_count"]== 3){?>selected<?php }?>>3개</option>
						<option value="4" <?php if($TPL_VAR["package_count"]== 4){?>selected<?php }?>>4개</option>
						<option value="5" <?php if($TPL_VAR["package_count"]== 5){?>selected<?php }?>>5개</option>
					</select>
				</span>
			</div>
		</td>
	</tr>
	<tr class="tr_package <?php if(count($TPL_VAR["options"])> 1){?>hide<?php }?>">
		<th>상품</th>
		<td>
			<span><button type="button" class="package_goods_make resp_btn active" onclick="package_goods_make();">상품 검색</button></span>
		</td>
	</tr>
<?php }?>
	</table>

	<div class="right mb5">
<?php if($TPL_VAR["package_yn"]=='y'&&$TPL_VAR["goods"]["goods_seq"]){?>
		<span id='connect_chkResult'><button type="button" class="resp_btn" onclick="package_error_check('option');">연결 상태 확인</button></span>
<?php }?>
<?php if($TPL_VAR["goods"]["option_use"]){?>
		<button type="button" id="optionPreview" class="resp_btn">미리보기</button>
<?php if($TPL_VAR["options"]&&$TPL_VAR["options"][ 0]["option_divide_title"]){?>
<?php if($TPL_VAR["config_goods"]["option_view_count"]> 0&&$TPL_VAR["config_goods"]["option_view_count"]<count($TPL_VAR["options"])){?>
					<button type="button" class="resp_btn option_open_all">모두열기</button>
<?php }?>
<?php }?>
<?php }?>
	</div>
	<!-- 필수 옵션 싱글옵션 등록/다중옵션 보기 -->
	<div id="optionLayer">
		<table class="table_basic v7 pd5">
<?php if($TPL_VAR["options"]&&$TPL_VAR["options"][ 0]["option_divide_title"]){?>
		<!-- 다중옵션 -->
		<input type="hidden" name="optionAddPopup" value="y" />
		<input type="hidden" name="reserve_policy" value="<?php echo $TPL_VAR["goods"]["reserve_policy"]?>" />
		<input type="hidden" name="goodsCode"  id="goodsCode" value="<?php echo $TPL_VAR["goods"]["goods_code"]?>" />
			<thead>
				<tr>
					<th rowspan="2" style="width:40px">기준</th>

<?php if($TPL_VAR["package_yn"]!='y'){?>

<?php if(is_array($TPL_R1=$TPL_VAR["options"][ 0]["option_divide_title"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
						<th style="white-space: normal;">
							<?php echo $TPL_V1?>

							<input type="hidden" name="optionTitle[]" value="<?php echo $TPL_V1?>" />
							<input type="hidden" name="optionType[]" value="<?php echo $TPL_VAR["options"][ 0]["option_divide_type"][$TPL_I1]?>" />
						</th>
<?php }}?>

						<th>
							상품 코드
							<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_option_code', 'sizeS')"></span>
						</th>

<?php if($TPL_VAR["socialcpuse"]){?>
						<th class="couponinputtitle"><span class="couponinputsubtitle"><?php if($TPL_VAR["goods"]["socialcp_input_type"]=='price'){?>금액<?php }else{?>횟수<?php }?></span></th>
<?php }else{?>
						<th>무게(kg)</th>
<?php }?>


<?php }else{?>
<?php if(is_array($TPL_R1=$TPL_VAR["options"][ 0]["option_divide_title"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><th><?php echo $TPL_V1?></th><?php }}?>
<?php }?>

<?php if($TPL_VAR["package_yn"]=='y'){?>
<?php if(is_array($TPL_R1=range( 1,$TPL_VAR["package_count"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<th>상품<?php echo $TPL_V1?></th>
<?php }}?>
<?php }else{?>

					<th>
						재고
						<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_option_stock', 'sizeS')"></span>
					</th>
					<th>불량
						<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_option_bedstock', 'sizeS')"></span>
					</th>
					<th>가용
						<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_option_availablestock', 'sizeS')"></span>
					</th>
					<th>
						안전재고
<?php if(($TPL_VAR["provider_seq"]=='1')&&$TPL_VAR["scm_cfg"]['use']){?>
							<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_option_safestock', 'sizeS')"></span>
							<input type="hidden" class="safestock_text" title="<?php echo $TPL_VAR["scm_cfg"]['admin_env_name']?>"/>
<?php }else{?>
							<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_option_safestock', 'sizeS')"></span>
							<input type="hidden" class="safestock_text" title="<?php if(($TPL_VAR["provider_seq"]=='1')){?>기본매장<?php }else{?>입점사<?php }?>"/>
<?php }?>
					</th>
<?php if(($TPL_VAR["provider_seq"]=='1')){?>
					<th>매입가(평균)</th>
<?php }?>
<?php }?>
					<th class="<?php if($TPL_VAR["provider_seq"]=='1'){?>hide<?php }?>">정산 금액</th>
					<th class="<?php if($TPL_VAR["provider_seq"]=='1'){?>hide<?php }?>">
<?php if($TPL_VAR["provider_charge"][ 0]["commission_type"]=='SACO'||$TPL_VAR["provider_charge"][ 0]["commission_type"]==''){?>
						수수료
<?php }else{?>
						<span class="SUCO_title">
							공급가
						</span>
<?php }?>
					</th>
					<th>정가</th>
					<th>판매가 <span class="required_chk"></span></th>
					<th>부가세</th>
					<th>마일리지 지급</th>
					<th class="optionStockSetText">옵션 노출</th>
					<th>설명</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_options_1){$TPL_I1=-1;foreach($TPL_VAR["options"] as $TPL_V1){$TPL_I1++;?>
<?php if(!$TPL_VAR["config_goods"]["option_view_count"]||$TPL_VAR["config_goods"]["option_view_count"]>$TPL_I1){?>
				<tr class="optionTr">
					<td class="center">
<?php if($TPL_V1["default_option"]=='y'){?>●<?php }else{?><?php }?>
						<input type="hidden" name="optionSeq[]" value="<?php echo $TPL_V1["option_seq"]?>" />
					</td>
<?php if(is_array($TPL_R2=$TPL_V1["opts"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_K2=>$TPL_V2){$TPL_I2++;?>
					<td class="center optionTitle">
						<?php echo $TPL_V2?>

<?php if($TPL_V1["optcodes"][$TPL_I2]&&$TPL_VAR["package_yn"]!='y'){?><br/><span class="desc">[<?php echo $TPL_V1["optcodes"][$TPL_I2]?>]</span><?php }?>
						<input type="hidden" name="optionNames[]" value="<?php echo $TPL_V2?>" />
<?php if($TPL_V1["divide_newtype"][$TPL_K2]){?>
						<input type="hidden"  name="optnewtype[]" value="<?php echo $TPL_V1["divide_newtype"][$TPL_K2]?>">
						<br/>
<?php if($TPL_V1["divide_newtype"][$TPL_K2]=='color'){?>
						<input type="hidden"  name="optcolor[]" value="<?php echo $TPL_V1["color"]?>" />
						<div class="colorPickerBtn " style="background-color:<?php echo $TPL_V1["color"]?>" ></div>
<?php }elseif($TPL_V1["divide_newtype"][$TPL_K2]=='address'){?>
						<input type="hidden"  name="optzipcode[]" value="<?php echo $TPL_V1["zipcode"]?>" />
						<input type="hidden"  name="optaddress_type[]" value="<?php echo $TPL_V1["address_type"]?>" />
						<input type="hidden"  name="optaddress[]" value="<?php echo $TPL_V1["address"]?>" />
						<input type="hidden"  name="optaddress_street[]" value="<?php echo $TPL_V1["address_street"]?>" />
						<input type="hidden"  name="optaddressdetail[]" value="<?php echo $TPL_V1["addressdetail"]?>" />
						<input type="hidden"  name="optbiztel[]" value="<?php echo $TPL_V1["biztel"]?>" />
						<input type="hidden"  name="optaddress_commission[]" value="<?php echo $TPL_V1["address_commission"]?>" />
						<button type="button" class="addrhelpicon helpicon resp_btn" title="<?php if($TPL_V1["zipcode"]){?>[<?php echo $TPL_V1["zipcode"]?>]<br> (지번) <?php echo $TPL_V1["address"]?> <?php echo $TPL_V1["addressdetail"]?><br>(도로명) <?php echo $TPL_V1["address_street"]?> <?php echo $TPL_V1["addressdetail"]?> <?php }else{?>지역 정보가 없습니다.<?php }?> <?php if($TPL_V1["biztel"]){?><br>업체 연락처:<?php echo $TPL_V1["biztel"]?><?php }?><br/>수수료:<?php echo $TPL_V1["address_commission"]?>%">지역</button>
<?php }elseif($TPL_V1["divide_newtype"][$TPL_K2]=='date'){?>
						<input type="hidden"  name="codedate[]" value="<?php echo $TPL_V1["codedate"]?>" />
						<button type="button" class="codedatehelpicon helpicon resp_btn" title="<?php if($TPL_V1["codedate"]&&$TPL_V1["codedate"]!='0000-00-00'){?><?php echo $TPL_V1["codedate"]?> <?php }else{?>날짜 정보가 없습니다.<?php }?>">날짜</button>
<?php }elseif($TPL_V1["divide_newtype"][$TPL_K2]=='dayinput'){?>
						<input type="hidden"  name="sdayinput[]" value="<?php echo $TPL_V1["sdayinput"]?>" />
						<input type="hidden"  name="fdayinput[]" value="<?php echo $TPL_V1["fdayinput"]?>" />
						<button type="button" class="dayinputhelpicon helpicon resp_btn" title="<?php if($TPL_V1["sdayinput"]&&$TPL_V1["fdayinput"]){?><?php echo $TPL_V1["sdayinput"]?> ~ <?php echo $TPL_V1["fdayinput"]?> <?php }else{?>수동기간 정보가 없습니다.<?php }?>">수동기간</button>
<?php }elseif($TPL_V1["divide_newtype"][$TPL_K2]=='dayauto'){?>
						<input type="hidden"  name="dayauto_type[]" value="<?php echo $TPL_V1["dayauto_type"]?>" />
						<input type="hidden"  name="sdayauto[]" value="<?php echo $TPL_V1["sdayauto"]?>" />
						<input type="hidden"  name="fdayauto[]" value="<?php echo $TPL_V1["fdayauto"]?>" />
						<input type="hidden"  name="dayauto_day[]" value="<?php echo $TPL_V1["dayauto_day"]?>" />
						<button type="button" class="dayautohelpicon helpicon resp_btn" title="<?php if($TPL_V1["dayauto_type"]){?>'결제확인' <?php echo $TPL_V1["dayauto_type_title"]?> <?php echo $TPL_V1["sdayauto"]?>일 <?php if($TPL_V1["dayauto_type"]=='day'){?>이후<?php }?> + <?php echo $TPL_V1["fdayauto"]?>일<?php echo $TPL_V1["dayauto_day_title"]?> <?php }else{?>자동기간 정보가 없습니다.<?php }?> ">자동기간</button>
<?php }?>
<?php }?>
					</td>
<?php }}?>

<?php if($TPL_VAR["package_yn"]!='y'){?>
					<td class="center">
						<span class="goodsCode"><?php echo $TPL_VAR["goods"]["goods_code"]?></span><?php echo $TPL_V1["optioncode"]?>

					</td>
<?php }?>

<?php if($TPL_VAR["package_yn"]!='y'&&!$TPL_VAR["socialcpuse"]){?><td class="right "><!--무게--><?php echo $TPL_V1["weight"]?></td><?php }?>

<?php if($TPL_VAR["socialcpuse"]){?>
					<td class="right couponinputtitle">
						<?php echo number_format($TPL_V1["coupon_input"])?>

						<input type="hidden" name="coupon_input[]" value="<?php echo $TPL_V1["coupon_input"]?>" size="10" class="input-box-default-text right"/>
					</td>
<?php }?>

<?php if($TPL_VAR["package_yn"]=='y'){?>
					<!-- 패키지 상품 : 연결 된 상품 시작 -->
<?php if(is_array($TPL_R2=range( 1,$TPL_VAR["package_count"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<td class="reg_package_option_tbl">
<?php if($TPL_V2== 1){?>
							<input type="hidden" name="stock[]" value="<?php echo $TPL_V1["stock"]?>" size="5" class="onlynumber input-box-default-text right"/>
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 15){?>
							<input type="hidden" name="unUsableStock[]" value="<?php echo ($TPL_V1["badstock"]+$TPL_V1["reservation15"])?>" />
<?php }?>
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 25){?>
							<input type="hidden" name="unUsableStock[]" value="<?php echo ($TPL_V1["badstock"]+$TPL_V1["reservation25"])?>" />
<?php }?>
<?php }?>
						<input type="hidden" name="reg_package_option_seq<?php echo $TPL_V2?>[]" value="<?php echo $TPL_V1["package_option_seq"][$TPL_V2]?>">
<?php if($TPL_V1["package_error_code"][$TPL_V2]){?>
						<div class="package_error">
							<script>package_error_msg('<?php echo $TPL_V1["package_error_code"][$TPL_V2]?>');</script>
						</div>
<?php }?>
						<div class="reg_package_goods_name">
<?php if($TPL_V1["package_goods_seq"][$TPL_V2]){?>
							<a href="../goods/regist?no=<?php echo $TPL_V1["package_goods_seq"][$TPL_V2]?>" target="_blank">
							<span class="reg_package_goods_seq<?php echo $TPL_V2?>">
							[<?php echo $TPL_V1["package_goods_seq"][$TPL_V2]?>]
							</span>
<?php }?>
							<span class="reg_package_goods_name<?php echo $TPL_V2?>"><?php echo $TPL_V1["package_goods_name"][$TPL_V2]?></span>
<?php if($TPL_V1["package_goods_seq"][$TPL_V2]){?>
							</a>
<?php }?>
						</div>
						<div class="reg_package_option reg_package_option<?php echo $TPL_V2?>">
<?php if($TPL_V1["package_option"][$TPL_V2]){?>
							<?php echo $TPL_V1["package_option"][$TPL_V2]?>

<?php }else{?>
							기본
<?php }?>
						</div>
						<div class="reg_package_option_code reg_package_option_code<?php echo $TPL_V2?>">
							<?php echo $TPL_V1["package_option_code"][$TPL_V2]?>

<?php if($TPL_V1["package_option_code"][$TPL_V2]){?>|<?php }?>
							<?php echo $TPL_V1["package_weight"][$TPL_V2]?>kg
						</div>
						<div class="reg_package_unit_ea">
							주문당 <?php echo $TPL_V1["package_unit_ea"][$TPL_V2]?>개 발송
							<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_package_ea')" ></span>
						</div>
<?php if($TPL_V1["package_option_seq"][$TPL_V2]){?>
						<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V1["package_goods_seq"][$TPL_V2]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_VAR["goods"]["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
							<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V1["package_option_seq"][$TPL_V2]?>">
								<?php echo number_format($TPL_V1["package_stock"][$TPL_V2])?>

							</span>
						</span>
						(<?php echo number_format($TPL_V1["package_badstock"][$TPL_V2])?>)
						/
						<?php echo number_format($TPL_V1["package_ablestock"][$TPL_V2])?>

						/
						<?php echo number_format($TPL_V1["package_safe_stock"][$TPL_V2])?>


<?php }?>
						</div>
					</td>
<?php }}?>
					<!-- 패키지 상품 : 연결 된 상품 종료 -->
<?php }else{?>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&($TPL_VAR["provider_seq"]=='1')&&$TPL_VAR["goods"]["goods_seq"]> 0&&$TPL_V1["option_seq"]> 0){?>
					<td class="right hand" onclick="goods_option_btn('<?php echo $TPL_VAR["goods"]["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_VAR["goods"]["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
						<span class="option-stock" optType="option" optSeq="<?php echo $TPL_V1["option_seq"]?>"><?php echo number_format($TPL_V1["stock"])?></span>
						<input type="hidden" name="stock[]" value="<?php echo $TPL_V1["stock"]?>" size="5" class="onlynumber input-box-default-text right"/>
					</td>
<?php }else{?>
					<td class="right pdr10">
						<?php echo number_format($TPL_V1["stock"])?>

						<input type="hidden" name="stock[]" value="<?php echo $TPL_V1["stock"]?>" size="5" class="onlynumber input-box-default-text right" />
					</td>
<?php }?>
					<td class="right pdr10"><?php echo number_format($TPL_V1["badstock"])?></td>
					<td class="right pdr10">
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 15){?>
						<span class="optionUsableStock"><?php echo number_format($TPL_V1["stock"]-$TPL_V1["badstock"]-$TPL_V1["reservation15"])?></span>
						<input type="hidden" name="unUsableStock[]" value="<?php echo ($TPL_V1["badstock"]+$TPL_V1["reservation15"])?>" />
<?php }?>
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 25){?>
						<span class="optionUsableStock"><?php echo number_format($TPL_V1["stock"]-$TPL_V1["badstock"]-$TPL_V1["reservation25"])?></span>
						<input type="hidden" name="unUsableStock[]" value="<?php echo ($TPL_V1["badstock"]+$TPL_V1["reservation25"])?>" />
<?php }?>
					</td>
					<td class="right pdr10">
						<?php echo number_format($TPL_V1["safe_stock"])?>

						<input type="hidden" name="safe_stock[]" value="<?php echo $TPL_V1["safe_stock"]?>" size="5" class="onlynumber input-box-default-text right" />
					</td>
<?php if(($TPL_VAR["provider_seq"]=='1')){?>
					<td class="right">
						<span title="<?php echo get_currency_price($TPL_V1["supply_price"], 3)?>"><?php echo get_currency_price($TPL_V1["supply_price"],'','KRW')?></span>
						<input type="hidden" name="supplyPrice[]" value="<?php echo $TPL_V1["supply_price"]?>" size="10" class="input-box-default-text right"/>
					</td>
<?php }?>
<?php }?>
					<td class="right settlementAmount <?php if($TPL_VAR["provider_seq"]=='1'){?>hide<?php }?>"></td>
					<td class="right pdr10 <?php if($TPL_VAR["provider_seq"]=='1'){?>hide<?php }?>">
<?php if($TPL_V1["commission_rate"]){?><?php echo $TPL_V1["commission_rate"]?><?php }else{?>0<?php }?>
<?php if($TPL_V1["commission_type"]=='SUPR'){?><?php echo $TPL_VAR["config_system"]['basic_currency']?><?php }else{?>%<?php }?>

						<input class="input-box-default-text right" name="commissionRate[]" value="<?php if($TPL_VAR["provider_seq"]=='1'){?>100<?php }else{?><?php if($TPL_V1["commission_rate"]){?><?php echo $TPL_V1["commission_rate"]?><?php }else{?>0<?php }?><?php }?>" size="3" type="hidden">

						<input class="input-box-default-text right" name="commissionType[]" value="<?php if($TPL_V1["commission_type"]){?><?php echo $TPL_V1["commission_type"]?><?php }else{?><?php echo $TPL_VAR["provider_charge"][ 0]["commission_type"]?><?php }?>" type="hidden">
					</td>
					<td class="right pricetd">
						<?php echo get_currency_price($TPL_V1["consumer_price"])?>

					</td>
					<td class="right pdr10 pricetd">
						<span class="priceSpan"><?php echo get_currency_price($TPL_V1["price"])?></span>
						<input type="hidden" name="consumerPrice[]" value="<?php echo $TPL_V1["consumer_price"]?>" size="10" class="input-box-default-text right"/>
						<input type="hidden" name="price[]" value="<?php echo $TPL_V1["price"]?>" size="10" class="input-box-default-text right" />
					</td>
					<td class="right pdr10 optionst_tax tax">
<?php if($TPL_VAR["goods"]["tax"]=='exempt'){?><?php echo get_currency_price( 0)?><?php }else{?>
						<?php echo get_currency_price($TPL_V1["tax"])?>

<?php }?>
					</td>
					<td class="right pdr10 ">
<?php if($TPL_V1["reserve_unit"]=='percent'){?>
						<?php echo $TPL_V1["reserve_rate"]?>% (<?php echo get_currency_price($TPL_V1["reserve"], 2)?>)
<?php }else{?>
						<?php echo get_currency_price($TPL_V1["reserve"], 2)?>

<?php }?>
					</td>
					<td class="center"><?php if($TPL_V1["option_view"]=='N'){?>미노출<?php }else{?>노출<?php }?></td>
					<td class="center">
<?php if($TPL_V1["infomation"]){?>
							<span class="underline hand" onclick="viewOptionInfomation(this);">보기</span>
							<textarea class="optionInfomation" style="display:none;"><?php echo $TPL_V1["infomation"]?></textarea>
<?php }else{?>
							<span class="desc">미입력</span>
<?php }?>
					</td>
				</tr>
<?php }?>
<?php }}?>
			</tbody>
<?php }else{?>
			<!-- 싱글옵션 -->
			<thead>
				<tr>
<?php if($TPL_VAR["package_yn"]!='y'){?>
					<!-- 패키지 아닐 때 (일반상품/티켓상품) -->
					<th>
						상품 코드
						<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_option_code', 'sizeS')"></span>
					</th>

<?php if($TPL_VAR["socialcpuse"]){?>
					<th class="couponinputtitle"><span class="couponinputsubtitle"><?php if($TPL_VAR["goods"]["socialcp_input_type"]=='price'){?>금액<?php }else{?>횟수<?php }?></span></th>
<?php }else{?>
					<th>무게(kg)</th>
<?php }?>

					<th>
						재고
						<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_option_stock', 'sizeS')"></span>
					</th>
					<th>불량
						<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_option_bedstock', 'sizeS')"></span></th>
					<th>가용
						<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_option_availablestock', 'sizeS')"></span></th>
					<th>
						안전재고
<?php if(($TPL_VAR["provider_seq"]=='1')&&$TPL_VAR["scm_cfg"]['use']){?>
							<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_option_safestock', 'sizeS')"></span>
							<input type="hidden" class="safestock_text" title="<?php echo $TPL_VAR["scm_cfg"]['admin_env_name']?>"/>
<?php }else{?>
							<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_option_safestock', 'sizeS')"></span>
							<input type="hidden" class="safestock_text" title="<?php if(($TPL_VAR["provider_seq"]=='1')){?>기본매장<?php }else{?>입점사<?php }?>"/>
<?php }?>

					</th>
<?php if(($TPL_VAR["provider_seq"]=='1')){?>
					<th class="admin">매입가(평균)</th>
<?php }?>

<?php }else{?>
					<!-- (패키지 일 때) -->
<?php if(is_array($TPL_R1=range( 1,$TPL_VAR["package_count"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<th class="reg_package_option_title_tbl">상품<?php echo $TPL_V1?></th>
<?php }}?>
<?php }?>
					<!-- (공통) -->
					<th class="not_for_seller <?php if($TPL_VAR["goods"]["provider_seq"]< 2){?>hide<?php }?>">정산 금액</th>
					<th class="not_for_seller <?php if($TPL_VAR["goods"]["provider_seq"]< 2){?>hide<?php }?>">
						<span class="commission_type_title">
<?php if($TPL_VAR["provider_charge"][ 0]["commission_type"]=='SACO'||$TPL_VAR["provider_charge"][ 0]["commission_type"]==''){?>
							수수료
<?php }else{?>
							공급가
<?php }?>
						</span>
					</th>
					<th>정가</th>
					<th>판매가 <span class="required_chk"></span></th>
					<th>부가세</th>
					<th>마일리지</th>
					<!--<th class="optionStockSetText"></th>-->
				</tr>
			</thead>
			<tbody>
				<!--- 필수옵션 사용 클릭 시 노출 영역 -->
				<tr class="optionTr">
<?php if($TPL_VAR["package_yn"]!='y'){?>
					<td class="center">
<?php if($TPL_VAR["goods"]["goods_seq"]> 0){?>
						<button type="button" id="goodsCodeBtn" class="resp_btn v2" title="기본코드자동생성" >코드생성</button>
<?php }?>

						<input type="hidden" name="optionSeq[]" value="<?php echo $TPL_VAR["options"][ 0]["option_seq"]?>" />
						<input type="text"  name="goodsCode"  id="goodsCode" value="<?php echo $TPL_VAR["goods"]["goods_code"]?>" class="wp80"/>
						<!--select name="option_international_shipping_status_view" onchange="set_option_international_shipping_status(this);">
							<option value="n">N</option>
							<option value="y" <?php if($TPL_VAR["goods"]["option_international_shipping_status"]=='y'){?>selected<?php }?>>Y</option>
						</select-->
					</td>
<?php }?>
<?php if($TPL_VAR["package_yn"]!='y'&&!$TPL_VAR["socialcpuse"]){?>
					<td class="center">
						<input class="onlyfloat input-box-default-text right" name="weight[]" value="<?php if($TPL_VAR["options"][ 0]["weight"]){?><?php echo $TPL_VAR["options"][ 0]["weight"]?><?php }else{?>0<?php }?>" size="4" type="text">
					</td>
<?php }?>

<?php if($TPL_VAR["socialcpuse"]){?>
					<td class="right couponinputtitle"><input type="text" name="coupon_input[]" class="right" size="10" value="<?php echo $TPL_VAR["options"][ 0]["coupon_input"]?>"/></td>
<?php }?>
<?php if($TPL_VAR["package_yn"]=='y'){?>
				<!-- 패키지 연결 상품 1 ~ 5-->
<?php if(is_array($TPL_R1=range( 1,$TPL_VAR["package_count"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<td class="reg_package_option_tbl">
<?php if($TPL_V1== 1){?><input type="hidden" name="stock[]" value="<?php echo $TPL_VAR["options"][ 0]["stock"]?>" /><?php }?>
<?php if($TPL_VAR["options"][ 0]["package_error_code"][$TPL_V1]){?>
								<div class="package_error">
									<script>package_error_msg('<?php echo $TPL_VAR["options"][ 0]["package_error_code"][$TPL_V1]?>');</script>
								</div>
<?php }?>
								<div class="reg_package_goods_name">
<?php if($TPL_VAR["options"][ 0]["package_goods_seq"][$TPL_V1]){?>
										<a href="../goods/regist?no=<?php echo $TPL_VAR["options"][ 0]["package_goods_seq"][$TPL_V1]?>">
										<span class="reg_package_goods_seq<?php echo $TPL_V1?>">[<?php echo $TPL_VAR["options"][ 0]["package_goods_seq"][$TPL_V1]?>]</span>
<?php }?>
										<span class="reg_package_goods_name<?php echo $TPL_V1?>"><?php echo $TPL_VAR["options"][ 0]["package_goods_name"][$TPL_V1]?></span>
<?php if($TPL_VAR["options"][ 0]["package_goods_seq"][$TPL_V1]){?>
										</a>
<?php }?>
								</div>
								<div class="reg_package_option reg_package_option<?php echo $TPL_V1?>"><?php echo $TPL_VAR["options"][ 0]["package_option"][$TPL_V1]?></div>
								<div class="reg_package_unit_ea reg_package_unit_ea<?php echo $TPL_V1?>">
									주문당
									<input type="text" name="package_unit_ea<?php echo $TPL_V1?>[]" size="3" value="<?php echo $TPL_VAR["options"][ 0]["package_unit_ea"][$TPL_V1]?>" style="text-align:right;">
									발송
									<span class="tooltip_btn" onClick="showTooltip(this, '../tooltip/goods', '#regist_package_ea')" ></span>
								</div>
								<div class="reg_package_option_seq<?php echo $TPL_V1?>" stock="<?php echo $TPL_VAR["options"][ 0]["package_stock"][$TPL_V1]?>" rstock="<?php echo $TPL_VAR["options"][ 0]["package_ablestock"][$TPL_V1]?>" badstock="<?php echo $TPL_VAR["options"][ 0]["package_badstock"][$TPL_V1]?>" safe_stock="<?php echo $TPL_VAR["options"][ 0]["package_safe_stock"][$TPL_V1]?>">
<?php if($TPL_VAR["options"][ 0]["package_option_seq"][$TPL_V1]){?>
								<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_VAR["options"][ 0]["package_goods_seq"][$TPL_V1]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_VAR["goods"]["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
									<span class="option-stock" optType="option" optSeq="<?php echo $TPL_VAR["options"][ 0]["package_option_seq"][$TPL_V1]?>">
										<?php echo number_format($TPL_VAR["options"][ 0]["package_stock"][$TPL_V1])?>

									</span>
								</span>
								(<?php echo number_format($TPL_VAR["options"][ 0]["package_badstock"][$TPL_V1])?>)
								/
								<?php echo number_format($TPL_VAR["options"][ 0]["package_ablestock"][$TPL_V1])?>

								/
								<?php echo number_format($TPL_VAR["options"][ 0]["package_safe_stock"][$TPL_V1])?>

<?php }?>
								</div>
								<input type="hidden" name="reg_package_option_seq<?php echo $TPL_V1?>[]" value="<?php echo $TPL_VAR["options"][ 0]["package_option_seq"][$TPL_V1]?>">
							</td>
<?php }}?>
				<!-- 패키지 연결 상품 1 ~ 5-->
<?php }else{?>

<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["provider_seq"]=='1'&&$TPL_VAR["goods"]["goods_seq"]> 0&&$TPL_VAR["options"][ 0]["option_seq"]){?>
					<td class="right pdr10 hand _stock" onclick="goods_option_btn('<?php echo $TPL_VAR["goods"]["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_VAR["goods"]["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
						<span class="option-stock" optType="option" optSeq="<?php echo $TPL_VAR["options"][ 0]["option_seq"]?>"><?php echo number_format($TPL_VAR["options"][ 0]["stock"])?></span>
						<input type="hidden" name="stock[]" value="<?php echo $TPL_VAR["options"][ 0]["stock"]?>" size="5" class="onlynumber right"/>
					</td>
<?php }elseif($TPL_VAR["scm_cfg"]['use']=='Y'&&($TPL_VAR["provider_seq"]=='1')){?>
					<td class="right pdr10 _stock">
						<span><?php echo number_format($TPL_VAR["options"][ 0]["stock"])?></span>
						<input type="hidden" name="stock[]" value="<?php echo $TPL_VAR["options"][ 0]["stock"]?>" size="5" class="onlynumber right"/>
					</td>
<?php }else{?>
					<td class="center _stock">
						<input type="text" name="stock[]" value="<?php echo $TPL_VAR["options"][ 0]["stock"]?>" size="5" class="onlynumber right"/>
					</td>
<?php }?>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_VAR["provider_seq"]=='1'){?>
					<td class="right pdr10 _stock">
						<span><?php echo number_format($TPL_VAR["options"][ 0]["badstock"])?></span>
						<input type="hidden" name="badstock[]" value="<?php echo $TPL_VAR["options"][ 0]["badstock"]?>" size="5" class="onlynumber right"/>
					</td>
<?php }else{?>
					<td class="center _stock">
						<input type="text" name="badstock[]" value="<?php echo $TPL_VAR["options"][ 0]["badstock"]?>" size="5" class="onlynumber right" />
					</td>
<?php }?>
					<td class="right pdr10 _stock">
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
					<td class="center _stock">
						<input type="text" name="safe_stock[]" value="<?php echo $TPL_VAR["options"][ 0]["safe_stock"]?>" size="5" class="onlynumber right"/>
					</td>
<?php if(($TPL_VAR["provider_seq"]=='1')){?>
					<td class="right admin">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
						<?php echo get_currency_price($TPL_VAR["options"][ 0]["supply_price"])?>

						<input type="hidden" name="supplyPrice[]" value="<?php echo $TPL_VAR["options"][ 0]["supply_price"]?>" />
<?php }else{?>
						<input type="text" name="supplyPrice[]" value="<?php echo get_currency_price($TPL_VAR["options"][ 0]["supply_price"], 1)?>" class="onlyfloat right wp80" />
<?php }?>
					</td>
<?php }?>
<?php }?>

				<td class="settlementAmount right not_for_seller <?php if($TPL_VAR["provider_seq"]=='1'){?>hide<?php }?>"></td>
				<td class="not_for_seller <?php if($TPL_VAR["provider_seq"]=='1'){?>hide<?php }?> center">
					<input class="onlyfloat  right" name="commissionRate[]" value="<?php if($TPL_VAR["options"][ 0]["commission_rate"]){?><?php echo $TPL_VAR["options"][ 0]["commission_rate"]?><?php }else{?>0<?php }?>" size="3" type="text">
					<span class="commission_type SACO_unit" <?php if($TPL_VAR["provider_charge"][ 0]["commission_type"]!='SACO'&&$TPL_VAR["provider_charge"][ 0]["commission_type"]!=''){?>style="display:none"<?php }?>>%</span>
					<span class="commission_type SUPPLY_unit" <?php if($TPL_VAR["provider_charge"][ 0]["commission_type"]=='SACO'||$TPL_VAR["provider_charge"][ 0]["commission_type"]==''){?>style="display:none"<?php }?>>
						<select name="commissionType[]" class="commission_type_sel">
							<option value="SUCO" <?php if($TPL_VAR["options"][ 0]["commission_type"]!='SUPR'){?>selected<?php }?>>%</option>
							<option value="SUPR" <?php if($TPL_VAR["options"][ 0]["commission_type"]=='SUPR'){?>selected<?php }?>>원</option>
						</select>
					</span>
				</td>

				<td class="center pricetd">
					<input type="text" name="consumerPrice[]" value="<?php echo get_currency_price($TPL_VAR["options"][ 0]["consumer_price"], 1)?>" class="onlyfloat right black wp80" />
				</td>
				<td class="center pricetd">
					<input type="text" name="price[]" value="<?php echo get_currency_price($TPL_VAR["options"][ 0]["price"], 1)?>" class="onlyfloat right wp80" />
				</td>
				<td class="tax right"><?php echo get_currency_price( 0)?></td>
				<td class="center">
					<select name="reserve_policy">
						<option value="shop" <?php if($TPL_VAR["goods"]["reserve_policy"]!='goods'){?>selected<?php }?>>통합</option>
						<option value="goods" <?php if($TPL_VAR["goods"]["reserve_policy"]=='goods'){?>selected<?php }?>>개별</option>
					</select>
					<input type="text" name="reserveRate[]" class="onlyfloat right" size="5" value="<?php echo $TPL_VAR["options"][ 0]["reserve_rate"]?>" />
					<select name="reserveUnit[]" >
<?php if($TPL_VAR["options"][ 0]["reserve_unit"]=='percent'){?>
						<option value="percent" selected>%</option>
						<option value="<?php echo $TPL_VAR["config_system"]['basic_currency']?>"><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
<?php }else{?>
						<option value="percent">%</option>
						<option value="<?php echo $TPL_VAR["config_system"]['basic_currency']?>" selected><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
<?php }?>
					</select>
					<input type="hidden" name="reserve[]" class="noborder right" value="<?php echo $TPL_VAR["options"][ 0]["reserve"]?>" size="7" readonly />
				</td>
				<!--<td class="center">
					<input type="hidden" name="option_view[]" value="Y" />노출
				</td>-->
			</tr>
			</tbody>
<?php }?>
		</table>
	</div>
	<ul class='bullet_hyphen resp_message'>
		<li>옵션 보기 <span style="margin-top:-5px;"><button type='button' name='' class='btn_goods_default_set resp_btn v2' data-type="option">기본 설정</button></span></li>
	</ul>

	<div id="preview_option_divide" style="display:none;">
		<div class="content">
<?php if($TPL_VAR["options"]){?>
			<table class="table_basic">
<?php if(is_array($TPL_R1=$TPL_VAR["options"][ 0]["option_divide_title"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
				<tr>
					<th><?php echo $TPL_V1?></th>
					<td>
						<select style='width:200px;'><option>- 선택 -</option>
<?php if(is_array($TPL_R2=$TPL_VAR["options"][ 0]["optionArr"][$TPL_I1])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
							<option><?php echo $TPL_V2?></option>
<?php }}?>
						</select>
						</td>
				</tr>
<?php }}?>
			</table>
<?php }?>
		</div>
		<div class="footer">
			<input type="button" class="resp_btn v3 size_XL" onclick="closeDialog('popPreviewOpt')" value="닫기" />
		</div>
	</div>

	<div id="preview_option_sum" style="display:none;">
		<div class="content">
<?php if($TPL_VAR["options"][ 0]){?>
			<table class="table_basic">
				<tr>
					<th>옵션</th>
					<td>
						<select style='width:200px;'><option>- 선택 -</option>
<?php if($TPL_options_1){foreach($TPL_VAR["options"] as $TPL_V1){?>
							<option><?php if(is_array($TPL_R2=$TPL_V1["opts"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?><?php if($TPL_I2> 0){?> / <?php }?><?php echo $TPL_V2?><?php }}?></option>
<?php }}?>
						</select>
					</td>
				</tr>
			</table>
<?php }?>
		</div>
		<div class="footer">
			<input type="button" class="resp_btn v3 size_XL" onclick="closeDialog('popPreviewOpt')" value="닫기" />
		</div>
	</div>

	<div id="selectGoodsOptionsDialog" class="hide"></div>

	<script>package_unit_ea_display();</script>

	<div id="optionInfomationLay" class="hide">
		<div class="content">
			<table class="table_basic">
			<thead>
			<tr>
				<th class="infomation-th">설명</th>
			</tr>
			</thead>
			<tbody>
			</tbody>
			</table>
		</div>
		<div class="footer">
			<button type="button" class="resp_btn v3 size_XL" onClick="closeDialog('optionInfomationLay')">닫기</button>
		</div>

	</div>