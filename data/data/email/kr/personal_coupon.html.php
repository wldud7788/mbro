<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/data/email/kr/personal_coupon.html 000008239 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<table border="0" cellpadding="0" cellspacing="0" width="696">
	<tbody><tr><td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" height="20"></td></tr>
	<tr>
		<td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;"><img src="/data/mail/logo.gif"></td>
	</tr>
	<tr><td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" height="20"></td></tr>
	<tr><td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" bgcolor="#000000" height="2"></td></tr>
	<tr><td style="height: 60px; color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" height="60"></td></tr>
	<!-- 내용시작 -->
	<tr>
		<td style="color: rgb(35, 35, 35); line-height: 40px; font-family: 돋움,Dotum; font-size: 34px; font-weight: bold;">이번 주에 만료되는 할인쿠폰입니다!</td>
	</tr> 
	<tr><td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" height="35"></td></tr>
	<tr><td class="texts" style="color: rgb(97, 106, 116); line-height: 22px; padding-left: 10px; font-family: 돋움, Dotum; font-size: 12px;"><?php echo $TPL_VAR["username"]?>님, 안녕하세요. <?php echo $TPL_VAR["config_basic"]["shopName"]?>쇼핑몰 입니다.</td></tr>
	<tr><td class="texts" style="color: rgb(97, 106, 116); line-height: 22px; padding-top: 10px; padding-left: 10px; font-family: 돋움, Dotum; font-size: 12px;"><p>고객님께서 보유하고 계신 쿠폰 중 이번 주에 소멸되는 쿠폰이 있습니다.</p><p>쿠폰이 소멸되기 전에 꼭 사용하셔서 할인 혜택을 받으세요.</p></td></tr>
	<tr><td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" height="20"></td></tr>
	<tr>
		<td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" align="center">

		<table class="info-table-style" style="border-top-color: rgb(170, 170, 170); border-right-color: rgb(218, 218, 218); border-top-width: 1px; border-right-width: 1px; border-top-style: solid; border-right-style: solid; border-collapse: collapse;" width="676">
		<tbody><tr>
			<th class="its-th-center" style="padding: 5px 0px; text-align: center; color: rgb(77, 77, 77); line-height: 180%; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid; background-color: rgb(241, 241, 241);" width="230">쿠폰명</th>
			<th class="its-th-center" style="padding: 5px 0px; text-align: center; color: rgb(77, 77, 77); line-height: 180%; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid; background-color: rgb(241, 241, 241);" width="130">제한금액</th>
			<th class="its-th-center" style="padding: 5px 0px; text-align: center; color: rgb(77, 77, 77); line-height: 180%; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid; background-color: rgb(241, 241, 241);" width="120">기간제한</th>
			<th class="its-th-center" style="padding: 5px 0px; text-align: center; color: rgb(77, 77, 77); line-height: 180%; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid; background-color: rgb(241, 241, 241);" width="136">혜택</th>
			<th class="its-th-center" style="padding: 5px 0px; text-align: center; color: rgb(77, 77, 77); line-height: 180%; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid; background-color: rgb(241, 241, 241);" width="60">적용대상</th>
		</tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<?php if($TPL_V1["use_period"]=='y'){?>
		<tr>
			<td class="its-td-center" style="padding: 5px 0px 5px 5px; text-align: left; color: rgb(77, 77, 77); line-height: 14px; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid;"><?php echo $TPL_V1["cp_name"]?></td>
			<td class="its-td-center" style="padding: 5px 0px; text-align: center; color: rgb(77, 77, 77); line-height: 14px; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid;"><?php echo $TPL_V1["limit_price"]?></td>
			<td class="its-td-center" style="padding: 5px 0px; text-align: center; color: rgb(77, 77, 77); line-height: 14px; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid;"><?php echo $TPL_V1["issuedate"]?></td>
			<td class="its-td-center" style="padding: 5px 0px; text-align: center; color: rgb(77, 77, 77); line-height: 14px; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid;"><?php echo $TPL_V1["salepricetitle"]?></td>
			<td class="its-td-center" style="padding: 5px 0px; text-align: center; color: rgb(77, 77, 77); line-height: 14px; letter-spacing: 0px; font-size: 12px; border-bottom-color: rgb(218, 218, 218); border-left-color: rgb(218, 218, 218); border-bottom-width: 1px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid;"><?php echo $TPL_V1["issuetype"]?></td>
		</tr>
<?php }?>
<?php }}?>
		</tbody></table>

		</td>
	</tr>
	<tr><td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" height="40"></td></tr>
	<tr>
		<td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" align="center"><a style="padding: 12px 18px; border-radius: 5px; text-align: center; color: rgb(255, 255, 255); font-family: 돋움,Dotum; font-size: 14px; font-weight: bold; text-decoration: none; background-color: rgb(0, 0, 0);" href="<?php echo $TPL_VAR["mypage_short_url"]?>" target="_blank"><strong>나의 쿠폰 보기 &gt;</strong></a></td>
	</tr>
	<tr><td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" height="30"></td></tr>
	<tr><td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" bgcolor="#000000" height="2"></td></tr>
	<tr><td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" height="20"></td></tr>
	<tr>
		<td class="company" style="text-align: center; color: rgb(151, 158, 165); line-height: 22px; font-family: 돋움, Dotum; font-size: 11px;">
			사업자등록번호 : <?php echo $TPL_VAR["config_basic"]["businessLicense"]?>&nbsp;&nbsp;&nbsp;&nbsp;통신판매업신고번호 : <?php echo $TPL_VAR["config_basic"]["mailsellingLicense"]?>&nbsp;&nbsp;&nbsp;&nbsp;대표이사 : <?php echo $TPL_VAR["config_basic"]["ceo"]?>

		</td>
	</tr>
	<tr>
		<td class="company" style="text-align: center; color: rgb(151, 158, 165); line-height: 22px; font-family: 돋움, Dotum; font-size: 11px;">
			주소 : <?php echo $TPL_VAR["config_basic"]["companyAddress"]?> <?php echo $TPL_VAR["config_basic"]["companyAddressDetail"]?>&nbsp;&nbsp;&nbsp;&nbsp;대표전화 : <?php echo $TPL_VAR["config_basic"]["companyPhone"]?>&nbsp;&nbsp;&nbsp;&nbsp;팩스 : <?php echo $TPL_VAR["config_basic"]["companyFax"]?>

		</td>
	</tr>
</tbody></table><p><br></p>