<?php /* Template_ 2.2.6 2021/12/15 16:50:22 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/goods/autocomplete.html 000005606 */ 
$TPL_result_1=empty($TPL_VAR["result"])||!is_array($TPL_VAR["result"])?0:count($TPL_VAR["result"]);
$TPL_result_recomm_1=empty($TPL_VAR["result_recomm"])||!is_array($TPL_VAR["result_recomm"])?0:count($TPL_VAR["result_recomm"]);?>
<style>
ul.autocomplete_list {color:#43454d;}
ul.autocomplete_list li {height:34px; line-height:34px; border-top:1px solid #e0e0e0; text-indent:20px; font-size:14px;}
ul.autocomplete_list li a {display:block; height:34px; line-height:34px;}
</style>
<div style="margin:0 64px 0 0; border-collapse:collapse; border:1px solid #333; box-sizing:border-box; min-width:256px; background:#ffffff;">
<?php if(($TPL_VAR["key"]&&$TPL_VAR["auto_search_use"]=='y')||$TPL_VAR["popular_search_use"]!='y'){?>
<table width="100%" cellpadding="0" cellspacing="0">
	<col width="60%" /><col width="40%" />
	<tr>
		<td valign="top" style="padding:10px;">
			<table width="100%" cellpadding="0" cellspacing="0">
<?php if($TPL_VAR["result"]){?>
<?php if($TPL_result_1){foreach($TPL_VAR["result"] as $TPL_V1){?>
				<tr valign="top">
					<td width="90%"><a href="/goods/search?search_text=<?php echo $TPL_V1["key"]?>"><span style="font-size:12px; color:#676767;"><?php echo $TPL_V1["keyword"]?></span></a></td>
					<td width="10%" align="right" style="font-size:11px; color:#acacac"><?php echo $TPL_V1["cnt"]?></td>
				</tr>
				<tr>
					<td colspan="2" style="height:7px;"></td>
				</tr>
<?php }}?>
<?php }elseif(!$TPL_VAR["key"]){?>
				<tr>
					<td colspan="2">검색어를 입력하여 주세요!</td>
				</tr>		
<?php }else{?>
				<tr>
					<td colspan="2">해당 단어로 시작하는 검색어가 없습니다.</td>
				</tr>
<?php }?>
			</table>
		</td>
		<td style="padding:10px;border-left:1px solid #e0e0e0;">
			<div align="center" style="padding:0 7px 7px 0; font-size:12px; color:#000;"><strong>추천상품</strong></div>
<?php if($TPL_result_recomm_1){foreach($TPL_VAR["result_recomm"] as $TPL_V1){?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center">
					<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target=""><img src="<?php echo $TPL_V1["goods_img"]?>" width="100" onerror="this.src='/data/skin/<?php echo $TPL_VAR["skin"]?>/images/common/noimage.gif';" /></a>
					</td>				
				</tr>				
				<tr><td height="6"></td></tr>
				<tr>
					<td align="center"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target=""><span style="font-size:11px;color:#000000;font-weight:normal;text-decoration:none;"><?php echo $TPL_V1["goods_name"]?></span></a></td>
				</tr>
				<tr><td height="6"></td></tr>
				<tr>
					<td align="center"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target=""><span style="color:#000000;font-weight:normal;text-decoration:none;font-weight:bold"><?php echo $TPL_V1["replace_price"]?></span></a></td>
				</tr>
			</table>
<?php }}?>
		</td>
	</tr>
</table>
<div style="border-collapse:collapse; background:#ffffff; border-top:1px solid #e0e0e0; padding:7px 7px 7px 0px;" align='right'><a href="javascript:autocomplete_nouse();"  style="font-size:11px; color:#95959f;">기능끄기</a></div>
<?php }else{?>
<table width="100%" cellpadding="0" cellspacing="0">
	<col width="60%" /><col width="40%" />
	<tr>
		<td valign="top" style="padding:10px;">
			<div style="padding:5px 0 10px 0;"><span style="font-size:12px; color:#d52901; font-weight:bold;">인기</span><span style="font-size:12px; color:#000000; font-weight:bold;">검색어</span></div>
			<table width="100%" cellpadding="0" cellspacing="0">
<?php if($TPL_result_1){$TPL_I1=-1;foreach($TPL_VAR["result"] as $TPL_V1){$TPL_I1++;?>
				<tr valign="top">
					<td width="10%" style="padding-top:1px; font-size:11px; color:#acacac;"><?php echo $TPL_I1+ 1?></td>
					<td width="90%" style="font-size:12px; color:#676767;word-wrap:break-word;word-break:break-all;"><a href="/goods/search?search_text=<?php echo $TPL_V1["key"]?>"><span style="font-size:12px; color:#676767;"><?php echo $TPL_V1["keyword"]?></span></a></td>				
				</tr>
				<tr>
					<td colspan="2" style="height:6px;"></td>
				</tr>
<?php }}?>
			</table>
		</td>
		<td style="padding:10px;border-left:1px solid #e0e0e0;">
			<div align="center" style="padding:0 7px 7px 0; font-size:12px; color:#000;"><strong>추천상품</strong></div>
<?php if($TPL_result_recomm_1){foreach($TPL_VAR["result_recomm"] as $TPL_V1){?>
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center">
					<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target=""><img src="<?php echo $TPL_V1["goods_img"]?>" width="100" onerror="this.src='/data/skin/<?php echo $TPL_VAR["skin"]?>/images/common/noimage.gif';" /></a>
					</td>				
				</tr>				
				<tr><td height="6"></td></tr>
				<tr>
					<td align="center"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target=""><span style="font-size:11px;color:#000000;font-weight:normal;text-decoration:none;"><?php echo $TPL_V1["goods_name"]?></span></a></td>
				</tr>
				<tr><td height="6"></td></tr>
				<tr>
					<td align="center"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target=""><span style="color:#000000;font-weight:normal;text-decoration:none;font-weight:bold"><?php echo $TPL_V1["replace_price"]?></span></a></td>
				</tr>
			</table>
<?php }}?>
		</td>
	</tr>
</table>
<?php }?>
</div>