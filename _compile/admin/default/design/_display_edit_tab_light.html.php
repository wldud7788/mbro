<?php /* Template_ 2.2.6 2022/05/17 12:31:42 /www/music_brother_firstmall_kr/admin/skin/default/design/_display_edit_tab_light.html 000002316 */ 
$TPL_display_tabs_1=empty($TPL_VAR["display_tabs"])||!is_array($TPL_VAR["display_tabs"])?0:count($TPL_VAR["display_tabs"]);?>
<tr class="tab_area">
			<th class="dsts-th">
				탭 <span class="btn small cyanblue"><button type="button" id="btnDisplayTabPopup">만들기/수정</button></span>
			</th>
			<td class="dsts-td left" colspan="2">
				<div class="displayTabContainer"></div>
				<div id="displayTabMakePopup" class="displayTabMakePopup pc_tab_popup">
					<input type="radio" class="hide" name="popup_tab_design_type" value="displayTabType1" checked/>
					<div class="displayTabMakePopupInner">

						<ul class="displayTabKindWrap hide">
							<input type="radio" name="popup_tab_design_kind" value="text" checked/>
						</ul>

						<div class="displayTabKindWrapText">
							<div class="displayTabDivisionLine" style="border-top:0;">
								<b>탭 명칭</b>
								<div class="displayTabList">
<?php if($TPL_VAR["display_tabs"]){?>
<?php if($TPL_display_tabs_1){foreach($TPL_VAR["display_tabs"] as $TPL_V1){?>
										<div class="displayTabMakeInputs">
											<input type="text" name="popup_tab_title[]" value="<?php echo $TPL_V1["tab_title"]?>" size="35" maxlength="15" /> <img src="/admin/skin/default/images/design/icon_design_plus.gif" align="absmiddle" class="tabPlusBtn" attr="pc" /><img src="/admin/skin/default/images/design/icon_design_minus.gif" align="absmiddle" class="tabMinusBtn" attr="pc"/>
										</div>
<?php }}?>
<?php }else{?>
										<div class="displayTabMakeInputs">
											<input type="text" name="popup_tab_title[]" value="" size="35" maxlength="15" /> <img src="/admin/skin/default/images/design/icon_design_plus.gif" align="absmiddle" class="tabPlusBtn" attr="pc"/><img src="/admin/skin/default/images/design/icon_design_minus.gif" align="absmiddle" class="tabMinusBtn" attr="pc"/>
										</div>
<?php }?>
								</div>
							</div>
						</div>

						<div class="pdt20 center">
							<span class="btn small cyanblue"><button type="button" onclick="closeDialog('displayTabMakePopup')">확인</button></span>
						</div>
					</div>
				</div>
			</td>
		</tr>