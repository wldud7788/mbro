<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/order/_optional_changes.html 000003312 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 옵션/수량 변경 @@
- 파일위치 : [스킨폴더]/order/_optional_changes.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript" src="/app/javascript/plugin/jquery_selectbox/js/jquery.selectbox-0.2.js"></script>
<link href="/app/javascript/plugin/jquery_selectbox/css/jquery.selectbox.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
<?php if($TPL_VAR["goods"]["price"]){?>
	gl_goods_price = <?php echo $TPL_VAR["goods"]["price"]?>;
<?php }?>
<?php if($TPL_VAR["goods"]["price"]>$TPL_VAR["goods"]["sale_price"]){?>
	gl_goods_price = <?php echo $TPL_VAR["goods"]["sale_price"]?>;
<?php }?>
	$(document).ready(function(){
		$('button#change_cart').bind('click', function(){
<?php if($_GET['mode']=="tmp"){?>
			var data = $('form#optional_changes_form').serialize();
			cart_tmp('<?php echo $TPL_VAR["cart_table"]?>','tmp',data,'<?php echo $_GET["tmp_cart"]?>','<?php echo $TPL_VAR["goods"]["goods_seq"]?>');
<?php }else{?>
			$('form#optional_changes_form').submit();
<?php }?>
		});
	});
</script>
<form name="optional_changes_form" id="optional_changes_form" method="post" enctype="multipart/form-data" action="/order/optional_modify" target="actionFrame">
<input type='hidden' name='mode'		value='<?php echo $_GET["mode"]?>'>
<?php if($_GET["tmp_cart"]){?><input type='hidden' name='tmp_cart'		value='<?php echo $_GET["tmp_cart"]?>'><?php }?>
<?php if($_GET["old_option_seq"]){?> <!--재매칭 수량 체크용-->
<input type='hidden' name='old_option_seq'		value='<?php echo $_GET["old_option_seq"]?>'>
<?php }?>
<input type='hidden' name='cart_option_seq' value='<?php echo $TPL_VAR["cart_options"][ 0]["cart_option_seq"]?>'>
<?php if($TPL_VAR["cart_table"]){?>
<input type='hidden' name='cart_table' value='<?php echo $TPL_VAR["cart_table"]?>'>
<?php }?>
<input type="hidden" name="hop_select_date" value="<?php echo $TPL_VAR["cart"]["shipping_hop_date"]?>" />
<input type="hidden" name="shipping_prepay_info" value="<?php echo $TPL_VAR["cart"]["shipping_prepay_info"]?>" />
<input type="hidden" name="shipping_store_seq" value="<?php echo $TPL_VAR["cart"]["shipping_store_seq"]?>" />

<ul class="resp_content2">
	<li><a href="/goods/view?no=<?php echo $TPL_VAR["goods"]["goods_seq"]?>" target="_blank" title="새창"><img src="<?php echo $TPL_VAR["goods"]["image"]?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl/images/common/noimage.gif'" alt="" style="max-width:80px; border:1px #eee solid;" /></a></li>
	<li><span class="Fs14 gray_01"><?php echo $TPL_VAR["goods"]["goods_name"]?></span></li>
</ul>

<?php $this->print_("OPTION_SELECT",$TPL_SCP,1);?>


<div class="layer_bottom_btn_area v2">
	<ul class="basic_btn_area2 v2">
		<li class="Pt5">총 금액 : <?php echo get_currency_price($TPL_VAR["goods"]["price"], 2,'','<span id="total_goods_price" class="pointcolor">_str_price_</span>','Fs15')?></li>
		<li style="width:45%;"><button type="button" id="change_cart" class="btn_resp size_c color2">변경하기</button></li>
	</ul>
</div>
</form>