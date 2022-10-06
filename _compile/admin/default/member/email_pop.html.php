<?php /* Template_ 2.2.6 2022/05/17 12:36:26 /www/music_brother_firstmall_kr/admin/skin/default/member/email_pop.html 000005376 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php if($TPL_VAR["css"]!='common-ui'){?>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common-ui.css?mm=<?php echo date('Ymd')?>" />
<?php }?>

<script type="text/javascript">
	$(document).ready(function() {
		EditorJSLoader.ready(function(Editor) {
			DaumEditorLoader.init(".daumeditor");
		});

		$("select[name='selectEmail']").live("change", function(){
			if($(this).val()){
				$.get('/admin/member_process/logmail?seq='+$(this).val(), function(response) {
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
		});

		$("#email_send_submit").click(function(){
			if (Editor.getContent()=="<p><br></p>") {
				openDialogAlert('내용 항목은 필수입니다.','400','140');
				return false;
			}
			submitEditorForm(document.emailFrm);
		});

		/* 2021.12.30 11월 3차 패치 by 김혜진 */
		$("#open_email_list").click(function(){
<?php if($TPL_VAR["private_masking"]){?>
			openDialogAlert("마스킹(*) 처리된 개인정보 항목이 일부 포함되어 있어 이메일 불러오기를 할 수 없습니다.<br/ >대표운영자에게 관리자 권한 수정을 요청해주시기 바랍니다.",600,180,function(){});
<?php }else{?>
			openDialog("최근 발송한 이메일 <span class='desc'>&nbsp;</span>", "email_log_list", {"width":"800","height":"600"});
<?php }?>
		});

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
			closeDialog('email_log_list');
		});

		$("#email_addr").html($("input[name='email']").val());
	})

</script>

<form name="emailFrm" id="emailFrm" method="post" target="actionFrame" action="/admin/member_process/email_pop" style="height:100%;">
	<input type="hidden" name="member_seq" value="<?php echo $TPL_VAR["member_seq"]?>"/>
	<input type="hidden" name="email" value="<?php echo $TPL_VAR["email"]?>"/>
	<input type="hidden" name="order_seq" value="<?php echo $TPL_VAR["order_seq"]?>"/>
	<input type="hidden" name="type" value="<?php echo $TPL_VAR["type"]?>"/>
	<div class="content">
		<div class="item-title">이메일 발송</div>
		<table class="table_basic thl">		
			<tr>
				<th>잔여 건수</th>
				<td><?php if(!$TPL_VAR["email_chk"]){?>잔여 <?php echo number_format($TPL_VAR["mail_count"])?>건<?php }?></td>
			</tr>
			
			<tr>
				<th>받는 사람</th>
				<td><span id="email_addr"></span></td>
			</tr>

			<tr>
				<th>제목</th>
				<td><input type="text" name="title" id="title" value="" style="width:90%" title="제목을 입력해주세요."/></td>
			</tr>
		</table>
		
		<div class="title_dvs">
			<div class="item-title">내용</div>
			<button type="button" id="open_email_list" class="resp_btn v2">이메일 불러오기</button>
		</div>

		<textarea name="contents" id="contents" class="daumeditor" style="width:80%" title="내용을 입력해 주세요."></textarea>
	</div>
	
	<div class="footer">
		<button <?php if($TPL_VAR["isdemo"]["isdemo"]){?> type="button"  <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> type="submit"  id="email_send_submit" <?php }?> class="resp_btn active size_XL">발송</button>
		<button type="button"  class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">취소</button>
	</div>
</form>

<div id="email_log_list" class="hide">
<form name="emailLogFrm" method="post">
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
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">취소</button>
	</div>
</form>
</div>