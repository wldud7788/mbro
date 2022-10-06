<?php /* Template_ 2.2.6 2022/05/17 12:36:26 /www/music_brother_firstmall_kr/admin/skin/default/member/dormancy_list.html 000003805 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<div class="list_info_container">
	<div class="dvs_left">	
		검색 <b><?php echo number_format($TPL_VAR["sc"]["searchcount"])?></b>개 (총 <b><?php echo number_format($TPL_VAR["sc"]["totalcount"])?></b>개)
	</div>
	<div class="dvs_right">	
		<select  name="perpage" id="display_quantity">
			<option id="dp_qty10" value="10" <?php if($TPL_VAR["sc"]["perpage"]== 10){?> selected<?php }?> >10개씩</option>
			<option id="dp_qty50" value="50" <?php if($TPL_VAR["sc"]["perpage"]== 50){?> selected<?php }?> >50개씩</option>
			<option id="dp_qty100" value="100" <?php if($TPL_VAR["sc"]["perpage"]== 100){?> selected<?php }?> >100개씩</option>
			<option id="dp_qty200" value="200" <?php if($TPL_VAR["sc"]["perpage"]== 200){?> selected<?php }?> >200개씩</option>
		</select>
	</div>
</div>
<div class="table_row_frame">	
	<div class="dvs_top">			
		<div class="dvs_right">		
			<button type="button" class="resp_btn v2 smsBtn">SMS 휴면 고지</button>
            <button type="button" class="resp_btn v2 emailBtn">이메일 휴면 고지</button>
		</div>
	</div>

	<!-- 주문리스트 테이블 : 시작 -->
	<table class="table_row_basic tdc">
		<!-- 테이블 헤더 : 시작 -->
		<colgroup>
			<col width="5%" /><col/><col/><col/>
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>구분</th>
			<th>아이디</th>
			<th>날짜</th>
			<th>캐시</th>
			<th>포인트</th>
			<th>예치금</th>
			<th>구매/주문/리뷰/방문</th>
			<th>관리</th>			
		</tr>
		</thead>
		<!-- 테이블 헤더 : 끝 -->

		<!-- 리스트 : 시작 -->
		<tbody >
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr>
				<td><?php echo $TPL_V1["log_seq"]?></td>
				<td><?php if($TPL_V1["log_type"]=='on'){?>휴면<?php }else{?>휴면 해제<?php }?></td>
				<td><?php echo $TPL_V1["userid"]?></td>
				<td><?php echo $TPL_V1["log_date"]?></td>				
				<td class="right"><?php echo get_currency_price($TPL_V1["emoney"])?></td>
				<td class="right"><?php echo get_currency_price($TPL_V1["point"])?></td>
				<td class="right"><?php echo get_currency_price($TPL_V1["cash"])?></span></td>
				<td><?php echo number_format($TPL_V1["order_cnt"])?>/<?php echo number_format($TPL_V1["order_sum"])?>/<?php echo number_format($TPL_V1["review_cnt"])?>/<?php echo number_format($TPL_V1["login_cnt"])?></td>
				<td><input type="button" name="manager_modify_btn" value="상세" <?php if($TPL_VAR["pageType"]!="search"){?>onclick="window.open('/admincrm/main/user_detail?member_seq=<?php echo $TPL_V1["member_seq"]?>');"<?php }?> class="resp_btn v2"/></span></td>				
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }}?>
<?php }else{?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr>
				<td colspan="9">
<?php if($TPL_VAR["search_text"]){?>
						'<?php echo $TPL_VAR["search_text"]?>' 검색된 회원이 없습니다.
<?php }else{?>
						등록된 회원이 없습니다.
<?php }?>
				</td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }?>
		</tbody>
		<!-- 리스트 : 끝 -->

	</table>
	<!-- 주문리스트 테이블 : 끝 -->

	<div class="dvs_bottom">			
		<div class="dvs_right">		
			<button type="button" class="resp_btn v2 smsBtn">SMS 휴면 고지</button>
            <button type="button" class="resp_btn v2 emailBtn">이메일 휴면 고지</button>
		</div>
	</div>
</div>

<div id="sendPopup" class="hide"></div>
<div id="emoneyPopup" class="hide"></div>
<div id="download_list_setting" class="hide"></div>