<?php /* Template_ 2.2.6 2022/05/17 12:37:16 /www/music_brother_firstmall_kr/admin/skin/default/statistic_sales/_sales_menu.html 000002028 */ ?>
<div class="slc-head pdt5">
<ul>
	<li><span class="mitem"><a href="sales_sales">매출액</a></span></li>
<?php if(serviceLimit('H_FR')){?>
		<li><span class="mitem"><a href="#" onclick="<?php echo serviceLimit('A1')?>">상품</a></span></li>
		<li><span class="mitem"><a href="#" onclick="<?php echo serviceLimit('A1')?>">유입경로</a></span></li>
		<li><span class="mitem"><a href="#" onclick="<?php echo serviceLimit('A1')?>">카테고리/브랜드</a></span></li>
		<li><span class="mitem"><a href="#" onclick="<?php echo serviceLimit('A1')?>">환경</a></span></li>
		<li><span class="mitem"><a href="#" onclick="<?php echo serviceLimit('A1')?>">수단</a></span></li>
		<li><span class="mitem"><a href="#" onclick="<?php echo serviceLimit('A1')?>">성별/연령/지역</a></span></li>
		<li><span class="mitem"><a href="#" onclick="<?php echo serviceLimit('A1')?>">매장별 매출</a></span></li>
<?php }else{?>
		<li><span class="mitem"><a href="sales_goods">상품</a></span></li>
		<li><span class="mitem"><a href="sales_referer">유입경로</a></span></li>
		<li><span class="mitem"><a href="sales_category">카테고리/브랜드</a></span></li>
		<li><span class="mitem"><a href="sales_platform">환경</a></span></li>
		<li><span class="mitem"><a href="sales_payment">결제수단</a></span></li>
		<li><span class="mitem"><a href="sales_etc">성별/연령/지역</a></span></li>
<?php if(serviceLimit('H_AD')){?>
		<li><span class="mitem"><a href="sales_seller">입점사별</a></span></li>
<?php }?>
<?php if($TPL_VAR["checkO2OService"]){?>
<?php $this->print_("o2o_statistic_sales_menu",$TPL_SCP,1);?>

<?php }?>
<?php }?>

</ul>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("div.slc-head a[href='<?php echo $TPL_VAR["selected_sales_menu"]?>']").parent().parent().addClass("selected");
});
</script>