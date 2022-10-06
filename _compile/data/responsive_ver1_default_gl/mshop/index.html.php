<?php /* Template_ 2.2.6 2021/12/15 17:48:38 /www/music_brother_firstmall_kr/data/skin/responsive_ver1_default_gl/mshop/index.html 000004814 */  $this->include_("showMyMinishopLight","snslinkurl","showGoodsSearchFormLight");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "판매자 미니샵" 페이지 @@
- 파일위치 : [스킨폴더]/mshop/index.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script type="text/javascript">
var gl_skin = '<?php echo $TPL_VAR["skin"]?>';
</script>
<script type="text/javascript" src='/data/skin/responsive_ver1_default_gl/common/minishop.js'></script>

<div id="itemstmplayer" class="hide"></div>

<div id="mshop_page">
	<div class="search_nav">
		<a class="home" href="/main/index">홈</a>
		<span class="navi_linemap">
			<span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbXNob3AvaW5kZXguaHRtbA==" >미니샵</span>&nbsp;
			<select name="navi_{.index_}" onchange="location.href='/mshop/?m='+this.value;">
<?php if(is_array($TPL_R1=showMyMinishopLight())&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["aProvider"]["provider_seq"]==$TPL_V1["provider_seq"]){?>
				<option value="<?php echo $TPL_V1["provider_seq"]?>" selected><?php echo $TPL_V1["provider_name"]?></option>
<?php }else{?>
				<option value="<?php echo $TPL_V1["provider_seq"]?>"><?php echo $TPL_V1["provider_name"]?></option>
<?php }?>
<?php }}?>
			</select>
		</span>
	</div>

	<!-- 타이틀 -->
	<div id="mshoptitle" class="resp_mshop_top">
		<ul class="resp_mshop_section">
			<li class="name">
<?php if($TPL_VAR["aProvider"]["info_name"]){?>
				<h3 class="title"><a href="?m=<?php echo $TPL_VAR["aProvider"]["provider_seq"]?>" ><?php echo $TPL_VAR["aProvider"]["info_name"]?></a></h3>
<?php }else{?>
				<h3 class="title"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbXNob3AvaW5kZXguaHRtbA==" >MINISHOP</span></h3>
<?php }?>
				<div class="info">
					<span class="point"><?php echo $TPL_VAR["aProvider"]["provider_name"]?></span> &nbsp; <span class="gray_07">|</span> &nbsp;
					<span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbXNob3AvaW5kZXguaHRtbA==" >단골</span> <span class="point"><?php echo $TPL_VAR["aProvider"]["cnt"]?></span>
				</div>
<?php if($TPL_VAR["aProvider"]["minishop_introdution"]){?>
				<div class="descr"><?php echo $TPL_VAR["aProvider"]["minishop_introdution"]?></div>
<?php }?>
			</li>
			<li class="sns">
				<button class="reg_minishop <?php if($TPL_VAR["aProvider"]["thisshop"]=='y'){?>on<?php }?>" data-shop='<?php echo $TPL_VAR["aProvider"]["provider_seq"]?>' onclick="mshopadd(this, '<?php echo $TPL_VAR["member_seq"]?>');"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbXNob3AvaW5kZXguaHRtbA==" >찜</span></button>
				<a href="javascript:void(0)" class="btn_sns_share" onclick="snsLink();"><span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV92ZXIxX2RlZmF1bHRfZ2wvbXNob3AvaW5kZXguaHRtbA==" >공유</span></a>
				<div class="snsbox_area" style="display:none;">
					<?php echo snslinkurl('event',$TPL_VAR["providerinfo"]["provider_name"])?>

				</div>
			</li>
		</ul>
	</div>

	<!-- 즐겨찾기 레이어 -->
	<div id="myshop_favorite_alert" class="myshop_favorite_alert">
		<div class="cfa_on"></div>
		<div class="cfa_off"></div>
		<div class="cfa_msg"></div>
	</div>

	<!-- ------- 추천상품( 추천상품 디스플레이 편집 : EYE-design을 켜고 클릭하여 수정 ) ------- -->
	<!-- 상품디스플레이 파일들 폴더 위치 : /data/design/ ( ※ /data 폴더는 /skin 폴더 상위 폴더입니다. ) -->
	<?php echo $TPL_VAR["providerRecommendGoodsList"]?>

	<!-- ------- //추천상품 ------- -->

	<!-- ------- 검색필터, 상품정렬( 파일위치 : [스킨폴더]/goods/_search_form_light.html ) ------- -->
	<?php echo showGoodsSearchFormLight()?>

	<!-- ------- //검색필터, 상품정렬 ------- -->

	<!-- ------- 상품 영역( data-displaytype : "lattice", "list" ), 파일위치 : [스킨폴더]/goods/search_list_template.html ------- -->
	<div id="searchedItemDisplay" class="searched_item_display" data-displaytype="lattice"></div>
	<!-- ------- //상품 영역 ------- -->
</div>

<div id="wish_alert">
	<div class="wa_on"></div>
	<div class="wa_off"></div>
	<div class="wa_msg"></div>
</div>

<script type="text/javascript">
$(function() {
	// 검색 페이지 -> 디폴트 검색박스 open
	$('#searchModule #searchVer2').show();

	// 컬러 필터 - 255, 255, 255 --> border
	colorFilter_white( '#searchFilterSelected .color_type' );
});
</script>