<?php /* Template_ 2.2.6 2022/05/17 12:28:57 /www/music_brother_firstmall_kr/selleradmin/skin/default/coupon/catalog.html 000005265 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="euc-kr"></script>
<script type="text/javascript" src="/app/javascript/js/admin/couponComm.js?mm=2020060201"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=2020060315"></script>
<script type="text/javascript" src="/app/javascript/js/admin/couponList.js?mm=20200601"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gCouponIssued.js?mm=20200601"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var _search_options = function(){
			return {
				'pageid':$("form[name='couponsearch'] input[name='pageid']").val(),
				'search_mode':$("form[name='couponsearch'] input[name='pageid']").attr('data-search_mode'),
				'defaultPage':$("form[name='couponsearch'] input[name='page']").attr('data-defaultPage'),
				'select_date':$("form[name='couponsearch'] input[name='pageid']").attr('data-select_date'),
				'sc':<?php echo $TPL_VAR["scObj"]?>

		};
		}

		gSearchForm.init(_search_options());
	});
</script>
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar"  >
		<!-- 타이틀 -->
		<div class="page-title">
			<h2><span class="darkgray">할인 쿠폰</h2>
		</div>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<!-- 리스트검색폼 : 시작 -->
<?php $this->print_("searchForm",$TPL_SCP,1);?>

<!-- 리스트검색폼 : 끝 -->

<div class="contents_container">
	<div class="list_info_container">
		<div class="dvs_left">
			<div class="left-btns-txt">검색 <b><?php echo number_format($TPL_VAR["sc"]["searchcount"])?></b> 개 (총 <b><?php echo number_format($TPL_VAR["sc"]["totalcount"])?></b> 개)</div>
		</div>
		<div class="dvs_right"><div class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></div></div>
	</div>

	<table class="table_row_basic tdc">
		<colgroup>
			<col width="5%" />
			<col width="7%" />
			<col width="8%" />
			<col width="16%" />
			<col width="12%" />
			<col width="10%" />
			<col width="11%" />
			<col width="7%" />
			<col width="8%" />
			<col width="10%" />
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>혜택 구분</th>
			<th>쿠폰 유형</th>
			<th>쿠폰명</th>
			<th>혜택</th>
			<th>유효기간</th>
			<th>내역</th>
			<th>발급상태</th>
			<th>등록일</th>
			<th>관리</th>
		</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["record"]){?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
		<tr  <?php if($TPL_V1["issue_stop"]== 1){?>class="stop-tr-background"<?php }?> >
		<td><?php echo $TPL_V1["_no"]?></td>
		<td><?php echo $TPL_V1["coupon_category_name"]?></td>
		<td><?php echo $TPL_V1["coupon_type"]?></td>
		<td class="left">
			<a href="../coupon/regist?no=<?php echo $TPL_V1["coupon_seq"]?>" class="resp_btn_txt v2"><?php echo $TPL_V1["coupon_name"]?></a>
		</td>
		<td>
			<?php echo $TPL_V1["salepricetitle"]?>

<?php if($TPL_V1["type"]!='offline_emoney'){?><br>
			<input type="button" class="coupongoodsreviewbtn resp_btn" coupon_type="<?php if($TPL_V1["type"]=='offline_coupon'){?>offline<?php }else{?>online<?php }?>" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>"  use_type="<?php echo $TPL_V1["use_type"]?>"  issue_type="<?php echo $TPL_V1["issue_type"]?>"   coupon_name="<?php echo $TPL_V1["coupon_name"]?>" value="보기" />
<?php }?>
		</td>
		<td><?php echo $TPL_V1["issuedate"]?></td>
		<td>
<?php if($TPL_V1["type"]=='offline_emoney'){?>
			인증 <?php echo $TPL_V1["downloadtotal"]?>건 / -
<?php }elseif($TPL_V1["type"]=='offline_coupon'){?>
			인증 <?php echo $TPL_V1["downloadtotal"]?>건 / 사용 <?php echo $TPL_V1["usetotal"]?>

<?php }else{?>
			발급 <?php echo $TPL_V1["downloadtotal"]?>건 / 사용 <?php echo $TPL_V1["usetotal"]?>

<?php }?>
		</td>
		<td><?php echo $TPL_V1["issue_stop_title"]?></td>
		<td><?php echo $TPL_V1["date"]?></td>


		<td nowrap="nowrap" >
			<input type="button" name="modify<?php echo $TPL_V1["issueimg"]?>_btn" class="cpmodifybtn resp_btn v2" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>" value="상세" modifytype="regist" />
		</td>
		</tr>
<?php }}?>
<?php }else{?>
		<tr>
			<td colspan="10">
<?php if($TPL_VAR["search_text"]){?>
				'<?php echo $TPL_VAR["search_text"]?>' 검색된 쿠폰이 없습니다.
<?php }else{?>
				등록된 쿠폰이 없습니다.
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

<?php $this->print_("coupongoodslayer",$TPL_SCP,1);?>



<?php $this->print_("layout_footer",$TPL_SCP,1);?>