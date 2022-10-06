<?php /* Template_ 2.2.6 2022/05/17 12:36:23 /www/music_brother_firstmall_kr/admin/skin/default/marketing/marketplace_url.html 000051037 */ 
$TPL_npay_shipping_1=empty($TPL_VAR["npay_shipping"])||!is_array($TPL_VAR["npay_shipping"])?0:count($TPL_VAR["npay_shipping"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	var marketingData = {'npayUse':'<?php echo $TPL_VAR["navercheckout"]["use"]?>','npayVersion':'<?php echo $TPL_VAR["navercheckout"]["version"]?>'};

	$(function(){
		/*도서 공연비 소득 공제 대상 상품*/
		setContentsRadio("navercheckout_culture", "<?php if($TPL_VAR["navercheckout"]["culture"]){?><?php echo $TPL_VAR["navercheckout"]["culture"]?><?php }else{?>n<?php }?>");
		setContentsRadio("talkbuy_culture", "<?php if($TPL_VAR["talkbuy"]["culture"]){?><?php echo $TPL_VAR["talkbuy"]["culture"]?><?php }else{?>n<?php }?>");
		if(location.hash) {
			$("a[href='"+location.hash+"']").trigger("click");
		}
	})
</script>
<script type="text/javascript" src="//pay.naver.com/customer/js/mobile/naverPayButton.js" charset="UTF-8"></script>
<script type="text/javascript" src="//pay.naver.com/customer/js/naverPayButton.js" charset="UTF-8"></script>
<script type="text/javascript" src="/app/javascript/js/admin-shipping.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gCategorySelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gGoodsSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/marketingRegist.js?mm=<?php echo date('Ymd')?>"></script>
<style>
	#lay_npay_btn_style{padding:0};
</style>

<form name="partner" method="post" action="../marketing_process/marketplace" target="actionFrame">

	<!-- 페이지 타이틀 바 : 시작 -->
	<div id="page-title-bar-area">
		<div id="page-title-bar">

			<!-- 타이틀 -->
			<div class="page-title">
				<h2>입점 마케팅</h2>
			</div>

			<!-- 우측 버튼 -->
<?php if($TPL_VAR["visible"]["nbp"]){?>
			<ul class="page-buttons-right">
				<li>
<?php if($TPL_VAR["functionLimit"]){?>
					<button type="button" onclick="servicedemoalert('use_f');" class="resp_btn active2 size_L">저장</button>
<?php }else{?>
					<button type="submit" class="resp_btn active2 size_L">저장</button></li>
<?php }?>
			</ul>
<?php }?>

		</div>
	</div>
	<!-- 페이지 타이틀 바 : 끝 -->

	<!-- Firstmall 입점마케팅 배너 로드 :: 시작 (3.0 및 기타 버전과 맞추기위해 iframe 구성 ) -->
	<div class="center" >
		<iframe id="gabiaPageFrame" src="//firstmall.kr/ec_hosting/marketing/marketplace_url.php?firstmall=yes&shopSno=<?php echo $TPL_VAR["config_system"]["shopSno"]?>&domain=<?php echo $_SERVER["HTTP_HOST"]?>&type=<?php echo $TPL_VAR["config_system"]["service"]["code"]?>&renew=Y&isdemo=<?php echo $TPL_VAR["isdemo"]["isdemo"]?>" width="100%" height="160" frameborder="0"></iframe>
	</div>
	<!-- Firstmall 입점마케팅 배너 로드 :: 끝 -->

	<div class="contents_container">
		<ul class="tab_01 v2 tabEvent">
			<li><a href="#naver" data-showcontent="naver">네이버 쇼핑/페이</a></li>
			<li><a href="#talkbuy" data-showcontent="talkbuy">카카오페이 구매</a></li>
			<li><a href="#daum" data-showcontent="daum" >다음 쇼핑하우</a></li>
			<li><a href="#facebook" data-showcontent="facebook" >페이스북 마케팅</a></li>
			<li><a href="#google" data-showcontent="google" >구글 마케팅</a></li>
		</ul>

		<!-- 네이버 쇼핑 : 시작 -->
		<div class="naver hide">
			<div class="item-title">네이버 쇼핑</div>
			<table class="table_basic thl">
				<tr>
					<th>DB URL 생성</th>
					<td>
						<div class="resp_radio">
<?php if($TPL_VAR["naver_use"]=='Y'){?>
							<!-- Only Naver EP 2.0 -->
							<label><input type="radio" name="naver_use" value="Y" <?php if($TPL_VAR["naver_use"]=='Y'){?>checked<?php }?>> 생성</label>
							<label><input type="radio" name="naver_use" value="N" <?php if($TPL_VAR["naver_use"]=='N'||!$TPL_VAR["naver_use"]){?>checked<?php }?>> 생성 안 함</label>
<?php }else{?>
							<!-- Only Naver EP 3.0 -->
							<label><input type="radio" name="naver_third_use" value="Y" <?php if($TPL_VAR["naver_third_use"]=='Y'){?>checked<?php }?>> 생성</label>
							<label><input type="radio" name="naver_third_use" value="N" <?php if($TPL_VAR["naver_third_use"]=='N'||!$TPL_VAR["naver_third_use"]){?>checked<?php }?>> 생성 안 함</label>
<?php }?>
						</div>
					</td>
				</tr>
				<tr>
					<th>상품 DB URL</th>
					<td>
						<div class="naver-ep-third-guide">
							네이버 쇼핑 입점 도메인 /partner/naver_third
<?php if($TPL_VAR["partner_info"]["naver_third_file_time"]){?>
							<span class="gray">(<?php echo $TPL_VAR["partner_info"]["naver_third_file_time"]?> 생성, <?php echo $TPL_VAR["partner_info"]["naver_third_file_size"]?>kb)</span>
<?php }?>
						</div>

<?php if($TPL_VAR["naver_use"]=='Y'){?>
						<div class="naver-ep-sec-guide">
							<b>[2.0 버전-2016.11.14 이전 쇼핑 입점 고객]</b><br/>
							네이버 쇼핑 입점 도메인 /partner/naver
<?php if($TPL_VAR["partner_info"]["naver_file_time"]){?>
							<span class="gray">(<?php echo $TPL_VAR["partner_info"]["naver_file_time"]?> 생성, <?php echo $TPL_VAR["partner_info"]["naver_file_size"]?>kb)</span>
<?php }?>
						</div>
<?php }?>
					</td>
				</tr>
				<tr>
					<th>
						판매지수 DB URL
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip1', '620')"></span>
					</th>
					<td>
						네이버 쇼핑 입점 도메인 /partner/naver_sales_ep
<?php if($TPL_VAR["partner_info"]["naver_sales_file_time"]){?>
						<span class="gray">(<?php echo $TPL_VAR["partner_info"]["naver_sales_file_time"]?> 생성, <?php echo $TPL_VAR["partner_info"]["naver_sales_file_size"]?>kb)</span>
<?php }?>

<?php if($TPL_VAR["naver_use"]=='Y'){?>
						<div class="naver-ep-sec-guide">
							<b>[2.0 버전-2016.11.14 이전 쇼핑 입점 고객]</b><br/>
							네이버 쇼핑 입점 도메인 /partner/naver?mode=summary
						</div>
<?php }?>
					</td>
				</tr>
				<tr>
					<th>신청 및 관리</th>
					<td>
<?php if($TPL_VAR["functionLimit"]){?>
						<a href="#none" onclick="servicedemoalert('use_f');" class="resp_btn active size_XL">신청</a>
						<a href="#none" onclick="servicedemoalert('use_f');" class="resp_btn v2 size_XL">관리</a>
<?php }else{?>
						<a href="https://adcenter.shopping.naver.com/mall/regist/agreement.nhn?agencyId=gabiacns" class="resp_btn active size_XL" target="_blank">신청</a>
						<a href="https://adcenter.shopping.naver.com/member/login/form.nhn?targetUrl=%2Fmain.nhn" class="resp_btn v2 size_XL" target="_blank">관리</a>
<?php }?>
					</td>
				</tr>
			</table>
		</div>
		<!-- 네이버 쇼핑 : 끝 -->

		<!-- 다음 쇼핑하우 : 시작 -->
		<div class="daum hide">
<?php if($TPL_VAR["arrmarket"]["marketdaum"]=='y'){?>
			<!-- 구버전 EP 생성 부분 -->
			<div class="item-title">(구)DAUM입점 마케팅 파일생성
				<span class="null desc" style="font-weight:normal">상품DB가 많을경우 파일을 미리 생성합니다.</span>
			</div>
			<table class="table_basic thl">
				<tr>
<?php if($TPL_VAR["arrmarket"]["marketdaum"]=='y'){?>
					<th>Daum파일생성</th>
					<td>
						<a href='javascript:make_market_file("<?php echo $TPL_VAR["target_count"]["all"]?>","daum","none")' >파일생성</a>
					</td>
<?php }?>
				</tr>
			</table>
<?php }?>

			<div class="item-title">다음 쇼핑하우</div>

			<table class="table_basic thl">
				<tr>
					<th>DB URL 생성</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="daum_use" value="Y" <?php if($TPL_VAR["daum_use"]=='Y'){?>checked<?php }?>> 생성</label>
							<label><input type="radio" name="daum_use" value="N" <?php if($TPL_VAR["daum_use"]=='N'||!$TPL_VAR["daum_use"]){?>checked<?php }?>> 생성 안 함</label>
						</div>
					</td>
				</tr>
				<tr>
					<th>상품 DB URL</th>
					<td class="clear">
						<table class="table_basic thl v3">
							<tbody>
							<tr>
								<th>
									전체
									<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip3')"></span>
								</th>
								<td>
									쇼핑하우 입점 도메인 /partner/daum_engine
<?php if($TPL_VAR["partner_info"]["daum_file_time"]){?>
									<span class="gray">(<?php echo $TPL_VAR["partner_info"]["daum_file_time"]?> 생성, <?php echo $TPL_VAR["partner_info"]["daum_file_size"]?>kb)</span>
<?php }?>
								</td>
							</tr>
							<tr>
								<th>
									요약
									<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip4')"></span>
								</th>
								<td>쇼핑하우 입점 도메인 /partner/daum_engine?mode=summary</td>
							</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<th>상품평 DB URL</th>
					<td class="clear">
						<table class="table_basic thl v3">
							<tbody>
							<tr>
								<th>전체</th>
								<td>
									쇼핑하우 입점 도메인 /partner/daum_review
<?php if($TPL_VAR["partner_info"]["daum_review_file_time"]){?>
									<span class="gray">(<?php echo $TPL_VAR["partner_info"]["daum_review_file_time"]?> 생성, <?php echo $TPL_VAR["partner_info"]["daum_review_file_size"]?>kb)</span>
<?php }?>
								</td>
							</tr>
							<tr>
								<th>요약</th>
								<td>쇼핑하우 입점 도메인 /partner/daum_review?mode=summary</td>
							</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<th>신청 및 관리</th>
					<td>
<?php if($TPL_VAR["functionLimit"]){?>
						<a href="#none" class="resp_btn active size_XL" onclick="servicedemoalert('use_f');">신청</a>
						<a href="#none" class="resp_btn v2 size_XL" onclick="servicedemoalert('use_f');">관리</a>
<?php }else{?>
						<a href="https://shopping.biz.daum.net/join/step2?jointype=CPC&hosting=gabia" class="resp_btn active size_XL" target="_blank">신청</a>
						<a href="https://commerceone.biz.daum.net" class="resp_btn v2 size_XL" target="_blank">관리</a>
<?php }?>
					</td>
				</tr>
			</table>
		</div>
		<!-- 다음 쇼핑하우 : 끝 -->

		<!-- 페이스북 마케팅 : 시작 -->
		<div class="facebook hide">
			<div class="title_dvs">
				<div class="item-title">페이스북 마케팅</div>
			</div>

			<table class="table_basic thl">
<?php if($TPL_VAR["facebook_pixel_use"]=='Y'&&$TPL_VAR["facebook_pixel"]){?>
				<tr>
					<th>픽셀 ID</th>
					<td><?php echo $TPL_VAR["facebook_pixel"]?></td>
				</tr>
<?php }?>

				<tr>
					<th>제품 피드 URL</th>
					<td>
<?php if($TPL_VAR["facebook_pixel_use"]=='Y'&&$TPL_VAR["facebook_pixel"]){?>
						도메인/partner/facebook
						<span class="gray hide">(<span id="facebook_update"><?php echo $TPL_VAR["partner_info"]["facebook_file_time"]?></span> 생성, <span id="facebook_file_size"><?php echo $TPL_VAR["partner_info"]["facebook_file_size"]?></span>kb)</span>
						<button type="button" id="facebookReload" class="resp_btn v2">URL 갱신</button>
						<button type="button" onclick="confirm_cancel_facebook();" class="resp_btn v2">데이터 전달 종료</button>
<?php }else{?>
						페이스북 마케팅 연동 전
<?php }?>
					</td>
				</tr>
<?php if($TPL_VAR["facebook_pixel_use"]=='Y'&&$TPL_VAR["facebook_pixel"]){?>
				<tr>
					<th>관리</th>
					<td><a href='https://adsapi.gabia.com/pageRedirect?target=/campaign/facebook&params={"shop_hash":"<?php echo $TPL_VAR["shop_hash"]?>"}' class="btn_contract2 resp_btn v2  size_XL" target="_blank" id="goGabiaADs">관리</a></td>
				</tr>
<?php }else{?>
				<tr>
					<th>신청</th>
					<td>
<?php if($TPL_VAR["functionLimit"]){?>
						<a href="#none" onclick="servicedemoalert('use_f');" class="resp_btn active size_XL">신청</a>
<?php }else{?>
						<a href='https://adsapi.gabia.com/pageRedirect?target=/campaign/facebook&params={"shop_hash":"<?php echo $TPL_VAR["shop_hash"]?>"}' class="btn_contract resp_btn active size_XL" target="_blank">신청
						</a>
<?php }?>
					</td>
				</tr>
<?php }?>
			</table>
		</div>
		<!-- 페이스북 마케팅 : 끝 -->

		<!-- 구글 마케팅 : 시작 -->
		<div class="google hide">
			<div class="title_dvs">
				<div class="item-title">구글 마케팅</div>
			</div>
			<input type="hidden" name="google_verification_token" value="<?php echo $TPL_VAR["partner_info"]["google_verification_token"]?>">
			<table class="table_basic thl">
				<tr>
					<th>제품 피드 URL</th>
					<td>
<?php if($TPL_VAR["partner_info"]["google_verification_token"]){?>
						도메인/partner/google <span class="desc">(<span id="google_update"><?php echo $TPL_VAR["partner_info"]["google_file_time"]?></span> 생성, <span id="google_file_size"><?php echo $TPL_VAR["partner_info"]["google_file_size"]?></span>kb)</span>
						<button type="button" id="googleReload" class="resp_btn v2">URL 갱신</button>
<?php }else{?>
						구글 마케팅 연동 전
<?php }?>
					</td>
				</tr>

<?php if($TPL_VAR["partner_info"]["google_verification_token"]){?>
				<tr>
					<th>관리</th>
					<td><a href="https://ads.gabia.com/myads/index" class="btn_contract2 resp_btn v2 size_XL" target="_blank">관리</a></td>
				</tr>
<?php }else{?>
				<tr>
					<th>신청</th>
					<td>
<?php if($TPL_VAR["functionLimit"]){?>
						<a href="#none" onclick="servicedemoalert('use_f');" class="resp_btn active size_XL">신청</a>
<?php }else{?>
						<a href="https://ads.gabia.com/myads/index" class="btn_contract resp_btn active size_XL" target="_blank">신청</a>
<?php }?>
					</td>
				</tr>
<?php }?>
			</table>
		</div>
		<!-- 구글 마케팅 : 끝 -->

		<!-- 카카오페이 구매 : 시작 -->
		<div class="talkbuy hide">
			<div class="item-title">카카오페이 구매 설정</div>
			<!--/setting/_talkbuy_config.html-->
			<!--
			# talkbuy_config
			-->
		</div>
		<!-- 카카오페이 구매 : 끝 -->


		<div class="item-title goods_common_setting">DB URL 공통 설정</div>

		<table class="table_basic thl goods_common_setting">
			<tr>
				<th>상품 DB URL 설정</th>
				<td><button type="button" class="commonInfoBtn resp_btn v2">설정</button></td>
			</tr>
		</table>

		<div class="box_style_05 mt15">
			<div class="title">안내</div>
			<ul class="bullet_hyphen">
				<li>
					<span class="naver hide">네이버 업데이트 주기 : 01시 (일 1회)</span>
					<span class="facebook hide">페이스북 업데이트 주기 : 01시 (일 1회)</span>
					<span class="google hide">구글 업데이트 주기 : 01시 (일 1회)</span>
					<span class="talkbuy hide">카카오페이 구매 업데이트 주기 : 01시 (일 1회)</span>
				</li>
				<li class="daum hide">
					다음 쇼핑하우는 DB URL 이 자동 등록이 되며, 등록 후 상품 데이터가 제대로 전달이 되었는지 반드시 확인을 하셔야 합니다. 
					<a href="https://www.firstmall.kr/customer/faq/10" class="resp_btn_txt" target="_blank">도메인 연결 방법 안내</a>
				</li>
				<li class="daum hide">다음 쇼핑하우 업데이트 주기: 전체 데이터- 1일 1회 자동 생성, 요약 데이터- 실시간 생성</li>
				<li><span class="facebook hide">페이스북 마케팅은 가비아애즈를 통해 서비스를 제공하고 있습니다.</span><span class="google hide">구글 마케팅은 가비아애즈를 통해 서비스를 제공하고 있습니다.</span></li>
				<li class="google hide">구글 마케팅 연동 전, <span class="red">SSL 인증서를  필수로 설정</span>해주시기 바랍니다. <a href="../setting/protect" target="_blank" class="resp_btn_txt">바로 가기</a></li>
				<li>
					DB URL의 입점 도메인은 쇼핑몰에 연결이 필요합니다. 연결 하지 않은 경우, 
					<a href="https://www.firstmall.kr/myshop" target="_blank" class="resp_btn_txt">MY 퍼스트몰</a>
					에서 연결 신청할 수 있습니다. (외부 호스팅 이용 시에는 해당 업체에 문의)
				</li>
				<li>상품 데이터 전달 제외 조건에 해당 되는 경우 상품의 데이터가 전달되지 않습니다. <span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip2')"></span></li>
				<li>데이터 전달 대상 상품은 실물 상품, 패키지/복합상품 입니다. (티켓 상품 전달 불가)</li>
				<li class="naver hide">DB URL 전달 시 상품 리뷰 수는 쇼핑몰의 리뷰만 전달됩니다. (네이버페이의 리뷰 수는 네이버 쇼핑에서 자체 집계)</li>
				<li class="talkbuy hide">설정에서 입력하신 지역별 추가 배송비 금액이 판매 가능한 상품에 공통으로 적용되어 전달됩니다.</li>
				<li class="talkbuy hide">카카오페이 구매는 크롬과 엣지 브라우저에 최적화되어 있습니다. 인터넷 익스플로러에는 카카오페이 구매 버튼이 노출되지 않습니다.</li>
			</ul>
		</div>

		<div class="naver hide">
			<!-- 네이버 페이 설정 :: 시작 -->
			<div class="item-title mt20">네이버 공통 인증 키</div>
			<table class="table_basic thl">
				<tr>
					<th>사용 여부</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="naver_wcs_use" value="y" <?php if($TPL_VAR["config_basic"]["naver_wcs_use"]=='y'){?>checked="checked"<?php }?>/> 사용</label>
							<label><input type="radio" name="naver_wcs_use" value="n" <?php if($TPL_VAR["config_basic"]["naver_wcs_use"]=='n'||$TPL_VAR["config_basic"]["naver_wcs_use"]==''){?>checked="checked"<?php }?>/> 사용 안 함</label>
						</div>
					</td>
				</tr>

				<tr>
					<th>
						네이버 공통 인증키
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip11')"></span>
					</th>
					<td><input type="text" name="naver_wcs_accountid" size="50" class="line" value="<?php echo $TPL_VAR["naver_wcs"]["accountId"]?>" /></td>
				</tr>

				<tr>
					<th>
						White List
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip12')"></span>
					</th>
					<td>
						<table id="checkoutWhitelist" class="table_basic wauto">
							<colgroup>
								<col width="90%" />
								<col width="10%" />
							</colgroup>

							<thead>
							<tr>
								<th>URL</th>
								<th><button type="button" class="btn_plus plusBtn"></button></th>
							</tr>
							</thead>

							<tbody>
<?php if($TPL_VAR["naver_wcs"]["checkoutWhitelist"]){?>
<?php if(is_array($TPL_R1=$TPL_VAR["naver_wcs"]["checkoutWhitelist"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<tr class="cloneTr">
								<td>http:// <input type="text" name="checkoutWhitelist[]" value="<?php echo $TPL_V1?>" size="50" /></td>
								<td><button type="button" class="btn_minus" onClick="trDel(this)"></button></td>
							</tr>
<?php }}?>
<?php }else{?>
							<tr class="cloneTr">
								<td>http:// <input type="text" name="checkoutWhitelist[]" value="" size="50"/></td>
								<td><button type="button" class="btn_minus" onClick="trDel(this)"></button></td>
							</tr>
<?php }?>
							</tbody>
						</table>
					</td>
				</tr>
			</table>

			<div class="item-title">네이버 페이 설정</div>

			<table class="table_basic thl t_select_goods">
				<tr>
					<th>버전</th>
					<td>
<?php if(in_array($TPL_VAR["navercheckout"]["use"],array("y","test"))&&in_array($TPL_VAR["navercheckout"]["version"],array('','1.0'))){?>
						<label><input type="radio" name="navercheckout_ver" value="1.0" class="npay_ver hide" <?php if($TPL_VAR["navercheckout"]["version"]!='2.1'){?>checked="checked"<?php }?> > 상품연동 1.0 / 주문연동 안함</label>
<?php }?>
						<label><input type="radio" name="navercheckout_ver" value="2.1" class="npay_ver hide" <?php if($TPL_VAR["navercheckout"]["version"]=='2.1'||$TPL_VAR["navercheckout"]["version"]==''){?>checked="checked"<?php }?>> 상품연동 2.0  / 주문연동 5.0</label>
					</td>
				</tr>

				<tr>
					<th>사용 여부</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="navercheckout_use" class="navercheckout_use" value="y" <?php if($TPL_VAR["navercheckout"]["use"]=='y'){?>checked="checked"<?php }?> /> 사용</label>
							<label><input type="radio" name="navercheckout_use" class="navercheckout_use" value="test" <?php if($TPL_VAR["navercheckout"]["use"]=='test'){?>checked="checked"<?php }?> /> 테스트</label>
							<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip13')"></span>
							<label><input type="radio" name="navercheckout_use" class="navercheckout_use" value="n" <?php if($TPL_VAR["navercheckout"]["use"]=='n'){?>checked="checked"<?php }?> /> 사용 안 함</label>
						</div>
					</td>
				</tr>

				<tr>
					<th>상점 ID</th>
					<td><input type="text" name="navercheckout_shop_id" size="50" class="line" value="<?php echo $TPL_VAR["navercheckout"]["shop_id"]?>" /></td>
				</tr>

				<tr>
					<th>상점 인증 키<br/>(가맹점 인증 키)</th>
					<td><input type="text" name="navercheckout_certi_key" size="50" class="line" value="<?php echo $TPL_VAR["navercheckout"]["certi_key"]?>"/></td>
				</tr>

				<tr>
					<th>버튼 인증 키</th>
					<td><input type="text" name="navercheckout_button_key" size="50" class="line" value="<?php echo $TPL_VAR["navercheckout"]["button_key"]?>" /></td>
				</tr>

<?php if($TPL_VAR["navercheckout"]["version"]=="2.1"){?>
				<tr>
					<th>버튼 타입 (PC)</th>
					<td>
						<div style="margin: 15px 0;">
							<button type="button" class="resp_btn v2 mr5" onclick="npay_btn_style('pc_goods')">버튼 선택</button>
							<span id="npay_pc_goods_text"><?php echo $TPL_VAR["sel_npay_btn_text"]['pc_goods']?></span>
						</div>
						<table class="table_basic wauto">
							<tr>
								<th>상품상세 페이지</th>
								<th>장바구니 페이지</th>
							</tr>
							<tr>
								<td class="pd10">
									<iframe name="npay_pc_goods" id="npay_pc_goods"  src="../marketing/npay_btn_style_iframe?mode=pc_goods" frameborder=0 border=0 align="center" width="350" height="<?php echo $TPL_VAR["sel_npay_btn_text"]['pc_goods_h']?>"></iframe>
								</td>
								<td class="pd10">
									<iframe name="npay_pc_goods_cart" id="npay_pc_goods_cart"  src="../marketing/npay_btn_style_iframe?mode=pc_goods&type=cart"  frameborder=0 border=0 align="center" width="350" height="<?php echo $TPL_VAR["sel_npay_btn_text"]['pc_goods_h']?>"></iframe>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th>버튼 타입 (MOBILE)</th>
					<td>
						<div style="margin: 15px 0;">
							<button type="button" onclick="npay_btn_style('mobile_goods')" class="resp_btn v2 mr5">버튼 선택</button>
							<span id="npay_mobile_goods_text"><?php echo $TPL_VAR["sel_npay_btn_text"]['mobile_goods']?></span>
						</div>
						<table class="table_basic wauto">
							<tr>
								<th>상품상세 페이지</th>
								<th>장바구니 페이지</th>
							</tr>
							<tr>
								<td class="pd10">
									<iframe name="npay_mobile_goods" id="npay_mobile_goods" src="../marketing/npay_btn_style_iframe?mode=mobile_goods" frameborder=0 border=0 align="center" width="350" height="<?php echo $TPL_VAR["sel_npay_btn_text"]['mobile_goods_h']?>"></iframe>
								</td>
								<td class="pd10">
									<iframe name="npay_mobile_goods_cart" id="npay_mobile_goods_cart" src="../marketing/npay_btn_style_iframe?mode=mobile_goods&type=cart" frameborder=0 border=0 align="center" width="350" height="<?php echo $TPL_VAR["sel_npay_btn_text"]['mobile_goods_h']?>"></iframe>
								</td>
							</tr>
						</table>
					</td>
				</tr>
<?php }?>

				<tr>
					<th>
						상품 연동 제외
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip14', 'sizeM')"></span>
					</th>
					<td class="clear">
						<table class="table_basic thl v3">
							<tbody>
							<tr>
								<th>상품</th>
								<td>
									<input type="button" value="상품 선택" class="btn_select_goods resp_btn active" data-goodstype='except_goods' />
									<span class="span_select_goods_del <?php if(count($TPL_VAR["navercheckout"]["except_goods"])== 0){?>hide<?php }?>"><input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" selectType="goods" /></span>
									<div class="mt10 wx600 <?php if(count($TPL_VAR["navercheckout"]["except_goods"])== 0){?>hide<?php }?>">
										<div class="goods_list_header">
											<table class="table_basic tdc">
												<colgroup>
													<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
													<col width="25%" />
													<col width="45%" />
<?php }else{?>
													<col width="70%" />
<?php }?>

													<col width="20%" />
												</colgroup>
												<tbody>
												<tr>
													<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" onClick="gGoodsSelect.checkAll(this)" value="goods"></label></th>
<?php if(serviceLimit('H_AD')){?>
													<th>입점사명</th>
<?php }?>
													<th>상품명</th>
													<th>판매가</th>
												</tr>
												</tbody>
											</table>
										</div>
										<div class="goods_list">
											<table class="table_basic tdc">
												<colgroup>
													<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
													<col width="25%" />
													<col width="45%" />
<?php }else{?>
													<col width="70%" />
<?php }?>
													<col width="20%" />
												</colgroup>
												<tbody>
												<tr rownum=0 <?php if(count($TPL_VAR["navercheckout"]["except_goods"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
												<td class="center" colspan="4">상품을 선택하세요</td>
												</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->
<?php if(is_array($TPL_R1=$TPL_VAR["navercheckout"]["except_goods"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
												<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
													<td><label class="resp_checkbox"><input type="checkbox" name='except_goodsTmp[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' /></label>
														<input type="hidden" name='except_goods[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' />
														<input type="hidden" name="except_goodsSeq[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["issuegoods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
													<td><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
													<td class='left'>
														<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></div>
														<div class="goodsname">
<?php if($TPL_V1["goods_code"]){?><div>[상품코드:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
															<div><?php echo $TPL_V1["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V1["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 30)?></a></div>
														</div>
													</td>
													<td class='right'><?php echo get_currency_price($TPL_V1["price"], 2)?></td>
												</tr>
<?php }}?>
												</tbody>
											</table>
										</div>
									</div>
								</td>
							</tr>

							<tr>
								<th>카테고리</th>
								<td class="categoryList">
									<input type="button" value="카테고리 선택" class="btn_category_select resp_btn active" />
									<div class="mt10 wx600 category_list  <?php if(count($TPL_VAR["navercheckout"]["except_category_code"])== 0){?>hide<?php }?>">
										<table class="table_basic fix">
											<colgroup>
												<col width="85%" />
												<col width="15%" />
											</colgroup>
											<thead>
											<tr class="nodrag nodrop">
												<th>카테고리명</th>
												<th>삭제</th>
											</tr>
											</thead>
											<tbody>
											<tr rownum=0 <?php if(count($TPL_VAR["navercheckout"]["except_category_code"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
											<td class="center" colspan="2">카테고리를 선택하세요</td>
											</tr>
<?php if(is_array($TPL_R1=$TPL_VAR["navercheckout"]["except_category_code"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
											<tr rownum="<?php echo $TPL_V1["category_code"]?>">
												<td class="center"><?php echo $TPL_V1["category_name"]?></td>
												<td class="center">
													<input type="hidden" name='issueCategoryCode[]' value='<?php echo $TPL_V1["category_code"]?>' />
													<input type="hidden" name="issueCategoryCodeSeq[<?php echo $TPL_V1["category_code"]?>]" value="<?php echo $TPL_V1["issuecategory_seq"]?>" />
													<button type="button" class="btn_minus"  selectType="category" category_seq="<?php echo $TPL_V1["category_code"]?>"></button>
												</td>
											</tr>
<?php }}?>
											</tbody>
										</table>
									</div>
		</div>
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>

		<tr>
			<th>배송비</th>
			<td>
				<button type="button" class="shippingGroupInfoBtn resp_btn v2">보기</button>
			</td>
		</tr>

		<tr>
			<th>도서 공연비<br/>소득 공제 대상 상품</th>
			<td class="clear">
				<ul class="ul_list_02">
					<li>
						<div class="resp_radio">
							<label><input type="radio" name="navercheckout_culture" value="n" <?php if($TPL_VAR["navercheckout"]["culture"]==''||$TPL_VAR["navercheckout"]["culture"]=='n'){?>checked="checked"<?php }?> /> 없음</label>
							<label><input type="radio" name="navercheckout_culture" value="all" <?php if($TPL_VAR["navercheckout"]["culture"]=='all'){?>checked="checked"<?php }?>/> 전체 상품</label>
							<label><input type="radio" name="navercheckout_culture" value="choice" <?php if($TPL_VAR["navercheckout"]["culture"]=='choice'){?>checked="checked"<?php }?>/> 선택 상품</label>
						</div>
					</li>
					<li class="navercheckout_culture_choice hide clear">
						<table class="table_basic thl v3">
							<tbody>
							<tr>
								<th>상품</th>
								<td>
									<input type="button" value="상품 선택" class="btn_select_goods resp_btn active" data-goodstype='culture_goods' />
									<span class="span_select_goods_del <?php if(count($TPL_VAR["navercheckout"]["culture_goods"])== 0){?>hide<?php }?>"><input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" /></span>
									<div class="mt10 wx600 <?php if(count($TPL_VAR["navercheckout"]["culture_goods"])== 0){?>hide<?php }?>">

										<div class="goods_list_header">
											<table class="table_basic tdc">
												<colgroup>
													<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
													<col width="25%" />
													<col width="45%" />
<?php }else{?>
													<col width="70%" />
<?php }?>

													<col width="20%" />
												</colgroup>
												<tbody>
												<tr>
													<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" onClick="gGoodsSelect.checkAll(this)" value="goods"></label></th>
<?php if(serviceLimit('H_AD')){?>
													<th>입점사명</th>
<?php }?>
													<th>상품명</th>
													<th>판매가</th>
												</tr>
												</tbody>
											</table>
										</div>
										<div class="goods_list">
											<table class="table_basic tdc">
												<colgroup>
													<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
													<col width="25%" />
													<col width="45%" />
<?php }else{?>
													<col width="70%" />
<?php }?>
													<col width="20%" />
												</colgroup>
												<tbody>
												<tr rownum=0 <?php if(count($TPL_VAR["navercheckout"]["culture_goods"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
												<td class="center" colspan="4">상품을 선택하세요</td>
												</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->
<?php if(is_array($TPL_R1=$TPL_VAR["navercheckout"]["culture_goods"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
												<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
													<td><label class="resp_checkbox"><input type="checkbox" name='culture_goodsTmp[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' /></label>
														<input type="hidden" name='culture_goods[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' />
														<input type="hidden" name="culture_goodsSeq[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["issuegoods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
													<td><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
													<td class='left'>
														<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></div>
														<div class="goodsname">
<?php if($TPL_V1["goods_code"]){?><div>[상품코드:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
															<div><?php echo $TPL_V1["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V1["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 30)?></a></div>
														</div>
													</td>
													<td class='right'><?php echo get_currency_price($TPL_V1["price"], 2)?></td>
												</tr>
<?php }}?>
												</tbody>
											</table>
										</div>
									</div>
								</td>
							</tr>
							</tbody>
						</table>
					</li>
				</ul>
			</td>
		</tr>

		<tr>
			<th>신청 및 관리</th>
			<td>
<?php if($TPL_VAR["functionLimit"]){?>
				<a href="#none" onclick="servicedemoalert('use_f');" class="resp_btn active size_XL">신청</a>
				<a href="#none" onclick="servicedemoalert('use_f');" class="resp_btn active size_XL">관리</a>
<?php }else{?>
				<a href="https://admin.pay.naver.com/join/step1" class="resp_btn active size_XL" target="_blank">신청</a>
				<a href="https://admin.checkout.naver.com/" class="resp_btn size_XL" target="_blank">관리</a>
<?php }?>
			</td>
		</tr>

		</table>

		<div class="box_style_05 mt15">
			<div class="title">안내</div>
			<ul class="bullet_hyphen">
				<li>네이버 페이는 네이버 담당자의 최종 검수 이후 사용 가능합니다.</li>
				<li>
					네이버 페이 주문금액의 과세/비과세 여부는 '사업자 유형'에 따라 결정됩니다.<br/>
					과세 : 개인사업자중 일반과세자, 법인사업자, 비과세 : 개인사업자중 면세사업자 및 간이과세자
				</li>
				<li>과세/비과세 처리에 대한 자세한 문의는 네이버 페이 고객센터(1588-3819)로 문의해 주세요.</li>
			</ul>
		</div>
	</div>

	<!-- 네이버 페이 설정 :: 끝 -->
	</div>
</form>

<div id="info_event_lay" width="100%" class="hide">
</div>

<!--치환 코드 :: 시작-->
<div id="info_code_lay" class="hide">
	<table class="table_basic">
		<colgroup>
			<col width="30%" />
			<col width="70%" />
		</colgroup>
		<tr>
			<th>치환 코드</th>
			<th>설명</th>
		</tr>
		<tr>
			<td>&#123;product_name&#125;</td>
			<td>판매 상품 > 상품 리스트 > 상품 상세 > 기본 정보: 상품명을 표기</td>
		</tr>
		<tr>
			<td>&#123;product_category&#125;</td>
			<td>판매 상품 > 상품 리스트 > 상품 상세> 카테고리: 대표 카테고리를 표기</td>
		</tr>
		<tr>
			<td>&#123;product_brand&#125;</td>
			<td>판매 상품 > 상품 리스트 > 상품 상세 > 브랜드: 대표 브랜드를 표기</td>
		</tr>
		<tr>
			<td>&#123;product_tag&#125;</td>
			<td>판매 상품 > 상품 리스트 > 상품 상세 > 입점 마케팅 전달 데이터: 검색어를 표기</td>
		</tr>
	</table>

	<div class="resp_message">
		- 치환코드 단독 입력 시, 반드시 상품 상세에서 해당 항목을 확인해주세요.</br>
		- 미입력된 항목의 치환코드 사용 시, 상품 데이터가 전달되지 않습니다.
	</div>

	<div class="footer">
		<button type="button" class="btnLayClose resp_btn v3 size_XL">닫기</button>
	</div>
</div>
<!--치환 코드 :: 끝-->

<!--DB URL 공통 설정 :: 시작-->
<div id="commonInfo" class="hide">
	<form name="partner" method="post" action="../marketing_process/marketplace_dburl" target="actionFrame" style="display: block; height:100%;">
		<div class="content">
			<div class="item-title">상품 정보</div>

			<table class="table_basic thl">
				<tr>
					<th>상품명</th>
					<td>
						<div class="resp_limit_text limitTextEvent">
							<input type="text" name="feed_goods_name" id="feed_goods_name" class="input-box-default-text" size="80" value="<?php if($TPL_VAR["marketing_feed"]["goods_name"]){?><?php echo $TPL_VAR["marketing_feed"]["goods_name"]?><?php }else{?>&#123;product_name&#125;<?php }?>" title="" maxlength="255" value=""/>
						</div>
						<button type="button" class="info_code resp_btn v2">치환 코드</button>
					</td>
				</tr>

				<tr>
					<th>
						브랜드
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip5', 'sizeM')"></span>
					</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="feed_brand_kind" id="feed_brand_kind_1" value="brand" <?php if($TPL_VAR["marketing_feed"]["brand_kind"]=='brand'){?>checked<?php }?> /> 상품 브랜드 정보</label>
							<label><input type="radio" name="feed_brand_kind" id="feed_brand_kind_2" value="addinfo" <?php if($TPL_VAR["marketing_feed"]["brand_kind"]!='brand'){?>checked<?php }?> /> 상품 추가 정보</label>
						</div>
					</td>
				</tr>

				<tr>
					<th>
						가격
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip6')"></span>
					</th>
					<td>
						<label class="resp_checkbox"><input type="checkbox" name="marketing_sale_member" value="Y" <?php if($TPL_VAR["marketing_sale"]["member"]=='Y'){?>checked="checked"<?php }?> /> 회원 할인 : </label>
						<div class="resp_radio">
							<label <?php if($TPL_VAR["marketing_sale"]["member"]=='N'){?>class="disabled"<?php }?>><input type="radio" name="member_sale_type" value="0" <?php if($TPL_VAR["marketing_sale"]["member_sale_type"]!='1'){?>checked="checked"<?php }?> <?php if($TPL_VAR["marketing_sale"]["member"]=='N'){?>disabled<?php }?>/> 비회원가</label>
							<label <?php if($TPL_VAR["marketing_sale"]["member"]=='N'){?>class="disabled"<?php }?>><input type="radio" name="member_sale_type" value="1" <?php if($TPL_VAR["marketing_sale"]["member_sale_type"]=='1'){?>checked="checked"<?php }?> <?php if($TPL_VAR["marketing_sale"]["member"]=='N'){?>disabled<?php }?> /> 회원가 (일반 등급 기준)</label>
						</div><br/>

						<label class="resp_checkbox"><input type="checkbox" name="marketing_sale_coupon" value="Y" <?php if($TPL_VAR["marketing_sale"]["coupon"]=='Y'){?>checked="checked"<?php }?> /> 할인 쿠폰</label>
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip7')"></span>
<?php if(!serviceLimit('H_FR')){?>
						<br/>
						<label class="resp_checkbox"><input type="checkbox" name="marketing_sale_referer" value="Y" <?php if($TPL_VAR["marketing_sale"]["referer"]=='Y'){?>checked="checked"<?php }?> /> 할인 유입경로 적용 (네이버, 다음 쇼핑하우)</label>
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip8')"></span>
<?php }?>
						<br/>
						<label class="resp_checkbox"><input type="checkbox" name="marketing_sale_mobile" value="Y" <?php if($TPL_VAR["marketing_sale"]["mobile"]=='Y'){?>checked="checked"<?php }?> /> 모바일 할인 (네이버, 다음 쇼핑하우)</label>
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip9')"></span>
					</td>
				</tr>

				<tr>
					<th>카드 무이자 할부</th>
					<td>
						<input type="text" name="cfg_card_free" id="cfg_card_free" class="input-box-default-text" size="50" value="<?php if($TPL_VAR["marketing_feed"]["cfg_card_free"]){?><?php echo $TPL_VAR["marketing_feed"]["cfg_card_free"]?><?php }?>" title="" />
						<span class="gray">예) 국민3,삼성2~3(모든 카드 동일 시는 '모든 카드 3개월')</span>
					</td>
				</tr>
			</table>

			<div class="item-title">배송비 정보</div>

			<table class="table_basic thl">
				<tr>
					<th>배송비 설정</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="feed_pay_type" value="free" <?php if(!$TPL_VAR["marketing_feed"]["feed_pay_type"]||$TPL_VAR["marketing_feed"]["feed_pay_type"]=='free'){?>checked<?php }?>> 무료</label>
							<label>
								<input type="radio" name="feed_pay_type" value="fixed" <?php if($TPL_VAR["marketing_feed"]["feed_pay_type"]=='fixed'){?>checked<?php }?>> 유료
								<input type="text" name="feed_std_fixed" class="onlynumber" size="8" value="<?php echo $TPL_VAR["marketing_feed"]["feed_std_fixed"]?>" > <?php if($TPL_VAR["config_system"]['basic_currency']=="KRW"){?>원<?php }else{?><?php echo $TPL_VAR["config_system"]['basic_currency']?><?php }?>
							</label>
							<label>
								<input type="radio" name="feed_pay_type" value="postpay" <?php if($TPL_VAR["marketing_feed"]["feed_pay_type"]=='postpay'){?>checked<?php }?>> 착불
								<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip10')"></span>
								<input type="text" name="feed_std_postpay" class="onlynumber" size="8" value="<?php echo $TPL_VAR["marketing_feed"]["feed_std_postpay"]?>" > <?php if($TPL_VAR["config_system"]['basic_currency']=="KRW"){?>원<?php }else{?><?php echo $TPL_VAR["config_system"]['basic_currency']?><?php }?>
							</label>
						</div>
					</td>
				</tr>

				<tr>
					<th>배송 안내 문구</th>
					<td>
						<div class="resp_limit_text limitTextEvent">
							<input type="text" name="feed_add_txt" id="feed_add_txt" value="<?php echo $TPL_VAR["marketing_feed"]["feed_add_txt"]?>" title="" size="60" maxlength="50">
						</div>
					</td>
				</tr>
			</table>

			<div class="item-title">이미지 설정</div>

			<table class="table_basic thl">
				<tr>
					<th>네이버 쇼핑</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="naverImage" value="B" <?php if($TPL_VAR["marketing_image"]["naverImage"]=='B'||!$TPL_VAR["marketing_image"]["naverImage"]){?>checked<?php }?>/>상품 상세 (기본)</label>
							<label><input type="radio" name="naverImage" value="C" <?php if($TPL_VAR["marketing_image"]["naverImage"]=='C'){?>checked<?php }?>/>상품 상세 (확대)</label>
						</div>
					</td>
				</tr>

				<tr>
					<th>다음 쇼핑하우</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="daumImage" value="B" <?php if($TPL_VAR["marketing_image"]["daumImage"]=='B'||!$TPL_VAR["marketing_image"]["daumImage"]){?>checked<?php }?>/>상품 상세 (기본)</label>
							<label><input type="radio" name="daumImage" value="C" <?php if($TPL_VAR["marketing_image"]["daumImage"]=='C'){?>checked<?php }?>/>상품 상세 (확대)</label>
						</div>
					</td>
				</tr>

				<tr>
					<th>페이스북 마케팅</th>
					<td>상품 상세 (확대)</td>
				</tr>
			</table>
		</div>

		<div class="footer">
			<button type="submit" class="confirmPopupInfoBtn resp_btn active size_XL">저장</button>
			<button type="button" class="btnLayClose resp_btn v3 size_XL">취소</button>
		</div>
	</form>
</div>
<!--DB URL 공통 설정 :: 끝-->

<!--네이버페이 가능 배송그룹 :: 시작-->
<div id="shippingGroupInfo" class="hide">
	<div class="content">
		<table class="table_basic tdc">
			<colgroup>
<?php if(serviceLimit('H_AD')){?>
				<col width="21%" />
<?php }?>
				<col width="21%" />
				<col width="21%" />
				<col width="23%" />
				<col width="14%" />
			</colgroup>
			<tr>
<?php if(serviceLimit('H_AD')){?>
				<th>판매자</th>
<?php }?>
				<th>가능 배송그룹</th>
				<th>가능 배송방법</th>
				<th>연결된상품</th>
				<th>관리</th>
			</tr>

<?php if($TPL_VAR["npay_shipping"]){?>
<?php if($TPL_npay_shipping_1){foreach($TPL_VAR["npay_shipping"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if(count($TPL_V2["shipping_set"])> 0){?>
			<tr>
<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_I2== 0){?>
				<td rowspan="<?php echo count($TPL_V1)?>"><?php echo $TPL_V2["provider_info"]?></td>
<?php }?>
<?php }?>
				<td><?php echo $TPL_V2["shipping_group_name"]?>(<?php echo $TPL_V2["shipping_group_seq"]?>)</td>
				<td><?php echo implode("<br/>",$TPL_V2["shipping_set"])?></td>
				<td>
					<input name="modify_btn" onclick="window.open('/admin/goods/package_catalog?ship_grp_seq=<?php echo $TPL_V2["shipping_group_seq"]?>');" type="button" value="패키지 : <?php echo $TPL_V2["rel_goods_cnt"]['package']?>개" class="resp_btn"></span>
					<input name="modify_btn" onclick="window.open('/admin/goods/catalog?ship_grp_seq=<?php echo $TPL_V2["shipping_group_seq"]?>');" type="button" value="상품 : <?php echo $TPL_V2["rel_goods_cnt"]['goods']?>개" class="resp_btn"></span>
				</td>
				<td>
<?php if($TPL_V2["shipping_provider_seq"]> 1){?>
					<input name="modify_btn" onclick="window.open('/admin/setting/shipping_group_regist?provider_seq=<?php echo $TPL_V2["shipping_provider_seq"]?>&provider_name=<?php echo $TPL_V2["provider_info"]?>&shipping_group_seq=<?php echo $TPL_V2["shipping_group_seq"]?>');" type="button" value="수정" class="resp_btn v2">
<?php }else{?>
					<input name="modify_btn" onclick="window.open('/admin/setting/shipping_group_regist?shipping_group_seq=<?php echo $TPL_V2["shipping_group_seq"]?>');" type="button" value="수정" class="resp_btn v2">
<?php }?>
				</td>
			</tr>
<?php }?>
<?php }}?>
<?php }}?>
<?php }else{?>
			<tr>
				<td id="no_npay_shipping" colspan="<?php if(serviceLimit('H_AD')){?>5<?php }else{?>4<?php }?>">
					네이버페이 결제가 가능한 배송그룹이 없습니다.
				</td>
			</tr>
<?php }?>
		</table>

		<div class="box_style_05 mt15">
			<div class="title">안내</div>
			<ul class="bullet_hyphen">
				<li>네이버페이 배송비 규정에 의해 위의 배송그룹으로 연결된 상품만 네이버페이 결제가 가능합니다.</li>
				<li>주소 오류, 네이버페이 통신 오류 등으로 배송비가 추가 과금 또는 누락될 수 있습니다. 이점 유의하시기 바랍니다.</li>
				<li>네이버 배송비 규정 <a href="https://www.firstmall.kr/customer/faq/1098" class="resp_btn_txt" target="_blank">자세히 보기</a></li>
				<li>새로운 배송그룹 추가를 원하는 경우 설정 > <a href="/admin/setting/shipping_group" class="resp_btn_txt" target="_blank">배송비</a>에서 추가해주세요.</li>
			</ul>
		</div>
	</div>

	<div class="footer">
		<button type="button" class="btnLayClose resp_btn v3 size_XL">닫기</button>
	</div>
</div>
<!--네이버페이 가능 배송그룹 :: 끝-->

<!-- 네이버페이 연동버전 업그레이드 신청 -->
<div id="npay_ver2_lay" class="hide">
	<div style="width:600px;">
		<form name="naverpay_upgrade" method="post" target="actionFrame">
			<div class="center mt10">
				<img src="/admin/skin/default/images/design/naverpay_pop.png">
			</div>

			<div style="width:570px;margin:15px auto;">
				<p class="mt20 fx12 bold red">※ 필독</p>
				<p class="mt10 fx12">
					상품연동 2.0으로 업그레이드 하시면 퍼스트몰에서 주문처리도 가능해집니다.<br />
					단, 업그레이드 신청처리는 <span class='red'>매주 목요일 ( 영업일 기준) 오전 10시에 순차적으로 진행</span>됩니다.
				</p>
				<p class="mt10" style="line-height:18px;">
				<ul class="fx12">
					<li class='red'>· 업그레이드 처리 소요시간은 영업일 기준 3 ~ 4일 소요됩니다.</li>
					<li>· 신청 진행중에는 네이버페이  버튼이 노출되지 않습니다.(사용여부:”테스트”로 자동변경)<br />
						&nbsp;&nbsp;&nbsp;※ ”테스트”모드로 자동 변경된 후 업그레이드 완료 전까지는 모드를 변경하시면 안됩니다.</li>
					<li>· 신청 후 업그레이드가  완료되면 완료안내 메일을 보내드리며, <span class='red'>메일 확인 후 사용여부를 [사용]으로<br />
						&nbsp;&nbsp;&nbsp;변경해주셔야 페이버튼이 정상 노출됩니다.</span></li>
					<li>· 페이버튼 노출 후 실환경에서 추가 테스트가 진행됩니다.(정상 주문 및 수집 가능)</li>
					<li>· 상품연동 2.0으로 변경 후 1.0으로 변경불가 합니다.</li>
				</ul>
				</p>
				<p class="mt10 fx12">
				<table width="100%" class="info-table-style">
					<col width="175" /><col  />
					<tr>
						<th class="its-th">페이가맹점 ID</th>
						<td class="its-td"><input type="text" name="naverpay_mall_id" value="<?php echo $TPL_VAR["navercheckout"]["naverpay_mall_id"]?>" style="width:94%;"></td>
					</tr/>
					<tr>
						<th class="its-th"><strong>이메일주소</strong></th>
						<td class="its-td">
							<input type="text" name="naverpay_email[]" value="" style="width:19%;">
							@ <input type="text" name="naverpay_email[]" value="" style="width:33%;" class="emailListInput">

							<select style="width:33%;height:25px;" name="emailList">
								<option value="">직접입력</option>
<?php if(is_array($TPL_R1=code_load('email'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["codecd"]?>"><?php echo $TPL_V1["value"]?></option>
<?php }}?>
							</select>
							<div class='red mt10' style="line-height:14px;">※적용완료시점에 이메일 발송으로 안내가 되오니 바로 확인이 가능한 이메일 주소를 적어주세요.</div>

						</td>
					</tr/>
					<tr>
						<th class="its-th">휴대폰번호</th>
						<td class="its-td">
							<input type="text" name="naverpay_user_phone" value="" style="width:94%;">
							<div class='red mt10' style="line-height:14px;">※이메일 발송 시점에 SMS를 보내드리오니 확인 가능한 휴대폰 번호를 넣어주세요.</div>
						</td>
					</tr/>
				</table>
				</p>
				<p class="mt10 center">
					<span class="btn large black"><button  type="button" id="naverpay_upgrade">업그레이드 신청</button></span>
				</p>
			</div>
		</form>
	</div>
</div>

<div id="lay_npay_btn_style" class="hide">
	<iframe name="npay" id="npay" frameborder=0 border=0 src="" style="width:100%;height:100%;" scrolling="no"></iframe>
</div>

<div id="lay_goods_select"></div><!-- 상품선택 레이어 -->
<div id="lay_category_select"></div><!-- 카테고리 선택 레이어 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>