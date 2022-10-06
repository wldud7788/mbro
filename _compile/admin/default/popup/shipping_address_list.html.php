<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/popup/shipping_address_list.html 000005059 */ 
$TPL_category_1=empty($TPL_VAR["category"])||!is_array($TPL_VAR["category"])?0:count($TPL_VAR["category"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
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
		$("input[name='add_chk[]']").each(function(){ $(this).trigger('click'); });
	}else{
		$("input[name='add_chk[]']").prop('checked',false);
	}
}
</script>

<?php if($TPL_VAR["msg"]){?>
<div class="center pdt20">
	<?php echo $TPL_VAR["msg"]?>

</div>
<?php }else{?>
<table class="table_basic">
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
	<th class="hide">관리</th>
<?php }?>
</tr>
</thead>
<tbody>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<tr class="address_tr_<?php echo $TPL_V1["shipping_address_seq"]?>" add_type="<?php echo $TPL_V1["add_type"]?>"
	wh_use="<?php if($TPL_V1["wh_use"]){?><?php echo $TPL_V1["wh_use"]?><?php }else{?>N<?php }?>"
	store_scm_seq="<?php if($TPL_V1["wh_use"]){?><?php echo $TPL_V1["store_scm_seq"]?><?php }else{?><?php }?>"
	>
	<td class="center nonpd" height="30">
		<label class="resp_checkbox"><input type="checkbox" name="add_chk[]" value="<?php echo $TPL_V1["shipping_address_seq"]?>" <?php if($TPL_V1["wh_use"]=='N'){?>disabled<?php }?> /></label>
	</td>
	<td class="center nonpd"><?php echo $TPL_V1["_rno"]?></td>
	<td class="center nonpd category"><?php echo $TPL_V1["address_category"]?></td>
	<td>
		<div class="address_name"><?php echo $TPL_V1["address_name"]?></div>
<?php if($TPL_V1["wh_use"]=='Y'){?>
		<div class="blue address_use">(사용 창고)</div>
<?php }elseif($TPL_V1["wh_use"]=='N'){?>
		<div class="red address_use">(미사용 창고)</div>
<?php }?>
	</td>
	<td class="center nonpd nation"><?php if($TPL_V1["address_nation"]=='korea'){?>N<?php }else{?>Y<?php }?></td>
	<td class="address">
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
	<td class="center nonpd shipping_phone"><?php echo $TPL_V1["shipping_phone"]?></td>
<?php if($TPL_VAR["tabtype"]=='input'){?>
	<td class="hide center nonpd">
		<button type="button" onclick="insert_address_pop('<?php echo $TPL_V1["shipping_address_seq"]?>');" class="btn_resp">수정</button>
	</td>
<?php }?>
</tr>
<?php }}?>
<?php }else{?>
<tr>
	<td colspan="8" class="center">
<?php if($_GET["tabType"]=='o2o'){?>
			오프라인 매장 설정에서 매장 등록 시 자동으로 등록됩니다.
<?php }else{?>
<?php if($TPL_VAR["sc"]){?>
			검색된 장소리스트가 없습니다.
<?php }else{?>
			설정된 장소리스트가 없습니다.
<?php }?>
<?php }?>
	</td>
</tr>
<?php }?>
</tbody>
</table>

<div class="paging_navigation" style="padding-top:20px; margin:auto;"><?php echo $TPL_VAR["page"]["html"]?></div>
<?php }?>