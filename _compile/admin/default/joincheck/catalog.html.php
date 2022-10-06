<?php /* Template_ 2.2.6 2022/05/30 15:48:14 /www/music_brother_firstmall_kr/admin/skin/default/joincheck/catalog.html 000009458 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('YmdHis')?>"></script>
<style type="text/css">
	.footer.search_btn_lay{top: auto; left: calc(50% - 50px);}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		
		gSearchForm.init({'pageid':'joincheck_catalog','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>'});

<?php if($_GET["mode"]=="new"){?>
		//쿠폰신규생성 후 뒤로가기 시 리스트로 이동
		history.pushState(null, null, location.href);
			window.onpopstate = function () {
				document.location.href="/admin/joincheck/catalog";
		};
<?php }?>

		$("div#page-title-bar-area button#joincheckRegist").bind("click",function(){
			location.href = "online";
		});
		
		$("#order_star").click(function(){
			var status = "";
			if($(this).hasClass("checked")){
				$(this).removeClass("checked");
				status = "asc";
			}else{
				$(this).addClass("checked");
				status = "desc";
			}
			location.href = "../joincheck/catalog?orderby=favorite_chk&sort="+status;
		});	
	});

	function jc_copy_btn(seq){	
		var str="../joincheck_process?mode=joincheck_copy&joincheck_seq=" + seq;
		$("iframe[name='actionFrame']").attr('src',str);
	}

	function jc_delete_btn(seq){
		var chk = confirm('정말 삭제하시겠습니까?');
		if(chk == true){
		var str="../joincheck_process?mode=joincheck_delete&joincheck_seq=" + seq;
		$("iframe[name='actionFrame']").attr('src',str);
		
		}else{
			return;
		}
	}

	function jc_view_btn(seq,sz1,sz2){
		var str= "/joincheck/joincheck_view?seq=" + seq;
		popup(str,sz1,sz2);	
	}

	function jc_cpurl_btn(seq){	
		var str= gl_protocol+"<?php echo $_SERVER["HTTP_HOST"]?>/joincheck/joincheck_view?seq="+seq;
		if(window.clipboardData){
			window.clipboardData.setData("TEXT",str);	
			alert("복사되었습니다.");
		}else{
			temp = prompt("Ctrl+C를 눌러 복사하세요", str);
		}	

	}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>출석 체크 이벤트</h2>
		</div>
		
		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button onclick="location.href='regist'" class="resp_btn active2 size_L">이벤트 등록</button></li>
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->


<!-- 출석체크 리스트 검색폼 : 시작 -->
<div id="search_container" class="search_container">
<form name="joincheckForm" id="joincheckForm">
<input type="hidden" name="perpage" id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" >
<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["sc"]["page"]?>" >
	<table class="table_search">
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_keyword" class="hide"></label> 검색어</th>
			<td>				
				<input type="text" name="keyword" value="<?php echo htmlspecialchars($TPL_VAR["sc"]["keyword"])?>"  size="80" />
			</td>
		</tr>
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_event_status" class="hide"></label> 상태</th>
			<td>				
				<div class="resp_radio">
					<label><input type="radio" name="event_status" value="" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['all']?> /> 전체</label>
					<label><input type="radio" name="event_status" value="before" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['before']?>/> 진행 전</label>
					<label><input type="radio" name="event_status" value="ing" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['ing']?>/> 진행 중</label>
					<label><input type="radio" name="event_status" value="end" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['end']?>/> 완료</label>
					<label><input type="radio" name="event_status" value="stop" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['stop']?>/> 중지</label>		
				</div>
			</td>
		</tr>
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_event_type" class="hide"></label> 출석 방법</th>
			<td>				
				<div class="resp_radio">
					<label><input type="radio" name="event_type" value="" <?php echo $TPL_VAR["sc"]['checkbox']['event_type']['all']?> /> 전체</label>
					<label><input type="radio" name="event_type" value="stamp" <?php echo $TPL_VAR["sc"]['checkbox']['event_type']['stamp']?>/> 스템프</label>
					<label><input type="radio" name="event_type" value="comment" <?php echo $TPL_VAR["sc"]['checkbox']['event_type']['comment']?>/> 댓글</label>
					<label><input type="radio" name="event_type" value="login" <?php echo $TPL_VAR["sc"]['checkbox']['event_type']['login']?> /> 로그인</label>	
				</div>
			</td>
		</tr>
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_event_clear_type" class="hide"></label> 달성 조건</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="event_clear_type" value="" <?php echo $TPL_VAR["sc"]['checkbox']['event_clear_type']['all']?> /> 전체</label>
					<label><input type="radio" name="event_clear_type" value="count" <?php echo $TPL_VAR["sc"]['checkbox']['event_clear_type']['count']?>/> 횟수 달성</label>
					<label><input type="radio" name="event_clear_type" value="straight" <?php echo $TPL_VAR["sc"]['checkbox']['event_clear_type']['straight']?>/> 연속 출석</label>					
				</div>
			</td>
		</tr>
	</table>
	<div class="search_btn_lay center mt10 footer"></div>
</form>
</div>
<div class="cboth"></div>
<!-- 출석체크 리스트 검색폼 : 끝 -->

<div class="contents_container">
	<div class="list_info_container">
		<div class="dvs_left">			
			<div class="left-btns-txt">
				검색 <b><?php echo number_format($TPL_VAR["page"]["searchcount"])?></b>개 (총 <b><?php echo number_format($TPL_VAR["page"]["totalcount"])?></b>개) 
			</div>			
		</div>

		<div class="dvs_right"><div class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></div></div>
	</div>

<!-- 출석체크 리스트 테이블 : 시작 -->
		<table class="table_row_basic">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="5%" />
		<col width="18%" />
		<col width="10%" />
		<col width="10%" />
		<col width="10%" />
		<col width="10%" />
		<col width="12%" />
		<col width="10%" />
		<col width="10%" />
		<col width="5%" />
	</colgroup>
			
	<thead>
	<tr>
		<th>번호</th>
		<th>이벤트명</th>
		<th>출석 방법</th>
		<th>달성 조건</th>
		<th>혜택</th>
		<th>시작일/종료일</th>
		<th>현황<br/>(참여/달성/적립)</th>
		<th>이벤트 상태</th>
		<th>관리</th>
		<th>삭제</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody>
<?php if($TPL_VAR["record"]){?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
		<!-- 출석체크 리스트(이벤트상태 및 버튼) : 시작 -->
		<tr>
			<td><?php echo $TPL_V1["_no"]?></td>
			<td class="left"><a href="regist?joincheck_seq=<?php echo $TPL_V1["joincheck_seq"]?>" class="resp_btn_txt v2"><?php echo $TPL_V1["title"]?></a></td>
			<td><?php echo $TPL_V1["mcheck_type"]?></td>
			<td><?php echo $TPL_V1["mcheck_clear_type"]?> <?php echo $TPL_V1["check_clear_count"]?>회</td>
			<td><?php if($TPL_V1["emoney"]> 0){?>캐시 <?php echo get_currency_price($TPL_V1["emoney"], 2)?> 지급<?php }?><br /><?php if($TPL_V1["point"]> 0){?>포인트 <?php echo get_currency_price($TPL_V1["point"])?>p 지급<?php }?></td>
			<td><?php echo $TPL_V1["start_date"]?><br /><?php echo $TPL_V1["end_date"]?></td>
			<td>
				<?php echo $TPL_V1["sum_count"]?> / <?php echo $TPL_V1["sum_clear"]?> / <?php echo $TPL_V1["sum_emoney"]?><br>
				<button type="button" class="resp_btn v2" onclick="window.open('memberlist?joincheck_seq=<?php echo $TPL_V1["joincheck_seq"]?>&title=<?php echo $TPL_V1["title"]?>','window_name','width=1100,height=800,location=no,status=no,scrollbars=yes');">조회</button>
			</td>
			<td><?php echo $TPL_V1["status"]?></td>				
			<td>
				<input type="button" name="manager_modify_btn" value="수정" class="resp_btn v2" onclick="location.href='regist?joincheck_seq=<?php echo $TPL_V1["joincheck_seq"]?>'" />
				<input type="button" name="manager_copy_btn"  value="복사" class="resp_btn v2" onclick="jc_copy_btn(<?php echo $TPL_V1["joincheck_seq"]?>)" />						
			</td>
			<td><input type="button" name="manager_delete_btn" value="삭제" class="resp_btn v3" onclick="jc_delete_btn(<?php echo $TPL_V1["joincheck_seq"]?>)" /></td>
		</tr>
		<!-- 리스트데이터 : 끝 -->
<?php }}?>
<?php }else{?>
		<!-- 리스트타이틀(이벤트상태 및 버튼) : 시작 -->
				<tr>
					<td colspan="10">
<?php if($TPL_VAR["keyword"]){?>
					'<?php echo $TPL_VAR["keyword"]?>' 검색된 이벤트가 없습니다.
<?php }else{?>
					등록된 이벤트가 없습니다.
<?php }?>
			</td>
		</tr>
		<!-- 리스트데이터 : 끝 -->
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->

</table>
<!-- 출석체크 리스트 테이블 : 끝 -->

</div>

<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>