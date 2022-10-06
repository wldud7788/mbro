<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/mypage/wish.html 000007049 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 위시리스트 @@
- 파일위치 : [스킨폴더]/mypage/wish.html
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
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL215cGFnZS93aXNoLmh0bWw=" >위시리스트</span></h2>
		</div>

<?php $this->print_("common_mycart_top",$TPL_SCP,1);?>


		<form name="wish_form" id="wish_form" method="post">
<?php if($TPL_VAR["record"]){?>
			<div class="wish_allselect_area">
				<label class="checkbox_allselect"><input type="checkbox" class="btn_select_all" /> <span class="txt">전체선택</span></label>
				<button type="button" class="btn_resp btn_select_del">선택삭제</button>
			</div>

			<div class="wish_wrap">
				<ul id="wishList" class="wish_list">
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
					<li>
						<div class="img_area"><a href="../goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" hrefOri='Li4vZ29vZHMvdmlldz9ubz17Lmdvb2RzX3NlcX0=' ><?php echo $TPL_V1["image_html"]?></a></div>
						<ul class="sub">
							<li class="wish_name">
								<label><input type="checkbox" name="wish_seq[]" value="<?php echo $TPL_V1["wish_seq"]?>" /> <?php echo $TPL_V1["goods_name"]?></label>
							</li>
							<li class="wish_price">
<?php if($TPL_V1["string_price_use"]){?>
								<p class="string_price"><b class="price"><?php echo $TPL_V1["string_price"]?></b></p>
<?php }else{?>
								<p class="nomal_price">
									<b><?php echo get_currency_price($TPL_V1["sale_price"], 2)?></b>
<?php if($TPL_V1["consumer_price"]&&$TPL_V1["sale_price"]!=$TPL_V1["consumer_price"]){?>
									<s><?php echo get_currency_price($TPL_V1["consumer_price"])?></s>
<?php }?>
								</p>
								<?php echo $TPL_V1["sale_price_compare"]?>

<?php }?>
							</li>
<?php if($TPL_V1["reserve"]||($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"])){?>
							<li class="wish_point">
<?php if($TPL_V1["reserve"]){?>
								<?php echo get_currency_price($TPL_V1["reserve"], 2)?> 적립
<?php }?>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
								/ <?php echo number_format($TPL_V1["point"])?>P 적립
<?php }?>
							</li>
<?php }?>
							<li class="wish_btns">
								<button type="button" name="cart" id="wishcart_<?php echo $TPL_V1["wish_seq"]?>" class="btn_resp size_a color2 wishcart">장바구니 담기</button>
								<button type="button" class="btn_resp size_a color5 btn_thisitem_del" value="<?php echo $TPL_V1["wish_seq"]?>">삭제</button>
							</li>
						</ul>
					</li>
<?php }}?>
				</ul>
			</div>

			<div class="paging_navigation">
<?php if($TPL_VAR["page"]["prev"]){?>
				<a href="wish?page=<?php echo $TPL_VAR["page"]["prev"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" hrefOri='d2lzaD9wYWdlPXtwYWdlLnByZXZ9JmFtcDt7cGFnZS5xdWVyeXN0cmluZ30=' ><span class="prev" />◀ 이전 </span></a>
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
					<a class="on red"><?php echo $TPL_V1?></a>&nbsp;
<?php }else{?>
					<a href="wish?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" hrefOri='d2lzaD9wYWdlPXsudmFsdWVffSZhbXA7e3BhZ2UucXVlcnlzdHJpbmd9' ><?php echo $TPL_V1?></a>&nbsp;
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?>
				<a href="wish?page=<?php echo $TPL_VAR["page"]["next"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" hrefOri='d2lzaD9wYWdlPXtwYWdlLm5leHR9JmFtcDt7cGFnZS5xdWVyeXN0cmluZ30=' ><span class="next " />다음 ▶</span></a>
<?php }?>
			</div>
<?php }else{?>
			<div class="no_data_area2 Mt20">
				위시리스트에 담긴 상품이 없습니다.
			</div>
<?php }?>
		</form>

		<div id="cart_dialog" class="resp_layer_pop hide">
			<h4 class="title">장바구니 담기</h4>
			<div class="y_scroll_auto v2">
			</div>
			<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' ></a>
		</div>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>
<script type="text/javascript" src="/data/skin/responsive_sports_sporti_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->


<!--div id="cart_dialog" style="display:none;"></div-->
<script type="text/javascript">
	$(document).ready(function() {
		
		// 항목 크기 설정
		/* 반응형에서 크기가 고정됨 --> css 처리로 변경 __ 190422
		if ( window.innerWidth > 767 ) {
			var li_width = $('#wishList>li:first-child .img_area img').width();
			$('#wishList>li').width( li_width );
		}
		*/

		// 전체 선택
		$("form#wish_form .btn_select_all").change(function() {
			if($(this).is(":checked")) {
				$("input[name='wish_seq[]']").attr("checked",true);
				$("input[name='wish_seq[]']").closest('.ez-checkbox').addClass('ez-checkbox-on');
			} else {
				$("input[name='wish_seq[]']").attr("checked",false);
				$("input[name='wish_seq[]']").closest('.ez-checkbox').removeClass('ez-checkbox-on');
			}
		});

		// 선택삭제
		$("form#wish_form button.btn_select_del").bind("click",function(){
			$("form#wish_form").attr("action","wish_del");
			$("form#wish_form").attr("target","actionFrame");
			$("form#wish_form")[0].submit();
		});
		
		// 현재상품 삭제
		$("form#wish_form button.btn_thisitem_del").bind("click",function(){
			var selected_order = $(this).val();
			$("input[name='wish_seq[]']").removeAttr("checked");
			$("input[name='wish_seq[]'][value='"+selected_order+"']").attr("checked", true);

			$("form#wish_form").attr("action","wish_del");
			$("form#wish_form").attr("target","actionFrame");
			$("form#wish_form")[0].submit();
		});

		// 장바구니담기 버튼
		$("button[name='cart']").bind("click",function() {
			var seq = $(this).attr('id');
			seq = seq.replace("wishcart_","");
			var url = "wish2cart?no="+seq;
			$.get(url, function(data) {
				$("#cart_dialog .y_scroll_auto").html(data);
				//장바구니 담기
				showCenterLayer('#cart_dialog');
				//openDialog(getAlert('mp040'), "cart_dialog", {"width":500,"height":600});
			});
		});
	});
</script>