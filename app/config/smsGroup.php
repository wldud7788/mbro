<?php

$msg_group[1] = array(
    array(
        'name' => 'join',
        'title' => '회원가입',
        'disable' => '',
        'user_disable' => '',
        'provider' => '',
    ),
    array(
        'name' => 'findid',
        'title' => '아이디 찾기',
        'disable' => 'disabled',
        'user_disable' => '',
        'provider' => '',
    ),
    array(
        'name' => 'withdrawal',
        'title' => '회원탈퇴',
        'disable' => 'disabled',
        'user_disable' => '',
        'provider' => '',
    ),  
    array(
        'name' => 'findpwd',
        'title' => '비밀번호 찾기',
        'disable' => 'disabled',
        'user_disable' => '',
        'provider' => '',
    ),
    array(
        'name' => 'dormancy',
        'title' => '휴면계정 전환',
        'disable' => 'disabled',
        'user_disable' => '',
        'provider' => '',
    ),
);

$msg_group[2] = array(
    array(
        'name' => 'order',
        'title' => ' 주문접수',
        'disable' => '',
        'user_disable' => '',
        'provider' => '',
    ),
    array(
        'name' => 'deposit',
        'title' => '입금요청',
        'disable' => '',
        'user_disable' => '',
        'provider' => '',
    ),
    array(
        'name' => 'settle',
        'title' => '결제확인',
        'disable' => '',
        'user_disable' => '',
        'provider' => 'y',
    ), 
    array(
        'name' => 'cancel',
        'title' => '환불완료(취소)',
        'disable' => '',
        'user_disable' => '',
        'provider' => '',
    ), 
    array(
        'name' => 'refund',
        'title' => '환불완료(반품)',
        'disable' => '',
        'user_disable' => '',
        'provider' => '',
    ), 
    array(
        'name' => 'coupon_cancel',
        'title' => '티켓 환불 완료(취소)',
        'disable' => '',
        'user_disable' => '',
        'provider' => '',
    ), 
    array(
        'name' => 'coupon_refund',
        'title' => '티켓 환불 완료(반품)',
        'disable' => '',
        'user_disable' => '',
        'provider' => '',
    ), 
);

$msg_group[3] = array(
    array(
        'name' => 'released',
        'title' => '출고완료(주문자)',
        'disable' => '',
        'user_disable' => '',
        'provider' => 'y',
    ),
    array(
        'name' => 'released2',
        'title' => '출고완료(받는분)',
        'disable' => 'disabled',
        'user_disable' => '',
        'provider' => 'y',
    ),
    array(
        'name' => 'delivery',
        'title' => '배송완료(주문자)',
        'disable' => '',
        'user_disable' => '',
        'provider' => 'y',
    ), 
    array(
        'name' => 'delivery2',
        'title' => '배송완료(받는분)',
        'disable' => 'disabled',
        'user_disable' => '',
        'provider' => 'y',
    ), 
    array(
        'name' => 'coupon_released2',
        'title' => '티켓발송(주문자)',
        'disable' => 'disabled',
        'user_disable' => '',
        'provider' => 'y',
    ), 
    array(
        'name' => 'coupon_released',
        'title' => '티켓발송(받는분)',
        'disable' => '',
        'user_disable' => '',
        'user_req' => 'y',
        'provider' => 'y',
    ), 
    array(
        'name' => 'coupon_delivery2',
        'title' => '티켓사용(주문자)',
        'disable' => 'disabled',
        'user_disable' => '',
        'provider' => 'y',
    ), 
    array(
        'name' => 'coupon_delivery',
        'title' => '티켓사용(받는분)',
        'disable' => '',
        'user_req' => 'y',
        'user_disable' => '',
        'provider' => 'y',
    ), 
);

$msg_group[4] = array(
    array(
        'name' => 'sms_charge',
        'title' => 'SMS 충전 안내',
        'disable' => '',
        'user_disable' => 'disabled',
        'provider' => '',
    ),
    array(
        'name' => 'autodeposit_charge',
        'title' => '자동입금확인 연장 안내',
        'disable' => '',
        'user_disable' => 'disabled',
        'provider' => '',
    ),
    array(
        'name' => 'goodsflow_charge',
        'title' => '굿스플로 연장 안내',
        'disable' => '',
        'user_disable' => 'disabled',
        'provider' => '',
    ),
);

$msg_group[5] = array(
    array(
        'name' => 'sorder_draft',
        'title' => '발주완료시',
        'disable' => '',
        'user_disable' => '',
        'provider' => '',
    ),
    array(
        'name' => 'sorder_cancel_draft',
        'title' => '발주취소시',
        'disable' => '',
        'user_disable' => '',
        'provider' => '',
    ),
    array(
        'name' => 'sorder_modify_draft',
        'title' => '수정발주시',
        'disable' => '',
        'user_disable' => '',
        'provider' => '',
    ),
);

$msg_group[6] = [
	[
		'name' => 'present_receive',
		'title' => '선물수신 (받는분)',
		'disable' => 'disabled',
		'user_disable' => '',
		'provider' => '',
	],
	[
		'name' => 'present_cancel_order',
		'title' => '선물취소 (주문자)',
		'disable' => 'disabled',
		'user_disable' => '',
		'provider' => '',
	],
	[
		'name' => 'present_cancel_receive',
		'title' => '선물취소 (받는분)',
		'disable' => 'disabled',
		'user_disable' => '',
		'provider' => '',
	],
];

foreach ($msg_group as $key => $group ) {
    foreach($group as $data) {
        $new_group[$key]['name'][] = $data['name'];
        $new_group[$key]['title'][] = $data['title'];
        $new_group[$key]['disable'][] = $data['disable'];
        $new_group[$key]['user_disable'][] = $data['user_disable'];
        $new_group[$key]['user_req'][] = $data['user_req'];
        $new_group[$key]['provider'][] = $data['provider'];
    }
}

$personal_title['personal_coupon'] 				= "[{shopName}] 이번주 만료되는 할인쿠폰이 {coupon_count}종 있습니다. 잊지말고 사용하세요! {mypage_short_url}";
$personal_title['personal_emoney'] 				= "[{shopName}] 다음달에 보유하고 계신 마일리지 {mileage_rest}원이 소멸될 예정입니다. 소멸되기 전에 꼭 사용하세요! {mypage_short_url}";
$personal_title['personal_membership'] 			= "[{shopName}] {username} 님의 회원등급은 {userlevel} 등급입니다. 마이페이지에서 등급 혜택을 확인하세요! {mypage_short_url}";
$personal_title['personal_cart'] 				= "[{shopName}] {go_item}의 상품이 장바구니/위시리스트에 담겨있습니다. {mypage_short_url}";
$personal_title['personal_timesale'] 			= "[{shopName}] {username} {go_item}의 상품이 곧 판매 종료됩니다. {mypage_short_url}";
$personal_title['personal_deliveryconfirm'] 	= "[{shopName}] {username} 회원님, 상품수령을 확인하시고 마일리지을 받으세요. {mypage_short_url}";
$personal_title['personal_review'] 				= "[{shopName}] {username} 회원님, 구매하신 상품 직접 사용 해 보니 어떠세요? 상품평 작성하시고 마일리지을 받으세요. {mypage_short_url}";
$personal_title['personal_birthday'] 			= "[{shopName}] {username} 회원님의 생일({userbirthday})을 진심으로 축하드립니다.";
$personal_title['personal_anniversary'] 		= "[{shopName}] {username} 회원님의 기념일({anniversary})을 진심으로 축하드립니다.";

$config['msg_group'] 			= $new_group;
$config['sms_personal_title'] 	= $personal_title;
?>