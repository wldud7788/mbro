<?php /* Template_ 2.2.6 2022/05/17 12:37:00 /www/music_brother_firstmall_kr/admin/skin/default/setting/pgInfo.html 000013795 */ 
$TPL_CardCompanyCode_1=empty($TPL_VAR["CardCompanyCode"])||!is_array($TPL_VAR["CardCompanyCode"])?0:count($TPL_VAR["CardCompanyCode"]);
$TPL_pcCardCompanyCode_1=empty($TPL_VAR["pcCardCompanyCode"])||!is_array($TPL_VAR["pcCardCompanyCode"])?0:count($TPL_VAR["pcCardCompanyCode"]);
$TPL_mobileCardCompanyCode_1=empty($TPL_VAR["mobileCardCompanyCode"])||!is_array($TPL_VAR["mobileCardCompanyCode"])?0:count($TPL_VAR["mobileCardCompanyCode"]);?>
<table width="100%" cellpadding="0" cellspacing="0" class="table_basic v3" >
	

<?php if($TPL_VAR["pgCompany"]==='paypal'){?>
	<tr>
		<th width="160px">
			 결제 통화
<?php if($TPL_VAR["pgCompany"]==='lg'||$TPL_VAR["pgCompany"]==='inicis'||$TPL_VAR["pgCompany"]==='allat'||$TPL_VAR["pgCompany"]==='kcp'||$TPL_VAR["pgCompany"]==='kspay'||$TPL_VAR["pgCompany"]==='kicc'||$TPL_VAR["pgCompany"]==='naverpay'||$TPL_VAR["pgCompany"]==='kakaopay'){?>
			KRW
<?php }elseif($TPL_VAR["pgCompany"]==='paypal'){?>
			<?php echo $TPL_VAR["paypal_currency"]?>

<?php }elseif($TPL_VAR["pgCompany"]==='eximbay'){?>
			<?php echo $TPL_VAR["eximBayCur"]?>

<?php }?>
		</th>
		<th>PC / 모바일</th>		
	</tr>
	<tr>
		<th>결제방법</th>
		<td>신용카드, 예치금, 은행계좌, 전자수표(e-check)</td>
	</tr>
<?php }elseif($TPL_VAR["pgCompany"]==='eximbay'){?>
	<tr>
		<th width="160px">
			 결제 통화
<?php if($TPL_VAR["pgCompany"]==='lg'||$TPL_VAR["pgCompany"]==='inicis'||$TPL_VAR["pgCompany"]==='allat'||$TPL_VAR["pgCompany"]==='kcp'||$TPL_VAR["pgCompany"]==='kspay'||$TPL_VAR["pgCompany"]==='kicc'||$TPL_VAR["pgCompany"]==='naverpay'||$TPL_VAR["pgCompany"]==='kakaopay'){?>
			KRW
<?php }elseif($TPL_VAR["pgCompany"]==='paypal'){?>
			USD
<?php }elseif($TPL_VAR["pgCompany"]==='eximbay'){?>
			<?php echo $TPL_VAR["eximBayCur"]?>

<?php }?>
		</th>
		<th>PC / 모바일</th>
	</tr>
	<tr>
		<th>결제방법</th>
		<td>신용카드, 예치금, 은행계좌, 전자수표(e-check)</td>
	</tr>
<?php }elseif($TPL_VAR["pgCompany"]==='naverpay'){?>
	<tr>
		<th width="160px">
			 결제 통화
<?php if($TPL_VAR["pgCompany"]==='lg'||$TPL_VAR["pgCompany"]==='inicis'||$TPL_VAR["pgCompany"]==='allat'||$TPL_VAR["pgCompany"]==='kcp'||$TPL_VAR["pgCompany"]==='kspay'||$TPL_VAR["pgCompany"]==='kicc'||$TPL_VAR["pgCompany"]==='naverpay'||$TPL_VAR["pgCompany"]==='kakaopay'){?>
			KRW
<?php }elseif($TPL_VAR["pgCompany"]==='paypal'){?>
			USD
<?php }elseif($TPL_VAR["pgCompany"]==='eximbay'){?>
			<?php echo $TPL_VAR["eximBayCur"]?>

<?php }?>
		</th>
		<th>PC / 모바일</th>		
	</tr>
	<tr>
		<th align="center" style="height:15px;">신용카드</th>
		<td colspan="4" rowspan="4" align="left" style="padding-left: 10px;">
<?php if($TPL_VAR["navercheckout"]["use"]=='test'){?>
			<span class="desc" style="font-weight:normal;color:red;">네이버페이는 네이버 담당자의 최종 검수완료 후 사용 가능합니다.</span>
<?php }?>
			<div>
			&nbsp;└ 연동 제외 상품 : <?php echo count($TPL_VAR["navercheckout"]["except_category_code"])?>개의 카테고리, <?php echo count($TPL_VAR["navercheckout"]["except_goods"])?>개의 상품
			</div>
			<div>
			&nbsp;└ 연동 가능 배송그룹 : <?php echo $TPL_VAR["npay_shipping_group_cnt"]?>개의 배송그룹
			</div>
			<br/><a href="https://admin.checkout.naver.com/" target="_blank"><span class="btn medium orange"><button type="button" id="btnPaySetting">네이버페이 관리</button></span></a>
			<!-- <a href="https://admin.checkout.naver.com/" class="btn_contract" style="width:184px;" target="_blank">네이버페이 관리</a> -->
		</td>
	</tr>
	<tr>
		<th>계좌이체</th>
	</tr>
	<tr>
		<th>가상계좌</th>
	</tr>
	<tr>
		<th>예치금</th>
	</tr>
<?php }elseif($TPL_VAR["pgCompany"]==='payco'){?>
	<tr>
		<th width="160px">
			 결제 통화
<?php if($TPL_VAR["pgCompany"]==='lg'||$TPL_VAR["pgCompany"]==='inicis'||$TPL_VAR["pgCompany"]==='allat'||$TPL_VAR["pgCompany"]==='kcp'||$TPL_VAR["pgCompany"]==='kspay'||$TPL_VAR["pgCompany"]==='kicc'||$TPL_VAR["pgCompany"]==='naverpay'||$TPL_VAR["pgCompany"]==='kakaopay'){?>
			KRW
<?php }elseif($TPL_VAR["pgCompany"]==='payco'){?>
			<?php echo $TPL_VAR["payco_currency"]?>

<?php }elseif($TPL_VAR["pgCompany"]==='paypal'){?>
			<?php echo $TPL_VAR["paypal_currency"]?>

<?php }elseif($TPL_VAR["pgCompany"]==='eximbay'){?>
			<?php echo $TPL_VAR["eximBayCur"]?>

<?php }?>
		</th>
		<th>PC / 모바일</th>
		
	</tr>
	<tr>
		<th>결제방법</th>
		<td>
			<?php echo $TPL_VAR["payment_opt_str"]?><br/>
			할부기간 : 자동
		</td>
	</tr>
<?php }elseif($TPL_VAR["pgCompany"]==='kakaopay'){?>
	<tr>
		<th width="160px">
			 결제 통화
<?php if($TPL_VAR["pgCompany"]==='lg'||$TPL_VAR["pgCompany"]==='inicis'||$TPL_VAR["pgCompany"]==='allat'||$TPL_VAR["pgCompany"]==='kcp'||$TPL_VAR["pgCompany"]==='kspay'||$TPL_VAR["pgCompany"]==='kicc'||$TPL_VAR["pgCompany"]==='naverpay'||$TPL_VAR["pgCompany"]==='kakaopay'){?>
			KRW
<?php }elseif($TPL_VAR["pgCompany"]==='paypal'){?>
			<?php echo $TPL_VAR["paypal_currency"]?>

<?php }elseif($TPL_VAR["pgCompany"]==='eximbay'){?>
			<?php echo $TPL_VAR["eximBayCur"]?>

<?php }?>
		</th>
		<th colspan="2" align="center">PC</th>
		<th colspan="2" align="center">모바일</th>
	</tr>
	<tr>
		<th align="center" style="height:39px;">신용카드</th>
		<td colspan="4" rowspan="3" align="left" style="padding-left: 10px;">
<?php if($TPL_VAR["payment"]==='card'){?>
			사용 <br/>
<?php if($TPL_VAR["interestTerms"]!=''){?>
					할부기간 :
<?php if($TPL_VAR["interestTerms"]=='01'){?>
						일시불
<?php }else{?>
						<?php echo $TPL_VAR["interestTerms"]?> 개월
<?php }?>

<?php if($TPL_VAR["nonInterestTerms"]!=''){?>
						<br/>무이자 할부<br/>
<?php if($TPL_VAR["nonInterestTerms"]=='automatic'){?>
							&nbsp;└ 자동
<?php }else{?>
<?php if($TPL_CardCompanyCode_1){$TPL_I1=-1;foreach($TPL_VAR["CardCompanyCode"] as $TPL_V1){$TPL_I1++;?>
							<div>
							&nbsp;└ <?php echo $TPL_VAR["arrCardCompany"][$TPL_V1]?> <?php echo $TPL_VAR["CardCompanyTerms"][$TPL_I1]?> 개월
							</div>
<?php }}?>
<?php }?>
<?php }?>

<?php }else{?>
					할부기간 :  할부 미사용
<?php }?>
				<br/>
				<div class='red'>무이자할부 수수료를 PG사에서 부담 (권장)</div>
				<div class='red'>무이자할부 수수료를 쇼핑몰에서 부담(PG사와 협의)</div>
<?php }else{?>
			미사용
<?php }?>
		</td>
	</tr>
<?php }elseif($TPL_VAR["pgCompany"]==='daumkakaopay'){?>
	<tr>
		<th width="160px">
			 결제 통화 KRW
		</th>
		<th>PC / 모바일</th>		
	</tr>
	<tr>
		<th >결제방법</th>
		<td>
			<?php echo $TPL_VAR["payment_opt_str"]?>

			<br/>
			할부기간 : <?php echo $TPL_VAR["interestTerms"]?>

		</td>
	</tr>
<?php }else{?>
	<tr>
		<th rowspan="2" width="160px">
			 결제 통화
<?php if($TPL_VAR["pgCompany"]==='lg'||$TPL_VAR["pgCompany"]==='inicis'||$TPL_VAR["pgCompany"]==='allat'||$TPL_VAR["pgCompany"]==='kcp'||$TPL_VAR["pgCompany"]==='kspay'||$TPL_VAR["pgCompany"]==='kicc'||$TPL_VAR["pgCompany"]==='naverpay'||$TPL_VAR["pgCompany"]==='kakaopay'){?>
			KRW
<?php }elseif($TPL_VAR["pgCompany"]==='paypal'){?>
			<?php echo $TPL_VAR["paypal_currency"]?>

<?php }elseif($TPL_VAR["pgCompany"]==='eximbay'){?>
			<?php echo $TPL_VAR["eximBayCur"]?>

<?php }?>
		</th>
		<th colspan="2" align="center">PC</th>
		<th colspan="2" align="center">모바일</th>
	</tr>
	<tr>
		<th align="center">일반</th>
		<th align="center">에스크로</th>
		<th align="center">일반</th>
		<th align="center">에스크로</th>
	</tr>
	<tr>
		<th align="center">신용카드</th>
		<td style="padding-left:10px;">
<?php if(in_array('card',$TPL_VAR["payment"])){?>
			사용 <br/>
<?php if($TPL_VAR["interestTerms"]!=''){?>
					할부기간 :
<?php if($TPL_VAR["interestTerms"]=='0'){?>
						일시불
<?php }else{?>
						<?php echo $TPL_VAR["interestTerms"]?>개월
<?php }?>

<?php if($TPL_VAR["nonInterestTerms"]!=''){?>
						<br/>무이자 할부<br/>
<?php if($TPL_VAR["nonInterestTerms"]=='automatic'){?>
							<div>
							&nbsp;└ 자동
							</div>
<?php }else{?>
<?php if($TPL_pcCardCompanyCode_1){$TPL_I1=-1;foreach($TPL_VAR["pcCardCompanyCode"] as $TPL_V1){$TPL_I1++;?>
							<div>
							&nbsp;└ <?php echo $TPL_VAR["arrCardCompany"][$TPL_V1]?> <?php echo $TPL_VAR["pcCardCompanyTerms"][$TPL_I1]?> 개월
							</div>
<?php }}?>
<?php }?>
<?php }?>

<?php }else{?>
					할부기간 :  할부 미사용
<?php }?>
				<br/>
<?php if($TPL_VAR["nonInterestTerms"]!=''){?>
				<div>
<?php if($TPL_VAR["nonInterestTerms"]=='automatic'){?>
					<div class='red'>무이자할부 수수료를 PG사에서 부담 (권장)</div>
<?php }else{?>
					<div class='red'>무이자할부 수수료를 쇼핑몰에서 부담(PG사와 협의)</div>	
<?php }?>						
				</div>
<?php }?>			
<?php }else{?>
			미사용
<?php }?>

		</td>
		<td align="center"> - </td>
		<td style="padding-left:10px;">
<?php if(in_array('card',$TPL_VAR["mobilePayment"])){?>
			사용 <br/>
<?php if($TPL_VAR["mobileInterestTerms"]!=''){?>
					할부기간 :
<?php if($TPL_VAR["mobileInterestTerms"]=='0'){?>
						일시불
<?php }else{?>
						<?php echo $TPL_VAR["mobileInterestTerms"]?> 개월
<?php }?>
						
<?php if($TPL_VAR["mobileNonInterestTerms"]!=''){?>
						<br/>무이자 할부<br/>
<?php if($TPL_VAR["mobileNonInterestTerms"]=='automatic'){?>
							<div>
							&nbsp;└ 자동
							</div>
<?php }else{?>
<?php if($TPL_mobileCardCompanyCode_1){$TPL_I1=-1;foreach($TPL_VAR["mobileCardCompanyCode"] as $TPL_V1){$TPL_I1++;?>
							<div>
							&nbsp;└ <?php echo $TPL_VAR["arrCardCompany"][$TPL_V1]?> <?php echo $TPL_VAR["mobileCardCompanyTerms"][$TPL_I1]?> 개월
							</div>
<?php }}?>
<?php }?>
<?php }?>

<?php }else{?>
					할부기간 :  할부 미사용
<?php }?>
				<br/>
<?php if($TPL_VAR["mobileNonInterestTerms"]!=''){?>
				<div>
<?php if($TPL_VAR["mobileNonInterestTerms"]=='automatic'){?>
					<div class='red'>무이자할부 수수료를 PG사에서 부담 (권장)</div>
<?php }else{?>
					<div class='red'>무이자할부 수수료를 쇼핑몰에서 부담(PG사와 협의)</div>	
<?php }?>
				</div>
<?php }?>				
<?php }else{?>
			미사용
<?php }?>
		</td>
		<td align="center"> - </td>
	</tr>
	<tr>
		<th align="center">계좌이체</th>

		<!-- PC 일반 시작 -->
		<td style="padding-left:10px;">
<?php if(in_array('account',$TPL_VAR["payment"])){?>
			사용
<?php }else{?>
			미사용
<?php }?>
		</td>	
		<!-- PC 일반 끝 -->

		<!-- PC 에스크로 시작 -->
<?php if($TPL_VAR["pgCompany"]!=='kspay'){?>
		<td style="padding-left:10px;">
<?php if(in_array('account',$TPL_VAR["escrow"])){?>
			사용<br/>
			&nbsp;└ <?php echo $TPL_VAR["escrowAccountLimit"]?>원 이상 결제시
<?php }else{?>
			미사용
<?php }?>
		</td>
<?php }else{?>
		<td align="center"> - </td>
<?php }?>
		<!-- PC 에스크로 끝 -->
		
		<!-- Mobile 일반 시작 -->
<?php if($TPL_VAR["pgCompany"]!=='kspay'){?>
		<td style="padding-left:10px;">
<?php if(in_array('account',$TPL_VAR["mobilePayment"])){?>
			사용
<?php }else{?>
			미사용
<?php }?>
		</td>
<?php }else{?>
		<td align="center"> - </td>
<?php }?>
		<!-- Mobile 일반 끝 -->
		
		<!-- Mobile 에스크로 시작 -->
<?php if($TPL_VAR["pgCompany"]!=='kspay'){?>
		<td style="padding-left:10px;">
<?php if(in_array('account',$TPL_VAR["mobileEscrow"])){?>
			사용<br/>
			&nbsp;└ <?php echo $TPL_VAR["mobileEscrowAccountLimit"]?>원 이상 결제시
<?php }else{?>
			미사용
<?php }?>
		</td>
<?php }else{?>
		<td align="center"> - </td>
<?php }?>
		<!-- Mobile 에스크로 끝 -->

	</tr>
	<tr>
		<th align="center">가상계좌</th>
		
		<!-- PC 일반 시작 -->
		<td style="padding-left:10px;">
<?php if(in_array('virtual',$TPL_VAR["payment"])){?>
			사용 <button type="button" class="button_virtual_info btn_resp">입금 확인 URL 설정</button>
<?php }else{?>
			미사용
<?php }?>
		</td>
		<!-- PC 일반 끝 -->
		
		<!-- PC 에스크로 시작 -->
		<td style="padding-left:10px;">
<?php if(in_array('virtual',$TPL_VAR["escrow"])){?>
				사용<br/>
				&nbsp;└ <?php echo $TPL_VAR["escrowVirtualLimit"]?>원 이상 결제시
<?php }else{?>
				미사용
<?php }?>
		</td>
		<!-- PC 에스크로 끝 -->
		
		<!-- Mobile 일반 시작 -->
		<td style="padding-left:10px;">
<?php if(in_array('virtual',$TPL_VAR["mobilePayment"])){?>
			사용 <button type="button" class="button_virtual_info btn_resp">입금 확인 URL 설정</button>
<?php }else{?>
			미사용
<?php }?>
		</td>
		<!-- Mobile 일반 끝 -->

		<!-- Mobile 에스크로 시작 -->
		<td style="padding-left:10px;">
<?php if(in_array('virtual',$TPL_VAR["mobileEscrow"])){?>
			사용<br/>
			&nbsp;└ <?php echo $TPL_VAR["mobileEscrowVirtualLimit"]?>원 이상 결제시
<?php }else{?>
			미사용
<?php }?>
		</td>
		<!-- Mobile 에스크로 끝 -->

	</tr>
	<tr>
		<th align="center">핸드폰</th>
		<td style="padding-left:10px;">
<?php if(in_array('cellphone',$TPL_VAR["payment"])){?>
			사용
<?php }else{?>
			미사용
<?php }?>
		</td>
		<td align="center"> - </td>
		<td style="padding-left:10px;">
<?php if(in_array('cellphone',$TPL_VAR["mobilePayment"])){?>
			사용
<?php }else{?>
			미사용
<?php }?>
		</td>
		<td align="center"> - </td>
	</tr>
<?php }?>
</table>