<?php /* Template_ 2.2.6 2020/12/29 16:40:31 /www/music_brother_firstmall_kr/admin/skin/default/board/npayqna_view.html 000011638 */ 
$TPL_reviewcategorylist_1=empty($TPL_VAR["reviewcategorylist"])||!is_array($TPL_VAR["reviewcategorylist"])?0:count($TPL_VAR["reviewcategorylist"]);
$TPL_filelist_1=empty($TPL_VAR["filelist"])||!is_array($TPL_VAR["filelist"])?0:count($TPL_VAR["filelist"]);
$TPL_bulkorder_sub_1=empty($TPL_VAR["bulkorder_sub"])||!is_array($TPL_VAR["bulkorder_sub"])?0:count($TPL_VAR["bulkorder_sub"]);?>
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
<?php if($TPL_reviewcategorylist_1){foreach($TPL_VAR["reviewcategorylist"] as $TPL_K1=>$TPL_V1){?>
				<tr>
					<th><?php echo $TPL_V1["title"]?></th>
					<td><?php if($TPL_V1["score"]){?><?php echo getGoodsScore($TPL_V1["score"],$TPL_VAR["managerview"],'view',$TPL_V1["idx"])?><?php }else{?>0<?php }?></td>
<?php if($TPL_K1=== 0){?>
					<th>구매여부</th>
					<td><?php echo $TPL_VAR["buyertitle"]?></td>
<?php }?>
				</tr>
<?php }}?>
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

<?php if($_GET["id"]=='bulkorder'){?>
		<div class="item-title">작성자 정보</div>
		<table class="table_basic thl">
			<tbody>
<?php if(($TPL_VAR["person_name_title"]&&$TPL_VAR["person_name"])||($TPL_VAR["person_tel1_title"]&&$TPL_VAR["person_tel1"])||($TPL_VAR["person_tel2_title"]&&$TPL_VAR["person_tel2"])||($TPL_VAR["person_email_title"]&&$TPL_VAR["person_email"])||($TPL_VAR["company_title"]&&$TPL_VAR["company"])){?>
				<tr>
					<th>담당자 정보</th>
					<td>
						<p>
<?php if($TPL_VAR["person_name_title"]&&$TPL_VAR["person_name"]){?><span class="han"><?php echo $TPL_VAR["person_name_title"]?></span>:<?php echo $TPL_VAR["person_name"]?><?php }?>
							(
<?php if($TPL_VAR["person_tel1_title"]&&$TPL_VAR["person_tel1"]){?><span class="han"><?php echo $TPL_VAR["person_tel1_title"]?></span>:<?php echo $TPL_VAR["person_tel1"]?> <span class="cell_bar">|</span> <?php }?>
<?php if($TPL_VAR["person_tel2_title"]&&$TPL_VAR["person_tel2"]){?><span class="han"><?php echo $TPL_VAR["person_tel2_title"]?></span>:<?php echo $TPL_VAR["person_tel2"]?> <span class="cell_bar">|</span> <?php }?>
<?php if($TPL_VAR["person_email_title"]&&$TPL_VAR["person_email"]){?><span class="han"><?php echo $TPL_VAR["person_email_title"]?></span>:<?php echo $TPL_VAR["person_email"]?> <?php }?>
							)
						</p>
<?php if($TPL_VAR["company_title"]&&$TPL_VAR["company"]){?>
						<p>
							<span class="han"><?php echo $TPL_VAR["company_title"]?></span>:<?php echo $TPL_VAR["company"]?>

						</p>
<?php }?>
					</td>
				</tr>
<?php }?>
<?php if(strstr($TPL_VAR["managerview"]["bulk_show"],'[goods]')&&$TPL_VAR["managerview"]["bulk_totprice"]){?>
				<tr>
					<th>희망 구매 가격</th>
					<td><?php echo $TPL_VAR["total_price"]?></td>
				</tr>
<?php }?>

				<tr>
					<th>기타 정보</th>
					<td>
<?php if(strstr($TPL_VAR["managerview"]["bulk_show"],'[payment]')){?>
						<span class="han">결제수단:</span>
<?php if($TPL_VAR["payment"]=='bank'){?>무통장
<?php }elseif($TPL_VAR["payment"]=='card'){?>카드결제
<?php }elseif($TPL_VAR["payment"]=='account'){?>실시간계좌이체
<?php }elseif($TPL_VAR["payment"]=='cellphone'){?>핸드폰결제
<?php }elseif($TPL_VAR["payment"]=='virtual'){?>가상계좌
<?php }?>
							,
<?php }?>
<?php if($TPL_VAR["shipping_date_title"]&&$TPL_VAR["shipping_date"]){?>
						<span class="han">배송예정 희망일</span> : <?php echo $TPL_VAR["shipping_date"]?>

							,
<?php }?>

<?php if(strstr($TPL_VAR["managerview"]["bulk_show"],'[typereceipt]')){?>
						<span class="han">매출증빙:</span>
<?php if($TPL_VAR["typereceipt"]== 2){?>현금영수증
<?php }elseif($TPL_VAR["typereceipt"]== 1){?>세금계산서
<?php }else{?>발급안함
<?php }?>
<?php }?>
					</td>
				</tr>
		
<?php if($TPL_VAR["bulkorder_sub"]){?>
				<tr>
					<th>추가 정보</th>
					<td>
						<div class="view-content">
<?php if($TPL_bulkorder_sub_1){foreach($TPL_VAR["bulkorder_sub"] as $TPL_V1){?>
<?php if($TPL_V1["used"]=='Y'){?>
							<?php echo $TPL_V1["label_title"]?> :  <?php echo $TPL_V1["label_view"]?><br>
<?php }?>
<?php }}?>
						</div>
					</td>
				</tr>
<?php }?>
			</tbody>
		</table>
<?php }?>

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
	{# 네이버페이는 답변 수정 불가 #}
<?php if($TPL_VAR["display"]== 0&&$TPL_VAR["replylay"]=='Y'&&!$TPL_VAR["re_contents"]){?><button type="button" name="boad_reply_btn" board_seq="<?php echo $TPL_VAR["seq"]?>" board_id="<?php echo $TPL_VAR["boardid"]?>" class="resp_btn size_XL active">답변 <?php if($TPL_VAR["re_contents"]){?>수정<?php }else{?>등록<?php }?></button><?php }?>
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