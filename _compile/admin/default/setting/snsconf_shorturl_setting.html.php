<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/setting/snsconf_shorturl_setting.html 000005875 */ ?>
<script type="text/javascript">
	var shorturl_app_id		= '<?php echo $TPL_VAR["sns"]["shorturl_app_id"]?>';
	var shorturl_app_key	= '<?php echo $TPL_VAR["sns"]["shorturl_app_key"]?>';
	var shorturl_app_token	= '<?php echo $TPL_VAR["sns"]["shorturl_app_token"]?>';
	var shorturl_v3 = false;

	/* Bitly 버전 확인 */
	if(shorturl_app_key && shorturl_app_id){
		shorturl_v3 = true;
	}

	$(document).ready(function() {
		/* 짧은 URL 가이드 이벤트 */
		$("#shorturl_guide").on("click",function(){
			window.open("https://www.firstmall.kr/customer/faq/1194");
		});
		var shorturl_keyType	= '<?php echo $TPL_VAR["sns"]["shorturl_keyType"]?>';
		init_keyType(shorturl_keyType);
	});

	/* 구분 초기화 */ 
	function init_keyType(keyType){
		if(keyType){
			if(keyType!='token'){
				$(".tr_token").attr("class","tr_token hide");
			}else{
				$(".tr_key").attr("class","tr_key hide");
			}
		}else if(shorturl_app_id && shorturl_app_key){
			$(".tr_token").attr("class","tr_token hide");
		}else{
			$(".tr_key").attr("class","tr_key hide");
		}
	}

	/* 구분 선택 이벤트 */ 
	function check_keyType(e){
		var shorturl_keyType = e.value;
		if(shorturl_keyType == 'token'){
			$(".tr_"+shorturl_keyType).attr("class","tr_"+shorturl_keyType);
			$(".tr_key").attr("class","tr_key hide");
		}else{
			$(".tr_"+shorturl_keyType).attr("class","tr_"+shorturl_keyType);
			$(".tr_token").attr("class","tr_token hide");
		}
	}

	/* 짧은 URL 설정 저장 */ 
	function save_shorturl(){
		var save_keyType = save_keyType = $(":radio[name='shorturl_keyType']:checked").val();

		if(save_keyType=='key'){
			if( !$("#shorturl_app_id").val() ){
				alert('LOGIN 설정값을 정확히 입력해 주세요.');
				return false;
			}
			if( !$("#shorturl_app_key").val() ){
				alert('API Key 설정값을 정확히 입력해 주세요.');
				return false;
			}
		}else if(save_keyType=='token'){
			if( !$("#shorturl_app_token").val() ){
				alert('ACCESS TOKEN 설정값을 정확히 입력해 주세요.');
				return false;
			}
		}
		var data = $("#snsShortUrlRegist").serialize();

		$.ajax({
			'url' : '../setting_process/snsconf_shorturl',
			'type' : 'post',
			'data': data,
			'dataType': 'json',
			'success': function(res) {
				if(res.result){
					openDialogAlert("설정되었습니다.",'300','140');
					$("#shorturl_help_lay").dialog('close');
				}else{
					openDialogAlert("오류 : 설정 값을 정확히 입력해 주세요.",'300','140');
				}
			},'error': function(e){ 
				openDialogAlert("오류 : 설정 값을 정확히 입력해 주세요.",'300','140');
			}
		});
	}
</script>

<div id="shorturl_help_lay" class="hide">
	<form name="snsShortUrlRegist" id="snsShortUrlRegist" method="post" action="" target="actionFrame">
		<input type="hidden" name="pagemode" id="pagemode" value="member">
		<input type="hidden" name="shorturl_use2" value="Y">
		<div style="clear:both;height:28px;">
			<button type="button" id="shorturl_guide" class="resp_btn fr mb10">bit.ly 키 발급 안내</button>
		</div>
		<table class="joinform-user-table table_basic thl">
			<col width="90px" /><col width="" />
			<tbody>
<?php if($TPL_VAR["sns"]["shorturl_app_key"]&&$TPL_VAR["sns"]["shorturl_app_id"]){?>
				<tr>
					<th class="its-th">구분</th>
					<td class="its-td">
						<label class="mr15">
							<input type="radio" name="shorturl_keyType"  id="key"  value="key" <?php if($TPL_VAR["sns"]["shorturl_keyType"]=='key'||$TPL_VAR["sns"]["shorturl_keyType"]==''){?> checked <?php }else{?>  <?php }?> onclick="check_keyType(this)"/> API KEY
						</label>
						<label class="mr15">
							<input type="radio" name="shorturl_keyType"  id="token"  value="token" <?php if($TPL_VAR["sns"]["shorturl_keyType"]=='token'){?> checked <?php }else{?>  <?php }?> onclick="check_keyType(this)"/> ACCESS TOKEN
						</label>
					</td>
				</tr>
				<tr class="tr_key">
					<th class="its-th">LOGIN</th>
					<td class="its-td"><input type='text'  name="shorturl_app_id"  id="shorturl_app_id" value="<?php if($TPL_VAR["sns"]["shorturl_app_id"]){?><?php echo $TPL_VAR["sns"]["shorturl_app_id"]?><?php }else{?><?php }?>" style="width:95%;"></td>
				</tr>
				<tr class="tr_key">
					<th class="its-th">API Key</th>
					<td class="its-td">
						<input type='text'  name="shorturl_app_key"  id="shorturl_app_key" value="<?php if($TPL_VAR["sns"]["shorturl_app_key"]){?><?php echo $TPL_VAR["sns"]["shorturl_app_key"]?><?php }else{?><?php }?>" style="width:95%;">
					</td>
				</tr>
<?php }else{?>
				<input type="hidden" name="shorturl_keyType" value="token"/>
<?php }?>
				<tr class="tr_token">
					<th class="its-th">ACCESS TOKEN</th>
					<td class="its-td">
						<input type='text'  name="shorturl_app_token"  id="shorturl_app_token" value="<?php if($TPL_VAR["sns"]["shorturl_app_token"]){?><?php echo $TPL_VAR["sns"]["shorturl_app_token"]?><?php }else{?><?php }?>" style="width:95%;">
					</td>
				</tr>
			</tbody>
		</table>
<?php if($TPL_VAR["sns"]["shorturl_app_key"]&&$TPL_VAR["sns"]["shorturl_app_id"]){?>
		<ul class="bullet_hyphen resp_message">
			<li>API KEY 연동은 신규 발급이 불가합니다.</li>
			<li>API KEY 연동 방식은 2020년 3월 서비스가 종료될 예정이오니, ACCESS TOKEN 연동 방식으로 변경하길 권장 드립니다.</li>
		</ul>
<?php }?>
		<div class="footer">
			<button type="button" id="shorturl" class="resp_btn active size_XL" onclick="save_shorturl()">저장</button>
			<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this)">닫기</button>
		</div>
	</form>
</div>