<?php /* Template_ 2.2.6 2021/01/08 15:30:14 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/mypage/promotion.html 000007738 */  $this->include_("showMyPromotion");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 포인트로 할인코드 교환 @@
- 파일위치 : [스킨폴더]/mypage/promotion.html
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
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL215cGFnZS9wcm9tb3Rpb24uaHRtbA==" >포인트로 할인코드 교환</span></h2>
		</div>
		
		<div class="tab_basic">
			<ul>
<?php if($TPL_VAR["emoney_exchange_use"]=='y'){?>
				<li>
					<a href="/mypage/point_exchange" hrefOri='L215cGFnZS9wb2ludF9leGNoYW5nZQ==' >포인트 → <span class="Dib">마일리지</span></a>
				</li>
<?php }?>
				<li class="on">
					<a href="/mypage/promotion" hrefOri='L215cGFnZS9wcm9tb3Rpb24=' >포인트 → <span class="Dib">할인코드</span></a>
				</li>
				<li>
					<a href="/mypage/emoney_exchange" hrefOri='L215cGFnZS9lbW9uZXlfZXhjaGFuZ2U=' >캐시 → <span class="Dib">사은품</span></a>
				</li>
			</ul>
		</div>

		<div class="tab_desc">
			보유하신 포인트로 상품구매 시 할인받으실 수 있는 1회성 할인코드를 교환할 수 있습니다.
		</div>
		<div id="bmpsetting">
			<input type="text" id="BMP" oninput="calculate()" value="123" placeholder="지급할 bmp를 입력해주세요">
			<input type="text" id="RATE" value="<?php echo $TPL_VAR["coinrate"]["rate"]?>" readonly>
			<input type="text" id="TOTAL" readonly>
		</div>

		<div class="resp_table_row th_size2 mt20">
			<ul class="tr">
				<li class="th"><?php echo $TPL_VAR["userInfo"]["user_name"]?>님의 보유 포인트</li>
				<li class="td">
					<strong class="strong1"><?php echo number_format($TPL_VAR["mypoint"])?></strong>P
				</li>
			</ul>
			<ul class="tr">
				<li class="th">이번달 소멸 예정 포인트</li>
				<li class="td">
					<strong class="strong1"><?php echo number_format($TPL_VAR["extinction"]["reserve_point"])?></strong>P
				</li>
			</ul>
		</div>
		
<?php if(showMyPromotion('','20000')){?>
		<h3 class="title_sub1">포인트로 할인코드 교환</h3>
		<div class="pro_code_exch">
			<ul>
<?php if(is_array($TPL_R1=showMyPromotion('','20000'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<li>
					<div class="promo_code">
						<div class="txt"><?php echo $TPL_V1["promotion_name"]?></div>
						<div class="sale"><span class="tahoma"><?php echo $TPL_V1["percent_goods_sale_show"]?></span></div>
					</div>
					<ul class="promo_deatil">
						<li>교환 포인트 : <strong class="strong1"><?php echo number_format($TPL_V1["promotion_point"])?></strong>P</li>
						<li>남은수량 : <strong class="strong1"><?php echo $TPL_V1["limitnumber"]?></strong></li>
						<li class="btn_area_a">
							<button type="button" class="promotiondownbtn btn_resp size_b" promotion_type="<?php echo $TPL_V1["type"]?>" promotion_seq="<?php echo $TPL_V1["promotion_seq"]?>" promotion_name="<?php echo $TPL_V1["promotion_name"]?>" promotion_point="<?php echo $TPL_V1["promotion_point"]?>">신청하기</button>
						</li>
					</ul>
				</li>
<?php }}?>
			</ul>
		</div>
<?php }?>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl_1/common/mypage_ui.js"></script><!-- mypage ui 공통 -->


<div id="giftPopup" style="display:none"></div>

<script type="text/javascript" src="/app/javascript/plugin/zeroclipboard/ZeroClipboard.js"></script>
<script>
	function calculate() {
		var bmp = document.getElementById("BMP").value;
		var rate = document.getElementById("RATE").value;
		var total = bmp*rate;

		document.getElementById("TOTAL").value = total; 
	}
</script>
<script type="text/javascript">
	$(document).ready(function() {
		//프로모션신청
		$(".promotiondownbtn").live("click",function(){
			var mypoint = <?php echo $TPL_VAR["mypoint"]?>;
			var promotion_type = $(this).attr('promotion_type');
			var promotion_seq = $(this).attr('promotion_seq');
			var promotion_name = $(this).attr('promotion_name');
			var promotion_point = $(this).attr('promotion_point');
			if( (promotion_type == 'point' || promotion_type == 'point_shipping' ) && (mypoint < promotion_point || mypoint < 1) ){//전환포인트인경우
				if(mypoint < 1){
					//보유포인트가 없습니다.
					openDialogAlert(getAlert('mp178'),'400','140',function(){});
				}else{
					//전환포인트 금액이 보유포인트보다 작습니다.
					openDialogAlert(getAlert('mp179'),'400','140',function(){});
				}
				return false;
			}else{
				//프로모션 코드를 신청하시겠습니까?
				if(confirm("["+promotion_name+"] "+getAlert('mp180'))) {
					$.ajax({
						'url' : '../promotion/download_member',
						'data' : {'promotion_seq':promotion_seq},
						'type' : 'post',
						'dataType': 'json',
						'success': function(data) {
							if(data.result){
								openDialogAlert(data.msg,'400','150',function(){document.location.reload();});
							}else{
								openDialogAlert(data.msg,'400','150',function(){});
							}
						}
					});
				}
			}
		})

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
					//해당 사은품은 증정 받기 위한 잔여 마일리지가 부족합니다
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
				$('#giftPopup').html(data);
			});
			//사은품 신청
			openDialog(getAlert('mp182'), "giftPopup", {"width":"1000","height":700});
		});

		$(".promotioncodecopy").live("click", function(){
				var promotion_input_serialnumber =  $(this).attr('promotion_input_serialnumber');
				var clip = new ZeroClipboard.Client();
				clip.setHandCursor( true );
				clip.setCSSEffects( true );
				clip.setText(promotion_input_serialnumber);
				clip.addEventListener( 'complete', function(client, text) {
					//클립보드에 복사되었습니다.
					alert(getAlert('mp183'));
				});
				clip.glue(promotion_input_serialnumber);
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