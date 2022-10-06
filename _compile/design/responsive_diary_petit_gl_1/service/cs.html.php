<?php /* Template_ 2.2.6 2021/01/08 12:01:44 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/service/cs.html 000006101 */  $this->include_("getBoarddata");?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 고객센터( CS CENTER ) 메인 @@
- 파일위치 : [스킨폴더]/service/cs.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div id="boardlayout" >
	<div class="subpage_wrap">
		<!-- +++++ cscenter LNB ++++ -->
		<div id="subpageLNB" class="subpage_lnb">
			<!-- ------- 고객센터 LNB 인클루드. 파일위치 : [스킨폴더]/_modules/common/board_lnb.html ------- -->
<?php $this->print_("board_lnb",$TPL_SCP,1);?>

			<!-- ------- //고객센터 LNB 인클루드 ------- -->
		</div>

		<!-- +++++ cscenter contents ++++ -->
		<div class="subpage_container">
			<!-- 전체 메뉴 -->
			<a id="subAllButton" class="btn_sub_all" href="javascript:void(0)" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3NlcnZpY2UvY3MuaHRtbA==" hrefOri='amF2YXNjcmlwdDp2b2lkKDAp' >MENU</a>

			<!-- -->
			<div class="cs_top2 mycs_fcont_margin">
				<a class="menu2" href="/mypage/myqna_catalog" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3NlcnZpY2UvY3MuaHRtbA==" hrefOri='L215cGFnZS9teXFuYV9jYXRhbG9n' ><span class="area"><span class="text2">배송문의</span></span></a>
				<a class="menu3" href="/mypage/myqna_catalog" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3NlcnZpY2UvY3MuaHRtbA==" hrefOri='L215cGFnZS9teXFuYV9jYXRhbG9n' ><span class="area"><span class="text2">반품/교환문의</span></span></a>
				<a class="menu1" href="/board/?id=goods_qna" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3NlcnZpY2UvY3MuaHRtbA==" hrefOri='L2JvYXJkLz9pZD1nb29kc19xbmE=' ><span class="area"><span class="text2">상품문의</span></span></a>
				<a class="menu9" href="/mypage/coupon" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3NlcnZpY2UvY3MuaHRtbA==" hrefOri='L215cGFnZS9jb3Vwb24=' ><span class="area"><span class="text2">쿠폰내역</span></span></a>
				<a class="menu10" href="/mypage/emoney" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3NlcnZpY2UvY3MuaHRtbA==" hrefOri='L215cGFnZS9lbW9uZXk=' ><span class="area"><span class="text2">캐시내역</span></span></a>
				<a class="menu5" href="/board/?id=faq" designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3NlcnZpY2UvY3MuaHRtbA==" hrefOri='L2JvYXJkLz9pZD1mYXE=' ><span class="area"><span class="text2">자주묻는질문</span></span></a>
			</div>

			<!-- 타이틀 -->
			<div class="title_container2">
				<h3 class="title_sub6"><span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3NlcnZpY2UvY3MuaHRtbA==" >자주 묻는 질문</span> <span class="top5" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3NlcnZpY2UvY3MuaHRtbA==" >TOP5</span></h3>
				<a class="btn_thebogi" href="/board/?id=faq" designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3NlcnZpY2UvY3MuaHRtbA==" hrefOri='L2JvYXJkLz9pZD1mYXE=' >더보기</a>
			</div>
			
<?php if(getBoardData('faq','5')){?>
			<ul class="faq_new v2">
<?php if(is_array($TPL_R1=getBoardData('faq','5'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<li>
					<div class="question">
						<p class="subject pointer boad_faqview_btn" board_seq="<?php echo $TPL_V1["seq"]?>"><?php echo $TPL_V1["category"]?> <?php echo $TPL_V1["subject_real"]?> <?php echo $TPL_V1["iconnew"]?> <?php echo $TPL_V1["iconhot"]?> <?php echo $TPL_V1["iconfile"]?> <?php echo $TPL_V1["iconhidden"]?></p>
						<p class="add_info">
							<span class="hide">번호:  <?php echo $TPL_V1["number"]?></span>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[writer]')){?>작성자: <?php echo $TPL_V1["name"]?><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[date]')){?>등록일: <?php echo $TPL_V1["date"]?><?php }?>
<?php if(strstr($TPL_VAR["manager"]["list_show"],'[hit]')){?>조회수: <?php echo $TPL_V1["hit"]?><?php }?>
						</p>
					</div>
					<div id="faqcontent_<?php echo $TPL_V1["seq"]?>" class="answer <?php if($_GET["seq"]!=$TPL_V1["seq"]){?>hide<?php }?>">								
						<?php echo $TPL_V1["contents_real"]?>

					</div>
				</li>
<?php }}?>
			</ul>
			<script type="text/javascript">
			// FAQ 게시글 보기
			$('.boad_faqview_btn').on('click', function() { 
				var board_seq = $(this).attr('board_seq');
				$("#faqcontent_"+board_seq).toggle();
			}); 
			</script>
<?php }else{?>
			<div class="no_data_area2">
				등록된 게시글이 없습니다.
			</div>
<?php }?>

<?php if($TPL_VAR["sns"]["ntalk_connect"]=='Y'&&$TPL_VAR["sns"]["ntalk_use"]=='Y'&&$TPL_VAR["sns"]["ntalk_use_mobile_customer"]=='Y'){?>
			<div class="naver_talk_service Mt30">
				<a href="javascript:;" class="btn_navertalk" onclick="window.open('https://talk.naver.com/<?php echo $TPL_VAR["sns"]["ntalk_connect_id"]?>', 'talktalk', 'width=471, height=640');return false;" hrefOri='amF2YXNjcmlwdDo7' ><img src="/data/skin/responsive_diary_petit_gl_1/images/common/icon_naver_talktalk.png" alt="네이버 톡톡" designImgSrcOri='Li4vaW1hZ2VzL2NvbW1vbi9pY29uX25hdmVyX3RhbGt0YWxrLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3NlcnZpY2UvY3MuaHRtbA==' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX2RpYXJ5X3BldGl0X2dsXzEvaW1hZ2VzL2NvbW1vbi9pY29uX25hdmVyX3RhbGt0YWxrLnBuZw==' designElement='image' /> &nbsp; <span designElement="text" textIndex="11"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbF8xL3NlcnZpY2UvY3MuaHRtbA==" >궁금할땐 톡톡하세요</span></a>
			</div>
<?php }?>

		</div>
		<!-- +++++ //cscenter contents ++++ -->
	</div>
	<script type="text/javascript" src="/data/skin/responsive_diary_petit_gl_1/common/cscenter_ui.js"></script><!-- 고객센터 ui 공통 -->

</div>