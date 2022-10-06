<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/coupon/catalog.html 000008000 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/plugin/validate/jquery.validate.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js" charset="euc-kr"></script>
<script type="text/javascript" src="/app/javascript/js/admin/couponComm.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/couponList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gCouponIssued.js?mm=<?php echo date('Ymd')?>"></script>
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
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>할인 쿠폰</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button type="button" id="onlineRegist" class="resp_btn active size_L onlineRegist">쿠폰 등록</button></li>
		</ul>

		<!-- 좌측 버튼 -->
		<div class="page-buttons-left"><button name="coupon_popup" class="coupon_popup resp_btn v3 size_L">쿠폰별 팝업</button></div>		
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<!-- 리스트검색폼 : 시작 -->
<?php $this->print_("searchForm",$TPL_SCP,1);?>

<!-- 리스트검색폼 : 끝 -->

<div class="contents_dvs v2">
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
			<col width="11%" />
			<col width="14%" />
			<col width="12%" />
			<col width="10%" />
			<col width="10%" />
			<col width="7%" />
			<col width="8%" />
			<col width="10%" />
			<col width="6%" />			
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
				<th>삭제</th>
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
					<input type="button" class="coupongoodsreviewbtn resp_btn mt5" coupon_type="<?php if($TPL_V1["type"]=='offline_coupon'){?>offline<?php }else{?>online<?php }?>" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>"  use_type="<?php echo $TPL_V1["use_type"]?>"  issue_type="<?php echo $TPL_V1["issue_type"]?>"   coupon_name="<?php echo $TPL_V1["coupon_name"]?>" value="보기" />
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
					
					<div class="mt5">
						<input type="button" class="downloadlist_btn resp_btn v2" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>" coupon_name="<?php echo $TPL_V1["coupon_name"]?>" value="조회" />
<?php if($TPL_V1["directbtn"]){?><?php echo $TPL_V1["directbtn"]?><?php }?>
					</div>
				</td>
				<td><?php echo $TPL_V1["issue_stop_title"]?></td>
				<td><?php echo $TPL_V1["date"]?></td>
				<td nowrap="nowrap" >										
					<input type="button" name="modify<?php echo $TPL_V1["issueimg"]?>_btn" class="cpmodifybtn resp_btn v2" coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>" value="수정" modifytype="regist" />					
<?php if(!(strstr($TPL_V1["type"],'offline'))){?>
						<input type="button" name="copy<?php echo $TPL_V1["issueimg"]?>_btn" class="cpcopybtn resp_btn v2"  coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>"  value="복사" />
<?php }?>
				</td>
				<td nowrap="nowrap" >
<?php if($TPL_V1["downloadtotal"]< 1){?>
					<input type="button" name="delete<?php echo $TPL_V1["issueimg"]?>_btn" class="<?php if($TPL_V1["type"]=='offline_emoney'||$TPL_V1["type"]=='offline_coupon'){?>off_<?php }?>cpdeletebtn resp_btn v3"  coupon_seq="<?php echo $TPL_V1["coupon_seq"]?>"  value="삭제" />
<?php }?>
				</td>
			</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td colspan="11">
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

<div id="couponcopyPopup" class="hide">
	<form name="CouponCopy" id="CouponCopy" method="post" action="../coupon_process/coupon_copy"  target="actionFrame">
	<div class="item-title" style="padding-top:0px;">쿠폰 복사</div>
	<table class="table_basic thl">
		<tbody>
			<tr>
				<th>쿠폰명</th>
				<td><input type="text" name="coupon_name" id="coupon_name" class="resp_text" size="50" value=""  /></td>
			</tr>
			<tr>
				<th>쿠폰설명</th>
				<td><input type="text" name="coupon_desc" id="coupon_desc" class="resp_text" size="50" value="" /></td>
			</tr>
			<tr>
				<th>쿠폰복사</th>
				<td>
					<select name="copy_coupon_seq" id="copy_coupon_seq" >
<?php if($TPL_VAR["record"]){?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["coupon_seq"]?>" ><?php echo $TPL_V1["coupon_name"]?></option>
<?php }}?>
<?php }?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	
	<div class="footer">
		<input type="button" value="복사" id="couponcopybtn" name="couponcopybtn" class="resp_btn active size_XL" />
		<input type="button" value="취소" name="cpClosebtn" class="cpClosebtn resp_btn v3 size_XL" />
	</div>
	</form>
</div>


<div id="lay_coupon_issued"></div><!-- Popup :: 쿠폰 발급하기 -->

<?php $this->print_("coupongoodslayer",$TPL_SCP,1);?>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>