<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/member/email_log_list_pop.html 000002008 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
$(document).ready(function() {	
	$(".selectEmailBtn").live("click", function(){

		if($("input[name='radioSeq']:checked").val()){
			$.get('../member_process/logmail?seq='+$("input[name='radioSeq']:checked").val(), function(response) {
				var data = eval(response)[0];
				$("#title").val(data.title);
				Editor.switchEditor($("#contents").data("initializedId"));
				Editor.modify({"content" : data.contents});
			});
		}else{
			$("#title").val('');
			Editor.switchEditor($("#contents").data("initializedId"));
			Editor.modify({"content" : " "});
		}
		closeDialog('emailLogListPopup');
	});
});

</script>


<form name="emailLogFrm" method="post" class="hx100">
	<div class="content">
		<table class="table_basic tdc">
			<colgroup>
				<col width="60" />
				<col width="150" />
				<col />
			</colgroup>	
			<thead>
				<tr>
					<th>선택</th>
					<th>발송 날짜</th>
					<th>제목</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_loop_1){$TPL_I1=-1;foreach($TPL_VAR["loop"] as $TPL_V1){$TPL_I1++;?>
			<tr onclick="$('#radioSeq<?php echo $TPL_I1?>').attr('checked',true);" class="hand">
				<td><label class="resp_radio"><input type="radio" name="radioSeq" id="radioSeq<?php echo $TPL_I1?>" value="<?php echo $TPL_V1["seq"]?>" <?php if($TPL_I1== 0){?>checked<?php }?>></label></td>
				<td><?php echo $TPL_V1["regdate"]?></td>
				<td class="left"><?php echo $TPL_V1["subject"]?></td>
			</tr>
<?php }}?>
	</table>
	</div>
	<div class="footer">
		<button type="button" class="selectEmailBtn resp_btn active size_XL">불러오기</button>
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialog('emailLogListPopup');">취소</button>
	</div>
</form>