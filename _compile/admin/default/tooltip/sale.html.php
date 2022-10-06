<?php /* Template_ 2.2.6 2022/05/17 12:37:24 /www/music_brother_firstmall_kr/admin/skin/default/tooltip/sale.html 000007592 */ ?>
<div id="tip1" class="tip_wrap">
	<h1>세금 계산서</h1>

	<div class="con_wrap">	
		<ul class="bullet_circle_in list_01">
			<li>
				세금 계산서 처리 방법
				<ul class="bullet_num_in gray list_01">
					<li>
						하이웍스 전자세금계산서 서비스 연동
						<ul class="bullet_hyphen">
							<li>세금계산서 신청 정보를 하이웍스로 전송하여 전자세금계산서 발행을 처리할 수 있습니다. 단, 시스템 연동을 위하여 하이웍스 서비스를 신청해주세요.</li>						
						</ul>
					</li>
					<li>
						미연동 처리
						<ul class="bullet_hyphen">
							<li>관리자가 수동으로 세금계산서를 처리합니다.</li>						
						</ul>
					</li>
				</ul>				
			</li>	
		</ul>
	</div>
</div>

<div id="tip2" class="tip_wrap">
	<h1>하이웍스 연동</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>일반 과세 사업자 세금계산서를 사용하기 위해서는 하이웍스에서 신청한 정보를 입력 해야 합니다.</li>	
			<li>하이웍스(메일)은 <a href="https://www.firstmall.kr/myshop" class="link_blue_01" target="_blank">MY퍼스트몰</a>에서 신청할 수 있습니다.</li>	
			<li>하이웍스(메일) 신청 후 발급 받은 연동키를 입력하여 사용할 수 있습니다.</li>	
		</ul>
	</div>
</div>

<div id="tip3" class="tip_wrap">	
	<h1>현금 영수증 중복 발행 유의사항</h1>

	<ul class="bullet_circle list_01 con_wrap">
		<li>
			<b>중복 발행되는 경우 처리 방법 </b>
			<ul class="bullet_hyphen">
				<li>
					구매자가 결제페이지에서 현금영수증 신청하고 결제창에서도 현금영수증 신청하는 경우 현금영수증이 중복발행 됩니다. 따라서, 결제창에서는 현금영수증이 신청되지 않도록 조치해 주시기 바랍니다.<br/>
					<img src="/admin/skin/default/images/design/pg/img_setting_taxsave_overlap.gif" width="97%" />
				</li>					
			</ul>		
		</li>
		
		<li>
			<b>전자결제(PG)별 결제 창에서의 현금영수증 신청 제어 방법</b><br/>
			<div class="resp_radio">
				<label><input type="radio" name="comment_cash_info" onclick="view_comment_cash_info(this)" value="kcp" checked/> KCP 이용 상점</label>
				<label><input type="radio" name="comment_cash_info" onClick="view_comment_cash_info(this)" value="inicis"/> 이니시스 이용 상점</label>
				<label><input type="radio" name="comment_cash_info" onClick="view_comment_cash_info(this)" value="lg"/> 토스페이먼츠 이용 상점</label>
				<label><input type="radio" name="comment_cash_info" onClick="view_comment_cash_info(this)" value="allat"/> 모빌리언스 이용 상점	</label>
				<label><input type="radio" name="comment_cash_info" onClick="view_comment_cash_info(this)" value="ksnet" /> KSNET 이용 상점</label>							
			</div>
						
			<div class="comment_cash_info comment_cash_info_kcp">
				<ul class="cash_info_contents">
					<li>
						KCP관리자페이지(<a href="https://admin.kcp.co.kr" target="_blank"><span class="blue">https://admin.kcp.co.kr</span></a>)에서 현금영수증 발급 설정을 “사용안함”으로 변경하여 주세요.
					</li>
				</ul>

				<div style="padding-top:16px;"></div>
				<div style="border-top:1px dashed #dddddd;width:100%;"></div>
				<div style="padding-top:36px;"></div>
				<div>
					<img src="/admin/skin/default/images/design/pg/img_setting_taxsave_kcp.gif" />
				</div>
			</div>

			<div class="comment_cash_info comment_cash_info_inicis hide">
				<ul class="cash_info_contents">
					<li>
						KG Inicis관리자페이지(<a href="https://iniweb.inicis.com" target="_blank"><span class="blue">https://iniweb.inicis.com</span></a>)에서 현금영수증 사용 설정을 “자진발급”에 체크를 풀어주세요.
					</li>
					<li>
						KG Inicis는 일반결제와 에스크로결제 관리자가 분리되어 있어, 일반결제 관리자 계정과 에스크로관리자 계정에 각각 로그인하여 “자진발급”에 체크를 풀어주셔야 합니다.
					</li>
				</ul>
				<div style="padding-top:16px;"></div>
				<div style="border-top:1px dashed #dddddd;width:100%;"></div>
				<div style="padding-top:36px;"></div>
				<div>
					<img src="/admin/skin/default/images/design/pg/img_setting_taxsave_inisis.gif" width="100%" />
				</div>
			</div>

			<div class="comment_cash_info comment_cash_info_lg hide">
				<ul class="cash_info_contents">
					<li>
						토스페이먼츠 이용 상점은 사용안함으로 자동 설정되어 있기 때문에 별도 설정이 필요하지 않습니다.
					</li>
				</ul>
			</div>

			<div class="comment_cash_info comment_cash_info_allat hide">
				<ul class="cash_info_contents">
					<li>
						모빌리언스 고객센터(02-3783-9990 )에 현금영수증 자진발급 사용 제한을 요청하여 주셔야 합니다.
					</li>
				</ul>
			</div>

			<div class="comment_cash_info comment_cash_info_ksnet hide">
				<ul class="cash_info_contents">
					<li>
						KSNET 이용 상점은 사용안함으로 자동 설정되어 있기 때문에 별도 설정이 필요하지 않습니다.
					</li>
				</ul>
			</div>

			<div class="comment_cash_info comment_cash_info_kicc hide">
				<ul class="cash_info_contents">
					<li>
						이지페이 이용 상점은 사용안함으로 자동 설정되어 있기 때문에 별도 설정이 필요하지 않습니다.
					</li>
				</ul>
			</div>
			
		</li>	
	</ul>	
</div>

<div id="tip4" class="tip_wrap">
	<h1>연동키 입력 안내</h1>

	<div class="con_wrap">
		<ul class="bullet_num gray">
			<li><a href="https://www.firstmall.kr/myshop" class="link_blue_01" target="_blank">MY퍼스트몰</a> 이동</li>	
			<li>설정을 원하는 도메인을 선택합니다.</li>	
			<li>해당 도메인 상세에서 '전자세금계산서-하이웍스'의 [관리]를 선택합니다.</li>
			<li>제공되는 API 연동 정보를 하이웍스 연동정보에 입력합니다.</li>
		</ul>
	</div>
</div>

<div id="tip5" class="tip_wrap">
	<h1>국내 PG 사용 여부</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen gray">
			<li>국내 PG 사용 여부는 설정 > <a href="/admin/setting/pg" class="link_blue_01" target="_blank">전자결제</a> 에서 국내 결제 PG 사용 시, 자동 연동됩니다.</li>
		</ul>
	</div>
</div>

<div id="tip6" class="tip_wrap">
	<h1>현금 영수증 의무 발행</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen gray">
			<li>현금 영수증 의무발행 업종에 해당하는 사업체의 경우 10만원 이상의 재화 또는 용역 공급에 대해서 현금 영수증을 의무로 발행해야 합니다.</li>
			<li>소비자 현금 영수증 발급을 원하지 않는 경우 또는 소비자의 인적 사항을 모르는 경우 국세청 지정 코드(010-000-1234)로 자동 발급됩니다.</li>
			<li>의무발행 업종 사업자는 현금영수증 미발행 적발 시, 과태료가 부과될 수 있습니다.(법인세법 제117조의 제 4항, 구 조세범 처벌법 제 15조)</li>
			<li>현금 영수증 의무발행 업종 <a href="https://www.firstmall.kr/customer/faq/1195" class="link_blue_01" target="_blank">자세히 보기></a></li>
		</ul>
	</div>
</div>