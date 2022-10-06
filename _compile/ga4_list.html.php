<?php /* Template_ 2.2.6 2022/01/05 11:17:21 /www/music_brother_firstmall_kr/partner/ga4/ga4_list.html 000000793 */ ?>
<!-- Start Script for ga4 (쇼핑몰 제품 목록 조회) -->
<script type='text/javascript'>
    try {
        var items = '<?php echo $TPL_VAR["data"]["items"]?>';
        if (items != '' && typeof items != 'undefined' && items != null ){
            items = JSON.parse(items);
        }
        // 새로고침일 경우 값 수집 안함
        if (performance.navigation.type === 0 && typeof gtag != 'undefined') {
            gtag("event", "view_item_list", {
                items: items
            });
        }

    } catch(e) {
        console.log('GA4 view_item_list 이벤트 발생 에러 :',e);
    }
</script>
<!-- End Script for ga4 -->