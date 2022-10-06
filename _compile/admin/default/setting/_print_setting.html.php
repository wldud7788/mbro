<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/setting/_print_setting.html 000005785 */ ?>
<form action="../setting_process/print_setting" method="post" enctype="multipart/form-data" target="actionFrame">
	<span class="fx12 black">1. 주문내역서에 주문번호를 바코드로 출력하시겠습니까?</span><br />
	<span class="fx11 gray">주문 검색창에서 바코드를 스캔하면 해당 주문건의 출고화면으로 바로 이동하여 출고처리가 편리해집니다.</span><br />
	<label><input type="radio" name="orderPrintOrderBarcode" value="1" <?php if($TPL_VAR["orderPrintOrderBarcode"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="orderPrintOrderBarcode" value="" <?php if(!$TPL_VAR["orderPrintOrderBarcode"]){?>checked<?php }?> /> 아니오</label><br />
	<br />
	<span class="fx12 black">2. 주문내역서에 주문상품의 상품코드를 출력하시겠습니까?</span><br />
	<label><input type="radio" name="orderPrintGoodsCode" value="1" <?php if($TPL_VAR["orderPrintGoodsCode"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="orderPrintGoodsCode" value="" <?php if(!$TPL_VAR["orderPrintGoodsCode"]){?>checked<?php }?> /> 아니오</label><br />
	<br />
	<span class="fx12 black">3. 주문내역서에 주문상품의 상품코드를 바코드로 출력하시겠습니까?</span><br />
	<span class="fx11 gray">해당 주문의 출고처리화면에서 실제 상품의 바코드를 스캔하면 주문상품이 맞는지 검증하여 <br />
	오배송 없이 정확하게 출고가 가능합니다. 해당 상품의 바코드를 계속 스캔하면 출고수량이 +1씩 증가합니다.</span><br />
	<label><input type="radio" name="orderPrintGoodsBarcode" value="1" <?php if($TPL_VAR["orderPrintGoodsBarcode"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="orderPrintGoodsBarcode" value="" <?php if(!$TPL_VAR["orderPrintGoodsBarcode"]){?>checked<?php }?> /> 아니오</label><br /><br />
	<span class="fx12 black">4. 주문내역서에 주문상품의 이미지를 출력하시겠습니까?</span><br />
	<label><input type="radio" name="orderPrintGoodsImage" value="1" <?php if($TPL_VAR["orderPrintGoodsImage"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="orderPrintGoodsImage" value="" <?php if(!$TPL_VAR["orderPrintGoodsImage"]){?>checked<?php }?> /> 아니오</label><br /><br />
	<span class="fx12 black">5. 출고내역서에 출고번호를 바코드로 출력하시겠습니까?</span><br />
	<span class="fx11 gray">출고 검색창에서 바코드를 스캔하면 해당 출고건의 출고화면으로 바로 이동하여 출고처리가 편리해집니다.</span><br />
	<label><input type="radio" name="exportPrintExportcodeBarcode" value="1" <?php if($TPL_VAR["exportPrintExportcodeBarcode"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="exportPrintExportcodeBarcode" value="" <?php if(!$TPL_VAR["exportPrintExportcodeBarcode"]){?>checked<?php }?> /> 아니오</label><br />
	<br />
	<span class="fx12 black">6. 출고내역서에 출고상품의 상품코드를 출력하시겠습니까?</span><br />
	<label><input type="radio" name="exportPrintGoodsCode" value="1" <?php if($TPL_VAR["exportPrintGoodsCode"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="exportPrintGoodsCode" value="" <?php if(!$TPL_VAR["exportPrintGoodsCode"]){?>checked<?php }?> /> 아니오</label><br />
	<br />
	<span class="fx12 black">7. 출고내역서에 출고상품의 상품코드를 바코드로 출력하시겠습니까?</span><br />
	<span class="fx11 gray">해당 출고의 출고처리화면에서 실제 상품의 바코드를 스캔하면 출고상품이 맞는지 검증하여 <br />
	오배송 없이 정확하게 출고가 가능합니다. 해당 상품의 바코드를 계속 스캔하면 출고수량이 +1씩 증가합니다.</span><br />
	<label><input type="radio" name="exportPrintGoodsBarcode" value="1" <?php if($TPL_VAR["exportPrintGoodsBarcode"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="exportPrintGoodsBarcode" value="" <?php if(!$TPL_VAR["exportPrintGoodsBarcode"]){?>checked<?php }?> /> 아니오</label><br /><br />
	<span class="fx12 black">8. 출고내역서에 주문상품의 이미지를 출력하시겠습니까?</span><br />
	<label><input type="radio" name="exportPrintGoodsImage" value="1" <?php if($TPL_VAR["exportPrintGoodsImage"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="exportPrintGoodsImage" value="" <?php if(!$TPL_VAR["exportPrintGoodsImage"]){?>checked<?php }?> /> 아니오</label><br /><br />
	<span class="fx12 black">9. 내역서 타이틀 우측에 로고 또는 타이틀 삽입</span><br />
	<label>
		<input type="radio" name="shopLogoType" value="text" <?php if($TPL_VAR["config_system"]["shopLogoType"]=='text'){?>checked<?php }?> />
		<input name="shopLogoText" type="text" value="<?php echo $TPL_VAR["config_system"]["shopLogoText"]?>" />
		<span class="desc">예시) 퍼스트몰</span>
	</label><br />
	<label>
		<input type="radio" name="shopLogoType" value="img" <?php if($TPL_VAR["config_system"]["shopLogoType"]=='img'){?>checked<?php }?> />
<?php if($TPL_VAR["config_system"]["shopLogoImg"]){?>
		<img src="<?php echo $TPL_VAR["config_system"]["shopLogoImg"]?>" border="0" style="max-width:50px;max-height:50px;"><br/>
<?php }?>
		<input type="file" name="shopLogoImg" style="letter-spacing:-1px !important" />
	</label><br /><br />

	<div class="center">
		<span class="btn large cyanblue"><input type="submit" value="저장" /></span>
	</div>
</form>