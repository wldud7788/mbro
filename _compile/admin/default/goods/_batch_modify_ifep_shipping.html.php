<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_ifep_shipping.html 000014289 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<style type="text/css">
.non-boder { border:0 !important; }
</style>
<script type="text/javascript">
	$(document).ready(function() {
		// EP 노출 배송비 설정 :: 2017-02-22 lwh
		$("input[name='feed_pay_type']").on('change', function(){
			ep_market_set();
		});

		// 추가 배송비 텍스트 체크 :: 2017-02-22 lwh
		$("#feed_add_txt").on("keyup", function(){
			ep_addtxt_chk();
		});

		feed_ship_chk();

		// 배송비 개별설정 변경 시 텍스트박스 활성화 :: 2018-10-02 pjw
		$('input[name="grp_feed_pay_type"]').change(function(){	
			if ($(this).val() == 'postpay') {	
				$("input[name='grp_feed_add_txt']").attr('disabled', true);
				$("input[name='grp_feed_add_txt']").val('');
				$("input[name='grp_feed_std_fixed']").attr('disabled', true);
				$("input[name='grp_feed_std_fixed']").val('');
				$("input[name='grp_feed_std_postpay']").attr('disabled', false);
			} else if ($(this).val() == 'fixed') {							
				$("input[name='grp_feed_add_txt']").attr('disabled', true);
				$("input[name='grp_feed_add_txt']").val('');
				$("input[name='grp_feed_std_postpay']").attr('disabled', true);
				$("input[name='grp_feed_std_postpay']").val('');
				$("input[name='grp_feed_std_fixed']").attr('disabled', false);
			} else {							
				$("input[name='grp_feed_add_txt']").attr('disabled', false);
				$("input[name='grp_feed_std_postpay']").attr('disabled', true);
				$("input[name='grp_feed_std_postpay']").val('');
				$("input[name='grp_feed_std_fixed']").attr('disabled', true);
				$("input[name='grp_feed_std_fixed']").val('');
			}	
		});
	});

	function feed_ship_chk(){
		var feed_type		= null;
		var feed_ship_type	= $("#feed_ship_type").val();

		$(".epcls").hide();
		if (feed_ship_type == 'E'){ // E:개별설정
			$(".epSel").show();
		}else if (feed_ship_type == 'S'){ // S:통합설정
			$(".epTxt").show();
		}else{ // G:그룹설정
			$(".epGrp").show();
		}
		
		if (feed_ship_type != 'E'){
			$("input[name='feed_pay_type[value='free']'").attr("checked", true);
			
			$("input[name='grp_feed_std_fixed']").val('');
			$("input[name='grp_feed_std_postpay']").val('');
			$("input[name='grp_feed_add_txt']").val('');
		}
	}

	// EP 마켓팅 배송데이터 설정 :: 2017-02-22 lwh
	function ep_market_set(){
		var feed_pay_type = $("input[name='feed_pay_type']:checked").val();
		if (feed_pay_type == 'fixed'){
			$("input[name='feed_std_fixed']").attr("disabled", false);
		} else {
			$("input[name='feed_std_fixed']").attr("disabled", true);
		}

		if (feed_pay_type == 'postpay')	$("#feed_add_txt").attr("disabled", true);
		else							$("#feed_add_txt").attr("disabled", false);
	}

	// EP 마켓팅 추가배송비 텍스트 체크 :: 2017-02-22 lwh
	function ep_addtxt_chk(){
		var feed_add_txt = $("#feed_add_txt").val();	
		if(feed_add_txt.length > 50){
			feed_add_txt = feed_add_txt.substring(0,50);
			$("#feed_add_txt").val(feed_add_txt);
			$("#addcnt").addClass('red');
		}else{
			$("#addcnt").removeClass('red');
		}
		$("#addcnt").html(feed_add_txt.length);
	}
</script>

<br class="table-gap" />

<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="35%" /><!--대상 상품-->
		<col width="65%" /><!--아래와 같이 업데이트-->
	</colgroup>
	<thead class="lth">
		<tr>
			<th>대상 상품</th>
			<th>아래와 같이 업데이트</th>
		</tr>
	</thead>
	<tbody class="ltb">
		<tr class="list-row" style="height:70px;">
			<td class="td" align="center">
				<input type="hidden" name="sel_provider_seq" value="1" />
				검색된 상품에서  →
				<select name="modify_list"  class="modify_list">
					<option value="choice">선택 </option>
					<option value="all">전체 </option>
				</select>
			</td>
			<td class="td" align="left">
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
				<colgroup>
					<col width="100" />
					<col width="150" />
					<col />
				</colgroup>
				<tbody>
				<tr>
					<td class="non-boder"><label><input type="checkbox" class="batch_update_item" name="grp_feed_status_yn" value="1" /> <strong>전달여부</strong></label></td>
					<td class="non-boder" colspan="2">
						<label><input type="radio" name="grp_feed_status" value="Y" checked /> 예</label>
						<label><input type="radio" name="grp_feed_status" value="N" /> 아니요</label>
					</td>
				</tr>
				<tr>
					<td class="non-boder"><label><input type="checkbox" class="batch_update_item" name="grp_openmarket_keyword_yn" value="1" /> <strong>검색어</strong></label></td>
					<td class="non-boder" colspan="2">
						<input type="text" size="40" name="grp_openmarket_keyword" title="검색어는 ,(콤마)로 구분됩니다." />
					</td>
				</tr>
				<tr>
					<td class="non-boder"><label><input type="checkbox" class="batch_update_item" name="grp_feed_evt_sdate_yn" value="1" /> <strong>이벤트</strong></label></td>
					<td class="non-boder" colspan="2">
						<input type="text" size="10" readonly class="datepicker" name="grp_feed_evt_sdate" />
						- 
						<input type="text" size="10" readonly class="datepicker" name="grp_feed_evt_edate" />
						<input type="text" size="40" name="grp_feed_evt_text" />
					</td>
				</tr>
				<tr>
					<td class="non-boder"><label><input type="checkbox" class="batch_update_item" name="grp_feed_ship_type_yn" value="1" /> <strong>배송비</strong></label></td>
					<td class="non-boder">
						<select name="grp_feed_ship_type" id="feed_ship_type" onchange="feed_ship_chk();">
							<option value="G">설정된 배송그룹</option>
							<option value="S">통합설정</option>
							<option value="E">개별설정</option>
						</select> 
					</td>
					<td class="non-boder left">
						<div class="epGrp epcls" style="line-height:25px;color:#8b8b8b;">
							상품에 연결된 배송그룹의 기본 배송방법을 기준으로 전달될 배송비 정보를 자동 추출
						</div>
						<div class="epTxt epcls hide" style="line-height:25px;">
							<span class="ep_std_area">기본 배송비 : <span class="ep_std_txt">-</span></span>
							<span class="ep_std_area">기본 배송비 : 
<?php if($TPL_VAR["common_epship"]["std"]=='0'){?>무료
<?php }elseif($TPL_VAR["common_epship"]["std"]=='-1'){?>착불
<?php }else{?><?php echo $TPL_VAR["common_epship"]["std"]?><?php }?>
							</span>
<?php if($TPL_VAR["common_epship"]["add"]){?>
							<br/><span class="ep_add_area">추가 배송비 : <?php echo $TPL_VAR["common_epship"]["add"]?></span>
<?php }?>
							( 마케팅 > <a href="javascript:goSetLink('../marketing/marketplace_url');" class="setlink" onfocus="this.blur();"><span class="highlight-link hand">입점마케팅 설정</span></a> )
						</div>
						<div class="epSel epcls hide" style="line-height:30px;">
							<label><input type="radio" name="grp_feed_pay_type" value="free" <?php if(!$TPL_VAR["goods"]["feed_pay_type"]||$TPL_VAR["goods"]["feed_pay_type"]=='free'){?>checked<?php }?>> 무료</label>
							&nbsp;
							<label><input type="radio" name="grp_feed_pay_type" value="fixed" <?php if($TPL_VAR["goods"]["feed_pay_type"]=='fixed'){?>checked<?php }?>> 유료</label>
							<input type="text" name="grp_feed_std_fixed" class="onlynumber" style="width:50px;text-align:right;" value="<?php echo $TPL_VAR["goods"]["feed_std_fixed"]?>" <?php if($TPL_VAR["goods"]["feed_pay_type"]!='fixed'){?>disabled<?php }?>> <?php if($TPL_VAR["config_system"]['basic_currency']=="KRW"){?> 원 <?php }else{?> <?php echo $TPL_VAR["config_system"]['basic_currency']?> <?php }?>
							&nbsp;
							<label><input type="radio" name="grp_feed_pay_type" value="postpay" <?php if($TPL_VAR["goods"]["feed_pay_type"]=='postpay'){?>checked<?php }?>> 착불</label>
							<input type="text" name="grp_feed_std_postpay" class="onlynumber" style="width:50px;text-align:right;" value="<?php echo $TPL_VAR["goods"]["feed_std_postpay"]?>" <?php if($TPL_VAR["goods"]["feed_pay_type"]!='postpay'){?>disabled<?php }?>> <?php if($TPL_VAR["config_system"]['basic_currency']=="KRW"){?> 원 <?php }else{?> <?php echo $TPL_VAR["config_system"]['basic_currency']?> <?php }?>
							<br/>
							<input type="text" name="grp_feed_add_txt" id="feed_add_txt" style="width:250px;" value="<?php echo $TPL_VAR["goods"]["feed_add_txt"]?>" title="예) 도서산간 5천원 추가" <?php if($TPL_VAR["goods"]["feed_pay_type"]=='postpay'){?>disabled<?php }else{?><?php }?>> (<span id="addcnt">0</span>/50)
						</div>
					</td>
				</tr>
				</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>


<div class="clearbox">
	<ul class="left-btns">
		<li class="left-btns-txt desc">※ 이용방법 : [검색하기] 버튼으로 검색 후 상품정보를 조건 업데이트 하세요!</li>
	</ul>
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
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="30" /><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="100" /><!--입점사--><?php }?>
		<col width="63" /><!--상품이미지-->
		<col /><!--상품명-->
		<col width="80" /><!--전달여부-->
		<col width="30%" /><!--전달 검색어 / 이벤트-->
		<col width="30%" /><!--전달 배송비-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
<?php if(serviceLimit('H_AD')){?><th>입점</th><?php }?>
		<th colspan="2">상품명</th>
		<th>전달여부</th>
		<th>전달 검색어 / 이벤트</th>
		<th>전달 배송비</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<!-- 상품정보 : 시작 -->
		<tbody class="ltb goods_list">
			<tr class="list-row" style="height:70px;">
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
				<td class="center"><?php echo $TPL_V1["feed_status"]?></td>
				<td class="left pdl5">
					<div>검색어 : <?php if($TPL_V1["openmarket_keyword"]){?><?php echo $TPL_V1["openmarket_keyword"]?><?php }else{?><span style="color:#8b8b8b;">없음</span><?php }?></div>
					<div>이벤트 : 
<?php if($TPL_V1["feed_evt_sdate"]||$TPL_V1["feed_evt_edate"]||$TPL_V1["feed_evt_text"]){?>
						<?php echo $TPL_V1["feed_evt_sdate"]?>~<?php echo $TPL_V1["feed_evt_edate"]?>

						<br/><?php echo $TPL_V1["feed_evt_text"]?>

<?php }else{?>
						<span style="color:#8b8b8b;">없음</span>
<?php }?>
				</td>
				<td class="left pdl5">
<?php if($TPL_V1["feed_ship_type"]=='S'){?>
					[통합설정]<br/>
						기본 배송비 : 
<?php if($TPL_VAR["common_epship"]["std"]=='0'){?>무료
<?php }elseif($TPL_VAR["common_epship"]["std"]=='-1'){?>착불
<?php }else{?><?php echo $TPL_VAR["common_epship"]["std"]?><?php }?>
<?php if($TPL_VAR["common_epship"]["add"]){?>
						<br/>추가 배송비 : <?php echo $TPL_VAR["common_epship"]["add"]?>

<?php }?>
<?php }elseif($TPL_V1["feed_ship_type"]=='E'){?>
					[개별설정]<br/>
<?php if($TPL_V1["feed_pay_type"]=='fixed'){?>유료 <?php echo $TPL_V1["feed_std_fixed"]?> <?php echo $TPL_VAR["config_system"]['basic_currency']?>

<?php }elseif($TPL_V1["feed_pay_type"]=='postpay'){?>착불 <?php echo $TPL_V1["feed_std_postpay"]?> <?php echo $TPL_VAR["config_system"]['basic_currency']?>

<?php }else{?>무료<?php }?>
<?php if($TPL_V1["feed_pay_type"]!='postpay'){?><br /><?php echo $TPL_V1["feed_add_txt"]?><?php }?>
<?php }else{?>
					[설정된 배송그룹]
<?php }?>
				</td>
			</tr>
		</tbody>
		<!-- 상품정보 : 끝 -->
<?php }}?>
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
	</tbody>
	<!-- 리스트 : 끝 -->

</table>
<!-- 주문리스트 테이블 : 끝 -->