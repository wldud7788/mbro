<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_goods_resize_setting.html 000003795 */ ?>
<div class="content">
	<table class="table_basic mt5" >
		<colgroup> 
			<col width="35%" />
			<col width="65%" />
		</colgroup>
		<tr> 
			<th>대표 사진</th>
			<td>
				가로 <input type="text" id="viewImageWidth" size="4" class="save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["view"]["width"]?>" readonly="readonly" disabled="disabled" > px 로 자동 리사이징
				<input type="text" id="viewImageHeight" size="4" class="save_image_input hide" value="<?php echo $TPL_VAR["goodsImageSize"]["view"]["height"]?>" readonly="readonly" disabled="disabled" ></td>
		</tr>
		<tr> 
			<th>상품상세(확대)</th>
			<td>가로 <input type="text" id="largeImageWidth" size="4" class="save_image_input " value="<?php echo $TPL_VAR["goodsImageSize"]["large"]["width"]?>"   readonly="readonly" disabled="disabled" >
				<input type="text" id="largeImageHeight" size="4" class="save_image_input hide" value="<?php echo $TPL_VAR["goodsImageSize"]["large"]["height"]?>" readonly="readonly" disabled="disabled" > px 로 자동 리사이징
			</td>
		</tr>
		<tr> 
			<th>리스트(1)</th>
			<td>가로 <input type="text" id="list1ImageWidth" size="4" class="save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["list1"]["width"]?>" readonly="readonly" disabled="disabled" >
			<input type="text" id="list1ImageHeight" size="4" class="save_image_input hide" value="<?php echo $TPL_VAR["goodsImageSize"]["list1"]["height"]?>" readonly="readonly" disabled="disabled" > px 로 자동 리사이징</td>
		</tr>
		<tr> 
			<th>리스트(2)</th>
			<td>가로 <input type="text" id="list2ImageWidth" size="4" class="save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["list2"]["width"]?>" readonly="readonly" disabled="disabled" >
			<input type="text"  id="list2ImageHeight" size="4" class="save_image_input hide" value="<?php echo $TPL_VAR["goodsImageSize"]["list2"]["height"]?>" readonly="readonly" disabled="disabled" > px 로 자동 리사이징</td>
		</tr>
		<tr> 
			<th>상품상세(썸네일))</th>
			<td>가로 <input type="text" id="thumbViewWidth" size="4" class="save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbView"]["width"]?>" readonly="readonly" disabled="disabled" >
			<input type="text" id="thumbViewHeight" size="4" class="save_image_input hide" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbView"]["height"]?>" readonly="readonly" disabled="disabled" > px 로 자동 리사이징</td>
		</tr>
		<tr> 
			<th nowrap>장바구니/주문(썸네일)</th>
			<td>가로 <input type="text" id="thumbCartWidth" size="4" class="save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbCart"]["width"]?>" readonly="readonly" disabled="disabled" >
			<input type="text" id="thumbCartHeight" size="4" class="save_image_input hide" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbCart"]["height"]?>" readonly="readonly" disabled="disabled" > px 로 자동 리사이징</td>
		</tr>
		<tr> 
			<th>스크롤</th>
			<td>가로 <input type="text" id="thumbScrollWidth" size="4" class="save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbScroll"]["width"]?>" readonly="readonly" disabled="disabled" >
			<input type="text" id="thumbScrollHeight" size="4" class="save_image_input hide" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbScroll"]["height"]?>" readonly="readonly" disabled="disabled" > px 로 자동 리사이징</td>
		</tr>
	</table>
</div>

<div class="footer">
	<button type="button" class="resp_btn v3 size_XL" onClick="closeDialog('goods_resize_formlay')">닫기</button>
</div>