<?php /* Template_ 2.2.6 2022/05/17 12:31:57 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_ifstatus.html 000015883 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
	$(document).ready(function() {

		// 재고 정책 선택시
		$("select[name='batch_runout_type']").bind("change",function(){ chk_runout_type(); });

		// 재고연동판매 체크
		$("select[name='batch_runout_policy']").bind("change",function(){ chk_runout_policy(); });


		//상품승인 -> 미승인시 판매중지자동
		$(".batch_provider_status").bind("change",function(){
			if( $(this).val() != '1' ) {
				openDialogAlert("'미승인'처리되며<br />상품 상태는 '판매중지'가 됩니다.",400,150,function(){},'');
				$(this).parent().parent().find(".input_goods_status option[value='unsold']").attr("selected",true);
			}else{
			}
		});

		//상품상태 -> 미승인 상품을 정상 처리시
		$(".batch_goods_status").bind("change",function(){
			//if( $(this).closest("table").find(".batch_provider_status").val() == '0' && $(this).val() != 'unsold' ) {//미승인시
				openDialogAlert("승인상품만 ' 정상' 처리됩니다.",350,150,function(){},'');
				//$(this).find("option[value='unsold']").attr("selected",true);
			//}
		});

		chk_runout_type();
		chk_runout_policy();
	});
</script>

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

<style>
	/*입점몰에만 버튼 css가 적용되지 않아 추가*/
	#dialog_confirm .ui-state-default { border: 1px solid #777777; background: #111111 url(/admin/skin/default/goods/images/ui-bg_glass_40_111111_1x400.png) 50% 50% repeat-x; font-weight: normal; color: #e3e3e3; }

	.ui-dialog-buttonset {text-align:center; margin-top:10px;}
	.ui-dialog-buttonset #btn_normal_gname {width:120px;font-size:12px;margin-right:25px;}
	.ui-dialog-buttonset #btn_runout_gname {width:120px;font-size:12px;}
	.ui-dialog-buttonset #btn_pop_close,#btn_pop_normal_close,#btn_pop_runout_close {width:80px;border-color:#eee;font-size:12px;height:32px;background:url('/admin/skin/default/images/common/btnBg.gif') no-repeat;background-position:0 -3699px;color:#fff;}

	.info_stock_status_table {width:90%;border: 1px solid #bcbcbc;border-collapse:collapse;}
	.info_stock_status_table th, .info_stock_status_table td{padding:8px 0 8px 0;border: 1px solid #bcbcbc;}
	.info_stock_status_table th{background-color:#f1f1f1;}
	.info_stock_status_table tr td:first-child {text-align:center;}
	.info_stock_status_table tr td:last-child {padding-left:20px;}
</style>

<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="20%" /><!--대상 상품-->
		<col width="80%" /><!--아래와 같이 업데이트-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th>대상 상품</th>
		<th colspan="2">아래와 같이 업데이트</th>
	</tr>
	</thead>

	<tbody class="ltb">
		<tr class="list-row" style="height:70px;">
			<td align="center" class="td">
			검색된 상품에서  →
			<select name="modify_list"  class="line">
				<option value="choice">선택 </option>
				<option value="all">전체 </option>
			</select>
			</td>
			<td>

				<table width="100%" cellpadding="0"  cellspacing="0" style="border:1px;">
				<colgroup>
					<col width="20%" />
					<col  />
				</colgroup>
<?php if(serviceLimit('H_AD')){?>
				<tr>
					<td><label><input type="checkbox" class="batch_update_item" name="batch_provider_status_yn" value="1" /> 승인/미승인 </label></td>
					<td>
						<select name="batch_provider_status" class="batch_provider_status line" style="width:120px;">
						<option value="1">승인</option>
						<option value="0">미승인</option>
						</select> 변경합니다.
					</td>
				</tr>
<?php }?>
				<tr>
					<td><label><input type="checkbox" class="batch_update_item" name="batch_goods_view_yn" value="1" /> 노출/미노출</label></td>
					<td>
						<select name="batch_goods_view" class="batch_goods_view line" style="width:120px;">
						<option value="look">노출</option>
						<option value="notLook">미노출</option>
						</select>
						변경합니다.
					</td>
				</tr>
				<tr>
					<td><label><input type="checkbox" class="batch_update_item" name="batch_goods_status_yn" value="1" /> 상태</label></td>
					<td>
						<select name="batch_goods_status" class="batch_goods_status line" style="width:120px;">
						<option value="normal_runout">정상/품절</option>
						<option value="purchasing">재고확보중</option>
						<option value="unsold">판매중지</option>
						</select>
						변경합니다.
					</td>
				</tr>
				<tr>
					<td><label><input type="checkbox" class="batch_update_item" name="batch_runout_type_yn" value="1" /> 재고에 따른 판매 여부를</label></td>
					<td>
						<!--재고연동판매-->
						<select name="batch_runout_type" class="batch_runout_type runout_type line" style="float:left;width:120px">
							<option value='shop'>통합정책</option>
							<option value='goods'>개별정책</option>
						</select>
						<div class="runout_span hide ml5" style="float:left">
							<select name="batch_runout_policy" class="runout_policy line" style="width:120px;">
								<option value='stock'>재고연동</option>
								<option value='ableStock'>가용재고연동</option>
								<option value='unlimited'>재고무관</option>
							</select>
							<input type="text" size="4" name="batch_able_stock_limit" style="text-align:right" value="0" />
						</div>
						<div style="float:left;" class="runout_span2 mt5 ml5 desc">
						<!-- 통합정책 상세 -->
<?php if($TPL_VAR["config_runout"]=="stock"){?>
							(재고가 1 이상일 때 판매)
<?php }elseif($TPL_VAR["config_runout"]=="ableStock"){?>
							(가용재고가 <?php echo number_format($TPL_VAR["config_ableStockLimit"])?> 이상일 때 판매)
<?php }else{?>
							(재고와 상관없이 판매)
<?php }?>
						</div>
						<div style="float:left;" class="mt5 ml5">변경합니다.</div>
					</td>
				</tr>
				<tr>
					<td><label><input type="checkbox" class="batch_update_item" name="batch_adult_goods_yn" value="1" /> 성인</label></td>
					<td>
						<select name="batch_adult_goods" class="batch_adult_goods line" style="width:120px;">
							<option value="N">일반</option>
							<option value="Y">성인</option>
						</select> 변경합니다.
					</td>
				</tr>
				<tr>
					<td><label><input type="checkbox" class="batch_update_item" name="batch_option_international_shipping_status_yn" value="1" /> 해외구매대행</label></td>
					<td>
						<select name="batch_option_international_shipping_status" class="batch_option_international_shipping_status line" style="width:120px;">
							<option value="N">일반</option>
							<option value="Y">구매대행</option>
						</select> 변경합니다.
					</td>
				</tr>
				<tr>
					<td style="border-bottom:0px;"><label><input type="checkbox" class="batch_update_item" name="batch_cancel_type_yn" value="1" /> 청약철회</label></td>
					<td style="border-bottom:0px;">
						<select name="batch_cancel_type" class="batch_cancel_type line" style="width:120px;">
							<option value="1">청약철회불가</option>
							<option value="0">청약철회가능</option>
						</select> 변경합니다.
					</td>
				</tr>
			</table>



			</td>

		</tr>
	</tbody>
</table>

<br style="line-height:2px;" />
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="30" /><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="100" /><!--입점--><?php }?>
		<col width="55" /><!--상품이미지-->
		<col /><!--상품명-->
<?php if(serviceLimit('H_AD')){?><col width="110" /><!--승인/미승인--><?php }?>
		<col width="110" /><!--노출/미노출-->
		<col width="130" /><!--상태-->
		<col width="140" /><!--재고에따른판매여부-->
		<col width="100" /><!--성인-->
		<col width="100" /><!--해외구매대행-->
		<col width="255" /><!--청약철회-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
<?php if(serviceLimit('H_AD')){?><th>입점</th><?php }?>
		<th colspan="2">상품명</th>
<?php if(serviceLimit('H_AD')){?><th>승인/미승인</th><?php }?>
		<th>노출/미노출</th>
		<th>상태</th>
		<th>재고에따른판매여부</th>
		<th>성인</th>
		<th>해외구매대행</th>
		<th>청약철회</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;">
			<td class="center"><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_V1["provider_seq"]=='1'){?>
			<td class="bg-blue white bold center">
<?php if($TPL_V1["lastest_supplier_name"]){?>
				매입 - <?php echo $TPL_V1["lastest_supplier_name"]?>

<?php }else{?>
				매입
<?php }?>
			</td>
<?php }else{?>
			<td class="bg-red white bold center"><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
<?php }?>
			<td class="center">
				<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a>
			</td>
			<td class="left" style="padding-left:10px;">
<?php if($TPL_V1["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
				<a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo $TPL_V1["goods_name"]?></a>
				<div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
			</td>
<?php if(serviceLimit('H_AD')){?>
			<!-- 승인/미승인 -->
			<td class="center">
<?php if($TPL_V1["provider_status"]=='0'||$TPL_V1["provider_status"]==''){?>미승인<?php }else{?>승인<?php }?>
			</td>
<?php }?>
			<!-- 노출/미노출 -->
			<td class="center">
<?php if($TPL_V1["display_terms"]=='AUTO'){?>
				<span class="click-lay display-terms-<?php echo $TPL_V1["goods_seq"]?>" style="color:#ff9900 !important;" onclick="openGoodsDisplayTerms('<?php echo $TPL_V1["goods_seq"]?>');">자동노출</span>
<?php }?>
				<span class="display-goods-view-<?php echo $TPL_V1["goods_seq"]?> <?php if($TPL_V1["display_terms"]=='AUTO'){?>hide<?php }?>">
<?php if($TPL_V1["goods_view"]=='look'){?>노출<?php }else{?>미노출<?php }?>
				</span>
			</td>
			<!-- 상태 -->
			<td class="center">
				<p class="goods_status_text"><?php echo $TPL_V1["goods_status_text"]?></p>
<?php if($TPL_V1["goods_status"]=='normal'||$TPL_V1["goods_status"]=='runout'){?><span class="desc">(정상/품절)</span><?php }?>
			</td>

			<!-- 재고에따른판매여부 -->
			<td class="option_td pdl5 center">
<?php if(!$TPL_V1["runout_policy"]){?>
					통합정책
<?php }else{?>
					개별정책
					<div class="desc">
<?php if($TPL_V1["runout_policy"]=='stock'){?>(재고가 있을 때 판매)
<?php }else{?>
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'){?>
<?php if($TPL_V1["runout_policy"]=='ableStock'){?>(가용재고가 <?php echo number_format($TPL_V1["able_stock_limit"])?> 이상일 때 판매))
<?php }elseif($TPL_V1["runout_policy"]=='unlimited'){?>(재고와 상관없이 판매)<?php }?>
<?php }?>
<?php }?>
					</div>
<?php }?>
			</td>

			<!--성인-->
			<td class="center">
<?php if($TPL_V1["adult_goods"]=="N"){?>일반<?php }elseif($TPL_V1["adult_goods"]=="Y"){?>성인<?php }?>
			</td>

			<!--해외구매대행-->
			<td class="center">
<?php if($TPL_V1["option_international_shipping_status"]=="y"){?>구매대행<?php }else{?>일반<?php }?>
				</select>
			</td>

			<!--청약철회-->
			<td class="center">
<?php if($TPL_V1["cancel_type"]=="1"){?>청약철회불가<?php }elseif($TPL_V1["cancel_type"]=="0"){?>청약철회가능<?php }?>
				</select>
			</td>
		</tr>
		<tr class="order-list-summary-row hide">
			<td colspan="10" class="order-list-summary-row-td option_info_td"><div class="option_info"></div></td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" colspan="10">
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
<!-- 주문리스트 테이블 : 끝 -->


<div id="dialog_confirm" class="hide">
	<div align="center" id="dialog_confirm_msg"></div>
	<div class="ui-dialog-buttonset">
		<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" type="button" id="btn_normal_gname" mode="ifstatus"><span class="ui-button-text">품절⇒정상<br/>변경 상품</span></button>
		<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" type="button" id="btn_runout_gname" mode="ifstatus"><span class="ui-button-text">정상⇒품절<br/>변경 상품</span></button>
		<br /><br />
		<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" type="button" id="btn_pop_close"><span class="ui-button-text">닫기</span></button>
	</div>
</div>

<div id="dialog_confirm_normal" class="hide">
	<div align="left" id="dialog_normal_table">아래 상품은 ‘품절’에서 ‘정상’으로 변경된 상품입니다.<br /><br /></div>
	<br /><br />
	<div class="ui-dialog-buttonset">
		<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" type="button" id="btn_pop_normal_close"><span class="ui-button-text">닫기</span></button>
	</div>
</div>

<div id="dialog_confirm_runout" class="hide">
	<div align="left" id="dialog_runout_table">아래 상품은 ‘정상’에서 ‘품절’로 변경된 상품입니다.<br /><br /></div>
	<br /><br />
	<div class="ui-dialog-buttonset">
		<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" type="button" id="btn_pop_runout_close"><span class="ui-button-text">닫기</span></button>
	</div>
</div>