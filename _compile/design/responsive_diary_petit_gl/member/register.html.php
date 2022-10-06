<?php /* Template_ 2.2.6 2021/02/25 14:19:06 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/member/register.html 000006913 */  $this->include_("sslAction");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 회원가입 > 회원정보 입력 @@
- 파일위치 : [스킨폴더]/member/register.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<!-- 타이틀 -->
<div class="title_container">
	<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvcmVnaXN0ZXIuaHRtbA==" >뮤직브로 통합 회원 가입</span></h2>
</div>
<div class="mypage_greeting Pb30">
	<span class="pilsu_icon"></span> <span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvcmVnaXN0ZXIuaHRtbA==" >항목은 <span class="pointcolor">필수 입력</span> 항목입니다.</span> <br><br>
	<span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvcmVnaXN0ZXIuaHRtbA==" >"회원가입 후 뮤직브로의 다양한 서비스를 이용해보세요~" </span>
	<div style="text-align: center;">
		<div style="width: 250px; display: inline-block;">
			<img src="/data/skin/responsive_diary_petit_gl/images/music_cha.jpg" alt="" style="width: 100%;" designImgSrcOri='Li4vaW1hZ2VzL211c2ljX2NoYS5qcGc=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvcmVnaXN0ZXIuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9tdXNpY19jaGEuanBn' designElement='image' >
		</div>
		<div style="width: 250px; display: inline-block;">
			<img src="/data/skin/responsive_diary_petit_gl/images/shop_cha.jpg" alt="" style="width: 100%;" designImgSrcOri='Li4vaW1hZ2VzL3Nob3BfY2hhLmpwZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvcmVnaXN0ZXIuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsL2ltYWdlcy9zaG9wX2NoYS5qcGc=' designElement='image' >
		</div>
	</div>
</div>


<div class="resp_member_join_wrap">
	<form name="registFrm" id="registFrm" target="actionFrame" method="post" action="<?php echo sslAction('../member_process/register_ok')?>" onSubmit="registAct()" novalidate>
	<input type="hidden" name="mtype" value="<?php echo $TPL_VAR["mtype"]?>"/>
	
	<!-- ------- 회원가입 입력폼. 파일위치 : [스킨폴더]/member/register_form.html ------- -->
<?php $this->print_("form_member",$TPL_SCP,1);?>

	<!-- ------- //회원가입 입력폼 ------- -->

	<div id="btn_register" class="btn_area_c">
		<button type="submit" class="btn_resp size_c color2 Wmax"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvcmVnaXN0ZXIuaHRtbA==" >입력 완료</span></button>
	</div>
	</form>
</div>




<script type="text/javascript">
$(document).ready(function() {
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
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>
<?php }?>