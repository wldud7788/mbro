<?php /* Template_ 2.2.6 2022/05/12 12:17:12 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/_batch_modify_selector.html 000035083 */ 
$TPL_r_hscode_1=empty($TPL_VAR["r_hscode"])||!is_array($TPL_VAR["r_hscode"])?0:count($TPL_VAR["r_hscode"]);
$TPL_info_loop_1=empty($TPL_VAR["info_loop"])||!is_array($TPL_VAR["info_loop"])?0:count($TPL_VAR["info_loop"]);
$TPL_icons_1=empty($TPL_VAR["icons"])||!is_array($TPL_VAR["icons"])?0:count($TPL_VAR["icons"]);?>
<div class="item-title">업데이트 항목</div>
<table class="table_basic thl batch_table wp70" cellspacing="0">
	<tbody class="ltb">
	<tr>
		<th>직접/조건 선택</th>
		<td>
			<select id="ifdirect" name="ifdirect">
				<option value="if" <?php echo $TPL_VAR["ifdirect"]["selected"]["if"]?>>조건</option>
				<option value="direct" <?php echo $TPL_VAR["ifdirect"]["selected"]["direct"]?>>직접</option>
			</select>
			<select id="batchmodify_selector_if" class="batchmodify_select <?php echo $TPL_VAR["ifdirect"]["hide"]["if"]?>">
				<option value="">-선택하세요-</option>
<?php if(is_array($TPL_R1=$TPL_VAR["batchmodify_selector"]["if"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
				<option value="<?php echo $TPL_K1?>" <?php echo $TPL_V1["selected"]?>><?php echo str_pad(($TPL_I1+ 1), 2,'0',$TPL_VAR["STR_PAD_LEFT"])?>. <?php echo $TPL_V1["text"]?>

				</option>
<?php }}?>
			</select>
			<select id="batchmodify_selector_direct" class="batchmodify_select <?php echo $TPL_VAR["ifdirect"]["hide"]["direct"]?>">
				<option value="">-선택하세요-</option>
<?php if(is_array($TPL_R1=$TPL_VAR["batchmodify_selector"]["direct"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
				<option value="<?php echo $TPL_K1?>" <?php echo $TPL_V1["selected"]?>><?php echo str_pad(($TPL_I1+ 1), 2,'0',$TPL_VAR["STR_PAD_LEFT"])?>. <?php echo $TPL_V1["text"]?>

				</option>
<?php }}?>
			</select>
			<input type="hidden" name="batchmodify_selector" id="batchmodify_selector" value="<?php echo $TPL_VAR["mode"]?>" />
		</td>
	</tr>
<?php if(!$TPL_VAR["ifdirect"]["selected"]["if"]==''){?>
	<tr>
		<th>
			<select name="modify_list">
				<option value="choice">선택 상품</option>
				<option value="all">전체 상품</option>
			</select>
		</th>
		<td>
<?php if(!$TPL_VAR["diff_layout"]){?>
			<table class="table_basic v7 thl wx700">
				<colgroup>
					<col width="5%" />
					<col width="20%" />
					<col width="75%"  />
				</colgroup>
				<tr>
					<th class="center"><label class="resp_checkbox"><input type="checkbox" id="ifchkAll" /></label>
					</th>
					<th class="center">항목명</th>
					<th class="center">내용</th>
				</tr>
<?php if($TPL_VAR["mode"]=='ifgoods'){?>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_goods_name_yn"
																		   value="1" /></label></td>
					<td>상품명</td>
					<td><input type='text' name="batch_goods_name" value="" class="wp85"></td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_color_pick_yn"
																		   value="1" /></label></td>
					<td>검색용 색상</td>
					<td>
						<div class="color-check pd3">
<?php if(is_array($TPL_R1=$TPL_VAR["arr_common"]['colorPickList'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<label style="background-color:#<?php echo $TPL_V1["code"]?>;margin:1px;" class=" <?php if($TPL_V1["select"]){?>active<?php }?>"
								   alt="<?php echo $TPL_V1["name"]?>" title="<?php echo $TPL_V1["name"]?>"><input type="checkbox" name="batch_color_pick[]"
																		class="all_color_pick_value" value="<?php echo $TPL_V1["code"]?>" <?php if($TPL_V1["select"]){?>checked<?php }?>
								apply_target="color_pick" /></label>
<?php }}?>
						</div>
					</td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_keyword_yn"
																		   value="1" /></label></td>
					<td>검색어</td>
					<td><input type='text' name="batch_keyword" value="" class="wp85"></td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_grade_sale_yn"
																		   value="1" /></label></td>
					<td>회원 등급별 할인</td>
					<td>
						<select name="batch_grade_sale" class="batch_grade_sale resp_select" style="width:120px;">
<?php if(is_array($TPL_R1=$TPL_VAR["arr_common"]['sale_list'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["sale_seq"]?>"><?php echo $TPL_V1["sale_title"]?></option>
<?php }}?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_tax_yn" value="1" /></label>
					</td>
					<td>과세/비과세</td>
					<td>
						<select name="batch_tax" class="batch_tax line resp_select" style="width:120px;">
							<option value="tax">과세</option>
							<option value="exempt">비과세</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_summary_yn"
																		   value="1" /></label></td>
					<td>간략 설명</td>
					<td><input type='text' name="batch_summary" value="" class="wp85"></td>
				</tr>
<?php }elseif($TPL_VAR["mode"]=='ifstatus'){?>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_goods_view_yn"
																		   value="1" /></label></td>
					<td>노출/미노출</td>
					<td>
						<select name="batch_goods_view" class="batch_goods_view">
							<option value="look">노출</option>
							<option value="notLook">미노출</option>
						</select>
						<span class="resp_message ml10">노출 예약 상품은 수정되지 않습니다.</span>
					</td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_goods_status_yn"
																		   value="1" /></label></td>
					<td>상태</td>
					<td>
						<select name="batch_goods_status" class="batch_goods_status">
							<option value="normal_runout">정상/품절</option>
							<option value="purchasing">재고확보중</option>
							<option value="unsold">판매중지</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_runout_type_yn"
																		   value="1" /></label></td>
					<td>재고에 따른 판매 여부</td>
					<td>
						<!--재고연동판매-->
						<select name="batch_runout_type" class="batch_runout_type runout_type">
							<option value='shop'>통합정책</option>
							<option value='goods'>개별정책</option>
						</select>
						<div style="display:inline-block;" class="runout_layout">
							<div class="runout_span hide ml5">
								<select name="batch_runout_policy" class="runout_policy">
									<option value='stock'>재고연동</option>
									<option value='ableStock'>가용재고연동</option>
									<option value='unlimited'>재고무관</option>
								</select>
								<input type="text" size="4" name="batch_able_stock_limit" value="0" />
							</div>
						</div>
						<span class="runout_span2 mt5 ml5 resp_message">
									<!-- 통합정책 상세 -->
<?php if($TPL_VAR["config_runout"]=="stock"){?>
									(재고가 1 이상일 때 판매)
<?php }elseif($TPL_VAR["config_runout"]=="ableStock"){?>
									(가용재고가 <?php echo number_format($TPL_VAR["config_ableStockLimit"])?> 이상일 때 판매)
<?php }else{?>
									(재고와 상관없이 판매)
<?php }?>
								</span>
					</td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_adult_goods_yn"
																		   value="1" /></label></td>
					<td>성인 인증</td>
					<td>
						<select name="batch_adult_goods" class="batch_adult_goods">
							<option value="N">사용 안 함</option>
							<option value="Y">사용</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item"
																		   name="batch_option_international_shipping_status_yn" value="1" /></label></td>
					<td>개인통관고유부호</td>
					<td>
						<select name="batch_option_international_shipping_status"
								class="batch_option_international_shipping_status">
							<option value="N">수집 안 함</option>
							<option value="Y">수집</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_cancel_type_yn"
																		   value="1" /></label></td>
					<td>청약철회</td>
					<td>
						<select name="batch_cancel_type" class="batch_cancel_type ">
							<option value="0">가능</option>
							<option value="1">불가</option>
						</select>
					</td>
				</tr>
<?php }elseif($TPL_VAR["mode"]=='ifgoodsetc'){?>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_goodscode_yn"
																		   value="1" /></label></td>
					<td>기본코드</td>
					<td>
						자동생성
					</td>
				</tr>
				<tr>
					<td class="center">
						<label class="resp_checkbox"><input type="checkbox"
															class="resp_text ifchk batch_update_item" name="batch_weight_yn"
															value="1" /></label>
					</td>
					<td>무게</td>
					<td>
						<input type="text" name="batch_weight_value" class="onlyfloat" size="4" /> Kg
					</td>
				</tr>
				<tr>
					<td class="center">
						<label class="resp_checkbox"><input type="checkbox"
															class="resp_text ifchk batch_update_item" name="batch_stock_yn" value="1" />
						</label>
					</td>
					<td>재고</td>
					<td>
						<input type="text" name="batch_stock_value" class="onlynumber" size="4"> 개
					</td>
				</tr>
				<tr>
					<td class="center">
						<label class="resp_checkbox"><input type="checkbox"
															class="resp_text ifchk batch_update_item" name="batch_badstock_yn"
															value="1" /></label>
					</td>
					<td>불량재고</td>
					<td>초기화 (0)</td>
				</tr>
				<tr>
					<td class="center">
						<label class="resp_checkbox"><input type="checkbox"
															class="resp_text ifchk batch_update_item" name="batch_safe_stock_yn" value="1" />
						</label>
					</td>
					<td>안전재고</td>
					<td>
						<input type="text" name="batch_safe_stock_value" class="onlynumber" size="4"> 개
					</td>
				</tr>
<?php }elseif($TPL_VAR["mode"]=='ifprice'){?>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_consumer_price_yn"
																		   value="1" /></label></td>
					<td>정가</td>
					<td>
						<input type="text" name="batch_consumer_price" value="" class="onlyfloat" size="10" />
						<select name="batch_consumer_price_unit">
							<option value="percent">%</option>
							<option value="won"><?php echo $TPL_VAR["basic_currency"]?></option>
						</select>
						만큼
						<select name="batch_consumer_price_updown">
							<option value="up">+ 조정</option>
							<option value="down">- 조정</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_price_yn" value="1" /></label>
					</td>
					<td>판매가</td>
					<td>
						<input type="text" name="batch_price" value="" class="onlyfloat" size="10" />
						<select name="batch_price_unit">
							<option value="percent">%</option>
							<option value="won"><?php echo $TPL_VAR["basic_currency"]?></option>
						</select>
						만큼
						<select name="batch_price_updown">
							<option value="up">+ 조정</option>
							<option value="down">- 조정</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_option_view_yn"
																		   value="1" /></label></td>
					<td>옵션 노출</td>
					<td>
						<select name="batch_option_view" class="line">
							<option value="Y">노출</option>
							<option value="N">미노출</option>
						</select>
					</td>
				</tr>
<?php }elseif($TPL_VAR["mode"]=='hscode'){?>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_hscode_yn"
																		   value="1" /></label></td>
					<td>HS CODE</td>
					<td>
						<select name="batch_hscode_selector">
							<option value="0">선택</option>
<?php if($TPL_r_hscode_1){foreach($TPL_VAR["r_hscode"] as $TPL_V1){?><option value="<?php echo $TPL_V1["hscode_common"]?>"><?php echo $TPL_V1["hscode_name"]?>(<?php echo $TPL_V1["hscode_common"]?>)</option>
<?php }}?>
						</select>
						<input type="hidden" class="hscode_common" name="hscode_common" />
					</td>
				</tr>
<?php }elseif($TPL_VAR["mode"]=='multidiscount'){?>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_multidiscount"
																		   value="1" /></label></td>
					<td>구매 수량 할인</td>
					<td>
						<div class="resp_radio" id="promotionViewSet">
							<label><input type="radio" name="multiDiscountSet" value="y" /> 사용</label>
							<label><input type="radio" name="multiDiscountSet" value="" checked /> 사용 안함</label>
						</div>
						<div class="multiDiscountLay wx500 <?php if(!$TPL_VAR["goods"]["multi_discount_policy"]){?>hide<?php }?>">
							<input type="hidden" name="discountUnit" id="discountUnit"
								   value="<?php echo $TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]?>" />
							<!-- 대량구매 설정 -->
							<table class="table_basic" id="multiDiscountTable">
								<colgroup>
									<col width="50%" />
									<col width="40%" />
									<col width="10%" />
								</colgroup>
								<thead>
								<tr>
									<th>상품수량</th>
									<th>
										할인
										<select name="discountUnit" class="line">
											<option value="PER" selected>%</option>
											<option value="PRI"><?php echo $TPL_VAR["config_system"]['basic_currency']?></option>
										</select>
									</th>
									<th><button type="button" class="addDiscountSet btn_plus"></button></th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td>
										<input type="text" name="discountOverQty[]" value="2"
											   class="resp_text onlynumber" size="4" maxlength="5" /> 개 이상
										<span class="discount_under_qty hide">
														<input type="text" name="discountUnderQty[]" value=""
															   class="line onlynumber" size="4" maxlength="5" /> 개 미만
													</span>
									</td>
									<td>
										<input type="text" name="discountAmount[]" value="0"
											   class="resp_text onlynumber right" size="7" maxlength="10" />
										<span class="discount_unit"><?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]=='PRI'){?><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> / 1개<?php }else{?>%<?php }?></span>
									</td>
									<td class="center">
													<span class=""><button type="button"
																		   class="delDiscountSet btn_minus"></button></span></td>
								</tr>
								</tbody>
								<tfoot
										class="center max_qty_set <?php if($TPL_VAR["goods"]["multi_discount_policy_count"]<= 1){?>hide<?php }?>">
								<tr>
									<td class="left">
										<input type="text" name="discountMaxOverQty"
											   value="<?php echo $TPL_VAR["goods"]["multi_discount_policy"]["discountMaxOverQty"]?>"
											   class="resp_text onlynumber readonly-color" size="4" maxlength="5"
											   readonly /> 개 이상
									</td>
									<td class="left">
										<input type="text" name="discountMaxAmount"
											   value="<?php echo $TPL_VAR["goods"]["multi_discount_policy"]["discountMaxAmount"]?>"
											   class="resp_text onlynumber right" size="7" maxlength="10" />
										<span class="discount_unit"><?php if($TPL_VAR["goods"]["multi_discount_policy"]["discountUnit"]=='PRI'){?><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> / 1개<?php }else{?>%<?php }?></span>
									</td>
									<td></td>
								<tr>
								</tfoot>
							</table>
							<div class="center hide" style="padding:10px;"><span class="btn large black"><button
									type="button" id="applyMultiDiscountBtn">적용하기</button></span></div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_min_limit"
																		   value="1" /></label></td>
					<td>최소 구매 수량</td>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="minPurchaseLimit" value="unlimit"
										  onclick="chgPurchaseType(this);" checked="checked"> 최소 1개</label>
							<label><input type="radio" name="minPurchaseLimit" value="limit"
										  onclick="chgPurchaseType(this);" /> 최소
								<input type="text" name="minPurchaseEa" size="3" class="onlynumber" value="2"
									   disabled="disabled" onblur="chkPurchaseEa(this);" />개 이상 구매 가능</label>
						</div>
					</td>
				</tr>
				<tr>
					<td class="center"><label class="resp_checkbox"><input type="checkbox"
																		   class="resp_text ifchk batch_update_item" name="batch_max_limit"
																		   value="1" /></label></td>
					<td>최대 구매 수량</td>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="maxPurchaseLimit" value="unlimit"
										  onclick="chgPurchaseType(this);" checked="checked" /> 제한 없음</label>
							<label><input type="radio" name="maxPurchaseLimit" value="limit"
										  onclick="chgPurchaseType(this);" /> 최대
								<input type="text" name="maxPurchaseEa" size="3" class="onlynumber" value="1"
									   disabled="disabled" onblur="chkPurchaseEa(this);" />개 이하 구매 가능</label>
						</div>
					</td>
				</tr>
<?php }?>
			</table>
<?php }else{?>
<?php if($TPL_VAR["mode"]=='shipping'){?>
			<table class="table_basic v7 wx700">
				<tr>
					<th class="center" style="width:160px">항목명</th>
					<th class="center">배송비</th>
				</tr>
				<tr>
					<th>배송 정책</th>
					<td>
						<input type="hidden" name="sel_provider_seq" value="<?php echo $TPL_VAR["provider_seq"]?>" />
						<select id="shipping_grp_sel" name="sel_shipping_group_seq">
						</select>
					</td>
				</tr>
			</table>
<?php }elseif($TPL_VAR["mode"]=='category'){?>
			<table class="table_basic v7 thl wx1000">
				<colgroup>
					<col style="width:20%" />
					<col />
				</colgroup>
				<tr>
					<th></th>
					<th class="center">항목명</th>
				</tr>
				<tr>
					<th>구분</th>
					<td>
						<select name="target_modify">
							<option value="category">카테고리</option>
							<option value="brand">브랜드</option>
							<option value="location">지역</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>연결/해제</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="connect" value="connect" checked /> 연결</label>
							<label><input type="radio" name="connect" value="disconnect" /> 해제</label>
						</div>
					</td>
				</tr>
				<tr class="if_category">
					<th>연결 설정</th>
					<td>
						<div class="category_connect connect_setting">
							<div class="resp_radio">
								<label><input type="radio" name="search_category_mode" value="add" checked /> 카테고리 추가 연결</label>
								<label><input type="radio" name="search_category_mode" value="move" /> 카테고리 삭제 후 연결</label>
								<label><input type="radio" name="search_category_mode" value="copy" /> 상품 복사 후 카테고리 연결</label>
							</div>
						</div>
						<div class="category_disconnect connect_setting hide">
							<div class="resp_radio">
								<label><input type="radio" name="search_category_mode" value="del" /> 해당 카테고리 연결 해제</label>
								<label><input type="radio" name="search_category_mode" value="all_del" /> 모든 카테고리 연결 해제</label>
							</div>
						</div>
					</td>
				</tr>
				<tr class="if_brand hide">
					<th>연결 설정</th>
					<td>
						<div class="brand_connect connect_setting">
							<div class="resp_radio">
								<label><input type="radio" name="search_brand_mode" value="add" checked /> 브랜드 추가 연결</label>
								<label><input type="radio" name="search_brand_mode" value="move" /> 브랜드 삭제 후 연결</label>
								<label><input type="radio" name="search_brand_mode" value="copy" /> 상품 복사 후 브랜드 연결</label>
							</div>
						</div>
						<div class="brand_disconnect connect_setting">
							<div class="resp_radio">
								<label><input type="radio" name="search_brand_mode" value="del" /> 해당 브랜드 연결 해제</label>
								<label><input type="radio" name="search_brand_mode" value="all_del" /> 모든 브랜드 연결 해제</label>
							</div>
						</div>
					</td>
				</tr>
				<tr class="if_location hide">
					<th>연결 설정</th>
					<td>
						<div class="location_connect connect_setting">
							<div class="resp_radio">
								<label><input type="radio" name="search_location_mode" value="add" checked /> 지역 추가 연결</label>
								<label><input type="radio" name="search_location_mode" value="move" /> 지역 삭제 후 연결</label>
								<label><input type="radio" name="search_location_mode" value="copy" /> 상품 복사 후 지역 연결</label>
							</div>
						</div>
						<div class="location_disconnect connect_setting">
							<div class="resp_radio">
								<label><input type="radio" name="search_location_mode" value="del" /> 해당 지역 연결 해제</label>
								<label><input type="radio" name="search_location_mode" value="all_del" /> 모든 지역 연결 해제</label>
							</div>
						</div>
					</td>
				</tr>
				<tr class="if_category category_select connect_setting">
					<th>카테고리</th>
					<td>
						<ul class="bullet_hyphen hide" id="category_search">
							<li>카테고리로 검색 시 가능</li>
						</ul>
						<table class="table_basic thl category_table v7">
							<tr>
								<th class="center">1차</th>
								<th class="center">2차</th>
								<th class="center">3차</th>
								<th class="center">4차</th>
							</tr>
							<tr>
								<td>
									<select class="resp_select wp100" name="add_category1">
										<option value="">1차</option>
									</select>
									<select class="resp_select wp100 hide" name="move_category1">
										<option value="">1차</option>
									</select>
									<select class="resp_select wp100 hide" name="copy_category1">
										<option value="">1차</option>
									</select>
								</td>
								<td>
									<select class="resp_select wp100" name="add_category2">
										<option value="">2차</option>
									</select>
									<select class="resp_select wp100 hide" name="move_category2">
										<option value="">2차</option>
									</select>
									<select class="resp_select wp100 hide" name="copy_category2">
										<option value="">2차</option>
									</select>
								</td>
								<td>
									<select class="resp_select wp100" name="add_category3">
										<option value="">3차</option>
									</select>
									<select class="resp_select wp100 hide" name="move_category3">
										<option value="">3차</option>
									</select>
									<select class="resp_select wp100 hide" name="copy_category3">
										<option value="">3차</option>
									</select>
								</td>
								<td>
									<select class="resp_select wp100" name="add_category4">
										<option value="">4차</option>
									</select>
									<select class="resp_select wp100 hide" name="move_category4">
										<option value="">4차</option>
									</select>
									<select class="resp_select wp100 hide" name="copy_category4">
										<option value="">4차</option>
									</select>
								</td>
							</tr>
						</table>
						<ul class="bullet_hyphen">
							<li id="category_tip">상품에 연결된 카테고리가 없으면 새로 연결되는 카테고리가 대표카테고리가 됩니다.</li>
						</ul>
					</td>
				</tr>
				<tr class="if_brand hide brand_select connect_setting">
					<th>브랜드</th>
					<td>
						<ul class="bullet_hyphen hide" id="brand_search">
							<li>브랜드로 검색 시 가능</li>
						</ul>
						<table class="table_basic thl brand_table v7">
							<tr>
								<th class="center">1차</th>
								<th class="center">2차</th>
								<th class="center">3차</th>
								<th class="center">4차</th>
							</tr>
							<tr>
								<td>
									<select class="resp_select wp100" name="add_brand1">
										<option value="">1차</option>
									</select>
									<select class="resp_select wp100" name="move_brand1">
										<option value="">1차</option>
									</select>
									<select class="resp_select wp100" name="copy_brand1">
										<option value="">1차</option>
									</select>
								</td>
								<td>
									<select class="resp_select wp100" name="add_brand2">
										<option value="">2차</option>
									</select>
									<select class="resp_select wp100" name="move_brand2">
										<option value="">2차</option>
									</select>
									<select class="resp_select wp100" name="copy_brand2">
										<option value="">2차</option>
									</select>
								</td>
								<td>
									<select class="resp_select wp100" name="add_brand3">
										<option value="">3차</option>
									</select>
									<select class="resp_select wp100" name="move_brand3">
										<option value="">3차</option>
									</select>
									<select class="resp_select wp100" name="copy_brand3">
										<option value="">3차</option>
									</select>
								</td>
								<td>
									<select class="resp_select wp100" name="add_brand4">
										<option value="">4차</option>
									</select>
									<select class="resp_select wp100" name="move_brand4">
										<option value="">4차</option>
									</select>
									<select class="resp_select wp100" name="copy_brand4">
										<option value="">4차</option>
									</select>
								</td>
							</tr>
						</table>
						<ul class="bullet_hyphen">
							<li id="brand_tip">상품에 연결된 카테고리가 없으면 새로 연결되는 카테고리가 대표카테고리가 됩니다.</li>
						</ul>
					</td>
				</tr>
				<tr class="if_location hide location_select connect_setting">
					<th>지역</th>
					<td>
						<ul class="bullet_hyphen hide" id="location_search">
							<li>지역으로 검색 시 가능</li>
						</ul>
						<table class="table_basic thl location_table v7">
							<tr>
								<th class="center">1차</th>
								<th class="center">2차</th>
								<th class="center">3차</th>
								<th class="center">4차</th>
							</tr>
							<tr>
								<td>
									<select class="resp_select wp100" name="add_location1">
										<option value="">1차</option>
									</select>
									<select class="resp_select wp100" name="move_location1">
										<option value="">1차</option>
									</select>
									<select class="resp_select wp100" name="copy_location1">
										<option value="">1차</option>
									</select>
								</td>
								<td>
									<select class="resp_select wp100" name="add_location2">
										<option value="">2차</option>
									</select>
									<select class="resp_select wp100" name="move_location2">
										<option value="">2차</option>
									</select>
									<select class="resp_select wp100" name="copy_location2">
										<option value="">2차</option>
									</select>
								</td>
								<td>
									<select class="resp_select wp100" name="add_location3">
										<option value="">3차</option>
									</select>
									<select class="resp_select wp100" name="move_location3">
										<option value="">3차</option>
									</select>
									<select class="resp_select wp100" name="copy_location3">
										<option value="">3차</option>
									</select>
								</td>
								<td>
									<select class="resp_select wp100" name="add_location4">
										<option value="">4차</option>
									</select>
									<select class="resp_select wp100" name="move_location4">
										<option value="">4차</option>
									</select>
									<select class="resp_select wp100" name="copy_location4">
										<option value="">4차</option>
									</select>
								</td>
							</tr>
						</table>
						<ul class="bullet_hyphen">
							<li id="location_tip">상품에 연결된 카테고리가 없으면 새로 연결되는 카테고리가 대표카테고리가 됩니다.</li>
						</ul>
					</td>
				</tr>
			</table>
<?php }elseif($TPL_VAR["mode"]=='commoninfo'){?>
			<table class="table_basic v7 wx700">
				<tr>
					<th>항목명</th>
					<th>내용</th>
				</tr>
				<tr>
					<th>공통 정보</th>
					<td>
						<label class="resp_checkbox hide"><input type="checkbox"
																 class="resp_text ifchk batch_update_item hide" name="batch_commoninfo_yn" value="1"
																 checked /></label>
						<select name="batch_info_select">
							<option value="0">선택</option>
<?php if($TPL_info_loop_1){foreach($TPL_VAR["info_loop"] as $TPL_V1){?>
<?php if($TPL_V1["info_name"]!='== 선택하세요 =='&&$TPL_V1["info_name"]!='== ←좌측에 공용정보명을 입력하여 새로운 공용정보를 만드시거나 또는 ↓아래에서 이미 만들어진 공용정보를 불러오세요 =='){?>
							<option value="<?php echo $TPL_V1["info_seq"]?>"><?php echo $TPL_V1["info_name"]?>(<?php echo $TPL_V1["info_seq"]?>)</option>
<?php }?>
<?php }}?>
						</select>
						<input type="hidden" class="common_info_seq" name="common_info_seq" />
					</td>
				</tr>
			</table>
<?php }elseif($TPL_VAR["mode"]=='icon'){?>

			<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
			<div class="resp_radio">
				<label><input type="radio" name="modify_means" value="add" checked /> 현재 아이콘 유지</label>
				<label><input type="radio" name="modify_means" value="delete" /> 현재 아이콘 삭제 후 업데이트</label>
			</div>
			<div class="wx600 pdt10 mt5" style="border-top:1px dashed #ddd">
				<table class="table_basic v7" id="iconViewTable">
					<colgroup>
						<col width="55%" />
						<col />
						<col width="10%" />
					</colgroup>
					<thead>
					<tr>
						<th>노출기간</th>
						<th>아이콘</th>
						<th><button type="button" id="iconAdd" class="btn_plus"></button></th>
					</tr>
					</thead>
					<tbody>
					<tr class="nothing <?php if($TPL_VAR["icons"]){?>hide<?php }?>">
						<td colspan="3" class="center">아이콘을 등록해 주세요.</td>
					</tr>
<?php if($TPL_VAR["icons"]){?>
<?php if($TPL_icons_1){foreach($TPL_VAR["icons"] as $TPL_V1){?>
					<tr>
						<td>
							<input type="hidden" name="iconSeq[]" value="<?php echo $TPL_V1["icon_seq"]?>" />
							<span>
											<input type="text" name="iconStartDate[]" value="<?php echo $TPL_V1["start_date"]?>" maxlength="10"
												   size="10" />~
											<input type="text" name="iconEndDate[]" value="<?php echo $TPL_V1["end_date"]?>" maxlength="10"
												   size="10" />
										</span>
						</td>
						<td class="center">
							<input type="hidden" name="goodsIcon[]" value="<?php echo $TPL_V1["codecd"]?>" />
							<img src="/data/icon/goods/<?php echo $TPL_V1["codecd"]?>.gif" border="0" class="goodsIcon hand"
								 align="absmiddle">
							<btton type="button" class="goodsIcon resp_btn v2 size_S">선택</button>
						</td>
						<td class="center"><button type="button" class="iconDel btn_minus"></button></td>
					</tr>
<?php }}?>
<?php }?>
					</tbody>
				</table>
			</div>
<?php }?>

<?php }?>
<?php if($TPL_VAR["mode"]=='ifprice'){?>
			<ul class="bullet_hyphen mt5">
				<li>정가, 판매가는 모든 옵션에 일괄 업데이트 됩니다.</li>
			</ul>
<?php }elseif($TPL_VAR["mode"]=='icon'){?>
			<ul class="bullet_hyphen mt5">
				<li>노출 기간 미설정 시 기간 제한 없음</li>
			</ul>
<?php }?>
		</td>
	</tr>
<?php }?>
	</tbody>
</table>
</div>

<div class="contents_dvs v2">
	<div class="list_info_container">
		<div class="dvs_left">
			검색 <b><?php echo number_format($TPL_VAR["page"]["searchcount"])?></b>개 (총 <b id="search_count"><?php echo number_format($TPL_VAR["page"]["totalcount"])?></b>개)
		</div>
		<div class="dvs_right">
			<span class="display_sort" sort="<?php echo $TPL_VAR["sc"]["sort"]?>"></span>
			<span class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></span>
		</div>
	</div>