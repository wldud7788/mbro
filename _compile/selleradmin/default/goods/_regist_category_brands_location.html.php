<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_regist_category_brands_location.html 000008088 */ 
$TPL_categories_1=empty($TPL_VAR["categories"])||!is_array($TPL_VAR["categories"])?0:count($TPL_VAR["categories"]);
$TPL_brands_1=empty($TPL_VAR["brands"])||!is_array($TPL_VAR["brands"])?0:count($TPL_VAR["brands"]);
$TPL_locations_1=empty($TPL_VAR["locations"])||!is_array($TPL_VAR["locations"])?0:count($TPL_VAR["locations"]);?>
<!-- 카테고리 시작 -->
	<a name="01" alt="카테고리"></a>
	<div class="bx-lay" data-bxcode="category">
		<div class="bx-title">
			<div class="item-title">카테고리</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl">
			<tr>
				<th>카테고리 선택</th>
				<td>
					<div class="mb5 right" style="max-width:1000px;">
						<button type="button" id="categoryConnectPopup" class="resp_btn v2">최근 연결 카테고리</button>
					</div>
					<div id="lay_category_select" class="mb5"></div>
				</td>
			</tr>
			<tr>
				<th>선택한 카테고리</th>
				<td>
					<div class="category_list_head">
						<table class="table_basic v7">
						<colgroup>
							<col width="10%" />
							<col width="75%" />
							<col width="15%" />
						</colgroup>
						<thead>
						<tr>
							<th>대표</th>
							<th>카테고리</th>
							<th>삭제</th>
						</tr>
						</thead>
						</table>
					</div>
					<div class="category_list h<?php if(count($TPL_VAR["categories"])> 5){?>5<?php }else{?><?php echo count($TPL_VAR["categories"])?><?php }?>" data-CategoryCnt="<?php if($TPL_VAR["categories"]!=''){?><?php echo count($TPL_VAR["categories"])?><?php }else{?>0<?php }?>">
						<table class="table_basic v7">
						<colgroup>
							<col width="10%" />
							<col width="75%" />
							<col width="15%" />
						</colgroup>
						<thead>
						<tr><th class="hide">대표</th></tr>
						</thead>
						<tbody>
						<tr rownum=0 <?php if(count($TPL_VAR["categories"])== 0||$TPL_VAR["categories"]==""){?>class="show"<?php }else{?>class="hide"<?php }?>>
							<td class="center" colspan="3">카테고리를 선택해 주세요.</td>
						</tr>
<?php if($TPL_categories_1){foreach($TPL_VAR["categories"] as $TPL_V1){?>
						<tr>
							<td class="center">
								<div class="resp_radio">
<?php if($TPL_V1["link"]){?>
									<label><input type="radio" name="firstCategory" value="<?php echo $TPL_V1["category_code"]?>" checked="checked" /></label>
<?php }else{?>
									<label><input type="radio" name="firstCategory" value="<?php echo $TPL_V1["category_code"]?>" /></label>
<?php }?>
								</div>
								<input type="hidden" name="categoryLinkSeq[]" value="<?php echo $TPL_V1["category_link_seq"]?>" />
								<input type="hidden" name="connectCategory[]" value="<?php echo $TPL_V1["category_code"]?>" data-Type='connect' />
							</td>
							<td><?php echo $TPL_V1["title"]?></td>
							<td class="center">
								<button type="button" class="btn_minus"  data-selectType="category" seq="<?php echo $TPL_V1["category_code"]?>" onClick="gCategorySelect.select_delete('minus',$(this))"></button>
							</td>
						</tr>
<?php }}?>
						</tbody>
						</table>
					</div>
				</td>
			</tr>
			</table>
		</div>
	</div>
	<!-- 카테고리 종료 -->

	<!-- 브랜드/지역 시작 -->
	<a name="02" alt="브랜드/지역"></a>
	<div class="bx-lay" data-bxcode="brand">
		<div class="bx-title">
			<div class="item-title">브랜드/지역</div>
			<div class='right'></div>
		</div>
		<div class="cont">
			<table class="table_basic thl">
			<tr>
				<th>브랜드</th>
				<td>
					<div class="mb5 le">
						<button type="button" class="brandConnectPopup resp_btn active " data-selectMode="category">브랜드 선택</button>
						<button type="button" class="brandConnectPopup resp_btn v2" data-selectMode="lastCategory">최근 연결 브랜드</button>
					</div>
					<div class="brand_list">
						<table class="table_basic v7">
						<colgroup>
							<col width="10%" />
							<col width="75%" />
							<col width="15%" />
						</colgroup>
						<thead>
						<tr>
							<th>대표</th>
							<th>브랜드</th>
							<th>삭제</th>
						</tr>
						</thead>
						<tbody>
						<tr rownum=0 <?php if(count($TPL_VAR["brands"])== 0||$TPL_VAR["brands"]==""){?>class="show"<?php }else{?>class="hide"<?php }?>>
							<td class="center" colspan="3">브랜드를 선택해 주세요.</td>
						</tr>
<?php if($TPL_brands_1){foreach($TPL_VAR["brands"] as $TPL_V1){?>
						<tr>
							<td class="center">
									<input type="hidden" name="brandLinkSeq[]" value="<?php echo $TPL_V1["category_link_seq"]?>" />
<?php if($TPL_V1["link"]){?>
								<label class="resp_radio"><input type="radio" name="firstBrand" value="<?php echo $TPL_V1["category_code"]?>" checked="checked" /></label>
<?php }else{?>
								<label class="resp_radio"><input type="radio" name="firstBrand" value="<?php echo $TPL_V1["category_code"]?>" /></label>
<?php }?>
								<input type="hidden" name="connectBrand[]" value="<?php echo $TPL_V1["category_code"]?>" data-Type='connect' />
							</td>
							<td><?php echo $TPL_V1["title"]?></td>
							<td class="center">
								<button type="button" class="btn_minus"  data-selectType="brand" seq="<?php echo $TPL_V1["category_code"]?>" onClick="gCategorySelect.select_delete('minus',$(this))"></button>
							</td>
						</tr>
<?php }}?>
						</tbody>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<th>지역</th>
				<td>
					<div class="resp_checkbox">
						<label><input type="checkbox" name="location_setting" value='y'> 지역 설정</label>
					</div>
					<div class="sub_cont hide">
						<div class="mb5 le">
<?php if(serviceLimit('H_FR')){?>
							<button type="button" class="resp_btn v2  " onclick="<?php echo serviceLimit('A1')?>">지역 선택</button>
<?php }else{?>
							<button type="button" class="locationConnectPopup resp_btn active " data-selectMode="category">지역 선택</button>
<?php }?>
							<button type="button" class="locationConnectPopup resp_btn v2" data-selectMode="lastCategory">최근 연결 지역</button>
						</div>
						<div class="location_list">
							<table class="table_basic">
							<colgroup>
								<col width="10%" />
								<col width="75%" />
								<col width="15%" />
							</colgroup>
							<thead>
							<tr>
								<th>대표</th>
								<th>지역</th>
								<th>삭제</th>
							</tr>
							</thead>
							<tbody>
							<tr rownum=0 <?php if(count($TPL_VAR["locations"])== 0||$TPL_VAR["locations"]==""){?>class="show"<?php }else{?>class="hide"<?php }?>>
								<td class="center" colspan="3">지역을 선택해 주세요.</td>
							</tr>
<?php if($TPL_locations_1){foreach($TPL_VAR["locations"] as $TPL_V1){?>
							<tr>
								<td class="center">
										<input type="hidden" name="locationLinkSeq[]" value="<?php echo $TPL_V1["location_link_seq"]?>" />
<?php if($TPL_V1["link"]){?>
									<label class="resp_radio"><input type="radio" name="firstLocation" value="<?php echo $TPL_V1["location_code"]?>" checked="checked" /></label>
<?php }else{?>
									<label class="resp_radio"><input type="radio" name="firstLocation" value="<?php echo $TPL_V1["location_code"]?>" /></label>
<?php }?>
									<input type="hidden" name="connectLocation[]" value="<?php echo $TPL_V1["location_code"]?>" data-Type='connect' />
								</td>
								<td><?php echo $TPL_V1["title"]?></td>
								<td class="center">
									<button type="button" class="btn_minus"  data-selectType="location" seq="<?php echo $TPL_V1["location_code"]?>" onClick="gCategorySelect.select_delete('minus',$(this))"></button>
								</td>
							</tr>
<?php }}?>
							</tbody>
							</table>
						</div>
					</div>
				</td>
			</tr>
			</table>
		</div>
	</div>
	<!-- 브랜드 종료 -->