<?php /* Template_ 2.2.6 2022/05/17 12:36:48 /www/music_brother_firstmall_kr/admin/skin/default/popup/shipping_chg_pop.html 000005427 */ 
$TPL_grp_list_1=empty($TPL_VAR["grp_list"])||!is_array($TPL_VAR["grp_list"])?0:count($TPL_VAR["grp_list"]);
$TPL_set_list_1=empty($TPL_VAR["set_list"])||!is_array($TPL_VAR["set_list"])?0:count($TPL_VAR["set_list"]);?>
<script type="text/javascript">
// 배송그룹 변경시
function chg_grp_seq(){
	var sel_grp_seq = $("#grp_seq").val();
	$.ajax({
		type: "get",
		url: "/admin/popup/shipping_set_ajax",
		data: "sel_grp_seq="+sel_grp_seq,
		dataType : 'json',
		success: function(result){
			if	(result){
				$("#set_seq > option").remove();
				$.each(result,function(){
					$("#set_seq").append("<option value='" + this.shipping_set_seq + "' setcode='" + this.shipping_set_code + "' setname='" + this.shipping_set_name + "'>" + this.select_option_html + "</option>");
				});
			}else{
				alert('배송정보를 추출하지 못했습니다.\n새로고침후 다시시도해주세요.');
				document.location.reload();
			}
		}
	});
}

// 배송그룹 최종 변경시
function chg_shipping_info(){
	var identity_seq	= "<?php echo $TPL_VAR["identity_seq"]?>";
	var process			= "<?php echo $TPL_VAR["process"]?>";
	var p_type			= "<?php echo $TPL_VAR["p_type"]?>";
	var tbObj			= $(".shipping_info_"+identity_seq)

	var chg_grp_seq		= $("#grp_seq").val();
	var chg_set_seq		= $("#set_seq").val();
	var chg_set_name	= $("#set_seq option:selected").attr('setname');
	var chg_set_code	= $("#set_seq option:selected").attr('setcode');
	var chg_ful_grp		= chg_grp_seq + '_' + chg_set_seq + '_' + chg_set_code;

	if(process == 'after'){
		$(tbObj).find(".shipping_set_name_"+identity_seq).html(chg_set_name);
		$(tbObj).find("input[name='export_shipping_group["+identity_seq+"]']").val(chg_ful_grp);
		$(tbObj).find("input[name='export_shipping_method["+identity_seq+"]']").val(chg_set_code);
		$(tbObj).find("input[name='export_shipping_set_name["+identity_seq+"]']").val(chg_set_name);

		if(chg_set_code == 'delivery'){
			$(tbObj).find(".delivery_lay").show();
			$(tbObj).find(".address_lay").show();
			$(tbObj).find(".store_lay").hide();
		}else if(chg_set_code == 'direct_store'){
			$.ajax({
				type: "get",
				url: "/admin/popup/shipping_store_ajax",
				data: "set_seq="+chg_set_seq,
				dataType : 'json',
				success: function(result){
					if	(result){
						$(tbObj).find("select[name='export_address_seq["+identity_seq+"]'] > option").remove();
						$.each(result,function(i){
							$(tbObj).find("select[name='export_address_seq["+identity_seq+"]']").append("<option value='" + this.shipping_address_seq + "' scm_type='" + this.store_scm_type + "'>" + this.shipping_store_name + "</option>");

							if(i == 0){
								// 선번째 값을 선택값에 넣어준다.
								$(".store_scm_type_" + identity_seq).val(this.store_scm_type);
							}
						});
					}else{
						alert('매장정보를 추출하지 못했습니다.\n새로고침후 다시시도해주세요.');
					}
				}
			});

			$(tbObj).find(".delivery_lay").hide();
			$(tbObj).find(".address_lay").hide();
			$(tbObj).find(".store_lay").show();
		}else{
			$(tbObj).find(".delivery_lay").hide();
			$(tbObj).find(".address_lay").show();
			$(tbObj).find(".store_lay").hide();
		}

		if(p_type == 'export'){
			check_deliveryCompany(identity_seq);
		}
	}else{
		// 실시간 저장 처리
	}

	//console.log(p_type + ' - ' + identity_seq + ' - ' + process + '\n' + 'chg_grp_seq : ' + chg_grp_seq + ' / chg_set_seq : ' + chg_set_seq + ' / chg_set_name : ' + chg_set_name + ' / chg_set_code : ' + chg_set_code);

	closeDialog('shipping_chg_pop_area');
}
</script>

<div class="popup_lay">
	<div class="pd10">
		배송그룹 : 
		<select name="grp_seq" id="grp_seq" style="height:25px;width:70%;" onchange="chg_grp_seq();">
<?php if($TPL_grp_list_1){foreach($TPL_VAR["grp_list"] as $TPL_V1){?>
			<option value="<?php echo $TPL_V1["shipping_group_seq"]?>" <?php if($TPL_VAR["sel_group_seq"]==$TPL_V1["shipping_group_seq"]){?>selected<?php }?>><?php echo $TPL_V1["shipping_group_name"]?> (<?php echo $TPL_V1["shipping_group_seq"]?>)</option>
<?php }}?>
		</select>
	</div>
	<div class="pd10 <?php if(!$TPL_VAR["set_list"]){?>hide<?php }?>">
		배송방법 : 
		<select name="set_seq" id="set_seq" style="height:25px;width:70%;">
<?php if($TPL_set_list_1){foreach($TPL_VAR["set_list"] as $TPL_V1){?>
			<option value="<?php echo $TPL_V1["shipping_set_seq"]?>" setcode="<?php echo $TPL_V1["shipping_set_code"]?>" setname="<?php echo $TPL_V1["shipping_set_name"]?>" <?php if($TPL_VAR["sel_set_seq"]==$TPL_V1["shipping_set_seq"]){?>selected<?php }?>><?php echo $TPL_V1["select_option_html"]?></option>
<?php }}?>
		</select>
	</div>
<?php if(!$TPL_VAR["set_list"]){?>
	<div class="pd10 red">
	해당 배송그룹은 이미 삭제된 배송그룹입니다.<br/>
	변경을 원하시면 다른 배송그룹을 선택하여주세요.
	</div>
<?php }?>
	<div class="center">
<?php if($TPL_VAR["process"]=='after'){?>
		<div class="pd5 red">※ 배송그룹/방법은 출고 및 출고상태<br/>변경 처리 시 일괄 저장됩니다.</div>
<?php }?>
		<span class="btn large cyanblue"><button type="button" id="" onclick="chg_shipping_info();">변경</button></span>
	</div>
</div>