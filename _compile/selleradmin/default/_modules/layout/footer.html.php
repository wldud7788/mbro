<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/_modules/layout/footer.html 000020430 */ ?>
<!--[ 레이아웃 바디(본문) : 끝 ]-->
		</div>
		</div>

	</div>
<?php if($_GET["debug"]){?>
	<iframe name="actionFrame" id="actionFrame" src="/data/index.php" frameborder="1" width="100%" height="1000" ></iframe>
<?php }else{?>
	<iframe name="actionFrame" id="actionFrame" src="/data/index.php" frameborder="0" width="100%" height="0" class="hide"></iframe>
<?php }?>
</div>

<!-- 답버튼 -->
<a href="#layout_header" class="ico_floating_top off" title="위로 가기"></a>

<div id="openDialogLayer" class="hide">
	<div align="center" id="openDialogLayerMsg"></div>
</div>

<div id="goodsSelectDialog" class="hide"></div>

<div id="ajaxLoadingLayer" class="hide"></div>

<div id="qrcodeGuideLayer" class="hide" style="padding:10px;"></div>

<style type="text/css">
#addsaleGuideLayer .GuideTitle {height:40px;line-height:40px;font-size:14px;text-align:center;border:1px solid #aaaaaa;background-color:#f1f1f1;font-weight:bold;}
#addsaleGuideLayer ul.addsaleGuideLayer li {padding-top:5px;font-size:11px;}
table.info-table-style td.bgyellow {background-color:#fffeca;}
</style>
<div id="addsaleGuideLayer" class="hide">
	<div class="GuideTitle">소비자에게 다양한 추가 혜택 제공으로 매출을 높이십시오.</div>
	<div class="item-title">
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr><td>추가 혜택 세팅</td></tr>
		</table>
	</div>
	<div>
		<table class="info-table-style" style="margin:auto;" width="100%">
		<colgroup>
			<col width="15%" />
			<col width="30%" />
			<col />
			<col width="20%" />
		</colgroup>
		<thead>
		<tr>
			<th class="its-th-align center">추가 혜택</th>
			<th class="its-th-align center">세팅</th>
			<th class="its-th-align center">조건</th>
			<th class="its-th-align center">혜택</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<th class="its-th-align center">복수구매</th>
			<td class="its-td-align left pdl5">상품 > <a href="../goods/catalog" target="_blank"><span class="highlight-link">상품리스트</span></a></td>
			<td class="its-td-align left pdl5">한 상품을 여러 개를 구매하였을 때</td>
			<td class="its-td-align left pdl5">추가 할인</td>
		</tr>
		<tr>
			<th class="its-th-align center">이벤트</th>
			<td class="its-td-align left pdl5">프로모션 > <a href="../event/catalog" target="_blank"><span class="highlight-link">할인 이벤트</span></a></td>
			<td class="its-td-align left pdl5">이벤트 상품을 구매하였을 때</td>
			<td class="its-td-align left pdl5">추가 할인 및 추가 적립</td>
		</tr>
		<tr>
			<th class="its-th-align center">등급</th>
			<td class="its-td-align left pdl5">설정 > 회원 > <a href="javascript:alert('통신판매
중계자만 설정 가능합니다.');" target="_blank"><span class="highlight-link">등급별 구매혜택</span></a></td>
			<td class="its-td-align left pdl5">해당 등급이 구매하였을 때</td>
			<td class="its-td-align left pdl5">추가 할인 및 추가 적립</td>
		</tr>
		<tr>
			<th class="its-th-align center">모바일</th>
			<td class="its-td-align left pdl5">설정 > <a href="javascript:alert('통신판매
중계자만 설정 가능합니다.');" target="_blank"><span class="highlight-link">판매환경</span></a></td>
			<td class="its-td-align left pdl5">모바일에서 구매하였을 때</td>
			<td class="its-td-align left pdl5">추가 할인 및 추가 적립</td>
		</tr>
		<tr>
			<th class="its-th-align center">쿠폰</th>
			<td class="its-td-align left pdl5"><a href="../coupon/catalog" target="_blank"><span class="highlight-link">할인 쿠폰</span></a></td>
			<td class="its-td-align left pdl5">할인 쿠폰을 사용하여 구매하였을 때</td>
			<td class="its-td-align left pdl5">추가 할인 및 적립</td>
		</tr>
		<tr>
			<th class="its-th-align center">코드</th>
			<td class="its-td-align left pdl5"><a href="../promotion/catalog" target="_blank"><span class="highlight-link">할인 코드</span></a></td>
			<td class="its-td-align left pdl5">할인 코드를 사용하여 구매하였을 때</td>
			<td class="its-td-align left pdl5">추가 할인</td>
		</tr>
		<tr>
			<th class="its-th-align center">유입경로</th>
			<td class="its-td-align left pdl5"><a href="../referer/catalog" target="_blank"><span class="highlight-link">할인 유입경로</span></a></td>
			<td class="its-td-align left pdl5">특정 유입경로로 접속하여 구매하였을 때 </td>
			<td class="its-td-align left pdl5">추가 할인</td>
		</tr>
		</tbody>
		</table>
		<ul class="addsaleGuideLayer" >
			<li>추가 혜택 세팅 시 혜택 적용 조건을 설정할 수 있습니다.</li>
			<li>예를 들어 쿠폰의 경우 아래와 같이 혜택 적용 조건 설정이 가능합니다.</li>
			<li>발급시작/중지, 다운로드기간/수량/등급, 유효기간, 제한금액, 최대할인, 중복할인, 타쿠폰동시사용, 모바일, 결제수단, 중복할인, 유입경로, 할인분담, 적용 상품</li>
		</ul>
	</div>

	<br style="line-height:30px;" />

	<div class="item-title">
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr><td>추가 혜택 적용 페이지</td></tr>
		</table>
	</div>
	<div>
		<table class="info-table-style" style="margin:auto;" width="100%">
		<colgroup>
			<col />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
		</colgroup>
		<thead>
		<tr>
			<th class="its-th-align center" rowspan="2">데스크탑/모바일</th>
			<th class="its-th-align center" colspan="7">추가 혜택</th>
		</tr>
		<tr>
			<th class="its-th-align center">복수구매</th>
			<th class="its-th-align center">이벤트</th>
			<th class="its-th-align center">등급</th>
			<th class="its-th-align center">모바일</th>
			<th class="its-th-align center">쿠폰</th>
			<th class="its-th-align center">코드</th>
			<th class="its-th-align center">유입경로</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<th class="its-th-align center">위시리스트</th>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
		</tr>
		<tr>
			<th class="its-th-align center">최근 본 상품</th>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
		</tr>
		<tr>
			<th class="its-th-align center">검색 페이지</th>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
		</tr>
		<tr>
			<th class="its-th-align center">검색 자동 완성</th>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
		</tr>
		<tr>
			<th class="its-th-align center">최근 본 상품</th>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
		</tr>
		<tr>
			<th class="its-th-align center">스크롤 배너</th>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
		</tr>
		<tr>
			<th class="its-th-align center">리스트</th>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
		</tr>
		<tr>
			<th class="its-th-align center">상세</th>
			<td class="its-td-align center bgyellow">△</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">△</td>
			<td class="its-td-align center bgyellow">△</td>
			<td class="its-td-align center bgyellow">△</td>
		</tr>
		<tr>
			<th class="its-th-align center">상세 - 관련상품</th>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
		</tr>
		<tr>
			<th class="its-th-align center">장바구니</th>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center bgyellow">○</td>
		</tr>
		<tr>
			<th class="its-th-align center">주문</th>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
		</tr>
		</tbody>
		</table>
		<ul class="addsaleGuideLayer" >
			<li><font size="1.5">△</font> : 추가 혜택이 안내되어짐</li>
			<li><font size="3">○</font> : 추가 혜택 금액이 계산되어 판매가에 적용됨</li>
		</ul>
	</div>

	<br style="line-height:30px;" />

	<div class="item-title">
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr><td>추가 혜택 적용 페이지에서 상품옵션의 범위</td></tr>
		</table>
	</div>
	<div>
		<table class="info-table-style" style="margin:auto;" width="100%">
		<colgroup>
			<col />
			<col width="15%" />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
		</colgroup>
		<thead>
		<tr>
			<th class="its-th-align center" rowspan="2" colspan="2">데스크탑/모바일</th>
			<th class="its-th-align center" colspan="7">추가 혜택</th>
		</tr>
		<tr>
			<th class="its-th-align center">복수구매</th>
			<th class="its-th-align center">이벤트</th>
			<th class="its-th-align center">등급</th>
			<th class="its-th-align center">모바일</th>
			<th class="its-th-align center">쿠폰</th>
			<th class="its-th-align center">코드</th>
			<th class="its-th-align center">유입경로</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<th class="its-th-align center" rowspan="2">필수 옵션<br/>(옷, 신발)</th>
			<th class="its-th-align center">추가 할인</th>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
		</tr>
		<tr>
			<th class="its-th-align center">추가 마일리지/포인트</th>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
		</tr>
		<tr>
			<th class="its-th-align center" rowspan="2">추가 구성 옵션<br/>(벨트, 깔창)</th>
			<th class="its-th-align center">추가 할인</th>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">X</td>
		</tr>
		<tr>
			<th class="its-th-align center">추가 마일리지/포인트</th>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center bgyellow">○</td>
			<td class="its-td-align center">X</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
			<td class="its-td-align center">-</td>
		</tr>
		</tbody>
		</table>
	</div>

	<br style="line-height:30px;" />

</div>

<script type="text/javascript" >
	// 업그레이드 안내 :: 2016-12-07 lwh
	function noProvideService(msg){
		if(msg){
			$("#noProvideService_msg").html(msg)
		}
		openDialog("쇼핑몰 업그레이드 안내<span class='desc'></span>", "noProvideService", {"width":550,"height":440});
	}

	// facebook config (무료몰인경우 연결 및 스킨설정
	$('#freefacebookconfignone').live('click', function() {
		alert('무료몰');
		/*
		if($(this).attr("config")){
			openDialog("Fammerce(facebook 쇼핑몰) 설정<span class='desc'></span>", "freefacebookService", {"width":600,"height":200});
		}else{
			openDialog("Fammerce(facebook 쇼핑몰) 안내<span class='desc'></span>", "freefacebookService", {"width":600,"height":200});
		}
		*/
	});
	// onlyfacebook config (facebook전용인경우 설정불가
	$('#onlyfacebooklinknone').live('click', function() {
		alert('페이스북');
		/*
		if($(this).attr("config")){
			openDialog("PC, Mobile/Table 쇼핑몰 업그레이드 안내<span class='desc'></span>", "onlyfacebookService", {"width":600,"height":200});
		}else{
			openDialog("PC, Mobile/Table 쇼핑몰 안내<span class='desc'></span>", "onlyfacebookService", {"width":600,"height":200});
		}*/
	});

	// 무료몰인경우 업그레이드안내
	$('#nofreelinknone,.nofreelinknone').live('click', function() {
		openDialog("쇼핑몰 업그레이드 안내<span class='desc'></span>", "nofreeService", {"width":600,"height":200});
	});

	/* 추가 혜택 적용 범위 안내 */
	$(".addsaleGuideBtn").live('click',function(){
		openDialog("추가 혜택 적용 범위 안내","addsaleGuideLayer",{"width":720,"height":500});
	});


</script>

<div id="noProvideService" class="hide">
<div>
		<table width="100%">
		<tr>
			<td class="pdt10" id="noProvideService_msg" align="center">
				사용중이신 서비스에서는 해당기능이 지원되지 않습니다.<br/>
				업그레이드 하시길 바랍니다.
			</td>
		</tr>
		<tr>
		<td class="pdt30" align="center">
			<br/>
			<img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand" onclick="serviceUpgrade();" align="absmiddle" />
		</td>
		</tr>
		</table>
	</div>
	<br style="line-height:20px;" />
</div>

<div id="freefacebookService" class="hide">
<div>
		<table width="100%">
		<tr>
		<td align="left">
			무료몰 Plus+ : PC 및 Mobile/Tablet 쇼핑몰 운영이 가능합니다.<br />
			Facebook PC 쇼핑몰 운영을 위해서는<br />
			프리미엄몰 Plus+ 또는 독립몰 Plus+로 업그레이드 하시길 바랍니다.<br />
		</td>
		</tr>
		<tr>
		<td align="center"><br /><br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="btn large cyanblue"><input type="button" onclick="serviceUpgrade();" value="업그레이드 >"></span>
		</td>
		</tr>
		</table>
	</div>
	<br style="line-height:20px;" />
</div>

<div id="onlyfacebookService" class="hide">
<div>
		<table width="100%">
		<tr>
		<td align="left">
			페이머스 Plus+ : Facebook 쇼핑몰 운영이 가능합니다.<br />
			PC, Mobile/Tablet  쇼핑몰 운영을 위해서는<br />
			프리미엄몰 Plus+ 또는 독립몰 Plus+로 업그레이드 하시길 바랍니다.<br />
		</td>
		</tr>
		<tr>
		<td align="center"><br /><br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="btn large cyanblue"><input type="button" onclick="serviceUpgrade();" value="업그레이드 >"></span>
		</td>
		</tr>
		</table>
	</div>
	<br style="line-height:20px;" />
</div>

<div id="nofreeService" class="hide">
<div>
		<table width="100%">
		<tr>
		<td align="left">
			무료몰 Plus+ 에서는 해당기능이 지원되지 않습니다.<br />
			프리미엄몰 Plus+ 또는 독립몰 Plus+로 업그레이드 하시길 바랍니다.<br />
		</td>
		</tr>
		<tr>
		<td align="center"><br /><br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="btn large cyanblue"><input type="button" onclick="serviceUpgrade();" value="업그레이드 >"></span>
		</td>
		</tr>
		</table>
	</div>
	<br style="line-height:20px;" />
</div>

<?php if($TPL_VAR["autoLogout"]["auto_logout"]=="Y"&&$TPL_VAR["providerInfo"]){?>
<script type="text/javascript">
	var initDate = new Date();
	var resetTime = new Array();
	var timerchecker = null;

	resetTime.hours = "<?php echo $TPL_VAR["autoLogout"]["until_time"]?>";		// 관리자 설정 시간
	resetTime.seconds = resetTime.hours * 60 * 60;		// ex) 1시간 > 3600

	initTimer=function(){
		//이벤트 발생 체크
		if(window.event){
			initDate = new Date();
			clearTimeout(timerchecker);
		}

		remainTime = new Date() - initDate;				// 남은 시간 (현재 시간 - 초기 시간)
		remainTime = parseInt(remainTime/1000);			// seconds

		// 움직임 없는 시간이 resetTime.seconds 보다 큰 경우 로그아웃
		if( remainTime < resetTime.seconds) {
			timerchecker = setTimeout("initTimer()", 1000);
		} else {
			clearTimeout(timerchecker);
			openDialog("관리자 자동 로그아웃 알림", "autoLogoutMsg", {"width":"600","height":"340", "noClose":true});
			actionFrame.location.href = "../login_process/logout?mode=autoLogout"; // 로그아웃 처리
		}
	}
	onload = initTimer;///현재 페이지 대기시간
	document.onclick = initTimer; /// 현재 페이지의 사용자 마우스 클릭이벤트 캡춰
	document.onkeypress = initTimer;/// 현재 페이지의 키보트 입력이벤트 캡춰
</script>

<div id="autoLogoutMsg" class="hide">
	<h2 class="center">자동으로 로그아웃 되었습니다.</h2>
	<div class="pdt20 pdb20">
	- 안전한 관리를 위하여 <?php echo $TPL_VAR["autoLogout"]["until_time"]?>시간 동안 사용이 없어 자동로그아웃 되었습니다.<br/>
	- 다시 로그인 하시려면 [로그인] 버튼을 클릭하십시오.
	</div>
	<div class="center">
		<span class="btn large gray"><input type="button" value="로그인" onclick="location.href='../login/index'"></span>
	</div>
</div>
<?php }?>

<?php echo header_requires()?></body>
<?php $this->print_("warningScript",$TPL_SCP,1);?>

<?php $this->print_("common_html_footer",$TPL_SCP,1);?>