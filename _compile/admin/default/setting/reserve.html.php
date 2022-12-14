<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/setting/reserve.html 000027486 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<style>
.label { cursor:pointer }
</style>
<script type="text/javascript">
function check_max_emoney_policy(){
	$("input[name='max_emoney_policy']").each(function(idx){
		if( idx != 0 ){
			var obj =$(this).parent().find("input[type='text']");
			if( $(this).attr("checked") == "checked" ){
				obj.removeAttr("readonly");
			}else{
				obj.val('');
				obj.attr("readonly",true);
			}
		}
	});
}

$(document).ready(function() {

	$('body,input,textarea,select').bind('keydown','Ctrl+s',function(event){
		event.preventDefault();
		$("form#settingForm")[0].submit();
	});

	$("input[name='max_emoney_policy']").bind("click",function(){
		check_max_emoney_policy();
	});

	$(".label").live("click",function(){
		$(this).parent().find("input[type='radio'], input[type='checkbox']").click();
		check_max_emoney_policy();
	});

	$("#setting_basic").click(function(){
		document.location.href='/admin/setting/multi';
	});

	$(".promotioncodehelperbtn").click(function() {
		openDialog("프로모션 코드 안내", "promotioncodehelperlay", {"width":"800","height":"480","show" : "fade","hide" : "fade"});
	});


<?php if($TPL_VAR["max_emoney_policy"]){?>
	$("input[name='max_emoney_policy'][value='<?php echo $TPL_VAR["max_emoney_policy"]?>']").attr('checked',true);
<?php }?>

	$("input[name='point_use'][value='<?php echo $TPL_VAR["point_use"]?>']").attr('checked',true);
	$("input[name='cash_use'][value='<?php echo $TPL_VAR["cash_use"]?>']").attr('checked',true);
	$("input[name='default_point_type'][value='<?php echo $TPL_VAR["default_point_type"]?>']").attr('checked',true);
	//$("input[name='save_step'][value='<?php echo $TPL_VAR["save_step"]?>']").attr('checked',true);

	//$("select[name='save_term']").val('<?php echo $TPL_VAR["save_term"]?>').attr("selected",true);
	//$("select[name='save_type']").val('<?php echo $TPL_VAR["save_type"]?>').attr("selected",true);
	$("select[name='reserve_select']").val('<?php echo $TPL_VAR["reserve_select"]?>').attr("selected",true);
	$("select[name='point_select']").val('<?php echo $TPL_VAR["point_select"]?>').attr("selected",true);
	$("select[name='exchange_emoney_select']").val('<?php echo $TPL_VAR["exchange_emoney_select"]?>').attr("selected",true);

	span_controller('reserve');
	span_controller('point');
	span_controller('exchange_emoney');

	check_max_emoney_policy();

	$("select[name='reserve_select']").live("change",function(){
		span_controller('reserve');
	});

	$("input[name='point_use']").on("change",function(){
		pointContent();
	});

	$("select[name='exchange_emoney_select']").live("change",function(){
		span_controller('exchange_emoney');
	});

	$("select[name='point_select']").live("change",function(){
		span_controller('point');
	});

	$("#infos").live("click",function(){
		openDialog("구매 시 마일리지/포인트 적립 금액 안내", "infoPopup", {"width":"1000","height":"580","show" : "fade","hide" : "fade"});
	});


	$("input[name=emoney_exchange_use]").change(function(){	
		if( $("input[name=emoney_exchange_use]:checked").val() == 'y' ){
			$(".emoney_exchange_uselay").show()
			$(".emoney_exchange_uselay").find("input,select").removeClass("gray");
			$(".emoney_exchange_uselay").find("input,select").removeClass("readonly");
			$(".emoney_exchange_uselay").find("input,select").removeAttr('disabled');
			$(".emoney_exchange_uselay").find("input,select").removeAttr('readonly');
		}else{
			$(".emoney_exchange_uselay").hide();
			$(".emoney_exchange_uselay").find("input,select").addClass("gray");
			$(".emoney_exchange_uselay").find("input,select").addClass("readonly");
			$(".emoney_exchange_uselay").find("input,select").attr('disabled',true);
			$(".emoney_exchange_uselay").find("input,select").attr('readonly',true);
			
		}
	}).change();

	$('#exchange_emoney_year').val('<?php echo $TPL_VAR["exchange_emoney_year"]?>');

	$('#reserve_year').val('<?php echo $TPL_VAR["reserve_year"]?>');
	$('#point_year').val('<?php echo $TPL_VAR["point_year"]?>');
	pointContent()
});

function span_controller(name){
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

function pointContent()
{
	if($("input[name='point_use']:checked").val()=="Y")
	{
		$(".point_con").show();		
		$(".valid_term").removeClass("gray");
		$(".valid_term").find("input,select").removeClass("gray");
		$(".valid_term").find("input,select").removeClass("readonly");
		$(".valid_term").find("input,select").attr('disabled', false);
		$(".valid_term").find("input,select").attr('readonly', false);
		$("input[name=emoney_exchange_use]").attr("disabled", false);			
	}else{
		$(".point_con").hide();		
		$("input[name=emoney_exchange_use]").attr("disabled", true);		
		$(".valid_term").addClass("gray");
		$(".valid_term").find("input,select").addClass("gray");
		$(".valid_term").find("input,select").addClass("readonly");
		$(".valid_term").find("input,select").attr('disabled', true);
		$(".valid_term").find("input,select").attr('readonly', true);		
	}
}
</script>

<form name="settingForm" id="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/reserve" target="actionFrame">

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
			<h2>마일리지/포인트/예치금</h2>
		</div>

		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<button  class="resp_btn active size_L" type="submit">저장</button>
		</div>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<!-- 서브메뉴 바디 : 시작-->
<ul class="tab_02 tabEvent">
	<li><a href="#mileage" data-showcontent="mileage">마일리지</a></li>
	<li>
		<a href="#point" 
<?php if(serviceLimit('H_NFR')){?>
			data-showcontent="point" 
<?php }else{?>
			data-other="" onclick="openDialog('쇼핑몰 업그레이드 안내<span class=\'desc\'></span>', 'nofreeService', {'width':600,'height':260});"
<?php }?>
		>포인트</a>
	</li>
	<li>
		<a href="#cash" 
<?php if(serviceLimit('H_NFR')){?>
			data-showcontent="cash" 
<?php }else{?>
			data-other="" onclick="openDialog('쇼핑몰 업그레이드 안내<span class=\'desc\'></span>', 'nofreeService', {'width':600,'height':260});"
<?php }?>
		>예치금</a>
	</li>
</ul>

<div id="mileage" class="hide">
	<div class="contents_dvs">
		<div class="item-title">
			마일리지
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/reserve', '#tip1', 'sizeM')"></span>
		</div>

		<table class="table_basic thl">
			<tr>
				<th>사용 여부</th>
				<td>
					사용함
<?php if(serviceLimit('H_FR')){?>
					<input type="hidden" name="point_use" value="N"/>
					<input type="hidden" name="cash_use" value="N"/>
<?php }?>
				</td>
			</tr>					
		</table>
	</div>

	<div class="contents_dvs">
		<div class="item-title">마일리지 사용 조건</div>
		<table class="table_basic thl">
			<tr>
				<th>보유 마일리지</th>
				<td>
					보유 마일리지가
					<input type="text" name="emoney_use_limit" class="line onlyfloat right" size="5" value="<?php echo $TPL_VAR["emoney_use_limit"]?>" /><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상이면 사용 가능
				</td>					
			</tr>
			
			<tr>
				<th>
					상품 금액
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/reserve', '#tip5')"></span>
				</th>
				<td>
					&#123;상품 실 결제금액&#125;+&#123;좌동&#125;+&#123;좌동&#125;…
					<input type="text" name="emoney_price_limit" size="5" class="line onlyfloat right" value="<?php echo $TPL_VAR["emoney_price_limit"]?>" /><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상이면 사용 가능
					
				</td>
			</tr>

			<tr>
				<th>마일리지 사용 한도</th>
				<td>
					<span class="fl">
						<b>최소</b> 
						<input type="text" name="min_emoney" size="5" class="line onlyfloat right" value="<?php echo $TPL_VAR["min_emoney"]?>" /><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상&nbsp;&nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;&nbsp;
						<b>최대</b>
					</span>
				
					<ul class="fl ml20 resp_radio col">
						<li><label><input type="radio" name="max_emoney_policy" value="unlimit" checked="checked" /> 1회 사용한도 제한 없이 사용 가능</label></li>
						<li>
							<label>									
								<input type="radio" name="max_emoney_policy" value="percent_limit" />
								&#123;상품 실 결제금액&#125;+&#123;좌동&#125;+&#123;좌동&#125;…
								<input type="text" name="max_emoney_percent" size="5" class="line onlyfloat percent right" value="<?php echo $TPL_VAR["max_emoney_percent"]?>" />				
								% 금액까지 사용 가능
							</label>
						</li>
						<li>
							<label>
								<input type="radio" name="max_emoney_policy" value="price_limit" /> 
								<input type="text" name="max_emoney" size="5" class="line onlyfloat right" value="<?php echo $TPL_VAR["max_emoney"]?>" />
								<?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 까지 사용 가능
							</label>
						</li>
					</ul>
				</td>
			</tr>

			<tr>
				<th>마일리지 사용 단위</th>
				<td>
					<select name="emoney_using_unit">
						<option value="3" <?php if($TPL_VAR["emoney_using_unit"]== 3){?>selected="selected"<?php }?>>1000(천단위)</option>
						<option value="2" <?php if($TPL_VAR["emoney_using_unit"]== 2){?>selected="selected"<?php }?>>100(백단위)</option>
						<option value="1" <?php if($TPL_VAR["emoney_using_unit"]== 1){?>selected="selected"<?php }?>>10(십단위)</option>
						<option value="0" <?php if($TPL_VAR["emoney_using_unit"]== 0){?>selected="selected"<?php }?>>1(일단위)</option>
						<option value="0.1" <?php if($TPL_VAR["emoney_using_unit"]== 0.1){?>selected="selected"<?php }?>>0.1(소수첫째자리)</option>
						<option value="0.01" <?php if($TPL_VAR["emoney_using_unit"]== 0.01){?>selected="selected"<?php }?>>0.01(소수둘째자리)</option>
					</select>로 마일리지 사용 가능
				</td>
			</tr>
		</table>	
	</div>
	
	<div class="contents_dvs">
		<div class="title_dvs">
			<div class="item-title">
				마일리지 지급
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/reserve', '#tip6')"></span>
			</div>
			<button type="button" class="resp_btn" id="infos">적립 금액 안내</button>
		</div>

		<table class="table_basic thl">
			<tr>
				<th>상품</th>
				<td>
					결제금액의 <input type="text" name="default_reserve_percent" size="5" class="line onlyfloat percent right" value="<?php echo $TPL_VAR["default_reserve_percent"]?>" />% 를 마일리지로 지급
					<div class="fx11 gray">- 상품별 마일리지 제공 설정은 상품 등록/수정 페이지에서 가능합니다.</div>
				</td>					
			</tr>
			
			<tr>
				<th>마일리지 사용 지급 한도</th>
				<td>
					<div class="resp_radio col">
						<label><input type="radio" name="default_reserve_limit" value="0" checked="checked" /> A) 상품금액에서 마일리지 차감 전 할인금액을 뺀 기준으로 마일리지 지급</label><br />
						<label><input type="radio" name="default_reserve_limit" value="3" <?php if($TPL_VAR["default_reserve_limit"]== 3){?>checked="checked"<?php }?> /> B) 결제금액(배송비를 뺀 금액) 기준으로 마일리지 지급</label><br />
						<label><input type="radio" name="default_reserve_limit" value="2" <?php if($TPL_VAR["default_reserve_limit"]== 2){?>checked="checked"<?php }?> /> C) 적립예정 마일리지에서 사용한 마일리지를 뺀 마일리지를 지급</label><br />
						<label><input type="radio" name="default_reserve_limit" value="1" <?php if($TPL_VAR["default_reserve_limit"]== 1){?>checked="checked"<?php }?> /> D) 마일리지 사용시 마일리지 지급 안함 (※ 단, 마일리지 미 사용시 설정 A로 마일리지 지급)</label>
					</div>
				</td>
			</tr>

			<tr>
				<th>유효 기간</th>
				<td>
					<select name="reserve_select">
						<option value="">제한하지 않음</option>
						<option value="year">제한 - 12월31일</option>
						<option value="direct">제한 - 직접입력</option>
					</select>
					<span name="reserve_y" class="hide">→ 지급연도 + 
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
					년 12월 31일</span>
					<span name="reserve_d" class="hide">→ <input type="text" name="reserve_direct" class="line onlynumber right" size="3" value="<?php echo $TPL_VAR["reserve_direct"]?>" />개월</span>
				</td>
			</tr>
		</table>
		<div class="resp_message">- 상품 구매시 마일리지 지급 금액 제한 조건 예시 <a href="https://www.firstmall.kr/customer/faq/1126" class="link_blue_01" target="_blank">자세히 보기</a></div>
	</div>
</div>

<div id="point" class="hide">
	<div class="contents_dvs">
		<div class="item-title">
			포인트
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/reserve', '#tip9', 'sizeR')"></span>
		</div>

		<table class="table_basic thl">					
			<tr>
				<th>사용 여부</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="point_use" value="Y"/> 사용함</label>	
						<label><input type="radio" name="point_use" value="N"/> 사용 안 함</label>		
					</div>
				</td>
			</tr>
		</table>
	</div>

	<div class="point_con">
		<div class="contents_dvs">
			<div class="item-title">
				포인트 지급
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/reserve', '#tip7')"></span>
			</div>

			<table class="table_basic thl">
				<tr>
					<th>상품</th>
					<td>
						<div class="resp_radio">
							<label>
								<input type="radio" name="default_point_type" value="per"> 상품 실 결제금액의 <input type="text" name="default_point_percent" size="5" class="line onlynumber percent right" value="<?php echo $TPL_VAR["default_point_percent"]?>" />% 금액을 포인트로 지급
							</label>
							<label>
								<input type="radio" name="default_point_type" value="app"> 상품 실 결제금액 
								<input type="text" name="default_point_app" size="5" class="line onlyfloat right" value="<?php echo $TPL_VAR["default_point_app"]?>" /><?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 당  <input type="text" name="default_point" size="5" class="line onlynumber right" value="<?php echo $TPL_VAR["default_point"]?>" />P 지급
							</label>
						</div>
					</td>
				</tr>
<?php if($TPL_VAR["isplusfreenot"]){?>
				<tr>
					<th>유효 기간</th>
					<td>
						<span class="valid_term" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly='readonly' disabled='disabled'class='gray readonly'  <?php }?>  >
						<select name="point_select" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly='readonly' disabled='disabled'class='gray readonly'  <?php }?> >
							<option value="">제한하지 않음</option>
							<option value="year">제한 - 12월31일</option>
							<option value="direct">제한 - 직접입력</option>
						</select>
						<span name="point_y" class="hide">→ 지급연도 + 
						<select name="point_year" id="point_year" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly='readonly' disabled='disabled' class='gray readonly'  <?php }?>>
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
						년 12월 31일</span>
						<span name="point_d" class="hide">→ <input type="text" name="point_direct" class="line onlynumber right" size="3" value="<?php echo $TPL_VAR["point_direct"]?>" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly='readonly' disabled='disabled'class='gray readonly'  <?php }?> />개월</span></span>
					</td>					
				</tr>
<?php }?>
			</table>			
		</div>		
		<div class="contents_dvs">
			<div class="item-title">포인트 교환</div>
			<table class="table_basic thl">
				<tr>
					<th>
						마일리지로 교환
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/reserve', '#tip8')"></span>
					</th>
					<td>
						<div class="resp_radio">
							<label><input type="radio" name="emoney_exchange_use" value="y" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly='readonly' disabled='disabled'class='gray readonly'  <?php }?> <?php if($TPL_VAR["emoney_exchange_use"]=='y'){?>checked<?php }?>> 사용함</label>
							<label><input type="radio" name="emoney_exchange_use" value="n" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly='readonly' disabled='disabled'class='gray readonly' <?php }?> <?php if($TPL_VAR["emoney_exchange_use"]!='y'){?>checked<?php }?>> 사용 안 함 (마일리지로 교환 불가능)</label>
						</div>
					</td>
				</tr>
				
				<tr class="emoney_exchange_uselay">
					<th>교환 비율</th>
					<td>
						<input type="text" name="point_rate" value="<?php echo $TPL_VAR["emoney_point_rate"]?>" size="6" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly='readonly' disabled='disabled'class='gray readonly right'  <?php }?> title="0"> P를 마일리지 1<?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>으로 교환							
					</td>
				</tr>	
				
				<tr class="emoney_exchange_uselay">
					<th>최소 교환 포인트</th>
					<td>
						<input type="text" name="minum_point" value="<?php echo $TPL_VAR["emoney_minum_point"]?>" size="6" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly='readonly' disabled='disabled'class='gray readonly right'  <?php }?> title="0"> P								
					</td>
				</tr>				

				<tr class="emoney_exchange_uselay">
					<th>유효 기간</th>
					<td>					
						<select name="exchange_emoney_select" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly='readonly' disabled='disabled'class='gray readonly'  <?php }?> >
							<option value="">제한하지 않음</option>
							<option value="year">제한 - 12월31일</option>
							<option value="direct">제한 - 직접입력</option>
						</select>
						<span name="exchange_emoney_y" class="hide">→ [지급연도 + 
						<select name="exchange_emoney_year" id="exchange_emoney_year" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly='readonly' disabled='disabled'class='gray readonly'  <?php }?>>
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
						]년도 12월 31일</span>
						<span name="exchange_emoney_d" class="hide">→ <input type="text" name="exchange_emoney_direct" class="line onlynumber right" size="3" value="<?php echo $TPL_VAR["exchange_emoney_direct"]?>" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly='readonly' disabled='disabled'class='gray readonly'  <?php }?> />개월</span>
					</td>
				</tr>				
			</table>
		</div>
	</div>
</div>

<div id="cash" class="hide">
	<div class="contents_dvs">
		<div class="item-title">
			예치금
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/reserve', '#tip10', 'sizeM')"></span>
		</div>
		<table class="table_basic thl">
			<tr>
				<th>사용 여부</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="cash_use" value="Y"/> 사용함</label>
						<label><input type="radio" name="cash_use" value="N"/> 사용 안 함</label>
					</div>
				</td>
			</tr>					
		</table>
	</div>
</div>


<!-- 서브메뉴 바디 : 끝 -->
<!-- 서브 레이아웃 영역 : 끝 -->
</form>

<!-- #POP -->
<div id="infoPopup" style="display:none;">
	<table class="table_basic">
	
	<tr>
		<th>구매 시 적립 상품</th>
		<td>
			↓아래 예시와 같이 보낸 상품수량에 해당되는 마일리지액만 정확하게 지급됩니다.<br>
			동일 상품 10개 주문(마일리지 100원) → 상품 10개를 발송하여 마일리지 1,000원 지급<br>
			동일 상품 10개 주문(마일리지 100원) → 상품 1개를 발송하여 마일리지 100원 지급
		</td>
	</tr>
	<tr>
		<th>구매 시 적립 금액</th>
		<td>
			<span style="color:red;">실 결제금액(9,000)</span> = 할인가(10,000) – 할인(1,000)<br>
			최종 결제금액 = 배송비 + <span style="color:red;">실 결제금액</span> – 사용 마일리지액<br>
			<table class="table_basic v7 v10 pd5 mt5">
			<tr>
				<th rowspan="2" align="center">단가</th>
				<th rowspan="2" align="center">수량</th>
				<th rowspan="2" align="center">할인가</th>
				<th colspan="4" align="center">할인</th>
			</tr>
			<tr>
				<th align="center">상품쿠폰</th>
				<th align="center">회원등급</th>
				<th align="center">상품Like</th>
				<th align="center">모바일</th>
			</tr>
			<tr>
				<td align="right" style="padding-right:7px;">1,000원</td>
				<td align="right" style="padding-right:7px;">10개</td>
				<td align="right" style="padding-right:7px;">10,000원</td>
				<td align="right" style="padding-right:7px;">250원</td>
				<td align="right" style="padding-right:7px;">250원</td>
				<td align="right" style="padding-right:7px;">250원</td>
				<td align="right" style="padding-right:7px;">250원</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th>구매 시 적립 시점</th>
		<td>
			`구매확정`에 대한 안내<br>
			<table class="table_basic v7 v10 mt5 pd5">
			
			<col width="18%"/>
			<col width="18%"/>
			<col width="10%"/>
			<col width="10%"/>
			<col width="18%"/>
			<col width="10%"/>
			<col width="16%"/>

			<tr>
				<th align="center">조건</th>
				<th align="center">행위</th>
				<th align="center">마일리지</th>
				<th align="center">포인트</th>
				<th align="center">구매확정</th>
				<th align="center">배송완료</th>
				<th align="center">이메일, SMS</th>
			</tr>
			<tr>
				<td align="center" rowspan="2">설정 기간 내에만</td>
				<td align="center">소비자가 구매확정</td>
				<td align="center">○</td>
				<td align="center">○</td>
				<td align="center">○(구매자)</td>
				<td align="center">○</td>
				<td align="center">○</td>
			</tr>
			<tr>
				<td align="center">관리자가 구매확정</td>
				<td align="center">○</td>
				<td align="center">○</td>
				<td align="center">○(관리자)</td>
				<td align="center">○</td>
				<td align="center">○</td>
			</tr>
			<tr>
				<td align="center">설정 기간 경과 후</td>
				<td align="center">관리자가 구매확정</td>
				<td align="center">△</td>
				<td align="center">△</td>
				<td align="center">○(자동/관리자)</td>
				<td align="center">○</td>
				<td align="center">○</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>

<div  id="promotioncodehelperlay"  class="hide" >
	<div style="margin:10px;"><span class="bold">프로모션 코드란?</span> 구매자가 온라인 쇼핑몰에서 물건을 구매할 때 할인 받을 수 있는 코드로 누구나 쉽게 사용할 수 있습니다.</div>
	<div style="border:0px #dddddd solid;padding:3px;width:95%;line-height:20px;">
	<table width="100%" class="info-table-style" align="center" >
	<colgroup><col width="100" /><col width="150" /><col width="150" /></colgroup>
	<tbody>
		<tr>
			<th class="its-th center" colspan="3"> 프로모션 코드 vs. 쿠폰 비교</th>
		</tr>
		<tr>
			<th class="its-th center" >비교 대상</th>
			<th class="its-th bold center" >프로모션 코드</th>
			<th class="its-th bold center" >쿠폰</th>
		</tr>
		<tr>
			<th class="its-th center" >배포 방법</th>
			<td class="its-td red center" >코드값 공개 (다운로드 불필요)</td>
			<td class="its-td red center" >소비자 다운로드</td>
		</tr>

		<tr>
			<th class="its-th center" >유효기간</th>
			<td class="its-td center" >유효기간 세팅 가능</td>
			<td class="its-td center" >(좌동)</td>
		</tr>
		<tr>
			<th class="its-th center" >혜택</th>
			<td class="its-td center" >구매 시 할인금액 세팅 가능</td>
			<td class="its-td center" >(좌동)</td>
		</tr>

		<tr>
			<th class="its-th center" >사용제한 – 구매금액</th>
			<td class="its-td center" >세팅 가능</td>
			<td class="its-td center" >(좌동)</td>
		</tr>
		<tr>
			<th class="its-th center" >사용제한 – 선착순</th>
			<td class="its-td center" >선착순 사용 제한 세팅 가능</td>
			<td class="its-td center" >다운로드 횟수 및 기간제한 세팅 가능</td>
		</tr>

		<tr>
			<th class="its-th center" >사용제한 - 회원</th>
			<td class="its-td red center" >비회원,회원 모두 사용 가능 <br/>(회원만 사용하도록 세팅도 가능)</td>
			<td class="its-td red center" >회원만 사용 가능</td>
		</tr>
		<tr>
			<th class="its-th center" >사용제한 - 상품</th>
			<td class="its-td center" >사용 가능 상품 세팅 가능</td>
			<td class="its-td center" >(좌동)</td>
		</tr>
		</tbody>
	</table>
	</div>
</div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>