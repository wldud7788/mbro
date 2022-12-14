<?php /* Template_ 2.2.6 2022/05/17 12:29:25 /www/music_brother_firstmall_kr/selleradmin/skin/default/page_manager/_goods_info_style.html 000006558 */ 
$TPL_fileList_1=empty($TPL_VAR["fileList"])||!is_array($TPL_VAR["fileList"])?0:count($TPL_VAR["fileList"]);?>
<link rel="stylesheet" href="/admin/skin/default/css/admin_goods_display.css"/>
<link rel="stylesheet" href="/data/design_list/goods_list_style.css"/>

<?php if($TPL_fileList_1){foreach($TPL_VAR["fileList"] as $TPL_V1){?>
<label class="resp_info_select">
	<input type="radio" class="hide goods_info_style" name="goods_info_style" value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_VAR["goods_info_style"]==$TPL_V1["name"]){?>checked<?php }?>/>
	<div data-type="<?php echo $TPL_V1["name"]?>" style="display: inline-flex; flex-direction: row;" class="hand goods_file_list <?php if($TPL_VAR["goods_info_style"]==$TPL_V1["name"]){?>current<?php }?>">
		<div class="searched_item_display">
			<ul><?php echo $TPL_V1["contents"]?></ul>
		</div>
	</div>
</label>
<?php }}?>


<script type="text/javascript">
	// 라이트형 상품정보 선택 색상 :: 2018-11-26 lwh
	// 클릭 시 submit 처리 추가 :: 2019-05-14 pjw
	$(".goods_info_style").bind('click',function(){
		var _that = this;
		$('.goods_file_list').removeClass('select');
		$(this).next('.goods_file_list').addClass('select');
	});
</script>

<!-- 상품 정보 선택 안내 팝업 --> 
<div id="displayGoodsInfoStyle" class="hide pd10">
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
							(플래티넘)
						</span>
					</div>
				</div>
			</td>
		</tr>
<?php }?>
	</table>
</div>