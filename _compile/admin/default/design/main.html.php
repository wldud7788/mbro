<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/design/main.html 000005335 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<script type="text/javascript">
	var front_go_sec = 2; // n초후 이동
	var front_go_timer = setInterval("front_go()",front_go_sec*1000);

	function front_go(){
		$("#progress_bar").stop(true,true).show();
		document.location.href="../design/front_action?frontUrl=<?php echo $TPL_VAR["frontUrl"]?>";	
	}

	function front_go_stop(){
		$("#progress_bar").fadeOut();
		clearInterval(front_go_timer);
	}
</script>
<style type="text/css">
	.designMode_go {position:absolute; top:50%; left:50%; margin:-320px 0 0 -475px; text-align:center; font-family:'Malgun Gothic';}
	.designMode_go h1 {margin-bottom:30px;}
	.designMode_go .go_btn a {margin:0 5px;}
	.designMode_go .progress {margin:25px 0 50px;} 
</style>

<div class="designMode_go">
	<h1><img src="/admin/skin/default/images/design/gate_i_txt.png" alt="실제 사용자 화면에서 바로 디자인 하세요! 디자인환경으로 이동합니다."></h1>
	<div class="go_btn">
		<a href="#none" onclick="front_go_stop()"><img src="/admin/skin/default/images/design/gate_i_pause.png" alt="pause" /></a>
		<a href="#none" onclick="front_go()"><img src="/admin/skin/default/images/design/gate_i_play.png" alt="play" /></a>
	</div>
	<div class="progress"><img src="/admin/skin/default/images/design/img_progress_bar.gif" id="progress_bar" height="9" width="185" /></div>
	<img src="/admin/skin/default/images/design/gate_i_remote.png" />
</div>

<div class="pd40 center hide">
	<div class="pdt30"><img src="/admin/skin/default/images/design/gate_i_txt01.gif" alt="실제 사용자 화면에서 바로 디자인 하세요!" /></div>
	<div class="pdt30"><img src="/admin/skin/default/images/design/gate_i_txt02.gif" alt="디자인환경으로 이동합니다." /></div>
	<div class="pdt20">
		<a href="#" onclick="front_go_stop()"><img src="/admin/skin/default/images/design/gate_i_pause.gif" hspace="1" /></a>
		<a href="#" onclick="front_go()"><img src="/admin/skin/default/images/design/gate_i_play.gif" hspace="1" /></a>
	</div>
	<div class="pdt10" style="height:9px"><img src="/admin/skin/default/images/design/img_progress_bar.gif" id="progress_bar" height="9" width="185" /></div>
	
	<div style="width:600px; margin:50px auto 20px auto; border-top:2px solid #d8d8d8; border-bottom:1px solid #dfdfdf; padding:20px 5px 16px 5px; text-align:left;">
		<b>모든 디자인 요소를 자유롭게! 편리하게!</b><br />
		이미지(배너), 플래시, 상품노출, 게시판, 팝업, 레이아웃, 폰트, 배경, 스크롤		
	</div>
	
	<table style="width:600px; margin:auto; text-align:left;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" width="170"><img src="/admin/skin/default/images/design/gate_i_remote.gif" /></td>
		<td valign="top">
			<div class="relative" style="font-size:11px; color:#000; letter-spacing:-1px;">
				<div class="absolute" style="top:40px;"><img src="/admin/skin/default/images/common/btn_arrow_l.gif" hspace="2" /> 레이아웃 통합 설정하여 손쉽게 쇼핑몰 구조를 한번에 세팅합니다.</div>
				<div class="absolute" style="top:70px;"><img src="/admin/skin/default/images/common/btn_arrow_l.gif" hspace="2" /> 카테고리의 노출스타일, 정렬, 노출 수를 세팅하고 상품이미지와 정보를 꾸미고 싶을때</div>
				<div class="absolute" style="top:121px;"><img src="/admin/skin/default/images/common/btn_arrow_l.gif" hspace="2" /> 해당 페이지에서 바로 이미지 편집&변경 또는 새 이미지 편집&넣고 싶을 때</div>
				<div class="absolute" style="top:148px;"><img src="/admin/skin/default/images/common/btn_arrow_l.gif" hspace="2" /> 해당 페이지에서 바로 플래시 편집&변경과 새 플래시 만들기&넣고 싶을 때</div>
				<div class="absolute" style="top:174px;"><img src="/admin/skin/default/images/common/btn_arrow_l.gif" hspace="2" /> 해당 페이지에서 바로 노출상품선택, 상품이미지와 정보를 꾸미고 싶을 때</div>
				<div class="absolute" style="top:200px;"><img src="/admin/skin/default/images/common/btn_arrow_l.gif" hspace="2" /> 해당 페이지에서 바로 게시판을 넣고 싶을 때</div>
				<div class="absolute" style="top:227px;"><img src="/admin/skin/default/images/common/btn_arrow_l.gif" hspace="2" /> 해당 페이지에서 바로 팝업을 만들고&편집하여 팝업을 띄우고 싶을 때</div>
				<div class="absolute" style="top:253px;"><img src="/admin/skin/default/images/common/btn_arrow_l.gif" hspace="2" /> 해당 페이지에서 바로 해당 페이지의 HTML소스편집 또는 원본소르를 보고 싶을 때</div>
				<div class="absolute" style="top:280px;"><img src="/admin/skin/default/images/common/btn_arrow_l.gif" hspace="2" /> 해당 페이지에서 바로 해당 페이지의 레이아웃, 폰트, 배경 등을 세팅하고 싶을 때</div>
				<div class="absolute" style="top:307px;"><img src="/admin/skin/default/images/common/btn_arrow_l.gif" hspace="2" /> 새 페이지를 만들고 싶을 때</div>
			</div>
		</td>
	</tr>
	</table>
</div>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>