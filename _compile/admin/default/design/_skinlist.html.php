<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/design/_skinlist.html 000006178 */ 
$TPL_my_skin_list_1=empty($TPL_VAR["my_skin_list"])||!is_array($TPL_VAR["my_skin_list"])?0:count($TPL_VAR["my_skin_list"]);?>
<script>
	var arrSkinInfo = {};
</script>
<div class="contents_dvs v2">
<div class="table_row_frame">	
<div class="dvs_top">	
	<div class="dvs_left">	
		<input type="button" class="btnRealSkinApply resp_btn active"  value="사용 스킨 설정" onclick="<?php if(serviceLimit('H_FR')){?>btnSkinApply(this);<?php }else{?>btnRealSkinApply(this);<?php }?>"  />
<?php if(!serviceLimit('H_FR')){?><input type="button" class="btnWorkingSkinApply resp_btn v2"  value="디자인 스킨 설정" onclick="btnWorkingSkinApply(this);" /><?php }?>
	</div>
	<div class="dvs_right">	
		<input type="button" value="스킨 업로드" <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?><?php }else{?> onclick="upload_skin()"<?php }?> class="resp_btn v3"/>
	</div>
</div>
			
<table class="table_row_basic tdc"  id="skin-list-tbl">
	<caption>보유스킨 설정</caption>
	
	<colgroup>
		<col width="8%"><col width="15%"><col width="23%"><col width="13%"><col width="15%"><col width="16%"><col width="10%">
	</colgroup>

	<thead>
		<tr>
			<th>선택</th>
			<th colspan="2">스킨명(폴더명)</th>
			<th>언어</th>
			<th>버전(등록 일시)</th>
			<th>관리</th>
			<th>삭제</th>
		</tr>
	</thead>

	<tbody>
<?php if($TPL_my_skin_list_1){$TPL_I1=-1;foreach($TPL_VAR["my_skin_list"] as $TPL_V1){$TPL_I1++;?>
		<tr>
			<td>
				<label class="resp_radio">
					<input type="radio" name="skin_chk" value="<?php echo $TPL_V1["skin"]?>" <?php if($_GET["checkedSkin"]==$TPL_V1["skin"]){?>checked<?php }?> onclick="bg_checked_skin();" />
				</label>
				<script>
					arrSkinInfo["<?php echo $TPL_V1["skin"]?>"] = <?php echo json_encode($TPL_VAR["my_skin_list"])?>[<?php echo $TPL_I1?>];
				</script>
			</td>
			<td>
				<div class="skin_img_wrap">
					<div class="is_use_icon">
<?php if(preg_match('/실제적용/',implode(' ',$TPL_VAR["my_skin_list_icon"][$TPL_I1]))){?><span class="use">사용</span><?php }?>
<?php if(preg_match('/디자인작업용/',implode(' ',$TPL_VAR["my_skin_list_icon"][$TPL_I1]))){?><span class="design <?php if(preg_match('/실제적용/',implode(' ',$TPL_VAR["my_skin_list_icon"][$TPL_I1]))){?>ml3<?php }?>">디자인</span><?php }?>
					</div>
<?php if($TPL_VAR["skinPrefix"]=='mobile'){?>
					<img src="/data/skin/<?php echo $TPL_V1["skin"]?>/configuration/<?php echo $TPL_V1["screenshot"]?>" alt="<?php echo $TPL_V1["name"]?>" class="wx110" />
<?php }elseif($TPL_VAR["skinPrefix"]=='fammerce'){?>
					<img src="/data/skin/<?php echo $TPL_V1["skin"]?>/configuration/<?php echo $TPL_V1["screenshot"]?>" alt="<?php echo $TPL_V1["name"]?>" class="wx110"  />
<?php }else{?>
					<img src="/data/skin/<?php echo $TPL_V1["skin"]?>/configuration/<?php echo $TPL_V1["screenshot"]?>" alt="<?php echo $TPL_V1["name"]?>" class="wx110"  />
<?php }?>
				</div>
			</td>

			<td class="left">					
				<div class="skin_name">
					<b><?php echo $TPL_V1["name"]?></b>
					<div>(<?php echo $TPL_V1["skin"]?>)</div>
				</div>
				<div class="mt5">					
					<a href="<?php if($TPL_VAR["skinPrefix"]=='mobile'){?>http://<?php echo $TPL_VAR["mobileDomain"]?>?previewSkin=<?php echo $TPL_V1["skin"]?><?php }else{?>/?previewSkin=<?php echo $TPL_V1["skin"]?>&setMode=pc<?php }?>" target="_blank" class="resp_btn">미리보기</a>
					<input type="button" value="스킨정보"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> onclick="rename_skin('<?php echo $TPL_V1["skin"]?>','<?php echo $TPL_V1["name"]?>', '<?php echo $TPL_V1["language"]?>', '<?php echo $TPL_VAR["skinType"]?>', '<?php echo $TPL_VAR["skinPrefix"]?>', '<?php echo $TPL_V1["patch_version"]?>', '<?php echo $TPL_V1["regdate"]?>')"<?php }?>  class="resp_btn"/>

				</div>
			</td>
			<td>
<?php if($TPL_V1["language"]=='EN'){?>
				영어
<?php }elseif($TPL_V1["language"]=='CN'){?>
				중국어
<?php }elseif($TPL_V1["language"]=='JP'){?>
				일본어
<?php }else{?>
				한국어
<?php }?>
			</td>
			<td>
				<?php echo $TPL_V1["patch_version"]?>

				<div>(<?php echo $TPL_V1["regdate"]?>)</div>
			</td>
			<td>
				<input type="button" value="백업"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?>  onclick="backup_skin('<?php echo $TPL_V1["skin"]?>')" <?php }?> class="resp_btn v2"/>
				<input type="button" value="복사"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?>  onclick="copy_skin('<?php echo $TPL_V1["skin"]?>')"<?php }?> class="resp_btn v2" />
			</td>
			<td>
				<input type="button" value="삭제"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> onclick="delete_skin('<?php echo $TPL_V1["skin"]?>')" <?php }?> class="resp_btn v3"/>
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>

<div class="dvs_bottom">	
	<div class="dvs_left">	
		<input type="button" class="btnRealSkinApply resp_btn active"  value="사용 스킨 설정" onclick="<?php if(serviceLimit('H_FR')){?>btnSkinApply(this);<?php }else{?>btnRealSkinApply(this);<?php }?>"  />
<?php if(!serviceLimit('H_FR')){?><input type="button" class="btnWorkingSkinApply resp_btn v2"  value="디자인 스킨 설정" onclick="btnWorkingSkinApply(this);" /><?php }?>
	</div>
	<div class="dvs_right">	
		<input type="button" value="스킨 업로드" <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?><?php }else{?> onclick="upload_skin()"<?php }?> class="resp_btn v3"/>
	</div>
</div>
</div>
</div>

<script>
	var height = (<?php echo $TPL_my_skin_list_1?>*150) + 30;
	// 20190607_sjg 보유스킨 목록이 다수인 경우 하단 배너와의 겹침 문제로 인한 높이값 삭제
	//$(".sst-skin-list-container").height(height);
	bg_checked_skin();
</script>