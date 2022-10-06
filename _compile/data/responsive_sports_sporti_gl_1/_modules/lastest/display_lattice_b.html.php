<?php /* Template_ 2.2.6 2022/03/18 15:13:29 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/_modules/lastest/display_lattice_b.html 000004124 */ ?>
<!-- <?php echo $TPL_VAR["recent"]["boardtitle"]?> 최근글 start -->
<style type="text/css">
.<?php echo $TPL_VAR["lastest_key"]?> .tit {font-size:12px; font-weight:bold;}
.<?php echo $TPL_VAR["lastest_key"]?> .normal_bbslist .cat {font-size:12px;font-family:gothic,gulim;color:#888;letter-spacing:-1px;}
.<?php echo $TPL_VAR["lastest_key"]?> .normal_bbslist .sbj {text-align:left;letter-spacing:0px;}
.<?php echo $TPL_VAR["lastest_key"]?> .normal_bbslist .sbj a {font-size:12px;font-family:gothic,gulim;color:#222222;text-decoration:none;line-height:150%;}
.<?php echo $TPL_VAR["lastest_key"]?> .normal_bbslist .sbj a:hover {text-decoration:underline;}
.<?php echo $TPL_VAR["lastest_key"]?> .normal_bbslist .comment {font:normal 11px arial;color:#FC6138;}
</style>
<div class='designDisplay <?php echo $TPL_VAR["lastest_key"]?>' designElement='displaylastest'  id="<?php echo $TPL_VAR["lastest_key"]?>" templatePath='<?php echo $TPL_VAR["template_path"]?>' >
	<div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="bottom" align="left" height="25"><span class="tit"><?php echo $TPL_VAR["recent"]["title"]?></span></td>
			<td valign="bottom" align="right"><b><a href="/board/?id=<?php echo $TPL_VAR["recent"]["boardId"]?>"><img src="/data/skin/responsive_sports_sporti_gl_1/images/design/cscenter_btn_more.gif" /></a></b></td>
		</tr>
	</table>
	</div>
	<br style="line-height:10px;" />
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<?php echo $TPL_VAR["recent"]["getBoardData"]?>

			<?php echo $TPL_VAR["recent"]["toptr"]?>

			<td width="50%"  class="sbj">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
<?php if($TPL_VAR["recent"]["showNumber"]){?><td width="10"><span ><?php echo $TPL_VAR["recent"]["Number"]?></span></td><?php }?>
<?php if($TPL_VAR["recent"]["showImg"]){?><td  width="<?php echo $TPL_VAR["recent"]["image_w"]?>"  height="<?php echo $TPL_VAR["recent"]["image_h"]?>"><?php echo $TPL_VAR["recent"]["imagelay"]?></td><?php }?>
					<td width="10"></td>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td align="<?php echo $TPL_VAR["recent"]["text_align"]?>">
							<?php echo $TPL_VAR["recent"]["goodsInfo"]?>

							<?php echo $TPL_VAR["recent"]["subject"]?>

						</td>
						</tr>

<?php if($TPL_VAR["recent"]["showContents"]){?>
						<tr><td height="6"></td></tr>
						<tr>
							<td align="<?php echo $TPL_VAR["recent"]["text_align"]?>"><?php echo $TPL_VAR["recent"]["contents"]?></td>
						</tr>
<?php }?>

						<tr><td height="6"></td></tr>
						<tr>
							<td align="<?php echo $TPL_VAR["recent"]["text_align"]?>">
<?php if(is_array($TPL_R1=$TPL_VAR["recent"]["info_settings"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1=='showDate'&&$TPL_VAR["recent"]["showDate"]){?>
									<?php echo $TPL_VAR["recent"]["r_date"]?>

<?php }?>
<?php if($TPL_V1=='showView'&&$TPL_VAR["recent"]["showView"]){?>
									<?php echo $TPL_VAR["recent"]["hitlay"]?>

<?php }?>
<?php if($TPL_V1=='showRecommend'&&$TPL_VAR["recent"]["showRecommend"]){?>
									<?php echo $TPL_VAR["recent"]["recommendlay"]?>

<?php }?>
<?php if($TPL_V1=='showName'&&$TPL_VAR["recent"]["showName"]){?>
									<?php echo $TPL_VAR["recent"]["name"]?>

<?php }?>
<?php if($TPL_V1=='showScore'&&$TPL_VAR["recent"]["showScore"]){?>
									<?php echo $TPL_VAR["recent"]["scorelay"]?>

<?php }?>
<?php if($TPL_V1=='showBuyer'&&$TPL_VAR["recent"]["showBuyer"]){?>
									<?php echo $TPL_VAR["recent"]["buyertitle"]?>

<?php }?>
<?php }}?>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		<?php echo $TPL_VAR["recent"]["end"]?>

	</tr>
	<tr><td height="10"></td></tr>
	</table>
</div>
<!-- <?php echo $TPL_VAR["recent"]["boardtitle"]?> 최근글 end -->