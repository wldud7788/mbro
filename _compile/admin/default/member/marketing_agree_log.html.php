<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/member/marketing_agree_log.html 000002244 */ 
$TPL_res_1=empty($TPL_VAR["res"])||!is_array($TPL_VAR["res"])?0:count($TPL_VAR["res"]);?>
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="7%" /></col>
		<col width="15%" /></col>
		<col width="20%" /></col>
		<col width="25%" /></col>
		<col width="25%" /></col>
		<col width="8%" /></col>
	</colgroup>
	<tbody>
		<tr>
			<th class="its-td-align center">번호</th>
			<th class="its-td-align center">수신동의 매체</th>
			<th class="its-td-align center">발송일시</th>
			<th class="its-td-align center">보내는 사람</th>
			<th class="its-td-align center">받는 사람</th>
			<th class="its-td-align center">결과</th>
		</tr>
<?php if(count($TPL_VAR["res"])<= 0){?>
		<tr>
			<td colspan="6" class="its-td-align center">발송 내역이 없습니다.</td>
		</tr>
<?php }else{?>
<?php if($TPL_res_1){foreach($TPL_VAR["res"] as $TPL_V1){?>
		<tr>
			<td class="its-td-align center"><?php echo $TPL_V1["no"]?></td>
			<th class="its-td-align center"><?php if($TPL_V1["type"]=='m'){?>Email<?php }elseif($TPL_V1["type"]=='s'){?>SMS<?php }elseif($TPL_V1["type"]=='a'){?>Email/SMS<?php }?></th>
			<td class="its-td-align center"><?php echo $TPL_V1["send_date"]?></td>
			<td class="its-td-align center"><?php echo $TPL_V1["send_addr"]?></td>
			<td class="its-td-align center"><?php echo $TPL_V1["receive_addr"]?></td>
			<td class="its-td-align center"><?php if($TPL_V1["res"]=='s'){?>성공<?php }else{?>실패<?php }?></td>
		</tr>
<?php }}?>
<?php }?>
	</tbody>
</table>
<div style="padding:18px;">
	<ul style="list-style-type : disc;">
		<li style="line-height: 120%;padding-bottom:5px;">정보통신망법 이용 촉진 및 정보보호에 관한 법률 50조 제 8항 및 동법 시행령 제 62조에 따라 수신자의 수신동의를 받아 광고성 정보를 전송하는 자는 수신동의를 받은 날부터 매 2년마다 확인하여야 합니다.</li>
		<li style="line-height: 120%;padding-bottom:5px;">2년마다 최대 3천만원의 과태료가 부과될 수 있습니다.</li>
	</ul>
</div>