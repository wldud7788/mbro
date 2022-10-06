<?php /* Template_ 2.2.6 2022/05/30 15:44:42 /www/music_brother_firstmall_kr/admin/skin/default/promotion/catalog.html 000021444 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="euc-kr"></script>\
<!-- 2021.12.30 11월 3차 패치 by 김혜진 -->
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gCouponIssued.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gMemberGradeSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gMemberSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<style type="text/css">
	.footer.search_btn_lay{top: auto; left: calc(50% - 50px);}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		
		gSearchForm.init({'pageid':'promotion_catalog','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','defaultPage':0,'select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>'});

<?php if($_GET["mode"]=="new"){?>
		//쿠폰신규생성 후 뒤로가기 시 리스트로 이동
		history.pushState(null, null, location.href);
			window.onpopstate = function () {
				document.location.href="/admin/promotion/catalog";
		};
<?php }?>

		$("div#page-title-bar-area button#promotionRegist").bind("click",function(){
			location.href = "promotion";
		});

		$("#promotionType_all").click(function(){
			$("input[name='promotionType[]']").attr("checked","checked");
		});

		// 등록
		$('#promotionRegist').live('click', function() {
			document.location.href='../promotion/regist';
		});

		// 발급/사용내역
		$('.downloadlist_btn').on('click', function() {
			//if ( $(this).val() > 0 ) {
				var promotion_seq = $(this).attr("promotion_seq");
				var promotion_name = $(this).attr("promotion_name");
				window.open('./download?no='+promotion_seq, "할인 코드 발급/사용 내역",'width=1250,height=800,location=no,status=no,scrollbars=yes');
				
			//}
		});

		// 발급/사용내역
		$('.downloadlistuse_btn').on('click', function() {
			if ( $(this).val() > 0 ) {
				var promotion_seq = $(this).attr("promotion_seq");
				var promotion_name = $(this).attr("promotion_name");
				addFormDialog('./download?use_status=used&no='+promotion_seq+'&title='+promotion_name,'93%', '600', '['+promotion_name+'] 발급/사용내역 ','false');
			}
		});

		//프로모션삭제
		$("input:button[name=deletepromotion_btn]").live("click",function(){
			var promotion_seq		= $(this).attr('promotion_seq');
			if(confirm("정말로 삭제하시겠습니까?") ) {
				$.ajax({
					'url' : '../promotion_process/promotion_delete?ajaxcall=Y',
					'data' : {'promotionSeq':promotion_seq},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){
						if(res.result == 'auth'){
							alert(res.msg);
							document.location.reload();
						}else{
							if(res.result == 'true' ){
								alert(res.msg);
								document.location.reload();
							}else{
								alert(res.msg);
							}
						}
					}
				});
			}
		});

		// 수정
		$(":input[name=modifypromotion_btn]").live("click", function() {
			var seq = $(this).attr("promotion_seq");
			document.location.href='../promotion/regist?no='+seq;
		});


		$("#download_group_search").live("click",function(){
			if($("#target_type2").attr("disabled") != 'disabled'){
				$("#target_type2").attr("checked","checked");
				var checkedId = "input:checkbox[name='memberGroup']";
				var idx = ($(checkedId).length);;
				if(idx > 0) {
					$(checkedId).each(function(e, data) {
						if( !downloadmembergroup($(data).val()) ) {//다운권한이 없는 등급인 경우
							$("#memberGroup_"+$(data).val()).attr("disabled","disabled");
						}else{
							$("#memberGroup_"+$(data).val()).removeAttr("disabled");
						}
					});
				}
				openDialog("등급 선택", "setGroupsPopup", {"width":"500","height":"500"});
			}
		});

	
		$('#display_quantity').bind('change', function() {
			$("#perpage").val($(this).val());
			$("#promotionsearch").submit();
		});

		$('#display_orderby').bind('change', function() {
			$("#orderby").val($(this).val());
			$("#promotionsearch").submit();
		});


		$(".orderview").click(function(){
			var order_seq = $(this).attr("order_seq");
			var href = "/admin/order/view?no="+order_seq;
			var a = window.open(href, 'orderdetail'+order_seq, '');
			if ( a ) {
				a.focus();
			}
		});

		$(".goodsview").click(function(){
			var goods_seq = $(this).attr("goods_seq");
			var href = "/admin/goods/regist?no="+goods_seq;
			var a = window.open(href, 'goodsdetail'+goods_seq, '');
			if ( a ) {
				a.focus();
			}
		});

		$(".userinfo").click(function(){
			var mseq = $(this).attr("mseq");
			var href = "/admin/member/detail?member_seq="+mseq;
			var a = window.open(href, 'mbdetail'+mseq, '');
			if ( a ) {
				a.focus();
			}
		});

			// 무료몰인경우 업그레이드안내
		$('#nofreelinknone,.nofreelinknone').live('click', function() {
			openDialog("쇼핑몰 업그레이드 안내<span class='desc'></span>", "nofreeService", {"width":600,"height":200});
		});

		$("#promotioncodeusebtn").click(function() {
			openDialog("할인 코드 사용 설정", "promotioncodeuselay", {"width":"600","height":"310","show" : "fade","hide" : "fade"});
		});


		$(".promotioncodehelperbtn").click(function() {
			openDialog("할인 코드 안내", "promotioncodehelperlay", {"width":"800","height":"480","show" : "fade","hide" : "fade"});
		});


		$("#promotionusesave").click(function(){
			var promotioncode_use = $("input:radio[name$='promotioncode_use']:checked").val();
			$.ajax({
					'url' : '../promotion_process/promotionusesave',
					'data' : {'promotioncode_use':promotioncode_use},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){
						if(res.result == 'auth'){
							alert(res.msg);
							document.location.reload();
						}else{
							if(res.result == true ){
								alert(res.msg);
								document.location.reload();
							}else{
								alert(res.msg);
							}
						}
					}
				});
		});

		$("#setGroupsBtn").click(function()
		{
			groupsMsg()
		})
	});

	function promotion_member_search(promotion_name){
		var no  = $("#write_no").val();
		addFormDialogSel('./download_member?no='+no, '1200px', '750', ' 회원 검색 ');
	}

	function addFormDialogSel(url, width, height, title, btn_yn) {
		newcreateElementContainer(title);
		newrefreshTable(url);
		$('#dlg').dialog({
			bgiframe: true,
			autoOpen: false,
			width: width,
			height: height,
			resizable: false,
			draggable: false,
			modal: true,		
			buttons: [				
				{
					text:"선택된 회원 적용",
					class: 'resp_btn active size_XL',
					click: function() {
						var str = "";
						var tag = "";
						var oldstr = $("#target_container").html();
						var target_member = $("#target_member").val();
						var checkedId = "input:checkbox[name$='member_chk[]']:checked";
						var idx = ($(checkedId).length);//현재회원수
						var addnum = 0;
						if(idx > 0) {

							var downloadtotal = $("#downloadtotal").val();////현재 발급건수
							var download_limit_ea = $("#download_limit_ea").val();//누적건수
							var member_search_count = parseInt($("#member_search_count").html());//총선택회원수
							var download_limit = $("#download_limit").val();//수량제한구분
							if(download_limit == 'limit'){
									var downloadtotal1 = parseInt(parseInt(downloadtotal)+parseInt(idx));
									var downloadtotal2 = parseInt(parseInt(downloadtotal1)+parseInt(member_search_count));
								if(idx > download_limit_ea ){
									alert("이 할인 코드의 전체수량제한 누적건수("+download_limit_ea+")보다 현재 선택회원("+idx+")이 많습니다!");
									return false;
								}else if(downloadtotal1 > download_limit_ea ){
									alert("이 할인 코드의 전체수량제한 누적건수("+download_limit_ea+")보다 총 발급건수와 현재 선택회원의 합계("+downloadtotal1+")가 많습니다!");
									return false;
								}else if(downloadtotal2 > download_limit_ea ){
									alert("이 할인 코드의 전체수량제한 누적건수("+download_limit_ea+")보다 총 발급건수와 총 선택회원의 합계("+downloadtotal2+")가 많습니다!");
									return false;
								}
							}

							$(checkedId).each(function(e, data) {
								if( memberselectck($(this).val()) == false ) {addnum++;
									str += $(this).attr("user_name")+'[' + $(this).attr("userid") + '] , ';
									tag += '['+$(this).val()+'],';
								}
							});
						}

						if(str){
							var msg = oldstr + " " + str;
							$("#target_container").html(msg);
							$("#target_member").val(target_member + tag)
							var newcheckedId = $("#target_member").val().split(',');
							$("#member_search_count").html((newcheckedId.length-1));
						}
						$(this).dialog('close');
					}
				},
				{
					text:"검색된 회원 적용",
					class: 'resp_btn active size_XL',
					click: function() {
						var queryString = $('#downloadsearch').formSerialize();
						$.ajax({
							type: 'post',
							url: '/admin/promotion_process/download_member_search_all',
							data: queryString,
							dataType: 'json',
							success: function(data) {
								var checkedId = "input:checkbox[name$='member_chk[]']:checked";
								var oldstr = $("#target_container").html();
								var target_member = $("#target_member").val();
								var addnum = 0;
								var str = "";
								var tag = "";

								var downloadtotal = $("#downloadtotal").val();////현재 발급건수
								var download_limit_ea = $("#download_limit_ea").val();//누적건수
								var member_search_count = ($("#member_search_count").html());//총선택회원수
								var download_limit = $("#download_limit").val();//수량제한구분

								if(data.totalcnt>0) {
									for(i=0;i<data.totalcnt;i++) {
										var member_seq = data.searchallmember[i]['member_seq'];
										var userid = data.searchallmember[i]['userid'];
										var user_name = data.searchallmember[i]['user_name'];
										if( memberselectck(member_seq) == false ) {
											addnum++;
											str += user_name+'[' + userid + '] , ';
											tag += '['+member_seq+'],';
										}
									}
								}
								if(str){
									var msg = oldstr + " " + str;
									$("#target_container").html(msg);
									$("#target_member").val(target_member + tag)
									var newcheckedId = $("#target_member").val().split(',');
									$("#member_search_count").html((newcheckedId.length-1));
								}
							}
						});
						$(this).dialog('close');
					}
				
				},
				{
					text:"닫기",
					class : 'resp_btn v3 size_XL',
					click: function() {
						
						$(this).dialog('close');
					}
				}
			]
		}).dialog('open');
		return false;
	}

	function groupsMsg(){
		
		var str = "";
		var tag = "";
		$("#groupsMsg").html("");
		
		$("input[type='checkbox'][name='memberGroup']:checked").each(function(){
			var clone = $(this).parent().clone();
			clone.find("input").remove();
			str += $(this).attr("groupName") + ' , ';
			tag += "<input type='hidden' name='memberGroups[]' value='"+$(this).val()+"'>";
			
		});

		if(str){
			var msg = str.substr(0,str.length-3) + tag;
			$("#groupsMsg").html(msg);
		}
	}

	
	//할인 코드의 다운로드 등급설정시 추가
	function downloadmembergroup(newgroup) {
		var returns = false;
		var newcheckedId = "input[name$='download_memberGroups[]']";
		var newidx = ($(newcheckedId).length);
		if(newidx > 0) {
			$(newcheckedId).each(function(e, newdata) {
				if( parseInt(newgroup) == parseInt($(newdata).val()) ) {
					returns = true;
					return false;
				}
			});
		}else{
			returns = true;
		}
		return returns;
	}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar"  >
		<ul class="page-buttons-left">			
			<li>
				<button type="button" id="promotioncodeusebtn" class="resp_btn v3 size_L">
					할인 코드 
					<span class="point"><?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispromotioncode"]){?>사용<?php }else{?>사용 안 함<?php }?></span>
				</button>
			</li>
		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2><span class="darkgray">할인 코드</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
<?php if(serviceLimit('H_FR')){?>
			<li><button type="button" onclick="openDialog('쇼핑몰 업그레이드 안내<span class=\'desc\'></span>', 'nofreeService', {'width':600,'height':200});" title="무료몰 Plus+ 에서는 해당기능이 지원되지 않습니다." class="resp_btn v4 sizeL">할인 코드 등록</button></li>
<?php }else{?>			
			<li><button type="button" id="promotionRegist" class="resp_btn active2 size_L">할인 코드 등록</button></li>
<?php }?>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 게시물리스트검색폼 : 끝 -->
<div  id="promotioncodeuselay"  class="hide" >
	<div class="item-title">할인 코드</div>
	
	<table class="table_basic thl">		
		<tr>
			<th>사용 여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="promotioncode_use"  id="promotioncode_use1" value="Y" <?php if($TPL_VAR["isplusfreenot"]["ispromotioncode"]){?>checked<?php }?> /> 사용</label>
					<label><input type="radio" name="promotioncode_use"  id="promotioncode_use0" value="N" <?php if(!$TPL_VAR["isplusfreenot"]["ispromotioncode"]){?>checked<?php }?> /> 사용 안 함</label>				
				</div>					
			</td>
		</tr>								
	</table>

	<ul class="bullet_hyphen resp_message">
		<li>할인 코드 안내 <a href="https://www.firstmall.kr/customer/faq/1253" class="link_blue_01" target="_blank">자세히 보기</a></li>
		<li>할인 코드 ‘사용 안 함‘ 선택 시, 쇼핑몰의 주문/결제 페이지에서 할인 코드 사용 기능이 노출되지 않습니다. </li>
	</ul>

	<div class="footer">
		<input type="button" id="promotionusesave" class="resp_btn active size_XL" onclick="$('#promotioncodeuselay').dialog('close');" value="적용" />		
		<input type="button" class="resp_btn v3 size_XL" onclick="$('#promotioncodeuselay').dialog('close');" value="취소" />
	</div>	
</div>

<!-- 리스트검색폼 : 시작 -->
<div id="search_container" class="search_container">
	<form name="promotionsearch" id="promotionsearch" >
	<input type="hidden" name="id" value="<?php echo $TPL_VAR["sc"]["id"]?>" >
	<input type="hidden" name="perpage" id="perpage" value="<?php echo $TPL_VAR["sc"]["perpage"]?>" >
	<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["sc"]["page"]?>" >
	<input type="hidden" name="orderby" id="orderby" value="<?php echo $TPL_VAR["sc"]["orderby"]?>" >
	<table class="table_search">
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_keyword" class="hide"></label> 할인 코드명</th>
			<td>
				<input type="text" name="search_text" id="search_text" value="<?php echo htmlspecialchars($TPL_VAR["sc"]["search_text"])?>" size="80" />
			</td>
		</tr>
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_promotion_type" class="hide"> 혜택 구분</label></th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="promotionType"  value="all"  <?php if(!$TPL_VAR["sc"]["promotionType"]||$TPL_VAR["sc"]["promotionType"]=='all'){?> checked <?php }?> /> 전체</label>
					<label><input type="radio" name="promotionType"  value="promotion"  <?php if($TPL_VAR["sc"]["promotionType"]=='promotion'){?> checked <?php }?> /> 상품</label>
					<label><input type="radio" name="promotionType"  value="promotion_shipping"  <?php if($TPL_VAR["sc"]["promotionType"]=='promotion_shipping'){?> checked <?php }?>/> 배송비</label>
				</div>
			</td>
		</tr>
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_promotion_type2" class="hide"> 코드 유형</label></th>
			<td>								
				<div class="resp_radio">
					<label><input type="radio" name="promotionType2" value="all"  <?php if(!$TPL_VAR["sc"]["promotionType2"]||$TPL_VAR["sc"]["promotionType2"]=='all'){?> checked <?php }?>/> 전체</label>
					<label><input type="radio" name="promotionType2" value="public"  <?php if($TPL_VAR["sc"]["promotionType2"]=='public'){?> checked <?php }?>/> 공용 코드</label>
					<label><input type="radio" name="promotionType2" value="disposable" <?php if($TPL_VAR["sc"]["promotionType2"]=='disposable'){?> checked <?php }?> /> 1회용 코드</label>
				</div>
			</td>
		</tr>
		<tr>
			<th><label><input type="checkbox" name="search_form_editor[]" value="sc_regist_date" class="hide"> 등록일</label></th>
			<td>
				<div class="date_range_form">
					<input type="text" name="sdate" id="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10" />
					-
					<input type="text" name="edate" id="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10" />
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
	</table>

	<div class="search_btn_lay center mt10 footer"></div>
</form>
</div>
<div class="cboth"></div>
<!-- 게시물리스트검색폼 : 끝 -->

<div class="contents_container">
	<div class="list_info_container">
		<div class="dvs_left">
			<div class="left-btns-txt">검색 <b><?php echo number_format($TPL_VAR["sc"]["searchcount"])?></b> 개 (총 <b><?php echo number_format($TPL_VAR["sc"]["totalcount"])?></b> 개)</div>
		</div>
		<div class="dvs_right"><div class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></div></div>
	</div>
	
	<table class="table_row_basic">
		<colgroup>
			<col width="5%" />
			<col width="6%" />
			<col width="8%" />
			<col width="17%" />
			<col width="9%" />
			<col width="13%" />
			<col width="9%" />
			<col width="12%" />
			<col width="9%" />
			<col width="9%" />
			<col width="13%" />
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>혜택 구분</th>			
			<th>코드 유형</th>
			<th>할인 코드명</th>
			<th>코드 정보</th>
			<th>혜택</th>
			<th>유효기간</th>
			<th>내역</th>
			<th>등록일</th>
			<th>관리</th>
			<th>삭제</th>
		</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["record"]){?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
				<tr>
					<td><?php echo $TPL_V1["_no"]?></td>
					<td><?php echo $TPL_V1["issuetypetitle"]?></td>
					<td><?php echo $TPL_V1["issueimgalt"]?></td>
					<td class="left">
						<a href="../promotion/regist?no=<?php echo $TPL_V1["promotion_seq"]?>" class="resp_btn_txt v2"><?php echo $TPL_V1["promotion_name"]?></a>							
					</td>
					<td><?php if(strstr($TPL_V1["type"],'promotion')){?><?php echo $TPL_V1["promotion_input_serialnumber"]?><?php }else{?>개별 코드<?php }?></td>
					<td><?php echo $TPL_V1["salepricetitle"]?></td>
					<td><?php echo $TPL_V1["issuedate"]?></td>
					<td>
						발급 <?php echo $TPL_V1["downloadtotal"]?>건 / 사용 <?php echo $TPL_V1["usetotal"]?>건<br>
						<input type="button" class="downloadlist_btn resp_btn v2" promotion_seq="<?php echo $TPL_V1["promotion_seq"]?>" promotion_name="<?php echo $TPL_V1["promotion_name"]?>" value="조회"/>
						<?php echo $TPL_V1["issuebtn"]?>

					</td>
					<td><?php echo $TPL_V1["date"]?></td>
					<td><input type="button" name="modifypromotion_btn" promotion_seq="<?php echo $TPL_V1["promotion_seq"]?>" class="resp_btn v2"  value="수정" /></td>
					<td>						
<?php if($TPL_V1["downloadtotal"]< 1){?>
						<input type="button" name="deletepromotion_btn" promotion_seq="<?php echo $TPL_V1["promotion_seq"]?>" class="resp_btn v3" value="삭제" />
<?php }?>
					</td>
				</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td colspan="11">
<?php if($TPL_VAR["search_text"]){?>
						'<?php echo $TPL_VAR["search_text"]?>' 검색된 할인 코드가 없습니다.
<?php }else{?>
						등록된 할인 코드가 없습니다.
<?php }?>
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>
</div>

<!-- 서브 레이아웃 영역 : 끝 -->

<!-- 페이징 -->
<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>
<!-- 페이징 : 끝 -->

<div id="lay_promotion_issued"></div><!-- Popup :: 쿠폰 발급하기 -->



<?php $this->print_("layout_footer",$TPL_SCP,1);?>