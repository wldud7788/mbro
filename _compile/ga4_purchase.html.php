<?php /* Template_ 2.2.6 2022/01/05 11:17:21 /www/music_brother_firstmall_kr/partner/ga4/ga4_purchase.html 000002445 */ ?>
<!-- Start Script for ga4 (결제 완료시)-->
 <script type='text/javascript'>
    try {
        var currency = '<?php echo $TPL_VAR["data"]["currency"]?>';
        var transaction_id = '<?php echo $TPL_VAR["data"]["transaction_id"]?>';
        var value = '<?php echo $TPL_VAR["data"]["value"]?>';
        var affiliation = '<?php echo $TPL_VAR["data"]["affiliation"]?>';
        var shipping = '<?php echo $TPL_VAR["data"]["shipping"]?>';
        var tax = '<?php echo $TPL_VAR["data"]["tax"]?>';
        var items = '<?php echo $TPL_VAR["data"]["items"]?>';
        if (items != '' && typeof items != 'undefined' && items != null ){
            items = JSON.parse(items);
        };
        var data = {};
        var ret; // 반환값

        if (value != '') {
            data.value = value;
        };
        
        if (shipping != '') {
            data.shipping = shipping;
        };

        if (tax != '') {
            data.tax = tax;
        }
        
        if (Object.keys(data).length > 0) {
            // 타입체크
            ret = check_obj(data);

            // 금액이나 수량은 반드시 숫자로 반환
            if (ret.value && typeof ret != 'undefined' && ret != null) {
                value = ret.value;
            } 

            if (ret.shipping && typeof ret != 'undefined' && ret != null) {
                shipping = ret.shipping;
            }

            if (ret.tax && typeof ret != 'undefined' && ret != null) {
                tax = ret.tax;
            }


        }

        // 주문번호와 총 상품이 존재하고 ChannelIO 객체가 존재할때 이벤트가 동작 && 새로고침일 경우 수집하지 않는다.
        if (typeof items != 'undefined' && items != '' && performance.navigation.type === 0 && typeof gtag != 'undefined') {
            gtag("event", "purchase", {
                currency: currency,
                transaction_id: transaction_id,
                value: value,
                affiliation: affiliation,
                shipping: shipping,
                tax: tax,
                items: items
            });
        }
    } catch(e) {
        console.log('GA4 purchase 이벤트 발생 에러 :',e);
    }
    
</script>
<!-- End Script for ga4 -->