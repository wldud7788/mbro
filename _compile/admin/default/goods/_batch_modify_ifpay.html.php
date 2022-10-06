<?php /* Template_ 2.2.6 2022/05/17 12:31:56 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_ifpay.html 000018416 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<br class="table-gap" />

<style type="text/css">
table.pay-table td {padding:5px;}
</style>
<script type="text/javascript" src="/app/javascript/js/goods-display.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-shipping.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-goodsReady.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js"></script>
<script type="text/javascript">
	var gl_amout_list					= new Array();
	var gl_default_charge				= false;
	var socialcpuse_flag				= false;
	var gl_option_exist_val				= false;
	var gl_goods_seq					= 0;
	var gl_tax							= 0;
	var gl_ableStockLimit				= 0;
	var gl_ableStockLimit_org			= 0;
	var goodsObj						= [];
	var gl_service_code					= '';
	var gl_runout						= '';
	var gl_default_reserve_percent		= '';
	var gl_package_yn					= '';
	var gl_provider_seq					= '';
	var gl_provider_name				= '';
	var gl_adminSessionType				= '';
	var gl_scm_use						= '';
	var gl_reservetitle					= '';
	var gl_pointtitle					= '';
	var gl_reserve_policy				= '';
	var gl_runtout_policy				= '';
	var gl_able_stock_limit				= '';
	var gl_first_goods_date				= '';
	var gl_basic_currency				= '';
	var gl_krw_exchange_rate			= '';
	var gl_suboption_layout_group		= '';
	var gl_suboption_layout_position	= '';
	var gl_inputoption_layout_group		= '';
	var gl_inputoption_layout_position	= '';

	$(document).ready(function(){
		$("select[name='possible_pay_type']").change(function(){
			if	($(this).val() == 'goods'){
				$('table.pay-table').find("input[name='possible_pay[]']").attr('disabled', false);
			}else{
				$('table.pay-table').find("input[name='possible_pay[]']").attr('disabled', true).attr('checked', false);
			}
		});
	});
</script>

<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="15%" /><!--대상 상품-->
		<col /><!--아래와 같이 업데이트-->
	</colgroup>
	<thead class="lth">
		<tr>
			<th>대상 상품</th>
			<th>아래와 같이 업데이트</th>
		</tr>
	</thead>
	<tbody class="ltb ">
		<tr  style="height:70px;">
			<td class="list-row" align="center" style="border-bottom:1px solid #e3e3e3;">
				검색된 상품에서  →
				<select name="modify_list"  class="line">
					<option value="choice">선택 </option>
					<option value="all">전체 </option>
				</select>
			</td>
			<td class="list-row" style="border-bottom:1px solid #e3e3e3;">
				<div class="mt10 ml10">
					<label><input type="checkbox" class="batch_update_item" name="batch_possible_pay_type_yn" value="1" /><span>결제수단</span></label>
					
					<select name="possible_pay_type">
						<option value="shop">통합</option>
						<option value="goods">개별세팅</option>
					</select>
					<div style="margin-top:10px;margin-left:20px;">
						<table class="pay-table" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="checkbox" name="possible_pay[]" value="bank" <?php if(!$TPL_VAR["payment"]["bank"]){?>disabled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["payment_check"]["bank"]){?>checked<?php }?> disabled /> 무통장 입금</label></td>
							<td><label><input type="checkbox" name="possible_pay[]" value="card" <?php if(!$TPL_VAR["payment"]["card"]){?>disabled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["payment_check"]["card"]){?>checked<?php }?> disabled /> 신용카드</label></td>
							<td><label><input type="checkbox" name="possible_pay[]" value="account" <?php if(!$TPL_VAR["payment"]["account"]){?>disabled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["payment_check"]["account"]){?>checked<?php }?> disabled /> 계좌이체</label></td>
							<td><label><input type="checkbox" name="possible_pay[]" value="virtual" <?php if(!$TPL_VAR["payment"]["virtual"]){?>disabled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["payment_check"]["virtual"]){?>checked<?php }?> disabled /> 가상계좌</label></td>
							<td><label><input type="checkbox" name="possible_pay[]" value="cellphone" <?php if(!$TPL_VAR["payment"]["cellphone"]){?>disabled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["payment_check"]["cellphone"]){?>checked<?php }?> disabled /> 핸드폰</label></td>
						</tr>
						<tr>
							<td><label><input type="checkbox" name="possible_pay[]" value="escrow_account" <?php if(!$TPL_VAR["escrow"]["account"]){?>disabled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["escrow_check"]["account"]){?>checked<?php }?> disabled /> (에스크로) 계좌이체</label></td>
							<td><label><input type="checkbox" name="possible_pay[]" value="escrow_virtual" <?php if(!$TPL_VAR["escrow"]["virtual"]){?>disabled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["escrow_check"]["virtual"]){?>checked<?php }?> disabled /> (에스크로) 가상계좌</label></td>
							<td><label><input type="checkbox" name="possible_pay[]" value="kakaopay" <?php if($TPL_VAR["config_system"]["not_use_kakao"]!='y'){?>disabled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["payment_check"]["kakaopay"]){?>checked<?php }?> disabled /> 카카오페이</label></td>
							<td><label><input type="checkbox" name="possible_pay[]" value="payco" <?php if($TPL_VAR["config_system"]["not_use_payco"]!='y'){?>disabled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["payment_check"]["kakaopay"]){?>checked<?php }?> disabled /> 페이코</label></td>
							<td><label><input type="checkbox" name="possible_pay[]" value="paypal" <?php if($TPL_VAR["config_system"]["not_use_paypal"]!='y'){?>disabled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["payment_check"]["paypal"]){?>checked<?php }?> disabled /> 페이팔</label></td>
						</tr>
						<tr>
							<td><label><input type="checkbox" name="possible_pay[]" value="alipay" <?php if($TPL_VAR["config_system"]["not_use_alipay"]!='y'){?>disabled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["payment_check"]["alipay"]){?>checked<?php }?> disabled /> 알리페이</label></td>
							<td><label><input type="checkbox" name="possible_pay[]" value="axes" <?php if(!$TPL_VAR["config_system"]["not_use_axes"]!='y'){?>disabled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["payment_check"]["axes"]){?>checked<?php }?> disabled /> 엑시즈</label></td>
							<td colspan="3"><label><input type="checkbox" name="possible_pay[]" value="eximbay" <?php if($TPL_VAR["config_system"]["not_use_eximbay"]){?>disbled<?php }else{?>class="able"<?php }?> <?php if($TPL_VAR["payment_check"]["eximbay"]){?>checked<?php }?> disabled /> 엑심베이</label>
							로 변경 합니다</td>
						</tr>
						</table>
					</div>
				</div>
				<div class="mt10 ml10 mb10">
					<label><input type="checkbox" class="batch_update_item" name="batch_replacement_yn" value="1" /><span>가격대체문구 및 버튼대체문구를 ↓아래의 내용으로 변경합니다.</span></label>
					<span class="btn small cyanblue"><button type="button" id="popStringPriceBtn">설정</button></span>
					<div id="frmStringPrice" class="hide">
						string_price_use<input type="text" name="string_price_use" /><br/>
						string_price<input type="text" name="string_price" /><br/>
						string_price_color<input type="text" name="string_price_color" /><br/>
						string_price_link<input type="text" name="string_price_link" /><br/>
						string_price_link_url<input type="text" name="string_price_link_url" /><br/>
						string_price_link_target<input type="text" name="string_price_link_target" /><br/>

						member_string_price_use<input type="text" name="member_string_price_use" /><br/>
						member_string_price<input type="text" name="member_string_price" /><br/>
						member_string_price_color<input type="text" name="member_string_price_color" /><br/>
						member_string_price_link<input type="text" name="member_string_price_link" /><br/>
						member_string_price_link_url<input type="text" name="member_string_price_link_url" /><br/>
						member_string_price_link_target<input type="text" name="member_string_price_link_target" /><br/>

						allmember_string_price_use<input type="text" name="allmember_string_price_use" /><br/>
						allmember_string_price<input type="text" name="allmember_string_price" /><br/>
						allmember_string_price_color<input type="text" name="allmember_string_price_color" /><br/>
						allmember_string_price_link<input type="text" name="allmember_string_price_link" /><br/>
						allmember_string_price_link_url<input type="text" name="allmember_string_price_link_url" /allmember_string_price_link_url}" >
						allmember_string_price_link_target<input type="text" name="allmember_string_price_link_target" /><br/>

						string_button_use<input type="text" name="string_button_use" /><br/>
						string_button<input type="text" name="string_button" /><br/>
						string_button_color<input type="text" name="string_button_color" /><br/>
						string_button_link<input type="text" name="string_button_link" /><br/>
						string_button_link_url<input type="text" name="string_button_link_url" /><br/>
						string_button_link_target<input type="text" name="string_button_link_target" /><br/>

						member_string_button_use<input type="text" name="member_string_button_use" /><br/>
						member_string_button<input type="text" name="member_string_button" /><br/>
						member_string_button_color<input type="text" name="member_string_button_color" /><br/>
						member_string_button_link<input type="text" name="member_string_button_link" /><br/>
						member_string_button_link_url<input type="text" name="member_string_button_link_url" /><br/>
						member_string_button_link_target<input type="text" name="member_string_button_link_target" /><br/>

						allmember_string_button_use<input type="text" name="allmember_string_button_use" /><br/>
						allmember_string_button<input type="text" name="allmember_string_button" /><br/>
						allmember_string_button_color<input type="text" name="allmember_string_button_color" /><br/>
						allmember_string_button_link<input type="text" name="allmember_string_button_link" /><br/>
						allmember_string_button_link_url<input type="text" name="allmember_string_button_link_url" /allmember_string_button_link_url}" >
						allmember_string_button_link_target<input type="text" name="allmember_string_button_link_target" /><br/>
					</div>
					<div style="margin-left:20px;">
						<table class="info-table-style" style="width:600px;">
							<colgroup>
								<col />
								<col width="38%" />
								<col width="38%" />
							</colgroup>
							<tbody>
								<tr>
									<th class="its-th-align center bold">구매 대상자</th>
									<th class="its-th-align center bold">가격노출 제어</th>
									<th class="its-th-align center bold">버튼노출 제어</th>
								</tr>

								<tr>
									<td class="its-td">비회원(로그아웃)</td>
									<td class="its-td"><div id="string_price_msg"></div></td>
									<td class="its-td center"><div id="string_button_msg"></div></td>
								</tr>
								<tr>
									<td class="its-td">일반등급</td>
									<td class="its-td"><div id="member_string_price_msg"></div></td>
									<td class="its-td center"><div id="member_string_button_msg"></div></td>
								</tr>
								<tr>
									<td class="its-td">상위등급</td>
									<td class="its-td"><div id="allmember_string_price_msg"></div></td>
									<td class="its-td center"><div id="allmember_string_button_msg"></div></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
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
			<select class="custom-select-box-multi" name="orderby">
				<option value="goods_seq" <?php if($TPL_VAR["orderby"]=='goods_seq'){?>selected<?php }?>>최근등록순</option>
				<option value="goods_name" <?php if($TPL_VAR["orderby"]=='goods_name'){?>selected<?php }?>>상품명순</option>
				<option value="page_view" <?php if($TPL_VAR["orderby"]=='page_view'){?>selected<?php }?>>페이지뷰순</option>
			</select>
		</li>
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
		<col width="50" /><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="100" /><!--입점--><?php }?>
		<col width="60" /><!--상품이미지-->
		<col  /><!--상품명-->
		<col width="150" /><!--결제수단-->
		<col width="100" /><!--구매 대상자-->
		<col width="150" /><!--가격대체문구-->
		<col width="150" /><!--버튼대체문구-->
		<col width="200" /><!--구매 가능여부-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
<?php if(serviceLimit('H_AD')){?><th>입점</th><?php }?>
		<th colspan="2">상품명</th>
		<th>결제수단</th>
		<th>구매 대상자</th>
		<th>가격대체문구</th>
		<th>버튼대체문구</th>
		<th>구매 가능여부</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row">
			<td class="center" rowspan="3"><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_V1["provider_seq"]=='1'){?>
			<td class="bg-blue white bold center" rowspan="3">
<?php if($TPL_V1["lastest_supplier_name"]){?>
				매입 - <?php echo $TPL_V1["lastest_supplier_name"]?>

<?php }else{?>
				매입
<?php }?>
			</td>
<?php }else{?>
			<td class="bg-red white bold center" rowspan="3"><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
<?php }?>
			<td class="center" rowspan="3"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a></td>
			<td class="left" style="padding-left:10px;" rowspan="3"><a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut($TPL_V1["goods_name"], 80)?></a> <div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
<?php if($TPL_V1["tax"]=='exempt'){?><div style="color:red;">[비과세]</div><?php }?></td>
			<td class="center" rowspan="3" style="padding:2px 0;">
<?php if($TPL_V1["possible_pay_type"]=='goods'){?>
				<?php echo str_replace(',','<br/>',$TPL_V1["possible_pay_str"])?>

<?php }else{?>
				통합 정책
<?php }?>
			</td>
			<td class="left" style="height:20px;border-bottom:none;">비회원 → </td>
			<td class="left" style="height:20px;border-bottom:none;">
<?php if($TPL_V1["string_price_use"]){?><?php echo $TPL_V1["string_price"]?><?php }else{?>판매가격<?php }?>
			</td>
			<td class="left" style="height:20px;border-bottom:none;">
<?php if($TPL_V1["string_button_use"]){?><?php echo $TPL_V1["string_button"]?><?php }else{?>판매가격<?php }?>
			</td>
			<td class="left" style="height:20px;border-bottom:none;">
<?php if($TPL_V1["string_price_use"]||$TPL_V1["string_button_use"]){?>구매 불가<?php }else{?>상품상태에 따라 구매 가능<?php }?>
			</td>
		</tr>
		<tr>
			<td class="left" style="height:20px;">일반등급 → </td>
			<td class="left" style="height:20px;">
<?php if($TPL_V1["member_string_price_use"]){?><?php echo $TPL_V1["member_string_price"]?><?php }else{?>판매가격<?php }?>
			</td>
			<td class="left" style="height:20px;">
<?php if($TPL_V1["member_string_button_use"]){?><?php echo $TPL_V1["member_string_button"]?><?php }else{?>판매가격<?php }?>
			</td>
			<td class="left" style="height:20px;">
<?php if($TPL_V1["member_string_price_use"]||$TPL_V1["member_string_button_use"]){?>구매 불가<?php }else{?>상품상태에 따라 구매 가능<?php }?>
			</td>
		</tr>
		<tr>
			<td class="left" style="height:20px;border-bottom:1px solid #e3e3e3;">상위등급 → </td>
			<td class="left" style="height:20px;border-bottom:1px solid #e3e3e3;">
<?php if($TPL_V1["allmember_string_price_use"]){?><?php echo $TPL_V1["allmember_string_price"]?><?php }else{?>판매가격<?php }?>
			</td>
			<td class="left" style="height:20px;border-bottom:1px solid #e3e3e3;">
<?php if($TPL_V1["allmember_string_button_use"]){?><?php echo $TPL_V1["allmember_string_button"]?><?php }else{?>판매가격<?php }?>
			</td>
			<td class="left" style="height:20px;border-bottom:1px solid #e3e3e3;">
<?php if($TPL_V1["allmember_string_price_use"]||$TPL_V1["allmember_string_button_use"]){?>구매 불가<?php }else{?>상품상태에 따라 구매 가능<?php }?>
			</td>
		</tr>
		<tr class="order-list-summary-row hide">
			<td colspan="7" class="order-list-summary-row-td"><div class="option_info"></div></td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td class="center" colspan="7">
<?php if($TPL_VAR["search_text"]){?>
				'<?php echo $TPL_VAR["search_text"]?>' 검색된 상품이 없습니다.
<?php }else{?>
				등록된 상품이 없습니다.
<?php }?>
		</td>
	</tr>
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->
</table>

<div id="popStringPrice" class="hide"></div>