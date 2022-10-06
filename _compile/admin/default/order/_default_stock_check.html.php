<?php /* Template_ 2.2.6 2022/05/17 12:36:42 /www/music_brother_firstmall_kr/admin/skin/default/order/_default_stock_check.html 000002433 */ ?>
<form method="post" action="../provider_process/default_stock_check" name="default_stock_check_form" target="actionFrame">
<table class="export_table" style="border-collapse:collapse" border='1'>
<tr>
	<td class="bold center" style="background:#efefef;">
		<div class="pd5">
		'출고완료'처리 시 아래와 같은 기준으로 처리됩니다.
		</div>
	</td>
</tr>
<tr>
	<td>
		<div>
		실물 :
			<select name="default_export_stock_check" style="width:330px;" <?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>onchange="this.options[0].selected=true;"<?php }?>>
				<option value="limit" <?php if($TPL_VAR["data_present_provider"]["default_export_stock_check"]=='limit'){?>selected<?php }?>>출고되는 모든 실물의 재고가 있으면</option>
				<option value="unlimit" <?php if($TPL_VAR["data_present_provider"]["default_export_stock_check"]=='unlimit'){?>selected<?php }?> <?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>style="background-color:#cdcdcd;"<?php }?>>출고되는 모든 실물의 재고가 부족해도</option>
			</select> → 재고 차감 → (설정 시) SMS/EMAIL 발송 →
			<input type="hidden" name="default_export_stock_step" value="55" />
			<strong>출고완료</strong>로 상태 처리
		</div>
		<div class="pdt5">
			티켓 :
			<select name="default_export_ticket_stock_check" style="width:330px;" <?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>onchange="this.options[0].selected=true;"<?php }?>>
				<option value="limit" <?php if($TPL_VAR["data_present_provider"]["default_export_ticket_stock_check"]=='limit'){?>selected<?php }?>>출고되는 모든 티켓의 재고가 있고 티켓번호가 있으면</option>
				<option value="limit_ticket" <?php if($TPL_VAR["data_present_provider"]["default_export_ticket_stock_check"]=='limit_ticket'){?>selected<?php }?>>출고되는 모든 티켓의 재고가 부족해도 티켓번호가 있으면</option>
			</select> → 재고 차감 → (설정 시) SMS/EMAIL 발송 →
			<input type="hidden" name="default_export_ticket_stock_step" value="55" />
			<strong>출고완료</strong>로 상태 처리
		</div>
		</td>
	</tr>
</table>

<div class="pdt10" align="center">
	<span class="btn large cyanblue" ><button type="submit">저장</button></span>
</div>

</form>