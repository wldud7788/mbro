<?php /* Template_ 2.2.6 2022/05/25 15:40:22 /www/music_brother_firstmall_kr/admin/skin/default/member/sms_history.html 000005616 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>



<script type="text/javascript">
	$(document).ready(function() {

		$('#search_submit').click(function (){
			smsFrmSubmit();
		});

		smsFrmSubmit();

		$("[name='select_date']").click(function() {
			switch($(this).attr("id")) {
				case 'today' :
					$("input[name='start_date']").val(getDate(0));
					$("input[name='end_date']").val(getDate(0));
					break;
				case '3day' :
					$("input[name='start_date']").val(getDate(3));
					$("input[name='end_date']").val(getDate(0));
					break;
				case '1week' :
					$("input[name='start_date']").val(getDate(7));
					$("input[name='end_date']").val(getDate(0));
					break;
				case '1month' :
					$("input[name='start_date']").val(getDate(30));
					$("input[name='end_date']").val(getDate(0));
					break;
				case '3month' :
					$("input[name='start_date']").val(getDate(90));
					$("input[name='end_date']").val(getDate(0));
					break;
				default :
					$("input[name='start_date']").val('');
					$("input[name='end_date']").val('');
					break;
			}
		});

		// SMS
		$("#sms_form").click(function(){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }else{?>
			var screenWidth;
			var screenHeight;

			screenWidth = 1000;
			screenHeight = 750;

			window.open('../batch/sms_form',"sms_form","menubar=no, toolbar=no, location=yes, status=no, resizble=yes, scrollbars=yes,width=" + screenWidth + ", height=" + screenHeight);
<?php }?>
		});
	});

	

	function smsFrmSubmit ()	{
		if ("<?php echo $TPL_VAR["chk"]?>" == '')
		{
			$.get('../member_process/getAuthPopup?type=B', function(data) {		
				$('#authPopup').html(data);		
				openDialog("SMS 인증번호 <span class='desc'>&nbsp;</span>", "authPopup", {"width":"800","height":"160"});
			});
			return;
		}

		$('#gabiaFrm').attr('action', '<?= get_connet_protocol()?>sms.firstmall.kr/main/user_history');
		$('#gabiaFrm').attr('target', 'gabiaSMS');
		$('#gabiaFrm').submit();
	}
</script>


<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<ul class="page-buttons-left" style="z-index:1;">			
			<li><button type="button" id="sms_form" class="resp_btn active3 size_L">SMS 수동 발송</button></li>			
		</ul>
		
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>SMS 발송 관리</h2>
		</div>
		
		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->
<div class="contents_container">

<?php $this->print_("top_menu",$TPL_SCP,1);?>


	<!-- 서브 레이아웃 영역 : 시작 -->

	<form name="gabiaFrm" id="gabiaFrm" method="get">
		<input type="hidden" name="id" value="<?php echo $TPL_VAR["sms_id"]?>">
		<input type="hidden" name="search_str" value="<?php echo $_GET["tran_phone"]?>">
		<input type="hidden" name="search_type" value="tran_phone">

		<div class="clearbox">
			<table class="info-table-style" style="width:100%; display:none;">
				<colgroup>
					<col width="15%" />
					<col />					
				</colgroup>
				<tbody>				
				<tr>
					<th class="its-th-align center">발송일</th>
					<td class="its-td-align left" style="padding-left:10px;">
						<input type="text" name="start_date" value="<?php echo $TPL_VAR["today"]?>" class="datepicker line"  maxlength="10" size="10" />
						&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
						<input type="text" name="end_date" value="<?php echo $TPL_VAR["today"]?>" class="datepicker line" maxlength="10" size="10" />
						&nbsp;&nbsp;
						<span class="btn small"><input type="button" value="오늘" id="today" name="select_date"/></span>
						<span class="btn small"><input type="button" value="3일간" id="3day" name="select_date"/></span>
						<span class="btn small"><input type="button" value="일주일" id="1week" name="select_date"/></span>
						<span class="btn small"><input type="button" value="1개월" id="1month" name="select_date"/></span>
						<span class="btn small"><input type="button" value="3개월" id="3month" name="select_date"/></span>
						<span class="btn small"><input type="button" value="전체" id="all" name="select_date"/></span>
					</td> 
				</tr> 
				<tr>
					<th class="its-th-align center">수신번호</th>
					<td class="its-td-align left" style="padding-left:10px;">
						
					</td> 
				</tr>
				<!--
				<tr>
					<th class="its-th-align center">문자내용</th>
					<td class="its-td-align left" style="padding-left:10px;"> </td> 
				</tr>
				-->
				<tr>
					<th class="its-th-align center">상태</th>
					<td class="its-td-align left" style="padding-left:10px;">
						<select name="status">
							<option value="A">모든상태</option>
							<option value="0">성공(S)</option>
							<option value="1">실패(F)</option>
						</select>
					</td> 
				</tr>
				</tbody>
			</table>
		</div>
		<div style="width:100%;text-align:center;padding-top:10px;display:none;">
		<span class="btn large gray"><button type="button" id="search_submit">검색</button></span>
		</div>
	</form>


	<table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" class="mt20">
		<style type="text/css">
			#outline #contentLine{width: auto;}
		</style>
		<tr>
			<td>
				<iframe name="gabiaSMS" id="gabiaSMS" width="100%" height="1000" frameborder="0"></iframe>
			</td>
		</tr>
	</table>

</div>
<div id="authPopup" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>