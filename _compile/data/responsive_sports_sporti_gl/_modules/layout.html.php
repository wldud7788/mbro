<?php /* Template_ 2.2.6 2022/09/14 10:57:29 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/_modules/layout.html 000011636 */ 
$TPL_cate_1=empty($TPL_VAR["cate"])||!is_array($TPL_VAR["cate"])?0:count($TPL_VAR["cate"]);
$TPL_brand_1=empty($TPL_VAR["brand"])||!is_array($TPL_VAR["brand"])?0:count($TPL_VAR["brand"]);?>
<!-- ================= #HTML_HEADER :: START. 파일위치 : _modules/common/html_header.html ================= -->
<?php $this->print_("HTML_HEADER",$TPL_SCP,1);?>

<!-- ================= #HTML_HEADER :: END. 파일위치 : _modules/common/html_header.html ================= -->

<!--[ 디자인모드 호출 스크립트]-->
<?php if($TPL_VAR["designMode"]){?>
<script type="text/javascript">
/* 디자인매니저 세팅 */
$(function(){
	if(parent.document==document){
		DM_init('<?php echo $TPL_VAR["template_path"]?>');
	}
});
</script>
<?php }?>

<!--[ 모바일쇼핑몰 디자인모드시 화면 구성 ]-->
<?php if(($TPL_VAR["mobileMode"]||$TPL_VAR["storemobileMode"])&&$TPL_VAR["designMode"]){?>

<?php }?>

<style>
	#layout_body {
<?php if($TPL_VAR["layout_config"]["backgroundColor"]){?>background-color:<?php echo $TPL_VAR["layout_config"]["backgroundColor"]?>;<?php }?>
<?php if($TPL_VAR["layout_config"]["backgroundImage"]){?>background:url('<?php echo $TPL_VAR["layout_config"]["backgroundImage"]?>');<?php }?>
<?php if($TPL_VAR["layout_config"]["backgroundRepeat"]){?>background-repeat:<?php echo $TPL_VAR["layout_config"]["backgroundRepeat"]?>;<?php }?>
<?php if($TPL_VAR["layout_config"]["backgroundPosition"]){?>background-position:<?php echo $TPL_VAR["layout_config"]["backgroundPosition"]?>;<?php }?>
	}
	#layer_pay {position:absolute;top:0px;width:100%;height:100%;background-color:#ffffff;text-align:center;z-index:999999;}
	#payprocessing {text-align:center;position:absolute;width:100%;top:150px;z-index:99999999px;}

	.subpage_sidemenu{display: inline-block; width: 15%; vertical-align: top; padding: 30px 30px 30px 0; box-sizing: border-box;}
	/*#layout_body{max-width: 1260px; padding-left: 20px;}*/
	.layout_body2{max-width: 100% !important;}
	/*.layout_body{max-width: 1260px !important; padding-left: 20px;}*/
	#catalog_page{display: inline-block; width: 84%;}
	.subpage_sidemenu ul li{line-height: 35px; border-bottom: 1px solid #ddd;}
	.subpage_sidemenu ul li a{/*display: block; width: 100%;*/font-weight: 600;}
	.subpage_sidemenu ul li a:hover{opacity: 0.5;}
	.searched_item_display>ul>li{width: 25%;}
	.more_btn1, .more_btn2, .more_btn3, .more_btn4 {position: absolute; right: 0; font-weight: bold; font-size: 18px; cursor: pointer; display: none; width: 50px; text-align: center;}
	.show_active{display: inline-block;}
	.more_btn1:hover, .more_btn2:hover, .more_btn3:hover, .more_btn4:hover {opacity: 0.6;}
	.subpage_subbox {display: none;}
	.subpage_subbox a{font-weight: 500 !important;}
	.fontweight_active{font-weight: bold !important;}

	@media screen and (max-width: 960px) {
		.searched_item_display>ul>li{width: 33%;}
	}

	@media screen and (max-width: 768px) { 
		.subpage_sidemenu{display: none;}
		#catalog_page{width: 100%;}
		.searched_item_display>ul>li{width: 50%;}
	}

</style>

<div id="wrap">
	<!-- ================= 어사이드 :: START. 파일위치 : _modules/common/layout_side.html (비동기 로드) ================= -->
	<div id="layout_side" class="layout_side"></div>
	<!-- ================= 어사이드 :: END. 파일위치 : _modules/common/layout_side.html (비동기 로드) ================= -->
	<a href="javascript:;" id="side_close" class="side_close">어사이드 닫기</a>

	<div id="layout_wrap" class="layout_wrap">
<?php if(!$_GET["popup"]&&!$_GET["iframe"]){?>
<?php if($TPL_VAR["layout_config"]["layoutHeader"]!='hidden'){?>
		<!-- ================= #LAYOUT_HEADER :: START. 파일위치 : layout_header/standard.html (default) ================= -->
<?php $this->print_("LAYOUT_HEADER",$TPL_SCP,1);?>

		<!-- ================= #LAYOUT_HEADER :: END. 파일위치 : layout_header/standard.html (default) ================= -->
<?php }?>
<?php }?>
<?php if($TPL_VAR["cate"]){?>
		<div id="layout_body" class="layout_body2">
			<!-- 위치 : /data/skin/responsive_sports_sporti_gl_1/_modules/layout.html by 김혜진  -->
			<!-- 해당 부분 레이아웃 작업 필요 / 대분류, 중분류 나누려면 작업 필요 -->
				<div class="subpage_sidemenu" style="display:none;">
					<!-- 카테고리 부분 -->
					<ul>
<?php if($TPL_VAR["cate"]){?>

<?php if($TPL_cate_1){foreach($TPL_VAR["cate"] as $TPL_V1){?>
<?php if($TPL_V1["level"]=='2'){?>
									<li style="position: relative;">
										<a href="/goods/catalog?code=<?php echo $TPL_V1["category_code"]?>" class="submenu_title <?php echo $TPL_V1["id"]?>"><?php echo $TPL_V1["title"]?></a>
										<span class="more_btn1 show_active <?php echo $TPL_V1["id"]?>" data-title="<?php echo $TPL_V1["title"]?>" data-id="<?php echo $TPL_V1["id"]?>">+</span>
										<span class="more_btn2 <?php echo $TPL_V1["id"]?>">-</span>
									</li>
								
<?php }else{?>
									<div class="subpage_subbox <?php echo $TPL_V1["parent_id"]?> <?php echo $TPL_V1["title"]?>" data-id="<?php echo $TPL_V1["parent_id"]?>"> <!-- 여기에 케이팝이 들어가야함-->
										<ul>
											<li><a href="/goods/catalog?code=<?php echo $TPL_V1["category_code"]?>">&nbsp;&nbsp;&nbsp;&nbsp;ㄴ&nbsp;<?php echo $TPL_V1["title"]?></a></li>
										</ul>
									</div>

<?php }?>
<?php }}?>
<?php }else{?>
<?php }?>
					</ul>
					<!-- 브랜드 부분 -->
					<ul>
<?php if($TPL_VAR["brand"]){?>
							<li style="position: relative;">
								<a class="submenu_title brand">브랜드</a>
								<span class="more_btn3 show_active brand" data-type="brand">+</span>
								<span class="more_btn4 brand" data-type="brand">-</span>
							</li>
<?php if($TPL_brand_1){foreach($TPL_VAR["brand"] as $TPL_V1){?>
<?php if($TPL_V1["category_code"]==''){?>
<?php }else{?>
								<div class="subpage_subbox brand" data-type="brand">
									<ul>
										<li>
											<a href="/goods/brand?code=<?php echo $TPL_V1["category_code"]?>">&nbsp;&nbsp;&nbsp;&nbsp;ㄴ&nbsp;<?php echo $TPL_V1["title"]?></a>
										</li>
									</ul>
								</div>
<?php }?>
<?php }}?>
<?php }else{?>
<?php }?>
					</ul>
					<script type="text/javascript">
						$(function(){
							// <!-- by 김혜진 -->
							$(".more_btn1").click(function(){
								var title = $(this).data("title");
								var id = $(this).data("id");

								//$(".subpage_subbox").addClass(id);
								$(".subpage_subbox."+id).slideDown();
								$(".more_btn1."+id).removeClass("show_active");
								$(".more_btn2."+id).addClass("show_active");
								$(".submenu_title."+id).addClass("fontweight_active");
							});

							$(".more_btn3").click(function(){
								var type = $(this).data("type");

								$(".subpage_subbox."+type).slideDown();
								$(".more_btn3."+type).removeClass("show_active");
								$(".more_btn4."+type).addClass("show_active");
								$(".submenu_title."+type).addClass("fontweight_active");
							});

							$(".more_btn4").click(function(){
								var type = $(this).data("type");

								$(".subpage_subbox."+type).stop().slideUp();
								$(".more_btn3."+type).addClass("show_active");
								$(".more_btn4."+type).removeClass("show_active");
								$(".submenu_title."+type).removeClass("fontweight_active");

							});


							/*
                            by 황혜찬
                            $(".more_btn1").click(function() {
                                $(".subpage_subbox").slideDown();
                                $(".more_btn1").removeClass("show_active");
                                $(".more_btn2").addClass("show_active");
                                $(".submenu_title").addClass("fontweight_active");
                            });
                            */
							$(".more_btn2").click(function(){
								$(".subpage_subbox").stop().slideUp();
								$(".more_btn1").addClass("show_active");
								$(".more_btn2").removeClass("show_active");
								$(".submenu_title").removeClass("fontweight_active");

							});
						});
					</script>
					<!-- cs 센터 부분 -->
					<ul style="display: none;">
<?php if($TPL_VAR["cata_chk"]){?>
							<li><a href="/board/?id=notice" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL19tb2R1bGVzL2xheW91dC5odG1s"  textindex="16">공지사항</a></li>
							<li><a href="/board/?id=faq" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL19tb2R1bGVzL2xheW91dC5odG1s"  textindex="17">자주묻는질문</a></li>
							<li><a href="/board/?id=goods_qna" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL19tb2R1bGVzL2xheW91dC5odG1s"  textindex="18">상품문의</a></li>
							<li><a href="https://musicbroshop.com/mypage/myqna_catalog" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL19tb2R1bGVzL2xheW91dC5odG1s"  textindex="19" >1:1 문의</a></li>
							<li><a href="/board/?id=goods_review" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL19tb2R1bGVzL2xheW91dC5odG1s"  textindex="20">상품후기</a></li>
							<li><a href="/board/?id=bulkorder" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL19tb2R1bGVzL2xheW91dC5odG1s"  textindex="21"> 대량구매</a></li>
<?php }else{?>
<?php }?>
					</ul>
				</div>
<?php }else{?>
			<div id="layout_body" class="layout_body">
<?php }?>
<?php if(!($TPL_VAR["layout_config"]["layoutMainTopBar"]!='hidden'&&strpos(uri_string(),"main")!==false&&$TPL_VAR["layout_config"]["layoutMainTopBar"]!='')){?>
		<!-- ================= 파트 페이지들 :: START. ================= -->
<?php $this->print_("LAYOUT_BODY",$TPL_SCP,1);?>

		<!-- ================= 파트 페이지들 :: END. ================= -->
<?php }?>
		</div>

<?php if(!$_GET["popup"]&&!$_GET["iframe"]){?>
<?php if($TPL_VAR["layout_config"]["layoutFooter"]!='hidden'){?>
		<!-- ================= #LAYOUT_FOOTER :: START. 파일위치 : layout_footer/standard.html (default) ================= -->
<?php $this->print_("LAYOUT_FOOTER",$TPL_SCP,1);?>

		<!-- ================= #LAYOUT_FOOTER :: END. 파일위치 : layout_footer/standard.html (default) ================= -->
<?php }?>
<?php }?>

<?php if(!$_GET["iframe"]){?>
		<iframe name="actionFrame" id="actionFrame" src="" frameborder="0" width="100%" <?php if($_GET["debug"]== 1){?>height="600"<?php }else{?>height="0"<?php }?>></iframe>
		<div id="openDialogLayer" style="display: none">
			<div align="center" id="openDialogLayerMsg"></div>
		</div>
<?php }?>
		<div id="ajaxLoadingLayer" style="display: none"></div>
	</div>	
</div>
<div id="mobileZipcodeLayer" style="display: none"></div>
<!-- 결제창을 레이어 형태로 구현-->
<div id="layer_pay" class="hide"></div>
<div id="payprocessing" class="pay_layer hide">
	<div style="margin:auto;"><img src="/data/skin/responsive_sports_sporti_gl/images/design/img_paying.gif" /></div>
	<div style="margin:auto;padding-top:20px;"><img src="/data/skin/responsive_sports_sporti_gl/images/design/progress_bar.gif" /></div>
</div>
<div id="layout_side_background" class="layout_side_background"></div>

<!-- ================= #HTML_FOOTER :: START. 파일위치 : _modules/common/html_footer.html ================= -->
<?php $this->print_("HTML_FOOTER",$TPL_SCP,1);?>

<!-- ================= #HTML_FOOTER :: END. 파일위치 : _modules/common/html_footer.html ================= -->