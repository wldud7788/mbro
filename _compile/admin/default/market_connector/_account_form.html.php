<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/market_connector/_account_form.html 000009018 */ ?>
<script type="text/javascript" src="/app/javascript/js/admin-connectorSetting.js?dummy=<?php echo date('YmdHis')?>"></script>
<script>
	var marketObj		= <?php echo $TPL_VAR["marketsObj"]?>;
	var goodsPriceSet	= <?php echo $TPL_VAR["goodsPriceSet"]?>;
	var goodsStockSet	= <?php echo $TPL_VAR["goodsStockSet"]?>;

	console.log(<?php echo $TPL_VAR["market"]?>)

	//객체동결(변경금지)
	Object.freeze(marketObj);
	Object.freeze(goodsPriceSet);
	Object.freeze(goodsStockSet);
</script>
<style>
.ui-widget-content {border:0;}
</style>
<div id="dumy" style="display:none"></div>
<?php if($TPL_VAR["mode"]=='renew'){?>
<div class="title_top">계정 수정</div>

<div class="contents_container">
<div class="title_dvs">
	<div class="item-title">계정 수정</div>
	<button type="button" id="accountDeleteBtn" class="resp_btn v3"> 계정 삭제</button>
</div>
<?php }?>

<form id="accountForm" method="post">
	<input type="hidden" name="mode" id="mode" value="<?php echo $TPL_VAR["mode"]?>"/>
	<input type="hidden" name="market" id="market" value="<?php echo $TPL_VAR["market"]?>"/>
	
	<table class="table_basic thl <?php if($TPL_VAR["mode"]!='renew'){?>bdrt0<?php }?>">	
<?php if($TPL_VAR["mode"]=='renew'){?>
		<tr>
			<th>사용 설정</th>
			<td>	
				<div class="btn-onoff">			
				<button type="button" class="on btn-on" id="accountOnOff" value="off">버튼</button>	
				</div>	
			</td>
		</tr>

		<tr>
			<th>마켓 정보</th>
			<td>
<?php if($TPL_VAR["market"]=='storefarm'){?>
				스마트스토어
<?php }elseif($TPL_VAR["market"]=='coupang'){?>
				쿠팡
<?php }else{?>	
				11번가
<?php }?>	
			</td>
		</tr>

		<tr>
			<th>				
<?php if($TPL_VAR["market"]=='storefarm'){?>
				API 연동용 판매자 ID
<?php }else{?>
				판매자 ID
<?php }?>	
			</th>
			<td>								
				<span class="bold"><?php echo $TPL_VAR["accountInfo"]["sellerId"]?></span>
				<input type="hidden" name="sellerId" id="sellerId" value="<?php echo $TPL_VAR["accountInfo"]["sellerId"]?>"/>				
			</td>
		</tr>
<?php }else{?>
		<tr>
			<th>				
<?php if($TPL_VAR["market"]=='storefarm'){?>
				API 연동용 판매자 ID
<?php }else{?>
				판매자 ID
<?php }?>				
			</th>
			<td><input type="text" name="sellerId" id="sellerId" value=""/></td>
		</tr>
<?php }?>

<?php if($TPL_VAR["market"]=='coupang'){?>
		<!--쿠팡 인증정보 -->
		<tr>
			<th>업체 코드</th>
			<td><input type="text" name="marketAuthInfo[accessId]" class="authInfo" authLable="accessId" value="<?php echo $TPL_VAR["accountInfo"]["marketAuthInfo"]["accessId"]?>"/></td>
		</tr>
		<tr>
			<th>Access Key</th>
			<td><input type="text" name="marketAuthInfo[accessKey]" class="authInfo" authLable="accessKey" value="<?php echo $TPL_VAR["accountInfo"]["marketAuthInfo"]["accessKey"]?>" style="width:240px"/></td>
		</tr>
		<tr>
			<th>Secret Key</th>
			<td><input type="password" name="marketAuthInfo[secretKey]" class="authInfo" authLable="secretKey" value="<?php echo $TPL_VAR["accountInfo"]["marketAuthInfo"]["secretKey"]?>" style="width:240px"/></td>
		</tr>
		<!--쿠팡 인증정보 -->	

<?php }elseif($TPL_VAR["market"]=='open11st'){?>
		<!--11번가 인증정보 -->
		<tr>
			<th>11ST OPEN API KEY</th>
			<td>
				<input type="password" name="marketAuthInfo[apiKey]" class="authInfo" authLable="apiKey" value="<?php echo $TPL_VAR["accountInfo"]["marketAuthInfo"]["apiKey"]?>" style="width:240px"/>
			</td>
		</tr>
		<!--11번가 인증정보 -->
		
<?php }elseif($TPL_VAR["market"]=='storefarm'){?>
		<!--스토어팜 인증정보 -->
		<tr>
			<th>스마트스토어 API ID</th>
			<td>
				<input type="text" name="marketAuthInfo[ApiId]" class="authInfo" authLable="ApiId" value="<?php echo $TPL_VAR["accountInfo"]["marketAuthInfo"]["ApiId"]?>" style="width:240px"/>
				<input type="hidden" name="marketAuthInfo[SellerId]" class="authInfo" authLable="SellerId" value="<?php echo $TPL_VAR["accountInfo"]["marketAuthInfo"]["SellerId"]?>" style="width:240px"/>
			</td>
		</tr>

		<tr>
			<th>스마트스토어 URL</th>
			<td>
				http://sell.smartstore.naver.com/ <input type="text" name="marketOtherInfo[storefarmUrl]" class="otherInfo" authLable="storefarmUrl"	value="<?php echo $TPL_VAR["accountInfo"]["marketOtherInfo"]["storefarmUrl"]?>" style="width:85px"/>
			</td>
		</tr>
		<!--스토어팜 인증정보 -->
<?php }?>
	</table>
	
	<div class="resp_message">
		- 
<?php if($TPL_VAR["market"]=='storefarm'){?>
		스마트 스토어 인증 API ID 발급 방법 
		<a href="https://www.firstmall.kr/customer/faq/1200" class="resp_btn_txt" target="_blank">자세히 보기</a>
<?php }elseif($TPL_VAR["market"]=='coupang'){?>
		쿠팡 연동 방법 
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/market_connector', '#tip2')"></span>
<?php }else{?>
		11번가 11ST OPEN API KEY 발급 방법 
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/market_connector', '#tip1', 'sizeM')"></span>
<?php }?>		
		
	</div>
	
	<div class="item-title">판매 가격 설정</div>

	<table class="table_basic thl">		
		<tr>
			<th>판매 가격</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="goodsPriceSet[adjustment][use]" class="goodsPriceSetAdjustmentUse variableCheck" value="N" checked/> 판매가격 동일</label>
					<label>
						<input type="radio" name="goodsPriceSet[adjustment][use]" class="goodsPriceSetAdjustmentUse variableCheck" value="Y"/>
						판매 가격에
						<input type="text" name="goodsPriceSet[adjustment][value]" value="" style="width:50px" />
						<span class="">
							<select name="goodsPriceSet[adjustment][unit]" class="priceAdjustmentUse" >
								<option value="PER"> % </option>
								<option value="CUR"> 원 </option>
							</select>
							<select name="goodsPriceSet[adjustment][type]" class="priceAdjustmentUse" >
								<option value="PLUS"> + 조정 </option>
								<option value="MINUS"> - 조정 </option>
							</select>
						</span>
					
					</label>
				</div>
			</td>
		</tr>
		
		<tr class="goodsPriceSet_Y hide">
			<th>금액 절사</th>
			<td>
				<label class="resp_checkbox">
					<input type="checkbox" name="goodsPriceSet[cutting][use]" id="goodsPriceSetCuttingUse" class="priceAdjustmentUse" value="Y" />
					금액의
					<select name="goodsPriceSet[cutting][unit]" class="priceCuttingUse" disabled>
						<option value="10"> 일원 단위 </option>
						<option value="100"> 십원 단위 </option>
						<option value="1000"> 백원 단위 </option>
					</select>
					단위에서
					<select name="goodsPriceSet[cutting][type]" class="priceCuttingUse" disabled>
						<option value="DOWN"> 버림 </option>
						<option value="UP"> 올림 </option>
						<option value="ROUND"> 반올림 </option>
					</select>					
				</label>
			</td>
		</tr>
	</table>

	<!-- 재고수량 설정 -->
	<div class="item-title">재고 설정</div>

	<table class="table_basic thl">		
		<tr>
			<th>재고 수량</th>
			<td>
				<div class="resp_radio">
					<label>
						<input type="radio" name="goodsStockSet[adjustment][use]" class="goodsStockSetAdjustmentUse variableCheck" value="N" checked/>
						재고 수량 동일
					</label>
					<label>
						<input type="radio" name="goodsStockSet[adjustment][use]" class="goodsStockSetAdjustmentUse number" value="Y"/>						
						<input type="text" name="goodsStockSet[adjustment][value]" value="" style="width:50px" />
						개
					</label>
				</div>
			</td>
		</tr>
	</table>
	<!-- //재고수량 설정 -->

	

	<div class="footer">		
		<input type="hidden" name="accountUse" id="accountUseYn" value="<?php if($TPL_VAR["accountInfo"]["accountUse"]=='N'){?>N<?php }else{?>Y<?php }?>"/>
		<!-- //사용 설정 -->
		
<?php if($TPL_VAR["mode"]=='renew'){?>
		<button type="button" id="accountSetBtn" class="resp_btn active size_XL">수정</button>
<?php }else{?>
		<button type="button" id="accountSetBtn" class="resp_btn active size_XL">등록</button>
		<button type="button" onClick="self.close();" class="resp_btn v3 size_XL">닫기</button>
<?php }?>
		
<?php if($TPL_VAR["mode"]=='renew'){?>
		<br/>
		<textarea readonly style="width:99.5%; height:100px; margin-top:20px;">
<?php if(is_array($TPL_R1=$TPL_VAR["accountInfo"]["accountLog"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
[<?php echo $TPL_V1["logTime"]?>]
<?php echo $TPL_V1["log"]?>

===============================================================
<?php }}?>
		</textarea>
<?php }?>

	</div>
</form>
<?php if($TPL_VAR["mode"]=='renew'){?>
</div>
<?php }?>

<div id="marketAuthHelper" class="hide">
	<div class="helperLay" id="helperLayContent"></div>
</div>