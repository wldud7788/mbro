<?php /* Template_ 2.2.6 2022/05/17 12:37:04 /www/music_brother_firstmall_kr/admin/skin/default/setting/_ssl_list_ajax.html 000003136 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<style>
<?php if(is_array($TPL_R1=$TPL_VAR["ssllib"]->valueSslConfigCertStatus['cancel'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
	.cart_status_<?php echo $TPL_V1?> {color:red;}
<?php }}?>
	.cart_redirect_Y {color:blue;}
</style>
<table width="100%" class="table_basic multi">
	<colgroup>
		<col>
		<col width="20%">
		<col width="20%">
		<col width="12%">
		<col width="15%">
	</colgroup>
	<tbody>
		<tr>
			<th>
				도메인
			</th>
			<th>
				인증서
			</th>
			<th>
				유효기간
			</th>
			<th>
				상태
			</th>
			<th>
				리다이렉트 설정
			</th>
		</tr>
		
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td class="domain-title-favicon">
<?php if(is_array($TPL_R2=$TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['domainList']])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<div>
					<span class="platform-domain"><?php echo $TPL_V2?></span>
				</div>
<?php }}?>
			</td>
			<td class="center">
<?php if($TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certOut']]=='Y'){?>
				(<?php echo $TPL_VAR["ssllib"]->codeSslConfigCertOut[$TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certOut']]]?>)
<?php }else{?>
				(<?php echo $TPL_VAR["ssllib"]->codeSslConfigCertPaid[$TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certPaid']]]?>)
<?php }?>
				<?php echo $TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certName']]?>

			</td>
			<td class="center">
				<?php echo $TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certPeriod']]?>

			</td>
			<td class="center cart_status_<?php echo $TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certStatus']]?>">
				<?php echo $TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certStatusText']]?>

			</td>
			<td class="center">
<?php if((in_array($TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certStatus']],$TPL_VAR["ssllib"]->valueSslConfigCertStatus['done']))){?>
				<span class='cart_redirect_<?php echo $TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certRedirect']]?>'>
					<?php echo $TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certRedirectText']]?>

				</span>
				
					<button type="button"
						data-ssl-seq="<?php echo $TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certSeq']]?>"
						data-redirect="<?php echo $TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certRedirect']]?>"
						class="btn_set_ssl_redirect btn_resp b_gray2">
<?php if($TPL_V1[$TPL_VAR["ssllib"]->sslConfigColumn['certRedirect']]=='Y'){?>
						해제
<?php }else{?>
						설정
<?php }?>
					</button>
				
<?php }else{?>
				-
<?php }?>
			</td>
		</tr>
<?php }}else{?>
		<tr>
			<td class="center" colspan="5">
				설치된 보안서버 인증서(SSL)가 없습니다.
			</td>
		</tr>
<?php }?>
	</tbody>
</table>
<!-- 페이징 -->

<?php if($TPL_loop_1> 0){?>
<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
<?php }?>