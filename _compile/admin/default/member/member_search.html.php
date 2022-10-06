<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/member/member_search.html 000021308 */ 
$TPL_search_type_arr_1=empty($TPL_VAR["search_type_arr"])||!is_array($TPL_VAR["search_type_arr"])?0:count($TPL_VAR["search_type_arr"]);
$TPL_group_arr_1=empty($TPL_VAR["group_arr"])||!is_array($TPL_VAR["group_arr"])?0:count($TPL_VAR["group_arr"]);
$TPL_sitetypeloop_1=empty($TPL_VAR["sitetypeloop"])||!is_array($TPL_VAR["sitetypeloop"])?0:count($TPL_VAR["sitetypeloop"]);
$TPL_ruteloop_1=empty($TPL_VAR["ruteloop"])||!is_array($TPL_VAR["ruteloop"])?0:count($TPL_VAR["ruteloop"]);
$TPL_referer_list_1=empty($TPL_VAR["referer_list"])||!is_array($TPL_VAR["referer_list"])?0:count($TPL_VAR["referer_list"]);
$TPL_m_arr_1=empty($TPL_VAR["m_arr"])||!is_array($TPL_VAR["m_arr"])?0:count($TPL_VAR["m_arr"]);
$TPL_d_arr_1=empty($TPL_VAR["d_arr"])||!is_array($TPL_VAR["d_arr"])?0:count($TPL_VAR["d_arr"]);?>
<?php if($TPL_VAR["pageType"]!="search"){?>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('YmdH')?>"></script>
<?php }?>
<script type="text/javascript">
	//기본검색설정
	var default_search_pageid	= "member";
	var default_obj_width		= 750;
	var default_obj_height		= 700;
	var callPage				= "<?php echo $TPL_VAR["callPage"]?>";
	var amail					= "<?php echo $TPL_VAR["amail"]?>";

	$(document).ready(function() {		
		// ### 검색 가입/방문일 //
		setContentsSelect("sc_money_type", "<?php echo $TPL_VAR["sc"]["sc_money_type"]?>");
		setContentsSelect("sc_count_type", "<?php echo $TPL_VAR["sc"]["sc_count_type"]?>");
		setContentsSelect("sc_specialDay_type", "<?php echo $TPL_VAR["sc"]["sc_specialDay_type"]?>");
		setContentsSelect("sc_day_type", "<?php echo $TPL_VAR["sc"]["sc_day_type"]?>");
	});
</script>
<!-- 회원리스트 검색폼 : 시작 -->

<table class="table_search">
	<tr>
		<th><label class="resp_checkbox"><input type="checkbox" name="search_form_editor[]" value="sc_keyword" class="hide"></label> 검색어</th>
		<td>
			<select name="search_type" class="resp_select wx110">
				<option value="">전체</option>
<?php if($TPL_search_type_arr_1){foreach($TPL_VAR["search_type_arr"] as $TPL_K1=>$TPL_V1){?>
				<option value="<?php echo $TPL_K1?>" <?php echo $TPL_VAR["sc"]['selected']['search_type'][$TPL_K1]?> ><?php echo $TPL_V1?></option>
<?php }}?>
			</select>
			<input type="text" name="keyword" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" size="80"/>			
		</td>
	</tr>

	<tr <?php if(!in_array('sc_regist_date',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>날짜</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_regist_date" class="hide"></label></th>
		<td>
			<div class="sc_day_date date_range_form">
				<select name="sc_day_type" class="resp_select">
					<option value="regist" <?php echo $TPL_VAR["sc"]['selected']['sc_day_type']['regist']?>>가입일</option>
					<option value="lastlogin" <?php echo $TPL_VAR["sc"]['selected']['sc_day_type']['lastlogin']?>>최종 방문일</option>					
				</select>
				<select name="lastlogin_search_type" class="sc_day_type_lastlogin hide">
					<option value="in" <?php echo $TPL_VAR["sc"]['selected']['lastlogin_search_type']['in']?>>기간 내 방문</option>
					<option value="out" <?php echo $TPL_VAR["sc"]['selected']['lastlogin_search_type']['out']?>>기간내 미방문</option>
				</select>
				<input type="text" name="regist_sdate" value="<?php echo $TPL_VAR["sc"]["regist_sdate"]?>"  class="datepicker line sdate"  maxlength="10" size="10" default_none/>
				-
				<input type="text" name="regist_edate" value="<?php echo $TPL_VAR["sc"]["regist_edate"]?>"  class="datepicker line edate" maxlength="10" size="10" default_none />
				<div class="resp_btn_wrap">
					<input type="button" value="오늘" range="today" class="select_date resp_btn" settarget="regist" />
					<input type="button" value="3일간" range="3day" class="select_date resp_btn" settarget="regist" />
					<input type="button" value="일주일" range="1week" class="select_date resp_btn" settarget="regist" />
					<input type="button" value="1개월" range="1month" class="select_date resp_btn" settarget="regist" />
					<input type="button" value="3개월" range="3month" class="select_date resp_btn" settarget="regist" />
					<input type="button" value="전체" range="all" class="select_date resp_btn" settarget="regist" row_bunch />
					<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden" />
				</div>
			</div>
		</td>
	</tr>
	<tr <?php if(!in_array('sc_grade',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>등급</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_grade" class="hide"></label></th>
		<td>
			<select name="grade" class="wx110">
				<option value="">전체</option>
<?php if($TPL_group_arr_1){foreach($TPL_VAR["group_arr"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["group_seq"]?>" <?php echo $TPL_VAR["sc"]['selected']['grade'][$TPL_V1["group_seq"]]?>><?php echo $TPL_V1["group_name"]?></option>
<?php }}?>
			</select>
		</td>
	</tr>

	<tr <?php if(!in_array('sc_business',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>가입 유형</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_business" class="hide"></label></th>
		<td>
			<div class="resp_radio">
				<label><input type="radio" name="business_seq" value=""  checked/> 전체</label>
				<label><input type="radio" name="business_seq" value="n" <?php echo $TPL_VAR["sc"]['checkbox']['business_seq']['n']?> /> 개인</label>
				<label><input type="radio" name="business_seq" value="y" <?php echo $TPL_VAR["sc"]['checkbox']['business_seq']['y']?> /> 사업자</label>
			</div>
		</td>
	</tr>

	<tr <?php if(!in_array('sc_status',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>가입 승인(휴면)</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_status" class="hide"></label></th>
		<td>
			<div class="resp_radio">
				<label><input type="radio" name="status" value="" checked/> 전체</label>
				<label><input type="radio" name="status" value="done" <?php echo $TPL_VAR["sc"]['checkbox']['status']['done']?> /> 승인</label>
				<label><input type="radio" name="status" value="hold" <?php echo $TPL_VAR["sc"]['checkbox']['status']['hold']?> /> 미승인</label>
				<label><input type="radio" name="status" value="dormancy" <?php echo $TPL_VAR["sc"]['checkbox']['status']['dormancy']?> /> 휴면</label>
			</div>
		</td>
	</tr>

	<tr <?php if(!in_array('sc_order_sum',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>결제 금액</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_order_sum" class="hide"></label></th>
		<td>
			<input type="text" name="sorder_sum" value="<?php echo $TPL_VAR["sc"]["sorder_sum"]?>" class="right onlynumber nostyle" size="7" row_group="order_sum" defaultValue="0"/> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

			~ 
			<input type="text" name="eorder_sum" value="<?php echo $TPL_VAR["sc"]["eorder_sum"]?>" class="right onlynumber nostyle" size="7" row_group="order_sum"/> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

		</td>
	</tr>

	<tr <?php if(!in_array('sc_order_cnt',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>주문 횟수</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_order_cnt" class="hide"></label></th>
		<td>
			<input type="text" name="sorder_cnt" value="<?php echo $TPL_VAR["sc"]["sorder_cnt"]?>" class="right onlynumber nostyle" size="7" row_group="order_cnt" defaultValue="0"/> 건 
			~ 
			<input type="text" name="eorder_cnt" value="<?php echo $TPL_VAR["sc"]["eorder_cnt"]?>" class="right onlynumber nostyle" size="7" row_group="order_cnt"/> 건
		</td>
	</tr>

	<tr <?php if(!in_array('sc_money',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>마일리지/포인트/예치금</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_money" class="hide"></label></th>
		<td>
			<select name="sc_money_type" class="resp_select">
				<option value="emoney">마일리지</option>
				<option value="point">포인트</option>		
				<option value="cash">예치금</option>		
			</select>	

			<span>
				<input type="text" name="semoney" value="<?php echo $TPL_VAR["sc"]["semoney"]?>" class="right onlyfloat nostyle" size="7" row_group="emoney" defaultValue="0"/>
				<span class="sc_money_type_cash sc_money_type_emoney"><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?></span>
				<span class="sc_money_type_point">P</span>
				~ 
				<input type="text" name="eemoney" value="<?php echo $TPL_VAR["sc"]["eemoney"]?>" class="right onlyfloat nostyle" size="7" row_group="emoney"/>
				<span class="sc_money_type_cash sc_money_type_emoney"><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?></span>
				<span class="sc_money_type_point">P</span>
			</span>
		</td>
	</tr>

	<tr <?php if(!in_array('sc_count',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>방문/리뷰수</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_count" class="hide"></label></th>
		<td>
			<select name="sc_count_type" class="resp_select">
				<option value="login_cnt">방문수</option>
				<option value="review_cnt">리뷰수</option>							
			</select>	

			<span>
				<input type="text" name="slogin_cnt" value="<?php echo $TPL_VAR["sc"]["slogin_cnt"]?>" class="right onlynumber nostyle" size="7" defaultValue="0" />
				<span class="sc_count_type_login_cnt">회</span>
				<span class="sc_count_type_review_cnt">건</span>					
				~ 
				<input type="text" name="elogin_cnt" value="<?php echo $TPL_VAR["sc"]["elogin_cnt"]?>" class="right onlynumber nostyle" size="7" />
				<span class="sc_count_type_login_cnt">회</span>
				<span class="sc_count_type_review_cnt">건</span>		
			</span>
		</td>
	</tr>
<?php if(serviceLimit('H_AD')){?>
	<tr <?php if(!in_array('sc_provider',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>단골 미니샵</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_provider" class="hide"></label></th>
		<td>
			<div class="ui-widget">
				<select name="provider_seq_selector" style="vertical-align:middle;">
				</select>
				<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $TPL_VAR["sc"]["provider_seq"]?>" />
			</div>
		</td>
	</tr>
<?php }?>
	<tr <?php if(!in_array('sc_sitetype',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>회원가입 환경</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_sitetype" class="hide"></label></th>
		<td>
			<div class="resp_radio">
				<label><input type="radio" name="sitetype" value="" checked/> 전체</label>
<?php if($TPL_sitetypeloop_1){foreach($TPL_VAR["sitetypeloop"] as $TPL_K1=>$TPL_V1){?>
				<label><input type="radio" name="sitetype" value="<?php echo $TPL_K1?>" <?php echo $TPL_VAR["sc"]['checkbox']['sitetype'][$TPL_K1]?> /> <?php echo $TPL_V1["name"]?></label>
<?php }}?>
			</div>
		</td>
	</tr>

	<tr <?php if(!in_array('sc_snsrute',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>회원가입 방법</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_snsrute" class="hide"></label></th>
		<td>
			<div class="resp_radio">
				<label><input type="radio" name="snsrute" value="" checked/> 전체</label>
<?php if($TPL_ruteloop_1){foreach($TPL_VAR["ruteloop"] as $TPL_K1=>$TPL_V1){?>
				<label><input type="radio" name="snsrute" value="<?php echo $TPL_K1?>" <?php echo $TPL_VAR["sc"]['checkbox']['snsrute'][$TPL_K1]?>  /><!-- <img src="../images/common/icon/<?php echo $TPL_V1["image"]?>"> --> <?php echo $TPL_V1["name"]?></label>
<?php }}?>
			</div>
		</td>
	</tr>
	<tr <?php if(!in_array('sc_referer',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>회원가입 경로</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_referer" class="hide"></label></th>
		<td>
			<select name="referer" style="width:135px;">
				<option value="">선택하세요</option>
<?php if($TPL_referer_list_1){foreach($TPL_VAR["referer_list"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["referer_group_name"]?>" <?php if($TPL_VAR["sc"]["referer"]==$TPL_V1["referer_group_name"]){?>selected<?php }?>><?php echo $TPL_V1["referer_group_name"]?></option>
<?php }}?>
				<option value="기타" <?php if($TPL_VAR["sc"]["referer"]=='기타'){?>selected<?php }?>>기타</option>
			</select>
		</td>
	</tr>

	<tr <?php if(!in_array('sc_sms',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>SMS 수신</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_sms" class="hide"></label></th>
		<td>
			<div class="resp_radio">
				<label><input type="radio" name="sms" value="" checked/> 전체</label>
				<label><input type="radio" name="sms" value="y"/> 동의</label>
				<label><input type="radio" name="sms" value="n"/> 거부</label>
			</div>
		</td>
	</tr>

	<tr <?php if(!in_array('sc_mailing',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>이메일 수신</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_mailing" class="hide"></label></th>
		<td>
			<div class="resp_radio">
				<label><input type="radio" name="mailing" value="" checked/> 전체</label>
				<label><input type="radio" name="mailing" value="y"/> 동의</label>
				<label><input type="radio" name="mailing" value="n"/> 거부</label>
			</div>
		</td>
	</tr>

	<tr <?php if(!in_array('sc_sex',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>성별</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_sex" class="hide"></label></th>
		<td>
			<div class="resp_radio">			
				<label><input type="radio" name="sex" value="" checked/> 전체</label>
				<label><input type="radio" name="sex" value="male" <?php if($TPL_VAR["sc"]["sex"]=='male'){?> checked <?php }?>/> 남성</label>
				<label><input type="radio" name="sex" value="female" <?php if($TPL_VAR["sc"]["sex"]=='female'){?> checked <?php }?>/> 여성</label>
			<div class="resp_radio">
		</td>
	</tr>

	<tr <?php if(!in_array('sc_age',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>나이</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_age" class="hide"></label></th>
		<td>만
			<input type="text" name="sage" value="<?php echo $TPL_VAR["sc"]["sage"]?>" class="right onlyfloat nostyle" size="7" row_group="age" defaultValue="0"/> 세
			~ 
			<input type="text" name="eage" value="<?php echo $TPL_VAR["sc"]["eage"]?>" class="right onlyfloat nostyle" size="7" row_group="age"/> 세
		</td>
	</tr>

	<tr <?php if(!in_array('sc_specialDay',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th><span>생일/기념일</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_specialDay" class="hide"></label></th>
		<td>
			<select name="sc_specialDay_type" class="resp_select wx110">
				<option value="birth" selected="selected">생일</option>
				<option value="anniversary">기념일</option>							
			</select>	
			
			<span class="sc_specialDay_type_birth hide ">
				<div class="date_range_form">
				<input type="text" name="birthday_sdate" value="<?php echo $TPL_VAR["sc"]["birthday_sdate"]?>" readonly class="datepicker sdate"  maxlength="10" size="12" default_none />
				-
				<input type="text" name="birthday_edate" value="<?php echo $TPL_VAR["sc"]["birthday_edate"]?>" readonly class="datepicker edate" maxlength="10" size="12" default_none />
				<div class="resp_btn_wrap">
					<input type="button" value="오늘" range="today" class="select_date resp_btn" settarget="birthday" />
					<input type="button" value="3일간" range="3day" class="select_date resp_btn" settarget="birthday" />
					<input type="button" value="일주일" range="1week" class="select_date resp_btn" settarget="birthday" />
					<input type="button" value="1개월" range="1month" class="select_date resp_btn" settarget="birthday" />
					<input type="button" value="3개월" range="3month" class="select_date resp_btn" settarget="birthday" />
					<input type="button" value="전체" range="all" class="select_date resp_btn" settarget="birthday" row_bunch />
					<input name="select_date_birthday" value="<?php echo $TPL_VAR["sc"]["select_date_birthday"]?>" class="select_date_input" type="hidden">
					<label class="resp_checkbox ml10"><input type="checkbox" name="birthday_year_except" value="Y" defaultValue="false" <?php if($TPL_VAR["sc"]["birthday_year_except"]=='Y'){?>checked<?php }?>/> 연도 제외</label>
				</div>
				</div>
			</span>
			
			<span class="sc_specialDay_type_anniversary hide">
				<div class="date_range_form">
				<select name="anniversary_sdate[]" onchange="chgAnniversaryOption('s', 0, 1);" default_none class="sdate">
					<option value=""></option>
<?php if($TPL_m_arr_1){foreach($TPL_VAR["m_arr"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["sc"]["anniversary_sdate"][ 0]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
				월
				<select name="anniversary_sdate[]" onchange="chgAnniversaryOption('s', 1, 0);" default_none class="sdate">
					<option value=""></option>
<?php if($TPL_d_arr_1){foreach($TPL_VAR["d_arr"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["sc"]["anniversary_sdate"][ 1]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
				일
				<span class="gray" style="margin:0 5px;">-</span>
				<select name="anniversary_edate[]" onchange="chgAnniversaryOption('e', 0, 1);" default_none class="edate">
					<option value=""></option>
<?php if($TPL_m_arr_1){foreach($TPL_VAR["m_arr"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["sc"]["anniversary_edate"][ 0]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
				월
				<select name="anniversary_edate[]" onchange="chgAnniversaryOption('e', 1, 0);" default_none class="edate">
					<option value=""></option>
<?php if($TPL_d_arr_1){foreach($TPL_VAR["d_arr"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["sc"]["anniversary_edate"][ 1]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
				일
				<div class="resp_btn_wrap" format="onlyDate">
					<input type="button" value="오늘" range="today" class="select_date resp_btn" settarget="anniversary" />
					<input type="button" value="3일간" range="3day" class="select_date resp_btn" settarget="anniversary" />
					<input type="button" value="일주일" range="1week" class="select_date resp_btn" settarget="anniversary" />
					<input type="button" value="1개월" range="1month" class="select_date resp_btn" settarget="anniversary" />
					<input type="button" value="3개월" range="3month" class="select_date resp_btn" settarget="anniversary" />
					<input type="button" value="전체" range="all" class="select_date resp_btn" settarget="anniversary" row_bunch />
					<input name="select_date_anniversary" value="<?php echo $TPL_VAR["sc"]["select_date_anniversary"]?>" class="select_date_input hide" type="text">
				</div>
				</div>
			</span>
		</td>
	</tr>

	<tr <?php if(!in_array('sc_mall_t',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?>>
		<th>
			<span>테스트용 회원</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_mall_t" class="hide"></label>
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/g_member', '#tip1')"></span>
		</th>
		<td><label class="resp_checkbox"><input type="checkbox" name="mall_t_check" value="Y" <?php if($TPL_VAR["sc"]["mall_t_check"]=='Y'){?>checked<?php }?>> 테스트용 회원만 검색</label></td>
	</tr>
</table>
<div class="footer search_btn_lay"></div>

<div id="setPopup" class="hide"></div>