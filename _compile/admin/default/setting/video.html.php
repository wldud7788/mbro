<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/setting/video.html 000006684 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<style type="text/css">
	.cont { padding: 10px; margin-bottom: 10px }
	.cont th { background: #eaeaea }
	.cont .tb-wrap { margin: 15px 0px; height: 90px; }
	.cont .tb-wrap .tb-small- { width: 50%; min-height: 100%; border-collapse: collapse;  }
	.cont .tb-wrap .tb-small- th,
	.cont .tb-wrap .tb-small- td { border: 1px solid #dadada; color: #d0d0d0; text-align: center; word-break: break-all;}
	.cont .tb-wrap .tb-small-Y { width: 50%; min-height: 100%; border-collapse: collapse;  }
	.cont .tb-wrap .tb-small-Y th,
	.cont .tb-wrap .tb-small-Y td { border: 1px solid #dadada; text-align: center; word-break: break-all;}
	.cont .tb-wrap .tb-small-N { width: 50%; min-height: 100%; border-collapse: collapse;  }
	.cont .tb-wrap .tb-small-N th,
	.cont .tb-wrap .tb-small-N td { border: 1px solid #dadada; color: #d0d0d0; text-align: center; word-break: break-all;}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$('#service_chk').click(function(){
			if($(this).attr('checked')){
				$('#use_service').val('N');
			}else{
				$('#use_service').val('Y');
			}		
		});		
	});
</script>

<form name="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/video" target="actionFrame">
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
			<h2>동영상</h2>
		</div>

		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<button class="resp_btn active2 size_L" type="submit">저장</button>
		</div>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="contents_container">

	<!-- 서브메뉴 바디 : 시작-->
	<div class="contents_dvs">
		<div class="title_dvs">
			<div class="item-title">
				리얼 패킹 – 포장 촬영
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/video', '#tip1', 'sizeM')"></span>
			</div>
			<button type="button" class="resp_btn" onclick="window.open('https://firstmall.kr/ec_hosting/addservice/realpacking.php', 'flvhosting');" >리얼 패킹 안내</button>
		</div>

		<table class="table_basic thl">
			<tr>
				<th>서비스 신청</th>
				<td>
<?php if($TPL_VAR["functionLimit"]){?>
					<button type="button" onclick="servicedemoalert('use_f');" class="resp_btn">신청</button>
<?php }else{?>
					<button type="button" onclick="window.open('../realpacking/service_regist','_REALPACKING');" class="resp_btn">신청</button>
<?php }?>
				</td>
			</tr>
<?php if($TPL_VAR["real_config"]["use_service"]){?>
			<tr>
				<th>사용여부</th>
				<td>
				<?php var_dump( $TPL_VAR["real_config"]) ?>
					<input type="hidden" name="use_service" id="use_service" value="<?php echo $TPL_VAR["real_config"]["use_service"]?>"/>
					<label class="mr15">
						<input type="radio"  id="service_chk" value="Y" <?php if($TPL_VAR["real_config"]["use_service"]){?>checked="checked"<?php }?> <?php if(!$TPL_VAR["real_config"]["use_service"]){?>disabled="disabled"<?php }?>/> 사용함
					</label>
					<label>
						<input type="radio" id="service_chk" value="N" <?php if(!$TPL_VAR["real_config"]["use_service"]){?>disabled="disabled"<?php }?>/> 사용 안 함
					</label>
				</td>
			</tr>

			<tr>
				<th>설정 정보</th>
				<td class="clear">						
					<table class="tb-small-<?php echo $TPL_VAR["real_config"]["use_service"]?> table_basic thl v3">							
						<tr> 
							<th>client_id</th>
							<td><?php echo $TPL_VAR["real_config"]["service_info"]["client_id"]?></td>
						</tr>
						<tr>
							<th>client_secret</th>
							<td>*************</td>
						</tr>
					</table>						
				</td>
			</tr>
<?php }?>
		</table>	
		<ul class="bullet_hyphen resp_message">
			<li>설정 정보는 서비스 신청을 완료하면 자동으로 입력됩니다.</li>
		</ul>
	</div>

	<div class="contents_dvs">
		<div class="title_dvs">
			<div class="item-title">
				동영상	
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/video', '#tip2')"></span>
			</div>
			<button type="button" class="resp_btn" onclick="window.open('https://media.gabia.com/service', 'flvhosting');" >동영상 신청 및 안내</button>
		</div>

		<table class="table_basic thl">
			<tr>
				<th>서비스 관리</th>
				<td>						
					<button type="button" class="resp_btn" onclick="window.open('https://admin.smartucc.kr/', 'admin');" >관리</button>
				</td>
			</tr>

			<tr>
				<th>설정 정보</th>
				<td class="clear">
					<table class="table_basic v3 thl">
						<tr>
							<th>
								UCC 아이디
								<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/video', '#tip3')"></span>
							</th>
							<td>
								<input type="text" name="ucc_id"  id="ucc_id"  size="72"  value="<?php echo $TPL_VAR["cfg_goods"]["ucc_id"]?>" class="line"   <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?> />
							</td>
						</tr>

						<tr>
							<th>
								UCC 도메인
								<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/video', '#tip4')"></span>
							</th>
							<td>
								<input type="text" name="ucc_domain"  id="ucc_domain" size="72"  value="<?php echo str_replace('web.mvod.','',$TPL_VAR["cfg_goods"]["ucc_domain"])?>" class="line"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?> />
							</td>
						</tr>

						<tr>
							<th>UCC 인증키	</th>
							<td>
								<input type="text" name="ucc_key"  id="ucc_key"  size="72"  value="<?php echo $TPL_VAR["cfg_goods"]["ucc_key"]?>" class="line"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>/>
								<ul class="bullet_hyphen resp_message v2">
									<li>동영상 관리 페이지 지원센터 > <a href="https://admin.smartucc.kr/" class="link_blue_01" target="_black">연동 환경 설정</a> 페이지에서 인증키를 확인 후 입력하세요.</li>
								</ul>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!-- 서브메뉴 바디 : 끝 -->
</div>
<!-- 서브 레이아웃 영역 : 끝 -->
</form>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>