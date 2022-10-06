<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_get_recommend.html 000003857 */ 
$TPL_display_tabs_1=empty($TPL_VAR["display_tabs"])||!is_array($TPL_VAR["display_tabs"])?0:count($TPL_VAR["display_tabs"]);?>
<?php if($TPL_VAR["display_tabs"]){?>
<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0" id="inner_html">
<colgroup>
	<col width="16%" />
	<col width="" />
<?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>
	<col width="15%" />
	<col width="15%" />
<?php }?>
</colgroup>
<thead class="lth">
<tr>
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
	<th class="its-th-align" colspan="2">데스크탑, 모바일</th>
<?php }else{?>
	<th class="its-th-align" colspan="2">데스크탑</th>
	<th class="its-th-align" colspan="2">모바일</th>
<?php }?>
</tr>
</thead>
<tbody class="ltb">
<?php if($TPL_display_tabs_1){$TPL_I1=-1;foreach($TPL_VAR["display_tabs"] as $TPL_V1){$TPL_I1++;?>
<tr>
	<td class="its-td-align">
<?php if(count($TPL_VAR["display_tabs"])> 1){?>
		<span class="strTab">[탭<span class="strTabIdx"><?php echo $TPL_I1+ 1?></span>]</span>
<?php }?>

<?php if($TPL_V1["contents_type"]=='auto'){?>
		자동
<?php }elseif($TPL_V1["contents_type"]=='auto_sub'){?>
		자동(2)
<?php }elseif($TPL_V1["contents_type"]=='select'){?>
		직접선정
<?php }elseif($TPL_V1["contents_type"]=='text'){?>
		입력
<?php }?>
	</td>
	<td class="its-td-align">
<?php if($TPL_V1["contents_type"]=='auto'){?>
		<div class="displayTabAutoTypeContainer" type="auto">
			<div class="displayCriteriaDesc pdt10"><?php echo $TPL_V1["auto_criteria_desc"]?></div>
		</div>
<?php }elseif($TPL_V1["contents_type"]=='auto_sub'){?>
		<div class="displayTabAutoTypeContainer" type="auto_sub">
			<div class="displayCriteriaDesc pdt10"><?php echo $TPL_V1["auto_criteria_desc"]?></div>
		</div>
<?php }elseif($TPL_V1["contents_type"]=='select'){?>
		<div id="displayGoods<?php echo $TPL_I1?>" class="displayGoods">
<?php if(is_array($TPL_R2=$TPL_V1["items"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<div class='goods fl'>
				<div align='center' class='image'><img src="<?php echo $TPL_V2["image"]?>" class="goodsThumbView" width="50" height="50" alt="<?php echo htmlspecialchars($TPL_V2["goods_name"])?>" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif'" /></div>
				<div align='center' class='name' style='width:70px;overflow:hidden;white-space:nowrap;'><?php echo htmlspecialchars($TPL_V2["goods_name"])?></div>
				<div align='center' class='price'><?php echo get_currency_price($TPL_V2["price"])?></div>
<?php if(serviceLimit('H_AD')){?>
				<div align='center' class='provider_name red'><?php echo $TPL_V2["provider_name"]?></div>
<?php }?>
			</div>
<?php }}?>
		</div>
<?php }elseif($TPL_V1["contents_type"]=='text'){?>
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
			<div class="displayTabAutoTypeContainer" type="text">
				<div style="border:1px solid #dadada;"><?php echo $TPL_V1["tab_contents"]?></div>
			</div>
<?php }else{?>
			<div class="displayTabAutoTypeContainer" type="text">
				* 데스크탑/태블릿用
				<div style="border:1px solid #dadada;"><?php echo $TPL_V1["tab_contents"]?></div>
			</div>
			<div class="displayTabAutoTypeContainer tab_contents_mobile" type="text">
				* 모바일用
				<div style="border:1px solid #dadada;"><?php echo $TPL_V1["tab_contents_mobile"]?></div>
			</div>
<?php }?>
<?php }?>
	</td>
<?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>
	<td class="its-td-align center">좌동</td>
	<td class="its-td-align center">좌동</td>
<?php }?>
</tr>
<?php }}?>
</tbody>
</table>
<?php }else{?>
잘못된 접근입니다.
<?php }?>