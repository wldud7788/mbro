<?php /* Template_ 2.2.6 2022/05/17 12:32:01 /www/music_brother_firstmall_kr/admin/skin/default/ifdo_marketing/config.html 000003339 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/admin/ifdoMarketingRegist.js?mm=<?php echo date('Ymd')?>"></script>
<style>
#lay_npay_btn_style{padding:0};
</style>

<form name="partner" method="post" action="../ifdo_marketing_process/config" target="actionFrame">

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>IFDO 마케팅 설정</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">	
			<li><button type="submit" class="resp_btn active2 size_L">저장</button></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">

	<table class="table_basic thl">		
		<tr>
			<th>사용 여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="ifdo_marketing_use" value="Y" <?php if($TPL_VAR["ifdo_marketing"]["use"]=='Y'){?>checked<?php }?>> 사용함</label>
					<label><input type="radio" name="ifdo_marketing_use" value="N" <?php if($TPL_VAR["ifdo_marketing"]["use"]=='N'||!$TPL_VAR["ifdo_marketing"]["use"]){?>checked<?php }?>> 사용 안 함</label>
					<div class="resp_message v2">
						- 서비스를 사용하시려면 IFDO 마케팅 자동화 서비스를 신청 후, 가능합니다.
					</div>
				</div>
			</td>
		</tr>
		<tr class="display_ifdo_marketing_use hide">
			<th>사이트 구분 코드</th>
			<td>
				<input class="wx250" type="text" name="ifdo_marketing_code" value="<?php echo $TPL_VAR["ifdo_marketing"]["code"]?>">
				<div class="resp_message v2">
					- IFDO 서비스 신청 완료 후, 발급된 사이트 구분 코드를 입력해 주세요.
				</div>
			</td>
		</tr>
		<tr class="display_ifdo_marketing_use hide">
			<th>신청 및 관리</th>
			<td>
<?php if($TPL_VAR["functionLimit"]){?>	
					<a href="#none" onclick="servicedemoalert('use_f');" class="resp_btn active size_XL">신청</a>
					<a href="#none" onclick="servicedemoalert('use_f');" class="resp_btn v2 size_XL">관리</a>					
<?php }else{?>					
					<a href="https://www.firstmall.kr/addservice/ifdo#" class="resp_btn active size_XL" target="_blank">신청</a>
					<a href="https://ifdo.co.kr/login/login_frm.apz" class="resp_btn v2 size_XL" target="_blank">관리</a>
<?php }?>
			</td>
		</tr>
	</table>

	<div class="box_style_05 mt15">
		<div class="title">안내</div>
		<ul class="bullet_hyphen">
			<li>실시간 방문자 확인 및 고객 세분화, 타겟 메세지 발송 등은 IFDO 관리자 페이지에서 가능합니다.</li>
			<li>사이트 구분 코드는 IFDO 관리자 페이지 내 ‘Settings > 분석 스크립트’ 메뉴에서 다시 확인하실 수 있습니다.</li>
			<li>IFDO 분석 도메인 추가 및 해지 등 변경이 필요하신 경우, IFDO 관리자 페이지 내 ‘Account > 사이트 >  정보 수정 > 등록된 도메인’ 메뉴에서 수정할 수 있습니다.</li>
			<li>IFDO 서비스 이용 관련 문의:  02-6346-2662</li>
		</ul>
	</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>