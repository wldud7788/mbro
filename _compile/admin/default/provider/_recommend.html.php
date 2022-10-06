<?php /* Template_ 2.2.6 2022/05/17 12:36:51 /www/music_brother_firstmall_kr/admin/skin/default/provider/_recommend.html 000007769 */ 
$TPL_items_1=empty($TPL_VAR["items"])||!is_array($TPL_VAR["items"])?0:count($TPL_VAR["items"]);?>
<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/goods-display.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript">
	$(document).ready(function(){

		// 구분 변경
		$("select.tkind").change(function(){
			var kind	= $(this).closest("div.set-bigdata-lay").attr('kindName');
			$("span."+kind+"-title-text").html($(this).find('option:selected').html());
		}).change();

		// 저장
		$("button.submit-form").click(function(){
			if	(!$(this).closest('span').hasClass('btn-disable'))
				$("form#bigdataFrm").submit();
		});

		$("button.mshopCriteriaButton").live("click",function(){
			var displayResultId = $(this).attr('dp_id');
			var criteria = $("#"+displayResultId).val();
			var kind = $(this).attr('kind');
			open_criteria_condition(displayResultId,'',criteria,kind);
		});

		/* 상품 검색 버튼 */
		$("button.displayGoodsButton").live("click",function(){
			this_platform		= 'displayGoods';

			set_goods_list("displayGoodsSelect",'displayGoods','goods','');
		});
		
		// 직접선정 상품 위치 이동 스크립트 실행
		$(".displayGoods").sortable();
		$(".displayGoods").disableSelection();
		
		// 추천상품 타입 변경 시 각 타입별 영역 노출처리
		$("select.auto_criteria_type").live('change',function(){
			that = $(this).closest('th');
			type = $(this).val();
			$(this).closest('tr').find('.mshopCriteriaButton').attr('auto_type',type);
			type = type.replace('auto_sub','auto');
			$(this).closest("tr").find(".displayTabAutoTypeContainer").hide();
			$(this).closest("tr").find(".displayTabAutoTypeContainer[type='"+type+"']").show();
			if($('.m_list_use').is(':checked')){
				$('.tab_contents_mobile').hide();
			}
			setCriteriaDescription_upgrade();
		}).change();

		// 추천상품 타입에 맞는 영역 노출 처리
		var auto_type = '<?php echo strtolower($TPL_VAR["auto_criteria_type"])?>';
		auto_type = auto_type == '' ? 'auto' : auto_type;

		$(".displayTabAutoTypeContainer").hide();
		$(".displayTabAutoTypeContainer[type='"+auto_type+"']").show();
		
		// 초기 텍스트 데이터 세팅
		setCriteriaDescription_upgrade();		
	});	

	function open_criteria_condition(displayResultId,auto_condition_use_id,criteria,kind){
		openDialog("추천 상품 조건 선택", "#displayGoodsSelectPopup", {"width":"1000px","height":"600","show" : "fade","hide" : "fade"});
		set_goods_list_auto("displayGoodsSelect",displayResultId,criteria,auto_condition_use_id,kind);
	};

	function set_goods_list_auto(displayId,inputGoods,criteria,auto_condition_use_id,kind){
		$.ajax({
			type: "get",
			url: "../goods/select_auto_condition",
			data: "displayKind="+kind+"&kind=none&auto_condition_use_id="+auto_condition_use_id+"&inputGoods="+inputGoods,
			success: function(result){
				$("div#"+displayId).html(result);
			}
		});
	}

	function set_goods_list(displayId,inputGoods){
		$.ajax({
			type: "get",
			url: "../goods/select",
			data: "page=1&inputGoods="+inputGoods+"&displayId="+displayId,
			success: function(result){
				$("div#"+displayId).html(result);
			}
		});
		openDialog("상품 검색", displayId, {"width":"1000","height":"700","show" : "fade","hide" : "fade"});
	}
</script>
<div class="displayTabGoodsContainer displayTabAutoTypeContainer hide" type="auto">
	<input type="hidden" class="isBigdataTest" value="1"/>
	<button type="button" class="mshopCriteriaButton displayCriteriaType resp_btn active" dp_id='mshopCriteria' attr="responsive" kind='mshop' auto_type="auto">조건 선택</button>
	<div class="clearbox" style="height:5px;"></div>
	<input type='hidden' class="displayCriteria" id="mshopCriteria" name='auto_criteria' value="<?php echo $TPL_VAR["auto_criteria"]?>" />
	<div class="displayCriteriaDesc"></div>    
</div>
<div class="displayTabAutoTypeContainer hide" type="manual">
	<input type='hidden' name='auto_goods_seqs[]' />
	<input type="button" value="상품 선택" class="btn_select_goods resp_btn active" data-goodstype='displayGoods' />
	<span class="span_select_goods_del <?php if(count($TPL_VAR["items"])== 0){?>hide<?php }?>"><input type="button" value="선택 삭제" class="select_goods_del resp_btn v3 " selectType="goods" /></span>
	<div class="mt10 wx600 <?php if(count($TPL_VAR["items"])== 0){?>hide<?php }?>">
		<div class="goods_list_header">
			<table class="table_basic tdc">
				<colgroup>
					<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
					<col width="25%" />
					<col width="45%" />
<?php }else{?>
					<col width="70%" />
<?php }?>
					<col width="20%" />
				</colgroup>
				<tbody>
					<tr>
					<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" onClick="gGoodsSelect.checkAll(this)" value="goods"></label></th>
<?php if(serviceLimit('H_AD')){?>
					<th>입점사명</th>
<?php }?>
					<th>상품명</th>
					<th>판매가</th>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="goods_list">
			<table class="table_basic tdc">
				<colgroup>
					<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
					<col width="25%" />
					<col width="45%" />
<?php }else{?>
					<col width="70%" />
<?php }?>
					<col width="20%" />
				</colgroup>
				<tbody>
					<tr rownum=0 <?php if(count($TPL_VAR["items"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
						<td class="center" colspan="4">상품을 선택하세요</td>
					</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->
<?php if($TPL_items_1){foreach($TPL_VAR["items"] as $TPL_V1){?>
					<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
						<td><label class="resp_checkbox"><input type="checkbox" name='select_goods_list[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' /></label>
							<input type="hidden" name='displayGoods[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' />
							<input type="hidden" name="displayGoodsSeq[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["issuegoods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
							<td><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
						<td class='left'>
							<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></div>
							<div class="goodsname">
<?php if($TPL_V1["goods_code"]){?><div>[상품코드:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
								<div><a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V1["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 30)?></a></div>
							</div>
						</td>
						<td class='right'><?php echo get_currency_price($TPL_V1["price"], 2)?></td>
					</tr>
<?php }}?>
				</tbody>
			</table>
		</div>
	</div>	
</div>
<div class="displayTabAutoTypeContainer" type="text">
	<textarea name="auto_contents" style="width:100%" contentHeight="150px" class="daumeditor hide" tinyMode="1"><?php echo $TPL_VAR["auto_contents"]?></textarea><br />
</div>

<div id="displayGoodsSelectPopup">
	<div id="displayGoodsSelect"></div>
</div>