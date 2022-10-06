<?php /* Template_ 2.2.6 2022/09/06 16:41:42 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_2/_modules/category/category_gnb.html 000007168 */ 
$TPL_category_1=empty($TPL_VAR["category"])||!is_array($TPL_VAR["category"])?0:count($TPL_VAR["category"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 카테고리 네비게이션 @@
- 파일위치 : [스킨폴더]/_modules/category/category_gnb.html
- 현재 3뎁스까지 노출 가능
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<style type="text/css">
	.categoryDepth2{position: relative;}
	.brand_depth{float: right; position: relative;}
	.brand_menu1, .brand_menu2{cursor: pointer; text-align: right; background-color: white; border-radius: 3px; padding: 5px 10px !important;  box-sizing: border-box; min-width: auto !important; min-height: auto !important; float: right;}
	.brand_menu1:hover, .brand_menu2:hover {opacity: 0.83; transition: all 0.2s;}
	.brand_menu1>span, .brand_menu2>span {color: black !important;}
	.brand_submenu{ background-color: rgba(0,0,0,0.7); color: white; padding: 15px !important; margin-top: 20px; width: 100%; box-sizing: border-box;}
	.brand_content{color: white; margin: 7px 20px 10px 0; cursor: pointer; display: inline-block;}
	.brand_content:hover {opacity: 0.6; transition: all 0.2s;}
	.layout_header .nav_wrap .categorySubWrap .categoryDepth2:last-child{right: 0;}
	.brand_show {right: 10px !important;}
	.brand_subtitle{display: inline-block; margin-right: 10px; color: #AFAFAF !important;}

</style>

<?php if($TPL_category_1){foreach($TPL_VAR["category"] as $TPL_V1){?>
	<li class="categoryDepth1">
		<a class="categoryDepthLink designElement" designelement="category" href="/goods/catalog?code=<?php echo $TPL_V1["category_code"]?>" hrefOri='L2dvb2RzL2NhdGFsb2c/Y29kZT17LmNhdGVnb3J5X2NvZGV9' ><em><?php echo $TPL_V1["name"]?></em></a>
<?php if($TPL_V1["name"]=='FASHION'){?>
<?php if($TPL_V1["childs"]){?>
		<div class="categorySub">
			<div class="categorySubWrap">
				<ul class="categoryDepth2">
		
					<li class="categorySubDepth brand_depth">
						<ul class="categoryDepth2 brand_show">
							<li class="brand_menu1" style="display: none;"><span>브랜드 보기</span></li>
							<li class="brand_menu2"><span>브랜드 접기</span></li>
						</ul>
					</li>
					<!-- 2022.07.19 GRAMINUS 추가 = 황혜찬 -->
					<li class="brand_submenu">
						<h4 class="brand_subtitle">B.</h4>
						<span class="brand_content" onclick="window.location='https://musicbroshop.com/goods/brand?page=1&searchMode=brand&brand%5B0%5D=b0147&per=40&sorting=regist&filter_display=lattice'">BASIC LABEL</span><br>
						<h4 class="brand_subtitle">D.</h4>
						<span class="brand_content" onclick="window.location='https://musicbroshop.com/goods/brand?page=1&searchMode=brand&brand%5B0%5D=b0144&per=40&sorting=regist&filter_display=lattice'">DUST GRAY</span><br>
						<h4 class="brand_subtitle">G.</h4>
						<span class="brand_content" onclick="window.location='https://musicbroshop.com/goods/brand?page=1&searchMode=brand&brand%5B0%5D=b0148&per=40&sorting=regist&filter_display=lattice'">GRAMINUS </span><br>
						<h4 class="brand_subtitle">M.</h4>
						<span class="brand_content" onclick="window.location='https://www.musicbroshop.com/goods/brand?page=1&searchMode=brand&brand%5B0%5D=b0146&per=40&sorting=regist&filter_display=lattice'">macular</span><br>
						<h4 class="brand_subtitle">ㄷ.</h4>
						<span class="brand_content" onclick="window.location='https://musicbroshop.com/goods/brand?page=1&searchMode=brand&brand%5B0%5D=b0145&per=40&sorting=regist&filter_display=lattice'">도그매틱</span><br>
						<h4 class="brand_subtitle">ㅁ.</h4>
						<span class="brand_content" onclick="window.location='https://musicbroshop.com/goods/brand?page=1&searchMode=brand&brand%5B0%5D=b0143&per=40&sorting=regist&filter_display=lattice'">매드마르스</span><br>
						<!-- <span class="brand_content" onclick="window.location='https://musicbroshop.com'">모디패스트</span><br> -->
						<!-- <h4 class="brand_subtitle">ㅇ.</h4>
						<span class="brand_content" onclick="window.location='https://musicbroshop.com/goods/brand?page=1&searchMode=brand&brand%5B0%5D=b0068&per=40&sorting=regist&filter_display=lattice'">아티스트웨어</span><br> -->
						<!-- <h4 class="brand_subtitle">ㅋ.</h4>
						<span class="brand_content" onclick="window.location='https://musicbroshop.com/goods/brand?page=1&searchMode=brand&brand%5B0%5D=b0067&per=40&sorting=regist&filter_display=lattice'">크럼프</span><br> -->
						<h4 class="brand_subtitle">ㅌ.</h4>
						<span class="brand_content" onclick="window.location='https://musicbroshop.com/goods/brand?page=1&searchMode=brand&brand%5B0%5D=b0069&per=40&sorting=regist&filter_display=lattice'">트립션</span><br>
						<h4 class="brand_subtitle">ㅎ.</h4>
						<span class="brand_content" onclick="window.location='https://musicbroshop.com/goods/brand?page=1&searchMode=brand&brand%5B0%5D=b0071&per=40&sorting=regist&filter_display=lattice'">하드코어해피니즈</span>
						<span class="brand_content" onclick="window.location='https://musicbroshop.com/goods/brand?page=1&searchMode=brand&brand%5B0%5D=b0070&per=40&sorting=regist&filter_display=lattice'">하이스쿨디스코</span>
					</li>
					<script type="text/javascript">
						$(function(){
							if($('.categorySub').is(":visible")){
							     // display : none가 아닐 경우
							     $(".brand_submenu").show();
							}else{
							     // display : none일 경우
							     $(".brand_submenu").show();
							}
							$(".brand_menu1").click(function(){
								$(".brand_submenu").show();
								$(".brand_menu1").hide();
								$(".brand_menu2").show();
							});
							$(".brand_menu2").click(function(){
								$(".brand_submenu").hide();
								$(".brand_menu1").show();
								$(".brand_menu2").hide();
							});
						});
					</script>
				</ul>
<?php if($TPL_V1["node_banner"]){?>
				<div class="categorySubBanner">
					<?php echo $TPL_V1["node_banner"]?>

				</div>
<?php }?>
			</div>
		</div>
<?php }?>
<?php }else{?>
<?php if($TPL_V1["childs"]){?>
		<div class="categorySub">
			<div class="categorySubWrap">
				<ul class="categoryDepth2">
<?php if(is_array($TPL_R2=$TPL_V1["childs"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<li class="categorySubDepth">
<?php if($TPL_V2["childs"]){?>
						<ul class="categoryDepth3">
<?php if(is_array($TPL_R3=$TPL_V2["childs"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
							<li><a href="/goods/catalog?code=<?php echo $TPL_V3["category_code"]?>" hrefOri='L2dvb2RzL2NhdGFsb2c/Y29kZT17Li4uY2F0ZWdvcnlfY29kZX0=' ><?php echo $TPL_V3["name"]?></a></li>
							
<?php }}?>
						</ul>
<?php }?>
						<a href="/goods/catalog?code=<?php echo $TPL_V2["category_code"]?>" hrefOri='L2dvb2RzL2NhdGFsb2c/Y29kZT17Li5jYXRlZ29yeV9jb2RlfQ==' ><?php echo $TPL_V2["name"]?></a>
					</li>

<?php }}?>

				</ul>
<?php if($TPL_V1["node_banner"]){?>
				<div class="categorySubBanner">
					<?php echo $TPL_V1["node_banner"]?>

				</div>
<?php }?>
			</div>
		</div>
<?php }?>		
<?php }?>
		
		
	</li>

<?php }}?>