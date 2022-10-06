<?php /* Template_ 2.2.6 2022/05/17 12:31:40 /www/music_brother_firstmall_kr/admin/skin/default/design/_display_edit_condition_light.html 000007027 */ 
$TPL_display_tabs_1=empty($TPL_VAR["display_tabs"])||!is_array($TPL_VAR["display_tabs"])?0:count($TPL_VAR["display_tabs"]);?>
<?php if($TPL_VAR["display_tabs"]){?>
<?php if($TPL_display_tabs_1){$TPL_I1=-1;foreach($TPL_VAR["display_tabs"] as $TPL_V1){$TPL_I1++;?>
		<tbody class="displayTabGoodsContainer" tabIdx="<?php echo $TPL_I1?>">
			<tr>
				<th class="dsts-th">
					<span class="strTab">[탭 <span class="strTabIdx"><?php echo $TPL_I1+ 1?></span>]</span><br />
					<select name="contents_type[]" class="contents_type">
<?php if($TPL_VAR["condition_type"]["auto"]){?>
						<option value="auto" <?php if($TPL_V1["contents_type"]=='auto'){?>selected<?php }?>>자동</option>
<?php }?>
<?php if($TPL_VAR["condition_type"]["auto_sub"]){?>
						<option value="auto_sub" <?php if($TPL_V1["contents_type"]=='auto_sub'){?>selected<?php }?>>자동(2)</option>
<?php }?>
<?php if($TPL_VAR["condition_type"]["select"]){?>
						<option value="select" <?php if($TPL_V1["contents_type"]=='select'){?>selected<?php }?>>직접 선정</option>
<?php }?>
<?php if($TPL_VAR["condition_type"]["text"]){?>
						<option value="text" <?php if($TPL_V1["contents_type"]=='text'){?>selected<?php }?>>입력</option>
<?php }?>
					</select>
					<div class="displayTypeInfo">고객의 최근 행동<br />또는 관리자 지정<br />기준</div>
					<div class="displayTypeInfo">고객의 현재<br />보고 있는 상품<br />기준</div>
					<div class="displayTypeInfo">관리자가<br />지정한 상품</div>
					<div class="displayTypeInfo">관리자가<br />해당 영역을 꾸밈</div>
				</th>
				<td class="dsts-td left" colspan="2">
					<div class="displayTabAutoTypeContainer" type="auto">
						<input type="hidden" class="isBigdataTest" value="1"/>
						<span class="btn small gray"><button type="button" class="displayCriteriaButton displayCriteriaType" attr="pc" auto_type="auto" kind="<?php echo $TPL_VAR["displaykind"]?>">조건 선택</button></span>
						<div class="clearbox" style="height:5px;"></div>
						<input type='hidden' class="displayCriteria" id="displayCriteria<?php echo $TPL_I1?>" name='auto_criteria[]' value="<?php echo $TPL_V1["auto_criteria"]?>" />
						<input type='hidden' class="auto_condition_use" id="auto_condition_use<?php echo $TPL_I1?>" name='auto_condition_use[]' value="<?php echo $TPL_V1["auto_condition_use"]?>" />
						<div class="displayCriteriaDesc pdt10"></div>
					</div>
					<div class="displayTabAutoTypeContainer" type="select">
						<span class="btn small gray"><button type="button" class="displayGoodsButton" attr="pc">상품 검색</button></span>
						<span class="desc">↓ 아래의 상품을 드래그하여 노출순서를 변경할 수도 있습니다.</span>
						<div class="clearbox" style="height:5px;"></div>
						<input type='hidden' name='auto_goods_seqs[]' />
						<div id="displayGoods<?php echo $TPL_I1?>" class="displayGoods">
<?php if(is_array($TPL_R2=$TPL_V1["items"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
							<div class='goods fl move'>
								<div align='center' class='image'><img src="<?php echo $TPL_V2["image"]?>" class="goodsThumbView" width="50" height="50" alt="<?php echo htmlspecialchars($TPL_V2["goods_name"])?>" onerror="this.src='/admin/skin/default/images/common/noimage_list.gif'" /></div>
								<div align='center' class='name' style='width:70px;overflow:hidden;white-space:nowrap;'><?php echo htmlspecialchars($TPL_V2["goods_name"])?></div>
								<div align='center' class='price'><?php echo get_currency_price($TPL_V2["price"])?></div>
								<input type='hidden' name='displayGoods<?php echo $TPL_I1?>[]' value='<?php echo $TPL_V2["goods_seq"]?>' />
<?php if(serviceLimit('H_AD')){?>
								<div align='center' class='provider_name red'><?php echo $TPL_V2["provider_name"]?></div>
<?php }?>
							</div>
<?php }}?>
						</div>
					</div>
					<div class="displayTabAutoTypeContainer" type="text">
						반응형 전용
						<textarea name="tab_contents[]" style="width:100%" contentHeight="150px" class="daumeditor hide" tinyMode="1"><?php echo $TPL_V1["tab_contents"]?></textarea><br />
					</div>
				</td>
			</tr>
		</tbody>
<?php }}?>
<?php }else{?>
		<tbody class="displayTabGoodsContainer" tabIdx="0">
			<tr>
				<th class="dsts-th">
					<span class="strTab">[탭 <span class="strTabIdx">1</span>]</span><br />
					<select name="contents_type[]" class="contents_type">
<?php if($TPL_VAR["condition_type"]["auto"]){?>
						<option value="auto" selected>자동</option>
<?php }?>
<?php if($TPL_VAR["condition_type"]["auto_sub"]){?>
						<option value="auto_sub">자동(2)</option>
<?php }?>
<?php if($TPL_VAR["condition_type"]["select"]){?>
						<option value="select">직접선정</option>
<?php }?>
<?php if($TPL_VAR["condition_type"]["text"]){?>
						<option value="text">입력</option>
<?php }?>
					</select>
					<div class="displayTypeInfo">고객의 최근 행동<br />또는 관리자 지정<br />기준</div>
					<div class="displayTypeInfo">고객의 현재<br />보고 있는 상품<br />기준</div>
					<div class="displayTypeInfo">관리자가<br />지정한 상품</div>
					<div class="displayTypeInfo">관리자가<br />해당 영역을 꾸밈</div>
				</th>
				<td class="dsts-td left" colspan="2">
					<div class="displayTabAutoTypeContainer" type="auto">
						<input type="hidden" class="isBigdataTest" value="1"/>
						<span class="btn small gray"><button type="button" class="displayCriteriaButton displayCriteriaType" attr="pc" auto_type="auto" kind="<?php echo $TPL_VAR["displaykind"]?>">조건 선택</button></span>
						<div class="clearbox" style="height:5px;"></div>
						<input type='hidden' class="displayCriteria" id="displayCriteria0" name='auto_criteria[]' value="admin∀type=select_auto,provider=all,month=1,act=recently,min_ea=1" />
						<input type='hidden' class="auto_condition_use" id="auto_condition_use0" name='auto_condition_use[]' value="1" />
						<div class="displayCriteriaDesc pdt10"></div>
					</div>
					<div class="displayTabAutoTypeContainer" type="select">
						<span class="btn small gray"><button type="button" class="displayGoodsButton" attr="pc">상품 검색</button></span>
						<span class="desc">↓ 아래의 상품을 드래그하여 노출순서를 변경할 수도 있습니다.</span>
						<div class="clearbox" style="height:5px;"></div>
						<input type='hidden' name='auto_goods_seqs[]' />
						<div id="displayGoods0" class="displayGoods"></div>
					</div>
					<div class="displayTabAutoTypeContainer" type="text">
						반응형 전용
						<textarea name="tab_contents[]" style="width:100%" contentHeight="150px" class="daumeditor hide" tinyMode="1"></textarea><br />
					</div>
				</td>
			</tr>
		</tbody>
<?php }?>