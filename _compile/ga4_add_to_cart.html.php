<?php /* Template_ 2.2.6 2022/01/05 11:17:21 /www/music_brother_firstmall_kr/partner/ga4/ga4_add_to_cart.html 000008364 */ ?>
<!-- Start Script for ga4 (장바구니에 상품 추가시) -->
<script type='text/javascript'>
    
    function common_process(amount, quantity, option) {
        var ret = [];
        var goods_option = '';
        if (typeof amount != 'undefined' && amount != null) {
            ret.amount = check_number(amount);
        }
        
        if (typeof quantity != 'undefined' && quantity != null) {
            ret.quantity = check_number(quantity);        
        }

        if (typeof option != 'undefined' && option != null && option != '' && typeof option == 'object') {
            // 옵션 가공
            for(var i=0; i < option.length; i++){
                goods_option += option[i]; 
                goods_option += "/";
            }
            goods_option = goods_option.slice(0, -1);
        } 

        ret.option = goods_option;  
        return ret;

    };

    // 과세 체크
    function tax_calculator(original_price,ea,tax) {
        var price = 0;

        // 할인된 개별 가격 합계
        var op_price = 0;
            op_price = original_price;
            price = Math.floor(op_price/ea);
        // 과세
        if (tax == 'tax') {
            // 세금빼고 개별 과세 
            price = Math.floor(Math.round(op_price/ea)/1.1);
        }

        return price;
    }
   
    $('#addCart').on('click', function() {

        var quantity = 0;
        var amount = 0;
        var items = [];
        var amount_tag = '';
        var option_tag = '';
        var tmp_amount = 0;
        var tmp_option = '';    
        var option = '';
        var option_arr = [];
        var ret; // 반환값
        var currency = '<?php echo $TPL_VAR["data"]["currency"]?>';
        var value = '<?php echo $TPL_VAR["data"]["value"]?>';
        var item = '<?php echo $TPL_VAR["data"]["items"]?>';
        if (item != '' && typeof item != 'undefined' && item != null ){
            item = JSON.parse(item);
        }
        var tax = '<?php echo $TPL_VAR["data"]["tax"]?>';
        

        try {
            // (반응형 스킨) 단일 옵션일 경우 
            if ($('.num_single_area').length > 0) {
                
                // 수량
                quantity = $("input[name*=optionEa]").val();

                if (typeof quantity != 'undefined' ) {
                    quantity = check_number(quantity);
                }

                // value값 재설정
                value =  $('#total_goods_price').text();
                if ($('#total_goods_price').length > 0 && typeof value != 'undefined' ){
                    value = check_number(value);
                }

            item.quantity = quantity;

            }
        } catch(e) {
            console.log(e);
        }

        try {
            // 수량 선택시 && 단일 옵션이 아닐시
            if ($("input[name*=optionEa]").length > 0 && $('.num_single_area').length == 0) {
                if ($("input[name*=optionEa]").length === 1){ // 옵션이 1개 or 옵션이 없을때

                    // 기본금액
                    amount = item.price;

                    // 옵션
                    $("input[class=selected_options]").each(function() {
                        option_arr.push(this.value);
                        option = option_arr;
                    });

                    // 수량
                    quantity = $("input[name*=optionEa]").val();

                    ret  =  common_process(amount,quantity,option);

                    // 상품 할인가격 number로 변경
                    item.discount = check_number(item.discount);

                    if (Object.keys(ret).length > 0) {
                        
                        item.quantity = ret.quantity;
                        
                        if (ret.option == ''){
                            item.item_variant = option[0];    
                        } else {
                            item.item_variant = ret.option;
                        }

                    }                      
                } else { // 상세페이지, 장바구니에 담을 경우 옵션 여러개일때  

                    $("input[name*=optionEa]").each(function() { 
                        // 옵션 1개당 items가 새롭게 담긴다.
                        option_arr = [];
                        option = '';

                        // 새롭게 아이템 구성되는데 공통값 
                        new_item = {
                            'affiliation'   :   item.affiliation,
                            'currency'      :   item.currency,
                            'item_brand'    :   item.item_brand,
                            'item_category' :   item.item_category,
                            'item_name'     :   item.item_name, 
                            'item_id'       :   item.item_id
                        };

                        // (반응형스킨)
                        if (gl_skin.indexOf('responsive') != -1){
                            amount_tag  =   'li';
                            option_tag  =   'ul';
                        } else { // (전용스킨)
                            amount_tag = 'td';
                            option_tag = 'td';
                        }

                        // (공통) 기본 옵션 or 가격 태그를 임시 변수에 담는다.
                        tmp_amount = $(this).parents(amount_tag).siblings('.option_col_price').children('.out_option_price').text();
                        tmp_option = $(this).parents(option_tag).siblings('.option_text').children("input[class=selected_options]");
                        
                        // 가격
                        if (tmp_amount.length > 0) {
                            if (typeof tmp_amount != 'undefined' && tmp_amount != '') {
                                amount = tmp_amount;
                            };
                        }
                        
                        // 옵션
                        if (typeof tmp_option != 'undefined' && tmp_option != '') {
                            
                            $(tmp_option).each(function() {
                                option_arr.push(this.value);
                                option = option_arr;
                            });
                        };

                        // 수량
                        quantity = this.value;
                        
                        ret  =  common_process(amount,quantity,option);

                        if (Object.keys(ret).length > 0) {
                            
                            new_item.item_variant = ret.option;
                            new_item.quantity = ret.quantity;

                            // 과세일 경우
                            if (tax == 'tax') {
                                new_item.price = tax_calculator(ret.amount,quantity,tax);                         
                            } else {
                                new_item = ret.amount;
                            }
                        }     
                        new_item.discount = check_number(item.discount);
                        items.push(new_item);
                    
                    });
                };
            value = check_number($('#total_goods_price').text());
            };
            if (items.length == 0) items = item;
    } catch(e) {
        console.log('GA4 add_to_cart 이벤트 발생 에러 :',e); 
    }
        try {
            if  (typeof gtag    !=  'undefined'){
                    // GA4 장바구니 상품 추가 이벤트 발생
                    gtag("event", "add_to_cart", {
                        currency: currency,
                        value: value,
                        items: [items]
                    });
            }
        } catch(e) {
            console.log('GA4 add_to_cart 이벤트 발생 에러 :',e);
        }


    });

</script>
<!-- End Script for ga4 -->