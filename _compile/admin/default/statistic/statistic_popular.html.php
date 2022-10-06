<?php /* Template_ 2.2.6 2022/05/17 12:37:06 /www/music_brother_firstmall_kr/admin/skin/default/statistic/statistic_popular.html 000002440 */ ?>
<div class="sub-wrap">
	<div class="sub-select-bar">
		<select name="catenbrand" class="sub-selectbox <?php echo $_GET["catenbrand"]?>">
			<option class="category" value="category" <?php if($_GET["catenbrand"]=='category'){?>selected<?php }?>>비교 - 동일 카테고리</option>
			<option class="brand" value="brand" <?php if($_GET["catenbrand"]=='brand'){?>selected<?php }?>>비교 - 동일 브랜드</option>
		</select>
	</div>

	<table cellspacing="0" cellpadding="0" class="stistic-data-table">
	<colgroup>
		<col width="25%" />
		<col width="25%" />
		<col width="25%" />
		<col width="25%" />
	</colgroup>
	<thead>
	<tr>
		<th class="nleftline">장바구니<div class="tcount">총 <?php echo number_format($TPL_VAR["stat"]["total"]["cart"])?>명</div></th>
		<th>위시리스트<div class="tcount">총 <?php echo number_format($TPL_VAR["stat"]["total"]["wish"])?>명</div></th>
		<th>좋아요<div class="tcount">총 <?php echo number_format($TPL_VAR["stat"]["total"]["like"])?>명</div></th>
		<th>재입고알림<div class="tcount">총 <?php echo number_format($TPL_VAR["stat"]["total"]["restock"])?>명</div></th>
	</tr>
	</thead>
	<tbody>
<?php if(is_array($TPL_R1=range( 0,count($TPL_VAR["rank_array"])- 1))&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
	<tr class="<?php echo $TPL_VAR["rank_array"][$TPL_I1]?>-tr">
<?php if(is_array($TPL_R2=$TPL_VAR["stat"]["rank"][$TPL_I1])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_I2> 0){?><td><?php }else{?><td class="nleftline"><?php }?>
<?php if($TPL_V2["goods_seq"]){?>
			<table cellspacing="0" cellpadding="0" class="lank-table <?php echo $_GET["catenbrand"]?>">
			<tr>
				<td class="rank-td"><?php echo ($TPL_I1+ 1)?>위</td>
				<td class="image-td" rowspan="2">
					<img class="small_goods_image" src="<?php echo viewImg($TPL_V2["goods_seq"],'thumbView')?>" onerror="this.src='/data/icon/error/noimage_list.gif';"  width="32" height="32" />
				</td>
				<td class="name-td" rowspan="2"><?php echo $TPL_V2["goods_name"]?></td>
			</tr>
			<tr>
				<td class="count-td"><?php echo number_format($TPL_V2["cnt"])?>명</td>
			</tr>
			</table>
<?php }?>
		</td>
<?php }}?>
	</tr>
<?php }}?>
	</tbody>
	</table>
</div>