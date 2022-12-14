<?php /* Template_ 2.2.6 2022/05/17 12:31:41 /www/music_brother_firstmall_kr/admin/skin/default/design/_display_edit_popup_light.html 000023098 */ ?>
<!-- 아이콘 선택 -->
<div id="displayImageIconPopup" class="hide">
	<div class="icon_tab_title hide">
		<span class="icon_title_1" icon_type="">조건 없이 노출</span>
		<span class="icon_title_2" icon_type="condition">(고급 설정)조건 만족 시 노출</span>
		<span class="icon_title_3"> </span>
	</div>
	<div class="icon_tab1 pdt30">
		<form enctype="multipart/form-data" method="post" action="../design_process/display_icon_upload" target="actionFrame">
			<input type="hidden" name="uniqueKey" value="" />
			<input type="hidden" name="subPath" value="" />
			<ul class="icon_ul"></ul>
		</form>
	</div>
	<div class="icon_tab2 hide">
		<div id="image_icon_wrap">
			<div class="mt10">
				<ul>
					<li class="icon_set_title">
						<span class="title">노출 순서</span>
						<span class="title_2">노출 여부</span>
						<span class="title_3">노출 조건</span>
						<span class="title_4">노출 정보 &nbsp;<strong class="btn small orange"><button onclick="openDialog('치환코드','#icon_replace_info', {'width':'500','show' : 'fade','hide' : 'fade'});">치환코드</button></strong></span>
						<span class="title_5">결과 예시</span>
					</li>
					<li>
						<div class="icon_container"></div>
					</li>
				</ul>
			</div>

			<div class="clearbox"></div>

			<div class="mt10 center">
				<span class="btn medium cyanblue"><button type="button" onclick="icon_condition_apply()">확인</button></span>
			</div>

			<div class="hide icon_detail_bak">
				<p>
					<label>
						<input type="radio" name="txt_use" class="txt_use" onchange="icon_condition_set_all()"/>
					</label>
					<input type="text" class="txt_val" onchange="icon_condition_set_all()" size="20"/>
					<input type="hidden" class="txt_color" value="#ffffff" />
					<input type="hidden" class="txt_font" value="" />
					<input type="hidden" class="txt_size" value="9" />
					<input type="hidden" class="txt_weight" value=""/>
				</p>
			</div>

			<div class="limit_func_blind hide"></div>
			<span class="limit_func_blind_txt hide">상품디스플레이 스킨을 업그레이드 해주세요</span>
		</div>
	</div>
</div>

<div id="displayImageIconBackground" class="hide">
	<table style="width:100%;" >
		<tr>
			<td>
				<span><input type="hidden" name="icon_background_type" value="style" /></span>
			</td>
			<td>
				<table class="info-table-style" style="width:100%;" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<th class="its-th-align center">배경 색상</th>
					</tr>
					<tr>
						<td class="its-td-align center">
							<input type="hidden" name="width" size="5"/>
							<input type="hidden" name="height" size="5"/>
							<input type="hidden" name="opacity" size="5"/>
							<input type="text" name="color" class="colorpicker" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div class="mt30 mb10 center">
		<span class="btn medium cyanblue"><button type="button" onclick="apply_image_icon_background();">적용</button></span>
	</div>
</div>

<!-- 이미지꾸미기 퀵바 아이콘 팝업 -->
<div id="displayQuickIconPopup" class="hide">
	<form enctype="multipart/form-data" method="post" action="../design_process/display_quick_icon_upload" target="actionFrame">
		<input type="hidden" name="uniqueKey" value="" />

		<table align="center">
			<col width="30" /><col width="50" /><col />
			<tr>
				<td><input type="checkbox" name="quick_shopping_icon[]" value="newwin" /></td>
				<td><img class="quick_shopping_icon_img" src="/data/icon/goodsdisplay/quick_shopping/thumb_newwin.gif"></td>
				<td><input name="quick_shopping_icon_newwin" class="input-box-default-text" type="file" value="" /></td>
			</tr>
			<tr>
				<td><input type="checkbox" name="quick_shopping_icon[]" value="quickview" /></td>
				<td><img class="quick_shopping_icon_img" src="/data/icon/goodsdisplay/quick_shopping/thumb_quickview.gif"></td>
				<td><input name="quick_shopping_icon_quickview" class="input-box-default-text" type="file" value="" /></td>
			</tr>
			<tr>
				<td><input type="checkbox" name="quick_shopping_icon[]" value="send" /></td>
				<td><img class="quick_shopping_icon_img" src="/data/icon/goodsdisplay/quick_shopping/thumb_send.gif"></td>
				<td><input name="quick_shopping_icon_send" class="input-box-default-text" type="file" value="" /></td>
			</tr>
			<tr>
				<td rowspan="2"><input type="checkbox" name="quick_shopping_icon[]" value="zzim" /></td>
				<td><img class="quick_shopping_icon_img" src="/data/icon/goodsdisplay/quick_shopping/thumb_zzim.gif"></td>
				<td><input name="quick_shopping_icon_zzim" class="input-box-default-text" type="file" value="" /></td>
			</tr>
			<tr>
				<td><img class="quick_shopping_icon_img" src="/data/icon/goodsdisplay/quick_shopping/thumb_zzim_on.gif"></td>
				<td><input name="quick_shopping_icon_zzim_on" class="input-box-default-text" type="file" value="" /></td>
			</tr>
		</table>

		<div class="pdt10 center">
			<span class="btn small black"><button type="submit">추가</button></span>
		</div>
	</form>
</div>

<div id="displayGoodsSelectPopup">
	<div id="displayGoodsSelect"></div>
</div>

<div id="displayInfoDescLayer" class="hide">
	<table class="info-table-style" width="100%" cellpadding="0" cellspacing="0" border="0">
		<col width="110" /><col />
		<tr>
			<th class="its-th-align center">(혜택적용)판매가</th>
			<td class="its-td">
				이벤트, 회원등급, 모바일/태블릿, 유입경로의 혜택이 있을 경우 할인이 적용된 판매가격입니다.
			</td>
		</tr>
		<tr>
			<th class="its-th-align center">(혜택적용)캐시</th>
			<td class="its-td">
				이벤트, 회원등급, 모바일/태블릿, 유입경로의 혜택이 있을 경우 추가 적립이 적용된 캐시액입니다.
			</td>
		</tr>
		<tr>
			<th class="its-th-align center">무료배송</th>
			<td class="its-td">
				기본 배송 정책 → 택배 선불 → 무료 배송으로 지정된 상품일 때 ▶ 무료 배송으로 표시됩니다.<br />
				기본 배송 정책 → 택배 선불 → 배송비 무료 정책일 때 ▶ 무료 배송으로 표시됩니다.<br />
				개별 배송 정책 → 택배 선불 → 배송비 0원 일 때 ▶ 무료 배송으로 표시됩니다.
			</td>
		</tr>
	</table>
</div>

<!-- 아래 네비게이션 선택 -->
<div id="navigation_paging_dialog" class="hide">
	<div class="mt10">
		<label>
			<input type="radio" name="navigation_paging_style" value="paging_style_1" />
			<ul class="mobile_pagination_paging_style_1">
				<li class="current">1</li>
				<li>2</li>
				<li>3</li>
				<li>4</li>
				<li>5</li>
			</ul>
		</label>
	</div>
	<div class="mt10">
		<label>
			<input type="radio" name="navigation_paging_style" value="paging_style_2" />
			<ul class="mobile_pagination_paging_style_2">
				<li class="current">1</li>
				<li>2</li>
				<li>3</li>
				<li>4</li>
				<li>5</li>
			</ul>
		</label>
	</div>
	<div class="mt10">
		<label>
			<input type="radio" name="navigation_paging_style" value="paging_style_3" />
			<ul class="mobile_pagination_paging_style_3">
				<li class="current">1</li>
				<li>2</li>
				<li>3</li>
				<li>4</li>
				<li>5</li>
				<li>6</li>
				<li>7</li>
			</ul>
		</label>
	</div>
	<div class="mt10">
		<label>
			<input type="radio" name="navigation_paging_style" value="paging_style_4" />
			<ul class="mobile_pagination_paging_style_4">
				<li class="paging_btn_prev"></li>
				<li class="paging_btn_body"><span class="paging_btn_num_now">2</span>/<span class="paging_btn_num_max">8</span></li>
				<li class="paging_btn_next"></li>
			</ul>
		</label>
	</div>
	<div class="mt10">
		<label>
			<input type="radio" name="navigation_paging_style" value="paging_style_5" />
			<ul class="mobile_pagination_paging_style_5">
				<li class="paging_btn_prev"></li>
				<li class="paging_btn_body"><span class="paging_btn_num_now">2</span>/<span class="paging_btn_num_max">8</span></li>
				<li class="paging_btn_next"></li>
			</ul>
		</label>
	</div>

	<div class="mt30 mb10 center">
		<span class="btn small cyanblue"><button type="button" onclick="closeDialog('navigation_paging_dialog')">확인</button></span>
	</div>

</div>

<div id="overay_setting_dialog" class="hide">
	<div>
		<table id="overay_main_setting" class="info-table-style" width="950px" align="center">
			<tr>
				<th class="its-th-align" colspan="2">배경</th>
				<th class="its-th-align" colspan="6">텍스트</th>
			</tr>
			<tr>
				<th class="its-th-align">색상</th>
				<th class="its-th-align">투명도</th>
				<th class="its-th-align" colspan="2">정렬</th>
				<th class="its-th-align">왼쪽 여백</th>
				<th class="its-th-align">아래쪽 여백</th>
				<th class="its-th-align">위쪽 여백</th>
				<th class="its-th-align">오른쪽 여백</th>
			</tr>
			<tr>
				<td class="its-td-align center">
					<input type="text" name="overay_bg_color" class="colorpicker overay_main" value=""/>
				</td>
				<td class="its-td-align center"><input type="text" name="overay_opacity" class="overay_main" size="3" maxlength="3"/> %</td>
				<td class="its-td-align center">
					<select name="overay_h_orderby" class="overay_main">
						<option value="left">왼쪽</option>
						<option value="center">가운데</option>
						<option value="right">오른쪽</option>
					</select>
				</td>
				<td class="its-td-align center">
					<select name="overay_v_orderby" class="overay_main">
						<option value="top">위쪽</option>
						<option value="middle">중간</option>
						<option value="bottom">아래쪽</option>
					</select>
				</td>
				<td class="its-td-align center"><input type="text" name="overay_left" class="overay_main onlynumber" size="3" maxlength="3"/> px</td>
				<td class="its-td-align center"><input type="text" name="overay_bottom" class="overay_main onlynumber" size="3" maxlength="3"/> px</td>
				<td class="its-td-align center"><input type="text" name="overay_top" class="overay_main onlynumber" size="3" maxlength="3"/> px</td>
				<td class="its-td-align center"><input type="text" name="overay_right" class="overay_main onlynumber" size="3" maxlength="3"/> px</td>
			</tr>
		</table>
	</div>
	<div class="mt10">
		<table class="info-table-style" width="950px" align="center">
			<col width="50px"/><col width="50px"/><col width="650px"/><col width="200px"/>
			<tr>
				<th class="its-th-align">순서</th>
				<th class="its-th-align">
					<span class="btn small cyanblue"><button type="button" onclick="overay_add_func('')">추가</button></span>
				</th>
				<th class="its-th-align">노출 정보</th>
				<th class="its-th-align">노출 조건</th>
			</tr>
			<tr>
				<td class="its-td-align" colspan="4">
					<div class="overay_container"></div>
				</td>
			</tr>
		</table>
	</div>
	<div class="overay_info_bak hide">
		<div class="overay_items">
			<ul>
				<li class="items_li"><img src="/admin/skin/default/images/common/icon_move.gif" align="absmiddle" style="margin-left:5px" class="move"></li>
				<li class="items_li_2"><span class="overay_del" onclick="overay_remove_func(this);">삭제</span></li>
				<li class="items_li_3">
					<select class="overay_info_cell_type" onchange="overay_set_event(this);">
						<option value="goods_name" opt="0111000000">상품명</option>
						<option value="summary" opt="0111010000">짧은 설명</option>
						<option value="brand_title" opt="0111010000">대표 브랜드</option>
						<option value="brand_title_eng" opt="0111010000">대표 브랜드(영문)</option>
						<option value="discount" opt="0111101110">정가→판매가</option>
						<option value="sale_discount" opt="0111101110">정가→(혜택)판매가</option>
						<option value="consumer_price" opt="011110000">정가</option>
						<option value="price" opt="0111100000">판매가</option>
						<option value="sale_price" opt="0111100000">(혜택)판매가</option>
						<option value="discount_per" opt="0111000001">할인율</option>
						<option value="shpping_free" opt="0111010000">무료배송</option>
						<option value="event_time" opt="0111000000">단독이벤트 남은시간</option>
						<option value="event_cnt" opt="0111000000">단독이벤트 판매수량</option>
<?php if($TPL_VAR["eventpage"]){?>
						<option value="event_text" opt="0111000000">이벤트내용</option>
<?php }?>
						<option value="related_goods" opt="0000000000">관련상품</option>
<?php if(serviceLimit('H_AD')){?>
						<option value="provider_name" opt="0111010000">판매자명</option>
<?php }?>
						<option value="line" opt="0100000000">구분선</option>
						<option value="direct" opt="1111000000">직접입력</option>
					</select>
					<input type="text" name="overay_text" class="line hide opt0" style="width:90px"/>
					<input type="text" name="overay_font_color" class="colorpicker_ready hide opt1" value="#000000"/>
					<select name="overay_font_size" class="hide opt2">
						<option value="">크기</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
					</select>
					<span type="checkbox" name="overay_font_weight" class="font_weight hide opt3" onclick="font_weight_use_chk(this)">A</span>
					<span name="overay_line_through" class="font_line_through font_weight hide opt4" onclick="font_weight_use_chk(this)">A</span>
					<select name="overay_bracket" class="hide opt5">
						<option value="">괄호</option>
						<option value="[]">[]</option>
						<option value="()">()</option>
						<option value="<>">&lt;&gt;</option>
						<option value="{}">{}</option>
					</select>
					<input name="overay_discount_color" type="text" class="colorpicker_ready hide opt6" value="#000000"/>
					<select name="overay_discount_font_size" class="hide opt7">
						<option value="">크기</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
					</select>
					<span name="overay_discount_font_weight" class="font_weight hide opt8" onclick="font_weight_use_chk(this)">A</span>
					<label class="hide opt9">
						할인율 <input type="text" name="overay_discount_per" class="overay_discount_per" size="3" maxlength="3"/> % 이상
						<span class="dicount_per_detail">
							└
							<select name="overay_discount_bg_color" class="overay_discount_bg_color">
								<option value="">배경색 미사용</option>
								<option value="1">배경색 사용</option>
							</select>
							<span>
								<select name="overay_discount_position" class="overay_discount_position">
									<option value="right">우측</option>
									<option value="left">좌측</option>
								</select>
								<input type="text" name="overay_discount_per_color" class="overay_discount_per_color colorpicker_ready" value="#000000"/>
								<input type="text" name="overay_discount_opacity" class="overay_discount_opacity" size="3" maxlength="3"/> %
							</span>
						</span>
					</label>
				</li>
				<li class="items_li_4">
					<span class="overay_desc desc_discount_per hide">설정된 할인율 이상일 때</span>
					<span class="overay_desc desc_shipping hide">기본배송비가 무료인 상품</span>
					<span class="overay_desc desc_event hide">현재 진행중인 단독이벤트 상품</span>
				</li>
			</ul>
		</div>
	</div>
	<div class="mt10 center">
		<span class="btn medium cyanblue"><button type="button" onclick="overay_apply()">확인</button></span>
	</div>
</div>
<div id="icon_replace_info" class="hide">
	<table class="info-table-style" width="100%" align="center">
		<tr>
			<th class="its-th-align center">치환코드</th>
			<th class="its-th-align center">치환코드</th>
		</tr>
		<tr>
			<td class="its-td-align center">{<?php echo 'discount'?>}</td>
			<td class="its-td-align center">할인율</td>
		</tr>
		<tr>
			<td class="its-td-align center">{<?php echo 'brand'?>}</td>
			<td class="its-td-align center">대표 브랜드명</td>
		</tr>
		<tr>
			<td class="its-td-align center">{<?php echo 'brandeng'?>}</td>
			<td class="its-td-align center">대표 브랜드 영문명</td>
		</tr>
		<tr>
			<td class="its-td-align center">{<?php echo 'bestnum'?>}</td>
			<td class="its-td-align center">순위 (오름 차순)</td>
		</tr>
	</table>
</div>
<div id="image_deco_favorite" class="hide">
	<input type="hidden" id="favorite_type" value=""/>
	<input type="hidden" id="favorite_act" value=""/>
	<input type="hidden" id="favorite_key" value=""/>
	<input type="hidden" id="favorite_platform" value=""/>
	<table class="design-simple-table-style" width="100%" align="center">
		<tr>
			<th class="dsts-th">생성일(수정일)</th>
			<td class="dsts-td left favorite_date">자동</td>
		</tr>
		<tr>
			<th class="dsts-th">타이틀</th>
			<td class="dsts-td left"><input type="text" name="favorite_title" size="50"/></td>
		</tr>
		<tr>
			<th class="dsts-th">설명</th>
			<td class="dsts-td left"><textarea name="favorite_desc" cols="48" rows="10"></textarea></td>
		</tr>
	</table>
	<div class="mt10 center">
		<span class="btn medium cyanblue"><button type="button" onclick="image_deco_favorite_save(this)">저장</button></span>
	</div>
</div>


<!-- 상품 정보 선택 안내 --> 
<div id="displayGoodsInfoCondition" class="hide pd10">
	<table class="info-table-style" width="100%" align="center">
		<colgroup>
			<col width="21%" />
			<col width="41%" />
			<col />
		</colgroup>
		<tr>
			<th class="its-th">노출 정보</th>
			<th class="its-th">노출 조건 <span class="red">(조건 미만족 시 미노출)</span></th>
			<th class="its-th">노출 예시</th>
		</tr>
		<tr>
			<th class="its-th">브랜드</th>
			<td class="its-td">등록된 '대표 브랜드'<br />(단, 브랜드 페이지에서는 미노출)</td>
			<td class="its-td">[나이키]</td>
		</tr>
		<tr>
			<th class="its-th">상품명</th>
			<td class="its-td">등록된 '상품명'</td>
			<td class="its-td">퍼스트몰 반응형 로고 반팔티</td>
		</td>
		</tr>
		<tr>
			<th class="its-th">짧은 설명</th>
			<td class="its-td">등록된 '짧은 설명'</td>
			<td class="its-td">모든 화면이 완전한 반응형으로 하나로 완전한 쇼핑몰 솔루션의 로고를 사용하여 제작된 티셔츠입니다. </td>
		</tr>
		<tr>
			<th class="its-th">정가</th>
			<td class="its-td">등록된 '정가'가 '판매가'보다 클 경우</td>
			<td class="its-td">10,000원</td>
		</tr>
		<tr>
			<th class="its-th">판매가</th>
			<td class="its-td">
				등록된 '판매가'<br />(단, 가격대체문구가 있을 경우 대체문구 노출)<br />
				※ 이벤트 할인, 회원등급 할인, 모바일 할인, 유입경로 할인이 있는 상품은 해당 할인 조건 만족 시 해당 할인이 적용된 '판매가'입니다.
			</td>
			<td class="its-td">8,000원</td>
		</tr>
		<tr>
			<th class="its-th">할인율</th>
			<td class="its-td">계산된 할인율('정가' 대비 '판매가')이 1% 이상일 경우</td>
			<td class="its-td">20%</td>
		</tr>
		<tr>
			<th class="its-th">구매수</th>
			<td class="its-td">구매된 경우</td>
			<td class="its-td">구매 12,345</td>
		</tr>
		<tr>
			<th class="its-th">후기수</th>
			<td class="its-td">후기가 있는 경우</td>
			<td class="its-td">후기 12,345</td>
		</tr>
		<tr>
			<th class="its-th">아이콘</th>
			<td class="its-td">등록된 '아이콘'</td>
			<td class="its-td">
				<div class="goodS_info displaY_icon_images">
					<img src="/data/icon/goods/1.gif" alt="">
					<img src="/data/icon/goods/2.gif" alt="">
					<img src="/data/icon/goods/3.gif" alt="">
				</div>
			</td>
		</tr>
		<tr>
			<th class="its-th">색상</th>
			<td class="its-td">등록된 '색상'</td>
			<td class="its-td">
				<div class="goodS_info displaY_color_option">
					<span class="areA" style="background-color: #6b4d32;"></span>
					<span class="areA" style="background-color: #b89f88;"></span>
					<span class="areA" style="background-color: #ebd8c1;"></span>
					<span class="areA" style="background-color: #fff;"></span>
					<span class="areA" style="background-color: #444;"></span>
				</div>
			</td>
		</tr>
		<tr>
			<th class="its-th">후기 평균평점(후기수)</th>
			<td class="its-td">후기가 있는 경우</td>
			<td class="its-td">
				<div class="goodS_info displaY_review_score_a" style="display: inline-block; line-height: 30px; vertical-align: middle ">
					<span class="areA">
						<span class="ev_active2"><b style="width:66%;"></b></span>
					</span>
				</div>
				<div style="display: inline-block; line-height: 30px; vertical-align: middle ">3.3  (12,345)</div>
			</td>
		</tr>
		<tr>
			<th class="its-th">후기 제목</th>
			<td class="its-td">'베스트 후기의 제목'이 있을 경우</td>
			<td class="its-td">반응형이니 편리하게 운영할 수 있겠어요</td>
		</tr>
		<tr>
			<th class="its-th">후기 내용</th>
			<td class="its-td">'베스트 후기의 내용'이 있을 경우</td>
			<td class="its-td">아주 좋습니다. 검정색 M사이즈가 없어서 주문했는데 배송이 오래 걸렸지만 무엇보다 옷이 맘에 듭니다. 검색, 남색 두벌 구매했네요~</td>
		</tr>
		<tr>
			<th class="its-th">무료배송</th>
			<td class="its-td">'무료배송'이 가능한 경우</td>
			<td class="its-td">
				<div class="goodS_info displaY_besong typE_a">
					<span class="areA">무료배송</span>
				</div>
			</td>
		</tr>
		<tr>
			<th class="its-th">해외배송</th>
			<td class="its-td">'해외배송'이 가능한 경우</td>
			<td class="its-td">
				<div class="goodS_info displaY_besong typE_a">
					<span class="areA">해외배송</span>
				</div>
			</td>
		</tr>
		<tr>
			<th class="its-th">상태</th>
			<td class="its-td">상품의 상태가 '정상'이 아닌 경우</td>
			<td class="its-td">Sold Out</td>
		</tr>
		<tr>
			<th class="its-th">판매수량, 남은시간</th>
			<td class="its-td">단독이벤트가 진행 중인 경우</td>
			<td class="its-td">구매 12,345개 &nbsp; 남은시간 02일 01:25:57</td>
		</tr>
		
<?php if(serviceLimit('H_AD')){?>
		<tr>
			<th class="its-th">판매자 (판매자등급)</th>
			<td class="its-td">등록된 '판매자' (단, 미니샵 페이지에서는 미노출)</td>
			<td class="its-td">
				<div class="infO_group">
					<div class="goodS_info displaY_seller_grade_a" style="display:inline-block;">
						<span class="areA">퍼스트몰</span>
					</div>

					<div class="goodS_info displaY_seller_grade_b" style="display:inline-block;">
						<span class="areA">
							<img src="/data/icon/provider/779388.gif" class="icoN" alt="">
							플래티넘
						</span>
					</div>
				</div>
			</td>
		</tr>
<?php }?>
	</table>
</div>