<?php
$group_name					= array(
	array('key'=>'member', 'value'=>'회원'),
	array('key'=>'order', 'value'=>'주문'),
	array('key'=>'scm', 'value'=>'거래처')
);

$email_group['member'] = array(
	array('name'=>'join','title'=>'회원 가입'),
	array('name'=>'withdrawal','title'=>'회원 탈퇴'),
	array('name'=>'findid','title'=>'아이디 찾기'),
	array('name'=>'findpwd','title'=>'비밀번호 찾기'),
	array('name'=>'dormancy','title'=>'휴면계정 해제 인증'),
	array('name'=>'marketing_agree','title'=>'광고성 정보 수신 동의 여부'),
	array('name'=>'marketing_agree_status','title'=>'광고성 정보 수신 동의 변경'),
	array('name'=>'cs','title'=>'1:1문의 답변'),
	array('name'=>'bulkorder','title'=>'대량구매 답변'),
	array('name'=>'promotion','title'=>'할인코드 발급'),
);

$email_group['order'] = array(
	array('name'=>'order','title'=>'주문 접수'),
	array('name'=>'settle','title'=>'결제 확인'),
	array('name'=>'released','title'=>'출고완료 (주문자)'),
	array('name'=>'delivery','title'=>'배송완료 (주문자)'),
	array('name'=>'cancel','title'=>'환불완료 (취소)'),
	array('name'=>'refund','title'=>'환불완료 (반품)'),
	array('name'=>'coupon_released','title'=>'티켓발송 (주문자)'),
	array('name'=>'coupon_delivery','title'=>'티켓사용 (주문자)'),
	array('name'=>'coupon_cancel','title'=>'티켓환불완료 (취소)'),
	array('name'=>'coupon_refund','title'=>'티켓환불완료 (반품)'),
);

$email_group['scm'] = array(
	array('name'=>'sorder_draft','title'=>'발주서 (원화)'),
	array('name'=>'sorder_edraft','title'=>'발주서 (외화)'),
	array('name'=>'sorder_cancel_draft','title'=>'취소발주서 (원화)'),
	array('name'=>'sorder_cancel_edraft','title'=>'취소발주서 (외화)'),
	array('name'=>'sorder_modify_draft','title'=>'수정발주서 (원화)'),
	array('name'=>'sorder_modify_edraft','title'=>'수정발주서 (외화)'),
);

$personal_title['personal_coupon'] 				= "[{shopName}] 이번주 만료되는 할인쿠폰이 {coupon_count}종 있습니다. 잊지말고 사용하세요!";
$personal_title['personal_emoney'] 				= "[{shopName}] 다음달에 보유하고 계신 마일리지 {mileage_rest}원이 소멸될 예정입니다. 소멸되기 전에 꼭 사용하세요!";
$personal_title['personal_membership'] 			= "[{shopName}] {username} 님의 회원등급은 {userlevel} 등급입니다.";
$personal_title['personal_cart'] 				= "[{shopName}] {go_item}의 상품이 장바구니/위시리스트에 담겨있습니다.";
$personal_title['personal_timesale'] 			= "[{shopName}] {username} {go_item}의 상품이 곧 판매 종료됩니다.";
$personal_title['personal_deliveryconfirm'] 	= "[{shopName}] {username} 회원님, 상품수령을 확인하시고 마일리지을 받으세요.";
$personal_title['personal_review'] 				= "[{shopName}] {username} 회원님, 구매하신 상품 직접 사용 해 보니 어떠세요? 상품평 작성하시고 마일리지을 받으세요.";
$personal_title['personal_birthday'] 			= "[{shopName}] {username} 회원님의 생일({userbirthday})을 진심으로 축하드립니다.";
$personal_title['personal_anniversary'] 		= "[{shopName}] {username} 회원님의 기념일({anniversary})을 진심으로 축하드립니다.";

$config['group_name'] 				= $group_name;
$config['email_group'] 				= $email_group;
$config['email_personal_title'] 	= $personal_title;
?>