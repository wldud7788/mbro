<?php /* Template_ 2.2.6 2022/05/17 12:36:31 /www/music_brother_firstmall_kr/admin/skin/default/member/sms_restriction.html 000004718 */ 
$TPL_restriction_item_1=empty($TPL_VAR["restriction_item"])||!is_array($TPL_VAR["restriction_item"])?0:count($TPL_VAR["restriction_item"]);
$TPL_loop_config_time_1=empty($TPL_VAR["loop_config_time"])||!is_array($TPL_VAR["loop_config_time"])?0:count($TPL_VAR["loop_config_time"]);
$TPL_loop_reserve_time_1=empty($TPL_VAR["loop_reserve_time"])||!is_array($TPL_VAR["loop_reserve_time"])?0:count($TPL_VAR["loop_reserve_time"]);?>
<script>
$(document).ready(function() {
	$("#btnRestrictionConfig").click(function(){
		$("#restrictionForm").attr("action","../member_process/sms_restriction");
		$("#restrictionForm").submit();
	}); 
	$(".adminck").on("click",function(){
		var no = $(this).attr("no");
		$("#sys_"+no).attr("checked",$(this).is(":checked"));
	});
});
</script>

<form name="restrictionForm" id="restrictionForm" method="post" action="" target="actionFrame" class="hx100">
<input type="hidden" name="mode" value="<?php echo $_GET['mode']?>">
	<div class="content">
		<div class="item-title">메시지</div>
		<table class="table_basic thl">
			<!-- 테이블 헤더 : 시작 -->
<?php if($_GET['mode']!="board"){?>		
<?php if($TPL_restriction_item_1){$TPL_I1=-1;foreach($TPL_VAR["restriction_item"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>			
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_K2=>$TPL_V2){$TPL_I2++;?>
<?php if($TPL_V2["use"]=='y'){?>
			<tr>
<?php if($TPL_VAR["ori_key"]!=$TPL_K1){?>
				<th rowspan="<?php echo $TPL_V1["usecnt"]?>"><?php echo $TPL_VAR["restriction_title"][$TPL_K1]?></th>
				<?php echo $this->assign('ori_key',$TPL_K1)?>

<?php }?>
				<td>
<?php if($TPL_V2["ac_admin"]!=""){?><label class="resp_checkbox"><input type="checkbox" name="<?php echo $TPL_K2?>" no="<?php echo $TPL_I1?><?php echo $TPL_I2?>" class="adminck" <?php echo $TPL_VAR["sms_rest"][$TPL_K2]?> value="checked"></label><?php }?> 
					<?php echo $TPL_VAR["restriction_title"][$TPL_K2]?>

				</td>			
			</tr>
<?php }?>
<?php }}?>
<?php }}?>
			
<?php }else{?>
			<colgroup>
				<col width="20%">
				<col>
			</colgroup>
			<tr>
				<th>
					<label for="form-element-board_toadmin">게시글 메시지</label>
				</th>
				<td>
					<label>
						<input type="checkbox" name="board_toadmin" id="form-element-board_toadmin" <?php echo $TPL_VAR["sms_rest"]['board_toadmin']?> value="checked">
						<span>게시글 작성 시 (관리자)</span>
					</label>
				</td>
			</tr>
			<tr>
				<th>
					<label for="form-element-board_touser">답글 메시지</label>
				</th>
				<td>
					<label>
						<input type="checkbox" name="board_touser" id="form-element-board_touser" <?php echo $TPL_VAR["sms_rest"]['board_touser']?> value="checked">
						<span>답글 작성 시 (고객)</span>
					</label>
				</td>
			</tr>
<?php }?>
		</table>
		
		<div class="item-title">발송 시간 제한</div>
		<table class="table_basic thl">		
			<tr>
				<th>발송 제한 시간</th>
				<td>
					<select name="<?php echo $TPL_VAR["config_field"][ 0]?>">
<?php if($TPL_loop_config_time_1){foreach($TPL_VAR["loop_config_time"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php echo $TPL_VAR["selected"]["config_time_s"][$TPL_V1]?>><?php echo $TPL_V1?>시</option>
<?php }}?>
					</select>
					 ~ 
					<select name="<?php echo $TPL_VAR["config_field"][ 1]?>">
<?php if($TPL_loop_config_time_1){foreach($TPL_VAR["loop_config_time"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php echo $TPL_VAR["selected"]["config_time_e"][$TPL_V1]?>><?php echo $TPL_V1?>시</option>
<?php }}?>
					</select>
				</td>
			</tr>	
			
			<tr>
				<th>재발송 시간</th>
				<td>
					오전 8시 
					<select name="<?php echo $TPL_VAR["config_field"][ 2]?>">
<?php if($TPL_loop_reserve_time_1){foreach($TPL_VAR["loop_reserve_time"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>" <?php echo $TPL_VAR["selected"]["reserve_time"][$TPL_K1]?>><?php echo $TPL_V1?></option>
<?php }}?>
					</select> 부터 순차적으로 자동 발송
				</td>
			</tr>	
		</table>
		<div class="resp_message">- SMS 발송시간 상세 안내 <a href="https://www.firstmall.kr/customer/faq/1266" target="_blank" class="resp_btn_txt">자세히 보기</a></div>
	</div>

	<div class="footer">
		<button type="button" id="btnRestrictionConfig" class="resp_btn active size_XL">확인</button>
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialog('restrictionPopup')">취소</button>
	</div>

</form>