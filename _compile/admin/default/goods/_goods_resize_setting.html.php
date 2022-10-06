<?php /* Template_ 2.2.6 2022/05/17 12:31:59 /www/music_brother_firstmall_kr/admin/skin/default/goods/_goods_resize_setting.html 000005959 */ ?>
<div>
 <ul>
<?php if($TPL_VAR["multi"]){?>
	<li style="list-style-type:disc;margin-left:20px;" >
		여러 개의 이미지를 한번에 등록 가능합니다.(멀티업로드) <br />예시) 3개 이미지 선택 → 3개의 상품컷으로 자동등록
	</li>
<?php }?>
	<li style="list-style-type:disc;margin-left:20px;" >
		등록되는 이미지는 ↓아래의 사이즈별로 자동 리사이징 됩니다. 권장사이즈 안내
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
		<span class="helpicon" title="<b>일괄등록 사이즈 설정 – 반응형 Default 권장 사이즈 안내</b><br>상품상세(확대) : 가로 800 x (세로 가변)<br>상품상세(기본) : 가로 600 x (세로 가변)<br>리스트(1-大) : 300 x (세로 가변)<br>리스트(2-小) : 190 x (세로 가변)<br>썸네일(상품상세) : 80 x (세로 가변)<br>썸네일(장바구니/주문) : 100 x (세로 가변)<br>썸네일(스크롤) 74 x (세로 가변)"></span>
<?php }else{?>
		<span class="helpicon" title="<b>일괄등록 사이즈 설정 – 권장 사이즈 안내</b><br>상품상세(확대) : 가로 540 x (세로 가변)<br>상품상세(기본) : 가로 250 x (세로 가변)<br>상품상세 - 확장형 : 가로 780 x (세로 가변)<br>리스트(1-大) : 200 x 240(세로 가변)<br>리스트(2-小) : 150 x 180(세로 가변)<br>썸네일(상품상세) : 60 x 60<br>썸네일(장바구니/주문) : 60 x 60<br>썸네일(스크롤) 60 x 60"></span>
<?php }?>
	</li>
	<li style="list-style-type:disc;margin-left:20px;" >
		리사이징 최대 크기와 같거나 큰 이미지를 등록하시기 바랍니다.<span style="color:#999;">( ex. 상품상세(확대)의 가로 사이즈가 800 이라면 가로 800px 상품 이미지 등록 )</span>
	</li>
</ul>
	<table class="info-table-style" style="width:100%" >
		<colgroup> 
			<col width="14%" />
			<col width="14%" />
			<col width="14%" />
			<col width="14%" />
			<col width="15%" />
			<col width="15%" />
			<col width="14%" />
		</colgroup>
		<thead>
		<tr> 
			<th class="its-th-align center">상품상세(확대)</th>
			<th class="its-th-align center">상품상세(기본)</th>
			<th class="its-th-align center">리스트(1)</th>
			<th class="its-th-align center">리스트(2)</th>
			<th class="its-th-align center">썸네일(상품상세)</th>
			<th class="its-th-align center" nowrap>썸네일(장바구니/주문)</th>
			<th class="its-th-align center">썸네일(스크롤)</th>
		</tr>
		<tr>
			<th class="its-th-align center"><input type="text" id="largeImageWidth" size="4" class="line save_image_input " value="<?php echo $TPL_VAR["goodsImageSize"]["large"]["width"]?>"   readonly="readonly" disabled="disabled" >×<input type="text" id="largeImageHeight" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["large"]["height"]?>" readonly="readonly" disabled="disabled" ></th>
			<th class="its-th-align center"><input type="text" id="viewImageWidth" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["view"]["width"]?>" readonly="readonly" disabled="disabled" >×<input type="text" id="viewImageHeight" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["view"]["height"]?>" readonly="readonly" disabled="disabled" ></th>
			<th class="its-th-align center"><input type="text" id="list1ImageWidth" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["list1"]["width"]?>" readonly="readonly" disabled="disabled" >×<input type="text" id="list1ImageHeight" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["list1"]["height"]?>" readonly="readonly" disabled="disabled" ></th>
			<th class="its-th-align center"><input type="text" id="list2ImageWidth" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["list2"]["width"]?>" readonly="readonly" disabled="disabled" >×<input type="text"  id="list2ImageHeight" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["list2"]["height"]?>" readonly="readonly" disabled="disabled" ></th>
			<th class="its-th-align center"><input type="text" id="thumbViewWidth" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbView"]["width"]?>" readonly="readonly" disabled="disabled" >×<input type="text" id="thumbViewHeight" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbView"]["height"]?>" readonly="readonly" disabled="disabled" ></th>
			<th class="its-th-align center"><input type="text" id="thumbCartWidth" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbCart"]["width"]?>" readonly="readonly" disabled="disabled" >×<input type="text" id="thumbCartHeight" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbCart"]["height"]?>" readonly="readonly" disabled="disabled" ></th>
			<th class="its-th-align center"><input type="text" id="thumbScrollWidth" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbScroll"]["width"]?>" readonly="readonly" disabled="disabled" >×<input type="text" id="thumbScrollHeight" size="4" class="line save_image_input" value="<?php echo $TPL_VAR["goodsImageSize"]["thumbScroll"]["height"]?>" readonly="readonly" disabled="disabled" ></th>
		</tr>
		</thead>
	</table>
	<div style="padding:5px 0;margin-left:5px;">
		<label style="cursor:pointer"><input type="checkbox" id="save_image_config_ck" value="y" /> 리사이징 사이즈 수정</label> 
		<span class="btn small gray"><button type="button" class="save_image_config" >저장</button></span>
	</div>
</div>