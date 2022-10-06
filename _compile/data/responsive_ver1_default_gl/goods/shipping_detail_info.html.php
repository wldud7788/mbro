<?php /* Template_ 2.2.6 2021/12/15 17:48:34 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/goods/shipping_detail_info.html 000023162 */ 
$TPL_ship_gl_arr_1=empty($TPL_VAR["ship_gl_arr"])||!is_array($TPL_VAR["ship_gl_arr"])?0:count($TPL_VAR["ship_gl_arr"]);
$TPL_set_list_1=empty($TPL_VAR["set_list"])||!is_array($TPL_VAR["set_list"])?0:count($TPL_VAR["set_list"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 배송 안내 및 변경 @@
- 파일위치 : [스킨폴더]/goods/shipping_detail_info.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript">
	$(document).ready(function(){
		// set_seq 지정
		$("#ship_set_list").val('<?php echo $TPL_VAR["set_info"]["shipping_set_seq"]?>');

<?php if($TPL_VAR["store_info"]["store_seq"]){?>
		// store 지정
		$("#store_sel").val('<?php echo $TPL_VAR["store_info"]["store_seq"]?>');
<?php }?>

<?php if($TPL_VAR["prepay_sel"]){?>
		// 선택된 배송비 선/착불정보
		$("input[name='prepay_info']:radio[value='<?php echo $TPL_VAR["prepay_sel"]?>']").attr('checked',true);
<?php }?>

<?php if($TPL_VAR["config_basic"]["map_client_id"]&&$TPL_VAR["config_basic"]["map_client_secret"]&&$TPL_VAR["store_info"]["shipping_address_txt"]){?>
		// 맵정보 노출
		var width = $(document).width() - 24;
		$("#mapfrm").attr('src','/goods/store_map_info?width='+width+'&height=148&addr=<?php echo $TPL_VAR["store_info"]["shipping_address_txt"]?>&name=<?php echo $TPL_VAR["store_info"]["shipping_store_name"]?>');

		$(window).on("orientationchange",function(){
			width = $(document).width() - 24;
			$("#mapfrm").attr('src','/goods/store_map_info?width='+width+'&height=148&addr=<?php echo $TPL_VAR["store_info"]["shipping_address_txt"]?>&name=<?php echo $TPL_VAR["store_info"]["shipping_store_name"]?>');
		});
<?php }?>

		$(".detailDescriptionLayerCloseBtn").unbind().click(function(){
			$(this).closest('div.detailDescriptionLayer').toggle()
		});
	});

	// 묶음배송상품보기
	function bundle_goods_search(grp_seq){
		window.open('<?php echo $TPL_VAR["grp_info"]["shipping_bundle_link"]?>'+grp_seq);
	}

	// 배송설정 변경시
	function chg_shipping_set(nation){
		var mode		= '<?php echo $TPL_VAR["mode"]?>';
		var cart_seq	= '<?php echo $TPL_VAR["cart_seq"]?>';
		var admin_mode	= '<?php echo $TPL_VAR["admin_mode"]?>';
		var cart_table	= '<?php echo $TPL_VAR["cart_table"]?>';
		var grp_seq		= '<?php echo $TPL_VAR["grp_info"]["shipping_group_seq"]?>';
		var set_seq		= '';
		var store_use	= '<?php echo $TPL_VAR["set_info"]["store_use"]?>';
		var direct_store= '<?php echo $TPL_VAR["direct_store"]?>';
		var goods_seq	= '<?php echo $TPL_VAR["goods_info"]["goods_seq"]?>';
		if(!nation){
			set_seq = $("#ship_set_list").val();
			nation = $("#ship_set_list option:selected").attr('nation');
		}

		var params	= [];
		params.push({name:'mode',value:mode});
		params.push({name:'grp_seq',value:grp_seq});
		params.push({name:'nation',value:nation});
		if(set_seq)				params.push({name:'set_seq',value:set_seq});
		if(cart_seq)			params.push({name:'cart_seq',value:cart_seq});
		if(admin_mode)			params.push({name:'admin_mode',value:admin_mode});
		if(cart_table)			params.push({name:'cart_table',value:cart_table});
		if(direct_store=='Y')	params.push({name:'direct_store',value:'Y'});
		if(store_use=='Y')		params.push({name:'store_seq',value:$("#store_sel").val()});
		if(goods_seq)			params.push({name:'goods_seq',value:goods_seq});

		$.ajax({
			'url' : '/goods/shipping_detail_info',
			'data' : params,
			'success' : function(html){
				if(html){
					// var blockscorp issue
					if(typeof isAdminpage == "undefined") {
						var isAdminpage = false;
					}

					if(typeof gl_operation_type != 'undefined' && gl_operation_type == 'light' && isAdminpage != true){
						hideCenterLayer();
						$("#shipping_detail_lay .layer_pop_contents").html(html);
						showCenterLayer('#shipping_detail_lay');
					}else{
						$("#shipping_detail_lay").html(html);
					}
				}else{
					//배송방법 정보가 누락되었습니다\n새로고침 후 다시 시도해주세요.
					alert(getAlert('os235'));
				}
			}
		});
	}

	// 상세지역 popup
	function ship_zone_pop(obj){
		$('div.detailDescriptionLayer').not($(obj).next('div.detailDescriptionLayer')).hide();
		$(obj).next('div.detailDescriptionLayer').toggle();
	}

	// 확인버튼 - 부모창에 현재 선택된 정보를 넘겨준다.
	function confirm_set_succ(){

		var mode			= '<?php echo $TPL_VAR["mode"]?>';
		var cart_seq		= '<?php echo $TPL_VAR["cart_seq"]?>';
		var admin_mode		= '<?php echo $TPL_VAR["admin_mode"]?>';				// 개인결제/관리자주문 장바구니/주문서
		var cart_table		= '<?php echo $TPL_VAR["cart_table"]?>';				// 개인결제,관리자주문
		var ship_set_seq	= $("#ship_set_list").val();	// 배송설정
		var store_seq		= $("#store_sel").val();		// 수령매장정보
		var prepay_info		= $("input[name='prepay_info']:checked").val(); // 배송비결제정보
		var direct_store	= '<?php echo $TPL_VAR["direct_store"]?>';

		if	(mode == 'goods'){
			top.chg_delivery_info(ship_set_seq,store_seq,prepay_info);
			if	(direct_store == 'Y'){
				if	( check_option() ){
					var f = $("form[name='goodsForm']");
					f.attr("action","../order/add?mode=direct");
					f.submit();
					f.attr("action","../order/add");
				}
			}
		}else if(mode == 'cart' || mode == 'order'){
			// 바로 변경 후 새로고침
			$("#shipFrm > input[name='cart_seq']").val(cart_seq);
			$("#shipFrm > input[name='admin_mode']").val(admin_mode);
			$("#shipFrm > input[name='cart_table']").val(cart_table);
			$("#shipFrm > input[name='ship_set_seq']").val(ship_set_seq);
			$("#shipFrm > input[name='store_seq']").val(store_seq);
			$("#shipFrm > input[name='prepay_info']").val(prepay_info);

			$("#shipFrm").submit();
		}
	}
</script>



<?php if($TPL_VAR["direct_store"]=='N'){?>
<?php if($TPL_VAR["ship_summary"]["gl_shipping_yn"]=='Y'){?>
<button type="button" class="btn_resp size_b color2" onclick="showCenterLayer('.nation', 'inner_layer')">
<?php if($TPL_VAR["set_info"]["delivery_nation"]=='korea'){?>
	대한민국
<?php }else{?>
	해외국가
<?php }?>
</button>
<?php }else{?>
<?php if($TPL_VAR["set_info"]["delivery_nation"]=='korea'){?>
	대한민국
<?php }else{?>
	해외국가
<?php }?>
<?php }?>

<!-- 국가 선택 POPUP :: START -->
<div class="nation resp_layer_pop maxHeight hide">
	<h4 class="title">배송 국가 변경</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<div class="Pb10">
				현재 배송 국가 :
<?php if($TPL_VAR["set_info"]["delivery_nation"]=='korea'){?>
					<span class="gray_01">대한민국</span>
<?php }else{?>
					<span class="gray_01"><?php echo getstrcut($TPL_VAR["now_nation"], 10)?></span>
<?php }?>
<?php if($TPL_VAR["now_nation"]!='해외국가'){?>
					<img src="/admin/skin/default/images/common/icon/nation/<?php echo $TPL_VAR["sel_gl_str"]?>.png" style="max-height:20px;" alt="">
<?php }?>
<?php if($TPL_VAR["set_info"]["delivery_nation"]=='global'&&$TPL_VAR["ship_summary"]["kr_shipping_yn"]=='Y'){?>
				<button type="button" class="btn_resp Ml8" onclick="chg_shipping_set('korea');">대한민국으로 변경</button>
<?php }?>
			</div>

			<table class="default_table_style" width="100%" border="0" cellpadding="0" cellspacing="0">
			<colgroup>
				<col style="width:50%" /><col style="width:50%" />
			</colgroup>
			<tbody>
<?php if($TPL_ship_gl_arr_1){foreach($TPL_VAR["ship_gl_arr"] as $TPL_K1=>$TPL_V1){?>
			<tr>
				<th scope="row" class="hand" onclick="chg_shipping_set('<?php echo $TPL_V1["nation_str"]?>');">
					<img src="/admin/skin/default/images/common/icon/nation/<?php echo $TPL_VAR["ship_gl_list"][$TPL_K1]['gl_nation']?>.png" height="20" alt=""> <?php echo $TPL_VAR["ship_gl_list"][$TPL_K1]['gl_nation']?>

				</th>
				<td class="left"><?php echo $TPL_VAR["ship_gl_list"][$TPL_K1]['kr_nation']?></td>
			</tr>
<?php }}?>
			</tbody>
			</table>
		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer('.nation', 'inner_layer')">확인</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer('.nation', 'inner_layer')"></a>
</div>
<!-- 국가 선택 POPUP :: END -->
<?php }?>

<!-- 배송설정 리스트 :: START -->
<select name="ship_set_list" id="ship_set_list" class="M" style="min-width:100px;" onchange="chg_shipping_set();">
<?php if($TPL_set_list_1){foreach($TPL_VAR["set_list"] as $TPL_V1){?>
	<option value="<?php echo $TPL_V1["shipping_set_seq"]?>" nation="<?php echo $TPL_V1["delivery_nation"]?>"><?php echo $TPL_V1["shipping_set_name"]?></option>
<?php }}?>
</select>
<!-- 배송설정 :: END -->

<?php if($TPL_VAR["set_info"]["store_use"]=='N'){?>
<?php if($TPL_VAR["set_info"]["prepay_info"]=='delivery'){?>
(주문시 결제)
<?php }elseif($TPL_VAR["set_info"]["prepay_info"]=='postpaid'){?>
(착불)
<?php }else{?>
(주문시 결제, 착불)
<?php }?>
<?php }?>

<?php if($TPL_VAR["set_info"]["store_use"]=='N'){?>
<div class="shipping-info-lay">
	<!--ul class="ul_ship" style="margin-right:-10px; padding-right:5px; height:400px; overflow-y:scroll;"-->
	<ul class="ul_ship">
<?php if(is_array($TPL_R1=$TPL_VAR["set_info"]["shipping_opt_type"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
		<li>
			<dl class="clearbox">
				<dt><h5 class="title_sub3 Pt5 Pb5"><?php if($TPL_K1=='std'){?>기본<?php }elseif($TPL_K1=='add'){?>추가<?php }elseif($TPL_K1=='hop'){?>희망<?php }?>배송비</h5></dt>
<?php if($TPL_VAR["grp_info"]["shipping_calcul_type"]=='bundle'&&$TPL_I1== 0&&$TPL_VAR["grp_info"]["shipping_bundle_link"]){?>
				<dd><button type="button" value="" class="btn_resp" onclick="bundle_goods_search('<?php echo $TPL_VAR["grp_info"]["shipping_group_seq"]?>');">묶음배송 상품보기</button></dd>
<?php }?>
<?php if($TPL_K1=='hop'&&$TPL_VAR["mode"]!='goods'){?>
				<dd>
<?php if($TPL_VAR["hop_date"]){?>
					<span class="hop_date_txt" style="vertical-align:middle; margin-right:5px;">선택된 일자 : <?php echo $TPL_VAR["hop_date"]?></span>
<?php }else{?>
					<span class="hop_date_txt" style="vertical-align:middle; margin-right:5px;">미지정</span>
<?php }?>
					<button type="button" class="btn_resp" onclick="hop_calendar_pop('<?php echo $TPL_VAR["set_info"]["shipping_group_seq"]?>', '<?php echo $TPL_VAR["set_info"]["shipping_set_seq"]?>');">희망배송일</button>
				</dd>
<?php }?>
			</dl>
<?php if($TPL_K1=='hop'&&$TPL_VAR["mode"]!='goods'){?>
			<div class="detailDescriptionLayer hopCalendarLayer hide" style="width:280px;height:135px;background-color:#fff;top:100px;left:80px;">달력</div>
<?php }?>
<?php if($TPL_VAR["set_info"]["shipping_opt_type"][$TPL_K1]=='free'||$TPL_VAR["set_info"]["shipping_opt_type"][$TPL_K1]=='fixed'){?>
			<table width="100%" class="list_table_style" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="160px"/>
			</colgroup>
			<thead>
			<tr>
				<th class="center bold" scope="col">지역</th>
				<th class="center bold" scope="col">배송비</th>
			</tr>
			</thead>
			<tbody>
<?php if(is_array($TPL_R2=$TPL_VAR["set_info"]['shipping_area_name'][$TPL_K1])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
			<tr>
				<td class="zone_area">
<?php if($TPL_VAR["set_info"]['sel_address_txt'][$TPL_K1][$TPL_K2]){?>
					<span class="blue hand" onclick="ship_zone_pop(this);"><?php echo $TPL_V2?></span>
					<!-- 상세 지역설명 :: START -->
					<div class="detailDescriptionLayer relative hide " style="width:300px; top:50% !important; left:50% !important; transform:translateX(-50%) translateY(-50%);">
						<div class="layer_wrap">
							<h1><?php echo $TPL_V2?> <?php if($TPL_K1=='std'){?>배송<?php }elseif($TPL_K1=='add'){?>추가배송비<?php }elseif($TPL_K1=='hop'){?>희망배송일 가능<?php }?> 지역</h1>
							<div class="layer_inner">
								<ul class="ul_list2">
<?php if(is_array($TPL_R3=$TPL_VAR["set_info"]['sel_address_txt'][$TPL_K1][$TPL_K2])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
									<li><?php echo $TPL_V3?></li>
<?php }}?>
								</ul>
							</div>
							<a class="detailDescriptionLayerCloseBtn" href="javascript:;">닫기</a>
						</div>
					</div>
					<!-- 상세 지역설명 :: END -->
<?php }else{?>
					<span><?php echo $TPL_V2?></span>
<?php }?>
				</td>
				<td class="right bold">
					<?php echo get_currency_price($TPL_VAR["set_info"]['shipping_cost'][$TPL_K1][$TPL_K2], 2)?>

				</td>
			</tr>
<?php }}?>
			</tbody>
			</table>
<?php }else{?>
			<div style="width:100%; overflow-x:auto;">
				<table class="list_table_style" border="0" cellspacing="0" cellpadding="0" style="width:100%; table-layout:fixed;">
				<thead>
				<tr>
					<th class="center bold" scope="col" style="width:160px;">
<?php if($TPL_VAR["grp_info"]["shipping_calcul_type"]=='bundle'){?>묶음배송 <?php }?>
						<?php echo $TPL_VAR["set_info"]['shipping_opt_type_txt'][$TPL_K1]?>

					</th>
<?php if(is_array($TPL_R2=$TPL_VAR["set_info"]['shipping_area_name'][$TPL_K1])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
					<th class="zone_area center bold" scope="col" style="width:100px;">
<?php if($TPL_VAR["set_info"]['sel_address_txt'][$TPL_K1][$TPL_K2]){?>
						<span class="blue hand" onclick="ship_zone_pop(this);"><?php echo $TPL_V2?></span>
						<!-- 상세 지역설명 :: START -->
						<div class="detailDescriptionLayer relative hide" style="width:300px; top:50% !important; left:50% !important; transform:translateX(-50%) translateY(-50%);">
							<div class="layer_wrap">
								<h1><?php echo $TPL_V2?> <?php if($TPL_K1=='std'){?>배송<?php }elseif($TPL_K1=='add'){?>추가배송비<?php }elseif($TPL_K1=='hop'){?>희망배송일 가능<?php }?> 지역</h1>
								<div class="layer_inner">
									<ul class="ul_list2">
<?php if(is_array($TPL_R3=$TPL_VAR["set_info"]['sel_address_txt'][$TPL_K1][$TPL_K2])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
										<li><?php echo $TPL_V3?></li>
<?php }}?>
									</ul>
								</div>
								<a class="detailDescriptionLayerCloseBtn" href="javascript:;">닫기</a>
							</div>
						</div>
						<!-- 상세 지역설명 :: END -->
<?php if($TPL_K1=='hop'&&$TPL_VAR["set_info"]['today_yn'][$TPL_K2]=='Y'){?>
						<div class="desc">(당일배송 가능)</div>
<?php }?>
<?php }else{?>
						<span><?php echo $TPL_V2?></span>
<?php }?>
					</th>
<?php }}?>
				</tr>
				</thead>
				<tbody>
<?php if(is_array($TPL_R2=$TPL_VAR["set_info"]['section_st'][$TPL_K1])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_K2=>$TPL_V2){$TPL_I2++;?>
				<tr>
					<!-- 구간 영역 :: START -->
					<td>
<?php if($TPL_VAR["set_info"]['shipping_opt_type'][$TPL_K1]=='free'||$TPL_VAR["set_info"]['shipping_opt_type'][$TPL_K1]=='fixed'){?>
						─
<?php }else{?>
<?php if($TPL_VAR["set_info"]['shipping_opt_unit'][$TPL_K1]){?>
								<?php echo $TPL_V2?> <?php echo $TPL_VAR["set_info"]['shipping_opt_unit'][$TPL_K1]?>

<?php }else{?>
								<?php echo get_currency_price($TPL_V2, 2)?>

<?php }?>
<?php if(count($TPL_VAR["set_info"]['section_st'][$TPL_K1])>($TPL_I2+ 1)){?>
							~
<?php if($TPL_VAR["set_info"]['shipping_opt_unit'][$TPL_K1]){?>
								<?php echo $TPL_VAR["set_info"]['section_ed'][$TPL_K1][$TPL_K2]?> <?php echo $TPL_VAR["set_info"]['shipping_opt_unit'][$TPL_K1]?> 미만
<?php }else{?>
								<?php echo get_currency_price($TPL_VAR["set_info"]['section_ed'][$TPL_K1][$TPL_K2], 2)?>

<?php }?>
<?php }else{?>
<?php if(strpos($TPL_VAR["set_info"]['shipping_opt_type'][$TPL_K1],'rep')&&count($TPL_VAR["set_info"]['section_st'][$TPL_K1])==($TPL_I2+ 1)){?>
							부터는
<?php }else{?>
							이상&nbsp; ~ 
<?php }?>

<?php if(strpos($TPL_VAR["set_info"]['shipping_opt_type'][$TPL_K1],'rep')){?>
							<?php echo $TPL_VAR["set_info"]['section_ed'][$TPL_K1][$TPL_I2]?> <?php echo $TPL_VAR["set_info"]['shipping_opt_unit'][$TPL_K1]?>

<?php if(count($TPL_VAR["set_info"]['section_st'][$TPL_K1])==($TPL_I2+ 1)){?>당<?php }else{?>미만<?php }?>
<?php }elseif(count($TPL_VAR["set_info"]['section_st'][$TPL_K1])>($TPL_I2+ 1)){?>
							<?php echo $TPL_VAR["set_info"]['section_ed'][$TPL_K1][$TPL_I2]?> <?php echo $TPL_VAR["set_info"]['shipping_opt_unit'][$TPL_K1]?>

<?php }?>
<?php }?>
<?php }?>
					</td>
					<!-- 구간 영역 :: END -->

					<!-- 금액 영역 :: START -->
<?php if(is_array($TPL_R3=range($TPL_I2*count($TPL_VAR["set_info"]['shipping_area_name'][$TPL_K1]),((($TPL_I2+ 1)*count($TPL_VAR["set_info"]['shipping_area_name'][$TPL_K1]))- 1)))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
					<td class="right bold">
						<?php echo get_currency_price($TPL_VAR["set_info"]['shipping_cost'][$TPL_K1][$TPL_V3], 2)?>

<?php if($TPL_VAR["set_info"]['shipping_cost_today_front'][$TPL_K1][$TPL_V3]){?>
						<div>당일 <?php echo get_currency_price($TPL_VAR["set_info"]['shipping_cost_today_front'][$TPL_K1][$TPL_V3], 2)?>

						</div>
<?php }?>
					</td>
<?php }}?>
					<!-- 금액 영역 :: END -->
				</tr>
<?php }}?>
				</tbody>
				</table>
			</div>
<?php }?>
		</li>
<?php }}?>
	</ul>
	<ul class="mt15">
<?php if($TPL_VAR["set_info"]["hop_use"]=='Y'){?>
		<li>※ 배송가능일자를 선택하세요. <?php if($TPL_VAR["set_info"]["hopeday_required"]=='Y'){?>(필수사항)<?php }else{?>(선택사항)<?php }?></li>
<?php if($TPL_VAR["set_info"]["hopeday_limit_set"]=='time'){?>
		<li>※ 오늘 <?php echo substr($TPL_VAR["set_info"]["hopeday_limit_val_time"], 0, 2)?>시 <?php echo substr($TPL_VAR["set_info"]["hopeday_limit_val_time"], 2, 2)?>분 이전 주문 시 당일배송 가능</li>
<?php }?>
<?php }?>
<?php if($TPL_VAR["goods_info"]["reserve_ship_txt"]){?>
		<li>※ <?php echo $TPL_VAR["goods_info"]["reserve_ship_txt"]?></li>
<?php }?>
	</ul>
</div>
<?php }elseif($TPL_VAR["set_info"]["store_use"]=='Y'){?>
<div class="shipping-info-lay">
	<div class="pdt15">
		<select name="store_sel" id="store_sel" onchange="chg_shipping_set();" style="width:100%;">
<?php if(is_array($TPL_R1=$TPL_VAR["set_info"]["shipping_store_name"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
<?php if($TPL_VAR["set_info"]['shipping_store_use'][$TPL_I1]=='Y'){?>
			<option value="<?php echo $TPL_VAR["set_info"]['shipping_address_seq'][$TPL_K1]?>">수령매장 : <?php echo $TPL_V1?> <?php if($TPL_VAR["set_info"]['shipping_wh_supply'][$TPL_I1]){?>(재고수량: <?php echo Number_format($TPL_VAR["set_info"]['shipping_wh_supply'][$TPL_I1])?>개)<?php }?></option>
<?php }?>
<?php }}?>
		</select>
	</div>
<?php if($TPL_VAR["config_basic"]["map_client_id"]&&$TPL_VAR["config_basic"]["map_client_secret"]&&$TPL_VAR["store_info"]["shipping_address_txt"]){?>
	<div class="mt10">
		<div class="map_area" style="border:1px solid #ccc; background:#fafafa;height:150px;">
			<iframe id="mapfrm" src="" style="border:0;height:100%;width:100%;"></iframe>
		</div>
	</div>
<?php }?>
	<div class="mt10"><?php echo $TPL_VAR["store_info"]["shipping_address_txt"]?></div>
	<div class="mt15 ui-dialog-box" style="<?php if($TPL_VAR["config_basic"]["map_client_id"]&&$TPL_VAR["config_basic"]["map_client_secret"]&&$TPL_VAR["store_info"]["shipping_address_txt"]){?>height:200px;<?php }else{?>height:350px;<?php }?> overflow-y:scroll;">
		<span class="ico_de"></span> <strong>매장수령</strong>
		<p class="mt5">매장수령은 온라인에서 결제하신 상품을 원하시는 오프라인매장에 직접 방문하여 찾을 수 있는 서비스입니다.</p>
		<ul class="pickup clearbox">
			<li class="fir">온라인<br>상품구매</li>
			<li class="sec">상품<br>준비중</li>
			<li class="thi">상품<br>출고완료</li>
			<li class="fou point">매장<br>방문</li>
			<li class="fiv point">상품픽업</li>
		</ul>
		<ul class="ul_list2">
			<li>
				<strong>STEP 1 온라인 주문</strong>
				<p>온라인쇼핑몰에서 수령매장을 선택하여 상품을 주문하세요.</p>
			</li>
			<li>
				<strong>STEP 2 상품 출고완료</strong>
				<p>매장 재고에 따라 당일 또는 1~3일 이내 수령 가능합니다.<br>
				주문하신 상품의 수령준비(출고완료)가 완료되면 알림 SMS를 발송해 드립니다.<br>
				반드시 문자를 확인하신 후 매장을 방문해 주세요.</p>
			</li>
			<li>
				<strong>STEP 3 매장방문</strong>
				<p>매장을 방문하여 상품 수령 시, SMS에 기재된 출고번호를 보여주시기 바랍니다.</p>
			</li>
		</ul>
	</div>
</div>
<?php }?>

<?php if($TPL_VAR["direct_store"]=='Y'){?>
<div class="layer_bottom_btn_area">
	<button type="button" class="btn_resp size_c color6 Wmax" onclick="confirm_set_succ(); hideCenterLayer('.resp_layer_pop')">매장픽업 바로구매</button>
</div>
<?php }else{?>
<div class="layer_bottom_btn_area">
	<div class="add1">
		<span class="check_h_t">배송비가 있을 경우</span>
<?php if($TPL_VAR["set_info"]["prepay_info"]=='delivery'){?>
		<label class="input_label_a"><input type="radio" name="prepay_info" value="delivery" checked /> 주문시 결제</label>
<?php }elseif($TPL_VAR["set_info"]["prepay_info"]=='postpaid'){?>
		<label class="input_label_a"><input type="radio" name="prepay_info" value="postpaid" checked /> 착불</label>
<?php }else{?>
		<label class="input_label_a"><input type="radio" name="prepay_info" value="delivery" checked /> 주문시 결제</label>
		<label class="input_label_a"><input type="radio" name="prepay_info" value="postpaid" /> 착불</label>
<?php }?>
	</div>
	<button type="button" class="btn_resp size_c color6 Wmax" onclick="confirm_set_succ(); hideCenterLayer('.resp_layer_pop')">확인</button>
</div>
<?php }?>




<?php if($TPL_VAR["mode"]!='goods'){?>
<form name="shipFrm" id="shipFrm" method="post" action="/order/modify_shipping_changes" target="actionFrame">
<input type="hidden" name="cart_seq" value="" />
<input type="hidden" name="admin_mode" value="" />
<input type="hidden" name="cart_table" value="" />
<input type="hidden" name="ship_grp_seq" value="<?php echo $TPL_VAR["grp_info"]["shipping_group_seq"]?>" />
<input type="hidden" name="ship_set_seq" value="" />
<input type="hidden" name="ship_set_code" value="<?php echo $TPL_VAR["set_info"]["shipping_set_code"]?>" />
<input type="hidden" name="prepay_info" value="" />
<input type="hidden" name="store_seq" value="" />
<input type="hidden" name="hop_select_date" id="hop_select_date" value="<?php echo $TPL_VAR["hop_date"]?>" />
</form>
<?php }?>


<script type="text/javascript">
$(function() {
	radioCheckUI(); // 라디오 박스 디자인
});
</script>