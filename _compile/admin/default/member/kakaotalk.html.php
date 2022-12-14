<?php /* Template_ 2.2.6 2022/05/17 12:36:27 /www/music_brother_firstmall_kr/admin/skin/default/member/kakaotalk.html 000012003 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		// 약관 전체 동의
		$(".agreement").on('click', function(){
			if(!$(this).prop('checked')){
				$("#agree_all").prop('checked', false);
			}
		});

		// 신청하기
		$("#memberForm").submit(function(){
<?php if($TPL_VAR["kakaotalk_config"]){?>
			$("#memberForm").attr('action','../member_process/kakaotalk_modify');
			$("#memberForm").submit();
<?php }else{?>
			var phoneNumber = $("input[name='phoneNumber']").val();
			var authKey		= $("input[name='authKey']").val();
			var token		= $("input[name='token']").val();
			var businessimg	= $("input[name='businessimg']").val();
			var yellowId	= $("input[name='yellowId']").val();

			if(!yellowId){
				alert('플러스친구 아이디를 입력하세요.');
				return false;
			}else if(!phoneNumber){
				alert('휴대폰 번호를 입력하세요.');
				return false;
			}else if(!businessimg){
				alert('사업자 등록증 이미지를 업로드하세요.');
				return false;
			}else{
				if(!authKey || !token){
					alert('먼저 인증번호 요청을 진행하세요.');
					return false;
				}
				$("#memberForm").submit();
			}
<?php }?>
		});
		
<?php if(!$TPL_VAR["kakaotalk_config"]){?>
		get_category_depth();
<?php }?>

		// 셀렉트 고정
		$('select#category1').val('006').trigger('change');

<?php if($TPL_VAR["categoryReset"]){?>
			$("select.category").each(function(){ $(this).removeClass('hide'); });
<?php }?>

		$("#agree1Btn").on("click", function(){			
			openDialog("서비스 이용약관 동의", "agree1Popup", {'width' : 700, 'height' : 500 });
		});

		$("#agree2Btn").on("click", function(){			
			openDialog("개인정보 수집 동의", "agree2Popup", {'width' : 700, 'height' : 500 });
		});

		$("#agree3Btn").on("click", function(){		
			openDialog("개인정보 위탁 동의", "agree3Popup", {'width' : 700, 'height' : 500 });
		});

		$('#businessImgBtn').createAjaxFileUpload(uploadConfig, uploadCallback);

	});

	// 전문 보기
	function agree_view(){
		var view_use = $(".agree_detail").hasClass('on');
		if(view_use){
			$(".agree_detail").removeClass('on');
			$(".agreement_all_desc").html('전문보기');
			$(".agreement_contents").hide();
		}else{
			$(".agree_detail").addClass('on');
			$(".agreement_all_desc").html('전문닫기');
			$(".agreement_contents").show();
		}
	}

	// 전체동의
	function agree_all_chk(){
		var agree_all = $("#agree_all").prop('checked');
		$(".agreement").prop('checked', agree_all);
	}

	// 인증토큰 요청
	function phone_auth(){
		if (!$("input[name='phoneNumber']").val()){
			alert('휴대폰번호를 입력하세요.');
			return false;
		}
		if (!$("input[name='yellowId']").val()){
			alert('플러스친구 아이디를 입력하세요.');
			return false;
		}

		var formdata	= $("#memberForm").serialize();
		$.ajax({
			'url'		: './kakaotalk_auth',
			'type'		: 'post',
			'data'		: {'formdata':formdata},
			'dataType'	: 'json',
			'success'	: function(res){
				console.log(res);
				if(res.authKey){
					alert('인증번호를 발송하였습니다.');
					$("#get_auth_token").html('인증키재요청');
					$("#auth_token").show();
					$("#auth_token").focus();
					$("input[name='authKey']").val(res.authKey);
				}else{
					openDialogAlert(res.errmsg, 400, 160);
				}
			}
		});
	}

	// 하위 카테고리 호출
	function get_category_depth(obj){

		var list		= JSON.parse('<?php echo $TPL_VAR["category_json"]?>');
		var cate_code	= $(obj).val();
		var target		= '';
		var data		= [];
		var len			= 0;

		

		if (!cate_code && !obj){
			target	= $('select#category1');
			data	= list.category1;
			$('select#category2').find('option').eq(0).nextAll().remove();
			$('select#category3').find('option').eq(0).nextAll().remove();
		}else if(cate_code == ''){
			var num = $(obj).attr('name').replace('category','');
			len		= 10;
			if(num < 3){
				num = parseInt(num) + 1;
				for(var i=num; i<4; i++){
					$('select#category'+i).find('option').eq(0).nextAll().remove();
				}
			}
		}else{
			len	= cate_code.length;
			if (len == 3){
				target = $('select#category2');
				data = list.category2;
				$('select#category3').find('option').eq(0).nextAll().remove();
			} else if (len == 7){
				target	= $('select#category3');
				data	= list.category3;
			}
		}

		if(len <= 7){
			var parent	= '';
			var opt		= '';
			target.find('option').eq(0).nextAll().remove();
			for ( var c in data ){
				parent = c.substr(0, len);
				if (parent == cate_code || !cate_code){
					opt = '<option value="' + c + '">' + "(" + c + ") " + data[c] + '</option>';
					target.append(opt);
				}
			}
			$("#category3 option:eq(1)").attr("selected","true");
			$("#category_name").val($("#category3 option:eq(1)").text());
		}
	}
</script>

<form name="memberForm" id="memberForm" method="post" enctype="multipart/form-data" target="actionFrame" action="../member_process/kakaotalk_regist">

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>카카오 알림톡</h2>
		</div>		
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">
<?php $this->print_("top_menu",$TPL_SCP,1);?>


	<!-- 서브 레이아웃 영역 : 시작 -->
<?php if($TPL_VAR["kakaotalk_config"]){?>
	<!-- 정보수정 영역 :: START -->
	<div class="item-title">알림톡 설정 및 정보</div>
	
	<table class="table_basic thl">	
		<tbody>
		<tr>
			<th>사용 여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="use_service" value="Y" <?php if($TPL_VAR["kakaotalk_config"]["use_service"]=='Y'){?> checked<?php }?>/> 사용</label>				
					<label><input type="radio" name="use_service" value="N" <?php if($TPL_VAR["kakaotalk_config"]["use_service"]=='N'||!$TPL_VAR["kakaotalk_config"]["use_service"]){?> checked<?php }?>/> 사용 안 함</label>
				</div>
				<div class="resp_message v2">- ‘사용함’으로 설정 변경 시, 자동 발송 SMS이 카카오 알림톡으로 발송됩니다.</div>
			</td>
		</tr>		
		<tr>
			<th>검색용 아이디</th>
			<td><?php echo $TPL_VAR["kakaotalk_config"]["yellowId"]?></td>
		</tr>
		<tr>
			<th>사업자번호</th>
			<td>
				<?php echo $TPL_VAR["kakaotalk_config"]["status_txt"]?> <span class="gray">(<?php echo $TPL_VAR["kakaotalk_config"]["modify_txt"]?>)</span>
			</td>
		</tr>
		</tbody>
	</table>
	<div class="resp_message">- 카카오 알림톡 발송 시간 제한 <a href="/admin/member/sms?no=5" class="resp_btn_txt">바로 가기</div>
	<!-- 정보수정 영역 :: END -->

<?php }else{?>
		<!-- 신청 영역 :: START -->
		<div class="title_dvs">
			<div class="item-title">알림톡 신청</div>
			<a href="https://center-pf.kakao.com/login" target="_blank" class="resp_btn">카카오 비즈니스 가입</a>
		</div>
		
		<input type="hidden" name="type" value="regist" />
		<input type="hidden" name="authKey" value="" />
		<table class="table_basic thl">		
			<tbody>
			<tr>
				<th>검색용 아이디</th>
				<td>
					<input type="text" name="yellowId" size=80 title="채널 개설 시 입력한 아이디 입력" value="" />				
				</td>
			</tr>
			<tr>
				<th>사업자번호</th>
				<td>
					<input type="text" name="businessLicense" id="businessLicense" value="<?php echo $TPL_VAR["businessLicense"]?>" number <?php if($TPL_VAR["businessLicense"]){?>style="background-color:#ebebe4;" readonly<?php }?> />				
				</td>
			</tr>
			<tr>
				<th>사업자등록증</th>
				<td>
					<div class="webftpFormItem">									
						<label class="resp_btn v2"><input type="file" id="businessImgBtn" accept=".jpg">파일 선택</label>
						<input type="hidden" class="webftpFormItemInput" name="businessimg" value=""/>									
						<div class="preview_image"></div>
					</div>

					<span class="resp_message v2">- 500KB 이하 jpg 파일만 업로드 가능합니다.</span>
				</td>
			</tr>
			<tr>
				<th>업종</th>
				<td>				
					<select class="category hide" name="category1" id="category1" style="width:150px;" onchange="get_category_depth(this);">
						<option value="">선택</option>
					</select>
					<select class="category" name="category2" id="category2" style="width:150px;" onchange="get_category_depth(this);">
						<option value="">선택</option>
					</select>
					<select class="category hide" name="category3" id="category3" style="width:150px;" onchange="get_category_depth(this);">
						<option value="">선택</option>
					</select>		
					<input type="hidden" name="category_name" id="category_name" value="" />
				</td>
			</tr>
			<tr>
				<th>휴대폰번호 인증</th>
				<td>
					<input type="text" name="phoneNumber" class="wp150" title="" value="" />
					<button type="button" id="get_auth_token" onclick="phone_auth();" class="resp_btn v2">인증번호 전송</button>
					<input type="text" name="token" id="auth_token" class="hide wp150" title="인증번호 입력" />			
					<div class="resp_message v2">- 카카오 비즈니스 가입 시 인증한 휴대폰번호를 입력하세요. (-제외)</div>
				</td>
			</tr>
			</tbody>
		</table>
		
		<div class="title_dvs v2">
			<span class="item-title">약관 동의</span>
			<label class="resp_checkbox ml10"><input type="checkbox" name="agree_all" id="agree_all" onclick="agree_all_chk()" value="Y" /> 전체 동의</label>
		</div>
		
		<ul class="ul_list_05 v2 mt15 ml15">		
			<li>
				<label class="resp_checkbox"><input type="checkbox" name="agree1" class="agreement" value="Y" /> 서비스 이용약관 동의 (필수)</label>
				<span class="resp_btn_txt" id="agree1Btn" >약관보기</span>
			</li>		
			<li>
				<label class="resp_checkbox"><input type="checkbox" name="agree2" class="agreement" value="Y" /> 개인정보 수집 동의 (필수)</label>
				<span class="resp_btn_txt" id="agree2Btn" >약관보기</span>
			</li>	
			<li>
				<label class="resp_checkbox"><input type="checkbox" name="agree3" class="agreement" value="Y" /> 개인정보 위탁 동의 (필수)</label>
				<span class="resp_btn_txt" id="agree3Btn" >약관보기</span>
			</li>		
		</ul>
	<!-- 신청 영역 :: END -->
<?php }?>

	<div class="footer">
		<button  <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  type="button" <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> type="submit" <?php }?> class="resp_btn active size_XL"><?php if($TPL_VAR["kakaotalk_config"]){?>저장<?php }else{?>신청<?php }?></button>
	</div>
</div>

<div id="agree1Popup" class="hide">
	<div class="content"><?php echo $TPL_VAR["agreement1"]?></div>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialog('agree1Popup')">닫기</div>
	</div>
</div>

<div id="agree2Popup" class="hide">
	<div class="content"><?php echo $TPL_VAR["agreement2"]?></div>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialog('agree2Popup')">닫기</div>
	</div
</div>

<div id="agree3Popup" class="hide">
	<div class="content"><?php echo $TPL_VAR["agreement3"]?></div>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialog('agree3Popup')">닫기</div>
	</div
</div>
</form>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>