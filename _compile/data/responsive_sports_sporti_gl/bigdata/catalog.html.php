<?php /* Template_ 2.2.6 2021/12/15 16:50:22 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/bigdata/catalog.html 000010867 */  $this->include_("snslinkurl");
$TPL_icons_1=empty($TPL_VAR["icons"])||!is_array($TPL_VAR["icons"])?0:count($TPL_VAR["icons"]);
$TPL_images_1=empty($TPL_VAR["images"])||!is_array($TPL_VAR["images"])?0:count($TPL_VAR["images"]);
$TPL_kinds_1=empty($TPL_VAR["kinds"])||!is_array($TPL_VAR["kinds"])?0:count($TPL_VAR["kinds"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "빅데이터 상품추천" 페이지 @@
- 파일위치 : [스킨폴더]/bigdata/catalog.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_VAR["cfg_bigdata"]["banner"]){?>
<div class="visual_title">
	<div class="img_area">
		<img src="/data/bigdata/<?php echo $TPL_VAR["cfg_bigdata"]["banner"]?>"/>
	</div>
	<!--div class="visual_gon">
		<ul class="title_inner_a">
			<li>
				<h2><span designElement="text">BIGDATA</span></h2>
				<p class="descr2" designElement="text">빅데이터를 통한 상품추천 서비스</p>
			</li>
		</ul>
	</div-->
</div>
<?php }?>


<div class="bigdata_area">

	<div class="detail_title_area v2">
		<h3 class="name"><?php echo $TPL_VAR["goodsinfo"]["goods_name"]?></h3>
		<p class="summary">
			<?php echo $TPL_VAR["goodsinfo"]["summary"]?>

			<span class="detail_icons">
<?php if($TPL_icons_1){foreach($TPL_VAR["icons"] as $TPL_V1){?>
					<img src="/data/icon/goods/<?php echo $TPL_V1["codecd"]?>.gif" alt="" />
<?php }}?>
			</span>
		</p>
	</div>

<?php if($TPL_VAR["eventEnd"]){?>
	<div class="event_datetime" style="background:<?php echo $TPL_VAR["goodsinfo"]["event"]["bgcolor"]?>;">
		<ul class="event_wrap">
			<li class="event_tit">
				<span class="title"><?php echo $TPL_VAR["goodsinfo"]["event"]["title_contents"]?></span>
			</li>
			<li class="remain_time">
				<span class="title" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JpZ2RhdGEvY2F0YWxvZy5odG1s" >남은시간</span>
				<div class="event_date" id="soloday">0</div> 일
				<div class="event_date" id="solohour">00</div> :
				<div class="event_date" id="solomin">00</div> :
				<div class="event_date" id="solosecond">00</div>
			</li>
		</ul>
	</div>
<?php }?>

	<div id="goods_view">
		<div class="goods_thumbs_spec">
			<!-- ++++++++++++++++++++++++ 상품 이미지 ++++++++++++++++++++++++ -->
			<div id="goods_thumbs">
<?php if($TPL_VAR["images"]&&count($TPL_VAR["images"])> 1){?>
				<div class="slide-wrap">
					<div class="slides_wrap">
<?php if($TPL_images_1){$TPL_I1=-1;foreach($TPL_VAR["images"] as $TPL_V1){$TPL_I1++;?>
						<div class="main_tabs_contents slide <?php if($TPL_I1== 0){?>active<?php }?>" id="slide<?php echo $TPL_I1?>" style="<?php if($TPL_I1!= 0){?>display:none;<?php }?>">
							<a href="javascript:;">
<?php if($TPL_V1["view"]["image_type"]=='video'){?>
								<iframe  width="<?php echo $TPL_VAR["goodsinfo"]["video_size_mobile0"]?>" height="<?php echo $TPL_VAR["goodsinfo"]["video_size_mobile1"]?>" src="<?php echo $TPL_V1["view"]["image"]?>" frameborder="0" allowfullscreen  ></iframe>
<?php }else{?>
								<img src="<?php echo $TPL_V1["view"]["image"]?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl/images/common/noimage_wide.gif'" title="<?php echo $TPL_V1[ 1]["large"]["label"]?>" />
<?php }?>
							</a>
					</div>
<?php }}?>
					</div>
				</div>
<?php }else{?>
				<a href="javascript:;"><img src="<?php echo $TPL_VAR["images"][ 1]["view"]["image"]?>" onerror="this.src='/data/skin/responsive_sports_sporti_gl/images/common/noimage.gif'" title="<?php echo $TPL_VAR["images"][ 1]["large"]["label"]?>" /></a>
<?php }?>
				
				<div style="margin:10px auto; text-align:center; display:none;">
<?php if($TPL_images_1){$TPL_I1=-1;foreach($TPL_VAR["images"] as $TPL_V1){$TPL_I1++;?>
					<img src="/data/skin/responsive_sports_sporti_gl/images/design/intro_dot<?php if($TPL_I1== 0){?>_on<?php }?>.png" class="dot_paging hand" id="dot_<?php echo $TPL_I1?>" idx="<?php echo $TPL_I1?>" <?php if($TPL_V1["view"]["match_color"]){?> color="<?php echo $TPL_V1["view"]["match_color"]?>" <?php }?>/>
<?php }}?>
				</div>
			</div>
			<!-- ++++++++++++++++++++++++ //상품 이미지 ++++++++++++++++++++++++ -->


			<!-- ++++++++++++++++++++++++ 상품 스펙 ++++++++++++++++++++++++ -->
			<div id="goods_spec" style="border-top:none;">
				
				<!-- 확대/sns -->
				<div class="dcont_b1">
					<div class="Fl"><a href="javascript:popup('../goods/zoom?no=<?php echo $TPL_VAR["goodsinfo"]["goods_seq"]?>&popup=1',<?php echo ($TPL_VAR["goodsImageSize"]["view"]["width"]+ 400)?>,<?php echo ($TPL_VAR["goodsImageSize"]["view"]["width"]+ 350)?>,'no')"><img src="/data/skin/responsive_sports_sporti_gl/images/design/icon_zoom.png" style="width:35px; opacity:0.4;" /></a></div>
					<div class="Fr"><?php echo snslinkurl('goods',$TPL_VAR["goodsinfo"]["goods_name"])?></div>
				</div>

<?php if($TPL_VAR["goodsinfo"]["string_price_use"]){?>
					<b class="price"><?php echo $TPL_VAR["goodsinfo"]["string_price"]?></b>
<?php }else{?>
					<ul class="price_area">
						<li>
							<p>
<?php if($TPL_VAR["goodsinfo"]["org_price"]>$TPL_VAR["goodsinfo"]["sale_price"]){?>
								<span class="consumer"><s><?php echo number_format($TPL_VAR["goodsinfo"]["org_price"])?>원</s></span> &nbsp;
<?php }?>
							</p>
							<p class="price1">
								<b><?php if($TPL_VAR["goodsinfo"]["sale_price"]> 0){?><?php echo number_format($TPL_VAR["goodsinfo"]["sale_price"])?><?php }else{?>0<?php }?></b>원&nbsp;
<?php if($TPL_VAR["goodsinfo"]["sum_sale_price"]){?>
								<button type="button" class="btn_resp Mt-3" onclick="if( $('#priceDetail').is(':hidden') ) $('#priceDetail').show(); else $('#priceDetail').hide();"><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JpZ2RhdGEvY2F0YWxvZy5odG1s" >혜택보기</span></button>
<?php }?>
							</p>
						</li>
						<li>
<?php if($TPL_VAR["goodsinfo"]["sale_rate"]){?>
							<div class="deatil_sale_rate">
								<p class="inner">
									<span class="num"><?php echo number_format($TPL_VAR["goodsinfo"]["sale_rate"])?></span>%
								</p>
							</div>
<?php }?>
						</li>
					</ul>
					<div id="priceDetail" class="detail_option_list Mt0" style="display:none;">
						<ul>
<?php if(is_array($TPL_R1=$TPL_VAR["sales"]["sale_list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_V1> 0){?>
							<li>
								<span class="title"><?php echo $TPL_VAR["sales"]["title_list"][$TPL_K1]?></span>
								<span class="detail"><?php echo number_format($TPL_V1)?> 원</span>
							</li>
<?php }?>
<?php }}?>
						</ul>
					</div>
<?php if($TPL_VAR["goodsinfo"]["goods_status"]=='runout'){?>
					<p class="text_soldout">품절</p>
<?php }?>
<?php if($TPL_VAR["goodsinfo"]["goods_status"]=='purchasing'){?>
					<p class="text_soldout">재고확보 중</p>
<?php }?>
<?php if($TPL_VAR["goodsinfo"]["goods_status"]=='unsold'){?>
					<p class="text_soldout">판매중지</p>
<?php }?>
<?php }?>



				<ul class="cart_order_btn_area">
					<li><button type="button" class="btn-goods btn_resp size_c color2"><span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JpZ2RhdGEvY2F0YWxvZy5odG1s" >상품상세정보</span></button></li>
					<li><button type="button" id="wishimg" usewish="n" class="btn_resp size_c" onclick="wish_chg();"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL2JpZ2RhdGEvY2F0YWxvZy5odG1s" >위시리스트</span></button></li>
				</ul>
			</div>
			<!-- ++++++++++++++++++++++++ //상품 스펙 ++++++++++++++++++++++++ -->
		</div>


<?php if($TPL_kinds_1){foreach($TPL_VAR["kinds"] as $TPL_K1=>$TPL_V1){?>
		<h3 class="title_sub2"><b><img src="/data/skin/responsive_sports_sporti_gl/images/design/ico_bd_<?php echo $TPL_K1?>.png" /> <?php echo $TPL_V1["textStr"]?></b></h3>
		<?php echo $TPL_V1["display"]?>

<?php }}?>

	</div>
</div>





<script type="text/javascript">
var gl_member_seq = "<?php echo $TPL_VAR["sessionMember"]["member_seq"]?>";
$(document).ready(function(){

	setSlideSwipe('.slides_wrap', '.main_tabs_contents', 'resimg_num');

<?php if($TPL_VAR["eventEnd"]){?>
	timeInterval<?php echo $TPL_VAR["goodsinfo"]["goods_seq"]?> = setInterval(function(){
		var time<?php echo $TPL_VAR["goodsinfo"]["goods_seq"]?> = showClockTime('text', '<?php echo $TPL_VAR["eventEnd"]["year"]?>', '<?php echo $TPL_VAR["eventEnd"]["month"]?>', '<?php echo $TPL_VAR["eventEnd"]["day"]?>', '<?php echo $TPL_VAR["eventEnd"]["hour"]?>', '<?php echo $TPL_VAR["eventEnd"]["min"]?>', '<?php echo $TPL_VAR["eventEnd"]["second"]?>', 'soloday', 'solohour', 'solomin', 'solosecond', '<?php echo $TPL_VAR["goodsinfo"]["goods_seq"]?>');
		if(time<?php echo $TPL_VAR["goodsinfo"]["goods_seq"]?> == 0){
			clearInterval(timeInterval<?php echo $TPL_VAR["goodsinfo"]["goods_seq"]?>);
			//단독이벤트가 종료되었습니다.
			alert(getAlert('et356'));
			document.location.reload();
		}
	},1000);
<?php }?>

	$("button.btn-goods").click(function(){
		location.href	= '../goods/view?no=<?php echo $TPL_VAR["goodsinfo"]["goods_seq"]?>';
	});

<?php if($TPL_VAR["wish_seq"]){?>
		$('#wishimg').attr('usewish','y');
<?php }?>
});

function resimg_num(i){
	var slide_current = $(".slides_wrap").data('slide_current');
	$('.dot_paging').attr('src','/data/skin/responsive_sports_sporti_gl/images/design/intro_dot.png');
	$('#dot_'+i).attr('src','/data/skin/responsive_sports_sporti_gl/images/design/intro_dot_on.png');
	$('.main_tabs_contents').eq(slide_current).removeClass('active');
	$('.main_tabs_contents').eq(i).addClass('active');
	var k=0;
	$('.main_tabs_contents').each(function(){
		if(i == k) $(this).show();
		else $(this).hide();

		k = k + 1;
	});
	$(".slides_wrap").data('slide_current',i);
}

function openlayer(type){
	$('#'+type).slideToggle(300);
}

function wish_chg(){
	if(!gl_member_seq){
		//회원만 사용가능합니다.\n로그인하시겠습니까?
		if(confirm(getAlert('et357'))){
			var url = "/member/login?return_url=<?php echo $_SERVER['REQUEST_URI']?>";
			top.document.location.href = url;
			return;
		}else{
			return;
		}
	}
	if($('#wishimg').attr('usewish') == 'n'){
		$('#wishimg').attr('usewish','y');
		$('iframe[name=actionFrame]').attr('src','../mypage/wish_add?seqs[]=<?php echo $TPL_VAR["goodsinfo"]["goods_seq"]?>');
	}else{
		$('#wishimg').attr('usewish','n');
		$('iframe[name=actionFrame]').attr('src','../mypage/wish_del?seqs=<?php echo $TPL_VAR["goodsinfo"]["goods_seq"]?>');
	}
}
</script>