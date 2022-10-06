<?php /* Template_ 2.2.6 2022/05/17 12:36:32 /www/music_brother_firstmall_kr/admin/skin/default/mobile_app/push_history.html 000021055 */ 
$TPL_pushlist_1=empty($TPL_VAR["pushlist"])||!is_array($TPL_VAR["pushlist"])?0:count($TPL_VAR["pushlist"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>
<style type="text/css">
.push_list { width:99%; }
</style>
<script type="text/javascript">
var today = new Date();
var currentdate = today.getDate();
$(document).ready(function() {

	gSearchForm.init({'pageid':'app_push_history','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>'});

	$("#chkAll").click(function(){
		if($(this).attr("checked")){
			$(".chk").attr("checked",true).change();
		}else{
			$(".chk").attr("checked",false).change();
		}
	});

	$('#previewBtn').click(function(){
		var url = $("#send_link").val();
		var n1  = url.indexOf("http://");
        var n2  = url.indexOf("https://");
		if( n1 < 0 && n2 < 0) {
			openDialogAlert('http를 포함 전체 url를 입력 하여 주세요.', 400, 150);
			return;
		}
		window.open(url, "_blank");
	});
});

// 리스트 행 클릭시 푸시 내용 출력 :: 2020-01-10 lwh
// - DB 재접속을 하지 않기 위해 기존 row 데이터에서 스크립트 처리
function popup_push_view(evt){

	var rowObj		= $(evt).closest('.list-row');

	var image		= $(rowObj).attr('push_img');
	var link_url	= $(rowObj).attr('link_url');
	var complete_yn	= $(rowObj).attr('complete_yn');
	var send_type	= $(rowObj).attr('send_type');
	var title		= $(rowObj).attr('push_title');
	var body		= $(rowObj).attr('push_body');
	var seq			= $(rowObj).find('.seq').text();
	var is_auto		= $(rowObj).find('.is_auto').text();
	var sendtype_str= $(rowObj).find('.send_type').text();
	var req_date	= $(rowObj).find('.req_date').text();
	var send_date	= $(rowObj).find('.send_date').text();
	var send_status	= $(rowObj).find('.member_seq_count').text();
	var complete_str= $(rowObj).find('.complete_str').text();

	var reserv_day	= $(rowObj).find('.reserv_date').find('.reserv_day').text();
	var reserv_hour	= $(rowObj).find('.reserv_date').find('.reserv_hour').text();
	var reserv_min	= $(rowObj).find('.reserv_date').find('.reserv_minute').text();

	// popup preview 변수 할당
	$('#popup_push_view').find('.controll-row').hide();

	$('#popup_push_view').find('#push_seq').val(seq);				// 발송seq
	$('#popup_push_view').find('.is_auto').html(is_auto);			// 발송구분
	$('#popup_push_view').find('.send_type').html(sendtype_str);	// 발송조건
	$('#popup_push_view').find('.req_date').html(req_date);			// 발송요청일
	$('#popup_push_view').find('.send_date').html(send_date);		// 발송완료일
	$('#popup_push_view').find('.send_status').html(send_status);	// 발송상태
	$('#popup_push_view').find('#send_title').val(title);			// 발송제목
	$('#popup_push_view').find('#send_body').val(body);			// 발송내용
	$('#popup_push_view').find('#send_link').val(link_url);			// 연결URL
	if(send_type == 'r'){											// 발송예약일
		$('#popup_push_view').find('.reserve').show();
		$('#popup_push_view').find('.reserv_date').find('#reserve_date').val(reserv_day);
		$('#popup_push_view').find('.reserv_date').find('#reserve_hour').val(reserv_hour);
		$('#popup_push_view').find('.reserv_date').find('#reserve_min').val(reserv_min);
	}else{
		$('#popup_push_view').find('.reserve').hide();
	}
	/*
	if(image){														// 등록이미지
		$('#popup_push_view').find('.push_img').show();
		$('#popup_push_view').find('#imgpreviewBtn').attr('onclick','window.open("'+image+'")');
	}*/
	


	if(image){
			$(".modify_push .preview_image").show()
			$(".noimg_message").hide()
			imgUploadEvent("#send_image", "", "", image);
		}else{
			$(".modify_push .preview_image").hide()
			$(".noimg_message").show()
		}

	// 발송완료 or 발송대기 처리
	if(complete_yn == 'Y' || complete_yn == 'C'){
		$(".modify_push .file_select").hide()
		$('#popup_push_view').find('.controll_input').css('background-color', '#f0f0f0');
		$('#popup_push_view').find('.ui-datepicker-trigger').hide();
		$('#popup_push_view').find('.controll_input').attr('disabled','disabled');
		// 발송상태 재정의
		$('#popup_push_view').find('.send_status').html(complete_str);
		// 수정 버튼 정의
		$('#popup_push_view').find('.modify_btn').hide();
		// 확인 버튼 정의
		$('#popup_push_view').find('.cancle_btn').find('button[name="cancel"]').html('닫기');
		
	}else if	(complete_yn == 'N'){
		$(".modify_push .file_select").show()			
		$('#send_image').createAjaxFileUpload(uploadConfig, appPushUploadCallback);
		$(".noimg_message").hide()

		$('#popup_push_view').find('.controll_input').css('background-color', '#fff');
		$('#popup_push_view').find('.ui-datepicker-trigger').show();
		$('#popup_push_view').find('.controll_input').removeAttr('disabled','disabled');
		// 발송상태 재정의
		if(reserve_date_check('check') === true){
			var cancel_btn = '<button type="button" onclick="push_controll(\'cancel\');" class="resp_btn v2">발송 취소</button> <span class="red desc">예약 발송 시간 5분 전까지 취소 가능합니다.</span>';
		}else{
			var cancel_btn = '<button type="button" onclick="alert(\'예약 발송 시간 5분 전까지 취소 가능합니다.\')" class="resp_btn v2">발송 취소</button>';
		}
		$('#popup_push_view').find('.send_status').html(cancel_btn);
		// 수정 버튼 정의
		$('#popup_push_view').find('.modify_btn').show();
		// 확인 버튼 정의
		$('#popup_push_view').find('.cancle_btn').removeClass('gray');
		$('#popup_push_view').find('.cancle_btn').find('button[name="cancel"]').html('취소');
	}

		

	

	var title = '푸쉬 발송 내역 상세';
	openDialog(title, "popup_push_view", {"width":"700","height":"700"});
}

// 푸시 발송 컨트롤
function push_controll(type){
	// 일괄 취소
	if(type == 'batch_cancel'){
		var chk_list	= '';
		var result		= true;

		console.log($('#pushList').find('.chk:checked').length);
		if($('#pushList').find('.chk:checked').length <= 0){
			result		= '선택된 푸시가 없습니다.';
		}
		$('#pushList').find('.chk:checked').each(function(){
			var chk_seq = $(this).val();
			// 완료 여부 체크
			var complete_yn = $(this).closest('.list-row').attr('complete_yn');
			if(complete_yn != 'N'){
				result = '발송 취소가 불가한 푸쉬 알림이 선택되었습니다.<br/>푸쉬 알림은 발송 5분 전까지 취소가 가능합니다.';
				return false;
			}
			// 예약시간 체크
			var reserve_date	= $(this).closest('.list-row').find('.reserv_day').text();
			var reserve_hour	= $(this).closest('.list-row').find('.reserv_hour').text();
			var reserve_min		= $(this).closest('.list-row').find('.reserv_minute').text();
			reserve_min = parseInt(reserve_min) - 5; // 발송 5분전 체크
			var date 	= new Date();
			var c_date 	= new Date(reserve_date+' '+reserve_hour+':'+reserve_min);
			if	(date.getTime() >= c_date.getTime()) {
				result = '발송 취소가 불가한 푸쉬 알림[' + chk_seq + ']이 선택되었습니다.<br/>푸쉬 알림은 발송 5분 전까지 취소가 가능합니다.';
				return false;
			}

			chk_list += $(this).val() + '|';
		});
		
		$('#modifyFrm').find('#push_seq').val(chk_list);
	}else{
		// 예약일 체크
		var result = reserve_date_check('send');
	}

	if(result === true){
		// 발송 프로세스
		var push_seq	= $('#modifyFrm').find('#push_seq').val();
		var chk_msg		= '푸쉬 발송 예약을 취소하시겠습니까?';
		if			(type == 'modify')		{	chk_msg = '푸쉬 발송 내역을 수정하시겠습니까?';	}
		else if		(type == 'cancel')		{	chk_msg = '푸쉬 발송 예약을 취소하시겠습니까?';	}
		else if		(type == 'batch_cancel'){	chk_msg = '푸쉬 발송 예약을 일괄취소하시겠습니까?';	}
		else		{ alert('type err'); return false; }
		
		if(push_seq){
			openDialogConfirm(chk_msg,'400','155',function(){
				$('#modifyFrm').find('#push_type').val(type);
				$('#modifyFrm').submit();
			},function(){});
		}else{ alert('push err'); return false; }
	}else{
		openDialogAlert(result, 400, 170);
	}
}

// 예약시간 체크
function reserve_date_check(chk_type){
	var	reserve_date	= $('#modifyFrm').find("input[name='reserve_date']").val();
	var	reserve_hour	= $('#modifyFrm').find("select[name='reserve_hour'] > option:selected").val();
	var	reserve_min		= $('#modifyFrm').find("select[name='reserve_min'] > option:selected").val();
	if(chk_type == 'check'){ reserve_min = parseInt(reserve_min) - 5; } // 발송 5분전 체크
	var date_pattern	= /^(19|20)\d{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[0-1])$/; 
	if(!date_pattern.test(reserve_date)){
		return "예약 일자를 선택해 주세요.";
	}else{
		var date 	= new Date();
		var c_date 	= new Date(reserve_date+' '+reserve_hour+':'+reserve_min);
		$("input[name='reserve_datetime']").val(reserve_date+' '+reserve_hour+':'+reserve_min);
		if	(date.getTime() >= c_date.getTime()) {
			return '예약발송은 현재시간 이후로 선택하여 주세요.';
		}
	}

	return true;
}
</script>

<!-- 푸시 내용 출력 css -->
<style>
	.push_list li{float:left; }
	.push_list > li:first-child{width:80%;}
	.push_list > li:last-child{width:20%;}
	.push_sample > div{display:table; width:calc(100% - 20px); -webkit-calc:calc(100% - 20px); -moz-calc:calc(100% - 20px); margin:0 10px; background:#eeeeee; height:100%;}
	.push_sample > div > ul{padding:10px;  }
	.push_sample > div > ul > li{ width:100%;  padding:10px 0;}
	.push_sample .title {font-size:14px;}
	.push_sample .mess_title{font-size:13px;}
	.modify_push .preview_image .preview-del {display:none;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>푸시 발송 관리</h2>
		</div>

	</div>
</div>

<div class="contents_container">
	
<?php $this->print_("top_menu",$TPL_SCP,1);?>


	<div id="search_container" class="search_container">
	<form name="listForm" id="listForm">
	<input type="hidden" name="searchcount" value="<?php echo $TPL_VAR["sc"]["searchcount"]?>"/>
	<input type="hidden" name="perpage"  id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" />


		<table class="table_search">			
			<tr>
				<th>발송 요청일</th>
				<td>
					<div class="date_range_form">
						<input type="text" name="start_date" value="<?php echo $TPL_VAR["sc"]["start_date"]?>" class="datepicker sdate"  maxlength="10" size="10" />
						-
						<input type="text" name="end_date" value="<?php echo $TPL_VAR["sc"]["end_date"]?>" class="datepicker edate" maxlength="10" size="10" />
							
						<div class="resp_btn_wrap">
							<input type="button" range="today" value="오늘" class="select_date resp_btn" />
							<input type="button" range="3day" value="3일간" class="select_date resp_btn" />
							<input type="button" range="1week" value="일주일" class="select_date resp_btn" />
							<input type="button" range="1month" value="1개월" class="select_date resp_btn" />
							<input type="button" range="3month" value="3개월" class="select_date resp_btn" />
							<input type="button" range="all"  value="전체" class="select_date resp_btn"/>
							<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden" />
						</div>
					</div>
				</td>
			</tr>			
			<tr>
				<th>발송 조건</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="send_type" value="" <?php if(!$TPL_VAR["sc"]["send_type"]||$TPL_VAR["sc"]["send_type"]==''){?>checked<?php }?> /> 전체</label>					
						<label><input type="radio" name="send_type" value="i" <?php if($TPL_VAR["sc"]["send_type"]=='i'){?>checked<?php }?> /> 즉시 발송</label>				
						<label><input type="radio" name="send_type" value="r" <?php if($TPL_VAR["sc"]["send_type"]=='r'){?>checked<?php }?> /> 예약 발송</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>제목</th>
				<td>
					<input type="text" id="search_title" name="search_title" size="70" value="<?php echo $TPL_VAR["sc"]["search_title"]?>" />
				</td>
			</tr>
			</tbody>
		</table>

		<div class="search_btn_lay center mt10"></div>
	</div>

	<!-- 서비스 현황 테이블 : 시작 -->
	<div class="list_info_container">		
		<div class="dvs_right">	
		</div>
	</div>

	<div class="table_row_frame">	
		<div class="dvs_top">	
			<div class="dvs_left">
				<button type="button" value="발송 취소" name="modify" onclick="push_controll('batch_cancel')" class="resp_btn v3">발송 취소</button>
			</div>			
		</div>
		
		<table class="table_row_basic tdc" id="pushList">
			<!-- 테이블 헤더 : 시작 -->
			<colgroup>
				<col width="10" /><!--체크-->
				<col width="15" /><!--번호-->
				<col width="20" /><!--발송구분-->
				<col width="20" /><!--발송조건-->
				<col width="25" /><!--발송요청일-->
				<col width="25"/><!--발송예약일-->
				<col width="25"/><!--발송완료일-->
				<col width="210"/><!--발송제목-->
				<col width="20"/><!--수신대상자-->
				<col width="20"/><!--발송상태-->
			</colgroup>

			<thead>
				<tr>
					<th><label class="resp_checkbox"><input type="checkbox" id="chkAll"/></div></th>
					<th>번호</th>
					<th>발송구분</th>
					<th>발송조건</th>
					<th>발송 요청일</th>
					<th>발송 예약일</th>
					<th>발송 완료일</th>
					<th>발송제목</th>
					<th>수신대상자</th>
					<th>발송상태</th>
				</tr>
			</thead>
			<!-- 테이블 헤더 : 끝 -->

			<!-- 리스트 : 시작 -->
			<tbody>
<?php if($TPL_VAR["pushlist"]){?>
<?php if($TPL_pushlist_1){$TPL_I1=-1;foreach($TPL_VAR["pushlist"] as $TPL_V1){$TPL_I1++;?>
				<tr class="list-row" size="<?php echo $TPL_pushlist_1?>" idx="<?php echo $TPL_I1?>" push_img="<?php echo $TPL_V1["image"]?>" push_title='<?php echo $TPL_V1["title"]?>' push_body='<?php echo $TPL_V1["body"]?>' send_type='<?php echo $TPL_V1["send_type"]?>' link_url='<?php echo $TPL_V1["link"]?>' complete_yn='<?php echo $TPL_V1["complete_yn"]?>' >
					<td><label class="resp_checkbox"><input type="checkbox" class="chk" name="chk_seq[]" value="<?php echo $TPL_V1["seq"]?>" /></label></td>
					<td class="seq"><?php echo $TPL_V1["seq"]?></td>
					<td class="is_auto"><?php if($TPL_V1["is_auto"]=='y'){?>자동발송<?php }elseif($TPL_V1["is_auto"]=='n'){?>수동발송<?php }?></td>
					<td class="send_type"><?php if($TPL_V1["send_type"]=='i'){?>즉시발송 <?php }elseif($TPL_V1["send_type"]=='r'){?>예약발송<?php }?></td>
					<td class="req_date"><?php echo $TPL_V1["req_date"]?></td>
					<td class="reserv_date">
<?php if($TPL_V1["send_type"]=='i'){?>
						-
<?php }elseif($TPL_V1["send_type"]=='r'&&$TPL_V1["reserv_date"]!='0000-00-00 00:00:00'){?>
						<span class="reserv_day"><?php echo $TPL_V1["reserv_day"]?></span> <span class="reserv_hour"><?php echo $TPL_V1["reserv_hour"]?></span>:<span class="reserv_minute"><?php echo $TPL_V1["reserv_minute"]?></span>
<?php }?>
					</td>
					<td class="send_date"><?php if($TPL_V1["complete_yn"]=='C'){?>발송 취소 완료<?php }elseif($TPL_V1["send_date"]==''||$TPL_V1["send_date"]==null){?>발송 대기 중<?php }else{?><?php echo $TPL_V1["send_date"]?><?php }?></td>
					<td class="left"><span class="resp_btn_txt v2" onclick="popup_push_view(this);"><?php echo $TPL_V1["title"]?></span></td>
					<td class="member_seq_count"><?php if($TPL_V1["member_seq_count"]=='-1'){?>전체<?php }elseif($TPL_V1["member_seq_count"]!='-1'){?><?php echo $TPL_V1["member_seq_count"]?><?php }?></td>
					<td class="complete_str"><?php if($TPL_V1["complete_yn"]=='N'){?>발송 대기<?php }elseif($TPL_V1["complete_yn"]=='C'){?>발송 취소<?php }elseif($TPL_V1["send_total"]!='0'){?><?php echo $TPL_V1["succ_android"]+$TPL_V1["succ_ios"]?>/<?php echo $TPL_V1["send_total"]?><?php }elseif($TPL_V1["complete_yn"]=='Y'){?>발송 실패<?php }?></td>
				</tr>
<?php }}?>
<?php }else{?>
		<tr>
			<td colspan="10">푸시 발송 내역이 없습니다.</td>
		</tr>
<?php }?>
			</tbody>
			<!-- 리스트 : 끝 -->
		</table>

		<div class="dvs_bottom">	
			<div class="dvs_left">	
				<button type="button" value="발송 취소" name="modify" onclick="push_controll('batch_cancel')" class="resp_btn v3">발송 취소</button>
			</div>			
		</div>
	</div>

	<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
	</form>
</div>

<!-- 푸시발송 상세 popup -->
<div class="hide" id="popup_push_view">
	<div class="content">
	<form name="modifyFrm" id="modifyFrm" method="post" enctype="multipart/form-data" target="processFrame" action="../mobile_app_process/controll_push">
	<input type="hidden" name="push_seq" id="push_seq" value="" />
	<input type="hidden" name="push_type" id="push_type" value="" />
	
	<table class="table_basic thl">		
		<tbody>
			<tr>
				<th>발송 구분</th>
				<td class="is_auto"></td>
			</tr>
			<tr>
				<th>발송 조건</th>
				<td class="send_type"></td>
			</tr>
			<tr>
				<th>발송 요청일</th>
				<td class="req_date"></td>
			</tr>
			<tr class="controll-row reserve">
				<th>발송 예약일</th>
				<td class="reserv_date">
					<input type="text" name="reserve_date" id="reserve_date" value="예약 일자 선택" class="datepicker line controll_input" maxlength="10" style="width:90px;" />
					<select name="reserve_hour" id="reserve_hour" class="controll_input">
<?php if(is_array($TPL_R1=range( 1, 24))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<option value="<?php echo str_pad($TPL_V1, 2, 0,$TPL_VAR["STR_PAD_LEFT"])?>" <?php if($TPL_V1=="8"){?>selected<?php }?>><?php echo str_pad($TPL_V1, 2, 0,$TPL_VAR["STR_PAD_LEFT"])?>시</option>
<?php }}?>
					</select>
					<select name="reserve_min" id="reserve_min" class="controll_input">
<?php if(is_array($TPL_R1=range( 0, 59))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<option value="<?php echo str_pad($TPL_V1, 2, 0,$TPL_VAR["STR_PAD_LEFT"])?>" <?php if($TPL_V1=="0"){?>selected<?php }?>><?php echo str_pad($TPL_V1, 2, 0,$TPL_VAR["STR_PAD_LEFT"])?>분</option>
<?php }}?>
					</select>
				</td>
			</tr>
			<tr>
				<th>발송 완료일</th>
				<td class="send_date"></td>
			</tr>
			<tr>
				<th>발송 상태</th>
				<td class="send_status"></td>
			</tr>
			<tr>
				<th>발송 제목</th>
				<td class="push_title">
					<input type="text" id="send_title" name="send_title" class="controll_input" value="" style="width:99%;" />
				</td>
			</tr>
			<tr>
				<th>발송내용</th>
				<td>
					<textarea name="send_body" id="send_body" class="controll_input" style="width:99%; height:100px;" ></textarea>
				</td>
			</tr>
			<tr>
				<th>발송이미지</th>
				<td>
					<div class="webftpFormItem modify_push">									
						<label class="resp_btn v2 file_select"><input type="file" id="send_image" accept="image/jpeg, image/png">파일 선택</label>
						<input type="hidden" class="webftpFormItemInput" name="send_image" />									
						<div class="preview_image"></div>
					</div>	

					<div class="noimg_message hide">이미지가 없습니다.</div>
					<!--
					<input type="file" id="send_image" name="send_image" class="line controll_input" accept="image/jpeg, image/png">
					<span class="btn small controll-row push_img"><button type="button" id="imgpreviewBtn">등록이미지</button></span>-->
				</td>
			</tr>
			<tr>
				<th>연결 URL</th>
				<td>
					<input type="text" id="send_link" name="send_link" class="line controll_input" value="" style="width:70%;" />
					<button type="button" id="previewBtn" class="resp_btn">미리보기</button>
				</td>
			</tr>
		</tbody>
	</table>	
	</form>
	</div>

	<div class="footer">
		<span class="modify_btn"><button type="button" value="수정" name="modify" onclick="push_controll('modify')" class="resp_btn active size_XL">수정</button></span>
		<span class="cancle_btn"><button type="button" value="취소" name="cancel" onclick="closeDialog('popup_push_view')" class="resp_btn v3 size_XL">취소</button></span>
	</div>
</div>

<iframe src="" name="processFrame" frameborder="0" width="100%" height="1000px" scrolling="no" class="hide"></iframe>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>