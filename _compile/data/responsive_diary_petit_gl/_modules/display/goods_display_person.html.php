<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/_modules/display/goods_display_person.html 000001501 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<style>
.personal_item {position:relative; text-align:left; margin-bottom:5px; height:79px; background-color:#fff; border:1px solid #ccc; cursor:pointer}
.personal_item .pi_icon {position:absolute; left:20px; top:20px;}
.personal_item .pi_arrow {position:absolute; right:15px; top:30px;}
.personal_item .pi_title {padding-top:18px; padding-left:73px; font-size:14px; color:#515151; font-weight:Bold;}
.personal_item .pi_price {padding-top:1px;padding-left:73px; color:#f05f30; font-weight:bold; font-size:24px;}
</style>

<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
<div class="personal_item" onclick="document.location.href='/order/settle?person_seq=<?php echo $TPL_V1["person_seq"]?>&member_seq=<?php echo $TPL_V1["member_seq"]?>'">
	<div class="pi_icon"><img src="/data/skin/responsive_diary_petit_gl/images/common/prv_pay.png" width="39" height="39" /></div>
	<div class="pi_arrow"><img src="/data/skin/responsive_diary_petit_gl/images/common/arrow.png" width="12" height="21" /></div>

	<div class="pi_title"><?php echo $TPL_V1["title"]?></div>
	<div class="pi_price"><?php echo get_currency_price(($TPL_V1["total_price"]-$TPL_V1["enuri"]), 2,'','','fx13')?></div>

</div>
<?php }}?>