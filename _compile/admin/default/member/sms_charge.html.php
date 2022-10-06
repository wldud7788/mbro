<?php /* Template_ 2.2.6 2022/05/17 12:36:30 /www/music_brother_firstmall_kr/admin/skin/default/member/sms_charge.html 000003888 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	$(document).ready(function() {

		$('#sms_charge').live('click', function (){
			$.get('sms_payment', function(data) {
				$('#smsPopup').html(data);
				openDialog("SMS 충전 <span class='desc'>&nbsp;</span>", "smsPopup", {"width":"800","height":"600"});
			});
		});

		$('#search_submit').click(function (){
			smsFrmSubmit();
		});

		if ("<?php echo $TPL_VAR["chk"]?>" != ''){
			smsFrmSubmit();
		}else{
			$.get('../member_process/getAuthPopup?type=A', function(data) {
				$('#authPopup').html(data);
				openDialog("SMS 계정 <span class='desc'>&nbsp;</span>", "authPopup", {"width":"600","height":"150"});
			});
		}

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

	function smsFrmSubmit ()
	{
		if ("<?php echo $TPL_VAR["chk"]?>" == '')
		{
			$.get('../member_process/getAuthPopup?type=A', function(data) {
				$('#authPopup').html(data);
				openDialog("SMS 계정 <span class='desc'>&nbsp;</span>", "authPopup", {"width":"600","height":"150"});
			});
			return;
		}
		$('#gabiaSMSFrm').attr('action', '//firstmall.kr/payment_firstmall/sms_account_log.php');
		$('#gabiaSMSFrm').attr('target', 'gabiaSMS');
		$('#gabiaSMSFrm').submit();

		$("#gabiaSMS").css("width",$("#top_table").css("width"));
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

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">
<?php $this->print_("top_menu",$TPL_SCP,1);?>


<!-- 서브 레이아웃 영역 : 시작 -->
<div class="item-title">SMS 현황</div>
<div class="clearbox">
	<table class="table_basic thl">			
		<tr>
			<th>현황</th>
			<td> <?php echo $TPL_VAR["count"]?>건</td>
		</tr>	
		<tr>
			<th>SMS 충전</th>
			<td><button type="button"  <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> id="sms_charge" <?php }?> class="resp_btn active">충전</button></td>
		</tr>	
	</table>
</div>


<form name="gabiaSMSFrm" id="gabiaSMSFrm" method="post">
<input type="hidden" name="params" value="<?php echo $TPL_VAR["param"]?>">
<div class="title_dvs">
	<div class="item-title">충전 내역</div>
	<div class="resp_btn_dvs">
		<select name="year">
			<?php
			$year	= date('Y');
			for($y=2002; $y<=$year; $y++)
			{
			?>
			<option value="<?=$y?>"<?=($year == $y) ? " selected" : ""?>><?=$y?></option>
			<?php
			}
			?>
		</select>
		<button type="button" id="search_submit" class="resp_btn active">검색</button>
	</div>
</div>
</form>


<?php if($TPL_VAR["chk"]!=''){?>
<table width="96%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
	<td>
		<iframe name="gabiaSMS" id="gabiaSMS" style="width:100%;height:700px;" frameborder="0"></iframe>
	</td>
</tr>
</table>
</div>
<?php }?>


<div id="smsPopup" class="hide"></div>
<div id="authPopup" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>