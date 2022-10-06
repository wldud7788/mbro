<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/data/design_list/goods_list_style5.html 000006387 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ goods_list_style5 @@
- 파일 위치 : /data/design_list/goods_list_style5.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
<li class="goods_list_style5">
<?php if(!$TPL_VAR["issample"]){?>
		<div class="item_img_area">
			<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>"><img src="<?php echo $TPL_V1["image"]?>" onerror="this.src='/data/skin/<?php echo $TPL_VAR["skin"]?>/images/common/noimage.gif';" alt="" /></a>
			<div class="display_zzim">
<?php if($TPL_V1["wish"]){?>
				<img src="/data/icon/goodsdisplay/preview/thumb_zzim_off.png" class="zzimOffImg"  alt="찜하기" style="display:none" data-member="<?php echo $TPL_VAR["aParams"]["member_seq"]?>" data-goods="<?php echo $TPL_V1["goods_seq"]?>" data-wish="<?php echo $TPL_V1["wish"]?>" onclick="setWish(this)">
				<img src="/data/icon/goodsdisplay/preview/thumb_zzim_on.png" class="zzimOnImg" alt="찜하기" data-member="<?php echo $TPL_VAR["aParams"]["member_seq"]?>" data-goods="<?php echo $TPL_V1["goods_seq"]?>" data-wish="<?php echo $TPL_V1["wish"]?>" onclick="setWish(this)">
<?php }else{?>
				<img src="/data/icon/goodsdisplay/preview/thumb_zzim_off.png" class="zzimOffImg" alt="찜하기" data-member="<?php echo $TPL_VAR["aParams"]["member_seq"]?>" data-goods="<?php echo $TPL_V1["goods_seq"]?>" data-wish="<?php echo $TPL_V1["wish"]?>" onclick="setWish(this)">
				<img src="/data/icon/goodsdisplay/preview/thumb_zzim_on.png" class="zzimOnImg" alt="찜하기" style="display:none" data-member="<?php echo $TPL_VAR["aParams"]["member_seq"]?>" data-goods="<?php echo $TPL_V1["goods_seq"]?>" data-wish="<?php echo $TPL_V1["wish"]?>" onclick="setWish(this)">
<?php }?>
			</div>
			<!-- 상품 상태 표시 -->
<?php if($TPL_V1["goods_status"]!='normal'){?>
			<div class="respGoodsStatus">
				<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" class="area">
<?php if($TPL_V1["goods_status"]=='runout'){?>
					<span class="status_style type1"><em>SOLD OUT!</em></span>
<?php }elseif($TPL_V1["goods_status"]=='purchasing'){?>
					<span class="status_style type2"><em>재고확보중</em></span>
<?php }elseif($TPL_V1["goods_status"]=='unsold'){?>
					<span class="status_style type3"><em>판매중지</em></span>
<?php }?>
				</a>
			</div>
<?php }?>
		</div>
<?php }?>
	<ul class="item_info_area">
<?php if($TPL_V1["goods_name"]){?>
		<li class="goods_name_area">
			<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>"><span class="name"><?php echo $TPL_V1["goods_name"]?></span></a>
		</li>
<?php }?>

		<!-- 비회원 대체문구 -->
<?php if($TPL_V1["string_price"]){?>
		<li class="goods_price_area">
			<span class="warning_text"><?php echo $TPL_V1["string_price"]?></span>
		</li>
<?php }else{?>
		<li class="goods_price_area">
			<span class="sale_price">
<?php if($TPL_V1["sale_price"]>= 0){?>
				<?php echo get_currency_price($TPL_V1["sale_price"], 2,'','<b class="num">_str_price_</b>')?>

<?php }else{?>
				<?php echo get_currency_price($TPL_V1["price"], 2,'','<b class="num">_str_price_</b>')?>

<?php }?>
			</span>

<?php if($TPL_V1["consumer_price"]>$TPL_V1["sale_price"]){?>
			<span class="consumer_price">
				<?php echo get_currency_price($TPL_V1["consumer_price"], 2,'','<span class="num">_str_price_</span>')?>

			</span>
<?php }?>

<?php if($TPL_V1["sale_per"]> 0){?>
			<span class="discount_rate">
				<b class="num"><?php echo $TPL_V1["sale_per"]?></b>%
			</span>
<?php }?>
		</li>
<?php }?>

<?php if($TPL_VAR["aParams"]["searchMode"]!='catalog'&&$TPL_V1["category"]){?>
		<li class="goods_category_area">
			<ul class="cate">
				<li><?php echo $TPL_V1["category"]?></li>
			</ul>
		</li>
<?php }?>

<?php if($TPL_V1["shipping_group"]["free_shipping_use"]=='Y'||$TPL_V1["shipping_group"]["gl_shipping_yn"]=='Y'){?>
		<li class="goods_besong_area">
			<!-- 무료배송 -->
<?php if($TPL_V1["shipping_group"]["free_shipping_use"]=='Y'){?>
			<span class="besong">무료배송</span>
<?php }?>
			<!-- 해외배송 -->
<?php if($TPL_V1["shipping_group"]["gl_shipping_yn"]=='Y'){?>
			<span class="besong">해외배송</span>
<?php }?>
		</li>
<?php }?>

		<!-- (단독이벤트) 판매수량 -->
<?php if($TPL_V1["event_order_ea"]> 0){?>
		<li class="goods_sold_area">
			<b class="num"><?php echo number_format($TPL_V1["event_order_ea"])?></b>개 구매
		</li>
<?php }?>

		<!-- (단독이벤트) 남은 시간 -->
<?php if(!empty($TPL_V1["eventEnd"])){?>
		<li class="goods_event_time displaY_event_time soloEventTd<?php echo $TPL_V1["goods_seq"]?>">
			<span class="title">남은시간</span>
			<span class="time_container">
				<span class="num2 soloday<?php echo $TPL_V1["goods_seq"]?>"></span>일 
				<span class="num2 solohour<?php echo $TPL_V1["goods_seq"]?>"></span> :
				<span class="num2 solomin<?php echo $TPL_V1["goods_seq"]?>"></span> :
				<span class="num2 solosecond<?php echo $TPL_V1["goods_seq"]?>"></span>
			</span>
		</li>
		<script type="text/javascript">
		   $(document).ready(function() {
				timeInterval<?php echo $TPL_V1["goods_seq"]?> = setInterval(function(){
					 var time<?php echo $TPL_V1["goods_seq"]?> = showClockTime('text', '<?php echo $TPL_V1["eventEnd"]["year"]?>', '<?php echo $TPL_V1["eventEnd"]["month"]?>', '<?php echo $TPL_V1["eventEnd"]["day"]?>', '<?php echo $TPL_V1["eventEnd"]["hour"]?>', '<?php echo $TPL_V1["eventEnd"]["min"]?>', '<?php echo $TPL_V1["eventEnd"]["second"]?>', 'soloday<?php echo $TPL_V1["goods_seq"]?>', 'solohour<?php echo $TPL_V1["goods_seq"]?>', 'solomin<?php echo $TPL_V1["goods_seq"]?>', 'solosecond<?php echo $TPL_V1["goods_seq"]?>', '<?php echo $TPL_V1["goods_seq"]?>','class');
					 if(time<?php echo $TPL_V1["goods_seq"]?> == 0){
						  clearInterval(timeInterval<?php echo $TPL_V1["goods_seq"]?>);
						  $(".soloEventTd<?php echo $TPL_V1["goods_seq"]?>").html("단독 이벤트 종료");
					 }
				},1000);
		   });
	   </script>
<?php }?>

	</ul>
</li>
<?php }}?>