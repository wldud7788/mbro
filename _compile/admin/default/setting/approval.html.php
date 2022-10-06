<?php /* Template_ 2.2.6 2022/05/17 12:36:54 /www/music_brother_firstmall_kr/admin/skin/default/setting/approval.html 000022065 */ ?>
<!-- 회원설정 : 승인/혜택 -->
<script type="text/javascript">
$(document).ready(function() {
	// 설정된 회원 타입에 따라 승인 조건 노출 변경
	var join_type = '<?php echo $TPL_VAR["join_type"]?>';
	if(join_type == 'member_only'){
		$("input[name='autoApproval_biz']").parent().parent().parent().hide();
	}else if(join_type == 'business_only'){
		$("input[name='autoApproval']").parent().parent().parent().hide();
	}
	
	$("input[name='autoApproval'][value='<?php echo $TPL_VAR["autoApproval"]?>']").attr('checked','checked');
	$("input[name='autoApproval_biz'][value='<?php echo $TPL_VAR["autoApproval_biz"]?>']").attr('checked','checked');
	$("select[name='emoneyTerm']").val('<?php echo $TPL_VAR["emoneyTerm"]?>');

	if(!$("input[name='autoApproval']:checked").val()) $("input[name='autoApproval'][value='Y']").attr('checked','checked');
	if(!$("input[name='autoApproval_biz']:checked").val()) $("input[name='autoApproval_biz'][value='Y']").attr('checked','checked');
	if(!$("input[name='emoneyJoin']").val()) $("input[name='emoneyJoin']").val(0);

	if(!$("input[name='emoneyRecommend']").val()) $("input[name='emoneyRecommend']").val(0);
	if(!$("input[name='emoneyLimit']").val()) $("input[name='emoneyLimit']").val(0);
	if(!$("input[name='emoneyJoiner']").val()) $("input[name='emoneyJoiner']").val(0);

	$("input[name='emoneyRecommend']").live("keyup",function(){
		var inpval1 = $("input[name='emoneyRecommend']").val() != '' ? $("input[name='emoneyRecommend']").val() : 0;
		var inpval2 = $("input[name='emoneyLimit']").val() != '' ? $("input[name='emoneyLimit']").val() : 0;
		var price = parseFloat(inpval1) * parseFloat(inpval2);
		$("#sprice").html(get_currency_price(price));
	});

	$("input[name='emoneyLimit']").live("keyup",function(){
		var inpval1 = $("input[name='emoneyRecommend']").val() != '' ? $("input[name='emoneyRecommend']").val() : 0;
		var inpval2 = $("input[name='emoneyLimit']").val() != '' ? $("input[name='emoneyLimit']").val() : 0;
		var price = parseFloat(inpval1) * parseFloat(inpval2);
		price = (price>0)?price:0;
		$("#sprice").html(get_currency_price(price));
	});
	$("input[name='pointRecommend']").live("keyup",function(){
		var inpval1 = $("input[name='pointRecommend']").val() != '' ? $("input[name='pointRecommend']").val() : 0;
		var inpval2 = $("input[name='pointLimit']").val() != '' ? $("input[name='pointLimit']").val() : 0;
		var price = parseFloat(inpval1) * parseFloat(inpval2);
		$("#sprice2").html(get_currency_price(price));
	});
	$("input[name='pointLimit']").live("keyup",function(){
		var inpval1 = $("input[name='pointRecommend']").val() != '' ? $("input[name='pointRecommend']").val() : 0;
		var inpval2 = $("input[name='pointLimit']").val() != '' ? $("input[name='pointLimit']").val() : 0;
		var price = parseFloat(inpval1) * parseFloat(inpval2);
		price = (price>0)?price:0;
		$("#sprice2").html(get_currency_price(price));
	});


	$("select[name='emoneyTerm_invited']").val('<?php echo $TPL_VAR["emoneyTerm_invited"]?>');

	if(!$("input[name='emoneyInvited']").val()) {
		$("input[name='emoneyInvited']").val(0);
	}

	if( !$("input[name='emoneyLimit_invited']").val() ) {
		$("input[name='emoneyLimit_invited']").val(0);
	}

	$("input[name='emoneyLimit_invited']").live("keyup",function(){
		var price_invited = parseFloat($("input[name='emoneyInvited']").val()) * parseFloat($("input[name='emoneyLimit_invited']").val());
		price_invited = (price_invited>0)?price_invited:0;
		$("#sprice_invited").html(get_currency_price(price_invited));
	});

	$("input[name='pointLimit_invited']").live("keyup",function(){
		var price_invited = parseFloat($("input[name='pointInvited']").val()) * parseFloat($("input[name='pointLimit_invited']").val());
		price_invited = (price_invited>0)?price_invited:0;
		$("#sprice_invited2").html(get_currency_price(price_invited));
	});

	apply_input_style();


	$("select[name='reserve_select']").live("change",function(){
		span_controller('reserve','');
	});
	$("select[name='point_select']").live("change",function(){
		span_controller('point','');
	});

	$("select[name='joiner_reserve_select']").live("change",function(){
		span_controller('reserve','joiner');
	});
	$("select[name='joiner_point_select']").live("change",function(){
		span_controller('point','joiner');
	});

	$("select[name='recomm_reserve_select']").live("change",function(){
		span_controller('reserve','recomm');
	});
	$("select[name='recomm_point_select']").live("change",function(){
		span_controller('point','recomm');
	});

	span_controller('reserve','');
	span_controller('point','');
	span_controller('reserve','recomm');
	span_controller('point','recomm');
	span_controller('reserve','joiner');
	span_controller('point','joiner');

	$("select[name='invit_reserve_select']").live("change",function(){
		span_controller('reserve','invit');
	});
	$("select[name='invit_point_select']").live("change",function(){
		span_controller('point','invit');
	});
	$("select[name='invited_reserve_select']").live("change",function(){
		span_controller('reserve','invited');
	});
	$("select[name='invited_point_select']").live("change",function(){
		span_controller('point','invited');
	});
	$("select[name='cnt_reserve_select']").live("change",function(){
		span_controller('reserve','cnt');
	});
	$("select[name='cnt_point_select']").live("change",function(){
		span_controller('point','cnt');
	});
	span_controller('reserve','invit');
	span_controller('point','invit');
	span_controller('reserve','invited');
	span_controller('point','invited');
	span_controller('reserve','cnt');
	span_controller('point','cnt');

	$('#reserve_year').val('<?php echo $TPL_VAR["reserve_year"]?>');
	$('#point_year').val('<?php echo $TPL_VAR["point_year"]?>');
	$('#recomm_reserve_year').val('<?php echo $TPL_VAR["recomm_reserve_year"]?>');
	$('#recomm_point_year').val('<?php echo $TPL_VAR["recomm_point_year"]?>');
	$('#joiner_reserve_year').val('<?php echo $TPL_VAR["joiner_reserve_year"]?>');
	$('#joiner_point_year').val('<?php echo $TPL_VAR["joiner_point_year"]?>');
});

function span_controller(nm, type){
	var name = type ? type+"_"+nm : nm;
	var reserve_y = $("span[name='"+name+"_y']");
	var reserve_d = $("span[name='"+name+"_d']");
	var value = $("select[name='"+name+"_select'] option:selected").val();
	if(value==""){
		reserve_y.hide();
		reserve_d.hide();
	}else if(value=="year"){
		reserve_y.show();
		reserve_d.hide();
	}else if(value=="direct"){
		reserve_y.hide();
		reserve_d.show();
	}
}
</script>

<div class="contents_dvs">
	<div class="item-title">회원 가입 승인</div>
	<table class="table_basic thl">
		<tr>		
			<th>개인 회원</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="autoApproval" id="apA1" value="Y" /> 자동 승인</label>			
					<label><input type="radio" name="autoApproval" id="apA2" value="N" /> 수동 승인</label>	
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip32')"></span>
				</div>
			</td>
		</tr>

		<tr>
			<th>사업자 회원</th>
			<td>	
				<div class="resp_radio">
					<label><input type="radio" name="autoApproval_biz" id="apA1_biz" value="Y" checked/> 자동 승인</label>			
					<label><input type="radio" name="autoApproval_biz" id="apA2_biz" value="N" /> 수동 승인</label>
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip32')"></span>
				</div>
			</td>
		</tr>
	</table>
</div>

<div class="contents_dvs">
	<div class="item-title">
		회원 가입 혜택
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip11')"></span>
	</div>

	<table class="table_basic thl">
		<tr>
			<th>마일리지</th>
			<td>
				<ul class="ul_list_08">
					<li class="wx150"><input type="text" name="emoneyJoin" value="<?php echo $TPL_VAR["emoneyJoin"]?>" size="10" class="line onlyfloat right" /><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 지급</li>
					<li>
						 유효기간 :
						 <select name="reserve_select">
							<option value="">제한하지 않음</option>
							<option value="year" <?php if($TPL_VAR["reserve_select"]=='year'){?>selected<?php }?>>제한</option>
							<option value="direct" <?php if($TPL_VAR["reserve_select"]=='direct'){?>selected<?php }?>>제한(직접입력)</option>
						</select>
						<span name="reserve_y" class="hide">지급연도 + 
							<select name="reserve_year" id="reserve_year">
								<option value="0">0년</option>
								<option value="1">1년</option>
								<option value="2">2년</option>
								<option value="3">3년</option>
								<option value="4">4년</option>
								<option value="5">5년</option>
								<option value="6">6년</option>
								<option value="7">7년</option>
								<option value="8">8년</option>
								<option value="9">9년</option>
								<option value="10">10년</option>
							</select>
							년의 12월 31일
						</span>
						<span name="reserve_d" class="hide"><input type="text" name="reserve_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["reserve_direct"]?>" /> 개월</span>
					</li>				
				</ul>			
			</td>
		</tr>
		
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
		<tr>
			<th>포인트</th>
			<td>
				<span <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly="readonly" disabled='disabled'  class="gray readonly"  <?php }?>  >
					<ul class="ul_list_08">
						<li class="wx150"><input type="text" name="pointJoin" value="<?php echo $TPL_VAR["pointJoin"]?>" size="10" class="line onlyfloat right" />P 지급</li>
						<li>
							 유효기간 : 
							 <select name="point_select" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly="readonly" disabled='disabled'  class="gray readonly"  <?php }?>  >
								<option value="">제한하지 않음</option>
								<option value="year" <?php if($TPL_VAR["point_select"]=='year'){?>selected<?php }?>>제한</option>
								<option value="direct" <?php if($TPL_VAR["point_select"]=='direct'){?>selected<?php }?>>제한(직접입력)</option>
							</select>
								<span name="point_y" class="hide">지급연도 + 
								<select name="point_year" id="point_year">
									<option value="0">0년</option>
									<option value="1">1년</option>
									<option value="2">2년</option>
									<option value="3">3년</option>
									<option value="4">4년</option>
									<option value="5">5년</option>
									<option value="6">6년</option>
									<option value="7">7년</option>
									<option value="8">8년</option>
									<option value="9">9년</option>
									<option value="10">10년</option>
								</select>
								년의 12월 31일</span>
								<span name="point_d" class="hide"><input type="text" name="point_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["point_direct"]?>" /> 개월</span>
						</li>
					</ul>				
				</span>
			</td>
		</tr>
<?php }?>

		<tr>
			<th>특정 기간 혜택 제공</th>
			<td>
				<ul class="ul_list_08">
					<li class="mr20" >
						<input type="text" name="start_date" value="<?php echo $TPL_VAR["start_date"]?>" class="datepicker line"  maxlength="10" size="10" /> ~ 
						<input type="text" name="end_date" value="<?php echo $TPL_VAR["end_date"]?>" class="datepicker line"  maxlength="10" size="10" />
					</li>
					<li>
						마일리지 <input type="text" name="emoneyJoin_limit" value="<?php echo $TPL_VAR["emoneyJoin_limit"]?>" size="6" class="line onlyfloat right" /><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>

						<span <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly="readonly" disabled='disabled'  class="gray readonly"  <?php }?>  >
						
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?> 
						, 포인트 <input type="text" name="pointJoin_limit" value="<?php echo $TPL_VAR["pointJoin_limit"]?>" size="6" class="line onlyfloat right" />P 지급
<?php }?>
						</span>
					</li>
				</ul>		
			</td>
		</tr>
	</table>
</div>

<div class="contents_dvs">
	<div class="item-title">
		추천인 혜택
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip12', 'sizeM')"></span>
	</div>

	<table class="table_basic thl">
		<tr>
			<th>기존 회원</th>
			<td class="clear">
				<table class="table_basic v3 thl">
					<tr>
						<th>마일리지</th>
						<td>
							<ul class="ul_list_08">
								<li class="wx150"><input type="text" name="emoneyRecommend" value="<?php echo $TPL_VAR["emoneyRecommend"]?>" size="10" class="line onlyfloat right" /><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 지급</li>
								<li class="mr20">
									유효기간 :
									<select name="recomm_reserve_select">
										<option value="">제한하지 않음</option>
										<option value="year" <?php if($TPL_VAR["recomm_reserve_select"]=='year'){?>selected<?php }?>>제한</option>
										<option value="direct" <?php if($TPL_VAR["recomm_reserve_select"]=='direct'){?>selected<?php }?>>제한(직접입력)</option>
									</select>
									<span name="recomm_reserve_y" class="hide">
										지급연도 + 
										<select name="recomm_reserve_year" id="recomm_reserve_year">
											<option value="0">0년</option>
											<option value="1">1년</option>
											<option value="2">2년</option>
											<option value="3">3년</option>
											<option value="4">4년</option>
											<option value="5">5년</option>
											<option value="6">6년</option>
											<option value="7">7년</option>
											<option value="8">8년</option>
											<option value="9">9년</option>
											<option value="10">10년</option>
										</select>
										년의 12월 31일
									</span>
									<span name="recomm_reserve_d" class="hide">
										<input type="text" name="recomm_reserve_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["recomm_reserve_direct"]?>" />개월
									</span>
								</li>
								<li>							
									단, 월<input type="hidden" name="emoneyTerm" value="month" >
									<input type="text" name="emoneyLimit" value="<?php if($TPL_VAR["emoneyLimit"]> 0){?><?php echo $TPL_VAR["emoneyLimit"]?><?php }else{?>1<?php }?>" size="6" class="line onlynumber right" />회(최대 <span id="sprice"><?php if($TPL_VAR["emoneyLimit"]> 0){?><?php echo get_currency_price($TPL_VAR["emoneyLimit"]*$TPL_VAR["emoneyRecommend"])?><?php }else{?>0<?php }?></span><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>)으로 제한 
								</li>
							</ul>						
						</td>
					</tr>

<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
					<tr>
						<th>포인트</th>
						<td>
							<span <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly="readonly" disabled='disabled'  class="gray readonly"  <?php }?>  >
								<ul class="ul_list_08">
									<li class="wx150"><input type="text" name="pointRecommend" value="<?php echo $TPL_VAR["pointRecommend"]?>" size="10" class="line onlyfloat right" />P 지급</li>
									<li class="mr20">
										 유효기간 : 
										 <select name="recomm_point_select" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly="readonly" disabled='disabled'  class="gray readonly"  <?php }?>  >
											<option value="">제한하지 않음</option>
											<option value="year" <?php if($TPL_VAR["recomm_point_select"]=='year'){?>selected<?php }?>>제한</option>
											<option value="direct" <?php if($TPL_VAR["recomm_point_select"]=='direct'){?>selected<?php }?>>제한(직접입력)</option>
										</select>
										<span name="recomm_point_y" class="hide">
											지급연도 + 
											<select name="recomm_point_year" id="recomm_point_year">
												<option value="0">0년</option>
												<option value="1">1년</option>
												<option value="2">2년</option>
												<option value="3">3년</option>
												<option value="4">4년</option>
												<option value="5">5년</option>
												<option value="6">6년</option>
												<option value="7">7년</option>
												<option value="8">8년</option>
												<option value="9">9년</option>
												<option value="10">10년</option>
											</select>
											년의 12월 31일
										</span>
										<span name="recomm_point_d" class="hide">
											<input type="text" name="recomm_point_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["recomm_point_direct"]?>" /> 개월
										</span>																	
									</li>
									<li>							
										단, 월<input type="hidden" name="pointTerm" value="month" >
										<input type="text" name="pointLimit" value="<?php if($TPL_VAR["pointLimit"]> 0){?><?php echo $TPL_VAR["pointLimit"]?><?php }else{?>1<?php }?>" size="6" class="line onlynumber right" />회(최대 <span id="sprice2"><?php if($TPL_VAR["pointLimit"]> 0){?><?php echo get_currency_price($TPL_VAR["pointLimit"]*$TPL_VAR["pointRecommend"])?><?php }else{?>0<?php }?></span>P)으로 제한
									</li>
								</ul>		
							</span>	
						</td>
					</tr>
<?php }?>
				</table>
			</td>
		</tr>

		<tr>
			<th>신규 회원</th>
			<td class="clear">
				<table class="table_basic v3 thl">
					<tr>
						<th>마일리지</th>
						<td>
							<ul class="ul_list_08">
								<li class="wx150"><input type="text" name="emoneyJoiner" value="<?php echo $TPL_VAR["emoneyJoiner"]?>" size="10" class="line onlyfloat right" /><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 지급</li>
								<li class="mr20">
									유효기간 :
									<select name="joiner_reserve_select">
										<option value="">제한하지 않음</option>
										<option value="year" <?php if($TPL_VAR["joiner_reserve_select"]=='year'){?>selected<?php }?>>제한</option>
										<option value="direct" <?php if($TPL_VAR["joiner_reserve_select"]=='direct'){?>selected<?php }?>>제한(직접입력)</option>
									</select>
									<span name="joiner_reserve_y" class="hide">
										지급연도 + 
										<select name="joiner_reserve_year" id="joiner_reserve_year">
											<option value="0">0년</option>
											<option value="1">1년</option>
											<option value="2">2년</option>
											<option value="3">3년</option>
											<option value="4">4년</option>
											<option value="5">5년</option>
											<option value="6">6년</option>
											<option value="7">7년</option>
											<option value="8">8년</option>
											<option value="9">9년</option>
											<option value="10">10년</option>
										</select>
										년의 12월 31일
									</span>
									<span name="joiner_reserve_d" class="hide">
										<input type="text" name="joiner_reserve_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["joiner_reserve_direct"]?>" /> 개월
									</span>
								</li>							
							</ul>					
						</td>
					</tr>

					<tr>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
						<th>포인트</th>
						<td>
							<span <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly="readonly" disabled='disabled'  class="gray readonly"  <?php }?>  >
								<ul class="ul_list_08">
									<li class="wx150"><input type="text" name="pointJoiner" value="<?php echo $TPL_VAR["pointJoiner"]?>" size="10" class="line onlyfloat right" />p 지급 </li>
									<li class="mr20">
										유효기간 :
										<select name="joiner_point_select" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly="readonly" disabled='disabled'  class="gray readonly"  <?php }?>  >
											<option value="">제한하지 않음</option>
											<option value="year" <?php if($TPL_VAR["joiner_point_select"]=='year'){?>selected<?php }?>>제한</option>
											<option value="direct" <?php if($TPL_VAR["joiner_point_select"]=='direct'){?>selected<?php }?>>제한(직접입력)</option>
										</select>
										<span name="joiner_point_y" class="hide">
											지급연도 + 
											<select name="joiner_point_year" id="joiner_point_year">
												<option value="0">0년</option>
												<option value="1">1년</option>
												<option value="2">2년</option>
												<option value="3">3년</option>
												<option value="4">4년</option>
												<option value="5">5년</option>
												<option value="6">6년</option>
												<option value="7">7년</option>
												<option value="8">8년</option>
												<option value="9">9년</option>
												<option value="10">10년</option>
											</select>
											년의 12월 31일
										</span>
										<span name="joiner_point_d" class="hide">
											<input type="text" name="joiner_point_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["joiner_point_direct"]?>" /> 개월
										</span>
									</li>							
								</ul>
							</span>	
						</td>
					</tr>
<?php }?>
				</table>
			</td>
		</tr>
	</table>
</div>