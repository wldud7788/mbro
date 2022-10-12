/*
 * 게시판 mobile_ver2 관련 자바스크립트
 */
$(document).ready(function() {
	$('.boad_search_btn_m').toggle(function() {
		$(this).text(getAlert("sy073")+" ▲"); // 검색
		$(".bbssearchbox").show();
	}, function() {
		$(this).text(getAlert("sy073")+" ▼");  // 검색
		$(".bbssearchbox").hide();
	});


	// mobile2 전용 게시글 보기
	$('.boad_view_btn_m').live('click', function() {
		var viewlink	= $(this).attr('viewlink');
		var board_seq	= $(this).attr('board_seq');
		var viewtype	= $(this).attr('viewtype');
		var pagetype	= $(this).attr('pagetype');
		var secret		= $(this).attr('secret');
		var cont_obj = $(this).parents().next("#board_contents_"+board_seq);
		$('.bus_arrow',this).toggle();

		boardviewtype_m(viewlink,board_seq,viewtype,cont_obj);
	});

	// mobile2 전용 회원글인경우 로그인으로 이동
	$('.boad_view_btn_m_mbno').live('click', function() {
		getMbLogin();
	});

	// mobile2 비회원글 비밀번호입력창
	$('.boad_view_btn_m_no').live('click', function() {
		$('#BoardPwcheckForm')[0].reset();//초기화
		var seq = $(this).attr('board_seq');
		var viewlink = $(this).attr('viewlink');
		$("#pwck_seq").val(seq);
		$("#pwck_returnurl").val(viewlink);
		openDialog("비밀글  <span class='desc'>비밀번호를 입력해 주세요.</span>", "BoardPwCk", {"width":"370","height":"200"});
	});


	// mobile2 전용 접근권한이 없는경우
	$('.boad_view_btn_m_authno').live('click', function() {
		getAuthLogin();
	});

	// 게시글 답변
	$("span.boad_reply_btn,input[name=boad_reply_btn]").live("click", function() {
		var seq = $(this).attr("board_seq");
		document.location.href=boardreplyurl+seq;
	});


	// 게시글 수정
	$(".goods_boad_modify_btn").live("click", function() {
		var seq = $(this).attr("board_seq");
		boardmodifyurl +=seq;
		//popup(boardmodifyurl, '750', '850');
		document.location.href=boardmodifyurl;
	});

	// 게시글 삭제
	$(".goods_boad_delete_btn").live("click", function() {
		//var board_id = $(this).attr('board_id');
		var delseq = $(this).attr('board_seq');
		boarddeletelessmobile(board_id, delseq );
	});


	// 개인정보 수집 이용 추가 2022.01.27 필수 동의여부 체크 
	$(".agree_check").live("change", function() {
		var is_agree_chk = $(this).is(':checked');
		var is_agree = $('input[name="agree"]');
		if (is_agree_chk) {
			is_agree.val('y');
		} else {
			is_agree.val('n');
		}
	}); 

	// * 2014-01-08 lwh * //

	// 댓글 등록
	$("#board_commentsend").live("click",function(){
		var comment_btn_seq = $(this).attr("seq");
		$("form[name=cmtform_"+comment_btn_seq+"]").submit();
	});

	// 댓글 수정
	$("#board_commentsend_mod").live("click",function(){
		var comment_btn_seq = $(this).attr("board_cmt_seq");
		$("form[name=cmtform_mod_"+comment_btn_seq+"]").submit();
	});

});

// 페이징 더보기
function more_comment(id, seq){
	$("#cmtmode").val('board_comment_more');
	$("form[name=cmtform_"+seq+"]").submit();
}

//게시글 삭제시 마일리지 또는 포인트 회수
function boarddeletelessmobile(board_id, delseq ){
	if( board_id == 'goods_review' ) {
		$.ajax({
			'url' : '../board_goods_process',
			'data' : {'mode':'goods_review_less_view', 'delseq':delseq, 'board_id':board_id},
			'type' : 'post',
			'dataType': 'json',
			'success' : function(res){
				if(res.result == "delete") {
					var msg = getAlert("et117");// "삭제된 게시글은 복구할 수 없습니다.\n정말로 삭제하시겠습니까?  ";//res.name+' 삭제',
					openDialogConfirm(msg,'450','140',function(){
						$.ajax({
						'url' : '../board_process',
						'data' : {'mode':'board_delete', 'delseq':delseq, 'board_id':board_id},
						'type' : 'post',
						'success' : function(res){
                                                        // 정상적으로 삭제되었습니다.
							openDialogAlert(getAlert("et224"),'400','140',function(){document.location.reload(); });
						}
					});},function(){});
				}else if(res.result == "lees") {
					openDialogConfirm(res.msg,'480','320',function() {
						$.ajax({
							'url' : '../board_process',
							'data' : {'mode':'board_delete', 'delseq':delseq, 'board_id':board_id},
							'type' : 'post',
							'success' : function(res){
                                                        // 정상적으로 삭제되었습니다.
							openDialogAlert(getAlert("et224"),'400','140',function(){document.location.reload(); });
							}
						});
					},function(){});
				}else if(res.result == "lees_none") {
					openDialogConfirm(res.msg,'400','270','',{hideButton:1});
				}else{
					openDialogAlert(res.msg,'400','140');
				}
			}
		});
	}else{
		$.ajax({
			'url' : '../board_goods_process',
			'data' : {'mode':'board_less_view', 'delseq':delseq, 'board_id':board_id},
			'type' : 'post',
			'dataType': 'json',
			'success' : function(res){
				if(res.result == "delete") {
					var msg = getAlert("et117");// "삭제된 게시글은 복구할 수 없습니다.\n정말로 삭제하시겠습니까?  "
					openDialogConfirm(msg,'450','140',function(){
						$.ajax({
						'url' : '../board_process',
						'data' : {'mode':'board_delete', 'delseq':delseq, 'board_id':board_id},
						'type' : 'post',
						'success' : function(res){
                                                        // 정상적으로 삭제되었습니다.
							openDialogAlert(getAlert("et224"),'400','140',function(){document.location.reload(); });
						}
					});},function(){});
				}else if(res.result == "lees") {
					openDialogConfirm(res.msg,'480','250',function() {
						$.ajax({
							'url' : '../board_process',
							'data' : {'mode':'board_delete', 'delseq':delseq, 'board_id':board_id},
							'type' : 'post',
							'success' : function(res){
                                                        // 정상적으로 삭제되었습니다.
							openDialogAlert(getAlert("et224"),'400','140',function(){document.location.reload(); });
							}
						});
					},function(){});
				}else if(res.result == "lees_none") {
					openDialogAlert(res.msg,'400','270','',{hideButton:1});
				}else{
					openDialogAlert(res.msg,'400','140');
				}
			}
		});
	}
}

// mobile2 전용 게시글보기
function boardviewtype_m(viewlink,board_seq,viewtype,cont_obj) {
	var area_obj = "";
	if(cont_obj.css('display') == 'none' ){
		$.ajax({
			'url' : viewlink,
			'data': {'mode':'ajax'},
			'success' : function(res){
				area_obj = cont_obj;
				area_obj.html(res);
				area_obj.toggle(500);
			}
		});
	}else{
		cont_obj.toggle(500);
	}
}

// mobile2 전용 게시글 무조건보기
function boardviewtype_m_only(viewlink,board_seq,viewtype,cnttype,comment_cnt) {
	var area_obj = "";
	if($(".get-comment-"+board_seq).text() == ''){
		$(".idx-comment-"+board_seq).html(comment_cnt);
	}else{
		if(cnttype =='up'){
			$(".idx-comment-"+board_seq).text(comment_cnt);
		}else if(cnttype =='down'){
			$(".idx-comment-"+board_seq).text(comment_cnt);
		}else{
			$("#mod_contents_"+board_seq).slideUp(500);
		}
	}

	$.ajax({
		'url' : viewlink,
		'data': {'mode':'ajax'},
		'success' : function(res){
			area_obj = $("#board_contents_"+board_seq);
			area_obj.html(res);
		}
	});
}
