<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/partner/naverpay2.1_item.html 000005283 */ 
$TPL_result_1=empty($TPL_VAR["result"])||!is_array($TPL_VAR["result"])?0:count($TPL_VAR["result"]);?>
<products>
<?php if($TPL_result_1){foreach($TPL_VAR["result"] as $TPL_V1){?>
	<product>
		<id><?php echo $TPL_V1["goods_seq"]?></id>
		<merchantProductId><?php echo $TPL_V1["goods_seq"]?></merchantProductId>
		<ecMallProductId><?php echo $TPL_V1["goods_seq"]?></ecMallProductId>
		<name><![CDATA[<?php echo $TPL_V1["goods_name"]?>]]></name>
		<basePrice><?php echo $TPL_V1["base_price"]?></basePrice>
		<taxType><?php echo $TPL_V1["taxtype"]?></taxType>
		<infoUrl><![CDATA[http://<?php echo $_SERVER["HTTP_HOST"]?>/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>]]></infoUrl>
		<imageUrl><![CDATA[<?php echo $TPL_V1["viewimg"]?>]]></imageUrl>
		<giftName><![CDATA[]]></giftName>
		<stockQuantity><?php echo $TPL_V1["tot_stock"]?></stockQuantity>
		<status><?php echo $TPL_V1["status"]?></status>
		<optionSupport><?php if($TPL_V1["optionSupport"]){?>true<?php }else{?>false<?php }?></optionSupport>
		<supplementSupport><?php if($TPL_V1["supplementSupport"]){?>true<?php }else{?>false<?php }?></supplementSupport>
<?php if($TPL_V1["returnShippingFee"]){?><returnShippingFee></returnShippingFee><?php }?>
<?php if($TPL_V1["exchangeShippingFee"]){?><exchangeShippingFee></exchangeShippingFee><?php }?>
		<returnInfo>
			<zipcode><?php echo $TPL_V1["shipping"]['return_zipcode']?></zipcode>
			<address1><![CDATA[<?php echo $TPL_V1["shipping"]['return_address1']?>]]></address1>
			<address2><![CDATA[<?php echo $TPL_V1["shipping"]['return_address2']?>]]></address2>
			<sellername><![CDATA[<?php echo $TPL_V1["shipping"]['return_sellername']?>]]></sellername>
			<contact1><![CDATA[<?php echo $TPL_V1["shipping"]['return_contact1']?>]]></contact1>
			<contact2><![CDATA[<?php echo $TPL_V1["shipping"]['return_contact2']?>]]></contact2>
		</returnInfo>
<?php if($TPL_V1["optionSupport"]){?>
		<option>
			<!-- 전체 옵션 -->
<?php if(is_array($TPL_R2=$TPL_V1["all_options"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
<?php if(is_array($TPL_R3=$TPL_V2)&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
			<optionItem>
				<type><?php echo $TPL_K2?></type>
				<name><![CDATA[<?php echo $TPL_K3?>]]></name>
<?php if(is_array($TPL_R4=$TPL_V3)&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
				<value>
					<id><?php echo $TPL_V4["id"]?></id>
					<text><![CDATA[<?php echo $TPL_V4["text"]?>]]></text>
					<status><![CDATA[<?php echo $TPL_V4["status"]?>]]></status>
				</value>
<?php }}?>
			</optionItem>
<?php }}?>
<?php }}?>
			<!-- optionManageCodes로 필터링 옵션 -->
<?php if(is_array($TPL_R2=$TPL_V1["sel_options"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
			<combination>
				<manageCode><?php echo $TPL_K2?></manageCode>
				<stockQuantity><?php echo $TPL_V2["stock"]?></stockQuantity>
				<status><?php echo $TPL_V2["status"]?></status>
				<price><?php echo $TPL_V2["price"]?></price>
<?php if(is_array($TPL_R3=$TPL_V2["options"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
				<options>
					<name><![CDATA[<?php echo $TPL_V3["name"]?>]]></name>
					<id><?php echo $TPL_V3["id"]?></id>
				</options>
<?php }}?>
<?php if(is_array($TPL_R3=$TPL_V2["input"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
				<options>
					<name><![CDATA[<?php echo $TPL_V3["name"]?>]]></name>
					<id><?php echo $TPL_V3["id"]?></id>
				</options>
<?php }}?>
			</combination>
<?php }}?>
		</option>
<?php }?>
<?php if($TPL_V1["supplementSupport"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["suboptions"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
		<supplement>
			<id><?php echo $TPL_V2["id"]?></id>
			<name><![CDATA[<?php echo $TPL_V2["name"]?>]]></name>
			<price><?php echo $TPL_V2["price"]?></price>
			<stockQuantity><?php echo $TPL_V2["stock"]?></stockQuantity>
			<status><?php echo $TPL_V2["status"]?></status>
		</supplement>
<?php }}?>
<?php }?>
		<shippingPolicy>
<?php if($TPL_V1["shipping"]['shipping_type']=="CHARGE_BY_QUANTITY"){?>
			<chargeByQuantity>
				<type><?php echo $TPL_V1["shipping"]['chargebyquantity']['type']?></type>
				<repeatQuantity><?php echo $TPL_V1["shipping"]['chargebyquantity']['repeatQuantity']?></repeatQuantity>
			</chargeByQuantity>
<?php }?>
<?php if($TPL_V1["shipping"]['conditionalFree']||$TPL_V1["shipping"]['shipping_type']=='CONDITIONAL_FREE'){?>
			<conditionalFree>
				<basePrice><?php echo $TPL_V1["shipping"]['basic_price']?></basePrice>
			</conditionalFree>
<?php }?>
			<feePayType><?php echo $TPL_V1["shipping"]['shipping_paytype']?></feePayType>
			<feePrice><?php echo $TPL_V1["shipping"]['shipping_price']?></feePrice>
			<feeType><?php echo $TPL_V1["shipping"]['shipping_type']?></feeType>
			<groupId><?php echo $TPL_V1["shipping"]['shipping_group']?></groupId>
			<method><?php echo $TPL_V1["shipping"]['shipping_method']?></method>
<?php if($TPL_V1["shipping"]['apiSupport']=='true'){?>
			<surchargeByArea>
				<apiSupport>true</apiSupport>
			</surchargeByArea>
<?php }?>
		</shippingPolicy>
	</product>
<?php }}?>
</products>