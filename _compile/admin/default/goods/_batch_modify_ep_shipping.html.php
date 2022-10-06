<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_ep_shipping.html 000017384 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<style type="text/css">
.non-boder { border:0 !important; }
</style>
<br class="table-gap" />
<script type="text/javascript">
	// EP 마케팅 배송구분 설정
	function feed_ship_chk(obj){
		var feed_ship_type	= $(obj).val();
		$(obj).closest('.feed-ship-lay').find('div.fst-lay').hide();
		$(obj).closest('.feed-ship-lay').find('div.feed_ship_type_' + feed_ship_type).show();
	}

	// EP 마켓팅 배송데이터 설정 :: 2017-02-22 lwh
	function ep_market_set(obj){
		var feed_pay_type = $(obj).val();

		if (feed_pay_type == 'postpay')	{ 
			$(obj).closest('.feed-ship-lay').find('.feed_add_txt').attr('disabled', true);
			$(obj).closest('.feed-ship-lay').find('.feed_add_txt').val('');
			$(obj).closest('.feed-ship-lay').find('.feed_std_fixed').attr('disabled', true);
			$(obj).closest('.feed-ship-lay').find('.feed_std_fixed').val('');
			$(obj).closest('.feed-ship-lay').find('.feed_std_postpay').attr('disabled', false);
		} else if (feed_pay_type == 'fixed'){							
			$(obj).closest('.feed-ship-lay').find('.feed_add_txt').attr('disabled', true);
			$(obj).closest('.feed-ship-lay').find('.feed_add_txt').val('');
			$(obj).closest('.feed-ship-lay').find('.feed_std_postpay').attr('disabled', true);
			$(obj).closest('.feed-ship-lay').find('.feed_std_postpay').val('');
			$(obj).closest('.feed-ship-lay').find('.feed_std_fixed').attr('disabled', false);
		} else {							
			$(obj).closest('.feed-ship-lay').find('.feed_add_txt').attr('disabled', false);
			$(obj).closest('.feed-ship-lay').find('.feed_std_postpay').attr('disabled', true);
			$(obj).closest('.feed-ship-lay').find('.feed_std_postpay').val('');
			$(obj).closest('.feed-ship-lay').find('.feed_std_fixed').attr('disabled', true);
			$(obj).closest('.feed-ship-lay').find('.feed_std_fixed').val('');
		}
	}

	// EP 마켓팅 추가배송비 텍스트 체크 :: 2017-02-22 lwh
	function ep_addtxt_chk(obj){
		var feed_add_txt = $(obj).val();	
		if(feed_add_txt.length > 50){
			feed_add_txt = feed_add_txt.substring(0, 50);
			$(obj).val(feed_add_txt);
			$(obj).closest('.feed-ship-lay').find('.addcnt').addClass('red');
		}else{
			$(obj).closest('.feed-ship-lay').find('.addcnt').removeClass('red');
		}
		$(obj).closest('.feed-ship-lay').find('.addcnt').html(feed_add_txt.length);
	}

	// EP 마케팅 배송문구 일괄 적용 후 변경 처리
	function chgFeedShipForm(obj){
		var feed_ship_wrap	= $(obj).closest('.feed-ship-lay');
		var feed_ship_type	= feed_ship_wrap.find('select.all_feed_ship_type_value').val();
		var feed_std_fixed	= feed_ship_wrap.find('input.feed_std_fixed').val();
		var feed_std_postpay= feed_ship_wrap.find('input.feed_std_postpay').val();
		var feed_add_txt	= feed_ship_wrap.find('input.feed_add_txt').val();
		var feed_pay_type	= 'free';
		if	(feed_ship_type == 'E'){
			feed_pay_type	= feed_ship_wrap.find("input[name='feed_pay_type']:checked").val();
		}

		$("input:checkbox[name='goods_seq[]']:checked").each (function() {
			$(this).closest('tr').find('select.feed_ship_type').change();

			if	(feed_ship_type == 'E'){
				$(this).closest('tr').find("input.feed_pay_type[value='" + feed_pay_type + "']").click();

				// disable pass 처리로 인해 한번 더 처리
				$(this).closest('tr').find('input.feed_std_fixed:not(:disabled)').val(feed_std_fixed);
				$(this).closest('tr').find('input.feed_std_postpay:not(:disabled)').val(feed_std_postpay);
				$(this).closest('tr').find('input.feed_add_txt:not(:disabled)').val(feed_add_txt);
			} else {
				$(this).closest('tr').find("input.feed_pay_type[value='free']").attr("checked", true);
				
				$(this).closest('tr').find('input.feed_std_fixed').val('');
				$(this).closest('tr').find('input.feed_std_postpay').val('');
				$(this).closest('tr').find('input.feed_add_txt').val('');
			}
		});
	}

	// EP 사용여부 일괄 체크 처리
	function chkFeedStatusChecked(obj){
		var chkStatus	= false;
		if	($('input.all_feed_status_value').attr('checked')){
			chkStatus	= true;
		}
		$("input:checkbox[name='goods_seq[]']:checked").each (function(){
			$(this).closest('tr').find('input.chk_feed_status').attr('checked', chkStatus);
			chgFeedStatus($(this).closest('tr').find('input.chk_feed_status'));
		});
	}

	// EP 사용여부 체크박스 체크에 따른 실제값 update
	function chgFeedStatus(obj){
		if	($(obj).attr('checked'))	$(obj).closest('td').find('input.feed_status').val('Y');
		else							$(obj).closest('td').find('input.feed_status').val('N');
	}
</script>

<div class="clearbox">
	<ul class="right-btns">
		<li>
			<select  class="custom-select-box-multi" name="perpage">
				<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
				<option id="dp_qty50" value="50" <?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?> >50개씩</option>
				<option id="dp_qty100" value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
				<option id="dp_qty200" value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
			</select>
		</li>
	</ul>
</div>

<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="30" /><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="100" /><!--입점사--><?php }?>
		<col width="63" /><!--상품이미지-->
		<col /><!--상품명-->
		<col width="100" /><!--전달여부-->
		<col width="300" /><!--전달 검색어 / 이벤트-->
		<col width="300" /><!--전달 배송비-->
	</colgroup>
	<thead class="lth">
		<tr style="background-color:#e3e3e3" height="55">
			<th></th>
<?php if(serviceLimit('H_AD')){?><th></th><?php }?>
			<th colspan="2"></th>
			<th>
				<input type="checkbox" class="all_feed_status_value" name="all_feed_status" apply_target="feed_status" />
				<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type="all_feed_status" done_function="chkFeedStatusChecked">▼</button></span>
			</th>
			<th align="center">
				<div>
					<input type="text" size="27" class="all_openmarket_keyword_value" name="all_openmarket_keyword" apply_target="openmarket_keyword" />
					<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type="all_openmarket_keyword">▼</button></span>
				</div>
				<div>
					<input type="text" size="10" readonly class="all_feed_evt_text_value datepicker" name="all_feed_evt_sdate" apply_target="feed_evt_sdate" />
					- 
					<input type="text" size="10" readonly class="all_feed_evt_text_value datepicker" name="all_feed_evt_edate" apply_target="feed_evt_edate" />
				</div>
				<div>
					<input type="text" size="27" class="all_feed_evt_text_value" name="all_feed_evt_text" apply_target="feed_evt_text" />
					<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type="all_feed_evt_text">▼</button></span>
				</div>
			</th>
			<th class="center feed-ship-lay">
				<div style="padding:8px 0;">
					<select class="all_feed_ship_type_value" name="all_feed_ship_type" apply_target="feed_ship_type" onchange="feed_ship_chk(this);">
						<option value="G">설정된 배송그룹</option>
						<option value="S">통합설정</option>
						<option value="E">개별설정</option>
					</select> 
					<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type="all_feed_ship_type" done_function="chgFeedShipForm">▼</button></span>
				</div>
				<div class="fst-lay left pdl5 feed_ship_type_G">
					상품에 연결된 배송그룹의 기본 배송방법을 <br/>
					기준으로 전달될 배송비 정보를 자동 추출합니다.
				</div>
				<div class="fst-lay left pdl5 feed_ship_type_S hide">
					<span class="ep_std_area">
						기본 배송비 : 
<?php if($TPL_VAR["common_epship"]["std"]=='0'){?>무료
<?php }elseif($TPL_VAR["common_epship"]["std"]=='-1'){?>착불
<?php }else{?><?php echo $TPL_VAR["common_epship"]["std"]?><?php }?>
					</span>
<?php if($TPL_VAR["common_epship"]["add"]){?>
					<br/><span class="ep_add_area">추가 배송비 : <?php echo $TPL_VAR["common_epship"]["add"]?></span>
<?php }?>
					<br/>
					마케팅 > <a href="javascript:goSetLink('../marketing/marketplace_url');" class="setlink" onfocus="this.blur();"><span class="highlight-link hand">입점마케팅 설정</span></a>
				</div>
				<div class="fst-lay left pdl5 feed_ship_type_E hide" style="padding-bottom:5px;">
					<label><input type="radio" name="feed_pay_type" value="free" checked onclick="ep_market_set(this);" /> 무료</label>
					&nbsp;
					<label><input type="radio" name="feed_pay_type" value="fixed" onclick="ep_market_set(this);" /> 유료</label>
					<input type="text" name="feed_std_fixed" class="feed_std_fixed all_feed_ship_type_value onlynumber" apply_target="feed_std_fixed" style="width:50px;text-align:right;" disabled /> <?php if($TPL_VAR["config_system"]['basic_currency']=="KRW"){?> 원 <?php }else{?> <?php echo $TPL_VAR["config_system"]['basic_currency']?> <?php }?>
					&nbsp;
					<label><input type="radio" name="feed_pay_type" value="postpay" onclick="ep_market_set(this);" /> 착불</label>
					<input type="text" name="feed_std_postpay" class="feed_std_postpay all_feed_ship_type_value onlynumber" apply_target="feed_std_postpay" style="width:50px;text-align:right;" disabled /> <?php if($TPL_VAR["config_system"]['basic_currency']=="KRW"){?> 원 <?php }else{?> <?php echo $TPL_VAR["config_system"]['basic_currency']?> <?php }?>
					<br/>
					<input type="text" name="feed_add_txt" class="feed_add_txt all_feed_ship_type_value" apply_target="feed_add_txt" onkeyup="ep_addtxt_chk(this);" style="width:230px;" title="예) 도서산간 5천원 추가" /> (<span class="addcnt">0</span>/50)
				</div>
			</th>
		</tr>
		<tr>
			<th><input type="checkbox" id="chkAll" /></th>
<?php if(serviceLimit('H_AD')){?><th>입점</th><?php }?>
			<th colspan="2">상품명</th>
			<th>전달여부</th>
			<th>전달 검색어 / 이벤트</th>
			<th>전달 배송비</th>
		</tr>
	</thead>
<?php if($TPL_VAR["loop"]){?>
	<tbody class="ltb goods_list">
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;" goods_seq="<?php echo $TPL_V1["goods_seq"]?>">
			<td class="center"><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
			<td class="center white bold <?php if($TPL_V1["provider_seq"]=='1'){?>bg-blue<?php }else{?>bg-red<?php }?>">
<?php if($TPL_V1["provider_seq"]=='1'){?>
<?php if($TPL_V1["lastest_supplier_name"]){?>매입 - <?php echo $TPL_V1["lastest_supplier_name"]?><?php }else{?>매입<?php }?>
<?php }else{?>
				<?php echo $TPL_V1["provider_name"]?>

<?php }?>
			</td>
<?php }?>
			<td class="center">
				<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a>
			</td>
			<td class="left pdl10">
				<div>
<?php if($TPL_V1["tax"]=='exempt'){?><span style="color:red;" class="left" >[비과세]</span><?php }?>
<?php if($TPL_V1["cancel_type"]=='1'){?><span class="order-item-cancel-type left" >[청약철회불가]</span><?php }?>
				</div>
<?php if($TPL_V1["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
				<a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut($TPL_V1["goods_name"], 80)?></a>
				<div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
			</td>
			<td class="center">
				<input type="hidden" name="feed_status[<?php echo $TPL_V1["goods_seq"]?>]" class="feed_status" value="<?php if($TPL_V1["feed_status"]){?><?php echo $TPL_V1["feed_status"]?><?php }else{?>N<?php }?>" />
				<input type="checkbox" class="chk_feed_status" onclick="chgFeedStatus(this);" <?php if($TPL_V1["feed_status"]=='Y'){?>checked<?php }?> />
			</td>
			<td class="center">
				<div>
					<input type="text" size="32" name="openmarket_keyword[<?php echo $TPL_V1["goods_seq"]?>]" class="openmarket_keyword" value="<?php echo $TPL_V1["openmarket_keyword"]?>" />
				</div>
				<div>
					<input type="text" size="10" readonly class="feed_evt_sdate datepicker" name="feed_evt_sdate[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["feed_evt_sdate"]?>" />
					- 
					<input type="text" size="10" readonly class="feed_evt_edate datepicker" name="feed_evt_edate[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["feed_evt_edate"]?>" />
				</div>
				<div>
					<input type="text" size="32" name="feed_evt_text[<?php echo $TPL_V1["goods_seq"]?>]" class="feed_evt_text" value="<?php echo $TPL_V1["feed_evt_text"]?>" />
				</div>
			</td>
			<td class="center feed-ship-lay">
				<div style="padding:8px 0;">
					<select class="feed_ship_type" name="feed_ship_type[<?php echo $TPL_V1["goods_seq"]?>]" onchange="feed_ship_chk(this);">
						<option value="G" <?php if($TPL_V1["feed_ship_type"]=='G'){?>selected<?php }?>>설정된 배송그룹</option>
						<option value="S" <?php if($TPL_V1["feed_ship_type"]=='S'){?>selected<?php }?>>통합설정</option>
						<option value="E" <?php if($TPL_V1["feed_ship_type"]=='E'){?>selected<?php }?>>개별설정</option>
					</select> 
				</div>
				<div class="fst-lay left pdl5 feed_ship_type_G <?php if($TPL_V1["feed_ship_type"]&&$TPL_V1["feed_ship_type"]!='G'){?>hide<?php }?>">
					상품에 연결된 배송그룹의 기본 배송방법을 <br/>
					기준으로 전달될 배송비 정보를 자동 추출합니다.
				</div>
				<div class="fst-lay left pdl5 feed_ship_type_S <?php if($TPL_V1["feed_ship_type"]!='S'){?>hide<?php }?>">
					<span class="ep_std_area">
						기본 배송비 : 
<?php if($TPL_VAR["common_epship"]["std"]=='0'){?>무료
<?php }elseif($TPL_VAR["common_epship"]["std"]=='-1'){?>착불
<?php }else{?><?php echo $TPL_VAR["common_epship"]["std"]?><?php }?>
					</span>
<?php if($TPL_VAR["common_epship"]["add"]){?>
					<br/><span class="ep_add_area">추가 배송비 : <?php echo $TPL_VAR["common_epship"]["add"]?></span>
<?php }?>
					<br/>
					마케팅 > <a href="javascript:goSetLink('../marketing/marketplace_url');" class="setlink" onfocus="this.blur();"><span class="highlight-link hand">입점마케팅 설정</span></a>
				</div>
				<div class="fst-lay left pdl5 feed_ship_type_E <?php if($TPL_V1["feed_ship_type"]!='E'){?>hide<?php }?>" style="padding-bottom:5px;">
					<label><input type="radio" name="feed_pay_type[<?php echo $TPL_V1["goods_seq"]?>]" class="feed_pay_type" value="free" <?php if(!$TPL_V1["feed_pay_type"]||$TPL_V1["feed_pay_type"]=='free'){?>checked<?php }?> onclick="ep_market_set(this);" /> 무료</label>
					&nbsp;
					<label><input type="radio" name="feed_pay_type[<?php echo $TPL_V1["goods_seq"]?>]" class="feed_pay_type" value="fixed" <?php if($TPL_V1["feed_pay_type"]=='fixed'){?>checked<?php }?> onclick="ep_market_set(this);" /> 유료</label>
					<input type="text" name="feed_std_fixed[<?php echo $TPL_V1["goods_seq"]?>]" class="feed_std_fixed onlynumber" style="width:50px;text-align:right;" value="<?php echo $TPL_V1["feed_std_fixed"]?>" <?php if($TPL_V1["feed_pay_type"]!='fixed'){?>disabled<?php }?>> <?php if($TPL_VAR["config_system"]['basic_currency']=="KRW"){?> 원 <?php }else{?> <?php echo $TPL_VAR["config_system"]['basic_currency']?> <?php }?>
					&nbsp;
					<label><input type="radio" name="feed_pay_type[<?php echo $TPL_V1["goods_seq"]?>]" class="feed_pay_type" value="postpay" <?php if($TPL_V1["feed_pay_type"]=='postpay'){?>checked<?php }?> onclick="ep_market_set(this);" /> 착불</label>
					
					<input type="text" name="feed_std_postpay[<?php echo $TPL_V1["goods_seq"]?>]" class="feed_std_postpay onlynumber" style="width:50px;text-align:right;" value="<?php echo $TPL_V1["feed_std_postpay"]?>" <?php if($TPL_V1["feed_pay_type"]!='postpay'){?>disabled<?php }?>> <?php if($TPL_VAR["config_system"]['basic_currency']=="KRW"){?> 원 <?php }else{?> <?php echo $TPL_VAR["config_system"]['basic_currency']?> <?php }?>
					<br/>
					<input type="text" name="feed_add_txt[<?php echo $TPL_V1["goods_seq"]?>]" class="feed_add_txt" style="width:230px;" value="<?php echo $TPL_V1["feed_add_txt"]?>" title="예) 도서산간 5천원 추가" <?php if($TPL_V1["feed_pay_type"]=='postpay'){?>disabled<?php }else{?><?php }?> onkeyup="ep_addtxt_chk(this);" /> (<span class="addcnt">0</span>/50)
				</div>
			</td>
		</tr>
<?php }}?>
	</tbody>
<?php }else{?>
	<tbody class="ltb goods_list">
		<tr class="list-row">
			<td align="center" colspan="5">
<?php if($TPL_VAR["search_text"]){?>
					'<?php echo $TPL_VAR["search_text"]?>' 검색된 상품이 없습니다.
<?php }else{?>
					등록된 상품이 없습니다.
<?php }?>
			</td>
		</tr>
	</tbody>
<?php }?>
</table>
<!-- 주문리스트 테이블 : 끝 -->