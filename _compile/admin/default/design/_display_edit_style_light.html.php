<?php /* Template_ 2.2.6 2022/05/17 12:31:42 /www/music_brother_firstmall_kr/admin/skin/default/design/_display_edit_style_light.html 000002213 */ 
$TPL_goodsImageSizes_1=empty($TPL_VAR["goodsImageSizes"])||!is_array($TPL_VAR["goodsImageSizes"])?0:count($TPL_VAR["goodsImageSizes"]);?>
<tr style="height:150px">
			<th class="dsts-th" style="border-top:none">
				스타일 <span class="helpicon" title="모바일, 데스크탑 등 모든 화면 사이즈에 최적화"></span>
			</th>
			<td colspan="2" class="table_td_left table_td_bottom pdl20" height="180px">
				<div class="imageCheckboxItem"><label><input type="radio" name="style" value="sizeswipe" <?php if($TPL_VAR["data"]["style"]=='sizeswipe'){?>checked="checked"<?php }?> /><img src="/admin/skin/default/images/design/m_img_display_sizeswipe.gif" width="230px" title="슬라이드형(크기고정)" /></label></div>
				<div class="imageCheckboxItem" style="">&nbsp;</div>
				<div class="imageCheckboxItem"><label><input type="radio" name="style" value="responsible" <?php if($TPL_VAR["data"]["style"]=='responsible'){?>checked="checked"<?php }?> /><img src="/admin/skin/default/images/design/m_img_display_lattice_responsible.gif" width="230px" title="격자형(반응형)" /></label></div>
			</td>
		</tr>
		<tr>
			<th class="dsts-th">노출 개수</th>
			<td colspan="2" class="dsts-td left table_td_bottom">
				<input type="text" name="count_r" value="<?php if($TPL_VAR["data"]["count_r"]){?><?php echo $TPL_VAR["data"]["count_r"]?><?php }else{?>8<?php }?>" class="line" size="2" maxlength="2" /> / 20 개
			</td>
		</tr>
		<tr>
			<th class="dsts-th">이미지 사이즈</th>
			<td colspan="2" class="dsts-td left table_td_bottom">
				<select name="image_size" class="image_size">
<?php if($TPL_goodsImageSizes_1){foreach($TPL_VAR["goodsImageSizes"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>" width="<?php echo $TPL_V1["width"]?>" height="<?php echo $TPL_V1["height"]?>" <?php if($TPL_K1==$TPL_VAR["data"]["image_size"]||(!$TPL_VAR["data"]["image_size"]&&$TPL_K1=='list2')){?>selected="selected"<?php }?> ><?php echo $TPL_V1['name']?></option>
<?php }}?>
				</select>
			</td>
		</tr>