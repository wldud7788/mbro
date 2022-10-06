<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/_modules/display/coupon_display_detail_light.html 000002352 */ 
$TPL_couponloop_1=empty($TPL_VAR["couponloop"])||!is_array($TPL_VAR["couponloop"])?0:count($TPL_VAR["couponloop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ [반응형] 쿠폰 템플릿 @@
- 파일위치 : [스킨폴더]/_modules/display/coupon_display_detail_light.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_VAR["couponloop"]){?>
<ul class="resp_coupon_list">
<?php if($TPL_couponloop_1){foreach($TPL_VAR["couponloop"] as $TPL_V1){?>
	<li class="couponDownload resStyle">
		<ul>
			<li class="text">
				<div class="title"><?php echo $TPL_V1["coupon_name"]?></div>
				<div class="descr"><?php echo $TPL_V1["issue_enddatetitle"]?></div>
			</li>
			<li class="sales">
				<div class="coupon_img">
<?php if($TPL_V1["sale_type"]=='percent'){?>
					<span class="num"><?php echo $TPL_V1["percent_goods_sale"]?></span>%
<?php }else{?>
					<?php echo get_currency_price($TPL_V1["won_goods_sale"], 2,'','<span class="num">_str_price_</span>')?>

<?php }?>
				</div>
			</li>
			<li class="bul"></li>
		</ul>
	</li>
<?php }}?>
</ul>
<?php }?>
<div id="couponDownloadDialog" style="display:none"></div>

<script type="text/javascript">
$(document).ready(function(){
	
<?php if(!$TPL_VAR["goods_view"]){?>
	$('.couponDownload').bind("click",function() {
		var memberSeq = "<?php echo $TPL_VAR["userInfo"]["member_seq"]?>";
		var gl_request_uri = "<?php echo urlencode($_SERVER["REQUEST_URI"])?>";

		if( !memberSeq ){
			location.href="/member/login?return_url="+gl_request_uri;
			return false;
		}
		var gl_goods_seq = "<?php echo $_GET["no"]?>";

		if ( $(this).hasClass('resStyle') ) { // 반응형인 경우 껍데기 변경
			coupondownlist_res(gl_goods_seq,gl_request_uri);
		} else {
			coupondownlist(gl_goods_seq,gl_request_uri);
		}
	});

	$("button[name='couponDownloadButton']").live('click',function(){
		var url = '../coupon/download?goods='+$(this).attr('goods')+'&coupon='+$(this).attr('coupon');
		actionFrame.location.href = url;
	});
<?php }?>
});
function getCouponDownlayerclose(){
	$('#couponDownloadDialog').dialog('close');
}
</script>