<?php /* Template_ 2.2.6 2022/05/17 12:37:01 /www/music_brother_firstmall_kr/admin/skin/default/setting/realname.html 000009250 */ ?>
<!-- 회원설정 : 실명확인 -->
<script type="text/javascript">
$(document).ready(function() {

	// 사이트 코드 및 패스워드 체크 :: 2015-07-30 lwh
	$(".realnamephone,.ipin").bind('blur',function(){
		defult_setting();
	});

	// 성인전용은 무조건 사용으로 pixed :: 2015-07-30 lwh
	$("#useRealnamephone_adult,#useIpin_adult").bind('click',function(){
		defult_setting();
		alert('성인인증은 필수로 사용해야 합니다.');
	});

<?php if($TPL_VAR["dormancy"]=='namecheck'){?>
	$("#useRealnamephone_dormancy,#useIpin_dormancy").bind('click',function(){
		event.preventDefault();
		alert('휴면해제 방법을 다른방법으로 설정하여주세요');
	});
<?php }?>

	$("#now_operating").html('<?php echo $TPL_VAR["status"]?>');

	defult_setting();
	apply_input_style();

	// 상단 매뉴얼 링크 변경 leewh 2014-10-01
	$(".page-manual-btn a").attr('href','http://manual.firstmall.kr/html/manual.php?category=010011');
});

function defult_setting(){
	var realnamephoneSikey	= $("input[name='realnamephoneSikey']").val();
	var realnamePhoneSipwd	= $("input[name='realnamePhoneSipwd']").val();
	var ipinSikey			= $("input[name='ipinSikey']").val();
	var ipinKeyString		= $("input[name='ipinKeyString']").val();

	if(realnamephoneSikey && realnamePhoneSipwd){
		$(".realnamephone_use").attr('disabled',false);
		$("#useRealnamephone_adult[value='Y']").attr('checked',true);
	}else{
		$(".realnamephone_use").attr('disabled',true);
		$(".realnamephone_use").attr('checked',false);
		$("input[name='useRealnamephone'][value='N']").attr('checked',true);
		$("input[name='useRealnamephone_dormancy'][value='N']").attr('checked',true);
	}

	if(ipinSikey && ipinKeyString){
		$(".useIpin_use").attr('disabled',false);
		$("#useIpin_adult").attr('checked',true);
	}else{
		$(".useIpin_use").attr('disabled',true);
		$(".useIpin_use").attr('checked',false);
		$("input[name='useIpin'][value='N']").attr('checked',true);
		$("input[name='useIpin_dormancy'][value='N']").attr('checked',true);
	}
}
</script>

<div class="contents_dvs">
	<div class="title_dvs">
		<div class="item-title">
			휴대폰 인증 설정
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip1')"></span>
		</div>							
		<a href="https://www.firstmall.kr/addservice/cellphone" class="resp_btn" target="_blank">휴대폰 인증 안내</a>	
	</div>

	<table class="table_basic thl">
		<tr>
			<th>휴대폰 인증</th>
			<td class="clear">
				<table class="table_basic v3 thl">
					<tr>
						<th>사이트 코드</th>
						<td>
							<input type="text" name="realnamephoneSikey" value="<?php echo $TPL_VAR["realnamephoneSikey"]?>"  oldval="<?php echo $TPL_VAR["realnamephoneSikey"]?>" size="40" class="line realnamephone wp95" <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>  />
						</td>
					</tr>
					<tr>
						<th>사이트 패스워드</th>
						<td>
							<input type="text" name="realnamePhoneSipwd" value="<?php echo $TPL_VAR["realnamePhoneSipwd"]?>" oldval="<?php echo $TPL_VAR["realnamePhoneSipwd"]?>" size="40" class="line realnamephone wp95" <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?> />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<th>
				사용 설정
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip2')"></span>
			</th>
			<td class="clear">
				<table class="table_basic v3 thl">
					<tr>
						<th>회원 가입</th>
						<td>
							<div class="resp_radio">
								<label>
									<input type="radio" name="useRealnamephone" id="useRealnamephone" value="Y" class="realnamephone_use" <?php if($TPL_VAR["useRealnamephone"]=='Y'){?>checked<?php }?>/> 사용함
								</label>
								<label>
									<input type="radio" name="useRealnamephone" id="useRealnamephone" value="N" class="realnamephone_use" <?php if($TPL_VAR["useRealnamephone"]=='N'||$TPL_VAR["useRealnamephone"]==''){?>checked<?php }?>/> 사용 안 함
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>성인용품 상품 접근</th>
						<td>
							사용 필수
							<input type="hidden" name="useRealnamephone_adult" id="useRealnamephone_adult" value="Y" class="realnamephone_use" checked />
							<!--
							<label class="mr15" >
								<input type="radio" name="useRealnamephone_adult" id="useRealnamephone_adult" value="Y" class="realnamephone_use" <?php if($TPL_VAR["useRealnamephone_adult"]=='Y'){?>checked<?php }?> /> 사용함
							</label>
							<label>
								<input type="radio" name="useRealnamephone_adult" id="useRealnamephone_adult" value="N" class="realnamephone_use" <?php if($TPL_VAR["useRealnamephone_adult"]=='N'||$TPL_VAR["useRealnamephone_adult"]==''){?>checked<?php }?> /> 사용 안 함
							</label>-->
						</td>
					</tr>
					<tr>
						<th>휴면회원 본인 인증</th>
						<td>
							<div class="resp_radio">
								<label>
									<input type="radio" name="useRealnamephone_dormancy" id="useRealnamephone_dormancy" value="Y" class="realnamephone_use" <?php if($TPL_VAR["useRealnamephone_dormancy"]=='Y'){?>checked<?php }?> /> 사용함
								</label>
								<label>
									<input type="radio" name="useRealnamephone_dormancy" id="useRealnamephone_dormancy" value="N" class="realnamephone_use" <?php if($TPL_VAR["useRealnamephone_dormancy"]=='N'||$TPL_VAR["useRealnamephone_dormancy"]==''){?>checked<?php }?> /> 사용 안 함
								</label>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<div class="contents_dvs">
	<div class="title_dvs">
		<div class="item-title">
			아이핀 사용 설정
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip3')"></span>
		</div>				
		<a href="https://www.firstmall.kr/addservice/ipin" class="resp_btn" target="_blank">아이핀 인증 안내</a>		
	</div>

	<table class="table_basic thl">
		<tr>
			<th>아이핀 인증</th>
			<td class="clear">
				<table class="table_basic v3 thl">
					<tr>
						<th>사이트 코드</th>
						<td>
							<input type="text" name="ipinSikey" value="<?php echo $TPL_VAR["ipinSikey"]?>"  oldval="<?php echo $TPL_VAR["ipinSikey"]?>" size="40" class="line ipin wp95" <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?> />
						</td>
					</tr>
					<tr>
						<th>사이트 패스워드</th>
						<td>
							<input type="text" name="ipinKeyString" value="<?php echo $TPL_VAR["ipinKeyString"]?>"  oldval="<?php echo $TPL_VAR["ipinKeyString"]?>" size="40" class="line ipin wp95" <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<th>
				사용 설정
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip2')"></span>
			</th>
			<td class="clear">
				<table class="table_basic v3 thl">
					<tr>
						<th>회원 가입</th>
						<td>
							<div class="resp_radio">
								<label>
									<input type="radio" name="useIpin" id="useIpin" value="Y" class="useIpin_use" <?php if($TPL_VAR["useIpin"]=='Y'){?>checked<?php }?> /> 사용함
								</label>
								<label>
									<input type="radio" name="useIpin" id="useIpin" value="N" class="useIpin_use" <?php if($TPL_VAR["useIpin"]=='N'||$TPL_VAR["useIpin"]==''){?>checked<?php }?> /> 사용 안 함
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<th>성인용품 상품 접근</th>
						<td>
							사용 필수
							<input type="hidden" name="useIpin_adult" id="useIpin_adult" value="Y" class="useIpin_use" checked />
							<!--
							<label class="mr15">
								<input type="radio" name="useIpin_adult" id="useIpin_adult" value="Y" class="useIpin_use" <?php if($TPL_VAR["useIpin_adult"]=='Y'){?>checked<?php }?> /> 사용함 
							</label>
							<label>
								<input type="radio" name="useIpin_adult" id="useIpin_adult" value="N" class="useIpin_use" <?php if($TPL_VAR["useIpin_adult"]=='N'||$TPL_VAR["useIpin_adult"]==''){?>checked<?php }?> /> 사용 안 함 
							</label>-->
						</td>
					</tr>
					<tr>
						<th>휴면회원 본인 인증</th>
						<td>
							<div class="resp_radio">
								<label>
									<input type="radio" name="useIpin_dormancy" id="useIpin_dormancy" value="Y" class="useIpin_use" <?php if($TPL_VAR["useIpin_dormancy"]=='Y'){?>checked<?php }?> /> 사용함 
								</label>
								<label>
									<input type="radio" name="useIpin_dormancy" id="useIpin_dormancy" value="N" class="useIpin_use" <?php if($TPL_VAR["useIpin_dormancy"]=='N'||$TPL_VAR["useIpin_dormancy"]==''){?>checked<?php }?> /> 사용 안 함 
								</label>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>