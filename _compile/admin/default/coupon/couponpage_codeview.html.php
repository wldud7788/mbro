<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/coupon/couponpage_codeview.html 000000811 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<link rel="stylesheet" href="/app/javascript/plugin/highlight/styles/default.css">
<link rel="stylesheet" href="/app/javascript/plugin/highlight/styles/tomorrow-night.css">
<script src="/app/javascript/plugin/highlight/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<style>
.entry pre { margin:0px; }
.hljs { padding:20px;}
</style>
<!--<div class="right mb5"><input type="button" id="couponallhtml_btn" class="btn_resp v2" value="소스복사" /></div>-->
<div class="entry"><pre><code class="php hljs"><?php echo $TPL_VAR["couponcodeallhtml"]?></code></pre></div>