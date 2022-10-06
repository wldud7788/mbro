<?php /* Template_ 2.2.6 2022/01/25 10:32:12 /www/music_brother_firstmall_kr/admin/skin/default/broadcast/catalog_ajax.html 000002083 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php if(!$TPL_VAR["record"]){?>
<tr >
	<td colspan="9">검색된 방송이 없습니다.</td>
</tr>
<?php }else{?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
<tr bsSeq="<?php echo $TPL_V1["bsSeq"]?>">
	<td><?php echo $TPL_V1["rno"]?></td>
	<td><div class="list_thumb"><img src="<?php echo $TPL_V1["image"]?>"></div></td>
	<td class="left">
<?php if($TPL_V1["status"]=='live'){?>
		<img src="/admin/skin/default/images/broadcast/i_live2.png" class="valign-middle">
<?php }?>		
		<a class="btn-info resp_btn_txt v2"><?php echo $TPL_V1["title"]?></a>
	</td>
	<td><?php echo $TPL_V1["goodsNameFull"]?></td>
	<td><?php echo $TPL_V1["startDateTxt"]?></td>
	<td><?php echo $TPL_V1["statusTxt"]?></td>
	<td>
		<input type="hidden" id="display<?php echo $TPL_V1["bsSeq"]?>" value="<?php echo $TPL_V1["display"]?>" />
<?php if($TPL_V1["approval"]=='apply'&&($TPL_V1["status"]=='create'||$TPL_V1["status"]=='live')){?>
		<div class="btn-onoff" bsSeq="<?php echo $TPL_V1["bsSeq"]?>">
			<button type="button" class="on btn-on" id="displayBtn<?php echo $TPL_V1["bsSeq"]?>" value="<?php echo $TPL_V1["display"]?>">버튼</button>	
		</div>
<?php }?>
	</td>
	<td>
<?php if($TPL_V1["status"]=='live'||$TPL_V1["status"]=='end'){?>
		<a href="/broadcast/player?no=<?php echo $TPL_V1["bsSeq"]?>" target="_blank"><button type="button" class="resp_btn">시청하기</button></a>
<?php }?>
	</td>
	<td>
<?php if($TPL_V1["status"]=='create'){?>
		<button type="button" name="manager_modify_btn" class="resp_btn v2 btn-modify">수정</button>
		<button type="button" class="resp_btn v3 btn-drop" >삭제</button>
<?php }elseif($TPL_V1["status"]=='cancel'||$TPL_V1["status"]=='end'){?>
		<button type="button" class="resp_btn v3 btn-delete" >삭제</button>
<?php }?>
	</td>
</tr>
<?php }}?>
<?php }?>