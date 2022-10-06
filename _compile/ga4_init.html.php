<?php /* Template_ 2.2.6 2022/01/05 11:17:21 /www/music_brother_firstmall_kr/partner/ga4/ga4_init.html 000000690 */ ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script>
    var id = '<?php echo $TPL_VAR["data"]["id"]?>';
</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=".id></script>
<script>
  window.dataLayer = window.dataLayer || [];
  try {
        function gtag(){
        dataLayer.push(arguments);
        
        // 추후 웹인지 앱인지 구분하는 부분 추가 필요
    };
    gtag('js', new Date());
    gtag('config', id);
  } catch(e) {
    console.log('GA4 init 이벤트 발생 에러 :',e);
  }

</script>