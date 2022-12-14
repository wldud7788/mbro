<?php /* Template_ 2.2.6 2022/05/17 12:31:04 /www/music_brother_firstmall_kr/admin/skin/default/coupon/download.html 000012189 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="utf8"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery_pagination/jquery.pager.js" charset="utf8"></script>
<script type="text/javascript" src="/app/javascript/js/admin/couponComm.js?mm=2020060811111"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=20200601"></script>
<script type="text/javascript">

	var search_opitons = {
		'pageid':'coupon_download',
		'search_mode':'<?php echo $TPL_VAR["sc"]["searchmode"]?>',
		'defaultPage':0,
		'divSelectLayId':'search_container_download',
		'searchFormId':'downloadsearch',
		'form_editor_use':false,
		'select_date':'all',
	};

	$(function(){

		gSearchForm.init(search_opitons,getDownAjaxList);

		//setDatepicker();

		$('#checkboxAll').click(function() {
			checkAll(this, '.checkeds');
			$("input[type='checkbox'][name='del[]']").trigger('change');
		});

		// 삭제
		$(".downloaddelete_btn").click(function() {
			var delseq = '';
			$('.checkeds').each(function(e, el) {
				if( $(el).attr('checked') == 'checked' ){
					delseq += $(el).val() + ",";
				}
			});
			if(!delseq){
				alert('삭제할 발급 쿠폰을 선택해 주세요.');
				return false;
			}
			openDialogConfirm('회원에게 발급된 쿠폰을<br>운영자의 권한으로 삭제하시겠습니까?',400,175,function(){
				$.ajax({
					'url' : '../coupon_process/download_delete',
					'data' : {'delseqar':delseq},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){
						if(res.result){
							$("input[name='checkboxAll']").prop("checked",false);
							openDialogAlert(res.msg,400,175,function(){getDownAjaxList();});
						}else{
							openDialogAlert(res.msg,400,175,function(){getDownAjaxList();});
						}
					}
				});
			},function(){});
		});

		// 미사용 쿠폰 전체 삭제
		$(".alldownloaddelete_btn").click(function() {
			var coupon_seq = '<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>';
			openDialogConfirm('미사용 쿠폰을 운영자의 권한으로 삭제하시겠습니까?',400,155,function(){
				$.ajax({
					'url' : '../coupon_process/download_all_delete',
					'data' : {'coupon_seq' : coupon_seq},
					'type' : 'post',
					'dataType': 'json',
					'success' : function(res){
						if(res.result){
							openDialogAlert(res.msg,400,175,function(){getDownAjaxList();});
						}else{
							openDialogAlert(res.msg,400,175,function(){getDownAjaxList();});
						}
					}
				});
			},function(){});
		});

		//체크박스 색상
		$("input[type='checkbox'][name='del[]']").on('change',function(){
			if($(this).is(':checked')){
				$(this).closest('tr').addClass('bg-gray');
			}else{
				$(this).closest('tr').removeClass('bg-gray');
			}
		}).change();


		getDownAjaxList();

	});

	var coupon_info = {
		title : '쿠폰정보',
		open : function(obj,option){
			var coupon_type		= $(obj).attr("coupon_type");
			var use_type		= $(obj).attr("use_type");
			var download_seq	= $(obj).attr("download_seq");
			var coupon_seq		= $(obj).attr("coupon_seq");
			var url				= '../coupon/coupongoodsreviewer';
			var width			= 450;
			if( use_type == 'offline' ) width			= 650;
			openDialogPopup(this.title,"onlinecoupontypePopupNew",{
				'width'			:width,
				'url'			:url,
				'data'			:{
					'no'			: download_seq,
					'coupon_type'	: coupon_type,
					'coupon_seq'	: coupon_seq,
					'download_seq'	: download_seq
				}
			});
		}
	}

	/**
	 * 체크박스 전체 선택
	 * @param string el 전체 선택 체크박스
	 * @param string targetEl 적용될 체크박스 클래스명
	 */
	function checkAll(el, targetEl) {
		if( $(el).attr('rel') == 'yes' ) {
			var do_check = false;
			$(el).attr('rel', 'no');
		} else {
			var do_check = true;
			$(el).attr('rel', 'yes');
		}
		$(targetEl).each(function(e, el) {
			if( $(el).attr('disabled') != 'disabled' ){//제외
				$(el).prop('checked', do_check).change();
			}
		});
	}

	function orderinfo(order_seq) {
		var href = "/admin/order/view?no="+order_seq;
		var a = window.open(href, 'orderdetail'+order_seq, '');
		if ( a ) {
			a.focus();
		}
	}

	function goodsinfo(goods_seq) {
		var href = "/admin/goods/regist?no="+goods_seq;
		var a = window.open(href, 'goodsdetail'+goods_seq, '');
		if ( a ) {
			a.focus();
		}
	}

	function userinfo(mseq){
		var href = "/admin/member/detail?member_seq="+mseq;
		var a = window.open(href, 'mbdetail'+mseq, '');
		if ( a ) {
			a.focus();
		}
	}


	/**
	 * 상품을 ajax로 검색한다.
	 * @param int page 페이지번호
	 */
	function getDownAjaxList(page) {

		var pageNumber = page ? page : 1;
		$("#getpage").val(pageNumber);
		var queryString = $('#downloadsearch').formSerialize();
		var perpage = 10;
		$.ajax({
			type: 'post',
			url: '/admin/coupon/downloadlist',
			data: queryString + '&perpage=' + perpage,
			dataType: 'json',
			success: function(data) {
				if(data) {
					$('#ajaxTable').html(data.content);
					$('#totalsaleprcie').html(setComma(data.totalsaleprcie));
					$('#searchcount').html(setComma(data.searchcount));
					$('#totalcount').html(setComma(data.totalcount));
					$('#nowpage').html(setComma(data.nowpage));
					$('#total_page').html(setComma(data.total_page));
					$("#pager").pager({ pagenumber: data.page, pagecount: data.pagecount, buttonClickCallback: pageClick });
				}
			}
		});
	}

	/**
	 * 페이징 클릭시 페이지를 로딩한다.
	 * @param int page 페이지번호
	 */
	function pageClick(page) {
		$("#getpage").val(page);
		getDownAjaxList(page);
	}

</script>
<!-- 서브 레이아웃 영역 : 시작 -->

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area" >
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>할인 쿠폰 발급/사용 내역</h2>
		</div>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 리스트검색폼 : 시작 -->
<div id="search_container_download" class="search_container">
	<form name="downloadsearch" id="downloadsearch" >
		<input type="hidden" name="no" 		value="<?php echo $TPL_VAR["coupons"]["coupon_seq"]?>" cannotBeReset=1 >
		<input type="hidden" name="page" 	id="getpage" value="<?php echo $TPL_VAR["sc"]["page"]?>" >
		<input type="hidden" name="orderby" id="orderby" value="<?php echo $TPL_VAR["sc"]["orderby"]?>" cannotBeReset=1 >
		<table class="table_search">
			<tr>
				<th>쿠폰명</th>
				<td><?php echo $TPL_VAR["coupons"]["coupon_name"]?></td>
			</tr>
			<tr>
				<th>검색어</th>
				<td>
					<select name="search_field" class="search_select">
						<option value="" <?php if($TPL_VAR["sc"]["search_field"]==''){?>selected<?php }?>>전체</option>
						<option value="m.userid" <?php if($TPL_VAR["sc"]["search_field"]=='m.userid'){?>selected<?php }?>>아이디</option>
						<option value="m.user_name" <?php if($TPL_VAR["sc"]["search_field"]=='m.user_name'){?>selected<?php }?>>이름</option>
					</select>
					<input type="text" name="search_text" id="download_search_text" value="<?php echo $TPL_VAR["sc"]["search_text"]?>" title="아이디, 이름" size="80" />	</td>
			</tr>
			<tr>
				<th>발급일</th>
				<td>
					<div class="date_range_form">
						<input type="text" name="sdate" id="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10" />
						-
						<input type="text" name="edate" id="edate"  value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10"/>

						<div class="resp_btn_wrap">
							<input type="button" range="today" value="오늘" class="select_date resp_btn" />
							<input type="button" range="3day" value="3일간" class="select_date resp_btn" />
							<input type="button" range="1week" value="일주일" class="select_date resp_btn" />
							<input type="button" range="1month" value="1개월" class="select_date resp_btn" />
							<input type="button" range="3month" value="3개월" class="select_date resp_btn" />
							<input type="button" range="all"  value="전체" class="select_date resp_btn"/>
							<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden" />
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<th>사용 여부</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="use_status" value="all" <?php if(!$TPL_VAR["sc"]["use_status"]||$TPL_VAR["sc"]["use_status"]=='all'){?> checked="checked" <?php }?>/> 전체</label>
						<label><input type="radio" name="use_status" value="used" <?php if($TPL_VAR["sc"]["use_status"]=='used'){?> checked="checked" <?php }?>/> 사용</label>
						<label><input type="radio" name="use_status" value="unused" <?php if($TPL_VAR["sc"]["use_status"]=='unused'){?> checked="checked" <?php }?>/> 미사용</label>
						<label><input type="radio" name="use_status" value="expire" <?php if($TPL_VAR["sc"]["use_status"]=='expire'){?> checked="checked" <?php }?>/> 유효기간 만료</label>
					</div>
				</td>
			</tr>
		</table>

		<div class="footer search_btn_lay"></div>

	</form>
	</table>
</div>
<div class="cboth"></div>
<!-- 리스트검색폼 : 끝 -->

<div class="contents_container">
	<div class="list_info_container">
		<div class="dvs_left">
			검색 <span id="searchcount" class="bold"><?php echo $TPL_VAR["sc"]["searchcount"]?></span>개 (총 <span id="totalcount" class="bold"><?php echo $TPL_VAR["sc"]["totalcount"]?></span>개)
		</div>
		<div class="dvs_right">
			총 할인금액 : <span id="totalsaleprcie" class=""></span>원
		</div>
	</div>

	<div class="table_row_frame">
		<div class="dvs_top">
			<div class="dvs_left">
				<button type="button" class="downloaddelete_btn resp_btn v3">선택 삭제</button>
			</div>
			<div class="dvs_right">
				<button type="button" class="alldownloaddelete_btn resp_btn v2">미사용 쿠폰 전체 삭제</button>
			</div>
		</div>

		<table class="table_row_basic">
			<colgroup>
<?php if($TPL_VAR["coupons"]["use_type"]=='online'){?>
				<col width="5%" />
				<col width="6%" />
				<col width="10%" />
				<col width="10%" />
				<col width="6%" />
				<col width="10%" />
				<col width="9%" />
				<col width="9%" />
				<col width="11%" />
				<col width="12%" />
				<col width="12%" />
<?php }else{?>
				<col width="5%" />
				<col width="5%" />
				<col width="10%" />
				<col width="10%" />
				<col width="12%" />
				<col width="12%" />
				<col width="10%" />
				<col width="10%" />
				<col width="13%" />
				<col width="13%" />
<?php }?>
			</colgroup>
			<thead>
			<tr>
				<th><label class="resp_checkbox"><input type="checkbox" name="checkboxAll" value="" id="checkboxAll" /></label></th>
				<th>번호</th>
				<th>아이디</th>
				<th>이름</th>
				<th>혜택</th>
				<th>유효기간</th>
				<th>사용여부</th>
<?php if($TPL_VAR["coupons"]["use_type"]=='online'){?><th>할인금액</th><?php }?>
				<th><?php echo $TPL_VAR["coupons"]["downloaddatetitle"]?></th>
				<th>주문번호</th>
				<th>구매상품</th>
			</tr>
			</thead>
			<tbody id="ajaxTable"></tbody>
		</table>

		<div class="dvs_bottom">
			<div class="dvs_left">
				<button type="button" class="downloaddelete_btn resp_btn v3">선택 삭제</button>
			</div>
			<div class="dvs_right">
				<button type="button" class="alldownloaddelete_btn resp_btn v2">미사용 쿠폰 전체 삭제</button>
			</div>
		</div>

	</div>
	<!-- 서브 레이아웃 영역 : 끝 -->

	<!-- 페이징 -->
	<div id="pager"></div>
	<div id="onlinecoupontypePopupNew" class="hide"></div>
</div>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>