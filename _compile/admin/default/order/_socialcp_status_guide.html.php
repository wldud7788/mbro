<?php /* Template_ 2.2.6 2022/05/17 12:36:42 /www/music_brother_firstmall_kr/admin/skin/default/order/_socialcp_status_guide.html 000000990 */ 
$TPL_socialcp_status_loop_1=empty($TPL_VAR["socialcp_status_loop"])||!is_array($TPL_VAR["socialcp_status_loop"])?0:count($TPL_VAR["socialcp_status_loop"]);?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" > 
<tr>
<td valign="top" >
	<table class="info-table-style" width="100%" border="0" cellpadding="0" cellspacing="0" > 
	<tr >
		<th class="its-th-align center">티켓 상품의 상태 안내</th>  
	</tr> 
<?php if($TPL_socialcp_status_loop_1){foreach($TPL_VAR["socialcp_status_loop"] as $TPL_V1){?> 
	<tr class="socialcp_status_<?php echo $TPL_V1["key"]?> socialcp_status_tr"  height="10">
		<td class="its-td left">
			<span class="red"><?php echo $TPL_V1["number"]?> <?php echo $TPL_V1["title"]?></span> 
			<br/><?php echo $TPL_V1["desc"]?>

		</td>
	</tr>
<?php }}?> 
	</table>
</td> 
</tr>
</table>