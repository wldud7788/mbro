<?php /* Template_ 2.2.6 2022/05/17 12:36:48 /www/music_brother_firstmall_kr/admin/skin/default/popup/shipping_desc_pop.html 000001308 */ ?>
<div class="delivery-info-lay">
	<div class="right pdb5">
		<input type="button" class="resp_btn" onclick="auto_info_pop();" value="자동안내 설명" />
	</div>
<?php if($TPL_VAR["desc"]["std"]||$TPL_VAR["desc"]["add"]){?>
	<table class="table_basic thl">
	<col width="30%"/><col width="70%"/>
<?php if($TPL_VAR["desc"]["std"]){?>
	<tr>
		<th>기본 배송비</th>
		<td><?php echo $TPL_VAR["desc"]["std"]?></td>
	</tr>
<?php }?>
<?php if($TPL_VAR["desc"]["add"]){?>
	<tr>
		<th>추가 배송비</th>
		<td><?php echo $TPL_VAR["desc"]["add"]?></td>
	</tr>
<?php }?>
	</table>
<?php }else{?>
	<div>배송그룹을 다시한번 저장해주세요.</div>
<?php }?>
	<div class="resp_message">
		- 상기 문구는 해당 배송그룹 해당 배송방법에서 자동안내 또는 직접입력 가능합니다.
	</div>

	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>

<!-- 자동안내 설명 :: START -->
<div class="hide" id="autoinfoPopup">
<?php $this->print_("delivery_desc",$TPL_SCP,1);?>

</div>
<!-- 자동안내 설명 :: END -->