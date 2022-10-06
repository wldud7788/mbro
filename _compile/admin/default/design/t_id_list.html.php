<?php /* Template_ 2.2.6 2022/05/17 12:31:39 /www/music_brother_firstmall_kr/admin/skin/default/design/t_id_list.html 000004441 */  $this->include_("defaultScriptFunc");
$TPL_mall_i_test_1=empty($TPL_VAR["mall_i_test"])||!is_array($TPL_VAR["mall_i_test"])?0:count($TPL_VAR["mall_i_test"]);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $TPL_VAR["config_basic"]["shopName"]?> - 아이디자인 테스트 로그인</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layout.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/buttons.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/boardnew.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/page.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/jqueryui/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/jqueryui/black-tie/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/poshytip/style.css" />
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/editor/css/goods_image_popup.css" />
<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/jquploadify/uploadify.css" />
<script type="text/javascript" src="/app/javascript/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.poshytip.min.js"></script>
<script type="text/javascript" src="/app/javascript/js/dev-tools.js"></script>
<?php echo defaultScriptFunc()?></head>
<body>
<div class="pd20">
	<h4 style="color:#00006F;">로그인 후의 화면을 디자인할 때 사용하는 회원 계정을 아래에서 선택하세요.</h4><br/>
	<table width="100%" class="info-table-style">
		<colgroup>
			<col width="20%"><col width="20%"><col width="20%"><col width="20%"><col width="20%">
		</colgroup>
		<thead>
			<tr>
				<th class="its-th-align">승인</th>
				<th class="its-th-align">등급</th>
				<th class="its-th-align">유형</th>
				<th class="its-th-align">이름</th>
				<th class="its-th-align">선택</th>
			</tr>
		</thead>
		<tbody class="dlts-body">
<?php if($TPL_VAR["mall_i_test"]){?>
<?php if($TPL_mall_i_test_1){foreach($TPL_VAR["mall_i_test"] as $TPL_V1){?>
			<tr>
				<td class="its-td-align center"><?php echo $TPL_V1["status_nm"]?></td>
				<td class="its-td-align center"><?php echo $TPL_V1["group_name"]?></td>
				<td class="its-td-align center"><?php echo $TPL_V1["type"]?></td>
				<td class="its-td-align center"><?php echo $TPL_V1["user_name"]?></td>
<?php if($TPL_V1["status_nm"]=="승인"){?>
				<td class="its-td-align center">
					<span onclick="t_id_login('<?php echo $TPL_V1["member_seq"]?>');" style="cursor:pointer;color:#045EE9;">로그인&nbsp;></span>
				</td>
<?php }else{?>
				<td class="its-td-align center">
					<span style="cursor:default;color:#E7E7E7;">로그인&nbsp;></span>
				</td>
<?php }?>
			</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td colspan=5>
					<span>설정된 테스트 계정이 없습니다.</span>
					<span style="margin-left:20px;color:#045EE9;cursor:pointer;" onclick="open_mem_list();">설정하기></span>
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>

	<script>
		function t_id_login(t_m_no) {
			$.ajax({
				type: "post",
				url: "/login_process/login",
				data: "log_code=eyedesign_t_id&t_mem_no="+t_m_no,
				success: function(result){
					if( result == 'success') {
						alert('로그인 화면이 되었습니다.');
						parent.location.href = '/';
					}
				}
			});
		}
		function open_mem_list() {
			window.open('/admin/member/catalog','_blank');
		}
	</script>
</div>
</body>
</html>