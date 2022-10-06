<?php /* Template_ 2.2.6 2022/01/05 11:17:21 /www/music_brother_firstmall_kr/partner/ga4/ga4_view_item.html 000001141 */ ?>
<!-- Start Script for ga4 (제품 / 품목 상세보기) -->
<script type='text/javascript'>
    try {
        var currency = '<?php echo $TPL_VAR["data"]["currency"]?>';
        var value = '<?php echo $TPL_VAR["data"]["value"]?>';
        if (value != '' && typeof value != 'undefined' && value != null) {
            value = check_number(value);
        }
        var items = '<?php echo $TPL_VAR["data"]["items"]?>';
        if (items != '' && typeof items != 'undefined' && items != null ){
            items = JSON.parse(items);
        };

        // 새로고침일 경우 수집하지 않는다.
        if (performance.navigation.type === 0 && typeof gtag != 'undefined'){
            gtag("event", "view_item", {
                currency: currency, // 통화
                value: value,
                items: [items]
        });
        }

    } catch(e) {
        console.log('GA4 view_item 이벤트 발생 에러 :',e);
    }

</script>
<!-- End Script for channeltalk -->