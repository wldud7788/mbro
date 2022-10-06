<?php /* Template_ 2.2.6 2022/05/17 12:36:29 /www/music_brother_firstmall_kr/admin/skin/default/member/nomember_crm_detail.html 000003033 */ ?>
<div class="memberInfoWrap">	
	<div class="memberDetialCloseBtn" onclick='$("#member_info_layer").hide();'><img src="/admin/skin/default/images/common/btn_close_popup2.gif"></div>
	<table width="160" cellspacing="0" cellpadding="0" class="memberInfoTable">
		<colgroup>
			<col style="width:110px" />
			<col style="width:50px" />
		</colgroup>
		<thead>
			<tr>
				<th colspan="2">고객CRM</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th><a href="/admincrm/order/catalog?chk_step%5B15%5D=1&order_seq=<?php echo $_GET["order_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?>>입금대기</a></th>
				<td class="<?php if($TPL_VAR["orderData"]["order"]){?>blueText bold<?php }?>"><?php echo $TPL_VAR["orderData"]["order"]?></td>
			</tr>
			<tr>
				<th><a <?php if($TPL_VAR["auth"]["order_view"]=="Y"){?>href="/admincrm/order/catalog?chk_step%5B25%5D=1&chk_step%5B35%5D=1&chk_step%5B40%5D=1&chk_step%5B45%5D=1&chk_step%5B50%5D=1&chk_step%5B60%5D=1&chk_step%5B70%5D=1&order_seq=<?php echo $_GET["order_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>미처리 출고</a></th>
				<td class="<?php if($TPL_VAR["orderData"]["settle"]){?>blueText bold<?php }?>"><?php echo $TPL_VAR["orderData"]["settle"]?></td>
			</tr>
			<tr>
				<th><a <?php if($TPL_VAR["auth"]["refund_view"]=="Y"){?>href="/admincrm/order/return_catalog?order_seq=<?php echo $_GET["order_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>미처리 반품/교환</a></th>
				<td class="<?php if($TPL_VAR["orderSummary"]['101']["count"]){?>blueText bold<?php }?>"><?php echo $TPL_VAR["orderSummary"]['101']["count"]?></td>
			</tr>
			<tr>
				<th><a <?php if($TPL_VAR["auth"]["refund_view"]=="Y"){?>href="/admincrm/order/refund_catalog?order_seq=<?php echo $_GET["order_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>미처리 환불(취소)</a></th>
				<td class="<?php if($TPL_VAR["orderSummary"]['102']["count"]){?>blueText bold<?php }?>"><?php echo $TPL_VAR["orderSummary"]['102']["count"]?></td>
			</tr>
			<tr>
				<th><a href="/admincrm/board/counsel_catalog?order_seq=<?php echo $_GET["order_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?>>미처리 상담</a></th>
				<td class="<?php if($TPL_VAR["counsel_sum"]){?>blueText bold<?php }?>"><?php echo $TPL_VAR["counsel_sum"]?></td>
			</tr>
		</tbody>
	</table>
	<div class="btn_crm_search pdt5"><button type="button" style="width:100%;" onclick="window.open('/admincrm/board/counsel_catalog?order_seq=<?php echo $_GET["order_seq"]?>');">상담등록<span class="arrow"></span></button></div>
</div>