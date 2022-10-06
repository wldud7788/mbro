<?php /* Template_ 2.2.6 2020/12/29 11:40:55 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/mypage/emoney_exchange.html 000006976 */ 
$TPL_gift_loop_1=empty($TPL_VAR["gift_loop"])||!is_array($TPL_VAR["gift_loop"])?0:count($TPL_VAR["gift_loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 혜택 교환 > 캐시로 사은품 교환 @@
- 파일위치 : [스킨폴더]/mypage/emoney_exchange.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9lbW9uZXlfZXhjaGFuZ2UuaHRtbA==" >캐시로 사은품 교환</span></h2>
		</div>
		
		<div class="tab_basic">
			<ul>
<?php if($TPL_VAR["emoney_exchange_use"]=='y'){?>
				<li>
					<a href="/mypage/point_exchange" hrefOri='L215cGFnZS9wb2ludF9leGNoYW5nZQ==' >포인트 → <span class="Dib">캐시</span></a>
				</li>
<?php }?>
				<li>
					<a href="/mypage/promotion" hrefOri='L215cGFnZS9wcm9tb3Rpb24=' >포인트 → <span class="Dib">할인코드</span></a>
				</li>
				<li class="on">
					<a href="/mypage/emoney_exchange" hrefOri='L215cGFnZS9lbW9uZXlfZXhjaGFuZ2U=' >캐시 → <span class="Dib">사은품</span></a>
				</li>
			</ul>
		</div>

		<div class="resp_table_row th_size2 mt20">
			<ul class="tr">
				<li class="th"><?php echo $TPL_VAR["userInfo"]["user_name"]?>님의 보유 캐시</li>
				<li class="td">
					<strong class="strong1"><?php echo get_currency_price($TPL_VAR["myemoney"], 2)?></strong>
				</li>
			</ul>
			<ul class="tr">
				<li class="th">이번달 소멸 예정 캐시</li>
				<li class="td">
					<strong class="strong1"><?php echo get_currency_price($TPL_VAR["extinction"]["reserve"], 2)?></strong>
				</li>
			</ul>
		</div>
		<input type="hidden" name="point" value="<?php echo get_member_money('point',$TPL_VAR["userInfo"]["member_seq"])?>"/>

<?php if($TPL_VAR["gift_loop"]){?>
<?php if($TPL_gift_loop_1){foreach($TPL_VAR["gift_loop"] as $TPL_V1){?>
			<h3 class="title_sub1"><?php echo $TPL_V1["title"]?></h3>
			<div class="gift_loop_title">
				<ul>
					<li class="title">
						<strong class="tt1">교환 마일리지 <?php echo number_format($TPL_V1["sprice"])?></strong> 
						<span class="ss1">사은품 가격만큼 <?php if($TPL_VAR["gift_info"]["goods_rule"]=="reserve"){?>캐시<?php }else{?>포인트<?php }?>가 차감됩니다.</span>
					</li>
					<li class="date">
						<span class="Dib"><?php echo $TPL_V1["start_date"]?></span> <span class="Dib">~ <?php echo $TPL_V1["end_date"]?></span>
					</li>
				</ul>
<?php if($TPL_V1["gift_contents"]){?>
				<!--<div class="gift_loop_desc"><?php echo $TPL_V1["gift_contents"]?></div>-->
<?php }?>
			</div>
			<ul class="gift_loop_items">
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li>
					<ul class="item_detail">
						<li class="img_area"><img class="item_img" src="<?php echo get_gift_image($TPL_V2,'list1')?>" onerror="this.src='/data/skin/responsive_diary_petit_gl_1/images/common/noimage.gif';" alt="<?php echo get_gift_name($TPL_V2)?>" designImgSrcOri='ez1nZXRfZ2lmdF9pbWFnZSguLnZhbHVlXyw=' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9lbW9uZXlfZXhjaGFuZ2UuaHRtbA==' designImgSrc='ez1nZXRfZ2lmdF9pbWFnZSguLnZhbHVlXyw=' designElement='image' /></li>
						<li class="name_area"><?php echo get_gift_name($TPL_V2)?></li>
						<li class="price_area hide"><?php if($TPL_VAR["gift_info"]["goods_rule"]=="reserve"){?>캐시<?php }else{?>포인트<?php }?> : <strong><?php echo number_format($TPL_V1["sprice"])?></strong></li>
						<li class="num_area">남은수량 : <strong class="strong1"><?php echo number_format(get_gift_stock($TPL_V2))?>개</strong></li>
<?php if(get_gift_stock($TPL_V2)> 0){?>
						<li class="btn_area">
							<button type="button" class="req_gift btn_resp size_b Wmax" point="<?php echo $TPL_V1["sprice"]?>" seq="<?php echo $TPL_V2?>" goods_rule="<?php echo $TPL_VAR["gift_info"]["goods_rule"]?>" goods_name="<?php echo get_gift_name($TPL_V2)?>">신청하기</button>
						</li>
<?php }?>
					</ul>
				</li>
<?php }}?>
			</ul>
<?php }}?>
<?php }?>


	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl_1/common/mypage_ui.js"></script><!-- mypage ui 공통 -->


<div id="giftPopup" class="resp_layer_pop hide">
	<h4 class="title">사은품 신청</h4>
	<div class="y_scroll_auto">
		<div class="layer_pop_contents v4"></div>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
</div>
<!--div id="giftPopup" style="display:none"></div--> 

<script type="text/javascript" src="/app/javascript/plugin/zeroclipboard/ZeroClipboard.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".req_gift").click(function(){
			var my_point = $("input[name='point']").val();
			var my_reserve = "<?php echo $TPL_VAR["myemoney"]?>";
			var seq		= $(this).attr("seq");
			var point	= $(this).attr("point");
			var goods_rule	= $(this).attr("goods_rule");
			var goods_name	= $(this).attr("goods_name");
			
			if(goods_rule == "reserve"){
				//alert(my_point+" : "+$(this).attr("point"));
				if(parseInt(my_reserve) < parseInt($(this).attr("point"))){
					//해당 사은품은 증정 받기 위한 잔여 캐시가 부족합니다
					alert(getAlert('mp186'));
					return;
				}
			}else{
				//alert(my_point+" : "+$(this).attr("point"));
				if(parseInt(my_point) < parseInt($(this).attr("point"))){
					//해당 사은품은 증정 받기 위한 잔여 포인트가 부족합니다
					alert(getAlert('mp181'));
					return;
				}
			}
			//alert($(this).attr("point")+" : "+$(this).attr("seq"));

			$.get('/mypage/buy_gift?seq='+seq+'&point='+point+'&goods_rule='+goods_rule+'&goods_name='+escape(goods_name), function(data) {
				$('#giftPopup .layer_pop_contents').html(data);
				//사은품 신청
				showCenterLayer('#giftPopup');
			});
			//사은품 신청
			//openDialog(getAlert('mp182'), "giftPopup", {"width":"1000","height":700});
		});
	});

	function clipBoard(name, id){
		var clip = new ZeroClipboard.Client();
		clip.setHandCursor( true );
		clip.setCSSEffects( true );
		clip.setText($("input[name='"+name+"']").val());
		clip.addEventListener( 'complete', function(client, text) {
			//클립보드에 복사되었습니다.
			alert(getAlert('mp183'));
		});
		clip.glue(id);
	}
</script>