<?php /* Template_ 2.2.6 2022/05/17 12:29:10 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/goods_search_form_select.html 000021082 */ 
$TPL_provider_1=empty($TPL_VAR["provider"])||!is_array($TPL_VAR["provider"])?0:count($TPL_VAR["provider"]);
$TPL_event_list_1=empty($TPL_VAR["event_list"])||!is_array($TPL_VAR["event_list"])?0:count($TPL_VAR["event_list"]);
$TPL_gift_list_1=empty($TPL_VAR["gift_list"])||!is_array($TPL_VAR["gift_list"])?0:count($TPL_VAR["gift_list"]);?>
<script type="text/javascript">
$(document).ready(function() {

	/* 카테고리 불러오기 */
	category_admin_select_load('','selectCategory1','',function(){
<?php if($TPL_VAR["sc"]["selectCategory1"]){?>
		$("select[name='selectCategory1']").val('<?php echo $_GET["selectCategory1"]?>').change();
<?php }?>
	});
	$("select[name='selectCategory1']").on("change",function(){
		category_admin_select_load('selectCategory1','selectCategory2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectCategory2"]){?>
			$("select[name='selectCategory2']").val('<?php echo $_GET["selectCategory2"]?>').change();
<?php }?>
		});
		category_admin_select_load('selectCategory2','selectCategory3',"");
		category_admin_select_load('selectCategory3','selectCategory4',"");
	});
	$("select[name='selectCategory2']").on("change",function(){
		category_admin_select_load('selectCategory2','selectCategory3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectCategory3"]){?>
			$("select[name='selectCategory3']").val('<?php echo $_GET["selectCategory3"]?>').change();
<?php }?>
		});
		category_admin_select_load('selectCategory3','selectCategory4',"");
	});
	$("select[name='selectCategory3']").on("change",function(){
		category_admin_select_load('selectCategory3','selectCategory4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectCategory4"]){?>
			$("select[name='selectCategory4']").val('<?php echo $_GET["selectCategory4"]?>').change();
<?php }?>
		});
	});

	$("select[name='s_selectCategory1']").on("change",function(){
		category_admin_select_load('s_selectCategory1','s_selectCategory2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectCategory2"]){?>
			$("select[name='s_selectCategory2']").val('<?php echo $_GET["selectCategory2"]?>').change();
<?php }?>
		});
		category_admin_select_load('selectCategory2','selectCategory3',"");
		category_admin_select_load('selectCategory3','selectCategory4',"");
	});
	$("select[name='s_selectCategory2']").on("change",function(){
		category_admin_select_load('s_selectCategory2','s_selectCategory3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectCategory3"]){?>
			$("select[name='s_selectCategory3']").val('<?php echo $_GET["selectCategory3"]?>').change();
<?php }?>
		});
		category_admin_select_load('s_selectCategory3','s_selectCategory4',"");
	});
	$("select[name='s_selectCategory3']").on("change",function(){
		category_admin_select_load('s_selectCategory3','s_selectCategory4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectCategory4"]){?>
			$("select[name='s_selectCategory4']").val('<?php echo $_GET["selectCategory4"]?>').change();
<?php }?>
		});
	});
	////////////////////////////

	/* 브랜드 불러오기 */
	brand_admin_select_load('','selectBrand1','',function(){
<?php if($TPL_VAR["sc"]["selectBrand1"]){?>
		$("select[name='selectBrand1']").val('<?php echo $_GET["selectBrand1"]?>').change();
<?php }?>
	});
	$("select[name='selectBrand1']").on("change",function(){
		brand_admin_select_load('selectBrand1','selectBrand2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectBrand2"]){?>
			$("select[name='selectBrand2']").val('<?php echo $_GET["selectBrand2"]?>').change();
<?php }?>
		});
		brand_admin_select_load('selectBrand2','selectBrand3',"");
		brand_admin_select_load('selectBrand3','selectBrand4',"");
	});
	$("select[name='selectBrand2']").on("change",function(){
		brand_admin_select_load('selectBrand2','selectBrand3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectBrand3"]){?>
			$("select[name='selectBrand3']").val('<?php echo $_GET["selectBrand3"]?>').change();
<?php }?>
		});
		brand_admin_select_load('selectBrand3','selectBrand4',"");
	});
	$("select[name='selectBrand3']").on("change",function(){
		brand_admin_select_load('selectBrand3','selectBrand4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectBrand4"]){?>
			$("select[name='selectBrand4']").val('<?php echo $_GET["selectBrand4"]?>').change();
<?php }?>
		});
	});
	$("select[name='s_selectBrand1']").on("change",function(){
		brand_admin_select_load('s_selectBrand1','s_selectBrand2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectBrand2"]){?>
			$("select[name='s_selectBrand2']").val('<?php echo $_GET["selectBrand2"]?>').change();
<?php }?>
		});
		brand_admin_select_load('s_selectBrand2','s_selectBrand3',"");
		brand_admin_select_load('s_selectBrand3','s_selectBrand4',"");
	});
	$("select[name='s_selectBrand2']").on("change",function(){
		brand_admin_select_load('s_selectBrand2','s_selectBrand3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectBrand3"]){?>
			$("select[name='s_selectBrand3']").val('<?php echo $_GET["selectBrand3"]?>').change();
<?php }?>
		});
		brand_admin_select_load('s_selectBrand3','s_selectBrand4',"");
	});
	$("select[name='s_selectBrand3']").on("change",function(){
		brand_admin_select_load('s_selectBrand3','s_selectBrand4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectBrand4"]){?>
			$("select[name='s_selectBrand4']").val('<?php echo $_GET["selectBrand4"]?>').change();
<?php }?>
		});
	});

	/* 지역 불러오기 */
	location_admin_select_load('','selectLocation1','',function(){
<?php if($TPL_VAR["sc"]["selectLocation1"]){?>
		$("select[name='selectLocation1']").val('<?php echo $_GET["selectLocation1"]?>').change();
<?php }?>
	});
	$("select[name='selectLocation1']").on("change",function(){
		location_admin_select_load('selectLocation1','selectLocation2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectLocation2"]){?>
			$("select[name='selectLocation2']").val('<?php echo $_GET["selectLocation2"]?>').change();
<?php }?>
		});
		location_admin_select_load('selectLocation2','selectLocation3',"");
		location_admin_select_load('selectLocation3','selectLocation4',"");
	});
	$("select[name='selectLocation2']").on("change",function(){
		location_admin_select_load('selectLocation2','selectLocation3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectLocation3"]){?>
			$("select[name='selectLocation3']").val('<?php echo $_GET["selectLocation3"]?>').change();
<?php }?>
		});
		location_admin_select_load('selectLocation3','selectLocation4',"");
	});
	$("select[name='selectLocation3']").on("change",function(){
		location_admin_select_load('selectLocation3','selectLocation4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectLocation4"]){?>
			$("select[name='selectLocation4']").val('<?php echo $_GET["selectLocation4"]?>').change();
<?php }?>
		});
	});
	$("select[name='s_selectLocation1']").on("change",function(){
		location_admin_select_load('s_selectLocation1','s_selectLocation2',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectLocation2"]){?>
			$("select[name='s_selectLocation2']").val('<?php echo $_GET["selectLocation2"]?>').change();
<?php }?>
		});
		location_admin_select_load('s_selectLocation2','s_selectLocation3',"");
		location_admin_select_load('s_selectLocation3','s_selectLocation4',"");
	});
	$("select[name='s_selectLocation2']").on("change",function(){
		location_admin_select_load('s_selectLocation2','s_selectLocation3',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectLocation3"]){?>
			$("select[name='s_selectLocation3']").val('<?php echo $_GET["selectLocation3"]?>').change();
<?php }?>
		});
		location_admin_select_load('s_selectLocation3','s_selectLocation4',"");
	});
	$("select[name='s_selectLocation3']").live("change",function(){
		location_admin_select_load('s_selectLocation3','s_selectLocation4',$(this).val(),function(){
<?php if($TPL_VAR["sc"]["selectLocation4"]){?>
			$("select[name='s_selectLocation4']").val('<?php echo $_GET["selectLocation4"]?>').change();
<?php }?>
		});
	});
});

</script>

<style type="text/css">
/* 검색폼 양식 개선 */
div.search-form-container {background:#fff; padding:0px 0 10px 0;margin-bottom:5px;text-align:left;}
div.search-form-container table.search-form-table	{margin:auto;}
div.search-form-container table.search_detail_form {width:100%;}
input.social_goods_group_name {width:81px;vertical-align: top;}
span.pd_td_right, span.pd_day {padding-left:5px;}

/* 티켓그룹 버튼 */
button#coupon_group_search {border: none;width:41px;height:23px;background:url('/admin/skin/default/images/common/icon/admin_sbt04.png') no-repeat; cursor:pointer;}
button#coupon_group_search_all {border: none;width:41px;height:23px;background:url('/admin/skin/default/images/common/icon/admin_allbt05.png') no-repeat; cursor:pointer;}

/* 기본검색설정 글자 */
#search_set, #btn_search_detail {color:#636363;font-size:12px;text-decoration: underline;}

div.ui-widget{padding-bottom:5px;}

/* 셀렉트박스 다운 아이콘 */
.search-form-container input.searchinp {height:22px;color:#797d86;padding:0px;padding-left:3px;padding-right:3px; font-size:12px; border:1px solid #A7A8AA; background-color:#eee; }
.search-form-container select {
			color:#797d86;font-size:12px;appearance:none;
			-webkit-appearance: none;-moz-appearance: none;
			height:24px !important;padding: 3px 0px 0px 3px;
			width:190px;vertical-align:middle;line-height:18px;
			background: #ffffff url('/admin/skin/default/images/common/icon/admin_select_n.gif') no-repeat right 8px center;
}
.search-form-container select::-ms-expand {display: none;}
.search-form-container label {color: #797d86;font-size: 12px;}
.search-form-container .ft_11 {font-size: 11px;}
.search-form-container .line {border:1px solid #a7a8aa !important; cursor:default}
.search-form-container .line:focus {margin:0px; border:2px solid #3ea4f6 !important; cursor:text}

#search_keyword {height:24px !important ;width:97%;padding:0px;}
.info-table-style { width:100%; }
.info-table-style th span{margin-left:6px; }
</style>

<div class="search-form-container">

	<table class="search-form-table search_detail_form <?php if($_SESSION["show_search_form"]=='close'){?>hide<?php }elseif($TPL_VAR["gdsearchdefault"]["search_form_view"]=='close'){?>hide<?php }?>" id="serch_tab" >
	<tr id="goods_search_form" style="display:block;">
	<tr>
		<td>
			<table class="info-table-style" border='0'>
			<colgroup>
				<col width="8%" />
				<col width="32%" />
				<col width="8%" />
				<col width="22%" />
				<col width="8%" />
				<col width="22%" />
			</colgroup>
			<!-- 카테고리 -->
			<tr>
				<th class="its-th-align"><span>카테고리</span></th>
				<td class="its-td" colspan="5">
					<span>
						<select class="line" name="selectCategory1" size="1"><option value="">1차 분류</option></select>
						<select class="line" name="selectCategory2" size="1"><option value="">2차 분류</option></select>
						<select class="line" name="selectCategory3" size="1"><option value="">3차 분류</option></select>
						<select class="line" name="selectCategory4" size="1"><option value="">4차 분류</option></select>

						<!--
						<label><input type="checkbox" name="goods_selectCategory" value="1" <?php if($TPL_VAR["sc"]["goods_selectCategory"]){?>checked<?php }?> /> 대표</label><span class="helpicon" title="체크 시 대표 카테고리를 기준으로 검색됩니다." options="{alignX: 'right'}"></span>
						<label><input type="checkbox" name="goods_selectCategory_no" value="1" <?php if($TPL_VAR["sc"]["goods_selectCategory_no"]){?>checked<?php }?> /> 미연결</label><span class="helpicon" title="체크 시 카테고리가 없는 상품을 검색합니다." options="{alignX: 'right'}"></span>
						-->
					</span>
				</td>
			</tr>
			<!-- 브랜드 -->
			<tr>
				<th class="its-th-align"><span>브랜드</span></th>
				<td class="its-td" colspan="5">
					<span>
						<select class="line" name="selectBrand1" size="1"><option value="">1차 분류</option></select>
						<select class="line" name="selectBrand2" size="1"><option value="">2차 분류</option></select>
						<select class="line" name="selectBrand3" size="1"><option value="">3차 분류</option></select>
						<select class="line" name="selectBrand4" size="1"><option value="">4차 분류</option></select>

						<!--
						 <label><input type="checkbox" name="goods_brand" value="1" <?php if($TPL_VAR["sc"]["goods_brand"]){?>checked<?php }?> /> 대표</label><span class="helpicon" title="체크 시 대표 브랜드를 기준으로 검색됩니다." options="{alignX: 'right'}"></span>

						 <label><input type="checkbox" name="goods_brand_no" value="1" <?php if($TPL_VAR["sc"]["goods_brand_no"]){?>checked<?php }?> /> 미연결</label><span class="helpicon" title="체크 시 브랜드가 없는 상품을 검색합니다." options="{alignX: 'right'}"></span>
						-->
					</span>
				</td>
			</tr>
			<!-- 지역 -->
			<tr>
				<th class="its-th-align"><span>지역</span></th>
				<td class="its-td" colspan="5">
					<span>
						<select class="line" name="selectLocation1" size="1"><option value="">1차 분류</option></select>
						<select class="line" name="selectLocation2" size="1"><option value="">2차 분류</option></select>
						<select class="line" name="selectLocation3" size="1"><option value="">3차 분류</option></select>
						<select class="line" name="selectLocation4" size="1"><option value="">4차 분류</option></select>

						<!--
						 <label><input type="checkbox" name="goods_selectLocation" value="1" <?php if($TPL_VAR["sc"]["goods_selectLocation"]){?>checked<?php }?> /> 대표</label><span class="helpicon" title="체크 시 대표 지역을 기준으로 검색됩니다." options="{alignX: 'right'}"></span>

						 <label><input type="checkbox" name="goods_selectLocation_no" value="1" <?php if($TPL_VAR["sc"]["goods_selectLocation_no"]){?>checked<?php }?> /> 미연결</label><span class="helpicon" title="체크 시 지역이 없는 상품을 검색합니다." options="{alignX: 'right'}"></span>
						-->
					</span>
				</td>
			</tr>
			<!-- 입점사 -->
			<tr>
				<th class="its-th-align"><span>입점사</span></th>
				<td class="its-td" colspan="3">
					<span>
						<select name="provider_seq_selector" class="line">
<?php if($TPL_VAR["provider_fix"]){?>
						<option value="<?php echo $_GET["provider_seq"]?>" selected ><?php echo stripslashes($_GET["provider_name"])?>(<?php echo $_GET["provider_id"]?>)</option>
<?php }else{?>
						<option value="0">- 입점사 검색 -</option>
						<option value="1" <?php if( 1==$_GET["provider_seq"]){?>selected<?php }?>>본사</option>
<?php if($TPL_provider_1){foreach($TPL_VAR["provider"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["provider_seq"]?>" <?php if($TPL_V1["provider_seq"]==$_GET["provider_seq"]){?>selected<?php }?> ><?php echo $TPL_V1["provider_name"]?>(<?php echo $TPL_V1["provider_id"]?>)</option>
<?php }}?>
<?php }?>
						</select>
						<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $_GET["provider_seq"]?>" />
						<input type="text" name="provider_name" value="<?php echo $_GET["provider_name"]?>" class="searchinp" style="width:310px;"
						 readonly  />

						<script>
						$(function(){
							$( "select[name='provider_seq_selector']" )
							.change(function(){
								if( $(this).val() > 0 ){
									$("input[name='provider_seq']").val($(this).val());
									$("input[name='provider_name']").val($("option:selected",this).text());
								}else{
									$("input[name='provider_seq']").val('');
									$("input[name='provider_name']").val('');
								}
							})
							.next(".ui-combobox").children("input")
							.bind('focus',function(){
								if($(this).val()==$( "select[name='provider_seq_selector'] option:first-child" ).text()){
									$(this).val('');
								}
							})
							.bind('mouseup',function(){
								if($(this).val()==''){
									$( "select[name='provider_seq_selector']").next(".ui-combobox").children("a.ui-combobox-toggle").click();
								}
							});
						});
						</script>
					</span>
				</td>
				<th class="its-th-align"><span>승인</span></th>
				<td class="its-td">
					<span>
						<label><input type="checkbox" name="search_provider_status[]" value="1" <?php if($TPL_VAR["sc"]["search_provider_status"]==='1'){?>checked<?php }?> /> 승인</label>
						<label><input type="checkbox" name="search_provider_status[]" value="0" <?php if($TPL_VAR["sc"]["search_provider_status"]==='0'){?>checked<?php }?> /> 미승인</label>
					</span>
				</td>
			</tr>
			<!-- 상태/노출/상품 -->
			<tr>
				<th class="its-th-align"><span>상태</span></th>
				<td class="its-td">
					<span>
						<label><input type="checkbox" name="selectGoodsStatus[]" value="normal" <?php if($TPL_VAR["sc"]["selectGoodsStatus"]&&in_array('normal',$TPL_VAR["sc"]["selectGoodsStatus"])){?>checked<?php }?> /> 정상</label>
						<label><input type="checkbox" name="selectGoodsStatus[]" value="runout" <?php if($TPL_VAR["sc"]["selectGoodsStatus"]&&in_array('runout',$TPL_VAR["sc"]["selectGoodsStatus"])){?>checked<?php }?> /> 품절</label>
						<label><input type="checkbox" name="selectGoodsStatus[]" value="purchasing" <?php if($TPL_VAR["sc"]["selectGoodsStatus"]&&in_array('purchasing',$TPL_VAR["sc"]["selectGoodsStatus"])){?>checked<?php }?> /> 재고확보중</label>
						<label><input type="checkbox" name="selectGoodsStatus[]" value="unsold" <?php if($TPL_VAR["sc"]["selectGoodsStatus"]&&in_array('unsold',$TPL_VAR["sc"]["selectGoodsStatus"])){?>checked<?php }?> /> 판매중지</label>
					</span>
				</td>
				<th class="its-th-align"><span>노출</span></th>
				<td class="its-td">
					<span>
						<label><input type="checkbox" name="selectGoodsView[]" value="look" <?php if($TPL_VAR["sc"]["selectGoodsView"]&&in_array('look',$TPL_VAR["sc"]["selectGoodsView"])){?>checked<?php }?> /> 노출</label>
						<label><input type="checkbox" name="selectGoodsView[]" value="notLook" <?php if($TPL_VAR["sc"]["selectGoodsView"]&&in_array('notLook',$TPL_VAR["sc"]["selectGoodsView"])){?>checked<?php }?> /> 미노출</label>
					</span>
				</td>
				<th class="its-th-align"><span>상품</span></th>
				<td class="its-td" <?php if(!$TPL_VAR["socialcpuse"]||preg_match('/goods\/batch_modify/',$_SERVER["REQUEST_URI"])){?><?php }else{?>colspan="3"<?php }?>>
					<span>
						<label><input type="checkbox" name="selectGoodskind[]" value="goods"  <?php if($TPL_VAR["sc"]["selectGoodskind"]&&in_array('look',$TPL_VAR["sc"]["selectGoodskind"])){?>checked<?php }?> > 실물</label>
						<label><input type="checkbox" name="selectGoodskind[]" value="coupon"  <?php if($TPL_VAR["sc"]["selectGoodskind"]&&in_array('look',$TPL_VAR["sc"]["selectGoodskind"])){?>checked<?php }?> > 티켓</label>
					</span>
				</td>
			</tr>
			<tr>
				<th class="its-th-align"><span>검색어</span></th>
				<td class="its-td">
					<div id="src_keyword_lay"><input type="text" id="selectKeyword" name="selectKeyword" class="src-keyword-input" value="<?php echo $_GET["selectKeyword"]?>"  title="상품명,상품고유값,상품코드,태그,간략설명" style="padding:0px;height:25px;width:95%;" /></div>
					<!-- 검색어 입력시 레이어 박스 : end -->
				</td>
				<th class="its-th-align"><span>이벤트</span></th>
				<td class="its-td" colspan="3">
					<span>할인이벤트
						<select name="selectEvent" class="line" style="width:140px;">
							<option value="">이벤트 선택</option>
<?php if($TPL_VAR["event_list"]){?>
<?php if($TPL_event_list_1){foreach($TPL_VAR["event_list"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["event_seq"]?>" <?php if($TPL_VAR["sc"]["selectEvent"]==$TPL_V1["event_seq"]){?>selected<?php }?>><?php echo $TPL_V1["event_title"]?></option>
<?php }}?>
<?php }?>
						</select>

						사은품이벤트
						<select name="selectGift" class="line" style="width:140px;">
							<option value="">사은품 이벤트 선택</option>
<?php if($TPL_VAR["gift_list"]){?>
<?php if($TPL_gift_list_1){foreach($TPL_VAR["gift_list"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["gift_seq"]?>" <?php if($TPL_VAR["sc"]["selectGift"]==$TPL_V1["gift_seq"]){?>selected<?php }?>><?php echo $TPL_V1["gift_title"]?></option>
<?php }}?>
<?php }?>
						</select>
					</span>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>

<div class="center">
	<span class="btn large cyanblue"><button type="submit">검색</button></span>
</div>