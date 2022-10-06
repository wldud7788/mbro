<?php /* Template_ 2.2.6 2022/01/25 10:32:12 /www/music_brother_firstmall_kr/admin/skin/default/broadcast/vod_ajax.html 000001706 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php if(!$TPL_VAR["record"]){?>
<tr >
	<td colspan="11">검색된 방송이 없습니다.</td>
</tr>
<?php }else{?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
<tr bsSeq="<?php echo $TPL_V1["bsSeq"]?>">
	<td class="center">
		<label class='resp_checkbox'><input type="checkbox" class="chk" name="bs_seq[]" value="<?php echo $TPL_V1["bsSeq"]?>" /></label>
	</td>
	<td><?php echo $TPL_V1["rno"]?></td>
	<td><div class="list_thumb"><img src="<?php echo $TPL_V1["image"]?>"></div></td>
	<td class="left">
		<a class="btn-info resp_btn_txt v2"><?php echo $TPL_V1["title"]?></a>
	</td>
	<td><?php echo $TPL_V1["goodsName"]?></td>
	<td><?php echo $TPL_V1["startDateTxt"]?></td>
	<td><?php echo $TPL_V1["sumvisitors"]?></td>
	<td><?php echo $TPL_V1["likes"]?></td>
	<td>
<?php if($TPL_V1["vodKey"]!='null'){?>
		<a href="/broadcast/vod?no=<?php echo $TPL_V1["bsSeq"]?>" target="_blank"><button type="button" class="resp_btn">시청하기</button></a>
<?php }?>
	</td>
	<td>
		<input type="hidden" id="display<?php echo $TPL_V1["bsSeq"]?>" value="<?php echo $TPL_V1["display"]?>" />
		<div class="btn-onoff" bsSeq="<?php echo $TPL_V1["bsSeq"]?>">
			<button type="button" class="on btn-on" id="displayBtn<?php echo $TPL_V1["bsSeq"]?>" value="<?php echo $TPL_V1["display"]?>">버튼</button>	
		</div>
	</td>
	<td>
		<button type="button" class="resp_btn v3 btn-delete" >삭제</button>
	</td>
</tr>
<?php }}?>
<?php }?>