<?php /* Template_ 2.2.6 2022/05/17 12:05:27 /www/music_brother_firstmall_kr/admincrm/skin/default/_modules/layout/left.html 000017069 */ 
$TPL_withdrawal_arr_1=empty($TPL_VAR["withdrawal_arr"])||!is_array($TPL_VAR["withdrawal_arr"])?0:count($TPL_VAR["withdrawal_arr"]);?>
<style type="text/css">
	.crmLeftName {border-bottom:1px solid #2c3240; background:#53565f; text-align:center; font-weight:bold; color:#ffffff; line-height:40px;}
	.crmLeftName .group {border-radius:50px; padding:5px; background:#fff;}
	.crmLeftMenu {background:#696b77; color:#fff; padding:10px;}
	.crmLeftMenuTitle {font-size:12px; color:#fff; line-height:20px; position:relative;}
	.crmLeftMenuTitle a {font-size:12px; color:#fff; line-height:20px; position:relative;}
	.crmLeftMenuTitleOn {font-size:12px; font-weight:bold; color:#78e4ff; line-height:20px; position:relative;}
	.crmLeftMenuTitleOn a {font-size:12px; font-weight:bold; color:#78e4ff; line-height:20px; position:relative;}
	.crmLeftMenuIcon {font-size:8px; color:#fff; line-height:20px;}
	.crmLeftMenuIconOn {font-size:8px; line-height:20px; color:#78e4ff;}
	.crmLeftMenuCount {background-color:#5D5E67; text-align:center; width:43px; top:0px; right:0px; position:absolute; font-size:12px; margin-top:0; color:#fff;}
	.crmLeftMenuCount2 {background-color:#5D5E67; text-align:center; width:43px; top:0px; right:47px; position:absolute; font-size:12px; margin-top:0; color:#fff;}
</style>
<table cellpadding="0" cellspacing="0" style="width:100%">
<tr>
	<td class="crmLeftName">
<?php if($TPL_VAR["leftStatus"]=="done"&&$TPL_VAR["leftUserIcon"]){?>
		<span class="group"><?php if($TPL_VAR["leftUserIcon"]){?><img src="../../data/icon/common/<?php echo $TPL_VAR["leftUserIcon"]?>" align="absmiddle"><?php }?></span>
<?php }?>
		<?php echo $TPL_VAR["leftUserName"]?> :
<?php if($_SESSION["member_seq"]){?>
<?php if($TPL_VAR["leftUser_type"]=="business"||$TPL_VAR["leftBusinessSeq"]){?>
			기업
<?php }else{?>
			개인
<?php }?>
<?php if($TPL_VAR["leftStatus_nm"]=="휴면"){?>
			<span class="yellow">(휴면)</span>
<?php }elseif($TPL_VAR["leftStatus"]=="hold"){?>
			<span class="yellow">(미승인)</span>
<?php }?>
<?php }else{?>
			<span class="yellow">비회원</span>
<?php }?>
	</td>
</tr>
<tr>
	<td class="crmLeftMenu" valign="top">
<?php if($_SESSION["member_seq"]){?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr style="cursor:pointer;" onclick="location.href='../main/user_detail?member_seq=<?php echo $_GET["member_seq"]?>';">
				<td width="12" height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/main/user_detail'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/main/user_detail'){?>On<?php }?>">회원정보
<?php if($TPL_VAR["mall_t_check"]=='Y'){?><span style="position:relation;padding:0px 5px 0px 5px;float:right;color:#FFBB00;border:1px solid;">TEST</span><?php }?>
				</td>
			</tr>
			<tr style="cursor:pointer;" onclick="location.href='../member/activity?member_seq=<?php echo $_GET["member_seq"]?>';">
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/member/activity'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/member/activity'){?>On<?php }?>">활동정보</td>
			</tr>
			<tr >
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/order/catalog'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/order/catalog'){?>On<?php }?>"><a href="../order/catalog?member_seq=<?php echo $_GET["member_seq"]?>">주문</a><div id="orderCount" class="crmLeftMenuCount" title="미출고완료 주문건" style="cursor:pointer;" onclick="location.href='../order/catalog?member_seq=<?php echo $_GET["member_seq"]?>&chk_step%5B25%5D=1&chk_step%5B35%5D=1&chk_step%5B40%5D=1&chk_step%5B45%5D=1&chk_step%5B50%5D=1&chk_step%5B60%5D=1&chk_step%5B70%5D=1'"><?php echo $TPL_VAR["leftExportReady"]?></div>
				<div id="exportCount" class="crmLeftMenuCount2" title="입금대기 주문건" style="cursor:pointer;" onclick="location.href='../order/catalog?member_seq=<?php echo $_GET["member_seq"]?>&chk_step%5B15%5D=1';"><?php echo $TPL_VAR["orderSummary"][ 15]["count"]?></div>
				</td>
			</tr>
			<tr>
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/order/return_catalog'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/order/return_catalog'){?>On<?php }?>"><a href="../order/return_catalog?member_seq=<?php echo $_GET["member_seq"]?>">반품/교환내역</a><div id="orderCount" class="crmLeftMenuCount" style="cursor:pointer;" onclick="location.href='../order/return_catalog?member_seq=<?php echo $_GET["member_seq"]?>&return_status%5B%5D=request';" title="미처리 반품/교환건"><?php echo $TPL_VAR["orderSummary"][ 101]["count"]+$TPL_VAR["orderSummary"][ 111]["count"]?></div></td>
			</tr>
			<tr>
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/order/refund_catalog'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/order/refund_catalog'){?>On<?php }?>"><a href="../order/refund_catalog?member_seq=<?php echo $_GET["member_seq"]?>">환불 내역</a><div id="orderCount" class="crmLeftMenuCount" style="cursor:pointer;" onclick="location.href='../order/refund_catalog?member_seq=<?php echo $_GET["member_seq"]?>&refund_status%5B%5D=request';" title="미처리 환불건"><?php echo $TPL_VAR["orderSummary"][ 102]["count"]?></div></td>
			</tr>
			<tr>
				<td height="10" colspan="2"></td>
			</tr>
			<tr>
				<td height="1" bgcolor="#7d7f8b" colspan="2"></td>
			</tr>
			<tr>
				<td height="10" colspan="2"></td>
			</tr>
			<tr style="cursor:pointer;" onclick="location.href='../member/emoney_list?member_seq=<?php echo $_GET["member_seq"]?>';">
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/member/emoney_list'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/member/emoney_list'){?>On<?php }?>">캐시 내역<div class="crmLeftMenuCount" style="width:80px !important; text-align:right; padding-right:10px;"><?php echo get_currency_price($TPL_VAR["userEmoney"])?></div></td>
			</tr>
			<tr style="cursor:pointer;" onclick="location.href='../member/point_list?member_seq=<?php echo $_GET["member_seq"]?>';">
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/member/point_list'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/member/point_list'){?>On<?php }?>">포인트 내역<div class="crmLeftMenuCount" style="width:80px !important; text-align:right; padding-right:10px;"><?php echo get_currency_price($TPL_VAR["userPoint"])?></div></td>
			</tr>
			<tr style="cursor:pointer;" onclick="location.href='../member/cash_list?member_seq=<?php echo $_GET["member_seq"]?>';">
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/member/cash_list'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/member/cash_list'){?>On<?php }?>">예치금<div class="crmLeftMenuCount" style="width:80px !important; text-align:right; padding-right:10px;"><?php echo get_currency_price($TPL_VAR["userCash"])?></div></td>
			</tr>
			<tr style="cursor:pointer;" onclick="location.href='../member/member_coupon_list?member_seq=<?php echo $_GET["member_seq"]?>';">
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/member/member_coupon_list'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/member/member_coupon_list'){?>On<?php }?>">쿠폰/코드<div class="crmLeftMenuCount"><?php echo $TPL_VAR["unusedcount"]?>/<?php echo $TPL_VAR["promotionCount"]?></div></td>
			</tr>
			<tr>
				<td height="10" colspan="2"></td>
			</tr>
			<tr>
				<td height="1" bgcolor="#7d7f8b" colspan="2"></td>
			</tr>
			<tr>
				<td height="10" colspan="2"></td>
			</tr>
			<tr style="cursor:pointer;" onclick="location.href='../board/review_catalog?member_seq=<?php echo $_GET["member_seq"]?>';">
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/board/review_catalog'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/board/review_catalog'){?>On<?php }?>">상품후기<div class="crmLeftMenuCount"><?php echo $TPL_VAR["goodsreviewCount"]?></div></td>
			</tr>
			<tr>
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/board/qna_catalog'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/board/qna_catalog'){?>On<?php }?>"><a href="../board/qna_catalog?member_seq=<?php echo $_GET["member_seq"]?>">상품문의</a><div id="orderCount" class="crmLeftMenuCount" onclick="location.href='../board/qna_catalog?member_seq=<?php echo $_GET["member_seq"]?>&searchreply=y'" style="cursor:pointer;"><?php echo $TPL_VAR["goodsqnaCount"]?></div></td>
			</tr>
			<tr>
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/board/mbqna_catalog'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/board/mbqna_catalog'){?>On<?php }?>"><a href="../board/mbqna_catalog?member_seq=<?php echo $_GET["member_seq"]?>">1:1문의</a><div id="orderCount" class="crmLeftMenuCount" style="cursor:pointer;" onclick="location.href='../board/mbqna_catalog?member_seq=<?php echo $_GET["member_seq"]?>&searchreply=y'"><?php echo $TPL_VAR["mbqnaCount"]?></div></td>
			</tr>
			<tr>
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/board/counsel_catalog'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/board/counsel_catalog'){?>On<?php }?>"><a href = "../board/counsel_catalog?member_seq=<?php echo $_GET["member_seq"]?>">상담</a><div id="orderCount" class="crmLeftMenuCount" style="cursor:pointer;" onclick="location.href='../board/counsel_catalog?member_seq=<?php echo $_GET["member_seq"]?>&counsel_status%5B%5D=request';" title="미처리 상담건"><?php echo $TPL_VAR["counselCount"]?></div></td>
			</tr>
			<tr>
				<td height="10" colspan="2"></td>
			</tr>
			<tr>
				<td height="1" bgcolor="#7d7f8b" colspan="2"></td>
			</tr>
			<tr>
				<td height="10" colspan="2"></td>
			</tr>
			<tr style="cursor:pointer;" onclick="location.href='../member/log_memo?member_seq=<?php echo $_GET["member_seq"]?>';">
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/member/log_memo'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/member/log_memo'){?>On<?php }?>">로그/메모</td>
			</tr>
<?php if($TPL_VAR["leftStatus"]=="done"){?>
			<tr>
				<td colspan="2" class="pdt20"><span class="btn_crm_search"><button type="button" style="width:180px;" onclick="select_sms('<?php echo $_SESSION["member_seq"]?>');">SMS 발송<span class="arrow"></span></button></span></td>
			</tr>
			<tr><td height="5" colspan="2"></td></tr>
			<tr>
				<td colspan="2"><span class="btn_crm_search"><button type="button" style="width:180px;" onclick="select_email('<?php echo $_SESSION["member_seq"]?>');">이메일 발송<span class="arrow"></span></button></span></td>
			</tr>
<?php }?>
			<tr>
				<td colspan="2" class="pdt20"><span class="btn_crm_search"><button type="button" style="width:180px;" onclick="location.href='../member/detail?member_seq=<?php echo $_GET["member_seq"]?>'">회원정보수정<span class="arrow"></span></button></span></td>
			</tr>
			<tr><td height="5" colspan="2"></td></tr>
			<tr>
				<td colspan="2"><span class="btn_crm_search"><button type="button" style="width:180px; color:#fff66a !important;" onclick="with_pop('<?php echo $TPL_VAR["leftStatus"]?>');">회원탈퇴처리<span class="arrow"></span></button></span></td>
			</tr>
		</table>
<?php }else{?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr style="cursor:pointer;" onclick="location.href='../order/catalog?member_seq=<?php echo $_GET["member_seq"]?>&order_seq=<?php echo $_GET["order_seq"]?>';">
				<td width="12" height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/order/catalog'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/order/catalog'){?>On<?php }?>">주문<div id="orderCount" class="crmLeftMenuCount">出<?php echo $TPL_VAR["orderSummary"][ 25]["count"]+$TPL_VAR["orderSummary"][ 35]["count"]+$TPL_VAR["orderSummary"][ 45]["count"]?></div>
				<div id="exportCount" class="crmLeftMenuCount2">확<?php echo $TPL_VAR["orderSummary"][ 15]["count"]?></div>
				</td>
			</tr>
			<tr style="cursor:pointer;" onclick="location.href='../order/return_catalog?member_seq=<?php echo $_GET["member_seq"]?>&order_seq=<?php echo $_GET["order_seq"]?>';">
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/order/return_catalog'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/order/return_catalog'){?>On<?php }?>">반품/교환내역<div id="orderCount" class="crmLeftMenuCount"><?php echo $TPL_VAR["orderSummary"][ 101]["count"]+$TPL_VAR["orderSummary"][ 111]["count"]?></div></td>
			</tr>
			<tr style="cursor:pointer;" onclick="location.href='../order/refund_catalog?member_seq=<?php echo $_GET["member_seq"]?>&order_seq=<?php echo $_GET["order_seq"]?>';">
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/order/refund_catalog'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/order/refund_catalog'){?>On<?php }?>">환불 내역<div id="orderCount" class="crmLeftMenuCount"><?php echo $TPL_VAR["orderSummary"][ 102]["count"]?></div></td>
			</tr>
			<tr>
				<td height="10" colspan="2"></td>
			</tr>
			<tr>
				<td height="1" bgcolor="#7d7f8b" colspan="2"></td>
			</tr>
			<tr>
				<td height="10" colspan="2"></td>
			</tr>
			<tr style="cursor:pointer;" onclick="location.href='../board/counsel_catalog?member_seq=<?php echo $_GET["member_seq"]?>&order_seq=<?php echo $_GET["order_seq"]?>';">
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/board/counsel_catalog'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/board/counsel_catalog'){?>On<?php }?>">상담 <div id="orderCount" class="crmLeftMenuCount" title="미처리 상담건"><?php echo $TPL_VAR["counselCount"]?></div></td>
			</tr>
			<tr>
				<td height="10" colspan="2"></td>
			</tr>
			<tr>
				<td height="1" bgcolor="#7d7f8b" colspan="2"></td>
			</tr>
			<tr>
				<td height="10" colspan="2"></td>
			</tr>
			<tr style="cursor:pointer;" onclick="location.href='../member/log_memo?member_seq=<?php echo $_GET["member_seq"]?>&order_seq=<?php echo $_GET["order_seq"]?>';">
				<td height="25"><span class="crmLeftMenuIcon<?php if(uri_string()=='admincrm/member/log_memo'){?>On<?php }?>">ㆍ</span></td>
				<td class="crmLeftMenuTitle<?php if(uri_string()=='admincrm/member/log_memo'){?>On<?php }?>">로그/메모</td>
			</tr>
		</table>
<?php }?>
	</td>
</tr>
</table>

<script>
function with_pop(status){
	if (status == 'withdrawal') {
		alert('이미 탈퇴 처리한 회원입니다.');
	} else {
		openDialog("회원 탈퇴", "withdrawalPopup", {"width":"500","height":"300"});
	}
}
</script>
<div id="withdrawalPopup" class="hide">
	<form name="withdrawalForm" id="withdrawalForm" method="post" target="actionFrame" action="../member_process/member_withdrawal">
	<input type="hidden" name="member_seq" value="<?php echo $_SESSION["member_seq"]?>"/>
	<table class="info-table-style" style="width:100%">
		<tbody>
			<tr>
				<th class="its-th-align center" width="80">탈퇴사유</th>
				<td class="its-td">
<?php if($TPL_withdrawal_arr_1){$TPL_I1=-1;foreach($TPL_VAR["withdrawal_arr"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1% 3== 0&&$TPL_I1!= 0){?><br><?php }?>
						<label><input type="radio" name="reason" value="<?php echo $TPL_V1?>"/><?php echo $TPL_V1?></label>&nbsp;&nbsp;
<?php }}?>
				</td>
			</tr>
			<tr>
				<th class="its-th-align center">내용</th>
				<td class="its-td">
					<input type="text" name="memo" class="line" size="40">
				</td>
			</tr>
			<tr>
				<td class="its-td-align center" colspan="2">
					<div>회원 탈퇴 시 회원의 모든 정보가 바로 삭제되어집니다!</div>
					<div>정말로 회원(<?php if($TPL_VAR["leftUserId"]==$TPL_VAR["leftSnsN"]){?><?php echo $TPL_VAR["leftConvSnsN"]?><?php }else{?><?php echo $TPL_VAR["leftUserId"]?><?php }?>)을 탈퇴시키시겠습니까?</div>
				</td>
			</tr>
		</tbody>
	</table>
	<div style="width:100%;text-align:center;padding-top:10px;">
		<span class="btn large cyanblue"><button type="submit" id="send_submit">확인</button></span>
	</div>
	</form>
</div>