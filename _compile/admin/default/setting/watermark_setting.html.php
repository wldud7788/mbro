<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/setting/watermark_setting.html 000004628 */ ?>
<style>
.popoup-item-title {	
	background-image:url('/admin/skin/default/images/common/bullet_tit_m.gif');
	background-repeat:no-repeat;
	font-family:"돋움",Dotum,AppleGothic,sans-serif;
	font-size:14px;
	font-weight:bold;
	padding-left:20px; 

}
</style>
<form name="watermark_setting_form" enctype="multipart/form-data" method="post" action="../setting_process/watermark_setting" target="actionFrame">
<div class="popoup-item-title">워터마크 이미지 및 스타일 </div>
<?php if($TPL_VAR["config_watermark"]["watermark_image"]){?>
<div style="padding-top:10px"><label><input type="radio" name="remove_watermark" value='2' checked> 기존 워터마크 사용</label></div>
<div style="padding-left:10px"><img src='<?php echo $TPL_VAR["config_watermark"]["watermark_image"]?>' border="0"  style="max-height:100px";></div>
<?php }?>

<div style="padding-top:10px">
	<label><input type="radio" name="remove_watermark" value='0' <?php if(!$TPL_VAR["config_watermark"]["watermark_image"]){?>checked<?php }?>> 워터마크 적용
	<input type="file" name="watermark_file" size="30" class="line" style="height:20px;"  />
	<span class="desc" style="font-weight:normal">투명한 파일(확장자 .PNG)을 등록 하세요</span></label>
</div>

<div style="height:10px"></div>
<table width="100%" cellspacing="3">
	<col width="50%" /><col width="50%" />
	<tr>
		<td valign="top">		
		<label><input type="radio" name="watermark_type" value="cross"> 워터마크 대각선 반복</label>
		<div style="height:5px;"></div>
		<div style="width:298px;height:186px;background-image:url('/admin/skin/default/images/common/watermark_sample_diagonal.gif');"></div>
		</td>
		<td valign="top">
		<label><input type="radio" name="watermark_type" value="position"> 워터마크 위치 선택</label>
		<div style="height:5px;"></div>
		<table style="width:298px;height:186px;background-image:url('/admin/skin/default/images/common/watermark_sample_position.gif');">
			<tr>
				<td class="center"><label>&nbsp;&nbsp;<input type="checkbox" name="watermark_position[]" value="0">&nbsp;&nbsp;</label></td>
				<td class="center"><label>&nbsp;&nbsp;<input type="checkbox" name="watermark_position[]" value="1">&nbsp;&nbsp;</label></td>
				<td class="center"><label>&nbsp;&nbsp;<input type="checkbox" name="watermark_position[]" value="2">&nbsp;&nbsp;</label></td>
			</tr>
			<tr>
				<td class="center"><label>&nbsp;&nbsp;<input type="checkbox" name="watermark_position[]" value="3">&nbsp;&nbsp;</label></td>
				<td class="center"><label>&nbsp;&nbsp;<input type="checkbox" name="watermark_position[]" value="4">&nbsp;&nbsp;</label></td>
				<td class="center"><label>&nbsp;&nbsp;<input type="checkbox" name="watermark_position[]" value="5">&nbsp;&nbsp;</label></td>
			</tr>
			<tr>
				<td class="center"><label>&nbsp;&nbsp;<input type="checkbox" name="watermark_position[]" value="6">&nbsp;&nbsp;</label></td>
				<td class="center"><label>&nbsp;&nbsp;<input type="checkbox" name="watermark_position[]" value="7">&nbsp;&nbsp;</label></td>
				<td class="center"><label>&nbsp;&nbsp;<input type="checkbox" name="watermark_position[]" value="8">&nbsp;&nbsp;</label></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<div align="center" style="padding-top:15px">
<span class="btn large black"><button type="submit">저장하기</button></span>
<span class="btn large gray"><button type="button" onclick="closeDialog('<?php echo $_GET["layerid"]?>');">취소</button></span>
</div>
</form>
<div style="height:15px;"></div>
<div style="font-family:thaoma;font-size:12px;padding:10px 10px 10px 10px;border:1px solid #cccccc;">
<strong>워터마크 적용 방법 안내</strong><br/>
1. 워터마크 이미지와 스타일을 설정합니다.<br/>
2. 상품 등록 후 상품 수정(또는 상품데이터 일괄업데이트) 페이지에서 워터마크를 적용합니다.<br/>
3. 워터마크를 적용할 원본이미지 크기는 680*3000 이하로 등록해 주세요.
</div>

<script>
<?php if($TPL_VAR["config_watermark"]["watermark_type"]){?>
$("input[name='watermark_type'][value='<?php echo $TPL_VAR["config_watermark"]["watermark_type"]?>']").attr('checked',true);
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["config_watermark"]["watermark_position"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
$("input[name='watermark_position[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>
</script>