<?php /* Template_ 2.2.6 2022/05/30 15:13:18 /www/music_brother_firstmall_kr/admin/skin/default/member/dormancy_catalog.html 000003280 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	$(function(){
		$("#display_quantity").on("change", function(){
			$("#memberForm").submit();
		});
		// SMS
		$(".smsBtn").click(function(){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }else{?>
			var screenWidth;
			var screenHeight;

			screenWidth = 1200;
			screenHeight = 800;
			
			window.open('../member/sms_form_dormancy',"sms_form_dormancy","menubar=no, toolbar=no, location=yes, status=no, resizble=yes, scrollbars=yes,width=" + screenWidth + ", height=" + screenHeight);
<?php }?>
		});
		// email
		$(".emailBtn").click(function(){
<?php if(!$TPL_VAR["auth_send"]){?>
			alert("권한이 없습니다.");
			return;
<?php }else{?>
			var screenWidth;
			var screenHeight;

			screenWidth = 1200;
			screenHeight =  $( window ).height();	
			
			window.open('../member/email_form_dormancy',"email_form_dormancy","menubar=no, toolbar=no, location=yes, status=no, resizble=yes, scrollbars=yes,width=" + screenWidth + ", height=" + screenHeight);
<?php }?>
		});
	});
</script>
<style>
	.footer.search_btn_lay button{width: auto;background-color: white; border: 1px solid gray; height: 30px;}
	.footer.search_btn_lay button span{color: #959595;}
	/*.resp_btn.active{color: #3090d6; border: 1px solid rgb(48, 144, 214) !important;}*/
	.search_btn_lay .sc_edit{position: relative;}
	.search_btn_lay .detail, .search_btn_lay .default{position: relative;}
	.resp_btn.size_XL{line-height: inherit;}
	.contents_container{width: 1400px; margin: auto;}
	.table_search{width: 1400px !important;}
	.footer.search_btn_lay{top:auto; left: calc(50% - 50px) !important;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
     <div id="page-title-bar">         
          <!-- 타이틀 -->
          <div class="page-title">
               <h2>휴면 처리 리스트</h2>
          </div>
     </div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->
<div id="search_container" class="contents_container">
	<form name="memberForm" id="memberForm" class='search_form'>
	<input type="hidden" name="member_seq" />
	<input type="hidden" name="orderby" value="<?php echo $TPL_VAR["sc"]["orderby"]?>" defaultValue="<?php echo $TPL_VAR["sc"]["orderby"]?>"/>
	<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sc"]["sort"]?>" defaultValue="<?php echo $TPL_VAR["sc"]["sort"]?>"/>
	<input type="hidden" name="searchcount" value="<?php echo $TPL_VAR["sc"]["searchcount"]?>"/>
	<input type="hidden" name="type" />
	<input type="hidden" name="perpage"  id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" />
	<input type="hidden" name="query_string" value="<?php echo $TPL_VAR["query_string"]?>"/>
<?php $this->print_("dormancy_search",$TPL_SCP,1);?>

<?php $this->print_("dormancy_list",$TPL_SCP,1);?>

		<!-- 페이징 -->
		<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
	</form>
</div>

<div>
<iframe name="container" id="container" style="display:none;width:100%;" frameborder="0"></iframe>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>