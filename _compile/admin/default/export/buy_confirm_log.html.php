<?php /* Template_ 2.2.6 2022/05/17 12:31:45 /www/music_brother_firstmall_kr/admin/skin/default/export/buy_confirm_log.html 000001631 */ 
$TPL_data_log_1=empty($TPL_VAR["data_log"])||!is_array($TPL_VAR["data_log"])?0:count($TPL_VAR["data_log"]);?>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/common.css" />
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layout.css" />
<table class="info-table-style">
<colgroup width="120">
<colgroup width="120">
<colgroup width="100">
<colgroup width="100">
<colgroup width="100">
<tr>
	<th class="its-th-align">일시</th>
	<th class="its-th-align">행위자</th>
	<th class="its-th-align">구매확정수량</th>
	<th class="its-th-align">지급수량</th>
	<th class="its-th-align">소멸수량</th>
</tr>
<?php if($TPL_VAR["data_log"]){?>
<?php if($TPL_data_log_1){foreach($TPL_VAR["data_log"] as $TPL_V1){?>
<tr>
	<td class="its-td-align center"><?php echo substr($TPL_V1["regdate"], 0, 16)?></td>
	<td class="its-td-align center"><?php if($TPL_V1["member_seq"]){?>구매자:<?php }?><?php echo $TPL_V1["doer"]?></td>
	<td class="its-td-align center"><?php echo $TPL_V1["ea"]?>개</td>
	<td class="its-td-align center"><?php if($TPL_V1["emoney_status"]=="pay"){?><?php echo $TPL_V1["ea"]?><?php }else{?>0<?php }?>개</td>
	<td class="its-td-align center"><?php if($TPL_V1["emoney_status"]=="destroy"){?><?php echo $TPL_V1["ea"]?><?php }else{?>0<?php }?>개</td>
</tr>
<?php }}?>
<?php }else{?>
<tr>
	<td class="its-td-align center" colspan="5">처리로그가 없습니다.</td>
</tr>
<?php }?>
</table>
<br />