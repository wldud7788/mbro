<?php /* Template_ 2.2.6 2022/05/17 12:31:04 /www/music_brother_firstmall_kr/admin/skin/default/coupon/coupon_popup_setting.html 000009227 */ 
$TPL_coupon_popup_list_1=empty($TPL_VAR["coupon_popup_list"])||!is_array($TPL_VAR["coupon_popup_list"])?0:count($TPL_VAR["coupon_popup_list"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common-ui.css?mm=20200601" />
<script type="text/javascript"> 
	$(document).ready(function() {

		var siteUrl = "<?php echo $TPL_VAR["config_system"]["domain"]?>";
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
			siteUrl = "<?php echo get_connet_protocol()?>" + siteUrl;
<?php }else{?>
			siteUrl = "<?php echo get_connet_protocol()?>m." + siteUrl;
<?php }?>


		//소스수정
		$('input.onlinecouponcodemodifybtn').click(function() {
<?php if($TPL_VAR["coupons"]["type"]=='birthday'||$TPL_VAR["coupons"]["type"]=='anniversary'||$TPL_VAR["coupons"]["type"]=='memberGroup'||$TPL_VAR["coupons"]["type"]=='memberGroup_shipping'){?>
				var href = "/promotion/<?php echo getcouponpagepopup($TPL_VAR["coupons"],'url')?>?setDesignMode=on&setMode=pc&popup=1";
<?php }else{?>
				var href = "/promotion/<?php echo getcouponpagepopup($TPL_VAR["coupons"],'url')?>?setDesignMode=on";
<?php }?>
			var a = window.open(href, 'coupon<?php echo $TPL_VAR["coupons"]["type"]?>_<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>', '');
			if ( a ) {
				a.focus();
			} 
		});

		$('input.onlinemobilecouponcodemodifybtn').click(function() { 
<?php if($TPL_VAR["coupons"]["type"]=='birthday'||$TPL_VAR["coupons"]["type"]=='anniversary'||$TPL_VAR["coupons"]["type"]=='memberGroup'||$TPL_VAR["coupons"]["type"]=='memberGroup_shipping'){?>
				var href = siteUrl + "/promotion/<?php echo getcouponpagepopup($TPL_VAR["coupons"],'url')?>?setDesignMode=on&setMode=mobile&popup=1";
<?php }else{?>
				var href = siteUrl + "/promotion/<?php echo getcouponpagepopup($TPL_VAR["coupons"],'url')?>?setDesignMode=on&setMode=mobile";
<?php }?>
			var a = window.open(href, 'mobilecoupon<?php echo $TPL_VAR["coupons"]["type"]?>_<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>', '');
			if ( a ) {
				a.focus();
			}		
		});
		
		//미리보기
		$('input.onlinecouponcodeviewbtn').click(function() {
<?php if($TPL_VAR["coupons"]["type"]=='memberGroup'||$TPL_VAR["coupons"]["type"]=='memberGroup_shipping'){?>
				var href = "/main/index?previewlayer=membergroup&setDesignMode=on&setMode=pc";
<?php }else{?>
				var href = "/main/index?previewlayer=<?php echo $TPL_VAR["coupons"]["type"]?>&setDesignMode=on&setMode=pc";
<?php }?>
			var a = window.open(href, 'couponpreviewlayer<?php echo $TPL_VAR["coupons"]["type"]?>_<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>', '');
			if ( a ) {
				a.focus();
			} 
		});

		$('input.onlinemobilecouponcodeviewbtn').click(function() { 
<?php if($TPL_VAR["coupons"]["type"]=='memberGroup'||$TPL_VAR["coupons"]["type"]=='memberGroup_shipping'){?>
			
				var href = siteUrl + "/main/index?previewlayer=membergroup&setDesignMode=on&setMode=mobile";
<?php }else{?>
				var href = siteUrl + "/main/index?previewlayer=<?php echo $TPL_VAR["coupons"]["type"]?>&setDesignMode=on&setMode=mobile";
<?php }?>
			var a = window.open(href, 'mobilecouponpreviewlayer<?php echo $TPL_VAR["coupons"]["type"]?>_<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>', '');
			if ( a ) {
				a.focus();
			}		
		});

		$("#couponusesave").click(function(){
			var coupon_popup_use = $("input:radio[name$='coupon_popup_use']:checked").val();
			$.ajax({
					'url' : '../coupon_process/couponpopupuse',
					'data' : {'couponpopupuse':coupon_popup_use,'type':'<?php echo $TPL_VAR["coupons"]["type"]?>','coupon_seq':'<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>'},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){
						if(res.result == true ){
							alert(res.msg);
							document.location.reload();
						}else{
							alert(res.msg);
						}
					}
				});
		});

		$(document).on("click",".coupon_popup",function(){
			document.location.href='/admin/coupon/catalog';
		});

		$(document).on("change","select[name='coupon_type']",function(){

			var select_value = $(this).children("option:selected").val();
			document.location.href= '/admin/coupon/coupon_popup_setting?type=' + select_value;

		});


		$(".couponpgae_view").on("click",function(){

			var mode = $(this).attr("mode");
			window.open('/admin/coupon/couponpage_codeview?coupon_seq=<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>&type=<?php echo $TPL_VAR["coupons"]["type"]?>&mode='+mode, 'onlinecouponcodepopup', 'width=900px,height=550px,top=50,toolbar=no,location=no,resizable=yes,scrollbars=yes');
		});


		// 쿠폰URL복사
		/*
		$(document).on("click","#couponallhtml_btn", function(){

			var code = $("#onlinecouponcodepopup .entry code").html();

			var str = "gocoder"
			code = replaceAll(code,"&lt;","<");
			code = replaceAll(code,"&gt;",">");


			console.log(code);
			clipboard_copy(code);
			alert('소스코드가 복사되었습니다.\nCtrl+V로 붙여넣기 하세요.');
		});
		*/
	});

/*
function replaceAll(str, searchStr, replaceStr) {
  return str.split(searchStr).join(replaceStr);
}
*/
</script> 

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area"  class="gray-bar">
	<div id="page-title-bar">
		<!-- 좌측 버튼 -->
		<div class="page-buttons-left"><button name="coupon_popup" class="coupon_popup resp_btn v3 size_L">리스트 바로가기</button></div>
		<!-- 타이틀 -->
		<div class="page-title">
			<h2> 쿠폰별 팝업</h2>
		</div> 
		<ul class="page-buttons-right birthday anniversary membergroup memberGroup memberGroup_shipping"> 
			<li><button type="button" id="couponusesave" class="resp_btn active2 size_L">저장</button></li>
		</ul> 
	</div>
</div>

<div class="contents_container">
	<div class="item-title">쿠폰 정보</div>

	<table class="table_basic thl">		
		<tr>
			<th>쿠폰 종류</th>
			<td>
				<select name="coupon_type" class="resp_select">
<?php if($TPL_coupon_popup_list_1){foreach($TPL_VAR["coupon_popup_list"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>" <?php if($TPL_VAR["coupons"]["type"]==$TPL_K1){?>selected<?php }?> /><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr class="t_popup_open_option <?php if(!in_array($TPL_VAR["coupons"]["type"],array('birthday','anniversary','memberGroup'))){?>hide<?php }?>">
			<th>팝업 노출 방법</th>
			<td>
				<div class="resp_radio">
					<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
					<label><input type="radio" name="coupon_popup_use" value="Y" <?php if($TPL_VAR["coupons"]["popup_use"]=='Y'){?> checked="checked"<?php }?>> 대상 회원이 로그인 시</label>
					<label><input type="radio" name="coupon_popup_use" value="N" <?php if(!$TPL_VAR["coupons"]["popup_use"]||$TPL_VAR["coupons"]["popup_use"]=='N'){?> checked="checked"<?php }?>> 팝업 제공 안함</label>
				</div>
			</td>
		</tr>
	</table>	

	<div class="item-title">팝업 디자인</div>
	
	<table class="table_basic thl tdc">
	<colgroup>
		<col width="14%" />
		<col width="43%" />
		<col width="43%" />
	</colgroup>

	<thead>
		<tr>
			<th></th>
			<th class="center">PC</th>
			<th class="center">Mobile</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<th>미리 보기</th>
			<td><img src="/admin/skin/default/images/design/coupon/<?php echo getcouponpagepopup($TPL_VAR["coupons"],'url')?>.jpg"  style="border: 1px solid #000;"></td>
			<td><img src="/admin/skin/default/images/design/coupon/mobile_<?php echo getcouponpagepopup($TPL_VAR["coupons"],'url')?>.jpg" style="border: 1px solid #000;"></div>
			</td>
		</tr>
		<tr>
			<th>디자인 편집</th>
			<td>
				<!--onclick="document.location.href='#pc_coupon_code'"-->
				<input type="button" class="couponpgae_view resp_btn" value="소스보기" mode="pc" />
<?php if(in_array($TPL_VAR["coupons"]["type"],array('birthday','anniversary','memberGroup','memberGroup_shipping'))){?>
				<input type="button" class="onlinecouponcodeviewbtn resp_btn v2"  value="디자인수정" />
<?php }else{?>
				<input type="button" class="onlinecouponcodemodifybtn resp_btn v2"  value="디자인수정" />
<?php }?>
				
			</td>
			<td>			
				<input type="button" class="couponpgae_view resp_btn"  value="소스보기" mode="mobile" />
<?php if(in_array($TPL_VAR["coupons"]["type"],array('birthday','anniversary','memberGroup','memberGroup_shipping'))){?>
				<input type="button" class="onlinemobilecouponcodeviewbtn  resp_btn v2"  value="디자인수정" />
<?php }else{?>
				<input type="button" class="onlinemobilecouponcodemodifybtn  resp_btn v2"  value="디자인수정" />
<?php }?>				
			</td>
		</tr>
	</tbody>

	</table>

	<div class="resp_message">
		- EYE-DESIGN 화면에서는 프로모션 폴더의  <?php echo $TPL_VAR["couponfilename"]?> 화면에서도 수정 가능합니다.</li>		
	</div>
</div>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>