<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/goods/popup_string_price.html 000013943 */ ?>
<style>
table#tb_string_price th { height:40px; }
table#tb_string_price td { height:50px; }
#setting_guide_msg {height:34px;}
</style>
<table class="info-table-style" id="tb_string_price" style="width:100%">
	<colgroup>
		<col width="10%" />
		<col width="45%" />
		<col width="45%" />
	</colgroup>

	<thead>
		<tr>
			<th class="its-th-align center bold">구매 대상자</th>
			<th class="its-th-align center bold">가격노출 제어</th>
			<th class="its-th-align center bold">버튼노출 제어</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="its-td-align center pdl5">비회원<br/>(로그아웃)</td>
			<td class="its-td-align left pdl5" nowrap="nowrap">
				<div class="pdl5"><label style="display:inline-block;"><input type="radio" class="string_use_radio" name="string_price_use" value="0" <?php if(!$TPL_VAR["string_price_use"]){?>checked<?php }?> /> 판매가격</label></div>
				<div class="pd5">
					<label style="display:inline-block;width:95px;"><input type="radio" class="string_use_radio" name="string_price_use" value="1" <?php if($TPL_VAR["string_price_use"]=='1'){?>checked<?php }?> /> 가격대체문구</label>
					<input type="text" name="string_price" size="25" value="<?php echo $TPL_VAR["string_price"]?>" />
					<input type="text" name="string_price_color" value="<?php if($TPL_VAR["string_price_color"]){?><?php echo $TPL_VAR["string_price_color"]?><?php }else{?>#FF0000<?php }?>" class="colorpicker display-form"/>
				</div>
				<div style="padding-left:104px">
					<input type="text" name="string_price_link_url" size="25" value="<?php echo $TPL_VAR["string_price_link_url"]?>" /></label>
					<select name="string_price_link" class="string_link_select">
						<option value='direct' <?php if($TPL_VAR["string_price_link"]=='direct'||!$TPL_VAR["string_price_link"]){?>selected<?php }?>>직접입력</option>
						<option value='login' <?php if($TPL_VAR["string_price_link"]=='login'){?>selected<?php }?>>로그인</option>
						<option value='1:1' <?php if($TPL_VAR["string_price_link"]=='1:1'){?>selected<?php }?>>1:1문의</option>
						<option value='none' <?php if($TPL_VAR["string_price_link"]=='none'){?>selected<?php }?>>링크없음</option>
					</select>
					<select name="string_price_link_target">
						<option value='NEW' <?php if($TPL_VAR["string_price_link_target"]!='NOW'){?>selected<?php }?>>새창</option>
						<option value='NOW' <?php if($TPL_VAR["string_price_link_target"]=='NOW'){?>selected<?php }?>>현재창</option>
					</select>
				</div>
			</td>
			<td class="its-td-align left pdl5" nowrap="nowrap">
				<div class="pdl5"><label style="display:inline-block;"><input type="radio" class="string_use_radio" name="string_button_use" value="0" <?php if(!$TPL_VAR["string_button_use"]){?>checked<?php }?> /> [정상/품절/재고확보중/판매중지] 상태별 버튼 <span id="string_price_use_guide">노출</span></label></div>
				<div class="pd5">
					<label style="display:inline-block;width:95px;"><input type="radio" class="string_use_radio" name="string_button_use" value="1" <?php if($TPL_VAR["string_button_use"]=='1'){?>checked<?php }?> /> 버튼대체문구</label>
					<input type="text" name="string_button" size="25" value="<?php echo $TPL_VAR["string_button"]?>" />
					<input type="text" name="string_button_color" value="<?php if($TPL_VAR["string_button_color"]){?><?php echo $TPL_VAR["string_button_color"]?><?php }else{?>#FF0000<?php }?>" class="colorpicker display-form"/>
				</div>
				<div style="padding-left:104px">
					<input type="text" name="string_button_link_url" size="25" value="<?php echo $TPL_VAR["string_button_link_url"]?>" /></label>
					<select name="string_button_link" class="string_link_select">
						<option value='direct' <?php if($TPL_VAR["string_button_link"]=='direct'||!$TPL_VAR["string_price_link"]){?>selected<?php }?>>직접입력</option>
						<option value='login' <?php if($TPL_VAR["string_button_link"]=='login'){?>selected<?php }?>>로그인</option>
						<option value='1:1' <?php if($TPL_VAR["string_button_link"]=='1:1'){?>selected<?php }?>>1:1문의</option>
						<option value='none' <?php if($TPL_VAR["string_button_link"]=='none'){?>selected<?php }?>>링크없음</option>
					</select>
					<select name="string_button_link_target">
						<option value='NEW' <?php if($TPL_VAR["string_button_link_target"]!='NOW'){?>selected<?php }?>>새창</option>
						<option value='NOW' <?php if($TPL_VAR["string_button_link_target"]=='NOW'){?>selected<?php }?>>현재창</option>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<td class="its-td-align center pdl5">일반등급</td>
			<td class="its-td-align left pdl5" nowrap="nowrap">
				<div class="pdl5"><label style="display:inline-block;"><input type="radio" class="string_use_radio" name="member_string_price_use" value="0" <?php if(!$TPL_VAR["member_string_price_use"]){?>checked<?php }?> /> 판매가격</label></div>
				<div class="pd5">
					<label style="display:inline-block;width:95px;"><input type="radio" class="string_use_radio" name="member_string_price_use" value="1" <?php if($TPL_VAR["member_string_price_use"]=='1'){?>checked<?php }?> /> 가격대체문구</label>
					<input type="text" name="member_string_price" size="25" value="<?php echo $TPL_VAR["member_string_price"]?>" />
					<input type="text" name="member_string_price_color" value="<?php if($TPL_VAR["member_string_price_color"]){?><?php echo $TPL_VAR["member_string_price_color"]?><?php }else{?>#FF0000<?php }?>" class="colorpicker display-form"/>
				</div>
				<div style="padding-left:104px">
					<input type="text" name="member_string_price_link_url" size="25" value="<?php echo $TPL_VAR["member_string_price_link_url"]?>" /></label>
					<select name="member_string_price_link" class="string_link_select">
						<option value='direct' <?php if($TPL_VAR["member_string_price_link"]=='direct'||!$TPL_VAR["string_price_link"]){?>selected<?php }?>>직접입력</option>
						<option value='login' <?php if($TPL_VAR["member_string_price_link"]=='login'){?>selected<?php }?>>로그인</option>
						<option value='1:1' <?php if($TPL_VAR["member_string_price_link"]=='1:1'){?>selected<?php }?>>1:1문의</option>
						<option value='none' <?php if($TPL_VAR["member_string_price_link"]=='none'){?>selected<?php }?>>링크없음</option>
					</select>
					<select name="member_string_price_link_target">
						<option value='NEW' <?php if($TPL_VAR["member_string_price_link_target"]!='NOW'){?>selected<?php }?>>새창</option>
						<option value='NOW' <?php if($TPL_VAR["member_string_price_link_target"]=='NOW'){?>selected<?php }?>>현재창</option>
					</select>
				</div>
			</td>
			<td class="its-td-align left pdl5" nowrap="nowrap">
				<div class="pdl5"><label style="display:inline-block;"><input type="radio" class="string_use_radio" name="member_string_button_use" value="0" <?php if(!$TPL_VAR["member_string_button_use"]){?>checked<?php }?> /> [정상/품절/재고확보중/판매중지] 상태별 버튼 <span id="member_string_price_use_guide">노출</span></label></div>
				<div class="pd5">
					<label style="display:inline-block;width:95px;"><input type="radio" class="string_use_radio" name="member_string_button_use" value="1" <?php if($TPL_VAR["member_string_button_use"]=='1'){?>checked<?php }?> /> 버튼대체문구</label>
					<input type="text" name="member_string_button" size="25" value="<?php echo $TPL_VAR["member_string_button"]?>" />
					<input type="text" name="member_string_button_color" value="<?php if($TPL_VAR["member_string_button_color"]){?><?php echo $TPL_VAR["member_string_button_color"]?><?php }else{?>#FF0000<?php }?>" class="colorpicker display-form"/>
				</div>
				<div style="padding-left:104px">
					<input type="text" name="member_string_button_link_url" size="25" value="<?php echo $TPL_VAR["member_string_button_link_url"]?>" /></label>
					<select name="member_string_button_link" class="string_link_select">
						<option value='direct' <?php if($TPL_VAR["member_string_button_link"]=='direct'||!$TPL_VAR["string_price_link"]){?>selected<?php }?>>직접입력</option>
						<option value='login' <?php if($TPL_VAR["member_string_button_link"]=='login'){?>selected<?php }?>>로그인</option>
						<option value='1:1' <?php if($TPL_VAR["member_string_button_link"]=='1:1'){?>selected<?php }?>>1:1문의</option>
						<option value='none' <?php if($TPL_VAR["member_string_button_link"]=='none'){?>selected<?php }?>>링크없음</option>
					</select>
					<select name="member_string_button_link_target">
						<option value='NEW' <?php if($TPL_VAR["member_string_button_link_target"]!='NOW'){?>selected<?php }?>>새창</option>
						<option value='NOW' <?php if($TPL_VAR["member_string_button_link_target"]=='NOW'){?>selected<?php }?>>현재창</option>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<td class="its-td-align center pdl5">상위등급</td>
			<td class="its-td-align left pdl5" nowrap="nowrap">
				<div class="pdl5"><label style="display:inline-block;"><input type="radio" class="string_use_radio" name="allmember_string_price_use" value="0" <?php if(!$TPL_VAR["allmember_string_price_use"]){?>checked<?php }?> /> 판매가격</label></div>
				<div class="pd5">
					<label style="display:inline-block;width:95px;"><input type="radio" class="string_use_radio" name="allmember_string_price_use" value="1" <?php if($TPL_VAR["allmember_string_price_use"]=='1'){?>checked<?php }?> /> 가격대체문구</label>
					<input type="text" name="allmember_string_price" size="25" value="<?php echo $TPL_VAR["allmember_string_price"]?>" />
					<input type="text" name="allmember_string_price_color" value="<?php if($TPL_VAR["allmember_string_price_color"]){?><?php echo $TPL_VAR["allmember_string_price_color"]?><?php }else{?>#FF0000<?php }?>" class="colorpicker display-form"/>
				</div>
				<div style="padding-left:104px">
					<input type="text" name="allmember_string_price_link_url" size="25" value="<?php echo $TPL_VAR["allmember_string_price_link_url"]?>" /></label>
					<select name="allmember_string_price_link" class="string_link_select">
						<option value='direct' <?php if($TPL_VAR["allmember_string_price_link"]=='direct'||!$TPL_VAR["string_price_link"]){?>selected<?php }?>>직접입력</option>
						<option value='login' <?php if($TPL_VAR["allmember_string_price_link"]=='login'){?>selected<?php }?>>로그인</option>
						<option value='1:1' <?php if($TPL_VAR["allmember_string_price_link"]=='1:1'){?>selected<?php }?>>1:1문의</option>
						<option value='none' <?php if($TPL_VAR["allmember_string_price_link"]=='none'){?>selected<?php }?>>링크없음</option>
					</select>
					<select name="allmember_string_price_link_target">
						<option value='NEW' <?php if($TPL_VAR["allmember_string_price_link_target"]!='NOW'){?>selected<?php }?>>새창</option>
						<option value='NOW' <?php if($TPL_VAR["allmember_string_price_link_target"]=='NOW'){?>selected<?php }?>>현재창</option>
					</select>
				</div>
			</td>
			<td class="its-td-align left pdl5" nowrap="nowrap">
				<div class="pdl5"><label style="display:inline-block;"><input type="radio" class="string_use_radio" name="allmember_string_button_use" value="0" <?php if(!$TPL_VAR["allmember_string_button_use"]){?>checked<?php }?> /> [정상/품절/재고확보중/판매중지] 상태별 버튼 <span id="allmember_string_price_use_guide">노출</span></label></div>
				<div class="pd5">
					<label style="display:inline-block;width:95px;"><input type="radio" class="string_use_radio" name="allmember_string_button_use" value="1" <?php if($TPL_VAR["allmember_string_button_use"]=='1'){?>checked<?php }?> /> 버튼대체문구</label>
					<input type="text" name="allmember_string_button" size="25" value="<?php echo $TPL_VAR["allmember_string_button"]?>" />
					<input type="text" name="allmember_string_button_color" value="<?php if($TPL_VAR["allmember_string_button_color"]){?><?php echo $TPL_VAR["allmember_string_button_color"]?><?php }else{?>#FF0000<?php }?>" class="colorpicker display-form"/>
				</div>
				<div style="padding-left:104px">
					<input type="text" name="allmember_string_button_link_url" size="25" value="<?php echo $TPL_VAR["allmember_string_button_link_url"]?>" /></label>
					<select name="allmember_string_button_link" class="string_link_select">
						<option value='direct' <?php if($TPL_VAR["allmember_string_button_link"]=='direct'||!$TPL_VAR["string_price_link"]){?>selected<?php }?>>직접입력</option>
						<option value='login' <?php if($TPL_VAR["allmember_string_button_link"]=='login'){?>selected<?php }?>>로그인</option>
						<option value='1:1' <?php if($TPL_VAR["allmember_string_button_link"]=='1:1'){?>selected<?php }?>>1:1문의</option>
						<option value='none' <?php if($TPL_VAR["allmember_string_button_link"]=='none'){?>selected<?php }?>>링크없음</option>
					</select>
					<select name="allmember_string_button_link_target">
						<option value='NEW' <?php if($TPL_VAR["allmember_string_button_link_target"]!='NOW'){?>selected<?php }?>>새창</option>
						<option value='NOW' <?php if($TPL_VAR["allmember_string_button_link_target"]=='NOW'){?>selected<?php }?>>현재창</option>
					</select>
				</div>
			</td>
		</tr>
	</tbody>
</table>
<div id="setting_guide_msg" class="hide bold mt15 fx14 center"></div>
<div class="center pdt10"><span class="btn large cyanblue"><button type="button" id="btn_apply_string" onclick='apply_string_price();'>적용하기</button></span></div>
<script>
$(".colorpicker").customColorPicker();
check_string_price();
//check_tb_string_price_select();
</script>