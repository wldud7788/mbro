<?php /* Template_ 2.2.6 2022/05/17 12:36:28 /www/music_brother_firstmall_kr/admin/skin/default/member/member_crm_detail.html 000009336 */ 
$TPL_snslist_1=empty($TPL_VAR["snslist"])||!is_array($TPL_VAR["snslist"])?0:count($TPL_VAR["snslist"]);?>
<script>
$(function(){
	// sns 계정 정보 확인
	$(".btnsnsdetail").bind("click",function(){
		var snscd	= $(this).attr("snscd");
		var member_seq	= $(this).attr("member_seq");
		var obj		= $("div#snsdetailPopup_"+snscd);
		obj.css("left","20%");
		var disp	= obj.css("display");
		$(".snsdetailPopup").hide();
		if(obj.html() == ''){
			$.get('/admin/member/sns_detail?snscd='+snscd+'&member_seq='+member_seq, function(data) {
				obj.html(data);
			});
		}
		if(disp == "none"){ obj.show(); }

	});
});
</script>
<div class="memberInfoWrap">
	<div class="memberDetialCloseBtn" onclick='$("#member_info_layer").hide();'><img src="/admin/skin/default/images/common/btn_close_popup2.gif"></div>
	<table width="310" cellspacing="0" cellpadding="0" class="memberInfoTable">
		<colgroup>
			<col style="width:60px" />
			<col style="width:*" />
			<col style="width:110px" />
			<col style="width:50px" />
		</colgroup>
		<thead>
			<tr>
				<th colspan="4">고객CRM</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th><a href="/admincrm/main/user_detail?member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?>>악성도</a></th>
				<td class="<?php if($TPL_VAR["blacklist"]){?>blueText bold<?php }?>"><?php if($TPL_VAR["blacklist"]){?><?php echo $TPL_VAR["blacklist"]?><?php }else{?>없음<?php }?></td>
				<th>SNS 정보</th>
				<td class="snsList">
<?php if($TPL_VAR["snslist"]){?>
<?php if($TPL_snslist_1){foreach($TPL_VAR["snslist"] as $TPL_V1){?>
<?php if($TPL_V1["rute"]=='facebook'&&$TPL_V1["sns_f_type"]== 0){?>
						<img src="/admin/skin/default/images/sns/sns_f00.gif" align="absmiddle" class="btnsnsdetail hand" snscd="<?php echo $TPL_V1["rute"]?>" title="<?php echo $TPL_V1["rute_nm"]?> 정보확인" member_seq="<?php echo $TPL_VAR["member_seq"]?>">
<?php }elseif($TPL_V1["rute"]=='twitter'&&$TPL_V1["sns_t_type"]== 0){?>
						<img src="/admin/skin/default/images/sns/sns_t0_gray.gif" align="absmiddle" class="btnsnsdetail hand" snscd="<?php echo $TPL_V1["rute"]?>" title="<?php echo $TPL_V1["rute_nm"]?> 정보확인" member_seq="<?php echo $TPL_VAR["member_seq"]?>">
<?php }else{?>
						<img src="/admin/skin/default/images/sns/sns_<?php echo substr($TPL_V1["rute"], 0, 1)?>0.gif" align="absmiddle" class="btnsnsdetail hand" snscd="<?php echo $TPL_V1["rute"]?>" title="<?php echo $TPL_V1["rute_nm"]?> 정보확인" member_seq="<?php echo $TPL_VAR["member_seq"]?>">
<?php }?>	
						<div id="snsdetailPopup_<?php echo $TPL_V1["rute"]?>" class="snsdetailPopup absolute hide"></div>
<?php }}?>			
<?php }else{?>
					없음
<?php }?>
				</td>
			</tr>
			<tr>
				<th><a href="/admincrm/main/user_detail?member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?>>회원정보</a></th>
				<td></td>
				<th><a <?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'||$TPL_VAR["auth"]["order_view"]=="Y"){?>href="/admincrm/order/catalog?chk_step%5B15%5D=1&member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>입금대기</a></th>
				<td class="<?php if($TPL_VAR["orderData"]["order"]){?>blueText bold<?php }?>"><?php echo $TPL_VAR["orderData"]["order"]?></td>
			</tr>
			<tr>
				<th><a href="/admincrm/member/activity?member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?>>활동정보</a></th>
				<td></td>
				<th><a <?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'||$TPL_VAR["auth"]["order_view"]=="Y"){?>href="/admincrm/order/catalog?chk_step%5B25%5D=1&chk_step%5B35%5D=1&chk_step%5B40%5D=1&chk_step%5B45%5D=1&chk_step%5B50%5D=1&chk_step%5B60%5D=1&chk_step%5B70%5D=1&member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>미처리 출고</a></th>
				<td class="<?php if($TPL_VAR["orderData"]["settle"]){?>blueText bold<?php }?>"><?php echo $TPL_VAR["orderData"]["settle"]?></td>
			</tr>
			<tr>
				<th><a <?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'||$TPL_VAR["auth"]["member_promotion"]=="Y"){?>href="/admincrm/member/emoney_list?member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>캐시</a></th>
				<td class="<?php if($TPL_VAR["emoney"]){?>blueText bold<?php }?>"><?php echo get_currency_price($TPL_VAR["emoney"])?></td>
				<th><a <?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'||$TPL_VAR["auth"]["refund_view"]=="Y"){?>href="/admincrm/order/return_catalog?member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>미처리 반품/교환</a></th>
				<td class="<?php if($TPL_VAR["orderSummary"]['101']["count"]){?>blueText bold<?php }?>"><?php echo $TPL_VAR["orderSummary"]['101']["count"]?></td>
			</tr>
			<tr>
				<th><a <?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'||$TPL_VAR["auth"]["member_promotion"]=="Y"){?>href="/admincrm/member/point_list?member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>포인트</a></th>
				<td class="<?php if($TPL_VAR["point"]){?>blueText bold<?php }?>"><?php echo get_currency_price($TPL_VAR["point"])?></td>
				<th><a <?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'||$TPL_VAR["auth"]["refund_view"]=="Y"){?>href="/admincrm/order/refund_catalog?member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>미처리 환불(취소)</a></th>
				<td class="<?php if($TPL_VAR["orderSummary"]['102']["count"]){?>blueText bold<?php }?> bdbottom"><?php echo $TPL_VAR["orderSummary"]['102']["count"]?></td>
			</tr>
			<tr>
				<th><a <?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'||$TPL_VAR["auth"]["member_promotion"]=="Y"){?>href="/admincrm/member/cash_list?member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>예치금</a></th>
				<td class="<?php if($TPL_VAR["cash"]){?>blueText bold<?php }?>"><?php echo get_currency_price($TPL_VAR["cash"])?></td>
				<th><a <?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'||$TPL_VAR["boardAuth"]["goods_qna"]=="Y"){?>href="/admincrm/board/qna_catalog?member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>미처리 상품문의</a></th>
				<td class="<?php if($TPL_VAR["gdqna_sum"]){?>blueText bold<?php }?>"><?php echo $TPL_VAR["gdqna_sum"]?></td>
			</tr>
			<tr>
				<th><a <?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'||$TPL_VAR["auth"]["coupon_view"]=="Y"){?>href="/admincrm/member/member_coupon_list?member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>쿠폰</a></th>
				<td class="<?php if($TPL_VAR["unusedcount"]){?>blueText bold<?php }?>"><?php echo number_format($TPL_VAR["unusedcount"])?>장</td>
				<th><a <?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'||$TPL_VAR["boardAuth"]["mbqna"]=="Y"){?>href="/admincrm/board/mbqna_catalog?member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>미처리 1:1문의</a></th>
				<td class="<?php if($TPL_VAR["mbqna_sum"]){?>blueText bold<?php }?>"><?php echo $TPL_VAR["mbqna_sum"]?></td>
			</tr>
			<tr>
				<th><a <?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'||$TPL_VAR["auth"]["coupon_view"]=="Y"){?>href="/admincrm/member/member_coupon_list?tab=3&member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?><?php }else{?>href="javascript:alert('권한이 없습니다.');"<?php }?>>코드</a></th>
				<td class="<?php if($TPL_VAR["promotionCount"]){?>blueText bold<?php }?>"><?php echo number_format($TPL_VAR["promotionCount"])?>장</td>
				<th><a href="/admincrm/board/counsel_catalog?member_seq=<?php echo $TPL_VAR["member_seq"]?>" <?php if($_GET["crmPage"]!="y"){?>target="_blank"<?php }?>>미처리 상담</a></th>
				<td class="<?php if($TPL_VAR["counsel_sum"]){?>blueText bold<?php }?>"><?php echo $TPL_VAR["counsel_sum"]?></td>
			</tr>
		</tbody>
	</table>
	<div class="btn_crm_search pdt5"><button type="button" style="width:100%;" onclick="window.open('/admincrm/board/counsel_catalog?member_seq=<?php echo $TPL_VAR["member_seq"]?>');">상담등록<span class="arrow"></span></button></div>	
</div>