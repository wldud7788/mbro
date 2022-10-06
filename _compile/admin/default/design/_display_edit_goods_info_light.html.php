<?php /* Template_ 2.2.6 2022/05/17 12:31:41 /www/music_brother_firstmall_kr/admin/skin/default/design/_display_edit_goods_info_light.html 000001438 */ 
$TPL_fileList_1=empty($TPL_VAR["fileList"])||!is_array($TPL_VAR["fileList"])?0:count($TPL_VAR["fileList"]);?>
<tr>
			<th class="dsts-th">
				<div class="mb10">상품정보</div>
				<span class="btn small cyanblue"><button type="button" onclick="openDialog('상품정보 노출 조건', '#displayGoodsInfoCondition', {'width':'930', 'height':'700', 'show':'fade', 'hide':'fade'});">노출 조건 안내</button></span>
			</th>
			<td class="dsts-td left" style="padding:0;" colspan="2">
				<input type="radio" class="hide decoration_type" name="goods_decoration_type" value="favorite" checked />
				<div class="clearbox">
<?php if($TPL_fileList_1){foreach($TPL_VAR["fileList"] as $TPL_V1){?>
					<label class="resp_info_select">
					<input type="radio" class="hide goods_info_style" name="goods_info_style" value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_VAR["data"]["goods_decoration_favorite_key"]==$TPL_V1["name"]){?>checked<?php }?>/>
					<div data-type="<?php echo $TPL_V1["name"]?>" style="display: inline-flex; flex-direction: row;" class="hand goods_file_list <?php if($TPL_VAR["data"]["goods_decoration_favorite_key"]==$TPL_V1["name"]){?>current<?php }?>"><?php echo $TPL_V1["contents"]?></div>
					</label>
<?php }}?>
				</div>
			</td>
		</tr>