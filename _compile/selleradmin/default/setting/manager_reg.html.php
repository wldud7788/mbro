<?php /* Template_ 2.2.6 2022/05/17 12:29:29 /www/music_brother_firstmall_kr/selleradmin/skin/default/setting/manager_reg.html 000033699 */ 
$TPL_auth_1=empty($TPL_VAR["auth"])||!is_array($TPL_VAR["auth"])?0:count($TPL_VAR["auth"]);
$TPL_boardmanagerlist_1=empty($TPL_VAR["boardmanagerlist"])||!is_array($TPL_VAR["boardmanagerlist"])?0:count($TPL_VAR["boardmanagerlist"]);
$TPL_limit_ip_1=empty($TPL_VAR["limit_ip"])||!is_array($TPL_VAR["limit_ip"])?0:count($TPL_VAR["limit_ip"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript">
	var auth_arr = new Array();
	var auth_flag = <?php if(!$TPL_VAR["auth_limit"]){?>true<?php }else{?>false<?php }?>;
		var auth_limit = <?php if($TPL_VAR["auth_limit"]&&$TPL_VAR["manager_yn"]=='Y'){?>true<?php }else{?>false<?php }?>;

			$(document).ready(function() {
				$(".auth").each(function(i){
					auth_arr[i] = $(this).attr('name');
				});

				$("#id_chk").click(function(){
					var id = $("input[name='provider_id']").val();
					if(!id){
						$("input[name='provider_id']").focus();
						return;
					}
					$.post("../setting_process/id_chk", { provider_id : id }, function(response){
						//debug(response);
						//var text = response.return_result;
						//var provider_id = response.provider_id;
						alert(response.return_result);
					},'json');
				});

				$("#allClick").click(function(){
					if($(this).attr("gb")=="none"){
						$(".auth").attr("checked",true);
						$("input.authboard").attr("checked",true);
						$("#click_text").html("전체해제");
						$(this).attr("gb","click");
						$("input.board_view_pw").attr("disabled",false);
						$("input.board_act").attr("disabled",false);
					}else{
						$(".auth").attr("checked",false);
						$("input.authboard").attr("checked",false);
						$("#click_text").html("전체선택");
						$(this).attr("gb","none");
						$("input.board_view_pw").attr("disabled",true);
						$("input.board_act").attr("disabled",true);
					}
					init_auth();
				});

				$(".board_view").click(function() {
					if($(this).attr("checked")){
						$(this).parent().parent().find(".board_view_pw").attr("checked",true);
						$(this).parent().parent().find(".board_act").attr("checked",true);
						$(this).parent().parent().find(".board_view_pw").attr("disabled",false);
						$(this).parent().parent().find(".board_act").attr("disabled",false);
					}else{
						$(this).parent().parent().find(".board_view_pw").attr("checked",false);
						$(this).parent().parent().find(".board_act").attr("checked",false);
						$(this).parent().parent().find(".board_view_pw").attr("disabled",true);
						$(this).parent().parent().find(".board_act").attr("disabled",true);
					}
				});

				$("input[name='modify_passwd']").click(function(){
					if($(this).attr("checked")){
						$("#manager_passwd_confirm").show();
						$("input[name='mpasswd']").attr("disabled",false);
						$("input[name='mpasswd_re']").attr("disabled",false);
					}else{
						$("#manager_passwd_confirm").hide();
						$("input[name='mpasswd']").attr("disabled",true);
						$("input[name='mpasswd_re']").attr("disabled",true);
					}
				});

<?php if($TPL_VAR["provider_seq"]){?>
<?php if($TPL_VAR["manager_yn"]=='Y'){?>
				$(".auth").attr("checked",true);
<?php }else{?>
<?php if($TPL_auth_1){foreach($TPL_VAR["auth"] as $TPL_K1=>$TPL_V1){?>
				if('<?php echo $TPL_V1?>'=='Y' && !auth_flag) $("input[name='<?php echo $TPL_K1?>']").attr("checked",true);
				if(auth_flag && '<?php echo $TPL_V1?>'!='Y'){
					$("input[name='<?php echo $TPL_K1?>']").closest("label").css('color','#b6b6b6');
				}
<?php }}?>
<?php if($TPL_boardmanagerlist_1){foreach($TPL_VAR["boardmanagerlist"] as $TPL_V1){?>
					if(auth_flag && '<?php echo $TPL_V1["board_view"]?>' == 0){
						$("input[name='board_view[<?php echo $TPL_V1["id"]?>]']").closest("label").css('color','#b6b6b6');
					}
					if(auth_flag && '<?php echo $TPL_V1["board_view_pw"]?>' == 0){
						$("input[name='board_view_pw[<?php echo $TPL_V1["id"]?>]']").closest("label").css('color','#b6b6b6');
					}
					if(auth_flag && '<?php echo $TPL_V1["board_act"]?>' == 0){
						$("input[name='board_act[<?php echo $TPL_V1["id"]?>]']").closest("label").css('color','#b6b6b6');
					}
<?php }}?>
<?php }?>
<?php }?>

								if(auth_flag || auth_limit){
									$('.auth,.authboard').closest("label").css({'cursor':'default'});
									$('.auth,.authboard').remove();
								}

								$("input[name='member_download_passwd']").bind('focus',function(){
									// 기존 비밀번호 변경시 암호화된 비밀번호 삭제
<?php if($TPL_VAR["provider_seq"]){?>
									if ($("input[name='member_download']").is(':checked')) {
										if ($("input[name='member_download_passwd']").val()) {
											if ("<?php echo $TPL_VAR["member_download_passwd"]?>"==$("input[name='member_download_passwd']").val()) {
												var chk = confirm("다운로드 비밀번호를 변경하시겠습니까?");
												if (chk) {
													$("input[name='member_download_passwd']").val("");
													$("input[name='member_download_passwd']").focus();
												} else {
													$(this).blur();
												}
											}
										}
									}
<?php }?>
									});

									$(".auth").bind('click',function(){
										var tmp = $(this).attr("name").split("_");
										if(tmp[tmp.length-1]=='view'){
											if($(this).attr("checked")){
												for(var i=0;i<auth_arr.length;i++){
													if(tmp[0]=='setting'){
														var tmp_text = tmp[0]+"_"+tmp[1];
														if(tmp_text==auth_arr[i].substring(0,tmp_text.length)){
															if($(this).attr("name")!=auth_arr[i]) $("input[name='"+auth_arr[i]+"']").attr("disabled",false);
														}
													}else{
														if(tmp[0]==auth_arr[i].substring(0,tmp[0].length)){
															if($(this).attr("name")!=auth_arr[i]) $("input[name='"+auth_arr[i]+"']").attr("disabled",false);
														}
													}
												}
											}else{
												for(var i=0;i<auth_arr.length;i++){
													if(tmp[0]=='setting'){
														var tmp_text = tmp[0]+"_"+tmp[1];
														if(tmp_text==auth_arr[i].substring(0,tmp_text.length)){
															if($(this).attr("name")!=auth_arr[i]){
																$("input[name='"+auth_arr[i]+"']").attr("checked",false);
																$("input[name='"+auth_arr[i]+"']").attr("disabled",true);
															}
														}
													}else if(tmp[0]==auth_arr[i].substring(0,tmp[0].length) && tmp[0]!='setting'){
														if($(this).attr("name")!=auth_arr[i]){
															$("input[name='"+auth_arr[i]+"']").attr("checked",false);
															$("input[name='"+auth_arr[i]+"']").attr("disabled",true);
														}
													}
												}
											}
										}
									});

									$("input[name='ip_chk']").click(function(){
										init_func();
									});

									$("input[name='hp_chk']").click(function(){
										init_hp();
									});

									$("input[name='passwd_chg']").bind("click",function(){
										if($(this).attr("checked")){
											$("#r_pass").show();
											$("#manager_passwd_confirm").show();
										}else{
											$("#r_pass").hide();
											$("#manager_passwd_confirm").hide();
										}
									});

									/* 아이피 추가 */
									$("#ipViewTable button#ipAdd").bind("click",function(){
										var html="";
										html = '<tr>';
										html += '	<td>';
										html += '	<input type="text" name="limit_ip1[]" value="" class="line limit_ip" size=4 maxlength=3 />.';
										html += '	<input type="text" name="limit_ip2[]" value="" class="line limit_ip" size=4 maxlength=3 />.';
										html += '	<input type="text" name="limit_ip3[]" value="" class="line limit_ip" size=4 maxlength=3 />.';
										html += '	<input type="text" name="limit_ip4[]" value="" class="line limit_ip" size=4 maxlength=3 />';
										html += '	</td><td><button type="button" id="ipDel" onclick="del_ip(this)" class="btn_minus"></button>';
										html += '	</td>';
										html += '</tr>';

										$("#ipViewTable").append(html);
										init_func();
									});

									/* 아이피 추가 */
									$("#adminIpAdd").bind("click",function(){
										var html		= '';
										var disabled	= '';
										if	(!$(this).closest('td').find("input[name='admin_ip_chk']").attr('checked')){
											disabled	= 'disabled="disabled"';
										}
										html += '	<div>';
										html += '	<input type="text" name="admin_limit_ip1[]" value="" class="line admin_limit_ip" size="4" maxlength="3" ' + disabled + ' />.';
										html += '	<input type="text" name="admin_limit_ip2[]" value="" class="line admin_limit_ip" size="4" maxlength="3" ' + disabled + ' />.';
										html += '	<input type="text" name="admin_limit_ip3[]" value="" class="line admin_limit_ip" size="4" maxlength="3" ' + disabled + ' />.';
										html += '	<input type="text" name="admin_limit_ip4[]" value="" class="line admin_limit_ip" size="4" maxlength="3" ' + disabled + ' />';
										html += '	<span class="btn-minus"><button type="button" id="adminIpDel" onclick="del_admin_ip(this)"></button></span>';
										html += '	</div>';
										$("#adminIpCell").append(html);
									});

									init_func();
									init_auth();
									init_hp();
									admin_init_func();
								});

								function del_ip(obj){
									var bobj = $(obj);
									if($("#ipViewTable tr").length <= 2) return
									bobj.closest("tr").remove();
								}

								function del_admin_ip(obj){
									var bobj = $(obj);
									bobj.closest("div").remove();
								}

								function init_func(){

									if($("input[name='ip_chk']").attr("checked")){
										$(".ip_view").show();
										$(".limit_ip").attr("disabled",false);
									}else{
										$(".limit_ip").val('');
										$(".ip_view").hide();
										$(".limit_ip").attr("disabled",true);
									}
								}

								function admin_init_func(){
									if($("input[name='admin_ip_chk']").attr("checked")){
										$(".admin_limit_ip").attr("disabled",false);
									}else{
										$(".admin_limit_ip").val('');
										$(".admin_limit_ip").attr("disabled",true);
									}
								}


								function init_hp(){
									if($("input[name='hp_chk']").attr("checked")){
										$(".auth_hp").show();
										$(".auth_hp").attr("disabled",false);
									}else{
										$("input[name='auth_hp']").val('');
										$(".auth_hp").hide();
										$(".auth_hp").attr("disabled",true);
									}
								}


								function init_auth(){
									for(var z=0;z<auth_arr.length;z++){
										if(auth_arr[z]=='event_view' || auth_arr[z]=='setting_manager_view'){
										}else{
											var tmp = auth_arr[z].split("_");
											if(tmp[tmp.length-1]=='view'){
												if(!$("input[name='"+auth_arr[z]+"']").attr("checked")){
													for(var i=0;i<auth_arr.length;i++){
														if(tmp[0]=='setting'){
															var tmp_text = tmp[0]+"_"+tmp[1];
															if(tmp_text==auth_arr[i].substring(0,tmp_text.length)){
																if(auth_arr[z]!=auth_arr[i]) $("input[name='"+auth_arr[i]+"']").attr("disabled",true);
															}
														}else{
															if(tmp[0]==auth_arr[i].substring(0,tmp[0].length)){
																if($("input[name='"+auth_arr[z]+"']").attr("name")!=auth_arr[i]) $("input[name='"+auth_arr[i]+"']").attr("disabled",true);
															}
														}
													}
												}else{
													for(var i=0;i<auth_arr.length;i++){
														if(tmp[0]!='setting'){
															if(tmp[0]==auth_arr[i].substring(0,tmp[0].length)){
																if($("input[name='"+auth_arr[z]+"']").attr("name")!=auth_arr[i]) $("input[name='"+auth_arr[i]+"']").attr("disabled",false);
															}
														}else{
															if(tmp[0]==auth_arr[i].substring(0,tmp[0].length)){
																if($("input[name='"+auth_arr[z]+"']").attr("name")!=auth_arr[i]) $("input[name='"+auth_arr[i]+"']").attr("disabled",false);
															}
														}
													}
												}
											}
										}
									}
								}

								function info_policy(){
									openDialog('안내) 개인정보 보호 법률','admin_policy_info',{'width':800,'height':380});
								}

// IP 필수 입력 확인
								function check_vaild_ip(){

									var ip1	= ip2 = ip3 = '';
									var chkStatus		= true;
									var errMsg			= '아이피 대역이 잘못되었습니다.<br />아이피 대역은 0~255 사이의 숫자만 입력해주세요.<br />아이피 3번째 자리까지는 필수 입력하셔야 합니다.';
									if	($("input[name='ip_chk']").attr('checked')){
										$("input[name='limit_ip1[]']").each(function(idx){
											ip1		= $(this).val();
											ip2		= $("input[name='limit_ip2[]']").eq(idx).val();
											ip3		= $("input[name='limit_ip3[]']").eq(idx).val();
											if	( !( ( ip1 > 0 && ip1 < 255 ) && ( ip2 > 0 && ip2 < 255 ) && ( ip3 > 0 && ip3 < 255 ) ) ){
												chkStatus	= false;
											}
										});
										if	(!chkStatus){
											openDialogAlert(errMsg, 400,180, function(){});
											return false;
										}
									}
									if	($("input[name='admin_ip_chk']").attr('checked')){
										$("input[name='admin_limit_ip1[]']").each(function(idx){
											ip1		= $(this).val();
											ip2		= $("input[name='admin_limit_ip2[]']").eq(idx).val();
											ip3		= $("input[name='admin_limit_ip3[]']").eq(idx).val();
											if	( !( ( ip1 > 0 && ip1 < 255 ) && ( ip2 > 0 && ip2 < 255 ) && ( ip3 > 0 && ip3 < 255 ) ) ){
												chkStatus	= false;
											}
										});
										if	(!chkStatus){
											openDialogAlert(errMsg, 400, 180, function(){});
											return false;
										}
									}

									return true;
								}

// 자신의 아이피를 허용하지 않았을 경우 경고 메시지처리
								function check_self_ip(){
									var self_ip = '<?php echo $_SERVER["REMOTE_ADDR"]?>';
									var apply_exist = false;
									var self_apply = false;
									var apply_exist_login = false;
									var self_apply_login = false;
									var ip = '';
									var patt = '';
									var result = '';
									var ips = '';
									var ips_login = '';
									var ip_num = 0;
									var ip_num_login = 0;

									if	(!check_vaild_ip())	return false;
									$("input[name='limit_ip1[]']").each(function(idx){
										if( $(this).val() ){
											apply_exist = true;
											ip = $(this).val();
											if( $("input[name='limit_ip2[]']").eq(idx).val() ){
												ip += '.'+$("input[name='limit_ip2[]']").eq(idx).val();
											}
											if( $("input[name='limit_ip3[]']").eq(idx).val() ){
												ip += '.'+$("input[name='limit_ip3[]']").eq(idx).val();
											}
											if( $("input[name='limit_ip4[]']").eq(idx).val() ){
												ip += '.'+$("input[name='limit_ip4[]']").eq(idx).val();
											}
											eval('patt = /^'+ip+'/i;');
											result =  patt.test(self_ip);
											if( result ){
												self_apply = true;
											}
											if( $("input[name='limit_ip4[]']").eq(idx).val() == '' ){
												ips += ip+'.1 ~ '+ip+'.255<br>';
											}else{
												ips += ip+'<br>';
											}
											ip_num++;
										}
									});
									$("input[name='admin_limit_ip1[]']").each(function(idx){
										if( $(this).val() ){
											apply_exist_login = true;
											ip = $(this).val();
											if( $("input[name='admin_limit_ip2[]']").eq(idx).val() ){
												ip += '.'+$("input[name='admin_limit_ip2[]']").eq(idx).val();
											}
											if( $("input[name='admin_limit_ip3[]']").eq(idx).val() ){
												ip += '.'+$("input[name='admin_limit_ip3[]']").eq(idx).val();
											}
											if( $("input[name='admin_limit_ip4[]']").eq(idx).val() ){
												ip += '.'+$("input[name='admin_limit_ip4[]']").eq(idx).val();
											}
											eval('patt = /^'+ip+'/i;');
											result =  patt.test(self_ip);
											if( result ){
												self_apply_login = true;
											}
											if( $("input[name='admin_limit_ip4[]']").eq(idx).val() == '' ){
												ips_login += ip+'.1 ~ '+ip+'.255<br>';
											}else{
												ips_login += ip+'<br>';
											}
											ip_num_login++;
										}
									});

									var height = 0;
									if( (!self_apply && apply_exist) || ( !self_apply_login && apply_exist_login ) ){
										var msg = '<div class="left">';
										if( !self_apply && apply_exist ){
											msg += '<b>[관리환경 관리페이지]</b><br>아래는 입력하신 접속허용 IP입니다.<br>'+ips+'<br>현재 접속 IP는 입력하신 접속허용 IP에는 포함되어 있지 않습니다.';
											msg += '<br>계속 진행하시면 현재 접속 IP에서는';
											msg += " 관리페이지";
											msg += '를 접속할 수 없게 됩니다.<br>';
											height += 6 + ip_num;
										}
										if( !self_apply_login && apply_exist_login ){
											if( !self_apply && apply_exist ){
												msg += '<br>';
											}
											msg += '<b>[관리환경 로그인페이지]</b><br>아래는 입력하신 접속허용 IP입니다.<br>'+ips_login+'<br>현재 접속 IP는 입력하신 접속허용 IP에는 포함되어 있지 않습니다.';
											msg += '<br>계속 진행하시면 현재 접속 IP에서는';
											msg += " 로그인페이지";
											msg += '를 접속할 수 없게 됩니다.';
											height += 7 + ip_num_login;
										}
										msg += '</div>';

										height = height * 20 + 100;
										openDialogConfirm(msg,550,height,function(){
											settingForm.submit();
											return true;
										},function(){
											return false;
										});
									}else{
										settingForm.submit();
									}
								}
</script>
<style>
	table.change_password tr th {font-weight:normal;padding-right:10px;text-align:right;}
</style>
<!-- <?php if($TPL_VAR["provider_seq"]){?> -->
<form name="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/manager_modify" target="actionFrame">
	<input type="hidden" name="provider_seq" value="<?php echo $TPL_VAR["provider_seq"]?>"/>
	<!-- <?php }else{?> -->
	<form name="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/manager_reg" target="actionFrame">
		<!-- <?php }?> -->

		<!-- 페이지 타이틀 바 : 시작 -->
		<div id="page-title-bar-area">
			<div id="page-title-bar">

				<!-- 타이틀 -->
				<div class="page-title">
					<h2>관리자</h2>
				</div>

				<!-- 좌측 버튼 -->
				<div class="page-buttons-left">
					<a href="manager" type="button" class="resp_btn v3 size_L" >관리자 리스트</a>
				</div>

				<!-- 우측 버튼 -->
				<div class="page-buttons-right">
<?php if(($TPL_VAR["providerInfo"]["manager_yn"]=='Y'&&$TPL_VAR["providerInfo"]["provider_seq"]==$TPL_VAR["provider_seq"])||$TPL_VAR["isdemo"]["isdemo"]){?>
					<button class="resp_btn active2 size_L" type="button" <?php if($TPL_VAR["isdemo"]["isdemo"]){?><?php echo $TPL_VAR["isdemo"]["isdemojs1"]?><?php }else{?> onclick="check_self_ip();"<?php }?>>저장</button>
<?php }else{?>
					<button class="resp_btn active2 size_L" type="submit">저장</button>
<?php }?>
				</div>
			</div>
		</div>
		<!-- 페이지 타이틀 바 : 끝 -->

		<!-- 서브 레이아웃 영역 : 시작 -->
		<div class="contents_container">
			<!-- 서브메뉴 바디 : 시작-->
			<div class="contents_dvs">
				<div class="item-title">관리자 정보</div>
				<table class="table_basic thl">

<?php if($TPL_VAR["provider_seq"]){?>
					<tr>
						<th>최근 접속일</th>
						<td><?php echo $TPL_VAR["lastlogin_date"]?></td>
					</tr>

					<tr>
						<th>등록일</th>
						<td><?php echo $TPL_VAR["regdate"]?></td>
					</tr>

					<tr>
						<th>관리자 구분</th>
						<td><?php if($TPL_VAR["manager_yn"]=='Y'){?>대표운영자<?php }else{?>부운영자<?php }?></td>
					</tr>
<?php }?>

					<tr>
						<th>관리자 아이디</th>
						<td>
<?php if($TPL_VAR["provider_seq"]){?>
							<b><?php echo $TPL_VAR["provider_id"]?></b>
<?php }else{?>
							<label><?php echo substr($TPL_VAR["providerInfo"]["provider_id"], 0, 4)?>_
								<input type="text" name="provider_id" value="" class="line"/>
							</label>
							<button type="button" class="btn_resp b_gray2" id="id_chk">중복확인</button>

							<div class="resp_message v2">- 첫 글자는 영문이며, 영문 또는 숫자 대소문자 4-16자 이하</div>
<?php }?>
						</td>
					</tr>
<?php if($TPL_VAR["provider_seq"]){?>
					<tr>
						<th>
							비밀번호
							<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/manager', '#tip6', 'sizeM')"></span>
						</th>
						<td>
							<label class="resp_checkbox"><input type="checkbox" name="passwd_chg" value="Y" /> 변경</label>
						</td>
					</tr>
<?php }?>
					<tr id="r_pass" <?php if($TPL_VAR["provider_seq"]){?>style="display:none;"<?php }?>>
					<th>
						비밀번호 설정
<?php if(!$TPL_VAR["provider_seq"]){?><span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/manager', '#tip6', 'sizeM')"></span><?php }?>
					</th>
					<td>
<?php if($TPL_VAR["provider_seq"]){?>
						<span>

						<dl class="change_password dl_list_01 w120">
							<dt>현재 비밀번호</dt>
							<dd><input type="password" name="manager_password" value="" class="line" /></dd>
						</dl>
						<dl class="change_password dl_list_01 w120">
							<dt>비밀번호 변경</dt>
							<dd><input type="password" name="mpasswd" class="line" /></dd>
						</dl>
						<dl class="change_password dl_list_01 w120">
							<dt>비밀번호 변경 확인</dt>
							<dd><input type="password" name="mpasswd_re" class="line" /></dd>
						</dl>

						<ul class="bullet_hyphen resp_message v2">
							<li>영문 대소문자 또는 숫자, 특수문자 중 2가지 이상 조합으로 10-20자 미만</li>
							<li>사용 가능 특수문자 # $ % & ( ) * + - / : < = > ? @ [ ＼ ] ^ _ { | } ~</li>
						</ul>
					
					</span>
<?php }else{?>

						<dl class="change_password dl_list_01 w120">
							<dt>비밀번호</dt>
							<dd><input type="password" name="mpasswd" class="line" /></dd>
						</dl>
						<dl class="change_password dl_list_01 w120">
							<dt>비밀번호 확인</dt>
							<dd><input type="password" name="mpasswd_re" class="line" /></dd>
						</dl>

						<ul class="bullet_hyphen  resp_message v2">
							<li>영문 대소문자 또는 숫자, 특수문자 중 2가지 이상 조합으로 10-20자 미만</li>
							<li>사용 가능 특수문자 # $ % & ( ) * + - / : < = > ? @ [ ＼ ] ^ _ { | } ~</li>
						</ul>
<?php }?>
					</td>
					</tr>

					<tr>
						<th>관리자명</th>
						<td><input type="text" name="provider_name" value="<?php echo $TPL_VAR["provider_name"]?>" class="line"/></td>
					</tr>
				</table>
			</div>

			<div class="contents_dvs">
				<div class="item-title">
					관리자 로그인 보안
					<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/manager', '#tip1')"></span>
				</div>

				<table class="table_basic thl">
					<tr>
						<th>비밀번호 변경</th>
						<td>비밀번호 변경 후 90일 경과 시 비밀번호 변경 자동 안내</td>
					</tr>

					<tr>
						<th>자동 로그아웃</th>
						<td>
<?php if($TPL_VAR["autoLogout"]["auto_logout"]=="Y"){?>
<?php if($TPL_VAR["autoLogout"]["until_time"]=="0.01"){?>36초<?php }else{?><?php echo $TPL_VAR["autoLogout"]["until_time"]?>시간<?php }?> 동안 액션이 없으면 자동 로그아웃
<?php }else{?>
							미사용
							<div class="gray">- 본사 관리자 설정에 따름</div>
<?php }?>
						</td>
					</tr>

					<tr>
						<th>
							접속 허용 IP
							<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/manager', '#tip7')"></span>
						</th>
						<td>
<?php if($TPL_VAR["providerInfo"]["manager_yn"]=='Y'){?>
							<label class="resp_radio">
								<label><input type="radio" name="ip_chk" value="Y" <?php if($TPL_VAR["limit_ip"]=="Y"){?>checked<?php }?>> 사용함</label>
								<label><input type="radio"  name="ip_chk" value="N" <?php if($TPL_VAR["limit_ip"]==""||$TPL_VAR["limit_ip"]=="N"){?>checked<?php }?>> 사용 안 함</label>
							</label>
<?php }else{?>
<?php if($TPL_VAR["limit_ip"]){?>
							해당 관리자는 아래의 IP에서만 관리페이지 접속 허용
<?php }else{?>
							관리환경 관리페이지 접속 제한 없음
<?php }?>
<?php }?>
						</td>
					</tr>

					<tr class="ip_view">
						<th>접속 IP 설정</th>
						<td>
<?php if($TPL_VAR["providerInfo"]["manager_yn"]=='Y'){?>
							<table id="ipViewTable" class="table_basic wauto">
								<tr>
									<th>IP</th>
									<th><button type="button" id="ipAdd" class="btn_plus"></button></th>
								</tr>
<?php if(!$TPL_VAR["limit_ip"]){?>
								<tr>
									<td>
										<input type="text" name="limit_ip1[]" value="" class="line limit_ip" size=4 maxlength=3/>.
										<input type="text" name="limit_ip2[]" value="" class="line limit_ip" size=4 maxlength=3/>.
										<input type="text" name="limit_ip3[]" value="" class="line limit_ip" size=4 maxlength=3/>.
										<input type="text" name="limit_ip4[]" value="" class="line limit_ip" size=4 maxlength=3/>
									</td>

									<td>
										<button type="button" id="ipDel"  onclick="del_ip(this)" class="btn_minus"></button>
									</td>
								</tr>
<?php }else{?>
<?php if($TPL_limit_ip_1){foreach($TPL_VAR["limit_ip"] as $TPL_V1){?>
								<tr>
									<td>
										<input type="text" name="limit_ip1[]" value="<?php echo $TPL_V1[ 0]?>" class="line limit_ip" size=4 maxlength=3/>.
										<input type="text" name="limit_ip2[]" value="<?php echo $TPL_V1[ 1]?>" class="line limit_ip" size=4 maxlength=3/>.
										<input type="text" name="limit_ip3[]" value="<?php echo $TPL_V1[ 2]?>" class="line limit_ip" size=4 maxlength=3/>.
										<input type="text" name="limit_ip4[]" value="<?php echo $TPL_V1[ 3]?>" class="line limit_ip" size=4 maxlength=3/>
									</td>

									<td>
										<button type="button" id="ipDel"  onclick="del_ip(this)" class="btn_minus"></button>
									</td>
								</tr>
<?php }}?>
<?php }?>
							</table>
<?php }else{?>

<?php if($TPL_limit_ip_1){foreach($TPL_VAR["limit_ip"] as $TPL_V1){?>
							<?php echo $TPL_V1[ 0]?>.<?php echo $TPL_V1[ 1]?>.<?php echo $TPL_V1[ 2]?><?php if($TPL_V1[ 3]){?>.<?php echo $TPL_V1[ 3]?><?php }else{?>.1 ~ <?php echo $TPL_V1[ 0]?>.<?php echo $TPL_V1[ 1]?>.<?php echo $TPL_V1[ 2]?>.255<?php }?>
							<br>
<?php }}?>

<?php }?>
						</td>
					</tr>

					<tr>
						<th>
							접속 허용 휴대폰
							<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/manager', '#tip8')"></span>
						</th>
						<td >
<?php if(!$TPL_VAR["auth_hp"]){?>
							관리환경 관리페이지 접속 제한 없음
<?php }else{?>
							해당 관리자는 아래의 휴대폰번호로 인증 시 관리페이지 접속 허용<br>
							<?php echo $TPL_VAR["auth_hp"]?>

<?php }?>
							<div class="gray">- 1일 1회 1기기에 한해 인증 필요, 문자 잔여건수가 없을 경우 미동작</div>
						</td>
					</tr>

					<tr class="auth_hp">
						<th>휴대폰 설정</th>
						<td>
<?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'){?>
							<input type="text" name="auth_hp" value="<?php echo $TPL_VAR["auth_hp"]?>" class="line auth_hp"/>
<?php if($TPL_VAR["sms_st"]!='Y'){?>
							<script>$("input[name='hp_chk']").attr('disabled',true);</script>
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["auth_hp"]){?>
							해당 관리자는 아래의 휴대폰번호로 인증 시 관리페이지 접속 허용<br>
							<?php echo $TPL_VAR["auth_hp"]?>

<?php }?>
<?php }?>
							<div class="gray">- 1일 1회 1기기에 한해 인증 필요, 문자 잔여건수가 없을 경우 미 동작</div>
						</td>
					</tr>
				</table>
			</div>

			<div class="contents_dvs">
				<div class="item-title">
					메뉴 상단 건수 표기
					<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/manager', '#tip2')"></span>
				</div>

				<table class="table_basic thl">
					<tr>
						<th>주문</th>
						<td>최근 <?php echo $TPL_VAR["noti_acount_priod"]["order"]?> 동안 처리해야 할 주문 건수 표시</td>
					</tr>

					<tr>
						<th>게시판</th>
						<td>최근 <?php echo $TPL_VAR["noti_acount_priod"]["board"]?> 동안 답변이 미 완료된 상품 문의
						</td>
					</tr>

<?php if($TPL_VAR["is_provider_solution"]){?>
					<tr>
						<th>정산</th>
						<td>최근<?php echo $TPL_VAR["noti_acount_priod"]["account"]?> 동안 정산 건 중 미 완료건</td>
					</tr>
<?php }?>
				</table>

				<div class="title_dvs">
					<div class="item-title">관리자 권한	</div>
<?php if($TPL_VAR["auth_limit"]&&$TPL_VAR["manager_yn"]!='Y'){?>
					<button class="resp_btn" type="button" id="allClick" gb="none"><span id="click_text">전체선택</span></button>
<?php }?>
				</div>

				<table class="table_basic thl">
<?php if($TPL_VAR["auth_limit"]&&$TPL_VAR["manager_yn"]=='Y'){?>
					<tr>
						<th class="red bold">슈퍼 권한</th>
						<td colspan="3">
							슈퍼관리자만이 모든 관리자에 대하여 보기, 삭제, 생성, 변경(권한)이 가능합니다.<br />
							슈퍼관리자 정보는 본인 외 누설을 절대 금지하십시오.
						</td>
					</tr>
<?php }?>

					<tr>
						<th>판매상품</th>
						<td colspan="2">
							<label class="resp_checkbox"><input type="checkbox" name="goods_view" value="Y" class="auth"/> 판매상품 보기</label>
							<label class="resp_checkbox">→ <input type="checkbox" name="goods_act" value="Y" class="auth"/> 판매상품 정보 등록/수정/삭제 (상품데이터 일괄업데이트 포함)</label>
						</td>
					</tr>

					<tr>
						<th>주문</th>
						<td>
							<label class="resp_checkbox"><input type="checkbox" name="order_view" value="Y" class="auth"/>주 문 보기</label>
							<label class="resp_checkbox">→ <input type="checkbox" name="order_goods_export" value="Y" class="auth"/> 출고/배송 처리</label>
						</td>
						<td>
							<label class="resp_checkbox"><input type="checkbox" name="refund_view" value="Y" class="auth"/> 반품/환불보기</label>
							<label class="resp_checkbox">→ <input type="checkbox" name="refund_act" value="Y" class="auth"/> 반품처리</label>
						</td>
					</tr>

					<tr>
						<th>게시판</th>
						<td colspan="2">
							<ul>
								<li>
									<label class="resp_checkbox"><input type="checkbox" name="board_view" value="Y" class="auth" /> 고객상담 통합게시판 보기</label>
									<label class="resp_checkbox"><input type="checkbox" name="board_act" value="Y" class="auth" /> 고객상담 통합게시판 관리</label>
								</li>
							</ul>
						</td>
					</tr>

					<tr>
						<th>프로모션/쿠폰</th>
						<td colspan="2">
							<label class="resp_checkbox"><input type="checkbox" name="coupon_view" value="Y" class="auth"/> 포로모션/쿠폰 보기</label>
						</td>
					</tr>

					<tr>
						<th>통계</th>
						<td colspan="2">
							<label class="resp_checkbox"><input type="checkbox" name="statistic_goods" value="Y" class="auth"/> 상품</label>
						</td>
					</tr>

					<tr>
						<th>정산</th>
						<td colspan="2">
							<label class="resp_checkbox"><input type="checkbox" name="account_view" value="Y" class="auth"/> 정산리스트 보기</label>
						</td>
					</tr>

					<tr>
						<th>배송/택배</th>
						<td colspan="2">
							<label class="resp_checkbox"><input type="checkbox" name="setting_shipping_view" value="Y" class="auth"/> 택배/배송비 보기</label>
							<label class="resp_checkbox">→ <input type="checkbox" name="setting_shipping_act" value="Y" class="auth"/> 택배/배송비 설정 권한</label>
						</td>
					</tr>
				</table>

				<div class="item-title">처리 내역</div>

				<table class="table_basic thl">
					<tr>
						<th>로그</th>
						<td>
							<div style="overflow:auto;height:60px;width:100%;border:1px solid #cccccc;padding: 10px 5px;background:#f7f7f7"><?php echo $TPL_VAR["provider_log"]?></div>
							<textarea name="provider_log" style="display:none;"><?php echo $TPL_VAR["provider_log"]?></textarea>
						</td>
					</tr>
				</table>
			</div>
			<!-- 서브메뉴 바디 : 끝 -->
		</div>
		<!-- 서브 레이아웃 영역 : 끝 -->
	</form>

	<div id="sendPopup" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>