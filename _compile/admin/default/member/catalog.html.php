<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/member/catalog.html 000006113 */ 
$TPL_group_arr_1=empty($TPL_VAR["group_arr"])||!is_array($TPL_VAR["group_arr"])?0:count($TPL_VAR["group_arr"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/batch.js?v=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/memberList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		gSearchForm.init({'pageid':'member_catalog','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','sc':<?php echo $TPL_VAR["scObj"]?>});
		memberList.init({'auth_arr':'<?php echo $TPL_VAR["auth_arr"]?>'});

		// 회원승인/등급
		$(".gradeForm").on("click", function(){
			grade_reset('open');
			openDialog("회원(승인/등급) 일괄변경<span class='desc'></span>", "grade_form_popup", {"width":"650","show" : "fade","hide" : "fade"});

			//일괄 수정 선택
			setContentsRadio("batch_mode", "member_status");
        });		
        
        $("select[name='grade']").change(function(){
			var grade_name = $(this).find(":selected").text();
			$("input[name='grade_name']").val(grade_name);
		});
	});
</script>

<style>
input[name="member_old_grade_name"]{background:#eee;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
	
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>회원 조회</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div id="search_container">
<form name="memberForm" id="memberForm" class="search_form">
<input type="hidden" name="pageid" value="member_catalog" data-search_mode='<?php echo $TPL_VAR["sc"]["search_mode"]?>' data-select_date='<?php echo $TPL_VAR["sc"]["select_date"]?>' />
<input type="hidden" name="member_seq" />
<input type="hidden" name="orderby" value="<?php echo $TPL_VAR["sc"]["orderby"]?>"/>
<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sc"]["sort"]?>"/>
<input type="hidden" name="searchcount" value="<?php echo $TPL_VAR["sc"]["searchcount"]?>"/>
<input type="hidden" name="type" />
<input type="hidden" name="perpage"  id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" />
<input type="hidden" name="mcount" value="<?php echo $TPL_VAR["sc"]["searchcount"]?>">
<input type="hidden" name="totalcount" value="<?php echo $TPL_VAR["sc"]["totalcount"]?>">
<input type="hidden" name="excel_type" value="all" />
<input type="hidden" name="orderby_disp" value="<?php echo $TPL_VAR["sc"]["orderby_disp"]?>" />
<input type="hidden" name="query_string" value="<?php echo $TPL_VAR["query_string"]?>"/>
<input type="hidden" name="grade_name" value="">

<div class="search_container">
<?php $this->print_("member_search",$TPL_SCP,1);?>

</div> <!-- search_container end -->

<div class="contents_dvs v2">
<?php $this->print_("member_list",$TPL_SCP,1);?>

</div>
<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>

</form>
<!-- 페이징 -->
</div>
<div>
<iframe name="container" id="container" style="display:none;width:100%;" frameborder="0"></iframe>
</div>

<div id="excel_popup" class="hide"></div>
<div id="grade_form_popup" class="hide">
	<form name="gradeForm" id="gradeForm" method="post" target="actionFrame" action="../batch_process/set_grade">
	<input type="hidden" name="mode" value="" />
	<input type="hidden" name="serialize" id="serialize" value=""/>
	<input type="hidden" name="mcount" value="0">
	<input type="hidden" name="member" value="search">
	<input type="hidden" name="searchSelect" value="search">
	<input type="hidden" name="selectMember" value="">
	<input type="hidden" name="wheres" value="status=hold"/>
	<input type="hidden" name="exceldown_mode" id="exceldown_mode">
	
	<table class="table_basic thl">
		<tr>
			<th>일괄 수정 선택</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="batch_mode" value="member_status" checked> 회원 승인</label>
					<label><input type="radio" name="batch_mode" value="member_grade"> 등급 변경</label>
				</div>
			</td>
		</tr>
		<tr>
			<th>대상 회원</th>
			<td>
				<span id="search_member" class='bold'>0</span>명 
				<button type="button" id="searchMemberBtn" callpage="status" class="resp_btn v2">회원 검색</button>
				<span class="resp_btn v3" id="downloadMemberBtn"><img src="/admin/skin/default/images/common/btn_img_ex.gif" /><span>다운로드</span></span>
			</td>
		</tr>

		<tr class="batch_mode_member_grade hide">
			<th>현재 회원 등급</th>
			<td>
				<input type="text" name="member_old_grade_name" size="10" readonly disabled title="">
				<input type="hidden" name="member_old_grade" size="3" readonly >
			</td>
		</tr>

		<tr class="batch_mode_member_grade hide">
			<th>변경 회원 등급</th>
			<td>
				<select name="member_new_grade">
					<option value="">등급 선택</option>
<?php if($TPL_group_arr_1){foreach($TPL_VAR["group_arr"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["group_seq"]?>" <?php if($TPL_VAR["sc"]["grade"]==$TPL_V1["group_seq"]){?>selected<?php }?>><?php echo $TPL_V1["group_name"]?></option>
<?php }}?>
				</select> 
			</td>
		</tr>		
	</table>
	
	<div class="batch_mode_member_status hide">
		<input type="hidden" name="member_status" value="y" >	
	</div>

	</form>
	<div class="footer">
		<button type="button" id="grade_submit" class="resp_btn active size_XL">변경</button>
		<button type="button" class="resp_btn v3 size_XL" onClick="closeDialog('grade_form_popup')">취소</button>
	</div>
</div>

<?php $this->print_("member_download_info",$TPL_SCP,1);?>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>