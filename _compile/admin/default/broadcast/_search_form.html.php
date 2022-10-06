<?php /* Template_ 2.2.6 2022/01/25 10:32:12 /www/music_brother_firstmall_kr/admin/skin/default/broadcast/_search_form.html 000005496 */ ?>
<div id="search_container" class="search_container">
	<form name="broadcastsearch" id="broadcastsearch" class="search_form">
	<input type="hidden" name="pageid" value="broadcast"  />
	<input type="hidden" name="query_string"/>
	<input type="hidden" name="perpage" id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" >
	<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["sc"]["page"]?>" data-defaultPage=0 >
	<input type="hidden" name="orderby" id="orderby" value="<?php echo $TPL_VAR["sc"]["orderby"]?>" >
	<input type="hidden" name="select_broadcast"  />

	<table class="table_search">
		<tr>
			<th><span>검색어</span></th>
			<td>
				<select name="search_field">
					<option value="all">전체</option>
					<option value="title">방송 제목</option>
					<option value="goods_name">상품명</option>
				</select>
				<input type="text" name="search_text" id="search_text" value="<?php echo $TPL_VAR["sc"]["search_text"]?>" size="100" title="" />
			</td>
		</tr>

<?php if($TPL_VAR["sc"]["select"]){?>
		<tr>
			<th><span>방송 종류</span></th>
			<td>
				<label class='resp_radio mr20'><input type="radio" name="select_search_status" value="vod" disabled  /> 지난 방송</label>
				<label class='resp_radio'><input type="radio" name="select_search_status" value="live" disabled  /> 라이브/방송 예약</label>
				<input type="hidden" name="select_status" value="<?php echo $TPL_VAR["sc"]["select_status"]?>" />
			</td>
		</tr>
<?php }?>

		<tr>
			<th><span>날짜</span></th>
			<td>
				<div class="sc_day_date date_range_form">
					<select name="date_gb" class="resp_select wx110">
						<option value="regist_date">방송일</option>
						<option value="start_date">예약 신청일</option>
					</select>
					<input type="text" name="sdate" class="datepicker line sdate"  maxlength="10" />
					-
					<input type="text" name="edate" class="datepicker line edate" maxlength="10"  />
					<div class="resp_btn_wrap">
						<input type="button"  range="today" value="오늘" class="select_date resp_btn" />
						<input type="button"  range="3day" value="3일간" class="select_date resp_btn" />
						<input type="button"  range="1week" value="일주일" class="select_date resp_btn" />
						<input type="button"  range="1month" value="1개월" class="select_date resp_btn" />
						<input type="button"  range="3month" value="3개월" class="select_date resp_btn" />
						<input type="button"  range="select_date_all"  value="전체" class="select_date resp_btn"/>
						<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden" />
					</div>
				</div>
			</td>
		</tr>

		<tr>
			<th><span>방송 상품 카테고리</span></th>
			<td>
				<select class="wx110" name="category1" size="1"><option value="">1차 분류</option></select>
				<select class="wx110" name="category2" size="1"><option value="">2차 분류</option></select>
				<select class="wx110" name="category3" size="1"><option value="">3차 분류</option></select>
				<select class="wx110" name="category4" size="1"><option value="">4차 분류</option></select>&nbsp;
				<label class='resp_checkbox'><input type="checkbox" name="goods_category" value="1" defaultValue=false  /> 대표 카테고리 기준</label>&nbsp;
				<label class='resp_checkbox'><input type="checkbox" name="goods_category_no" class="not_regist" value="1" defaultValue=false /> 카테고리 미등록</label>
			</td>
		</tr>

<?php if(isBroadcastVersion('2.0')&&serviceLimit('H_AD')){?>
		<tr>
			<th><span>입점사</span></th>
			<td>
				<div class="ui-widget">
					<select name="provider_seq_selector" style="vertical-align:middle;">
					</select>
					<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $TPL_VAR["sc"]["provider_seq"]?>" />
				</div>
			</td>
		</tr>
		<tr>
			<th><span>승인 여부</span></th>
			<td>
				<label class='resp_radio mr20'><input type="radio" name="approval" value="" checked /> 전체</label>
				<label class='resp_radio mr20'><input type="radio" name="approval" value="regist"/> 신청</label>
				<label class='resp_radio mr20'><input type="radio" name="approval" value="apply" /> 승인</label>
				<label class='resp_radio mr20'><input type="radio" name="approval" value="hold" /> 보류</label>
				<label class='resp_radio'><input type="radio" name="approval" value="reject" /> 거절</label>
			</td>
		</tr>
<?php }?>
<?php if(!$TPL_VAR["voduse"]&&!$TPL_VAR["sc"]["select"]){?>
		<tr>
			<th><span>방송 상태</span></th>
			<td>
				<label class='resp_radio mr20'><input type="radio" name="status" value="" checked /> 전체</label>
				<label class='resp_radio mr20'><input type="radio" name="status" value="create"/> 방송 예약</label>
				<label class='resp_radio mr20'><input type="radio" name="status" value="live" /> 방송 중</label>
				<label class='resp_radio mr20'><input type="radio" name="status" value="end" /> 방송 종료</label>
				<label class='resp_radio'><input type="radio" name="status" value="cancel" /> 방송 취소</label>
			</td>
		</tr>
<?php }?>
	</table>

	<div class="footer search_btn_lay"></div>
</form>
</div>
<div class="cboth"></div>