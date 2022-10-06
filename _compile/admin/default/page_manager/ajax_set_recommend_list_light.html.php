<?php /* Template_ 2.2.6 2022/05/17 12:36:46 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/ajax_set_recommend_list_light.html 000003787 */ 
$TPL_target_list_1=empty($TPL_VAR["target_list"])||!is_array($TPL_VAR["target_list"])?0:count($TPL_VAR["target_list"]);?>
<?php if($TPL_VAR["target_list"]){?>
<?php if($TPL_target_list_1){$TPL_I1=-1;foreach($TPL_VAR["target_list"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
<?php if($TPL_V1["display_tabs"]&&count($TPL_V1["display_tabs"])> 0){?>
<?php if(is_array($TPL_R2=$TPL_V1["display_tabs"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
				<tr class="group_item<?php echo $TPL_I1?>" idx_num="<?php echo $TPL_I1?>" >
<?php if($TPL_I2== 0){?>
					<td class="its-td-align center" rowspan="<?php echo $TPL_V1["tabs_row"]?>">
						<input type="checkbox" class="chk" name="code[]" value="<?php echo $TPL_K1?>" />
					</td>
					<td class="its-td-align center" rowspan="<?php echo $TPL_V1["tabs_row"]?>"><?php echo $TPL_V1["title"]?></td>
<?php }?>
					<td class="its-td-align center">
<?php if(count($TPL_V1["display_tabs"])> 1){?>
						<span class="strTab">[탭<span class="strTabIdx"><?php echo $TPL_I2+ 1?></span>]</span>
<?php }?>

<?php if($TPL_V2["contents_type"]=='auto'){?>
						자동
<?php }elseif($TPL_V2["contents_type"]=='auto_sub'){?>
						자동(2)
<?php }elseif($TPL_V2["contents_type"]=='select'){?>
						직접선정
<?php }elseif($TPL_V2["contents_type"]=='text'){?>
						입력
<?php }?>
					</td>
					<td class="its-td-align center" style="vertical-align:middle;">
<?php if($TPL_V2["contents_type"]=='auto'||$TPL_V2["contents_type"]=='auto_sub'){?>
<?php if($TPL_V2["auto_criteria_desc"]){?>
						<?php echo $TPL_V2["auto_criteria_desc"]?>

<?php }else{?>
						설정된 조건이 없습니다.
<?php }?>
<?php }elseif($TPL_V2["contents_type"]=='select'){?>
<?php if(is_array($TPL_R3=$TPL_V2["items"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
						<div class='goods fl'>
							<div align='center' class='image'><img src="<?php echo $TPL_V3["image"]?>" class="goodsThumbView" width="50" height="50" alt="<?php echo htmlspecialchars($TPL_V3["goods_name"])?>" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif'" /></div>
							<div align='center' class='name' style='width:70px;overflow:hidden;white-space:nowrap;'><?php echo htmlspecialchars($TPL_V3["goods_name"])?></div>
							<div align='center' class='price'><?php echo get_currency_price($TPL_V3["price"])?></div>
<?php if(serviceLimit('H_AD')){?>
							<div align='center' class='provider_name red'><?php echo $TPL_V3["provider_name"]?></div>
<?php }?>
						</div>
<?php }}?>
<?php }elseif($TPL_V2["contents_type"]=='text'){?>
						<div class="displayTabAutoTypeContainer" type="text">
							<div style="border:1px solid #dadada;"><?php echo $TPL_V2["tab_contents"]?></div>
						</div>
<?php }?>
					</td>
				</tr>
<?php }}?>
<?php }else{?>
				<tr>
					<td class="its-td-align center" rowspan="<?php echo $TPL_V1["tabs_row"]?>">
						<input type="checkbox" class="chk" name="code[]" value="<?php echo $TPL_K1?>" />
					</td>
					<td class="its-td-align center" rowspan="<?php echo $TPL_V1["tabs_row"]?>"><?php echo $TPL_V1["title"]?></td>
					<td class="its-td-align center"><span class="desc">등록가능</span></td>
					<td class="its-td-align center"><span class="desc">등록가능</span></td>
				</tr>
<?php }?>
<?php }}?>
<?php }else{?>
<?php if($TPL_VAR["target_code"]){?>
<tr>
	<td class="its-td-align center" colspan="4">대상이 없습니다.</td>
</tr>
<?php }else{?>
<tr>
	<td class="its-td-align center" colspan="4">대상을 먼저 선택하여 주세요.</td>
</tr>
<?php }?>
<?php }?>