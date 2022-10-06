<?php /* Template_ 2.2.6 2022/05/17 12:30:54 /www/music_brother_firstmall_kr/admin/skin/default/board/mbqna_view.html 000011057 */ 
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);?>
<?php if($_GET["mainview"]){?>
<script type="text/javascript">
var boardlistsurl = '<?php echo $TPL_VAR["boardurl"]->lists?>';
var boardwriteurl = '<?php echo $TPL_VAR["boardurl"]->write?>';
var boardviewurl = '<?php echo $TPL_VAR["boardurl"]->view?>';
var boardmodifyurl = '<?php echo $TPL_VAR["boardurl"]->modify?>';
var boardreplyurl = '<?php echo $TPL_VAR["boardurl"]->reply?>';
</script>
<?php }?>
<div class="content">
	<form name="form1" id="form1" method="post" action="/admin/board_process" target="actionFrame">
		<input type="hidden" name="mode" id="mode" value="<?php echo $TPL_VAR["mode"]?>">
		<input type="hidden" name="board_id" id="board_id" value="<?php echo $_GET["id"]?>">
		<input type="hidden" name="reply" id="reply" value="<?php echo $_GET["reply"]?>">
<?php if($TPL_VAR["seq"]){?>
		<input type="hidden" name="seq" id="board_seq" value="<?php echo $TPL_VAR["seq"]?>">
<?php }?>
		<input type="hidden" name="popup" value="<?php echo $_GET["popup"]?>">
		<input type="hidden" name="iframe" value="<?php echo $_GET["iframe"]?>">
		<input type="hidden" name="goods_seq" value="<?php echo $_GET["goods_seq"]?>">
		<div class="item-title">
			<span>게시글</span>
			<span class="fr">
<?php if($TPL_VAR["display"]== 0){?>
				<button type="button" name="boad_modify_btn" board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="resp_btn v2">게시글 수정</button>
<?php }?>
<?php if($TPL_VAR["display"]== 0||($TPL_VAR["display"]== 1&&$TPL_VAR["replyor"]== 0&&$TPL_VAR["comment"]== 0)){?>
				<button type="button" name="boad_delete_btn" board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="resp_btn v3">게시글 삭제</button>
<?php }?>
			</span>
		</div>
		<table class="table_basic thl">
			<tbody>
				<tr>
					<th>작성자</th>
					<td<?php if($TPL_VAR["emoneylay"]||$TPL_VAR["emoneyviewlay"]){?><?php }else{?> colspan="3"<?php }?>><?php echo $TPL_VAR["name"]?> (IP:<?php echo $TPL_VAR["ip"]?>)</td>
<?php if($TPL_VAR["emoneylay"]||$TPL_VAR["emoneyviewlay"]){?>
					<th>캐시</th>
					<td><?php if($TPL_VAR["emoneylay"]){?><?php echo $TPL_VAR["emoneylay"]?><?php }?><?php if($TPL_VAR["emoneyviewlay"]){?><?php echo $TPL_VAR["emoneyviewlay"]?><?php }?></td>
<?php }?>
				</tr>
				<tr>
					<th>날짜</th>
					<td><?php echo $TPL_VAR["m_date"]?></td>
					<th>조회</th>
					<td><?php echo number_format($TPL_VAR["hit"])?></td>
				</tr>
				<tr>
					<th>제목</th>
					<td colspan="3"><?php if($TPL_VAR["datacategory"]){?>[<?php echo $TPL_VAR["datacategory"]?>]<?php }?><?php echo $TPL_VAR["iconmobile"]?> <?php echo $TPL_VAR["subject"]?> <?php echo $TPL_VAR["iconnew"]?> <?php echo $TPL_VAR["iconhot"]?> <?php echo $TPL_VAR["iconhidden"]?></td>
				</tr>
				<tr>
					<th>내용</th>
					<td colspan="3">
						<div class="view-content"><?php echo $TPL_VAR["contents"]?></div>
<?php if($TPL_VAR["managerview"]["auth_recommend_use"]=='Y'){?>
						<div class="scorelay"><?php $this->print_("scoreskin",$TPL_SCP,1);?></div>
<?php }?>
					</td>
				</tr>
<?php if($TPL_VAR["filelist"]){?>
				<tr>
					<th>첨부 파일</th>
					<td colspan="3">
<?php if($TPL_filelist_1){foreach($TPL_VAR["filelist"] as $TPL_V1){?>
						<p>
							<a href="../board_process?mode=board_file_down&board_id=<?php echo $TPL_VAR["boardid"]?>&realfiledir=<?php echo $TPL_V1["realfiledir"]?>&realfilename=<?php echo $TPL_V1["orignfile"]?>" download onclick="return confirm('다운로드하시겠습니까?')"><?php echo $TPL_V1["orignfile"]?></a>
							<span>(<?php echo $TPL_V1["realsizefile"]?>)</span>
						</p>
<?php }}?>
					</td>
				</tr>
<?php }?>
			</tbody>
		</table>

<?php if($TPL_VAR["re_contents"]){?>
		<div class="item-title">답변</div>
		<table class="table_basic thl">
			<tbody>
				<tr>
					<th>작성자</th>
					<td><?php echo $TPL_VAR["replymanagerview"]["writetitle"]?></td>
				</tr>
<?php /* Todo: 날짜누락 기획 확인필요
				<tr>
					<th>날짜</th>
					<td> $TPL_VAR["re_date"]</td>
				</tr>
*/ ?>
				<tr>
					<th>제목</th>
					<td><?php echo $TPL_VAR["re_subject"]?></td>
				</tr>
				<tr>
					<th>내용</th>
					<td><?php echo $TPL_VAR["re_contents"]?></td>
				</tr>
			</tbody>
		</table>
<?php }?>
<?php /*
	<table class="bbsview_table_style" style="width:100%" cellpadding="0" cellspacing="0" border="0">
	<colgroup>
		<col><col width="300px"/>
	</colgroup>
	<thead>
	<tr>
		<th class="left pdl5 pdt5 pdb5"><!--{? datacategory }-->[ $TPL_VAR["datacategory"]]<!--{/}--><b> $TPL_VAR["iconmobile"]  $TPL_VAR["subject"]  $TPL_VAR["iconnew"]  $TPL_VAR["iconhot"]  $TPL_VAR["iconhidden"]</b></th>
		<th class="right">
		</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td class="cell" colspan="2">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="5"></td>
				<td>
					<table align="right" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td><span class="fl"><span class="han">작성자</span> :&nbsp;</span><span class="fl"> $TPL_VAR["name"]</span></td>
						<!--{ ? email }--><td class="cell_bar">|</td><td><span class="han">이메일</span> :  $TPL_VAR["email"]</td><!--{/}-->
						<!--{ ? tel1 }--><td class="cell_bar">|</td><td><span class="han">휴대폰</span> :  $TPL_VAR["tel1"]</td><!--{/}-->
						<!--{ ? emoneyviewlay }--><td class="cell_bar">|</td><td><span class="han">캐시</span> : <span class="num"> $TPL_VAR["emoneyviewlay"]</span></td><!--{/}-->
						<td class="cell_bar">|</td><td><span class="han">IP</span> :  $TPL_VAR["ip"]</td>
						<td class="cell_bar">|</td><td><span class="han">조회:</span> <span class="num"> number_format($TPL_VAR["hit"])</span></td>
						<td class="cell_bar">|</td><td><span class="han">날짜:</span> <span class="num"> $TPL_VAR["m_date"]</span></td>
						<!--{ ? order_seq }--><td class="cell_bar">|</td><td><span class="han orderview " order_seq=" $TPL_VAR["order_seq"]">주문번호</span> : <span class="hand orderview blue bold" order_seq=" $TPL_VAR["order_seq"]"> $TPL_VAR["order_seq"]</span></td><!--{/}-->
					</tr>
					</table>
				</td>
				<td width="5"></td>
			</tr>
			</table>
			<div class="cboth"></div>
		</td>
	</tr>

	<!--{? goodsview }-->
	<tr>
		<td class="cell" colspan="2">
			<div class="view-content">
				 $TPL_VAR["goodsview"]
			</div>
		</td>
	</tr>
	<!--{/}-->

	<!--{? filelist}-->
	<tr>
		<td class="cell " colspan="2">
			<div class="attach ">
				<ul>
						<!--{@ fileliforeach($TPL_VAR["filelist"] as $TPL_V1){?>}-->
						<li class="left pdl5 pdt5"><span class="realfilelist hand " realfiledir=" $TPL_V1["realfiledir"]" realfilename=" $TPL_V1["orignfile"]" board_id=" $TPL_VAR["boardid"]" filedown="../board_process?mode=board_file_down&board_id= $TPL_VAR["boardid"]&realfiledir= $TPL_V1["realfiledir"]&realfilename= $TPL_V1["orignfile"]"><span class="highlight-link"> $TPL_V1["orignfile"]</span> <span class="size">( $TPL_V1["realsizefile"])</span> <button type="button" class="bbs_btn">down</button></span></li>
						<!--{/}-->
				</ul>
			</div>
		</td>
	</tr>
	<!--{/}-->
	</tbody>
	</table>

	<div class="view-content">
		 $TPL_VAR["contents"]
		<!--{? re_contents }-->
			<div class="reply">
				<div class="sbj_writer">
					<img src="/admin/skin/default/images/common/icon/icon_answer.png" style="vertical-align:middle">  $TPL_VAR["replymanagerview"]["writetitle"] ( $TPL_VAR["re_date"])
				</div>
				<div class="sbj">
				 $TPL_VAR["re_subject"]
				</div>
				 $TPL_VAR["re_contents"]
			</div>
		<!--{/}-->
	</div>
	</form>

	<!--{? managerview.auth_recommend_use == 'Y' }-->
	<!-- 게시글평가 -->
	<div class="scorelay" style="margin: 15px 0 5px">{#scoreskin}</div>
	<!-- 게시글평가 -->
	<!--{/}-->  

	<!--{? commentlay == 'Y' || comment > 0 // 댓글 사용여부, 댓글수 }-->
		<!-- 코멘트부분 -->
		<a name="cmtlist"></a>
		<div class="comment" id="comment_container" style="margin: 15px 0 5px">{#commentskin}</div>
		<!-- 코멘트부분 -->
	<!--{/}-->

	<!-- 이전/다음 -->
	<div id="prenextlist" style="margin: 15px 0 5px">{#prenextskin}</div>
	<!-- 이전/다음 -->
*/ ?>
</div>
<div class="footer">
<?php if($TPL_VAR["display"]== 0){?><button type="button" name="boad_reply_btn" board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="resp_btn size_XL active">답변 <?php if($TPL_VAR["re_contents"]){?>수정<?php }else{?>등록<?php }?></button><?php }?>
	<button class="resp_btn v3 size_XL" type="reset" onclick="$(this).closest('.ui-dialog').find('.ui-dialog-content').dialog('close')">닫기</button>
</div>

<!-- 댓글관리 start -->
<script type="text/javascript">
//<![CDATA[


//체크박스 색상
$("input[type='checkbox'][name='cmtdel[]']").live('change',function(){
	var cmtseq = $(this).val();
	var cmttype = $(this).attr('cmt');

	if($(this).is(':checked')){
		$(this).closest('tr').addClass('checked-tr-background');
		if(cmttype == 'reply'){
			$('.replycmtcontent'+cmtseq).addClass('checked-tr-background');
		}else{
			$('.cmtcontent'+cmtseq).addClass('checked-tr-background');
		}
	}else{
		$(this).closest('tr').removeClass('checked-tr-background');
		if(cmttype == 'reply'){
			$('.replycmtcontent'+cmtseq).removeClass('checked-tr-background');
		}else{
			$('.cmtcontent'+cmtseq).removeClass('checked-tr-background');
		}
	}
}).change();

$(document).ready(function() {


	$(".orderview").click(function(){
		var order_seq = $(this).attr("order_seq");
		var href = "/admin/order/view?no="+order_seq;
		var a = window.open(href, 'orderdetail'+order_seq, '');
		if ( a ) {
			a.focus();
		}
	});



});

function getboardLogin(){
<?php if(defined('__ISUSER__')===true){?>
		openDialogAlert('해당 서비스를 이용하시려면 관리자에게 문의하여 주시길 바랍니다.','450','140');
<?php }else{?>
		openDialogConfirm('이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?','400','140',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
}

function getcmtMbLogin(){
<?php if(defined('__ISUSER__')===true){?>
		openDialogAlert('글작성자만 이용가능합니다.','450','140');
<?php }else{?>
		openDialogConfirm('이용하시려면 로그인이 필요합니다!<br/>로그인하시겠습니까?','400','140',function(){location.href="/member/login?return_url=<?php echo urlencode($_SERVER["REQUEST_URI"])?>";},function(){});
<?php }?>
}

//]]>
</script>
<!-- 댓글관리 end  -->

<script type="text/javascript">
$(".content img").load(function() {
	//이미지 가로가 큰경우
	$(".content img").each(function() {
		var default_width = '600';
		if( $(this).width() > default_width || $(this).height() > default_width ) {
			imageResize(this);
		}
	});
});
</script>