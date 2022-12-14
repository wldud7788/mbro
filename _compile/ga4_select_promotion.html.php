<?php /* Template_ 2.2.6 2022/01/05 11:17:21 /www/music_brother_firstmall_kr/partner/ga4/ga4_select_promotion.html 000005603 */ ?>
<!-- Start Script for ga4 (쇼핑몰 프로모션 클릭) -->
<script type='text/javascript'>

   function select_event(ori_url,creative_slot,data_type) {
        var qs = ori_url.substring(ori_url.indexOf('?')+1).split('&');
        var data = {};
        var event_type = '';
        if (data_type == 'no') {
            event_type = qs[0].split("=")[0];
            var no = qs[0].split("=")[1];
            data = {
                'no' : no,
                'event_type' : event_type
            }
        } else if(data_type == 'tpl') {
            var tpl_path = qs[0].split("=")[1];
            if (tpl_path.indexOf('gift') > -1) {
                event_type = 'gift';
            } else if (tpl_path.indexOf('event') > -1) {
                event_type = 'event';
            } else {
                event_type = '';
            }
            data = {
                'tpl_path' : tpl_path,
                'event_type' : event_type
            }               
        }
        try {
            if (typeof data_type != 'undefined' && data_type != null && data_type != '') {
                $.ajax({
                    url: "/promotion/now_event", //컨트롤러 URL
                        data: data,
                        dataType: 'json',
                        type: 'POST',
                        success: function (res) {
                            if (res.event_type == 'solo'){ // 단독이벤트일 경우 수집 X
                                return false;
                            } else {
                                if (typeof gtag != 'undefined') {
                                    gtag("event", "select_promotion", {
                                        creative_name: res.tpl_path,
                                        creative_slot: creative_slot,
                                        promotion_id: res.event_seq,
                                        promotion_name: res.title,
                                    });
                                return true;
                                };
                            }
                        },error: function (xhr) {
                            console.log(xhr.responseText,'오류입니다.');
                            return false;
                        } 
                });
            }
        } catch(e) {
            console.log('GA4 select_promotion ajax 호출 에러 :',e);
        }

   }

    // (반응형스킨) 할인 이벤트 && 사은품 이벤트 접근시
    $('.event_bnr1 > li > a').on('click', function() {
        try {
            var ori_url= $(this).attr('href');
            select_event(ori_url,'직접이벤트','no');
        } catch(e) {
            console.log('GA4 select_promotion 직전이벤트 발생 에러 :',e);
        }

    });

    // (반응형스킨) 관련 이벤트 클릭시
    $('.detail_relation_event > li > a').on('click', function() {
        try {
            var ori_url= $(this).attr('href');
            select_event(ori_url,'관련이벤트','no');
        } catch(e) {
            console.log('GA4 select_promotion 관련이벤트 발생 에러 :',e);
        }

    });

    // (전용스킨 모바일) 직접 이벤트 접근시
    if (typeof $("a[href^='/page']").attr('target') == 'undefined' && typeof uriString != 'undefined') {
        try {
            $(document).on("click", "a[href^='/page']", function(){
                var ori_url = $(this).attr('href');
                    ori_url = ori_url.replace('%2F','/');
                    select_event(ori_url,'직접이벤트','tpl');
            });
        } catch(e) {
            console.log('GA4 select_promotion 모바일 직접이벤트 발생 에러 :',e);
        } 
    }


    // (전용스킨) 직접 이벤트 접근시
    if ($("a[href^='/page']").length > 0 && typeof $("a[href^='/page']").attr('target') == 'undefined') {
        try {
            $("a[href^='/page']").on('click', function() {
                var ori_url = $(this).attr('href');
                    ori_url = ori_url.replace('%2F','/');
                select_event(ori_url,'직접이벤트','tpl');
                        
                });
            } catch(e) {
                console.log('GA4 select_promotion 관련이벤트 발생 에러 :',e);
            }
    }

    // (전용스킨) 관련 이벤트 접근시
    if ($("a[href^='/page']").length > 0 && $("a[href^='/page']").attr('target') == '_event') {
        try {
            $("a[href^='/page']").on('click', function() {
                var event = '<?php echo $TPL_VAR["data"]["event"]?>';
                if (event != '' && typeof event != 'undefined' && event != null ){
                    event = JSON.parse(event);
                }
                if (typeof gtag != 'undefined') { 
                    gtag("event", "select_promotion", {
                        creative_name: event.creative_name,
                        creative_slot: event.creative_slot,
                        promotion_id: event.promotion_id,
                        promotion_name: event.promotion_name,
                    });
                };   
            });
        } catch(e) {
            console.log('GA4 select_promotion 관련이벤트 발생 에러 :',e);
        }
    }
      
    
</script>
<!-- End Script for channeltalk -->