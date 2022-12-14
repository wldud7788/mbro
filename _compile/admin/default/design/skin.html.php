<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/design/skin.html 000014303 */  $this->include_("getGabiaSkinPannel");?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/admin-skinsetting.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript">
	var skinPrefix = "<?php echo $TPL_VAR["skinPrefix"]?>";
	var glSkinType	= "<?php echo $TPL_VAR["skinType"]?>";
</script>
<script type="text/javascript" src="/app/javascript/js/admin-designSkin.js?mm=<?php echo date('Ymd')?>"></script>
<style type="text/css">
	.skin_type_wrap { overflow:hidden; zoom:1; margin: 20px 0; }
	.skin_type_wrap .box-skin-type { float:left; width:100%; /*width:calc( 100% - 75px );*/  border-radius:5px}
	.skin_type_wrap .btns { float:right; }
	.skin_type_wrap .btnSkinTypeChk { box-sizing:border-box; height:44px; width:70px; text-align:center; border:none; background-color:#434343; font:14px/38px 'Malgun Gothic'; color:#fff; border-radius:2px; cursor:default; }
	.skin_type_wrap .btnSkinTypeChk:hover, .skin_type_wrap .btnSkinTypeChk:focus { background-color:#000; }
	.sst-skin-list-container {}
	.sst-skin-list-container .skin_name {font-size:13px; color:#444; margin-bottom:15px;}
	.box-skin-type { display:table; width:100%; table-layout:fixed; font-size:14px; font-family:'Malgun Gothic'; border-bottom:0; box-sizing: border-box;}
	.box-skin-type>li { display:table-cell; vertical-align:middle; text-align:center; }
	.box-skin-type>li>label { display:block; box-sizing:border-box; height:44px; line-height:40px; border-right:none; border:1px solid #d8d7dc; background:#FFF; overflow:hidden; cursor:pointer; transition:all 0.2s; color:#767676;  }
	.box-skin-type>li>label:hover { background-color:#FFF; color:#000; }
	.box-skin-type>li>label:before { display:inline-block; content:''; width:40px; height:40px; vertical-align:top; }
	.box-skin-type>li>label.on { background-color:#559ffe; color:#fff; cursor:default; border:1px solid #559ffe;}	
	.box-skin-type>li>label>input[type='radio'] { width:0px; height:0px; visibility:hidden; position:absolute; left:0; top:0;  }
	.skin_img_wrap{position:relative;}
	.skin_img_wrap img {border:1px solid #d5d5d5; margin:10px 0;}
	.is_use_icon{position:absolute; top:0; left:0;}	
	.use {border:1px solid #4395ff; display:inline-block; padding:1px 7px; font-size:11px; background:#4395ff; color:#FFF; border-radius:2px; letter-spacing:-1.5px;}
	.design{border:1px solid #4196ff; color:#4196ff; background:#e1ecfe; display:inline-block; padding:1px 7px; font-size:11px; border-radius:2px; letter-spacing:-1.5px;}
	.folder_name{font-size:12px; font-weight:400; margin-top:3px;}
	.section_dvs.cols.ea2 > li .title {cursor:default;}
	.stit .mess {font-size:11px; color:gray; font-weight:400;}
	.skinListTab {border-bottom:0;}
	.skinListTab li a {line-height: 40px; height: 40px; padding: 0 30px;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>스킨 설정</h2>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="skin_setting">

	<!-- 임시 스킨 타입 변경 박스 -->
	<div class="skin_type_wrap">
		<ul class="box-skin-type">
			<li>
				<label <?php if($TPL_VAR["skinType"]=='responsive'){?>class="on"<?php }?>><input type="radio" name="skin_type" value="responsive" <?php if($TPL_VAR["skinType"]=='responsive'){?>checked="checked"<?php }?> /> 1개의 반응형 스킨</label>
			</li>
			<li>
				<label <?php if($TPL_VAR["skinType"]=='fixed'){?>class="on"<?php }?>><input type="radio" name="skin_type" value="fixed" <?php if($TPL_VAR["skinType"]=='fixed'){?>checked="checked"<?php }?> /> 2개의 전용 스킨</label>
			</li>
		</ul>
		<!--div class="btns">
			<input type="button" class="btnSkinTypeChk" value="변경" />
		</div-->
	</div>

<?php if($TPL_VAR["skinType"]=='responsive'){?>
<?php }elseif($TPL_VAR["skinType"]=='responsive2'){?>
	<ul class="skinListTab">
		<li class="active half" skinPrefix=''><a href="skin">[반응형] 데스크탑 단말기 접속 시</a></li>
		<li class="half" skinPrefix='mobile'><a href="skin?prefix=mobile">[반응형] 폴더블폰, 태블릿, 스마트폰 등 모든 모바일 단말기 접속 시</a></li>
	</ul>
<?php }elseif($TPL_VAR["skinType"]=='fixed'){?>
	<ul class="skinListTab tab_01">
		<li class="active" skinPrefix=''><a href="skin">PC 도메인 접속</a></li>
		<li skinPrefix='mobile'><a href="skin?prefix=mobile">모바일 도메인 접속</a></li>
<?php if(serviceLimit('H_NFR')){?>
		<li skinPrefix='fammerce'><a href="skin?prefix=fammerce">페이스북 접속</a></li>
<?php }else{?>
		<li skinPrefix='fammerce'><a href="javascript:void(0);" id="freefacebookconfignone">페이스북 접속</a></li>
<?php }?>
	</ul>
<?php }?>

	<ul id="skin-setting" class="sst-skin-wrap" <?php if($TPL_VAR["skinType"]=='fixed'){?>style="margin-top:-1px;"<?php }?>>
		<li>
			<div id="realSkinPanel" class="apply-skin-list">
				<ul class="clearbox">
					<li class="img sst-body">
						<div class="sst-apply-skin-box">
<?php if($TPL_VAR["skinPrefix"]=='mobile'){?>
							<div class="sst-apply-skin-screenshot"><img src="/data/skin/<?php echo $TPL_VAR["realMobileSkin"]?>/configuration/<?php echo $TPL_VAR["realSkinConfiguration"]["screenshot"]?>" alt="<?php echo $TPL_VAR["realSkinConfiguration"]["name"]?>" class="resp" /></div>
<?php }elseif($TPL_VAR["skinPrefix"]=='fammerce'){?>
							<div class="sst-apply-skin-screenshot"><img src="/data/skin/<?php echo $TPL_VAR["realFammerceSkin"]?>/configuration/<?php echo $TPL_VAR["realSkinConfiguration"]["screenshot"]?>" alt="<?php echo $TPL_VAR["realSkinConfiguration"]["name"]?>" /></div>
<?php }else{?>
							<div class="sst-apply-skin-screenshot"><img src="/data/skin/<?php echo $TPL_VAR["realSkin"]?>/configuration/<?php echo $TPL_VAR["realSkinConfiguration"]["screenshot"]?>" alt="<?php echo $TPL_VAR["realSkinConfiguration"]["name"]?>" /></div>
<?php }?>
						</div>					
					</li>
					<li class="txt">
						<div class="stit">
							사용 스킨 <span class="mess">(현재 쇼핑몰에서 사용 중)</span>
							<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/design', '#tip1')"></span>
						</div>
						<div class="tit">
							<div class="sst-apply-skin-name"><?php echo $TPL_VAR["realSkinConfiguration"]["name"]?></div>
							<div class="folder_name">폴더명 : <span class="sst-apply-skin-dir"><?php echo $TPL_VAR["realSkinConfiguration"]["skin"]?></span></div>
						</div>										

						<a href="/?previewSkin=<?php echo $TPL_VAR["realSkinConfiguration"]["skin"]?>&setMode=<?php if($TPL_VAR["skinPrefix"]=='mobile'){?>mobile<?php }elseif($TPL_VAR["skinPrefix"]=='fammerce'){?>fammerce<?php }else{?>pc<?php }?>" target="_blank" class="resp_btn v3 mt15 wx150 size_XL">바로가기</a>
					</li>
				</ul>
			</div>
			<!-- //실제적용 스킨 -->
		</li>
		<li>
			<div id="workingSkinPanel" class="apply-skin-list">
				<ul class="clearbox">
					<li class="img sst-body">
						<div class="sst-apply-skin-box">
<?php if($TPL_VAR["skinPrefix"]=='mobile'){?>
							<div class="sst-apply-skin-screenshot"><img src="/data/skin/<?php echo $TPL_VAR["workingMobileSkin"]?>/configuration/<?php echo $TPL_VAR["workingSkinConfiguration"]["screenshot"]?>" alt="<?php echo $TPL_VAR["workingSkinConfiguration"]["name"]?>" /></div>
<?php }elseif($TPL_VAR["skinPrefix"]=='fammerce'){?>
							<div class="sst-apply-skin-screenshot"><img src="/data/skin/<?php echo $TPL_VAR["workingFammerceSkin"]?>/configuration/<?php echo $TPL_VAR["workingSkinConfiguration"]["screenshot"]?>" alt="<?php echo $TPL_VAR["workingSkinConfiguration"]["name"]?>" /></div>
<?php }else{?>
							<div class="sst-apply-skin-screenshot"><img src="/data/skin/<?php echo $TPL_VAR["workingSkin"]?>/configuration/<?php echo $TPL_VAR["workingSkinConfiguration"]["screenshot"]?>" alt="<?php echo $TPL_VAR["workingSkinConfiguration"]["name"]?>" /></div>
<?php }?>
						</div>
					</li>
					<li class="txt">
						<div class="stit">
							디자인 스킨 <span class="mess">(디자인 환경에서 사용 중)</span>
							<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/design', '#tip2')"></span>
						</div>
						<div class="tit">
							<div class="sst-apply-skin-name"><?php echo $TPL_VAR["workingSkinConfiguration"]["name"]?></div>
							<div class="folder_name">폴더명 : <span class="sst-apply-skin-dir"><?php echo $TPL_VAR["workingSkinConfiguration"]["skin"]?></span></div>
						</div>										

						<a href="main?setMode=<?php if($TPL_VAR["skinPrefix"]=='mobile'){?>mobile<?php }elseif($TPL_VAR["skinPrefix"]=='fammerce'){?>fammerce<?php }else{?>pc<?php }?>"  target="_blank"  class="resp_btn v3 mt15 wx150 size_XL">디자인 수정</a>
					</li>
				</ul>
			</div>
			<!-- //디자인작업용 스킨 -->
		</li>
	</ul>
	<!-- //실제적용/작업용 스킨 -->	

	<div class="sst-skin-list-container"></div>
	<!-- //보유스킨 설정 -->

	<ul class="sst-skin-wrap mt30">
		<?php echo getGabiaSkinPannel()?>

	</ul>
	<!-- // 하단 배너 -->
</div>


<!-- 스킨업로드 레이어 -->
<div id="skinUploadDialogLayer" class="hide">
	<form action="../design_process/upload_skin" target="actionFrame" enctype="multipart/form-data" method="post" onsubmit="return upload_skin_submit(this)">
		<table class="table_basic">
			<colgroup>
				<col width="30%" />
				<col />
			</colgroup>
			<tr>
				<th>파일 첨부</th>
				<td>
					<label class="resp_btn v2"><input type="file" name="skin_zipfile"  id="skinZipfileBtn"/>파일 선택</label>
					<span id="fileName" class="ml5"></span>
				</td>
			</tr>
		</table>	

		<div class="footer">
			<input type="submit" value="업로드" class="resp_btn active size_XL" />
			<input onclick="closeDialog('skinUploadDialogLayer');" type="button" value="취소" class="resp_btn v3 size_XL" />
		</div>
	</form>
</div>



<!-- 스킨 리네임 레이어 -->
<div id="skinRenameDialogLayer" class="hide">
	<form action="../design_process/rename_skin" target="actionFrame" enctype="multipart/form-data" method="post" onsubmit="return rename_skin_submit(this)">
		<input type="hidden" name="skin" value="" />
		<input type="hidden" name="skinPrefix" value="<?php echo $TPL_VAR["skinPrefix"]?>" />

		<table class="table_basic thl">			
			<tr>
				<th>스킨명</th>
				<td>
					<input type="text" name="skinName" value="" size="60" maxlength="50" /> 
					<div class="resp_message v2">- 영문 소문자, 한글, 숫자, 언더바만 입력 가능</div>
				</td>
			</tr>
			<tr>
				<th>폴더명(스킨코드)</th>
				<td>
					<input type="text" name="skinFolder" value="" size="60" maxlength="45" /> 
					<div class="resp_message v2">- 영문 소문자, 숫자, 언더바만 입력 가능</div>
				</td>
			</tr>

			<tr>
				<th>스킨 언어</th>
				<td><div class="language"></div></td>
			</tr>

			<tr>
				<th>스킨 환경</th>
				<td><div class="skin_type"></div></td>
			</tr>

			<tr>
				<th>스킨 버전</th>
				<td><div class="patch_version"></div></td>
			</tr>

			<tr>
				<th>등록 일시</th>
				<td><div class="regdate"></div></td>
			</tr>			
		</table>

		<div class="footer">
			<input type="submit" value="저장" class="resp_btn active size_XL"/>
			<input onclick="closeDialog('skinRenameDialogLayer');" type="button" value="취소" class="resp_btn v3 size_XL"/>
		</div>
	</form>
</div>

<!-- 스킨타입 변경레이어 -->
<div id="skinTypeChangeDialogLayer" class="hide">
	<form action="../design_process/set_default_skintype" target="actionFrame" method="post">
		<div class="content_wrap">
			<input type="hidden" id="next_skin_type" name="skin_type" value="" />
			<div>
				<b class="fx14"><span class="skinType">전용 스킨</span>으로 변경하겠습니까?</b>
				<div class="gray">스킨 사용 방식 변경 시 재설정이 필요한 항목 안내 <a href="https://www.firstmall.kr/customer/faq/1334" class="resp_btn_txt" target="_blank">자세히 보기</a></div>
			</div>
			
			<ul class="section_dvs cols ea2 mt20 skinTypeEvent">
				<li skinType="responsive">
					<div class="contents">					
						<img src="/admin/skin/default/images/design/responsive_skin.jpg">					
					</div>
					<div class="title">반응형 스킨</div>
					<div class="gray">(1개의 스킨으로 운영합니다.)</div>
				</li>
				<li skinType="fixed">
					<div class="contents">					
						<img src="/admin/skin/default/images/design/pc_skin.jpg" >
						<img src="/admin/skin/default/images/design/mobile_skin.jpg" class="ml3 wx70">						
					</div>
					<div class="title">전용 스킨</div>
					<div class="gray">(PC/모바일 별도 스킨으로 운영합니다.)</div>
				</li>
			</ul>
		</div>
		<div class="footer">
			<input type="submit" value="저장" class="resp_btn active size_XL" />
			<input onclick="closeDialog('skinTypeChangeDialogLayer');" type="button" value="취소" class="resp_btn v3 size_XL cancelBtn" />
		</div>
	</form>
</div>

<div id="noskinDialogLayer" class="hide">	
	<div class="content_wrap">
		현재 추가된 <span class="skinType">전용 스킨</span>이 없습니다.<br>
		디자인 > 스킨 추가에서 <span class="skinType">전용 스킨</span>을 먼저 추가해 주세요.
	</div>

	<div class="footer">
		<a href="/admin/design/skin_add" class="resp_btn active size_XL" />스킨 추가</a>
		<input type="button" onclick="closeDialog('noskinDialogLayer');"  value="취소" class="resp_btn v3 size_XL cancelBtn" />
	</div>	
</div>

<!-- 스킨관련 공지 팝업 :: 2016-01-27 lwh -->
<div class="ui-widget-overlay adDialogLayer hide" style="width:100%; height:100%; z-index:10001;"></div>
<div id="adDialogLayer" class="gabia-pannel adDialogLayer hide" code="solution_skin_page_popupAD"  style="position:absolute; left:50%; top:50%; width:100px;height:100px; z-index:10002;"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>