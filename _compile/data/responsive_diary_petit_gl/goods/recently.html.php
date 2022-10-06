<?php /* Template_ 2.2.6 2020/12/10 10:20:15 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/goods/recently.html 000006998 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 최근본 상품 @@
- 파일위치 : [스킨폴더]/goods/recently.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)">MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9nb29kcy9yZWNlbnRseS5odG1s" >최근본 상품</span></h2>
		</div>

		<!-- ------- 탭메뉴 인클루드. 파일위치 : [스킨폴더]/_modules/common/mycart_top.html ------- -->
<?php $this->print_("common_mycart_top",$TPL_SCP,1);?>

		<!-- ------- //탭메뉴 인클루드 ------- -->

		<form name="goods_form" id="goods_form" method="post">
		<!--input type="hidden" name="goods_seq[]" value="" /-->
<?php if($TPL_VAR["record"]){?>
			<div class="recent_allselect_area">
				<label class="checkbox_allselect"><input type="checkbox" class="btn_select_all" /> <span class="txt">전체선택</span></label>
				<button type="button" class="btn_resp btn_select_del">선택삭제</button>
			</div>

			<div class="recent_wrap">
				<ul id="recentList" class="recent_list">
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
					<li>
						<div class="img_area">
							<a href="../goods/view?no=<?php echo $TPL_V1["goods_seq"]?>">
								<img src="<?php echo $TPL_V1["image"]?>" onerror="this.src='/data/skin/responsive_diary_petit_gl/images/common/noimage_list.gif'" />
							</a>
						</div>
						<ul class="sub">
							<li class="recent_name">
								<label><input type="checkbox" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /> <?php echo $TPL_V1["goods_name"]?></label>
							</li>
							<li class="recent_price">
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
							<li class="recent_point">
<?php if($TPL_V1["reserve"]){?>
								<?php echo get_currency_price($TPL_V1["reserve"], 2)?> 적립
<?php }?>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
								/ <?php echo number_format($TPL_V1["point"])?>P 적립
<?php }?>
							</li>
<?php }?>
							<li class="recent_btns">
								<button type="button" name="cart" id="goodscart_<?php echo $TPL_V1["goods_seq"]?>" class="btn_resp size_a color2">장바구니 담기</button>
								<button type="button" class="btn_resp size_a color5 btn_thisitem_del" value="<?php echo $TPL_V1["goods_seq"]?>">삭제</button>
							</li>
						</ul>
					</li>
<?php }}?>
				</ul>
			</div>

			<div class="paging_navigation">
<?php if($TPL_VAR["page"]["prev"]){?>
				<a href="wish?page=<?php echo $TPL_VAR["page"]["prev"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>"><span class="prev" />◀ 이전 </span></a>
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
					<a class="on red"><?php echo $TPL_V1?></a>&nbsp;
<?php }else{?>
					<a href="wish?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>"><?php echo $TPL_V1?></a>&nbsp;
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?>
				<a href="wish?page=<?php echo $TPL_VAR["page"]["next"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>"><span class="next " />다음 ▶</span></a>
<?php }?>
			</div>
<?php }else{?>
			<div class="no_data_area2 Mt20">
				최근 본 상품이 없습니다.
			</div>
<?php }?>
		</form>

		<div id="cart_dialog" class="resp_layer_pop hide">
			<h4 class="title">장바구니 담기</h4>
			<div class="y_scroll_auto v2">
			</div>
			<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
		</div>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>
<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->


<!--div id="cart_dialog" style="display:none;"></div-->
<script type="text/javascript">
	$(document).ready(function() {
		

		
		// 항목 크기 설정
		/* 반응형에서 크기가 고정됨 --> css 처리로 변경 __ 190422
		if ( window.innerWidth > 767 ) {
			var li_width = $('#recentList>li:first-child .img_area img').width();
			$('#recentList .img_area').width( li_width );
		}
		*/

		// 전체 선택
		$("form#goods_form .btn_select_all").change(function() {
			if($(this).is(":checked")) {
				$("input[name='goods_seq[]']").attr("checked",true);
				$("input[name='goods_seq[]']").closest('.ez-checkbox').addClass('ez-checkbox-on');
			} else {
				$("input[name='goods_seq[]']").attr("checked",false);
				$("input[name='goods_seq[]']").closest('.ez-checkbox').removeClass('ez-checkbox-on');
			}
		});

		// 선택삭제
		$("form#goods_form button.btn_select_del").bind("click",function(){
			$("form#goods_form").attr("action","goods_del");
			$("form#goods_form").attr("target","actionFrame");
			$("form#goods_form")[0].submit();
		});
		
		// 현재상품 삭제
		$("form#goods_form button.btn_thisitem_del").bind("click",function(){
			var selected_order = $(this).val();
			$("input[name='goods_seq[]']").removeAttr("checked");
			$("input[name='goods_seq[]'][value='"+selected_order+"']").attr("checked", true);

			$("form#goods_form").attr("action","goods_del");
			$("form#goods_form").attr("target","actionFrame");
			$("form#goods_form")[0].submit();
		});

	// 장바구니담기 버튼
		$("button[name='cart']").bind("click",function() {


			var seq = $(this).attr('id');
			seq = seq.replace("goodscart_","");
			var url = "recently_option?no="+seq;

			

			$.get(url, function(data) {
				$("#cart_dialog .y_scroll_auto").html(data);
				//장바구니 담기
				showCenterLayer('#cart_dialog');
				//openDialog(getAlert('mp040'), "cart_dialog", {"width":500,"height":600});


			});
		});
	});
</script>
<!-- <script type="text/javascript" src="/app/javascript/js/goods_img_hhc.js"></script> -->