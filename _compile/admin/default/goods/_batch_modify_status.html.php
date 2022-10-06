<?php /* Template_ 2.2.6 2022/05/17 12:31:58 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_status.html 000018487 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
	$(document).ready(function() {

		// 재고 정책 선택시
		$("select.runout_type").bind("change",function(){ chk_runout_type(); });

		// 재고연동판매 체크
		$("select.runout_policy").bind("change",function(){ chk_runout_policy(); });

		//상품승인 -> 미승인시 판매중지자동
		$(".provider_status").bind("change",function(){
			if( $(this).val() != '1' ) {
				openDialogAlert("'미승인' 처리되며, 상품 상태는 '판매중지'가 됩니다.",400,150,function(){},'');
				$(this).parent().parent().find(".goods_status option[value='unsold']").attr("selected",true);
			}else{ }
		});

		//상품상태 -> 미승인시 판매중지만가능
		$(".goods_status").bind("change",function(){
			if( $(this).closest("tr").find(".provider_status").val() == '0' && $(this).val() != 'unsold' ) {//미승인시

				openDialogAlert("'미승인' 상품이며, 먼저 '승인' 처리해 주세요.",400,150,function(){},'');
				$(this).find("option[value='unsold']").attr("selected",true);
			}
		});
		chk_runout_type();
		chk_runout_policy();
	});


	function all_runout_type(obj){
		chk_runout_type();
		chk_runout_policy();

		return true;
	}
</script>
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

<div class="clearbox">
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
	<colgroup>
		<col width="30" /><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="100" /><!--입점--><?php }?>
		<col width="60" /><!--상품이미지-->
		<col  /><!--상품명-->
<?php if(serviceLimit('H_AD')){?><col width="110" /><!--승인/미승인--><?php }?>
		<col width="110" /><!--노출/미노출-->
		<col width="130" /><!--상태-->
		<col width="140" /><!--재고에따른판매여부-->
		<col width="100" /><!--성인-->
		<col width="100" /><!--해외구매대행-->
		<col width="250" /><!--청약철회-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th></th>
<?php if(serviceLimit('H_AD')){?><th></th><?php }?>
		<th colspan="2"></th>
<?php if(serviceLimit('H_AD')){?>
		<th>
			<select name="all_provider_status" class="all_provider_status_value line" style="width:55%;" apply_target="provider_status" apply_text="승인/미승인">
			<option value="1">승인</option>
			<option value="0">미승인</option>
			</select><span class="btn small gray ml3"><button type="button" class="applyAllBtn" id="btn_all_provider_status" apply_type='all_provider_status'>▼</button></span>
		</th>
<?php }?>
		<th>
			<select name="all_goods_view" class="all_goods_view_value line" apply_target="goods_view" apply_text="노출/미노출" style="width:55%;">
			<option value="look">노출</option>
			<option value="notLook">미노출</option>
			</select><span class="btn small gray ml3"><button type="button" class="applyAllBtn" id="btn_all_goods_view" apply_type='all_goods_view'>▼</button></span>
			<div class="mt3 desc">('수동' 상품만 적용)</div>
		</th>
		<th>
			<select name="all_goods_status" class="all_goods_status_value line" apply_target="goods_status" apply_text="상품상태" style="width:65%;">
			<option value="normal_runout">정상/품절</option>
			<option value="purchasing">재고확보중</option>
			<option value="unsold">판매중지</option>
			</select><span class="btn small gray ml3"><button type="button" class="applyAllBtn" id="btn_all_goods_status" apply_type='all_goods_status'>▼</button></span>
		</th>
		<th>
			<div class="left" style="margin:3px;">
				<!--재고연동판매-->
				<select name="all_runout_type" class="all_runout_type_value runout_type line" apply_target="runout_type" apply_text="재고정책" style="width:95px;">
					<option value='shop'>통합정책</option>
					<option value='goods'>개별정책</option>
				</select><span class="btn small gray ml3"><button type="button" class="applyAllBtn" id="btn_all_runout_type" apply_type='all_runout_type' done_function="all_runout_type()">▼</button></span>
				<div class="runout_span mt2">
					<select name="all_runout_policy" class="all_runout_type_value runout_policy line" apply_target="runout_policy" apply_text="재고연동" style="width:83px;">
						<option value='stock'>재고연동</option>
						<option value='ableStock'>가용재고연동</option>
						<option value='unlimited'>재고무관</option>
					</select>
					<input type="text" size="4" name="all_able_stock_limit" class="all_runout_type_value" apply_target="able_stock_limit" apply_text="재고연동 수량" style="text-align:right" value="0" />
				</div>
				<div class="runout_span2 pd3 desc">
<?php if($TPL_VAR["config_runout"]=="stock"){?>
					재고가 1 이상일 때 판매
<?php }elseif($TPL_VAR["config_runout"]=="ableStock"){?>
					가용재고가 <?php echo $TPL_VAR["config_ableStockLimit"]?> 이상일 때 판매
<?php }else{?> 재고와 상관없이 판매
<?php }?>
				</div>
			</div>
		</th>
		<th>
			<select name="all_adult_goods" class="all_adult_goods_value line" apply_target="adult_goods" apply_text="성인" style="width:55%;">
				<option value="N">일반</option>
				<option value="Y">성인</option>
			</select><span class="btn small gray ml3"><button type="button" class="applyAllBtn" id="btn_all_adult_goods" apply_type='all_adult_goods'>▼</button></span>
		</th>
		<th>
			<select name="all_option_international_shipping_status" class="all_option_international_shipping_status_value line"  apply_target="option_international_shipping_status" apply_text="해외구매대행" style="width:55%;">
				<option value="N">일반</option>
				<option value="Y">구매대행</option>
			</select><span class="btn small gray ml3"><button type="button" class="applyAllBtn"  apply_type='all_option_international_shipping_status'>▼</button></span>
		</th>
		<th>
			<select name="all_cancel_type" class="all_cancel_type_value line" apply_target="cancel_type" apply_text="청약철회" style="width:65%;">
				<option value="1">청약철회불가</option>
				<option value="0">청약철회가능</option>
			</select><span class="btn small gray ml3"><button type="button" class="applyAllBtn"  apply_type='all_cancel_type'>▼</button></span>
		</th>
	</tr>
	</thead>
</table>
<br style="line-height:2px;" />
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="30" /><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="100" /><!--입점--><?php }?>
		<col width="55" /><!--상품이미지-->
		<col  /><!--상품명-->
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
		<tr class="list-row" style="height:70px;" goods_seq='<?php echo $TPL_V1["goods_seq"]?>'>
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
			<td align="center">
				<select name="provider_status[<?php echo $TPL_V1["goods_seq"]?>]" class="provider_status line" apply_type="provider_status_<?php echo $TPL_V1["goods_seq"]?>">
					<option value="1" <?php if($TPL_V1["provider_status"]=='1'){?>selected<?php }?>>승인</option>
					<option value="0" <?php if($TPL_V1["provider_status"]=='0'||$TPL_V1["provider_status"]==''){?>selected<?php }?>>미승인</option>
				</select>
				<input type="hidden" name="option_seq[<?php echo $TPL_V1["option_seq"]?>]" value="<?php echo $TPL_V1["goods_seq"]?>" />
			</td>
<?php }?>
			<!-- 노출/미노출 -->
			<td align="center">
<?php if($TPL_V1["display_terms"]=='AUTO'){?>
				<span class="click-lay display-terms-<?php echo $TPL_V1["goods_seq"]?>" style="color:#ff9900 !important;" onclick="openGoodsDisplayTerms('<?php echo $TPL_V1["goods_seq"]?>');">자동노출</span>
<?php }?>
				<span class="display-goods-view-<?php echo $TPL_V1["goods_seq"]?> <?php if($TPL_V1["display_terms"]=='AUTO'){?>hide<?php }?>">
					<select name="goods_view[<?php echo $TPL_V1["goods_seq"]?>]" class="goods_view line" apply_type="goods_view<?php echo $TPL_V1["goods_seq"]?>">
						<option value="look" <?php if($TPL_V1["goods_view"]=='look'){?>selected<?php }?>>노출</option>
						<option value="notLook" <?php if($TPL_V1["goods_view"]!='look'){?>selected<?php }?>>미노출</option>
					</select>
				</span>
			</td>
			<!-- 상태 -->
			<td align="center">
				<div class="goods_status_text desc"><?php echo $TPL_V1["goods_status_text"]?></div>
				<div class="mt3">
				<select name="goods_status[<?php echo $TPL_V1["goods_seq"]?>]" class="goods_status line" apply_type="goods_status<?php echo $TPL_V1["goods_seq"]?>">
					<option value="normal_runout" <?php if($TPL_V1["goods_status"]=='normal'||$TPL_V1["goods_status"]=='runout'){?>selected<?php }?>>정상/품절</option>
					<option value="purchasing" <?php if($TPL_V1["goods_status"]=='purchasing'){?>selected<?php }?>>재고확보중</option>
					<option value="unsold" <?php if($TPL_V1["goods_status"]=='unsold'){?>selected<?php }?>>판매중지</option>
				</select>
				</div>
			</td>

			<!-- 재고에따른판매여부 -->
			<td align="left" class="option_td pdl5">
				<select name="runout_type[<?php echo $TPL_V1["goods_seq"]?>]" class="runout_type line" style="width:80px;" apply_type="runout_type_<?php echo $TPL_V1["goods_seq"]?>">
					<option value='shop' <?php if(!$TPL_V1["runout_policy"]){?> selected<?php }?> >통합정책</option>
					<option value='goods' <?php if($TPL_V1["runout_policy"]){?> selected<?php }?> >개별정책</option>
				</select>
				<div></div><!--삭제금지-->
				<div class="runout_span mt2">
					<select name="runout_policy[<?php echo $TPL_V1["goods_seq"]?>]" class="runout_policy line" style="width:80px;" apply_type="runout_policy<?php echo $TPL_V1["goods_seq"]?>">
						<option value='stock' <?php if($TPL_V1["runout_policy"]=='stock'){?> selected<?php }?> >재고연동</option>
						<option value='ableStock' <?php if($TPL_V1["runout_policy"]=='ableStock'){?> selected<?php }?> >가용재고연동</option>
						<option value='unlimited' <?php if($TPL_V1["runout_policy"]=='unlimited'){?> selected<?php }?> >재고무관</option>
					</select>
					<input type="text" size="4" name="able_stock_limit[<?php echo $TPL_V1["goods_seq"]?>]" style="text-align:right" value="<?php echo $TPL_V1["able_stock_limit"]?>" class="able_stock_limit onlynumber" apply_type="able_stock_limit<?php echo $TPL_V1["goods_seq"]?>" />
				</div>
			</td>

			<!--성인-->
			<td align="center">
				<select name="adult_goods[<?php echo $TPL_V1["goods_seq"]?>]" class="adult_goods line" apply_type="adult_goods<?php echo $TPL_V1["goods_seq"]?>"v>
					<option value="N" <?php if($TPL_V1["adult_goods"]=="N"){?>selected<?php }?>>일반</option>
					<option value="Y" <?php if($TPL_V1["adult_goods"]=="Y"){?>selected<?php }?>>성인</option>
				</select>
			</td>

			<!--해외구매대행-->
			<td align="center">
				<select name="option_international_shipping_status[<?php echo $TPL_V1["goods_seq"]?>]" class="option_international_shipping_status line" apply_type="option_international_shipping_status<?php echo $TPL_V1["goods_seq"]?>">
					<option value="N" <?php if($TPL_V1["option_international_shipping_status"]=="n"){?>selected<?php }?>>일반</option>
					<option value="Y" <?php if($TPL_V1["option_international_shipping_status"]=="y"){?>selected<?php }?>>구매대행</option>
				</select>
			</td>

			<!--청약철회-->
			<td align="center">
				<select name="cancel_type[<?php echo $TPL_V1["goods_seq"]?>]" class="cancel_type line" apply_type="cancel_type<?php echo $TPL_V1["goods_seq"]?>">
					<option value="1" <?php if($TPL_V1["cancel_type"]=="1"){?>selected<?php }?>>청약철회불가</option>
					<option value="0" <?php if($TPL_V1["cancel_type"]!="1"){?>selected<?php }?>>청약철회가능</option>
				</select>
			</td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" colspan="11">
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
		<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" type="button" id="btn_normal_gname"><span class="ui-button-text">품절⇒정상<br/>변경 상품</span></button>
		<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" type="button" id="btn_runout_gname"><span class="ui-button-text">정상⇒품절<br/>변경 상품</span></button>
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