<?php /* Template_ 2.2.6 2019/06/14 15:19:03 /www/gs1602700.git/solution/data/email/kr/promotion.html 000005588 */ ?>
<!--HEAD -->
<table style="border-bottom-color: rgb(0, 0, 0); border-bottom-width: 2px; border-bottom-style: solid;" border="0" cellSpacing="0" cellPadding="0" width="700" align="center" height="60">
<tbody>
<tr>
	<td><img src="/data/email/kr/img/logo.gif" width="146" height="19"></td>
</tr>
</tbody>
</table>
<!--/HEAD -->

<table style="margin-top: 65px; margin-bottom: 45px;" border="0" cellSpacing="0" cellPadding="0" width="700" align="center">
<tbody>
<tr>
	<td align="center"><img alt="PROMOTION CODE가 발급되었습니다," src="/data/email/kr/img/txt_promo.gif"></td>
</tr>
</tbody>
</table>

<!--발급 코드 테이블 -->
<table style="border: 2px solid rgb(170, 170, 170); border-collapse: collapse;" class="info-table-style" width="670" align="center">
<colgroup><col width="20%"><col width="80%">
<tbody><tr>
	<th style="padding: 8px 0px 8px 28px; text-align: left; color: rgb(77, 77, 77); line-height: 14px; font-size: 12px; font-weight: normal; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid; background-color: rgb(241, 241, 241);" class="its-th">코드</th>
	<td style="padding: 5px 0px 5px 15px; color: rgb(77, 77, 77); line-height: 180%; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid;" class="its-td"><?php echo $TPL_VAR["promotioncode"]?></td>
</tr>
<tr>
	<th style="padding: 8px 0px 8px 28px; text-align: left; color: rgb(77, 77, 77); line-height: 14px; font-size: 12px; font-weight: normal; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid; background-color: rgb(241, 241, 241);" class="its-th">할인</th>
	<td style="padding: 5px 0px 5px 15px; color: rgb(77, 77, 77); line-height: 180%; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid;" class="its-td"><?php echo $TPL_VAR["promotionsale"]?></td>
</tr>
<tr>
	<th style="padding: 8px 0px 8px 28px; text-align: left; color: rgb(77, 77, 77); line-height: 14px; font-size: 12px; font-weight: normal; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid; background-color: rgb(241, 241, 241);" class="its-th">유효기간</th>
	<td style="padding: 5px 0px 5px 15px; color: rgb(77, 77, 77); line-height: 180%; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid;" class="its-td"><?php echo $TPL_VAR["promotionlimitdate"]?></td>
</tr>
</tbody></table>
<!--/발급 코드 테이블 -->

<!--PROMOTION CODE? -->
<table style="margin-top: 74px;" border="0" cellSpacing="0" cellPadding="0" width="670" align="center">
<tbody>
<tr>
	<td style="font: 12px/normal Dotum; color: rgb(97, 106, 116); font-size-adjust: none; font-stretch: normal;" height="28"><strong style="color: rgb(0, 0, 0);">프로모션 코드</strong> 이용안내</td>
</tr>
<tr>
	<td style="font: 12px/normal Dotum; color: rgb(97, 106, 116); font-size-adjust: none; font-stretch: normal;">
		- 본 프로모션 코드는 <font color="#cd2700">회원님께만</font> 발송되는 할인코드입니다.<br>
		- 본 프로모션 코드는 <font color="#cd2700">1개의 주문에 1회 사용</font>이 가능합니다.<br>
		- 본 프로모션 코드는 <font color="#cd2700">주문 할 때 입력</font>하여 사용하시게 됩니다.<br>
		- 본 프로모션 코드는 <font color="#cd2700">할인 혜택이 바로 적용</font>됩니다.<br>
		- 본 프로모션 코드는 <font color="#cd2700">유효기간</font> 내에 사용하셔야 합니다.<br>
	</td>
</tr>
</tbody>
</table>
<!--/PROMOTION CODE? -->

<!--쇼핑몰가기 버튼 -->
<div style="text-align: center; padding-top: 50px; padding-bottom: 30px;"><a href="<?php echo $TPL_VAR["basic"]["domain"]?>" target="_blank"><img alt="쇼핑몰가기" src="/data/email/kr/img/btn_go.gif" width="200" height="50"></a></div>
<!--/쇼핑몰가기 버튼 -->

<!--FOOTER -->
<table style="border-top-color: rgb(0, 0, 0); border-top-width: 2px; border-top-style: solid;" border="0" cellSpacing="0" cellPadding="0" width="700" align="center" height="60">
<tbody>
	<tr>
	<td height="20"></td>
</tr>
<tr>
	<td style="font: 11px/18px Dotum; text-align: center; color: rgb(150, 157, 163); font-size-adjust: none; font-stretch: normal;">
		사업자등록번호 : <?php echo $TPL_VAR["basic"]["businessLicense"]?>&nbsp;&nbsp;&nbsp;&nbsp;통신판매업신고번호 : <?php echo $TPL_VAR["basic"]["mailsellingLicense"]?>&nbsp;&nbsp;&nbsp;&nbsp;대표이사 : <?php echo $TPL_VAR["basic"]["ceo"]?><br>
		주소 : <?php echo $TPL_VAR["basic"]["companyAddress"]?>&nbsp;&nbsp;&nbsp;&nbsp;대표전화 : <?php echo $TPL_VAR["basic"]["companyPhone"]?>&nbsp;&nbsp;&nbsp;&nbsp;팩스 : <?php echo $TPL_VAR["basic"]["companyFax"]?>

	</td>
</tr>
</tbody>
</table>
<!--/FOOTER -->