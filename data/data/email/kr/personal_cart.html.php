<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/data/email/kr/personal_cart.html 000008626 */ 
$TPL_cartlist_1=empty($TPL_VAR["cartlist"])||!is_array($TPL_VAR["cartlist"])?0:count($TPL_VAR["cartlist"]);
$TPL_wishlist_1=empty($TPL_VAR["wishlist"])||!is_array($TPL_VAR["wishlist"])?0:count($TPL_VAR["wishlist"]);?>
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
		<td style="color: rgb(35, 35, 35); line-height: 40px; font-family: 돋움,Dotum; font-size: 34px; font-weight: bold;">장바구니/위시리스트에 담은 상품 정보입니다!</td>
	</tr>
	<tr><td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" height="20"></td></tr>
	<tr><td class="texts" style="color: rgb(97, 106, 116); line-height: 22px; padding-left: 10px; font-family: 돋움, Dotum; font-size: 12px;"><?php echo $TPL_VAR["username"]?>님, 안녕하세요. <?php echo $TPL_VAR["config_basic"]["shopName"]?>쇼핑몰 입니다.</td></tr>
	<tr><td class="texts" style="height: 28px; color: rgb(97, 106, 116); line-height: 18px; padding-top: 10px; padding-left: 10px; font-family: 돋움, Dotum; font-size: 12px;"><p>회원님께서 어제 장바구니 또는 위시리스트에 담은 상품 정보를 알려드립니다.</p></td></tr>
	<tr><td style="text-align: left; color: rgb(77, 77, 77); line-height: 18px; font-size: 12px;" height="20"></td></tr>
<?php if($TPL_VAR["cartlist"]){?> 
	<tr><td style="text-align: left; line-height: 18px; font-size: 12px; colorr: reg(0, 0, 0);" height="20"><strong>장바구니에 총 <?php echo $TPL_VAR["cart_count"]?>개의 상품이 있습니다.</strong></td></tr>
	<tr>
		<td style="color: rgb(77, 77, 77); line-height: 20px; padding-bottom: 5px; font-family: 돋움,Dotum; font-size: 12px; border-top-color: rgb(105, 105, 105); border-bottom-color: rgb(105, 105, 105); border-top-width: 2px; border-bottom-width: 2px; border-top-style: solid; border-bottom-style: solid;" align="center">
<?php if($TPL_cartlist_1){foreach($TPL_VAR["cartlist"] as $TPL_V1){?>
		<div style="margin: 0px; padding: 15px; width: 696px; height: 80px; color: rgb(0, 0, 0); clear: both; border-top-color: rgb(221, 221, 221); border-top-width: 1px; border-top-style: solid; position: relative;">
			<div style="padding: 0px; border-radius: 3px; border: 1px solid rgb(221, 221, 221); border-image: none; width: 80px; height: 80px; text-align: center; float: left;"><a style="color: rgb(0, 0, 0); text-decoration: none;" href="<?php echo $TPL_VAR["shopdomain"]?>/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo $TPL_V1["goods_image"]?></a></div>
			<div style="width: 580px; text-align: left; margin-left: 15px; float: left;">
				<div style="width: 440px; text-align: left; line-height: 15px; font-size: 12px; margin-top: 4px; float: left; min-height: 20px;">
					<a style="color: rgb(0, 0, 0); text-decoration: none;" href="<?php echo $TPL_VAR["shopdomain"]?>/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><strong><?php echo $TPL_V1["goods_name"]?></strong></a>
<?php if($TPL_V1["options"]){?>
					<div style="text-align: left; line-height: 18px; font-size: 12px;"><img style="border: 0px currentColor; border-image: none;" src="/admin/skin/default/images/common/icon_option.gif" align="absmiddle"> <?php echo $TPL_V1["options"]?></div>
<?php }?>
				</div>
				<div style="width: 140px; text-align: right; line-height: 20px; padding-top: 55px; font-size: 14px; float: right;"><strong><?php echo $TPL_V1["price"]?>원</strong></div>
			</div>
		</div>
<?php }}?>
		</td>
	</tr>
	<tr><td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" height="30"></td></tr>
	<tr>
		<td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" align="center"><a style="padding: 12px 18px; border-radius: 5px; text-align: center; color: rgb(255, 255, 255); font-family: 돋움,Dotum; font-size: 14px; font-weight: bold; text-decoration: none; background-color: rgb(0, 0, 0);" href="<?php echo $TPL_VAR["mypage_short_url_cart"]?>" target="_blank"><strong>나의 장바구니 보기 &gt;</strong></a></td>
	</tr>
<?php }?>
<?php if($TPL_VAR["wishlist"]){?>
	<tr><td style="text-align: left; color: rgb(77, 77, 77); line-height: 18px; font-size: 12px;" height="50"></td></tr>
	<tr><td style="text-align: left; line-height: 18px; font-size: 12px; colorr: reg(0, 0, 0);" height="20"><strong>위시리스트에 총 <?php echo $TPL_VAR["wish_count"]?>개의 상품이 있습니다.</strong></td></tr>
	<tr>
		<td style="color: rgb(77, 77, 77); line-height: 20px; font-family: 돋움,Dotum; font-size: 12px; border-top-color: rgb(105, 105, 105); border-bottom-color: rgb(105, 105, 105); border-top-width: 2px; border-bottom-width: 2px; border-top-style: solid; border-bottom-style: solid;" align="center">
<?php if($TPL_wishlist_1){foreach($TPL_VAR["wishlist"] as $TPL_V1){?>
		<div style="margin: 0px; padding: 15px; width: 696px; color: rgb(0, 0, 0); clear: both; border-top-color: rgb(221, 221, 221); border-top-width: 1px; border-top-style: solid; position: relative;">
			<div style="padding: 0px; border-radius: 3px; border: 1px solid rgb(221, 221, 221); border-image: none; width: 80px; height: 80px; text-align: center; margin-bottom: 15px; float: left;"><a style="color: rgb(0, 0, 0); text-decoration: none;" href="<?php echo $TPL_VAR["shopdomain"]?>/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo $TPL_V1["goods_image"]?></a></div>
			<div style="width: 580px; text-align: left; margin-left: 15px; float: left;">
				<div style="width: 440px; text-align: left; line-height: 15px; font-size: 12px; margin-top: 4px; float: left; min-height: 20px;"><a style="color: rgb(0, 0, 0); text-decoration: none;" href="<?php echo $TPL_VAR["shopdomain"]?>/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><strong><?php echo $TPL_V1["goods_name"]?></strong></a></div>
				<div style="width: 140px; text-align: right; line-height: 20px; padding-top: 55px; font-size: 14px; float: right;"><strong><?php echo $TPL_V1["price"]?>원</strong></div>
			</div>
		</div>
<?php }}?>
		</td>
	</tr>
	<tr><td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" height="30"></td></tr>
	<tr>
		<td style="color: rgb(77, 77, 77); line-height: 14px; font-size: 12px;" align="center"><a style="padding: 12px 18px; border-radius: 5px; text-align: center; color: rgb(255, 255, 255); font-family: 돋움,Dotum; font-size: 14px; font-weight: bold; text-decoration: none; background-color: rgb(0, 0, 0);" href="<?php echo $TPL_VAR["mypage_short_url_wish"]?>" target="_blank"><strong>나의 위시리스트 보기 &gt;</strong></a></td>
	</tr>
<?php }?>
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