<?php /* Template_ 2.2.6 2022/05/17 12:05:24 /www/music_brother_firstmall_kr/admincrm/skin/default/member/detail.html 000049588 */ 
$TPL_grade_list_1=empty($TPL_VAR["grade_list"])||!is_array($TPL_VAR["grade_list"])?0:count($TPL_VAR["grade_list"]);
$TPL_memberIcondata_1=empty($TPL_VAR["memberIcondata"])||!is_array($TPL_VAR["memberIcondata"])?0:count($TPL_VAR["memberIcondata"]);
$TPL_snslist_1=empty($TPL_VAR["snslist"])||!is_array($TPL_VAR["snslist"])?0:count($TPL_VAR["snslist"]);
$TPL_m_arr_1=empty($TPL_VAR["m_arr"])||!is_array($TPL_VAR["m_arr"])?0:count($TPL_VAR["m_arr"]);
$TPL_d_arr_1=empty($TPL_VAR["d_arr"])||!is_array($TPL_VAR["d_arr"])?0:count($TPL_VAR["d_arr"]);
$TPL_form_sub_1=empty($TPL_VAR["form_sub"])||!is_array($TPL_VAR["form_sub"])?0:count($TPL_VAR["form_sub"]);
$TPL_withdrawal_arr_1=empty($TPL_VAR["withdrawal_arr"])||!is_array($TPL_VAR["withdrawal_arr"])?0:count($TPL_VAR["withdrawal_arr"]);
$TPL_minisohp_1=empty($TPL_VAR["minisohp"])||!is_array($TPL_VAR["minisohp"])?0:count($TPL_VAR["minisohp"]);?>
<!-- 2022.01.05 12월 1차 패치 by 김혜진 -->

<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript">
	$(function(){

		$(".class_check_password_validation").each(function(){
			init_check_password_validation($(this));
		});


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
<?php if($TPL_VAR["rute"]!='none'&&$TPL_VAR["sns_change"]!=='1'){?>
		$("input[name='passwd_chg']").attr('disabled',true);
<?php }?>
	});
</script>
<style type="text/css">
	.pop_area { width:97px;height:33px; padding-top:5px; background-color:#fff; border:1px #636364 solid; }
	.pop_link { line-height:15px; padding-left:3px; font-size:11px; }
	.pop_link span { color:#6E6E6E; }
	.pop_link span:hover { color:#000; }
	td.member-order-work {border-left:1px solid #dadada; border-bottom:1px solid #dadada; padding:5px 10px 5px 15px; line-height:180%; letter-spacing:0px; text-align:right }
	input.size_phone { width:40px; }
	#layout-body {background: #f1f1f1;}

	/************* tooltip **********************************************/
	.tip_wrap h1 {font-size:12px; color:#000; margin-bottom:5px;}
	.tip_wrap h2 {font-weight:400; font-size:12px; color:#000; margin-bottom:5px;}
	.tip_wrap .con_wrap{overflow:auto; margin:0 5px;}
	.tip_wrap .section{margin:10px 0;}

	.tooltip_btn {display:inline-block; width: 14px; height: 14px; cursor: pointer; background: url('/admin/skin/default/images/common/bg_icon.png'); vertical-align: middle; margin-bottom: 2px; margin-left: 2px;}
	.tooltip_close {background:url('/admin/skin/default/images/common/tooltip_close.png'); background-size:10px 11px; vertical-align: middle; position:absolute; right:10px; display:inline-block; width:10px; height:11px; }
	.tooltip_area {display:none; position:absolute; z-index:20001; box-sizing:border-box; border:1px #313131 solid; background:#fff;}
	.tooltip_content {padding:10px; position:relative; left:0; top:0; font-weight:400; font-size: 12px; box-sizing: border-box;}
	.bullet_hyphen li {
		background: url(/admin/skin/default/images/common/hyphen_bullet.png) 1px 10px no-repeat;
		padding-left: 15px;
		line-height: 180%;
		color: #999;
	}
</style>

<form name="memberForm" id="memberForm" method="post" target="actionFrame" action="/admin/member_process/member_modify">
	<input type="hidden" name="member_seq" value="<?php echo $TPL_VAR["member_seq"]?>"/>
	<input type="hidden" name="business_seq" value="<?php echo $TPL_VAR["business_seq"]?>"/>
	<input type="hidden" name="query_string" value="<?php echo $TPL_VAR["query_string"]?>"/>
	<input type="hidden" name="user_name_old" value="<?php echo $TPL_VAR["user_name"]?>"/>
	<input type="hidden" name="email_old" value="<?php echo $TPL_VAR["email"]?>"/>
	<input type="hidden" name="phone_old" value="<?php echo $TPL_VAR["phone"]?>"/>
	<input type="hidden" name="cellphone_old" value="<?php echo $TPL_VAR["cellphone"]?>"/>
	<input type="hidden" name="address_street_old" value="<?php echo $TPL_VAR["address_street"]?>"/>
	<input type="hidden" name="address_detail_old" value="<?php echo $TPL_VAR["address_detail"]?>"/>

	<!-- 서브메뉴 바디 : 시작-->
	<div>
		<table style="width:100%">
			<tr>
				<td width="100%" valign="top" style="vertical-align:top;">
					<!-- <div class="item-title">기본정보 </div> -->
					<table class="info-table-style" style="width:100%">
						<colgroup>
							<col width="20%" />
							<col />
						</colgroup>
						<thead>
						<tr>
							<th colspan="2">기본정보</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<th class="its-th-align center">가입일</th>
							<td class="its-td"><?php echo $TPL_VAR["regist_date"]?></td>
						</tr>
						<tr>
							<th class="its-th-align center">상태</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
<?php if($TPL_VAR["status_nm"]!='휴면'){?>
								<select name="status">
									<option value="done">승인</option>
									<option value="hold">미승인</option>
								</select>
<?php if($TPL_VAR["kid_auth"]=='N'){?><span class="red m15">(만 14세 미만 회원가입 고객, 법정 대리인 동의 필요)</span><?php }?>
<?php }else{?>
								휴면
<?php }?>
<?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">등급</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<span id="group_icon"><?php if($TPL_VAR["icon"]){?><img src="../../data/icon/common/<?php echo $TPL_VAR["icon"]?>" align="absmiddle"><?php }?></span>
								<select name="group_seq">
<?php if($TPL_grade_list_1){foreach($TPL_VAR["grade_list"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1["group_seq"]?>" gicon="<?php echo $TPL_V1["icon"]?>" use_type="<?php echo $TPL_V1["use_type"]?>" <?php if($TPL_VAR["group_seq"]==$TPL_V1["group_seq"]){?>selected<?php }?>><?php echo $TPL_V1["group_name"]?></option>
<?php }}?>
								</select>
								<input type="hidden" name="group_name" value="<?php echo $TPL_VAR["group_name"]?>"/>
<?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">유형</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<select name="user_type" id="user_type" onchange="userSelect();">
									<option value="default">개인</option>
									<option value="business">기업</option>
								</select>
<?php }?>
							</td>
						</tr>
<?php if($TPL_VAR["joinform"]["user_icon"]=='Y'){?>
						<tr>
							<th class="its-th-align center">아이콘</th>
							<td class="its-td">
								<ul style=" ">
<?php if($TPL_memberIcondata_1){$TPL_I1=-1;foreach($TPL_VAR["memberIcondata"] as $TPL_V1){$TPL_I1++;?>
									<li style="float:left; padding:5px 0 5px 20px;width:40px;" >
										<label>
											<div style="margin-top:5px;" ><input type="radio" name="user_icon" value="<?php echo ($TPL_I1+ 1)?>" <?php if($TPL_VAR["user_icon"]==($TPL_I1+ 1)){?> checked="checked" <?php }?> /></div>
											<img src="/data/icon/member/<?php echo $TPL_V1?>" class="icon_membericon" align="absmiddle" style="vertical-align:middle;" />
										</label>
									</li>
<?php }}?>
									<li style="float:left; padding:5px 0 5px 10px;width:80px;">
										<label>
											<input type="radio" name="user_icon" value="99" <?php if($TPL_VAR["user_icon"]== 99&&$TPL_VAR["user_icon_file"]){?> checked="checked" <?php }?> style="margin-left:17px;" /><br/>
											<img src="/data/icon/member/<?php echo $TPL_VAR["user_icon_file"]?>" id="membericon_img" align="absmiddle" style="margin-left:15px;vertical-align:middle;" <?php if(!$TPL_VAR["user_icon_file"]){?> class="hide" <?php }?> />
										</label>
										<div  style="margin-top:5px;" ><span class="btn small cyanblue valign-middle"><button type="button" class="black btn" id="membericonUpdate">직접등록</button></span></label></div>
									</li>
								</ul>
							</td>
						</tr>
<?php }?>
						<tr>
							<th class="its-th-align center">테스트용</th>
							<td class="its-td"><?php if(!$TPL_VAR["withdrawal_seq"]){?><label><input type="checkbox" name="mall_t_check" value="Y" <?php if($TPL_VAR["mall_t_check"]=='Y'){?> checked="checked" <?php }?>> EYE-DESIGN에서 로그인 후의 화면을 디자인할 때 사용하는 회원 계정</label><?php }?></td>
						</tr>
						</tbody>

					</table>
					<br style="line-height:20px;" />

<?php if($TPL_VAR["status_nm"]!='휴면'){?>
					<table class="info-table-style user_tab" style="width:100%">
						<colgroup>
							<col width="20%" />
							<col />
						</colgroup>
						<thead>
						<tr>
							<th colspan="2">개인정보 &nbsp;<span class="btn small"><button type="button" class="delivery_address hand" >자주 쓰는 배송지</button></span></th>
						</tr>
						</thead>
						<tbody>
<?php if($TPL_VAR["snslist"]){?>
						<tr>
							<th class="its-th-align center" >사용중인 SNS</th>
							<td class="its-td">
<?php if($TPL_snslist_1){foreach($TPL_VAR["snslist"] as $TPL_V1){?>
								<img src="/admincrm/skin/default/images/sns/sns_<?php echo substr($TPL_V1["rute"], 0, 1)?>0.gif" align="absmiddle" class="btnsnsdetail hand" snscd="<?php echo $TPL_V1["rute"]?>" title="<?php echo $TPL_V1["rute_nm"]?> 정보확인">
								<div id="snsdetailPopup_<?php echo $TPL_V1["rute"]?>" class="snsdetailPopup absolute hide"></div>
<?php if($TPL_V1["rute"]&&$TPL_V1["rute"]=='naver'){?>
								<?php echo $TPL_VAR["conv_sns_n"]?>

<?php }?>
<?php }}?>
							</td>
						</tr>
<?php }?>
						<tr>
							<th class="its-th-align center">아이디 / 이름</th>
							<td class="its-td">
<?php if($TPL_VAR["userid"]==$TPL_VAR["sns_n"]){?><?php echo $TPL_VAR["conv_sns_n"]?><?php }else{?><?php echo $TPL_VAR["userid"]?><?php }?> <?php if(!$TPL_VAR["withdrawal_seq"]){?>/ <input type="text" name="user_name" value="<?php echo $TPL_VAR["user_name"]?>" size="12"/><?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">닉네임</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<input type="text" name="nickname" value="<?php echo $TPL_VAR["nickname"]?>" maxlength="10" />
<?php }else{?>
								<?php echo $TPL_VAR["nickname"]?>

<?php }?>
							</td>
						</tr>
						<!-- ### PASSWD -->
<?php if($TPL_VAR["rute"]=='none'||$TPL_VAR["sns_change"]==='1'){?>
						<tr>
							<th class="its-th-align center">
								비밀번호 변경
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/manager', '#tip6', 'sizeM')"></span>
								<input type="checkbox" name="passwd_chg">
<?php }?>
							</th>
							<td class="its-td"><span id="passwd"></span></td>
						</tr>
<?php if(!$TPL_VAR["business_seq"]){?>
						<tr id="manager_passwd_confirm" class="hide">
							<th class="its-th-align center"><span class="red bold">*</span> 관리자 비밀번호 확인</th>
							<td class="its-td">
								<input type="password" name="manager_password" value="" />
								<span class="helpicon" title="보안을 위하여 '<?php echo $TPL_VAR["managerInfo"]["mname"]?>(<?php echo $TPL_VAR["managerInfo"]["manager_id"]?>)'의 패스워드를 입력해주세요"></span>
							</td>
						</tr>
<?php }?>
<?php }?>
						<tr>
							<th class="its-th-align center">이메일</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<div class="pdt5">
									<input type="text" name="email" value="<?php echo $TPL_VAR["email"]?>" class="uphonemail"/>
									<span class="btn small gray"><input type="button" id="email_pop" value="이메일 보내기" /></span>
								</div>
								<div class="pdt5">
									광고성 정보 수신동의 안내 확인 발송 예정일: <?php echo $TPL_VAR["marketing_agree_send_date"]?>

									<span><input type="button" class="marketing_agree_log" value="발송내역" /></span>
								</div>
<?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">핸드폰</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<div class="pdt5">
									<input type="tel" name="cellphone[]" value="<?php echo str_split_arr($TPL_VAR["cellphone"],'-', 0)?>" class="size_phone" maxlength="4" /> -
									<input type="tel" name="cellphone[]" value="<?php echo str_split_arr($TPL_VAR["cellphone"],'-', 1)?>" class="size_phone" maxlength="4" /> -
									<input type="tel" name="cellphone[]" value="<?php echo str_split_arr($TPL_VAR["cellphone"],'-', 2)?>" class="size_phone" maxlength="4" /> /
									<span class="btn small gray"><input type="button" id="sms_pop" value="SMS 보내기" /></span>
								</div>
								<div class="pdt5">
									광고성 정보 수신동의 안내 확인 발송 예정일: <?php echo $TPL_VAR["marketing_agree_send_date"]?>

									<span><input type="button" class="marketing_agree_log" value="발송내역" /></span>
								</div>
<?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">마케팅 및 광고 활용 동의</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<label for="user_tab_mailing" >
									<input type="checkbox" id="user_tab_mailing" name="mailing" value="y" <?php if($TPL_VAR["mailing"]=='y'){?> checked="checked" <?php }?> class="mr5"> 이메일 수신(<?php if($TPL_VAR["mailing"]=='y'){?>동의 <?php echo $TPL_VAR["update_date"]?><?php }else{?>거부 <?php echo $TPL_VAR["update_date"]?> <?php }?>)
								</label>
								<label for="user_tab_sms">
									<input type="checkbox" id="user_tab_sms" name="sms" value="y" <?php if($TPL_VAR["sms"]=='y'){?> checked="checked" <?php }?> class="mr5">SMS 수신(<?php if($TPL_VAR["sms"]=='y'){?>동의 <?php echo $TPL_VAR["update_date"]?><?php }else{?>거부 <?php echo $TPL_VAR["update_date"]?><?php }?>)
								</label>
<?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">전화번호</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<input type="tel" name="phone[]" value="<?php echo str_split_arr($TPL_VAR["phone"],'-', 0)?>" class="size_phone" maxlength="4" /> -
								<input type="tel" name="phone[]" value="<?php echo str_split_arr($TPL_VAR["phone"],'-', 1)?>" class="size_phone" maxlength="4" /> -
								<input type="tel" name="phone[]" value="<?php echo str_split_arr($TPL_VAR["phone"],'-', 2)?>" class="size_phone" maxlength="4" />
<?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">주소</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<input type="hidden" name="Address_type" value="<?php echo $TPL_VAR["address_type"]?>"/>
								<div class="pdt3">
									<input type="text" name="Zipcode[]" value="<?php echo $TPL_VAR["zipcode"]?>" size="7" readonly/>
									<span class="btn small"><input type="button" id="zipcodeButton" value="우편번호" /></span>
								</div>
								<div class="pdt5">
									<span class="address_title" style="font-weight:<?php if($TPL_VAR["address_type"]!="street"){?>bold<?php }else{?>nomal<?php }?>">(지번)</span>
									<input type="text" name="Address" value="<?php echo $TPL_VAR["address"]?>" size="40"/>
								</div>
								<div class="pdt5">
									<span class="address_title" style="font-weight:<?php if($TPL_VAR["address_type"]=="street"){?>bold<?php }else{?>nomal<?php }?>">(도로명)</span>
									<input type="text" name="Address_street" value="<?php echo $TPL_VAR["address_street"]?>" size="40"/>
								</div>
								<div class="pdt5">
									<span class="address_title">(공통상세)</span>
									<input type="text" name="address_detail" value="<?php echo $TPL_VAR["address_detail"]?>" size="40"/>
								</div>
<?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">실명확인</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<?php echo $TPL_VAR["auth_type"]?>

<?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">추천인</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<input type="text" name="recommend" id="recommend" value="<?php echo $TPL_VAR["recommend"]?>" class="uphonemail"/>
								<span class="btn small gray"><input type="button" onclick="chkRecommend('u');" value="찾기" /></span>
								<span id="recommend_return_txt" class="small" style="padding-top:5px;color:#d13b00;"></span>
<?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">생일</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<input type="text" name="birthday" class="datepicker line" value="<?php echo $TPL_VAR["birthday"]?>" readonly />
<?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">기념일</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<select name="anniversary[]">
									<option value=""></option>
<?php if($TPL_m_arr_1){foreach($TPL_VAR["m_arr"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1?>" <?php if(substr($TPL_VAR["anniversary"], 0, 2)==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
								</select>월
								<select name="anniversary[]">
									<option value=""></option>
<?php if($TPL_d_arr_1){foreach($TPL_VAR["d_arr"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1?>" <?php if(substr($TPL_VAR["anniversary"], 3, 2)==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
								</select>일
<?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">성별</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<select name="sex">
									<option value="none">없음</option>
									<option value="male">남</option>
									<option value="female">여</option>
								</select>
<?php }?>
							</td>
						</tr>
						</tbody>
<?php if($TPL_VAR["form_sub"]){?>
<?php if($TPL_form_sub_1){foreach($TPL_VAR["form_sub"] as $TPL_V1){?>
<?php if($TPL_V1["used"]=='Y'&&$TPL_V1["join_type"]=='user'){?>
						<tr>
							<th class="its-th-align center"><?php echo $TPL_V1["label_title"]?></th>
							<td class="its-td"><?php echo $TPL_V1["label_view"]?></td>
						</tr>
<?php }?>
<?php }}?>
<?php }?>
					</table>
<?php }else{?>
					<table class="info-table-style user_tab" style="width:100%">
						<colgroup>
							<col width="20%" />
							<col />
						</colgroup>
						<thead>
						<tr>
							<th colspan="2">개인정보</th>
						</tr>
						</thead>
						<tbody>
<?php if($TPL_VAR["snslist"]){?>
						<tr>
							<th class="its-th-align center" >사용중인 SNS</th>
							<td class="its-td"></td>
						</tr>
<?php }?>
						<tr>
							<th class="its-th-align center">아이디 / 이름</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">닉네임</th>
							<td class="its-td"></td>
						</tr>
						<!-- ### PASSWD -->
<?php if($TPL_VAR["rute"]=='none'||$TPL_VAR["sns_change"]==='1'){?>
						<tr>
							<th class="its-th-align center">
								비밀번호 변경
								<span class="tooltip_btn" onclick="showTooltip(this, '/admin/tooltip/manager', '#tip6', 'sizeM')"></span>
								<input type="checkbox" name="passwd_chg">
							</th>
							<td class="its-td"></td>
						</tr>
						<tr id="manager_passwd_confirm" class="hide">
							<th class="its-th-align center"><span class="red bold">*</span> 관리자 비밀번호 확인</th>
							<td class="its-td"></td>
						</tr>
<?php }?>
						<tr>
							<th class="its-th-align center">이메일 / 수신여부</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">핸드폰 / 수신여부</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">전화번호</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">주소</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">실명확인</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">추천인</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">Facebook 초대인</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">생일</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">기념일</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">성별</th>
							<td class="its-td"></td>
						</tr>
						</tbody>
<?php if($TPL_VAR["form_sub"]){?>
<?php if($TPL_form_sub_1){foreach($TPL_VAR["form_sub"] as $TPL_V1){?>
<?php if($TPL_V1["used"]=='Y'&&$TPL_V1["join_type"]=='user'){?>
						<tr>
							<th class="its-th-align center"><?php echo $TPL_V1["label_title"]?></th>
							<td class="its-td"></td>
						</tr>
<?php }?>
<?php }}?>
<?php }?>
					</table>
<?php }?>

<?php if($TPL_VAR["status_nm"]!='휴면'){?>
					<table class="info-table-style buss_tab" style="width:100%">
						<colgroup>
							<col width="20%" />
							<col />
						</colgroup>
						<thead>
						<tr>
							<th colspan="2">기업정보 &nbsp;<span class="btn small"><button type="button" class="delivery_address hand">자주 쓰는 배송지</button></span></th>
						</tr>
						</thead>
						<tbody>
<?php if($TPL_VAR["snslist"]){?>
						<tr>
							<th class="its-th-align center" >사용중인 SNS</th>
							<td class="its-td">
<?php if($TPL_snslist_1){foreach($TPL_VAR["snslist"] as $TPL_V1){?>
								<img src="/admincrm/skin/default/images/sns/sns_<?php echo substr($TPL_V1["rute"], 0, 1)?>0.gif" align="absmiddle" class="btnsnsdetail hand" snscd="<?php echo $TPL_V1["rute"]?>" title="<?php echo $TPL_V1["rute_nm"]?> 정보확인">
								<div id="snsdetailPopup_<?php echo $TPL_V1["rute"]?>" class="snsdetailPopup absolute hide"></div>
<?php }}?>
							</td>
						</tr>
<?php }?>
						<tr>
							<th class="its-th-align center">아이디 </th>
							<td class="its-td">
<?php if($TPL_VAR["userid"]==$TPL_VAR["sns_n"]){?><?php echo $TPL_VAR["conv_sns_n"]?><?php }else{?><?php echo $TPL_VAR["userid"]?><?php }?> <?php if(!$TPL_VAR["withdrawal_seq"]){?><?php }?>
							</td>
						</tr>
						<!-- ### PASSWD -->
<?php if($TPL_VAR["rute"]=='none'||$TPL_VAR["sns_change"]==='1'){?>
						<tr>
							<th class="its-th-align center">
								비밀번호 변경
								<span class="tooltip_btn" onclick="showTooltip(this, '/admin/tooltip/manager', '#tip6', 'sizeM')"></span>
								<input type="checkbox" name="busi_passwd_chg">
							</th>
							<td class="its-td"><span id="busi_passwd"></span></td>
						</tr>
<?php if($TPL_VAR["business_seq"]){?>
						<tr id="busi_manager_passwd_confirm" class="hide">
							<th class="its-th-align center">관리자 비밀번호 확인 <span class="red bold">*</span></th>
							<td class="its-td" colspan="3">
								<input type="password" name="manager_password" value="" class="line" />
								<span class="helpicon" title="보안을 위하여 현재 로그인된 '<?php echo $TPL_VAR["managerInfo"]["mname"]?>(<?php echo $TPL_VAR["managerInfo"]["manager_id"]?>)'의 패스워드를 입력해주세요"></span>
							</td>
						</tr>
<?php }?>
<?php }?>
						<tr>
							<th class="its-th-align center">업체명</th>
							<td class="its-td">
								<input type="text" name="bname" value="<?php echo $TPL_VAR["bname"]?>"/>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">대표자명</th>
							<td class="its-td">
								<input type="text" name="bceo" value="<?php echo $TPL_VAR["bceo"]?>"/>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">사업자 등록번호</th>
							<td class="its-td">
								<input type="text" name="bno" value="<?php echo $TPL_VAR["bno"]?>"/>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">업태/종목</th>
							<td class="its-td">
								<input type="text" name="bitem" value="<?php echo $TPL_VAR["bitem"]?>"/> /
								<input type="text" name="bstatus" value="<?php echo $TPL_VAR["bstatus"]?>"/>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">사업장주소</th>
							<td class="its-td">
								<input type="hidden" name="companyAddress_type" value="<?php echo $TPL_VAR["baddress_type"]?>" size="60"/>
								<div class="pdt3">
									<input type="text" name="companyZipcode[]" value="<?php echo $TPL_VAR["bzipcode"]?>" size="7" readonly/>
									<span class="btn small"><input type="button" id="zipcodeButton2" value="우편번호" /></span>
								</div>
								<div class="pdt5">
									<span class="address_title" style="font-weight:<?php if($TPL_VAR["baddress_type"]!="street"){?>bold<?php }else{?>nomal<?php }?>">(지번)</span>
									<input type="text" name="companyAddress" value="<?php echo $TPL_VAR["baddress"]?>" size="60"/>
								</div>
								<div class="pdt5">
									<span class="address_title" style="font-weight:<?php if($TPL_VAR["baddress_type"]=="street"){?>bold<?php }else{?>nomal<?php }?>">(도로명)</span>
									<input type="text" name="companyAddress_street" value="<?php echo $TPL_VAR["baddress_street"]?>" size="58"/>
								</div>
								<div class="pdt5">
									<span class="address_title">(공통상세)</span>
									<input type="text" name="baddress_detail" value="<?php echo $TPL_VAR["baddress_detail"]?>" size="56"/>
								</div>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">담당자 명</th>
							<td class="its-td">
								<input type="text" name="bperson" value="<?php echo $TPL_VAR["bperson"]?>"/>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">담당자 부서명</th>
							<td class="its-td">
								<input type="text" name="bpart" value="<?php echo $TPL_VAR["bpart"]?>"/>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">담당자 전화번호</th>
							<td class="its-td">
								<input type="tel" name="bphone[]" value="<?php echo str_split_arr($TPL_VAR["bphone"],'-', 0)?>" class="size_phone" maxlength="4" /> -
								<input type="tel" name="bphone[]" value="<?php echo str_split_arr($TPL_VAR["bphone"],'-', 1)?>" class="size_phone" maxlength="4" /> -
								<input type="tel" name="bphone[]" value="<?php echo str_split_arr($TPL_VAR["bphone"],'-', 2)?>" class="size_phone" maxlength="4" />

							</td>
						</tr>
						<tr>
							<th class="its-th-align center">담당자 핸드폰</th>
							<td class="its-td">
								<input type="tel" name="bcellphone[]" value="<?php echo str_split_arr($TPL_VAR["bcellphone"],'-', 0)?>" class="size_phone" maxlength="4" /> -
								<input type="tel" name="bcellphone[]" value="<?php echo str_split_arr($TPL_VAR["bcellphone"],'-', 1)?>" class="size_phone" maxlength="4" /> -
								<input type="tel" name="bcellphone[]" value="<?php echo str_split_arr($TPL_VAR["bcellphone"],'-', 2)?>" class="size_phone" maxlength="4" />
								<span class="btn small gray"><input type="button" id="b_sms_pop" value="SMS 보내기" /></span>
								<div class="pdt5">
									광고성 정보 수신동의 안내 확인 발송 예정일: <?php echo $TPL_VAR["marketing_agree_send_date"]?>

									<span><input type="button" class="marketing_agree_log" value="발송내역" /></span>
								</div>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">이메일 / 수신여부</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<input type="text" name="email" value="<?php echo $TPL_VAR["email"]?>" class="bphonemail"/> /
								<span class="btn small gray"><input type="button" id="b_email_pop" value="이메일 보내기" /></span>
								<div class="pdt5">
									광고성 정보 수신동의 안내 확인 발송 예정일: <?php echo $TPL_VAR["marketing_agree_send_date"]?>

									<span><input type="button" class="marketing_agree_log" value="발송내역" /></span>
								</div>
<?php }?>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">마케팅 및 광고 활용 동의</th>
							<td class="its-td">
								<label for="buss_tab_mailing" >
									<input type="checkbox" id="buss_tab_mailing" name="mailing" value="y" <?php if($TPL_VAR["mailing"]=='y'){?> checked="checked" <?php }?> class="mr5"> 이메일 수신(<?php if($TPL_VAR["mailing"]=='y'){?>동의 <?php echo $TPL_VAR["update_date"]?><?php }else{?>거부 <?php echo $TPL_VAR["update_date"]?> <?php }?>)
								</label>
								<label for="buss_tab_sms">
									<input type="checkbox" id="buss_tab_sms" name="sms" value="y" <?php if($TPL_VAR["sms"]=='y'){?> checked="checked" <?php }?> class="mr5">SMS 수신(<?php if($TPL_VAR["sms"]=='y'){?>동의 <?php echo $TPL_VAR["update_date"]?><?php }else{?>거부 <?php echo $TPL_VAR["update_date"]?><?php }?>)
								</label>
							</td>
						</tr>
						<tr>
							<th class="its-th-align center">추천인</th>
							<td class="its-td">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
								<input type="text" name="recommend" id="brecommend" value="<?php echo $TPL_VAR["recommend"]?>" class="bphonemail"/>
								<span class="btn small gray"><input type="button" onclick="chkRecommend('b');" value="찾기" /></span>
								<span id="brecommend_return_txt" class="small" style="padding-top:5px;color:#d13b00;"></span>
<?php }?>
							</td>
						</tr>
						</tbody>
<?php if($TPL_VAR["form_sub"]){?>
<?php if($TPL_form_sub_1){foreach($TPL_VAR["form_sub"] as $TPL_V1){?>
<?php if($TPL_V1["used"]=='Y'&&$TPL_V1["join_type"]=='order'){?>
						<tr>
							<th class="its-th-align center"><?php echo $TPL_V1["label_title"]?></th>
							<td class="its-td"><?php echo $TPL_V1["label_view"]?></td>
						</tr>
<?php }?>
<?php }}?>
<?php }?>
					</table>
<?php }else{?>
					<table class="info-table-style buss_tab" style="width:100%">
						<colgroup>
							<col width="20%" />
							<col />
						</colgroup>
						<thead>
						<tr>
							<th colspan="2">기업정보</th>
						</tr>
						</thead>
						<tbody>
<?php if($TPL_VAR["snslist"]){?>
						<tr>
							<th class="its-th-align center" >사용중인 SNS</th>
							<td class="its-td">
<?php if($TPL_snslist_1){foreach($TPL_VAR["snslist"] as $TPL_V1){?>
								<img src="/admincrm/skin/default/images/sns/sns_<?php echo substr($TPL_V1["rute"], 0, 1)?>0.gif" align="absmiddle" class="btnsnsdetail hand" snscd="<?php echo $TPL_V1["rute"]?>" title="<?php echo $TPL_V1["rute_nm"]?> 정보확인">
								<div id="snsdetailPopup_<?php echo $TPL_V1["rute"]?>" class="snsdetailPopup absolute hide"></div>
<?php }}?>
							</td>
						</tr>
<?php }?>
						<tr>
							<th class="its-th-align center">아이디 </th>
							<td class="its-td"><?php if($TPL_VAR["userid"]==$TPL_VAR["sns_n"]){?><?php echo $TPL_VAR["conv_sns_n"]?><?php }else{?><?php echo $TPL_VAR["userid"]?><?php }?> <?php if(!$TPL_VAR["withdrawal_seq"]){?><?php }?></td>
						</tr>
						<!-- ### PASSWD -->
<?php if($TPL_VAR["rute"]=='none'||$TPL_VAR["sns_change"]==='1'){?>
						<tr>
							<th class="its-th-align center">
								비밀번호 변경
								<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/manager', '#tip6', 'sizeM')"></span>
								<input type="checkbox" name="busi_passwd_chg">
							</th>
							<td class="its-td"></td>
						</tr>
<?php if($TPL_VAR["business_seq"]){?>
						<tr id="busi_manager_passwd_confirm" class="hide">
							<th class="its-th-align center">관리자 비밀번호 확인 <span class="red bold">*</span></th>
							<td class="its-td"></td>
						</tr>
<?php }?>
<?php }?>
						<tr>
							<th class="its-th-align center">업체명</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">대표자명</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">사업자 등록번호</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">업태/종목</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">사업장주소</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">담당자 명</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">담당자 부서명</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">담당자 전화번호</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">담당자 핸드폰</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">이메일 / 수신여부</th>
							<td class="its-td"></td>
						</tr>
						<tr>
							<th class="its-th-align center">추천인</th>
							<td class="its-td"></td>
						</tr>
						</tbody>
<?php if($TPL_VAR["form_sub"]){?>
<?php if($TPL_form_sub_1){foreach($TPL_VAR["form_sub"] as $TPL_V1){?>
<?php if($TPL_V1["used"]=='Y'&&$TPL_V1["join_type"]=='order'){?>
						<tr>
							<th class="its-th-align center"><?php echo $TPL_V1["label_title"]?></th>
							<td class="its-td"></td>
						</tr>
<?php }?>
<?php }}?>
<?php }?>
					</table>
<?php }?>
				</td>
			</tr>
		</table>
	</div>
	<div class="pdt20 center">
<?php if(!$TPL_VAR["withdrawal_seq"]){?>
		<span class="btn_crm_search"><button type="submit">저장하기<span class="arrow"></span></button></span>
<?php }?>
		<div>
</form>

<!-- 아이콘 선택 -->
<div id="deliveryPopup" class="hide"></div>
<div id="emoneyPopup" class="hide"></div>
<div id="pointPopup" class="hide"></div>
<div id="cashPopup" class="hide"></div>
<div id="couponPopup" class="hide"><iframe id="couponiframe" src="" style="width:100%;height:680px"  frameborder="0"></iframe></div>
<div id="invitePopup" class="hide"><iframe id="inviteiframe" src="" style="width:100%;height:430px;"  frameborder="0"  scrolling="no" allowTransparency="true"></iframe></div>
<div id="recommendPopup" class="hide"><iframe id="recommendiframe" src="" style="width:100%;height:480px;"  frameborder="0"  scrolling="no" allowTransparency="true"></iframe></div>
<div id="marketingAgree" class="hide"></div>

<!--성인인증내역-->
<div id="adultPopup" class="hide">
	<table class="info-table-style" style="width:100%">
		<tbody>
		<tr>
			<th class="its-th-align center">번호</th>
			<th class="its-th-align center">인증수단</th>
			<th class="its-th-align center">인증날짜</th>
			<th class="its-th-align center" width="420px">접속환경</th>
		</tr>
<?php if(is_array($TPL_R1=$TPL_VAR["adult_info"]["res"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
		<tr>
			<td class="its-td"><?php echo $TPL_I1+ 1?></td>
			<td class="its-td">
<?php if($TPL_V1["auth_type"]=='phone'){?>휴대폰인증<?php }elseif($TPL_V1["auth_type"]=='ipin'){?>아이핀<?php }?>
			</td>
			<td class="its-td"><?php echo $TPL_V1["regist_date"]?></td>
			<td class="its-td"><?php echo $TPL_V1["user_agent"]?></td>
		</tr>
<?php }}?>
		</tbody>
	</table>
</div>


<div id="withdrawalPopup" class="hide">
	<form name="withdrawalForm" id="withdrawalForm" method="post" target="actionFrame" action="../member_process/member_withdrawal">
		<input type="hidden" name="member_seq" value="<?php echo $TPL_VAR["member_seq"]?>"/>
		<table class="info-table-style" style="width:100%">
			<tbody>
			<tr>
				<th class="its-th-align center" width="80">탈퇴사유</th>
				<td class="its-td">
<?php if($TPL_withdrawal_arr_1){$TPL_I1=-1;foreach($TPL_VAR["withdrawal_arr"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1% 3== 0&&$TPL_I1!= 0){?><br><?php }?>
					<label><input type="radio" name="reason" value="<?php echo $TPL_V1["codecd"]?>"/><?php echo $TPL_V1["value"]?></label>&nbsp;&nbsp;
<?php }}?>
				</td>
			</tr>
			<tr>
				<th class="its-th-align center">내용</th>
				<td class="its-td">
					<input type="text" name="memo" class="line" size="40">
				</td>
			</tr>
			<tr>
				<td class="its-td-align center" colspan="2">
					<div>회원 탈퇴 시 회원의 모든 정보가 바로 삭제되어집니다!</div>
					<div>정말로 회원(<?php if($TPL_VAR["userid"]==$TPL_VAR["sns_n"]){?><?php echo $TPL_VAR["conv_sns_n"]?><?php }else{?><?php echo $TPL_VAR["userid"]?><?php }?>)을 탈퇴시키시겠습니까?</div>
				</td>
			</tr>
			</tbody>
		</table>
		<div style="width:100%;text-align:center;padding-top:10px;">
			<span class="btn_crm_search"><button type="submit" id="send_submit">확인<span class="arrow"></span></button></span>
		</div>
	</form>
</div>

<div id="minishopPopup" class="hide">
	<table class="info-table-style" style="width:100%">
		<colgroup>
			<col width="30%" />
			<col />
			<col />
		</colgroup>
		<thead>
		<tr>
			<th class="its-th-align center">단골 미니샵 등록일</th>
			<th class="its-th-align center">업체명</th>
			<th class="its-th-align center">입점사ID</th>
		</tr>
		</thead>
		<tbody>
<?php if($TPL_minisohp_1){foreach($TPL_VAR["minisohp"] as $TPL_V1){?>
		<tr>
			<td class="its-td-align center"><?php echo $TPL_V1["regist_date"]?></td>
			<td class="its-td"><?php echo $TPL_V1["provider_name"]?></td>
			<td class="its-td"><?php echo $TPL_V1["provider_id"]?></td>
		</tr>
<?php }}?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	function membericonFileUpload(str){
		if(str > 0) {
			alert('로고를 선택해 주세요.');
			return false;
		}
		var frm = $('#membericonRegist');
		frm.attr("action","../member_process/membericonsave?mseq=<?php echo $_GET["member_seq"]?>");
		frm.submit();
	}

	function membericonDisplay(filenm){
		$("#membericon_img").attr("src",filenm);
		$("#membericon_img").css("display","block");
		$("#membericonDelete").css("display","block");
		$('#membericonRegist')[0].reset();
		$("#membericonUpdatePopup").dialog("close");
	}
</script>

<div id="membericonUpdatePopup" class="hide">
	<form name="membericonRegist" id="membericonRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">
		<div style="height:20px;padding-left:30px;"><span class='desc'>사이즈는 30 × 30 으로 등록해 주세요.</span></div>
		<div style="height:30px;padding-left:30px;"><input type="file" name="membericonFile" class="line"  id="membericonFile" onChange="membericonFileUpload();" /></div>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("button#membericonUpdate").click(function(){
			$('#membericonRegist')[0].reset();
			$("input[name='user_icon'][value='99']").attr("checked",true);
			openDialog("아이콘", "membericonUpdatePopup", {"width":"380","height":"150","show" : "fade","hide" : "fade"});
		});

		$("select[name='status']").val(['<?php echo $TPL_VAR["status"]?>']);
		$("select[name='sms']").val(['<?php echo $TPL_VAR["sms"]?>']);
		$("select[name='mailing']").val(['<?php echo $TPL_VAR["mailing"]?>']);
		$("select[name='sex']").val(['<?php echo $TPL_VAR["sex"]?>']);
		if(!'<?php echo $TPL_VAR["business_seq"]?>'){
			$("select[name='user_type']").val(['default']);
		}else{
			$("select[name='user_type']").val(['business']);
		}
		userSelect();

		$("select[name='group_seq']").change(function(){
			var img		= $("select[name='group_seq'] option:selected").attr("gicon");
			if(img){
				var icon = "<img src='../../data/icon/common/"+$("select[name='group_seq'] option:selected").attr("gicon")+"' align='absmiddle'>";
				$("#group_icon").html(icon);
			}else{
				$("#group_icon").html('');
			}
			$("input[name='group_name']").val($("select[name='group_seq'] option:selected").text());
		});

		$("#emoney_history").bind("click",function(event){
<?php if(!$TPL_VAR["auth_promotion"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
			emoney_pop();
		});

		$("#adult_history").bind("click",function(event){
			openDialog("<?php echo $TPL_VAR["user_name"]?>님의 인증내역 <span class=desc>해당 회원의 최근10건의 성인인증내역입니다.</span> ", "adultPopup", {"width":"700","height":"600"});
		});

		$("#point_history").bind("click",function(event){
<?php if(!$TPL_VAR["auth_promotion"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
			point_pop();
		});

		$("#cash_history").bind("click",function(event){
<?php if(!$TPL_VAR["auth_promotion"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
			cash_pop();
		});

		$("#coupon_history").bind("click",function(event){
			$("#couponiframe").attr("src","../coupon/member_coupon_list?member_seq=<?php echo $TPL_VAR["member_seq"]?>");
			openDialog("쿠폰 보유쿠폰/다운가능쿠폰 <span class=desc>해당 회원의 쿠폰 보유쿠폰과 다운가능쿠폰입니다.</span> ", "couponPopup", {"width":"900","height":"780"});
		});

		//추천내역
		$("#recommend_history").bind("click",function(event){
			$("#recommendiframe").attr("src","./recommend_list?member_seq=<?php echo $TPL_VAR["member_seq"]?>");
			openDialog("<?php echo $TPL_VAR["user_name"]?>님의 추천내역 <span class=desc>해당 회원의 추천내역입니다.</span> ", "recommendPopup", {"width":"700","height":"550"});
		});


		//초대내역
		$("#invite_history").bind("click",function(event){
			$("#inviteiframe").attr("src","./invite_list?member_seq=<?php echo $TPL_VAR["member_seq"]?>");
			openDialog("<?php echo $TPL_VAR["user_name"]?>님의 초대내역 <span class=desc>해당 회원의 초대내역입니다.</span> ", "invitePopup", {"width":"700","height":"550"});
		});

		$("#sms_pop").bind("click",function(event){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
			$.get('/admin/member/sms_pop?member_seq=<?php echo $TPL_VAR["member_seq"]?>', function(data) {
				$('#sendPopup').html(data);
				openDialog("SMS 발송", "sendPopup", {"width":"700","height":"350"});
			});
		});

		$("#b_sms_pop").bind("click",function(event){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
			$.get('/admin/member/sms_pop?member_seq=<?php echo $TPL_VAR["member_seq"]?>', function(data) {
				$('#sendPopup').html(data);
				openDialog("SMS 발송", "sendPopup", {"width":"700","height":"350"});
			});
		});

		$("#email_pop").bind("click",function(event){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
			$.get('/admin/member/email_pop?member_seq=<?php echo $TPL_VAR["member_seq"]?>', function(data) {
				$('#sendPopup').html(data);
				openDialog("EMAIL 발송", "sendPopup", {"width":"1000","height":"720"});
			});
		});

		$("#b_email_pop").bind("click",function(event){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
			$.get('/admin/member/email_pop?member_seq=<?php echo $TPL_VAR["member_seq"]?>', function(data) {
				$('#sendPopup').html(data);
				openDialog("EMAIL 발송", "sendPopup", {"width":"1000","height":"720"});
			});
		});


		/* PASSWORD */
		$("input[name='passwd_chg']").bind("click",function(){
			var input = "<input type='password' name='password' class='class_check_password_validation'/>";
			if($(this).attr("checked")){
				$("#passwd").html(input);
				$("#manager_passwd_confirm").show();
			}else{
				$("#passwd").html('');
				$("#manager_passwd_confirm").hide();
			}

			$(".class_check_password_validation").each(function(){
				init_check_password_validation($(this));
			});
		});

		/* 기업 PASSWORD */
		$("input[name='busi_passwd_chg']").bind("click",function(){
			var input = "<input type='password' name='password' class='class_check_password_validation'/>";
			if($(this).attr("checked")){
				$("#busi_passwd").html(input);
				<!-- 2022.01.11 12월 4차 패치시 모두 지움 -->
				$("#busi_manager_passwd_confirm").hide();
			}else{
				$("#busi_passwd").html('');
				$("#busi_manager_passwd_confirm").show();
			}

			$(".class_check_password_validation").each(function(){
				init_check_password_validation($(this));
			});
		});


		$("#zipcodeButton").live("click",function(){
			openDialogZipcode('');
		});
		$("#zipcodeButton2").live("click",function(){
			openDialogZipcode('company');
		});

		$(document).bind('keydown', 'Ctrl+s', function(){
			$("#memberForm").submit();
			return false;
		});

		/*
		$(":text").bind('keydown', 'Ctrl+s', function(){
			$("#memberForm").submit();
			return false;
		});
		*/

		$(".delivery_address").bind("click", function(){
			var title ="자주쓰는 배송지"
			$.get('/admin/member/delivery?tab=1&member_seq=<?php echo $TPL_VAR["member_seq"]?>', function(data) {
				$("div#deliveryPopup").html(data);
			});
			openDialog(title,'deliveryPopup', {"width":700,"height":400})
		});

		// sns 계정 정보 확인
		$(".btnsnsdetail").bind("click",function(){

			var snscd	= $(this).attr("snscd");
			var obj		= $("div#snsdetailPopup_"+snscd);
			var disp	= obj.css("display");
			$(".snsdetailPopup").hide();
			if(obj.html() == ''){
				$.get('sns_detail?snscd='+snscd+'&member_seq=<?php echo $TPL_VAR["member_seq"]?>', function(data) {
					obj.html(data);
				});
			}
			if(disp == "none"){ obj.show(); }
		});

		//광고성 정보 수신동의 안내 메일 발송 내역
		$(".marketing_agree_log").on("click",function(event){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }?>
			$.get('/admin/member/marketing_agree_log?member_seq=<?php echo $TPL_VAR["member_seq"]?>', function(data) {
				$('#marketingAgree').html(data);
				openDialog("광고성 정보 수신동의 안내 메일 발송 내역", "marketingAgree", {"width":"600","height":"500"});
			});
		});

	});

	// 추천인 확인
	function chkRecommend(type){
		var recommend	= $("#recommend").val();
		if(type=="b")	recommend = $("#brecommend").val();
		if	(!recommend){
			openDialogAlert('추천인 ID를 입력하세요', 400, 150);
			return;
		}
		actionFrame.location.href	= '/member/recommend_confirm?recomid='+recommend+'&type='+type;
	}

	function emoney_pop(){
<?php if(!$TPL_VAR["auth_promotion"]){?>
		alert("권한이 없습니다.");
		return;
<?php }?>
		$.get('emoney_detail?member_seq=<?php echo $TPL_VAR["member_seq"]?>', function(data) {
			$('#emoneyPopup').html(data);
			openDialog("마일리지 내역 <span class='desc'>해당 회원의 마일리지 내역 및 수동으로 지급/차감을 하실 수 있습니다.</span>", "emoneyPopup", {"width":"900","height":"820"});
		});
	}

	function point_pop(){
<?php if(!$TPL_VAR["auth_promotion"]){?>
		alert("권한이 없습니다.");
		return;
<?php }?>
		$.get('point_detail?member_seq=<?php echo $TPL_VAR["member_seq"]?>', function(data) {
			$('#pointPopup').html(data);
			openDialog("포인트 내역 <span class='desc'>해당 회원의 포인트 내역 및 수동 지급/차감을 하실 수 있습니다.</span>", "pointPopup", {"width":"800","height":"820"});
		});
	}

	function cash_pop(){
<?php if(!$TPL_VAR["auth_promotion"]){?>
		alert("권한이 없습니다.");
		return;
<?php }?>
		$.get('cash_detail?member_seq=<?php echo $TPL_VAR["member_seq"]?>', function(data) {
			$('#cashPopup').html(data);
			openDialog("예치금 내역 <span class='desc'>해당 회원의 예치금 내역.</span>", "cashPopup", {"width":"800","height":"820"});
		});
	}

	function with_pop(){
<?php if(!$TPL_VAR["auth_act"]){?>
		alert("권한이 없습니다.");
		return;
<?php }?>
		openDialog("회원 탈퇴", "withdrawalPopup", {"width":"500","height":"300"});
	}

	function userSelect(){
		var value = '<?php echo $TPL_VAR["withdrawal_seq"]?>';
		if(value){
			$(".user_tab").show();
			$(".buss_tab").hide();
			$(".uphonemail").removeAttr('disabled');
			$(".bphonemail").attr('disabled', true);
			return;
		}

		if($("#user_type").val()=='default'){
			$(".user_tab").show();
			$(".buss_tab").hide();
			$(".uphonemail").removeAttr('disabled');
			$(".bphonemail").attr('disabled', true);

			$("#user_tab_mailing").removeAttr('disabled');
			$("#user_tab_sms").removeAttr('disabled');

			$("#buss_tab_mailing").attr('disabled', true);
			$("#buss_tab_sms").attr('disabled', true);
		}else{
			$(".user_tab").hide();
			$(".buss_tab").show();
			$(".bphonemail").removeAttr('disabled');
			$(".uphonemail").attr('disabled', true);

			$("#buss_tab_mailing").removeAttr('disabled');
			$("#buss_tab_sms").removeAttr('disabled');

			$("#user_tab_mailing").attr('disabled', true);
			$("#user_tab_sms").attr('disabled', true);
		}
	}
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>