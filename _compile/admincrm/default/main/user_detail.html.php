<?php /* Template_ 2.2.6 2022/05/17 12:05:23 /www/music_brother_firstmall_kr/admincrm/skin/default/main/user_detail.html 000012992 */ 
$TPL_snslist_1=empty($TPL_VAR["snslist"])||!is_array($TPL_VAR["snslist"])?0:count($TPL_VAR["snslist"]);
$TPL_orderReady_1=empty($TPL_VAR["orderReady"])||!is_array($TPL_VAR["orderReady"])?0:count($TPL_VAR["orderReady"]);
$TPL_exportReady_1=empty($TPL_VAR["exportReady"])||!is_array($TPL_VAR["exportReady"])?0:count($TPL_VAR["exportReady"]);
$TPL_returnReady_1=empty($TPL_VAR["returnReady"])||!is_array($TPL_VAR["returnReady"])?0:count($TPL_VAR["returnReady"]);
$TPL_refundReady_1=empty($TPL_VAR["refundReady"])||!is_array($TPL_VAR["refundReady"])?0:count($TPL_VAR["refundReady"]);
$TPL_gdqnaReady_1=empty($TPL_VAR["gdqnaReady"])||!is_array($TPL_VAR["gdqnaReady"])?0:count($TPL_VAR["gdqnaReady"]);
$TPL_mbqnaReady_1=empty($TPL_VAR["mbqnaReady"])||!is_array($TPL_VAR["mbqnaReady"])?0:count($TPL_VAR["mbqnaReady"]);
$TPL_counselReady_1=empty($TPL_VAR["counselReady"])||!is_array($TPL_VAR["counselReady"])?0:count($TPL_VAR["counselReady"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script style="text/javascript">
	$(document).ready(function() {
		// sns 계정 정보 확인
		$(".btnsnsdetail").bind("click",function(){
			var snscd	= $(this).attr("snscd");
			var obj		= $("div#snsdetailPopup_"+snscd);
			var disp	= obj.css("display");
			$(".snsdetailPopup").hide();
			if(obj.html() == ''){
				$.get('/admin/member/sns_detail?snscd='+snscd+'&member_seq=<?php echo $TPL_VAR["member_seq"]?>', function(data) {
					obj.html(data);
				});
			}
			if(disp == "none"){ obj.show(); }

		});
	});

	function open_reason(member_seq) {
		if(member_seq == '') return;
		$.get('/admin/member/withdrawal_pop?member_seq='+member_seq, function(data) {
			$('#viewMemo').html(data);
			openDialog("탈퇴 회원 상세 사유", "viewMemo", {"width":"600","height":"320"});
		});
	}
</script>
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="13%" />
		<col width="20%" />
		<col width="13%" />
		<col width="20%" />
		<col width="13%" />
		<col width="21%" />
	</colgroup>
	<thead>
		<tr>
			<th scope="col" colspan="6">고객 정보</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th class="its-th">가입경로</th>
			<td class="its-td"><?php echo $TPL_VAR["referer_name"]?>

<?php if($TPL_VAR["referer_domain"]){?>
				(<?php if($TPL_VAR["referer"]){?><a href="<?php echo $TPL_VAR["referer"]?>" target="_blank"><u style="color:#0263d9;"><?php }?><?php echo $TPL_VAR["referer_domain"]?><?php if($TPL_VAR["referer"]){?></u></a><?php }?>)
<?php }?> &nbsp;<span class="btn small gray"><button type="button" onclick="window.open('/admin/statistic_member/member_referer');">더보기</button></span></td>
			<th class="its-th">가입환경</th>
			<td class="its-td" colspan="3">
				<?php echo $TPL_VAR["platformText"]?>

<?php if($TPL_VAR["checkO2OService"]){?>
				<span style='font-weight: bold;'>(바코드 번호 : <?php echo $TPL_VAR["barcode_key"]?>)</span>
<?php }?>
			</td>
		</tr>
		<tr>
			<th class="its-th">가입</th>
			<td class="its-td">
				<?php echo $TPL_VAR["regist_date"]?>

			</td>
			<th class="its-th">상태</th>
			<td class="its-td">
<?php if($TPL_VAR["status"]=='withdrawal'){?>
				<a onclick="open_reason('<?php echo $TPL_VAR["member_seq"]?>')" class="blue hand"><?php echo $TPL_VAR["status_nm"]?></a>
<?php }else{?>
				<?php echo $TPL_VAR["status_nm"]?>

<?php }?>
			</td>
			<th class="its-th">등급</th>
			<td class="its-td">
<?php if($TPL_VAR["leftStatus"]=="done"&&$TPL_VAR["icon"]){?><img src="../../data/icon/common/<?php echo $TPL_VAR["icon"]?>" align="absmiddle"><?php }?> <?php echo $TPL_VAR["group_name"]?>

			</td>
		</tr>
		<tr>
			<th class="its-th">아이디</th>
			<td class="its-td">
<?php if($TPL_VAR["userid"]==$TPL_VAR["sns_n"]){?><?php echo $TPL_VAR["conv_sns_n"]?><?php }else{?><?php echo $TPL_VAR["userid"]?><?php }?>
			</td>
			<th class="its-th">사용계정</th>
			<td class="its-td">
<?php if($TPL_snslist_1){foreach($TPL_VAR["snslist"] as $TPL_V1){?>
					<img src="/admincrm/skin/default/images/sns/sns_<?php echo substr($TPL_V1["rute"], 0, 1)?>0.gif" align="absmiddle" class="btnsnsdetail hand" snscd="<?php echo $TPL_V1["rute"]?>" title="<?php echo $TPL_V1["rute_nm"]?> 정보확인">
					<div id="snsdetailPopup_<?php echo $TPL_V1["rute"]?>" class="snsdetailPopup absolute hide"></div>
<?php }}?>
			</td>
			<th class="its-th">유형</th>
			<td class="its-td">
<?php if($TPL_VAR["business_seq"]){?>기업<?php }else{?>개인<?php }?>
			</td>
		</tr>
<?php if($TPL_VAR["business_seq"]){?>
		<tr>
			<th class="its-th">업체명</th>
			<td class="its-td">
				<?php echo $TPL_VAR["bname"]?>

			</td>
			<th class="its-th">대표자</th>
			<td class="its-td">
				<?php echo $TPL_VAR["bceo"]?>

			</td>
			<th class="its-th">등록번호</th>
			<td class="its-td">
				<?php echo $TPL_VAR["bno"]?>

			</td>
		</tr>
		<tr>
			<th class="its-th">업태</th>
			<td class="its-td">
				<?php echo $TPL_VAR["bitem"]?>

			</td>
			<th class="its-th">종목</th>
			<td class="its-td">
				<?php echo $TPL_VAR["bstatus"]?>

			</td>
			<th class="its-th">담당자</th>
			<td class="its-td">
				<?php echo $TPL_VAR["bperson"]?>

			</td>
		</tr>
		<tr>
			<th class="its-th">전화</th>
			<td class="its-td">
				<?php echo $TPL_VAR["bphone"]?>

			</td>
			<th class="its-th">휴대폰</th>
			<td class="its-td">
				<span class="blue hand" onclick="select_sms('<?php echo $TPL_VAR["member_seq"]?>');"><?php echo $TPL_VAR["bcellphone"]?></span>
			</td>
			<th class="its-th">이메일</th>
			<td class="its-td">
				<span class="blue hand" onclick="select_email('<?php echo $TPL_VAR["member_seq"]?>');"><?php echo $TPL_VAR["email"]?></span>
			</td>
		</tr>
<?php }else{?>
		<tr>
			<th class="its-th">이름</th>
			<td class="its-td">
				<?php echo $TPL_VAR["user_name"]?>

			</td>
			<th class="its-th">실명확인</th>
			<td class="its-td">
				<?php echo $TPL_VAR["auth_type"]?> <br />
				<?php echo $TPL_VAR["auth_date"]?>

			</td>
			<th class="its-th">닉네임</th>
			<td class="its-td">
				<?php echo $TPL_VAR["nickname"]?>

			</td>
		</tr>
		<tr>
			<th class="its-th">전화</th>
			<td class="its-td">
				<?php echo $TPL_VAR["phone"]?>

			</td>
			<th class="its-th">휴대폰</th>
			<td class="its-td">
				<span class="blue hand" onclick="select_sms('<?php echo $TPL_VAR["member_seq"]?>');"><?php echo $TPL_VAR["cellphone"]?></span>
			</td>
			<th class="its-th">이메일</th>
			<td class="its-td">
				<span class="blue hand" onclick="select_email('<?php echo $TPL_VAR["member_seq"]?>');"><?php echo $TPL_VAR["email"]?></span>
			</td>
		</tr>
		<tr>
			<th class="its-th">성별</th>
			<td class="its-td">
<?php if($TPL_VAR["sex"]=='male'){?>남자<?php }elseif($TPL_VAR["sex"]=='female'){?>여자<?php }?>
			</td>
			<th class="its-th">생일</th>
			<td class="its-td">
<?php if($TPL_VAR["birthday"]&&$TPL_VAR["birthday"]!="0000-00-00"){?><?php echo $TPL_VAR["birthday"]?> (<?php echo date("Y")-substr($TPL_VAR["birthday"], 0, 4)+ 1?>세)<?php }?>
			</td>
			<th class="its-th">기념일</th>
			<td class="its-td">
				<?php echo $TPL_VAR["anniversary"]?>

			</td>
		</tr>
<?php }?>
		<tr>
			<th class="its-th">주소</th>
			<td class="its-td" colspan="5"><?php if($TPL_VAR["zipcode"]){?>(<?php echo $TPL_VAR["zipcode"]?>)<?php }?> <?php if($TPL_VAR["address_street"]){?><?php echo $TPL_VAR["address_street"]?><?php }else{?><?php echo $TPL_VAR["address"]?><?php }?> <?php echo $TPL_VAR["address_detail"]?></td>
		</tr>
		<tr>
			<th class="its-th">사용배송지</th>
			<td class="its-td" colspan="5"><?php if($TPL_VAR["oftenDelivery"]["recipient_zipcode"]){?>(<?php echo $TPL_VAR["oftenDelivery"]["recipient_zipcode"]?>)<?php }?> <?php if($TPL_VAR["oftenDelivery"]["recipient_address_street"]){?><?php echo $TPL_VAR["oftenDelivery"]["recipient_address_street"]?><?php }else{?><?php echo $TPL_VAR["oftenDelivery"]["recipient_address"]?><?php }?> <?php echo $TPL_VAR["oftenDelivery"]["recipient_address_detail"]?></td>
		</tr>
	</tbody>
</table>
<div style="height:20px;"></div>
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="18%" />
		<col width="8%" />
		<col />
	</colgroup>
	<thead>
		<tr>
			<th scope="col" colspan="3">고객 데이터(최근 30일 기준 : <?php echo date('Y-m-d',strtotime('-30 day'))?> ~ <?php echo date('Y-m-d')?>)</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="its-td">입금대기</td>
			<td class="its-td-align center"><?php echo count($TPL_VAR["orderReady"])?>건</td>
			<td class="its-td">
<?php if($TPL_orderReady_1){$TPL_I1=-1;foreach($TPL_VAR["orderReady"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1> 0){?>, <?php }?>
					<a href="/admin/order/view?no=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["order_seq"]?></span></a>
<?php }}?>
			</td>
		</tr>
		<tr>
			<td class="its-td">미처리 출고</td>
			<td class="its-td-align center"><?php echo count($TPL_VAR["exportReady"])?>건</td>
			<td class="its-td">
<?php if($TPL_exportReady_1){$TPL_I1=-1;foreach($TPL_VAR["exportReady"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1> 0){?>, <?php }?>
					<a href="/admin/order/view?no=<?php echo $TPL_V1["order_seq"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["order_seq"]?></span></a>
<?php }}?>
			</td>
		</tr>
		<tr>
			<td class="its-td">미처리 반품/교환</td>
			<td class="its-td-align center"><?php echo count($TPL_VAR["returnReady"])?>건</td>
			<td class="its-td">
<?php if($TPL_returnReady_1){$TPL_I1=-1;foreach($TPL_VAR["returnReady"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1> 0){?>, <?php }?>
					<a href="/admin/returns/view?no=<?php echo $TPL_V1["return_code"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["return_code"]?></span></a>
<?php }}?>
			</td>
		</tr>
		<tr>
			<td class="its-td">미처리 환불(취소)</td>
			<td class="its-td-align center"><?php echo count($TPL_VAR["refundReady"])?>건</td>
			<td class="its-td">
<?php if($TPL_refundReady_1){$TPL_I1=-1;foreach($TPL_VAR["refundReady"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1> 0){?>, <?php }?>
					<a href="/admin/refund/view?no=<?php echo $TPL_V1["refund_code"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["refund_code"]?></span></a>
<?php }}?>
			</td>
		</tr>
		<tr>
			<td class="its-td">미처리 상품문의</td>
			<td class="its-td-align center"><?php echo count($TPL_VAR["gdqnaReady"])?>건</td>
			<td class="its-td">
<?php if($TPL_gdqnaReady_1){$TPL_I1=-1;foreach($TPL_VAR["gdqnaReady"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1> 0){?>, <?php }?>
					<a href="/admin/board/board?id=goods_qna&seq=<?php echo $TPL_V1["seq"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["seq"]?></span></a>
<?php }}?>
			</td>
		</tr>
		<tr>
			<td class="its-td">미처리 1:1문의</td>
			<td class="its-td-align center"><?php echo count($TPL_VAR["mbqnaReady"])?>건</td>
			<td class="its-td">
<?php if($TPL_mbqnaReady_1){$TPL_I1=-1;foreach($TPL_VAR["mbqnaReady"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1> 0){?>, <?php }?>
					<a href="/admin/board/board?id=mbqna&seq=<?php echo $TPL_V1["seq"]?>" target="_blank"><span class="blue"><?php echo $TPL_V1["seq"]?></span></a>
<?php }}?>
			</td>
		</tr>
		<tr>
			<td class="its-td">미처리 상담문의</td>
			<td class="its-td-align center"><?php echo count($TPL_VAR["counselReady"])?>건</td>
			<td class="its-td">
<?php if($TPL_counselReady_1){$TPL_I1=-1;foreach($TPL_VAR["counselReady"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1> 0){?>, <?php }?>
					<a href="/admincrm/board/counsel_catalog?counsel_seq=<?php echo $TPL_V1["counsel_seq"]?>"><span class="blue"><?php echo $TPL_V1["counsel_seq"]?></span></a>
<?php }}?>
			</td>
		</tr>
	</tbody>
</table>

<!-- 통합 로그인 정보 2021.05.17.11:28(이지영) -->
<div style="height:20px;"></div>
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="18%" />
		<col width="8%" />
		<col />
	</colgroup>
	<thead>
		<tr>
			<th scope="col" colspan="3">고객 데이터(최근 30일 기준 : <?php echo date('Y-m-d',strtotime('-30 day'))?> ~ <?php echo date('Y-m-d')?>)</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="its-td">성함</td>
			<td class="its-td-align left" colspan="2" style=" padding-left: 15px;"><?php echo $TPL_VAR["login"]["name"]?></td>
<!-- 			<td class="its-td"></td> -->
		</tr>
		<tr>
			<td class="its-td">이메일</td>
			<td class="its-td-align left" colspan="2" style=" padding-left: 15px;"><?php echo $TPL_VAR["login"]["email"]?></td>
			<!-- <td class="its-td"></td> -->
		</tr>
		<tr>
			<td class="its-td">인증 날짜</td>
			<td class="its-td-align center"><?php echo $TPL_VAR["login"]["sign"]?></td>
			<td class="its-td"><?php echo $TPL_VAR["login"]["time"]?></td>
		</tr>
	</tbody>
</table>
<div id="viewMemo" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>