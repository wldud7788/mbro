<?php /* Template_ 2.2.6 2022/05/17 12:36:33 /www/music_brother_firstmall_kr/admin/skin/default/mobile_app/setting.html 000019545 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/mobile_app.css" />
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<style type="text/css">
.popWrap-border {border:1px solid #e0e0e0;}
#preview_area {display:none}
#app_popup_area {display:none}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#custom_popup_img").change(function (e) {
		if(this.disabled) return alert('File upload not supported!');
		var F = this.files;
		if(F && F[0]) for(var i=0; i<F.length; i++) readImage( F[i] );
	});

	$("input[name='app_popup_use']").on('change', function (){
		popupuse();
	});

	popupuse();
	popupimg();

	setContentsRadio("app_popup_use", "<?php echo $TPL_VAR["app_config"]["app_popup_use"]?>");
	setContentsSelect("popup_type", "<?php if($TPL_VAR["app_config"]["popup_type"]){?><?php echo $TPL_VAR["app_config"]["popup_type"]?><?php }else{?>img_a<?php }?>");

	//팝업 이미지 직접 등록 버튼
	$('#custom_popup_img').createAjaxFileUpload(uploadConfig, uploadSizelimitCallback);
<?php if($TPL_VAR["app_config"]["popup_type"]=='custom'){?>imgUploadEvent("#custom_popup_img", "", "", "<?php echo $TPL_VAR["app_config"]["custom_popup_img"]?>")<?php }?>	

});

// 앱 다운 권장 팝업 닫기 버튼 - 에러제거용
function appClosepopup(mode){}

// 최종 저장하기
function saveapp_setting(){
	var n_popup_type	= $("input[name='new_popup_type']").val();
	var popup_type		= $("#popup_type").val();

	if(popup_type != 'custom' && n_popup_type && popup_type != n_popup_type){
		var params	= {'yesMsg':'저장','noMsg':'수정하기'};
		var ph		= 180;
		var msg		= '설정된 미리보기 팝업 스타일과 실제 지정된 팝업 스타일이 다릅니다.<br/>셀렉스 박스의 스타일을 적용하시려면 `수정` 버튼을 눌러 적용하시기 바랍니다.<br/>저장 하시겠습니까?';
		openDialogConfirm(msg,500,ph,function(){
			$("#settingForm").submit();
		},function(){
			popupimg_modify();
			return false;
		},params);
	}else{
		$("#settingForm").submit();
	}
}

// 앱설치 권장 팝업 사용여부 변경
function popupuse(){
	var use_yn = $("input[name='app_popup_use']:checked").val();
	if(use_yn == 'N'){ // 비활성화
		$("#popup_type").prop('disabled', true);
		//$("#popup_img_modify").closest('span.app_popup').addClass('gray');
	}else{
		$("#popup_type").prop('disabled', false);
		//$("#popup_img_modify").closest('span.app_popup').removeClass('gray');
	}
}

// 앱설치 권장 팝업 타입 변환
function popupimg(){
	var popup_type = $("#popup_type").val();
	if(popup_type == 'custom'){
		$(".custom_popup").show();
		$("#app_popup_area").hide();
	}else{
		$("#app_popup_area").show();
		$(".custom_popup").hide();
	}
}

// 앱설치 권장 팝업 수정
function popupimg_modify(){
	if($("input[name='app_popup_use']:checked").val() == 'Y'){
		var popup_type	= $("#popup_type").val();
		var serialize	= $("#settingForm").serialize();
		$.ajax({
			type: "post",
			url: "/admin/mobile_app/app_popup",
			data: "popup_type="+popup_type+"&pop_style="+serialize,
			dataType: "html",
			success: function(html_tag){
				$("#popupImg_lay").html(html_tag);
				openDialog("팝업 이미지", "popupImg_lay", {"width":"800","height":"730"});
			}
		});
	}else{
		alert('사용 안 함 상태 에서는 수정이 불가능합니다.');
	}
}

// 앱 하단 메뉴 수정
function footerimg_modify(){
	var footer_style = $("input[name='footer_style']").val();
	$("input[name='footer_style_tmp']:radio[value='"+footer_style+"']").prop('checked',true);
	openDialog("하단 메뉴 스타일", "footerImg_lay", {"width":"780","height":"590"});
}

// 앱 하단 메뉴 수정 미리보기 적용
function footer_style_set(){
	var footer_style = $("input[name='footer_style_tmp']:checked").val();
	$("input[name='footer_style']").val(footer_style);
	$("#footer_type_img").attr('src','/admin/skin/default/images/app/tabbar'+footer_style+'.jpg');
	$("#footer_type").html('스타일 ' + footer_style);
	$(".footer_type_dvs").css("display", "block");
	closeDialog("footerImg_lay");
}

function readImage(file) {
	var reader = new FileReader();
	var image  = new Image();

	reader.readAsDataURL(file);

	reader.onload = function(_file) {
		image.src    = _file.target.result;
		image.onload = function() {
			var w = this.width,
				h = this.height,
				t = file.type,
				n = file.name,
				s = ~~(file.size/1024) +'KB';


				if(w > 300)
				{
					openDialogAlert("가로 300px 이미지만 업로드 할 수 있습니다.", 400, 150);
					$("#file").val("");
					$("#preview").closest('div').hide();
				}else{
					$("#preview").attr("src", image.src);
					$("#preview").closest('div').show();
				}

		};
		image.onerror= function() {
			alert('Invalid file type: '+ file.type);
		};
	};
}
</script>

<form name="settingForm" id="settingForm" method="post" enctype="multipart/form-data" action="../mobile_app_process/setting" target="actionFrame">
<input type="hidden" name="Android" value="<?php echo $TPL_VAR["ANDROID"]["status"]?>">
<input type="hidden" name="IOS" value="<?php echo $TPL_VAR["IOS"]["status"]?>">
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>앱 설정</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li>
				<button <?php if($TPL_VAR["isdemo"]["isdemo"]){?>type="button" <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> type="button" onclick="saveapp_setting();" <?php }?> class="resp_btn active2 size_L">저장</button>
			</li>
		</ul>

	</div>
</div>


<div class="contents_container">

	<!-- 모바일앱 이용현황 :: START -->
	<div class="item-title">쇼핑몰 앱</div>

	<ul class="tab_01 tabEvent">
		<li><a href="javascript:void(0);" data-showcontent="android" class="current">Android</a></li>
		<li><a href="javascript:void(0);" data-showcontent="ios">iOS</a></li>				
	</ul>
	<a href="https://www.firstmall.kr/mobileapp/shop_app" target="_blank" class="resp_btn fr">서비스 안내</a>

	<div class="android">
		<table class="table_basic thl">		
			<tr>
				<th>상태</th>
				<td>
<?php if($TPL_VAR["ANDROID"]["status_txt"]){?>
					<?php echo $TPL_VAR["ANDROID"]["status_txt"]?>

					<input type="hidden" name="status_txt_and" value="1" />
<?php }else{?>
					출시된 쇼핑몰 앱 없음				
<?php }?>
				</td>
			</tr>
<?php if($TPL_VAR["ANDROID"]["status_txt"]){?>
			<tr>
				<th>신청일</th>
				<td>
<?php if($TPL_VAR["ANDROID"]["period"]["start"]){?>
					<?php echo $TPL_VAR["ANDROID"]["period"]["start"]?>

<?php }else{?>
					-
<?php }?>
				</td>
			</tr>

			<tr>
				<th>출시일</th>
				<td>
<?php if($TPL_VAR["ANDROID"]["period"]["launched"]){?>
					<?php echo $TPL_VAR["ANDROID"]["period"]["launched"]?>

<?php }else{?>
					-
<?php }?>
				</td>
			</tr>

			<tr>
				<th>종료일</th>
				<td>
<?php if($TPL_VAR["ANDROID"]["period"]["end"]=='0000-00-00'){?>
					-
<?php }elseif($TPL_VAR["ANDROID"]["period"]["end"]){?>
					<?php echo $TPL_VAR["ANDROID"]["period"]["end"]?> <button type="button" onclick="window.open('https://firstmall.kr/myshop/index.php');" class="resp_btn v2">연장</button>
<?php }else{?>
					-
<?php }?>
				</td>
			</tr>

			<tr>
				<th>스토어 등록</th>
				<td>
<?php if($TPL_VAR["ANDROID"]["account_type_txt"]){?>
					<?php echo $TPL_VAR["ANDROID"]["account_type_txt"]?>

<?php }else{?>
					-
<?php }?>
				</td>
			</tr>

			<tr>
				<th>앱 변경</th>
				<td>
<?php if($TPL_VAR["ANDROID"]["status"]=='80'){?>				
					<button type="button" onclick="window.open('https://firstmall.kr/myshop/index.php');" class="resp_btn v2">변경 신청</button>					
<?php }else{?>
					-
<?php }?>
				</td>
			</tr>

			<tr>
				<th>스토어 바로가기</th>
				<td>
<?php if($TPL_VAR["ANDROID"]["status"]=='80'){?>
<?php if($TPL_VAR["app_url"]["shopApp"]["ANDROID"]){?>					
					<button type="button" onclick="window.open('<?php echo $TPL_VAR["app_url"]["shopApp"]["ANDROID"]?>');" class="resp_btn v2">바로가기</button>				
					<input type="hidden" name="popup_url_and" value="<?php echo $TPL_VAR["app_url"]["shopApp"]["ANDROID"]?>" />
<?php }else{?>
					-
<?php }?>
<?php }?>
				</td>
			</tr>
<?php }else{?>
			<tr>
				<th>신청</th>
				<td>
<?php if($TPL_VAR["ANDROID"]["status"]&&$TPL_VAR["ANDROID"]["status"]< 80){?>
					-
<?php }else{?>				
<?php if($TPL_VAR["functionLimit"]){?>
					<button type="button" onclick="servicedemoalert('use_f');" class="resp_btn v2">신청</button>
<?php }else{?>
					<button type="button" onclick="window.open('https://firstmall.kr/myshop/index.php');" class="resp_btn v2">신청</button>
<?php }?>				
<?php }?>
				</td>
			</tr>
<?php }?>
		</table>
	</div>

	<div class="ios hide">
		<table class="table_basic thl">		
			<tr>
				<th>상태</th>
				<td>
<?php if($TPL_VAR["IOS"]["status_txt"]){?>
					<?php echo $TPL_VAR["IOS"]["status_txt"]?>

					<input type="hidden" name="status_txt_ios" value="1" />
<?php }else{?>
					출시된 쇼핑몰 앱 없음				
<?php }?>
				</td>
			</tr>
<?php if($TPL_VAR["IOS"]["status_txt"]){?>
			<tr>
				<th>신청일</th>
				<td>
<?php if($TPL_VAR["IOS"]["period"]["start"]){?>
					<?php echo $TPL_VAR["IOS"]["period"]["start"]?>

<?php }else{?>
					-
<?php }?>
				</td>
			</tr>

			<tr>
				<th>출시일</th>
				<td>
<?php if($TPL_VAR["IOS"]["period"]["launched"]){?>
					<?php echo $TPL_VAR["IOS"]["period"]["launched"]?>

<?php }else{?>
					-
<?php }?>
				</td>
			</tr>

			<tr>
				<th>종료일</th>
				<td>
<?php if($TPL_VAR["IOS"]["period"]["end"]=='0000-00-00'){?>
					-
<?php }elseif($TPL_VAR["IOS"]["period"]["end"]){?>
					<?php echo $TPL_VAR["IOS"]["period"]["end"]?> <button type="button" onclick="window.open('https://firstmall.kr/myshop/index.php');" class="resp_btn v2">연장</button>
<?php }else{?>
					-
<?php }?>
				</td>
			</tr>

			<tr>
				<th>스토어 등록</th>
				<td>
<?php if($TPL_VAR["IOS"]["account_type_txt"]){?>
					<?php echo $TPL_VAR["IOS"]["account_type_txt"]?>

<?php }else{?>
					-
<?php }?>
				</td>
			</tr>

			<tr>
				<th>앱 변경</th>
				<td>
<?php if($TPL_VAR["IOS"]["status"]=='80'){?>				
					<button type="button" onclick="window.open('https://firstmall.kr/myshop/index.php');" class="resp_btn v2">변경 신청</button>					
<?php }else{?>
					-
<?php }?>
				</td>
			</tr>

			<tr>
				<th>스토어 바로가기</th>
				<td>
<?php if($TPL_VAR["IOS"]["status"]=='80'){?>
<?php if($TPL_VAR["app_url"]["shopApp"]["IOS"]){?>					
					<button type="button" onclick="window.open('<?php echo $TPL_VAR["app_url"]["shopApp"]["IOS"]?>');" class="resp_btn v2">바로가기</button>				
					<input type="hidden" name="popup_url_ios" value="<?php echo $TPL_VAR["app_url"]["shopApp"]["IOS"]?>" />
<?php }else{?>
					-
<?php }?>
<?php }?>
				</td>
			</tr>
<?php }else{?>
			<tr>
				<th>신청</th>
				<td>
<?php if($TPL_VAR["IOS"]["status"]&&$TPL_VAR["IOS"]["status"]< 80){?>
					-
<?php }else{?>				
<?php if($TPL_VAR["functionLimit"]){?>
					<button type="button" onclick="servicedemoalert('use_f');" class="resp_btn v2">신청</button>
<?php }else{?>
					<button type="button" onclick="window.open('https://firstmall.kr/myshop/index.php');" class="resp_btn v2">신청</button>
<?php }?>				
<?php }?>
				</td>
			</tr>
<?php }?>
		</table>
	</div>		
	<!-- 모바일앱 이용현황 :: END -->	

	<div class="item-title">앱 설치 권장 팝업</div>
	<table class="table_basic thl">		
		<tr>
			<th>사용 여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="app_popup_use" value="Y" <?php if($TPL_VAR["app_config"]["app_popup_use"]=='Y'){?>checked<?php }?> > 사용</label>				
					<label><input type="radio" name="app_popup_use" value="N" <?php if($TPL_VAR["app_config"]["app_popup_use"]=='N'||!$TPL_VAR["app_config"]["app_popup_use"]){?>checked<?php }?> > 사용 안 함</label>
				</div>				
			</td>
		</tr>

		<tr class="app_popup_use_Y hide">
			<th>
				팝업 이미지
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/mobile_app', '#tip1')"></span>
			</th>
			<td>				
				<select name="popup_type" id="popup_type" onchange="popupimg();">
					<option value="img_a" <?php if($TPL_VAR["app_config"]["popup_type"]=='img_a'){?>selected<?php }?>>이미지형 A</option>
					<option value="img_b" <?php if($TPL_VAR["app_config"]["popup_type"]=='img_b'){?>selected<?php }?>>이미지형 B</option>
					<option value="btn" <?php if($TPL_VAR["app_config"]["popup_type"]=='btn'){?>selected<?php }?>>버튼형</option>
					<option value="custom" <?php if($TPL_VAR["app_config"]["popup_type"]=='custom'){?>selected<?php }?>>직접 등록</option>
				</select>
				
				<button type="button" id="app_popup_area" onclick="popupimg_modify();" class="resp_btn v2">수정</button>
				<!--
				<label class="custom_popup resp_btn v2">
					<input type="file" id="custom_popup_img" name="custom_popup_img"  accept="image/gif, image/jpeg, image/png">파일 선택
				</label>				
				<div class="custom_popup mt5 hide">
					
					<div class="mt5">
						<img src="<?php if($TPL_VAR["app_config"]["popup_type"]=='custom'){?><?php echo $TPL_VAR["app_config"]["custom_popup_img"]?><?php }?>" id="preview" />
					</div>
				</div>-->
			
				<div class="webftpFormItem popup_type_custom hide">									
					<label class="resp_btn v2 popup_type_custom_btn"><input type="file" id="custom_popup_img" class="uploadify">파일 선택</label>
					<input type="hidden" class="webftpFormItemInput" name="custom_popup_img" value="<?php echo $TPL_VAR["app_config"]["custom_popup_img"]?>"/>									
					<div class="preview_image"></div>
				</div>

				<div class="app_popup mt10" id="preview_area">
<?php if($TPL_VAR["app_config"]["pop_html"]){?>
					<?php echo $TPL_VAR["app_config"]["pop_html"]?>

					<input type="hidden" name="pop_title" value="<?php echo $TPL_VAR["app_config"]["pop_title"]?>">
					<input type="hidden" name="pop_subtitle" value="<?php echo $TPL_VAR["app_config"]["pop_subtitle"]?>">
					<input type="hidden" name="pop_sale" value="<?php echo $TPL_VAR["app_config"]["pop_sale"]?>">
					<input type="hidden" name="pop_sale_unit" value="<?php echo $TPL_VAR["app_config"]["pop_sale_unit"]?>">
					<input type="hidden" name="pop_footer_txt" value="<?php echo $TPL_VAR["app_config"]["pop_footer_txt"]?>">
					<input type="hidden" name="pop_footer_close" value="<?php echo $TPL_VAR["app_config"]["pop_footer_close"]?>">
					<input type="hidden" name="new_popup_type" value="<?php echo $TPL_VAR["app_config"]["popup_type"]?>">
					<textarea name="pop_html" style="display:none;"><?php echo $TPL_VAR["app_config"]["pop_html"]?></textarea>
<?php }?>
				</div>
			
				<ul class="bullet_hyphen resp_message">
					<li>파일 형식 jpg, jpeg, png, 가로 사이즈 300px</li>		
					<li>샘플 파일 <a href="http://userapp.firstmall.kr/data/app_popup/app_popup.zip" class="resp_btn_txt">다운로드</a></li>		
				</ul>			
			</td>
		</tr>
	</table>
	<div class="resp_message">- 앱 설치 쿠폰은 프로모션/쿠폰 > 할인 쿠폰 > <a href="/admin/coupon/regist" class="resp_btn_txt">쿠폰 등록</a>에서 발급할 수 있습니다.</div>

	<div class="item-title">앱 업데이트 권장 팝업</div>
	<table class="table_basic thl">		
		<tr>
			<th>
				사용 여부
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/mobile_app', '#tip2')"></span>
			</th>
			<td>	
				<div class="resp_radio">
					<label><input type="radio" name="app_notice_popup" value="Y" <?php if($TPL_VAR["app_config"]["app_notice_popup"]=='Y'){?>checked<?php }?> > 사용</label>				
					<label><input type="radio" name="app_notice_popup" value="N" <?php if($TPL_VAR["app_config"]["app_notice_popup"]=='N'||!$TPL_VAR["app_config"]["app_notice_popup"]){?>checked<?php }?> > 사용 안 함</label>
				</div>				
			</td>
		</tr>
	</table>

	<div class="item-title">앱 스타일</div>

	<table class="table_basic thl">		
		<tr>
			<th>하단 메뉴</th>
			<td class="clear">
				<ul class="ul_list_02">
					<li>
						<button type="button" id="footer_img_modify" onclick="footerimg_modify();" class="resp_btn v2">설정</button>
						<span id="footer_type">
<?php if($TPL_VAR["app_config"]["footer_style"]){?>
							스타일 <?php echo $TPL_VAR["app_config"]["footer_style"]?>

<?php }?>
						</span>
					</li>
					<li class="footer_type_dvs <?php if(!$TPL_VAR["app_config"]["footer_style"]){?>hide<?php }?>">					
						<input type="hidden" name="footer_style" value="<?php echo $TPL_VAR["app_config"]["footer_style"]?>" />
						<img src="<?php if($TPL_VAR["app_config"]["footer_style"]){?>/admin/skin/default/images/app/tabbar<?php echo $TPL_VAR["app_config"]["footer_style"]?>.jpg<?php }else{?><?php }?>" id="footer_type_img"/>			
					</li>
				</ul>
			</td>
		</tr>
	</table>
</div>
</form>


<!-- 앱 하단메뉴 스타일 수정 -->
<div id="footerImg_lay" class="hide">
	<div class="item-title">스타일 선택</div>
	<table class="table_basic">
		<tr>
			<th>스타일 선택</th>
			<th>미리 보기</th>
		</tr>
		<tr>
			<th class="left"><label class="resp_radio"><input type="radio" name="footer_style_tmp" value="A" checked /> 스타일 A</label></th>
			<td><img src="/admin/skin/default/images/app/tabbarA.jpg" alt="Footer Style A" /></td>
		</tr>
		<tr>
			<th class="left"><label class="resp_radio"><input type="radio" name="footer_style_tmp" value="B" /> 스타일 B</label></th>
			<td><img src="/admin/skin/default/images/app/tabbarB.jpg" alt="Footer Style B" /></td>
		</tr>
		<tr>
			<th class="left"><label class="resp_radio"><input type="radio" name="footer_style_tmp" value="C" /> 스타일 C</label></th>
			<td><img src="/admin/skin/default/images/app/tabbarC.jpg" alt="Footer Style C" /></td>
		</tr>
		<tr>
			<th class="left"><label class="resp_radio"><input type="radio" name="footer_style_tmp" value="D" /> 스타일 D</label></th>
			<td><img src="/admin/skin/default/images/app/tabbarD.jpg" alt="Footer Style D" /></td>
		</tr>
		<tr>
			<th class="left"><label class="resp_radio"><input type="radio" name="footer_style_tmp" value="E" /> 스타일 E</label></th>
			<td><img src="/admin/skin/default/images/app/tabbarE.jpg" alt="Footer Style E" /></td>
		</tr>
	</table>
	
	<div class="footer">
		<button onclick="footer_style_set();" class="resp_btn active size_XL">저장</button>
		<button onclick="closeDialog('footerImg_lay');" class="resp_btn v3 size_XL">취소</button>
	</div>
</div>

<!-- 앱 설치 권장 팝업 수정 -->
<div id="popupImg_lay" class="hide"></div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>