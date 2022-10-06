<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/popup/groupsale_choice.html 000002457 */ 
$TPL_group_sale_lists_1=empty($TPL_VAR["group_sale_lists"])||!is_array($TPL_VAR["group_sale_lists"])?0:count($TPL_VAR["group_sale_lists"]);?>
<script type="text/javascript">
<!--
$(function(){
	// default-set
	var p_sale_seq = $("[name='sale_seq']").val();
	$("input:radio[name='p_sale_seq']:input[value='"+p_sale_seq+"']").attr('checked', true);

	// event
	$("button[name='submit_btn']").click(function(){
		var p_sale_seq = $('[name="p_sale_seq"]:checked').val()||'';

		if(!p_sale_seq) {
			openDialogAlert('적용할 <b>회원 등급별 혜택 세트</b>를 선택해주세요.');
			return false;
		}

		typeof groupsale_choice == 'function' && groupsale_choice(p_sale_seq);
		closeDialog('groupScalePopup');
	});

	$("button[name='cancel_btn']").bind("click",function(){
		closeDialog('groupScalePopup');
	});
});
//-->
</script>

<table width="100%" cellpadding="0" cellspacing="0" class="info-table-style">
	<thead>
		<th class="its-th-align">회원 등급별 혜택 세트</th>
	</thead>
	<tbody>
<?php if($TPL_group_sale_lists_1){foreach($TPL_VAR["group_sale_lists"] as $TPL_V1){?>
	<tr><td class="its-td-align" style="padding-top:10px; padding-bottom:10px;"><label style="margin-left:10px;"><input type="radio" name="p_sale_seq" value="<?php echo $TPL_V1["sale_seq"]?>" /> <?php echo $TPL_V1["sale_title"]?> (<?php echo $TPL_V1["sale_seq"]?>)</label></td></tr>
<?php }}else{?>
	<tr><td class="its-td-align center" style="padding-top:10px; padding-bottom:10px;">적용가능한 <b>회원 등급별 혜택 세트</b>가 존재하지 않습니다.</td></tr>
<?php }?>
	</tbody>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:10px;">
	<tbody>
		<tr>
			<td>
				회원 등급별 혜택 세트 설정 : <span class="highlight-link hand" onclick="window.open('../setting/member?gb=member_sale');">설정>회원 : 등급별구매혜택 탭.</span><br/>
				적용된 혜택 세트가 삭제될 경우 해당 상품의 회원 등급 혜택은 없어집니다.
			</td>
		</tr>
	</tbody>
</table>

<p align="center" style="margin-top:20px;">
	<span class="btn large"><button name="submit_btn" class="submit_btn">적용</button></span>
	<span class="btn large"><button id="cancel_btn" name="cancel_btn">취소</button></span>
</p>