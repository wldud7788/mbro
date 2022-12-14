<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/goods/_openmarket_imagehosting.html 000004393 */ ?>
<script>
function checkImagehostingDomainType(){
	if($("input[name='imagehostingDomainType']:checked").val() == 'firstmall'){
		$("tr.gabia_imghosting").hide();
		$("#imagehostingDomain").html('<?php echo $TPL_VAR["imagehostingftp"]["firstmallimagehostingurl"]?>');
	}else{
		$("tr.gabia_imghosting").show();
		$("#imagehostingDomain").html('<?php echo $TPL_VAR["imagehostingftp"]["gabiaimagehostingurl"]?>');
	}
}

function resetftp(){
	$("#imghostingusername").val('');
	$("#imghostingpassword").val('');
}

$(document).ready(function() {
	checkImagehostingDomainType();

});
</script>

<?php if(!preg_match("/chrome/",strtolower($_SERVER['HTTP_USER_AGENT']))&&!preg_match("/firefox/",strtolower($_SERVER['HTTP_USER_AGENT']))){?>
<style type="text/css">
.ui-widget-overlay {z-index:9999 !important}
</style>
<?php }?>

<div class="content">
	<form name="goodsImagehostingForm" id="goodsImagehostingForm">
	<input type="hidden" name="mode" id="imghostingsavemode" value="<?php echo $TPL_VAR["sc"]["mode"]?>" /> 
	<input type="hidden" name="goods_seq" id="imghostingsavegoods_seq" value="" />
	<table class="table_basic">
		<colgroup>
			<col width="30%">
			<col width="70%">
		</colgroup>
	<tr>
		<th>서비스 선택</th>
		<td>
			<div class="resp_radio">
<?php if($TPL_VAR["imagehostingftp"]["imagehostingDomainType"]=='firstmall'){?>
				<label><input type="radio" name="imagehostingDomainType" value="firstmall" onclick="checkImagehostingDomainType()" onchange="resetftp();" checked> 퍼스트몰</label>
<?php }else{?>
				<label><input type="radio" name="imagehostingDomainType" value="firstmall" onclick="checkImagehostingDomainType()" onchange="resetftp();"> 퍼스트몰</label>
<?php }?>
				&nbsp;&nbsp;&nbsp;
<?php if($TPL_VAR["imagehostingftp"]["imagehostingDomainType"]=='gabia'){?>
				<label><input type="radio" name="imagehostingDomainType" value="gabia" onclick="checkImagehostingDomainType()" onchange="resetftp();" checked> 가비아</label>
<?php }else{?>
				<label><input type="radio" name="imagehostingDomainType" value="gabia" onclick="checkImagehostingDomainType()" onchange="resetftp();"> 가비아</label>
<?php }?>
				
			</div>
		</td>
	</tr>
	<tr class="gabia_imghosting <?php if($TPL_VAR["imagehostingftp"]["imagehostingDomainType"]=='firstmall'){?>hide<?php }?>">
		<th>이미지 호스팅 관리</th>
		<td>
			<a href="http://imagetool.gabia.com/login" target="_blank"><span class="resp_btn">관리</span></a>
		</td>
	</tr>
	<tr>
		<th>FTP 접속경로</th>
		<td>
			<input type="text" name="hostname"  id="imghostinghostname" value="<?php echo $TPL_VAR["imagehostingftp"]["hostnameid"]?>" size="15" />
			<span id="imagehostingDomain"><?php echo $TPL_VAR["imagehostingftp"]["firstmallimagehostingurl"]?></span>
		</td>
	</tr>
	
	<tr>
		<th>FTP 아이디</th>
		<td>
			<input type="text" name="username"  id="imghostingusername" value="" size="38" />
		</td>
	</tr>
	<tr>
		<th>FTP 비밀번호</th>
		<td>
			<input type="password" name="password"  id="imghostingpassword" value="" size="38" autocomplete="off"  />
		</td>
	</tr>
	</table>
	<div class="box_style_05 mt10">
		<div class="title">안내</div>
		<ul class="bullet_circle">
			<li>서비스 신청 후 이용가능합니다.</li>
			<li>
				퍼스트몰 이미지호스팅 <a href ="https://www.firstmall.kr/register/imagehosting" target="_blank"><span class="underline blue hand">신청하기 &gt;</span></a>,
				가비아 이미지호스팅 <a href ="https://imagehosting.gabia.com/service" target="_blank"><span class="underline blue hand">신청하기 &gt;</span></a>
			</li>
			<li>등록된 상품 설명 이미지를 이미지 호스팅에 업로드(동일파일명 존재 시 덮어쓰기) 합니다.</li>
			<li>상품 설명 이미지의 경로를 로컬 경로(URL)에서 이미지 호스팅 경로(URL)로 자동 변환하여 저장합니다.</li>
		</ul>
	</div>

	</form>
</div>
<div class="footer">
	<button type="button"  id="imagehostinggoodssave" class="resp_btn active size_XL">실행</button>
	<button type="button" onClick="closeDialog('openmarketimghostinglay')" class="resp_btn v3 size_XL">취소</button>
</div>