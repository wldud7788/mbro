<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * channeltalk 연동 라이브러리
 * 2021-05-11
 */
class channeltalklibrary
{
    public $allow_exit = true;
    public $channeltalk;
    public $script;

    function __construct() {
        $this->CI =& get_instance();
        $this->channeltalk = $this->get_channeltalk();
    }

    /**
     * 채널톡 설정 저장 
     */
    function set_channeltalk($arr){
        $channeltalk = array();
        $channeltalk['use'] = trim($arr['channeltalk_use']);
        $channeltalk['plugin_key'] = trim($arr['plugin_key']);
        $channeltalk['access_secret'] = trim($arr['access_secret']);
        config_save('channeltalk', $channeltalk);

        $item = $this->get_channeltalk();
        return $item;
    }

    /**
     * 채널톡 설정 정보
     */
    function get_channeltalk(){
        $items = config_load('channeltalk');
        return $items;
    }

    function check_base_validation(){

        $manager = $this->CI->session->userdata['manager'];

        return ((($this->channeltalk['use'] === 'T' && isset($manager)) || // 관리자인 경우
                  $this->channeltalk['use'] === 'Y') && // 전체 사용자가 사용하는 경우
                  $this->channeltalk['plugin_key'] && 
                  $this->channeltalk['access_secret'] && 
                 !preg_match('/admin\//',$CI->uri->uri_string));
    }

    /**
     * 공통 패치
     */ 
    function common_fetch($html='',$script_name='',$assign_data=array()){

        $script = '';
        
        // 원본 경로
        $ori_dir = array(
            'template_dir' => $this->CI->template->template_dir,
            'compile_dir' => $this->CI->template->compile_dir
        );
        
        // 채널톡 경로
        $channeltalk_dir = array(
            'template_dir' => BASEPATH."../partner/channeltalk",
            'compile_dir' => BASEPATH."../_compile/"
        );
        
        // 채널톡일때만 경로를 변경
        $this->CI->template->template_dir = $channeltalk_dir['template_dir'];
        $this->CI->template->compile_dir = $channeltalk_dir['compile_dir'];
        $this->CI->template->define(array($script_name => $html ));
        
        
        if (!empty($assign_data)){
            $this->CI->template->assign('data', $assign_data);
        }

        // 채널톡 스크립트 string 출력
        $script	= $this->CI->template->fetch($script_name);
        
        //string 변환 후 경로 원복
        $this->CI->template->template_dir = $ori_dir['template_dir'];
        $this->CI->template->compile_dir = $ori_dir['compile_dir'];

        return $script;
    }

    // 공통 스크립트
    function init($ret){
  
        // 초기값 선언
        $script = ($ret) ? $ret : '';

        // 회원여부와 장바구니 갯수 체크
        $userInfo = $this->CI->session->userdata['user'];
        $cartCount = $this->CI->session->userdata['cartCount'];
        $cartPrice = $this->CI->session->userdata['cartPrice'];

        // 마케팅 수신 거부에 따른 설정
        $unsubscribed = ($userInfo['mailing'] == 'n' || $userInfo['sms'] == 'n') ? 'true' : 'false';

        // 개인회원과 사업자회원에 따른 구분 추가
        $memberType = ($userInfo['member_type'] != 'business') ? 'normal' : 'corporation';

        $assign_data = array(
            'plugin_key' =>  $this->channeltalk['plugin_key'],
            'userInfo' => $userInfo,
            'cartCount' => $cartCount,
            'unsubscribed' => $unsubscribed
        );
        
        // 추가 스크립트 
        $extend_script = implode($this->script, "");
        
        if ($this->check_base_validation()) {
        
              // 회원일때만 프로필 연동
              if (isset($userInfo)){
                    $profile = array(
                        'name' => $userInfo['user_name'],
                        'email' => $userInfo['email'],
                        'mobileNumber' => $userInfo['cellphone'],
                        'groupName' => $userInfo['group_name'],
                        'availableMileage' => (int)$userInfo['emoney'],
                        'totalDeposit' => (int)$userInfo['cash'],
                        'cartCount' => (int)$cartCount,
                        'cartPrice' => (int)$cartPrice,
                        'couponCount' => (int)$userInfo['coupon'],
                        'wishCount' => (int)$userInfo['wish_count'],
                        'totalPurchaseAmount' => (int)$userInfo['member_order_price'],
                        'totalPurchaseCount' => (int)$userInfo['member_order_goods_cnt'],
                        'memberType' => $memberType,
                    );
            
                    $output = json_encode($profile,JSON_UNESCAPED_UNICODE);

                    $assign_data['profile'] = $output;
                
              }
              $init_script = $this->common_fetch('channeltalk_init.html','init',$assign_data);
        }

        $script = $ret.$init_script.$extend_script;
        
        
        return $script;

    }

    // 가입시
    function join(){

        // 반환 스크립트 선언
        $this->script['join'] = '';

        if ($this->check_base_validation()) {
            $this->script['join'] = $this->common_fetch('channeltalk_join.html','join');  
        }
        
        return $this->script['join'];        
        
    }

    // 주문서 작성페이지 진입시 ( 결제 직전 단계에서 전송 )
    function begin_checkout($no='',$order=array(),$cart=array()){

        // 반환 스크립트 선언
        $script= '';
        
        if ($this->check_base_validation()){

            // 스크립트내에서 사용될 데이터값 선언
            $assign_data = array();
            $goods = array();


            if ($order['settleprice'] == '' || $order['shipping_cost'] == ''){
                if ($order['settleprice'] == ''){
                    $order['settleprice'] = 0;
                } 
            
                if ($order['shipping_cost'] == ''){
                    $order['shipping_cost'] = 0;
                }
                
            }

            $assign_data['orders'] = array(
                'order_seq' => $no,
                'order' => $order
            );

            if (!empty($cart)){ 
                foreach($cart as $cart_list){    
                    $goods_item = array(
                        'id'   => $cart_list['goods_seq'],
                        'name' => $cart_list['goods_name'],
                        'quantity' => (int) $cart_list['ea'],
                        'amount' => (int) $cart_list['price']
                    );
                    array_push($goods,$goods_item);
                }; 
                
                $output = json_encode($goods,JSON_UNESCAPED_UNICODE);
                $assign_data['goods'] = $output; 
            }

            $script = $this->common_fetch('channeltalk_begin_checkout.html','begin_checkout',$assign_data);  
        }

        return $script;

    }

    // 결제 완료시 (무통장 입금은 주문 접수시 전송) 
    function purchase($shipping_group_items = array(), $orders = array()){
        
        // 반환 스크립트 선언
        $this->script['purchase'] = '';

        if ($this->check_base_validation()) {
            
            // 스크립트내에서 사용될 데이터값 선언
            $assign_data = array();
            $goods = array();
            
            if ($orders['settleprice'] == '' || $orders['shipping_cost'] == ''){
                if ($oders['settleprice'] == ''){
                    $orders['settleprice'] = 0;
                } 
            
                if ($orders['shipping_cost'] == ''){
                    $orders['shipping_cost'] = 0;
                }
                
            }
    
            $assign_data['orders'] = $orders;

            if (!empty($shipping_group_items)) {
                foreach($shipping_group_items as $shipping_group){
                    foreach($shipping_group['items'] as $item){
                        foreach($item['options'] as $option){
                            $goods_item = array(
                                'id' => $item['goods_seq'],
                                'name' => $item['goods_name'],
                                'quantity' => (int) $option['ea'],
                                'amount' => (int) $option['price']
                            );
                            array_push($goods,$goods_item);
                        }
                    }
                }    
        
                $output = json_encode($goods,JSON_UNESCAPED_UNICODE);
                $assign_data['goods'] = $output;
            }

            $this->script['purchase'] = $this->common_fetch('channeltalk_purchase.html','purchase',$assign_data);  

        }
        return $this->script['purchase'];
    }

    // 특정 물품 조회시
    function goods_view($product = array()){

        // 반환 스크립트 선언
        $this->script['goods_view'] = '';
        
        if ($this->check_base_validation()){
            
            // 스크립트내에서 사용될 데이터값 선언
            $assign_data = array();
            
            if (empty($product) || $product['price'] == ''){
                $product['price'] = 0;
            }

            $assign_data = $product;
            
            $this->script['goods_view'] = $this->common_fetch('channeltalk_goods_view.html','goods_view',$assign_data);  

        }
        return $this->script['goods_view'];

    }

    // 장바구니에 물품 등록시
    function cart_in($product = array()){

         // 반환 스크립트 선언
        $this->script['cart_in'] = '';
        
        if ($this->check_base_validation()) {
            
            $assign_data = array();

            if (!empty($product)){
                $assign_data = $product;
            }
            
            $this->script['cart_in'] = $this->common_fetch('channeltalk_cart_in.html','cart_in',$assign_data);  
        }
        return $this->script['cart_in'];

    }

    // 위시리스트에 물품 등록시
    function wish_in($product=array()){
        
        // 반환 스크립트 선언
        $this->script['wish_in'] = "";
        
        // 위시리스트는 회원인 경우에만 동작한다.
        $userInfo = $this->CI->session->userdata('user');
        
        if (isset($userInfo) && $this->check_base_validation()) {
        
            // 장바구니에서 찜버튼 클릭시
            if (empty($product)) {
            
                $this->script['wish_in'] = $this->common_fetch('channeltalk_wish_in.html','wish_in');  
            
            } else {
                $assign_data = array();

                if (empty($product) || $product['price'] == ''){
                    $product['price'] = 0;
                }
    
                $assign_data = $product;
    
                $this->script['wish_in'] = $this->common_fetch('channeltalk_wish_in.html','wish_in',$assign_data);  
     
            } 
            
        }

        return $this->script['wish_in'];

    }
}
?>