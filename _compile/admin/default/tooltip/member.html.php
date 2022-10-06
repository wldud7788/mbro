<?php /* Template_ 2.2.6 2022/05/17 12:37:22 /www/music_brother_firstmall_kr/admin/skin/default/tooltip/member.html 000020159 */ 
$TPL_snsinfo_1=empty($TPL_VAR["snsinfo"])||!is_array($TPL_VAR["snsinfo"])?0:count($TPL_VAR["snsinfo"]);
$TPL_codeList_1=empty($TPL_VAR["codeList"])||!is_array($TPL_VAR["codeList"])?0:count($TPL_VAR["codeList"]);?>
<div id="tip1" class="tip_wrap">
	<h1>휴대폰 인증 설정</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>휴대폰 인증은 이름, 생년월일, 휴대폰 번호를 통해 본인확인을 할 수 있는 서비스 입니다.</li>
			<li>휴대폰 인증 설정을 위해서 <a href="https://www.firstmall.kr/addservice/cellphone" class="link_blue_01" target="_black">휴대폰 인증 계약 방법 안내</a>를 확인해주세요.</li>
		</ul>
	</div>
</div>

<div id="tip2" class="tip_wrap">
	<h1>사용 설정</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>운영 방식 설정은 설정 > <a href="/admin/setting/operating" class="link_blue_01">운영 설정</a> 에서 변경할 수 있습니다.</li>
		</ul>
	</div>
</div>

<div id="tip3" class="tip_wrap">
	<h1>아이핀 사용 설정</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>아이핀 인증은 주민번호 대신 본인확인 기관이 공급하는 아이핀 ID, 비밀번호를 사용하여 본인확인을 할 수 있는 서비스입니다.</li>
			<li>아이핀 사용 설정을 위해서 <a href="https://firstmall.kr/ec_hosting/addservice/ipin.php" class="link_blue_01" target="_black">아이핀 인증 계약 방법 안내</a>를 확인해주세요.</li>
		</ul>
	</div>
</div>

<div id="tip4" class="tip_wrap">
	<h1>이용 약관 설정</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>쇼핑몰 하단에 이용약관 설정 클릭 시 보여주는 약관 내용입니다. 공정거래위원회 표준약관을 참고하여 수정하여 사용할 수 있습니다.</li>
			<li>공정거래위원회에서 제공하는 <a href="https://www.ftc.go.kr/solution/skin/doc.html?fn=b5bbcffdef4f9e856121b2ba1c0089df8c1dac13565ee8e66ba6d0ab318c011f&rs=/fileupload/data/result/BBSMSTR_000000002320/" class="link_blue_01" target="_black">표준 약관</a>을 참고해주세요.</li>
		</ul>
	</div>
</div>

<div id="tip5" class="tip_wrap">
	<h1>개인정보 처리 방침 만들기
	</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>개인정보보호 종합지원 포털 사이트(http://www.privacy.go.kr)의 <개인정보처리방침 만들기>는 개인정보보호법 및 시행령, 표준 개인정보 보호지침에 근거하여 개인정보처리방침 기본 항목에 대한 예시를 작성할 수 있도록 도와드리는 서비스입니다. 사업자께서는 생성된 개인정보처리방침을 참조하여 사업 목적 및 범위에 맞도록 수정하여 사용하시기 바랍니다.</li>
			<li>아래의 내용은 사이트 하단에 링크되어지는 ‘개인정보처리방침‘에 제공됩니다.</li>
			<li>사업자께서는 생성된 개인정보 처리 방침을 참조하여 사업 목적 및 범위에 맞도록 수정하여 사용하시기 바립니다.</li>
		</ul>
	</div>
</div>

<div id="tip7" class="tip_wrap">
	<h1>개인정보 수집 및 이용</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>아래의 내용은 ‘회원가입’, ‘비회원 주문’, ‘비회원 게시판 글 작성‘에 제공됩니다.</li>
		</ul>
	</div>
</div>

<div id="tip8" class="tip_wrap">
	<h1>SNS 회원 가입 시 입력 항목</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>'SNS에서 회원가입 시 제공하는 항목입니다.</li>
			<li>아이디 방식 및 외부 계정은 구매자가 MY 페이지에서 추가할 수 있습니다.</li>
		</ul>

		<table class="table_basic tdc section">
			<tr>
				<th>구분</th>
				<th>이메일</th>
				<th>이름</th>
				<th>성별</th>
				<th>생일</th>
				<th>닉네임</th>
			</tr>
<?php if($TPL_snsinfo_1){foreach($TPL_VAR["snsinfo"] as $TPL_K1=>$TPL_V1){?>
			<tr>
				<td><?php echo $TPL_K1?></td>
				<td <?php if($TPL_V1["email"]){?>class="use"<?php }?>><?php if($TPL_V1["email"]=="2"){?>사용자 설정<?php }elseif($TPL_V1["email"]=="1"){?>제공<?php }else{?>미제공<?php }?></td>
				<td <?php if($TPL_V1["name"]){?>class="use"<?php }?>><?php if($TPL_V1["name"]=="2"){?>사용자 설정<?php }elseif($TPL_V1["name"]=="1"){?>제공<?php }else{?>미제공<?php }?></td>
				<td <?php if($TPL_V1["sex"]){?>class="use"<?php }?>><?php if($TPL_V1["sex"]=="2"){?>사용자 설정<?php }elseif($TPL_V1["sex"]=="1"){?>제공<?php }else{?>미제공<?php }?></td>
				<td <?php if($TPL_V1["birthday"]){?>class="use"<?php }?>><?php if($TPL_V1["birthday"]=="2"){?>사용자 설정<?php }elseif($TPL_V1["birthday"]=="1"){?>제공<?php }else{?>미제공<?php }?></td>
				<td <?php if($TPL_V1["nickname"]){?>class="use"<?php }?>><?php if($TPL_V1["nickname"]=="2"){?>사용자 설정<?php }elseif($TPL_V1["nickname"]=="1"){?>제공<?php }else{?>미제공<?php }?></td>
			</tr>
<?php }}?>
		</table>
	</div>
</div>

<div id="tip10" class="tip_wrap">
	<h1>아이디, 비밀번호 찾기</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>이메일, SMS  발송을 위해서는 회원 > <a href="/admin/member/email" class="link_blue_01">이메일 발송 관리</a> 또는  <a href="/admin/member/sms" class="link_blue_01">SMS 발송 관리</a>에서 고객에게 발송 항목이 체크되어야 합니다.</li>
			<li>본인인증으로 아이디, 비밀번호를 찾기 위해서는 설정 > <a href="/admin/setting/member?gb=realname" class="link_blue_01">휴대폰/아이핀 인증</a>을 설정 해야 합니다.</li>
			<li>SNS로 회원 가입한 경우 이용중인 SNS 업체에 문의해주세요. </li>
		</ul>

		<ul class="bullet_circle_in red mt10">
			<li>
				주의 사항
				<ul class="bullet_hyphen black">
					<li>비밀번호는 정보 찾는 경우 임시비밀번호가 전송 혹은 노출이 됩니다.</li>
					<li>회원가입 시 가입항목에 이름과 이메일, 휴대폰이 필수로 입력하지 않는 경우 아이디와 비밀번호를 찾을 수 없습니다.</li>
					<li>‘SMS 발송관리’ 혹은 ‘이메일 발송관리’에서 ‘아이디 찾기’와 ‘비밀번호 찾기’발송을 해제하면 이메일이나 SMS 가 고객에게 발송되지 않으니 주의하시길 바랍니다.</li>
				</ul>
			</li>
		</ul>
	</div>
</div>

<div id="tip11" class="tip_wrap">
	<h1>회원 가입 혜택</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>회원 가입 시 지급하는 혜택을 설정할 수 있습니다.</li>
			<li>신규회원 쿠폰 발급은 프로모션 > <a href="/admin/coupon/catalog" class="link_blue_01">할인 쿠폰</a>에서 설정할 수 있습니다.</li>
		</ul>
	</div>
</div>

<div id="tip12" class="tip_wrap">
	<h1>추천인 혜택</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>회원 가입 시 타인에게 쇼핑몰을 추천한 기존 회원과 추천을 받은 신규 회원에게 지급하는 혜택을 설정할 수 있습니다.</li>
			<li>회원 > 로그인 및 회원가입에서 회원 가입 입력 항목에 '추천인' 을 사용하면 추천인 혜택 이용이 가능합니다.</li>
		</ul>
		<ul class="bullet_circle_in list_01">
			<li>
				기존 회원
				<ul class="bullet_hyphen">
					<li>회원 가입 시 추천을 받은 기존 회원입니다.</li>
				</ul>
			</li>
			<li>
				신규 회원
				<ul class="bullet_hyphen">
					<li>회원 가입 시 추천인을 입력하는 신규 회원입니다.</li>
				</ul>
			</li>
		</ul>
	</div>
</div>

<div id="tip13" class="tip_wrap">
	<h1>등급 정책</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>쇼핑몰의 우수고객 제도(또는 회원등급 정책)는 구매실적(실결제금액,구매건수,구매횟수)을 종합하여 회원 등급을 나누고 등급에 따라 회원에게 혜택을 드리는 제도입니다.</li>
		</ul>
	</div>
</div>

<div id="tip14" class="tip_wrap">
	<h1>산정 기준</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>산정 기준의 총 상품 구매 개수에서 상품 구매와 무관한 사은품은 제외됩니다.</li>
		</ul>
	</div>
</div>

<div id="tip15" class="tip_wrap">
	<h1>회원등급별 구매혜택</h1>

	<div class="con_wrap">
		<ul class="bullet_circle_in">
			<li>
				구매자 (비회원 또는 회원)별 추가 혜택 설정 방법
				<ul class="bullet_hyphen">
					<li>상품 등록 또는 수정 시 해당 상품의 회원 등급 별 구매 혜택을 설정 할 수 있습니다.</li>
				</ul>
				<img class="mt10" width="100%" src="/admin/skin/default/images/design/bnfset_i_slct.gif">
			</li>

			<li>
				추가 혜택 적용 범위 안내 <a href="https://www.firstmall.kr/customer/faq/1115" target="_blank" class="link_blue_01">자세히 보기</a>
			</li>

			<li>
				오프라인 회원(오프라인 매장 등록 시 해당) 혜택 적용 범위 <a href="https://www.firstmall.kr/customer/faq/1154" target="_blank" class="link_blue_01">자세히 보기</a>
			</li>
		</ul>
	</div>
</div>

<div id="tip16" class="tip_wrap">
	<h1>추가할인-조건</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>{상품 할인가(판매가) x 수량}+<?php echo $TPL_VAR["좌동"]?>+…<?php echo $TPL_VAR["좌동"]?>의 합이 얼마 이상일 때만 추가할인</li>
		</ul>
	</div>
</div>

<div id="tip17" class="tip_wrap">
	<h1>추가할인-할인</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>상품 할인가(판매가) x 수량 x % = 추가할인 금액</li>
		</ul>
	</div>
</div>

<div id="tip18" class="tip_wrap">
	<h1>추가할인-추가옵션</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>추가상품 할인가(판매가) x 수량 x % = 추가할인 금액</li>
		</ul>
	</div>
</div>

<div id="tip19" class="tip_wrap">
	<h1>추가적립-조건</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>{상품 할인가(판매가) x 수량}+<?php echo $TPL_VAR["좌동"]?>+…<?php echo $TPL_VAR["좌동"]?>의 합이 얼마 이상일 때만 추가적립</li>
		</ul>
	</div>
</div>

<div id="tip20" class="tip_wrap">
	<h1>추가적립-포인트</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>실 결제금액 x % = 추가포인트 금액</li>
		</ul>
	</div>
</div>

<div id="tip21" class="tip_wrap">
	<h1>추가적립-마일리지</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>실 결제금액 x % = 추가마일리지 금액</li>
		</ul>
	</div>
</div>


<div id="tip22" class="tip_wrap">
	<h1>비밀번호 재확인</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>회원정보 변경 시 비밀번호를 재확인 여부를 설정할 수 있습니다.</li>
			<li>SNS 계정으로 로그인한 경우 비밀번호 재확인 없이 정보 변경이 가능 합니다.</li>
		</ul>
	</div>
</div>

<div id="tip23" class="tip_wrap">
	<h1>휴대폰 정보 변경 시 인증 </h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>휴대폰 번호 변경 시, 인증 후 변경할 수 있도록 설정할 수 있습니다.</li>
			<li>사용 설정 시, 인증 번호를 확인 후 휴대폰 번호 변경이 가능합니다.</li>
		</ul>
	</div>
</div>

<div id="tip24" class="tip_wrap">
	<h1>이메일 인증 시 해제</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>회원가입 시 기입한 이메일로 인증 메일이 발송 되며, 기입한 이메일이 없는 경우 로그인 시 휴면처리 자동 해제됩니다. </li>
			<li>휴면 해제 이메일 인증 내용은 회원 > <a href="/admin/member/email" class="link_blue_01">이메일 발송 관리</a>에서 확인 가능합니다.</li>
		</ul>
	</div>
</div>

<div id="tip25" class="tip_wrap">
	<h1>본인 인증 시 해제</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>본인 인증 시 휴면 처리가 해제 됩니다.</li>
			<li>본인 인증 사용은 회원 > <a href="/admin/setting/member?gb=realname" class="link_blue_01">본인인증</a> 설정 시 사용할 수 있습니다.</li>
		</ul>
	</div>
</div>

<div id="tip26" class="tip_wrap">
	<h1>휴면 처리</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>정보통신망법에 따라 1년 이상 로그인하지 않는 회원의 경우 회원 정보를 별도로 보관해야 하며 퍼스트몰은 1년 이상 로그인하지 않은 회원을 자동으로 휴면 처리하여 별도로 보관하는 기능을 제공합니다.</li>
			<li>쇼핑몰 운영자는 휴면처리 1개월 전까지 대상 회원에게 미리 공지를 해야 합니다.</li>
		</ul>

		<ul class="bullet_circle_in list_01">
			<li>
				휴면처리 고지방법 안내
				<ul class="bullet_hyphen">
					<li>SMS 자동 고지: 회원 > <a href="/admin/member/sms" class="link_blue_01">SMS자동발송</a>에서 설정</li>
					<li>
						SMS 수동 고지:
						<ul class="bullet_num">
							<li>(1000명 미만) 회원 > 휴면처리리스트에서 SMS수동발송을 통해 가능 </li>
							<li>(1000명 이상) 11개월간 로그인 기록 없는 회원 엑셀다운로드 후 회원 > <a href="/admin/batch/sms" class="link_blue_01">SMS대량발송</a>에서 가능</li>
						</ul>
					</li>
					<li>
						이메일 수동 고지:
						<ul class="bullet_num">
							<li>회원 > <a href="/admin/member/dormancy_catalog" class="link_blue_01">휴면처리리스트</a>에서 이메일 수동발송을 통해 가능</li>
							<li>11개월간 로그인 기록 없는 회원 엑셀다운로드 후 회원 > <a href="/admin/member/amail" class="link_blue_01">이메일대량발송</a>에서 가능</li>
						</ul>
					</li>
				</ul>
			</li>
			<li>
				관련 법규 (2015년 8월 18일 적용)
				<ul class="bullet_hyphen">
					<li>
						정보통신망 이용촉진 및 정보보호 등에 관한 법률 시행령<br/>
						제16조(개인정보의 파기 등) ① 법 제29조제2항에서 "대통령령으로 정하는 기간"이란 1년을 말한다<br/>
						2 항의 ② 정보통신서비스 제공자등은 이용자가 정보통신서비스를 제1항의 기간 동안 이용하지 아니하는 경우에는 이용자의 개인정보를 해당 기간 경과 후 즉시 파기하거나 다른 이용자의 개인정보와 분리하여 별도로 저장·관리하여야 한다.<br/>
						④ 정보통신서비스 제공자등은 제1항의 기간 만료 30일 전까지 개인정보가 파기되거나 분리되어<br/>
						저장·관리되는 사실과 기간 만료일 및 해당 개인정보의 항목을 전자우편·서면·모사전송·전화 또는 이와 유사한 방법 중 어느 하나의 방법으로 이용자에게 알려야 한다
					</li>

				</ul>
			</li>
		</ul>
	</div>
</div>

<div id="tip27" class="tip_wrap">
	<h1>보안 문자 </h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>아이디, 비밀번호 입력 시 보안문자 입력 여부를 설정하는 항목입니다. </li>
		</ul>
	</div>
</div>

<div id="tip28" class="tip_wrap">
	<h1>선정 기간</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>선정 기준은 회원별 실 결제금액, 구매 건수, 구매 횟수로 계산합니다.</li>
		</ul>
	</div>
</div>

<div id="tip29" class="tip_wrap">
	<h1>비밀번호 변경 유도</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>정보통신 이용촉진 및 정보보호 등에 관한 법률과 방통위 시행령에 따라 정보 보호를 위해 쇼핑몰 회원에게 90일마다 비밀번호 변경을 유도할 수 있습니다.</li>
		</ul>
	</div>
</div>

<div id="tip30" class="tip_wrap">
	<h1>자동 로그아웃</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>쇼핑몰 회원의 정보 보호를 위해 활동이 없는 경우 회원을 일정 시간 이후 자동 로그아웃 시킵니다.</li>
		</ul>
	</div>
</div>

<div id="tip31" class="tip_wrap">
	<h1>오프라인 회원 가입</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>해당 항목은 POS 기기를 연동한 고객을 위한 오프라인 회원 가입 페이지 입니다.</li>
			<li>쇼핑몰의 회원 가입 페이지와는 무관합니다.</li>
			<li>오프라인 창업 <a href="https://www.firstmall.kr/introduce/firstmall/offline" target="_blank" class="link_blue_01">자세히 보기</a></li>
		</ul>

		<ul class="bullet_circle mt10">
			<li>예시 화면</li>
		</ul>

		<img src="/admin/skin/default/images/common/o2o_join.jpg">
	</div>
</div>

<div id="tip32" class="tip_wrap">
	<h1>수동 승인</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>쇼핑몰 회원 가입 시 관리자의 승인이 있어야 회원 가입이 완료됩니다.</li>
			<li>회원 가입 승인은 회원 > <a href="/admin/member/catalog" target="_blank" class="link_blue_01">회원리스트</a>에서 가능합니다.</li>
		</ul>
	</div>
</div>

<div id="tip33" class="tip_wrap">
	<h1>단독 상품 이벤트 종료</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>장바구니 또는 위시리스트에 해당 상품을 담은 회원에게 단독 상품 이벤트 종료를 안내합니다.</li>
		</ul>
	</div>
</div>

<div id="tip34" class="tip_wrap">
	<h1>상품 리뷰 혜택 안내</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>상품후기 게시판 후기 작성 리워드 자동 지급 설정 시에만 발송됩니다.</li>
		</ul>
		<a href="/admin/board/manager_write?id=goods_review" target="_blank" class="link_blue_01">설정 바로가기 ></a>
	</div>
</div>

<div id="tip35" class="tip_wrap">
	<h1>약관 및 개인정보처리방침 치환 코드</h1>
	<div class="con_wrap">
		<table class="table_basic tdc section">
			<tr>
				<th>항목</th>
				<th>치환코드</th>
			</tr>
<?php if($TPL_codeList_1){foreach($TPL_VAR["codeList"] as $TPL_K1=>$TPL_V1){?>
			<tr>
				<td style="text-align:left;"><?php echo $TPL_K1?></td>
				<td>{<?php echo $TPL_V1?>}</td>
			</tr>
<?php }}?>
		</table>
	</div>
</div>

<div id="tip36" class="tip_wrap">
	<h1>만 14세 미만 아동 회원 가입 제한</h1>
	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>정보통신망법 제31조제1항에 의거, 정보통신서비스 제공자 등이 만 14세 미만의 아동으로부터 개인정보 수집·이용·제공 등의 동의를 받으려면 그 법정대리인의 동의를 받아야 합니다. </li>
			<li>'관리자 인증 후 가입' 선택한 경우, 회원 가입 시 본인 인증 또는 생년월일을 입력해야 합니다. </li>
			<li>법정 대리인 동의서는 만 14세 미만 회원 가입 시 필수 제출 서류입니다. 제공된 샘플을 다운로드 받아 내용 수정 후, 법정 대리인 동의서에 파일을 업로드해주세요. </li>
			<li class="red">'제한 없음'을 선택한 경우 정보통신망 이용촉진 및 정보보호 등에 관한 법률 시행령 제 17조 2에 위배되므로 처벌을 받을 수 있습니다. </li>
			<li>SNS로 회원 가입 시 연령 확인이 불가하여 만 14세 미만 아동 연령 제한이 불가합니다. 관련 법적 책임은 쇼핑몰에 있으니 주의하시기 바랍니다. </li>
			<li>만 14세 미만 아동 회원가입 안내 <a href="https://www.firstmall.kr/customer/faq/1205" target="_blank" class="link_blue_01">자세히 보기</a></li>
		</ul>
	</div>
</div>