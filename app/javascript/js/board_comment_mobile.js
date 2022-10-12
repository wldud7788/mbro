var dynamic_js	= document.createElement('script');
dynamic_js.src	= '/app/javascript/js/board_comment_common.js';
document.getElementsByTagName('head')[0].appendChild(dynamic_js);

if(!$.isFunction("getAuthLogin")){
    function getAuthLogin(){
		//접근권한이 없습니다.!
		openDialogAlert(getAlert('et236'),'400','150','');
	}
}

if(!$.isFunction("getLogin")){
    function getLogin(){
		//이용하시려면 로그인이 필요합니다!
		openDialogAlert(getAlert('et237'),'400','155','');
	}
}
if(!$.isFunction("getMbLogin")){
	function getMbLogin(){
		openDialogAlert(getAlert('et237'),'400','155','');
	}
}

var pagemode = (pagemode)?pagemode:'ajax';

$(document).ready(function() {
	$(".viewerlay_close_btn").live("click",function(){
		var board_seq = $(this).attr('board_seq');
		$("#viewer"+board_seq).hide();
		$("#viewer"+board_seq).html('');
		$("#tdviewer"+board_seq).hide();
	});

	// 댓글 등록창 열기
	$(".board_comment_btn").live("click",function(){
		var comment_btn_seq = $(this).attr("seq");
		if	($(this).hasClass('isopen')){
			$(this).val(getAlert("sy075")+'▼');    // '댓글 등록하기▼');
			$(this).removeClass('isopen');
			$("#cmt_insert_"+comment_btn_seq).hide();
			//$("#cmt_insert_"+comment_btn_seq).toggle('slow');//slideUp(500);
		}else{
			$(this).val(getAlert("sy076")+'▲'); // 댓글 닫기
			$(this).addClass('isopen');
			$('#cmtpw').val('');
			$('#cmtcontent').val('');
			$("#cmt_insert_"+comment_btn_seq).show();
			//$("#cmt_insert_"+comment_btn_seq).toggle('slow');//slideDown(500);
		}
		setDefaultText();
	});

	// 댓글 등록창 닫기
	$("#board_comment_cancel").live("click",function(){
		var comment_btn_seq = $(this).attr("seq");
		$('#cmtmode').val('board_comment_write');
		if(!gl_isuser){
			$('#cmtpw').val('');
		}
		$('#cmtcontent').val('');
		$("#cmt_insert_"+comment_btn_seq).toggle('slow');//slideUp(500);
		$("#board_comment_btn_"+comment_btn_seq).val(getAlert("sy075")+'▼');    // '댓글 등록하기▼');
		$("#board_comment_btn_"+comment_btn_seq).removeClass('isopen');
		setDefaultText();
	});


	if($.cookie("cmtlistlay")) {$("#cmtlistlay").show();}

	$("#commentlayshow").live("click",function() {
		$.cookie( "cmtlistlay", '1' );
		if ( comment > 0 ) {
			$("#cmtlistlay").toggle();
		}

		if ( commentlay != 'N' && isperm_write != "_no" ) {
			$('#cmtform1')[0].reset();//초기화
		}
		setDefaultText();
	});

	// 비회원 > 게시글 수정
	$(".goods_boad_modify_btn_no").live("click", function() {
		$('#ModDelBoardPwcheckForm')[0].reset();//초기화
		var seq = $(this).attr('board_seq');
		var viewlink = $(this).attr('viewlink');
		$("#moddel_pwck_seq").val(seq);
		$("#moddel_pwck_returnurl").val(boardmodifyurl+seq);
		$("#modetype").val('board_modify');
		//게시글수정 <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et265'), "ModDelBoardPwCk_m", {"width":"370","height":"250"});
	});

	// 비회원 > 게시글 삭제
	$(".goods_boad_delete_btn_no").live("click", function() {
		$('#ModDelBoardPwcheckForm')[0].reset();//초기화
		var seq = $(this).attr('board_seq');
		var viewlink = $(this).attr('viewlink');
		$("#moddel_pwck_seq").val(seq);
		$("#moddel_pwck_returnurl").val(boardlistsurl);
		$("#mode").val('board_delete');
		//게시글삭제  <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et266'), "ModDelBoardPwCk_m", {"width":"370","height":"250"});
	});

	//비밀글 > 비번체크
	$("#ModDelBoardPwcheckForm").validate({
		submitHandler: function(form) {
			var seq = $("#moddel_pwck_seq").val();
			var pw = $("#moddel_pwck_pw").val();
			var modetype = $("#modetype").val();
			var returnurl = $("#moddel_pwck_returnurl").val();
			if(!pw || pw == $("#moddel_pwck_pw").attr('title') ){
				setDefaultText();
				//비밀번호를 입력해 주세요.
				alert(getAlert('et250'));
				$("#moddel_pwck_pw").focus();
				return false;
			}else{
				$.ajax({
					'url' : '../board_process',
					'data' : {'mode':'board_modifydelete_pwckeck','modetype':modetype, 'seq':seq, 'pw':pw, 'board_id':board_id},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res) {
						if(res.result == true){
							if(res.msg){
								openDialogAlert(res.msg,'400','140',function(){document.location.href=returnurl;});
							}else{
								if(modetype == 'board_delete' ){
									//정상적으로 삭제되었습니다.
									openDialogAlert(getAlert('et267'),'400','140',function(){document.location.href=returnurl;});
								}else{
									document.location.href=returnurl;
								}
							}
						}else{
							if(res.msg){
								openDialogAlert(res.msg,'400','140',function(){});
							}else{
								//잘못된 접근입니다.
								openDialogAlert(getAlert('et245'),'400','140',function(){});
							}
						}
					}
				});
			}//endif
			return false;
		}
	});

	//댓글 작성권한없음
	$("#cwrite_no").live("click",function() {
		getboardLogin();
	});

	/* 댓글 등록 및 수정
	 * Heavy Mobile, Light 마이페이지 댓글 영역에서는 미사용
	 * 실제 사용 위치: app/javascript/js/board_mobile.js
	 */
	$('#cmtform1').validate({
		onkeyup: false,
		rules: {
			name: { required:true},
			content: { required:true}
		},
		messages: {
			name: { required:''},
			captcha_code: { required:''},
			pw: { required:''},
			content: { required:''}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent());
		},
		submitHandler: function(f) {

			if(!$("#cmtname").val() || $("#cmtname").val() == $("#cmtname").attr('title') ) {
				setDefaultText();
				//이름을 입력해 주세요.
				alert(getAlert('et249'));
				$("#cmtname").focus();
				return false;
			}
			if(!$("#cmtcontent").val() || $("#cmtcontent").val() == "<p>&nbsp;</p>"  || $("#cmtcontent").val() == $("#cmtcontent").attr('title') ){
				setDefaultText();
				//내용을 입력해 주세요.
				alert(getAlert('et268'));
				$("#cmtcontent").focus();
				return false;
			}

			/*{? !defined('__ISUSER__') }*/
				//비회원 개인정보 동의
				if($(this).find("input[name='agree']").length > 0 && !$(this).find("input[name='agree']").is(":checked")){
					setDefaultText();
					//개인정보 수집 및 이용에 동의하셔야 합니다.
					alert(getAlert('et139'));
					$(this).find("input[name='agree']").focus();
					return false;
				}
			/*{ / }*/
			f.submit();
		}
	});

	/* 댓글 등록 및 수정
	 * Heavy Mobile, Light 댓글 영역에서는 사용
	 */
	$('').validate({
		onkeyup: false,
		rules: {
			name: { required:true},
			content: { required:true}
		},
		messages: {
			name: { required:''},
			captcha_code: { required:''},
			pw: { required:''},
			content: { required:''}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent());
		},
		submitHandler: function(f) {

			if(!$("#cmtname").val() || $("#cmtname").val() == $("#cmtname").attr('title') ) {
				setDefaultText();
				//이름을 입력해 주세요.
				alert(getAlert('et249'));
				$("#cmtname").focus();
				return false;
			}
			if(!$("#cmtcontent").val() || $("#cmtcontent").val() == "<p>&nbsp;</p>"  || $("#cmtcontent").val() == $("#cmtcontent").attr('title') ){
				setDefaultText();
				//내용을 입력해 주세요.
				alert(getAlert('et268'));
				$("#cmtcontent").focus();
				return false;
			}

			/*{? !defined('__ISUSER__') }*/
			//비회원 개인정보 동의
			if($(this).find("input[name='agree']").length > 0 && !$(this).find("input[name='agree']").is(":checked")){
				setDefaultText();
				//개인정보 수집 및 이용에 동의하셔야 합니다.
				alert(getAlert('et139'));
				$(this).find("input[name='agree']").focus();
				return false;
			}
			/*{ / }*/
			f.submit();
		}
	});

	//비회원 > 비밀댓글 비밀번호입력창
	$("span.boad_cmt_content_hidden_no").live("click",function(){
		$('#CmtBoardPwcheckFormNew')[0].reset();//초기화
		var seq = $('#board_seq').val();
		var cmtseq = $(this).attr("board_cmt_seq");
		var cmtreplyseq = $(this).attr("board_cmt_reply_seq");

		$("#cmtmodetype_new").val('view');
		$("#cmt_pwck_seq_new").val(seq);
		$("#cmt_pwck_cmtseq_new").val(cmtseq);
		$("#cmt_pwck_cmtreplyseq_new").val(cmtreplyseq);
		//비밀댓글 보기 <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et258'), "CmtBoardPwCkNew", {"width":"370","height":"230"});
	});

	//비회원 > 비밀답글 비밀번호입력창
	$("span.boad_cmt_reply_content_hidden_no, span.boad_cmt_reply_content_hidden_mbno").live("click",function(){
		$('#CmtBoardPwcheckFormNew')[0].reset();//초기화
		var seq = $('#board_seq').val();
		var cmtseq = $(this).attr("board_cmt_seq");
		var cmtreplyseq = $(this).attr("board_cmt_reply_seq");
		var cmtidx = $(this).attr("board_cmt_idx");

		$("#cmtmodetype_new").val('reply_view');
		$("#cmt_pwck_seq_new").val(seq);
		$("#cmt_pwck_cmtseq_new").val(cmtseq);
		$("#cmt_pwck_cmtreplyseq_new").val(cmtreplyseq);
		$("#cmt_pwck_cmtreplyidx_new").val(cmtidx);
		//비밀답글 보기 <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et259'), "CmtBoardPwCkNew", {"width":"370","height":"230"});
	});

	//비회원 댓글 수정
	$("[name=boad_cmt_modify_btn_no]").live("click", function() {
		$('#CmtBoardPwcheckFormNew')[0].reset();//초기화
		var seq = $('#board_seq').val();
		var cmtseq = $(this).attr("board_cmt_seq");

		$("#cmtmodetype_new").val('modify');
		$("#cmt_pwck_seq_new").val(seq);
		$("#cmt_pwck_cmtseq_new").val(cmtseq);
		//댓글 수정 <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et243'), "CmtBoardPwCkNew", {"width":"370","height":"250"});
	});

	// 회원 댓글 수정
	$("[name=boad_cmt_modify_btn]").live("click", function() {
		var cmtseq = $(this).attr("board_cmt_seq");
		getModifyCmt(cmtseq);
		/**
		var board_id = $('#board_id').val();
		var seq = $('#board_seq').val();
		var returnurl = $('#cmtreturnurl').val();

		if( $("#mod_contents_"+cmtseq).css('display') == 'none' ){
			$.ajax({
				'url' : '../board_comment_process',
				'data' : {'mode':'board_comment_item', 'cmtseq':cmtseq, 'seq':seq, 'board_id':board_id},
				'type' : 'post',
				'dataType': 'json',
				'success': function(data) {
					$("#mod_contents_"+cmtseq).toggle('slow');//slideDown(500);
					setDefaultText();
				}
			});
		}else{
			$("#mod_contents_"+cmtseq).toggle('slow');
		}
		**/
	});

	//댓글 수정 : 회원글인 경우 로그인
	$("[name=boad_cmt_modify_btn_mbno], [name=boad_cmt_modify_btn_hidden_mbno]").live("click", function() {
		getcmtMbLogin();
	});

	// 댓글 삭제
	$("[name=boad_cmt_delete_btn]").live("click",function(){
		var cmtseq = $(this).attr("board_cmt_seq");
		var seq = $('#board_seq').val();
		var returnurl = $('#cmtreturnurl').val();
		//정말로 댓글을 삭제하시겠습니까?
		if(confirm(getAlert('et244'))) {
			if(gl_isuser) {
				$.ajax({
					'url' : '../board_comment_process',
					'data' : {'mode':'board_comment_delete', 'delcmtseq':cmtseq, 'seq':seq, 'board_id':board_id},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){
						if(res) {
							if(res.result == true){
								if(res.callback){
									openDialogAlert(res.msg,'400','150',function(){boardviewtype_m_only(returnurl,seq,"ajax","down",res.comment_cnt);});//boardviewtypeshow(returnurl,seq,pagemode);
								}else{
									openDialogAlert(res.msg,'400','150',function(){document.location.href=returnurl;});
								}
							}else{
								openDialogAlert(res.msg,'400','150',function(){});
							}
						}else{
							//잘못된 접근입니다.
							openDialogAlert(getAlert('et240'),'400','150',function(){});
						}
					}
				});
			}else{
				$.ajax({
					'url' : '../board_comment_process',
					'data' : {'mode':'board_comment_delete_pwcheck', 'delcmtseq':cmtseq, 'seq':seq,  'board_id':board_id, 'returnurl':returnurl, 'view':'comment_delete'},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){
						if(res) {
							if(res.result == true){
								if(res.callback){
									openDialogAlert(res.msg,'400','150',function(){boardviewtype_m_only(returnurl,seq,"ajax","down",res.comment_cnt);});//boardviewtypeshow(returnurl,seq,pagemode);
								}else{
									openDialogAlert(res.msg,'400','150',function(){document.location.href=returnurl;});
								}
							}else{
								openDialogAlert(res.msg,'400','150',function(){});
							}
						}else{
							//잘못된 접근입니다.
							openDialogAlert(getAlert('et240'),'400','150',function(){});
						}
					}
				});
			}
		}
	});

	//댓글취소
	$("#board_comment_cancel").live("click",function(){
		$('#cmtseq').val('');
		if(!gl_isuser){
			$('#cmtname').val('');
			$('#cmtpw').val('');
		}
		$('#cmtcontent').val('');
		$('#cmtmode').val('board_comment_write');
		setDefaultText();
	});

	// 댓글 수정 닫기
	$("#board_comment_cancel_mod").live("click",function(){
		var cmtseq = $(this).attr("board_cmt_seq");
		$('#cmtmode').val('board_comment_write');
		$('#cmtpw').val('');
		$('#cmtcontent').val('');
		$("#mod_contents_"+cmtseq).toggle('slow');//slideUp(500);
	});

	//댓글 > 답글 등록폼 작성권한없음
	$("[name=boad_cmt_reply_btn_no]").live("click", function() {
		getboardLogin();
	});

	//댓글 > 답글 등록가능함
	$("[name=boad_cmt_reply_btn]").live("click", function() {
		var idx = $(this).attr("board_cmt_idx");
		var cmtseq = $(this).attr("board_cmt_seq");
		$(".cmtreplyform"+cmtseq).toggle('slow');
		$(".cmtreplyform"+cmtseq).find('.captcha_code').val('');
		//답글등록
		$('#board_commentsend_reply'+cmtseq).text(getAlert('et247'));
		$('#board_commentsend_reply'+cmtseq).attr('board_cmt_reply_seq','');
		setDefaultText();
	});

	//회원 댓글 > 답글 수정
	$("[name=boad_cmt_modify_reply_btn]").live("click", function() {
		var cmtseq = $(this).attr("board_cmt_seq");
		var cmtreplyseq = $(this).attr("board_cmt_reply_seq");
		var cmtreplyidx = $(this).attr("board_cmt_idx");
		getModifyReplyCmt(cmtseq, cmtreplyseq, cmtreplyidx);
	});

	//비회원 댓글 수정
	$("[name=boad_cmt_modify_reply_btn_no]").live("click", function() {
		$('#CmtBoardPwcheckFormNew')[0].reset();//초기화
		var seq = $('#board_seq').val();
		var cmtseq = $(this).attr("board_cmt_seq");
		var cmtreplyseq = $(this).attr("board_cmt_reply_seq");
		var cmtidx = $(this).attr("board_cmt_idx");

		$("#cmtmodetype_new").val('reply_modify');
		$("#cmt_pwck_seq_new").val(seq);
		$("#cmt_pwck_cmtseq_new").val(cmtseq);//답글의 부모고유번호
		$("#cmt_pwck_cmtreplyseq_new").val(cmtreplyseq);//답글본래고유번호
		$("#cmt_pwck_cmtreplyidx_new").val(cmtidx);
		//답글 수정  <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et243'), "CmtBoardPwCkNew", {"width":"370","height":"250"});

	});


	//댓글 > 답글 등록/수정
	$("[name=board_commentsend_reply]").live("click", function() {
		var idx = $(this).attr("board_cmt_idx");
		var cmtseq			= $(this).attr("board_cmt_seq");//parent comment seq
		var cmtreplyseq	= $(this).attr("board_cmt_reply_seq");//reply comment seq
		var isperm_moddel	= $(this).attr("isperm_moddel");
		var board_id = $('#board_id').val();
		var seq = $('#board_seq').val();
		var returnurl = $('#cmtreturnurl').val();
		var cmtpage			= $('#cmtpage').val();
		returnurl += "&cmtpage="+cmtpage;

		var cmtcontent = $("#cmtcontent"+cmtseq).val();
		var cmthidden = ($("#cmthidden"+cmtseq).attr("checked"))?1:0;

		var user_name = $("#cmtname"+cmtseq).val();
		var password = $("#cmtpw"+cmtseq).val();
		var captcha_code = $(".cmtreplyform"+cmtseq).find('.captcha_code').val();
		var cmtagree	 = '';
		if($("#cmtagree"+cmtseq).length == 1) {
			cmtagree = $("#cmtagree"+cmtseq).val();
		}

		if(!gl_isuser){
			if(!user_name || user_name == $("#cmtname"+cmtseq).attr('title')) {
				setDefaultText();
				//이름을 입력해 주세요.
				alert(getAlert('et241'));
				$("#cmtname"+cmtseq).focus();
				return false;
			}

			if( !isperm_moddel ) {
				if(!password || password == $("#cmtpw"+cmtseq).attr('title') ) {
				setDefaultText();
					//비밀번호를 입력해 주세요.
					alert(getAlert('et250'));
					$("#pw"+cmtseq).focus();
					return false;
				}
			}
		}

		if(!cmtcontent || cmtcontent == $("#cmtcontent"+cmtseq).attr('title') ) {
				setDefaultText();
				//답글을 입력해 주세요.
			alert(getAlert('et251'));
			$("#cmtcontent"+cmtseq).focus();
			return false;
		}

		if(cmtreplyseq) {//답글수정시
			$.ajax({
				'url' : '../board_comment_process',
				'data' : {'mode':'board_comment_reply_modify_pwcheck','viewtype':pagemode, 'cmtseq':cmtreplyseq, 'seq':seq, 'board_id':board_id, 'name':user_name, 'pw':password, 'content':cmtcontent, 'captcha_code':captcha_code, 'returnurl':returnurl, 'hidden':cmthidden, 'agree' : cmtagree},
				'type' : 'post',
				'dataType': 'json',
				'async': false,
				'success' : function(res){
					if(res) {
						if(res.result == true){
							if(res.callback){
								openDialogAlert(res.msg,'400','140',function(){
										var viewlink = boardviewurl+seq;
										if(pagemode == 'ajax'){
											boardviewtype_m_only(viewlink,seq,"ajax","down",res.comment_cnt);
										}else{
											document.location.href=viewlink;
										}
									});
							}else{
								openDialogAlert(res.msg,'400','140',function(){document.location.href=returnurl;});
							}
							if (typeof pageRefresh != 'undefined') {
								pageRefresh();
							}
						}else{
							openDialogAlert(res.msg,'400','140',function(){});
						}
					}else{
						//잘못된 접근입니다.
						openDialogAlert(getAlert('et240'),'400','140',function(){});
					}
				}
			});
		}else{//답글등록시
			$.ajax({
				'url' : '../board_comment_process',
				'data' : {'mode':'board_comment_reply','viewtype':pagemode, 'cmtseq':cmtseq, 'seq':seq, 'board_id':board_id, 'name':user_name, 'pw':password, 'content':cmtcontent, 'captcha_code':captcha_code, 'returnurl':returnurl, 'hidden':cmthidden , 'agree' : cmtagree},
				'type' : 'post',
				'async': false,
				'dataType': 'json',
				'success' : function(res){
					if(res) {
						if(res.result == true){
							if(res.callback){
								openDialogAlert(res.msg,'400','140',function(){
										var viewlink = boardviewurl+seq;
										if(pagemode == 'ajax'){
												boardviewtype_m_only(viewlink,seq,"ajax","down",res.comment_cnt);
										}else{
											document.location.href=viewlink;
										}
									});
							}else{
								openDialogAlert(res.msg,'400','140',function(){document.location.href=returnurl;});
							}
							if (typeof pageRefresh != 'undefined') {
								pageRefresh();
							}
						}else{
							openDialogAlert(res.msg,'400','140',function(){});
						}
					}else{
						//잘못된 접근입니다.
						openDialogAlert(getAlert('et240'),'400','140',function(){});
					}
				}
			});
		}
	});


	//답글취소
	$("button[name=board_comment_reply_cancel]").live("click",function(){
		var cmtseq = $(this).attr("board_cmt_seq");
		$("#cmtname"+cmtseq).val('');
		$("#cmtpw"+cmtseq).val('');
		$("#cmtcontent"+cmtseq).val('');
		$('#board_comment_reply_cancel'+cmtseq).attr('board_cmt_reply_seq','');
		$(".cmtreplylay").hide();//답글폼숨김
		setDefaultText();
	});


	//비회원 > 댓글, 답글 비밀번호입력창
	$("[name=boad_cmt_delete_btn_no]").live("click",function(){
		$('#CmtBoardPwcheckFormNew')[0].reset();//초기화
		var seq = $('#board_seq').val();
		var cmtseq = $(this).attr("board_cmt_seq");
		var cmtreplyseq = $(this).attr("board_cmt_reply_seq");
		var cmtidx = $(this).attr("board_cmt_idx");
				
		$("#cmtmodetype_new").val('delete');
		$("#cmt_pwck_seq_new").val(seq);
		$("#cmt_pwck_cmtseq_new").val(cmtseq);//답글의 부모고유번호
		$("#cmt_pwck_cmtreplyseq_new").val(cmtreplyseq);//답글본래고유번호
		$("#cmt_pwck_cmtreplyidx_new").val(cmtidx);
		//댓글삭제 <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et252'), "CmtBoardPwCkNew", {"width":"370","height":"230"});
	});

	//댓글 > 덧글 : 회원글 로그인
	$("[name=boad_cmt_modify_reply_btn_mbno], [name=boad_cmt_modify_reply_btn_hidden_mbno], [name=boad_cmt_delete_btn_mbno], [name=boad_cmt_delete_btn_hidden_mbno], [name=boad_cmt_delete_reply_btn_hidden_mbno],[name=boad_cmt_delete_reply_btn_mbno], span.boad_cmt_content_hidden_mbno, ").live("click",function(){
		getcmtMbLogin();
	});

	//비회원 비밀댓글 수정
	$("[name=boad_cmt_modify_btn_hidden_no]").live("click", function() {
		$('#CmtBoardPwcheckFormNew')[0].reset();//초기화
		var seq = $('#board_seq').val();
		var cmtseq = $(this).attr("board_cmt_seq");

		$("#cmtmodetype_new").val('modify');
		$("#cmt_pwck_seq_new").val(seq);
		$("#cmt_pwck_cmtseq_new").val(cmtseq);
		//비밀댓글 수정 <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et253'), "CmtBoardPwCkNew", {"width":"370","height":"250"});
	});

	//비회원 비밀답글 수정
	$("[name=boad_cmt_modify_reply_btn_hidden_no]").live("click", function() {
		$('#CmtBoardPwcheckFormNew')[0].reset();//초기화
		var seq = $('#board_seq').val();
		var cmtseq = $(this).attr("board_cmt_seq");
		var cmtreplyseq = $(this).attr("board_cmt_reply_seq");
		var cmtidx = $(this).attr("board_cmt_idx");

		$("#cmtmodetype_new").val('reply_modify');
		$("#cmt_pwck_seq_new").val(seq);
		$("#cmt_pwck_cmtseq_new").val(cmtseq);//답글의 부모고유번호
		$("#cmt_pwck_cmtreplyseq_new").val(cmtreplyseq);//답글본래고유번호
		$("#cmt_pwck_cmtreplyidx_new").val(cmtidx);
		//비밀답글 수정  <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et254'), "CmtBoardPwCkNew", {"width":"370","height":"250"});
	});

	//비회원 > 비밀댓글 비밀번호입력창
	$("[name=boad_cmt_delete_btn_hidden_no]").live("click",function(){
		$('#CmtBoardPwcheckFormNew')[0].reset();//초기화
		var seq = $('#board_seq').val();
		var cmtseq = $(this).attr("board_cmt_seq");

		$("#cmtmodetype_new").val('delete');
		$("#cmt_pwck_seq_new").val(seq);
		$("#cmt_pwck_cmtseq_new").val(cmtseq);
		//비밀댓글 삭제 <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et255'), "CmtBoardPwCkNew", {"width":"370","height":"250"});
	});

	//답글삭제
	$("[name=boad_cmt_delete_reply_btn]").live("click",function(){
		var cmtseq = $(this).attr("board_cmt_reply_seq");//$(this).attr("board_cmt_seq");
		var seq = $('#board_seq').val();
		var returnurl = $('#cmtreturnurl').val();
		//정말로 댓글을 삭제하시겠습니까?
		if(confirm(getAlert('et244'))) {
			if(gl_isuser) {
				$.ajax({
					'url' : '../board_comment_process',
					'data' : {'mode':'board_comment_delete', 'delcmtseq':cmtseq, 'seq':seq, 'board_id':board_id},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){
						if(res) {
							if(res.result == true){
								if(res.callback){
									openDialogAlert(res.msg,'400','150',function(){boardviewtype_m_only(returnurl,seq,"ajax","down",res.comment_cnt);});//boardviewtypeshow(returnurl,seq,'layer');
								}else{
									openDialogAlert(res.msg,'400','150',function(){document.location.href=returnurl;});
								}
							}else{
								openDialogAlert(res.msg,'400','150',function(){});
							}
						}else{
							//잘못된 접근입니다.
							openDialogAlert(getAlert('et245'),'400','150',function(){});
						}
					}
				});
			}else{
				$.ajax({
					'url' : '../board_comment_process',
					'data' : {'mode':'board_comment_delete_pwcheck', 'delcmtseq':cmtseq, 'seq':seq,  'board_id':board_id, 'returnurl':returnurl, 'view':'comment_delete'},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){
						if(res) {
							if(res.result == true){
								if(res.callback){
									openDialogAlert(res.msg,'400','150',function(){boardviewtype_m_only(returnurl,seq,"ajax","down",res.comment_cnt);});//boardviewtypeshow(returnurl,seq,'layer');
								}else{
									openDialogAlert(res.msg,'400','150',function(){document.location.href=returnurl;});
								}
							}else{
								openDialogAlert(res.msg,'400','150',function(){});
							}
						}else{
							//잘못된 접근입니다.
							openDialogAlert(getAlert('et245'),'400','150',function(){});
						}
					}
				});
			}
		}
	});
	//비회원 > 비밀답글 비밀번호입력창
	$("[name=boad_cmt_delete_reply_btn_no], [name=boad_cmt_delete_reply_btn_hidden_no]").live("click",function(){
		$('#CmtBoardPwcheckFormNew')[0].reset();//초기화
		var seq = $('#board_seq').val();
		var cmtseq = $(this).attr("board_cmt_seq");
		var cmtreplyseq = $(this).attr("board_cmt_reply_seq");

		$("#cmtmodetype_new").val('reply_delete');
		$("#cmt_pwck_seq_new").val(seq);
		$("#cmt_pwck_cmtseq_new").val(cmtseq);
		$("#cmt_pwck_cmtreplyseq_new").val(cmtreplyseq);
		//비밀답글 삭제 <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et257'), "CmtBoardPwCkNew", {"width":"370","height":"250"});
	});

	//비회원 > 비밀댓글 비밀번호입력창
	$("span.boad_cmt_content_hidden_no").live("click",function(){
		$('#CmtBoardPwcheckFormNew')[0].reset();//초기화
		var seq = $('#board_seq').val();
		var cmtseq = $(this).attr("board_cmt_seq");
		var cmtreplyseq = $(this).attr("board_cmt_reply_seq");

		$("#cmtmodetype_new").val('view');
		$("#cmt_pwck_seq_new").val(seq);
		$("#cmt_pwck_cmtseq_new").val(cmtseq);
		$("#cmt_pwck_cmtreplyseq_new").val(cmtreplyseq);
		//비밀댓글 보기 <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et258'), "CmtBoardPwCkNew", {"width":"370","height":"250"});
	});

	//비회원 > 비밀답글 비밀번호입력창
	$("span.boad_cmt_reply_content_hidden_no, span.boad_cmt_reply_content_hidden_mbno").live("click",function(){
		$('#CmtBoardPwcheckFormNew')[0].reset();//초기화
		var seq = $('#board_seq').val();
		var cmtseq = $(this).attr("board_cmt_seq");
		var cmtreplyseq = $(this).attr("board_cmt_reply_seq");
		var cmtidx = $(this).attr("board_cmt_idx");

		$("#cmtmodetype_new").val('reply_view');
		$("#cmt_pwck_seq_new").val(seq);
		$("#cmt_pwck_cmtseq_new").val(cmtseq);
		$("#cmt_pwck_cmtreplyseq_new").val(cmtreplyseq);
		$("#cmt_pwck_cmtreplyidx_new").val(cmtidx);
		//비밀답글 보기 <span class='desc'>비밀번호를 입력해 주세요.</span>
		openDialog(getAlert('et259'), "CmtBoardPwCkNew", {"width":"370","height":"250"});
	});


	//비회원 > 비밀댓글 비밀번호입력창
	$("#CmtBoardPwcheckBtnNew").live("click",function(){
		var modetype = $(this).parents("form").find("#cmtmodetype_new").val();
		var seq = $(this).parents("form").find("#cmt_pwck_seq_new").val();
		var cmtseq = $(this).parents("form").find("#cmt_pwck_cmtseq_new").val();//본래글
		var cmtreplyseq = $(this).parents("form").find("#cmt_pwck_cmtreplyseq_new").val();//부모글
		var cmtreplyidx = $(this).parents("form").find("#cmt_pwck_cmtreplyidx_new").val();
		var pw = $(this).parents("form").find("#cmt_pwck_pw_new").val();
		var returnurl = $('#cmtreturnurl').val();
		if(!pw || pw == $(this).parents("form").find("#cmt_pwck_pw_new").attr('title') ) {
				setDefaultText();
				//비밀번호를 입력해 주세요.
			alert(getAlert('et250'));
			$(this).parents("form").find("#cmt_pwck_pw_new").focus();
			return false;
		}else{
			cmtboardcheckform(modetype, seq, cmtseq, cmtreplyseq, pw, board_id, cmtreplyidx, returnurl);
		}//endif
	});

	//비밀글추가 관련 댓글
	$("#CmtBoardPwcheckFormNew").validate({
		submitHandler: function(form) {
			var modetype = $("#cmtmodetype_new").val();
			var seq = $("#cmt_pwck_seq_new").val();
			var cmtseq = $("#cmt_pwck_cmtseq_new").val();//본래글
			var cmtreplyseq = $("#cmt_pwck_cmtreplyseq_new").val();//부모글
			var cmtreplyidx = $("#cmt_pwck_cmtreplyidx_new").val();
			var pw = $("#cmt_pwck_pw_new").val();
			var returnurl = $('#cmtreturnurl').val();
			if(!pw || pw == $(this).parents("form").find("#cmt_pwck_pw_new").attr('title') ) {
				setDefaultText();
				//비밀번호를 입력해 주세요.
				alert(getAlert('et250'));
				$(this).parents("form").find("#cmt_pwck_pw_new").focus();
				return false;
			}else{
				cmtboardcheckform(modetype, seq, cmtseq, cmtreplyseq, pw, board_id, cmtreplyidx, returnurl);
			}//endif
		}
	});

	//기존 비회원 > 댓글, 답글 삭제
	$("#CmtBoardPwcheckForm").validate({
		submitHandler: function(form) {
			var seq = $("#cmt_pwck_seq").val();
			var cmtseq = $("#cmt_pwck_cmtseq").val();
			var pw = $("#cmt_pwck_pw").val();
			if(!pw || pw == $("#cmt_pwck_pw").attr('title') ){
				setDefaultText();
				//비밀번호를 입력해 주세요.
				alert(getAlert('et250'));
				$("#cmt_pwck_pw").focus();
				return false;
			}else{
				var returnurl = $('#cmtreturnurl').val();
				$.ajax({
					'url' : '../board_comment_process',
					'data' : {'mode':'board_comment_delete_pwcheck','viewtype':pagemode, 'delcmtseq':cmtseq, 'seq':seq,  'pw':pw, 'board_id':board_id},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){
						if(res) {
							var viewlink = boardviewurl+seq;
							if(res.result == true){
								alert(res.msg);
								$('#CmtBoardPwCk').dialog('close');
								if(pagemode == 'ajax'){
									boardviewtype_m_only(viewlink,seq,"ajax","down",res.comment_cnt);
								}else{
									document.location.href=viewlink;
								}
							}else{
								alert(res.msg);
								if(pagemode == 'ajax'){
									boardviewtype_m_only(viewlink,seq,"ajax","down",res.comment_cnt);
								}else{
									document.location.href=viewlink;
								}
							}
							$('#CmtBoardPwCk').dialog('close');
						}else{
							//잘못된 접근입니다.
							openDialogAlert(getAlert('et240'),'400','140',function(){});
						}
					}
				});
			}//endif
		}
	});

	$(".agree_check").on("change", function() {
		var chk = $(this).is(':checked');
		var agree_input = $(this).closest('td').find('[name="agree"]');
		if(chk) {
			agree_input.val('y');
		} else {
			agree_input.val('n');
		}
	});
});

function getboardLogin(){
	if(gl_isuser){
		//해당 서비스를 이용하시려면 관리자에게 문의하여 주시길 바랍니다.
		openDialogAlert(getAlert('et260'),'450','140');
	}else{
		//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
		openDialogConfirm(getAlert('et261'),'400','155',function(){
			if ( pagemode == 'ajax' ) {
				top.location.href="/member/login?return_url="+return_url;
			} else {
				location.href="/member/login?return_url="+return_url;
			}
		},function(){});
	}
}

function getcmtMbLogin(){
	if(gl_isuser){
		//글작성자만 이용가능합니다.
		openDialogAlert(getAlert('et262'),'400','140');
	}else{
		//이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?
		openDialogConfirm(getAlert('et261'),'400','155',function(){
			if ( pagemode == 'ajax' ) {
				top.location.href="/member/login?return_url="+return_url;
			} else {
				location.href="/member/login?return_url="+return_url;
			}
		},function(){});
	}
}

//비밀댓글 수정폼보여주기
function getModifyCmt(cmtseq ){
	$('#CmtBoardPwCkNew').dialog('close');
	//var cmtseq = $(this).attr("board_cmt_seq");
	var board_id = $('#board_id').val();
	var seq = $('#board_seq').val();
	var returnurl = $('#cmtreturnurl').val();
	if( $("#mod_contents_"+cmtseq).css('display') == 'none' ){
		$.ajax({
			'url' : '../board_comment_process',
			'data' : {'mode':'board_comment_item', 'cmtseq':cmtseq, 'seq':seq, 'board_id':board_id},
			'type' : 'post',
			'dataType': 'json',
			'success': function(data) {
				//alert(data.isperm_display);
				if(data.isperm_display != 1){//삭제되지않은 글
					$("#mod_contents_"+cmtseq).attr('isperm_moddel',false);
					$("#mod_contents_"+cmtseq).toggle('slow');//slideDown(500);
					if(gl_isuser){
						$("#mod_contents_"+cmtseq).find('.cmtmode').val('board_comment_modify');//$('#cmtmode')
						if( data.mseq > 0 ) {
							$("#mod_contents_"+cmtseq).find('.pwchecklay').hide();
						}else{
							if( data.isperm_moddel ) {//비회원 권한있으면
								$("#mod_contents_"+cmtseq).find('.pwchecklay').hide();
							}else{
								$("#mod_contents_"+cmtseq).find('.pwchecklay').show();
							}
						}
					}else{
						$("#mod_contents_"+cmtseq).find('.cmtmode').val('board_comment_modify_pwcheck');//$('#cmtmode')
						if( data.mseq > 0 ) {
							getcmtMbLogin();
						}else{
							if( data.isperm_moddel ) {//비회원 권한있으면
								$("#mod_contents_"+cmtseq).find('.pwchecklay').hide();
							}else{
								$("#mod_contents_"+cmtseq).find('.pwchecklay').show();
							}
						}
					}

					$("#mod_contents_"+cmtseq).attr('isperm_moddel',data.isperm_moddel);
					$("#mod_contents_"+cmtseq).find('.cmtname').val(data.name);//$('#cmtname')
					$("#mod_contents_"+cmtseq).find('.cmtsubject').val(data.subject);//$('#cmtsubject')
					$("#mod_contents_"+cmtseq).find('.cmtcontent').val(data.content); //$('#cmtcontent')
					$("#mod_contents_"+cmtseq).find('.cmtseq').val(data.seq);//$('#cmtseq')
					if(data.hidden == 1 ) {
						$("#mod_contents_"+cmtseq).find('.cmthidden').attr("checked",true);//$('#cmthidden')
					}else{
						$("#mod_contents_"+cmtseq).find('.cmthidden').attr("checked",false);//$('#cmthidden')
					}
					$("#mod_contents_"+cmtseq).find('.cmthidden').ezMark({
					  selectedCls: 'ez-radio-on'
					 });
					///$("#mod_contents_"+cmtseq).find('.cmtname')$('#board_commentsend').text('댓글수정');
					document.location.href="#cwriteform";
					$('.cmtreplylay').hide();
					setDefaultText();
				}
			}
		});
	}else{
		$("#mod_contents_"+cmtseq).toggle('slow');
	}
}

//비밀답글 수정폼보여주기
function getModifyReplyCmt(cmtseq, cmtreplyseq, idx ){
	var board_id = $('#board_id').val();
	var seq = $('#board_seq').val();
	var returnurl = $('#cmtreturnurl').val();
	$(".cmtreplyform"+cmtreplyseq).find('.captcha_code').val('');
	$('#CmtBoardPwCkNew').dialog('close');
	if( $(".cmtreplyform"+cmtreplyseq).css('display') == 'none' ){
		$.ajax({
			'url' : '../board_comment_process',
			'data' : {'mode':'board_comment_reply_item', 'cmtseq':cmtseq, 'cmtreplyseq':cmtreplyseq, 'seq':seq, 'board_id':board_id},
			'type' : 'post',
			'dataType': 'json',
			'success': function(data) {
				//alert(data.isperm_display);
				if(data.isperm_display != 1){//삭제되지않은 글
					$('#board_commentsend_reply'+cmtreplyseq).attr('isperm_moddel',false);
					$(".cmtreplyform"+cmtreplyseq).toggle('slow');//show();
					if(gl_isuser){
						if( data.mseq > 0 ) {
							$(".cmtreplyform"+cmtreplyseq).find('.pwchecklay').hide();
						}else{
							if( data.isperm_moddel ) {//비회원 권한있으면
								$(".cmtreplyform"+cmtreplyseq).find('.pwchecklay').hide();
							}else{
								$(".cmtreplyform"+cmtreplyseq).find('.pwchecklay').show();
							}
						}
					}else{
						if( data.mseq > 0 ) {
							getcmtMbLogin();
						}else{
							if( data.isperm_moddel ) {//비회원 권한있으면
								$(".cmtreplyform"+cmtreplyseq).find('.pwchecklay').hide();
							}else{
								$(".cmtreplyform"+cmtreplyseq).find('.pwchecklay').show();
							}
						}
					}

					$('#board_commentsend_reply'+cmtreplyseq).attr('isperm_moddel',data.isperm_moddel);
					$('#cmtname'+cmtreplyseq).val(data.name);
					$('#cmtsubject'+cmtreplyseq).val(data.subject);
					$('#cmtcontent'+cmtreplyseq).val(data.content);
					if(data.hidden == 1 ) {
						$('#cmthidden'+cmtreplyseq).attr("checked",true);
					}else{
						$('#cmthidden'+cmtreplyseq).attr("checked",false);
					}
					$('#cmthidden'+cmtreplyseq).ezMark({
					  selectedCls: 'ez-radio-on'
					 });
					 //답글수정
					$('#board_commentsend_reply'+cmtreplyseq).text(getAlert('et264'));
					$('#board_commentsend_reply'+cmtreplyseq).attr('board_cmt_reply_seq',cmtreplyseq);
					setDefaultText();
				}
			}
		});
	}else{
		$(".cmtreplyform"+cmtreplyseq).toggle('slow');
	}
}
