<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/setting/member.html 000006117 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/plugin/zeroclipboard/ZeroClipboard.js"></script>
<script type="text/javascript">
	function set_member_html(){
		var url = $("form[name='memberForm'] input[name='gb']").val();

<?php if($_GET["gb"]=="member_sale"&&$_GET["page"]!=""){?>
			url = url+"?page=<?php echo $_GET["page"]?>";
<?php }?>

		$.get(url, function(data) {
			$('#memberContents').html(data);
			
		});
		var gb = $("input[name='gb']").val();

		if(gb=="grade"){
			$("#left_btn").hide();
			$("#grade_btn").show();
			$("#join_btn").hide();
			$("#save_btn").hide();
			$("#member_sale_btn").hide();

		}else if(gb=="joinform"){
			$("#left_btn").hide();
			$("#grade_btn").hide();
			$("#join_btn").show();
			$("#save_btn").show();
			$("#member_sale_btn").hide();
			$("#joinDiv").dialog('close').remove();

		}else if(gb.substring(0,12)=="grade_modify"){
			$("#left_btn").show();
			$("#grade_btn").hide();
			$("#join_btn").hide();
			$("#save_btn").show();
			$("#member_sale_btn").hide();
		}else if(gb=="member_sale"){
			$("#left_btn").hide();
			$("#grade_btn").hide();
			$("#join_btn").hide();
			$("#save_btn").hide();
			$("#member_sale_btn").show();

		}else{
			$("#left_btn").hide();
			$("#grade_btn").hide();
			$("#join_btn").hide();
			$("#save_btn").show();
			$("#member_sale_btn").hide();
		}

		var clip = new ZeroClipboard.Client();
		clip.destroy();

		if(gb=='agreement'||gb=='privacy'||gb=='cancellation'||gb=='policy'){
			$("#rn_join").show();
			$('#rn_join > li').find('a').removeClass('current');
			$('#rn_join > li #'+gb).eq(0).addClass('current');
		}else{
			$("#rn_join").hide();
		}
	}

	function formMove(gb, no){		
		if(gb=='grade_write'){
			$("form[name='memberForm'] input[name='gb']").val('grade_modify');
		}else{
			$("form[name='memberForm'] input[name='gb']").val(gb);
		}

		$("form[name='memberForm']").attr('action','../member_process/'+gb);
		$("#mainTab > li:eq("+(no-1)+") > a").addClass("current");
		set_member_html();		
	}

	function formMoveSub(gb, no){
		$(".ctab-on").addClass("ctab");
		$(".ctab-on").removeClass("ctab-on");
		$(".t"+no).addClass("ctab-on");
		$("form[name='memberForm'] input[name='gb']").val(gb);
		$("form[name='memberForm']").attr('action','../member_process/'+gb);
		set_member_html();
		
		if(gb=="joinform")
		{
			$('#rn_join > li').find('a').removeClass('current')
			$('#rn_join > li').eq(0).find('a').addClass('current')
		}
	}


	$(document).ready(function() {
		// 첫로드시 "가입 > 가입형식"으로 이동(삭제 하지 마시오)
<?php if($_GET["gb"]=='realname'){?>		
			formMove('realname',8);
<?php }elseif($_GET["gb"]=='joinform'){?>			
			formMove('joinform',1);
<?php }elseif($_GET["gb"]=='agreement'){?>			
			formMove('agreement',6);
<?php }elseif($_GET["gb"]=='approval'){?>		
			formMove('approval',3);
<?php }elseif($_GET["gb"]=='grade'){?>		
			formMove('grade',4);
<?php }elseif($_GET["gb"]=='withdraw'){?>	
			formMove('withdraw',2);
<?php }elseif($_GET["gb"]=='member_sale'){?>		
			formMove('member_sale',5);
<?php }?>
		
<?php if($TPL_VAR["grade"]){?>		
		formMove('grade_modify?group_seq=<?php echo $TPL_VAR["seq"]?>', 4);
<?php }else{?>
		set_member_html();
<?php }?>

		$("#submit_btn").click(function(){
			var gb = $("input[name='gb']").val();
			if(gb.substring(0,12)=="grade_modify"){
				$("#gradeFrm").submit();
			}else{
				$("#memberForm").submit();
			}
		});			
	});
</script>
<style>
	#mainTab{display: flex;}
	#rn_join{display: flex;}
</style>
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
			<h2>
<?php if($_GET["gb"]=='agreement'){?>약관 및 개인정보처리방침<?php }elseif($_GET["gb"]=='joinform'){?>로그인 및 회원가입<?php }elseif($_GET["gb"]=='withdraw'){?>회원 정보 변경<?php }elseif($_GET["gb"]=='approval'){?>승인 혜택<?php }elseif($_GET["gb"]=='grade'){?>등급<?php }elseif($_GET["gb"]=='member_sale'){?>등급별 구매 혜택<?php }elseif($_GET["gb"]=='realname'){?>본인 확인<?php }elseif($_GET["grade"]=='modify'&&$_GET["seq"]){?>등급 수정<?php }elseif($_GET["gb"]=='grade_modify'){?>등급 등록<?php }?>
			</h2>
		</div>

		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<span id="join_btn" class="hide"><button type="button" class="resp_btn v2 size_L" id="joinBtn">가입항목 만들기</button></span>
			<span id="save_btn"><button type="button" class="resp_btn active size_L" id="submit_btn">저장</button></span>
			<span id="member_sale_btn" class="hide"><input type="button" class="resp_btn active size_L hide" value="혜택 세트 만들기" onclick="sale_write();"></span>			
		</div>
		
		<!-- 좌측 버튼 -->
		<div class="page-buttons-left">
			<span  id="left_btn" class="hide"><span class="resp_btn v3 size_L" onclick="formMove('grade',4);">리스트 바로가기</span></span>
		</div>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<form name="memberForm" id="memberForm" method="post" enctype="multipart/form-data" action="../member_process/joinform" target="actionFrame">
<input type="hidden" name="gb" value="joinform"/>

<!-- 서브 레이아웃 영역 : 시작 -->

<!-- 서브메뉴 탭 : 시작 -->
<?php $this->print_("setting_menu",$TPL_SCP,1);?>

<!-- 서브메뉴 탭 : 끝 -->

<!-- 서브메뉴 바디 : 시작-->
<!-- 상단 단계 링크 : 시작 -->

<div id="memberContents"></div>
<!-- 서브메뉴 바디 : 끝 -->

<!-- 서브 레이아웃 영역 : 끝 -->
</form>

<!-- 네이버 아이디로 로그인 API 연동 창 -->
<div id="snsdiv_n" class="snsdiv_n hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>