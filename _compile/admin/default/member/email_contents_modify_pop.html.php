<?php /* Template_ 2.2.6 2022/05/17 12:36:26 /www/music_brother_firstmall_kr/admin/skin/default/member/email_contents_modify_pop.html 000003099 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<style>
	html{overflow:hidden;}
	.tx-canvas iframe {height:500px !important;}
</style>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var mode = getParameterByName('mode');
		$("#btn_replace").on("click",function(event){		
			$.get('replace_pop?mode=' + mode, function(data) {
				console.log(data);
				$('#replace_pop').html(data);
				openDialog("사용 가능한 치환코드", "replace_pop", {"width":"450","height":"580"});
			});
		});

		getMailForm(mode);
		$("input[name='mail_form']").val([mode]);
	})

	function getMailForm(id) {
		$.get('../member_process/getmail?id='+id, function(response) {
			var data = eval(response)[0];
			$("#title").val(data.title);
			Editor.switchEditor($("#contents").data("initializedId"));
			Editor.modify({"content" : data.contents});
			//$("#email_chk").html("<?php echo $TPL_VAR["html"]?>");
			if(id == "marketing_agree" || id == "marketing_agree_status"){
				$("#title").attr('readonly', true).css('background-color', '#EEE');
				$(".admin_email").hide();
			} else {
				$("#title").attr('readonly', false).css('background-color', '');
				$(".admin_email").show();
			}
		});
	}
</script>

<div class="contents_container">
<form name="memberForm" id="memberForm" method="post" target="actionFrame" action="../member_process/email" class="hx100">
<input type="hidden" name="mail_form" />
	<div class="content">
		<div class="item-title">이메일 발송</div>

		<table class="table_basic thl">	
			<tr>
				<th>보내는 이메일</th>
				<td><?php echo $TPL_VAR["email"]?></td>
			</tr>
<?php if($TPL_VAR["mode"]!="findid"&&$TPL_VAR["mode"]!="findpwd"&&$TPL_VAR["mode"]!="marketing_agree"&&$TPL_VAR["mode"]!='marketing_agree_status'){?>
			<tr>
				<th>수신 관리자 이메일</th>
				<td><input type='text' name='<?php echo $TPL_VAR["mode"]?>_admin_email' value='<?php echo $TPL_VAR["admin_email"]?>' /></td>
			</tr>
<?php }?>
			<tr>
				<th>제목</th>
				<td>
					<input type="text" name="title" id="title" size="100"/>
					<button type="button" id="btn_replace" class="resp_btn" >치환 코드</button>
				</td>
			</tr>		
		</table>

		<div class="item-title">내용</div>
		<textarea name="contents" id="contents" class="daumeditor hide"></textarea>
	</div>

	<div class="footer">
		<button type="button" onclick="submitEditorForm(document.memberForm)" class="resp_btn active size_XL">저장</button>
		<button type="button" onclick="window.close();" class="resp_btn v3 size_XL">취소</button>
	</div>
	</form>
</div>


<div id="replace_pop" class="hide"></div>
<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>