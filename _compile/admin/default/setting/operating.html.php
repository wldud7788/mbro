<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/setting/operating.html 000022414 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	var resp_flag = "";
<?php if($TPL_VAR["operationType"]=='light'){?>
		resp_flag = "_resp";
<?php }?>

	function check_operating(type){
		var obj = $("input[name='operating']:checked").parent();
		var chkValue = $("input[name='operating']:checked").val();
		var tdx = obj.parent().parent("tr").index();
	/*
		obj.parent().parent().parent().children().each(function(idx){
			if (tdx == idx) {							
				$(this).find("td[rowspan]").css({"border-bottom":"2px solid #ab0804"});
			} else {
				$(this).find("td[rowspan]").css({"border-bottom":"1px solid #dadada"});
				$(this).next().css({"border":"1px solid #dadada","background-color":"#fff"});
			}
		});
	
		obj.parent().parent("tr").css({
			"border-top":"2px solid #ab0804", "border-left":"2px solid #ab0804", "border-right":"2px solid #ab0804", "background-color":"#ffffe8"
		});
		obj.parent().parent("tr").next().css({
			"border-top":"1px solid #dadada", "border-left":"2px solid #ab0804", "border-right":"2px solid #ab0804", "border-bottom":"2px solid #ab0804", "background-color":"#ffffe8"});
	*/
		if(type!='chg'){
			$("#now_operating").html(obj.children("span").html());
		}
	}
	$(document).ready(function() {
		$("input[name='operating']").live("click",function(){
			
			var idx = $(this).parent().parent().index();

<?php if($TPL_VAR["realname"]["adult_chk"]!='Y'){?>
			if(idx == 2) { // 성인몰
				if(confirm('성인 쇼핑몰을 운영 하시려면 먼저 휴대폰인증&아이핀서비스를 설정하셔야 합니다.\n설정>회원>본인확인으로 이동하시겠습니까?')){
					location.href = "/admin/setting/member?gb=realname";
				}
				$("input[name='operating']").val(['general']);
			}
<?php }?>
			check_operating('chg');
		});
<?php if($TPL_VAR["operating"]){?>
		$("input[name='operating'][value='<?php echo $TPL_VAR["operating"]?>']").attr('checked','checked');
		$("input[name='intro_use'][value='<?php echo $TPL_VAR["intro_use"]?>']").attr('checked','checked');
		$("input[name='general_use'][value='<?php echo $TPL_VAR["general_use"]?>']").attr('checked','checked');
		$("input[name='member_use'][value='<?php echo $TPL_VAR["member_use"]?>']").attr('checked','checked');
		$("input[name='adult_use'][value='<?php echo $TPL_VAR["adult_use"]?>']").attr('checked','checked');

		// 운영방식 모바일(태블릿) 추가 2014-05-20 leewh
		var intro_m_use = ('<?php echo $TPL_VAR["intro_m_use"]?>') ? '<?php echo $TPL_VAR["intro_m_use"]?>' : '<?php echo $TPL_VAR["intro_use"]?>';
		var general_m_use = ('<?php echo $TPL_VAR["general_m_use"]?>') ? '<?php echo $TPL_VAR["general_m_use"]?>' : '<?php echo $TPL_VAR["general_use"]?>';
		var member_m_use = ('<?php echo $TPL_VAR["member_m_use"]?>') ? '<?php echo $TPL_VAR["member_m_use"]?>' : '<?php echo $TPL_VAR["member_use"]?>';
		var adult_m_use = ('<?php echo $TPL_VAR["adult_m_use"]?>') ? '<?php echo $TPL_VAR["adult_m_use"]?>' : '<?php echo $TPL_VAR["adult_use"]?>';

		$("input[name='intro_m_use'][value='"+intro_m_use+"']").attr('checked',true);
		$("input[name='general_m_use'][value='"+general_m_use+"']").attr('checked',true);
		$("input[name='member_m_use'][value='"+member_m_use+"']").attr('checked',true);
		$("input[name='adult_m_use'][value='"+adult_m_use+"']").attr('checked',true);
<?php }?>
		check_operating('init');

		$("input[name='operating']").live("click", function(){
			init_process();
		});

		$("input[name='intro_use'], input[name='general_use'], input[name='intro_m_use'], input[name='general_m_use']").live("click",function(){
			set_img_general();
		});

		$("input[name='member_use'], input[name='member_m_use']").live("click",function(){
			set_img_member();
		});

		$("input[name='adult_use'], input[name='adult_m_use']").live("click",function(){
			set_img_adult();
		});

<?php if($TPL_VAR["service_limit"]){?>
		$("input[name='operating'][value='member']").attr("disabled",true);
		$("input[name='operating'][value='adult']").attr("disabled",true);
<?php }?>

		init_process();

		// 미리보기 샘플 설정
		set_img_general();
		set_img_member();
		set_img_adult();
	});

	function init_process(){
		var chk = $("input[name='operating']:checked").val();
		$(".operating .setting").css("display", "none");
		if(chk=='general'){
			$("input[name='general_use']").attr("disabled",false);
			$("input[name='general_m_use']").attr("disabled",false);
			$("input[name='member_use']").attr("disabled",true);
			$("input[name='member_m_use']").attr("disabled",true);
			$("input[name='adult_use']").attr("disabled",true);
			$("input[name='adult_m_use']").attr("disabled",true);
			$("input[name='intro_use']").attr("disabled",false);
			$("input[name='intro_m_use']").attr("disabled",false);
			$(".setting_general").css("display", "block");
		}else if(chk=='member'){
			$("input[name='general_use']").attr("disabled",true);
			$("input[name='general_m_use']").attr("disabled",true);
			$("input[name='member_use']").attr("disabled",false);
			$("input[name='member_m_use']").attr("disabled",false);
			$("input[name='adult_use']").attr("disabled",true);
			$("input[name='adult_m_use']").attr("disabled",true);
			$("input[name='intro_use']").attr("disabled",true);
			$("input[name='intro_m_use']").attr("disabled",true);
			$(".setting_member").css("display", "block");
		}else if(chk=='adult'){
			$("input[name='general_use']").attr("disabled",true);
			$("input[name='general_m_use']").attr("disabled",true);
			$("input[name='member_use']").attr("disabled",true);
			$("input[name='member_m_use']").attr("disabled",true);
			$("input[name='adult_use']").attr("disabled",false);
			$("input[name='adult_m_use']").attr("disabled",false);
			$("input[name='intro_use']").attr("disabled",true);
			$("input[name='intro_m_use']").attr("disabled",true);
			$(".setting_adult").css("display", "block");
		}
	}

	function set_img_general() {
			var intro = $("input[name='intro_use']:checked").val();
			var general = $("input[name='general_use']:checked").val();
			var img_box = $("#img_box_intro img");

<?php if($TPL_VAR["operationType"]=='light'){?>
			// RESPONSIVE
			if (intro=="Y" && general=="Y" || intro=="N" && general=="Y") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_underconstruction_resp.gif");
			} else if (intro=="Y" && general=="N") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_intro_resp.gif");
			} else if (intro=="N" && general=="N") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_main_resp.gif");
			}
<?php }else{?>
			// PC
			if (intro=="Y" && general=="Y" || intro=="N" && general=="Y") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_underconstruction.gif");
			} else if (intro=="Y" && general=="N") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_intro.gif");
			} else if (intro=="N" && general=="N") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_main.gif");
			}
<?php }?>

			var intro_m = $("input[name='intro_m_use']:checked").val();
			var general_m = $("input[name='general_m_use']:checked").val();
			var img_box_m = $("#img_box_intro_m img");

			// 모바일
			if (intro_m=="Y" && general_m=="Y" || intro_m=="N" && general_m=="Y") {
				img_box_m.attr("src","/admin/skin/default/images/common/intro_sample_underconstruction_m.gif");
			} else if (intro_m=="Y" && general_m=="N") {
				img_box_m.attr("src","/admin/skin/default/images/common/intro_sample_intro_m.gif");
			} else if (intro_m=="Y" && general_m=="P") {
				img_box_m.attr("src","/admin/skin/default/images/common/intro_sample.gif");
			} else if (intro_m=="N" && general_m=="N") {
				img_box_m.attr("src","/admin/skin/default/images/common/intro_sample_main_m.gif");
			} else if (intro_m=="N" && general_m=="P") {
				img_box_m.attr("src","/admin/skin/default/images/common/intro_sample_main_pc.gif");
			}
	}

	function set_img_member() {
			var member = $("input[name='member_use']:checked").val();
			var img_box = $("#img_box_member img");
			
<?php if($TPL_VAR["operationType"]=='light'){?>
			// RESPONSIVE
			if (member=="Y") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_member_resp.gif");
			} else if (member=="N") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_underconstruction_resp.gif");
			}
<?php }else{?>
			// PC
			if (member=="Y") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_member.gif");
			} else if (member=="N") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_underconstruction.gif");
			}
<?php }?>

			var member_m = $("input[name='member_m_use']:checked").val();
			var img_box_m = $("#img_box_member_m img");

			// 모바일
			if (member_m=="Y") {
				img_box_m.attr("src","/admin/skin/default/images/common/intro_sample_member_m.gif");
			} else if (member_m=="P") {
				img_box_m.attr("src","/admin/skin/default/images/common/intro_sample_member_pc.gif");
			} else if (member_m=="N") {
				img_box_m.attr("src","/admin/skin/default/images/common/intro_sample_underconstruction_m.gif");
			}
	}

	function set_img_adult() {
			var adult = $("input[name='adult_use']:checked").val();
			var img_box = $("#img_box_adult img");
			
<?php if($TPL_VAR["operationType"]=='light'){?>
			// RESPONSIVE
			if (adult=="Y") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_19_resp.gif");
			} else if (adult=="N") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_underconstruction_resp.gif");
			}
<?php }else{?>
			// PC
			if (adult=="Y") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_19_resp.gif");
			} else if (adult=="N") {
				img_box.attr("src","/admin/skin/default/images/common/intro_sample_underconstruction.gif");
			}
<?php }?>

			var adult_m = $("input[name='adult_m_use']:checked").val();
			var img_box_m = $("#img_box_adult_m img");

			// 모바일
			if (adult_m=="Y") {
				img_box_m.attr("src","/admin/skin/default/images/common/intro_sample_19_m.gif");
			} else if (adult_m=="P") {
				img_box_m.attr("src","/admin/skin/default/images/common/intro_sample_19_pc.gif");
			} else if (adult_m=="N") { // 오픈 준비 중
				img_box_m.attr("src","/admin/skin/default/images/common/intro_sample_underconstruction_m.gif");
			}
	}
</script>

<form name="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/operating" target="actionFrame">

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
			<h2>운영 방식</h2>
		</div>

		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<button class="resp_btn active size_L" type="submit">저장</button>
		</div>

	</div>
</div>

<!-- 서브메뉴 바디 : 시작-->
<div class="contents_dvs operating">
	<div class="item-title">운영 방식</div>			
	<!-- 페이지 타이틀 바 : 끝 -->
<?php if($TPL_VAR["operationType"]=='light'){?>
	<!-- 서브 레이아웃 영역 : 시작 -->
	<table class="table_basic thl ">
		<tr>
			<th>운영 방식</th>
			<td>					
				<ul class="ul_list_08 resp_radio">
					<li>
						<label ><input type="radio" name="operating" value="general" checked="checked" /> 일반</label>
						<div id="img_box_intro" class="mt5"><img src="/admin/skin/default/images/common/intro_sample_main_resp.gif" class="line"/></div>
					</li>
					<li
<?php if(serviceLimit('H_FR')){?>
						 onclick="openDialog('쇼핑몰 업그레이드 안내<span class=\'desc\'></span>', 'nofreeService', {'width':600,'height':280});"
<?php }?>
					>
						<label><input type="radio" name="operating" value="member" /> 회원 전용</label>
						<div id="img_box_member" class="mt5"><img src="/admin/skin/default/images/common/intro_sample_underconstruction_resp.gif"  class="line"/></div>
					</li>
					<li
<?php if(serviceLimit('H_FR')){?>
						 onclick="openDialog('쇼핑몰 업그레이드 안내<span class=\'desc\'></span>', 'nofreeService', {'width':600,'height':280});"
<?php }?>
					>
						<label><input type="radio" name="operating" value="adult" /> 성인 전용(19세 이상)</label>
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/operating', '#tip1', 'sizeM')"></span>
						<div id="img_box_adult" class="mt5"><img src="/admin/skin/default/images/common/intro_sample_19_resp.gif"  class="line"/></div>
					</li>
				</ul>					
			</td>				
		</tr>

		<tr>
			<th>인트로 페이지(반응형)</th>
			<td class="clear">
				<table class="table_basic thl v3">
					<tr>
						<th>사용 여부</th>
						<td>
							<div class="setting_general setting resp_radio">
								<label><input type="radio" name="intro_use" value="Y"> 사용함</label>
								<label><input type="radio" name="intro_use" value="N" checked="checked"> 사용 안 함</label>
							</div>
<?php if(serviceLimit('H_NFR')){?>
							<div class="setting_member setting hide">사용 필수</div>	
							<div class="setting_adult setting hide">사용 필수</div>
<?php }?>
						</td>
					</tr>
					<tr>
						<th>제공 방식</th>
						<td>
							<div class="setting_general setting resp_radio">
								<label><input type="radio" name="general_use" value="N" checked="checked"> 운영 중</label>
								<label><input type="radio" name="general_use" value="Y"> 오픈 준비 중(공사 중)</label>
								<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/operating', '#tip2')"></span>
							</div>
<?php if(serviceLimit('H_NFR')){?>
							
							<!--회원전용 운영여부 설정-->	
							<div class="setting_member setting hide resp_radio">
								<label><input type="radio" name="member_use" value="Y" checked="checked"> 운영 중</label>
								<label><input type="radio" name="member_use" value="N"> 오픈 준비 중(공사 중)</label>	
								<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/operating', '#tip2')"></span>
							</div>

							<!--성인전용 운영여부 설정-->	
							<div class="setting_adult setting hide resp_radio">
								<label><input type="radio" name="adult_use" value="Y" checked="checked"> 운영 중</label>
								<label><input type="radio" name="adult_use" value="N"> 오픈 준비 중(공사 중)</label>	
								<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/operating', '#tip2')"></span>
							</div>
<?php }?>
						</td>
					</tr>
				</table>
			</td>				
		</tr>					
	</table>		
<?php }else{?>
	<!-- 서브 레이아웃 영역 : 시작 -->
	<table class="table_basic thl">	
		<tr>
			<th>운영 방식</th>
			<td>
				<ul class="ul_list_08 resp_radio">
					<li>
						<label><input type="radio" name="operating" value="general" checked="checked" /> 일반</label>
						<div class="mt5">
							<span id="img_box_intro"><img src="/admin/skin/default/images/common/intro_sample_underconstruction_resp.gif" class="line"/></span>
							<span id="img_box_intro_m"><img src="/admin/skin/default/images/common/intro_sample_underconstruction.gif" class="line" style="height:120px;"/></span>	
						</div>
					</li>
<?php if(serviceLimit('H_NFR')){?>
					<li>
						<label><input type="radio" name="operating" value="member" /> 회원 전용</label>
						<div class="mt5">
							<span id="img_box_member"><img src="/admin/skin/default/images/common/intro_sample_member_resp.gif" class="line"/></span>
							<span id="img_box_member_m"><img src="/admin/skin/default/images/common/intro_sample_member.gif" class="line" style="height:120px;"/></span>
						</div>
					</li>
					<li>
						<label><input type="radio" name="operating" value="adult" /> 성인 전용(19세 이상)</label>
						<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/operating', '#tip1', 'sizeM')"></span>
						<div class="mt5">
							<span id="img_box_adult"><img src="/admin/skin/default/images/common/intro_sample_19_resp.gif" class="line"/></span>
							<span id="img_box_adult_m"><img src="/admin/skin/default/images/common/intro_sample_19.gif" class="line" style="height:120px;"/></span>
						</div>
					</li>
<?php }?>
				</ul>
			</td>					
		</tr>

		<tr>
			<th>인트로 페이지(PC)</th>
			<td class="clear">
				<table class="table_basic thl v3">
					<tr>
						<th>사용 여부</th>
						<td>
							<div class="setting_general setting resp_radio">
								<label><input type="radio" name="intro_use" value="Y"> 사용함</label>
								<label><input type="radio" name="intro_use" value="N" checked="checked"> 사용 안 함</label>
							</div>
<?php if(serviceLimit('H_NFR')){?>
							<div class="setting_member setting hide">사용 필수</div>

							<div class="setting_adult setting hide">사용 필수</div>
<?php }?>
						</td>
					</tr>
					<tr>
						<th>제공 방식</th>
						<td>
							<div class="setting_general setting">
								<div class="resp_radio">
									<label><input type="radio" name="general_use" value="N" checked="checked"> 운영 중</label>
									<label><input type="radio" name="general_use" value="Y"> 오픈 준비 중(공사 중)</label>
									<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/operating', '#tip2')"></span>
								</div>
							</div>
							
<?php if(serviceLimit('H_NFR')){?>
							<div class="setting_member setting hide">
								<div class="resp_radio">
									<label><input type="radio" name="member_use" value="Y" checked="checked"> 운영 중</label>
									<label><input type="radio" name="member_use" value="N"> 오픈 준비 중(공사 중)</label>	
									<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/operating', '#tip2')"></span>
								</div>
							</div>
							
							<div class="setting_adult setting hide">
								<div class="resp_radio">
									<label><input type="radio" name="adult_use" value="Y" checked="checked"> 운영 중</label>
									<label><input type="radio" name="adult_use" value="N"> 오픈 준비 중(공사 중)</label>	
									<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/operating', '#tip2')"></span>
									</div>
							</div>
<?php }?>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<th>인트로 페이지(모바일)</th>
			<td class="clear">
				<table class="table_basic thl v3">
					<tr>
						<th>사용 여부</th>
						<td>
							<div class="setting_general setting resp_radio">
								<label><input type="radio" name="intro_m_use" value="Y"> 사용함</label>
								<label><input type="radio" name="intro_m_use" value="N" checked="checked"> 사용 안 함</label>
							</div>
<?php if(serviceLimit('H_NFR')){?>
							<div class="setting_member setting hide">사용 필수</div>

							<div class="setting_adult setting hide">사용 필수</div>
<?php }?>
						</td>
					</tr>
					<tr>
						<th>제공 방식</th>
						<td>
							<!--일반->M 정상 운영여부 설정-->
							<div class="setting_general setting">
								<div class="resp_radio">
									<label><input type="radio" name="general_m_use" value="N" checked="checked"> 운영 중</label>
									<label><input type="radio" name="general_m_use" value="P"> 운영 중(PC와 동일)</label>
									<label><input type="radio" name="general_m_use" value="Y"> 오픈 준비 중(공사 중)</label>
									<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/operating', '#tip2')"></span>
								</div>
							</div>

<?php if(serviceLimit('H_NFR')){?>
							<div class="setting_member setting hide">
								<div class="resp_radio">
									<label><input type="radio" name="member_m_use" value="Y" checked="checked"> 운영 중</label>
									<label><input type="radio" name="member_m_use" value="P"> 운영 중(PC와 동일)</label>
									<label><input type="radio" name="member_m_use" value="N"> 오픈 준비 중(공사 중)</label>
									<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/operating', '#tip2')"></span>
								</div>
							</div>
							
							<div class="setting_adult setting hide">
								<div class="resp_radio">
									<label><input type="radio" name="adult_m_use" value="Y" checked="checked"> 운영 중</label>
									<label><input type="radio" name="adult_m_use" value="P"> 운영 중(PC와 동일)</label>
									<label><input type="radio" name="adult_m_use" value="N"> 오픈 준비 중(공사 중)</label>
									<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/operating', '#tip2')"></span>
								</div>
							</div>
<?php }?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<?php }?>
</div>
<!-- 서브메뉴 바디 : 끝 -->

<div class="box_style_05 mt20">
	<div class="title">안내</div>
	<ul class="bullet_circle">					
		<li>운영 방식 설정에 따라 쇼핑몰 접근 권한이 변경됩니다.</li>			
	</ul>
</div>	

</form>

<div id="shopBranchPopup" style="display: none">
	<div align="center">
	<select name="shopBranchSel">
		<option value="">쇼핑몰 분류1을 선택하세요.</option>
<?php if(is_array($TPL_R1=code_load('shopBranch'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<option value='<?php echo $TPL_V1["codecd"]?>'><?php echo $TPL_V1["value"]?></option>
<?php }}?>
	</select>
	<select name="shopBranchSub">
		<option value="">쇼핑몰 분류2를 선택하세요.</option>
	</select>
	</div>

	<div style="padding:10px 0 0 0" align="center"><span class="btn medium"><input type="button" value="추가" id="shopBranchButton" /></span></div>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>