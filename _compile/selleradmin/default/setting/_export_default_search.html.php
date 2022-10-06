<?php /* Template_ 2.2.6 2022/05/17 12:29:31 /www/music_brother_firstmall_kr/selleradmin/skin/default/setting/_export_default_search.html 000006493 */ ?>
<form name="search_default_frm" action="../setting_process/export_default_search" method="post" target="actionFrame">
	<table width="100%" class="info-table-style">
		<col width="10%" /><col width="45%" /><col width="45%" />
		<tr>
			<th class="its-th"></th>
			<th class="its-th">출고처리 검색</th>
			<th class="its-th">출고처리 검색</th>
		</tr>
		<tr>
			<th class="its-th">기간</th>
			<td class="its-td">
				<select name="order_default_date_field">
					<option value="regist_date" <?php if($TPL_VAR["data_search_default"]["order_default_date_field"]=='regist_date'||!$TPL_VAR["data_search_default"]["order_default_date_field"]){?>selected<?php }?>>주문일</option>
					<option value="deposit_date" <?php if($TPL_VAR["data_search_default"]["order_default_date_field"]=='deposit_date'){?>selected<?php }?>>입금일</option>
				</select>&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="order_default_period" value="-1 day" <?php if($TPL_VAR["data_search_default"]["order_default_period"]=='-1 day'){?>checked<?php }?>> 오늘</label>
				<label><input type="radio" name="order_default_period" value="-1 week" <?php if($TPL_VAR["data_search_default"]["order_default_period"]=='-1 week'||!$TPL_VAR["data_search_default"]["export_default_period"]){?>checked<?php }?>> 일주일</label>
				<label><input type="radio" name="order_default_period" value="-1 mon" <?php if($TPL_VAR["data_search_default"]["order_default_period"]=='-1 mon'){?>checked<?php }?>> 1개월</label>
				<label><input type="radio" name="order_default_period" value="-3 mon" <?php if($TPL_VAR["data_search_default"]["order_default_period"]=='-3 mon'){?>checked<?php }?>> 3개월</label>
				<label><input type="radio" name="order_default_period" value="all" <?php if($TPL_VAR["data_search_default"]["order_default_period"]=='all'){?>checked<?php }?>> 전체</label>
			</td>
			<td class="its-td">
				<select name="export_default_date_field">
					<option value="order" <?php if($TPL_VAR["data_search_default"]["export_default_date_field"]=='order'){?>selected<?php }?>>주문일</option>
					<option value="export" <?php if($TPL_VAR["data_search_default"]["export_default_date_field"]=='export'||!$TPL_VAR["data_search_default"]["export_default_date_field"]){?>selected<?php }?>>출고일(입력)</option>
					<option value="regist_date" <?php if($TPL_VAR["data_search_default"]["export_default_date_field"]=='regist_date'){?>selected<?php }?>>출고일</option>
					<option value="shipping" <?php if($TPL_VAR["data_search_default"]["export_default_date_field"]=='shipping'){?>selected<?php }?>>배송완료일</option>
					<option value="confirm_date" <?php if($TPL_VAR["data_search_default"]["export_default_date_field"]=='confirm_date'){?>selected<?php }?>>구매확정일</option>
				</select>&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="export_default_period" value="-1 day" <?php if($TPL_VAR["data_search_default"]["export_default_period"]=='-1 day'){?>checked<?php }?>> 오늘</label>
				<label><input type="radio" name="export_default_period" value="-1 week" <?php if($TPL_VAR["data_search_default"]["export_default_period"]=='-1 week'||!$TPL_VAR["data_search_default"]["export_default_period"]){?>checked<?php }?>> 일주일</label>
				<label><input type="radio" name="export_default_period" value="-1 mon" <?php if($TPL_VAR["data_search_default"]["export_default_period"]=='-1 mon'){?>checked<?php }?>> 1개월</label>
				<label><input type="radio" name="export_default_period" value="-3 mon" <?php if($TPL_VAR["data_search_default"]["export_default_period"]=='-3 mon'){?>checked<?php }?>> 3개월</label>
				<label><input type="radio" name="export_default_period" value="all" <?php if($TPL_VAR["data_search_default"]["export_default_period"]=='all'){?>checked<?php }?>> 전체</label>
			</td>
		</tr>
		<tr>
			<th class="its-th">상태</th>
			<td class="its-td">
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if(($TPL_K1>= 40&&$TPL_K1<= 75&&substr($TPL_K1, 1, 1)== 0)||($TPL_K1>= 25&&$TPL_K1<= 35)){?>
				<label style="display:inline-block;"><input type="checkbox" name="order_default_step[]" value="<?php echo $TPL_K1?>" <?php if(in_array($TPL_K1,$TPL_VAR["data_search_default"]["order_default_step"])||(!$TPL_VAR["data_search_default"]["order_default_step"]&&$TPL_K1=='25')){?>checked<?php }?>> <?php echo $TPL_V1?></label>
<?php }?>
<?php }}?>
			</td>
			<td class="its-td">
<?php if(is_array($TPL_R1=config_load('export_status'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
				<label style="display:inline-block;"><input type="radio" name="export_default_status[]" value="<?php echo $TPL_K1?>" <?php if(in_array($TPL_K1,$TPL_VAR["data_search_default"]["export_default_status"])||(!$TPL_VAR["data_search_default"]["export_default_status"]&&$TPL_K1=='45')){?>checked<?php }?> /> <?php echo $TPL_V1?></label>
<?php }}?>
			</td>
		</tr>
		<tr>
			<th class="its-th">결과</th>
			<td class="its-td">
				<label style="display:inline-block;">
					<input type="radio" name="order_detail_view" value="open" <?php if($TPL_VAR["data_search_default"]["order_detail_view"]!='close'){?>checked<?php }?> />
					주문상품 열기 상태
				</label>
				<label style="display:inline-block;">
					<input type="radio" name="order_detail_view" value="close" <?php if($TPL_VAR["data_search_default"]["order_detail_view"]=='close'){?>checked<?php }?> />
					주문상품 닫기 상태
				</label>
			</td>
			<td class="its-td">
				<label style="display:inline-block;">
					<input type="radio" name="export_detail_view" value="open" <?php if($TPL_VAR["data_search_default"]["export_detail_view"]!='close'){?>checked<?php }?> />
					출고상품 열기 상태
				</label>
				<label style="display:inline-block;">
					<input type="radio" name="export_detail_view" value="close" <?php if($TPL_VAR["data_search_default"]["export_detail_view"]=='close'){?>checked<?php }?> />
					출고상품 닫기 상태
				</label>
			</td>
		</tr>
	</table>
	<div class="desc pdt5">※ 관리자 ID당 설정이 저장됩니다.</div>
	<div class="center">
		<span class="btn large gray" ><button type="submit">저장 하기</button></span>
	</div>
</form>