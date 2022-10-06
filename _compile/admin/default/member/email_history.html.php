<?php /* Template_ 2.2.6 2022/05/30 15:16:47 /www/music_brother_firstmall_kr/admin/skin/default/member/email_history.html 000008156 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		gSearchForm.init({'pageid':'email_history','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>'});

		$(".email_select").live("click",function(){
			$.get('../member_process/getlogmail?seq='+$(this).attr('seq'), function(response) {
				//$('#contPop').html(data);

				var data = eval(response)[0];
				$("#contents").show();
				$('#c_title').html(data.subject);
				$('#c_total').html(data.total);
				$('#c_regdate').html(data.regdate);
				$('#c_contents').html(data.contents);
				//openDialog("이메일 내용 <span class='desc'>&nbsp;</span>", "contPop", {"width":"600","height":"600"});
			});
		});		

		$("#btn_submit").click(function(){
			$("#gabiaFrm").submit();
		});
	});
</script>
<style>
	.footer.search_btn_lay button{width: auto;background-color: white; border: 1px solid gray; height: 30px;}
	.footer.search_btn_lay button span{color: #959595;}
	/*.resp_btn.active{color: #3090d6; border: 1px solid rgb(48, 144, 214) !important;}*/
	.search_btn_lay .sc_edit{position: relative;}
	.search_btn_lay .detail, .search_btn_lay .default{position: relative;}
	.footer.search_btn_lay{top: 23px;}
	.resp_btn.size_XL{line-height: inherit;}
	.contents_container{width: 1400px; margin: auto;}
	.table_search{width: 1400px !important;}
	.footer.search_btn_lay{top: auto; left: calc(50% - 50px) !important;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>이메일 발송 관리</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
		<!--
			<li><span class="btn large icon"><button><span class="arrowleft"></span>이동버튼</button></span></li>
			<li><span class="btn large icon"><button><span class="arrowleft"></span>이동버튼</button></span></li>
		-->
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
		<!--
			<li><span class="btn large black"><button type="submit">저장하기<span class="arrowright"></span></button></span></li>
			<li><span class="btn large black"><button type="submit">저장하기<span class="arrowright"></span></button></span></li>
		-->
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">
	<!-- 상단 단계 링크 : 시작 -->
	<ul class="tab_01 v2 tabEvent">
<?php if($_GET['sc_gb']=="PERSONAL"){?>
		<li><a href='curation'>개인맞춤형알림</a></td>
		<li><a href='sms_history?sc_gb=PERSONAL'>SMS 발송내역</a></td>
		<li><a href='email_history?sc_gb=PERSONAL&orderby=regdate'>이메일 발송내역</a></td>
		<li><a href='sms_setting'>세팅및충전</a></td>
		<li><a href='curation_log'>로그데이터</a></td>
<?php }else{?>
		<li><a href="email">이메일 자동 발송</a></td>
		<li><a href="email_history" class="current">이메일 발송내역</a></td>
<?php }?>
	</ul>
	<!-- 상단 단계 링크 : 끝 -->

	<!-- 서브 레이아웃 영역 : 시작 -->
	<div id="search_container"  class="search_container">
		<form name="gabiaFrm" id="gabiaFrm" class='search_form'>
		<input type="hidden" name="sc_gb" value="<?php echo $TPL_VAR["sc_gb"]?>">
		<input type="hidden" name="searchcount" value="<?php echo $TPL_VAR["sc"]["searchcount"]?>">
		<table class="table_search">			
			<tbody>
				<tr>
					<th>제목</th>
					<td>
						<input type="text" name="sc_subject" size="80" value="<?php echo $TPL_VAR["sc"]["sc_subject"]?>" />
					</td>
				</tr>
				<tr>
					<th>발송일</th>
					<td>
						<div class="sc_day_date date_range_form">
							<input type="text" name="start_date" value="<?php echo $TPL_VAR["sc"]["start_date"]?>"  class="datepicker line sdate"  maxlength="10" size="12" default_none/>
							-
							<input type="text" name="end_date" value="<?php echo $TPL_VAR["sc"]["end_date"]?>"  class="datepicker line edate" maxlength="10" size="12" default_none />
							<div class="resp_btn_wrap">
								<input type="button" value="오늘" range="today" class="select_date resp_btn" settarget="regist" />
								<input type="button" value="3일간" range="3day" class="select_date resp_btn" settarget="regist" />
								<input type="button" value="일주일" range="1week" class="select_date resp_btn" settarget="regist" />
								<input type="button" value="1개월" range="1month" class="select_date resp_btn" settarget="regist" />
								<input type="button" value="3개월" range="3month" class="select_date resp_btn" settarget="regist" />
								<input type="button" value="전체" range="all" class="select_date resp_btn" settarget="regist" row_bunch />
								<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden">
							</div>
						</div>
					</td>
				</tr>
				
			</tbody>
		</table>

		<div class="footer search_btn_lay"></div>
		</form>
	</div>

	<!-- 주문리스트 테이블 : 시작 -->
	<div class="list_info_container">
		<div class="dvs_left">	
			검색 <b><?php echo $TPL_VAR["sc"]["searchcount"]?></b>개 (총 <b><?php echo $TPL_VAR["sc"]["totalcount"]?></b>개)
		</div>		
	</div>
	<table class="table_row_basic">
		<!-- 테이블 헤더 : 시작 -->
		<colgroup>
			<col width="5%" />
			<col />
			<col width="20%" />
			<col width="20%" />
		</colgroup>
		<thead class="lth">
			<tr>
				<th>번호</th>
				<th>이메일 제목</th>
				<th>수신 대상자</th>
				<th>발송일시</th>
			</tr>
		</thead>
		<!-- 테이블 헤더 : 끝 -->
		<tbody class="ltb otb" >
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr class="list-row email_select"  seq="<?php echo $TPL_V1["seq"]?>" style="cursor:pointer;">
				<td><?php echo $TPL_V1["number"]?></td>
				<td class="left"><span><?php echo $TPL_V1["subject"]?></span></td>
				<td><?php if($TPL_V1["memo"]=="admin"){?>관리자<?php }else{?><?php echo $TPL_V1["total"]?>명<?php }?></td>
				<td><?php echo $TPL_V1["regdate"]?></td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }}?>
<?php }else{?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr class="list-row">
				<td align="center" colspan="4">
<?php if($TPL_VAR["search_text"]){?>
						'<?php echo $TPL_VAR["search_text"]?>' 검색된 데이터가 없습니다.
<?php }else{?>
						등록된 데이터가 없습니다.
<?php }?>
				</td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }?>
		</tbody>
		<!-- 리스트 : 끝 -->
	</table>
	<!-- 주문리스트 테이블 : 끝 -->	
	<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?> </div>			
</div>

<div id="contPop" class="hide"></div>

<div id="contents" class="hide">
	<br style="line-height:16px;" />

	<!-- 주문리스트 테이블 : 시작 -->
	<div class="item-title" style="float:left;width:92%">이메일 발송내역</div>
	<table class="list-table-style" cellspacing="0">
		<!-- 테이블 헤더 : 시작 -->
		<colgroup>
			<col />
			<col width="20%" />
			<col width="20%" />
		</colgroup>
		<thead class="lth">
			<tr>
				<th>이메일 제목</th>
				<th>수신 대상자</th>
				<th>발송일시</th>
			</tr>
		</thead>
		<!-- 테이블 헤더 : 끝 -->
		<tbody class="ltb otb" >
			<tr class="list-row">
				<td align="center"><span id="c_title"></span></td>
				<td align="center"><span id="c_total"></span></td>
				<td align="center"><span id="c_regdate"></span></td>
			</tr>
			<tr class="list-row">
				<td align="center" colspan="3" style="padding:10px;"><span id="c_contents" style="width:80%;"></span></td>
			</tr>
		</tbody>
	</table>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>