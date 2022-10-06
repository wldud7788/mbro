<?php /* Template_ 2.2.6 2022/05/17 12:30:57 /www/music_brother_firstmall_kr/admin/skin/default/board/_notice_hidden.html 000003828 */ ?>
<!-- 게시판 스킨이 썸네일일 경우 공지글, 팝업, 비밀글 기능 비활성화 by hed 기획팀 요청 jhs -->
<?php if($TPL_VAR["manager"]["skin"]!='gallery02'){?>
<tr>
	<th>공지 기간 제한</th>
	<td >
		<span class="resp_radio">
			<label>
				<input type="radio" name="onlynotice" id="onlynotice0" value="0"<?php if(!($TPL_VAR["notice"]=='1'&&$TPL_VAR["onlynotice"]=='1')){?> checked<?php }?>/>
				<span>기간 제한 없음</span>
			</label>
			<label>
				<input type="radio" name="onlynotice" id="onlynotice1" value="1"<?php if($TPL_VAR["notice"]=='1'&&$TPL_VAR["onlynotice"]=='1'){?> checked<?php }?>/>
				<span>기간 제한</span>
			</label>
		</span>
		<span>
			<input type="text" name="onlynotice_sdate" id="onlynotice_sdate" value="<?php if(substr($TPL_VAR["onlynotice_sdate"], 0, 10)!='0000-00-00'){?><?php echo substr($TPL_VAR["onlynotice_sdate"], 0, 10)?><?php }?>" maxlength="10" size="10">
			<span>~</span>
			<input type="text" name="onlynotice_edate" id="onlynotice_edate" value="<?php if(substr($TPL_VAR["onlynotice_edate"], 0, 10)!='0000-00-00'){?><?php echo substr($TPL_VAR["onlynotice_edate"], 0, 10)?><?php }?>" maxlength="10" size="10">
		</span>
	</td>
</tr>

<?php if($_GET["id"]=='gs_seller_notice'){?>
<tr>
	<th>팝업 기간 제한</th>
	<td>
		<span class="resp_radio">
			<label>
				<input type="radio" name="onlypopup" id="onlypopup0" value="y"<?php if($TPL_VAR["onlypopup"]=='y'){?> checked<?php }?>>
				<span>기간 제한 없음</span>
			</label>
			<label>
				<input type="radio" name="onlypopup" id="onlypopup1" value="d"<?php if($TPL_VAR["onlypopup"]=='d'){?> checked<?php }?>>
				<span>기간 제한</span>
			</label>
		</span>
		<span>
			<input type="text" name="onlypopup_sdate" id="onlypopup_sdate" value="<?php if(substr($TPL_VAR["onlypopup_sdate"], 0, 10)!='0000-00-00'){?><?php echo substr($TPL_VAR["onlypopup_sdate"], 0, 10)?><?php }?>" maxlength="10" size="10">
			<span>~</span>
			<input type="text" name="onlypopup_edate" id="onlypopup_edate" value="<?php if(substr($TPL_VAR["onlypopup_edate"], 0, 10)!='0000-00-00'){?><?php echo substr($TPL_VAR["onlypopup_edate"], 0, 10)?><?php }?>" maxlength="10" size="10">
		</span>
	</td>
</tr> 
<?php }?>

<?php if($TPL_VAR["manager"]["secret_use"]=='Y'||$TPL_VAR["manager"]["secret_use"]=='A'||($TPL_VAR["seq"]&&$TPL_VAR["hidden"]== 1)){?>
<tr>
	<th>비밀글</th>
	<td>
		<label class="resp_checkbox">
			<input type="checkbox" name="hidden" id="boardhidden" value="1" <?php echo $TPL_VAR["hiddenckeck"]?>>
			<span>비밀글</span>
		</label>
	</td>
</tr>
<tr<?php if(!$TPL_VAR["seq"]||!$TPL_VAR["hiddenckeck"]||strpos($TPL_VAR["hiddenckeck"],"checked")===false||true){?> class="hide"<?php }?>>
	<th>비밀번호 입력</th>
	<td>
<?php if($TPL_VAR["seq"]){?>
<?php if($TPL_VAR["mseq"]&&$TPL_VAR["mseq"]< 0){?>
<?php if($TPL_VAR["pw"]){?>
					<input type="hidden" name="oldpw" value="<?php echo $TPL_VAR["pw"]?>">
<?php }?>
				<input type="password" name="pw" id="boardpw" value="<?php echo $TPL_VAR["pw"]?>" password="password"<?php if(!$TPL_VAR["hiddenckeck"]||strpos($TPL_VAR["hiddenckeck"],"checked")===false){?> disabled<?php }?>>
				<button type="button" class="resp_btn hidden_sms_send" board_id="<?php echo $_GET["id"]?>" board_seq="<?php echo $TPL_VAR["seq"]?>">SMS 보내기</button>
<?php }?>
<?php }else{?>
			<input type="password" name="pw" id="boardpw" value password="password"<?php if(!$TPL_VAR["hiddenckeck"]||strpos($TPL_VAR["hiddenckeck"],"checked")===false){?> disabled<?php }?>>
<?php }?>
		<div id="sendPopup" class="hide"></div>
	</td>
</tr>
<?php }?>
<?php }?>