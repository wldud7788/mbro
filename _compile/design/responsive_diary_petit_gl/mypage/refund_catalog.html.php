<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/mypage/refund_catalog.html 000005520 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 취소/환불 내역 @@
- 파일위치 : [스킨폴더]/mypage/refund_catalog.html
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
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9teXBhZ2UvcmVmdW5kX2NhdGFsb2cuaHRtbA==" >취소/환불 내역</span></h2>
		</div>
		<div class="mypage_greeting btm_padding">
			전체 <span class="pointnum"><?php echo number_format($TPL_VAR["page"]["totalcount"])?></span>건
		</div>

<?php if($TPL_VAR["page"]["totalcount"]== 0){?>
		<div class="no_data_area2">
			내역이 없습니다.
		</div>
<?php }else{?>
		<div class="res_table">
			<ul class="thead">
				<li style="width:90px;">날짜</li>
				<li style="width:100px;">환불번호</li>
				<li style="width:110px;">환불종류</li>
				<li>상품</li>
				<li style="width:100px;">환불완료일</li>
				<li style="width:132px;">상태</li>
			</ul>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
			<ul class="tbody">
				<li class="sjb_top" style="order:-9;"><?php echo date('Y-m-d',strtotime($TPL_V1["regist_date"]))?></li>
				<li class="sjb_top mo_r grow" style="order:-8">
					<span class="motle">환불번호:</span> 
					<a class="link1" href="refund_view?refund_code=<?php echo $TPL_V1["refund_code"]?>" title="상세" hrefOri='cmVmdW5kX3ZpZXc/cmVmdW5kX2NvZGU9ey5yZWZ1bmRfY29kZX0=' ><?php echo $TPL_V1["refund_code"]?></a>
				</li>
				<li class="sjb_top" style="order:-10;"><span class="mo_stle"><?php echo $TPL_V1["mtype"]?></span></li>
				<li class="subject">
					<?php echo $TPL_V1["goods_name"]?>

<?php if($TPL_V1["item_cnt"]> 1){?><span class="pointcolor2">외 <?php echo $TPL_V1["item_cnt"]- 1?>건</span><?php }?>
				</li>
				<li class="grow mo_r" style="order:2;">
<?php if($TPL_V1["mrefund_date"]){?><span class="motle">환불완료일:</span><?php }?>
					<?php echo $TPL_V1["mrefund_date"]?>

				</li>
				<li style="order:1;">
					<span class="motle">상태:</span> <span class="pointcolor"><?php echo $TPL_V1["mstatus"]?></span> &nbsp;
					<a href="/mypage/myqna_write?category=<?php echo urlencode('환불문의')?>" class="btn_resp mo_adj" hrefOri='L215cGFnZS9teXFuYV93cml0ZT9jYXRlZ29yeT17PXVybGVuY29kZSg=' >문의</a>
				</li>
			</ul>
<?php }}?>
		</div>
<?php }?>

<?php if($TPL_VAR["page"]["totalpage"]> 1){?>
		<div class="paging_navigation">
<?php if($TPL_VAR["page"]["first"]){?><a href="?page=<?php echo $TPL_VAR["page"]["first"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="first" hrefOri='P3BhZ2U9e3BhZ2UuZmlyc3R9JmFtcDt7cGFnZS5xdWVyeXN0cmluZ30=' >◀ 처음</a><?php }?>
<?php if($TPL_VAR["page"]["prev"]){?><a href="?page=<?php echo $TPL_VAR["page"]["prev"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="prev" hrefOri='P3BhZ2U9e3BhZ2UucHJldn0mYW1wO3twYWdlLnF1ZXJ5c3RyaW5nfQ==' >◀ 이전</a><?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
			<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="on" hrefOri='P3BhZ2U9ey52YWx1ZV99JmFtcDt7cGFnZS5xdWVyeXN0cmluZ30=' ><?php echo $TPL_V1?></a>
<?php }else{?>
			<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" hrefOri='P3BhZ2U9ey52YWx1ZV99JmFtcDt7cGFnZS5xdWVyeXN0cmluZ30=' ><?php echo $TPL_V1?></a>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?><a href="?page=<?php echo $TPL_VAR["page"]["next"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="next" hrefOri='P3BhZ2U9e3BhZ2UubmV4dH0mYW1wO3twYWdlLnF1ZXJ5c3RyaW5nfQ==' >다음 ▶</a><?php }?>
<?php if($TPL_VAR["page"]["last"]){?><a href="?page=<?php echo $TPL_VAR["page"]["last"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="last" hrefOri='P3BhZ2U9e3BhZ2UubGFzdH0mYW1wO3twYWdlLnF1ZXJ5c3RyaW5nfQ==' >마지막 ▶</a><?php }?>
		</div>
<?php }?>


		<h3 class="title_sub1">환불 절차</h3>
		<ol class="step_type1">
			<li>
				<p class="tle"><span class="num">1</span> 환불신청</p>
				<p class="cont">고객님의 환불신청이 접수되었습니다.</p>
			</li>
			<li>
				<p class="tle"><span class="num">2</span> 환불처리중</p>
				<p class="cont">고객님의 환불건을 처리중입니다.</p>
			</li>
			<li>
				<p class="tle"><span class="num">3</span> 환불완료</p>
				<p class="cont">고객님께 환불해드렸습니다.</p>
			</li>
		</ol>


	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->