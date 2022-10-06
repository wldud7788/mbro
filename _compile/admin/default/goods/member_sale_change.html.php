<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/goods/member_sale_change.html 000005250 */ 
$TPL_sale_data_1=empty($TPL_VAR["sale_data"])||!is_array($TPL_VAR["sale_data"])?0:count($TPL_VAR["sale_data"]);
$TPL_sale_list_1=empty($TPL_VAR["sale_list"])||!is_array($TPL_VAR["sale_list"])?0:count($TPL_VAR["sale_list"]);?>
<?php if($_GET["sale_seq"]){?>
<?php if($TPL_sale_data_1){foreach($TPL_VAR["sale_data"] as $TPL_V1){?>
<tr>
	<td rowspan="6" class="its-td-align center">
		<select name="sale_seq" onchange="sale_change(this.value);">
			<option value="">혜택 세트 선택</option>
<?php if(is_array($TPL_R2=$TPL_V1["sale_list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
			<option value="<?php echo $TPL_V2["sale_seq"]?>" <?php if($TPL_V2["sale_seq"]==$_GET["sale_seq"]){?>selected<?php }?>><?php echo $TPL_V2["sale_title"]?></option>
<?php }}?>
		</select>
	</td>
	<td rowspan="3" class="its-td-align center">추가할인</td>
	<td class="its-td-align center">조건</td>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td class="its-td-align" style="padding-left:5px;">
<?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_use"]=="N"){?>조건없음<?php }else{?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_limit_price"]?> <?php echo $TPL_VAR["config_system"]['basic_currency']?> 이상 구매<?php }?>
	</td>
<?php }}?>
</tr>
<tr>
	<td class="its-td-align center">할인</td>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td class="its-td-align" style="padding-left:5px;">
		<?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_price"]?><?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_price_type"]=="PER"){?>%<?php }else{?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_price_type"]?><?php }?> 할인
	</td>
<?php }}?>
</tr>
<tr>
	<td class="its-td-align center">추가옵션</td>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td class="its-td-align" style="padding-left:5px;">
		<?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_option_price"]?><?php if($TPL_V1[$TPL_V2["group_seq"]]["sale_option_price_type"]=="PER"){?>%<?php }else{?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["sale_option_price_type"]?><?php }?> 할인
	</td>
<?php }}?>
</tr>
<tr>
	<td rowspan="3" class="its-td-align center">추가적립</td>
	<td class="its-td-align center">조건</td>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td class="its-td-align" style="padding-left:5px;">
<?php if($TPL_V1[$TPL_V2["group_seq"]]["point_use"]=="N"){?>조건없음<?php }else{?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["point_limit_price"]?> <?php echo $TPL_VAR["config_system"]['basic_currency']?> 이상 구매<?php }?>
	</td>
<?php }}?>
</tr>
<tr>
	<td class="its-td-align center">마일리지</td>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td class="its-td-align" style="padding-left:5px;">

		<?php echo $TPL_V1[$TPL_V2["group_seq"]]["reserve_price"]?>%

<?php if($TPL_V1[$TPL_V2["group_seq"]]["reserve_select"]=='year'){?>지급연도 + <?php echo $TPL_V1[$TPL_V2["group_seq"]]["reserve_year"]?>년 12월 31일
<?php }elseif($TPL_V1[$TPL_V2["group_seq"]]["reserve_select"]=='direct'){?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["reserve_direct"]?>개월
<?php }else{?>
		적립
<?php }?>
	</td>
<?php }}?>
</tr>

<tr>
	<td class="its-td-align center">포인트</td>
<?php if(is_array($TPL_R2=$TPL_V1["loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
	<td class="its-td-align" style="padding-left:5px;">
		<?php echo $TPL_V1[$TPL_V2["group_seq"]]["point_price"]?>%

<?php if($TPL_V1[$TPL_V2["group_seq"]]["point_select"]=='year'){?>지급연도 + <?php echo $TPL_V1[$TPL_V2["group_seq"]]["point_year"]?>년 12월 31일
<?php }elseif($TPL_V1[$TPL_V2["group_seq"]]["point_select"]=='direct'){?><?php echo $TPL_V1[$TPL_V2["group_seq"]]["point_direct"]?>개월
<?php }else{?>
		적립
<?php }?>
	</td>
<?php }}?>
</tr>
<?php }}?>

<?php }else{?>

<tr>
	<td rowspan="6" class="its-td-align center">
		<select name="sale_seq" onchange="sale_change(this.value);">
			<option value="">혜택 세트 선택</option>
<?php if($TPL_sale_list_1){foreach($TPL_VAR["sale_list"] as $TPL_V1){?>
			<option value="<?php echo $TPL_V1["sale_seq"]?>" <?php if($TPL_V1["sale_seq"]==$_GET["sale_seq"]){?>selected<?php }?>><?php echo $TPL_V1["sale_title"]?></option>
<?php }}?>
		</select>
	</td>
	<td rowspan="3" class="its-td-align center">추가할인</td>
	<td class="its-td-align center">조건</td>
	<td rowspan="6" colspan="<?php echo $TPL_VAR["gcount"]?>" class="its-td-align center">
		등급별 할인 세트를 선택하세요
	</td>
</tr>
<tr><td class="its-td-align center">할인</td></tr>
<tr><td class="its-td-align center">추가옵션</td></tr>
<tr>
	<td rowspan="3" class="its-td-align center">추가적립</td>
	<td class="its-td-align center">조건</td>
</tr>
<tr><td class="its-td-align center">마일리지</td></tr>
<tr><td class="its-td-align center">포인트</td></tr>
<?php }?>