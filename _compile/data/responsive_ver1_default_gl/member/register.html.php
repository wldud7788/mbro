<?php /* Template_ 2.2.6 2022/01/13 10:47:07 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/member/register.html 000006478 */  $this->include_("sslAction");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 회원가입 > 회원정보 입력 @@
- 파일위치 : [스킨폴더]/member/register.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<!-- 타이틀 -->
<div class="title_container">
	<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWVtYmVyL3JlZ2lzdGVyLmh0bWw=" >회원정보 입력</span></h2>
</div>
<div class="mypage_greeting Pb30">
	<span class="pilsu_icon"></span> <span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWVtYmVyL3JlZ2lzdGVyLmh0bWw=" >항목은 <span class="pointcolor">필수 입력</span> 항목입니다.</span>
</div>


<div class="resp_member_join_wrap">
	<form name="registFrm" id="registFrm" target="actionFrame" method="post" action="<?php echo sslAction('../member_process/register_ok')?>" onSubmit="registAct()" novalidate>
	<input type="hidden" name="mtype" value="<?php echo $TPL_VAR["mtype"]?>"/>
<?php if(!$TPL_VAR["member_seq"]){?>
<?php if($TPL_VAR["mailing"]=='y'){?>
	<input type="hidden" name="mailing" value="y" />
<?php }?>
<?php if($TPL_VAR["sms"]=='y'){?>
	<input type="hidden" name="sms" value="y" />
<?php }?>
<?php }?>
	<!-- ------- 회원가입 입력폼. 파일위치 : [스킨폴더]/member/register_form.html ------- -->
<?php $this->print_("form_member",$TPL_SCP,1);?>

	<!-- ------- //회원가입 입력폼 ------- -->

	<div id="btn_register" class="btn_area_c">
		<button type="submit" class="btn_resp size_c color2 Wmax"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbWVtYmVyL3JlZ2lzdGVyLmh0bWw=" >입력 완료</span></button>
	</div>
	</form>
</div>




<script type="text/javascript">
$(document).ready(function() {

	$(".class_check_password_validation").each(function(){
		init_check_password_validation($(this));
	});
	
	$("input[name='userid']").blur(function() {
		if($(this).val()){
			$.post("../member_process/id_chk", { userid : $(this).val() }, function(response){
				//debug(response);
				var text = response.return_result;
				var userid = response.userid;
				$("#id_info").html(text);
				$("input[name='userid']").val(userid);
			},'json');
		}
    });

<?php if($TPL_VAR["mtype"]=='business'&&$TPL_VAR["joinform"]["bno_use"]=='Y'){?>
	$("input[name='bno']").blur(function() {
		if($(this).val()){
			$.post("../member_process/bno_chk", { bno : $(this).val() }, function(response){
				//debug(response);
				var text = response.return_result;
				var bno = response.bno;
				$("#bno_info").html(text);
				//$("input[name='bno']").val(bno);
			},'json');
		}
    });
<?php }?>

	$('#find_email').change(function() {
		if($(this).val() == "select"){
			$("input[name='email[1]']").val("");
			$("input[name='email[1]']").hide();
			return;
		}
		$("input[name='email[1]']").val($(this).val());
		if(!$(this).val()){
			$("input[name='email[1]']").show();
			$("input[name='email[1]']").attr("readonly",false);
		}else{
			$("input[name='email[1]']").hide();
			$("input[name='email[1]']").attr("readonly",true);
		}
	});

});

/* 2022.01.13 이메일 자동입력 커스텀 부분 */
function cngadd(address) {
	var inputText = document.getElementById("addInput");

	inputText.value = address;
}

function filterKey(e) { 
	var keycode;
	var prevent = null; 
	var filter = "[0-9a-z]";
	if(filter){
		// for something else IE
		if (e != null) {
			keycode = e.which;
			prevent = function() {
				e.which = 0;
				e.preventDefault();
			};
		}
		// for IE
		else {
			keycode = window.event.keyCode;
			prevent = function() {
				window.event.keyCode = 0;
				window.event.returnValue = false;
			};
		}

		// fromCharCode : 매개 변수에서 ASCII 값이 나타내는 문자들로 구성된 문자열을 반환합니다
		var sKey = String.fromCharCode(keycode);
		// RegExp
		// 정규표현을 취급하는 객체로 new를 사용하지 않고 정규표현 문자열을 변수에 대입하는 것으로도 동일한 결과
		var re = new RegExp(filter);
		// test() : 일치하는 문자열이 있는 경우 true, 없으면 false
		if(!re.test(sKey)) { 
			prevent();
		}
	}
}
//회원가입버튼 클릭시 버튼 숨기기
function registAct(){
	$('#btn_register').hide();
}
</script>



<?php if($TPL_VAR["joinform"]["user_icon"]=='Y'){?> 
<script type="text/javascript">
$(document).ready(function() { 
		
		$("button#membericonUpdate").live("click",function(){
			$('#membericonRegist')[0].reset();
			$("input[name=user_icon][value='99']").attr("checked",true);
			//아이콘
			showCenterLayer('#membericonUpdatePopup');
			//openDialog(getAlert('mb007'), "membericonUpdatePopup", {"width":"380","height":"150","show" : "fade","hide" : "fade"});
		});
});
	function membericonFileUpload(str){
		if(str > 0) {
			//로고를 선택해 주세요.
			alert(getAlert('mb008'));
			return false;
		}
		var frm = $('#membericonRegist');
		frm.attr("action","../member_process/membericonsave");
		frm.submit();
	}

	function membericonDisplay(filenm){
		$("#membericon_img").attr("src",filenm);
		$("#membericon_img").css("display","block"); 
		$("#membericonDelete").css("display","block");
		$('#membericonRegist')[0].reset();
		hideCenterLayer();
		//$("#membericonUpdatePopup").dialog("close");
	}
</script>

<div id="membericonUpdatePopup" class="resp_layer_pop hide">
	<h4 class="title">아이콘 등록</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5 C">
			<form name="membericonRegist" id="membericonRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">
				<p class="stitle v4 gray_03 Pt30 Pb30">
					사이즈는 30 × 30 으로 등록해 주세요.
				</p>
				<input type="file" name="membericonFile" id="membericonFile" onChange="membericonFileUpload();" />
			</form>
		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">취소</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>
<?php }?>