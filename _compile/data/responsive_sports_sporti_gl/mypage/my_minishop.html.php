<?php /* Template_ 2.2.6 2021/12/15 16:50:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/mypage/my_minishop.html 000003897 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 나의 단골 미니샵 @@
- 파일위치 : [스킨폴더]/mypage/my_minishop.html
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
			<h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL215cGFnZS9teV9taW5pc2hvcC5odG1s" >나의 단골 미니샵</span></h2>
		</div>
		<div class="mypage_greeting btm_padding">
			나의 단골 미니샵은 <span class="pointnum"><?php echo number_format($TPL_VAR["page"]["totalcount"])?></span>개 입니다.
		</div>

		<form name="myFrm" method="post" action="/mshop_process/save_memolist" target="actionFrame">
		<input type="hidden" name="mseq" value="<?php echo $TPL_VAR["user"]["member_seq"]?>" />

<?php if($TPL_VAR["page"]["totalcount"]== 0){?>
		<div class="no_data_area2">
			나의 단골 미니샵이 없습니다.
		</div>
<?php }else{?>
		<div class="res_table">
			<ul class="thead">
				<li style="width:180px;">미니샵</li>
				<li>메모</li>
				<li style="width:90px;">등록일</li>
				<li style="width:160px;">관리</li>
			</ul>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
			<ul class="tbody">
				<li class="sjb_top" style="order:-10;">
					<strong class="pointcolor2"><?php echo $TPL_V1["provider_name"]?></strong>( <?php echo $TPL_V1["provider_id"]?> )
				</li>
				<li class="deatil">
					<div class="mowrap3">
						<span class="motle3" style="width:38px;">메모</span>
						<span class="mocont3">
							<textarea name="memo[<?php echo $TPL_V1["provider_seq"]?>]"><?php echo $TPL_V1["memo"]?></textarea>
						</span>
					</div>
				</li>
				<li class="sjb_top grow mo_r" style="order:-9;"><span class="motle">등록일:</span> <?php echo $TPL_V1["regist_date"]?></li>
				<li class="manage">
					<button type="button" shopseq="<?php echo $TPL_V1["provider_seq"]?>" class="goMinishop btn_resp" title="새창">미니샵 바로가기</button>
					<button type="button" shopseq="<?php echo $TPL_V1["provider_seq"]?>" class="delMinishop btn_resp">삭제</button>
				</li>
			</ul>
<?php }}?>
		</div>

		<div class="btn_area_b">
			<button type="submit" class="btn_resp size_c color4">메모저장</button>
		</div>
<?php }?>

	</div>
	<!-- +++++ //mypage contents ++++ -->

</div>

<script type="text/javascript" src="/data/skin/responsive_sports_sporti_gl/common/mypage_ui.js"></script><!-- mypage ui 공통 -->

<script type="text/javascript">
	$(document).ready(function(){
		$(".goMinishop").live("click", function(){
			window.open('../mshop/?m='+$(this).attr("shopseq"));
		});
		$(".delMinishop").live("click", function(){
			//단골 미니샵을 삭제하시겠습니까?
			if	(confirm(getAlert('et059'))){
				$.getJSON("/mshop_process/delete_myshop", {'mseq':'<?php echo $TPL_VAR["user"]["member_seq"]?>', 'shopno':$(this).attr("shopseq")},function(data){
					if	(data.result == 'ok'){
						//삭제되었습니다.
						alert(getAlert('et060'));
						location.reload();
					}
				});
			}
		});
	});
</script>














<!-- 본문내용 시작 -->

<!-- //본문내용 끝 -->