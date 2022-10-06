<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/popup/shipping_address_list.html 000005977 */ 
$TPL_category_1=empty($TPL_VAR["category"])||!is_array($TPL_VAR["category"])?0:count($TPL_VAR["category"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript" src="/app/javascript/js/admin-shipping.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	var otpHtml = "<option value=\"direct_input\">직접입력</option>";
	$("#address_category").empty().data('options');
	$("#address_category").append(otpHtml);
	otpHtml = "<option value=\"\">전체분류</option>";
	$("#src_address_category").empty().data('options');
	$("#src_address_category").append(otpHtml);

<?php if($TPL_VAR["category"]){?>
<?php if($TPL_category_1){foreach($TPL_VAR["category"] as $TPL_V1){?>
		otpHtml = "<option value=\"<?php echo $TPL_V1["address_category"]?>\"><?php echo $TPL_V1["address_category"]?></option>";
		$("#address_category").append(otpHtml);
		$("#src_address_category").append(otpHtml);
<?php }}?>
<?php }?>

<?php if($TPL_VAR["sc"]["address_category"]){?>
	$("#src_address_category").val("<?php echo $TPL_VAR["sc"]["address_category"]?>").attr("selected", "selected");
<?php }?>
<?php if($TPL_VAR["msg"]){?>
	$(".control-btn").hide();
<?php }else{?>
	$(".control-btn").show();
<?php }?>
});

// 전체 체크
function chkAll(){
	var chk_status = $("#allchk").attr('checked');
	if(chk_status == 'checked'){
		$("input[name='add_chk[]']").prop('checked',true);
	}else{
		$("input[name='add_chk[]']").prop('checked',false);
	}
}
</script>
<form name="settingForm" method="GET" target="actionFrame">
<table class="table_basic tdc v7 mt10">
<colgroup>
	<col width="5%" />
	<col width="5%" />
	<col width="" />
	<col width="" />
	<col width="" />
	<col width="40%"/>
	<col width="" />
	<col width="" />
</colgroup>
<thead>
<tr>
	<th><label class="resp_checkbox"><input type="checkbox" name="allchk" id="allchk" onclick="chkAll();"/></label></th>
	<th>번호</th>
	<th>분류</th>
	<th>매장명</th>
	<th>해외</th>
	<th>주소</th>
	<th>매장 전화번호</th>
<?php if($TPL_VAR["tabtype"]=='input'){?>
	<th>관리</th>
<?php }?>
</tr>
</thead>
<tbody>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<tr class="address_tr_<?php echo $TPL_V1["shipping_address_seq"]?>" add_type="<?php echo $TPL_V1["add_type"]?>">
	<td class="nonpd" height="30">
		<label class="resp_checkbox">
			<input type="checkbox" name="add_chk[]" value="<?php echo $TPL_V1["shipping_address_seq"]?>" <?php if($TPL_V1["is_selected"]=='Y'){?>disabled<?php }?>
<?php if($TPL_V1["refund_address_seq"]){?>
				data-refund_address="1"
<?php }?>
<?php if($TPL_V1["shipping_store_seq"]== 1){?>
				data-shipping_store="1"
<?php }?>
			/>
		</label>
	</td>
	<td class="nonpd"><?php echo $TPL_V1["_rno"]?></td>
	<td class="nonpd category"><?php echo $TPL_V1["address_category"]?></td>
	<td class="nonpd address_name"><?php echo $TPL_V1["address_name"]?></td>
	<td class="nonpd nation"><?php if($TPL_V1["address_nation"]=='korea'){?>N<?php }else{?>Y<?php }?></td>
	<td class="left address">
<?php if($TPL_V1["address_zipcode"]){?>
<?php if($TPL_V1["address_nation"]=='korea'){?>
		(<?php echo $TPL_V1["address_zipcode"]?>)
<?php if($TPL_V1["address_type"]=='street'){?>
			<?php echo $TPL_V1["address_street"]?>

<?php }else{?>
			<?php echo $TPL_V1["address"]?>

<?php }?>
			<?php echo $TPL_V1["address_detail"]?>

<?php }else{?>
		(<?php echo $TPL_V1["international_postcode"]?>) <?php echo $TPL_V1["international_address"]?> <?php echo $TPL_V1["international_town_city"]?> <?php echo $TPL_V1["international_county"]?> <?php echo $TPL_V1["international_country"]?>

<?php }?>
<?php }?>
	</td>
	<td class="nonpd shipping_phone"><?php echo $TPL_V1["shipping_phone"]?></td>
<?php if($TPL_VAR["tabtype"]=='input'){?>
	<td class="nonpd">
		<button type="button" onclick="insert_address_pop('<?php echo $TPL_V1["shipping_address_seq"]?>');" class="resp_btn">수정</button>
	</td>
<?php }?>
</tr>
<?php }}?>
<?php }else{?>
<tr>
	<td colspan="8" class="center">
<?php if($TPL_VAR["sc"]){?>
		검색된 장소리스트가 없습니다.
<?php }else{?>
		설정된 장소리스트가 없습니다.
<?php }?>
	</td>
</tr>
<?php }?>
</tbody>
</table>
</form>
<button type="button" class="btnStoreDelete resp_btn v3 mt10">삭제</button>

<div class="paging_navigation" style="padding-top:10px; margin:auto;"><?php echo $TPL_VAR["page"]["html"]?></div>

<!-- 삭제 안내 레이어 : start -->
<div class="hide" id="deleteInfoLayer">
	<div style="padding-top:5px;">
		<ul class="red mt10">
			<li>매장 삭제 전 아래 유의사항을 반드시 확인하시기 바랍니다.</li>
		</ul>
		<ul class="mt10">
			<li class="bold">1. 반송지 해당하는 경우 </li>
			<li>배송정책><a class="link_blue_01" href="../setting/shipping_group">배송비</a>에 반송지 설정을 먼저 변경 후 삭제 가능합니다.</li>
		</ul>
		<ul class="mt10">
			<li class="bold">2. 매장 수령 사용하는 경우</li>
			<li>배송정책><a class="link_blue_01" href="../setting/shipping_group">배송비</a>에 수령 매장 설정을 먼저 변경 후 삭제 가능합니다.</li>
		</ul>

		<div style="padding-top:10px;text-align:center;">
			<ul class="mt10 mb10">
				<li>선택한 매장을 삭제하시겠습니까?</li>
			</ul>
			<span class="btn large">
				<button type="button" class="btn_resp b_white btnDelSetting" >예</button>
			</span>
			<span class="btn large">
				<button type="button" class="btn_resp b_white btnCancelDelSetting" >아니오</button>
			</span>
		</div>
	</div>
</div>
<!-- 삭제 안내 레이어 : end -->