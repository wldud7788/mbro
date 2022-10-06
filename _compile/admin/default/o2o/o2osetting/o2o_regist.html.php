<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/o2o/o2osetting/o2o_regist.html 000019905 */ 
$TPL_category_1=empty($TPL_VAR["category"])||!is_array($TPL_VAR["category"])?0:count($TPL_VAR["category"]);
$TPL_store_term_week_1=empty($TPL_VAR["store_term_week"])||!is_array($TPL_VAR["store_term_week"])?0:count($TPL_VAR["store_term_week"]);
$TPL_store_term_time_1=empty($TPL_VAR["store_term_time"])||!is_array($TPL_VAR["store_term_time"])?0:count($TPL_VAR["store_term_time"]);
$TPL_o2o_pos_info_1=empty($TPL_VAR["o2o_pos_info"])||!is_array($TPL_VAR["o2o_pos_info"])?0:count($TPL_VAR["o2o_pos_info"]);
$TPL_warehouses_1=empty($TPL_VAR["warehouses"])||!is_array($TPL_VAR["warehouses"])?0:count($TPL_VAR["warehouses"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/multiple-select.css" />
<script src="/app/javascript/plugin/multiple-select.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/js/o2o/admin-o2o.js?dummy=<?php echo date($TPL_VAR["YmdHis"])?>"></script>
<script>
var shipping_address_regist_able_yn = '<?php echo $TPL_VAR["shipping_address_regist_able_yn"]?>';
var shipping_address_max = '<?php echo $TPL_VAR["shipping_address_max"]?>';
</script>
<style>
	a.pg-link { color: rgb(205, 80, 11); }
	table.multi tr td.domain-title-favicon {vertical-align:top;}
	table.curr-simbol tr td.curr_amout {text-align:right;}
	table.curr-simbol tr td.curr_exchange {text-align:left;}	
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<input type="hidden" id="chkSMS_chk" value="<?php echo $TPL_VAR["chk"]?>"/>
	<input type="hidden" id="chkSMS_sms_auth" value="<?php echo $TPL_VAR["sms_auth"]?>"/>
	<input type="hidden" id="chkSMS_send_phone" value="<?php echo $TPL_VAR["send_phone"]?>"/>
	<input type="hidden" id="ssl_pay_is_alive" value="<?php echo $TPL_VAR["ssl_pay_is_alive"]?>"/>
	
	<div id="page-title-bar" class="gray-bar">
		
		<!-- // 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li>
				<span class="btn large">
					<button type="button" id="btnO2OList">
						매장 리스트
						<span class="arrowright"></span>
					</button>
				</span>
			</li>
		</ul>
		<!-- // 좌측 버튼 -->

		<!-- 타이틀 -->
		<div class="page-title">
			<h2><span class="darkgray">매장 등록</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li>
				<button type="button" class="btnSaveO2OSetting btn_resp b_blue_r">저장</button>				
			</li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="sub-layout-container body-height-resizing">
	<div class="slc-body-wrap">
		<div class="slc-body-wtl body-height-resizing"><div class="slc-body-wtr body-height-resizing"><div class="slc-body-wbl body-height-resizing"><div class="slc-body-wbr body-height-resizing"><div class="slc-body" style="min-height: 718px;">

			<!-- 추가 수정 레이어 : start -->
			<div id="o2oConfigLayer">
				<form name="settingConfigForm" id="settingConfigForm" method="post" target="actionFrame" action="../o2o/o2osetting_process/save">
				<input type="hidden" name="o2o_store_seq" id="o2o_store_seq" value="<?php echo $TPL_VAR["shipping_address"]["store_o2o_info"]["o2o_store_seq"]?>" />
				<input type="hidden" name="shipping_address_seq" value="<?php echo $TPL_VAR["shipping_address"]["shipping_address_seq"]?>" />
				<input type="hidden" name="address_provider_seq" value="<?php echo $TPL_VAR["shipping_address"]["address_provider_seq"]?>" />

				<div class="item-title">매장 정보</div>
				<table class="table_basic thl">				
					<tr>
						<th>분류 <span class="required_chk"></span><span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/o2o', '#tip2')"></span></th>
						<td>
							<select name="address_category" id="address_category" onchange="category_chg();">
								<option value="direct_input">직접입력</option>
<?php if($TPL_category_1){foreach($TPL_VAR["category"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["address_category"]?>" <?php echo $TPL_V1["selected"]?>><?php echo $TPL_V1["address_category"]?></option>
<?php }}?>
							</select>
							<input type="text" name="address_category_direct" id="address_category_direct" class="line" title="분류명" value="<?php echo $TPL_VAR["shipping_address"]["address_category_direct"]?>" />
						</td>
					</tr>
					<tr>
						<th>매장명<span class="required_chk"></span></th>
						<td>
							<len><input class="cal-len" type="text" name="address_name" value="<?php echo $TPL_VAR["shipping_address"]["address_name"]?>" title="매장명" class="line" maxlength="8" onkeyup="calculate_input_len(this);" onblur="calculate_input_len(this);"/> <span class="view-len">0</span></len>
						</td>
					</tr>
					<tr>
						<th>주소<span class="required_chk"></span></th>
						<td>
							<input type="text" name="zoneZipcode[]" value="<?php echo $TPL_VAR["shipping_address"]["zoneZipcode"]?>" size="7" title="우편번호" class="line" readonly="readonly" />
							<select name="address_nation" onchange="international_chg();">
								<option value="korea" <?php if($TPL_VAR["shipping_address"]["address_nation"]=='korea'){?> selected <?php }?>>대한민국</option>
								<option value="global" <?php if($TPL_VAR["shipping_address"]["address_nation"]=='global'){?> selected <?php }?>>해외국가</option>
							</select>
							<span class="inter_area international_korea"><input type="button" value="검색" onclick="openDialogZipcode('zone');" class="btn_resp"/></span>

							<div class="inter_area international_korea">
								<input type="hidden" name="zoneAddress_type" value="<?php echo $TPL_VAR["shipping_address"]["address_type"]?>" />
								<input type="text" name="zoneAddress" value="<?php echo $TPL_VAR["shipping_address"]["address"]?>" size="65" title="주소" class="line <?php if($TPL_VAR["shipping_address"]["address_type"]!=='zibun'){?>hide<?php }?>" readonly="readonly"/>
								<input type="text" name="zoneAddress_street" value="<?php echo $TPL_VAR["shipping_address"]["address_street"]?>" size="65" title="주소" class="line <?php if($TPL_VAR["shipping_address"]["address_type"]==='zibun'){?>hide<?php }?>" readonly="readonly" /><br />
								<input type="text" name="zoneAddressDetail" value="<?php echo $TPL_VAR["shipping_address"]["address_detail"]?>" size="65" title="상세주소" class="line" />
							</div>
							<div class="inter_area international_global hide">
								<input type="text" name="international_country" value="<?php echo $TPL_VAR["shipping_address"]["international_country"]?>" size="25" title="국가" class="line" />
								<input type="text" name="international_town_city" value="<?php echo $TPL_VAR["shipping_address"]["international_town_city"]?>" size="25" title="도시" class="line" />
								<input type="text" name="international_county" value="<?php echo $TPL_VAR["shipping_address"]["international_county"]?>" size="60" title="주/도" class="line" />
								<input type="text" name="international_address" value="<?php echo $TPL_VAR["shipping_address"]["international_address"]?>" size="60" title="주소" class="line" />
							</div>
						</td>
					</tr>
					<tr>
						<th>매장 전화번호</th>
						<td>
							<input type="text" name="shipping_phone" value="<?php echo $TPL_VAR["shipping_address"]["shipping_phone"]?>" title="전화번호" class="line" />
						</td>
					</tr>
				</table>

				<div class="item-title">매장 안내</div>

				<table class="table_basic thl">				
					<tr>
						<th>매장 안내<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/o2o', '#tip3')"></span></th>
						<td>
							<label class="mr15"><input type="radio" name="store_info_display_yn" value="Y" <?php if($TPL_VAR["shipping_address"]["store_info_display_yn"]=='Y'){?> checked <?php }?>> 노출</label>	
							<label><input type="radio" name="store_info_display_yn" value="N" <?php if($TPL_VAR["shipping_address"]["store_info_display_yn"]!='Y'){?> checked <?php }?>> 미노출</label>			
						</td>
					</tr>
					<tr class="area_store_info">
						<th>대표 매장<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/o2o', '#tip4')"></span></th>
						<td>
							<label><input type="checkbox" name="default_yn" id="default_yn" value="Y" <?php if($TPL_VAR["shipping_address"]["default_yn"]=='Y'){?> checked <?php }?>> 사용</label>				
							<input type="hidden" name="origin_default_yn" id="origin_default_yn" value="<?php echo $TPL_VAR["shipping_address"]["default_yn"]?>"/>
							<div class="gray">- 대표 매장은 1곳만 설정 가능합니다. 대표 매장으로 설정된 매장은 메인 페이지(홈페이지 스킨 사용 시)에 노출됩니다. </div>
						</td>
					</tr>
					<tr class="area_store_info">
						<th>영업시간</th>
						<td>
							<select name="sel_store_term_week" id="sel_store_term_week">
								<option value="">요일 선택</option>
<?php if($TPL_store_term_week_1){foreach($TPL_VAR["store_term_week"] as $TPL_K1=>$TPL_V1){?>
								<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }}?>
							</select>
							<select name="sel_store_term_time" id="sel_store_term_time">
<?php if($TPL_store_term_time_1){foreach($TPL_VAR["store_term_time"] as $TPL_K1=>$TPL_V1){?>
								<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }}?>
							</select>
							<span class="sel_store_term_detail">
								<input type="text" name="sel_store_term_hour1" id="sel_store_term_hour1" value="00" class="line" maxlength="2" size="2">
								<span class="gray">:</span>
								<input type="text" name="sel_store_term_min1" id="sel_store_term_min1" value="00" class="line" maxlength="2" size="2">
								<span class="gray" style="margin:0 1px;">~</span>
								<input type="text" name="sel_store_term_hour2" id="sel_store_term_hour2" value="23" class="line" maxlength="2" size="2">
								<span class="gray">:</span>
								<input type="text" name="sel_store_term_min2" id="sel_store_term_min2" value="59" class="line" maxlength="2" size="2">
							</span>							
							<button type="button" class="btnAddStoreTerm btn_plus"></button>
						
							<span class="draw_store_term">
<?php if(is_array($TPL_R1=$TPL_VAR["shipping_address"]["store_term_list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
								<span class="row_store_term">		
									<br>							
									<input type="hidden" name="store_term_week[]"	value="<?php echo $TPL_V1["store_term_week"]?>">
									<input type="hidden" name="store_term_time[]"	value="<?php echo $TPL_V1["store_term_time"]?>">
									<input type="hidden" name="store_term_hour1[]"	value="<?php echo $TPL_V1["store_term_hour1"]?>">
									<input type="hidden" name="store_term_min1[]"	value="<?php echo $TPL_V1["store_term_min1"]?>">
									<input type="hidden" name="store_term_hour2[]"	value="<?php echo $TPL_V1["store_term_hour2"]?>">
									<input type="hidden" name="store_term_min2[]"	value="<?php echo $TPL_V1["store_term_min2"]?>">
									<span class="row_store_term_text"><?php echo $TPL_V1["text"]?></span>
									
									<span>
										<button type="button" class="btnDelStoreTerm btn_minus"></button>
									</span>
								</span>
<?php }}?>
							</span>
						</td>
					</tr>
					<tr class="area_store_info">
						<th>매장 소개</th>
						<td>
							<len>
								<textarea 
									class="cal-len" 
									name="store_description" 
									style="width:98%" 
									rows="5"
									maxlength="500"
									onkeyup="calculate_input_len(this);" 
									onblur="calculate_input_len(this);"
								><?php echo $TPL_VAR["shipping_address"]["store_description"]?></textarea> 
								<span class="view-len">0</span>
							</len>
						</td>
					</tr>
				</table>

				<div class="item-title">POS 연동</div>
				<table class="table_basic thl">					
					<tr>
						<th>POS 연동<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/o2o', '#tip5')"></span></th>
						<td>
							<label class="mr15"><input type="radio" name="store_o2o_use_yn" value="Y" <?php if($TPL_VAR["shipping_address"]["store_o2o_use_yn"]=='Y'){?> checked <?php }?>> 사용함</label>		
							<label><input type="radio" name="store_o2o_use_yn" value="N" <?php if($TPL_VAR["shipping_address"]["store_o2o_use_yn"]!='Y'){?> checked <?php }?>> 사용 안 함</label>
							
							<ul class="bullet_hyphen">
								<li>
									보안서버 인증서(SSL) 설치된 경우에만 정상 작동됩니다. 
									<a class="link_blue_01" href="../setting/protect">설정>보안서버</a>
								</li>	
								<li>
									오프라인(POS) 회원가입 시 휴대폰인증 절차가 추가됩니다. SMS 설정이 완료된 경우에만 정상 작동됩니다. 
									<a class="link_blue_01" href="../member/sms_auth">회원>SMS발송관리</a>
								</li>								
							</ul>							
						</td>
					</tr>
					<tr class="area_store_o2o">
						<th>연동정보<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/o2o', '#tip6')"></span></th>
						<td class="clear">
							<table class="table_basic thl v3">								
								<tr>
									<th>점포코드 <span class="required_chk"></span></th>
									<td>
										<span class="text_show" id="span_store_seq"></span>
										<div class="text_show">
											<input type="text" class="line" style="width: 300px;" 
												   name="store_seq" id="store_seq" value="<?php echo $TPL_VAR["shipping_address"]["store_o2o_info"]["store_seq"]?>" />
											<p class="desc pdt5">
												- 반드시 계약 시 발급받은 점포 코드를 입력하세요.
											</p>
										</div>
									</td>
								</tr>
								<tr class="hide">
									<th>POS 업체</th>
									<td>
										<span class="text_show" id="span_pos_code"></span>
										<div class="text_hide">
											<select class="line"  style="width: 310px;" 
													name="pos_code" id="pos_code" >
<?php if($TPL_o2o_pos_info_1){$TPL_I1=-1;foreach($TPL_VAR["o2o_pos_info"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
												<option value="<?php echo $TPL_K1?>"
<?php if($TPL_I1== 0){?>selected<?php }?>
														><?php echo $TPL_V1["name"]?></option>
<?php }}else{?>
												<option value="">사용 가능한 POS 업체가 없습니다.</option>
<?php }?>
											</select>
										</div>
									</td>
								</tr>
								<tr>
									<th>포스키<span class="required_chk"></span></th>
									<td>
										<input type="text" class="line" style="width: 300px;" 
											   name="tmp_pos_seq" id="tmp_pos_seq" value="" title="POS 계약 시 발급받은 포스키를 입력하세요."/>
										<button type="button" class="btnO2OPosAdd btn_plus"></button>
										<span class="draw_pos_key">
<?php if(is_array($TPL_R1=$TPL_VAR["shipping_address"]["store_o2o_info"]["o2o_config_pos"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
											<span class="row_pos_key">
												<br/>
												<input type="hidden" name="o2o_pos_seq[]"		value="<?php echo $TPL_V1["o2o_pos_seq"]?>">
												<input type="hidden" name="del_o2o_pos_seq[]"	value="">
												<input type="hidden" name="pos_seq[]"			value="<?php echo $TPL_V1["pos_seq"]?>">
												<?php echo $TPL_V1["pos_seq"]?>

												<span>
													<button type="button" class="btnO2OPosDelete btn_minus"></button>
												</span>
											</span>
<?php }}?>
										</span>
									</td>
								</tr>
								<tr>
									<th>연동키</th>
									<td>
<?php if($TPL_VAR["shipping_address"]["store_o2o_info"]["pos_key"]){?>
											<span id="span_pos_key"><?php echo $TPL_VAR["shipping_address"]["store_o2o_info"]["pos_key"]?></span>
											<span class="btnPublishInfoPosKey">											
												<button type="button" class="btn_resp b_gray2">재발급</button>												
											</span>
<?php }else{?>
											<p class="desc pdt5">
												저장 후 자동생성 됩니다. 
											</p>
<?php }?>										
										<input type="hidden" class="line" style="width: 300px;" 
											   name="pos_key" id="pos_key" value="<?php echo $TPL_VAR["shipping_address"]["store_o2o_info"]["pos_key"]?>" />
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr id="div_scm_store" class="<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>area_store_o2o<?php }else{?>hide<?php }?>">
						<th>퍼스트몰 연결 창고</th>
						<td>
							<div>
								<select class="line"  style="width: 310px;" 
										name="scm_store" id="scm_store" >
									<!-- 자동생성은 신규 생성시에만 처리 -->
<?php if(empty($TPL_VAR["shipping_address"]["store_o2o_info"])){?>
									<option value="auto" selected>자동생성</option>
<?php }?>
									<option value="" <?php if($TPL_VAR["shipping_address"]["store_o2o_info"]["scm_store"]==''&&!empty($TPL_VAR["shipping_address"]["store_o2o_info"])){?> selected <?php }?>>미연결</option>
<?php if($TPL_warehouses_1){foreach($TPL_VAR["warehouses"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1["wh_seq"]?>"
<?php if($TPL_V1["wh_seq"]==$TPL_VAR["shipping_address"]["store_o2o_info"]["scm_store"]){?>selected<?php }?>
											><?php echo $TPL_V1["wh_name"]?></option>
<?php }}else{?>
									<option value="">창고가 없습니다.</option>
<?php }?>
								</select>
							</div>
						</td>
					</tr>
				</table>
				</form>
			</div>
			<!-- 추가 수정 레이어 : end -->
							
			<!-- 재발급 안내 레이어 : start -->
			<div class="hide" id="o2oPublishInfoLayer">			
				<ul>
					<li>※ 재발급이 필요한 경우</li>
					<li>- 현재 POS연동에 오류 발생 시 예) 주문수집, 오프라인회원가입불가 등</li>				
				</ul>

				<ul class="red mt10">
					<li>※ 재발급 시 주의 사항</li>
					<li>- 재발급 받은 연동키는 반드시 POS 설치 담당자에게 전달하세요.</li>
				</ul>				

				<div class="mt20 mb10">재발급 시 주의 사항에 대해 충분히 인지하셨다면 아래 [동의]에 체크하시고 재발급을 진행해 주시기 바랍니다.</div>

				<div class="mt20 mb10 center"><label><input type="checkbox" name="agree_yn" id="agree_yn" value="Y">상기 내용에 동의합니다.</label></div>
				
				<div class="mt20 center">
					<button type="button" class="btnPublishPosKey btn_resp b_gray size_a" >재발급</button>
					<button type="button" class="btnCancelPublishPosKey btn_resp b_gray size_a" >취소</button>
				</div>			
			</div>
			<!-- 재발급 안내 레이어 : end -->

			<div class="box_style_05 mt20">
					<div class="title">안내</div>
					<ul class="bullet_circle">	
						<li>매장 안내 노출 설정을 통해 쇼핑몰 스킨에서 매장 정보를 제공할 수 있습니다. (현재 홈페이지 스킨만 반영, 추후 모든 반응형 스킨 반영 예정)</li>
						<li>매장 POS 사용을 원하시는 고객은 먼저 POS를 신청해주시기 바랍니다. <a href="https://www.firstmall.kr/introduce/firstmall/offline" class="link_blue_01" target="_blank">바로가기</a></li>										
					</ul>
				</div>
			
		</div></div></div></div>
		
		</div>
		
	</div>
	<!-- 서브메뉴 바디 : 끝 -->
	
</div>
<!-- 서브 레이아웃 영역 : 끝 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>