<?php /* Template_ 2.2.6 2022/01/05 11:47:07 /www/music_brother_firstmall_kr/admin/skin/default/market_connector/coupang_add_info.html 000025933 */ ?>
<?php if($TPL_VAR["displayMmode"]=='popup'){?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/market_connector.css?dummy=<?php echo date('YmdHis')?>" />
<?php }?>

<script type="text/javascript" src="/app/javascript/js/admin-addInfoRegist.js"></script>

<script>
	var	mode			= '<?php echo $TPL_VAR["mode"]?>';
	var	modeText		= (mode == 'renew' || mode == 'marketRenew') ? '수정' : '등록';
	var seller_id		= '<?php echo $TPL_VAR["seller_id"]?>';
	var market			= '<?php echo $TPL_VAR["market"]?>';
	var outboundAddress	= {};
	var addInfo			= <?php echo $TPL_VAR["addInfo"]?>;
	
	//객체동결(변경금지)
	Object.freeze(addInfo);

	var reloaded = false;

	$(document).ready(function() {

		if (reloaded === true)
			return;

		reloaded 	= true;
		market		= '<?php echo $TPL_VAR["market"]?>';

		// 필수정보 기본셋팅
		setAddInfoRegist();

		$('#deliveryChargeType').change(function(){
			variableCheck(this, 'FREE_DELIVERY_OVER_9800|FREE_DELIVERY_OVER_19800|FREE_DELIVERY_OVER_30000|NOT_FREE|CONDITIONAL_FREE');
			
			var freeShipOverAmount		= 0;
			var chargeOnReturn			= true;

			switch (this.value) {
				case	'FREE_DELIVERY_OVER_9800' :
					freeShipOverAmount	= 9800;
					break;
				
				case	'FREE_DELIVERY_OVER_19800' :
					freeShipOverAmount	= 19800;
					break;

				case	'FREE_DELIVERY_OVER_30000' :
					freeShipOverAmount	= 30000;
					break;

				case	'FREE' :
					chargeOnReturn		= false;

					freeShipOverCondition = true;
					break;
					<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
				case 'NOT_FREE' :
					freeShipOverCondition = true;

					break;
			}

			$('#deliveryChargeOnReturn').attr('disabled', chargeOnReturn);

			<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
			$('#freeShipOverAmount').attr('disabled', freeShipOverCondition);
			if(this.value == 'CONDITIONAL_FREE') {
				$('#freeShipOverAmount').removeAttr('readonly');
			} else {
				$('#freeShipOverAmount').attr('readonly','readonly');
				$('#freeShipOverAmount').val(freeShipOverAmount);
			}
		});

		$('#outboundShippingPlaceCode').change(function() {
			$('#deliveryCompanyCode > option').attr('disabled', true);
			var outboundShippingPlaceCode	= this.value;
			if (outboundShippingPlaceCode == 'AUTO') {
				$('#deliveryCompanyCode > option').attr('disabled', false);
				return;
			} else {
				$('#deliveryCompanyCode > option[value="AUTO"]').attr('disabled', true);
			}

			var addressInfo	= outboundAddress[outboundShippingPlaceCode];
			var selectFirst	= false;

			for (cnt = addressInfo.remoteInfos.length, i = 0; i < cnt; i++) {
				var nowRemoteInfo	= addressInfo.remoteInfos[i];
				if (nowRemoteInfo.usable !== true)
					continue;

				if (selectFirst === false) 
					selectFirst	= nowRemoteInfo.deliveryCode;

				$('#deliveryCompanyCode > option[value="' + nowRemoteInfo.deliveryCode + '"]').attr('disabled', false);				
			}

			if ($('#deliveryCompanyCode').val() == 'AUTO' || $('#deliveryCompanyCode > option:selected').attr('disabled') == 'disabled')
				$('#deliveryCompanyCode > option[value="' + selectFirst + '"]').attr('selected', true);
		});

		$('#saleStartSet, #saleEndSet').change(function(){ variableCheck(this, 'SETDATE'); });

		if(mode == 'renew' || mode == 'marketRenew') {
			callConnector('categoryMoreInfo', setCategoryDesc, {cagrgoryCode:addInfo.category_code});
			$('#saleStartSet, #saleEndSet, #deliveryChargeType').trigger('change');
		}

		
	});

	function resetCategoryDesc() {
		$('#optionNoti').hide();
		$('#optionNoti > tbody').children().remove()
	}

	function setCategoryDesc(response) {
		if (response.success == 'Y') {
			var resultData	= response.resultData;

			if (resultData.hasOwnProperty('attributes') === true) {
				var attributes	= resultData.attributes;
				var attrCount	= attributes.length;
				var $notiObj	= $('#optionNoti > tbody');
				$notiObj.children().remove();
				
				if (attrCount < 1) {
					$notiObj.append('<tr><td class="its-td center" colspan="5">해당 카테고리의 옵션 필수정보가 없습니다.</td></tr>');
					$('#optionNoti').show();
					return;
				}

				var baseTr		= "<tr><td class='its-td pd10 center'></td>";
				baseTr			+= "<td class='its-td pdl10 left'></td>";
				baseTr			+= "<td class='its-td pdl10	left'></td>";
				baseTr			+= "<td class='its-td pdl10 left'></td>";
				baseTr			+= "<td class='its-td pdl10 left'></td></tr>";
				
				var $baseTrObj	= $(baseTr);

				var setArrtTr	= function(required, nowAttr) {
					var $nowObj	= $baseTrObj.clone();

					if (required === true) {
						$nowObj.find('td:eq(0)').html('<span class="bold blue">필수</span>');
						$nowObj.find('td:eq(1)').html('<span class="bold">' + nowAttr.attributeTypeName + '</span>');
					} else {
						$nowObj.find('td:eq(0)').html('선택');
						$nowObj.find('td:eq(1)').html(nowAttr.attributeTypeName);
					}

					
					$nowObj.find('td:eq(2)').html(nowAttr.dataType);
					$nowObj.find('td:eq(3)').html(nowAttr.basicUnit);

					if (nowAttr.usableUnits.length > 0)
						$nowObj.find('td:eq(4)').html(nowAttr.usableUnits.join(', '));
					else
						$nowObj.find('td:eq(4)').html('없음');
					
					$notiObj.append($nowObj);
				}
				
				var mandatoryList	= [];
				var optionalList	= [];
				for (i = 0; i < attrCount; i++) {
					var nowAttr	= attributes[i];
					if (nowAttr.required == 'MANDATORY')
						mandatoryList.push(nowAttr);
					else
						optionalList.push(nowAttr);
				}

				optionalCnt		= attrCount - mandatoryList.length;


				for (i = 0; i < mandatoryList.length; i++)
					setArrtTr(true, mandatoryList[i])

				
				for (i = 0; i < optionalCnt; i++)
					setArrtTr(false, optionalList[i])

								
				$('#optionNoti').show();
			}

		} else if(response.hasOwnProperty('message') == true){
			openDialogAlert(response.message);
		} else {
			openDialogAlert("카테고리 필수정보 수집 실패");
		}
	}
	
	function setAddress() {

		var setOutboundAddress	= function (addressList) {
			
			$('#outboundShippingPlaceCode > option').remove();
			$('#outboundShippingPlaceCode').append("<option value='AUTO'>출고지 정보 자동매칭</option>");
			
			for (cnt = addressList.length, i = 0; i < cnt; i++) {
				var nowVal		= addressList[i];
				if (nowVal.usable !== true)
					continue;

				outboundAddress[nowVal.outboundShippingPlaceCode]	= nowVal;

				var address		= nowVal.placeAddresses[0].returnAddress + ' ' + nowVal.placeAddresses[0].returnAddressDetail;
				var nowOption	= '<option value="' + nowVal.outboundShippingPlaceCode + '">' + nowVal.shippingPlaceName + ' - ' + address + '</option>';
				$('#outboundShippingPlaceCode').append(nowOption);
			}

			if(mode == 'renew' || mode == 'marketRenew') {
				$('#outboundShippingPlaceCode').val(addInfo.outboundShippingPlaceCode);
				$('#outboundShippingPlaceCode').trigger('change');
			}

		}

		var setReturnAddress	= function (addressList) {
			$('#returnCenterCode > option').remove();
			$('#returnCenterCode').append("<option value='AUTO'>반품지 정보 자동매칭</option>");

			for (cnt = addressList.length, i = 0; i < cnt; i++) {
				var nowVal		= addressList[i];
				var address		= nowVal.returnAddress + ' ' + nowVal.returnAddressDetail;
				var nowOption	= '<option value="' + nowVal.returnCenterCode + '">' + nowVal.returnChargeName + ' - ' + address + '</option>';
				$('#returnCenterCode').append(nowOption);
			}

			if(mode == 'renew' || mode == 'marketRenew') {
				$('#returnCenterCode').val(addInfo.returnCenterCode);
			}
		}

		var callBack	= function (response) {

			if (response.success != 'Y') {
				
				if(response.hasOwnProperty('message') == true)
					openDialogAlert(response.message);
				else
					openDialogAlert("주소 조회 실패");

				return;
			}

			var addressList		= response.resultData;

			if (addressList[0].hasOwnProperty('outboundShippingPlaceCode') == true)
				setOutboundAddress(addressList);
			else if (addressList[0].hasOwnProperty('returnCenterCode') == true)
				setReturnAddress(addressList);
		}

		callConnector('shippingAddress', callBack);
		callConnector('returnAddress', callBack);

	}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<?php if($TPL_VAR["displayMmode"]=='popup'){?>
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>
<?php if($TPL_VAR["mode"]!='marketRenew'){?>
				쿠팡 필수 정보
<?php }else{?>
				쿠팡 등록 필수 정보
<?php }?>
			</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<!--li><span class="helpicon" title=""></span></li-->
			<li>
				<span class="btn large black"><button onClick="addInfoSave();" id="addInfoActionBtn"></button></span>
			</li>
		</ul>

	</div>
</div>
<div class="pop_setting">
<?php }else{?>
<div class="title_top">필수 정보 <?php if($TPL_VAR["mode"]=='renew'||$TPL_VAR["mode"]=='marketRenew'){?>수정<?php }else{?>등록<?php }?></div>

<div class="contents_container">
<?php }?>
<!-- 페이지 타이틀 바 : 끝 -->

	<input type="hidden" name="displayMmode" id="displayMmode" value="<?php echo $TPL_VAR["displayMmode"]?>"/>
	<input type="hidden" name="market" id="market" value="<?php echo $TPL_VAR["market"]?>" toBeSaved="Y" required/>
	<input type="hidden" name="seller_id" id="seller_id" value='<?php echo $TPL_VAR["seller_id"]?>' toBeSaved="Y" required/>
	<input type="hidden" name="add_info_seq" id="add_info_seq" value='<?php echo $TPL_VAR["add_info_seq"]?>' toBeSaved="Y"/>
	<input type="hidden" name="fmMarketProduceSeq" id="fmMarketProduceSeq", value='<?php echo $TPL_VAR["fmMarketProduceSeq"]?>' toBeSaved="Y"/>


		<div class="item-title">템플릿</div>
		<table class="table_basic tdc" >
<?php if($TPL_VAR["mode"]!='marketRenew'){?>
			<colgroup>
				<col width="160" />
				<col width="" />
			</colgroup>
			
			<tr>
				<th>쿠팡 ID <span class="required_chk"/></th>
				<th>타이틀  <span class="required_chk"/></th>
			</tr>
			
			<tbody>
				<tr>
					<td><?php echo $TPL_VAR["seller_id"]?></td>
					<td>
						<input type="text" name="add_info_title" value="" maxlength="100" class="width-90per" toBeSaved="Y" required itemName='필수 정보 타이틀'/>
					</td>
				</tr>
			</tbody>
<?php }else{?>
			<input type="hidden" name="mode" value="marketRenew" toBeSaved="Y"/>
			<input type="hidden" class="_add_info_title" name="add_info_title" value="" toBeSaved="Y"/>

			<colgroup>
				<col width="160" />
				<col width="160" />
				<col width="" />
			</colgroup>
			<thead>
				<tr>
					<th>쿠팡 ID <span class="required_chk"/></th>
					<th>마켓 상품코드</th>
					<th>마켓 상품명</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $TPL_VAR["seller_id"]?></td>
					<td><?php echo $TPL_VAR["marketProductCode"]?></td>
					<td><?php echo $TPL_VAR["marketProductName"]?></td>
				</tr>
			</tbody>
<?php }?>

		</table>

		<div class="item-title">카테고리 정보<?php if($TPL_VAR["mode"]!='marketRenew'){?> - <span class="desc normal">매칭 카테고리 사용시 필수정보의 카테고리값은 무시됩니다</span><?php }?></div>
		<table class="table_basic">
			<colgroup>
				<col width="160" />
				<col width="*" />
				<col width="*" />
				<col width="*" />
				<col width="*" />
				<col width="*" />
			</colgroup>			
			<tr>
				<th>구분</th>
				<th>1차 카테고리</th>
				<th>2차 카테고리</th>
				<th>3차 카테고리</th>
				<th>4차 카테고리</th>
				<th>5차 카테고리</th>
				<th>6차 카테고리</th>
			</tr>			
			<tbody>
<?php if($TPL_VAR["mode"]!='marketRenew'){?>
				<tr>
					<th class="left">쿠팡 카테고리</th>
					<td>
						<select id="dep1_category_sel" class="width-90per" onChange="getCategory('dep2_category', this.value)"></select>
					</td>
					<td>
						<select id="dep2_category_sel" class="width-90per" onChange="getCategory('dep3_category', this.value)"></select>
					</td>
					<td>
						<select id="dep3_category_sel" class="width-90per" onChange="getCategory('dep4_category', this.value)"></select>
					</td>
					<td>
						<select id="dep4_category_sel" class="width-90per" onChange="getCategory('dep5_category', this.value)"></select>
					</td>
					<td>
						<select id="dep5_category_sel" class="width-90per" onChange="getCategory('dep6_category', this.value)"></select>
					</td>
					<td>
						<select id="dep6_category_sel" class="width-90per" onChange="sel_category('dep6_category', this.value)"></select>
					</td>
				</tr>
<?php }?>
				<tr>
					<th class="left">선택 카테고리 <span class="required_chk"/></th>
					<td>
						<input type="text" name="dep1_category_name" id="dep1_category_name" value="" class="width-90per" toBeSaved="Y" readonly>
						<input type="hidden" name="dep1_category_code" id="dep1_category_code" value="" toBeSaved="Y">
					</td>
					<td>
						<input type="text" name="dep2_category_name" id="dep2_category_name" value="" class="width-90per" toBeSaved="Y" readonly>
						<input type="hidden" name="dep2_category_code" id="dep2_category_code" value="" toBeSaved="Y">
					</td>
					<td>
						<input type="text" name="dep3_category_name" id="dep3_category_name" value="" class="width-90per" toBeSaved="Y" readonly>
						<input type="hidden" name="dep3_category_code" id="dep3_category_code" value="" toBeSaved="Y">
					</td>
					<td>
						<input type="text" name="dep4_category_name" id="dep4_category_name" value=""  class="width-90per" toBeSaved="Y" readonly>
						<input type="hidden" name="dep4_category_code" id="dep4_category_code" value="" toBeSaved="Y" saveType="text">
					</td>
					<td>
						<input type="text" name="dep5_category_name" id="dep5_category_name" value=""  class="width-90per" toBeSaved="Y" readonly>
						<input type="hidden" name="dep5_category_code" id="dep5_category_code" value="" toBeSaved="Y" saveType="text">
					</td>
					<td>
						<input type="text" name="dep6_category_name" id="dep6_category_name" value=""  class="width-90per" toBeSaved="Y" readonly>
						<input type="hidden" name="dep6_category_code" id="dep6_category_code" value="" toBeSaved="Y" saveType="text">
						<input type="hidden" name="category_code" id="category_code" value="" toBeSaved="Y" saveType="text" itemName="선택 카테고리" required>
					</td>
				</tr>
				<tr>
					<th class="left">사용가능 옵션정보</th>
					<td colspan="6">
						<table id="optionNoti" class="table_basic tdc hide">
							<colgroup>
								<col width="80" />
								<col width="170" />
								<col width="100" />
								<col width="100" />
								<col width="*" />
							</colgroup>
							<thead>
								<tr>
									<th>구분</th>
									<th>옵션명</th>
									<th>타입</th>
									<th>기본단위</th>
									<th>사용 가능한 단위</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
							<tfoot>
								<tr>
									<td colspan="5">
										※ <span class="blue">‘필수’</span> 항목이 내 쇼핑몰 상품의 필수옵션명과 동일하게 설정되어 있어야 정상적으로 쿠팡으로 전송됩니다.
									</td>
								</tr>
							</tfoot>
						</table>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="item-title">상품 필수정보</div>
		<table class="table_basic thl">
			
			<tbody>
				<tr>
					<th>승인요청 <span class="required_chk"/></th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="requested" value="FALSE" toBeSaved="Y" checked> 수동요청</label>
							<label><input type="radio" name="requested" value="TRUE" toBeSaved="Y"> 자동요청</label>
						</div>
					</td>					
				</tr>
				<tr>
					<th>판매기간 <span class="required_chk"/></th>
					<td>
						시작일 :
						<select name="saleStartSet" id="saleStartSet" toBeSaved="Y">
							<option value='TODAY'>즉시판매</option>
							<option value='SETDATE'>직접입력</option>
						</select>
						<input type="text" name="saleStartedAt" id="saleStartedAt" value="" class="saleStartSet datepicker" size="10" toBeSaved="Y" itemName="판매 시작일" readonly disabled> -

						종료일 :
						<select name="saleEndSet" id="saleEndSet" toBeSaved="Y">
							<option value='INFINITE'>영구판매</option>
							<option value='SETDATE'>직접입력</option>
						</select>
						<input type="text" name="saleEndedAt" id="saleEndedAt" value="" class="saleEndSet datepicker" size="10" toBeSaved="Y" itemName="판매 종료일" readonly disabled>
					</td>
				</tr>
				<tr>
					<th>A/S 전화번호 <span class="required_chk"/></th>
					<td>
						<input type="text" name="afterServiceContactNumber" id="afterServiceContactNumber" class="wx200" value="" toBeSaved="Y"  itemName="A/S전화번호" required/>
					</td>					
				</tr>
				<tr>
					<th>A/S 안내 <span class="required_chk"/></th>
					<td>
						<input type="text" name="afterServiceInformation" id="afterServiceInformation" class="wx200" value="" toBeSaved="Y"  itemName="A/S안내" required/>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="item-title">배송정보</div>
		<table class="table_basic thl">
			<colgroup>
				<col width="13%" />
				<col />
				<col width="13%" />
				<col />
				<col width="13%" />
				<col />
			</colgroup>
			<tbody>
				<tr>
					<th>출고지 선택 <span class="required_chk"/></th>
					<td colspan="3">
						<select name="outboundShippingPlaceCode" id="outboundShippingPlaceCode" class="width-80per" toBeSaved="Y"></select>
						<div class="resp_message v2">- 오픈마켓 관리자 > 출고지관리에 등록된 정보를 자동으로 불러와 표시합니다.</div>
					</td>
					<th>기준 출고일 <span class="required_chk"/></th>
					<td>
						<input type="text" name="outboundShippingTimeDay" id="outboundShippingTimeDay" class="onlynumber right" style="width:70px"  value="1" toBeSaved="Y"  itemName="기준 출고일" required/> (일)
					</td>
				</tr>
				<tr>
					<th>배송방법 <span class="required_chk"/></th>
					<td>
						<select name="deliveryMethod" id="deliveryMethod" class="width-90per" toBeSaved="Y">
							<option value='SEQUENCIAL'>순차배송</option>
							<option value='VENDOR_DIRECT'>업체직송</option>
							<option value='MAKE_ORDER'>주문제작</option>
							<option value='INSTRUCTURE'>설치배송</option>
							<option value='AGENT_BUY'>구매대행</option>
							<option value='COLD_FRESH'>신선냉동</option>
							<option value='MAKE_ORDER_DIRECT'>주문제작(업체직송)</option>
						</select>
					</td>
					<th>묶음 배송 <span class="required_chk"/></th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="unionDeliveryType" value="UNION_DELIVERY" toBeSaved="Y" checked> 가능</label>
							<label><input type="radio" name="unionDeliveryType" value="NOT_UNION_DELIVERY" toBeSaved="Y"> 불가능</label>
						</div>
					</td>
					<th>택배사 <span class="required_chk"/></th>
					<td>
						<select name="deliveryCompanyCode" id="deliveryCompanyCode" class="width-90per" toBeSaved="Y">
							<option value="AUTO">자동선택</option>
							<option value="CJGLS">CJ대한통운</option>
							<option value="EPOST">우체국</option>
							<option value="KGB">로젠택배</option>
							<option value="HANJIN">한진택배</option>
							<option value="HYUNDAI">롯데택배</option>
							<option value="COUPANG">쿠팡자체배송</option>
							<option value="KOREX">대한통운</option>
							<option value="LOGEN">로젠택배</option>
							<option value="KGBLS">KGB택배</option>
							<option value="KDEXP">경동택배</option>
							<option value="DONGBU">KG로지스</option>
							<option value="INNOGIS">GTX로지스</option>
							<option value="KYUNGDONG">경동택배</option>
							<option value="ILYANG">일양택배</option>
							<option value="CHUNIL">천일택배</option>
							<option value="AJOU">아주택배</option>
							<option value="CSLOGIS">SC로지스</option>
							<option value="DAESIN">대신택배</option>
							<option value="CVS">CVS택배</option>
							<option value="HDEXP">합동택배</option>
							<option value="DADREAM">다드림</option>
							<option value="DHL">DHL</option>
							<option value="UPS">UPS</option>
							<option value="FEDEX">FEDEX</option>
							<option value="REGISTPOST">우편등기</option>
							<option value="DIRECT">업체직송</option>
							<option value="IQS">굿스포스트</option>
							<option value="EMS">우체국 EMS</option>
							<option value="TNT">TNT</option>
							<option value="USPS">USPS</option>
							<option value="IPARCEL">i-parcel</option>
							<option value="GSMNTON">GSM NtoN</option>
							<option value="SWGEXP">성원글로벌</option>
							<option value="PANTOS">범한판토스</option>
							<option value="ACIEXPRESS">ACI Express</option>
							<option value="DAEWOON">대운글로벌</option>
							<option value="AIRBOY">에어보이익스프레스</option>
							<option value="KGLNET">KGL네트웍스</option>
							<option value="KUNYOUNG">건영택배</option>
							<option value="SLX">SLX택배</option>
							<option value="HONAM">호남택배</option>
							<option value="LINEEXPRESS">LineExpress</option>
							<option value="SFEXPRESS">순풍택배</option>
							<option value="TWOFASTEXP">2FastsExpress</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>배송비 종류 <span class="required_chk"/></th>
					<td>
						<select name="deliveryChargeType" id="deliveryChargeType" class="width-90per" toBeSaved="Y">
							<option value='FREE'>무료배송</option>
							<option value='FREE_DELIVERY_OVER_9800'>9800이상 무료배송</option>
							<option value='FREE_DELIVERY_OVER_19800'>19800이상 무료배송</option>
							<option value='FREE_DELIVERY_OVER_30000'>30000이상 무료배송</option>
							<option value='NOT_FREE'>유료배송</option>
							<option value='CHARGE_RECEIVED'>착불배송</option>
							<option value='CONDITIONAL_FREE'>조건부 무료배송</option>
						</select>
					</td>
					<th>기본 배송비</th>
					<td>
						<input type="text" name="deliveryCharge" id="deliveryCharge" class="deliveryChargeType onlynumber right wx150"  value="" toBeSaved="Y"  itemName="배송비" disabled/>
					</td>
					<td colspan="2">
						<div class="resp_radio">
							<label><input type="radio" name="remoteAreaDeliverable" value="Y" toBeSaved="Y" checked> 도서산간 배송</label>
							<label><input type="radio" name="remoteAreaDeliverable" value="N" toBeSaved="Y"> 도서산간 배송안함</label>
						</div>
					</td>
				</tr>
				<tr>
					<th>무료배송 조건금액 <span class="required_chk"/></th>
					<td >
						<input type="text" name="freeShipOverAmount" id="freeShipOverAmount" class="onlynumber right wx150"  value="0" toBeSaved="Y"  itemName="초도 반품 배송비" readonly/>
						<div class="resp_message v2">- 최소 금액은 100원이며, 100원 단위로 입력해주셔야 합니다.</div>
					</td>
					<th>초도 반품 배송비 <span class="required_chk"/></th>
					<td>
						<input type="text" name="deliveryChargeOnReturn" id="deliveryChargeOnReturn" class="onlynumber right wx150"  value="0" toBeSaved="Y"  itemName="초도 반품 배송비"/> (편도)
					</td>
					<td colspan="2">

					</td>
				</tr>
			</tbody>
		</table>

		<div class="item-title">반품정보</div>
		<table class="table_basic thl">		
			<tbody>
				<tr>
					<th>반품배송지 선택 <span class="required_chk"/></th>
					<td>
						<select name="returnCenterCode" id="returnCenterCode" class="width-95per" toBeSaved="Y"></select>
						<div class="resp_message v2">- 오픈마켓 관리자 > 반품지관리에 등록된 정보를 자동으로 불러와 표시합니다.</div>
					</td>					
				</tr>
				<tr>
					<th>반품 배송비 <span class="required_chk"/></th>
					<td>
						<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
						<input type="text" name="returnCharge" id="returnCharge" class="onlynumber right wx150"  value="" size="10" toBeSaved="Y"  itemName="반품 배송비"/> 원
					</td>
				</tr>
				<tr>
					<th>착불여부 <span class="required_chk"/></th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="returnChargeVendor" value="N" toBeSaved="Y" checked> 선불</label>
							<label><input type="radio" name="returnChargeVendor" value="Y" toBeSaved="Y"> 착불</label>
						</div>
					</td>	
				</tr>
			</tbody>
		</table>
	
<?php if($TPL_VAR["displayMmode"]!='popup'){?>	
		<div class="footer">
			<button onClick="addInfoSave();" id="addInfoActionBtn" class="resp_btn active size_XL"></button>
			<button onclick="moveMenu('./market_setting?market=<?php echo $TPL_VAR["market"]?>&sellerId=<?php echo $TPL_VAR["seller_id"]?>&pageMode=AddInfoListSet')" class="resp_btn v3 size_XL">취소</button>
		</div>
<?php }?>
	
</div>
<?php if($TPL_VAR["displayMmode"]=='popup'){?><?php $this->print_("layout_footer",$TPL_SCP,1);?><?php }?>