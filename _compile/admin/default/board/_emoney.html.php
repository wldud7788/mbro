<?php /* Template_ 2.2.6 2022/05/17 12:30:57 /www/music_brother_firstmall_kr/admin/skin/default/board/_emoney.html 000012683 */ ?>
<script type="text/javascript">
$(document).ready(function() {

	/* 선택회원 캐시 출력 */
	$("button.board_emoneyt_btn").live("click",function(){
		$('#BoardEmoneytPopup')[0].reset();
		var mbname = $(this).attr('mbname');
		var mbtel = $(this).attr('mbtel');
		var board_seq = $(this).attr('board_seq');
		var mid = $(this).attr('mid');
		var mseq = $(this).attr('mseq');

		$('#emoney_board_seq').val(board_seq);
		$('#board_emoney_mid').val(mid);
		$('#board_emoney_mseq').val(mseq);
		$('#board_emoney_mbtel').val(mbtel);

		var managername = $(this).attr('managername');
		var board_id = $(this).attr('managerid');
		$('#board_board_id').val(board_id);
		$('#board_mbname').html(mbname + " (" + mbtel + ")");
		openDialog("캐시 지급", "BoardEmoneytlayList", {"width":550,"height":470,"show" : "fade","hide" : "fade"});
	});

	$('#BoardEmoneytPopup').validate({
		onkeyup: false,
		rules: {
			board_memo: { required:true},
			board_emoney: { required:true, number: true},
		},
		messages: {
			board_memo: { required:'입력해 주세요.'},
			board_emoney: { required:'입력해 주세요.', number:'숫자로 입력해 주세요.'}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent());
		},
		submitHandler: function(f) {
			if( parseInt($("#board_emoney").val())<1){//
				alert("캐시를 정확히 입력해 주세요.");
				return false;
			}
			if( $('#board_sms').is(":checked") ) {
				if( !$(".board_sms_contents").val() ) {
					$(".board_sms_contents").focus();
					return false;
				}
			}
			f.submit();
		}
	});

	$("button#goods_board_cancel").click(function(){
		$('#BoardEmoneytlayList').dialog('close');
	});

	$(".board_sms_contents").live("keydown",function(){
		str = $(this).val();
		$(this).parent().parent().parent().find(".sms_byte").html(BoardchkByte(str));
	});
	$(".board_sms_contents").live("keyup",function(){
		str = $(this).val();
		$(this).parent().parent().parent().find(".sms_byte").html(BoardchkByte(str));
	});


	/* 선택된 아이콘 출력 */
	$("button.review_emoneyt_btn").live("click",function(){
		$('#ReviewEmoneytPopup')[0].reset();
		var mbname = $(this).attr('mbname');
		var mbtel = $(this).attr('mbtel');
		var board_seq = $(this).attr('board_seq');
		var mid = $(this).attr('mid');
		var mseq = $(this).attr('mseq');

		$('#emoney_review_board_seq').val(board_seq);
		$('#emoney_review_mid').val(mid);
		$('#emoney_review_mseq').val(mseq);
		$('#emoney_review_mbtel').val(mbtel);

		var board_id = $(this).attr('managerid');
		$('#review_board_id').val(board_id);
		var managername = $(this).attr('managername');

		$('#review_mbname').html(mbname + " (" + mbtel + ")");
		openDialog("캐시 지급", "ReviewEmoneytlayList", {"width":550,"height":470,"show" : "fade","hide" : "fade"});
	});

	//
	$(".goods_review_sms").live("keydown",function(){
		str = $(this).val();
		$(this).parent().parent().parent().find(".sms_byte").html(BoardchkByte(str));
	});
	$(".goods_review_sms").live("keyup",function(){
		str = $(this).val();
		$(this).parent().parent().parent().find(".sms_byte").html(BoardchkByte(str));
	});

	$('#ReviewEmoneytPopup').validate({
		onkeyup: false,
		rules: {
			goods_review_memo: { required:true},
			goods_review_emoney: { required:true, number: true},
		},
		messages: {
			goods_review_memo: { required:'입력해 주세요.'},
			goods_review_emoney: { required:'입력해 주세요.', number:'숫자로 입력해 주세요.'}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent());
		},
		submitHandler: function(f) {
			if( parseInt($("#goods_review_emoney").val())<1){// 
				alert("캐시를 정확히 입력해 주세요.");
				return false;
			}
			if( $('#board_review_sms').is(":checked") ) {
				if( !$(".goods_review_sms").val() ) {
					$(".goods_review_sms").focus();
					return false;
				}
			}
			f.submit();
		}
	});


	$("button#goods_review_cancel").click(function(){
		$('#ReviewEmoneytlayList').dialog('close');
	});

	$("select[name='goods_review_reserve_select']").live("change",function(){
		span_controller('goods_review_reserve');
	});

	$("select[name='board_reserve_select']").live("change",function(){
		span_controller('board_reserve');
	});

});

function boardemoneyclose(){
	document.location.reload();
}

function emoneyclose(){
	document.location.reload();
}

function span_controller(name){
	var reserve_y = $("span[name='"+name+"_y']");
	var reserve_d = $("span[name='"+name+"_d']");
	var value = $("select[name='"+name+"_select'] option:selected").val();
	if(value==""){
		reserve_y.hide();
		reserve_d.hide();
	}else if(value=="year"){
		reserve_y.show();
		reserve_d.hide();
	}else if(value=="direct"){
		reserve_y.hide();
		reserve_d.show();
	}
}

function span_controller_view(name){
	var reserve_y = $("#writeform span[name='"+name+"_y']");
	var reserve_d = $("#writeform span[name='"+name+"_d']");
	var value = $("#writeform select[name='"+name+"_select'] option:selected").val();
	if(value==""){
		reserve_y.hide();
		reserve_d.hide();
	}else if(value=="year"){
		reserve_y.show();
		reserve_d.hide();
	}else if(value=="direct"){
		reserve_y.hide();
		reserve_d.show();
	}
}


</script>

<div id="ReviewEmoneytlayList" style="display:none">
<form name="ReviewEmoneyPopup" id="ReviewEmoneytPopup" method="post" action="/admin/board_goods_process" target="actionFrame">
	<input type="hidden" name="mode" id="" value="goods_review_emoney_save">
	<input type="hidden" name="type" value="List">
	<input type="hidden" name="seq" id="emoney_review_board_seq" value="">
	<input type="hidden" name="board_id" id="review_board_id" value="<?php echo $_GET["id"]?>">
	<input type="hidden" name="mid" id="emoney_review_mid" value="<?php echo $TPL_VAR["mid"]?>">
	<input type="hidden" name="mseq" id="emoney_review_mseq" value="<?php echo $TPL_VAR["mseq"]?>">
	<input type="hidden" name="mbtel" id="emoney_review_mbtel" value="">
	<div class="content">
		<table class="table_basic thl">
			<tbody>
			<tr>
				<th>지급대상</th>
				<td id="review_mbname"></td>
			</tr>
			<tr>
				<th>지급사유</th>
				<td >
					<input type="text" name="goods_review_memo" id="goods_review_memo" size="40" value="<?php echo $TPL_VAR["goods_review_memo"]?>" title="" class="line">
				</td>
			</tr>
			<tr>
				<th>지급액</th>
				<td >
					<input type="text" name="goods_review_emoney" id="goods_review_emoney" size="3" value="<?php if($TPL_VAR["reserve_goods_review"]){?><?php echo trim($TPL_VAR["reserve_goods_review"])?><?php }else{?><?php echo trim($TPL_VAR["goods_review_emoney"])?><?php }?>" title="" class="line onlynumber">
					<a href="/admin/board/manager_write?id=goods_review"><span class="highlight-link hand">[캐시 설정하기]</span></a>
				</td>
			</tr>

			<tr>
				<th>유효기간</th>
				<td > <select name="goods_review_reserve_select">
						<option value="" selected>제한하지 않음</option>
						<option value="year" <?php if($TPL_VAR["reserve"]["goods_review_reserve_select"]=='year'){?>selected<?php }?>>제한 - 12월31일</option>
						<option value="direct" <?php if($TPL_VAR["reserve"]["goods_review_reserve_select"]=='direct'){?>selected<?php }?>>제한 - 직접입력</option>
					</select>
					<span name="goods_review_reserve_y" class="hide">→ 
					<select name="goods_review_reserve_year" id="goods_review_reserve_year">
<?php if(is_array($TPL_R1=range( 0, 9))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
						<option value="<?php echo $TPL_K1?>"><?php echo intval(date('Y'))+intval($TPL_K1)?>년</option>
<?php }}?>
					</select>
					12월 31일</span>
					<span name="goods_review_reserve_d" class="hide">→ <input type="text" name="goods_review_reserve_direct" class="line onlynumber" style="text-align:right" size="3" value="12">개월</span>
				</td>
			</tr>

			<tr>
				<th>SMS</th>
				<td>
					<label class="resp_checkbox">
						<input type="checkbox" name="board_sms2" value="1" id="board_review_sms"<?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');$('#board_review_sms').prop('checked',false);"<?php }?> onchange="$(this).closest('label').nextAll('div')[['hide','show'][+this.checked]]();">
						<span>SMS 발송</span>
					</label>
					<div class="hide">
						<div>
							<ul>
								<li><textarea name="goods_review_sms" <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }else{?> class="goods_review_sms" <?php }?> ></textarea></li>
								<li><font color="#5a84a1"><span class="sms_byte">0</span>bytes</font></li>
							</ul>
						</div>
						<div>
							(90 bytes 이상 시 LMS로 발송이 되며 3건이 차감됩니다.)
						</div>
					</div>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<div class="footer">
		<button type="submit" id="goods_review_save" class="resp_btn active size_XL">지급</button>
		<button type="button" id="goods_review_cancel" class="resp_btn v3 size_XL">취소</button>
	</div>
</form>
</div>



<div id="BoardEmoneytlayList" style="display:none">
<form name="BoardEmoneyPopup" id="BoardEmoneytPopup" method="post" action="/admin/board_goods_process" target="actionFrame">
	<input type="hidden" name="mode" id="" value="board_emoney_save">
	<input type="hidden" name="type" value="List">
	<input type="hidden" name="seq" id="emoney_board_seq" value="">
	<input type="hidden" name="board_id" id="board_board_id" value="<?php echo $_GET["id"]?>">
	<input type="hidden" name="mid" id="board_emoney_mid" value="<?php echo $TPL_VAR["mid"]?>">
	<input type="hidden" name="mseq" id="board_emoney_mseq" value="<?php echo $TPL_VAR["mseq"]?>">
	<input type="hidden" name="mbtel" id="board_emoney_mbtel" value="">
	<div class="content">
		<table class="table_basic">
			<tbody>
			<tr>
				<th>지급대상</th>
				<td id="board_mbname"></td>
			</tr>
			<tr>
				<th>지급사유</th>
				<td >
					<input type="text" name="board_memo" id="board_memo" size="40" value="<?php echo $TPL_VAR["board_memo"]?>" title="" class="line">
				</td>
			</tr>
			<tr>
				<th>지급액</th>
				<td >
					<input type="text" name="board_emoney" id="board_emoney" size="7" value="<?php if($TPL_VAR["reserve_goods_review"]){?><?php echo trim($TPL_VAR["reserve_goods_Board"])?><?php }else{?><?php echo trim($TPL_VAR["board_emoney"])?><?php }?>" title="" class="line onlyfloat"><?php echo $TPL_VAR["basic_currency"]?>

				</td>
			</tr>

			<tr>
				<th>유효기간</th>
				<td > <select name="board_reserve_select">
						<option value="" selected >제한하지 않음</option>
						<option value="year" <?php if($TPL_VAR["reserve"]["board_reserve_select"]=='year'){?>selected<?php }?>>제한 - 12월31일</option>
						<option value="direct" <?php if($TPL_VAR["reserve"]["board_reserve_select"]=='direct'){?>selected<?php }?>>제한 - 직접입력</option>
					</select>
					<span name="board_reserve_y" class="hide">→ 
					<select name="board_reserve_year" id="board_reserve_year">
<?php if(is_array($TPL_R1=range( 0, 9))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
						<option value="<?php echo $TPL_K1?>"><?php echo intval(date('Y'))+intval($TPL_K1)?>년</option>
<?php }}?>
					</select>
					12월 31일</span>
					<span name="board_reserve_d" class="hide">→ <input type="text" name="board_reserve_direct" class="line onlynumber" style="text-align:right" size="3" value="12">개월</span>
				</td>
			</tr>

			<tr>
				<th>SMS</th>
				<td>
					<label class="resp_checkbox">
						<input type="checkbox" name="board_sms" id="board_sms1" value="1"<?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');$('#board_sms1').prop('checked',false);"<?php }?> onchange="$(this).closest('label').nextAll('div')[['hide','show'][+this.checked]]();">
						<span>SMS 발송</span>
					</label>
					<div class="hide">
						<ul>
							<li><textarea name="goods_board_sms" <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }else{?> class="board_sms_contents" <?php }?> ></textarea></li>
							<li><font color="#5a84a1"><span class="sms_byte">0</span>bytes</font></li>
						</ul>
					</div>
					<div>
						(90 bytes 이상 시 LMS로 발송이 되며 3건이 차감됩니다.)
					</div>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<div class="footer">
		<button type="submit" id="goods_board_save" class="resp_btn active size_XL">지급</button>
		<button type="button" id="goods_board_cancel" class="resp_btn v3 size_XL">취소</button>
	</div>
</form>
</div>