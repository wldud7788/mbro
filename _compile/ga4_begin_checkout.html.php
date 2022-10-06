<?php /* Template_ 2.2.6 2022/01/05 11:17:21 /www/music_brother_firstmall_kr/partner/ga4/ga4_begin_checkout.html 000001474 */ ?>
<!-- Start Script for ga4 (결제하기 버튼 클릭) -->
<script type='text/javascript'>
    try {
        var obj;
        var value = '<?php echo $TPL_VAR["data"]["value"]?>';
        var currency = '<?php echo $TPL_VAR["data"]["currency"]?>';
        var items = '<?php echo $TPL_VAR["data"]["items"]?>';
        if (items != '' && typeof items != 'undefined' && items != null ){
            items = JSON.parse(items);
        }
        var ret;

        // gtag가 존재하는지 체크
        if (typeof gtag != 'undefined' ) {
            obj = gtag;
        } else {
            if (typeof parent.gtag != 'undefined' ) {
                obj = parent.gtag;        
            }
        }

        if (value != '') {
            value = parent.check_number(value);
        };
            
        // 주문번호와 상품이 존재할때만 이벤트가 동작 && 새로고침일 경우 수집하지 않는다.
        if (obj != '' && items != '' && performance.navigation.type == 0) {
            obj("event", "begin_checkout", {
                currency: currency,
                value: value,
                items: [items]
            });
        }
    } catch(e) {
        console.log('GA4 begin_checkout 이벤트 발생 에러 :',e);
    }


    
</script>
<!-- End Script for ga4 -->