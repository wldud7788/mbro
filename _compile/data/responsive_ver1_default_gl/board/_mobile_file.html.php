<?php /* Template_ 2.2.6 2021/12/15 17:48:34 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/board/_mobile_file.html 000003257 */ 
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 게시판 파일 첨부 @@
- 파일위치 : [스킨폴더]/board/_mobile_file.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript" src="/app/javascript/js/skin-board_mobile_file.js?dummy=201905062"></script>

<!-- 2018-06-05 byuncs add image 먼저 업로드 후 경로 및 태그 -->
<input type="hidden" name="realfilename" value="" >
<input type="hidden" name="incimage" value="" >
<input type="hidden" name="insert_image" value="" >
<input type="hidden" name="remove_no" value="" >

<table cellpadding="0" cellspacing="0" border="0" class="file_add_table">
<tr>
	<th class="width_a"><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvX21vYmlsZV9maWxlLmh0bWw=" >첨부파일을</span></th>
	<td>
		<select class="select_img">
			<option value="bottom" <?php if(!$TPL_VAR["insert_image"]||$TPL_VAR["insert_image"]=='bottom'){?> selected="selected" <?php }?>>내용하단에 삽입</option>
			<option value="top"  <?php if($TPL_VAR["insert_image"]=='top'){?> selected="selected" <?php }?>>내용상단에 삽입</option>
			<option value="" <?php if($TPL_VAR["insert_image"]=='none'){?> selected="selected" <?php }?>>내용에 삽입하지 않음</option>
		</select>
	</td>
</tr>
<tr id="filelistlay">
	<th></th>
	<td>
		<div>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" class="boardfileliststyle" id="BoardFileTable">
			<tbody>
<?php if($TPL_VAR["filelist"]){?>
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
				<tr>
					<td class="pdt5" align="left"> 					
						<input type="hidden" name="orignfile_info[]"  class="orignfile_info" value="<?php echo $TPL_V1["realfile"]?>^^<?php echo $TPL_V1["orignfile"]?>^^<?php echo $TPL_V1["sizefile"]?>^^<?php echo $TPL_V1["typefile"]?>"/>
						<span class="realfilelist move highlight-link" realfiledir="<?php echo $TPL_V1["realfiledir"]?>" realfilename="<?php echo $TPL_V1["orignfile"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" filedown="../board_process?mode=board_file_down&board_id=<?php echo $TPL_VAR["boardid"]?>&realfiledir=<?php echo $TPL_V1["realfiledir"]?>&realfilename=<?php echo $TPL_V1["orignfile"]?>"><?php echo $TPL_V1["orignfile"]?></span>
					</td>
					<td class="pdt5" align="right">
						<button type="button" class="btn_graybox eaMinus  etcDel hand">-</button>
					</td>
				</tr>
<?php }}?>		
<?php }?>
<?php if($TPL_VAR["manager"]["file_use"]=='Y'){?>
				<tr>
					<td>
						<div id="img_viewer"></div>
						<div class="pdt5">
							<button type="button" class="btnUploader btn_resp size_b"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvYm9hcmQvX21vYmlsZV9maWxlLmh0bWw=" >+ 파일 추가</span></button>
						</div>
					</td>
				</tr>
<?php }?>
			</tbody>
			</table>
		</div>
	</td>
</tr>
</table>