<?php /* Template_ 2.2.6 2020/10/15 17:39:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/joincheck/comment_basic.html 000005856 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ "출석체크" 댓글 - Basic형 @@
- 파일위치 : [스킨폴더]/joincheck/comment_basic.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="search_nav">
	<a class="home" href="/main/index" hrefOri='L21haW4vaW5kZXg=' >홈</a>
	<a class="navi_linemap" href="/promotion/event" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9qb2luY2hlY2svY29tbWVudF9iYXNpYy5odG1s" hrefOri='L3Byb21vdGlvbi9ldmVudA==' >이벤트</a>
	<span class="navi_linemap searched_text"><?php echo $TPL_VAR["joincheck"]["title"]?></span>
</div>

<div class="resp_event_dlist">
	<ul>
		<li>
			<span class="title" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9qb2luY2hlY2svY29tbWVudF9iYXNpYy5odG1s" >진행기간</span>
			<span class="detail"><span class="point"><?php echo $TPL_VAR["joincheck"]["start_date"]?> ~ <?php echo $TPL_VAR["joincheck"]["end_date"]?></span></span>
		</li>
		<li>
			<span class="title" designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9qb2luY2hlY2svY29tbWVudF9iYXNpYy5odG1s" >이벤트 조건</span>
			<span class="detail">이벤트 기간 중 <span class="point">총 <?php echo $TPL_VAR["joincheck"]["check_clear_count"]?>회 <?php echo $TPL_VAR["joincheck"]["mclear_type"]?> 출석</span> 하는 경우</span>
		</li>
		<li>
			<span class="title" designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9qb2luY2hlY2svY29tbWVudF9iYXNpYy5odG1s" >이벤트 혜택</span> 
			<span class="detail">마일리지 <span class="point"><?php echo get_currency_price($TPL_VAR["joincheck"]["emoney"], 2)?></span> <?php if($TPL_VAR["joincheck"]["point"]> 0){?> / 포인트 <span class="point"><?php echo number_format($TPL_VAR["joincheck"]["point"])?>P</span><?php }?> 지급</span>
		</li>
		<li>
			<span class="title" designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9qb2luY2hlY2svY29tbWVudF9iYXNpYy5odG1s" >참여 방법</span>
			<span class="detail"><?php echo $TPL_VAR["mdata"]["type_ment"]?> 1일 1회 자동 참여</span>
		</li>
	</ul>
</div>

<?php if($TPL_VAR["minfo"]["member_seq"]){?>
<div class="resp_event_status1">
	<?php echo $TPL_VAR["minfo"]["user_name"]?>님께서는 현재 총 <span class="pointcolor"><?php echo $TPL_VAR["mdata"]["acount"]?>일</span> 출석하였습니다.
<?php if($TPL_VAR["mdata"]["chage"]== 0){?>(목표를 달성하셨습니다.)<?php }else{?>(<?php if($TPL_VAR["joincheck"]["check_clear_type"]=='straight'){?><span class="pointcolor"><?php echo $TPL_VAR["mdata"]["chage"]?>번</span> 더 연속으로<?php }else{?>해당 기간 내에 <span class="pointcolor"><?php echo $TPL_VAR["mdata"]["chage"]?>번</span> 더<?php }?> 출석을 하셔야 합니다.)<?php }?></span>
	<button type="button" id="mylog" name="mylog" class="btn_resp size_a Ml4" onclick="my_log('<?php echo $TPL_VAR["joincheck"]["joincheck_seq"]?>','mylog')">내가쓴 댓글</button>
</div>
<?php }?>

<div class="resp_joincheck">
	<form name="jcwrite" id="jcwrite" method="post" enctype="multipart/form-data" onsubmit="return sub_wrt_btn()" >
		<input type='hidden' name='mode' value='comment_wrt'>
		<input type="hidden" name="joincheck_seq" value="<?php echo $TPL_VAR["joincheck"]["joincheck_seq"]?>" />
		<input type="hidden" name="member_seq" value="<?php echo $TPL_VAR["minfo"]["member_seq"]?>" />
		<div class="resp_joincheck_reply">
			<ul>
				<li><textarea name='comment' title="댓글을 입력하세요" class="reply_input"></textarea></li>
				<li class="btns"><button name='comment_wrt_btn' id='comment_wrt_btn' class="btn_reply_reg">댓글등록</button></li>
			</ul>
		</div>
	</form>

	<div class="joincheck_month Mt30">
		<span class="prev"><?php echo $TPL_VAR["joincheck"]["prev_day"]?></span>
		<?php echo $TPL_VAR["joincheck"]["tdate"]?>

		<span class="next"><?php echo $TPL_VAR["joincheck"]["next_day"]?></span>
	</div>

<?php if($TPL_VAR["record"]){?>
	<ul class="resp_reply_contents">
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
		<li>
			<ul>
				<li class="head"><?php echo $TPL_V1["user_name"]?>(<?php echo $TPL_V1["userid"]?>) &nbsp; <?php echo $TPL_V1["regist_date"]?></li>
				<li class="cont"><?php echo $TPL_V1["check_comment"]?></li>
			</ul>
		</li>
<?php }}?>
	</ul>
<?php }else{?>
	<div class="no_data_area2">
		현재 등록된 댓글이 존재하지 않습니다.
	</div>
<?php }?>

	<!-- 페이징 -->
	<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

</div>



<iframe name="actionFrame" src="/data/index.php" frameborder="0" width="100%" height="0"></iframe>

<script type="text/javascript">
function sub_wrt_btn(){
	var setform = document.jcwrite;
	var minfo_seq = setform.member_seq.value;
	if(!minfo_seq){
		//로그인 후 참여 가능합니다.
		alert(getAlert('mb233'));
		location.href="/member/login";
		return false;
	}else{
		var scomment = setform.comment.value; //.replace(/\s/g,"");
		var ccomment = setform.comment.value.replace(/\s/g,"");

		if(!ccomment || scomment == setform.comment.getAttribute('title')){
			//댓글을 입력해주세요.
			alert(getAlert('mb234'));
			setform.comment.focus();
			return false;
		}else{
		setform.action="../joincheck_process";
		setform.target="actionFrame";
		}
	}
}

function my_log(seq,mode){
	location.href="?seq="+seq+"&mode="+mode;
}
</script>