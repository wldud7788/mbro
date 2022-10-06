<?php /* Template_ 2.2.6 2022/05/17 12:31:49 /www/music_brother_firstmall_kr/admin/skin/default/goods/gift_catalog.html 000025102 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript">
	// SEARCH FOLDER
	function showSearch(){
		if($("#goods_search_form").css('display')=='none'){
			$("#goods_search_form").show();
			$.cookie("goods_list_folder", "folded");
		}else{
			$("#goods_search_form").hide();
			$.cookie("goods_list_folder", "unfolded");
		}
	}

	$(document).ready(function() {
		$("#delete_btn").click(function(){
<?php if(!$TPL_VAR["auth"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>

			var cnt = $("input:checkbox[name='goods_seq[]']:checked").length;
			if(cnt<1){
				alert("삭제할 상품을 선택해 주세요.");
				return;
			}else{
				var queryString = $("#goodsForm").serialize();
				if(!confirm("선택한 상품을 삭제 시키겠습니까? ")) return;
				$.ajax({
					type: "get",
					url: "../goods_process/goods_delete",
					data: queryString,
					success: function(result){
						//alert(result);
						location.reload();
					}
				});
			}
		});

		$("#chkAll").click(function(){
			if($(this).attr("checked")){
				$(".chk").attr("checked",true).change();
			}else{
				$(".chk").attr("checked",false).change();
			}
		});

		$(".manager_copy_btn").click(function(){

<?php if(!$TPL_VAR["auth"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>

			if(!confirm("이 상품을 복사해서 상품을 등록하시겠습니까?")) return;

			$.ajax({
				type: "get",
				url: "../goods_process/goods_copy",
				data: "goods_seq="+$(this).attr("goods_seq"),
				success: function(result){
					switch(result){
						case	'diskfull' :
							customOptions				= [];
							customOptions['btn_title']	= '용량추가';
							customOptions['btn_class']	= 'btn large cyanblue';
							customOptions['btn_action']	= "window.open('https://firstmall.kr/myshop','_blank')";
							openDialogAlert("용량이 초과되어 상품을 등록 또는 수정할 수 없습니다.<br/>용량 추가를 하시길 바랍니다.",400,175,'',customOptions);
						break;

						default :
							location.reload();
						break;
					}
				}
			});
		});

		// 체크박스 색상
		$("input[type='checkbox'][name='goods_seq[]']").live('change',function(){
			if($(this).is(':checked')){
				$(this).closest('tr').addClass('checked-tr-background');
			}else{
				$(this).closest('tr').removeClass('checked-tr-background');
			}
		}).change();


		$(".btnSort").bind("click", function(){
			var sort = $("input[name='sort']").val();
			if($(this).attr("orderby") != "<?php echo $TPL_VAR["sorderby"]?>") sort = "";

			if(sort == "asc"){
				sort = "desc";
			}else if(sort == "desc" || sort == ""){
				sort = "asc";
			}
			var orderby = sort+"_"+$(this).attr("orderby");

			$(this).attr("sort",sort);
			$("select[name='orderby'] option[value='"+orderby+"']").attr("selected",true);
			$("input[name='keyword']").focus();
			$("form[name='goodsForm']").submit();
		});


		// export_upload
		$("button[name='upload_excel']").live("click",function(){
			openDialog("상품일괄등록/수정 <span class='desc'></span>", "export_upload", {"width":"600","height":"500","show" : "fade","hide" : "fade"});
		});

		$(".gift_helpbtn").click(function() {
			openDialog("사은품 안내", "gift_help", {"width":1000,"height":490});
		});

		$(".hscode_setting").bind("click",function(){
			document.location.href="./hscode_setting";
		});

	});

	function gift_help(){
		openDialog("사은품 안내", "gift_help", {"width":1000,"height":490});
	}

	function goodsView(seq){
		$("input[name='no']").val(seq);
		var search = location.search;
		search = search.substring(1,search.length);
		$("input[name='query_string']").val(search);
		$("form[name='goodsForm']").attr('action','gift_regist');
		$("form[name='goodsForm']").submit();
	}
</script>
<style>
	.goodsOptionTable {display:none; position:absolute; border-collapse:collapse; top:-10px; left:60px;}
	.goodsOptionTable table {width:220px;}
	.goodsOptionTable th {padding:5px; border:1px solid #ddd; background-color:#f5f5f5}
	.goodsOptionTable td {height:25px !important; border:1px solid #ddd; background-color:#ffffff; text-align:center;}
	.t_tot_stock {text-align:center; border-collapse:collapse;}
	.t_tot_stock td {border:1px solid #666; padding:1px;}
	.gr_col {color:#666;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>[실물배송] 사은품</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span class="btn large orange"><input type="button" value="안내) 사은품" onclick="gift_help();"></span></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_VAR["managerInfo"]){?>
			<li><span class="btn large deepblue"><button onclick="location.href='gift_regist?provider=base';">본사매입 사은품등록<span class="arrowright"></span></button></span></li>
			<li><span class="btn large red"><button onclick="location.href='gift_regist';">입점사 사은품등록<span class="arrowright"></span></button></span></li>
<?php }elseif($TPL_VAR["providerInfo"]){?>
			<li><span class="btn large red"><button onclick="location.href='gift_regist';">입점사 사은품등록<span class="arrowright"></span></button></span></li>
<?php }?>
<?php }else{?>
			<li><span class="icon-goods-kind-<?php echo $TPL_VAR["goods"]["goods_kind"]?>"></span><span class="btn large red"><button onclick="location.href='gift_regist?provider=base';">사은품등록<span class="arrowright"></span></button></span></li>
<?php }?>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<form name="goodsForm" id="goodsForm">
<input type="hidden" name="query_string"/>
<input type="hidden" name="no" />
<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sort"]?>"/>

<!-- 상품 검색폼 : 시작 -->
<?php $this->print_("goods_search_form",$TPL_SCP,1);?>

<!-- 상품 검색폼 : 끝 -->

<ul class="right-btns clearbox">
	<li><select class="custom-select-box-multi" name="orderby" onchange="document.goodsForm.submit();">
		<option value="asc_goods_name" <?php if($TPL_VAR["orderby"]=='asc_goods_name'){?>selected<?php }?>>사은품명↑</option>
		<option value="desc_goods_name" <?php if($TPL_VAR["orderby"]=='desc_goods_name'){?>selected<?php }?>>사은품명↓</option>
		<option value="asc_consumer_price" <?php if($TPL_VAR["orderby"]=='asc_consumer_price'){?>selected<?php }?>>정가↑</option>
		<option value="desc_consumer_price" <?php if($TPL_VAR["orderby"]=='desc_consumer_price'){?>selected<?php }?>>정가↓</option>
		<option value="asc_price" <?php if($TPL_VAR["orderby"]=='asc_price'){?>selected<?php }?>>판매가↑</option>
		<option value="desc_price" <?php if($TPL_VAR["orderby"]=='desc_price'){?>selected<?php }?>>판매가↓</option>
		<option value="asc_tot_stock" <?php if($TPL_VAR["orderby"]=='asc_tot_stock'){?>selected<?php }?>>재고↑</option>
		<option value="desc_tot_stock" <?php if($TPL_VAR["orderby"]=='desc_tot_stock'){?>selected<?php }?>>재고↓</option>
		<option value="asc_goods_seq" <?php if($TPL_VAR["orderby"]=='asc_goods_seq'){?>selected<?php }?>>등록일순↑</option>
		<option value="desc_goods_seq" <?php if($TPL_VAR["orderby"]=='desc_goods_seq'){?>selected<?php }?>>등록일순↓</option>
	</select></li>
	<li><select  class="custom-select-box-multi" name="perpage" onchange="document.goodsForm.submit();">
		<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
		<option id="dp_qty50" value="50" <?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?> >50개씩</option>
		<option id="dp_qty100" value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
		<option id="dp_qty200" value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
	</select></li>
</ul>

<ul class="left-btns clearbox">
	<li>
		<div style="margin-top:5px;" id="search_count">
			총 <b><?php echo $TPL_VAR["page"]["searchcount"]?></b> 개
		</div>
	</li>
</ul>

<!-- 주문리스트 테이블 : 시작 -->
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="30" />
		<col width="30" />
		<col width="40" />
<?php if(serviceLimit('H_AD')){?>
		<col width="60" />
<?php }?>
		<col width="100" />
		<col />
		<col width="90" />
		<col width="90" />
		<col width="130" />
		<col width="100" />
		<col width="150" />
		<col width="70" />
		<col width="60" />
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
		<th><span class="icon-star-gray <?php if($TPL_VAR["sc"]["orderby"]=='favorite_chk'&&$TPL_VAR["sc"]["sort"]=='desc'){?>checked<?php }?>" id="order_star"></span></th>
		<th>번호</th>
<?php if(serviceLimit('H_AD')){?>
		<th>입점</th>
<?php }?>
		<th colspan="2"><span class="btnSort hand" orderby="goods_name" title="[사은품명] 정렬">사은품명<?php if($TPL_VAR["orderby"]=='asc_goods_name'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_goods_name'){?>▼<?php }?></span></th>

		<th><span class="btnSort hand" orderby="consumer_price" title="[정가] 정렬">정가<?php if($TPL_VAR["orderby"]=='asc_consumer_price'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_consumer_price'){?>▼<?php }?></span></th>
		<th><span class="btnSort hand" orderby="price" title="[판매가] 정렬">판매가<?php if($TPL_VAR["orderby"]=='asc_price'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_price'){?>▼<?php }?></span></th>
		<th><span class="btnSort hand" orderby="tot_stock" title="[재고] 정렬">재고<?php if($TPL_VAR["orderby"]=='asc_tot_stock'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_tot_stock'){?>▼<?php }?></span><span>/가용</span>
			<span class="helpicon2 detailDescriptionLayerBtn" title="[안내] 재고/가용 표기"></span>
			<div class="detailDescriptionLayer hide">
				<table class='t_tot_stock'>
					<tr>
						<td style="color:#5CD1E5;">[가용재고 > 0 인 옵션의 개수]</td>
						<td>해당 옵션의 재고 합계</td>
						<td>해당 옵션의 가용재고 합계</td>
					</tr>
					<tr>
						<td style="color:#5CD1E5;">[가용재고 < = 0 인 옵션의 개수]</td>
						<td>해당 옵션의 재고 합계</td>
						<td>해당 옵션의 가용재고 합계</td>
					</tr>
				</table><br />
				해당 상품에 가용재고 > 0 인 옵션이 있다면 해당 옵션의 재고 합계 > 0 이며, 가용재고 합계 > 0 입니다.<br />
				해당 상품에 가용재고 < = 0 인 옵션이 있다면 해당 옵션의 재고 합계 = 0 이며, 가용재고 합계 < = 0 입니다.<br /><br /><br />
				<b>예시 1 - '가' 상품)</b><br />
				<span class="helpicon_noimg" title="가용재고 있는 옵션 개수">[1]</span>  10 / 3&nbsp;&nbsp;&nbsp;<span class="desc">→ 가용재고 > 0 인 옵션은 [1]개이며 해당 옵션의 재고합계 10 / 가용재고합계 3</span><br /><span class="helpicon_noimg" title="가용재고 없는 옵션 개수">[3]</span>  <span style='color:#FF4848;'>0</span> / <span style='color:#FF4848;'>-1</span>&nbsp;&nbsp;&nbsp;<span class="desc">→ 가용재고 < = 0 인 옵션은 [3]개이며 해당 옵션의 재고합계 0 / 가용재고합계 -1</span><br /><br />
				<b>예시 2 - '나' 상품)</b><br />
				<span class="helpicon_noimg" title="가용재고 있는 옵션 개수">[2]</span>  9 / 7&nbsp;&nbsp;&nbsp;&nbsp;<span class="desc">→ 가용재고 > 0 인 옵션은 [2]개이며 해당 옵션의 재고합계 9 / 가용재고합계 7</span><br /><span class="helpicon_noimg" title="가용재고 없는 옵션 개수">[0]</span>  - / -&nbsp;&nbsp;&nbsp;&nbsp;<span class="desc">→ 가용재고 < = 0 인 옵션은 없습니다.</span><br /><br />
				<b>예시 3 - '다' 상품)</b><br />
				<span class="helpicon_noimg" title="가용재고 있는 옵션 개수">[0]</span>  - / -&nbsp;&nbsp;&nbsp;&nbsp;<span class="desc">→ 가용재고 > 0 인 옵션은 없습니다.</span><br /><span class="helpicon_noimg" title="가용재고 없는 옵션 개수">[1]</span>  <span style='color:#FF4848;'>0</span> / <span style='color:#FF4848;'>0</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="desc">→ 가용재고 < = 0 인 옵션은 [1]개이며 해당 옵션의 재고합계 0 / 가용재고합계 0</span><br /><br />
			</div>
		</th>
		<th>재고판매
			<span class="helpicon2 detailDescriptionLayerBtn" title="[안내] 재고에 따른 판매 가능여부"></span>
			<div class="detailDescriptionLayer hide">재고(옵션 기준)에 따른 상품 판매 설정에 따라<br />아래와 같이 3가지로 표기됩니다.<br />- 주문수량 < = 재고  : <span class="desc">주문수량 < = 재고 일 때 주문 가능</span><br />- 주문수량 < = 가용재고  : <span class="desc">주문수량 < = 가용재고 일 때 주문 가능</span><br />- 무제한  : <span class="desc">재고 상관없이 주문 가능</span></div>
		</th>
		<th><span class="btnSort hand" orderby="goods_seq" title="[등록일순] 정렬">등록일<?php if($TPL_VAR["orderby"]=='asc_goods_seq'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_goods_seq'){?>▼<?php }?></span>
		/<span style="font-size: 12px;">수정일</span></th>

		<th>상태</th>
		<th>관리</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;">
			<td align="center">
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'&&$TPL_V1["rtotal_stock"]> 0){?>
				-
<?php }else{?>
				<input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" />
<?php }?>
			</td>
			<td align="center"><span class="icon-star-gray star_select <?php echo $TPL_V1["favorite_chk"]?>" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"></span></td>
			<td align="center" class="page_no"><?php echo $TPL_V1["_no"]?></td>
<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_V1["provider_seq"]=='1'){?>
				<td align="center" class="white bold bg-blue">
<?php if($TPL_V1["lastest_supplier_name"]){?>
					매입 - <?php echo $TPL_V1["lastest_supplier_name"]?>

<?php }else{?>
					매입
<?php }?>
				</td>
<?php }else{?>
				<td align="center" class="white bold bg-red"><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
<?php }?>
			<td align="right"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></td>
			<td align="left" style="padding-left:10px;"><a href="javascript:void(0);" onclick="goodsView('<?php echo $TPL_V1["goods_seq"]?>');"><?php echo getstrcut($TPL_V1["goods_name"], 80)?></a></td>
			<td align="right"><?php echo get_currency_price($TPL_V1["consumer_price"])?>&nbsp;</td>
			<td align="right"><?php echo get_currency_price($TPL_V1["price"])?>&nbsp;</td>
			<td align="right">
				<table class='gr_col' width="100%" style="padding-left:1px;padding-right:1px;">
					<tr>
						<td colspan=2 style="border:0px;height:15px;width:*;text-align:left;">
							<span style='color:#5CD1E5;'>[<?php echo number_format($TPL_V1["a_stock_cnt"])?>]</span>
<?php if($TPL_V1["a_stock_cnt"]== 0){?>
							<?php echo $TPL_V1["a_stock"]?> / <?php echo $TPL_V1["a_rstock"]?>

<?php }else{?>
							<?php echo number_format($TPL_V1["a_stock"])?> / <?php echo number_format($TPL_V1["a_rstock"])?>

<?php }?>
						</td>
					</tr>
					<tr>
						<td style="border:0px;height:15px;text-align:left;">
							<span style='color:#5CD1E5;'>[<?php echo number_format($TPL_V1["b_stock_cnt"])?>]</span>
<?php if($TPL_V1["b_stock_cnt"]== 0){?>
							<?php echo $TPL_V1["b_stock"]?> / <?php echo $TPL_V1["b_rstock"]?>

<?php }else{?>
							<span style='color:#FF4848;'><?php echo number_format($TPL_V1["b_stock"])?></span> / <span  style='color:#FF4848;'><?php echo number_format($TPL_V1["b_rstock"])?></span>
<?php }?>
						</td>
						<td style="border:0px;height:15px;text-align:right;padding-right:2px;">
							<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V1["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_V1["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
								<span class="option-stock" optType="option" optSeq=""></span>
								<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"><span class="hide">옵션</span></span>
							</span>
						</td>
					</tr>
				</table>
<?php if($TPL_V1["options"][ 0]["option_title"]){?>
				<br/>
<?php if($TPL_VAR["cfg_goods_default"]["list_condition_stock"]=='y'){?>
<?php if($TPL_V1["runout_policy"]=='stock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_goods_stock.png" class="help" title="[개별설정] 주문수량 <= 재고" align="absmiddle" / -->
				주문수량<br /><= 재고
<?php }elseif($TPL_V1["runout_policy"]=='ableStock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_goods_ablestock.png" class="help" title="[개별설정] 주문수량 <= 가용재고" align="absmiddle" / -->
				주문수량<br /><= 가용재고
<?php }elseif($TPL_V1["runout_policy"]=='unlimited'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_goods_nolimit.png" class="help" title="[개별설정] 무제한" align="absmiddle" / -->
				<span class="red">무제한</span>
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='stock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_config_stock.png" class="help" title="[통합설정] 주문수량 <= 재고" align="absmiddle" / -->
				 주문수량<br /><= 재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='ableStock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_config_ablestock.png" class="help" title="[통합설정] 주문수량 <= 가용재고" align="absmiddle" / -->
				주문수량<br /><= 가용재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='unlimited'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_config_nolimit.png" class="help" title="[통합설정] 무제한" align="absmiddle" / -->
				<span class="red">무제한</span>
<?php }?>
<?php }?>

<?php }else{?>
				<br/>
<?php if($TPL_VAR["cfg_goods_default"]["list_condition_stock"]=='y'){?>
<?php if($TPL_V1["runout_policy"]=='stock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_goods_stock.png" class="help" title="[개별설정] 주문수량 <= 재고" align="absmiddle" / -->
				주문수량<br /><= 재고
<?php }elseif($TPL_V1["runout_policy"]=='ableStock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_goods_ablestock.png" class="help" title="[개별설정] 주문수량 <= 가용재고" align="absmiddle" / -->
				주문수량<br /><= 가용재고
<?php }elseif($TPL_V1["runout_policy"]=='unlimited'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_goods_nolimit.png" class="help" title="[개별설정] 무제한" align="absmiddle" / -->
				<span style='color:#FF4848;'>무제한</span>
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='stock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_config_stock.png" class="help" title="[통합설정] 주문수량 <= 재고" align="absmiddle" / -->
				 주문수량<br /><= 재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='ableStock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_config_ablestock.png" class="help" title="[통합설정] 주문수량 <= 가용재고" align="absmiddle" / -->
				주문수량<br /><= 가용재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='unlimited'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_config_nolimit.png" class="help" title="[통합설정] 무제한" align="absmiddle" / -->
				<span style='color:#FF4848;'>무제한</span>
<?php }?>
<?php }?>
<?php }?>
			</td>
			<td align="center" class="gr_col">
<?php if($TPL_V1["runout_policy"]){?>
				<!--<b>[개별설정]</b><br/>-->
<?php if($TPL_V1["runout_policy"]=='stock'){?>
				주문수량 <= 재고
<?php }elseif($TPL_V1["runout_policy"]=='ableStock'){?>
				주문수량<br /><= 가용재고
<?php }elseif($TPL_V1["runout_policy"]=='unlimited'){?>
				<span style='color:#FF4848;'>무제한</span>
<?php }?>
<?php }else{?>
				<!--<b>[통합설정]</b><br/>-->
<?php if($TPL_VAR["cfg_order"]["runout"]=='stock'){?>
				주문수량 <= 재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='ableStock'){?>
				주문수량<br /><= 가용재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='unlimited'){?>
				<span style='color:#FF4848;'>무제한</span>
<?php }?>
<?php }?>
			</td>
			<td align="center"><?php echo $TPL_V1["regist_date"]?><br/><?php echo $TPL_V1["update_date"]?></td>
			<td align="center"><?php if(serviceLimit('H_AD')){?><?php echo $TPL_V1["provider_status_text"]?><br/><?php }?><?php echo $TPL_V1["goods_status_text"]?></td>
			<td align="center">
				<span class="btn small valign-middle"><input type="button" name="manager_modify_btn" value="상세" goods_seq="<?php echo $TPL_V1["goods_seq"]?>" onclick="goodsView('<?php echo $TPL_V1["goods_seq"]?>');"/></span>
			</td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" <?php if(serviceLimit('H_AD')){?>colspan="13"<?php }else{?>colspan="12"<?php }?>>
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
<div class="clearbox">
	<ul class="left-btns" style="margin-top:-10px;">
		<li>
			<span class="btn small gray"><button type="button" id="delete_btn">삭제</button></span>
		</li>
	</ul>
	
	<!-- 페이징 -->
	<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>
</form>

<div id="export_upload" class="hide">
<form name="excelRegist" id="excelRegist" method="post" action="../goods_process/excel_upload" enctype="multipart/form-data"  target="actionFrame">

	<div class="clearbox"></div>
	<div class="item-title">상품 일괄 등록 및 수정</div>
	<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="20%" />
		<col width="80%" />
	</colgroup>
	<tr>
		<th class="its-th-align center">일괄수정</th>
		<td class="its-td">
			<input type="file" name="excel_file" id="excel_file" style="height:20px;"/>
		</td>
	</tr>
	</table>

	<div style="width:100%;text-align:center;padding-top:10px;">
	<span class="btn large cyanblue"><button id="upload_submit">확인</button></span>
	</div>

	<div style="padding:15px;"></div>

	<div style="padding-left:10px;font-size:12px;">
		* 상품을 일괄 등록하거나 수정할 때 엑셀 양식을  먼저 다운로드 받은 후에 이용하면 됩니다.(xls 양식) <br/>
		<div style="padding:3px;"></div>
		* 일괄 등록과 수정의 구분은 고유값 필드에 있는 값의 유무로 판단합니다.(고유값 필드에 값이 있으면 수정, 없으면 등록입니다.)<br/>
		<div style="padding:3px;"></div>
		* 상품 옵션은 옵션마다 1개의 행을 차지합니다.(옵션을 등록한 이후에 엑셀을 다운로드 받아서 보면 이해하기 편합니다.)<br/>
		<div style="padding:3px;"></div>
		* 옵션 항목에는 옵션값만 입력해야 하며 상품 공통 정보를 입력하면 안됩니다. 상품 공통 정보 항목도 옵션값을 입력하면 안됩니다. <br/>
	</div>

	<div style="padding:15px;"></div>


</form>
</div>
<div id="gift_help" style="display:none;">
	<table width="100%" class="info-table-style">
		<tr>
			<td class="its-td-align center"><img src="/admin/skin/default/images/design/guide_img_gift.gif"></td>
		</tr>
	</table>
</div>

<!-- 기본검색설정 : 시작 -->
<div class="hide" id="search_detail_dialog"><?php $this->print_("set_search_default",$TPL_SCP,1);?></div>
<!-- 기본검색설정 : 끝 -->

<!--### 워터마크세팅 -->
<div id="watermark_setting_popup"></div>

<script type="text/javascript">
// 리스트 카운트 에러 발생으로 제거 20.02.06 sms
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>