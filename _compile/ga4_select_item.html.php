<?php /* Template_ 2.2.6 2022/01/05 11:17:21 /www/music_brother_firstmall_kr/partner/ga4/ga4_select_item.html 000001001 */ ?>
<!-- Start Script for ga4 (쇼핑몰 제품 클릭) -->
<script type='text/javascript'>
    // (반응형스킨) 상품 리스트 클릭시
    $('a[href^="/goods/view"]').click(function(e){
        try {
            var items = '<?php echo $TPL_VAR["data"]["items"]?>';
            if (items != '' && typeof items != 'undefined' && items != null ){
                items = JSON.parse(items);
            }
            var ori_url= $(this).attr('href');
            var qs = ori_url.substring(ori_url.indexOf('?')+1).split('&');
            qs = qs[0].split("=");
            no = qs[1]; // 상품 번호
            if (typeof gtag != 'undefined') {
                ga4_select_item(no);
            }
        } catch(e) {
            console.log('GA4 select_item 이벤트 발생 에러 :',e);
        }   
    });
</script>
<!-- End Script for ga4 -->