<?php /* Template_ 2.2.6 2022/05/17 12:05:21 /www/music_brother_firstmall_kr/admincrm/skin/default/board/get_blacklist.html 000003797 */ 
$TPL_blackList_1=empty($TPL_VAR["blackList"])||!is_array($TPL_VAR["blackList"])?0:count($TPL_VAR["blackList"]);?>
<div class="th">
	악성내역 &nbsp;
	<span class="btn small"><button type="button" id="blacklist">등록</button></span>
	<span class="btn small"><button type="button" id="blacklistInit">초기화</button></span>
</div>
<?php if($TPL_VAR["blackList"]){?>
<?php if($TPL_blackList_1){foreach($TPL_VAR["blackList"] as $TPL_V1){?>	
<?php if($TPL_V1["blacklist_level"]> 0){?>						
			<div id="blacklistOff<?php echo $TPL_V1["blacklist_seq"]?>" class="blacklistOffDiv" blacklist_seq="<?php echo $TPL_V1["blacklist_seq"]?>">
				<table class="info-table-style list" style="width:100%">
					<colgroup>
						<col width="28%" />
						<col />
					</colgroup>
					<tbody>
						<tr>
							<th class="its-th"><img src="/admin/skin/default/images/blacklist/devil.png" align="absmiddle"> x<?php echo $TPL_V1["blacklist_level"]?></th>
							<td class="its-th" style="border-left:0">
								<?php echo getstrcut($TPL_V1["blacklist_contents"], 10)?>

								<span class="blacklistOpen absolute" style="right:5px">▼</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="blacklistOn<?php echo $TPL_V1["blacklist_seq"]?>" class="blacklistOnDiv hide" >
				<table class="info-table-style list" style="width:100%">
					<colgroup>
						<col width="28%" />
						<col />
					</colgroup>
					<tbody>
						<tr>
							<th class="its-th"><img src="/admin/skin/default/images/blacklist/devil.png" align="absmiddle"> x<?php echo $TPL_V1["blacklist_level"]?></th>
							<td class="its-th blacklistOnTd" style="border-left:0" blacklist_seq="<?php echo $TPL_V1["blacklist_seq"]?>">
								<?php echo $TPL_V1["blacklist_regist_manager"]?>

								<span class="desc">(<?php echo $TPL_V1["blacklist_regist_date"]?>)</span>
								<span class="absolute" style="right:5px">▲</span>
							</td>
						</tr>
						<tr>
							<td colspan="3" class="its-td">
								<?php echo $TPL_V1["blacklist_contents"]?>

							</td>
						</tr>
						<tr>
							<td colspan="3" class="its-td">
								<span class="btn small"><button type="button" name="blacklist_modify" onclick="customer_commnet_load(<?php echo $TPL_V1["blacklist_seq"]?>)">수정</button></span></div>
								<span class="btn small"><button type="button" name="blacklist_delete" onclick="customer_commnet_del(<?php echo $TPL_V1["blacklist_seq"]?>)">삭제</button></span></div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
<?php }else{?>
			<div id="blacklistOff" class="blacklistOffDiv" blacklist_seq="<?php echo $TPL_V1["blacklist_seq"]?>">
				<table class="info-table-style list" style="width:100%">
					<colgroup>
						<col width="40%" />
						<col />
					</colgroup>
					<tbody>
						<tr>
							<th class="its-th"><?php echo $TPL_V1["blacklist_contents"]?></th>
							<td class="its-th" style="border-left:0;font-size: 11px;">
								<?php echo $TPL_V1["blacklist_regist_manager"]?><br />(<?php echo $TPL_V1["blacklist_regist_date"]?>)
							</td>
						</tr>
					</tbody>
				</table>
			</div>
<?php }?>
<?php }}?>
	<div class="paging_navigation" style="margin:auto;">
<?php if(is_array($TPL_R1=$TPL_VAR["blackListpage"]["page"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
			<a <?php if($_POST["page"]==($TPL_I1+ 1)){?>class="on"<?php }?> href="javascript:get_black_list(<?php echo $TPL_V1?>);"><?php echo $TPL_V1?></a>
<?php }}?>
	</div>
<?php }else{?>
	<div class="nodata">악성 고객이 아닙니다.</div>
<?php }?>