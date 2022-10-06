<?php /* Template_ 2.2.6 2022/05/17 12:36:59 /www/music_brother_firstmall_kr/admin/skin/default/setting/multi.html 000004518 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<form name="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/multi" target="actionFrame">

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>상점 관리</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="sub-layout-container body-height-resizing">

	<!-- 서브메뉴 탭 : 시작 -->
<?php $this->print_("setting_menu",$TPL_SCP,1);?>

	<!-- 서브메뉴 탭 : 끝 -->

	<!-- 서브메뉴 바디 : 시작-->
	<div class='slc-body-wrap'>
		<div class="slc-body">

			<!-- <div class="center top">
				<span>쇼핑몰<?php echo $TPL_VAR["config_system"]["admin_env_seq"]?> <?php echo $TPL_VAR["config_system"]["basic_currency"]?> <?php echo $TPL_VAR["language_codes"][$TPL_VAR["config_system"]["language"]]["name"]?>,<?php echo $TPL_VAR["currency_codes"][$TPL_VAR["config_system"]["basic_currency"]]["hangul"]?></span>
				<span>메뉴얼 ></span>
			</div> -->

			<div class="item-title">상점 설정</div>

			<table class="table_basic">
				
				<colgroup>
					<col width="11%" />					
					<col width="21%" />
					<col width="21%" />
					<col width="9%" />
					<col width="10%" />
					<col width="10%" />
					<col width="10%" />
					<col width="8%" />						
				</colgroup>

				<tr>
					<th>관리명	</th>
					<th>관리 도메인</th>
					<th>정식 도메인</th>
					<th>안내 언어</th>
					<th>기본통화</th>
					<th>설치일</th>
					<th>종료일</th>
					<th>관리</th>
				</tr>
					
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
				<tr>
				
					<!-- 관리명 -->
					<td class="center">
						<?php echo $TPL_V1["admin_env_name"]?>

					</td>

					<!-- 임시 도메인 -->
					<td>
						<dl class="dl_list_01 w60 v2">
							<dt>[PC]</dt>
							<dd><?php echo $TPL_V1["temp_domain"]?></dd>

							<dt>[모바일]</dt>
							<dd>m.<?php echo $TPL_V1["temp_domain"]?></dd>
						</dl>							
					</td>

					<!-- 정식 도메인 -->
					<td>
<?php if($TPL_V1["domain"]){?>
						<dl class="dl_list_01 w60 v2">
							<dt>[PC]</dt>
							<dd><?php echo $TPL_V1["domain"]?></dd>

							<dt>[모바일]</dt>
							<dd>m.<?php echo $TPL_V1["domain"]?></dd>
						</dl>
<?php }?>

<?php if($TPL_V1["favicon"]){?>
						<img src="//<?php echo $TPL_V1["temp_domain"]?><?php echo $TPL_V1["favicon"]?>" border="0" style="max-width:26px;max-height:26px;">
<?php }?>

					</td>

					<!-- 안내 언어 -->
					<td class="center">						
						<?php echo $TPL_VAR["language_codes"][$TPL_V1["language"]]["name"]?>

					</td>

					<!-- 기본통화 -->
					<td class="center">
<?php if($TPL_VAR["currency_codes"][$TPL_V1["currency"]]){?>
						<?php echo $TPL_V1["currency"]?>,<?php echo $TPL_VAR["currency_codes"][$TPL_V1["currency"]]["nation"]?>,<?php echo $TPL_VAR["currency_codes"][$TPL_V1["currency"]]["hangul"]?>

<?php }?>
					</td>

					<!-- 설치 일 -->
					<td class="center">
						<?php echo $TPL_VAR["config_system"]["service"]["setting_date"]?>

					</td>

					<!-- 종료 일 -->
					<td class="center">						
						<?php echo $TPL_VAR["expireDay"]?>

					</td>

					<!-- 관리 -->
					<td class="center">
<?php if($TPL_V1["shopSno"]==$TPL_VAR["config_system"]["shopSno"]){?>
							<button class="btn_resp b_gray2" type="button" onclick="location.href='../setting/multi_basic?no=<?php echo $TPL_V1["admin_env_seq"]?>';">설정</button>
<?php }else{?>
							<button class="btn_resp b_gray2" type="button" onclick="window.open('//<?php echo $TPL_V1["temp_domain"]?>/admin/setting/multi_basic?no=<?php echo $TPL_V1["admin_env_seq"]?>');" class="btn_link">설정</button>
<?php }?>
						</td>
					</tr>
<?php }}?>
				</table>
			</div>
		</div>
	</div>
	<!-- 서브메뉴 바디 : 끝 -->

</div>
<!-- 서브 레이아웃 영역 : 끝 -->

</form>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>