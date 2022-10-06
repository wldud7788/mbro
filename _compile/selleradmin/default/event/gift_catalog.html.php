<?php /* Template_ 2.2.6 2022/05/17 12:29:05 /www/music_brother_firstmall_kr/selleradmin/skin/default/event/gift_catalog.html 000012095 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=20200601"></script>
<script type="text/javascript">
$(document).ready(function() {

	var arrSort = {
						'evt.regist_date desc':'최근 등록 순',
						'evt.title asc':'이벤트명 순'
					};
	gSearchForm.init({'pageid':'seller_gift_catalog','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>','sellerAdminMode':true,'displaySort':arrSort});

	$("#order_star").click(function(){
		var status = "";
		if($(this).hasClass("checked")){
			$(this).removeClass("checked");
			status = "asc";
		}else{
			$(this).addClass("checked");
			status = "desc";
		}
		location.href = "../goods/catalog?orderby=favorite_chk&sort="+status;
	});

	$(".event_modify_btn").click(function(){
		document.location.href="gift_regist?event_seq="+$(this).attr("event_seq");
	});

	$(".event_copy_btn").click(function(){

		if(!confirm("이 이벤트를 복사하시겠습니까?")) return;

		$.ajax({
			type: "get",
			url: "../event_process/event_copy",
			data: "event_seq="+$(this).attr("event_seq"),
			success: function(result){
				location.reload();
			}
		});
	});

	$(".event_delete_btn").click(function(){

		if(!confirm("이 이벤트를 삭제하시겠습니까?")) return;

		$.ajax({
			'type': "get",
			'url': "../event_process/gift_delete?ajaxcall=Y",
			'data': "event_seq="+$(this).attr("event_seq"),
			'dataType': 'json',
			success: function(res){
				if(res.result == 'auth'){
					alert(res.msg);
					document.location.reload();
				}else{
					document.location.reload();
				}
			}
		});
	});


	$(".mypage_view").click(function(){
		window.open("/mypage/point_exchange","","");
	});


	// 데이터가 없을 경우
	$("tr.no-data td").attr('colspan',$("#gift-event-list thead.lth tr th").length);
});


function contView(seq, type){
	if(type == "order"){
		if(!confirm("본 구매 조건 사은품 이벤트를 진행하시겠습니까?")) return;
	}else{
		if(!confirm("본 사은품 이벤트를 노출 하시겠습니까?")) return;
	}
	actionFrame.location.href = "../event_process/gift_cont?seq="+seq;
}

	function event_view(tpl_path,platform){
		window.open("/link/"+tpl_path+"?setDesignMode=on&setMode="+platform);
}

</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">		
		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>사은품 이벤트</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button onclick="location.href='/selleradmin/event/gift_regist'" class="resp_btn active2 size_L">이벤트 등록</button></li>			
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 이벤트리스트 검색폼 : 시작 -->
<div id="search_container" class="search_container">
<form name="orderForm" id="orderForm">
<input type="hidden" name="perpage" id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" >
<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["sc"]["page"]?>" >
<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sc"]["sort"]?>" >
	<table class="table_search">
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_keyword" class="hide"></label> 이벤트명</th>
			<td><input type="text" name="keyword" value="<?php echo htmlspecialchars($TPL_VAR["sc"]["keyword"])?>" size=80 title="사은품 이벤트명" /></td>
		</tr>
		
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_regist_date" class="hide"></label> 날짜</th>
			<td>
				<div class="date_range_form" >
					<select name="date">
						<option value="start_date" <?php if($TPL_VAR["sc"]["date"]=='start_date'){?>selected<?php }?>>시작일</option>
						<option value="end_date" <?php if($TPL_VAR["sc"]["date"]=='end_date'){?>selected<?php }?>>종료일</option>
						<option value="regist_date" <?php if($TPL_VAR["sc"]["date"]=='regist_date'){?>selected<?php }?>>등록일</option>
					</select>

					<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10"/>
					-
					<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10"/>
					
					<div class="resp_btn_warp">
						<input type="button" range="today" value="오늘" class="select_date resp_btn" />
						<input type="button" range="3day" value="3일간" class="select_date resp_btn" />
						<input type="button" range="1week" value="일주일" class="select_date resp_btn" />
						<input type="button" range="1month" value="1개월" class="select_date resp_btn" />
						<input type="button" range="3month" value="3개월" class="select_date resp_btn" />
						<input type="button" range="select_date_all"  value="전체" class="select_date resp_btn"/>
						<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden" />
					</div>
				</div>
			</td>
		</tr>

		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_provider" class="hide"></label> 사은품 제공자</th>
			<td>				
				<span class="mr15"><?php echo $TPL_VAR["provider"]["provider_name"]?></span>
		
				<select name="provider_seq_selector" class='hide'>
				</select>
				<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $TPL_VAR["provider"]["provider_seq"]?>" relation="ship_grp" />
				<input type="hidden" name="provider_name" value="<?php echo $TPL_VAR["provider"]["provider_name"]?>" size=40 readonly />
				<span class="ship_grp hide">
				<select name="ship_grp" val="<?php echo $TPL_VAR["sc"]["ship_grp"]?>">
					<option value="">배송비 선택</option>
				</select>
			</td>
		</tr>

		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_event_status" class="hide"></label> 상태</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="event_status" value="" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['all']?> /> 전체</label>
					<label><input type="radio" name="event_status" value="before" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['before']?> /> 시작 이전</label>
					<label><input type="radio" name="event_status" value="ing" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['ing']?>/> 진행 중</label>
					<label><input type="radio" name="event_status" value="end" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['end']?>/> 종료</label>	
				</div>
				
			</td>
		</tr>
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_gift_gb" class="hide"></label> 유형</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="gift_gb" value="" <?php echo $TPL_VAR["sc"]['checkbox']['gift_gb']['all']?> /> 전체</label>
					<label><input type="radio" name="gift_gb" value="order" <?php echo $TPL_VAR["sc"]['checkbox']['gift_gb']['order']?> > 사은품 증정</label>
					<label><input type="radio" name="gift_gb" value="buy" <?php echo $TPL_VAR["sc"]['checkbox']['gift_gb']['buy']?>> 사은품 교환</label>
				</div>
			</td>
		</tr>
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_display" class="hide"></label> 페이지 진입</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="display" value="" <?php echo $TPL_VAR["sc"]['checkbox']['display']['all']?> /> 전체</label>
					<label><input type="radio" name="display" value="y" <?php echo $TPL_VAR["sc"]['checkbox']['display']['y']?> /> 가능</label>
					<label><input type="radio" name="display" value="n" <?php echo $TPL_VAR["sc"]['checkbox']['display']['n']?> /> 불가</label>
				</div>
			</td>
		</tr>
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_event_view" class="hide"></label> 전체 이벤트 노출</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="event_view" value=""  <?php echo $TPL_VAR["sc"]['checkbox']['event_view']['all']?> /> 전체</label>
					<label><input type="radio" name="event_view" value="y" <?php echo $TPL_VAR["sc"]['checkbox']['event_view']['y']?>/>노출</label>
					<label><input type="radio" name="event_view" value="n" <?php echo $TPL_VAR["sc"]['checkbox']['event_view']['n']?>/> 미노출</label>
				
				</div>
			</td>
		</tr>

	</table>
	
	<div class="search_btn_lay center mt10 footer"></div>
</div>
</form>
<div class="cboth"></div>
<!-- 이벤트리스트 검색폼 : 끝 -->

<div class="contents_container">
	<div class="list_info_container">
		<div class="dvs_left">
			<div class="left-btns-txt">검색 <b><?php echo number_format($TPL_VAR["page"]["searchcount"])?></b>개 (총 <b><?php echo number_format($TPL_VAR["page"]["totalcount"])?></b>개)</div>
		</div>
		<div class="dvs_right">	
			<span class="display_sort" sort="<?php echo $TPL_VAR["sc"]["sort"]?>"></span>
			<span class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></span>
		</div>
	</div>

	<table class="table_row_basic tdc" id="gift-event-list">		
		<colgroup>
			<col width="7%" />
			<col width="10%" />
			<col width="22%" />
			<col width="10%" />
			<col width="12%" />
			<col width="8%" />
			<col width="12%" />
			<col width="9%" />
			<col width="9%" />				
		</colgroup>
		
		<thead>
			<tr>
				<th>번호</th>
				<th>유형</th>
				<th>이벤트명</th>	
				<th>사은품 제공자</th>	
				<th>시작일/종료일</th>	
				<th>상태</th>	
				<th>등록일</th>	
				<th>관리</th>	
				<th>삭제</th>	
			</tr>
		</thead>
		
		<tbody>
<?php if($TPL_VAR["record"]){?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
		<!-- 리스트타이틀(이벤트상태 및 버튼) : 시작 -->
			<tr>
				<td><?php echo $TPL_V1["_no"]?></td>
				<td><?php if($TPL_V1["gift_gb"]=='order'){?>증정<?php }else{?>교환<?php }?></td>
				<td class="left"><a href='./gift_regist?event_seq=<?php echo $TPL_V1["gift_seq"]?>' class='resp_btn_txt v2'><?php echo $TPL_V1["title"]?></a></td>
				<td>
<?php if(serviceLimit('H_AD')){?>				
					<?php echo $TPL_V1["provider_name"]?>

<?php }else{?>					
					<?php echo $TPL_V1["shipping_group_name"]?>

<?php }?>
				</td>
				<td><?php echo $TPL_V1["start_date"]?><br/><?php echo $TPL_V1["end_date"]?></td>
				<td><?php echo $TPL_V1["status"]?></td>
				<td><?php echo $TPL_V1["regist_date"]?></td>
				<td><input type="button" value="수정" class="event_modify_btn resp_btn v2" event_seq="<?php echo $TPL_V1["gift_seq"]?>" />	</td>
				<td><input type="button" value="삭제" class="event_delete_btn resp_btn v3" event_seq="<?php echo $TPL_V1["gift_seq"]?>"/></td>
			</tr>
		<!-- 리스트데이터 : 끝 -->
<?php }}?>
<?php }else{?>
		<!-- 리스트타이틀(이벤트상태 및 버튼) : 시작 -->
			<tr>
				<td class="center" colspan="9">
<?php if($TPL_VAR["sc"]["keyword"]){?>
						'<?php echo $TPL_VAR["sc"]["keyword"]?>' 검색된 이벤트가 없습니다.
<?php }else{?>
						등록된 이벤트가 없습니다.
<?php }?>
				</td>
			</tr>
		<!-- 리스트데이터 : 끝 -->
<?php }?>
		<tbody>
	</table>
	<!-- 이벤트리스트 테이블 : 끝 -->	
</div>

<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>