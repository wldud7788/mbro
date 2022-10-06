<?php /* Template_ 2.2.6 2022/05/17 12:36:51 /www/music_brother_firstmall_kr/admin/skin/default/provider/_gl_select_provider.html 000003341 */ 
$TPL_result_1=empty($TPL_VAR["result"])||!is_array($TPL_VAR["result"])?0:count($TPL_VAR["result"]);?>
<script type="text/javascript">
document.addEventListener('keydown', function(event) {
  if (event.keyCode === 13) {
    //gProviderSelect.searchProvider(1);
  };
}, true);
</script>

<div class="content">
<div class="item-title">입점사 검색</div>

<form name="selectProviderFrm" method="post" onSubmit="return false">
<input type="hidden" name="select_providers" value="<?php echo implode('|',$TPL_VAR["sc"]["select_providers"])?>">
	<div class="search_container">
		<table class="table_search">	
			<tr>
				<th>입점사명</th>
				<td>
					<input type="text" name="sc_provider_name" style="width:55%;" value="<?php echo $TPL_VAR["sc"]["sc_provider_name"]?>" class="resp_text" />

					<!-- <?php if($TPL_VAR["shippingtype"]> 0){?> -->
					<div style="width:100%;">
						<label><input type="radio" name="src_provider_gb" value="company" <?php if($TPL_VAR["default_deli_group"]!='provider'){?>checked<?php }?> /> 본사배송</label>
						<label><input type="radio" name="src_provider_gb" value="provider" <?php if($TPL_VAR["default_deli_group"]=='provider'){?>checked<?php }?> /> 입점사배송</label>
					</div>
					<!-- <?php }?> -->	
					
					<button type="submit" class="resp_btn active " id="btn_src_provider">검색</button>		
				</td>
			</tr>
		</table>
	</div>

	<table class="table_basic provider_list">
		<colgroup>
			<col width="10%" />
			<col width="50%" />
			<col width="40%" />
		</colgroup>
		<thead>
			<tr class="nodrag nodrop">
				<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" title="전체선택" ></label></th>
				<th>입점사명</th>
				<th>정산 방식</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["result"]){?>
<?php if($TPL_result_1){foreach($TPL_VAR["result"] as $TPL_V1){?>
			<tr rownum="<?php echo $TPL_V1["provider_seq"]?>" <?php if(in_array($TPL_V1["provider_seq"],$TPL_VAR["sc"]["select_lists"])){?>class="bg-gray"<?php }?>>
				<td class="center">
<?php if(!in_array($TPL_V1["provider_seq"],$TPL_VAR["sc"]["select_lists"])){?>
					<label class="resp_checkbox"><input type="checkbox" name="providerSeq[]" class="chk" value="<?php echo $TPL_V1["provider_seq"]?>"></label>
					<input type="hidden" name="providerName[]" value="<?php echo $TPL_V1["provider_name"]?>">
					<input type="hidden" name="providerCommission[]" value="<?php echo $TPL_V1["commission_text"]?>">
<?php }?>
				</td>
				<td class="center"><?php echo $TPL_V1["provider_name"]?></td>
				<td class="center"><?php echo $TPL_V1["commission_text"]?> (<?php echo $TPL_V1["commission_charge"]?>)</td>
			</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td class="center" colspan="3">검색된 입점사가 없습니다.</td>
			</tr>
<?php }?>
		</tbody>
	</table>

	</form>

	<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

</div>

<div class="footer">
	<button type="button" class="confirmSelectProvider resp_btn active size_XL">선택</button>
	<button type="button" class="btnLayClose resp_btn v3 size_XL">닫기</button>
</div>