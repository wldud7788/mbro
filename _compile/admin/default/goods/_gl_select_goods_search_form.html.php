<?php /* Template_ 2.2.6 2022/05/18 16:17:42 /www/music_brother_firstmall_kr/admin/skin/default/goods/_gl_select_goods_search_form.html 000020914 */ 
$TPL_eventData_1=empty($TPL_VAR["eventData"])||!is_array($TPL_VAR["eventData"])?0:count($TPL_VAR["eventData"]);
$TPL_giftData_1=empty($TPL_VAR["giftData"])||!is_array($TPL_VAR["giftData"])?0:count($TPL_VAR["giftData"]);
$TPL_auto_orders_1=empty($TPL_VAR["auto_orders"])||!is_array($TPL_VAR["auto_orders"])?0:count($TPL_VAR["auto_orders"]);
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);?>
<script type="text/javascript">
$(function(){

<?php if($TPL_VAR["sc"]["criteria"]){?>
	var criteria = "<?php echo $TPL_VAR["sc"]["criteria"]?>".split(",");
	if(criteria=="") return;
	for(var i=0;i<criteria.length;i++){
		var div = criteria[i].split("=");
		var name = div[0];
		var value = decodeURIComponent(div[1]);

		var obj = $(".search_container>form *[name='"+name+"']");
		if(obj.length){
			if(obj[0].tagName.toUpperCase()=='INPUT' && (obj.attr('type')=='checkbox' || obj.attr('type')=='radio')){
				$(".search_container>form input[name='"+name+"'][value='"+value+"']").attr("checked",true);
			}else if(obj[0].tagName=='SELECT'){
				obj.val(value).attr("defaultValue",value);
			}else{
				obj.val(value);
			}
		}
	}
<?php }else{?>
		//$(".search_container>form input[name='selectGoodsStatus[]']").eq(0).attr("checked",true);
<?php }?>


	/* 카테고리 불러오기 */
		category_admin_select_load('','selectCategory1','',function(){
<?php if($TPL_VAR["sc"]["selectCategory1"]){?>
			$("select[name='selectCategory1']").val('<?php echo $TPL_VAR["sc"]["selectCategory1"]?>').change();
<?php }?>
		});
		$("div#<?php echo $TPL_VAR["sc"]["displayId"]?> select[name='selectCategory1']").on("change",function(){
			category_admin_select_load('selectCategory1','selectCategory2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectCategory2"]){?>
				$("select[name='selectCategory2']").val('<?php echo $TPL_VAR["sc"]["selectCategory2"]?>').change();
<?php }?>
			});
			category_admin_select_load('selectCategory2','selectCategory3',"");
			category_admin_select_load('selectCategory3','selectCategory4',"");
		});
		$("div#<?php echo $TPL_VAR["sc"]["displayId"]?> select[name='selectCategory2']").on("change",function(){
			category_admin_select_load('selectCategory2','selectCategory3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectCategory3"]){?>
				$("select[name='selectCategory3']").val('<?php echo $TPL_VAR["sc"]["selectCategory3"]?>').change();
<?php }?>
			});
			category_admin_select_load('selectCategory3','selectCategory4',"");
		});
		$("div#<?php echo $TPL_VAR["sc"]["displayId"]?> select[name='selectCategory3']").on("change",function(){
			category_admin_select_load('selectCategory3','selectCategory4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectCategory4"]){?>
				$("select[name='selectCategory4']").val('<?php echo $TPL_VAR["sc"]["selectCategory4"]?>').change();
<?php }?>
			});
		});

	/* 브랜드 불러오기 */
		brand_admin_select_load('','selectBrand1','',function(){
<?php if($TPL_VAR["sc"]["selectBrand1"]){?>
			$("select[name='selectBrand1']").val('<?php echo $TPL_VAR["sc"]["selectBrand1"]?>').change();
<?php }?>
		});
		$("select[name='selectBrand1']").on("change",function(){
			brand_admin_select_load('selectBrand1','selectBrand2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectBrand2"]){?>
				$("select[name='selectBrand2']").val('<?php echo $TPL_VAR["sc"]["selectBrand2"]?>').change();
<?php }?>
			});
			brand_admin_select_load('selectBrand2','selectBrand3',"");
			brand_admin_select_load('selectBrand3','selectBrand4',"");
		});
		$("select[name='selectBrand2']").on("change",function(){
			brand_admin_select_load('selectBrand2','selectBrand3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectBrand3"]){?>
				$("select[name='selectBrand3']").val('<?php echo $TPL_VAR["sc"]["selectBrand3"]?>').change();
<?php }?>
			});
			brand_admin_select_load('selectBrand3','selectBrand4',"");
		});
		$("select[name='selectBrand3']").on("change",function(){
			brand_admin_select_load('selectBrand3','selectBrand4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectBrand4"]){?>
				$("select[name='selectBrand4']").val('<?php echo $TPL_VAR["sc"]["selectBrand4"]?>').change();
<?php }?>
			});
		});

	/* 지역 불러오기 */
		location_admin_select_load('','selectLocation1','',function(){
<?php if($TPL_VAR["sc"]["selectLocation1"]){?>
			$("select[name='selectLocation1']").val('<?php echo $TPL_VAR["sc"]["selectLocation1"]?>').change();
<?php }?>
		});
		$("select[name='selectLocation1']").on("change",function(){
			location_admin_select_load('selectLocation1','selectLocation2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectLocation2"]){?>
				$("select[name='selectLocation2']").val('<?php echo $TPL_VAR["sc"]["selectLocation2"]?>').change();
<?php }?>
			});
			location_admin_select_load('selectLocation2','selectLocation3',"");
			location_admin_select_load('selectLocation3','selectLocation4',"");
		});
		$("select[name='selectLocation2']").on("change",function(){
			location_admin_select_load('selectLocation2','selectLocation3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectLocation3"]){?>
				$("select[name='selectLocation3']").val('<?php echo $TPL_VAR["sc"]["selectLocation3"]?>').change();
<?php }?>
			});
			location_admin_select_load('selectLocation3','selectLocation4',"");
		});
		$("select[name='selectLocation3']").on("change",function(){
			location_admin_select_load('selectLocation3','selectLocation4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectLocation4"]){?>
				$("select[name='selectLocation4']").val('<?php echo $TPL_VAR["sc"]["selectLocation4"]?>').change();
<?php }?>
			});
		});


	/* 이벤트 선택 */
	$("div#<?php echo $TPL_VAR["sc"]["displayId"]?> select[name='selectEvent']").on("change",function(){
		event_admin_select_load('selectEvent','selectEventBenefits',$(this).val());
	}).change();

	/* 이벤트 검색폼 활성화 */
	var regExp = /^(.*)\/event[0-9]{7}\.html$/;
	if(regExp.test($("input[name='template_path']").val())){
		$(".searchFormItemEvent").show();
		$(".searchFormItemGift").hide();
		$(".searchFormItemNormal").hide();
	}

	/* GIFT 이벤트 검색폼 활성화 */
	var regExp = /^(.*)\/gift[0-9]{7}\.html$/;
	if(regExp.test($("input[name='template_path']").val())){
		$(".searchFormItemGift").show();
		$(".searchFormItemEvent").hide();
		$(".searchFormItemNormal").hide();
	}
	addSelectDateEvent();
});

</script>

<div class="search_container">
<form name="selectGoodsFrm" id="selectGoodsFrm" method="get" onSubmit="return false">
<input type="hidden" name="goods_review" 	value="<?php echo $TPL_VAR["sc"]["goods_review"]?>" 	cannotBeReset=1 />
<input type="hidden" name="type" 			value="<?php echo $TPL_VAR["sc"]["type"]?>" 			cannotBeReset=1 />
<input type="hidden" name="displayId" 		value="<?php echo $TPL_VAR["sc"]["displayId"]?>" 		cannotBeReset=1 />
<input type="hidden" name="page" 			value="<?php echo $TPL_VAR["sc"]["page"]?>" 			id="getpage" />
<input type="hidden" name="perpage" 		value="<?php echo $TPL_VAR["sc"]["perpage"]?>" />
<input type="hidden" name="select_goods" 	value="<?php echo $TPL_VAR["select_goods"]?>"  	cannotBeReset=1 >
<input type="hidden" name="select_providers" value="<?php echo $TPL_VAR["sc"]["select_providers"]?>"  cannotBeReset=1 >
<?php if($TPL_VAR["sc"]["sellerAdminMode"]){?>
<input type='hidden' name='provider_seq' value='<?php echo $TPL_VAR["provider"]["provider_seq"]?>' cannotBeReset=1 />
<?php }?>
<?php if($TPL_VAR["sc"]["relation_goods_seq"]){?>
<!-- 상품의 대표 카테고리,브랜드,지역 가져와서 관련상품출력할때 사용-->
<input type="hidden" name="relation_goods_seq" value="<?php echo $TPL_VAR["sc"]["relation_goods_seq"]?>"  cannotBeReset=1 />
<?php }?>
	<table class="table_search">
	<tr>
		<th>검색어</th>
		<td colspan="3">
			<select name="selectSearchField">
				<option value="all">전체</option>
				<option value="goods_name">상품명</option>
				<option value="goods_code">상품코드</option>
			</select>
			<input type="text" name="selectKeyword" value="<?php echo htmlspecialchars($TPL_VAR["sc"]["selectKeyword"])?>" title="상품명(매입상품명), 상품코드" size="80" />
		</td>
	</tr>
	<tr>
		<th>날짜</th>
		<td colspan="3">
			<div class="date_range_form">
				<select class="line" name="selectdateGb" style="width:100px;">
					<option value="regist_date" <?php if($TPL_VAR["sc"]["selectdateGb"]=="regist_date"){?>selected<?php }?>>등록일</option>
					<option value="update_date" <?php if($TPL_VAR["sc"]["selectdateGb"]=="update_date"){?>selected<?php }?>>수정일</option>
				</select>				
				<input type="text" name="selectSdate" value="<?php echo $TPL_VAR["sc"]["selectSdate"]?>" class="datepicker sdate" maxlength="10"/>
				-
				<input type="text" name="selectEdate" value="<?php echo $TPL_VAR["sc"]["selectEdate"]?>" class="datepicker edate" maxlength="10" />

				<div class="resp_btn_wrap">
					<input type="button" range="today" value="오늘" class="select_date resp_btn" />
					<input type="button" range="3day" value="3일간" class="select_date resp_btn" />
					<input type="button" range="1week" value="일주일" class="select_date resp_btn" />
					<input type="button" range="1month" value="1개월" class="select_date resp_btn" />
					<input type="button" range="3month" value="3개월" class="select_date resp_btn" />
					<input type="button" range="all"  value="전체" class="select_date resp_btn"/>
					<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden" />
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<th>구분</th>
		<td colspan="3">
			<div class="resp_radio">
				<label><input type="radio" name="selectGoodsKind" value="all" <?php if(!$TPL_VAR["sc"]["selectGoodsKind"]||$TPL_VAR["sc"]["selectGoodsKind"]=='all'){?>checked<?php }?> /> 전체</label>
				<label><input type="radio" name="selectGoodsKind" value="goods" <?php if($TPL_VAR["sc"]["selectGoodsKind"]=='goods'){?>checked<?php }?> /> 일반 상품</label>
				<label><input type="radio" name="selectGoodsKind" value="package" <?php if($TPL_VAR["sc"]["selectGoodsKind"]=='package'){?>checked<?php }?> /> 패키지 상품</label>
<?php if(!serviceLimit('H_FR')){?>
				<label><input type="radio" name="selectGoodsKind" value="coupon" <?php if($TPL_VAR["sc"]["selectGoodsKind"]=='coupon'){?>checked<?php }?> /> 티켓 상품</label>
<?php }?>
			</div>
		</td>
	<tr>
		<th>카테고리</th>
		<td colspan="3">
			<select name="selectCategory1" <?php if($TPL_VAR["sc"]["displayKind"]=='category'&&$TPL_VAR["sc"]["type"]=='criteria'){?>disabled<?php }?>><option value="">1차 카테고리</option></select>
			<select name="selectCategory2" <?php if($TPL_VAR["sc"]["displayKind"]=='category'&&$TPL_VAR["sc"]["type"]=='criteria'){?>disabled<?php }?>><option value="">2차 카테고리</option></select>
			<select name="selectCategory3" <?php if($TPL_VAR["sc"]["displayKind"]=='category'&&$TPL_VAR["sc"]["type"]=='criteria'){?>disabled<?php }?>><option value="">3차 카테고리</option></select>
			<select name="selectCategory4"<?php if($TPL_VAR["sc"]["displayKind"]=='category'&&$TPL_VAR["sc"]["type"]=='criteria'){?>disabled<?php }?>><option value="">4차 카테고리</option></select>
		</td>
	</tr>
	<tr>
		<th>브랜드</th>
		<td colspan="3">
			<select name="selectBrand1" <?php if($TPL_VAR["sc"]["displayKind"]=='brand'&&$TPL_VAR["sc"]["type"]=='criteria'){?>disabled<?php }?>><option value="">1차 브랜드</option></select>
			<select name="selectBrand2" <?php if($TPL_VAR["sc"]["displayKind"]=='brand'&&$TPL_VAR["sc"]["type"]=='criteria'){?>disabled<?php }?>><option value="">2차 브랜드</option></select>
			<select name="selectBrand3" <?php if($TPL_VAR["sc"]["displayKind"]=='brand'&&$TPL_VAR["sc"]["type"]=='criteria'){?>disabled<?php }?>><option value="">3차 브랜드</option></select>
			<select name="selectBrand4" <?php if($TPL_VAR["sc"]["displayKind"]=='brand'&&$TPL_VAR["sc"]["type"]=='criteria'){?>disabled<?php }?>><option value="">4차 브랜드</option></select>
		</td>
	</tr>
	<tr>
		<th>지역</th>
		<td colspan="3">
			<select name="selectLocation1" <?php if($TPL_VAR["sc"]["displayKind"]=='location'&&$TPL_VAR["sc"]["type"]=='criteria'){?>disabled<?php }?>><option value="">1차 지역</option></select>
			<select name="selectLocation2" <?php if($TPL_VAR["sc"]["displayKind"]=='location'&&$TPL_VAR["sc"]["type"]=='criteria'){?>disabled<?php }?>><option value="">2차 지역</option></select>
			<select name="selectLocation3" <?php if($TPL_VAR["sc"]["displayKind"]=='location'&&$TPL_VAR["sc"]["type"]=='criteria'){?>disabled<?php }?>><option value="">3차 지역</option></select>
			<select name="selectLocation4" <?php if($TPL_VAR["sc"]["displayKind"]=='location'&&$TPL_VAR["sc"]["type"]=='criteria'){?>disabled<?php }?>><option value="">4차 지역</option></select>
		</td>
	</tr>
	<tr>
		<th>상태</th>
		<td>
			<div class="resp_checkbox">
				<label><input type="checkbox" name="selectGoodsStatus[]" value="normal" <?php if($TPL_VAR["sc"]["selectGoodsStatus"][ 0]=='normal'){?>checked<?php }?> /> 정상</label>
				<label><input type="checkbox" name="selectGoodsStatus[]" value="runout" <?php if($TPL_VAR["sc"]["selectGoodsStatus"][ 1]=='runout'){?>checked<?php }?>  /> 품절</label>
				<label><input type="checkbox" name="selectGoodsStatus[]" value="purchasing" <?php if($TPL_VAR["sc"]["selectGoodsStatus"][ 2]=='purchasing'){?>checked<?php }?>  /> 재고확보중</label>
				<label><input type="checkbox" name="selectGoodsStatus[]" value="unsold" <?php if($TPL_VAR["sc"]["selectGoodsStatus"][ 3]=='unsold'){?>checked<?php }?>  /> 판매중지</label>
			</div>
		</td>
		<th class="th120">노출 여부</th>
		<td>
			<div class="resp_radio">
				<label><input type="radio" name="selectGoodsView" value="" <?php if(!$TPL_VAR["sc"]["selectGoodsView"]){?>checked<?php }?> /> 전체</label>
				<label><input type="radio" name="selectGoodsView" value="look" <?php if($TPL_VAR["sc"]["selectGoodsView"]=="look"){?>checked<?php }?> /> 노출</label>
				<label><input type="radio" name="selectGoodsView" value="notLook" <?php if($TPL_VAR["sc"]["selectGoodsView"]=="notLook"){?>checked<?php }?> /> 미노출</label>
			</div>
		</td>
	</tr>
	<tr>
		<th>설명영역 동영상</th>
		<td>
			<label class="resp_checkbox"><input type="checkbox" name="videototal" value="1" <?php if($TPL_VAR["sc"]["videototal"]=="1"){?>checked<?php }?> /> 있음</label>
		</td>		
		<th>이미지영역 동영상</th>
		<td>
			<label class="resp_checkbox"><input type="checkbox" name="file_key_w" value="1" <?php if($TPL_VAR["sc"]["file_key_w"]){?>checked="checked"<?php }?> /> 있음</label>
			<select name="video_use" class="video_use ml10">
				<option value=""  <?php if(!$TPL_VAR["sc"]["video_use"]){?>selected<?php }?> >전체</option>
				<option value="Y" <?php if('Y'==$TPL_VAR["sc"]["video_use"]){?>selected<?php }?> >노출</option>
				<option value="N" <?php if('N'==$TPL_VAR["sc"]["video_use"]){?>selected<?php }?>>미노출</option>
			</select>
		</td>
	</tr>	
	<tr>
		<th>할인이벤트</th>
		<td <?php if(serviceLimit('H_FR')){?>colspan='3'<?php }?>>			
			<select name="selectEvent">
				<option value="">이벤트 선택</option>
<?php if($TPL_eventData_1){foreach($TPL_VAR["eventData"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["event_seq"]?>" <?php if($TPL_V1["event_seq"]==$TPL_VAR["sc"]["selectEvent"]){?>selected<?php }?> >[<?php echo $TPL_V1["status"]?>] <?php echo $TPL_V1["title"]?></option>
<?php }}?>
			</select>
			<select name="selectEventBenefits"  class="hide"></select>
		</td>
<?php if(!serviceLimit('H_FR')){?>
		<th>사은품이벤트</th>
		<td>			
			<select name="selectGift">
				<option value="">이벤트 선택</option>
<?php if($TPL_giftData_1){foreach($TPL_VAR["giftData"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["gift_seq"]?>" <?php if($TPL_V1["gift_seq"]==$TPL_VAR["sc"]["selectGift"]){?>selected<?php }?> >[<?php echo $TPL_V1["status"]?>] <?php echo $TPL_V1["title"]?></option>
<?php }}?>
			</select>
		</td>
<?php }?>
	</tr>
	<tr>		
		<th>판매가격</th>
		<td colspan="3">
			<input type="text" name="selectStartPrice" size="6" value="<?php echo $TPL_VAR["sc"]["selectStartPrice"]?>" class="onlynumber"  /> 원 부터 ~
			<input type="text" name="selectEndPrice" size="6" value="<?php echo $TPL_VAR["sc"]["selectEndPrice"]?>" class="onlynumber"  /> 원 까지
		</td>
	</tr>
<?php if($TPL_VAR["sc"]["type"]=='criteria'){?>
	<tr>
		<th>자동노출 정렬</th>
		<td>
<?php if($TPL_auto_orders_1){$TPL_I1=-1;foreach($TPL_VAR["auto_orders"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
	 		<div>
	 			<label><input type="radio" name="auto_order" value="<?php echo $TPL_K1?>" title="<?php echo $TPL_V1?>" <?php if($TPL_I1== 0){?>checked="checked"<?php }?> /><?php echo $TPL_V1?></label>&nbsp;&nbsp;
	 		</div>
<?php }}?>
		</td>
		<th>자동노출 검색기간</th>
		<td>
			<label><input type="radio" name="auto_term_type" value="relative" checked="checked" /> 최근  </label>
			<input type="text" name="auto_term" value="<?php if($TPL_VAR["data"]["auto_term"]==null){?>30<?php }else{?><?php echo $TPL_VAR["data"]["auto_term"]?><?php }?>" size="3" maxlength="4" class="onlynumber" />일
			<br />
			<label><input type="radio" name="auto_term_type" value="absolute" /> 고정 </label><input type="text" name="auto_start_date" value="<?php if($TPL_VAR["data"]["auto_start_date"]!='0000-00-00'){?><?php echo $TPL_VAR["data"]["auto_start_date"]?><?php }?>" size="7" maxlength="8" class="datepicker" style="font-size:11px !important" /> ~ <input type="text" name="auto_end_date" value="<?php if($TPL_VAR["data"]["auto_end_date"]!='0000-00-00'){?><?php echo $TPL_VAR["data"]["auto_end_date"]?><?php }?>" size="7" maxlength="8" class="datepicker" style="font-size:11px !important" />
		</td>
	</tr>
<?php }?>
<?php if(serviceLimit('H_AD')&&!$TPL_VAR["sc"]["sellerAdminMode"]){?>
	<tr>
		<th>입점판매자</th>
		<td colspan="3">
			<select name="provider_seq">
<?php if(count($TPL_VAR["provider"])> 1){?>
				<option value="0">- 입점사 검색 -</option>
<?php }?>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["provider_seq"]?>" <?php if($TPL_VAR["sc"]["provider_seq"]==$TPL_V1["provider_seq"]){?>selected<?php }?> ><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }}?>
			</select>
		</td>
	</tr>
<?php }?>
	</table>

<?php if($TPL_VAR["sc"]["type"]=='criteria'){?>
	<div class="pdt10 center">
		<div class="pdb10 center desc">
			등록된 상품갯수가 약3,000개 이상일 경우 [상품노출 자동방식]은 해당 페이지의 로딩속도가 느려지게 됩니다.<br />
			그러므로 상품갯수가 많을 경우 상품을 선택하여 노출하는 [상품노출 수동방식]을 권장 드립니다.
		</div>
<?php if($TPL_VAR["sc"]["autoSelectOnly"]!='Y'){?>
		<span class="btn medium cyanblue"><button type="button" id="selectCriteriaSearchButton">↑ 위 자동 조건에 만족하는 상품을 추출하여 수동 상품노출에 넣기</button></span>
		또는
<?php }?>
		<span class="btn medium cyanblue"><button type="button" id="selectCriteriaButton">↑ 위 자동 조건으로 상품노출 하기</button></span>

	</div>

	<div class="pdt10 center desc">
		또는<br />
		앞으로 업그레이드된 자동 선정 조건을 사용하여 자동 노출 하실 수 있습니다.<br />
		단, (구) 자동 선정 기능은 더 이상 사용할 수 없습니다.<br /><br />
		<span class="btn medium cyanblue"><button type="button" id="selectUpgradeButton">업그레이드된 자동 선정 사용하기</button></span>
	</div>
	<div class="hide" id="upgradeConfirm">
		<div class="center">
			업그레이드된 자동 선정하기를 사용하실 경우<br/>
			(구)자동 선정 기능은 더이상 사용 할 수 없습니다.<br /><br />
			<span class="btn medium cyanblue"><button type="button" onclick="check_new_select();">사용</button></span>
			<span class="btn medium cyanblue"><button type="button" onclick="$('#upgradeConfirm').dialog('close');">취소</button></span>
		</div>
	</div>
<?php }else{?>
	<div class="footer search_btn_lay"></div>
<?php }?>
</form>
</div>
<div class="cboth"></div>