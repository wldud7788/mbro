<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/setting/_require_info.html 000001841 */ ?>
<div class="page-buttons-left hide">	
	<input type="button" value="필수 설정" class="require_info_btn resp_btn active3 size_L " />	
</div>
<div id="require_info_layer" class="hide">
	<span class='red bold' style='font-size:11px'>!</span>표시는 아래와 같은 경우에 설정메뉴 우측에 나타나며, 필요한 설정을 알려드립니다.<br/><br/>
	·일반정보 <span class='red bold' style='font-size:11px'>!</span> : 도메인,쇼핑몰이름,타이틀,사업자정보가 없을 경우 → 쇼핑몰하단에 쇼핑몰정보가 표기되지 않을 수 있습니다.<br/>
	·전자결제 <span class='red bold' style='font-size:11px'>!</span> : 전자결제 미사용이거나 사용하는 결제수단이 없을 경우 → 구매자가 상품을 구매하지 못할 수 있습니다.<br/>
	·무통장 <span class='red bold' style='font-size:11px'>!</span> : 사용중인 무통장입금계좌가 없거나 계좌정보가 없을 경우 → 구매자가 상품을 구매하지 못할 수 있습니다.<br/>
	·택배/배송비 <span class='red bold' style='font-size:11px'>!</span> : 사용중인 배송정책이 없을 경우 → 구매자가 상품을 구매할 수 없습니다.
</div>
<div class="hide" id="firstmallGlManualPopup">
<iframe name="firstmall_manual" id="firstmall_manual" src="//interface.firstmall.kr/firstmall_manual/firstmall_gl_manual.php?service_code=<?php echo $TPL_VAR["service_code"]?>" width="800px" height="700px" frameborder="0" scrolling="no" allowTransparency="true"></iframe>
</div>
<script>
	$(".require_info_btn").click(function() {
		openDialog("알림", "firstmallGlManualPopup", {"width":"850","height":"800"});
	});
</script>