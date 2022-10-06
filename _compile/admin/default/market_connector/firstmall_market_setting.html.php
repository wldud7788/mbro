<?php /* Template_ 2.2.6 2022/05/17 12:36:19 /www/music_brother_firstmall_kr/admin/skin/default/market_connector/firstmall_market_setting.html 000003611 */ 
$TPL_useMarketList_1=empty($TPL_VAR["useMarketList"])||!is_array($TPL_VAR["useMarketList"])?0:count($TPL_VAR["useMarketList"]);
$TPL_accountList_1=empty($TPL_VAR["accountList"])||!is_array($TPL_VAR["accountList"])?0:count($TPL_VAR["accountList"]);?>
<?php if($TPL_VAR["pageMode"]=='FirstSet'){?>
				<div class="market_regist">
<?php if($TPL_VAR["MarketConnectorClause"]=='NOT_YET'){?>
<?php $this->print_("CLAUSE",$TPL_SCP,1);?>

<?php }else{?>
					<div class="icon">						
						<button type="button"  onclick="addNewAccount('');" class="resp_btn active size_L">오픈 마켓 등록</button>					
					</div>					
<?php }?>
				</div>
<?php }else{?>
				<div>
					<ul class="tab_01 v2 y3 tabEvent">
<?php if($TPL_useMarketList_1){foreach($TPL_VAR["useMarketList"] as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_VAR["market"]==$TPL_K1){?>
						<li><a onclick="moveMenu('./market_setting?market=<?php echo $TPL_K1?>')" class="current"><img src="/admin/skin/default/images/common/ico_connector_<?php echo $TPL_K1?>.png" align="absmiddle" alt="<?php echo $TPL_V1?>"> <?php echo $TPL_V1?></a></li>
<?php }else{?>
						<li><a onclick="moveMenu('./market_setting?market=<?php echo $TPL_K1?>')"><img src="/admin/skin/default/images/common/ico_connector_<?php echo $TPL_K1?>.png" align="absmiddle" alt="<?php echo $TPL_V1?>"> <?php echo $TPL_V1?></a></li>
<?php }?>
<?php }}?>
					</ul>
	
					<!-- //탭메뉴 -->
					<table class="market-table-style" width="100%"  cellpadding="0" cellspacing="0">
						<colgroup>
							<col width="200" /><col />
						</colgroup>
						<tbody>
						<tr valign="top">
							<td>								
								<dl class="market_seller">
<?php if($TPL_accountList_1){foreach($TPL_VAR["accountList"] as $TPL_V1){?>
<?php if($TPL_VAR["sellerId"]==$TPL_V1["sellerId"]){?>
									<dt class="active"><?php echo $TPL_V1["sellerId"]?></dt>
									<dd style="display:block">
										<ul>
											<li class="act <?php if($TPL_VAR["pageMode"]=='AccountSet'){?>on<?php }?>" onclick="moveMenu('./market_setting?market=<?php echo $TPL_VAR["market"]?>&sellerId=<?php echo $TPL_V1["sellerId"]?>&accountSeq=<?php echo $TPL_V1["accountSeq"]?>&pageMode=AccountSet')">
												계정설정
											</li>
											<li class="add <?php if($TPL_VAR["pageMode"]=='AddInfoListSet'||$TPL_VAR["pageMode"]=='AddInfoRegistSet'){?>on<?php }?>" onclick="moveMenu('./market_setting?market=<?php echo $TPL_VAR["market"]?>&sellerId=<?php echo $TPL_V1["sellerId"]?>&pageMode=AddInfoListSet')">
												필수정보 설정
											</li>
											<li class="ctg <?php if($TPL_VAR["pageMode"]=='CategoryMatchingListSet'){?>on<?php }?>" onclick="moveMenu('./market_setting?market=<?php echo $TPL_VAR["market"]?>&sellerId=<?php echo $TPL_V1["sellerId"]?>&pageMode=CategoryMatchingListSet')">
												카테고리 매칭
											</li>
										</ul>
									</dd>
<?php }else{?>
									<dt onclick="moveMenu('./market_setting?market=<?php echo $TPL_VAR["market"]?>&sellerId=<?php echo $TPL_V1["sellerId"]?>&accountSeq=<?php echo $TPL_V1["accountSeq"]?>&pageMode=AccountSet')">
										<?php echo $TPL_V1["sellerId"]?>

									</dt>
<?php }?>
<?php }}?>
								</dl>
							</td>
							<td>
								<div id="rightContentLay">
<?php $this->print_("RIGHT_CONTENT",$TPL_SCP,1);?>

								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
<?php }?>