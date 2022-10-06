<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/coupon/_search_form.html 000010138 */ 
$TPL_salestoreitemloop_1=empty($TPL_VAR["salestoreitemloop"])||!is_array($TPL_VAR["salestoreitemloop"])?0:count($TPL_VAR["salestoreitemloop"]);?>
<div id="search_container" class="search_container">
	<form name="couponsearch" id="couponsearch" class="search_form">
	<input type="hidden" name="pageid" value="coupon_catalog" data-search_mode='<?php echo $TPL_VAR["sc"]["search_mode"]?>' data-select_date='<?php echo $TPL_VAR["sc"]["select_date"]?>' />
	<input type="hidden" name="no" value="" >
	<input type="hidden" name="query_string"/>
	<input type="hidden" name="perpage" id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" >
	<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["sc"]["page"]?>" data-defaultPage=0 >
	<input type="hidden" name="orderby" id="orderby" value="<?php echo $TPL_VAR["sc"]["orderby"]?>" >

	<table class="table_search">
		<tr <?php if(!in_array('sc_keyword',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>쿠폰명</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_keyword" class="hide"></label></th>
			<td>
				<input type="text" name="search_text" id="search_text" value="<?php echo $TPL_VAR["sc"]["search_text"]?>" size="100" title="" />
			</td>
		</tr>

		<tr <?php if(!in_array('sc_coupon_category',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>혜택 구분</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_coupon_category" class="hide"></label></th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="sc_coupon_category" value=""  <?php echo $TPL_VAR["sc"]['checkbox']['sc_coupon_category']['all']?>> 전체</label>
<?php if(is_array($TPL_R1=$TPL_VAR["sc_form"]['coupon_category'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
					<label><input type="radio" name="sc_coupon_category" value="<?php echo $TPL_K1?>"  <?php echo $TPL_VAR["sc"]['checkbox']['sc_coupon_category'][$TPL_K1]?> > <?php echo $TPL_V1?>

<?php if(count($TPL_VAR["sc_form"]['coupon_category_sub'][$TPL_K1])> 1&&$TPL_K1!='order'){?>
					<select name="sc_coupon_category_sub[]" onClick="$(this).parent().find('input:radio').prop('checked',true)">
					<option value="">전체</option>
<?php if(is_array($TPL_R2=$TPL_VAR["sc_form"]['coupon_category_sub'][$TPL_K1])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?> 
						<option value="<?php echo $TPL_K2?>" <?php if(in_array($TPL_K2,$TPL_VAR["sc"]["sc_coupon_category_sub"])){?>selected<?php }?>><?php echo $TPL_V2?></option>
<?php }}?>
					</select>
<?php }?>
					</label>
<?php }}?>
				</div>
			</td>
		</tr>

		<tr <?php if(!in_array('sc_regist_date',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>등록일</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_regist_date" class="hide"></label></th>
			<td>
			<div class="date_range_form">
				<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10" />
				-
				<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10"  />

				<div class="resp_btn_wrap">
					<input type="button" range="today" value="오늘" class="select_date resp_btn" />
					<input type="button" range="3day" value="3일간" class="select_date resp_btn" />
					<input type="button" range="1week" value="일주일" class="select_date resp_btn" />
					<input type="button" range="1month" value="1개월" class="select_date resp_btn" />
					<input type="button" range="3month" value="3개월" class="select_date resp_btn" />
					<input type="button" range="all"  value="전체" class="select_date resp_btn"/>
					<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden">
				</div>
			</div>
			</td>							
		</tr>

<?php if(serviceLimit('H_AD')){?>
		<tr <?php if(!in_array('sc_provider',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>입점사</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_provider" class="hide"></label></th>
			<td>
				<div class="ui-widget">
					<select name="provider_seq_selector" style="vertical-align:middle;">
					</select>
					<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $TPL_VAR["sc"]["provider_seq"]?>" />
				</div>
			</td>
		</tr>
<?php }?>

		<tr <?php if(!in_array('sc_issue_stop',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>발급 상태</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_issue_stop" class="hide"></label></th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="issue_stop" value=""  <?php echo $TPL_VAR["sc"]['checkbox']['issue_stop']['all']?> /> 전체</label>
					<label><input type="radio" name="issue_stop" value="1"  <?php echo $TPL_VAR["sc"]['checkbox']['issue_stop']['1']?> /> 발급 중</label>
					<label><input type="radio" name="issue_stop" value="2"  <?php echo $TPL_VAR["sc"]['checkbox']['issue_stop']['2']?> /> 발급 정지</label>
				</div>
			</td>
		</tr>

		<tr <?php if(!in_array('sc_use_type',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>온/오프라인</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_use_type" class="hide"></label></th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="use_type" value=""  <?php echo $TPL_VAR["sc"]['checkbox']['use_type']['all']?> /> 전체</label>
					<label><input type="radio" name="use_type" value="online"  <?php echo $TPL_VAR["sc"]['checkbox']['use_type']['online']?> /> 온라인 전용</label>
					<label>
						<input type="radio" name="use_type" value="offline"  <?php echo $TPL_VAR["sc"]['checkbox']['use_type']['offline']?> /> 오프라인 전용

<?php if($TPL_VAR["checkO2OService"]&&$TPL_VAR["salestoreitemloop"]){?>
						<select name="sale_store_item" class="wx150" onClick="$(this).parent().find('input[name=\'use_type\'][value=\'offline\']').prop('checked',true)">
							<option value="">전체</option>
<?php if($TPL_salestoreitemloop_1){foreach($TPL_VAR["salestoreitemloop"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["o2o_store_seq"]?>" <?php echo $TPL_VAR["sc"]['selected']['sale_store_item'][$TPL_V1["o2o_store_seq"]]?> /> <?php echo $TPL_V1["pos_name"]?></option>
<?php }}?>
<?php }?>
						</select>
					</label>
				</div>
			</td>
		</tr>

<?php if(serviceLimit('H_AD')){?>
		<tr <?php if(!in_array('sc_cost_start',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>할인 혜택 부담</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_cost_start" class="hide"></label></th>
			<td>
				<select name="cost_type" class="search_select">
					<option value="admin" <?php if($TPL_VAR["sc"]["cost_type"]=='admin'){?>selected<?php }?>>본사 부담률</option>
					<option value="provider" <?php if($TPL_VAR["sc"]["cost_type"]=='provider'){?>selected<?php }?>>입점사 부담률</option>
				</select>

				<input type="text" name="search_cost_start" size="4" maxlength="3" value="<?php echo $TPL_VAR["sc"]["search_cost_start"]?>" defaultValue='0' class="onlynumber right" />%
				~
				<input type="text" name="search_cost_end" size="4" maxlength="3" value="<?php echo $TPL_VAR["sc"]["search_cost_end"]?>" defaultValue='100' class="onlynumber right" />%
				<span class="desc">(0~100사이)</span>
			</td>
		</tr>
<?php }?>

		<tr <?php if(!in_array('sc_limit_goods_price',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>최소 주문 금액</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_limit_goods_price" class="hide"></label></th>
			<td>
				<input type="text" name="limit_goods_price" value="<?php echo $TPL_VAR["sc"]["limit_goods_price"]?>" size="7" class="line"/> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상
			</td>
		</tr>

		<tr <?php if(!in_array('sc_sale_agent',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>사용 가능 환경</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_sale_agent" class="hide"></label></th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="sale_agent" value=""  <?php echo $TPL_VAR["sc"]['checkbox']['sale_agent']['all']?> /> 전체</label>
					<label><input type="radio" name="sale_agent" value="m"  <?php echo $TPL_VAR["sc"]['checkbox']['sale_agent']['m']?> /> 모바일</label>
					<label><input type="radio" name="sale_agent" value="app"   <?php echo $TPL_VAR["sc"]['checkbox']['sale_agent']['app']?> /> 쇼핑몰앱</label>
				</div>
			</td>
		</tr>

		<tr <?php if(!in_array('sc_sale_payment',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>결제 가능 수단</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_sale_payment" class="hide"></label></th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="sale_payment" value=""  <?php echo $TPL_VAR["sc"]['checkbox']['sale_payment']['all']?>  /> 전체</label>
					<label><input type="radio" name="sale_payment" value="b"  <?php echo $TPL_VAR["sc"]['checkbox']['sale_payment']['b']?> /> 무통장</label>
				</div>
			</td>
		</tr>

	</table>

	<div class="footer search_btn_lay"></div>
</form>
</div>
<div class="cboth"></div>