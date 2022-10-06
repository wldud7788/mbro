<?php /* Template_ 2.2.6 2022/05/17 12:31:59 /www/music_brother_firstmall_kr/admin/skin/default/goods/_gl_select_gift.html 000005929 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript">
document.addEventListener('keydown', function(event) {
  if (event.keyCode === 13) {
  //  gGiftGoodsSelect.searchGift(1);
  };
}, true);

var search_opitons = {
				'pageid':'gl_select_gift',
				'search_mode':'<?php echo $TPL_VAR["sc"]["searchmode"]?>',
				'defaultPage':0,
				'divSelectLayId':'gift_search_container',
				'searchFormId':'searchGiftFrm',
				'form_editor_use':false,
				'select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>'
				};

gSearchForm.init(search_opitons,gGiftGoodsSelect.searchGift);
</script>

<div class="content" id="gift_search_container">

	<div class="item-title">사은품 검색</div>

	<div class="search_container">

		<form name="searchGiftFrm" method="get" onSubmit="return false">
		<input type="hidden" name="inputGoods" value="<?php echo $TPL_VAR["sc"]["inputGoods"]?>"  cannotBeReset=1 />

		<table class="table_search">
			<tr>
				<th>검색어</th>
				<td>
					<input type="text" name="selectGoodsName" style="width:55%;" value="<?php echo $TPL_VAR["sc"]["selectGoodsName"]?>" class="resp_text" />
				</td>
			</tr>
			<tr>
				<th>상태</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="goodsStatus" value="" <?php echo $TPL_VAR["checked"]['goodsStatus']['all']?> />전체</label>
						<label><input type="radio" name="goodsStatus" value="normal" <?php echo $TPL_VAR["checked"]['goodsStatus']['normal']?> />정상</label>
						<label><input type="radio" name="goodsStatus" value="runout" <?php echo $TPL_VAR["checked"]['goodsStatus']['runout']?> />품절</label>
						<label><input type="radio" name="goodsStatus" value="unsold" <?php echo $TPL_VAR["checked"]['goodsStatus']['unsold']?> />판매중지</label>
					</div>
				</td>
			</tr>
			<!--<tr>
				<th>노출</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="goodsView" value="" <?php echo $TPL_VAR["checked"]['goodsView']['all']?> />전체</label>
						<label><input type="radio" name="goodsView" value="look" <?php echo $TPL_VAR["checked"]['goodsView']['look']?> />노출</label>
						<label><input type="radio" name="goodsView" value="notLook" <?php echo $TPL_VAR["checked"]['goodsView']['notLook']?> />미노출</label>
					</div>
				</td>
			</tr>-->
			<tr>
				<th>정가</th>
				<td>
					<input type="text" name="selectStartconsumerPrice" size="10" value="<?php echo $TPL_VAR["sc"]['selectStartconsumerPrice']?>" class="onlynumber resp_text"  /> 원 ~
					<input type="text" name="selectEndconsumerPrice" size="10" value="<?php echo $TPL_VAR["sc"]['selectEndconsumerPrice']?>" class="onlynumber resp_text"  /> 원
				</td>
			</tr>
		</table>

		<div class="footer search_btn_lay"></div>
	</form>
	</div>
	<div class="item-title">검색한 사은품</div>
	<table class="table_basic gift_list">
		<colgroup>
			<col width="10%" />
<?php if(isset($TPL_VAR["record"][ 0]["provider_name"])){?>
			<col width="25%" />
<?php }?>
			<col  />
		</colgroup>
		<thead>
			<tr class="nodrag nodrop">
				<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" title="전체선택" ></label></th>
<?php if(isset($TPL_VAR["record"][ 0]["provider_name"])){?>
				<th>입점사명</th>
<?php }?>
				<th>사은품명</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["record"]){?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
			<tr rownum="<?php echo $TPL_V1["goods_seq"]?>" <?php if(in_array($TPL_V1["goods_seq"],$TPL_VAR["sc"]["select_gift_goods"])){?>class='bg-gray'<?php }?>>
				<td class="center">
<?php if(!in_array($TPL_V1["goods_seq"],$TPL_VAR["sc"]["select_gift_goods"])){?>
					<label class="resp_checkbox"><input type="checkbox" name="select_goods_seq[]" class="chk" value="<?php echo $TPL_V1["goods_seq"]?>"></label>
					<input type="hidden" name="select_provider_name[]" value="<?php echo strip_tags($TPL_V1["provider_name"])?>">
					<input type="hidden" name="select_goods_name[]" value="<?php echo strip_tags($TPL_V1["goods_name"])?>" goodsstrcut="{=getstrcut(strip_tags(.goods_name)),params.goods_name_strcut)}">
					<input type="hidden" name="select_goods_code[]" value="<?php echo $TPL_V1["goods_code"]?>">
					<input type="hidden" name="select_goods_img[]" value="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>">
<?php }?>
				</td>
<?php if(isset($TPL_V1["provider_name"])){?>
				<td class="center"><?php echo strip_tags($TPL_V1["provider_name"])?></td>
<?php }?>
				<td class="left">
					<div class="image">
						<img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" class="goodsThumbView" width="50" height="50" />
					</div>
					<div class="goodsname">
<?php if($TPL_V1["goods_code"]){?><div class="desc">[상품코드:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
						<div><a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V1["goods_seq"]?>] <?php echo htmlspecialchars($TPL_V1["goods_name"])?></a></div>
					</div>
				</td>
			</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td colspan="2" class="center">검색된 사은품이 없습니다.</td>
			</tr>
<?php }?>
		</tbody>
	</table>

	<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

</div>

<div class="footer">
	<button type="button" class="confirmSelectGift resp_btn active size_XL">선택</button>
	<button type="button" class="btnLayClose resp_btn size_XL">닫기</button>
</div>