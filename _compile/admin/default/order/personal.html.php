<?php /* Template_ 2.2.6 2022/05/17 12:36:40 /www/music_brother_firstmall_kr/admin/skin/default/order/personal.html 000014206 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<!-- 2021.12.30 11월 3차 패치 by 김혜진 -->
<div id="orderAdminSettle" class="hide"></div>
<div id="issueGoodsSelect" class="hide"></div>
<div id="optional_changes_dialog" class="hide"></div>
<script type="text/javascript">
	var search_type				= "<?php echo $TPL_VAR["sc"]["search_type"]?>";

	/* default search */
	var default_search_pageid	= "personal";
	var default_obj_width		= 750;
	var default_obj_height		= 200;

	var gf_deliveryCode			= "<?php echo $TPL_VAR["gf_config"]["gf_deliveryCode"]?>";

	$(document).ready(function() {
		$(".all-check").toggle(function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',true);
		},function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',false);
		});

		$("span.list-important").bind("click",function(){
			var param = "?no="+$(this).attr('id');
			if( $(this).hasClass('checked') ){
				$(this).removeClass('checked');
				param += "&val=0";
				$.get('important'+param,function(data) {});

			}else{
				$(this).addClass('checked');
				param += "&val=1";
				$.get('important'+param,function(data) {});
			}
		});

		$("select.list-select").bind("change",function(){
			var nm = $(this).attr("name");
			var value_str = $(this).val();
			var that = this;

			$("select[name='"+nm+"']").not(this).each(function(idx){
				$(this).find("option[value='"+value_str+"']").attr("selected",true);
				this.selectedIndex = that.selectedIndex;
				$(this).customSelectBox("selectIndex",that.selectedIndex);
			});

			var step = nm.replace('select_', "");
			var obj = $(".important-"+step);
			obj.each(function(){
				if( value_str ){
					$(this).parent().parent().find("td").eq(0).find("input").attr("checked",false);
					if(  value_str == 'important' && $(this).hasClass('checked') ){
						$(this).parent().parent().find("td").eq(0).find("input").attr("checked",true);
					}else if( value_str == 'not-important' && !$(this).hasClass('checked') ){
						$(this).parent().parent().find("td").eq(0).find("input").attr("checked",true);
					}else if(  value_str == 'select' ){
						$(this).parent().parent().find("td").eq(0).find("input").attr("checked",true);
					}
				}
			});
		});


		// 체크박스 색상
		$("input[type='checkbox'][name='order_seq[]']").live('change',function(){
			if($(this).is(':checked')){
				$(this).closest('tr').addClass('checked-tr-background');
			}else{
				$(this).closest('tr').removeClass('checked-tr-background');
			}
		}).change();

	});

	function person_view(displayId,inputGoods,person_seq,member_seq){
		$.ajax({
			type: "get",
			url: "../order/person_view",
			data: "page=1&inputGoods="+inputGoods+"&displayId="+displayId+"&person_seq="+person_seq+"&member_seq="+member_seq,
			success: function(result){
				$("div#"+displayId).html(result);
			}
		});
		openDialog("개인 결제 보기", displayId, {"width":"1000","height":"700","show" : "fade","hide" : "fade"});
	}


	function set_date(target, start,end){
		var starget  =  target + '_sdate';
		var etarget  =  target + '_edate';
		$("input[name='" + starget + "[]']").val(start);
		$("input[name='" + etarget + "[]']").val(end);
	}



	function personal_order_del(){
		var f = document.listFrm;;
		f.action = "personal_del";
		f.submit();
	}
</script>
<!-- 2022.01.04 11월 4차 패치 by 김혜진 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchForm.js?v=<?php echo date('Ymd')?>"></script>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/searchform.css" />
<style>
	.goods_name {display:inline-block;white-space:nowrap;overflow:hidden;width:100%;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	.search_label 	{display:inline-block;width:80px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	span.step_title { font-weight:normal;padding:0 5px 0 5px; }
	span.export-list { display:inline-block;background-url("/admin/skin/default/images/common/btn_list_release.gif");width:60px;height:15px; }
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>개인결제리스트</h2>
		</div>

		<!-- 우측 버튼 -->
		<!--ul class="page-buttons-right">
			<li><span class="btn large"><button name="order_admin_settle">관리자가 주문 넣기<span class="arrowright"></span></button></span></li>
			<li><span class="btn large"><button name="download_list">다운로드항목설정<span class="arrowright"></span></button></span></li>
		</ul-->

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 주문리스트 검색폼 : 시작 -->
<div class="search-form-container">
	<form name="search-form" method="get">
		<input type="hidden" name="regist_date_type" value="<?php echo $TPL_VAR["sc"]["regist_date_type"]?>" />

		<table class="table_search">
			<tr>
				<th>검색어</th>
				<td>
					<input type="text" name="keyword" size="100" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" title="주문자, 아이디, 이메일, 휴대폰, 주문번호, 상품명" />
</div>
</td>
</tr>
</table>

<table class="search-form-table" id="search_detail_table">
	<tr>
		<td>
			<table class="sf-option-table table_search">
				<col width="60"><col >
				<tr>
					<th>등록일</th>
					<td>
						<input type="text" name="regist_sdate" value="<?php echo $TPL_VAR["sc"]["regist_sdate"]?>" class="datepicker"  maxlength="10" style="width:80px" default_none />
						&nbsp;<span class="gray">-</span>&nbsp;
						<input type="text" name="regist_edate" value="<?php echo $TPL_VAR["sc"]["regist_edate"]?>" class="datepicker" maxlength="10" style="width:80px"  default_none />
						<span class="resp_btn_wrap">
								<span class="btn small"><input type="button" id="today" value="오늘" class="select_date resp_btn" settarget="regist" /></span>
								<span class="btn small"><input type="button" id="3day" value="3일간" class="select_date resp_btn" settarget="regist"/></span>
								<span class="btn small"><input type="button" id="1week" value="일주일" class="select_date resp_btn" settarget="regist"/></span>
								<span class="btn small"><input type="button" id="1month" value="1개월" class="select_date resp_btn" settarget="regist"/></span>
								<span class="btn small"><input type="button" id="3month" value="3개월" class="select_date resp_btn" settarget="regist"/></span>
								<span class="btn small"><input type="button" id="all"  value="전체" class="select_date resp_btn" settarget="regist" row_bunch/></span>
							</span>
					</td>
				</tr>
				<tr>
					<th>유효기간</th>
					<td>
						<input type="text" name="expiry_sdate" value="<?php echo $TPL_VAR["sc"]["expiry_sdate"]?>" class="datepicker"  maxlength="10" style="width:80px" default_none />
						&nbsp;<span class="gray">-</span>&nbsp;
						<input type="text" name="expiry_edate" value="<?php echo $TPL_VAR["sc"]["expiry_edate"]?>" class="datepicker" maxlength="10" style="width:80px"  default_none />
						<span class="resp_btn_wrap">
								<span class="btn small"><input type="button" id="today" value="오늘" class="select_date resp_btn" settarget="expiry" /></span>
								<span class="btn small"><input type="button" id="3day" value="3일간" class="select_date resp_btn" settarget="expiry" /></span>
								<span class="btn small"><input type="button" id="1week" value="일주일" class="select_date resp_btn" settarget="expiry" /></span>
								<span class="btn small"><input type="button" id="1month" value="1개월" class="select_date resp_btn" settarget="expiry" /></span>
								<span class="btn small"><input type="button" id="3month" value="3개월" class="select_date resp_btn" settarget="expiry" /></span>
								<span class="btn small"><input type="button" id="all"  value="전체" class="select_date resp_btn" settarget="expiry" row_bunch/></span>
							</span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<div class="footer search_btn_lay">
	<div>
			<span class="sc_edit">
				<button type="button" id="set_default_setting_button" class="resp_btn v3">기본검색설정</button>
				<button type="button" id="set_default_apply_button" onclick="set_search_form('personal')" class="resp_btn v3">기본검색적용</button>
			</span>
		<span class="search">
				<button type="submit" class="resp_btn active size_XL"><span>검색</span></button>
				<button type="button" id="search_reset_button" class="resp_btn v3 size_XL">초기화</button>
			</span>
	</div>
</div>
</form>
</div>
<!-- 주문리스트 검색폼 : 끝 -->

<!-- 주문리스트 테이블 : 시작 -->
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="40" />
		<col width="40" />
		<col width="60" />
		<col width="88" />
		<col width="88" />
		<col />
		<col width="250" />
		<col width="170" />
		<col width="120" />
		<col width="150" />
		<col width="60" />
	</colgroup>
	<thead class="lth">
	<tr>
		<th>선택</th>
		<th>중요</th>
		<th>번호</th>
		<th>등록일시</th>
		<th>유효기간</th>
		<th>개인결제 타이틀</th>
		<th>상품</th>
		<th>주문자</th>
		<th>개인결제가</th>
		<th>주문번호</th>
		<th>관리</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->
	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
	<form name="listFrm" id="listFrm" method="post" target="actionFrame">
<?php if(!$TPL_VAR["record"]){?>
		<tr class="list-row">
			<td colspan="10" align="center">검색어가 없거나 검색 결과가 없습니다.</td>
		</tr>
<?php }else{?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>

		<tr class="list-row step<?php echo $TPL_V1["step"]?>">
			<td align="center"><input type="checkbox" name="person_seq[]" value="<?php echo $TPL_V1["person_seq"]?>" /></td>
			<td align="center">
<?php if($TPL_V1["important"]){?>
				<span class="icon-star-gray hand checked list-important important-<?php echo $TPL_V1["step"]?>" id="important_<?php echo $TPL_V1["person_seq"]?>"></span>
<?php }else{?>
				<span class="icon-star-gray hand list-important important-<?php echo $TPL_V1["step"]?>" id="important_<?php echo $TPL_V1["person_seq"]?>"></span>
<?php }?>
			</td>
			<td align="center"><?php echo $TPL_V1["no"]?></td>
			<td align="center"><?php echo substr($TPL_V1["regist_date"], 2, - 3)?></td>
			<td align="center"><?php echo substr($TPL_V1["expiry_date"], 2, - 3)?></td>
			<td align="left" style="padding-left:10px">
				<?php echo $TPL_V1["title"]?>

			</td>
			<td align="left">
<?php if($TPL_V1["item_cnt"]< 2){?>
				<div class="goods_name"><?php echo $TPL_V1["goods_name"]?></div>
<?php }else{?>
				<div class="goods_name"><?php echo $TPL_V1["goods_name"]?> 외 <?php echo $TPL_V1["item_cnt"]- 1?>건</div>
<?php }?>
			</td>
			<td class="hand" onclick="open_crm_summary(this,'<?php echo $TPL_V1["member_seq"]?>','<?php echo $TPL_V1["order_seq"]?>','right');">
<?php if($TPL_V1["member_seq"]){?>
				<div>
<?php if($TPL_V1["member_type"]=='개인'){?><img src="/admin/skin/default/images/common/icon/icon_personal.gif" />
<?php }elseif($TPL_V1["member_type"]=='기업'){?><img src="/admin/skin/default/images/common/icon/icon_besiness.gif" /><?php }?>
					<?php echo $TPL_V1["order_user_name"]?>

<?php if($TPL_V1["mbinfo_rute"]=='facebook'){?>
					(<span style="color:#d13b00;"><img src="/admin/skin/default/images/board/icon/sns_f0.gif" align="absmiddle"><?php echo $TPL_V1["mbinfo_email"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span>)
<?php }else{?>
					(<span style="color:#d13b00;"><?php echo $TPL_V1["userid"]?></span>/<span class="blue"><?php echo $TPL_V1["group_name"]?></span></a>)
<?php }?>
				</div>
<?php }else{?>
				<img src="/admin/skin/default/images/common/icon/icon_personal.gif" /> <?php echo $TPL_V1["order_user_name"]?> (<span class="desc">비회원</span>)
<?php }?>
			</td>

			<td align="right"><b><?php echo get_currency_price($TPL_V1["total_price"]-$TPL_V1["enuri"], 3)?></b></td>
			<td align="center"><a href="/admin/order/view?no=<?php echo $TPL_V1["order_seq"]?>"><?php echo $TPL_V1["order_seq"]?></a></td>
			<td align="center"><span class="btn small"><button type="button" onclick='person_view("orderAdminSettle","issueGoods", "<?php echo $TPL_V1["person_seq"]?>", "<?php echo $TPL_V1["member_seq"]?>");'>상세</button></span></td>
		</tr>
		<!--<tr><td colspan="12" style="padding-top:3px;"></td></tr>-->
		<tr class="order-list-summary-row hide">
			<td colspan="10" class="order-list-summary-row-td"><div class="order_info"></div></td>
		</tr>
		<!-- 리스트데이터 : 끝 -->
<?php if($TPL_V1["end"]){?>
		<!-- 합계 : 시작 -->
		<tr class="list-end-row">
			<td colspan="11" class="list-end-row-td">
				<ul class="left-btns clearbox" style="margin-top:2px">
					<li>
						<select class="list-select custom-select-box-multi" name="select_<?php echo $TPL_V1["step"]?>"  rows="4">
							<option value="select">전체선택</option>
							<option value="not-select">선택안함</option>
						</select>
					</li>
					<li>
						<span class="btn small"><button type="button" name="goods_del" onclick="personal_order_del()">삭제</button></span>
					</li>
				</ul>
			</td>
		</tr>
		<!-- 합계 : 끝 -->
<?php }?>
<?php }}?>
<?php }?>
	</form>
	</tbody>
	<!-- 리스트 : 끝 -->
</table>
<!-- 주문리스트 테이블 : 끝 -->
</form>
</div>

<!-- 기본검색설정 -->
<script type="text/javascript" src="/app/javascript/js/admin-searchDefaultConfig.js"></script>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>