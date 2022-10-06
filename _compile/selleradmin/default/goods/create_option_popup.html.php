<?php /* Template_ 2.2.6 2022/05/17 12:29:08 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/create_option_popup.html 000005570 */ 
$TPL_goodsoptionloop_1=empty($TPL_VAR["goodsoptionloop"])||!is_array($TPL_VAR["goodsoptionloop"])?0:count($TPL_VAR["goodsoptionloop"]);?>
<form name="optPopFrm" method="post" action="../goods_process/<?php echo $TPL_VAR["submitFunc"]?>" target="actionFrame">
<input type="hidden" name="goods_seq" value="<?php echo $TPL_VAR["goods_seq"]?>" />
<input type="hidden" name="tmp_seq" value="<?php echo $TPL_VAR["tmp_seq"]?>" />
<input type="hidden" name="popup_id" value="<?php echo $TPL_VAR["popup_id"]?>" />
<table class="info-table-style" style="width:100%">
<colgroup>
	<col width="1%" />
	<col />
	<col />
	<col />
	<col width="18%" />
	<col />
</colgroup>
<thead>
<tr>
	<th class="its-th-align center"></th>
	<th class="its-th-align center">
		옵션정보 가져오기
	</th>
	<th class="its-th-align center">
		옵션명
		[특수옵션선택]
	</th>
	<th class="its-th-align center">
		옵션값 → ','(콤마)로 구분
	</th>
	<th class="its-th-align center">
		옵션가격 → ','(콤마)로 구분
	</th>
	<th class="its-th-align center">
		옵션 코드 → ','(콤마)로 구분
	</th>
</tr>
</thead>
<tbody>
<tr>
	<td class="its-td-align center pmbtn">
		<span class="btn-plus  btnplusminus" onclick="addOptionRow(this);"><button type="button"></button></span>
	</td>
	<td class="its-td-align center">
		<select name="option_type[]" class="line simple" onchange="select_option_type(this);">
<?php if($TPL_goodsoptionloop_1){foreach($TPL_VAR["goodsoptionloop"] as $TPL_V1){?>
<?php if($TPL_V1["label_newtype"]=='color'||!$TPL_V1["label_newtype"]||$TPL_V1["label_newtype"]=='none'){?>
			<option value="goodsoption_<?php echo $TPL_V1["codeform_seq"]?>" label_type="<?php echo $TPL_V1["label_type"]?>" label_title="<?php echo $TPL_V1["label_title"]?>"  label_newtype="<?php echo $TPL_V1["label_newtype"]?>"><?php if($TPL_V1["label_newtype"]&&$TPL_V1["label_newtype"]!='none'){?>[특수]<?php }?><?php echo $TPL_V1["label_title"]?></option>
<?php }?>
<?php }}?>
			<option value="direct" selected>직접입력</option>
		</select>
	</td>
	<td class="its-td-align center">
		<input type="text" name="option_title[]" class="line" size="10" value="" title="예) 사이즈" />
		<span class="option-type-direct-lay">
			<select name="option_new_type[]" class="line simple" onchange="chg_option_type(this);">
				<option value="none" >특수 정보</option>
				<option value="color" >색상</option>
			</select>
		</span>
		<span class="option-type-codeform-lay btn-lay hide">
			<span class="btn small gray"><button type="button" onclick="select_load_option(this);">선택</button></span>
		</span>
	</td>
	<td class="its-td-align left pdl5">
		<span class="option-type-direct-lay">
			<input type="text" name="option_value[]" class="line" size="30" value="" title="예) 90, 95, 100" onblur="option_blur_event(this);" />
			<input type="hidden" name="option_color[]" />
		</span>
		<span class="option-type-codeform-lay text-lay hide"></span>
		<div class="option-color-box-lay hide"></div>
	</td>
	<td class="its-td-align left pdl5">
		<input type="text" name="option_price[]" class="line" size="25" value="" title="예) 0,0,0" />
	</td>
	<td class="its-td-align left pdl5">
		<span class="option-type-direct-lay">
			<input type="text" name="option_code[]" class="line" size="30" value="" title="예) A090,A095,A100" />
		</span>
		<span class="option-type-codeform-lay text-lay hide"></span>
	</td>
</tr>
</tbody>
</table>
</form>

<div style="margin-top:20px;width:100%;text-align:center;">
	<span class="btn large"><button type="button" onclick="create_option_submit();">옵션 생성</button></span>
</div>

<?php if($TPL_goodsoptionloop_1){foreach($TPL_VAR["goodsoptionloop"] as $TPL_V1){?>
<?php if($TPL_V1["label_newtype"]=='color'||!$TPL_V1["label_newtype"]||$TPL_V1["label_newtype"]=='none'){?>
<div id="goodsoption_<?php echo $TPL_V1["codeform_seq"]?>" class="goodsoption_wrap hide">
	<input type="hidden" class="row-idx" value="test" />

	<div style="margin:20px 0;width:100%;text-align:center;">
		<span class="btn large"><button type="button" onclick="apply_load_optionform(this);">적용</button></span>
	</div>

	<table class="info-table-style" style="width:100%">
	<thead>
	<tr>
		<th class="its-th-align center"><?php echo $TPL_V1["label_title"]?></th>
		<th class="its-th-align center">코드값</th>
	</tr>
	</thead>
	<tbody>
<?php if(is_array($TPL_R2=$TPL_V1["code_arr"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<tr>
		<td class="its-td-align left pdl5">
			<label><input type="checkbox" class="chk-code" value="<?php echo $TPL_V2["value"]?>" code="<?php echo $TPL_V2["code"]?>" color="<?php echo $TPL_V2["colors"]?>" newType="<?php echo $TPL_V1["label_newtype"]?>" <?php if($TPL_V2["default"]=='Y'){?>checked<?php }?> /> <?php echo $TPL_V2["value"]?>

<?php if($TPL_V1["label_newtype"]=='color'){?>
				→<div class="colorPickerBtn colorhelpicon" style="background-color:<?php echo $TPL_V2["colors"]?>" ></div>
<?php }?>
			</label>
		</td>
		<td class="its-td-align left pdl5"><?php echo $TPL_V2["code"]?></td>
	</tr>
<?php }}?>
	</tbody>
	</table>

	<div style="margin:20px 0;width:100%;text-align:center;">
		<span class="btn large"><button type="button" onclick="apply_load_optionform(this);">적용</button></span>
	</div>
</div>
<?php }?>
<?php }}?>