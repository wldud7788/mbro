<?php /* Template_ 2.2.6 2022/05/17 12:31:56 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_goodsetc.html 000017555 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".btn-direct-open").on('changeOptionLay', function(){
			var goods_seq	= $(this).attr('goods_seq');

			if ($(this).hasClass('opened') === false) {
				//닫기
				$('#option_' + goods_seq).find("[defalult_option='y']").each(function(){
					var targetName	= this.name.replace(/^detail_/, '');
					$('[name="' + targetName + '"]').val(this.value);
				});
			}
		});

		// 기본코드 자동생성
		$("#btn_all_code").on("click", function(){
			var chk_flag = true;
			$("input[name='goods_seq[]']").each(function(){
				if($(this).is(":checked")){
					chk_flag		= false;
					var trObj		= $(this).closest(".list-row")
					var goods_seq	= trObj.attr("goods_seq");
					if($(this).val() == goods_seq){
						trObj.find(".real_code").val(trObj.find(".hidden_code").val());
					}
				}
			});
			if(chk_flag)	alert("일괄적용할 상품을 선택해 주세요.");
		});
	});
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
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="30" /><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="100" /><!--입점사--><?php }?>
		<col width="63" /><!--상품이미지-->
		<col /><!--상품명-->
		<col width="70" /><!--옵션-->
		<col width="150" /><!--상품기본코드-->
		<col width="100" /><!--무게-->
		<col width="100" /><!--재고-->
		<col width="100" /><!--불량-->
		<col width="100" /><!--안전재고-->
	</colgroup>
	<thead class="lth">
	<tr style="background-color:#e3e3e3" height="55">
		<th></th>
<?php if(serviceLimit('H_AD')){?><th></th><?php }?>
		<th colspan="2"></th>
		<th>
			<img class="btn_open_all hand" src="/admin/skin/default/images/common/icon/btn_open_all.gif" />
		</th>
		<th align="center">
			기본코드 자동생성
			<span class="btn small gray"><button type="button" id="btn_all_code">▼</button></span>
		</th>
		<th align="center">
			<input type="text" class="all_weight_value" name="all_weight" size="5" apply_target="weight">
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type="all_weight">▼</button></span>
		</th>
		<th align="center">
			<input type="text" class="all_stock_value" name="all_stock" size="5" apply_target="stock">
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type="all_stock">▼</button></span>
		</th>
		<th align="center">
			<input type="text" class="all_badstock_value" name="all_badstock" size="5" apply_target="badstock">
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type="all_badstock">▼</button></span>
		</th>
		<th align="center">
			<input type="text" class="all_safe_stock_value" name="all_safe_stock" size="5" apply_target="safe_stock">
			<span class="btn small gray"><button type="button" class="applyAllBtn" apply_type="all_safe_stock">▼</button></span>
		</th>
	</tr>
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
<?php if(serviceLimit('H_AD')){?><th>입점</th><?php }?>
		<th colspan="2">상품명</th>
		<th>옵션</th>
		<th>상품기본코드</th>
		<th>무게(Kg)</th>
		<th>재고</th>
		<th>불량</th>
		<th>안전재고</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<!-- 상품정보 : 시작 -->
		<tbody class="ltb goods_list">
			<tr class="list-row" style="height:70px;" goods_seq="<?php echo $TPL_V1["goods_seq"]?>">
				<td class="center">
					<input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" />
					<input type="hidden" name="default_option_seq[<?php echo $TPL_V1["option_seq"]?>]" value="<?php echo $TPL_V1["goods_seq"]?>" class="default_option<?php if(count($TPL_V1["options"])> 1){?> option_use<?php }?>" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"/>
				</td>
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
<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn-direct-open" goods_seq='<?php echo $TPL_V1["goods_seq"]?>'><span class="hide">열기</span></span><?php }?>
				</td>
				<td class="center"><!--// 코드 //-->
					<input type="hidden" class="hidden_code" name="tmpcode[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["tmp_goods_code"]?>" />
					<input type="text" class="real_code" name="code[<?php echo $TPL_V1["goods_seq"]?>]" size="7" value="<?php echo $TPL_V1["goods_code"]?>" option_seq='<?php echo $TPL_V1["goods_seq"]?>_<?php echo $TPL_V1["option_seq"]?>' style="text-align:right;width:80%;" class="code_<?php echo $TPL_V1["goods_seq"]?>" apply_target="code" />
				</td>
				<td class="pdl10 left"><!--// 무게 //-->
					<input type="text" name="weight[<?php echo $TPL_V1["option_seq"]?>]" size="7" value="<?php echo $TPL_V1["default_weight"]?>" style="text-align:right;" class="onlyfloat weight weight_<?php echo $TPL_V1["goods_seq"]?>_value" apply_target="weight" />

<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn"  goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='weight_<?php echo $TPL_V1["goods_seq"]?>'>▼</button></span><?php }?>
				</td>
				<td class="pdl10 left"><!--// 재고 //-->
					<input type="text" name="stock[<?php echo $TPL_V1["option_seq"]?>]" size="7" value="<?php echo $TPL_V1["default_stock"]?>" style="text-align:right;" class="onlyfloat stock stock_<?php echo $TPL_V1["goods_seq"]?>_value" apply_target="stock" <?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_V1["provider_seq"]=='1'){?>disabled<?php }?> />

<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn"  goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='stock_<?php echo $TPL_V1["goods_seq"]?>'>▼</button></span><?php }?>
				</td>
				<td class="pdl10 left"><!--// 불량 //-->
					<input type="text" name="badstock[<?php echo $TPL_V1["option_seq"]?>]" size="7" value="<?php echo $TPL_V1["default_badstock"]?>" style="text-align:right;" class="onlyfloat badstock badstock_<?php echo $TPL_V1["goods_seq"]?>_value" apply_target="badstock" <?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_V1["provider_seq"]=='1'){?>disabled<?php }?> />

<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn"  goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='badstock_<?php echo $TPL_V1["goods_seq"]?>'>▼</button></span><?php }?>
				</td>
				<td class="pdl10 left"><!--// 안전재고 //-->
					<input type="text" name="safe_stock[<?php echo $TPL_V1["option_seq"]?>]" size="7" value="<?php echo $TPL_V1["default_safe_stock"]?>" style="text-align:right;" class="onlyfloat safe_stock safe_stock_<?php echo $TPL_V1["goods_seq"]?>_value" apply_target="safe_stock" />

<?php if($TPL_V1["options"][ 0]["option_title"]){?><span class="btn small gray" style="display:none;"><button type="button" class="applyOptionsBtn"  goods_seq='<?php echo $TPL_V1["goods_seq"]?>' apply_type='safe_stock_<?php echo $TPL_V1["goods_seq"]?>'>▼</button></span><?php }?>
				</td>
			</tr>
		</tbody>
		<!-- 상품정보 : 끝 -->

		<!-- 옵션정보 : 시작 -->
<?php if($TPL_V1["options"][ 0]["option_title"]){?>
		<tbody id='option_<?php echo $TPL_V1["goods_seq"]?>' class="optionLay bg-dot-linem hide">
<?php if(is_array($TPL_R2=$TPL_V1["options"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<tr height="30" goods_seq="<?php echo $TPL_V1["goods_seq"]?>">
				<td <?php if(serviceLimit('H_AD')){?>colspan="2"<?php }?>>
					<input type="hidden" name="option_seq[<?php echo $TPL_V2["option_seq"]?>]" value="<?php echo $TPL_V1["goods_seq"]?>" disabled/>
				</td>
				<td class="right"><?php if($TPL_V2["default_option"]=='y'){?>[대표]<?php }?></td>
				<td class="pdl10" colspan="2">
					<span class="detail_default_option_select hand">
<?php if($TPL_V2["option_divide_title"][ 0]){?><?php echo $TPL_V2["option_divide_title"][ 0]?> : <?php echo $TPL_V2["option1"]?><?php }?>
<?php if($TPL_V2["option_divide_title"][ 1]){?>&nbsp;<?php echo $TPL_V2["option_divide_title"][ 1]?> : <?php echo $TPL_V2["option2"]?><?php }?>
<?php if($TPL_V2["option_divide_title"][ 2]){?>&nbsp;<?php echo $TPL_V2["option_divide_title"][ 2]?> : <?php echo $TPL_V2["option3"]?><?php }?>
<?php if($TPL_V2["option_divide_title"][ 3]){?>&nbsp;<?php echo $TPL_V2["option_divide_title"][ 3]?> : <?php echo $TPL_V2["option4"]?><?php }?>
<?php if($TPL_V2["option_divide_title"][ 4]){?>&nbsp;<?php echo $TPL_V2["option_divide_title"][ 4]?> : <?php echo $TPL_V2["option5"]?><?php }?>
					</span>
				</td>
				<td class="pdl10 left">
					<input type="text" name="detail_code1[<?php echo $TPL_V2["option_seq"]?>]" value="<?php echo $TPL_V2["optioncode1"]?><?php echo $TPL_V2["optioncode2"]?><?php echo $TPL_V2["optioncode3"]?><?php echo $TPL_V2["optioncode4"]?><?php echo $TPL_V2["optioncode5"]?>" style="text-align:right;" defalult_option="<?php echo $TPL_V2["default_option"]?>" class="optioncode" disabled />
					<input type="hidden" name="detail_code2[<?php echo $TPL_V2["option_seq"]?>]" defalult_option="<?php echo $TPL_V2["default_option"]?>" class="optioncode" disabled />
					<input type="hidden" name="detail_code3[<?php echo $TPL_V2["option_seq"]?>]" defalult_option="<?php echo $TPL_V2["default_option"]?>" class="optioncode" disabled />
					<input type="hidden" name="detail_code4[<?php echo $TPL_V2["option_seq"]?>]" defalult_option="<?php echo $TPL_V2["default_option"]?>" class="optioncode" disabled />
					<input type="hidden" name="detail_code5[<?php echo $TPL_V2["option_seq"]?>]" defalult_option="<?php echo $TPL_V2["default_option"]?>" class="optioncode" disabled />
				</td>
				<td class="pdl10 left"><!--// 무게 //-->
					<input type="text" name="detail_weight[<?php echo $TPL_V2["option_seq"]?>]" size="7" value="<?php echo $TPL_V2["weight"]?>" style="text-align:right;" defalult_option="<?php echo $TPL_V2["default_option"]?>" class="onlyfloat weight" disabled />
				</td>
				<td class="pdl10 left"><!--// 재고 //-->
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'||$TPL_V1["provider_seq"]!='1'){?>
					<input type="text" name="detail_stock[<?php echo $TPL_V2["option_seq"]?>]" size="7" value="<?php echo $TPL_V2["stock"]?>" style="text-align:right;" defalult_option="<?php echo $TPL_V2["default_option"]?>" class="onlyfloat stock" disabled />
<?php }?>
				</td>
				<td class="pdl10 left"><!--// 불량 //-->
<?php if($TPL_VAR["scm_cfg"]['use']!='Y'||$TPL_V1["provider_seq"]!='1'){?>
					<input type="text" name="detail_badstock[<?php echo $TPL_V2["option_seq"]?>]" size="7" value="<?php echo $TPL_V2["badstock"]?>" style="text-align:right;" defalult_option="<?php echo $TPL_V2["default_option"]?>" class="onlyfloat badstock" disabled />
<?php }?>
				</td>
				<td class="pdl10 left"><!--// 안전재고 //-->
					<input type="text" name="detail_safe_stock[<?php echo $TPL_V2["option_seq"]?>]" size="7" value="<?php echo $TPL_V2["safe_stock"]?>" style="text-align:right;" defalult_option="<?php echo $TPL_V2["default_option"]?>" class="onlyfloat safe_stock" disabled />
				</td>
			</tr>
<?php }}?>
		</tbody>
		<!-- 옵션정보 : 끝 -->
<?php }?>
<?php }}?>
<?php }else{?>
	<tbody class="ltb goods_list">
		<tr class="list-row">
			<td align="center" colspan="<?php if($TPL_VAR["scm_cfg"]['use']!='Y'){?>9<?php }else{?>7<?php }?>">
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