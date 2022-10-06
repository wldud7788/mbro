<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/member/member_list.html 000017113 */  $this->include_("o2oAdminMemberListRute");
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<div class="list_info_container">
	<div class="dvs_left">	
		검색 <b><?php echo number_format($TPL_VAR["sc"]["searchcount"])?></b>개 (총 <b><?php echo number_format($TPL_VAR["sc"]["totalcount"])?></b>개)
	</div>
	<div class="dvs_right">	
<?php if($TPL_VAR["pageType"]!="search"){?>
		<select id="orderby_disp" name="orderby_disp">
			<option value="A.regist_date desc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='A.regist_date desc'){?>selected<?php }?>>최근 가입 순</option>
			<option value="A.emoney desc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='A.emoney desc'){?>selected<?php }?>>마일리지 많은 순</option>
			<option value="A.emoney asc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='A.emoney asc'){?>selected<?php }?>>마일리지 적은 순</option>
			<option value="member_order_price desc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='member_order_price desc'){?>selected<?php }?>>구매금액 많은 순</option>
			<option value="member_order_price asc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='member_order_price asc'){?>selected<?php }?>>구매금액 적은 순</option>
			<option value="member_order_cnt desc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='member_order_cnt desc'){?>selected<?php }?>>주문수 많은 순</option>
			<option value="member_order_cnt asc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='member_order_cnt asc'){?>selected<?php }?>>주문수 적은 순</option>
			<option value="A.review_cnt desc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='A.review_cnt desc'){?>selected<?php }?>>상품후기 많은 순</option>
			<option value="A.review_cnt asc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='A.review_cnt asc'){?>selected<?php }?>>상품후기 적은 순</option>
			<option value="A.login_cnt desc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='A.login_cnt desc'){?>selected<?php }?>>방문수 많은 순</option>
			<option value="A.login_cnt asc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='A.login_cnt asc'){?>selected<?php }?>>방문수 적은 순</option>
			<option value="member_recommend_cnt desc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='member_recommend_cnt desc'){?>selected<?php }?>>추천수 많은 순</option>	
			<option value="member_recommend_cnt asc" <?php if($TPL_VAR["sc"]["orderby_disp"]=='member_recommend_cnt asc'){?>selected<?php }?>>추천수 적은 순</option>			
		</select>
<?php }?>
		<select  name="perpage" id="display_quantity">
			<option id="dp_qty10" value="10" <?php if($TPL_VAR["sc"]["perpage"]== 10){?> selected<?php }?> >10개씩</option>
			<option id="dp_qty50" value="50" <?php if($TPL_VAR["sc"]["perpage"]== 50){?> selected<?php }?> >50개씩</option>
			<option id="dp_qty100" value="100" <?php if($TPL_VAR["sc"]["perpage"]== 100){?> selected<?php }?> >100개씩</option>
			<option id="dp_qty200" value="200" <?php if($TPL_VAR["sc"]["perpage"]== 200){?> selected<?php }?> >200개씩</option>
		</select>
	</div>
</div>
	
<div class="table_row_frame">	
<?php if($TPL_VAR["pageType"]!="search"){?>
	<div class="dvs_top">	
		<!--div class="dvs_left">
			<button type="button" class="resp_btn v3 withdrawalBtn">회원 탈퇴</button>
		</div-->
		<div class="dvs_right">	
			<button type="button" class="resp_btn v2 batchForm" mode="email">이메일 발송</button>
			<button type="button" class="resp_btn v2 batchForm" mode="sms" >SMS 발송</button>
			<button type="button" class="resp_btn v2 batchForm" mode="emoney">마일리지 지급</button>
<?php if(serviceLimit('H_FR')){?>
			<span class="<?php echo serviceLimit('C1')?>"><button type="button" onclick="<?php echo serviceLimit('A1')?>" class="resp_btn v2">포인트 지급</button></span>
<?php }else{?>
			<button type="button" class="resp_btn v2 <?php echo $TPL_VAR["point_use_button"]?>" mode="point">포인트 지급</button>
<?php }?>
			<button type="button" class="resp_btn v2 gradeForm">승인/등급 일괄 변경</button>
			<button type="button" name="excel_down" class="resp_btn v3"><img src="/admin/skin/default/images/common/btn_img_ex.gif" /><span>다운로드</span></button>
		</div>
	</div>
<?php }?>

	<!-- 주문리스트 테이블 : 시작 -->
	<table class="table_row_basic tdc">
		<!-- 테이블 헤더 : 시작 -->
		<colgroup>		
		
<?php if($TPL_VAR["pageType"]=="search"){?>
			<col width="7%" /><!-- checkbox -->
			<col width="7%" /><!-- 번호 -->
			<col width="12%" /><!-- 아이디 -->
			<col width="12%" /><!-- 이름 -->
			<col /><!-- 이메일/핸드폰 -->			
			<col width="10%"/><!-- 승인 -->
			<col width="10%"/><!-- 등급 -->
			<col width="10%" /><!-- 유형 -->	
<?php }else{?>
			<col width="5%" /><!-- 번호 -->
			<col width="15%" /><!-- 아이디 -->
			<col width="10%" /><!-- 이름 -->
			<col /><!-- 이메일/핸드폰 -->			
			<col width="6%"/><!-- 승인 -->
			<col width="6%"/><!-- 등급 -->
			<col width="6%" /><!-- 유형 -->
			<col width="7%" /><!-- 마일리지 -->
			<col width="7%"/><!-- 포인트 -->
			<col width="7%" /><!-- 예치금 -->
			<col width="10%"/><!-- 가입일/최종방문 -->	
			<col width="5%" /><!-- 관리 -->
<?php }?>
		</colgroup>
		<thead class="lth">
		<tr>
<?php if($TPL_VAR["pageType"]=="search"){?>
			<th><label class="resp_checkbox"><input type="checkbox" defaultValue="false" onclick="chkAll(this,'member_chk'); allMemberClick();" class="all_member_chk"/></label></th>
<?php }else{?>
			<th class="hide"><label class="resp_checkbox"><input type="checkbox" defaultValue="false" onclick="chkAll(this,'member_chk');"/></label></th>
<?php }?>
			<th <?php if($TPL_VAR["pageType"]!="search"){?>class="bdl0"<?php }?>>번호</th>				
			<th>아이디</th>
			<th>이름(닉네임)</th>
			<th>이메일</br>핸드폰</th>			
			<th>승인</th>
			<th>등급</th>
			<th>유형</th>
<?php if($TPL_VAR["pageType"]!="search"){?>
			<th>마일리지</th>
			<th>포인트</th>
			<th>예치금</th>
			<th>가입일<br/>최종방문</th>
<?php }?>
<?php if($TPL_VAR["loadType"]!="layer"){?>
			<th>관리</th>
<?php }?>
		</tr>
		</thead>
		<!-- 테이블 헤더 : 끝 -->

		<!-- 리스트 : 시작 -->
		<tbody>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
<?php if($TPL_V1["status_nm"]!='휴면'){?>
			<tr>
<?php if($TPL_VAR["pageType"]=="search"){?>
				<td><label class="resp_checkbox"><input type="checkbox" name="member_chk[]" value="<?php echo $TPL_V1["member_seq"]?>" defaultValue="false" class="member_chk" onclick="selectMemberClick(this);" grade="<?php echo $TPL_V1["group_seq"]?>"  grade_name="<?php echo $TPL_V1["group_name"]?>" /></label></td>			
<?php }else{?>
				<td class="hide"><label class="resp_checkbox"><input type="checkbox" name="member_chk[]" value="<?php echo $TPL_V1["member_seq"]?>" defaultValue="false" cellphone="<?php echo $TPL_V1["cellphone"]?>" email="<?php echo $TPL_V1["email"]?>" grade="<?php echo $TPL_V1["group_seq"]?>" grade_name="<?php echo $TPL_V1["group_name"]?>" class="member_chk"/></label></td>					
<?php }?>

				<td <?php if($TPL_VAR["pageType"]!="search"){?>class="bdl0"<?php }?>><?php echo $TPL_V1["number"]?></td>
							
				<td class="left" >		
					<span class="resp_btn_txt v2" onclick="window.open('/admincrm/main/user_detail?member_seq=<?php echo $TPL_V1["member_seq"]?>');">
<?php if($TPL_V1["snslist"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["snslist"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["rute"]){?>
							<span class="blue">
<?php if($TPL_V2["rute"]=='facebook'&&$TPL_V2["sns_f_type"]== 0){?>
							<img src="/admin/skin/default/images/sns/sns_f00.gif" align="absmiddle">
<?php }elseif($TPL_V2["rute"]=='twitter'&&$TPL_V2["sns_t_type"]== 0){?>
							<img src="/admin/skin/default/images/sns/sns_t0_gray.gif" align="absmiddle">
<?php }else{?>
							<img src="/admin/skin/default/images/sns/sns_<?php echo substr($TPL_V2["rute"], 0, 1)?>0.gif" align="absmiddle">
<?php }?>
							</span>
<?php }?>
<?php }}?>
<?php }?>
						
						<?php echo o2oAdminMemberListRute($TPL_V1)?>

<?php if(($TPL_V1["rute"]&&$TPL_V1["rute"]=='none')||$TPL_V1["sns_change"]== 1){?>
							<?php echo $TPL_V1["userid"]?>

<?php }elseif(($TPL_V1["rute"]&&$TPL_V1["rute"]=='naver')&&$TPL_V1["sns_change"]!= 1){?>
							<?php echo $TPL_V1["conv_sns_n"]?>

<?php }else{?>
							<?php echo $TPL_V1["userid"]?>

<?php }?>
					</span>

<?php if(($TPL_V1["rute"]&&$TPL_V1["rute"]=='none')||$TPL_V1["sns_change"]== 1){?>
<?php if($TPL_V1["mall_t_check"]=='Y'){?><span style="position:relation;padding:0px 5px 0px 5px;margin-left:7px;color:#FFBB00;border:1px solid;">TEST</span><?php }?>
<?php }?>
<?php if(($TPL_V1["rute"]&&$TPL_V1["rute"]=='naver')&&$TPL_V1["sns_change"]!= 1){?>
<?php if($TPL_V1["mall_t_check"]=='Y'){?><span style="position:relation;padding:0px 5px 0px 5px;margin-left:7px;color:#FFBB00;border:1px solid;">TEST</span><?php }?>
<?php }?>
				</td>
				<td class="left"><?php echo $TPL_V1["user_name"]?><?php if($TPL_V1["nickname"]){?>(<?php echo $TPL_V1["nickname"]?>)<?php }?></td>

				<td class="left">
<?php if($TPL_VAR["loadType"]=="layer"){?>
<?php if((!$TPL_V1["email"]||$TPL_V1["email"]=='--')&&(!$TPL_V1["bcellphone"]||$TPL_V1["bcellphone"]=='--')&&(!$TPL_V1["cellphone"]||$TPL_V1["cellphone"]=='--')){?>
					<span>없음</span>
<?php }else{?>
					<span>
<?php if($TPL_V1["email"]&&$TPL_V1["email"]!='--'){?>
					<?php echo $TPL_V1["email"]?>(<?php echo strtoupper($TPL_V1["mailing"])?>)
<?php }else{?>
					없음
<?php }?>
					</span>

					<span>
<?php if(($TPL_V1["bcellphone"]&&$TPL_V1["bcellphone"]!='--')||($TPL_V1["cellphone"]&&$TPL_V1["cellphone"]!='--')){?>
<?php if($TPL_V1["bcellphone"]){?><?php echo $TPL_V1["bcellphone"]?><?php }else{?><?php echo $TPL_V1["cellphone"]?><?php }?>(<?php echo strtoupper($TPL_V1["sms"])?>)
<?php }else{?>
					없음
<?php }?>
					</span>
<?php }?>
<?php }else{?>
<?php if((!$TPL_V1["email"]||$TPL_V1["email"]=='--')&&(!$TPL_V1["bcellphone"]||$TPL_V1["bcellphone"]=='--')&&(!$TPL_V1["cellphone"]||$TPL_V1["cellphone"]=='--')){?>
					<p>없음</p>
<?php }else{?>
					<p class="resp_btn_txt v2">
<?php if($TPL_V1["email"]&&$TPL_V1["email"]!='--'){?>
					<span <?php if($TPL_VAR["pageType"]!="search"){?>onclick="select_email('<?php echo $TPL_V1["member_seq"]?>', '<?php echo $TPL_V1["email"]?>');"<?php }?>><?php echo $TPL_V1["email"]?></span>
					(<?php echo strtoupper($TPL_V1["mailing"])?>)
<?php }else{?>
					없음
<?php }?>
					</p>

					<p class="resp_btn_txt v2">
<?php if(($TPL_V1["bcellphone"]&&$TPL_V1["bcellphone"]!='--')||($TPL_V1["cellphone"]&&$TPL_V1["cellphone"]!='--')){?>
					<span <?php if($TPL_VAR["pageType"]!="search"){?>onclick="select_sms('<?php echo $TPL_V1["member_seq"]?>');"<?php }?>><?php if($TPL_V1["bcellphone"]){?><?php echo $TPL_V1["bcellphone"]?><?php }else{?><?php echo $TPL_V1["cellphone"]?><?php }?></span>
					(<?php echo strtoupper($TPL_V1["sms"])?>)
<?php }else{?>
					없음
<?php }?>
					</p>
<?php }?>
<?php }?>
				</td>
				<!--td align="center"><a href="javascript:select_email('<?php echo $TPL_V1["member_seq"]?>');"><?php echo $TPL_V1["email"]?></a> (<?php echo strtoupper($TPL_V1["mailing"])?>)</td>
				<td align="center"><a href="javascript:select_sms('<?php echo $TPL_V1["member_seq"]?>');"><?php if($TPL_V1["bcellphone"]){?><?php echo $TPL_V1["bcellphone"]?><?php }else{?><?php echo $TPL_V1["cellphone"]?><?php }?></a> (<?php echo strtoupper($TPL_V1["sms"])?>)</td-->
				<td><?php echo $TPL_V1["status_nm"]?></td>
				<td><?php echo $TPL_V1["group_name"]?></td>
				<td><?php echo $TPL_V1["type"]?></td>				
<?php if($TPL_VAR["pageType"]!="search"){?>
<?php if($TPL_VAR["loadType"]=="layer"){?>
				<td class="right"><?php echo get_currency_price($TPL_V1["emoney"])?></td>
				<td class="right"><?php echo get_currency_price($TPL_V1["point"])?></td>
				<td class="right"><?php echo get_currency_price($TPL_V1["cash"])?></td>
<?php }else{?>
				<td class="right">
					<a href="/admincrm/member/emoney_list?member_seq=<?php echo $TPL_V1["member_seq"]?>" class="resp_btn_txt v2" target="_blank"><?php echo get_currency_price($TPL_V1["emoney"])?></a>
				</td>
				<td class="right">
<?php if($TPL_VAR["reserveinfo"]["point_use"]=='Y'){?>
					<a href="/admincrm/member/point_list?member_seq=<?php echo $TPL_V1["member_seq"]?>" class="resp_btn_txt v2" target="_blank">
<?php }else{?>
					<a href="javascript:void(0)" onclick="point_not_use();" class="resp_btn_txt v2">
<?php }?>
					<?php echo get_currency_price($TPL_V1["point"])?>

					</a>
				</td>
				<td class="right">
					<a href="/admincrm/member/cash_list?member_seq=<?php echo $TPL_V1["member_seq"]?>" class="resp_btn_txt v2" target="_blank"><?php echo get_currency_price($TPL_V1["cash"])?></a>
				</td>
<?php }?>
				<td><?php echo $TPL_V1["regist_date"]?><br/><?php echo $TPL_V1["lastlogin_date"]?></td>
<?php }?>
<?php if($TPL_VAR["loadType"]!="layer"){?>
				<td><input type="button" name="manager_modify_btn" value="수정" <?php if($TPL_VAR["pageType"]!="search"){?>onclick="window.open('/admincrm/member/detail?member_seq=<?php echo $TPL_V1["member_seq"]?>');"<?php }?> class="resp_btn v2"/></span></td>
<?php }?>
			</tr>
<?php }else{?>
			<tr>
<?php if($TPL_VAR["pageType"]=="search"){?>
				<td><label class="resp_checkbox"><input type="checkbox" name="member_chk[]" defaultValue="false" value="<?php echo $TPL_V1["member_seq"]?>" cellphone="<?php echo $TPL_V1["cellphone"]?>" email="<?php echo $TPL_V1["email"]?>" class="member_chk"/></label></td>
<?php }else{?>
				<td class="hide"><label class="resp_checkbox"><input type="checkbox" name="member_chk[]" defaultValue="false" value="<?php echo $TPL_V1["member_seq"]?>" cellphone="<?php echo $TPL_V1["cellphone"]?>" email="<?php echo $TPL_V1["email"]?>" class="member_chk"/></label></td>
<?php }?>
				<td><?php echo $TPL_V1["number"]?></td>			
				<td class="left" onclick="window.open('/admincrm/main/user_detail?member_seq=<?php echo $TPL_V1["member_seq"]?>');">			
					<span class='red'>(휴면)</span>
					<span class="resp_btn_txt v2"><?php echo $TPL_V1["userid"]?></span>
				</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>				
				<td>-</td>
				<td>-</td>
<?php if($TPL_VAR["pageType"]!="search"){?>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
<?php }?>
<?php if($TPL_VAR["loadType"]!="layer"){?>
				<td><input type="button" name="manager_modify_btn" value="수정" <?php if($TPL_VAR["pageType"]!="search"){?>onclick="window.open('/admincrm/main/user_detail?member_seq=<?php echo $TPL_V1["member_seq"]?>');"<?php }?> class="resp_btn v2"/></td>
<?php }?>
			</tr>
<?php }?>
			<!-- 리스트데이터 : 끝 -->
<?php }}?>
<?php }else{?> 
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr>
<?php if($TPL_VAR["loadType"]!="layer"){?>
				<td colspan="16">
<?php }else{?>
				<td <?php if($TPL_VAR["pageType"]!="search"){?>colspan="15"<?php }else{?>colspan="14"<?php }?>>
<?php }?>
<?php if($TPL_VAR["search_text"]){?>
						'<?php echo $TPL_VAR["search_text"]?>' 검색된 회원이 없습니다.
<?php }else{?>
						등록된 회원이 없습니다.
<?php }?>
				</td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }?>
		</tbody>
		<!-- 리스트 : 끝 -->

	</table>
	<!-- 주문리스트 테이블 : 끝 -->
<?php if($TPL_VAR["pageType"]!="search"){?>
	<div class="dvs_bottom">	
		<!--div class="dvs_left">
			<button type="button" class="resp_btn v3 withdrawalBtn">회원 탈퇴</button>
		</div-->
		<div class="dvs_right">	
			<button type="button" class="resp_btn v2 batchForm" mode="email">이메일 발송</button>
			<button type="button" class="resp_btn v2 batchForm" mode="sms" >SMS 발송</button>
			<button type="button" class="resp_btn v2 batchForm" mode="emoney">마일리지 지급</button>
<?php if(serviceLimit('H_FR')){?>
			<span class="<?php echo serviceLimit('C1')?>"><button type="button" onclick="<?php echo serviceLimit('A1')?>" class="resp_btn v2">포인트 지급</button></span>
<?php }else{?>
			<button type="button" class="resp_btn v2 <?php echo $TPL_VAR["point_use_button"]?>" mode="point">포인트 지급</button>
<?php }?>
			<button type="button" class="resp_btn v2 gradeForm">승인/등급 일괄 변경</button>
			<button type="button" name="excel_down" class="resp_btn v3"><img src="/admin/skin/default/images/common/btn_img_ex.gif"/><span>다운로드</span></button>
		</div>
	</div>
<?php }?>
</div>
<div id="sendPopup" class="hide"></div>
<div id="emoneyPopup" class="hide"></div>
<div id="download_list_setting" class="hide"></div>