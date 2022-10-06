<?php /* Template_ 2.2.6 2022/05/17 12:31:56 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_hscode.html 000008202 */ 
$TPL_r_hscode_1=empty($TPL_VAR["r_hscode"])||!is_array($TPL_VAR["r_hscode"])?0:count($TPL_VAR["r_hscode"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
$(document).ready(function() {

	$("select[name='batch_hscode_selector']").css({'width': '150px'}).combobox()
		.change(function(){

			var selectedHSCode	= $(this).val();

			console.log("selectedHSCode : " + selectedHSCode);
			if( selectedHSCode != 0 ){
				$("input[name='hscode_common']").val(selectedHSCode);
				$("input[name='hscode_name']").val($("option:selected",this).text());
			}else{
				$("input[name='hscode_common']").val('');
				$("input[name='hscode_name']").val('');
			}

		}).next(".ui-combobox").children("input").css({'width': '150px'})
		.bind('focus',function(){
			if($(this).val()==$( "select[name='batch_hscode_selector'] option:first-child" ).text()){
				$(this).val('');
			}
		})
		.bind('mouseup',function(){
			if($(this).val()==''){
				$( "select[name='batch_hscode_selector']").next(".ui-combobox").children("a.ui-combobox-toggle").click();
			}
	});

});

// HSCODE 관리 페이지로 이동
function goHSCodepage(){
	if	($("input[name='hscode_common']").val() && $("input[name='hscode_name']").val()){
		window.open('../goods/hscode_setting?hscode=' + $("input[name='hscode_common']").val());
	}else{
		window.open('../goods/hscode_setting');
	}
}
</script>
<br class="table-gap" />
<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="15%" /><!--대상 상품-->
		<col  /><!--아래와 같이 업데이트-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th>대상 상품</th>
		<th>아래와 같이 업데이트  </th>
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
			<td class="pdt20 pdb20">
				<div class="pdl10">
					<!--조건상 checkbox가 있어야함 무조건 checked 및 hide 처리-->
					<label><input type="checkbox" class="hide" name="batch_hscode_yn" value="1" checked/> HSCODE 를</label>
					<select name="batch_hscode_selector" style="vertical-align:middle;width:141px;" title="선택하세요">
						<option value="0">품명검색</option>
<?php if($TPL_r_hscode_1){foreach($TPL_VAR["r_hscode"] as $TPL_V1){?><option value="<?php echo $TPL_V1["hscode_common"]?>"><?php echo $TPL_V1["hscode_name"]?>(<?php echo $TPL_V1["hscode_common"]?>)</option><?php }}?>
					</select>
					<span style="margin-left:20px;">&nbsp;</span>
					<input type="hidden" class="hscode_common" name="hscode_common"/>
					<input type="text" name="hscode_name" value="<?php echo $_GET["hscode_name"]?>" style="width:150px;" readonly />
					변경(<span class="click-lay" style="color:orange !important;" onclick="goHSCodepage();">HSCODE 관리</span>)합니다
				</div>
			</td>
		</tr>
	</tbody>
</table>


<br class="table-gap" />


<ul class="left-btns clearbox">
	<li class="left-btns-txt desc">※ 이용방법 : [검색하기] 버튼으로 검색 후 상품정보를 조건 업데이트 하세요!</li>
</ul>
<div class="fr">
	<div class="clearbox">
		<ul class="right-btns clearbox">
		<li><select class="custom-select-box-multi" name="orderby">
			<option value="goods_seq" <?php if($TPL_VAR["orderby"]=='goods_seq'){?>selected<?php }?>>최근등록순</option>
			<option value="goods_name" <?php if($TPL_VAR["orderby"]=='goods_name'){?>selected<?php }?>>상품명순</option>
			<option value="page_view" <?php if($TPL_VAR["orderby"]=='page_view'){?>selected<?php }?>>페이지뷰순</option>
		</select></li>
		<li><select  class="custom-select-box-multi" name="perpage">
			<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
			<option id="dp_qty50" value="50" <?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?> >50개씩</option>
			<option id="dp_qty100" value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
			<option id="dp_qty200" value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
		</select></li>
	</ul>
	</div>
</div>

<br style="line-height:2px;" />
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="3%" /><!--체크-->
<?php if(serviceLimit('H_AD')){?><col width="10%" /><!--입점사--><?php }?>
		<col width="7%" /><!--상품이미지-->
		<col  /><!--상품명-->
		<col width="400" /><!--아이콘-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
<?php if(serviceLimit('H_AD')){?><th>입점</th><?php }?>
		<th colspan="2">상품명</th>
		<th>HSCODE</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;">
			<td align="center"><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /></td>
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
			<td align="center"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a></td>
			<td align="left" style="padding-left:10px;">
<?php if($TPL_V1["tax"]=='exempt'&&$TPL_V1["cancel_type"]=='1'){?>
					<div>
					<span style="color:red;" class="left" >[비과세]</span>
					<span class="order-item-cancel-type left" >[청약철회불가]</span>
					</div>
<?php }elseif($TPL_V1["tax"]=='exempt'){?>
					<div>
					<span style="color:red;" class="left" >[비과세]</span>
					</div>
<?php }elseif($TPL_V1["cancel_type"]=='1'){?>
					<div>
					<span class="order-item-cancel-type left" >[청약철회불가]</span>
					</div>
<?php }?>
<?php if($TPL_V1["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
			<a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo $TPL_V1["goods_name"]?></a> <div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
			</td>
			<td align="left">
<?php if($TPL_V1["hscode"]){?>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="border:none;">품명 : <?php echo $TPL_V1["hscode_name"]?></td>
					<td style="border:none;" rowspan="2" width="80">
						<span class="click-lay" style="color:orange !important;" onclick="window.open('../goods/hscode_setting?hscode=<?php echo $TPL_V1["hscode"]?>');">자세히</span>
					</td>
				</tr>
				<tr>
					<td style="border:none;">공통HSCODE : <?php echo $TPL_V1["hscode"]?></td>
				</tr>
				</table>
<?php }else{?> &nbsp;<?php }?>
				</div>
			</td>
		</tr>
		<tr class="order-list-summary-row hide">
			<td colspan="8" class="order-list-summary-row-td"><div class="option_info"></div></td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" colspan="7">
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