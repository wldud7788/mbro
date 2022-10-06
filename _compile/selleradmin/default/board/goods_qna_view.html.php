<?php /* Template_ 2.2.6 2022/05/17 12:28:52 /www/music_brother_firstmall_kr/selleradmin/skin/default/board/goods_qna_view.html 000007193 */ 
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
<div class="content" style="margin-bottom:65px">
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
		</div>
		<table class="table_basic thl">
			<tbody>
				<tr>
					<th>작성자</th>
					<td colspan="3"><?php echo $TPL_VAR["name"]?> (IP:<?php echo $TPL_VAR["ip"]?>)</td>
				</tr>
				<tr>
					<th>날짜</th>
					<td><?php echo $TPL_VAR["m_date"]?></td>
					<th>조회</th>
					<td><?php echo number_format($TPL_VAR["hit"])?></td>
				</tr>
<?php if($TPL_VAR["goodsview"]){?>
				<tr>
					<th>상품 정보</th>
					<td colspan="3"><?php echo $TPL_VAR["goodsview"]?></td>
				</tr>
<?php }?>
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
<?php /* Todo: 동영상 기획누락? (관리자UI개선)
				<!--{? file_key_w && uccdomain('fileswf',file_key_w,managerview)}-->
				<tr>
					<td class="cell center" colspan="2">
						<div class="view-content">
							<embed src=" uccdomain('fileswf',$TPL_VAR["file_key_w"],$TPL_VAR["managerview"])" width=" $TPL_VAR["managerview"]["video_size0"]" height=" $TPL_VAR["managerview"]["video_size1"]" allowfullscreen="true" wmode="transparent"></embed>
						</div>
					</td>
				</tr>
				<!--{/}-->
*/ ?>
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
	</form>

<?php if($TPL_VAR["commentlay"]=='Y'||$TPL_VAR["comment"]> 0){?>
	<!-- 코멘트부분 -->
	<a name="cmtlist"></a>
	<div class="comment" id="comment_container" style="margin: 15px 0 5px"><?php $this->print_("commentskin",$TPL_SCP,1);?></div>
	<!-- 코멘트부분 -->
<?php }?>
</div>
<div class="footer">
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["replylay"]=='Y'){?><button type="button" name="boad_reply_btn" board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="resp_btn size_XL active">답변 <?php if($TPL_VAR["re_contents"]){?>수정<?php }else{?>등록<?php }?></button><?php }?>
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