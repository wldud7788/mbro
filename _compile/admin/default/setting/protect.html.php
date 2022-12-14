<?php /* Template_ 2.2.6 2022/05/17 12:37:01 /www/music_brother_firstmall_kr/admin/skin/default/setting/protect.html 000009821 */ 
$TPL_protectIp_1=empty($TPL_VAR["protectIp"])||!is_array($TPL_VAR["protectIp"])?0:count($TPL_VAR["protectIp"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript">
    var gl_bobj = '';
    var gl_pobj = '';    
	$(document).ready(function() {
<?php if($TPL_protectIp_1){foreach($TPL_VAR["protectIp"] as $TPL_V1){?>
		add_banip('<?php echo $TPL_V1?>','append');
<?php }}?>
	});
</script>
<script type="text/javascript" src="/app/javascript/js/admin-settingProtectReady.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-settingProtect.js"></script>
<style>
	.ssl_kind_tbody {display:none;}
    div.all-display-cach    {float:right;}
</style>

<form name="protectSettingForm" method="post" enctype="multipart/form-data" action="../setting_process/protect" target="actionFrame">
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
			<h2>보안</h2>
		</div>
		
		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<button class="resp_btn active2 size_L" type="submit">저장</button>
		</div>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="contents_container">
	<!-- 서브메뉴 바디 : 시작-->
	<div class="contents_dvs">
		<div class="item-title">
			보안서버
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/protect', '#tip1')"></span>
		</div>
		<div class="hide">							
			<ul class="tab_01 tabEvent ">
				<li class="showSslList" 
					data-status="install"
					data-page="1">
					<a href="javascript:void(0);" class="hand current">설치 인증서</a>
				</li>
				<li class="showSslList" 
					data-status="cancel"
					data-page="1" >
					<a href="javascript:void(0);" class="hand">해지 인증서</a>
				</li>
			</ul>			
		</div>

<?php if($TPL_VAR["cfg_system"]["ssl_old"]=='1'){?>
		<div style="margin-top: 10px;margin-bottom: 5px;">
			<span class="desc" style="font-weight:normal;">
				<span class="red" style="font-size: 16px;">
					현재 임의로 설정된 인증서를 사용하고 있습니다. <br/>									
				</span>
				외부 인증서의 경우 퍼스트몰의 1:1 문의를 통해 동기화 요청 해주시기 바랍니다.
				<a href="//www.firstmall.kr/customer/1to1" target="_blank">
					<span class="btn small cyanblue">
						<button type="button">1:1문의 바로가기</button>
					</span>
				</a><br/>
				인증서 정보 :
<?php if($TPL_VAR["cfg_system"]["ssl_external"]=='1'){?>
					<?php echo $TPL_VAR["cfg_system"]["ssl_ex_domain"]?>

<?php }else{?>
					<?php echo $TPL_VAR["cfg_system"]["ssl_domain"]?>

<?php }?>
				(<?php echo $TPL_VAR["cfg_system"]["ssl_period_start"]?>~<?php echo $TPL_VAR["cfg_system"]["ssl_period_expire"]?>)
			</span>
		</div>
<?php }?>

		<div id="showSslLayer"></div>
	</div>

	<div class="box_style_05 mt10">					
		<div class="title">안내</div>
		
		<ul class="bullet_circle ">
			<li class="red">사이트 정보 보안을 위해 보안서버를 반드시 사용해주세요.</li>
			<li>기본으로 제공되는 관리도메인은 SSL인증서(유료/무료) 신청 및 설치가 되지 않습니다.</li>						
			<li>보안서버 인증서 미 설치 시 솔루션기능이 정상적으로 동작하지 않을 수 있으니 반드시 보안서버인증서를 신청하여 주시기 바랍니다.</li>		
			<li>무료 보안서버인증서(Let's Encrypt)의 사용기간은 90일이며 사용기간 종료일 이전에 자동 갱신됩니다.</li>					
		</ul>					
		<div > ※ Let's Encrypt는 무료로 제공되는 보안서버인증서로 Let's Encrypt(https://letsencrypt.org/) 측의 사유로 자동 인증서 갱신 및 서비스 장애가 발생할 수도 있습니다.</div>
	
		<div class="mt10"> 보안서버 구축 의무화</div>

		<ul class="bullet_circle ">
			<li>2012년 8월 18일 정보통신망법 개정으로 개인 정보를 취급하는 모든 웹사이트의 보안서버 구축이 의무화되었습니다. (위반 시 최대 3천만 원의 과태료가 부과되므로 반드시 인증서를 신청하시기 바랍니다.)</li>
			<li>보안서버 인증서(SSL)는 보안서버를 구축하는 한 방법으로, 사용자가 별도의 보안 프로그램을 설치하는 번거로움 없이 웹서버에 설치된 인증서(SSL)를 통해 개인 정보를 암호화하여 전송합니다.</li>						
			<li>보안서버가 적용된 도메인은 리다이렉트 설정 시 https로 전환됩니다.</li>		
			<li>보안서버 인증서(SSL)는 인증서 기간 만료 전 반드시 갱신하셔야 합니다.</li>
			<li>
				보안서버 인증서(SSL)는 MY퍼스트몰 에서 신청하실 수 있습니다.						
				<button type="button" id="btn_ssl_regist" data-href="<?php echo $TPL_VAR["ssllib"]->sslRequestUrl?>" class="resp_btn active"> 신청 </button>
				<a href="https://firstmall.kr/customer/faq/1109" target="_blank" class="resp_btn">SSL설정 안내</a>
			</li>
		</ul>					
	</div>		
	
	<div class="contents_dvs">
		<div class="item-title">접속 차단 IP 설정</div>
		<table class="table_basic thl">				
			<tr>
				<th>
					IP 추가
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/protect', '#tip2')"></span>					
				</th>
				<td>					
					<span class="new_ip_input ">
						<input type="text" value="" size="4" />.
						<input type="text" value="" size="4" />.
						<input type="text" value="" size="4" />.
						<input type="text" value="" size="4" />
					</span>
					<input type="button" class="btn_plus" value="추가" id="btn_add_banip" />	
				</td>
			</tr>

			<tr>
				<th>IP 목록</th>
				<td>
					<table class="table_basic thl wauto">
						<tr>
							<th>
								<span class="search_ip_input ">
									<input type="text" value="" size="4" />.
									<input type="text" value="" size="4" />.
									<input type="text" value="" size="4" />.
									<input type="text" value="" size="4" />
								</span>									
								<input type="button" class="resp_btn active" value="검색" id="btn_search_banip" />
								<input type="button" class="resp_btn" value="초기화" id="btn_reset_banip" />
							</th>
						</tr>
						<tr>
							<td><div id="ip_list"></div></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div class="contents_dvs">
		<div class="item-title">컨텐츠 무단 복사 보호</div>
		<table class="table_basic thl">
			<tr>
				<th>
					마우스 오른쪽 클릭
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/protect', '#tip3')"></span>
				</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="protectMouseRight" value="0" <?php if(!$TPL_VAR["config_system"]["protectMouseRight"]){?>checked="checked"<?php }?> /> 허용</label>
						<label><input type="radio" name=protectMouseRight value="1" <?php if($TPL_VAR["config_system"]["protectMouseRight"]=='1'){?>checked="checked"<?php }?> /> 금지</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>
					마우스 드래그&복사
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/protect', '#tip4')"></span>
				</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="protectMouseDragcopy" value="0" <?php if(!$TPL_VAR["config_system"]["protectMouseDragcopy"]){?>checked="checked"<?php }?> /> 허용</label>
						<label><input type="radio" name=protectMouseDragcopy value="1" <?php if($TPL_VAR["config_system"]["protectMouseDragcopy"]=='1'){?>checked="checked"<?php }?> /> 금지</label>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<!-- 서브메뉴 바디 : 끝 -->
</div>
<!-- 서브 레이아웃 영역 : 끝 -->
</form>


<div id="ssl_info_layer" class="hide">
1. 보안서버 연결 여부<br/>
- 사이트의 보안서버 연결을 확인하려면 브라우저의 보안 상태를 확인하여 주시기 바랍니다. <a target="_blank" href="https://support.google.com/chrome/answer/95617?visit_id=636803676867229208-4082358234&p=ui_security_indicator&rd=1">(자세히보기)</a><br/>
<br/>
2. 유료 보안서버 설치 후 보안관련 문제가 나오는 경우 체크리스트<br/>
 - `https:// 로 전환` 체크가 되어 있는지 확인<br/>
 - 페이지 내 Iframe Url 이 http://로 하드코딩 되어있는지 확인 (ex] 유투브, 네이버동영상, 사이트 등등..)<br/>
 - 페이지 내 이미지가 이미지서버를 사용하거나 다른 도메인의 이미지를 url 그대로 http://로 하드코딩 되어 있는지 여부<br/>
 - Font 나 css 및 script 파일을 http:// 로 연결 하였을 경우<br/>
 - 그 외 http:// 의 Url 을 사용하는 경우<br/>
<br/>
3. 연결 도메인접속 시 정상적인 서비스 불가<br/>
- 인증서 구매 후 보안서버 설치가 완료되면 “대표도메인” 외에 추가 연결된 모든 도메인은 정상적인 서비스가 불가합니다.<br/>
- ※ 인증서 구매 후 추가 도메인 연결은 도메인 구매 업체에서 제공하는 도메인 부가서비스인 도메인 유동 포워딩 서비스 등을 이용해주시기 바랍니다.<br/>
<br/>
4. 인증서 갱신<br/>
- 인증서 만료 시 모바일 인증서도 반드시 같이 연장하셔야 합니다.<br/>
<br/>
</div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>