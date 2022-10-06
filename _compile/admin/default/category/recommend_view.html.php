<?php /* Template_ 2.2.6 2022/05/17 12:31:01 /www/music_brother_firstmall_kr/admin/skin/default/category/recommend_view.html 000003117 */ 
$TPL_display_tabs_1=empty($TPL_VAR["display_tabs"])||!is_array($TPL_VAR["display_tabs"])?0:count($TPL_VAR["display_tabs"]);?>
<?php if($TPL_VAR["display_tabs"]){?>
	<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0" id="inner_html">
	<colgroup>
		<col width="5%" />
		<col width="20%" />
		<col width="15%" />
		<col width="" />
	</colgroup>
	<tbody class="ltb">
<?php if($TPL_display_tabs_1){$TPL_I1=-1;foreach($TPL_VAR["display_tabs"] as $TPL_V1){$TPL_I1++;?>
		<tr class="group_item<?php echo $TPL_I1?>" idx_num="<?php echo $TPL_I1?>" >
		<td class="its-td-align center">
		<span class="strTab">[탭<span class="strTabIdx"><?php echo $TPL_I1+ 1?></span>]</span>
<?php if($TPL_V1["contents_type"]=='auto'){?>
		자동 <div class="desc">고객의 최근 행동<br />또는 관리자 지정<br />기준</div>
<?php }elseif($TPL_V1["contents_type"]=='auto_sub'){?>
		자동(2) <div class="desc">고객의 현재<br />보고 있는 상품<br />기준</div>
<?php }elseif($TPL_V1["contents_type"]=='select'){?>
		직접 선정 <div class="desc">관리자가<br />지정한 상품</div>
<?php }elseif($TPL_V1["contents_type"]=='text'){?>
		입력 <div class="desc">관리자가<br />해당 영역을 꾸밈</div>
<?php }?>
		</td>
		<td class="its-td-align center" style="vertical-align:middle;">
<?php if($TPL_V1["contents_type"]=='auto'||$TPL_V1["contents_type"]=='auto_sub'){?>
<?php if($TPL_V1["auto_criteria_desc"]){?>
				<?php echo $TPL_V1["auto_criteria_desc"]?>

<?php }else{?>
				설정된 조건이 없습니다.
<?php }?>
<?php }elseif($TPL_V1["contents_type"]=='select'){?>
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
<?php }elseif($TPL_V1["contents_type"]=='text'){?>
		<div class="displayTabAutoTypeContainer" type="text">
			* 데스크탑/태블릿用
			<div style="border:1px solid #dadada;"><?php echo $TPL_V1["tab_contents"]?></div>
		</div>
		<div class="displayTabAutoTypeContainer tab_contents_mobile" type="text">
			* 모바일用
			<div style="border:1px solid #dadada;"><?php echo $TPL_V1["tab_contents_mobile"]?></div>
		</div>
<?php }?>
		</td>
		</tr>
<?php }}?>
	</tbody>
	</table>
<?php }else{?>
미사용
<?php }?>