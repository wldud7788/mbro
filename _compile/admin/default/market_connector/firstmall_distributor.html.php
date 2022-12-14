<?php /* Template_ 2.2.6 2022/05/17 12:36:19 /www/music_brother_firstmall_kr/admin/skin/default/market_connector/firstmall_distributor.html 000004178 */ ?>
<div id="distributorLay" class="pd20 hide">
	
	<div class="item-title">판매 정보</div>
	<table class="table_basic thl">
		<tbody>
			<tr>
				<th>판매 마켓</th>
				<td>
					<select name="market" class="width-50per"  id="market">
						<option value="">마켓을 선택하세요</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>판매자 아이디</th>
				<td>
					<select name="sellerId" class="width-50per" id="sellerId">
						<option value="">판매자 아이디를 선택하세요</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="item-title">필수 정보</div>
	<table class="table_basic thl">
		<tbody>
			<tr>
				<th>필수 정보</th>
				<td>
					<select name="addInfo" id="addInfo" class="sellerSelectChk ">
						<option value="">필수정보 템플릿을 선택하세요</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	
	<div class="item-title">상품 정보</div>
	<table class="table_basic thl t_select_goods">
		<tbody>
			<tr>
				<th>상품 검색</th>
				<td>
					<input type="button" value="상품 선택" class="btn_select_goods resp_btn active sellerSelectChk" data-goodstype='distributorGoods' />
					<span class="span_select_goods_del <?php if(count($TPL_VAR["navercheckout"]["distributorGoods"])== 0){?>hide<?php }?>"><input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" selectType="goods" /></span>
					<div class="mt10 wx600 <?php if(count($TPL_VAR["navercheckout"]["distributorGoods"])== 0){?>hide<?php }?>">
						<div class="goods_list_header">
							<table class="table_basic tdc">
								<colgroup>
									<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
									<col width="25%" />
									<col width="45%" />
<?php }else{?>
									<col width="70%" />
<?php }?>

									<col width="20%" />
								</colgroup>
								<tbody>
									<tr>
									<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" onClick="gGoodsSelect.checkAll(this)" value="goods"></label></th>
<?php if(serviceLimit('H_AD')){?>
									<th>입점사명</th>
<?php }?>
									<th>상품명</th>
									<th>판매가</th>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="goods_list">
							<table class="table_basic tdc">
								<colgroup>
									<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
									<col width="25%" />
									<col width="45%" />
<?php }else{?>
									<col width="70%" />
<?php }?>
									<col width="20%" />
								</colgroup>
								<tbody>
									<tr rownum=0 <?php if(count($TPL_VAR["navercheckout"]["except_goods"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
										<td class="center" colspan="4">상품을 선택하세요</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>	
				</td>
			</tr>
			
			<tr>
				<th>중복 전송 여부</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="registed" value="N" class="sellerSelectChk" checked/> 등록상품 제외</label>
						<label><input type="radio" name="registed" value="Y" class="sellerSelectChk"/> 모두등록</label>
					</div>
					<span id="alreadyInfo" class="blue bold"></span>
				</td>
			</tr>
			<tr>
				<th>카테고리 타입</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="categoryType" value="M" class="sellerSelectChk" checked/> 매칭 카테고리</label>
						<label><input type="radio" name="categoryType" value="G" class="sellerSelectChk"/> 필수정보 카테고리</label>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="footer">
		<button type="button" class="resp_btn active size_XL" onclick="addDistributeGoods();">추가</button></span>
		<button type="button" class="resp_btn v3 size_XL" onclick="$('#distributorLay').dialog('close')">취소</button></span>
	</div>
</div>