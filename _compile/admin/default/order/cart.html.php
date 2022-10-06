<?php /* Template_ 2.2.6 2022/05/17 12:36:37 /www/music_brother_firstmall_kr/admin/skin/default/order/cart.html 000019480 */  $this->include_("snsLikeButton");
$TPL_shipping_group_list_1=empty($TPL_VAR["shipping_group_list"])||!is_array($TPL_VAR["shipping_group_list"])?0:count($TPL_VAR["shipping_group_list"]);?>
<style type="text/css">
table,div,button {font-size:12px; }
.rborder { border-right:1px solid #ddd; }
</style>
<script type="text/javascript">

$(document).ready(function(){
	
	$(".detailDescriptionLayerBtn").click(function(){
		$('div.detailDescriptionLayer').not($(this).next('div.detailDescriptionLayer')).hide();
		$(this).next('div.detailDescriptionLayer').show();
	});
	$(".detailDescriptionLayerCloseBtn").click(function(){
		$(this).closest('div.detailDescriptionLayer').hide();
	});
	
	// 배송설정 변경시
	function chg_shipping_set(nation){
		alert(nation);
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
					$("#shipping_detail_lay").html(html);
				}else{
					//배송방법 정보가 누락되었습니다\n새로고침 후 다시 시도해주세요.
					alert(getAlert('os235'));
				}
			}
		});
	}
	

	// 배송 방법 변경 :: 2016-07-30 lwh
	$("button.btn_shipping_modify").on("click",function() {
		var cart_seq	= $(this).attr('cart_seq');
		var prepay_info = $(this).attr('prepay_info');
		var nation		= $(this).attr('nation');
		var hop_date	= $(this).attr('hop_date');
		var goods_seq	= $(this).attr('goods_seq');
		var reserve_txt	= $(this).attr('reserve_txt');	
		
		$.ajax({
			'url'	: '/goods/shipping_detail_info',
			'data'	: {'mode':'cart','cart_seq':cart_seq,'prepay_info':prepay_info,'nation':nation,'hop_date':hop_date,'goods_seq':goods_seq,'reserve_txt':reserve_txt,'cart_table':'<?php echo $TPL_VAR["cart_table"]?>','admin_mode':'cart'},
			'type'	: 'get',
			'dataType': 'text',
			'success': function(html) {
				if(html){
					$("div#shipping_detail_lay").html(html);
					//배송방법 안내 및 변경
					openDialog(getAlert('oc040'), "shipping_detail_lay", {"width":500,"height":650});//oc140
				}else{
					//오류가 발생했습니다. 새로고침 후 다시시도해주세요.
					alert(getAlert('oc041'));
					document.location.reload();
				}
			}
		});
	});


});

// 내역 레이어 팝업 열기
function open_sale_price_layer(obj){
	$(obj).closest('div').find(".sale_price_layer").show();
}
// 내역 레이어 팝업 닫기
function close_sale_price_layer(obj){
	$(obj).closest('div').find(".sale_price_layer").hide();
}


</script>
<!-- List -->

<div id="shipping_detail_lay" style="display:none;"></div>

<div class="admin_cart">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table_style">
	<caption>주문상품</caption>
	<colgroup>
		<col /><col style="width:8%" /><col style="width:10%" /><col style="width:10%" />
		<col style="width:10%" /><col style="width:16%" />
	</colgroup>
	<thead>
		<tr>
			<th scope="col">주문상품</th>
			<th scope="col">수량</th>
			<th scope="col">상품금액</th>
			<th scope="col">할인</th>
			<th scope="col">할인금액</th>
			<!--<th scope="col" class="hide">적립</th>-->
			<th scope="col">배송비</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_VAR["shipping_group_list"]){?>
<?php if($TPL_shipping_group_list_1){foreach($TPL_VAR["shipping_group_list"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
		<tr>
			<td class="relative">
				<dl class="order_thumb_wrap">
					<dt>
						<a href="/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>"><img src="<?php echo $TPL_V2["image"]?>" class="order_thumb" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif'" width="60" alt="<?php echo $TPL_V2["goods_name"]?>" /></a>
					</dt>
					<dd>
						<input type="hidden" name="cartOptionSeq[]" value="<?php echo $TPL_V2["cart_option_seq"]?>" />
						<a href="/goods/view?no=<?php echo $TPL_V2["goods_seq"]?>" title="<?php echo $TPL_V2["goods_name"]?>" class="order_name"><?php echo $TPL_V2["goods_name"]?></a>
<?php if($TPL_V2["adult_goods"]=='Y'){?>
						<img src="/admin/skin/default/images/common/auth_img.png" height="17" align="absmiddle" alt="성인" />
<?php }?>
<?php if($TPL_V2["option_international_shipping_status"]=='y'){?>
							<img src="/admin/skin/default/images/common/icon/plane_on.png" height="14" align="absmiddle" alt="해외배송상품" />
<?php }?>
						<div>
<?php if($TPL_V2["cancel_type"]=='1'){?>
							<span class="btn_move icon mt3">청약철회불가</span>
<?php }?>
<?php if($TPL_V2["tax"]=='exempt'){?>
							<span class="btn_move icon mt3">비과세</span>
<?php }?>
						</div>
<?php if($TPL_V2["option1"]!=null){?>
						<div class="order_option mt3">
							<span class="btn_gray icon">옵션</span>
<?php if($TPL_V2["title1"]){?>
							<?php echo $TPL_V2["title1"]?>:<?php }?><?php echo $TPL_V2["option1"]?><?php if($TPL_V2["option2"]){?>, <?php if($TPL_V2["title2"]){?>
							<?php echo $TPL_V2["title2"]?>:<?php }?><?php echo $TPL_V2["option2"]?><?php }?><?php if($TPL_V2["option3"]){?>, <?php if($TPL_V2["title3"]){?>
							<?php echo $TPL_V2["title3"]?>:<?php }?><?php echo $TPL_V2["option3"]?><?php }?><?php if($TPL_V2["option4"]){?>, <?php if($TPL_V2["title4"]){?>
							<?php echo $TPL_V2["title4"]?>:<?php }?><?php echo $TPL_V2["option4"]?><?php }?><?php if($TPL_V2["option5"]){?>, <?php if($TPL_V2["title5"]){?>
							<?php echo $TPL_V2["title5"]?>:<?php }?><?php echo $TPL_V2["option5"]?><?php }?>
						</div>
<?php }?>
<?php if($TPL_V2["eventEnd"]){?>
						<div class="soloEventTd<?php echo $TPL_V2["cart_option_seq"]?> eventEnd mt3">
							<img src="/admin/skin/default/images/common/icon_clock.gif" alt="clock" />
							<span class="time_count">
								<span id="soloday<?php echo $TPL_V2["cart_option_seq"]?>">0</span>일
								<span id="solohour<?php echo $TPL_V2["cart_option_seq"]?>">00</span>:<span id="solomin<?php echo $TPL_V2["cart_option_seq"]?>">00</span>:<span id="solosecond<?php echo $TPL_V2["cart_option_seq"]?>">00</span>
							</span>
						</div>
						<script type="text/javascript">
							$(function() {
								timeInterval<?php echo $TPL_V2["cart_option_seq"]?> = setInterval(function(){
									var time<?php echo $TPL_V2["cart_option_seq"]?> = showClockTime('text', '<?php echo $TPL_V2["eventEnd"]["year"]?>', '<?php echo $TPL_V2["eventEnd"]["month"]?>', '<?php echo $TPL_V2["eventEnd"]["day"]?>', '<?php echo $TPL_V2["eventEnd"]["hour"]?>', '<?php echo $TPL_V2["eventEnd"]["min"]?>', '<?php echo $TPL_V2["eventEnd"]["second"]?>', 'soloday<?php echo $TPL_V2["cart_option_seq"]?>', 'solohour<?php echo $TPL_V2["cart_option_seq"]?>', 'solomin<?php echo $TPL_V2["cart_option_seq"]?>', 'solosecond<?php echo $TPL_V2["cart_option_seq"]?>', '<?php echo $TPL_V2["cart_option_seq"]?>');
									if(time<?php echo $TPL_V2["cart_option_seq"]?> == 0){
										clearInterval(timeInterval<?php echo $TPL_V2["cart_option_seq"]?>);
										//단독 이벤트 종료
										$(".soloEventTd<?php echo $TPL_V2["cart_option_seq"]?>").html(getAlert('oc135'));
									}
								},1000);
							});
						</script>
<?php }?>
<?php if($TPL_V2["cart_inputs"]){?>
<?php if(is_array($TPL_R3=$TPL_V2["cart_inputs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["input_value"]){?>
								<div class="order_option mt3">
									<span class="btn_gray icon">옵션</span>
<?php if($TPL_V3["type"]=='file'){?>
<?php if($TPL_V3["input_title"]){?><?php echo $TPL_V3["input_title"]?>:<?php }?> <a href="/mypage_process/filedown?file=<?php echo $TPL_V3["input_value"]?>" target="actionFrame"><img src="/mypage_process/filedown?file=<?php echo $TPL_V3["input_value"]?>" width="13" height="13" title="크게 보기" align="absmiddle" /> <span class="desc"><?php echo $TPL_V3["input_value"]?></span></a>
<?php }else{?>
<?php if($TPL_V3["input_title"]){?><?php echo $TPL_V3["input_title"]?>:<?php }?><?php echo $TPL_V3["input_value"]?>

<?php }?>
								</div>
<?php }?>
<?php }}?>
<?php }?>
<?php if($TPL_VAR["cfg"]["order"]["fblike_ordertype"]&&$TPL_VAR["fblikesale"]){?>
						<div class="fblikelay mt5">
							<?php echo snsLikeButton($TPL_V2["goods_seq"],'button_count')?>

						</div>
<?php }?>
					</dd>
				</dl>
				<!-- 배송불가 -->
				<dl class="ship_no <?php if($TPL_V1["ship_possible"]=='Y'){?>hide<?php }?>">
<?php if($TPL_V1["ship_possible"]=='N'){?>
					<dt>선택하신 국가로 배송이 불가한 상품입니다.</dt>
<?php }elseif($TPL_V1["ship_possible"]=='H'){?>
					<dt>선택하신 국가로 희망배송이 불가한 상품입니다.</dt>
<?php }?>
					<dd></dd>
				</dl>
				<!-- //배송불가 -->
			</td>
			<td>
				<div><?php echo number_format($TPL_V2["ea"])?></div>
			</td>
			<td class="right"><?php echo get_currency_price($TPL_V2["price"]*$TPL_V2["ea"], 3)?></td>
			<td class="right">
				<div id="cart_option_sale_total_<?php echo $TPL_V2["cart_option_seq"]?>">
<?php if($TPL_V2["sales"]["total_sale_price"]> 0){?>
					<?php echo get_currency_price($TPL_V2["sales"]["total_sale_price"], 3)?>

<?php }else{?>
					-
<?php }?>
				</div>
				<!-- 할인내역 LAYER :: START -->
				<div id="cart_option_sale_detail_<?php echo $TPL_V2["cart_option_seq"]?>" <?php if($TPL_V2["sales"]["total_sale_price"]> 0){?><?php }else{?>class="hide"<?php }?>>
					<button type="button" class="mt3 btn_move small detailDescriptionLayerBtn">내역</button>
					<div class="detailDescriptionLayer hide" style="width:280px;">
						<div class="layer_wrap">
							<h1>할인내역</h1>
							<div class="layer_inner">
								<table class="tbl_col" width="100%" border="0" cellpadding="0" cellspacing="0">
									<caption>할인내역</caption>
									<colgroup>
										<col style="width:50%" /><col />
									</colgroup>
									<thead>
										<tr>
											<th scope="col">항목</th>
											<th scope="col">할인금액</th>
										</tr>
									</thead>
									<tbody>
<?php if(is_array($TPL_R3=$TPL_V2["sales"]["title_list"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
										<tr id="cart_option_<?php echo $TPL_K3?>_saletr_<?php echo $TPL_V2["cart_option_seq"]?>" <?php if($TPL_V2["sales"]["sale_list"][$TPL_K3]> 0){?><?php }else{?>class="hide"<?php }?>>
											<th scope="row"><?php echo $TPL_V2["sales"]["title_list"][$TPL_K3]?></th>
											<td>
												<?php echo get_currency_price($TPL_V2["sales"]["sale_list"][$TPL_K3], 3,'','<span id="cart_option_'.$TPL_K3.'_saleprice_'.$TPL_V2["cart_option_seq"].'">_str_price_</span>')?>

											</td>
										</tr>
<?php }}?>
									</tbody>
								</table>
							</div>
							<a href="javascript:;" class="detailDescriptionLayerCloseBtn"></a>
						</div>
					</div>
				</div>
				<!-- 할인내역 LAYER :: END -->
			</td>
			<td class="right bold">
				<?php echo get_currency_price($TPL_V2["sales"]["result_price"], 3,'','<span class="cart_option_price_'.$TPL_V2["cart_option_seq"].'">_str_price_</span>')?>

			</td>
			<!--
			<td class="hide">
				<table align="center" border="0">
					<tbody>
						<tr>
							<td><img src="/admin/skin/default/images/common/icon/icon_ord_emn.gif" title="캐시" /></td>
							<td class="right"><?php echo number_format($TPL_V2["reserve"], 3,'','<span id="option_reserve_'.$TPL_V2["cart_option_seq"].'">_str_price_</span>')?></td>
						</tr>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
						<tr>
							<td><img src="/admin/skin/default/images/common/icon/icon_ord_point.gif" title="포인트" /></td>
							<td class="right"><span id="option_point_<?php echo $TPL_V1["cart_option_seq"]?>"><?php echo get_currency_price($TPL_V2["point"])?></span>P</td>
						</tr>
<?php }?>
					</tbody>
				</table>
			</td>
			-->
<?php if($TPL_I2== 0){?>
			<td class="left goods_delivery_info" rowspan="<?php echo $TPL_V1["row_cnt"]?>">
				<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td>
						<div class="blue"><?php echo $TPL_V1["shipper_name"]?></div>
						<div><?php echo $TPL_V1["cfg"]["baserule"]["shipping_set_name"]?></div>
<?php if($TPL_V1["grp_shipping_price"]> 0){?>
						<div><?php echo get_currency_price($TPL_V1["grp_shipping_price"], 3)?></div>
<?php }else{?>
<?php if($TPL_V1["ship_possible"]=='Y'){?>
						<div>무료</div>
<?php }else{?>
						<div class="red">배송불가</div>
<?php }?>
<?php }?>
					</td>
					<td>
						<!-- 배송방법 변경 :: START -->
						<div class="order_change">
							<button type="button" class="btn_shipping_modify btn_move small" cart_seq="<?php echo $TPL_V2["cart_seq"]?>" prepay_info="<?php echo $TPL_V1["shipping_prepay_info"]?>" nation="<?php echo $TPL_V1["cfg"]["baserule"]["delivery_nation"]?>" goods_seq="<?php echo $TPL_V2["goods_seq"]?>" hop_date="<?php echo $TPL_V1["shipping_hop_date"]?>" reserve_txt="<?php echo $TPL_V1["reserve_sdate"]?><?php echo $TPL_V1["reserve_txt"]?>">변경</button>
						</div>
						<!-- 배송방법 변경 :: END -->
					</td>
				</tr>
				</table>
<?php if($TPL_V1["cfg"]["baserule"]["shipping_set_code"]=='direct_store'){?>
				<div class="ship_info">수령매장 : <?php echo $TPL_V1["store_info"]["shipping_store_name"]?></div>
<?php }else{?>
<?php if($TPL_V1["grp_shipping_price"]> 0){?>
<?php if($TPL_V1["shipping_prepay_info"]=='delivery'){?>
				<div class="ship_info">(주문시 결제)</div>
<?php }else{?>
				<div class="ship_info">(착불)</div>
<?php }?>
<?php }?>
<?php }?>
<?php if($TPL_V1["shipping_hop_date"]){?>
				<div class="ship_info">희망배송일 : <?php echo $TPL_V1["shipping_hop_date"]?></div>
<?php }elseif($TPL_V1["reserve_sdate"]){?>
				<div class="ship_info">예약배송일 : <?php echo $TPL_V1["reserve_sdate"]?></div>
<?php }?>
			</td>
<?php }?>
		</tr>
<?php if(is_array($TPL_R3=$TPL_V2["cart_suboptions"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
		<tr class="sub_bg">
			<td>
				<dl class="order_thumb_wrap">
					<dt>
						<img src="/admin/skin/default/images/common/icon_add_arrow.gif" class="pdr15" alt="" />
					</dt>
					<dd class="order_option">
						<span class="btn_gray icon">추가</span>
<?php if($TPL_V3["suboption"]){?>
<?php if($TPL_V3["suboption_title"]){?><?php echo $TPL_V3["suboption_title"]?>:<?php }?><?php echo $TPL_V3["suboption"]?>

<?php }?>
					</dd>
				</dl>
			</td>
			<td><?php echo number_format($TPL_V3["ea"])?></td>
			<td class="right"><?php echo get_currency_price($TPL_V3["price"]*$TPL_V3["ea"], 3)?></td>
			<td class="right">
				<div id="cart_suboption_sale_total_<?php echo $TPL_V3["cart_suboption_seq"]?>">
<?php if($TPL_V3["sales"]["total_sale_price"]> 0){?>
					<?php echo get_currency_price($TPL_V3["sales"]["total_sale_price"], 3)?>

<?php }else{?>
					-
<?php }?>
				</div>
				<div id="cart_suboption_sale_detail_<?php echo $TPL_V3["cart_suboption_seq"]?>" <?php if($TPL_V3["sales"]["total_sale_price"]> 0){?><?php }else{?>class="hide"<?php }?>>
					<button type="button" class="mt3 btn_move small detailDescriptionLayerBtn">내역</button>
					<div class="detailDescriptionLayer hide" style="width:280px;">
						<div class="layer_wrap">
							<h1>할인내역</h1>
							<div class="layer_inner">
								<table class="tbl_col" width="100%" border="0" cellpadding="0" cellspacing="0">
									<caption>할인내역</caption>
									<colgroup>
										<col style="width:50%" /><col />
									</colgroup>
									<thead>
										<tr>
											<th scope="col">항목</th>
											<th scope="col">할인금액</th>
										</tr>
									</thead>
									<tbody>
<?php if(is_array($TPL_R4=$TPL_V3["sales"]["sale_list"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_K4=>$TPL_V4){?>
										<tr id="cart_suboption_<?php echo $TPL_K4?>_saletr_<?php echo $TPL_V3["cart_suboption_seq"]?>" <?php if($TPL_V4> 0){?><?php }else{?>class="hide"<?php }?>>
											<td class="gr"><?php echo $TPL_V3["sales"]["title_list"][$TPL_K4]?></td>
											<td class="bolds ends prices">
												<?php echo get_currency_price($TPL_V4, 3,'','<span id="cart_suboption_'.$TPL_K3.'_saleprice_'.$TPL_V3["cart_suboption_seq"].'">_str_price_</span>')?>

											</td>
										</tr>
<?php }}?>
									</tbody>
								</table>
							</div>
							<a href="javascript:;" class="detailDescriptionLayerCloseBtn"></a>
						</div>
					</div>
				</div>
			</td>
			<td class="right bold">
				<?php echo get_currency_price($TPL_V3["sales"]["result_price"], 3,'','<span id="cart_suboption_price_'.$TPL_V2["cart_suboption_seq"].'">_str_price_</span>')?>

			</td>
			<td class="hide">
				<table align="center" border="0">
					<tbody>
						<tr>
							<td><img src="/admin/skin/default/images/common/icon/icon_ord_emn.gif" title="캐시" /></td>
							<td class="right"><?php echo get_currency_price($TPL_V3["reserve"], 3,'','<span id="suboption_reserve_'.$TPL_V3["cart_suboption_seq"].'">_str_price_</span>')?></td>
						</tr>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
						<tr>
							<td><img src="/admin/skin/default/images/common/icon/icon_ord_point.gif" title="포인트" /></td>
							<td class="right"><span id="suboption_point_<?php echo $TPL_V3["cart_suboption_seq"]?>"><?php echo get_currency_price($TPL_V3["point"])?></span>P</td>
						</tr>
<?php }?>
					</tbody>
				</table>
			</td>
		</tr>
<?php }}?>
<?php }}?>
<?php }}?>
<?php }else{?>
		<tr>
			<td class="nodata" colspan="6">선택된 상품이 없습니다.</td>
		</tr>
<?php }?>
	</tbody>
</table>
<!-- //주문상품 테이블 -->
</div>

<div class="order_settle clearbox">
	<div class="benefit">
		<dl class="clearbox" style="height:28px;">
			<dt>구매적립 혜택</dt>
			<dd>
				구매확정 시 : 캐시 <?php echo get_currency_price($TPL_VAR["total_reserve"], 3,'','<span id="total_reserve" class="bold">_str_price_</span>')?><?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>, 포인트 <span id="total_point" class="bold"><?php echo get_currency_price($TPL_VAR["total_point"])?></span>P
<?php }?>
			</dd>
		</dl>
	</div>
</div>
<!-- //결제금액 -->