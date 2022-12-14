<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/market_connector/_order_collect.html 000003060 */ ?>
<script>
$(function(){

	setDatepicker();
	defaultDateSet('collectPop');

	if (typeof marketObj == 'object') {

		if (marketObj.hasOwnProperty('ClauseAgree') == true && marketObj.ClauseAgree == false) {
			notClauseAgree();
			return;
		}

		for(market in marketObj) {
			if (marketObj[market].hasOwnProperty('sellerList') == true) {
				var nowOption	= '';
				for (sellerCnt = marketObj[market].sellerList.length, i = 0; i < sellerCnt; i++) {
					if(market == 'shoplinker'){
						nowOption	= "<option value='" + market + "^" + marketObj[market].sellerList[i] + "'> " + marketObj[market].marketOtherList[i] + "(" + marketObj[market].sellerList[i] + ")</option>";
						$('.marketSeller').append(nowOption);							
					}else{
						nowOption	= "<option value='" + market + "^" + marketObj[market].sellerList[i] + "'> " + marketObj[market].name + "(" + marketObj[market].sellerList[i] + ")</option>";
						$('.marketSeller').append(nowOption);						
					}
				}
			}
		}

		if(typeof $('select').multipleSelect == 'function') {

			$('.marketSeller').multipleSelect({
				placeholder		: '선택',
				selectAll		: true,
				selectAllText	: '전체 선택',
				allSelected		: '전체 셀러',
				noMatchesFound	: '설정된 오픈마켓 계정이 없습니다.',
				minimumCountSelected : 100
			});
			$('select.marketSeller').multipleSelect('setSelects', []);
			
		}
	}
	
	// 수집
	$(".btnCollect").on("click",function(){
		var mode = '<?php echo $TPL_VAR["mode"]?>';
		switch(mode){
			case "CAN":
			case "RTN":
			case "EXC": getClaimCollect(); break;
			case "QNA": getQnaCollect(); break;
			default : getOrderCollect(); break;
		}
	})
	$(".btnClose").on("click",function(){
		closeDialog('orderCollection');
	})
});

</script>
<div id="orderCollection" class="">
	<table class="table_basic thl">		
		<tr>
			<th><?php echo $TPL_VAR["title"]?></th>
			<td>
				<input type="text" name="collectBeginDate" id="collectBeginDate" value="" class="datepicker sdate" maxlength="10" size="12" />
				<span class="gray" style="margin:0 5px;">-</span>
				<input type="text" name="collectEndDate" id="collectEndDate" value="" class="datepicker edate" maxlength="10" size="12" />
			</td>
		</tr>	
		<tr>
			<th>판매 마켓</th>
			<td><select name="marketSeller" id="marketSeller" class="marketSeller" style="width:240px;;"></select></td>
		</tr>
	</table>

	<div class="box_style_05 resp_message pd10">
		<div class="title">안내</div>
		<ul class="bullet_hyphen">					
			<li><?php echo $TPL_VAR["guidemsg"]?></li>	
			<li>수동 수집을 원하실 경우 [수집] 을 이용해주세요.</li>	
		</ul>
	</div>
	
	<div class="footer">
		<button type="button" class="btnCollect resp_btn active size_XL">수집</button>
		<button type="button" class="btnClose resp_btn v3 size_XL" >취소</button>
	</div>
</div>