<?php /* Template_ 2.2.6 2022/05/17 12:36:33 /www/music_brother_firstmall_kr/admin/skin/default/mobile_app/push_manual.html 000010510 */ 
$TPL_h_arr_1=empty($TPL_VAR["h_arr"])||!is_array($TPL_VAR["h_arr"])?0:count($TPL_VAR["h_arr"]);
$TPL_m_arr_1=empty($TPL_VAR["m_arr"])||!is_array($TPL_VAR["m_arr"])?0:count($TPL_VAR["m_arr"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/batch.js?v=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	$("#send_submit").click(function(){		

		var member			= $("input[name='serialize']").val();
		var reserve_date 	= "";
		var reserve_hour 	= "";
		var reserve_min 	= "";
		if( $("input[name='send_type']:checked").val() == 'r' )
		{

			reserve_date	= $("input[name='reserve_date']").val();
			reserve_hour	= $("select[name='reserve_hour'] > option:selected").val();
			reserve_min		= $("select[name='reserve_min'] > option:selected").val();

			var date_pattern = /^(19|20)\d{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[0-1])$/; 

			if(!date_pattern.test(reserve_date)){
				openDialogAlert("예약 일자를 선택해 주세요.", 400, 150);
				return false;
				ret		= true;
			}else{
				var date 	= new Date();
				var c_date 	= new Date(reserve_date+' '+reserve_hour+':'+reserve_min);
				
				$("input[name='reserve_datetime']").val(reserve_date+' '+reserve_hour+':'+reserve_min);
				if	(date.getTime() >= c_date.getTime()) {
					openDialogAlert('예약발송은 현재시간 이후로 선택하여 주세요.', 400, 150);					
					return;
				}
			}
		}
		
		if( $("input[name='send_title']").val().length < 1 )	{
			openDialogAlert('발송제목을 입력하여 주세요.', 400, 150);			
			return;			
		}

        if( $("input[name='send_title']").val().length > 20 )	{
			openDialogAlert('제목은 20자까지 입력 가능 합니다.', 400, 150);			
			return;			
		}

		
		if( $("textarea[name='send_body']").val().length < 1 )	{
			openDialogAlert('발송내용을 입력하여 주세요.', 400, 150);			
			return;			
		}
		
		console.log($("textarea[name='send_body']").val().length)
        if( $("textarea[name='send_body']").val().length > 1024 )	{
			openDialogAlert('내용은 1024자까지 입력 가능 합니다.', 400, 150);			
			return;			
		}

        var url = $("#send_link").val();        
        if( url.length > 1 )	{            
            var n1  = url.indexOf("http://");
            var n2  = url.indexOf("https://");
            if( n1 < 0 && n2 < 0) {
                openDialogAlert('http를 포함 전체 url를 입력 하여 주세요.', 400, 150);
                return;		
            }
        }

		//openDialog('처리','processDiv', {'width':550,'height':140});
		document.pushForm.submit();
	});
	$("#previewBtn").click(function(){
		var url = $("#send_link").val();
		var n1  = url.indexOf("http://");
        var n2  = url.indexOf("https://");
		if( n1 < 0 && n2 < 0) {
			openDialogAlert('http를 포함 전체 url를 입력 하여 주세요.', 400, 150);
			return;		
		}
		window.open(url, "_blank")
	});

	$("#downloadMemberBtn").click(function(){

		
<?php if($TPL_VAR["auth_member_down"]){?>
		if($("input[name='mcount']").val() == 0){
			openDialogAlert('다운로드 파일이 없습니다.<br />먼저 회원을 검색해 주세요.', 400, 150);
			return;
		}

<?php if(preg_match("/chrome/",strtolower($_SERVER['HTTP_USER_AGENT']))||preg_match("/firefox/",strtolower($_SERVER['HTTP_USER_AGENT']))){?>
		if($("input[name='mcount']").val() > 30000){
			openDialogAlert("현재 브라우져에서는 대량 다운로드가 원할하지 않을 수 있습니다.<br />다운로드가 되지 않을 시<br />IE에서 다운로드 하시기 바랍니다.", 400, 180);
		}
<?php }?>

		openDialog('회원정보 다운로드','admin_member_download', {'width':550,'height':420});
<?php }else{?>
			openDialogAlert('다운로드 권한이 없습니다.<br /> <a href="../setting/manager"><span class="orange"><b>설정 > 관리자</b></span></a>에서 설정할 수 있습니다.', 400, 150);
			return;
<?php }?>
	});

	$('#send_image').createAjaxFileUpload(uploadConfig, appPushUploadCallback);
	
});

function excelDownloadOk(){
	closeDialog('admin_member_download');
	document.smsForm.action ="../mobile_app_process/sms_member_download";
	document.smsForm.submit();
	document.smsForm.action ="../mobile_app_process/regist_push";
}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">	

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>푸시 발송 관리</h2>
		</div>
		
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->
<div class="contents_container">
<?php $this->print_("top_menu",$TPL_SCP,1);?>


	<!-- 페이지 타이틀 바 : 끝 -->
	<form name="pushForm" id="pushForm" method="post" enctype="multipart/form-data" target="processFrame" action="../mobile_app_process/regist_push">
	<!--input type="hidden" name="table" value="<?php echo $TPL_VAR["table"]?>" />
	<input type="hidden" name="page" value="<?php echo $_GET["page"]?>"/>
	<input type="hidden" name="category"/>
	<input type="hidden" name="send_num"/>
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="mcount" value="0">
	<input type="hidden" name="serialize" id="serialize" value="">
	<input type="hidden" name="searchSelect" value="search">
	<input type="hidden" name="selectMember" value="">
	<input type="hidden" name="reserve_datetime" value=""-->
	<input type="hidden" name="shopSno" value="<?php echo $TPL_VAR["config_system"]["shopSno"]?>" />

	<!-- 서브 레이아웃 영역 : 시작 -->
	<div class="item-title mt10">푸시 발송 설정</div>

	<table class="table_basic">
		<tbody>
			<tr>
				<th>발송 조건</th>
				<td>				
					<div class="resp_radio">
						<label><input type="radio" name="send_type" value="i" checked="checked"> 즉시 발송</label>				
						<label><input type="radio" name="send_type" value="r"> 예약 발송</label>
					</div>				

					<input type="text" name="reserve_date" value="예약 일자 선택" class="datepicker ml10" maxlength="10" />

					<select name="reserve_hour" onchange="chgAnniversaryOption('s', 0, 1);" default_none>
						<!-- option value=""></option-->
<?php if($TPL_h_arr_1){foreach($TPL_VAR["h_arr"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1?>" <?php if($TPL_V1=="08"){?>selected<?php }?>><?php echo $TPL_V1?>시</option>
<?php }}?>
					</select>				
					<select name="reserve_min" onchange="chgAnniversaryOption('s', 1, 0);" default_none>
						<!-- option value=""></option-->
<?php if($TPL_m_arr_1){foreach($TPL_VAR["m_arr"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1?>" <?php if($TPL_V1=="00"){?>selected<?php }?>><?php echo $TPL_V1?>분</option>
<?php }}?>
					</select>							
				</td>
				</td>

			</tr>
			<tr>
				<th>대상</th>
				<td>			
					<input type="radio" name="search_member_yn" value="n" checked="checked" class="hide"> 전체 (앱 설치 고객)				
					<span class="ml20">
					<!--
						<label>
							<input type="radio" name="search_member_yn" value="y">
							<span id="searchSelectText">검색된</span> 회원
						</label>(
						<span class="hand" id="downloadMemberBtn">
							<img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" />
							<u>엑셀다운로드</u>
						</span> 
						<span id="search_member">0</span>명)
						<span class="btn small">
							<button type="button" id="searchMemberBtn">회원검색</button>
						</span>
						-->
					</span>
				</td>				
			</tr>
			<tr>
				<th>제목</th>
				<td>
					<div class="resp_limit_text limitTextEvent">
						<input type="text" id="send_title" name="send_title" value="" size="60" maxlength="20"/>   
					</div>
				</td>
			</tr>       
			
			<tr>
				<th>내용</th>
				<td>
					<textarea name="send_body" id="send_body" class="daumeditor" style="width:80%; height:100px;" ></textarea>
					<ul class="bullet_hyphen resp_message v2">
						<li>1024자까지 입력 가능 합니다.</li>		
						<li>줄바꿈 사용 시 그대로 전송됩니다.</li>		
						<li>광고성 정보의 경우 (광고) 표시가 필수입니다.</li>		
					</ul>
				</td>
			</tr>
			<tr>
				<th>이미지</th>
				<td>
					<!--<label class="resp_btn v2"><input type="file" id="send_image" name="send_image" class="line" accept="image/jpeg, image/png">파일 선택</label> -->							
					<div class="webftpFormItem">									
						<label class="resp_btn v2"><input type="file" id="send_image" class="uploadify" accept="image/jpeg, image/png">파일 선택</label>
						<input type="hidden" class="webftpFormItemInput" name="send_image" />									
						<div class="preview_image"></div>
					</div>	

					<div class="resp_message v2">- 파일 형식 jpg, png, 이미지 사이즈 640px*320px</div>  
				</td>
			</tr>
			<tr>
				<th>연결 URL</th>
				<td>
					<input type="text" id="send_link" name="send_link" value="" size="60" />        
					<button type="button" id="previewBtn" class="resp_btn">미리 보기</button>			
					<div class="resp_message v2">- http:// 혹은 https:// 을 포함 하여 전체 url을 입력 하여 주세요.	</div>                
				</td>
			</tr>
		</tbody>
	</table>
	
	<div class="footer"> 
<?php if($TPL_VAR["app_cnt"]== 0){?><div id="push_noti" class="red mb15">출시된 쇼핑몰앱이 없어 발송할 수 없습니다.</div><?php }?>
<?php if($TPL_VAR["app_cnt"]> 0){?><button type="button" id="send_submit" class="resp_btn active size_XL" >발송</button><?php }?>		
	</div>	
</div>

</form>

<div id="processDiv" class="hide">
<div style='height:10px;'></div>
<table width="100%" cellspacing="0" cellpadding="0" style='border:1px solid #d2d2d2'>
	<tr>
		<td>
		<iframe src="" name="processFrame" frameborder="0" width="100%" height="30" scrolling="no"></iframe>
		</td>
	</tr>
</table>
</div>


<?php $this->print_("member_download_info",$TPL_SCP,1);?>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>