<?php /* Template_ 2.2.6 2022/05/17 12:31:44 /www/music_brother_firstmall_kr/admin/skin/default/event/catalog.html 000015774 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

		var arrSort = {'evt.regist_date desc':'최근 등록 순',
						'evt.title asc':'이벤트명 순',
						'evt.pageview desc':'조회수 많은 순',
						'evt.pageview asc':'조회수 적은순'};
		gSearchForm.init({'pageid':'event_catalog','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>','displaySort':arrSort});

<?php if($_GET["mode"]=="new"){?>
		//쿠폰신규생성 후 뒤로가기 시 리스트로 이동
		history.pushState(null, null, location.href);
			window.onpopstate = function () {
				document.location.href="/admin/event/catalog";
		};
<?php }?>

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
			//######################## 16.10.27 : 수정 s
			$("input[name='keyword']").focus();
			$("input[name='event_seq']").val($(this).attr("event_seq"));
			var search = location.search;
			search = search.substring(1,search.length);
			$("input[name='query_string']").val(search);			
			$("form[name='orderForm']").attr('action','regist');
			$("form[name='orderForm']").submit();
			//######################## 16.10.27 : 수정 e
		});

		$(".event_copy_btn").click(function(){
			if(!confirm("이벤트와 상품정보만 복사되니 복사 후 정보를 수정해 주세요!\n정말로 이 이벤트를 복사하시겠습니까?")) return;
			actionFrame.document.location.href	= '../event_process/event_copy?event_seq='+$(this).attr("event_seq");
		});

		$(".event_delete_btn").click(function(){
			if(!confirm("이 이벤트를 삭제하시겠습니까?")) return;
			actionFrame.document.location.href	= '../event_process/event_delete?event_seq='+$(this).attr("event_seq");
		});

		$("input[name='sc_event_type']").on("click",function(){
			if	($(this).val() == "solo"){
				$("input[name='search_form_editor[]'][value='sc_event_solo']").closest("tr").show();
				$(".search_solo").removeClass('desc');
				$(".search_solo").find('select').prop('disabled', false);
				$(".search_solo").find('input').prop('disabled', false);
			}else{
				$("input[name='search_form_editor[]'][value='sc_event_solo']").closest("tr").hide();
				$(".search_solo").addClass('desc');
				$(".search_solo").find('select').prop('disabled', true);
				$(".search_solo").find('input').prop('disabled', true);
			}
		});

<?php if($TPL_VAR["sc"]["sc_event_type"]=='solo'){?> $("input[name='sc_event_type']").trigger("click"); <?php }?>

	});

	function event_view(tpl_path,mode){
		window.open("/link/"+tpl_path+"?setDesignMode=on&setMode="+mode);
	}

</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">		
		<ul class="page-buttons-left">
			<li>
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
				<button onclick="location.href='/admin/page_manager/subpage_layout?cmd=event';" class="resp_btn v3 size_L">전체 이벤트 페이지 설정</button>
<?php }else{?>
				<button onclick="location.href='event_view?mode=sale_event';" class="resp_btn v3 size_L">전체 이벤트 페이지 설정</button>
<?php }?>
			</li>
		</ul>		

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>할인 이벤트</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">			
			<li><button onclick="location.href='regist';" class="resp_btn active2 size_L">이벤트 등록</button></li>			
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 이벤트리스트 검색폼 : 시작 -->
<div id="search_container" class="search_container">
<form name="orderForm" id="orderForm">
<!-- ######################## 16.10.27 : 수정 s -->
<input type="hidden" name="query_string"/>
<input type="hidden" name="event_seq" />
<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sc"]["sort"]?>"/>
<!-- ######################## 16.10.27 : 수정 e -->
<input type="hidden" name="perpage" id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" >
<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["sc"]["page"]?>" >
	<table class="table_search">
	<tr>
		<th><label><input type="checkbox" name="search_form_editor[]" value="sc_keyword" class="hide"></label>이벤트명</th>
		<td>
			<input type="text" name="keyword" value="<?php echo htmlspecialchars($TPL_VAR["sc"]["keyword"])?>" title="이벤트명" size=80 />
		</td>
	</tr>
	<tr>
		<th><label><input type="checkbox" name="search_form_editor[]" value="sc_regist_date" class="hide"></label>날짜</th>
		<td>
			<div class="date_range_form">
				<select name="date">
					<option value="evt.start_date" <?php echo $TPL_VAR["sc"]['selectbox']['date']['evt.start_date']?>>시작일</option>
					<option value="evt.end_date" <?php echo $TPL_VAR["sc"]['selectbox']['date']['evt.end_date']?>>종료일</option>
					<option value="evt.regist_date" <?php echo $TPL_VAR["sc"]['selectbox']['date']['evt.regist_date']?>>등록일</option>
				</select>				
				<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10"/>
				-
				<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10"/>
				
				<div class="resp_btn_wrap">
					<input type="button" range="today" value="오늘" class="select_date resp_btn" />
					<input type="button" range="3day" value="3일간" class="select_date resp_btn" />
					<input type="button" range="1week" value="일주일" class="select_date resp_btn" />
					<input type="button" range="1month" value="1개월" class="select_date resp_btn" />
					<input type="button" range="3month" value="3개월" class="select_date resp_btn" />
					<input type="button" range="all"  value="전체" class="select_date resp_btn"/>
					<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden">
				</div>	
			</div>
		</td>
	</tr>
	<tr>
		<th><label><input type="checkbox" name="search_form_editor[]" value="sc_event_status" class="hide"></label>상태</th>
		<td>
			<div class="resp_radio">
				<label><input type="radio" name="event_status" value="all" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['all']?>/> 전체</label>
				<label><input type="radio" name="event_status" value="before" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['before']?>/> 시작 전</label>
				<label><input type="radio" name="event_status" value="ing" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['ing']?>/> 진행 중</label>
				<label><input type="radio" name="event_status" value="end" <?php echo $TPL_VAR["sc"]['checkbox']['event_status']['end']?>/> 종료</label>
			</div>				
		</td>
	</tr>
<?php if(serviceLimit('H_NFR')){?>	
	<tr>
		<th><label><input type="checkbox" name="search_form_editor[]" value="sc_event_type" class="hide"></label>유형</th>
		<td>				
			<div class="resp_radio">
				<label><input type="radio" name="sc_event_type" value="" <?php echo $TPL_VAR["sc"]['checkbox']['sc_event_type']['all']?> /> 전체</label>
				<label><input type="radio" name="sc_event_type" value="multi" <?php echo $TPL_VAR["sc"]['checkbox']['sc_event_type']['multi']?>/> 상품 이벤트</label>	
				<label><input type="radio" name="sc_event_type" value="solo" <?php echo $TPL_VAR["sc"]['checkbox']['sc_event_type']['solo']?> /> 단독 상품이벤트</label>	
			</div>
		</td>
	</tr>
	<tr class='disable hide'>
		<th><label><input type="checkbox" name="search_form_editor[]" value="sc_event_solo" class="hide"></label>단독 상품</th>
		<td class="search_solo  <?php if($TPL_VAR["sc"]["sc_event_type"]!='solo'){?>desc<?php }?>">
			<select name="sc_goods_type" <?php if($TPL_VAR["sc"]["sc_event_type"]!='solo'){?>disabled<?php }?>>
				<option value=""			<?php echo $TPL_VAR["sc"]['selectbox']['sc_goods_type']['all']?>>일반상품+티켓상품</option>
				<option value="goods"		<?php echo $TPL_VAR["sc"]['selectbox']['sc_goods_type']['goods']?>>일반상품</option>
				<option value="coupon"		<?php echo $TPL_VAR["sc"]['selectbox']['sc_goods_type']['coupon']?>>티켓상품</option>
			</select>
			<input type="text" name="sc_start_st" size="3" class="onlynumber" value="<?php echo $TPL_VAR["sc"]["sc_start_st"]?>" <?php if($TPL_VAR["sc"]["sc_event_type"]!='solo'){?>disabled<?php }?> maxlength=3 /> 차
			~
			<input type="text" name="sc_end_st" size="3" class="onlynumber" value="<?php echo $TPL_VAR["sc"]["sc_end_st"]?>" <?php if($TPL_VAR["sc"]["sc_event_type"]!='solo'){?>disabled<?php }?> maxlength=3 /> 차
			<input type="text" name="sc_goods_info"size="40" value="<?php echo htmlspecialchars($TPL_VAR["sc"]["sc_goods_info"])?>" title="상품명, 상품번호" <?php if($TPL_VAR["sc"]["sc_event_type"]!='solo'){?>disabled<?php }?> />
		</td>
	</tr>
<?php }?>
	<tr>
		<th><label><input type="checkbox" name="search_form_editor[]" value="sc_use_coupon" class="hide"></label>사용 제한</th>
		<td>
			<div class="resp_radio">					
				<label><input type="radio" name="use_type" value="all"					<?php echo $TPL_VAR["sc"]['checkbox']['use_type']['all']?> /> 전체</label>
				<label><input type="radio" name="use_type" value="use_coupon"				<?php echo $TPL_VAR["sc"]['checkbox']['use_type']['use_coupon']?>/> 쿠폰</label>
				<label><input type="radio" name="use_type" value="use_coupon_shipping"		<?php echo $TPL_VAR["sc"]['checkbox']['use_type']['use_coupon_shipping']?>/> 배송비 쿠폰</label>
				<label><input type="radio" name="use_type" value="use_coupon_ordersheet"	<?php echo $TPL_VAR["sc"]['checkbox']['use_type']['use_coupon_ordersheet']?>/> 주문서 쿠폰</label>
<?php if(serviceLimit('H_NFR')){?>
				<label><input type="radio" name="use_type" value="use_code"					<?php echo $TPL_VAR["sc"]['checkbox']['use_type']['use_code']?>/> 할인 코드</label>
				<label><input type="radio" name="use_type" value="use_code_shipping"		<?php echo $TPL_VAR["sc"]['checkbox']['use_type']['use_code_shipping']?>/> 배송비 할인코드</label>
<?php }?>
			</div>
		</td>
	</tr>
	<tr>
		<th><label><input type="checkbox" name="search_form_editor[]" value="sc_display" class="hide"></label>페이지 진입</th>
		<td>
			<div class="resp_radio">	
				<label><input type="radio" name="display" value="all" <?php echo $TPL_VAR["sc"]['checkbox']['display']['all']?> /> 전체</label>
				<label><input type="radio" name="display" value="y" <?php echo $TPL_VAR["sc"]['checkbox']['display']['y']?> /> 가능</label>
				<label><input type="radio" name="display" value="n" <?php echo $TPL_VAR["sc"]['checkbox']['display']['n']?>/> 불가</label>	
			</div>
		</td>
	</tr>
	<tr>
		<th><label><input type="checkbox" name="search_form_editor[]" value="sc_event_view" class="hide"></label>전체 이벤트 노출</th>
		<td>
			<div class="resp_radio">
				<label><input type="radio" name="event_view" value="all" <?php echo $TPL_VAR["sc"]['checkbox']['event_view']['all']?>/> 전체</label>
				<label><input type="radio" name="event_view" value="y" <?php echo $TPL_VAR["sc"]['checkbox']['event_view']['y']?>/> 노출</label>
				<label><input type="radio" name="event_view" value="n" <?php echo $TPL_VAR["sc"]['checkbox']['event_view']['n']?>/> 미노출</label>
			</div>				
		</td>
	</tr>
	</table>

	<div class="search_btn_lay center mt10"></div>
</div>
<div class="cboth"></div>
<!-- 이벤트리스트 검색폼 : 끝 -->

<div class="contents_container">
	<div class="list_info_container">
		<div class="dvs_left">	
			<div class="left-btns-txt">검색 <b><?php echo number_format($TPL_VAR["page"]["searchcount"])?></b> 개 (총 <b><?php echo number_format($TPL_VAR["page"]["totalcount"])?></b>개)</div>
		</div>
		<div class="dvs_right">	
			<span class="display_sort" sort="<?php echo $TPL_VAR["sc"]["sort"]?>"></span>
			<span class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></span>
		</div>
	</div>
	
	<table class="table_row_basic">		
		<colgroup>
			<col width="7%" />
			<col width="9%" />
			<col width="16%" />
			<col width="14%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="7%" />
			<col width="10%" />
			<col width="7%" />
		</colgroup>
		
		<thead>
			<tr>
				<th>번호</th>
				<th>유형</th>
				<th>이벤트명</th>
				<th>혜택</th>
				<th>시작일/종료일</th>
				<th>상태</th>
				<th>등록일</th>
				<th>조회수</th>
				<th>관리</th>
				<th>삭제</th>
			</tr>
		</thead>
		
		<tbody>
<?php if($TPL_VAR["list"]){?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<!-- 리스트타이틀(이벤트상태 및 버튼) : 시작 -->
			<tr>
				<td><?php echo $TPL_V1["_no"]?></td>
				<td>
<?php if($TPL_V1["event_type"]=='solo'){?>
						 단독
<?php }else{?>
						상품
<?php }?>
	
				</td>
				<td class="left">
<?php if($TPL_V1["event_type"]=='solo'){?>[<?php echo $TPL_V1["st_num"]?>차]<?php }?>
					<a href='/admin/event/regist?event_seq=<?php echo $TPL_V1["event_seq"]?>' class="resp_btn_txt v2"><?php echo $TPL_V1["title"]?></a></td>
				<td class="left"><?php echo $TPL_V1["salepricetitle"]?></td>
				<td>
<?php if($TPL_V1["start_date"]=='0000-00-00 00:00:00'&&$TPL_V1["end_date"]=='0000-00-00 00:00:00'){?>
						0000-00-00 00<br/>
						0000-00-00 00
<?php }else{?>
						<?php echo date('Y-m-d H',strtotime($TPL_V1["start_date"]))?><br/>
						<?php echo date('Y-m-d H',strtotime($TPL_V1["end_date"]))?>

<?php }?>
				</td>
				<td><?php echo $TPL_V1["status"]?></td>
				<td><?php echo $TPL_V1["regist_date"]?></td>
				<td><?php echo number_format($TPL_V1["pageview"])?></td>
				<td>
					<input type="button" value="수정" class="event_modify_btn resp_btn v2" event_seq="<?php echo $TPL_V1["event_seq"]?>" event_type="<?php echo $TPL_V1["event_type"]?>" />
					<input type="button" value="복사" class="event_copy_btn  resp_btn v2" event_seq="<?php echo $TPL_V1["event_seq"]?>" event_type="<?php echo $TPL_V1["event_type"]?>" />
				</td>
				<td><input type="button" value="삭제" class="event_delete_btn  resp_btn v3"  event_seq="<?php echo $TPL_V1["event_seq"]?>" /></td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }}?>
<?php }else{?>
			<!-- 리스트타이틀(이벤트상태 및 버튼) : 시작 -->
			<tr>				
				<td class="center" colspan="10">				
<?php if($TPL_VAR["keyword"]){?>
						'<?php echo $TPL_VAR["keyword"]?>' 검색된 이벤트가 없습니다.
<?php }else{?>
						등록된 이벤트가 없습니다.
<?php }?>
				</td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }?>
		<tbody>
	</table>	
</form>	
</div>

<!-- 이벤트리스트 테이블 : 끝 -->


<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>