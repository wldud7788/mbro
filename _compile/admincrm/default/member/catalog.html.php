<?php /* Template_ 2.2.6 2022/05/17 12:05:24 /www/music_brother_firstmall_kr/admincrm/skin/default/member/catalog.html 000015064 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
	$(document).ready(function() {
		/*
		$("input[name='keyword']").keydown(function(e){
			if(e.keyCode == 13) {
				divSearchMember();
				return false;
			}
		});
		*/

	// 상단 회원 검색어 레이어 박스 : start
		$("#body_crm_search_keyword").keyup(function (e) {
			if ($(this).val()) {
				$('.body_txt_keyword').text($(this).val());
				crmBodySearchLayerOpen();
			}else{
				$('.body_searchLayer').hide();
			}
		});

		$("#body_crm_search_keyword").focus(function () {
			if ($(this).val() && $(this).val()!=$(this).attr('title')) {
				$('.body_txt_keyword').text($(this).val());
				crmBodySearchLayerOpen();
			}
			$('.header_txt_order_keyword').html("");
			$('.header_order_search_type_text').hide();
			$("#crm_order_search_keyword").val("");
		});

		$("a.body_member_link_keyword").click(function () {
			var sType = $(this).attr('s_type');
			$('#body_search_type').val(sType);
			$('.body_searchLayer').hide();
			setBodyMemberSearchTxt(sType);
		});

		var offset = $("#body_crm_search_keyword").offset();
		$('.body_member_search_type_text').css({
			'position' : 'absolute',
			'z-index' : 999,
			'left' : "50%",
			'margin-left' : '-198px',
			'top' : "41px",
			'line-height' : '29px',
			'width':$("#body_crm_search_keyword").width()-1,
			'height':$("#body_crm_search_keyword").height()-4
		});

		$(".body_member_search_type_text").click(function () {
			$(".body_member_search_type_text").hide();
			$("#body_crm_search_keyword").focus();
		});

		$(".body_searchLayer ul li").hover(function() {
			$(".body_searchLayer ul li").removeClass('hoverli');
			$(this).addClass('hoverli');
		});

		$("#body_crm_search_keyword").keydown(function (e) {
			var searchbox = $(this);

			switch (e.keyCode) {
				case 40:
					if($('.bodyMemberSearchUl').find('li.hoverli').length == 0){
						$('.bodyMemberSearchUl').find('li:first-child').addClass('hoverli');
					}else{
						if($('.bodyMemberSearchUl').find('li:last-child').hasClass("hoverli") ){
							$('.bodyMemberSearchUl').find('li::last-child.hoverli').removeClass('hoverli');
							$('.bodyMemberSearchUl').find('li:first-child').addClass('hoverli');
						}else{
							$('.bodyMemberSearchUl').find('li:not(:last-child).hoverli').removeClass('hoverli').next().addClass('hoverli');
						}
					}
					break;
				case 38:
					if($('.bodyMemberSearchUl').find('li.hoverli').length == 0){
						$('.bodyMemberSearchUl').find('li:last-child').addClass('hoverli');
					}else{
						if($('.bodyMemberSearchUl').find('li:first-child').hasClass("hoverli")){
							$('.bodyMemberSearchUl').find('li::first-child.hoverli').removeClass('hoverli');
							$('.bodyMemberSearchUl').find('li:last-child').addClass('hoverli');
						}else{
							 $('.bodyMemberSearchUl').find('li:not(:first-child).hoverli').removeClass('hoverli').prev().addClass('hoverli');
						}
					}
					break;
				case 13 :
					var index=0;
					 $('.bodyMemberSearchUl').find('li').each(function(){
						if($(this).hasClass("hoverli")){
							index=$(this).index();
						}
					});

					$('.bodyMemberSearchUl').find('li>a').eq(index).click();
					//$('.body_searchLayer').hide();
					$("#body_crm_search_keyword").blur();
					divSearchMember();
					e.keyCode = null;
					return false;
					break;
			}
		});
		// 상단 회원 검색어 레이어 박스 : end

<?php if($_GET["body_search_type"]){?>
			setBodyMemberSearchTxt('<?php echo $_GET["body_search_type"]?>');
<?php }?>

	});

	function setBodyMemberSearchTxt(sType) {
		var search_type_array = new Array();
		search_type_array['all'] = "";
		search_type_array['user_name'] = "이름 찾기";
		search_type_array['userid'] = "아이디 찾기";
		search_type_array['phone'] = "전화번호 찾기";
		search_type_array['cellphone'] = "휴대폰 찾기";
		search_type_array['email'] = "이메일 찾기";
		$('.body_member_search_type_text').html(search_type_array[sType]+ " : " + $("#body_crm_search_keyword").val()).show();
		$("input[name='body_crm_search_keyword']").blur();

	}

	function crmBodySearchLayerOpen() {
		var offset = $("#body_crm_search_keyword_div").offset();
		if( offset) {
			$('.body_searchLayer').css({
				'position' : 'absolute',
				'z-index' : 999,
				'left' : '1',
				'top' : '10px;',
				//'width':$("#header_search_keyword").width()+32
				'width':$("#body_crm_search_keyword_div").width()-19
			}).show();
		}
	}

	function searchPaging(query_string){
		$.ajax({
			type: "get",
			url: "../member/catalog",
			data: "body_crm_search_keyword=<?php echo $_GET["body_crm_search_keyword"]?>"+query_string,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			success: function(result){
				$("#memberSearchDiv").html(result);
				apply_input_style();
			}
		});
	}

	function divSearchMember(){
		var body_crm_search_keyword = $("input[name='body_crm_search_keyword']").val();
		var body_search_type = $("input[name='body_search_type']").val();
		var searchcount = $("input[name='searchcount']").val();
		$.ajax({
			type: "get",
			url: "../member/catalog",
			data: {"body_crm_search_keyword":body_crm_search_keyword,"body_search_type":body_search_type,"searchcount":searchcount},
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			success: function(result){
				$("#memberSearchDiv").html(result);
				apply_input_style();
			}
		});
	}
</script>
<style type="text/css">
	div.search-form-container table.sf-keyword-table .sfk-td-txt .form_tit {width:50px; height:29px; line-height:30px; background:#696B77; text-align:center; color:#fff;}
	.body_member_search_type_text {background-color:#fff; line-height:22px; text-align:center; overflow:hidden; white-space:nowrap}
	.body_searchLayer {margin:29px 0 0 49px; width:448px !important; border:1px solid #797d86;background-color:#fff; padding:5px 0;word-break:break-all;}
	.body_searchLayer .body_txt_title {color:#999;font-size:11px;}
	.body_searchLayer .body_txt_keyword {color:#ff6633;}
	.body_searchLayer ul li {padding:2px 0 2px 5px;}
	.body_searchLayer .hoverli {background-color:#f5f5f5;}
</style>

<div class="search-form-container">
	<table class="search-form-table">
	<tr>
		<td>
			<table>
			<tr>
				<td width="500">
					<table class="sf-keyword-table">
					<tr>
						<td class="sfk-td-txt">
							<div id="body_crm_search_keyword_div" class="hs-box">
								<span class="fl form_tit">회원</span>
								<input type="text" id="body_crm_search_keyword" name="body_crm_search_keyword" class="fl" value="<?php echo $_GET["body_crm_search_keyword"]?>" title="이름, 아이디, 이메일, 전화번호, 핸드폰(뒷자리4), 주소, 닉네임" />
							</div>
							<div class="body_member_search_type_text hide"><?php echo $_GET["body_search_type"]?></div>
							<div class="body_searchLayer hide">
								<input type="hidden" name="body_search_type" id="body_search_type" value="<?php echo $_GET["body_search_type"]?>" />
								<input type="hidden" name="searchcount" id="searchcount" value="<?php echo $TPL_VAR["sc"]["searchcount"]?>" />
								<ul class="bodyMemberSearchUl">
									<li><a class="body_member_link_keyword" s_type="all" href="#"><span class="body_txt_keyword"></span> <span class="body_txt_title">- 회원 전체검색</span></a></li>
									<li><a class="body_member_link_keyword" s_type="user_name" href="#">이름 : <span class="body_txt_keyword"></span> <span class="body_txt_title">- 이름 찾기</span></a></li>
									<li><a class="body_member_link_keyword" s_type="userid" href="#">아이디 : <span class="body_txt_keyword"></span> <span class="body_txt_title">- 아이디 찾기</span></a></li>
									<li><a class="body_member_link_keyword" s_type="phone" href="#">전화번호 : <span class="body_txt_keyword"></span> <span class="body_txt_title">- 전화번호 찾기</span></a></li>
									<li><a class="body_member_link_keyword" s_type="cellphone" href="#">휴대폰 : <span class="body_txt_keyword"></span> <span class="body_txt_title">- 휴대폰 찾기</span></a></li>
									<li><a class="body_member_link_keyword" s_type="email" href="#">이메일 : <span class="body_txt_keyword"></span> <span class="body_txt_title">- 이메일 찾기</span></a></li>
								</ul>
							</div>
							<!-- 검색어 입력시 레이어 박스 : end -->
							<script type="text/javascript">
							$("#headMemberForm").blur(function(){
								$(".body_member_search_type_text").show();

								setTimeout(function(){
									$('.body_searchLayer').hide()}, 500
								);
							});
							</script>
						</td>
						<td class="sfk-td-btn"><button type="button" onclick="divSearchMember();"><span>검색</span></button></td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>
<div class="clearbox">
	<ul class="left-btns clearbox">
		<li><div style="margin-top:rpx;">검색 <b><?php echo number_format($TPL_VAR["sc"]["searchcount"])?></b> 개 / 총 <b><?php echo number_format($TPL_VAR["sc"]["totalcount"])?></b> 개</div></li>
	</ul>
</div>

<!-- 주문리스트 테이블 : 시작 -->
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="3%" /><!-- 번호 -->
		<col width="4%" /><!-- 승인 -->
		<col width="4%" /><!-- 등급 -->
		<col width="5%" /><!-- 유형 -->
		<col width="20%"/><!-- 아이디 -->
		<col width="10%"/><!-- 이름 -->
		<col width="15%" /><!-- 이메일 -->
		<col width="8%" /><!-- 전화번호 -->
		<col width="11%" /><!-- 가입일 -->
		<col width="5%" /><!-- 관리 -->
	</colgroup>
	<thead class="lth">
	<tr>
		<th>번호</th>
		<th>상태</th>
		<th>등급</th>
		<th>유형</th>
		<th>아이디</th>
		<th>이름(닉네임)</th>
		<th>이메일</th>
		<th>핸드폰</th>
		<th>전화번호</th>
		<th>CRM</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb otb" >
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
<?php if($TPL_V1["status_nm"]!='휴면'){?>
		<tr class="list-row">
			<td class="ctd"><?php echo $TPL_V1["number"]?></td>
			<td class="ltd"><?php echo $TPL_V1["status_nm"]?></td>
			<td class="ltd"><?php echo $TPL_V1["group_name"]?></td>
			<td class="ltd">
<?php if($TPL_V1["type"]=='개인'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" />
<?php }elseif($TPL_V1["type"]=='기업'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" /><?php }?>
					<?php echo $TPL_V1["type"]?>

			</td>
			<td class="ltd">
<?php if($TPL_V1["snslist"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["snslist"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["rute"]){?>
				<img src="/admincrm/skin/default/images/sns/sns_<?php echo substr($TPL_V2["rute"], 0, 1)?>0.gif" align="absmiddle">
<?php }?>
<?php }}?>
<?php }?>
<?php if(($TPL_V1["rute"]&&$TPL_V1["rute"]=='none')||$TPL_V1["sns_change"]== 1){?>
				<span class="blue"><?php echo $TPL_V1["userid"]?></span><?php if($TPL_V1["mall_t_check"]=='Y'){?><span style="position:relation;padding:0px 5px 0px 5px;margin-left:7px;color:#FFBB00;border:1px solid;">TEST</span><?php }?>
<?php }?>
<?php if(($TPL_V1["rute"]&&$TPL_V1["rute"]=='naver')&&$TPL_V1["sns_change"]!= 1){?>
				<span class="blue"><?php echo $TPL_V1["conv_sns_n"]?></span><?php if($TPL_V1["mall_t_check"]=='Y'){?><span style="position:relation;padding:0px 5px 0px 5px;margin-left:7px;color:#FFBB00;border:1px solid;">TEST</span><?php }?>
<?php }?>
			</td>
			<td class="ltd">
				<?php echo $TPL_V1["user_name"]?><?php if($TPL_V1["nickname"]){?>(<?php echo $TPL_V1["nickname"]?>)<?php }?>
<?php if($TPL_V1["blacklist"]){?>
				<img src="/admin/skin/default/images/common/ico_blacklist_<?php echo $TPL_V1["blacklist"]?>.png" align="absmiddle" alt="블랙리스트_<?php echo $TPL_V1["blacklist"]?>" />
<?php }else{?>
				<img src="/admin/skin/default/images/common/ico_angel.png" align="absmiddle" alt="엔젤회원" />
<?php }?>
			</td>

			<td class="ltd">
<?php if($TPL_V1["email"]){?>
				<span class="blue hand" <?php if($TPL_VAR["pageType"]!="search"){?>onclick="select_email('<?php echo $TPL_V1["member_seq"]?>');"<?php }?>><?php echo $TPL_V1["email"]?></span>
				(<?php echo strtoupper($TPL_V1["mailing"])?>)
<?php }?>
			</td>
			<td class="ctd">
<?php if($TPL_V1["bcellphone"]||$TPL_V1["cellphone"]){?>
				<span class="blue hand" <?php if($TPL_VAR["pageType"]!="search"){?>onclick="select_sms('<?php echo $TPL_V1["member_seq"]?>');"<?php }?>><?php if($TPL_V1["bcellphone"]){?><?php echo $TPL_V1["bcellphone"]?><?php }else{?><?php echo $TPL_V1["cellphone"]?><?php }?></span>
				(<?php echo strtoupper($TPL_V1["sms"])?>)
<?php }?>
			</td>
			<td class="ctd"><?php echo $TPL_V1["phone"]?></td>
			<td class="ctd hand" onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','','left');">
				<span class="btn small cyanblue">
					<input type="button" name="manager_modify_btn" value="CRM" />
				</span>
			</td>
		</tr>
<?php }else{?>
		<tr class="list-row">
			<td class="ctd"><?php echo $TPL_V1["number"]?></td>
			<td class="ctd">-</td>
			<td class="ctd">-</td>
			<td class="ctd">-</td>
			<td class="ltd" >
				<span class='red' style="font-weight:bold;">(휴면)</span>
				<?php echo $TPL_V1["userid"]?>

			</td>
			<td class="ctd">-</td>
			<td class="ctd">-</td>
			<td class="ctd">-</td>
			<td class="ctd">-</td>
			<td class="ctd hand" onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','','left');">
				<span class="btn small cyanblue">
					<input type="button" name="manager_modify_btn" value="CRM" member_seq="<?php echo $TPL_V1["member_seq"]?>" class="memberDetialBtn" memberDetialWay="left"/>
				</span>
			</td>
		</tr>
<?php }?>
		<!-- 리스트데이터 : 끝 -->
<?php }}?>
<?php }else{?>
		<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
		<tr class="list-row">
			<td align="center" colspan="10">
<?php if($TPL_VAR["search_text"]){?>
					'<?php echo $TPL_VAR["search_text"]?>' 검색된 회원이 없습니다.
<?php }else{?>
					등록된 회원이 없습니다.
<?php }?>
			</td>
		</tr>
		<!-- 리스트데이터 : 끝 -->
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->

</table>
<!-- 주문리스트 테이블 : 끝 -->
<div style="height:10px;"></div>
<!-- 페이징 -->
<div class="paging_navigation" style="margin:auto;"><?php echo $TPL_VAR["pagin"]?></div>