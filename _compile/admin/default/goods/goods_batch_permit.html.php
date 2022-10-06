<?php /* Template_ 2.2.6 2022/05/17 12:31:49 /www/music_brother_firstmall_kr/admin/skin/default/goods/goods_batch_permit.html 000002954 */ 
$TPL_digit_goods_1=empty($TPL_VAR["digit_goods"])||!is_array($TPL_VAR["digit_goods"])?0:count($TPL_VAR["digit_goods"]);
$TPL_digit_sale_1=empty($TPL_VAR["digit_sale"])||!is_array($TPL_VAR["digit_sale"])?0:count($TPL_VAR["digit_sale"]);?>
<script type="text/javascript">
function digit_sale_pop(){
	openDialog("매입상품 내역", "digit_sale", {"width":"300","height":"200","show" : "fade","hide" : "fade"});
}
function digit_goods_pop(){	
	openDialog("입점사상품 내역", "digit_goods", {"width":"300","height":"200","show" : "fade","hide" : "fade"});
}
</script>
<div id="body_contants">
<?php if($TPL_VAR["warning"]){?>
	<div style="width:100%;text-align:center;margin-top:20px;margin-bottom:20px;">
		<div style="margin-bottom:20px;"><?php echo $TPL_VAR["warning"]?></div>
	</div>
<?php }?>
<?php if($TPL_VAR["digit_goods"]){?>
	<div style="width:100%;text-align:center;margin-top:20px;margin-bottom:20px;">
		<div style="margin-bottom:20px;">일부 상품의  정산금액이 판매가보다 많습니다.</div>
		<span class="btn large gray"><button type="button" onclick="digit_goods_pop();">상품확인</button></span>
	</div>
<?php }?>

<?php if($TPL_VAR["digit_sale"]){?>
	<div style="width:100%;text-align:center;margin-top:20px;margin-bottom:20px;">
		<div style="margin-bottom:20px;">일부 상품의  매입금액이 판매가보다 많습니다.</div>
		<span class="btn large gray"><button type="button" onclick="digit_sale_pop();">상품확인</button></span>
	</div>
<?php }?>

	<div style="width:100%;text-align:center;margin-top:10px;">
		상품정보를 일괄 업데이트하겠습니까?<br/>변경된 데이터는 복구 되지 않습니다!
	</div>
	<div style="width:100%;text-align:center;margin-top:20px;">
		<span class="btn large cyanblue"><button type="button" onclick="closeDialog('goods_permit_lay');batch_goods_save_submit();"> 확인 </button></span>
		<span class="btn large black"><button type="button" onclick="closeDialog('goods_permit_lay');"> 취소 </button></span>
	</div>
</div>

<?php if($TPL_VAR["digit_goods"]){?>
<div id="digit_goods" class="hide">
	<table class="info-table-style" style="width:99%">
	<tr><th class="its-th-align center">상품명</th><tr>
<?php if($TPL_digit_goods_1){foreach($TPL_VAR["digit_goods"] as $TPL_V1){?>
	<tr><td class="its-td-align center"><?php echo $TPL_V1?></td></tr>
<?php }}?>
	</table>
</div>
<?php }?>

<?php if($TPL_VAR["digit_sale"]){?>
<div id="digit_sale" class="hide">
	<table class="info-table-style" style="width:99%">
	<tr><th class="its-th-align center">상품명</th><tr>
<?php if($TPL_digit_sale_1){foreach($TPL_VAR["digit_sale"] as $TPL_V1){?>
	<tr><td class="its-td-align center"><?php echo $TPL_V1?></td></tr>
<?php }}?>
	</table>
</div>
<?php }?>