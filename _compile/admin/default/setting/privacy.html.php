<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/setting/privacy.html 000003592 */ ?>
<!-- 회원설정 : 개인정보처리방침 -->
<script type="text/javascript">
	$(document).ready(function() {
		var chk2 = '<?php echo $TPL_VAR["p3p_xml"]?>';
		var chk3 = '<?php echo $TPL_VAR["privacy_html"]?>';
		/*
		if(chk3){
			showTab('tab4');
		}else if(chk2){
			showTab('tab3');
		}*/

		//clipBoard('member_url','board1');
		//clipBoard('privacy_url','board2');
		apply_input_style();
		addAccordionEvent();
	});


	// 에디터 팝업 띄우기 :: 2017-05-11 lwh
	function view_editor_pop(){
		var contents_top	= $("#view_editor_div").offset().top - 100;
		$("body").css("overflow","hidden");
		openDialog("개인정보 제3자 제공동의 - <span class='desc'>수정 시 실시간으로 저장됩니다.</span>", "view_editor_div", {"width":"98.5%","draggable":false,position: ['center', 'top'],"close":function(){$("body").css("overflow",""); window.scrollTo(0,contents_top); }});
	}

	// 3자 제공동의 로드 :: 2017-05-11 lwh
	function third_party_reload(){
		$.ajax({
			'type': "POST",
			'url': "../setting/ajax_third_party",
			'dataType' : 'text',
			'success': function(res){ 
				$("#policy_third_party_area").html(res);
			}
		});
		closeDialog('view_editor_div');
	}

	function clipBoard(name, id){
		var clip = new ZeroClipboard.Client();
		clip.setHandCursor( true );
		clip.setCSSEffects( true );
		clip.setText($("input[name='"+name+"']").val());
		clip.addEventListener( 'complete', function(client, text) {
			alert("클립보드에 복사되었습니다.");
		});
		clip.glue(id);
	}

</script>

<div class="contents_dvs">
	<div class="title_dvs">
		<div class="item-title">
			개인정보처리방침
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip5', 'sizeM')"></span>
		</div>
		
		<div class="resp_btn_dvs">
			<button type="button" class="resp_btn active" onclick="window.open('https://www.privacy.go.kr/a3sc/per/inf/perInfStep01.do','','');">개인정보처리방침 만들기</button>
			<button type="button" class="resp_btn" onclick="window.open('https://www.privacy.go.kr/cmm/fms/FileDown.do?atchFileId=FILE_000000000072233&fileSn=3&nttId=1767','','');">소상공인용 작성예시</button>
			<button type="button" class="resp_btn" onclick="window.open('https://www.privacy.go.kr/cmm/fms/FileDown.do?atchFileId=FILE_000000000072233&fileSn=2&nttId=1767','','');">민간용 작성예시</button>
		</div>
	</div>

	<div class="box_style_03">
		<textarea rows="10" name="privacy"><?php echo $TPL_VAR["privacy"]?></textarea>
	</div>
</div>

<div class="contents_dvs">
	<div class="item-title">
		개인정보 수집 및 이용
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip7')"></span>	
	</div>

	<div class="box_style_03">				
		<textarea rows="10" name="policy"><?php echo $TPL_VAR["policy"]?></textarea>
	</div>
</div>


<?php if(serviceLimit('H_AD')){?>
<div class="contents_dvs">
	<div class="title_dvs">
		<div class="item-title">개인정보 제3자 제공 동의</div>
		<button type="button" class="resp_btn v2" onclick="view_editor_pop();">수정</button>
	</div>

	<div id="policy_third_party_area" style="border:0;"><?php echo $TPL_VAR["policy_third_party"]?></div>

	<div id="view_editor_div" class="hide">
		<iframe src="./privacy_third_party" style="border:0" width="99%" height="700px"></iframe>
	</div>
</div>
<?php }?>