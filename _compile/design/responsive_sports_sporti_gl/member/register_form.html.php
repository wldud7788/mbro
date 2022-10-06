<?php /* Template_ 2.2.6 2022/10/05 15:09:04 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/member/register_form.html 000042807 */ 
$TPL_email_arr_1=empty($TPL_VAR["email_arr"])||!is_array($TPL_VAR["email_arr"])?0:count($TPL_VAR["email_arr"]);
$TPL_m_arr_1=empty($TPL_VAR["m_arr"])||!is_array($TPL_VAR["m_arr"])?0:count($TPL_VAR["m_arr"]);
$TPL_d_arr_1=empty($TPL_VAR["d_arr"])||!is_array($TPL_VAR["d_arr"])?0:count($TPL_VAR["d_arr"]);
$TPL_memberIcondata_1=empty($TPL_VAR["memberIcondata"])||!is_array($TPL_VAR["memberIcondata"])?0:count($TPL_VAR["memberIcondata"]);
$TPL_form_sub_1=empty($TPL_VAR["form_sub"])||!is_array($TPL_VAR["form_sub"])?0:count($TPL_VAR["form_sub"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 회원가입 입력폼 @@
- 파일위치 : [스킨폴더]/member/register_form.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div id="marketingDeatilLayer" class="resp_layer_pop hide">
	<h4 class="title">마케팅 및 광고 활용 동의</h4>
	<div class="y_scroll_auto2">
		<div class="layer_pop_contents v5">
			<?php echo nl2br($TPL_VAR["policy_marketing"])?>

		</div>
	</div>
	<div class="layer_bottom_btn_area2">
		<button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>
<div id="formMemberArea" class="resp_member_join">

<!-- O2O 통합 가입 안내 -->
<?php if($TPL_VAR["checkO2ORequired"]){?>
<?php $this->print_("o2o_member_join_gate",$TPL_SCP,1);?>

<?php }?>

<?php if($TPL_VAR["mtype"]=='member'){?>
	<input type="hidden" name="kid_agree" value="<?php echo $TPL_VAR["kid_agree"]?>"/>
	<div class="resp_join_table">
<?php if($TPL_VAR["rute"]&&$TPL_VAR["rute"]!='none'){?>
<?php if($TPL_VAR["sns_change"]== 0){?>
				<ul>
					<li class="th"><p designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >아이디 / 비밀번호</p></li>
					<li class="td"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >아직 등록하지 않았습니다.</span> <button type="button" class="btn_resp size_b color2" onclick="sns_change_id();"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >등록</span></button></li>
				</ul>
<?php }else{?>
		
				<ul class="required">
					<li class="th"><p designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >아이디/이메일</p></li>
					<li class="td"><?php echo $TPL_VAR["userid"]?></li>
				</ul>
				
				<ul class="required">
					<li class="th"><p designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >기존 비밀번호</p></li>
					<li class="td">
						<input type="password" name="old_password" value="" class="eng_only" />
					</li>
				</ul>
				<ul>
					<li class="th"><p designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >신규 비밀번호</p></li>
					<li class="td">
						<input type="password" name="new_password" value="" class="eng_only class_check_password_validation"/>
					</li>
				</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["user_name_use"]=='Y'){?>
				<ul <?php if($TPL_VAR["joinform"]["user_name_required"]=='Y'){?>class="required"<?php }?>>
					<li class="th"><p designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >이름</p></li>
					<li class="td">
						<input type="text" name="user_name" value="<?php echo $TPL_VAR["user_name"]?>" <?php if($TPL_VAR["user_name"]){?>readonly<?php }?> />
					</li>
				</ul>
<?php }?>
<?php }else{?>
			<ul class="required">
				
				<li class="th "><p designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >아이디/이메일</p></li>
				<li class="td">
<?php if($TPL_VAR["member_seq"]){?>
						<?php echo $TPL_VAR["userid"]?>

<?php }else{?>
						<input type="email" name="userid" id="userid" autocomplete="off" autocapitalize="off" value="" placeholder="공백 없는 영문/숫자 포함 6~20자" />
						<p id="id_info" class="guide_text"></p>
<?php }?>
				</li>
				
			</ul>
<?php if($TPL_VAR["joinform"]["email_use"]=='Y'){?>
			<!-- 20220314 내 아이디 보이기 by khj -->
<?php if($TPL_VAR["formtype"]=='email'){?>
				<ul>
					<li class="th">
						<p designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >
							아이디
						</p>
					</li>
					<li class="td">
						<input type="text" name="mypage_userid" value="<?php echo $TPL_VAR["userid"]?>" readonly>
					</li>
				</ul>
<?php }?>
			<!-- 정보수정 페이지에서 이메일 부분 주석 처리 by khj -->
<?php if($TPL_VAR["formtype"]=='member'){?>
				<ul <?php if($TPL_VAR["joinform"]["email_required"]=='Y'){?>class="required"<?php }?>>
					<li class="th "><p designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >
						<!--2022.01.13 회원가입,마이페이지 같은 입력폼 사용으로 사용하는 이름 다름-->
<?php if($TPL_VAR["formtype"]=='member'){?>이메일아이디<?php }?>
<?php if($TPL_VAR["formtype"]=='email'){?> 이메일 <?php }?>
					</p></li>
					<li class="td">
						<input type="email" name="email[0]" value="<?php echo str_split_arr($TPL_VAR["email"],'@', 0)?>" class="size_mail1" /> @
						<input type="email" id="addInput" name="email[1]" value="<?php echo str_split_arr($TPL_VAR["email"],'@', 1)?>" class="size_mail2" />
						<select name="find_email" id="find_email" onchange="cngadd(this.value);">
							<option value="">직접입력</option>
<?php if($TPL_email_arr_1){foreach($TPL_VAR["email_arr"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["codecd"]?>"><?php echo $TPL_V1["codecd"]?></option>
<?php }}?>
						</select>
					</li>
				</ul>
<?php }?>
<?php }?>
<?php if($TPL_VAR["member_seq"]){?>
				<ul class="required">
					<li class="th "><p designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >기존 비밀번호</p></li>
					<li class="td">
						<input type="password" name="old_password" placeholder="8자이상"  value="" class="eng_only" />
					</li>
				</ul>
				<ul>
					<li class="th"><p designElement="text" textIndex="12"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >신규 비밀번호</p></li>
					<li class="td">
						<input type="password" name="new_password" placeholder="8자이상"  value="" class="eng_only class_check_password_validation" />
					</li>
				</ul>
<?php }else{?>
				<ul class="required">
					<li class="th "><p designElement="text" textIndex="13"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >비밀번호</p></li>
					<li class="td">
						<input type="password" name="password" placeholder="8자이상"  value="" class="eng_only class_check_password_validation" />
					</li>
				</ul>
				<ul class="required">
					<li class="th "><p designElement="text" textIndex="14"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >비밀번호 확인</p></li>
					<li class="td">
						<input type="password" name="re_password" placeholder="8자이상"  value="" class="eng_only" />
					</li>
				</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["user_name_use"]=='Y'){?>
				<ul <?php if($TPL_VAR["joinform"]["user_name_required"]=='Y'){?>class="required"<?php }?>>
					<li class="th "><p designElement="text" textIndex="15"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >이름</p></li>
					<li class="td">
						<input type="text" name="user_name" value="<?php echo $TPL_VAR["user_name"]?>" <?php if($TPL_VAR["user_name"]){?>readonly<?php }?> />
					</li>
				</ul>
<?php }?>
<?php }?>

<?php if($TPL_VAR["joinform"]["phone_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["phone_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th "><p designElement="text" textIndex="16"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >전화번호</p></li>
				<li class="td">
					<input type="tel" name="phone[]" value="<?php echo str_split_arr($TPL_VAR["phone"],'-', 0)?>" class="size_phone" maxlength="4" /> -
					<input type="tel" name="phone[]" value="<?php echo str_split_arr($TPL_VAR["phone"],'-', 1)?>" class="size_phone" maxlength="4" /> -
					<input type="tel" name="phone[]" value="<?php echo str_split_arr($TPL_VAR["phone"],'-', 2)?>" class="size_phone" maxlength="4" />
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["cellphone_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["cellphone_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th "><p designElement="text" textIndex="17"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >휴대폰번호</p></li>
				<li class="td">
					<input type="tel" name="cellphone[]" value="<?php echo str_split_arr($TPL_VAR["cellphone"],'-', 0)?>" class="size_phone" maxlength="4" <?php if($TPL_VAR["regitst_auth"]){?>readonly<?php }?> /> -
					<input type="tel" name="cellphone[]" value="<?php echo str_split_arr($TPL_VAR["cellphone"],'-', 1)?>" class="size_phone" maxlength="4" <?php if($TPL_VAR["regitst_auth"]){?>readonly<?php }?> /> -
					<input type="tel" name="cellphone[]" value="<?php echo str_split_arr($TPL_VAR["cellphone"],'-', 2)?>" class="size_phone" maxlength="4" <?php if($TPL_VAR["regitst_auth"]){?>readonly<?php }?> />
<?php if($TPL_VAR["confirmPhone"]=='Y'){?>
					<script>$("input[name='cellphone[]']").attr("disabled",true);</script>
					<button type="button" class="btn_resp size_b color2" onclick="authphone_popup('cellphone');"><span designElement="text" textIndex="18"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >휴대폰인증</span></button>
<?php }?>
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["member_seq"]&&($TPL_VAR["joinform"]["email_use"]=='Y'||$TPL_VAR["joinform"]["cellphone_use"]=='Y')){?>
			<ul>
				<li class="th "><p designElement="text" textIndex="19"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >마케팅 및 광고 활용 동의</p><a href="javascript:void(0)" onclick="showCenterLayer('#marketingDeatilLayer')" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ><!--<span class="ml10 Und">보기</span>--></a></li>
				<li class="td">
					<div class="Pt10">
<?php if($TPL_VAR["joinform"]["email_use"]=='Y'){?>
						<label class="ml10"><input type="checkbox" name="mailing" value="y" class="mr5"/> <span designElement="text" textIndex="20"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >이메일 수신</span></label>
<?php }?>
<?php if($TPL_VAR["joinform"]["cellphone_use"]=='Y'){?>
						<label class="ml10"><input type="checkbox" name="sms" value="y" class="mr5"/> <span designElement="text" textIndex="21"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >SMS 수신</span></label>
<?php }?>
					</div>
					<p class="Pt10 desc" designElement="text" textIndex="22"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" ><?php if($TPL_VAR["joinform"]["email_use"]=='Y'){?>이메일<?php }?><?php if($TPL_VAR["joinform"]["email_use"]=='Y'&&$TPL_VAR["joinform"]["cellphone_use"]=='Y'){?>,<?php }?> <?php if($TPL_VAR["joinform"]["cellphone_use"]=='Y'){?>SMS<?php }?> 수신에 동의하시면 여러가지 할인해택과 각종 이벤트 정보를 받아보실 수 있습니다.</br>회원가입관련,주문배송관련 등의 정보는 수신동의와 상관없이 구매 회원에게 발송됩니다.</p>
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["address_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["address_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th "><p designElement="text" textIndex="23"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >주소</p></li>
				<li class="td">
					<input type="hidden" name="address_type" value="<?php echo $TPL_VAR["address_type"]?>"/>
					<input type="tel" name="new_zipcode" value="<?php echo $TPL_VAR["new_zipcode"]?>" class="size_zip_all" readonly />
					<button type="button" class="btn_resp size_b color4" onclick="openDialogZipcode_resp('member');"><span designElement="text" textIndex="24"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >주소찾기</span></button>
					<div class="address_area">
						<input type="text" name="address" value="<?php echo $TPL_VAR["address"]?>" class="address size_full <?php if($TPL_VAR["address_type"]=='street'){?>hide<?php }?>" readonly />
						<input type="text" name="address_street" value="<?php echo $TPL_VAR["address_street"]?>" class="address_street size_full <?php if($TPL_VAR["address_type"]!='street'){?>hide<?php }?>" readonly />
					</div>
					<div class="address_area">
						<input type="text" name="address_detail" value="<?php echo $TPL_VAR["address_detail"]?>" class="size_full" />
					</div>
<?php if($TPL_VAR["member_seq"]){?>
<?php if($TPL_VAR["address_type"]=="street"){?>
							<button type="button" class="btn_resp size_b" onclick="view_address('zibun');">지번 주소보기</button>
<?php }else{?>
<?php if($TPL_VAR["address_street"]){?>
								<button type="button" class="btn_resp size_b" onclick="view_address('street');">도로명 주소보기</button>
<?php }?>
<?php }?>
<?php }?>
					<p id="address_view" style="padding-top:5px; display:none;"></p>
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["nickname_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["nickname_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th "><p designElement="text" textIndex="25"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >닉네임</p></li>
				<li class="td">
					<input type="text" name="nickname" value="<?php echo $TPL_VAR["nickname"]?>" maxlength="10" />
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["birthday_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["birthday_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th "><p designElement="text" textIndex="26"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >생년월일</p></li>
				<li class="td">
					<label>
						<input type="text" name="birthday" value="<?php echo $TPL_VAR["birthday"]?>" class="datepicker" style="width:110px;" readonly />
						<span class="btn_resp size_b" designElement="text" textIndex="27"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >찾기</span>
					</label>
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["anniversary_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["anniversary_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th "><p designElement="text" textIndex="28"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >기념일</p></li>
				<li class="td">
					<select name="anniversary[]">
						<option value="">선택</option>
<?php if($TPL_m_arr_1){foreach($TPL_VAR["m_arr"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1?>" <?php if(substr($TPL_VAR["anniversary"], 0, 2)==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
					</select> <span designElement="text" textIndex="29"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >월</span> &nbsp;
					<select name="anniversary[]">
						<option value="">선택</option>
<?php if($TPL_d_arr_1){foreach($TPL_VAR["d_arr"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1?>" <?php if(substr($TPL_VAR["anniversary"], 3, 2)==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
					</select> <span designElement="text" textIndex="30"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >일</span>
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["sex_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["sex_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th "><p designElement="text" textIndex="31"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >성별</p></li>
				<li class="td designed_radio_checkbox join_form">
					<label><input type="radio" name="sex" value="male" <?php if($TPL_VAR["sex"]=='male'){?>checked<?php }?> /> <span designElement="text" textIndex="32"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >남성</span></label>
					<label><input type="radio" name="sex" value="female"  <?php if($TPL_VAR["sex"]=='female'){?>checked<?php }?>  /> <span designElement="text" textIndex="33"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >여성</span></label>
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["user_icon"]=='Y'){?>
			<ul>
				<li class="th"><p designElement="text" textIndex="34"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >아이콘</p></li>
				<li class="td">
					<ul class="member_icon_list">
<?php if($TPL_memberIcondata_1){$TPL_I1=-1;foreach($TPL_VAR["memberIcondata"] as $TPL_V1){$TPL_I1++;?>
							<li>
								<label class="lab1">
									<div class="Mb4"><input type="radio" name="user_icon" value="<?php echo ($TPL_I1+ 1)?>" <?php if($TPL_VAR["user_icon"]==($TPL_I1+ 1)){?> checked="checked" <?php }?> /></div>
									<img src="/data/icon/member/<?php echo $TPL_V1?>" class="icon_membericon" designImgSrcOri='L2RhdGEvaWNvbi9tZW1iZXIvey52YWx1ZV99' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=' designImgSrc='L2RhdGEvaWNvbi9tZW1iZXIvey52YWx1ZV99' designElement='image' />
								</label>
							</li>
<?php }}?>
<?php if($TPL_VAR["member_seq"]){?>
							<li>
								<label class="lab1 L">
									<div class="Mb4">
										<input type="radio" name="user_icon" value="99" <?php if($TPL_VAR["user_icon"]== 99&&$TPL_VAR["user_icon_file"]){?> checked="checked" <?php }?> />
										<button type="button" class="btn_resp size_a Ml4" id="membericonUpdate">직접등록</button>
									</div>
									<img src="/data/icon/member/<?php echo $TPL_VAR["user_icon_file"]?>" id="membericon_img" <?php if(!$TPL_VAR["user_icon_file"]){?> class="hide" <?php }?> designImgSrcOri='L2RhdGEvaWNvbi9tZW1iZXIve3VzZXJfaWNvbl9maWxlfQ==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=' designImgSrc='L2RhdGEvaWNvbi9tZW1iZXIve3VzZXJfaWNvbl9maWxlfQ==' designElement='image' />
								</label>
							</li>
<?php }?>
					</ul>
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["recommend_use"]=='Y'){?>
<?php if($TPL_VAR["member_seq"]&&$TPL_VAR["recommend"]){?>
				<ul <?php if($TPL_VAR["joinform"]["recommend_required"]=='Y'){?>class="required"<?php }?>>
					<li class="th "><p designElement="text" textIndex="35"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >추천인ID</p></li>
					<li class="td"><?php echo $TPL_VAR["recommend"]?></li>
				</ul>
<?php }elseif(!$TPL_VAR["member_seq"]){?>
				<ul <?php if($TPL_VAR["joinform"]["recommend_required"]=='Y'){?>class="required"<?php }?>>
					<li class="th "><p designElement="text" textIndex="36"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >추천인ID</p></li>
					<li class="td">
						<input type="text" name="recommend" id="recommend" value="<?php echo $TPL_VAR["recommend"]?>" style="width:160px;" />
						<button type="button" onclick="chkRecommend('u');" class="btn_resp size_b">확인</button>
						<p id="recommend_return_txt" class="guide_text"></p>
						<ul class="list_01 v3 desc pd_1">
						<!--
<?php if($TPL_VAR["emoneyapp"]["emoneyJoin"]> 0){?>
							<li>신규회원 -  마일리지 <span class="pointcolor"><?php echo number_format($TPL_VAR["emoneyapp"]["emoneyJoin"])?></span>원 지급</li>
<?php }?>
						-->
<?php if($TPL_VAR["emoneyapp"]["emoneyJoiner"]> 0){?>
							<li><p designElement="text" textIndex="37"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >추천인ID 입력시 - 마일리지 <span class="pointcolor"><?php echo number_format($TPL_VAR["emoneyapp"]["emoneyJoiner"])?></span>원 추가지급</p></li>
<?php }?>
<?php if($TPL_VAR["emoneyapp"]["emoneyRecommend"]> 0){?>
							<li><p designElement="text" textIndex="38"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >추천받은 회원 - 마일리지 <span class="pointcolor2"><?php echo $TPL_VAR["emoneyapp"]["emoneyRecommend"]?></span>원 지급</p></li>
<?php }?>
						</ul>
					</li>
				</ul>
<?php }?>
<?php }?>
<?php if($TPL_VAR["fb_invite"]){?>
			<ul>
				<li class="th "><p designElement="text" textIndex="39"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >Facebook 초대한ID</p></li>
				<li class="td"><input type="text" name="fb_invite" value="<?php echo $TPL_VAR["fb_invite"]?>" /></li>
			</ul>
<?php }?>

<?php if($TPL_VAR["form_sub"]){?>
<?php if($TPL_form_sub_1){foreach($TPL_VAR["form_sub"] as $TPL_V1){?>
<?php if($TPL_V1["used"]=='Y'&&$TPL_V1["join_type"]=='user'){?>
<?php if($TPL_V1["required"]=='Y'){?>
						<ul class="form_sub required">
							<li class="th">
								<p><input type="hidden" name="required[]" value="<?php echo $TPL_V1["joinform_seq"]?>"><input type="hidden" name="required_title[]" value="<?php echo $TPL_V1["label_title"]?>"><?php echo $TPL_V1["label_title"]?></p>
							</li>
<?php }else{?>
						<ul class="form_sub">
							<li class="th">
								<p><?php echo $TPL_V1["label_title"]?></p>
							</li>
<?php }?>
							<li class="td custom_form designed_radio_checkbox join_form">
								<?php echo $TPL_V1["label_view"]?>

<?php if($TPL_V1["label_desc"]){?><p class="desc pd_2"><?php echo $TPL_V1["label_desc"]?></p><?php }?>
							</li>
						</ul>
<?php }?>
<?php }}?>
<?php }?>
	</div>
<?php }?>


<?php if($TPL_VAR["mtype"]=='business'){?>
	<div class="resp_join_table">
<?php if($TPL_VAR["rute"]&&$TPL_VAR["rute"]!='none'){?>
			<input type="hidden" name="user_name" value="<?php echo $TPL_VAR["user_name"]?>" />
<?php if($TPL_VAR["sns_change"]== 0){?>
				<ul>
					<li class="th"><p designElement="text" textIndex="40"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >아이디 / 비밀번호</p></li>
					<li class="td"><span designElement="text" textIndex="41"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >아직 등록하지 않았습니다.</span> <button type="button" class="btn_resp size_b color2" onclick="sns_change_id();"><span designElement="text" textIndex="42"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >등록</span></button></li>
				</ul>
<?php }else{?>
				<ul class="required">
					<li class="th"><p designElement="text" textIndex="43"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >아이디</p></li>
					<li class="td"><?php echo $TPL_VAR["userid"]?></li>
				</ul>
				<ul class="required">
					<li class="th"><p designElement="text" textIndex="44"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >기존 비밀번호</p></li>
					<li class="td"><input type="password" name="old_password" value="" class="eng_only" /></li>
				</ul>
				<ul>
					<li class="th"><p designElement="text" textIndex="45"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >신규 비밀번호</p></li>
					<li class="td">
						<input type="password" name="new_password" value="" class="eng_only class_check_password_validation" />
					</li>
				</ul>
<?php }?>
<?php }else{?>
			<ul class="required">
				<li class="th"><p designElement="text" textIndex="46"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >아이디</p></li>
				<li class="td">
<?php if($TPL_VAR["member_seq"]){?>
					<?php echo $TPL_VAR["userid"]?>

<?php }else{?>
					<input type="text" name="userid" id="userid" value="" onkeypress="filterKey();" class="eng_only" onpaste="javascript:return false;" placeholder="공백 없는 영문/숫자 포함 6~20자" />
					<p id="id_info" class="guide_text"></p>
<?php }?>
				</li>
			</ul>
<?php if($TPL_VAR["member_seq"]){?>
				<ul class="required">
					<li class="th"><p designElement="text" textIndex="47"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >기존 비밀번호</p></li>
					<li class="td"><input type="password" name="old_password" value="" class="eng_only" /></li>
				</ul>
				<ul>
					<li class="th"><p designElement="text" textIndex="48"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >신규 비밀번호</p></li>
					<li class="td">
						<input type="password" name="new_password" value="" class="eng_only class_check_password_validation" />
					</li>
				</ul>
<?php }else{?>
				<ul class="required">
					<li class="th"><p designElement="text" textIndex="49"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >비밀번호</p></li>
					<li class="td">
						<input type="password" name="password" value="" class="eng_only class_check_password_validation" />
					</li>
				</ul>
				<ul class="required">
					<li class="th"><p designElement="text" textIndex="50"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >비밀번호 확인</p></li>
					<li class="td">
						<input type="password" name="re_password" value="" class="eng_only" />
					</li>
				</ul>
<?php }?>
<?php }?>
<?php if($TPL_VAR["joinform"]["nickname_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["nickname_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th "><p designElement="text" textIndex="51"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >닉네임</p></li>
				<li class="td">
					<input type="text" name="nickname" value="<?php echo $TPL_VAR["nickname"]?>" maxlength="10" />
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["bname_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["bname_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th"><p designElement="text" textIndex="52"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >업체명</p></li>
				<li class="td"><input type="text" name="bname" value="<?php echo $TPL_VAR["bname"]?>" /></li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["bceo_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["bceo_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th"><p designElement="text" textIndex="53"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >대표자명</p></li>
				<li class="td"><input type="text" name="bceo" value="<?php echo $TPL_VAR["bceo"]?>" /></li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["bno_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["bno_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th"><p designElement="text" textIndex="54"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >사업자 등록번호</p></li>
				<li class="td">
					<input type="tel" name="bno" value="<?php echo $TPL_VAR["bno"]?>" placeholder="ex) 123-12-12345" />
					<p id="bno_info" class="guide_text"></p>
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["bitem_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["bitem_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th"><p designElement="text" textIndex="55"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >업태</p></li>
				<li class="td"><input type="text" name="bitem" value="<?php echo $TPL_VAR["bitem"]?>" /></li>
			</ul>
			<ul <?php if($TPL_VAR["joinform"]["bitem_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th"><p designElement="text" textIndex="56"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >종목</p></li>
				<li class="td"><input type="text" name="bstatus" value="<?php echo $TPL_VAR["bstatus"]?>" /></li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["badress_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["badress_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th"><p designElement="text" textIndex="57"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >사업장 주소</p></li>
				<li class="td">
					<input type="hidden" name="baddress_type" value="<?php echo $TPL_VAR["baddress_type"]?>" />
					<input type="text" name="new_bzipcode" value="<?php echo $TPL_VAR["bzipcode"]?>" class="size_zip_all" readonly />
					<button type="button" class="btn_resp size_b color4" onclick="openDialogZipcode_resp('business')"><span designElement="text" textIndex="58"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >주소찾기</span></button>
					<div class="address_area">
						<input type="text" name="baddress" value="<?php echo $TPL_VAR["baddress"]?>" class="size_full <?php if($TPL_VAR["address_type"]=='street'){?>hide<?php }?>" readonly />
						<input type="text" name="baddress_street" value="<?php echo $TPL_VAR["baddress_street"]?>" class="size_full <?php if($TPL_VAR["address_type"]!='street'){?>hide<?php }?>" readonly />
					</div>
					<div class="address_area">
						<input type="text" name="baddress_detail" value="<?php echo $TPL_VAR["baddress_detail"]?>" class="size_full" />
					</div>
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["bperson_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["bperson_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th"><p designElement="text" textIndex="59"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >담당자 명</p></li>
				<li class="td"><input type="text" name="bperson" value="<?php echo $TPL_VAR["bperson"]?>" /></li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["bpart_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["bpart_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th"><p designElement="text" textIndex="60"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >담당자 부서명</p></li>
				<li class="td"><input type="text" name="bpart" value="<?php echo $TPL_VAR["bpart"]?>" /></li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["bemail_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["bemail_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th"><p designElement="text" textIndex="61"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >이메일</p></li>
				<li class="td">
					<input type="email" name="email[0]" value="<?php echo str_split_arr($TPL_VAR["email"],'@', 0)?>" class="size_mail1" /> @
					<input type="email" name="email[1]" value="<?php echo str_split_arr($TPL_VAR["email"],'@', 1)?>" class="size_mail2" />
					<select name="find_email" id="find_email">
						<option value="">직접선택</option>
<?php if($TPL_email_arr_1){foreach($TPL_VAR["email_arr"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["codecd"]?>"><?php echo $TPL_V1["codecd"]?></option>
<?php }}?>
					</select>
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["bphone_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["bphone_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th"><p designElement="text" textIndex="62"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >전화번호</p></li>
				<li class="td">
					<input type="tel" name="bphone[]" value="<?php echo str_split_arr($TPL_VAR["bphone"],'-', 0)?>" class="size_phone" /> -
					<input type="tel" name="bphone[]" value="<?php echo str_split_arr($TPL_VAR["bphone"],'-', 1)?>" class="size_phone" /> -
					<input type="tel" name="bphone[]" value="<?php echo str_split_arr($TPL_VAR["bphone"],'-', 2)?>" class="size_phone" />
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["bcellphone_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["bcellphone_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th"><p designElement="text" textIndex="63"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >휴대폰번호</p></li>
				<li class="td">
					<input type="text" name="bcellphone[]" value="<?php echo str_split_arr($TPL_VAR["bcellphone"],'-', 0)?>" class="size_phone" /> -
					<input type="text" name="bcellphone[]" value="<?php echo str_split_arr($TPL_VAR["bcellphone"],'-', 1)?>" class="size_phone" /> -
					<input type="text" name="bcellphone[]" value="<?php echo str_split_arr($TPL_VAR["bcellphone"],'-', 2)?>" class="size_phone" />
<?php if($TPL_VAR["confirmPhone"]=='Y'){?>
						<script>$("input[name='bcellphone[]']").attr("disabled",true);</script>
						<button type="button" class="btn_resp size_b color2" onclick="authphone_popup('bcellphone');">휴대폰인증</button>
<?php }?>
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["member_seq"]&&($TPL_VAR["joinform"]["bemail_use"]=='Y'||$TPL_VAR["joinform"]["bcellphone_use"]=='Y')){?>
		<ul>
			<li class="th "><p designElement="text" textIndex="64"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >마케팅 및 광고 활용 동의</p><a href="javascript:void(0)" onclick="showCenterLayer('#marketingDeatilLayer')" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ><span class="ml10 Und">보기</span></a></li>
			<li class="td">
				<div class="Pt10">
<?php if($TPL_VAR["joinform"]["bemail_use"]=='Y'){?>
					<label class="ml10"><input type="checkbox" name="mailing" value="y" class="mr5"/> <span designElement="text" textIndex="65"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >이메일 수신</span></label>
<?php }?>
<?php if($TPL_VAR["joinform"]["bcellphone_use"]=='Y'){?>
					<label class="ml10"><input type="checkbox" name="sms" value="y" class="mr5"/> <span designElement="text" textIndex="66"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >SMS 수신</span></label>
<?php }?>
				</div>
				<p class="Pt10 desc" designElement="text" textIndex="67"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" ><?php if($TPL_VAR["joinform"]["bemail_use"]=='Y'){?>이메일<?php }?> <?php if($TPL_VAR["joinform"]["bemail_use"]=='Y'&&$TPL_VAR["joinform"]["bcellphone_use"]=='Y'){?>, <?php }?> <?php if($TPL_VAR["joinform"]["bcellphone_use"]=='Y'){?>SMS<?php }?> 수신에 동의하시면 여러가지 할인해택과 각종 이벤트 정보를 받아보실 수 있습니다.</br>회원가입관련,주문배송관련 등의 정보는 수신동의와 상관없이 구매 회원에게 발송됩니다.</p>
			</li>

		</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["user_icon"]=='Y'){?>
			<ul>
				<li class="th"><p designElement="text" textIndex="68"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >아이콘</p></li>
				<li class="td">
					<ul class="member_icon_list">
<?php if($TPL_memberIcondata_1){$TPL_I1=-1;foreach($TPL_VAR["memberIcondata"] as $TPL_V1){$TPL_I1++;?>
							<li>
								<label class="lab1">
									<div class="Mb4"><input type="radio" name="user_icon" value="<?php echo ($TPL_I1+ 1)?>" <?php if($TPL_VAR["user_icon"]==($TPL_I1+ 1)){?> checked="checked" <?php }?> /></div>
									<img src="/data/icon/member/<?php echo $TPL_V1?>" class="icon_membericon" designImgSrcOri='L2RhdGEvaWNvbi9tZW1iZXIvey52YWx1ZV99' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=' designImgSrc='L2RhdGEvaWNvbi9tZW1iZXIvey52YWx1ZV99' designElement='image' />
								</label>
							</li>
<?php }}?>
<?php if($TPL_VAR["member_seq"]){?>
							<li>
								<div class="Mb4">
									<input type="radio" name="user_icon" value="99" <?php if($TPL_VAR["user_icon"]== 99&&$TPL_VAR["user_icon_file"]){?> checked="checked" <?php }?> />
									<button type="button" class="btn_resp size_b" id="membericonUpdate">직접등록</button>
								</div>
								<label>
									<img src="/data/icon/member/<?php echo $TPL_VAR["user_icon_file"]?>" id="membericon_img" <?php if(!$TPL_VAR["user_icon_file"]){?> class="hide" <?php }?> designImgSrcOri='L2RhdGEvaWNvbi9tZW1iZXIve3VzZXJfaWNvbl9maWxlfQ==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=' designImgSrc='L2RhdGEvaWNvbi9tZW1iZXIve3VzZXJfaWNvbl9maWxlfQ==' designElement='image' />
								</label>
							</li>
<?php }?>
					</ul>
				</li>
			</ul>
<?php }?>
<?php if($TPL_VAR["joinform"]["recommend_use"]=='Y'){?>
			<ul <?php if($TPL_VAR["joinform"]["recommend_required"]=='Y'){?>class="required"<?php }?>>
				<li class="th"><p>추천인ID</p></li>
				<li class="td">
					<input type="text" name="recommend" id="brecommend" value="<?php echo $TPL_VAR["recommend"]?>" style="width:160px;" />
					<button type="button" class="btn_resp size_b" onclick="chkRecommend('b');">확인</button>
					<p id="brecommend_return_txt" class="guide_text"></p>
					<ul class="list_01 v3 desc pd_1">
					<!--
<?php if($TPL_VAR["emoneyapp"]["emoneyJoin"]> 0){?>
						<li>신규회원 -  마일리지 <span class="pointcolor"><?php echo number_format($TPL_VAR["emoneyapp"]["emoneyJoin"])?></span>원 지급</li>
<?php }?>
					-->
<?php if($TPL_VAR["emoneyapp"]["emoneyJoiner"]> 0){?>
						<li><p designElement="text" textIndex="69"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >추천인ID 입력시 - 마일리지 <span class="pointcolor"><?php echo number_format($TPL_VAR["emoneyapp"]["emoneyJoiner"])?></span>원 추가지급</p></li>
<?php }?>
<?php if($TPL_VAR["emoneyapp"]["emoneyRecommend"]> 0){?>
						<li><p designElement="text" textIndex="70"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL21lbWJlci9yZWdpc3Rlcl9mb3JtLmh0bWw=" >추천받은 회원 - 마일리지 <span class="pointcolor2"><?php echo $TPL_VAR["emoneyapp"]["emoneyRecommend"]?></span>원 지급</p></li>
<?php }?>
					</ul>
				</li>
			</ul>
<?php }?>

<?php if($TPL_VAR["form_sub"]){?>
<?php if($TPL_form_sub_1){foreach($TPL_VAR["form_sub"] as $TPL_V1){?>
<?php if($TPL_V1["used"]=='Y'&&$TPL_V1["join_type"]=='order'){?>
<?php if($TPL_V1["required"]=='Y'){?>
						<ul class="form_sub required">
							<li class="th"><p><input type="hidden" name="required[]" value="<?php echo $TPL_V1["joinform_seq"]?>"><input type="hidden" name="required_title[]" value="<?php echo $TPL_V1["label_title"]?>"><?php echo $TPL_V1["label_title"]?></p></li>
<?php }else{?>
						<ul class="form_sub">
							<li class="th"><p><?php echo $TPL_V1["label_title"]?></p></li>
<?php }?>
							<li class="td custom_form designed_radio_checkbox join_form">
								<?php echo $TPL_V1["label_view"]?>

<?php if($TPL_V1["label_desc"]){?><p class="desc pd_2"><?php echo $TPL_V1["label_desc"]?></p><?php }?>
							</li>
						</ul>
<?php }?>
<?php }}?>
<?php }?>
	</div>
<?php }?>

</div>

<script type="text/javascript">
	$(function(){
		$(".selectLabelSet").each(function(){
			var selectLabelSetObj = $(this);
			$("select.selectLabelDepth1",selectLabelSetObj).bind('change',function(){
				var childs = $("option:selected",this).attr('childs').split(';');
				var joinform_seq = $(this).attr('joinform_seq');
				var select2 = $("input.hiddenLabelDepth[type='hidden'][joinform_seq='"+joinform_seq+"']").val();
				if(childs[0]){
					$(".selectsubDepth",selectLabelSetObj).show();
					$("select.selectLabelDepth2[joinform_seq='"+joinform_seq+"']").empty();
					for(var i=0; i< childs.length ; i++){
						$("select.selectLabelDepth2[joinform_seq='"+joinform_seq+"']")
						.append("<option value='"+childs[i]+"'>"+childs[i]+"</option>");
					}
				}else{
					$(".selectsubDepth",selectLabelSetObj).hide();
				}
				$("select.selectLabelDepth2 option[value='"+select2+"']").attr('selected',true);
			}).trigger('change');
		});


		/* ========== 반응형 프론트엔드 추가 ========= */
		// designed radio UI
		$('.designed_radio_checkbox input[type=radio]').closest('.designed_radio_checkbox').addClass('type_radio');
		$('.designed_radio_checkbox input[checked]').parent('label').addClass('on');

		$('.designed_radio_checkbox input[type=radio]').on('change', function() {
			$(this).parent().parent().find('label').removeClass('on');
			$(this).parent('label').addClass('on');
		});
		// designed checkbox UI
		$('.designed_radio_checkbox input[type=checkbox]').on('change', function() {
			if ( $(this).prop('checked') ) {
				$(this).parent('label').addClass('on');
			} else {
				$(this).parent('label').removeClass('on');
			}
		});
		/* ========== //반응형 프론트엔드 추가 ========= */
	});

	// 추천인 확인
	function chkRecommend(type){
		var recommend	= $("#recommend").val();
		if(type=="b")	recommend = $("#brecommend").val();
		if	(!recommend){
			//추천인명을 입력하세요
			openDialogAlert(getAlert('mb009'), 400, 150);
			return;
		}
		actionFrame.location.href	= '/member/recommend_confirm?recomid='+recommend+'&type='+type;
	}

	/* 2022.03.14 이메일 자동 입력 폼 아래 오도록 수정  */
	function cngadd(address) {
		var inputText = document.getElementById("addInput");

		inputText.value = address;
	}
</script>