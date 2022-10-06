<?php /* Template_ 2.2.6 2022/05/17 12:31:41 /www/music_brother_firstmall_kr/admin/skin/default/design/_display_edit_decoration_light.html 000010081 */ ?>
<!-- 상품디스플레이 꾸미기 영역 : 시작 -->
		<tr class="goodsDisplayDecorationContainer">
			<th class="dsts-th">
			<input type="hidden" name="image_decoration" class="image_decoration" value="" />
			<input type="hidden" class="image_decoration_icon_type" value="<?php echo $TPL_VAR["image_decorations"]->image_icon_type?>" />
				<p class="mb5">이미지 꾸미기</p>
			</th>
			<td class="dsts-td left" style="padding:0; padding-bottom:15px">
				<input type="radio" class="decoration_type hide" name="image_decoration_type" value="quality" checked />

				<div class="clearbox decoration_quality mt10 ml20" style="">
					<table width="100%" cellpadding="0" cellspacing="0">
					<colgroup>
						<col width="25%" />
						<col width="25%" />
						<col width="25%" />
						<col width="25%" />
					</colgroup>
					<tr>
						<!-- 찜하기 -->
						<td valign="top">
							<table class="image_decoration_table fl pdr30">
							<tr>
								<td height="25px">
									<label><input type="checkbox" id="zzim_view" class="use_image_zzim image_decorate_chk" <?php if($TPL_VAR["image_decorations"]->image_zzim){?>checked="checked"<?php }?> />
									<span>찜하기</span></label><br/>
									<label for="zzim_view"><span class="desc" style="color:#f6731b">(이미지를 클릭하면 변경 가능)</span></label>
								</td>
							</tr>
							<tr>
								<td>
									<input type="hidden" class="image_zzim" value="<?php if($TPL_VAR["image_decorations"]->image_zzim){?><?php echo $TPL_VAR["image_decorations"]->image_zzim?><?php }else{?>icon_zzim.png<?php }?>" />
<?php if($TPL_VAR["image_decorations"]->image_zzim){?>
									<img src="/data/icon/goodsdisplay/zzim/<?php echo $TPL_VAR["image_decorations"]->image_zzim?>" border="0" vspace="4" class="image_zzim_select hand" align="absmiddle">
<?php }else{?>
									<img src="/data/icon/goodsdisplay/zzim/icon_zzim.png" border="0" vspace="4" class="image_zzim_select hand" align="absmiddle">
<?php }?>
									<input type="hidden" class="image_zzim_on" value="<?php if($TPL_VAR["image_decorations"]->image_zzim_on){?><?php echo $TPL_VAR["image_decorations"]->image_zzim_on?><?php }else{?>icon_zzim_on.png<?php }?>" />
<?php if($TPL_VAR["image_decorations"]->image_zzim_on){?>
									<img src="/data/icon/goodsdisplay/zzim_on/<?php echo $TPL_VAR["image_decorations"]->image_zzim_on?>" border="0" vspace="4" class="image_zzim_on_select hand" align="absmiddle">
<?php }else{?>
									<img src="/data/icon/goodsdisplay/zzim_on/icon_zzim_on.png" border="0" vspace="4" class="image_zzim_on_select hand" align="absmiddle">
<?php }?>
								</td>
							</tr>
							</table>
						</td>
						<!-- 아이콘 -->
						<td valign="top">						
							<table class="image_decoration_table fl pdr30" minwidth="250px">
							<tr>
								<td height="25px">
									<label><input type="checkbox" id="icon_view" class="use_image_icon image_decorate_chk" <?php if($TPL_VAR["image_decorations"]->image_icon){?>checked="checked"<?php }?> />
									<span>아이콘</span></label><br/>
									<label for="icon_view"><span class="desc" style="color:#f6731b">(이미지를 클릭하면 변경 가능)</span></label>
								</td>
							</tr>
							<tr>
								<td>
									<div style="float:left;width:65px">
										<input type="hidden" class="image_icon_condition" value="<?php echo $TPL_VAR["image_decorations"]->image_icon_condition?>" />
										<input type="hidden" class="image_icon_type" value="<?php echo $TPL_VAR["image_decorations"]->image_icon_type?>" />
										<input type="hidden" class="image_icon_condition_cnt" value="<?php echo $TPL_VAR["image_decorations"]->image_icon_condition_cnt?>" />
										<input type="hidden" class="image_icon" value="<?php if($TPL_VAR["image_decorations"]->image_icon){?><?php echo $TPL_VAR["image_decorations"]->image_icon?><?php }else{?>icon_best.png<?php }?>" />
<?php if($TPL_VAR["image_decorations"]->image_icon){?>
										<img src="/data/icon/goodsdisplay/<?php echo $TPL_VAR["image_decorations"]->image_icon?>" border="0" class="image_icon_select hand <?php if($TPL_VAR["image_decorations"]->image_icon_type=='condition'){?>hide<?php }?>" align="absmiddle">
<?php }else{?>
										<img src="/data/icon/goodsdisplay/icon_best.png" border="0" class="image_icon_select hand <?php if($TPL_VAR["image_decorations"]->image_icon_type=='condition'){?>hide<?php }?>" align="absmiddle">
<?php }?>
										<span class="image_icon_select image_icon_select_condition hand <?php if($TPL_VAR["image_decorations"]->image_icon_type!='condition'){?>hide<?php }?>">아이콘</span>
									</div>
									<div class="hide" style="float:left; width:200px">
										<label for="icon_view">
											<div class="icon_type_txt <?php if($TPL_VAR["image_decorations"]->image_icon_type=='condition'){?>hide<?php }?>" attr="no">
												<span>조건 없이 노출</span>
											</div>
											<div class="icon_type_txt <?php if($TPL_VAR["image_decorations"]->image_icon_type!='condition'){?>hide<?php }?>" attr="condition">
												<span>조건(</span><span class="icon_condition_cnt"><?php echo $TPL_VAR["image_decorations"]->image_icon_condition_cnt?></span><span>개) 만족 시 노출</span>
											</div>
											<div class="mt5">
												<select class="image_icon_location">
													<option value="left" <?php if($TPL_VAR["image_decorations"]->image_icon_location=='left'){?>selected="selected"<?php }?>>좌측상단</option>
													<option value="right" <?php if($TPL_VAR["image_decorations"]->image_icon_location=='right'){?>selected="selected"<?php }?>>우측상단</option>
												</select>
												<select class="image_icon_over">
													<option value="n" <?php if($TPL_VAR["image_decorations"]->image_icon_over=='n'){?>selected="selected"<?php }?>>고정</option>
													<option value="y" <?php if($TPL_VAR["image_decorations"]->image_icon_over=='y'){?>selected="selected"<?php }?>>오버 시</option>
												</select>
											</div>
											<div class="mt5">
												<span class="desc" style="color:#f6731b">이미지를 클릭하면 변경 가능</span>
											</div>
										</label>
									</div>
								</td>
							</tr>
							</table>
						</td>
						<!-- 미리보기,옵션보기,관심상품 버튼 -->
						<td valign="top">
							<table class="image_decoration_table fl pdr30" minwidth="250px">
							<tr>
								<td height="25px">
									<label><input type="checkbox" class="use_review_option_like image_decorate_chk" <?php if($TPL_VAR["image_decorations"]->use_review_option_like){?>checked="checked"<?php }?> />
									<span>미리보기/옵션보기/SNS보내기/찜하기</span></label>
								</td>
							</tr>
							<tr>
								<td><img src="/admin/skin/default/images/design/img_effect_rollover_review.gif" /></td>
							</tr>
							</table>
						</td>
						<!-- 상품 후면컷 버튼 -->
						<td valign="top">
							<table class="image_decoration_table fl pdr30" minwidth="250px">
							<tr>
								<td height="25px">
									<label><input type="checkbox" class="use_seconde_image image_decorate_chk" <?php if($TPL_VAR["image_decorations"]->use_seconde_image){?>checked="checked"<?php }?> />
									<span>첫번째 컷 → 두번째 컷</span></label>
								</td>
							</tr>
							<tr>
								<td valign="top"><img src="/admin/skin/default/images/design/img_effect_rollover_2cut.gif" /></td>
							</tr>
							</table>
							<table class="goodsDisplayImageTable" width="220" align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto; position: absolute; left: -9999px; visibility: hidden">
								<tr>
									<td valign="top" class="pd10">
										<div class="goodsDisplayItemWrap">
											<div class="goodsDisplayImageWrap" goodsInfo="<?php echo base64_encode(json_encode($TPL_VAR["sampleGoodsInfo"]))?>" version="display_edit">
												<a href="javascript:;">
													<img src="/admin/skin/default/images/design/img_effect_sample.gif" class="goodsDisplayImage" width="100%" designElement />
													<div class="goodsDisplayBottomFuncWrap">
														<div class="goodsDisplayBottomFunc">
															<div class="display_newwin hide" onclick="alert('새창보기');"><img src='/data/icon/goodsdisplay/preview/thumb_newwin.png' alt="새창보기" /></div>
															<div class="display_quickview" onclick="alert('미리보기');"><img src='/data/icon/goodsdisplay/preview/thumb_quickview.png' alt="미리보기" /></div>
															<div class="display_option" onclick="display_goods_show_opt(this,1)" goods_seq="<?php echo $TPL_VAR["displayGoods"]["goods_seq"]?>"><img src='/data/icon/goodsdisplay/preview/thumb_option.png' alt="옵션보기" /><div class="hide display_opt_bak"></div></div>
															<div class="display_send" onclick="display_goods_send(this,'bottom')"><img src='/data/icon/goodsdisplay/preview/thumb_send.png' alt="SNS보내기" /></div>
															<div class="display_zzim" onclick="alert('찜하기');" <?php if($TPL_VAR["displayGoods"]["wish"]=='1'){?>act="stay"<?php }?>><img src='/data/icon/goodsdisplay/preview/thumb_zzim_off.png' class='zzimOffImg' <?php if($TPL_VAR["displayGoods"]["wish"]=='1'){?>style="display:none"<?php }?> alt="찜하기" /><img src='/data/icon/goodsdisplay/preview/thumb_zzim_on.png' class='zzimOnImg' <?php if($TPL_VAR["displayGoods"]["wish"]!='1'){?>style="display:none"<?php }?> alt="찜하기"/></div>
														</div>
													</div>
												</a>
											</div>
											<div class="pd20 center">상품정보 영역</div>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					</table>
				</div>
			</td>
		</tr>