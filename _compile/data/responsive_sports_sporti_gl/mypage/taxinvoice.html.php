<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/mypage/taxinvoice.html 000003490 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 세금계산서 신청 @@
- 파일위치 : [스킨폴더]/mypage/taxinvoice.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="subpage_wrap">

	<!-- +++++ mypage LNB ++++ -->
	<div id="subpageLNB" class="subpage_lnb"><!-- [스킨폴더]/mypage/mypage_lnb.html --></div>
	<!-- +++++ //mypage LNB ++++ -->

	<!-- +++++ mypage contents ++++ -->
	<div class="subpage_container">
		<!-- 전체 메뉴 -->
		<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)">MENU</a>

		<!-- 타이틀 -->
		<div class="title_container">
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL215cGFnZS90YXhpbnZvaWNlLmh0bWw=" >세금계산서 신청</span></h2>
		</div>

<?php if($TPL_VAR["loop"]){?>
		<div class="res_table">
			<ul class="thead">
				<li style="width:42px;">번호</li>
				<li style="width:14%;">날짜</li>
				<li style="width:154px;">주문번호</li>
				<li>상품</li>
				<li style="width:90px;">주문금액</li>
				<li style="width:100px;">상태</li>
			</ul>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<ul class="tbody">
				<li class="mo_hide"><?php echo $TPL_V1["number"]?></li>
				<li class="sjb_top" style="order:-10;"><?php echo $TPL_V1["regist_date"]?></li>
				<li class="sjb_top mo_r grow" style="order:-9;"><span class="motle">주문번호:</span> <?php echo $TPL_V1["order_seq"]?></li>
				<li class="subject"><?php echo $TPL_V1["goods_name"]?></li>
				<li class="Pb10">
					<span class="motle">금액:</span> 
					<?php echo number_format($TPL_V1["settleprice"])?>

				</li>
				<li>
<?php if($TPL_V1["tax_seq"]){?>
<?php if($TPL_V1["tstep"]== 2){?>
							발급완료
<?php }else{?>
							<button type="button" class="taxBtn btn_resp color4 mo_adj" tax_seq="<?php echo $TPL_V1["tax_seq"]?>"  order_seq="<?php echo $TPL_V1["order_seq"]?>">수정</button>
							<button type="button" class="taxDellBtn btn_resp pointcolor3 imp mo_adj" tax_seq="<?php echo $TPL_V1["tax_seq"]?>"  order_seq="<?php echo $TPL_V1["order_seq"]?>">삭제</button>
<?php }?>
<?php }else{?>
<?php if($TPL_V1["taxwriteuse"]){?>
							<button type="button" class="taxBtn btn_resp color2 mo_adj" order_seq="<?php echo $TPL_V1["order_seq"]?>">신청</button>
<?php }?>
<?php }?>
				</li>
			</ul>
<?php }}?>
		</div>
<?php }else{?>
		<div class="no_data_area2">
			세금계산서 내역이 없습니다.
		</div>
<?php }?>

		<!-- paging -->
		<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_sports_sporti_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->
<script type="text/javascript" src="/app/javascript/skin-mypage.js"></script>

<!-- 세금계산서 신청 레이어 -->
<div id="tax_bill" class="resp_layer_pop hide">
	<h4 class="title">세금계산서</h4>
	<div class="y_scroll_auto">
		<div class="layer_pop_contents v3">
		</div>
	</div>
	<a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>