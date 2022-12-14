<?php /* Template_ 2.2.6 2022/05/17 12:37:07 /www/music_brother_firstmall_kr/admin/skin/default/statistic_ga/regist.html 000009502 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
<script type="text/javascript">
	$(function(){

		setContentsRadio("ga_visit", "<?php if($TPL_VAR["ga_auth"]["ga_visit"]){?><?php echo $TPL_VAR["ga_auth"]["ga_visit"]?><?php }else{?>N<?php }?>");
		setContentsRadio("ga_commerce", "<?php if($TPL_VAR["ga_auth"]["ga_commerce"]){?><?php echo $TPL_VAR["ga_auth"]["ga_commerce"]?><?php }else{?>N<?php }?>");

		$(".page-manual-btn").hide();

		setContentsRadio("ga4_visit", "<?php if($TPL_VAR["ga4_auth"]["ga4_visit"]){?><?php echo $TPL_VAR["ga4_auth"]["ga4_visit"]?><?php }else{?>N<?php }?>");
		setContentsRadio("ga4_commerce", "<?php if($TPL_VAR["ga4_auth"]["ga4_commerce"]){?><?php echo $TPL_VAR["ga4_auth"]["ga4_commerce"]?><?php }else{?>N<?php }?>");

	});

	var authCheck = function(){
		ga_visit = $('input[name="ga_visit"]:radio:checked').val();
		ga_commerce = $('input[name="ga_commerce"]:radio:checked');
		ga_commerce_plus = $('input[name="ga_commerce_plus"]:radio:checked');
		ga_commerce_chk = ga_commerce.val();
		ga_commerce_plus_chk = ga_commerce_plus.val();
		ga4_visit = $('input[name="ga4_visit"]:radio:checked').val();
		ga4_commerce = $('input[name="ga4_commerce"]:radio:checked');
		ga4_commerce_chk = ga4_commerce.val();

		if (ga_commerce.prop("disabled")) ga_commerce_chk = "N";
		if (ga_commerce_plus.prop("disabled")) ga_commerce_plus_chk = "N";

		if (ga4_commerce.prop("disablied")) ga4_commerce_chk = "N";

		if(ga_visit == "Y" && $.trim($("#ga_id").val()) == ""){
			openDialogAlert("추적ID는 필수 항목입니다.",'400','150',function(){});
			return;
		}

		if (ga4_visit == "Y" && $.trim($("#ga4_id").val()) == "") {
			openDialogAlert("측정ID는 필수 항목입니다.","400",'150',function(){});
			return;
		}

		if(ga_visit == "N" && (ga_commerce == "Y" || ga_commerce_plus == "Y")){
			openDialogAlert("방문 통계를 사용으로 체크해주세요",'400','150',function(){});
			return;
		}else if(ga_commerce == "N" && ga_commerce_plus == "Y"){
			openDialogAlert("전자상거래를 사용으로 체크해주세요",'400','150',function(){});
		}else{
			$("#gaSettingForm").submit();
		}

	};
</script>

<form name="gaSettingForm" id="gaSettingForm" method="post" action="../statistic_process/ga_setting" target="actionFrame">
	<!-- 페이지 타이틀 바 : 시작 -->
	<div id="page-title-bar-area">
		<div id="page-title-bar">
			<!-- 타이틀 -->
			<div class="page-title"><h2>구글 애널리틱스</h2></div>

			<!-- 우측 버튼 -->
			<ul class="page-buttons-right">
				<li>
					<button type="button" onclick="authCheck();" class="resp_btn active2 size_L">저장</button>
				</li>
			</ul>
		</div>
	</div>
	<!-- 페이지 타이틀 바 : 끝 -->

	<div class="contents_container">
		<ul class="tab_01 v2 tabEvent">
			<li><a href="javascript:void(0);" data-showcontent="tabCon1" class="current">구글애널리틱스4</a></li>
			<li><a href="javascript:void(0);" data-showcontent="tabCon2">구글애널리틱스 유니버셜</a></li>
		</ul>

		<div id="tabCon1">
			<div class="item-title">연결 설정</div>

			<table class="table_basic thl">
				<tr>
					<th>사용설정</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="ga4_visit" value="Y" <?php if($TPL_VAR["ga4_auth"]["ga4_visit"]=="Y"){?>checked<?php }?>/> 사용</label>
							<label><input type="radio" name="ga4_visit" value="N" <?php if($TPL_VAR["ga4_auth"]["ga4_visit"]=="N"){?>checked<?php }?>/> 사용 안 함</label>
						</div>
					</td>
				</tr>

				<tr class="ga4_visit_Y hide">
					<th>측정 ID</th>
					<td>
						<input type="text" name="ga4_id" id="ga4_id" value="<?php echo $TPL_VAR["ga4_auth"]["ga4_id"]?>" size="25"/>
						<div class="resp_message v2">
							- 구글 애널리틱스에서 생성한 ‘G-*******’ 형식의 측정ID를 입력하세요. <a href="https://www.firstmall.kr/customer/faq/1744" target="_blank" class="resp_btn_txt">자세히 보기</a>
						</div>
					</td>
				</tr>

				<tr class="ga4_visit_Y hide">
					<th>
						전자 상거래
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/statistic', '#tip9')"></span>
					</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="ga4_commerce" value="Y" <?php if($TPL_VAR["ga4_auth"]["ga4_commerce"]=="Y"){?>checked<?php }?>/> 사용</label>
							<label><input type="radio" name="ga4_commerce" value="N" <?php if($TPL_VAR["ga4_auth"]["ga4_commerce"]!="Y"){?>checked<?php }?>/ /> 사용 안 함</label>
						</div>
						<div class="resp_message v2">
							- 구매 전환에 대한 수치를 측정할 수 있습니다. <a href="https://www.firstmall.kr/customer/faq/1745" target="_blank" class="resp_btn_txt">자세히 보기</a>
						</div>
					</td>
				</tr>
			</table>

			<div class="box_style_05 mt15">
				<div class="title">안내</div>
				<ul class="bullet_hyphen">
					<li>구글 애널리틱스 4 FAQ <a href="https://www.firstmall.kr/customer/faq/1742" target="_blank" class="resp_btn_txt">자세히 보기</a></li>
					<!-- <li>구글 애널리틱스 4 앱 데이터 수집 설정방법 <a href="https://www.firstmall.kr/customer/faq/1743" target="_blank" class="resp_btn_txt">자세히 보기</a></li> -->
				</ul>
			</div>
		</div>

		<div id="tabCon2" class="hide">
			<div class="item-title">
				연결 설정
				<span class="fr">
                    <button type="button" class="resp_btn" onclick="window.open('//interface.firstmall.kr/firstmall_plus/ga.php?shop=1','demo','width=1020px,height=830px')">가이드 맵</button>
                    <a href="https://www.firstmall.kr/addservice/google" target="_blank" class="resp_btn">서비스 안내</a>
                </span>
			</div>

			<table class="table_basic thl">
				<tr>
					<th>
						사용설정
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/statistic', '#tip1')"></span>
					</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="ga_visit" value="Y" <?php if($TPL_VAR["ga_auth"]["ga_visit"]=="Y"){?>checked<?php }?>/> 사용</label>
							<label><input type="radio" name="ga_visit" value="N" <?php if($TPL_VAR["ga_auth"]["ga_visit"]!="Y"){?>checked<?php }?>/> 사용 안 함</label>
						</div>
					</td>
				</tr>

				<tr class="ga_visit_Y hide">
					<th>추적 ID (tracking ID)</th>
					<td>
						<input type="text" name="ga_id" id="ga_id" value="<?php echo $TPL_VAR["ga_auth"]["ga_id"]?>" size="25"/>
						<div class="resp_message v2">
							- 추적 ID (tracking ID) 발급 <a href="https://www.firstmall.kr/customer/faq/1248" target="_blank" class="resp_btn_txt">자세히 보기</a>
						</div>
					</td>
				</tr>
			</table>

			<div class="item-title ga_visit_Y hide">고급 설정</div>

			<table class="table_basic thl ga_visit_Y hide">
				<tr>
					<th>
						전자 상거래
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/statistic', '#tip2')"></span>
					</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="ga_commerce" value="Y" <?php if($TPL_VAR["ga_auth"]["ga_commerce"]=="Y"){?>checked<?php }?>/> 사용</label>
							<label><input type="radio" name="ga_commerce" value="N" <?php if($TPL_VAR["ga_auth"]["ga_commerce"]!="Y"){?>checked<?php }?>/> 사용 안 함</label>
						</div>
						<div class="resp_message v2">
							- 전자 상거래 설정 방법 <a href="https://www.firstmall.kr/customer/faq/1249" target="_blank" class="resp_btn_txt">자세히 보기</a>
						</div>
					</td>
				</tr>

				<tr class="ga_commerce_Y">
					<th>
						향상된 전자 상거래
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/statistic', '#tip3')"></span>
					</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="ga_commerce_plus" value="Y" <?php if($TPL_VAR["ga_auth"]["ga_commerce"]=="Y"&&$TPL_VAR["ga_auth"]["ga_commerce_plus"]=="Y"&&!$TPL_VAR["service_limit"]){?>checked<?php }?>/> 사용</label>
							<label><input type="radio" name="ga_commerce_plus" value="N" <?php if($TPL_VAR["ga_auth"]["ga_commerce"]!="Y"||($TPL_VAR["ga_auth"]["ga_commerce_plus"]!="Y"&&!$TPL_VAR["service_limit"])){?>checked<?php }?>/> 사용 안 함</label>
						</div>
						<div class="resp_message v2">
							- 향상된 전자 상거래 설정 방법 <a href="https://www.firstmall.kr/customer/faq/1250" target="_blank" class="resp_btn_txt">자세히 보기</a>
						</div>
					</td>
				</tr>
			</table>

			<div class="box_style_05 mt15">
				<div class="title">안내</div>
				<ul class="bullet_hyphen">
					<li>구글 애널리틱스 유니버셜 FAQ <a href="https://www.firstmall.kr/customer/faq/1246" target="_blank" class="resp_btn_txt">자세히 보기</a></li>
					<li>퍼스트몰 전용 대시 보드 생성 <a href="https://www.google.com/analytics/web/template?uid=VWP82-MGQDKQdsrJDwOLIA" target="_blank" class="resp_btn_txt">자세히 보기</a></li>
				</ul>
			</div>
		</div>
	</div>
</form>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>